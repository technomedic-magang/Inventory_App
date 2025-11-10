<?php foreach ($module as $m) : ?>
  <?php
  $link = "";
  if ($m['nav_url'] == 'dashboard/index' && $m['nav_id'] != 'E11') {
    $link = site_url('dashboard/index?n=' . md5($m['nav_id']));
  } else if ($m['nav_id'] == 'E11' && @$m['nav_url'] == 'dashboard/index') {
    $link = site_url('eksekutif/dashboard?n=' . md5($m['nav_id']));
  } else {
    $link = site_url($m['nav_url'] . '?n=' . md5($m['nav_id']));
  }
  ?>
  <div class="col-lg-2 col-sm-3 gx-2">
    <a class="card card-link mb-2" href="<?= $link ?>">
      <div class="card-body py-2 px-2">
        <div class="row">
          <div class="col-auto">
            <span class="avatar" style="background-image: url('<?= $m['image'] ?>'); box-shadow: none;background-color:white;"></span>
          </div>
          <div class="col gx-2">
            <div class="font-weight-medium"><?= $m['nav_nm'] ?></div>
          </div>
        </div>
      </div>
    </a>
  </div>
<?php endforeach; ?>