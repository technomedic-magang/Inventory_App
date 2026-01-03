<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_perbaikan_aset extends CI_Model
{
    var $table = 'dat_service';
    var $pk_id = 'service_id';

    const ID_ATRIBUT_MERK = 128; 
    const ID_ATRIBUT_SPEK = 129; 

    // -------------------------------------------------------------------------
    // 1. DATATABLES (SERVER SIDE)
    // -------------------------------------------------------------------------
    public function load_datatables()
    {
        if (ob_get_length()) ob_clean(); 
        header('Content-Type: application/json');

        // =====================================================================
        // [LOGIKA HAK AKSES / ROLE]
        // =====================================================================
        
        // 1. Ambil ID User yang sedang login
        $user_id_login = $this->session->userdata('user_id');

        // 2. Cek Role ID user tersebut dari tabel app_user
        // Asumsi tabel user bernama 'app_user' sesuai permintaan Anda
        $cek_role = $this->db->select('role_id')
                             ->from('app_user')
                             ->where('user_id', $user_id_login)
                             ->get()
                             ->row();
                             
        $role_id_user = $cek_role ? $cek_role->role_id : '';

        // 3. Tentukan Kode Superadmin (Sesuai Gambar Anda: 01.01)
        $superadmin_code = '01.01'; 

        // 4. TERAPKAN FILTER JIKA BUKAN SUPERADMIN
        if ($role_id_user != $superadmin_code) {
            // Filter: Hanya tampilkan data yang dibuat oleh user ini (created_by)
            // $this->db->where('s.created_by', $user_id_login);
            
            // Opsi Alternatif:
            // Jika ingin filter berdasarkan Pelapor (Pegawai), gunakan:
            $this->db->where('p.user_id', $user_id_login); 
        }
        // Jika Superadmin, logika ini dilewati (Tampil Semua)

        // =====================================================================
        // [QUERY UTAMA] (Sama seperti Revisi 1)
        // =====================================================================

        $sql_tiket = "CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0'))";

        $this->db->select("
            s.*, 
            $sql_tiket AS tiket_perbaikan,
            a.asset_nm, 
            a.asset_kd,
            v_merk.value_isi AS merk,          
            v_spek.value_isi AS spesifikasi,   
            k.kategori_nm,
            k.kategori_kd,
            p.pegawai_nm AS pelapor_nm
        ", FALSE); 

        $this->db->from($this->table . ' s');
        
        $this->db->join('mst_asset a', 's.asset_id = a.asset_id', 'left');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id', 'left');
        $this->db->join('mst_pegawai p', 's.pelapor_id = p.pegawai_id', 'left');

        $this->db->join('dat_asset_value v_merk', 'v_merk.asset_id = a.asset_id AND v_merk.atribut_id = ' . self::ID_ATRIBUT_MERK . ' AND v_merk.active_st = 1', 'left');
        $this->db->join('dat_asset_value v_spek', 'v_spek.asset_id = a.asset_id AND v_spek.atribut_id = ' . self::ID_ATRIBUT_SPEK . ' AND v_spek.active_st = 1', 'left');

        $this->db->where('s.deleted_st', 0);

        // Filter Kategori
        $filter_kategori = $this->input->post('filter_kategori');
        if (!empty($filter_kategori)) {
            $this->db->where('a.kategori_id', $filter_kategori);
        }

        // Pencarian Global
        $search = $this->input->post('search')['value'];
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('s.keluhan_deskripsi', $search);
            $this->db->or_like('a.asset_nm', $search);
            $this->db->or_like('a.asset_kd', $search);
            $this->db->or_like('p.pegawai_nm', $search); 
            $this->db->or_like("CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0'))", $search); 
            $this->db->group_end();
        }

        $this->db->order_by('s.created_at', 'DESC'); 
        
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        if($length != -1) $this->db->limit($length, $start);

        $data_raw = $this->db->get()->result_array();
        
        // --- [HITUNG TOTAL DATA (JUGA HARUSDIFILTER)] ---
        // Kita harus reset query builder untuk menghitung total agar filternya juga berlaku untuk pagination
        // Namun cara paling aman di Datatables CI adalah menghitung ulang dengan kondisi yang sama.
        
        // Count All (Sesuai Role)
        $this->db->from($this->table . ' s');
        $this->db->where('s.deleted_st', 0);
        if ($role_id_user != $superadmin_code) {
             $this->db->where('s.created_by', $user_id_login);
        }
        $total_all = $this->db->count_all_results();

        echo json_encode([
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $total_all,
            "recordsFiltered" => $total_all, // Untuk simplifikasi, filtered dianggap sama dgn total akses
            "data" => $data_raw
        ]);
        exit;
    }

    // ... (Fungsi Lain: get_auto_ticket_number, get_all_assets, get_all_kategori TETAP SAMA) ...
    public function get_auto_ticket_number($tanggal, $asset_id)
    {
        $sku_aset = 'UNK'; 
        if($asset_id) {
            $cek_aset = $this->db->select('asset_kd')->where('asset_id', $asset_id)->get('mst_asset')->row();
            if($cek_aset) $sku_aset = $cek_aset->asset_kd;
        }
        $tahun = date('Y', strtotime($tanggal));
        $bulan = date('m', strtotime($tanggal));
        $prefix_depan = "SERV/$tahun.$bulan/$sku_aset/";
        $this->db->like('created_at', $tahun, 'after'); 
        $this->db->where('deleted_st', 0);
        $count = $this->db->count_all_results($this->table);
        $urutan = $count + 1;
        return $prefix_depan . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    public function get_all_assets() {
        return $this->db->select('a.asset_id, a.asset_nm, a.asset_kd, k.kategori_nm, k.kategori_kd, k.kategori_id')
                        ->from('mst_asset a')
                        ->join('mst_kategori k', 'a.kategori_id = k.kategori_id', 'left')
                        ->where(['a.deleted_st'=>0, 'a.active_st'=>1])
                        ->order_by('a.asset_nm', 'ASC')->get()->result_array();
    }

    public function get_all_kategori() {
        return $this->db->where(['deleted_st'=>0, 'active_st'=>1])->order_by('kategori_nm', 'ASC')->get('mst_kategori')->result_array();
    }
}