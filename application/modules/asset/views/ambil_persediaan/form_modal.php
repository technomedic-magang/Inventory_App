<style>
    .table-input th { background-color: #e6f7ff; font-weight: 600; font-size: 0.875rem; }
    .table-input td { padding: 5px !important; vertical-align: middle; }
    .btn-del-row { color: #dc3545; cursor: pointer; font-size: 1.1rem; }
</style>

<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body p-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Gudang Sumber</label>
                <select name="gudang_id" id="gudang_id" class="form-select" required onchange="loadAssets()">
                    <option value="">-- Pilih Gudang --</option>
                    <?php foreach ($list_gudang as $gdg): ?>
                        <option value="<?= $gdg['gudang_id'] ?>"><?= $gdg['gudang_nm'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
             <div class="col-md-6 mb-3">
                <label class="form-label required">Diambil Oleh (Pegawai)</label>
                <select name="pegawai_id" class="form-select" required>
                    <option value="">-- Pilih Pegawai --</option>
                    <?php foreach ($list_pegawai as $pgw): ?>
                        <option value="<?= $pgw['pegawai_id'] ?>"><?= $pgw['pegawai_nm'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label required">No. Transaksi</label>
                <input type="text" name="transaksi_no" id="transaksi_no" class="form-control bg-light"
                       value="<?= @$main['transaksi_no'] ?? @$preview_no ?>" readonly required>
                <small class="text-muted">(Otomatis)</small>
            </div>
             <div class="col-md-6 mb-3">
                <label class="form-label required">Tanggal Pengambilan</label>
                <input type="date" name="transaksi_tgl" id="transaksi_tgl" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Keperluan</label>
            <input type="text" name="transaksi_ket" class="form-control" placeholder="Cth: Kebutuhan ATK Bulanan">
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="m-0 fw-bold text-info">Persediaan Diambil</h4>
            <button type="button" id="btn-add-row" class="btn btn-sm btn-info" onclick="addRow()" disabled>
                <i class="fas fa-plus me-1"></i> Tambah Baris
            </button>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-input">
                <thead>
                    <tr>
                        <th width="45%">Nama Persediaan (Stok Tersedia)</th>
                        <th width="20%" class="text-center">Jml Ambil</th>
                        <th>Catatan</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody id="tbody-detail">
                    <tr><td colspan="4" class="text-center text-muted p-3">Silakan pilih Gudang Sumber terlebih dahulu.</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-footer justify-content-between bg-light py-2">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
        </button>
        <button type="submit" class="btn btn-info px-4" onclick="_save(event)">
            <i class="fas fa-check me-1"></i> Simpan
        </button>
    </div>
</form>

<script>
    var currentAssetOptions = '<option value="">- Pilih Persediaan -</option>';

    // [Perubahan 3] Load Persediaan (HANYA ATK, dll)
    function loadAssets() {
        var gid = $('#gudang_id').val();
        if (!gid) {
            $('#tbody-detail').html('<tr><td colspan="4" class="text-center text-muted p-3">Pilih Gudang Sumber.</td></tr>');
            $('#btn-add-row').prop('disabled', true);
            return;
        }
        $('#tbody-detail').html('<tr><td colspan="4" class="text-center p-3"><span class="spinner-border spinner-border-sm"></span> Memuat...</td></tr>');

        $.ajax({
            url: '<?= $this->uri . "/get_persediaan_by_gudang?n=" . _get("n") ?>', // Panggil API baru
            type: 'POST', data: { gudang_id: gid }, dataType: 'json',
            success: function(data) {
                if (data.length === 0) {
                     $('#tbody-detail').html('<tr><td colspan="4" class="text-center text-danger p-3">Gudang ini tidak memiliki Persediaan (ATK, dll)</td></tr>');
                     $('#btn-add-row').prop('disabled', true);
                } else {
                    currentAssetOptions = '<option value="">- Pilih Persediaan -</option>';
                    $.each(data, function(i, item) {
                        var stok = parseFloat(item.stok_qty); 
                        currentAssetOptions += `<option value="${item.asset_id}" data-stok="${stok}">
                                                ${item.asset_nm} (${item.asset_kd}) - Sisa: ${stok} ${item.satuan_nm || ''}
                                              </option>`;
                    });
                    $('#tbody-detail').empty();
                    addRow(); 
                    $('#btn-add-row').prop('disabled', false);
                }
            }
        });
    }

    // Tambah Baris
    function addRow() {
        var html = `
            <tr class="tr-row">
                <td>
                    <select name="asset_id[]" class="form-select form-select-sm asset-select" required onchange="cekStok(this)">
                        ${currentAssetOptions}
                    </select>
                </td>
                <td>
                    <input type="number" name="asset_qty[]" class="form-control form-control-sm text-center qty-input" min="0.0001" step="any" value="1" required onchange="cekStok(this)">
                </td>
                <td><input type="text" name="detail_ket[]" class="form-control form-control-sm" placeholder="Opsional"></td>
                <td class="text-center"><i class="fas fa-times-circle btn-del-row" onclick="delRow(this)"></i></td>
            </tr>
        `;
        $('#tbody-detail').append(html);
    }
    function delRow(el) { if ($('#tbody-detail .tr-row').length > 1) $(el).closest('tr').remove(); }

    // Validasi Stok
    function cekStok(el) {
        var row = $(el).closest('tr');
        var stok = parseFloat(row.find('.asset-select :selected').data('stok')) || 0;
        var qty = parseFloat(row.find('.qty-input').val()) || 0;
        if (qty > stok && stok > 0) {
            alert('Stok tidak cukup! Maksimal: ' + stok);
            row.find('.qty-input').val(stok);
        }
    }

    // Auto Number
    $(document).on('change', '#transaksi_tgl', function() {
        var tgl = $(this).val(); $('#transaksi_no').val('Loading...');
        $.ajax({
            url: '<?= $this->uri . "/get_no_transaksi_ajax?n=" . _get("n") ?>', type: 'POST', data: { tanggal: tgl }, dataType: 'json',
            success: function(res) { if(res.new_no) $('#transaksi_no').val(res.new_no); }
        });
    });
</script>