<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_master_asset extends CI_Model
{
    var $table = 'mst_asset';
    var $pk_id = 'asset_id';

    public function load_datatables()
    {
        // JOIN ke tabel Kategori dan Satuan (menggunakan nama kolom baru _nm)
        $query = "SELECT a.*, k.kategori_nm, s.satuan_nm 
                  FROM mst_asset a 
                  LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                  LEFT JOIN mst_satuan s ON a.satuan_id = s.satuan_id";
                  
        $search = ['a.asset_kd', 'a.asset_nm', 'k.kategori_nm', 's.satuan_nm'];
        $where  = ['a.deleted_st' => 0];
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // Fungsi ambil kode kategori untuk prefix SKU (misal: ELK, ATK)
    public function get_kategori_prefix($kategori_id)
    {
        $this->db->select('kategori_kd');
        $this->db->where('kategori_id', $kategori_id);
        $query = $this->db->get('mst_kategori');
        return ($query->num_rows() > 0) ? $query->row()->kategori_kd : null;
    }

    // Fungsi generate nomor urut otomatis (misal: ELK-001 -> ELK-002)
    public function get_next_sku($prefix)
    {
        $this->db->select('asset_kd');
        $this->db->from($this->table);
        $this->db->like('asset_kd', $prefix . '-', 'after');
        $this->db->order_by('asset_kd', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $last_sku = $query->row()->asset_kd; 
            $parts = explode('-', $last_sku);
            $last_num = (int) end($parts); 
            $new_num = $last_num + 1;
        } else {
            $new_num = 1;
        }
        // Format: PREFIX-00X (3 digit angka)
        return $prefix . '-' . str_pad($new_num, 3, '0', STR_PAD_LEFT);
    }
}