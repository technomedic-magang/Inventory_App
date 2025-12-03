<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-11-15 00:27:23 --> 404 Page Not Found: /index
ERROR - 2025-11-15 00:31:57 --> Severity: error --> Exception: Unable to locate the model you have specified: M_pakai C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:32:54 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:34:35 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:32 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:33 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:33 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:33 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:33 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:34 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:34 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:34 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:34 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:35 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:35 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:35 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:36 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:37 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:37 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:35:37 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:36:47 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:36:48 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:36:52 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:37:46 --> Severity: error --> Exception: Unable to locate the model you have specified: M_kembali C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2025-11-15 00:37:52 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_masuk
ERROR - 2025-11-15 00:37:55 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_keluar
ERROR - 2025-11-15 00:38:11 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_masuk
ERROR - 2025-11-15 00:38:14 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_keluar
ERROR - 2025-11-15 00:38:34 --> Query error: Table 'tmfw_inventory_management_system.trx_pinjam' doesn't exist - Invalid query: SELECT k.*, p.transaksi_no as pinjam_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pinjam p ON k.pinjam_id = p.pinjam_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id WHERE 1 = 1  AND k.deleted_st='0' AND (LOWER(k.transaksi_no) LIKE '%%' OR LOWER(p.transaksi_no) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%')  ORDER BY kembali_id desc LIMIT 10 OFFSET 0
ERROR - 2025-11-15 00:39:40 --> Query error: Table 'tmfw_inventory_management_system.trx_pinjam' doesn't exist - Invalid query: SELECT k.*, p.transaksi_no as pinjam_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pinjam p ON k.pinjam_id = p.pinjam_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id WHERE 1 = 1  AND k.deleted_st='0' AND (LOWER(k.transaksi_no) LIKE '%%' OR LOWER(p.transaksi_no) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%')  ORDER BY kembali_id desc LIMIT 10 OFFSET 0
ERROR - 2025-11-15 00:40:16 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_keluar
ERROR - 2025-11-15 00:40:18 --> Query error: Table 'tmfw_inventory_management_system.trx_pinjam' doesn't exist - Invalid query: SELECT k.*, p.transaksi_no as pinjam_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pinjam p ON k.pinjam_id = p.pinjam_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id WHERE 1 = 1  AND k.deleted_st='0' AND (LOWER(k.transaksi_no) LIKE '%%' OR LOWER(p.transaksi_no) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%')  ORDER BY kembali_id desc LIMIT 10 OFFSET 0
ERROR - 2025-11-15 00:40:26 --> Query error: Table 'tmfw_inventory_management_system.trx_pinjam' doesn't exist - Invalid query: SELECT k.*, p.transaksi_no as pinjam_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pinjam p ON k.pinjam_id = p.pinjam_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id WHERE 1 = 1  AND k.deleted_st='0' AND (LOWER(k.transaksi_no) LIKE '%%' OR LOWER(p.transaksi_no) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%')  ORDER BY kembali_id desc LIMIT 10 OFFSET 0
ERROR - 2025-11-15 00:42:39 --> Query error: Table 'tmfw_inventory_management_system.trx_pinjam' doesn't exist - Invalid query: SELECT k.*, p.transaksi_no as pinjam_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pinjam p ON k.pinjam_id = p.pinjam_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id WHERE 1 = 1  AND k.deleted_st='0' AND (LOWER(k.transaksi_no) LIKE '%%' OR LOWER(p.transaksi_no) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%')  ORDER BY kembali_id desc LIMIT 10 OFFSET 0
ERROR - 2025-11-15 00:43:21 --> Query error: Table 'tmfw_inventory_management_system.trx_pinjam' doesn't exist - Invalid query: SELECT k.*, p.transaksi_no as pinjam_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pinjam p ON k.pinjam_id = p.pinjam_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id WHERE 1 = 1  AND k.deleted_st='0' AND (LOWER(k.transaksi_no) LIKE '%%' OR LOWER(p.transaksi_no) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%')  ORDER BY kembali_id desc LIMIT 10 OFFSET 0
ERROR - 2025-11-15 00:50:40 --> Query error: Unknown column 'k.pakai_id' in 'on clause' - Invalid query: SELECT k.*, p.transaksi_no as pakai_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pakai p ON k.pakai_id = p.pakai_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id WHERE 1 = 1  AND k.deleted_st='0' AND (LOWER(k.transaksi_no) LIKE '%%' OR LOWER(p.transaksi_no) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%')  ORDER BY kembali_id desc LIMIT 10 OFFSET 0
ERROR - 2025-11-15 00:54:02 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_masuk
ERROR - 2025-11-15 00:57:00 --> 404 Page Not Found: ../modules/formulir/controllers//index
ERROR - 2025-11-15 01:50:57 --> Query error: Table 'tmfw_inventory_management_system.trx_pinjam_detail' doesn't exist - Invalid query: SELECT SUM(pinjam_qty - kembali_qty) as sisa_pinjam
FROM `trx_pinjam_detail`
WHERE `pinjam_qty` > `kembali_qty`
ERROR - 2025-11-15 01:52:43 --> Query error: Table 'tmfw_inventory_management_system.trx_pinjam_detail' doesn't exist - Invalid query: SELECT SUM(pinjam_qty - kembali_qty) as sisa_pinjam
FROM `trx_pinjam_detail`
WHERE `pinjam_qty` > `kembali_qty`
ERROR - 2025-11-15 01:55:23 --> 404 Page Not Found: ../modules/asset/controllers/Asset_masuk/tes_db
ERROR - 2025-11-15 01:55:35 --> Query error: Table 'tmfw_inventory_management_system.trx_pinjam_detail' doesn't exist - Invalid query: SELECT SUM(pinjam_qty - kembali_qty) as sisa_pinjam
FROM `trx_pinjam_detail`
WHERE `pinjam_qty` > `kembali_qty`
ERROR - 2025-11-15 01:57:45 --> Query error: Table 'tmfw_inventory_management_system.trx_pinjam_detail' doesn't exist - Invalid query: SELECT SUM(pinjam_qty - kembali_qty) as sisa_pinjam
FROM `trx_pinjam_detail`
WHERE `pinjam_qty` > `kembali_qty`
ERROR - 2025-11-15 02:00:51 --> Query error: Table 'tmfw_inventory_management_system.trx_pinjam' doesn't exist - Invalid query: 
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Masuk' as tipe, 'primary' as warna FROM trx_masuk WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Keluar (Disposal)' as tipe, 'danger' as warna FROM trx_keluar WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Peminjaman' as tipe, 'warning' as warna FROM trx_pinjam WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pengembalian' as tipe, 'success' as warna FROM trx_kembali WHERE deleted_st = 0)
            
            ORDER BY tgl DESC
            LIMIT 10
        
