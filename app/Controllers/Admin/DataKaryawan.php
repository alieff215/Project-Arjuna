<?php

namespace App\Controllers\Admin;

use App\Models\KaryawanModel;
use App\Models\DepartemenModel;
use App\Models\ApprovalModel;
use App\Libraries\ApprovalHelper;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
use App\Models\UploadModel;
use App\Models\KaryawanUpdateHistoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DataKaryawan extends BaseController
{
   protected KaryawanModel $karyawanModel;
   protected DepartemenModel $departemenModel;
   protected JabatanModel $jabatanModel;
   protected KaryawanUpdateHistoryModel $karyawanUpdateHistoryModel;
   protected ApprovalModel $approvalModel;
   protected ApprovalHelper $approvalHelper;

   protected $karyawanValidationRules = [
      'nis' => [
         'rules' => 'permit_empty',
         'errors' => [
            'is_unique' => 'NIS ini telah terdaftar.'
         ]
      ],
      'nama' => [
         'rules' => 'required|min_length[3]',
         'errors' => [
            'required' => 'Nama harus diisi'
         ]
      ],
      'id_departemen' => [
         'rules' => 'required',
         'errors' => [
            'required' => 'Departemen harus diisi'
         ]
      ],
      'jk' => ['rules' => 'required', 'errors' => ['required' => 'Jenis kelamin wajib diisi']],
      'no_hp' => 'required|numeric|max_length[20]|min_length[5]'
      ,
      'tanggal_join' => [
         'rules' => 'required',
         'errors' => [
            'required' => 'Tanggal join harus diisi'
         ]
      ]
   ];

   public function __construct()
   {
      $this->karyawanModel = new KaryawanModel();
      $this->departemenModel = new DepartemenModel();
      $this->jabatanModel = new JabatanModel();
      $this->karyawanUpdateHistoryModel = new KaryawanUpdateHistoryModel();
      $this->approvalModel = new ApprovalModel();
      $this->approvalHelper = new ApprovalHelper();
   }

   public function index()
   {
      $data = [
         'title' => 'Data Karyawan',
         'ctx' => 'karyawan',
         'departemen' => $this->departemenModel->getDataDepartemen(),
         'jabatan' => $this->jabatanModel->getDataJabatan(),
         'listDepartemen' => $this->departemenModel->getDataDepartemen(),
         'total_karyawan' => $this->karyawanModel->countAllResults()
      ];

      return view('admin/data/data-karyawan', $data);
   }

   public function ambilDataKaryawan()
   {
      $departemen = $this->request->getVar('departemen') ?? null;
      $jabatan = $this->request->getVar('jabatan') ?? null;
      $id_departemen = $this->request->getVar('id_departemen') ?? null;

      // Debug: log parameter yang diterima
      log_message('debug', 'ambilDataKaryawan - departemen: ' . ($departemen ?? 'null'));
      log_message('debug', 'ambilDataKaryawan - jabatan: ' . ($jabatan ?? 'null'));
      log_message('debug', 'ambilDataKaryawan - id_departemen: ' . ($id_departemen ?? 'null'));

      // Jika id_departemen dikirim dan bukan 'all', gunakan untuk filter
      if (!empty($id_departemen) && $id_departemen !== 'all') {
         $result = $this->karyawanModel->getKaryawanByDepartemen($id_departemen);
         log_message('debug', 'Menggunakan getKaryawanByDepartemen dengan id: ' . $id_departemen);
      } else {
         // Jika memilih "Semua Departemen & Jabatan", kirim null untuk mendapatkan semua data
         $departemenFilter = ($departemen === 'Semua Departemen & Jabatan') ? null : $departemen;
         $jabatanFilter = ($jabatan === 'Semua Departemen & Jabatan') ? null : $jabatan;
         
         $result = $this->karyawanModel->getAllKaryawanWithDepartemen($departemenFilter, $jabatanFilter);
         log_message('debug', 'Menggunakan getAllKaryawanWithDepartemen dengan filter: departemen=' . ($departemenFilter ?? 'null') . ', jabatan=' . ($jabatanFilter ?? 'null'));
      }

      log_message('debug', 'Jumlah hasil: ' . count($result));

      $data = [
         'data' => $result,
         'empty' => empty($result),
         'total_karyawan' => count($result)
      ];

      return view('admin/data/list-data-karyawan', $data);
   }

   public function formTambahKaryawan()
   {
      $departemen = $this->departemenModel->getDataDepartemen();

      $data = [
         'ctx' => 'karyawan',
         'departemen' => $departemen,
         'title' => 'Tambah Data Karyawan'
      ];

      return view('admin/data/create/create-data-karyawan', $data);
   }

   public function saveKaryawan()
   {
      // validasi
      if (!$this->validate($this->karyawanValidationRules)) {
         $departemen = $this->departemenModel->getDataDepartemen();

         $data = [
            'ctx' => 'karyawan',
            'departemen' => $departemen,
            'title' => 'Tambah Data Karyawan',
            'validation' => $this->validator,
            'oldInput' => $this->request->getVar()
         ];
         return view('/admin/data/create/create-data-karyawan', $data);
      }

      // Siapkan data untuk disimpan
      $requestData = [
         'nis' => $this->request->getVar('nis'),
         'nama_karyawan' => $this->request->getVar('nama'),
         'id_departemen' => intval($this->request->getVar('id_departemen')),
         'jenis_kelamin' => $this->request->getVar('jk'),
         'no_hp' => $this->request->getVar('no_hp'),
         'tanggal_join' => $this->request->getVar('tanggal_join'),
      ];

      // Cek apakah memerlukan approval
      if ($this->approvalHelper->requiresApproval()) {
         // Buat request approval
         $approvalId = $this->approvalHelper->createApprovalRequest(
            'create',
            'tb_karyawan',
            null,
            $requestData
         );

         if ($approvalId) {
            session()->setFlashdata([
               'msg' => 'Request penambahan data karyawan telah dikirim dan menunggu persetujuan superadmin',
               'error' => false
            ]);
         } else {
            session()->setFlashdata([
               'msg' => 'Gagal mengirim request approval',
               'error' => true
            ]);
         }
         return redirect()->to('/admin/karyawan');
      } else {
         // Langsung simpan (untuk super admin)
         $result = $this->karyawanModel->createKaryawan(
            nis: $this->request->getVar('nis'),
            nama: $this->request->getVar('nama'),
            idDepartemen: intval($this->request->getVar('id_departemen')),
            jenisKelamin: $this->request->getVar('jk'),
            noHp: $this->request->getVar('no_hp'),
            tanggalJoin: $this->request->getVar('tanggal_join'),
         );

         if ($result) {
            session()->setFlashdata([
               'msg' => 'Tambah data berhasil',
               'error' => false
            ]);
            return redirect()->to('/admin/karyawan');
         }

         session()->setFlashdata([
            'msg' => 'Gagal menambah data',
            'error' => true
         ]);
         return redirect()->to('/admin/karyawan/create');
      }
   }

   public function formEditKaryawan($id)
   {
      $karyawan = $this->karyawanModel->getKaryawanById($id);
      $departemen = $this->departemenModel->getDataDepartemen();
      try {
         $histories = $this->karyawanUpdateHistoryModel->getByKaryawanId((int) $id);
      } catch (\Throwable $th) {
         $histories = [];
      }

      if (empty($karyawan) || empty($departemen)) {
         throw new PageNotFoundException('Data karyawan dengan id ' . $id . ' tidak ditemukan');
      }

      $data = [
         'data' => $karyawan,
         'departemen' => $departemen,
         'ctx' => 'karyawan',
         'title' => 'Edit Karyawan',
         'histories' => $histories
      ];

      return view('admin/data/edit/edit-data-karyawan', $data);
   }

   public function updateKaryawan()
   {
      $idKaryawan = $this->request->getVar('id');

      $karyawanLama = $this->karyawanModel->getKaryawanById($idKaryawan);

      if ($karyawanLama['nis'] != $this->request->getVar('nis')) {
         $this->karyawanValidationRules['nis']['rules'] = 'permit_empty|is_unique[tb_karyawan.nis]';
      }

      // validasi
      if (!$this->validate($this->karyawanValidationRules)) {
         $karyawan = $this->karyawanModel->getKaryawanById($idKaryawan);
         $departemen = $this->departemenModel->getDataDepartemen();

         $data = [
            'data' => $karyawan,
            'departemen' => $departemen,
            'ctx' => 'karyawan',
            'title' => 'Edit Karyawan',
            'validation' => $this->validator,
            'oldInput' => $this->request->getVar()
         ];
         return view('/admin/data/edit/edit-data-karyawan', $data);
      }

      // Siapkan data untuk update
      $requestData = [
         'nis' => $this->request->getVar('nis'),
         'nama_karyawan' => $this->request->getVar('nama'),
         'id_departemen' => intval($this->request->getVar('id_departemen')),
         'jenis_kelamin' => $this->request->getVar('jk'),
         'no_hp' => $this->request->getVar('no_hp'),
         'tanggal_join' => $this->request->getVar('tanggal_join'),
      ];

      // Cek apakah memerlukan approval
      if ($this->approvalHelper->requiresApproval()) {
         // Buat request approval
         $approvalId = $this->approvalHelper->createApprovalRequest(
            'update',
            'tb_karyawan',
            $idKaryawan,
            $requestData,
            $karyawanLama
         );

         if ($approvalId) {
            session()->setFlashdata([
               'msg' => 'Request perubahan data karyawan telah dikirim dan menunggu persetujuan superadmin',
               'error' => false
            ]);
         } else {
            session()->setFlashdata([
               'msg' => 'Gagal mengirim request approval',
               'error' => true
            ]);
         }
         return redirect()->to('/admin/karyawan');
      } else {
         // Langsung update (untuk super admin)
         $result = $this->karyawanModel->updateKaryawan(
            id: $idKaryawan,
            nis: $this->request->getVar('nis'),
            nama: $this->request->getVar('nama'),
            idDepartemen: intval($this->request->getVar('id_departemen')),
            jenisKelamin: $this->request->getVar('jk'),
            noHp: $this->request->getVar('no_hp'),
            tanggalJoin: $this->request->getVar('tanggal_join'),
         );

         if ($result) {
            try {
               $karyawanBaru = $this->karyawanModel->getKaryawanById($idKaryawan);
               $before = [
                  'nis' => $karyawanLama['nis'] ?? null,
                  'nama_karyawan' => $karyawanLama['nama_karyawan'] ?? null,
                  'id_departemen' => $karyawanLama['id_departemen'] ?? null,
                  'jenis_kelamin' => $karyawanLama['jenis_kelamin'] ?? null,
                  'no_hp' => $karyawanLama['no_hp'] ?? null,
                  'tanggal_join' => $karyawanLama['tanggal_join'] ?? null,
               ];
               $after = [
                  'nis' => $karyawanBaru['nis'] ?? null,
                  'nama_karyawan' => $karyawanBaru['nama_karyawan'] ?? null,
                  'id_departemen' => $karyawanBaru['id_departemen'] ?? null,
                  'jenis_kelamin' => $karyawanBaru['jenis_kelamin'] ?? null,
                  'no_hp' => $karyawanBaru['no_hp'] ?? null,
                  'tanggal_join' => $karyawanBaru['tanggal_join'] ?? null,
               ];
               $changed = [];
               foreach ($after as $key => $val) {
                  if (($before[$key] ?? null) != $val) {
                     $changed[] = $key;
                  }
               }
               $insertData = [
                  'id_karyawan' => (int) $idKaryawan,
                  'changed_fields' => implode(',', $changed),
                  'before_data' => json_encode($before, JSON_UNESCAPED_UNICODE),
                  'after_data' => json_encode($after, JSON_UNESCAPED_UNICODE),
               ];
               $ok = $this->karyawanUpdateHistoryModel->insert($insertData);
               if ($ok === false) {
                  log_message('error', 'Failed to insert karyawan history: ' . json_encode($insertData));
               } else {
                  log_message('debug', 'Inserted karyawan history for ID ' . $idKaryawan);
               }
            } catch (\Throwable $th) {
               log_message('error', 'Exception inserting karyawan history: ' . $th->getMessage());
            }
            session()->setFlashdata([
               'msg' => 'Edit data berhasil',
               'error' => false,
               'show_history' => true
            ]);
            return redirect()->to('/admin/karyawan/edit/' . $idKaryawan);
         }

         session()->setFlashdata([
            'msg' => 'Gagal mengubah data',
            'error' => true
         ]);
         return redirect()->to('/admin/karyawan/edit/' . $idKaryawan);
      }
   }

   public function delete($id)
   {
      // Ambil data yang akan dihapus
      $karyawanData = $this->karyawanModel->getKaryawanById($id);
      
      if (empty($karyawanData)) {
         session()->setFlashdata([
            'msg' => 'Data karyawan tidak ditemukan',
            'error' => true
         ]);
         return redirect()->to('/admin/karyawan');
      }

      // Cek apakah memerlukan approval
      if ($this->approvalHelper->requiresApproval()) {
         // Buat request approval untuk delete
         $approvalId = $this->approvalHelper->createApprovalRequest(
            'delete',
            'tb_karyawan',
            $id,
            null,
            $karyawanData
         );

         if ($approvalId) {
            session()->setFlashdata([
               'msg' => 'Request penghapusan data karyawan telah dikirim dan menunggu persetujuan superadmin',
               'error' => false
            ]);
         } else {
            session()->setFlashdata([
               'msg' => 'Gagal mengirim request approval',
               'error' => true
            ]);
         }
         return redirect()->to('/admin/karyawan');
      } else {
         // Langsung hapus (untuk super admin)
         $result = $this->karyawanModel->delete($id);

         if ($result) {
            session()->setFlashdata([
               'msg' => 'Data berhasil dihapus',
               'error' => false
            ]);
            return redirect()->to('/admin/karyawan');
         }

         session()->setFlashdata([
            'msg' => 'Gagal menghapus data',
            'error' => true
         ]);
         return redirect()->to('/admin/karyawan');
      }
   }

   /**
    * Delete Selected Posts
    */
   public function deleteSelectedKaryawan()
   {
      $karyawanIds = inputPost('karyawan_ids');
      $this->karyawanModel->deleteMultiSelected($karyawanIds);
   }

   /*
    *-------------------------------------------------------------------------------------------------
    * IMPORT KARYAWAN
    *-------------------------------------------------------------------------------------------------
    */

   /**
    * Bulk Post Upload
    */
   public function bulkPostKaryawan()
   {
      $data['title'] = 'Import Karyawan';
      $data['ctx'] = 'karyawan';
      $data['departemen'] = $this->departemenModel->getDataDepartemen();

      return view('/admin/data/import-karyawan', $data);
   }

   /**
    * Generate CSV Object Post
    */
   public function generateCSVObjectPost()
   {
      $uploadModel = new UploadModel();
      //delete old txt files
      $files = glob(FCPATH . 'uploads/tmp/*.txt');
      if (!empty($files)) {
         foreach ($files as $item) {
            @unlink($item);
         }
      }
      $file = $uploadModel->uploadCSVFile('file');
      if (!empty($file) && !empty($file['path'])) {
         $obj = $this->karyawanModel->generateCSVObject($file['path']);
         if (!empty($obj)) {
            $data = [
               'result' => 1,
               'numberOfItems' => $obj->numberOfItems,
               'txtFileName' => $obj->txtFileName,
            ];
            echo json_encode($data);
            exit();
         }
      }
      echo json_encode(['result' => 0]);
   }

   /**
    * Import CSV Item Post
    */
   public function importCSVItemPost()
   {
      $txtFileName = inputPost('txtFileName');
      $index = inputPost('index');
      $karyawan = $this->karyawanModel->importCSVItem($txtFileName, $index);
      if (!empty($karyawan)) {
         $data = [
            'result' => 1,
            'karyawan' => $karyawan,
            'index' => $index
         ];
         echo json_encode($data);
      } else {
         $data = [
            'result' => 0,
            'index' => $index
         ];
         echo json_encode($data);
      }
   }

   /**
    * Download CSV File Post
    */
   public function downloadCSVFilePost()
   {
      $submit = inputPost('submit');
      $response = \Config\Services::response();
      if ($submit == 'csv_karyawan_template') {
         return $response->download(FCPATH . 'assets/file/csv_karyawan_template.csv', null);
      } elseif ($submit == 'csv_admin_template') {
         return $response->download(FCPATH . 'assets/file/csv_admin_template.csv', null);
      }
   }
}
