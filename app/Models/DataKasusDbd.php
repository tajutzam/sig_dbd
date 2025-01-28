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
        return $this->select('data_kasus_dbd.*, tahun.tahun, puskesmas.nama_puskesmas')
            ->join('tahun', 'tahun.id = data_kasus_dbd.tahun_id')
            ->join('puskesmas', 'puskesmas.id = data_kasus_dbd.puskesmas_id')
            ->where('data_kasus_dbd.tahun_id', $tahun_id)
            ->findAll();
    }
}
