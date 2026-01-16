<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asset_perusahaan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Model Gabungan 
        _models(['list/m_asset_perusahaan']); 
        
        // Arahkan ke folder view yang baru
        $this->template = 'list/list_asset_perusahaan/'; 
    }

    public function index()
    {
        $this->title = 'Daftar Seluruh Aset Perusahaan';
        // Ambil daftar kategori untuk filter (Sekarang sudah ada fungsinya di model)
        $d['list_kategori'] = $this->m_asset_perusahaan->get_all_kategori();
        $this->render($this->template . 'index', $d);
    }

    public function ajax_datatables()
    {
        // Panggil fungsi datatables dari model gabungan
        $this->m_asset_perusahaan->load_datatables();
    }

    public function detail_modal($id = null)
    {
        // Ambil data utama aset
        $d['main'] = DB::get('mst_asset', ['asset_id' => $id]);
        
        // [PERBAIKAN DISINI] 
        // Ganti m_master_asset menjadi m_asset_perusahaan sesuai load di construct
        $d['detail_kustom'] = $this->m_asset_perusahaan->get_detail_kustom($id);
        
        $d['id_asset'] = $id;
        $this->load->view($this->template . 'detail_modal', $d);
    }
}