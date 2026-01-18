<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kendaraan extends MY_Controller
{
    protected $view_path = 'list/list_kendaraan/';
    protected $uri_path  = 'list/kendaraan';

    public function __construct()
    {
        parent::__construct();
        _models(['list/m_kendaraan']); 
        
        $this->model = $this->m_kendaraan;
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

        $data['main'] = DB::get('mst_asset', ['asset_id' => $id]);
        
        if (!$data['main']) {
            echo '<div class="alert alert-warning">Data aset tidak ditemukan.</div>';
            return;
        }

        $data['detail_kustom'] = $this->model->get_detail_kustom($id);
        $data['id_asset'] = $id;
        
        // [FIX] Gunakan render() agar output konsisten
        $this->render($this->view_path . 'detail_modal', $data);
    }
}