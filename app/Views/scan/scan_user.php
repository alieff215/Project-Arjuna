<?= $this->extend('templates/user_page_layout'); ?>

<?= $this->section('content'); ?>
<?php
   $oppBtn = '';

   $waktu == 'Masuk' ? $oppBtn = 'pulang' : $oppBtn = 'masuk';
   ?>
<div class="main-panel">
   <div class="content">
      <div class="container-fluid">
         <div class="row mx-auto">
            <div class="col-lg-3 col-xl-4">
               <div class="card">
                  <div class="card-body">
                     <h3 class="mt-2"><b>Tips</b></h3>
                     <ul class="pl-3">
                        <li>Tunjukkan qr code sampai terlihat jelas di kamera</li>
                        <li>Posisikan qr code tidak terlalu jauh maupun terlalu dekat</li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="col-lg-6 col-xl-4">
               <div class="card">
                  <div class="col-10 mx-auto card-header card-header-primary">
                     <div class="row">
                        <div class="col">
                           <h4 class="card-title"><b>Absen <?= $waktu; ?></b></h4>
                           <p class="card-category">Silahkan tunjukkan QR Code anda</p>
                        </div>
                        <div class="col-md-auto">
                           <a href="<?= base_url("scan/$oppBtn"); ?>" class="btn btn-<?= $oppBtn == 'masuk' ? 'success' : 'warning'; ?>">
                              Absen <?= $oppBtn; ?>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="card-body my-auto px-5">
                     <h4 class="d-inline">Pilih kamera</h4>

                     <select id="pilihKamera" class="custom-select w-50 ml-2" aria-label="Default select example" style="height: 35px;">
                        <option selected>Select camera devices</option>
                     </select>

                     <div class="mt-3">
                        <video id="preview" class="w-100" style="height: 300px; object-fit: cover;"></video>
                     </div>

                     <div class="mt-3">
                        <form id="formAbsen" action="<?= base_url('scan/cekKode'); ?>" method="post">
                           <input type="hidden" name="unique_code" id="unique_code">
                           <input type="hidden" name="waktu" value="<?= strtolower($waktu); ?>">
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-xl-4">
               <div class="card">
                  <div class="card-body">
                     <h3 class="mt-2"><b>Informasi</b></h3>
                     <ul class="pl-3">
                        <li>Pastikan QR Code dalam kondisi baik</li>
                        <li>Pastikan koneksi internet stabil</li>
                        <li>Jika ada masalah, hubungi admin</li>
                     </ul>
                     
                     <!-- Button Logout untuk User -->
                     <div class="mt-4">
                        <a href="<?= base_url('logout'); ?>" class="btn btn-danger btn-block">
                           <i class="material-icons mr-2">logout</i>
                           Logout
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
<script>
   let scanner = null;

   // Daftar kamera yang tersedia
   navigator.mediaDevices.enumerateDevices()
      .then(devices => {
         const videoDevices = devices.filter(device => device.kind === 'videoinput');
         const select = document.getElementById('pilihKamera');
         
         videoDevices.forEach((device, index) => {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.text = device.label || `Camera ${index + 1}`;
            select.appendChild(option);
         });
      });

   // Event listener untuk perubahan kamera
   document.getElementById('pilihKamera').addEventListener('change', function() {
      const deviceId = this.value;
      if (scanner) {
         scanner.stop();
      }
      startScanner(deviceId);
   });

   // Fungsi untuk memulai scanner
   function startScanner(deviceId = null) {
      const config = {
         inputStream: {
            name: "Live",
            type: "LiveStream",
            target: document.querySelector('#preview'),
            constraints: {
               width: 640,
               height: 480,
               facingMode: "environment",
               deviceId: deviceId
            }
         },
         locator: {
            patchSize: "medium",
            halfSample: true
         },
         numOfWorkers: 2,
         frequency: 10,
         decoder: {
            readers: [
               "code_128_reader",
               "ean_reader",
               "ean_8_reader",
               "code_39_reader",
               "code_39_vin_reader",
               "codabar_reader",
               "upc_reader",
               "upc_e_reader",
               "i2of5_reader"
            ]
         },
         locate: true
      };

      Quagga.init(config, function(err) {
         if (err) {
            console.log(err);
            return;
         }
         console.log("Initialization finished. Ready to start");
         Quagga.start();
      });

      Quagga.onDetected(function(result) {
         const code = result.codeResult.code;
         document.getElementById('unique_code').value = code;
         document.getElementById('formAbsen').submit();
      });
   }

   // Mulai scanner dengan kamera default
   startScanner();
</script>
<?= $this->endSection(); ?>
