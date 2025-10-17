<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminUpdateHistory extends Migration
{
   public function up()
   {
      $this->forge->addField([
         'id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
         ],
         'id_admin' => [
            'type' => 'INT',
            'constraint' => 11,
            'null' => false,
         ],
         'changed_fields' => [
            'type' => 'VARCHAR',
            'constraint' => 255,
            'null' => true,
         ],
         'before_data' => [
            'type' => 'TEXT',
            'null' => true,
         ],
         'after_data' => [
            'type' => 'TEXT',
            'null' => true,
         ],
         'created_at' => [
            'type' => 'DATETIME',
            'null' => true,
         ],
      ]);

      $this->forge->addKey('id', true);
      $this->forge->createTable('tb_admin_update_history', true);
   }

   public function down()
   {
      $this->forge->dropTable('tb_admin_update_history', true);
   }
}




