<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gedung extends MY_Controller
{
    // Konfigurasi Path Standar
    protected $view_path = 'list/list_gedung/';
    protected $uri_path  = 'list/gedung';

    public function __construct()
    {
        parent::__construct();
        _models(['list/m_gedung']); 
        
        $this->model = $this->m_gedung;
        // Full URL untuk View/JS
        $this->uri = site_url($this->uri_path); 
    }

    public function index()
    {
        $this->render($this->view_path . 'index');
    }

    public function ajax_datatables()
    {
        $this->model->load_datatables();
    }

    public function detail_modal($id = null)
    {
        if (empty($id)) {
            echo '<div class="alert alert-danger">ID tidak ditemukan.</div>';
            return;
        }

        // Ambil data utama
        $data['main'] = DB::get('mst_asset', ['asset_id' => $id]);
        
        if (!$data['main']) {
            echo '<div class="alert alert-warning">Data aset tidak ditemukan.</div>';
            return;
        }

        // Ambil atribut spesifik (Alamat, Luas, dll)
        $data['detail_kustom'] = $this->model->get_detail_kustom($id);
        $data['id_asset'] = $id;
        
        $this->render($this->view_path . 'detail_modal', $data);
    }
}