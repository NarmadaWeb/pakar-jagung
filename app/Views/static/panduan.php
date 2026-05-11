<?= $this->extend('layouts/page') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Panduan penggunaan sistem pakar CornAI.">
<?= $this->endSection() ?>

<?= $this->section('main_content') ?>
    <div class="flex flex-col gap-2 mb-10 pt-4">
        <h1 class="text-slate-900 text-2xl md:text-3xl font-bold">Panduan Penggunaan</h1>
        <div class="h-1.5 w-20 bg-primary rounded-full"></div>
    </div>
    
    <div class="max-w-2xl">
        <div class="bg-white p-6 rounded-xl border border-slate-200 mb-6">
            <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">touch_app</span>
                Cara Menggunakan sistem
            </h3>
            <ol class="list-decimal list-inside space-y-4 text-slate-600">
                <li>Klik tombol "Mulai Deteksi" pada halaman utama</li>
                <li>Pilih gejala yang Anda temukan pada tanaman jagung</li>
                <li>Tentukan tingkat kepastian untuk setiap gejala</li>
                <li>Klik "Proses Diagnosa" untuk melihat hasil</li>
                <li>Hasil akan menampilkan kemungkinan penyakit beserta definisi penyakit</li>
            </ol>
        </div>
    </div>
<?= $this->endSection() ?>