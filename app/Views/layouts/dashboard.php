<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#56995c",
                        "primary-light": "#7cb87f",
                        "primary-dark": "#3d6b42",
                        "background-light": "#f6f7f6",
                        "background-dark": "#161c17",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <?= $this->renderSection('meta') ?>
    <title><?= $title ?? 'Dashboard - CornAI' ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100">
    <?php
    $currentUri = service('uri')->getPath();
    ?>
    
    <!-- Mobile Header -->
    <header class="md:hidden fixed top-0 left-0 right-0 z-40 bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between">
        <button onclick="toggleSidebar()" class="p-2 hover:bg-slate-100 rounded-lg">
            <span class="material-symbols-outlined text-2xl">menu</span>
        </button>
        <a href="<?= base_url('/') ?>" class="flex items-center gap-2">
            <span class="material-symbols-outlined text-2xl font-bold text-primary">eco</span>
            <span class="font-bold text-primary">CornAI</span>
        </a>
        <div class="w-10"></div>
    </header>

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="md:hidden fixed inset-0 bg-black/50 z-40 hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-0 h-full flex flex-col z-50 bg-white dark:bg-background-dark border-r border-slate-200 dark:border-slate-700 w-72 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
        <div class="p-4 border-b border-slate-100 dark:border-slate-700">
            <a href="<?= base_url('/') ?>" class="flex items-center gap-3">
                <span class="material-symbols-outlined text-3xl font-bold text-primary">eco</span>
                <h1 class="text-xl font-black text-primary">CornAI</h1>
            </a>
            <p class="text-sm text-slate-500 mt-1 font-medium">Sistem Pakar Jagung</p>
        </div>
        <nav class="flex-1 px-3 py-2 space-y-1 overflow-y-auto">
            <a class="flex items-center gap-3 px-3 py-3 <?= $currentUri === 'dashboard' ? 'bg-primary/10 text-primary border-r-4 border-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' ?> transition-all duration-200 text-base font-bold rounded-r" href="<?= base_url('dashboard') ?>" onclick="closeSidebarOnMobile()">
                <span class="material-symbols-outlined text-xl">dashboard</span>
                Dashboard
            </a>
            <a class="flex items-center gap-3 px-3 py-3 <?= str_starts_with($currentUri, 'deteksi') ? 'bg-primary/10 text-primary border-r-4 border-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' ?> transition-all duration-200 text-base font-bold rounded-r" href="<?= base_url('deteksi') ?>" onclick="closeSidebarOnMobile()">
                <span class="material-symbols-outlined text-xl">query_stats</span>
                Diagnosa
            </a>
            <a class="flex items-center gap-3 px-3 py-3 <?= str_starts_with($currentUri, 'riwayat') ? 'bg-primary/10 text-primary border-r-4 border-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' ?> transition-all duration-200 text-base font-bold rounded-r" href="<?= base_url('riwayat') ?>" onclick="closeSidebarOnMobile()">
                <span class="material-symbols-outlined text-xl">history</span>
                Riwayat Diagnosa
            </a>
            <?php if (session()->get('role') === 'admin'): ?>
            <a class="flex items-center gap-3 px-3 py-3 <?= str_starts_with($currentUri, 'admin') ? 'bg-primary/10 text-primary border-r-4 border-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' ?> transition-all duration-200 text-base font-bold rounded-r" href="<?= base_url('admin') ?>" onclick="closeSidebarOnMobile()">
                <span class="material-symbols-outlined text-xl">admin_panel_settings</span>
                Panel Admin
            </a>
            <?php endif; ?>
        </nav>
        <div class="p-4 border-t border-slate-100 dark:border-slate-700">
            <a href="<?= base_url('profile') ?>" class="flex items-center gap-3 mb-4 hover:bg-slate-50 p-2 rounded-lg transition-colors">
                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-2xl">person</span>
                </div>
                <div>
                    <p class="font-bold text-lg"><?= session()->get('nama_lengkap') ?? session()->get('username') ?></p>
                    <p class="text-base text-slate-500"><?= session()->get('role') === 'admin' ? 'Administrator' : 'Pengguna' ?></p>
                </div>
            </a>
            <a href="<?= base_url('logout') ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                <span class="material-symbols-outlined text-xl">logout</span>
                <span class="font-semibold text-base">Logout</span>
            </a>
        </div>
    </aside>
    
    <main class="md:ml-72 min-h-screen bg-background-light dark:bg-background-dark pt-16 md:pt-0">
        <!-- Content Area -->
        <div class="p-4 md:p-6 max-w-full mx-auto">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
        
        function closeSidebarOnMobile() {
            if (window.innerWidth < 768) {
                toggleSidebar();
            }
        }
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>