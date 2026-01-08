<?php include('_js.php'); ?>

<div class="page-wrapper">
    <div class="page-header d-print-none mt-2">
        <div class="container-xl">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">Laporan Masalah</div>
                    <h2 class="page-title">Daftar Keluhan Aset</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body mt-2">
        <div class="container-xl">
            
            <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-<?= $this->session->flashdata('msg_type') ? $this->session->flashdata('msg_type') : 'info' ?> alert-dismissible" role="alert">
                <div class="d-flex">
                    <div><?= $this->session->flashdata('msg'); ?></div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped table-sm display nowrap" id="datatable-keluhan" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th>No. Tiket</th>
                                    <th class="text-center">Foto</th>
                                    <th>Aset & Kondisi</th>
                                    <th>Deskripsi Masalah</th>
                                    <th class="text-center">Status</th>
                                    <th>Waktu Lapor</th>
                                    <th width="10%" class="text-center">Aksi</th> </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Konfigurasi Path Foto (Sesuaikan jika perlu)
                                $api_folder_path = 'C:/laragon/www/Project_Magang_API/uploads/keluhan/';
                                $api_url_path = 'http://localhost/Project_Magang_API/uploads/keluhan/';

                                $no = 1;
                                if(!empty($keluhan)) :
                                foreach($keluhan as $row): 
                                    // Logika Gambar
                                    $nama_foto = $row->bukti_foto;
                                    $img_url = $api_url_path . $nama_foto;
                                    $file_exists = !empty($nama_foto) && file_exists($api_folder_path . $nama_foto);
                                    
                                    // Warna Badge Status
                                    $st = $row->tiket_status;
                                    $bg_st = 'secondary';
                                    if($st == 'BARU') $bg_st = 'red';
                                    if($st == 'DIPROSES') $bg_st = 'yellow';
                                    if($st == 'SELESAI') $bg_st = 'green';
                                    if($st == 'DITOLAK') $bg_st = 'dark';
                                    
                                    // Warna Badge Kondisi
                                    $kond = $row->asset_kondisi;
                                    $bg_kd = 'secondary';
                                    if($kond == 'BAIK') $bg_kd = 'success';
                                    if($kond == 'RUSAK') $bg_kd = 'danger';
                                    if($kond == 'PERBAIKAN') $bg_kd = 'warning';
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    
                                    <td>
                                        <span class="badge bg-blue-lt"><?= $row->tiket_no ?></span>
                                    </td>

                                    <td class="text-center">
                                        <?php if($file_exists): ?>
                                            <a href="<?= $img_url ?>" target="_blank" data-bs-toggle="tooltip" title="Lihat Foto">
                                                <img src="<?= $img_url ?>" class="avatar avatar-sm rounded" style="object-fit: cover; border: 1px solid #ddd;">
                                            </a>
                                        <?php else: ?>
                                            <span class="avatar avatar-sm rounded bg-secondary-lt text-muted" style="font-size: 9px;" title="File tidak ditemukan">No IMG</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="fw-bold text-dark"><?= $row->asset_nm ?></div>
                                        <div class="text-muted small"><?= $row->asset_kd ?></div>
                                        <div class="mt-1">
                                            <span class="badge bg-<?= $bg_kd ?>-lt"><?= $kond ?></span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="text-wrap" style="max-width: 300px;">
                                            <?= nl2br($row->keluhan_deskripsi) ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-<?= $bg_st ?> text-white"><?= $st ?></span>
                                    </td>

                                    <td>
                                        <div><?= date('d/m/Y', strtotime($row->created_at)) ?></div>
                                        <div class="text-muted small"><?= date('H:i', strtotime($row->created_at)) ?> WIB</div>
                                    </td>

                                    <td class="text-center">
                                        <?php if($st == 'BARU'): ?>
                                            <a href="<?= site_url('laporan/keluhan_aset/acc_tiket/'.$row->keluhan_id) ?>" 
                                               class="btn btn-outline-primary btn-sm btn-pill"
                                               onclick="return confirm('Proses tiket ini?')">
                                               <i class="fas fa-check me-1"></i> ACC
                                            </a>
                                        <?php elseif($st == 'DIPROSES'): ?>
                                            <a href="<?= site_url('laporan/keluhan_aset/selesaikan_tiket/'.$row->keluhan_id.'/'.$row->asset_id) ?>" 
                                               class="btn btn-success btn-sm btn-pill text-white"
                                               onclick="return confirm('Selesaikan perbaikan?')">
                                               <i class="fas fa-tools me-1"></i> Selesai
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small"><i class="fas fa-lock"></i> Locked</span>
                                        <?php endif; ?>
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