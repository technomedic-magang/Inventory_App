<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_perabot extends CI_Model
{
    var $table = 'mst_asset';
    var $pk_id = 'asset_id';

    public function load_datatables()
    {
        // Query ini menggabungkan data Aset, Atribut Kustom, dan Lokasi
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
                v_merek.value_isi as merek_spek,
                v_tgl.value_isi as tgl_pembelian_kustom,
                v_ruang.value_isi as ruangan,
                v_lantai.value_isi as lantai,

                -- Ambil Penanggung Jawab (PIC Gudang / Peminjam)
                COALESCE(pg.pegawai_nm, g.pic_nm, '-') as penanggungjawab,
                CASE 
                    WHEN pg.pegawai_id IS NOT NULL THEN COALESCE(j.jabatan_nm, '-')
                    WHEN g.gudang_id IS NOT NULL THEN 'Kepala Gudang'
                    ELSE '-'
                END as jabatan

            FROM mst_asset a
            
            -- [FILTER KUNCI]
            -- Kategori 'PB' (Perabot, ID 11)
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd = 'PB'
            
            -- JOIN Atribut Kustom (Merek, Tgl, Ruang, Lantai)
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label LIKE 'Merek%'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label LIKE 'Tgl Pembelian%'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id

            LEFT JOIN mst_kategori_atribut attr_ruang ON attr_ruang.kategori_id = a.kategori_id AND attr_ruang.atribut_label = 'Ruangan'
            LEFT JOIN dat_asset_value v_ruang ON v_ruang.asset_id = a.asset_id AND v_ruang.atribut_id = attr_ruang.atribut_id

            LEFT JOIN mst_kategori_atribut attr_lantai ON attr_lantai.kategori_id = a.kategori_id AND attr_lantai.atribut_label = 'Lantai'
            LEFT JOIN dat_asset_value v_lantai ON v_lantai.asset_id = a.asset_id AND v_lantai.atribut_id = attr_lantai.atribut_id
            
            -- JOIN Sirkulasi (Siapa yang sedang pakai?)
            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id
            LEFT JOIN mst_jabatan j ON pg.jabatan_id = j.jabatan_id

            -- JOIN Stok (Ada di gudang mana?)
            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id
        ";

        $where = ['a.deleted_st'  => 0];
        $search = ['a.asset_kd', 'a.asset_nm', 'v_merek.value_isi', 'v_ruang.value_isi', 'pg.pegawai_nm'];
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // Fungsi detail (standar)
    public function get_detail_kustom($asset_id)
    {
        return $this->db->select('v.value_isi, attr.atribut_label')
                        ->from('dat_asset_value v')
                        ->join('mst_kategori_atribut attr', 'v.atribut_id = attr.atribut_id')
                        ->where('v.asset_id', $asset_id)
                        ->get()->result_array();
    }
}