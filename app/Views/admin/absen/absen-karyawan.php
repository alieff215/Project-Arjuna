<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-body">
                  <div class="row justify-content-between">
                     <div class="col">
                        <div class="pt-3 pl-3">
                           <h4><b>Daftar Departemen</b></h4>
                           <p>Silakan pilih departemen</p>
                        </div>
                     </div>
                  </div>

                  <div class="card-body pt-1 px-3">
                     <div class="row">
                        <?php foreach ($departemen as $value) : ?>
                           <?php
                           $idDepartemen = $value['id_departemen'];
                           $namaDepartemen =  $value['departemen'] . ' ' . $value['jabatan'];
                           ?>
                           <div class="col-md-3">
                              <button id="departemen-<?= $idDepartemen; ?>" onclick="getKaryawan(<?= $idDepartemen; ?>, '<?= $namaDepartemen; ?>')" class="btn btn-primary w-100">
                                 <?= $namaDepartemen; ?>
                              </button>
                           </div>
                        <?php endforeach; ?>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-3">
                        <div class="pt-3 pl-3 pb-2">
                           <h4><b>Tanggal</b></h4>
                           <input class="form-control" type="date" name="tangal" id="tanggal" value="<?= date('Y-m-d'); ?>" onchange="onDateChange()">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card" id="dataKaryawan">
         <div class="card-body">
            <div class="row justify-content-between">
               <div class="col-auto me-auto">
                  <div class="pt-3 pl-3">
                     <h4><b>Absen Karyawan</b></h4>
                     <p>Daftar karyawan muncul disini</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Modal ubah kehadiran -->
   <div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="modalUbahKehadiran" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="modalUbahKehadiran">Ubah kehadiran</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div id="modalFormUbahKaryawan"></div>
         </div>
      </div>
   </div>
</div>
<script>
   var lastIdDepartemen;
   var lastDepartemen;

   function onDateChange() {
      if (lastIdDepartemen != null && lastDepartemen != null) getKaryawan(lastIdDepartemen, lastDepartemen);
   }

   function getKaryawan(idDepartemen, departemen) {
      var tanggal = $('#tanggal').val();

      updateBtn(idDepartemen);

      jQuery.ajax({
         url: "<?= base_url('/admin/absen-karyawan'); ?>",
         type: 'post',
         data: {
            'departemen': departemen,
            'id_departemen': idDepartemen,
            'tanggal': tanggal
         },
         success: function(response, status, xhr) {
            // console.log(status);
            $('#dataKaryawan').html(response);

            $('html, body').animate({
               scrollTop: $("#dataKaryawan").offset().top
            }, 500);
         },
         error: function(xhr, status, thrown) {
            console.log(thrown);
            $('#dataKaryawan').html(thrown);
         }
      });

      lastIdDepartemen = idDepartemen;
      lastDepartemen = departemen;
   }

   function updateBtn(id_btn) {
      for (let index = 1; index <= <?= count($departemen); ?>; index++) {
         if (index != id_btn) {
            $('#departemen-' + index).removeClass('btn-success');
            $('#departemen-' + index).addClass('btn-primary');
         } else {
            $('#departemen-' + index).removeClass('btn-primary');
            $('#departemen-' + index).addClass('btn-success');
         }
      }
   }

   function getDataKehadiran(idPresensi, idKaryawan) {
      jQuery.ajax({
         url: "<?= base_url('/admin/absen-karyawan/kehadiran'); ?>",
         type: 'post',
         data: {
            'id_presensi': idPresensi,
            'id_karyawan': idKaryawan
         },
         success: function(response, status, xhr) {
            // console.log(status);
            $('#modalFormUbahKaryawan').html(response);
         },
         error: function(xhr, status, thrown) {
            console.log(thrown);
            $('#modalFormUbahKaryawan').html(thrown);
         }
      });
   }

   function ubahKehadiran() {
      var tanggal = $('#tanggal').val();

      var form = $('#formUbah').serializeArray();

      form.push({
         name: 'tanggal',
         value: tanggal
      });

      console.log(form);

      jQuery.ajax({
         url: "<?= base_url('/admin/absen-karyawan/edit'); ?>",
         type: 'post',
         data: form,
         success: function(response, status, xhr) {
            // console.log(status);

            if (response['status']) {
               getKaryawan(lastIdDepartemen, lastDepartemen);
               alert('Berhasil ubah kehadiran : ' + response['nama_karyawan']);
            } else {
               alert('Gagal ubah kehadiran : ' + response['nama_karyawan']);
            }
         },
         error: function(xhr, status, thrown) {
            console.log(thrown);
            alert('Gagal ubah kehadiran\n' + thrown);
         }
      });
   }
</script>
<?= $this->endSection() ?>