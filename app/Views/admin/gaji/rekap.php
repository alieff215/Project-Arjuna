<?= $this->extend('templates/admin_page_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Rekap Gaji Karyawan</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opsi:</div>
                            <a class="dropdown-item" href="<?= base_url('admin/gaji'); ?>">Manajemen Gaji</a>
                            <a class="dropdown-item" href="<?= base_url('admin/gaji/export?filter=' . $filter . '&start_date=' . $start_date . '&end_date=' . $end_date); ?>">Export CSV</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?= view('admin/_message_block') ?>
                    
                    <!-- Filter Form -->
                    <form action="<?= base_url('admin/gaji/rekap'); ?>" method="get" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="filter">Filter</label>
                                    <select name="filter" id="filter" class="form-control" onchange="toggleDateFields()">
                                        <option value="day" <?= ($filter == 'day') ? 'selected' : ''; ?>>Harian</option>
                                        <option value="week" <?= ($filter == 'week') ? 'selected' : ''; ?>>Mingguan</option>
                                        <option value="month" <?= ($filter == 'month') ? 'selected' : ''; ?>>Bulanan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $start_date; ?>">
                                </div>
                            </div>
                            <div class="col-md-3" id="end_date_container">
                                <div class="form-group">
                                    <label for="end_date">Tanggal Akhir</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $end_date; ?>">
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Departemen</th>
                                    <th>Jabatan</th>
                                    <th>Jumlah Kehadiran</th>
                                    <th>Total Jam</th>
                                    <th>Gaji Per Jam</th>
                                    <th>Total Gaji</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1; 
                                $totalAllGaji = 0;
                                foreach ($rekap_gaji as $rg) {
                                    $totalAllGaji += $rg['total_gaji'];
                                }
                                ?>
                                <?php foreach ($rekap_gaji as $rg) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $rg['nama_karyawan']; ?></td>
                                        <td><?= $rg['departemen']; ?></td>
                                        <td><?= $rg['jabatan']; ?></td>
                                        <td><?= $rg['jumlah_kehadiran']; ?></td>
                                        <td><?= $rg['total_jam']; ?> jam</td>
                                        <td>Rp <?= number_format($rg['gaji_per_jam'], 0, ',', '.'); ?></td>
                                        <td>Rp <?= number_format($rg['total_gaji'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php 
                                            $percentage = ($totalAllGaji > 0) ? ($rg['total_gaji'] / $totalAllGaji) * 100 : 0;
                                            echo number_format($percentage, 2) . '%';
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="7" class="text-right">Total Gaji:</th>
                                    <th>Rp <?= number_format($totalAllGaji, 0, ',', '.'); ?></th>
                                    <th>100%</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleDateFields() {
        const filter = document.getElementById('filter').value;
        const endDateContainer = document.getElementById('end_date_container');
        
        if (filter === 'day') {
            endDateContainer.style.display = 'none';
        } else {
            endDateContainer.style.display = 'block';
        }
    }
    
    // Call on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleDateFields();
    });
</script>
<?= $this->endSection(); ?>