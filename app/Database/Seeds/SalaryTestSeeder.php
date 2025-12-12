<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory as FakerFactory;

class SalaryTestSeeder extends Seeder
{
    public function run()
    {
        $db = $this->db;
        $faker = FakerFactory::create('id_ID');

        // Ambil beberapa departemen beserta jabatannya
        $departemenList = $db->table('tb_departemen d')
            ->select('d.id_departemen, d.departemen, d.id_jabatan, j.jabatan')
            ->join('tb_jabatan j', 'd.id_jabatan = j.id', 'left')
            ->limit(3)
            ->get()
            ->getResultArray();

        if (empty($departemenList)) {
            echo "Tidak ada data departemen. Buat departemen dan jabatan terlebih dahulu.\n";
            return;
        }

        // Pastikan konfigurasi gaji ada untuk kombinasi departemen/jabatan yang dipakai
        foreach ($departemenList as $dep) {
            $exists = $db->table('tb_gaji')
                ->where('id_departemen', $dep['id_departemen'])
                ->where('id_jabatan', $dep['id_jabatan'])
                ->countAllResults();

            if ($exists == 0) {
                $db->table('tb_gaji')->insert([
                    'id_departemen' => $dep['id_departemen'],
                    'id_jabatan' => $dep['id_jabatan'],
                    'gaji_per_jam' => $faker->numberBetween(15000, 30000),
                    'tanggal_update' => date('Y-m-d')
                ]);
            }
        }

        $karyawanBaru = [];
        foreach ($departemenList as $dep) {
            for ($i = 0; $i < 3; $i++) { // 3 karyawan per departemen
                $gender = $faker->randomElement(['Laki-laki', 'Perempuan']);
                $karyawanBaru[] = [
                    'nis' => $faker->numerify('#######'),
                    'nama_karyawan' => $faker->name($gender == 'Laki-laki' ? 'male' : 'female'),
                    'id_departemen' => $dep['id_departemen'],
                    'jenis_kelamin' => $gender,
                    'no_hp' => $faker->numerify('08##########'),
                    'unique_code' => $faker->uuid()
                ];
            }
        }

        // Insert karyawan baru
        if (!empty($karyawanBaru)) {
            $db->table('tb_karyawan')->insertBatch($karyawanBaru);
        }

        // Ambil kembali karyawan yang baru dimasukkan (berdasarkan unique_code yang di-generate)
        // Karena tidak menyimpan unique_code sebelumnya, ambil 9 karyawan terakhir sebagai pendekatan praktis
        $karyawanList = $db->table('tb_karyawan')
            ->orderBy('id_karyawan', 'DESC')
            ->limit(count($karyawanBaru))
            ->get()
            ->getResultArray();

        // Buat presensi bervariasi untuk bulan berjalan
        $startDate = new \DateTime(date('Y-m-01'));
        $endDate = new \DateTime(date('Y-m-t'));

        foreach ($karyawanList as $k) {
            $current = clone $startDate;
            while ($current <= $endDate) {
                // Skip akhir pekan untuk variasi yang lebih realistis
                $dayOfWeek = (int)$current->format('N'); // 1..7 (Mon..Sun)
                if ($dayOfWeek <= 5) {
                    // Distribusi kehadiran: mostly hadir, sebagian sakit/izin/TK
                    $roll = mt_rand(1, 100);
                    if ($roll <= 70) {
                        // Hadir (id_kehadiran = 1)
                        $jamMasukHour = mt_rand(7, 9); // variasi keterlambatan kecil
                        $jamKeluarHour = $jamMasukHour + mt_rand(7, 9); // 7-9 jam kerja
                        $jamMasuk = sprintf('%02d:%02d:00', $jamMasukHour, mt_rand(0, 1) * 30);
                        $jamKeluar = sprintf('%02d:%02d:00', $jamKeluarHour, mt_rand(0, 1) * 30);
                        $db->table('tb_presensi_karyawan')->insert([
                            'id_karyawan' => $k['id_karyawan'],
                            'id_departemen' => $k['id_departemen'] ?? null,
                            'tanggal' => $current->format('Y-m-d'),
                            'jam_masuk' => $jamMasuk,
                            'jam_keluar' => $jamKeluar,
                            'id_kehadiran' => 1,
                            'keterangan' => ''
                        ]);
                    } elseif ($roll <= 80) {
                        // Sakit (2)
                        $db->table('tb_presensi_karyawan')->insert([
                            'id_karyawan' => $k['id_karyawan'],
                            'id_departemen' => $k['id_departemen'] ?? null,
                            'tanggal' => $current->format('Y-m-d'),
                            'jam_masuk' => null,
                            'jam_keluar' => null,
                            'id_kehadiran' => 2,
                            'keterangan' => 'Sakit'
                        ]);
                    } elseif ($roll <= 90) {
                        // Izin (3)
                        $db->table('tb_presensi_karyawan')->insert([
                            'id_karyawan' => $k['id_karyawan'],
                            'id_departemen' => $k['id_departemen'] ?? null,
                            'tanggal' => $current->format('Y-m-d'),
                            'jam_masuk' => null,
                            'jam_keluar' => null,
                            'id_kehadiran' => 3,
                            'keterangan' => 'Izin'
                        ]);
                    } else {
                        // Tanpa Keterangan (4)
                        $db->table('tb_presensi_karyawan')->insert([
                            'id_karyawan' => $k['id_karyawan'],
                            'id_departemen' => $k['id_departemen'] ?? null,
                            'tanggal' => $current->format('Y-m-d'),
                            'jam_masuk' => null,
                            'jam_keluar' => null,
                            'id_kehadiran' => 4,
                            'keterangan' => ''
                        ]);
                    }
                }
                $current->modify('+1 day');
            }
        }

        echo "Seeder SalaryTestSeeder selesai. Data karyawan, gaji, dan presensi bervariasi ditambahkan untuk bulan berjalan.\n";
    }
}













