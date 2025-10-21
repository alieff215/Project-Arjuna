<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTanggalToInventories extends Migration
{
    public function up()
    {
        $this->forge->addColumn('inventories', [
            'tanggal_mulai' => [
                'type' => 'DATE',
                'null' => true,
                'comment' => 'Tanggal mulai inventory'
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
                'null' => true,
                'comment' => 'Tanggal selesai inventory'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('inventories', ['tanggal_mulai', 'tanggal_selesai']);
    }
}
