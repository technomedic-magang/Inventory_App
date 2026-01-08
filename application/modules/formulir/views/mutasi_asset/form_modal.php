<<<<<<< HEAD
<form id="form" action="<?= $form_act ?>" method="post">
<div class="card-body">
    <h4 class="text-primary mb-3">Form Mutasi (Pindah Tangan)</h4>
    
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label required">Dari Pegawai (Pemegang Saat Ini)</label>
            <select name="pegawai_asal" id="pegawai_asal" class="form-select" required>
                <option value="">-- Pilih Pegawai Asal --</option>
                <?php foreach($list_pegawai as $p): ?>
                    <option value="<?= $p['pegawai_id'] ?>"><?= $p['pegawai_nm'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label required">Ke Pegawai (Penerima)</label>
            <select name="pegawai_tujuan" class="form-select" required>
                <option value="">-- Pilih Pegawai Tujuan --</option>
                <?php foreach($list_pegawai as $p): ?>
                    <option value="<?= $p['pegawai_id'] ?>"><?= $p['pegawai_nm'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal Mutasi</label>
        <input type="date" name="tgl_mutasi" class="form-control" value="<?= date('Y-m-d') ?>" required>
    </div>

    <div class="border p-3 rounded bg-light mb-3">
        <label class="form-label fw-bold">Pilih Aset yang Dimutasi:</label>
        <div id="list_asset_area" class="text-muted small" style="max-height: 200px; overflow-y: auto;">
            <div class="text-center p-2 fst-italic">Pilih "Dari Pegawai" terlebih dahulu...</div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Keterangan</label>
        <textarea name="keterangan" class="form-control" placeholder="Alasan mutasi..."></textarea>
    </div>

    <div class="row mt-2">
      <div class="col-12 text-end">
        <button type="submit" class="btn btn-primary" onclick="_save(event)">Proses Mutasi</button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
</div>
</form>

<script>
$('#pegawai_asal').change(function(){
    var pid = $(this).val();
    var $area = $('#list_asset_area');

    // Reset area
    $area.html('<div class="text-center p-2"><span class="spinner-border spinner-border-sm"></span> Memuat aset...</div>');
    
    if (!pid) {
        $area.html('<div class="text-center p-2 fst-italic">Pilih "Dari Pegawai" terlebih dahulu...</div>');
        return;
    }

    $.ajax({
        // [FIX] Gunakan format URL lengkap dengan token ?n=...
        url: '<?= $this->uri . "/get_pegawai_assets?n=" . _get("n") ?>',
        type: 'POST',
        data: { pegawai_id: pid },
        dataType: 'json',
        success: function(data){
            if(data && data.length > 0){
                var html = '<table class="table table-sm table-striped mb-0 table-hover">';
                html += '<thead><tr><th width="40" class="text-center">Pilih</th><th>Kode</th><th>Nama Aset</th></tr></thead><tbody>';
                
                $.each(data, function(i, v){
                    html += `<tr>
                        <td class="text-center">
                            <div class="form-check d-flex justify-content-center m-0">
                                <input type="checkbox" name="asset_id[]" value="${v.asset_id}" class="form-check-input cursor-pointer" id="chk_${v.asset_id}">
                                <input type="hidden" name="pemakaian_id[]" value="${v.pemakaian_id}" disabled id="hdn_${v.asset_id}">
                            </div>
                        </td>
                        <td><label class="cursor-pointer m-0 w-100" for="chk_${v.asset_id}">${v.asset_kd}</label></td>
                        <td><label class="cursor-pointer m-0 w-100" for="chk_${v.asset_id}">${v.asset_nm}</label></td>
                    </tr>`;
                });
                html += '</tbody></table>';
                $area.html(html);
                
                // Helper: Aktifkan hidden input saat checkbox dipilih
                $('input[name="asset_id[]"]').change(function(){
                    var aid = $(this).val();
                    var isChecked = $(this).is(':checked');
                    $('#hdn_' + aid).prop('disabled', !isChecked);
                });

            } else {
                $area.html('<div class="alert alert-warning small m-0">Pegawai ini tidak sedang memegang aset apapun (Status OPEN).</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $area.html('<div class="text-danger small text-center p-2">Gagal memuat data. Cek Console.</div>');
        }
    });
});
=======
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
        // [ADAPTASI] Jalankan Watcher agar Auto Number responsif
        startDateWatcher();
    });

    // --- FUNGSI WATCHER (PEMANTAU TANGGAL) ---
    // Sama persis dengan modul Pemakaian, hanya URL Ajax nya beda
    function startDateWatcher() {
        setInterval(function() {
            var tglInput = $('#transaksi_tgl');
            var tglVal = tglInput.val(); // Format dd-mm-yyyy

            if (tglVal && tglVal.length == 10 && tglVal !== lastDateValue) {
                lastDateValue = tglVal; 

                $.ajax({ 
                    url: '<?= site_url($this->uri_mod . "/get_no_transaksi_ajax?n=" . _get("n")) ?>', 
                    type: 'POST', 
                    data: { tanggal: tglVal }, 
                    dataType: 'json',
                    success: function(res) { 
                        if(res && res.new_no) {
                            $('#transaksi_no').val(res.new_no);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            }
        }, 100); 
    }

    // --- LOGIKA UTAMA (SAAT PEGAWAI ASAL DIPILIH) ---
    $('#pegawai_asal').on('change', function(){
        var pid = $(this).val(); 
        
        // Logika Reset Tujuan
        var $tujuanSelect = $('#pegawai_tujuan');
        var currentTujuan = $tujuanSelect.val(); 

        $tujuanSelect.find('option').prop('disabled', false);
        if (pid) {
            $tujuanSelect.find('option[value="' + pid + '"]').prop('disabled', true);
            if (currentTujuan == pid) {
                $tujuanSelect.val('').trigger('change'); 
            }
        }
        
        // Refresh Select2
        $tujuanSelect.select2({
            theme: "bootstrap-5",
            dropdownParent: $('#form').closest('.modal'),
            width: '100%'
        });

        // Logika Load Aset
        var $area = $('#list_asset_area');
        $area.html('<div class="text-center p-2"><span class="spinner-border spinner-border-sm"></span> Memuat aset...</div>');
        
        if (!pid) {
            $area.html('<div class="text-center p-2 fst-italic text-muted">Pilih "Dari Pegawai" terlebih dahulu...</div>');
            return;
        }

        $.ajax({
            url: '<?= site_url("formulir/mutasi_asset/get_pegawai_assets?n=" . _get("n")) ?>',
            type: 'POST',
            data: { pegawai_id: pid },
            dataType: 'json',
            success: function(data){
                if(data && data.length > 0){
                    // [LAYOUT TABEL SEPERTI YANG ANDA MINTA]
                    var html = '<table class="table table-sm table-striped mb-0 table-hover">';
                    html += '<thead><tr><th width="40" class="text-center">Pilih</th><th>Kode</th><th>Nama Aset</th><th>Spesifikasi / Detail</th></tr></thead><tbody>';
                    
                    $.each(data, function(i, v){
                        // Logic detail aset
                        var detailInfo = [];
                        if (v.merk) detailInfo.push(v.merk);
                        if (v.merek_tipe) detailInfo.push(v.merek_tipe);
                        if (v.spesifikasi) detailInfo.push(v.spesifikasi);
                        if (v.nopol) detailInfo.push(v.nopol);
                        var detailStr = detailInfo.length > 0 ? detailInfo.join(', ') : '-';

                        html += `<tr>
                                    <td class="text-center align-middle">
                                        <div class="form-check d-flex justify-content-center m-0">
                                            <input type="checkbox" name="asset_id[]" value="${v.asset_id}" class="form-check-input cursor-pointer" id="chk_${v.asset_id}">
                                            <input type="hidden" name="pemakaian_id[]" value="${v.pemakaian_id}" disabled id="hdn_${v.asset_id}">
                                        </div>
                                    </td>
                                    <td class="align-middle"><label class="cursor-pointer m-0 w-100" for="chk_${v.asset_id}">${v.asset_kd}</label></td>
                                    <td class="align-middle fw-bold"><label class="cursor-pointer m-0 w-100" for="chk_${v.asset_id}">${v.asset_nm}</label></td>
                                    <td class="align-middle"><label class="cursor-pointer m-0 w-100 text-muted small" for="chk_${v.asset_id}">${detailStr}</label></td>
                                </tr>`;
                    });
                    html += '</tbody></table>';
                    $area.html(html);
                    
                    $('input[name="asset_id[]"]').change(function(){
                        var aid = $(this).val();
                        var isChecked = $(this).is(':checked');
                        $('#hdn_' + aid).prop('disabled', !isChecked);
                    });

                } else {
                    $area.html('<div class="alert alert-warning small m-0 text-center">Pegawai ini tidak sedang memegang aset apapun.</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                $area.html('<div class="text-danger small text-center p-2">Gagal memuat data. Cek Console.</div>');
            }
        });
    });
>>>>>>> repoB/main
</script>