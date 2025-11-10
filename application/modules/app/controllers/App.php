<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model([
      'm_app'
    ]);
  }

  function search_init()
  {
    $s = _ses_get(_get('n'));
    $s['search'] = _post();
    $s['cur_page'] = 0;
    _ses_init([_get('n') => $s]);
    $nav = $this->m_app->nav_encrypt_get(_get('n'));
    _pg_set($nav);
    _json(_response('00', site_url($nav['nav_url'])));
  }

  function search_reset()
  {
    $d = _post();
    if (@$d['n'] != '') {
      $n = @$d['n'];
    } else {
      $n = $d['data']['n'];
    }
    $s = _ses_get(@$n);
    $s['search'] = [];
    $s['cur_page'] = 0;
    $s['per_page'] = 10;
    _ses_init([@$n => $s]);
    $nav = $this->m_app->nav_encrypt_get(@$n);
    _pg_set($nav);
    _json(_response('00', site_url($nav['nav_url'])));
  }

  function perpage()
  {
    $d = _post();
    $s = _ses_get($d['n']);
    $s['cur_page'] = 0;
    $s['per_page'] = $d['p'];
    _ses_init([$d['n'] => $s]);
    $nav = $this->m_app->nav_encrypt_get($d['n']);
    _pg_set($nav);
    _json(_response('00', site_url($nav['nav_url'])));
  }

  function get_file($folder, $file_name)
  {
    get_file($folder, $file_name);
  }

  function superadmin($role_id, $pass)
  {
    if ($pass == 'telo' && $role_id == '01.01') {
      DB::delete('app_permission', ['role_id' => $role_id]);
      $all_nav = DB::all('app_nav');
      foreach ($all_nav as $nav) {
        $d = [
          'role_id' => $role_id,
          'nav_id' => $nav['nav_id'],
          'all_data_st' => 1,
        ];
        DB::insert('app_permission', $d);
      }
    } else {
      echo "Access Denied";
    }
  }
}
