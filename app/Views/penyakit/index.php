<?= $this->extend('layouts/admin') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Kelola data penyakit tanaman jagung.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Penyakit</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data penyakit tanaman jagung</p>
        </div>
        <a href="<?= base_url('penyakit/add') ?>" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 transition-colors">
            <span class="material-symbols-outlined">add</span>
            Tambah Penyakit
        </a>
    </div>

    <?php if (session('success')): ?>
    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>
        <?= session('success') ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($penyakit)): ?>
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">Gambar</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">Kode</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">Nama Penyakit</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">Gejala</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">Solusi</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <?php foreach ($penyakit as $p): ?>
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-4">
                        <?php if (!empty($p['gambar'])): ?>
                        <img src="<?= $p['gambar'] ?>" class="w-16 h-16 object-cover rounded-lg" alt="<?= esc($p['nama_penyakit']) ?>">
                        <?php else: ?>
                        <div class="w-16 h-16 bg-slate-200 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-slate-400">image</span>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-lg bg-primary/10 text-primary text-xs font-bold px-3 py-1">
                            <?= esc($p['kode_penyakit']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-800"><?= esc($p['nama_penyakit']) ?></td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            <?php if (!empty($p['gejala_list'])): ?>
                                <?php foreach ($p['gejala_list'] as $g): ?>
                                    <span class="inline-flex items-center rounded bg-slate-100 text-xs px-2 py-0.5 text-slate-600">
                                        <?= esc($g['kode_gejala']) ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-slate-400 text-sm">-</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600 text-sm max-w-xs truncate"><?= esc($p['solusi']) ?></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="<?= base_url('penyakit/detail/' . $p['id_penyakit']) ?>" class="inline-flex items-center gap-1 rounded-lg border border-primary text-primary text-xs font-bold px-3 py-1.5 hover:bg-primary hover:text-white transition-all">
                                <span class="material-symbols-outlined text-base">info</span>
                                Detail
                            </a>
                            <a href="<?= base_url('penyakit/edit/' . $p['id_penyakit']) ?>" class="text-blue-600 hover:text-blue-800 p-1">
                                <span class="material-symbols-outlined">edit</span>
                            </a>
                            <button onclick="confirmDelete('<?= base_url('penyakit/delete/' . $p['id_penyakit']) ?>')" class="text-red-600 hover:text-red-800 p-1">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="flex flex-col items-center justify-center gap-4 rounded-2xl border border-dashed border-slate-300 bg-white py-20 text-center">
        <span class="material-symbols-outlined text-6xl text-slate-300">search_off</span>
        <h3 class="text-slate-700 text-xl font-bold">Belum Ada Data</h3>
        <p class="text-slate-500 text-sm max-w-xs">Data penyakit belum tersedia.</p>
    </div>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(url) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
<?= $this->endSection() ?>