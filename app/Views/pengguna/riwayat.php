<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Riwayat diagnosa penyakit jagung.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php 
$userId = session()->get('id');
$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : '';
$riwayatList = $riwayat ?? [];
$count = count($riwayatList);
?>

<?php if ($sukses == '1'): ?>
<div id="toast-notification" class="fixed top-20 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 z-50 animate-slide-in">
    <span class="material-symbols-outlined">check_circle</span>
    <span class="font-medium">Riwayat berhasil dihapus</span>
</div>
<script>
    setTimeout(function() { document.getElementById('toast-notification').style.display = 'none'; }, 4000);
</script>
<?php elseif ($sukses == '2'): ?>
<div id="toast-notification" class="fixed top-20 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 z-50 animate-slide-in">
    <span class="material-symbols-outlined">check_circle</span>
    <span class="font-medium">Semua riwayat berhasil dihapus</span>
</div>
<script>
    setTimeout(function() { document.getElementById('toast-notification').style.display = 'none'; }, 4000);
</script>
<?php elseif ($sukses == '3'): ?>
<div id="toast-notification" class="fixed top-20 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 z-50 animate-slide-in">
    <span class="material-symbols-outlined">check_circle</span>
    <span class="font-medium">Riwayat berhasil disimpan</span>
</div>
<script>
    setTimeout(function() { document.getElementById('toast-notification').style.display = 'none'; }, 4000);
</script>
<?php endif; ?>

<!-- Modal Hapus Satu -->
<div id="modal-hapus" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl p-4 max-w-sm w-full mx-4">
        <div class="flex flex-col items-center text-center">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-3">
                <span class="material-symbols-outlined text-red-500 text-2xl">warning</span>
            </div>
            <h3 class="text-base font-bold text-slate-800 mb-2">Konfirmasi Hapus</h3>
            <p class="text-sm text-slate-600 mb-4">Apakah Anda yakin ingin menghapus riwayat ini?</p>
            <div class="flex gap-2 w-full">
                <button onclick="document.getElementById('modal-hapus').classList.add('hidden')" 
                        class="flex-1 px-3 py-2 border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors text-sm">
                    Tidak
                </button>
                <a id="btn-konfirmasi-hapus" href="" 
                        class="flex-1 px-3 py-2 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition-colors text-center text-sm">
                    Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Semua -->
<div id="modal-hapus-semua" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-xs w-full mx-4 border border-slate-200">
        <div class="flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-red-500 text-3xl">warning</span>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Hapus Semua Riwayat?</h3>
            <p class="text-sm text-slate-500 mb-6">Semua riwayat diagnosa akan dihapus secara permanen.</p>
            <div class="flex gap-3 w-full">
                <button onclick="document.getElementById('modal-hapus-semua').classList.add('hidden')" 
                        class="flex-1 px-4 py-2.5 border border-slate-300 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition-all text-sm">
                    Batal
                </button>
                <a href="<?= base_url('riwayat/hapus-semua') ?>" 
                        class="flex-1 px-4 py-2.5 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 transition-all text-center text-sm shadow-lg shadow-red-500/30">
                    Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<div class="flex flex-col gap-2 mb-4 no-print">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-slate-900 text-xl md:text-2xl font-bold">Riwayat Diagnosa</h1>
            <div class="h-1 w-16 bg-primary rounded-full"></div>
            <p class="text-slate-600 text-sm">Riwayat hasil deteksi penyakit tanaman jagung Anda</p>
        </div>
        <?php if ($count > 0): ?>
        <div class="flex items-center gap-2">
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <span class="material-symbols-outlined">search</span>
                </span>
                <input type="text" id="searchInput" onkeyup="searchRiwayat()" 
                    placeholder="Cari penyakit..."
                    class="pl-10 pr-4 py-2 border border-slate-200 rounded-lg text-sm w-48 md:w-64 focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            <button onclick="showModalHapusSemua()" 
                    class="px-3 py-1.5 bg-red-100 text-red-600 text-xs font-semibold rounded-lg hover:bg-red-200 transition-colors flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">delete_sweep</span>
                Hapus Semua
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function searchRiwayat() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const cards = document.querySelectorAll('.riwayat-card');
    
    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(filter)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

