<div class="page-wrapper">
    <div class="page-header d-print-none mt-2">
        <div class="container-xl">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">Dashboard</div>
                    <h2 class="page-title">
                        Selamat Datang, <?= $pegawai['pegawai_nm'] ?? $this->session->userdata('user_nm') ?? 'User' ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body mt-3">
        <div class="container-xl">
            
            <div class="row row-deck row-cards mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Total Jenis Aset</div>
                            </div>
                            <div class="h1 mb-3"><?= number_format($total_types) ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Total Stok Fisik</div>
                            </div>
                            <div class="h1 mb-3 text-primary"><?= number_format($total_items) ?> Unit</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Sedang Dipakai</div>
                            </div>
                            <div class="h1 mb-3 text-warning"><?= number_format($total_borrowed) ?> Unit</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card <?= (count($low_stock) > 0) ? 'bg-danger-lt' : '' ?>">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Alert Stok Menipis</div>
                            </div>
                            <div class="h1 mb-3 text-danger"><?= count($low_stock) ?> Item</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cards">
                <div class="col-lg-6">
                    <div class="card" style="height: 28rem; overflow-y: auto;">
                        <div class="card-header sticky-top bg-white">
                            <h3 class="card-title text-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i> Stok Perlu Restock
                            </h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Asset</th>
                                        <th class="text-center">Min.</th>
                                        <th class="text-center">Sisa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($low_stock)): ?>
                                        <tr><td colspan="3" class="text-center text-muted py-5"> - Stok Aman - </td></tr>
                                    <?php else: ?>
                                        <?php foreach($low_stock as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="font-weight-medium"><?= $item['asset_nm'] ?></div>
                                                <div class="text-muted small"><?= $item['asset_kd'] ?></div>
                                            </td>
                                            <td class="text-center"><?= number_format($item['stok_min_qty']) ?></td>
                                            <td class="text-center"><span class="badge bg-danger"><?= number_format($item['total_current']) ?></span></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card" style="height: 28rem; overflow-y: auto;">
                        <div class="card-header sticky-top bg-white">
                            <h3 class="card-title">
                                <i class="fas fa-history me-2"></i> Aktivitas Terakhir
                            </h3>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable">
                            <?php if(empty($recent_trx)): ?>
                                <div class="text-center text-muted py-5">Belum ada aktivitas.</div>
                            <?php else: ?>
                                <?php foreach($recent_trx as $log): ?>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="badge bg-<?= $log['warna'] ?>"></span>
                                        </div>
                                        <div class="col text-truncate">
                                            <span class="text-reset d-block"><?= $log['tipe'] ?></span>
                                            <div class="d-block text-muted text-truncate mt-n1 small">
                                                Ref: <strong><?= $log['ref'] ?></strong>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <small class="text-muted"><?= date('d/m/y H:i', strtotime($log['tgl'])) ?></small>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>