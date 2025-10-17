<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePresensiAdminHistory extends Migration
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
         'id_presensi' => [
            'type' => 'INT',
            'constraint' => 11,
            'null' => true,
         ],
         'id_admin' => [
            'type' => 'INT',
            'constraint' => 11,
            'null' => false,
         ],
         'tanggal' => [
            'type' => 'DATE',
            'null' => false,
         ],
         'id_kehadiran_before' => [
            'type' => 'INT',
            'constraint' => 11,
            'null' => true,
         ],
         'id_kehadiran_after' => [
            'type' => 'INT',
            'constraint' => 11,
            'null' => true,
         ],
         'keterangan_before' => [
            'type' => 'TEXT',
            'null' => true,
         ],
         'keterangan_after' => [
            'type' => 'TEXT',
            'null' => true,
         ],
         'created_at' => [
            'type' => 'DATETIME',
            'null' => true,
         ],
      ]);

      $this->forge->addKey('id', true);
      $this->forge->createTable('tb_presensi_admin_history', true);
   }

   public function down()
   {
      $this->forge->dropTable('tb_presensi_admin_history', true);
   }
}


