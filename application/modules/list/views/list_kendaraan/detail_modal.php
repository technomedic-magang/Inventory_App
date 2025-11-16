<?php if (empty($main)): ?>
    <div class="modal-body text-center text-danger">Data tidak ditemukan.</div>
    <?php return; ?>
<?php endif; ?>

<div class="modal-header">
    <h5 class="modal-title">Detail Kendaraan: <?= $main['asset_nm'] ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <h4 class="text-primary mb-3">Data Aset</h4>
            <table class="table table-sm table-borderless">
                <tr><td class="text-muted" width="40%">Kode Aset</td><td class="fw-bold"><?= $main['asset_kd'] ?></td></tr>
                <tr><td class="text-muted">Nama Unit</td><td><?= $main['asset_nm'] ?></td></tr>
                <tr><td class="text-muted">Tahun Pembuatan</td><td><?= $main['asset_thn_beli'] ?></td></tr>
                <tr><td class="text-muted">Harga Beli</td><td>Rp <?= number_format($main['harga_beli'], 0, ',', '.') ?></td></tr>
                <tr><td class="text-muted">Kondisi</td>
                    <td><span class="badge bg-<?= ($main['asset_kondisi']=='BAIK')?'success':(($main['asset_kondisi']=='RUSAK')?'danger':'warning') ?>-lt"><?= $main['asset_kondisi'] ?></span></td>
                </tr>
            </table>
        </div>

        <div class="col-md-6">
            <h4 class="text-primary mb-3">Spesifikasi Kendaraan</h4>
            <table class="table table-sm table-striped">
                <?php if(empty($detail_kustom)): ?>
                    <tr><td class="text-muted text-center fst-italic">Belum ada data spesifik.</td></tr>
                <?php else: ?>
                    <?php foreach($detail_kustom as $row): ?>
                    <tr>
                        <td width="50%" class="fw-bold"><?= $row['atribut_label'] ?></td>
                        <td><?= $row['value_isi'] ?></td>
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