<?php if ($count > 0): ?>
    <div class="space-y-6 print-container">
        <?php foreach ($riwayatList as $r): ?>
        <?php if (empty($r['nama_penyakit'])) continue; ?>
        
        <?php 
        $detailGejala = !empty($r['detail_gejala']) ? json_decode($r['detail_gejala'], true) : [];
        $gejalaDipilih = !empty($r['gejala_dipilih']) ? json_decode($r['gejala_dipilih'], true) : [];
        
        $keyakinan = 'Rendah';
        if ($r['persentase'] >= 75) $keyakinan = 'Sangat Kuat';
        elseif ($r['persentase'] >= 50) $keyakinan = 'Kuat';
        elseif ($r['persentase'] >= 25) $keyakinan = 'Sedang';
        
        if ($r['persentase'] >= 80) {
            $statusLabel = 'SANGAT YAKIN';
            $statusBg = 'bg-green-100 text-green-800';
            $barColor = 'bg-green-500';
        } elseif ($r['persentase'] >= 60) {
            $statusLabel = 'YAKIN';
            $statusBg = 'bg-green-100 text-green-800';
            $barColor = 'bg-green-500';
        } elseif ($r['persentase'] >= 40) {
            $statusLabel = 'CUKUP YAKIN';
            $statusBg = 'bg-green-100 text-green-800';
            $barColor = 'bg-green-500';
        } else {
            $statusLabel = 'KURANG YAKIN';
            $statusBg = 'bg-green-100 text-green-800';
            $barColor = 'bg-green-500';
        }
