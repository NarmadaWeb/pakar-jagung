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
                        "background-light": "#f6f7f6",
                        "background-dark": "#161c17",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"],
                    },
                },
            },
        }
    </script>
    <title>Dashboard - CornAI</title>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="<?= base_url('/') ?>" class="flex items-center gap-3 text-primary">
                    <span class="material-symbols-outlined text-3xl font-bold">eco</span>
                    <span class="text-xl font-bold">CornAI</span>
                </a>
                <div class="flex items-center gap-4">
                    <span class="text-slate-600 dark:text-slate-300">Halo, <strong><?= $user['nama_lengkap'] ?></strong></span>
                    <a href="<?= base_url('logout') ?>" class="flex items-center gap-2 px-4 py-2 rounded-lg text-red-600 hover:bg-red-50">
                        <span class="material-symbols-outlined">logout</span>
                        <span class="font-medium">Logout</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-bold mb-2">Dashboard Pengguna</h1>
            <p class="text-slate-600 dark:text-slate-400 mb-8">Selamat datang di CornAI, <?= $user['nama_lengkap'] ?>!</p>
            
            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center gap-2">
                    <span class="material-symbols-outlined">check_circle</span>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1: Deteksi -->
                <a href="<?= base_url('deteksi') ?>" class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-primary/10 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all group">
                    <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-primary text-3xl group-hover:text-white">photo_camera</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Deteksi Penyakit</h3>
                    <p class="text-slate-600 dark:text-slate-400">
                        Deteksi penyakit tanaman jagung dengan mengunggah foto daun.
                    </p>
                </a>

                <!-- Card 2: Katalog -->
                <a href="<?= base_url('katalog') ?>" class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-primary/10 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all group">
                    <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-primary text-3xl group-hover:text-white">menu_book</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Katalog Penyakit</h3>
                    <p class="text-slate-600 dark:text-slate-400">
                        Lihat informasi lengkap tentang penyakit dan gejala jagung.
                    </p>
                </a>

                <!-- Card 3: Panduan -->
                <a href="<?= base_url('panduan') ?>" class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-primary/10 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all group">
                    <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-primary text-3xl group-hover:text-white">help</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Panduan</h3>
                    <p class="text-slate-600 dark:text-slate-400">
                        Pelajari cara menggunakan sistem deteksi penyakit jagung.
                    </p>
                </a>
            </div>

            <div class="mt-12 bg-primary/5 rounded-xl p-6 border border-primary/10">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">tips_and_updates</span>
                    Tips Deteksi
                </h2>
                <ul class="space-y-3 text-slate-600 dark:text-slate-400">
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-primary mt-1">check_circle</span>
                        <span>Pastikan foto diambil dengan pencahayaan yang baik</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-primary mt-1">check_circle</span>
                        <span>Ambil foto dari jarak dekat untuk melihat detail gejala</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-primary mt-1">check_circle</span>
                        <span>Pilih semua gejala yang sesuai dengan kondisi tanaman</span>
                    </li>
                </ul>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-400 py-6 px-8 text-center text-sm">
            <p>&copy; 2026 CornAI Specialist System. Developed by Al Mushawwir.</p>
        </footer>
    </div>
</body>
</html>
