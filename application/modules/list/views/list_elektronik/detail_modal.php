<?php if (empty($main)): ?>
    <div class="modal-header">
        <h5 class="modal-title text-danger">Error Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body text-center">
        <p class="text-danger">Data aset tidak ditemukan atau sudah dihapus.</p>
        <p class="text-muted small">ID Aset: <?= $id_asset ?? 'Kosong' ?></p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    </div>
    <?php return; ?>
<?php endif; ?>

<div class="modal-header">
    <h5 class="modal-title">Detail Aset: <?= $main['asset_nm'] ?? '-' ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <h4 class="text-primary mb-3">Informasi Umum</h4>
            <table class="table table-sm table-borderless">
                <tr>
                    <td class="text-muted" width="40%">Kode Aset</td>
                    <td class="fw-bold"><?= $main['asset_kd'] ?? '-' ?></td>
                </tr>
                <tr>
                    <td class="text-muted">Tahun Beli (Default)</td>
                    <td><?= $main['asset_thn_beli'] ?? '-' ?></td>
                </tr>
                <tr>
                    <td class="text-muted">Harga Perolehan</td>
                    <td>Rp <?= number_format($main['harga_beli'] ?? 0, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="text-muted">Kondisi Saat Ini</td>
                    <td>
                        <?php 
                            $kondisi = $main['asset_kondisi'] ?? 'BAIK';
                            $bg = ($kondisi == 'BAIK') ? 'success' : (($kondisi == 'RUSAK') ? 'danger' : 'warning');
                        ?>
                        <span class="badge bg-<?= $bg ?>-lt"><?= $kondisi ?></span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-6">
            <h4 class="text-primary mb-3">Spesifikasi Detail</h4>
            <table class="table table-sm table-striped">
                <?php if(empty($detail_kustom)): ?>
                    <tr><td class="text-muted text-center fst-italic py-3">Tidak ada detail spesifik.</td></tr>
                <?php else: ?>
                    <?php foreach($detail_kustom as $row): ?>
                    <tr>
                        <td width="50%" class="fw-bold"><?= $row['atribut_label'] ?></td>
                        <td>
                            <?php 
                                if(strtolower($row['atribut_label']) == 'tgl pembelian' && !empty($row['value_isi'])) {
                                    echo date('d F Y', strtotime($row['value_isi']));
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
<div class="modal-footer bg-light">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>