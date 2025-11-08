<?php

namespace Nsulistiyawan\Bpjs\Antrean;

use Nsulistiyawan\Bpjs\BpjsServiceAntrean;

class Referensi extends BpjsServiceAntrean
{
    public function poli()
    {
        $response = $this->get('ref/poli');
        return json_decode($response, true);
    }

    public function dokter()
    {
        $response = $this->get('ref/dokter');
        return json_decode($response, true);
    }

    public function jadwalDokter($kodepoli, $tanggal)
    {
        $response = $this->get('jadwaldokter/kodepoli/' . $kodepoli . '/tanggal/' . $tanggal);
        return json_decode($response, true);
    }
}
