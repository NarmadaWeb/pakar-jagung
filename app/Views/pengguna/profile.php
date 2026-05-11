<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Profil saya - CornAI">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Profil Saya</h1>
    <p class="text-slate-500 text-sm mt-1">Informasi akun</p>
</div>

<!-- Profile Card -->
<div class="bg-white rounded-xl border-2 border-primary shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-primary to-green-600 px-6 py-8">
        <div class="flex items-center gap-4">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined text-primary text-4xl">person</span>
            </div>
            <div class="text-white">
                <h2 class="text-2xl font-bold"><?= esc($user['nama_lengkap']) ?></h2>
                <p class="opacity-90"><?= esc($user['username']) ?></p>
            </div>
        </div>
    </div>

    <div class="p-6">
        <div class="space-y-4">
            <div class="flex items-center justify-between py-3 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-slate-400">badge</span>
                    <span class="text-slate-600">Nama Lengkap</span>
                </div>
                <span class="font-semibold text-slate-800"><?= esc($user['nama_lengkap']) ?></span>
            </div>

            <div class="flex items-center justify-between py-3 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-slate-400">alternate_email</span>
                    <span class="text-slate-600">Username</span>
                </div>
                <span class="font-semibold text-slate-800"><?= esc($user['username']) ?></span>
            </div>

            <div class="flex items-center justify-between py-3 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-slate-400">email</span>
                    <span class="text-slate-600">Email</span>
                </div>
                <span class="font-semibold text-slate-800"><?= esc($user['email']) ?></span>
            </div>

            <div class="flex items-center justify-between py-3 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-slate-400">admin_panel_settings</span>
                    <span class="text-slate-600">Role</span>
                </div>
                <span class="inline-flex items-center rounded-lg bg-primary/10 text-primary font-bold px-3 py-1">
                    <?= $user['role'] === 'admin' ? 'Administrator' : 'Pengguna' ?>
                </span>
            </div>

            <div class="flex items-center justify-between py-3">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-slate-400">calendar_month</span>
                    <span class="text-slate-600">Bergabung</span>
                </div>
                <span class="font-semibold text-slate-800"><?= esc($user['created_at']) ?></span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>