<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use DateTime;
use DateInterval;
use DatePeriod;

use App\Models\AdminModel;
use App\Models\DepartemenModel;
use App\Models\PresensiAdminModel;
use App\Models\KaryawanModel;
use App\Models\PresensiKaryawanModel;

class GenerateLaporan extends BaseController
{
   protected KaryawanModel $karyawanModel;
   protected DepartemenModel $departemenModel;

   protected AdminModel $adminModel;

   protected PresensiKaryawanModel $presensiKaryawanModel;
   protected PresensiAdminModel $presensiAdminModel;

   public function __construct()
   {
      $this->karyawanModel = new KaryawanModel();
      $this->departemenModel = new DepartemenModel();

      $this->adminModel = new AdminModel();

      $this->presensiKaryawanModel = new PresensiKaryawanModel();
      $this->presensiAdminModel = new PresensiAdminModel();
   }

   public function index()
   {
      $departemen = $this->departemenModel->getDataDepartemen();
      $admin = $this->adminModel->getAllAdmin();

      $karyawanPerDepartemen = [];

      foreach ($departemen as $value) {
         array_push($karyawanPerDepartemen, $this->karyawanModel->getKaryawanByDepartemen($value['id_departemen']));
      }

      $data = [
         'title' => 'Generate Laporan',
         'ctx' => 'laporan',
         'karyawanPerDepartemen' => $karyawanPerDepartemen,
         'departemen' => $departemen,
         'admin' => $admin
      ];

      return view('admin/generate-laporan/generate-laporan', $data);
   }

   public function generateLaporanKaryawan()
   {
      $idDepartemen = $this->request->getVar('departemen');
      // Jika departemen tidak dipilih, ambil semua karyawan di semua departemen
      if (empty($idDepartemen)) {
         $karyawan = $this->karyawanModel->getAllKaryawanWithDepartemen();
         // Urutkan agar pengelompokan per departemen di view rapi
         usort($karyawan, function ($a, $b) {
            $deptA = ($a['departemen'] ?? '') . ' ' . ($a['jabatan'] ?? '');
            $deptB = ($b['departemen'] ?? '') . ' ' . ($b['jabatan'] ?? '');
            if ($deptA === $deptB) {
               return strcmp($a['nama_karyawan'] ?? '', $b['nama_karyawan'] ?? '');
            }
            return strcmp($deptA, $deptB);
         });
      } else {
         $karyawan = $this->karyawanModel->getKaryawanByDepartemen($idDepartemen);
      }
      $type = $this->request->getVar('type');

      if (empty($karyawan)) {
         session()->setFlashdata([
            'msg' => 'Data karyawan kosong!',
            'error' => true
         ]);
         return redirect()->to('/admin/laporan');
      }

      // Informasi departemen untuk header laporan
      if (empty($idDepartemen)) {
         $departemen = [
            'departemen' => 'Semua Departemen',
            'jabatan' => ''
         ];
      } else {
         $departemen = $this->departemenModel->where(['id_departemen' => $idDepartemen])
            ->join('tb_jabatan', 'tb_departemen.id_jabatan = tb_jabatan.id', 'left')
            ->first();
      }

      $bulan = $this->request->getVar('tanggalKaryawan');

      // hari pertama dalam 1 bulan
      $begin = new Time($bulan, locale: 'id');
      // tanggal terakhir dalam 1 bulan
      $end = (new DateTime($begin->format('Y-m-t')))->modify('+1 day');
      // interval 1 hari
      $interval = DateInterval::createFromDateString('1 day');
      // buat array dari semua hari di bulan
      $period = new DatePeriod($begin, $interval, $end);

      $arrayTanggal = [];
      $dataAbsen = [];

      foreach ($period as $value) {
         // kecualikan hari minggu
         if ($value->format('D') != 'Sun') {
            $lewat = Time::parse($value->format('Y-m-d'))->isAfter(Time::today());

            // Jika semua departemen dipilih, ambil presensi semua departemen pada tanggal tsb
            if (empty($idDepartemen)) {
               $absenByTanggal = $this->presensiKaryawanModel
                  ->getPresensiAllDepartemenTanggal($value->format('Y-m-d'));
            } else {
               $absenByTanggal = $this->presensiKaryawanModel
                  ->getPresensiByDepartemenTanggal($idDepartemen, $value->format('Y-m-d'));
            }

            $absenByTanggal['lewat'] = $lewat;

            array_push($dataAbsen, $absenByTanggal);
            array_push($arrayTanggal, Time::createFromInstance($value, locale: 'id'));
         }
      }

      $laki = 0;

      foreach ($karyawan as $value) {
         if ($value['jenis_kelamin'] != 'Perempuan') {
            $laki++;
         }
      }

      $data = [
         'tanggal' => $arrayTanggal,
         'bulan' => $begin->toLocalizedString('MMMM'),
         'listAbsen' => $dataAbsen,
         'listKaryawan' => $karyawan,
         'jumlahKaryawan' => [
            'laki' => $laki,
            'perempuan' => count($karyawan) - $laki
         ],
         'departemen' => $departemen,
         'grup' => empty($idDepartemen) ? 'semua departemen' : ("departemen " . $departemen['departemen'] . " " . $departemen['jabatan']),
      ];

      if ($type == 'csv') {
         return $this->generateCsvKaryawan($data, $departemen, $begin);
      }

      return view('admin/generate-laporan/laporan-karyawan', $data) . view('admin/generate-laporan/topdf');
   }

