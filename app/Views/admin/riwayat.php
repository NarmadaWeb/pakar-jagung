<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Riwayat Sistem</h1>
            <p class="text-slate-500 text-sm mt-1">Log riwayat diagnosis semua pengguna</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-primary/10 rounded-lg">
                    <span class="material-symbols-outlined text-primary text-2xl">history</span>
                </div>
                <div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Total Diagnosa</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-slate-100"><?= count($riwayat) ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
<div class="p-4 border-b border-slate-200 dark:border-slate-700">
            <div class="flex flex-col sm:flex-row gap-4">
                <form method="get" class="flex flex-1 gap-2 flex-wrap">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                        <input type="text" name="cari" value="<?= service('request')->getGet('cari') ?>" 
                            placeholder="Cari pengguna..."
                            class="pl-10 pr-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 text-sm w-48">
                    </div>
                    <input type="date" name="tanggal_awal" value="<?= service('request')->getGet('tanggal_awal') ?>" 
                        class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 text-sm">
                    <span class="flex items-center text-slate-600 dark:text-slate-400">s/d</span>
                    <input type="date" name="tanggal_akhir" value="<?= service('request')->getGet('tanggal_akhir') ?>" 
                        class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 text-sm">
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors">
                        Filter
                    </button>
                    <?php if (service('request')->getGet('cari') || service('request')->getGet('tanggal_awal') || service('request')->getGet('tanggal_akhir')): ?>
                    <a href="<?= base_url('admin/riwayat') ?>" class="px-4 py-2 text-slate-600 hover:text-slate-900 text-sm">
                        Reset
                    </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700">
                        <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Tanggal</th>
                        <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Pengguna</th>
                        <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Hasil Deteksi</th>
                        <th class="text-left py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Gejala Dipilih</th>
                        <th class="text-center py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Persentase</th>
                        <th class="text-center py-3 px-4 font-semibold text-slate-600 dark:text-slate-400 text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayat)): ?>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">Belum ada riwayat diagnosis</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($riwayat as $r): ?>
                    <tr class="border-b border-slate-100 dark:border-slate-700/50">
                        <td class="py-3 px-4 text-slate-900 dark:text-slate-100 text-sm">
                            <?= date('d/m/Y H:i', strtotime($r['tanggal_diagnosa'] ?? date('Y-m-d H:i:s'))) ?>
                        </td>
                        <td class="py-3 px-4 text-slate-900 dark:text-slate-100">
                            <div class="flex flex-col">
                                <span class="font-medium"><?= $r['nama_user'] ?? 'Pengguna Anonim' ?></span>
                                <span class="text-xs text-slate-500">Publik / Non-Login</span>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <?php 
                            $db = \Config\Database::connect();
                            $p = $db->table('penyakit')->where('nama_penyakit', $r['nama_penyakit'] ?? '')->get()->getRowArray();
                            $gambar = $p['gambar'] ?? '';
                            ?>
                            <?php if (!empty($gambar)): ?>
                            <div class="flex items-center gap-2">
                                <img src="<?= base_url($gambar) ?>" class="w-10 h-10 object-cover rounded-lg" alt="<?= esc($r['nama_penyakit'] ?? '') ?>">
                                <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-full text-xs font-medium">
                                    <?= $r['nama_penyakit'] ?? 'Tidak terdeteksi' ?>
                                </span>
                            </div>
                            <?php else: ?>
                            <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-full text-xs font-medium">
                                <?= $r['nama_penyakit'] ?? 'Tidak terdeteksi' ?>
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400 text-sm max-w-xs truncate">
                            <?php 
                            $gejalaJson = $r['gejala_dipilih'] ?? null;
                            $gejala = $gejalaJson ? json_decode($gejalaJson, true) : null;
                            if ($gejala && is_array($gejala)): ?>
                                <?php foreach (array_slice($gejala, 0, 3) as $g): ?>
                                <span class="inline-flex items-center bg-slate-100 dark:bg-slate-700 rounded px-2 py-0.5 text-xs mr-1 mb-1"><?= is_array($g) ? ($g['kode'] ?? $g) : $g ?></span>
                                <?php endforeach; ?>
                                <?php if (count($gejala) > 3): ?><span class="text-xs text-slate-500">+<?= count($gejala) - 3 ?> lagi</span><?php endif ?>
                            <?php else: ?>
                            -
                            <?php endif ?>
                        </td>
                        <td class="py-3 px-4 text-center text-slate-900 dark:text-slate-100 font-bold">
                            <?= $r['persentase'] ?? 0 ?>%
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center justify-center gap-1">
                                <button onclick="deleteRiwayat(<?= $r['id_riwayat'] ?? 0 ?>)" class="p-2 text-red-500 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
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

