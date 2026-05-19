<?= $this->extend('layouts/page') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Library - Database lengkap penyakit, gejala, dan aturan CF sistem pakar jagung.">
<?= $this->endSection() ?>

<?= $this->section('main_content') ?>
    <div class="flex flex-col gap-2 mb-6 pt-4">
        <h1 class="text-slate-900 text-2xl md:text-3xl font-bold">Library</h1>
        <div class="h-1.5 w-20 bg-primary rounded-full"></div>
        <p class="text-slate-600 text-sm">Database lengkap pengetahuan tentang penyakit tanaman jagung</p>
    </div>

    <!-- Tabs -->
    <div class="flex gap-2 mb-6 border-b border-slate-200 overflow-x-auto">
        <button onclick="showTab('penyakit')" id="tab-penyakit" class="px-4 py-2 text-primary font-semibold border-b-2 border-primary whitespace-nowrap text-sm">Penyakit</button>
        <button onclick="showTab('gejala')" id="tab-gejala" class="px-4 py-2 text-slate-500 font-semibold hover:text-primary whitespace-nowrap text-sm">Gejala</button>
        <button onclick="showTab('cf')" id="tab-cf" class="px-4 py-2 text-slate-500 font-semibold hover:text-primary whitespace-nowrap text-sm">Aturan CF</button>
    </div>

    <!-- Penyakit Table -->
    <div id="penyakit" class="tab-content">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($penyakit as $p): ?>
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <?php 
                $imgSrc = (!empty($p['gambar']) && (strpos($p['gambar'], 'http') === 0 || strpos($p['gambar'], 'uploads/') === 0)) 
                    ? (strpos($p['gambar'], 'http') === 0 ? $p['gambar'] : base_url($p['gambar'])) 
                    : '';
                ?>
                <?php if (!empty($imgSrc)): ?>
                <img src="<?= $imgSrc ?>" alt="<?= $p['nama_penyakit'] ?>" class="w-full h-56 object-cover">
                <?php else: ?>
                <div class="w-full h-56 bg-slate-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-slate-300 text-5xl">eco</span>
                </div>
                <?php endif; ?>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-medium text-slate-500"><?= $p['kode_penyakit'] ?></span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-2"><?= $p['nama_penyakit'] ?></h3>
                    <p class="text-sm text-slate-600 mb-4"><?= $p['solusi'] ?></p>
                    
                    <?php if (!empty($p['tindakan_segera'])): ?>
                    <div class="mb-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-red-500 text-lg">warning</span>
                            <span class="text-xs font-semibold text-red-700">Tindakan Segera</span>
                        </div>
                        <p class="text-xs text-red-600 leading-relaxed"><?= esc($p['tindakan_segera']) ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($p['protokol_pengobatan'])): ?>
                    <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-blue-500 text-lg">medical_services</span>
                            <span class="text-xs font-semibold text-blue-700">Protokol Pengobatan</span>
                        </div>
                        <p class="text-xs text-blue-600 leading-relaxed"><?= esc($p['protokol_pengobatan']) ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($p['strategi_pencegahan'])): ?>
                    <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-green-500 text-lg">shield</span>
                            <span class="text-xs font-semibold text-green-700">Strategi Pencegahan</span>
                        </div>
                        <p class="text-xs text-green-600 leading-relaxed"><?= esc($p['strategi_pencegahan']) ?></p>
                    </div>
                    <?php endif; ?>
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
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Nama Gejala</th>
                        <th class="px-6 py-4">Kategori</th>
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
                        <th class="px-6 py-4">Penyakit</th>
                        <th class="px-6 py-4">Gejala</th>
                        <th class="px-6 py-4">CF</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach ($rules as $r): ?>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-900"><?= $r['nama_penyakit'] ?? '-' ?></td>
                        <td class="px-6 py-4 text-slate-700"><?= $r['nama_gejala'] ?? '-' ?></td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700"><?= $r['cf'] ?? '-' ?></span>
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
<?= $this->endSection() ?>