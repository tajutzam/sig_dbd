<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    public function run()
    {
        //
        $data = [
            [
                'kode_wilayah' => 'KW001',
                'nama_kecamatan' => 'Sukapura',
                'file_geojson' => 'sukapura.geojson',
                'latitude' => '-7.250445',
                'longitude' => '112.768845',
            ],
        ];

        $this->db->table('kecamatan')->insertBatch($data);
    }
}
