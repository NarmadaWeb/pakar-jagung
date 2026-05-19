<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Deteksi penyakit tanaman jagung berdasarkan gejala dengan metode Certainty Factor.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .gejala-card.selected { border-color: #56995c !important; box-shadow: 0 0 0 1px #56995c; }
    .gejala-card.selected .card-icon-wrap { background-color: rgba(86, 153, 92, 0.15) !important; color: #56995c !important; }
    .gejala-card.selected .cf-trigger-btn { background-color: #56995c !important; color: white !important; border-color: #56995c !important; }
    .kategori-btn.active { background-color: #56995c !important; color: white !important; border-color: #56995c !important; }
    .cf-modal { transition: opacity 0.2s ease; }
</style>

<div class="w-full">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-slate-900 text-xl md:text-2xl font-bold">Diagnosa Kesehatan Jagung</h1>
        <div class="h-1 w-16 bg-primary rounded-full"></div>
        <p class="text-slate-600 text-sm mt-2">Pilih gejala yang diamati untuk mengidentifikasi penyakit potensial menggunakan Sistem Pakar kami.</p>
    </div>

    <!-- Info Box -->
    <div class="bg-primary/5 border border-primary/20 p-4 rounded-xl mb-6 flex items-start gap-3">
        <span class="material-symbols-outlined text-primary text-xl mt-0.5">info</span>
        <div>
            <h3 class="font-bold text-slate-800 text-sm mb-1">Tabel Kepastian</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-x-6 gap-y-1 text-xs text-slate-600">
                <div><span class="font-bold text-red-500">0</span> - Tidak ada</div>
                <div><span class="font-bold text-red-500">0.2</span> - Tidak Tau</div>
                <div><span class="font-bold text-orange-500">0.4</span> - Sedikit Yakin</div>
                <div><span class="font-bold text-yellow-500">0.6</span> - Cukup Yakin</div>
                <div><span class="font-bold text-blue-500">0.8</span> - Yakin</div>
                <div><span class="font-bold text-green-600">1</span> - Sangat Yakin</div>
            </div>
        </div>
    </div>

    <form action="<?= base_url('deteksi/proses') ?>" method="post" id="gejalaForm">
        <!-- Input Nama -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 mb-6 shadow-sm">
            <label for="nama_user" class="block text-sm font-bold text-slate-800 mb-2">Nama Anda <span class="text-red-500">*</span></label>
            <input type="text" id="nama_user" name="nama_user" placeholder="Masukkan nama Anda..." required
                   class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm text-slate-700">
            <p class="text-xs text-slate-400 mt-1">Nama akan ditampilkan pada riwayat diagnosa.</p>
        </div>

        <!-- Category Quick Nav -->
        <div class="flex flex-wrap gap-2 mb-6">
            <button type="button" class="kategori-btn active px-3 py-1.5 text-xs font-semibold rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-primary hover:text-white transition-all" onclick="filterKategori('all')">Semua</button>
            <?php foreach ($gejala_grouped as $kategori => $gejalaList): ?>
            <button type="button" class="kategori-btn px-3 py-1.5 text-xs font-semibold rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-primary hover:text-white transition-all" onclick="filterKategori('<?= esc($kategori) ?>')"><?= esc($kategori) ?> (<?= count($gejalaList) ?>)</button>
            <?php endforeach; ?>
        </div>

        <?php foreach ($gejala_grouped as $kategori => $gejalaList): ?>
        <div id="kategori-<?= esc($kategori) ?>" class="kategori-section mb-6 scroll-mt-24" data-kategori="<?= esc($kategori) ?>">
            <h2 class="text-base font-bold text-slate-800 mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-lg">category</span>
                <?= esc($kategori) ?>
                <span class="text-xs font-normal text-slate-400">(<?= count($gejalaList) ?>)</span>
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
                <div id="gejala-<?= $g['id_gejala'] ?>" class="gejala-card relative flex flex-col gap-3 rounded-xl border-2 border-transparent bg-white p-4 shadow-sm transition-all hover:border-primary/40 hover:shadow-md">
                    <!-- Hidden inputs -->
                    <input type="checkbox" name="gejala[]" value="<?= $g['id_gejala'] ?>" class="gejala-checkbox hidden" id="cb-<?= $g['id_gejala'] ?>">
                    
                    <div class="flex items-start gap-3">
                        <div class="card-icon-wrap p-2 rounded-lg bg-slate-100 text-slate-500 transition-colors">
                            <span class="material-symbols-outlined text-xl"><?= $icon ?></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold mb-0.5 text-slate-800"><?= esc($g['kode_gejala']) ?></h3>
                            <p class="text-xs text-slate-500 leading-relaxed"><?= esc($g['nama_gejala']) ?></p>
                        </div>
                        <button type="button" class="cf-trigger-btn flex-shrink-0 px-3 py-1.5 text-xs font-semibold rounded-lg border border-slate-300 text-slate-600 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all bg-white self-start">
                            Pilih
                        </button>
                    </div>
                    
                    
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 py-4 border-t border-slate-200 mt-4">
            <a href="<?= base_url('/') ?>" class="w-full sm:w-auto px-4 py-2.5 rounded-lg border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition-colors flex items-center justify-center gap-2 bg-white text-sm">
                <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali
            </a>
            <div class="flex gap-2 w-full sm:w-auto">
                <button type="button" onclick="resetForm()" class="flex-1 sm:flex-none px-4 py-2.5 rounded-lg font-semibold border border-slate-200 hover:bg-slate-50 flex items-center justify-center gap-2 transition-all bg-white text-sm text-slate-600">
                    <span class="material-symbols-outlined text-sm">refresh</span> Reset
                </button>
                <button type="submit" class="flex-1 sm:flex-none px-6 py-2.5 rounded-lg bg-primary hover:bg-primary-dark text-white font-semibold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 text-sm">
                    Proses Diagnosa <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- CF Modal -->
<div id="cf-modal" class="cf-modal fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl">
        <h3 class="text-base font-bold text-slate-800 mb-1">Pilih Nilai Kepastian</h3>
        <p id="cf-modal-gejala" class="text-xs text-slate-400 mb-4"></p>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" data-val="0" class="cf-option px-3 py-3 text-xs font-semibold rounded-xl border-2 border-slate-200 text-slate-600 hover:border-red-400 hover:text-red-500 hover:bg-red-50 transition-all">0<br><span class="text-[10px] font-normal">Tidak Ada</span></button>
            <button type="button" data-val="0.2" class="cf-option px-3 py-3 text-xs font-semibold rounded-xl border-2 border-slate-200 text-slate-600 hover:border-orange-400 hover:text-orange-500 hover:bg-orange-50 transition-all">0.2<br><span class="text-[10px] font-normal">Tidak Tau</span></button>
            <button type="button" data-val="0.4" class="cf-option px-3 py-3 text-xs font-semibold rounded-xl border-2 border-slate-200 text-slate-600 hover:border-yellow-400 hover:text-yellow-600 hover:bg-yellow-50 transition-all">0.4<br><span class="text-[10px] font-normal">Sedikit Yakin</span></button>
            <button type="button" data-val="0.6" class="cf-option px-3 py-3 text-xs font-semibold rounded-xl border-2 border-slate-200 text-slate-600 hover:border-emerald-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all">0.6<br><span class="text-[10px] font-normal">Cukup Yakin</span></button>
            <button type="button" data-val="0.8" class="cf-option px-3 py-3 text-xs font-semibold rounded-xl border-2 border-slate-200 text-slate-600 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 transition-all">0.8<br><span class="text-[10px] font-normal">Yakin</span></button>
            <button type="button" data-val="1" class="cf-option px-3 py-3 text-xs font-semibold rounded-xl border-2 border-slate-200 text-slate-600 hover:border-green-400 hover:text-green-600 hover:bg-green-50 transition-all">1<br><span class="text-[10px] font-normal">Sangat Yakin</span></button>
        </div>
        <button type="button" id="cf-modal-close" class="mt-4 w-full px-4 py-2.5 text-sm font-semibold rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition-all">Batal</button>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function() {
    let selectedGejalaId = null;
    let gejalaDipilih = {};

    // Setup click handlers for all Pilih buttons
    document.querySelectorAll('.cf-trigger-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            var card = this.closest('.gejala-card');
            var id = parseInt(card.id.replace('gejala-', ''));
            selectedGejalaId = id;
            
            var modal = document.getElementById('cf-modal');
            var gejalaName = card.querySelector('h3').textContent + ' - ' + card.querySelector('p').textContent;
            document.getElementById('cf-modal-gejala').textContent = 'Gejala: ' + gejalaName;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    // CF Option buttons
    document.querySelectorAll('.cf-option').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var val = parseFloat(this.dataset.val);
            selectGejala(selectedGejalaId, val);
            closeModal();
        });
    });

    // Close modal button
    document.getElementById('cf-modal-close').addEventListener('click', closeModal);
    
    // Close modal on background click
    document.getElementById('cf-modal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    function closeModal() {
        var modal = document.getElementById('cf-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        selectedGejalaId = null;
    }

    function selectGejala(id, val) {
        var card = document.getElementById('gejala-' + id);
        if (!card) return;

        // Create hidden kepastian input if not exists
        var kepInput = card.querySelector('.kepastian-input');
        if (!kepInput) {
            kepInput = document.createElement('input');
            kepInput.type = 'hidden';
            kepInput.className = 'kepastian-input';
            kepInput.name = 'kepastian[' + id + ']';
            card.appendChild(kepInput);
        }
        kepInput.value = val;

        // Update card state
        card.classList.add('selected');
        card.querySelector('.gejala-checkbox').checked = true;
        
        var btn = card.querySelector('.cf-trigger-btn');
        btn.classList.add('bg-primary', 'text-white', 'border-primary');
        btn.textContent = val;

        gejalaDipilih[id] = val;
    }

    function deselectGejala(id) {
        var card = document.getElementById('gejala-' + id);
        if (!card) return;

        card.classList.remove('selected');
        card.querySelector('.gejala-checkbox').checked = false;
        
        var btn = card.querySelector('.cf-trigger-btn');
        btn.classList.remove('bg-primary', 'text-white', 'border-primary');
        btn.textContent = 'Pilih';

        delete gejalaDipilih[id];
    }

    window.filterKategori = function(kategori) {
        document.querySelectorAll('.kategori-btn').forEach(function(btn) {
            btn.classList.remove('active');
            if (btn.textContent.trim() === 'Semua' && kategori === 'all') {
                btn.classList.add('active');
            } else if (btn.textContent.includes(kategori)) {
                btn.classList.add('active');
            }
        });

        document.querySelectorAll('.kategori-section').forEach(function(section) {
            if (kategori === 'all' || section.dataset.kategori === kategori) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    };

    window.resetForm = function() {
        Object.keys(gejalaDipilih).forEach(function(id) {
            deselectGejala(parseInt(id));
        });
        gejalaDipilih = {};
        filterKategori('all');
    };

    // Form validation
    document.getElementById('gejalaForm').addEventListener('submit', function(e) {
        if (Object.keys(gejalaDipilih).length === 0) {
            e.preventDefault();
            alert('Pilih setidaknya satu gejala.');
        }
    });
})();
</script>
<?= $this->endSection() ?>
