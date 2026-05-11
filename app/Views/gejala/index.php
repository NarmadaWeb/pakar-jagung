<?= $this->extend('layouts/admin') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Kelola data gejala tanaman jagung.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kelola Gejala</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data gejala penyakit tanaman jagung</p>
        </div>
        <a href="<?= base_url('gejala/add') ?>" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 transition-colors">
            <span class="material-symbols-outlined">add</span>
            Tambah Gejala
        </a>
    </div>

    <?php if (session('success')): ?>
    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>
        <?= session('success') ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($gejala)): ?>
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">Kode</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">Nama Gejala</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">Bagian</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <?php foreach ($gejala as $g): ?>
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-lg bg-primary/10 text-primary text-xs font-bold px-3 py-1">
                            <?= esc($g['kode_gejala']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-700"><?= esc($g['nama_gejala']) ?></td>
                    <td class="px-6 py-4">
                        <?php 
                        $badgeColors = [
                            'Daun' => 'bg-green-100 text-green-700',
                            'Batang' => 'bg-amber-100 text-amber-700',
                            'Tongkol' => 'bg-purple-100 text-purple-700',
                            'Biji' => 'bg-orange-100 text-orange-700',
                            'Umum' => 'bg-slate-100 text-slate-700',
                        ];
                        $color = $badgeColors[$g['kategori']] ?? 'bg-slate-100 text-slate-700';
                        ?>
                        <span class="inline-flex items-center rounded-lg text-xs font-medium px-2.5 py-1 <?= $color ?>">
                            <?= esc($g['kategori'] ?? '-') ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="<?= base_url('gejala/edit/' . $g['id_gejala']) ?>" class="text-blue-600 hover:text-blue-800 p-1">
                                <span class="material-symbols-outlined">edit</span>
                            </a>
                            <button onclick="confirmDelete('<?= base_url('gejala/delete/' . $g['id_gejala']) ?>')" class="text-red-600 hover:text-red-800 p-1">
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
        <p class="text-slate-500 text-sm max-w-xs">Data gejala belum tersedia.</p>
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