<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    _models([
      'm_dashboard',
      // 'kepegawaian/m_kehadiran',
      // 'kepegawaian/m_kegiatan',
      // 'kepegawaian/m_kegiatan'
    ]);
  }

  function index()
  {
    $d['tahun'] = date('Y');
    $d['bulan'] = date('m');
    $d['tgl_awal'] = date('Y-m-01');
    $d['tgl_total'] = date('t', strtotime($d['tgl_awal']));


    if (_ses_get('role_tp') == '01') {
      $d['pegawai'] = $this->m_dashboard->pegawai_get();
      // $d['kehadiran'] = $this->m_kehadiran->get_kehadiran_pegawai_by_date(_ses_get('pegawai_id'), date('Y-m-d'));
      // $d['kegiatan'] = $this->m_kegiatan->get_kegiatan_pegawai_by_date(_ses_get('pegawai_id'), date('Y-m-d'));
      // $d['all_kehadiran'] = $this->m_kehadiran->all_kehadiran_by_pegawai_bulan(_ses_get('pegawai_id'), date('Y'), date('m'));
      // $d['all_kegiatan'] = $this->m_kegiatan->all_data(['all_data_st' => 0], true);

      // $this->load->library('calendar');
      // $calendar = new Calendar($d['tahun'] . '-' . $d['bulan'] . '-01');
      // for ($i = 0; $i < $d['tgl_total']; $i++) {
      //   $date = date('Y-m-d', strtotime($d['tgl_awal'] . ' + ' . $i . ' days'));
      //   $kegiatan = DB::get('peg_kegiatan', [
      //     'pegawai_id' => _ses_get('pegawai_id'),
      //     'kegiatan_tgl' => $date,
      //   ]);
      //   if ($kegiatan == null) {
      //     $calendar->add_event('<i class="fas fa-times-circle me-2"></i>Kosong', $date, 1, 'red');
      //   } else {
      //     $calendar->add_event('<i class="fas fa-check-circle me-2"></i>Terisi', $date, 1, 'green');
      //   }
      // }

      // $d['calendar'] = $calendar;

      $this->render('app/dashboard/index_pegawai', $d);
    }

    if (_ses_get('role_tp') == '02') {
      $d['magang'] = $this->m_dashboard->magang_get();
      $d['kehadiran'] = null;
      $d['all_kehadiran'] = null;

      $this->load->library('calendar');
      $calendar = new Calendar($d['tahun'] . '-' . $d['bulan'] . '-01');
      for ($i = 0; $i < $d['tgl_total']; $i++) {
        $date = date('Y-m-d', strtotime($d['tgl_awal'] . ' + ' . $i . ' days'));
        // $kegiatan = DB::get('peg_kegiatan', [
        //   'pegawai_id' => _ses_get('pegawai_id'),
        //   'kegiatan_tgl' => $date,
        // ]);
        $kegiatan = null;
        if ($kegiatan == null) {
          $calendar->add_event('<i class="fas fa-times-circle me-2"></i>Kosong', $date, 1, 'red');
        } else {
          // $calendar->add_event('<i class="fas fa-check-circle me-2"></i>Terisi', $date, 1, 'green');
        }
      }
      $d['calendar'] = $calendar;

      $this->render('app/dashboard/index_magang', $d);
    }
  }
}
