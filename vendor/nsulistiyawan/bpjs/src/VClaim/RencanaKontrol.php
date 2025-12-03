<?php

namespace Nsulistiyawan\Bpjs\VClaim;

use Nsulistiyawan\Bpjs\BpjsService;

class RencanaKontrol extends BpjsService
{
    public function cariSEP($keyword)
    {
        $response = $this->get('RencanaKontrol/nosep/' . $keyword);
        return json_decode($response, true);
    }

    public function insertRencanaKontrol($data = [])
    {
        $response = $this->post('RencanaKontrol/insert', $data);
        return json_decode($response, true);
    }

    public function updateRencanaKontrol($data = [])
    {
        $response = $this->put('RencanaKontrol/Update', $data);
        return json_decode($response, true);
    }

    public function deleteRencanaKontrol($data = [])
    {
        $response = $this->delete('RencanaKontrol/Delete', $data);
        return json_decode($response, true);
    }

    public function cariSuratKontrol($keyword)
    {
        $response = $this->get('RencanaKontrol/noSuratKontrol/' . $keyword);
        return json_decode($response, true);
    }

    public function listSuratKontrolBerdasarkanNoKartu($Bulan, $Tahun, $Nokartu, $filter)
    {
        $response = $this->get('RencanaKontrol/ListRencanaKontrol/Bulan/' . $Bulan . '/Tahun/' . $Tahun . '/Nokartu/' . $Nokartu . '/filter/' . $filter);
        return json_decode($response, true);
    }

    public function listSuratKontrol($tglAwal, $tglAkhir, $filter)
    {
        $response = $this->get('RencanaKontrol/ListRencanaKontrol/tglAwal/' . $tglAwal . '/tglAkhir/' . $tglAkhir . '/filter/' . $filter);
        return json_decode($response, true);
    }

    public function listPoliSpesialistik($jnsKontrol, $nomor, $tanggal)
    {
        $response = $this->get('RencanaKontrol/ListSpesialistik/JnsKontrol/' . $jnsKontrol . '/nomor/' . $nomor . '/TglRencanaKontrol/' . $tanggal);
        return json_decode($response, true);
    }

    public function listDokter($jnsKontrol, $kdPoli, $tanggal)
    {
        $response = $this->get('RencanaKontrol/JadwalPraktekDokter/JnsKontrol/' . $jnsKontrol . '/KdPoli/' . $kdPoli . '/TglRencanaKontrol/' . $tanggal);
        return json_decode($response, true);
    }

    public function insertRencanaInap($data = [])
    {
        $response = $this->post('RencanaKontrol/InsertSPRI', $data);
        return json_decode($response, true);
    }

    public function updateRencanaInap($data = [])
    {
        $response = $this->put('RencanaKontrol/UpdateSPRI', $data);
        return json_decode($response, true);
    }

    public function cariSuratInap($keyword)
    {
        $response = $this->get('RencanaKontrol/noSuratKontrol/' . $keyword);
        return json_decode($response, true);
    }
}
