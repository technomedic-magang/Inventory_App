<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_manajemen_asset extends CI_Model
{
    var $table = 'mst_asset';
    var $pk_id = 'asset_id';

    public function load_datatables()
    {
        $query = "SELECT a.*, k.kategori_nm, s.satuan_nm 
                  FROM mst_asset a 
                  LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                  LEFT JOIN mst_satuan s ON a.satuan_id = s.satuan_id";
                  
        $search = ['a.asset_kd', 'a.asset_nm', 'k.kategori_nm'];
        $where  = ['a.deleted_st' => 0];
        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // Fungsi helper ambil KODE KATEGORI (misal: GG, K2, K4)
    public function get_kategori_prefix($kategori_id)
    {
        $this->db->select('kategori_kd');
        $this->db->where('kategori_id', $kategori_id);
        $query = $this->db->get('mst_kategori');
        return ($query->num_rows() > 0) ? $query->row()->kategori_kd : null;
    }

    // --- [MESIN BARU] Generate SKU Lengkap (ITM-K2-MT-2014.10.001) ---
    public function get_next_full_sku($kategori_id, $kd_singkat, $tahun, $bulan)
    {
        // 1. Ambil Kode Kategori
        $kategori_kd = $this->get_kategori_prefix($kategori_id);
        if (empty($kategori_kd) || empty($kd_singkat) || empty($tahun) || empty($bulan)) {
            return "Lengkapi 4 Field SKU";
        }

        // 2. Format Bulan (misal: 9 -> 09)
        $bln = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        
        // 3. Buat Prefix Pencarian (cth: "ITM-K2-MT-2014.10.")
        $prefix = "ITM-$kategori_kd-$kd_singkat-$tahun.$bln.";

        // 4. Cari nomor urut terakhir di database
        $this->db->select('asset_kd');
        $this->db->from($this->table);
        $this->db->like('asset_kd', $prefix, 'after');
        $this->db->order_by('asset_kd', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $last_kode = $query->row()->asset_kd;
            $last_num = (int) substr($last_kode, -3);
            $new_num = $last_num + 1;
        } else {
            $new_num = 1;
        }

        // 5. Kembalikan kode lengkap
        return $prefix . str_pad($new_num, 3, '0', STR_PAD_LEFT);
    }
}