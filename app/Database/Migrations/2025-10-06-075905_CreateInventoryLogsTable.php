<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'inventory_id' => [
                'type'       => 'INT',
                'null'       => false,
            ],
            'cutting_qty' => [
                'type'       => 'INT',
                'default'    => 0,
            ],
            'produksi_qty' => [
                'type'       => 'INT',
                'default'    => 0,
            ],
            'finishing_qty' => [
                'type'       => 'INT',
                'default'    => 0,
            ],
            'created_at' => [
                'type'       => 'DATE',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        // Relasi ke tabel inventories
        $this->forge->addForeignKey('inventory_id', 'inventories', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('inventory_logs');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_logs', true);
    }
}
