<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseController
{
    public function index()
    {
        $data = [
            ['Location', 'Cases'],
            ['Kabupaten Bandung', 120],
            ['Kabupaten Bogor', 95],
            ['Kabupaten Bekasi', 75],
            ['Kota Jakarta Selatan', 150],
            ['Kota Surabaya', 200]
        ];


        return view('geochart', ['chartData' => json_encode($data)]);
    }
}
