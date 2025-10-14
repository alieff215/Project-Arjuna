<?php

namespace App\Controllers\Admin;

use App\Models\DepartemenModel;

use App\Models\KaryawanModel;

use App\Controllers\BaseController;
use App\Models\KehadiranModel;
use App\Models\PresensiKaryawanModel;
use CodeIgniter\I18n\Time;

class DataAbsenKaryawan extends BaseController
{
   protected DepartemenModel $departemenModel;

   protected KaryawanModel $karyawanModel;

   protected KehadiranModel $kehadiranModel;

   protected PresensiKaryawanModel $presensiKaryawan;

   protected string $currentDate;

   public function __construct()
   {
      $this->currentDate = Time::today()->toDateString();

      $this->karyawanModel = new KaryawanModel();

      $this->kehadiranModel = new KehadiranModel();

      $this->departemenModel = new DepartemenModel();

      $this->presensiKaryawan = new PresensiKaryawanModel();
   }

   public function index()
   {
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
      $data['departemen'] = $departemenModel->getAllDepartemen();
      $data['title'] = 'Data Absen Karyawan';
      $data['tanggal'] = $tanggal;

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
         'lewat' => $lewat
      ];

      return view('admin/absen/list-absen-karyawan', $data);
   }

   public function ambilKehadiran()
   {
      $idPresensi = $this->request->getVar('id_presensi');
      $idKaryawan = $this->request->getVar('id_karyawan');

      $data = [
         'presensi' => $this->presensiKaryawan->getPresensiById($idPresensi),
         'listKehadiran' => $this->kehadiranModel->getAllKehadiran(),
         'data' => $this->karyawanModel->getKaryawanById($idKaryawan)
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
      $jamMasuk = $this->request->getVar('jam_masuk');
      $jamKeluar = $this->request->getVar('jam_keluar');
      $keterangan = $this->request->getVar('keterangan');

      $cek = $this->presensiKaryawan->cekAbsen($idKaryawan, $tanggal);

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
         $response['status'] = TRUE;
      } else {
         $response['status'] = FALSE;
      }

      return $this->response->setJSON($response);
   }
}
