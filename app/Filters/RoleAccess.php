<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Libraries\RoleHelper;
use App\Libraries\enums\UserRole;

class RoleAccess implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Cek apakah user sudah login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Jika tidak ada argument role yang diperlukan, skip filter
        if (empty($arguments)) {
            return;
        }

        $requiredRole = $arguments[0] ?? null;
        if (!$requiredRole) {
            return;
        }

        // Konversi string role ke enum
        $roleEnum = null;
        switch ($requiredRole) {
            case 'super_admin':
                $roleEnum = UserRole::SUPER_ADMIN;
                break;
            case 'admin':
                $roleEnum = UserRole::ADMIN;
                break;
            case 'user':
                $roleEnum = UserRole::USER;
                break;
            default:
                return;
        }

        // Cek apakah user memiliki akses
        if (!RoleHelper::hasAccess($roleEnum)) {
            // Redirect ke halaman yang sesuai berdasarkan role user
            $userRole = RoleHelper::getUserRole();
            
            switch ($userRole) {
                case UserRole::SUPER_ADMIN:
                case UserRole::ADMIN:
                    return redirect()->to('/admin/dashboard');
                case UserRole::USER:
                    return redirect()->to('/scan');
                default:
                    return redirect()->to('/login');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada action setelah request
    }
}
