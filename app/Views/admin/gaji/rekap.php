<?= $this->extend('templates/admin_page_layout'); ?>
<?= $this->section('content'); ?>

<style>
    /* ===========================
   CUSTOM STYLING - REKAP GAJI
   =========================== */
    .card-header {
        background: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }

    .card-header h6 {
        color: #4e73df;
        font-weight: 700;
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #f8f9fc;
        color: #4e73df;
    }

    .table thead th {
        background-color: #f1f1f1;
        color: #4e73df;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }

    .table tbody td {
        vertical-align: middle;
    }

    .table tfoot th {
        background-color: #f8f9fc;
        font-weight: 600;
        color: #333;
    }

    .table tbody tr:hover {
        background-color: #f9fafc;
    }

    .btn-primary {
        border-radius: 30px;
        padding: 6px 16px;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }

    .form-group label {
        font-weight: 500;
        color: #555;
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Rekap Gaji Karyawan</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Opsi:</div>
                                <a class="dropdown-item" href="<?= base_url('admin/gaji'); ?>">Manajemen Gaji</a>
                                <a class="dropdown-item" href="<?= base_url('admin/gaji/export?filter=' . $filter . '&start_date=' . $start_date . '&end_date=' . $end_date . '&min_percentage=' . $min_percentage); ?>">Export CSV</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <?= view('admin/_message_block') ?>

                        <!-- Filter Form -->
                        <form action="<?= base_url('admin/gaji/rekap'); ?>" method="get" class="mb-4">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <label for="filter">Filter</label>
                                        <select name="filter" id="filter" class="form-control" onchange="toggleDateFields()">
                                            <option value="day" <?= ($filter == 'day') ? 'selected' : ''; ?>>Harian</option>
                                            <option value="week" <?= ($filter == 'week') ? 'selected' : ''; ?>>Mingguan</option>
                                            <option value="month" <?= ($filter == 'month') ? 'selected' : ''; ?>>Bulanan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group mb-0">
                                        <label for="start_date">Tanggal Mulai</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $start_date; ?>">
                                    </div>
                                </div>

                                <div class="col-md-2" id="end_date_container">
                                    <div class="form-group mb-0">
                                        <label for="end_date">Tanggal Akhir</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $end_date; ?>">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group mb-0">
                                        <label for="min_percentage">Min. Persentase</label>
                                        <input type="number" step="0.01" class="form-control" id="min_percentage"
                                            name="min_percentage" value="<?= $min_percentage ?? 0; ?>">
                                    </div>
                                </div>

                                <div class="col-md-3 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-35">Filter</button>
                                    <button type="button" class="btn btn-danger w-35"
                                        onclick="window.location.href='<?= base_url('admin/gaji/rekap'); ?>'">Reset</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIP</th>
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
                                    $totalFilteredGaji = 0;
                                    $persentase_filter = $min_percentage ?? 100; // kalau kosong, 100%
                                    ?>

                                    <?php foreach ($rekap_gaji as $rg) : ?>
                                        <?php
                                        // hitung gaji setelah filter persentase
                                        $gaji_setelah_persen = $rg['total_gaji'] * ($persentase_filter / 100);

                                        // jumlahkan total yang sudah kena potong
                                        $totalFilteredGaji += $gaji_setelah_persen;
                                        ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $rg['nis']; ?></td>
                                            <td><?= $rg['nama_karyawan']; ?></td>
                                            <td><?= $rg['departemen']; ?></td>
                                            <td><?= $rg['jabatan']; ?></td>
                                            <td><?= $rg['jumlah_kehadiran']; ?></td>
                                            <td><?= $rg['total_jam']; ?> jam</td>
                                            <td>Rp <?= number_format($rg['gaji_per_jam'], 0, ',', '.'); ?></td>
                                            <td>Rp <?= number_format($gaji_setelah_persen, 0, ',', '.'); ?></td>
                                            <td><?= $persentase_filter; ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <tfoot>
                                    <tr>
                                        <th colspan="7" class="text-right">Total Gaji <?= $persentase_filter; ?>%:</th>
                                        <th>Rp <?= number_format($totalFilteredGaji, 0, ',', '.'); ?></th>
                                        <th><?= $persentase_filter; ?>%</th>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
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

    document.addEventListener('DOMContentLoaded', function() {
        toggleDateFields();
    });
</script>

<?= $this->endSection(); ?>