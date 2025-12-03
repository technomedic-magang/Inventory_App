<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Elektronik extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model baru
        _models(['list/m_elektronik']); 
        // Set path view baru
        $this->template = 'list/list_elektronik/'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        $this->m_elektronik->load_datatables();
    }

    // Modal detail (standar)
    public function detail_modal($id = null)
    {
        $d['main'] = DB::get('mst_asset', ['asset_id' => $id]);
        $d['detail_kustom'] = $this->m_elektronik->get_detail_kustom($id);
        $d['id_asset'] = $id;
        $this->load->view($this->template . 'detail_modal', $d);
    }
}