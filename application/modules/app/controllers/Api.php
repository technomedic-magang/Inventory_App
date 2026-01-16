<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_app');       // Model Login
        $this->load->model('m_dashboard'); // Model Dashboard (Pastikan file m_dashboard.php ada)
        
        // Header agar output selalu JSON
        header('Content-Type: application/json');
    }

    // ============================================================
    // 1. LOGIN (Pindahan dari Auth.php)
    // ============================================================
    public function login()
    {
        // 1. Ambil Input
        $u = $this->input->post('u');
        $p = $this->input->post('p');

        // 2. Validasi
        if (empty($u) || empty($p)) {
            echo json_encode(['status' => 0, 'message' => 'Username/Password kosong']);
            return;
        }

        // 3. BYPASS CAPTCHA & TOKEN (Teknik Inject)
        $kunci_bypass = 'android_bypass_key';
        $this->session->set_userdata('captchaword', $kunci_bypass);
        
        $_POST['c'] = $kunci_bypass;       // Manipulasi input captcha
        $_POST['t'] = md5(date('YmdH'));   // Manipulasi input token

        // 4. Panggil Model Asli
        $res = $this->m_app->login();

        // 5. Response
        $response = ['status' => $res, 'message' => ''];
        
        switch ($res) {
            case 1:
                $response['message'] = "Login Berhasil";
                // Kirim data user untuk ditampilkan di Dashboard Android
                $response['user_data'] = [
                    'user_id' => $this->session->userdata('user_id'),
                    'nama'    => $this->session->userdata('pegawai_nm') ?? $this->session->userdata('magang_nm'),
                    'role'    => $this->session->userdata('role_nm')
                ];
                break;
            case 0:  $response['message'] = "Password Salah"; break;
            case -1: $response['message'] = "Akun Tidak Aktif"; break;
            case -2: $response['message'] = "User Tidak Ditemukan"; break;
            default: $response['message'] = "Gagal Login (Kode: $res)"; break;
        }

        echo json_encode($response);
    }

    // ============================================================
    // 2. DASHBOARD (Untuk Data Statistik)
    // ============================================================
    public function dashboard()
    {
        // Panggil fungsi yang SUDAH ADA di M_dashboard
        // Pastikan Anda sudah punya M_dashboard.php di folder models
        $stats = $this->m_dashboard->get_summary_stats();
        
        $data = [
            'status' => 1,
            'message' => 'Data Dashboard',
            'stats' => [
                // Konversi ke string agar aman di JSON
                'total_asset' => (string) $stats['total_asset'],
                'asset_rusak' => (string) $stats['asset_trouble'],
                'stok_fisik'  => (string) $stats['stok_fisik']
            ],
            // Panggil Reminder Service
            'service_alerts' => $this->m_dashboard->get_service_reminders()
        ];

        echo json_encode($data);
    }
}