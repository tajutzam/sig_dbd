<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataKasusDbdTable extends Migration
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
            'tahun_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'puskesmas_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'jumlah_penduduk' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'jumlah_kasus' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'jumlah_kematian' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'jumlah_rumah_diperiksa' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'jumlah_rumah_bebas_jentik' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
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

        // Menambahkan primary key
        $this->forge->addKey('id', true);

        // Relasi dengan tabel tahun dan puskesmas
        $this->forge->addForeignKey('tahun_id', 'tahun', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('puskesmas_id', 'puskesmas', 'id', 'CASCADE', 'CASCADE');

        // Membuat tabel
        $this->forge->createTable('data_kasus_dbd');
    }

    public function down()
    {
        //
        $this->forge->dropTable('data_kasus_dbd');
    }
}