   public function generateLaporanAdmin()
   {
      $admin = $this->adminModel->getAllAdmin();
      $type = $this->request->getVar('type');

      if (empty($admin)) {
         session()->setFlashdata([
            'msg' => 'Data admin kosong!',
            'error' => true
         ]);
         return redirect()->to('/admin/laporan');
      }

      $bulan = $this->request->getVar('tanggalAdmin');

      // hari pertama dalam 1 bulan
      $begin = new Time($bulan, locale: 'id');
      // tanggal terakhir dalam 1 bulan
      $end = (new DateTime($begin->format('Y-m-t')))->modify('+1 day');
      // interval 1 hari
      $interval = DateInterval::createFromDateString('1 day');
      // buat array dari semua hari di bulan
      $period = new DatePeriod($begin, $interval, $end);

      $arrayTanggal = [];
      $dataAbsen = [];

      foreach ($period as $value) {
         // kecualikan hari minggu
         if ($value->format('D') != 'Sun') {
            $lewat = Time::parse($value->format('Y-m-d'))->isAfter(Time::today());

            $absenByTanggal = $this->presensiAdminModel
               ->getPresensiByTanggal($value->format('Y-m-d'));

            $absenByTanggal['lewat'] = $lewat;

            array_push($dataAbsen, $absenByTanggal);
            array_push($arrayTanggal, Time::createFromInstance($value, locale: 'id'));
         }
      }

      $laki = 0;

      foreach ($admin as $value) {
         if ($value['jenis_kelamin'] != 'Perempuan') {
            $laki++;
         }
      }

      $data = [
         'tanggal' => $arrayTanggal,
         'bulan' => $begin->toLocalizedString('MMMM'),
         'listAbsen' => $dataAbsen,
         'listAdmin' => $admin,
         'jumlahAdmin' => [
            'laki' => $laki,
            'perempuan' => count($admin) - $laki
         ],
         'grup' => 'admin',
      ];

      if ($type == 'csv') {
         return $this->generateCsvAdmin($data, $begin);
      }

      return view('admin/generate-laporan/laporan-admin', $data) . view('admin/generate-laporan/topdf');
   }

