<?= $this->extend('layouts/admin') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Form tambah/edit aturan CF.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900"><?= $title ?></h1>
</div>

<form action="<?= isset($rule) ? base_url('basis-pengetahuan/edit/' . $rule['id_rule']) : base_url('basis-pengetahuan/add') ?>" method="post" class="bg-white p-6 rounded-xl border border-slate-200 space-y-4 max-w-2xl">
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Penyakit</label>
        <select name="id_penyakit" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <option value="">-- Pilih Penyakit --</option>
            <?php foreach ($penyakit as $p): ?>
            <option value="<?= $p['id_penyakit'] ?>" <?= isset($rule) && $rule['id_penyakit'] == $p['id_penyakit'] ? 'selected' : '' ?>><?= esc($p['kode_penyakit']) ?> - <?= esc($p['nama_penyakit']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Gejala</label>
        <select name="id_gejala" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <option value="">-- Pilih Gejala --</option>
            <?php foreach ($gejala as $g): ?>
            <option value="<?= $g['id_gejala'] ?>" <?= isset($rule) && $rule['id_gejala'] == $g['id_gejala'] ? 'selected' : '' ?>><?= esc($g['kode_gejala']) ?> - <?= esc($g['nama_gejala']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Nilai CF (Certainty Factor)</label>
        <input type="number" name="cf" step="0.01" min="0.01" max="1.00" value="<?= isset($rule) ? number_format($rule['cf'], 2) : '0.50' ?>" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="0.01 - 1.00">
        <p class="text-xs text-slate-500 mt-1">Nilai kepastian antara 0.01 (sangat rendah) sampai 1.00 (sangat pasti)</p>
    </div>
    
    <div class="flex gap-3 pt-2">
        <a href="<?= base_url('basis-pengetahuan') ?>" class="px-6 py-2 border border-slate-300 rounded-lg font-semibold hover:bg-slate-50">Batal</a>
        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-primary/90">Simpan</button>
    </div>
</form>
<?= $this->endSection() ?>