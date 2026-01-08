<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
  <div class="card-body">
    
    <h4 class="mb-3 text-success">Data Pengembalian</h4>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">No. Pemakaian (OPEN)</label>
      <div class="col-lg-8 col-md-6">
        <select name="pemakaian_id" id="pemakaian_id" class="form-select" required onchange="loadItems()">
            <option value="">-- Pilih Transaksi Pemakaian --</option>
            <?php foreach ($list_pemakaian as $pmk): ?>
                <option value="<?= $pmk['pemakaian_id'] ?>">
                    <?= $pmk['transaksi_no'] ?> (<?= $pmk['pegawai_nm'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">No. Pengembalian</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="transaksi_no" id="transaksi_no" class="form-control bg-light" 
               value="<?= @$main['transaksi_no'] ?? @$preview_no ?>" readonly>
      </div>
    </div>
    
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Tanggal Kembali</label>
      <div class="col-lg-8 col-md-6">
<<<<<<< HEAD
        <input type="date" name="transaksi_tgl" id="transaksi_tgl" class="form-control" value="<?= date('Y-m-d') ?>" required>
=======
        <input type="text" name="transaksi_tgl" id="transaksi_tgl" 
               class="form-control datepicker-notauto" 
               value="<?= date('d-m-Y') ?>" 
               required placeholder="dd-mm-yyyy">
>>>>>>> repoB/main
      </div>
    </div>
    
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label">Catatan</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="transaksi_ket" class="form-control" placeholder="Keterangan...">
      </div>
    </div>

    <div class="border-dotted my-3"></div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Pilih Barang</label>
      <div class="col-lg-8 col-md-6">
        <select name="pemakaian_detail_id" id="item_select" class="form-select" required disabled onchange="fillItemData()">
             <option value="">- Pilih Pemakaian Dulu -</option>
        </select>
        <small class="text-muted" id="item_info"></small>
      </div>
    </div>
    
    <input type="hidden" name="asset_id" id="asset_id">
    <input type="hidden" name="gudang_id" id="gudang_id">
    <input type="hidden" id="max_qty">

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Jumlah Kembali</label>
      <div class="col-lg-8 col-md-6">
        <input type="number" name="kembali_qty" id="kembali_qty" class="form-control" min="1" step="any" value="0" required disabled>
        <small class="text-muted">Maksimal sisa pinjam.</small>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Kondisi Saat Ini</label>
      <div class="col-lg-8 col-md-6">
        <select name="kondisi_asset" class="form-select" required>
            <option value="BAIK">BAIK</option>
            <option value="RUSAK">RUSAK (Perlu Perbaikan)</option>
        </select>
      </div>
    </div>

<<<<<<< HEAD

=======
>>>>>>> repoB/main
    <div class="border-dotted mt-3"></div>

    <div class="row mt-2">
      <div class="col-9 offset-3">
        <button type="submit" class="btn btn-success" onclick="_save(event)">
            <?= _icon('check') ?> Proses Kembali
        </button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
            <?= _icon('cancel') ?> Batal
        </button>
      </div>
    </div>
  </div>
</form>

<script>
<<<<<<< HEAD
    // Simpan data item global agar mudah diakses
    var itemsData = {};

=======
    var itemsData = {};
    var lastDateValue = ''; 

    $(document).ready(function() {
        // Jalankan Watcher Auto Number
        startDateWatcher();
    });

    // --- WATCHER AUTO NUMBER ---
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
                    }
                });
            }
        }, 100); 
    }

    // --- Load Barang via AJAX ---
