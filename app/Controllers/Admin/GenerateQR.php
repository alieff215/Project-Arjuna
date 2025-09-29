<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\AdminModel;
use App\Models\DepartemenModel;
use App\Models\KaryawanModel;

class GenerateQR extends BaseController
{
   protected KaryawanModel $karyawanModel;
   protected DepartemenModel $departemenModel;

   protected AdminModel $adminModel;

   public function __construct()
   {
      $this->karyawanModel = new KaryawanModel();
      $this->departemenModel = new DepartemenModel();

      $this->adminModel = new AdminModel();
   }

   public function index()
   {
      $karyawan = $this->karyawanModel->getAllKaryawanWithDepartemen();
      $departemen = $this->departemenModel->getDataDepartemen();
      $admin = $this->adminModel->getAllAdmin();

      $data = [
         'title' => 'Generate QR Code',
         'ctx' => 'qr',
         'karyawan' => $karyawan,
         'departemen' => $departemen,
         'admin' => $admin
      ];

      return view('admin/generate-qr/generate-qr', $data);
   }

   public function getKaryawanByDepartemen()
   {
      $idDepartemen = $this->request->getVar('idDepartemen');

      $karyawan = $this->karyawanModel->getKaryawanByDepartemen($idDepartemen);

      return $this->response->setJSON($karyawan);
   }
}
