<?php include('_js.php') ?>

<div class="page-wrapper">
  <div class="page-header d-print-none mt-2">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col">
<<<<<<< HEAD
          <div class="page-pretitle">
            <?= $this->nav['nav_nm'] ?? 'Formulir' ?>
          </div>
          <h2 class="page-title">
            <?= $this->title ?? 'Penggunaan Aset' ?>
          </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <a href="javascript:void(0)" onclick="_modal(event, {uri: '<?= $this->uri . '/form_modal' ?>', size: 'modal-lg', position: 'normal'})" class="btn btn-primary d-sm-inline-block">
                <i class="fas fa-plus"></i> Buat Form Penggunaan
=======
          <div class="page-pretitle">Formulir</div>
          <h2 class="page-title">Peminjaman Barang & Aset</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <a href="javascript:void(0)" 
               onclick="_modal(event, {uri: '<?= site_url($this->uri . '/form_modal') ?>', size: 'modal-lg', position: 'normal'})" 
               class="btn btn-primary d-sm-inline-block">
                <i class="fas fa-plus me-1"></i> Input Peminjaman
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
                      <th width="10">No</th>
                      <th width="40">Aksi</th>
                      <th>Tgl Pakai</th>
                      <th>No. Penggunaan</th>
                      <th>Pengguna (Pegawai)</th>
                      <th>Deadline</th>
                      <th>Status</th>
=======
                <table class="table table-vcenter card-table table-striped table-sm display nowrap" id="datatable-main" width="100%">
                  <thead>
                    <tr>
                      <th width="20" class="text-center">No</th>
                      <th width="40" class="text-center">Aksi</th>
                      <th class="text-center">Tgl Pinjam</th>
                      <th>No. Transaksi</th>
                      <th>Peminjam</th>
                      <th class="text-center">Rencana Kembali</th>
                      <th class="text-center">Status</th>
>>>>>>> repoB/main
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