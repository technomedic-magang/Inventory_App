<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_elektronik extends CI_Model
{
    var $table = 'mst_asset';
    var $pk_id = 'asset_id';

    public function load_datatables()
    {
        // [REVISI TOTAL QUERY]
        $query = "
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                a.asset_ket,
                k.kategori_nm,
                
                -- Ambil Atribut Kustom
                v_merek.value_isi as merek_tipe,
                v_tgl.value_isi as tgl_pembelian_kustom,

                -- [BARU] Ambil Ruangan & Lantai
                v_ruang.value_isi as ruangan,
                v_lantai.value_isi as lantai

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd = 'EL'
            
            -- JOIN Atribut Kustom
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label = 'Merek & Seri'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label = 'Tgl Pembelian'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id

            -- [BARU] JOIN untuk Ruangan
            LEFT JOIN mst_kategori_atribut attr_ruang ON attr_ruang.kategori_id = a.kategori_id AND attr_ruang.atribut_label = 'Ruangan'
            LEFT JOIN dat_asset_value v_ruang ON v_ruang.asset_id = a.asset_id AND v_ruang.atribut_id = attr_ruang.atribut_id

            -- [BARU] JOIN untuk Lantai
            LEFT JOIN mst_kategori_atribut attr_lantai ON attr_lantai.kategori_id = a.kategori_id AND attr_lantai.atribut_label = 'Lantai'
            LEFT JOIN dat_asset_value v_lantai ON v_lantai.asset_id = a.asset_id AND v_lantai.atribut_id = attr_lantai.atribut_id
        ";

        $where = ['a.deleted_st'  => 0];
        $search = ['a.asset_kd', 'a.asset_nm', 'v_merek.value_isi', 'v_ruang.value_isi', 'v_lantai.value_isi'];
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