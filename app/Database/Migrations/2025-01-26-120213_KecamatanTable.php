<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KecamatanTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kode_wilayah' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'nama_kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'file_geojson' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'latitude' => [
                'type' => 'DECIMAL',
                'constraint' => '10,8',
                'null' => true,
            ],
            'longitude' => [
                'type' => 'DECIMAL',
                'constraint' => '11,8',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('kecamatan');
    }

    public function down()
    {
        //
        $this->forge->dropTable('kecamatan');
    }
}
