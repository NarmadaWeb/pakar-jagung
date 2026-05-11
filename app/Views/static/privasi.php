<?= $this->extend('layouts/page') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Kebijakan privasi CornAI.">
<?= $this->endSection() ?>

<?= $this->section('main_content') ?>
    <div class="flex flex-col gap-2 mb-10 pt-4">
        <h1 class="text-slate-900 text-2xl md:text-3xl font-bold">Kebijakan Privasi</h1>
        <div class="h-1.5 w-20 bg-primary rounded-full"></div>
    </div>
    <p class="text-slate-600 max-w-2xl">Kami menghargai privasi Anda. Data yang Anda masukkan hanya digunakan untuk proses diagnosa penyakit.</p>
<?= $this->endSection() ?>