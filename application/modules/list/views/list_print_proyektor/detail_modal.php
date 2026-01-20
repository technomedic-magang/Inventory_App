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
            <span class="avatar avatar-lg rounded bg-pink-lt">
                <i class="fas fa-print fa-lg"></i>
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
                $bg = ($kondisi=='BAIK')?'success':(($kondisi=='RUSAK')?'danger':'warning');
            ?>
            <span class="badge bg-<?= $bg ?>"><?= $kondisi ?></span>
        </div>
    </div>

    <div class="border-dotted my-3"></div>

    <div class="row">
        <div class="col-md-5 border-end">
            <h4 class="text-muted text-uppercase small font-weight-bold mb-3">Informasi Umum</h4>
            <table class="table table-sm table-borderless">
                <tr>
                    <td class="text-muted small" width="40%">Kode Barang</td>
                    <td class="fw-bold text-dark"><?= $main['asset_kd'] ?></td>
                </tr>
                <tr>
                    <td class="text-muted small">Tahun Beli</td>
                    <td><?= $main['asset_thn_beli'] ?: '-' ?></td>
                </tr>
                <tr>
                    <td class="text-muted small">Harga</td>
                    <td class="text-blue">Rp <?= number_format($main['harga_beli'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="text-muted small">Keterangan</td>
                    <td class="small"><?= $main['asset_ket'] ?: '-' ?></td>
                </tr>
            </table>
        </div>

        <div class="col-md-7 ps-md-4">
            <h4 class="text-muted text-uppercase small font-weight-bold mb-3">Spesifikasi Detail</h4>
            
            <?php if(empty($detail_kustom)): ?>
                <div class="text-center py-4 text-muted bg-light rounded">
                    <i class="fas fa-info-circle me-1"></i> Belum ada detail spesifik.
                </div>
            <?php else: ?>
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-sm table-striped">
                        <?php foreach($detail_kustom as $row): ?>
                        <tr>
                            <td width="45%" class="fw-bold small text-muted"><?= $row['atribut_label'] ?></td>
                            <td class="small fw-bold text-dark">
                                <?php 
                                    // Auto Format Tanggal
                                    if((stripos($row['atribut_label'], 'tgl') !== false || stripos($row['atribut_label'], 'tanggal') !== false) && !empty($row['value_isi'])) {
                                        $ts = strtotime($row['value_isi']);
                                        echo ($ts) ? date('d M Y', $ts) : $row['value_isi'];
                                    } else {
                                        echo $row['value_isi'];
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="modal-footer bg-light">
    <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Tutup</button>
</div>