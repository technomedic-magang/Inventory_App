<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
  <div class="card-body">
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label required">Pegawai Id</label>
      <div class="col-lg-4">
        <input type="text" class="form-control" value="<?= @$main['pegawai_id'] ?>" <?= @$main ? 'required' : '' ?> readonly>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label required">Nama Lengkap</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="pegawai_nm" class="form-control" value="<?= @$main['pegawai_nm'] ?>" required>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label required">Jenis Kelamin</label>
      <div class="col-lg-8 col-md-6">
        <label class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="sex_id" value="L" <?= (@$main == '') ? 'checked' : ((@$main['sex_id'] == 'L') ? 'checked' : '') ?>>
          <span class="form-check-label">Laki - laki</span>
        </label>
        <label class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="sex_id" value="P" <?= (@$main != '') ? ((@$main['sex_id'] == 'P') ? 'checked' : '') : '' ?>>
          <span class="form-check-label">Perempuan</span>
        </label>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label" required>TTL</label>
      <div class="col-lg-4 col-md-6">
        <input type="text" name="lahir_tmp" class="form-control" value="<?= @$main['lahir_tmp'] ?>" required>
      </div>
      <div class="col-lg-4 col-md-6">
        <input type="text" name="lahir_tgl" class="form-control datepicker-notauto" value="<?= @to_date($main['lahir_tgl'], '-', 'date') ?>" required>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label">NIK</label>
      <div class="col-lg-4 col-md-6">
        <input type="text" name="nik" class="form-control" value="<?= @$main['nik'] ?>">
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label">NPWP</label>
      <div class="col-lg-4 col-md-6">
        <input type="text" name="npwp" class="form-control" value="<?= @$main['npwp'] ?>">
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label">Pendidikan</label>
      <div class="col-lg-6 col-md-6">
        <select class="form-select chosen-select" name="pendidikan_id">
          <option value="">- None -</option>
          <?php foreach ($all_pendidikan as $r) : ?>
            <option value="<?= $r['pendidikan_id'] ?>" <?= (@$main['pendidikan_id'] == $r['pendidikan_id']) ? 'selected' : '' ?>><?= $r['pendidikan_id'] ?> - <?= $r['pendidikan_nm'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label">No. Telepon</label>
      <div class="col-lg-3 col-md-6">
        <input type="text" name="telp_no" class="form-control" value="<?= @$main['telp_no'] ?>">
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label">Email</label>
      <div class="col-lg-4 col-md-6">
        <input type="email" name="email" class="form-control" value="<?= @$main['email'] ?>">
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label">Alamat</label>
      <div class="col-lg-8 col-md-6">
        <textarea type="text" name="alamat" class="form-control" rows="3"><?= @$main['alamat'] ?></textarea>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label">Tanda tangan</label>
      <div class="col-lg-4 col-md-6">
        <input type="file" name="ttd" class="form-control" value="">
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label"></label>
      <div class="col-lg-6 col-md-6">
        <img src="<?= @$main['ttd'] ?>" alt="ttd" class="img-thumbnail" width="150">
      </div>
    </div>
    <div class="border-dotted my-2"></div>
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label required">Password</label>
      <div class="col-lg-4 col-md-6">
        <input type="password" name="password" class="form-control" value="">
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-2 col-md-6 col-form-label required">Repeat Pass</label>
      <div class="col-lg-4 col-md-6">
        <input type="password" name="password_repeat" class="form-control" value="">
      </div>
    </div>
    <div class="border-dotted"></div>
    <div class="border-dotted"></div>
    <div class="row mt-2">
      <div class="col-10 offset-2">
        <button type="submit" class="btn btn-primary" onclick="_save(event)"><?= _icon('save') ?> Simpan</button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?= _icon('cancel') ?> Batal</button>
      </div>
    </div>
  </div>
</form>