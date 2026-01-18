<?php if (empty($main)): ?>
    <div class="modal-body text-center text-danger">
        <i class="fas fa-exclamation-circle fa-2x mb-2"></i><br>
        Data tidak ditemukan atau sudah dihapus.
    </div>
    <?php return; ?>
<?php endif; ?>

<div class="modal-body">
    
    <div class="d-flex align-items-center mb-3">
        <div class="me-3">
            <span class="avatar avatar-lg rounded bg-blue-lt">
                <i class="fas fa-car fa-lg"></i>
            </span>
        </div>
        <div>
            <h3 class="m-0 text-primary"><?= $main['asset_nm'] ?></h3>
            <div class="text-muted small">
                Kode Aset: <strong><?= $main['asset_kd'] ?></strong>
            </div>
        </div>
        <div class="ms-auto">
            <?php 
                $kondisi = $main['asset_kondisi'];
                $bg_badge = ($kondisi=='BAIK')?'success':(($kondisi=='RUSAK')?'danger':'warning');
            ?>
            <span class="badge bg-<?= $bg_badge ?>"><?= $kondisi ?></span>
        </div>
    </div>

    <div class="border-dotted my-3"></div>

    <div class="row">
        <div class="col-md-6 border-end">
            <h4 class="text-muted text-uppercase small font-weight-bold mb-3">Data Umum Aset</h4>
            <table class="table table-sm table-borderless">
                <tr>
                    <td class="text-muted" width="40%">Tahun Pembuatan</td>
                    <td class="fw-bold"><?= $main['asset_thn_beli'] ?: '-' ?></td>
                </tr>
                <tr>
                    <td class="text-muted">Harga Perolehan</td>
                    <td class="fw-bold text-blue">Rp <?= number_format($main['harga_beli'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="text-muted">Tgl Pembelian</td>
                    <td><?= $main['beli_tgl'] ? date('d-m-Y', strtotime($main['beli_tgl'])) : '-' ?></td>
                </tr>
            </table>
        </div>

        <div class="col-md-6 ps-md-4">
            <h4 class="text-muted text-uppercase small font-weight-bold mb-3">Spesifikasi Detail</h4>
            
            <?php if(empty($detail_kustom)): ?>
                <div class="text-center py-4 text-muted bg-light rounded">
                    <i class="fas fa-info-circle me-1"></i> Belum ada data spesifik.
                </div>
            <?php else: ?>
                <table class="table table-sm table-striped">
                    <?php foreach($detail_kustom as $row): ?>
                    <tr>
                        <td width="45%" class="text-muted"><?= $row['atribut_label'] ?></td>
                        <td class="fw-bold text-dark"><?= $row['value_isi'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>

</div>
<div class="modal-footer bg-light">
    <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Tutup</button>
</div>