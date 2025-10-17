<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Gaji Karyawan</h1>
        <div>
            <button class="btn btn-success" onclick="exportToCSV()">
                <i class="fas fa-file-csv"></i> Export CSV
            </button>
            <a href="<?= base_url('admin/gaji') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form method="get" action="<?= base_url('admin/gaji/report') ?>" id="filterForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="start_date" 
                                   name="start_date" 
                                   value="<?= $start_date ?>" 
                                   required>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="end_date" 
                                   name="end_date" 
                                   value="<?= $end_date ?>" 
                                   required>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_departemen">Departemen</label>
                            <select class="form-control" id="id_departemen" name="id_departemen">
                                <option value="">Semua Departemen</option>
                                <?php foreach ($departemen as $dept): ?>
                                    <option value="<?= $dept['id_departemen'] ?>" 
                                            <?= ($id_departemen == $dept['id_departemen']) ? 'selected' : '' ?>>
                                        <?= $dept['departemen'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="<?= base_url('admin/gaji/report') ?>" class="btn btn-secondary">
                                    <i class="fas fa-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Summary -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Karyawan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($report_data) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                Total Gaji</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format(array_sum(array_column($report_data, 'total_gaji')), 0, ',', '.') ?>
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
                                Total Jam Kerja</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= array_sum(array_column($report_data, 'total_jam_kerja')) ?> jam
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                Rata-rata Gaji</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $avg_gaji = count($report_data) > 0 ? array_sum(array_column($report_data, 'total_gaji')) / count($report_data) : 0;
                                ?>
                                Rp <?= number_format($avg_gaji, 0, ',', '.') ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Data Laporan Gaji 
                (<?= date('d/m/Y', strtotime($start_date)) ?> - <?= date('d/m/Y', strtotime($end_date)) ?>)
            </h6>
        </div>
        <div class="card-body">
            <?php if (empty($report_data)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Tidak ada data laporan gaji</h5>
                    <p class="text-gray-500">Coba ubah periode atau filter yang dipilih</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="reportTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Karyawan</th>
                                <th>Departemen</th>
                                <th>Jabatan</th>
                                <th>Gaji/Jam</th>
                                <th>Kehadiran</th>
                                <th>Total Jam</th>
                                <th>Total Gaji</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($report_data as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nis'] ?></td>
                                <td><?= $row['nama_karyawan'] ?></td>
                                <td><?= $row['departemen'] ?></td>
                                <td><?= $row['jabatan'] ?></td>
                                <td>Rp <?= number_format($row['gaji_per_jam'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge badge-<?= $row['total_kehadiran'] > 0 ? 'success' : 'secondary' ?>">
                                        <?= $row['total_kehadiran'] ?> hari
                                    </span>
                                </td>
                                <td><?= $row['total_jam_kerja'] ?> jam</td>
                                <td>
                                    <strong>Rp <?= number_format($row['total_gaji'], 0, ',', '.') ?></strong>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td colspan="8" class="text-right">Total:</td>
                                <td>Rp <?= number_format(array_sum(array_column($report_data, 'total_gaji')), 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#reportTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "pageLength": 25,
        "order": [[ 8, "desc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [0] }
        ]
    });

    // Set default dates if not set
    if (!$('#start_date').val()) {
        $('#start_date').val('<?= date('Y-m-01') ?>');
    }
    if (!$('#end_date').val()) {
        $('#end_date').val('<?= date('Y-m-t') ?>');
    }
});

function exportToCSV() {
    let start_date = $('#start_date').val();
    let end_date = $('#end_date').val();
    let id_departemen = $('#id_departemen').val();
    
    let url = '<?= base_url('admin/gaji/export') ?>?start_date=' + start_date + '&end_date=' + end_date;
    if (id_departemen) {
        url += '&id_departemen=' + id_departemen;
    }
    
    window.location.href = url;
}
</script>
   </div>
</div>
<?= $this->endSection() ?>
