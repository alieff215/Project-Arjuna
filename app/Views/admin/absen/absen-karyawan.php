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

      /* Accents */
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
      font-size: clamp(18px, 2vw, 20px);
      line-height: 1.25;
   }

   .u-sub {
      margin: 0;
      color: var(--muted);
      font-weight: 600;
      font-size: clamp(12.5px, 1.6vw, 13px);
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
      gap: 12px;
      font-size: clamp(12px, 1.6vw, 13px);
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
      font-size: clamp(14px, 2.5vw, 16px);
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

   /* =============== DEPARTEMEN GRID =============== */
   .chip-btn {
      width: 100%;
      margin-bottom: 10px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      border-radius: 12px;
      border: 1px solid var(--border);
      padding: 12px 14px;
      font-weight: 700;
      color: var(--text);
      background: color-mix(in oklab, var(--card-solid) 92%, transparent);
      transition: transform .12s ease, box-shadow .12s ease, background .12s ease;
      box-shadow: var(--neon);
      min-height: 44px;
      /* touch target */
      font-size: clamp(14px, 2.6vw, 16px);
   }

   .chip-btn:hover {
      transform: translateY(-1px);
   }

   .chip-btn.active {
      border-color: color-mix(in oklab, var(--primary) 40%, var(--border));
      box-shadow: 0 0 0 1px color-mix(in oklab, var(--primary) 35%, transparent), 0 10px 24px rgba(59, 130, 246, .18);
      background: color-mix(in oklab, var(--primary) 8%, var(--card-solid));
   }

   /* =============== DATA AREA / TABLE-FRIENDLY =============== */
   #dataKaryawan {
      min-height: 140px;
      overflow-x: auto;
      /* << responsif untuk tabel lebar */
      -webkit-overflow-scrolling: touch;
   }

   #dataKaryawan table {
      /* jaga tabel agar tak pecah layout */
      min-width: 760px;
      /* bisa disesuaikan */
      width: 100%;
   }

   /* Kolom aksi rapi dan responsif */
   #dataKaryawan table th:last-child {
      min-width: 132px;
      white-space: nowrap;
   }

   #dataKaryawan table td:last-child {
      display: inline-flex;
      gap: 8px;
      align-items: center;
      white-space: nowrap;
   }

   #dataKaryawan table td:last-child .btn,
   #dataKaryawan table td:last-child a.btn,
   #dataKaryawan table td:last-child button.btn {
      width: 40px;
      height: 40px;
      padding: 0 !important;
      border-radius: 10px;
      display: grid;
      place-items: center;
      line-height: 1;
   }

   #dataKaryawan table td:last-child .material-icons {
      font-size: 20px;
      line-height: 1;
      color: #fff;
   }

   .placeholder {
      border: 1px dashed var(--border);
      border-radius: 12px;
      padding: 18px;
      color: var(--muted);
      background: linear-gradient(180deg, color-mix(in oklab, var(--card-solid) 90%, transparent), transparent);
      text-align: center;
   }

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
      max-width: min(92vw, 420px);
   }

   .toast-lite i {
      vertical-align: middle;
      margin-right: 6px;
   }

   /* ======= RESPONSIVE TWEAKS ======= */
   @media (max-width: 991.98px) {
      .u-head {
         flex-wrap: wrap;
      }
   }

   @media (max-width: 767.98px) {
      .u-head {
         flex-direction: column;
         align-items: stretch;
         gap: 8px;
      }

      .input-chip {
         width: 100%;
      }

      .u-foot {
         flex-direction: column;
         align-items: flex-start;
      }
   }

   @media (max-width: 575.98px) {
      .chip-btn {
         padding: 10px 12px;
         border-radius: 10px;
      }

      #dataKaryawan table th:last-child {
         min-width: 112px;
      }

      #dataKaryawan table td:last-child {
         gap: 6px;
      }

      #dataKaryawan table td:last-child .btn,
      #dataKaryawan table td:last-child a.btn,
      #dataKaryawan table td:last-child button.btn {
         width: 36px;
         height: 36px;
         border-radius: 8px;
      }

      #dataKaryawan table td,
      #dataKaryawan table th {
         padding: .6rem .5rem !important;
      }
   }

   /* Motion-reduce: kurangi animasi */
   @media (prefers-reduced-motion: reduce) {
      .skeleton::after {
         animation: none;
      }

      .btn-soft,
      .chip-btn {
         transition: none;
      }
   }
</style>

