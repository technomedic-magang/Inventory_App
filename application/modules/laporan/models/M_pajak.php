<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_pajak extends CI_Model
{
    // Konfigurasi Nama Tabel & Primary Key
    var $table = 'trx_pajak';
    var $pk_id = 'pajak_id';

    // --- 1. DATATABLES QUERY ---
    public function load_datatables()
    {
        // Kita perlu JOIN ke tabel Aset dan Kategori untuk menampilkan nama barang & jenisnya
        $query = "SELECT 
                    t.*, 
                    a.asset_nm, 
                    a.asset_kd, 
                    k.kategori_nm
                  FROM trx_pajak t
                  JOIN mst_asset a ON t.asset_id = a.asset_id
                  LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id";

        // Kolom yang bisa dicari via Search Box
        $search = [
            't.transaksi_no', 
            'a.asset_nm', 
            't.nopol_baru', // Cari berdasarkan Plat Nomor
            'k.kategori_nm',
            't.transaksi_ket'
        ];

        // Filter standar: Hapus data yang sudah di-soft delete
        $where  = ['t.deleted_st' => 0];
        
        // (Opsional) Jika ingin filter tambahan via Controller, bisa dimasukkan ke $isWhere
        $isWhere = null; 

        // Eksekusi Helper Datatables (Sesuai framework Anda)
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // --- 2. GENERATOR NOMOR OTOMATIS ---
    // Format: TAX/202512/0001 (Berdasarkan Bulan & Tahun)
    public function get_auto_number($tanggal)
    {
        $prefix = 'TAX'; 
        
        // Ambil Tahun & Bulan dari tanggal input (format YYYYMM)
        $periode = date('Ym', strtotime($tanggal)); 
        $prefix_full = $prefix . '/' . $periode . '/';

        // Cari nomor terakhir di database dengan prefix bulan ini
        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        $query = $this->db->get($this->table);
        $last_no = $query->row()->transaksi_no;

        // Jika ada, ambil 4 digit terakhir + 1. Jika tidak, mulai dari 1.
        $urutan = ($last_no) ? (int)substr($last_no, -4) + 1 : 1;
        
        // Return format lengkap dengan padding 0 (0001)
        return $prefix_full . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    // --- 3. HELPER: HITUNG TOTAL PAJAK (Untuk Info di Halaman Index) ---
    // (Opsional, nanti bisa dipakai di View Index untuk menampilkan kartu ringkasan)
    public function get_total_pajak_bulan_ini()
    {
        $bulan_ini = date('Y-m');
        $this->db->select_sum('nominal_total');
        $this->db->where('deleted_st', 0);
        $this->db->like('transaksi_tgl', $bulan_ini, 'after');
        $q = $this->db->get($this->table);
        return $q->row()->nominal_total ?? 0;
    }
}