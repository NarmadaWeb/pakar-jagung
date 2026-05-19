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
    <title><?= $title ?? 'Admin - CornAI' ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100">
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

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700 flex flex-col fixed h-full z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <a href="<?= base_url('/') ?>" class="flex items-center gap-3 text-primary">
                    <span class="material-symbols-outlined text-3xl font-bold">eco</span>
                    <span class="text-xl font-bold">CornAI</span>
                </a>
                <p class="text-sm text-slate-500 mt-1">Panel Admin</p>
            </div>
            
            <?php
            $uri = service('uri');
            $currentUri = $uri->getPath();
            
            $isLibraryActive = str_starts_with($currentUri, 'admin/library') || 
                              str_starts_with($currentUri, 'penyakit') || 
                              str_starts_with($currentUri, 'gejala') || 
                              str_starts_with($currentUri, 'basis-pengetahuan');
            ?>
            
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <!-- Dashboard -->
                <a href="<?= base_url('admin') ?>" class="<?= $currentUri === 'admin' ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' ?> flex items-center gap-3 px-4 py-3 rounded-lg transition-colors" onclick="closeSidebarOnMobile()">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <!-- Riwayat Sistem -->
                <a href="<?= base_url('admin/riwayat') ?>" class="<?= str_starts_with($currentUri, 'admin/riwayat') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' ?> flex items-center gap-3 px-4 py-3 rounded-lg transition-colors" onclick="closeSidebarOnMobile()">
                    <span class="material-symbols-outlined">history</span>
                    <span class="font-medium">Riwayat Sistem</span>
                </a>
                
                <!-- Panel Manajemen Pengetahuan (Collapsible) -->
                <div class="pt-2">
                    <button onclick="toggleSubmenu('manajemen-pengetahuan')" class="<?= $isLibraryActive ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' ?> flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined">library_books</span>
                            <span class="font-medium">Manajemen Pengetahuan</span>
                        </div>
                        <span id="manajemen-pengetahuan-icon" class="material-symbols-outlined text-sm transition-transform <?= $isLibraryActive ? 'rotate-180' : '' ?>">expand_more</span>
                    </button>
                    
                    <div id="manajemen-pengetahuan-submenu" class="ml-4 mt-1 space-y-1 <?= $isLibraryActive ? '' : 'hidden' ?>">
                        <!-- Penyakit -->
                        <a href="<?= base_url('penyakit') ?>" class="<?= str_starts_with($currentUri, 'penyakit') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-slate-100 dark:hover:bg-slate-700' ?> flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm transition-colors" onclick="closeSidebarOnMobile()">
                            <span class="material-symbols-outlined text-lg">bug_report</span>
                            <span>Penyakit</span>
                        </a>
                        
                        <!-- Gejala -->
                        <a href="<?= base_url('gejala') ?>" class="<?= str_starts_with($currentUri, 'gejala') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-slate-100 dark:hover:bg-slate-700' ?> flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm transition-colors" onclick="closeSidebarOnMobile()">
                            <span class="material-symbols-outlined text-lg">healing</span>
                            <span>Gejala</span>
                        </a>
                        
                        <!-- Aturan CF -->
                        <a href="<?= base_url('basis-pengetahuan') ?>" class="<?= str_starts_with($currentUri, 'basis-pengetahuan') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-slate-100 dark:hover:bg-slate-700' ?> flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm transition-colors" onclick="closeSidebarOnMobile()">
                            <span class="material-symbols-outlined text-lg">psychology</span>
                            <span>Aturan CF</span>
                        </a>
                    </div>
                </div>
            </nav>
            
            <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                <a href="<?= base_url('logout') ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="font-medium">Logout</span>
                </a>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-4 pt-20 md:pt-8">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
    
    <script>
        function toggleSubmenu(id) {
            const submenu = document.getElementById(id + '-submenu');
            const icon = document.getElementById(id + '-icon');
            
            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                submenu.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }
        
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