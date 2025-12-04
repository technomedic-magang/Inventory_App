<?php include('_js.php') ?>

<div class="page-wrapper">
  <div class="page-header d-print-none mt-2">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <?= $this->nav['nav_nm'] ?? 'Logistik & Inventaris' ?>
          </div>
          <h2 class="page-title">
            <?= $this->title ?? 'Riwayat Persediaan Masuk' ?>
          </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <a href="javascript:void(0)" 
               onclick="_modal(event, {uri: '<?= site_url($this->uri . '/form_modal') ?>', size: 'modal-lg', position: 'normal'})" 
               class="btn btn-primary d-sm-inline-block">
                <i class="fas fa-plus me-1"></i> Tambah Stok (Belanja)
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
                <table class="table table-vcenter card-table table-striped table-sm display nowrap" id="datatable-main" width="100%">
                  <thead>
                    <tr>
                      <th width="20">No</th>
                      <th width="40">Aksi</th>
                      <th>Tanggal</th>
                      <th>No. Struk</th>
                      <th>Nama Barang</th>
                      <th>Kategori</th>
                      <th>Jumlah</th>
                      <th>Satuan</th>
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