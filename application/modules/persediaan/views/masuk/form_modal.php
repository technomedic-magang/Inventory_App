<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body">
        <h4 class="text-primary mb-3">Informasi Transaksi</h4>
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Kategori</label>
            <div class="col-lg-9 col-md-8">
                <select id="filter_kategori" name="kategori_temp" class="form-select" required onchange="onFilterChange()">
                    <option value="">- Pilih Kategori -</option>
                    <?php foreach($list_kategori as $kat): ?>
                        <option value="<?= $kat['kategori_id'] ?>" data-kode="<?= $kat['kategori_kd'] ?>">
                            <?= $kat['kategori_nm'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Tanggal</label>
            <div class="col-lg-9 col-md-8">
                <input type="date" id="beli_tgl" name="beli_tgl" class="form-control" value="<?= @$main['beli_tgl'] ?? date('Y-m-d') ?>" required onchange="updateNoTransaksi()">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">No. Transaksi</label>
            <div class="col-lg-9 col-md-8">
                <input type="text" id="struk_no" name="struk_no" class="form-control bg-light" readonly placeholder="Otomatis..." value="<?= @$main['struk_no'] ?>">
                <small class="text-muted">Format: KODE-TANGGAL-URUT</small>
            </div>
        </div>

        <div class="border-dotted my-3"></div>
        <h4 class="text-primary mb-3">Detail Barang</h4>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Nama Barang</label>
            <div class="col-lg-9 col-md-8">
                <select name="persediaan_id" id="persediaan_id" class="form-select select2-modal" required onchange="onBarangChange(this)">
                    <option value="">- Pilih Barang -</option>
                    <?php if(!empty($list_barang)): ?>
                        <?php foreach ($list_barang as $brg): ?>
                            <option value="<?= $brg['persediaan_id'] ?>" 
                                    data-kategori="<?= $brg['kategori_id'] ?>" 
                                    data-satuan="<?= $brg['satuan_id'] ?>"
                                    data-lantai="<?= $brg['lokasi_lantai'] ?>"
                                    data-ruang="<?= $brg['lokasi_ruang'] ?>">
                                <?= $brg['barang_nm'] ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Satuan Beli</label>
            <div class="col-lg-9 col-md-8">
                <select name="satuan_id" id="satuan_id" class="form-select" required>
                    <option value="">- Pilih Satuan -</option>
                    <?php foreach ($list_satuan as $st): ?>
                        <option value="<?= $st['satuan_id'] ?>"><?= $st['satuan_nm'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">Lokasi Lantai</label>
            <div class="col-lg-9 col-md-8">
                <input type="text" id="lokasi_lantai" name="lokasi_lantai" class="form-control" placeholder="Contoh: Lantai 1">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">Nama Ruangan</label>
            <div class="col-lg-9 col-md-8">
                <input type="text" id="lokasi_ruang" name="lokasi_ruang" class="form-control" placeholder="Contoh: Dapur">
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Jumlah</label>
            <div class="col-lg-9 col-md-8">
                <input type="number" name="masuk_qty" class="form-control" min="0.01" step="0.01" required placeholder="0">
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">Keterangan</label>
            <div class="col-lg-9 col-md-8">
                <textarea name="keterangan_txt" class="form-control" rows="1" placeholder="Catatan..."></textarea>
            </div>
        </div>

        <div class="border-dotted my-3"></div>
        <div class="row mt-2">
            <div class="col-9 offset-3">
                <button type="submit" class="btn btn-primary" onclick="_save(event)">
                    <?= _icon('save') ?> Simpan
                </button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                    <?= _icon('cancel') ?> Batal
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    var select2Options = {
        theme: "bootstrap-5",
        dropdownParent: $('#form').closest('.modal'),
        width: '100%',
        tags: true, 
        selectOnClose: true,
        createTag: function (params) {
            var term = $.trim(params.term);
            if (term === '') { return null; }
            return { id: term, text: term, newOption: true }
        }
    };

    $(document).ready(function() {
        $('.select2-modal').select2(select2Options);
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
        $selectBarang.val('').trigger('change');
        $selectBarang.find('option').each(function() {
            var itemKat = $(this).data('kategori');
            if (katID === "" || itemKat == katID || $(this).val() == "" || typeof itemKat === 'undefined') {
                $(this).prop('disabled', false); 
            } else {
                $(this).prop('disabled', true); 
            }
        });
        if ($selectBarang.data('select2')) { $selectBarang.select2('destroy'); }
        $selectBarang.select2(select2Options);
    }

    function onBarangChange(el) {
        var $opt = $(el).find(':selected');
        var sat = $opt.data('satuan');
        var lan = $opt.data('lantai');
        var rua = $opt.data('ruang');
        if (sat) $('#satuan_id').val(sat);
        if (lan) $('#lokasi_lantai').val(lan);
        if (rua) $('#lokasi_ruang').val(rua);
    }

    // --- PREVIEW NOMOR (Tanpa AJAX) ---
    function updateNoTransaksi() {
        var $kat = $('#filter_kategori option:selected');
        var katID = $kat.val();
        // Ambil kode dari data-kode, default GEN jika tidak ada
        var katKode = $kat.data('kode') || 'GEN';
        var tgl   = $('#beli_tgl').val();

        if(katID && tgl) {
            // Ubah format 2025-12-03 menjadi 2025.12.03
            var formattedDate = tgl.replace(/-/g, '.'); 
            
            // Tampilkan Preview: KODE-TANGGAL-AUTO
            $('#struk_no').val(katKode + '-' + formattedDate + '-AUTO');
        } else {
            $('#struk_no').val('');
        }
    }
</script>