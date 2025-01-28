<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Tahun;
use CodeIgniter\HTTP\ResponseInterface;

class TahunController extends BaseController
{
    public function index()
    {
        $model = new Tahun();
        $data['tahun'] = $model->findAll();
        return view('/pages/tahun/index', $data);
    }


    public function create()
    {
        return view('/pages/tahun/create');
    }


    public function edit($id)
    {
        $model = new Tahun();
        $tahun = $model->find($id);

        if (!$tahun) {
            return redirect()->to(base_url('/admin/tahun'))->with('error', 'Data tahun tidak ditemukan!');
        }


        $data['tahun'] = $tahun;
        return view('pages/tahun/edit', $data);
    }

    public function store()
    {
        $validation = $this->validate([
            'tahun' => 'required|is_unique[tahun.tahun]',
        ]);

        if (!$validation) {
            $errorMessages = implode(', ', $this->validator->getErrors());
            session()->setFlashdata('error', $errorMessages);
            return redirect()->back()->withInput();
        }

        $model = new Tahun();
        $model->insert(
            [
                'tahun' => $this->request->getPost('tahun')
            ]
        );

        return redirect()->to('/admin/tahun')->with('success', 'berhasil insert data tahun');
    }

    public function delete($id)
    {
        $model = new Tahun();
        $tahun = $model->find($id);

        if (!$tahun) {
            return redirect()->to(base_url('/admin/tahun'))->with('error', 'Data tahun tidak ditemukan!');
        }

        $model->delete($id);
        return redirect()->to('/admin/tahun')->with('success', 'berhasil delete data tahun');
    }


    public function update($id)
    {
        $validation = $this->validate([
            'tahun' => 'required',
        ]);

        $model = new Tahun();

        if (!$validation) {
            $errorMessages = implode(', ', $this->validator->getErrors());
            session()->setFlashdata('error', $errorMessages);
            return redirect()->back()->withInput();
        }

        $existingData = $model->find($id);

        if (!$existingData) {
            session()->setFlashdata('error', 'Data Kecamatan tidak ditemukan!');
            return redirect()->to(base_url('/admin/tahun'));
        }

        $model->update($id, ['tahun' => $this->request->getPost('tahun')]);
        return redirect()->to(base_url('/admin/tahun'))->with('success', 'berhasil update data tahun');
    }
}
