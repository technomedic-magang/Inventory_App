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
                <?php 
                    $val_tgl = @$main['beli_tgl'] ? date('d-m-Y', strtotime($main['beli_tgl'])) : date('d-m-Y');
                ?>
                <input type="text" id="beli_tgl" name="beli_tgl" 
                       class="form-control datepicker-notauto" 
                       value="<?= $val_tgl ?>" 
                       required placeholder="dd-mm-yyyy">
            </div>
        </div>
        
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">No. Transaksi</label>
            <div class="col-lg-9 col-md-8">
                <input type="text" id="struk_no" name="struk_no" class="form-control bg-light" 
                       readonly placeholder="Otomatis..." value="<?= @$main['struk_no'] ?>">
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
                <small class="text-muted">Ketik untuk mencari atau menambah barang baru.</small>
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

    var lastDateValue = '';

    $(document).ready(function() {
        // Init Select2
        $('.select2-modal').select2(select2Options);
        
        // Filter awal
        filterBarangByKategori(); 
        
        // Cek Preview Nomor
        if($('#struk_no').val() == '') { 
            updateNoTransaksi(); 
        }

        // Jalankan Watcher Tanggal
        dateWatcher();
    });

    // --- Fungsi Helper ---

    function dateWatcher() {
        setInterval(function() {
            var tgl = $('#beli_tgl').val();
            if (tgl && tgl.length == 10 && tgl !== lastDateValue) {
                lastDateValue = tgl;
                updateNoTransaksi(); 
            }
        }, 100);
    }

    function onFilterChange() {
        filterBarangByKategori();
        updateNoTransaksi();
    }

    function filterBarangByKategori() {
        var katID = $('#filter_kategori').val();
        var $selectBarang = $('#persediaan_id');
        
        // Reset pilihan barang saat kategori berubah
        $selectBarang.val('').trigger('change');
        
        // Loop opsi untuk enable/disable sesuai kategori
        $selectBarang.find('option').each(function() {
            var itemKat = $(this).data('kategori');
            
            // Tampilkan jika kategori cocok, atau belum ada kategori, atau opsi kosong
            var shouldShow = (katID === "" || itemKat == katID || $(this).val() == "" || typeof itemKat === 'undefined');
            
            if (shouldShow) {
                $(this).prop('disabled', false); 
            } else {
                $(this).prop('disabled', true); 
            }
        });

        // Re-init Select2 agar perubahan disabled ter-render
        if ($selectBarang.data('select2')) { 
            $selectBarang.select2('destroy'); 
        }
        $selectBarang.select2(select2Options);
    }

    function onBarangChange(el) {
        var $opt = $(el).find(':selected');
        
        // Auto-fill field lain berdasarkan data barang
        var sat = $opt.data('satuan');
        var lan = $opt.data('lantai');
        var rua = $opt.data('ruang');
        
        if (sat) $('#satuan_id').val(sat);
        if (lan) $('#lokasi_lantai').val(lan);
        if (rua) $('#lokasi_ruang').val(rua);
    }

    function updateNoTransaksi() {
        var $kat = $('#filter_kategori option:selected');
        var katKode = $kat.data('kode') || 'GEN';
        var tgl = $('#beli_tgl').val(); 

        if (tgl && tgl.length == 10) {
            // Konversi dd-mm-yyyy menjadi yyyy.mm.dd untuk preview
            var parts = tgl.split('-');
            if (parts.length == 3) {
                var formattedDate = parts[2] + '.' + parts[1] + '.' + parts[0];
                
                // Format: KODE-YYYY.MM.DD-AUTO
                $('#struk_no').val(katKode + '-' + formattedDate + '-AUTO');
                return;
            }
        }
        
        $('#struk_no').val('');
    }
</script>