<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-select" required onchange="generateSKU()">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($list_kategori as $kat): ?>
                        <option value="<?= $kat['kategori_id'] ?>" <?= (@$main['kategori_id'] == $kat['kategori_id']) ? 'selected' : '' ?>>
                            <?= $kat['kategori_nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label required">Kode Barang (SKU)</label>
                <div class="input-group">
                    <input type="text" name="asset_kode" id="asset_kode" class="form-control" value="<?= @$main['asset_kode'] ?>" placeholder="Pilih kategori dulu..." readonly>
                    <button class="btn btn-outline-secondary" type="button" onclick="generateSKU()" title="Generate Ulang SKU">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <small class="text-muted">Otomatis terisi saat kategori dipilih.</small>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label required">Nama Barang</label>
            <input type="text" name="asset_nama" class="form-control" value="<?= @$main['asset_nama'] ?>" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Satuan</label>
                <select name="satuan_id" class="form-select" required>
                    <option value="">-- Pilih Satuan --</option>
                    <?php foreach ($list_satuan as $sat): ?>
                        <option value="<?= $sat['satuan_id'] ?>" <?= (@$main['satuan_id'] == $sat['satuan_id']) ? 'selected' : '' ?>>
                            <?= $sat['satuan_nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Stok Minimal (Alarm)</label>
                <input type="number" name="stok_minimal" class="form-control" value="<?= @$main['stok_minimal'] ?? 0 ?>" min="0">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="2"><?= @$main['keterangan'] ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <div>
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="active_st" value="1" <?= (@$main['active_st'] == 1 || !isset($main)) ? 'checked' : '' ?>>
                    <span class="form-check-label">Aktif</span>
                </label>
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="active_st" value="0" <?= (@$main['active_st'] == 0 && isset($main)) ? 'checked' : '' ?>>
                    <span class="form-check-label">Non-Aktif</span>
                </label>
            </div>
        </div>
    </div>
<div class="row mt-2">
      <div class="col-9 offset-3">
        <button type="submit" class="btn btn-primary" onclick="_save(event)"><?= _icon('save') ?> Simpan</button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?= _icon('cancel') ?> Batal</button>
      </div>
    </div>
</form>

<script>
    // Fungsi AJAX untuk minta SKU baru ke server
    function generateSKU() {
        var kategori_id = $('#kategori_id').val();
        // Hanya generate jika ini mode TAMBAH BARU (input SKU masih kosong/readonly dan belum tersimpan)
        // Atau jika user memaksa klik tombol refresh
        if (kategori_id) {
            $.ajax({
                url: '<?= $this->uri . "/get_sku_ajax?n=" . _get("n") ?>',
                type: 'POST',
                data: { kategori_id: kategori_id },
                dataType: 'json',
                success: function(response) {
                    if (response.new_sku) {
                        $('#asset_kode').val(response.new_sku);
                    } else {
                         // Jika kategori tidak punya prefix, biarkan user isi manual atau kosongkan
                        $('#asset_kode').val('');
                        $('#asset_kode').removeAttr('readonly'); 
                        $('#asset_kode').attr('placeholder', 'Isi kode manual...');
                    }
                }
            });
        } else {
            $('#asset_kode').val('');
        }
    }
</script>