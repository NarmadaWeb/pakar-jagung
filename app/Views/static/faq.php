<?= $this->extend('layouts/page') ?>

<?= $this->section('meta') ?>
<meta name="description" content="FAQ - Pertanyaan yang sering diajukan tentang sistem pakar CornAI.">
<?= $this->endSection() ?>

<?= $this->section('main_content') ?>
    <div class="flex flex-col gap-2 mb-10 pt-4">
        <h1 class="text-slate-900 text-2xl md:text-3xl font-bold">Frequently Asked Questions</h1>
        <div class="h-1.5 w-20 bg-primary rounded-full"></div>
    </div>
    
    <div class="space-y-4 max-w-2xl">
        <div class="bg-white p-6 rounded-xl border border-slate-200 hover:border-primary/30 transition-colors">
            <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">help</span>
                Apa itu CornAI?
            </h3>
            <p class="text-slate-600">CornAI adalah sistem pakar berbasis kecerdasan buatan untuk mendeteksi penyakit pada tanaman jagung.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 hover:border-primary/30 transition-colors">
            <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">help</span>
                Bagaimana cara menggunakan CornAI?
            </h3>
            <p class="text-slate-600">Anda dapat memilih gejala yang terlihat pada tanaman jagung, kemudian sistem akan memproses dan memberikan hasil diagnosa.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 hover:border-primary/30 transition-colors">
            <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">help</span>
                Apakah layanan ini gratis?
            </h3>
            <p class="text-slate-600">Ya, layanan CornAI sepenuhnya gratis untuk digunakan.</p>
        </div>
    </div>
<?= $this->endSection() ?>