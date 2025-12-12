<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<style>
   /* ===================== MODERN PETUGAS THEME ===================== */
   .content {
      --bg: #f8fafc;
      --card: #ffffff;
      --text: #1e293b;
      --muted: #64748b;
      --border: #e2e8f0;
      --border-hover: #cbd5e1;
      --ring: #3b82f6;
      --primary: #3b82f6;
      --primary-hover: #2563eb;
      --primary-light: #dbeafe;
      --success: #22c55e;
      --success-hover: #16a34a;
      --success-light: #dcfce7;
      --danger: #ef4444;
      --danger-hover: #dc2626;
      --danger-light: #fee2e2;
      --info: #06b6d4;
      --info-hover: #0891b2;
      --info-light: #cffafe;
      --radius: 12px;
      --radius-lg: 16px;
      --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
      --shadow-lg: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-xl: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      position: relative;
      padding: 24px 0 40px !important;
      color: var(--text);
      background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
      min-height: 100vh;
      width: 100%;
      display: block;
      visibility: visible;
   }

   html[data-theme="dark"] .content {
      --bg: #0f172a;
      --card: #1e293b;
      --text: #f1f5f9;
      --muted: #94a3b8;
      --border: #334155;
      --border-hover: #475569;
      --ring: #60a5fa;
      --primary: #60a5fa;
      --primary-hover: #3b82f6;
      --primary-light: #1e3a8a;
      --success: #34d399;
      --success-hover: #10b981;
      --success-light: #064e3b;
      --danger: #f87171;
      --danger-hover: #ef4444;
      --danger-light: #7f1d1d;
      --info: #22d3ee;
      --info-hover: #06b6d4;
      --info-light: #164e63;
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
   }

   .content .page-wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
      width: 100%;
      display: block;
      visibility: visible;
   }

   .content .toolbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-bottom: 32px;
      padding: 24px 0;
      gap: 16px;
   }

   .content .toolbar h3 {
      margin: 0;
      font-weight: 700;
      font-size: 1.875rem;
      letter-spacing: -0.025em;
      color: var(--text);
      display: flex;
      align-items: center;
      gap: 12px;
   }

   .content .toolbar h3::before {
      content: "👥";
      font-size: 1.5rem;
   }

   .content .toolbar p {
      margin: 4px 0 0 0;
      color: var(--muted);
      font-size: 0.9rem;
   }

   .content .btn-group {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
   }

   .content .btn {
      border-radius: var(--radius);
      line-height: 1.5;
      padding: 10px 20px;
      font-weight: 600;
      font-size: 0.85rem;
      border: 1px solid transparent;
      transition: all 0.2s ease;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      text-decoration: none;
   }

   .content .btn:focus-visible {
      outline: 2px solid var(--ring);
      outline-offset: 2px;
   }

   .content .btn:active {
      transform: translateY(1px);
   }

   .content .btn-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: #ffffff;
      border: none;
      box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.3);
   }

   .content .btn-success:hover {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      box-shadow: 0 6px 20px 0 rgba(16, 185, 129, 0.4);
      transform: translateY(-2px);
      color: #ffffff;
   }

   .content .btn-info {
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
      color: #ffffff;
      border: none;
      box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.3);
      position: relative;
      overflow: hidden;
   }

   .content .btn-info:hover {
      background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
      box-shadow: 0 6px 20px 0 rgba(59, 130, 246, 0.4);
      transform: translateY(-2px);
      color: #ffffff;
   }

   .content .btn-info.loading {
      pointer-events: none;
      opacity: 0.8;
   }

   .content .btn-info.loading .btn-text {
      opacity: 0;
   }

   .content .btn-info .loading-spinner {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 16px;
      height: 16px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-top: 2px solid #ffffff;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      opacity: 0;
      transition: opacity 0.3s ease;
   }

   .content .btn-info.loading .loading-spinner {
      opacity: 1;
   }

   .content .btn .btn-text-full {
      display: inline;
   }

   .content .btn .btn-text-short {
      display: none;
   }

   @keyframes spin {
      0% {
         transform: translate(-50%, -50%) rotate(0deg);
      }

      100% {
         transform: translate(-50%, -50%) rotate(360deg);
      }
   }

   .content .btn-danger {
      background: var(--danger);
      color: #fff;
      border-color: var(--danger);
      box-shadow: var(--shadow);
   }

   .content .btn-danger:hover {
      background: var(--danger-hover);
      border-color: var(--danger-hover);
      box-shadow: var(--shadow-lg);
      color: #fff;
   }

   .content .btn-disabled {
      background: var(--muted);
      color: #fff;
      border-color: var(--muted);
      opacity: 0.6;
      cursor: not-allowed;
   }

   .content .form-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-lg);
      transition: all 0.2s ease;
      padding: 32px;
      margin: 0 auto;
      width: 100%;
      max-width: 100%;
      box-sizing: border-box;
   }

   .content .form-card:hover {
      box-shadow: var(--shadow-xl);
   }

   .content .form-card.refreshing {
      opacity: 0.7;
      transform: scale(0.98);
      transition: all 0.3s ease;
      pointer-events: none;
   }

   .content .form-card.refreshing #dataPetugas {
      opacity: 0.3;
      transition: opacity 0.3s ease;
   }

   .content .form-card {
      position: relative !important;
   }

   .content .form-card .refresh-overlay {
      position: absolute !important;
      top: 0 !important;
      left: 0 !important;
      right: 0 !important;
      bottom: 0 !important;
      background: rgba(255, 255, 255, 0.9) !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      border-radius: var(--radius-lg) !important;
      opacity: 0 !important;
      visibility: hidden !important;
      transition: all 0.3s ease !important;
      z-index: 100 !important;
      backdrop-filter: blur(2px) !important;
   }

   html[data-theme="dark"] .content .form-card .refresh-overlay {
      background: rgba(30, 41, 59, 0.9) !important;
   }

   .content .form-card.refreshing .refresh-overlay {
      opacity: 1 !important;
      visibility: visible !important;
   }

   .content .form-card .refresh-spinner {
      width: 50px !important;
      height: 50px !important;
      border: 4px solid rgba(59, 130, 246, 0.2) !important;
      border-top: 4px solid #3b82f6 !important;
      border-radius: 50% !important;
      animation: spin 1s linear infinite, pulse 2s ease-in-out infinite !important;
   }

   @keyframes pulse {

      0%,
      100% {
         transform: scale(1);
         opacity: 1;
      }

      50% {
         transform: scale(1.1);
         opacity: 0.8;
      }
   }

   .content .form-card .refresh-text {
      position: absolute !important;
      top: 60% !important;
      left: 50% !important;
      transform: translateX(-50%) !important;
      color: var(--text) !important;
      font-size: 0.9rem !important;
      font-weight: 600 !important;
      margin-top: 10px !important;
   }

   .content .alert {
      border-radius: var(--radius);
      border: none;
      padding: 16px 20px;
      margin-bottom: 24px;
      box-shadow: var(--shadow);
   }

   .content .alert-success {
      background: var(--success-light);
      color: var(--success-hover);
      border-left: 4px solid var(--success);
   }

   .content .alert-danger {
      background: var(--danger-light);
      color: var(--danger-hover);
      border-left: 4px solid var(--danger);
   }

   /* ===================== MODERN RESPONSIVE DESIGN ===================== */

   /* Desktop & Tablet Landscape */
   @media (min-width: 1025px) {
      .content .page-wrap {
         max-width: 1200px;
         padding: 0 32px;
      }

      .content .toolbar {
         margin-bottom: 40px;
         padding: 32px 0;
      }

      .content .toolbar h3 {
         font-size: 2rem;
         margin-bottom: 8px;
      }

      .content .btn-group {
         gap: 16px;
      }

      .content .btn {
         padding: 12px 24px;
         font-size: 0.9rem;
         min-width: 140px;
      }

      .content .form-card {
         padding: 40px;
         margin: 0;
         width: 100%;
      }
   }

   /* Tablet Portrait */
   @media (max-width: 1024px) and (min-width: 769px) {
      .content .page-wrap {
         max-width: 100%;
         padding: 0 24px;
      }

      .content .toolbar {
         flex-direction: column;
         align-items: center;
         text-align: center;
         margin-bottom: 36px;
         padding: 28px 0;
      }

      .content .toolbar h3 {
         font-size: 1.75rem;
         margin-bottom: 8px;
      }

      .content .toolbar p {
         margin-bottom: 24px;
      }

      .content .btn-group {
         gap: 16px;
         width: auto;
         justify-content: center;
      }

      .content .btn {
         padding: 12px 24px;
         font-size: 0.9rem;
         min-width: 140px;
      }

      .content .form-card {
         padding: 32px;
         margin: 0;
         width: 100%;
      }
   }

   /* Mobile Landscape & Small Tablet */
   @media (max-width: 768px) and (min-width: 577px) {
      .content .page-wrap {
         padding: 0 20px;
      }

      .content .toolbar {
         flex-direction: column;
         align-items: center;
         text-align: center;
         margin-bottom: 32px;
         padding: 24px 0;
      }

      .content .toolbar h3 {
         font-size: 1.5rem;
         margin-bottom: 6px;
      }

      .content .toolbar p {
         font-size: 0.9rem;
         margin-bottom: 20px;
      }

      .content .btn-group {
         flex-direction: row;
         gap: 12px;
         width: auto;
         justify-content: center;
      }

      .content .btn {
         padding: 10px 20px;
         font-size: 0.8rem;
         min-width: 120px;
      }

      .content .form-card {
         padding: 28px;
         margin: 0;
         width: 100%;
      }
   }

   /* Mobile Portrait */
   @media (max-width: 576px) {
      .content {
         padding: 16px 0 24px !important;
      }

      .content .page-wrap {
         padding: 0 16px;
      }

      .content .toolbar {
         flex-direction: column;
         align-items: center;
         text-align: center;
         margin-bottom: 24px;
         padding: 20px 0;
      }

      .content .toolbar h3 {
         font-size: 1.4rem;
         margin-bottom: 4px;
      }

      .content .toolbar p {
         font-size: 0.85rem;
         margin-bottom: 16px;
      }

      .content .btn-group {
         flex-direction: column;
         gap: 12px;
         width: 100%;
         max-width: 280px;
      }

      .content .btn {
         width: 100%;
         padding: 12px 20px;
         font-size: 0.8rem;
         justify-content: center;
      }

      .content .form-card {
         padding: 20px;
         margin: 0;
         width: 100%;
      }
   }

   /* Small Mobile */
   @media (max-width: 480px) {
      .content .page-wrap {
         padding: 0 12px;
      }

      .content .toolbar {
         margin-bottom: 20px;
         padding: 16px 0;
      }

      .content .toolbar h3 {
         font-size: 1.25rem;
         margin-bottom: 4px;
      }

      .content .toolbar p {
         font-size: 0.8rem;
         margin-bottom: 14px;
      }

      .content .btn-group {
         max-width: 260px;
         gap: 10px;
      }

      .content .btn {
         padding: 10px 16px;
         font-size: 0.75rem;
      }

      .content .form-card {
         padding: 16px;
         margin: 0;
         width: 100%;
      }
   }

   /* Animasi refresh tetap muncul di semua device */
   .content .form-card .refresh-overlay {
      position: absolute !important;
      top: 0 !important;
      left: 0 !important;
      right: 0 !important;
      bottom: 0 !important;
      z-index: 100 !important;
   }
