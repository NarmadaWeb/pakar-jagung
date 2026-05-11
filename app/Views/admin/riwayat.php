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
                                <span class="font-medium"><?= $r['nama_lengkap'] ?? 'Tidak diketahui' ?></span>
                                <span class="text-xs text-slate-500"><?= $r['email'] ?? '-' ?></span>
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
                                <img src="<?= $gambar ?>" class="w-10 h-10 object-cover rounded-lg" alt="<?= esc($r['nama_penyakit'] ?? '') ?>">
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
        'pengguna' => $r['nama_lengkap'] ?? 'Tidak diketahui',
        'email' => $r['email'] ?? '',
        'penyakit' => $r['nama_penyakit'] ?? '-',
        'kode_penyakit' => $r['kode_penyakit'] ?? '-',
        'gejala' => is_array($gejala) ? array_map(function($g) { return is_array($g) ? ($g['kode'] ?? $g) : $g; }, $gejala) : [],
        'detail_gejala' => is_array($detail) ? $detail : [],
        'persentase' => floatval($r['persentase'] ?? 0),
        'cf_hasil' => floatval($r['cf_hasil'] ?? 0),
        'solusi' => $r['solusi'] ?? '',
    ];
}, $riwayat)) : '[]' ?>;

function showDetail(id) {
    const data = riwayatData.find(r => r.id === id);
    if (!data) return;
    
    let content = `
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-slate-500">Tanggal</p>
                    <p class="font-medium">${data.tanggal}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Pengguna</p>
                    <p class="font-medium">${data.pengguna}</p>
                    <p class="text-sm text-slate-500">${data.email}</p>
                </div>
            </div>
    `;
    
    if (data.penyakit && data.penyakit !== '-') {
        content += `
            <div class="p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                <p class="text-sm text-slate-500">Hasil Deteksi</p>
                <p class="text-lg font-bold text-red-700 dark:text-red-400">${data.penyakit}</p>
                <p class="text-sm text-red-600 dark:text-red-400">(${data.kode_penyakit}) - Keyakinan: <span class="font-bold">${data.persentase}%</span></p>
            </div>
        `;
    }
    
    if (data.gejala && data.gejala.length > 0) {
        content += `
            <div>
                <p class="text-sm text-slate-500 mb-2">Gejala Dipilih (${data.gejala.length})</p>
                <div class="flex flex-wrap gap-2">
                    ${data.gejala.map(g => `<span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 rounded-full text-sm">${g}</span>`).join('')}
                </div>
            </div>
        `;
    }
    
    if (data.detail_gejala && data.detail_gejala.length > 0) {
        content += `
            <div>
                <p class="text-sm text-slate-500 mb-2">Detail Perhitungan CF</p>
                <div class="bg-slate-50 dark:bg-slate-700 rounded-lg p-3 space-y-1">
                    ${data.detail_gejala.map(g => `
                        <div class="flex justify-between text-sm">
                            <span>${g.kode || '-'} - ${g.nama || '-'}</span>
                            <span class="font-medium">CF = ${g.cf_user || 0} × ${g.cf_pakar || 0} = ${g.cf_hasil || 0}</span>
                        </div>
                    `).join('')}
                    <div class="flex justify-between text-sm font-bold border-t pt-2 mt-2">
                        <span>Total CF Gabung</span>
                        <span>${data.cf_hasil.toFixed(4)}</span>
                    </div>
                </div>
            </div>
        `;
    }
    
    if (data.solusi) {
        content += `
            <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                <p class="text-sm text-slate-500">Solusi</p>
                <p class="text-green-700 dark:text-green-400 text-sm">${data.solusi}</p>
            </div>
        `;
    }
    
    content += '</div>';
    
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