<div id="modal-detail" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-slate-800 rounded-xl p-6 max-w-2xl w-full mx-4 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100">Detail Riwayat Diagnosis</h2>
            <button onclick="closeModal()" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div id="detail-content" class="text-slate-700 dark:text-slate-300">
            <!-- Content loaded via JS -->
        </div>
    </div>
</div>

<script>
const riwayatData = <?= isset($riwayat) ? json_encode(array_map(function($r) {
    $gejala = !empty($r['gejala_dipilih']) ? json_decode($r['gejala_dipilih'], true) : [];
    $detail = !empty($r['detail_gejala']) ? json_decode($r['detail_gejala'], true) : [];
    return [
        'id' => $r['id_riwayat'] ?? 0,
        'tanggal' => date('d/m/Y H:i', strtotime($r['tanggal_diagnosa'] ?? date('Y-m-d H:i:s'))),
        'pengguna' => $r['nama_user'] ?? 'Pengguna Anonim',
        'email' => 'Publik / Non-Login',
        'penyakit' => $r['nama_penyakit'] ?? '-',
        'kode_penyakit' => $r['kode_penyakit'] ?? '-',
        'gambar' => $r['gambar'] ?? '',
        'gejala' => is_array($gejala) ? array_map(function($g) { return is_array($g) ? ['kode' => ($g['kode'] ?? ''), 'nama' => ($g['nama'] ?? '')] : ['kode' => $g, 'nama' => '']; }, $gejala) : [],
        'detail_gejala' => is_array($detail) ? $detail : [],
        'persentase' => floatval($r['persentase'] ?? 0),
        'cf_hasil' => floatval($r['cf_hasil'] ?? 0),
        'solusi' => $r['solusi'] ?? '',
        'tindakan_segera' => $r['tindakan_segera'] ?? '',
        'protokol_pengobatan' => $r['protokol_pengobatan'] ?? '',
        'strategi_pencegahan' => $r['strategi_pencegahan'] ?? '',
    ];
}, $riwayat)) : '[]' ?>;

