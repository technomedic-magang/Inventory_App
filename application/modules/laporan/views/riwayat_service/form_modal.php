<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="card-body">
        
        <h4 class="mb-3 text-primary">Informasi Aset</h4>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">Filter Kategori</label>
            <div class="col-lg-8 col-md-8">
                <select id="filter_kategori" class="form-select" onchange="filterAssetByKategori()">
                    <option value="">- Tampilkan Semua -</option>
                    <?php foreach($list_kategori as $kat): ?>
                        <option value="<?= $kat['kategori_id'] ?>"><?= $kat['kategori_nm'] ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted">Pilih kategori untuk menyaring daftar aset dibawah.</small>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Pilih Aset</label>
            <div class="col-lg-8 col-md-8">
                <select name="asset_id" id="asset_id" class="form-select select2-modal" required onchange="cekJenisAset()">
                    <option value="">- Cari Nama / Kode Aset -</option>
                    <?php foreach ($list_asset as $k): ?>
                        <option value="<?= $k['asset_id'] ?>" 
                                data-kode="<?= $k['kategori_kd'] ?>"
                                data-kat-id="<?= $k['kategori_id'] ?>" 
                                <?= (@$main['asset_id'] == $k['asset_id']) ? 'selected' : '' ?>>
                            [<?= $k['asset_kd'] ?>] <?= $k['asset_nm'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="border-dotted my-3"></div>
        
        <h4 class="mb-3 text-primary">Detail Pengerjaan</h4>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Tanggal</label>
            <div class="col-lg-8 col-md-8">
                <input type="text" id="tgl_service" name="tgl_service" 
                       class="form-control datepicker-notauto" 
                       value="<?= (@$main['tgl_service']) ? date('d-m-Y', strtotime($main['tgl_service'])) : date('d-m-Y') ?>" 
                       required placeholder="dd-mm-yyyy">
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">Tempat / Bengkel</label>
            <div class="col-lg-8 col-md-8">
                <input type="text" name="bengkel_nm" class="form-control" placeholder="Nama Toko / Vendor Service" value="<?= @$main['bengkel_nm'] ?>">
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label required">Rincian Perbaikan</label>
            <div class="col-lg-8 col-md-8">
                <textarea name="keterangan_txt" class="form-control" rows="2" required placeholder="Jelaskan detail kerusakan atau perawatan..."><?= @$main['keterangan_txt'] ?></textarea>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-lg-3 col-md-4 col-form-label">Biaya</label>
            <div class="col-lg-8 col-md-8">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="biaya" class="form-control number-separator text-start" placeholder="0" value="<?= @$main['biaya'] ?>">
                </div>
            </div>
        </div>

        <div id="area-kendaraan" class="d-none">
            <div class="border-dotted my-3"></div>
            <h4 class="mb-3 text-warning"><i class="fas fa-car me-2"></i>Data Khusus Kendaraan</h4>
            
            <div class="mb-1 row">
                <label class="col-lg-3 col-md-4 col-form-label">KM Saat Ini</label>
                <div class="col-lg-8 col-md-8">
                    <input type="text" id="kilometer_saat_ini" name="kilometer_saat_ini" class="form-control number-separator" placeholder="Posisi Odometer" value="<?= @$main['kilometer_saat_ini'] ?>">
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-lg-3 col-md-4 col-form-label text-muted">Jadwal Berikutnya</label>
                <div class="col-lg-4 col-md-4">
                    <div class="input-group input-group-flat">
                        <span class="input-group-text">Tgl</span>
                        <input type="text" id="tgl_berikutnya" name="tgl_berikutnya" 
                               class="form-control datepicker-notauto" 
                               value="<?= (@$main['tgl_berikutnya']) ? date('d-m-Y', strtotime($main['tgl_berikutnya'])) : '' ?>"
                               placeholder="dd-mm-yyyy">
                    </div>
                    <small class="text-muted">*Estimasi +3 Bulan</small>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="input-group input-group-flat">
                        <span class="input-group-text">KM</span>
                        <input type="text" id="kilometer_berikutnya" name="kilometer_berikutnya" class="form-control number-separator" placeholder="Target KM" value="<?= @$main['kilometer_berikutnya'] ?>">
                    </div>
                    <small class="text-muted">*Estimasi +3000 KM</small>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-9 offset-3">
                <button type="submit" class="btn btn-primary" onclick="_save(event)">Simpan Data</button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
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

    var allAssets = [];
    var lastDateValue = '';

    $(document).ready(function() {
        // 1. Simpan Data Aset ke Memory
        $('#asset_id option').each(function() {
            if($(this).val() != '') { 
                allAssets.push({
                    value: $(this).val(),
                    text: $(this).text(),
                    katId: $(this).data('kat-id'),
                    kode: $(this).data('kode')
                });
            }
        });

        // 2. Init Plugin
        $('.select2-modal').select2(select2Options);
        
        // Format Angka
        $(document).on('input', '.number-separator', function() {
            var value = $(this).val().replace(/[^0-9]/g, '');
            if(value) {
                $(this).val(new Intl.NumberFormat('id-ID').format(value));
            } else {
                $(this).val('');
            }
        });

        // 3. LOGIKA OTOMASI TANGGAL
        startDateWatcher();

        // 4. LOGIKA KM
        $('#kilometer_saat_ini').on('keyup input', function() {
            var valStr = $(this).val().replace(/\./g, '');
            var currentKM = parseInt(valStr) || 0;
            
            if (currentKM > 0) {
                var nextKM = currentKM + 3000;
                $('#kilometer_berikutnya').val(new Intl.NumberFormat('id-ID').format(nextKM));
            } else {
                $('#kilometer_berikutnya').val('');
            }
        });

        // 5. Cek saat load
        cekJenisAset();
    });

    // --- FUNGSI WATCHER ---
    function startDateWatcher() {
        setInterval(function() {
            var tglInput = $('#tgl_service');
            var tglVal = tglInput.val(); 
            var isVisible = !$('#area-kendaraan').hasClass('d-none');

            if (isVisible && tglVal !== lastDateValue) {
                lastDateValue = tglVal; 

                if (tglVal && tglVal.includes('-')) {
                    var parts = tglVal.split('-');
                    if (parts.length === 3) {
                        var day = parseInt(parts[0], 10);
                        var month = parseInt(parts[1], 10) - 1; 
                        var year = parseInt(parts[2], 10);
                        
                        var d = new Date(year, month, day);
                        
                        if(!isNaN(d.getTime())) {
                            d.setMonth(d.getMonth() + 3); 
                            
                            var newYear = d.getFullYear();
                            var newMonth = ('0' + (d.getMonth() + 1)).slice(-2);
                            var newDay = ('0' + d.getDate()).slice(-2);
                            
                            var nextDate = newDay + '-' + newMonth + '-' + newYear;
                            $('#tgl_berikutnya').val(nextDate);
                        }
                    }
                }
            }
        }, 500); 
    }

    // --- FUNGSI FILTER (CLIENT SIDE) ---
    function filterAssetByKategori() {
        var katID = $('#filter_kategori').val();
        var $assetSelect = $('#asset_id');
        
        if ($assetSelect.data('select2')) { $assetSelect.select2('destroy'); }
        $assetSelect.find('option:gt(0)').remove();

        $.each(allAssets, function(index, item) {
            if (katID === "" || item.katId == katID) {
                var $option = $('<option>', { value: item.value, text: item.text });
                $option.attr('data-kat-id', item.katId);
                $option.attr('data-kode', item.kode); 
                $assetSelect.append($option);
            }
        });

        $assetSelect.select2(select2Options);
        $assetSelect.val('').trigger('change');
        $('#area-kendaraan').addClass('d-none');
    }

    // --- FUNGSI CEK JENIS ---
    function cekJenisAset() {
        var $selectedOption = $('#asset_id').find('option:selected');
        var katKode = $selectedOption.attr('data-kode'); 
        
        if(katKode == 'K2' || katKode == 'K4' || katKode == 'KENDARAAN') {
            $('#area-kendaraan').removeClass('d-none');
        } else {
            $('#area-kendaraan').addClass('d-none');
            $('#kilometer_saat_ini, #kilometer_berikutnya, #tgl_berikutnya').val('');
        }
    }
</script>