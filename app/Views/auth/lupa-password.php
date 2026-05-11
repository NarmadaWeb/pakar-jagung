<?= $this->extend('layouts/auth') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Lupa Password - CornAI">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-full mb-4">
            <span class="material-symbols-outlined text-primary text-4xl">lock_reset</span>
        </div>
        <h1 class="text-2xl font-black text-slate-900">Lupa Password?</h1>
        <p class="text-slate-600 mt-2">Masukkan email Anda untuk reset password</p>
    </div>

    <?php if (session('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= session('error') ?>
    </div>
    <?php endif; ?>

    <?php if (session('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <?= session('success') ?>
    </div>
    <?php endif; ?>

    <form action="<?= base_url('lupa-password') ?>" method="POST" class="space-y-5">
        <?= csrf_field() ?>
        
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <span class="material-symbols-outlined">email</span>
                </span>
                <input type="email" id="email" name="email" required
                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all"
                       placeholder="Masukkan email Anda">
            </div>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-primary to-green-600 hover:from-primary/90 hover:to-green-600/90 text-white font-bold py-3.5 px-4 rounded-xl transition-all transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
            <span class="flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">send</span>
                Kirim Link Reset
            </span>
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="<?= base_url('login') ?>" class="text-primary hover:text-primary-dark text-sm font-medium flex items-center justify-center gap-1">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali ke Login
        </a>
    </div>
</div>
<?= $this->endSection() ?>