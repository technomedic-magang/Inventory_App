<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Satuan extends MY_Controller
{
    // Definisi path view dan URI agar tidak berulang (Hardcoded strings)
    protected $view_path = 'master/satuan/';
    protected $uri_path  = 'master/satuan';

    public function __construct()
    {
        parent::__construct();
        _models(['master/m_satuan']);
        
        $this->table = $this->m_satuan->table;
        $this->pk_id = $this->m_satuan->pk_id;
    }

    public function index()
    {
        $this->render($this->view_path . 'index');
    }

    public function form_modal($id = null)
    {
        $data = [];
        
        // Ambil data jika mode edit
        $data['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $data['form_act'] = site_url($this->uri_path . '/save/' . $id);
        
        $this->render($this->view_path . 'form_modal', $data);
    }

    public function save($id = null)
    {
        $input_data = _post();

        // Guard Clause: Pisahkan logika Insert dan Update
        if (!empty($id)) {
            return $this->_update_existing($id, $input_data);
        }

        return $this->_insert_new($input_data);
    }

    public function delete($id = null)
    {
        if (empty($id)) return;

        // Soft delete: set deleted = 1 dan non-aktifkan
        $where = [$this->pk_id => $id];
        $data  = ['deleted_st' => 1, 'active_st' => 0];
        
        DB::update($this->table, $data, $where);
        _json(_response('03', site_url($this->uri_path)));
    }

    public function ajax_datatables()
    {
        $this->m_satuan->load_datatables();
    }

    // --- Private Methods ---

    private function _insert_new($data)
    {
        $data['deleted_st'] = 0;
        
        DB::insert($this->table, $data);
        _json(_response('01', site_url($this->uri_path)));
    }

    private function _update_existing($id, $data)
    {
        $where = [$this->pk_id => $id];
        
        DB::update($this->table, $data, $where);
        _json(_response('02', site_url($this->uri_path)));
    }
}