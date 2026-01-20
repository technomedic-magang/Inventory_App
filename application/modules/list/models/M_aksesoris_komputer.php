<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_aksesoris_komputer extends CI_Model
{
    var $table = 'mst_asset';
    var $pk_id = 'asset_id';

    /**
     * Query utama untuk DataTables
     * Mengambil data aset + atribut kustom (Merek, Tgl Beli)
     */
    public function load_datatables()
    {
        // [PENTING] Header JSON untuk mencegah error parsing di sisi client
        if (ob_get_length()) ob_clean(); 
        header('Content-Type: application/json');

        $query = "
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                a.asset_thn_beli,
                a.asset_bln_beli,
                a.asset_ket,
                k.kategori_nm,
                
                -- Mengambil nilai atribut kustom dari tabel EAV (Entity-Attribute-Value)
                v_merek.value_isi as merek_tipe,
                v_tgl.value_isi as tgl_pembelian_kustom

            FROM mst_asset a
            
            -- Filter Kategori: Hanya ambil yang kodenya 'ACC' (Aksesoris)
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd = 'ACC' 
            
            -- Join Atribut 'Merek & Tipe'
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label = 'Merek & Tipe'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            -- Join Atribut 'Tanggal Pembelian'
            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label = 'Tanggal Pembelian'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
        ";

        // Filter standar: Data tidak terhapus & Aktif
        $where = ['a.deleted_st' => 0, 'a.active_st' => 1];

        // Kolom yang bisa dicari via search box
        $search = ['a.asset_kd', 'a.asset_nm', 'v_merek.value_isi', 'a.asset_ket'];
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }

    /**
     * Mengambil detail spesifikasi kustom untuk modal
     */
    public function get_detail_kustom($asset_id)
    {
        return $this->db->select('v.value_isi, attr.atribut_label')
                        ->from('dat_asset_value v')
                        ->join('mst_kategori_atribut attr', 'v.atribut_id = attr.atribut_id')
                        ->where('v.asset_id', $asset_id)
                        ->order_by('attr.atribut_urutan', 'ASC')
                        ->get()->result_array();
    }
}