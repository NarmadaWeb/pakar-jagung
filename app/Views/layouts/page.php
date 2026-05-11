<?= $this->extend('layouts/main') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Sistem pakar berbasis AI untuk mendeteksi penyakit pada tanaman jagung secara akurat dan cepat.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('partials/navbar') ?>

<main class="flex-1">
    <div class="px-4 md:px-20 pb-20 min-h-[calc(100vh-200px)]">
        <?= $this->renderSection('main_content') ?>
    </div>
</main>

<?= $this->include('partials/footer') ?>
<?= $this->endSection() ?>