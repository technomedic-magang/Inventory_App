<?php if (!empty($list_atribut)): ?>
    <div class="border-dotted my-3"></div>
    <h4 class="mb-3 text-muted">Detail Lokasi Aset</h4>
    
    <?php foreach($list_atribut as $attr): ?>
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label required">
                <?= $attr['atribut_label'] ?>
            </label>
            <div class="col-lg-8 col-md-6">
                
                <?php if ($attr['atribut_tipe'] == 'teks'): ?>
                    <input type="text" name="kustom[<?= $attr['atribut_id'] ?>]" class="form-control" required>
                
                <?php elseif ($attr['atribut_tipe'] == 'angka'): ?>
                    <input type="number" name="kustom[<?= $attr['atribut_id'] ?>]" class="form-control" required>

                <?php elseif ($attr['atribut_tipe'] == 'tanggal'): ?>
                    <input type="date" name="kustom[<?= $attr['atribut_id'] ?>]" class="form-control" required>

                <?php elseif ($attr['atribut_tipe'] == 'textarea'): ?>
                    <textarea name="kustom[<?= $attr['atribut_id'] ?>]" class="form-control" rows="2" required></textarea>
                
                <?php endif; ?>

            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>