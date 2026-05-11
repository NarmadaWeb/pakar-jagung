<?php if (session()->get('isLoggedIn')): ?>
<?= $this->extend('layouts/dashboard') ?>
<?php else: ?>
<?= $this->extend('layouts/page') ?>
<?php endif; ?>

<?= $this->section('meta') ?>
<meta name="description" content="Library - Database lengkap penyakit, gejala, dan aturan CF sistem pakar jagung.">
<?= $this->endSection() ?>

<?php if (session()->get('isLoggedIn')): ?>
<?= $this->section('content') ?>
<?php else: ?>
<?= $this->section('main_content') ?>
<?php endif; ?>
    <div class="flex flex-col gap-2 mb-10 pt-4">
        <h1 class="text-slate-900 text-2xl md:text-3xl font-bold">Library</h1>
        <div class="h-1.5 w-20 bg-primary rounded-full"></div>
        <p class="text-slate-600">Database lengkap pengetahuan tentang penyakit tanaman jagung</p>
    </div>

    <!-- Tabs -->
    <div class="flex gap-2 mb-4 border-b border-slate-200 overflow-x-auto">
        <button onclick="showTab('penyakit')" id="tab-penyakit" class="px-3 py-2 text-primary font-semibold border-b-2 border-primary whitespace-nowrap text-sm">Penyakit</button>
        <button onclick="showTab('gejala')" id="tab-gejala" class="px-3 py-2 text-slate-500 font-semibold hover:text-primary whitespace-nowrap text-sm">Gejala</button>
        <button onclick="showTab('cf')" id="tab-cf" class="px-3 py-2 text-slate-500 font-semibold hover:text-primary whitespace-nowrap text-sm">Aturan CF</button>
    </div>

    <!-- Penyakit Table -->
    <div id="penyakit" class="tab-content">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($penyakit as $p): ?>
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <?php 
                $imgSrc = (!empty($p['gambar']) && (strpos($p['gambar'], 'http') === 0 || strpos($p['gambar'], 'uploads/') === 0)) 
                    ? (strpos($p['gambar'], 'http') === 0 ? $p['gambar'] : base_url($p['gambar'])) 
                    : '';
                ?>
                <?php if (!empty($imgSrc)): ?>
                <img src="<?= $imgSrc ?>" alt="<?= $p['nama_penyakit'] ?>" class="w-full h-72 object-cover">
                <?php else: ?>
                <div class="w-full h-72 bg-slate-200 flex items-center justify-center">
                    <span class="material-symbols-outlined text-slate-400 text-6xl">eco</span>
                </div>
                <?php endif; ?>
                <div class="p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-medium text-slate-500"><?= $p['kode_penyakit'] ?></span>
                        <?php 
                        $jenis = strtolower($p['jenis_penyakit'] ?? 'Penyakit');
                        $color = str_contains($jenis, 'jamur') ? 'bg-yellow-100 text-yellow-700' : 
                                (str_contains($jenis, 'bakteri') ? 'bg-red-100 text-red-700' : 
                                (str_contains($jenis, 'virus') ? 'bg-purple-100 text-purple-700' : 
                                (str_contains($jenis, 'hama') ? 'bg-orange-100 text-orange-700' : 'bg-slate-100 text-slate-700')));
                        ?>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium <?= $color ?>"><?= $p['jenis_penyakit'] ?? 'Penyakit' ?></span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-2"><?= $p['nama_penyakit'] ?></h3>
                    <p class="text-sm text-slate-600"><?= $p['solusi'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Gejala Table -->
    <div id="gejala" class="tab-content hidden">
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Nama Gejala</th>
                        <th class="px-6 py-3">Kategori</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach ($gejala as $g): ?>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-900"><?= $g['kode_gejala'] ?? '-' ?></td>
                        <td class="px-6 py-4 text-slate-700"><?= $g['nama_gejala'] ?? '-' ?></td>
                        <td class="px-6 py-4 text-slate-500"><?= $g['kategori'] ?? '-' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Aturan CF Table -->
    <div id="cf" class="tab-content hidden">
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th class="px-6 py-3">Penyakit</th>
                        <th class="px-6 py-3">Gejala</th>
                        <th class="px-6 py-3">CF</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach ($rules as $r): ?>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-900"><?= $r['nama_penyakit'] ?? '-' ?></td>
                        <td class="px-6 py-4 text-slate-700"><?= $r['nama_gejala'] ?? '-' ?></td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700"><?= $r['nilai_cf'] ?? $r['cf'] ?? $r['nilai'] ?? '-' ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<script>
    function showTab(tab) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.getElementById(tab).classList.remove('hidden');
        
        document.querySelectorAll('#tab-penyakit, #tab-gejala, #tab-cf').forEach(el => {
            el.classList.remove('text-primary', 'border-b-2', 'border-primary');
            el.classList.add('text-slate-500');
        });
        document.getElementById('tab-' + tab).classList.add('text-primary', 'border-b-2', 'border-primary');
        document.getElementById('tab-' + tab).classList.remove('text-slate-500');
    }
</script>
<?php if (session()->get('isLoggedIn')): ?>
<?= $this->endSection() ?>
<?php else: ?>
<?= $this->endSection() ?>
<?php endif; ?>