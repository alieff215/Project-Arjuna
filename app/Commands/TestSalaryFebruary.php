<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\GajiModel;

class TestSalaryFebruary extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'test:salary:february';
    protected $description = 'Verifikasi perhitungan gaji Februari 2025';

    public function run(array $params)
    {
        CLI::write("=== VERIFIKASI PERHITUNGAN GAJI FEBRUARI 2025 ===\n", 'green');

        $gajiModel = new GajiModel();

        // Ambil laporan gaji untuk Februari 2025
        $report = $gajiModel->getSalaryReport('2025-02-01', '2025-02-28');

        if (empty($report)) {
            CLI::error("❌ Tidak ada data karyawan untuk periode Februari 2025");
            CLI::write("Pastikan seeder sudah dijalankan terlebih dahulu:");
            CLI::write("php spark db:seed FebruariFullAttendance168Seeder");
            return;
        }

        CLI::write("Total karyawan: " . count($report), 'yellow');
        CLI::write(str_repeat("=", 80) . "\n");

        foreach ($report as $index => $data) {
            $no = $index + 1;
            CLI::write("[$no] Karyawan: {$data['nama_karyawan']}", 'cyan');
            CLI::write("    NIS: {$data['nis']}");
            CLI::write("    Departemen: {$data['departemen']}");
            CLI::write("    Jabatan: {$data['jabatan']}");
            CLI::write("    Gaji per jam: Rp " . number_format($data['gaji_per_jam'], 0, ',', '.'));
            CLI::write("    Total kehadiran: {$data['total_kehadiran']} hari");
            CLI::write("    Total jam kerja: {$data['total_jam_kerja']} jam");
            CLI::write("    Total gaji: Rp " . number_format($data['total_gaji'], 0, ',', '.'));
            
            // Validasi khusus untuk karyawan test
            if (strpos($data['nama_karyawan'], 'Test Feb 2025') !== false) {
                CLI::write("\n    ✅ VERIFIKASI KARYAWAN TEST:", 'green');
                
                if ($data['total_kehadiran'] == 24) {
                    CLI::write("    ✓ Kehadiran 24 hari (FULL) - SESUAI", 'green');
                } else {
                    CLI::error("    ✗ Kehadiran {$data['total_kehadiran']} hari - TIDAK SESUAI (harusnya 24)");
                }
                
                if ($data['total_jam_kerja'] == 173) {
                    CLI::write("    ✓ Total jam 173 jam - SESUAI (auto-cap untuk full attendance)", 'green');
                } else {
                    CLI::error("    ✗ Total jam {$data['total_jam_kerja']} jam - TIDAK SESUAI (harusnya 173)");
                }
                
                $expectedGaji = 173 * $data['gaji_per_jam'];
                if ($data['total_gaji'] == $expectedGaji) {
                    CLI::write("    ✓ Total gaji Rp " . number_format($expectedGaji, 0, ',', '.') . " - SESUAI", 'green');
                } else {
                    CLI::error("    ✗ Total gaji tidak sesuai");
                }
            }
            
            CLI::write("\n" . str_repeat("-", 80) . "\n");
        }

        CLI::write("\n=== RINGKASAN LOGIKA BARU ===", 'yellow');
        CLI::write("1. Jam masuk: 07:45 (sebelumnya 08:00)");
        CLI::write("2. Jam keluar: 16:45 (sebelumnya 16:00)");
        CLI::write("3. Punishment 1 jam wajib setiap hari (tidak dibayar)");
        CLI::write("4. Pembulatan: <15 menit ke bawah, ≥15 menit ke atas");
        CLI::write("5. Lembur: tetap >17:00");
        CLI::write("6. Jika karyawan hadir FULL (100%), otomatis dapat 173 jam");
        CLI::write("7. Maksimal jam per bulan: 173 jam (cap)");
        CLI::write("\n✅ Verifikasi selesai!", 'green');
    }
}

