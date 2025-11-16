<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
   /* ====== Layout dasar ====== */
   .content {
      padding: 18px 0 28px !important;
      background: linear-gradient(180deg, var(--bg), color-mix(in oklab, var(--bg) 75%, #fff));
   }

   .card.modern {
      border-radius: var(--radius);
      border: 1px solid var(--border);
      background: var(--card);
      box-shadow: var(--shadow-1);
      overflow: hidden;
   }

   .card-header.gradient {
      border: 0;
      padding: 18px 20px;
      position: relative;
      background: linear-gradient(180deg, color-mix(in oklab, #eef7ff 70%, var(--card)), var(--card));
   }

   [data-theme="dark"] .card-header.gradient {
      background: linear-gradient(180deg, color-mix(in oklab, #0c1b33 45%, var(--card)), var(--card));
   }

   .card-header .title,
   .card-header .subtitle {
      color: var(--text) !important;
   }

   .title {
      margin: 0;
      font-weight: 800;
      letter-spacing: .2px;
      display: flex;
      align-items: center;
      gap: 10px;
   }

   .title i {
      color: var(--success);
   }

   .subtitle {
      margin-top: 2px;
      color: var(--muted) !important;
      font-weight: 600;
   }

   .toolbar {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: center;
   }

   /* ===== Input & button ===== */
   .input-pill {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--card-solid);
      border: 1px solid var(--border);
      border-radius: 999px;
      padding: 10px 14px;
      min-width: 260px;
      box-shadow: var(--shadow-2);
   }

   .input-pill input {
      border: 0;
      outline: 0;
      width: 100%;
      background: transparent;
      color: var(--text);
   }

   .input-pill .clear {
      border: 0;
      background: transparent;
      cursor: pointer;
      padding: 4px;
      display: none;
   }

   .btn-modern {
      border: 1px solid color-mix(in oklab, var(--primary) 25%, var(--border));
      background: linear-gradient(180deg, color-mix(in oklab, var(--primary) 8%, var(--card-solid)), var(--card-solid));
      color: var(--text);
      border-radius: 14px;
      padding: 10px 16px;
      font-weight: 800;
      display: inline-flex;
      gap: 8px;
      align-items: center;
      box-shadow: 0 10px 30px rgba(37, 99, 235, .08);
      transition: box-shadow .15s ease, opacity .15s ease;
   }

   .btn-modern[disabled] {
      opacity: .6;
      cursor: not-allowed;
   }

   .btn-modern.is-loading i,
   .material-icons.spin {
      animation: spin .9s linear infinite;
      display: inline-block;
      transform-origin: 50% 55%;
   }

   @keyframes spin {
      to {
         transform: rotate(360deg);
      }
   }

   .btn-primary {
      background: linear-gradient(135deg, var(--primary), color-mix(in oklab, var(--primary) 55%, #60a5fa));
      color: #fff;
      border: 0;
   }

   /* ===== Filter panel ===== */
   .filters-panel {
      display: none;
      margin: 10px 0 14px;
      padding: 12px;
      border: 1px solid var(--border);
      background: var(--card-solid);
      border-radius: 14px;
      box-shadow: var(--shadow-2);
   }

   .filters-panel.show {
      display: block;
      animation: fadeIn .18s ease both;
   }

   .filters-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(180px, 1fr));
      gap: 10px;
   }

   @media (max-width: 991.98px) {
      .filters-grid {
         grid-template-columns: repeat(2, minmax(160px, 1fr));
      }
   }

   @media (max-width: 575.98px) {
      .filters-grid {
         grid-template-columns: 1fr;
      }
   }

   .fctrl {
      display: flex;
      flex-direction: column;
      gap: 6px;
   }

   .fctrl label {
      font-size: 12px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: .04em;
   }

   .select-modern,
   .input-modern {
      width: 100%;
      border: 1px solid var(--border);
      background: var(--card);
      color: var(--text);
      border-radius: 12px;
      padding: 9px 12px;
      outline: none;
   }

   .select-modern:focus,
   .input-modern:focus {
      box-shadow: 0 0 0 3px color-mix(in oklab, var(--ring) 35%, transparent);
   }

   .filters-actions {
      display: flex;
      gap: 10px;
      justify-content: flex-end;
      margin-top: 6px;
   }

   .btn-secondary {
      background: var(--card);
      border: 1px solid var(--border);
      color: var(--text);
      border-radius: 12px;
      padding: 9px 14px;
      font-weight: 700;
   }

   /* ===== Table ===== */
   .table-wrap {
      position: relative;
      border: 1px solid var(--border);
      border-radius: 16px;
      background: var(--card-solid);
      overflow: hidden;
   }

   .data-container.fade-in {
      animation: fadeIn .22s ease both;
   }

   @keyframes fadeIn {
      from {
         opacity: 0;
         transform: translateY(3px);
      }

      to {
         opacity: 1;
         transform: none;
      }
   }

   table.data {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      font-size: 14px;
   }

   table.data thead th {
      position: sticky;
      top: 0;
      z-index: 1;
      background: color-mix(in oklab, var(--card-solid) 95%, #fff);
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: .04em;
      font-weight: 800;
      border-bottom: 1px solid var(--border);
      padding: 12px 14px;
   }

   table.data tbody td {
      padding: 12px 14px;
      border-bottom: 1px solid color-mix(in oklab, var(--border) 60%, transparent);
      vertical-align: middle;
      color: var(--text);
   }

   table.data tbody tr {
      transition: background .15s ease;
   }

   table.data tbody tr:hover {
      background: color-mix(in oklab, var(--primary) 6%, var(--card-solid));
   }

   .col-actions {
      width: 152px;
   }

   /* netralisir hover/striped bootstrap di dark mode */
   .table-wrap :is(.table-hover tbody tr:hover, .table-striped tbody tr:nth-of-type(odd)) {
      background: color-mix(in oklab, var(--card-solid) 92%, transparent) !important;
      color: var(--text) !important;
   }

   [data-theme="dark"] .table-wrap :is(.table-hover tbody tr:hover, .table-striped tbody tr:nth-of-type(odd)) {
      background: color-mix(in oklab, var(--primary) 12%, var(--card-solid)) !important;
      color: var(--text) !important;
   }

   [data-theme="dark"] ::selection {
      background: color-mix(in oklab, var(--primary) 35%, transparent);
      color: #fff;
   }

   /* ===== Tombol aksi ===== */
   .icon-btn {
      width: 40px;
      height: 40px;
      border-radius: 12px;
      display: inline-grid;
      place-items: center;
      color: #fff;
      border: 1px solid var(--border);
      box-shadow: var(--shadow-2);
   }

   .icon-btn[data-variant="edit"] {
      background: color-mix(in oklab, var(--success) 92%, #fff);
   }

   .icon-btn[data-variant="delete"] {
      background: color-mix(in oklab, var(--danger) 92%, #fff);
   }

   .icon-btn[data-variant="qr"] {
      background: color-mix(in oklab, var(--primary) 92%, #fff);
   }

   /* ===== SHIMMER (sama seperti sebelumnya, ringkas) ===== */
   .refresh-panel {
      display: none;
      position: relative;
      padding: 18px;
      border-radius: 16px;
      border: 1px dashed color-mix(in oklab, var(--text) 18%, transparent);
      background: linear-gradient(90deg, #ffffff 0%, #ffffff 45%, #f4f8ff 70%, #eef4ff 100%);
   }

   [data-theme="dark"] .refresh-panel {
      background: linear-gradient(90deg, color-mix(in oklab, var(--card-solid) 96%, #000) 0%, color-mix(in oklab, var(--card-solid) 96%, #000) 40%, color-mix(in oklab, var(--card-solid) 92%, #001428) 70%, color-mix(in oklab, var(--card-solid) 90%, #001d3a) 100%);
      border-color: color-mix(in oklab, #ffffff 18%, transparent);
   }

   .sbar {
      height: 66px;
      border-radius: 12px;
      background: linear-gradient(90deg, #fff 0%, #fff 35%, #f3f7ff 65%, #eaf1ff 100%);
   }

   [data-theme="dark"] .sbar {
      background: linear-gradient(90deg, color-mix(in oklab, var(--card-solid) 97%, #000) 0%, color-mix(in oklab, var(--card-solid) 95%, #000) 35%, color-mix(in oklab, var(--card-solid) 92%, #00203a) 65%, color-mix(in oklab, var(--card-solid) 90%, #00284d) 100%);
   }

   .sbar+.sbar {
      margin-top: 18px;
   }

   .refresh-panel::before {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: 16px;
      background: linear-gradient(90deg, transparent 0%, color-mix(in oklab, #e7efff 65%, transparent) 42%, color-mix(in oklab, #dfe9ff 78%, transparent) 50%, color-mix(in oklab, #e7efff 65%, transparent) 58%, transparent 100%);
      transform: translateX(-100%);
      animation: sweep 1.25s linear infinite;
   }

   [data-theme="dark"] .refresh-panel::before {
      background: linear-gradient(90deg, transparent 0%, color-mix(in oklab, var(--ring) 22%, transparent) 44%, color-mix(in oklab, var(--ring) 28%, transparent) 50%, color-mix(in oklab, var(--ring) 22%, transparent) 56%, transparent 100%);
      opacity: .7;
   }

   @keyframes sweep {
      to {
         transform: translateX(100%);
      }
   }

   /* ===== Meta ===== */
   .meta {
      display: flex;
      gap: 12px;
      align-items: center;
      color: var(--muted);
      margin-top: 12px;
   }

   .meta .dot {
      width: 6px;
      height: 6px;
      border-radius: 999px;
      background: var(--muted);
      opacity: .4;
   }
</style>

<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">

            <div class="card modern">
               <div class="card-header gradient">
                  <div class="d-flex flex-wrap align-items-center justify-content-between">
                     <div>
                        <h4 class="title"><i class="material-icons">task_alt</i> Data Supervisor</h4>
                        <div class="subtitle">Total Supervisor: <span style="background: var(--success); color: white; padding: 2px 8px; border-radius: 8px; font-weight: 700;"><?= $total_admin; ?></span> | <?= date('d M Y H:i'); ?></div>
                     </div>
                     <div class="toolbar">
                        <button type="button" class="btn-modern" id="filtersBtn">
                           <i class="material-icons">tune</i><span>Filter</span>
                        </button>
                        <button type="button" class="btn-modern" id="refreshBtn" aria-label="Refresh data">
                           <i class="material-icons" id="refreshIcon">refresh</i><span>Refresh</span>
                        </button>
                        <a class="btn-modern btn-primary" id="tabBtn" href="<?= base_url('admin/admin/create'); ?>">
                           <i class="material-icons">add</i><span>Tambah</span>
                        </a>
                     </div>
                  </div>
               </div>

               <div class="card-body">
                  <!-- Toolbar pencarian -->
                  <div class="toolbar mb-2">
                     <div class="input-pill">
                        <i class="material-icons" aria-hidden="true">search</i>
                        <input id="searchAdmin" type="text" placeholder="Cari nama, email, NIP… (tekan / untuk fokus)" aria-label="Input pencarian" autocomplete="off">
                        <button class="clear" id="clearSearch" aria-label="Bersihkan pencarian"><i class="material-icons">close</i></button>
                     </div>
                  </div>

                  <!-- FILTERS PANEL -->
                  <div class="filters-panel" id="filtersPanel" aria-label="Panel filter">
                     <div class="filters-grid">
                        <div class="fctrl">
                           <label for="fStatus">Status</label>
                           <select id="fStatus" class="select-modern">
                              <option value="all">Semua</option>
                              <option value="active">Aktif</option>
                              <option value="inactive">Non-aktif</option>
                           </select>
                        </div>
                        <div class="fctrl">
                           <label for="fGender">Jenis Kelamin</label>
                           <select id="fGender" class="select-modern">
                              <option value="all">Semua</option>
                              <option value="l">Laki-laki</option>
                              <option value="p">Perempuan</option>
                           </select>
                        </div>
                        <div class="fctrl">
                           <label for="fAddress">Alamat berisi</label>
                           <input id="fAddress" class="input-modern" type="text" placeholder="cth: Bandung">
                        </div>
                        <div class="fctrl">
                           <label for="fSort">Urutkan</label>
                           <select id="fSort" class="select-modern">
                              <option value="">Default (NO)</option>
                              <option value="name-asc">Nama (A–Z)</option>
                              <option value="name-desc">Nama (Z–A)</option>
                           </select>
                        </div>
                     </div>
                     <div class="filters-actions">
                        <button type="button" class="btn-secondary" id="filtersReset"><i class="material-icons" style="font-size:18px;">close</i>&nbsp;Reset</button>
                        <button type="button" class="btn-modern" id="filtersApply"><i class="material-icons" style="font-size:18px;">check</i>&nbsp;Terapkan</button>
                     </div>
                  </div>

                  <div class="table-wrap" id="tableWrap">
                     <!-- SHIMMER saat refresh -->
                     <div class="refresh-panel" id="refreshPanel" aria-hidden="true">
                        <div class="sbar"></div>
                        <div class="sbar"></div>
                        <div class="sbar"></div>
                     </div>

                     <!-- KONTEN ASLI -->
                     <div id="dataContainer" class="data-container">
                        <table class="data" aria-label="Tabel data supervisor">
                           <thead>
                              <tr>
                                 <th>NO</th>
                                 <th>NIP</th>
                                 <th>Nama Supervisor</th>
                                 <th class="hide-sm">Jenis Kelamin</th>
                                 <th>No HP</th>
                                 <th class="hide-sm">Alamat</th>
                                 <th class="hide-sm">Tanggal Join</th>
                                 <th>Status Approval</th>
                                 <th class="col-actions">Aksi</th>
                              </tr>
                           </thead>
                           <tbody id="tbodyInit">
                              <tr>
                                 <td colspan="9" style="padding:18px; color:var(--muted);">Memuat data…</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>

                  <div class="meta">
                     <i class="material-icons" style="font-size:18px;">info</i>
                     <span>Data diperbarui berdasarkan tanggal yang dipilih.</span>
                     <span class="dot"></span>
                     <span id="metaCount">Menampilkan 0 dari 0</span>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>

<script>
   /* ===== Ikon refresh berputar + state tombol ===== */
   function setRefreshing(on) {
      const btn = document.getElementById('refreshBtn');
      const ico = document.getElementById('refreshIcon');
      if (!btn || !ico) return;
      btn.disabled = on;
      btn.classList.toggle('is-loading', on);
      if (on) {
         ico.textContent = 'autorenew';
         ico.classList.add('spin');
      } else {
         ico.textContent = 'refresh';
         ico.classList.remove('spin');
      }
   }

   /* ===== Shimmer show/hide ===== */
   function showShimmer() {
      document.getElementById('tableWrap')?.classList.add('is-refreshing');
   }

   function hideShimmer() {
      const wrap = document.getElementById('tableWrap');
      wrap?.classList.remove('is-refreshing');
      const data = document.getElementById('dataContainer');
      if (data) {
         data.classList.add('fade-in');
         setTimeout(() => data.classList.remove('fade-in'), 260);
      }
   }

   /* ===== Init ===== */
   document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('refreshBtn')?.addEventListener('click', (e) => {
         e.preventDefault();
         e.stopPropagation();
         getDataAdmin();
      });
      document.getElementById('filtersBtn')?.addEventListener('click', () => {
         document.getElementById('filtersPanel').classList.toggle('show');
      });
      document.getElementById('filtersApply')?.addEventListener('click', () => {
         document.getElementById('filtersPanel').classList.remove('show');
         applyFiltersAndSort();
      });
      document.getElementById('filtersReset')?.addEventListener('click', resetFilters);

      bindSearch();
      getDataAdmin();

      document.addEventListener('keydown', (e) => {
         if (e.key === '/' && document.activeElement.tagName !== 'INPUT') {
            e.preventDefault();
            document.getElementById('searchAdmin').focus();
         }
         if (e.key.toLowerCase() === 'r' && !e.metaKey && !e.ctrlKey) {
            getDataAdmin();
         }
      });
   });

   /* ===== AJAX load ===== */
   const MIN_LOADING_MS = 450;

   function getDataAdmin() {
      setRefreshing(true);
      showShimmer();
      const tokenName = (window.BaseConfig && BaseConfig.csrfTokenName) ? BaseConfig.csrfTokenName : '';
      const tokenVal = tokenName ? (document.querySelector(`meta[name="${tokenName}"]`)?.getAttribute('content') || '') : '';
      const start = Date.now();

      jQuery.ajax({
         url: "<?= base_url('/admin/admin'); ?>",
         type: 'post',
         data: tokenName ? {
            [tokenName]: tokenVal
         } : {},
         success: function(resp) {
            const dataEl = document.getElementById('dataContainer');
            if (dataEl) {
               dataEl.innerHTML = resp;
               decorateIncomingTable();
               updateCounts();
               applyFiltersAndSort(true);
            }
         },
         error: function(_, __, thrown) {
            const dataEl = document.getElementById('dataContainer');
            if (dataEl) {
               dataEl.innerHTML = `<div class="p-3">Gagal memuat data: <b>${thrown}</b></div>`;
            }
         },
         complete: function() {
            const elapsed = Date.now() - start;
            const remain = Math.max(0, MIN_LOADING_MS - elapsed);
            setTimeout(() => {
               hideShimmer();
               setRefreshing(false);
            }, remain);
         }
      });
   }

   /* ===== Search ===== */
   function bindSearch() {
      const input = document.getElementById('searchAdmin');
      const clearBtn = document.getElementById('clearSearch');
      if (!input) return;
      let t;
      input.addEventListener('input', function() {
         clearBtn.style.display = input.value ? 'inline-grid' : 'none';
         clearTimeout(t);
         t = setTimeout(() => applyFiltersAndSort(), 140);
      });
      clearBtn.addEventListener('click', () => {
         input.value = '';
         clearBtn.style.display = 'none';
         applyFiltersAndSort();
         input.focus();
      });
   }

   /* ===== Filter state ===== */
   const Filters = {
      status: 'all',
      gender: 'all',
      address: '',
      sort: ''
   };
   const COLS = {
      no: 0,
      nuptk: 1,
      nama: 2,
      jk: 3,
      hp: 4,
      alamat: 5
   }; // fallback; akan di-deteksi ulang

   function readFiltersFromUI() {
      Filters.status = document.getElementById('fStatus')?.value || 'all';
      Filters.gender = document.getElementById('fGender')?.value || 'all';
      Filters.address = (document.getElementById('fAddress')?.value || '').trim().toLowerCase();
      Filters.sort = document.getElementById('fSort')?.value || '';
   }

   function resetFilters() {
      document.getElementById('fStatus').value = 'all';
      document.getElementById('fGender').value = 'all';
      document.getElementById('fAddress').value = '';
      document.getElementById('fSort').value = '';
      applyFiltersAndSort();
   }

   /* ===== Apply filters + sorting (client-side) ===== */
   function applyFiltersAndSort(skipScroll) {
      readFiltersFromUI();
      const q = (document.getElementById('searchAdmin')?.value || '').toLowerCase().trim();
      const tbl = document.querySelector('#dataContainer table');
      if (!tbl) return;
      const tbody = tbl.tBodies[0];
      if (!tbody) return;
      const rows = [...tbody.rows];

      // Filter logic
      let shown = 0;
      rows.forEach(tr => {
         const textAll = tr.innerText.toLowerCase();

         // status (aktif/non-aktif) berdasarkan text baris
         let status = '';
         if (/non.?aktif|tidak.?aktif|inactive/.test(textAll)) status = 'inactive';
         else if (/aktif|active/.test(textAll)) status = 'active';

         // gender dari kolom
         const jkCell = tr.cells[_colIdx.jk] || tr.cells[COLS.jk];
         const jkText = (jkCell?.innerText || '').toLowerCase();
         const g = /perempuan|female|wanita|p\b/.test(jkText) ? 'p' : (/laki|male|pria|l\b/.test(jkText) ? 'l' : '');

         // alamat kolom
         const alamatCell = tr.cells[_colIdx.alamat] || tr.cells[COLS.alamat];
         const alamatText = (alamatCell?.innerText || '').toLowerCase();

         const matchSearch = !q || textAll.includes(q);
         const matchStatus = (Filters.status === 'all') || (status === Filters.status);
         const matchGender = (Filters.gender === 'all') || (g === Filters.gender);
         const matchAlamat = !Filters.address || alamatText.includes(Filters.address);

         const ok = matchSearch && matchStatus && matchGender && matchAlamat;
         tr.style.display = ok ? '' : 'none';
         if (ok) shown++;
      });

      // Sorting (by name only to keep it safe)
      if (Filters.sort) {
         const nameIdx = _colIdx.nama ?? COLS.nama;
         rows.sort((a, b) => {
            const A = (a.cells[nameIdx]?.innerText || '').trim().toLowerCase();
            const B = (b.cells[nameIdx]?.innerText || '').trim().toLowerCase();
            return Filters.sort === 'name-asc' ? A.localeCompare(B) : B.localeCompare(A);
         }).forEach(tr => tbody.appendChild(tr));
      }

      setShown(shown, rows.length);
      if (!skipScroll) {
         try {
            document.querySelector('.table-wrap').scrollIntoView({
               behavior: 'smooth',
               block: 'start'
            });
         } catch (e) {}
      }
   }

   /* ===== Detect & decorate table from server ===== */
   let _colIdx = {
      no: 0,
      nuptk: 1,
      nama: 2,
      jk: 3,
      hp: 4,
      alamat: 5
   };

   function decorateIncomingTable() {
      const tbl = document.querySelector('#dataContainer table');
      if (!tbl) return;

      // netralisir kelas bootstrap yang bisa ganggu dark mode
      ['table-hover', 'table-striped', 'table-dark', 'table-light'].forEach(c => tbl.classList.remove(c));
      tbl.classList.add('data');

      // deteksi index kolom berdasarkan header text
      const ths = [...(tbl.tHead?.rows?.[0]?.cells || [])].map((th, i) => ({
         i,
         t: th.innerText.trim().toLowerCase()
      }));
      const map = {};
      ths.forEach(({
         i,
         t
      }) => {
         if (t.includes('nuptk')) map.nuptk = i;
         else if (t.includes('nama')) map.nama = i;
         else if (t.includes('jenis') || t.includes('kelamin')) map.jk = i;
         else if (t.includes('no hp') || t.includes('hp') || t.includes('telepon')) map.hp = i;
         else if (t.includes('alamat')) map.alamat = i;
         else if (t === 'no' || t.includes('no ')) map.no = i;
      });
      _colIdx = Object.assign(_colIdx, map);

      // gaya cell
      tbl.querySelectorAll('td, th').forEach(td => {
         td.style.verticalAlign = 'middle';
      });

      // tombol aksi -> ikon-only berwarna
      tbl.querySelectorAll('td .btn, td button, td a').forEach(el => {
         if (!el.classList.contains('icon-btn')) el.classList.add('icon-btn');
         const txt = (el.title || el.innerText || '').toLowerCase();
         if (/edit/.test(txt)) {
            el.setAttribute('data-variant', 'edit');
            el.title = el.title || 'Edit';
            el.setAttribute('aria-label', 'Edit');
         }
         if (/hapus|delete/.test(txt)) {
            el.setAttribute('data-variant', 'delete');
            el.title = el.title || 'Hapus';
            el.setAttribute('aria-label', 'Hapus');
         }
         if (/qr/.test(txt)) {
            el.setAttribute('data-variant', 'qr');
            el.title = el.title || 'QR';
            el.setAttribute('aria-label', 'QR');
         }
         const ico = el.querySelector('i.material-icons');
         if (ico) {
            el.innerHTML = ico.outerHTML;
         }
      });
   }

   /* ===== Counter ===== */
   function updateCounts() {
      const tbl = document.querySelector('#dataContainer table');
      const total = tbl?.tBodies?.[0]?.rows.length || 0;
      setShown(total, total);
   }

   function setShown(shown, total) {
      const meta = document.getElementById('metaCount');
      if (meta) meta.textContent = `Menampilkan ${shown} dari ${total}`;
   }
</script>

<?= $this->endSection() ?>