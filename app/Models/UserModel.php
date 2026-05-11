<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'email', 'password', 'nama_lengkap', 'role', 'created_at', 'updated_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function verifyPassword($password, $user)
    {
        return password_verify($password, $user['password']);
    }

    public function isAdmin($user)
    {
        return $user['role'] === 'admin';
    }

    public function isPengguna($user)
    {
        return $user['role'] === 'pengguna';
    }
}
