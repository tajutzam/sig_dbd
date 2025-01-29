<?php

namespace App\Controllers;

use App\Models\DataKasusDbd;
use App\Models\Kecamatan;
use App\Models\Tahun;

class Home extends BaseController
{
    public function index(): string
    {
        $tahun = new Tahun();
        $kecamatan = new Kecamatan();
        $data['tahun'] = $tahun->findAll();
        $tahunRequest = $this->request->getGet('tahun') ?? date('Y');
        $dataTahun = $tahun->where('tahun', $tahunRequest)->first();
        $data['tahunRequest'] = $tahunRequest;
        $data['kasus'] = $kecamatan->getIrCfrAbj($dataTahun['id']);
        return view('pages/dashboard/index', $data);
    }
}
