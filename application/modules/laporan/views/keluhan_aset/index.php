<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-<?= $this->session->flashdata('msg_type') ? $this->session->flashdata('msg_type') : 'info' ?> alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('msg'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-tools me-2"></i> Daftar Keluhan Aset</h5>
        </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th>No Tiket</th>
                        <th class="text-center">Foto Bukti</th>
                        <th>Aset & Kondisi</th>
                        <th>Deskripsi Masalah</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if(!empty($keluhan)):
                    foreach($keluhan as $row): 
                        // --- Logika Path Foto ---
                        // Pastikan folder uploads ada di root public
                        $img_path = 'uploads/keluhan/' . $row->bukti_foto;
                        $img_url  = base_url($img_path);
                        
                        // Cek file fisik (FCPATH = root folder project)
                        $file_exists = !empty($row->bukti_foto) && file_exists(FCPATH . $img_path);
                        
                        // Warna Badge Status
                        $badge_color = 'bg-secondary';
                        if($row->tiket_status == 'BARU') $badge_color = 'bg-primary';
                        if($row->tiket_status == 'DIPROSES') $badge_color = 'bg-warning text-dark';
                        if($row->tiket_status == 'SELESAI') $badge_color = 'bg-success';
                        if($row->tiket_status == 'DITOLAK') $badge_color = 'bg-danger';

                        // Warna Badge Kondisi
                        $kondisi_color = 'bg-secondary';
                        if($row->asset_kondisi == 'BAIK') $kondisi_color = 'bg-success';
                        if($row->asset_kondisi == 'RUSAK') $kondisi_color = 'bg-danger';
                        if($row->asset_kondisi == 'PERBAIKAN') $kondisi_color = 'bg-warning text-dark';
                    ?>
                    <tr>
                        <td class="text-center text-muted"><?= $no++ ?></td>
                        <td class="fw-bold text-danger" style="font-family: monospace;"><?= $row->tiket_no ?></td>
                        
                        <td class="text-center">
                            <?php if($file_exists): ?>
                                <a href="<?= $img_url ?>" target="_blank">
                                    <img src="<?= $img_url ?>" alt="Bukti" class="shadow-sm" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #dee2e6;">
                                </a>
                            <?php else: ?>
                                <div class="bg-light text-muted border rounded d-flex align-items-center justify-content-center mx-auto" style="width:60px; height:60px; font-size: 0.7em;">
                                    No IMG
                                </div>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="fw-bold text-dark"><?= $row->asset_nm ?></div>
                            <div class="text-muted small"><?= $row->asset_kd ?></div>
                            <span class="badge <?= $kondisi_color ?> rounded-pill mt-1" style="font-size: 0.65em;">
                                <?= $row->asset_kondisi ?>
                            </span>
                        </td>

                        <td>
                            <div class="text-secondary small text-break" style="max-width: 250px;">
                                <?= nl2br($row->keluhan_deskripsi) ?>
                            </div>
                        </td>
                        
                        <td class="text-center">
                            <span class="badge <?= $badge_color ?> px-2 py-1"><?= $row->tiket_status ?></span>
                        </td>

                        <td class="text-center">
                            <div class="d-grid gap-1">
                                <?php if($row->tiket_status == 'BARU'): ?>
                                    <a href="<?= site_url('laporan/keluhan_aset/acc_tiket/'.$row->keluhan_id) ?>" 
                                       class="btn btn-sm btn-outline-primary"
                                       onclick="return confirm('Proses tiket ini?')">
                                       <i class="bi bi-check-lg"></i> ACC
                                    </a>
                                
                                <?php elseif($row->tiket_status == 'DIPROSES'): ?>
                                    <a href="<?= site_url('laporan/keluhan_aset/selesaikan_tiket/'.$row->keluhan_id.'/'.$row->asset_id) ?>" 
                                       class="btn btn-sm btn-success text-white"
                                       onclick="return confirm('Selesaikan perbaikan?')">
                                       <i class="bi bi-check-circle-fill"></i> Selesai
                                    </a>
                                
                                <?php else: ?>
                                    <span class="text-muted small"><i class="bi bi-lock-fill"></i> Locked</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data keluhan aset.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>