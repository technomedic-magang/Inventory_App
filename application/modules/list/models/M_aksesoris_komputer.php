<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_aksesoris_komputer extends CI_Model
{
    var $table = 'mst_asset';
    var $pk_id = 'asset_id';

    public function load_datatables()
    {
        // Query ini menggabungkan data Aset dengan Atribut Kustom
        $query = "
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- Ambil Atribut Kustom 'Merek & Tipe'
                v_merek.value_isi as merek_tipe,
                
                -- Ambil Atribut Kustom 'Tanggal Pembelian'
                v_tgl.value_isi as tgl_pembelian_kustom,

                a.asset_ket

            FROM mst_asset a
            
            -- 1. JOIN Kategori (Filter 'AKS' di sini)
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd = 'ACC' -- KUNCI: Hanya Aksesoris
            
            -- 2. JOIN Atribut 'Merek & Tipe'
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label = 'Merek & Tipe'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            -- 3. JOIN Atribut 'Tanggal Pembelian'
            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label = 'Tanggal Pembelian'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
        ";

        // Filter standar
        $where = ['a.deleted_st' => 0];

        // Kolom yang bisa dicari
        $search = ['a.asset_kd', 'a.asset_nm', 'v_merek.value_isi'];
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // Fungsi ini sama, untuk modal detail
    public function get_detail_kustom($asset_id)
    {
        return $this->db->select('v.value_isi, attr.atribut_label')
                        ->from('dat_asset_value v')
                        ->join('mst_kategori_atribut attr', 'v.atribut_id = attr.atribut_id')
                        ->where('v.asset_id', $asset_id)
                        ->get()->result_array();
    }
}