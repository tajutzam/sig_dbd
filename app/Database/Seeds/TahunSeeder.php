<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TahunSeeder extends Seeder
{
    public function run()
    {
        //
        $data = [
            [
                'tahun' => 2020,
            ],
            [
                'tahun' => 2021,
            ],
            [
                'tahun' => 2022,
            ],
            [
                'tahun' => 2023,
            ],
            [
                'tahun' => 2024,
            ],
            [
                'tahun' => 2025,
            ]
        ];
        $this->db->table('tahun')->insertBatch($data);
    }
}
