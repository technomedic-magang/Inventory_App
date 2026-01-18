<div class="modal-body">
    
    <div class="row align-items-center mb-3">
        <div class="col-auto">
            <span class="avatar avatar-lg rounded bg-blue-lt">
                <i class="fas fa-cube" style="font-size: 1.5rem;"></i>
            </span>
        </div>
        <div class="col">
            <div class="text-muted text-uppercase small font-weight-bold">
                <?= isset($main['kategori_nm']) ? $main['kategori_nm'] : '-' ?>
            </div>
            <h2 class="mb-0 text-primary"><?= $main['asset_nm'] ?></h2>
            <div class="text-muted small">
                Kode: <strong><?= $main['asset_kd'] ?></strong> &bull; 
                Satuan: <?= isset($main['satuan_nm']) ? $main['satuan_nm'] : '-' ?>
            </div>
        </div>
        <div class="col-auto">
            <?php 
                $status_bg = ($main['status_susut'] == 'HABIS') ? 'bg-purple' : 'bg-green';
                $status_txt = ($main['status_susut'] == 'HABIS') ? 'Habis Susut' : 'Aktif';
            ?>
            <span class="badge <?= $status_bg ?> p-2"><?= $status_txt ?></span>
        </div>
    </div>

    <div class="border-dotted my-3"></div>

    <div class="row row-cards mb-3">
        <div class="col-md-6">
            <div class="card card-sm border-blue-lt">
                <div class="card-body">
                    <div class="text-muted small text-uppercase">Harga Perolehan</div>
                    <div class="h3 mb-0 text-blue">
                        Rp <?= number_format($main['harga_beli'], 0, ',', '.') ?>
                    </div>
                    <div class="text-muted small mt-1">
                        <i class="fas fa-calendar-alt me-1"></i> 
                        Tgl Beli: <?= date('d-m-Y', strtotime($main['beli_tgl'])) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-sm border-green-lt">
                <div class="card-body">
                    <div class="text-muted small text-uppercase">Nilai Buku (Saat Ini)</div>
                    <div class="h3 mb-0 text-green">
                        Rp <?= number_format($main['nilai_buku_akhir'], 0, ',', '.') ?>
                    </div>
                    <div class="text-muted small mt-1">
                        Penyusutan Bln Ini: Rp <?= number_format($main['depresiasi_bulan_ini'], 0, ',', '.') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-2 text-muted">Statistik Penyusutan</h4>
    <div class="card bg-light border-0">
        <div class="card-body">
            
            <div class="row mb-2">
                <div class="col-6">
                    <small class="text-muted">Metode</small>
                    <div class="fw-bold"><?= $main['depresiasi_metode'] ?></div>
                </div>
                <div class="col-6 text-end">
                    <small class="text-muted">Nilai Residu</small>
                    <div class="fw-bold">Rp <?= number_format($main['residu_nominal'], 0, ',', '.') ?></div>
                </div>
            </div>

            <?php 
                $total_bulan = (int)$main['pakai_masa_bln'];
                $pakai_bulan = (int)$main['umur_bulan'];
                $persen = ($total_bulan > 0) ? round(($pakai_bulan / $total_bulan) * 100) : 0;
                if($persen > 100) $persen = 100;
            ?>
            <div class="mb-2">
                <div class="d-flex justify-content-between small mb-1">
                    <span>Masa Manfaat (<?= $pakai_bulan ?> / <?= $total_bulan ?> Bulan)</span>
                    <span class="fw-bold"><?= $persen ?>%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-primary" style="width: <?= $persen ?>%"></div>
                </div>
            </div>

            <?php 
                $nilai_awal = (float)$main['harga_beli'];
                $nilai_sisa = (float)$main['nilai_buku_akhir'];
                $persen_nilai = ($nilai_awal > 0) ? round(($nilai_sisa / $nilai_awal) * 100) : 0;
            ?>
            <div>
                <div class="d-flex justify-content-between small mb-1">
                    <span>Sisa Nilai Aset</span>
                    <span class="fw-bold"><?= $persen_nilai ?>%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-success" style="width: <?= $persen_nilai ?>%"></div>
                </div>
            </div>

        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Tutup</button>
</div>