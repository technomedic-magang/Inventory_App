<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_master_kategori extends CI_Model
{
    var $table = 'mst_kategori';
    var $pk_id = 'kategori_id';

    public function load_datatables()
    {
        $query = "SELECT * FROM $this->table";
        $search = ['kategori_kd', 'kategori_nm'];
        $where  = ['deleted_st' => 0];
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }
}