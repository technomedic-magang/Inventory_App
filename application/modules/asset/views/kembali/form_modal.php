<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body p-4">
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label required fw-bold text-success">Pilih Transaksi Peminjaman (OPEN)</label>
                <select name="pinjam_id" id="pinjam_id" class="form-select form-select-lg" required onchange="loadItems()">
                    <option value="">-- Cari Nomor Peminjaman --</option>
                    <?php foreach ($list_pinjam as $pjm): ?>
                        <option value="<?= $pjm['pinjam_id'] ?>">
                            <?= $pjm['transaksi_no'] ?> a.n. <?= $pjm['pegawai_nm'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
             <div class="col-md-6">
                <label class="form-label required">No. Pengembalian</label>
                <input type="text" name="transaksi_no" id="transaksi_no" class="form-control bg-light"
                       value="<?= @$main['transaksi_no'] ?? @$preview_no ?>"
                       readonly required>
                <small class="text-muted">(Otomatis)</small>
            </div>
            <div class="col-md-6">
                <label class="form-label required">Tanggal Kembali</label>
                <input type="date" name="transaksi_tgl" id="transaksi_tgl" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Catatan Pengembalian</label>
            <input type="text" name="transaksi_ket" class="form-control" placeholder="Keterangan...">
        </div>

        <h5 class="mb-2 fw-bold">Daftar Barang yang Harus Kembali</h5>
        <div class="table-responsive border rounded">
            <table class="table table-sm table-striped m-0">
                <thead class="table-success">
                    <tr>
                        <th width="35%">Nama Barang</th>
                        <th width="20%">Gudang Asal</th>
                        <th width="15%" class="text-center">Sisa Pinjam</th>
                        <th width="15%">Jml Kembali</th>
                        <th width="15%">Kondisi</th>
                    </tr>
                </thead>
                <tbody id="tbody-items">
                    <tr><td colspan="5" class="text-center text-muted py-4">Silakan pilih No. Peminjaman di atas terlebih dahulu.</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-footer justify-content-between bg-light py-2">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
        </button>
        <button type="submit" class="btn btn-success px-4" onclick="_save(event)">
            <i class="fas fa-check-double me-1"></i> Proses Kembali
        </button>
    </div>
</form>

<script>
function loadItems() {
    var pid = $('#pinjam_id').val();
    if (!pid) { $('#tbody-items').html('<tr><td colspan="5" class="text-center text-muted py-4">Pilih No. Peminjaman dulu.</td></tr>'); return; }
    $('#tbody-items').html('<tr><td colspan="5" class="text-center py-4"><span class="spinner-border spinner-border-sm"></span> Loading...</td></tr>');
    $.ajax({
        url: '<?= $this->uri . "/get_items_pinjam?n=" . _get("n") ?>', type: 'POST', data: { pinjam_id: pid }, dataType: 'json',
        success: function(data) {
            var html = '';
            if(data.length === 0) html = '<tr><td colspan="5" class="text-center text-danger py-4">Semua barang sudah dikembalikan!</td></tr>';
            else {
                $.each(data, function(i, item) {
                    var sisa = parseFloat(item.sisa_qty);
                    html += `<tr>
                        <td class="p-2">
                            <input type="hidden" name="pinjam_detail_id[]" value="${item.pinjam_detail_id}">
                            <input type="hidden" name="asset_id[]" value="${item.asset_id}">
                            <strong>${item.asset_nm}</strong> <br> <small class="text-muted">${item.asset_kd}</small>
                        </td>
                        <td class="p-2 align-middle">
                            <input type="hidden" name="gudang_id[]" value="${item.gudang_id}">
                            ${item.gudang_nm}
                        </td>
                        <td class="text-center align-middle"><span class="badge bg-warning-lt">${sisa} ${item.satuan_nm || ''}</span></td>
                        <td class="p-2"><input type="number" name="kembali_qty[]" class="form-control form-control-sm text-center" min="0" max="${sisa}" step="any" value="${sisa}" required></td>
                        <td class="p-2">
                            <select name="kondisi_asset[]" class="form-select form-select-sm">
                                <option value="BAIK" selected>Baik</option>
                                <option value="RUSAK">Rusak</option>
                                <option value="HILANG">Hilang</option>
                            </select>
                        </td>
                    </tr>`;
                });
            }
            $('#tbody-items').html(html);
        }
    });
}

// Auto Number Script
$(document).on('change', '#transaksi_tgl', function() {
    var tgl = $(this).val();
    $('#transaksi_no').val('Loading...');
    $.ajax({
        url: '<?= $this->uri . "/get_no_transaksi_ajax?n=" . _get("n") ?>', type: 'POST', data: { tanggal: tgl }, dataType: 'json',
        success: function(res) { if(res.new_no) $('#transaksi_no').val(res.new_no); }
    });
});
</script>