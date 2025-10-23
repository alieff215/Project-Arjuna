<?php

namespace App\Libraries;

use App\Libraries\enums\UserRole;
use App\Models\PetugasModel;

class RoleHelper
{
    /**
     * Mendapatkan role user berdasarkan data user
     */
    public static function getUserRole($userData = null): UserRole
    {
        if ($userData === null) {
            // Ambil data user dari session
            $session = \Config\Services::session();
            
            // Cek apakah user sudah login
            if (!$session->get('logged_in')) {
                return UserRole::USER;
            }
            
            // Coba ambil dari Myth Auth user function terlebih dahulu
            $userId = null;
            if (function_exists('user')) {
                try {
                    $mythUser = user();
                    if ($mythUser) {
                        $userId = $mythUser->id;
                        $userData = $mythUser->toArray();
                        log_message('debug', 'Got user from Myth Auth: ' . json_encode($userData));
                        
                        // Langsung proses data dari Myth Auth
                        if (isset($userData['user_role'])) {
                            switch ($userData['user_role']) {
                                case 'super_admin':
                                    return UserRole::SUPER_ADMIN;
                                case 'admin':
                                    return UserRole::ADMIN;
                                case 'user':
                                    return UserRole::USER;
                            }
                        }
                        
                        // Fallback ke is_superadmin
                        if (isset($userData['is_superadmin']) && $userData['is_superadmin'] == '1') {
                            return UserRole::SUPER_ADMIN;
                        }
                        
                        // Jika ada di users table, default ke admin
                        if (isset($userData['id']) && isset($userData['username'])) {
                            return UserRole::ADMIN;
                        }
                    }
                } catch (\Exception $e) {
                    log_message('error', 'Error getting user from Myth Auth: ' . $e->getMessage());
                }
            }
            
            // Jika Myth Auth tidak berhasil, coba session key lain
            if (!$userId) {
                $userId = $session->get('user_id') ?? $session->get('id') ?? $session->get('user')['id'] ?? null;
            }
            
            // Debug: Log session data
            log_message('debug', 'Session data: ' . json_encode([
                'logged_in' => $session->get('logged_in'),
                'user_id' => $userId,
                'is_superadmin' => $session->get('is_superadmin'),
                'user_role' => $session->get('user_role'),
                'all_session' => $session->get()
            ]));
            
            // Jika masih tidak ada user_id, coba ambil dari session yang lain
            if (!$userId) {
                $allSession = $session->get();
                foreach ($allSession as $key => $value) {
                    if (strpos($key, 'user') !== false || strpos($key, 'id') !== false) {
                        log_message('debug', "Found potential user key: $key = " . json_encode($value));
                    }
                }
            }
            
            if ($userId) {
                try {
                    $petugasModel = new PetugasModel();
                    $userData = $petugasModel->getPetugasById($userId);
                    
                    // Debug: Log user data
                    log_message('debug', 'User data from DB: ' . json_encode($userData));
                    
                    // Jika user tidak ditemukan di database, return USER
                    if (!$userData) {
                        return UserRole::USER;
                    }
                } catch (\Exception $e) {
                    // Debug: Log error
                    log_message('error', 'Error getting user data: ' . $e->getMessage());
                    // Jika ada error, return USER sebagai default
                    return UserRole::USER;
                }
            } else {
                // Jika tidak ada user ID, coba ambil dari Myth Auth user function
                if (function_exists('user')) {
                    try {
                        $mythUser = user();
                        if ($mythUser) {
                            $userData = $mythUser->toArray();
                            log_message('debug', 'User data from Myth Auth: ' . json_encode($userData));
                        } else {
                            return UserRole::USER;
                        }
                    } catch (\Exception $e) {
                        log_message('error', 'Error getting user from Myth Auth: ' . $e->getMessage());
                        return UserRole::USER;
                    }
                } else {
                    // Jika tidak ada user ID, return USER sebagai default
                    return UserRole::USER;
                }
            }
        }

        if (is_object($userData)) {
            $userData = $userData->toArray();
        }

        // Debug: Log user data
        log_message('debug', 'Processing user data: ' . json_encode($userData));
        
        // Cek user_role field terlebih dahulu
        if (isset($userData['user_role'])) {
            log_message('debug', 'Found user_role: ' . $userData['user_role']);
            switch ($userData['user_role']) {
                case 'super_admin':
                    return UserRole::SUPER_ADMIN;
                case 'admin':
                    return UserRole::ADMIN;
                case 'user':
                    return UserRole::USER;
            }
        }

        // Fallback ke is_superadmin untuk backward compatibility
        if (isset($userData['is_superadmin']) && $userData['is_superadmin'] == '1') {
            log_message('debug', 'Found is_superadmin: ' . $userData['is_superadmin']);
            return UserRole::SUPER_ADMIN;
        }

        // Jika ada di tabel users tapi bukan super admin, maka admin
        if (isset($userData['id']) && isset($userData['username'])) {
            log_message('debug', 'Found user in users table, defaulting to ADMIN');
            return UserRole::ADMIN;
        }
        
        // Cek apakah ada is_superadmin = 0 (admin biasa)
        if (isset($userData['is_superadmin']) && $userData['is_superadmin'] == '0') {
            log_message('debug', 'Found is_superadmin = 0, defaulting to ADMIN');
            return UserRole::ADMIN;
        }

        // Default adalah user
        log_message('debug', 'No role found, defaulting to USER');
        return UserRole::USER;
    }

