<?php

namespace App\Controllers\Admin;

use App\Models\KaryawanModel;
use App\Models\DepartemenModel;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
use App\Models\UploadModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DataKaryawan extends BaseController
{
   protected KaryawanModel $karyawanModel;
   protected DepartemenModel $departemenModel;
   protected JabatanModel $jabatanModel;

   protected $karyawanValidationRules = [
      'nis' => [
         'rules' => 'required|max_length[20]|min_length[4]',
         'errors' => [
            'required' => 'NIS harus diisi.',
            'is_unique' => 'NIS ini telah terdaftar.',
            'min_length[4]' => 'Panjang NIS minimal 4 karakter'
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
   ];

   public function __construct()
   {
      $this->karyawanModel = new KaryawanModel();
      $this->departemenModel = new DepartemenModel();
      $this->jabatanModel = new JabatanModel();
   }

   public function index()
   {
      $data = [
         'title' => 'Data Karyawan',
         'ctx' => 'karyawan',
         'departemen' => $this->departemenModel->getDataDepartemen(),
         'jabatan' => $this->jabatanModel->getDataJabatan()
      ];

      return view('admin/data/data-karyawan', $data);
   }

   public function ambilDataKaryawan()
   {
      $departemen = $this->request->getVar('departemen') ?? null;
      $jabatan = $this->request->getVar('jabatan') ?? null;

      $result = $this->karyawanModel->getAllKaryawanWithDepartemen($departemen, $jabatan);

      $data = [
         'data' => $result,
         'empty' => empty($result)
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

      // simpan
      $result = $this->karyawanModel->createKaryawan(
         nis: $this->request->getVar('nis'),
         nama: $this->request->getVar('nama'),
         idDepartemen: intval($this->request->getVar('id_departemen')),
         jenisKelamin: $this->request->getVar('jk'),
         noHp: $this->request->getVar('no_hp'),
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

   public function formEditKaryawan($id)
   {
      $karyawan = $this->karyawanModel->getKaryawanById($id);
      $departemen = $this->departemenModel->getDataDepartemen();

      if (empty($karyawan) || empty($departemen)) {
         throw new PageNotFoundException('Data karyawan dengan id ' . $id . ' tidak ditemukan');
      }

      $data = [
         'data' => $karyawan,
         'departemen' => $departemen,
         'ctx' => 'karyawan',
         'title' => 'Edit Karyawan',
      ];

      return view('admin/data/edit/edit-data-karyawan', $data);
   }

   public function updateKaryawan()
   {
      $idKaryawan = $this->request->getVar('id');

      $karyawanLama = $this->karyawanModel->getKaryawanById($idKaryawan);

      if ($karyawanLama['nis'] != $this->request->getVar('nis')) {
         $this->karyawanValidationRules['nis']['rules'] = 'required|max_length[20]|min_length[4]|is_unique[tb_karyawan.nis]';
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

      // update
      $result = $this->karyawanModel->updateKaryawan(
         id: $idKaryawan,
         nis: $this->request->getVar('nis'),
         nama: $this->request->getVar('nama'),
         idDepartemen: intval($this->request->getVar('id_departemen')),
         jenisKelamin: $this->request->getVar('jk'),
         noHp: $this->request->getVar('no_hp'),
      );

      if ($result) {
         session()->setFlashdata([
            'msg' => 'Edit data berhasil',
            'error' => false
         ]);
         return redirect()->to('/admin/karyawan');
      }

      session()->setFlashdata([
         'msg' => 'Gagal mengubah data',
         'error' => true
      ]);
      return redirect()->to('/admin/karyawan/edit/' . $idKaryawan);
   }

   public function delete($id)
   {
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
