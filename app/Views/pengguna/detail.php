<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Detail Riwayat Diagnosa - CornAI">
<style>
@keyframes ping-slow {
    0% { transform: scale(1); opacity: 1; }
    75%, 100% { transform: scale(2); opacity: 0; }
}
.animate-ping-slow { animation: ping-slow 2s cubic-bezier(0, 0, 0.2, 1) infinite; }

@media print {
    .no-print { display: none !important; }
    body { background: white !important; }
    .print-container::before { content: "Laporan Diagnosa CornAI"; display: block; text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 10px; color: #56995c; }
    aside, header { display: none !important; }
    main { margin-left: 0 !important; padding-top: 0 !important; }
}

.progress-ring { transition: stroke-dasharray 1.2s ease-out; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$persen = floatval($riwayat['cf_percentage'] ?? $riwayat['persentase'] ?? 0);
$cfHasil = floatval($riwayat['cf_hasil'] ?? 0);

if ($persen >= 80) {
    $statusLabel = 'Keyakinan Tinggi';
    $statusBg = 'bg-green-100 text-green-700';
    $barColor = 'bg-green-500';
    $badgeBg = 'bg-red-50 text-red-600 border-red-100';
} elseif ($persen >= 60) {
    $statusLabel = 'Keyakinan Sedang';
    $statusBg = 'bg-blue-100 text-blue-700';
    $barColor = 'bg-blue-500';
    $badgeBg = 'bg-yellow-50 text-yellow-600 border-yellow-100';
} elseif ($persen >= 40) {
    $statusLabel = 'Keyakinan Cukup';
    $statusBg = 'bg-yellow-100 text-yellow-700';
    $barColor = 'bg-yellow-500';
    $badgeBg = 'bg-orange-50 text-orange-600 border-orange-100';
} else {
    $statusLabel = 'Keyakinan Rendah';
    $statusBg = 'bg-orange-100 text-orange-700';
    $barColor = 'bg-orange-500';
    $badgeBg = 'bg-slate-50 text-slate-600 border-slate-200';
}

$gambar = $riwayat['gambar_penyakit'] ?? '';
$gambarSrc = (!empty($gambar) && (strpos($gambar, 'http') === 0 || strpos($gambar, 'uploads/') === 0))
    ? (strpos($gambar, 'http') === 0 ? $gambar : base_url($gambar))
    : '';
?>

<div class="max-w-6xl mx-auto print-container">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6">
        <div class="space-y-1">
            <div class="flex items-center gap-3 no-print">
                <a href="<?= base_url('riwayat') ?>" class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-slate-500 hover:text-primary hover:bg-primary/10 transition-colors shadow-sm border border-slate-200">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                </a>
                <span class="text-primary font-bold text-xs tracking-widest uppercase flex items-center gap-2">
                    <span class="h-[2px] w-8 bg-primary"></span>
                    Riwayat Diagnosa
                </span>
            </div>
            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-slate-900">Laporan Diagnosa</h2>
            <div class="text-slate-500 flex items-center gap-4 text-sm mt-2 flex-wrap">
                <p class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">person</span>
                    <?= esc($riwayat['nama_user'] ?? 'Pengguna Anonim') ?>
                </p>
                <p class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                    <?= date('d F Y, H:i', strtotime($riwayat['tanggal_diagnosa'])) ?>
                </p>
            </div>
        </div>
        <div class="flex flex-wrap gap-3 w-full md:w-auto no-print">
            <button onclick="window.print()" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">print</span>
                Cetak
            </button>
            <a href="<?= base_url('deteksi') ?>" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-3 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-slate-800 transition-all shadow-md">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Diagnosa Baru
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-8 flex flex-col gap-8">
            <!-- Primary Diagnosis Card -->
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xl shadow-slate-200/50">
                <!-- Top section with gradient -->
                <div class="p-6 md:p-8 border-b border-slate-100 bg-gradient-to-br from-primary/5 via-white to-white relative">
                    <div class="absolute top-0 right-0 p-8 opacity-10 pointer-events-none">
                        <span class="material-symbols-outlined text-[120px]">health_and_safety</span>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6 justify-between items-start relative z-10">
                        <div class="flex-1">
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full <?= $badgeBg ?> text-xs font-black uppercase tracking-widest mb-4 border">
                                <span class="size-2 rounded-full <?= $barColor ?> animate-ping-slow"></span>
                                Probabilitas Tertinggi
                            </div>
                            <h3 class="text-3xl font-black text-slate-900 mb-1 leading-tight"><?= esc($riwayat['nama_penyakit']) ?></h3>
                            <p class="text-slate-400 text-sm mb-4"><?= esc($riwayat['kode_penyakit']) ?></p>

                            <?php if (!empty($gambarSrc)): ?>
                            <div class="w-full max-w-sm rounded-2xl overflow-hidden border border-slate-200 shadow-lg mb-4">
                                <img src="<?= $gambarSrc ?>" alt="Gambar <?= esc($riwayat['nama_penyakit']) ?>" class="w-full h-auto object-cover">
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Circular Progress -->
                        <div class="flex items-center gap-5 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                            <div class="relative size-24 flex items-center justify-center">
                                <svg class="size-full -rotate-90 transform" viewBox="0 0 36 36">
                                    <path class="text-slate-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3.5"></path>
                                    <path class="progress-ring text-primary" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="0, 100" stroke-linecap="round" stroke-width="3.5" id="circle-progress"></path>
                                </svg>
                                <div class="absolute flex flex-col items-center">
                                    <span class="text-2xl font-black text-slate-900" id="persentase-display">0%</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] uppercase tracking-[0.2em] text-slate-400 font-black">Confidence</span>
                                <span class="text-xs font-bold px-3 py-1 rounded-lg <?= $statusBg ?> inline-block text-center"><?= $statusLabel ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Analisis Patologi / Definisi -->
                    <div class="mt-8 bg-slate-50/80 backdrop-blur-sm p-5 rounded-2xl border border-slate-100 group transition-all hover:bg-slate-50">
                        <h4 class="font-black text-slate-900 text-sm uppercase tracking-wider mb-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-xl">biotech</span>
                            Analisis Patologi
                        </h4>
                        <p class="text-slate-600 text-sm leading-relaxed"><?= esc($riwayat['solusi_penyakit'] ?? '-') ?></p>
                    </div>
                </div>

                <!-- Protokol Pemulihan -->
                <div class="p-6 md:p-8 bg-white border-b border-slate-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 rounded-xl bg-primary/10 text-primary">
                            <span class="material-symbols-outlined text-2xl font-bold">healing</span>
                        </div>
                        <h4 class="text-xl font-black text-slate-900">Protokol Pemulihan</h4>
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-2xl border border-red-500/10 bg-red-50/50 p-6 shadow-sm">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-500/10 text-red-600">
                                    <span class="material-symbols-outlined text-sm font-bold">emergency</span>
                                </div>
                                <h5 class="text-red-700 text-sm font-black uppercase tracking-widest">Tindakan Segera</h5>
                            </div>
                            <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap ml-11"><?= esc($riwayat['tindakan_segera'] ?? 'Belum ada panduan tindakan segera.') ?></p>
                        </div>

                        <div class="rounded-2xl border border-blue-500/10 bg-blue-50/50 p-6 shadow-sm">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500/10 text-blue-600">
                                    <span class="material-symbols-outlined text-sm font-bold">medical_services</span>
                                </div>
                                <h5 class="text-blue-700 text-sm font-black uppercase tracking-widest">Protokol Pengobatan</h5>
                            </div>
                            <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap ml-11"><?= esc($riwayat['protokol_pengobatan'] ?? 'Belum ada panduan protokol pengobatan.') ?></p>
                        </div>

                        <div class="rounded-2xl border border-green-500/10 bg-green-50/50 p-6 shadow-sm">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-500/10 text-green-600">
                                    <span class="material-symbols-outlined text-sm font-bold">security</span>
                                </div>
                                <h5 class="text-green-700 text-sm font-black uppercase tracking-widest">Strategi Pencegahan</h5>
                            </div>
                            <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap ml-11"><?= esc($riwayat['strategi_pencegahan'] ?? 'Belum ada panduan strategi pencegahan.') ?></p>
                        </div>
                    </div>
                </div>

                <!-- Detail Perhitungan CF -->
                <div class="p-6 md:p-8 bg-white">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 rounded-xl bg-primary/10 text-primary">
                            <span class="material-symbols-outlined text-2xl font-bold">calculate</span>
                        </div>
                        <h4 class="text-xl font-black text-slate-900">Detail Perhitungan CF</h4>
                    </div>

                    <?php if (!empty($detailGejala)): ?>
                    <div class="space-y-4">
                        <?php foreach ($detailGejala as $idx => $dp): ?>
                        <div class="group rounded-2xl border border-slate-100 bg-white overflow-hidden transition-all hover:shadow-lg hover:border-slate-200">
                            <div class="px-5 py-3 bg-primary/5 flex items-center justify-between border-b border-slate-100">
                                <div class="flex items-center gap-3 font-black text-xs uppercase tracking-widest text-primary">
                                    <span class="material-symbols-outlined text-lg">science</span>
                                    <?= esc($dp['kode'] ?? '') ?> — <?= esc($dp['nama'] ?? '') ?>
                                </div>
                                <span class="flex h-2 w-2 rounded-full bg-primary"></span>
                            </div>
                            <div class="p-5">
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div class="bg-slate-50 p-3 rounded-xl">
                                        <div class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">CF User</div>
                                        <div class="text-lg font-black text-slate-800"><?= number_format(floatval($dp['cf_user'] ?? 0), 2) ?></div>
                                    </div>
                                    <div class="bg-slate-50 p-3 rounded-xl">
                                        <div class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">CF Pakar</div>
                                        <div class="text-lg font-black text-slate-800"><?= number_format(floatval($dp['cf_pakar'] ?? 0), 2) ?></div>
                                    </div>
                                    <div class="bg-primary/10 p-3 rounded-xl">
                                        <div class="text-[10px] uppercase tracking-widest text-primary font-bold mb-1">CF Hasil</div>
                                        <div class="text-lg font-black text-primary"><?= number_format(floatval($dp['cf_hasil'] ?? 0), 4) ?></div>
                                    </div>
                                </div>
                                <div class="mt-3 text-xs text-slate-400 text-center">
                                    CF = <?= number_format(floatval($dp['cf_user'] ?? 0), 2) ?> × <?= number_format(floatval($dp['cf_pakar'] ?? 0), 2) ?> = <?= number_format(floatval($dp['cf_hasil'] ?? 0), 4) ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <!-- CF Combine Result -->
                        <div class="mt-4 p-5 rounded-2xl bg-slate-900 text-white relative overflow-hidden">
                            <div class="absolute right-0 top-0 p-4 opacity-10">
                                <span class="material-symbols-outlined text-6xl">functions</span>
                            </div>
                            <div class="flex items-start gap-4 relative z-10">
                                <span class="material-symbols-outlined text-primary font-bold text-2xl">verified</span>
                                <div class="space-y-1">
                                    <p class="text-sm font-black uppercase tracking-widest text-primary">Hasil CF Combine</p>
                                    <p class="text-xs text-slate-400">CF Combine = CF₁ + CF₂ × (1 − CF₁) → diulang untuk setiap gejala</p>
                                    <p class="text-2xl font-black mt-2"><?= number_format($cfHasil, 4) ?> <span class="text-sm text-slate-400">(<?= number_format($persen, 2) ?>%)</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <p class="text-slate-400 text-sm">Data perhitungan CF tidak tersedia.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-4 flex flex-col gap-8">
            <!-- Gejala Teramati -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-slate-900">Anamnesa</h3>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Gejala</span>
                </div>
                <?php if (!empty($gejalaDipilih)): ?>
                <ul class="space-y-3">
                    <?php foreach ($gejalaDipilih as $g): ?>
                    <li class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100 transition-all hover:bg-white hover:shadow-md hover:border-primary/20 group">
                        <div class="size-8 rounded-xl bg-white flex items-center justify-center text-primary shadow-sm group-hover:bg-primary group-hover:text-white transition-colors flex-shrink-0">
                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                        </div>
                        <span class="text-sm text-slate-600 leading-snug font-medium"><?= esc($g['kode'] ?? '') ?> — <?= esc($g['nama'] ?? '') ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p class="text-slate-400 text-sm">Tidak ada data gejala tersimpan.</p>
                <?php endif; ?>
            </div>

            <!-- Rumus CF -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h4 class="text-sm font-black text-slate-900 mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">menu_book</span>
                    Rumus Certainty Factor
                </h4>
                <div class="space-y-2 text-sm text-slate-600">
                    <div class="bg-slate-50 p-3 rounded-xl">
                        <p class="font-bold text-slate-700 text-xs">CF Gejala</p>
                        <p class="text-xs mt-1">CF(user) × CF(pakar)</p>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl">
                        <p class="font-bold text-slate-700 text-xs">CF Combine</p>
                        <p class="text-xs mt-1">CF₁ + CF₂ × (1 − CF₁)</p>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl">
                        <p class="font-bold text-slate-700 text-xs">Persentase</p>
                        <p class="text-xs mt-1">CF Combine × 100%</p>
                    </div>
                </div>
            </div>

            <!-- Delete action (admin only) -->
            <?php if (session()->get('isLoggedIn')): ?>
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm no-print">
                <h4 class="text-sm font-black text-slate-900 mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-500">delete</span>
                    Hapus Riwayat
                </h4>
                <p class="text-slate-400 text-xs mb-4">Tindakan ini bersifat permanen dan tidak dapat dibatalkan.</p>
                <a href="<?= base_url('riwayat/hapus/' . $riwayat['id_riwayat']) ?>"
                   onclick="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?')"
                   class="block text-center w-full py-3 bg-red-500 text-white font-bold rounded-xl text-sm hover:bg-red-600 transition-all shadow-md">
                    Hapus Riwayat Ini
                </a>
            </div>
            <?php endif; ?>

            <!-- Banner CTA -->
            <div class="bg-slate-900 rounded-3xl p-6 text-white relative overflow-hidden group no-print">
                <div class="absolute -right-4 -bottom-4 text-white/10 group-hover:scale-110 transition-transform duration-500">
                    <span class="material-symbols-outlined text-[100px]">psychology</span>
                </div>
                <h4 class="text-lg font-bold mb-2 relative z-10">Butuh bantuan lebih lanjut?</h4>
                <p class="text-slate-400 text-sm mb-5 relative z-10">Konsultasikan hasil diagnosa ini dengan penyuluh pertanian setempat untuk verifikasi lapangan.</p>
                <a href="<?= base_url('deteksi') ?>" class="block text-center w-full py-3 bg-primary text-white font-bold rounded-xl text-sm relative z-10 hover:scale-[1.02] transition-transform shadow-lg">
                    Diagnosa Ulang
                </a>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const progress = document.getElementById('circle-progress');
        const display  = document.getElementById('persentase-display');
        const target   = <?= number_format($persen, 2, '.', '') ?>;

        if (progress && display) {
            setTimeout(() => {
                progress.setAttribute('stroke-dasharray', `${target}, 100`);
            }, 200);

            let current = 0;
            const duration = 1200;
            const start = performance.now();
            function animateNumber(now) {
                const elapsed = now - start;
                const ratio = Math.min(elapsed / duration, 1);
                current = Math.round(target * ratio * 100) / 100;
                display.textContent = current.toFixed(2) + '%';
                if (ratio < 1) requestAnimationFrame(animateNumber);
            }
            requestAnimationFrame(animateNumber);
        }
    });
</script>
<?= $this->endSection() ?>