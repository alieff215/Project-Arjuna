<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
   /* ==============================
     THEME TOKENS
  ===============================*/
   :root {
      --bg-dark: #0b1020;
      --bg-light: #f5f7fb;
      --card-dark: #0f172a;
      --card-light: #ffffff;
      --text-dark: #e6edf6;
      --text-light: #0f172a;
      --border: rgba(148, 163, 184, .16);
      --radius: 16px;
      --shadow: 0 12px 30px rgba(0, 0, 0, .22);

      /* Responsive tokens */
      --pad-xs: 12px;
      --pad-sm: 14px;
      --pad-md: 16px;
      --pad-lg: 18px;
      --gap: 18px;
   }

   html[data-theme="dark"] {
      --bg: var(--bg-dark);
      --card: var(--card-dark);
      --text: var(--text-dark);
   }

   html[data-theme="light"] {
      --bg: var(--bg-light);
      --card: var(--card-light);
      --text: var(--text-light);
   }

   /* ==============================
     BASE LAYOUT
  ===============================*/
   .content {
      background: var(--bg);
      min-height: 100vh;
      padding: clamp(12px, 2vw, 20px) 0 clamp(18px, 2.4vw, 28px);
   }

   .container-fluid {
      padding-left: clamp(10px, 2vw, 18px) !important;
      padding-right: clamp(10px, 2vw, 18px) !important;
   }

   .card.modern {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow: hidden;
   }

   .card-header.clean {
      border-bottom: 1px solid var(--border);
      padding: clamp(var(--pad-xs), 2vw, var(--pad-md)) clamp(var(--pad-xs), 2.2vw, var(--pad-md));
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
   }

   .card-body.clean {
      padding: clamp(var(--pad-xs), 2vw, var(--pad-lg));
   }

   .row-gap {
      row-gap: var(--gap);
   }

   /* Judul/subjudul adaptif */
   .title-fixed {
      margin: 0;
      font-weight: 800;
      font-size: clamp(18px, 2.2vw, 22px);
      line-height: 1.25;
   }

   html[data-theme="light"] .title-fixed {
      color: #1e293b !important;
   }

   html[data-theme="dark"] .title-fixed {
      color: #ffffff !important;
   }

   .subtitle {
      margin: 2px 0 0;
      font-size: clamp(13px, 1.8vw, 15px);
      color: #64748b;
   }

   /* ==============================
     THEME TOGGLE
  ===============================*/
   .theme-toggle {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 12px;
      border-radius: 999px;
      border: 1px solid var(--border);
      background: var(--card);
      color: var(--text);
      cursor: pointer;
      user-select: none;
      transition: transform .08s ease, box-shadow .2s ease;
      font-size: clamp(12px, 1.6vw, 14px);
   }

   .theme-toggle:hover {
      transform: translateY(-1px);
   }

   .theme-toggle .material-icons {
      font-size: clamp(18px, 2vw, 20px);
   }

   /* ==============================
     FORM & INPUTS
  ===============================*/
   .form-row {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: clamp(10px, 2vw, 14px);
      flex-wrap: wrap;
   }

   .label {
      min-width: clamp(78px, 12vw, 100px);
      margin: 0;
      font-weight: 700;
      color: var(--text);
      font-size: clamp(13px, 1.8vw, 14.5px);
   }

   .input,
   .select {
      flex: 1 1 220px;
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: clamp(9px, 1.8vw, 12px) clamp(10px, 2vw, 12px);
      background: var(--card);
      color: var(--text);
      outline: none;
      font-size: clamp(13px, 1.8vw, 14.5px);
   }

   .input:focus,
   .select:focus {
      box-shadow: 0 0 0 3px rgba(96, 165, 250, .25);
      border-color: rgba(96, 165, 250, .7);
   }

   /* ==============================
     PANELS (Equal height on md+, auto on mobile)
  ===============================*/
   .col-eq {
      display: flex;
   }

   .panel {
      display: flex;
      flex-direction: column;
      width: 100%;
      min-height: 420px;
   }

   .panel .panel-body {
      display: flex;
      flex-direction: column;
      flex: 1;
   }

   @media (max-width: 767.98px) {
      .panel {
         min-height: unset;
      }

      /* auto height di mobile */
   }

   /* Buttons (bawaan bootstrap tetap dipakai) */
   .btn {
      border-radius: 12px;
      font-weight: 700;
   }

   .btn i.material-icons {
      vertical-align: middle;
   }

   .btn h4 {
      font-size: clamp(16px, 2.2vw, 20px);
      margin: 0;
   }

   .btn .material-icons {
      font-size: clamp(24px, 3vw, 32px) !important;
   }

   /* Grid dalam tombol agar tetap rapi di layar kecil */
   .btn .row {
      align-items: center;
   }

   @media (max-width: 575.98px) {
      .btn .col-auto {
         padding-right: 10px;
      }
   }
</style>

