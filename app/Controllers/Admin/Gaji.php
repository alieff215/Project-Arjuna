<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GajiModel;
use App\Models\DepartemenModel;
use App\Models\JabatanModel;

class Gaji extends BaseController
{
    protected $gajiModel;
    protected $departemenModel;
    protected $jabatanModel;

    public function __construct()
    {
        $this->gajiModel = new GajiModel();
        $this->departemenModel = new DepartemenModel();
        $this->jabatanModel = new JabatanModel();
    }

    public function index()
    {
        $data['title'] = 'Manajemen Gaji';
        $data['gaji'] = $this->gajiModel->getDataGaji();
        $data['departemen'] = $this->departemenModel->getAllDepartemen();
        $data['jabatan'] = $this->jabatanModel->getAllJabatan();

        return view('admin/gaji/index', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $this->gajiModel->addGaji();
            session()->setFlashdata('success', 'Gaji berhasil ditambahkan');
            return redirect()->to(base_url('admin/gaji'));
        }

        $data['title'] = 'Tambah Gaji';
        $data['departemen'] = $this->departemenModel->getAllDepartemen();
        $data['jabatan'] = $this->jabatanModel->getAllJabatan();

        return view('admin/gaji/add', $data);
    }

    public function edit($id)
    {
        if ($this->request->getMethod() === 'post') {
            $this->gajiModel->editGaji($id);
            session()->setFlashdata('success', 'Gaji berhasil diperbarui');
            return redirect()->to(base_url('admin/gaji'));
        }

        $data['title'] = 'Edit Gaji';
        $data['gaji'] = $this->gajiModel->getGaji($id);
        $data['departemen'] = $this->departemenModel->getAllDepartemen();
        $data['jabatan'] = $this->jabatanModel->getAllJabatan();

        if (empty($data['gaji'])) {
            session()->setFlashdata('error', 'Gaji tidak ditemukan');
            return redirect()->to(base_url('admin/gaji'));
        }

        return view('admin/gaji/edit', $data);
    }

    public function delete($id)
    {
        $this->gajiModel->deleteGaji($id);
        session()->setFlashdata('success', 'Gaji berhasil dihapus');
        return redirect()->to(base_url('admin/gaji'));
    }

    public function rekap()
    {
        $filter = $this->request->getGet('filter') ?? 'day';
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-d');
        $end_date = $this->request->getGet('end_date') ?? date('Y-m-d');

        $data['title'] = 'Rekap Gaji Karyawan';
        $data['rekap_gaji'] = $this->gajiModel->getRekapGaji($filter, $start_date, $end_date);
        $data['filter'] = $filter;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        return view('admin/gaji/rekap', $data);
    }

    public function export()
    {
        $filter = $this->request->getGet('filter') ?? 'day';
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-d');
        $end_date = $this->request->getGet('end_date') ?? date('Y-m-d');

        return $this->gajiModel->exportToCSV($filter, $start_date, $end_date);
    }
}