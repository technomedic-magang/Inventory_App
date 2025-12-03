<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_gedung extends CI_Model
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
                a.active_st,
                k.kategori_nm,
                a.asset_kd as qr_code,

                -- [UBAH INI] Ambil Alamat (Atribut Kustom)
                v_alamat.value_isi as alamat,

                -- [BARU] Ambil Tanggal Pendirian (Atribut Kustom)
                -- Jika kosong, fallback ke Tahun Beli standar
                COALESCE(v_tgl.value_isi, CONCAT(a.asset_thn_beli, '-01-01')) as tgl_beli_lengkap

            FROM mst_asset a
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id
            LEFT JOIN mst_satuan s ON a.satuan_id = s.satuan_id
            
            -- JOIN untuk ALAMAT
            LEFT JOIN mst_kategori_atribut attr_alamat ON attr_alamat.kategori_id = a.kategori_id AND attr_alamat.atribut_label LIKE '%Alamat%'
            LEFT JOIN dat_asset_value v_alamat ON v_alamat.asset_id = a.asset_id AND v_alamat.atribut_id = attr_alamat.atribut_id

            -- JOIN untuk TANGGAL PENDIRIAN
            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label LIKE '%Tanggal%'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
        ";

        $where = [
            'k.kategori_kd' => 'GG',
            'a.deleted_st'  => 0
        ];

        $search = ['a.asset_kd', 'a.asset_nm', 'v_alamat.value_isi'];
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }

    public function get_detail_kustom($asset_id)
    {
        return $this->db->select('v.value_isi, attr.atribut_label, attr.atribut_tipe')
                        ->from('dat_asset_value v')
                        ->join('mst_kategori_atribut attr', 'v.atribut_id = attr.atribut_id')
                        ->where('v.asset_id', $asset_id)
                        ->order_by('attr.atribut_urutan', 'ASC')
                        ->get()->result_array();
    }
}