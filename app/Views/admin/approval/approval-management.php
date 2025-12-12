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
      color: var(--warning);
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

   /* ===== Refresh Button (match Data Admin style) ===== */
   .btn-modern {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 14px;
      border-radius: 12px;
      border: 1px solid var(--border);
      background: color-mix(in oklab, var(--card-solid) 90%, transparent);
      color: var(--text);
      font-weight: 800;
      box-shadow: var(--neon);
      transition: transform .12s ease, box-shadow .12s ease;
   }

   .btn-modern:hover {
      transform: translateY(-1px);
   }

   .btn-modern[disabled] {
      opacity: .6;
      cursor: not-allowed;
      transform: none;
   }

   .btn-modern .material-icons {
      color: var(--text);
   }

   @keyframes spin360 {
      to {
         transform: rotate(360deg);
      }
   }

   .btn-modern.is-loading .material-icons {
      animation: spin360 .9s linear infinite;
      color: var(--ring);
   }

   /* ===== Stats Cards ===== */
   .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 16px;
      margin-bottom: 24px;
   }

   .stat-card {
      background: var(--card-solid);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 20px;
      text-align: center;
      box-shadow: var(--shadow-2);
   }

   .stat-card.pending {
      border-color: var(--warning);
      background: linear-gradient(135deg, color-mix(in oklab, var(--warning) 8%, var(--card-solid)), var(--card-solid));
   }

   .stat-card.approved {
      border-color: var(--success);
      background: linear-gradient(135deg, color-mix(in oklab, var(--success) 8%, var(--card-solid)), var(--card-solid));
   }

   .stat-card.rejected {
      border-color: var(--danger);
      background: linear-gradient(135deg, color-mix(in oklab, var(--danger) 8%, var(--card-solid)), var(--card-solid));
   }

   .stat-card.total {
      border-color: var(--primary);
      background: linear-gradient(135deg, color-mix(in oklab, var(--primary) 8%, var(--card-solid)), var(--card-solid));
   }

   .stat-number {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 8px;
   }

   .stat-label {
      font-size: 14px;
      font-weight: 600;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
   }

   /* ===== Filter buttons ===== */
   .filter-buttons {
      display: flex;
      gap: 8px;
      margin-bottom: 20px;
      flex-wrap: wrap;
   }

   .filter-btn {
      padding: 8px 16px;
      border: 1px solid var(--border);
      background: var(--card);
      color: var(--text);
      border-radius: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.15s ease;
   }

   .filter-btn.active {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary);
   }

   .filter-btn:hover {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary);
   }

   /* ===== Bulk actions ===== */
   .bulk-actions {
      display: none;
      padding: 12px 16px;
      background: var(--card-solid);
      border: 1px solid var(--border);
      border-radius: 12px;
      margin-bottom: 16px;
      align-items: center;
      gap: 12px;
   }

   .bulk-actions.show {
      display: flex;
   }

   .bulk-actions .selected-count {
      font-weight: 600;
      color: var(--text);
   }

   .bulk-actions .btn {
      padding: 6px 12px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 14px;
   }

   .bulk-actions .btn-success {
      background: var(--success);
      color: #fff;
      border: 1px solid var(--success);
   }

   .bulk-actions .btn-danger {
      background: var(--danger);
      color: #fff;
      border: 1px solid var(--danger);
   }

   /* ===== Table ===== */
   .table-wrap {
      position: relative;
      border: 1px solid var(--border);
      border-radius: 16px;
      background: var(--card-solid);
      overflow: hidden;
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

   /* ===== Status badges ===== */
   .status-badge {
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
   }

   .status-badge.pending {
      background: color-mix(in oklab, var(--warning) 20%, transparent);
      color: var(--warning);
      border: 1px solid color-mix(in oklab, var(--warning) 40%, transparent);
   }

   .status-badge.approved {
      background: color-mix(in oklab, var(--success) 20%, transparent);
      color: var(--success);
      border: 1px solid color-mix(in oklab, var(--success) 40%, transparent);
   }

   .status-badge.rejected {
      background: color-mix(in oklab, var(--danger) 20%, transparent);
      color: var(--danger);
      border: 1px solid color-mix(in oklab, var(--danger) 40%, transparent);
   }

   /* ===== Action buttons ===== */
   .action-buttons {
      display: flex;
      gap: 6px;
   }

   .btn-sm {
      padding: 6px 12px;
      font-size: 12px;
      border-radius: 8px;
      font-weight: 600;
   }

   .btn-success {
      background: var(--success);
      color: #fff;
      border: 1px solid var(--success);
   }

   .btn-danger {
      background: var(--danger);
      color: #fff;
      border: 1px solid var(--danger);
   }

   .btn-info {
      background: var(--info);
      color: #fff;
      border: 1px solid var(--info);
   }

   /* ===== Checkbox ===== */
   .checkbox-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
   }

   .checkbox-wrapper input[type="checkbox"] {
      width: 18px;
      height: 18px;
      accent-color: var(--primary);
   }
