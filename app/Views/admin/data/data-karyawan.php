<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
   /* ================= TOKENS & THEMES ================= */
   :root {
      --bg: #eef3fb;
      --bg-accent-1: #e5efff;
      --bg-accent-2: #f0f7ff;
      --card: #ffffffcc;
      --card-solid: #ffffff;
      --text: #0b132b;
      --muted: #6b7b93;
      --border: rgba(16, 24, 40, .12);
      --ring: #2563eb;
      --primary: #3b82f6;
      --success: #10b981;
      --danger: #ef4444;
      --radius: 18px;
      --shadow-1: 0 10px 30px rgba(12, 20, 40, .08);
      --shadow-2: 0 18px 60px rgba(12, 20, 40, .12);
      --glass-blur: 8px;
      --neon: 0 0 0 1px color-mix(in oklab, var(--ring) 22%, transparent), 0 10px 30px rgba(37, 99, 235, .08);
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
      --primary: #7aa8ff;
      --success: #34d399;
      --danger: #fb7185;
      --shadow-1: 0 16px 36px rgba(0, 0, 0, .45);
      --shadow-2: 0 25px 70px rgba(0, 0, 0, .55);
      --glass-blur: 12px;
      --neon: 0 0 0 1px color-mix(in oklab, var(--ring) 35%, transparent), 0 10px 40px rgba(0, 186, 255, .12);
   }

   /* =============== BACKGROUND =============== */
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

   /* =============== GLASS CARD =============== */
   .u-card {
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

   .btn-hero {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border-radius: 12px;
      border: 1px solid var(--border);
      padding: 10px 14px;
      font-weight: 700;
      color: var(--text);
      background: color-mix(in oklab, var(--card-solid) 88%, transparent);
      box-shadow: var(--neon);
      transition: transform .12s ease, box-shadow .12s ease;
   }

   .btn-hero:hover {
      transform: translateY(-1px);
   }

   .btn-hero .material-icons {
      font-size: 20px;
   }

   /* =============== FILTER PILLS =============== */
   .pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: 1px solid var(--border);
      background: color-mix(in oklab, var(--card-solid) 92%, transparent);
      color: var(--text);
      padding: 10px 12px;
      border-radius: 999px;
      font-weight: 700;
      margin: 6px 8px 6px 0;
      cursor: pointer;
      box-shadow: var(--neon);
      transition: transform .12s ease, background .12s ease, box-shadow .12s ease;
      font-size: clamp(13px, 2.2vw, 14px);
   }

   .pill:hover {
      transform: translateY(-1px);
   }

   .pill.active {
      border-color: color-mix(in oklab, var(--primary) 40%, var(--border));
      box-shadow: 0 0 0 1px color-mix(in oklab, var(--primary) 35%, transparent), 0 10px 24px rgba(59, 130, 246, .18);
      background: color-mix(in oklab, var(--primary) 8%, var(--card-solid));
   }

   /* =============== INPUT CHIP (INFO) =============== */
   .input-chip {
      display: flex;
      align-items: center;
      gap: 8px;
      border: 1px solid var(--border);
      border-radius: 12px;
      background: color-mix(in oklab, var(--card-solid) 85%, transparent);
      padding: 10px 12px;
      box-shadow: var(--neon);
      max-width: 100%;
   }

   .input-chip .form-control {
      border: 0;
      background: transparent;
      color: var(--text);
      padding: 0;
      height: auto;
      min-width: 170px;
   }

   .input-chip .form-control:focus {
      box-shadow: none;
   }

   /* =============== ACTIONS ROW =============== */
   .actions-bar {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      padding: 0 4px 10px;
   }

   .btn-rounded {
      border-radius: 12px !important;
      font-weight: 700;
      padding: 10px 14px !important;
   }

   .actions-bar .btn {
      font-size: clamp(14px, 2.2vw, 15px);
   }

   /* =============== DATA AREA =============== */
   #dataKaryawan {
      min-height: 160px;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
   }

   #dataKaryawan table {
      min-width: 760px;
      width: 100%;
   }

   /* amankan tabel lebar */

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


   /* ===== ACTION BUTTONS FIX (kolom "Aksi") ===== */
   #dataKaryawan table th:last-child {
      min-width: 132px;
      white-space: nowrap;
      text-align: left;
   }

   #dataKaryawan table td:last-child {
      display: inline-flex;
      gap: 8px;
      align-items: center;
      white-space: nowrap;
   }

   #dataKaryawan table td:last-child a.btn,
   #dataKaryawan table td:last-child button.btn,
   #dataKaryawan table td:last-child .btn {
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

   #dataKaryawan table td:last-child a,
   #dataKaryawan table td:last-child button {
      display: grid;
      place-items: center;
      text-decoration: none;
   }

   /* ======= RESPONSIVE ======= */
   @media (max-width: 991.98px) {
      .u-head {
         flex-wrap: wrap;
      }
   }

   @media (max-width: 767.98px) {
      .u-head {
         flex-direction: column;
         align-items: flex-start;
         gap: 8px;
      }

      .input-chip {
         width: 100%;
      }

      .u-foot {
         flex-direction: column;
         align-items: flex-start;
         gap: 8px;
      }

      .actions-bar .btn {
         width: 100%;
      }

      /* tombol aksi header full-width di HP */
      #dataKaryawan table th,
      #dataKaryawan table td {
         padding: .7rem .6rem !important;
      }
   }

   @media (max-width: 575.98px) {
      #dataKaryawan table th:last-child {
         min-width: 112px;
      }

      #dataKaryawan table td:last-child {
         gap: 6px;
      }

      #dataKaryawan table td:last-child a.btn,
      #dataKaryawan table td:last-child button.btn,
      #dataKaryawan table td:last-child .btn {
         width: 36px;
         height: 36px;
         border-radius: 8px;
      }

      #dataKaryawan table td:last-child .material-icons {
         font-size: 18px;
      }
   }

   /* Motion-reduce */
   @media (prefers-reduced-motion: reduce) {
      .skeleton::after {
         animation: none;
      }

      .pill,
      .btn-hero {
         transition: none;
      }
   }
