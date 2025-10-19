<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-history"></i> Riwayat Perubahan Gaji
        </h1>
        <a href="<?= base_url('admin/gaji') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Gaji
        </a>
    </div>

    <!-- Gaji Info Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Gaji</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Departemen:</strong><br>
                    <?= $gaji['departemen'] ?>
                </div>
                <div class="col-md-3">
                    <strong>Jabatan:</strong><br>
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
        </div>
    </div>

    <!-- History Timeline -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">
                <i class="fas fa-history"></i> Timeline Perubahan
            </h6>
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
                                                <span class="badge badge-success">Data Gaji Dibuat</span>
                                            <?php elseif ($record['action'] == 'updated'): ?>
                                                <span class="badge badge-warning">Data Gaji Diperbarui</span>
                                            <?php elseif ($record['action'] == 'deleted'): ?>
                                                <span class="badge badge-danger">Data Gaji Dihapus</span>
                                            <?php endif; ?>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> <?= date('d/m/Y H:i', strtotime($record['updated_at'])) ?>
                                        </small>
                                    </div>
                                    
                                    <div class="row">
                                        <?php if ($record['action'] == 'updated' && $record['gaji_per_jam_old'] != $record['gaji_per_jam_new']): ?>
                                        <div class="col-md-6 mb-3">
                                            <strong>Gaji Per Jam:</strong><br>
                                            <div class="change-item">
                                                <span class="old-value">Rp <?= number_format($record['gaji_per_jam_old'], 0, ',', '.') ?></span>
                                                <i class="fas fa-arrow-right mx-2 text-muted"></i>
                                                <span class="new-value">Rp <?= number_format($record['gaji_per_jam_new'], 0, ',', '.') ?></span>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($record['action'] == 'updated' && $record['departemen_old'] != $record['departemen_new']): ?>
                                        <div class="col-md-6 mb-3">
                                            <strong>Departemen:</strong><br>
                                            <div class="change-item">
                                                <span class="old-value"><?= $record['departemen_old'] ?></span>
                                                <i class="fas fa-arrow-right mx-2 text-muted"></i>
                                                <span class="new-value"><?= $record['departemen_new'] ?></span>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($record['action'] == 'updated' && $record['jabatan_old'] != $record['jabatan_new']): ?>
                                        <div class="col-md-6 mb-3">
                                            <strong>Jabatan:</strong><br>
                                            <div class="change-item">
                                                <span class="old-value"><?= $record['jabatan_old'] ?></span>
                                                <i class="fas fa-arrow-right mx-2 text-muted"></i>
                                                <span class="new-value"><?= $record['jabatan_new'] ?></span>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($record['action'] == 'created'): ?>
                                        <div class="col-md-12">
                                            <div class="alert alert-success">
                                                <h6><i class="fas fa-info-circle"></i> Data Awal:</h6>
                                                <strong>Departemen:</strong> <?= $record['departemen_new'] ?><br>
                                                <strong>Jabatan:</strong> <?= $record['jabatan_new'] ?><br>
                                                <strong>Gaji Per Jam:</strong> Rp <?= number_format($record['gaji_per_jam_new'], 0, ',', '.') ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="mt-3 pt-2 border-top">
                                        <small class="text-muted">
                                            <i class="fas fa-user"></i> Diubah oleh: <strong><?= $record['updated_by'] ?></strong>
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
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 15px;
    width: 24px;
    height: 24px;
    background: #fff;
    border: 3px solid #e3e6f0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -23px;
    top: 39px;
    width: 2px;
    height: calc(100% + 30px);
    background: #e3e6f0;
    z-index: 1;
}

.timeline-content {
    margin-left: 0;
}

.timeline-content .card {
    border-left: 4px solid #4e73df;
    transition: all 0.3s ease;
}

.timeline-content .card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.timeline-item:first-child .timeline-content .card {
    border-left-color: #1cc88a;
}

.timeline-item:last-child .timeline-content .card {
    border-left-color: #e74a3b;
}

.change-item {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.old-value {
    background: #f8d7da;
    color: #721c24;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.9em;
}

.new-value {
    background: #d4edda;
    color: #155724;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.9em;
}

.badge {
    font-size: 0.8em;
    padding: 6px 12px;
}
</style>

<script>
$(document).ready(function() {
    // Add smooth scrolling to timeline
    $('.timeline-item').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });
});
</script>
<?= $this->endSection() ?>

