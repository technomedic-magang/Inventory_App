<?php

namespace Nsulistiyawan\Bpjs\Antrean;

use Nsulistiyawan\Bpjs\BpjsServiceAntrean;

class JadwalDokter extends BpjsServiceAntrean
{
    public function updateJadwalDokter($data)
    {
        $response = $this->post('jadwaldokter/updatejadwaldokter', $data);
        return json_decode($response, true);
    }
}
