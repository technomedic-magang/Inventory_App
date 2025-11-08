<?php

namespace Nsulistiyawan\Bpjs\Antrean;

use Nsulistiyawan\Bpjs\BpjsServiceAntrean;

class Pendaftaran extends BpjsServiceAntrean
{
  public function antreanPerhari($tgl)
  {
    $response = $this->get('antrean/pendaftaran/tanggal/' . $tgl);
    return json_decode($response, true);
  }

  public function batalAntrean($data)
  {
    $response = $this->post('antrean/batal', $data);
    return json_decode($response, true);
  }

  public function updatewaktuantrean($data)
  {
    $response = $this->post('antrean/updatewaktu', $data);
    return json_decode($response, true);
  }

  public function getlisttask($data)
  {
    $response = $this->post('antrean/getlisttask', $data);
    return json_decode($response, true);
  }
}
