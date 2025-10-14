<style>
   /* ====== Tabel responsif & rapi ====== */
   .table-wrap {
      position: relative;
   }

   .table-wrap .table {
      min-width: 820px;
      /* aman untuk kolom banyak; tetap bisa di-scroll */
      font-size: clamp(13px, 1.8vw, 14px);
   }

   .table thead th {
      white-space: nowrap;
      vertical-align: middle;
   }

   /* Header lengket saat di-scroll (opsional, boleh hapus 3 baris di bawah) */
   .table thead th.sticky-top {
      position: sticky;
      top: 0;
      z-index: 2;
      background: var(--card, #fff);
   }

   /* Kolom aksi: tombol seragam */
   .td-actions {
      white-space: nowrap;
   }

   .td-actions .btn {
      width: 40px;
      height: 40px;
      padding: 0 !important;
      border-radius: 10px;
      display: inline-grid;
      place-items: center;
      line-height: 1;
      margin-right: 8px;
   }

   .td-actions .btn:last-child {
      margin-right: 0;
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
         border: 1px solid var(--border, rgba(16, 24, 40, .12));
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
         border-top: 1px dashed rgba(0, 0, 0, .06);
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
         justify-content: flex-start;
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
</style>

<div class="card-body table-responsive table-wrap">
   <?php if (!$empty) : ?>
      <table class="table table-hover">
         <thead class="text-primary">
            <tr>
               <th class="sticky-top" width="20">
                  <input type="checkbox" class="checkbox-table" id="checkAll">
               </th>
               <th class="sticky-top"><b>No</b></th>
               <th class="sticky-top"><b>NIP</b></th>
               <th class="sticky-top"><b>Nama Karyawan</b></th>
               <th class="sticky-top"><b>Jenis Kelamin</b></th>
               <th class="sticky-top"><b>Departemen</b></th>
               <th class="sticky-top"><b>Jabatan</b></th>
               <th class="sticky-top"><b>No HP</b></th>
               <th class="sticky-top" width="1%"><b>Aksi</b></th>
            </tr>
         </thead>
         <tbody>
            <?php $i = 1;
            foreach ($data as $value) : ?>
               <tr>
                  <td data-label="">
                     <input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $value['id_karyawan']; ?>">
                  </td>
                  <td data-label="No"><?= $i; ?></td>
                  <td data-label="NIP"><?= $value['nis']; ?></td>
                  <td data-label="Nama Karyawan"><b><?= $value['nama_karyawan']; ?></b></td>
                  <td data-label="Jenis Kelamin"><?= $value['jenis_kelamin']; ?></td>
                  <td data-label="Departemen"><?= $value['departemen']; ?></td>
                  <td data-label="Jabatan"><?= $value['jabatan']; ?></td>
                  <td data-label="No HP"><?= $value['no_hp']; ?></td>
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
   <?php else : ?>
      <div class="row">
         <div class="col">
            <h4 class="text-center text-danger">Data tidak ditemukan</h4>
         </div>
      </div>
   <?php endif; ?>
</div>