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

   .title-fixed {
      margin: 0;
      font-weight: 800;
      font-size: clamp(18px, 2.2vw, 22px);
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


   .form-row {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: clamp(10px, 2vw, 14px);
      flex-wrap: wrap;
   }

   .label {
      min-width: clamp(78px, 12vw, 100px);
      font-weight: 700;
      color: var(--text);
   }

   .input,
   .select {
      flex: 1 1 220px;
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 10px 12px;
      background: var(--card);
      color: var(--text);
   }

   .btn {
      border-radius: 12px;
      font-weight: 700;
   }

   .choose-card {
      text-align: center;
      padding: 50px 20px;
   }

   .choose-btn {
      display: inline-block;
      padding: 14px 26px;
      border-radius: 12px;
      font-size: 18px;
      font-weight: 700;
      border: none;
      margin: 8px;
      cursor: pointer;
      transition: transform .1s ease, box-shadow .2s ease;
   }

   .choose-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
   }

   .btn-karyawan {
      background: #2563eb;
      color: #fff;
   }

   .btn-admin {
      background: #16a34a;
      color: #fff;
   }

   .hidden {
      display: none;
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
                     <p class="subtitle">Pilih jenis laporan terlebih dahulu</p>
                  </div>

               </div>

               <div class="card-body clean">
                  <!-- Pilihan awal -->
                  <div id="chooseSection" class="choose-card">
                     <p class="subtitle mb-3">Silakan pilih laporan yang ingin Anda generate:</p>
                     <button class="choose-btn btn-karyawan" onclick="showCard('karyawan')">
                        <i class="material-icons align-middle">badge</i> Laporan Karyawan
                     </button>
                     <button class="choose-btn btn-admin" onclick="showCard('admin')">
                        <i class="material-icons align-middle">supervisor_account</i> Laporan Admin
                     </button>
                  </div>

                  <!-- Card Karyawan -->
                  <div id="karyawanCard" class="hidden mt-3">
                     <div class="card modern panel">
                        <div class="card-body clean panel-body">
                           <h5 class="text-primary"><b>Laporan Absen Karyawan</b></h5>
                           <p class="subtitle">Pilih bulan & (opsional) departemen.</p>

                           <form action="<?= base_url('admin/laporan/karyawan'); ?>" method="post" class="mt-3">
                              <div class="form-row">
                                 <p class="label">Bulan</p>
                                 <input type="month" name="tanggalKaryawan" id="tanggalKaryawan"
                                    value="<?= date('Y-m'); ?>" class="input">
                              </div>

                              <div class="form-row">
                                 <p class="label">Departemen</p>
                                 <select name="departemen" class="select">
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

                              <!-- GANTI bagian bawah ini -->
                              <div class="form-row justify-content-end">
                                 <p class="label">Format</p>
                                 <div class="d-flex align-items-center gap-2" style="flex:1;">
                                    <select name="type" class="select w-auto" required>
                                       <option value="pdf">PDF</option>
                                       <option value="doc">DOC</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">
                                       <i class="material-icons" style="font-size:16px;">description</i> Generate
                                    </button>
                                 </div>
                              </div>
                           </form>

                        </div>
                     </div>
                  </div>

                  <!-- Card Admin -->
                  <div id="adminCard" class="hidden mt-3">
                     <div class="card modern panel">
                        <div class="card-body clean panel-body">
                           <h5 class="text-success"><b>Laporan Absen Admin</b></h5>
                           <p class="subtitle">Total jumlah admin : <b><?= count($admin); ?></b></p>

                           <form action="<?= base_url('admin/laporan/admin'); ?>" method="post" class="mt-3">
                              <div class="form-row">
                                 <p class="label">Bulan</p>
                                 <input type="month" name="tanggalAdmin" id="tanggalAdmin"
                                    value="<?= date('Y-m'); ?>" class="input">
                              </div>

                              <!-- GANTI bagian bawah ini -->
                              <div class="form-row justify-content-end">
                                 <p class="label">Format</p>
                                 <div class="d-flex align-items-center gap-2" style="flex:1;">
                                    <select name="type" class="select w-auto" required>
                                       <option value="pdf">PDF</option>
                                       <option value="doc">DOC</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">
                                       <i class="material-icons" style="font-size:16px;">description</i> Generate
                                    </button>
                                 </div>
                              </div>
                           </form>

                        </div>
                     </div>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>

<script>
   // ========== THEME INIT + TOGGLE ==========
   (function initTheme() {
      try {
         const saved = localStorage.getItem('ui-theme');
         const prefersLight = window.matchMedia('(prefers-color-scheme: light)').matches;
         const theme = saved || (prefersLight ? 'light' : 'dark');
         document.documentElement.setAttribute('data-theme', theme);
      } catch (e) {}
   })();


   // ========== SHOW/HIDE CARD ==========
   function showCard(type) {
      document.getElementById('chooseSection').classList.add('hidden');
      if (type === 'karyawan') {
         document.getElementById('karyawanCard').classList.remove('hidden');
      } else if (type === 'admin') {
         document.getElementById('adminCard').classList.remove('hidden');
      }
   }
</script>

<?= $this->endSection() ?>