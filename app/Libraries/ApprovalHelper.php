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
            $result = $model->insert($data);
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

        return $model->update($recordId, $data);
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

        return $model->delete($recordId);
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
}
