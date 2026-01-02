<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-01-02 10:31:13 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '// <--- Wajib ada
                    a.spesifikasi,   // <--- Wajib ada
     ' at line 5 - Invalid query: SELECT 
                    s.*, 
                    a.asset_nm, 
                    a.asset_kd,
                    a.merk,          // <--- Wajib ada
                    a.spesifikasi,   // <--- Wajib ada
                    k.kategori_nm,
                    k.kategori_kd
                  FROM dat_service s
                  LEFT JOIN mst_asset a ON s.asset_id = a.asset_id
                  LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id WHERE 1 = 1  AND s.deleted_st='0' AND (LOWER(s.bengkel_nm) LIKE '%%' OR LOWER(s.keterangan_txt) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(a.asset_kd) LIKE '%%')  ORDER BY asset_kd desc LIMIT 10 OFFSET 0
ERROR - 2026-01-02 10:31:38 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '// <--- Wajib ada
                    a.spesifikasi,   // <--- Wajib ada
     ' at line 5 - Invalid query: SELECT 
                    s.*, 
                    a.asset_nm, 
                    a.asset_kd,
                    a.merk,          // <--- Wajib ada
                    a.spesifikasi,   // <--- Wajib ada
                    k.kategori_nm,
                    k.kategori_kd
                  FROM dat_service s
                  LEFT JOIN mst_asset a ON s.asset_id = a.asset_id
                  LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id WHERE 1 = 1  AND s.deleted_st='0' AND (LOWER(s.bengkel_nm) LIKE '%%' OR LOWER(s.keterangan_txt) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(a.asset_kd) LIKE '%%')  ORDER BY asset_kd desc LIMIT 10 OFFSET 0
ERROR - 2026-01-02 10:32:23 --> Query error: Unknown column 'a.merk' in 'field list' - Invalid query: SELECT 
                    s.*, 
                    a.asset_nm, 
                    a.asset_kd,
                    a.merk,
                    a.spesifikasi,   
                    k.kategori_nm,
                    k.kategori_kd
                  FROM dat_service s
                  LEFT JOIN mst_asset a ON s.asset_id = a.asset_id
                  LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id WHERE 1 = 1  AND s.deleted_st='0' AND (LOWER(s.bengkel_nm) LIKE '%%' OR LOWER(s.keterangan_txt) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(a.asset_kd) LIKE '%%')  ORDER BY asset_kd desc LIMIT 10 OFFSET 0
ERROR - 2026-01-02 10:34:01 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '// <--- Wajib ada (sesuai permintaan JS)
            a.spesifikasi, // <--- Waj' at line 1 - Invalid query: SELECT `s`.*, `a`.`asset_nm`, `a`.`asset_kd`, `a`.`merk`, // <--- Wajib ada (sesuai permintaan JS)
            a.spesifikasi, // <--- Wajib ada (sesuai permintaan JS)
            k.kategori_nm, `k`.`kategori_kd`
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
WHERE `s`.`deleted_st` = 0
ORDER BY `s`.`tgl_service` DESC
 LIMIT 10
ERROR - 2026-01-02 10:59:02 --> Severity: error --> Exception: Call to undefined method M_riwayat_service::get_all_kategori() C:\laragon\www\tmfw-main\application\modules\laporan\controllers\Riwayat_service.php 35
ERROR - 2026-01-02 10:59:13 --> Severity: error --> Exception: Call to undefined method M_riwayat_service::get_all_kategori() C:\laragon\www\tmfw-main\application\modules\laporan\controllers\Riwayat_service.php 35
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined variable: list_kategori C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 11
ERROR - 2026-01-02 10:59:46 --> Severity: Warning --> Invalid argument supplied for foreach() C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 11
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 10:59:46 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined variable: list_kategori C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 11
ERROR - 2026-01-02 11:00:26 --> Severity: Warning --> Invalid argument supplied for foreach() C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 11
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:00:26 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:00:37 --> Severity: error --> Exception: Call to undefined method M_riwayat_service::get_all_kategori() C:\laragon\www\tmfw-main\application\modules\laporan\controllers\Riwayat_service.php 35
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:02:05 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:03:33 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:06:20 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:25:48 --> 404 Page Not Found: ../modules/laporan/controllers/Riwayat_service/get_list_asset_by_kategori
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:26:31 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 26
ERROR - 2026-01-02 11:28:11 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 27
