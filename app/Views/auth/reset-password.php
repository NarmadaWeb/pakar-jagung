<?= $this->extend('layouts/auth') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Reset Password - CornAI">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-full mb-4">
            <span class="material-symbols-outlined text-primary text-4xl">lock_reset</span>
        </div>
        <h1 class="text-2xl font-black text-slate-900">Reset Password</h1>
        <p class="text-slate-600 mt-2">Masukkan password baru Anda</p>
    </div>

    <?php if (session('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= session('error') ?>
    </div>
    <?php endif; ?>

    <form action="<?= base_url('reset-password') ?>" method="POST" class="space-y-5">
        <?= csrf_field() ?>
        <input type="hidden" name="token" value="<?= $token ?>">
        
        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <span class="material-symbols-outlined">lock</span>
                </span>
                <input type="password" id="password" name="password" required
                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all"
                       placeholder="Masukkan password baru">
            </div>
        </div>

        <div>
            <label for="confirm_password" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <span class="material-symbols-outlined">lock</span>
                </span>
                <input type="password" id="confirm_password" name="confirm_password" required
                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all"
                       placeholder="Konfirmasi password baru">
            </div>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-primary to-green-600 hover:from-primary/90 hover:to-green-600/90 text-white font-bold py-3.5 px-4 rounded-xl transition-all transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
            <span class="flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">save</span>
                Simpan Password
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