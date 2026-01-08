<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_manajemen_asset extends CI_Model
{
    var $table = 'mst_asset';
    var $pk_id = 'asset_id';

    public function load_datatables()
    {
<<<<<<< HEAD
=======
        // [UPDATE] Tambahkan select beli_nominal (Harga)
>>>>>>> repoB/main
        $query = "SELECT a.*, k.kategori_nm, s.satuan_nm 
                  FROM mst_asset a 
                  LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                  LEFT JOIN mst_satuan s ON a.satuan_id = s.satuan_id";
                  
        $search = ['a.asset_kd', 'a.asset_nm', 'k.kategori_nm'];
        $where  = ['a.deleted_st' => 0];

<<<<<<< HEAD
        // [UPDATE] Filter Data Berdasarkan Kategori
=======
        // Filter Data Berdasarkan Kategori
>>>>>>> repoB/main
        $filter_kategori = $this->input->post('filter_kategori');
        if (!empty($filter_kategori)) {
            $where['a.kategori_id'] = $filter_kategori;
        }

        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

<<<<<<< HEAD
    // Fungsi helper ambil KODE KATEGORI (misal: GG, K2, K4)
    public function get_kategori_prefix($kategori_id)
    {
        $this->db->select('kategori_kd');
        $this->db->where('kategori_id', $kategori_id);
        $query = $this->db->get('mst_kategori');
        return ($query->num_rows() > 0) ? $query->row()->kategori_kd : null;
    }

    // Generate SKU dengan NOMOR URUT PER GRUP KATEGORI
    public function get_next_full_sku($kategori_id, $kd_singkat, $tahun, $bulan)
    {
        // 1. Ambil Kode Kategori (e.g., "K2")
        $kategori_kd = $this->get_kategori_prefix($kategori_id);
        if (empty($kategori_id) || empty($kategori_kd) || empty($kd_singkat) || empty($tahun) || empty($bulan)) {
            return "Lengkapi 4 Field SKU";
        }

        // 2. Format Bulan (e.g., "09")
        $bln = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        
        // 3. Buat "Prefix Fleksibel" (Bagian depan kode)
        $prefix_fleksibel = "ITM-$kategori_kd-$kd_singkat-$tahun.$bln.";

        // 4. Tentukan GRUP KATEGORI
        $grup_kategori_kds = [];
        if ($kategori_kd == 'K2' || $kategori_kd == 'K4') { 
            $grup_kategori_kds = ['K2', 'K4']; 
        } else if ($kategori_kd == 'GG' || $kategori_kd == 'GDG') { 
            $grup_kategori_kds = ['GG', 'GDG'];
        } else {
            $grup_kategori_kds = [$kategori_kd];
        }

        // 5. Cari nomor urut TERBESAR berdasarkan GRUP KATEGORI
=======
    // Fungsi helper dan generate SKU (Tetap Gunakan Kode Lama Anda)
    public function get_kategori_prefix($kategori_id)
    {
        $q = $this->db->select('kategori_kd')->where('kategori_id', $kategori_id)->get('mst_kategori');
        return ($q->num_rows() > 0) ? $q->row()->kategori_kd : null;
    }

    public function get_next_full_sku($kategori_id, $kd_singkat, $tahun, $bulan)
    {
        $kategori_kd = $this->get_kategori_prefix($kategori_id);
        if (empty($kategori_id) || empty($kategori_kd) || empty($kd_singkat) || empty($tahun) || empty($bulan)) {
            return "Lengkapi Data";
        }

        $bln = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        $prefix_fleksibel = "ITM-$kategori_kd-$kd_singkat-$tahun.$bln.";

        // Logic grup kategori (Sesuai kode lama)
        $grup_kategori_kds = [$kategori_kd];
        if (in_array($kategori_kd, ['K2', 'K4'])) $grup_kategori_kds = ['K2', 'K4'];
        if (in_array($kategori_kd, ['GG', 'GDG'])) $grup_kategori_kds = ['GG', 'GDG'];

>>>>>>> repoB/main
        $this->db->select("MAX(CAST(SUBSTRING_INDEX(a.asset_kd, '.', -1) AS UNSIGNED)) as max_num");
        $this->db->from("mst_asset a");
        $this->db->join("mst_kategori k", "a.kategori_id = k.kategori_id");
        $this->db->where_in('k.kategori_kd', $grup_kategori_kds); 
        $query = $this->db->get();
        $last_num = $query->row() ? $query->row()->max_num : 0;

<<<<<<< HEAD
        // 6. Hitung nomor baru
        $new_num = $last_num + 1;

        $padding_length = 0;
        
        // Cek apakah kategori saat ini termasuk grup "Gedung" atau "Kendaraan"
        if (in_array($kategori_kd, ['GG', 'GDG', 'K2', 'K4'])) {
            $padding_length = 3;
        } else {
            $padding_length = 4;
        }

        // 7. Kembalikan kode lengkap dengan padding dinamis
=======
        $new_num = $last_num + 1;
        $padding_length = in_array($kategori_kd, ['GG', 'GDG', 'K2', 'K4']) ? 3 : 4;

>>>>>>> repoB/main
        return $prefix_fleksibel . str_pad($new_num, $padding_length, '0', STR_PAD_LEFT);
    }
}