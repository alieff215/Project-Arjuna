<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
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

   .detail-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
      margin-bottom: 24px;
   }

   @media (max-width: 768px) {
      .detail-grid {
         grid-template-columns: 1fr;
      }
   }

   .detail-section {
      background: var(--card-solid);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 20px;
   }

   .detail-section h5 {
      margin: 0 0 16px 0;
      font-weight: 700;
      color: var(--text);
      display: flex;
      align-items: center;
      gap: 8px;
   }

   .detail-section h5 i {
      color: var(--primary);
   }

   .data-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      border-bottom: 1px solid color-mix(in oklab, var(--border) 30%, transparent);
   }

   .data-row:last-child {
      border-bottom: none;
   }

   .data-label {
      font-weight: 600;
      color: var(--muted);
      text-transform: uppercase;
      font-size: 12px;
      letter-spacing: 0.5px;
   }

   .data-value {
      font-weight: 600;
      color: var(--text);
   }

   .status-badge {
      padding: 6px 16px;
      border-radius: 20px;
      font-size: 14px;
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

   .json-data {
      background: var(--bg);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 16px;
      font-family: 'Courier New', monospace;
      font-size: 13px;
      line-height: 1.5;
      max-height: 300px;
      overflow-y: auto;
   }

   .action-buttons {
      display: flex;
      gap: 12px;
      margin-top: 24px;
   }

   .btn {
      padding: 12px 24px;
      border-radius: 12px;
      font-weight: 700;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.15s ease;
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

   .btn-secondary {
      background: var(--muted);
      color: #fff;
      border: 1px solid var(--muted);
   }

   .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
   }

   .diff-section {
      margin-top: 24px;
   }

   .diff-item {
      background: var(--card-solid);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 12px;
   }

   .diff-label {
      font-weight: 700;
      color: var(--text);
      margin-bottom: 8px;
   }

   .diff-old {
      background: color-mix(in oklab, var(--danger) 10%, var(--card-solid));
      border-left: 4px solid var(--danger);
      padding: 8px 12px;
      margin-bottom: 8px;
      border-radius: 4px;
   }

   .diff-new {
      background: color-mix(in oklab, var(--success) 10%, var(--card-solid));
      border-left: 4px solid var(--success);
      padding: 8px 12px;
      border-radius: 4px;
   }

   .diff-old::before {
      content: "Before: ";
      font-weight: 700;
      color: var(--danger);
   }

   .diff-new::before {
      content: "After: ";
      font-weight: 700;
      color: var(--success);
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
                        <h4 class="title">
                           <i class="material-icons">approval</i> 
                           Detail Approval Request #<?= $request['id'] ?>
                        </h4>
                        <div class="subtitle">
                           Request <?= ucfirst($request['request_type']) ?> untuk tabel <?= $request['table_name'] ?>
                        </div>
                     </div>
                     <div>
                        <span class="status-badge <?= $request['status'] ?>">
                           <?= ucfirst($request['status']) ?>
                        </span>
                     </div>
                  </div>
               </div>

               <div class="card-body">
                  <div class="detail-grid">
                     <!-- Request Info -->
                     <div class="detail-section">
                        <h5><i class="material-icons">info</i> Informasi Request</h5>
                        
                        <div class="data-row">
                           <span class="data-label">ID Request</span>
                           <span class="data-value">#<?= $request['id'] ?></span>
                        </div>
                        
                        <div class="data-row">
                           <span class="data-label">Type</span>
                           <span class="data-value">
                              <span class="badge badge-<?= $request['request_type'] === 'create' ? 'success' : ($request['request_type'] === 'update' ? 'warning' : 'danger') ?>">
                                 <?= ucfirst($request['request_type']) ?>
                              </span>
                           </span>
                        </div>
                        
                        <div class="data-row">
                           <span class="data-label">Table</span>
                           <span class="data-value"><code><?= $request['table_name'] ?></code></span>
                        </div>
                        
                        <?php if (!empty($request['record_id'])): ?>
                        <div class="data-row">
                           <span class="data-label">Record ID</span>
                           <span class="data-value"><?= $request['record_id'] ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="data-row">
                           <span class="data-label">Status</span>
                           <span class="data-value">
                              <span class="status-badge <?= $request['status'] ?>">
                                 <?= ucfirst($request['status']) ?>
                              </span>
                           </span>
                        </div>
                        
                        <div class="data-row">
                           <span class="data-label">Created</span>
                           <span class="data-value"><?= date('d M Y H:i', strtotime($request['created_at'])) ?></span>
                        </div>
                        
                        <?php if (!empty($request['approved_at'])): ?>
                        <div class="data-row">
                           <span class="data-label">Processed</span>
                           <span class="data-value"><?= date('d M Y H:i', strtotime($request['approved_at'])) ?></span>
                        </div>
                        <?php endif; ?>
                     </div>

                     <!-- User Info -->
                     <div class="detail-section">
                        <h5><i class="material-icons">person</i> Informasi User</h5>
                        
                        <div class="data-row">
                           <span class="data-label">Requested By</span>
                           <span class="data-value"><?= $request['requested_by_username'] ?? 'Unknown' ?></span>
                        </div>
                        
                        <?php if (!empty($request['approved_by_username'])): ?>
                        <div class="data-row">
                           <span class="data-label">Approved By</span>
                           <span class="data-value"><?= $request['approved_by_username'] ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($request['approval_notes'])): ?>
                        <div class="data-row">
                           <span class="data-label">Approval Notes</span>
                           <span class="data-value"><?= $request['approval_notes'] ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($request['rejection_reason'])): ?>
                        <div class="data-row">
                           <span class="data-label">Rejection Reason</span>
                           <span class="data-value" style="color: var(--danger);"><?= $request['rejection_reason'] ?></span>
                        </div>
                        <?php endif; ?>
                     </div>
                  </div>

                  <!-- Request Data -->
                  <div class="detail-section">
                     <h5><i class="material-icons">data_object</i> Data Request</h5>
                     <div class="json-data">
                        <?= json_encode($request_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?>
                     </div>
                  </div>

                  <!-- Original Data (for update/delete) -->
                  <?php if ($original_data): ?>
                  <div class="detail-section">
                     <h5><i class="material-icons">history</i> Data Asli</h5>
                     <div class="json-data">
                        <?= json_encode($original_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?>
                     </div>
                  </div>

                  <!-- Diff Section -->
                  <?php if ($request['request_type'] === 'update'): ?>
                  <div class="diff-section">
                     <h5><i class="material-icons">compare</i> Perubahan Data</h5>
                     <?php foreach ($request_data as $key => $newValue): ?>
                        <?php if (isset($original_data[$key]) && $original_data[$key] != $newValue): ?>
                        <div class="diff-item">
                           <div class="diff-label"><?= ucfirst(str_replace('_', ' ', $key)) ?></div>
                           <div class="diff-old"><?= htmlspecialchars($original_data[$key]) ?></div>
                           <div class="diff-new"><?= htmlspecialchars($newValue) ?></div>
                        </div>
                        <?php endif; ?>
                     <?php endforeach; ?>
                  </div>
                  <?php endif; ?>
                  <?php endif; ?>

                  <!-- Action Buttons -->
                  <?php if ($request['status'] === 'pending'): ?>
                  <div class="action-buttons">
                     <button onclick="approveRequest(<?= $request['id'] ?>)" class="btn btn-success">
                        <i class="material-icons">check</i> Approve
                     </button>
                     <button onclick="rejectRequest(<?= $request['id'] ?>)" class="btn btn-danger">
                        <i class="material-icons">close</i> Reject
                     </button>
                     <a href="<?= base_url('/admin/approval') ?>" class="btn btn-secondary">
                        <i class="material-icons">arrow_back</i> Kembali
                     </a>
                  </div>
                  <?php else: ?>
                  <div class="action-buttons">
                     <a href="<?= base_url('/admin/approval') ?>" class="btn btn-secondary">
                        <i class="material-icons">arrow_back</i> Kembali
                     </a>
                  </div>
                  <?php endif; ?>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>

<script>
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
                  location.reload();
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
               location.reload();
            } else {
               alert(resp.message);
            }
         }
      });
   }
</script>

<?= $this->endSection() ?>
