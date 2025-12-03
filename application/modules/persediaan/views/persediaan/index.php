<div class="page-wrapper">
    <div class="page-header d-print-none mt-2">
        <div class="container-xl">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">Output Data</div>
                    <h2 class="page-title">Pusat Laporan</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header"><h3 class="card-title">Laporan Posisi Stok</h3></div>
                        <div class="card-body">
                            <div id="form-laporan-stok">
                                <div class="mb-3">
                                    <label class="form-label">Gudang (Opsional)</label>
                                    <select name="gudang_id" id="filter_gudang_id" class="form-select">
                                        <option value="">- Pilih Gudang -</option>
                                        <?php foreach($list_gudang as $gdg): ?>
                                            <option value="<?= $gdg['gudang_id'] ?>"><?= $gdg['gudang_nm'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kategori (Opsional)</label>
                                    <select name="kategori_id" id="filter_kategori_id" class="form-select">
                                        <option value="">- Pilih Kategori -</option>
                                        <?php foreach($list_kategori as $kat): ?>
                                            <option value="<?= $kat['kategori_id'] ?>"><?= $kat['kategori_nm'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary w-100" onclick="tampilkanLaporan()">
                                    <i class="fas fa-eye me-2"></i> Tampilkan Preview
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function tampilkanLaporan() {
    var gudang = $('#filter_gudang_id').val();
    var kategori = $('#filter_kategori_id').val();

    if (gudang === '' && kategori === '') {
        alert('Silakan pilih minimal salah satu filter (gudang atau kategori).');
        return;
    }

    var data_filter = {
        gudang_id: gudang,
        kategori_id: kategori,
        n: '<?= _get('n') ?>'
    };

    var target_url = '<?= site_url('laporan/preview_stok') ?>';

    _modal(event, {
        uri: target_url,
        data: data_filter,
        size: 'modal-xl',
        position: 'normal'
    });
    }

</script>