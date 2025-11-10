<?php include('_js.php') ?>
<div class="page-wrapper">
    <div class="page-header d-print-none mt-2">
        <div class="container-xl">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle"><?= $this->nav['nav_nm'] ?? 'Master Data' ?></div>
                    <h2 class="page-title"><?= $this->title ?? 'Master Satuan' ?></h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="javascript:void(0)" onclick="_modal(event, {uri: '<?= $this->uri . '/form_modal' ?>', size: 'modal-md'})" class="btn btn-primary d-sm-inline-block">
                            <i class="fas fa-plus"></i> Tambah Satuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body mt-2">
        <div class="container-xl">
            <div class="card">
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped table-sm display nowrap" id="datatable-main" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Aksi</th>
                                    <th>Nama Satuan</th>
                                    <th class="text-center" width="10%">Status</th>
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