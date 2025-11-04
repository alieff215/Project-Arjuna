<?= $this->extend('templates/user_page_layout'); ?>

<?= $this->section('content'); ?>
<style>
   .scan-main-header {
      margin-top: 2rem;
      margin-bottom: 3rem;
      padding-top: 2rem;
      padding-bottom: 2rem;
      padding-left: 1rem;
      padding-right: 1rem;
   }
   
   .scan-main-header h1 {
      font-size: 2.5rem;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 1rem;
   }
   
   .scan-main-header .lead {
      font-size: 1.1rem;
      font-weight: 400;
      margin-bottom: 1.5rem;
   }
   
   /* Memastikan tidak bertabrakan dengan sidebar */
   .container-fluid {
      margin-left: 0;
      padding-left: 1rem;
      padding-right: 1rem;
   }
   
   @media (max-width: 768px) {
      .scan-main-header h1 {
         font-size: 2rem;
      }
      
      .scan-main-header {
         margin-top: 1rem;
         margin-bottom: 2rem;
         padding-top: 1rem;
         padding-bottom: 1rem;
      }
      
      .container-fluid {
         padding-left: 0.5rem;
         padding-right: 0.5rem;
      }
   }
</style>

<div class="container-fluid">
   <!-- Header Utama -->
   <div class="row mb-5">
      <div class="col-12">
         <div class="text-center scan-main-header">
            <br>
            <h1><b>Absensi Karyawan dan Admin Berbasis QR Code</b></h1>
            <p class="lead text-muted">Sistem absensi modern menggunakan teknologi QR Code untuk kemudahan dan keakuratan</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
               <span class="badge bg-primary px-3 py-2">
                  <i class="material-icons mr-1" style="font-size: 18px;">qr_code_scanner</i>
                  Scan QR Code
               </span>
               <span class="badge bg-warning px-3 py-2">
                  <i class="material-icons mr-1" style="font-size: 18px;">usb</i>
                  USB Scanner
               </span>
               <span class="badge bg-success px-3 py-2">
                  <i class="material-icons mr-1" style="font-size: 18px;">schedule</i>
                  Real-time
               </span>
               <span class="badge bg-info px-3 py-2">
                  <i class="material-icons mr-1" style="font-size: 18px;">security</i>
                  Secure
               </span>
            </div>
         </div>
      </div>
   </div>

   <!-- Menu Utama -->
   <div class="row mb-5">
      <div class="col-lg-4 col-md-6 mb-4">
         <div class="card h-100 shadow-sm border-0">
            <div class="card-body text-center p-4">
               <div class="mb-3">
                  <div class="bg-primary bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                     <i class="material-icons text-white" style="font-size: 40px;">login</i>
                  </div>
               </div>
               <h4 class="card-title mb-3">Absen Masuk</h4>
               <p class="card-text text-muted mb-4">Lakukan absensi masuk dengan memindai QR Code Anda</p>
               <a href="<?= base_url('scan/masuk'); ?>" class="btn btn-primary btn-lg w-100">
                  <i class="material-icons mr-2">arrow_forward</i>
                  Mulai Absen Masuk
               </a>
            </div>
         </div>
      </div>

      <div class="col-lg-4 col-md-6 mb-4">
         <div class="card h-100 shadow-sm border-0">
            <div class="card-body text-center p-4">
               <div class="mb-3">
                  <div class="bg-warning bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                     <i class="material-icons text-white" style="font-size: 40px;">logout</i>
                  </div>
               </div>
               <h4 class="card-title mb-3">Absen Pulang</h4>
               <p class="card-text text-muted mb-4">Lakukan absensi pulang dengan memindai QR Code Anda</p>
               <a href="<?= base_url('scan/pulang'); ?>" class="btn btn-warning btn-lg w-100">
                  <i class="material-icons mr-2">arrow_forward</i>
                  Mulai Absen Pulang
               </a>
            </div>
         </div>
      </div>

      <div class="col-lg-4 col-md-6 mb-4">
         <div class="card h-100 shadow-sm border-0">
            <div class="card-body text-center p-4">
               <div class="mb-3">
                  <div class="bg-info bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                     <i class="material-icons text-white" style="font-size: 40px;">help_outline</i>
                  </div>
               </div>
               <h4 class="card-title mb-3">Panduan</h4>
               <p class="card-text text-muted mb-4">Pelajari cara menggunakan sistem absensi QR Code</p>
               <button class="btn btn-info btn-lg w-100" data-bs-toggle="modal" data-bs-target="#panduanModal">
                  <i class="material-icons mr-2">book</i>
                  Lihat Panduan
               </button>
            </div>
         </div>
      </div>
   </div>


   <!-- Tips Penggunaan -->
   <div class="row">
      <div class="col-12 mb-4">
         <div class="card shadow-sm">
            <div class="card-body">
               <h4 class="mb-3"><b>Tips Penggunaan</b></h4>
               <div class="row">
                  <div class="col-lg-4 col-md-6 mb-3">
                     <div class="d-flex align-items-start">
                        <i class="material-icons text-success mr-2 mt-1">check_circle</i>
                        <div>
                           <h6 class="mb-1">Pastikan QR Code dalam kondisi baik</h6>
                           <small class="text-muted">QR Code harus jelas dan tidak rusak</small>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 mb-3">
                     <div class="d-flex align-items-start">
                        <i class="material-icons text-success mr-2 mt-1">check_circle</i>
                        <div>
                           <h6 class="mb-1">Posisikan QR Code dengan benar</h6>
                           <small class="text-muted">Jangan terlalu jauh atau terlalu dekat dari kamera</small>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 mb-3">
                     <div class="d-flex align-items-start">
                        <i class="material-icons text-success mr-2 mt-1">check_circle</i>
                        <div>
                           <h6 class="mb-1">Pastikan koneksi internet stabil</h6>
                           <small class="text-muted">Untuk sinkronisasi data yang optimal</small>
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
