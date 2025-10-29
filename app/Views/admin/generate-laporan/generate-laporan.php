<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
   /* ==============================
     MODERN DESIGN TOKENS
  ===============================*/
   :root {
      --bg: #fafbfc;
      --card: #ffffff;
      --text: #1a202c;
      --text-muted: #718096;
      --primary: #667eea;
      --primary-light: #e6f3ff;
      --success: #48bb78;
      --success-light: #f0fff4;
      --border: #e2e8f0;
      --radius: 12px;
      --radius-lg: 16px;
      --shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.06);
      --shadow-lg: 0 10px 25px 0 rgba(0, 0, 0, 0.1);
      --shadow-xl: 0 20px 40px 0 rgba(0, 0, 0, 0.15);
      --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --gradient-success: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
   }

   html[data-theme="dark"] {
      --bg: #1a202c;
      --card: #2d3748;
      --text: #f7fafc;
      --text-muted: #a0aec0;
      --primary: #667eea;
      --primary-light: #2d3748;
      --success: #48bb78;
      --success-light: #2d3748;
      --border: #4a5568;
   }

   /* ==============================
     BASE LAYOUT
  ===============================*/
   .content {
      background: var(--bg);
      min-height: 100vh;
      padding: 32px 0 48px !important;
      position: relative;
   }

   .content::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 200px;
      background: var(--gradient);
      opacity: 0.05;
      z-index: 0;
   }

   .container-fluid {
      padding: 0 32px !important;
      position: relative;
      z-index: 1;
      max-width: 1200px;
      margin: 0 auto;
   }

   .shell {
      background: var(--card);
      border: none;
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-xl);
      overflow: hidden;
      position: relative;
   }

   .shell::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--gradient);
   }

   .shell-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      padding: 24px 32px;
      background: linear-gradient(180deg, color-mix(in oklab, var(--primary) 8%, transparent), transparent);
      border-bottom: 1px solid var(--border);
   }

   .shell-title {
      margin: 0;
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 800;
      font-size: 24px;
      color: var(--text);
      letter-spacing: -0.02em;
   }

   .shell-title i {
      color: var(--primary);
   }

   .shell-sub {
      margin: 4px 0 0;
      color: var(--text-muted);
      font-weight: 500;
      font-size: 14px;
   }

   .shell-body {
      padding: 32px;
   }


   /* ==============================
     DROPDOWN SELECTOR
  ===============================*/
   .choice-section {
      text-align: center;
      padding: 40px 20px;
      opacity: 1;
      transform: translateY(0);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
   }

   .choice-title {
      margin: 0 0 24px 0;
      font-size: 18px;
      font-weight: 600;
      color: var(--text-muted);
   }

   .dropdown-container {
      max-width: 400px;
      margin: 0 auto;
      position: relative;
   }

   .dropdown-select {
      width: 100%;
      padding: 16px 20px;
      border: 2px solid var(--border);
      border-radius: var(--radius-lg);
      background: var(--card);
      color: var(--text);
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 16px center;
      background-size: 20px;
      padding-right: 50px;
   }

   .dropdown-select:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
      transform: translateY(-2px);
   }

   .dropdown-select:hover {
      border-color: var(--primary);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
   }

   .dropdown-option {
      padding: 12px 20px;
      font-weight: 500;
   }

   .dropdown-option[value="karyawan"] {
      color: var(--primary);
   }

   .dropdown-option[value="admin"] {
      color: var(--success);
   }

   /* ==============================
     FORM PANELS
  ===============================*/
   .form-panel {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-lg);
      overflow: hidden;
      margin-top: 24px;
      position: relative;
      opacity: 1;
      transform: translateY(0);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
   }

   .form-panel::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--gradient);
   }

   .form-panel-admin::before {
      background: var(--gradient-success);
   }

   .form-panel-header {
      padding: 20px 24px;
      background: linear-gradient(180deg, color-mix(in oklab, var(--primary) 8%, transparent), transparent);
      border-bottom: 1px solid var(--border);
   }

   .form-panel-admin .form-panel-header {
      background: linear-gradient(180deg, color-mix(in oklab, var(--success) 8%, transparent), transparent);
   }

   .form-panel-title {
      margin: 0;
      font-size: 18px;
      font-weight: 700;
      color: var(--text);
      display: flex;
      align-items: center;
      gap: 8px;
   }

   .form-panel-title i {
      color: var(--primary);
   }

   .form-panel-admin .form-panel-title i {
      color: var(--success);
   }

   .form-panel-subtitle {
      margin: 4px 0 0;
      font-size: 14px;
      color: var(--text-muted);
   }

   .form-panel-body {
      padding: 24px;
   }

   .form-row {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 20px;
      flex-wrap: wrap;
   }

   .form-label {
      min-width: 120px;
      font-weight: 600;
      color: var(--text);
      font-size: 14px;
   }

   .form-input,
   .form-select {
      flex: 1;
      min-width: 200px;
      border: 2px solid var(--border);
      border-radius: var(--radius);
      padding: 12px 16px;
      background: var(--card);
      color: var(--text);
      font-size: 14px;
      transition: all 0.2s ease;
   }

   .form-input:focus,
   .form-select:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
   }

   .form-actions {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-top: 24px;
      padding-top: 20px;
      border-top: 1px solid var(--border);
   }

   .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 12px 24px;
      border: none;
      border-radius: var(--radius);
      font-weight: 600;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
   }

   .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
   }

   .btn-primary {
      background: var(--gradient);
      color: white;
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
   }

   .btn-primary:hover {
      box-shadow: 0 6px 16px rgba(102, 126, 234, 0.35);
   }

   .btn-outline-secondary {
      background: transparent;
      color: var(--text-muted);
      border: 2px solid var(--border);
      box-shadow: none;
   }

   .btn-outline-secondary:hover {
      background: var(--text-muted);
      color: var(--card);
      border-color: var(--text-muted);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
   }

   .hidden {
      display: none !important;
   }

   /* ==============================
     FALLBACK STYLES
  ===============================*/
   #chooseSection {
      display: block !important;
   }

   #chooseSection.hidden {
      display: none !important;
   }

   #karyawanCard.hidden,
   #adminCard.hidden {
      display: none !important;
   }

   /* ==============================
     RESPONSIVE DESIGN
  ===============================*/
   @media (max-width: 768px) {
      .container-fluid {
         padding: 0 20px !important;
      }

      .shell-header {
         flex-direction: column;
         align-items: flex-start;
         gap: 16px;
         padding: 20px 24px;
      }

      .shell-body {
         padding: 24px;
      }

      .choice-section {
         padding: 30px 16px;
      }

      .dropdown-container {
         max-width: 100%;
      }

      .form-panel-header {
         flex-direction: column;
         align-items: flex-start;
         gap: 12px;
      }

      .form-row {
         flex-direction: column;
         align-items: flex-start;
         gap: 8px;
      }

      .form-label {
         min-width: auto;
      }

      .form-input,
      .form-select {
         min-width: 100%;
      }

      .form-actions {
         flex-direction: column;
         align-items: stretch;
      }

      .btn {
         justify-content: center;
      }
   }

   @media (max-width: 480px) {
      .shell-header {
         padding: 16px 20px;
      }

      .shell-body {
         padding: 20px;
      }

      .choice-section {
         padding: 30px 12px;
      }

      .dropdown-select {
         font-size: 14px;
         padding: 14px 16px;
      }

      .form-panel-body {
         padding: 20px;
      }
   }
