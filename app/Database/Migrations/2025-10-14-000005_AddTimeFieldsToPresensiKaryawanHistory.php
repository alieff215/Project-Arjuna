<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimeFieldsToPresensiKaryawanHistory extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tb_presensi_karyawan_history', [
            'jam_masuk_before' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'jam_masuk_after' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'jam_keluar_before' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'jam_keluar_after' => [
                'type' => 'TIME',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_presensi_karyawan_history', [
            'jam_masuk_before',
            'jam_masuk_after',
            'jam_keluar_before',
            'jam_keluar_after'
        ]);
    }
}
