<div class="card-body table-responsive">
   <style>
      /* Cream header and rows, consistent with karyawan table */
      .table-cream thead th {
         background: #ffe3b8 !important;
         /* krem header */
         color: #2e7d32 !important;
         text-align: center;
         border-bottom: 0 !important;
      }

      .table-cream thead {
         background: #ffe3b8 !important;
      }

      .table-cream tbody td {
         background-color: #fffaf0;
         /* krem tipis isi data */
         vertical-align: middle;
      }

      /* Remove borders so tampil soft */
      .table-cream thead th,
      .table-cream tbody td {
         border: 0 !important;
      }

      /* Hover subtle */
      .table-cream tbody tr:hover td {
         background: #fff3d6;
      }

      .table-cream td:last-child {
         text-align: center;
      }
   </style>
   <?php if (!$empty) : ?>
      <!-- Total Admin Info -->
      <div class="mb-3" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: linear-gradient(135deg, #e8f5e8 0%, #f0f8f0 100%); border-radius: 8px; border-left: 4px solid #4caf50;">
         <div style="display: flex; align-items: center; gap: 8px;">
            <i class="material-icons" style="color: #4caf50; font-size: 24px;">admin_panel_settings</i>
            <span style="font-weight: 700; color: #2e7d32; font-size: 16px;">Total Admin: <span style="background: #4caf50; color: white; padding: 4px 8px; border-radius: 12px; font-size: 14px;"><?= $total_admin; ?></span></span>
         </div>
         <div style="color: #666; font-size: 14px;">
            <i class="material-icons" style="font-size: 18px; vertical-align: middle;">schedule</i>
            <?= date('d M Y H:i'); ?>
         </div>
      </div>

      <table class="table table-hover table-cream">
         <thead class="text-success">
            <th><b>No</b></th>
            <th><b>NIP</b></th>
            <th><b>Nama Admin</b></th>
            <th><b>Jenis Kelamin</b></th>
            <th><b>No HP</b></th>
            <th><b>Alamat</b></th>
            <th><b>Status Approval</b></th>
            <th width="1%"><b>Aksi</b></th>
         </thead>
         <tbody>
            <?php $i = 1;
            foreach ($data as $value) : ?>
               <tr>
                  <td><?= $i; ?></td>
                  <td><?= $value['nuptk']; ?></td>
                  <td><b><?= $value['nama_admin']; ?></b></td>
                  <td><?= $value['jenis_kelamin']; ?></td>
                  <td><?= $value['no_hp']; ?></td>
                  <td><?= $value['alamat']; ?></td>
                  <td>
                     <?php
                     // Cek status approval untuk record ini
                     $approvalModel = new \App\Models\ApprovalModel();
                     $pendingRequests = $approvalModel->where('table_name', 'tb_admin')
                        ->where('record_id', $value['id_admin'])
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
                  <td>
                     <div class="d-flex justify-content-center">
                        <a title="Edit" href="<?= base_url('admin/admin/edit/' . $value['id_admin']); ?>" class="btn btn-success p-2" id="<?= $value['nuptk']; ?>">
                           <i class="material-icons">edit</i>
                        </a>
                        <form action="<?= base_url('admin/admin/delete/' . $value['id_admin']); ?>" method="post" class="d-inline">
                           <?= csrf_field(); ?>
                           <input type="hidden" name="_method" value="DELETE">
                           <button title="Delete" onclick="return confirm('Konfirmasi untuk menghapus data');" type="submit" class="btn btn-danger p-2" id="<?= $value['nuptk']; ?>">
                              <i class="material-icons">delete_forever</i>
                           </button>
                        </form>
                        <a title="Download QR Code" href="<?= base_url('admin/qr/admin/' . $value['id_admin'] . '/download'); ?>" class="btn btn-info p-2">
                           <i class="material-icons">qr_code</i>
                        </a>
                     </div>
                  </td>
               </tr>
            <?php $i++;
            endforeach; ?>
         </tbody>
      </table>
   <?php else : ?>
      <div class="row">
         <div class="col">
            <h4 class="text-center text-danger">Data tidak ditemukan</h4>
         </div>
      </div>
   <?php endif; ?>
</div>