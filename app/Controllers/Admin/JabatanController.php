<?php

namespace App\Controllers\Admin;

use App\Models\JabatanModel;
use App\Models\DepartemenModel;
use App\Models\ApprovalModel;
use App\Libraries\ApprovalHelper;
use App\Controllers\BaseController;

class JabatanController extends BaseController
{
    protected JabatanModel $jabatanModel;
    protected DepartemenModel $departemenModel;
    protected ApprovalModel $approvalModel;
    protected ApprovalHelper $approvalHelper;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->departemenModel = new DepartemenModel();
        $this->jabatanModel = new JabatanModel();
        $this->approvalModel = new ApprovalModel();
        $this->approvalHelper = new ApprovalHelper();
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
            // Siapkan data untuk disimpan
            $requestData = [
                'jabatan' => $this->request->getVar('jabatan'),
            ];

            // Cek apakah memerlukan approval
            if ($this->approvalHelper->requiresApproval()) {
                // Buat request approval
                $approvalId = $this->approvalHelper->createApprovalRequest(
                    'create',
                    'tb_jabatan',
                    null,
                    $requestData
                );

                if ($approvalId) {
                    $this->session->setFlashdata('success', 'Request penambahan data jabatan telah dikirim dan menunggu persetujuan superadmin');
                } else {
                    $this->session->setFlashdata('error', 'Gagal mengirim request approval');
                }
                return redirect()->to('admin/jabatan');
            } else {
                // Langsung simpan (untuk super admin)
                if ($this->jabatanModel->addJabatan()) {
                    $this->session->setFlashdata('success', 'Tambah data berhasil');
                    return redirect()->to('admin/jabatan');
                } else {
                    $this->session->setFlashdata('error', 'Gagal menambah data');
                    return redirect()->to('admin/jabatan/tambah')->withInput();
                }
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
            
            // Ambil data lama
            $jabatanLama = $this->jabatanModel->getJabatan($id);
            
            // Siapkan data untuk update
            $requestData = [
                'jabatan' => $this->request->getVar('jabatan'),
            ];

            // Cek apakah memerlukan approval
            if ($this->approvalHelper->requiresApproval()) {
                // Buat request approval
                $approvalId = $this->approvalHelper->createApprovalRequest(
                    'update',
                    'tb_jabatan',
                    $id,
                    $requestData,
                    $jabatanLama
                );

                if ($approvalId) {
                    $this->session->setFlashdata('success', 'Request perubahan data jabatan telah dikirim dan menunggu persetujuan superadmin');
                } else {
                    $this->session->setFlashdata('error', 'Gagal mengirim request approval');
                }
                return redirect()->to('admin/jabatan');
            } else {
                // Langsung update (untuk super admin)
                if ($this->jabatanModel->editJabatan($id)) {
                    $this->session->setFlashdata('success', 'Edit data berhasil');
                    return redirect()->to('admin/jabatan');
                } else {
                    $this->session->setFlashdata('error', 'Gagal Mengubah data');
                }
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
        
        if (empty($jabatan)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data jabatan tidak ditemukan'
            ]);
        }
        
        if (!empty($this->departemenModel->getDepartemenCountByJabatan($id))) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Hapus relasi data departemen terlebih dahulu'
            ]);
        }

        // Cek apakah memerlukan approval
        if ($this->approvalHelper->requiresApproval()) {
            // Buat request approval untuk delete
            $approvalId = $this->approvalHelper->createApprovalRequest(
                'delete',
                'tb_jabatan',
                $id,
                null,
                $jabatan
            );

            if ($approvalId) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Request penghapusan data jabatan telah dikirim dan menunggu persetujuan superadmin'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengirim request approval'
                ]);
            }
        } else {
            // Langsung hapus (untuk super admin)
            if ($this->jabatanModel->deleteJabatan($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus data'
                ]);
            }
        }
    }
}
