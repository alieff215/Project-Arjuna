<?php

namespace App\Controllers\Admin;

use App\Models\AdminModel;

use App\Controllers\BaseController;
use App\Models\AdminUpdateHistoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DataAdmin extends BaseController
{
   protected AdminModel $adminModel;
   protected AdminUpdateHistoryModel $adminUpdateHistoryModel;

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
   }

   public function index()
   {
      $data = [
         'title' => 'Data admin',
         'ctx' => 'admin',
      ];

      return view('admin/data/data-admin', $data);
   }

   public function ambilDataAdmin()
   {
      $result = $this->adminModel->getAllAdmin();

      $data = [
         'data' => $result,
         'empty' => empty($result)
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

      // simpan
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

      // update
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

   public function delete($id)
   {
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
