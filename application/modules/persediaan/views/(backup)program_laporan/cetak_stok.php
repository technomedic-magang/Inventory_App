<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Posisi Stok</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; background-color: #f8f9fa; }
        .report-container { max-width: 1140px; margin: 20px auto; background: white; border: 1px solid #ddd; }
        .header-laporan { text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; }
        .header-laporan h2 { margin: 0; }
        .table thead th { background-color: #343a40 !important; color: white !important; }
        .btn-bar { background: #e9ecef; padding: 10px; border-bottom: 1px solid #ddd; }
        
        /* SEMBUNYIKAN TOMBOL SAAT PRINT */
        @media print {
            body { background-color: white; }
            .no-print { display: none !important; }
            .report-container { margin: 0; border: none; }
            .table thead th { background-color: #343a40 !important; color: white !important; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="btn-bar no-print text-end p-2">
            <?php 
                // Siapkan URL untuk tombol PDF (menggunakan filter yang sama)
                $query_string = http_build_query([
                    'gudang_id' => $filter_gudang_id ?? '',
                    'kategori_id' => $filter_kategori_id ?? '',
                    'n' => $token_n ?? '' // <-- TAMBAHKAN TOKEN DI SINI
                ]);
            ?>
            <a href="javascript:window.print()" class="btn btn-secondary btn-sm">
                <i class="fas fa-print me-1"></i> Cetak Preview Ini
            </a>
            <a href="<?= site_url('laporan/cetak_pdf?' . $query_string) ?>" target="_blank" class="btn btn-primary btn-sm">
                <i class="fas fa-download me-1"></i> Download PDF
            </a>
        </div>

        <div class="p-4">
            <div class="header-laporan">
                <h2>LAPORAN POSISI STOK</h2>
                <p class="mb-0">
                    Per Tanggal: <?= $periode ?><br>
                    <?= isset($filter_gudang) ? 'Lokasi: ' . $filter_gudang : 'Lokasi: Semua Gudang' ?>
                </p>
            </div>

            <table class="table table-bordered table-sm table-striped">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="15%">Kode Asset</th>
                        <th width="30%">Nama Asset</th>
                        <th width="15%">Kategori</th>
                        <th width="20%">Lokasi Gudang</th>
                        <th width="15%" class="text-end">Sisa Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($laporan)): ?>
                        <tr><td colspan="6" class="text-center py-3">Tidak ada data.</td></tr>
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
        </div>
    </div>
</body>
</html>