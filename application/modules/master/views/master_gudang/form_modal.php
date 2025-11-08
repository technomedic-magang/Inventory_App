<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label required">Kode Gudang</label>
                <input type="text" name="gudang_kd" class="form-control bg-light" value="<?= @$main['gudang_kd'] ?>" readonly required>
            </div>
            <div class="col-md-8 mb-3">
                <label class="form-label required">Nama Gudang</label>
                <input type="text" name="gudang_nm" class="form-control" value="<?= @$main['gudang_nm'] ?>" required placeholder="Contoh: Gudang Pusat A">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="gudang_alm" class="form-control" rows="3"><?= @$main['gudang_alm'] ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Penanggung Jawab (PIC)</label>
                <input type="text" name="pic_nm" class="form-control" value="<?= @$main['pic_nm'] ?>" placeholder="Nama PIC">
            </div>
             <div class="col-md-6 mb-3">
                <label class="form-label">Status Gudang</label>
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

        <div class="mb-3">
            <label class="form-label">Keterangan Tambahan</label>
            <textarea name="gudang_ket" class="form-control" rows="2"><?= @$main['gudang_ket'] ?></textarea>
        </div>
    </div>
    <div class="row mt-2">
      <div class="col-9 offset-3">
        <button type="submit" class="btn btn-primary" onclick="_save(event)"><?= _icon('save') ?> Simpan</button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?= _icon('cancel') ?> Batal</button>
      </div>
    </div>
</form>