</style>

<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">

            <!-- Stats Cards -->
            <div class="stats-grid">
               <div class="stat-card total">
                  <div class="stat-number" id="totalRequests"><?= $stats['total'] ?></div>
                  <div class="stat-label">Total Requests</div>
               </div>
               <div class="stat-card pending">
                  <div class="stat-number" id="pendingRequests"><?= $stats['pending'] ?></div>
                  <div class="stat-label">Pending</div>
               </div>
               <div class="stat-card approved">
                  <div class="stat-number" id="approvedRequests"><?= $stats['approved'] ?></div>
                  <div class="stat-label">Approved</div>
               </div>
               <div class="stat-card rejected">
                  <div class="stat-number" id="rejectedRequests"><?= $stats['rejected'] ?></div>
                  <div class="stat-label">Rejected</div>
               </div>
            </div>

            <div class="card modern">
               <div class="card-header gradient">
                  <div class="d-flex flex-wrap align-items-center justify-content-between">
                     <div>
                        <h4 class="title"><i class="material-icons">approval</i> Manajemen Approval</h4>
                        <div class="subtitle">Kelola request approval dari admin</div>
                     </div>
                     <div class="toolbar">
                        <button type="button" class="btn-modern" id="refreshBtn" aria-label="Refresh data">
                           <i class="material-icons" id="refreshIcon">refresh</i><span>Refresh</span>
                        </button>
                     </div>
                  </div>
               </div>

               <div class="card-body">
                  <!-- Filter buttons -->
                  <div class="filter-buttons">
                     <button class="filter-btn active" data-status="all">Semua</button>
                     <button class="filter-btn" data-status="pending">Pending</button>
                     <button class="filter-btn" data-status="approved">Approved</button>
                     <button class="filter-btn" data-status="rejected">Rejected</button>
                  </div>

                  <!-- Bulk actions -->
                  <div class="bulk-actions" id="bulkActions">
                     <span class="selected-count" id="selectedCount">0 item dipilih</span>
                     <button class="btn btn-success" id="bulkApproveBtn">Approve Selected</button>
                     <button class="btn btn-danger" id="bulkRejectBtn">Reject Selected</button>
                  </div>

                  <div class="table-wrap" id="tableWrap">
                     <!-- KONTEN ASLI -->
                     <div id="dataContainer" class="data-container">
                        <table class="data" aria-label="Tabel approval requests">
                           <thead>
                              <tr>
                                 <th width="40">
                                    <input type="checkbox" id="selectAll" />
                                 </th>
                                 <th>ID</th>
                                 <th>Type</th>
                                 <th>Table</th>
                                 <th>Requested By</th>
                                 <th>Status</th>
                                 <th>Created</th>
                                 <th width="120">Actions</th>
                              </tr>
                           </thead>
                           <tbody id="tbodyInit">
                              <tr>
                                 <td colspan="8" style="padding:18px; color:var(--muted);">Memuat data…</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>

