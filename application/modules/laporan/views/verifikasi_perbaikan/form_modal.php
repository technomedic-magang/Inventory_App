<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="card-body">
        
        <div class="alert alert-info bg-azure-lt">
            <div class="d-flex justify-content-between">
                <div>
                    <strong><?= $detail['asset_nm'] ?></strong> 
                    <input type="hidden" id="hidden_nama_aset" value="<?= strtoupper($detail['asset_nm']) ?>">
                    <input type="hidden" id="hidden_kode_aset" value="<?= strtoupper($detail['asset_kd']) ?>">
                    <br> 
                    <small><?= $detail['asset_kd'] ?></small>
                </div>
                <div class="text-end">
                    Pelapor: <strong><?= $detail['pegawai_nm'] ?></strong><br>
                    <small>Tgl Lapor: <?= date('d-m-Y', strtotime($main['created_at'])) ?></small>
                </div>
            </div>
            <div class="mt-2 border-top pt-2">
                <strong>Keluhan:</strong> <?= $main['keluhan_deskripsi'] ?>

                <?php if(!empty($main['keluhan_foto'])): ?>
                    <div class="mt-2">
                        <small class="text-muted d-block mb-1">Foto Bukti (Before):</small>
                        <a href="<?= 'http://localhost/Project_Magang_API/uploads/keluhan/' . $main['keluhan_foto'] ?>" target="_blank" class="btn btn-sm btn-light border">
                            <i class="fas fa-image text-primary me-1"></i> Lihat Foto Kerusakan
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if(!empty($main['kilometer_saat_ini']) && $main['kilometer_saat_ini'] > 0): ?>
                    <br><small class="text-muted"><i class="fas fa-tachometer-alt me-1"></i> Posisi KM Awal: <?= number_format($main['kilometer_saat_ini'],0,',','.') ?></small>
                <?php endif; ?>
            </div>
        </div>

        <input type="hidden" name="aksi_admin" id="aksi_admin" value="">

        <?php if($main['status_tiket'] == 0): ?>
            
            <div class="text-center py-2 mb-2">
                <span class="badge bg-orange text-white mb-2">PROSES VERIFIKASI</span>
                <p class="text-muted small">Tentukan rencana perbaikan untuk aset ini.</p>
            </div>

            <div class="mb-2 row">
                <label class="col-3 col-form-label required">Tgl Rencana</label>
                <div class="col-9">
                    <input type="text" name="tgl_rencana" class="form-control datepicker-notauto" 
                           placeholder="dd-mm-yyyy" value="<?= date('d-m-Y', strtotime('+1 day')) ?>">
                </div>
            </div>

            <div class="mb-2 row">
                <label class="col-3 col-form-label required">Deskripsi Rencana</label>
                <div class="col-9">
                    <textarea name="deskripsi_rencana" class="form-control" rows="2" placeholder="Rencana tindakan..."><?= $main['deskripsi_rencana'] ? $main['deskripsi_rencana'] : $main['keluhan_deskripsi'] ?></textarea>
                </div>
            </div>

             <div class="mb-2 row">
                <label class="col-3 col-form-label">Rencana Bengkel</label>
                <div class="col-9">
                     <input type="text" name="bengkel_nm_rencana" class="form-control" placeholder="Nama Bengkel / Teknisi (Opsional)">
                </div>
            </div>

            <div id="row-ac-rencana" class="row mb-2 d-none bg-yellow-lt p-2 rounded mx-1">
                <label class="col-3 col-form-label text-orange">Jenis Tindakan AC</label>
                <div class="col-9">
                    <select name="jenis_perbaikan_ac" id="input_jenis_ac" class="form-select" disabled>
                        <option value="">- Pilih Jenis Tindakan -</option>
                        <option value="Cuci AC">Cuci AC (Maintenance Rutin)</option>
                        <option value="Isi Freon">Isi Freon</option>
                        <option value="Perbaikan Sparepart">Perbaikan Sparepart</option>
                        <option value="Bongkar Pasang">Bongkar Pasang</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer bg-light mt-3">
                <button type="submit" class="btn btn-success" onclick="$('#aksi_admin').val('approve'); _save(event)">
                    <i class="fas fa-check-circle me-1"></i> Terima & Jadwalkan
                </button>
                <button type="submit" class="btn btn-danger ms-auto" onclick="$('#aksi_admin').val('reject'); _save(event)">
                    <i class="fas fa-ban me-1"></i> Tolak
                </button>
            </div>


        <?php elseif($main['status_tiket'] == 1): ?>

            <div class="card mb-3 border-warning">
                <div class="card-status-top bg-warning"></div>
                <div class="card-body p-2 bg-muted-lt">
                    <small class="text-uppercase text-muted fw-bold">Rencana Awal:</small>
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td width="30%">Tgl Rencana</td><td>: <strong><?= date('d-m-Y', strtotime($main['tgl_rencana'])) ?></strong></td></tr>
                        <tr><td>Deskripsi</td><td>: <?= $main['deskripsi_rencana'] ?></td></tr>
                        <?php if($main['keterangan_txt']): ?>
                            <tr><td>Info Tambahan</td><td>: <?= $main['keterangan_txt'] ?></td></tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <div class="hr-text text-green">Input Realisasi / Penyelesaian</div>

            <div class="mb-2 row">
                <label class="col-3 col-form-label required">Tgl Selesai</label>
                <div class="col-9">
                    <input type="text" name="tgl_service" id="tgl_service" class="form-control datepicker-notauto" 
                           placeholder="dd-mm-yyyy" value="<?= date('d-m-Y') ?>" required>
                    
                    <div id="info_next_service" class="mt-2 p-2 rounded bg-azure-lt d-none border border-azure">
                        <div class="d-flex">
                            <div class="me-2"><i class="fas fa-calendar-check text-azure h2"></i></div>
                            <div>
                                <div class="small text-muted text-uppercase fw-bold">Jadwal Rutin Berikutnya</div>
                                <div class="fw-bold text-dark" id="lbl_tgl_next">-</div>
                                <div class="small text-muted lh-sm mt-1">Sistem akan otomatis menjadwalkan ulang (+3 Bulan).</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-2 row">
                <label class="col-3 col-form-label required">Deskripsi Pengerjaan</label>
                <div class="col-9">
                    <textarea name="deskripsi_penyelesaian" class="form-control" rows="2" placeholder="Apa yang sebenarnya dikerjakan?"><?= $main['deskripsi_penyelesaian'] ? $main['deskripsi_penyelesaian'] : $main['deskripsi_rencana'] ?></textarea>
                </div>
            </div>

            <div class="mb-2 row">
                <label class="col-3 col-form-label">Bengkel / Vendor</label>
                <div class="col-9">
                    <input type="text" name="bengkel_nm" class="form-control" value="<?= $main['bengkel_nm'] ? $main['bengkel_nm'] : $main['bengkel_nm'] ?>" placeholder="Nama Tempat Service">
                </div>
            </div>

            <div class="mb-2 row">
                <label class="col-3 col-form-label required">Biaya (Rp)</label>
                <div class="col-9">
                    <input type="text" name="biaya" class="form-control number-separator" 
                           placeholder="0" required inputmode="numeric" pattern="[0-9.]*">
                    <small class="text-muted">Hanya masukkan angka.</small>
                </div>
            </div>
            
            <div class="mb-2 row">
                <label class="col-3 col-form-label required fw-bold">Kondisi Akhir</label>
                <div class="col-9">
                    <select name="kondisi_akhir" class="form-select" required>
                        <option value="BAIK">BAIK (Normal Kembali)</option>
                        <option value="RUSAK RINGAN">RUSAK RINGAN (Masih ada kendala)</option>
                        <option value="RUSAK BERAT">RUSAK BERAT (Gagal Service)</option>
                    </select>
                </div>
            </div>

            <div class="mb-2 row">
                <label class="col-3 col-form-label fw-bold text-success">Foto After (Bukti)</label>
                <div class="col-9">
                    <input type="file" name="foto_pengerjaan" class="form-control" accept="image/*">
                    <small class="text-muted">Upload foto bukti bahwa perbaikan telah selesai.</small>
                </div>
            </div>

            <div class="modal-footer mt-3">
                <button type="submit" class="btn btn-success w-100" onclick="$('#aksi_admin').val('finish'); _save(event)">
                    <i class="fas fa-save me-1"></i> Simpan Penyelesaian & Update Stok
                </button>
            </div>


        <?php else: ?>
            
            <div class="text-center py-3">
                <?php if($main['status_tiket'] == 2): ?>
                    <div class="mb-2 text-success"><i class="fas fa-check-circle fa-3x"></i></div>
                    <h3 class="mb-3">Tiket Selesai</h3>
                    
                    <div class="card text-start bg-light border-success">
                        <div class="card-body">
                            <?php if(!empty($main['tgl_rencana'])): ?>
                                <small class="text-muted text-uppercase">Rencana Awal:</small>
                                <div class="mb-2">
                                    <strong>Tgl:</strong> <?= date('d-m-Y', strtotime($main['tgl_rencana'])) ?><br>
                                    <em>"<?= $main['deskripsi_rencana'] ?? '-' ?>"</em>
                                </div>
                                <hr class="my-2">
                            <?php endif; ?>

                            <small class="text-muted text-uppercase fw-bold text-success">Realisasi / Penyelesaian:</small>
                            <div class="mb-1">
                                <strong>Tgl Selesai:</strong> <?= date('d-m-Y', strtotime($main['tgl_service'])) ?>
                            </div>
                            
                            <div class="alert alert-success bg-white mb-2 p-2">
                                <strong>Catatan Pengerjaan:</strong><br>
                                <?= !empty($main['deskripsi_penyelesaian']) ? nl2br($main['deskripsi_penyelesaian']) : '-' ?>
                            </div>

                            <div class="d-flex justify-content-between fw-bold">
                                <span>Biaya:</span>
                                <span>Rp <?= number_format($main['biaya'], 0, ',', '.') ?></span>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <span>Kondisi Akhir:</span>
                                <span class="badge bg-green-lt"><?= $main['kondisi_akhir'] ?? '-' ?></span>
                            </div>

                            <?php if(!empty($main['pengerjaan_foto'])): ?>
                                <div class="mt-3 pt-2 border-top text-center">
                                    <small class="text-muted d-block mb-1">Bukti Foto After:</small>
                                    <a href="<?= 'http://localhost/Project_Magang_API/uploads/keluhan/' . $main['pengerjaan_foto'] ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-image me-1"></i> Lihat Foto Selesai
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if(!empty($main['tgl_berikutnya'])): ?>
                                <div class="mt-2 pt-2 border-top text-center">
                                    <small class="text-muted">Jadwal Berikutnya:</small><br>
                                    <strong class="text-primary"><?= date('d-m-Y', strtotime($main['tgl_berikutnya'])) ?></strong>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="text-danger"><i class="fas fa-ban fa-3x"></i></div>
                    <h3 class="mt-2">Laporan Ditolak</h3>
                    <p class="text-muted">Pengajuan perbaikan ini tidak disetujui.</p>
                <?php endif; ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Tutup</button>
            </div>

        <?php endif; ?>

    </div>
