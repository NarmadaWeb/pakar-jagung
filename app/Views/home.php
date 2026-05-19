<?= $this->extend('layouts/main') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Sistem pakar berbasis AI untuk mendeteksi penyakit pada tanaman jagung secara akurat dan cepat.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('partials/navbar') ?>

<main class="flex-1">

    <!-- Hero Section -->
    <div class="px-4 md:px-20 py-8">
        <div class="relative flex min-h-[520px] flex-col gap-6 items-center justify-center overflow-hidden rounded-xl bg-slate-900 p-8 text-center"
             style='background-image: linear-gradient(rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.7) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuDwUvwkI8JAHeLhBp7ZF6I1Pnu7Da2GO2NJcDWG-DuWccPk8zYZZSqmdUM8gg_vLUeWjm_S2KfVHLcZLa9Mo-Lxrzq8JXQZiOG0KthtfR3bet_6I8WdtBD8pRVdJfLxQDlrEjASQbW7pHn57Uc9Owf8MjeQG5JaX7gj2yw59bpIWFBmy0olUiJUJI63r1uUWiTX3IMiG9eRtE741ikbNJkKOf8xB7I30tTd1e4GjN3EfXtI7g_MZPc0FjX0JvsG2S7uBod9nAvMKZM"); background-size: cover; background-position: center;'>
            <div class="max-w-[800px] flex flex-col gap-4">
                <h1 class="text-white text-4xl md:text-6xl font-black leading-tight tracking-tight">
                    Deteksi Cepat Penyakit Jagung dengan AI
                </h1>
                <p class="text-slate-200 text-lg md:text-xl font-medium leading-relaxed">
                    Sistem pakar berbasis AI untuk membantu petani mengidentifikasi penyakit pada tanaman jagung secara akurat dan cepat.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 mt-4">
                <a href="<?= base_url('deteksi') ?>" class="flex items-center justify-center gap-2 rounded-lg bg-primary px-8 py-4 text-white text-lg font-bold shadow-lg hover:bg-primary/90 transition-all transform hover:scale-105">
                    <span class="material-symbols-outlined">photo_camera</span>
                    <span>Mulai Deteksi</span>
                </a>
                <a href="<?= base_url('riwayat') ?>" class="flex items-center justify-center gap-2 rounded-lg bg-white/10 backdrop-blur-md border border-white/20 px-8 py-4 text-white text-lg font-bold hover:bg-white/20 transition-all">
                    <span>Lihat Riwayat</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="px-4 md:px-20 py-16 bg-white dark:bg-background-dark/50">
        <div class="flex flex-col gap-4 mb-12">
            <span class="text-primary font-bold tracking-widest uppercase text-sm">Keunggulan Kami</span>
            <h2 class="text-slate-900 dark:text-slate-100 text-3xl md:text-4xl font-black leading-tight">
                Solusi Cerdas untuk Pertanian Modern
            </h2>
            <div class="h-1.5 w-20 bg-primary rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group flex flex-col gap-5 rounded-2xl border border-primary/10 bg-white dark:bg-slate-800 p-8 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-3xl">bolt</span>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="text-slate-900 dark:text-slate-100 text-xl font-bold">Deteksi Cepat & Akurat</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Pilih gejala yang terlihat pada tanaman jagung Anda, sistem akan mendeteksi penyakit dengan metode Certainty Factor dan memberikan hasil diagnosa dalam hitungan detik.
                    </p>
                </div>
            </div>
            <!-- Feature 2 -->
            <div class="group flex flex-col gap-5 rounded-2xl border border-primary/10 bg-white dark:bg-slate-800 p-8 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-3xl">menu_book</span>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="text-slate-900 dark:text-slate-100 text-xl font-bold">Database Penyakit Terlengkap</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Akses informasi lengkap 13+ penyakit tanaman jagung dengan gejala, penyebab, solusi penanganan, dan tindakan pencegahan.
                    </p>
                </div>
            </div>
            <!-- Feature 3 -->
            <div class="group flex flex-col gap-5 rounded-2xl border border-primary/10 bg-white dark:bg-slate-800 p-8 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-3xl">psychology</span>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="text-slate-900 dark:text-slate-100 text-xl font-bold">Solusi Penanganan</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Dapatkan rekomendasi penanganan dan pencegahan penyakit berdasarkan hasil diagnosa untuk menjaga produktivitas tanaman jagung Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>

    </main>

<?= $this->include('partials/footer') ?>
<?= $this->endSection() ?>