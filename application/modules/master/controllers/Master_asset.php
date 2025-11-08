<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_asset extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['master/m_master_asset']);
        $this->table = $this->m_master_asset->table;
        $this->pk_id = $this->m_master_asset->pk_id;
        // Sesuaikan path ini dengan struktur folder view kamu
        $this->template = 'master/master_asset/'; 
    }

    public function index()
    {
        $d = [];
        $this->render($this->template . 'index', $d);
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = $this->uri . '/save/' . $id;

        // Ambil data untuk dropdown
        $d['list_kategori'] = $this->db->where('deleted_st', 0)->get('mst_kategori')->result_array();
        $d['list_satuan']   = $this->db->where('deleted_st', 0)->get('mst_satuan')->result_array();

        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $d = _post();
        if ($id == null) {
            // Jika SKU kosong, generate otomatis
            if (empty($d['asset_kode'])) {
                $prefix = $this->m_master_asset->get_kategori_prefix($d['kategori_id']);
                if ($prefix) {
                    $d['asset_kode'] = $this->m_master_asset->get_next_sku($prefix);
                } else {
                    // Fallback jika kategori tak punya prefix
                    $d['asset_kode'] = 'BRG-' . strtoupper(substr(uniqid(), -5)); 
                }
            }
            $d['deleted_st'] = 0;
        }

        $w = ($id != '' ? [$this->pk_id => $id] : null);

        if ($id == null) {
            DB::insert($this->table, $d);
            _json(_response('01', $this->uri));
        } else {
            DB::update($this->table, $d, $w);
            _json(_response('02', $this->uri));
        }
    }

    public function delete($id = null)
    {
        $w = ($id != '' ? [$this->pk_id => $id] : null);
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', $this->uri));
    }

    public function ajax_datatables()
    {
        $this->m_master_asset->load_datatables();
    }

    // API untuk dipanggil via AJAX dari form_modal
    public function get_sku_ajax()
    {
        $kategori_id = $this->input->post('kategori_id');
        $prefix = $this->m_master_asset->get_kategori_prefix($kategori_id);
        $new_sku = ($prefix) ? $this->m_master_asset->get_next_sku($prefix) : '';
        echo json_encode(['new_sku' => $new_sku]);
    }
}