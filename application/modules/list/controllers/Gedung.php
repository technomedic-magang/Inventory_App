<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gedung extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['list/m_gedung']); 
        $this->template = 'list/list_gedung/'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        $this->m_gedung->load_datatables();
    }

    public function detail_modal($id = null)
    {
        // Ambil data utama
        $d['main'] = DB::get('mst_asset', ['asset_id' => $id]);
        
        // Ambil data kustom
        $d['detail_kustom'] = $this->m_gedung->get_detail_kustom($id);

        // [PERBAIKAN] Kirim ID aset secara eksplisit ke view
        // Agar view tidak perlu mencarinya di URL (yang menyebabkan error)
        $d['id_asset'] = $id;

        $this->load->view($this->template . 'detail_modal', $d);
    }
}