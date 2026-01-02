<?php include('_js.php') ?>

<div class="page-wrapper">
  <div class="page-header d-print-none mt-2">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col">
          <div class="page-pretitle">Manajemen Aset</div>
          <h2 class="page-title">Riwayat Service & Perbaikan</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <a href="javascript:void(0)" 
               onclick="_modal(event, {uri: '<?= site_url($this->uri . '/form_modal') ?>', size: 'modal-lg', position: 'normal'})" 
               class="btn btn-primary d-sm-inline-block">
               <i class="fas fa-plus me-1"></i> Input Data
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
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Filter Kategori:</label>
                    <select id="main_filter_kategori" class="form-select">
                        <option value="">- Semua Kategori -</option>
                        <?php foreach($list_kategori as $kat): ?>
                            <option value="<?= $kat['kategori_id'] ?>"><?= $kat['kategori_nm'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="w-100">
              <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped table-sm display nowrap" id="datatable-main" width="100%">
                  <thead>
                    <tr>
                      <th width="20">No</th>
                      <th width="40">Aksi</th>
                      <th>Kode Aset</th>
                      <th>Nama Aset</th>
                      <th>Kategori</th>
                      <th>Tgl Service</th>
                      <th>Rincian / Keterangan</th>
                      <th>Nama Bengkel</th>
                      <th class="text-end">Biaya</th>
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