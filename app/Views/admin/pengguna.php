<?= $this->extend('layouts/admin') ?>

<?= $this->section('meta') ?>
<meta name="description" content="Kelola data pengguna.">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Data Pengguna</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola akun pengguna yang terdaftar</p>
        </div>
    </div>

    <?php if (session('success')): ?>
    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>
        <?= session('success') ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($pengguna)): ?>
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">No</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">Nama Lengkap</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">Username</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">Email</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700">Tanggal Daftar</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-700 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <?php foreach ($pengguna as $index => $p): ?>
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-4 text-sm text-slate-500"><?= $index + 1 ?></td>
                    <td class="px-6 py-4 font-semibold text-slate-800"><?= esc($p['nama_lengkap']) ?></td>
                    <td class="px-6 py-4 text-slate-700">
                        <span class="inline-flex items-center rounded-lg bg-primary/10 text-primary text-xs font-bold px-3 py-1">
                            <?= esc($p['username']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-600"><?= esc($p['email']) ?></td>
                    <td class="px-6 py-4 text-slate-500 text-sm"><?= date('d M Y', strtotime($p['created_at'])) ?></td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="confirmDelete('<?= base_url('admin/pengguna/delete/' . $p['id']) ?>')" class="text-red-600 hover:text-red-800 p-1">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="flex flex-col items-center justify-center gap-4 rounded-2xl border border-dashed border-slate-300 bg-white py-20 text-center">
        <span class="material-symbols-outlined text-6xl text-slate-300">group</span>
        <h3 class="text-slate-700 text-xl font-bold">Belum Ada Pengguna</h3>
        <p class="text-slate-500 text-sm max-w-xs">Pengguna yang mendaftar akan muncul di sini.</p>
    </div>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(url) {
        Swal.fire({
            title: 'Hapus Pengguna?',
            text: 'Pengguna akan dihapus permanen!',
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