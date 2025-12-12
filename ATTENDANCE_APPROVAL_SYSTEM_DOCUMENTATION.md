# Dokumentasi Sistem Approval untuk Absensi

## Overview
Sistem approval telah diperluas untuk mencakup halaman absensi karyawan dan admin, memastikan bahwa setiap perubahan kehadiran memerlukan persetujuan dari superadmin sebelum dapat dieksekusi.

## Fitur yang Ditambahkan

### 1. Sistem Approval untuk Absensi
- **Absensi Karyawan**: Perubahan kehadiran karyawan memerlukan approval
- **Absensi Admin**: Perubahan kehadiran admin memerlukan approval
- **Konsistensi Data**: Semua perubahan kehadiran tercatat dengan status approval

### 2. Kolom Database Baru
Tabel `tb_presensi_karyawan` dan `tb_presensi_admin` telah ditambahkan kolom:
- `approval_status`: Status approval (pending, approved, rejected)
- `approval_request_id`: ID request approval yang terkait
- `approved_by`: ID admin yang approve perubahan
- `approved_at`: Waktu approval

## Implementasi Teknis

### 1. Migration Database
**File**: `app/Database/Migrations/2024-01-21-000001_AddApprovalColumnsToPresensiTables.php`

```php
// Menambahkan kolom approval ke tabel presensi
$this->forge->addColumn('tb_presensi_karyawan', [
    'approval_status' => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected']],
    'approval_request_id' => ['type' => 'INT', 'constraint' => 11],
    'approved_by' => ['type' => 'INT', 'constraint' => 11],
    'approved_at' => ['type' => 'DATETIME']
]);
```

### 2. Model Updates

#### PresensiKaryawanModel & PresensiAdminModel
- Menambahkan field approval ke `$allowedFields`
- Memperbarui method `updatePresensi()` dengan parameter approval
- Menambahkan tracking approval status dan timestamp

### 3. Controller Updates

#### DataAbsenKaryawan.php
- Menambahkan import `ApprovalModel` dan `ApprovalHelper`
- Memodifikasi method `ubahKehadiran()` untuk menggunakan sistem approval
- Admin biasa: Request approval → Super admin: Langsung eksekusi

#### DataAbsenAdmin.php
- Implementasi yang sama seperti DataAbsenKaryawan
- Konsistensi dalam penanganan approval

### 4. ApprovalHelper Updates
- Menambahkan case untuk `tb_presensi_karyawan` dan `tb_presensi_admin`
- Memperbarui method `executeUpdate()` untuk presensi
- Menggunakan method `updatePresensi()` dengan parameter approval

## Workflow Approval Absensi

### 1. Admin Biasa Mengubah Kehadiran
1. Admin mengubah status kehadiran karyawan/admin
2. Sistem cek role admin
3. Jika admin biasa → Buat request approval
4. Data disimpan dengan status "pending"
5. Notifikasi dikirim ke super admin

### 2. Super Admin Review & Approve
1. Super admin melihat request approval
2. Review perubahan yang diminta
3. Approve atau reject request
4. Jika approved → Data kehadiran diupdate
5. Status approval diupdate ke "approved"

### 3. Tracking & History
- Semua perubahan tercatat di history
- Status approval tersimpan di database
- Timestamp approval dicatat
- User yang approve tercatat

## API Endpoints

### Absensi Karyawan
- `POST /absen-karyawan/edit` - Ubah kehadiran (dengan approval)

### Absensi Admin  
- `POST /absen-admin/edit` - Ubah kehadiran (dengan approval)

## Response Format

### Success Response (Admin Biasa)
```json
{
    "status": true,
    "message": "Request perubahan kehadiran telah dikirim dan menunggu persetujuan superadmin",
    "nama_karyawan": "John Doe"
}
```

### Success Response (Super Admin)
```json
{
    "status": true,
    "nama_karyawan": "John Doe"
}
```

## Database Schema

### Tabel tb_presensi_karyawan
```sql
ALTER TABLE tb_presensi_karyawan ADD COLUMN approval_status ENUM('pending', 'approved', 'rejected') DEFAULT 'approved';
ALTER TABLE tb_presensi_karyawan ADD COLUMN approval_request_id INT(11) NULL;
ALTER TABLE tb_presensi_karyawan ADD COLUMN approved_by INT(11) NULL;
ALTER TABLE tb_presensi_karyawan ADD COLUMN approved_at DATETIME NULL;
```

### Tabel tb_presensi_admin
```sql
ALTER TABLE tb_presensi_admin ADD COLUMN approval_status ENUM('pending', 'approved', 'rejected') DEFAULT 'approved';
ALTER TABLE tb_presensi_admin ADD COLUMN approval_request_id INT(11) NULL;
ALTER TABLE tb_presensi_admin ADD COLUMN approved_by INT(11) NULL;
ALTER TABLE tb_presensi_admin ADD COLUMN approved_at DATETIME NULL;
```

## Testing

### Test Cases
1. **Admin Biasa Mengubah Kehadiran**
   - Login sebagai admin biasa
   - Ubah status kehadiran karyawan
   - Verifikasi request approval dibuat
   - Verifikasi data tidak berubah sampai di-approve

2. **Super Admin Approve**
   - Login sebagai super admin
   - Lihat request approval
   - Approve request
   - Verifikasi data kehadiran berubah

3. **Super Admin Langsung Ubah**
   - Login sebagai super admin
   - Ubah status kehadiran langsung
   - Verifikasi perubahan langsung diterapkan

## Keamanan

### Role-Based Access
- **Admin Biasa**: Hanya bisa request approval
- **Super Admin**: Bisa approve/reject dan langsung ubah
- **User**: Tidak bisa akses fitur absensi

### Data Integrity
- Semua perubahan tercatat di history
- Status approval selalu terupdate
- Timestamp dan user tracking lengkap

## Monitoring & Logging

### Log Events
- Request approval dibuat
- Approval diberikan/ditolak
- Perubahan kehadiran dieksekusi
- Error dalam proses approval

### Audit Trail
- Siapa yang mengubah kehadiran
- Kapan perubahan dilakukan
- Siapa yang approve perubahan
- Status approval lengkap

## Maintenance

### Database Cleanup
- Archive old approval requests
- Clean up rejected requests
- Optimize query performance

### Monitoring
- Track approval response time
- Monitor rejection rate
- Alert on system errors

## Future Enhancements

### Planned Features
1. **Email Notifications**: Notifikasi email untuk approval
2. **Bulk Approval**: Approve multiple requests sekaligus
3. **Approval Rules**: Custom rules untuk auto-approval
4. **Dashboard**: Dashboard khusus untuk approval management
5. **Mobile Support**: Approval via mobile app

### Performance Optimization
1. **Caching**: Cache approval status
2. **Indexing**: Optimize database indexes
3. **Pagination**: Paginate approval requests
4. **Search**: Search approval requests

## Troubleshooting

### Common Issues
1. **Approval tidak berfungsi**: Cek role user dan permission
2. **Data tidak berubah**: Cek status approval dan eksekusi
3. **History tidak tercatat**: Cek model dan database connection
4. **Performance lambat**: Cek database indexes dan query

### Debug Steps
1. Cek log file untuk error
2. Verifikasi database schema
3. Test dengan user berbeda
4. Cek network dan server status
