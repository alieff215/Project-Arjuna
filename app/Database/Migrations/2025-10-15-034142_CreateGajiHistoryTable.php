<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGajiHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_history' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_gaji' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_departemen_old' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_departemen_new' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_jabatan_old' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_jabatan_new' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'gaji_per_jam_old' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'gaji_per_jam_new' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'departemen_old' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'departemen_new' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'jabatan_old' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'jabatan_new' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'action' => [
                'type'       => 'ENUM',
                'constraint' => ['created', 'updated', 'deleted'],
                'default'    => 'updated',
            ],
            'updated_by' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id_history', true);
        $this->forge->addForeignKey('id_gaji', 'tb_gaji', 'id_gaji', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_departemen_old', 'tb_departemen', 'id_departemen', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('id_departemen_new', 'tb_departemen', 'id_departemen', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('id_jabatan_old', 'tb_jabatan', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('id_jabatan_new', 'tb_jabatan', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('tb_gaji_history');
    }

    public function down()
    {
        $this->forge->dropTable('tb_gaji_history');
    }
}