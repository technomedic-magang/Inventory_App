<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
<<<<<<< HEAD
=======
        // Load model
>>>>>>> repoB/main
        $this->load->model('M_dashboard');
    }

    public function index() {
        // 1. Statistik Kartu
        $data['stats'] = $this->M_dashboard->get_summary_stats();

        // 2. Stok Menipis
        $data['low_stock'] = $this->M_dashboard->get_low_stock_persediaan();

<<<<<<< HEAD
        // 3. Riwayat Aktivitas (Tabel Baru)
        $data['riwayat'] = $this->M_dashboard->get_riwayat_gabungan();

        // 4. Top Barang (Info Tambahan)
=======
        // 3. Riwayat Aktivitas
        $data['riwayat'] = $this->M_dashboard->get_riwayat_gabungan();

        // 4. Top Barang
>>>>>>> repoB/main
        $data['top_barang'] = $this->M_dashboard->get_top_barang_keluar();

        // 5. Data Chart
        $data['chart_data'] = $this->M_dashboard->get_monthly_chart();

<<<<<<< HEAD
=======
        // 6. [BARU] Service Reminders
        $data['service_alerts'] = $this->M_dashboard->get_service_reminders();

        // Judul
>>>>>>> repoB/main
        $this->title = "Dashboard Utama";
        $this->nav['nav_nm'] = "Ringkasan Sistem";

        $this->render('dashboard/index_pegawai', $data);
    }
}