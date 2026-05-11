<?php

namespace App\Controllers;

use App\Models\GejalaModel;

class Gejala extends BaseController
{
    private function requireAdmin()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses fitur ini.');
        }
        return null;
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $data['gejala'] = $db->table('gejala')->orderBy('id_gejala', 'ASC')->get()->getResultArray();
        $data['title'] = 'Katalog Gejala';
        
        return view('gejala/index', $data);
    }

    public function add()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data['title'] = 'Tambah Gejala';
        
        if ($this->request->getMethod() === 'POST') {
            $gejalaModel = new GejalaModel();
            $gejalaModel->save([
                'kode_gejala' => $this->request->getPost('kode_gejala'),
                'nama_gejala' => $this->request->getPost('nama_gejala'),
                'kategori' => $this->request->getPost('kategori'),
            ]);
            
            return redirect()->to('gejala')->with('success', 'Gejala berhasil ditambahkan!');
        }
        
        return view('gejala/form', $data);
    }

    public function edit($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $gejalaModel = new GejalaModel();
        $data['title'] = 'Edit Gejala';
        $data['gejala'] = $gejalaModel->find($id);
        
        if (!$data['gejala']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Gejala tidak ditemukan');
        }
        
        if ($this->request->getMethod() === 'POST') {
            $gejalaModel->update($id, [
                'kode_gejala' => $this->request->getPost('kode_gejala'),
                'nama_gejala' => $this->request->getPost('nama_gejala'),
                'kategori' => $this->request->getPost('kategori'),
            ]);
            
            return redirect()->to('gejala')->with('success', 'Gejala berhasil diupdate!');
        }
        
        return view('gejala/form', $data);
    }

    public function delete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        
        try {
            // Hapus dulu data di basis_pengetahuan
            $db->table('basis_pengetahuan')->where('id_gejala', $id)->delete();
            // Baru hapus gejala
            $gejalaModel = new GejalaModel();
            $gejalaModel->delete($id);
            
            return redirect()->to('gejala')->with('success', 'Gejala berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->to('gejala')->with('error', 'Gagal menghapus gejala: ' . $e->getMessage());
        }
    }
}
