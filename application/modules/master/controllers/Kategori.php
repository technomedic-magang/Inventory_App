<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends MY_Controller
{
    // Definisi path view dan URI secara eksplisit
    protected $view_path = 'master/kategori/';
    protected $uri_path  = 'master/kategori';

    public function __construct()
    {
        parent::__construct();
        _models(['master/m_kategori']);
        
        // Mapping model ke properti controller
        $this->model = $this->m_kategori;
        $this->table = $this->model->table;
        $this->pk_id = $this->model->pk_id;
    }

    public function index()
    {
        $this->render($this->view_path . 'index');
    }

    public function form_modal($id = null)
    {
        $data = [];
        
        // Ambil data jika sedang edit
        $data['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $data['form_act'] = site_url($this->uri_path . '/save/' . $id);
        
        $this->render($this->view_path . 'form_modal', $data);
    }

    public function save($id = null)
    {
        $input = _post();
        
        // Normalisasi data input
        $data_kategori = [
            'kategori_kd'   => strtoupper($input['kategori_kd']),
            'kategori_nm'   => $input['kategori_nm'],
            'kategori_tipe' => $input['kategori_tipe'],
            'active_st'     => $input['active_st']
        ];
        
        // Pisahkan logika Insert dan Update (Guard Clause)
        if (!empty($id)) {
            return $this->_update_existing($id, $data_kategori);
        }

        return $this->_insert_new($data_kategori);
    }

    public function delete($id = null)
    {
        if (empty($id)) return;

        $where = [$this->pk_id => $id];
        $data  = ['deleted_st' => 1, 'active_st' => 0];
        
        DB::update($this->table, $data, $where);
        _json(_response('03', site_url($this->uri_path)));
    }

    public function ajax_datatables()
    {
        $this->model->load_datatables();
    }

    // --- Private Methods ---

    private function _insert_new($data)
    {
        $data['deleted_st'] = 0;
        // Menggunakan session user ID jika tersedia, fallback ke string statis jika belum ada auth
        $data['created_by'] = $this->session->userdata('user_id') ?? 'PEGAWAI TESTER';
        
        DB::insert($this->table, $data);
        _json(_response('01', site_url($this->uri_path)));
    }

    private function _update_existing($id, $data)
    {
        $where = [$this->pk_id => $id];
        $data['updated_by'] = $this->session->userdata('user_id') ?? 'PEGAWAI TESTER';
        
        DB::update($this->table, $data, $where);
        _json(_response('02', site_url($this->uri_path)));
    }
}