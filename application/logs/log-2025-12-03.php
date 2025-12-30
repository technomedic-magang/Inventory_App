<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-12-03 00:00:39 --> 404 Page Not Found: ../modules/persediaan/controllers//index
ERROR - 2025-12-03 00:03:47 --> 404 Page Not Found: ../modules/persediaan/controllers//index
ERROR - 2025-12-03 00:04:16 --> Severity: Notice --> Undefined variable: redirect_url C:\laragon\www\tmfw-main\application\modules\persediaan\controllers\Persediaan_masuk.php 120
ERROR - 2025-12-03 09:15:57 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'tmfw_inventory_management_system.p.persediaan_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `p`.*, `s`.`satuan_nm`
FROM `mst_persediaan` `p`
LEFT JOIN `mst_satuan` `s` ON `s`.`satuan_id` = `p`.`satuan_id`
WHERE `p`.`deleted_st` = 0
GROUP BY `p`.`barang_nm`
ORDER BY `p`.`barang_nm` ASC
ERROR - 2025-12-03 22:50:18 --> 404 Page Not Found: ../modules/formulir/controllers//index
