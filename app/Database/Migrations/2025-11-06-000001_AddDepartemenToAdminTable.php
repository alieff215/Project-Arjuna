<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDepartemenToAdminTable extends Migration
{
    public function up()
    {
        $fields = [
            'id_departemen' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'nama_admin'
            ]
        ];

        $this->forge->addColumn('tb_admin', $fields);

        // Tambahkan foreign key ke tb_departemen
        $this->forge->addForeignKey('id_departemen', 'tb_departemen', 'id_departemen', 'CASCADE', 'SET NULL', 'tb_admin');
    }

    public function down()
    {
        // Drop foreign key dulu
        $this->forge->dropForeignKey('tb_admin', 'tb_admin_id_departemen_foreign');
        
        // Kemudian drop column
        $this->forge->dropColumn('tb_admin', 'id_departemen');
    }
}

