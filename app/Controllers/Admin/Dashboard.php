<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\AdminModel;
use App\Models\KaryawanModel;
use App\Models\DepartemenModel;
use App\Models\PetugasModel;
use App\Models\PresensiAdminModel;
use App\Models\PresensiKaryawanModel;
use CodeIgniter\I18n\Time;
use Config\AbsensiSekolah as ConfigAbsensiSekolah;

class Dashboard extends BaseController
{
   protected KaryawanModel $karyawanModel;
   protected AdminModel $adminModel;

   protected DepartemenModel $DepartemenModel;

   protected PresensiKaryawanModel $presensiKaryawanModel;
   protected PresensiAdminModel $presensiAdminModel;

   protected PetugasModel $petugasModel;

   public function __construct()
   {
      $this->karyawanModel = new KaryawanModel();
      $this->adminModel = new AdminModel();
      $this->DepartemenModel = new DepartemenModel();
      $this->presensiKaryawanModel = new PresensiKaryawanModel();
      $this->presensiAdminModel = new PresensiAdminModel();
      $this->petugasModel = new PetugasModel();
   }

   public function index()
   {
      $now = Time::now();

      $dateRange = [];
      $karyawanKehadiranArray = [];
      $adminKehadiranArray = [];

      for ($i = 6; $i >= 0; $i--) {
         $date = $now->subDays($i)->toDateString();
         if ($i == 0) {
            $formattedDate = "Hari ini";
         } else {
            $t = $now->subDays($i);
            $formattedDate = "{$t->getDay()} " . substr($t->toFormattedDateString(), 0, 3);
         }
         array_push($dateRange, $formattedDate);
         array_push(
            $karyawanKehadiranArray,
            count($this->presensiKaryawanModel
               ->join('tb_karyawan', 'tb_presensi_karyawan.id_karyawan = tb_karyawan.id_karyawan', 'left')
               ->where(['tb_presensi_karyawan.tanggal' => "$date", 'tb_presensi_karyawan.id_kehadiran' => '1'])->findAll())
         );
         array_push(
            $adminKehadiranArray,
            count($this->presensiAdminModel
               ->join('tb_admin', 'tb_presensi_admin.id_admin = tb_admin.id_admin', 'left')
               ->where(['tb_presensi_admin.tanggal' => "$date", 'tb_presensi_admin.id_kehadiran' => '1'])->findAll())
         );
      }

      $today = $now->toDateString();

      $data = [
         'title' => 'Dashboard',
         'ctx' => 'dashboard',

         'karyawan' => $this->karyawanModel->getAllKaryawanWithDepartemen(),
         'admin' => $this->adminModel->getAllAdmin(),

         'departemen' => $this->DepartemenModel->getDataDepartemen(),

         'dateRange' => $dateRange,
         'dateNow' => $now->toLocalizedString('d MMMM Y'),

         'grafikKehadiranKaryawan' => $karyawanKehadiranArray,
         'grafikkKehadiranAdmin' => $adminKehadiranArray,

         'jumlahKehadiranKaryawan' => [
            'hadir' => count($this->presensiKaryawanModel->getPresensiByKehadiran('1', $today)),
            'sakit' => count($this->presensiKaryawanModel->getPresensiByKehadiran('2', $today)),
            'izin' => count($this->presensiKaryawanModel->getPresensiByKehadiran('3', $today)),
            'alfa' => count($this->presensiKaryawanModel->getPresensiByKehadiran('4', $today))
         ],

         'jumlahKehadiranAdmin' => [
            'hadir' => count($this->presensiAdminModel->getPresensiByKehadiran('1', $today)),
            'sakit' => count($this->presensiAdminModel->getPresensiByKehadiran('2', $today)),
            'izin' => count($this->presensiAdminModel->getPresensiByKehadiran('3', $today)),
            'alfa' => count($this->presensiAdminModel->getPresensiByKehadiran('4', $today))
         ],

         'petugas' => $this->petugasModel->getAllPetugas(),
      ];

      return view('admin/dashboard', $data);
   }
}
