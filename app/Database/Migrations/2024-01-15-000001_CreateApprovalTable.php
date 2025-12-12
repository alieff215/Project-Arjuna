<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApprovalTable extends Migration
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
            'request_type' => [
                'type' => 'ENUM',
                'constraint' => ['create', 'update', 'delete'],
                'null' => false,
            ],
            'table_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'record_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'ID record yang akan diubah (null untuk create)',
            ],
            'request_data' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'JSON data yang akan disimpan/diubah',
            ],
            'original_data' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'JSON data asli (untuk update/delete)',
            ],
            'requested_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'comment' => 'ID admin yang meminta approval',
            ],
            'approved_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'ID superadmin yang approve',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default' => 'pending',
            ],
            'approval_notes' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Catatan dari superadmin',
            ],
            'rejection_reason' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Alasan penolakan',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'approved_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Waktu approval/rejection',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('requested_by');
        $this->forge->addKey('approved_by');
        $this->forge->addKey('status');
        $this->forge->addKey('table_name');
        $this->forge->addKey('created_at');

        $this->forge->createTable('approval_requests');
    }

    public function down()
    {
        $this->forge->dropTable('approval_requests');
    }
}

