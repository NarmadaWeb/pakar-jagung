<?php

namespace App\Controllers;

use App\Models\UserModel;
use Config\Database;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            if (session()->get('role') === 'admin') {
                return redirect()->to('/admin');
            }
            return redirect()->to('/dashboard');
        }

        $data['title'] = 'Login';
        
        $currentUri = service('uri')->getPath();
        if (strpos($currentUri, 'admin') !== false) {
            return redirect()->to('login-admin');
        }
        
        return view('auth/login', $data);
    }

    public function loginAdmin()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $data['title'] = 'Login Admin';
        return view('auth/login-admin', $data);
    }

    public function loginPengguna()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data['title'] = 'Login Pengguna';
        return view('auth/login-pengguna', $data);
    }

    public function prosesLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->getUserByUsername($username);

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan');
        }

        if (!$userModel->verifyPassword($password, $user)) {
            return redirect()->back()->with('error', 'Password salah');
        }

        // Block admin users from user login page - show same error message as invalid credentials
        if ($user['role'] === 'admin') {
            return redirect()->back()->with('error', 'Username tidak ditemukan');
        }

        session()->set([
            'id'         => $user['id'],
            'username'   => $user['username'],
            'nama_lengkap' => $user['nama_lengkap'],
            'role'       => $user['role'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/dashboard')->with('success', 'Selamat datang, ' . $user['nama_lengkap']);
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

    public function register()
    {
        $data['title'] = 'Registrasi Pengguna';
        return view('auth/register', $data);
    }

    public function prosesRegister()
    {
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        $namaLengkap = $this->request->getPost('nama_lengkap');

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok');
        }

        if ($userModel->getUserByUsername($username)) {
            return redirect()->back()->with('error', 'Username sudah digunakan');
        }

        if ($userModel->getUserByEmail($email)) {
            return redirect()->back()->with('error', 'Email sudah digunakan');
        }

        $userModel->save([
            'username'     => $username,
            'email'        => $email,
            'password'     => $password,
            'nama_lengkap' => $namaLengkap,
            'role'         => 'pengguna',
        ]);

        return redirect()->to('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function lupaPassword()
    {
        $data['title'] = 'Lupa Password';
        return view('auth/lupa-password', $data);
    }

    public function kirimResetPassword()
    {
        $email = $this->request->getPost('email');
        
        $db = Database::connect();
        $user = $db->table('users')->where('email', $email)->get()->getRowArray();
        
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan!');
        }
        
        $token = bin2hex(random_bytes(32));
        $db->table('users')->where('id', $user['id'])->update([
            'reset_token' => $token,
            'reset_expires' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);
        
        // Redirect langsung ke halaman reset password
        return redirect()->to('reset-password/' . $token);
    }

    public function resetPassword($token = null)
    {
        if (!$token) {
            return redirect()->to('login');
        }
        
        $db = Database::connect();
        $user = $db->table('users')->where('reset_token', $token)
            ->where('reset_expires >', date('Y-m-d H:i:s'))
            ->get()->getRowArray();
        
        if (!$user) {
            return redirect()->to('login')->with('error', 'Link reset tidak valid atau expired!');
        }
        
        $data['title'] = 'Reset Password';
        $data['token'] = $token;
        $data['user'] = $user;
        return view('auth/reset-password', $data);
    }

    public function prosesResetPassword()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        
        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok!');
        }
        
        $db = Database::connect();
        $user = $db->table('users')->where('reset_token', $token)->get()->getRowArray();
        
        if (!$user) {
            return redirect()->to('login')->with('error', 'Token tidak valid!');
        }
        
        // Update password using UserModel (will hash automatically)
        $userModel = new UserModel();
        $userModel->update($user['id'], [
            'password' => $password,
            'reset_token' => null,
            'reset_expires' => null
        ]);
        
        return redirect()->to('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}