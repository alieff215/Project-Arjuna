# Perbaikan Fitur Delete pada Departemen dan Jabatan

## Masalah yang Ditemukan

1. **URL Delete Salah di List Departemen**
   - URL yang digunakan: `admin/departemen/delete`
   - URL yang benar: `admin/departemen/deleteDepartemenPost`
   - Ini menyebabkan request delete tidak sampai ke controller

2. **Controller Tidak Mengembalikan JSON Response**
   - Kedua controller (`DepartemenController` dan `JabatanController`) tidak mengembalikan response JSON yang benar
   - Controller menggunakan `exit()` atau `session->setFlashdata()` tanpa return response
   - AJAX di frontend mengharapkan response JSON dengan format `{success: boolean, message: string}`

3. **Inkonsistensi antara Departemen dan Jabatan**
   - List departemen menggunakan fungsi JavaScript sendiri (`deleteDepartemen()`)
   - List jabatan menggunakan fungsi global `deleteItem()` yang hanya reload halaman
   - Tidak ada fungsi `showAlert()` untuk menampilkan pesan sukses/error

## Perbaikan yang Dilakukan

### 1. File: `app/Views/admin/departemen/list-departemen.php`
**Perbaikan:** Fix URL delete dari `admin/departemen/delete` menjadi `admin/departemen/deleteDepartemenPost`

```javascript
url: '<?= base_url('admin/departemen/deleteDepartemenPost') ?>',
```

### 2. File: `app/Controllers/Admin/DepartemenController.php`
**Perbaikan:** Update method `deleteDepartemenPost()` untuk mengembalikan JSON response

**Sebelum:**
```php
public function deleteDepartemenPost($id = null)
{
    $id = inputPost('id');
    $departemen = $this->departemenModel->getDepartemen($id);
    if (!empty($departemen)) {
        $KaryawanModel = new \App\Models\KaryawanModel();
        if (!empty($KaryawanModel->getKaryawanCountByDepartemen($id))) {
            $this->session->setFlashdata('error', 'Departemen Masih Memiliki Karyawan Aktif');
            exit();
        }
        // ... code lainnya tanpa return response
    }
}
```

**Sesudah:**
```php
public function deleteDepartemenPost($id = null)
{
    $id = inputPost('id');
    $departemen = $this->departemenModel->getDepartemen($id);
    
    if (empty($departemen)) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Data departemen tidak ditemukan'
        ]);
    }
    
    $KaryawanModel = new \App\Models\KaryawanModel();
    if (!empty($KaryawanModel->getKaryawanCountByDepartemen($id))) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Departemen masih memiliki karyawan aktif'
        ]);
    }

    // Cek apakah memerlukan approval
    if ($this->approvalHelper->requiresApproval()) {
        // Buat request approval untuk delete
        $approvalId = $this->approvalHelper->createApprovalRequest(...);

        if ($approvalId) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Request penghapusan data departemen telah dikirim dan menunggu persetujuan superadmin'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengirim request approval'
            ]);
        }
    } else {
        // Langsung hapus (untuk super admin)
        if ($this->departemenModel->deleteDepartemen($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus data'
            ]);
        }
    }
}
```

### 3. File: `app/Controllers/Admin/JabatanController.php`
**Perbaikan:** Update method `deleteJabatanPost()` untuk mengembalikan JSON response (sama seperti DepartemenController)

### 4. File: `app/Views/admin/jabatan/list-jabatan.php`
**Perbaikan:** 
- Ubah dari menggunakan `deleteItem()` menjadi fungsi `deleteJabatan()` yang konsisten dengan departemen
- Tambahkan handling untuk menampilkan pesan ketika data kosong
- Tambahkan script JavaScript yang sama dengan list-departemen

**Sebelum:**
```html
<button onclick='deleteItem("admin/jabatan/deleteJabatanPost","<?= $value["id"]; ?>","Konfirmasi untuk menghapus data");' ...>
```

**Sesudah:**
```html
<button type="button" class="btn btn-danger p-2" onclick="deleteJabatan(<?= $value['id']; ?>)" title="Hapus">
  <i class="material-icons">delete_forever</i>
  Delete
</button>

<script>
function deleteJabatan(id) {
  if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
    $.ajax({
      url: '<?= base_url('admin/jabatan/deleteJabatanPost') ?>',
      type: 'POST',
      data: {
        id: id,
        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
      },
      success: function(response) {
        if (response.success) {
          refreshSection('jabatan', '#dataJabatan');
          showAlert('success', response.message);
        } else {
          showAlert('error', response.message);
        }
      },
      error: function() {
        showAlert('error', 'Terjadi kesalahan saat menghapus data');
      }
    });
  }
}
</script>
```

### 5. File: `app/Views/admin/departemen/index.php`
**Perbaikan:** Tambahkan fungsi `showAlert()` untuk menampilkan pesan sukses/error

```javascript
function showAlert(type, message) {
  if (typeof swal !== 'undefined') {
    // Gunakan SweetAlert jika tersedia
    swal({
      text: message,
      icon: type === 'success' ? 'success' : 'error',
      button: 'OK',
    });
  } else {
    // Fallback ke alert biasa
    alert(message);
  }
}
```

## Fitur yang Sudah Berfungsi

✅ Delete departemen dengan validasi (cek apakah masih ada karyawan aktif)
✅ Delete jabatan dengan validasi (cek apakah masih ada departemen yang menggunakan)
✅ Approval system untuk non-superadmin
✅ Direct delete untuk superadmin
✅ Pesan sukses/error yang informatif
✅ Auto refresh data setelah delete berhasil
✅ Konsistensi UI/UX antara departemen dan jabatan

## Testing

Untuk menguji fitur ini:

1. **Test Delete Departemen:**
   - Login sebagai superadmin
   - Buka halaman Departemen & Jabatan
   - Coba hapus departemen yang tidak memiliki karyawan → Harus berhasil
   - Coba hapus departemen yang memiliki karyawan → Harus ditolak dengan pesan error

2. **Test Delete Jabatan:**
   - Login sebagai superadmin
   - Buka halaman Departemen & Jabatan
   - Coba hapus jabatan yang tidak digunakan departemen → Harus berhasil
   - Coba hapus jabatan yang masih digunakan → Harus ditolak dengan pesan error

3. **Test Approval System:**
   - Login sebagai admin (bukan superadmin)
   - Coba hapus departemen/jabatan → Harus membuat request approval
   - Login sebagai superadmin
   - Cek approval request dan approve/reject

## Tanggal Perbaikan
4 November 2025

