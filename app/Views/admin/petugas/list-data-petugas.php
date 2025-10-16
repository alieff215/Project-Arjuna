<style>
   /* Simple styling yang bekerja di mode terang dan gelap */
   .simple-table {
      background: var(--card);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      border: 1px solid var(--border);
   }

   .simple-table table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
   }

   .simple-table thead {
      background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
      color: white;
      box-shadow: 0 2px 8px rgba(30, 64, 175, 0.3);
   }

   .simple-table thead th {
      padding: 16px 20px;
      font-weight: 600;
      font-size: 0.9rem;
      text-align: left;
      border: none;
   }

   .simple-table tbody tr {
      border-bottom: 1px solid var(--border);
      transition: all 0.3s ease;
   }

   .simple-table tbody tr:hover {
      background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
   }

   .simple-table tbody tr:last-child {
      border-bottom: none;
   }

   .simple-table tbody td {
      padding: 16px 20px;
      font-size: 0.9rem;
      color: var(--text);
      vertical-align: middle;
   }

   .role-badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
      text-transform: uppercase;
   }

   .role-superadmin {
      background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
      color: #dc2626;
      border: 1px solid #fecaca;
      box-shadow: 0 2px 4px rgba(220, 38, 38, 0.1);
   }

   .role-petugas {
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
      color: #16a34a;
      border: 1px solid #bbf7d0;
      box-shadow: 0 2px 4px rgba(22, 163, 74, 0.1);
   }

   .action-buttons {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
   }

   .btn-custom {
      border-radius: 8px;
      padding: 8px 16px;
      font-size: 0.8rem;
      font-weight: 600;
      border: none;
      transition: all 0.3s ease;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      text-decoration: none;
      min-width: 80px;
      justify-content: center;
   }

   .btn-edit {
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
      color: white;
      box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
   }

   .btn-edit:hover {
      background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
      color: white;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
      transform: translateY(-1px);
   }

   .btn-delete {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
      color: white;
      box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
   }

   .btn-delete:hover {
      background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
      color: white;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
      transform: translateY(-1px);
   }

   .btn-disabled {
      background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
      color: white;
      opacity: 0.6;
      cursor: not-allowed;
      box-shadow: none;
   }

   .no-data {
      text-align: center;
      padding: 60px 20px;
      color: var(--muted);
   }

   .no-data h4 {
      margin: 0 0 8px 0;
      font-size: 1.2rem;
      color: #ef4444;
   }

   .no-data p {
      margin: 0;
      font-size: 0.9rem;
   }

   /* Responsive */
   @media (max-width: 1024px) {
      .simple-table {
         overflow-x: auto;
      }

      .simple-table table {
         min-width: 600px;
      }
   }

   @media (max-width: 768px) {

      .simple-table thead th,
      .simple-table tbody td {
         padding: 12px 16px;
         font-size: 0.85rem;
      }

      .simple-table table {
         min-width: 500px;
      }

      .action-buttons {
         flex-direction: column;
         gap: 6px;
      }

      .btn-custom {
         width: 100%;
         padding: 10px 16px;
         font-size: 0.75rem;
      }

      .role-badge {
         font-size: 0.7rem;
         padding: 3px 8px;
      }
   }

   @media (max-width: 576px) {

      .simple-table thead th,
      .simple-table tbody td {
         padding: 10px 12px;
         font-size: 0.8rem;
      }

      .simple-table table {
         min-width: 400px;
      }

      .btn-custom {
         padding: 8px 12px;
         font-size: 0.7rem;
         min-width: 70px;
      }

      .role-badge {
         font-size: 0.65rem;
         padding: 2px 6px;
      }
   }

   @media (max-width: 480px) {

      .simple-table thead th,
      .simple-table tbody td {
         padding: 8px 10px;
         font-size: 0.75rem;
      }

      .simple-table table {
         min-width: 350px;
      }

      .btn-custom {
         padding: 6px 10px;
         font-size: 0.65rem;
         min-width: 60px;
      }

      .no-data {
         padding: 40px 16px;
      }

      .no-data h4 {
         font-size: 1rem;
      }

      .no-data p {
         font-size: 0.8rem;
      }
   }
</style>

<div class="simple-table">
   <?php if (!$empty) : ?>
      <table>
         <thead>
            <tr>
               <th>No</th>
               <th>Username</th>
               <th>Email</th>
               <th>Role</th>
               <th>Aksi</th>
            </tr>
         </thead>
         <tbody>
            <?php $i = 1;
            foreach ($data as $value) : ?>
               <tr>
                  <td><?= $i; ?></td>
                  <td><strong><?= $value['username']; ?></strong></td>
                  <td><?= $value['email']; ?></td>
                  <td>
                     <span class="role-badge <?= $value['is_superadmin'] == '1' ? 'role-superadmin' : 'role-petugas'; ?>">
                        <?= $value['is_superadmin'] == '1' ? 'Super Admin' : 'Petugas'; ?>
                     </span>
                  </td>
                  <td>
                     <div class="action-buttons">
                        <?php if ($value['username'] == 'superadmin') : ?>
                           <button disabled class="btn-custom btn-disabled">
                              <i class="material-icons">edit</i>
                              Edit
                           </button>
                           <button disabled class="btn-custom btn-disabled">
                              <i class="material-icons">delete_forever</i>
                              Delete
                           </button>
                        <?php else : ?>
                           <a href="<?= base_url('admin/petugas/edit/' . $value['id']); ?>" class="btn-custom btn-edit">
                              <i class="material-icons">edit</i>
                              Edit
                           </a>
                           <form action="<?= base_url('admin/petugas/delete/' . $value['id']); ?>" method="post" class="d-inline">
                              <?= csrf_field(); ?>
                              <input type="hidden" name="_method" value="DELETE">
                              <button onclick="return confirm('Konfirmasi untuk menghapus data');" type="submit" class="btn-custom btn-delete">
                                 <i class="material-icons">delete_forever</i>
                                 Delete
                              </button>
                           </form>
                        <?php endif; ?>
                     </div>
                  </td>
               </tr>
            <?php $i++;
            endforeach; ?>
         </tbody>
      </table>
   <?php else : ?>
      <div class="no-data">
         <h4>📋 Data Tidak Ditemukan</h4>
         <p>Belum ada data petugas yang tersedia</p>
      </div>
   <?php endif; ?>
</div>