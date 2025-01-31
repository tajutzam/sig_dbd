<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function index()
    {
        //
    }

    public function login()
    {
        return view('pages/auth/login');
    }

    public function loginAttempt()
    {
        $session = session();
        $userModel = new User();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id'       => $user['id'],
                    'username' => $user['username'],
                    'role'     => $user['role'],
                    'isLoggedIn' => true
                ];
                $session->set($sessionData);
                return redirect()->to('/admin')->with('success', 'Berhasil login!');
            } else {
                return redirect()->back()->with('error', 'Password salah!');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan!');
        }
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'berhasil logout!');
    }
}
