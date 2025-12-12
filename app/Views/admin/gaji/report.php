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

/* Form styling konsisten */
.form-group {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.form-group label {
    font-weight: 600;
    color: var(--text, #0b132b);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    min-height: 24px;
}

.form-control {
    border: 1px solid var(--border, rgba(16, 24, 40, .12));
    border-radius: 8px;
    padding: 10px 12px;
    background: var(--card, #fff);
    color: var(--text, #0b132b);
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    height: 42px;
    flex: 1;
}

.form-control:focus {
    border-color: var(--primary, #3b82f6);
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    outline: 0;
}

/* Department dropdown styling */
#id_departemen option {
    padding: 8px 12px;
    font-size: 14px;
    line-height: 1.4;
}

#id_departemen option:first-child {
    font-weight: 600;
    color: var(--primary);
}

/* Enhanced select styling */
select.form-control {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 12px center;
    background-repeat: no-repeat;
    background-size: 16px 12px;
    padding-right: 40px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}

/* Filter form alignment */
#filterForm .row {
    align-items: end;
}

#filterForm .col-md-3 {
    display: flex;
    flex-direction: column;
}

#filterForm .form-group:last-child {
    justify-content: flex-end;
}

#filterForm .d-flex.gap-2 {
    height: 42px;
    align-items: center;
}

/* Additional alignment fixes */
#filterForm .form-group {
    margin-bottom: 0;
}

#filterForm .form-group label {
    margin-bottom: 8px;
    line-height: 1.2;
}

#filterForm .form-control {
    margin-bottom: 0;
}

/* Responsive filter alignment */
@media (max-width: 767.98px) {
    #filterForm .row {
        align-items: stretch;
    }
    
    #filterForm .col-md-3 {
        margin-bottom: 16px;
    }
    
    #filterForm .form-group:last-child {
        justify-content: flex-start;
    }
    
    #filterForm .d-flex.gap-2 {
        height: auto;
        justify-content: center;
    }
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

