<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body">
        <h3 class="mb-3">Informasi Kategori</h3>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label required">Kode Kategori</label>
                <input type="text" name="kategori_kd" class="form-control" 
                       value="<?= @$main['kategori_kd'] ?>" required placeholder="ex: KAT-01">
            </div>
            <div class="col-md-8 mb-3">
                <label class="form-label required">Nama Kategori</label>
                <input type="text" name="kategori_nm" class="form-control" 
                       value="<?= @$main['kategori_nm'] ?>" required placeholder="ex: Elektronik">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Tipe Kategori</label>
                <?php
                    // Logika seleksi tipe
                    $is_aset = (@$main['kategori_tipe'] == 'ASET');
                    $is_persediaan = (@$main['kategori_tipe'] == 'PERSEDIAAN');
                ?>
                <select name="kategori_tipe" class="form-select" required>
                    <option value="ASET" <?= $is_aset ? 'selected' : '' ?>>Aset (Barang Modal)</option>
                    <option value="PERSEDIAAN" <?= $is_persediaan ? 'selected' : '' ?>>Persediaan (Habis Pakai)</option>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <div>
                    <?php
                        // Logika status aktif
                        $is_active = (@$main['active_st'] == 1 || !isset($main));
                        $is_inactive = (@$main['active_st'] == 0 && isset($main));
                    ?>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="active_st" value="1" <?= $is_active ? 'checked' : '' ?>>
                        <span class="form-check-label">Aktif</span>
                    </label>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="active_st" value="0" <?= $is_inactive ? 'checked' : '' ?>>
                        <span class="form-check-label">Non-Aktif</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal-footer justify-content-between bg-light py-2">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
        </button>
        <button type="submit" class="btn btn-primary" onclick="_save(event)">
            <i class="fas fa-save me-1"></i> Simpan Kategori
        </button>
    </div>
</form>