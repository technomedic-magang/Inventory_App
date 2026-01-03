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
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:19:04 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:20:23 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:36:10 --> Query error: Unknown column 'pegawai_id' in 'where clause' - Invalid query: SELECT *
FROM `app_permission`
WHERE `pegawai_id` = '000000000000'
AND `nav_id` = '08.03'
ERROR - 2026-01-02 14:36:43 --> Severity: error --> Exception: Unable to locate the model you have specified: M_perbaikan_aset C:\laragon\www\tmfw-main\system\core\Loader.php 348
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_kd C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 29
ERROR - 2026-01-02 14:46:49 --> Severity: Notice --> Undefined index: kategori_id C:\laragon\www\tmfw-main\application\modules\laporan\views\riwayat_service\form_modal.php 30
ERROR - 2026-01-02 14:54:19 --> Severity: error --> Exception: Call to undefined method M_perbaikan_aset::get_all_assets() C:\laragon\www\tmfw-main\application\modules\laporan\controllers\Perbaikan_aset.php 48
ERROR - 2026-01-02 14:54:24 --> Severity: error --> Exception: Call to undefined method M_perbaikan_aset::get_all_assets() C:\laragon\www\tmfw-main\application\modules\laporan\controllers\Perbaikan_aset.php 48
ERROR - 2026-01-02 14:56:01 --> Severity: Notice --> Undefined variable: id C:\laragon\www\tmfw-main\application\modules\laporan\views\perbaikan_aset\form_modal.php 10
ERROR - 2026-01-02 15:33:33 --> The upload path does not appear to be valid.
ERROR - 2026-01-02 15:33:39 --> The upload path does not appear to be valid.
ERROR - 2026-01-02 15:37:13 --> 404 Page Not Found: /index
ERROR - 2026-01-02 21:08:06 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_' at line 2 - Invalid query: SELECT s.*, CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0')) AS tiket_perbaikan, -- Alias kolom untuk Datatables a.asset_nm, a.asset_kd, v_merk.value_isi AS merk, v_spek.value_isi AS spesifikasi, k.kategori_nm, k.kategori_kd
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `dat_asset_value` `v_merk` ON `v_merk`.`asset_id` = `a`.`asset_id` AND `v_merk`.`atribut_id` = 128 AND `v_merk`.`active_st` = 1
LEFT JOIN `dat_asset_value` `v_spek` ON `v_spek`.`asset_id` = `a`.`asset_id` AND `v_spek`.`atribut_id` = 129 AND `v_spek`.`active_st` = 1
WHERE `s`.`deleted_st` = 0
ORDER BY `s`.`created_at` DESC
 LIMIT 10
ERROR - 2026-01-02 21:08:38 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_' at line 2 - Invalid query: SELECT s.*, CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0')) AS tiket_perbaikan, -- Alias kolom untuk Datatables a.asset_nm, a.asset_kd, v_merk.value_isi AS merk, v_spek.value_isi AS spesifikasi, k.kategori_nm, k.kategori_kd
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `dat_asset_value` `v_merk` ON `v_merk`.`asset_id` = `a`.`asset_id` AND `v_merk`.`atribut_id` = 128 AND `v_merk`.`active_st` = 1
LEFT JOIN `dat_asset_value` `v_spek` ON `v_spek`.`asset_id` = `a`.`asset_id` AND `v_spek`.`atribut_id` = 129 AND `v_spek`.`active_st` = 1
WHERE `s`.`deleted_st` = 0
ORDER BY `s`.`created_at` DESC
 LIMIT 10
