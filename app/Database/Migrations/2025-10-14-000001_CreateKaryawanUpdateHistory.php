<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKaryawanUpdateHistory extends Migration
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
            'id_karyawan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'changed_fields' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'before_data' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'after_data' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            // gunakan rawDefinition agar DEFAULT CURRENT_TIMESTAMP tidak ditolak MySQL
            'created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('id_karyawan');
        $this->forge->createTable('tb_karyawan_update_history');
    }

    public function down()
    {
        $this->forge->dropTable('tb_karyawan_update_history');
    }
}


