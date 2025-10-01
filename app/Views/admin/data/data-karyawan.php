<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <?php if (session()->getFlashdata('msg')) : ?>
               <div class="pb-2 px-3">
                  <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success'  ?> ">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="material-icons">close</i>
                     </button>
                     <?= session()->getFlashdata('msg') ?>
                  </div>
               </div>
            <?php endif; ?>
            <a class="btn btn-primary ml-3 pl-3 py-3" href="<?= base_url('admin/karyawan/create'); ?>">
               <i class="material-icons mr-2">add</i> Tambah data karyawan
            </a>
            <a class="btn btn-primary ml-3 pl-3 py-3" href="<?= base_url('admin/karyawan/bulk'); ?>">
               <i class="material-icons mr-2">add</i> Import CSV
            </a>
            <button class="btn btn-danger ml-3 pl-3 py-3 btn-table-delete" onclick="deleteSelectedKaryawan('Data yang sudah dihapus tidak bisa kembalikan');"><i class="material-icons mr-2">delete_forever</i>Bulk Delete</button>
            <div class="card">
               <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                     <div class="row">
                        <div class="col-md-2">
                           <h4 class="card-title"><b>Daftar Karyawan</b></h4>
                           <p class="card-category">Angkatan <?= $generalSettings->company_year; ?></p>
                        </div>
                        <div class="col-md-4">
                           <div class="nav-tabs-wrapper">
                              <span class="nav-tabs-title">Departemen:</span>
                              <ul class="nav nav-tabs" data-tabs="tabs">
                                 <li class="nav-item">
                                    <a class="nav-link active" onclick="departemen = null; trig()" href="#" data-toggle="tab">
                                       <i class="material-icons">check</i> Semua
                                       <div class="ripple-container"></div>
                                    </a>
                                 </li>
                                 <?php
                                 $tempDepartemen = [];
                                 foreach ($departemen as $value) : ?>
                                    <?php if (!in_array($value['departemen'], $tempDepartemen)) : ?>
                                       <li class="nav-item">
                                          <a class="nav-link" onclick="departemen = '<?= $value['departemen']; ?>'; trig()" href="#" data-toggle="tab">
                                             <i class="material-icons">company</i> <?= $value['departemen']; ?>
                                             <div class="ripple-container"></div>
                                          </a>
                                       </li>
                                       <?php array_push($tempDepartemen, $value['departemen']) ?>
                                    <?php endif; ?>
                                 <?php endforeach; ?>
                              </ul>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="nav-tabs-wrapper">
                              <span class="nav-tabs-title">Karyawan:</span>
                              <ul class="nav nav-tabs" data-tabs="tabs">
                                 <li class="nav-item">
                                    <a class="nav-link active" onclick="karyawan = null; trig()" href="#" data-toggle="tab">
                                       <i class="material-icons">check</i> Semua
                                       <div class="ripple-container"></div>
                                    </a>
                                 </li>
                                 <?php foreach ($jabatan as $value) : ?>
                                    <li class="nav-item">
                                       <a class="nav-link" onclick="jabatan = '<?= $value['jabatan']; ?>'; trig();" href="#" data-toggle="tab">
                                          <i class="material-icons">work</i> <?= $value['jabatan']; ?>
                                          <div class="ripple-container"></div>
                                       </a>
                                    </li>
                                 <?php endforeach; ?>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div id="dataKaryawan">
                  <p class="text-center mt-3">Daftar karyawan muncul disini</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   var departemen = null;
   var jabatan = null;

   getDataKaryawan(departemen, jabatan);

   function trig() {
      getDataKaryawan(departemen, jabatan);
   }

   function getDataKaryawan(_departemen = null, _karyawan = null) {
      jQuery.ajax({
         url: "<?= base_url('/admin/karyawan'); ?>",
         type: 'post',
         data: {
            'departemen': _departemen,
            'karyawan': _karyawan
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
   }

   document.addEventListener('DOMContentLoaded', function() {
      $("#checkAll").click(function(e) {
         console.log(e);
         $('input:checkbox').not(this).prop('checked', this.checked);
      });
   });
</script>
<?= $this->endSection() ?>