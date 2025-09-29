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
      $karyawan = $this->karyawanModel->getKaryawanByDivisi($idDepartemen);
      $type = $this->request->getVar('type');

      if (empty($Karyawan)) {
         session()->setFlashdata([
            'msg' => 'Data karyawan kosong!',
            'error' => true
         ]);
         return redirect()->to('/admin/laporan');
      }

      $departemen = $this->departemenModel->where(['id_departemen' => $idDepartemen])
         ->join('tb_jabatan', 'tb_departemen.id_jabatan = tb_jabatan.id', 'left')
         ->first();

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
         // kecualikan hari sabtu dan minggu
         if (!($value->format('D') == 'Sat' || $value->format('D') == 'Sun')) {
            $lewat = Time::parse($value->format('Y-m-d'))->isAfter(Time::today());

            $absenByTanggal = $this->presensiKaryawanModel
               ->getPresensiByDepartemenTanggal($idDepartemen, $value->format('Y-m-d'));

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
         'grup' => "departemen " . $departemen['departemen'] . " " . $departemen['jabatan'],
      ];

      if ($type == 'doc') {
         $this->response->setHeader('Content-type', 'application/vnd.ms-word');
         $this->response->setHeader(
            'Content-Disposition',
            'attachment;Filename=laporan_absen_' . $departemen['departemen'] . " " . $departemen['jabatan'] . '_' . $begin->toLocalizedString('MMMM-Y') . '.doc'
         );

         return view('admin/generate-laporan/laporan-karyawan', $data);
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
         // kecualikan hari sabtu dan minggu
         if (!($value->format('D') == 'Sat' || $value->format('D') == 'Sun')) {
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

      if ($type == 'doc') {
         $this->response->setHeader('Content-type', 'application/vnd.ms-word');
         $this->response->setHeader(
            'Content-Disposition',
            'attachment;Filename=laporan_absen_admin_' . $begin->toLocalizedString('MMMM-Y') . '.doc'
         );

         return view('admin/generate-laporan/laporan-admin', $data);
      }

      return view('admin/generate-laporan/laporan-admin', $data) . view('admin/generate-laporan/topdf');
   }
}
