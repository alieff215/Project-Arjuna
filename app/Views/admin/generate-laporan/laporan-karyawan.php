<?= $this->extend('templates/laporan') ?>

<?= $this->section('content') ?>
<table>
   <tr>
      <td><img src="<?= getLogo(); ?>" width="100px" height="100px"></img></td>
      <td width="100%">
         <h2 align="center">DAFTAR HADIR KARYAWAN</h2>
         <h4 align="center"><?= $generalSettings->company_name; ?></h4>
         <h4 align="center">TAHUN PELAJARAN <?= $generalSettings->company_year; ?></h4>
      </td>
      <td>
         <div style="width:100px"></div>
      </td>
   </tr>
</table>
<span>Bulan : <?= $bulan; ?></span>
<span style="position: absolute;right: 0;">
   <?php if (isset($isAllDepartments) && $isAllDepartments): ?>
      Departemen : Semua Departemen
   <?php else: ?>
      Departemen : <?= "{$departemen['departemen']} {$departemen['jabatan']}"; ?>
   <?php endif; ?>
</span>

<?php if (isset($isAllDepartments) && $isAllDepartments): ?>
   <!-- Tampilan untuk semua departemen - dikelompokkan per departemen -->
   <?php
   // Kelompokkan karyawan berdasarkan departemen
   $karyawanByDepartemen = [];
   foreach ($listKaryawan as $karyawan) {
      $deptKey = $karyawan['departemen'] . ' - ' . $karyawan['jabatan'];
      if (!isset($karyawanByDepartemen[$deptKey])) {
         $karyawanByDepartemen[$deptKey] = [];
      }
      $karyawanByDepartemen[$deptKey][] = $karyawan;
   }
   ?>

   <?php foreach ($karyawanByDepartemen as $deptName => $karyawanList): ?>
      <h3 style="margin-top: 30px; margin-bottom: 10px; color: #333;"><?= $deptName; ?></h3>
      
      <table align="center" border="1" style="margin-bottom: 20px;">
         <tr>
            <td></td>
            <td></td>
            <th colspan="<?= count($tanggal); ?>">Hari/Tanggal</th>
         </tr>
         <tr>
            <td></td>
            <td></td>
            <?php foreach ($tanggal as $value) : ?>
               <td align="center"><b><?= $value->toLocalizedString('E'); ?></b></td>
            <?php endforeach; ?>
            <td colspan="4" align="center">Total</td>
         </tr>
         <tr>
            <th align="center">No</th>
            <th width="1000px">Nama</th>
            <?php foreach ($tanggal as $value) : ?>
               <th align="center"><?= $value->format('d'); ?></th>
            <?php endforeach; ?>
            <th align="center" style="background-color:lightgreen;">H</th>
            <th align="center" style="background-color:yellow;">S</th>
            <th align="center" style="background-color:yellow;">I</th>
            <th align="center" style="background-color:red;">A</th>
         </tr>

         <?php $localNo = 1; ?>
         <?php foreach ($karyawanList as $karyawan): ?>
            <?php
            // Cari index karyawan dalam listKaryawan keseluruhan
            $karyawanIndex = array_search($karyawan['id_karyawan'], array_column($listKaryawan, 'id_karyawan'));
            
            $jumlahHadir = count(array_filter($listAbsen, function ($a) use ($karyawanIndex) {
               if ($a['lewat'] || is_null($a[$karyawanIndex]['id_kehadiran'])) return false;
               return $a[$karyawanIndex]['id_kehadiran'] == 1;
            }));
            $jumlahSakit = count(array_filter($listAbsen, function ($a) use ($karyawanIndex) {
               if ($a['lewat'] || is_null($a[$karyawanIndex]['id_kehadiran'])) return false;
               return $a[$karyawanIndex]['id_kehadiran'] == 2;
            }));
            $jumlahIzin = count(array_filter($listAbsen, function ($a) use ($karyawanIndex) {
               if ($a['lewat'] || is_null($a[$karyawanIndex]['id_kehadiran'])) return false;
               return $a[$karyawanIndex]['id_kehadiran'] == 3;
            }));
            $jumlahTidakHadir = count(array_filter($listAbsen, function ($a) use ($karyawanIndex) {
               if ($a['lewat']) return false;
               if (is_null($a[$karyawanIndex]['id_kehadiran']) || $a[$karyawanIndex]['id_kehadiran'] == 4) return true;
               return false;
            }));
            ?>
            <tr>
               <td align="center"><?= $localNo; ?></td>
               <td><?= $karyawan['nama_karyawan']; ?></td>
               <?php foreach ($listAbsen as $absen) : ?>
                  <?= kehadiran($absen[$karyawanIndex]['id_kehadiran'] ?? ($absen['lewat'] ? 5 : 4)); ?>
               <?php endforeach; ?>
               <td align="center">
                  <?= $jumlahHadir != 0 ? $jumlahHadir : '-'; ?>
               </td>
               <td align="center">
                  <?= $jumlahSakit != 0 ? $jumlahSakit : '-'; ?>
               </td>
               <td align="center">
                  <?= $jumlahIzin != 0 ? $jumlahIzin : '-'; ?>
               </td>
               <td align="center">
                  <?= $jumlahTidakHadir != 0 ? $jumlahTidakHadir : '-'; ?>
               </td>
            </tr>
            <?php $localNo++; ?>
         <?php endforeach; ?>
      </table>
   <?php endforeach; ?>

