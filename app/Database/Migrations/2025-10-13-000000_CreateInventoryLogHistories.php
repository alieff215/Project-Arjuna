<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryLogHistories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'inventory_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'previous_cutting_qty' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'previous_produksi_qty' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'previous_finishing_qty' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'new_cutting_qty' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'new_produksi_qty' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'new_finishing_qty' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'changed_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('inventory_id');
        $this->forge->createTable('inventory_log_histories', true);
    }

    public function down()
    {
        $this->forge->dropTable('inventory_log_histories', true);
    }
}




