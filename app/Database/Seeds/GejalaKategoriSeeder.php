<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GejalaKategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Daun (14 gejala)
            ['id_gejala' => 4, 'kategori' => 'Daun'],
            ['id_gejala' => 6, 'kategori' => 'Daun'],
            ['id_gejala' => 7, 'kategori' => 'Daun'],
            ['id_gejala' => 8, 'kategori' => 'Daun'],
            ['id_gejala' => 12, 'kategori' => 'Daun'],
            ['id_gejala' => 16, 'kategori' => 'Daun'],
            ['id_gejala' => 17, 'kategori' => 'Daun'],
            ['id_gejala' => 18, 'kategori' => 'Daun'],
            ['id_gejala' => 19, 'kategori' => 'Daun'],
            ['id_gejala' => 20, 'kategori' => 'Daun'],
            ['id_gejala' => 21, 'kategori' => 'Daun'],
            ['id_gejala' => 22, 'kategori' => 'Daun'],
            ['id_gejala' => 24, 'kategori' => 'Daun'],
            ['id_gejala' => 28, 'kategori' => 'Daun'],
            // Batang (9 gejala)
            ['id_gejala' => 13, 'kategori' => 'Batang'],
            ['id_gejala' => 14, 'kategori' => 'Batang'],
            ['id_gejala' => 15, 'kategori' => 'Batang'],
            ['id_gejala' => 25, 'kategori' => 'Batang'],
            ['id_gejala' => 26, 'kategori' => 'Batang'],
            ['id_gejala' => 27, 'kategori' => 'Batang'],
            ['id_gejala' => 29, 'kategori' => 'Batang'],
            ['id_gejala' => 32, 'kategori' => 'Batang'],
            ['id_gejala' => 33, 'kategori' => 'Batang'],
            // Tongkol (5 gejala)
            ['id_gejala' => 3, 'kategori' => 'Tongkol'],
            ['id_gejala' => 30, 'kategori' => 'Tongkol'],
            ['id_gejala' => 34, 'kategori' => 'Tongkol'],
            ['id_gejala' => 35, 'kategori' => 'Tongkol'],
            ['id_gejala' => 36, 'kategori' => 'Tongkol'],
            // Biji (3 gejala)
            ['id_gejala' => 9, 'kategori' => 'Biji'],
            ['id_gejala' => 10, 'kategori' => 'Biji'],
            ['id_gejala' => 11, 'kategori' => 'Biji'],
            // Umum (5 gejala)
            ['id_gejala' => 1, 'kategori' => 'Umum'],
            ['id_gejala' => 2, 'kategori' => 'Umum'],
            ['id_gejala' => 5, 'kategori' => 'Umum'],
            ['id_gejala' => 23, 'kategori' => 'Umum'],
            ['id_gejala' => 31, 'kategori' => 'Umum'],
        ];

        $db = \Config\Database::connect();
        foreach ($data as $row) {
            $db->table('gejala')->update(['kategori' => $row['kategori']], ['id_gejala' => $row['id_gejala']]);
        }
    }
}