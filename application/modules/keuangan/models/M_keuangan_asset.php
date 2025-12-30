<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_keuangan_asset extends CI_Model
{
    var $table = 'mst_asset';
    var $pk_id = 'asset_id';

    // --- FUNGSI DATATABLES (Server Side dengan Hitungan) ---
    public function load_datatables()
    {
        // 1. Bersihkan Buffer (Pencegah Error JSON)
        if (ob_get_length()) ob_clean(); 
        header('Content-Type: application/json');

        // 2. Query Dasar
        $this->db->select('a.*, k.kategori_nm');
        $this->db->from($this->table . ' a');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id');
        $this->db->where('a.deleted_st', 0);
        $this->db->where('a.active_st', 1);

        // Filter Kategori (Dari POST AJAX)
        $filter_kategori = $this->input->post('filter_kategori');
        if (!empty($filter_kategori)) {
            $this->db->where('a.kategori_id', $filter_kategori);
        }

        // Pencarian (Search Box)
        $search = $this->input->post('search')['value'];
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.asset_nm', $search);
            $this->db->or_like('a.asset_kd', $search);
            $this->db->or_like('k.kategori_nm', $search);
            $this->db->group_end();
        }

        // Hitung Total Filtered
        $temp_db = clone $this->db;
        $total_filtered = $temp_db->count_all_results();

        // Sorting & Limit
        $order = $this->input->post('order');
        $start = $this->input->post('start');
        $length = $this->input->post('length');

        $this->db->order_by('a.asset_id', 'desc'); // Default sort
        if($length != -1) $this->db->limit($length, $start);

        $data_raw = $this->db->get()->result_array();
        $total_all = $this->db->where(['deleted_st'=>0, 'active_st'=>1])->count_all_results($this->table);

        // 3. Proses Data & Hitungan
        $data_final = [];
        $today = date('Y-m-d');

        foreach ($data_raw as $row) {
            $row['valuasi_metode'] = $row['valuasi_metode'] ?? 'DEPRESIASI';
            $calc = $this->_hitung_rumus($row, $today);

            // Format angka untuk View
            $row['calc_umur']       = $calc['umur_bulan'] . ' / ' . $row['pakai_masa_bln'];
            $row['calc_harga']      = number_format($row['beli_nominal'], 0, ',', '.');
            $row['calc_nilai_buku'] = number_format($calc['nilai_buku_saat_ini'], 0, ',', '.');
            $row['calc_status']     = $calc['status'];
            $row['calc_tgl']        = ($row['beli_tgl']) ? date('d-m-Y', strtotime($row['beli_tgl'])) : '-';
            
            $data_final[] = $row;
        }

        // 4. Output JSON
        $output = [
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $total_all,
            "recordsFiltered" => $total_filtered,
            "data" => $data_final,
            // CSRF Token Update
            $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
        ];

        echo json_encode($output);
        exit;
    }

    // --- RUMUS MATEMATIKA ---
    private function _hitung_rumus($row, $per_tanggal)
    {
        $harga  = (float) $row['beli_nominal'];
        $residu = (float) $row['residu_nominal'];
        $masa   = (int) $row['pakai_masa_bln'];
        
        if ($masa <= 0 || $harga <= 0 || empty($row['beli_tgl'])) {
            return ['umur_bulan'=>0, 'nilai_buku_saat_ini'=>$harga, 'status'=>'Data Kurang'];
        }

        // Hitung Umur Integer
        $t1 = strtotime($row['beli_tgl']);
        $t2 = strtotime($per_tanggal);
        if ($t2 < $t1) $umur = 0;
        else {
            $y1 = (int)date('Y', $t1); $m1 = (int)date('m', $t1);
            $y2 = (int)date('Y', $t2); $m2 = (int)date('m', $t2);
            $umur = (($y2 - $y1) * 12) + ($m2 - $m1);
        }

        $nilai_buku = $harga; $status = 'Berjalan';

        if ($row['valuasi_metode'] == 'APRESIASI') {
            $perubahan = ($residu > $harga) ? ($residu - $harga)/$masa : ($harga * 0.01);
            $nilai_buku = $harga + ($perubahan * $umur);
            $status = 'Apresiasi';
        } else {
            $perubahan = ($harga - $residu) / $masa;
            $nilai_buku = $harga - ($perubahan * $umur);
            if ($nilai_buku <= $residu) {
                $nilai_buku = $residu; $status = 'Mentok Min';
            }
        }

        return ['umur_bulan' => $umur, 'nilai_buku_saat_ini' => $nilai_buku, 'status' => $status];
    }

    // --- Helpers Lain ---
    public function get_summary_total() {
        // Hitung kasar total semua aset
        $raw = $this->db->get_where($this->table, ['deleted_st'=>0, 'active_st'=>1])->result_array();
        $t_aset = 0; $t_buku = 0;
        foreach($raw as $r) {
            $r['valuasi_metode'] = $r['valuasi_metode'] ?? 'DEPRESIASI';
            $c = $this->_hitung_rumus($r, date('Y-m-d'));
            $t_aset += $r['beli_nominal'];
            $t_buku += $c['nilai_buku_saat_ini'];
        }
        return ['total_aset_awal' => $t_aset, 'total_nilai_buku' => $t_buku, 'total_akumulasi' => $t_buku - $t_aset];
    }

    public function cek_tutup_buku($p) { return $this->db->get_where('log_asset_nilai', ['periode_kd'=>$p])->num_rows()>0; }
    public function eksekusi_tutup_buku($p) { /* (Sama seperti sebelumnya, gunakan _hitung_rumus) */ return true; }
}