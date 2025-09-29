<?php

namespace App\Controllers\Admin;

use App\Models\JabatanModel;
use App\Models\DepartemenModel;
use App\Controllers\BaseController;

class JabatanController extends BaseController
{
    protected JabatanModel $jabatanModel;
    protected DepartemenModel $departemenModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->departemenModel = new DepartemenModel();
        $this->jabatanModel = new JabatanModel();
    }

    /**
     * Return redirect to departemen controller
     *
     * @return mixed
     */
    public function index()
    {
        return redirect()->to('admin/departemen');
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */

    public function listData()
    {
        $vars['data'] = $this->jabatanModel->getDataJabatan();
        $htmlContent = '';
        if (!empty($vars['data'])) {
            $htmlContent = view('admin/jabatan/list-jabatan', $vars);
            $data = [
                'result' => 1,
                'htmlContent' => $htmlContent,
            ];
            echo json_encode($data);
        } else {
            echo json_encode(['result' => 0]);
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function tambahJabatan()
    {
        $data = [
            'ctx' => 'departemen',
            'title' => 'Tambah Data Jabatan',
        ];
        return view('/admin/jabatan/create', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function tambahJabatanPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('jabatan', 'Jabatan', 'required|max_length[32]|is_unique[tb_jabatan.jabatan]');

        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to('admin/jabatan/tambah')->withInput();
        } else {
            if ($this->jabatanModel->addJabatan()) {
                $this->session->setFlashdata('success', 'Tambah data berhasil');
                return redirect()->to('admin/jabatan');
            } else {
                $this->session->setFlashdata('error', 'Gagal menambah data');
                return redirect()->to('admin/jabatan/tambah')->withInput();
            }
        }

        return redirect()->to('admin/jabatan/tambah');
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function editJabatan($id)
    {
        $data['title'] = 'Edit Jabatan';
        $data['ctx'] = 'departemen';
        $data['jabatan'] = $this->jabatanModel->getJabatan($id);
        if (empty($data['jabatan'])) {
            return redirect()->to('admin/departemen');
        }

        return view('/admin/jabatan/edit', $data);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function editJabatanPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('jabatan', 'Jabatan', 'required|max_length[32]|is_unique[tb_jabatan.jabatan]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back();
        } else {
            $id = inputPost('id');
            if ($this->jabatanModel->editJabatan($id)) {
                $this->session->setFlashdata('success', 'Edit data berhasil');
                return redirect()->to('admin/jabatan');
            } else {
                $this->session->setFlashdata('error', 'Gagal Mengubah data');
            }
        }
        return redirect()->to('admin/jabatan/edit/' . cleanNumber($id));
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function deleteJabatanPost($id = null)
    {
        $id = inputPost('id');
        $jabatan = $this->jabatanModel->getJabatan($id);
        if (!empty($jabatan)) {
            if (!empty($this->departemenModel->getDepartemenCountByJabatan($id))) {
                $this->session->setFlashdata('error', 'Hapus Relasi Data Dulu');
                exit();
            }
            if ($this->jabatanModel->deleteJabatan($id)) {
                $this->session->setFlashdata('success', 'Data berhasil dihapus');
            } else {
                $this->session->setFlashdata('error', 'Gagal menghapus data');
            }
        }
    }
}
