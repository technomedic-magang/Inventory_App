<div class="modal-header">
    <h5 class="modal-title">Detail Keluhan & Verifikasi</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form id="form_keluhan" action="<?= $form_act ?>" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6 text-center">
                <label>Foto Keluhan</label>
                <div class="border p-2" style="background: #f4f6f9; min-height: 200px; display: flex; align-items: center; justify-content: center;">
                    <?php if (!empty($main['foto_keluhan'])): ?>
                        <img src="<?= $url_foto . $main['foto_keluhan'] ?>" class="img-fluid img-thumbnail" alt="Foto Keluhan" onerror="this.onerror=null; this.src=''; this.alt='Gagal memuat gambar (Cek URL API)';">
                    <?php else: ?>
                        <span class="text-muted">Tidak ada foto dilampirkan</span>
                    <?php endif; ?>
                </div>
                <small class="text-muted d-block mt-2">Sumber: <?= $url_foto ?></small>
            </div>

            <div class="col-md-6">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="30%"><strong>Tiket</strong></td>
                        <td>: <?= $main['no_tiket'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Pelapor</strong></td>
                        <td>: <?= $main['pegawai_nm'] ?? 'User/Tamu' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Aset</strong></td>
                        <td>: <?= $main['asset_nm'] ?> <br> <small>(<?= $main['asset_kd'] ?>)</small></td>
                    </tr>
                    <tr>
                        <td><strong>Waktu</strong></td>
                        <td>: <?= $main['created_at'] ?></td>
                    </tr>
                </table>

                <div class="form-group">
                    <label>Deskripsi Keluhan</label>
                    <textarea class="form-control" rows="3" readonly><?= $main['deskripsi'] ?></textarea>
                </div>

                <hr>
                
                <div class="form-group">
                    <label>Update Status <span class="text-danger">*</span></label>
                    <select name="status_tiket" class="form-control">
                        <option value="0" <?= ($main['status_tiket'] == 0) ? 'selected' : '' ?>>Baru (Menunggu)</option>
                        <option value="1" <?= ($main['status_tiket'] == 1) ? 'selected' : '' ?>>Sedang Diproses</option>
                        <option value="2" <?= ($main['status_tiket'] == 2) ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggapan Admin (Opsional)</label>
                    <textarea name="tanggapan_admin" class="form-control" rows="2" placeholder="Catatan perbaikan..."><?= $main['tanggapan_admin'] ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" id="btn_save">Simpan Perubahan</button>
    </div>
</form>

<script>
// Script Submit via AJAX (Sesuai kebiasaan project Anda)
$('#form_keluhan').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function() {
            $('#btn_save').attr('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        },
        success: function(res) {
            if (res.status) {
                // Tampilkan pesan sukses jika ada (tergantung helper _json/_response Anda)
                // alert('Berhasil!'); 
                $('#modal_form').modal('hide');
                $('#datatables_keluhan').DataTable().ajax.reload();
                
                // Jika ingin refresh halaman penuh seperti di contoh Perbaikan_aset:
                if(res.redirect) {
                     window.location.href = res.redirect;
                }
            } else {
                alert(res.msg || 'Gagal menyimpan data.');
            }
        },
        error: function() {
            alert('Terjadi kesalahan server.');
        },
        complete: function() {
            $('#btn_save').attr('disabled', false).html('Simpan Perubahan');
        }
    });
});
</script>