<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_master_satuan extends CI_Model
{
    var $table = 'mst_satuan';
    var $pk_id = 'satuan_id';

    public function load_datatables()
    {
        // Pastikan kolom deskripsi ditambahkan di sini agar DataTables bisa mengambilnya
        $query = "SELECT satuan_id, satuan_nm, deskripsi, active_st, deleted_st FROM $this->table";
        $search = ['satuan_nm', 'deskripsi']; // Cari berdasarkan nama satuan dan deskripsi
        $where  = ['deleted_st' => 0];
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }
}