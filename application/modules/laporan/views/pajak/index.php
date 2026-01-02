<?php include('_js.php') ?>

<div class="page-wrapper">
  <div class="page-header d-print-none mt-2">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col">
          <div class="page-pretitle">Laporan & Keuangan</div>
          <h2 class="page-title">Pembayaran Pajak Aset (STNK/KIR)</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <a href="javascript:void(0)" 
               onclick="_modal(event, {uri: '<?= site_url("laporan/pajak/form_modal") ?>', size: 'modal-lg'})" 
               class="btn btn-primary d-sm-inline-block">
                <i class="fas fa-plus me-1"></i> Input Pembayaran
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="page-wrapper">
    <div class="page-body mt-2">
      <div class="container-xl">
        <div class="card">
          <div class="card-body p-2">
            <div class="w-100">
              <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped table-sm text-nowrap" id="datatable-main" width="100%">
                  <thead>
                    <tr>
                      <th width="20">No</th>
                      <th width="40">Aksi</th>
                      <th>Kode Aset</th>
                      <th>No. Transaksi / Aset</th>
                      <th>Kategori</th>
                      <th>Plat No</th>
                      <th class="text-end">Jenis</th>
                      <th class="text-end">Tgl Bayar</th>
                      <th class="text-end">Berlaku Sampai</th>
                      <th class="text-end">Total Bayar</th>
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