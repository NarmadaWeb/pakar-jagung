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
    <title>Login - CornAI</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <style>
        .login-bg {
            background: linear-gradient(135deg, rgba(86, 153, 92, 0.9) 0%, rgba(45, 90, 53, 0.95) 100%),
                        url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1920') center/cover;
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100">
    <div class="min-h-screen login-bg flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-3 text-white mb-6">
                    <span class="material-symbols-outlined text-5xl font-bold">eco</span>
                    <span class="text-3xl font-bold">CornAI</span>
                </a>
                <h1 class="text-white text-2xl font-bold">Sistem Pakar Deteksi Penyakit Jagung</h1>
                <p class="text-white/80 mt-2">Masuk ke akun Anda</p>
            </div>
            
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8 border border-white/20">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">error</span>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-600 rounded-xl flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">check_circle</span>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('auth/proses-login') ?>" method="POST" class="space-y-5">
                    <div>
                        <label for="username" class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <span class="material-symbols-outlined">person</span>
                            </span>
                            <input type="text" id="username" name="username" required
                                   class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all"
                                   placeholder="Masukkan username">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <span class="material-symbols-outlined">lock</span>
                            </span>
                            <input type="password" id="password" name="password" required
                                   class="w-full pl-12 pr-24 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all"
                                   placeholder="Masukkan password">
                            <button type="button" onclick="togglePassword()" 
                                    class="absolute right-16 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                                <span id="toggleIcon" class="material-symbols-outlined">visibility</span>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-primary to-green-600 hover:from-primary/90 hover:to-green-600/90 text-white font-bold py-3.5 px-4 rounded-xl transition-all transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                        <span class="flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">login</span>
                            Masuk
                        </span>
                    </button>
                    
                    <div class="text-center">
                        <a href="<?= base_url('lupa-password') ?>" class="text-primary hover:text-primary-dark text-sm font-medium">
                            Lupa Password?
                        </a>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-slate-200">
                    <p class="text-center text-slate-600 text-sm">
                        Belum punya akun?
                        <a href="<?= base_url('auth/register') ?>" class="text-primary hover:text-primary-dark font-semibold">Daftar Sekarang</a>
                    </p>
                </div>
            </div>

            <div class="text-center mt-6">
                <a href="<?= base_url('/') ?>" class="text-white/80 hover:text-white text-sm flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Kembali ke Beranda
                </a>
            </div>
            
            <p class="text-center text-white/60 text-xs mt-6">
                &copy; <?= date('Y') ?> CornAI - Sistem Pakar Pertanian
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>