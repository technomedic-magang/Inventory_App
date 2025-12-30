<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
    // 1. Hitung Total Jenis Asset Aktif
    public function count_total_asset_types()
    {
        return $this->db->where(['deleted_st' => 0, 'active_st' => 1])
                        ->count_all_results('mst_asset');
    }

    // 2. Hitung Total Fisik Stok
    public function sum_total_stok()
    {
        $query = $this->db->select_sum('stok_qty')->get('dat_stok');
        return (int) $query->row()->stok_qty;
    }

    // 3. Hitung Barang Sedang Dipakai
    public function sum_sedang_dipakai()
    {
        $this->db->select('SUM(pemakaian_qty - kembali_qty) as sisa_pemakaian');
        $this->db->where('pemakaian_qty > kembali_qty');
        $query = $this->db->get('trx_pemakaian_detail');
        return (int) $query->row()->sisa_pemakaian;
    }

    // 4. Ambil Daftar Barang Stok Menipis (Limit 5)
    public function get_low_stock_items()
    {
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

    // 5. Ambil 5 Transaksi Terakhir (Activity Feed)
    public function get_recent_activities()
    {
        // mengambil 5 transaksi masuk terakhir
        return $this->db->select('t.transaksi_tgl, t.transaksi_no, g.gudang_nm, "IN" as tipe')
                        ->from('trx_masuk t')
                        ->join('mst_gudang g', 't.gudang_id = g.gudang_id', 'left')
                        ->where('t.deleted_st', 0)
                        ->order_by('t.created_at', 'DESC')
                        ->limit(5)
                        ->get()->result_array();
    }
}