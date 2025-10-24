<?php

namespace App\Libraries;

use App\Models\ApprovalModel;
use App\Libraries\RoleHelper;
use App\Libraries\enums\UserRole;

class ApprovalHelper
{
    protected ApprovalModel $approvalModel;

    public function __construct()
    {
        $this->approvalModel = new ApprovalModel();
    }

    /**
     * Cek apakah user saat ini memerlukan approval
     */
    public function requiresApproval($userData = null): bool
    {
        $userRole = RoleHelper::getUserRole($userData);
        
        // Hanya admin biasa yang memerlukan approval
        // Super admin tidak memerlukan approval
        return $userRole === UserRole::ADMIN;
    }

    /**
     * Membuat request approval untuk operasi CRUD
     */
    public function createApprovalRequest($requestType, $tableName, $recordId, $requestData, $originalData = null, $userData = null)
    {
        // Cek apakah memerlukan approval
        if (!$this->requiresApproval($userData)) {
            return false; // Tidak memerlukan approval
        }

        // Ambil user ID
        $userId = $this->getCurrentUserId($userData);
        if (!$userId) {
            return false;
        }

        // Cek apakah sudah ada request pending untuk record yang sama
        if ($this->approvalModel->hasPendingRequest($tableName, $recordId, $requestType)) {
            return false; // Sudah ada request pending
        }

        return $this->approvalModel->createApprovalRequest(
            $requestType,
            $tableName,
            $recordId,
            $requestData,
            $originalData,
            $userId
        );
    }

    /**
     * Proses approval request
     */
    public function processApproval($requestId, $action, $notes = null, $userData = null)
    {
        // Cek apakah user adalah super admin
        $userRole = RoleHelper::getUserRole($userData);
        if ($userRole !== UserRole::SUPER_ADMIN) {
            return false;
        }

        $userId = $this->getCurrentUserId($userData);
        if (!$userId) {
            return false;
        }

        if ($action === 'approve') {
            return $this->approvalModel->approveRequest($requestId, $userId, $notes);
        } elseif ($action === 'reject') {
            return $this->approvalModel->rejectRequest($requestId, $userId, $notes);
        }

        return false;
    }

