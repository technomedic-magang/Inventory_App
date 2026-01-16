<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_kategori extends CI_Model
{
    // Menggunakan visibility public (standar baru) daripada var
    public $table = 'mst_kategori';
    public $pk_id = 'kategori_id';

    public function load_datatables()
    {
        $query = "SELECT * FROM {$this->table}";
        
        $search_fields = ['kategori_kd', 'kategori_nm', 'kategori_tipe'];
        $where_clauses = ['deleted_st' => 0];
        
        DB::datatables_query($query, $search_fields, $where_clauses, null);
    }

    public function get_current_atribut_ids($kategori_id)
    {
        $result = $this->db->select('atribut_id')
                           ->where('kategori_id', $kategori_id)
                           ->get('mst_kategori_atribut')
                           ->result_array();
        
        // Gaya Deklaratif: Langsung ambil kolom atribut_id menjadi array flat
        // Tidak perlu looping manual (foreach)
        return array_column($result, 'atribut_id');
    }
}