>>>>>>> repoB/main
    function loadItems() {
        var pid = $('#pemakaian_id').val();
        var $itemSelect = $('#item_select');
        
        // Reset Form
        $itemSelect.html('<option value="">Loading...</option>').prop('disabled', true);
        $('#kembali_qty').val(0).prop('disabled', true);
        $('#item_info').text('');

        if (!pid) {
            $itemSelect.html('<option value="">- Pilih Pemakaian Dulu -</option>');
            return;
        }

        $.ajax({
<<<<<<< HEAD
            url: '<?= $this->uri . "/get_items_pemakaian?n=" . _get("n") ?>',
            type: 'POST', data: { pemakaian_id: pid }, dataType: 'json',
            success: function(data) {
                itemsData = {}; // Reset data
                var ops = '<option value="">- Pilih Barang yang Dikembalikan -</option>';
=======
            url: '<?= site_url($this->uri_mod . "/get_items_pemakaian?n=" . _get("n")) ?>',
            type: 'POST', data: { pemakaian_id: pid }, dataType: 'json',
            success: function(data) {
                itemsData = {}; 
                var ops = '<option value="">- Pilih Barang yang Dikembalikan -</option>';
                
>>>>>>> repoB/main
                if (data.length === 0) {
                    ops = '<option value="">Semua barang sudah lunas/kembali</option>';
                } else {
                    $.each(data, function(i, item) {
<<<<<<< HEAD
                        // Simpan data lengkap item ke object global dengan key ID
                        itemsData[item.pemakaian_detail_id] = item;
                        ops += `<option value="${item.pemakaian_detail_id}">
                                ${item.asset_nm} (${item.asset_kd}) - Sisa: ${parseFloat(item.sisa_qty)}
=======
                        itemsData[item.pemakaian_detail_id] = item;
                        
                        // [MODIFIKASI] Tampilkan Info Lengkap (Merek, Tipe, Spek)
                        var detailInfo = [];
                        if (item.merk) detailInfo.push(item.merk);
                        if (item.merek_tipe) detailInfo.push(item.merek_tipe);
                        if (item.spesifikasi) detailInfo.push(item.spesifikasi);
                        if (item.nopol) detailInfo.push('[' + item.nopol + ']');
                        
                        var detailStr = detailInfo.length > 0 ? ' (' + detailInfo.join(' - ') + ')' : '';

                        ops += `<option value="${item.pemakaian_detail_id}">
                                ${item.asset_nm}${detailStr} - Sisa Pinjam: ${parseFloat(item.sisa_qty)}
>>>>>>> repoB/main
                                </option>`;
                    });
                }
                $itemSelect.html(ops).prop('disabled', false);
            }
        });
    }

<<<<<<< HEAD
=======
    // --- Isi Data Hidden Saat Barang Dipilih ---
>>>>>>> repoB/main
    function fillItemData() {
        var id = $('#item_select').val();
        if(!id) {
             $('#kembali_qty').prop('disabled', true);
             return;
        }
        
        var item = itemsData[id];
        if(item) {
<<<<<<< HEAD
            // Isi hidden input
            $('#asset_id').val(item.asset_id);
            $('#gudang_id').val(item.gudang_id); // Kembalikan ke gudang asal
            
            // Set max qty
=======
            $('#asset_id').val(item.asset_id);
            $('#gudang_id').val(item.gudang_id); 
            
>>>>>>> repoB/main
            var sisa = parseFloat(item.sisa_qty);
            $('#max_qty').val(sisa);
            $('#kembali_qty').val(sisa).prop('disabled', false).attr('max', sisa);
            
<<<<<<< HEAD
            $('#item_info').text('Gudang Asal: ' + item.gudang_nm);
        }
    }

    // Validasi Max Qty
=======
            $('#item_info').text('Dikembalikan ke: ' + item.gudang_nm);
        }
    }

    // --- Validasi Stok/Sisa ---
>>>>>>> repoB/main
    $('#kembali_qty').on('change keyup', function() {
        var max = parseFloat($('#max_qty').val());
        var val = parseFloat($(this).val());
        if(val > max) {
            alert('Maksimal pengembalian: ' + max);
            $(this).val(max);
        }
    });
<<<<<<< HEAD

    // Auto Number
    $(document).on('change', '#transaksi_tgl', function() {
        var tgl = $(this).val(); $('#transaksi_no').val('Loading...');
        $.ajax({ 
            url: '<?= $this->uri . "/get_no_transaksi_ajax?n=" . _get("n") ?>', 
            type: 'POST', data: { tanggal: tgl }, dataType: 'json',
            success: function(res) { if(res.new_no) $('#transaksi_no').val(res.new_no); } 
        });
    });
=======
>>>>>>> repoB/main
</script>