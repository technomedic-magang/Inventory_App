<?php if (empty($main)): ?>
    <div class="modal-header">
        <h5 class="modal-title text-danger">Error Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body text-center">
        <p class="text-danger">Data aset tidak ditemukan atau sudah dihapus.</p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    </div>
    <?php return; ?>
<?php endif; ?>

<div class="modal-header">
    <h5 class="modal-title">
        <span class="badge bg-primary ms-2"><?= $main['asset_kd'] ?? '-' ?></span> 
        <?= $main['asset_nm'] ?? 'Detail Aset' ?>
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-5 border-end">
            <h4 class="text-primary mb-3">Informasi Umum</h4>
            <table class="table table-sm table-borderless">
                <tr>
                    <td class="text-muted small" width="40%">Kode System</td>
                    <td class="fw-bold text-dark"><?= $main['asset_kd'] ?? '-' ?></td>
                </tr>
                <tr>
                    <td class="text-muted small">Tahun Perolehan</td>
                    <td><?= $main['asset_thn_beli'] ?? '-' ?></td>
                </tr>
                <tr>
                    <td class="text-muted small">Harga Awal</td>
                    <td>Rp <?= number_format($main['harga_beli'] ?? 0, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="text-muted small">Kondisi</td>
                    <td>
                        <?php 
                            $kondisi = $main['asset_kondisi'] ?? 'BAIK';
                            $bg = ($kondisi == 'BAIK') ? 'success' : (($kondisi == 'RUSAK') ? 'danger' : 'warning');
                        ?>
                        <span class="badge bg-<?= $bg ?>-lt"><?= $kondisi ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted small">Keterangan</td>
                    <td class="text-wrap small"><?= $main['asset_ket'] ?? '-' ?></td>
                </tr>
            </table>
        </div>

        <div class="col-md-7">
            <h4 class="text-primary mb-3">Detail & Spesifikasi</h4>
            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                <table class="table table-sm table-striped table-hover">
                    <?php if(empty($detail_kustom)): ?>
                        <tr><td class="text-muted text-center fst-italic py-3">Tidak ada atribut tambahan.</td></tr>
                    <?php else: ?>
                        <?php foreach($detail_kustom as $row): ?>
                        <tr>
                            <td width="45%" class="fw-bold small"><?= $row['atribut_label'] ?></td>
                            
                            <td class="small">
                                <?php 
                                    // Format tanggal otomatis jika label mengandung kata 'Tanggal' atau 'Tgl'
                                    if((stripos($row['atribut_label'], 'tanggal') !== false || stripos($row['atribut_label'], 'tgl') !== false) && !empty($row['value_isi'])) {
                                        // Cek apakah formatnya valid date
                                        $time = strtotime($row['value_isi']);
                                        echo ($time) ? date('d F Y', $time) : $row['value_isi'];
                                    } else {
                                        echo $row['value_isi'];
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer bg-light">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>