</style>

<div class="content" id="pageKaryawan">

   <div class="container-fluid">
      <!-- ========== HEAD ACTIONS ========== -->
      <div class="actions-bar">
         <a class="btn btn-primary btn-rounded" href="<?= base_url('admin/karyawan/create'); ?>">
            <i class="material-icons mr-2">add</i> Tambah data karyawan
         </a>
         <a class="btn btn-info btn-rounded" href="<?= base_url('admin/karyawan/bulk'); ?>">
            <i class="material-icons mr-2">upload_file</i> Import CSV
         </a>
         <button class="btn btn-danger btn-rounded btn-table-delete" onclick="deleteSelectedKaryawan('Data yang sudah dihapus tidak bisa kembalikan');">
            <i class="material-icons mr-2">delete_forever</i> Bulk Delete
         </button>
      </div>

      <!-- ====== FILTER & DEPARTEMEN ====== -->
      <div class="u-card mb-3">
         <div class="u-head">
            <div>
               <h5 class="u-title"><i class="material-icons" style="color:var(--primary)">tune</i> Filter Karyawan</h5>
               <p class="u-sub">Pilih departemen &amp; jabatan untuk menampilkan daftar karyawan</p>
            </div>
         </div>

         <div class="u-body">
            <div class="form-group">
               <label for="filterDepartemenJabatan" class="form-label" style="color: var(--text); font-weight: 600; margin-bottom: 8px;">
                  <i class="material-icons" style="vertical-align: middle; margin-right: 6px; color: var(--primary);">apartment</i>
                  Filter Departemen & Jabatan
               </label>
               <select id="filterDepartemenJabatan" class="form-control custom-select" style="border: 2px solid #e3f2fd; border-radius: 8px; padding: 12px 16px; font-size: 14px; background: white; color: #333; min-height: 48px;">
                  <option value="all">Semua Departemen & Jabatan</option>
                  <?php foreach ($listDepartemen as $value): ?>
                     <?php
                     $idDepartemen   = $value['id_departemen'];
                     $namaDepartemen = $value['departemen'] . ' - ' . $value['jabatan'];
                     ?>
                     <option value="<?= $idDepartemen; ?>" data-nama="<?= $namaDepartemen; ?>"><?= $namaDepartemen; ?></option>
                  <?php endforeach; ?>
               </select>
            </div>
         </div>

         <div class="u-foot">
            <small>Tips: pilih filter atau klik <b>Refresh</b> untuk memuat ulang data.</small>
            <button id="btnRefresh" class="btn-soft btn-refresh" type="button" style="background: #e8f5e8; border: 1px solid #4caf50; color: #2e7d32; padding: 8px 16px; border-radius: 6px; font-weight: 500;">
               <i class="material-icons" style="margin-right: 4px;">refresh</i> Refresh
            </button>
         </div>
      </div>

      <!-- ====== DATA KARYAWAN ====== -->
      <div class="u-card">
         <div class="u-head">
            <div>
               <h4 class="u-title"><i class="material-icons" style="color:var(--success)">people</i> Data Karyawan</h4>
               <p class="u-sub">Total Karyawan: <span style="background: var(--success); color: white; padding: 2px 8px; border-radius: 8px; font-weight: 700;"><?= $total_karyawan; ?></span> | <?= date('d M Y H:i'); ?></p>
            </div>
            <button class="btn-hero" type="button" onclick="loadKaryawan()">
               <i class="material-icons" style="color:var(--success)">refresh</i> Refresh
            </button>
         </div>

         <div class="u-body" id="dataKaryawan">
            <div class="placeholder">Memuat data karyawan...</div>
         </div>

         <div class="u-foot">
            <span style="display:inline-flex;align-items:center;gap:6px;">
               <i class="material-icons" style="color:var(--primary)">info</i>
               Data diperbarui berdasarkan filter yang dipilih.
            </span>
            <span class="badge-soft">Realtime AJAX</span>
         </div>
      </div>
   </div>
