<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manajemen_gudang extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['manajemen/m_manajemen_gudang']);
        $this->table = $this->m_manajemen_gudang->table;
        $this->pk_id = $this->m_manajemen_gudang->pk_id;
        $this->template = 'manajemen/manajemen_gudang/';
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = $this->uri . '/save/' . $id;
        
        // Gunakan kunci array baru: 'gudang_kd'
        if ($id == null) {
            $d['main']['gudang_kd'] = $this->m_manajemen_gudang->get_next_kode_gudang();
        }
        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $d = _post();
        $w = ($id != '' ? [$this->pk_id => $id] : null);

        if ($id == null) {
            // Gunakan kunci array baru: 'gudang_kd'
            if (empty($d['gudang_kd'])) {
                $d['gudang_kd'] = $this->m_manajemen_gudang->get_next_kode_gudang();
            }
            $d['deleted_st'] = 0;
            DB::insert($this->table, $d);
            _json(_response('01', $this->uri));
        } else {
            DB::update($this->table, $d, $w);
            _json(_response('02', $this->uri));
        }
    }

    // ... fungsi delete & ajax_datatables TETAP SAMA ...
    public function delete($id = null) {
        $w = ($id != '' ? [$this->pk_id => $id] : null);
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', $this->uri));
    }
    public function ajax_datatables() { $this->m_manajemen_gudang->load_datatables(); }
}