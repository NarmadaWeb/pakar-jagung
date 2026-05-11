<?php

namespace App\Controllers;

use App\Models\GejalaModel;
use Config\Database;

class Deteksi extends BaseController
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Makassar');
    }

    private function requireLogin()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu untuk melakukan deteksi.');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        // Hapus session diagnosa sebelumnya agar bisa mulai baru
        session()->remove('diagnosa_hasil');

        $db = Database::connect();
        $data['daftar_gejala'] = $db->table('gejala')->orderBy('kategori', 'ASC')->orderBy('id_gejala', 'ASC')->get()->getResultArray();
        
        // Group by kategori for view
        $gejalaGrouped = [];
        foreach ($data['daftar_gejala'] as $g) {
            $kat = $g['kategori'] ?? 'Lainnya';
            if (!isset($gejalaGrouped[$kat])) {
                $gejalaGrouped[$kat] = [];
            }
            $gejalaGrouped[$kat][] = $g;
        }
        $data['gejala_grouped'] = $gejalaGrouped;
        
        // Debug: log symptom count
        log_message('debug', 'Total gejala: ' . count($data['daftar_gejala']));
        
        return view('deteksi/index', $data);
    }

    public function proses()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $gejalaDipilih = $this->request->getPost('gejala');
        $kepastian = $this->request->getPost('kepastian');
        
        if (empty($gejalaDipilih)) {
            return redirect()->to('deteksi')->with('error', 'Pilih setidaknya satu gejala!');
        }

        $db = Database::connect();
        $userId = session()->get('id');
        
        $semuaPenyakit = $db->table('penyakit')->get()->getResultArray();
        $semuaGejala = $db->table('gejala')->get()->getResultArray();
        $gejalaMap = [];
        foreach ($semuaGejala as $g) {
            $gejalaMap[$g['id_gejala']] = $g;
        }
        
        $hasil = [];
        
        foreach ($semuaPenyakit as $penyakit) {
            $rules = $db->table('basis_pengetahuan')
                ->where('id_penyakit', $penyakit['id_penyakit'])
                ->get()
                ->getResultArray();
            
            if (empty($rules)) {
                continue;
            }
            
            $gejalaCocok = [];
            $cfGejalaList = [];
            $cfCombine = 0;
            $detailPerhitungan = [];
            
            foreach ($rules as $rule) {
                $idGejalaRule = $rule['id_gejala'];
                
                if (in_array($idGejalaRule, $gejalaDipilih)) {
                    $cfPakar = (float) $rule['cf'];
                    $cfUser = isset($kepastian[$idGejalaRule]) ? (float) $kepastian[$idGejalaRule] : 0.6;
                    if ($cfUser == 0) $cfUser = 0.6;
                    
                    $cfGejala = $cfUser * $cfPakar;
                    
                    $g = $gejalaMap[$idGejalaRule] ?? ['kode_gejala' => 'G'.$idGejalaRule, 'nama_gejala' => ''];
                    
                    $gejalaCocok[] = $idGejalaRule;
                    $cfGejalaList[] = $cfGejala;
                    
                    $detailPerhitungan[] = [
                        'kode' => $g['kode_gejala'],
                        'nama' => $g['nama_gejala'],
                        'cf_user' => $cfUser,
                        'cf_pakar' => $cfPakar,
                        'cf_hasil' => $cfGejala
                    ];
                    
                    if (count($cfGejalaList) === 1) {
                        $cfCombine = $cfGejala;
                    } else {
                        $cfCombine = $cfCombine + $cfGejala * (1 - $cfCombine);
                    }
                }
            }
            
            $jumlahCocok = count($gejalaCocok);
            $totalGejalaRule = count($rules);
            
            if ($jumlahCocok === 0) {
                continue;
            }
            
            $persentase = round($cfCombine * 100, 2);
            
            $hasil[] = [
                'penyakit' => $penyakit,
                'gejala_cocok' => $gejalaCocok,
                'detail_perhitungan' => $detailPerhitungan,
                'total_gejala_rule' => $totalGejalaRule,
                'jumlah_cocok' => $jumlahCocok,
                'cf_combine' => $cfCombine,
                'persentase' => $persentase,
            ];
        }
        
        usort($hasil, function($a, $b) {
            return $b['persentase'] - $a['persentase'];
        });

        // Simpan selalu ke riwayat, bahkan jika 0%
        $penyakitTerbaik = $hasil[0] ?? ['penyakit' => ['nama_penyakit' => 'Tidak Ada Kecocokan', 'kode_penyakit' => '-', 'solusi' => ''], 'cf_combine' => 0, 'persentase' => 0];
        
        $detailGejalaJson = json_encode($detailPerhitungan);
        $gejalaDipilihJson = json_encode(array_map(function($id) use ($gejalaMap) {
            return [
                'id' => $id,
                'kode' => $gejalaMap[$id]['kode_gejala'] ?? 'G'.$id,
                'nama' => $gejalaMap[$id]['nama_gejala'] ?? '',
                'cf_user' => $kepastian[$id] ?? 0.6
            ];
        }, $gejalaDipilih));
        
        $insertData = [
            'id_user' => $userId,
            'id_penyakit' => $penyakitTerbaik['penyakit']['id_penyakit'] ?? null,
            'nama_penyakit' => $penyakitTerbaik['penyakit']['nama_penyakit'] ?? 'Tidak Diketahui',
            'kode_penyakit' => $penyakitTerbaik['penyakit']['kode_penyakit'] ?? '-',
            'gejala_dipilih' => $gejalaDipilihJson,
            'detail_gejala' => $detailGejalaJson,
            'cf_hasil' => $penyakitTerbaik['cf_combine'] ?? 0,
            'persentase' => $penyakitTerbaik['persentase'] ?? 0,
            'solusi' => $penyakitTerbaik['penyakit']['solusi'] ?? '',
            'tanggal_diagnosa' => date('Y-m-d H:i:s'),
        ];
        
        // DON'T auto-save - wait for user confirmation
        log_message('info', 'UserID: ' . $userId . ' - Menunggu konfirmasi simpan');
        
        $data['hasil'] = $hasil;
        $data['gejalaDipilih'] = $gejalaDipilih;
        $data['insertData'] = $insertData;
        
        // Simpan ke session untuk akses via GET
        session()->set('diagnosa_hasil', $data);
        
        return redirect()->to('deteksi/hasil');
    }

    public function simpanRiwayat()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }
        
        $data = session()->get('diagnosa_hasil');
        if (empty($data) || empty($data['insertData'])) {
            return redirect()->to('deteksi');
        }
        
        $db = Database::connect();
        $insertData = $data['insertData'];
        
        $builder = $db->table('riwayat_diagnosa');
        $result = $builder->insert($insertData);
        log_message('info', 'Simpan riwayat result: ' . ($result ? 'berhasil' : 'gagal'));
        
        return redirect()->to('riwayat?sukses=3');
    }

    public function Batal()
    {
        session()->remove('diagnosa_hasil');
        return redirect()->to('deteksi');
    }

    public function hasil()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }
        
        // Ambil dari session
        $data = session()->get('diagnosa_hasil');
        
        if (empty($data)) {
            return redirect()->to('deteksi')->with('error', 'Data diagnosa tidak ditemukan. Silakan lakukan deteksi ulang.');
        }
        
        // Refresh data penyakit dari database agar dapat gambar terbaru
        $db = Database::connect();
        $semuaPenyakit = $db->table('penyakit')->get()->getResultArray();
        $penyakitMap = [];
        foreach ($semuaPenyakit as $p) {
            $penyakitMap[$p['id_penyakit']] = $p;
        }
        
        // Update hasil dengan data penyakit terbaru
        if (!empty($data['hasil'])) {
            foreach ($data['hasil'] as $key => $h) {
                if (isset($h['penyakit']['id_penyakit']) && isset($penyakitMap[$h['penyakit']['id_penyakit']])) {
                    $data['hasil'][$key]['penyakit'] = $penyakitMap[$h['penyakit']['id_penyakit']];
                }
            }
            // Update juga insertData
            if (!empty($data['insertData']['id_penyakit'])) {
                $data['insertData']['penyakit'] = $penyakitMap[$data['insertData']['id_penyakit']] ?? [];
            }
        }
        
        // DEBUG: Log what's being sent to view
        log_message('debug', 'Gambar untuk hasil[0]: ' . ($data['hasil'][0]['penyakit']['gambar'] ?? 'KOSONG'));
        
        return view('deteksi/hasil', $data);
    }

    public function upload()
    {
        if ($redirect = $this->requireLogin()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ]);
        }

        $file = $this->request->getFile('foto');
        
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak ada foto yang diupload'
            ]);
        }

        // Validasi
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Format foto harus JPG, PNG, atau WEBP'
            ]);
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Ukuran foto maksimal 5MB'
            ]);
        }

        // Simpan foto
        $newName = $file->getRandomName();
        $file->move('uploads/deteksi', $newName);

        // Analisis sederhana berdasarkan nama file (simulasi AI)
        // Untuk implementasi nyata, perlu integrasi dengan model ML
        $db = Database::connect();
        
        // Ambil semua penyakit untuk analisis
        $semuaPenyakit = $db->table('penyakit')->get()->getResultArray();
        
        // Analisis dummy - dalam implementasi nyata, ini akan diganti dengan inference model ML
        // Untuk sekarang, kita tampilkan pesan bahwa foto sudah diterima
        // dan arahkan user untuk memilih gejala juga
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Foto berhasil diupload. Untuk analisis penyakit, silakan pilih gejala yang terlihat pada daun.',
            'foto' => base_url('uploads/deteksi/' . $newName)
        ]);
    }
}