</div>

<script>

   /* ============ STATE & FILTER ============ */
   var lastIdDepartemen = 'all';
   var lastDepartemen = 'Semua Departemen & Jabatan';

   function selectDepartemenJabatan(id, nama) {
      lastIdDepartemen = id;
      lastDepartemen = nama;
      loadKaryawan();
   }

   /* ============ LOADING PLACEHOLDER ============ */
   function setLoading() {
      document.getElementById('dataKaryawan').innerHTML = `
        <div class="skeleton"></div>
        <div class="skeleton" style="height:64px"></div>
        <div class="skeleton" style="height:64px"></div>
      `;
   }


   /* ============ AJAX LOAD ============ */
   function loadKaryawan() {
      setLoading();
      $.ajax({
         url: "<?= base_url('/admin/karyawan'); ?>",
         type: 'post',
         data: {
            'departemen': lastDepartemen,
            'id_departemen': lastIdDepartemen
         },
         success: function(res) {
            $('#dataKaryawan').html(res);
            $('html, body').animate({
               scrollTop: $("#dataKaryawan").offset().top - 80
            }, 260);
         },
         error: function(xhr, status, err) {
            console.log('Error:', err);
            console.log('Response:', xhr.responseText);
            $('#dataKaryawan').html(`<div class="placeholder">Gagal memuat data.<br><small class="text-danger">${err}</small></div>`);
         }
      });
   }

   // Auto-load data saat halaman dibuka
   $(document).ready(function() {
      // Set dropdown ke "Semua Departemen & Jabatan"
      $('#filterDepartemenJabatan').val('all');
      // Load data secara otomatis
      loadKaryawan();
   });

   /* ================== EVENT BINDINGS ================== */
   $('#btnRefresh').on('click', loadKaryawan);
   
   // Event handler untuk dropdown gabungan
   $('#filterDepartemenJabatan').on('change', function() {
      const selectedOption = $(this).find('option:selected');
      const id = $(this).val();
      const nama = selectedOption.data('nama') || selectedOption.text();
      selectDepartemenJabatan(id, nama);
   });


   // checkbox "select all" bila ada di partial
   document.addEventListener('DOMContentLoaded', function() {
      $("#checkAll").click(function() {
         $('input:checkbox').not(this).prop('checked', this.checked);
      });
   });
</script>

<style>
   /* ============ CUSTOM STYLES ============ */
   .custom-select {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 16px center;
      background-size: 20px;
      padding-right: 48px;
      cursor: pointer;
      transition: all 0.2s ease;
   }
   
   .custom-select:hover {
      border-color: #90caf9;
   }
   
   .custom-select:focus {
      border-color: #2196f3;
      box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.2);
      outline: none;
   }
</style>

<?= $this->endSection() ?>