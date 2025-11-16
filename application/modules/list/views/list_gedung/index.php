<?php include('_js.php') ?>

<div class="page-wrapper">
  <div class="page-header d-print-none mt-2">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <?= $this->nav['nav_nm'] ?? 'Monitoring' ?>
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
            <div class="w-100">
              <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped table-sm display nowrap" id="datatable-main">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Kode Barang</th>
                      <th>Kategori</th>
                      <th>Nama Barang</th>
                      <th class="text-left">Tgl Beli</th>
                      <th>Alamat</th>
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
  </div>
</div>