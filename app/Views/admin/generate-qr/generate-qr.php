<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
  /* ===== Design tokens (ikut header) ===== */
  :root {
    --radius: 16px;
    --gap: 16px;
    --pad: 20px;
    --progress-h: 6px;
    --elev-1: 0 10px 30px rgba(12, 20, 40, .08);
  }

  /* ===== Layout ===== */
  .content {
    padding: 18px 0 28px !important;
    background: linear-gradient(180deg, var(--bg), color-mix(in oklab, var(--bg) 92%, #fff));
    min-height: calc(100vh - 64px);
  }

  .container-fluid {
    padding-inline: 18px !important;
  }

  /* ===== Shell card (utama) ===== */
  .shell {
    border: 1px solid var(--border);
    border-radius: calc(var(--radius) + 2px);
    background: var(--card-solid);
    color: var(--text);
    box-shadow: var(--elev-1);
    overflow: hidden;
  }

  .shell-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    padding: 18px 20px;
    background: color-mix(in oklab, var(--card-solid) 88%, var(--bg-accent-1, #eef6ff));
    border-bottom: 1px solid color-mix(in oklab, var(--border) 80%, transparent);
  }

  [data-theme="dark"] .shell-header {
    background: color-mix(in oklab, var(--card-solid) 86%, #0f2140);
    border-bottom-color: color-mix(in oklab, var(--border) 90%, transparent);
  }

  .shell-title {
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 800;
    font-size: 20px;
    letter-spacing: .2px;
    color: var(--text) !important;
    /* <-- pastikan kontras tinggi */
  }

  .shell-title i {
    color: var(--primary);
  }

  .shell-sub {
    margin: 2px 0 0 34px;
    color: var(--muted) !important;
    font-weight: 600;
  }

  .shell-body {
    padding: 20px;
  }

  /* ===== Dropdown Filter ===== */
  .filter-dropdown {
    position: relative;
    display: inline-block;
  }

  .filter-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background: var(--card-solid);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 10px 16px;
    padding-right: 40px;
    font-weight: 700;
    font-size: 14px;
    color: var(--text);
    cursor: pointer;
    transition: all 0.2s ease;
    min-width: 140px;
    outline: none;
  }

  .filter-select:hover {
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
  }

  .filter-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
  }

  .filter-dropdown::after {
    content: '▼';
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: var(--muted);
    font-size: 12px;
    transition: transform 0.2s ease;
  }

  .filter-select:focus+.filter-dropdown::after {
    transform: translateY(-50%) rotate(180deg);
  }

  /* ===== Panels grid ===== */
  .panels {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 20px;
  }

  @media (max-width: 991.98px) {
    .panels {
      grid-template-columns: 1fr;
      gap: 16px;
    }
  }

  /* ===== Panel visibility ===== */
  .panel {
    transition: all 0.3s ease;
  }

  .panel.hidden {
    display: none !important;
  }

  .panel.visible {
    display: block !important;
  }

  /* ===== Panel card ===== */
  .panel {
    border: 1px solid var(--border);
    border-radius: var(--radius);
    background: var(--card-solid);
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .panel-head {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    background: color-mix(in oklab, var(--card-solid) 92%, var(--bg-accent-1, #f7fbff));
    border-bottom: 1px solid color-mix(in oklab, var(--border) 75%, transparent);
  }

  [data-theme="dark"] .panel-head {
    background: color-mix(in oklab, var(--card-solid) 90%, #0f203c);
  }

  .panel-title {
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 800;
    color: var(--text) !important;
    /* <-- kontras tinggi */
  }

  .panel-title i {
    color: var(--primary);
  }

  .panel-sub {
    margin-left: auto;
    color: var(--muted);
    font-weight: 600;
  }

  .panel-sub a {
    color: var(--primary) !important;
    text-decoration: underline;
  }

  .panel-body {
    padding: 16px;
  }

  /* ===== Actions ===== */
  .actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
  }

  @media (max-width: 575.98px) {
    .actions {
      grid-template-columns: 1fr;
      gap: 12px;
    }
  }

  .actions-single {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
  }

  @media (max-width: 575.98px) {
    .actions-single {
      flex-direction: column;
    }
  }

  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border-radius: 12px;
    padding: 12px 20px;
    border: 0;
    font-weight: 700;
    font-size: 14px;
    line-height: 1;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    min-height: 44px;
  }

  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  .btn:active {
    transform: translateY(0);
  }

  .btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
  }

  .btn-primary {
    background: linear-gradient(135deg, var(--primary), color-mix(in oklab, var(--primary) 55%, #60a5fa));
    color: #fff;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
  }

  .btn-primary:hover {
    box-shadow: 0 6px 16px rgba(59, 130, 246, 0.35);
  }

  .btn-success {
    background: linear-gradient(135deg, var(--success), color-mix(in oklab, var(--success) 60%, #34d399));
    color: #fff;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
  }

  .btn-success:hover {
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
  }

  /* ===== Form ===== */
  .field {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin: 10px 0 8px;
  }

  .field label {
    font-size: 12.5px;
    font-weight: 800;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .05em;
  }

  .select {
    width: 100%;
    border: 1px solid color-mix(in oklab, var(--border) 90%, #cbd5e1);
    background: var(--card);
    color: var(--text);
    border-radius: 12px;
    padding: 10px 12px;
    outline: none;
    transition: border .12s, box-shadow .12s;
  }

  .select:focus {
    border-color: color-mix(in oklab, var(--ring) 60%, var(--border));
    box-shadow: 0 0 0 2px color-mix(in oklab, var(--ring) 38%, transparent);
  }

  .hr {
    height: 1px;
    background: color-mix(in oklab, var(--border) 90%, #e9eef8);
    margin: 14px 0;
  }

  /* ===== Progress ===== */
  .progress-wrap {
    margin-top: 8px;
  }

  .progress {
    height: var(--progress-h);
    border-radius: 999px;
    overflow: hidden;
    border: 1px solid var(--border);
    background: color-mix(in oklab, var(--border) 55%, #fff);
  }

  .progress-bar {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, color-mix(in oklab, var(--primary) 45%, #fff), #fff);
    transition: width .25s ease;
  }

  [data-theme="dark"] .progress-bar {
    background: linear-gradient(90deg, color-mix(in oklab, var(--ring) 40%, transparent), color-mix(in oklab, var(--ring) 60%, transparent));
  }

  .progress-meta {
    display: flex;
    gap: 8px;
    align-items: center;
    color: var(--muted);
    font-size: 13.5px;
    margin-bottom: 6px;
  }

  .check-icon {
    color: #22c55e;
  }

  .note {
    color: var(--muted);
    font-size: 14px;
  }

  .note a {
    color: var(--primary);
    text-decoration: underline;
  }

  /* ===== Force ALL headings high-contrast ===== */
  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
    color: var(--text) !important;
  }

  /* ===== Mobile Responsive ===== */
  @media (max-width: 768px) {
    .shell-header {
      flex-direction: column;
      gap: 16px;
      align-items: flex-start;
    }

    .filter-dropdown {
      align-self: stretch;
    }

    .filter-select {
      width: 100%;
      min-width: auto;
    }

    .panels {
      grid-template-columns: 1fr !important;
      gap: 16px;
    }

    .actions {
      grid-template-columns: 1fr;
      gap: 12px;
    }

    .actions-single {
      flex-direction: column;
    }

    .btn {
      width: 100%;
      justify-content: center;
    }

    .shell-body {
      padding: 16px;
    }

    .panel-head {
      flex-direction: column;
      align-items: flex-start;
      gap: 8px;
    }

    .panel-sub {
      margin-left: 0;
    }
  }

  @media (max-width: 480px) {
    .shell-header {
      padding: 16px;
    }

    .shell-title {
      font-size: 18px;
    }

    .shell-sub {
      font-size: 14px;
    }

    .panel-head {
      padding: 12px 14px;
    }

    .panel-body {
      padding: 14px;
    }

    .btn {
      padding: 10px 16px;
      font-size: 13px;
    }
  }
</style>

<div class="content">
  <div class="container-fluid">
    <?php if (session()->getFlashdata('msg')): ?>
      <div class="pb-2 px-3">
        <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success' ?>">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="material-icons">close</i></button>
          <?= session()->getFlashdata('msg') ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="shell">
      <div class="shell-header">
        <div>
          <h4 class="shell-title"><i class="material-icons">qr_code_2</i> Generate QR Code</h4>
          <div class="shell-sub">Buat & unduh QR berdasarkan <em>kode unik</em> karyawan & admin.</div>
        </div>
        <div class="filter-dropdown">
          <select id="viewFilter" class="filter-select" aria-label="Pilih tampilan">
            <option value="karyawan">Karyawan</option>
            <option value="admin">Admin</option>
            <option value="all" selected>Semua</option>
          </select>
        </div>
      </div>

      <div class="shell-body">
        <div class="panels">
          <!-- ===== Panel Karyawan ===== -->
          <div class="panel" id="panelKaryawan">
            <div class="panel-head">
              <h5 class="panel-title"><i class="material-icons">group</i> Data Karyawan</h5>
              <div class="panel-sub">Total: <b><?= count($karyawan); ?></b> • <a href="<?= base_url('admin/karyawan'); ?>">Lihat data</a></div>
            </div>
            <div class="panel-body">
              <div class="actions">
                <button id="btnGenAllKar" onclick="generateAllQrKaryawan()" class="btn btn-primary" aria-live="polite">
                  <i class="material-icons" aria-hidden="true">qr_code</i><span>Generate Semua</span>
                </button>

                <a href="<?= base_url('admin/qr/karyawan/download'); ?>" class="btn btn-primary">
                  <i class="material-icons" aria-hidden="true">cloud_download</i><span>Download Semua</span>
                </a>
              </div>

              <div id="progressKaryawan" class="progress-wrap d-none" aria-label="Progres generate karyawan">
                <div class="progress-meta">
                  <span id="progressTextKaryawan">Progres: 0/0</span>
                  <i id="progressSelesaiKaryawan" class="material-icons check-icon d-none" aria-hidden="true">check_circle</i>
                </div>
                <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="<?= count($karyawan); ?>">
                  <div id="progressBarKaryawan" class="progress-bar"></div>
                </div>
              </div>

              <div class="hr"></div>

              <div class="field">
                <label for="departemenSelect">Generate per Departemen</label>
                <select name="id_departemen" id="departemenSelect" class="select" required aria-label="Pilih departemen">
                  <option value="">-- Pilih departemen --</option>
                  <?php foreach ($departemen as $value) : ?>
                    <option id="idDepartemen<?= $value['id_departemen']; ?>" value="<?= $value['id_departemen']; ?>">
                      <?= $value['departemen'] . ' ' . $value['jabatan']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="actions-single">
                <button id="btnGenDept" type="button" onclick="generateQrKaryawanByDepartemen()" class="btn btn-primary">
                  <i class="material-icons" aria-hidden="true">qr_code</i><span>Generate per Departemen</span>
                </button>

                <a href="<?= base_url('admin/qr/karyawan/download'); ?>" class="btn btn-primary">
                  <i class="material-icons" aria-hidden="true">cloud_download</i><span>Download per Departemen</span>
                </a>
              </div>

              <div id="progressDepartemen" class="progress-wrap d-none" aria-label="Progres generate per departemen">
                <div class="progress-meta">
                  <span id="progressTextDepartemen">Progres: 0/0</span>
                  <i id="progressSelesaiDepartemen" class="material-icons check-icon d-none" aria-hidden="true">check_circle</i>
                </div>
                <div id="progressBarBgDepartemen" class="progress d-none" role="progressbar">
                  <div id="progressBarDepartemen" class="progress-bar"></div>
                </div>
              </div>

              <div id="textErrorDepartemen" class="d-none" style="font-size:14px; color:var(--danger); font-weight: 600; margin-top: 8px;"></div>

              <p class="note mt-2">
                Untuk generate/download QR per karyawan, buka
                <a href="<?= base_url('admin/karyawan'); ?>"><b>Data Karyawan</b></a>
              </p>
            </div>
          </div>

          <!-- ===== Panel Admin ===== -->
          <div class="panel" id="panelAdmin">
            <div class="panel-head">
              <h5 class="panel-title"><i class="material-icons" style="color:var(--success)">admin_panel_settings</i> Data Admin</h5>
              <div class="panel-sub">Total: <b><?= count($admin); ?></b> • <a href="<?= base_url('admin/admin'); ?>" style="color:var(--success)">Lihat data</a></div>
            </div>
            <div class="panel-body">
              <div class="actions">
                <button id="btnGenAllAdmin" onclick="generateAllQrAdmin()" class="btn btn-success" aria-live="polite">
                  <i class="material-icons" aria-hidden="true">qr_code</i><span>Generate Semua</span>
                </button>

                <a href="<?= base_url('admin/qr/admin/download'); ?>" class="btn btn-success">
                  <i class="material-icons" aria-hidden="true">cloud_download</i><span>Download Semua</span>
                </a>
              </div>

              <div id="progressAdmin" class="progress-wrap d-none" aria-label="Progres generate admin">
                <div class="progress-meta">
                  <span id="progressTextAdmin">Progres: 0/0</span>
                  <i id="progressSelesaiAdmin" class="material-icons check-icon d-none" aria-hidden="true">check_circle</i>
                </div>
                <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="<?= count($admin); ?>">
                  <div id="progressBarAdmin" class="progress-bar"></div>
                </div>
              </div>

              <p class="note mt-2">
                File QR tersimpan di <code>/public/uploads/</code>. Untuk generate/download per admin, buka
                <a href="<?= base_url('admin/admin'); ?>"><b>Data Admin</b></a>
              </p>
            </div>
          </div>
        </div> <!-- /panels -->
      </div>
    </div>
  </div>
</div>

<script>
  /* ===== View switch dengan dropdown ===== */
  const VIEW_KEY = 'qr-view';

  function setView(view) {
    const pKar = document.getElementById('panelKaryawan');
    const pAdm = document.getElementById('panelAdmin');
    const panels = document.querySelector('.panels');

    // Reset semua panel
    pKar.classList.remove('hidden', 'visible');
    pAdm.classList.remove('hidden', 'visible');

    // Set visibility berdasarkan view
    if (view === 'karyawan') {
      pKar.classList.add('visible');
      pAdm.classList.add('hidden');
      panels.style.gridTemplateColumns = '1fr';
    } else if (view === 'admin') {
      pKar.classList.add('hidden');
      pAdm.classList.add('visible');
      panels.style.gridTemplateColumns = '1fr';
    } else if (view === 'all') {
      pKar.classList.add('visible');
      pAdm.classList.add('visible');
      panels.style.gridTemplateColumns = '1fr 1fr';
    }

    localStorage.setItem(VIEW_KEY, view);
  }

  // Event listener untuk dropdown
  document.getElementById('viewFilter')?.addEventListener('change', function() {
    setView(this.value);
  });

  // Initialize view
  (function initView() {
    const savedView = localStorage.getItem(VIEW_KEY) || 'all';
    document.getElementById('viewFilter').value = savedView;
    setView(savedView);
  })();

  /* ===== Data (PHP → JS) ===== */
  const dataAdmin = [
    <?php foreach ($admin as $value) {
      echo "{
        nama: `$value[nama_admin]`,
        unique_code: `$value[unique_code]`,
        nomor: `$value[nuptk]`
      },";
    } ?>
  ];
  const dataKaryawan = [
    <?php foreach ($karyawan as $value) {
      echo "{
        nama: `$value[nama_karyawan]`,
        unique_code: `$value[unique_code]`,
        id_departemen: `$value[id_departemen]`,
        nomor: `$value[nis]`
      },";
    } ?>
  ];
  let dataKaryawanPerDepartemen = [];

  /* ===== Util Progres & Tombol ===== */
  function setProgress($wrap, $bar, $textEl, current, total) {
    const pct = total > 0 ? Math.round((current / total) * 100) : 0;
    $bar.css('width', pct + '%');
    $wrap.find('.progress').attr('aria-valuenow', current).attr('aria-valuemax', total);
    $textEl.text(`Progres: ${current}/${total}` + (current === total ? ' selesai' : ''));
    if (current === total) $wrap.find('.check-icon').removeClass('d-none');
  }

  function disableBtn($btn, on = true) {
    if (on) {
      $btn.attr('disabled', true);
      if (!$btn.find('.spinner-border').length) {
        $btn.append('<span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>');
      }
    } else {
      $btn.attr('disabled', false);
      $btn.find('.spinner-border').remove();
    }
  }

  function resetProgress($wrap, $bar, $txt) {
    $wrap.removeClass('d-none');
    $wrap.find('.check-icon').addClass('d-none');
    $bar.css('width', '0%');
    $txt.text('Progres: 0/0');
  }

  /* ===== Generate Semua Karyawan ===== */
  function generateAllQrKaryawan() {
    const $btn = $('#btnGenAllKar'),
      $wrap = $('#progressKaryawan'),
      $bar = $('#progressBarKaryawan'),
      $txt = $('#progressTextKaryawan');
    if (!dataKaryawan.length) return;
    resetProgress($wrap, $bar, $txt);
    disableBtn($btn, true);
    let i = 0;
    const total = dataKaryawan.length;
    dataKaryawan.forEach(el => {
      jQuery.ajax({
        url: "<?= base_url('admin/generate/karyawan'); ?>",
        type: 'post',
        data: {
          nama: el['nama'],
          unique_code: el['unique_code'],
          id_departemen: el['id_departemen'],
          nomor: el['nomor']
        },
        success() {
          i++;
          setProgress($wrap, $bar, $txt, i, total);
          if (i === total) disableBtn($btn, false);
        },
        error() {
          i++;
          setProgress($wrap, $bar, $txt, i, total);
          if (i === total) disableBtn($btn, false);
        }
      });
    });
  }

  /* ===== Generate Per Departemen ===== */
  function generateQrKaryawanByDepartemen() {
    const idDepartemen = $('#departemenSelect').val();
    const $err = $('#textErrorDepartemen'),
      $btn = $('#btnGenDept');
    const $wrap = $('#progressDepartemen'),
      $bg = $('#progressBarBgDepartemen');
    const $bar = $('#progressBarDepartemen'),
      $txt = $('#progressTextDepartemen');

    if (!idDepartemen) {
      $wrap.addClass('d-none');
      $err.removeClass('d-none').text('Pilih departemen terlebih dahulu.');
      return;
    }
    $err.addClass('d-none').text('');
    disableBtn($btn, true);
    resetProgress($wrap, $bar, $txt);
    $bg.removeClass('d-none');

    jQuery.ajax({
      url: "<?= base_url('admin/generate/karyawan-by-departemen'); ?>",
      type: 'post',
      data: {
        idDepartemen
      },
      success(response) {
        dataKaryawanPerDepartemen = Array.isArray(response) ? response : [];
        if (dataKaryawanPerDepartemen.length < 1) {
          $wrap.addClass('d-none');
          $err.removeClass('d-none').text('Data karyawan tidak ditemukan untuk departemen terpilih.');
          disableBtn($btn, false);
          return;
        }
        let i = 0;
        const total = dataKaryawanPerDepartemen.length;
        dataKaryawanPerDepartemen.forEach(el => {
          jQuery.ajax({
            url: "<?= base_url('admin/generate/karyawan'); ?>",
            type: 'post',
            data: {
              nama: el['nama_karyawan'],
              unique_code: el['unique_code'],
              id_departemen: el['id_departemen'],
              nomor: el['nis']
            },
            success() {
              i++;
              setProgress($wrap, $bar, $txt, i, total);
              if (i === total) disableBtn($btn, false);
            },
            error() {
              i++;
              setProgress($wrap, $bar, $txt, i, total);
              if (i === total) disableBtn($btn, false);
            }
          });
        });
      },
      error() {
        $wrap.addClass('d-none');
        $err.removeClass('d-none').text('Terjadi kesalahan saat mengambil data departemen.');
        disableBtn($btn, false);
      }
    });
  }

  function handleDeptSubmit() {
    const idDepartemen = $('#departemenSelect').val();
    if (!idDepartemen) {
      $('#textErrorDepartemen').removeClass('d-none').text('Pilih departemen terlebih dahulu.');
      return false;
    }
    return true;
  }

  /* ===== Generate Semua Admin ===== */
  function generateAllQrAdmin() {
    const $btn = $('#btnGenAllAdmin'),
      $wrap = $('#progressAdmin'),
      $bar = $('#progressBarAdmin'),
      $txt = $('#progressTextAdmin');
    if (!dataAdmin.length) return;
    resetProgress($wrap, $bar, $txt);
    disableBtn($btn, true);
    let i = 0;
    const total = dataAdmin.length;
    dataAdmin.forEach(el => {
      jQuery.ajax({
        url: "<?= base_url('admin/generate/admin'); ?>",
        type: 'post',
        data: {
          nama: el['nama'],
          unique_code: el['unique_code'],
          nomor: el['nomor']
        },
        success() {
          i++;
          setProgress($wrap, $bar, $txt, i, total);
          if (i === total) disableBtn($btn, false);
        },
        error() {
          i++;
          setProgress($wrap, $bar, $txt, i, total);
          if (i === total) disableBtn($btn, false);
        }
      });
    });
  }
</script>

<?= $this->endSection() ?>