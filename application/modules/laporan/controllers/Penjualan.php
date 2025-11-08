<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends MY_Controller // Pastikan extends ke MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Cek login (Wajib ada, ini dari TMFW)
        if ($this->session->userdata('login_st') != 1) {
            redirect('auth/login');
        }

        // @model (Sesuai pola TMFW)
        _models(['laporan/m_penjualan']);
        
        // @table (Sesuai pola TMFW)
        $this->table = $this->m_penjualan->table;
        $this->pk_id = $this->m_penjualan->pk_id;
        
        // @params (Sesuai pola TMFW)
        $this->template = 'laporan/penjualan/'; // Path ke folder views
    }

    /**
     * Halaman Index (Hanya menampilkan view)
     */
    public function index()
    {
        $d = [
            'title' => 'Laporan Penjualan (Tampilan Saja)'
        ];
        
        // Panggil fungsi render TMFW
        $this->render($this->template . 'index', $d); 
    }

    /**
     * Fungsi DataTables (Sesuai pola TMFW)
     */
    public function ajax_datatables()
    {
        // Panggil fungsi dari model
        $this->m_penjualan->load_datatables();
    }
    
    // TIDAK PERLU FUNGSI form_modal(), save(), atau delete()
    // KARENA INI ADALAH LAPORAN (READ-ONLY)
}