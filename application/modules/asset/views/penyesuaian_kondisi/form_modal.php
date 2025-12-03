<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
  <div class="card-body">
    
    <h4 class="mb-3 text-danger">Form Perubahan Kondisi</h4>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Aset</label>
      <div class="col-lg-8 col-md-6">
        <select name="asset_id" id="asset_id_select" class="form-select" required>
            <option value="">-- Pilih Aset --</option>
            <?php foreach ($list_asset as $ast): ?>
                <option value="<?= $ast['asset_id'] ?>">
                    <?= $ast['asset_nm'] ?> (<?= $ast['asset_kd'] ?>) - Saat ini: <?= $ast['asset_kondisi'] ?>
                </option>
            <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">No. Dokumen</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="transaksi_no" id="transaksi_no" class="form-control bg-light" 
               value="<?= @$main['transaksi_no'] ?? @$preview_no ?>" readonly>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Tanggal Laporan</label>
      <div class="col-lg-8 col-md-6">
        <input type="date" name="transaksi_tgl" id="transaksi_tgl" class="form-control" value="<?= date('Y-m-d') ?>" required>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Ubah Menjadi</label>
      <div class="col-lg-8 col-md-6">
        <select name="kondisi_ke" class="form-select" required>
            <option value="">-- Pilih Kondisi Baru --</option>
            <option value="BAIK">BAIK (Layak Pakai)</option>
            <option value="RUSAK">RUSAK (Butuh Perbaikan)</option>
            <option value="PERBAIKAN">SEDANG DIPERBAIKI (Service)</option>
            <option value="MUSNAH">MUSNAH (Hilang/Dibuang)</option>
        </select>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label">Keterangan</label>
      <div class="col-lg-8 col-md-6">
        <textarea name="transaksi_ket" class="form-control" rows="3" placeholder="Kronologi kerusakan atau perbaikan..."></textarea>
      </div>
    </div>
    
    <div class="border-dotted mt-3"></div>
    
    <div class="row mt-2">
      <div class="col-9 offset-3">
        <button type="submit" class="btn btn-danger" onclick="_save(event)">
            <?= _icon('save') ?> Simpan Perubahan
        </button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
            <?= _icon('cancel') ?> Batal
        </button>
      </div>
    </div>
  </div>
</form>

<script>
    // Script Auto Number (FIXED)
    $(document).on('change', '#transaksi_tgl', function() {
        var tgl = $(this).val(); 
        $('#transaksi_no').val('Loading...');
        
        $.ajax({ 
            url: '<?= $this->uri . "/get_no_transaksi_ajax?n=" . _get("n") ?>', 
            type: 'POST', 
            data: { tanggal: tgl }, 
            dataType: 'json', 
            success: function(res) { 
                // Ambil properti 'new_no' dari objek JSON
                if(res.new_no) {
                    $('#transaksi_no').val(res.new_no); 
                } else {
                    $('#transaksi_no').val('Error');
                }
            },
            error: function() {
                $('#transaksi_no').val('Gagal Koneksi');
            }
        });
    });
</script>