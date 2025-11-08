<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
  <div class="card-body">
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label">Parent</label>
      <div class="col-lg-8 col-md-6">
        <select class="form-select chosen-select" name="divisi_parent">
          <option value="">- None -</option>
          <?php foreach ($parent as $par) : ?>
            <option value="<?= $par['divisi_id'] ?>" <?= (@$main['divisi_parent'] == $par['divisi_id']) ? 'selected' : '' ?>><?= $par['divisi_id'] ?> - <?= $par['divisi_nm'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Divisi Id</label>
      <div class="col-lg-4">
        <input type="text" name="divisi_id" class="form-control" value="<?= @$main['divisi_id'] ?>" required>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Divisi</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="divisi_nm" class="form-control" value="<?= @$main['divisi_nm'] ?>" required>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Aktif?</label>
      <div class="col-lg-8 col-md-6">
        <label class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="active_st" value="1" <?= (@$main == '') ? 'checked' : ((@$main['active_st'] == 1) ? 'checked' : '') ?>>
          <span class="form-check-label">Aktif</span>
        </label>
        <label class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="active_st" value="0" <?= (@$main != '') ? ((@$main['active_st'] == 0) ? 'checked' : '') : '' ?>>
          <span class="form-check-label">Tidak Aktif</span>
        </label>
      </div>
    </div>
    <div class="border-dotted"></div>
    <div class="row mt-2">
      <div class="col-9 offset-3">
        <button type="submit" class="btn btn-primary" onclick="_save(event)"><?= _icon('save') ?> Simpan</button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?= _icon('cancel') ?> Batal</button>
      </div>
    </div>
  </div>
</form>