    /**
     * Eksekusi request yang sudah di-approve
     */
    public function executeApprovedRequest($requestId)
    {
        $request = $this->approvalModel->getRequestById($requestId);
        
        if (!$request || $request['status'] !== 'approved') {
            return false;
        }

        $requestData = json_decode($request['request_data'], true);
        $originalData = $request['original_data'] ? json_decode($request['original_data'], true) : null;

        try {
            switch ($request['request_type']) {
                case 'create':
                    return $this->executeCreate($request['table_name'], $requestData);
                
                case 'update':
                    return $this->executeUpdate($request['table_name'], $request['record_id'], $requestData, $originalData);
                
                case 'delete':
                    return $this->executeDelete($request['table_name'], $request['record_id'], $originalData);
                
                default:
                    return false;
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to execute approved request: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Eksekusi operasi create
     */
    protected function executeCreate($tableName, $data)
    {
        $model = $this->getModelForTable($tableName);
        if (!$model) {
            log_message('error', "Model not found for table: {$tableName}");
            return false;
        }

        try {
            // Gunakan method yang sesuai untuk setiap model
            switch ($tableName) {
                case 'tb_departemen':
                    // Simpan data ke session untuk inputValues()
                    $this->setInputData($data);
                    $result = $model->addDepartemen();
                    break;
                case 'tb_jabatan':
                    $this->setInputData($data);
                    $result = $model->addJabatan();
                    break;
                case 'tb_gaji':
                    $result = $model->insert($data);
                    break;
                case 'tb_presensi_karyawan':
                case 'tb_presensi_admin':
                    $result = $model->insert($data);
                    break;
                default:
                    $result = $model->insert($data);
                    break;
            }
            
            if ($result === false) {
                log_message('error', "Failed to insert data into {$tableName}: " . json_encode($model->errors()));
                return false;
            }
            return $result;
        } catch (\Exception $e) {
            log_message('error', "Exception during create operation: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Eksekusi operasi update
     */
    protected function executeUpdate($tableName, $recordId, $data, $originalData)
    {
        $model = $this->getModelForTable($tableName);
        if (!$model) {
            return false;
        }

        try {
            // Gunakan method yang sesuai untuk setiap model
            switch ($tableName) {
                case 'tb_departemen':
                    $this->setInputData($data);
                    $result = $model->editDepartemen($recordId);
                    break;
                case 'tb_jabatan':
                    $this->setInputData($data);
                    $result = $model->editJabatan($recordId);
                    break;
                case 'tb_gaji':
                    $result = $model->update($recordId, $data);
                    break;
                case 'tb_presensi_karyawan':
                    // Untuk presensi karyawan, gunakan method updatePresensi dengan parameter lengkap
                    $result = $model->updatePresensi(
                        $recordId,
                        $data['id_karyawan'],
                        $data['id_departemen'],
                        $data['tanggal'],
                        $data['id_kehadiran'],
                        $data['jam_masuk'] ?? null,
                        $data['jam_keluar'] ?? null,
                        $data['keterangan'],
                        'approved',
                        null,
                        $this->getCurrentUserId()
                    );
                    break;
                case 'tb_presensi_admin':
                    // Untuk presensi admin, gunakan method updatePresensi dengan parameter lengkap
                    $result = $model->updatePresensi(
                        $recordId,
                        $data['id_admin'],
                        $data['tanggal'],
                        $data['id_kehadiran'],
                        $data['jam_masuk'] ?? null,
                        $data['jam_keluar'] ?? null,
                        $data['keterangan'],
                        'approved',
                        null,
                        $this->getCurrentUserId()
                    );
                    break;
                default:
                    $result = $model->update($recordId, $data);
                    break;
            }
            
            return $result;
        } catch (\Exception $e) {
            log_message('error', "Exception during update operation: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Eksekusi operasi delete
     */
    protected function executeDelete($tableName, $recordId, $originalData)
    {
        $model = $this->getModelForTable($tableName);
        if (!$model) {
            return false;
        }

        try {
            // Gunakan method yang sesuai untuk setiap model
            switch ($tableName) {
                case 'tb_departemen':
                    $result = $model->deleteDepartemen($recordId);
                    break;
                case 'tb_jabatan':
                    $result = $model->deleteJabatan($recordId);
                    break;
                case 'tb_gaji':
                    $result = $model->delete($recordId);
                    break;
                case 'tb_presensi_karyawan':
                case 'tb_presensi_admin':
                    $result = $model->delete($recordId);
                    break;
                default:
                    $result = $model->delete($recordId);
                    break;
            }
            
            return $result;
        } catch (\Exception $e) {
            log_message('error', "Exception during delete operation: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Dapatkan model berdasarkan nama tabel
     */
    protected function getModelForTable($tableName)
    {
        try {
            switch ($tableName) {
                case 'tb_admin':
                    return new \App\Models\AdminModel();
                case 'tb_karyawan':
                    return new \App\Models\KaryawanModel();
                case 'tb_departemen':
                    return new \App\Models\DepartemenModel();
                case 'tb_jabatan':
                    return new \App\Models\JabatanModel();
                case 'tb_gaji':
                    return new \App\Models\GajiModel();
                case 'tb_presensi_karyawan':
                    return new \App\Models\PresensiKaryawanModel();
                case 'tb_presensi_admin':
                    return new \App\Models\PresensiAdminModel();
                default:
                    log_message('error', "Unknown table name: {$tableName}");
                    return null;
            }
        } catch (\Exception $e) {
            log_message('error', "Failed to create model for table {$tableName}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Dapatkan user ID saat ini
     */
    protected function getCurrentUserId($userData = null)
    {
        if ($userData && isset($userData['id'])) {
            return $userData['id'];
        }

        // Coba ambil dari session
        $session = \Config\Services::session();
        
        // Coba beberapa kemungkinan key session
        $userId = $session->get('user_id') ?? 
                  $session->get('id') ?? 
                  $session->get('logged_in_user_id');
        
        // Jika masih tidak ada, coba dari Myth Auth
        if (!$userId && function_exists('user')) {
            try {
                $mythUser = user();
                if ($mythUser && isset($mythUser->id)) {
                    $userId = $mythUser->id;
                }
            } catch (\Exception $e) {
                // Ignore error
            }
        }
        
        return $userId;
    }

    /**
     * Dapatkan semua request pending
     */
    public function getPendingRequests()
    {
        return $this->approvalModel->getPendingRequests();
    }

    /**
     * Dapatkan request dengan detail user
     */
    public function getRequestsWithUserDetails()
    {
        return $this->approvalModel->getRequestsWithUserDetails();
    }

    /**
     * Dapatkan statistik approval
     */
    public function getApprovalStats()
    {
        return $this->approvalModel->getApprovalStats();
    }

    /**
     * Cek apakah ada request pending untuk record tertentu
     */
    public function hasPendingRequest($tableName, $recordId, $requestType = null)
    {
        return $this->approvalModel->hasPendingRequest($tableName, $recordId, $requestType);
    }

    /**
     * Set input data untuk model yang menggunakan inputValues()
     */
    protected function setInputData($data)
    {
        // Simpan data ke session untuk diakses oleh inputValues()
        $session = \Config\Services::session();
        
        // Set data ke session dengan prefix khusus
        foreach ($data as $key => $value) {
            $session->set("approval_input_{$key}", $value);
        }
    }
}