<?php else: ?>
   <!-- Tampilan untuk departemen spesifik (tampilan asli) -->
   <table align="center" border="1">
      <tr>
         <td></td>
         <td></td>
         <th colspan="<?= count($tanggal); ?>">Hari/Tanggal</th>
      </tr>
      <tr>
         <td></td>
         <td></td>
         <?php foreach ($tanggal as $value) : ?>
            <td align="center"><b><?= $value->toLocalizedString('E'); ?></b></td>
         <?php endforeach; ?>
         <td colspan="4" align="center">Total</td>
      </tr>
      <tr>
         <th align="center">No</th>
         <th width="1000px">Nama</th>
         <?php foreach ($tanggal as $value) : ?>
            <th align="center"><?= $value->format('d'); ?></th>
         <?php endforeach; ?>
         <th align="center" style="background-color:lightgreen;">H</th>
         <th align="center" style="background-color:yellow;">S</th>
         <th align="center" style="background-color:yellow;">I</th>
         <th align="center" style="background-color:red;">A</th>
      </tr>

      <?php $i = 0; ?>

      <?php foreach ($listKaryawan as $karyawan) : ?>
         <?php
         $jumlahHadir = count(array_filter($listAbsen, function ($a) use ($i) {
            if ($a['lewat'] || is_null($a[$i]['id_kehadiran'])) return false;
            return $a[$i]['id_kehadiran'] == 1;
         }));
         $jumlahSakit = count(array_filter($listAbsen, function ($a) use ($i) {
            if ($a['lewat'] || is_null($a[$i]['id_kehadiran'])) return false;
            return $a[$i]['id_kehadiran'] == 2;
         }));
         $jumlahIzin = count(array_filter($listAbsen, function ($a) use ($i) {
            if ($a['lewat'] || is_null($a[$i]['id_kehadiran'])) return false;
            return $a[$i]['id_kehadiran'] == 3;
         }));
         $jumlahTidakHadir = count(array_filter($listAbsen, function ($a) use ($i) {
            if ($a['lewat']) return false;
            if (is_null($a[$i]['id_kehadiran']) || $a[$i]['id_kehadiran'] == 4) return true;
            return false;
         }));
         ?>
         <tr>
            <td align="center"><?= $i + 1; ?></td>
            <td><?= $karyawan['nama_karyawan']; ?></td>
            <?php foreach ($listAbsen as $absen) : ?>
               <?= kehadiran($absen[$i]['id_kehadiran'] ?? ($absen['lewat'] ? 5 : 4)); ?>
            <?php endforeach; ?>
            <td align="center">
               <?= $jumlahHadir != 0 ? $jumlahHadir : '-'; ?>
            </td>
            <td align="center">
               <?= $jumlahSakit != 0 ? $jumlahSakit : '-'; ?>
            </td>
            <td align="center">
               <?= $jumlahIzin != 0 ? $jumlahIzin : '-'; ?>
            </td>
            <td align="center">
               <?= $jumlahTidakHadir != 0 ? $jumlahTidakHadir : '-'; ?>
            </td>
         </tr>
      <?php
         $i++;
      endforeach; ?>

   </table>
<?php endif; ?>

<br></br>
<table>
   <tr>
      <td>Jumlah karyawan</td>
      <td>: <?= count($listKaryawan); ?></td>
   </tr>
   <tr>
      <td>Laki-laki</td>
      <td>: <?= $jumlahKaryawan['laki']; ?></td>
   </tr>
   <tr>
      <td>Perempuan</td>
      <td>: <?= $jumlahKaryawan['perempuan']; ?></td>
   </tr>
</table>
<?php
function kehadiran($kehadiran)
{
   $text = '';
   switch ($kehadiran) {
      case 1:
         $text = "<td align='center' style='background-color:lightgreen;'>H</td>";
         break;
      case 2:
         $text = "<td align='center' style='background-color:yellow;'>S</td>";
         break;
      case 3:
         $text = "<td align='center' style='background-color:yellow;'>I</td>";
         break;
      case 4:
         $text = "<td align='center' style='background-color:red;'>A</td>";
         break;
      case 5:
      default:
         $text = "<td></td>";
         break;
   }

   return $text;
}
?>
<?= $this->endSection() ?>