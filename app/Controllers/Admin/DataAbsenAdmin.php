<?php

namespace App\Controllers\Admin;

use App\Models\AdminModel;

use App\Controllers\BaseController;
use App\Models\KehadiranModel;
use App\Models\PresensiAdminModel;
use CodeIgniter\I18n\Time;

class DataAbsenAdmin extends BaseController
{
   protected AdminModel $adminModel;

   protected PresensiAdminModel $presensiAdmin;

   protected KehadiranModel $kehadiranModel;

   public function __construct()
   {
      $this->adminModel = new AdminModel();

      $this->presensiAdmin = new PresensiAdminModel();

      $this->kehadiranModel = new KehadiranModel();
   }

   public function index()
   {
      $data = [
         'title' => 'Data Absen Admin',
         'ctx' => 'absen-Admin',
      ];

      return view('admin/absen/absen-Admin', $data);
   }

   public function ambilDataAdmin()
   {
      // ambil variabel POST
      $tanggal = $this->request->getVar('tanggal');

      $lewat = Time::parse($tanggal)->isAfter(Time::today());

      $result = $this->presensiAdmin->getPresensiByTanggal($tanggal);

      $data = [
         'data' => $result,
         'listKehadiran' => $this->kehadiranModel->getAllKehadiran(),
         'lewat' => $lewat
      ];

      return view('admin/absen/list-absen-admin', $data);
   }

   public function ambilKehadiran()
   {
      $idPresensi = $this->request->getVar('id_presensi');
      $idAdmin = $this->request->getVar('id_admin');

      $data = [
         'presensi' => $this->presensiAdmin->getPresensiById($idPresensi),
         'listKehadiran' => $this->kehadiranModel->getAllKehadiran(),
         'data' => $this->adminModel->getAdminById($idAdmin)
      ];

      return view('admin/absen/ubah-kehadiran-modal', $data);
   }

   public function ubahKehadiran()
   {
      // ambil variabel POST
      $idKehadiran = $this->request->getVar('id_kehadiran');
      $idAdmin = $this->request->getVar('id_admin');
      $tanggal = $this->request->getVar('tanggal');
      $jamMasuk = $this->request->getVar('jam_masuk');
      $jamKeluar = $this->request->getVar('jam_keluar');
      $keterangan = $this->request->getVar('keterangan');

      $cek = $this->presensiAdmin->cekAbsen($idAdmin, $tanggal);

      $result = $this->presensiAdmin->updatePresensi(
         $cek == false ? NULL : $cek,
         $idAdmin,
         $tanggal,
         $idKehadiran,
         $jamMasuk ?? NULL,
         $jamKeluar ?? NULL,
         $keterangan
      );

      $response['nama_admin'] = $this->adminModel->getAdminById($idAdmin)['nama_admin'];

      if ($result) {
         $response['status'] = TRUE;
      } else {
         $response['status'] = FALSE;
      }

      return $this->response->setJSON($response);
   }
}
