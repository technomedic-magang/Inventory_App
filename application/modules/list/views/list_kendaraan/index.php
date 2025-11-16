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
            <?= $this->title ?? 'Daftar Kendaraan' ?>
          </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
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
                      <th class="text-center">No</th>
                      <th>Kode Aset</th>
                      <th>Kategori</th>
                      <th>Nama Kendaraan</th>
                      <th>Merek</th>
                      <th>Seri</th>
                      <th>Warna</th>
                      <th class="text-primary">No. Polisi</th>
                      <th class="text-left">Tahun</th>
                      <th class="text-center">Kondisi</th>
                      <th>Service Terakhir</th>
                      <th>Pajak</th>
                      <th>Nama BPKB</th>
                      <th>Penanggungjawab</th>
                      <th>Jabatan</th>
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