.btn-success {
    background: var(--success, #10b981);
    border-color: var(--success, #10b981);
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
            <h1 class="h3 mb-0" style="color: var(--text); font-weight: 700;">📊 Laporan Gaji Karyawan</h1>
            <p class="text-muted mb-0">Analisis dan monitoring gaji karyawan berdasarkan periode dan departemen</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-success" onclick="exportToCSV()">
                <i class="material-icons" style="font-size:18px;">file_download</i> Export CSV
            </button>
            <a href="<?= base_url('admin/gaji') ?>" class="btn btn-secondary">
                <i class="material-icons" style="font-size:18px;">arrow_back</i> Kembali
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold" style="color: var(--text);">
                <i class="material-icons" style="vertical-align:middle;margin-right:8px;font-size:18px;">filter_list</i>
                Filter Laporan
            </h6>
        </div>
        <div class="card-body">
            <form method="get" action="<?= base_url('admin/gaji/report') ?>" id="filterForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">
                                <i class="material-icons" style="vertical-align:middle;margin-right:6px;font-size:16px;">date_range</i>
                                Tanggal Mulai
                            </label>
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
                            <label for="end_date">
                                <i class="material-icons" style="vertical-align:middle;margin-right:6px;font-size:16px;">date_range</i>
                                Tanggal Akhir
                            </label>
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
                            <label for="id_departemen">
                                <i class="material-icons" style="vertical-align:middle;margin-right:6px;font-size:16px;">business</i>
                                Departemen
                            </label>
                            <select class="form-control" id="id_departemen" name="id_departemen">
                                <option value="">Semua Departemen</option>
                                <?php foreach ($departemen as $dept): ?>
                                    <option value="<?= $dept['id_departemen'] ?>" 
                                            <?= ($id_departemen == $dept['id_departemen']) ? 'selected' : '' ?>>
                                        <?= $dept['departemen'] ?> - <?= $dept['jabatan'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="material-icons" style="font-size:18px;">search</i> Filter
                                </button>
                                <a href="<?= base_url('admin/gaji/report') ?>" class="btn btn-secondary">
                                    <i class="material-icons" style="font-size:18px;">refresh</i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Summary -->
    <div class="row equal-cards-row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">people</i>
                        </div>
                    <div>
                        <p class="card-category">Total Karyawan</p>
                        <h3 class="card-title"><?= count($report_data) ?></h3>
                        </div>
                    </div>
                <div class="card-footer">
                    <div class="stats"><i class="material-icons" style="color:var(--primary);font-size:16px;">check</i> Dalam Laporan</div>
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
                        <p class="card-category">Total Gaji</p>
                        <h3 class="card-title">Rp <?= number_format(array_sum(array_column($report_data, 'total_gaji')), 0, ',', '.') ?></h3>
                        </div>
                    </div>
                <div class="card-footer">
                    <div class="stats"><i class="material-icons" style="color:var(--success);font-size:16px;">trending_up</i> Total Pembayaran</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">schedule</i>
                            </div>
                    <div>
                        <p class="card-category">Total Jam Kerja</p>
                        <h3 class="card-title"><?= number_format(array_sum(array_column($report_data, 'total_jam_kerja')), 1, ',', '.') ?> jam</h3>
                        </div>
                    </div>
                <div class="card-footer">
                    <div class="stats"><i class="material-icons" style="color:var(--primary);font-size:16px;">timer</i> Jam Kerja</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">trending_up</i>
                    </div>
                    <div>
                        <p class="card-category">Rata-rata Gaji</p>
                        <h3 class="card-title">
                                <?php 
                                $avg_gaji = count($report_data) > 0 ? array_sum(array_column($report_data, 'total_gaji')) / count($report_data) : 0;
                                ?>
                                Rp <?= number_format($avg_gaji, 0, ',', '.') ?>
                        </h3>
                            </div>
                        </div>
                <div class="card-footer">
                    <div class="stats"><i class="material-icons" style="color:var(--danger);font-size:16px;">analytics</i> Per Karyawan</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Data Table -->
    <div class="panel">
        <div class="panel__head">
            <h4 class="panel__title">
                <i class="material-icons" style="font-size:20px;">assessment</i>
                Data Laporan Gaji 
                (<?= date('d/m/Y', strtotime($start_date)) ?> - <?= date('d/m/Y', strtotime($end_date)) ?>)
            </h4>
        </div>
        <div class="panel__body">
            <?php if (empty($report_data)): ?>
                <div class="text-center py-4">
                    <i class="material-icons" style="font-size:4rem;color:var(--muted);margin-bottom:1rem;">inbox</i>
                    <h5 style="color: var(--text);">Tidak ada data laporan gaji</h5>
                    <p style="color: var(--muted);">Coba ubah periode atau filter yang dipilih</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="reportTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama Karyawan</th>
                                <th>Departemen</th>
                                <th>Jabatan</th>
                                <th>Gaji/Jam</th>
                                <th>Kehadiran</th>
                                <th>Total Jam (Kelipatan 0.5)</th>
                                <th>Total Gaji</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($report_data as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons" style="margin-right:6px;color:var(--primary);font-size:16px;">badge</i>
                                        <span style="font-weight:600;"><?= $row['nis'] ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons" style="margin-right:6px;color:var(--success);font-size:16px;">person</i>
                                        <span><?= $row['nama_karyawan'] ?></span>
                                    </div>
                                </td>
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
                                    <span style="font-weight:600;color:var(--primary);font-size:1rem;">
                                        Rp <?= number_format($row['gaji_per_jam'], 0, ',', '.') ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $row['total_kehadiran'] > 0 ? 'success' : 'secondary' ?>">
                                        <?= $row['total_kehadiran'] ?> hari
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons" style="margin-right:6px;color:var(--primary);font-size:16px;">schedule</i>
                                        <span style="font-weight:600;"><?= number_format($row['total_jam_kerja'], 1, ',', '.') ?> jam</span>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-weight:600;color:var(--success);font-size:1.1rem;">
                                        Rp <?= number_format($row['total_gaji'], 0, ',', '.') ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr style="background: rgba(102, 126, 234, 0.05);">
                                <td colspan="8" class="text-right" style="font-weight:600;">Total:</td>
                                <td style="font-weight:600;color:var(--success);font-size:1.1rem;">
                                    Rp <?= number_format(array_sum(array_column($report_data, 'total_gaji')), 0, ',', '.') ?>
                                </td>
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
    // Initialize DataTable dengan styling konsisten
    $('#reportTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "pageLength": 25,
        "order": [[ 8, "desc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [0] }
        ],
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
               '<"row"<"col-sm-12"tr>>' +
               '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        "initComplete": function() {
            // Styling konsisten untuk elemen DataTable
            $('.dataTables_length select').addClass('form-control');
            $('.dataTables_filter input').addClass('form-control');
        }
    });

    // Set default dates if not set
    if (!$('#start_date').val()) {
        $('#start_date').val('<?= date('Y-m-01') ?>');
    }
    if (!$('#end_date').val()) {
        $('#end_date').val('<?= date('Y-m-t') ?>');
    }

    // Form validation
    $('#filterForm').on('submit', function(e) {
        const startDate = new Date($('#start_date').val());
        const endDate = new Date($('#end_date').val());
        
        if (startDate > endDate) {
            e.preventDefault();
            alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
            return false;
        }
    });
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
