<style>
  #frame_pdf {
    width: 100%;
    min-height: 80vh;
  }
</style>
<div class="card-body">
  <div class="row">
    <div class="col-md-12">
      <iframe id="frame_pdf" src="<?= $uri ?>" frameborder="0"></iframe>
    </div>
  </div>
  <div class="border-dotted"></div>
  <div class="mt-2">
    <div class="text-center">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= _icon('cancel') ?> Tutup</button>
      <a href="<?= $uri ?>" target="_blank" class="btn btn-primary">Buka Di Tab Baru <i class="fas fa-search ms-1"></i></a>
    </div>
  </div>
</div>