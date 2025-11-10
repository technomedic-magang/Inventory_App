<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nav extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    // @model
    _models(['master/m_nav']);
    // @table
    $this->table = $this->m_nav->table;
    $this->pk_id = $this->m_nav->pk_id;
    // @params
    $this->template = 'master/nav/';
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
      $d['module_id'] = @$d['nav_id'];
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

  public function full_access($id = null)
  {
    if ($this->nav['all_data_st'] == 1) {

      $all_pegawai = DB::all('mst_pegawai');

      foreach ($all_pegawai as $row) {
        $check = DB::get('app_permission', [
          'pegawai_id' => $row['pegawai_id'],
          'nav_id' => $id,
        ]);

        if ($check == null) {
          DB::insert('app_permission', [
            'pegawai_id' => $row['pegawai_id'],
            'nav_id' => $id,
          ]);
        }
      }

      _json(_response('01', $this->uri));
    } else {
      _json(_response('29', $this->uri, ['message' => 'Access Denied']));
    }
  }

  public function ajax_datatables()
  {
    $this->m_nav->load_datatables();
  }
}
