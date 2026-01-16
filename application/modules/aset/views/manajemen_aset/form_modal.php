<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body">
        
        <h4 class="mb-3 text-primary">Informasi Utama</h4>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Kode Aset (SKU)</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="asset_kd" id="asset_kd" class="form-control bg-light" 
                       value="<?= @$main['asset_kd'] ?>" readonly placeholder="(Otomatis digenerate)">
            </div>
        </div>
        
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Kategori</label>
            <div class="col-lg-8 col-md-6">
                <select name="kategori_id" id="kategori_id" class="form-select select2-modal" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($list_kategori as $kat): ?>
                        <option value="<?= $kat['kategori_id'] ?>" 
                                data-tipe="<?= $kat['kategori_tipe'] ?>" 
                                data-kode="<?= $kat['kategori_kd'] ?>" 
                                <?= (@$main['kategori_id'] == $kat['kategori_id']) ? 'selected' : '' ?>>
                            <?= $kat['kategori_nm'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Singkatan Nama</label>
            <div class="col-lg-8 col-md-6">
                <select name="asset_kd_singkat" id="asset_kd_singkat" class="form-select select2-tags" required onchange="updateSKUPreview()">
                    <?php if(!empty($main['asset_kd_singkat'])): ?>
                        <option value="<?= $main['asset_kd_singkat'] ?>" selected><?= $main['asset_kd_singkat'] ?></option>
                    <?php endif; ?>
                </select>
                <small class="text-muted">Pilih dari riwayat atau ketik baru (otomatis Uppercase).</small>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Nama Aset</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="asset_nm" class="form-control" 
                       value="<?= @$main['asset_nm'] ?>" required placeholder="Contoh: Laptop Dell Latitude">
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Satuan</label>
            <div class="col-lg-8 col-md-6">
                <select name="satuan_id" id="satuan_id" class="form-select select2-modal" required>
                    <option value="">-- Pilih Satuan --</option>
                    <?php foreach ($list_satuan as $sat): ?>
                        <option value="<?= $sat['satuan_id'] ?>" 
                                <?= (@$main['satuan_id'] == $sat['satuan_id']) ? 'selected' : '' ?>>
                            <?= $sat['satuan_nm'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="border-dotted my-3"></div>
        <h4 class="mb-3 text-success">Informasi Tambahan</h4>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Tanggal Beli</label>
            <div class="col-lg-8 col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    <input type="text" name="beli_tgl" id="beli_tgl" class="form-control datepicker-notauto" 
                           value="<?= (@$main['beli_tgl']) ? date('d-m-Y', strtotime($main['beli_tgl'])) : date('d-m-Y') ?>" 
                           required placeholder="dd-mm-yyyy">
                </div>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Harga Beli</label>
            <div class="col-lg-8 col-md-6">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="beli_nominal" class="form-control rupiah-input" 
                           value="<?= @$main['beli_nominal'] ?>" required>
                </div>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">Masa Pakai</label>
            <div class="col-lg-8 col-md-6">
                <div class="input-group">
                    <input type="number" name="pakai_masa_bln" class="form-control" 
                           min="0" value="<?= @$main['pakai_masa_bln'] + 0 ?>" required>
                    <span class="input-group-text">Bulan</span>
                </div>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label">Metode Depresiasi</label>
            <div class="col-lg-8 col-md-6">
                <select name="depresiasi_metode" class="form-select">
                    <option value="NONE">Tidak Ada (Aset Tetap)</option>
                    <option value="STRAIGHT_LINE" <?= (@$main['depresiasi_metode']=='STRAIGHT_LINE')?'selected':'' ?>>
                        Garis Lurus (Straight Line)
                    </option>
                </select>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label">Nilai Residu Min</label>
            <div class="col-lg-8 col-md-6">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="residu_nominal" class="form-control rupiah-input" 
                           value="<?= @$main['residu_nominal'] ?>">
                </div>
            </div>
        </div>

        <div id="area-dinamis-kontainer">
            <div id="area-atribut-kustom"></div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label">Keterangan</label>
            <div class="col-lg-8 col-md-6">
                <textarea name="asset_ket" class="form-control" rows="2"><?= @$main['asset_ket'] ?></textarea>
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
    var select2TagsOptions = {
        theme: "bootstrap-5",
        dropdownParent: $('#form').closest('.modal'),
        tags: true, 
        width: '100%',
        placeholder: "-- Pilih Kategori Terlebih Dahulu --",
        allowClear: true,
        createTag: function (params) {
            var term = $.trim(params.term);
            if (term === '') { return null; }
            return { id: term.toUpperCase(), text: term.toUpperCase() + ' (Baru)', newOption: true }
        }
    };

    var lastDateValue = ''; // [NEW] Variabel Watcher

    $(document).ready(function() {
        $('#kategori_id').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#form').closest('.modal'),
            width: '100%'
        });

        $('#satuan_id').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#form').closest('.modal'),
            width: '100%'
        });

        var $selectSingkat = $('#asset_kd_singkat').select2(select2TagsOptions);

        $('#kategori_id').on('select2:select', function(e) {
            var data = e.params.data;
            console.log('Kategori Dipilih:', data.id);
            autoSelectSatuanUnit();
            loadSingkatanOptions(true); 
            loadFormDinamis();      
        });

        $('#kategori_id').on('select2:clear', function(e) {
             resetSingkatan();
             $('#area-atribut-kustom').html('');
        });

        if ('<?= @$main['kategori_id'] ?>') {
            loadFormDinamis();
            loadSingkatanOptions(false); 
        } else {
            $('#asset_kd_singkat').prop('disabled', true);
        }

        // [NEW] Aktifkan Watcher Tanggal agar SKU terupdate otomatis
        startDateWatcher();
    });

    // --- FORMATTER RUPIAH (Auto Separator) ---
    $(document).on('input', '.rupiah-input', function() {
        // 1. Ambil value asli, buang semua karakter selain angka
        var value = $(this).val().replace(/[^0-9]/g, '');
        
        // 2. Format ke ribuan Indonesia (menggunakan titik)
        if (value) {
            $(this).val(new Intl.NumberFormat('id-ID').format(value));
        } else {
            $(this).val('');
        }
    });

    // Trigger input event saat load agar data dari DB (jika ada) langsung terformat
    // Timeout kecil diperlukan agar value masuk dulu
    setTimeout(function(){
        $('.rupiah-input').trigger('input');
    }, 100);

    // --- LOGIC FUNCTIONS ---

    // [NEW] Fungsi Watcher (Diadaptasi dari Riwayat Service)
    // Fungsinya: Memantau input tanggal, jika berubah, trigger update SKU
    function startDateWatcher() {
        // Set nilai awal
        lastDateValue = $('#beli_tgl').val();
        
        setInterval(function() {
            var tglInput = $('#beli_tgl');
            var tglVal = tglInput.val(); // Format dd-mm-yyyy

            if (tglVal !== lastDateValue) {
                lastDateValue = tglVal;
                // Jika tanggal berubah, panggil update SKU
                updateSKUPreview(); 
            }
        }, 500); // Cek setiap 500ms
    }

    function resetSingkatan() {
        var $selectSingkat = $('#asset_kd_singkat');
        $selectSingkat.empty(); 
        $selectSingkat.val(null).trigger('change'); 
        $selectSingkat.prop('disabled', true);
    }

    function autoSelectSatuanUnit() {
        var $satuan = $('#satuan_id');
        var valUnit = '';
        $satuan.find('option').each(function() {
            var txt = $(this).text().trim().toLowerCase();
            if (txt === 'unit' || txt.includes('unit')) {
                valUnit = $(this).val();
                return false; 
            }
        });
        if (valUnit) {
            $satuan.val(valUnit).trigger('change');
        }
    }

    function loadSingkatanOptions(isReset = false) {
        var kategori_id = $('#kategori_id').val();
        var $selectSingkat = $('#asset_kd_singkat');
        var currentVal = '<?= @$main['asset_kd_singkat'] ?>'; 
        if ($selectSingkat.val()) { currentVal = $selectSingkat.val(); }

        if (isReset) {
            $selectSingkat.empty().trigger('change'); 
            currentVal = null; 
        }

        if (!kategori_id) { resetSingkatan(); return; }

        $selectSingkat.prop('disabled', false);

        $.ajax({
            url: '<?= site_url("manajemen/manajemen_asset/get_singkatan_ajax?n=" . _get("n")) ?>',
            type: 'POST',
            data: { 
                kategori_id: kategori_id, 
                ts: new Date().getTime(),
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(data) {
                $selectSingkat.append(new Option('', '', false, false));
                if (data && data.length > 0) {
                    data.forEach(function(item) {
                        var isSelected = (currentVal === item.asset_kd_singkat);
                        var newOption = new Option(item.asset_kd_singkat, item.asset_kd_singkat, isSelected, isSelected);
                        $selectSingkat.append(newOption);
                    });
                }
                if (currentVal && !isReset) {
                    var exists = false;
                    $selectSingkat.find('option').each(function(){ if (this.value == currentVal) { exists = true; return false; } });
                    if (!exists) {
                        var newOption = new Option(currentVal, currentVal, true, true);
                        $selectSingkat.append(newOption);
                    }
                    $selectSingkat.val(currentVal).trigger('change');
                } else {
                     $selectSingkat.trigger('change');
                }
            },
            error: function(xhr, status, error) { console.error("Error AJAX:", error); }
        });
    }

    function loadFormDinamis() {
        var kategori_id = $('#kategori_id').val();
        var asset_id = '<?= @$main['asset_id'] ?? '' ?>'; 
        $('#area-atribut-kustom').html('<div class="text-center p-2"><span class="spinner-border spinner-border-sm"></span> Loading atribut...</div>');
        if (!kategori_id) { $('#area-atribut-kustom').html(''); return; }
        $.ajax({
            url: '<?= site_url("manajemen/manajemen_asset/get_atribut_dinamis?n=" . _get("n")) ?>',
            type: 'POST', 
            data: { 
                kategori_id: kategori_id, asset_id: asset_id,
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
            }, 
            dataType: 'json',
            success: function(res) { 
                $('#area-atribut-kustom').html(res.html); 
                updateSKUPreview(); 
            },
            error: function() { $('#area-atribut-kustom').html(''); }
        });
    }

    function updateSKUPreview() {
        var asset_id = '<?= @$main['asset_id'] ?? '' ?>';
        if (asset_id != '') return; 

        var data_sku = {
            kategori_id: $('#kategori_id').val(),
            kd_singkat: $('#asset_kd_singkat').val(),
            tgl_beli: $('#beli_tgl').val(), // Format dd-mm-yyyy akan dikirim ke controller
            '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
        };

        if (data_sku.kategori_id && data_sku.kd_singkat && data_sku.tgl_beli) {
            $('#asset_kd').val('Generating...');
            $.ajax({
                url: '<?= site_url("manajemen/manajemen_asset/get_sku_ajax?n=" . _get("n")) ?>',
                type: 'POST', data: data_sku, dataType: 'json',
                success: function(res) { 
                    if (res.new_sku) $('#asset_kd').val(res.new_sku); 
                    else $('#asset_kd').val('Error');
                }
            });
        }
    }
</script>