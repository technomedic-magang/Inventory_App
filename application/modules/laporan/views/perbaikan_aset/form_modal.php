<?php 
// Tentukan Mode: Read Only jika ID ada DAN status bukan 0 (Pending)
$is_readonly = ($id && @$main['status_tiket'] != 0); 
?>

<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="card-body">
        
        <h4 class="mb-3 text-primary">Informasi Tiket & Aset</h4>

        <div class="alert alert-light border">
            <div class="row">
                <div class="col-md-6">
                    <small class="text-muted d-block">No. Tiket:</small>
                    <div class="fw-bold text-primary">
                        <?= ($id) ? 'SERV/'.date('Y.m', strtotime($main['created_at'])).'/'.$asset_detail['asset_kd'].'/'.str_pad($id, 4, '0', STR_PAD_LEFT) : 'Generating...' ?>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                     <small class="text-muted d-block">Status Saat Ini:</small>
                     <?php 
                        $st = @$main['status_tiket'];
                        if($st == '0') echo '<span class="badge bg-red-lt">Menunggu Verifikasi</span>';
                        elseif($st == '1') echo '<span class="badge bg-yellow-lt">Sedang Diproses</span>';
                        elseif($st == '2') echo '<span class="badge bg-green text-white">Selesai</span>';
                        elseif($st == '9') echo '<span class="badge bg-secondary text-white">Ditolak</span>';
                        else echo '<span class="badge bg-secondary">Draft</span>';
                     ?>
                </div>
            </div>
        </div>

        <?php if($is_readonly): ?>
            <div class="hr-text text-blue">Detail Pengerjaan</div>

            <?php if($main['status_tiket'] == 1): ?>
                <div class="text-center py-3 bg-yellow-lt rounded mb-3">
                    <div class="display-6"><i class="fas fa-tools"></i></div>
                    <h3 class="mt-2 mb-0">Sedang Dalam Perbaikan</h3>
                    <p class="text-muted">Dijadwalkan pada: <strong><?= date('d-m-Y', strtotime($main['tgl_rencana'])) ?></strong></p>
                </div>
            
            <?php elseif($main['status_tiket'] == 2): ?>
                <div class="row row-cards">
                    <div class="col-md-6">
                        <div class="card card-sm border-success">
                            <div class="card-body">
                                <div class="text-muted">Tanggal Selesai</div>
                                <div class="fw-bold text-success h3 mb-0">
                                    <i class="fas fa-check-circle me-1"></i>
                                    <?= date('d-m-Y', strtotime($main['tgl_service'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="text-muted">Total Biaya</div>
                                <div class="fw-bold h3 mb-0">Rp <?= number_format($main['biaya'], 0, ',', '.') ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto"><i class="fas fa-store fa-2x text-muted"></i></div>
                                    <div class="col">
                                        <div class="text-muted">Bengkel / Vendor:</div>
                                        <div class="fw-bold"><?= $main['bengkel_nm'] ? $main['bengkel_nm'] : '-' ?></div>
                                    </div>
                                    <div class="col-auto border-start ps-3">
                                        <div class="text-muted">Kondisi Akhir:</div>
                                        <span class="badge bg-azure"><?= $asset_detail['asset_kondisi'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif($main['status_tiket'] == 9): ?>
                <div class="text-center py-4 bg-red-lt rounded">
                    <div class="display-6"><i class="fas fa-ban"></i></div>
                    <h3 class="mt-2 text-danger">Laporan Ditolak</h3>
                    <p>Mohon hubungi admin untuk informasi lebih lanjut.</p>
                </div>
            <?php endif; ?>

            <div class="mt-4">
                <label class="form-label">Data Laporan Anda:</label>
                <div class="form-control-plaintext border p-2 rounded bg-light">
                    <strong>Aset:</strong> [<?= $asset_detail['asset_kd'] ?>] <?= $asset_detail['asset_nm'] ?><br>
                    <strong>Tgl Lapor:</strong> <?= date('d-m-Y', strtotime($main['created_at'])) ?><br>
                    <strong>Keluhan:</strong> <?= $main['keluhan_deskripsi'] ?>
                    
                    <?php if(!empty($main['keluhan_foto'])): ?>
                        <div class="mt-2">
                            <a href="<?= base_url("uploads/service/".$main['keluhan_foto']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-image me-1"></i> Lihat Foto Bukti
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="modal-footer mt-3">
                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Tutup</button>
            </div>

        <?php else: ?>
            <div class="mb-1 row">
                <label class="col-lg-3 col-md-4 col-form-label">Pelapor</label>
                <div class="col-lg-8 col-md-8">
                    <input type="text" class="form-control bg-light" value="<?= $nama_pelapor ?>" readonly>
                </div>
            </div>

            <div class="border-dotted my-3"></div>
            
            <div class="mb-1 row">
                <label class="col-lg-3 col-md-4 col-form-label">Filter Kategori</label>
                <div class="col-lg-8 col-md-8">
                    <select id="filter_kategori" class="form-select" onchange="filterAssetByKategori()">
                        <option value="">- Tampilkan Semua -</option>
                        <?php foreach($list_kategori as $kat): ?>
                            <option value="<?= $kat['kategori_id'] ?>"><?= $kat['kategori_nm'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-lg-3 col-md-4 col-form-label required">Pilih Aset</label>
                <div class="col-lg-8 col-md-8">
                    <select name="asset_id" id="asset_id" class="form-select select2-modal" required onchange="onAssetChange()">
                        <option value="">- Cari Nama / Kode Aset -</option>
                        <?php foreach ($list_asset as $k): ?>
                            <?php 
                                // LOGIKA UTAMA: DISABLE JIKA SEDANG DIPERBAIKI
                                // Field 'status_perbaikan' didapat dari Subquery di Model M_perbaikan_aset
                                $is_repair  = (isset($k['status_perbaikan']) && $k['status_perbaikan'] > 0);
                                $is_current = (@$main['asset_id'] == $k['asset_id']); // Cek jika sedang edit tiket diri sendiri
                                
                                // Disable jika sedang rusak DAN bukan tiket yang sedang diedit
                                $disabled = ($is_repair && !$is_current) ? 'disabled' : '';
                                $info_txt = ($is_repair && !$is_current) ? ' (SEDANG DIPERBAIKI)' : '';
                                
                                // Opsional: Beri warna latar agak merah
                                $style    = ($is_repair && !$is_current) ? 'background-color: #fceceb; color: #d63939;' : '';
                            ?>
                            <option value="<?= $k['asset_id'] ?>" 
                                    data-kode="<?= $k['kategori_kd'] ?>"
                                    data-kat-id="<?= $k['kategori_id'] ?>" 
                                    <?= ($is_current) ? 'selected' : '' ?>
                                    <?= $disabled ?>
                                    style="<?= $style ?>">
                                [<?= $k['asset_kd'] ?>] <?= $k['asset_nm'] . $info_txt ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-danger d-none" id="warning_repair">* Aset yang sedang diperbaiki tidak dapat dipilih.</small>
                </div>
            </div>

            <div class="border-dotted my-3"></div>
            <h4 class="mb-3 text-primary">Detail Laporan</h4>

            <div class="mb-1 row">
                <label class="col-lg-3 col-md-4 col-form-label required">Tanggal Lapor</label>
                <div class="col-lg-8 col-md-8">
                    <input type="text" id="created_at" name="created_at" class="form-control datepicker-notauto" 
                           value="<?= (@$main['created_at']) ? date('d-m-Y', strtotime($main['created_at'])) : date('d-m-Y') ?>" 
                           required placeholder="dd-mm-yyyy">
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-lg-3 col-md-4 col-form-label required">Deskripsi Keluhan</label>
                <div class="col-lg-8 col-md-8">
                    <textarea name="keluhan_deskripsi" class="form-control" rows="3" required placeholder="Jelaskan detail kerusakan..."><?= @$main['keluhan_deskripsi'] ?></textarea>
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-lg-3 col-md-4 col-form-label">Foto Bukti</label>
                <div class="col-lg-8 col-md-8">
                    <input type="file" name="keluhan_foto" class="form-control" accept="image/*">
                    <?php if(!empty($main['keluhan_foto'])): ?>
                        <small class="text-success d-block mt-1">File tersimpan: <?= $main['keluhan_foto'] ?></small>
                    <?php endif; ?>
                </div>
            </div>

            <div id="area-kendaraan" class="d-none">
                <div class="border-dotted my-3"></div>
                <h4 class="mb-3 text-warning"><i class="fas fa-car me-2"></i>Data Khusus Kendaraan</h4>
                
                <div class="mb-1 row">
                    <label class="col-lg-3 col-md-4 col-form-label">Update Odometer?</label>
                    <div class="col-lg-8 col-md-8">
                        <select id="jenis_perbaikan_km" class="form-select form-select-sm" onchange="toggleFormKM()">
                            <option value="1">Ya (Service Rutin / Ganti Oli)</option>
                            <option value="0">Tidak (Ganti Sparepart / Ban / Body)</option>
                        </select>
                        <small class="text-muted d-block mt-1 lh-sm">
                            Pilih <b>"Ya"</b> jika service ini mempengaruhi jadwal ganti oli berikutnya.<br>
                            Pilih <b>"Tidak"</b> jika hanya perbaikan fisik.
                        </small>
                    </div>
                </div>

                <div class="mb-1 row">
                    <label class="col-lg-3 col-md-4 col-form-label required-km">KM Saat Ini</label>
                    <div class="col-lg-8 col-md-8">
                        <div class="input-group">
                            <input type="text" id="kilometer_saat_ini" name="kilometer_saat_ini" 
                                   class="form-control number-separator" 
                                   placeholder="0" 
                                   value="<?= @$main['kilometer_saat_ini'] ?>">
                            <span class="input-group-text">KM</span>
                        </div>
                    </div>
                </div>

                <div class="mb-1 row" id="row_estimasi_next">
                    <label class="col-lg-3 col-md-4 col-form-label text-muted">Estimasi Service Selanjutnya</label>
                    
                    <div class="col-lg-4 col-md-4">
                        <div class="input-group input-group-flat">
                            <span class="input-group-text">Tgl</span>
                            <input type="text" id="tgl_berikutnya" name="tgl_berikutnya" 
                                   class="form-control datepicker-notauto" 
                                   value="<?= (@$main['tgl_berikutnya']) ? date('d-m-Y', strtotime($main['tgl_berikutnya'])) : '' ?>">
                        </div>
                        <small class="text-muted">*Auto (+3 Bulan)</small>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <div class="input-group input-group-flat">
                            <span class="input-group-text">KM</span>
                            <input type="text" id="kilometer_berikutnya" name="kilometer_berikutnya" 
                                   class="form-control number-separator" 
                                   value="<?= @$main['kilometer_berikutnya'] ?>" 
                                   placeholder="Target KM">
                        </div>
                        <small class="text-muted">*Auto (+3000 KM)</small>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary" onclick="_save(event)">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Laporan
                    </button>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>

        <?php endif; // END IF READONLY ?>

    </div>
</form>

<?php if(!$is_readonly): ?>
<script>
    var select2Options = { theme: "bootstrap-5", dropdownParent: $('#form').closest('.modal'), width: '100%' };
    var allAssets = [];
    var lastDateValue = ''; 

    $(document).ready(function() {
        // Ambil data aset ke array, simpan juga status disabled-nya
        $('#asset_id option').each(function() {
            if($(this).val() != '') { 
                allAssets.push({ 
                    value: $(this).val(), 
                    text: $(this).text(), 
                    katId: $(this).data('kat-id'), 
                    kode: $(this).data('kode'),
                    disabled: $(this).is(':disabled'), // Simpan status disabled
                    style: $(this).attr('style') // Simpan style merahnya
                });
            }
        });

        $('.select2-modal').select2(select2Options);
        
        $(document).on('input', '.number-separator', function() {
            var value = $(this).val().replace(/[^0-9]/g, '');
            if(value) $(this).val(new Intl.NumberFormat('id-ID').format(value));
        });

        if ($('#filter_kategori').val() == "") { filterAssetByKategori(); }
        
        cekJenisAset();
        toggleFormKM(); 

        <?php if(!$id): ?>
            startDateWatcher();   
        <?php endif; ?>

        $('#kilometer_saat_ini').on('keyup input', function() {
            if($('#jenis_perbaikan_km').val() == '1') {
                var valStr = $(this).val().replace(/\./g, '');
                var currentKM = parseInt(valStr) || 0;
                if (currentKM > 0) {
                    var nextKM = currentKM + 3000; 
                    $('#kilometer_berikutnya').val(new Intl.NumberFormat('id-ID').format(nextKM));
                } else {
                    $('#kilometer_berikutnya').val('');
                }
            }
        });
    });

    function updateTicketNumber() {
        var tgl = $('#created_at').val();
        var asset_id = $('#asset_id').val(); 
        
        if(tgl && asset_id) {
            $('#no_tiket_display').val('Generating...');
            $.ajax({
                url: '<?= site_url($this->uri_mod . "/get_no_tiket_ajax?n=" . _get("n")) ?>',
                type: 'POST',
                data: { tanggal: tgl, asset_id: asset_id },
                dataType: 'json',
                success: function(res) {
                    if(res.status) { $('#no_tiket_display').val(res.no_tiket); } 
                    else { $('#no_tiket_display').val('Error Gen'); }
                }
            });
        } else { 
            $('#no_tiket_display').val('Pilih Aset & Tanggal...'); 
        }
    }

    function onAssetChange() { cekJenisAset(); updateTicketNumber(); }

    function startDateWatcher() {
        setInterval(function() {
            var tglInput = $('#created_at'); 
            var tglVal = tglInput.val(); 
            if (tglVal && tglVal.length == 10 && tglVal !== lastDateValue) {
                lastDateValue = tglVal;
                updateTicketNumber(); 
                if($('#jenis_perbaikan_km').val() == '1') { calculateNextDate(tglVal); }
            }
        }, 500); 
    }

    function toggleFormKM() {
        var jenis = $('#jenis_perbaikan_km').val(); 
        if (jenis == '1') {
            $('#kilometer_saat_ini').prop('readonly', false).attr('placeholder', 'Wajib diisi');
            $('.required-km').addClass('required'); 
            $('#row_estimasi_next').removeClass('d-none'); 
            $('#kilometer_saat_ini').trigger('keyup');
            calculateNextDate($('#created_at').val());
        } else {
            $('#kilometer_saat_ini').prop('readonly', false).attr('placeholder', 'Opsional (Hanya catat)');
            $('.required-km').removeClass('required');
            $('#row_estimasi_next').addClass('d-none'); 
            $('#kilometer_berikutnya').val('');
            $('#tgl_berikutnya').val('');
        }
    }

    function calculateNextDate(dateStr) {
        if (!dateStr || dateStr.length !== 10) return;
        var parts = dateStr.split('-'); 
        if (parts.length === 3) {
            var d = new Date(parts[2], parts[1]-1, parts[0]);
            if(!isNaN(d.getTime())) {
                d.setMonth(d.getMonth() + 3); 
                var newDate = ('0' + d.getDate()).slice(-2) + '-' + ('0' + (d.getMonth()+1)).slice(-2) + '-' + d.getFullYear();
                $('#tgl_berikutnya').val(newDate);
            }
        }
    }

    function filterAssetByKategori() {
        var katID = $('#filter_kategori').val();
        var $assetSelect = $('#asset_id');
        var currentSelected = $assetSelect.val(); 
        
        if ($assetSelect.data('select2')) { $assetSelect.select2('destroy'); }
        $assetSelect.find('option:gt(0)').remove();
        
        $.each(allAssets, function(index, item) {
            if (katID === "" || item.katId == katID) {
                var isSelected = (item.value == currentSelected) ? 'selected' : '';
                // [PENTING] Tambahkan kembali atribut disabled dan style saat filter ulang
                var disabledAttr = item.disabled ? 'disabled' : '';
                var styleAttr = item.style ? 'style="' + item.style + '"' : '';
                
                $assetSelect.append('<option value="'+item.value+'" data-kat-id="'+item.katId+'" data-kode="'+item.kode+'" '+isSelected+' '+disabledAttr+' '+styleAttr+'>'+item.text+'</option>');
            }
        });
        
        $assetSelect.select2(select2Options);
        if (!currentSelected) { $assetSelect.val('').trigger('change'); }
    }

    function cekJenisAset() {
        var $selectedOption = $('#asset_id').find('option:selected');
        var katKode = $selectedOption.attr('data-kode'); 
        
        if(katKode == 'K2' || katKode == 'K4' || katKode == 'KENDARAAN') {
            $('#area-kendaraan').removeClass('d-none');
        } else {
            $('#area-kendaraan').addClass('d-none');
            $('#kilometer_saat_ini').val('');
        }
    }
</script>
<?php endif; ?>