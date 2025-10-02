<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGajiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_gaji' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_departemen' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_jabatan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'gaji_per_jam' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'tanggal_update' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_gaji', true);
        $this->forge->addForeignKey('id_departemen', 'tb_departemen', 'id_departemen', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_jabatan', 'tb_jabatan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_gaji');
    }

    public function down()
    {
        $this->forge->dropTable('tb_gaji');
    }
}