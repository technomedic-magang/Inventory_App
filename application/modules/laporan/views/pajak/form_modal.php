<?php
// --- 1. PERSIAPAN DATA DI SISI SERVER (PHP) ---
// Kita olah datanya di PHP dulu biar rapi, lalu di-convert ke JSON untuk Javascript
$data_assets_js = [];

foreach($list_asset as $row) {
    // Bersihkan kode aset agar seragam huruf besar
    $kode = strtoupper($row['asset_kd']); 
    
    // Default Tipe
    $type = 'LAINNYA';

    // Logika Deteksi (Dilonggarkan: Cukup mengandung 'K2' atau 'K4' dimanapun posisinya)
    if (strpos($kode, 'K2') !== false || strpos($kode, 'K4') !== false) {
        $type = 'KENDARAAN';
    } 
    elseif (strpos($kode, 'GG') !== false) {
        $type = 'BANGUNAN';
    }

    $data_assets_js[] = [
        'id'    => $row['asset_id'],
        'text'  => $row['asset_nm'],
        'nopol' => $row['nopol'],
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

        <div class="row bg-blue-lt border rounded p-2 mb-3 mx-0">
            <div class="col-6">
                <small class="text-muted d-block" id="label_identitas">Identitas (Plat/Kode):</small>
                <span class="fw-bold" id="info_nopol">-</span>
            </div>
            <div class="col-6">
                <small class="text-muted d-block">Jatuh Tempo Terakhir:</small>
                <span class="fw-bold text-danger" id="info_due">-</span>
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
                <input type="text" name="transaksi_tgl" id="transaksi_tgl" 
                    class="form-control datepicker-notauto" 
                    value="<?= date('d-m-Y') ?>" 
                    required placeholder="dd-mm-yyyy">
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
        
        // 1. INIT SELECT2
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

        // 2. INIT RUPIAH
        $('.rupiah').on('keyup', function(){ $(this).val(formatRupiah($(this).val())); });

        // 3. JALANKAN FILTER AWAL
        filterAssetByType();

        // 4. JALANKAN WATCHER NOMOR OTOMATIS
        startDateWatcher();
    });

    // --- FUNGSI WATCHER (DIPERBAIKI UNTUK HANDLE FORMAT TANGGAL) ---
    function startDateWatcher() {
        setInterval(function() {
            var tglInput = $('#transaksi_tgl');
            var rawVal = tglInput.val(); 
            
            // Validasi: Pastikan nilai ada dan minimal panjangnya 10 (yyyy-mm-dd atau dd-mm-yyyy)
            if (rawVal && rawVal.length >= 10 && rawVal !== lastDateValue) {
                lastDateValue = rawVal;
                
                // Normalisasi Tanggal sebelum dikirim ke Controller
                // Controller biasanya butuh YYYY-MM-DD untuk SQL, tapi kadang fungsi helper butuh DD-MM-YYYY
                // Kita kirim apa adanya dulu, biarkan controller yang parsing.
                
                // Debugging: Cek nilai yang dikirim di Console Browser
                console.log("Tanggal berubah:", rawVal);

                $.ajax({ 
                    url: '<?= site_url("laporan/pajak/get_no_transaksi_ajax?n=" . _get("n")) ?>', 
                    type: 'POST', 
                    data: { tanggal: rawVal }, 
                    dataType: 'json',
                    success: function(res) { 
                        if(res && res.new_no) {
                            $('#transaksi_no').val(res.new_no);
                            console.log("Nomor baru:", res.new_no);
                        }
                    },
                    error: function(xhr) {
                        console.error("Gagal update nomor:", xhr.responseText);
                    }
                });
            }
        }, 500); // Cek setiap 500ms
    }

    // --- FUNGSI FILTER & LAINNYA (TETAP SAMA) ---
    function filterAssetByType() {
        var selectedType = $('input[name="tipe_filter"]:checked').val();
        var $select = $('#asset_id');
        
        $select.html('<option value="">- Cari Aset -</option>');

        var count = 0;
        $.each(allAssets, function(i, item) {
            if(item.type === selectedType) {
                var label = item.text;
                if(item.nopol && item.nopol !== '') label += ' [' + item.nopol + ']';
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
        updatePajakOptions(selectedType);
        resetInfoUI();
    }

    function resetInfoUI() {
        $('#info_nopol').text('-');
        $('#info_due').text('-');
        $('#nopol_baru').val('');
        $('#div_nopol_baru').hide();
        $('#asset_id').val('').trigger('change.select2'); 
    }

    function updatePajakOptions(type) {
        var $pajakSelect = $('#pajak_jenis');
        $pajakSelect.empty();

        if(type === 'KENDARAAN') {
            $pajakSelect.append(new Option('Pajak Tahunan (Ulang STNK)', 'TAHUNAN'));
            $pajakSelect.append(new Option('Pajak 5 Tahunan (Ganti Kaleng)', '5_TAHUNAN'));
            $('#label_identitas').text('Plat Nomor:');
            $('#hint_jenis').text('Masa berlaku STNK bertambah 1 tahun.');
        } else if(type === 'BANGUNAN') {
            $pajakSelect.append(new Option('Pajak Bumi & Bangunan (PBB)', 'PBB'));
            $('#label_identitas').text('Kode / NOP:');
            $('#hint_jenis').text('Pembayaran PBB Tahunan.');
        } else {
            $pajakSelect.append(new Option('Pajak Tahunan (Umum)', 'TAHUNAN'));
            $('#label_identitas').text('Kode Aset:');
            $('#hint_jenis').text('Pembayaran pajak aset umum.');
        }
        toggleFormLogic();
    }

    function getAssetInfo() {
        var $opt = $('#asset_id option:selected');
        if(!$opt.val()) {
             $('#info_nopol').text('-');
             $('#info_due').text('-');
             return;
        }

        var nopol = $opt.attr('data-nopol');
        var due = $opt.attr('data-due');
        var kode = $opt.attr('data-kode');

        if(nopol && nopol !== '' && nopol !== 'null') {
            $('#info_nopol').text(nopol);
            $('#nopol_baru').val(nopol);
        } else {
            $('#info_nopol').text(kode);
            $('#nopol_baru').val('');
        }
        
        if(due && due !== 'null' && due !== '') {
            try {
                var dateObj = new Date(due);
                var dateStr = dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                $('#info_due').text(dateStr);
            } catch(e) { $('#info_due').text(due); }
        } else {
            $('#info_due').text('Belum ada riwayat');
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