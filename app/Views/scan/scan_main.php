<?= $this->extend('templates/starting_page_layout'); ?>

<?= $this->section('content'); ?>
<style>
   :root {
      --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
      --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
      --info-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
      --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --card-shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      --bg: #eef3fb;
      --bg-accent: #e5efff;
      --card: #ffffff;
      --text: #1f2937;
      --text-muted: #6b7280;
      --border: rgba(16, 24, 40, 0.12);
   }
   
   [data-theme="dark"] {
      --bg: #0a0f1a;
      --bg-accent: #141b2d;
      --card: #1a2332;
      --text: #f0f4ff;
      --text-muted: #b8c5d9;
      --border: rgba(200, 210, 230, 0.2);
      --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
      --card-shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.3);
   }

   .scan-main-header {
      margin-top: 1rem;
      margin-bottom: 1.5rem;
      padding: 2.5rem 2rem;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 20px;
      position: relative;
      overflow: hidden;
   }

   .scan-main-header::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
      animation: pulse 4s ease-in-out infinite;
   }

   @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 0.5; }
      50% { transform: scale(1.1); opacity: 0.8; }
   }
   
   .scan-main-header h1 {
      font-size: 2.75rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: 1rem;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      position: relative;
      z-index: 1;
   }
   
   .scan-main-header .lead {
      font-size: 1.15rem;
      font-weight: 400;
      margin-bottom: 1.5rem;
      color: var(--text-muted);
      position: relative;
      z-index: 1;
   }
   
   [data-theme="dark"] .scan-main-header h1 {
      background: linear-gradient(135deg, #8bb4ff 0%, #a78bfa 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
   }
   
   [data-theme="dark"] .scan-main-header::before {
      background: radial-gradient(circle, rgba(139, 180, 255, 0.15) 0%, transparent 70%);
   }

   .feature-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      background: var(--card);
      border-radius: 50px;
      box-shadow: var(--card-shadow);
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--text);
      transition: all 0.3s ease;
      position: relative;
      z-index: 1;
      border: 1px solid var(--border);
   }
   
   [data-theme="dark"] .feature-badge:not(.bg-primary):not(.bg-warning):not(.bg-success):not(.bg-info) {
      background: var(--card);
      color: var(--text);
      border-color: var(--border);
   }

   .feature-badge:hover {
      transform: translateY(-2px);
      box-shadow: var(--card-shadow-hover);
   }

   .feature-badge i {
      font-size: 20px;
   }

   .feature-badge.bg-primary { background: var(--primary-gradient); color: white; }
   .feature-badge.bg-warning { background: var(--warning-gradient); color: white; }
   .feature-badge.bg-success { background: var(--success-gradient); color: white; }
   .feature-badge.bg-info { background: var(--info-gradient); color: white; }
   
   .container-fluid {
      margin-left: auto;
      margin-right: auto;
      padding-left: 2rem;
      padding-right: 2rem;
      max-width: 1400px;
   }

   .scan-card {
      border: 1px solid var(--border);
      border-radius: 16px;
      box-shadow: var(--card-shadow);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
      height: 100%;
      background: var(--card);
   }

   .scan-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--card-shadow-hover);
   }

   .scan-card .card-body {
      padding: 2.5rem;
   }

   .scan-icon-wrapper {
      width: 90px;
      height: 90px;
      border-radius: 20px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
      position: relative;
      overflow: hidden;
   }

   .scan-icon-wrapper::before {
      content: '';
      position: absolute;
      inset: 0;
      background: inherit;
      opacity: 0.2;
      filter: blur(20px);
   }

   .scan-icon-wrapper i {
      font-size: 45px;
      color: white;
      position: relative;
      z-index: 1;
   }

   .scan-card h4 {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 0.75rem;
      color: var(--text);
   }

   .scan-card .card-text {
      color: var(--text-muted);
      font-size: 0.95rem;
      line-height: 1.6;
      margin-bottom: 1.5rem;
   }

   .scan-card .btn {
      border-radius: 12px;
      padding: 12px 24px;
      font-weight: 600;
      font-size: 1rem;
      transition: all 0.3s ease;
      border: none;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
   }

   .scan-card .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
   }

   .dashboard-btn-top {
      border-radius: 12px;
      padding: 12px 24px;
      font-weight: 600;
      box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
      border: none;
      color: white;
   }

   .dashboard-btn-top:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.4);
      background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
      color: white;
   }

   .dashboard-btn-top i {
      font-size: 20px;
   }

   .tips-section {
      margin-top: 4rem;
      padding-top: 2rem;
   }

   .tips-card {
      border: 1px solid var(--border);
      border-radius: 16px;
      box-shadow: var(--card-shadow);
      background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
   }
   
   [data-theme="dark"] .tips-card {
      background: linear-gradient(135deg, var(--card) 0%, rgba(26, 35, 50, 0.8) 100%);
      border-color: var(--border);
   }

   .tips-card .card-body {
      padding: 2rem;
   }

   .tips-card h4 {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: var(--text);
   }

   .tip-item {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      padding: 1rem;
      background: var(--card);
      border-radius: 12px;
      margin-bottom: 1rem;
      transition: all 0.3s ease;
      border: 1px solid var(--border);
      border-left: 4px solid #10b981;
   }
   
   [data-theme="dark"] .tip-item {
      background: var(--card);
      border-color: var(--border);
      border-left-color: #4ade80;
   }

   .tip-item:hover {
      transform: translateX(5px);
      box-shadow: var(--card-shadow);
   }

   .tip-item i {
      font-size: 24px;
      color: #10b981;
      margin-top: 2px;
   }
   
   [data-theme="dark"] .tip-item i {
      color: #4ade80;
   }

   .tip-item h6 {
      font-size: 1rem;
      font-weight: 600;
      margin-bottom: 0.25rem;
      color: var(--text);
   }

   .tip-item small {
      color: var(--text-muted);
      font-size: 0.875rem;
      line-height: 1.5;
   }
   
   /* Modal Dark Mode */
   [data-theme="dark"] .modal-content {
      background: var(--card);
      color: var(--text);
      border-color: var(--border);
   }
   
   [data-theme="dark"] .modal-header {
      background: var(--card);
      border-bottom-color: var(--border);
      color: var(--text);
   }
   
   [data-theme="dark"] .modal-title {
      color: var(--text);
   }
   
   [data-theme="dark"] .modal-body {
      background: var(--card);
      color: var(--text);
   }
   
   [data-theme="dark"] .modal-body h6 {
      color: var(--text);
   }
   
   [data-theme="dark"] .modal-body ol li,
   [data-theme="dark"] .modal-body ul li {
      color: var(--text-muted);
   }
   
   [data-theme="dark"] .modal-body strong {
      color: var(--text);
   }
   
   [data-theme="dark"] .modal-body hr {
      border-color: var(--border);
      opacity: 0.5;
   }
   
   [data-theme="dark"] .modal-footer {
      background: var(--card);
      border-top-color: var(--border);
   }
   
   [data-theme="dark"] .alert-info {
      background-color: rgba(96, 165, 250, 0.15);
      border-color: rgba(96, 165, 250, 0.3);
      color: var(--text);
   }
   
   [data-theme="dark"] .alert-info strong {
      color: var(--text);
   }
   
   /* Button Dark Mode */
   [data-theme="dark"] .btn-secondary {
      background-color: var(--card);
      border-color: var(--border);
      color: var(--text);
   }
   
   [data-theme="dark"] .btn-secondary:hover {
      background-color: var(--bg-accent);
      color: var(--text);
   }
   
   /* Body background */
   body {
      background: var(--bg);
      color: var(--text);
   }
   
   /* List styling in modal */
   [data-theme="dark"] .modal-body ol,
   [data-theme="dark"] .modal-body ul {
      color: var(--text-muted);
   }
   
   [data-theme="dark"] .modal-body ol li::marker,
   [data-theme="dark"] .modal-body ul li::marker {
      color: var(--text);
   }
   
   /* Table styling if any */
   [data-theme="dark"] table {
      color: var(--text);
   }
   
   [data-theme="dark"] table thead {
      background: var(--bg-accent);
      color: var(--text);
   }
   
   [data-theme="dark"] table tbody {
      background: var(--card);
      color: var(--text);
   }
   
   [data-theme="dark"] table td,
   [data-theme="dark"] table th {
      border-color: var(--border);
      color: var(--text);
   }
   
   [data-theme="dark"] table tr:hover {
      background: var(--bg-accent);
   }
   
   @media (max-width: 768px) {
      .scan-main-header {
         margin-top: 1rem;
         margin-bottom: 2rem;
         padding: 2rem 1.5rem;
      }

      .scan-main-header h1 {
         font-size: 2rem;
      }
      
      .scan-main-header .lead {
         font-size: 1rem;
      }

      .feature-badge {
         padding: 8px 16px;
         font-size: 0.85rem;
      }
      
      .container-fluid {
         padding-left: 1rem;
         padding-right: 1rem;
      }

      .scan-card .card-body {
         padding: 1.5rem;
      }

      .scan-icon-wrapper {
         width: 70px;
         height: 70px;
      }

      .scan-icon-wrapper i {
         font-size: 35px;
      }
   }
