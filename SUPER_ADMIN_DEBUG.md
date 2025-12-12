# Super Admin Debug - Troubleshooting

## Masalah yang Dilaporkan
**Super admin malah masuk ke halaman user** - Ini berarti RoleHelper mengembalikan `UserRole::USER` untuk super admin.

## Debug Steps

### 1. **Akses Debug Session**
```
http://localhost/Project-Arjuna/debug/session
```
Ini akan menampilkan:
- Session data lengkap
- Role Helper debug
- User data dari database
- Myth Auth user function

### 2. **Cek Log Files**
Lihat file log di `writable/logs/` untuk melihat debug messages:
- Session data
- User data dari database
- Role detection process

### 3. **Kemungkinan Penyebab**

#### **A. Session Key Salah**
- Myth Auth mungkin menggunakan session key yang berbeda
- Cek apakah `user_id` ada di session
- Cek apakah `is_superadmin` ada di session

#### **B. Database Data Salah**
- Cek apakah user memiliki `is_superadmin = 1` di database
- Cek apakah user memiliki `user_role = 'super_admin'` di database
- Cek apakah user ada di tabel `users`

#### **C. Myth Auth User Function**
- Cek apakah `user()` function berfungsi
- Cek apakah user data lengkap dari Myth Auth

## Solusi yang Sudah Diimplementasikan

### 1. **RoleHelper Update**
- ✅ Menggunakan Myth Auth `user()` function terlebih dahulu
- ✅ Fallback ke session key lain jika Myth Auth gagal
- ✅ Debug logging untuk troubleshooting
- ✅ Multiple session key detection

### 2. **Debug Controller**
- ✅ Route `/debug/session` untuk melihat session data
- ✅ Menampilkan semua informasi yang diperlukan
- ✅ Error handling yang robust

### 3. **Session Key Detection**
```php
// Coba Myth Auth user function terlebih dahulu
if (function_exists('user')) {
    $mythUser = user();
    if ($mythUser) {
        $userId = $mythUser->id;
        $userData = $mythUser->toArray();
        // Process role dari Myth Auth
    }
}

// Fallback ke session key lain
if (!$userId) {
    $userId = $session->get('user_id') ?? $session->get('id') ?? $session->get('user')['id'] ?? null;
}
```

## Testing Steps

### 1. **Test Super Admin Login**
```bash
# Login sebagai super admin
# Akses: /debug/session
# Cek: Session data, user data, role detection
# Akses: /scan
# Cek: Apakah menggunakan layout admin atau user
```

### 2. **Test Database Data**
```sql
-- Cek data super admin di database
SELECT id, username, email, is_superadmin, user_role 
FROM users 
WHERE is_superadmin = 1 OR user_role = 'super_admin';
```

### 3. **Test Session Data**
```php
// Cek session data
$session = \Config\Services::session();
var_dump($session->get());
```

## Expected Results

### **Super Admin Should:**
- ✅ `user_role = 'super_admin'` atau `is_superadmin = 1`
- ✅ RoleHelper mengembalikan `UserRole::SUPER_ADMIN`
- ✅ Menggunakan layout admin normal
- ✅ Bisa akses semua menu admin

### **If Still Getting User Layout:**
1. Cek log files untuk debug messages
2. Akses `/debug/session` untuk melihat data
3. Cek database data user
4. Cek session data

## Troubleshooting Commands

### **Cek Log Files:**
```bash
tail -f writable/logs/log-*.php
```

### **Cek Database:**
```sql
SELECT * FROM users WHERE username = 'your_superadmin_username';
```

### **Cek Session:**
```php
// Di controller atau view
$session = \Config\Services::session();
var_dump($session->get());
```

## Next Steps

1. **Akses `/debug/session`** untuk melihat data
2. **Cek log files** untuk debug messages
3. **Cek database** untuk user data
4. **Report hasil** untuk analisis lebih lanjut

Dengan debug tools ini, kita bisa melihat apa yang sebenarnya terjadi dengan session dan role detection! 🔍

