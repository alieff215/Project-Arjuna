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

.row {
    row-gap: 16px;
}

/* Card styling konsisten dengan dashboard */
.card {
    background: var(--card, #fff) !important;
    border: 1px solid var(--border, rgba(16, 24, 40, .12)) !important;
    border-radius: var(--radius, 18px) !important;
    box-shadow: var(--shadow-1, 0 10px 30px rgba(12, 20, 40, .08)) !important;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
}

/* Equal height cards */
.equal-cards-row {
    display: flex;
    flex-wrap: wrap;
}

.equal-cards-row .col-lg-3,
.equal-cards-row .col-md-6,
.equal-cards-row .col-sm-6,
.equal-cards-row .col-12 {
    display: flex;
    flex-direction: column;
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

/* Header cards dengan icon seperti dashboard */
.card.card-stats .card-header.card-header-icon {
    display: grid;
    grid-template-columns: 64px 1fr auto;
    grid-auto-rows: auto;
    align-items: center;
    column-gap: 14px;
    height: 100px;
    padding: 16px 18px 14px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(180deg, var(--card-solid, #fff), transparent);
}

.card.card-stats .card-header .card-icon {
    grid-column: 1;
    grid-row: 1 / span 2;
    width: 64px;
    height: 64px;
    border-radius: 12px;
    display: grid;
    place-items: center;
    margin: 0;
    box-shadow: 0 6px 16px rgba(12, 20, 40, .08);
    transition: transform 0.2s ease;
}

.card.card-stats .card-header .card-icon:hover {
    transform: translateY(-2px);
}

.card.card-stats .card-header .card-icon .material-icons {
    font-size: 28px !important;
    color: white;
}

.card.card-stats .card-header .card-category {
    grid-column: 2;
    grid-row: 1;
    margin: 0;
    line-height: 1.2;
    font-weight: 600;
    font-size: 12px;
    color: var(--muted);
    text-transform: none;
    letter-spacing: 0.3px;
}

.card.card-stats .card-header .card-title {
    grid-column: 3;
    grid-row: 1;
    margin: 0;
    text-align: right;
    line-height: 1;
    font-size: clamp(20px, 1.8vw + 10px, 26px);
    font-weight: 800;
    color: var(--text);
}

.card.card-stats .card-footer {
    display: flex;
    align-items: center;
    gap: 10px;
    min-height: 56px;
    border-top: 1px solid var(--border);
    padding: 12px 18px !important;
    background: var(--card, #fff);
    color: var(--muted, #6b7b93);
}

.card.card-stats .card-footer .stats {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: var(--muted);
}

/* Panel untuk tabel data */
.panel {
    border: 1px solid var(--border, rgba(16, 24, 40, .12));
    border-radius: var(--radius, 18px);
    background: var(--card, #fff);
    box-shadow: var(--shadow-1, 0 10px 30px rgba(12, 20, 40, .08));
    overflow: hidden;
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.panel__head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 14px 16px;
    background: linear-gradient(180deg, var(--card-solid, #fff), transparent);
    border-bottom: 1px solid var(--border, rgba(16, 24, 40, .12));
}

.panel__title {
    margin: 0;
    font-weight: 800;
    letter-spacing: .2px;
    color: var(--text, #0b132b);
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: var(--fz-title, 20px);
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.panel__body {
    padding: 16px;
    flex: 1 1 auto;
}

/* Action buttons konsisten */
.btn-icon {
    width: 34px;
    height: 34px;
    display: grid;
    place-items: center;
    border-radius: 10px;
    border: 1px solid var(--border, rgba(16, 24, 40, .12));
    background: var(--card, #fff);
    cursor: pointer;
    transition: all .15s ease;
    touch-action: manipulation;
}

.btn-icon:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(12, 20, 40, .1);
}

.btn-icon .material-icons {
    font-size: 18px;
}

/* Responsive */
@media (max-width: 575.98px) {
    .card.card-stats .card-header.card-header-icon {
        grid-template-columns: 56px 1fr auto;
        height: 88px;
        padding: 14px 16px 12px;
        column-gap: 12px;
    }

    .card.card-stats .card-header .card-icon {
        width: 56px;
        height: 56px;
        border-radius: 10px;
    }

    .card.card-stats .card-header .card-icon .material-icons {
        font-size: 24px !important;
    }

    .card.card-stats .card-header .card-category {
        font-size: 11px;
    }

    .card.card-stats .card-header .card-title {
        font-size: clamp(18px, 1.5vw + 8px, 22px);
    }
}

@media (max-width: 767.98px) {
    .card.card-stats .card-header.card-header-icon {
        grid-template-columns: 60px 1fr auto;
        height: 92px;
        padding: 15px 16px 13px;
        column-gap: 13px;
    }

    .card.card-stats .card-header .card-icon {
        width: 60px;
        height: 60px;
    }

    .card.card-stats .card-header .card-icon .material-icons {
        font-size: 26px !important;
    }
}
</style>

<div class="content app-content-bg">
   <div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0" style="color: var(--text); font-weight: 700;">💰 Manajemen Gaji</h1>
            <p class="text-muted mb-0">Kelola konfigurasi gaji karyawan dengan mudah dan efisien</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('admin/gaji/add') ?>" class="btn btn-primary">
                <i class="material-icons" style="font-size:18px;">add</i> Tambah Konfigurasi
            </a>
            <a href="<?= base_url('admin/gaji/report') ?>" class="btn btn-success">
                <i class="material-icons" style="font-size:18px;">assessment</i> Laporan Gaji
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row equal-cards-row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">settings</i>
                    </div>
                    <div>
                        <p class="card-category">Total Konfigurasi</p>
                        <h3 class="card-title"><?= $stats['total_config'] ?></h3>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="stats"><i class="material-icons" style="color:var(--primary);font-size:16px;">check</i> Konfigurasi Aktif</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div>
                        <p class="card-category">Rata-rata Gaji/Jam</p>
                        <h3 class="card-title">Rp <?= number_format($stats['avg_salary'], 0, ',', '.') ?></h3>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="stats"><i class="material-icons" style="color:var(--success);font-size:16px;">trending_up</i> Per Jam Kerja</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">keyboard_arrow_up</i>
                    </div>
                    <div>
                        <p class="card-category">Gaji Tertinggi/Jam</p>
                        <h3 class="card-title">Rp <?= number_format($stats['max_salary'], 0, ',', '.') ?></h3>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="stats"><i class="material-icons" style="color:var(--primary);font-size:16px;">star</i> Tertinggi</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">keyboard_arrow_down</i>
                    </div>
                    <div>
                        <p class="card-category">Gaji Terendah/Jam</p>
                        <h3 class="card-title">Rp <?= number_format($stats['min_salary'], 0, ',', '.') ?></h3>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="stats"><i class="material-icons" style="color:var(--danger);font-size:16px;">trending_down</i> Terendah</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="panel">
        <div class="panel__head">
            <h4 class="panel__title">
                <i class="material-icons" style="font-size:20px;">list</i>
                Daftar Konfigurasi Gaji
            </h4>
            <div class="toolbar d-flex gap-1">
                <a class="btn-icon" href="<?= base_url('admin/gaji/add') ?>" title="Tambah konfigurasi" aria-label="Tambah konfigurasi gaji">
                    <i class="material-icons">add</i>
                </a>
                <a class="btn-icon" href="<?= base_url('admin/gaji/report') ?>" title="Lihat laporan" aria-label="Lihat laporan gaji">
                    <i class="material-icons">assessment</i>
                </a>
            </div>
        </div>
        <div class="panel__body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="material-icons" style="vertical-align:middle;margin-right:6px;font-size:18px;">check_circle</i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="material-icons" style="vertical-align:middle;margin-right:6px;font-size:18px;">error</i>
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
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="material-icons" style="margin-right:6px;color:var(--primary);font-size:16px;">business</i>
                                    <span><?= $row['departemen'] ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="material-icons" style="margin-right:6px;color:var(--success);font-size:16px;">work</i>
                                    <span><?= $row['jabatan'] ?></span>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight:600;color:var(--success);font-size:1rem;">
                                    Rp <?= number_format($row['gaji_per_jam'], 0, ',', '.') ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="material-icons" style="margin-right:6px;color:var(--primary);font-size:16px;">schedule</i>
                                    <span><?= date('d/m/Y H:i', strtotime($row['tanggal_update'])) ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?= base_url('admin/gaji/edit/' . $row['id_gaji']) ?>" 
                                       class="btn-icon" title="Edit">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    
                                    <a href="<?= base_url('admin/gaji/history/' . $row['id_gaji']) ?>" 
                                       class="btn-icon" title="Riwayat">
                                        <i class="material-icons">history</i>
                                    </a>
                                    
                                    <a href="<?= base_url('admin/gaji/delete/' . $row['id_gaji']) ?>" 
                                       class="btn-icon" 
                                       title="Hapus"
                                       onclick="return confirm('Yakin ingin menghapus konfigurasi gaji ini?')">
                                        <i class="material-icons">delete</i>
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
    // Initialize DataTable dengan styling konsisten
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "pageLength": 25,
        "order": [[ 4, "desc" ]],
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
               '<"row"<"col-sm-12"tr>>' +
               '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        "initComplete": function() {
            // Styling konsisten untuk elemen DataTable
            $('.dataTables_length select').addClass('form-control');
            $('.dataTables_filter input').addClass('form-control');
        }
    });
});
</script>
   </div>
</div>
<?= $this->endSection() ?>
