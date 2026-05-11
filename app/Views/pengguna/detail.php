<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Detail Riwayat Diagnosa - CornAI">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php 
$keyakinan = 'Rendah';
if ($riwayat['cf_percentage'] >= 75) $keyakinan = 'Sangat Kuat';
elseif ($riwayat['cf_percentage'] >= 50) $keyakinan = 'Kuat';
elseif ($riwayat['cf_percentage'] >= 25) $keyakinan = 'Sedang';

if ($riwayat['cf_percentage'] >= 80) {
    $statusLabel = 'SANGAT YAKIN';
    $statusBg = 'bg-green-100 text-green-800';
    $barColor = 'bg-green-500';
} elseif ($riwayat['cf_percentage'] >= 60) {
    $statusLabel = 'YAKIN';
    $statusBg = 'bg-green-100 text-green-800';
    $barColor = 'bg-green-500';
} elseif ($riwayat['cf_percentage'] >= 40) {
    $statusLabel = 'CUKUP YAKIN';
    $statusBg = 'bg-green-100 text-green-800';
    $barColor = 'bg-green-500';
} else {
    $statusLabel = 'KURANG YAKIN';
    $statusBg = 'bg-green-100 text-green-800';
    $barColor = 'bg-green-500';
}

$detailGejala = !empty($riwayat['detail_gejala']) ? json_decode($riwayat['detail_gejala'], true) : [];
$gejalaDipilih = !empty($riwayat['gejala_dipilih']) ? json_decode($riwayat['gejala_dipilih'], true) : [];
?>

<div class="mb-4 no-print">
    <a href="<?= base_url('dashboard') ?>" class="inline-flex items-center gap-2 text-primary hover:text-primary/80 text-sm font-medium">
        <span class="material-symbols-outlined">arrow_back</span>
        Kembali ke Dashboard
    </a>
</div>

<div class="bg-white rounded-xl border-2 border-primary shadow-lg overflow-hidden riwayat-card" id="riwayat-card-<?= $riwayat['id_riwayat'] ?>">
    <div class="bg-primary text-white px-6 py-2 flex items-center gap-2">
        <span class="material-symbols-outlined">verified</span>
        <span class="font-bold">Diagnosa Utama - <?= $statusLabel ?> (<?= $riwayat['cf_percentage'] ?>%)</span>
    </div>
    
    <div class="p-6">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
            <div class="flex items-center gap-4">
                <?php 
                $db = \Config\Database::connect();
                $penyakitData = $db->table('penyakit')->where('nama_penyakit', $riwayat['nama_penyakit'])->get()->getRowArray();
                $gambar = $penyakitData['gambar'] ?? '';
                $gambarSrc = (!empty($gambar) && (strpos($gambar, 'http') === 0 || strpos($gambar, 'uploads/') === 0)) 
                    ? (strpos($gambar, 'http') === 0 ? $gambar : base_url($gambar)) 
                    : '';
                if (!empty($gambarSrc)): ?>
                <img src="<?= $gambarSrc ?>" alt="<?= esc($riwayat['nama_penyakit']) ?>" class="w-16 h-16 object-cover rounded-xl">
                <?php else: ?>
                <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-3xl">coronavirus</span>
                </div>
                <?php endif; ?>
                <div>
                    <span class="inline-flex items-center rounded-lg bg-red-100 text-red-700 text-xs font-bold px-2 py-1">HASIL UTAMA</span>
                    <h3 class="text-xl md:text-2xl font-bold text-primary mt-1"><?= esc($riwayat['nama_penyakit']) ?></h3>
                    <span class="text-sm text-slate-500"><?= esc($riwayat['kode_penyakit'] ?? '-') ?></span>
                </div>
            </div>
            <div class="text-left md:text-right">
                <div class="inline-flex items-center gap-2 px-4 py-2 <?= $statusBg ?> rounded-lg font-bold">
                    <span class="material-symbols-outlined text-xl">check_circle</span>
                    <?= number_format($riwayat['cf_percentage'], 2) ?>%
                </div>
            </div>
        </div>

        <div class="mb-4 text-sm text-slate-500 flex items-center gap-2 no-print">
            <span class="material-symbols-outlined text-sm">calendar_today</span>
            Tanggal: <?= date('d F Y, H:i', strtotime($riwayat['tanggal_diagnosa'])) ?>
        </div>

        <div class="mb-6">
            <div class="flex justify-between mb-2">
                <span class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Keyakinan Diagnosa</span>
                <span class="text-sm font-bold text-primary"><?= $keyakinan ?></span>
            </div>
            <div class="w-full bg-slate-200 rounded-full h-3">
                <div class="<?= $barColor ?> h-3 rounded-full transition-all" style="width: <?= $riwayat['cf_percentage'] ?>%"></div>
            </div>
        </div>

        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 mb-6">
            <div class="flex items-center gap-2 mb-3">
                <span class="material-symbols-outlined text-primary">description</span>
                <h4 class="font-bold text-slate-700">Definisi Penyakit</h4>
            </div>
            <p class="text-slate-600 text-sm leading-relaxed">
                <?= esc($riwayat['solusi'] ?? 'Penyakit ini menyerang tanaman jagung dan dapat menyebabkan kerugian signifikan jika tidak ditangani dengan tepat.') ?>
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
                    <span class="font-bold text-primary"><?= number_format($cf_hasil, 4) ?></span>
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
            ID Riwayat: <?= $riwayat['id_riwayat'] ?> | Metode: Certainty Factor (CF)
        </div>
        <div class="flex items-center gap-2 no-print">
            <button onclick="downloadPDF(<?= $riwayat['id_riwayat'] ?>)" 
                    class="flex items-center gap-1 px-2 py-1 text-slate-400 hover:text-primary hover:bg-primary/10 rounded transition-colors no-print">
                <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                <span>PDF</span>
            </button>
            <button onclick="showModalHapus('<?= base_url('riwayat/hapus/' . $riwayat['id_riwayat']) ?>')" 
                    class="flex items-center gap-1 px-2 py-1 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded transition-colors no-print">
                <span class="material-symbols-outlined text-sm">delete</span>
                <span class="no-print">Hapus</span>
            </button>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div id="modal-hapus" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl p-4 max-w-sm w-full mx-4">
        <div class="flex flex-col items-center text-center">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-3">
                <span class="material-symbols-outlined text-red-500 text-2xl">warning</span>
            </div>
            <h3 class="text-base font-bold text-slate-800 mb-2">Konfirmasi Hapus</h3>
            <p class="text-sm text-slate-600 mb-4">Apakah Anda yakin ingin menghapus riwayat ini?</p>
            <div class="flex gap-2 w-full">
                <button onclick="document.getElementById('modal-hapus').classList.add('hidden')" class="flex-1 px-3 py-2 border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors text-sm">
                    Tidak
                </button>
                <a id="btn-konfirmasi-hapus" href="" class="flex-1 px-3 py-2 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition-colors text-center text-sm">
                    Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function showModalHapus(url) {
    document.getElementById('btn-konfirmasi-hapus').href = url;
    document.getElementById('modal-hapus').classList.remove('hidden');
}

function downloadPDF(id) {
    document.querySelectorAll('.riwayat-card').forEach(card => {
        card.classList.add('print-hide');
    });
    document.getElementById('riwayat-card-' + id).classList.remove('print-hide');
    window.print();
    setTimeout(() => {
        document.querySelectorAll('.riwayat-card').forEach(card => {
            card.classList.remove('print-hide');
        });
    }, 100);
}
</script>
<style>
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