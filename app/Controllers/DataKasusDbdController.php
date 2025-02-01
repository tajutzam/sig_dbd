<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataKasusDbd;
use App\Models\Puskesmas;
use App\Models\Tahun;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class DataKasusDbdController extends BaseController
{
    public function index()
    {
        //
        $model = new DataKasusDbd();
        $tahunModel = new Tahun();
        $data['kasus_dbd'] = $model->select('data_kasus_dbd.*, tahun.tahun, puskesmas.nama_puskesmas')
            ->join('tahun', 'tahun.id = data_kasus_dbd.tahun_id')
            ->join('puskesmas', 'puskesmas.id = data_kasus_dbd.puskesmas_id')
            ->findAll();

        $data['tahun'] = $tahunModel->findAll();
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

    public function export()
    {
        $model = new DataKasusDbd();
        $tahunModel = new Tahun();

        $validation = $this->validate(
            [
                'tahun' => 'required',
                'tipe' => 'required'
            ]
        );

        if (!$validation) {
            $errorMessages = implode(', ', $this->validator->getErrors());
            session()->setFlashdata('error', $errorMessages);
            return redirect()->back()->withInput();
        }

        $tahun = $tahunModel->find($this->request->getPost('tahun'));
        $data['kasus'] = $model->getKasusDbdByTahun($this->request->getPost('tahun'));
        $tipe = $this->request->getPost('tipe'); // Menentukan tipe export

        if ($tipe == 'excel') {
            // ============ EXPORT KE EXCEL ============
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle("Kasus DBD " . $tahun['tahun']);

            // Header kolom
            $headers = [
                'ID',
                'Tahun',
                'Nama Kecamatan',
                'Nama Puskesmas',
                'Jumlah Penduduk',
                'Jumlah Kasus',
                'Jumlah Kematian',
                'Jumlah Rumah Diperiksa',
                'Jumlah Rumah Bebas Jentik',
                'IR',
                'CFR (%)',
                'ABJ (%)',
                'Risiko IR',
                'Risiko CFR',
                'Risiko ABJ',
            ];
            $sheet->fromArray($headers, NULL, 'A1');

            $rowNumber = 2;
            foreach ($data['kasus'] as $row) {
                $cfrPersen = $row['CFR'] * 100;
                $abjPersen = $row['ABJ'] * 100;

                $sheet->fromArray([
                    $row['id'],
                    $row['tahun'],
                    $row['nama_kecamatan'],
                    $row['nama_puskesmas'],
                    $row['jumlah_penduduk'],
                    $row['jumlah_kasus'],
                    $row['jumlah_kematian'],
                    $row['jumlah_rumah_diperiksa'],
                    $row['jumlah_rumah_bebas_jentik'],
                    $row['IR'],
                    number_format($cfrPersen, 2) . '%',
                    number_format($abjPersen, 2) . '%',
                    $row['risiko_IR'],
                    $row['risiko_CFR'],
                    $row['risiko_ABJ'],
                ], NULL, "A{$rowNumber}");
                $rowNumber++;
            }

            $filename = 'kasus_dbd_' . $tahun['tahun'] . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        } elseif ($tipe == 'pdf') {
            // ============ EXPORT KE PDF ============
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);

            $dompdf = new Dompdf($options);

            $html = '
            <h2 style="text-align:center;">Laporan Kasus DBD Tahun ' . $tahun['tahun'] . '</h2>
            <table border="1" cellpadding="5" cellspacing="0" width="100%">
                <thead>
                    <tr style="background-color:#f2f2f2;">
                        <th>ID</th>
                        <th>Tahun</th>
                        <th>Nama Kecamatan</th>
                        <th>Nama Puskesmas</th>
                        <th>Jumlah Penduduk</th>
                        <th>Jumlah Kasus</th>
                        <th>Jumlah Kematian</th>
                        <th>Jumlah Rumah Diperiksa</th>
                        <th>Jumlah Rumah Bebas Jentik</th>
                        <th>IR</th>
                        <th>CFR (%)</th>
                        <th>ABJ (%)</th>
                        <th>Risiko IR</th>
                        <th>Risiko CFR</th>
                        <th>Risiko ABJ</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($data['kasus'] as $row) {
                $cfrPersen = number_format($row['CFR'] * 100, 2);
                $abjPersen = number_format($row['ABJ'] * 100, 2);

                $html .= '
                <tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['tahun'] . '</td>
                    <td>' . $row['nama_kecamatan'] . '</td>
                    <td>' . $row['nama_puskesmas'] . '</td>
                    <td>' . $row['jumlah_penduduk'] . '</td>
                    <td>' . $row['jumlah_kasus'] . '</td>
                    <td>' . $row['jumlah_kematian'] . '</td>
                    <td>' . $row['jumlah_rumah_diperiksa'] . '</td>
                    <td>' . $row['jumlah_rumah_bebas_jentik'] . '</td>
                    <td>' . $row['IR'] . '</td>
                    <td>' . $cfrPersen . '%</td>
                    <td>' . $abjPersen . '%</td>
                    <td>' . $row['risiko_IR'] . '</td>
                    <td>' . $row['risiko_CFR'] . '</td>
                    <td>' . $row['risiko_ABJ'] . '</td>
                </tr>';
            }

            $html .= '
                </tbody>
            </table>';

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            $filename = 'kasus_dbd_' . $tahun['tahun'] . '.pdf';
            $dompdf->stream($filename, ['Attachment' => true]);
            exit();
        }
    }
}
