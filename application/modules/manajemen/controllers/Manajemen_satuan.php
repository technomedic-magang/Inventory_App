<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manajemen_satuan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['manajemen/m_manajemen_satuan']);
        $this->table = $this->m_manajemen_satuan->table;
        $this->pk_id = $this->m_manajemen_satuan->pk_id;
        $this->template = 'manajemen/manajemen_satuan/';
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
        $w = ($id != '' ? [$this->pk_id => $id] : null);

        if ($id == null) {
            $d['deleted_st'] = 0;
            DB::insert($this->table, $d);
            _json(_response('01', $this->uri));
        } else {
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
        $this->m_manajemen_satuan->load_datatables();
    }
}