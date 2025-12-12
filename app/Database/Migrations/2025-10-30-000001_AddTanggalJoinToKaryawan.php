<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTanggalJoinToKaryawan extends Migration
{
    public function up()
    {
        $fields = [
            'tanggal_join' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'no_hp',
            ],
        ];

        $this->forge->addColumn('tb_karyawan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_karyawan', 'tanggal_join');
    }
}


