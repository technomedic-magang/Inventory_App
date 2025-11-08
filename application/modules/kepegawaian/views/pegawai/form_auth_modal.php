<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
  <div class="card-body">
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Pegawai Id</label>
      <div class="col-lg-4">
        <input type="text" name="pegawai_id" class="form-control" value="<?= @$main['pegawai_id'] ?>" <?= @$main ? 'required' : '' ?> readonly>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Nama Lengkap</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="pegawai_nm" class="form-control" value="<?= @$main['pegawai_nm'] ?>" readonly>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Role</label>
      <div class="col-lg-8 col-md-6">
        <select class="form-select chosen-select" name="role_id" required>
          <option value="">- None -</option>
          <?php foreach ($all_role as $role) : ?>
            <option value="<?= $role['role_id'] ?>" <?= (@$user['role_id'] == $role['role_id']) ? 'selected' : '' ?>><?= $role['role_id'] ?> - <?= $role['role_nm'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="border-dotted my-2"></div>
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Username</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="user_nm" class="form-control" value="<?= @$user['user_nm'] ?>" required>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label">Password</label>
      <div class="col-lg-8 col-md-6">
        <input type="password" name="password" class="form-control" value="">
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label">Repeat Password</label>
      <div class="col-lg-8 col-md-6">
        <input type="password" name="password_repeat" class="form-control" value="">
      </div>
    </div>
    <div class="border-dotted"></div>
    <div class="row mt-2">
      <div class="col offset-3">
        <button type="submit" class="btn btn-primary" onclick="_save(event)"><?= _icon('save') ?> Simpan</button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?= _icon('cancel') ?> Batal</button>
      </div>
    </div>
  </div>
</form>