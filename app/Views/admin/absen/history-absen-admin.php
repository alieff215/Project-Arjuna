<div>
   <button type="button" class="btn btn-info" style="margin-bottom:10px;cursor:default">HISTORY UPDATE</button>
   <?php if (!empty($histories)) : ?>
      <?php foreach ($histories as $h) : ?>
         <?php
         $kbId = intval($h['id_kehadiran_before'] ?? 0);
         $kaId = intval($h['id_kehadiran_after'] ?? 0);
         $kb = kehadiran($kbId);
         $ka = kehadiran($kaId);
         ?>
         <div class="card" style="border:1px solid #e5e7eb;border-radius:8px;margin-bottom:12px;">
            <div class="card-body">
               <div style="display:flex;justify-content:space-between;align-items:center;gap:8px;flex-wrap:wrap;">
                  <div>
                     <span class="badge badge-primary" style="margin-right:6px;"><?= esc($h['nama_admin'] ?? 'Admin') ?></span>
                     <span class="badge badge-secondary">Kehadiran</span>
                     <span class="badge badge-secondary">Keterangan</span>
                  </div>
                  <div class="badge-soft">
                     <?= date('d M Y H:i:s', strtotime($h['created_at'] ?? 'now')) ?>
                  </div>
               </div>
               <div class="table-responsive" style="margin-top:12px;">
                  <table class="table">
                     <thead>
                        <tr>
                           <th style="width:160px;">Field</th>
                           <th>Perubahan</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>Kehadiran</td>
                           <td>
                              <span class="text-danger"><b><?= esc($kb['text'] ?? '-') ?></b></span>
                              <span class="text-muted"> → </span>
                              <span class="text-success"><b><?= esc($ka['text'] ?? '-') ?></b></span>
                           </td>
                        </tr>
                        <tr>
                           <td>Keterangan</td>
                           <td>
                              <span class="text-danger"><?= esc($h['keterangan_before'] ?? '') ?></span>
                              <span class="text-muted"> → </span>
                              <span class="text-success"><?= esc($h['keterangan_after'] ?? '') ?></span>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      <?php endforeach; ?>
   <?php else : ?>
      <div class="placeholder">Belum ada history perubahan pada tanggal ini.</div>
   <?php endif; ?>
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
      default:
         $color = 'disabled';
         $text = 'Belum tersedia';
         break;
   }

   return ['color' => $color, 'text' => $text];
}
?>


