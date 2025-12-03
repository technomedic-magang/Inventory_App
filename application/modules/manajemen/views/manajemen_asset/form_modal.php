<form id="form" action="<?= $form_act ?>" method="post" autocomplete="off">
  <div class="card-body">
    
    <h4 class="mb-3 text-primary">Informasi Utama</h4>
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Kategori</label>
      <div class="col-lg-8 col-md-6">
        <select name="kategori_id" id="kategori_id" class="form-select" required onchange="loadAtributDanSKU()">
          <option value="">-- Pilih Kategori --</option>
          <?php foreach ($list_kategori as $kat): ?>
            <option value="<?= $kat['kategori_id'] ?>" data-tipe="<?= $kat['kategori_tipe'] ?>" data-kode="<?= $kat['kategori_kd'] ?>" <?= (@$main['kategori_id'] == $kat['kategori_id']) ? 'selected' : '' ?>>
              <?= $kat['kategori_nm'] ?> (<?= $kat['kategori_tipe'] ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Nama Aset</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="asset_nm" class="form-control" value="<?= @$main['asset_nm'] ?>" required>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Satuan</label>
      <div class="col-lg-8 col-md-6">
        <select name="satuan_id" class="form-select" required>
          <option value="">-- Pilih Satuan --</option>
          <?php foreach ($list_satuan as $sat): ?>
            <option value="<?= $sat['satuan_id'] ?>" <?= (@$main['satuan_id'] == $sat['satuan_id']) ? 'selected' : '' ?>>
              <?= $sat['satuan_nm'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="border-dotted my-3"></div>
    <h4 class="mb-3 text-muted">Komponen Kode Aset (SKU)</h4>
    
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Singkatan Nama</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="asset_kd_singkat" id="asset_kd_singkat" class="form-control" value="<?= @$main['asset_kd_singkat'] ?>" required placeholder="Cth: KT(kantor), MT(motor), LPT">
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Tahun Beli</label>
      <div class="col-lg-8 col-md-6">
        <input type="number" name="asset_thn_beli" id="asset_thn_beli" class="form-control" value="<?= @$main['asset_thn_beli'] ?>" placeholder="Cth: 2024" required>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Bulan Beli</label>
      <div class="col-lg-8 col-md-6">
        <select name="asset_bln_beli" id="asset_bln_beli" class="form-select" required>
          <option value="">- Pilih Bulan -</option>
          <?php for($b=1; $b<=12; $b++): ?>
            <option value="<?= $b ?>" <?= (@$main['asset_bln_beli'] == $b) ? 'selected' : '' ?>>
              <?= str_pad($b, 2, '0', STR_PAD_LEFT) ?> (<?= date('F', mktime(0,0,0,$b, 1)) ?>)
            </option>
          <?php endfor; ?>
        </select>
      </div>
    </div>

    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Kode Aset (SKU)</label>
      <div class="col-lg-8 col-md-6">
        <input type="text" name="asset_kd" id="asset_kd" class="form-control bg-light" 
               value="<?= @$main['asset_kd'] ?>" 
               placeholder="(Akan terisi otomatis)" readonly>
      </div>
    </div>


    <div id="area-dinamis-kontainer" class="mt-3">
      
      <div id="area-aset" class="d-none">
        <div class="border-dotted mb-3"></div>
        <h4 class="mb-3 text-primary">Detail Spesifikasi</h4>

        <div class="mb-1 row" id="grup-masa-pakai">
          <label class="col-lg-3 col-md-6 col-form-label">Masa Pakai (Thn)</label>
          <div class="col-lg-8 col-md-6">
            <input type="number" name="asset_masa_pakai_thn" class="form-control" value="<?= @$main['asset_masa_pakai_thn'] ?? 0 ?>">
          </div>
        </div>

        <div class="mb-1 row">
          <label class="col-lg-3 col-md-6 col-form-label">Kondisi</label>
          <div class="col-lg-8 col-md-6">
            <select name="asset_kondisi" class="form-select">
              <option value="BAIK" <?= (@$main['asset_kondisi'] == 'BAIK' || !isset($main)) ? 'selected' : '' ?>>BAIK</option>
              <option value="RUSAK" <?= (@$main['asset_kondisi'] == 'RUSAK') ? 'selected' : '' ?>>RUSAK</option>
              <option value="PERBAIKAN" <?= (@$main['asset_kondisi'] == 'PERBAIKAN') ? 'selected' : '' ?>>SEDANG PERBAIKAN</option>
            </select>
          </div>
        </div>
        
        <div id="area-atribut-kustom"></div>
      </div>

      <div id="area-persediaan" class="d-none">
        <div class="border-dotted mb-3"></div>
        <h4 class="mb-3 text-muted">Detail Persediaan</h4>
        <div class="mb-1 row">
          <label class="col-lg-3 col-md-6 col-form-label">Stok Minimal</label>
          <div class="col-lg-8 col-md-6">
            <input type="number" name="stok_min_qty" class="form-control" value="<?= @$main['stok_min_qty'] ?? 0 ?>">
          </div>
        </div>
      </div>
    </div> 

    <div class="border-dotted my-3"></div>
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label">Keterangan</label>
      <div class="col-lg-8 col-md-6">
        <textarea name="asset_ket" class="form-control" rows="2"><?= @$main['asset_ket'] ?></textarea>
      </div>
    </div>
    <div class="mb-1 row">
      <label class="col-lg-3 col-md-6 col-form-label required">Aktif?</label>
      <div class="col-lg-8 col-md-6">
        <label class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="active_st" value="1" <?= (@$main == '') ? 'checked' : ((@$main['active_st'] == 1) ? 'checked' : '') ?>>
          <span class="form-check-label">Aktif</span>
        </label>
        <label class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="active_st" value="0" <?= (@$main != '') ? ((@$main['active_st'] == 0) ? 'checked' : '') : '' ?>>
          <span class="form-check-label">Tidak Aktif</span>
        </label>
      </div>
    </div>
    <div class="border-dotted"></div>
    <div class="row mt-2">
      <div class="col-9 offset-3">
        <button type="submit" class="btn btn-primary" onclick="_save(event)"><?= _icon('save') ?> Simpan</button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?= _icon('cancel') ?> Batal</button>
      </div>
    </div>
  </div>
</form>

<script>
    function loadAtributDanSKU() {
        updateFormDinamis();
        updateSKUPreview();
    }
    function updateFormDinamis() {
        var $select = $('#kategori_id');
        var kategori_id = $select.val();
        var tipe_kategori = $select.find(':selected').data('tipe');
        var kode_kategori = $select.find(':selected').data('kode');
        var asset_id = '<?= @$main['asset_id'] ?? '' ?>'; 
        $('#area-aset').addClass('d-none');
        $('#area-persediaan').addClass('d-none');
        $('#area-atribut-kustom').html('');
        $('#grup-masa-pakai').show(); 
        if (!kategori_id) return;
        if (tipe_kategori == 'ASET') {
            $('#area-aset').removeClass('d-none');
            if (kode_kategori == 'GG' || kode_kategori == 'K2' || kode_kategori == 'K4' || kode_kategori == 'ACC') { 
                $('#grup-masa-pakai').hide();
                $('input[name="asset_masa_pakai_thn"]').val(0);
            }
            $('#area-atribut-kustom').html('<div class="text-center p-2"><span class="spinner-border spinner-border-sm"></span>...</div>');
            $.ajax({
                url: '<?= $this->uri . "/get_atribut_dinamis?n=" . _get("n") ?>',
                type: 'POST', data: { kategori_id: kategori_id, asset_id: asset_id }, dataType: 'json',
                success: function(res) { $('#area-atribut-kustom').html(res.html); },
                error: function() { $('#area-atribut-kustom').html('<div class="text-danger small">Gagal memuat.</div>'); }
            });
        } else if (tipe_kategori == 'PERSEDIAAN') {
            $('#area-persediaan').removeClass('d-none');
        }
    }
    function updateSKUPreview() {
        var asset_id = '<?= @$main['asset_id'] ?? '' ?>';
        if (asset_id != '') return; 
        var data_sku = {
            kategori_id: $('#kategori_id').val(),
            kd_singkat: $('#asset_kd_singkat').val(),
            tahun: $('#asset_thn_beli').val(),
            bulan: $('#asset_bln_beli').val()
        };
        if (data_sku.kategori_id && data_sku.kd_singkat && data_sku.tahun && data_sku.bulan) {
            $('#asset_kd').val('Generating...');
            $.ajax({
                url: '<?= $this->uri . "/get_sku_ajax?n=" . _get("n") ?>',
                type: 'POST', data: data_sku, dataType: 'json',
                success: function(res) { 
                    if (res.new_sku) $('#asset_kd').val(res.new_sku); 
                    else $('#asset_kd').val('Error');
                }
            });
        }
    }
    $(document).on('change', '#kategori_id, #asset_kd_singkat, #asset_thn_beli, #asset_bln_beli', updateSKUPreview);
    $(document).on('change', '#kategori_id', loadAtributDanSKU); // Panggil fungsi gabungan
    $(document).ready(function() {
        setTimeout(function() {
            if ('<?= @$main['kategori_id'] ?>') {
                loadAtributDanSKU();
            }
        }, 100);
    });
</script>