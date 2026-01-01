<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_keuangan_asset extends CI_Model
{
    var $table = 'mst_asset';
    var $pk_id = 'asset_id';

    /**
     * Memuat data untuk DataTables (Server Side Processing).
     */
    public function load_datatables()
    {
        // Membersihkan buffer output untuk mencegah error JSON
        if (ob_get_length()) ob_clean(); 
        header('Content-Type: application/json');

        // Query Builder dasar
        $this->db->select('a.*, k.kategori_nm');
        $this->db->from($this->table . ' a');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id');
        $this->db->where('a.deleted_st', 0);
        $this->db->where('a.active_st', 1);

        // Filter berdasarkan Kategori
        $filter_kategori = $this->input->post('filter_kategori');
        if (!empty($filter_kategori)) {
            $this->db->where('a.kategori_id', $filter_kategori);
        }

        // Pencarian Global (Search Box)
        $search = $this->input->post('search')['value'];
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.asset_nm', $search);
            $this->db->or_like('a.asset_kd', $search);
            $this->db->or_like('k.kategori_nm', $search);
            $this->db->group_end();
        }

        // Hitung total data yang terfilter
        $temp_db = clone $this->db;
        $total_filtered = $temp_db->count_all_results();

        // Pengaturan Sorting dan Limit (Paginasi)
        $order = $this->input->post('order');
        $start = $this->input->post('start');
        $length = $this->input->post('length');

        $this->db->order_by('a.asset_id', 'desc'); // Default sort
        if($length != -1) $this->db->limit($length, $start);

        // Eksekusi query ambil data
        $data_raw = $this->db->get()->result_array();
        
        // Hitung total semua data tanpa filter
        $total_all = $this->db->where(['deleted_st'=>0, 'active_st'=>1])->count_all_results($this->table);

        // Proses data mentah (tambahkan perhitungan)
        $data_final = [];
        $today = date('Y-m-d');

        foreach ($data_raw as $row) {
            // Set default metode jika kosong
            $row['valuasi_metode'] = $row['valuasi_metode'] ?? 'DEPRESIASI';
            
            // Hitung nilai aset saat ini
            $calc = $this->_hitung_rumus($row, $today);

            // Format data untuk tampilan View
            $row['calc_umur']       = $calc['umur_bulan'] . ' / ' . $row['pakai_masa_bln'];
            $row['calc_harga']      = number_format($row['beli_nominal'], 0, ',', '.');
            $row['calc_nilai_buku'] = number_format($calc['nilai_buku_saat_ini'], 0, ',', '.');
            $row['calc_status']     = $calc['status'];
            $row['calc_tgl']        = ($row['beli_tgl']) ? date('d-m-Y', strtotime($row['beli_tgl'])) : '-';
            
            $data_final[] = $row;
        }

        // Susun output JSON untuk DataTables
        $output = [
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $total_all,
            "recordsFiltered" => $total_filtered,
            "data" => $data_final,
            // Update CSRF Token untuk keamanan
            $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
        ];

        echo json_encode($output);
        exit;
    }

    /**
     * Menghitung nilai penyusutan atau apresiasi aset secara privat.
     */
    private function _hitung_rumus($row, $per_tanggal)
    {
        $harga  = (float) $row['beli_nominal'];
        $residu = (float) $row['residu_nominal'];
        $masa   = (int) $row['pakai_masa_bln'];
        
        // Validasi data awal
        if ($masa <= 0 || $harga <= 0 || empty($row['beli_tgl'])) {
            return ['umur_bulan'=>0, 'nilai_buku_saat_ini'=>$harga, 'status'=>'Data Kurang'];
        }

        // Hitung umur aset dalam bulan
        $t1 = strtotime($row['beli_tgl']);
        $t2 = strtotime($per_tanggal);
        if ($t2 < $t1) $umur = 0;
        else {
            $y1 = (int)date('Y', $t1); $m1 = (int)date('m', $t1);
            $y2 = (int)date('Y', $t2); $m2 = (int)date('m', $t2);
            $umur = (($y2 - $y1) * 12) + ($m2 - $m1);
        }

        $nilai_buku = $harga; 
        $status = 'Berjalan';

        // Hitung berdasarkan metode valuasi
        if ($row['valuasi_metode'] == 'APRESIASI') {
            // Jika nilai aset naik
            $perubahan = ($residu > $harga) ? ($residu - $harga)/$masa : ($harga * 0.01);
            $nilai_buku = $harga + ($perubahan * $umur);
            $status = 'Apresiasi';
        } else {
            // Jika nilai aset turun (depresiasi)
            $perubahan = ($harga - $residu) / $masa;
            $nilai_buku = $harga - ($perubahan * $umur);
            
            // Cek batas residu minimum
            if ($nilai_buku <= $residu) {
                $nilai_buku = $residu; 
                $status = 'Mentok Min';
            }
        }

        return ['umur_bulan' => $umur, 'nilai_buku_saat_ini' => $nilai_buku, 'status' => $status];
    }

    /**
     * Menghitung ringkasan total aset untuk Dashboard.
     */
    public function get_summary_total() {
        $raw = $this->db->get_where($this->table, ['deleted_st'=>0, 'active_st'=>1])->result_array();
        $t_aset = 0; 
        $t_buku = 0;
        
        foreach($raw as $r) {
            $r['valuasi_metode'] = $r['valuasi_metode'] ?? 'DEPRESIASI';
            $c = $this->_hitung_rumus($r, date('Y-m-d'));
            
            $t_aset += $r['beli_nominal'];
            $t_buku += $c['nilai_buku_saat_ini'];
        }
        
        return [
            'total_aset_awal' => $t_aset, 
            'total_nilai_buku' => $t_buku, 
            'total_akumulasi' => $t_buku - $t_aset
        ];
    }

    // Cek apakah periode ini sudah ditutup bukunya
    public function cek_tutup_buku($p) { 
        return $this->db->get_where('log_asset_nilai', ['periode_kd'=>$p])->num_rows() > 0; 
    }
    
    // Eksekusi tutup buku (Placeholder)
    public function eksekusi_tutup_buku($p) { 
        // Logika simpan history tutup buku akan ditempatkan di sini
        return true; 
    }
}