ERROR - 2026-01-02 22:39:26 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '.user_nama AS pelapor_nm
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`' at line 1 - Invalid query: SELECT s.*, CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0')) AS tiket_perbaikan, a.asset_nm, a.asset_kd, v_merk.value_isi AS merk, v_spek.value_isi AS spesifikasi, k.kategori_nm, k.kategori_kd u.user_nama AS pelapor_nm
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `sys_user` `u` ON `s`.`pelapor_id` = `u`.`user_id`
LEFT JOIN `dat_asset_value` `v_merk` ON `v_merk`.`asset_id` = `a`.`asset_id` AND `v_merk`.`atribut_id` = 128 AND `v_merk`.`active_st` = 1
LEFT JOIN `dat_asset_value` `v_spek` ON `v_spek`.`asset_id` = `a`.`asset_id` AND `v_spek`.`atribut_id` = 129 AND `v_spek`.`active_st` = 1
WHERE `s`.`deleted_st` = 0
ORDER BY `s`.`created_at` DESC
 LIMIT 10
ERROR - 2026-01-02 22:41:35 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '.user_nama AS pelapor_nm
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`' at line 1 - Invalid query: SELECT s.*, CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0')) AS tiket_perbaikan, a.asset_nm, a.asset_kd, v_merk.value_isi AS merk, v_spek.value_isi AS spesifikasi, k.kategori_nm, k.kategori_kd u.user_nama AS pelapor_nm
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `sys_user` `u` ON `s`.`pelapor_id` = `u`.`user_id`
LEFT JOIN `dat_asset_value` `v_merk` ON `v_merk`.`asset_id` = `a`.`asset_id` AND `v_merk`.`atribut_id` = 128 AND `v_merk`.`active_st` = 1
LEFT JOIN `dat_asset_value` `v_spek` ON `v_spek`.`asset_id` = `a`.`asset_id` AND `v_spek`.`atribut_id` = 129 AND `v_spek`.`active_st` = 1
WHERE `s`.`deleted_st` = 0
ORDER BY `s`.`created_at` DESC
 LIMIT 10
ERROR - 2026-01-02 22:46:49 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_' at line 2 - Invalid query: SELECT s.*, CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0')) AS tiket_perbaikan, -- Alias untuk Tiket a.asset_nm, a.asset_kd, v_merk.value_isi AS merk, v_spek.value_isi AS spesifikasi, k.kategori_nm, k.kategori_kd, u.user_nama AS pelapor_nm -- Alias untuk Nama Pelapor
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `sys_user` `u` ON `s`.`pelapor_id` = `u`.`user_id`
LEFT JOIN `dat_asset_value` `v_merk` ON `v_merk`.`asset_id` = `a`.`asset_id` AND `v_merk`.`atribut_id` = 128 AND `v_merk`.`active_st` = 1
LEFT JOIN `dat_asset_value` `v_spek` ON `v_spek`.`asset_id` = `a`.`asset_id` AND `v_spek`.`atribut_id` = 129 AND `v_spek`.`active_st` = 1
WHERE `s`.`deleted_st` = 0
ORDER BY `s`.`created_at` DESC
 LIMIT 10
ERROR - 2026-01-02 22:47:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_' at line 2 - Invalid query: SELECT s.*, CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0')) AS tiket_perbaikan, -- Alias untuk Tiket a.asset_nm, a.asset_kd, v_merk.value_isi AS merk, v_spek.value_isi AS spesifikasi, k.kategori_nm, k.kategori_kd, u.user_nama AS pelapor_nm -- Alias untuk Nama Pelapor
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `sys_user` `u` ON `s`.`pelapor_id` = `u`.`user_id`
LEFT JOIN `dat_asset_value` `v_merk` ON `v_merk`.`asset_id` = `a`.`asset_id` AND `v_merk`.`atribut_id` = 128 AND `v_merk`.`active_st` = 1
LEFT JOIN `dat_asset_value` `v_spek` ON `v_spek`.`asset_id` = `a`.`asset_id` AND `v_spek`.`atribut_id` = 129 AND `v_spek`.`active_st` = 1
WHERE `s`.`deleted_st` = 0
ORDER BY `s`.`created_at` DESC
 LIMIT 10
ERROR - 2026-01-02 22:49:51 --> Query error: Table 'tmfw_inventory_management_system.sys_user' doesn't exist - Invalid query: SELECT s.*, CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0')) AS tiket_perbaikan, a.asset_nm, a.asset_kd, v_merk.value_isi AS merk, v_spek.value_isi AS spesifikasi, k.kategori_nm, k.kategori_kd, u.user_nama AS pelapor_nm
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `sys_user` `u` ON `s`.`pelapor_id` = `u`.`user_id`
LEFT JOIN `dat_asset_value` `v_merk` ON `v_merk`.`asset_id` = `a`.`asset_id` AND `v_merk`.`atribut_id` = 128 AND `v_merk`.`active_st` = 1
LEFT JOIN `dat_asset_value` `v_spek` ON `v_spek`.`asset_id` = `a`.`asset_id` AND `v_spek`.`atribut_id` = 129 AND `v_spek`.`active_st` = 1
WHERE `s`.`deleted_st` = 0
ORDER BY `s`.`created_at` DESC
 LIMIT 10
