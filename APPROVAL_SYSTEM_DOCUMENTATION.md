# Sistem Approval Documentation

## Overview
Sistem approval telah diimplementasikan untuk memberikan kontrol yang lebih ketat terhadap operasi CRUD (Create, Read, Update, Delete) yang dilakukan oleh admin. Setiap operasi yang dilakukan oleh admin biasa akan memerlukan persetujuan dari superadmin sebelum dapat dieksekusi.

## Fitur Utama

### 1. Layer Approval untuk Admin
- **Admin biasa**: Semua operasi CRUD (create, update, delete) memerlukan approval dari superadmin
- **Super admin**: Dapat melakukan operasi CRUD langsung tanpa approval
- **User**: Tidak dapat melakukan operasi CRUD

### 2. Jenis Operasi yang Memerlukan Approval
- **Create**: Penambahan data baru (admin, karyawan, dll)
- **Update**: Perubahan data yang sudah ada
- **Delete**: Penghapusan data

### 3. Workflow Approval
1. Admin melakukan operasi CRUD
2. Sistem membuat request approval
3. Superadmin meninjau request
4. Superadmin dapat approve atau reject
5. Jika approved, operasi dieksekusi
6. Jika rejected, operasi dibatalkan

## Komponen Sistem

### 1. Database Schema
**Tabel: `approval_requests`**
```sql
- id (INT, PRIMARY KEY)
- request_type (ENUM: 'create', 'update', 'delete')
- table_name (VARCHAR): Nama tabel yang akan diubah
- record_id (INT): ID record yang akan diubah (null untuk create)
- request_data (TEXT): JSON data yang akan disimpan/diubah
- original_data (TEXT): JSON data asli (untuk update/delete)
- requested_by (INT): ID admin yang meminta approval
- approved_by (INT): ID superadmin yang approve
- status (ENUM: 'pending', 'approved', 'rejected')
- approval_notes (TEXT): Catatan dari superadmin
- rejection_reason (TEXT): Alasan penolakan
- created_at (DATETIME)
- updated_at (DATETIME)
- approved_at (DATETIME)
```

### 2. Models
- **ApprovalModel**: Mengelola data approval requests
- **ApprovalHelper**: Helper untuk logika approval

### 3. Controllers
- **ApprovalManagement**: Controller untuk superadmin mengelola approval
- **DataAdmin**: Controller admin yang dimodifikasi untuk menggunakan approval

### 4. Views
- **approval-management.php**: Halaman utama manajemen approval
- **list-approval-requests.php**: List request approval
- **detail-approval-request.php**: Detail request approval

## Implementasi

### 1. Migration
```bash
php spark migrate
```

### 2. Routes
```php
// Approval Management (Super Admin only)
$routes->group('approval', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('/', 'ApprovalManagement::index');
    $routes->post('get-requests', 'ApprovalManagement::getApprovalRequests');
    $routes->get('detail/(:num)', 'ApprovalManagement::detail/$1');
    $routes->post('approve/(:num)', 'ApprovalManagement::approve/$1');
    $routes->post('reject/(:num)', 'ApprovalManagement::reject/$1');
    $routes->post('bulk-approve', 'ApprovalManagement::bulkApprove');
    $routes->post('bulk-reject', 'ApprovalManagement::bulkReject');
    $routes->get('stats', 'ApprovalManagement::getStats');
});
```

### 3. Menu Sidebar
Menu "Manajemen Approval" ditambahkan ke sidebar untuk superadmin dengan akses:
- Hanya superadmin yang dapat melihat menu ini
- Menu menggunakan ikon "approval"
- Warna sidebar: warning (kuning)

## Penggunaan

### 1. Untuk Admin Biasa
1. Login sebagai admin biasa
2. Lakukan operasi CRUD (create, update, delete)
3. Sistem akan menampilkan pesan "Request telah dikirim dan menunggu persetujuan superadmin"
4. Data tidak langsung tersimpan, menunggu approval

### 2. Untuk Super Admin
1. Login sebagai super admin
2. Akses menu "Manajemen Approval"
3. Lihat daftar request yang pending
4. Klik "Detail" untuk melihat detail request
5. Pilih "Approve" atau "Reject"
6. Jika approve, operasi akan dieksekusi
7. Jika reject, berikan alasan penolakan

### 3. Fitur Bulk Actions
- **Bulk Approve**: Approve multiple requests sekaligus
- **Bulk Reject**: Reject multiple requests sekaligus dengan alasan yang sama

## Status Approval

### 1. Pending
- Request menunggu persetujuan superadmin
- Ditampilkan dengan badge kuning "Pending Approval"

### 2. Approved
- Request telah disetujui dan dieksekusi
- Ditampilkan dengan badge hijau "Approved"

### 3. Rejected
- Request ditolak oleh superadmin
- Ditampilkan dengan badge merah "Rejected"

## Keamanan

### 1. Role-based Access
- Hanya super admin yang dapat mengakses manajemen approval
- Admin biasa tidak dapat melihat menu approval
- User tidak dapat melakukan operasi CRUD

### 2. Data Integrity
- Data asli disimpan untuk operasi update/delete
- Request data disimpan dalam format JSON
- Audit trail lengkap dengan timestamp

### 3. Validation
- Validasi input tetap dilakukan sebelum membuat request
- Request hanya dibuat jika validasi berhasil

## Monitoring dan Reporting

### 1. Statistics
- Total requests
- Pending requests
- Approved requests
- Rejected requests

### 2. History
- Semua request tersimpan dengan timestamp
- Dapat melihat siapa yang meminta dan siapa yang approve
- Catatan approval dan alasan penolakan

### 3. Filtering
- Filter berdasarkan status (all, pending, approved, rejected)
- Search dan sorting
- Pagination untuk performa

## Troubleshooting

### 1. Request tidak muncul
- Pastikan user adalah super admin
- Cek role di database
- Pastikan menu approval_management aktif

### 2. Approval tidak berfungsi
- Cek permission super admin
- Pastikan request masih pending
- Cek log error di aplikasi

### 3. Data tidak tersimpan setelah approve
- Cek model yang digunakan di ApprovalHelper
- Pastikan method executeApprovedRequest berfungsi
- Cek log error di database

## Future Enhancements

### 1. Notifikasi
- Email notification untuk super admin
- Real-time notification
- WhatsApp notification

### 2. Advanced Filtering
- Filter berdasarkan tanggal
- Filter berdasarkan user
- Filter berdasarkan tipe operasi

### 3. Approval Levels
- Multi-level approval
- Department-based approval
- Custom approval workflow

### 4. Reporting
- Export approval history
- Approval statistics dashboard
- Performance metrics

## Conclusion

Sistem approval telah berhasil diimplementasikan dengan fitur-fitur:
- ✅ Layer approval untuk admin biasa
- ✅ Interface manajemen untuk super admin
- ✅ Status tracking dan monitoring
- ✅ Bulk operations
- ✅ Security dan role-based access
- ✅ Audit trail lengkap

Sistem ini memberikan kontrol yang lebih ketat terhadap operasi data dan memastikan bahwa semua perubahan data mendapat persetujuan dari super admin.