<div class="content">
   <div class="container-fluid">
      <div class="row row-gap">
         <div class="col-lg-12 col-md-12">

            <?php if (session()->getFlashdata('msg')) : ?>
               <div class="pb-2 px-3">
                  <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success' ?>">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="material-icons">close</i>
                     </button>
                     <?= session()->getFlashdata('msg') ?>
                  </div>
               </div>
            <?php endif; ?>

            <div class="card modern">
               <div class="card-header clean">
                  <div>
                     <h4 class="title-fixed">Generate Laporan</h4>
                     <p class="subtitle">Laporan absen karyawan & admin</p>
                  </div>

                  <!-- Toggle tema (opsional) -->
                  <button id="themeToggle" type="button" class="theme-toggle" aria-label="Ganti tema">
                     <i class="material-icons" aria-hidden="true">dark_mode</i>
                     <span id="themeLabel">Gelap</span>
                  </button>
               </div>

               <div class="card-body clean">
                  <div class="row row-gap">
                     <!-- ================= KARYAWAN ================= -->
                     <div class="col-md-6 col-eq">
                        <div class="card modern panel">
                           <div class="card-body clean panel-body">
                              <h5 class="text-primary" style="font-size:clamp(16px,2.2vw,20px)"><b>Laporan Absen Karyawan</b></h5>
                              <p class="subtitle">Pilih bulan & (opsional) departemen.</p>

                              <form action="<?= base_url('admin/laporan/karyawan'); ?>" method="post" class="mt-3 d-flex flex-column flex-grow-1">
                                 <div class="form-row">
                                    <p class="label">Bulan</p>
                                    <input type="month" name="tanggalKaryawan" id="tanggalKaryawan"
                                       value="<?= date('Y-m'); ?>" class="input" aria-label="Bulan laporan karyawan">
                                 </div>

                                 <div class="form-row">
                                    <p class="label">Departemen</p>
                                    <select name="departemen" class="select" aria-label="Pilih departemen">
                                       <option value="">Semua departemen</option>
                                       <?php foreach ($departemen as $key => $value) : ?>
                                          <?php
                                          $idDepartemen = $value['id_departemen'];
                                          $departemenText = "{$value['departemen']} {$value['jabatan']}";
                                          $jumlahKaryawan = count($karyawanPerDepartemen[$key]);
                                          ?>
                                          <option value="<?= $idDepartemen; ?>"><?= "{$departemenText} — {$jumlahKaryawan} karyawan"; ?></option>
                                       <?php endforeach; ?>
                                    </select>
                                 </div>

                                 <!-- Tombol full width, responsif -->
                                 <div class="mt-auto">
                                    <button type="submit" name="type" value="pdf" class="btn btn-danger pl-3 w-100 mb-2">
                                       <div class="row no-gutters">
                                          <div class="col-auto">
                                             <i class="material-icons">print</i>
                                          </div>
                                          <div class="col">
                                             <div class="text-start">
                                                <h4 class="d-inline"><b>Generate PDF</b></h4>
                                             </div>
                                          </div>
                                       </div>
                                    </button>

                                    <button type="submit" name="type" value="doc" class="btn btn-info pl-3 w-100">
                                       <div class="row no-gutters">
                                          <div class="col-auto">
                                             <i class="material-icons">description</i>
                                          </div>
                                          <div class="col">
                                             <div class="text-start">
                                                <h4 class="d-inline"><b>Generate DOC</b></h4>
                                             </div>
                                          </div>
                                       </div>
                                    </button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>

                     <!-- ================= ADMIN ================= -->
                     <div class="col-md-6 col-eq">
                        <div class="card modern panel">
                           <div class="card-body clean panel-body">
                              <h5 class="text-success" style="font-size:clamp(16px,2.2vw,20px)"><b>Laporan Absen Admin</b></h5>
                              <p class="subtitle">Total jumlah admin : <b><?= count($admin); ?></b></p>

                              <form action="<?= base_url('admin/laporan/admin'); ?>" method="post" class="mt-3 d-flex flex-column flex-grow-1">
                                 <div class="form-row">
                                    <p class="label">Bulan</p>
                                    <input type="month" name="tanggalAdmin" id="tanggalAdmin"
                                       value="<?= date('Y-m'); ?>" class="input" aria-label="Bulan laporan admin">
                                 </div>

                                 <!-- Tombol full width, responsif -->
                                 <div class="mt-auto">
                                    <button type="submit" name="type" value="pdf" class="btn btn-danger pl-3 w-100 mb-2">
                                       <div class="row no-gutters">
                                          <div class="col-auto">
                                             <i class="material-icons">print</i>
                                          </div>
                                          <div class="col">
                                             <div class="text-start">
                                                <h4 class="d-inline"><b>Generate PDF</b></h4>
                                             </div>
                                          </div>
                                       </div>
                                    </button>

                                    <button type="submit" name="type" value="doc" class="btn btn-info pl-3 w-100">
                                       <div class="row no-gutters">
                                          <div class="col-auto">
                                             <i class="material-icons">description</i>
                                          </div>
                                          <div class="col">
                                             <div class="text-start">
                                                <h4 class="d-inline"><b>Generate DOC</b></h4>
                                             </div>
                                          </div>
                                       </div>
                                    </button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                     <!-- /ADMIN -->

                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>

<script>
   /* ========== THEME INIT + TOGGLE ========== */
   (function initTheme() {
      try {
         const saved = localStorage.getItem('theme'); // 'dark' | 'light'
         const prefersLight = window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches;
         const theme = saved || (prefersLight ? 'light' : 'dark');
         document.documentElement.setAttribute('data-theme', theme);
         updateThemeUI(theme);
      } catch (e) {}
   })();

   function updateThemeUI(theme) {
      const label = document.getElementById('themeLabel');
      const icon = document.querySelector('#themeToggle .material-icons');
      if (!label || !icon) return;
      if (theme === 'light') {
         label.textContent = 'Terang';
         icon.textContent = 'light_mode';
      } else {
         label.textContent = 'Gelap';
         icon.textContent = 'dark_mode';
      }
   }

   document.getElementById('themeToggle')?.addEventListener('click', function() {
      const current = document.documentElement.getAttribute('data-theme') || 'dark';
      const next = current === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', next);
      try {
         localStorage.setItem('theme', next);
      } catch (e) {}
      updateThemeUI(next);
   });
</script>

<?= $this->endSection() ?>