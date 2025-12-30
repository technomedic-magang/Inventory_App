<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_mabel_meja extends CI_Model
{
    var $table = 'mst_asset';
    var $pk_id = 'asset_id';

    public function load_datatables()
    {
        $query = "
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                a.asset_ket,
                -- Kolom Tahun dan Bulan Beli
                a.asset_thn_beli,
                a.asset_bln_beli,
                
                k.kategori_nm,
                
                -- Atribut Kustom
                v_merek.value_isi as merek_spek,
                v_ruang.value_isi as ruangan,
                v_lantai.value_isi as lantai

            FROM mst_asset a
            
            -- Filter Kategori Mebel (MB) dan Nama mengandung 'Meja'
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd = 'MB'
                 AND a.asset_nm LIKE 'Meja%'
            
            -- Join Merek
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label LIKE 'Merek%'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            -- Join Ruangan
            LEFT JOIN mst_kategori_atribut attr_ruang ON attr_ruang.kategori_id = a.kategori_id AND attr_ruang.atribut_label = 'Ruangan'
            LEFT JOIN dat_asset_value v_ruang ON v_ruang.asset_id = a.asset_id AND v_ruang.atribut_id = attr_ruang.atribut_id

            -- Join Lantai
            LEFT JOIN mst_kategori_atribut attr_lantai ON attr_lantai.kategori_id = a.kategori_id AND attr_lantai.atribut_label = 'Lantai'
            LEFT JOIN dat_asset_value v_lantai ON v_lantai.asset_id = a.asset_id AND v_lantai.atribut_id = attr_lantai.atribut_id
        ";

        $where = ['a.deleted_st'  => 0];
        
        // Pencarian data
        $search = ['a.asset_kd', 'a.asset_nm', 'v_merek.value_isi', 'v_ruang.value_isi', 'a.asset_thn_beli'];
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }

    public function get_detail_kustom($asset_id)
    {
        return $this->db->select('v.value_isi, attr.atribut_label')
                        ->from('dat_asset_value v')
                        ->join('mst_kategori_atribut attr', 'v.atribut_id = attr.atribut_id')
                        ->where('v.asset_id', $asset_id)
                        ->get()->result_array();
    }
}