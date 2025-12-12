<?php

namespace App\Controllers\Admin;

use App\Models\DepartemenModel;

use App\Models\KaryawanModel;

use App\Controllers\BaseController;
use App\Models\KehadiranModel;
use App\Models\PresensiKaryawanModel;
use App\Models\PresensiKaryawanHistoryModel;
use App\Models\ApprovalModel;
use App\Libraries\ApprovalHelper;
use CodeIgniter\I18n\Time;

class DataAbsenKaryawan extends BaseController
{
   protected DepartemenModel $departemenModel;

   protected KaryawanModel $karyawanModel;

   protected KehadiranModel $kehadiranModel;

   protected PresensiKaryawanModel $presensiKaryawan;
   protected PresensiKaryawanHistoryModel $presensiHistory;
   protected ?ApprovalModel $approvalModel = null;
   protected ?ApprovalHelper $approvalHelper = null;

   protected string $currentDate;

   public function __construct()
   {
      $this->currentDate = Time::today()->toDateString();

      $this->karyawanModel = new KaryawanModel();

      $this->kehadiranModel = new KehadiranModel();

      $this->departemenModel = new DepartemenModel();

      $this->presensiKaryawan = new PresensiKaryawanModel();
      $this->presensiHistory = new PresensiKaryawanHistoryModel();
      // Inisialisasi approval helper & model secara aman (opsional)
      try { $this->approvalModel = new ApprovalModel(); } catch (\Throwable $th) { $this->approvalModel = null; }
      try { $this->approvalHelper = new ApprovalHelper(); } catch (\Throwable $th) { $this->approvalHelper = null; }
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

      // Data yang akan diupdate
      $updateData = [
         'id_karyawan' => $idKaryawan,
         'id_departemen' => $idDepartemen,
         'tanggal' => $tanggal,
         'id_kehadiran' => $idKehadiran,
         'keterangan' => $keterangan
      ];

      if ($jamMasuk != null) {
         $updateData['jam_masuk'] = $jamMasuk;
      }

      if ($jamKeluar != null) {
         $updateData['jam_keluar'] = $jamKeluar;
      }

      // Cek apakah memerlukan approval
      if ($this->approvalHelper->requiresApproval()) {
         // Buat request approval untuk update presensi
         $approvalId = $this->approvalHelper->createApprovalRequest(
            'update',
            'tb_presensi_karyawan',
            $cek,
            $updateData,
            $beforeRow
         );

         if ($approvalId) {
            $response['status'] = TRUE;
            $response['message'] = 'Request perubahan kehadiran telah dikirim dan menunggu persetujuan superadmin';
            $response['nama_karyawan'] = $this->karyawanModel->getKaryawanById($idKaryawan)['nama_karyawan'];
         } else {
            $response['status'] = FALSE;
            $response['message'] = 'Gagal mengirim request approval';
         }
      } else {
         // Langsung eksekusi untuk super admin
         $result = $this->presensiKaryawan->updatePresensi(
            $cek == false ? NULL : $cek,
            $idKaryawan,
            $idDepartemen,
            $tanggal,
            $idKehadiran,
            $jamMasuk ?? NULL,
            $jamKeluar ?? NULL,
            $keterangan,
            'approved',
            null,
            session()->get('user_id')
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
      }

      return $this->response->setJSON($response);
   }

   /**
    * Ubah kehadiran semua karyawan pada tanggal terpilih (opsional per departemen)
    * Parameter: id_departemen ('all' atau numeric), tanggal, id_kehadiran, jam_masuk?, jam_keluar?, keterangan?
    * Tetap pertahankan akses edit per karyawan (fitur ini hanya tambahan mass update)
    */
   public function ubahKehadiranSemua()
   {
      try {
         // Validasi akses masterdata
         if (!$this->roleHelper->canAccessMasterData()) {
            return $this->response->setJSON([
               'status' => false,
               'message' => 'Tidak memiliki akses',
            ]);
         }

         $idDepartemenParam = $this->request->getVar('id_departemen');
         $tanggal = $this->request->getVar('tanggal');
         $idKehadiran = $this->request->getVar('id_kehadiran');
         $jamMasuk = $this->request->getVar('jam_masuk');
         $jamKeluar = $this->request->getVar('jam_keluar');
         $keterangan = $this->request->getVar('keterangan');

         if (empty($tanggal)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Tanggal tidak boleh kosong']);
         }
         if ($idKehadiran === null || $idKehadiran === '') {
            return $this->response->setJSON(['status' => false, 'message' => 'Status kehadiran wajib dipilih']);
         }

         // Cegah update untuk tanggal di masa depan
         try {
            $isFuture = \CodeIgniter\I18n\Time::parse($tanggal)->isAfter(\CodeIgniter\I18n\Time::today());
            if ($isFuture) {
               return $this->response->setJSON([
                  'status' => false,
                  'message' => 'Tanggal belum berjalan. Tidak dapat melakukan update massal.',
               ]);
            }
         } catch (\Throwable $th) {
            // Jika parsing gagal tetap lanjut tanpa blokir
         }

         // Ambil daftar karyawan dan presensi sesuai filter
         if ($idDepartemenParam === 'all') {
            $list = $this->presensiKaryawan->getPresensiAllDepartemenTanggal($tanggal);
         } else {
            $list = $this->presensiKaryawan->getPresensiByDepartemenTanggal($idDepartemenParam, $tanggal);
         }

         $updated = 0;
         $requests = 0;
         foreach ($list as $row) {
            $idKaryawan = $row['id_karyawan'];
            $idDepartemen = $row['id_departemen'] ?? ($idDepartemenParam === 'all' ? null : $idDepartemenParam);

            // Ambil data sebelum perubahan (jika ada)
            $beforeRow = $this->presensiKaryawan->getPresensiByIdKaryawanTanggal($idKaryawan, $tanggal);
            $idPresensi = $beforeRow['id_presensi'] ?? null;

            $updateData = [
               'id_karyawan' => $idKaryawan,
               'id_departemen' => $idDepartemen,
               'tanggal' => $tanggal,
               'id_kehadiran' => $idKehadiran,
               'keterangan' => $keterangan
            ];
            if (!empty($jamMasuk)) $updateData['jam_masuk'] = $jamMasuk;
            if (!empty($jamKeluar)) $updateData['jam_keluar'] = $jamKeluar;

         // Coba jalankan mekanisme approval jika tersedia.
         $useApproval = false;
         try {
            $useApproval = $this->approvalHelper && $this->approvalHelper->requiresApproval();
         } catch (\Throwable $th) {
            $useApproval = false; // fallback bila helper/tabel tidak tersedia
         }

         if ($useApproval) {
            try {
               // Buat request approval per karyawan
               $approvalId = $this->approvalHelper->createApprovalRequest(
                  'update',
                  'tb_presensi_karyawan',
                  $idPresensi,
                  $updateData,
                  $beforeRow
               );
               if ($approvalId) {
                  $requests++;
                  continue; // tunggu approval, tidak eksekusi langsung
               }
               // Jika gagal membuat request approval, lanjutkan eksekusi langsung (fallback)
            } catch (\Throwable $th) {
               // fallback ke eksekusi langsung di bawah
            }
         }

         // Eksekusi langsung untuk superadmin
         $result = $this->presensiKaryawan->updatePresensi(
            $idPresensi,
            $idKaryawan,
            $idDepartemen,
            $tanggal,
            $idKehadiran,
            $jamMasuk ?? null,
            $jamKeluar ?? null,
            $keterangan
         );
            if ($result) {
               $updated++;
               // Catat history per karyawan
               try {
                  $afterRow = $this->presensiKaryawan->getPresensiByIdKaryawanTanggal($idKaryawan, $tanggal);
                  $historyData = [
                     'id_presensi' => $afterRow['id_presensi'] ?? $idPresensi,
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
                     'created_at' => date('Y-m-d H:i:s')
                  ];
                  $this->presensiHistory->insert($historyData);
               } catch (\Throwable $th) {
                  // ignore single history failure
               }
            }
         }
         $message = ($this->approvalHelper && $this->approvalHelper->requiresApproval())
            ? 'Request perubahan massal dikirim. Menunggu persetujuan (' . $requests . ' request).'
            : 'Berhasil mengubah presensi massal untuk ' . $updated . ' karyawan.';

         return $this->response->setJSON([
            'status' => true,
            'updated' => $updated,
            'requests' => $requests,
            'message' => $message,
         ]);
      } catch (\Throwable $e) {
         // Tangkap semua error agar tidak melempar 500
         return $this->response->setJSON([
            'status' => false,
            'message' => 'Gagal update massal: ' . ($e->getMessage() ?? 'Terjadi kesalahan.'),
         ]);
      }
   }
}
