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

  /* Refresh button look & animation (match data admin) */
  .btn-refresh {
    border-radius: 12px;
    border-color: #e2e8f0;
    box-shadow: 0 6px 14px rgba(80, 120, 255, 0.12);
  }

  .btn-refresh .material-icons {
    color: #0b132b;
  }

  .btn-refresh[disabled] {
    opacity: .6;
    cursor: not-allowed;
    transform: none;
  }

  @keyframes spin360 {
    to {
      transform: rotate(360deg);
    }
  }

  .btn-refresh.is-loading .material-icons {
    animation: spin360 .9s linear infinite;
    color: #2563eb;
  }

  /* Collapsible table helpers */
  .collapse-gradient {
    position: relative;
  }

  .collapse-gradient::after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 36px;
    pointer-events: none;
    background: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, #ffffff 80%);
    display: none;
  }

  .is-collapsed.collapse-gradient::after {
    display: block;
  }

  .collapse-toggle {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    margin-top: 8px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #1e293b;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all .2s ease;
  }

  .collapse-toggle:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, .08);
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
              <button class="btn btn-refresh" type="button" onclick="refreshSection('departemen','#dataDepartemen', this)" aria-label="Refresh daftar departemen">
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
              <button class="btn btn-refresh" type="button" onclick="refreshSection('jabatan','#dataJabatan', this)" aria-label="Refresh daftar jabatan">
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
    // Reset flag agar collapsible dipasang ulang setelah konten diperbarui
    el.removeAttribute('data-collapsible-applied');
    el.innerHTML = `
    <div class="skeleton">
      <div class="sk-line" style="width:58%"></div>
      <div class="sk-line" style="width:92%"></div>
      <div class="sk-line" style="width:74%"></div>
    </div>`;
  }

  function refreshSection(kind, target, btnEl) {
    setSkeleton(target);
    // jika ada button, aktifkan animasi spin dan disable sementara
    if (btnEl) {
      btnEl.classList.add('is-loading');
      btnEl.disabled = true;
    }
    // observer satu-kali: hentikan loading ketika konten berubah
    try {
      const el = document.querySelector(target);
      if (el) {
        const once = new MutationObserver(() => {
          if (btnEl) {
            btnEl.classList.remove('is-loading');
            btnEl.disabled = false;
          }
          once.disconnect();
        });
        once.observe(el, {
          childList: true,
          subtree: true
        });
      }
    } catch (e) {}

    // jeda kecil supaya transisi terasa halus
    setTimeout(() => {
      fetchDepartemenJabatanData(kind, target);
    }, 160);
  }

  document.addEventListener('DOMContentLoaded', function() {
    // Ubah angka ini untuk menentukan jumlah baris awal yang ditampilkan
    // Contoh: window.__COLLAPSE_MAX = 8
    if (typeof window.__COLLAPSE_MAX !== 'number') {
      window.__COLLAPSE_MAX = 6;
    }

    refreshSection('departemen', '#dataDepartemen');
    refreshSection('jabatan', '#dataJabatan');

    /* ========== COLLAPSIBLE TABLE (apply on dynamic loads) ========== */
    function applyCollapsible(container) {
      const root = typeof container === 'string' ? document.querySelector(container) : container;
      if (!root) return;
      // Hindari loop observer: bila sudah diaplikasikan, jangan jalankan lagi
      if (root.dataset.collapsibleApplied === '1') return;
      const table = root.querySelector('table');
      if (!table) return;

      const rows = Array.from(table.querySelectorAll('tbody tr'));
      const wrapper = root; // body container already present

      // remove previous toggle if any
      const oldBtn = root.querySelector('.collapse-toggle');
      if (oldBtn) oldBtn.remove();

      // reset any previous state
      rows.forEach(r => r.style.removeProperty('display'));
      wrapper.classList.remove('is-collapsed', 'collapse-gradient');

      const MAX_VISIBLE = window.__COLLAPSE_MAX;
      if (rows.length <= MAX_VISIBLE) return;

      // hide beyond threshold
      rows.slice(MAX_VISIBLE).forEach(r => r.style.display = 'none');
      wrapper.classList.add('is-collapsed', 'collapse-gradient');

      // add toggle button
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'collapse-toggle';
      btn.innerHTML = '<i class="material-icons">unfold_more</i><span class="label">Lihat semua</span>';
      btn.addEventListener('click', () => {
        const collapsed = wrapper.classList.contains('is-collapsed');
        if (collapsed) {
          rows.forEach(r => r.style.removeProperty('display'));
          wrapper.classList.remove('is-collapsed');
          btn.innerHTML = '<i class="material-icons">unfold_less</i><span class="label">Sembunyikan</span>';
        } else {
          rows.slice(MAX_VISIBLE).forEach(r => r.style.display = 'none');
          wrapper.classList.add('is-collapsed');
          btn.innerHTML = '<i class="material-icons">unfold_more</i><span class="label">Lihat semua</span>';
        }
      });
      root.appendChild(btn);
      // Tandai sudah dipasang
      root.dataset.collapsibleApplied = '1';
    }

    // Expose globally so partials can trigger if needed
    window.__applyCollapsible = applyCollapsible;

    // Observe dynamic content replacement
    const targets = ['#dataDepartemen', '#dataJabatan'];
    targets.forEach(sel => {
      const el = document.querySelector(sel);
      if (!el) return;
      const observer = new MutationObserver(() => {
        // Debounce agar tidak loop akibat perubahan kecil pada DOM
        if (el.__collapsDebounce) cancelAnimationFrame(el.__collapsDebounce);
        el.__collapsDebounce = requestAnimationFrame(() => applyCollapsible(el));
      });
      observer.observe(el, {
        childList: true,
        subtree: true
      });
    });
  });
</script>

<?= $this->endSection() ?>