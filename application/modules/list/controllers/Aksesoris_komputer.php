<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aksesoris_komputer extends MY_Controller
{
    // Path view dan URI modul
    protected $view_path = 'list/list_aksesoris_komputer/';
    protected $uri_path  = 'list/aksesoris_komputer';

    public function __construct()
    {
        parent::__construct();
        // Load model khusus aksesoris
        _models(['list/m_aksesoris_komputer']); 
        
        $this->model = $this->m_aksesoris_komputer;
        // Generate Full URL untuk digunakan di View/JS
        $this->uri = site_url($this->uri_path); 
    }

    /**
     * Menampilkan halaman utama (Tabel)
     */
    public function index()
    {
        $this->render($this->view_path . 'index');
    }

    /**
     * Endpoint untuk DataTables (Server-side)
     * Mengembalikan output JSON
     */
    public function ajax_datatables()
    {
        $this->model->load_datatables();
    }

    /**
     * Menampilkan Modal Detail Aset
     * @param int $id ID Aset
     */
    public function detail_modal($id = null)
    {
        if (empty($id)) {
            echo '<div class="alert alert-danger">ID tidak ditemukan.</div>';
            return;
        }

        // Ambil data utama dari tabel master
        $data['main'] = DB::get('mst_asset', ['asset_id' => $id]);
        
        if (!$data['main']) {
            echo '<div class="alert alert-warning">Data aset tidak ditemukan.</div>';
            return;
        }

        // Ambil atribut spesifik (Merek, Tgl Beli, dll)
        $data['detail_kustom'] = $this->model->get_detail_kustom($id);
        $data['id_asset'] = $id;
        
        // Render view modal
        $this->render($this->view_path . 'detail_modal', $data);
    }
}