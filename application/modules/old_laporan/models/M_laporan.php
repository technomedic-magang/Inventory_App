<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan extends CI_Model
{
    public function get_laporan_stok($gudang_id = null, $kategori_id = null)
    {
        // Jika kedua filter kosong -> tidak menampilkan data
        if (empty($gudang_id) && empty($kategori_id)) {
            return [];
        }

        $this->db->select('
            a.asset_id,
            a.asset_kd,
            a.asset_nm,
            k.kategori_nm,
            s.satuan_nm,
            g.gudang_id,
            g.gudang_nm,
            IFNULL(ds.stok_qty, 0) AS stok_qty
        ');

        // Mulai dari mst_asset agar semua asset bisa muncul
        $this->db->from('mst_asset a');

        // Join kategori & satuan (relasi normal)
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id', 'left');
        $this->db->join('mst_satuan s', 'a.satuan_id = s.satuan_id', 'left');

        // Cross join ke gudang aktif (1=1) -> menghasilkan kombinasi asset x gudang
        // Filter gudang spesifik nanti lewat WHERE jika gudang dipilih
        $this->db->join('mst_gudang g', '1=1', 'inner');

        // Left join ke tabel stok berdasarkan asset + gudang
        $this->db->join(
            'dat_stok ds',
            'ds.asset_id = a.asset_id AND ds.gudang_id = g.gudang_id',
            'left'
        );

        // Filter element yang dihapus
        $this->db->where('a.deleted_st', 0);
        $this->db->where('g.deleted_st', 0);

        // Jika gudang dipilih -> batasi ke gudang itu saja
        if (!empty($gudang_id)) {
            $this->db->where('g.gudang_id', (int)$gudang_id);
        }

        // Jika kategori dipilih -> batasi ke kategori itu saja
        if (!empty($kategori_id)) {
            $this->db->where('a.kategori_id', (int)$kategori_id);
        }

        // Urutkan dan pastikan unik (hindari duplikat bila struktur stok memiliki multi record)
        $this->db->group_by('a.asset_id, g.gudang_id');
        $this->db->order_by('g.gudang_nm ASC, a.asset_nm ASC');

        $result = $this->db->get()->result_array();

        return $result;
    }
}
