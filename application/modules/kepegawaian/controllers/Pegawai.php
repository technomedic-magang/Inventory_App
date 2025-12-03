<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    // @model
    _models(['m_pegawai']);
    // @table
    $this->table = $this->m_pegawai->table;
    $this->pk_id = $this->m_pegawai->pk_id;
    // @params
    $this->template = 'pegawai/';
  }

  public function index()
  {
    $d['all_jabatan'] = DB::all('mst_jabatan');
    $d['all_divisi'] = DB::all('mst_divisi', null, ['divisi_id', 'ASC']);
    $d['active_st'] = (@$this->nav_sess['search']['data']['active_st'] != "") ? $this->nav_sess['search']['data']['active_st'] : '1';
    $this->render($this->template . 'index', $d);
  }

  public function form_modal($id = null)
  {
    $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
    $d['all_jabatan'] = DB::all('mst_jabatan');
    $d['all_divisi'] = DB::all('mst_divisi', null, ['divisi_id', 'ASC']);
    $d['all_pendidikan'] = DB::all('mst_pendidikan');
    $d['form_act'] = $this->uri . '/save/' . $id;
    $this->render($this->template . 'form_modal', $d);
  }

  public function form_auth_modal($id = null)
  {
    $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
    $d['user'] = DB::get('app_user', ['user_id' => $d['main']['user_id']]);
    $d['all_role'] = DB::all('app_role', ['deleted_st' => '0', 'active_st' => '1']);
    $d['form_act'] = $this->uri . '/save_auth/' . $id;
    $this->render($this->template . 'form_auth_modal', $d);
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
    $d['pegawai_nm'] = strtoupper($d['pegawai_nm']);
    $d['pendek_nm'] = strtoupper($d['pendek_nm']);
    $d['lahir_tmp'] = strtoupper($d['lahir_tmp']);
    $d['lahir_tgl'] = to_date($d['lahir_tgl'], '-', 'date');
    $d['pegawai_tmt'] = to_date($d['pegawai_tmt'], '-', 'date');
    if ($d['pegawai_tat'] != '') {
      $d['pegawai_tat'] = to_date($d['pegawai_tat'], '-', 'date');
    }

    $ttd = upload_base64('ttd');
    if ($ttd != null) $d['ttd'] = $ttd;

    $w = ($id != '' ? [$this->pk_id => $id] : null);
    if ($id == null) {
      $d['pegawai_id'] = DB::get_id('mst_pegawai', 2, 12);
      if (DB::valid_id($this->table, @$this->pk_id, @$d[@$this->pk_id]) == true) {
        _json(_response('20', $this->uri));
      } else {
        $d['user_id'] = 'P' . $d['pegawai_id'];
        DB::insert($this->table, $d, $w);

        // Make user 
        $dUser = array(
          'user_id' => $d['user_id'],
          'auth_nm' => $d['user_id'],
          'auth_hash' => password_hash('123456', PASSWORD_BCRYPT, ['cost' => 12]),
          'role_id' => '01.04',
        );

        DB::insert('app_user', $dUser);

        _json(_response('01', $this->uri));
      }
    } else {
      DB::update($this->table, $d, $w);
      _json(_response('02', $this->uri));
    }
  }

  public function save_auth($id = null)
  {
    $d = _post();
    $pegawai = DB::get('mst_pegawai', [$this->pk_id => $id]);
    $check_user_nm = DB::raw('row_array', "SELECT * FROM mst_pegawai WHERE user_nm = '" . $d['user_nm'] . "' AND pegawai_id != '$id'");

    if ($check_user_nm != null) {
      _json(_response('29', $this->uri, [
        'message' => 'Username sudah digunakan pegawai lain!'
      ]));
    } else {
      if ($d['password'] != $d['password_repeat']) {
        _json(_response('29', $this->uri, [
          'message' => 'Password tidak sama!'
        ]));
      } else {
        $dUser = array(
          'role_id' => $d['role_id'],
        );

        if ($d['password'] == '') {
          $dUser['auth_nm'] = $d['user_nm'];
          $dUser['auth_hash'] = password_hash($d['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        }
        
        DB::update('app_user', $dUser, ['user_id' => $pegawai['user_id']]);
        _json(_response('02', $this->uri));
      }
    }
  }

  public function save_permissions($id = null)
  {
    $d = _post();
    $this->m_pegawai->save_permissions($d);
    _json(_response('01', $this->uri));
  }

  public function delete($id = null)
  {
    $w = ($id != '' ? [$this->pk_id => $id] : null);
    DB::update(
      $this->table,
      ['active_st' => 0],
      $w
    );
    _json(_response('03', $this->uri));
  }

  public function ajax_datatables()
  {
    $this->m_pegawai->load_datatables();
  }

  public function ajax_datatables_permissions($id = null)
  {
    $this->m_pegawai->load_datatables_permissions($id);
  }
}
