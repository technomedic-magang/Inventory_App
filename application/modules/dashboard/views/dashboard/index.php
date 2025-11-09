<div class="page-wrapper">
    <div class="page-header d-print-none mt-2">
        <div class="container-xl">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">Overview</div>
                    <h2 class="page-title">Dashboard Inventaris</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body mt-2">
        <div class="container-xl">
            
            <div class="row row-deck row-cards mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Jenis Asset</div>
                            </div>
                            <div class="h1 mb-3"><?= number_format($total_types) ?></div>
                            <div class="d-flex mb-2">
                                <div>Master Data Aktif</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Total Stok Fisik</div>
                            </div>
                            <div class="h1 mb-3 text-primary"><?= number_format($total_items) ?></div>
                            <div class="d-flex mb-2">
                                <div>Unit di Semua Gudang</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Sedang Dipinjam</div>
                            </div>
                            <div class="h1 mb-3 text-warning"><?= number_format($total_borrowed) ?></div>
                            <div class="d-flex mb-2">
                                <div>Unit Belum Kembali</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card <?= (count($low_stock) > 0) ? 'bg-danger-lt' : '' ?>">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Alert Stok Menipis</div>
                            </div>
                            <div class="h1 mb-3 text-danger"><?= count($low_stock) ?></div>
                            <div class="d-flex mb-2">
                                <div>Perlu Restock Segera</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cards">
                <div class="col-md-6">
                    <div class="card" style="min-height: 350px;">
                        <div class="card-header">
                            <h3 class="card-title text-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i> Stok Perlu Perhatian
                            </h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table table-striped">
                                <thead>
                                    <tr>
                                        <th>Asset</th>
                                        <th class="text-center">Min</th>
                                        <th class="text-center">Sisa</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($low_stock)): ?>
                                        <tr><td colspan="4" class="text-center text-muted py-4">Aman! Tidak ada stok menipis.</td></tr>
                                    <?php else: ?>
                                        <?php foreach($low_stock as $item): ?>
                                        <tr>
                                            <td><?= $item['asset_nm'] ?><div class="text-muted small"><?= $item['asset_kd'] ?></div></td>
                                            <td class="text-center"><?= number_format($item['stok_min_qty']) ?></td>
                                            <td class="text-center fw-bold text-danger"><?= number_format($item['total_current']) ?></td>
                                            <td><span class="badge bg-danger">Low</span></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card" style="min-height: 350px;">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-history me-2"></i> Aktivitas Masuk Terakhir
                            </h3>
                        </div>
                        <div class="table-responsive">
                             <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>No. Transaksi</th>
                                        <th>Gudang Tujuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($recent_trx)): ?>
                                        <tr><td colspan="3" class="text-center text-muted py-4">Belum ada transaksi masuk.</td></tr>
                                    <?php else: ?>
                                        <?php foreach($recent_trx as $trx): ?>
                                        <tr>
                                            <td><?= date('d M Y', strtotime($trx['transaksi_tgl'])) ?></td>
                                            <td>
                                                <span class="text-primary fw-bold"><?= $trx['transaksi_no'] ?></span>
                                            </td>
                                            <td><?= $trx['gudang_nm'] ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>