<div class="page-wrapper">
    <div class="page-header d-print-none mt-2">
        <div class="container-xl">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Laporan Perbaikan Asset</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="<?= site_url($this->uri) ?>">
                        <input type="hidden" name="n" value="<?= $this->input->get('n') ?>">
                        <input type="hidden" name="filter" value="1">

                        <div class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Dari Tanggal</label>
                                <input type="date" name="start" class="form-control" value="<?= $start_date ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sampai Tanggal</label>
                                <input type="date" name="end" class="form-control" value="<?= $end_date ?>" required>
                            </div>
                            <div class="col-md-auto">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i> Tampilkan
                                </button>
                                <?php if(!empty($list_data)): ?>
                                    <a href="<?= site_url($this->uri.'/cetak?n='._get('n').'&start='.$start_date.'&end='.$end_date) ?>" target="_blank" class="btn btn-default">
                                        <i class="fas fa-print me-1"></i> Cetak PDF
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter table-bordered card-table table-striped">
                        <thead>
                            <tr class="bg-light">
                                <th class="w-1">No</th>
                                <th style="width: 100px;">Tanggal</th>
                                <th>Nama Asset / Kendaraan</th>
                                <th>Rincian Perbaikan</th>
                                <th>Tempat Service</th>
                                <th>KM</th>
                                <th class="text-end">Biaya (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($list_data)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-search fa-2x mb-2"></i><br>
                                        Silakan pilih periode tanggal untuk menampilkan laporan.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php 
                                    $no = 1; 
                                    $total_biaya = 0;
                                    foreach($list_data as $row): 
                                        $total_biaya += $row['biaya'];
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['tgl_service'])) ?></td>
                                    <td>
                                        <div class="fw-bold"><?= $row['asset_nm'] ?></div>
                                        <div class="text-muted small"><?= $row['asset_kd'] ?></div>
                                    </td>
                                    <td><?= nl2br($row['keterangan_txt']) ?></td>
                                    <td><?= $row['bengkel_nm'] ?></td>
                                    <td><?= number_format($row['kilometer_saat_ini']) ?></td>
                                    <td class="text-end fw-bold"><?= number_format($row['biaya']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="bg-light fw-bold">
                                    <td colspan="6" class="text-end">TOTAL BIAYA PERBAIKAN</td>
                                    <td class="text-end text-primary"><?= number_format($total_biaya) ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>