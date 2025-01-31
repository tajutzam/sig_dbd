<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateArtikelsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'judul'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'image'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true, // Nullable
            ],
            'author'      => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'created_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('artikels');
    }

    public function down()
    {
        //
        $this->forge->dropTable('artikels');
    }
}
