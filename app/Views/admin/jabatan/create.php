<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
  .form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    padding: 32px;
    margin-top: 16px;
  }

  .form-card__header {
    margin-bottom: 24px;
  }

  .form-card__title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .form-group {
    margin-bottom: 24px;
  }

  .form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #1e293b;
    font-size: 0.875rem;
  }

  .form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background: #ffffff;
    color: #1e293b;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  .form-control.is-invalid {
    border-color: #ef4444;
  }

  .invalid-feedback {
    display: block;
    margin-top: 6px;
    color: #ef4444;
    font-size: 0.875rem;
  }

  .btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border-color: #3b82f6;
    color: #ffffff;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    box-shadow: 0 6px 12px rgba(59, 130, 246, 0.3);
    transform: translateY(-1px);
  }

  @media (max-width: 768px) {
    .form-card {
      padding: 24px;
    }
  }
</style>

<div class="content">
  <div class="container-fluid">
    <?= view('admin/_messages'); ?>
    
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="form-card">
          <div class="form-card__header">
            <h4 class="form-card__title">
              ➕ Form Tambah Grade
            </h4>
          </div>

          <form action="<?= base_url('admin/jabatan/tambahJabatanPost'); ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
              <label for="jabatan">Nama Grade</label>
              <input type="text" id="jabatan" class="form-control <?= invalidFeedback('jabatan') ? 'is-invalid' : ''; ?>" name="jabatan" placeholder="IPA, IPS" value="<?= old('jabatan'); ?>" required>
              <div class="invalid-feedback">
                <?= invalidFeedback('jabatan'); ?>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">💾 Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>