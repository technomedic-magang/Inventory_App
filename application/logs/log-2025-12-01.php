<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-12-01 16:41:56 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_masuk
ERROR - 2025-12-01 19:46:19 --> Severity: error --> Exception: Class 'HMVC_Controller' not found C:\laragon\www\tmfw-main\application\modules\persediaan\controllers\Persediaan.php 4
ERROR - 2025-12-01 19:47:53 --> Severity: error --> Exception: Class 'HMVC_Controller' not found C:\laragon\www\tmfw-main\application\modules\persediaan\controllers\Persediaan.php 4
ERROR - 2025-12-01 19:47:55 --> Severity: error --> Exception: Class 'HMVC_Controller' not found C:\laragon\www\tmfw-main\application\modules\persediaan\controllers\Persediaan.php 4
ERROR - 2025-12-01 19:47:56 --> Severity: error --> Exception: Class 'HMVC_Controller' not found C:\laragon\www\tmfw-main\application\modules\persediaan\controllers\Persediaan.php 4
ERROR - 2025-12-01 19:47:56 --> Severity: error --> Exception: Class 'HMVC_Controller' not found C:\laragon\www\tmfw-main\application\modules\persediaan\controllers\Persediaan.php 4
ERROR - 2025-12-01 19:47:56 --> Severity: error --> Exception: Class 'HMVC_Controller' not found C:\laragon\www\tmfw-main\application\modules\persediaan\controllers\Persediaan.php 4
ERROR - 2025-12-01 19:47:56 --> Severity: error --> Exception: Class 'HMVC_Controller' not found C:\laragon\www\tmfw-main\application\modules\persediaan\controllers\Persediaan.php 4
ERROR - 2025-12-01 19:51:51 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_masuk
ERROR - 2025-12-01 19:52:18 --> Query error: Unknown column 'p.lengkap_nm' in 'field list' - Invalid query: SELECT `t`.*, `p`.`lengkap_nm` as `pembuat_nm`
FROM `dat_persediaan_masuk` `t`
LEFT JOIN `mst_pegawai` `p` ON `p`.`pegawai_id` = `t`.`created_by`
WHERE `t`.`deleted_st` = 0
ORDER BY `t`.`beli_tgl` DESC
ERROR - 2025-12-01 19:55:13 --> Query error: Unknown column 'p.nama_lengkap' in 'field list' - Invalid query: SELECT `t`.*, `p`.`nama_lengkap` as `pembuat_nm`
FROM `dat_persediaan_masuk` `t`
LEFT JOIN `mst_pegawai` `p` ON `p`.`pegawai_id` = `t`.`created_by`
WHERE `t`.`deleted_st` = 0
ORDER BY `t`.`beli_tgl` DESC
ERROR - 2025-12-01 20:04:22 --> Query error: Unknown column 'p.lengkap_nm' in 'field list' - Invalid query: SELECT `t`.*, `p`.`lengkap_nm` as `pembuat_nm`
FROM `dat_persediaan_masuk` `t`
LEFT JOIN `mst_pegawai` `p` ON `p`.`pegawai_id` = `t`.`created_by`
WHERE `t`.`deleted_st` = 0
ORDER BY `t`.`beli_tgl` DESC
ERROR - 2025-12-01 20:40:44 --> Severity: Notice --> Undefined variable: history C:\laragon\www\tmfw-main\application\modules\persediaan\views\masuk\index.php 46
ERROR - 2025-12-01 20:40:44 --> Severity: Warning --> Invalid argument supplied for foreach() C:\laragon\www\tmfw-main\application\modules\persediaan\views\masuk\index.php 46
ERROR - 2025-12-01 20:56:55 --> 404 Page Not Found: ../modules/persediaan/controllers//index
ERROR - 2025-12-01 21:30:35 --> 404 Page Not Found: ../modules/persediaan/controllers//index
ERROR - 2025-12-01 21:32:07 --> 404 Page Not Found: ../modules/persediaan/controllers//index
ERROR - 2025-12-01 22:08:43 --> Unable to load the requested class: Datatables
ERROR - 2025-12-01 22:11:33 --> Query error: Unknown column 'p.lengkap_nm' in 'field list' - Invalid query: SELECT `t`.`masuk_id`, `t`.`beli_tgl`, `t`.`struk_no`, `t`.`keterangan_txt`, `t`.`total_qty`, `t`.`active_st`, `p`.`lengkap_nm` as `created_by_nm`
FROM `dat_persediaan_masuk` `t`
LEFT JOIN `mst_pegawai` `p` ON `p`.`pegawai_id` = `t`.`created_by`
WHERE `t`.`deleted_st` = 0
ORDER BY `t`.`beli_tgl` DESC
 LIMIT 25
ERROR - 2025-12-01 22:11:37 --> Query error: Unknown column 'p.lengkap_nm' in 'field list' - Invalid query: SELECT `t`.`masuk_id`, `t`.`beli_tgl`, `t`.`struk_no`, `t`.`keterangan_txt`, `t`.`total_qty`, `t`.`active_st`, `p`.`lengkap_nm` as `created_by_nm`
FROM `dat_persediaan_masuk` `t`
LEFT JOIN `mst_pegawai` `p` ON `p`.`pegawai_id` = `t`.`created_by`
WHERE `t`.`deleted_st` = 0
ORDER BY `t`.`beli_tgl` DESC
 LIMIT 25
ERROR - 2025-12-01 23:03:27 --> Query error: Column 'satuan_id' in field list is ambiguous - Invalid query: SELECT `persediaan_id`, `barang_nm`, `barang_kd`, `satuan_id`
FROM `mst_persediaan`
LEFT JOIN `mst_satuan` ON `mst_persediaan`.`satuan_id` = `mst_satuan`.`satuan_id`
WHERE `mst_persediaan`.`deleted_st` = 0
AND `mst_persediaan`.`active_st` = 1
ORDER BY `barang_nm` ASC
