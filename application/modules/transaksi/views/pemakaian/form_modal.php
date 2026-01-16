<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="card-body">
        
        <h4 class="mb-3 text-primary">Data Peminjaman</h4>

        <?php $attr_disabled = ($is_readonly) ? 'disabled' : ''; ?>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Peminjam</label>
            <div class="col-lg-9 col-md-8">
                <select name="pegawai_id" class="form-select select2-modal" required <?= $attr_disabled ?>>
                    <option value="">-- Pilih Pegawai --</option>
                    <?php foreach ($list_pegawai as $pgw): ?>
                        <option value="<?= $pgw['pegawai_id'] ?>" <?= (@$main['pegawai_id'] == $pgw['pegawai_id']) ? 'selected' : '' ?>>
                            <?= $pgw['pegawai_nm'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">No. Peminjaman</label>
            <div class="col-lg-9 col-md-8">
                <input type="text" name="transaksi_no" id="transaksi_no" class="form-control bg-light" 
                       value="<?= @$main['transaksi_no'] ?? @$preview_no ?>" readonly>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Tanggal Pinjam</label>
            <div class="col-lg-9 col-md-8">
                <?php $val_tgl = @$main['transaksi_tgl'] ? date('d-m-Y', strtotime($main['transaksi_tgl'])) : date('d-m-Y'); ?>
                <input type="text" name="transaksi_tgl" id="transaksi_tgl" 
                       class="form-control datepicker-notauto" 
                       value="<?= $val_tgl ?>" required placeholder="dd-mm-yyyy" <?= $attr_disabled ?>>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">Rencana Kembali</label>
            <div class="col-lg-9 col-md-8">
                <?php $val_back = @$main['kembali_rencana_tgl'] ? date('d-m-Y', strtotime($main['kembali_rencana_tgl'])) : ''; ?>
                <input type="text" name="kembali_rencana_tgl" class="form-control datepicker-notauto" 
                       value="<?= $val_back ?>" placeholder="dd-mm-yyyy (Opsional)" <?= $attr_disabled ?>>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">Keperluan</label>
            <div class="col-lg-9 col-md-8">
                <input type="text" name="transaksi_ket" class="form-control" 
                       value="<?= @$main['transaksi_ket'] ?>" placeholder="Contoh: Dinas Luar Kota" <?= $attr_disabled ?>>
            </div>
        </div>

        <div class="border-dotted my-3"></div>
        <h4 class="mb-3 text-warning">Rincian Barang</h4>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Asal Gudang</label>
            <div class="col-lg-9 col-md-8">
                <select name="gudang_id" id="gudang_id" class="form-select" required <?= $attr_disabled ?>>
                    <option value="">-- Pilih Gudang --</option>
                    <?php foreach ($list_gudang as $gdg): ?>
                        <option value="<?= $gdg['gudang_id'] ?>" <?= (@$main['gudang_id'] == $gdg['gudang_id']) ? 'selected' : '' ?>>
                            <?= $gdg['gudang_nm'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Nama Asset</label>
            <div class="col-lg-9 col-md-8">
                <select name="asset_id" id="asset_id" class="form-select select2-modal" required disabled>
                    <option value="">- Pilih Gudang Dulu -</option>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Jumlah</label>
            <div class="col-lg-9 col-md-8">
                <input type="number" name="pemakaian_qty" id="pemakaian_qty" 
                       class="form-control" min="1" step="any" 
                       value="<?= @$main['pemakaian_qty'] + 0 ?>" required <?= $attr_disabled ?>>
            </div>
        </div>

        <div class="border-dotted mt-3"></div>

        <div class="row mt-2">
            <div class="col-9 offset-3">
                <?php if(!$is_readonly): ?>
                    <button type="submit" class="btn btn-primary" onclick="_save(event)">
                        <?= _icon('check') ?> Simpan
                    </button>
                <?php else: ?>
                    <button type="button" class="btn btn-secondary" disabled>
                        <i class="fas fa-lock me-1"></i> Mode Lihat Saja
                    </button>
                <?php endif; ?>
                
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                    <?= _icon('cancel') ?> Tutup
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    var select2Options = {
        theme: "bootstrap-5",
        dropdownParent: $('#form').closest('.modal'),
        width: '100%'
    };

    $(document).ready(function() {
        $('.select2-modal').select2(select2Options);
        
        // Hanya jalankan auto number jika mode input baru (Bukan ReadOnly)
        <?php if(!$is_readonly): ?>
            startDateWatcher();
        <?php endif; ?>

        // [AUTO LOAD] Jika mode Detail (Gudang sudah terpilih), load aset
        var savedGudang = '<?= @$main['gudang_id'] ?>';
        var savedAsset  = '<?= @$main['asset_id'] ?>';
        
        // Kirim status isReadOnly ke fungsi JS
        var isReadOnly  = <?= $is_readonly ? 'true' : 'false' ?>;

        if(savedGudang) {
            loadAssets(savedGudang, savedAsset, isReadOnly);
        }
    });

    var lastDateValue = ''; 
    function startDateWatcher() {
        setInterval(function() {
            var tglInput = $('#transaksi_tgl');
            var tglVal = tglInput.val(); 
            if (tglVal && tglVal.length == 10 && tglVal !== lastDateValue) {
                lastDateValue = tglVal; 
                $.ajax({ 
                    url: '<?= $this->uri . "/get_no_transaksi_ajax?n=" . _get("n") ?>', 
                    type: 'POST', data: { tanggal: tglVal }, dataType: 'json',
                    success: function(res) { if(res.new_no) $('#transaksi_no').val(res.new_no); }
                });
            }
        }, 500); 
    }

    $('#gudang_id').change(function() {
        // Saat gudang diganti manual, pasti mode Edit/Input (isLocked = false)
        loadAssets($(this).val(), null, false);
    });

    // Fungsi Load Asset dengan Parameter Lock
    function loadAssets(gid, selectedId, isLocked) {
        var $assetSelect = $('#asset_id');
        var $qtyInput = $('#pemakaian_qty');

        if (!gid) {
            $assetSelect.html('<option value="">- Pilih Gudang Dulu -</option>').prop('disabled', true);
            return;
        }

        // Jangan reset text loading jika selectedId ada (agar mulus saat view detail)
        if(!selectedId) $assetSelect.html('<option>Loading...</option>');
        
        $.ajax({
            url: '<?= $this->uri . "/get_assets_by_gudang?n=" . _get("n") ?>', 
            type: 'POST', data: { gudang_id: gid }, dataType: 'json',
            success: function(data) {
                var ops = '<option value="">- Pilih Asset Tersedia -</option>';
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        var stok = parseFloat(item.stok_qty);
                        var isSel = (selectedId == item.asset_id) ? 'selected' : '';
                        
                        var detailInfo = [];
                        if (item.merk) detailInfo.push(item.merk);
                        if (item.nopol) detailInfo.push(item.nopol);
                        var detailStr = detailInfo.length > 0 ? ' (' + detailInfo.join(', ') + ')' : '';

                        ops += `<option value="${item.asset_id}" data-stok="${stok}" ${isSel}>
                                ${item.asset_nm}${detailStr} - Sisa: ${stok}
                                </option>`;
                    });
                } else {
                    ops = '<option value="">(Gudang Kosong)</option>';
                }
                
                $assetSelect.html(ops);
                
                // [LOGIC KUNCI]
                // Jika isLocked (Mode Detail), set disabled=true setelah load selesai
                if (isLocked) {
                    $assetSelect.prop('disabled', true);
                    $qtyInput.prop('disabled', true);
                } else {
                    $assetSelect.prop('disabled', false);
                    $qtyInput.prop('disabled', false);
                }
            }
        });
    }

    // Validasi Stok (Hanya aktif jika tidak locked)
    <?php if(!$is_readonly): ?>
    $('#pemakaian_qty, #asset_id').on('change keyup', function() {
        var stok = parseFloat($('#asset_id :selected').data('stok')) || 0;
        var qty = parseFloat($('#pemakaian_qty').val()) || 0;
        
        if (qty > stok && stok > 0) {
            alert('Stok tidak cukup! Maksimal: ' + stok);
            $('#pemakaian_qty').val(stok);
        }
    });
    <?php endif; ?>
</script>