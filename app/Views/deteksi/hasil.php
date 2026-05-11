<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Hasil Diagnosa - CornAI">
<style>
@media print {
    .no-print { display: none !important; }
    body { background: white !important; }
    .print-container::before { content: "Laporan Diagnosa"; display: block; text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 10px; color: #56995c; }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex items-center justify-between gap-3 mb-4 no-print">
    <div class="flex items-center gap-2">
        <form action="<?= base_url('deteksi/simpan') ?>" method="POST">
            <?= csrf_field() ?>
            <button type="submit" class="flex items-center gap-2 px-3 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 text-sm">
                <span class="material-symbols-outlined text-lg">save</span>
                <span>Simpan</span>
            </button>
        </form>
        <a href="<?= base_url('deteksi/batal') ?>" class="flex items-center gap-2 px-3 py-2 bg-white border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 text-sm">
            <span class="material-symbols-outlined text-lg">close</span>
            <span>Batal</span>
        </a>
    </div>
</div>

<main class="print-container">
    <?php if (session('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= session('error') ?></div>
    <?php elseif (empty($hasil)): ?>
    <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-yellow-600 text-2xl">warning</span>
            <div>
                <h3 class="font-semibold text-yellow-800 text-sm">Tidak Ada Kecocokan</h3>
                <p class="text-yellow-700 text-xs">Gejala yang dipilih tidak cocok dengan penyakit manapun.</p>
            </div>
        </div>
        <a href="<?= base_url('deteksi') ?>" class="inline-block mt-3 bg-primary text-white px-4 py-2 rounded-lg font-semibold text-sm">Coba Lagi</a>
    </div>
    <?php else: ?>
    
    <section class="mb-4">
        <h2 class="text-xl md:text-2xl font-bold text-slate-900">Laporan Diagnosa</h2>
        <p class="text-slate-600 text-xs mt-1">Hasil analisis pada <?= date('d F Y, H:i') ?></p>
    </section>

    <div class="bg-blue-50 border border-blue-200 p-3 rounded-lg mb-4">
        <h3 class="font-semibold text-blue-800 flex items-center gap-2 text-sm">
            <span class="material-symbols-outlined text-lg">info</span>
            Tentang Metode Certainty Factor
        </h3>
        <p class="text-blue-700 text-xs mt-1">CF = Keyakinan User × Keyakinan Pakar. CFgab = CF1 + CF2(1-CF1).</p>
    </div>

    <?php 
    $utama = $hasil[0];
    $keyakinan = 'Rendah';
    if ($utama['persentase'] >= 75) $keyakinan = 'Sangat Kuat';
    elseif ($utama['persentase'] >= 50) $keyakinan = 'Kuat';
    elseif ($utama['persentase'] >= 25) $keyakinan = 'Sedang';
    
    if ($utama['persentase'] >= 80) {
        $statusLabel = 'SANGAT YAKIN';
        $statusBg = 'bg-green-100 text-green-800';
        $barColor = 'bg-green-500';
    } elseif ($utama['persentase'] >= 60) {
        $statusLabel = 'YAKIN';
        $statusBg = 'bg-blue-100 text-blue-800';
        $barColor = 'bg-blue-500';
    } elseif ($utama['persentase'] >= 40) {
        $statusLabel = 'CUKUP YAKIN';
        $statusBg = 'bg-yellow-100 text-yellow-800';
        $barColor = 'bg-yellow-500';
    } else {
        $statusLabel = 'KURANG YAKIN';
        $statusBg = 'bg-orange-100 text-orange-800';
        $barColor = 'bg-orange-500';
    }
    ?>

    <div class="bg-white rounded-xl border-2 border-primary shadow-lg overflow-hidden mb-4">
        <?php if ($utama['persentase'] >= 60): ?>
        <div class="bg-primary text-white px-4 py-2 flex items-center gap-2 text-sm">
            <span class="material-symbols-outlined text-lg">verified</span>
            <span class="font-bold">Diagnosa Utama - <?= $statusLabel ?> (<?= $utama['persentase'] ?>%)</span>
        </div>
        <?php endif; ?>
        
        <div class="p-4">
            <div class="flex items-center gap-3 mb-4">
                <?php 
                $gambar = $utama['penyakit']['gambar'] ?? '';
                $gambarSrc = (!empty($gambar) && (strpos($gambar, 'http') === 0 || strpos($gambar, 'uploads/') === 0)) 
                    ? (strpos($gambar, 'http') === 0 ? $gambar : base_url($gambar)) 
                    : '';
                ?>
                <?php if (!empty($gambarSrc)): ?>
                <img src="<?= $gambarSrc ?>?t=<?= time() ?>" class="w-12 h-12 object-cover rounded-lg" alt="gambar penyakit">
                <?php else: ?>
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-xl">coronavirus</span>
                </div>
                <?php endif; ?>
                <div>
                    <h3 class="text-base font-bold text-primary"><?= esc($utama['penyakit']['nama_penyakit']) ?></h3>
                    <span class="text-xs text-slate-500"><?= esc($utama['penyakit']['kode_penyakit']) ?></span>
                </div>
                <div class="ml-auto text-right">
                    <div class="inline-flex items-center gap-1 px-3 py-1 <?= $statusBg ?> rounded-lg font-bold text-sm">
                        <span class="material-symbols-outlined text-lg"><?= $utama['persentase'] >= 60 ? 'check_circle' : 'help' ?></span>
                        <?= number_format($utama['persentase'], 2) ?>%
                    </div>
                </div>
            </div>

            <div class="mb-3 text-xs font-semibold text-slate-600 uppercase">Keyakinan: <?= $keyakinan ?></div>
            <div class="w-full bg-slate-200 rounded-full h-2 mb-4">
                <div class="<?= $barColor ?> h-2 rounded-full transition-all" style="width: <?= $utama['persentase'] ?>%"></div>
            </div>

            <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 mb-4">
                <h4 class="font-semibold text-slate-700 mb-2 text-sm">Definisi Penyakit</h4>
                <p class="text-slate-600 text-xs"><?= esc($utama['penyakit']['solusi'] ?? '-') ?></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="bg-white border border-slate-200 rounded-lg p-3">
                    <h4 class="font-semibold text-slate-700 mb-3 text-sm">Gejala Terdeteksi</h4>
                    <div class="space-y-1">
                        <?php 
                        $db = \Config\Database::connect();
                        $gejalaMap = $db->table('gejala')->get()->getResultArray('id_gejala');
                        foreach ($gejalaDipilih as $id): 
                            $nama = isset($gejalaMap[$id]) ? $gejalaMap[$id]['nama_gejala'] : 'Gejala #'.$id;
                        ?>
                        <div class="flex items-center gap-2 p-1.5 bg-slate-50 rounded text-xs">
                            <span class="material-symbols-outlined text-blue-500 text-sm">check_circle</span>
                            <span class="text-slate-600"><?= esc($nama) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <?php 
                $gambarSrc2 = (!empty($gambar) && (strpos($gambar, 'http') === 0 || strpos($gambar, 'uploads/') === 0)) 
                    ? (strpos($gambar, 'http') === 0 ? $gambar : base_url($gambar)) 
                    : '';
                ?>
                <?php if (!empty($gambarSrc2)): ?>
                <div class="bg-white border border-slate-200 rounded-lg p-3">
                    <h4 class="font-semibold text-slate-700 mb-3 text-sm">Foto Penyakit</h4>
                    <div class="flex justify-center">
                        <img src="<?= $gambarSrc2 ?>?t=<?= time() ?>" class="max-h-32 rounded-lg" alt="foto penyakit">
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?= $this->endSection() ?>