ERROR - 2026-01-02 22:51:02 --> Query error: Table 'tmfw_inventory_management_system.sys_user' doesn't exist - Invalid query: SELECT s.*, CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0')) AS tiket_perbaikan, a.asset_nm, a.asset_kd, v_merk.value_isi AS merk, v_spek.value_isi AS spesifikasi, k.kategori_nm, k.kategori_kd, u.user_nama AS pelapor_nm
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `sys_user` `u` ON `s`.`pelapor_id` = `u`.`user_id`
LEFT JOIN `dat_asset_value` `v_merk` ON `v_merk`.`asset_id` = `a`.`asset_id` AND `v_merk`.`atribut_id` = 128 AND `v_merk`.`active_st` = 1
LEFT JOIN `dat_asset_value` `v_spek` ON `v_spek`.`asset_id` = `a`.`asset_id` AND `v_spek`.`atribut_id` = 129 AND `v_spek`.`active_st` = 1
WHERE `s`.`deleted_st` = 0
ORDER BY `s`.`created_at` DESC
 LIMIT 10
ERROR - 2026-01-02 22:58:06 --> Query error: Table 'tmfw_inventory_management_system.mst_user' doesn't exist - Invalid query: SELECT s.*, CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0')) AS tiket_perbaikan, a.asset_nm, a.asset_kd, v_merk.value_isi AS merk, v_spek.value_isi AS spesifikasi, k.kategori_nm, k.kategori_kd, u.user_nama AS pelapor_nm
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_user` `u` ON `s`.`pelapor_id` = `u`.`user_id`
LEFT JOIN `dat_asset_value` `v_merk` ON `v_merk`.`asset_id` = `a`.`asset_id` AND `v_merk`.`atribut_id` = 128 AND `v_merk`.`active_st` = 1
LEFT JOIN `dat_asset_value` `v_spek` ON `v_spek`.`asset_id` = `a`.`asset_id` AND `v_spek`.`atribut_id` = 129 AND `v_spek`.`active_st` = 1
WHERE `s`.`deleted_st` = 0
ORDER BY `s`.`created_at` DESC
 LIMIT 10
ERROR - 2026-01-02 23:01:55 --> Query error: Table 'tmfw_inventory_management_system.mst_user' doesn't exist - Invalid query: SELECT s.*, CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0')) AS tiket_perbaikan, a.asset_nm, a.asset_kd, v_merk.value_isi AS merk, v_spek.value_isi AS spesifikasi, k.kategori_nm, k.kategori_kd, u.user_nama AS pelapor_nm
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_user` `u` ON `s`.`pelapor_id` = `u`.`user_id`
LEFT JOIN `dat_asset_value` `v_merk` ON `v_merk`.`asset_id` = `a`.`asset_id` AND `v_merk`.`atribut_id` = 128 AND `v_merk`.`active_st` = 1
LEFT JOIN `dat_asset_value` `v_spek` ON `v_spek`.`asset_id` = `a`.`asset_id` AND `v_spek`.`atribut_id` = 129 AND `v_spek`.`active_st` = 1
WHERE `s`.`deleted_st` = 0
ORDER BY `s`.`created_at` DESC
 LIMIT 10
ERROR - 2026-01-02 23:08:02 --> Query error: Unknown column 'p.pegawai' in 'field list' - Invalid query: SELECT s.*, CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0')) AS tiket_perbaikan, a.asset_nm, a.asset_kd, v_merk.value_isi AS merk, v_spek.value_isi AS spesifikasi, k.kategori_nm, k.kategori_kd, p.pegawai AS pelapor_nm
FROM `dat_service` `s`
LEFT JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
LEFT JOIN `mst_kategori` `k` ON `a`.`kategori_id` = `k`.`kategori_id`
LEFT JOIN `mst_pegawai` `p` ON `s`.`pelapor_id` = `p`.`pegawai_id`
LEFT JOIN `dat_asset_value` `v_merk` ON `v_merk`.`asset_id` = `a`.`asset_id` AND `v_merk`.`atribut_id` = 128 AND `v_merk`.`active_st` = 1
LEFT JOIN `dat_asset_value` `v_spek` ON `v_spek`.`asset_id` = `a`.`asset_id` AND `v_spek`.`atribut_id` = 129 AND `v_spek`.`active_st` = 1
WHERE `s`.`deleted_st` = 0
ORDER BY `s`.`created_at` DESC
 LIMIT 10