</style>

<div class="container-fluid">
   <!-- Button Dashboard di Atas -->
   <div class="row mb-4 mt-4">
      <div class="col-12 d-flex justify-content-start">
         <a href="<?= base_url('admin/dashboard'); ?>" class="dashboard-btn-top">
            <i class="material-icons">dashboard</i>
            <span>Masuk ke Dashboard</span>
         </a>
      </div>
   </div>

   <!-- Header Utama -->
   <div class="row mb-3">
      <div class="col-12">
         <div class="text-center scan-main-header">
            <h1>Absensi Karyawan dan Admin Berbasis QR Code</h1>
            <p class="lead">Sistem absensi modern menggunakan teknologi QR Code untuk kemudahan dan keakuratan</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
               <span class="feature-badge bg-primary">
                  <i class="material-icons">qr_code_scanner</i>
                  Scan QR Code
               </span>
               <span class="feature-badge bg-warning">
                  <i class="material-icons">usb</i>
                  USB Scanner
               </span>
               <span class="feature-badge bg-success">
                  <i class="material-icons">schedule</i>
                  Real-time
               </span>
               <span class="feature-badge bg-info">
                  <i class="material-icons">security</i>
                  Secure
               </span>
            </div>
         </div>
      </div>
   </div>

   <!-- Menu Utama -->
   <div class="row mb-4 g-4 justify-content-center">
      <div class="col-lg-3 col-md-6">
         <div class="scan-card">
            <div class="card-body text-center">
               <div class="scan-icon-wrapper" style="background: var(--primary-gradient);">
                  <i class="material-icons">login</i>
                  </div>
               <h4>Absen Masuk</h4>
               <p class="card-text">Lakukan absensi masuk dengan memindai QR Code Anda</p>
               <a href="<?= base_url('scan/masuk'); ?>" class="btn btn-primary w-100">
                  <i class="material-icons mr-2" style="vertical-align: middle;">arrow_forward</i>
                  Mulai Absen Masuk
               </a>
            </div>
         </div>
      </div>

      <div class="col-lg-3 col-md-6">
         <div class="scan-card">
            <div class="card-body text-center">
               <div class="scan-icon-wrapper" style="background: var(--warning-gradient);">
                  <i class="material-icons">logout</i>
                  </div>
               <h4>Absen Pulang</h4>
               <p class="card-text">Lakukan absensi pulang dengan memindai QR Code Anda</p>
               <a href="<?= base_url('scan/pulang'); ?>" class="btn btn-warning w-100">
                  <i class="material-icons mr-2" style="vertical-align: middle;">arrow_forward</i>
                  Mulai Absen Pulang
               </a>
            </div>
         </div>
      </div>

      <div class="col-lg-3 col-md-6">
         <div class="scan-card">
            <div class="card-body text-center">
               <div class="scan-icon-wrapper" style="background: var(--danger-gradient);">
                  <i class="material-icons">logout</i>
               </div>
               <h4>Logout</h4>
               <p class="card-text">Keluar dari akun absensi Anda</p>
               <a href="<?= base_url('scan/logout'); ?>" class="btn btn-danger w-100">
                  <i class="material-icons mr-2" style="vertical-align: middle;">exit_to_app</i>
                  Logout
               </a>
            </div>
                  </div>
               </div>
      
      <div class="col-lg-3 col-md-6">
         <div class="scan-card">
            <div class="card-body text-center">
               <div class="scan-icon-wrapper" style="background: var(--info-gradient);">
                  <i class="material-icons">help_outline</i>
               </div>
               <h4>Panduan</h4>
               <p class="card-text">Pelajari cara menggunakan sistem absensi QR Code</p>
               <button class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#panduanModal">
                  <i class="material-icons mr-2" style="vertical-align: middle;">book</i>
                  Lihat Panduan
               </button>
            </div>
         </div>
      </div>
   </div>


   <!-- Tips Penggunaan -->
   <div class="row justify-content-center tips-section">
      <div class="col-12 col-lg-10 col-xl-8">
         <div class="tips-card">
            <div class="card-body">
               <h4>Tips Penggunaan</h4>
               <div class="row g-3">
                  <div class="col-lg-4 col-md-6">
                     <div class="tip-item">
                        <i class="material-icons">check_circle</i>
                        <div>
                           <h6>Pastikan QR Code dalam kondisi baik</h6>
                           <small>QR Code harus jelas dan tidak rusak untuk hasil scan yang optimal</small>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6">
                     <div class="tip-item">
                        <i class="material-icons">check_circle</i>
                        <div>
                           <h6>Posisikan QR Code dengan benar</h6>
                           <small>Jaga jarak optimal antara QR Code dan kamera untuk hasil terbaik</small>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6">
                     <div class="tip-item">
                        <i class="material-icons">check_circle</i>
                        <div>
                           <h6>Pastikan koneksi internet stabil</h6>
                           <small>Koneksi yang stabil memastikan sinkronisasi data berjalan lancar</small>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal Panduan -->
