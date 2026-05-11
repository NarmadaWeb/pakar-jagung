<?= $this->extend('layouts/admin') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Detail penyakit <?= esc($detail['penyakit']['nama_penyakit']) ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Detail Penyakit</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 flex flex-col gap-6">
        <div class="rounded-2xl border border-primary/10 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-4">
                <span class="inline-flex w-fit items-center rounded-lg bg-primary/10 text-primary text-xs font-bold px-3 py-1 tracking-widest uppercase">
                    <?= esc($detail['penyakit']['kode_penyakit']) ?>
                </span>
                <h1 class="text-slate-900 text-3xl font-black leading-tight">
                    <?= esc($detail['penyakit']['nama_penyakit']) ?>
                </h1>
                <div class="h-1 w-16 bg-primary rounded-full"></div>
            </div>
        </div>

        <div class="rounded-2xl border border-primary/10 bg-white p-8 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-symbols-outlined">symptoms</span>
                </div>
                <h2 class="text-slate-900 text-xl font-bold">Gejala yang Terkait</h2>
            </div>

            <?php if (!empty($detail['gejala'])): ?>
            <div class="flex flex-col gap-3">
                <?php foreach ($detail['gejala'] as $g): ?>
                <div class="flex items-start gap-4 rounded-xl bg-slate-50 p-4">
                    <span class="inline-flex shrink-0 items-center rounded-lg bg-primary/10 text-primary text-xs font-bold px-2 py-1 mt-0.5 tracking-wider">
                        <?= esc($g['kode_gejala']) ?>
                    </span>
                    <div class="flex flex-col gap-1 flex-1">
                        <p class="text-slate-800 text-sm font-medium leading-relaxed">
                            <?= esc($g['nama_gejala']) ?>
                        </p>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="flex-1 h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full transition-all"
                                     style="width: <?= round(($g['cf'] ?? 0.5) * 100) ?>%"></div>
                            </div>
                            <span class="text-xs text-slate-500 font-semibold shrink-0">
                                CF: <?= number_format($g['cf'] ?? 0.5, 2) ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="text-slate-500 text-sm italic">Belum ada gejala yang terdaftar untuk penyakit ini.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="flex flex-col gap-6">
        <div class="rounded-2xl border border-primary/10 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <span class="material-symbols-outlined">menu_book</span>
                </div>
                <h2 class="text-slate-900 text-lg font-bold">Definisi Penyakit</h2>
            </div>
            <p class="text-slate-600 text-sm leading-relaxed">
                <?= esc($detail['penyakit']['solusi']) ?>
            </p>
        </div>

        <div class="rounded-2xl border border-primary/10 bg-white p-6 shadow-sm">
            <h2 class="text-slate-900 text-lg font-bold mb-4">Informasi</h2>
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500 text-sm">Kode Penyakit</span>
                    <span class="text-slate-900 text-sm font-bold"><?= esc($detail['penyakit']['kode_penyakit']) ?></span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500 text-sm">Jumlah Gejala</span>
                    <span class="text-slate-900 text-sm font-bold"><?= count($detail['gejala']) ?> gejala</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-slate-500 text-sm">Metode Deteksi</span>
                    <span class="text-slate-900 text-sm font-bold">Certainty Factor</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>