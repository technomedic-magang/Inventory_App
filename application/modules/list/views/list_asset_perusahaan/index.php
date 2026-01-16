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
            <?= $this->title ?? 'Data Seluruh Aset' ?>
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

                <div class="row mb-3">
                  <div class="col-md-4">
                      <label class="form-label">Filter Kategori Aset:</label>
                      <select id="main_filter_kategori" class="form-select">
                          <option value="">- Tampilkan Semua -</option>
                          <?php foreach($list_kategori as $kat): ?>
                              <option value="<?= $kat['kategori_id'] ?>"><?= $kat['kategori_nm'] ?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
              </div>

                <table class="table table-vcenter card-table table-striped table-sm text-nowrap" id="datatable-main" width="100%">
                  <thead>
                    <tr>
                      <th width=20>No</th>
                      <th width=40>Kode Aset</th>
                      <th>Kategori</th>
                      <th>Nama Barang & Spesifikasi</th>
                      <th>Lokasi / PJ</th>
                      <th class="text-center">Tahun</th>
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
  </div>
</div>