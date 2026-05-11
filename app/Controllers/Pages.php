<?php

namespace App\Controllers;

use Config\Database;

class Pages extends BaseController
{
    public function katalog()
    {
        $db = Database::connect();
        
        $data['penyakit'] = $db->table('penyakit')->orderBy('id_penyakit', 'ASC')->get()->getResultArray();
        $data['gejala'] = $db->table('gejala')->orderBy('id_gejala', 'ASC')->get()->getResultArray();
        $data['rules'] = $db->table('basis_pengetahuan bp')
            ->select('bp.*, p.nama_penyakit, p.kode_penyakit, g.nama_gejala, g.kode_gejala')
            ->join('penyakit p', 'p.id_penyakit = bp.id_penyakit')
            ->join('gejala g', 'g.id_gejala = bp.id_gejala')
            ->orderBy('bp.id_rule', 'ASC')
            ->get()
            ->getResultArray();
        
        return view('katalog/index', $data);
    }

    public function library()
    {
        $db = Database::connect();
        
        $data['penyakit'] = $db->table('penyakit')
            ->orderBy('id_penyakit', 'ASC')
            ->get()
            ->getResultArray();
        
        $data['gejala'] = $db->table('gejala')
            ->orderBy('id_gejala', 'ASC')
            ->get()
            ->getResultArray();
        
        $rules = $db->table('basis_pengetahuan bp')
            ->select('bp.*, p.nama_penyakit, p.kode_penyakit, p.solusi, g.nama_gejala, g.kode_gejala')
            ->join('penyakit p', 'p.id_penyakit = bp.id_penyakit')
            ->join('gejala g', 'g.id_gejala = bp.id_gejala')
            ->orderBy('p.id_penyakit', 'ASC')
            ->orderBy('g.id_gejala', 'ASC')
            ->get()
            ->getResultArray();
        
        // Debug: cek jumlah rules per penyakit
        $debug = [];
        foreach ($rules as $r) {
            $debug[$r['id_penyakit']] = ($debug[$r['id_penyakit']] ?? 0) + 1;
        }
        log_message('info', 'Rules per penyakit: ' . json_encode($debug));
        
        $data['rules'] = $rules;
        
        return view('static/library', $data);
    }

    public function tentang()
    {
        return view('static/tentang');
    }

    public function riwayat()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $db = Database::connect();
        $userId = session()->get('id');
        
        // DEBUG: Langsung tampilkan semua data tanpa filter
        $semua = $db->table('riwayat_diagnosa')
            ->orderBy('tanggal_diagnosa', 'DESC')
            ->get()
            ->getResultArray();
        
        // Filter manual berdasarkan userId
        $filtered = [];
        foreach ($semua as $r) {
            if ($r['id_user'] == $userId) {
                $filtered[] = $r;
            }
        }
        
        $data['riwayat'] = $filtered;
        
