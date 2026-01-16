<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_satuan extends CI_Model
{
    public $table = 'mst_satuan';
    public $pk_id = 'satuan_id';

    public function load_datatables()
    {
        // Query dasar
        $query = "SELECT * FROM {$this->table}";
        
        // Konfigurasi pencarian dan filter
        $search_fields = ['satuan_nm']; 
        $where_clauses = ['deleted_st' => 0];
        
        DB::datatables_query($query, $search_fields, $where_clauses, null);
    }
}