<?php

namespace App\Models;

use CodeIgniter\Model;

class Puskesmas extends Model
{
    protected $table            = 'puskesmas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kecamatan_id',
        'nama_puskesmas',
        'latitude',
        'longitude'
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


    public function getPuskesmasWithKecamatan()
    {
        return $this->select('puskesmas.*, kecamatan.nama_kecamatan')
            ->join('kecamatan', 'kecamatan.id = puskesmas.kecamatan_id')
            ->findAll();
    }


    public function findPuskesmasWithKecamatan($id)
    {
        return $this->select('puskesmas.*, kecamatan.nama_kecamatan, kecamatan.id as id_kecamatan')
            ->join('kecamatan', 'kecamatan.id = puskesmas.kecamatan_id')
            ->where('puskesmas.id', $id)
            ->first();
    }
}
