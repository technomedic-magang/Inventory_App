<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-11-11 09:59:16 --> Severity: Compile Error --> Cannot declare class Laporan, because the name is already in use C:\laragon\www\tmfw-main\application\modules\laporan\models\M_laporan.php 4
ERROR - 2025-11-11 11:10:15 --> Severity: Compile Error --> Cannot declare class Laporan, because the name is already in use C:\laragon\www\tmfw-main\application\modules\laporan\models\M_laporan.php 4
ERROR - 2025-11-11 11:37:08 --> Severity: Compile Error --> Cannot declare class Laporan, because the name is already in use C:\laragon\www\tmfw-main\application\modules\laporan\models\M_laporan.php 8
ERROR - 2025-11-11 11:37:43 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudan' at line 8 - Invalid query: SELECT `t1`.*, IFNULL(ds.stok_qty, 0) as stok_qty
FROM ((SELECT `a`.`asset_kd`, `a`.`asset_nm`, `g`.`gudang_nm`, `k`.`kategori_nm`, `s`.`satuan_nm`, `a`.`kategori_id`, `g`.`gudang_id`
FROM `mst_asset` `a`
JOIN `mst_gudang` `g` ON 1=1
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_satuan` `s` ON `a`.`satuan_id` = `s`.`satuan_id`
WHERE `a`.`deleted_st` = 0
AND `g`.`deleted_st` = 0) t1)
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudang_id` = `ds`.`gudang_id`
ORDER BY `t1`.`gudang_nm` ASC, `t1`.`asset_nm` ASC
ERROR - 2025-11-11 11:37:49 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudan' at line 8 - Invalid query: SELECT `t1`.*, IFNULL(ds.stok_qty, 0) as stok_qty
FROM ((SELECT `a`.`asset_kd`, `a`.`asset_nm`, `g`.`gudang_nm`, `k`.`kategori_nm`, `s`.`satuan_nm`, `a`.`kategori_id`, `g`.`gudang_id`
FROM `mst_asset` `a`
JOIN `mst_gudang` `g` ON 1=1
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_satuan` `s` ON `a`.`satuan_id` = `s`.`satuan_id`
WHERE `a`.`deleted_st` = 0
AND `g`.`deleted_st` = 0) t1)
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudang_id` = `ds`.`gudang_id`
ORDER BY `t1`.`gudang_nm` ASC, `t1`.`asset_nm` ASC
ERROR - 2025-11-11 11:37:56 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudan' at line 8 - Invalid query: SELECT `t1`.*, IFNULL(ds.stok_qty, 0) as stok_qty
FROM ((SELECT `a`.`asset_kd`, `a`.`asset_nm`, `g`.`gudang_nm`, `k`.`kategori_nm`, `s`.`satuan_nm`, `a`.`kategori_id`, `g`.`gudang_id`
FROM `mst_asset` `a`
JOIN `mst_gudang` `g` ON 1=1
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_satuan` `s` ON `a`.`satuan_id` = `s`.`satuan_id`
WHERE `a`.`deleted_st` = 0
AND `g`.`deleted_st` = 0) t1)
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudang_id` = `ds`.`gudang_id`
ORDER BY `t1`.`gudang_nm` ASC, `t1`.`asset_nm` ASC
ERROR - 2025-11-11 11:40:47 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '.`asset_kd`, `a`.`asset_nm`, `k`.`kategori_nm`, `s`.`satuan_nm`, `a`.`kategori_i' at line 2 - Invalid query: SELECT `t1`.*, IFNULL(ds.stok_qty, 0) as stok_qty
FROM ((SELECT `a`.`asset_id`, `-- WAJIB ADA UNTUK JOIN STOK` `a`.`asset_kd`, `a`.`asset_nm`, `k`.`kategori_nm`, `s`.`satuan_nm`, `a`.`kategori_id`, `g`.`gudang_id`, `-- WAJIB ADA UNTUK JOIN STOK` `g`.`gudang_nm`
FROM `mst_asset` `a`
JOIN `mst_gudang` `g` ON 1=1
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_satuan` `s` ON `a`.`satuan_id` = `s`.`satuan_id`
WHERE `a`.`deleted_st` = 0
AND `g`.`deleted_st` = 0) t1)
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudang_id` = `ds`.`gudang_id`
ORDER BY `t1`.`gudang_nm` ASC, `t1`.`asset_nm` ASC
ERROR - 2025-11-11 11:40:53 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '.`asset_kd`, `a`.`asset_nm`, `k`.`kategori_nm`, `s`.`satuan_nm`, `a`.`kategori_i' at line 2 - Invalid query: SELECT `t1`.*, IFNULL(ds.stok_qty, 0) as stok_qty
FROM ((SELECT `a`.`asset_id`, `-- WAJIB ADA UNTUK JOIN STOK` `a`.`asset_kd`, `a`.`asset_nm`, `k`.`kategori_nm`, `s`.`satuan_nm`, `a`.`kategori_id`, `g`.`gudang_id`, `-- WAJIB ADA UNTUK JOIN STOK` `g`.`gudang_nm`
FROM `mst_asset` `a`
JOIN `mst_gudang` `g` ON 1=1
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_satuan` `s` ON `a`.`satuan_id` = `s`.`satuan_id`
WHERE `a`.`deleted_st` = 0
AND `g`.`deleted_st` = 0) t1)
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudang_id` = `ds`.`gudang_id`
ORDER BY `t1`.`gudang_nm` ASC, `t1`.`asset_nm` ASC
ERROR - 2025-11-11 11:41:51 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudan' at line 8 - Invalid query: SELECT `t1`.*, IFNULL(ds.stok_qty, 0) as stok_qty
FROM ((SELECT `a`.`asset_id`, `a`.`asset_kd`, `a`.`asset_nm`, `k`.`kategori_nm`, `s`.`satuan_nm`, `a`.`kategori_id`, `g`.`gudang_id`, `g`.`gudang_nm`
FROM `mst_asset` `a`
JOIN `mst_gudang` `g` ON 1=1
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_satuan` `s` ON `a`.`satuan_id` = `s`.`satuan_id`
WHERE `a`.`deleted_st` = 0
AND `g`.`deleted_st` = 0) t1)
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudang_id` = `ds`.`gudang_id`
ORDER BY `t1`.`gudang_nm` ASC, `t1`.`asset_nm` ASC
ERROR - 2025-11-11 11:42:06 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudan' at line 8 - Invalid query: SELECT `t1`.*, IFNULL(ds.stok_qty, 0) as stok_qty
FROM ((SELECT `a`.`asset_id`, `a`.`asset_kd`, `a`.`asset_nm`, `k`.`kategori_nm`, `s`.`satuan_nm`, `a`.`kategori_id`, `g`.`gudang_id`, `g`.`gudang_nm`
FROM `mst_asset` `a`
JOIN `mst_gudang` `g` ON 1=1
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_satuan` `s` ON `a`.`satuan_id` = `s`.`satuan_id`
WHERE `a`.`deleted_st` = 0
AND `g`.`deleted_st` = 0) t1)
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudang_id` = `ds`.`gudang_id`
ORDER BY `t1`.`gudang_nm` ASC, `t1`.`asset_nm` ASC
ERROR - 2025-11-11 11:43:11 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '.`asset_id`, `a`.`asset_kd`, `a`.`asset_nm`, `k`.`kategori_nm`, `s`.`satuan_nm`,' at line 2 - Invalid query: SELECT `t1`.*, IFNULL(ds.stok_qty, 0) as stok_qty
FROM (`SELECT` `a`.`asset_id`, `a`.`asset_kd`, `a`.`asset_nm`, `k`.`kategori_nm`, `s`.`satuan_nm`, `a`.`kategori_id`, `g`.`gudang_id`, `g`.`gudang_nm`` FROM ``mst_asset`` ``a`` JOIN ``mst_gudang`` ``g`` ON 1=1 LEFT JOIN ``mst_kategori`` ``k`` ON ``a`.`kategori_id`` = ``k`.`kategori_id`` LEFT JOIN ``mst_satuan`` ``s`` ON ``a`.`satuan_id`` = ``s`.`satuan_id`` WHERE ``a`.`deleted_st`` = 0 AND ``g`.`deleted_st`` = 0` `t1`)
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudang_id` = `ds`.`gudang_id`
ORDER BY `t1`.`gudang_nm` ASC, `t1`.`asset_nm` ASC
ERROR - 2025-11-11 11:43:23 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '.`asset_id`, `a`.`asset_kd`, `a`.`asset_nm`, `k`.`kategori_nm`, `s`.`satuan_nm`,' at line 2 - Invalid query: SELECT `t1`.*, IFNULL(ds.stok_qty, 0) as stok_qty
FROM (`SELECT` `a`.`asset_id`, `a`.`asset_kd`, `a`.`asset_nm`, `k`.`kategori_nm`, `s`.`satuan_nm`, `a`.`kategori_id`, `g`.`gudang_id`, `g`.`gudang_nm`` FROM ``mst_asset`` ``a`` JOIN ``mst_gudang`` ``g`` ON 1=1 LEFT JOIN ``mst_kategori`` ``k`` ON ``a`.`kategori_id`` = ``k`.`kategori_id`` LEFT JOIN ``mst_satuan`` ``s`` ON ``a`.`satuan_id`` = ``s`.`satuan_id`` WHERE ``a`.`deleted_st`` = 0 AND ``g`.`deleted_st`` = 0` `t1`)
LEFT JOIN `dat_stok` `ds` ON `t1`.`asset_id` = `ds`.`asset_id` AND `t1`.`gudang_id` = `ds`.`gudang_id`
ORDER BY `t1`.`gudang_nm` ASC, `t1`.`asset_nm` ASC
ERROR - 2025-11-11 12:35:14 --> Severity: error --> Exception: Call to undefined function render() C:\laragon\www\tmfw-main\application\modules\laporan\controllers\Laporan.php 22
ERROR - 2025-11-11 12:43:26 --> 404 Page Not Found: ../modules/laporan/controllers/Laporan/preview_stok
ERROR - 2025-11-11 12:44:33 --> 404 Page Not Found: ../modules/laporan/controllers/Laporan/preview_stok
ERROR - 2025-11-11 12:44:38 --> 404 Page Not Found: ../modules/laporan/controllers/Laporan/preview_stok
ERROR - 2025-11-11 12:46:28 --> 404 Page Not Found: ../modules/laporan/controllers/Laporan/preview_stok
ERROR - 2025-11-11 12:58:23 --> Severity: Compile Error --> Cannot declare class Laporan, because the name is already in use C:\laragon\www\tmfw-main\application\modules\laporan\views\laporan\index.php 4
ERROR - 2025-11-11 12:59:00 --> Severity: Compile Error --> Cannot declare class Laporan, because the name is already in use C:\laragon\www\tmfw-main\application\modules\laporan\views\laporan\index.php 4
ERROR - 2025-11-11 13:46:36 --> Severity: error --> Exception: Class '_Controller' not found C:\laragon\www\tmfw-main\application\modules\laporan\controllers\Laporan.php 8
ERROR - 2025-11-11 13:46:52 --> Severity: Notice --> Undefined variable: title C:\laragon\www\tmfw-main\application\modules\laporan\views\laporan\index.php 5
ERROR - 2025-11-11 13:46:52 --> Severity: Notice --> Undefined variable: title C:\laragon\www\tmfw-main\application\modules\laporan\views\laporan\index.php 9
ERROR - 2025-11-11 13:46:52 --> Severity: Notice --> Undefined variable: gudang C:\laragon\www\tmfw-main\application\modules\laporan\views\laporan\index.php 15
ERROR - 2025-11-11 13:46:52 --> Severity: Warning --> Invalid argument supplied for foreach() C:\laragon\www\tmfw-main\application\modules\laporan\views\laporan\index.php 15
ERROR - 2025-11-11 13:46:52 --> Severity: Notice --> Undefined variable: kategori C:\laragon\www\tmfw-main\application\modules\laporan\views\laporan\index.php 23
ERROR - 2025-11-11 13:46:52 --> Severity: Warning --> Invalid argument supplied for foreach() C:\laragon\www\tmfw-main\application\modules\laporan\views\laporan\index.php 23