ERROR - 2025-11-15 02:02:30 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_masuk
ERROR - 2025-11-15 02:02:45 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_masuk
ERROR - 2025-11-15 02:02:48 --> 404 Page Not Found: /index
ERROR - 2025-11-15 02:10:44 --> Severity: error --> Exception: Call to undefined function render() C:\laragon\www\tmfw-main\application\modules\asset\controllers\Penyesuaian_kondisi.php 17
ERROR - 2025-11-15 02:11:17 --> Severity: Warning --> Use of undefined constant uri - assumed 'uri' (this will throw an Error in a future version of PHP) C:\laragon\www\tmfw-main\application\modules\asset\views\penyesuaian_kondisi\_js.php 15
ERROR - 2025-11-15 02:11:17 --> Severity: error --> Exception: Object of class MY_Loader could not be converted to string C:\laragon\www\tmfw-main\application\modules\asset\views\penyesuaian_kondisi\_js.php 15
ERROR - 2025-11-15 02:11:24 --> Severity: Warning --> Use of undefined constant uri - assumed 'uri' (this will throw an Error in a future version of PHP) C:\laragon\www\tmfw-main\application\modules\asset\views\penyesuaian_kondisi\_js.php 15
ERROR - 2025-11-15 02:11:24 --> Severity: error --> Exception: Object of class MY_Loader could not be converted to string C:\laragon\www\tmfw-main\application\modules\asset\views\penyesuaian_kondisi\_js.php 15
ERROR - 2025-11-15 02:11:29 --> Severity: Warning --> Use of undefined constant uri - assumed 'uri' (this will throw an Error in a future version of PHP) C:\laragon\www\tmfw-main\application\modules\asset\views\penyesuaian_kondisi\_js.php 15
ERROR - 2025-11-15 02:11:29 --> Severity: error --> Exception: Object of class MY_Loader could not be converted to string C:\laragon\www\tmfw-main\application\modules\asset\views\penyesuaian_kondisi\_js.php 15
ERROR - 2025-11-15 02:12:14 --> Severity: Warning --> Use of undefined constant nav - assumed 'nav' (this will throw an Error in a future version of PHP) C:\laragon\www\tmfw-main\application\modules\asset\views\penyesuaian_kondisi\index.php 8
ERROR - 2025-11-15 02:12:14 --> Severity: Warning --> Illegal string offset 'nav_nm' C:\laragon\www\tmfw-main\application\modules\asset\views\penyesuaian_kondisi\index.php 8
ERROR - 2025-11-15 02:12:14 --> Severity: error --> Exception: Object of class MY_Loader could not be converted to string C:\laragon\www\tmfw-main\application\modules\asset\views\penyesuaian_kondisi\index.php 8
ERROR - 2025-11-15 02:13:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE 1 = 1  AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR ' at line 4 - Invalid query: SELECT l.*, a.asset_kd, a.asset_nm
                  FROM log_asset_kondisi l
                  LEFT JOIN mst_asset a ON l.asset_id = a.asset_id
                  WHERE l.deleted_st = 0 WHERE 1 = 1  AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(l.kondisi_ke) LIKE '%%' OR LOWER(l.transaksi_ket) LIKE '%%')  ORDER BY transaksi_tgl desc LIMIT 500 OFFSET 0
