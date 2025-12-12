<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
     public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // cek kalau belum login
        if (!$session->get('logged_in')) {
            // kalau akses ke admin tanpa login, lempar ke /login
            return redirect()->to('/login');
        }

        // kalau sudah login, lanjut
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $session = session();
        $path = $request->getUri()->getPath();

        // Jika sudah login tapi buka login lagi, arahkan ke dashboard
        if ($session->get('isLoggedIn') && ($path === 'login' || str_starts_with($path, 'login/'))) {
            return redirect()->to('/admin/dashboard');
        }
    }
}