   private function generateCsvKaryawan($data, $departemen, $begin)
   {
      $filename = 'laporan_absen_' . str_replace(' ', '_', $departemen['departemen'] . '_' . $departemen['jabatan']) . '_' . $begin->toLocalizedString('MMMM-Y') . '.csv';
      
      $this->response->setHeader('Content-Type', 'text/csv; charset=UTF-8');
      $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
      $this->response->setHeader('Pragma', 'no-cache');
      $this->response->setHeader('Expires', '0');

      // BOM untuk UTF-8 agar Excel bisa membaca dengan benar
      echo "\xEF\xBB\xBF";

      $output = fopen('php://output', 'w');

      // Header utama global
      fputcsv($output, ['DAFTAR HADIR KARYAWAN'], ';');
      fputcsv($output, ['Bulan: ' . $data['bulan']], ';');
      fputcsv($output, []); // Baris kosong

      $isAllDepartemen = isset($departemen['departemen']) && $departemen['departemen'] === 'Semua Departemen';

      // Jika semua departemen, kelompokkan berdasarkan departemen
      if ($isAllDepartemen) {
         // Kelompokkan karyawan berdasarkan departemen
         $karyawanByDepartemen = [];
         foreach ($data['listKaryawan'] as $index => $karyawan) {
            $deptKey = ($karyawan['departemen'] ?? '') . ' ' . ($karyawan['jabatan'] ?? '');
            if (!isset($karyawanByDepartemen[$deptKey])) {
               $karyawanByDepartemen[$deptKey] = [];
            }
            $karyawanByDepartemen[$deptKey][] = [
               'karyawan' => $karyawan,
               'index' => $index
            ];
         }

         // Buat tabel untuk setiap departemen
         $tableNumber = 1;
         foreach ($karyawanByDepartemen as $deptKey => $karyawanList) {
            $this->writeCsvTableKaryawan($output, $data, $deptKey, $karyawanList, $tableNumber);
            $tableNumber++;
         }

         // Footer global untuk semua departemen
         fputcsv($output, []); // Baris kosong
         fputcsv($output, ['=== RINGKASAN SEMUA DEPARTEMEN ==='], ';');
         fputcsv($output, ['Jumlah karyawan', count($data['listKaryawan'])], ';');
         fputcsv($output, ['Laki-laki', $data['jumlahKaryawan']['laki']], ';');
         fputcsv($output, ['Perempuan', $data['jumlahKaryawan']['perempuan']], ';');
      } else {
         // Satu departemen saja, buat satu tabel
         $karyawanList = [];
         foreach ($data['listKaryawan'] as $index => $karyawan) {
            $karyawanList[] = [
               'karyawan' => $karyawan,
               'index' => $index
            ];
         }
         $deptKey = $departemen['departemen'] . ' ' . $departemen['jabatan'];
         $this->writeCsvTableKaryawan($output, $data, $deptKey, $karyawanList, 1);

         // Footer untuk satu departemen
         fputcsv($output, []); // Baris kosong
         fputcsv($output, ['Jumlah karyawan', count($data['listKaryawan'])], ';');
         fputcsv($output, ['Laki-laki', $data['jumlahKaryawan']['laki']], ';');
         fputcsv($output, ['Perempuan', $data['jumlahKaryawan']['perempuan']], ';');
      }

      fclose($output);
      return;
   }

