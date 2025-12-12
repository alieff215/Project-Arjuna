<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTanggalJoinToAdminTable extends Migration
{
    public function up()
    {
        $fields = [
            'tanggal_join' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'no_hp'
            ]
        ];

        $this->forge->addColumn('tb_admin', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_admin', 'tanggal_join');
    }
}

