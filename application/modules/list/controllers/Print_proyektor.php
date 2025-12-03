<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_proyektor extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model baru
        _models(['list/m_print_proyektor']); 
        // Set path view baru
        $this->template = 'list/list_print_proyektor/'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        $this->m_print_proyektor->load_datatables();
    }

    // Modal detail (standar)
    public function detail_modal($id = null)
    {
        $d['main'] = DB::get('mst_asset', ['asset_id' => $id]);
        $d['detail_kustom'] = $this->m_print_proyektor->get_detail_kustom($id);
        $d['id_asset'] = $id;
        $this->load->view($this->template . 'detail_modal', $d);
    }
}