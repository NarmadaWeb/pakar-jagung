<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Panel Manajemen Pengetahuan</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data penyakit, gejala, dan aturan CF</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-primary/10 rounded-lg">
                    <span class="material-symbols-outlined text-primary text-2xl">bug_report</span>
                </div>
                <div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Total Penyakit</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-slate-100"><?= count($penyakit) ?></p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-primary/10 rounded-lg">
                    <span class="material-symbols-outlined text-primary text-2xl">healing</span>
                </div>
                <div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Total Gejala</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-slate-100"><?= count($gejala) ?></p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-primary/10 rounded-lg">
                    <span class="material-symbols-outlined text-primary text-2xl">psychology</span>
                </div>
                <div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Total Aturan CF</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-slate-100"><?= count($rules) ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
        <div class="p-4 border-b border-slate-200 dark:border-slate-700">
            <div class="flex gap-2">
                <button onclick="showTab('penyakit')" id="tab-penyakit" class="tab-btn px-4 py-2 rounded-lg font-medium text-sm transition-colors bg-primary text-white">Penyakit</button>
                <button onclick="showTab('gejala')" id="tab-gejala" class="tab-btn px-4 py-2 rounded-lg font-medium text-sm transition-colors text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">Gejala</button>
                <button onclick="showTab('rules')" id="tab-rules" class="tab-btn px-4 py-2 rounded-lg font-medium text-sm transition-colors text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">Aturan CF</button>
            </div>
        </div>

        <div id="content-penyakit" class="tab-content p-4">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Gambar</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Kode</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Nama Penyakit</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Deskripsi</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Solusi</th>
                            <th class="text-center py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($penyakit)): ?>
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-500">Belum ada data penyakit</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($penyakit as $p): ?>
                        <tr class="border-b border-slate-100 dark:border-slate-700/50">
                            <td class="py-3 px-4">
                                <?php if (!empty($p['gambar'])): ?>
                                <img src="<?= $p['gambar'] ?>" class="w-12 h-12 object-cover rounded-lg" alt="gambar">
                                <?php else: ?>
                                <div class="w-12 h-12 bg-slate-200 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-slate-400">image</span>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 text-slate-900 dark:text-slate-100"><?= $p['kode_penyakit'] ?></td>
                            <td class="py-3 px-4 text-slate-900 dark:text-slate-100 font-medium"><?= $p['nama_penyakit'] ?></td>
                            <td class="py-3 px-4 text-slate-600 dark:text-slate-400 max-w-xs truncate"><?= $p['deskripsi'] ?? '-' ?></td>
                            <td class="py-3 px-4 text-slate-600 dark:text-slate-400 max-w-xs truncate"><?= $p['solusi'] ?? '-' ?></td>
                            <td class="py-3 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('penyakit/edit/' . $p['id_penyakit']) ?>" class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Edit">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a href="<?= base_url('penyakit/detail/' . $p['id_penyakit']) ?>" class="p-2 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="Detail">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="content-gejala" class="tab-content p-4 hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Kode</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 textsm">Nama Gejala</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Deskripsi</th>
                            <th class="text-center py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($gejala)): ?>
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-500">Belum ada data gejala</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($gejala as $g): ?>
                        <tr class="border-b border-slate-100 dark:border-slate-700/50">
                            <td class="py-3 px-4 text-slate-900 dark:text-slate-100"><?= $g['kode_gejala'] ?></td>
                            <td class="py-3 px-4 text-slate-900 dark:text-slate-100 font-medium"><?= $g['nama_gejala'] ?></td>
                            <td class="py-3 px-4 text-slate-600 dark:text-slate-400"><?= $g['deskripsi'] ?? '-' ?></td>
                            <td class="py-3 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('gejala/edit/' . $g['id_gejala']) ?>" class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Edit">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="content-rules" class="tab-content p-4 hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">ID</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Penyakit</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Gejala</th>
                            <th class="text-center py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">MB</th>
                            <th class="text-center py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">MD</th>
                            <th class="text-center py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rules)): ?>
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500">Belum ada aturan CF</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($rules as $r): ?>
                        <tr class="border-b border-slate-100 dark:border-slate-700/50">
                            <td class="py-3 px-4 text-slate-900 dark:text-slate-100"><?= $r['id_rule'] ?></td>
                            <td class="py-3 px-4 text-slate-900 dark:text-slate-100"><?= $r['kode_penyakit'] ?> - <?= $r['nama_penyakit'] ?></td>
                            <td class="py-3 px-4 text-slate-900 dark:text-slate-100"><?= $r['kode_gejala'] ?> - <?= $r['nama_gejala'] ?></td>
                            <td class="py-3 px-4 text-center text-slate-900 dark:text-slate-100"><?= $r['mb'] ?></td>
                            <td class="py-3 px-4 text-center text-slate-900 dark:text-slate-100"><?= $r['md'] ?></td>
                            <td class="py-3 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('basis-pengetahuan/edit/' . $r['id_rule']) ?>" class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Edit">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.classList.remove('bg-primary', 'text-white');
        el.classList.add('text-slate-600', 'dark:text-slate-300');
    });
    
    document.getElementById('content-' + tab).classList.remove('hidden');
    document.getElementById('tab-' + tab).classList.add('bg-primary', 'text-white');
    document.getElementById('tab-' + tab).classList.remove('text-slate-600', 'dark:text-slate-300');
}
</script>
<?= $this->endSection() ?>