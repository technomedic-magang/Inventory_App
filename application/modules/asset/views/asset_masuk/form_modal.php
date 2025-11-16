<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
  <div class="card-body"> 
    
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Gudang Tujuan</label>
      <div class="col-lg-8 col-md-6">
        <select name="gudang_id" class="form-select" required>
            <option value="">-- Pilih Gudang --</option>
            <?php foreach ($list_gudang as $gdg): ?>
                <option value="<?= $gdg['gudang_id'] ?>"><?= $gdg['gudang_nm'] ?></option>
            <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Tanggal Masuk</label>
      <div class="col-lg-8 col-md-6">
        <input type="date" name="transaksi_tgl" id="transaksi_tgl_input" class="form-control" value="<?= date('Y-m-d') ?>" required>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Pilih Aset</label>
      <div class="col-lg-8 col-md-6">
        <select name="asset_id" id="asset_id_select" class="form-select" required>
            <option value="">-- Pilih Aset (Tipe ASET saja) --</option>
            <?php foreach ($list_asset as $ast): ?>
                <option value="<?= $ast['asset_id'] ?>" data-sku="<?= $ast['asset_kd'] ?>">
                    <?= $ast['asset_nm'] ?> (<?= $ast['asset_kd'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">No. Transaksi</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="transaksi_no" id="transaksi_no" class="form-control bg-light" 
               value="" 
               placeholder="(Otomatis terisi...)" readonly>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label">Keterangan</label>
      <div class="col-lg-8 col-md-6">
        <textarea name="detail_ket" class="form-control" rows="2" placeholder="Catatan..."></textarea>
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

<script>
    function updateTransaksiNo() {
        var tgl = $('#transaksi_tgl_input').val();
        var asset_id = $('#asset_id_select').val();
        if (tgl && asset_id) {
            $('#transaksi_no').val('Generating...');
            $.ajax({
                url: '<?= $this->uri . "/get_no_transaksi_ajax?n=" . _get("n") ?>',
                type: 'POST',
                data: { tanggal: tgl, asset_id: asset_id },
                dataType: 'json',
                success: function(response) {
                    if(response.status) {
                        $('#transaksi_no').val(response.transaksi_no);
                    } else {
                        $('#transaksi_no').val(response.transaksi_no || 'Error');
                    }
                }
            });
        } else {
            $('#transaksi_no').val('(Otomatis terisi...)');
        }
    }
    $(document).on('change', '#asset_id_select, #transaksi_tgl_input', updateTransaksiNo);
</script>