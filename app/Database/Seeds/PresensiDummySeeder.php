<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PresensiDummySeeder extends Seeder
{
    public function run()
    {
        $db = $this->db;

        // Konfigurasi bulan yang akan di-seed (default: bulan ini)
        $startDate = new \DateTime(date('Y-m-01'));
        $endDate = new \DateTime(date('Y-m-t'));

        // Ambil hingga 10 karyawan pertama sebagai sampel
        $karyawanList = $db->table('tb_karyawan')
            ->select('id_karyawan, id_departemen, nama_karyawan')
            ->limit(10)
            ->get()
            ->getResultArray();

        if (empty($karyawanList)) {
            echo "Tidak ada data karyawan. Jalankan KaryawanSeeder terlebih dahulu.\n";
            return;
        }

        // Peta status kehadiran
        // 1=hadir, 2=sakit, 3=izin, 4=alpa (berdasarkan kode yang ada di aplikasi)
        $KEHADIRAN_HADIR = 1;
        $KEHADIRAN_SAKIT = 2;
        $KEHADIRAN_IZIN  = 3;

        $table = $db->table('tb_presensi_karyawan');

        // Hapus data presensi pada rentang bulan ini untuk karyawan-karyawan sampel agar tidak dobel
        $idKaryawanArr = array_column($karyawanList, 'id_karyawan');
        if (!empty($idKaryawanArr)) {
            $table->whereIn('id_karyawan', $idKaryawanArr)
                ->where('tanggal >=', $startDate->format('Y-m-01'))
                ->where('tanggal <=', $endDate->format('Y-m-t'))
                ->delete();
        }

        // Variasi skenario jam masuk/keluar (Senin–Jumat)
        // Semua format HH:MM 24 jam
        $weekdayScenarios = [
            // Tepat waktu penuh (08:00–16:00)
            ['in' => '08:00', 'out' => '16:00', 'note' => 'ontime_full'],
            // Telat <15m (08:07), pulang normal
            ['in' => '08:07', 'out' => '16:00', 'note' => 'late_lt15'],
            // Telat >=15m (08:22), pulang normal
            ['in' => '08:22', 'out' => '16:00', 'note' => 'late_gte15'],
            // Masuk normal, pulang <15m lebih cepat (15:50)
            ['in' => '08:00', 'out' => '15:50', 'note' => 'early_lt15'],
            // Masuk normal, pulang >15m lebih cepat (15:40)
            ['in' => '08:00', 'out' => '15:40', 'note' => 'early_gte15'],
            // Masuk >15m telat dan pulang >15m lebih cepat (kombinasi)
            ['in' => '08:20', 'out' => '15:35', 'note' => 'late_early_mix'],
            // Masuk saat menjelang istirahat (11:55), pulang normal (edge)
            ['in' => '11:55', 'out' => '16:00', 'note' => 'edge_before_lunch'],
            // Masuk setelah istirahat (13:05), pulang normal
            ['in' => '13:05', 'out' => '16:00', 'note' => 'after_lunch_only'],
        ];

        // Variasi skenario untuk Sabtu (08:00–13:00, tanpa istirahat)
        $saturdayScenarios = [
            ['in' => '08:00', 'out' => '13:00', 'note' => 'saturday_full'],
            // Telat <15m (08:10), pulang normal
            ['in' => '08:10', 'out' => '13:00', 'note' => 'saturday_late_lt15'],
            // Telat >=15m (08:18), pulang normal
            ['in' => '08:18', 'out' => '13:00', 'note' => 'saturday_late_gte15'],
            // Masuk normal, pulang <15m lebih cepat (12:50)
            ['in' => '08:00', 'out' => '12:50', 'note' => 'saturday_early_lt15'],
            // Masuk normal, pulang >15m lebih cepat (12:40)
            ['in' => '08:00', 'out' => '12:40', 'note' => 'saturday_early_gte15'],
        ];

        $period = new \DatePeriod($startDate, new \DateInterval('P1D'), (clone $endDate)->modify('+1 day'));

        $rows = [];
        foreach ($karyawanList as $index => $karyawan) {
            foreach ($period as $day) {
                $tanggal = $day->format('Y-m-d');
                $dow = (int)$day->format('N'); // 1=Senin ... 6=Sabtu, 7=Minggu

                // Skip Minggu
                if ($dow === 7) {
                    continue;
                }

                // Hari kerja: sebagian hari random dijadikan Sakit/Izin untuk variasi
                $rand = mt_rand(1, 100);
                if ($rand <= 7) {
                    // ~7% Sakit
                    $rows[] = [
                        'id_karyawan'  => $karyawan['id_karyawan'],
                        'id_departemen'=> $karyawan['id_departemen'],
                        'tanggal'      => $tanggal,
                        'jam_masuk'    => null,
                        'jam_keluar'   => null,
                        'id_kehadiran' => $KEHADIRAN_SAKIT,
                        'keterangan'   => 'Sakit (dummy)'
                    ];
                    continue;
                }
                if ($rand > 7 && $rand <= 12) {
                    // ~5% Izin
                    $rows[] = [
                        'id_karyawan'  => $karyawan['id_karyawan'],
                        'id_departemen'=> $karyawan['id_departemen'],
                        'tanggal'      => $tanggal,
                        'jam_masuk'    => null,
                        'jam_keluar'   => null,
                        'id_kehadiran' => $KEHADIRAN_IZIN,
                        'keterangan'   => 'Izin (dummy)'
                    ];
                    continue;
                }

                // Hadir
                if ($dow === 6) {
                    // Sabtu
                    $scenario = $saturdayScenarios[array_rand($saturdayScenarios)];
                } else {
                    // Senin–Jumat
                    $scenario = $weekdayScenarios[array_rand($weekdayScenarios)];
                }

                $rows[] = [
                    'id_karyawan'  => $karyawan['id_karyawan'],
                    'id_departemen'=> $karyawan['id_departemen'],
                    'tanggal'      => $tanggal,
                    'jam_masuk'    => $scenario['in'],
                    'jam_keluar'   => $scenario['out'],
                    'id_kehadiran' => $KEHADIRAN_HADIR,
                    'keterangan'   => $scenario['note']
                ];
            }
        }

        if (!empty($rows)) {
            // Batch insert agar cepat
            $table->insertBatch($rows);
        }

        echo "Berhasil generate presensi dummy untuk ".$startDate->format('F Y')." (".count($rows)." baris).\n";
    }
}



