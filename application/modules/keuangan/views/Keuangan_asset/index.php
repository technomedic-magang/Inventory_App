<?php include('_js.php') ?>

<div class="page-wrapper">
  <div class="page-header d-print-none mt-2">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col">
          <div class="page-pretitle">Modul Keuangan</div>
          <h2 class="page-title">Nilai Kekayaan Aset</h2>
        </div>
        
        <div class="col-auto ms-auto d-print-none">
          <?php if(!$is_closed): ?>
             <button class="btn btn-warning" 
                onclick="_modal(event, {uri: '<?= site_url($this->uri_mod . "/form_modal_tutup_buku") ?>', size: 'modal-md', title: 'Konfirmasi Tutup Buku'})">
                <i class="fas fa-lock me-2"></i> Tutup Buku Periode <?= $periode_text ?>
             </button>
          <?php else: ?>
             <button class="btn btn-secondary" disabled>
                <i class="fas fa-check-circle me-2"></i> Periode <?= $periode_text ?> Ditutup
             </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  
  <div class="page-wrapper">
    <div class="page-body mt-2">
      <div class="container-xl">
        
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="text-muted">Total Nilai Perolehan</div>
                        <div class="display-6 fw-bold text-blue">Rp <?= number_format($summary['total_aset_awal'], 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="text-muted">Akumulasi Valuasi (+/-)</div>
                        <div class="display-6 fw-bold <?= ($summary['total_akumulasi'] < 0) ? 'text-red' : 'text-green' ?>">
                            Rp <?= number_format($summary['total_akumulasi'], 0, ',', '.') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-sm">
                    <div class="card-body bg-green-lt">
                        <div class="text-muted">Nilai Buku Bersih (Saat Ini)</div>
                        <div class="display-6 fw-bold text-green">Rp <?= number_format($summary['total_nilai_buku'], 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="w-100">
                    <div class="row mb-3">
                        <div class="col-md-4 col-sm-6">
                            <label class="form-label">Filter Kategori Aset:</label>
                            <select id="filter_kategori" class="form-select">
                                <option value="">-- Tampilkan Semua --</option>
                                <?php foreach($list_kategori as $kat): ?>
                                    <option value="<?= $kat['kategori_id'] ?>"><?= $kat['kategori_nm'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped table-sm display nowrap" id="datatable-main" width="100%">
                            <thead>
                                <tr>
                                    <th width="20">No</th>
                                    <th width="40" class="text-center">Aksi</th>
                                    <th>Kode Aset</th>
                                    <th>Tgl Beli</th>
                                    <th width="150">Umur Aset</th>
                                    <th class="text-end">Harga Beli</th>
                                    <th class="text-center">Metode</th>
                                    <th class="text-end">Nilai Buku</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody> 
                        </table>
                    </div>
                </div>
            </div>
        </div>

      </div>
    </div>
  </div>
</div>