<div class="content" id="pageAbsensiKaryawan">
   <!-- THEME TOGGLE -->
   <div class="theme-toggle">
      <button class="theme-btn" type="button" id="themeBtn" aria-label="Toggle theme">
         <i class="material-icons" id="themeIcon">dark_mode</i>
         <span id="themeText">Dark Mode</span>
      </button>
   </div>

   <div class="container-fluid">
      <!-- ====== FILTER & DEPARTEMEN ====== -->
      <div class="u-card mb-3">
         <div class="u-head">
            <div>
               <h5 class="u-title"><i class="material-icons" style="color:var(--primary)">tune</i> Filter Absensi</h5>
               <p class="u-sub">Pilih tanggal &amp; departemen untuk menampilkan daftar kehadiran karyawan</p>
            </div>
            <div class="input-chip">
               <i class="material-icons" style="color:var(--primary)">event</i>
               <input class="form-control" type="date" name="tanggal" id="tanggal" value="<?= date('Y-m-d'); ?>">
            </div>
         </div>

         <div class="u-body">
            <div class="row">
               <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                  <button id="departemen-all"
                     class="chip-btn"
                     type="button"
                     onclick="selectDepartemen('all', 'Semua Departemen')">
                     <i class="material-icons" aria-hidden="true">apartment</i>
                     <span>Semua Departemen</span>
                  </button>
               </div>
               <?php foreach ($listDepartemen as $value): ?>
                  <?php
                  $idDepartemen   = $value['id_departemen'];
                  $namaDepartemen = $value['departemen'] . ' ' . $value['jabatan'];
                  ?>
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                     <button id="departemen-<?= $idDepartemen; ?>"
                        class="chip-btn"
                        type="button"
                        onclick="selectDepartemen(<?= $idDepartemen; ?>, '<?= $namaDepartemen; ?>')">
                        <i class="material-icons" aria-hidden="true">apartment</i>
                        <span><?= $namaDepartemen; ?></span>
                     </button>
                  </div>
               <?php endforeach; ?>
            </div>
         </div>

         <div class="u-foot">
            <small>Tips: ubah tanggal atau klik <b>Refresh</b> untuk memuat ulang data.</small>
            <button id="btnRefresh" class="btn-soft btn-refresh" type="button">
               <i class="material-icons">refresh</i> Refresh
            </button>
         </div>
      </div>

      <!-- ====== DATA ABSEN KARYAWAN ====== -->
      <div class="u-card">
         <div class="u-head">
            <div>
               <h4 class="u-title"><i class="material-icons" style="color:var(--success)">assignment_turned_in</i> Absen Karyawan</h4>
               <p class="u-sub">Daftar karyawan &amp; status kehadiran</p>
            </div>
         </div>

         <div class="u-body">
            <div id="dataKaryawan" class="placeholder">
               Silakan pilih departemen terlebih dahulu, lalu pilih tanggal atau tekan <b>Refresh</b>.
            </div>
         </div>

         <div class="u-foot">
            <span style="display:inline-flex;align-items:center;gap:6px;">
               <i class="material-icons" style="color:var(--primary)">info</i>
               Data diperbarui berdasarkan tanggal &amp; departemen yang dipilih.
            </span>
            <span class="badge-soft">Realtime AJAX</span>
         </div>
      </div>

      <!-- ====== HISTORY UPDATE ====== -->
      <div class="u-card" style="margin-top:12px;">
         <div class="u-head">
            <div>
               <h5 class="u-title"><i class="material-icons" style="color:var(--warning)">history</i> History Update</h5>
               <p class="u-sub">Perubahan kehadiran karyawan pada tanggal yang dipilih</p>
            </div>
         </div>
         <div class="u-body" id="historyKaryawan">
            <div class="placeholder">Belum ada history ditampilkan. Pilih tanggal atau klik Refresh.</div>
         </div>
      </div>
   </div>

   <!-- ====== MODAL: Ubah Kehadiran ====== -->
   <div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="modalUbahKehadiran" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content u-card" style="border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid var(--border);">
               <h5 class="modal-title" id="modalUbahKehadiran">Ubah Kehadiran</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" style="color:var(--text)">&times;</span>
               </button>
            </div>
            <div id="modalFormUbahKaryawan" class="u-body" style="padding-top:12px;"></div>
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
      if (saved) root.setAttribute('data-theme', saved);

      const btn = document.getElementById('themeBtn');
      const icon = document.getElementById('themeIcon');
      const text = document.getElementById('themeText');

      function sync() {
         const mode = root.getAttribute('data-theme') || 'light';
         if (mode === 'dark') {
            icon.textContent = 'light_mode';
            text.textContent = 'Terang';
         } else {
            icon.textContent = 'dark_mode';
            text.textContent = 'Gelap';
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

   /* ================== SKELETON LOADING ================== */
   function setLoading(isLoading) {
      const $btn = $('#btnRefresh');
      if (isLoading) {
         $btn.prop('disabled', true);
         $('#dataKaryawan').html(`
           <div class="skeleton"></div>
           <div class="skeleton" style="height:64px"></div>
           <div class="skeleton" style="height:64px"></div>
         `);
      } else {
         $btn.prop('disabled', false);
      }
   }

   /* ================== STATE ================== */
   var lastIdDepartemen = null;
   var lastDepartemen = null;

   function selectDepartemen(id, nama) {
      lastIdDepartemen = id;
      lastDepartemen = nama;
      updateBtnActive(id);
      fetchKaryawan();
   }

   function updateBtnActive(activeId) {
      <?php foreach ($listDepartemen as $value): ?>
         $('#departemen-<?= $value['id_departemen']; ?>')
            .toggleClass('active', <?= $value['id_departemen']; ?> === activeId);
      <?php endforeach; ?>
   }

   /* ================== AJAX LOAD ================== */
   function fetchKaryawan() {
      const tanggal = $('#tanggal').val();
      if (!lastIdDepartemen || !lastDepartemen) {
         $('#dataKaryawan').html('<div class="placeholder">Silakan pilih departemen terlebih dahulu.</div>');
         return;
      }
      setLoading(true);
      $.ajax({
         url: "<?= base_url('/admin/absen-karyawan'); ?>",
         type: 'post',
         data: {
            departemen: lastDepartemen,
            id_departemen: lastIdDepartemen,
            tanggal: tanggal
         },
         success: function(res) {
            $('#dataKaryawan').html(res);
            $('html, body').animate({
               scrollTop: $("#dataKaryawan").offset().top - 80
            }, 280);
            setLoading(false);
         },
         error: function(xhr, status, err) {
            console.log(err);
            $('#dataKaryawan').html(`<div class="placeholder">Gagal memuat data.<br><small class="text-danger">${err}</small></div>`);
            setLoading(false);
            showToast('Gagal memuat data', 'error');
         }
      });

      // muat history untuk tanggal yang sama
      $.ajax({
         url: "<?= base_url('/admin/absen-karyawan/history'); ?>",
         type: 'post',
         data: { tanggal },
         success: function(res) {
            $('#historyKaryawan').html(res);
         },
         error: function() {
            $('#historyKaryawan').html('<div class="placeholder">Gagal memuat history.</div>');
         }
      });
   }

   /* ================== EVENT BINDINGS ================== */
   $('#btnRefresh').on('click', fetchKaryawan);
   $('#tanggal').on('change input', debounce(fetchKaryawan, 250));

   function debounce(fn, delay) {
      let t;
      return function() {
         clearTimeout(t);
         t = setTimeout(() => fn.apply(this, arguments), delay);
      };
   }

   /* ================== MODAL ACTIONS ================== */
   function getDataKehadiran(idPresensi, idKaryawan) {
      $('#modalFormUbahKaryawan').html('<div class="skeleton" style="height:120px"></div>');
      $.ajax({
         url: "<?= base_url('/admin/absen-karyawan/kehadiran'); ?>",
         type: 'post',
         data: {
            id_presensi: idPresensi,
           id_karyawan: idKaryawan,
           tanggal: $('#tanggal').val()
         },
         success: function(res) {
            $('#modalFormUbahKaryawan').html(res);
         },
         error: function() {
            $('#modalFormUbahKaryawan').html('<div class="placeholder">Gagal memuat form.</div>');
         }
      });
   }

   function ubahKehadiran() {
      const tanggal = $('#tanggal').val();
      const form = $('#formUbah').serializeArray();
      form.push({
         name: 'tanggal',
         value: tanggal
      });

      $.ajax({
         url: "<?= base_url('/admin/absen-karyawan/edit'); ?>",
         type: 'post',
         data: form,
         success: function(response) {
            if (response['status']) showToast('Berhasil ubah kehadiran: ' + response['nama_karyawan'], 'check_circle');
            else showToast('Gagal ubah kehadiran: ' + response['nama_karyawan'], 'error');
            fetchKaryawan();
         },
         error: function(xhr, status, err) {
            console.log(err);
            alert('Gagal ubah kehadiran\n' + err);
         }
      });
   }

   // Expose untuk dipakai di partial yang dirender AJAX
   window.getDataKehadiran = getDataKehadiran;
   window.ubahKehadiran = ubahKehadiran;
   window.selectDepartemen = selectDepartemen;
</script>

<?= $this->endSection() ?>