   private function writeCsvTableKaryawan($output, $data, $deptKey, $karyawanList, $tableNumber)
   {
      // Baris pemisah antar tabel (kecuali tabel pertama)
      if ($tableNumber > 1) {
         fputcsv($output, []); // Baris kosong
         fputcsv($output, []); // Baris kosong
      }

      // Header departemen
      fputcsv($output, ['=== TABEL ' . $tableNumber . ': ' . trim($deptKey) . ' ==='], ';');
      fputcsv($output, []); // Baris kosong

      // Header tabel
      $header = ['No', 'Nama'];
      foreach ($data['tanggal'] as $tanggal) {
         $header[] = $tanggal->toLocalizedString('E') . ' ' . $tanggal->format('d');
      }
      $header[] = 'Total H';
      $header[] = 'Total S';
      $header[] = 'Total I';
      $header[] = 'Total A';
      fputcsv($output, $header, ';');

      // Data karyawan dalam departemen ini
      $rowNumber = 1;
      foreach ($karyawanList as $item) {
         $karyawan = $item['karyawan'];
         $i = $item['index'];

         // Hitung total
         $jumlahHadir = count(array_filter($data['listAbsen'], function ($a) use ($i) {
            if ($a['lewat'] || is_null($a[$i]['id_kehadiran'])) return false;
            return $a[$i]['id_kehadiran'] == 1;
         }));
         $jumlahSakit = count(array_filter($data['listAbsen'], function ($a) use ($i) {
            if ($a['lewat'] || is_null($a[$i]['id_kehadiran'])) return false;
            return $a[$i]['id_kehadiran'] == 2;
         }));
         $jumlahIzin = count(array_filter($data['listAbsen'], function ($a) use ($i) {
            if ($a['lewat'] || is_null($a[$i]['id_kehadiran'])) return false;
            return $a[$i]['id_kehadiran'] == 3;
         }));
         $jumlahTidakHadir = count(array_filter($data['listAbsen'], function ($a) use ($i) {
            if ($a['lewat']) return false;
            if (is_null($a[$i]['id_kehadiran']) || $a[$i]['id_kehadiran'] == 4) return true;
            return false;
         }));

         // Baris data
         $row = [$rowNumber, $karyawan['nama_karyawan']];
         
         foreach ($data['listAbsen'] as $absen) {
            $jm = $absen[$i]['jam_masuk'] ?? null;
            $jk = $absen[$i]['jam_keluar'] ?? null;
            $idKehadiran = $absen[$i]['id_kehadiran'] ?? ($absen['lewat'] ? 5 : 4);
            
            $cellValue = '';
            if ($idKehadiran == 5 || $absen['lewat']) {
               $cellValue = '';
            } else {
               switch ($idKehadiran) {
                  case 1: // Hadir
                     $hoursText = '-';
                     if (!empty($jm) && !empty($jk)) {
                        $durasiDetik = strtotime($jk) - strtotime($jm);
                        if ($durasiDetik > 0) {
                           $hoursText = number_format($durasiDetik / 3600, 1) . 'h';
                        }
                     }
                     $cellValue = 'H' . ($hoursText != '-' ? ' (' . $hoursText . ')' : '');
                     break;
                  case 2: // Sakit
                     $cellValue = 'S';
                     break;
                  case 3: // Izin
                     $cellValue = 'I';
                     break;
                  case 4: // Alpha
                     $cellValue = 'A';
                     break;
                  default:
                     $cellValue = '';
                     break;
               }
            }
            $row[] = $cellValue;
         }
         
         $row[] = $jumlahHadir != 0 ? $jumlahHadir : '';
         $row[] = $jumlahSakit != 0 ? $jumlahSakit : '';
         $row[] = $jumlahIzin != 0 ? $jumlahIzin : '';
         $row[] = $jumlahTidakHadir != 0 ? $jumlahTidakHadir : '';
         
         fputcsv($output, $row, ';');
         $rowNumber++;
      }

      // Footer per departemen
      $lakiDept = 0;
      $perempuanDept = 0;
      foreach ($karyawanList as $item) {
         if ($item['karyawan']['jenis_kelamin'] != 'Perempuan') {
            $lakiDept++;
         } else {
            $perempuanDept++;
         }
      }

      fputcsv($output, []); // Baris kosong
      fputcsv($output, ['--- Ringkasan Departemen ---'], ';');
      fputcsv($output, ['Jumlah karyawan', count($karyawanList)], ';');
      fputcsv($output, ['Laki-laki', $lakiDept], ';');
      fputcsv($output, ['Perempuan', $perempuanDept], ';');
   }

