<?= $this->extend('templates/starting_page_layout'); ?>

<?= $this->section('navaction') ?>
<div class="d-flex gap-2">
   <a href="<?= base_url('/admin'); ?>" class="btn btn-secondary">
      <i class="material-icons mr-2">arrow_back</i>
      Kembali
   </a>
   <a href="<?= base_url('/admin'); ?>" class="btn btn-primary">
      <i class="material-icons mr-2">dashboard</i>
      Dashboard
   </a>
</div>
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<style>
   .scan-header {
      margin-top: 2rem;
      margin-bottom: 2rem;
      padding: 2rem;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
      border-radius: 16px;
      border-left: 4px solid #667eea;
   }
   
   .scan-header h2 {
      font-size: 2.25rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: 0.5rem;
      color: #1f2937;
   }
   
   .scan-header p {
      font-size: 1.05rem;
      font-weight: 400;
      margin-bottom: 0;
      color: #6b7280;
   }
   
   /* Memastikan garis tidak bertabrakan */
   .scan-header + hr {
      margin-left: 1.5rem;
      margin-right: 1.5rem;
      margin-top: 2rem;
      margin-bottom: 0;
   }
   
   /* Memastikan tidak bertabrakan dengan sidebar */
   .container-fluid {
      margin-left: auto;
      margin-right: auto;
      padding-left: 1rem;
      padding-right: 1rem;
      max-width: 1400px;
   }
   
   /* Mobile-first improvements */
   .previewParent {
      position: relative;
      overflow: hidden;
      border-radius: 8px;
   }
   
   .previewParent::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 200px;
      height: 200px;
      border: 2px solid #007bff;
      border-radius: 8px;
      pointer-events: none;
      z-index: 10;
      opacity: 0.7;
   }
   
   .previewParent::after {
      content: 'Arahkan kamera ke QR Code';
      position: absolute;
      bottom: 10px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 5px 10px;
      border-radius: 4px;
      font-size: 0.8rem;
      pointer-events: none;
      z-index: 10;
   }
   
   /* Responsive Design */
   @media (max-width: 1200px) {
      .col-xl-4 {
         flex: 0 0 50%;
         max-width: 50%;
      }
   }
   
   @media (max-width: 992px) {
      .col-lg-3, .col-lg-6 {
         flex: 0 0 100%;
         max-width: 100%;
         margin-bottom: 1rem;
      }
      
      .card-body {
         padding: 1rem;
      }
   }
   
   @media (max-width: 768px) {
      .scan-header h2 {
         font-size: 1.5rem;
      }
      
      .scan-header {
         margin-top: 1rem;
         margin-bottom: 1.5rem;
         padding-top: 1rem;
         padding-bottom: 1rem;
         flex-direction: column;
         align-items: flex-start !important;
      }
      
      .scan-header .badge {
         margin-top: 0.5rem;
         align-self: flex-start;
      }
      
      .container-fluid {
         padding-left: 0.5rem;
         padding-right: 0.5rem;
      }
      
      .scan-header + hr {
         margin-left: 1rem;
         margin-right: 1rem;
         margin-top: 1.5rem;
      }
      
      .card-header .row {
         flex-direction: column;
         align-items: flex-start !important;
      }
      
      .card-header .col-auto {
         margin-top: 0.5rem;
         width: 100%;
      }
      
      .card-header .btn {
         width: 100%;
      }
      
      .previewParent {
         height: 250px !important;
      }
      
      .previewParent::before {
         width: 150px;
         height: 150px;
      }
      
      #previewKamera {
         height: 250px !important;
      }
      
      .form-select {
         font-size: 0.9rem;
      }
   }
   
   @media (max-width: 576px) {
      .scan-header h2 {
         font-size: 1.25rem;
      }
      
      .scan-header p {
         font-size: 0.9rem;
      }
      
      .card-title {
         font-size: 1.1rem;
      }
      
      .card-category {
         font-size: 0.85rem;
      }
      
      .previewParent {
         height: 200px !important;
      }
      
      .previewParent::before {
         width: 120px;
         height: 120px;
      }
      
      .previewParent::after {
         font-size: 0.7rem;
         padding: 3px 8px;
      }
      
      #previewKamera {
         height: 200px !important;
      }
      
      .notification-floating {
         top: 5px;
         right: 5px;
         left: 5px;
         max-width: none;
         min-width: auto;
         font-size: 0.9rem;
      }
      
      .notification-header {
         padding: 10px 15px;
      }
      
      .notification-body {
         padding: 10px 15px;
      }
   }

   /* Floating Notification Styles */
   .notification-floating {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
      max-width: 420px;
      min-width: 320px;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      border-radius: 16px;
      animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
   }

   .notification-content {
      background: white;
      border-radius: 16px;
      overflow: hidden;
   }

   .notification-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 24px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      position: relative;
   }

   .notification-header::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
   }

   .notification-header h5 {
      margin: 0;
      font-weight: 700;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      gap: 10px;
   }

   .notification-header h5::before {
      content: '';
      width: 8px;
      height: 8px;
      border-radius: 50%;
      display: inline-block;
   }

   .notification-body {
      padding: 20px 24px;
      background: #f9fafb;
   }

   .notification-body p {
      margin-bottom: 0.5rem;
      font-size: 0.95rem;
      color: #374151;
   }

   .notification-body p strong {
      color: #1f2937;
      font-weight: 600;
   }

   .notification-success .notification-header {
      background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
      color: #065f46;
   }

   .notification-success .notification-header::before {
      background: #10b981;
   }

   .notification-success .notification-header h5::before {
      background: #10b981;
   }

   .notification-error .notification-header {
      background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
      color: #991b1b;
   }

   .notification-error .notification-header::before {
      background: #ef4444;
   }

   .notification-error .notification-header h5::before {
      background: #ef4444;
   }

   .btn-close {
      background: none;
      border: none;
      font-size: 1.2rem;
      cursor: pointer;
      padding: 0;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
   }

   @keyframes slideInRight {
      from {
         transform: translateX(100%);
         opacity: 0;
      }
      to {
         transform: translateX(0);
         opacity: 1;
      }
   }

   @media (max-width: 768px) {
      .notification-floating {
         top: 10px;
         right: 10px;
         left: 10px;
         max-width: none;
         min-width: auto;
      }
   }
