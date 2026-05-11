<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $users = [
            [
                'username'     => 'admin',
                'email'        => 'admin@cornai.com',
                'password'     => 'admin123',
                'nama_lengkap' => 'Administrator',
                'role'         => 'admin',
            ],
            [
                'username'     => 'petani',
                'email'        => 'petani@example.com',
                'password'     => 'petani123',
                'nama_lengkap' => 'Budi Santoso',
                'role'         => 'pengguna',
            ],
        ];

        foreach ($users as $user) {
            $existingUser = $userModel->getUserByUsername($user['username']);
            if (!$existingUser) {
                $userModel->save($user);
            }
        }
    }
}
