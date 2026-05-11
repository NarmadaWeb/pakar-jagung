<?php

namespace App\Controllers;

use App\Models\UserModel;
use Config\Database;

class Auth extends BaseController
{
    public function loginAdmin()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $data['title'] = 'Login Admin';
        return view('auth/login-admin', $data);
    }

    public function prosesLoginAdmin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->getUserByUsername($username);

        if (!$user) {
            return redirect()->to('login-admin')->with('error', 'Username tidak ditemukan');
        }

        if (!$userModel->verifyPassword($password, $user)) {
            return redirect()->to('login-admin')->with('error', 'Password salah');
        }

        if ($user['role'] !== 'admin') {
            return redirect()->to('login-admin')->with('error', 'Anda bukan admin!');
        }

        session()->set([
            'id'         => $user['id'],
            'username'   => $user['username'],
            'nama_lengkap' => $user['nama_lengkap'],
            'role'       => $user['role'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/admin')->with('success', 'Selamat datang, ' . $user['nama_lengkap']);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}