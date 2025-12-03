<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mabel_meja extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Memuat model khusus untuk mabel meja
        _models(['list/m_mabel_meja']); 
        // Set path view folder
        $this->template = 'list/list_mabel_meja/'; 
    }

    public function index()
    {
        // Render view index.php
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        // Panggil fungsi datatables di model
        $this->m_mabel_meja->load_datatables();
    }

    // Modal detail (standar)
    public function detail_modal($id = null)
    {
        $d['main'] = DB::get('mst_asset', ['asset_id' => $id]);
        $d['detail_kustom'] = $this->m_mabel_meja->get_detail_kustom($id);
        $d['id_asset'] = $id;
        $this->load->view($this->template . 'detail_modal', $d);
    }
}