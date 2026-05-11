<?= $this->extend('layouts/page') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Hubungi kami - CornAI sistem pakar deteksi penyakit jagung.">
<?= $this->endSection() ?>

<?= $this->section('main_content') ?>
    <div class="flex flex-col gap-2 mb-10 pt-4">
        <h1 class="text-slate-900 text-2xl md:text-3xl font-bold">Hubungi Kami</h1>
        <div class="h-1.5 w-20 bg-primary rounded-full"></div>
    </div>
    
    <div class="max-w-xl">
        <p class="text-slate-600 mb-6">Punya pertanyaan? Silakan hubungi kami melalui formulir di bawah ini.</p>
        <form class="flex flex-col gap-4">
            <input type="text" placeholder="Nama" class="p-3 border border-slate-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
            <input type="email" placeholder="Email" class="p-3 border border-slate-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
            <textarea placeholder="Pesan" rows="5" class="p-3 border border-slate-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all"></textarea>
            <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg font-bold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">send</span>
                Kirim Pesan
            </button>
        </form>
    </div>
<?= $this->endSection() ?>