</style>

<?php
   $oppBtn = '';

   $waktu == 'Masuk' ? $oppBtn = 'pulang' : $oppBtn = 'masuk';
   ?>
<div class="container-fluid">
         <!-- Header dengan Informasi -->
         <div class="row mb-4">
            <div class="col-12">
               <div class="d-flex justify-content-between align-items-center scan-header">
                  <div>
                    <br>
                     <h2><b>Absensi Karyawan dan Admin Berbasis QR Code</b></h2>
                     <p class="text-muted">Sistem absensi menggunakan QR Code - Mode Admin</p>
                  </div>
                  <div class="badge bg-info text-white px-3 py-2">
                     <i class="material-icons mr-1" style="font-size: 18px;">admin_panel_settings</i>
                     Mode Admin
                  </div>
               </div>
               <hr class="mt-3">
            </div>
         </div>
         
         <div class="row g-4 justify-content-center">
            <div class="col-lg-3 col-xl-4">
               <div class="card shadow-sm border-0" style="border-radius: 16px; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);">
                  <div class="card-body">
                     <h4 class="mb-4" style="font-weight: 700; color: #1f2937;">
                        <i class="material-icons mr-2" style="vertical-align: middle; color: #10b981;">lightbulb</i>
                        Tips Penggunaan
                     </h4>
                     <div class="mb-3">
                        <div class="d-flex align-items-start mb-3 p-3" style="background: white; border-radius: 12px; border-left: 4px solid #10b981;">
                           <i class="material-icons text-success mr-3" style="font-size: 24px; margin-top: 2px;">visibility</i>
                           <div>
                              <strong style="color: #1f2937; display: block; margin-bottom: 4px;">Tunjukkan QR Code dengan jelas</strong>
                              <small class="text-muted">Pastikan QR Code terlihat jelas di kamera</small>
                           </div>
                        </div>
                        <div class="d-flex align-items-start p-3" style="background: white; border-radius: 12px; border-left: 4px solid #10b981;">
                           <i class="material-icons text-success mr-3" style="font-size: 24px; margin-top: 2px;">center_focus_strong</i>
                           <div>
                              <strong style="color: #1f2937; display: block; margin-bottom: 4px;">Posisikan dengan benar</strong>
                              <small class="text-muted">Jaga jarak optimal antara QR Code dan kamera</small>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6 col-xl-4">
               <div class="card shadow-sm border-0" style="border-radius: 16px;">
                  <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 16px 16px 0 0; padding: 1.5rem;">
                     <div class="row align-items-center">
                        <div class="col">
                           <h4 class="card-title mb-1" style="font-weight: 700; font-size: 1.5rem;">
                              <i class="material-icons mr-2" style="vertical-align: middle; font-size: 28px;">qr_code_scanner</i>
                              Absen <?= $waktu; ?>
                           </h4>
                           <p class="card-category mb-0" style="opacity: 0.9; font-size: 0.95rem;">Silahkan tunjukkan QR Code anda</p>
                        </div>
                        <div class="col-auto">
                           <a href="<?= base_url("scan/$oppBtn"); ?>" class="btn btn-light btn-sm" style="border-radius: 8px; font-weight: 600;">
                              <i class="material-icons mr-1" style="font-size: 18px; vertical-align: middle;">swap_horiz</i>
                              Absen <?= $oppBtn; ?>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="card-body" style="padding: 2rem;">
                     <!-- Toggle Scan Mode -->
                     <div class="mb-4">
                        <label class="form-label" style="font-weight: 600; color: #1f2937; font-size: 1rem; margin-bottom: 0.75rem;">
                           <i class="material-icons mr-2" style="vertical-align: middle; font-size: 20px;">settings</i>
                           Mode Scan
                        </label>
                        <div class="btn-group w-100" role="group" style="box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 12px; overflow: hidden;">
                           <input type="radio" class="btn-check" name="scanMode" id="cameraMode" value="camera" checked>
                           <label class="btn btn-outline-primary" for="cameraMode" style="border-radius: 0; font-weight: 600; padding: 12px;">
                              <i class="material-icons mr-2" style="font-size: 20px; vertical-align: middle;">camera_alt</i>
                              Kamera
                           </label>
                           
                           <input type="radio" class="btn-check" name="scanMode" id="usbMode" value="usb">
                           <label class="btn btn-outline-primary" for="usbMode" style="border-radius: 0; font-weight: 600; padding: 12px;">
                              <i class="material-icons mr-2" style="font-size: 20px; vertical-align: middle;">usb</i>
                              USB Scanner
                           </label>
                        </div>
                     </div>

                     <!-- Camera Mode Section -->
                     <div id="cameraModeSection">
                        <div class="mb-4">
                           <label class="form-label" style="font-weight: 600; color: #1f2937; font-size: 1rem; margin-bottom: 0.75rem;">
                              <i class="material-icons mr-2" style="vertical-align: middle; font-size: 20px;">videocam</i>
                              Pilih Kamera
                           </label>
                           <select id="pilihKamera" class="form-select" aria-label="Pilih kamera" style="border-radius: 12px; padding: 12px; border: 2px solid #e5e7eb; font-size: 0.95rem;">
                              <option selected>Pilih kamera yang tersedia</option>
                           </select>
                        </div>

                        <div class="mb-3">
                           <div class="previewParent border rounded" style="background: #f8f9fa; border-radius: 16px; overflow: hidden; border: 2px solid #e5e7eb !important;">
                              <div class="text-center py-5" id="searching">
                                 <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">Loading...</span>
                                 </div>
                                 <p class="mt-2 mb-0" style="font-weight: 600; color: #4b5563; font-size: 1rem;">
                                    <i class="material-icons mr-2" style="vertical-align: middle;">search</i>
                                    Mencari kamera...
                                 </p>
                              </div>
                              <video id="previewKamera" class="w-100 rounded" style="height: 350px; object-fit: cover; display: none;"></video>
                           </div>
                        </div>
                     </div>

                     <!-- USB Scanner Mode Section -->
                     <div id="usbModeSection" style="display: none;">
                        <div class="mb-4">
                           <label class="form-label" style="font-weight: 600; color: #1f2937; font-size: 1rem; margin-bottom: 0.75rem;">
                              <i class="material-icons mr-2" style="vertical-align: middle; font-size: 20px;">keyboard</i>
                              Scan QR Code dengan USB Scanner
                           </label>
                           <input type="text" id="usbScanInput" class="form-control form-control-lg" placeholder="Arahkan USB Scanner ke QR Code dan scan..." autofocus style="font-size: 1.1rem; padding: 18px; border-radius: 12px; border: 2px solid #e5e7eb; font-weight: 500;">
                           <small class="text-muted d-block mt-2" style="font-size: 0.875rem;">
                              <i class="material-icons mr-1" style="vertical-align: middle; font-size: 16px;">info</i>
                              Klik pada kolom input ini, lalu scan QR Code dengan USB scanner Anda
                           </small>
                        </div>
                        <div class="alert alert-info">
                           <i class="material-icons mr-2" style="font-size: 18px;">info</i>
                           <strong>Petunjuk:</strong> Pastikan kursor ada di kolom input, lalu arahkan USB scanner ke QR Code. Sistem akan otomatis memproses setelah scan.
                        </div>
                     </div>

                     <div id="hasilScan" class="mt-3"></div>

                     <!-- Floating Notification -->
                     <div id="notification" class="notification-floating" style="display: none;">
                        <div class="notification-content">
                           <div class="notification-header">
                              <h5 id="notification-title"></h5>
                              <button type="button" class="btn-close" onclick="hideNotification()"></button>
                           </div>
                           <div class="notification-body" id="notification-body">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-xl-4">
               <div class="card shadow-sm border-0" style="border-radius: 16px; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);">
                  <div class="card-body">
                     <h4 class="mb-4" style="font-weight: 700; color: #1f2937;">
                        <i class="material-icons mr-2" style="vertical-align: middle; color: #3b82f6;">book</i>
                        Panduan Penggunaan
                     </h4>
                     <div class="mb-4">
                        <div class="d-flex align-items-start mb-3 p-3" style="background: white; border-radius: 12px; border-left: 4px solid #3b82f6;">
                           <i class="material-icons text-info mr-3" style="font-size: 24px; margin-top: 2px;">qr_code_scanner</i>
                           <div>
                              <strong style="color: #1f2937; display: block; margin-bottom: 4px;">Data muncul setelah scan</strong>
                              <small class="text-muted">Data karyawan/admin akan muncul di bawah preview kamera</small>
                           </div>
                        </div>
                        <div class="d-flex align-items-start mb-3 p-3" style="background: white; border-radius: 12px; border-left: 4px solid #3b82f6;">
                           <i class="material-icons text-info mr-3" style="font-size: 24px; margin-top: 2px;">swap_horiz</i>
                           <div>
                              <strong style="color: #1f2937; display: block; margin-bottom: 4px;">Ubah waktu absensi</strong>
                              <small class="text-muted">Klik tombol <b><span class="text-success">Absen masuk</span> / <span class="text-warning">Absen pulang</span></b> untuk mengubah</small>
                           </div>
                        </div>
                        <div class="d-flex align-items-start mb-3 p-3" style="background: white; border-radius: 12px; border-left: 4px solid #3b82f6;">
                           <i class="material-icons text-info mr-3" style="font-size: 24px; margin-top: 2px;">dashboard</i>
                           <div>
                              <strong style="color: #1f2937; display: block; margin-bottom: 4px;">Lihat data absensi</strong>
                              <small class="text-muted">Klik tombol Dashboard untuk melihat data absensi</small>
                           </div>
                        </div>
                        <div class="d-flex align-items-start p-3" style="background: white; border-radius: 12px; border-left: 4px solid #3b82f6;">
                           <i class="material-icons text-info mr-3" style="font-size: 24px; margin-top: 2px;">admin_panel_settings</i>
                           <div>
                              <strong style="color: #1f2937; display: block; margin-bottom: 4px;">Akses halaman admin</strong>
                              <small class="text-muted">Anda harus login terlebih dahulu untuk mengakses halaman admin</small>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

