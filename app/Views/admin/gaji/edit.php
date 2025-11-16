<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Konfigurasi Gaji</h1>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Konfigurasi Gaji</h6>
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

            <form action="<?= base_url('admin/gaji/update/' . $gaji['id_gaji']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_departemen">Departemen & Grade <span class="text-danger">*</span></label>
                            <select class="form-control" id="id_departemen" name="id_departemen" required>
                                <option value="">Pilih Departemen & Grade</option>
                                <?php foreach ($departemen as $dept): ?>
                                    <option value="<?= $dept['id_departemen'] ?>" 
                                            data-jabatan-id="<?= $dept['id_jabatan'] ?>"
                                            <?= (old('id_departemen', $gaji['id_departemen']) == $dept['id_departemen']) ? 'selected' : '' ?>>
                                        <?= $dept['departemen'] ?> - <?= $dept['jabatan'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">
                                Setiap departemen sudah memiliki grade yang terkait
                            </small>
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
                                       value="<?= old('gaji_per_jam', $gaji['gaji_per_jam']) ?>" 
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
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="<?= base_url('admin/gaji') ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Current Data Info -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">Data Saat Ini</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Departemen:</strong><br>
                    <?= $gaji['departemen'] ?>
                </div>
                <div class="col-md-3">
                    <strong>Grade:</strong><br>
                    <?= $gaji['jabatan'] ?>
                </div>
                <div class="col-md-3">
                    <strong>Gaji Per Jam:</strong><br>
                    Rp <?= number_format($gaji['gaji_per_jam'], 0, ',', '.') ?>
                </div>
                <div class="col-md-3">
                    <strong>Tanggal Update:</strong><br>
                    <?= date('d/m/Y H:i', strtotime($gaji['tanggal_update'])) ?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <strong>Terakhir Diupdate:</strong> <?= date('d/m/Y H:i', strtotime($gaji['tanggal_update'])) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- History Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-info">
                <i class="fas fa-history"></i> Riwayat Perubahan
            </h6>
            <a href="<?= base_url('admin/gaji/history/' . $gaji['id_gaji']) ?>" class="btn btn-sm btn-info">
                <i class="fas fa-external-link-alt"></i> Lihat Detail Riwayat
            </a>
        </div>
        <div class="card-body">
            <?php if (empty($history)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-history fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Belum ada riwayat perubahan</h5>
                    <p class="text-gray-500">Riwayat perubahan akan muncul setelah data diupdate</p>
                </div>
            <?php else: ?>
                <div class="timeline">
                    <?php foreach ($history as $index => $record): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            <?php if ($record['action'] == 'created'): ?>
                                <i class="fas fa-plus-circle text-success"></i>
                            <?php elseif ($record['action'] == 'updated'): ?>
                                <i class="fas fa-edit text-warning"></i>
                            <?php elseif ($record['action'] == 'deleted'): ?>
                                <i class="fas fa-trash text-danger"></i>
                            <?php endif; ?>
                        </div>
                        <div class="timeline-content">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title mb-0">
                                            <?php if ($record['action'] == 'created'): ?>
                                                Data Gaji Dibuat
                                            <?php elseif ($record['action'] == 'updated'): ?>
                                                Data Gaji Diperbarui
                                            <?php elseif ($record['action'] == 'deleted'): ?>
                                                Data Gaji Dihapus
                                            <?php endif; ?>
                                        </h6>
                                        <small class="text-muted">
                                            <?= date('d/m/Y H:i', strtotime($record['updated_at'])) ?>
                                        </small>
                                    </div>
                                    
                                    <div class="row">
                                        <?php if ($record['action'] == 'updated' && $record['gaji_per_jam_old'] != $record['gaji_per_jam_new']): ?>
                                        <div class="col-md-6">
                                            <strong>Gaji Per Jam:</strong><br>
                                            <span class="text-danger">Rp <?= number_format($record['gaji_per_jam_old'], 0, ',', '.') ?></span>
                                            <i class="fas fa-arrow-right mx-2"></i>
                                            <span class="text-success">Rp <?= number_format($record['gaji_per_jam_new'], 0, ',', '.') ?></span>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($record['action'] == 'updated' && $record['departemen_old'] != $record['departemen_new']): ?>
                                        <div class="col-md-6">
                                            <strong>Departemen:</strong><br>
                                            <span class="text-danger"><?= $record['departemen_old'] ?></span>
                                            <i class="fas fa-arrow-right mx-2"></i>
                                            <span class="text-success"><?= $record['departemen_new'] ?></span>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($record['action'] == 'updated' && $record['jabatan_old'] != $record['jabatan_new']): ?>
                                        <div class="col-md-6">
                                            <strong>Grade:</strong><br>
                                            <span class="text-danger"><?= $record['jabatan_old'] ?></span>
                                            <i class="fas fa-arrow-right mx-2"></i>
                                            <span class="text-success"><?= $record['jabatan_new'] ?></span>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($record['action'] == 'created'): ?>
                                        <div class="col-md-6">
                                            <strong>Departemen:</strong> <?= $record['departemen_new'] ?><br>
                                            <strong>Grade:</strong> <?= $record['jabatan_new'] ?><br>
                                            <strong>Gaji Per Jam:</strong> Rp <?= number_format($record['gaji_per_jam_new'], 0, ',', '.') ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-user"></i> Diubah oleh: <?= $record['updated_by'] ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 10px;
    width: 20px;
    height: 20px;
    background: #fff;
    border: 2px solid #e3e6f0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -26px;
    top: 30px;
    width: 2px;
    height: calc(100% + 20px);
    background: #e3e6f0;
    z-index: 1;
}

.timeline-content {
    margin-left: 0;
}

.timeline-content .card {
    border-left: 3px solid #4e73df;
}

.timeline-item:first-child .timeline-content .card {
    border-left-color: #1cc88a;
}

.timeline-item:last-child .timeline-content .card {
    border-left-color: #e74a3b;
}
</style>

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
        let gaji_per_jam = $('#gaji_per_jam').val();

        if (!id_departemen || !gaji_per_jam) {
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
