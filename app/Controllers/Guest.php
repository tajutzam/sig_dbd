<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Artikel;
use App\Models\DataKasusDbd;
use App\Models\Kecamatan;
use App\Models\Tahun;
use CodeIgniter\HTTP\ResponseInterface;

class Guest extends BaseController
{
    public function index()
    {
        //
        return view('guest/index');
    }

    public function pemetaan()
    {
        $kecamatanModel = new Kecamatan();
        $kasusDbd = new DataKasusDbd();
        $tahun = new Tahun();

        $tahunRequest = $this->request->getGet('tahun') ?? date('Y');

        $dataTahun = $tahun->where('tahun', $tahunRequest)->first();

        if (!$dataTahun) {
            return redirect()->to(base_url('/'))->with('error', 'Tidak ada data tahun sesuai request!');
        }

        $data['kecamatan'] = $kecamatanModel->findAll();
        $data['kasus'] = $kasusDbd->getKasusDbdByTahun($dataTahun['id']);
        $data['tahun'] = $tahunRequest;
        $data['tahunall'] = $tahun->findAll();

        return view('guest/pemetaan', $data);
    }


    public function artikel()
    {
        $model = new Artikel();
        $data['artikel'] = $model->findAll();
        return view('guest/artikel', $data);
    }
}
