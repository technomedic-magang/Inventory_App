<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
    <div class="modal-body">
        
        <h4 class="text-primary mb-3">Input Data Perbaikan</h4>

        <div class="mb-3">
            <label class="form-label required">Pilih Aset</label>
            <select name="asset_id" id="asset_id" class="form-select select2-modal" required onchange="cekJenisAset()">
                <option value="">- Cari Nama / Kode Aset -</option>
                <?php foreach ($list_asset as $k): ?>
                    <option value="<?= $k['asset_id'] ?>" 
                            data-kat="<?= $k['kategori_kd'] ?>"
                            <?= (@$main['asset_id'] == $k['asset_id']) ? 'selected' : '' ?>>
                        [<?= $k['asset_kd'] ?>] <?= $k['asset_nm'] ?> (<?= $k['kategori_nm'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label required">Tanggal Perbaikan</label>
                <input type="date" id="tgl_service" name="tgl_service" class="form-control" value="<?= @$main['tgl_service'] ?? date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-6 mb-3 d-none" id="box-km">
                <label class="form-label">KM Saat Ini (Khusus Kendaraan)</label>
                <input type="text" id="kilometer_saat_ini" name="kilometer_saat_ini" class="form-control number-separator" placeholder="0" value="<?= @$main['kilometer_saat_ini'] ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Tempat Service / Vendor</label>
            <input type="text" name="bengkel_nm" class="form-control" placeholder="Contoh: Toko Komputer Jaya / Bengkel Resmi" value="<?= @$main['bengkel_nm'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label required">Rincian Kerusakan & Perbaikan</label>
            <textarea name="keterangan_txt" class="form-control" rows="3" required placeholder="Contoh: Ganti LCD Laptop, Install Ulang Windows, Ganti Oli..."><?= @$main['keterangan_txt'] ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Biaya Perbaikan (Rp)</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="text" name="biaya" class="form-control number-separator text-end" placeholder="0" value="<?= @$main['biaya'] ?>">
            </div>
        </div>

    </div>
    <div class="modal-footer bg-light justify-content-end">
        <button type="button" class="btn btn-default me-2" data-bs-dismiss="modal"><?= _icon('cancel') ?> Batal</button>
        <button type="submit" class="btn btn-primary" onclick="_save(event)"><?= _icon('save') ?> Simpan Data</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('.select2-modal').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#form').closest('.modal'),
            width: '100%'
        });

        $('.number-separator').on('input', function() {
            var value = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(new Intl.NumberFormat('id-ID').format(value));
        });
        
        // Cek saat edit data
        setTimeout(cekJenisAset, 100);
    });

    function cekJenisAset() {
        var $sel = $('#asset_id').find(':selected');
        var katKode = $sel.data('kat'); // Kode Kategori (K2, K4, LP, dll)
        
        // Asumsi kode kendaraan adalah K2 atau K4
        if(katKode == 'K2' || katKode == 'K4') {
            $('#box-km').removeClass('d-none');
        } else {
            $('#box-km').addClass('d-none');
            $('#kilometer_saat_ini').val('');
        }
    }
</script>