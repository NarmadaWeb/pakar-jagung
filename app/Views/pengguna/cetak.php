<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa - CornAI</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-white p-8 max-w-3xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8 border-b-2 border-green-600 pb-4">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-4xl text-green-600">eco</span>
            <div>
                <h1 class="text-2xl font-bold text-green-700">CornAI</h1>
                <p class="text-sm text-gray-500">Sistem Deteksi Penyakit Jagung</p>
            </div>
        </div>
        <div class="text-right text-sm text-gray-500">
            <p>Tanggal Cetak: <?= date('d F Y, H:i') ?></p>
        </div>
    </div>

    <!-- Info Pasien -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <h2 class="font-bold text-gray-700 mb-2">Informasi Pasien</h2>
        <div class="grid grid-cols-2 gap-2 text-sm">
            <div><span class="font-medium">Nama:</span> <?= esc($riwayat['nama_pasien'] ?? session()->get('nama_lengkap')) ?></div>
            <div><span class="font-medium">No. HP:</span> <?= esc($riwayat['no_hp'] ?? '-') ?></div>
        </div>
    </div>

    <!-- Hasil Utama -->
    <div class="border-2 border-green-600 rounded-lg overflow-hidden mb-6">
        <div class="bg-green-600 text-white px-4 py-2">
            <span class="font-bold">HASIL DIAGNOSA</span>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-xl font-bold text-green-700"><?= esc($riwayat['nama_penyakit']) ?></h3>
                    <p class="text-gray-500">Kode: <?= esc($riwayat['kode_penyakit'] ?? '-') ?></p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-green-600"><?= number_format($riwayat['persentase'], 2) ?>%</div>
                    <div class="text-sm text-gray-500">Tingkat Keyakinan</div>
                </div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-green-600 h-4 rounded-full" style="width: <?= $riwayat['persentase'] ?>%"></div>
            </div>
        </div>
    </div>

    <!-- Tanggal Diagnosa -->
    <div class="mb-6">
        <p class="text-sm text-gray-600">
            <span class="font-medium">Tanggal Diagnosa:</span> <?= date('d F Y, H:i', strtotime($riwayat['tanggal_diagnosa'])) ?>
        </p>
    </div>

    <!-- Gejala Terdeteksi -->
    <div class="border rounded-lg mb-6">
        <div class="bg-gray-100 px-4 py-2 border-b">
            <h4 class="font-bold text-gray-700">Gejala Terdeteksi</h4>
        </div>
        <div class="p-4">
            <?php if (!empty($gejalaDipilih)): ?>
            <ul class="space-y-2">
                <?php foreach ($gejalaDipilih as $g): ?>
                <li class="flex items-center gap-2">
                    <span class="text-green-600">✓</span>
                    <span><?= esc($g['kode'] ?? '') ?> - <?= esc($g['nama'] ?? '') ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p class="text-gray-500">Tidak ada data gejala</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Detail CF -->
    <?php if (!empty($detailGejala)): ?>
    <div class="border rounded-lg mb-6">
        <div class="bg-gray-100 px-4 py-2 border-b">
            <h4 class="font-bold text-gray-700">Perhitungan Certainty Factor (CF)</h4>
        </div>
        <div class="p-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Gejala</th>
                        <th class="text-center py-2">CF User</th>
                        <th class="text-center py-2">CF Pakar</th>
                        <th class="text-center py-2">CF Gabung</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detailGejala as $g): ?>
                    <tr class="border-b">
                        <td class="py-2"><?= esc($g['kode'] ?? '') ?> - <?= esc($g['nama'] ?? '') ?></td>
                        <td class="text-center"><?= $g['cf_user'] ?? 0 ?></td>
                        <td class="text-center"><?= $g['cf_pakar'] ?? 0 ?></td>
                        <td class="text-center"><?= number_format($g['cf_hasil'] ?? 0, 4) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-3 pt-3 border-t flex justify-between font-bold">
                <span>Hasil Akhir CF Combine:</span>
                <span><?= number_format($riwayat['cf_hasil'], 4) ?></span>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Solusi -->
    <div class="border rounded-lg mb-6">
        <div class="bg-gray-100 px-4 py-2 border-b">
            <h4 class="font-bold text-gray-700">Solusi / Rekomendasi</h4>
        </div>
        <div class="p-4 text-sm text-gray-700">
            <?= nl2br(esc($riwayat['solusi'] ?? 'Silakan konsultasikan dengan ahli pertanian untuk penanganan lebih lanjut.')) ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center text-xs text-gray-500 pt-4 border-t">
        <p>Hasil diagnosa ini dibuat menggunakan metode Certainty Factor (CF)</p>
        <p>CornAI - Sistem Pakar Diagnosa Penyakit Jagung</p>
    </div>

    <!-- Tombol Print -->
    <div class="no-print mt-8 flex justify-center">
        <button onclick="window.print()" class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 flex items-center gap-2">
            <span class="material-symbols-outlined">print</span>
            Print Hasil
        </button>
    </div>
</body>
</html>