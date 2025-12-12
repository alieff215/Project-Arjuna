<?php 

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Inventory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                         => ['type' => 'INT', 'auto_increment' => true],
            'brand'                      => ['type' => 'VARCHAR', 'constraint' => 100],
            'order_name'                 => ['type' => 'VARCHAR', 'constraint' => 150],
            'price_per_pcs'              => ['type' => 'DECIMAL', 'constraint' => '10,2'],

            // === Kolom baru yang ditambahkan ===
            'total_target'               => ['type' => 'INT', 'default' => 0],
            
            'cutting_price_per_pcs'      => ['type' => 'INT', 'default' => 0],
            'cutting_target'             => ['type' => 'INT', 'default' => 0],
            'cutting_income'             => ['type' => 'INT', 'default' => 0],

            'produksi_price_per_pcs'     => ['type' => 'INT', 'default' => 0],
            'produksi_target'            => ['type' => 'INT', 'default' => 0],
            'produksi_income'            => ['type' => 'INT', 'default' => 0],

            'finishing_price_per_pcs'    => ['type' => 'INT', 'default' => 0],
            'finishing_target'           => ['type' => 'INT', 'default' => 0],
            'finishing_income'           => ['type' => 'INT', 'default' => 0],
            // ================================

            'cutting_qty'                => ['type' => 'INT', 'default' => 0],
            'produksi_qty'               => ['type' => 'INT', 'default' => 0],
            'finishing_qty'              => ['type' => 'INT', 'default' => 0],
            'target_per_day'             => ['type' => 'INT', 'default' => 0],
            'total_income'               => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'status'                     => ['type' => 'ENUM("onprogress","done")', 'default' => 'onprogress'],
            'created_at'                 => ['type' => 'DATETIME', 'null' => true],
            'updated_at'                 => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('inventories');
    }

    public function down()
    {
        $this->forge->dropTable('inventories');
    }
}
