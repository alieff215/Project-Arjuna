# Daftar File yang Diubah - Fitur Scan & Login Absen

## File Baru (Untracked/New Files)

### 1. Controller
- **`app/Controllers/LoginAbsen.php`** - Controller baru untuk fitur login absen

### 2. View
- **`app/Views/scan/login_absen.php`** - View halaman login khusus untuk absen

---

## File yang Dimodifikasi (Modified Files)

### 1. Controller
- **`app/Controllers/Scan.php`** - Controller utama untuk fitur scan QR Code
  - Menambahkan pengecekan login sebelum akses scan
  - Redirect ke halaman login absen jika belum login
  - Update method `index()` untuk handle routing scan/masuk dan scan/pulang

### 2. View - Scan
- **`app/Views/scan/scan_main.php`** - Halaman utama menu scan
  - Menghilangkan template (standalone page)
  - Update styling dan layout
  - Menambahkan button mode gelap
  - Perbaikan kontras untuk dark mode

- **`app/Views/scan/scan_user.php`** - Halaman scan untuk user biasa
  - Menghilangkan template (standalone page)
  - Menambahkan button mode gelap
  - Perbaikan kontras teks dan button untuk dark mode
  - Merapikan header card "Absen Masuk/Pulang"
  - Membuat button mode scan lebih profesional
  - Membuat select pilih kamera lebih profesional
  - Menghilangkan titik merah pada button mode scan
  - Perbaikan typography dan spacing

- **`app/Views/scan/scan_admin.php`** - Halaman scan untuk admin
  - Update styling dan layout

### 3. Config
- **`app/Config/Routes.php`** - Routing untuk fitur scan dan login absen
  - Menambahkan route `/scan/login` untuk LoginAbsen
  - Menambahkan route `/scan/logout` untuk logout
  - Route `/scan/masuk` dan `/scan/pulang` untuk scan

- **`app/Config/Filters.php`** - Filter untuk autentikasi (jika ada perubahan)

### 4. Template
- **`app/Views/templates/starting_page_layout.php`** - Template layout (jika ada perubahan)

---

## Ringkasan Perubahan

### Fitur Utama yang Ditambahkan:
1. **Login Absen** - Sistem login khusus untuk absen
2. **Mode Gelap** - Dark mode toggle pada halaman scan
3. **UI/UX Improvements** - Perbaikan tampilan dan interaksi
4. **Professional Button Design** - Button mode scan dan select kamera yang lebih profesional

### File yang Paling Banyak Diubah:
1. `app/Views/scan/scan_user.php` - Perubahan besar pada styling dan layout
2. `app/Controllers/Scan.php` - Update logic untuk login check
3. `app/Config/Routes.php` - Menambahkan route baru

---

## Catatan
- File dengan status `MM` berarti ada perubahan yang sudah di-stage dan belum di-stage
- File dengan status `M` berarti ada perubahan yang belum di-stage
- File dengan status `??` berarti file baru yang belum di-track oleh git