</style>

<div class="content">
   <div class="container-fluid">
      <?php if (session()->getFlashdata('msg')) : ?>
         <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success' ?> mb-4">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <i class="material-icons">close</i>
            </button>
            <?= session()->getFlashdata('msg') ?>
         </div>
      <?php endif; ?>

      <div class="shell">
         <div class="shell-header">
            <div>
               <h1 class="shell-title">
                  <i class="material-icons">assessment</i>
                  Generate Laporan
               </h1>
               <p class="shell-sub">Pilih jenis laporan yang ingin Anda generate</p>
            </div>
         </div>

         <div class="shell-body">
            <!-- Pilihan awal -->
            <div id="chooseSection" class="choice-section">
               <p class="choice-title">Silakan pilih jenis laporan yang ingin Anda generate:</p>
               <div class="dropdown-container">
                  <select id="reportType" class="dropdown-select" onchange="showCard(this.value)">
                     <option value="" class="dropdown-option">Pilih Jenis Laporan</option>
                     <option value="karyawan" class="dropdown-option">📊 Laporan Karyawan</option>
                     <option value="admin" class="dropdown-option">👥 Laporan Admin (<?= count($admin); ?> admin)</option>
                  </select>
               </div>
            </div>

            <!-- Card Karyawan -->
            <div id="karyawanCard" class="hidden">
               <div class="form-panel">
                  <div class="form-panel-header">
                     <div>
                        <h3 class="form-panel-title">
                           <i class="material-icons">badge</i>
                           Laporan Absen Karyawan
                        </h3>
                        <p class="form-panel-subtitle">Pilih bulan dan departemen untuk generate laporan</p>
                     </div>
                     <button type="button" class="btn btn-outline-secondary" onclick="backToChoice()" style="padding: 8px 16px; font-size: 14px;">
                        <i class="material-icons" style="font-size: 18px;">arrow_back</i>
                        Kembali
                     </button>
                  </div>

                  <div class="form-panel-body">
                     <form action="<?= base_url('admin/laporan/karyawan'); ?>" method="post">
                        <div class="form-row">
                           <label class="form-label">Bulan</label>
                           <input type="month" name="tanggalKaryawan" id="tanggalKaryawan"
                              value="<?= date('Y-m'); ?>" class="form-input" required>
                        </div>

                        <div class="form-row">
                           <label class="form-label">Departemen</label>
                           <select name="departemen" class="form-select">
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

                        <div class="form-actions">
                           <label class="form-label">Format</label>
                           <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                              <select name="type" class="form-select" style="flex: 0 0 120px;" required>
                                 <option value="pdf">PDF</option>
                                 <option value="doc">DOC</option>
                              </select>
                              <button type="submit" class="btn btn-primary">
                                 <i class="material-icons">description</i>
                                 Generate Laporan
                              </button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>

            <!-- Card Admin -->
            <div id="adminCard" class="hidden">
               <div class="form-panel form-panel-admin">
                  <div class="form-panel-header">
                     <div>
                        <h3 class="form-panel-title">
                           <i class="material-icons">supervisor_account</i>
                           Laporan Absen Admin
                        </h3>
                        <p class="form-panel-subtitle">Total jumlah admin: <strong><?= count($admin); ?></strong></p>
                     </div>
                     <button type="button" class="btn btn-outline-secondary" onclick="backToChoice()" style="padding: 8px 16px; font-size: 14px;">
                        <i class="material-icons" style="font-size: 18px;">arrow_back</i>
                        Kembali
                     </button>
                  </div>

                  <div class="form-panel-body">
                     <form action="<?= base_url('admin/laporan/admin'); ?>" method="post">
                        <div class="form-row">
                           <label class="form-label">Bulan</label>
                           <input type="month" name="tanggalAdmin" id="tanggalAdmin"
                              value="<?= date('Y-m'); ?>" class="form-input" required>
                        </div>

                        <div class="form-actions">
                           <label class="form-label">Format</label>
                           <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                              <select name="type" class="form-select" style="flex: 0 0 120px;" required>
                                 <option value="pdf">PDF</option>
                                 <option value="doc">DOC</option>
                              </select>
                              <button type="submit" class="btn btn-primary">
                                 <i class="material-icons">description</i>
                                 Generate Laporan
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

   // ========== DROPDOWN CARD TRANSITIONS ==========
   function showCard(type) {
      const chooseSection = document.getElementById('chooseSection');
      const karyawanCard = document.getElementById('karyawanCard');
      const adminCard = document.getElementById('adminCard');
      const reportTypeSelect = document.getElementById('reportType');

      // If no type selected, show choice section
      if (!type || type === '') {
         // Hide all cards first
         karyawanCard.classList.add('hidden');
         adminCard.classList.add('hidden');

         // Reset styles
         karyawanCard.style.opacity = '';
         karyawanCard.style.transform = '';
         karyawanCard.style.transition = '';
         adminCard.style.opacity = '';
         adminCard.style.transform = '';
         adminCard.style.transition = '';

         // Show choice section with animation
         chooseSection.classList.remove('hidden');
         chooseSection.style.opacity = '0';
         chooseSection.style.transform = 'translateY(20px)';
         chooseSection.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';

         // Trigger reflow
         chooseSection.offsetHeight;

         // Animate in
         chooseSection.style.opacity = '1';
         chooseSection.style.transform = 'translateY(0)';

         // Reset dropdown
         if (reportTypeSelect) {
            reportTypeSelect.value = '';
         }
         return;
      }

      // Hide choice section with fade out
      chooseSection.style.opacity = '0';
      chooseSection.style.transform = 'translateY(20px)';

      setTimeout(() => {
         chooseSection.classList.add('hidden');

         // Show selected card with fade in
         if (type === 'karyawan') {
            karyawanCard.classList.remove('hidden');
            karyawanCard.style.opacity = '0';
            karyawanCard.style.transform = 'translateY(20px)';

            // Trigger reflow
            karyawanCard.offsetHeight;

            karyawanCard.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            karyawanCard.style.opacity = '1';
            karyawanCard.style.transform = 'translateY(0)';
         } else if (type === 'admin') {
            adminCard.classList.remove('hidden');
            adminCard.style.opacity = '0';
            adminCard.style.transform = 'translateY(20px)';

            // Trigger reflow
            adminCard.offsetHeight;

            adminCard.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            adminCard.style.opacity = '1';
            adminCard.style.transform = 'translateY(0)';
         }
      }, 200);
   }

   // ========== BACK TO CHOICE FUNCTION ==========
   function backToChoice() {
      // Force reset all elements
      const chooseSection = document.getElementById('chooseSection');
      const karyawanCard = document.getElementById('karyawanCard');
      const adminCard = document.getElementById('adminCard');
      const reportTypeSelect = document.getElementById('reportType');

      // Hide all cards immediately
      karyawanCard.classList.add('hidden');
      adminCard.classList.add('hidden');

      // Reset all inline styles
      [karyawanCard, adminCard].forEach(card => {
         card.style.opacity = '';
         card.style.transform = '';
         card.style.transition = '';
      });

      // Show choice section
      chooseSection.classList.remove('hidden');
      chooseSection.style.opacity = '1';
      chooseSection.style.transform = 'translateY(0)';
      chooseSection.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';

      // Reset dropdown
      if (reportTypeSelect) {
         reportTypeSelect.value = '';
      }
   }

   // ========== ENHANCED INTERACTIONS ==========
   document.addEventListener('DOMContentLoaded', function() {
      // Add focus states to form inputs
      const formInputs = document.querySelectorAll('.form-input, .form-select');
      formInputs.forEach(input => {
         input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
         });

         input.addEventListener('blur', function() {
            this.parentElement.style.transform = '';
         });
      });

      // Add smooth transitions to dropdown
      const dropdownSelect = document.getElementById('reportType');
      if (dropdownSelect) {
         dropdownSelect.addEventListener('change', function() {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
               this.style.transform = '';
            }, 150);
         });
      }
   });
</script>

<?= $this->endSection() ?>