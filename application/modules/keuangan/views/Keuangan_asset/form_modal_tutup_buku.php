<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body">
        
        <div class="alert alert-warning border-warning">
            <div class="d-flex">
                <div class="me-2"><i class="fas fa-exclamation-triangle fa-2x"></i></div>
                <div>
                    <h4 class="alert-title">Konfirmasi Tutup Buku</h4>
                    <div class="text-muted small">
                        Anda akan melakukan penutupan buku untuk periode <strong><?= $periode_text ?></strong>. 
                        Data nilai aset saat ini akan disimpan permanen dan <strong>tidak dapat dibatalkan</strong>.
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-3 text-primary">Preview Ringkasan</h4>
        
        <div class="card card-sm mb-3 bg-light">
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-2 border-bottom pb-2">
                        <div class="text-muted small text-uppercase">Total Aset</div>
                        <div class="fw-bold"><?= number_format($total_asset,0,',','.') ?> Unit</div>
                    </div>
                    <div class="col-6 mb-2 border-bottom pb-2 text-end">
                        <div class="text-muted small text-uppercase">Total Perolehan</div>
                        <div class="fw-bold text-blue">Rp <?= number_format($summary['total_aset_awal'], 0, ',', '.') ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small text-uppercase">Akumulasi Susut</div>
                        <div class="fw-bold text-red">Rp <?= number_format($summary['total_akumulasi'], 0, ',', '.') ?></div>
                    </div>
                    <div class="col-6 text-end">
                        <div class="text-muted small text-uppercase">Nilai Buku Akhir</div>
                        <div class="fw-bold text-green">Rp <?= number_format($summary['total_nilai_buku'], 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label required">Verifikasi Keamanan</label>
            <div class="input-group">
                <input type="text" name="confirm_text" class="form-control" placeholder="Ketik: SETUJU" autocomplete="off">
                <span class="input-group-text bg-warning-lt fw-bold">SETUJU</span>
            </div>
            <input type="hidden" name="periode_kd" value="<?= $periode ?>">
        </div>

        <div class="row mt-3">
            <div class="col-12 text-end">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning" id="btn_save_tutup" onclick="_save(event)" disabled>
                    <i class="fas fa-lock me-1"></i> Proses Tutup Buku
                </button>
            </div>
        </div>

    </div>
</form>

<script>
    // Hanya logika buka kunci tombol, submit ditangani oleh _save(event) sistem
    $('input[name="confirm_text"]').on('input keyup', function(){
        if($(this).val() === 'SETUJU') {
            $('#btn_save_tutup').removeAttr('disabled').removeClass('btn-warning').addClass('btn-danger');
        } else {
            $('#btn_save_tutup').attr('disabled', true).removeClass('btn-danger').addClass('btn-warning');
        }
    });
</script>