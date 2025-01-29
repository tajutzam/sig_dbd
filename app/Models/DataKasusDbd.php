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
    protected $useTimestamps = false;
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

        // Hitung R, CFR, dan ABJ untuk setiap data
        foreach ($data as &$item) {
            // Hitung R (Risiko) = (jumlah kasus / jumlah penduduk) * 100
            $item['IR'] = ($item['jumlah_kasus'] / $item['jumlah_penduduk']) * 100;

            // Hitung CFR (Case Fatality Rate) = (jumlah kematian / jumlah kasus) * 100
            $item['CFR'] = ($item['jumlah_kematian'] / $item['jumlah_kasus']) * 100;

            // Hitung ABJ (Angka Bebas Jentik) = (jumlah rumah bebas jentik / jumlah rumah yang diperiksa) * 100
            $item['ABJ'] = ($item['jumlah_rumah_bebas_jentik'] / $item['jumlah_rumah_diperiksa']) * 100;
        }

        return $data;
    }
}
