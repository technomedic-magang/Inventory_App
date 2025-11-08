<?php

namespace Nsulistiyawan\Bpjs\VClaim;

use Nsulistiyawan\Bpjs\BpjsService;

class Rujukan extends BpjsService
{

    public function insertRujukan($data = [])
    {
        $response = $this->post('Rujukan/insert', $data);
        return json_decode($response, true);
    }
    public function updateRujukan($data = [])
    {
        $response = $this->put('Rujukan/update', $data);
        return json_decode($response, true);
    }
    public function deleteRujukan($data = [])
    {
        $response = $this->delete('Rujukan/delete', $data);
        return json_decode($response, true);
    }

    public function insertRujukan2($data = [])
    {
        $response = $this->post('Rujukan/2.0/insert', $data);
        return json_decode($response, true);
    }
    public function updateRujukan2($data = [])
    {
        $response = $this->put('Rujukan/2.0/Update', $data);
        return json_decode($response, true);
    }

    public function cariByNoRujukan($searchBy, $keyword)
    {
        if ($searchBy == 'RS') {
            $url = 'Rujukan/RS/' . $keyword;
        } else {
            $url = 'Rujukan/' . $keyword;
        }
        $response = $this->get($url);
        return json_decode($response, true);
    }

    public function cariByNoKartu($searchBy, $keyword, $multi = false)
    {
        $record = $multi ? 'List/' : '';
        if ($searchBy == 'RS') {
            $url = 'Rujukan/RS/Peserta/' . $keyword;
        } else {
            $url = 'Rujukan/' . $record . 'Peserta/' . $keyword;
        }
        $response = $this->get($url);
        return json_decode($response, true);
    }

    public function cariByTglRujukan($searchBy, $keyword)
    {
        if ($searchBy == 'RS') {
            $url = 'Rujukan/RS/TglRujukan/' . $keyword;
        } else {
            $url = 'Rujukan/List/Peserta/' . $keyword;
        }
        $response = $this->get($url);
        return json_decode($response, true);
    }

    public function listSpesialistik($kodePPK, $tanggal)
    {
        $url = 'Rujukan/ListSpesialistik/PPKRujukan/' . $kodePPK . '/TglRujukan/' . $tanggal;
        $response = $this->get($url);
        return json_decode($response, true);
    }

    function listRujukanKeluarRS($tglAwal, $tglAkhir)
    {
        $response = $this->get('Rujukan/Keluar/List/tglMulai/' . $tglAwal . '/tglAkhir/' . $tglAkhir);
        return json_decode($response, true);
    }

    function cariRujukanKeluarRSByNoRujukan($noRujukan)
    {
        $response = $this->get('Rujukan/Keluar/' . $noRujukan);
        return json_decode($response, true);
    }
}
