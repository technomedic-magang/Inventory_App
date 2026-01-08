<?php
// --- 1. PERSIAPAN DATA ---
$data_assets_js = [];

foreach($list_asset as $row) {
    $kode = strtoupper($row['asset_kd']); 
    
    // Logika Deteksi Tipe
    $type = 'LAINNYA';
    if (strpos($kode, 'K2') !== false || strpos($kode, 'K4') !== false) {
        $type = 'KENDARAAN';
    } elseif (strpos($kode, 'GG') !== false) {
        $type = 'BANGUNAN';
    }

    $nopol_fix = !empty($row['nopol_asli']) ? $row['nopol_asli'] : '-';

    $data_assets_js[] = [
        'id'    => $row['asset_id'],
        'text'  => $row['asset_nm'],
        'nopol' => $nopol_fix,
        'kode'  => $row['asset_kd'],
        'due'   => $row['tgl_pajak_tahunan'],
        'type'  => $type
    ];
}
?>

<form id="form" action="<?= $form_act ?>" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="modal-body">
        
        <h4 class="text-primary mb-3">Input Pembayaran Pajak</h4>

        <div class="mb-3 p-2 border rounded bg-light">
            <label class="form-label required fw-bold text-dark">Kategori Aset</label>
            <div class="form-selectgroup">
                <label class="form-selectgroup-item">
                    <input type="radio" name="tipe_filter" value="KENDARAAN" class="form-selectgroup-input" checked onchange="filterAssetByType()">
                    <span class="form-selectgroup-label"><i class="fas fa-car me-1"></i> Kendaraan (K2/K4)</span>
                </label>
                <label class="form-selectgroup-item">
                    <input type="radio" name="tipe_filter" value="BANGUNAN" class="form-selectgroup-input" onchange="filterAssetByType()">
                    <span class="form-selectgroup-label"><i class="fas fa-building me-1"></i> Bangunan (GG)</span>
                </label>
                <label class="form-selectgroup-item">
                    <input type="radio" name="tipe_filter" value="LAINNYA" class="form-selectgroup-input" onchange="filterAssetByType()">
                    <span class="form-selectgroup-label"><i class="fas fa-box me-1"></i> Lainnya</span>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-2">
                <label class="form-label required">Objek Pajak / Nama Aset</label>
                <select name="asset_id" id="asset_id" class="form-select select2-modal" required onchange="getAssetInfo()">
                    <option value="">- Cari Aset -</option>
                </select>
            </div>
        </div>

        <div class="row bg-blue-lt border rounded p-2 mb-3 mx-0 text-center">
            <div class="col-4 border-end" id="col_info_kode">
                <small class="text-muted d-block" style="font-size:10px">Kode Aset (ID)</small>
                <span class="fw-bold d-block text-truncate" id="view_kode">-</span>
            </div>
            
            <div class="col-4 border-end" id="col_info_nopol">
                <small class="text-muted d-block" style="font-size:10px">Nomor Polisi</small>
                <span class="fw-bold d-block text-truncate" id="view_nopol">-</span>
            </div>
            
            <div class="col-4" id="col_info_due">
                <small class="text-muted d-block" style="font-size:10px">Jatuh Tempo Terakhir</small>
                <span class="fw-bold text-danger d-block text-truncate" id="view_due">-</span>
            </div>
        </div>

        <div class="mb-2 row">
            <label class="col-lg-3 col-form-label required">Jenis Pembayaran</label>
            <div class="col-lg-9">
                <select name="pajak_jenis" id="pajak_jenis" class="form-select" required onchange="toggleFormLogic()">
                </select>
                <small class="text-info" id="hint_jenis">-</small>
            </div>
        </div>

        <div class="mb-2 row" id="div_nopol_baru" style="display:none;">
            <label class="col-lg-3 col-form-label required text-primary">Plat Nomor Baru</label>
            <div class="col-lg-9">
                <input type="text" name="nopol_baru" id="nopol_baru" class="form-control text-uppercase" placeholder="Contoh: AB 1234 XY">
            </div>
        </div>

        <div class="border-dotted my-3"></div>

        <div class="mb-2 row">
            <label class="col-lg-3 col-form-label required">Tanggal Bayar</label>
            <div class="col-lg-8 col-md-6">
                <input type="text" name="transaksi_tgl" id="transaksi_tgl" class="form-control datepicker-notauto" value="<?= date('d-m-Y') ?>" required placeholder="dd-mm-yyyy">
            </div>
        </div>

        <div class="mb-2 row">
            <label class="col-lg-3 col-form-label">No. Transaksi</label>
            <div class="col-lg-9">
                <input type="text" id="transaksi_no" name="transaksi_no" class="form-control bg-light" readonly value="<?= @$preview_no ?>">
            </div>
        </div>

        <div class="mb-2 row">
            <label class="col-lg-3 col-form-label required">Biaya Pokok</label>
            <div class="col-lg-9">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="nominal_pokok" class="form-control rupiah" required placeholder="0">
                </div>
            </div>
        </div>

        <div class="mb-2 row">
            <label class="col-lg-3 col-form-label">Denda (Jika ada)</label>
            <div class="col-lg-9">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="nominal_denda" class="form-control rupiah" placeholder="0">
                </div>
            </div>
        </div>

        <div class="mb-2 row">
            <label class="col-lg-3 col-form-label">Bukti Bayar</label>
            <div class="col-lg-9">
                <input type="file" name="bukti_file" class="form-control" accept="image/*,application/pdf">
            </div>
        </div>

        <div class="mb-2 row">
            <label class="col-lg-3 col-form-label">Keterangan</label>
            <div class="col-lg-9">
                <textarea name="transaksi_ket" class="form-control" rows="1" placeholder="Catatan..."></textarea>
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
    var allAssets = <?= json_encode($data_assets_js) ?>;
    var lastDateValue = '';

    $(document).ready(function() {
        $('.select2-modal').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#form').closest('.modal'),
            width: '100%',
            matcher: function(params, data) {
                if ($.trim(params.term) === '') return data;
                if (typeof data.text === 'undefined') return null;
                if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1) return data;
                return null;
            }
        });

        $('.rupiah').on('keyup', function(){ $(this).val(formatRupiah($(this).val())); });

        // Init Data
        filterAssetByType();
        startDateWatcher();
    });

    function startDateWatcher() {
        setInterval(function() {
            var tglInput = $('#transaksi_tgl');
            var rawVal = tglInput.val(); 
            if (rawVal && rawVal.length >= 10 && rawVal !== lastDateValue) {
                lastDateValue = rawVal;
                $.ajax({ 
                    url: '<?= site_url("laporan/pajak/get_no_transaksi_ajax?n=" . _get("n")) ?>', 
                    type: 'POST', 
                    data: { tanggal: rawVal }, 
                    dataType: 'json',
                    success: function(res) { 
                        if(res && res.new_no) $('#transaksi_no').val(res.new_no);
                    }
                });
            }
        }, 500);
    }

    // --- FUNGSI UTAMA (UPDATED) ---
    function filterAssetByType() {
        var selectedType = $('input[name="tipe_filter"]:checked').val();
        
        // 1. LOGIKA UI: Sembunyikan Nopol jika bukan kendaraan
        if (selectedType === 'KENDARAAN') {
            // Tampilkan kolom Nopol
            $('#col_info_nopol').show();
            // Kembalikan lebar kolom lain ke col-4
            $('#col_info_kode').removeClass('col-6').addClass('col-4');
            $('#col_info_due').removeClass('col-6').addClass('col-4');
        } else {
            // Sembunyikan kolom Nopol
            $('#col_info_nopol').hide();
            // Lebarkan kolom sisa jadi col-6 agar rapi
            $('#col_info_kode').removeClass('col-4').addClass('col-6');
            $('#col_info_due').removeClass('col-4').addClass('col-6');
        }

        // 2. Populate Dropdown Aset
        var $select = $('#asset_id');
        $select.empty(); 
        $select.append(new Option('- Cari Aset -', ''));

        var count = 0;
        $.each(allAssets, function(i, item) {
            if(item.type === selectedType) {
                var label = item.text;
                // Hanya tampilkan Nopol di label dropdown jika tipe kendaraan
                if(item.nopol !== '-' && selectedType === 'KENDARAAN') label += ' [' + item.nopol + ']';
                label += ' (' + item.kode + ')';

                var newOption = new Option(label, item.id, false, false);
                $(newOption).attr('data-nopol', item.nopol);
                $(newOption).attr('data-due', item.due);
                $(newOption).attr('data-kode', item.kode);
                
                $select.append(newOption);
                count++;
            }
        });

        if(count === 0) {
            $select.append(new Option('(Tidak ada data)', '', false, false));
        }
        $select.trigger('change'); 
        resetInfoUI(); 

        // 3. Update Jenis Pembayaran
        updatePajakOptions(selectedType);
    }

    function resetInfoUI() {
        $('#view_kode').text('-');
        $('#view_nopol').text('-');
        $('#view_due').text('-');
        $('#nopol_baru').val('');
        $('#div_nopol_baru').hide();
    }

    function updatePajakOptions(type) {
        var $pajakSelect = $('#pajak_jenis');
        $pajakSelect.empty(); 

        if(type === 'KENDARAAN') {
            $pajakSelect.append(new Option('Pajak Tahunan (Ulang STNK)', 'TAHUNAN'));
            $pajakSelect.append(new Option('Pajak 5 Tahunan (Ganti Kaleng)', '5_TAHUNAN'));
            $('#hint_jenis').text('Masa berlaku STNK bertambah 1 tahun.');
        } else if(type === 'BANGUNAN') {
            $pajakSelect.append(new Option('Pajak Bumi & Bangunan (PBB)', 'PBB'));
            $('#hint_jenis').text('Pembayaran PBB Tahunan.');
        } else {
            $pajakSelect.append(new Option('Pajak Tahunan (Umum)', 'TAHUNAN'));
            $('#hint_jenis').text('Pembayaran pajak aset umum.');
        }
        
        toggleFormLogic();
    }

    function getAssetInfo() {
        var $opt = $('#asset_id option:selected');
        
        if(!$opt.val()) {
             resetInfoUI();
             return;
        }

        var nopol = $opt.attr('data-nopol');
        var due   = $opt.attr('data-due');
        var kode  = $opt.attr('data-kode');

        $('#view_kode').text(kode ? kode : '-');
        $('#view_nopol').text(nopol); 
        
        if(nopol && nopol !== '-') {
            $('#nopol_baru').val(nopol);
        } else {
            $('#nopol_baru').val('');
        }
        
        if(due && due !== 'null' && due !== '') {
            try {
                var dateObj = new Date(due);
                var dateStr = dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                $('#view_due').text(dateStr);
            } catch(e) { $('#view_due').text(due); }
        } else {
            $('#view_due').text('Belum ada riwayat');
        }
    }

    function toggleFormLogic() {
        var jenis = $('#pajak_jenis').val();
        if(jenis === '5_TAHUNAN') {
            $('#div_nopol_baru').slideDown();
            $('#nopol_baru').prop('required', true);
            $('#hint_jenis').text('Update Masa Berlaku STNK (+1 Thn) & Plat (+5 Thn).');
        } else {
            $('#div_nopol_baru').slideUp();
            $('#nopol_baru').prop('required', false);
        }
    }

    function formatRupiah(angka) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa  = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    }
</script>