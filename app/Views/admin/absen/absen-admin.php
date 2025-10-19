<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
   /* ================= TOKENS & THEMES ================= */
   :root {
      /* Base Light */
      --bg: #eef3fb;
      --bg-accent-1: #e5efff;
      --bg-accent-2: #f0f7ff;

      --card: #ffffffcc;
      /* translucent for glass effect */
      --card-solid: #ffffff;
      --text: #0b132b;
      --muted: #6b7b93;
      --border: rgba(16, 24, 40, .12);
      --ring: #2563eb;

      /* Futuristic accents */
      --primary: #3b82f6;
      /* blue */
      --success: #10b981;
      /* green */
      --warning: #f59e0b;
      --danger: #ef4444;

      /* Glow + radius */
      --radius: 18px;
      --shadow-1: 0 10px 30px rgba(12, 20, 40, .08);
      --shadow-2: 0 18px 60px rgba(12, 20, 40, .12);
      --glass-blur: 8px;

      /* Neon style for borders */
      --neon: 0 0 0 1px color-mix(in oklab, var(--ring) 20%, transparent), 0 10px 30px rgba(37, 99, 235, .08);
   }

   /* Dark */
   [data-theme="dark"] {
      --bg: #070d1a;
      --bg-accent-1: #0a1731;
      --bg-accent-2: #0f213f;

      --card: rgba(12, 18, 36, .55);
      --card-solid: #0f182d;
      --text: #e6ecff;
      --muted: #9fb1cc;
      --border: rgba(200, 210, 230, .14);
      --ring: #7dd3fc;
      /* cyan */
      --primary: #7aa8ff;
      --success: #34d399;
      --warning: #fbbf24;
      --danger: #fb7185;

      --shadow-1: 0 16px 36px rgba(0, 0, 0, .45);
      --shadow-2: 0 25px 70px rgba(0, 0, 0, .55);
      --glass-blur: 12px;

      --neon: 0 0 0 1px color-mix(in oklab, var(--ring) 35%, transparent), 0 10px 40px rgba(0, 186, 255, .12);
   }

   /* =============== BACKGROUND (mesh + subtle grid) =============== */
   .content {
      position: relative;
      min-height: calc(100vh - 64px);
      padding: 18px 0 28px !important;
      background:
         radial-gradient(1100px 420px at 8% -10%, var(--bg-accent-2) 0%, transparent 60%),
         radial-gradient(900px 380px at 98% -5%, var(--bg-accent-1) 0%, transparent 55%),
         linear-gradient(180deg, var(--bg), var(--bg));
   }

   .content::before {
      /* micro grid dots to feel futuristic */
      content: "";
      position: absolute;
      inset: 0;
      background-image: radial-gradient(color-mix(in oklab, var(--border) 40%, transparent) 1px, transparent 1px);
      background-size: 12px 12px;
      opacity: .18;
      pointer-events: none;
   }

   .container-fluid {
      padding: 0 16px !important;
   }

   /* =============== GLASS CARDS =============== */
   .u-card {
      position: relative;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow-1);
      backdrop-filter: blur(var(--glass-blur));
      -webkit-backdrop-filter: blur(var(--glass-blur));
      overflow: hidden;
   }

   .u-card:hover {
      box-shadow: var(--shadow-2);
   }

   .u-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      padding: 14px 18px;
      background:
         linear-gradient(180deg, color-mix(in oklab, var(--primary) 8%, transparent), transparent),
         linear-gradient(180deg, color-mix(in oklab, var(--card-solid) 70%, transparent), transparent);
      border-bottom: 1px solid var(--border);
   }

   .u-title {
      margin: 0;
      color: var(--text);
      font-weight: 800;
      letter-spacing: .2px;
      display: flex;
      gap: 10px;
      align-items: center;
   }

   .u-sub {
      margin: 0;
      color: var(--muted);
      font-weight: 600;
      font-size: 13px;
   }

   .u-body {
      padding: 16px 18px;
   }

   .u-foot {
      padding: 12px 18px;
      border-top: 1px solid var(--border);
      color: var(--muted);
      display: flex;
      justify-content: space-between;
      align-items: center;
   }

   .badge-soft {
      padding: 6px 10px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 12px;
      border: 1px solid var(--border);
      background: color-mix(in oklab, var(--card-solid) 85%, transparent);
      color: var(--muted);
   }

   /* =============== INPUT DATE + TOOLBAR =============== */
   .input-chip {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 12px;
      border-radius: 12px;
      border: 1px solid var(--border);
      background: color-mix(in oklab, var(--card-solid) 85%, transparent);
      box-shadow: var(--neon);
   }

   .input-chip .form-control {
      border: 0;
      outline: 0;
      background: transparent;
      color: var(--text);
      padding: 0;
      height: auto;
      min-width: 170px;
   }

   .input-chip .form-control:focus {
      box-shadow: none;
   }

   .btn-soft {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border-radius: 12px;
      border: 1px solid var(--border);
      padding: 10px 14px;
      font-weight: 700;
      background: color-mix(in oklab, var(--card-solid) 90%, transparent);
      color: var(--text);
      transition: transform .12s ease, box-shadow .12s ease;
      box-shadow: var(--neon);
   }

   .btn-soft:hover {
      transform: translateY(-1px);
   }

   .btn-refresh {
      color: var(--success);
      border-color: color-mix(in oklab, var(--success) 30%, var(--border));
   }

   .btn-refresh[disabled] {
      opacity: .6;
      cursor: not-allowed;
      transform: none;
   }

   /* =============== DATA AREA =============== */
   #dataAdmin {
      min-height: 140px;
   }

   .placeholder {
      border: 1px dashed var(--border);
      border-radius: 12px;
      padding: 18px;
      color: var(--muted);
      background:
         linear-gradient(180deg, color-mix(in oklab, var(--card-solid) 90%, transparent), transparent);
   }

   /* Skeleton shimmer */
   .skeleton {
      position: relative;
      overflow: hidden;
      border-radius: 12px;
      height: 82px;
      margin-bottom: 12px;
      background: linear-gradient(180deg, color-mix(in oklab, var(--card-solid) 88%, transparent), transparent);
   }

   .skeleton::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(90deg, transparent, color-mix(in oklab, var(--ring) 24%, transparent), transparent);
      transform: translateX(-100%);
      animation: shimmer 1.15s infinite;
      opacity: .35;
   }

   @keyframes shimmer {
      100% {
         transform: translateX(100%);
      }
   }

   /* =============== THEME TOGGLE =============== */
   .theme-toggle {
      position: sticky;
      top: 12px;
      z-index: 40;
      display: flex;
      justify-content: flex-end;
      padding: 0 16px 10px;
   }

   .theme-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border-radius: 999px;
      border: 1px solid var(--border);
      background: color-mix(in oklab, var(--card-solid) 80%, transparent);
      color: var(--text);
      padding: 10px 14px;
      cursor: pointer;
      box-shadow: var(--neon);
   }

   .theme-btn .material-icons {
      font-size: 20px;
   }

   /* Toast */
   .toast-lite {
      position: fixed;
      right: 16px;
      bottom: 16px;
      z-index: 1060;
      border-radius: 14px;
      border: 1px solid var(--border);
      background: var(--card);
      box-shadow: var(--shadow-2);
      padding: 12px 14px;
      color: var(--text);
      display: none;
   }

   .toast-lite i {
      vertical-align: middle;
      margin-right: 6px;
   }

   /* Responsive */
   @media (max-width: 767.98px) {
      .u-head {
         flex-direction: column;
         align-items: flex-start;
         gap: 6px;
      }

      .input-chip {
         width: 100%;
      }
   }
