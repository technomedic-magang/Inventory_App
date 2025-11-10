<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Identitas extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    // @params
    $this->template = 'master/identitas/';
  }

  public function index()
  {
    $d['main'] = $this->m_app->identitas_get();
    $d['all_pegawai'] = DB::all('mst_pegawai', ['active_st' => 1]);
    $d['form_act'] = $this->uri . '/save';
    $this->render($this->template . 'index', $d);
  }

  public function save()
  {
    $d = _post();

    $logo = upload_base64('logo');
    if ($logo != null) $d['logo'] = $logo;

    $photo = upload_base64('photo');
    if ($photo != null) $d['photo'] = $photo;

    $background = upload_base64('background');
    if ($background != null) $d['background'] = $background;

    $kop_surat = upload_base64('kop_surat');
    if ($kop_surat != null) $d['kop_surat'] = $kop_surat;

    DB::update('mst_identitas', $d, ['identitas_id' => '1']);
    _json(_response('02', $this->uri));
  }
}
