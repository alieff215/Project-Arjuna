<?php if (empty($requests)): ?>
   <tr>
      <td colspan="8" style="padding: 40px; text-align: center; color: var(--muted);">
         <i class="material-icons" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;">inbox</i>
         <div style="font-size: 16px; font-weight: 600; margin-bottom: 8px;">Tidak ada request approval</div>
         <div style="font-size: 14px;">Belum ada request approval yang perlu ditangani</div>
      </td>
   </tr>
<?php else: ?>
   <?php foreach ($requests as $index => $request): ?>
      <tr>
         <td class="checkbox-wrapper">
            <input type="checkbox" value="<?= $request['id'] ?>" />
         </td>
         <td>
            <strong>#<?= $request['id'] ?></strong>
         </td>
         <td>
            <span class="badge badge-<?= $request['request_type'] === 'create' ? 'success' : ($request['request_type'] === 'update' ? 'warning' : 'danger') ?>">
               <?= ucfirst($request['request_type']) ?>
            </span>
         </td>
         <td>
            <code><?= $request['table_name'] ?></code>
            <?php if ($request['record_id']): ?>
               <br><small class="text-muted">ID: <?= $request['record_id'] ?></small>
            <?php endif; ?>
         </td>
         <td>
            <div>
               <strong><?= $request['requested_by_username'] ?? 'Unknown' ?></strong>
               <?php if ($request['approved_by_username']): ?>
                  <br><small class="text-muted">Approved by: <?= $request['approved_by_username'] ?></small>
               <?php endif; ?>
            </div>
         </td>
         <td>
            <span class="status-badge <?= $request['status'] ?>">
               <?= ucfirst($request['status']) ?>
            </span>
         </td>
         <td>
            <div>
               <strong><?= date('d M Y', strtotime($request['created_at'])) ?></strong>
               <br><small class="text-muted"><?= date('H:i', strtotime($request['created_at'])) ?></small>
            </div>
         </td>
         <td>
            <div class="action-buttons">
               <a href="<?= base_url('/admin/approval/detail/' . $request['id']) ?>" 
                  class="btn btn-info btn-sm" title="Detail">
                  <i class="material-icons" style="font-size: 16px;">visibility</i>
               </a>
               
               <?php if ($request['status'] === 'pending'): ?>
                  <button onclick="approveRequest(<?= $request['id'] ?>)" 
                          class="btn btn-success btn-sm" title="Approve">
                     <i class="material-icons" style="font-size: 16px;">check</i>
                  </button>
                  <button onclick="rejectRequest(<?= $request['id'] ?>)" 
                          class="btn btn-danger btn-sm" title="Reject">
                     <i class="material-icons" style="font-size: 16px;">close</i>
                  </button>
               <?php else: ?>
                  <span class="text-muted" style="font-size: 12px;">
                     <?php if ($request['status'] === 'approved'): ?>
                        <i class="material-icons" style="font-size: 16px; color: var(--success);">check_circle</i>
                     <?php else: ?>
                        <i class="material-icons" style="font-size: 16px; color: var(--danger);">cancel</i>
                     <?php endif; ?>
                  </span>
               <?php endif; ?>
            </div>
         </td>
      </tr>
   <?php endforeach; ?>
<?php endif; ?>

