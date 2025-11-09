<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Posisi Stok</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header-laporan { text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; }
        .header-laporan h2 { margin: 0; }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body onload="window.print()"> <div class="container-fluid mt-4">
        <button class="btn btn-secondary btn-sm no-print mb-3" onclick="window.close()">Tutup</button>

        <div class="header-laporan">
            <h2>LAPORAN POSISI STOK</h2>
            <p class="mb-0">
                Per Tanggal: <?= $periode ?><br>
                <?= isset($filter_gudang) ? 'Lokasi: ' . $filter_gudang : 'Lokasi: Semua Gudang' ?>
            </p>
        </div>

        <table class="table table-bordered table-sm table-striped">
            <thead class="table-dark">
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="15%">Kode Barang</th>
                    <th width="30%">Nama Barang</th>
                    <th width="15%">Kategori</th>
                    <th width="20%">Lokasi Gudang</th>
                    <th width="15%" class="text-end">Sisa Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($laporan)): ?>
                    <tr><td colspan="6" class="text-center py-3">Tidak ada data stok yang ditemukan sesuai filter.</td></tr>
                <?php else: ?>
                    <?php $no = 1; foreach($laporan as $row): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $row['asset_kd'] ?></td>
                        <td><?= $row['asset_nm'] ?></td>
                        <td><?= $row['kategori_nm'] ?></td>
                        <td><?= $row['gudang_nm'] ?></td>
                        <td class="text-end fw-bold">
                            <?= number_format($row['stok_qty'], 0, ',', '.') ?> <?= $row['satuan_nm'] ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="mt-4 text-end small text-muted">
            Dicetak oleh Sistem pada <?= date('d/m/Y H:i:s') ?>
        </div>
    </div>

</body>
</html>