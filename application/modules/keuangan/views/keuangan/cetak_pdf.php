<!DOCTYPE html>
<html>
<head>
    <title>Laporan Tutup Buku</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 1px solid #000; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #666; padding: 5px; }
        th { background-color: #eee; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin:0;">LAPORAN TUTUP BUKU ASET</h2>
        <p style="margin:5px;">Periode: <?= $periode ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Kode</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th class="text-right">Harga Awal</th>
                <th class="text-right">Akumulasi Susut</th>
                <th class="text-right">Nilai Akhir</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $t_awal = 0; $t_akhir = 0;
            if(empty($laporan)): ?>
                <tr><td colspan="8" class="text-center">Data tidak ditemukan</td></tr>
            <?php else: ?>
                <?php foreach($laporan as $i => $r): 
                    $t_awal += $r['buku_awal_nominal'];
                    $t_akhir += $r['buku_akhir_nominal'];
                ?>
                <tr>
                    <td class="text-center"><?= $i+1 ?></td>
                    <td><?= $r['asset_kd'] ?></td>
                    <td><?= $r['asset_nm'] ?></td>
                    <td><?= $r['kategori_nm'] ?></td>
                    <td class="text-right"><?= number_format($r['buku_awal_nominal'],0,',','.') ?></td>
                    <td class="text-right"><?= number_format($r['akumulasi_penyusutan_nominal'],0,',','.') ?></td>
                    <td class="text-right"><?= number_format($r['buku_akhir_nominal'],0,',','.') ?></td>
                    <td><?= $r['keterangan_txt'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">TOTAL</th>
                <th class="text-right"><?= number_format($t_awal,0,',','.') ?></th>
                <th></th>
                <th class="text-right"><?= number_format($t_akhir,0,',','.') ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>