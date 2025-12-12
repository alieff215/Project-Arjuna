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
<span style="position: absolute;right: 0;">Departemen : <?= "{$departemen['departemen']} {$departemen['jabatan']}"; ?></span>
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
   <?php $isAllDepartemen = isset($departemen['departemen']) && $departemen['departemen'] === 'Semua Departemen'; ?>
   <?php $lastDepartemenKey = null; ?>

   <?php foreach ($listKaryawan as $karyawan) : ?>
      <?php
      // Cetak pemisah departemen saat berpindah departemen (khusus semua departemen)
      if ($isAllDepartemen) {
         $deptKey = ($karyawan['departemen'] ?? '') . ' ' . ($karyawan['jabatan'] ?? '');
         if ($deptKey !== $lastDepartemenKey) {
            $lastDepartemenKey = $deptKey;
            ?>
            <tr>
               <td colspan="<?= 2 + count($tanggal) + 4; ?>" style="background-color:#f0f0f0;font-weight:bold;">
                  Departemen: <?= trim($deptKey); ?>
               </td>
            </tr>
            <?php
         }
      }
      ?>
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
         <?php foreach ($listAbsen as $j => $absen) : ?>
            <?php
            $jm = $absen[$i]['jam_masuk'] ?? null;
            $jk = $absen[$i]['jam_keluar'] ?? null;
            $hoursText = '-';
            if (!empty($jm) && !empty($jk)) {
               $durasiDetik = strtotime($jk) - strtotime($jm);
               if ($durasiDetik > 0) {
                  $hoursText = number_format($durasiDetik / 3600, 1);
               }
            }
            ?>
            <?= kehadiran($absen[$i]['id_kehadiran'] ?? ($absen['lewat'] ? 5 : 4), $hoursText); ?>
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
function kehadiran($kehadiran, $content = '-')
{
   $style = '';
   switch ($kehadiran) {
      case 1: // Hadir
         $style = "background-color:lightgreen;";
         break;
      case 2: // Sakit
      case 3: // Izin
         $style = "background-color:yellow;";
         break;
      case 4: // Alpha
         $style = "background-color:red;";
         break;
      case 5: // Lewat (belum terjadi)
      default:
         $style = '';
         $content = '';
         break;
   }

   return "<td align='center' style='${style}'>${content}</td>";
}
?>
<?= $this->endSection() ?>