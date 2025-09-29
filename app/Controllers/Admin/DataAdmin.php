<?php

namespace App\Controllers\Admin;

use App\Models\AdminModel;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class DataAdmin extends BaseController
{
   protected AdminModel $adminModel;

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
         session()->setFlashdata([
            'msg' => 'Edit data berhasil',
            'error' => false
         ]);
         return redirect()->to('/admin/admin');
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
