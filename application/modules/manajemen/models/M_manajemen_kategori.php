<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_manajemen_kategori extends CI_Model
{
    var $table = 'mst_kategori';
    var $pk_id = 'kategori_id';

    public function load_datatables()
    {
        $query = "SELECT * FROM $this->table";
        $search = ['kategori_kd', 'kategori_nm', 'kategori_tipe'];
        $where  = ['deleted_st' => 0];
        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // [PASTIKAN FUNGSI INI ADA]
    public function get_current_atribut_ids($kategori_id)
    {
        $query = $this->db->select('atribut_id')
                          ->where('kategori_id', $kategori_id)
                          ->get('mst_kategori_atribut');
        $ids = [];
        foreach ($query->result_array() as $row) {
            // Konversi ke integer agar array_diff berfungsi akurat
            $ids[] = (int)$row['atribut_id'];
        }
        return $ids;
    }
}