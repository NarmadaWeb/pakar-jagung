<?php
$uri = service('uri');
$segments = $uri->getSegments();
$breadcrumb = [['title' => 'Beranda', 'url' => base_url('/')]];

$pageTitles = [
    'katalog' => 'Katalog',
    'deteksi' => 'Deteksi',
    'tentang' => 'Tentang Kami',
    'kontak' => 'Kontak',
    'faq' => 'FAQ',
    'panduan' => 'Panduan',
    'privasi' => 'Kebijakan Privasi',
    'syarat' => 'Syarat & Ketentuan',
    'penyakit' => 'Data Penyakit',
    'gejala' => 'Data Gejala',
    'basis-pengetahuan' => 'Basis Pengetahuan',
    'library' => 'Library',
    'riwayat' => 'Riwayat',
];

foreach ($segments as $segment) {
    if (isset($pageTitles[$segment])) {
        $breadcrumb[] = ['title' => $pageTitles[$segment], 'url' => base_url($segment)];
    }
}
?>

<div class="flex items-center gap-2 mb-6 text-sm no-print">
    <?php foreach ($breadcrumb as $index => $item): ?>
        <?php if ($index > 0): ?>
            <span class="text-slate-400">/</span>
        <?php endif; ?>
        <?php if ($index < count($breadcrumb) - 1): ?>
            <a href="<?= $item['url'] ?>" class="text-slate-500 hover:text-primary transition-colors"><?= $item['title'] ?></a>
        <?php else: ?>
            <span class="text-primary font-semibold"><?= $item['title'] ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
</div>