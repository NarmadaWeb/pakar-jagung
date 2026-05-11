<footer class="bg-slate-900 text-slate-400 py-12 px-6 md:px-20 border-t border-slate-800">
    <div class="flex flex-col md:flex-row justify-between gap-10">
        <div class="flex flex-col gap-4 max-w-xs">
            <div class="flex items-center gap-3 text-white">
                <span class="material-symbols-outlined text-3xl text-primary">eco</span>
                <span class="text-xl font-bold">CornAI</span>
            </div>
            <p class="text-sm">Membantu kedaulatan pangan melalui teknologi kecerdasan buatan untuk petani jagung Indonesia.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-8">
            <div class="flex flex-col gap-4">
                <h4 class="text-white font-bold">Navigasi</h4>
                <a class="hover:text-primary transition-colors" href="<?= base_url('/') ?>">Beranda</a>
                <a class="hover:text-primary transition-colors" href="<?= base_url('library') ?>">Library</a>
                <a class="hover:text-primary transition-colors" href="<?= base_url('riwayat') ?>">Riwayat</a>
                <a class="hover:text-primary transition-colors" href="<?= base_url('tentang') ?>">Tentang</a>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="text-white font-bold">Bantuan</h4>
                <a class="hover:text-primary transition-colors" href="<?= base_url('faq') ?>">FAQ</a>
                <a class="hover:text-primary transition-colors" href="<?= base_url('panduan') ?>">Panduan</a>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="text-white font-bold">Legal</h4>
                <a class="hover:text-primary transition-colors" href="<?= base_url('privasi') ?>">Privasi</a>
                <a class="hover:text-primary transition-colors" href="<?= base_url('syarat') ?>">Syarat</a>
            </div>
        </div>
    </div>
    <div class="mt-12 pt-8 border-t border-slate-800 text-center">
        <p class="text-sm">&copy; <?= date('Y') ?> CornAI Specialist System. Developed by Al Mushawwir.</p>
    </div>
</footer>