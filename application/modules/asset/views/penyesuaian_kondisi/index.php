<?php include('_js.php') ?>
<div class="page-wrapper">
  <div class="page-header d-print-none mt-2">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <?= $this->nav['nav_nm'] ?? 'Asset' ?>
          </div>
          <h2 class="page-title">
            <?= $this->title ?? 'Penyesuaian Kondisi' ?>
          </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <a href="javascript:void(0)" onclick="_modal(event, {uri: '<?= $this->uri . '/form_modal' ?>', size: 'modal-lg', position: 'normal'})" class="btn btn-danger d-sm-inline-block">
                <i class="fas fa-edit"></i> Buat Laporan
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
                      <th>Tanggal</th>
                      <th>No. Dokumen</th>
                      <th>Nama Aset</th>
                      <th>Dari Kondisi</th>
                      <th>Menjadi Kondisi</th>
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