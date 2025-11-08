<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_master_asset extends CI_Model
{
    var $table = 'mst_asset';
    var $pk_id = 'asset_id';

    public function load_datatables()
    {
        // KEMBALIKAN VERSI JOIN LENGKAP
        $query = "SELECT a.*, k.kategori_nama, s.satuan_nama 
                FROM mst_asset a 
                LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                LEFT JOIN mst_satuan s ON a.satuan_id = s.satuan_id";
                
        // Cari berdasarkan nama kategori juga
        $search = ['a.asset_kode', 'a.asset_nama', 'k.kategori_nama'];
        $where  = ['a.deleted_st' => 0];
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }

    public function get_kategori_prefix($kategori_id)
    {
        $this->db->select('kategori_kode');
        $this->db->where('kategori_id', $kategori_id);
        $query = $this->db->get('mst_kategori');
        return ($query->num_rows() > 0) ? $query->row()->kategori_kode : null;
    }

    public function get_next_sku($prefix)
    {
        $this->db->select('asset_kode');
        $this->db->from($this->table);
        $this->db->like('asset_kode', $prefix . '-', 'after');
        $this->db->order_by('asset_kode', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $last_sku = $query->row()->asset_kode; 
            $parts = explode('-', $last_sku);
            $last_num = (int) end($parts); 
            $new_num = $last_num + 1;
        } else {
            $new_num = 1;
        }
        return $prefix . '-' . str_pad($new_num, 3, '0', STR_PAD_LEFT);
    }
}