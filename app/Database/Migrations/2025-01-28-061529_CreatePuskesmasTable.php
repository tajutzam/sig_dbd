<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePuskesmasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kecamatan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nama_puskesmas' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->addForeignKey('kecamatan_id', 'kecamatan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('puskesmas');
    }

    public function down()
    {
        $this->forge->dropTable('puskesmas');
    }
}