<script>
   let currentStatus = 'all';
   let selectedItems = new Set();

   /* ===== Init ===== */
   document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('refreshBtn')?.addEventListener('click', () => {
         getApprovalRequests();
      });

      // Filter buttons
      document.querySelectorAll('.filter-btn').forEach(btn => {
         btn.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentStatus = btn.dataset.status;
            getApprovalRequests();
         });
      });

      // Select all checkbox
      document.getElementById('selectAll')?.addEventListener('change', (e) => {
         const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
         checkboxes.forEach(cb => {
            cb.checked = e.target.checked;
            if (e.target.checked) {
               selectedItems.add(cb.value);
            } else {
               selectedItems.delete(cb.value);
            }
         });
         updateBulkActions();
      });

      // Bulk actions
      document.getElementById('bulkApproveBtn')?.addEventListener('click', bulkApprove);
      document.getElementById('bulkRejectBtn')?.addEventListener('click', bulkReject);

      getApprovalRequests();
   });

   /* ===== AJAX load ===== */
   function getApprovalRequests() {
      const $btn = jQuery('#refreshBtn');
      if ($btn.length) {
         $btn.addClass('is-loading').prop('disabled', true);
      }
      const tokenName = (window.BaseConfig && BaseConfig.csrfTokenName) ? BaseConfig.csrfTokenName : '';
      const tokenVal = tokenName ? (document.querySelector(`meta[name="${tokenName}"]`)?.getAttribute('content') || '') : '';

      jQuery.ajax({
         url: "<?= base_url('/admin/approval/get-requests'); ?>",
         type: 'post',
         data: {
            status: currentStatus,
            [tokenName]: tokenVal
         },
         success: function(resp) {
            const dataEl = document.getElementById('dataContainer');
            if (dataEl) {
               dataEl.innerHTML = resp;
               bindCheckboxes();
            }
            if ($btn.length) {
               $btn.removeClass('is-loading').prop('disabled', false);
            }
         },
         error: function(_, __, thrown) {
            const dataEl = document.getElementById('dataContainer');
            if (dataEl) {
               dataEl.innerHTML = `<div class="p-3">Gagal memuat data: <b>${thrown}</b></div>`;
            }
            if ($btn.length) {
               $btn.removeClass('is-loading').prop('disabled', false);
            }
         }
      });
   }

   /* ===== Checkbox handling ===== */
   function bindCheckboxes() {
      document.querySelectorAll('tbody input[type="checkbox"]').forEach(cb => {
         cb.addEventListener('change', (e) => {
            if (e.target.checked) {
               selectedItems.add(e.target.value);
            } else {
               selectedItems.delete(e.target.value);
            }
            updateBulkActions();
         });
      });
   }

   function updateBulkActions() {
      const bulkActions = document.getElementById('bulkActions');
      const selectedCount = document.getElementById('selectedCount');

      if (selectedItems.size > 0) {
         bulkActions.classList.add('show');
         selectedCount.textContent = `${selectedItems.size} item dipilih`;
      } else {
         bulkActions.classList.remove('show');
      }
   }

   /* ===== Bulk actions ===== */
   function bulkApprove() {
      if (selectedItems.size === 0) return;

      const tokenName = (window.BaseConfig && BaseConfig.csrfTokenName) ? BaseConfig.csrfTokenName : '';
      const tokenVal = tokenName ? (document.querySelector(`meta[name="${tokenName}"]`)?.getAttribute('content') || '') : '';

      jQuery.ajax({
         url: "<?= base_url('/admin/approval/bulk-approve'); ?>",
         type: 'post',
         data: {
            ids: Array.from(selectedItems),
            [tokenName]: tokenVal
         },
         success: function(resp) {
            if (resp.success) {
               alert(resp.message);
               selectedItems.clear();
               updateBulkActions();
               getApprovalRequests();
            } else {
               alert(resp.message);
            }
         }
      });
   }

   function bulkReject() {
      if (selectedItems.size === 0) return;

      const reason = prompt('Masukkan alasan penolakan:');
      if (!reason) return;

      const tokenName = (window.BaseConfig && BaseConfig.csrfTokenName) ? BaseConfig.csrfTokenName : '';
      const tokenVal = tokenName ? (document.querySelector(`meta[name="${tokenName}"]`)?.getAttribute('content') || '') : '';

      jQuery.ajax({
         url: "<?= base_url('/admin/approval/bulk-reject'); ?>",
         type: 'post',
         data: {
            ids: Array.from(selectedItems),
            reason: reason,
            [tokenName]: tokenVal
         },
         success: function(resp) {
            if (resp.success) {
               alert(resp.message);
               selectedItems.clear();
               updateBulkActions();
               getApprovalRequests();
            } else {
               alert(resp.message);
            }
         }
      });
   }

   /* ===== Individual actions ===== */
   function approveRequest(id) {
      if (confirm('Apakah Anda yakin ingin approve request ini?')) {
         const tokenName = (window.BaseConfig && BaseConfig.csrfTokenName) ? BaseConfig.csrfTokenName : '';
         const tokenVal = tokenName ? (document.querySelector(`meta[name="${tokenName}"]`)?.getAttribute('content') || '') : '';

         jQuery.ajax({
            url: `<?= base_url('/admin/approval/approve'); ?>/${id}`,
            type: 'post',
            data: {
               [tokenName]: tokenVal
            },
            success: function(resp) {
               if (resp.success) {
                  alert(resp.message);
                  getApprovalRequests();
               } else {
                  alert(resp.message);
               }
            }
         });
      }
   }

   function rejectRequest(id) {
      const reason = prompt('Masukkan alasan penolakan:');
      if (!reason) return;

      const tokenName = (window.BaseConfig && BaseConfig.csrfTokenName) ? BaseConfig.csrfTokenName : '';
      const tokenVal = tokenName ? (document.querySelector(`meta[name="${tokenName}"]`)?.getAttribute('content') || '') : '';

      jQuery.ajax({
         url: `<?= base_url('/admin/approval/reject'); ?>/${id}`,
         type: 'post',
         data: {
            reason: reason,
            [tokenName]: tokenVal
         },
         success: function(resp) {
            if (resp.success) {
               alert(resp.message);
               getApprovalRequests();
            } else {
               alert(resp.message);
            }
         }
      });
   }
</script>

<?= $this->endSection() ?>