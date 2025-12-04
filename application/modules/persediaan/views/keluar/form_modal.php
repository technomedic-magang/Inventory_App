<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body">
        
        <h4 class="text-danger mb-3">Informasi Transaksi</h4>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Tanggal Keluar</label>
            <div class="col-lg-9 col-md-8">
                <input type="date" id="keluar_tgl" name="keluar_tgl" class="form-control" value="<?= @$main['keluar_tgl'] ?? date('Y-m-d') ?>" required onchange="updateNoTransaksi()">
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">No. Transaksi</label>
            <div class="col-lg-9 col-md-8">
                <input type="text" id="struk_no" name="struk_no" class="form-control bg-light" readonly placeholder="Otomatis..." value="<?= @$main['struk_no'] ?>">
                <small class="text-muted">Format: OUT-KODE-YYYY.MM.DD-URUT</small>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Keperluan</label>
            <div class="col-lg-9 col-md-8">
                <select name="keperluan_jenis" class="form-select" required>
                    <option value="">- Pilih Keperluan -</option>
                    <option value="Pemakaian Rutin">Pemakaian Rutin (Operasional)</option>
                    <option value="Rusak / Expired">Rusak / Kadaluwarsa</option>
                    <option value="Koreksi Stok">Koreksi Stok (Stock Opname)</option>
                    <option value="Hibah / Sumbangan">Hibah / Sumbangan</option>
                    <option value="Lain-lain">Lain-lain</option>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">Pengguna</label>
            <div class="col-lg-9 col-md-8">
                <select name="penerima_nm" class="form-select select2-modal">
                    <option value="">- Pilih Pegawai -</option>
                    <?php foreach($list_pegawai as $pgw): ?>
                        <option value="<?= $pgw['pegawai_nm'] ?>" <?= (@$main['penerima_nm'] == $pgw['pegawai_nm']) ? 'selected' : '' ?>>
                            <?= $pgw['pegawai_nm'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="border-dotted my-3"></div>
        
        <h4 class="text-danger mb-3">Detail Barang</h4>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">Filter Kategori</label>
            <div class="col-lg-9 col-md-8">
                <select id="filter_kategori" name="kategori_temp" class="form-select" onchange="onFilterChange()">
                    <option value="">- Semua Kategori -</option>
                    <?php foreach($list_kategori as $kat): ?>
                        <option value="<?= $kat['kategori_id'] ?>" data-kode="<?= $kat['kategori_kd'] ?>"><?= $kat['kategori_nm'] ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted">Pilih kategori untuk mempermudah pencarian barang.</small>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Nama Barang</label>
            <div class="col-lg-9 col-md-8">
                <select name="persediaan_id" id="persediaan_id" class="form-select select2-modal" required onchange="cekStok(this)">
                    <option value="">- Pilih Barang -</option>
                    <?php foreach ($list_barang as $brg): ?>
                        <option value="<?= $brg['persediaan_id'] ?>" 
                                data-kategori="<?= $brg['kategori_id'] ?>" 
                                data-satuan="<?= $brg['satuan_id'] ?>"
                                data-stok="<?= $brg['stok_qty'] ?>">
                            <?= $brg['barang_nm'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">Stok Tersedia</label>
            <div class="col-lg-9 col-md-8">
                <div class="input-group">
                    <input type="text" id="info_stok" class="form-control bg-light fw-bold text-dark" readonly value="0">
                    <span class="input-group-text" id="info_satuan">-</span>
                </div>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Jumlah Keluar</label>
            <div class="col-lg-9 col-md-8">
                <input type="number" id="keluar_qty" name="keluar_qty" class="form-control" min="0.01" step="0.01" required placeholder="0">
                <small class="text-danger d-none" id="alert_stok">
                    <i class="fas fa-exclamation-circle"></i> Stok tidak mencukupi!
                </small>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">Keterangan</label>
            <div class="col-lg-9 col-md-8">
                <textarea name="keterangan_txt" class="form-control" rows="1" placeholder="Catatan khusus item ini..."></textarea>
            </div>
        </div>

        <div class="border-dotted my-3"></div>
        
        <div class="row mt-2">
            <div class="col-9 offset-3">
                <button type="submit" class="btn btn-danger" id="btn_simpan" onclick="_save(event)">
                    <?= _icon('save') ?> Simpan
                </button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                    <?= _icon('cancel') ?> Batal
                </button>
            </div>
        </div>
    </div>

    <input type="hidden" name="satuan_id" id="satuan_id">
</form>

<script>
    var select2Options = {
        theme: "bootstrap-5",
        dropdownParent: $('#form').closest('.modal'),
        width: '100%'
    };

    $(document).ready(function() {
        $('.select2-modal').select2(select2Options);
        
        // Init awal
        filterBarangByKategori();
        if($('#struk_no').val() == '') { updateNoTransaksi(); }
    });

    function onFilterChange() {
        filterBarangByKategori();
        updateNoTransaksi();
    }

    function filterBarangByKategori() {
        var katID = $('#filter_kategori').val();
        var $selectBarang = $('#persediaan_id');
        
        // Reset Barang
        $selectBarang.val('').trigger('change');
        
        // Reset Info Stok
        $('#info_stok').val('0');
        $('#info_satuan').text('-');

        $selectBarang.find('option').each(function() {
            var itemKat = $(this).data('kategori');
            if (katID === "" || itemKat == katID || $(this).val() == "") {
                $(this).prop('disabled', false); 
            } else {
                $(this).prop('disabled', true); 
            }
        });

        if ($selectBarang.data('select2')) { $selectBarang.select2('destroy'); }
        $selectBarang.select2(select2Options);
    }

    // Cek Stok saat barang dipilih
    function cekStok(el) {
        var $opt = $(el).find(':selected');
        var stok = parseFloat($opt.data('stok')) || 0;
        var satID = $opt.data('satuan');
        
        // Update Info Stok UI
        $('#info_stok').val(stok.toLocaleString('id-ID'));
        $('#satuan_id').val(satID); 
        
        // Reset Qty & Validasi Limit
        $('#keluar_qty').attr('max', stok);
        $('#keluar_qty').val('');
        
        $('#alert_stok').addClass('d-none');
        $('#btn_simpan').prop('disabled', false);
    }

    // Validasi Real-time saat ketik qty
    $('#keluar_qty').on('input', function() {
        var val = parseFloat($(this).val());
        var max = parseFloat($(this).attr('max')) || 0;
        
        if(val > max) {
            $('#alert_stok').removeClass('d-none');
            $('#btn_simpan').prop('disabled', true); // Kunci tombol simpan
        } else {
            $('#alert_stok').addClass('d-none');
            $('#btn_simpan').prop('disabled', false);
        }
    });

    function updateNoTransaksi() {
        var $kat = $('#filter_kategori option:selected');
        // Ambil kode dari attribute data-kode, default OUT jika kosong
        var katKode = $kat.data('kode') || 'OUT'; 
        var tgl = $('#keluar_tgl').val();
        
        if(tgl) {
            var formattedDate = tgl.replace(/-/g, '.'); 
            $('#struk_no').val(katKode + '-' + formattedDate + '-AUTO');
        }
    }
</script>