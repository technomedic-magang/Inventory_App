<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_riwayat_service extends CI_Model
{
    var $table = 'dat_service';
    var $pk_id = 'service_id';

    // ID Atribut (Sesuaikan dengan DB Anda)
    const ID_ATRIBUT_MERK = 128; 
    const ID_ATRIBUT_SPEK = 129; 

    public function load_datatables()
    {
        if (ob_get_length()) ob_clean(); 
        header('Content-Type: application/json');

        // 1. Select Data (Termasuk Merk & Spek)
        $this->db->select('
            s.*, 
            a.asset_nm, 
            a.asset_kd,
            v_merk.value_isi AS merk,          
            v_spek.value_isi AS spesifikasi,   
            k.kategori_nm,
            k.kategori_kd
        ');

        $this->db->from($this->table . ' s');
        $this->db->join('mst_asset a', 's.asset_id = a.asset_id', 'left');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id', 'left');

        // Join Merk & Spek (Left Join agar data tetap muncul meski kosong)
        $this->db->join('dat_asset_value v_merk', 'v_merk.asset_id = a.asset_id AND v_merk.atribut_id = ' . self::ID_ATRIBUT_MERK . ' AND v_merk.active_st = 1', 'left');
        $this->db->join('dat_asset_value v_spek', 'v_spek.asset_id = a.asset_id AND v_spek.atribut_id = ' . self::ID_ATRIBUT_SPEK . ' AND v_spek.active_st = 1', 'left');

        $this->db->where('s.deleted_st', 0);

        // [MODIFIKASI] Filter Kategori dari Halaman Utama
        $filter_kategori = $this->input->post('filter_kategori');
        if (!empty($filter_kategori)) {
            $this->db->where('a.kategori_id', $filter_kategori);
        }

        // Pencarian
        $search = $this->input->post('search')['value'];
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('s.bengkel_nm', $search);
            $this->db->or_like('s.keterangan_txt', $search);
            $this->db->or_like('a.asset_nm', $search);
            $this->db->or_like('v_merk.value_isi', $search);
            $this->db->or_like('v_spek.value_isi', $search);
            $this->db->group_end();
        }

        $this->db->order_by('s.tgl_service', 'DESC'); 
        
        // Paginasi
        $temp_db = clone $this->db;
        $total_filtered = $temp_db->count_all_results();
        
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        if($length != -1) $this->db->limit($length, $start);

        $data_raw = $this->db->get()->result_array();
        $total_all = $this->db->where('deleted_st', 0)->count_all_results($this->table);

        echo json_encode([
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $total_all,
            "recordsFiltered" => $total_filtered,
            "data" => $data_raw,
            $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
        ]);
        exit;
    }

    // --- FUNGSI PENDUKUNG (FORM MODAL STOCK) ---
    public function get_all_assets()
    {
        $this->db->select('a.asset_id, a.asset_nm, a.asset_kd, k.kategori_nm, k.kategori_kd, k.kategori_id');
        $this->db->from('mst_asset a');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id', 'left');
        $this->db->where('a.deleted_st', 0);
        $this->db->where('a.active_st', 1);
        $this->db->order_by('a.asset_nm', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_all_kategori()
    {
        return $this->db->where('deleted_st', 0)
                        ->order_by('kategori_nm', 'ASC')
                        ->get('mst_kategori')
                        ->result_array();
    }
}