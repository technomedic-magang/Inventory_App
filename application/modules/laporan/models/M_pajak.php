<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_pajak extends CI_Model
{
    var $table = 'trx_pajak';
    var $pk_id = 'pajak_id';

    // --- 1. DATATABLES QUERY (UPDATED) ---
    public function load_datatables()
    {
        // QUERY JOIN LENGKAP
        // COALESCE akan mengambil nilai pertama yang TIDAK NULL.
        // NULLIF(t.nopol_baru, '') mengubah string kosong jadi NULL agar dilewati.
        
        $query = "SELECT 
                    t.*, 
                    a.asset_nm, 
                    a.asset_kd, 
                    k.kategori_nm,
                    
                    -- LOGIKA PRIORITAS:
                    -- 1. Ambil dari Transaksi (Jika ganti kaleng/ada isinya)
                    -- 2. Jika kosong, ambil dari Master Aset (v_nopol)
                    -- 3. Jika kosong juga, strip (-)
                    COALESCE(NULLIF(t.nopol_baru, ''), v_nopol.value_isi, '-') as plat_nomor

                  FROM trx_pajak t
                  JOIN mst_asset a ON t.asset_id = a.asset_id
                  LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id
                  
                  -- JOIN KE TABEL ATRIBUT (Untuk ambil Nopol Master)
                  LEFT JOIN mst_kategori_atribut attr_nopol ON (attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%')
                  LEFT JOIN dat_asset_value v_nopol ON (v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id)";

        // Kolom Pencarian
        $search = [
            't.transaksi_no', 
            'a.asset_nm', 
            't.nopol_baru',      // Bisa cari nopol baru
            'v_nopol.value_isi', // Bisa cari nopol lama
            'k.kategori_nm',
            't.transaksi_ket'
        ];

        $where  = ['t.deleted_st' => 0];
        $isWhere = null; 

        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // --- 2. GENERATOR NOMOR OTOMATIS ---
    public function get_auto_number($tanggal)
    {
        $prefix = 'TAX'; 
        $periode = date('Ym', strtotime($tanggal)); 
        $prefix_full = $prefix . '/' . $periode . '/';

        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        $query = $this->db->get($this->table);
        $last_no = $query->row()->transaksi_no;

        $urutan = ($last_no) ? (int)substr($last_no, -4) + 1 : 1;
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