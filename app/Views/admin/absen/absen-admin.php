<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
   /* ================= PAGE-ONLY STYLES (Tanpa tokens/theme & tanpa navbar/footer) ================= */

   /* Background halaman (boleh dipertahankan jika memang mau mesh di halaman ini) */
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

   /* =============== GLASS CARDS (komponen halaman) =============== */
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

   /* Refresh spin animation */
   @keyframes spin360 {
      to {
         transform: rotate(360deg);
      }
   }

   .btn-refresh.is-loading .material-icons {
      animation: spin360 .9s linear infinite;
      color: var(--ring);
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
      background: linear-gradient(180deg, color-mix(in oklab, var(--card-solid) 90%, transparent), transparent);
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

   /* Responsive dasar yang sudah ada */
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

   /* ====== Layout seragam untuk list kartu stats (jika dipakai di halaman ini) ====== */
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

   .card.card-stats .card-header.card-header-icon {
      display: grid;
      grid-template-columns: 92px 1fr auto;
      grid-auto-rows: auto;
      align-items: center;
      column-gap: 16px;
      min-height: 128px;
      padding-bottom: 14px;
      border-bottom: 1px solid var(--border);
      background: linear-gradient(180deg, var(--card-solid, #fff), transparent);
   }

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

   .card.card-stats .card-header::after {
      content: none !important;
   }

   .card.card-stats .card-footer {
      display: flex;
      align-items: center;
      gap: 10px;
      min-height: 56px;
      border-top: 1px solid var(--border);
   }

   .card.card-stats .card-footer .stats {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      color: var(--muted);
   }

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

   /* ==================== MOBILE TUNING (lebih padat & rapi di HP) ==================== */
   @media (max-width: 991.98px) {
      .u-card {
         border-radius: 16px;
      }

      .u-head {
         gap: 10px;
      }
   }

   @media (max-width: 767.98px) {
      .container-fluid {
         padding: 0 12px !important;
      }

      .u-card {
         border-radius: 14px;
      }

      .u-head {
         padding: 10px 12px;
         gap: 8px;
      }

      .u-body {
         padding: 12px;
      }

      .u-foot {
         padding: 10px 12px;
         font-size: 12px;
      }

      .u-title {
         font-size: 16px;
         line-height: 1.2;
      }

      .u-sub {
         font-size: 12px;
      }

      .input-chip {
         padding: 8px 10px;
         border-radius: 10px;
      }

      .input-chip .form-control {
         min-width: 150px;
         font-size: 14px;
      }

      .btn-soft {
         padding: 8px 12px;
         border-radius: 10px;
         font-size: 13px;
      }

      .btn-soft .material-icons {
         font-size: 18px;
      }

      .placeholder {
         padding: 14px;
         border-radius: 10px;
      }

      .skeleton {
         height: 64px;
      }

      /* ikon dalam komponen halaman sedikit diperkecil */
      .u-card .material-icons,
      .input-chip .material-icons {
         font-size: 20px;
      }
   }

   @media (max-width: 420px) {
      .u-card {
         border-radius: 12px;
      }

      .u-head {
         padding: 8px 10px;
      }

      .u-body {
         padding: 10px;
      }

      .u-foot {
         padding: 8px 10px;
      }

      .u-title {
         font-size: 15px;
      }

      .u-sub {
         font-size: 11.5px;
      }

      .input-chip .form-control {
         min-width: 130px;
         font-size: 13px;
      }

      .btn-soft {
         padding: 7px 10px;
         font-size: 12.5px;
      }

      .input-chip .material-icons,
      #dataAdmin .material-icons {
         font-size: 18px;
      }
   }

   @media (max-width: 360px) {
      .input-chip .form-control {
         min-width: 120px;
      }
   }

   /* === Perapihan pill "Realtime AJAX" + footer responsif === */

   /* Pill di dalam footer: selalu 1 baris, center, bentuk oval */
   .u-foot .badge-soft {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      white-space: nowrap;
      /* cegah pecah baris "Realtime AJAX" */
      line-height: 1;
      padding: 8px 12px;
      /* sedikit lebih lega */
      border-radius: 9999px;
      /* benar-benar oval */
      box-shadow: var(--neon);
      /* glow tipis */
   }

   /* Penempatan footer di mobile: teks di atas, pill di bawah */
   @media (max-width: 640px) {
      .u-foot {
         flex-direction: column;
         /* stack */
         align-items: flex-start;
         /* rata kiri supaya rapi */
         gap: 8px;
      }

      .u-foot .badge-soft {
         font-size: 11.5px;
         padding: 7px 10px;
         /* pill sedikit lebih kecil di HP */
      }
   }

   /* Layar sangat kecil */
   @media (max-width: 380px) {
      .u-foot .badge-soft {
         font-size: 11px;
         padding: 6px 9px;
      }
   }
</style>

<div class="content" id="pageAbsensiAdmin">
   <!-- TIDAK ADA THEME TOGGLE DI HALAMAN INI. Toggle sudah ada di navbar/header global -->

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
               <p class="u-sub">Total Admin: <span style="background: var(--success); color: white; padding: 2px 8px; border-radius: 8px; font-weight: 700;"><?= $total_admin; ?></span> | <?= date('d M Y H:i'); ?></p>
            </div>
            <button id="btnRefresh" class="btn-soft btn-refresh" type="button">
               <i class="material-icons">refresh</i> Refresh
            </button>
         </div>

         <div class="u-body">
            <div id="dataAdmin" class="placeholder">
               Belum ada data ditampilkan. Silakan pilih tanggal atau tekan <b>Refresh</b>.
            </div>
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
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" style="color:var(--text)">&times;</span>
               </button>
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
         $btn.addClass('is-loading').prop('disabled', true);
         $('#dataAdmin').html(`
           <div class="skeleton"></div>
           <div class="skeleton" style="height:64px"></div>
           <div class="skeleton" style="height:64px"></div>
         `);
      } else {
         $btn.removeClass('is-loading').prop('disabled', false);
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
         data: {
            tanggal
         },
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
   getAdmin(); // Load awal
   $('#btnRefresh').on('click', getAdmin);
   $('#tanggal').on('change input', debounce(getAdmin, 250));

   // Expose ke global (dipakai di partial yang dirender AJAX)
   window.ubahKehadiran = ubahKehadiran;
   window.getDataKehadiran = getDataKehadiran;
</script>

<?= $this->endSection() ?>