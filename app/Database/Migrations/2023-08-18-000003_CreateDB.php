<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDB extends Migration
{
    public function up()
    {
        $this->forge->getConnection()->query("CREATE TABLE tb_kehadiran (
            id_kehadiran int(11) NOT NULL,
            kehadiran ENUM('Hadir', 'Sakit', 'Izin', 'Tanpa keterangan') NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $this->forge->getConnection()->query("INSERT INTO tb_kehadiran (id_kehadiran, kehadiran) VALUES
            (1, 'Hadir'),
            (2, 'Sakit'),
            (3, 'Izin'),
            (4, 'Tanpa keterangan');");

        $this->forge->getConnection()->query("INSERT INTO tb_jabatan (jabatan) VALUES
            ('OTKP'),
            ('BDP'),
            ('AKL'),
            ('RPL');");

        $this->forge->getConnection()->query("INSERT INTO tb_departemen (departemen, id_jabatan) VALUES
            ('X', 1),
            ('X', 2),
            ('X', 3),
            ('X', 4),
            ('XI', 1),
            ('XI', 2),
            ('XI', 3),
            ('XI', 4),
            ('XII', 1),
            ('XII', 2),
            ('XII', 3),
            ('XII', 4);");

        $this->forge->getConnection()->query("CREATE TABLE tb_admin (
            id_admin int(11) NOT NULL,
            nuptk varchar(24) NOT NULL,
            nama_admin varchar(255) NOT NULL,
            jenis_kelamin ENUM('Laki-laki','Perempuan') NOT NULL,
            alamat text NOT NULL,
            no_hp varchar(32) NOT NULL,
            unique_code varchar(64) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $this->forge->getConnection()->query("CREATE TABLE tb_presensi_admin (
            id_presensi int(11) NOT NULL,
            id_admin int(11) DEFAULT NULL,
            tanggal date NOT NULL,
            jam_masuk time DEFAULT NULL,
            jam_keluar time DEFAULT NULL,
            id_kehadiran int(11) NOT NULL,
            keterangan varchar(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                        ");

        $this->forge->getConnection()->query("CREATE TABLE tb_karyawan (
            id_karyawan int(11) NOT NULL,
            nis varchar(16) NOT NULL,
            nama_karyawan varchar(255) NOT NULL,
            id_departemen int(11) UNSIGNED NOT NULL,
            jenis_kelamin ENUM('Laki-laki','Perempuan') NOT NULL,
            no_hp varchar(32) NOT NULL,
            unique_code varchar(64) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $this->forge->getConnection()->query("CREATE TABLE tb_presensi_karyawan (
            id_presensi int(11) NOT NULL,
            id_karyawan int(11) NOT NULL,
            id_departemen int(11) UNSIGNED DEFAULT NULL,
            tanggal date NOT NULL,
            jam_masuk time DEFAULT NULL,
            jam_keluar time DEFAULT NULL,
            id_kehadiran int(11) NOT NULL,
            keterangan varchar(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $this->forge->getConnection()->query("ALTER TABLE tb_admin
            ADD PRIMARY KEY (id_admin),
            ADD UNIQUE KEY unique_code (unique_code);");

        $this->forge->getConnection()->query("ALTER TABLE tb_kehadiran
            ADD PRIMARY KEY (id_kehadiran);");

        $this->forge->getConnection()->query("ALTER TABLE tb_presensi_admin
            ADD PRIMARY KEY (id_presensi),
            ADD KEY id_kehadiran (id_kehadiran),
            ADD KEY id_admin (id_admin);");

        $this->forge->getConnection()->query("ALTER TABLE tb_presensi_karyawan
            ADD PRIMARY KEY (id_presensi),
            ADD KEY id_karyawan (id_karyawan),
            ADD KEY id_kehadiran (id_kehadiran),
            ADD KEY id_departemen (id_departemen);");

        $this->forge->getConnection()->query("ALTER TABLE tb_karyawan
            ADD PRIMARY KEY (id_karyawan),
            ADD UNIQUE KEY unique_code (unique_code),
            ADD KEY id_karyawan (id_karyawan);");

        $this->forge->getConnection()->query("ALTER TABLE tb_admin
            MODIFY id_admin int(11) NOT NULL AUTO_INCREMENT;");

        $this->forge->getConnection()->query("ALTER TABLE tb_kehadiran
            MODIFY id_kehadiran int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;");

        $this->forge->getConnection()->query("ALTER TABLE tb_presensi_admin
            MODIFY id_presensi int(11) NOT NULL AUTO_INCREMENT;");

        $this->forge->getConnection()->query("ALTER TABLE tb_presensi_karyawan
            MODIFY id_presensi int(11) NOT NULL AUTO_INCREMENT;");

        $this->forge->getConnection()->query("ALTER TABLE tb_karyawan
            MODIFY id_karyawan int(11) NOT NULL AUTO_INCREMENT;");

        $this->forge->getConnection()->query("ALTER TABLE tb_presensi_admin
            ADD CONSTRAINT tb_presensi_admin_ibfk_2 FOREIGN KEY (id_kehadiran) REFERENCES tb_kehadiran (id_kehadiran),
            ADD CONSTRAINT tb_presensi_admin_ibfk_3 FOREIGN KEY (id_admin) REFERENCES tb_admin (id_admin) ON DELETE SET NULL;");

        $this->forge->getConnection()->query("ALTER TABLE tb_presensi_karyawan
            ADD CONSTRAINT tb_presensi_karyawan_ibfk_2 FOREIGN KEY (id_kehadiran) REFERENCES tb_kehadiran (id_kehadiran),
            ADD CONSTRAINT tb_presensi_karyawan_ibfk_3 FOREIGN KEY (id_karyawan) REFERENCES tb_karyawan (id_karyawan) ON DELETE CASCADE,
            ADD CONSTRAINT tb_presensi_karyawan_ibfk_4 FOREIGN KEY (id_departemen) REFERENCES tb_departemen (id_departemen) ON DELETE SET NULL ON UPDATE CASCADE;");

        $this->forge->getConnection()->query("ALTER TABLE tb_karyawan
            ADD CONSTRAINT tb_karyawan_ibfk_1 FOREIGN KEY (id_departemen) REFERENCES tb_departemen (id_departemen) ON DELETE CASCADE ON UPDATE CASCADE;");

    }

    public function down()
    {
        $tables = [
            'tb_presensi_karyawan',
            'tb_presensi_admin',
            'tb_karyawan',
            'tb_admin',
            'tb_kehadiran',
        ];

        foreach ($tables as $table) {
            $this->forge->dropTable($table);
        }
    }
}
