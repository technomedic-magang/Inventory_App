<?php $this->load->view('dashboard/_js'); ?>

<style>
    .dash-card { border: none; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); background: #fff; transition: .3s; }
    .dash-card:hover { transform: translateY(-3px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    
    .icon-box { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
    .bg-blue-light { background: #e8f1ff; color: #0054a6; }
    .bg-green-light { background: #e6fffa; color: #0ca678; }
    .bg-red-light { background: #ffe3e3; color: #d63939; }
    .bg-purple-light { background: #f3e5f5; color: #ae3ec9; }

    .table-vcenter td { vertical-align: middle; }
    .avatar-text { width: 32px; height: 32px; line-height: 32px; text-align: center; background: #f1f5f9; border-radius: 50%; font-weight: bold; font-size: 12px; color: #64748b; }
</style>

<div class="page-wrapper">
    <div class="page-header d-print-none mt-2">
        <div class="container-xl">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">Overview</div>
                    <h2 class="page-title">Dashboard & Monitoring</h2>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <a href="#" class="btn btn-white d-none d-sm-inline-block">
                            <i class="far fa-calendar-alt me-2"></i> <?= date('d F Y') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            
            <div class="row row-cards mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card dash-card p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-blue-light me-3"><i class="fas fa-laptop"></i></div>
                            <div>
                                <div class="text-muted font-weight-medium">Total Aset</div>
                                <div class="h2 mb-0"><?= number_format($stats['total_asset'] ?? 0) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card dash-card p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-red-light me-3"><i class="fas fa-tools"></i></div>
                            <div>
                                <div class="text-muted font-weight-medium">Aset Rusak</div>
                                <div class="h2 mb-0 text-danger"><?= number_format($stats['asset_trouble'] ?? 0) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card dash-card p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-green-light me-3"><i class="fas fa-boxes"></i></div>
                            <div>
                                <div class="text-muted font-weight-medium">Jenis Barang</div>
                                <div class="h2 mb-0"><?= number_format($stats['total_persediaan'] ?? 0) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card dash-card p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-purple-light me-3"><i class="fas fa-layer-group"></i></div>
                            <div>
                                <div class="text-muted font-weight-medium">Total Stok Fisik</div>
                                <div class="h2 mb-0"><?= number_format($stats['stok_fisik'] ?? 0) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cards mb-4">
                <div class="col-lg-8">
                    <div class="card dash-card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Tren Keluar Masuk Barang (6 Bulan)</h3>
                        </div>
                        <div class="card-body">
                            <div id="chart-mentions" class="chart-lg"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card dash-card h-100">
                        <div class="card-header border-0">
                            <h3 class="card-title text-warning"><i class="fas fa-crown me-2"></i> Barang Paling Laris</h3>
                        </div>
                        <div class="list-group list-group-flush">
                            <?php if(empty($top_barang)): ?>
                                <div class="text-center py-4 text-muted">Belum ada data keluar</div>
                            <?php else: ?>
                                <?php foreach($top_barang as $tb): ?>
                                <div class="list-group-item border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="font-weight-medium text-dark"><?= $tb['barang_nm'] ?></div>
                                            <div class="small text-muted"><?= $tb['barang_kd'] ?></div>
                                        </div>
                                        <span class="badge bg-azure-lt"><?= number_format($tb['total_keluar']) ?> <?= $tb['satuan_nm'] ?></span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cards">
                
                <div class="col-lg-8">
                    <div class="card dash-card">
                        <div class="card-header border-0">
                            <h3 class="card-title"><i class="fas fa-history me-2"></i> Riwayat Aktivitas Terakhir</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tipe</th>
                                        <th>Tanggal</th>
                                        <th>Ref/Struk</th>
                                        <th>Info/Penerima</th>
                                        <th class="text-end">Total Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($riwayat)): ?>
                                        <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada aktivitas</td></tr>
                                    <?php else: ?>
                                        <?php foreach($riwayat as $rw): 
                                            $bg = ($rw['tipe'] == 'MASUK') ? 'bg-green-lt' : 'bg-red-lt';
                                            $icon = ($rw['tipe'] == 'MASUK') ? 'fa-arrow-down' : 'fa-arrow-up';
                                        ?>
                                        <tr>
                                            <td>
                                                <span class="badge <?= $bg ?> w-100">
                                                    <i class="fas <?= $icon ?> me-1"></i> <?= $rw['tipe'] ?>
                                                </span>
                                            </td>
                                            <td class="text-muted">
                                                <?= date('d M H:i', strtotime($rw['created_at'])) ?>
                                            </td>
                                            <td>
                                                <div class="font-weight-medium"><?= $rw['ref'] ?></div>
                                            </td>
                                            <td class="text-muted small">
                                                <?= $rw['info'] ?: '-' ?>
                                            </td>
                                            <td class="text-end font-weight-bold">
                                                <?= number_format($rw['qty']) ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card dash-card">
                        <div class="card-header border-0">
                            <h3 class="card-title text-danger"><i class="fas fa-battery-quarter me-2"></i> Stok Menipis</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th class="text-end">Sisa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($low_stock)): ?>
                                        <tr><td colspan="2" class="text-center py-4 text-success"><i class="fas fa-check-circle"></i> Stok Aman</td></tr>
                                    <?php else: ?>
                                        <?php foreach($low_stock as $ls): ?>
                                        <tr>
                                            <td>
                                                <div class="text-truncate" style="max-width: 150px;" title="<?= $ls['barang_nm'] ?>">
                                                    <?= $ls['barang_nm'] ?>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <span class="badge bg-danger-lt"><?= number_format($ls['stok_qty']) ?> <?= $ls['satuan_nm'] ?></span>
                                            </td>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Data dari Controller
        var labels = <?= json_encode($chart_data['labels'] ?? []) ?>;
        var dataIn = <?= json_encode($chart_data['masuk'] ?? []) ?>;
        var dataOut = <?= json_encode($chart_data['keluar'] ?? []) ?>;

        if(window.ApexCharts) {
            var options = {
                chart: {
                    type: 'area',
                    height: 300,
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                series: [{
                    name: 'Barang Masuk',
                    data: dataIn
                }, {
                    name: 'Barang Keluar',
                    data: dataOut
                }],
                dataLabels: { enabled: false },
                stroke: { width: 2, curve: 'smooth' },
                colors: ['#2fb344', '#d63939'], // Hijau (Masuk), Merah (Keluar)
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.05, stops: [0, 100] }
                },
                xaxis: { categories: labels },
                tooltip: { theme: 'light' },
                grid: { strokeDashArray: 4 }
            };

            var chart = new ApexCharts(document.querySelector("#chart-mentions"), options);
            chart.render();
        }
    });
</script>