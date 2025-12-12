<div class="modal-body">
   <div class="container-fluid">
      <form id="formUbah">

         <input type="hidden" name="id_karyawan" value="<?= $data['id_karyawan'] ?? ''; ?>">
         <input type="hidden" name="id_admin" value="<?= $data['id_admin'] ?? ''; ?>">
         <input type="hidden" name="id_departemen" value="<?= $data['id_departemen'] ?? ''; ?>">

         <label for="kehadiran">Kehadiran</label>
         <div class="form-check" id="kehadiran">
            <?php foreach ($listKehadiran as $value2) : ?>
               <?php $kehadiran = kehadiran($value2['id_kehadiran']); ?>
               <div class="row">
                  <div class="col-auto pr-1 pt-1">
                     <input class="form-check" type="radio" name="id_kehadiran" id="k<?= $kehadiran['text']; ?>" value="<?= $value2['id_kehadiran']; ?>" <?= $value2['id_kehadiran'] == ($presensi['id_kehadiran'] ?? '4') ? 'checked' : ''; ?>>
                  </div>
                  <div class="col">
                     <label class="form-check-label pl-0" for="k<?= $kehadiran['text']; ?>">
                        <h6 class="text-<?= $kehadiran['color']; ?>"><?= $kehadiran['text']; ?></h6>
                     </label>
                  </div>
               </div>
            <?php endforeach; ?>
         </div>
         
         <!-- Input Jam Masuk dan Jam Keluar -->
         <div class="row mt-3">
            <div class="col-md-6">
               <label for="jam_masuk">Jam Masuk</label>
               <input type="time" id="jam_masuk" name="jam_masuk" class="form-control" value="<?= $presensi['jam_masuk'] ?? ''; ?>">
            </div>
            <div class="col-md-6">
               <label for="jam_keluar">Jam Keluar</label>
               <input type="time" id="jam_keluar" name="jam_keluar" class="form-control" value="<?= $presensi['jam_keluar'] ?? ''; ?>">
            </div>
         </div>
         
         <div class="mt-3">
            <label for="keterangan">Keterangan</label>
            <textarea id="keterangan" name="keterangan" class="custom-select"><?= trim($presensi['keterangan'] ?? ''); ?></textarea>
         </div>
         
         <hr>
         <div>
            <button type="button" class="btn btn-info" style="margin-bottom:10px;cursor:default">History Update</button>
            <?php if (!empty($histories)) : ?>
               <div class="card" style="border:1px solid #e5e7eb;border-radius:8px;">
                  <div class="card-body" style="max-height:220px;overflow:auto;padding:12px;">
                     <?php foreach ($histories as $h) : ?>
                        <?php $kb = kehadiran(intval($h['id_kehadiran_before'] ?? 0)); $ka = kehadiran(intval($h['id_kehadiran_after'] ?? 0)); ?>
                        <div class="mb-3" style="border-bottom:1px dashed #e5e7eb;padding-bottom:8px;">
                           <div class="mb-1" style="font-size:12px;color:#64748b;">
                              <?= date('d M Y H:i:s', strtotime($h['created_at'] ?? 'now')) ?>
                           </div>
                           <div class="row" style="font-size:14px;">
                              <div class="col-4 col-sm-3 text-muted">Kehadiran</div>
                              <div class="col-8 col-sm-9">
                                 <span class="text-danger"><?= esc($kb['text'] ?? '-') ?></span>
                                 <span class="text-muted"> → </span>
                                 <span class="text-success"><?= esc($ka['text'] ?? '-') ?></span>
                              </div>
                           </div>
                           <?php if (!empty($h['jam_masuk_before']) || !empty($h['jam_masuk_after'])) : ?>
                           <div class="row" style="font-size:14px;">
                              <div class="col-4 col-sm-3 text-muted">Jam Masuk</div>
                              <div class="col-8 col-sm-9">
                                 <span class="text-danger"><?= esc($h['jam_masuk_before'] ?? '-') ?></span>
                                 <span class="text-muted"> → </span>
                                 <span class="text-success"><?= esc($h['jam_masuk_after'] ?? '-') ?></span>
                              </div>
                           </div>
                           <?php endif; ?>
                           <?php if (!empty($h['jam_keluar_before']) || !empty($h['jam_keluar_after'])) : ?>
                           <div class="row" style="font-size:14px;">
                              <div class="col-4 col-sm-3 text-muted">Jam Keluar</div>
                              <div class="col-8 col-sm-9">
                                 <span class="text-danger"><?= esc($h['jam_keluar_before'] ?? '-') ?></span>
                                 <span class="text-muted"> → </span>
                                 <span class="text-success"><?= esc($h['jam_keluar_after'] ?? '-') ?></span>
                              </div>
                           </div>
                           <?php endif; ?>
                           <div class="row" style="font-size:14px;">
                              <div class="col-4 col-sm-3 text-muted">Keterangan</div>
                              <div class="col-8 col-sm-9">
                                 <span class="text-danger"><?= esc($h['keterangan_before'] ?? '') ?></span>
                                 <span class="text-muted"> → </span>
                                 <span class="text-success"><?= esc($h['keterangan_after'] ?? '') ?></span>
                              </div>
                           </div>
                        </div>
                     <?php endforeach; ?>
                  </div>
               </div>
            <?php else : ?>
               <div class="alert alert-secondary" role="alert" style="margin:0">
                  Belum ada history perubahan untuk tanggal ini.
               </div>
            <?php endif; ?>
         </div>
      </form>
   </div>
</div>
<div class="modal-footer">
   <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
   <button type="button" onclick="ubahKehadiran()" class="btn btn-primary" data-dismiss="modal">Ubah</button>
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