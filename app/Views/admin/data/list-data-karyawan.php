<style>
   /* ====== Tabel responsif & rapi ====== */
   .table-wrap {
      position: relative;
   }

   .table-wrap .table {
      min-width: 920px;
      /* aman untuk kolom banyak; tetap bisa di-scroll */
      font-size: clamp(13px, 1.8vw, 14px);
   }

   .table thead th {
      white-space: nowrap;
      vertical-align: middle;
      color: #2e7d32;
      font-weight: 700;
      border-bottom: 2px solid rgba(16, 24, 40, .08);
      padding-top: .9rem;
      padding-bottom: .9rem;
   }

   .table tbody td {
      vertical-align: middle;
      padding-top: 14px;
      padding-bottom: 14px;
      border-bottom: 0;
   }

   .table tbody tr:hover td {
      background: #fff3d6;
      /* krem sedikit lebih kuat saat hover */
   }

   /* ====== Grid like example (bordered table) ====== */
   .table-grid {
      border-collapse: separate;
      border-spacing: 0;
   }

   .table-grid thead th,
   .table-grid tbody td {
      border: 0 !important;
      background-clip: padding-box;
   }

   .table-grid thead th {
      background: #ffe3b8;
      /* krem sedikit lebih tua untuk header */
      color: #2e7d32;
   }

   /* Center all header and cell text for grid table */
   .table-grid th,
   .table-grid td {
      text-align: center !important;
   }

   /* Ensure any left-text helper is centered within grid usage */
   .table-grid .td-text-left,
   .table-grid .td-name {
      text-align: center;
   }

   /* Center actions column on desktop */
   .table-grid td.td-actions {
      text-align: center;
   }

   /* ====== Cream row background (all rows) ====== */
   .table-grid tbody td {
      background-color: #fffaf0;
      /* krem tipis untuk semua baris */
   }

   /* ====== Column sizing & alignment ====== */
   .col-no {
      width: 56px;
      text-align: center;
   }

   .col-check {
      width: 44px;
      text-align: center;
   }

   .col-nip {
      width: 140px;
      white-space: nowrap;
   }

   .col-gender {
      width: 120px;
      text-align: center;
      white-space: nowrap;
   }

   .col-dept {
      width: 140px;
      white-space: nowrap;
   }

   .col-jabatan {
      width: 140px;
      white-space: nowrap;
   }

   .col-hp {
      width: 160px;
      white-space: nowrap;
   }

   .col-join {
      width: 140px;
      white-space: nowrap;
      text-align: center;
   }

   .col-status {
      width: 160px;
      text-align: center;
   }

   .col-actions {
      width: 1%;
      white-space: nowrap;
   }

   .td-text-left {
      text-align: left;
   }

   .td-text-center {
      text-align: center;
   }

   /* Prevent layout jump for long names */
   .td-name {
      max-width: 260px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
   }

   /* Header lengket saat di-scroll (opsional, boleh hapus 3 baris di bawah) */
   .table thead th.sticky-top {
      position: sticky;
      top: 0;
      z-index: 2;
      background: var(--card, #fff);
   }

   /* Override sticky header background for grid table to cream */
   .table-grid thead th.sticky-top {
      background: #ffe3b8 !important;
   }

   /* Kolom aksi: tombol seragam */
   .td-actions,
   .col-actions {
      white-space: nowrap;
   }

   /* Jadikan sel aksi flex agar benar-benar center */
   .td-actions {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 12px;
   }

   .td-actions .btn {
      width: 40px;
      height: 40px;
      padding: 0 !important;
      border-radius: 10px;
      display: inline-grid;
      place-items: center;
      line-height: 1;
   }

   .td-actions form {
      margin: 0;
   }

   .td-actions .material-icons {
      font-size: 20px;
      color: #fff;
   }

   /* ====== Mode "card" di perangkat kecil ====== */
   @media (max-width: 576px) {
      .table-wrap .table {
         min-width: unset;
      }

      .table thead {
         display: none;
      }

      .table tbody tr {
         display: block;
         border: 0;
         border-radius: 12px;
         background: var(--card, #fff);
         margin-bottom: 12px;
         box-shadow: var(--shadow-1, 0 8px 24px rgba(0, 0, 0, .06));
         overflow: hidden;
      }

      .table tbody td {
         display: flex;
         align-items: center;
         justify-content: space-between;
         gap: 10px;
         padding: .65rem .9rem;
         border-top: 0;
      }

      .table tbody td:first-child {
         border-top: 0;
      }

      .table tbody td::before {
         content: attr(data-label);
         font-weight: 700;
         color: var(--muted, #6b7b93);
         margin-right: 12px;
         text-align: left;
         flex: 0 0 auto;
      }

      /* Kolom aksi di HP */
      .td-actions {
         display: flex;
         justify-content: center;
         gap: 6px;
         padding-bottom: .8rem;
      }

      .td-actions .btn {
         width: 36px;
         height: 36px;
         border-radius: 8px;
      }

      .td-actions .material-icons {
         font-size: 18px;
      }
   }

   /* ====== Status Approval Badge ====== */
   .badge {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 6px 14px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
   }

   .badge-warning {
      background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
      color: white;
      box-shadow: 0 2px 8px rgba(255, 152, 0, 0.3);
   }

   .badge-success {
      background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
      color: white;
      box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);
   }

   .badge .material-icons {
      font-size: 14px;
      vertical-align: middle;
   }

   /* ====== Column controls & helpers ====== */
   .col-controls {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 10px 16px;
      margin: 10px 0 14px;
      padding: 10px 12px;
      background: #fff8e6;
      /* krem sangat tipis untuk kontrol */
      border-radius: 10px;
   }

   .col-controls .label {
      color: #2e7d32;
      font-weight: 700;
      margin-right: 8px;
   }

   .is-hidden {
      display: none !important;
   }

   /* ====== Toggle chip (Lihat semua) ====== */
   .toggle-chip {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 6px 10px;
      /* smaller size */
      border-radius: 10px;
      border: 1px solid rgba(16, 24, 40, .14);
      background: #fff;
      cursor: pointer;
      font-weight: 700;
      color: #0f172a;
      transition: box-shadow .2s ease, transform .05s ease;
      user-select: none;
   }

   .toggle-chip:active {
      transform: translateY(1px);
   }

   .toggle-chip:hover {
      box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
   }

   .toggle-chip .chevrons {
      display: inline-grid;
      gap: 2px;
      color: #0f172a;
      font-size: 12px;
      /* smaller chevrons */
      line-height: 1;
   }

   .row-hidden {
      display: none !important;
   }
</style>

<div class="card-body table-responsive table-wrap">
   <?php if (!$empty) : ?>
      <!-- Total Karyawan Info -->
      <div class="mb-3" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); border-radius: 8px; border-left: 4px solid #2196f3;">
         <div style="display: flex; align-items: center; gap: 8px;">
            <i class="material-icons" style="color: #2196f3; font-size: 24px;">people</i>
            <span style="font-weight: 700; color: #1976d2; font-size: 16px;">Total Karyawan: <span style="background: #1976d2; color: white; padding: 4px 8px; border-radius: 12px; font-size: 14px;"><?= $total_karyawan; ?></span></span>
         </div>
         <div style="color: #666; font-size: 14px;">
            <i class="material-icons" style="font-size: 18px; vertical-align: middle;">schedule</i>
            <?= date('d M Y H:i'); ?>
         </div>
      </div>

      <div id="columnControls" class="col-controls is-hidden"></div>

      <table class="table table-hover table-grid" id="karyawanTable">
         <thead class="text-primary">
            <tr>
               <th class="sticky-top col-check" width="20">
                  <input type="checkbox" class="checkbox-table" id="checkAll">
               </th>
               <th class="sticky-top col-no"><b>No.</b></th>
               <th class="sticky-top col-nip"><b>NIP</b></th>
               <th class="sticky-top"><b>Nama Karyawan</b></th>
               <th class="sticky-top col-gender"><b>Jenis Kelamin</b></th>
               <th class="sticky-top col-dept"><b>Departemen</b></th>
               <th class="sticky-top col-jabatan"><b>Grade</b></th>
               <th class="sticky-top col-hp"><b>No HP</b></th>
               <th class="sticky-top col-join"><b>Tanggal Join</b></th>
               <th class="sticky-top col-status"><b>Status Approval</b></th>
               <th class="sticky-top col-actions" width="1%"><b>Aksi</b></th>
            </tr>
         </thead>
         <tbody>
            <?php $i = 1;
            foreach ($data as $value) : ?>
               <tr>
                  <td class="td-text-center" data-label="">
                     <input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $value['id_karyawan']; ?>">
                  </td>
                  <td class="td-text-center" data-label="No"><?= $i; ?></td>
                  <td class="td-text-left" data-label="NIP"><?= $value['nis']; ?></td>
                  <td class="td-name" data-label="Nama Karyawan"><b><?= $value['nama_karyawan']; ?></b></td>
                  <td class="td-text-center" data-label="Jenis Kelamin"><?= $value['jenis_kelamin']; ?></td>
                  <td class="td-text-left" data-label="Departemen"><?= $value['departemen']; ?></td>
                  <td class="td-text-left" data-label="Jabatan"><?= $value['jabatan']; ?></td>
                  <td class="td-text-left" data-label="No HP"><?= $value['no_hp']; ?></td>
                  <td class="td-text-center" data-label="Tanggal Join"><?= !empty($value['tanggal_join']) ? date('d M Y', strtotime($value['tanggal_join'])) : '-'; ?></td>
                  <td class="td-text-center" data-label="Status Approval">
                     <?php
                     // Cek status approval untuk record ini
                     $approvalModel = new \App\Models\ApprovalModel();
                     $pendingRequests = $approvalModel->where('table_name', 'tb_karyawan')
                        ->where('record_id', $value['id_karyawan'])
                        ->where('status', 'pending')
                        ->findAll();

                     if (!empty($pendingRequests)): ?>
                        <span class="badge badge-warning">
                           <i class="material-icons" style="font-size: 14px; vertical-align: middle;">schedule</i>
                           Pending Approval
                        </span>
                     <?php else: ?>
                        <span class="badge badge-success">
                           <i class="material-icons" style="font-size: 14px; vertical-align: middle;">check_circle</i>
                           Approved
                        </span>
                     <?php endif; ?>
                  </td>
                  <td data-label="Aksi" class="td-actions">
                     <a title="Edit" href="<?= base_url('admin/karyawan/edit/' . $value['id_karyawan']); ?>" class="btn btn-primary" id="<?= $value['nis']; ?>">
                        <i class="material-icons">edit</i>
                     </a>

                     <form action="<?= base_url('admin/karyawan/delete/' . $value['id_karyawan']); ?>" method="post" class="d-inline">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button title="Delete" onclick="return confirm('Konfirmasi untuk menghapus data');" type="submit" class="btn btn-danger" id="<?= $value['nis']; ?>">
                           <i class="material-icons">delete_forever</i>
                        </button>
                     </form>

                     <a title="Download QR Code" href="<?= base_url('admin/qr/karyawan/' . $value['id_karyawan'] . '/download'); ?>" class="btn btn-success">
                        <i class="material-icons">qr_code</i>
                     </a>
                  </td>
               </tr>
            <?php $i++;
            endforeach; ?>
         </tbody>
      </table>

      <!-- Toggle placed below the table -->
      <div style="margin-top: 10px;">
         <div id="toggleControls" class="toggle-chip" role="button" aria-expanded="false">
            <span class="chevrons">▲<br>▼</span>
            <span class="toggle-label">Lihat semua</span>
         </div>
      </div>

      <script>
         (function() {
            const table = document.getElementById('karyawanTable');
            if (!table) return;

            const storageKey = 'karyawanTable.hiddenColumns';
            const controls = document.getElementById('columnControls');
            const toggle = document.getElementById('toggleControls');
            // Row limit toggle like departemen/jabatan
            const showLimit = 10; // jumlah baris awal yang ditampilkan
            const showKey = 'karyawanTable.showAll';

            // Build columns list from current thead
            const ths = Array.from(table.querySelectorAll('thead th'));
            // Skip the first checkbox column from auto-controls (index 0)
            const columns = ths.map((th, idx) => ({
               index: idx,
               label: (th.textContent || '').trim() || `Kolom ${idx + 1}`
            }));

            // Render controls
            const left = document.createElement('span');
            left.className = 'label';
            left.textContent = 'Tampilkan kolom:';
            controls.appendChild(left);

            const saved = JSON.parse(localStorage.getItem(storageKey) || '{}');

            columns.forEach(col => {
               // Create control for each column except the very first empty/checkbox header
               const wrapper = document.createElement('label');
               wrapper.style.display = 'inline-flex';
               wrapper.style.alignItems = 'center';
               wrapper.style.gap = '6px';

               const cb = document.createElement('input');
               cb.type = 'checkbox';
               cb.checked = saved[col.index] !== false; // default shown unless saved false
               cb.dataset.index = String(col.index);

               const span = document.createElement('span');
               span.textContent = col.label;

               wrapper.appendChild(cb);
               wrapper.appendChild(span);
               controls.appendChild(wrapper);
            });

            function applyVisibility() {
               const state = {};
               controls.querySelectorAll('input[type="checkbox"]').forEach(input => {
                  const idx = Number(input.dataset.index);
                  const show = input.checked;
                  state[idx] = show;
                  // Loop all rows (thead/tbody) and toggle the matching cell
                  table.querySelectorAll('tr').forEach(tr => {
                     const cell = tr.children[idx];
                     if (cell) {
                        cell.classList.toggle('is-hidden', !show);
                     }
                  });
               });
               localStorage.setItem(storageKey, JSON.stringify(state));
            }

            // Apply initial from saved state
            // Ensure we call after controls created
            applyVisibility();

            // Bind change (column visibility)
            controls.addEventListener('change', function(e) {
               if (e.target && e.target.matches('input[type="checkbox"]')) {
                  applyVisibility();
               }
            });
            // ===== Row Hide/Unhide (lihat semua) =====
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            function updateToggleLabel(showAll) {
               const label = toggle.querySelector('.toggle-label');
               if (rows.length <= showLimit) {
                  toggle.style.display = 'none';
               } else {
                  toggle.style.display = 'inline-flex';
                  label.textContent = showAll ? 'Sembunyikan' : 'Lihat semua';
               }
            }

            function applyRowLimit(showAll) {
               rows.forEach((tr, idx) => {
                  tr.classList.toggle('row-hidden', !showAll && idx >= showLimit);
               });
               localStorage.setItem(showKey, showAll ? '1' : '0');
               updateToggleLabel(showAll);
            }

            const savedShowAll = localStorage.getItem(showKey) === '1';
            applyRowLimit(savedShowAll);

            toggle.addEventListener('click', function() {
               const current = localStorage.getItem(showKey) === '1';
               applyRowLimit(!current);
            });
         })();
      </script>
   <?php else : ?>
      <div class="row">
         <div class="col">
            <h4 class="text-center text-danger">Data tidak ditemukan</h4>
         </div>
      </div>
   <?php endif; ?>
</div>