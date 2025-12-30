<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mabel_meja extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['list/m_mabel_meja']); 
        $this->template = 'list/list_mabel_meja/'; 
    }

    public function index()
    {
        // Judul disesuaikan
        $this->title = 'Daftar Mebel (Meja)';
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        $this->m_mabel_meja->load_datatables();
    }

    public function detail_modal($id = null)
    {
        if (!$this->input->is_ajax_request()) exit('No direct script access allowed');

        $d['main'] = DB::get('mst_asset', ['asset_id' => $id]);
        $d['detail_kustom'] = $this->m_mabel_meja->get_detail_kustom($id);
        $d['id_asset'] = $id;

        $this->load->view($this->template . 'detail_modal', $d);
    }
}