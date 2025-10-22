<?php

namespace App\Controllers\Admin;

use App\Models\DepartemenModel;

use App\Models\KaryawanModel;

use App\Controllers\BaseController;
use App\Models\KehadiranModel;
use App\Models\PresensiKaryawanModel;
use App\Models\PresensiKaryawanHistoryModel;
use CodeIgniter\I18n\Time;

class DataAbsenKaryawan extends BaseController
{
   protected DepartemenModel $departemenModel;

   protected KaryawanModel $karyawanModel;

   protected KehadiranModel $kehadiranModel;

   protected PresensiKaryawanModel $presensiKaryawan;
   protected PresensiKaryawanHistoryModel $presensiHistory;

   protected string $currentDate;

   public function __construct()
   {
      $this->currentDate = Time::today()->toDateString();

      $this->karyawanModel = new KaryawanModel();

      $this->kehadiranModel = new KehadiranModel();

      $this->departemenModel = new DepartemenModel();

      $this->presensiKaryawan = new PresensiKaryawanModel();
      $this->presensiHistory = new PresensiKaryawanHistoryModel();
   }

   public function index()
   {
      // Cek akses masterdata
      if (!$this->roleHelper->canAccessMasterData()) {
         return redirect()->to('/scan');
      }

      $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');
      $departemen = $this->request->getGet('departemen');

      $presensiModel = new \App\Models\PresensiKaryawanModel();

      if ($departemen == 'all') {
         $data['listAbsen'] = $presensiModel->getAllAbsenByDate($tanggal);
         $data['departemen'] = 'Semua Departemen';
      } else {
         $data['listAbsen'] = $presensiModel->getPresensiByDepartemenTanggal($departemen, $tanggal);
         $data['departemen'] = ucfirst($departemen);
      }

      // ✅ Tambahkan ini:
      $departemenModel = new \App\Models\DepartemenModel();
      $data['listDepartemen'] = $departemenModel->getAllDepartemen();
      $data['title'] = 'Data Absen Karyawan';
      $data['tanggal'] = $tanggal;
      
      // Ambil total karyawan untuk ditampilkan di header
      $data['total_karyawan'] = $this->karyawanModel->countAllResults();

      return view('admin/absen/absen-karyawan', $data);
   }

   public function ambilDataKaryawan()
   {
      // Ambil variabel POST
      $departemen = $this->request->getVar('departemen');
      $idDepartemen = $this->request->getVar('id_departemen');
      $tanggal = $this->request->getVar('tanggal');

      $lewat = Time::parse($tanggal)->isAfter(Time::today());

      // 🔹 Tambahkan logika ini
      if ($idDepartemen === 'all') {
         // Ambil semua data presensi dari semua departemen
         $result = $this->presensiKaryawan->getPresensiAllDepartemenTanggal($tanggal);
      } else {
         // Ambil data presensi berdasarkan departemen tertentu
         $result = $this->presensiKaryawan->getPresensiByDepartemenTanggal($idDepartemen, $tanggal);
      }

      $data = [
         'departemen' => $departemen,
         'data' => $result,
         'listKehadiran' => $this->kehadiranModel->getAllKehadiran(),
         'lewat' => $lewat,
         'total_karyawan' => count($result)
      ];

      return view('admin/absen/list-absen-karyawan', $data);
   }

   public function ambilHistoryTanggal()
   {
      $tanggal = $this->request->getVar('tanggal') ?? date('Y-m-d');
      try {
         $histories = $this->presensiHistory->getByTanggal((string)$tanggal);
      } catch (\Throwable $th) {
         $histories = [];
      }

      return view('admin/absen/history-absen-karyawan', ['histories' => $histories, 'tanggal' => $tanggal]);
   }

   public function ambilKehadiran()
   {
      $idPresensi = $this->request->getVar('id_presensi');
      $idKaryawan = $this->request->getVar('id_karyawan');

      $histories = [];
      try {
         $histories = $this->presensiHistory->getByKaryawanTanggal((int)$idKaryawan, $this->request->getVar('tanggal') ?? $this->currentDate);
      } catch (\Throwable $th) {
         $histories = [];
      }

      $data = [
         'presensi' => $this->presensiKaryawan->getPresensiById($idPresensi),
         'listKehadiran' => $this->kehadiranModel->getAllKehadiran(),
         'data' => $this->karyawanModel->getKaryawanById($idKaryawan),
         'histories' => $histories
      ];

      return view('admin/absen/ubah-kehadiran-modal', $data);
   }

   public function ubahKehadiran()
   {
      // ambil variabel POST
      $idKehadiran = $this->request->getVar('id_kehadiran');
      $idKaryawan = $this->request->getVar('id_karyawan');
      $idDepartemen = $this->request->getVar('id_departemen');
      $tanggal = $this->request->getVar('tanggal');
      // ambil jam masuk dan jam keluar dari request UI
      $jamMasuk = $this->request->getVar('jam_masuk');
      $jamKeluar = $this->request->getVar('jam_keluar');
      $keterangan = $this->request->getVar('keterangan');

      // ambil data sebelum perubahan (row lengkap)
      $beforeRow = $this->presensiKaryawan->getPresensiByIdKaryawanTanggal($idKaryawan, $tanggal);
      // untuk kompatibilitas fungsi updatePresensi yang menerima idPresensi
      $cek = $beforeRow ? ($beforeRow['id_presensi'] ?? null) : $this->presensiKaryawan->cekAbsen($idKaryawan, $tanggal);

      $result = $this->presensiKaryawan->updatePresensi(
         $cek == false ? NULL : $cek,
         $idKaryawan,
         $idDepartemen,
         $tanggal,
         $idKehadiran,
         $jamMasuk ?? NULL,
         $jamKeluar ?? NULL,
         $keterangan
      );

      $response['nama_karyawan'] = $this->karyawanModel->getKaryawanById($idKaryawan)['nama_karyawan'];

      if ($result) {
         try {
            $afterRow = $this->presensiKaryawan->getPresensiByIdKaryawanTanggal($idKaryawan, $tanggal);
            $historyData = [
               'id_presensi' => $afterRow['id_presensi'] ?? $cek,
               'id_karyawan' => (int)$idKaryawan,
               'tanggal' => $tanggal,
               'id_kehadiran_before' => $beforeRow['id_kehadiran'] ?? null,
               'id_kehadiran_after' => $afterRow['id_kehadiran'] ?? $idKehadiran,
               'keterangan_before' => $beforeRow['keterangan'] ?? null,
               'keterangan_after' => $afterRow['keterangan'] ?? $keterangan,
               'jam_masuk_before' => $beforeRow['jam_masuk'] ?? null,
               'jam_masuk_after' => $afterRow['jam_masuk'] ?? $jamMasuk,
               'jam_keluar_before' => $beforeRow['jam_keluar'] ?? null,
               'jam_keluar_after' => $afterRow['jam_keluar'] ?? $jamKeluar,
            ];
            
            $historyResult = $this->presensiHistory->insert($historyData);
            if (!$historyResult) {
               log_message('error', 'Failed to insert history: ' . json_encode($this->presensiHistory->errors()));
            }
         } catch (\Throwable $th) {
            log_message('error', 'History insert error: ' . $th->getMessage());
         }
         $response['status'] = TRUE;
      } else {
         $response['status'] = FALSE;
      }

      return $this->response->setJSON($response);
   }
}
