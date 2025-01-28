<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kecamatan;
use App\Models\Puskesmas;
use CodeIgniter\HTTP\ResponseInterface;

class PuskesmasController extends BaseController
{
    public function index()
    {
        //
        $model = new Puskesmas();
        $data['puskesmas'] = $model->getPuskesmasWithKecamatan();
        return view("/pages/puskesmas/index", $data);
    }

    public function create()
    {
        $kecamatanModel = new Kecamatan();
        $data['kecamatan'] =  $kecamatanModel->findAll();
        return view('/pages/puskesmas/create', $data);
    }

    public function store()
    {
        $validation = $this->validate([
            'kecamatan_id' => 'required',
            'nama_puskesmas' => 'required',
            'latitude' => 'required|decimal',
            'longitude' => 'required|decimal',
        ]);

        $model = new Puskesmas();

        if (!$validation) {
            $errorMessages = implode(', ', $this->validator->getErrors());
            session()->setFlashdata('error', $errorMessages);
            return redirect()->back()->withInput();
        }

        $model->insert(
            [
                'kecamatan_id' => $this->request->getPost('kecamatan_id'),
                'nama_puskesmas' => $this->request->getPost('nama_puskesmas'),
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
            ]
        );


        return redirect()->to(base_url('/admin/puskesmas'))->with('success', 'berhasil menambahkan data puskesmas');
    }


    public function update($id)
    {
        // Validasi input
        $validation = $this->validate([
            'kecamatan_id' => 'required',
            'nama_puskesmas' => 'required',
            'latitude' => 'required|decimal',
            'longitude' => 'required|decimal',
        ]);

        // Model Puskesmas
        $model = new Puskesmas();

        // Jika validasi gagal
        if (!$validation) {
            $errorMessages = implode(', ', $this->validator->getErrors());
            session()->setFlashdata('error', $errorMessages);
            return redirect()->back()->withInput();
        }

        // Cari data puskesmas berdasarkan ID
        $puskesmas = $model->find($id);

        if (!$puskesmas) {
            session()->setFlashdata('error', 'Data Puskesmas tidak ditemukan');
            return redirect()->to(base_url('/admin/puskesmas'));
        }

        // Perbarui data puskesmas
        $model->update($id, [
            'kecamatan_id' => $this->request->getPost('kecamatan_id'),
            'nama_puskesmas' => $this->request->getPost('nama_puskesmas'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
        ]);

        return redirect()->to(base_url('/admin/puskesmas'))->with('success', 'Berhasil memperbarui data puskesmas');
    }

    public function edit($id)
    {
        $model = new Puskesmas();
        $kecamatanModel = new Kecamatan();
        $data['puskesmas'] = $model->findPuskesmasWithKecamatan($id);
        $data['kecamatan'] = $kecamatanModel->findAll();
        if (!$data['puskesmas']) {
            return redirect()->back()->with('error', 'data puskesmas tidak ditemukan!');
        }

        return view('/pages/puskesmas/edit', $data);
    }

    public function delete($id)
    {
        $model = new Puskesmas();

        $data['puskesmas'] = $model->findPuskesmasWithKecamatan($id);

        if (!$data['puskesmas']) {
            return redirect()->back()->with('error', 'data puskesmas tidak ditemukan!');
        }

        $model->delete($id);
        return redirect()->back()->with('success', 'berhasil menghapus data puskesmas');
    }
}
