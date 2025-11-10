<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendidikan extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    // @model
    _models(['master/m_pendidikan']);
    // @table
    $this->table = $this->m_pendidikan->table;
    $this->pk_id = $this->m_pendidikan->pk_id;
    // @params
    $this->template = 'master/pendidikan/';
  }

  public function index()
  {
    $d = [];
    $this->render($this->template . 'index', $d);
  }

  public function form_modal($id = null)
  {
    $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
    $d['parent'] = DB::all($this->table, ['deleted_st' => '0', 'active_st' => '1']);
    $d['form_act'] = $this->uri . '/save/' . $id;
    $this->render($this->template . 'form_modal', $d);
  }

  public function save($id = null)
  {
    $d = _post();
    // condition
    if (@$d['module_st'] == 1) {
      $d['module_id'] = @$d['pendidikan_id'];
    }
    // /end condition
    $w = ($id != '' ? [$this->pk_id => $id] : null);
    if ($id == null) {
      if (DB::valid_id($this->table, @$this->pk_id, @$d[@$this->pk_id]) == true) {
        _json(_response('20', $this->uri));
      } else {
        DB::insert($this->table, $d, $w);
        _json(_response('01', $this->uri));
      }
    } else {
      DB::update($this->table, $d, $w);
      _json(_response('02', $this->uri));
    }
  }

  public function delete($id = null)
  {
    $w = ($id != '' ? [$this->pk_id => $id] : null);
    DB::delete($this->table, $w);
    _json(_response('03', $this->uri));
  }

  public function ajax_datatables()
  {
    $this->m_pendidikan->load_datatables();
  }
}
