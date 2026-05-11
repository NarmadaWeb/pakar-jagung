<?php
$currentUri = service('uri')->getPath();
$isHome = ($currentUri === '' || $currentUri === '/');
?>

<!-- Top Navigation Bar -->
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-primary/10 px-6 md:px-20 py-4 bg-white dark:bg-background-dark sticky top-0 z-50">
    <div class="flex items-center gap-3 text-primary">
        <span class="material-symbols-outlined text-3xl font-bold">eco</span>
        <h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold leading-tight tracking-tight">CornAI</h2>
    </div>
    <div class="hidden md:flex flex-1 justify-end gap-12">
        <nav class="flex items-center gap-10">
            <a class="<?= $currentUri === '' || $currentUri === '/' ? 'text-primary border-b-2 border-primary' : 'text-slate-700 dark:text-slate-300' ?> text-sm font-semibold hover:text-primary transition-colors" href="<?= base_url('/') ?>">Beranda</a>
            <a class="<?= str_starts_with($currentUri, 'library') ? 'text-primary border-b-2 border-primary' : 'text-slate-700 dark:text-slate-300' ?> text-sm font-semibold hover:text-primary transition-colors" href="<?= base_url('library') ?>">Library</a>
            <a class="<?= str_starts_with($currentUri, 'riwayat') ? 'text-primary border-b-2 border-primary' : 'text-slate-700 dark:text-slate-300' ?> text-sm font-semibold hover:text-primary transition-colors" href="<?= base_url('riwayat') ?>">Riwayat</a>
            <a class="<?= $currentUri === 'tentang' ? 'text-primary border-b-2 border-primary' : 'text-slate-700 dark:text-slate-300' ?> text-sm font-semibold hover:text-primary transition-colors" href="<?= base_url('tentang') ?>">Tentang</a>
        </nav>
        <div class="flex items-center gap-3">
            <?php if (session()->get('isLoggedIn')): ?>
                <?php if (session()->get('role') === 'admin'): ?>
                    <a href="<?= base_url('admin') ?>" class="px-4 py-2 text-sm font-semibold text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition-colors">Admin Panel</a>
                <?php endif; ?>
                <a href="<?= base_url('logout') ?>" class="flex items-center justify-center w-9 h-9 rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition-colors" title="Logout">
                    <span class="material-symbols-outlined">logout</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <!-- Mobile Menu Button -->
    <button class="md:hidden text-slate-900 dark:text-slate-100" onclick="toggleMenu()">
        <span class="material-symbols-outlined text-3xl">menu</span>
    </button>
</header>

<!-- Mobile Menu -->
<div id="mobileMenu" class="hidden fixed inset-0 bg-white z-50 flex flex-col">
    <div class="flex justify-between items-center p-6 border-b border-slate-100">
        <a href="<?= base_url('/') ?>" class="flex items-center gap-3 text-primary">
            <span class="material-symbols-outlined text-3xl font-bold">eco</span>
            <h2 class="text-xl font-bold">CornAI</h2>
        </a>
        <button onclick="toggleMenu()" class="text-slate-900">
            <span class="material-symbols-outlined text-3xl">close</span>
        </button>
    </div>
<nav class="flex-1 p-6 flex flex-col gap-2">
        <a class="<?= $currentUri === '' || $currentUri === '/' ? 'text-primary bg-primary/5' : 'text-slate-700' ?> text-lg font-semibold px-4 py-3 rounded-lg hover:bg-slate-50" href="<?= base_url('/') ?>">Beranda</a>
        <a class="<?= str_starts_with($currentUri, 'library') ? 'text-primary bg-primary/5' : 'text-slate-700' ?> text-lg font-semibold px-4 py-3 rounded-lg hover:bg-slate-50" href="<?= base_url('library') ?>">Library</a>
        <a class="<?= str_starts_with($currentUri, 'riwayat') ? 'text-primary bg-primary/5' : 'text-slate-700' ?> text-lg font-semibold px-4 py-3 rounded-lg hover:bg-slate-50" href="<?= base_url('riwayat') ?>">Riwayat</a>
        <a class="<?= $currentUri === 'tentang' ? 'text-primary bg-primary/5' : 'text-slate-700' ?> text-lg font-semibold px-4 py-3 rounded-lg hover:bg-slate-50" href="<?= base_url('tentang') ?>">Tentang</a>
    </nav>
    <div class="p-6 border-t border-slate-100">
        <?php if (session()->get('isLoggedIn')): ?>
            <a href="<?= base_url('dashboard') ?>" class="flex items-center justify-center gap-2 w-full px-4 py-3 mb-2 text-center text-sm font-semibold text-white bg-primary rounded-lg hover:bg-primary/90">
                <span class="material-symbols-outlined">dashboard</span>
                Dashboard
            </a>
            <a href="<?= base_url('logout') ?>" class="flex items-center justify-center gap-2 w-full px-4 py-3 text-center text-sm font-semibold text-red-600 border-2 border-red-600 rounded-lg hover:bg-red-50 transition-colors">
                <span class="material-symbols-outlined">logout</span>
                Logout
            </a>
        <?php endif; ?>
    </div>
</div>