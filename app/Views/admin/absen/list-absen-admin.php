<div id="dataKaryawan" class="card-body table-responsive pb-5">
   <?php if (!empty($data)) : ?>
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
      
      <table class="table table-hover">
         <thead class="text-success">
            <th><b>No.</b></th>
            <th><b>NIP</b></th>
            <th><b>Nama admin</b></th>
            <th><b>Kehadiran</b></th>
            <th><b>Jam masuk</b></th>
            <th><b>Jam pulang</b></th>
            <th><b>Keterangan</b></th>
            <th><b>Aksi</b></th>
         </thead>
         <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data as $value) : ?>
               <?php
               $idKehadiran = intval($value['id_kehadiran'] ?? ($lewat ? 5 : 4));
               $kehadiran = kehadiran($idKehadiran);
               ?>
               <tr>
                  <td><?= $no; ?></td>
                  <td><?= $value['nuptk']; ?></td>
                  <td><b><?= $value['nama_admin']; ?></b></td>
                  <td>
                     <p class="p-2 w-100 btn btn-<?= $kehadiran['color']; ?> text-center">
                        <b><?= $kehadiran['text']; ?></b>
                     </p>
                  </td>
                  <td><b><?= $value['jam_masuk'] ?? '-'; ?></b></td>
                  <td><b><?= $value['jam_keluar'] ?? '-'; ?></b></td>
                  <td><?= $value['keterangan'] ?? '-'; ?></td>
                  <td>
                     <?php if (!$lewat) : ?>
                        <button data-toggle="modal" data-target="#ubahModal" onclick="getDataKehadiran(<?= $value['id_presensi'] ?? '-1'; ?>, <?= $value['id_admin']; ?>)" class="btn btn-info p-2" id="<?= $value['id_admin']; ?>">
                           <i class="material-icons">edit</i>
                           Edit
                        </button>
                     <?php else : ?>
                        <button class="btn btn-disabled p-2">No Action</button>
                     <?php endif; ?>
                  </td>
               </tr>
            <?php $no++;
            endforeach ?>
         </tbody>
      </table>
   <?php
   else :
   ?>
      <div class="row">
         <div class="col">
            <h4 class="text-center text-danger">Data tidak ditemukan</h4>
         </div>
      </div>
   <?php
   endif; ?>
</div>

<?php
function kehadiran($kehadiran): array
{
   $text = '';
   $color = '';
   switch ($kehadiran) {
      case 1:
         $color = 'success';
         $text = 'Hadir';
         break;
      case 2:
         $color = 'warning';
         $text = 'Sakit';
         break;
      case 3:
         $color = 'info';
         $text = 'Izin';
         break;
      case 4:
         $color = 'danger';
         $text = 'Tanpa keterangan';
         break;
      case 5:
      default:
         $color = 'disabled';
         $text = 'Belum tersedia';
         break;
   }

   return ['color' => $color, 'text' => $text];
}
?>