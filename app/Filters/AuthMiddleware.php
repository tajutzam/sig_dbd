<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;


class AuthMiddleware implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        // Periksa apakah pengguna sudah login
        if (!session()->get('isLoggedIn')) {
            // Jika belum login, redirect ke halaman login
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan apa-apa setelah request
    }
}
