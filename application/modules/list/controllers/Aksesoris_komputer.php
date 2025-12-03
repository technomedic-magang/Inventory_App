<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aksesoris_komputer extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model baru
        _models(['list/m_aksesoris_komputer']); 
        // Set path view baru
        $this->template = 'list/list_aksesoris_komputer/'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        $this->m_aksesoris_komputer->load_datatables();
    }

    // Modal detail tetap sama, hanya beda model
    public function detail_modal($id = null)
    {
        $d['main'] = DB::get('mst_asset', ['asset_id' => $id]);
        $d['detail_kustom'] = $this->m_aksesoris_komputer->get_detail_kustom($id);
        $d['id_asset'] = $id;
        $this->load->view($this->template . 'detail_modal', $d);
    }
}