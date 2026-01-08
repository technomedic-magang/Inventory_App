<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
<<<<<<< HEAD
    // 1. STATISTIK UTAMA (Card Atas) - Tetap sama
    public function get_summary_stats()
    {
        $total_asset = $this->db->where('deleted_st', 0)->count_all_results('mst_asset');
        $asset_rusak = $this->db->where('deleted_st', 0)->where_in('asset_kondisi', ['RUSAK', 'PERBAIKAN'])->count_all_results('mst_asset');
        
        $total_jenis = $this->db->where('deleted_st', 0)->count_all_results('mst_persediaan');
        
=======
    // 1. STATISTIK UTAMA (Card Atas)
    public function get_summary_stats()
    {
        // Aset
        $total_asset = $this->db->where('deleted_st', 0)->count_all_results('mst_asset');
        $asset_rusak = $this->db->where('deleted_st', 0)
                                ->where_in('asset_kondisi', ['RUSAK', 'PERBAIKAN'])
                                ->count_all_results('mst_asset');
        
        // Persediaan
        $total_jenis = $this->db->where('deleted_st', 0)->count_all_results('mst_persediaan');
        
        // Stok Fisik
>>>>>>> repoB/main
        $q_stok = $this->db->select_sum('stok_qty')->where('deleted_st', 0)->get('mst_persediaan')->row();
        $total_fisik = $q_stok->stok_qty ?? 0;

        return [
<<<<<<< HEAD
            'total_asset' => $total_asset,
            'asset_trouble' => $asset_rusak,
            'total_persediaan' => $total_jenis,
            'stok_fisik' => $total_fisik
        ];
    }

    // 2. STOK MENIPIS
=======
            'total_asset'      => $total_asset,
            'asset_trouble'    => $asset_rusak,
            'total_persediaan' => $total_jenis,
            'stok_fisik'       => $total_fisik
        ];
    }

    // 2. STOK MENIPIS (Persediaan)
>>>>>>> repoB/main
    public function get_low_stock_persediaan($limit = 5)
    {
        $this->db->select('p.*, s.satuan_nm');
        $this->db->from('mst_persediaan p');
        $this->db->join('mst_satuan s', 'p.satuan_id = s.satuan_id', 'left');
        $this->db->where('p.deleted_st', 0);
        $this->db->where('p.stok_qty <=', 5); 
        $this->db->order_by('p.stok_qty', 'ASC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

<<<<<<< HEAD
    // 3. [BARU] RIWAYAT AKTIVITAS (TABEL GABUNGAN)
    public function get_riwayat_gabungan($limit = 10)
    {
        // Menggabungkan tabel Masuk dan Keluar
        $sql = "
        (SELECT 
            'MASUK' as tipe, 
            created_at, 
            struk_no as ref, 
            total_qty as qty, 
            keterangan_txt as info,
            created_by
         FROM dat_persediaan_masuk 
         WHERE deleted_st = 0)
        UNION ALL
        (SELECT 
            'KELUAR' as tipe, 
            created_at, 
            struk_no as ref, 
            total_qty as qty, 
            penerima_nm as info,
            created_by
         FROM dat_persediaan_keluar 
         WHERE deleted_st = 0)
        ORDER BY created_at DESC 
        LIMIT $limit
        ";
        
        $query = $this->db->query($sql);
        $result = $query->result_array();

        // Tambahkan Nama User yang menginput (Opsional, jika butuh join user)
        // Di sini kita return raw data dulu agar cepat
        return $result;
    }

    // 4. [BARU] BARANG PALING LARIS (FAST MOVING)
=======
    // 3. RIWAYAT AKTIVITAS (Gabungan Masuk & Keluar)
    public function get_riwayat_gabungan($limit = 10)
    {
        $sql = "
        (SELECT 'MASUK' as tipe, created_at, struk_no as ref, total_qty as qty, keterangan_txt as info
         FROM dat_persediaan_masuk WHERE deleted_st = 0)
        UNION ALL
        (SELECT 'KELUAR' as tipe, created_at, struk_no as ref, total_qty as qty, penerima_nm as info
         FROM dat_persediaan_keluar WHERE deleted_st = 0)
        ORDER BY created_at DESC LIMIT $limit
        ";
        return $this->db->query($sql)->result_array();
    }

    // 4. TOP BARANG KELUAR
>>>>>>> repoB/main
    public function get_top_barang_keluar($limit = 5)
    {
        $this->db->select('p.barang_nm, p.barang_kd, s.satuan_nm, SUM(d.keluar_qty) as total_keluar');
        $this->db->from('dat_persediaan_keluar_det d');
        $this->db->join('mst_persediaan p', 'd.persediaan_id = p.persediaan_id');
        $this->db->join('mst_satuan s', 'p.satuan_id = s.satuan_id', 'left');
        $this->db->join('dat_persediaan_keluar h', 'd.keluar_id = h.keluar_id');
        $this->db->where('h.deleted_st', 0);
<<<<<<< HEAD
        // Filter tahun ini agar relevan
=======
>>>>>>> repoB/main
        $this->db->where('YEAR(h.keluar_tgl)', date('Y'));
        $this->db->group_by('d.persediaan_id');
        $this->db->order_by('total_keluar', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

<<<<<<< HEAD
    // 5. [BARU] DATA CHART (TREN 6 BULAN TERAKHIR)
    public function get_monthly_chart()
    {
        // Logic sederhana: Ambil 6 bulan ke belakang
=======
    // 5. CHART DATA (6 Bulan Terakhir)
    public function get_monthly_chart()
    {
>>>>>>> repoB/main
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $month_label = date('M Y', strtotime("-$i months"));

<<<<<<< HEAD
            // Hitung Masuk
=======
            // Masuk
>>>>>>> repoB/main
            $this->db->select_sum('total_qty');
            $this->db->like('beli_tgl', $month);
            $this->db->where('deleted_st', 0);
            $in = $this->db->get('dat_persediaan_masuk')->row()->total_qty ?? 0;

<<<<<<< HEAD
            // Hitung Keluar
=======
            // Keluar
>>>>>>> repoB/main
            $this->db->select_sum('total_qty');
            $this->db->like('keluar_tgl', $month);
            $this->db->where('deleted_st', 0);
            $out = $this->db->get('dat_persediaan_keluar')->row()->total_qty ?? 0;

            $data['labels'][] = $month_label;
            $data['masuk'][] = (int)$in;
            $data['keluar'][] = (int)$out;
        }
        return $data;
    }
<<<<<<< HEAD
=======

    // 6. [BARU] REMINDER SERVICE (Bulan Ini)
    public function get_service_reminders()
    {
        $bulan_ini = date('Y-m'); 
        
        $this->db->select('s.tgl_berikutnya, s.kilometer_berikutnya, a.asset_nm, a.asset_kd');
        $this->db->from('dat_service s');
        $this->db->join('mst_asset a', 's.asset_id = a.asset_id');
        
        $this->db->where('s.deleted_st', 0);
        // Cari yang tgl_berikutnya mirip '2025-12-%'
        $this->db->like('s.tgl_berikutnya', $bulan_ini, 'after');
        $this->db->order_by('s.tgl_berikutnya', 'ASC');
        
        return $this->db->get()->result_array();
    }
>>>>>>> repoB/main
}