</form>

<script>
    $(document).ready(function() {
        // 1. Formatter Angka Ketat (Anti Huruf)
        $(document).on('input keyup paste', '.number-separator', function(e) {
            var inputVal = $(this).val();
            var cleanVal = inputVal.replace(/[^0-9]/g, ''); 
            if (cleanVal === "") { $(this).val(""); return; }
            var formattedVal = new Intl.NumberFormat('id-ID').format(cleanVal);
            $(this).val(formattedVal);
        });

        // 2. Logic Cek Jenis Aset (AC/Kendaraan)
        var namaAset = $('#hidden_nama_aset').val();
        var kodeAset = $('#hidden_kode_aset').val();
        
        var isAC = (namaAset.includes('AC ') || namaAset.includes('AIR CONDITIONER') || kodeAset == 'AC');
        var isKendaraan = (namaAset.includes('MOTOR') || namaAset.includes('MOBIL') || namaAset.includes('KENDARAAN') || kodeAset.includes('K2') || kodeAset.includes('K4'));

        // =================================================
        // LOGIKA STATUS 0 (PERENCANAAN) - INPUT DROPDOWN AC
        // =================================================
        if(isAC) {
            $('#row-ac-rencana').removeClass('d-none');
            $('#input_jenis_ac').prop('disabled', false); // Enable jika AC
        } else {
            $('#input_jenis_ac').prop('disabled', true);  // Disable jika bukan AC (Anti Bug Submit)
            $('#input_jenis_ac').val(''); // Reset value
        }

        // =================================================
        // LOGIKA STATUS 1 (REALISASI) - INFO TANGGAL NEXT
        // =================================================
        if(isAC || isKendaraan) {
            calcNextDate(); 
            setInterval(function() { calcNextDate(); }, 1000);
        }

        var lastTglVal = '';
        function calcNextDate() {
            var tglInput = $('#tgl_service').val();
            if(tglInput && tglInput.length == 10 && tglInput !== lastTglVal) {
                lastTglVal = tglInput; 
                var parts = tglInput.split('-'); 
                if (parts.length === 3) {
                    var d = new Date(parts[2], parts[1]-1, parts[0]); 
                    if(!isNaN(d.getTime())) {
                        d.setMonth(d.getMonth() + 3); 
                        var newDate = ('0' + d.getDate()).slice(-2) + '-' + ('0' + (d.getMonth()+1)).slice(-2) + '-' + d.getFullYear();
                        $('#info_next_service').removeClass('d-none');
                        $('#lbl_tgl_next').text(newDate);
                    }
                }
            }
        }
    });
</script>