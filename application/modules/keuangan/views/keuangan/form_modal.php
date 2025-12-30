<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <input type="hidden" name="asset_id" value="<?= @$data['asset_id'] ?>">

    <div class="card-body">
        <h4 class="mb-3 text-primary">Setting Nilai & Valuasi Aset</h4>
        
        <div class="mb-2 row">
            <label class="col-4 col-form-label">Nama Aset</label>
            <div class="col-8">
                <input type="text" class="form-control" value="<?= @$data['asset_nm'] ?>" readonly>
            </div>
        </div>

        <div class="mb-2 row">
            <label class="col-4 col-form-label required">Metode Valuasi</label>
            <div class="col-8">
                <select name="valuasi_metode" class="form-select" required>
                    <option value="DEPRESIASI" <?= (@$data['valuasi_metode'] == 'DEPRESIASI') ? 'selected' : '' ?>>
                        DEPRESIASI (Nilai Turun)
                    </option>
                    <option value="APRESIASI" <?= (@$data['valuasi_metode'] == 'APRESIASI') ? 'selected' : '' ?>>
                        APRESIASI (Nilai Naik)
                    </option>
                </select>
            </div>
        </div>

        <div class="mb-2 row">
            <label class="col-4 col-form-label required">Harga Perolehan</label>
            <div class="col-8">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="beli_nominal" class="form-control rupiah" 
                           value="<?= number_format(@$data['beli_nominal'],0,',','.') ?>" required>
                </div>
            </div>
        </div>

        <div class="mb-2 row">
            <label class="col-4 col-form-label required">Tanggal Beli</label>
            <div class="col-8">
                <input type="date" name="beli_tgl" class="form-control" 
                       value="<?= @$data['beli_tgl'] ?>" required>
            </div>
        </div>

        <div class="mb-2 row">
            <label class="col-4 col-form-label required">Masa Pakai (Bln)</label>
            <div class="col-8">
                <input type="number" name="pakai_masa_bln" class="form-control" min="1" 
                       value="<?= @$data['pakai_masa_bln'] ?>">
            </div>
        </div>

        <div class="mb-2 row">
            <label class="col-4 col-form-label required">Nilai Batas (Residu)</label>
            <div class="col-8">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="residu_nominal" class="form-control rupiah" 
                           value="<?= number_format(@$data['residu_nominal'],0,',','.') ?>" required>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 text-end">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="_save(event)">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $('.rupiah').on('keyup', function(e){
        var n = parseInt($(this).val().replace(/\D/g,''),10);
        if(isNaN(n)) n = 0;
        $(this).val(n.toLocaleString('id-ID'));
    });
</script>