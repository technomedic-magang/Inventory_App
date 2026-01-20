<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_asset_perusahaan extends CI_Model
{
    var $table = 'mst_asset';
    var $pk_id = 'asset_id';

    public function load_datatables()
    {
        if (ob_get_length()) ob_clean(); 
        header('Content-Type: application/json');

        // 1. Query Utama (Complex Join untuk standarisasi nama & lokasi)
        $query = "
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.active_st,
                k.kategori_nm,
                k.kategori_kd,
                
                -- LOGIKA TAHUN: Prioritas thn_beli -> thn_custom -> strip
                COALESCE(
                    NULLIF(a.asset_thn_beli, ''), 
                    NULLIF(a.asset_thn_beli, '0'), 
                    LEFT(v_tgl.value_isi, 4), 
                    '-'
                ) as tahun,

                -- LOGIKA NAMA LENGKAP: Nama Aset + Merek/Plat/Alamat
                CONCAT(
                    a.asset_nm,
                    CASE 
                        WHEN k.kategori_kd IN ('K2', 'K4') THEN 
                            CONCAT(
                                IF(v_merek.value_isi IS NOT NULL, CONCAT(' - ', v_merek.value_isi), ''),
                                IF(v_nopol.value_isi IS NOT NULL, CONCAT(' (', v_nopol.value_isi, ')'), '')
                            )
                        WHEN k.kategori_kd = 'GG' THEN 
                            IF(v_alamat.value_isi IS NOT NULL, CONCAT(' - ', v_alamat.value_isi), '')
                        ELSE 
                            IF(v_merek.value_isi IS NOT NULL, CONCAT(' - ', v_merek.value_isi), '')
                    END
                ) as nama_lengkap,

                -- LOGIKA LOKASI / PJ: Cek Peminjam -> Alamat Gedung -> Ruang -> Gudang
                CASE
                    WHEN tp.pemakaian_id IS NOT NULL THEN 
                        CONCAT('Dipakai: ', pg.pegawai_nm)
                    WHEN k.kategori_kd = 'GG' THEN 
                        COALESCE(v_alamat.value_isi, 'Alamat Belum Diset')
                    WHEN k.kategori_kd IN ('MB', 'PB', 'EL') AND v_ruang.value_isi IS NOT NULL THEN 
                        CONCAT(v_ruang.value_isi, IF(v_lantai.value_isi IS NOT NULL, CONCAT(' (', v_lantai.value_isi, ')'), ''))
                    WHEN g.gudang_id IS NOT NULL THEN 
                        CONCAT('Gudang: ', g.gudang_nm)
                    ELSE 'Lokasi Tidak Terdata'
                END as lokasi_pj,

                a.asset_kondisi

            FROM mst_asset a
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id

            -- JOIN ATRIBUT DINAMIS (Merek, Nopol, Alamat, Ruang, Lantai, Tanggal)
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id 
                 AND (attr_merek.atribut_label LIKE 'Merek%' OR attr_merek.atribut_label LIKE 'Type%')
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_nopol ON attr_nopol.kategori_id = a.kategori_id 
                 AND attr_nopol.atribut_label LIKE '%Polisi%'
            LEFT JOIN dat_asset_value v_nopol ON v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id

            LEFT JOIN mst_kategori_atribut attr_alamat ON attr_alamat.kategori_id = a.kategori_id 
                 AND attr_alamat.atribut_label LIKE '%Alamat%'
            LEFT JOIN dat_asset_value v_alamat ON v_alamat.asset_id = a.asset_id AND v_alamat.atribut_id = attr_alamat.atribut_id

            LEFT JOIN mst_kategori_atribut attr_ruang ON attr_ruang.kategori_id = a.kategori_id 
                 AND attr_ruang.atribut_label LIKE 'Ruang%'
            LEFT JOIN dat_asset_value v_ruang ON v_ruang.asset_id = a.asset_id AND v_ruang.atribut_id = attr_ruang.atribut_id

            LEFT JOIN mst_kategori_atribut attr_lantai ON attr_lantai.kategori_id = a.kategori_id 
                 AND attr_lantai.atribut_label LIKE 'Lantai%'
            LEFT JOIN dat_asset_value v_lantai ON v_lantai.asset_id = a.asset_id AND v_lantai.atribut_id = attr_lantai.atribut_id

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id 
                 AND (attr_tgl.atribut_label LIKE 'Tgl%' OR attr_tgl.atribut_label LIKE 'Tanggal%')
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id

            -- JOIN TRANSAKSI (Peminjaman & Stok)
            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id

            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id
        ";

        $where = ['a.deleted_st' => 0];

        // Filter Kategori
        $filter_kategori = $this->input->post('filter_kategori');
        if (!empty($filter_kategori)) {
            $where['a.kategori_id'] = $filter_kategori;
        }

        // Pencarian Global
        $search = [
            'a.asset_kd', 
            'a.asset_nm', 
            'v_merek.value_isi', 
            'v_nopol.value_isi', 
            'pg.pegawai_nm', 
            'v_ruang.value_isi'
        ];
        
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }

    public function get_detail_kustom($asset_id)
    {
        return $this->db->select('v.value_isi, attr.atribut_label')
                        ->from('dat_asset_value v')
                        ->join('mst_kategori_atribut attr', 'v.atribut_id = attr.atribut_id')
                        ->where('v.asset_id', $asset_id)
                        ->order_by('attr.atribut_urutan', 'ASC')
                        ->get()->result_array();
    }

    public function get_all_kategori() 
    {
        return $this->db->where(['deleted_st'=>0, 'active_st'=>1])
                        ->order_by('kategori_nm', 'ASC')
                        ->get('mst_kategori')->result_array();
    }
}