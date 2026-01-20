<?php include('_js.php') ?>

<div class="page-wrapper">
  <div class="page-header d-print-none mt-2">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col">
          <div class="page-pretitle">Keuangan & Aset</div>
          <h2 class="page-title"></i> Pajak Aset (STNK/PBB)</h2>
        </div>

        <div class="col-auto ms-auto d-print-none">
          <button class="btn btn-primary shadow-sm" 
             onclick="_modal(event, {uri: '<?= $this->uri . '/form_modal' ?>', size: 'modal-lg', title: 'Input Pembayaran Pajak'})"
             class="btn btn-primary d-sm-inline-block">
             <i class="fas fa-plus me-2"></i> Input Pembayaran
          </button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="page-body mt-3">
    <div class="container-xl">
        
        <div class="row row-cards mb-4">
            <div class="col-sm-6 col-lg-4">
                <div class="card card-sm border-1 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-blue text-white avatar avatar-md rounded">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="text-muted font-weight-medium">Total Bayar (<?= date('Y') ?>)</div>
                                <div class="display-6 fw-bold text-blue">
                                    Rp <?= number_format($summary['total_tahun'], 0, ',', '.') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="card card-sm border-1 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-red text-white avatar avatar-md rounded">
                                    <i class="fas fa-money-bill-wave"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="text-muted font-weight-medium">Total Bulan Ini</div>
                                <div class="display-6 fw-bold text-red">
                                    Rp <?= number_format($summary['total_bulan'], 0, ',', '.') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="card card-sm border-1 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-green text-white avatar avatar-md rounded">
                                    <i class="fas fa-receipt"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="text-muted font-weight-medium">Transaksi Bulan Ini</div>
                                <div class="display-6 fw-bold text-green">
                                    <?= number_format($summary['count_bulan'], 0, ',', '.') ?> Data
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-1 shadow-sm">
            <div class="card-body p-2">
                <div class="w-100">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped table-sm display nowrap" id="datatable-main" width="100%">
                            <thead>
                                <tr>
                                <th width="20" class="text-center text-muted">No</th>
                                <th width="40" class="text-center text-muted">Aksi</th>
                                <th class="text-muted">Kode Aset</th>
                                <th class="text-muted">Info Transaksi</th>
                                <th class="text-muted">Kategori</th>
                                <th class="text-muted">Identitas (Plat)</th>
                                <th class="text-end text-muted">Jenis</th>
                                <th class="text-end text-muted">Tgl Bayar</th>
                                <th class="text-end text-muted">Berlaku Sampai</th>
                                <th class="text-end text-muted">Total Bayar</th>
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