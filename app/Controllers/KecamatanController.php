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

    public function create()
    {
        return view('/pages/kecamatan/create');
    }


    public function store()
    {
        $kecamatanModel = new Kecamatan();

        $validation = $this->validate([
            'kode_wilayah' => 'required',
            'nama_kecamatan' => 'required',
            'latitude' => 'required|decimal',
            'longitude' => 'required|decimal',
        ]);

        if (!$validation) {
            $errorMessages = implode(', ', $this->validator->getErrors());
            session()->setFlashdata('error', $errorMessages);
            return redirect()->back()->withInput();
        }

        $file = $this->request->getFile('file_geojson');

        $fileName = $file->getRandomName();
        $file->move(WRITEPATH . '../public/geojson', $fileName);

        $kecamatanModel->save([
            'kode_wilayah' => $this->request->getPost('kode_wilayah'),
            'nama_kecamatan' => $this->request->getPost('nama_kecamatan'),
            'file_geojson' => $fileName,
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
        ]);
        session()->setFlashdata('success', 'Data berhasil disimpan!');
        return redirect()->to(base_url('/admin/kecamatan'))->with('success', 'Data Kecamatan berhasil ditambahkan!');
    }


    public function edit($id)
    {

        $model = new Kecamatan();
        $kecamatan = $model->find($id);

        if (!$kecamatan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Kecamatan not found");
        }
        return view('/pages/kecamatan/edit', ['kecamatan' => $kecamatan]);
    }

    public function update($id)
    {
        $kecamatanModel = new Kecamatan();

        // Validate input
        $validation = $this->validate([
            'kode_wilayah' => 'required',
            'nama_kecamatan' => 'required',
            'latitude' => 'required|decimal',
            'longitude' => 'required|decimal',
        ]);

        if (!$validation) {
            $errorMessages = implode(', ', $this->validator->getErrors());
            session()->setFlashdata('error', $errorMessages);
            return redirect()->back()->withInput();
        }

        // Get the current data from the database
        $existingData = $kecamatanModel->find($id);

        if (!$existingData) {
            session()->setFlashdata('error', 'Data Kecamatan tidak ditemukan!');
            return redirect()->to(base_url('/admin/kecamatan'));
        }

        // Handle file upload
        $file = $this->request->getFile('file_geojson');
        $fileName = $existingData['file_geojson']; // Preserve existing file if no new file is uploaded

        // If a new file is uploaded, handle it
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(WRITEPATH . '../public/geojson', $fileName);
        }

        // Prepare updated data
        $kecamatanModel->update($id, [
            'kode_wilayah' => $this->request->getPost('kode_wilayah'),
            'nama_kecamatan' => $this->request->getPost('nama_kecamatan'),
            'file_geojson' => $fileName,
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
        ]);

        // Set success message and redirect
        session()->setFlashdata('success', 'Data Kecamatan berhasil diperbarui!');
        return redirect()->to(base_url('/admin/kecamatan'));
    }


    public function delete($id)
    {
        $kecamatanModel = new Kecamatan();

        $kecamatan = $kecamatanModel->find($id);

        if (!$kecamatan) {
            session()->setFlashdata('error', 'Data Kecamatan tidak ditemukan!');
            return redirect()->to(base_url('/admin/kecamatan'));
        }

        // Delete the file associated with the Kecamatan if it exists
        $filePath = WRITEPATH . '../public/geojson/' . $kecamatan['file_geojson'];
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file
        }

        // Delete the Kecamatan record from the database
        $kecamatanModel->delete($id);

        // Set success message and redirect
        session()->setFlashdata('success', 'Data Kecamatan berhasil dihapus!');
        return redirect()->to(base_url('/admin/kecamatan'));
    }
}
