<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
  /* ========= THEME SYSTEM =========
     - Default: mengikuti data-theme pada <html data-theme="dark|light">
     - Jika tidak ada, fallback ke dark.
  */
  :root {
    --bg: #0e1422;
    --surface: #0f172a;
    --surface-2: #111c2f;
    --glass: rgba(255, 255, 255, 0.06);
    --text: #e6edf6;
    --muted: #9fb1c6;
    --border: rgba(226, 232, 240, .08);
    --ring: #60a5fa;
    --shadow: 0 18px 40px rgba(0, 0, 0, .35);

    --primary: #3b82f6;
    --primary-2: #60a5fa;
    --success: #10b981;
    --success-2: #34d399;
    --danger: #ef4444;

    --radius: 16px;
    --gap: 18px;
    --card-pad: 18px;
    --progress-h: 6px;

    /* Responsiveness tokens */
    --pad-xs: 12px;
    --pad-sm: 14px;
    --pad-md: 16px;
    --pad-lg: 18px;
  }

  /* ====== LIGHT THEME ====== */
  html[data-theme="light"] {
    --bg: #f5f7fb;
    --surface: #ffffff;
    --surface-2: #f8fafc;
    --glass: rgba(255, 255, 255, 0.75);
    --text: #0f172a;
    --muted: #5b6b80;
    --border: rgba(2, 6, 23, .08);
    --ring: #2563eb;
    --shadow: 0 12px 32px rgba(15, 23, 42, .10);
  }

  /* ====== Optional: mengikuti preferensi OS saat pertama kali (jika belum ada localStorage) ====== */
  @media (prefers-color-scheme: light) {
    html:not([data-theme]) {
      --bg: #f5f7fb;
      --surface: #ffffff;
      --surface-2: #f8fafc;
      --glass: rgba(255, 255, 255, 0.75);
      --text: #0f172a;
      --muted: #5b6b80;
      --border: rgba(2, 6, 23, .08);
      --ring: #2563eb;
      --shadow: 0 12px 32px rgba(15, 23, 42, .10);
    }
  }

  /* ========= LAYOUT ========= */
  .content {
    background:
      radial-gradient(1200px 600px at -10% -20%, rgba(99, 102, 241, .15), transparent 60%),
      radial-gradient(900px 500px at 110% 10%, rgba(20, 184, 166, .14), transparent 55%),
      radial-gradient(1200px 800px at 50% 120%, rgba(56, 189, 248, .16), transparent 60%),
      var(--bg);
    min-height: calc(100vh - 64px);
    padding-top: clamp(8px, 1.2vw, 12px);
    padding-bottom: clamp(16px, 2vw, 24px);
  }

  .container-fluid {
    padding-left: clamp(10px, 2vw, 18px) !important;
    padding-right: clamp(10px, 2vw, 18px) !important;
  }

  .grid-gap {
    row-gap: var(--gap);
  }

  /* ========= CARDS ========= */
  .card {
    background: linear-gradient(180deg, var(--surface), var(--surface-2));
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
  }

  .card-header {
    border-bottom: 1px solid var(--border);
    padding: clamp(var(--pad-xs), 2vw, var(--pad-md)) clamp(var(--pad-xs), 2.2vw, var(--pad-md));
    background: linear-gradient(0deg, rgba(255, 255, 255, .02), rgba(255, 255, 255, .03));
    display: flex;
    align-items: center;
    gap: 12px;
    justify-content: space-between;
    flex-wrap: wrap;
  }

  .card-body {
    padding: clamp(var(--pad-xs), 2vw, var(--pad-lg));
  }

  .section-title {
    font-weight: 800;
    letter-spacing: .2px;
    margin: 0;
    color: var(--text);
    font-size: clamp(18px, 2.2vw, 22px);
    line-height: 1.25;
  }

  .section-sub {
    margin: 2px 0 0;
    color: var(--muted);
    font-size: clamp(13px, 1.8vw, 15px);
  }

  /* ========= Theme Toggle ========= */
  .theme-toggle {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    border: 1px solid var(--border);
    background: var(--surface-2);
    color: var(--text);
    border-radius: 999px;
    padding: 8px 12px;
    cursor: pointer;
    user-select: none;
    transition: box-shadow .2s ease, transform .08s ease;
    font-size: clamp(12px, 1.6vw, 14px);
  }

  .theme-toggle .material-icons {
    font-size: clamp(18px, 2vw, 20px);
  }

  .theme-toggle:hover {
    transform: translateY(-1px);
  }

  /* ========= Buttons ========= */
  .btn-modern {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: clamp(8px, 1.4vw, 10px);
    width: 100%;
    border: 0;
    border-radius: 14px;
    padding: clamp(10px, 1.8vw, 12px) clamp(14px, 2.2vw, 18px);
    font-weight: 700;
    letter-spacing: .2px;
    transition: transform .08s ease, box-shadow .2s ease, background .2s ease;
    color: #fff;
    cursor: pointer;
    outline: none;
    text-align: left;
  }

  .btn-modern:focus-visible {
    box-shadow: 0 0 0 3px rgba(99, 102, 241, .3), 0 10px 24px rgba(0, 0, 0, .25);
  }

  .btn-primary-modern {
    background: linear-gradient(135deg, var(--primary), var(--primary-2));
    box-shadow: 0 10px 24px rgba(37, 99, 235, .35);
  }

  .btn-success-modern {
    background: linear-gradient(135deg, var(--success), var(--success-2));
    box-shadow: 0 10px 24px rgba(16, 185, 129, .35);
  }

  .btn-modern:hover {
    transform: translateY(-1px);
  }

  .btn-modern:active {
    transform: translateY(0px) scale(.99);
  }

  .btn-modern[disabled] {
    opacity: .65;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
  }

  .btn-label {
    line-height: 1.2;
  }

  .btn-label h4,
  .btn-label h6 {
    margin: 0;
    font-weight: 800;
    font-size: clamp(15px, 2vw, 18px);
  }

  .icon-24 {
    font-size: clamp(20px, 2.2vw, 24px);
  }

  /* >>> Keterbacaan teks "soft" di tombol (gelap & terang) <<< */
  .btn-modern .soft {
    color: color-mix(in oklab, #fff 90%, transparent);
    text-shadow: 0 1px 0 rgba(0, 0, 0, .35);
    opacity: 1;
    font-size: clamp(12.5px, 1.8vw, 14px);
  }

  html[data-theme="light"] .btn-modern .soft,
  html:not([data-theme]) .btn-modern .soft {
    color: color-mix(in oklab, #fff 92%, transparent);
    text-shadow: none;
  }

  /* ========= Progress ========= */
  .progress {
    height: clamp(6px, 1.4vw, var(--progress-h));
    background: rgba(255, 255, 255, .1);
    border-radius: 999px;
    overflow: hidden;
    border: 1px solid var(--border);
  }

  html[data-theme="light"] .progress {
    background: rgba(2, 6, 23, .06);
  }

  .progress-bar {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, rgba(255, 255, 255, .75), #fff);
    transition: width .25s ease;
  }

  html[data-theme="light"] .progress-bar {
    background: linear-gradient(90deg, rgba(2, 6, 23, .2), rgba(2, 6, 23, .35));
  }

  .progress-wrap {
    margin-top: 10px;
  }

  .progress-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--muted);
    font-size: clamp(12px, 1.7vw, 14px);
    margin-bottom: 8px;
    flex-wrap: wrap;
  }

  .check-icon {
    color: #22c55e;
    font-size: clamp(16px, 2vw, 18px);
    vertical-align: middle;
  }

  /* ========= Meta & Helpers ========= */
  .meta {
    color: var(--muted);
    font-size: clamp(12.5px, 1.8vw, 14px);
  }

  .meta a {
    color: var(--primary-2);
    text-decoration: underline;
  }

  html[data-theme="light"] .meta a {
    color: var(--ring);
  }

  .hint {
    color: #f59e0b;
    font-size: clamp(12.5px, 1.8vw, 14px);
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 12px;
  }

  .text-danger-modern {
    color: var(--danger);
  }

  .select-modern {
    width: 100%;
    border-radius: 12px;
    border: 1px solid var(--border);
    padding: clamp(9px, 1.6vw, 10px) clamp(10px, 2vw, 12px);
    background: var(--surface-2);
    color: var(--text);
    outline: none;
    transition: box-shadow .2s ease, border .2s ease;
    font-size: clamp(13px, 1.8vw, 14.5px);
  }

  .select-modern:focus {
    border-color: var(--ring);
    box-shadow: 0 0 0 3px rgba(96, 165, 250, .25);
  }

  .divider {
    height: 1px;
    background: var(--border);
    margin: clamp(10px, 2vw, 14px) 0;
  }

  .soft {
    color: var(--muted);
  }

  /* ========= Responsive utilities ========= */
  /* Rapatkan grid tombol di layar kecil */
  @media (max-width: 575.98px) {
    .card-header {
      gap: 8px;
    }

    .btn-modern {
      align-items: center;
    }

    /* Biar dua action (Generate / Download) terlihat lega */
    .card .row>[class*="col-"] {
      padding-left: 6px;
      padding-right: 6px;
    }
  }

  /* Tablet: beri napas antar kolom */
  @media (min-width: 576px) and (max-width: 991.98px) {
    .card .row>[class*="col-"] {
      margin-bottom: 8px;
    }
  }
