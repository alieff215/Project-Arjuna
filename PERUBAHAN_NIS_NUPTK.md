# Dokumentasi Perubahan: Menghapus Batas Karakter NIS dan NUPTK

## Ringkasan Perubahan

Telah dilakukan perubahan untuk menghilangkan batasan panjang karakter pada input NIS (untuk karyawan) dan NUPTK (untuk admin). Validasi sekarang hanya mengecek apakah field kosong atau tidak (menggunakan `permit_empty`).

## File yang Telah Diubah

### 1. Controller Karyawan
**File:** `app/Controllers/Admin/DataKaryawan.php`

**Perubahan:**
- Baris 27: Validasi NIS diubah dari `'rules' => 'required|max_length[20]|min_length[4]'` menjadi `'rules' => 'permit_empty'`
- Baris 234: Validasi NIS saat edit diubah dari `'required|max_length[20]|min_length[4]|is_unique[tb_karyawan.nis]'` menjadi `'permit_empty|is_unique[tb_karyawan.nis]'`

### 2. Controller Admin
**File:** `app/Controllers/Admin/DataAdmin.php`

**Perubahan:**
- Baris 22: Validasi NUPTK diubah dari `'rules' => 'required|max_length[20]|min_length[16]'` menjadi `'rules' => 'permit_empty'`

### 3. Migration Database
**File:** `app/Database/Migrations/2025-11-04-000001_RemoveNisNuptkLengthLimit.php`

Migration file telah dibuat untuk mengubah struktur database.

## Langkah-langkah yang Perlu Dilakukan

### ⚠️ PENTING: Perubahan Database Manual

Karena ada issue dengan migration yang belum terselesaikan, Anda perlu menjalankan query SQL berikut secara manual:

#### Opsi 1: Menggunakan phpMyAdmin
1. Buka phpMyAdmin di browser (biasanya http://localhost/phpmyadmin)
2. Pilih database `arjuna2`
3. Klik tab "SQL"
4. Jalankan query berikut:

```sql
-- Ubah kolom NIS di tb_karyawan dari VARCHAR(16) ke VARCHAR(255)
ALTER TABLE tb_karyawan MODIFY nis VARCHAR(255) NOT NULL;

-- Ubah kolom NUPTK di tb_admin dari VARCHAR(24) ke VARCHAR(255)
ALTER TABLE tb_admin MODIFY nuptk VARCHAR(255) NOT NULL;
```

#### Opsi 2: Menggunakan MySQL CLI
```bash
mysql -u root -p
```

Kemudian jalankan:
```sql
USE arjuna2;

ALTER TABLE tb_karyawan MODIFY nis VARCHAR(255) NOT NULL;
ALTER TABLE tb_admin MODIFY nuptk VARCHAR(255) NOT NULL;

EXIT;
```

#### Opsi 3: Menggunakan XAMPP Shell
1. Buka XAMPP Control Panel
2. Klik "Shell"
3. Jalankan perintah:
```bash
mysql -u root -p arjuna2 -e "ALTER TABLE tb_karyawan MODIFY nis VARCHAR(255) NOT NULL; ALTER TABLE tb_admin MODIFY nuptk VARCHAR(255) NOT NULL;"
```

## Hasil Perubahan

### Sebelum:
- **NIS (Karyawan):** 
  - Validasi: Wajib diisi, minimal 4 karakter, maksimal 20 karakter
  - Database: VARCHAR(16)

- **NUPTK (Admin):**
  - Validasi: Wajib diisi, minimal 16 karakter, maksimal 20 karakter
  - Database: VARCHAR(24)

### Sesudah:
- **NIS (Karyawan):**
  - Validasi: Boleh kosong (`permit_empty`), tidak ada batasan panjang karakter
  - Database: VARCHAR(255)

- **NUPTK (Admin):**
  - Validasi: Boleh kosong (`permit_empty`), tidak ada batasan panjang karakter
  - Database: VARCHAR(255)

## Testing

Setelah menjalankan query SQL di atas, Anda dapat menguji dengan:

1. **Tambah Karyawan Baru:**
   - Buka menu Data Karyawan → Tambah Karyawan
   - Coba input NIS dengan berbagai panjang karakter (lebih dari 20 karakter)
   - Pastikan tidak ada error validasi

2. **Edit Karyawan:**
   - Edit data karyawan yang sudah ada
   - Ubah NIS menjadi lebih panjang
   - Simpan dan pastikan berhasil

3. **Tambah Admin Baru:**
   - Buka menu Data Admin → Tambah Admin
   - Coba input NUPTK dengan berbagai panjang karakter
   - Pastikan tidak ada error validasi

4. **Edit Admin:**
   - Edit data admin yang sudah ada
   - Ubah NUPTK menjadi lebih panjang
   - Simpan dan pastikan berhasil

## Catatan

- Field NIS dan NUPTK sekarang menggunakan validasi `permit_empty`, yang berarti field boleh dikosongkan
- Validasi `is_unique` tetap berfungsi untuk memastikan tidak ada duplikasi NIS/NUPTK
- Tidak ada lagi batasan minimum atau maksimum karakter
- Form HTML tidak memiliki atribut `maxlength`, sehingga user bisa memasukkan teks sepanjang apapun

## Rollback (Jika Diperlukan)

Jika ingin mengembalikan ke kondisi semula, jalankan:

```sql
-- Kembalikan kolom NIS ke VARCHAR(16)
ALTER TABLE tb_karyawan MODIFY nis VARCHAR(16) NOT NULL;

-- Kembalikan kolom NUPTK ke VARCHAR(24)
ALTER TABLE tb_admin MODIFY nuptk VARCHAR(24) NOT NULL;
```

Kemudian ubah kembali validasi di controller sesuai kondisi awal.

---
**Tanggal Perubahan:** 4 November 2025  
**Status:** ✅ Perubahan kode selesai | ⏳ Perubahan database menunggu eksekusi manual

