<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="card-body">
        
        <h4 class="mb-3 text-primary">Data Mutasi (Pindah Tangan)</h4>
        
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">No. Dokumen</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="transaksi_no" id="transaksi_no" class="form-control bg-light" 
                       value="<?= @$preview_no ?>" readonly>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Tanggal Mutasi</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="transaksi_tgl" id="transaksi_tgl" 
                       class="form-control datepicker-notauto" 
                       value="<?= date('d-m-Y') ?>" 
                       required placeholder="dd-mm-yyyy">
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Dari Pegawai</label>
            <div class="col-lg-8 col-md-6">
                <select name="pegawai_asal" id="pegawai_asal" class="form-select select2-modal" required>
                    <option value="">-- Pilih Pemegang Saat Ini --</option>
                    <?php foreach($list_pegawai as $p): ?>
                        <option value="<?= $p['pegawai_id'] ?>"><?= $p['pegawai_nm'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Ke Pegawai</label>
            <div class="col-lg-8 col-md-6">
                <select name="pegawai_tujuan" id="pegawai_tujuan" class="form-select select2-modal" required>
                    <option value="">-- Pilih Penerima --</option>
                    <?php foreach($list_pegawai as $p): ?>
                        <option value="<?= $p['pegawai_id'] ?>"><?= $p['pegawai_nm'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label">Keterangan</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="keterangan" class="form-control" placeholder="Alasan mutasi...">
            </div>
        </div>

        <div class="border-dotted my-3"></div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label fw-bold">Pilih Aset</label>
            <div class="col-lg-9 col-md-12">
                <div id="list_asset_area" class="border rounded p-2 bg-light" style="max-height: 200px; overflow-y: auto;">
                    <div class="text-center p-2 fst-italic text-muted">Pilih "Dari Pegawai" terlebih dahulu...</div>
                </div>
                <small class="text-muted">*Centang aset yang akan dipindahkan.</small>
            </div>
        </div>

        <div class="border-dotted mt-3"></div>

        <div class="row mt-2">
            <div class="col-9 offset-3">
                <button type="submit" class="btn btn-primary" onclick="_save(event)">
                    <?= _icon('exchange-alt') ?> Proses Mutasi
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
        // Init Select2
        $('.select2-modal').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#form').closest('.modal'),
            width: '100%'
        });
        
        startDateWatcher();
    });

    // Fungsi Watcher Tanggal (Auto Number)
    function startDateWatcher() {
        setInterval(function() {
            var tglInput = $('#transaksi_tgl');
            var tglVal = tglInput.val(); 

            if (tglVal && tglVal.length == 10 && tglVal !== lastDateValue) {
                lastDateValue = tglVal; 

                // [FIX URL] Gunakan Full URL dari controller
                $.ajax({ 
                    url: '<?= $this->uri . "/get_no_transaksi_ajax?n=" . _get("n") ?>', 
                    type: 'POST', 
                    data: { tanggal: tglVal }, 
                    dataType: 'json',
                    success: function(res) { 
                        if(res && res.new_no) {
                            $('#transaksi_no').val(res.new_no);
                        }
                    }
                });
            }
        }, 500); 
    }

    // Logika Load Aset saat Pegawai Asal Berubah
    $('#pegawai_asal').on('change', function(){
        var pid = $(this).val(); 
        var $area = $('#list_asset_area');
        
        // Reset Dropdown Tujuan agar tidak bisa pilih pegawai yang sama
        var $tujuanSelect = $('#pegawai_tujuan');
        $tujuanSelect.find('option').prop('disabled', false);
        if (pid) {
            $tujuanSelect.find('option[value="' + pid + '"]').prop('disabled', true);
            // Jika terpilih sama, reset
            if ($tujuanSelect.val() == pid) { 
                $tujuanSelect.val('').trigger('change'); 
            }
        }

        if (!pid) {
            $area.html('<div class="text-center p-2 fst-italic text-muted">Pilih "Dari Pegawai" terlebih dahulu...</div>');
            return;
        }

        $area.html('<div class="text-center p-2"><span class="spinner-border spinner-border-sm"></span> Memuat aset...</div>');

        // [FIX URL] AJAX Call
        $.ajax({
            url: '<?= $this->uri . "/get_pegawai_assets?n=" . _get("n") ?>',
            type: 'POST',
            data: { pegawai_id: pid },
            dataType: 'json',
            success: function(data){
                if(data && data.length > 0){
                    var html = '<table class="table table-sm table-striped mb-0 table-hover">';
                    html += '<thead><tr><th width="40" class="text-center">Pilih</th><th>Kode</th><th>Nama Aset</th><th>Detail</th></tr></thead><tbody>';
                    
                    $.each(data, function(i, v){
                        // Helper tampilan detail
                        var detailInfo = [];
                        if (v.merk) detailInfo.push(v.merk);
                        if (v.spesifikasi) detailInfo.push(v.spesifikasi);
                        var detailStr = detailInfo.length > 0 ? detailInfo.join(', ') : '-';

                        html += '<tr>' +
                                    '<td class="text-center align-middle">' +
                                        '<div class="form-check d-flex justify-content-center m-0">' +
                                            '<input type="checkbox" name="asset_id[]" value="' + v.asset_id + '" class="form-check-input cursor-pointer" id="chk_' + v.asset_id + '">' +
                                            '<input type="hidden" name="pemakaian_id[]" value="' + v.pemakaian_id + '" disabled id="hdn_' + v.asset_id + '">' +
                                        '</div>' +
                                    '</td>' +
                                    '<td class="align-middle"><label class="cursor-pointer m-0 w-100" for="chk_' + v.asset_id + '">' + v.asset_kd + '</label></td>' +
                                    '<td class="align-middle fw-bold"><label class="cursor-pointer m-0 w-100" for="chk_' + v.asset_id + '">' + v.asset_nm + '</label></td>' +
                                    '<td class="align-middle"><label class="cursor-pointer m-0 w-100 text-muted small" for="chk_' + v.asset_id + '">' + detailStr + '</label></td>' +
                                '</tr>';
                    });
                    html += '</tbody></table>';
                    $area.html(html);
                    
                    // Logic enable hidden input pemakaian_id saat checkbox dicentang
                    $('input[name="asset_id[]"]').change(function(){
                        var aid = $(this).val();
                        var isChecked = $(this).is(':checked');
                        $('#hdn_' + aid).prop('disabled', !isChecked);
                    });

                } else {
                    $area.html('<div class="alert alert-warning small m-0 text-center">Pegawai ini tidak memegang aset apapun.</div>');
                }
            },
            error: function() {
                $area.html('<div class="text-danger small text-center p-2">Gagal memuat data.</div>');
            }
        });
    });
</script>