?>
          
        <div class="bg-white rounded-xl border-2 border-primary shadow-lg overflow-hidden riwayat-card" id="riwayat-card-<?= $r['id_riwayat'] ?>">
            <!-- Print Header (Only visible in print) -->
            <div class="print-header print-only">
                <h2 class="text-2xl md:text-4xl font-black text-slate-900">Laporan Diagnosa</h2>
                <p class="text-slate-600 text-sm md:text-base mt-1">
                    Hasil analisis berdasarkan gejala yang diinput pada <?= date('d F Y, H:i', strtotime($r['tanggal_diagnosa'])) ?>
                </p>
                <div class="flex items-center gap-2 mt-2 text-xs text-slate-500">
                    <span class="material-symbols-outlined text-sm">psychology</span>
                    <span>Metode: Certainty Factor (CF)</span>
                </div>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mb-6 print-info-box print-only">
                <h3 class="font-bold text-blue-800 flex items-center gap-2">
                    <span class="material-symbols-outlined">info</span>
                    Tentang Metode Certainty Factor
                </h3>
                <p class="text-blue-700 text-sm mt-1">
                    Sistem mencocokkan gejala yang Anda pilih dengan basis pengetahuan. CF = Keyakinan User × Keyakinan Pakar. 
                    Nilai CF gabung dihitung menggunakan rumus: CFgab = CF1 + CF2(1-CF1). Hasil diagnosa menunjukkan tingkat kepastian tertinggi.
                </p>
            </div>
            
            <div class="bg-primary text-white px-6 py-2 flex items-center gap-2">
                <span class="material-symbols-outlined">verified</span>
                <span class="font-bold">Diagnosa Utama - <?= $statusLabel ?> (<?= $r['persentase'] ?>%)</span>
            </div>
            
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
                    <div class="flex items-center gap-4">
                        <?php 
                        $db = \Config\Database::connect();
                        $penyakitData = $db->table('penyakit')->where('nama_penyakit', $r['nama_penyakit'])->get()->getRowArray();
                        $gambar = $penyakitData['gambar'] ?? '';
                        $gambarSrc = (!empty($gambar) && (strpos($gambar, 'http') === 0 || strpos($gambar, 'uploads/') === 0)) 
                            ? (strpos($gambar, 'http') === 0 ? $gambar : base_url($gambar)) 
                            : '';
                        if (!empty($gambarSrc)): ?>
                        <img src="<?= $gambarSrc ?>" alt="<?= esc($r['nama_penyakit']) ?>" class="w-16 h-16 object-cover rounded-xl">
                        <?php else: ?>
                        <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-3xl">coronavirus</span>
                        </div>
                        <?php endif; ?>
                        <div>
                            <span class="inline-flex items-center rounded-lg bg-red-100 text-red-700 text-xs font-bold px-2 py-1">HASIL UTAMA</span>
                            <h3 class="text-xl md:text-2xl font-bold text-primary mt-1"><?= esc($r['nama_penyakit']) ?></h3>
                            <span class="text-sm text-slate-500"><?= esc($r['kode_penyakit'] ?? '-') ?></span>
                        </div>
                    </div>
                    <div class="text-left md:text-right">
                        <div class="inline-flex items-center gap-2 px-4 py-2 <?= $statusBg ?> rounded-lg font-bold">
                            <span class="material-symbols-outlined text-xl">check_circle</span>
                            <?= number_format($r['persentase'], 2) ?>%
                        </div>
                    </div>
                </div>

                <div class="mb-4 text-sm text-slate-500 flex items-center gap-2 no-print">
                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                    Tanggal: <?= date('d F Y, H:i', strtotime($r['tanggal_diagnosa'])) ?>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Keyakinan Diagnosa</span>
                        <span class="text-sm font-bold text-primary"><?= $keyakinan ?></span>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-3">
                        <div class="<?= $barColor ?> h-3 rounded-full transition-all" style="width: <?= $r['persentase'] ?>%"></div>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-primary">description</span>
                        <h4 class="font-bold text-slate-700">Definisi Penyakit</h4>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        <?= esc($r['solusi'] ?? 'Penyakit ini menyerang tanaman jagung dan dapat menyebabkan kerugian signifikan jika tidak ditangani dengan tepat.') ?>
                    </p>
                </div>

                <div class="border border-slate-200 rounded-xl overflow-hidden mb-6">
                    <div class="bg-slate-100 px-4 py-3 border-b border-slate-200 flex justify-between items-center">
                        <h4 class="font-bold text-slate-700">Detail Perhitungan CF</h4>
                        <span class="material-symbols-outlined text-slate-500 text-sm">info</span>
                    </div>
                    <div class="p-4 space-y-2">
                        <?php if (!empty($detailGejala)): ?>
                            <?php foreach ($detailGejala as $g): ?>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-600"><?= esc($g['kode'] ?? '') ?> - <?= esc($g['nama'] ?? '') ?></span>
                                <span class="font-semibold text-slate-700">CF = <?= $g['cf_user'] ?? 0 ?> × <?= $g['cf_pakar'] ?? 0 ?></span>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <hr class="border-slate-200 my-2"/>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-slate-700">Hasil Akhir CF Combine</span>
                            <span class="font-bold text-primary"><?= number_format($r['cf_hasil'], 4) ?></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-4">
                    <h4 class="font-bold text-slate-700 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">fact_check</span>
                        Gejala Terdeteksi
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <?php if (!empty($gejalaDipilih)): ?>
                            <?php foreach ($gejalaDipilih as $g): ?>
                            <div class="flex items-center gap-2 p-2 bg-slate-50 rounded-lg">
                                <span class="material-symbols-outlined text-blue-500 text-sm">check_circle</span>
                                <span class="text-sm text-slate-600"><?= esc($g['kode'] ?? '') ?> - <?= esc($g['nama'] ?? '') ?></span>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">info</span>
                    ID Riwayat: <?= $r['id_riwayat'] ?> | Metode: Certainty Factor (CF)
                </div>
                <div class="flex items-center gap-2 no-print">
                    <button onclick="downloadPDF(<?= $r['id_riwayat'] ?>)" 
                            class="flex items-center gap-1 px-2 py-1 text-slate-400 hover:text-primary hover:bg-primary/10 rounded transition-colors no-print">
                        <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                        <span>PDF</span>
                    </button>
                    <button onclick="showModalHapus('<?= base_url('riwayat/hapus/' . $r['id_riwayat']) ?>')" 
                            class="flex items-center gap-1 px-2 py-1 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded transition-colors no-print">
                        <span class="material-symbols-outlined text-sm">delete</span>
                        <span class="no-print">Hapus</span>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="flex flex-col items-center justify-center gap-4 rounded-2xl border border-dashed border-slate-300 bg-white py-20 text-center">
        <span class="material-symbols-outlined text-6xl text-slate-300">history</span>
        <h3 class="text-slate-700 text-xl font-bold">Belum Ada Riwayat</h3>
        <p class="text-slate-500 text-sm max-w-xs">Anda belum melakukan deteksi penyakit apapun.</p>
        <?php if (session()->get('isLoggedIn')): ?>
        <a href="<?= base_url('deteksi') ?>" class="mt-4 px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-primary/90">
            Mulai Deteksi
        </a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<script>
