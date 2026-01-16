<?php 
// Logika View
$has_attributes = !empty($list_atribut);
?>

<?php if ($has_attributes): ?>
    <div class="border-dotted my-3"></div>
    <h5 class="mb-3 text-muted">Atribut Khusus Kategori</h5>
    
    <?php foreach($list_atribut as $attr): ?>
        <?php
            $field_name = "kustom[{$attr['atribut_id']}]";
            $value = $tersimpan[$attr['atribut_id']] ?? '';
        ?>
        
        <div class="mb-1 row">
            <label class="col-lg-3 col-md-6 col-form-label"><?= $attr['atribut_label'] ?></label>
            <div class="col-lg-8 col-md-6">
                
                <?php if ($attr['atribut_tipe'] == 'teks'): ?>
                    <input type="text" name="<?= $field_name ?>" class="form-control" value="<?= $value ?>">
                
                <?php elseif ($attr['atribut_tipe'] == 'angka'): ?>
                    <input type="number" name="<?= $field_name ?>" class="form-control" value="<?= $value ?>">

                <?php elseif ($attr['atribut_tipe'] == 'tanggal'): ?>
                    <input type="date" name="<?= $field_name ?>" class="form-control" value="<?= $value ?>">

                <?php elseif ($attr['atribut_tipe'] == 'textarea'): ?>
                    <textarea name="<?= $field_name ?>" class="form-control" rows="2"><?= $value ?></textarea>
                
                <?php endif; ?>

            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>