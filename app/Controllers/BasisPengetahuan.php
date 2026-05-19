<?php

namespace App\Controllers;

use App\Models\PenyakitModel;
use App\Models\GejalaModel;
use Config\Database;

class BasisPengetahuan extends BaseController
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
        $db = Database::connect();
        
        $data['title'] = 'Basis Pengetahuan';
        
        $data['rules'] = $db->table('basis_pengetahuan bp')
            ->select('bp.*, p.nama_penyakit, p.kode_penyakit, g.nama_gejala, g.kode_gejala')
            ->join('penyakit p', 'p.id_penyakit = bp.id_penyakit')
            ->join('gejala g', 'g.id_gejala = bp.id_gejala')
            ->get()
            ->getResultArray();
        
        return view('basis_pengetahuan/index', $data);
    }

    public function add()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $db = Database::connect();
        $data['title'] = 'Tambah Aturan';
        
        $data['penyakit'] = $db->table('penyakit')->get()->getResultArray();
        $data['gejala'] = $db->table('gejala')->get()->getResultArray();
        
        if ($this->request->getMethod() === 'POST') {
            $db->table('basis_pengetahuan')->insert([
                'id_penyakit' => $this->request->getPost('id_penyakit'),
                'id_gejala' => $this->request->getPost('id_gejala'),
                'cf' => $this->request->getPost('cf') ?: 0.50,
            ]);
            
            return redirect()->to('basis-pengetahuan')->with('success', 'Aturan berhasil ditambahkan!');
        }
        
        return view('basis_pengetahuan/form', $data);
    }

    public function delete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        $db->table('basis_pengetahuan')->delete(['id' => $id]);
        
        return redirect()->to('basis-pengetahuan')->with('success', 'Aturan berhasil dihapus!');
    }

    public function edit($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        $data['title'] = 'Edit Aturan';
        
        $data['penyakit'] = $db->table('penyakit')->get()->getResultArray();
        $data['gejala'] = $db->table('gejala')->get()->getResultArray();
        $data['rule'] = $db->table('basis_pengetahuan')->where('id', $id)->get()->getRowArray();
        
        if (!$data['rule']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Aturan tidak ditemukan');
        }
        
        if ($this->request->getMethod() === 'POST') {
            $db->table('basis_pengetahuan')->where('id', $id)->update([
                'id_penyakit' => $this->request->getPost('id_penyakit'),
                'id_gejala' => $this->request->getPost('id_gejala'),
                'cf' => $this->request->getPost('cf') ?: 0.50,
            ]);
            
            return redirect()->to('basis-pengetahuan')->with('success', 'Aturan berhasil diupdate!');
        }
        
        return view('basis_pengetahuan/form', $data);
    }
}
