<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body">
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Kode Gudang</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="gudang_kd" class="form-control bg-light" value="<?= @$main['gudang_kd'] ?>" readonly required>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Nama Gudang</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="gudang_nm" class="form-control" value="<?= @$main['gudang_nm'] ?>" required placeholder="Contoh: Gudang Pusat">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label">Alamat</label>
            <div class="col-lg-8 col-md-6">
                <textarea name="gudang_alm" class="form-control" rows="2"><?= @$main['gudang_alm'] ?></textarea>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label">PIC</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="pic_nm" class="form-control" value="<?= @$main['pic_nm'] ?>" placeholder="Nama Penanggung Jawab">
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