   private function generateCsvAdmin($data, $begin)
   {
      $filename = 'laporan_absen_admin_' . $begin->toLocalizedString('MMMM-Y') . '.csv';
      
      $this->response->setHeader('Content-Type', 'text/csv; charset=UTF-8');
      $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
      $this->response->setHeader('Pragma', 'no-cache');
      $this->response->setHeader('Expires', '0');

      // BOM untuk UTF-8 agar Excel bisa membaca dengan benar
      echo "\xEF\xBB\xBF";

      $output = fopen('php://output', 'w');

      // Header utama
      fputcsv($output, ['DAFTAR HADIR ADMIN'], ';');
      fputcsv($output, ['Bulan: ' . $data['bulan']], ';');
      fputcsv($output, []); // Baris kosong

      // Header tabel
      $header = ['No', 'Nama'];
      foreach ($data['tanggal'] as $tanggal) {
         $header[] = $tanggal->toLocalizedString('E') . ' ' . $tanggal->format('d');
      }
      $header[] = 'Total H';
      $header[] = 'Total S';
      $header[] = 'Total I';
      $header[] = 'Total A';
      fputcsv($output, $header, ';');

      // Data admin
      $i = 0;
      foreach ($data['listAdmin'] as $admin) {
         // Hitung total
         $jumlahHadir = count(array_filter($data['listAbsen'], function ($a) use ($i) {
            if ($a['lewat'] || is_null($a[$i]['id_kehadiran'])) return false;
            return $a[$i]['id_kehadiran'] == 1;
         }));
         $jumlahSakit = count(array_filter($data['listAbsen'], function ($a) use ($i) {
            if ($a['lewat'] || is_null($a[$i]['id_kehadiran'])) return false;
            return $a[$i]['id_kehadiran'] == 2;
         }));
         $jumlahIzin = count(array_filter($data['listAbsen'], function ($a) use ($i) {
            if ($a['lewat'] || is_null($a[$i]['id_kehadiran'])) return false;
            return $a[$i]['id_kehadiran'] == 3;
         }));
         $jumlahTidakHadir = count(array_filter($data['listAbsen'], function ($a) use ($i) {
            if ($a['lewat']) return false;
            if (is_null($a[$i]['id_kehadiran']) || $a[$i]['id_kehadiran'] == 4) return true;
            return false;
         }));

         // Baris data
         $row = [$i + 1, $admin['nama_admin']];
         
         foreach ($data['listAbsen'] as $absen) {
            $idKehadiran = $absen[$i]['id_kehadiran'] ?? ($absen['lewat'] ? 5 : 4);
            
            $cellValue = '';
            if ($idKehadiran == 5 || $absen['lewat']) {
               $cellValue = '';
            } else {
               switch ($idKehadiran) {
                  case 1: // Hadir
                     $cellValue = 'H';
                     break;
                  case 2: // Sakit
                     $cellValue = 'S';
                     break;
                  case 3: // Izin
                     $cellValue = 'I';
                     break;
                  case 4: // Alpha
                     $cellValue = 'A';
                     break;
                  default:
                     $cellValue = '';
                     break;
               }
            }
            $row[] = $cellValue;
         }
         
         $row[] = $jumlahHadir != 0 ? $jumlahHadir : '';
         $row[] = $jumlahSakit != 0 ? $jumlahSakit : '';
         $row[] = $jumlahIzin != 0 ? $jumlahIzin : '';
         $row[] = $jumlahTidakHadir != 0 ? $jumlahTidakHadir : '';
         
         fputcsv($output, $row, ';');
         $i++;
      }

      // Footer
      fputcsv($output, []); // Baris kosong
      fputcsv($output, ['Jumlah admin', count($data['listAdmin'])], ';');
      fputcsv($output, ['Laki-laki', $data['jumlahAdmin']['laki']], ';');
      fputcsv($output, ['Perempuan', $data['jumlahAdmin']['perempuan']], ';');

      fclose($output);
      return;
   }
}
