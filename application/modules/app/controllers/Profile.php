<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    // @params
    $this->template = 'app/profile/';
  }

  public function form_modal()
  {
    $pegawai_id = _ses_get('pegawai_id');
    $d['all_pendidikan'] = DB::all('mst_pendidikan');
    $d['main'] = DB::raw(
      'row_array',
      "SELECT 
          a.*
        FROM 
          mst_pegawai a
        WHERE a.pegawai_id = '$pegawai_id'"
    );
    $d['form_act'] = site_url('app/profile/save');
    $this->render($this->template . 'form_modal', $d);
  }

  public function save()
  {
    $d = _post();

    $d['pegawai_nm'] = strtoupper($d['pegawai_nm']);
    $d['lahir_tmp'] = strtoupper($d['lahir_tmp']);
    $d['lahir_tgl'] = to_date($d['lahir_tgl'], '-', 'date');

    $ttd = upload_base64('ttd');
    if ($ttd != null) $d['ttd'] = $ttd;

    if (($d['password'] != '') && ($d['password'] == $d['password_repeat'])) {
      $d['user_hash'] = hash_password($d['password']);
    }

    $d = _frm_unset($d, ['password', 'password_repeat']);

    DB::update('mst_pegawai', $d, ['pegawai_id' => _ses_get('pegawai_id')]);

    _json(_response('02', $this->uri));
  }
}
