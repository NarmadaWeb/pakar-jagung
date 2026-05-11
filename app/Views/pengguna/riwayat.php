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
                    placeholder="Cari Nama atau Penyakit "
                    class="pl-10 pr-4 py-2 border border-slate-200 rounded-lg text-sm w-48 md:w-64 focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            <?php if (session()->get('isLoggedIn')): ?>
            <button onclick="showModalHapusSemua()" 
                    class="px-3 py-1.5 bg-red-100 text-red-600 text-xs font-semibold rounded-lg hover:bg-red-200 transition-colors flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">delete_sweep</span>
                Hapus Semua
            </button>
            <?php endif; ?>
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($riwayatList as $r): ?>
        <?php if (empty($r['nama_penyakit'])) continue; ?>
        
        <?php 
        $keyakinan = 'Rendah';
        if ($r['persentase'] >= 75) $keyakinan = 'Sangat Kuat';
        elseif ($r['persentase'] >= 50) $keyakinan = 'Kuat';
        elseif ($r['persentase'] >= 25) $keyakinan = 'Sedang';
        ?>
          
        <a href="<?= base_url('riwayat/detail/' . $r['id_riwayat']) ?>" class="riwayat-card block bg-white hover:bg-slate-50 border border-slate-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-all cursor-pointer">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">psychology</span>
                    <span class="text-xs font-semibold text-slate-500"><?= date('d M Y', strtotime($r['tanggal_diagnosa'])) ?></span>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <?= $r['persentase'] ?>%
                </span>
            </div>
            
            <h3 class="text-lg font-bold text-slate-900 mb-1"><?= esc($r['nama_penyakit']) ?></h3>
            <p class="text-sm text-slate-500 mb-4 flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">person</span>
                <?= esc($r['nama_user'] ?? 'Pengguna Anonim') ?>
            </p>
            
            <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center text-sm">
                <span class="text-primary font-medium hover:underline">Lihat Detail</span>
                <span class="material-symbols-outlined text-slate-400">arrow_forward</span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="flex flex-col items-center justify-center gap-4 rounded-2xl border border-dashed border-slate-300 bg-white py-20 text-center">
        <span class="material-symbols-outlined text-6xl text-slate-300">history</span>
        <h3 class="text-slate-700 text-xl font-bold">Belum Ada Riwayat</h3>
        <p class="text-slate-500 text-sm max-w-xs">Anda belum melakukan deteksi penyakit apapun.</p>
        <a href="<?= base_url('deteksi') ?>" class="mt-4 px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-primary/90">
            Mulai Deteksi
        </a>
    </div>
<?php endif; ?>

<script>
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