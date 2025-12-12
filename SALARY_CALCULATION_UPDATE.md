# Update Perhitungan Gaji - November 2025

## Perubahan Logika Penghitungan Gaji

### 1. **Perubahan Jam Kerja**
- **Jam Masuk**: 07:45 (sebelumnya 08:00)
- **Jam Keluar**: 16:45 (sebelumnya 16:00)
- **Sabtu**: Jam masuk 07:45, keluar 13:00

### 2. **Punishment 1 Jam Wajib**
- Setiap hari kerja akan dikurangi **1 jam (60 menit)** yang tidak dibayar
- Pengurangan dilakukan setelah perhitungan menit kerja normal
- Jika hasil pengurangan negatif, akan dibuat menjadi 0

### 3. **Pembulatan (Tetap Sama)**
- Kurang dari 15 menit → Dibulatkan ke bawah
- 15 menit ke atas → Dibulatkan ke atas
- Sistem pembulatan per 30 menit tetap dipertahankan

### 4. **Lembur (Tetap Sama)**
- Tetap dihitung jika jam keluar karyawan lebih dari **17:00**
- Rate lembur sama dengan rate reguler

### 5. **Sistem Jam Kerja Standar: 173 Jam per Bulan**

#### Aturan Baru:
- **Jika karyawan hadir FULL (100% hari kerja)** dalam 1 bulan, **otomatis mendapat 173 jam**
- Tidak peduli apakah bulan tersebut memiliki 24, 25, 26, atau 27 hari kerja
- Jika karyawan tidak hadir full, hitung berdasarkan jam aktual (maksimal tetap 173 jam)

#### Contoh Kasus:

##### Kasus 1: Februari 2025 (24 hari kerja)
- Total hari kerja: 24 hari (Senin-Sabtu, tidak termasuk Minggu)
- Karyawan hadir: 24 hari (100%)
- Jam kerja aktual tanpa lembur: ~157 jam
- **Hasil akhir: 173 jam** (otomatis karena hadir full)

##### Kasus 2: Bulan dengan 26 hari kerja
- Total hari kerja: 26 hari
- Karyawan hadir: 26 hari (100%)
- Jam kerja aktual bisa > 173 jam
- **Hasil akhir: 173 jam** (di-cap ke maksimal)

##### Kasus 3: Karyawan tidak full
- Total hari kerja: 26 hari
- Karyawan hadir: 20 hari (tidak full)
- Jam kerja aktual: 140 jam
- **Hasil akhir: 140 jam** (sesuai aktual)

### 6. **Perhitungan Jam Kerja per Hari**

#### Senin - Jumat:
```
Jam masuk    : 07:45
Jam keluar   : 16:45
Total        : 9 jam
Istirahat    : 12:00-13:00 (1 jam, tidak dihitung)
Punishment   : 1 jam (tidak dibayar)
Net per hari : 7 jam
```

#### Sabtu:
```
Jam masuk    : 07:45
Jam keluar   : 13:00
Total        : 5 jam 15 menit
Punishment   : 1 jam (tidak dibayar)
Net per hari : 4.25 jam (setelah pembulatan)
```

## File yang Dimodifikasi

### 1. `app/Models/GajiModel.php`
- Method `getSalaryReport()` diperbarui dengan logika baru
- Menambahkan perhitungan total hari kerja dalam periode
- Menambahkan logika auto-cap 173 jam untuk karyawan full attendance
- Jam kerja diubah dari 08:00-16:00 menjadi 07:45-16:45
- Menambahkan punishment 1 jam per hari

### 2. Seeder untuk Testing

#### `app/Database/Seeds/FebruariFullAttendanceSeeder.php`
- Membuat data karyawan dengan presensi full di Februari 2025
- Dengan lembur (jam keluar 18:00)
- Total jam aktual ~177 jam → di-cap menjadi 173 jam

#### `app/Database/Seeds/FebruariFullAttendance168Seeder.php`
- Membuat data karyawan dengan presensi full di Februari 2025
- Tanpa lembur (jam keluar 16:45)
- Total jam aktual ~157 jam → naik menjadi 173 jam (karena hadir full)

### 3. Command untuk Verifikasi

#### `app/Commands/TestSalaryFebruary.php`
Command untuk memverifikasi perhitungan gaji:
```bash
php spark test:salary:february
```

## Cara Testing

### 1. Jalankan Seeder
```bash
# Seeder dengan lembur
php spark db:seed FebruariFullAttendanceSeeder

# Seeder tanpa lembur (demonstrasi auto 173 jam)
php spark db:seed FebruariFullAttendance168Seeder
```

### 2. Verifikasi Hasil
```bash
php spark test:salary:february
```

### 3. Lihat Laporan Gaji
Akses melalui aplikasi:
- Menu: Gaji → Laporan Gaji
- Pilih periode: Februari 2025 (2025-02-01 s/d 2025-02-28)
- Cari karyawan test: "Budi Santoso" atau "Siti Nurhaliza"

## Hasil Testing

Berdasarkan testing yang dilakukan:

### ✅ Karyawan Test 1: Budi Santoso (dengan lembur)
- Kehadiran: 24/24 hari (100%)
- Jam aktual: ~177 jam (termasuk lembur)
- Jam yang dibayar: **173 jam** (di-cap)
- Gaji: Rp 2.318.200 (173 jam × Rp 13.400)

### ✅ Karyawan Test 2: Siti Nurhaliza (tanpa lembur)
- Kehadiran: 24/24 hari (100%)
- Jam aktual: ~157 jam (tanpa lembur)
- Jam yang dibayar: **173 jam** (auto-cap karena full)
- Gaji: Rp 2.318.200 (173 jam × Rp 13.400)

## Kesimpulan

Logika perhitungan gaji telah berhasil diperbarui dengan:
1. ✅ Jam kerja baru (07:45-16:45)
2. ✅ Punishment 1 jam per hari
3. ✅ Sistem 173 jam standar untuk karyawan full-time
4. ✅ Auto-cap 173 jam untuk kehadiran 100%
5. ✅ Maksimal tetap 173 jam untuk semua kasus

**Tanggal Update**: 5 November 2025

