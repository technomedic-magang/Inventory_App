<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body">
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Kategori</label>
            <div class="col-lg-8 col-md-6">
                <select name="kategori_id" id="kategori_id" class="form-select" required onchange="generateSKU()">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($list_kategori as $kat): ?>
                        <option value="<?= $kat['kategori_id'] ?>" <?= (@$main['kategori_id'] == $kat['kategori_id']) ? 'selected' : '' ?>>
                            <?= $kat['kategori_nm'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Kode Asset</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="asset_kd" id="asset_kd" class="form-control bg-light" value="<?= @$main['asset_kd'] ?>" readonly placeholder="(Otomatis)">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Nama Asset</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="asset_nm" class="form-control" value="<?= @$main['asset_nm'] ?>" required>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Satuan</label>
            <div class="col-lg-8 col-md-6">
                <select name="satuan_id" class="form-select" required>
                    <option value="">-- Pilih Satuan --</option>
                    <?php foreach ($list_satuan as $sat): ?>
                        <option value="<?= $sat['satuan_id'] ?>" <?= (@$main['satuan_id'] == $sat['satuan_id']) ? 'selected' : '' ?>>
                            <?= $sat['satuan_nm'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label">Harga Beli (Def)</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="harga_beli_def" class="form-control" value="<?= number_format(@$main['harga_beli_def'] ?? 0, 0, '', '') ?>">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label">Stok Minimal</label>
            <div class="col-lg-8 col-md-6">
                <input type="number" name="stok_min_qty" class="form-control" value="<?= number_format(@$main['stok_min_qty'] ?? 0, 0, '', '') ?>" min="0">
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label">Status</label>
            <div class="col-lg-8 col-md-6">
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="active_st" value="1" <?= (@$main['active_st'] == 1 || !isset($main)) ? 'checked' : '' ?>>
                    <span class="form-check-label">Aktif</span>
                </label>
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="active_st" value="0" <?= (@$main['active_st'] == 0 && isset($main)) ? 'checked' : '' ?>>
                    <span class="form-check-label">Tidak Aktif</span>
                </label>
            </div>
        </div>

        <div class="border-dotted my-3"></div>

        <div class="row mt-2">
            <div class="col-9 offset-3">
                <button type="submit" class="btn btn-primary" onclick="_save(event)">
                    <?= _icon('save') ?> Simpan
                </button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                    <?= _icon('cancel') ?> Batal
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    function generateSKU() {
        var kid = $('#kategori_id').val();
        // Hanya generate jika kode masih kosong (tambah baru)
        if (kid && !$('#asset_kd').val()) {
             $.ajax({
                url: '<?= $this->uri . "/get_sku_ajax?n=" . _get("n") ?>',
                type: 'POST',
                data: { kategori_id: kid },
                dataType: 'json',
                success: function(res) {
                    if (res.new_sku) $('#asset_kd').val(res.new_sku);
                }
            });
        }
    }
</script>