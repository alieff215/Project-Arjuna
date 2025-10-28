<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content') ?>

<style>
/* Page-specific styles untuk gaji - konsisten dengan dashboard */
.content.app-content-bg {
    min-height: calc(100vh - 64px);
    padding: 18px 0 24px !important;
    font-size: var(--fz-body, 14px);
    background:
        radial-gradient(1200px 500px at 15% 0%, var(--bg-accent-2, #f0f7ff) 0%, transparent 60%),
        radial-gradient(900px 360px at 100% -5%, var(--bg-accent-1, #e5efff) 0%, transparent 55%),
        linear-gradient(180deg, var(--bg, #eef3fb), var(--bg, #eef3fb));
}

.container-fluid {
    padding: 0 14px !important;
    margin: 0 auto;
    max-width: var(--container-max, 1280px);
    width: 100%;
}

/* Card styling konsisten */
.card {
    background: var(--card, #fff) !important;
    border: 1px solid var(--border, rgba(16, 24, 40, .12)) !important;
    border-radius: var(--radius, 18px) !important;
    box-shadow: var(--shadow-1, 0 10px 30px rgba(12, 20, 40, .08)) !important;
    overflow: hidden;
}

.card-header {
    padding: 16px 18px !important;
    border-bottom: 1px solid var(--border, rgba(16, 24, 40, .12)) !important;
    background: linear-gradient(180deg, var(--card-solid, #fff), transparent);
}

.card .card-body {
    padding: 16px 18px !important;
    color: var(--text, #0b132b);
}

/* Form styling konsisten */
.form-group label {
    font-weight: 600;
    color: var(--text, #0b132b);
    margin-bottom: 8px;
    display: block;
}

.form-control {
    border: 1px solid var(--border, rgba(16, 24, 40, .12));
    border-radius: 8px;
    padding: 10px 12px;
    background: var(--card, #fff);
    color: var(--text, #0b132b);
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    border-color: var(--primary, #3b82f6);
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    outline: 0;
}

.input-group-text {
    background: var(--card, #fff);
    border: 1px solid var(--border, rgba(16, 24, 40, .12));
    color: var(--muted, #6b7b93);
    font-weight: 600;
}

/* Button styling konsisten */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    border: 1px solid transparent;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-primary {
    background: var(--primary, #3b82f6);
    border-color: var(--primary, #3b82f6);
    color: white;
}

.btn-secondary {
    background: var(--card, #fff);
    border-color: var(--border, rgba(16, 24, 40, .12));
    color: var(--text, #0b132b);
}

.btn-secondary:hover {
    background: var(--bg-accent-1, #e5efff);
}
</style>

<div class="content app-content-bg">
   <div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0" style="color: var(--text); font-weight: 700;">➕ Tambah Konfigurasi Gaji</h1>
            <p class="text-muted mb-0">Buat konfigurasi gaji baru untuk departemen dan jabatan tertentu</p>
        </div>
        <div>
            <a href="<?= base_url('admin/gaji') ?>" class="btn btn-secondary">
                <i class="material-icons">arrow_back</i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold" style="color: var(--text);">
                <i class="material-icons" style="vertical-align:middle;margin-right:8px;">add_circle</i>
                Form Tambah Konfigurasi Gaji
            </h6>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="material-icons" style="vertical-align:middle;margin-right:6px;">error</i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="material-icons" style="vertical-align:middle;margin-right:6px;">warning</i>
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/gaji/store') ?>" method="post" id="salaryForm">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_departemen">
                                <i class="material-icons" style="vertical-align:middle;margin-right:6px;font-size:18px;">business</i>
                                Departemen <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="id_departemen" name="id_departemen" required>
                                <option value="">Pilih Departemen</option>
                                <?php foreach ($departemen as $dept): ?>
                                    <option value="<?= $dept['id_departemen'] ?>" 
                                            <?= (old('id_departemen') == $dept['id_departemen']) ? 'selected' : '' ?>>
                                        <?= $dept['departemen'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_jabatan">
                                <i class="material-icons" style="vertical-align:middle;margin-right:6px;font-size:18px;">work</i>
                                Jabatan <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="id_jabatan" name="id_jabatan" required>
                                <option value="">Pilih Jabatan</option>
                                <?php foreach ($jabatan as $jab): ?>
                                    <option value="<?= $jab['id'] ?>" 
                                            <?= (old('id_jabatan') == $jab['id']) ? 'selected' : '' ?>>
                                        <?= $jab['jabatan'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gaji_per_jam">
                                <i class="material-icons" style="vertical-align:middle;margin-right:6px;font-size:18px;">attach_money</i>
                                Gaji Per Jam <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" 
                                       class="form-control" 
                                       id="gaji_per_jam" 
                                       name="gaji_per_jam" 
                                       value="<?= old('gaji_per_jam') ?>" 
                                       min="0" 
                                       step="100" 
                                       placeholder="Masukkan gaji per jam"
                                       required>
                            </div>
                            <small class="form-text text-muted">
                                <i class="material-icons" style="vertical-align:middle;margin-right:4px;font-size:16px;">info</i>
                                Masukkan gaji per jam dalam rupiah (tanpa titik atau koma)
                            </small>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="material-icons">save</i> Simpan Konfigurasi
                        </button>
                        <a href="<?= base_url('admin/gaji') ?>" class="btn btn-secondary">
                            <i class="material-icons">cancel</i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold" style="color: var(--text);">
                <i class="material-icons" style="vertical-align:middle;margin-right:8px;">info</i>
                Informasi & Panduan
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3" style="color: var(--text); font-weight: 600;">
                        <i class="material-icons" style="vertical-align:middle;margin-right:6px;color:var(--warning);">warning</i>
                        Aturan Konfigurasi Gaji:
                    </h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="material-icons" style="vertical-align:middle;margin-right:6px;color:var(--success);font-size:18px;">check_circle</i>
                            Setiap kombinasi departemen dan jabatan hanya boleh memiliki satu konfigurasi gaji
                        </li>
                        <li class="mb-2">
                            <i class="material-icons" style="vertical-align:middle;margin-right:6px;color:var(--success);font-size:18px;">check_circle</i>
                            Gaji per jam harus berupa angka positif
                        </li>
                        <li class="mb-2">
                            <i class="material-icons" style="vertical-align:middle;margin-right:6px;color:var(--success);font-size:18px;">check_circle</i>
                            Konfigurasi gaji yang sudah dibuat akan digunakan untuk perhitungan laporan gaji
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-3" style="color: var(--text); font-weight: 600;">
                        <i class="material-icons" style="vertical-align:middle;margin-right:6px;color:var(--warning);">lightbulb</i>
                        Tips & Saran:
                    </h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="material-icons" style="vertical-align:middle;margin-right:6px;color:var(--primary);font-size:18px;">star</i>
                            Pastikan departemen dan jabatan sudah tersedia sebelum membuat konfigurasi gaji
                        </li>
                        <li class="mb-2">
                            <i class="material-icons" style="vertical-align:middle;margin-right:6px;color:var(--primary);font-size:18px;">star</i>
                            Gaji per jam akan digunakan untuk menghitung total gaji berdasarkan jam kerja
                        </li>
                        <li class="mb-2">
                            <i class="material-icons" style="vertical-align:middle;margin-right:6px;color:var(--primary);font-size:18px;">star</i>
                            Konfigurasi gaji dapat diedit atau dinonaktifkan kapan saja
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Form validation sederhana
    $('#salaryForm').on('submit', function(e) {
        const $submitBtn = $('#submitBtn');
        
        // Show loading state
        $submitBtn.html('<i class="material-icons">hourglass_empty</i> Menyimpan...');
        $submitBtn.prop('disabled', true);
        
        // Validate form
        let isValid = true;
        const requiredFields = ['id_departemen', 'id_jabatan', 'gaji_per_jam'];
        
        requiredFields.forEach(field => {
            const $field = $(`#${field}`);
            if (!$field.val()) {
                $field.addClass('is-invalid');
                isValid = false;
            } else {
                $field.removeClass('is-invalid');
            }
        });
        
        // Validate salary amount
        const salary = parseFloat($('#gaji_per_jam').val());
        if (salary <= 0) {
            $('#gaji_per_jam').addClass('is-invalid');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            $submitBtn.html('<i class="material-icons">save</i> Simpan Konfigurasi');
            $submitBtn.prop('disabled', false);
            
            alert('Mohon lengkapi semua field yang wajib diisi dengan benar');
            return false;
        }
    });

    // Real-time validation
    $('#gaji_per_jam').on('input', function() {
        const value = $(this).val();
        if (value < 0) {
            $(this).val(0);
        }
        
        // Format display
        if (value > 0) {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
        } else {
            $(this).removeClass('is-valid');
        }
    });
});
</script>
   </div>
</div>
<?= $this->endSection() ?>
