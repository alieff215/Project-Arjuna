<?php

namespace App\Controllers\Admin;

use App\Models\AdminModel;

use App\Controllers\BaseController;
use App\Models\KehadiranModel;
use App\Models\PresensiAdminModel;
use App\Models\PresensiAdminHistoryModel;
use CodeIgniter\I18n\Time;

class DataAbsenAdmin extends BaseController
{
   protected AdminModel $adminModel;

   protected PresensiAdminModel $presensiAdmin;

   protected KehadiranModel $kehadiranModel;

   protected PresensiAdminHistoryModel $presensiHistory;

   public function __construct()
   {
      $this->adminModel = new AdminModel();

      $this->presensiAdmin = new PresensiAdminModel();

      $this->kehadiranModel = new KehadiranModel();

      $this->presensiHistory = new PresensiAdminHistoryModel();
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

   public function ambilHistoryTanggal()
   {
      $tanggal = $this->request->getVar('tanggal') ?? date('Y-m-d');
      try {
         $histories = $this->presensiHistory->getByTanggal((string)$tanggal);
      } catch (\Throwable $th) {
         $histories = [];
      }

      return view('admin/absen/history-absen-admin', ['histories' => $histories, 'tanggal' => $tanggal]);
   }

   public function ambilKehadiran()
   {
      $idPresensi = $this->request->getVar('id_presensi');
      $idAdmin = $this->request->getVar('id_admin');
      $reqTanggal = $this->request->getVar('tanggal');

      $presensi = $this->presensiAdmin->getPresensiById($idPresensi);
      $histories = [];
      $tanggalForHistory = $reqTanggal ?: ($presensi['tanggal'] ?? date('Y-m-d'));
      try {
         $histories = $this->presensiHistory->getByAdminTanggal((int)$idAdmin, (string)$tanggalForHistory);
      } catch (\Throwable $th) {
         $histories = [];
      }

      $data = [
         'presensi' => $presensi,
         'listKehadiran' => $this->kehadiranModel->getAllKehadiran(),
         'data' => $this->adminModel->getAdminById($idAdmin),
         'histories' => $histories
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
      $beforeRow = $this->presensiAdmin->getPresensiByIdAdminTanggal($idAdmin, $tanggal);

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
         // catat history perubahan (best-effort)
         try {
            $afterRow = $this->presensiAdmin->getPresensiByIdAdminTanggal($idAdmin, $tanggal);
            $this->presensiHistory->insert([
               'id_presensi' => $afterRow['id_presensi'] ?? $cek,
               'id_admin' => (int)$idAdmin,
               'tanggal' => $tanggal,
               'id_kehadiran_before' => $beforeRow['id_kehadiran'] ?? null,
               'id_kehadiran_after' => $afterRow['id_kehadiran'] ?? $idKehadiran,
               'keterangan_before' => $beforeRow['keterangan'] ?? null,
               'keterangan_after' => $afterRow['keterangan'] ?? $keterangan,
               'created_at' => date('Y-m-d H:i:s'),
            ]);
         } catch (\Throwable $th) {
            // jangan blokir respon
         }
         $response['status'] = TRUE;
      } else {
         $response['status'] = FALSE;
      }

      return $this->response->setJSON($response);
   }
}