function showModalHapus(url) {
    document.getElementById('btn-konfirmasi-hapus').href = url;
    document.getElementById('modal-hapus').classList.remove('hidden');
}

function showModalHapusSemua() {
    document.getElementById('modal-hapus-semua').classList.remove('hidden');
}

function downloadPDF(id) {
    // Hide all cards first
    document.querySelectorAll('.riwayat-card').forEach(card => {
        card.classList.add('print-hide');
    });
    
    // Show only selected card
    const selectedCard = document.getElementById('riwayat-card-' + id);
    selectedCard.classList.remove('print-hide');
    selectedCard.classList.add('print-show');
    
    // Hide delete button in print
    selectedCard.querySelectorAll('.no-print').forEach(el => {
        el.style.display = 'none';
    });
    
    window.print();
    
    // Reset
    document.querySelectorAll('.riwayat-card').forEach(card => {
        card.classList.remove('print-hide', 'print-show');
    });
    selectedCard.querySelectorAll('.no-print').forEach(el => {
        el.style.display = '';
    });
}

function showModalHapus(url) {
    document.getElementById('btn-konfirmasi-hapus').href = url;
    document.getElementById('modal-hapus').classList.remove('hidden');
}

function showModalHapusSemua() {
    document.getElementById('modal-hapus-semua').classList.remove('hidden');
}
</script>

<style>
@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
.animate-slide-in {
    animation: slideIn 0.3s ease-out;
}
.material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
}
.print-hide { display: none !important; }
.print-only { display: none; }
@media print {
    .no-print { display: none !important; }
    body { background: white !important; font-family: 'Inter', sans-serif !important; }
    nav, header, footer { display: none !important; }
    main { padding: 0 !important; }
    .print-only { display: block !important; }
    .print-header { margin-bottom: 20px; }
    .print-header h2 { font-size: 32px !important; font-weight: 800 !important; color: #0f172a !important; }
    .print-header p { color: #64748b !important; font-size: 14px !important; margin-top: 4px !important; }
    .print-info-box { margin-bottom: 20px !important; background: #eff6ff !important; border: 1px solid #bfdbfe !important; }
    .print-info-box h3 { color: #1e40af !important; }
    .print-info-box p { color: #1e3a8a !important; }
    .print-container { padding: 20px !important; max-width: 100% !important; box-shadow: none !important; }
    .print-container::before {
        content: "Laporan Diagnosa Penyakit Jagung - CornAI";
        display: block; font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px; color: #56995c;
    }
    .print-show { display: block !important; }
    .print-hide { display: none !important; }
    .bg-white { border: none !important; box-shadow: none !important; }
    .shadow-lg { box-shadow: none !important; }
    .border-2 { border: none !important; }
    .border { border: none !important; }
    .rounded-xl { border-radius: 0 !important; }
    .bg-primary { background: #56995c !important; -webkit-print-color-adjust: exact; }
    .bg-slate-50 { background: #f8fafc !important; -webkit-print-color-adjust: exact; }
    .text-primary { color: #56995c !important; -webkit-print-color-adjust: exact; }
}
</style>
<?= $this->endSection() ?>