        // Debug log
        log_message('info', 'Session ID: ' . $userId . ', Total data: ' . count($semua) . ', Matched: ' . count($filtered));
        
return view('pengguna/riwayat', $data);
    }
    
    public function riwayatDetail($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $db = Database::connect();
        $userId = session()->get('id');
        
        $riwayat = $db->table('riwayat_diagnosa')
            ->where('id_riwayat', $id)
            ->where('id_user', $userId)
            ->get()
            ->getRowArray();
        
        if (!$riwayat) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Riwayat tidak ditemukan");
        }
        
        // Get penyakit info
        $penyakit = $db->table('penyakit')
            ->where('id_penyakit', $riwayat['id_penyakit'] ?? 0)
            ->get()
            ->getRowArray();
        
        $riwayat['nama_penyakit'] = $penyakit['nama_penyakit'] ?? $riwayat['hasil_diagnosa'] ?? '-';
        $riwayat['kode_penyakit'] = $penyakit['kode_penyakit'] ?? '-';
        $riwayat['gambar_penyakit'] = $penyakit['gambar'] ?? '';
        $riwayat['solusi_penyakit'] = $penyakit['solusi'] ?? ($riwayat['solusi'] ?? '');
        $riwayat['detail_gejala'] = $riwayat['detail_gejala'] ?? '';
        
        // Calculate CF percentage
        $cf = floatval($riwayat['persentase'] ?? $riwayat['cf'] ?? 0);
        if ($cf >= 70) {
            $riwayat['status'] = 'Sembuh';
        } elseif ($cf >= 50) {
            $riwayat['status'] = 'Dalam Perawatan';
        } elseif ($cf > 0) {
            $riwayat['status'] = 'Perlu Perhatian';
        } else {
            $riwayat['status'] = '-';
        }
        $riwayat['cf_percentage'] = $cf;
        
        $data['riwayat'] = $riwayat;
        $data['title'] = 'Detail Riwayat Diagnosa';
        
        // Get gejala selected if any (from JSON in gejala_dipilih)
        $gejalaDipilih = [];
        if (!empty($riwayat['gejala_dipilih'])) {
            $gejalaJson = json_decode($riwayat['gejala_dipilih'], true);
            if ($gejalaJson) {
                foreach ($gejalaJson as $g) {
                    $gejala = $db->table('gejala')->where('id_gejala', $g['id_gejala'] ?? 0)->get()->getRowArray();
                    $gejalaDipilih[] = [
                        'kode' => $gejala['kode_gejala'] ?? '-',
                        'nama' => $gejala['nama_gejala'] ?? '-',
                        'cf_user' => $g['cf'] ?? 0
                    ];
                }
            }
        }
        
        $data['gejalaDipilih'] = $gejalaDipilih;
        
        // Get detail gejala
        $detailGejala = [];
        if (!empty($riwayat['detail_gejala'])) {
            $detailGejala = json_decode($riwayat['detail_gejala'], true) ?? [];
        }
        $data['detailGejala'] = $detailGejala;
        $data['cf_hasil'] = floatval($riwayat['cf_hasil'] ?? $riwayat['cf_percentage'] ?? 0);
        
        return view('pengguna/detail', $data);
    }
    
    public function hapusRiwayat($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $db = Database::connect();
        $userId = session()->get('id');
        
        $riwayat = $db->table('riwayat_diagnosa')
            ->where('id_riwayat', $id)
            ->where('id_user', $userId)
            ->get()
            ->getRowArray();
        
        if ($riwayat) {
            $db->table('riwayat_diagnosa')->delete(['id_riwayat' => $id]);
            return redirect()->to('riwayat?sukses=1');
        }
        
        return redirect()->to('riwayat');
    }

    public function hapusSemuaRiwayat()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $db = Database::connect();
        $userId = session()->get('id');
        
        $db->table('riwayat_diagnosa')->delete(['id_user' => $userId]);
        
        return redirect()->to('riwayat?sukses=2');
    }

    public function hapusAdminRiwayat($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('login-admin');
        }

        $db = Database::connect();
        $db->table('riwayat_diagnosa')->delete(['id_riwayat' => $id]);
        
        return redirect()->to('admin/riwayat?sukses=1');
    }

    public function hapusSemuaAdminRiwayat()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('login-admin');
        }

        $db = Database::connect();
        $db->table('riwayat_diagnosa')->emptyTable();
        
        return redirect()->to('admin/riwayat?sukses=2');
    }

    public function cetakRiwayat($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $db = Database::connect();
        $userId = session()->get('id');
        
        $riwayat = $db->table('riwayat_diagnosa')
            ->where('id_riwayat', $id)
            ->where('id_user', $userId)
            ->get()
            ->getRowArray();
        
        if (!$riwayat) {
            return redirect()->to('riwayat');
        }

        $detailGejala = !empty($riwayat['detail_gejala']) ? json_decode($riwayat['detail_gejala'], true) : [];
        $gejalaDipilih = !empty($riwayat['gejala_dipilih']) ? json_decode($riwayat['gejala_dipilih'], true) : [];

        $data['riwayat'] = $riwayat;
        $data['detailGejala'] = $detailGejala;
        $data['gejalaDipilih'] = $gejalaDipilih;

        return view('pengguna/cetak', $data);
    }

    public function kontak()
    {
        return view('static/kontak');
    }

    public function faq()
    {
        return view('static/faq');
    }

    public function panduan()
    {
        return view('static/panduan');
    }

    public function privasi()
    {
        return view('static/privasi');
    }

    public function syarat()
    {
        return view('static/syarat');
    }

    public function admin()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('login')->with('error', 'Silakan login sebagai admin');
        }

        $db = Database::connect();
        
        $data['totalPenyakit'] = $db->table('penyakit')->countAllResults();
        $data['totalGejala'] = $db->table('gejala')->countAllResults();
        $data['totalRules'] = $db->table('basis_pengetahuan')->countAllResults();
        
        return view('admin/dashboard', $data);
    }

    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $data['user'] = [
            'nama_lengkap' => session()->get('nama_lengkap'),
            'username' => session()->get('username'),
        ];
        
        return view('pengguna/dashboard', $data);
    }

    public function pengguna()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('login')->with('error', 'Silakan login sebagai admin');
        }

        $userModel = new \App\Models\UserModel();
        $data['pengguna'] = $userModel->where('role', 'pengguna')->orderBy('created_at', 'DESC')->findAll();
        
        return view('admin/pengguna', $data);
    }

    public function deletePengguna($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('login')->with('error', 'Silakan login sebagai admin');
        }

        $userModel = new \App\Models\UserModel();
        $userModel->delete($id);
        
        return redirect()->to('admin/pengguna')->with('success', 'Pengguna berhasil dihapus');
    }

    public function adminLibrary()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('login')->with('error', 'Silakan login sebagai admin');
        }

        $db = Database::connect();
        
        $data['penyakit'] = $db->table('penyakit')->orderBy('id_penyakit', 'ASC')->get()->getResultArray();
        $data['gejala'] = $db->table('gejala')->orderBy('id_gejala', 'ASC')->get()->getResultArray();
        $data['rules'] = $db->table('basis_pengetahuan bp')
            ->select('bp.*, p.nama_penyakit, p.kode_penyakit, g.nama_gejala, g.kode_gejala')
            ->join('penyakit p', 'p.id_penyakit = bp.id_penyakit')
            ->join('gejala g', 'g.id_gejala = bp.id_gejala')
            ->orderBy('bp.id_rule', 'ASC')
            ->get()
            ->getResultArray();
        
        return view('admin/library', $data);
    }

    public function adminRiwayat()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('login')->with('error', 'Silakan login sebagai admin');
        }

        $db = Database::connect();
        
        $cari = service('request')->getGet('cari');
        $tanggalAwal = service('request')->getGet('tanggal_awal');
        $tanggalAkhir = service('request')->getGet('tanggal_akhir');
        
        $query = $db->table('riwayat_diagnosa r')
            ->select('r.*, u.nama_lengkap, u.email')
            ->join('users u', 'u.id = r.id_user');
        
        if ($cari) {
            $query->groupStart()
                ->like('u.nama_lengkap', $cari)
                ->orLike('u.email', $cari)
                ->orLike('r.nama_penyakit', $cari)
                ->groupEnd();
        }
        
        if ($tanggalAwal && $tanggalAkhir) {
            $query->where('r.tanggal_diagnosa >=', $tanggalAwal . ' 00:00:00')
                ->where('r.tanggal_diagnosa <=', $tanggalAkhir . ' 23:59:59');
        }
        
        $data['riwayat'] = $query->orderBy('r.tanggal_diagnosa', 'DESC')
            ->get()
            ->getResultArray();
        
        return view('admin/riwayat', $data);
    }

    public function profile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $db = Database::connect();
        $userId = session()->get('id');
        
        $data['title'] = 'Profil Pengguna';
$userData = $db->table('users')->where('id', $userId)->get()->getRowArray();
        
        $data['user'] = [
            'nama_lengkap' => session()->get('nama_lengkap'),
            'username' => session()->get('username'),
            'email' => $userData['email'] ?? session()->get('email') ?? '-',
            'role' => session()->get('role'),
            'created_at' => date('d F Y', strtotime($userData['created_at'] ?? 'now')),
        ];

        return view('pengguna/profile', $data);
    }
}
