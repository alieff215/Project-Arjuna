<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterGajiPrecision extends Migration
{
    public function up()
    {
        // Ubah presisi kolom gaji_per_jam pada tb_gaji menjadi 3 desimal
        $this->forge->modifyColumn('tb_gaji', [
            'gaji_per_jam' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,3',
                'default'    => 0,
            ],
        ]);

        // Ubah presisi kolom gaji_per_jam_old dan gaji_per_jam_new pada tb_gaji_history menjadi 3 desimal
        $this->forge->modifyColumn('tb_gaji_history', [
            'gaji_per_jam_old' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,3',
                'null'       => true,
            ],
            'gaji_per_jam_new' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,3',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        // Kembalikan presisi ke 2 desimal jika rollback
        $this->forge->modifyColumn('tb_gaji', [
            'gaji_per_jam' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
        ]);

        $this->forge->modifyColumn('tb_gaji_history', [
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
        ]);
    }
}