function showDetail(id) {
    const data = riwayatData.find(r => r.id === id);
    if (!data) return;
    
    let statusLabel, statusBg, barColor, badgeBg;
    if (data.persentase >= 80) {
        statusLabel = 'Keyakinan Tinggi';
        statusBg = 'bg-green-100 text-green-700';
        barColor = 'bg-green-500';
        badgeBg = 'bg-red-50 text-red-600 border-red-100';
    } else if (data.persentase >= 60) {
        statusLabel = 'Keyakinan Sedang';
        statusBg = 'bg-blue-100 text-blue-700';
        barColor = 'bg-blue-500';
        badgeBg = 'bg-yellow-50 text-yellow-600 border-yellow-100';
    } else if (data.persentase >= 40) {
        statusLabel = 'Keyakinan Cukup';
        statusBg = 'bg-yellow-100 text-yellow-700';
        barColor = 'bg-yellow-500';
        badgeBg = 'bg-orange-50 text-orange-600 border-orange-100';
    } else {
        statusLabel = 'Keyakinan Rendah';
        statusBg = 'bg-orange-100 text-orange-700';
        barColor = 'bg-orange-500';
        badgeBg = 'bg-slate-50 text-slate-600 border-slate-200';
    }
    
    const imgSrc = data.gambar ? (data.gambar.startsWith('http') ? data.gambar : '<?= base_url('') ?>' + data.gambar) : '';
    
    let content = `
        <div class="max-h-[70vh] overflow-y-auto pr-2">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content (Left) -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-500">Tanggal</p>
                            <p class="font-semibold text-sm">${data.tanggal}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Pengguna</p>
                            <p class="font-semibold text-sm">${data.pengguna}</p>
                        </div>
                    </div>
    `;
    
    if (data.penyakit && data.penyakit !== '-') {
        content += `
            <div class="bg-gradient-to-br from-primary/5 via-white to-white rounded-xl p-4 border border-slate-100">
                <div class="flex flex-col md:flex-row gap-4 justify-between items-start">
                    <div class="flex-1">
                        <div class="inline-flex items-center gap-2 px-2 py-1 rounded-full ${badgeBg} text-[10px] font-bold uppercase tracking-widest mb-2 border">
                            <span class="size-1.5 rounded-full ${barColor}"></span>
                            Probabilitas Tertinggi
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">${data.penyakit}</h3>
                        <p class="text-slate-400 text-xs">${data.kode_penyakit}</p>
                        ${imgSrc ? `<img src="${imgSrc}" class="w-full max-w-[200px] rounded-lg border border-slate-200 mt-3 object-cover">` : ''}
                    </div>
                    <div class="flex items-center gap-3 bg-white p-3 rounded-xl border border-slate-100 shadow-sm">
                        <div class="relative w-14 h-14 flex items-center justify-center">
                            <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                                <path class="text-slate-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3"></path>
                                <path class="text-primary" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="${data.persentase}, 100" stroke-linecap="round" stroke-width="3"></path>
                            </svg>
                            <div class="absolute text-sm font-bold text-slate-900">${data.persentase}%</div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-[8px] uppercase tracking-wider text-slate-400 font-bold">Confidence</span>
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-lg ${statusBg} inline-block text-center">${statusLabel}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    if (data.gejala && data.gejala.length > 0) {
        content += `
            <div class="bg-white rounded-xl border border-slate-200 p-4">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-bold text-base text-slate-900">Anamnesa</h4>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Gejala</span>
                </div>
                <ul class="space-y-2">
                    ${data.gejala.map(g => `
                    <li class="flex items-start gap-2 p-2 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="size-6 rounded-lg bg-white flex items-center justify-center text-primary shadow-sm flex-shrink-0">
                            <span class="material-symbols-outlined text-xs font-bold">check</span>
                        </div>
                        <span class="text-xs text-slate-600 leading-snug font-medium">${g.kode || g} — ${g.nama || ''}</span>
                    </li>
                    `).join('')}
                </ul>
            </div>
        `;
    }
    
    if (data.detail_gejala && data.detail_gejala.length > 0) {
        content += `
            <div class="bg-white rounded-xl border border-slate-200 p-4">
                <h4 class="font-bold text-sm text-slate-900 mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">calculate</span>
                    Detail Perhitungan CF
                </h4>
                <div class="space-y-2">
                    ${data.detail_gejala.map(g => `
                        <div class="flex justify-between text-xs bg-slate-50 p-2 rounded-lg">
                            <span>${g.kode || '-'} - ${g.nama || '-'}</span>
                            <span class="font-medium">CF = ${g.cf_user || 0} × ${g.cf_pakar || 0} = ${g.cf_hasil || 0}</span>
                        </div>
                    `).join('')}
                    <div class="flex justify-between text-xs font-bold bg-slate-900 text-white p-2 rounded-lg mt-2">
                        <span>Total CF Gabung</span>
                        <span>${data.cf_hasil.toFixed(4)} (${data.persentase}%)</span>
                    </div>
                </div>
            </div>
        `;
    }
    
    if (data.tindakan_segera || data.protokol_pengobatan || data.strategi_pencegahan) {
        content += `
            <div class="bg-white rounded-xl border border-slate-200 p-4">
                <h4 class="font-bold text-sm text-slate-900 mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">healing</span>
                    Protokol Penanganan
                </h4>
                <div class="space-y-3">
                    ${data.tindakan_segera ? `
                    <div class="rounded-lg border border-red-500/10 bg-red-50/50 p-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-red-600 text-sm">emergency</span>
                            <h5 class="text-red-700 text-xs font-bold uppercase">Tindakan Segera</h5>
                        </div>
                        <p class="text-slate-600 text-xs whitespace-pre-wrap">${data.tindakan_segera}</p>
                    </div>
                    ` : ''}
                    ${data.protokol_pengobatan ? `
                    <div class="rounded-lg border border-blue-500/10 bg-blue-50/50 p-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-blue-600 text-sm">medical_services</span>
                            <h5 class="text-blue-700 text-xs font-bold uppercase">Protokol Pengobatan</h5>
                        </div>
                        <p class="text-slate-600 text-xs whitespace-pre-wrap">${data.protokol_pengobatan}</p>
                    </div>
                    ` : ''}
                    ${data.strategi_pencegahan ? `
                    <div class="rounded-lg border border-green-500/10 bg-green-50/50 p-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-green-600 text-sm">security</span>
                            <h5 class="text-green-700 text-xs font-bold uppercase">Strategi Pencegahan</h5>
                        </div>
                        <p class="text-slate-600 text-xs whitespace-pre-wrap">${data.strategi_pencegahan}</p>
                    </div>
                    ` : ''}
                </div>
            </div>
        `;
    }
    
    // Hasil CF Combine (diletakkan di main content, sebelum sidebar)
    content += `
        <div class="p-4 rounded-xl bg-slate-900 text-white relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-10">
                <span class="material-symbols-outlined text-4xl">functions</span>
            </div>
            <div class="flex items-start gap-3 relative z-10">
                <span class="material-symbols-outlined text-primary font-bold text-xl">verified</span>
                <div class="space-y-1">
                    <p class="text-xs font-bold uppercase tracking-widest text-primary">Hasil CF Combine</p>
                    <p class="text-[10px] text-slate-400">CF Combine = CF₁ + CF₂ × (1 − CF₁) → diulang untuk setiap gejala</p>
                    <p class="text-lg font-bold mt-1">${data.cf_hasil.toFixed(4)} <span class="text-xs text-slate-400">(${data.persentase}%)</span></p>
                </div>
            </div>
        </div>
    `;
    
    // Tutup Main Content, mulai Sidebar
    content += `
                </div>
                <!-- Sidebar (Right) -->
                <div class="lg:col-span-1 space-y-4">
                    <!-- Rumus CF -->
                    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                        <h4 class="font-bold text-sm text-slate-900 mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-lg">menu_book</span>
                            Rumus Certainty Factor
                        </h4>
                        <div class="space-y-2 text-xs text-slate-600">
                            <div class="bg-slate-50 p-2 rounded-lg">
                                <p class="font-bold text-slate-700 text-xs">CF Gejala</p>
                                <p class="text-[10px] mt-1">CF(user) × CF(pakar)</p>
                            </div>
                            <div class="bg-slate-50 p-2 rounded-lg">
                                <p class="font-bold text-slate-700 text-xs">CF Combine</p>
                                <p class="text-[10px] mt-1">CF₁ + CF₂ × (1 − CF₁)</p>
                            </div>
                            <div class="bg-slate-50 p-2 rounded-lg">
                                <p class="font-bold text-slate-700 text-xs">Persentase</p>
                                <p class="text-[10px] mt-1">CF Combine × 100%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`
    
    document.getElementById('detail-content').innerHTML = content;
    document.getElementById('modal-detail').classList.remove('hidden');
    document.getElementById('modal-detail').classList.add('flex');
}

function closeModal() {
    document.getElementById('modal-detail').classList.add('hidden');
    document.getElementById('modal-detail').classList.remove('flex');
}

</script>

<!-- Modal Hapus -->
<div id="modal-hapus" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl p-6 max-w-sm w-full mx-4">
        <div class="flex flex-col items-center text-center">
            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-red-500 text-3xl">warning</span>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Konfirmasi Hapus</h3>
            <p class="text-slate-600 text-sm mb-6">Apakah Anda yakin ingin menghapus riwayat ini?</p>
            <div class="flex gap-3 w-full">
                <button onclick="closeModalHapus()" class="flex-1 px-4 py-2 border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors">
                    Tidak
                </button>
                <a id="btn-konfirmasi-hapus" href="" class="flex-1 px-4 py-2 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition-colors text-center">
                    Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function deleteRiwayat(id) {
    document.getElementById('btn-konfirmasi-hapus').href = '<?= base_url('admin/riwayat/hapus/') ?>' + id;
    document.getElementById('modal-hapus').classList.remove('hidden');
    document.getElementById('modal-hapus').classList.add('flex');
}

function closeModalHapus() {
    document.getElementById('modal-hapus').classList.add('hidden');
    document.getElementById('modal-hapus').classList.remove('flex');
}
</script>
<?= $this->endSection() ?>