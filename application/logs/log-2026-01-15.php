<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-01-15 19:12:15 --> Severity: error --> Exception: Unable to locate the model you have specified: M_manajemen_gudang C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2026-01-15 19:19:45 --> Query error: Duplicate entry '#' for key 'app_nav.PRIMARY' - Invalid query: UPDATE `app_nav` SET `nav_parent` = '01', `nav_id` = '#', `nav_nm` = 'Manajemen', `nav_url` = 'master/manajemen', `icon` = 'fas fa-chart-bar', `active_st` = '1', `updated_at` = '2026-01-15 19:19:45', `updated_by` = 'PEGAWAI TESTER'
WHERE `nav_id` = '03'
ERROR - 2026-01-15 20:22:55 --> Severity: error --> Exception: Unable to locate the model you have specified: M_manajemen_satuan C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2026-01-15 20:27:05 --> 404 Page Not Found: ../modules/master/controllers//index
ERROR - 2026-01-15 20:33:20 --> 404 Page Not Found: ../modules/master/controllers//index
ERROR - 2026-01-15 20:33:48 --> 404 Page Not Found: ../modules/master/controllers//index
ERROR - 2026-01-15 20:34:38 --> 404 Page Not Found: ../modules/master/controllers/Gudang/index
ERROR - 2026-01-15 20:35:32 --> 404 Page Not Found: ../modules/master/controllers/Gudang/index
ERROR - 2026-01-15 20:36:47 --> 404 Page Not Found: ../modules/master/controllers/Gudang/index
ERROR - 2026-01-15 20:37:03 --> 404 Page Not Found: ../modules/master/controllers/Gudang/index
ERROR - 2026-01-15 22:13:15 --> Query error: Duplicate entry '04.01' for key 'app_nav.PRIMARY' - Invalid query: UPDATE `app_nav` SET `nav_parent` = '04', `nav_id` = '04.01', `nav_nm` = 'Manajemen Aset', `nav_url` = 'aset/manajemen_aset', `icon` = NULL, `active_st` = '1', `updated_at` = '2026-01-15 22:13:15', `updated_by` = 'PEGAWAI TESTER'
WHERE `nav_id` = '03.01'
ERROR - 2026-01-15 22:13:53 --> 404 Page Not Found: /index
ERROR - 2026-01-15 22:55:07 --> Severity: error --> Exception: Class 'M_manajemen_aset' not found C:\laragon\www\tmfw-main\application\third_party\MX\Loader.php 213
ERROR - 2026-01-15 22:59:12 --> Severity: error --> Exception: Class 'M_manajemen_aset' not found C:\laragon\www\tmfw-main\application\third_party\MX\Loader.php 213
ERROR - 2026-01-15 23:09:20 --> Severity: error --> Exception: Unable to locate the model you have specified: M_manajemen_asset C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2026-01-15 23:10:24 --> Severity: error --> Exception: Class 'M_manajemen_aset' not found C:\laragon\www\tmfw-main\application\third_party\MX\Loader.php 213
ERROR - 2026-01-15 23:57:16 --> 404 Page Not Found: /index
ERROR - 2026-01-15 23:57:25 --> 404 Page Not Found: /index
ERROR - 2026-01-15 23:58:15 --> 404 Page Not Found: /index
ERROR - 2026-01-15 23:58:33 --> Severity: Warning --> substr() expects parameter 1 to be string, array given C:\laragon\www\tmfw-main\application\helpers\db_helper.php 325
ERROR - 2026-01-15 23:58:33 --> Severity: Notice --> Array to string conversion C:\laragon\www\tmfw-main\application\helpers\db_helper.php 331
ERROR - 2026-01-15 23:58:33 --> Query error: Unknown column 'Array' in 'where clause' - Invalid query: SELECT t.*, d.masuk_qty, p.barang_nm, k.kategori_nm, s.satuan_nm 
                  FROM dat_persediaan_masuk t
                  JOIN dat_persediaan_masuk_det d ON t.masuk_id = d.masuk_id
                  JOIN mst_persediaan p ON d.persediaan_id = p.persediaan_id
                  LEFT JOIN mst_kategori_persediaan k ON p.kategori_id = k.kategori_id
                  LEFT JOIN mst_satuan s ON d.satuan_id = s.satuan_id WHERE  Array AND t.deleted_st='0' AND (LOWER(t.struk_no) LIKE '%%' OR LOWER(p.barang_nm) LIKE '%%' OR LOWER(k.kategori_nm) LIKE '%%')  ORDER BY beli_tgl desc LIMIT 25 OFFSET 0
ERROR - 2026-01-15 23:59:24 --> 404 Page Not Found: /index
