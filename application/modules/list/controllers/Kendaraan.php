<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kendaraan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['list/m_kendaraan']); 
        $this->template = 'list/list_kendaraan/'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        $this->m_kendaraan->load_datatables();
    }

    public function detail_modal($id = null)
    {
        $d['main'] = DB::get('mst_asset', ['asset_id' => $id]);
        $d['detail_kustom'] = $this->m_kendaraan->get_detail_kustom($id);
        $d['id_asset'] = $id;
        $this->load->view($this->template . 'detail_modal', $d);
    }
}