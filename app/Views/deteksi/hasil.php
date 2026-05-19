<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Hasil Diagnosa - CornAI">
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

/* Progress circle animation */
.progress-ring { transition: stroke-dasharray 1.2s ease-out; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="print-container max-w-none">

    <?php if (session('error')): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3">
        <span class="material-symbols-outlined text-xl">error</span>
        <?= session('error') ?>
    </div>
    <?php elseif (empty($hasil)): ?>
    <!-- No Result -->
    <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-sm">
        <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">search_off</span>
        <h3 class="text-2xl font-black text-slate-800 mb-2">Tidak ada penyakit yang teridentifikasi.</h3>
        <p class="text-slate-500 mb-6">Gejala yang diberikan tidak cocok dengan penyakit yang diketahui secara kuat.</p>
        <a href="<?= base_url('deteksi') ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary-dark transition-all">
            <span class="material-symbols-outlined">refresh</span>
            Coba Lagi
        </a>
    </div>
    <?php else: ?>

    <?php
    $utama = $hasil[0];
    $cfVal = $utama['cf_combine'];
    $persen = $utama['persentase'];

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

    $gambar = $utama['penyakit']['gambar'] ?? '';
    $gambarSrc = (!empty($gambar) && (strpos($gambar, 'http') === 0 || strpos($gambar, 'uploads/') === 0))
        ? (strpos($gambar, 'http') === 0 ? $gambar : base_url($gambar))
        : '';
    ?>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-6">
        <div class="space-y-1">
            <div class="flex items-center gap-3 no-print">
                <a href="<?= base_url('deteksi') ?>" class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-slate-500 hover:text-primary hover:bg-primary/10 transition-colors shadow-sm border border-slate-200">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                </a>
                <span class="text-primary font-bold text-xs tracking-widest uppercase flex items-center gap-2">
                    <span class="h-[2px] w-8 bg-primary"></span>
                    Hasil Diagnosa
                </span>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Laporan Diagnosa</h2>
            <div class="text-slate-500 flex items-center gap-4 text-sm mt-1 flex-wrap">
                <p class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">person</span>
                    <?= esc($insertData['nama_user'] ?? 'Pengguna Anonim') ?>
                </p>
                <p class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                    <?= date('d F Y, H:i') ?>
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
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full <?= $badgeBg ?> text-xs font-bold uppercase tracking-widest mb-3 border">
                                <span class="size-2 rounded-full <?= $barColor ?> animate-ping-slow"></span>
                                Probabilitas Tertinggi
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-1"><?= esc($utama['penyakit']['nama_penyakit']) ?></h3>
                            <p class="text-slate-400 text-xs mb-3"><?= esc($utama['penyakit']['kode_penyakit']) ?></p>

                            <?php if (!empty($gambarSrc)): ?>
                            <div class="w-full max-w-sm rounded-2xl overflow-hidden border border-slate-200 shadow-lg mb-4">
                                <img src="<?= $gambarSrc ?>?t=<?= time() ?>" alt="Gambar Penyakit" class="w-full h-auto object-cover">
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Circular Progress -->
                        <div class="flex items-center gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
                            <div class="relative size-20 flex items-center justify-center">
                                <svg class="size-full -rotate-90 transform" viewBox="0 0 36 36">
                                    <path class="text-slate-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3.5"></path>
                                    <path class="progress-ring text-primary" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="0, 100" stroke-linecap="round" stroke-width="3.5" id="circle-progress"></path>
                                </svg>
                                <div class="absolute flex flex-col items-center">
                                    <span class="text-xl font-bold text-slate-900" id="persentase-display">0%</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] uppercase tracking-wider text-slate-400 font-bold">Confidence</span>
                                <span class="text-xs font-semibold px-2 py-1 rounded-lg <?= $statusBg ?> inline-block text-center"><?= $statusLabel ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi / Definisi Penyakit -->
                    <div class="mt-4 bg-slate-50/80 backdrop-blur-sm p-4 rounded-xl border border-slate-100 group transition-all hover:bg-slate-50">
                        <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wider mb-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-lg">biotech</span>
                            Analisis Patologi
                        </h4>
                        <p class="text-slate-600 text-xs leading-relaxed"><?= esc($utama['penyakit']['solusi'] ?? '-') ?></p>
                    </div>
                </div>

                <!-- Protokol Pemulihan -->
                <div class="p-4 md:p-6 bg-white border-b border-slate-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 rounded-lg bg-primary/10 text-primary">
                            <span class="material-symbols-outlined text-xl font-bold">healing</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900">Protokol Pemulihan</h4>
                    </div>

                    <div class="space-y-3">
                        <div class="rounded-xl border border-red-500/10 bg-red-50/50 p-4 shadow-sm">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-red-500/10 text-red-600">
                                    <span class="material-symbols-outlined text-xs font-bold">emergency</span>
                                </div>
                                <h5 class="text-red-700 text-xs font-bold uppercase tracking-wider">Tindakan Segera</h5>
                            </div>
                            <p class="text-slate-700 text-xs leading-relaxed whitespace-pre-wrap ml-8"><?= esc($utama['penyakit']['tindakan_segera'] ?? 'Belum ada panduan tindakan segera.') ?></p>
                        </div>

                        <div class="rounded-xl border border-blue-500/10 bg-blue-50/50 p-4 shadow-sm">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-blue-500/10 text-blue-600">
                                    <span class="material-symbols-outlined text-xs font-bold">medical_services</span>
                                </div>
                                <h5 class="text-blue-700 text-xs font-bold uppercase tracking-wider">Protokol Pengobatan</h5>
                            </div>
                            <p class="text-slate-700 text-xs leading-relaxed whitespace-pre-wrap ml-8"><?= esc($utama['penyakit']['protokol_pengobatan'] ?? 'Belum ada panduan protokol pengobatan.') ?></p>
                        </div>

                        <div class="rounded-xl border border-green-500/10 bg-green-50/50 p-4 shadow-sm">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-green-500/10 text-green-600">
                                    <span class="material-symbols-outlined text-xs font-bold">security</span>
                                </div>
                                <h5 class="text-green-700 text-xs font-bold uppercase tracking-wider">Strategi Pencegahan</h5>
                            </div>
                            <p class="text-slate-700 text-xs leading-relaxed whitespace-pre-wrap ml-8"><?= esc($utama['penyakit']['strategi_pencegahan'] ?? 'Belum ada panduan strategi pencegahan.') ?></p>
                        </div>
                    </div>
                </div>

                <!-- Detail Perhitungan CF -->
                <div class="p-4 md:p-6 bg-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 rounded-lg bg-primary/10 text-primary">
                            <span class="material-symbols-outlined text-xl font-bold">calculate</span>
                        </div>
                        <h4 class="text-base font-bold text-slate-900">Detail Perhitungan CF</h4>
                    </div>

                    <?php if (!empty($utama['detail_perhitungan'])): ?>
                    <div class="space-y-3">
                        <?php foreach ($utama['detail_perhitungan'] as $idx => $dp): ?>
                        <div class="group rounded-xl border border-slate-100 bg-white overflow-hidden transition-all hover:shadow-md hover:border-slate-200">
                            <div class="px-4 py-2 bg-primary/5 flex items-center justify-between border-b border-slate-100">
                                <div class="flex items-center gap-2 font-bold text-xs uppercase tracking-widest text-primary">
                                    <span class="material-symbols-outlined text-sm">science</span>
                                    <?= esc($dp['kode']) ?> — <?= esc($dp['nama']) ?>
                                </div>
                                <span class="flex h-2 w-2 rounded-full bg-primary"></span>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-3 gap-3 text-center">
                                    <div class="bg-slate-50 p-2 rounded-lg">
                                        <div class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">CF User</div>
                                        <div class="text-sm font-bold text-slate-800"><?= number_format($dp['cf_user'], 2) ?></div>
                                    </div>
                                    <div class="bg-slate-50 p-2 rounded-lg">
                                        <div class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">CF Pakar</div>
                                        <div class="text-sm font-bold text-slate-800"><?= number_format($dp['cf_pakar'], 2) ?></div>
                                    </div>
                                    <div class="bg-primary/10 p-2 rounded-lg">
                                        <div class="text-[10px] uppercase tracking-widest text-primary font-bold mb-1">CF Hasil</div>
                                        <div class="text-sm font-bold text-primary"><?= number_format($dp['cf_hasil'], 4) ?></div>
                                    </div>
                                </div>
                                <div class="mt-2 text-xs text-slate-400 text-center">
                                    CF = <?= number_format($dp['cf_user'], 2) ?> × <?= number_format($dp['cf_pakar'], 2) ?> = <?= number_format($dp['cf_hasil'], 4) ?>
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
                                    <p class="text-2xl font-black mt-2"><?= number_format($utama['cf_combine'], 4) ?> <span class="text-sm text-slate-400">(<?= $utama['persentase'] ?>%)</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-4 flex flex-col gap-6">
            <!-- Gejala Teramati -->
            <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-slate-900">Anamnesa</h3>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Gejala</span>
                </div>
                <ul class="space-y-2">
                    <?php
                    $db = \Config\Database::connect();
                    $gejalaMap = [];
                    $allGejala = $db->table('gejala')->get()->getResultArray();
                    foreach ($allGejala as $ag) {
                        $gejalaMap[$ag['id_gejala']] = $ag;
                    }
                    foreach ($gejalaDipilih as $id):
                        $nama = isset($gejalaMap[$id]) ? $gejalaMap[$id]['nama_gejala'] : 'Gejala #'.$id;
                    ?>
                    <li class="flex items-start gap-2 p-2 rounded-xl bg-slate-50 border border-slate-100 transition-all hover:bg-white hover:shadow-sm hover:border-primary/20 group">
                        <div class="size-6 rounded-lg bg-white flex items-center justify-center text-primary shadow-sm group-hover:bg-primary group-hover:text-white transition-colors flex-shrink-0">
                            <span class="material-symbols-outlined text-xs font-bold">check</span>
                        </div>
                        <span class="text-xs text-slate-600 leading-snug font-medium"><?= esc($nama) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Kemungkinan Lain / Diferensial -->
            <?php if (count($hasil) > 1): ?>
            <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-slate-900">Diferensial</h3>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Alternatif</span>
                </div>
                <div class="flex flex-col gap-2">
                    <?php foreach (array_slice($hasil, 1) as $h):
                        $hGambar = $h['penyakit']['gambar'] ?? '';
                        $hGambarSrc = (!empty($hGambar) && (strpos($hGambar, 'http') === 0 || strpos($hGambar, 'uploads/') === 0))
                            ? (strpos($hGambar, 'http') === 0 ? $hGambar : base_url($hGambar))
                            : '';
                    ?>
                    <div class="relative group p-3 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-primary/30 transition-all cursor-pointer hover:shadow-md">
                        <div class="flex items-center gap-2 mb-2">
                            <?php if (!empty($hGambarSrc)): ?>
                            <div class="size-8 rounded-lg overflow-hidden border border-slate-200 flex-shrink-0">
                                <img src="<?= $hGambarSrc ?>?t=<?= time() ?>" class="w-full h-full object-cover" alt="">
                            </div>
                            <?php else: ?>
                            <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-primary text-sm">coronavirus</span>
                            </div>
                            <?php endif; ?>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-bold text-xs text-slate-700 truncate"><?= esc($h['penyakit']['nama_penyakit']) ?></span>
                                    <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full ml-2 flex-shrink-0"><?= $h['persentase'] ?>%</span>
                                </div>
                                <div class="w-full bg-slate-200/50 rounded-full h-1 overflow-hidden">
                                    <div class="bg-primary h-full rounded-full transition-all duration-1000" style="width: <?= $h['persentase'] ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Rumus CF -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h4 class="text-sm font-black text-slate-900 mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">menu_book</span>
                    Rumus Certainty Factor
                </h4>
                <div class="space-y-2 text-xs text-slate-600">
                    <div class="bg-slate-50 p-2 rounded-lg">
                        <p class="font-bold text-slate-700 text-xs">CF Gejala</p>
                        <p class="text-[10px] mt-1">CF(user) × CF(pakar)</p>
                    </div>
                    <div class="bg-slate-50 p-2 rounded-lg">
                        <p class="font-bold text-slate-700 text-xs">CF Combine</p>
                        <p class="text-[10px] mt-1">CF₁ + CF₂ × (1 − CF₁)</p>
                    </div>
                    <div class="bg-slate-50 p-2 rounded-lg">
                        <p class="font-bold text-slate-700 text-xs">Persentase</p>
                        <p class="text-[10px] mt-1">CF Combine × 100%</p>
                    </div>
                </div>
            </div>

            <!-- Banner -->
            <div class="bg-slate-900 rounded-xl p-4 text-white relative overflow-hidden group no-print">
                <div class="absolute -right-2 -bottom-2 text-white/10 group-hover:scale-110 transition-transform duration-500">
                    <span class="material-symbols-outlined text-[60px]">psychology</span>
                </div>
                <h4 class="text-sm font-bold mb-1 relative z-10">Butuh bantuan lebih lanjut?</h4>
                <p class="text-slate-400 text-xs mb-3 relative z-10">Konsultasikan hasil dengan penyuluh pertanian.</p>
                <a href="<?= base_url('deteksi') ?>" class="block text-center w-full py-2 bg-primary text-white font-semibold rounded-lg text-xs relative z-10 hover:scale-[1.02] transition-transform shadow-md">
                    Diagnosa Ulang
                </a>
            </div>
        </div>
    </div>

    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Animate the circular progress
    document.addEventListener('DOMContentLoaded', function() {
        const progress = document.getElementById('circle-progress');
        const display = document.getElementById('persentase-display');
        const target = <?= $hasil[0]['persentase'] ?? 0 ?>;

        if (progress && display) {
            setTimeout(() => {
                progress.setAttribute('stroke-dasharray', `${target}, 100`);
            }, 200);

            // Animate number
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