<?php

namespace App\Controllers;

use Config\Database;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        // If admin, redirect to admin panel
        if (session()->get('role') === 'admin') {
            return redirect()->to('/admin');
        }
        
        $db = Database::connect();
        $userId = session()->get('id');
        
        // Get all riwayat for this user
        $riwayat = $db->table('riwayat_diagnosa')
            ->where('id_user', $userId)
            ->orderBy('tanggal_diagnosa', 'DESC')
            ->get()
            ->getResultArray();
        
        $totalDiagnosa = count($riwayat);
        
        // User-specific stats
        $latestDiagnosa = !empty($riwayat) ? date('d M Y', strtotime($riwayat[0]['tanggal_diagnosa'])) : '-';
        
        // Count diseases by user
        $penyakitCount = [];
        foreach ($riwayat as $r) {
            $nama = $r['nama_penyakit'] ?? $r['hasil_diagnosa'] ?? 'Unknown';
            $penyakitCount[$nama] = ($penyakitCount[$nama] ?? 0) + 1;
        }
        $penyakitTerbanyak = !empty($penyakitCount) ? array_keys($penyakitCount, max($penyakitCount))[0] : '-';
        
        // Average certainty
        $totalCf = 0;
        $countCf = 0;
        foreach ($riwayat as $r) {
            $cf = floatval($r['persentase'] ?? $r['cf_percentage'] ?? 0);
            if ($cf > 0) {
                $totalCf += $cf;
                $countCf++;
            }
        }
        $avgCf = $countCf > 0 ? round($totalCf / $countCf) : 0;
        
        // Get recent 3 diagnoses and add penyakit info
        $recentRiwayat = array_slice($riwayat, 0, 3);
        foreach ($recentRiwayat as &$r) {
            $penyakit = $db->table('penyakit')->where('id_penyakit', $r['id_penyakit'] ?? 0)->get()->getRowArray();
            $r['nama_penyakit'] = $penyakit['nama_penyakit'] ?? $r['hasil_diagnosa'] ?? '-';
            $r['gambar_penyakit'] = $penyakit['gambar'] ?? '';
            
            // Use persentase field directly from database
            $cf = floatval($r['persentase'] ?? $r['cf'] ?? 0);
            if ($cf >= 70) {
                $r['status'] = 'Sembuh';
            } elseif ($cf >= 50) {
                $r['status'] = 'Dalam Perawatan';
            } elseif ($cf > 0) {
                $r['status'] = 'Perlu Perhatian';
            } else {
                $r['status'] = '-';
            }
            $r['cf_percentage'] = $cf;
        }
        
        // Get total penyakit in database
        $totalPenyakit = $db->table('penyakit')->countAllResults();
        
        // Get total gejala in database
        $totalGejala = $db->table('gejala')->countAllResults();
        
        // Get total basis pengetahuan (aturan CF)
        $totalAturan = $db->table('basis_pengetahuan')->countAllResults();
        
        $data['title'] = 'Dashboard';
        $data['totalDiagnosa'] = $totalDiagnosa;
        $data['latestDiagnosa'] = $latestDiagnosa;
        $data['penyakitTerbanyak'] = $penyakitTerbanyak;
        $data['avgCf'] = $avgCf;
        $data['recentRiwayat'] = $recentRiwayat;
        $data['totalPenyakit'] = $db->table('penyakit')->countAllResults();
        $data['totalGejala'] = $db->table('gejala')->countAllResults();
        
        return view('dashboard/index', $data);
    }
}