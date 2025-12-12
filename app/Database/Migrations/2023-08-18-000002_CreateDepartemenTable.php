<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDepartemenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_departemen' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'departemen' => [
                'type'           => 'VARCHAR',
                'constraint'     => 32,
            ],
            'id_jabatan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NULL',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NULL',
            'deleted_at TIMESTAMP NULL',
        ]);

        // primary key
        $this->forge->addKey('id_departemen', primary: TRUE);

        // id_jabatan foreign key
        $this->forge->addForeignKey('id_jabatan', 'tb_jabatan', 'id', 'CASCADE', 'NO ACTION');

        $this->forge->createTable('tb_departemen', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_departemen');
    }
}
