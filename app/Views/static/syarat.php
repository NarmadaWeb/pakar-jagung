<?= $this->extend('layouts/page') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Syarat dan Ketentuan CornAI.">
<?= $this->endSection() ?>

<?= $this->section('main_content') ?>
    <div class="flex flex-col gap-2 mb-10 pt-4">
        <h1 class="text-slate-900 text-2xl md:text-3xl font-bold">Syarat dan Ketentuan</h1>
        <div class="h-1.5 w-20 bg-primary rounded-full"></div>
    </div>
    <p class="text-slate-600 max-w-2xl">Dengan menggunakan layanan ini, Anda setuju untuk menggunakan sistem sesuai dengan panduan yang disediakan.</p>
<?= $this->endSection() ?>