</style>

<div class="content" id="pageAbsensiAdmin">
   <!-- THEME TOGGLE -->
   <div class="theme-toggle">
      <button class="theme-btn" type="button" id="themeBtn" aria-label="Toggle theme">
         <i class="material-icons" id="themeIcon">dark_mode</i>
         <span id="themeText">Dark Mode</span>
      </button>
   </div>

   <div class="container-fluid">
      <!-- ====== FILTER TANGGAL ====== -->
      <div class="u-card mb-3">
         <div class="u-head">
            <div>
               <h5 class="u-title"><i class="material-icons" style="color:var(--primary)">tune</i> Filter Absensi</h5>
               <p class="u-sub">Pilih tanggal untuk menampilkan daftar kehadiran admin</p>
            </div>
            <div class="input-chip">
               <i class="material-icons" style="color:var(--primary)">event</i>
               <input class="form-control" type="date" name="tanggal" id="tanggal" value="<?= date('Y-m-d'); ?>">
            </div>
         </div>
         <div class="u-body">
            <small style="color:var(--muted)">Tips: ubah tanggal atau klik <b>Refresh</b> untuk memuat ulang data.</small>
         </div>
      </div>

      <!-- ====== DATA ABSEN ADMIN ====== -->
      <div class="u-card">
         <div class="u-head">
            <div>
               <h4 class="u-title"><i class="material-icons" style="color:var(--success)">assignment_turned_in</i> Absen Admin</h4>
               <p class="u-sub">Daftar admin & status kehadiran</p>
            </div>
            <button id="btnRefresh" class="btn-soft btn-refresh" type="button">
               <i class="material-icons">refresh</i> Refresh
            </button>
         </div>

         <div class="u-body">
            <div id="dataAdmin" class="placeholder">Belum ada data ditampilkan. Silakan pilih tanggal atau tekan <b>Refresh</b>.</div>
         </div>

         <div class="u-foot">
            <span style="display:inline-flex;align-items:center;gap:6px;">
               <i class="material-icons" style="color:var(--primary)">info</i>
               Data diperbarui berdasarkan tanggal yang dipilih.
            </span>
            <span class="badge-soft">Realtime AJAX</span>
         </div>
      </div>

      <!-- ====== HISTORY UPDATE ====== -->
      <div class="u-card" style="margin-top:12px;">
         <div class="u-head">
            <div>
               <h5 class="u-title"><i class="material-icons" style="color:var(--warning)">history</i> History Update</h5>
               <p class="u-sub">Perubahan kehadiran admin pada tanggal yang dipilih</p>
            </div>
         </div>
         <div class="u-body" id="historyAdmin">
            <div class="placeholder">Belum ada history ditampilkan. Pilih tanggal atau klik Refresh.</div>
         </div>
      </div>
   </div>

   <!-- ====== MODAL ====== -->
   <div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="modalUbahKehadiran" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content u-card" style="border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid var(--border);">
               <h5 class="modal-title" id="modalUbahKehadiran">Ubah Kehadiran</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:var(--text)">&times;</span></button>
            </div>
            <div id="modalFormUbahAdmin" class="u-body" style="padding-top:12px;"></div>
         </div>
      </div>
   </div>

   <!-- Toast -->
   <div id="toastLite" class="toast-lite">
      <i class="material-icons" id="toastIcon">info</i><span id="toastText">Info</span>
   </div>