</style>

<div class="content">
   <div class="page-wrap">
      <div class="toolbar">
         <div>
            <h3>Daftar Petugas</h3>
            <p>Kelola data petugas absensi</p>
         </div>
         <div class="btn-group">
            <a href="<?= base_url('admin/petugas/register'); ?>" class="btn btn-success" onclick="removeHover();">
               <span class="btn-text">➕ <span class="btn-text-full">Tambah Petugas</span><span class="btn-text-short">Tambah</span></span>
            </a>
            <button onclick="getDataPetugas()" class="btn btn-info" id="refreshBtn">
               <span class="btn-text">🔄 <span class="btn-text-full">Refresh</span><span class="btn-text-short">Refresh</span></span>
               <div class="loading-spinner"></div>
            </button>
         </div>
      </div>

      <?php if (session()->getFlashdata('msg')) : ?>
         <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success' ?>">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <i class="material-icons">close</i>
            </button>
            <?= session()->getFlashdata('msg') ?>
         </div>
      <?php endif; ?>

      <div class="form-card" id="dataCard">
         <div class="refresh-overlay">
            <div class="refresh-spinner"></div>
            <div class="refresh-text">Memuat data...</div>
         </div>
         <div id="dataPetugas">
            <p class="text-center mt-3">Daftar petugas muncul disini</p>
         </div>
      </div>
   </div>
