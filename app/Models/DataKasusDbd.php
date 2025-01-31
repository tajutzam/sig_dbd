<?php

namespace App\Models;

use CodeIgniter\Model;

class DataKasusDbd extends Model
{
    protected $table            = 'data_kasus_dbd';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tahun_id',
        'puskesmas_id',
        'jumlah_penduduk',
        'jumlah_kasus',
        'jumlah_kematian',
        'jumlah_rumah_diperiksa',
        'jumlah_rumah_bebas_jentik',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getKasusDbdWithDetails($id)
    {
        return $this->select('data_kasus_dbd.*, tahun.tahun, puskesmas.nama_puskesmas')
            ->join('tahun', 'tahun.id = data_kasus_dbd.tahun_id')
            ->join('puskesmas', 'puskesmas.id = data_kasus_dbd.puskesmas_id')
            ->where('data_kasus_dbd.id', $id)
            ->first();
    }

    public function getKasusDbdByPuskesmas($puskesmas_id)
    {
        return $this->select('data_kasus_dbd.*, tahun.tahun, puskesmas.nama_puskesmas')
            ->join('tahun', 'tahun.id = data_kasus_dbd.tahun_id')
            ->join('puskesmas', 'puskesmas.id = data_kasus_dbd.puskesmas_id')
            ->where('data_kasus_dbd.puskesmas_id', $puskesmas_id)
            ->findAll();
    }

    public function getKasusDbdByTahun($tahun_id)
    {
        // Ambil data kasus DBD berdasarkan tahun
        $data = $this->select('data_kasus_dbd.*, tahun.tahun, puskesmas.nama_puskesmas, puskesmas.latitude as latitude_puskesmas, puskesmas.longitude as longitude_puskesmas, kecamatan.*')
            ->join('tahun', 'tahun.id = data_kasus_dbd.tahun_id')
            ->join('puskesmas', 'puskesmas.id = data_kasus_dbd.puskesmas_id')
            ->join('kecamatan', 'kecamatan.id = puskesmas.kecamatan_id')
            ->where('data_kasus_dbd.tahun_id', $tahun_id)
            ->findAll();

        // Hitung IR, CFR, ABJ dan tentukan warna risiko
        foreach ($data as &$item) {
            // Hindari pembagian dengan nol
            $jumlahPenduduk = max($item['jumlah_penduduk'], 1);
            $jumlahKasus = max($item['jumlah_kasus'], 1);
            $jumlahRumahDiperiksa = max($item['jumlah_rumah_diperiksa'], 1);

            // Hitung IR (Incident Rate) = (jumlah kasus / jumlah penduduk) * 100.000
            $item['IR'] = ($item['jumlah_kasus'] / $jumlahPenduduk) * 100000;

            // Hitung CFR (Case Fatality Rate) = (jumlah kematian / jumlah kasus) * 100
            $item['CFR'] = ($item['jumlah_kematian'] / $jumlahKasus) * 100;

            // Hitung ABJ (Angka Bebas Jentik) = (jumlah rumah bebas jentik / jumlah rumah yang diperiksa)
            $item['ABJ'] = ($item['jumlah_rumah_bebas_jentik'] / $jumlahRumahDiperiksa);

            // Menentukan level risiko berdasarkan IR
            if ($item['IR'] > 100) {
                $item['risiko_IR'] = 'tinggi';
            } elseif ($item['IR'] >= 50) {
                $item['risiko_IR'] = 'sedang';
            } else {
                $item['risiko_IR'] = 'rendah';
            }

            if ($item['CFR'] > 1) {
                $item['risiko_CFR'] = 'tinggi';
            } elseif ($item['CFR'] >= 0.5) {
                $item['risiko_CFR'] = 'sedang';
            } else {
                $item['risiko_CFR'] = 'rendah';
            }

            // Menentukan level risiko berdasarkan ABJ
            if ($item['ABJ'] <= 0.95) {
                $item['risiko_ABJ'] = 'tinggi';
            } elseif ($item['ABJ'] >= 0.95 && $item['ABJ'] <= 98) {
                $item['risiko_ABJ'] = 'sedang';
            } else {
                $item['risiko_ABJ'] = 'rendah';
            }

            // Tentukan warna berdasarkan kombinasi risiko
            if ($item['risiko_IR'] == 'tinggi' && $item['risiko_CFR'] == 'tinggi' && $item['risiko_ABJ'] == 'tinggi') {
                $item['warna_risiko'] = 'red'; // Merah - Kerawanan Tinggi
            } elseif ($item['risiko_IR'] == 'tinggi' && $item['risiko_CFR'] == 'sedang' && $item['risiko_ABJ'] == 'rendah') {
                $item['warna_risiko'] = 'orange'; // Oranye - Kerawanan Sedang
            } elseif ($item['risiko_IR'] == 'rendah' && $item['risiko_CFR'] == 'rendah' && $item['risiko_ABJ'] == 'rendah') {
                $item['warna_risiko'] = 'yellow'; // Kuning - Kerawanan Rendah
            } else {
                $item['warna_risiko'] = 'yellow'; // Hijau - Normal/Selamat
            }
        }

        return $data;
    }
}
