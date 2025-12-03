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
</script>