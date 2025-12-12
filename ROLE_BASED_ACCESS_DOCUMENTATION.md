# Role-Based Access Control Documentation

## Overview
Sistem role-based access control telah diimplementasikan untuk membatasi akses pengguna berdasarkan role mereka.

## Role Hierarchy

### 1. Super Admin (`super_admin`)
- **Akses**: Semua masterdata termasuk data petugas
- **Menu yang bisa diakses**:
  - Dashboard
  - Data Admin
  - Data Karyawan  
  - Data Petugas (hanya super admin)
  - Data Departemen & Jabatan
  - Data Absen Admin
  - Data Absen Karyawan
  - Data Gaji
  - Data Inventory
  - Generate QR Code
  - Generate Laporan
  - General Settings (hanya super admin)
  - Scan QR Code

### 2. Admin (`admin`)
- **Akses**: Masterdata kecuali data petugas
- **Menu yang bisa diakses**:
  - Dashboard
  - Data Admin
  - Data Karyawan
  - Data Departemen & Jabatan
  - Data Absen Admin
  - Data Absen Karyawan
  - Data Gaji
  - Data Inventory
  - Generate QR Code
  - Generate Laporan
  - Scan QR Code
- **Tidak bisa akses**:
  - Data Petugas
  - General Settings

### 3. User (`user`)
- **Akses**: Hanya menu scan
- **Menu yang bisa diakses**:
  - Scan QR Code
- **Tidak bisa akses**:
  - Semua menu masterdata
  - Dashboard admin

## Implementation Details

### 1. RoleHelper Library
File: `app/Libraries/RoleHelper.php`
- `getUserRole()`: Mendapatkan role user saat ini
- `hasAccess()`: Cek apakah user memiliki akses ke fitur tertentu
- `canAccessMasterData()`: Cek akses masterdata
- `canAccessPetugas()`: Cek akses data petugas (hanya super admin)
- `canAccessScan()`: Cek akses menu scan
- `getAccessibleMenus()`: Daftar menu yang bisa diakses berdasarkan role

### 2. UserRole Enum
File: `app/Libraries/enums/UserRole.php`
- `SUPER_ADMIN`: Super admin role
- `ADMIN`: Admin role  
- `USER`: User role

### 3. RoleAccess Filter
File: `app/Filters/RoleAccess.php`
- Filter untuk mengecek akses berdasarkan role
- Redirect otomatis jika tidak memiliki akses

### 4. Database Changes
- Migration: `2024-01-01-000001_AddUserRole.php`
- Menambahkan field `user_role` ke tabel `users`
- Backward compatibility dengan field `is_superadmin`

## Testing Guide

### 1. Test Super Admin Access
```php
// Login sebagai super admin
// Akses: /admin/dashboard - harus bisa
// Akses: /admin/petugas - harus bisa
// Akses: /admin/general-settings - harus bisa
// Akses: /scan - harus bisa
```

### 2. Test Admin Access
```php
// Login sebagai admin
// Akses: /admin/dashboard - harus bisa
// Akses: /admin/petugas - harus redirect ke dashboard
// Akses: /admin/general-settings - harus redirect ke dashboard
// Akses: /scan - harus bisa
```

### 3. Test User Access
```php
// Login sebagai user
// Akses: /admin/dashboard - harus redirect ke /scan
// Akses: /admin/petugas - harus redirect ke /scan
// Akses: /scan - harus bisa
```

## Controller Updates

### Updated Controllers:
1. `app/Controllers/Admin/Dashboard.php`
2. `app/Controllers/Admin/DataAdmin.php`
3. `app/Controllers/Admin/DataKaryawan.php`
4. `app/Controllers/Admin/DataPetugas.php`
5. `app/Controllers/Admin/DataAbsenAdmin.php`
6. `app/Controllers/Admin/DataAbsenKaryawan.php`
7. `app/Controllers/Admin/DepartemenController.php`
8. `app/Controllers/Scan.php`

### View Updates:
1. `app/Views/templates/sidebar.php` - Menu berdasarkan role
2. `app/Views/templates/user_sidebar.php` - Sidebar khusus user
3. `app/Views/templates/user_page_layout.php` - Layout khusus user

## Usage Examples

### 1. Cek Role di Controller
```php
// Cek apakah user bisa akses masterdata
if (!$this->roleHelper->canAccessMasterData()) {
    return redirect()->to('/scan');
}

// Cek apakah user bisa akses data petugas
if (!$this->roleHelper->canAccessPetugas()) {
    return redirect()->to('admin/dashboard');
}
```

### 2. Cek Role di View
```php
// Tampilkan menu berdasarkan role
<?php if ($accessibleMenus['data_petugas'] ?? false): ?>
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('admin/petugas'); ?>">
        <i class="material-icons">computer</i>
        <p>Data Petugas</p>
    </a>
</li>
<?php endif; ?>
```

### 3. Cek Role di Filter
```php
// Gunakan filter di routes
$routes->group('admin', ['filter' => 'role_access:admin'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
});
```

## Migration Commands

```bash
# Jalankan migration
php spark migrate

# Rollback migration (jika diperlukan)
php spark migrate:rollback
```

## Notes

1. **Backward Compatibility**: Sistem tetap mendukung field `is_superadmin` untuk backward compatibility
2. **Default Role**: User baru akan memiliki role `user` secara default
3. **Layout**: User dengan role `user` akan menggunakan layout khusus yang hanya menampilkan menu scan
4. **Security**: Semua controller admin sudah dilindungi dengan pengecekan role
5. **Menu Dynamic**: Menu sidebar akan menampilkan/menyembunyikan item berdasarkan role user
