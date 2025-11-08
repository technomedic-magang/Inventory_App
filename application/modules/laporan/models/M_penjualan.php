<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_penjualan extends CI_Model
{
    // Definisikan tabel utama laporan ini
    var $table, $pk_id;
    function __construct()
    {
        parent::__construct();
        $this->table = 'dat_penjualan'; // Tabel utama
        $this->pk_id = 'penjualan_id';
    }

    /**
     * Fungsi ini akan dipanggil oleh ajax_datatables() di controller
     * KITA AKAN KIRIM DATA DUMMY (CONTOH) DI SINI
     */
    public function load_datatables()
    {
        // --- (MODE TAMPILAN SAJA) ---
        // Kita kirim data JSON dummy agar tabelnya terisi
        $dummy_data = [
            [
                "penjualan_id" => "1",
                "tanggal" => "2025-11-08 10:30:00",
                "invoice_no" => "INV-001",
                "outlet_nm" => "Cabang Teras (Dummy)",
                "user_nm" => "kasir_andi (Dummy)", // Dari sys_user
                "total_akhir_rp" => "50000"
            ],
            [
                "penjualan_id" => "2",
                "tanggal" => "2025-11-08 11:15:00",
                "invoice_no" => "INV-002",
                "outlet_nm" => "Cabang Teras (Dummy)",
                "user_nm" => "kasir_andi (Dummy)",
                "total_akhir_rp" => "125000"
            ],
            [
                "penjualan_id" => "3",
                "tanggal" => "2025-11-08 14:00:00",
                "invoice_no" => "INV-003",
                "outlet_nm" => "Gudang Utama (Dummy)",
                "user_nm" => "kasir_budi (Dummy)",
                "total_akhir_rp" => "75000"
            ]
        ];
        
        // Buat format JSON yang sama persis seperti DataTables
        $json_output = [
            "draw" => intval($_POST['draw'] ?? 0),
            "recordsTotal" => 3,
            "recordsFiltered" => 3,
            "data" => $dummy_data
        ];
        
        // Gunakan helper _json() dari TMFW
        _json($json_output);
        // --- (AKHIR MODE TAMPILAN) ---


        /*
        // --- NANTI, GANTI KODE DI ATAS DENGAN KODE ASLI INI ---

        $query = "
            SELECT p.penjualan_id, p.tanggal, p.invoice_no, o.outlet_nm, u.user_nm, p.total_akhir_rp
            FROM $this->table p
            LEFT JOIN mst_outlet o ON p.outlet_id = o.outlet_id
            LEFT JOIN sys_user u ON p.user_id = u.user_id -- (Pastikan ini sys_user dari TMFW)
        ";
        
        $search = ['p.invoice_no', 'o.outlet_nm', 'u.user_nm'];
        
        // Filter tanggal (Contoh jika Anda menambahkannya)
        // $tgl_awal = _post('tgl_awal'); // Ambil dari filter
        // $tgl_akhir = _post('tgl_akhir');
        // $isWhere = " WHERE DATE(p.tanggal) BETWEEN '$tgl_awal' AND '$tgl_akhir' ";
        
        $where = ['p.deleted_st' => 0]; 
        $isWhere = null; // Aktifkan ini jika sudah ada filter

        DB::datatables_query($query, $search, $where, $isWhere);
        */
    }
}