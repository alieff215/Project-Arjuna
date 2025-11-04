<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveNisNuptkLengthLimit extends Migration
{
    public function up()
    {
        // Ubah kolom NIS di tb_karyawan dari varchar(16) ke varchar(255)
        $this->forge->modifyColumn('tb_karyawan', [
            'nis' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ]);

        // Ubah kolom NUPTK di tb_admin dari varchar(24) ke varchar(255)
        $this->forge->modifyColumn('tb_admin', [
            'nuptk' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        // Kembalikan ke ukuran semula jika rollback
        $this->forge->modifyColumn('tb_karyawan', [
            'nis' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'null' => false,
            ],
        ]);

        $this->forge->modifyColumn('tb_admin', [
            'nuptk' => [
                'type' => 'VARCHAR',
                'constraint' => 24,
                'null' => false,
            ],
        ]);
    }
}

