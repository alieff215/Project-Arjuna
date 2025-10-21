<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Konfigurasi Gaji</h1>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Konfigurasi Gaji</h6>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
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

            <form action="<?= base_url('admin/gaji/store') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_departemen">Departemen <span class="text-danger">*</span></label>
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
                            <label for="id_jabatan">Jabatan <span class="text-danger">*</span></label>
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
                            <label for="gaji_per_jam">Gaji Per Jam <span class="text-danger">*</span></label>
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
                                Masukkan gaji per jam dalam rupiah (tanpa titik atau koma)
                            </small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="<?= base_url('admin/gaji') ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">Informasi</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Aturan Konfigurasi Gaji:</h6>
                    <ul>
                        <li>Setiap kombinasi departemen dan jabatan hanya boleh memiliki satu konfigurasi gaji</li>
                        <li>Gaji per jam harus berupa angka positif</li>
                        <li>Konfigurasi gaji yang sudah dibuat akan digunakan untuk perhitungan laporan gaji</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Tips:</h6>
                    <ul>
                        <li>Pastikan departemen dan jabatan sudah tersedia sebelum membuat konfigurasi gaji</li>
                        <li>Gaji per jam akan digunakan untuk menghitung total gaji berdasarkan jam kerja</li>
                        <li>Konfigurasi gaji dapat diedit atau dinonaktifkan kapan saja</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Format input gaji per jam
    $('#gaji_per_jam').on('input', function() {
        let value = $(this).val();
        if (value < 0) {
            $(this).val(0);
        }
    });

    // Validasi form
    $('form').on('submit', function(e) {
        let id_departemen = $('#id_departemen').val();
        let id_jabatan = $('#id_jabatan').val();
        let gaji_per_jam = $('#gaji_per_jam').val();

        if (!id_departemen || !id_jabatan || !gaji_per_jam) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi');
            return false;
        }

        if (parseFloat(gaji_per_jam) <= 0) {
            e.preventDefault();
            alert('Gaji per jam harus lebih dari 0');
            return false;
        }
    });
});
</script>
   </div>
</div>
<?= $this->endSection() ?>
