<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Gaji</h1>
        <div>
            <a href="<?= base_url('admin/gaji/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Konfigurasi Gaji
            </a>
            <a href="<?= base_url('admin/gaji/report') ?>" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> Laporan Gaji
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Konfigurasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_config'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cogs fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Rata-rata Gaji/Jam</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($stats['avg_salary'], 0, ',', '.') ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Gaji Tertinggi/Jam</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($stats['max_salary'], 0, ',', '.') ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Gaji Terendah/Jam</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($stats['min_salary'], 0, ',', '.') ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Konfigurasi Gaji</h6>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th>Gaji Per Jam</th>
                            <th>Tanggal Update</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($gaji as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['departemen'] ?></td>
                            <td><?= $row['jabatan'] ?></td>
                            <td>Rp <?= number_format($row['gaji_per_jam'], 0, ',', '.') ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($row['tanggal_update'])) ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('admin/gaji/edit/' . $row['id_gaji']) ?>" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <a href="<?= base_url('admin/gaji/history/' . $row['id_gaji']) ?>" 
                                       class="btn btn-sm btn-info" title="Riwayat">
                                        <i class="fas fa-history"></i>
                                    </a>
                                    
                                    <a href="<?= base_url('admin/gaji/delete/' . $row['id_gaji']) ?>" 
                                       class="btn btn-sm btn-danger" 
                                       title="Hapus"
                                       onclick="return confirm('Yakin ingin menghapus konfigurasi gaji ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "pageLength": 25,
        "order": [[ 4, "desc" ]]
    });
});
</script>
   </div>
</div>
<?= $this->endSection() ?>
