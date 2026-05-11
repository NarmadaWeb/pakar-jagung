<?= $this->extend('layouts/page') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Katalog lengkap data penyakit, gejala, dan rules sistem pakar CornAI.">
<?= $this->endSection() ?>

<?= $this->section('main_content') ?>
    <div class="flex flex-col gap-3 mb-10">
        <h1 class="text-slate-900 text-3xl md:text-4xl font-black">Katalog</h1>
        <div class="h-1.5 w-20 bg-primary rounded-full"></div>
        <p class="text-slate-600">Data lengkap penyakit, gejala, dan rules pada sistem pakar Certainty Factor</p>
    </div>

    <!-- Tabs -->
    <div class="flex gap-2 mb-6 border-b border-slate-200 overflow-x-auto">
        <button onclick="showTab('penyakit')" id="tab-penyakit" class="px-4 py-2 text-primary font-semibold border-b-2 border-primary whitespace-nowrap">Penyakit</button>
        <button onclick="showTab('gejala')" id="tab-gejala" class="px-4 py-2 text-slate-500 font-semibold hover:text-primary whitespace-nowrap">Gejala</button>
        <button onclick="showTab('basis')" id="tab-basis" class="px-4 py-2 text-slate-500 font-semibold hover:text-primary whitespace-nowrap">Basis Pengetahuan</button>
    </div>

    <!-- Tabel Penyakit -->
    <div id="content-penyakit" class="tab-content">
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Kode</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Nama Penyakit</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Solusi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($penyakit as $p): ?>
                    <tr class="border-t border-slate-100 hover:bg-slate-50/50">
                        <td class="px-4 py-3 text-sm font-semibold text-primary"><?= esc($p['kode_penyakit']) ?></td>
                        <td class="px-4 py-3 text-sm font-medium"><?= esc($p['nama_penyakit']) ?></td>
                        <td class="px-4 py-3 text-sm text-slate-600"><?= esc($p['solusi']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Gejala -->
    <div id="content-gejala" class="tab-content hidden">
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Kode</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Nama Gejala</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gejala as $g): ?>
                    <tr class="border-t border-slate-100 hover:bg-slate-50/50">
                        <td class="px-4 py-3 text-sm font-semibold text-primary"><?= esc($g['kode_gejala']) ?></td>
                        <td class="px-4 py-3 text-sm"><?= esc($g['nama_gejala']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Basis Pengetahuan -->
    <div id="content-basis" class="tab-content hidden">
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Kode Penyakit</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Nama Penyakit</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Kode Gejala</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Nama Gejala</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rules as $r): ?>
                    <tr class="border-t border-slate-100 hover:bg-slate-50/50">
                        <td class="px-4 py-3 text-sm font-semibold text-primary"><?= esc($r['kode_penyakit']) ?></td>
                        <td class="px-4 py-3 text-sm"><?= esc($r['nama_penyakit']) ?></td>
                        <td class="px-4 py-3 text-sm font-semibold text-blue-600"><?= esc($r['kode_gejala']) ?></td>
                        <td class="px-4 py-3 text-sm"><?= esc($r['nama_gejala']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function showTab(tab) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.getElementById('content-' + tab).classList.remove('hidden');
        
        document.querySelectorAll('#tab-penyakit, #tab-gejala, #tab-basis').forEach(el => {
            el.classList.remove('text-primary', 'border-b-2', 'border-primary');
            el.classList.add('text-slate-500');
        });
        document.getElementById('tab-' + tab).classList.add('text-primary', 'border-b-2', 'border-primary');
        document.getElementById('tab-' + tab).classList.remove('text-slate-500');
    }
</script>
<?= $this->endSection() ?>