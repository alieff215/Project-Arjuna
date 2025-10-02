 <?= $this->extend('templates/admin_page_layout') ?>
 <?= $this->section('content') ?>

 <!-- ==================== THEME STYLES ==================== -->
 <style>
     /* ===== Design System (CSS Variables) ===== */
     :root {
         --bg: #f5f7fb;
         --bg-accent: #ebf1ff;
         --card: #fff;
         --card-2: #f8fafc;
         --text: #0f172a;
         --muted: #5b6b80;
         --border: #e6ebf2;
         --ring: #3b82f6;
         --shadow: 0 14px 40px rgba(15, 23, 42, .08);
         --primary: #2563eb;
         --primary-2: #60a5fa;
         --success: #10b981;
         --info: #7c3aed;
         --danger: #ef4444;
         --radius: 18px;
         --radius-sm: 14px;
         --gap: 16px;

         /* Tipografi responsif */
         --fz-title: clamp(16px, 1.2vw + 12px, 20px);
         --fz-body: clamp(13px, .8vw + 10px, 16px);
         --fz-micro: clamp(11px, .6vw + 8px, 13px);

         /* Lebar kontainer maksimum agar nyaman di layar besar */
         --container-max: 1280px;
     }

     [data-theme="dark"] {
         --bg: #0b1220;
         --bg-accent: #0f1d3a;
         --card: #101828;
         --card-2: #0f172a;
         --text: #e5eaf3;
         --muted: #94a3b8;
         --border: rgba(226, 232, 240, .10);
         --ring: #22c3f3;
         --shadow: 0 18px 44px rgba(0, 0, 0, .35);
         --primary: #5fb2ff;
         --primary-2: #76d1ff;
         --success: #34d399;
         --info: #9b8cff;
         --danger: #fb6b6b;
     }

     /* ===== Page Background ===== */
     .content {
         background:
             radial-gradient(1200px 500px at 15% 0%, var(--bg-accent) 0%, transparent 60%),
             radial-gradient(900px 360px at 100% -5%, var(--bg-accent) 0%, transparent 55%),
             linear-gradient(180deg, var(--bg), var(--bg));
         min-height: calc(100vh - 64px);
         padding: 18px 0 24px !important;
         font-size: var(--fz-body);
     }

     [data-theme="dark"] .content {
         background:
             radial-gradient(1200px 500px at 15% 0%, #0b2a4b 0%, transparent 60%),
             radial-gradient(900px 360px at 100% -5%, #152a44 0%, transparent 55%),
             linear-gradient(180deg, var(--bg), var(--bg));
     }

     .container-fluid {
         padding: 0 14px !important;
         margin: 0 auto;
         max-width: var(--container-max);
         width: 100%;
     }

     .row {
         row-gap: var(--gap);
     }

     /* ===== Card legacy (biarkan sesuai sistem) ===== */
     .card {
         background: var(--card) !important;
         border: 1px solid var(--border) !important;
         border-radius: var(--radius) !important;
         box-shadow: var(--shadow) !important;
         overflow: hidden;
     }

     .card-header {
         padding: 16px 18px !important;
         border-bottom: 1px solid var(--border) !important;
         background: linear-gradient(180deg, var(--card-2), var(--card));
     }

     .card .card-body {
         padding: 16px 18px !important;
         color: var(--text);
     }

     .card .card-footer {
         padding: 12px 18px !important;
         border-top: 1px solid var(--border) !important;
         background: var(--card);
         color: var(--muted);
     }

     .card-title {
         margin: 0;
         color: var(--text);
         font-weight: 800;
         letter-spacing: .2px;
         font-size: var(--fz-title);
     }

     .card-category {
         margin: 2px 0 0;
         color: var(--muted) !important;
         font-weight: 600;
         font-size: var(--fz-micro);
     }

     .card-header-primary {
         background: linear-gradient(180deg, color-mix(in oklab, var(--primary) 10%, var(--card)), var(--card));
     }

     .card-header-success {
         background: linear-gradient(180deg, color-mix(in oklab, var(--success) 12%, var(--card)), var(--card));
     }

     .card-header-info {
         background: linear-gradient(180deg, color-mix(in oklab, var(--info) 10%, var(--card)), var(--card));
     }

     .card-header-danger {
         background: linear-gradient(180deg, color-mix(in oklab, var(--danger) 10%, var(--card)), var(--card));
     }

     /* ===== Grid rapi & RESPONSIF untuk panel =====
       Auto-fit akan membuat jumlah kolom menyesuaikan lebar kontainer */
     .dash-grid {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
         gap: var(--gap);
         margin-top: var(--gap);
         align-items: stretch;
     }

     /* ===== Panel modern ===== */
     .panel {
         border: 1px solid var(--border);
         border-radius: var(--radius);
         background: var(--card);
         box-shadow: var(--shadow);
         overflow: hidden;
         display: flex;
         flex-direction: column;
         min-width: 0;
         /* penting untuk mencegah overflow di grid */
     }

     .panel__head {
         display: flex;
         align-items: center;
         justify-content: space-between;
         gap: 12px;
         padding: 14px 16px;
         background: linear-gradient(180deg, var(--card-2), var(--card));
         border-bottom: 1px solid var(--border);
     }

     .panel__title {
         margin: 0;
         font-weight: 800;
         letter-spacing: .2px;
         color: var(--text);
         display: flex;
         align-items: center;
         gap: 10px;
         font-size: var(--fz-title);
         min-width: 0;
         overflow: hidden;
         text-overflow: ellipsis;
         white-space: nowrap;
     }

     .panel__date {
         font-size: var(--fz-micro);
         color: var(--muted);
         font-weight: 700;
         white-space: nowrap;
     }

     .panel__body {
         padding: 16px;
         flex: 1 1 auto;
     }

     .panel__foot {
         padding: 12px 16px;
         border-top: 1px solid var(--border);
         color: var(--muted);
         display: flex;
         justify-content: space-between;
         align-items: center;
         background: var(--card);
         gap: 10px;
         flex-wrap: wrap;
     }

     .panel__foot a {
         inline-size: fit-content;
     }

     .badge-soft {
         padding: 6px 10px;
         border-radius: 999px;
         font-weight: 800;
         font-size: var(--fz-micro);
         border: 1px solid var(--border);
         background: var(--card-2);
         color: var(--muted);
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
         border: 1px solid var(--border);
         background: var(--card);
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

     /* ===== Metrics responsif ===== */
     .metrics {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
         gap: 10px;
     }

     .metric {
         border: 1px solid var(--border);
         background: color-mix(in oklab, var(--card) 92%, transparent);
         border-radius: 12px;
         padding: 12px;
         text-align: center;
     }

     .metric__label {
         font-size: var(--fz-micro);
         font-weight: 900;
         letter-spacing: .5px;
         text-transform: uppercase;
         margin-bottom: 6px;
     }

     .metric__value {
         font-size: clamp(22px, 2.2vw + 14px, 32px);
         font-weight: 900;
         color: var(--text);
         line-height: 1;
     }

     .is-hadir {
         color: var(--success);
     }

     .is-sakit {
         color: #ca8a04;
     }

     .is-izin {
         color: var(--primary);
     }

     .is-alfa {
         color: var(--danger);
     }

     /* ===== Chartist ===== */
     .chartbox .ct-chart {
         /* tinggi chart responsif: min 220px, prefer 36vh, max 360px */
         height: clamp(220px, 36vh, 360px);
     }

     .chartbox__meta {
         padding: 8px 16px 16px 16px;
         color: var(--muted);
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

     [data-theme="dark"] .ct-grid {
         stroke: rgba(255, 255, 255, .12);
     }

     [data-theme="dark"] .ct-label {
         color: #c7d2fe;
         fill: #c7d2fe;
     }

     [data-theme="dark"] .ct-series-a .ct-line,
     [data-theme="dark"] .ct-series-a .ct-point {
         stroke: #e5e7eb;
     }

     /* ===== Theme toggle ===== */
     .theme-toggle {
         position: sticky;
         top: 12px;
         z-index: 30;
         display: flex;
         justify-content: flex-end;
         padding: 0 14px 8px;
     }

     .theme-btn {
         display: inline-flex;
         align-items: center;
         gap: 8px;
         background: var(--card);
         color: var(--text);
         border: 1px solid var(--border);
         border-radius: 999px;
         padding: 10px 14px;
         cursor: pointer;
         box-shadow: var(--shadow);
     }

     .theme-btn .material-icons {
         font-size: 20px;
     }

     .theme-label {
         font-weight: 600;
         font-size: 13px;
         color: var(--muted);
     }

     /* ===== Responsif tambahan ===== */
     @media (max-width: 991.98px) {
         .content {
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

         .panel__date {
             font-weight: 600;
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

         .theme-toggle {
             padding: 0 10px 8px;
         }
     }

     /* Prefer reduced motion */
     @media (prefers-reduced-motion: reduce) {
         .btn-icon {
             transition: none;
         }
     }
 </style>

 <div class="content" id="dashboardContent">
     <!-- Theme Toggle -->
     <div class="theme-toggle">
         <button type="button" class="theme-btn" id="themeBtn" aria-label="Toggle theme">
             <i class="material-icons" id="themeIcon">dark_mode</i>
             <span class="theme-label" id="themeText">Dark Mode</span>
         </button>
     </div>

     <div class="container-fluid">

         <!-- ===== Rekap jumlah data ===== -->
         <div class="row">
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
                             <a href="<?= base_url('admin/admin'); ?>" aria-label="Menu Admin"><i class="material-icons">person_4</i></a>
                         </div>
                         <div>
                             <p class="card-category">Jumlah Admin</p>
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
                         <div class="stats"><i class="material-icons" style="color:var(--info)">home</i> <?= $generalSettings->company_name; ?></div>
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

         <!-- ===== BARIS 1 — ABSENSI (Grid responsif) ===== -->
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

             <!-- Absensi Admin -->
             <div class="panel">
                 <div class="panel__head">
                     <h4 class="panel__title">
                         <span>Absensi Admin Hari Ini</span>
                         <span class="badge-soft">Administrator</span>
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
                     <span><i class="material-icons" style="vertical-align:middle;margin-right:6px;color:var(--success)">verified</i>Sinkron dengan data admin</span>
                     <div class="toolbar">
                         <a class="btn-icon" href="<?= base_url('admin/admin'); ?>" title="Kelola admin" aria-label="Kelola admin"><i class="material-icons">admin_panel_settings</i></a>
                         <a class="btn-icon" href="<?= base_url('admin/absen-Admin'); ?>" title="Lihat data" aria-label="Lihat data absen admin"><i class="material-icons">open_in_new</i></a>
                     </div>
                 </div>
             </div>
         </div>

         <!-- ===== BARIS 2 — CHART (Grid responsif) ===== -->
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

     </div>
 </div>

 <!-- ==================== SCRIPTS ==================== -->
 <script src="<?= base_url('assets/js/plugins/chartist.min.js') ?>"></script>
 <script>
     // ========= Theme persistence & toggle =========
     (function() {
         const root = document.documentElement;
         const saved = localStorage.getItem('dash-theme');
         if (saved) root.setAttribute('data-theme', saved);

         const btn = document.getElementById('themeBtn');
         const icon = document.getElementById('themeIcon');
         const text = document.getElementById('themeText');

         function syncUI() {
             const mode = root.getAttribute('data-theme') || 'light';
             if (mode === 'dark') {
                 icon.textContent = 'light_mode';
                 text.textContent = 'Light Mode';
             } else {
                 icon.textContent = 'dark_mode';
                 text.textContent = 'Dark Mode';
             }
         }
         syncUI();

         btn.addEventListener('click', function() {
             const current = root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
             const next = current === 'dark' ? 'light' : 'dark';
             root.setAttribute('data-theme', next);
             localStorage.setItem('dash-theme', next);
             syncUI();
         });
     })();

     // ========= Chart init (Chartist responsif by default) =========
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