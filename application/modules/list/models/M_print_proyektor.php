<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_print_proyektor extends CI_Model
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
                k.kategori_nm,
                
                -- [BARU] Kolom Tahun dan Bulan Beli
                a.asset_thn_beli,
                a.asset_bln_beli,
                
                v_merek.value_isi as merek_tipe,
                v_tgl.value_isi as tgl_pembelian_kustom,

                -- Penanggung Jawab
                COALESCE(pg.pegawai_nm, g.pic_nm, '-') as penanggungjawab,

                -- Jabatan
                CASE 
                    WHEN pg.pegawai_id IS NOT NULL THEN COALESCE(j.jabatan_nm, '-')
                    WHEN g.gudang_id IS NOT NULL THEN 'Kepala Gudang'
                    ELSE '-'
                END as jabatan,
                
                -- Lokasi (Logika Cerdas)
                CASE
                    -- 1. Ambil Keterangan Transaksi (jika diisi)
                    WHEN tp.pemakaian_id IS NOT NULL AND tp.transaksi_ket IS NOT NULL AND tp.transaksi_ket != '' 
                        THEN tp.transaksi_ket
                    -- 2. Jika Keterangan kosong, pakai Nama Peminjam
                    WHEN tp.pemakaian_id IS NOT NULL 
                        THEN CONCAT('Dipakai: ', pg.pegawai_nm)
                    -- 3. Jika di Gudang
                    WHEN g.gudang_id IS NOT NULL 
                        THEN g.gudang_nm
                    -- 4. Fallback
                    ELSE 'Lokasi TBD'
                END as lokasi

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd = 'KP'
                 AND a.asset_nm IN ('Printer', 'LCD Proyektor')
            
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id 
                 AND attr_merek.atribut_label = 'Merek & Seri'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id 
                 AND attr_tgl.atribut_label = 'Tgl Pembelian'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id

            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id
            LEFT JOIN mst_jabatan j ON pg.jabatan_id = j.jabatan_id

            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id
        ";

        $where = ['a.deleted_st'  => 0];
        // Tambahkan pencarian tahun
        $search = ['a.asset_kd', 'a.asset_nm', 'v_merek.value_isi', 'pg.pegawai_nm', 'g.gudang_nm', 'tp.transaksi_ket', 'a.asset_thn_beli'];
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