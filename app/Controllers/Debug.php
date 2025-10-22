<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\RoleHelper;

class Debug extends BaseController
{
    public function session()
    {
        $session = \Config\Services::session();
        
        // Ambil semua data session
        $sessionData = [
            'logged_in' => $session->get('logged_in'),
            'user_id' => $session->get('user_id'),
            'is_superadmin' => $session->get('is_superadmin'),
            'user_role' => $session->get('user_role'),
            'username' => $session->get('username'),
            'email' => $session->get('email'),
            'all_session' => $session->get()
        ];
        
        // Cek role helper
        $roleHelper = new RoleHelper();
        $userRole = $roleHelper->getUserRole();
        
        echo "<h2>Session Debug</h2>";
        echo "<pre>";
        print_r($sessionData);
        echo "</pre>";
        
        echo "<h2>Role Helper Debug</h2>";
        echo "<p>User Role: " . $userRole->value . "</p>";
        
        // Cek apakah ada data user di database
        if ($session->get('user_id')) {
            $petugasModel = new \App\Models\PetugasModel();
            $userData = $petugasModel->getPetugasById($session->get('user_id'));
            
            echo "<h2>User Data from Database</h2>";
            echo "<pre>";
            print_r($userData);
            echo "</pre>";
        }
        
        // Cek Myth Auth user function
        if (function_exists('user')) {
            try {
                $mythUser = user();
                echo "<h2>Myth Auth User Function</h2>";
                echo "<pre>";
                print_r($mythUser ? $mythUser->toArray() : 'null');
                echo "</pre>";
            } catch (\Exception $e) {
                echo "<h2>Myth Auth User Function Error</h2>";
                echo "<p>Error: " . $e->getMessage() . "</p>";
            }
        }
    }
}