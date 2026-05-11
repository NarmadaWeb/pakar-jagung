<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Deteksi penyakit tanaman jagung berdasarkan gejala dengan metode Certainty Factor.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="flex flex-col gap-2 mb-4">
        <span class="text-primary font-semibold tracking-widest uppercase text-xs">AI Deteksi</span>
        <h1 class="text-xl md:text-2xl font-bold">Deteksi Penyakit Jagung</h1>
        <div class="h-1 w-16 bg-primary rounded-full"></div>
        <p class="text-slate-600 text-sm">Pilih gejala dan tentukan tingkat kepastian Anda untuk setiap gejala.</p>
    </div>

    <div class="bg-blue-50 border border-blue-200 p-3 rounded-lg mb-4">
        <h3 class="font-semibold text-blue-800 flex items-center gap-2 mb-2 text-sm">
            <span class="material-symbols-outlined text-lg">info</span>
            Tabel Kepastian (MB/MD)
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-sm">
            <div class="flex items-center gap-1"><span class="font-bold text-red-600">0</span> - Tidak ada</div>
            <div class="flex items-center gap-1"><span class="font-bold text-red-600">0.2</span> - Tidak Tau</div>
            <div class="flex items-center gap-1"><span class="font-bold text-orange-600">0.4</span> - Sedikit Yakin</div>
            <div class="flex items-center gap-1"><span class="font-bold text-yellow-600">0.6</span> - Cukup Yakin</div>
            <div class="flex items-center gap-1"><span class="font-bold text-blue-600">0.8</span> - Yakin</div>
            <div class="flex items-center gap-1"><span class="font-bold text-green-600">1</span> - Sangat Yakin</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
        <!-- Form Gejala dengan Kepastian -->
        <div class="space-y-6">
            <div class="bg-white p-4 md:p-6 rounded-xl border border-slate-200">
                <h2 class="text-lg md:text-xl font-bold mb-3 md:mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">assignment</span>
                    Pilih Gejala & Tingkat Kepastian
                </h2>
                
                <!-- Quick Category Buttons -->
                <div class="flex flex-wrap gap-2 mb-4 p-2 bg-slate-100 rounded-lg">
                    <?php foreach ($gejala_grouped as $kategori => $gejalaList): ?>
                    <button type="button" onclick="scrollToKategori('<?= esc($kategori) ?>')" 
                            class="kategori-btn px-4 py-2 text-sm font-medium rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-primary hover:text-white hover:border-primary transition-all">
                        <?= esc($kategori) ?> (<?= count($gejalaList) ?>)
                    </button>
                    <?php endforeach; ?>
                </div>
                
                <form action="<?= base_url('deteksi/proses') ?>" method="post" id="gejalaForm">
                    <?php foreach ($gejala_grouped as $kategori => $gejalaList): ?>
                    <div id="kategori-<?= esc($kategori) ?>" class="mb-6 scroll-mt-20">
                        <h3 class="text-lg font-bold text-primary mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined">category</span>
                            <?= esc($kategori) ?>
                            <span class="text-xs font-normal text-slate-500">(<?= count($gejalaList) ?> gejala)</span>
                        </h3>
                        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-slate-100 text-slate-700">
                                        <tr>
                                            <th class="px-4 py-3 text-left font-semibold"><span class="material-symbols-outlined align-middle">check_box</span></th>
                                            <th class="px-4 py-3 text-left font-semibold">Kode</th>
                                            <th class="px-4 py-3 text-left font-semibold">Nama Gejala</th>
                                            <th class="px-4 py-3 text-left font-semibold">Kepastian</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        <?php foreach ($gejalaList as $g): ?>
                                        <tr class="transition-all duration-200 group gejala-row" data-id="<?= $g['id_gejala'] ?>">
                                            <td class="px-4 py-3">
                                                <input type="checkbox" name="gejala[]" value="<?= $g['id_gejala'] ?>" 
                                                       class="gejala-checkbox w-5 h-5 text-primary rounded focus:ring-2 focus:ring-primary focus:ring-offset-2 cursor-pointer accent-primary">
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-green-500 text-white font-bold text-sm shadow-md">
                                                    <?= esc($g['kode_gejala']) ?>
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-slate-700 font-medium group-hover:text-primary transition-colors">
                                                    <?= esc($g['nama_gejala']) ?>
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <button type="button" onclick="pilihGejala(this, <?= $g['id_gejala'] ?>)" 
                                                        class="pilih-btn px-4 py-2 text-sm font-medium rounded-lg border border-primary text-primary hover:bg-primary hover:text-white transition-all">
                                                    Pilih
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div class="mt-6 flex flex-col md:flex-row gap-4">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-primary to-green-600 text-white px-8 py-4 rounded-xl font-bold hover:from-primary/90 hover:to-green-600/90 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl transition-all">
                            <span class="material-symbols-outlined text-xl">search</span>
                            Proses Diagnosa
                        </button>
                        <button type="button" onclick="resetForm()" class="px-8 py-4 rounded-xl font-bold border-2 border-slate-300 hover:border-slate-400 hover:bg-slate-50 flex items-center justify-center gap-2 transition-all">
                            <span class="material-symbols-outlined">refresh</span>
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Hasil / Preview -->
        <div class="bg-white p-4 md:p-6 rounded-xl border border-slate-200">
            <h2 class="text-lg md:text-xl font-bold mb-3 md:mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">info</span>
                Petunjuk
            </h2>
            <div class="space-y-4 text-slate-600">
                <div class="flex gap-3">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <p>Centang gejala yang Anda lihat pada tanaman jagung</p>
                </div>
                <div class="flex gap-3">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <p>Pilih tingkat kepastian Anda untuk setiap gejala yang dipilih</p>
                </div>
                <div class="flex gap-3">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <p>Sistem akan menghitung CF combine: CF(user) × CF(pakar)</p>
                </div>
                <div class="flex gap-3">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <p>Anda akan mendapatkan diagnosis dengan persentase kepastian</p>
                </div>
            </div>
            
            <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200">
                <h3 class="font-bold text-green-800 mb-2">Rumus Perhitungan CF:</h3>
                <div class="text-sm text-green-700 space-y-2">
                    <p><strong>CF Gejala = CF(user) × CF(pakar)</strong></p>
                    <p><strong>CF Combine = CF₁ + CF₂ × (1 − CF₁)</strong></p>
                    <p><strong>Persentase = CF Combine × 100%</strong></p>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const kepastianOptions = [
        { value: '0', label: 'Tidak ada (0)' },
        { value: '0.2', label: 'Tidak Tau (0.2)' },
        { value: '0.4', label: 'Sedikit Yakin (0.4)' },
        { value: '0.6', label: 'Cukup Yakin (0.6)' },
        { value: '0.8', label: 'Yakin (0.8)' },
        { value: '1', label: 'Sangat Yakin (1)' }
    ];
    
    function pilihGejala(btn, id) {
        const checkbox = document.querySelector(`input[name="gejala[]"][value="${id}"]`);
        const row = btn.closest('tr');
        
        if (checkbox && checkbox.checked) {
            checkbox.checked = false;
            btn.textContent = 'Pilih';
            btn.classList.remove('bg-primary', 'text-white');
            btn.classList.add('border-primary', 'text-primary');
            row.classList.remove('bg-green-50');
            // Remove hidden input
            const hiddenInput = row.querySelector('input[type="hidden"]');
            if (hiddenInput) hiddenInput.remove();
            return;
        }
        
        let optionsHtml = '';
        kepastianOptions.forEach((opt, i) => {
            optionsHtml += `<option value="${opt.value}" ${i === 3 ? 'selected' : ''}>${opt.label}</option>`;
        });
        
        const modal = `
            <div id="kepastianModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl p-6 max-w-sm w-full mx-4 shadow-xl">
                    <h3 class="text-lg font-bold mb-4">Pilih Tingkat Kepastian</h3>
                    <p class="text-slate-600 text-sm mb-4">Seberapa yakin Anda bahwa tanaman menunjukkan gejala ini?</p>
                    <select id="kepastianValue" class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 mb-4">
                        ${optionsHtml}
                    </select>
                    <div class="flex gap-3">
                        <button onclick="batalPilih()" class="flex-1 py-3 rounded-xl font-bold border border-slate-300 hover:bg-slate-50">Batal</button>
                        <button onclick="konfirmasiPilih(${id})" class="flex-1 py-3 rounded-xl font-bold bg-primary text-white hover:bg-primary/90">Pilih</button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modal);
    }
    
    function batalPilih() {
        document.getElementById('kepastianModal').remove();
    }
    
    function konfirmasiPilih(id) {
        const modal = document.getElementById('kepastianModal');
        const select = modal.querySelector('#kepastianValue');
        const value = select.value;
        
        const checkbox = document.querySelector(`input[name="gejala[]"][value="${id}"]`);
        const row = document.querySelector(`.gejala-row[data-id="${id}"]`);
        const btn = row.querySelector('.pilih-btn');
        
        // Add hidden input for kepastian
        let hiddenInput = row.querySelector('input[type="hidden"]');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `kepastian[${id}]`;
            row.appendChild(hiddenInput);
        }
        hiddenInput.value = value;
        
        if (checkbox) {
            checkbox.checked = true;
            btn.textContent = 'Batal';
            btn.classList.remove('border-primary', 'text-primary');
            btn.classList.add('bg-primary', 'text-white');
            row.classList.add('bg-green-50');
        }
        
        modal.remove();
    }
    
    document.querySelectorAll('.gejala-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            if (this.checked) {
                const id = this.value;
                const btn = this.closest('tr').querySelector('.pilih-btn');
                pilihGejala(btn, id);
            } else {
                const row = this.closest('tr');
                const btn = row.querySelector('.pilih-btn');
                btn.textContent = 'Pilih';
                btn.classList.remove('bg-primary', 'text-white');
                btn.classList.add('border-primary', 'text-primary');
                row.classList.remove('bg-green-50');
                const hiddenInput = row.querySelector('input[type="hidden"]');
                if (hiddenInput) hiddenInput.remove();
            }
        });
    });
    
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
        document.querySelectorAll('.gejala-checkbox').forEach(cb => cb.checked = false);
        document.querySelectorAll('.pilih-btn').forEach(btn => {
            btn.textContent = 'Pilih';
            btn.classList.remove('bg-primary', 'text-white');
            btn.classList.add('border-primary', 'text-primary');
        });
        document.querySelectorAll('.gejala-row').forEach(row => row.classList.remove('bg-green-50'));
    }
</script>
<?= $this->endSection() ?>