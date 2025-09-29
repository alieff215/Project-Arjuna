<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJabatanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'jabatan' => [
                'type'           => 'VARCHAR',
                'constraint'     => 32,
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NULL',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NULL',
            'deleted_at TIMESTAMP NULL',
        ]);

        // primary key
        $this->forge->addKey('id', primary: TRUE);

        // unique key
        $this->forge->addKey('jabatan', unique: TRUE);

        $this->forge->createTable('tb_jabatan', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_jabatan');
    }
}
