<style>
    /* Merapikan tabel input dinamis */
    .table-input th { background-color: #f0f2f5; font-weight: 600; font-size: 0.875rem; }
    .table-input td { padding: 5px !important; vertical-align: middle; }
    .form-control-sm, .form-select-sm { font-size: 0.875rem; }
    .btn-del-row { color: #dc3545; cursor: pointer; font-size: 1.1rem; }
    .btn-del-row:hover { color: #a00; }
</style>

<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body p-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Gudang Tujuan</label>
                <select name="gudang_id" class="form-select" required>
                    <option value="">-- Pilih Gudang --</option>
                    <?php foreach ($list_gudang as $gdg): ?>
                        <option value="<?= $gdg['gudang_id'] ?>"><?= $gdg['gudang_nm'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label required">No. Transaksi</label>
                <input type="text" name="transaksi_no" class="form-control bg-light"
                    value="<?= @$main['transaksi_no'] ?? @$preview_no ?>"
                    readonly>
                <small class="text-muted">Nomor otomatis sistem</small>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Tanggal Masuk</label>
                <input type="date" name="transaksi_tgl" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Catatan Transaksi</label>
                <input type="text" name="transaksi_ket" class="form-control" placeholder="Contoh: Pengadaan Q3">
            </div>
        </div>

        <hr class="my-4"> <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="m-0 fw-bold">Rincian Barang</h4>
            <button type="button" class="btn btn-sm btn-primary" onclick="addRow()">
                <i class="fas fa-plus me-1"></i> Tambah Baris
            </button>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-input">
                <thead>
                    <tr>
                        <th width="40%">Nama Asset</th>
                        <th width="20%" class="text-center">Jumlah</th>
                        <th>Keterangan Detail</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody id="tbody-detail">
                    <tr class="tr-row">
                        <td>
                            <select name="asset_id[]" class="form-select form-select-sm" required>
                                <option value="">- Pilih Asset -</option>
                                <?php foreach ($list_asset as $ast): ?>
                                    <option value="<?= $ast['asset_id'] ?>">
                                        <?= $ast['asset_nm'] ?> (<?= $ast['asset_kd'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="asset_qty[]" class="form-control form-control-sm text-center" min="0.0001" step="any" value="1" required>
                        </td>
                        <td>
                            <input type="text" name="detail_ket[]" class="form-control form-control-sm" placeholder="Opsional">
                        </td>
                        <td class="text-center">
                            <i class="fas fa-times-circle btn-del-row" onclick="delRow(this)" title="Hapus"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-footer justify-content-between bg-light py-2">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
            <?= _icon('cancel') ?> Batal
        </button>
        <button type="submit" class="btn btn-primary px-4" onclick="_save(event)">
            <i class="fas fa-check me-1"></i> Simpan Transaksi
        </button>
    </div>
</form>

<script>
    function addRow() {
        var $klon = $('#tbody-detail .tr-row:first').clone();
        $klon.find('input').val('');
        $klon.find('input[type="number"]').val('1');
        $klon.find('select').val('');
        $('#tbody-detail').append($klon);
    }
    function delRow(el) {
        if ($('#tbody-detail .tr-row').length > 1) $(el).closest('tr').remove();
    }
</script>

<script>
    // Saat input tanggal berubah...
    $('[name="transaksi_tgl"]').on('change', function() {
        var tgl_baru = $(this).val();

        // Panggil API Controller via AJAX
        $.ajax({
            url: '<?= $this->uri . "/get_no_transaksi_ajax?n=" . _get("n") ?>',
            type: 'POST',
            data: { tanggal: tgl_baru },
            dataType: 'json',
            success: function(response) {
                // Update kolom No. Transaksi dengan nomor baru
                $('[name="transaksi_no"]').val(response.new_no);
            }
        });
    });
</script>