</div>

<script>
   /* ================= THEME TOGGLE (persist) ================= */
   (function() {
      const root = document.documentElement;
      const saved = localStorage.getItem('absen-theme');
      if (saved) {
         root.setAttribute('data-theme', saved);
      }
      const btn = document.getElementById('themeBtn');
      const icon = document.getElementById('themeIcon');
      const text = document.getElementById('themeText');

      function sync() {
         const mode = root.getAttribute('data-theme') || 'light';
         if (mode === 'dark') {
            icon.textContent = 'light_mode';
            text.textContent = 'Light Mode';
         } else {
            icon.textContent = 'dark_mode';
            text.textContent = 'Dark Mode';
         }
      }
      sync();

      btn.addEventListener('click', () => {
         const current = root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
         const next = current === 'dark' ? 'light' : 'dark';
         root.setAttribute('data-theme', next);
         localStorage.setItem('absen-theme', next);
         sync();
      });
   })();

   /* ================== TOAST MINI ================== */
   function showToast(text, icon = 'info') {
      const t = $('#toastLite');
      $('#toastText').text(text);
      $('#toastIcon').text(icon);
      t.stop(true, true).fadeIn(120).delay(1600).fadeOut(200);
   }

   /* ================== LOADING SKELETON ================== */
   function setLoading(isLoading) {
      const $btn = $('#btnRefresh');
      if (isLoading) {
         $btn.prop('disabled', true);
         $('#dataAdmin').html(`
        <div class="skeleton"></div>
        <div class="skeleton" style="height:64px"></div>
        <div class="skeleton" style="height:64px"></div>
      `);
      } else {
         $btn.prop('disabled', false);
      }
   }

   /* ================== DEBOUNCE ================== */
   function debounce(fn, delay) {
      let t;
      return function() {
         clearTimeout(t);
         t = setTimeout(() => fn.apply(this, arguments), delay);
      };
   }

   /* ================== AJAX: GET DATA ================== */
   function getAdmin() {
      const tanggal = $('#tanggal').val();
      setLoading(true);
      $.ajax({
         url: "<?= base_url('/admin/absen-admin'); ?>",
         type: 'post',
         data: {
            tanggal
         },
         success: function(res) {
            $('#dataAdmin').html(res);
            $('html, body').animate({
               scrollTop: $("#dataAdmin").offset().top - 80
            }, 280);
            setLoading(false);
         },
         error: function(xhr, status, err) {
            console.log(err);
            $('#dataAdmin').html(`<div class="placeholder">Gagal memuat data.<br><small class="text-danger">${err}</small></div>`);
            setLoading(false);
            showToast('Gagal memuat data', 'error');
         }
      });

      // muat history untuk tanggal yang sama
      $.ajax({
         url: "<?= base_url('/admin/absen-admin/history'); ?>",
         type: 'post',
         data: { tanggal },
         success: function(res) {
            $('#historyAdmin').html(res);
         },
         error: function() {
            $('#historyAdmin').html('<div class="placeholder">Gagal memuat history.</div>');
         }
      });
   }

   /* ================== AJAX: UBAH KEHADIRAN ================== */
   function ubahKehadiran() {
      const tanggal = $('#tanggal').val();
      const form = $('#formUbah').serializeArray();
      form.push({
         name: 'tanggal',
         value: tanggal
      });

      $.ajax({
         url: "<?= base_url('/admin/absen-admin/edit'); ?>",
         type: 'post',
         data: form,
         success: function(response) {
            if (response['status']) showToast('Berhasil ubah kehadiran: ' + response['nama_admin'], 'check_circle');
            else showToast('Gagal ubah kehadiran: ' + response['nama_admin'], 'error');
            getAdmin();
         },
         error: function(xhr, status, err) {
            console.log(err);
            alert('Gagal ubah kehadiran\n' + err);
         }
      });
   }

   /* ================== AJAX: FORM MODAL ================== */
   function getDataKehadiran(idPresensi, idAdmin) {
      $('#modalFormUbahAdmin').html('<div class="skeleton" style="height:120px"></div>');
      $.ajax({
         url: "<?= base_url('/admin/absen-admin/kehadiran'); ?>",
         type: 'post',
         data: {
            id_presensi: idPresensi,
            id_admin: idAdmin,
            tanggal: $('#tanggal').val()
         },
         success: function(res) {
            $('#modalFormUbahAdmin').html(res);
         },
         error: function(xhr, status, err) {
            console.log(err);
            $('#modalFormUbahAdmin').html('<div class="placeholder">Gagal memuat form.</div>');
         }
      });
   }

   /* ================== INIT ================== */
   // Load awal
   getAdmin();
   // Refresh button
   $('#btnRefresh').on('click', getAdmin);
   // Date change (debounced)
   $('#tanggal').on('change input', debounce(getAdmin, 250));

   // Expose ke global (dipakai di partial yang kamu render)
   window.ubahKehadiran = ubahKehadiran;
   window.getDataKehadiran = getDataKehadiran;
</script>

<?= $this->endSection() ?>