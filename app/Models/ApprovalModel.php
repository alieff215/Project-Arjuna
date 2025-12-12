<?php

namespace App\Models;

use CodeIgniter\Model;

class ApprovalModel extends Model
{
    protected $table = 'approval_requests';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'request_type',
        'table_name',
        'record_id',
        'request_data',
        'original_data',
        'requested_by',
        'approved_by',
        'status',
        'approval_notes',
        'rejection_reason',
        'created_at',
        'updated_at',
        'approved_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Membuat request approval baru
     */
    public function createApprovalRequest($requestType, $tableName, $recordId, $requestData, $originalData = null, $requestedBy)
    {
        $data = [
            'request_type' => $requestType,
            'table_name' => $tableName,
            'record_id' => $recordId,
            'request_data' => json_encode($requestData),
            'original_data' => $originalData ? json_encode($originalData) : null,
            'requested_by' => $requestedBy,
            'status' => 'pending'
        ];

        return $this->insert($data);
    }

    /**
     * Mendapatkan semua request yang pending
     */
    public function getPendingRequests()
    {
        return $this->where('status', 'pending')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Mendapatkan request berdasarkan ID
     */
    public function getRequestById($id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Approve request
     */
    public function approveRequest($id, $approvedBy, $notes = null)
    {
        $data = [
            'status' => 'approved',
            'approved_by' => $approvedBy,
            'approval_notes' => $notes,
            'approved_at' => date('Y-m-d H:i:s')
        ];

        return $this->update($id, $data);
    }

    /**
     * Reject request
     */
    public function rejectRequest($id, $approvedBy, $rejectionReason)
    {
        $data = [
            'status' => 'rejected',
            'approved_by' => $approvedBy,
            'rejection_reason' => $rejectionReason,
            'approved_at' => date('Y-m-d H:i:s')
        ];

        return $this->update($id, $data);
    }

    /**
     * Mendapatkan request berdasarkan user yang meminta
     */
    public function getRequestsByUser($userId)
    {
        return $this->where('requested_by', $userId)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Mendapatkan request berdasarkan status
     */
    public function getRequestsByStatus($status)
    {
        return $this->where('status', $status)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Mendapatkan request dengan detail user
     */
    public function getRequestsWithUserDetails()
    {
        try {
            return $this->select('approval_requests.*, u1.username as requested_by_username, u2.username as approved_by_username')
                       ->join('users u1', 'u1.id = approval_requests.requested_by', 'left')
                       ->join('users u2', 'u2.id = approval_requests.approved_by', 'left')
                       ->orderBy('approval_requests.created_at', 'DESC')
                       ->findAll();
        } catch (\Exception $e) {
            // Jika join gagal, ambil data tanpa join
            log_message('error', 'Join query failed: ' . $e->getMessage());
            $requests = $this->orderBy('created_at', 'DESC')->findAll();
            
            // Tambahkan username secara manual
            foreach ($requests as &$request) {
                $request['requested_by_username'] = $this->getUsernameById($request['requested_by']);
                $request['approved_by_username'] = $request['approved_by'] ? $this->getUsernameById($request['approved_by']) : null;
            }
            
            return $requests;
        }
    }

    /**
     * Mendapatkan request dengan detail user berdasarkan status
     */
    public function getRequestsWithUserDetailsByStatus($status)
    {
        try {
            return $this->select('approval_requests.*, u1.username as requested_by_username, u2.username as approved_by_username')
                       ->join('users u1', 'u1.id = approval_requests.requested_by', 'left')
                       ->join('users u2', 'u2.id = approval_requests.approved_by', 'left')
                       ->where('approval_requests.status', $status)
                       ->orderBy('approval_requests.created_at', 'DESC')
                       ->findAll();
        } catch (\Exception $e) {
            // Jika join gagal, ambil data tanpa join
            log_message('error', 'Join query failed for status ' . $status . ': ' . $e->getMessage());
            $requests = $this->where('status', $status)
                           ->orderBy('created_at', 'DESC')
                           ->findAll();
            
            // Tambahkan username secara manual
            foreach ($requests as &$request) {
                $request['requested_by_username'] = $this->getUsernameById($request['requested_by']);
                $request['approved_by_username'] = $request['approved_by'] ? $this->getUsernameById($request['approved_by']) : null;
            }
            
            return $requests;
        }
    }

    /**
     * Cek apakah ada request pending untuk record tertentu
     */
    public function hasPendingRequest($tableName, $recordId, $requestType = null)
    {
        $where = [
            'table_name' => $tableName,
            'record_id' => $recordId,
            'status' => 'pending'
        ];

        if ($requestType) {
            $where['request_type'] = $requestType;
        }

        return $this->where($where)->first() !== null;
    }

    /**
     * Mendapatkan statistik approval
     */
    public function getApprovalStats()
    {
        $stats = [
            'total' => $this->countAllResults(),
            'pending' => $this->where('status', 'pending')->countAllResults(),
            'approved' => $this->where('status', 'approved')->countAllResults(),
            'rejected' => $this->where('status', 'rejected')->countAllResults()
        ];

        return $stats;
    }

    /**
     * Mendapatkan username berdasarkan ID
     */
    protected function getUsernameById($userId)
    {
        if (!$userId) {
            return 'Unknown';
        }

        try {
            $db = \Config\Database::connect();
            $result = $db->table('users')
                        ->select('username')
                        ->where('id', $userId)
                        ->get()
                        ->getRow();
            
            return $result ? $result->username : 'Unknown';
        } catch (\Exception $e) {
            log_message('error', 'Failed to get username for ID ' . $userId . ': ' . $e->getMessage());
            return 'Unknown';
        }
    }
}
