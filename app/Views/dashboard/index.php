<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Dashboard - CornAI">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-1">
        Halo, <?= session()->get('nama_lengkap') ?? 'Pengguna' ?> 👋
    </h1>
    <p class="text-slate-600 dark:text-slate-400 text-sm">
        Berikut ringkasan aktivitas dan menu untuk mengelola diagnosa tanaman jagung Anda.
    </p>
</div>

<!-- Stats Cards - User Specific -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-gradient-to-br from-primary to-green-600 rounded-xl p-4 text-white shadow-lg">
        <div class="flex items-center justify-between mb-2">
            <span class="material-symbols-outlined text-2xl">medical_services</span>
        </div>
        <p class="text-3xl font-bold"><?= $totalDiagnosa ?? 0 ?></p>
        <p class="text-green-100 text-xs">Total Deteksi</p>
    </div>

    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 text-white shadow-lg">
        <div class="flex items-center justify-between mb-2">
            <span class="material-symbols-outlined text-2xl">calendar_month</span>
        </div>
        <p class="text-2xl font-bold"><?= $latestDiagnosa ?? '-' ?></p>
        <p class="text-blue-100 text-xs">Terakhir Deteksi</p>
    </div>

    <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl p-4 text-white shadow-lg">
        <div class="flex items-center justify-between mb-2">
            <span class="material-symbols-outlined text-2xl">bug_report</span>
        </div>
        <p class="text-2xl font-bold truncate"><?= $penyakitTerbanyak ?? '-' ?></p>
        <p class="text-amber-100 text-xs">Penyakit Terbanyak</p>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 text-white shadow-lg">
        <div class="flex items-center justify-between mb-2">
            <span class="material-symbols-outlined text-2xl">speed</span>
        </div>
        <p class="text-3xl font-bold"><?= $avgCf ?? 0 ?>%</p>
        <p class="text-purple-100 text-xs">Rata-rata Keyakinan</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <a href="<?= base_url('deteksi') ?>" class="flex items-center gap-4 p-4 bg-white rounded-xl border border-slate-200 hover:border-primary hover:shadow-md transition-all group">
        <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
            <span class="material-symbols-outlined text-2xl">search</span>
        </div>
        <div>
            <h3 class="font-semibold text-slate-900">Mulai Deteksi</h3>
            <p class="text-slate-500 text-sm">Diagnosa penyakit tanaman</p>
        </div>
    </a>
    
    <a href="<?= base_url('riwayat') ?>" class="flex items-center gap-4 p-4 bg-white rounded-xl border border-slate-200 hover:border-primary hover:shadow-md transition-all group">
        <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-all">
            <span class="material-symbols-outlined text-2xl">history</span>
        </div>
        <div>
            <h3 class="font-semibold text-slate-900">Riwayat Diagnosa</h3>
            <p class="text-slate-500 text-sm">Lihat hasil sebelumnya</p>
        </div>
    </a>
</div>

<!-- Riwayat Terbaru -->
<?php if (!empty($recentRiwayat)): ?>
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">recent_actors</span>
            Riwayat Diagnosa Terbaru
        </h2>
    </div>
    <table class="w-full text-left">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-3 text-sm font-bold text-slate-700">Tanggal</th>
                <th class="px-6 py-3 text-sm font-bold text-slate-700">Penyakit</th>
                <th class="px-6 py-3 text-sm font-bold text-slate-700">Kepastian</th>
                <th class="px-6 py-3 text-sm font-bold text-slate-700 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php foreach ($recentRiwayat as $r): ?>
            <tr class="hover:bg-slate-50">
                <td class="px-6 py-4 text-slate-600"><?= date('d M Y', strtotime($r['tanggal_diagnosa'])) ?></td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center rounded-lg bg-primary/10 text-primary text-xs font-bold px-3 py-1">
                        <?= esc($r['nama_penyakit'] ?? '-') ?>
                    </span>
                </td>
                <td class="px-6 py-4">
                    <?php 
                    $cf = floatval($r['cf_percentage'] ?? 0);
                    if ($cf > 0):
                    ?>
                    <span class="font-semibold text-green-600"><?= number_format($cf, 0) ?>%</span>
                    <?php else: ?>
                    <span class="text-slate-400">-</span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="<?= base_url('riwayat/detail/' . $r['id_riwayat']) ?>" class="inline-flex items-center gap-1 text-primary hover:text-primary/80 text-sm font-medium">
                        Lihat Detail
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
<div class="bg-white rounded-xl border border-slate-200 p-8 text-center">
    <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">history</span>
    <h3 class="text-slate-700 text-lg font-semibold mb-2">Belum Ada Riwayat</h3>
    <p class="text-slate-500 text-sm mb-4">Anda belum melakukan diagnosa apapun.</p>
    <a href="<?= base_url('deteksi') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg font-medium hover:bg-primary/90">
        <span class="material-symbols-outlined">search</span>
        Mulai Deteksi Sekarang
    </a>
</div>
<?php endif; ?>
<?= $this->endSection() ?>