<?php include('_js.php') ?>

<div class="page-wrapper">
  <div class="page-header d-print-none mt-2">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col">
<<<<<<< HEAD
          <div class="page-pretitle">
            <?= $this->nav['nav_nm'] ?? 'Transaksi' ?>
          </div>
          <h2 class="page-title">
            <?= $this->title ?? 'Mutasi Aset (Handover)' ?>
          </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <a href="javascript:void(0)" onclick="_modal(event, {uri: '<?= $this->uri . '/form_modal' ?>', size: 'modal-lg', position: 'normal'})" class="btn btn-primary d-sm-inline-block">
                <i class="fas fa-exchange-alt"></i> Buat Mutasi
=======
          <div class="page-pretitle">Formulir</div>
          <h2 class="page-title">Mutasi / Pindah Aset</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <a href="javascript:void(0)" 
               onclick="_modal(event, {uri: '<?= site_url("formulir/mutasi_asset/form_modal") ?>', size: 'modal-lg'})" 
               class="btn btn-primary d-sm-inline-block">
                <i class="fas fa-exchange-alt me-1"></i> Mutasi Baru
>>>>>>> repoB/main
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
<<<<<<< HEAD
                <table class="table table-vcenter card-table table-striped table-sm text-nowrap" id="datatable-main" width="100%">
                  <thead>
                    <tr>
                      <th width="20">No</th>
                      <th width="40">Aksi</th>
                      <th>Tgl Mutasi</th>
=======
                <table class="table table-vcenter card-table table-striped table-sm display nowrap" id="datatable-main" width="100%">
                  <thead>
                    <tr>
                      <th width="20" class="text-center">No</th>
                      <th width="40" class="text-center">Aksi</th>
                      <th class="text-center">Tgl Mutasi</th>
>>>>>>> repoB/main
                      <th>No. Dokumen</th>
                      <th>Dari Pegawai</th>
                      <th>Ke Pegawai</th>
                      <th>Keterangan</th>
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