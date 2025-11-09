<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_kategori extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['master/m_master_kategori']);
        $this->table = $this->m_master_kategori->table;
        $this->pk_id = $this->m_master_kategori->pk_id;
        $this->template = 'master/master_kategori/';
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = $this->uri . '/save/' . $id;
        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $d = _post();
        // Opsional: Paksa kode kategori jadi huruf besar semua
        if (isset($d['kategori_kd'])) {
            $d['kategori_kd'] = strtoupper($d['kategori_kd']);
        }

        $w = ($id != '' ? [$this->pk_id => $id] : null);

        if ($id == null) {
            $d['deleted_st'] = 0;
            // $d['created_by'] = $this->session->userdata('user_id'); // Aktifkan nanti
            DB::insert($this->table, $d);
            _json(_response('01', $this->uri));
        } else {
            // $d['updated_by'] = $this->session->userdata('user_id'); // Aktifkan nanti
            DB::update($this->table, $d, $w);
            _json(_response('02', $this->uri));
        }
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $w);
        _json(_response('03', $this->uri));
    }

    public function ajax_datatables()
    {
        $this->m_master_kategori->load_datatables();
    }
}