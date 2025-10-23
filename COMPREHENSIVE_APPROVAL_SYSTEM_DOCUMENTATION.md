# Dokumentasi Sistem Approval Komprehensif

## Ringkasan
Sistem approval telah diimplementasikan untuk semua halaman CRUD yang dapat diakses admin, memastikan bahwa setiap operasi Create, Update, dan Delete memerlukan persetujuan dari superadmin.

## Controller yang Dimodifikasi

### 1. DataAdmin.php
**Lokasi**: `app/Controllers/Admin/DataAdmin.php`
**Tabel**: `tb_admin`
**Operasi yang dilindungi**:
- ✅ Create Admin (`saveAdmin`)
- ✅ Update Admin (`updateAdmin`) 
- ✅ Delete Admin (`delete`)

### 2. DataKaryawan.php
**Lokasi**: `app/Controllers/Admin/DataKaryawan.php`
**Tabel**: `tb_karyawan`
**Operasi yang dilindungi**:
- ✅ Create Karyawan (`saveKaryawan`)
- ✅ Update Karyawan (`updateKaryawan`)
- ✅ Delete Karyawan (`delete`)

### 3. DepartemenController.php
**Lokasi**: `app/Controllers/Admin/DepartemenController.php`
**Tabel**: `tb_departemen`
**Operasi yang dilindungi**:
- ✅ Create Departemen (`tambahDepartemenPost`)
- ✅ Update Departemen (`editDepartemenPost`)
- ✅ Delete Departemen (`deleteDepartemenPost`)

### 4. JabatanController.php
**Lokasi**: `app/Controllers/Admin/JabatanController.php`
**Tabel**: `tb_jabatan`
**Operasi yang dilindungi**:
- ✅ Create Jabatan (`tambahJabatanPost`)
- ✅ Update Jabatan (`editJabatanPost`)
- ✅ Delete Jabatan (`deleteJabatanPost`)

### 5. InventoryController.php
**Lokasi**: `app/Controllers/Admin/InventoryController.php`
**Tabel**: `tb_inventory`
**Operasi yang dilindungi**:
- ✅ Create Inventory (`store`)
- ✅ Delete Inventory (`delete`)

### 6. Gaji.php
**Lokasi**: `app/Controllers/Admin/Gaji.php`
**Tabel**: `tb_gaji`
**Operasi yang dilindungi**:
- ✅ Create Gaji (`store`)
- ✅ Update Gaji (`update`)
- ✅ Delete Gaji (`delete`)

## Implementasi Teknis

### 1. Import dan Inisialisasi
Setiap controller yang dimodifikasi telah menambahkan:
```php
use App\Models\ApprovalModel;
use App\Libraries\ApprovalHelper;

// Di constructor
$this->approvalModel = new ApprovalModel();
$this->approvalHelper = new ApprovalHelper();
```

### 2. Logika Approval
Setiap operasi CRUD menggunakan pola yang sama:

```php
// Cek apakah memerlukan approval
if ($this->approvalHelper->requiresApproval()) {
    // Buat request approval
    $approvalId = $this->approvalHelper->createApprovalRequest(
        'create/update/delete',
        'nama_tabel',
        $recordId, // null untuk create
        $requestData, // data baru
        $originalData // data lama (untuk update/delete)
    );
    
    if ($approvalId) {
        // Redirect dengan pesan sukses
        return redirect()->with('success', 'Request telah dikirim...');
    } else {
        // Redirect dengan pesan error
        return redirect()->with('error', 'Gagal mengirim request...');
    }
} else {
    // Langsung eksekusi (untuk super admin)
    // ... logika CRUD asli
}
```

### 3. Pesan Notifikasi
Setiap operasi memiliki pesan notifikasi yang spesifik:

**Create Operations**:
- "Request penambahan data [entity] telah dikirim dan menunggu persetujuan superadmin"

**Update Operations**:
- "Request perubahan data [entity] telah dikirim dan menunggu persetujuan superadmin"

**Delete Operations**:
- "Request penghapusan data [entity] telah dikirim dan menunggu persetujuan superadmin"

## Tabel Database yang Dilindungi

| No | Tabel | Controller | Operasi |
|----|-------|------------|---------|
| 1 | `tb_admin` | DataAdmin | Create, Update, Delete |
| 2 | `tb_karyawan` | DataKaryawan | Create, Update, Delete |
| 3 | `tb_departemen` | DepartemenController | Create, Update, Delete |
| 4 | `tb_jabatan` | JabatanController | Create, Update, Delete |
| 5 | `tb_inventory` | InventoryController | Create, Delete |
| 6 | `tb_gaji` | Gaji | Create, Update, Delete |

## Fitur yang Sudah Diimplementasikan

