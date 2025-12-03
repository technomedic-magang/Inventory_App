<?php 
// File ini HANYA berisi potongan HTML untuk form dinamis
?>

<?php if (!empty($list_atribut)): ?>
    <div class="border-dotted my-3"></div>
    <h5 class="mb-3 text-muted">Atribut Khusus Kategori</h5>
    
    <?php foreach($list_atribut as $attr): ?>
        <?php
            // Ambil data yang tersimpan (jika mode edit)
            $value = $tersimpan[$attr['atribut_id']] ?? '';
        ?>
        
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label"><?= $attr['atribut_label'] ?></label>
            <div class="col-lg-8 col-md-6">
                
                <?php if ($attr['atribut_tipe'] == 'teks'): ?>
                    <input type="text" name="kustom[<?= $attr['atribut_id'] ?>]" class="form-control" value="<?= $value ?>">
                
                <?php elseif ($attr['atribut_tipe'] == 'angka'): ?>
                    <input type="number" name="kustom[<?= $attr['atribut_id'] ?>]" class="form-control" value="<?= $value ?>">

                <?php elseif ($attr['atribut_tipe'] == 'tanggal'): ?>
                    <input type="date" name="kustom[<?= $attr['atribut_id'] ?>]" class="form-control" value="<?= $value ?>">

                <?php elseif ($attr['atribut_tipe'] == 'textarea'): ?>
                    <textarea name="kustom[<?= $attr['atribut_id'] ?>]" class="form-control" rows="2"><?= $value ?></textarea>
                
                <?php endif; ?>

            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>