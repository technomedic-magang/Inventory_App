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
        <input type="date" name="transaksi_tgl" id="transaksi_tgl" class="form-control" value="<?= date('Y-m-d') ?>" required>
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
    // Simpan data item global agar mudah diakses
    var itemsData = {};

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
            url: '<?= $this->uri . "/get_items_pemakaian?n=" . _get("n") ?>',
            type: 'POST', data: { pemakaian_id: pid }, dataType: 'json',
            success: function(data) {
                itemsData = {}; // Reset data
                var ops = '<option value="">- Pilih Barang yang Dikembalikan -</option>';
                if (data.length === 0) {
                    ops = '<option value="">Semua barang sudah lunas/kembali</option>';
                } else {
                    $.each(data, function(i, item) {
                        // Simpan data lengkap item ke object global dengan key ID
                        itemsData[item.pemakaian_detail_id] = item;
                        ops += `<option value="${item.pemakaian_detail_id}">
                                ${item.asset_nm} (${item.asset_kd}) - Sisa: ${parseFloat(item.sisa_qty)}
                                </option>`;
                    });
                }
                $itemSelect.html(ops).prop('disabled', false);
            }
        });
    }

    function fillItemData() {
        var id = $('#item_select').val();
        if(!id) {
             $('#kembali_qty').prop('disabled', true);
             return;
        }
        
        var item = itemsData[id];
        if(item) {
            // Isi hidden input
            $('#asset_id').val(item.asset_id);
            $('#gudang_id').val(item.gudang_id); // Kembalikan ke gudang asal
            
            // Set max qty
            var sisa = parseFloat(item.sisa_qty);
            $('#max_qty').val(sisa);
            $('#kembali_qty').val(sisa).prop('disabled', false).attr('max', sisa);
            
            $('#item_info').text('Gudang Asal: ' + item.gudang_nm);
        }
    }

    // Validasi Max Qty
    $('#kembali_qty').on('change keyup', function() {
        var max = parseFloat($('#max_qty').val());
        var val = parseFloat($(this).val());
        if(val > max) {
            alert('Maksimal pengembalian: ' + max);
            $(this).val(max);
        }
    });

    // Auto Number
    $(document).on('change', '#transaksi_tgl', function() {
        var tgl = $(this).val(); $('#transaksi_no').val('Loading...');
        $.ajax({ 
            url: '<?= $this->uri . "/get_no_transaksi_ajax?n=" . _get("n") ?>', 
            type: 'POST', data: { tanggal: tgl }, dataType: 'json',
            success: function(res) { if(res.new_no) $('#transaksi_no').val(res.new_no); } 
        });
    });
</script>