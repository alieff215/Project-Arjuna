<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<style>
  .progress-karyawan {
    height: 5px;
    border-radius: 0px;
    background-color: rgb(186, 124, 222);
  }

  .progress-admin {
    height: 5px;
    border-radius: 0px;
    background-color: rgb(58, 192, 85);
  }

  .my-progress-bar {
    height: 5px;
    border-radius: 0px;
  }
</style>
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
        <div class="card">
          <div class="card-header card-header-danger">
            <h4 class="card-title"><b>Generate QR Code</b></h4>
            <p class="card-category">Generate QR berdasarkan kode unik data karyawan/admin</p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary"><b>Data Karyawan</b></h4>
                    <p>Total jumlah karyawan : <b><?= count($karyawan); ?></b>
                      <br>
                      <a href="<?= base_url('admin/karyawan'); ?>">Lihat data</a>
                    </p>
                    <div class="row px-2">
                      <div class="col-12 col-xl-6 px-1">
                        <button onclick="generateAllQrKaryawan()" class="btn btn-primary p-2 px-md-4 w-100">
                          <div class="d-flex align-items-center justify-content-center" style="gap: 12px;">
                            <div>
                              <i class="material-icons" style="font-size: 24px;">qr_code</i>
                            </div>
                            <div>
                              <h4 class="d-inline font-weight-bold">Generate All</h4>
                              <div id="progressKaryawan" class="d-none mt-2">
                                <span id="progressTextKaryawan"></span>
                                <i id="progressSelesaiKaryawan" class="material-icons d-none" class="d-none">check</i>
                                <div class="progress progress-Karyawan">
                                  <div id="progressBarKaryawan" class="progress-bar my-progress-bar bg-white" style="width: 0%;" role="progressbar" aria-valuenow="" aria-valuemin="" aria-valuemax=""></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </button>
                      </div>
                      <div class="col-12 col-xl-6 px-1">
                        <a href="<?= base_url('admin/qr/karyawan/download'); ?>" class="btn btn-primary p-2 px-md-4 w-100">
                          <div class="d-flex align-items-center justify-content-center" style="gap: 12px;">
                            <div>
                              <i class="material-icons" style="font-size: 24px;">cloud_download</i>
                            </div>
                            <div>
                              <div class="text-start">
                                <h4 class="d-inline font-weight-bold">Download All</h4>
                              </div>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                    <hr>
                    <br>
                    <h4 class="text-primary"><b>Generate per departemen</b></h4>
                    <form action="<?= base_url('admin/qr/karyawan/download'); ?>" method="get">
                      <select name="id_departemen" id="departemenSelect" class="custom-select mb-3" required>
                        <option value="">--Pilih departemen--</option>
                        <?php foreach ($departemen as $value) : ?>
                          <option id="idDepartemen<?= $value['id_departemen']; ?>" value="<?= $value['id_departemen']; ?>">
                            <?= $value['departemen'] . ' ' . $value['jabatan']; ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                      <b class="text-danger mt-2" id="textErrorDepartemen"></b>
                      <div class="row px-2">
                        <div class="col-12 col-xl-6 px-1">
                          <button type="button" onclick="generateQrKaryawanByDepartemen()" class="btn btn-primary p-2 px-md-4 w-100">
                            <div class="d-flex align-items-center justify-content-center" style="gap: 12px;">
                              <div>
                                <i class="material-icons" style="font-size: 24px;">qr_code</i>
                              </div>
                              <div>
                                <div class="text-start">
                                  <h6 class="d-inline">Generate per departemen</h6>
                                </div>
                                <div id="progressDepartemen" class="d-none">
                                  <span id="progressTextDepartemen"></span>
                                  <i id="progressSelesaiDepartemen" class="material-icons d-none" class="d-none">check</i>
                                  <div class="progress progress-karyawan d-none" id="progressBarBgDepartemen">
                                    <div id="progressBarDepartemen" class="progress-bar my-progress-bar bg-white" style="width: 0%;" role="progressbar" aria-valuenow="" aria-valuemin="" aria-valuemax=""></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </button>
                        </div>
                        <div class="col-12 col-xl-6 px-1">
                          <button type="submit" class="btn btn-primary p-2 px-md-4 w-100">
                            <div class="d-flex align-items-center justify-content-center" style="gap: 12px;">
                              <div>
                                <i class="material-icons" style="font-size: 24px;">cloud_download</i>
                              </div>
                              <div>
                                <div class="text-start">
                                  <h6 class="d-inline">Download Per Departemen</h6>
                                </div>
                              </div>
                            </div>
                          </button>
                        </div>
                      </div>
                    </form>
                    <br>
                    <p>
                      Untuk generate/download QR Code per masing-masing karyawan kunjungi
                      <a href="<?= base_url('admin/karyawan'); ?>"><b>data karyawan</b></a>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-success"><b>Data Admin</b></h4>
                    <p>Total jumlah admin : <b><?= count($admin); ?></b>
                      <br>
                      <a href="<?= base_url('admin/admin'); ?>" class="text-success">Lihat data</a>
                    </p>
                    <div class="row px-2">
                      <div class="col-12 col-xl-6 px-1">
                        <button onclick="generateAllQrAdmin()" class="btn btn-success p-2 px-md-4 w-100">
                          <div class="d-flex align-items-center justify-content-center" style="gap: 12px;">
                            <div>
                              <i class="material-icons" style="font-size: 24px;">qr_code</i>
                            </div>
                            <div>
                              <h4 class="d-inline font-weight-bold">Generate All</h4>
                              <div>
                                <div id="progressAdmin" class="d-none mt-2">
                                  <span id="progressTextAdmin"></span>
                                  <i id="progressSelesaiAdmin" class="material-icons d-none" class="d-none">check</i>
                                  <div class="progress progress-Admin">
                                    <div id="progressBarAdmin" class="progress-bar my-progress-bar bg-white" style="width: 0%;" role="progressbar" aria-valuenow="" aria-valuemin="" aria-valuemax=""></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </button>
                      </div>
                      <div class="col-12 col-xl-6 px-1">
                        <a href="<?= base_url('admin/qr/admin/download'); ?>" class="btn btn-success p-2 px-md-4 w-100">
                          <div class="d-flex align-items-center justify-content-center" style="gap: 12px;">
                            <div>
                              <i class="material-icons" style="font-size: 24px;">cloud_download</i>
                            </div>
                            <div>
                              <div class="text-start">
                                <h4 class="d-inline font-weight-bold">Download All</h4>
                              </div>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                    <br>
                    <br>
                    <p>
                      Untuk generate/download QR Code per masing-masing admin kunjungi
                      <a href="<?= base_url('admin/admin'); ?>" class="text-success"><b>data admin</b></a>
                    </p>
                  </div>
                </div>
                <p class="text-danger">
                  <i class="material-icons" style="font-size: 16px;">warning</i>
                  File image QR Code tersimpan di [folder website]/public/uploads/
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  const dataAdmin = [
    <?php foreach ($admin as $value) {
      echo "{
              'nama' : `$value[nama_admin]`,
              'unique_code' : `$value[unique_code]`,
              'nomor' : `$value[nuptk]`
            },";
    }; ?>
  ];

  const dataKaryawan = [
    <?php foreach ($karyawan as $value) {
      echo "{
              'nama' : `$value[nama_karyawan]`,
              'unique_code' : `$value[unique_code]`,
              'id_departemen' : `$value[id_departemen]`,
              'nomor' : `$value[nis]`
            },";
    }; ?>
  ];

  var dataKaryawanPerDepartemen = [];

  function generateAllQrKaryawan() {
    var i = 1;
    $('#progressKaryawan').removeClass('d-none');
    $('#progressBarKaryawan')
      .attr('aria-valuenow', '0')
      .attr('aria-valuemin', '0')
      .attr('aria-valuemax', dataKaryawan.length)
      .attr('style', 'width: 0%;');

    dataKaryawan.forEach(element => {
      jQuery.ajax({
        url: "<?= base_url('admin/generate/karyawan'); ?>",
        type: 'post',
        data: {
          nama: element['nama'],
          unique_code: element['unique_code'],
          id_departemen: element['id_departemen'],
          nomor: element['nomor']
        },
        success: function(response) {
          if (!response) return;
          if (i != dataKaryawan.length) {
            $('#progressTextKaryawan').html('Progres: ' + i + '/' + dataKaryawan.length);
          } else {
            $('#progressTextKaryawan').html('Progres: ' + i + '/' + dataKaryawan.length + ' selesai');
            $('#progressSelesaiKaryawan').removeClass('d-none');
          }

          $('#progressBarKaryawan')
            .attr('aria-valuenow', i)
            .attr('style', 'width: ' + (i / dataKaryawan.length) * 100 + '%;');
          i++;
        }
      });
    });
  }

  function generateQrKaryawanByDepartemen() {
    var i = 1;

    idDepartemen = $('#departemenSelect').val();

    if (idDepartemen == '') {
      $('#progressDepartemen').addClass('d-none');
      $('#textErrorDepartemen').html('Pilih departemen terlebih dahulu');
      return;
    }

    departemen = $('#idDepartemen' + idDepartemen).html();

    jQuery.ajax({
      url: "<?= base_url('admin/generate/karyawan-by-departemen'); ?>",
      type: 'post',
      data: {
        idDepartemen: idDepartemen
      },
      success: function(response) {
        dataKaryawanPerDepartemen = response;

        if (dataKaryawanPerDepartemen.length < 1) {
          $('#progressDepartemen').addClass('d-none');
          $('#textErrorDepartemen').html('Data karyawan departemen ' + departemen + ' tidak ditemukan');
          return;
        }

        $('#textErrorDepartemen').html('')

        $('#progressDepartemen').removeClass('d-none');
        $('#progressBarBgDepartemen')
          .removeClass('d-none');
        $('#progressBarDepartemen')
          .removeClass('d-none')
          .attr('aria-valuenow', '0')
          .attr('aria-valuemin', '0')
          .attr('aria-valuemax', dataKaryawanPerDepartemen.length)
          .attr('style', 'width: 0%;');

        dataKaryawanPerDepartemen.forEach(element => {
          jQuery.ajax({
            url: "<?= base_url('admin/generate/karyawan'); ?>",
            type: 'post',
            data: {
              nama: element['nama_karyawan'],
              unique_code: element['unique_code'],
              id_departemen: element['id_Departemen'],
              nomor: element['nis']
            },
            success: function(response) {
              if (!response) return;
              if (i != dataKaryawanPerDepartemen.length) {
                $('#progressTextDepartemen').html('Progres: ' + i + '/' + dataKaryawanPerDepartemen.length);
              } else {
                $('#progressTextDepartemen').html('Progres: ' + i + '/' + dataKaryawanPerDepartemen.length + ' selesai');
                $('#progressSelesaiDepartemen').removeClass('d-none');
              }

              $('#progressBarDepartemen')
                .attr('aria-valuenow', i)
                .attr('style', 'width: ' + (i / dataKaryawanPerDepartemen.length) * 100 + '%;');
              i++;
            },
            error: function(xhr, status, thrown) {
              console.error(xhr + status + thrown);
            }
          });
        });
      }
    });
  }

  function generateAllQrAdmin() {
    var i = 1;
    $('#progressAdmin').removeClass('d-none');
    $('#progressBarAdmin')
      .attr('aria-valuenow', '0')
      .attr('aria-valuemin', '0')
      .attr('aria-valuemax', dataAdmin.length)
      .attr('style', 'width: 0%;');

    dataAdmin.forEach(element => {
      jQuery.ajax({
        url: "<?= base_url('admin/generate/admin'); ?>",
        type: 'post',
        data: {
          nama: element['nama'],
          unique_code: element['unique_code'],
          nomor: element['nomor']
        },
        success: function(response) {
          if (!response) return;
          if (i != dataAdmin.length) {
            $('#progressTextAdmin').html('Progres: ' + i + '/' + dataAdmin.length);
          } else {
            $('#progressTextAdmin').html('Progres: ' + i + '/' + dataAdmin.length + ' selesai');
            $('#progressSelesaiAdmin').removeClass('d-none');
          }

          $('#progressBarAdmin')
            .attr('aria-valuenow', i)
            .attr('style', 'width: ' + (i / dataAdmin.length) * 100 + '%;');
          i++;
        }
      });
    });
  }
</script>
<?= $this->endSection() ?>