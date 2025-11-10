<style>
    .table-input th { background-color: #fff5f5; font-weight: 600; font-size: 0.875rem; }
    .table-input td { padding: 5px !important; vertical-align: middle; }
    .btn-del-row { color: #dc3545; cursor: pointer; font-size: 1.1rem; }
</style>

<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body p-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Gudang Sumber</label>
                <select name="gudang_id" id="gudang_id" class="form-select" required onchange="loadAssets()">
                    <option value="">-- Pilih Gudang Asal --</option>
                    <?php foreach ($list_gudang as $gdg): ?>
                        <option value="<?= $gdg['gudang_id'] ?>"><?= $gdg['gudang_nm'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label required">Jenis Keluar</label>
                <select name="keluar_jns" class="form-select" required>
                    <option value="">-- Pilih Alasan --</option>
                    <option value="RUSAK">Rusak / Defect</option>
                    <option value="HILANG">Hilang (Lost)</option>
                    <option value="MUSNAH">Pemusnahan</option>
                    <option value="TERPAKAI">Terpakai Habis</option>
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
                <label class="form-label required">Tanggal Keluar</label>
                <input type="date" name="transaksi_tgl" id="transaksi_tgl" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Keterangan</label>
            <input type="text" name="transaksi_ket" class="form-control" placeholder="Kronologi kejadian...">
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="m-0 fw-bold text-danger">Barang Keluar</h4>
            <button type="button" id="btn-add-row" class="btn btn-sm btn-danger" onclick="addRow()" disabled>
                <i class="fas fa-plus me-1"></i> Tambah Baris
            </button>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-input">
                <thead>
                    <tr>
                        <th width="45%">Nama Asset (Stok Tersedia)</th>
                        <th width="20%" class="text-center">Jml Keluar</th>
                        <th>Keterangan Detail</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody id="tbody-detail">
                    <tr><td colspan="4" class="text-center text-muted fst-italic p-3">Silakan pilih Gudang Sumber terlebih dahulu.</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-footer justify-content-between bg-light py-2">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
        </button>
        <button type="submit" class="btn btn-danger px-4" onclick="_save(event)">
            <i class="fas fa-exclamation-triangle me-1"></i> Proses Keluar
        </button>
    </div>
</form>

<script>
    // Variabel global untuk menyimpan opsi asset yang aktif saat ini
    var currentAssetOptions = '<option value="">- Pilih Asset -</option>';

    // Fungsi 1: Load Asset saat Gudang berubah
    function loadAssets() {
        var gid = $('#gudang_id').val();
        if (!gid) {
            $('#tbody-detail').html('<tr><td colspan="4" class="text-center text-muted p-3">Silakan pilih Gudang Sumber terlebih dahulu.</td></tr>');
            $('#btn-add-row').prop('disabled', true);
            return;
        }

        // Tampilkan loading
        $('#tbody-detail').html('<tr><td colspan="4" class="text-center p-3"><span class="spinner-border spinner-border-sm text-danger"></span> Memuat data stok...</td></tr>');

        $.ajax({
            url: '<?= $this->uri . "/get_assets_by_gudang?n=" . _get("n") ?>',
            type: 'POST',
            data: { gudang_id: gid },
            dataType: 'json',
            success: function(data) {
                if (data.length === 0) {
                     $('#tbody-detail').html('<tr><td colspan="4" class="text-center text-danger p-3"><i class="fas fa-exclamation-circle"></i> Gudang ini kosong! Tidak ada barang yang bisa dikeluarkan.</td></tr>');
                     $('#btn-add-row').prop('disabled', true);
                } else {
                    // Buat ulang opsi dropdown berdasarkan data terbaru
                    currentAssetOptions = '<option value="">- Pilih Asset -</option>';
                    $.each(data, function(i, item) {
                        // Format angka desimal ke integer jika .0000
                        var stok = parseFloat(item.stok_qty); 
                        currentAssetOptions += `<option value="${item.asset_id}" data-stok="${stok}">
                                                ${item.asset_nm} (${item.asset_kd}) - Sisa: ${stok} ${item.satuan_nm || ''}
                                              </option>`;
                    });
                    
                    // Reset tabel dan tambah 1 baris kosong pertama
                    $('#tbody-detail').empty();
                    addRow(); 
                    $('#btn-add-row').prop('disabled', false);
                }
            },
            error: function() {
                 $('#tbody-detail').html('<tr><td colspan="4" class="text-center text-danger p-3">Gagal memuat data.</td></tr>');
            }
        });
    }

    // Fungsi 2: Tambah Baris Baru (menggunakan currentAssetOptions)
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
                <td>
                    <input type="text" name="detail_ket[]" class="form-control form-control-sm" placeholder="Opsional">
                </td>
                <td class="text-center">
                    <i class="fas fa-times-circle btn-del-row" onclick="delRow(this)"></i>
                </td>
            </tr>
        `;
        $('#tbody-detail').append(html);
    }

    // Fungsi 3: Hapus Baris
    function delRow(el) {
        if ($('#tbody-detail .tr-row').length > 1) $(el).closest('tr').remove();
        else alert("Minimal harus ada satu baris!");
    }

    // Fungsi 4: Validasi Stok di Client Side (Agar user tidak input melebihi stok)
    function cekStok(el) {
        var row = $(el).closest('tr');
        var select = row.find('.asset-select');
        var inputQty = row.find('.qty-input');
        
        var stokTersedia = parseFloat(select.find(':selected').data('stok')) || 0;
        var qtyDiminta = parseFloat(inputQty.val()) || 0;

        if (qtyDiminta > stokTersedia && stokTersedia > 0) {
            alert('Stok tidak cukup! Hanya tersedia ' + stokTersedia);
            inputQty.val(stokTersedia); // Reset ke maksimal stok
        }
    }

    // Auto Number Script (Jaga-jaga kalau tanggal diganti)
    $(document).on('change', '#transaksi_tgl', function() {
        var tgl = $(this).val();
        $('#transaksi_no').val('Loading...');
        $.ajax({
            url: '<?= $this->uri . "/get_no_transaksi_ajax?n=" . _get("n") ?>', type: 'POST', data: { tanggal: tgl }, dataType: 'json',
            success: function(res) { if(res.new_no) $('#transaksi_no').val(res.new_no); }
        });
    });
</script>