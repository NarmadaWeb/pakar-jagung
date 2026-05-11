<?= $this->extend('layouts/admin') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Form tambah/edit gejala.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900"><?= $title ?></h1>
</div>

<form method="post" class="bg-white p-6 rounded-xl border border-slate-200 space-y-4 max-w-2xl">
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Gejala</label>
        <input type="text" name="kode_gejala" value="<?= isset($gejala) ? esc($gejala['kode_gejala']) : '' ?>" required
               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
    </div>
    
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Gejala</label>
        <textarea name="nama_gejala" rows="3" required
                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"><?= isset($gejala) ? esc($gejala['nama_gejala']) : '' ?></textarea>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Bagian Tanaman</label>
        <select name="kategori" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <option value="">-- Pilih Bagian --</option>
            <option value="Daun" <?= isset($gejala) && $gejala['kategori'] == 'Daun' ? 'selected' : '' ?>>Daun</option>
            <option value="Batang" <?= isset($gejala) && $gejala['kategori'] == 'Batang' ? 'selected' : '' ?>>Batang</option>
            <option value="Tongkol" <?= isset($gejala) && $gejala['kategori'] == 'Tongkol' ? 'selected' : '' ?>>Tongkol</option>
            <option value="Biji" <?= isset($gejala) && $gejala['kategori'] == 'Biji' ? 'selected' : '' ?>>Biji</option>
            <option value="Umum" <?= isset($gejala) && $gejala['kategori'] == 'Umum' ? 'selected' : '' ?>>Umum</option>
        </select>
    </div>
    
    <div class="flex gap-3 pt-2">
        <a href="<?= base_url('gejala') ?>" class="px-6 py-2 border border-slate-300 rounded-lg font-semibold hover:bg-slate-50">Batal</a>
        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-primary/90">Simpan</button>
    </div>
</form>
<?= $this->endSection() ?>