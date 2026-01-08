<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
<<<<<<< HEAD
  <div class="card-body">
    
    <h4 class="mb-3 text-primary">Data Peminjaman</h4>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Peminjam</label>
      <div class="col-lg-8 col-md-6">
        <select name="pegawai_id" class="form-select" required>
            <option value="">-- Pilih Pegawai --</option>
            <?php foreach ($list_pegawai as $pgw): ?>
                <option value="<?= $pgw['pegawai_id'] ?>">
                    <?= $pgw['pegawai_nm'] ?> (<?= $pgw['user_id'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">No. Peminjaman</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="transaksi_no" id="transaksi_no" class="form-control bg-light" 
               value="<?= @$main['transaksi_no'] ?? @$preview_no ?>" readonly>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Tanggal Pinjam</label>
      <div class="col-lg-8 col-md-6">
        <input type="date" name="transaksi_tgl" id="transaksi_tgl" class="form-control" value="<?= date('Y-m-d') ?>" required>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Rencana Kembali</label>
      <div class="col-lg-8 col-md-6">
        <input type="date" name="kembali_rencana_tgl" class="form-control" required>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label">Keperluan</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="transaksi_ket" class="form-control" placeholder="Contoh: Dinas Luar Kota">
      </div>
    </div>

    <div class="border-dotted my-3"></div>
    
    <h4 class="mb-3 text-warning">Rincian Barang</h4>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Asal Gudang</label>
      <div class="col-lg-8 col-md-6">
        <select name="gudang_id" id="gudang_id" class="form-select" required>
            <option value="">-- Pilih Gudang --</option>
            <?php foreach ($list_gudang as $gdg): ?>
                <option value="<?= $gdg['gudang_id'] ?>"><?= $gdg['gudang_nm'] ?></option>
            <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Nama Asset</label>
      <div class="col-lg-8 col-md-6">
        <select name="asset_id" id="asset_id" class="form-select" required disabled>
            <option value="">- Pilih Gudang Dulu -</option>
        </select>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Jumlah</label>
      <div class="col-lg-8 col-md-6">
        <input type="number" name="pemakaian_qty" id="pemakaian_qty" class="form-control" min="1" step="any" value="1" required disabled>
      </div>
    </div>

    <div class="border-dotted mt-3"></div>

    <div class="row mt-2">
      <div class="col-9 offset-3">
        <button type="submit" class="btn btn-warning text-dark" onclick="_save(event)">
            <?= _icon('check') ?> Simpan
        </button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
            <?= _icon('cancel') ?> Batal
        </button>
      </div>
    </div>
  </div>
</form>

<script>
=======
    <div class="card-body">
        
        <h4 class="mb-3 text-primary">Data Peminjaman</h4>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Peminjam</label>
            <div class="col-lg-8 col-md-6">
                <select name="pegawai_id" class="form-select" required>
                    <option value="">-- Pilih Pegawai --</option>
                    <?php foreach ($list_pegawai as $pgw): ?>
                        <option value="<?= $pgw['pegawai_id'] ?>">
                            <?= $pgw['pegawai_nm'] ?> (<?= $pgw['user_id'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">No. Peminjaman</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="transaksi_no" id="transaksi_no" class="form-control bg-light" 
                       value="<?= @$main['transaksi_no'] ?? @$preview_no ?>" readonly>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Tanggal Pinjam</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="transaksi_tgl" id="transaksi_tgl" 
                       class="form-control datepicker-notauto" 
                       value="<?= date('d-m-Y') ?>" 
                       required placeholder="dd-mm-yyyy">
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Rencana Kembali</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="kembali_rencana_tgl" id="kembali_rencana_tgl" 
                       class="form-control datepicker-notauto" 
                       required placeholder="dd-mm-yyyy">
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label">Keperluan</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="transaksi_ket" class="form-control" placeholder="Contoh: Dinas Luar Kota">
            </div>
        </div>

        <div class="border-dotted my-3"></div>
        
        <h4 class="mb-3 text-warning">Rincian Barang</h4>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Asal Gudang</label>
            <div class="col-lg-8 col-md-6">
                <select name="gudang_id" id="gudang_id" class="form-select" required>
                    <option value="">-- Pilih Gudang --</option>
                    <?php foreach ($list_gudang as $gdg): ?>
                        <option value="<?= $gdg['gudang_id'] ?>"><?= $gdg['gudang_nm'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Nama Asset</label>
            <div class="col-lg-8 col-md-6">
                <select name="asset_id" id="asset_id" class="form-select" required disabled>
                    <option value="">- Pilih Gudang Dulu -</option>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Jumlah</label>
            <div class="col-lg-8 col-md-6">
                <input type="number" name="pemakaian_qty" id="pemakaian_qty" class="form-control" min="1" step="any" value="1" required disabled>
            </div>
        </div>

        <div class="border-dotted mt-3"></div>

        <div class="row mt-2">
            <div class="col-9 offset-3">
                <button type="submit" class="btn btn-warning text-dark" onclick="_save(event)">
                    <?= _icon('check') ?> Simpan
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
        // Jalankan Watcher agar Auto Number responsif
        startDateWatcher();
    });

    // --- FUNGSI WATCHER (PEMANTAU TANGGAL) ---
    function startDateWatcher() {
        setInterval(function() {
            var tglInput = $('#transaksi_tgl');
            var tglVal = tglInput.val(); // Format dd-mm-yyyy

            if (tglVal && tglVal.length == 10 && tglVal !== lastDateValue) {
                lastDateValue = tglVal; 

                $.ajax({ 
                    url: '<?= site_url($this->uri . "/get_no_transaksi_ajax?n=" . _get("n")) ?>', 
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

>>>>>>> repoB/main
    // 1. Load Asset saat Gudang dipilih
    $('#gudang_id').change(function() {
        var gid = $(this).val();
        var $assetSelect = $('#asset_id');
        var $qtyInput = $('#pemakaian_qty');

        if (!gid) {
            $assetSelect.html('<option value="">- Pilih Gudang Dulu -</option>').prop('disabled', true);
            $qtyInput.prop('disabled', true);
            return;
        }

        $assetSelect.html('<option>Loading...</option>').prop('disabled', true);
        
        $.ajax({
<<<<<<< HEAD
            url: '<?= $this->uri . "/get_assets_by_gudang?n=" . _get("n") ?>', 
            type: 'POST', data: { gudang_id: gid }, dataType: 'json',
            success: function(data) {
                var ops = '<option value="">- Pilih Asset Tersedia -</option>';
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        var stok = parseFloat(item.stok_qty);
                        ops += `<option value="${item.asset_id}" data-stok="${stok}">
                                ${item.asset_nm} (Sisa: ${stok})
=======
            url: '<?= site_url($this->uri . "/get_assets_by_gudang?n=" . _get("n")) ?>', 
            type: 'POST', data: { gudang_id: gid }, dataType: 'json',
            // Bagian script AJAX success di View Anda

            success: function(data) {
                var ops = '<option value="">- Pilih Asset Tersedia -</option>';
                
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        var stok = parseFloat(item.stok_qty);
                        
                        // --- [MODIFIKASI LOGIKA TAMPILAN] ---
                        var detailInfo = [];

                        // 1. Cek Merk (Standar)
                        if (item.merk) detailInfo.push(item.merk);
                        
                        // 2. Cek 'Merek & Tipe' (KHUSUS AKSESORIS - BARU)
                        // Jika atribut ini ada isinya, kita tampilkan.
                        if (item.merek_tipe) detailInfo.push(item.merek_tipe);

                        // 3. Cek Spesifikasi
                        if (item.spesifikasi) detailInfo.push(item.spesifikasi);
                        
                        // 4. Cek Nopol
                        if (item.nopol) detailInfo.push('[' + item.nopol + ']');

                        // Gabungkan jadi string
                        var detailStr = detailInfo.length > 0 ? ' (' + detailInfo.join(' - ') + ')' : '';

                        // Masukkan ke option text
                        ops += `<option value="${item.asset_id}" data-stok="${stok}">
                                ${item.asset_nm}${detailStr} - Sisa: ${stok}
>>>>>>> repoB/main
                                </option>`;
                    });
                } else {
                    ops = '<option value="">(Gudang Kosong)</option>';
                }
<<<<<<< HEAD
=======

>>>>>>> repoB/main
                $assetSelect.html(ops).prop('disabled', false);
                $qtyInput.prop('disabled', false);
            }
        });
    });

    // 2. Validasi Stok (Real-time)
    $('#pemakaian_qty, #asset_id').on('change keyup', function() {
        var stok = parseFloat($('#asset_id :selected').data('stok')) || 0;
        var qty = parseFloat($('#pemakaian_qty').val()) || 0;
        
        if (qty > stok && stok > 0) {
            alert('Stok tidak cukup! Maksimal: ' + stok);
            $('#pemakaian_qty').val(stok);
        }
    });
<<<<<<< HEAD

    // 3. Auto Number
    $(document).on('change', '#transaksi_tgl', function() {
        var tgl = $(this).val(); 
        $('#transaksi_no').val('Loading...');
        $.ajax({ 
            url: '<?= $this->uri . "/get_no_transaksi_ajax?n=" . _get("n") ?>', 
            type: 'POST', data: { tanggal: tgl }, dataType: 'json',
            success: function(res) { if(res.new_no) $('#transaksi_no').val(res.new_no); } 
        });
    });
=======
>>>>>>> repoB/main
</script>