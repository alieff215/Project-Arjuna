<?= $this->extend('templates/user_page_layout'); ?>

<?= $this->section('content'); ?>
<style>
   .scan-header {
      margin-top: 2rem;
      margin-bottom: 2rem;
      padding-top: 1.5rem;
      padding-bottom: 1.5rem;
      padding-left: 1rem;
      padding-right: 1rem;
   }
   
   .scan-header h2 {
      font-size: 2rem;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 0.5rem;
   }
   
   .scan-header p {
      font-size: 1rem;
      font-weight: 400;
      margin-bottom: 0;
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
      margin-left: 0;
      padding-left: 1rem;
      padding-right: 1rem;
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
      
      .scan-header .btn {
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
      
      #preview {
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
      
      #preview {
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
      max-width: 400px;
      min-width: 300px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      border-radius: 8px;
      animation: slideInRight 0.3s ease-out;
   }

   .notification-content {
      background: white;
      border-radius: 8px;
      overflow: hidden;
   }

   .notification-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 20px;
      border-bottom: 1px solid #e9ecef;
   }

   .notification-header h5 {
      margin: 0;
      font-weight: 600;
   }

   .notification-body {
      padding: 15px 20px;
   }

   .notification-success .notification-header {
      background: #d4edda;
      color: #155724;
   }

   .notification-error .notification-header {
      background: #f8d7da;
      color: #721c24;
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
         <!-- Header dengan Button Kembali -->
         <div class="row mb-4">
            <div class="col-12">
               <div class="d-flex justify-content-between align-items-center scan-header">
                  <div>
                    <br>
                     <h2><b>Absensi Karyawan dan Admin Berbasis QR Code</b></h2>
                     <p class="text-muted">Sistem absensi menggunakan QR Code</p>
                  </div>
                  <div>
                     <a href="<?= base_url('scan'); ?>" class="btn btn-secondary">
                        <i class="material-icons mr-2">arrow_back</i>
                        Kembali
                     </a>
                  </div>
               </div>
               <hr class="mt-3">
            </div>
         </div>
         
         <div class="row mx-auto">
            <div class="col-lg-3 col-xl-4">
               <div class="card shadow-sm">
                  <div class="card-body">
                     <h4 class="mb-3"><b>Tips Penggunaan</b></h4>
                     <div class="mb-3">
                        <div class="d-flex align-items-start mb-2">
                           <i class="material-icons text-success mr-2" style="font-size: 20px;">visibility</i>
                           <small>Tunjukkan QR Code sampai terlihat jelas di kamera</small>
                        </div>
                        <div class="d-flex align-items-start mb-2">
                           <i class="material-icons text-success mr-2" style="font-size: 20px;">center_focus_strong</i>
                           <small>Posisikan QR Code tidak terlalu jauh maupun terlalu dekat</small>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6 col-xl-4">
               <div class="card shadow-sm">
                  <div class="card-header card-header-primary">
                     <div class="row align-items-center">
                        <div class="col">
                           <h4 class="card-title mb-1"><b>Absen <?= $waktu; ?></b></h4>
                           <p class="card-category mb-0">Silahkan tunjukkan QR Code anda</p>
                        </div>
                        <div class="col-auto">
                           <a href="<?= base_url("scan/$oppBtn"); ?>" class="btn btn-<?= $oppBtn == 'masuk' ? 'success' : 'warning'; ?> btn-sm">
                              <i class="material-icons mr-1" style="font-size: 18px;">swap_horiz</i>
                              Absen <?= $oppBtn; ?>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <!-- Toggle Scan Mode -->
                     <div class="mb-3">
                        <label class="form-label"><b>Mode Scan</b></label>
                        <div class="btn-group w-100" role="group">
                           <input type="radio" class="btn-check" name="scanMode" id="cameraMode" value="camera" checked>
                           <label class="btn btn-outline-primary" for="cameraMode">
                              <i class="material-icons mr-1" style="font-size: 16px;">camera_alt</i>
                              Kamera
                           </label>
                           
                           <input type="radio" class="btn-check" name="scanMode" id="usbMode" value="usb">
                           <label class="btn btn-outline-primary" for="usbMode">
                              <i class="material-icons mr-1" style="font-size: 16px;">usb</i>
                              USB Scanner
                           </label>
                        </div>
                     </div>

                     <!-- Camera Mode Section -->
                     <div id="cameraModeSection">
                        <div class="mb-3">
                           <label class="form-label"><b>Pilih Kamera</b></label>
                           <select id="pilihKamera" class="form-select" aria-label="Pilih kamera">
                              <option selected>Pilih kamera yang tersedia</option>
                           </select>
                        </div>

                        <div class="mb-3">
                           <div class="previewParent border rounded" style="background: #f8f9fa;">
                              <div class="text-center py-4" id="searching">
                                 <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                 </div>
                                 <p class="mt-2 mb-0"><b>Mencari kamera...</b></p>
                              </div>
                              <video id="preview" class="w-100 rounded" style="height: 300px; object-fit: cover; display: none;"></video>
                           </div>
                        </div>
                     </div>

                     <!-- USB Scanner Mode Section -->
                     <div id="usbModeSection" style="display: none;">
                        <div class="mb-3">
                           <label class="form-label"><b>Scan QR Code dengan USB Scanner</b></label>
                           <input type="text" id="usbScanInput" class="form-control form-control-lg" placeholder="Arahkan scanner ke QR Code..." autocomplete="off">
                           <small class="text-muted">Klik pada kolom input ini, lalu scan QR Code dengan USB scanner Anda</small>
                        </div>
                        <div class="alert alert-info">
                           <i class="material-icons mr-2" style="font-size: 18px;">info</i>
                           <strong>Petunjuk:</strong> Pastikan kursor ada di kolom input, lalu arahkan USB scanner ke QR Code. Sistem akan otomatis memproses setelah scan.
                        </div>
                     </div>

                     <form id="formAbsen" action="<?= base_url('scan/cek'); ?>" method="post">
                        <input type="hidden" name="unique_code" id="unique_code">
                        <input type="hidden" name="waktu" value="<?= strtolower($waktu); ?>">
                     </form>

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
               <div class="card shadow-sm">
                  <div class="card-body">
                     <h4 class="mb-3"><b>Informasi</b></h4>
                     <div class="mb-4">
                        <div class="d-flex align-items-start mb-2">
                           <i class="material-icons text-info mr-2" style="font-size: 20px;">check_circle</i>
                           <small>Pastikan QR Code dalam kondisi baik</small>
                        </div>
                        <div class="d-flex align-items-start mb-2">
                           <i class="material-icons text-info mr-2" style="font-size: 20px;">wifi</i>
                           <small>Pastikan koneksi internet stabil</small>
                        </div>
                        <div class="d-flex align-items-start mb-2">
                           <i class="material-icons text-info mr-2" style="font-size: 20px;">support_agent</i>
                           <small>Jika ada masalah, hubungi admin</small>
                        </div>
                     </div>
                     
                     <!-- Button Logout untuk User -->
                     <div class="d-grid">
                        <a href="<?= base_url('logout'); ?>" class="btn btn-danger">
                           <i class="material-icons mr-2">logout</i>
                           Logout
                        </a>
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
      audio.play();
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
   const preview = document.getElementById('preview');

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
            $('#preview').show();
            $('#searching').hide();

            codeReader.decodeOnceFromVideoDevice(selectedDeviceId, 'preview')
               .then(result => {
                  console.log(result.text);
                  audio.play();
                  cekData(result.text);

                  $('#preview').hide();
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
      
      // Set body content
      let bodyContent = '<div class="row">';
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
      bodyContent += '<div class="col">';
      bodyContent += `<p><strong>Jam masuk:</strong> <span class="text-info">${data.presensi.jam_masuk || '-'}</span></p>`;
      bodyContent += `<p><strong>Jam pulang:</strong> <span class="text-info">${data.presensi.jam_keluar || '-'}</span></p>`;
      bodyContent += '</div>';
      bodyContent += '</div>';
      
      // Tambahkan tombol untuk scan selanjutnya
      bodyContent += '<div class="row mt-3">';
      bodyContent += '<div class="col-12 text-center">';
      bodyContent += '<button class="btn btn-success btn-sm" onclick="prepareNextScan()">';
      bodyContent += '<i class="material-icons mr-1" style="font-size: 16px;">refresh</i>';
      bodyContent += 'Scan Karyawan Selanjutnya';
      bodyContent += '</button>';
      bodyContent += '</div>';
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
      $('#preview').show();
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
