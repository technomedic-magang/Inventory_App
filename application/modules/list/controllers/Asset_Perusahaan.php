<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asset_perusahaan extends MY_Controller
{
    // Konfigurasi Path Standar
    protected $view_path = 'list/list_asset_perusahaan/';
    protected $uri_path  = 'list/asset_perusahaan';

    public function __construct()
    {
        parent::__construct();
        _models(['list/m_asset_perusahaan']); 
        
        $this->model = $this->m_asset_perusahaan;
        // Full URL untuk View/JS
        $this->uri = site_url($this->uri_path); 
    }

    public function index()
    {
        $this->title = 'Daftar Seluruh Aset Perusahaan';
        // Ambil data untuk filter kategori
        $data['list_kategori'] = $this->model->get_all_kategori();
        
        $this->render($this->view_path . 'index', $data);
    }

    public function ajax_datatables()
    {
        // JSON Response ditangani di Model
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

        // Ambil atribut spesifik (Merek, Lokasi, dll)
        $data['detail_kustom'] = $this->model->get_detail_kustom($id);
        $data['id_asset'] = $id;
        
        // Render menggunakan view path standar
        $this->render($this->view_path . 'detail_modal', $data);
    }
}