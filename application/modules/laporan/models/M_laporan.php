<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan extends CI_Model
{
    // Laporan 1: Posisi Stok Gabungan (Per Barang per Gudang)
    public function get_laporan_stok($gudang_id = null, $kategori_id = null)
    {
        $this->db->select('a.asset_kd, a.asset_nm, k.kategori_nm, s.satuan_nm, g.gudang_nm, ds.stok_qty');
        $this->db->from('dat_stok ds');
        $this->db->join('mst_asset a', 'ds.asset_id = a.asset_id');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id', 'left');
        $this->db->join('mst_satuan s', 'a.satuan_id = s.satuan_id', 'left');
        $this->db->join('mst_gudang g', 'ds.gudang_id = g.gudang_id');
        
        // Filter Opsional
        if (!empty($gudang_id)) {
            $this->db->where('ds.gudang_id', $gudang_id);
        }
        if (!empty($kategori_id)) {
            $this->db->where('a.kategori_id', $kategori_id);
        }

        $this->db->where('ds.stok_qty >', 0); // Hanya tampilkan yang ada stoknya
        $this->db->order_by('g.gudang_nm ASC, a.asset_nm ASC');
        
        return $this->db->get()->result_array();
    }
}