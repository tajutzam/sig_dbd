<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kecamatan;
use CodeIgniter\HTTP\ResponseInterface;

class KecamatanController extends BaseController
{




    public function index()
    {
        $model = new Kecamatan();
        $data['kecamatans'] = $model->findAll();
        return view("/pages/kecamatan/index", $data);
    }
}
