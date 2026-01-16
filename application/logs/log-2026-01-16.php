<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-01-16 00:00:22 --> 404 Page Not Found: /index
ERROR - 2026-01-16 00:01:12 --> 404 Page Not Found: /index
ERROR - 2026-01-16 00:16:01 --> Severity: Warning --> substr() expects parameter 1 to be string, array given C:\laragon\www\tmfw-main\application\helpers\db_helper.php 325
ERROR - 2026-01-16 00:16:01 --> Severity: Notice --> Array to string conversion C:\laragon\www\tmfw-main\application\helpers\db_helper.php 331
ERROR - 2026-01-16 00:16:01 --> Query error: Unknown column 'Array' in 'where clause' - Invalid query: SELECT t.*, d.masuk_qty, p.barang_nm, k.kategori_nm, s.satuan_nm 
                  FROM dat_persediaan_masuk t
                  JOIN dat_persediaan_masuk_det d ON t.masuk_id = d.masuk_id
                  JOIN mst_persediaan p ON d.persediaan_id = p.persediaan_id
                  LEFT JOIN mst_kategori_persediaan k ON p.kategori_id = k.kategori_id
                  LEFT JOIN mst_satuan s ON d.satuan_id = s.satuan_id WHERE  Array AND t.deleted_st='0' AND (LOWER(t.struk_no) LIKE '%%' OR LOWER(p.barang_nm) LIKE '%%' OR LOWER(k.kategori_nm) LIKE '%%')  ORDER BY beli_tgl desc LIMIT 25 OFFSET 0
ERROR - 2026-01-16 00:18:04 --> 404 Page Not Found: /index
ERROR - 2026-01-16 00:37:11 --> Severity: error --> Exception: Unable to locate the model you have specified: M_pemakaian C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2026-01-16 00:38:19 --> 404 Page Not Found: ../modules/transaksi/controllers/Mutasi_asset/index
ERROR - 2026-01-16 00:38:33 --> 404 Page Not Found: ../modules/transaksi/controllers//index
ERROR - 2026-01-16 00:39:14 --> 404 Page Not Found: ../modules/transaksi/controllers//index
ERROR - 2026-01-16 00:39:38 --> 404 Page Not Found: /index
ERROR - 2026-01-16 00:39:54 --> 404 Page Not Found: /index
ERROR - 2026-01-16 00:41:43 --> 404 Page Not Found: /index
ERROR - 2026-01-16 00:42:23 --> 404 Page Not Found: /index
ERROR - 2026-01-16 00:44:57 --> 404 Page Not Found: /index
ERROR - 2026-01-16 00:49:28 --> 404 Page Not Found: /index
ERROR - 2026-01-16 15:35:03 --> Severity: Compile Error --> Cannot declare class Pemakaian, because the name is already in use C:\laragon\www\tmfw-main\application\modules\transaksi\models\M_pemakaian.php 4
ERROR - 2026-01-16 16:09:32 --> 404 Page Not Found: /index
ERROR - 2026-01-16 16:09:32 --> 404 Page Not Found: /index
ERROR - 2026-01-16 21:37:55 --> 404 Page Not Found: /index
ERROR - 2026-01-16 21:39:16 --> 404 Page Not Found: /index
ERROR - 2026-01-16 21:39:18 --> 404 Page Not Found: /index
ERROR - 2026-01-16 21:39:32 --> 404 Page Not Found: /index
ERROR - 2026-01-16 21:41:21 --> Severity: error --> Exception: Unable to locate the model you have specified: M_verifikasi_perbaikan C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2026-01-16 22:10:03 --> Severity: Notice --> Undefined property: CI::$uri_mod C:\laragon\www\tmfw-main\application\third_party\MX\Controller.php 63
