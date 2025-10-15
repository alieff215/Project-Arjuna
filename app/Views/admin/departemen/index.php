<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
  /* ========== RESET RINGKAS & AKSESIBILITAS ========== */
  :where(*, *::before, *::after) {
    box-sizing: border-box
  }

  :where(html) {
    -webkit-text-size-adjust: 100%
  }

  :where(body) {
    margin: 0
  }

  :where(a) {
    color: inherit;
    text-decoration: none
  }

  :where(button) {
    font: inherit
  }

  :where(img) {
    display: block;
    max-width: 100%
  }

  :where(:focus-visible) {
    outline: 2px solid var(--ring);
    outline-offset: 2px
  }

  /* ========== DESIGN TOKENS ========== */
  :root {
    --radius: 14px;
    --radius-lg: 18px;
    --shadow-sm: 0 4px 14px rgba(0, 0, 0, .06);
    --shadow: 0 14px 38px rgba(15, 23, 42, .08);
    --border-w: 1px;

    --space-1: 6px;
    --space-2: 10px;
    --space-3: 14px;
    --space-4: 18px;
    --space-5: 22px;

    --font-sys: ui-sans-serif, -apple-system, Segoe UI, Roboto, Inter, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";

    /* ukuran ikon default */
    --icon: 18px;
  }

  /* LIGHT */
  html[data-theme="light"] {
    --bg: #f6f8fc;
    --bg-2: #eef3ff;
    --card: #ffffff;
    --text: #0f172a;
    --muted: #64748b;
    --border: rgba(2, 6, 23, .10);
    --ring: #3b82f6;

    --primary: #2563eb;
    --primary-2: #60a5fa;
    --chip: #eef2ff;
    --accent-wash: radial-gradient(1100px 600px at 15% -10%, #eaf1ff 0%, transparent 45%), radial-gradient(900px 600px at 110% 0%, rgba(99, 102, 241, .10) 0%, transparent 40%);
  }

  /* DARK */
  html[data-theme="dark"] {
    --bg: #0b1220;
    --bg-2: #0f172a;
    --card: #101827;
    --text: #e6edf6;
    --muted: #9fb1c6;
    --border: rgba(226, 232, 240, .10);
    --ring: #60a5fa;

    --primary: #60a5fa;
    --primary-2: #93c5fd;
    --chip: #0f223d;
    --accent-wash: radial-gradient(1100px 600px at 15% -10%, rgba(32, 51, 92, .45) 0%, transparent 45%), radial-gradient(900px 600px at 110% 0%, rgba(99, 102, 241, .18) 0%, transparent 40%);
  }

  /* ========== BASE LAYOUT ========== */
  .content {
    font-family: var(--font-sys);
    background: var(--bg);
    min-height: 100%;
  }

  .content .container-fluid {
    padding: var(--space-4) var(--space-3) var(--space-5);
    background: var(--accent-wash);
    border-radius: 0;
  }

  /* ========== CARD ========== */
  .ui-card {
    background: linear-gradient(180deg, color-mix(in srgb, var(--card) 92%, transparent), var(--card));
    border: var(--border-w) solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    overflow: hidden;
  }

  .ui-card__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-3);
    padding: var(--space-4) var(--space-4);
    border-bottom: var(--border-w) solid var(--border);
    background: linear-gradient(180deg, color-mix(in srgb, var(--bg-2) 40%, transparent), transparent);
  }

  .ui-card__title {
    margin: 0;
    font-weight: 800;
    letter-spacing: .2px;
    color: var(--text);
  }

  .ui-card__meta {
    margin-top: 4px;
    color: var(--muted);
    font-size: .92rem;
  }

  .ui-card__body {
    padding: var(--space-4);
  }

  /* ========== CHIP & ICON ========== */
  .chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 10px;
    border-radius: 999px;
    border: var(--border-w) solid var(--border);
    background: var(--chip);
    color: var(--text);
    font-size: .86rem;
  }

  .material-icons {
    font-size: var(--icon);
    line-height: 1;
    vertical-align: middle
  }

  /* ========== BUTTONS (konsisten) ========== */
  .btn {
    --h: 40px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    height: var(--h);
    padding: 0 14px;
    border-radius: 12px;
    border: var(--border-w) solid var(--border);
    background: color-mix(in srgb, var(--card) 92%, transparent);
    color: var(--text);
    font-weight: 600;
    cursor: pointer;
    transition: transform .12s ease, background .12s ease, border-color .12s ease, box-shadow .12s ease;
  }

  .btn:hover {
    transform: translateY(-1px);
    background: color-mix(in srgb, var(--card) 86%, var(--bg-2) 14%)
  }

  .btn:active {
    transform: translateY(0)
  }

  .btn--primary {
    background: linear-gradient(180deg, color-mix(in srgb, var(--primary) 18%, var(--card)), var(--card));
    border-color: color-mix(in srgb, var(--primary) 32%, var(--border));
  }

  .btn--iconOnly {
    padding: 0 10px;
    width: 40px;
    justify-content: center
  }

  /* grup aksi rapi */
  .action-group {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center
  }

  /* ========== THEME TOGGLE ========== */
  .theme-switch {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 6px 10px;
    border-radius: 12px;
    border: var(--border-w) solid var(--border);
    background: color-mix(in srgb, var(--card) 92%, transparent);
    user-select: none;
    cursor: pointer;
  }

  .theme-switch input {
    appearance: none;
    width: 46px;
    height: 24px;
    border-radius: 999px;
    border: var(--border-w) solid var(--border);
    background: radial-gradient(8px 8px at 8px 50%, var(--text) 98%, transparent 99%), color-mix(in srgb, var(--card) 88%, var(--bg-2) 12%);
    transition: background .15s ease, border-color .15s ease;
    position: relative;
  }

  .theme-switch input:checked {
    background: radial-gradient(8px 8px at 38px 50%, var(--text) 98%, transparent 99%), color-mix(in srgb, var(--card) 88%, var(--primary) 12%);
    border-color: color-mix(in srgb, var(--primary) 30%, var(--border));
  }

  /* ========== SKELETON ========== */
  .skeleton {
    display: grid;
    gap: 10px
  }

  .sk-line {
    height: 14px;
    border-radius: 8px;
    background: linear-gradient(90deg,
        color-mix(in srgb, var(--card) 78%, var(--bg) 22%) 0%,
        color-mix(in srgb, var(--card) 88%, var(--bg) 12%) 40%,
        color-mix(in srgb, var(--card) 78%, var(--bg) 22%) 80%);
    background-size: 290% 100%;
    animation: shimmer 1.1s infinite;
  }

  @keyframes shimmer {
    0% {
      background-position: 0% 50%
    }

    100% {
      background-position: 100% 50%
    }
  }

  /* ========== RESPONSIVE ========== */
  @media (max-width:1199.98px) {
    .ui-card__header {
      flex-wrap: wrap
    }
  }

  @media (max-width:575.98px) {
    .btn span.label {
      display: none
    }

    .btn {
      padding: 0 12px
    }

    .ui-card__body {
      padding: var(--space-3)
    }
  }

  /* ========== REDUCED MOTION ========== */
  @media (prefers-reduced-motion: reduce) {
    * {
      animation-duration: .001ms !important;
      animation-iteration-count: 1 !important;
      transition: none !important
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
              <!-- Toggle tema tunggal -->
              <label class="theme-switch" for="themeSwitch" title="Ganti tema">
                <i class="material-icons" aria-hidden="true">brightness_6</i>
                <input id="themeSwitch" type="checkbox" role="switch" aria-label="Toggle tema">
              </label>
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
  /* ========= THEME MANAGER (stabil & sinkron) ========= */
  (function() {
    const KEY = 'ui-theme';
    const html = document.documentElement;
    const switchEl = () => document.getElementById('themeSwitch');

    function setTheme(mode) {
      html.setAttribute('data-theme', mode);
      const sw = switchEl();
      if (sw) sw.checked = (mode === 'dark');
    }

    function getSystem() {
      return (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
    }

    // init: prioritas localStorage -> system
    const saved = localStorage.getItem(KEY);
    setTheme(saved === 'light' || saved === 'dark' ? saved : getSystem());

    // reaksi perubahan sistem (jika user tidak override)
    const media = window.matchMedia('(prefers-color-scheme: dark)');
    media.addEventListener?.('change', e => {
      const current = localStorage.getItem(KEY);
      if (!current) {
        setTheme(e.matches ? 'dark' : 'light');
      }
    });

    // toggle
    document.addEventListener('change', e => {
      if (e.target && e.target.id === 'themeSwitch') {
        const mode = e.target.checked ? 'dark' : 'light';
        localStorage.setItem(KEY, mode);
        setTheme(mode);
      }
    });

    // jika ingin reset ke system preference: localStorage.removeItem(KEY)
  })();

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