### 1. Sistem Approval Core
- ✅ `ApprovalModel` - Model untuk mengelola approval requests
- ✅ `ApprovalHelper` - Library untuk logika approval
- ✅ `ApprovalManagement` - Controller untuk superadmin
- ✅ Database migration untuk tabel `approval_requests`

### 2. Interface Superadmin
- ✅ Dashboard approval management
- ✅ List approval requests dengan filter
- ✅ Detail approval request dengan diff view
- ✅ Bulk approve/reject
- ✅ Statistics dan reporting

### 3. Integrasi dengan RBAC
- ✅ Menu "Manajemen Approval" hanya untuk superadmin
- ✅ Access control menggunakan `RoleHelper`
- ✅ Sidebar integration dengan context detection

### 4. User Experience
- ✅ Status approval di list data
- ✅ Notifikasi yang jelas untuk setiap operasi
- ✅ Redirect yang konsisten setelah operasi

## Cara Kerja Sistem

### 1. Untuk Admin Biasa
1. Admin melakukan operasi CRUD (Create/Update/Delete)
2. Sistem mengecek `requiresApproval()` - return `true`
3. Request approval dibuat dan disimpan ke database
4. Admin mendapat notifikasi "Request telah dikirim..."
5. Data tidak langsung berubah, menunggu approval

### 2. Untuk Super Admin
1. Super admin melakukan operasi CRUD
2. Sistem mengecek `requiresApproval()` - return `false`
3. Operasi langsung dieksekusi
4. Super admin mendapat notifikasi "Data berhasil..."

### 3. Proses Approval
1. Super admin mengakses menu "Manajemen Approval"
2. Melihat daftar request yang pending
3. Bisa approve atau reject dengan catatan
4. Jika approve, operasi dieksekusi otomatis
5. Jika reject, request dibatalkan

## Testing

### 1. Test sebagai Admin Biasa
```bash
# Login sebagai admin biasa
# Coba tambah/edit/hapus data
# Verifikasi muncul notifikasi "Request telah dikirim..."
# Cek di database tabel approval_requests
```

### 2. Test sebagai Super Admin
```bash
# Login sebagai super admin
# Coba tambah/edit/hapus data
# Verifikasi data langsung berubah
# Verifikasi tidak ada request approval yang dibuat
```

### 3. Test Approval Process
```bash
# Login sebagai super admin
# Akses /admin/approval
# Lihat daftar request
# Test approve/reject
# Verifikasi data berubah sesuai approval
```

## Monitoring dan Maintenance

### 1. Log Files
- Semua operasi approval dicatat di log
- Error handling yang komprehensif
- Debug information untuk troubleshooting

### 2. Database Monitoring
```sql
-- Cek request pending
SELECT * FROM approval_requests WHERE status = 'pending';

-- Cek request per user
SELECT requested_by, COUNT(*) as total_requests 
FROM approval_requests 
GROUP BY requested_by;

-- Cek request per tabel
SELECT table_name, COUNT(*) as total_requests 
FROM approval_requests 
GROUP BY table_name;
```

### 3. Performance
- Index pada kolom yang sering diquery
- Efficient query dengan JOIN
- Pagination untuk list yang besar

## Keamanan

### 1. Access Control
- Hanya super admin yang bisa approve
- Role-based access control
- Session validation

### 2. Data Integrity
- Validasi data sebelum approval
- Rollback jika operasi gagal
- Audit trail lengkap

### 3. Input Validation
- Sanitasi input
- Validasi format data
- Protection terhadap SQL injection

## Troubleshooting

### 1. Request tidak terbuat
- Cek `ApprovalHelper::requiresApproval()`
- Cek session user
- Cek role assignment

### 2. Approval tidak dieksekusi
- Cek `ApprovalHelper::executeApprovedRequest()`
- Cek model yang digunakan
- Cek database constraints

### 3. Menu tidak muncul
- Cek `RoleHelper::getAccessibleMenus()`
- Cek user role
- Cek sidebar template

## Kesimpulan

Sistem approval telah berhasil diimplementasikan untuk semua halaman CRUD yang dapat diakses admin. Sistem ini memberikan:

1. **Kontrol penuh** - Super admin memiliki kontrol penuh atas semua perubahan data
2. **Audit trail** - Semua perubahan tercatat dengan detail
3. **User experience** - Interface yang intuitif untuk approval management
4. **Keamanan** - Role-based access control yang ketat
5. **Fleksibilitas** - Mudah untuk menambah tabel baru ke sistem approval

Sistem ini memastikan bahwa tidak ada perubahan data yang terjadi tanpa persetujuan super admin, memberikan tingkat keamanan dan kontrol yang tinggi untuk organisasi.
