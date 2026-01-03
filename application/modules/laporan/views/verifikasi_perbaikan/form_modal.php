<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="card-body">
        
        <div class="alert alert-info bg-azure-lt">
            <div class="d-flex justify-content-between">
                <div>
                    <strong><?= $detail['asset_nm'] ?></strong> <br> 
                    <small><?= $detail['asset_kd'] ?></small>
                </div>
                <div class="text-end">
                    Pelapor: <strong><?= $detail['pegawai_nm'] ?></strong><br>
                    <small>Tgl: <?= date('d-m-Y', strtotime($main['created_at'])) ?></small>
                </div>
            </div>
            <div class="mt-2 border-top pt-2">
                <strong>Keluhan:</strong> <?= $main['keluhan_deskripsi'] ?>
            </div>
        </div>

        <input type="hidden" name="aksi_admin" id="aksi_admin" value="">

        <?php if($main['status_tiket'] == 0): // STATUS BARU / PENDING ?>
            
            <div class="text-center py-2">
                <h4 class="text-warning">Status: Menunggu Verifikasi</h4>
                <p class="text-muted">Silakan tentukan rencana perbaikan atau tolak laporan ini.</p>
            </div>

            <div class="mb-3 row">
                <label class="col-3 col-form-label required">Tgl Rencana</label>
                <div class="col-9">
                    <input type="text" name="tgl_rencana" class="form-control datepicker-notauto" 
                           placeholder="dd-mm-yyyy" value="<?= date('d-m-Y', strtotime('+1 day')) ?>">
                    <small class="text-muted">Kapan perbaikan akan dimulai?</small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="$('#aksi_admin').val('approve'); _save(event)">
                    <i class="fas fa-check me-1"></i> Setujui & Proses
                </button>
                <button type="submit" class="btn btn-danger" onclick="$('#aksi_admin').val('reject'); _save(event)">
                    <i class="fas fa-times me-1"></i> Tolak Laporan
                </button>
            </div>

        <?php elseif($main['status_tiket'] == 1): // STATUS PROSES ?>

            <div class="text-center py-2">
                <h4 class="text-blue">Status: Sedang Dalam Proses</h4>
                <p class="text-muted">Aset saat ini berstatus <strong>PERBAIKAN</strong>. Isi data di bawah untuk menyelesaikan.</p>
            </div>

            <div class="mb-2 row">
                <label class="col-3 col-form-label required">Tgl Selesai</label>
                <div class="col-9">
                    <input type="text" name="tgl_service" class="form-control datepicker-notauto" 
                           placeholder="dd-mm-yyyy" value="<?= date('d-m-Y') ?>" required>
                </div>
            </div>

            <div class="mb-2 row">
                <label class="col-3 col-form-label">Bengkel / Vendor</label>
                <div class="col-9">
                    <input type="text" name="bengkel_nm" class="form-control" placeholder="Nama Tempat Service">
                </div>
            </div>

            <div class="mb-2 row">
                <label class="col-3 col-form-label">Biaya (Rp)</label>
                <div class="col-9">
                    <input type="text" name="biaya" class="form-control number-separator" placeholder="0">
                </div>
            </div>

            <div class="mb-2 row">
                <label class="col-3 col-form-label required fw-bold">Kondisi Akhir</label>
                <div class="col-9">
                    <select name="kondisi_akhir" class="form-select" required>
                        <option value="">- Pilih Kondisi Aset Setelah Service -</option>
                        <option value="BAIK">BAIK (Normal Kembali)</option>
                        <option value="RUSAK RINGAN">RUSAK RINGAN (Masih ada kendala)</option>
                        <option value="RUSAK BERAT">RUSAK BERAT (Gagal Service / Tidak Layak)</option>
                    </select>
                    <small class="text-muted">*Status aset di Master Aset akan diupdate sesuai pilihan ini.</small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="$('#aksi_admin').val('finish'); _save(event)">
                    <i class="fas fa-save me-1"></i> Simpan Penyelesaian
                </button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
            </div>

        <?php else: // STATUS SELESAI (2) ATAU DITOLAK (9) ?>
            
            <div class="text-center py-4">
                <?php if($main['status_tiket'] == 2): ?>
                    <div class="display-6 text-success"><i class="fas fa-check-circle"></i></div>
                    <h3 class="mt-2">Laporan Selesai</h3>
                    <p>Perbaikan selesai pada tgl: <strong><?= date('d-m-Y', strtotime($main['tgl_service'])) ?></strong></p>
                <?php else: ?>
                    <div class="display-6 text-danger"><i class="fas fa-ban"></i></div>
                    <h3 class="mt-2">Laporan Ditolak</h3>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w-100" data-bs-dismiss="modal">Tutup</button>
            </div>

        <?php endif; ?>

    </div>
</form>

<script>
    $(document).ready(function() {
        // Formatter Angka
        $(document).on('input', '.number-separator', function() {
            var value = $(this).val().replace(/[^0-9]/g, '');
            if(value) $(this).val(new Intl.NumberFormat('id-ID').format(value));
        });
    });
</script>