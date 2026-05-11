<?php

namespace App\Controllers;

use App\Models\PenyakitModel;

class Penyakit extends BaseController
{
    protected PenyakitModel $penyakitModel;

    public function __construct()
    {
        $this->penyakitModel = new PenyakitModel();
    }

    private function requireAdmin()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses fitur ini.');
        }
        return null;
    }

    public function index()
    {
        $data = [
            'title'    => 'Katalog Penyakit Jagung',
            'penyakit' => $this->penyakitModel->getAllWithGejalaCount(),
        ];

        return view('penyakit/index', $data);
    }

    public function detail(int $id)
    {
        $detail = $this->penyakitModel->getDetailWithGejala($id);

        if (!$detail) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Penyakit dengan ID $id tidak ditemukan.");
        }

        $data = [
            'title'   => $detail['penyakit']['nama_penyakit'] ?? 'Detail Penyakit',
            'detail'  => $detail,
        ];

        return view('penyakit/detail', $data);
    }

    public function add()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data['title'] = 'Tambah Penyakit';
        
        if ($this->request->getMethod() === 'POST') {
            $kode = $this->request->getPost('kode_penyakit');
            $nama = $this->request->getPost('nama_penyakit');
            $solusi = $this->request->getPost('solusi');
            $tindakan_segera = $this->request->getPost('tindakan_segera');
            $protokol_pengobatan = $this->request->getPost('protokol_pengobatan');
            $strategi_pencegahan = $this->request->getPost('strategi_pencegahan');
            $gambarUrl = $this->request->getPost('gambar_url');
            
            $gambar = '';
            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/penyakit', $newName);
                $gambar = 'uploads/penyakit/' . $newName;
            } elseif (!empty($gambarUrl)) {
                $gambar = $gambarUrl;
            }
            
            $db = \Config\Database::connect();
            $db->table('penyakit')->insert([
                'kode_penyakit' => $kode,
                'nama_penyakit' => $nama,
                'solusi' => $solusi,
                'tindakan_segera' => $tindakan_segera,
                'protokol_pengobatan' => $protokol_pengobatan,
                'strategi_pencegahan' => $strategi_pencegahan,
                'gambar' => $gambar,
            ]);
            
            return redirect()->to(base_url('/penyakit'))->with('success', 'Penyakit berhasil ditambahkan!');
        }
        
        return view('penyakit/form', $data);
    }

    public function edit($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $penyakit = $this->penyakitModel->find($id);
        $data['title'] = 'Edit Penyakit';
        $data['penyakit'] = $penyakit;
        
        if (!$penyakit) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Penyakit tidak ditemukan');
        }
        
        if ($this->request->getMethod() === 'POST') {
            $updateData = [
                'kode_penyakit' => $this->request->getPost('kode_penyakit'),
                'nama_penyakit' => $this->request->getPost('nama_penyakit'),
                'solusi' => $this->request->getPost('solusi'),
                'tindakan_segera' => $this->request->getPost('tindakan_segera'),
                'protokol_pengobatan' => $this->request->getPost('protokol_pengobatan'),
                'strategi_pencegahan' => $this->request->getPost('strategi_pencegahan'),
            ];
            
            $gambarUrl = $this->request->getPost('gambar_url');
            $file = $this->request->getFile('gambar');
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                if (!empty($penyakit['gambar']) && file_exists($penyakit['gambar']) && strpos($penyakit['gambar'], 'uploads/') === 0) {
                    unlink($penyakit['gambar']);
                }
                $newName = $file->getRandomName();
                $file->move('uploads/penyakit', $newName);
                $updateData['gambar'] = 'uploads/penyakit/' . $newName;
            } elseif (!empty($gambarUrl)) {
                $updateData['gambar'] = $gambarUrl;
            }
            
            $this->penyakitModel->update($id, $updateData);
            
            return redirect()->to('penyakit')->with('success', 'Penyakit berhasil diupdate!');
        }
        
        return view('penyakit/form', $data);
    }

    public function delete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        
        try {
            // Hapus dulu data di basis_pengetahuan
            $db->table('basis_pengetahuan')->where('id_penyakit', $id)->delete();
            // Baru hapus penyakit
            $this->penyakitModel->delete($id);
            
            return redirect()->to('penyakit')->with('success', 'Penyakit berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->to('penyakit')->with('error', 'Gagal menghapus penyakit: ' . $e->getMessage());
        }
    }

    public function updateGambar()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $gambarData = [
            1 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Locusta_migratoria_migratorioides.jpg/320px-Locusta_migratoria_migratorioides.jpg',
            2 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Northern_corn_leaf_blight.jpg/320px-Northern_corn_leaf_blight.jpg',
            3 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b3/Downy_mildew_on_corn.jpg/320px-Downy_mildew_on_corn.jpg',
            4 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/Corn_stalk_rot.jpg/320px-Corn_stalk_rot.jpg',
            5 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Corn_smut_2.jpg/320px-Corn_smut_2.jpg',
            6 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Northern_corn_leaf_blight.jpg/320px-Northern_corn_leaf_blight.jpg',
            7 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e3/Puccinia_polysora_USDA.jpg/320px-Puccinia_polysora_USDA.jpg',
            8 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a8/Atherigona_soccata.jpg/320px-Atherigona_soccata.jpg',
            9 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/Maize_dwarf_mosaic_virus.jpg/320px-Maize_dwarf_mosaic_virus.jpg',
            10 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/Ostrinia_furnacalis.jpg/320px-Ostrinia_furnacalis.jpg',
            11 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Helicoverpa_armigera.jpg/320px-Helicoverpa_armigera.jpg',
            12 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Spodoptera_frugiperda_caterpillar.jpg/320px-Spodoptera_frugiperda_caterpillar.jpg',
            13 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0b/Agrotis_ipsilon_larva.jpg/320px-Agrotis_ipsilon_larva.jpg',
        ];

        $db = \Config\Database::connect();
        $updated = 0;

        foreach ($gambarData as $id => $url) {
            $db->table('penyakit')->where('id_penyakit', $id)->update(['gambar' => $url]);
            $updated++;
        }

        return redirect()->to('penyakit')->with('success', "Berhasil update $updated gambar penyakit!");
    }
}
