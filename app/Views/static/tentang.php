<?= $this->extend('layouts/page') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Tentang CornAI - Sistem pakar berbasis AI untuk deteksi penyakit tanaman jagung.">
<?= $this->endSection() ?>

<?= $this->section('main_content') ?>
<div class="flex flex-col gap-2 mb-10 pt-4">
    <h1 class="text-slate-900 text-2xl md:text-3xl font-bold">Tentang Kami</h1>
    <div class="h-1.5 w-20 bg-primary rounded-full"></div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 shadow-sm">
    <div class="prose max-w-3xl">
        <p class="text-sm text-slate-600 mb-4">
            CornAI adalah sistem pakar berbasis kecerdasan buatan yang dirancang untuk membantu petani jagung Indonesia dalam mendeteksi penyakit tanaman secara cepat dan akurat.
        </p>
        
        <h3 class="text-base font-semibold text-slate-800 mb-2">Fitur Utama:</h3>
        <ul class="text-sm text-slate-600 space-y-2 mb-4">
            <li class="flex items-start gap-2">
                <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                <span>Deteksi penyakit tanaman jagung menggunakan metode Certainty Factor</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                <span>Database lengkap penyakit, gejala, dan aturan pakar</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                <span>Riwayat diagnosa untuk monitoring perkembangan tanaman</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                <span>Interface yang mudah digunakan untuk semua pengguna</span>
            </li>
        </ul>
        
        <h3 class="text-base font-semibold text-slate-800 mb-2">Teknologi:</h3>
        <p class="text-sm text-slate-600 mb-4">
            CornAI menggunakan metode Certainty Factor (CF) yang menggabungkan keyakinan user dengan keyakinan pakar untuk menghasilkan diagnosis yang akurat.
        </p>
        
        <h3 class="text-base font-semibold text-slate-800 mb-2">Tujuan:</h3>
        <p class="text-sm text-slate-600">
            Membantu petani jagung Indonesia dalam mengidentifikasi penyakit secara dini sehingga dapat ditangani dengan cepat dan tepat.
        </p>
    </div>
</div>
<?= $this->endSection() ?>