<?php include('_js.php') ?>

<div class="page-wrapper">
  <div class="page-header d-print-none mt-2">
    <div class="container-xl">
      <div class="row align-items-center">
        <div class="col">
          <div class="page-pretitle">Verifikasi Perbaikan Aset</div>
          <h2 class="page-title">Verifikasi & Realisasi Perbaikan</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <button type="button" class="btn btn-light" onclick="tabel.ajax.reload()">
                <i class="fas fa-sync me-1"></i> Refresh Data
            </button>
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
                <div class="col-md-3">
                    <label class="form-label">Filter Status:</label>
                    <select id="filter_status" class="form-select">
                        <option value="">- Semua Status -</option>
                        <option value="0">Menunggu Verifikasi (Baru)</option>
                        <option value="1">Sedang Proses</option>
                        <option value="2">Selesai</option>
                        <option value="9">Ditolak</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
              <table class="table table-vcenter card-table table-striped table-sm display nowrap" id="datatable-admin" width="100%">
                <thead>
                  <tr>
                    <th width="20">No</th>
                    <th width="40">Aksi (Ubah Status)</th>
                    <th>No. Tiket</th>
                    <th>Status</th>
                    <th>Nama Aset</th>
                    <th>Pelapor</th>
                    <th>Tgl Lapor</th>
                    <th>Keluhan</th>
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