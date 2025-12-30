<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
  <div class="card-body">
    
    <h4 class="mb-3 text-danger">Form Perubahan Kondisi</h4>

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
        <input type="text" name="transaksi_tgl" id="transaksi_tgl" 
               class="form-control datepicker-notauto" 
               value="<?= date('d-m-Y') ?>" 
               required placeholder="dd-mm-yyyy">
      </div>
    </div>

    <div class="border-dotted my-3"></div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Kategori Aset</label>
      <div class="col-lg-8 col-md-6">
        <select id="filter_kategori_id" class="form-select select2-modal">
            <option value="">-- Pilih Kategori --</option>
            <?php foreach ($list_kategori as $kat): ?>
                <option value="<?= $kat['kategori_id'] ?>">
                    <?= $kat['kategori_nm'] ?>
                </option>
            <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Pilih Aset</label>
      <div class="col-lg-8 col-md-6">
        <select name="asset_id" id="asset_id_select" class="form-select select2-modal" required disabled>
            <option value="">-- Pilih Kategori Terlebih Dahulu --</option>
        </select>
        <small class="text-muted" id="asset_info"></small>
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
    var lastDateValue = '';

    $(document).ready(function() {
        
        // 1. WATCHER TANGGAL (Auto Number)
        startDateWatcher();

        // 2. FILTER KATEGORI -> LOAD ASET (AJAX)
        $('#filter_kategori_id').change(function() {
            var kid = $(this).val();
            var $assetSelect = $('#asset_id_select');
            
            // Reset
            $assetSelect.html('<option value="">Loading...</option>').prop('disabled', true);
            $('#asset_info').text('');

            if (!kid) {
                $assetSelect.html('<option value="">-- Pilih Kategori Terlebih Dahulu --</option>');
                return;
            }

            $.ajax({
                url: '<?= site_url("asset/penyesuaian_kondisi/get_assets_by_kategori?n=" . _get("n")) ?>',
                type: 'POST', 
                data: { kategori_id: kid }, 
                dataType: 'json',
                success: function(data) {
                    var html = '<option value="">-- Pilih Aset --</option>';
                    if (data.length > 0) {
                        $.each(data, function(i, item) {
                            
                            // [MODIFIKASI] Info Detail (Merek/Spek)
                            var detailInfo = [];
                            if (item.merk) detailInfo.push(item.merk);
                            if (item.merek_tipe) detailInfo.push(item.merek_tipe);
                            if (item.spesifikasi) detailInfo.push(item.spesifikasi);
                            if (item.nopol) detailInfo.push('[' + item.nopol + ']');
                            var detailStr = detailInfo.length > 0 ? ' (' + detailInfo.join(' - ') + ')' : '';

                            html += `<option value="${item.asset_id}" data-kondisi="${item.asset_kondisi}">
                                     ${item.asset_nm}${detailStr} (${item.asset_kd})
                                     </option>`;
                        });
                    } else {
                        html = '<option value="">(Tidak ada aset tersedia di gudang)</option>';
                    }
                    $assetSelect.html(html).prop('disabled', false);
                    
                    // Re-init Select2 jika ada
                    if ($.fn.select2) {
                        $assetSelect.select2({ theme: 'bootstrap-5', dropdownParent: $('#form').closest('.modal') });
                    }
                }
            });
        });

        // 3. UPDATE INFO KONDISI SAAT INI
        $('#asset_id_select').change(function() {
            var kondisi = $(this).find(':selected').data('kondisi');
            if(kondisi) {
                $('#asset_info').html('Kondisi saat ini: '+ kondisi);
            } else {
                $('#asset_info').text('');
            }
        });
    });

    // --- FUNGSI WATCHER ---
    function startDateWatcher() {
        setInterval(function() {
            var tglInput = $('#transaksi_tgl');
            var tglVal = tglInput.val(); // Format dd-mm-yyyy

            if (tglVal && tglVal.length == 10 && tglVal !== lastDateValue) {
                lastDateValue = tglVal; 

                $.ajax({ 
                    url: '<?= site_url("asset/penyesuaian_kondisi/get_no_transaksi_ajax?n=" . _get("n")) ?>', 
                    type: 'POST', 
                    data: { tanggal: tglVal }, 
                    dataType: 'json',
                    success: function(res) { 
                        if(res.new_no) {
                            $('#transaksi_no').val(res.new_no);
                        }
                    }
                });
            }
        }, 200); 
    }
</script>