</div>
<script>
   var departemen = null;
   var jabatan = null;

   getDataPetugas();

   function getDataPetugas() {
      const refreshBtn = document.getElementById('refreshBtn');
      const dataCard = document.getElementById('dataCard');

      // Add loading state
      refreshBtn.classList.add('loading');
      refreshBtn.disabled = true;
      dataCard.classList.add('refreshing');

      // Show loading immediately
      setTimeout(() => {
         if (dataCard.classList.contains('refreshing')) {
            dataCard.style.opacity = '0.7';
         }
      }, 100);

      jQuery.ajax({
         url: "<?= base_url('/admin/petugas'); ?>",
         type: 'post',
         data: {},
         success: function(response, status, xhr) {
            // console.log(status);

            // Add fade out effect
            $('#dataPetugas').fadeOut(200, function() {
               $(this).html(response).fadeIn(300);
            });

            removeHover();

            $('html, body').animate({
               scrollTop: $("#dataPetugas").offset().top
            }, 500);
         },
         error: function(xhr, status, thrown) {
            console.log(thrown);
            $('#dataPetugas').fadeOut(200, function() {
               $(this).html(thrown).fadeIn(300);
            });
         },
         complete: function() {
            // Remove loading state with delay
            setTimeout(() => {
               refreshBtn.classList.remove('loading');
               refreshBtn.disabled = false;
               dataCard.classList.remove('refreshing');
               dataCard.style.opacity = '1';
            }, 800);
         }
      });
   }

   function removeHover() {
      setTimeout(() => {
         $('#tabBtn').removeClass('active show');
         $('#refreshBtn').removeClass('active show');
      }, 250);
   }
</script>
<?= $this->endSection() ?>