<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_manajemen_aset extends CI_Model
{
    public $table = 'mst_asset';
    public $pk_id = 'asset_id';

    public function load_datatables()
    {
        $query = "SELECT a.*, k.kategori_nm, s.satuan_nm 
                  FROM mst_asset a 
                  LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                  LEFT JOIN mst_satuan s ON a.satuan_id = s.satuan_id";
                  
        $search_fields = ['a.asset_kd', 'a.asset_nm', 'k.kategori_nm'];
        $where_clauses = ['a.deleted_st' => 0];

        // Filter: Jika user memilih kategori tertentu
        $filter_kategori = $this->input->post('filter_kategori');
        if (!empty($filter_kategori)) {
            $where_clauses['a.kategori_id'] = $filter_kategori;
        }

        DB::datatables_query($query, $search_fields, $where_clauses, null);
    }

    // --- Helper SKU Generation ---

    public function get_kategori_prefix($kategori_id)
    {
        $row = $this->db->select('kategori_kd')
                        ->where('kategori_id', $kategori_id)
                        ->get('mst_kategori')
                        ->row();
        return $row ? $row->kategori_kd : null;
    }

    public function get_next_full_sku($kategori_id, $kd_singkat, $tahun, $bulan)
    {
        $kategori_kd = $this->get_kategori_prefix($kategori_id);
        
        if (empty($kategori_id) || empty($kategori_kd) || empty($kd_singkat)) {
            return "Lengkapi Data";
        }

        $bln_pad = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        $prefix_full = "ITM-$kategori_kd-$kd_singkat-$tahun.$bln_pad.";

        // Logic Grup Kategori
        $grup_kategori = [$kategori_kd];
        if (in_array($kategori_kd, ['K2', 'K4'])) $grup_kategori = ['K2', 'K4'];
        if (in_array($kategori_kd, ['GG', 'GDG'])) $grup_kategori = ['GG', 'GDG'];

        // Ambil Nomor Urut Terakhir
        $this->db->select("MAX(CAST(SUBSTRING_INDEX(a.asset_kd, '.', -1) AS UNSIGNED)) as max_num");
        $this->db->from("mst_asset a");
        $this->db->join("mst_kategori k", "a.kategori_id = k.kategori_id");
        $this->db->where_in('k.kategori_kd', $grup_kategori); 
        
        $query = $this->db->get();
        $last_num = $query->row() ? $query->row()->max_num : 0;
        $new_num  = $last_num + 1;

        // Panjang padding berbeda untuk kategori tertentu
        $padding = in_array($kategori_kd, ['GG', 'GDG', 'K2', 'K4']) ? 3 : 4;

        return $prefix_full . str_pad($new_num, $padding, '0', STR_PAD_LEFT);
    }
}