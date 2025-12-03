<?php include('_js_magang.php') ?>
<div class="page-wrapper">
  <div class="page-body mt-3">
    <div class="container-xl">
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <div class="row gy-3">
                <div class="col-12 col-sm-auto d-flex justify-content-center">
                  <img src="<?= base_url() ?>assets/ilustrasi/undraw_friendship_chd3.png" width="250">
                </div>
                <div class="col-12 col-sm d-flex flex-column">
                  <h2 class="h2 mb-0">Selamat datang</h2>
                  <h2 class="h2 mb-0"><?= $magang['magang_nm'] ?></h2>
                  <p><?= $magang['sekolah_nm'] ?></p>
                  <div class="row g-5 mt-auto">
                    <div class="col-auto">
                      <div class="subheader">Presensi Masuk</div>
                      <div class="d-flex align-items-baseline">
                        <?php if (@$kehadiran['masuk_st'] == 1): ?>
                          <div class="h3 me-2"><?= date('d-m-Y H:i:s', strtotime($kehadiran['masuk_jam_magang'])) ?></div>
                        <?php else: ?>
                          <div class="h3 me-2 text-disabled">Kamu belum masuk <i class="far fa-sad-tear"></i> </div>
                        <?php endif; ?>
                      </div>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: 100%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" aria-label="75% Complete">
                          <span class="visually-hidden">100% Complete</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <div class="subheader">Presensi Keluar</div>
                      <div class="d-flex align-items-baseline">
                        <?php if (@$kehadiran['keluar_st'] == 1): ?>
                          <div class="h3 me-2"><?= date('d-m-Y H:i:s', strtotime($kehadiran['keluar_jam_magang'])) ?></div>
                        <?php else: ?>
                          <div class="h3 me-2">Kamu belum keluar <i class="far fa-sad-tear"></i> </div>
                        <?php endif; ?>
                      </div>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: 100%" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" aria-label="78% Complete">
                          <span class="visually-hidden">100% Complete</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h6 class="card-title"><i class="fas fa-calendar-alt me-2"></i>Riwayat Kegiatan</h6>
            </div>
            <div class="card-body p-2">
              <?= $calendar ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>