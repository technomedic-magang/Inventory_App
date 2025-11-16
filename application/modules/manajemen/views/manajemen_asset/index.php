<?php include('_js.php') ?>

<div class="page-wrapper">
  <div class="page-header d-print-none mt-2">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <?= $this->nav['nav_nm'] ?? 'Manajemen' ?>
          </div>
          <h2 class="page-title">
            <?= $this->title ?? 'Manajemen Asset' ?>
          </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <a href="javascript:void(0)" onclick="_modal(event, {uri: '<?= $this->uri . '/form_modal' ?>', size: 'modal-lg', position: 'normal'})" class="btn btn-primary d-sm-inline-block">
                <i class="fas fa-plus"></i> Tambah Asset
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
                <table class="table table-vcenter card-table table-striped table-sm display nowrap" id="datatable-main">
                  <thead>
                    <tr>
                      <th width="20">No</th>
                      <th width="40">Aksi</th>
                      <th>Kode Asset</th>
                      <th>Nama Asset</th>
                      <th>Kategori</th>
                      <th>Satuan</th>
                      <th>Stok Min</th>
                      <th class="text-center" width="5%">Status</th>
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