<?php

namespace App\Controllers\Admin;

use App\Models\JabatanModel;
use App\Models\DepartemenModel;
use App\Controllers\BaseController;
class DepartemenController extends BaseController
{
    protected DepartemenModel $departemenModel;
    protected JabatanModel $jabatanModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->departemenModel = new DepartemenModel();
        $this->jabatanModel = new JabatanModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $data = [
            'title' => 'Departemen & Jabatan',
            'ctx' => 'departemen',
            'generalSettings' => $this->generalSettings,
        ];

        return view('admin/departemen/index', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function listData()
    {
        try {
            $vars['data'] = $this->departemenModel->getDataDepartemen();
            $htmlContent = '';
            if (!empty($vars['data'])) {
                $htmlContent = view('admin/departemen/list-departemen', $vars);
                $data = [
                    'result' => 1,
                    'htmlContent' => $htmlContent,
                ];
                echo json_encode($data);
            } else {
                echo json_encode(['result' => 0]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in DepartemenController::listData: ' . $e->getMessage());
            echo json_encode([
                'result' => 0,
                'error' => 'Internal Server Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function tambahDepartemen()
    {
        $data['ctx'] = 'departemen';
        $data['title'] = 'Tambah Data Departemen';
        $data['jabatan'] = $this->jabatanModel->findAll();

        return view('/admin/departemen/create', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function tambahDepartemenPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('departemen', 'Departemen', 'required|max_length[32]');
        $val->setRule('id_jabatan', 'Jabatan', 'required|numeric');

        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to('admin/departemen/tambah')->withInput();
        } else {
            if ($this->departemenModel->addDepartemen()) {
                $this->session->setFlashdata('success', 'Tambah data berhasil');
                return redirect()->to('admin/departemen');
            } else {
                $this->session->setFlashdata('error', 'Gagal menambah data');
                return redirect()->to('admin/departemen/tambah')->withInput();
            }
        }

        return redirect()->to('admin/departemen/tambah');
    }

    /**
     * Return a resource object, with default properties
     *
     * @return mixed
     */
    public function editDepartemen($id)
    {
        $data['title'] = 'Edit Departemen';
        $data['ctx'] = 'departemen';
        $data['jabatan'] = $this->jabatanModel->findAll();
        $data['departemen'] = $this->departemenModel->getDepartemen($id);
        if (empty($data['departemen'])) {
            return redirect()->to('admin/departemen');
        }

        return view('/admin/departemen/edit', $data);
    }

    /**
     * Edit a resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function editDepartemenPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('departemen', 'Departemen', 'required|max_length[32]');
        $val->setRule('id_jabatan', 'Jabatan', 'required|numeric');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back();
        } else {
            $id = inputPost('id');
            if ($this->departemenModel->editDepartemen($id)) {
                $this->session->setFlashdata('success', 'Edit data berhasil');
                return redirect()->to('admin/departemen');
            } else {
                $this->session->setFlashdata('error', 'Gagal Mengubah data');
            }
        }
        return redirect()->to('admin/departemen/edit/' . cleanNumber($id));
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function deleteDepartemenPost($id = null)
    {
        $id = inputPost('id');
        $departemen = $this->departemenModel->getDepartemen($id);
        if (!empty($departemen)) {
            $KaryawanModel = new \App\Models\KaryawanModel();
            if (!empty($KaryawanModel->getKaryawanCountByDepartemen($id))) {
                $this->session->setFlashdata('error', 'Departemen Masih Memiliki Karyawan Aktif');
                exit();
            }
            if ($this->departemenModel->deleteDepartemen($id)) {
                $this->session->setFlashdata('success', 'Data berhasil dihapus');
            } else {
                $this->session->setFlashdata('error', 'Gagal menghapus data');
            }
        }
    }
}
