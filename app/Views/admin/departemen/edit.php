<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title"><b>Form Edit Departemen</b></h4>
          </div>
          <div class="card-body mx-5 my-3">

            <form action="<?= base_url('admin/departemen/editDepartemenPost'); ?>" method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="id" value="<?= esc($departemen->id_departemen); ?>">
              <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">

              <div class="form-group mt-4">
                <label for="departemen">Departemen / Tingkat</label>
                <input type="text" id="departemen" class="form-control <?= invalidFeedback('departemen') ? 'is-invalid' : ''; ?>" name="departemen" placeholder="'X', 'XI', '11'" , value="<?= old('departemen') ?? $departemen->departemen  ?? '' ?>" required>
                <div class="invalid-feedback">
                  <?= invalidFeedback('departemen'); ?>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <label for="id_jabatan">Jabatan</label>
                  <select class="custom-select <?= invalidFeedback('id_jabatan') ? 'is-invalid' : ''; ?>" id="id_jabatan" name="id_jabatan">
                    <option value="">--Pilih Jabatan--</option>
                    <?php foreach ($jabatan as $value) : ?>
                      <option value="<?= $value['id']; ?>" <?= $departemen->id_jabatan == $value['id'] ? 'selected' : ''; ?>>
                        <?= $value['jabatan']; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <div class="invalid-feedback">
                    <?= invalidFeedback('id_jabatan'); ?>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary mt-4">Simpan</button>
            </form>

            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>