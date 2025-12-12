<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use Myth\Auth\Config\Auth as AuthConfig;

class LoginAbsen extends BaseController
{
    protected $auth;
    protected $config;
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->config = config('Auth');
        $this->auth = service('authentication');
    }

    /**
     * Menampilkan halaman login khusus untuk absen
     */
    public function index()
    {
        // Jika sudah login, redirect ke halaman scan
        if ($this->auth->check()) {
            return redirect()->to('/scan');
        }

        $data = [
            'title' => 'Login Absen',
            'config' => $this->config,
        ];

        return view('scan/login_absen', $data);
    }

    /**
     * Proses login untuk absen
     */
    public function attemptLogin(): RedirectResponse
    {
        $rules = [
            'login'    => 'required',
            'password' => 'required',
        ];
        if ($this->config->validFields === ['email']) {
            $rules['login'] .= '|valid_email';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $remember = (bool) $this->request->getPost('remember');

        // Coba login
        $attempt = $this->auth->attempt([
            'email'    => $login,
            'password' => $password,
        ], $remember);

        if (!$attempt) {
            // Coba dengan username jika email gagal
            $attempt = $this->auth->attempt([
                'username' => $login,
                'password' => $password,
            ], $remember);
        }

        if (!$attempt) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->auth->error() ?? lang('Auth.badAttempt'));
        }

        // Set session logged_in
        $this->session->set('logged_in', true);

        // Redirect ke halaman scan setelah login berhasil
        return redirect()->to('/scan')->with('message', lang('Auth.loginSuccess'));
    }

    /**
     * Logout dari absen
     */
    public function logout(): RedirectResponse
    {
        if ($this->auth->check()) {
            $this->auth->logout();
        }

        $this->session->remove('logged_in');
        // Jangan destroy session karena mungkin ada flash message

        return redirect()->to('/scan/login')->with('message', lang('Auth.logoutSuccess'));
    }
}