<script type="text/javascript" src="<?= base_url('assets/js/plugins/zxing/zxing.min.js') ?>"></script>
<script src="<?= base_url('assets/js/core/jquery-3.5.1.min.js') ?>"></script>
<script type="text/javascript">
   let selectedDeviceId = null;
   let audio = new Audio("<?= base_url('assets/audio/beep.mp3'); ?>");
   const codeReader = new ZXing.BrowserMultiFormatReader();
   const sourceSelect = $('#pilihKamera');
   let currentMode = 'camera';

   // Toggle between Camera and USB Scanner mode
   $(document).on('change', 'input[name="scanMode"]', function() {
      currentMode = $(this).val();
      
      if (currentMode === 'camera') {
         // Show camera section, hide USB section
         $('#cameraModeSection').show();
         $('#usbModeSection').hide();
         
         // Stop any existing camera stream first
         if (codeReader) {
            codeReader.reset();
         }
         
         // Reinitialize scanner
         if (navigator.mediaDevices) {
            initScanner();
         }
      } else {
         // Show USB section, hide camera section
         $('#cameraModeSection').hide();
         $('#usbModeSection').show();
         
         // Stop camera
         if (codeReader) {
            codeReader.reset();
         }
         
         // Focus on USB input
         $('#usbScanInput').focus();
      }
   });

   // Handle USB Scanner Input
   let usbScanBuffer = '';
   let usbScanTimeout = null;
   
   $(document).on('input', '#usbScanInput', function(e) {
      clearTimeout(usbScanTimeout);
      usbScanBuffer = $(this).val();
      
      // Wait for scanner to finish (usually sends Enter key)
      usbScanTimeout = setTimeout(() => {
         if (usbScanBuffer.trim().length > 0) {
            processUSBScan(usbScanBuffer.trim());
            $(this).val(''); // Clear input
            usbScanBuffer = '';
         }
      }, 100);
   });

   // Handle Enter key for USB scanner
   $(document).on('keypress', '#usbScanInput', function(e) {
      if (e.which === 13) { // Enter key
         e.preventDefault();
         clearTimeout(usbScanTimeout);
         const code = $(this).val().trim();
         if (code.length > 0) {
            processUSBScan(code);
            $(this).val(''); // Clear input
            usbScanBuffer = '';
         }
      }
   });

   function processUSBScan(code) {
      console.log('USB Scanner detected code:', code);
      cekData(code);
      
      // Re-focus input for next scan after delay
      setTimeout(() => {
         $('#usbScanInput').focus();
      }, 2500);
   }

   $(document).on('change', '#pilihKamera', function() {
      selectedDeviceId = $(this).val();
      if (codeReader) {
         codeReader.reset();
         initScanner();
      }
   })

   const previewParent = document.getElementById('previewParent');
   const preview = document.getElementById('previewKamera');

   function initScanner() {
      codeReader.listVideoInputDevices()
         .then(videoInputDevices => {
            videoInputDevices.forEach(device =>
               console.log(`${device.label}, ${device.deviceId}`)
            );

            if (videoInputDevices.length < 1) {
               alert("Camera not found!");
               return;
            }

            if (selectedDeviceId == null) {
               if (videoInputDevices.length <= 1) {
                  selectedDeviceId = videoInputDevices[0].deviceId
               } else {
                  selectedDeviceId = videoInputDevices[1].deviceId
               }
            }

            if (videoInputDevices.length >= 1) {
               sourceSelect.html('');
               videoInputDevices.forEach((element) => {
                  const sourceOption = document.createElement('option')
                  sourceOption.text = element.label
                  sourceOption.value = element.deviceId
                  if (element.deviceId == selectedDeviceId) {
                     sourceOption.selected = 'selected';
                  }
                  sourceSelect.append(sourceOption)
               })
            }

            $('#previewParent').removeClass('unpreview');
            $('#previewKamera').show();
            $('#searching').hide();

            codeReader.decodeOnceFromVideoDevice(selectedDeviceId, 'previewKamera')
               .then(result => {
                  console.log(result.text);
                  cekData(result.text);

                  $('#previewKamera').hide();
                  $('#previewParent').addClass('unpreview');
                  $('#searching').show();

                  if (codeReader) {
                     codeReader.reset();

                     // delay 2,5 detik setelah berhasil meng-scan
                     setTimeout(() => {
                        initScanner();
                     }, 2500);
                  }
               })
               .catch(err => console.error(err));

         })
         .catch(err => console.error(err));
   }

   if (navigator.mediaDevices) {
      initScanner();
   } else {
      alert('Cannot access camera.');
   }

   async function cekData(code) {
      try {
         const response = await fetch("<?= base_url('scan/cek'); ?>", {
            method: 'POST',
            headers: {
               'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
               'unique_code': code,
               'waktu': '<?= strtolower($waktu); ?>'
            })
         });

         const result = await response.json();
         
         if (result.success) {
            showSuccessNotification(result);
         } else {
            showErrorNotification(result);
         }
      } catch (error) {
         console.error('Error:', error);
         showErrorNotification({
            success: false,
            message: 'Terjadi kesalahan saat memproses data'
         });
      }
   }

   function showSuccessNotification(data) {
      const notification = document.getElementById('notification');
      const title = document.getElementById('notification-title');
      const body = document.getElementById('notification-body');
      
      // Set title
      title.textContent = data.message;
      
      // Set body content dengan design yang lebih profesional
      let bodyContent = '<div style="background: white; border-radius: 12px; padding: 1rem; margin-bottom: 1rem;">';
      bodyContent += '<div class="row g-3">';
      bodyContent += '<div class="col-md-6">';
      bodyContent += '<div style="background: #f9fafb; padding: 1rem; border-radius: 10px; border-left: 3px solid #10b981;">';
      bodyContent += '<p style="margin: 0; font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 0.5rem;">Data Karyawan</p>';
      
      // Tampilkan data karyawan/admin
      if (data.data) {
         if (data.type === 'Karyawan' && data.data.nama_karyawan) {
            bodyContent += `<p style="margin: 0 0 0.5rem 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Nama:</strong> ${data.data.nama_karyawan || '-'}</p>`;
            bodyContent += `<p style="margin: 0 0 0.5rem 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">NIS:</strong> ${data.data.nis || '-'}</p>`;
            const dept = data.data.departemen || '';
            const jab = data.data.jabatan || '';
            const deptJab = `${dept} ${jab}`.trim();
            bodyContent += `<p style="margin: 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Departemen:</strong> ${deptJab || '-'}</p>`;
         } else if (data.type === 'Admin' && data.data.nama_admin) {
            bodyContent += `<p style="margin: 0 0 0.5rem 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Nama:</strong> ${data.data.nama_admin || '-'}</p>`;
            bodyContent += `<p style="margin: 0 0 0.5rem 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">NUPTK:</strong> ${data.data.nuptk || '-'}</p>`;
            bodyContent += `<p style="margin: 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">No HP:</strong> ${data.data.no_hp || '-'}</p>`;
         }
      }
      
      bodyContent += '</div>';
      bodyContent += '</div>';
      bodyContent += '<div class="col-md-6">';
      bodyContent += '<div style="background: #f9fafb; padding: 1rem; border-radius: 10px; border-left: 3px solid #3b82f6;">';
      bodyContent += '<p style="margin: 0; font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 0.5rem;">Waktu Absensi</p>';
      if (data.presensi) {
         bodyContent += `<p style="margin: 0 0 0.5rem 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Jam masuk:</strong> <span style="color: #3b82f6; font-weight: 600;">${data.presensi.jam_masuk || '-'}</span></p>`;
         bodyContent += `<p style="margin: 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Jam pulang:</strong> <span style="color: #3b82f6; font-weight: 600;">${data.presensi.jam_keluar || '-'}</span></p>`;
      } else {
         bodyContent += `<p style="margin: 0 0 0.5rem 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Jam masuk:</strong> <span style="color: #9ca3af;">-</span></p>`;
         bodyContent += `<p style="margin: 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Jam pulang:</strong> <span style="color: #9ca3af;">-</span></p>`;
      }
      bodyContent += '</div>';
      bodyContent += '</div>';
      bodyContent += '</div>';
      bodyContent += '</div>';
      
      // Tambahkan tombol untuk scan selanjutnya dengan design yang lebih menarik
      bodyContent += '<div class="text-center" style="padding-top: 0.5rem;">';
      bodyContent += '<button class="btn btn-success" onclick="prepareNextScan()" style="border-radius: 12px; padding: 12px 24px; font-weight: 600; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);">';
      bodyContent += '<i class="material-icons mr-2" style="vertical-align: middle; font-size: 20px;">refresh</i>';
      bodyContent += 'Scan Karyawan Selanjutnya';
      bodyContent += '</button>';
      bodyContent += '</div>';
      
      body.innerHTML = bodyContent;
      
      // Set notification class
      notification.className = 'notification-floating notification-success';
      notification.style.display = 'block';
      
      // Auto hide after 8 seconds dan auto refresh
      setTimeout(() => {
         hideNotification();
         prepareNextScan();
      }, 8000);
   }

   function showErrorNotification(data) {
      const notification = document.getElementById('notification');
      const title = document.getElementById('notification-title');
      const body = document.getElementById('notification-body');
      
      // Set title
      title.textContent = data.message;
      
      // Set body content
      let bodyContent = '';
      if (data.data) {
         bodyContent += '<div class="row">';
         bodyContent += '<div class="col">';
         
         if (data.type === 'Karyawan') {
            bodyContent += `<p><strong>Nama:</strong> ${data.data.nama_karyawan}</p>`;
            bodyContent += `<p><strong>NIS:</strong> ${data.data.nis}</p>`;
            bodyContent += `<p><strong>Departemen:</strong> ${data.data.departemen} ${data.data.jabatan}</p>`;
         } else if (data.type === 'Admin') {
            bodyContent += `<p><strong>Nama:</strong> ${data.data.nama_admin}</p>`;
            bodyContent += `<p><strong>NUPTK:</strong> ${data.data.nuptk}</p>`;
            bodyContent += `<p><strong>No HP:</strong> ${data.data.no_hp}</p>`;
         }
         
         bodyContent += '</div>';
         if (data.presensi) {
            bodyContent += '<div class="col">';
            bodyContent += `<p><strong>Jam masuk:</strong> <span class="text-info">${data.presensi.jam_masuk || '-'}</span></p>`;
            bodyContent += `<p><strong>Jam pulang:</strong> <span class="text-info">${data.presensi.jam_keluar || '-'}</span></p>`;
            bodyContent += '</div>';
         }
         bodyContent += '</div>';
      }
      
      body.innerHTML = bodyContent;
      
      // Set notification class
      notification.className = 'notification-floating notification-error';
      notification.style.display = 'block';
      
      // Auto hide after 5 seconds
      setTimeout(() => {
         hideNotification();
      }, 5000);
   }

   function hideNotification() {
      const notification = document.getElementById('notification');
      notification.style.display = 'none';
   }

   function prepareNextScan() {
      // Hide notification
      hideNotification();
      
      // Reset scanner state
      $('#previewParent').removeClass('unpreview');
      $('#previewKamera').show();
      $('#searching').hide();
      
      // Clear any previous results
      clearData();
      
      // Restart scanner
      if (codeReader) {
         codeReader.reset();
         setTimeout(() => {
            initScanner();
         }, 500);
      }
   }

   function clearData() {
      $('#hasilScan').html('');
   }
</script>

<?= $this->endSection(); ?>