<?php include('_js.php') ?>

<div class="page-wrapper">
  <div class="page-header d-print-none mt-2">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <?= $this->nav['nav_nm'] ?? 'Monitoring Aset' ?>
          </div>
          <h2 class="page-title">
            <?= $this->title ?? 'Daftar Gedung & Bangunan' ?>
          </h2>
        </div>
      </div>
    </div>
  </div>
  
  <div class="page-wrapper">
    <div class="page-body mt-2">
      <div class="container-xl">
        <div class="card">
          <div class="card-body p-2">
            <div class="table-responsive">
              <table class="table table-vcenter card-table table-striped table-sm display nowrap" id="datatable-main" width="100%">
                <thead>
                <tr>
                  <th width="20">No</th>
                  <th width="40">Aksi</th>
                  <th>Kode Aset</th>
                  <th>Kategori</th>
                  <th>Nama Gedung</th>
                  <th>Alamat / Lokasi</th>
                  <th class="text-center">Tanggal</th>
                  <th class="text-center">Kondisi</th>
                  <th class="text-center">QR Code</th>
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