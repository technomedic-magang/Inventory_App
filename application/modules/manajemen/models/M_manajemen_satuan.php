<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_manajemen_satuan extends CI_Model
{
    var $table = 'mst_satuan';
    var $pk_id = 'satuan_id';

    public function load_datatables()
    {
        $query = "SELECT * FROM $this->table";
        $search = ['satuan_nm']; // Hanya cari berdasarkan nama satuan
        $where  = ['deleted_st' => 0];
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }
}