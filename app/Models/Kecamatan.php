<?php

namespace App\Models;

use CodeIgniter\Model;

class Kecamatan extends Model
{
    protected $table            = 'kecamatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "kode_wilayah",
        "nama_kecamatan",
        "file_geojson",
        "latitude",
        "longitude",
        "created_at",
        "updated_at"
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


    public function getIrCfrAbj($tahunID)
    {
        // Ambil data kecamatan beserta data terkait dari puskesmas dan data_kasus_dbd
        $data = $this->select('kecamatan.id as kecamatan_id, kecamatan.nama_kecamatan, 
                          COALESCE(SUM(data_kasus_dbd.jumlah_penduduk), 0) as jumlah_penduduk,
                          COALESCE(SUM(data_kasus_dbd.jumlah_kasus), 0) as jumlah_kasus,
                          COALESCE(SUM(data_kasus_dbd.jumlah_kematian), 0) as jumlah_kematian,
                          COALESCE(SUM(data_kasus_dbd.jumlah_rumah_diperiksa), 0) as jumlah_rumah_diperiksa,
                          COALESCE(SUM(data_kasus_dbd.jumlah_rumah_bebas_jentik), 0) as jumlah_rumah_bebas_jentik')
            ->join('puskesmas', 'puskesmas.kecamatan_id = kecamatan.id', 'left') // LEFT JOIN untuk puskesmas
            ->join('data_kasus_dbd', 'data_kasus_dbd.puskesmas_id = puskesmas.id AND data_kasus_dbd.tahun_id = ' . $tahunID, 'left') // LEFT JOIN untuk data_kasus_dbd dan pastikan tahun_id sesuai
            ->groupBy('kecamatan.id')
            ->findAll();

        // Hitung IR, ABJ, dan CFR untuk setiap kecamatan
        foreach ($data as &$kecamatan) {
            // Cek jika data null, set ke nilai default
            $jumlah_penduduk = $kecamatan['jumlah_penduduk'];
            $jumlah_kasus = $kecamatan['jumlah_kasus'];
            $jumlah_kematian = $kecamatan['jumlah_kematian'];
            $jumlah_rumah_diperiksa = $kecamatan['jumlah_rumah_diperiksa'];
            $jumlah_rumah_bebas_jentik = $kecamatan['jumlah_rumah_bebas_jentik'];

            // Hitung IR (Incidence Rate) = (jumlah kasus / jumlah penduduk) * 100
            $kecamatan['IR'] = ($jumlah_penduduk > 0)
                ? ($jumlah_kasus / $jumlah_penduduk) * 100
                : 0;

            // Hitung CFR (Case Fatality Rate) = (jumlah kematian / jumlah kasus) * 100
            $kecamatan['CFR'] = ($jumlah_kasus > 0)
                ? ($jumlah_kematian / $jumlah_kasus) * 100
                : 0;

            // Hitung ABJ (Angka Bebas Jentik) = (jumlah rumah bebas jentik / jumlah rumah diperiksa) * 100
            $kecamatan['ABJ'] = ($jumlah_rumah_diperiksa > 0)
                ? ($jumlah_rumah_bebas_jentik / $jumlah_rumah_diperiksa) * 100
                : 0;

            // Format ke dua angka di belakang koma
            $kecamatan['IR'] = number_format($kecamatan['IR'], 2);
            $kecamatan['CFR'] = number_format($kecamatan['CFR'], 2);
            $kecamatan['ABJ'] = number_format($kecamatan['ABJ'], 2);
        }

        return $data;
    }
}