    /**
     * Cek apakah user memiliki akses ke fitur tertentu
     */
    public static function hasAccess(UserRole $requiredRole, $userData = null): bool
    {
        $userRole = self::getUserRole($userData);

        switch ($requiredRole) {
            case UserRole::SUPER_ADMIN:
                return $userRole === UserRole::SUPER_ADMIN;
            
            case UserRole::ADMIN:
                return in_array($userRole, [UserRole::SUPER_ADMIN, UserRole::ADMIN]);
            
            case UserRole::USER:
                return in_array($userRole, [UserRole::SUPER_ADMIN, UserRole::ADMIN, UserRole::USER]);
            
            default:
                return false;
        }
    }

    /**
     * Cek apakah user bisa akses masterdata
     */
    public static function canAccessMasterData($userData = null): bool
    {
        $userRole = self::getUserRole($userData);
        return in_array($userRole, [UserRole::SUPER_ADMIN, UserRole::ADMIN]);
    }

    /**
     * Cek apakah user bisa akses data petugas (hanya super admin)
     */
    public static function canAccessPetugas($userData = null): bool
    {
        $userRole = self::getUserRole($userData);
        return $userRole === UserRole::SUPER_ADMIN;
    }

    /**
     * Cek apakah user bisa akses menu scan
     */
    public static function canAccessScan($userData = null): bool
    {
        $userRole = self::getUserRole($userData);
        return in_array($userRole, [UserRole::SUPER_ADMIN, UserRole::ADMIN, UserRole::USER]);
    }

    /**
     * Redirect user berdasarkan role mereka
     */
    public static function redirectBasedOnRole(): string
    {
        $userRole = self::getUserRole();
        
        switch ($userRole) {
            case UserRole::SUPER_ADMIN:
            case UserRole::ADMIN:
                return '/admin/dashboard';
            case UserRole::USER:
                return '/scan';
            default:
                return '/login';
        }
    }

    /**
     * Mendapatkan daftar menu yang bisa diakses berdasarkan role
     */
    public static function getAccessibleMenus($userData = null): array
    {
        $userRole = self::getUserRole($userData);
        $menus = [];

        switch ($userRole) {
            case UserRole::SUPER_ADMIN:
                $menus = [
                    'dashboard' => true,
                    'data_admin' => true,
                    'data_karyawan' => true,
                    'data_petugas' => true,
                    'data_departemen' => true,
                    'data_jabatan' => true,
                    'data_absen_admin' => true,
                    'data_absen_karyawan' => true,
                    'data_gaji' => true,
                    'data_inventory' => true,
                    'generate_qr' => true,
                    'generate_laporan' => true,
                    'approval_management' => true,
                    'general_settings' => true,
                    'scan' => true
                ];
                break;

            case UserRole::ADMIN:
                $menus = [
                    'dashboard' => true,
                    'data_admin' => true,
                    'data_karyawan' => true,
                    'data_departemen' => true,
                    'data_jabatan' => true,
                    'data_absen_admin' => true,
                    'data_absen_karyawan' => true,
                    'data_gaji' => true,
                    'data_inventory' => true,
                    'generate_qr' => true,
                    'generate_laporan' => true,
                    'scan' => true,
                    'data_petugas' => false, // Admin tidak bisa akses data petugas
                    'general_settings' => false // Admin tidak bisa akses general settings
                ];
                break;

            case UserRole::USER:
                $menus = [
                    'scan' => true,
                    'dashboard' => false,
                    'data_admin' => false,
                    'data_karyawan' => false,
                    'data_petugas' => false,
                    'data_departemen' => false,
                    'data_jabatan' => false,
                    'data_absen_admin' => false,
                    'data_absen_karyawan' => false,
                    'data_gaji' => false,
                    'data_inventory' => false,
                    'generate_qr' => false,
                    'generate_laporan' => false,
                    'general_settings' => false
                ];
                break;
        }

        return $menus;
    }
}
