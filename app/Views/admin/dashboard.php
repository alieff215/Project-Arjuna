<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<!-- ==================== PAGE-ONLY STYLES (Dashboard) ==================== -->
<style>
    /* NOTE:
     - Tidak ada :root atau [data-theme="dark"] di sini.
     - Semua warna ambil dari token global yang sudah didefinisikan di <head>.
     - Kalau token global belum ada, var() punya fallback agar aman. */

    /* ===== Page Background (opsional: gunakan util global app-content-bg) ===== */
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

    /* ===== Legacy Cards (pakai token global) ===== */
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

    .card .card-footer {
        padding: 12px 18px !important;
        border-top: 1px solid var(--border, rgba(16, 24, 40, .12)) !important;
        background: var(--card, #fff);
        color: var(--muted, #6b7b93);
    }

    .card-title {
        margin: 0;
        color: var(--text, #0b132b);
        font-weight: 800;
        letter-spacing: .2px;
        font-size: var(--fz-title, 20px);
    }

    .card-category {
        margin: 2px 0 0;
        color: var(--muted, #6b7b93) !important;
        font-weight: 600;
        font-size: var(--fz-micro, 12px);
    }

    .card-header-primary {
        background: linear-gradient(180deg, color-mix(in oklab, var(--primary, #3b82f6) 10%, var(--card, #fff)), var(--card, #fff));
    }

    .card-header-success {
        background: linear-gradient(180deg, color-mix(in oklab, var(--success, #10b981) 12%, var(--card, #fff)), var(--card, #fff));
    }

    .card-header-info {
        background: linear-gradient(180deg, color-mix(in oklab, var(--ring, #2563eb) 10%, var(--card, #fff)), var(--card, #fff));
    }

    .card-header-danger {
        background: linear-gradient(180deg, color-mix(in oklab, var(--danger, #ef4444) 10%, var(--card, #fff)), var(--card, #fff));
    }

    /* ===== Grid responsif untuk panel ===== */
    .dash-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 16px;
        margin-top: 16px;
        align-items: stretch;
    }

    /* ===== Panel modern ===== */
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

    .panel__date {
        font-size: var(--fz-micro, 12px);
        color: var(--muted, #6b7b93);
        font-weight: 700;
        white-space: nowrap;
    }

    .panel__body {
        padding: 16px;
        flex: 1 1 auto;
    }

    .panel__foot {
        padding: 12px 16px;
        border-top: 1px solid var(--border, rgba(16, 24, 40, .12));
        color: var(--muted, #6b7b93);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--card, #fff);
        gap: 10px;
        flex-wrap: wrap;
    }

    .badge-soft {
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 800;
        font-size: var(--fz-micro, 12px);
        border: 1px solid var(--border, rgba(16, 24, 40, .12));
        background: color-mix(in oklab, var(--card-solid, #fff) 90%, transparent);
        color: var(--muted, #6b7b93);
    }

    .toolbar {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-icon {
        width: 38px;
        height: 38px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        border: 1px solid var(--border, rgba(16, 24, 40, .12));
        background: var(--card, #fff);
        cursor: pointer;
        transition: transform .15s ease;
        touch-action: manipulation;
    }

    .btn-icon:hover {
        transform: translateY(-1px);
    }

    .btn-icon .material-icons {
        font-size: 20px;
    }

    /* ===== Metrics ===== */
    .metrics {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 10px;
    }

    .metric {
        border: 1px solid var(--border, rgba(16, 24, 40, .12));
        background: color-mix(in oklab, var(--card, #fff) 92%, transparent);
        border-radius: 12px;
        padding: 12px;
        text-align: center;
    }

    .metric__label {
        font-size: var(--fz-micro, 12px);
        font-weight: 900;
        letter-spacing: .5px;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .metric__value {
        font-size: clamp(22px, 2.2vw + 14px, 32px);
        font-weight: 900;
        color: var(--text, #0b132b);
        line-height: 1;
    }

    .is-hadir {
        color: var(--success, #10b981);
    }

    .is-sakit {
        color: #ca8a04;
    }

    .is-izin {
        color: var(--primary, #3b82f6);
    }

    .is-alfa {
        color: var(--danger, #ef4444);
    }

    /* ===== Chartist ===== */
    .chartbox .ct-chart {
        height: clamp(220px, 36vh, 360px);
    }

    .chartbox__meta {
        padding: 8px 16px 16px 16px;
        color: var(--muted, #6b7b93);
    }

    .ct-grid {
        stroke: rgba(2, 6, 23, .10);
    }

    .ct-label {
        color: #667085;
        fill: #667085;
        font-size: 11.5px;
    }

    .ct-series-a .ct-line {
        stroke: #0f172a;
        stroke-width: 2.6px;
    }

    .ct-series-a .ct-point {
        stroke: #0f172a;
        stroke-width: 6px;
    }

    /* ===== Responsive ===== */
    @media (max-width: 991.98px) {
        .content.app-content-bg {
            padding-top: 10px !important;
        }
    }

    @media (max-width: 767.98px) {
        .card .card-body {
            padding: 14px !important;
        }

        .panel__head {
            padding: 12px 14px;
        }

        .panel__body {
            padding: 14px;
        }

        .panel__foot {
            padding: 10px 14px;
        }
    }

    @media (max-width: 575.98px) {
        .container-fluid {
            padding: 0 10px !important;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
        }

        .panel__title {
            max-width: 70%;
        }
    }

    @media (max-width: 420px) {
        .dash-grid {
            gap: 12px;
        }

        .metrics {
            grid-template-columns: 1fr 1fr;
        }

        .chartbox .ct-chart {
            height: clamp(200px, 34vh, 320px);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .btn-icon {
            transition: none;
        }
    }

    /* ====== Layout seragam untuk 4 kartu rekap ====== */
    .equal-cards-row>[class^="col-"],
    .equal-cards-row>[class*=" col-"] {
        display: flex;
    }

    .equal-cards-row>[class^="col-"]>.card,
    .equal-cards-row>[class*=" col-"]>.card {
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
        width: 100%;
    }

    /* Header kartu: grid 3 kolom → [ikon | judul | angka] */
    .card.card-stats .card-header.card-header-icon {
        display: grid;
        grid-template-columns: 92px 1fr auto;
        /* ikon tetap, judul fleksibel, angka auto */
        grid-auto-rows: auto;
        align-items: center;
        column-gap: 16px;
        min-height: 128px;
        /* tinggi seragam */
        padding-bottom: 14px;
        /* jarak sebelum garis bawah header */
        border-bottom: 1px solid var(--border);
        background: linear-gradient(180deg, var(--card-solid, #fff), transparent);
    }

    /* Ikon kotak kiri */
    .card.card-stats .card-header .card-icon {
        grid-column: 1;
        grid-row: 1 / span 2;
        width: 92px;
        height: 92px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        margin: 0;
        box-shadow: 0 10px 20px rgba(12, 20, 40, .12);
    }

    /* Judul (dua baris boleh), rata kiri */
    .card.card-stats .card-header .card-category {
        grid-column: 2;
        grid-row: 1;
        margin: 0;
        line-height: 1.15;
        font-weight: 800;
        font-size: var(--fz-micro, 13px);
        color: var(--muted);
        text-transform: none;
    }

    /* Angka besar rata kanan (selalu di kolom ke-3) */
    .card.card-stats .card-header .card-title {
        grid-column: 3;
        grid-row: 1;
        margin: 0;
        text-align: right;
        line-height: 1;
        font-size: clamp(24px, 2.2vw + 12px, 32px);
        font-weight: 900;
        color: var(--text);
    }

    /* HAPUS garis dekoratif di dalam header yang menabrak ikon */
    .card.card-stats .card-header::after {
        content: none !important;
    }

    [data-theme="dark"] .card.card-stats .card-header::after {
        content: none !important;
    }

    /* Footer seragam: satu baris, ikon + teks sejajar */
    .card.card-stats .card-footer {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 56px;
        border-top: 1px solid var(--border);
        /* tetap ada garis atas footer */
    }

    .card.card-stats .card-footer .stats {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: var(--muted);
    }

    /* Responsif kecil: rapatkan sedikit */
    @media (max-width:575.98px) {
        .card.card-stats .card-header.card-header-icon {
            grid-template-columns: 80px 1fr auto;
            min-height: 112px;
        }

        .card.card-stats .card-header .card-icon {
            width: 80px;
            height: 80px;
        }
    }
</style>

<div class="content app-content-bg" id="dashboardContent">
    <!-- TIDAK ADA THEME TOGGLE DI SINI. Toggle tema ada di NAVBAR global. -->

    <div class="container-fluid">
        <!-- ===== Rekap jumlah data ===== -->
        <div class="row equal-cards-row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-stats">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <a href="<?= base_url('admin/karyawan'); ?>" aria-label="Menu Karyawan"><i class="material-icons">person</i></a>
                        </div>
                        <div>
                            <p class="card-category">Jumlah Karyawan</p>
                            <h3 class="card-title"><?= count($karyawan); ?></h3>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="stats"><i class="material-icons" style="color:var(--primary)">check</i> Terdaftar</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <a href="<?= base_url('admin/admin'); ?>" aria-label="Menu Supervisor"><i class="material-icons">person_4</i></a>
                        </div>
                        <div>
                            <p class="card-category">Jumlah Supervisor</p>
                            <h3 class="card-title"><?= count($admin); ?></h3>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="stats"><i class="material-icons" style="color:var(--success)">check</i> Terdaftar</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <a href="<?= base_url('admin/departemen'); ?>" aria-label="Menu Departemen"><i class="material-icons">grade</i></a>
                        </div>
                        <div>
                            <p class="card-category">Jumlah Departemen</p>
                            <h3 class="card-title"><?= count($departemen); ?></h3>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="stats"><i class="material-icons" style="color:var(--primary)">home</i> <?= $generalSettings->company_name; ?></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <a href="<?= base_url('admin/petugas'); ?>" aria-label="Menu Petugas"><i class="material-icons">settings</i></a>
                        </div>
                        <div>
                            <p class="card-category">Jumlah Petugas</p>
                            <h3 class="card-title"><?= count($petugas); ?></h3>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="stats"><i class="material-icons" style="color:var(--danger)">person</i> Petugas & Administrator</div>
                    </div>
                </div>
            </div>

            
        </div>

        <!-- ===== BARIS 1 — ABSENSI ===== -->
        <div class="dash-grid">
            <!-- Absensi Karyawan -->
            <div class="panel">
                <div class="panel__head">
                    <h4 class="panel__title">
                        <span>Absensi Karyawan Hari Ini</span>
                        <span class="badge-soft"><?= $generalSettings->company_name; ?></span>
                    </h4>
                    <span class="panel__date"><?= $dateNow; ?></span>
                </div>
                <div class="panel__body">
                    <div class="metrics">
                        <div class="metric">
                            <div class="metric__label is-hadir">Hadir</div>
                            <div class="metric__value"><?= $jumlahKehadiranKaryawan['hadir']; ?></div>
                        </div>
                        <div class="metric">
                            <div class="metric__label is-sakit">Sakit</div>
                            <div class="metric__value"><?= $jumlahKehadiranKaryawan['sakit']; ?></div>
                        </div>
                        <div class="metric">
                            <div class="metric__label is-izin">Izin</div>
                            <div class="metric__value"><?= $jumlahKehadiranKaryawan['izin']; ?></div>
                        </div>
                        <div class="metric">
                            <div class="metric__label is-alfa">Alfa</div>
                            <div class="metric__value"><?= $jumlahKehadiranKaryawan['alfa']; ?></div>
                        </div>
                    </div>
                </div>
                <div class="panel__foot">
                    <span><i class="material-icons" style="vertical-align:middle;margin-right:6px;color:var(--primary)">check_circle</i>Rekap otomatis per hari</span>
                    <div class="toolbar">
                        <a class="btn-icon" href="<?= base_url('admin/karyawan'); ?>" title="Kelola karyawan" aria-label="Kelola karyawan"><i class="material-icons">people</i></a>
                        <a class="btn-icon" href="<?= base_url('admin/absen-karyawan'); ?>" title="Lihat data" aria-label="Lihat data absen karyawan"><i class="material-icons">open_in_new</i></a>
                    </div>
                </div>
            </div>

            <!-- Absensi Supervisor -->
            <div class="panel">
                <div class="panel__head">
                    <h4 class="panel__title">
                        <span>Absensi Supervisor Hari Ini</span>
                        <span class="badge-soft">Supervisor</span>
                    </h4>
                    <span class="panel__date"><?= $dateNow; ?></span>
                </div>
                <div class="panel__body">
                    <div class="metrics">
                        <div class="metric">
                            <div class="metric__label is-hadir">Hadir</div>
                            <div class="metric__value"><?= $jumlahKehadiranAdmin['hadir']; ?></div>
                        </div>
                        <div class="metric">
                            <div class="metric__label is-sakit">Sakit</div>
                            <div class="metric__value"><?= $jumlahKehadiranAdmin['sakit']; ?></div>
                        </div>
                        <div class="metric">
                            <div class="metric__label is-izin">Izin</div>
                            <div class="metric__value"><?= $jumlahKehadiranAdmin['izin']; ?></div>
                        </div>
                        <div class="metric">
                            <div class="metric__label is-alfa">Alfa</div>
                            <div class="metric__value"><?= $jumlahKehadiranAdmin['alfa']; ?></div>
                        </div>
                    </div>
                </div>
                <div class="panel__foot">
                    <span><i class="material-icons" style="vertical-align:middle;margin-right:6px;color:var(--success)">verified</i>Sinkron dengan data supervisor</span>
                    <div class="toolbar">
                        <a class="btn-icon" href="<?= base_url('admin/admin'); ?>" title="Kelola supervisor" aria-label="Kelola supervisor"><i class="material-icons">admin_panel_settings</i></a>
                        <a class="btn-icon" href="<?= base_url('admin/absen-Admin'); ?>" title="Lihat data" aria-label="Lihat data absen supervisor"><i class="material-icons">open_in_new</i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== BARIS 2 — CHART ===== -->
        <div class="dash-grid">
            <!-- Chart Karyawan -->
            <div class="panel chartbox">
                <div class="panel__head">
                    <h4 class="panel__title">Tingkat Kehadiran Karyawan</h4>
                    <span class="badge-soft">7 hari terakhir</span>
                </div>
                <div class="panel__body" style="padding:0 12px 12px 12px;">
                    <div class="ct-chart" id="kehadiranKaryawan"></div>
                </div>
                <div class="panel__foot">
                    <span>Jumlah kehadiran karyawan dalam 7 hari terakhir.</span>
                    <a href="<?= base_url('admin/absen-karyawan'); ?>" style="text-decoration:none;color:var(--primary)">
                        <i class="material-icons" style="vertical-align:middle;margin-right:6px;">insights</i>Lihat data
                    </a>
                </div>
            </div>

            <!-- Chart Admin -->
            <div class="panel chartbox">
                <div class="panel__head">
                    <h4 class="panel__title">Tingkat Kehadiran Admin</h4>
                    <span class="badge-soft">7 hari terakhir</span>
                </div>
                <div class="panel__body" style="padding:0 12px 12px 12px;">
                    <div class="ct-chart" id="kehadiranAdmin"></div>
                </div>
                <div class="panel__foot">
                    <span>Jumlah kehadiran admin dalam 7 hari terakhir.</span>
                    <a href="<?= base_url('admin/absen-Admin'); ?>" style="text-decoration:none;color:var(--success)">
                        <i class="material-icons" style="vertical-align:middle;margin-right:6px;">query_stats</i>Lihat data
                    </a>
                </div>
            </div>
        </div>

        
        <!-- ===== PALING BAWAH — Karyawan Tidak Hadir 3 Hari Berturut-turut ===== -->
        <div class="panel">
            <div class="panel__head">
                <h4 class="panel__title">
                    <span>Karyawan Tidak Hadir 3 Hari Berturut-turut</span>
                    <span class="badge-soft"><?= (int)($jumlahTidakHadirLebih3Hari ?? 0); ?> orang</span>
                </h4>
                <span class="panel__date"><?= $dateNow; ?></span>
            </div>
            <div class="panel__body">
                <?php if (!empty($karyawanTidakHadirLebih3Hari)): ?>
                    <div style="display:flex;flex-direction:column;gap:10px;max-height:360px;overflow:auto;padding-right:4px;">
                        <?php foreach ($karyawanTidakHadirLebih3Hari as $item): ?>
                            <div style="display:flex;align-items:center;gap:10px;border:1px solid var(--border);border-radius:12px;padding:10px 12px;background:var(--card);">
                                <i class="material-icons" style="color:var(--danger)">event_busy</i>
                                <div style="display:flex;flex-direction:column;gap:2px;">
                                    <strong style="color:var(--text);line-height:1;"><?= esc($item['nama_karyawan']); ?></strong>
                                    <small style="color:var(--muted);">Departemen: <?= esc($item['departemen'] ?? '-'); ?><?= isset($item['jabatan']) ? ' • ' . esc($item['jabatan']) : '' ?></small>
                                </div>
                                <span style="margin-left:auto;color:var(--muted);font-weight:700;"><?= (int)($item['streak_days'] ?? 0); ?> hari</span>
                                <a class="btn-icon" href="<?= base_url('admin/karyawan'); ?>" title="Lihat detail" aria-label="Lihat detail karyawan"><i class="material-icons">open_in_new</i></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="border:1px dashed var(--border);border-radius:12px;padding:16px;color:var(--muted);">Tidak ada karyawan dengan streak absen 3 hari berturut-turut.</div>
                <?php endif; ?>
            </div>
            <div class="panel__foot">
                <span><i class="material-icons" style="vertical-align:middle;margin-right:6px;color:var(--danger)">warning</i>Streak dihitung untuk hari kerja (Senin–Sabtu)</span>
                <div class="toolbar">
                    <a class="btn-icon" href="<?= base_url('admin/karyawan'); ?>" title="Kelola karyawan" aria-label="Kelola karyawan"><i class="material-icons">people</i></a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ==================== SCRIPTS ==================== -->
<script src="<?= base_url('assets/js/plugins/chartist.min.js') ?>"></script>
<script>
    // HANYA untuk chart; tidak ada script toggle tema di halaman ini.
    document.addEventListener('DOMContentLoaded', initDashboardPageCharts);

    function initDashboardPageCharts() {
        if (document.querySelector('#kehadiranKaryawan')) {
            const dataKaryawan = [<?php foreach ($grafikKehadiranKaryawan as $v) echo "$v,"; ?>];
            const labels = [<?php foreach ($dateRange as $d) echo "'$d',"; ?>];
            let maxVal = 0;
            dataKaryawan.forEach(v => {
                if (v > maxVal) maxVal = v;
            });
            new Chartist.Line('#kehadiranKaryawan', {
                labels,
                series: [dataKaryawan]
            }, {
                lineSmooth: Chartist.Interpolation.cardinal({
                    tension: 0
                }),
                low: 0,
                high: maxVal + (maxVal / 4 || 4),
                fullWidth: true,
                chartPadding: {
                    top: 10,
                    right: 12,
                    bottom: 10,
                    left: 12
                },
                showPoint: true
            });
        }

        if (document.querySelector('#kehadiranAdmin')) {
            const dataAdmin = [<?php foreach ($grafikkKehadiranAdmin as $v) echo "$v,"; ?>];
            const labels = [<?php foreach ($dateRange as $d) echo "'$d',"; ?>];
            let maxVal = 0;
            dataAdmin.forEach(v => {
                if (v > maxVal) maxVal = v;
            });
            new Chartist.Line('#kehadiranAdmin', {
                labels,
                series: [dataAdmin]
            }, {
                lineSmooth: Chartist.Interpolation.cardinal({
                    tension: 0
                }),
                low: 0,
                high: maxVal + (maxVal / 4 || 4),
                fullWidth: true,
                chartPadding: {
                    top: 10,
                    right: 12,
                    bottom: 10,
                    left: 12
                },
                showPoint: true
            });
        }
    }
</script>

<?= $this->endSection() ?>
