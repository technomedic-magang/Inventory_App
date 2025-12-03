<?php

namespace Nsulistiyawan\Bpjs\Antrean;

use Nsulistiyawan\Bpjs\BpjsServiceAntrean;

class Antrean extends BpjsServiceAntrean
{
  public function tambahAntrean($data)
  {
    $response = $this->post('antrean/add', $data);
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

  public function tambahAntreanFarmasi($data)
  {
    $response = $this->post('antrean/farmasi/add', $data);
    return json_decode($response, true);
  }
}
