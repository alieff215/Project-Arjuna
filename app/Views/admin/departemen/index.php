<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <?= view('admin/_messages'); ?>
        <div class="row">
          <div class="col-12 col-xl-6">
            <div class="card">
              <div class="card-header card-header-tabs card-header-primary">
                <div class="nav-tabs-navigation">
                  <div class="row">
                    <div class="col-md-4 col-lg-5">
                      <h4 class="card-title"><b>Daftar Departemen</b></h4>
                      <p class="card-category">Angkatan <?= $generalSettings->company_year; ?></p>
                    </div>

                    <div class="col-auto row">
                      <div class="col-12 col-sm-auto nav nav-tabs">
                        <a class="btn-custom-tools" id="tabBtn" href="<?= base_url('admin/departemen/tambah'); ?>">
                          <i class="material-icons">add</i> Tambah data departemen
                          <div class="ripple-container"></div>
                        </a>

                      </div>
                      <div class="col-12 col-sm-auto nav nav-tabs">
                        <a class="btn-custom-tools" id="refreshBtn" onclick="fetchDepartemenJabatanData('departemen', '#dataDepartemen')" href="javascript:void(0)">
                          <i class="material-icons">refresh</i> Refresh

                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-data" id="dataDepartemen">
              </div>
            </div>
          </div>
          <div class="col-12 col-xl-6">
            <div class="card">
              <div class="card-header card-header-tabs card-header-primary">
                <div class="nav-tabs-navigation">
                  <div class="row">
                    <div class="col-md-4 col-lg-5">
                      <h4 class="card-title"><b>Daftar Jabatan</b></h4>
                      <p class="card-category">Angkatan <?= $generalSettings->company_year; ?></p>
                    </div>
                    <div class="col-auto row">
                      <div class="col-12 col-sm-auto nav nav-tabs">
                        <a class="btn-custom-tools" id="tabBtn" href="<?= base_url('admin/jabatan/tambah'); ?>">
                          <i class="material-icons">add</i> Tambah data jabatan
                        </a>

                      </div>
                      <div class="col-12 col-sm-auto nav nav-tabs">
                        <a class="btn-custom-tools" id="refreshBtn2" onclick="fetchDepartemenJabatanData('jabatan', '#dataJabatan')" href="javascript:void(0)">
                          <i class="material-icons">refresh</i> Refresh

                        </a>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="card-data" id="dataJabatan">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    fetchDepartemenJabatanData('departemen', '#dataDepartemen');
    fetchDepartemenJabatanData('jabatan', '#dataJabatan');
  });

  
</script>
<?= $this->endSection() ?>