<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataKasusDbd;
use App\Models\Puskesmas;
use App\Models\Tahun;
use CodeIgniter\HTTP\ResponseInterface;

class DataKasusDbdController extends BaseController
{
    public function index()
    {
        //
        $model = new DataKasusDbd();
        $data['kasus_dbd'] = $model->select('data_kasus_dbd.*, tahun.tahun, puskesmas.nama_puskesmas')
            ->join('tahun', 'tahun.id = data_kasus_dbd.tahun_id')
            ->join('puskesmas', 'puskesmas.id = data_kasus_dbd.puskesmas_id')
            ->findAll();
        return view('/pages/data-kasus/index', $data);
    }

    public function create()
    {
        $tahunModel = new Tahun();
        $puskesmasModel = new Puskesmas();

        // Ambil data tahun dan puskesmas
        $data['tahun'] = $tahunModel->findAll();
        $data['puskesmas'] = $puskesmasModel->findAll();

        return view('/pages/data-kasus/create', $data);
    }


    public function store()
    {
        // Validasi input
        $validation = $this->validate([
            'tahun_id' => 'required',
            'puskesmas_id' => 'required|is_not_unique[puskesmas.id]',
            'jumlah_penduduk' => 'required|numeric',
            'jumlah_kasus' => 'required|numeric',
            'jumlah_kematian' => 'required|numeric',
            'jumlah_rumah_diperiksa' => 'required|numeric',
            'jumlah_rumah_bebas_jentik' => 'required|numeric',
        ]);

        if (!$validation) {
            $errorMessages = implode(', ', $this->validator->getErrors());
            session()->setFlashdata('error', $errorMessages);
            return redirect()->back()->withInput();
        }

        // Model untuk menyimpan data kasus_dbd
        $model = new DataKasusDbd();

        // Simpan data
        $model->insert([
            'tahun_id' => $this->request->getPost('tahun_id'),
            'puskesmas_id' => $this->request->getPost('puskesmas_id'),
            'jumlah_penduduk' => $this->request->getPost('jumlah_penduduk'),
            'jumlah_kasus' => $this->request->getPost('jumlah_kasus'),
            'jumlah_kematian' => $this->request->getPost('jumlah_kematian'),
            'jumlah_rumah_diperiksa' => $this->request->getPost('jumlah_rumah_diperiksa'),
            'jumlah_rumah_bebas_jentik' => $this->request->getPost('jumlah_rumah_bebas_jentik'),
        ]);

        return redirect()->to(base_url('/admin/dbd'))->with('success', 'Berhasil menambahkan data kasus DBD');
    }

    public function edit($id)
    {
        $kasusDbdModel = new DataKasusDbd();
        $tahunModel = new Tahun();
        $puskesmasModel = new Puskesmas();

        // Ambil data kasus_dbd yang ingin diedit
        $data['kasus_dbd'] = $kasusDbdModel->find($id);

        if (!$data['kasus_dbd']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data Kasus DBD dengan ID $id tidak ditemukan.");
        }

        // Ambil data tahun dan puskesmas
        $data['tahun'] = $tahunModel->findAll();
        $data['puskesmas'] = $puskesmasModel->findAll();

        return view('pages/data-kasus/edit', $data);
    }

    public function update($id)
    {
        // Validasi input
        $validation = $this->validate([
            'tahun_id' => 'required',
            'puskesmas_id' => 'required',
            'jumlah_penduduk' => 'required|numeric',
            'jumlah_kasus' => 'required|numeric',
            'jumlah_kematian' => 'required|numeric',
            'jumlah_rumah_diperiksa' => 'required|numeric',
            'jumlah_rumah_bebas_jentik' => 'required|numeric',
        ]);

        if (!$validation) {
            $errorMessages = implode(', ', $this->validator->getErrors());
            session()->setFlashdata('error', $errorMessages);
            return redirect()->back()->withInput();
        }

        $model = new DataKasusDbd();

        $model->update($id, [
            'tahun_id' => $this->request->getPost('tahun_id'),
            'puskesmas_id' => $this->request->getPost('puskesmas_id'),
            'jumlah_penduduk' => $this->request->getPost('jumlah_penduduk'),
            'jumlah_kasus' => $this->request->getPost('jumlah_kasus'),
            'jumlah_kematian' => $this->request->getPost('jumlah_kematian'),
            'jumlah_rumah_diperiksa' => $this->request->getPost('jumlah_rumah_diperiksa'),
            'jumlah_rumah_bebas_jentik' => $this->request->getPost('jumlah_rumah_bebas_jentik'),
        ]);

        return redirect()->to(base_url('/admin/dbd'))->with('success', 'Data kasus DBD berhasil diperbarui');
    }

    public function delete($id)
    {
        $model = new DataKasusDbd();

        $data['dbd'] = $model->find($id);

        if (!$data['dbd']) {
            return redirect()->back()->with('error', 'data kasus dbd tidak ditemukan!');
        }

        $model->delete($id);
        return redirect()->back()->with('success', 'berhasil menghapus data kasus dbd');
    }
}
