<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manajemen_kategori extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['manajemen/m_manajemen_kategori']);
        $this->table = $this->m_manajemen_kategori->table;
        $this->pk_id = $this->m_manajemen_kategori->pk_id;
        $this->template = 'manajemen/manajemen_kategori/';
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    // form_modal tidak perlu load 'list_atribut' lagi
    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = $this->uri . '/save/' . $id;
        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $d = _post();
        
        $data_kategori = [
            'kategori_kd' => strtoupper($d['kategori_kd']),
            'kategori_nm' => $d['kategori_nm'],
            'kategori_tipe' => $d['kategori_tipe'],
            'active_st' => $d['active_st']
        ];
        
        $w = ($id != '' ? [$this->pk_id => $id] : null);

        if ($id == null) {
            $data_kategori['deleted_st'] = 0;
            $data_kategori['created_by'] = 'PEGAWAI TESTER';
            DB::insert($this->table, $data_kategori);
        } else {
            $data_kategori['updated_by'] = 'PEGAWAI TESTER';
            DB::update($this->table, $data_kategori, $w);
        }
       
        _json(_response('01', $this->uri));
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $w);
        _json(_response('03', $this->uri));
    }

    public function ajax_datatables()
    {
        $this->m_manajemen_kategori->load_datatables();
    }
}