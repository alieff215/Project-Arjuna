<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ApprovalModel;
use App\Libraries\ApprovalHelper;
use App\Libraries\RoleHelper;
use App\Libraries\enums\UserRole;

class ApprovalManagement extends BaseController
{
    protected ApprovalModel $approvalModel;
    protected ApprovalHelper $approvalHelper;

    public function __construct()
    {
        $this->approvalModel = new ApprovalModel();
        $this->approvalHelper = new ApprovalHelper();
    }

    /**
     * Halaman utama approval management
     */
    public function index()
    {
        // Cek akses super admin
        if (!RoleHelper::hasAccess(UserRole::SUPER_ADMIN)) {
            return redirect()->to(RoleHelper::redirectBasedOnRole());
        }

        $data = [
            'title' => 'Manajemen Approval',
            'ctx' => 'approval',
            'stats' => $this->approvalHelper->getApprovalStats()
        ];

        return view('admin/approval/approval-management', $data);
    }

    /**
     * Ambil data approval requests
     */
    public function getApprovalRequests()
    {
        // Cek akses super admin
        if (!RoleHelper::hasAccess(UserRole::SUPER_ADMIN)) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $status = $this->request->getVar('status') ?? 'all';
        
        if ($status === 'all') {
            $requests = $this->approvalModel->getRequestsWithUserDetails();
        } else {
            $requests = $this->approvalModel->getRequestsWithUserDetailsByStatus($status);
        }

        $data = [
            'requests' => $requests,
            'empty' => empty($requests)
        ];

        return view('admin/approval/list-approval-requests', $data);
    }

    /**
     * Detail approval request
     */
    public function detail($id)
    {
        // Cek akses super admin
        if (!RoleHelper::hasAccess(UserRole::SUPER_ADMIN)) {
            return redirect()->to(RoleHelper::redirectBasedOnRole());
        }

        // Ambil request dengan detail user
        $requests = $this->approvalModel->getRequestsWithUserDetails();
        $request = null;
        
        foreach ($requests as $req) {
            if ($req['id'] == $id) {
                $request = $req;
                break;
            }
        }
        
        if (!$request) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Request approval tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Approval Request',
            'ctx' => 'approval',
            'request' => $request,
            'request_data' => json_decode($request['request_data'], true),
            'original_data' => $request['original_data'] ? json_decode($request['original_data'], true) : null
        ];

        return view('admin/approval/detail-approval-request', $data);
    }

    /**
     * Approve request
     */
    public function approve($id)
    {
        // Cek akses super admin
        if (!RoleHelper::hasAccess(UserRole::SUPER_ADMIN)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $notes = $this->request->getVar('notes');
        
        $result = $this->approvalHelper->processApproval($id, 'approve', $notes);
        
        if ($result) {
            // Eksekusi request yang sudah di-approve
            $this->approvalHelper->executeApprovedRequest($id);
            
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Request berhasil di-approve'
            ]);
        }

        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Gagal approve request'
        ]);
    }

    /**
     * Reject request
     */
    public function reject($id)
    {
        // Cek akses super admin
        if (!RoleHelper::hasAccess(UserRole::SUPER_ADMIN)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $reason = $this->request->getVar('reason');
        
        if (empty($reason)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Alasan penolakan harus diisi'
            ]);
        }
        
        $result = $this->approvalHelper->processApproval($id, 'reject', $reason);
        
        if ($result) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Request berhasil di-reject'
            ]);
        }

        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Gagal reject request'
        ]);
    }

    /**
     * Bulk approve
     */
    public function bulkApprove()
    {
        // Cek akses super admin
        if (!RoleHelper::hasAccess(UserRole::SUPER_ADMIN)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $ids = $this->request->getVar('ids');
        
        if (empty($ids) || !is_array($ids)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Tidak ada request yang dipilih'
            ]);
        }

        $success = 0;
        $failed = 0;

        foreach ($ids as $id) {
            $result = $this->approvalHelper->processApproval($id, 'approve');
            if ($result) {
                $this->approvalHelper->executeApprovedRequest($id);
                $success++;
            } else {
                $failed++;
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => "Berhasil approve {$success} request, gagal {$failed} request"
        ]);
    }

    /**
     * Bulk reject
     */
    public function bulkReject()
    {
        // Cek akses super admin
        if (!RoleHelper::hasAccess(UserRole::SUPER_ADMIN)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $ids = $this->request->getVar('ids');
        $reason = $this->request->getVar('reason');
        
        if (empty($ids) || !is_array($ids)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Tidak ada request yang dipilih'
            ]);
        }

        if (empty($reason)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Alasan penolakan harus diisi'
            ]);
        }

        $success = 0;
        $failed = 0;

        foreach ($ids as $id) {
            $result = $this->approvalHelper->processApproval($id, 'reject', $reason);
            if ($result) {
                $success++;
            } else {
                $failed++;
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => "Berhasil reject {$success} request, gagal {$failed} request"
        ]);
    }

    /**
     * Get approval statistics
     */
    public function getStats()
    {
        // Cek akses super admin
        if (!RoleHelper::hasAccess(UserRole::SUPER_ADMIN)) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $stats = $this->approvalHelper->getApprovalStats();
        
        return $this->response->setJSON($stats);
    }
}
