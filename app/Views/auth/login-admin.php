<?= $this->extend('layouts/auth') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Login admin CornAI.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="w-full max-w-md px-4 py-8">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8 border border-primary/10">
        <div class="text-center mb-8">
            <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-3 text-primary mb-4">
                <span class="material-symbols-outlined text-4xl font-bold">eco</span>
                <span class="text-2xl font-bold">CornAI</span>
            </a>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Login Admin</h1>
            <p class="text-slate-600 dark:text-slate-400 mt-2">Masukkan kredensial untuk mengakses panel admin</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center gap-2">
                <span class="material-symbols-outlined">error</span>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center gap-2">
                <span class="material-symbols-outlined">check_circle</span>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/admin-login') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <div>
                <label for="username" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Username</label>
                <input type="text" id="username" name="username" required
                       class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                       placeholder="Masukkan username">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-colors pr-12"
                           placeholder="Masukkan password">
                    <button type="button" onclick="togglePassword('password', 'toggleIcon')" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                        <span id="toggleIcon" class="material-symbols-outlined">visibility</span>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-3 px-4 rounded-lg transition-all transform hover:scale-[1.02] shadow-lg">
                Masuk
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="<?= base_url('/') ?>" class="text-slate-600 dark:text-slate-400 hover:text-primary text-sm">Kembali ke Beranda</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }
</script>
<?= $this->endSection() ?>