</style>

<div class="content">
  <div class="container-fluid">
    <div class="row grid-gap">
      <div class="col-lg-12 col-md-12">
        <?php if (session()->getFlashdata('msg')) : ?>
          <div class="pb-2 px-3">
            <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success' ?>">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
              </button>
              <?= session()->getFlashdata('msg') ?>
            </div>
          </div>
        <?php endif; ?>

        <div class="card">
          <div class="card-header">
            <div>
              <h4 class="section-title">Generate QR Code</h4>
              <p class="section-sub">Buat & unduh QR berdasarkan <em>kode unik</em> karyawan & admin.</p>
            </div>

            <!-- THEME TOGGLE -->
            <button id="themeToggle" type="button" class="theme-toggle" aria-label="Toggle theme" title="Ganti tema">
              <i class="material-icons" aria-hidden="true">dark_mode</i>
              <span id="themeLabel">Gelap</span>
            </button>
          </div>

          <div class="card-body">
            <div class="row grid-gap">
              <!-- ===== KARYAWAN ===== -->
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary mb-1" style="font-size:clamp(16px,2.2vw,20px)"><b>Data Karyawan</b></h4>
                    <p class="meta mb-3">
                      Total: <b><?= count($karyawan); ?></b>
                      • <a href="<?= base_url('admin/karyawan'); ?>">Lihat data</a>
                    </p>

                    <div class="row">
                      <div class="col-12 col-xl-6 mb-2">
                        <button id="btnGenAllKar" onclick="generateAllQrKaryawan()" class="btn-modern btn-primary-modern" aria-live="polite">
                          <i class="material-icons icon-24" aria-hidden="true">qr_code</i>
                          <div class="btn-label">
                            <h4>Generate Semua</h4>
                            <span class="soft">Buat QR seluruh karyawan</span>
                          </div>
                        </button>

                        <div id="progressKaryawan" class="progress-wrap d-none" aria-label="Progres generate karyawan">
                          <div class="progress-meta">
                            <span id="progressTextKaryawan">Progres: 0/0</span>
                            <i id="progressSelesaiKaryawan" class="material-icons check-icon d-none" aria-hidden="true">check_circle</i>
                          </div>
                          <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="<?= count($karyawan); ?>">
                            <div id="progressBarKaryawan" class="progress-bar"></div>
                          </div>
                        </div>
                      </div>

                      <div class="col-12 col-xl-6 mb-2">
                        <a href="<?= base_url('admin/qr/karyawan/download'); ?>" class="btn-modern btn-primary-modern">
                          <i class="material-icons icon-24" aria-hidden="true">cloud_download</i>
                          <div class="btn-label">
                            <h4>Download Semua</h4>
                            <span class="soft">Unduh arsip QR karyawan</span>
                          </div>
                        </a>
                      </div>
                    </div>

                    <div class="divider"></div>

                    <h5 class="mb-2" style="font-size:clamp(15px,2vw,18px)"><b>Generate per Departemen</b></h5>
                    <form action="<?= base_url('admin/qr/karyawan/download'); ?>" method="get" class="mb-2" onsubmit="return handleDeptSubmit()">
                      <select name="id_departemen" id="departemenSelect" class="select-modern mb-2" required aria-label="Pilih departemen">
                        <option value="">-- Pilih departemen --</option>
                        <?php foreach ($departemen as $value) : ?>
                          <option id="idDepartemen<?= $value['id_departemen']; ?>" value="<?= $value['id_departemen']; ?>">
                            <?= $value['departemen'] . ' ' . $value['jabatan']; ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                      <div class="row">
                        <div class="col-12 col-xl-6 mb-2">
                          <button id="btnGenDept" type="button" onclick="generateQrKaryawanByDepartemen()" class="btn-modern btn-primary-modern">
                            <i class="material-icons icon-24" aria-hidden="true">qr_code</i>
                            <div class="btn-label">
                              <h6>Generate per Departemen</h6>
                              <span class="soft">Buat QR sesuai pilihan</span>
                            </div>
                          </button>

                          <div id="progressDepartemen" class="progress-wrap d-none" aria-label="Progres generate per departemen">
                            <div class="progress-meta">
                              <span id="progressTextDepartemen">Progres: 0/0</span>
                              <i id="progressSelesaiDepartemen" class="material-icons check-icon d-none" aria-hidden="true">check_circle</i>
                            </div>
                            <div id="progressBarBgDepartemen" class="progress d-none" role="progressbar">
                              <div id="progressBarDepartemen" class="progress-bar"></div>
                            </div>
                          </div>

                          <b class="text-danger-modern mt-2 d-block" id="textErrorDepartemen" style="font-size:clamp(12.5px,1.8vw,14px)"></b>
                        </div>
                        <div class="col-12 col-xl-6 mb-2">
                          <button type="submit" class="btn-modern btn-primary-modern">
                            <i class="material-icons icon-24" aria-hidden="true">cloud_download</i>
                            <div class="btn-label">
                              <h6>Download per Departemen</h6>
                              <span class="soft">Unduh arsip departemen</span>
                            </div>
                          </button>
                        </div>
                      </div>
                    </form>

                    <p class="meta mt-2">
                      Untuk generate/download QR per karyawan, buka
                      <a href="<?= base_url('admin/karyawan'); ?>"><b>Data Karyawan</b></a>
                    </p>
                  </div>
                </div>
              </div>

              <!-- ===== ADMIN ===== -->
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h4 class="mb-1" style="color: var(--success); font-size:clamp(16px,2.2vw,20px)"><b>Data Admin</b></h4>
                    <p class="meta mb-3">
                      Total: <b><?= count($admin); ?></b>
                      • <a href="<?= base_url('admin/admin'); ?>" style="color: var(--success-2)">Lihat data</a>
                    </p>

                    <div class="row">
                      <div class="col-12 col-xl-6 mb-2">
                        <button id="btnGenAllAdmin" onclick="generateAllQrAdmin()" class="btn-modern btn-success-modern" aria-live="polite">
                          <i class="material-icons icon-24" aria-hidden="true">qr_code</i>
                          <div class="btn-label">
                            <h4>Generate Semua</h4>
                            <span class="soft">Buat QR seluruh admin</span>
                          </div>
                        </button>

                        <div id="progressAdmin" class="progress-wrap d-none" aria-label="Progres generate admin">
                          <div class="progress-meta">
                            <span id="progressTextAdmin">Progres: 0/0</span>
                            <i id="progressSelesaiAdmin" class="material-icons check-icon d-none" aria-hidden="true">check_circle</i>
                          </div>
                          <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="<?= count($admin); ?>">
                            <div id="progressBarAdmin" class="progress-bar"></div>
                          </div>
                        </div>
                      </div>

                      <div class="col-12 col-xl-6 mb-2">
                        <a href="<?= base_url('admin/qr/admin/download'); ?>" class="btn-modern btn-success-modern">
                          <i class="material-icons icon-24" aria-hidden="true">cloud_download</i>
                          <div class="btn-label">
                            <h4>Download Semua</h4>
                            <span class="soft">Unduh arsip QR admin</span>
                          </div>
                        </a>
                      </div>
                    </div>

                    <p class="hint">
                      <i class="material-icons" aria-hidden="true" style="font-size: clamp(16px,2vw,18px);">warning</i>
                      File gambar QR disimpan di <code>/public/uploads/</code>
                    </p>

                    <p class="meta mt-2">
                      Untuk generate/download QR per admin, buka
                      <a href="<?= base_url('admin/admin'); ?>"><b>Data Admin</b></a>
                    </p>
                  </div>
                </div>
              </div>
              <!-- /ADMIN -->
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  /* ===== THEME TOGGLER =====
     - Simpan preferensi di localStorage('theme'): 'dark' | 'light'
     - Inisialisasi saat load
  */
  (function initTheme() {
    const saved = localStorage.getItem('theme'); // 'dark' | 'light' | null
    const prefersLight = window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches;
    const theme = saved || (prefersLight ? 'light' : 'dark');
    document.documentElement.setAttribute('data-theme', theme);
    updateThemeUI(theme);
  })();

  function updateThemeUI(theme) {
    const label = document.getElementById('themeLabel');
    const icon = document.querySelector('#themeToggle .material-icons');
    if (!label || !icon) return;
    if (theme === 'light') {
      label.textContent = 'Terang';
      icon.textContent = 'light_mode';
    } else {
      label.textContent = 'Gelap';
      icon.textContent = 'dark_mode';
    }
  }

  document.getElementById('themeToggle')?.addEventListener('click', function() {
    const current = document.documentElement.getAttribute('data-theme') || 'dark';
    const next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
    updateThemeUI(next);
  });

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
    $wrap.find('.progress').attr('aria-valuenow', current);
    $wrap.find('.progress').attr('aria-valuemax', total);
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
    const $btn = $('#btnGenAllKar');
    const $wrap = $('#progressKaryawan');
    const $bar = $('#progressBarKaryawan');
    const $txt = $('#progressTextKaryawan');

    if (!dataKaryawan.length) return;

    resetProgress($wrap, $bar, $txt);
    disableBtn($btn, true);

    let i = 0;
    const total = dataKaryawan.length;

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
          i++;
          setProgress($wrap, $bar, $txt, i, total);
          if (i === total) disableBtn($btn, false);
        },
        error: function() {
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
    const $err = $('#textErrorDepartemen');
    const $btn = $('#btnGenDept');
    const $wrap = $('#progressDepartemen');
    const $bg = $('#progressBarBgDepartemen');
    const $bar = $('#progressBarDepartemen');
    const $txt = $('#progressTextDepartemen');

    if (!idDepartemen) {
      $wrap.addClass('d-none');
      $err.text('Pilih departemen terlebih dahulu.');
      return;
    }

    $err.text('');
    disableBtn($btn, true);
    resetProgress($wrap, $bar, $txt);
    $bg.removeClass('d-none');

    jQuery.ajax({
      url: "<?= base_url('admin/generate/karyawan-by-departemen'); ?>",
      type: 'post',
      data: {
        idDepartemen: idDepartemen
      },
      success: function(response) {
        dataKaryawanPerDepartemen = Array.isArray(response) ? response : [];

        if (dataKaryawanPerDepartemen.length < 1) {
          $wrap.addClass('d-none');
          $err.text('Data karyawan tidak ditemukan untuk departemen terpilih.');
          disableBtn($btn, false);
          return;
        }

        let i = 0;
        const total = dataKaryawanPerDepartemen.length;

        dataKaryawanPerDepartemen.forEach(element => {
          jQuery.ajax({
            url: "<?= base_url('admin/generate/karyawan'); ?>",
            type: 'post',
            data: {
              nama: element['nama_karyawan'],
              unique_code: element['unique_code'],
              id_departemen: element['id_departemen'],
              nomor: element['nis']
            },
            success: function(res) {
              if (!res) return;
              i++;
              setProgress($wrap, $bar, $txt, i, total);
              if (i === total) disableBtn($btn, false);
            },
            error: function() {
              i++;
              setProgress($wrap, $bar, $txt, i, total);
              if (i === total) disableBtn($btn, false);
            }
          });
        });
      },
      error: function() {
        $wrap.addClass('d-none');
        $err.text('Terjadi kesalahan saat mengambil data departemen.');
        disableBtn($btn, false);
      }
    });
  }

  function handleDeptSubmit() {
    const idDepartemen = $('#departemenSelect').val();
    if (!idDepartemen) {
      $('#textErrorDepartemen').text('Pilih departemen terlebih dahulu.');
      return false;
    }
    return true;
  }

  /* ===== Generate Semua Admin ===== */
  function generateAllQrAdmin() {
    const $btn = $('#btnGenAllAdmin');
    const $wrap = $('#progressAdmin');
    const $bar = $('#progressBarAdmin');
    const $txt = $('#progressTextAdmin');

    if (!dataAdmin.length) return;

    resetProgress($wrap, $bar, $txt);
    disableBtn($btn, true);

    let i = 0;
    const total = dataAdmin.length;

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
          i++;
          setProgress($wrap, $bar, $txt, i, total);
          if (i === total) disableBtn($btn, false);
        },
        error: function() {
          i++;
          setProgress($wrap, $bar, $txt, i, total);
          if (i === total) disableBtn($btn, false);
        }
      });
    });
  }
</script>

<?= $this->endSection() ?>