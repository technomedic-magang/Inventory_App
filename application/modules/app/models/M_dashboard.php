<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
    // --- [BAGIAN 1] Data Pegawai (Warisan Sistem Lama) ---
    function pegawai_get()
    {
        $sql = "SELECT a.* FROM mst_pegawai a WHERE a.pegawai_id = ?";
        $id = _ses_get('pegawai_id') ? _ses_get('pegawai_id') : _ses_get('user_id');
        return $this->db->query($sql, array($id))->row_array();
    }

    // --- [BAGIAN 2] Data Ringkasan Inventaris ---
    public function count_total_asset_types()
    {
        return $this->db->where(['deleted_st' => 0, 'active_st' => 1])->count_all_results('mst_asset');
    }

    public function sum_total_stok()
    {
        $query = $this->db->select_sum('stok_qty')->get('dat_stok');
        return (int) $query->row()->stok_qty;
    }

    public function sum_sedang_dipakai()
    {
        // Hitung barang yang masih berstatus dipakai (belum kembali)
        $this->db->select('SUM(pemakaian_qty - kembali_qty) as sisa_pakai');
        $this->db->where('pemakaian_qty > kembali_qty');
        $query = $this->db->get('trx_pemakaian_detail');
        return (int) $query->row()->sisa_pakai;
    }

    public function get_low_stock_items()
    {
        // Ambil 5 barang dengan stok di bawah minimal
        $sql = "SELECT a.asset_nm, a.asset_kd, a.stok_min_qty, SUM(s.stok_qty) as total_current
                FROM mst_asset a
                LEFT JOIN dat_stok s ON a.asset_id = s.asset_id
                WHERE a.deleted_st = 0 AND a.active_st = 1
                GROUP BY a.asset_id
                HAVING total_current <= a.stok_min_qty
                ORDER BY total_current ASC
                LIMIT 5";
        return $this->db->query($sql)->result_array();
    }

    // --- [BAGIAN 3] Log Aktivitas Gabungan (UNION ALL) ---
    public function get_recent_activities()
    {
        // Menggabungkan 4 tabel transaksi menjadi satu timeline aktivitas
        $query = "
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Masuk' as tipe, 'primary' as warna FROM trx_masuk WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Keluar (Disposal)' as tipe, 'danger' as warna FROM trx_keluar WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pemakaian' as tipe, 'warning' as warna FROM trx_pemakaian WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pengembalian' as tipe, 'success' as warna FROM trx_kembali WHERE deleted_st = 0)
            
            ORDER BY tgl DESC
            LIMIT 10
        ";
        return $this->db->query($query)->result_array();
    }
    
}