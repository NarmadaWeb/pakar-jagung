<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Deteksi penyakit tanaman jagung berdasarkan gejala dengan metode Certainty Factor.">
<style>
    input[type="range"] {
        -webkit-appearance: none;
        appearance: none;
        height: 8px;
        border-radius: 9999px;
        outline: none;
    }
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #56995c;
        cursor: pointer;
        border: 3px solid white;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }
    input[type="range"]::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #56995c;
        cursor: pointer;
        border: 3px solid white;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }
    .gejala-card.selected {
        border-color: #56995c !important;
    }
    .gejala-card.selected .card-icon-wrap {
        background-color: rgba(86, 153, 92, 0.15) !important;
        color: #56995c !important;
    }
    .gejala-card.selected .card-check {
        display: flex !important;
    }
    .gejala-card.selected .slider-container {
        display: block !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Diagnosa Kesehatan Jagung</h1>
            <p class="text-slate-500 text-base max-w-2xl leading-relaxed">
                Pilih gejala yang diamati untuk mengidentifikasi penyakit potensial menggunakan Sistem Pakar kami.
                Sesuaikan tingkat keyakinan untuk hasil yang lebih akurat.
            </p>
        </div>

        <!-- Info Box -->
        <div class="bg-primary/5 border border-primary/20 p-4 rounded-2xl mb-6 flex items-start gap-3">
            <span class="material-symbols-outlined text-primary text-xl mt-0.5">info</span>
            <div>
                <h3 class="font-bold text-slate-800 text-sm mb-1">Tabel Kepastian (MB/MD)</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-x-6 gap-y-1 text-sm text-slate-600">
                    <div class="flex items-center gap-1.5"><span class="font-bold text-red-500">0</span> - Tidak ada</div>
                    <div class="flex items-center gap-1.5"><span class="font-bold text-red-500">0.2</span> - Tidak Tau</div>
                    <div class="flex items-center gap-1.5"><span class="font-bold text-orange-500">0.4</span> - Sedikit Yakin</div>
                    <div class="flex items-center gap-1.5"><span class="font-bold text-yellow-500">0.6</span> - Cukup Yakin</div>
                    <div class="flex items-center gap-1.5"><span class="font-bold text-blue-500">0.8</span> - Yakin</div>
                    <div class="flex items-center gap-1.5"><span class="font-bold text-green-600">1</span> - Sangat Yakin</div>
                </div>
            </div>
        </div>

        <form action="<?= base_url('deteksi/proses') ?>" method="post" id="gejalaForm">
            <!-- Input Nama -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 mb-6 shadow-sm">
                <label for="nama_user" class="block text-sm font-bold text-slate-800 mb-2">
                    Nama Anda <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama_user" name="nama_user" placeholder="Masukkan nama Anda..." required
                       class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-slate-700"
                       oninvalid="this.setCustomValidity('Nama wajib diisi sebelum melakukan diagnosa')" oninput="this.setCustomValidity('')">
                <p class="text-xs text-slate-400 mt-1">Nama akan ditampilkan pada riwayat diagnosa.</p>
            </div>

        <!-- Category Quick Nav -->
        <div class="flex flex-wrap gap-2 mb-6">
            <?php foreach ($gejala_grouped as $kategori => $gejalaList): ?>
            <button type="button" onclick="scrollToKategori('<?= esc($kategori) ?>')"
                    class="kategori-btn px-4 py-2 text-sm font-bold rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-primary hover:text-white hover:border-primary transition-all shadow-sm">
                <?= esc($kategori) ?> <span class="text-xs opacity-70">(<?= count($gejalaList) ?>)</span>
            </button>
            <?php endforeach; ?>
        </div>

        <?php foreach ($gejala_grouped as $kategori => $gejalaList): ?>
            <div id="kategori-<?= esc($kategori) ?>" class="mb-8 scroll-mt-24">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">category</span>
                    <?= esc($kategori) ?>
                    <span class="text-xs font-normal text-slate-400">(<?= count($gejalaList) ?> gejala)</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach ($gejalaList as $g): ?>
                    <?php
                        $desc = strtolower($g['nama_gejala']);
                        if (strpos($desc, 'daun') !== false) $icon = 'eco';
                        elseif (strpos($desc, 'batang') !== false) $icon = 'account_tree';
                        elseif (strpos($desc, 'akar') !== false) $icon = 'psychology_alt';
                        elseif (strpos($desc, 'tumbuh') !== false || strpos($desc, 'kerdil') !== false) $icon = 'trending_down';
                        elseif (strpos($desc, 'biji') !== false || strpos($desc, 'tongkol') !== false) $icon = 'grass';
                        else $icon = 'coronavirus';
                    ?>
                    <div id="gejala-<?= $g['id_gejala'] ?>"
                         class="gejala-card group relative flex flex-col gap-3 rounded-2xl border-2 border-transparent bg-white p-5 shadow-sm transition-all cursor-pointer hover:border-primary/40 hover:shadow-md"
                         onclick="toggleGejala(<?= $g['id_gejala'] ?>)">

                        <!-- Checkmark -->
                        <div class="card-check absolute top-4 right-4 hidden">
                            <div class="size-6 rounded-full bg-primary flex items-center justify-center text-white">
                                <span class="material-symbols-outlined text-sm font-bold">check</span>
                            </div>
                        </div>

                        <!-- Hidden form inputs -->
                        <input type="checkbox" name="gejala[]" value="<?= $g['id_gejala'] ?>"
                               class="gejala-checkbox hidden" id="cb-<?= $g['id_gejala'] ?>">

                        <div class="flex items-start gap-4">
                            <div class="card-icon-wrap p-3 rounded-xl bg-slate-100 text-slate-500 transition-colors">
                                <span class="material-symbols-outlined text-2xl"><?= $icon ?></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-bold mb-0.5 text-slate-800"><?= esc($g['kode_gejala']) ?></h3>
                                <p class="text-sm text-slate-500 leading-relaxed"><?= esc($g['nama_gejala']) ?></p>
                            </div>
                        </div>

                        <!-- Slider -->
                        <div class="slider-container hidden mt-2 pt-3 border-t border-slate-100" onclick="event.stopPropagation()">
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Tingkat Keyakinan</label>
                                <span id="conf-val-<?= $g['id_gejala'] ?>" class="text-sm font-bold text-primary">0.6</span>
                            </div>
                            <input class="w-full bg-slate-200 rounded-lg cursor-pointer"
                                type="range" min="0" max="1" step="0.2" value="0.6"
                                id="slider-<?= $g['id_gejala'] ?>"
                                oninput="updateKeyakinan(<?= $g['id_gejala'] ?>, this.value)">
                            <input type="hidden" name="kepastian[<?= $g['id_gejala'] ?>]" value="0.6"
                                   id="kepastian-<?= $g['id_gejala'] ?>" disabled>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 py-6 border-t border-slate-200 mt-4">
                <a href="<?= base_url('/') ?>" class="w-full sm:w-auto px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-colors flex items-center justify-center gap-2 bg-white shadow-sm">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Kembali
                </a>
                <div class="flex gap-3 w-full sm:w-auto">
                    <button type="button" onclick="resetForm()" class="flex-1 sm:flex-none px-6 py-3 rounded-xl font-bold border border-slate-200 hover:bg-slate-50 flex items-center justify-center gap-2 transition-all bg-white shadow-sm text-slate-600">
                        <span class="material-symbols-outlined">refresh</span>
                        Reset
                    </button>
                    <button type="submit" id="btn-diagnosa" class="flex-1 sm:flex-none px-8 py-3 rounded-xl bg-primary hover:bg-primary-dark text-white font-bold shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                        Proses Diagnosa
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let gejalaDipilih = {};

    function toggleGejala(id) {
        const card = document.getElementById(`gejala-${id}`);
        const cb = document.getElementById(`cb-${id}`);
        const kepInput = document.getElementById(`kepastian-${id}`);
        const slider = document.getElementById(`slider-${id}`);

        if (gejalaDipilih[id] !== undefined) {
            // Deselect
            delete gejalaDipilih[id];
            card.classList.remove('selected');
            cb.checked = false;
            kepInput.disabled = true;
        } else {
            // Select
            gejalaDipilih[id] = 0.6;
            card.classList.add('selected');
            cb.checked = true;
            kepInput.disabled = false;
            kepInput.value = '0.6';
            slider.value = 0.6;
            document.getElementById(`conf-val-${id}`).innerText = '0.6';
        }
    }

    function updateKeyakinan(id, val) {
        gejalaDipilih[id] = parseFloat(val);
        document.getElementById(`conf-val-${id}`).innerText = val;
        document.getElementById(`kepastian-${id}`).value = val;
    }

    function scrollToKategori(kategori) {
        const element = document.getElementById('kategori-' + kategori);
        if (element) {
            const headerOffset = 80;
            const elementPosition = element.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
            window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
        }
    }

    function resetForm() {
        Object.keys(gejalaDipilih).forEach(id => {
            const card = document.getElementById(`gejala-${id}`);
            const cb = document.getElementById(`cb-${id}`);
            const kepInput = document.getElementById(`kepastian-${id}`);
            if (card) card.classList.remove('selected');
            if (cb) cb.checked = false;
            if (kepInput) kepInput.disabled = true;
        });
        gejalaDipilih = {};
    }

    // Form validation
    document.getElementById('gejalaForm').addEventListener('submit', function(e) {
        if (Object.keys(gejalaDipilih).length === 0) {
            e.preventDefault();
            alert('Pilih setidaknya satu gejala.');
        }
    });
</script>
<?= $this->endSection() ?>