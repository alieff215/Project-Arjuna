<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FebruariFullAttendanceSeeder extends Seeder
{
    public function run()
    {
        $db = $this->db;

        // 1. Pastikan ada departemen dan jabatan
        $departemen = $db->table('tb_departemen')->orderBy('id_departemen', 'ASC')->limit(1)->get()->getRowArray();
        
        if (!$departemen) {
            echo "Tidak ada data departemen. Silakan buat departemen terlebih dahulu.\n";
            return;
        }

        // 2. Pastikan ada konfigurasi gaji untuk departemen dan jabatan ini
        $gajiExists = $db->table('tb_gaji')
            ->where('id_departemen', $departemen['id_departemen'])
            ->where('id_jabatan', $departemen['id_jabatan'])
            ->countAllResults();

        if ($gajiExists == 0) {
            // Buat konfigurasi gaji dengan rate Rp 25.000/jam
            $db->table('tb_gaji')->insert([
                'id_departemen' => $departemen['id_departemen'],
                'id_jabatan' => $departemen['id_jabatan'],
                'gaji_per_jam' => 25000,
                'tanggal_update' => date('Y-m-d')
            ]);
            echo "Konfigurasi gaji dibuat: Rp 25.000/jam\n";
        }

        // 3. Buat karyawan dummy untuk testing
        $karyawanData = [
            'nis' => 'TEST' . date('YmdHis'),
            'nama_karyawan' => 'Budi Santoso (Test Feb 2025)',
            'id_departemen' => $departemen['id_departemen'],
            'jenis_kelamin' => 'Laki-laki',
            'no_hp' => '081234567890',
            'unique_code' => 'TEST-FEB-2025-' . uniqid()
        ];

        $db->table('tb_karyawan')->insert($karyawanData);
        $id_karyawan = $db->insertID();
        
        echo "Karyawan test dibuat: {$karyawanData['nama_karyawan']} (ID: {$id_karyawan})\n";

        // 4. Buat presensi untuk SEMUA hari kerja (Senin-Sabtu) di Februari 2025
        // Februari 2025: 28 hari
        // Minggu: 2, 9, 16, 23 (4 hari)
        // Hari kerja: 24 hari (20 weekdays + 4 Sabtu)
        
        $startDate = new \DateTime('2025-02-01');
        $endDate = new \DateTime('2025-02-28');
        
        $totalHariKerja = 0;
        $presensiData = [];
        
        $current = clone $startDate;
        while ($current <= $endDate) {
            $dayOfWeek = (int)$current->format('N'); // 1=Senin, 7=Minggu
            
            // Skip Minggu (hari 7)
            if ($dayOfWeek == 7) {
                $current->modify('+1 day');
                continue;
            }
            
            $totalHariKerja++;
            $tanggal = $current->format('Y-m-d');
            
            // Jam masuk: 07:45
            // Jam keluar: 
            // - Senin-Jumat: 18:00 (dengan lembur 1 jam agar total jam > 173)
            // - Sabtu: 13:00 (tidak ada lembur)
            
            if ($dayOfWeek == 6) {
                // Sabtu: 07:45 - 13:00
                $jamMasuk = '07:45:00';
                $jamKeluar = '13:00:00';
            } else {
                // Senin-Jumat: 07:45 - 18:00 (termasuk lembur 1 jam agar mencapai >173 jam)
                $jamMasuk = '07:45:00';
                $jamKeluar = '18:00:00';
            }
            
            $presensiData[] = [
                'id_karyawan' => $id_karyawan,
                'id_departemen' => $departemen['id_departemen'],
                'tanggal' => $tanggal,
                'jam_masuk' => $jamMasuk,
                'jam_keluar' => $jamKeluar,
                'id_kehadiran' => 1, // Hadir
                'keterangan' => 'Full attendance test - Feb 2025'
            ];
            
            $current->modify('+1 day');
        }

        // Insert semua presensi sekaligus
        if (!empty($presensiData)) {
            $db->table('tb_presensi_karyawan')->insertBatch($presensiData);
        }

        echo "\n=== RINGKASAN SEEDER ===\n";
        echo "Bulan: Februari 2025\n";
        echo "Total hari kerja: {$totalHariKerja} hari\n";
        echo "Presensi dibuat: " . count($presensiData) . " record\n";
        echo "Status kehadiran: 100% HADIR (tanpa izin/sakit/alpa)\n";
        echo "\nPerhitungan Jam Kerja (dengan sistem baru):\n";
        echo "- Senin-Jumat (20 hari):\n";
        echo "  * Jam kerja: 07:45-16:45 (9 jam)\n";
        echo "  * Istirahat: 12:00-13:00 (1 jam, tidak dihitung)\n";
        echo "  * Punishment: 1 jam (tidak dibayar)\n";
        echo "  * Net jam normal: 7 jam/hari\n";
        echo "  * Lembur: 17:00-18:00 (1 jam)\n";
        echo "  * Total per hari: 7 + 1 = 8 jam\n";
        echo "  * Subtotal 20 hari: 160 jam\n";
        echo "\n- Sabtu (4 hari):\n";
        echo "  * Jam kerja: 07:45-13:00 (5 jam 15 menit)\n";
        echo "  * Punishment: 1 jam (tidak dibayar)\n";
        echo "  * Net per hari: 4.25 jam\n";
        echo "  * Subtotal 4 hari: 17 jam\n";
        echo "\nTotal teoritis: 160 + 17 = 177 jam\n";
        echo "Karena maksimal 173 jam per bulan...\n";
        echo "Hasil akhir akan di-cap menjadi: 173 JAM (MAKSIMAL) ✓\n";
        echo "\n📊 Silakan cek laporan gaji untuk periode 2025-02-01 s/d 2025-02-28\n";
        echo "👤 Karyawan: {$karyawanData['nama_karyawan']}\n";
        echo "💰 Gaji per jam: Rp 25.000\n";
        echo "📈 Expected total gaji: Rp " . number_format(173 * 25000, 0, ',', '.') . "\n";
        echo "=======================\n";
    }
}

