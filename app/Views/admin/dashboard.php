<?= $this->extend('layouts/admin') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Admin Dashboard CornAI">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard Admin</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data sistem pakar deteksi penyakit jagung</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-500">
            <span class="material-symbols-outlined text-lg">calendar_today</span>
            <?= date('d M Y') ?>
        </div>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-2">
            <span class="material-symbols-outlined">check_circle</span>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-primary to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm">Total Penyakit</p>
                    <p class="text-4xl font-bold mt-1"><?= $totalPenyakit ?></p>
                </div>
                <div class="w-14 h-14 rounded-xl bg-white/20 flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">bug_report</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/20 flex items-center justify-between text-sm">
                <span class="text-white/70">Data penyakit</span>
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm">Total Gejala</p>
                    <p class="text-4xl font-bold mt-1"><?= $totalGejala ?></p>
                </div>
                <div class="w-14 h-14 rounded-xl bg-white/20 flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">healing</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/20 flex items-center justify-between text-sm">
                <span class="text-white/70">Data gejala</span>
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm">Total Rules</p>
                    <p class="text-4xl font-bold mt-1"><?= $totalRules ?></p>
                </div>
                <div class="w-14 h-14 rounded-xl bg-white/20 flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">library_books</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/20 flex items-center justify-between text-sm">
                <span class="text-white/70">Basis pengetahuan</span>
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </div>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">bolt</span>
            Quick Actions
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="<?= base_url('penyakit') ?>" class="flex items-center gap-4 p-5 bg-white rounded-xl border border-slate-200 hover:border-primary hover:shadow-md transition-all group">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-primary group-hover:text-white">bug_report</span>
                </div>
                <div>
                    <span class="font-semibold text-slate-800">Kelola Penyakit</span>
                    <p class="text-xs text-slate-500">Tambah,ubah,hapus data</p>
                </div>
            </a>
            <a href="<?= base_url('gejala') ?>" class="flex items-center gap-4 p-5 bg-white rounded-xl border border-slate-200 hover:border-blue-400 hover:shadow-md transition-all group">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-blue-600 group-hover:text-white">healing</span>
                </div>
                <div>
                    <span class="font-semibold text-slate-800">Kelola Gejala</span>
                    <p class="text-xs text-slate-500">Tambah,ubah,hapus data</p>
                </div>
            </a>
            <a href="<?= base_url('basis-pengetahuan') ?>" class="flex items-center gap-4 p-5 bg-white rounded-xl border border-slate-200 hover:border-amber-400 hover:shadow-md transition-all group">
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-amber-600 group-hover:text-white">library_books</span>
                </div>
                <div>
                    <span class="font-semibold text-slate-800">Basis Pengetahuan</span>
                    <p class="text-xs text-slate-500">Kelola aturan CF</p>
                </div>
            </a>
        </div>
    </div>

    <div>
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">info</span>
            Informasi Sistem
        </h2>
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">psychology</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-800">Metode Certainty Factor</h4>
                        <p class="text-sm text-slate-500 mt-1">Sistem menggunakan CF untuk menghitung tingkat kepastian diagnosa penyakit</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                        <span class="material-symbols-outlined">storage</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-800">Database</h4>
                        <p class="text-sm text-slate-500 mt-1"><?= $totalPenyakit ?> penyakit, <?= $totalGejala ?> gejala, <?= $totalRules ?> rules</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>