<div class="modal fade" id="panduanModal" tabindex="-1" aria-labelledby="panduanModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="panduanModalLabel">
               <i class="material-icons mr-2">book</i>
               Panduan Penggunaan Sistem Absensi QR Code
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-6">
                  <h6><b>Langkah-langkah Absensi:</b></h6>
                  <ol>
                     <li>Pilih menu "Absen Masuk" atau "Absen Pulang"</li>
                     <li>Pilih mode scan: Kamera atau USB Scanner</li>
                     <li><strong>Mode Kamera:</strong> Izinkan akses kamera dan tunjukkan QR Code</li>
                     <li><strong>Mode USB Scanner:</strong> Klik kolom input dan scan QR Code</li>
                     <li>Tunggu konfirmasi berhasil</li>
                  </ol>
               </div>
               <div class="col-md-6">
                  <h6><b>Tips Sukses:</b></h6>
                  <ul>
                     <li>Gunakan USB Scanner untuk scan lebih cepat dan akurat</li>
                     <li>Pastikan pencahayaan cukup (untuk mode kamera)</li>
                     <li>QR Code harus terlihat jelas</li>
                     <li>Pastikan koneksi internet stabil</li>
                  </ul>
               </div>
            </div>
            <hr>
            <div class="alert alert-info">
               <i class="material-icons mr-2">info</i>
               <strong>Catatan:</strong> Jika mengalami masalah, segera hubungi admin atau IT support.
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>

<?= $this->endSection(); ?>
