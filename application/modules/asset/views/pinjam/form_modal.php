<style>
    .table-input th { background-color: #fff8e1; font-weight: 600; font-size: 0.875rem; }
    .table-input td { padding: 5px !important; vertical-align: middle; }
    .btn-del-row { color: #d63939; cursor: pointer; font-size: 1.1rem; }
</style>

<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body p-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label required">Peminjam</label>
                <select name="pegawai_id" class="form-select" required>
                    <option value="">-- Pilih Pegawai --</option>
                    <?php foreach ($list_pegawai as $pgw): ?>
                        <option value="<?= $pgw['pegawai_id'] ?>"><?= $pgw['pegawai_nm'] ?> (<?= $pgw['user_id'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label required">No. Peminjaman</label>
                <input type="text" name="transaksi_no" id="transaksi_no" class="form-control bg-light"
                       value="<?= @$main['transaksi_no'] ?? @$preview_no ?>" readonly required>
                <small class="text-muted">(Otomatis)</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label required">Tanggal Pinjam</label>
                <input type="date" name="transaksi_tgl" id="transaksi_tgl" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label required">Rencana Kembali</label>
                <input type="date" name="kembali_rencana_tgl" class="form-control" required>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Keperluan</label>
            <input type="text" name="transaksi_ket" class="form-control" placeholder="Contoh: Dinas Luar Kota">
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="m-0 fw-bold text-warning">Barang Dipinjam</h4>
            <button type="button" class="btn btn-sm btn-warning text-dark" onclick="addRow()">
                <i class="fas fa-plus me-1"></i> Tambah Baris
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-input">
                <thead>
                    <tr>
                        <th width="35%">Asal Gudang</th>
                        <th width="40%">Nama Asset (Sesuai Gudang)</th>
                        <th width="20%" class="text-center">Jml Pinjam</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody id="tbody-detail">
                    <tr class="tr-row">
                        <td>
                            <select name="gudang_id[]" class="form-select form-select-sm select-gudang" required>
                                <option value="">- Pilih Gudang -</option>
                                <?php foreach ($list_gudang as $gdg): ?>
                                    <option value="<?= $gdg['gudang_id'] ?>"><?= $gdg['gudang_nm'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="asset_id[]" class="form-select form-select-sm select-asset" required disabled>
                                <option value="">- Pilih Gudang Dulu -</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="pinjam_qty[]" class="form-control form-control-sm text-center qty-input" min="0.0001" step="any" value="1" required disabled>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-times-circle btn-del-row" onclick="delRow(this)"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-footer justify-content-between bg-light py-2">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
        </button>
        <button type="submit" class="btn btn-warning px-4 text-dark" onclick="_save(event)">
            <i class="fas fa-hand-holding me-1"></i> Simpan Peminjaman
        </button>
    </div>
</form>

<script>
    // 1. Fungsi Tambah Baris (Clone)
    function addRow() {
        // Clone baris pertama
        var $klon = $('#tbody-detail .tr-row:first').clone();
        // Reset nilai-nilainya
        $klon.find('.select-gudang').val('');
        $klon.find('.select-asset').html('<option value="">- Pilih Gudang Dulu -</option>').prop('disabled', true);
        $klon.find('.qty-input').val('1').prop('disabled', true);
        // Tempel ke tabel
        $('#tbody-detail').append($klon);
    }
    function delRow(el) {
        if ($('#tbody-detail .tr-row').length > 1) $(el).closest('tr').remove();
    }

    // 2. Fungsi Canggih: Load Asset saat Gudang di baris tersebut berubah
    $(document).on('change', '.select-gudang', function() {
        var $row = $(this).closest('tr'); // Temukan baris tempat dropdown ini berada
        var gid = $(this).val();
        var $assetSelect = $row.find('.select-asset');
        var $qtyInput = $row.find('.qty-input');

        if (!gid) {
            $assetSelect.html('<option value="">- Pilih Gudang Dulu -</option>').prop('disabled', true);
            $qtyInput.prop('disabled', true);
            return;
        }

        // Tampilkan loading di dropdown asset baris ini saja
        $assetSelect.html('<option>Loading stok...</option>').prop('disabled', true);

        $.ajax({
            url: '<?= $this->uri . "/get_assets_by_gudang?n=" . _get("n") ?>',
            type: 'POST',
            data: { gudang_id: gid },
            dataType: 'json',
            success: function(data) {
                var ops = '<option value="">- Pilih Asset Tersedia -</option>';
                if (data.length === 0) {
                    ops = '<option value="">(Gudang Kosong)</option>';
                } else {
                    $.each(data, function(i, item) {
                        var stok = parseFloat(item.stok_qty);
                        ops += `<option value="${item.asset_id}" data-stok="${stok}">
                                ${item.asset_nm} (${item.asset_kd}) - Sisa: ${stok} ${item.satuan_nm || ''}
                                </option>`;
                    });
                }
                $assetSelect.html(ops).prop('disabled', false);
                $qtyInput.prop('disabled', false);
            }
        });
    });

    // 3. Validasi Stok Per Baris
    $(document).on('change keyup', '.qty-input, .select-asset', function() {
        var $row = $(this).closest('tr');
        var stok = parseFloat($row.find('.select-asset :selected').data('stok')) || 0;
        var qty = parseFloat($row.find('.qty-input').val()) || 0;
        
        if (qty > stok && stok > 0) {
            alert('Stok tidak cukup! Maksimal: ' + stok);
            $row.find('.qty-input').val(stok);
        }
    });

    // 4. Auto Number
    $(document).on('change', '#transaksi_tgl', function() {
        var tgl = $(this).val(); $('#transaksi_no').val('Loading...');
        $.ajax({ url: '<?= $this->uri . "/get_no_transaksi_ajax?n=" . _get("n") ?>', type: 'POST', data: { tanggal: tgl }, dataType: 'json',
            success: function(res) { if(res.new_no) $('#transaksi_no').val(res.new_no); } });
    });
</script>