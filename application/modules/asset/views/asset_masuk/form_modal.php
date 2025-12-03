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
      <label class="col-lg-3 col-md-6 col-form-label required">Filter Kategori</label>
      <div class="col-lg-8 col-md-6">
        <select id="filter_kategori_id" class="form-select">
            <option value="">-- Pilih Kategori --</option>
            <?php foreach ($list_kategori as $kat): ?>
                <option value="<?= $kat['kategori_id'] ?>" data-kode="<?= $kat['kategori_kd'] ?>">
                    <?= $kat['kategori_nm'] ?>
                </option>
            <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Pilih Aset</label>
      <div class="col-lg-8 col-md-6">
        <select name="asset_id" id="asset_id_select" class="form-select" required disabled>
            <option value="">-- Pilih Kategori Terlebih Dahulu --</option>
        </select>
      </div>
    </div>

    <div id="area-form-dinamis"></div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">No. Transaksi</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="transaksi_no" id="transaksi_no" class="form-control bg-light" 
               value="" placeholder="(Otomatis terisi...)" readonly>
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
    // 1. Ktika Kategori Dipilih -> Load Aset
    $('#filter_kategori_id').change(function() {
        var kategori_id = $(this).val();
        var $assetSelect = $('#asset_id_select');
        
        // Reset Form
        $assetSelect.html('<option value="">Loading...</option>').prop('disabled', true);
        $('#area-form-dinamis').html('');
        $('#transaksi_no').val('');

        if (!kategori_id) {
            $assetSelect.html('<option value="">-- Pilih Kategori Terlebih Dahulu --</option>');
            return;
        }

        // A. Panggil Daftar Aset via AJAX
        $.ajax({
            url: '<?= $this->uri . "/get_list_asset_by_kategori?n=" . _get("n") ?>',
            type: 'POST',
            data: { kategori_id: kategori_id },
            dataType: 'json',
            success: function(data) {
                var html = '<option value="">-- Pilih Aset --</option>';
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        // Simpan data-kategori_kd di option aset
                        html += `<option value="${item.asset_id}" 
                                         data-sku="${item.asset_kd}" 
                                         data-kategori_kd="${item.kategori_kd}">
                                    ${item.asset_nm} (${item.asset_kd})
                                 </option>`;
                    });
                } else {
                    html = '<option value="">(Tidak ada aset baru di kategori ini)</option>';
                }
                $assetSelect.html(html).prop('disabled', false);
            }
        });

        // B. Panggil Form Dinamis (Jika Kategori butuh Lokasi)
        var $optionKat = $(this).find(':selected');
        var kategori_kd = $optionKat.data('kode');
        
        // Daftar Kode Kategori yang butuh input Ruangan/Lantai
        var kategori_wajib_lokasi = ['EL', 'MB', 'KP', 'ACC', 'PB', 'K2', 'K4', 'PRN', 'LCD'];

        if (kategori_kd && kategori_wajib_lokasi.includes(kategori_kd)) {
            $('#area-form-dinamis').html('<div class="text-center small p-2">Memuat form lokasi...</div>');
            $.ajax({
                url: '<?= $this->uri . "/get_form_dinamis_by_kategori?n=" . _get("n") ?>',
                type: 'POST', data: { kategori_kd: kategori_kd }, dataType: 'json',
                success: function(res) {
                    if(res.html) $('#area-form-dinamis').html(res.html);
                    else $('#area-form-dinamis').html('');
                }
            });
        }
    });

    // 2. Saat Aset Dipilih -> Update SKU Transaksi
    $('#asset_id_select').change(function() {
        updateTransaksiNo();
    });

    // 3. Saat Tanggal Berubah -> Update SKU Transaksi
    $('#transaksi_tgl_input').change(function() {
        updateTransaksiNo();
    });

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
                    if(response.status) $('#transaksi_no').val(response.transaksi_no);
                    else $('#transaksi_no').val(response.transaksi_no || 'Error');
                }
            });
        }
    }
</script>