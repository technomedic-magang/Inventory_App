<?php
// Persiapan data JSON untuk JS
$data_assets_js = [];
foreach($list_asset as $row) {
    $kode = strtoupper($row['asset_kd']); 
    $type = 'LAINNYA';
    // Deteksi Tipe Sederhana dari Kode
    if (strpos($kode, 'K2') !== false || strpos($kode, 'K4') !== false || strpos($kode, 'MBL') !== false || strpos($kode, 'MTR') !== false) {
        $type = 'KENDARAAN';
    } elseif (strpos($kode, 'GG') !== false || strpos($kode, 'GDU') !== false) {
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

<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="card-body">

        <h4 class="text-primary mb-3">Informasi Pembayaran Pajak</h4>

        <div class="mb-3 p-2 border rounded bg-light">
            <label class="form-label required fw-bold text-dark">Kategori Aset</label>
            <div class="form-selectgroup">
                <label class="form-selectgroup-item">
                    <input type="radio" name="tipe_filter" value="KENDARAAN" class="form-selectgroup-input" checked onchange="filterAssetByType()">
                    <span class="form-selectgroup-label"><i class="fas fa-car me-1"></i> Kendaraan</span>
                </label>
                <label class="form-selectgroup-item">
                    <input type="radio" name="tipe_filter" value="BANGUNAN" class="form-selectgroup-input" onchange="filterAssetByType()">
                    <span class="form-selectgroup-label"><i class="fas fa-building me-1"></i> Bangunan</span>
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
                <small class="text-muted d-block" style="font-size:10px">Kode Aset</small>
                <span class="fw-bold d-block text-truncate" id="view_kode">-</span>
            </div>
            <div class="col-4 border-end" id="col_info_nopol">
                <small class="text-muted d-block" style="font-size:10px">Identitas (Plat)</small>
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
            <div class="col-lg-9">
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
                <textarea name="transaksi_ket" class="form-control" rows="1" placeholder="Catatan tambahan..."></textarea>
            </div>
        </div>

        <div class="border-dotted my-3"></div>
        
        <div class="row mt-2">
            <div class="col-9 offset-3">
                <button type="submit" class="btn btn-primary" onclick="_save(event)">
                    <?= _icon('check') ?> Simpan Data
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

        // Format Rupiah
        $('.rupiah').on('input', function(){ 
            var val = $(this).val().replace(/[^0-9]/g, '');
            if(val) $(this).val(new Intl.NumberFormat('id-ID').format(val));
        });

        // Init
        filterAssetByType();
        startDateWatcher();
    });

    // Auto Number Watcher
    function startDateWatcher() {
        setInterval(function() {
            var rawVal = $('#transaksi_tgl').val(); 
            if (rawVal && rawVal.length >= 10 && rawVal !== lastDateValue) {
                lastDateValue = rawVal;
                // Gunakan URL Absolut dari Controller
                $.ajax({ 
                    url: '<?= $this->uri . "/get_no_transaksi_ajax?n=" . _get("n") ?>', 
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

    // Logic UI
    function filterAssetByType() {
        var selectedType = $('input[name="tipe_filter"]:checked').val();
        
        if (selectedType === 'KENDARAAN') {
            $('#col_info_nopol').show();
            $('#col_info_kode').removeClass('col-6').addClass('col-4');
            $('#col_info_due').removeClass('col-6').addClass('col-4');
        } else {
            $('#col_info_nopol').hide();
            $('#col_info_kode').removeClass('col-4').addClass('col-6');
            $('#col_info_due').removeClass('col-4').addClass('col-6');
        }

        var $select = $('#asset_id');
        $select.empty().append(new Option('- Cari Aset -', ''));

        $.each(allAssets, function(i, item) {
            if(item.type === selectedType) {
                var label = item.text + ' (' + item.kode + ')';
                if(item.nopol !== '-' && selectedType === 'KENDARAAN') label = item.text + ' [' + item.nopol + ']';

                var newOption = new Option(label, item.id, false, false);
                $(newOption).attr('data-nopol', item.nopol);
                $(newOption).attr('data-due', item.due);
                $(newOption).attr('data-kode', item.kode);
                $select.append(newOption);
            }
        });
        $select.trigger('change'); 
        resetInfoUI(); 
        updatePajakOptions(selectedType);
    }

    function resetInfoUI() {
        $('#view_kode').text('-'); $('#view_nopol').text('-'); $('#view_due').text('-');
        $('#nopol_baru').val(''); $('#div_nopol_baru').hide();
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
        if(!$opt.val()) { resetInfoUI(); return; }

        $('#view_kode').text($opt.attr('data-kode') || '-');
        $('#view_nopol').text($opt.attr('data-nopol') || '-');
        
        var due = $opt.attr('data-due');
        if(due && due !== 'null') {
            try {
                var d = new Date(due);
                $('#view_due').text(d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }));
            } catch(e) { $('#view_due').text(due); }
        } else {
            $('#view_due').text('Belum ada riwayat');
        }

        if($opt.attr('data-nopol') && $opt.attr('data-nopol') !== '-') {
            $('#nopol_baru').val($opt.attr('data-nopol'));
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
</script>