ERROR - 2025-11-15 02:21:21 --> Severity: Notice --> Undefined variable: list_gudang C:\laragon\www\tmfw-main\application\modules\asset\views\penyesuaian_kondisi\form_modal.php 9
ERROR - 2025-11-15 02:21:21 --> Severity: Warning --> Invalid argument supplied for foreach() C:\laragon\www\tmfw-main\application\modules\asset\views\penyesuaian_kondisi\form_modal.php 9
ERROR - 2025-11-15 02:26:11 --> Severity: Notice --> Undefined variable: list_gudang C:\laragon\www\tmfw-main\application\modules\asset\views\penyesuaian_kondisi\form_modal.php 9
ERROR - 2025-11-15 02:26:11 --> Severity: Warning --> Invalid argument supplied for foreach() C:\laragon\www\tmfw-main\application\modules\asset\views\penyesuaian_kondisi\form_modal.php 9
ERROR - 2025-11-15 02:27:31 --> 404 Page Not Found: ../modules/asset/controllers/Penyesuaian_kondisi/get_no_transaksi_ajax
ERROR - 2025-11-15 14:42:52 --> 404 Page Not Found: ../modules/formulir/controllers//index
ERROR - 2025-11-15 14:43:19 --> 404 Page Not Found: ../modules/formulir/controllers//index
ERROR - 2025-11-15 14:45:37 --> 404 Page Not Found: ../modules/formulir/controllers//index
ERROR - 2025-11-15 14:45:41 --> 404 Page Not Found: ../modules/formulir/controllers//index
ERROR - 2025-11-15 14:45:44 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: SELECT k.*, p.transaksi_no as pakai_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pakai p ON k.pakai_id = p.pakai_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id WHERE 1 = 1  AND k.deleted_st='0' AND (LOWER(k.transaksi_no) LIKE '%%' OR LOWER(p.transaksi_no) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%')  ORDER BY kembali_id desc LIMIT 10 OFFSET 0
ERROR - 2025-11-15 14:46:25 --> Query error: Unknown column 's.satuan_id' in 'on clause' - Invalid query: SELECT `s`.`asset_id`, `s`.`stok_qty`, `a`.`asset_nm`, `a`.`asset_kd`, `sat`.`satuan_nm`
FROM `dat_stok` `s`
JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_satuan` `sat` ON `a`.`satuan_id` = `s`.`satuan_id`
WHERE `s`.`gudang_id` = '4'
AND `s`.`stok_qty` > 0
AND `k`.`kategori_tipe` = 'ASET'
ERROR - 2025-11-15 14:46:27 --> Query error: Unknown column 's.satuan_id' in 'on clause' - Invalid query: SELECT `s`.`asset_id`, `s`.`stok_qty`, `a`.`asset_nm`, `a`.`asset_kd`, `sat`.`satuan_nm`
FROM `dat_stok` `s`
JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_satuan` `sat` ON `a`.`satuan_id` = `s`.`satuan_id`
WHERE `s`.`gudang_id` = '5'
AND `s`.`stok_qty` > 0
AND `k`.`kategori_tipe` = 'ASET'
ERROR - 2025-11-15 14:46:29 --> Query error: Unknown column 's.satuan_id' in 'on clause' - Invalid query: SELECT `s`.`asset_id`, `s`.`stok_qty`, `a`.`asset_nm`, `a`.`asset_kd`, `sat`.`satuan_nm`
FROM `dat_stok` `s`
JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_satuan` `sat` ON `a`.`satuan_id` = `s`.`satuan_id`
WHERE `s`.`gudang_id` = '4'
AND `s`.`stok_qty` > 0
AND `k`.`kategori_tipe` = 'ASET'
ERROR - 2025-11-15 14:46:45 --> Query error: Unknown column 's.satuan_id' in 'on clause' - Invalid query: SELECT `s`.`asset_id`, `s`.`stok_qty`, `a`.`asset_nm`, `a`.`asset_kd`, `sat`.`satuan_nm`
FROM `dat_stok` `s`
JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_satuan` `sat` ON `a`.`satuan_id` = `s`.`satuan_id`
WHERE `s`.`gudang_id` = '4'
AND `s`.`stok_qty` > 0
AND `k`.`kategori_tipe` = 'ASET'
ERROR - 2025-11-15 15:06:39 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: SELECT k.*, p.transaksi_no as pakai_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pakai p ON k.pakai_id = p.pakai_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id WHERE 1 = 1  AND k.deleted_st='0' AND (LOWER(k.transaksi_no) LIKE '%%' OR LOWER(p.transaksi_no) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%')  ORDER BY kembali_id desc LIMIT 10 OFFSET 0
ERROR - 2025-11-15 15:11:06 --> Query error: Unknown column 'k.pemakaian_id' in 'on clause' - Invalid query: SELECT k.*, p.transaksi_no as pemakaian_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pemakaian p ON k.pemakaian_id = p.pemakaian_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id WHERE 1 = 1  AND k.deleted_st='0' AND (LOWER(k.transaksi_no) LIKE '%%' OR LOWER(p.transaksi_no) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%')  ORDER BY transaksi_tgl desc LIMIT 500 OFFSET 0
ERROR - 2025-11-15 15:11:14 --> Query error: Unknown column 'k.pemakaian_id' in 'on clause' - Invalid query: SELECT k.*, p.transaksi_no as pemakaian_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pemakaian p ON k.pemakaian_id = p.pemakaian_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id WHERE 1 = 1  AND k.deleted_st='0' AND (LOWER(k.transaksi_no) LIKE '%%' OR LOWER(p.transaksi_no) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%')  ORDER BY transaksi_tgl desc LIMIT 500 OFFSET 0
ERROR - 2025-11-15 15:14:05 --> Query error: Unknown column 'pemakaian_detail_id' in 'field list' - Invalid query: INSERT INTO `trx_kembali_detail` (`kembali_id`, `pemakaian_detail_id`, `gudang_id`, `kembali_qty`, `kondisi_asset`, `created_at`) VALUES (3, '5', '4', 1, 'BAIK', '2025-11-15 15:14:05')
ERROR - 2025-11-15 15:14:10 --> Query error: Unknown column 'pemakaian_detail_id' in 'field list' - Invalid query: INSERT INTO `trx_kembali_detail` (`kembali_id`, `pemakaian_detail_id`, `gudang_id`, `kembali_qty`, `kondisi_asset`, `created_at`) VALUES (4, '5', '4', 1, 'BAIK', '2025-11-15 15:14:10')
ERROR - 2025-11-15 15:19:10 --> 404 Page Not Found: ../modules/asset/controllers/Penyesuaian_kondisi/get_no_transaksi_ajax
ERROR - 2025-11-15 15:26:31 --> 404 Page Not Found: ../modules/asset/controllers/Penyesuaian_kondisi/get_no_transaksi_ajax
ERROR - 2025-11-15 15:27:06 --> 404 Page Not Found: ../modules/asset/controllers/Penyesuaian_kondisi/get_no_transaksi_ajax
ERROR - 2025-11-15 15:27:22 --> 404 Page Not Found: ../modules/asset/controllers/Penyesuaian_kondisi/get_no_transaksi_ajax
ERROR - 2025-11-15 15:28:24 --> 404 Page Not Found: ../modules/asset/controllers/Penyesuaian_kondisi/get_no_transaksi_ajax
ERROR - 2025-11-15 15:28:24 --> 404 Page Not Found: ../modules/asset/controllers/Penyesuaian_kondisi/get_no_transaksi_ajax
ERROR - 2025-11-15 15:28:25 --> 404 Page Not Found: ../modules/asset/controllers/Penyesuaian_kondisi/get_no_transaksi_ajax
ERROR - 2025-11-15 15:28:25 --> 404 Page Not Found: ../modules/asset/controllers/Penyesuaian_kondisi/get_no_transaksi_ajax
ERROR - 2025-11-15 16:45:00 --> Severity: Warning --> Use of undefined constant table - assumed 'table' (this will throw an Error in a future version of PHP) C:\laragon\www\tmfw-main\application\modules\asset\models\M_penyesuaian_kondisi.php 48
ERROR - 2025-11-15 16:45:00 --> Severity: error --> Exception: Object of class M_penyesuaian_kondisi could not be converted to string C:\laragon\www\tmfw-main\application\modules\asset\models\M_penyesuaian_kondisi.php 48
ERROR - 2025-11-15 16:45:17 --> Severity: Warning --> Use of undefined constant table - assumed 'table' (this will throw an Error in a future version of PHP) C:\laragon\www\tmfw-main\application\modules\asset\models\M_penyesuaian_kondisi.php 48
ERROR - 2025-11-15 16:45:17 --> Severity: error --> Exception: Object of class M_penyesuaian_kondisi could not be converted to string C:\laragon\www\tmfw-main\application\modules\asset\models\M_penyesuaian_kondisi.php 48
ERROR - 2025-11-15 16:57:41 --> 404 Page Not Found: /index
ERROR - 2025-11-15 17:41:59 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-15 17:42:58 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-15 17:45:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE 1 = 1  AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR ' at line 7 - Invalid query: SELECT 
                a.*, b.all_data_st 
              FROM app_nav a
              JOIN app_permission b ON a.nav_id = b.nav_id
              WHERE 
                b.role_id = '01.01'
                AND md5(a.nav_id) = 'e98dbd9036bb8976e79d77cb95e29892' WHERE 1 = 1  AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(a.asset_kondisi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-15 17:45:07 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE 1 = 1  AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR ' at line 7 - Invalid query: SELECT 
                a.*, b.all_data_st 
              FROM app_nav a
              JOIN app_permission b ON a.nav_id = b.nav_id
              WHERE 
                b.role_id = '01.01'
                AND md5(a.nav_id) = 'e98dbd9036bb8976e79d77cb95e29892' WHERE 1 = 1  AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(a.asset_kondisi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-15 17:51:30 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE 1 = 1  AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR ' at line 6 - Invalid query: SELECT a.*, s.satuan_nm
                  FROM mst_asset a
                  JOIN mst_kategori k ON a.kategori_id = k.kategori_id
                  LEFT JOIN mst_satuan s ON a.satuan_id = s.satuan_id
                  WHERE k.kategori_kd = 'GG' 
                  AND a.deleted_st = 0 WHERE 1 = 1  AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(a.asset_kondisi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-15 17:53:55 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\list\views\list_gedung\detail_modal.php 2
ERROR - 2025-11-15 17:53:55 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\list\views\list_gedung\detail_modal.php 10
ERROR - 2025-11-15 17:53:55 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\list\views\list_gedung\detail_modal.php 11
ERROR - 2025-11-15 17:53:55 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\list\views\list_gedung\detail_modal.php 12
ERROR - 2025-11-15 17:53:55 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\list\views\list_gedung\detail_modal.php 15
ERROR - 2025-11-15 17:53:55 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\list\views\list_gedung\detail_modal.php 15
ERROR - 2025-11-15 17:53:55 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\list\views\list_gedung\detail_modal.php 16
ERROR - 2025-11-15 17:53:55 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\list\views\list_gedung\detail_modal.php 20
ERROR - 2025-11-15 17:55:57 --> Severity: error --> Exception: Call to a member function segment() on string C:\laragon\www\tmfw-main\application\modules\list\views\list_gedung\detail_modal.php 11
ERROR - 2025-11-15 18:04:19 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE 1 = 1  AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR ' at line 7 - Invalid query: SELECT 
                a.*, b.all_data_st 
              FROM app_nav a
              JOIN app_permission b ON a.nav_id = b.nav_id
              WHERE 
                b.role_id = '01.01'
                AND md5(a.nav_id) = 'e98dbd9036bb8976e79d77cb95e29892' WHERE 1 = 1  AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(g.gudang_alm) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-15 20:29:12 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') as alamat

            FROM mst_asset a
            JOIN mst_kategori k ON ' at line 6 - Invalid query: 
            SELECT COUNT(1) AS count FROM dat_asset_value v 
                    JOIN mst_kategori_atribut attr ON v.atribut_id = attr.atribut_id
                    WHERE v.asset_id = a.asset_id 
                    AND attr.atribut_label LIKE '%Alamat%' -- Mencari label yang mengandung kata 'Alamat'
                    LIMIT 1
                ) as alamat

            FROM mst_asset a
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id
            LEFT JOIN mst_satuan s ON a.satuan_id = s.satuan_id
         WHERE 1 = 1  AND k.kategori_kd='GDG' AND a.deleted_st='0'
ERROR - 2025-11-15 20:29:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') as alamat

            FROM mst_asset a
            JOIN mst_kategori k ON ' at line 6 - Invalid query: 
            SELECT COUNT(1) AS count FROM dat_asset_value v 
                    JOIN mst_kategori_atribut attr ON v.atribut_id = attr.atribut_id
                    WHERE v.asset_id = a.asset_id 
                    AND attr.atribut_label LIKE '%Alamat%' -- Mencari label yang mengandung kata 'Alamat'
                    LIMIT 1
                ) as alamat

            FROM mst_asset a
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id
            LEFT JOIN mst_satuan s ON a.satuan_id = s.satuan_id
         WHERE 1 = 1  AND k.kategori_kd='GDG' AND a.deleted_st='0'
ERROR - 2025-11-15 21:23:53 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-15 21:27:52 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'K2', 'K4')' AND 1='a.deleted_st = 0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a' at line 25 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_thn_beli,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- Ambil Lokasi Terakhir (Gudang)
                g.gudang_nm as lokasi,

                -- [KHUSUS KENDARAAN] Ambil No. Polisi
                v_nopol.value_isi as nopol

            FROM mst_asset a
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id
            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id

            -- JOIN KHUSUS UNTUK NO. POLISI
            -- Mencari atribut yang labelnya mengandung kata 'Polisi' (Cth: No. Polisi)
            LEFT JOIN mst_kategori_atribut attr_nopol ON attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'
            LEFT JOIN dat_asset_value v_nopol ON v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id
         WHERE 1 = 1  AND 0='k.kategori_kd IN ('K2', 'K4')' AND 1='a.deleted_st = 0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_nopol.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-15 21:28:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'K2', 'K4')' AND 1='a.deleted_st = 0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a' at line 25 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_thn_beli,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- Ambil Lokasi Terakhir (Gudang)
                g.gudang_nm as lokasi,

                -- [KHUSUS KENDARAAN] Ambil No. Polisi
                v_nopol.value_isi as nopol

            FROM mst_asset a
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id
            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id

            -- JOIN KHUSUS UNTUK NO. POLISI
            -- Mencari atribut yang labelnya mengandung kata 'Polisi' (Cth: No. Polisi)
            LEFT JOIN mst_kategori_atribut attr_nopol ON attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'
            LEFT JOIN dat_asset_value v_nopol ON v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id
         WHERE 1 = 1  AND 0='k.kategori_kd IN ('K2', 'K4')' AND 1='a.deleted_st = 0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_nopol.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-15 21:56:11 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE 1 = 1  AND 0='k.kategori_kd IN ('K2', 'K4')' AND 1='a.deleted_st = 0' AND ' at line 55 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- Gabungkan Bulan/Tahun Beli
                CONCAT(LPAD(a.asset_bln_beli, 2, '0'), '/', a.asset_thn_beli) as tgl_beli,

                -- Data Kustom (Diambil via JOIN di bawah)
                v_merek.value_isi as merk,
                v_seri.value_isi as seri,
                v_warna.value_isi as warna,
                v_nopol.value_isi as nopol,
                v_bpkb.value_isi as bpkb,

                -- Data Penanggungjawab (Peminjam saat ini - Status OPEN)
                COALESCE(pg.pegawai_nm, g.pic_nm, '-') as penanggungjawab,
                COALESCE(pg.pegawai_jabatan, 'Kepala Gudang') as jabatan,

                -- Data Dummy (Placeholder untuk menu Perawatan nanti)
                '-' as service_terakhir,
                '-' as pajak_kendaraan

            FROM mst_asset a
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id
            
            -- 1. JOIN ATRIBUT KUSTOM (Satu per satu)
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label = 'Merek'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_seri ON attr_seri.kategori_id = a.kategori_id AND (attr_seri.atribut_label LIKE 'Seri%' OR attr_seri.atribut_label LIKE 'Model%')
            LEFT JOIN dat_asset_value v_seri ON v_seri.asset_id = a.asset_id AND v_seri.atribut_id = attr_seri.atribut_id

            LEFT JOIN mst_kategori_atribut attr_warna ON attr_warna.kategori_id = a.kategori_id AND attr_warna.atribut_label = 'Warna'
            LEFT JOIN dat_asset_value v_warna ON v_warna.asset_id = a.asset_id AND v_warna.atribut_id = attr_warna.atribut_id

            LEFT JOIN mst_kategori_atribut attr_nopol ON attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'
            LEFT JOIN dat_asset_value v_nopol ON v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id

            LEFT JOIN mst_kategori_atribut attr_bpkb ON attr_bpkb.kategori_id = a.kategori_id AND attr_bpkb.atribut_label LIKE '%BPKB%'
            LEFT JOIN dat_asset_value v_bpkb ON v_bpkb.asset_id = a.asset_id AND v_bpkb.atribut_id = attr_bpkb.atribut_id

            -- 2. JOIN SIRKULASI (Cek siapa yang pegang barang)
            -- Cek trx_pemakaian yang statusnya OPEN
            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id

            -- 3. JOIN GUDANG (Jika tidak dipinjam, maka di Gudang)
            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id
         GROUP BY a.asset_id WHERE 1 = 1  AND 0='k.kategori_kd IN ('K2', 'K4')' AND 1='a.deleted_st = 0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_nopol.value_isi) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-15 21:56:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE 1 = 1  AND 0='k.kategori_kd IN ('K2', 'K4')' AND 1='a.deleted_st = 0' AND ' at line 55 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- Gabungkan Bulan/Tahun Beli
                CONCAT(LPAD(a.asset_bln_beli, 2, '0'), '/', a.asset_thn_beli) as tgl_beli,

                -- Data Kustom (Diambil via JOIN di bawah)
                v_merek.value_isi as merk,
                v_seri.value_isi as seri,
                v_warna.value_isi as warna,
                v_nopol.value_isi as nopol,
                v_bpkb.value_isi as bpkb,

                -- Data Penanggungjawab (Peminjam saat ini - Status OPEN)
                COALESCE(pg.pegawai_nm, g.pic_nm, '-') as penanggungjawab,
                COALESCE(pg.pegawai_jabatan, 'Kepala Gudang') as jabatan,

                -- Data Dummy (Placeholder untuk menu Perawatan nanti)
                '-' as service_terakhir,
                '-' as pajak_kendaraan

            FROM mst_asset a
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id
            
            -- 1. JOIN ATRIBUT KUSTOM (Satu per satu)
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label = 'Merek'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_seri ON attr_seri.kategori_id = a.kategori_id AND (attr_seri.atribut_label LIKE 'Seri%' OR attr_seri.atribut_label LIKE 'Model%')
            LEFT JOIN dat_asset_value v_seri ON v_seri.asset_id = a.asset_id AND v_seri.atribut_id = attr_seri.atribut_id

            LEFT JOIN mst_kategori_atribut attr_warna ON attr_warna.kategori_id = a.kategori_id AND attr_warna.atribut_label = 'Warna'
            LEFT JOIN dat_asset_value v_warna ON v_warna.asset_id = a.asset_id AND v_warna.atribut_id = attr_warna.atribut_id

            LEFT JOIN mst_kategori_atribut attr_nopol ON attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'
            LEFT JOIN dat_asset_value v_nopol ON v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id

            LEFT JOIN mst_kategori_atribut attr_bpkb ON attr_bpkb.kategori_id = a.kategori_id AND attr_bpkb.atribut_label LIKE '%BPKB%'
            LEFT JOIN dat_asset_value v_bpkb ON v_bpkb.asset_id = a.asset_id AND v_bpkb.atribut_id = attr_bpkb.atribut_id

            -- 2. JOIN SIRKULASI (Cek siapa yang pegang barang)
            -- Cek trx_pemakaian yang statusnya OPEN
            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id

            -- 3. JOIN GUDANG (Jika tidak dipinjam, maka di Gudang)
            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id
         GROUP BY a.asset_id WHERE 1 = 1  AND 0='k.kategori_kd IN ('K2', 'K4')' AND 1='a.deleted_st = 0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_nopol.value_isi) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-15 21:56:49 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE 1 = 1  AND 0='k.kategori_kd IN ('K2', 'K4')' AND 1='a.deleted_st = 0' AND ' at line 55 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- Gabungkan Bulan/Tahun Beli
                CONCAT(LPAD(a.asset_bln_beli, 2, '0'), '/', a.asset_thn_beli) as tgl_beli,

                -- Data Kustom (Diambil via JOIN di bawah)
                v_merek.value_isi as merk,
                v_seri.value_isi as seri,
                v_warna.value_isi as warna,
                v_nopol.value_isi as nopol,
                v_bpkb.value_isi as bpkb,

                -- Data Penanggungjawab (Peminjam saat ini - Status OPEN)
                COALESCE(pg.pegawai_nm, g.pic_nm, '-') as penanggungjawab,
                COALESCE(pg.pegawai_jabatan, 'Kepala Gudang') as jabatan,

                -- Data Dummy (Placeholder untuk menu Perawatan nanti)
                '-' as service_terakhir,
                '-' as pajak_kendaraan

            FROM mst_asset a
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id
            
            -- 1. JOIN ATRIBUT KUSTOM (Satu per satu)
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label = 'Merek'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_seri ON attr_seri.kategori_id = a.kategori_id AND (attr_seri.atribut_label LIKE 'Seri%' OR attr_seri.atribut_label LIKE 'Model%')
            LEFT JOIN dat_asset_value v_seri ON v_seri.asset_id = a.asset_id AND v_seri.atribut_id = attr_seri.atribut_id

            LEFT JOIN mst_kategori_atribut attr_warna ON attr_warna.kategori_id = a.kategori_id AND attr_warna.atribut_label = 'Warna'
            LEFT JOIN dat_asset_value v_warna ON v_warna.asset_id = a.asset_id AND v_warna.atribut_id = attr_warna.atribut_id

            LEFT JOIN mst_kategori_atribut attr_nopol ON attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'
            LEFT JOIN dat_asset_value v_nopol ON v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id

            LEFT JOIN mst_kategori_atribut attr_bpkb ON attr_bpkb.kategori_id = a.kategori_id AND attr_bpkb.atribut_label LIKE '%BPKB%'
            LEFT JOIN dat_asset_value v_bpkb ON v_bpkb.asset_id = a.asset_id AND v_bpkb.atribut_id = attr_bpkb.atribut_id

            -- 2. JOIN SIRKULASI (Cek siapa yang pegang barang)
            -- Cek trx_pemakaian yang statusnya OPEN
            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id

            -- 3. JOIN GUDANG (Jika tidak dipinjam, maka di Gudang)
            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id
         GROUP BY a.asset_id WHERE 1 = 1  AND 0='k.kategori_kd IN ('K2', 'K4')' AND 1='a.deleted_st = 0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_nopol.value_isi) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-15 21:57:03 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE 1 = 1  AND 0='k.kategori_kd IN ('K2', 'K4')' AND 1='a.deleted_st = 0' AND ' at line 55 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- Gabungkan Bulan/Tahun Beli
                CONCAT(LPAD(a.asset_bln_beli, 2, '0'), '/', a.asset_thn_beli) as tgl_beli,

                -- Data Kustom (Diambil via JOIN di bawah)
                v_merek.value_isi as merk,
                v_seri.value_isi as seri,
                v_warna.value_isi as warna,
                v_nopol.value_isi as nopol,
                v_bpkb.value_isi as bpkb,

                -- Data Penanggungjawab (Peminjam saat ini - Status OPEN)
                COALESCE(pg.pegawai_nm, g.pic_nm, '-') as penanggungjawab,
                COALESCE(pg.pegawai_jabatan, 'Kepala Gudang') as jabatan,

                -- Data Dummy (Placeholder untuk menu Perawatan nanti)
                '-' as service_terakhir,
                '-' as pajak_kendaraan

            FROM mst_asset a
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id
            
            -- 1. JOIN ATRIBUT KUSTOM (Satu per satu)
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label = 'Merek'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_seri ON attr_seri.kategori_id = a.kategori_id AND (attr_seri.atribut_label LIKE 'Seri%' OR attr_seri.atribut_label LIKE 'Model%')
            LEFT JOIN dat_asset_value v_seri ON v_seri.asset_id = a.asset_id AND v_seri.atribut_id = attr_seri.atribut_id

            LEFT JOIN mst_kategori_atribut attr_warna ON attr_warna.kategori_id = a.kategori_id AND attr_warna.atribut_label = 'Warna'
            LEFT JOIN dat_asset_value v_warna ON v_warna.asset_id = a.asset_id AND v_warna.atribut_id = attr_warna.atribut_id

            LEFT JOIN mst_kategori_atribut attr_nopol ON attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'
            LEFT JOIN dat_asset_value v_nopol ON v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id

            LEFT JOIN mst_kategori_atribut attr_bpkb ON attr_bpkb.kategori_id = a.kategori_id AND attr_bpkb.atribut_label LIKE '%BPKB%'
            LEFT JOIN dat_asset_value v_bpkb ON v_bpkb.asset_id = a.asset_id AND v_bpkb.atribut_id = attr_bpkb.atribut_id

            -- 2. JOIN SIRKULASI (Cek siapa yang pegang barang)
            -- Cek trx_pemakaian yang statusnya OPEN
            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id

            -- 3. JOIN GUDANG (Jika tidak dipinjam, maka di Gudang)
            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id
         GROUP BY a.asset_id WHERE 1 = 1  AND 0='k.kategori_kd IN ('K2', 'K4')' AND 1='a.deleted_st = 0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_nopol.value_isi) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-15 22:05:30 --> Query error: Unknown column 'pg.pegawai_jabatan' in 'field list' - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- Gabungkan Bulan/Tahun Beli
                CONCAT(LPAD(a.asset_bln_beli, 2, '0'), '/', a.asset_thn_beli) as tgl_beli,

                -- Data Kustom (Diambil via JOIN di bawah)
                v_merek.value_isi as merk,
                v_seri.value_isi as seri,
                v_warna.value_isi as warna,
                v_nopol.value_isi as nopol,
                v_bpkb.value_isi as bpkb,

                -- Data Penanggungjawab (Peminjam saat ini - Status OPEN)
                COALESCE(pg.pegawai_nm, g.pic_nm, '-') as penanggungjawab,
                COALESCE(pg.pegawai_jabatan, 'Kepala Gudang') as jabatan,

                -- Data Dummy (Placeholder)
                '-' as service_terakhir,
                '-' as pajak_kendaraan

            FROM mst_asset a
            
            -- [FIX 1] Filter Kategori K2 & K4 dipindah ke JOIN
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd IN ('K2', 'K4')
            
            -- 1. JOIN ATRIBUT KUSTOM
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label = 'Merek'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_seri ON attr_seri.kategori_id = a.kategori_id AND (attr_seri.atribut_label LIKE 'Seri%' OR attr_seri.atribut_label LIKE 'Model%')
            LEFT JOIN dat_asset_value v_seri ON v_seri.asset_id = a.asset_id AND v_seri.atribut_id = attr_seri.atribut_id

            LEFT JOIN mst_kategori_atribut attr_warna ON attr_warna.kategori_id = a.kategori_id AND attr_warna.atribut_label = 'Warna'
            LEFT JOIN dat_asset_value v_warna ON v_warna.asset_id = a.asset_id AND v_warna.atribut_id = attr_warna.atribut_id

            LEFT JOIN mst_kategori_atribut attr_nopol ON attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'
            LEFT JOIN dat_asset_value v_nopol ON v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id

            LEFT JOIN mst_kategori_atribut attr_bpkb ON attr_bpkb.kategori_id = a.kategori_id AND attr_bpkb.atribut_label LIKE '%BPKB%'
            LEFT JOIN dat_asset_value v_bpkb ON v_bpkb.asset_id = a.asset_id AND v_bpkb.atribut_id = attr_bpkb.atribut_id

            -- 2. JOIN SIRKULASI (Cek siapa yang pegang barang)
            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id

            -- 3. JOIN GUDANG (Jika tidak dipinjam, maka di Gudang)
            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id
         WHERE 1 = 1  AND a.deleted_st='0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_nopol.value_isi) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
