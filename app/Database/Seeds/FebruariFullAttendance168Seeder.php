<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FebruariFullAttendance168Seeder extends Seeder
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
            'nis' => 'TEST168-' . date('YmdHis'),
            'nama_karyawan' => 'Siti Nurhaliza (Test Feb 2025 - 168 Jam)',
            'id_departemen' => $departemen['id_departemen'],
            'jenis_kelamin' => 'Perempuan',
            'no_hp' => '081234567891',
            'unique_code' => 'TEST-FEB-168-' . uniqid()
        ];

        $db->table('tb_karyawan')->insert($karyawanData);
        $id_karyawan = $db->insertID();
        
        echo "Karyawan test dibuat: {$karyawanData['nama_karyawan']} (ID: {$id_karyawan})\n";

        // 4. Buat presensi untuk SEMUA hari kerja (Senin-Sabtu) di Februari 2025
        // TANPA LEMBUR - hanya jam normal
        // Februari 2025: 28 hari, Minggu: 2, 9, 16, 23
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
            // Jam keluar: TANPA LEMBUR (hanya jam normal)
            // - Senin-Jumat: 16:45
            // - Sabtu: 13:00
            
            if ($dayOfWeek == 6) {
                // Sabtu: 07:45 - 13:00
                $jamMasuk = '07:45:00';
                $jamKeluar = '13:00:00';
            } else {
                // Senin-Jumat: 07:45 - 16:45 (TANPA LEMBUR)
                $jamMasuk = '07:45:00';
                $jamKeluar = '16:45:00';
            }
            
            $presensiData[] = [
                'id_karyawan' => $id_karyawan,
                'id_departemen' => $departemen['id_departemen'],
                'tanggal' => $tanggal,
                'jam_masuk' => $jamMasuk,
                'jam_keluar' => $jamKeluar,
                'id_kehadiran' => 1, // Hadir
                'keterangan' => 'Full attendance (no overtime) - Feb 2025'
            ];
            
            $current->modify('+1 day');
        }

        // Insert semua presensi sekaligus
        if (!empty($presensiData)) {
            $db->table('tb_presensi_karyawan')->insertBatch($presensiData);
        }

        echo "\n=== RINGKASAN SEEDER (Kasus 168 Jam -> 173 Jam) ===\n";
        echo "Bulan: Februari 2025\n";
        echo "Total hari kerja dalam periode: {$totalHariKerja} hari\n";
        echo "Presensi dibuat: " . count($presensiData) . " record\n";
        echo "Status kehadiran: 100% HADIR (tanpa izin/sakit/alpa)\n";
        echo "\nPerhitungan Jam Kerja Aktual:\n";
        echo "- Senin-Jumat (20 hari):\n";
        echo "  * Jam kerja: 07:45-16:45 (9 jam)\n";
        echo "  * Istirahat: 12:00-13:00 (1 jam, tidak dihitung)\n";
        echo "  * Punishment: 1 jam (tidak dibayar)\n";
        echo "  * Net per hari: 7 jam\n";
        echo "  * TANPA LEMBUR\n";
        echo "  * Subtotal 20 hari: 140 jam\n";
        echo "\n- Sabtu (4 hari):\n";
        echo "  * Jam kerja: 07:45-13:00 (5 jam 15 menit)\n";
        echo "  * Punishment: 1 jam (tidak dibayar)\n";
        echo "  * Net per hari: 4.25 jam\n";
        echo "  * Subtotal 4 hari: 17 jam\n";
        echo "\nTotal jam AKTUAL: 140 + 17 = 157 jam\n";
        echo "\n🎯 TAPI KARENA karyawan hadir FULL 24/24 hari (100%)...\n";
        echo "✅ Sistem akan OTOMATIS memberikan: 173 JAM (STANDAR FULL-TIME)\n";
        echo "\n📊 Silakan cek laporan gaji untuk periode 2025-02-01 s/d 2025-02-28\n";
        echo "👤 Karyawan: {$karyawanData['nama_karyawan']}\n";
        echo "💰 Gaji per jam: Rp 25.000\n";
        echo "📈 Total gaji yang akan diterima: Rp " . number_format(173 * 25000, 0, ',', '.') . "\n";
        echo "📝 Catatan: Meskipun jam aktual ~157 jam, karena hadir full dapat 173 jam\n";
        echo "================================================\n";
    }
}

