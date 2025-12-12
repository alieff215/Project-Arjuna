<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddApprovalColumnsToPresensiTables extends Migration
{
    public function up()
    {
        // Tambahkan kolom approval status ke tabel presensi karyawan
        $this->forge->addColumn('tb_presensi_karyawan', [
            'approval_status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default' => 'approved',
                'null' => false,
                'comment' => 'Status approval untuk perubahan presensi'
            ],
            'approval_request_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'ID request approval yang terkait'
            ],
            'approved_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'ID admin yang approve perubahan'
            ],
            'approved_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Waktu approval'
            ]
        ]);

        // Tambahkan kolom approval status ke tabel presensi admin
        $this->forge->addColumn('tb_presensi_admin', [
            'approval_status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default' => 'approved',
                'null' => false,
                'comment' => 'Status approval untuk perubahan presensi'
            ],
            'approval_request_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'ID request approval yang terkait'
            ],
            'approved_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'ID admin yang approve perubahan'
            ],
            'approved_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Waktu approval'
            ]
        ]);

        // Tambahkan index untuk performa
        $this->forge->addKey('approval_status', false, 'tb_presensi_karyawan');
        $this->forge->addKey('approval_request_id', false, 'tb_presensi_karyawan');
        $this->forge->addKey('approval_status', false, 'tb_presensi_admin');
        $this->forge->addKey('approval_request_id', false, 'tb_presensi_admin');
    }

    public function down()
    {
        // Hapus kolom approval dari tabel presensi karyawan
        $this->forge->dropColumn('tb_presensi_karyawan', ['approval_status', 'approval_request_id', 'approved_by', 'approved_at']);
        
        // Hapus kolom approval dari tabel presensi admin
        $this->forge->dropColumn('tb_presensi_admin', ['approval_status', 'approval_request_id', 'approved_by', 'approved_at']);
    }
}
