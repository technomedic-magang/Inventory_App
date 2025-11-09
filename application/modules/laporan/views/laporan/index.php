<div class="page-wrapper">
    <div class="page-header d-print-none mt-2">
        <div class="container-xl">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">Output Data</div>
                    <h2 class="page-title">Pusat Laporan Inventaris</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row row-cards">
                
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-boxes me-2"></i> Laporan Posisi Stok
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Melihat sisa stok fisik di setiap gudang saat ini.</p>
                            <form action="<?= base_url('laporan/cetak_stok') ?>" method="GET" target="_blank">
                                <div class="mb-3">
                                    <label class="form-label">Pilih Gudang (Opsional)</label>
                                    <select name="gudang_id" class="form-select">
                                        <option value="">- Semua Gudang -</option>
                                        <?php foreach($list_gudang as $gdg): ?>
                                            <option value="<?= $gdg['gudang_id'] ?>"><?= $gdg['gudang_nm'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pilih Kategori (Opsional)</label>
                                    <select name="kategori_id" class="form-select">
                                        <option value="">- Semua Kategori -</option>
                                        <?php foreach($list_kategori as $kat): ?>
                                            <option value="<?= $kat['kategori_id'] ?>"><?= $kat['kategori_nm'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-print me-2"></i> Cetak Laporan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                </div>
        </div>
    </div>
</div>