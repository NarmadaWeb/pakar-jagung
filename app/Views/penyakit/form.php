<?= $this->extend('layouts/admin') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Form tambah/edit penyakit.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900"><?= $title ?></h1>
</div>

<?php if (session('error')): ?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= session('error') ?></div>
<?php endif; ?>

<?php 
$action = isset($penyakit) ? base_url('penyakit/edit/' . $penyakit['id_penyakit']) : base_url('penyakit/add');
?>
<form action="<?= $action ?>" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded-xl border border-slate-200 space-y-4 max-w-2xl">
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Penyakit</label>
        <input type="text" name="kode_penyakit" value="<?= isset($penyakit) ? esc($penyakit['kode_penyakit']) : '' ?>" required
               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
    </div>
    
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Penyakit</label>
        <input type="text" name="nama_penyakit" value="<?= isset($penyakit) ? esc($penyakit['nama_penyakit']) : '' ?>" required
               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
    </div>
    
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar Penyakit</label>
        <?php if (isset($penyakit) && isset($penyakit['gambar']) && !empty($penyakit['gambar'])): ?>
        <div class="mb-2">
            <img src="<?= base_url($penyakit['gambar']) ?>" alt="Gambar <?= esc($penyakit['nama_penyakit']) ?>" class="w-32 h-32 object-cover rounded-lg border">
        </div>
        <?php endif; ?>
        <div class="space-y-2">
            <input type="file" name="gambar" accept="image/jpeg,image/jpg,image/png,image/gif"
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <p class="text-xs text-slate-500">Atau gunakan URL gambar:</p>
            <input type="url" name="gambar_url" placeholder="https://contoh.com/gambar.jpg" 
                   value="<?= (isset($penyakit) && isset($penyakit['gambar'])) ? esc($penyakit['gambar']) : '' ?>"
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
        </div>
        <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, GIF (maks 2MB) atau masukkan URL gambar</p>
    </div>
    
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Solusi / Penanganan</label>
        <textarea name="solusi" rows="4" required
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"><?= isset($penyakit) ? esc($penyakit['solusi']) : '' ?></textarea>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Tindakan Segera</label>
        <textarea name="tindakan_segera" rows="3"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"><?= isset($penyakit) && isset($penyakit['tindakan_segera']) ? esc($penyakit['tindakan_segera']) : '' ?></textarea>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Protokol Pengobatan</label>
        <textarea name="protokol_pengobatan" rows="3"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"><?= isset($penyakit) && isset($penyakit['protokol_pengobatan']) ? esc($penyakit['protokol_pengobatan']) : '' ?></textarea>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Strategi Pencegahan</label>
        <textarea name="strategi_pencegahan" rows="3"
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"><?= isset($penyakit) && isset($penyakit['strategi_pencegahan']) ? esc($penyakit['strategi_pencegahan']) : '' ?></textarea>
    </div>
    
    <div class="flex gap-3 pt-2">
        <a href="<?= base_url('penyakit') ?>" class="px-6 py-2 border border-slate-300 rounded-lg font-semibold hover:bg-slate-50">Batal</a>
        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-primary/90">Simpan</button>
    </div>
</form>
<?= $this->endSection() ?>