<?php

namespace Nsulistiyawan\Bpjs\Antrean;

use Nsulistiyawan\Bpjs\BpjsServiceAntrean;

class Dashboard extends BpjsServiceAntrean
{
  public function pertanggal($tanggal, $jenis)
  {
    $response = $this->get('dashboard/waktutunggu/tanggal/' . $tanggal . '/waktu/' . $jenis, false);
    return json_decode($response, true);
  }

  public function perbulan($bulan, $tahun, $waktu)
  {
    $response = $this->get('dashboard/waktutunggu/bulan/' . $bulan . '/tahun/' . $tahun . '/waktu/' . $waktu, false);
    return json_decode($response, true);
  }
}
