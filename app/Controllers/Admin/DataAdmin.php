<?php

namespace App\Controllers\Admin;

use App\Models\AdminModel;
use App\Models\ApprovalModel;
use App\Libraries\ApprovalHelper;

use App\Controllers\BaseController;
use App\Models\AdminUpdateHistoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DataAdmin extends BaseController
{
   protected AdminModel $adminModel;
   protected AdminUpdateHistoryModel $adminUpdateHistoryModel;
   protected ApprovalModel $approvalModel;
   protected ApprovalHelper $approvalHelper;

   protected $adminValidationRules = [
      'nuptk' => [
         'rules' => 'required|max_length[20]|min_length[16]',
         'errors' => [
            'required' => 'NUPTK harus diisi.',
            'is_unique' => 'NUPTK ini telah terdaftar.',
            'min_length[16]' => 'Panjang NUPTK minimal 16 karakter'
         ]
      ],
      'nama' => [
         'rules' => 'required|min_length[3]',
         'errors' => [
            'required' => 'Nama harus diisi'
         ]
      ],
      'jk' => ['rules' => 'required', 'errors' => ['required' => 'Jenis kelamin wajib diisi']],
      'no_hp' => 'required|numeric|max_length[20]|min_length[5]'
   ];

   public function __construct()
   {
      $this->adminModel = new AdminModel();
      $this->adminUpdateHistoryModel = new AdminUpdateHistoryModel();
      $this->approvalModel = new ApprovalModel();
      $this->approvalHelper = new ApprovalHelper();
   }

   public function index()
   {
      // Cek akses masterdata
      if (!$this->roleHelper->canAccessMasterData()) {
         return redirect()->to($this->roleHelper->redirectBasedOnRole());
      }

      // Ambil total admin untuk ditampilkan di header
      $totalAdmin = $this->adminModel->countAllResults();
      
      $data = [
         'title' => 'Data admin',
         'ctx' => 'admin',
         'total_admin' => $totalAdmin
      ];

      return view('admin/data/data-admin', $data);
   }

   public function ambilDataAdmin()
   {
      $result = $this->adminModel->getAllAdmin();

      $data = [
         'data' => $result,
         'empty' => empty($result),
         'total_admin' => count($result)
      ];

      return view('admin/data/list-data-admin', $data);
   }

   public function formTambahAdmin()
   {
      $data = [
         'ctx' => 'admin',
         'title' => 'Tambah Data Admin'
      ];

      return view('admin/data/create/create-data-admin', $data);
   }

   public function saveAdmin()
   {
      // validasi
      if (!$this->validate($this->adminValidationRules)) {
         $data = [
            'ctx' => 'admin',
            'title' => 'Tambah Data Admin',
            'validation' => $this->validator,
            'oldInput' => $this->request->getVar()
         ];
         return view('/admin/data/create/create-data-admin', $data);
      }

      // Siapkan data untuk disimpan
      $requestData = [
         'nuptk' => $this->request->getVar('nuptk'),
         'nama_admin' => $this->request->getVar('nama'),
         'jenis_kelamin' => $this->request->getVar('jk'),
         'alamat' => $this->request->getVar('alamat'),
         'no_hp' => $this->request->getVar('no_hp'),
      ];

      // Cek apakah memerlukan approval
      if ($this->approvalHelper->requiresApproval()) {
         // Buat request approval
         $approvalId = $this->approvalHelper->createApprovalRequest(
            'create',
            'tb_admin',
            null,
            $requestData
         );

         if ($approvalId) {
            session()->setFlashdata([
               'msg' => 'Request penambahan data admin telah dikirim dan menunggu persetujuan superadmin',
               'error' => false
            ]);
         } else {
            session()->setFlashdata([
               'msg' => 'Gagal mengirim request approval',
               'error' => true
            ]);
         }
         return redirect()->to('/admin/admin');
      } else {
         // Langsung simpan (untuk super admin)
         $result = $this->adminModel->createAdmin(
            nuptk: $this->request->getVar('nuptk'),
            nama: $this->request->getVar('nama'),
            jenisKelamin: $this->request->getVar('jk'),
            alamat: $this->request->getVar('alamat'),
            noHp: $this->request->getVar('no_hp'),
         );

         if ($result) {
            session()->setFlashdata([
               'msg' => 'Tambah data berhasil',
               'error' => false
            ]);
            return redirect()->to('/admin/admin');
         }

         session()->setFlashdata([
            'msg' => 'Gagal menambah data',
            'error' => true
         ]);
         return redirect()->to('/admin/admin/create/');
      }
   }

   public function formEditAdmin($id)
   {
      $admin = $this->adminModel->getAdminById($id);

      if (empty($admin)) {
         throw new PageNotFoundException('Data admin dengan id ' . $id . ' tidak ditemukan');
      }

      $data = [
         'data' => $admin,
         'ctx' => 'admin',
         'title' => 'Edit Data admin',
         'histories' => $this->adminUpdateHistoryModel->getByAdminId((int)$id)
      ];

      return view('admin/data/edit/edit-data-admin', $data);
   }

   public function updateAdmin()
   {
      $idAdmin = $this->request->getVar('id');

      // validasi
      if (!$this->validate($this->adminValidationRules)) {
         $data = [
            'data' => $this->adminModel->getAdminById($idAdmin),
            'ctx' => 'Admin',
            'title' => 'Edit Data Admin',
            'validation' => $this->validator,
            'oldInput' => $this->request->getVar()
         ];
         return view('/admin/data/edit/edit-data-admin', $data);
      }

      // ambil data lama untuk history
      $adminLama = $this->adminModel->getAdminById($idAdmin);

      // Siapkan data untuk update
      $requestData = [
         'nuptk' => $this->request->getVar('nuptk'),
         'nama_admin' => $this->request->getVar('nama'),
         'jenis_kelamin' => $this->request->getVar('jk'),
         'alamat' => $this->request->getVar('alamat'),
         'no_hp' => $this->request->getVar('no_hp'),
      ];

      // Cek apakah memerlukan approval
      if ($this->approvalHelper->requiresApproval()) {
         // Buat request approval
         $approvalId = $this->approvalHelper->createApprovalRequest(
            'update',
            'tb_admin',
            $idAdmin,
            $requestData,
            $adminLama
         );

         if ($approvalId) {
            session()->setFlashdata([
               'msg' => 'Request perubahan data admin telah dikirim dan menunggu persetujuan superadmin',
               'error' => false
            ]);
         } else {
            session()->setFlashdata([
               'msg' => 'Gagal mengirim request approval',
               'error' => true
            ]);
         }
         return redirect()->to('/admin/admin');
      } else {
         // Langsung update (untuk super admin)
         $result = $this->adminModel->updateAdmin(
            id: $idAdmin,
            nuptk: $this->request->getVar('nuptk'),
            nama: $this->request->getVar('nama'),
            jenisKelamin: $this->request->getVar('jk'),
            alamat: $this->request->getVar('alamat'),
            noHp: $this->request->getVar('no_hp'),
         );

         if ($result) {
            // tulis history perubahan
            try {
               $adminBaru = $this->adminModel->getAdminById($idAdmin);
               $before = [
                  'nuptk' => $adminLama['nuptk'] ?? null,
                  'nama_admin' => $adminLama['nama_admin'] ?? null,
                  'jenis_kelamin' => $adminLama['jenis_kelamin'] ?? null,
                  'alamat' => $adminLama['alamat'] ?? null,
                  'no_hp' => $adminLama['no_hp'] ?? null,
               ];
               $after = [
                  'nuptk' => $adminBaru['nuptk'] ?? null,
                  'nama_admin' => $adminBaru['nama_admin'] ?? null,
                  'jenis_kelamin' => $adminBaru['jenis_kelamin'] ?? null,
                  'alamat' => $adminBaru['alamat'] ?? null,
                  'no_hp' => $adminBaru['no_hp'] ?? null,
               ];
               $changed = [];
               foreach ($after as $key => $val) {
                  if (($before[$key] ?? null) != $val) {
                     $changed[] = $key;
                  }
               }
               $insertData = [
                  'id_admin' => (int)$idAdmin,
                  'changed_fields' => implode(',', $changed),
                  'before_data' => json_encode($before, JSON_UNESCAPED_UNICODE),
                  'after_data' => json_encode($after, JSON_UNESCAPED_UNICODE),
                  'created_at' => date('Y-m-d H:i:s'),
               ];
               $ok = $this->adminUpdateHistoryModel->insert($insertData);
               if ($ok === false) {
                  log_message('error', 'Failed to insert admin history: ' . json_encode($insertData));
               } else {
                  log_message('debug', 'Inserted admin history for ID ' . $idAdmin);
               }
            } catch (\Throwable $th) {
               log_message('error', 'Exception inserting admin history: ' . $th->getMessage());
            }
            session()->setFlashdata([
               'msg' => 'Edit data berhasil',
               'error' => false,
               'show_history' => true
            ]);
            return redirect()->to('/admin/admin/edit/' . $idAdmin);
         }

         session()->setFlashdata([
            'msg' => 'Gagal mengubah data',
            'error' => true
         ]);
         return redirect()->to('/admin/admin/edit/' . $idAdmin);
      }
   }

   public function delete($id)
   {
      // Ambil data yang akan dihapus
      $adminData = $this->adminModel->getAdminById($id);
      
      if (empty($adminData)) {
         session()->setFlashdata([
            'msg' => 'Data admin tidak ditemukan',
            'error' => true
         ]);
         return redirect()->to('/admin/admin');
      }

      // Cek apakah memerlukan approval
      if ($this->approvalHelper->requiresApproval()) {
         // Buat request approval untuk delete
         $approvalId = $this->approvalHelper->createApprovalRequest(
            'delete',
            'tb_admin',
            $id,
            null,
            $adminData
         );

         if ($approvalId) {
            session()->setFlashdata([
               'msg' => 'Request penghapusan data admin telah dikirim dan menunggu persetujuan superadmin',
               'error' => false
            ]);
         } else {
            session()->setFlashdata([
               'msg' => 'Gagal mengirim request approval',
               'error' => true
            ]);
         }
         return redirect()->to('/admin/admin');
      } else {
         // Langsung hapus (untuk super admin)
         $result = $this->adminModel->delete($id);

         if ($result) {
            session()->setFlashdata([
               'msg' => 'Data berhasil dihapus',
               'error' => false
            ]);
            return redirect()->to('/admin/admin');
         }

         session()->setFlashdata([
            'msg' => 'Gagal menghapus data',
            'error' => true
         ]);
         return redirect()->to('/admin/admin');
      }
   }
}
