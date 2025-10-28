<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
  .ui-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    overflow: hidden;
  }

  .ui-card__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 20px;
    border-bottom: 1px solid #e2e8f0;
    background: linear-gradient(180deg, #f8fafc 0%, transparent 100%);
  }

  .ui-card__title {
    margin: 0;
    font-weight: 700;
    font-size: 1.25rem;
    color: #1e293b;
  }

  .ui-card__meta {
    margin-top: 4px;
    color: #64748b;
    font-size: 0.875rem;
  }

  .ui-card__body {
    padding: 20px;
  }

  .chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    border-radius: 999px;
    border: 1px solid #e2e8f0;
    background: #f1f5f9;
    color: #1e293b;
    font-size: 0.875rem;
  }

  .material-icons {
    font-size: 18px;
    line-height: 1;
    vertical-align: middle;
  }

  .btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #1e293b;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
  }

  .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .btn:active {
    transform: translateY(0);
  }

  .btn--primary {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border-color: #3b82f6;
    color: #ffffff;
  }

  .btn--primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    box-shadow: 0 6px 12px rgba(59, 130, 246, 0.3);
  }

  .action-group {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
  }

  .skeleton {
    display: grid;
    gap: 10px;
  }

  .sk-line {
    height: 14px;
    border-radius: 8px;
    background: linear-gradient(90deg,
        #f1f5f9 0%,
        #e2e8f0 40%,
        #f1f5f9 80%);
    background-size: 290% 100%;
    animation: shimmer 1.1s infinite;
  }

  @keyframes shimmer {
    0% {
      background-position: 0% 50%;
    }
    100% {
      background-position: 100% 50%;
    }
  }

  @media (max-width: 768px) {
    .ui-card__header {
      flex-wrap: wrap;
    }

    .action-group {
      width: 100%;
    }

    .btn {
      flex: 1;
      justify-content: center;
    }
  }

  @media (max-width: 575px) {
    .btn span.label {
      display: none;
    }
  }
</style>

<div class="content">
  <div class="container-fluid">
    <div class="row gy-3">
      <div class="col-12 col-xl-6">
        <section class="ui-card" aria-labelledby="title-dept">
          <header class="ui-card__header">
            <div>
              <h4 id="title-dept" class="ui-card__title">Daftar Departemen</h4>
              <div class="ui-card__meta">
                <span class="chip"><i class="material-icons">calendar_month</i> Angkatan <?= esc($generalSettings->company_year); ?></span>
              </div>
            </div>
            <div class="action-group">
              <a class="btn btn--primary" href="<?= base_url('admin/departemen/tambah'); ?>" aria-label="Tambah data departemen">
                <i class="material-icons">add</i><span class="label">Tambah</span>
              </a>
              <button class="btn" type="button" onclick="refreshSection('departemen','#dataDepartemen')" aria-label="Refresh daftar departemen">
                <i class="material-icons">refresh</i><span class="label">Refresh</span>
              </button>
            </div>
          </header>
          <div class="ui-card__body" id="dataDepartemen">
            <div class="skeleton">
              <div class="sk-line" style="width:62%"></div>
              <div class="sk-line" style="width:92%"></div>
              <div class="sk-line" style="width:78%"></div>
            </div>
          </div>
        </section>
      </div>

      <div class="col-12 col-xl-6">
        <section class="ui-card" aria-labelledby="title-jbt">
          <header class="ui-card__header">
            <div>
              <h4 id="title-jbt" class="ui-card__title">Daftar Jabatan</h4>
              <div class="ui-card__meta">
                <span class="chip"><i class="material-icons">calendar_month</i> Angkatan <?= esc($generalSettings->company_year); ?></span>
              </div>
            </div>
            <div class="action-group">
              <a class="btn btn--primary" href="<?= base_url('admin/jabatan/tambah'); ?>" aria-label="Tambah data jabatan">
                <i class="material-icons">add</i><span class="label">Tambah</span>
              </a>
              <button class="btn" type="button" onclick="refreshSection('jabatan','#dataJabatan')" aria-label="Refresh daftar jabatan">
                <i class="material-icons">refresh</i><span class="label">Refresh</span>
              </button>
            </div>
          </header>
          <div class="ui-card__body" id="dataJabatan">
            <div class="skeleton">
              <div class="sk-line" style="width:66%"></div>
              <div class="sk-line" style="width:90%"></div>
              <div class="sk-line" style="width:74%"></div>
            </div>
          </div>
        </section>
      </div>

      <div class="col-12 mt-3">
        <?= view('admin/_messages'); ?>
      </div>
    </div>
  </div>
</div>

<script>

  /* ========= LOADING UX + FETCH WRAPPER ========= */
  function setSkeleton(target) {
    const el = document.querySelector(target);
    if (!el) return;
    el.innerHTML = `
    <div class="skeleton">
      <div class="sk-line" style="width:58%"></div>
      <div class="sk-line" style="width:92%"></div>
      <div class="sk-line" style="width:74%"></div>
    </div>`;
  }

  function refreshSection(kind, target) {
    setSkeleton(target);
    // jeda kecil supaya transisi terasa halus
    setTimeout(() => {
      fetchDepartemenJabatanData(kind, target);
    }, 160);
  }

  document.addEventListener('DOMContentLoaded', function() {
    refreshSection('departemen', '#dataDepartemen');
    refreshSection('jabatan', '#dataJabatan');
  });
</script>

<?= $this->endSection() ?> ini kan untuk tampilan data departemen dan jabatan, tetapi ini masih salah karna style untuk header dan navbar nya malah ditaruh disini, kemudian mode terang dan gelap nya juga malah ditaruh disini, tolong yang tidak sesuai dihilangkan ya dan dibenarkan, sisanya tidak perlu dirubah