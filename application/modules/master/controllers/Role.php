<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    // @model
    _models(['master/m_role']);
    // @table
    $this->table = $this->m_role->table;
    $this->pk_id = $this->m_role->pk_id;
    // @params
    $this->template = 'master/role/';
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
    $this->render($this->template . 'form_modal', $d);
  }

  public function form_permission_modal($id = null)
  {
    $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
    $d['form_act'] = $this->uri . '/save_permissions/' . $id;
    $this->render($this->template . 'form_permission_modal', $d);
  }

  public function save($id = null)
  {
    $d = _post();
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

  public function save_permissions($id = null)
  {
    $d = _post();
    $this->m_role->save_permissions($d);
    _json(_response('01', $this->uri));
  }

  public function delete($id = null)
  {
    $w = ($id != '' ? [$this->pk_id => $id] : null);
    DB::delete($this->table, $w);
    _json(_response('03', $this->uri));
  }

  public function ajax_datatables()
  {
    $this->m_role->load_datatables();
  }

  public function ajax_datatables_permissions($id = null)
  {
    $this->m_role->load_datatables_permissions($id);
  }
}
