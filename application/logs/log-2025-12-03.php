<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-12-03 18:22:36 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-12-03 18:22:52 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-12-03 18:23:32 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-12-03 18:29:52 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-12-03 18:59:35 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE 1 = 1  AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR ' at line 21 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.asset_thn_beli,
                k.kategori_nm,
                
                -- Subquery untuk mengambil Merek/Model (atribut 156 dari data dump)
                (SELECT value_isi FROM dat_asset_value v 
                 WHERE v.asset_id = a.asset_id AND v.atribut_id = 156 LIMIT 1) as spesifikasi_utama

            FROM mst_asset a
            
            LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
            
            WHERE a.deleted_st = 0 
            AND a.active_st = 1
            -- Filter khusus untuk Printer (PR) dan Proyektor (PRY)
            AND (a.asset_kd_singkat IN ('PR', 'PRY') OR a.asset_nm LIKE '%Printer%' OR a.asset_nm LIKE '%Proyektor%')
         WHERE 1 = 1  AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(k.kategori_nm) LIKE '%%')  ORDER BY asset_kd asc LIMIT 500 OFFSET 0
ERROR - 2025-12-03 19:01:01 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-12-03 19:01:57 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-12-03 19:02:02 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-12-03 19:02:42 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-12-03 19:08:19 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-12-03 19:08:24 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-12-03 19:09:02 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-12-03 19:10:03 --> 404 Page Not Found: ../modules/list/controllers/Mabel_meja/index
ERROR - 2025-12-03 19:10:04 --> 404 Page Not Found: ../modules/list/controllers/Mabel_meja/index
ERROR - 2025-12-03 19:10:07 --> 404 Page Not Found: ../modules/list/controllers/Mabel_meja/index
ERROR - 2025-12-03 19:10:08 --> 404 Page Not Found: ../modules/list/controllers/Mabel_meja/index
ERROR - 2025-12-03 19:10:09 --> 404 Page Not Found: ../modules/list/controllers/Mabel_meja/index
ERROR - 2025-12-03 19:10:10 --> 404 Page Not Found: ../modules/list/controllers/Mabel_meja/index
ERROR - 2025-12-03 19:10:49 --> 404 Page Not Found: ../modules/list/controllers/Mabel_meja/index
ERROR - 2025-12-03 19:12:08 --> Severity: Notice --> Undefined property: CI::$data C:\laragon\www\Project_Magang\application\third_party\MX\Controller.php 63
ERROR - 2025-12-03 19:12:08 --> Severity: Notice --> Indirect modification of overloaded property Mabel_meja::$data has no effect C:\laragon\www\Project_Magang\application\modules\list\controllers\Mabel_meja.php 15
ERROR - 2025-12-03 19:34:30 --> Severity: Notice --> Undefined property: CI::$data C:\laragon\www\Project_Magang\application\third_party\MX\Controller.php 63
ERROR - 2025-12-03 19:34:30 --> Severity: Notice --> Indirect modification of overloaded property Mabel_meja::$data has no effect C:\laragon\www\Project_Magang\application\modules\list\controllers\Mabel_meja.php 15
ERROR - 2025-12-03 19:34:30 --> Severity: Notice --> Undefined property: CI::$data C:\laragon\www\Project_Magang\application\third_party\MX\Controller.php 63
ERROR - 2025-12-03 19:34:46 --> Severity: Notice --> Undefined property: CI::$data C:\laragon\www\Project_Magang\application\third_party\MX\Controller.php 63
ERROR - 2025-12-03 19:34:46 --> Severity: Notice --> Indirect modification of overloaded property Mabel_meja::$data has no effect C:\laragon\www\Project_Magang\application\modules\list\controllers\Mabel_meja.php 15
ERROR - 2025-12-03 19:34:46 --> Severity: Notice --> Undefined property: CI::$data C:\laragon\www\Project_Magang\application\third_party\MX\Controller.php 63
ERROR - 2025-12-03 19:34:54 --> Severity: Notice --> Undefined property: CI::$data C:\laragon\www\Project_Magang\application\third_party\MX\Controller.php 63
ERROR - 2025-12-03 19:34:54 --> Severity: Notice --> Indirect modification of overloaded property Mabel_meja::$data has no effect C:\laragon\www\Project_Magang\application\modules\list\controllers\Mabel_meja.php 15
ERROR - 2025-12-03 19:35:23 --> Severity: Notice --> Undefined property: CI::$data C:\laragon\www\Project_Magang\application\third_party\MX\Controller.php 63
ERROR - 2025-12-03 19:35:23 --> Severity: Notice --> Indirect modification of overloaded property Mabel_meja::$data has no effect C:\laragon\www\Project_Magang\application\modules\list\controllers\Mabel_meja.php 15
ERROR - 2025-12-03 19:35:39 --> Severity: Notice --> Undefined property: CI::$data C:\laragon\www\Project_Magang\application\third_party\MX\Controller.php 63
ERROR - 2025-12-03 19:35:39 --> Severity: Notice --> Indirect modification of overloaded property Mabel_meja::$data has no effect C:\laragon\www\Project_Magang\application\modules\list\controllers\Mabel_meja.php 15
ERROR - 2025-12-03 19:35:56 --> Severity: Notice --> Undefined property: CI::$data C:\laragon\www\Project_Magang\application\third_party\MX\Controller.php 63
ERROR - 2025-12-03 19:35:56 --> Severity: Notice --> Indirect modification of overloaded property Mabel_meja::$data has no effect C:\laragon\www\Project_Magang\application\modules\list\controllers\Mabel_meja.php 15
ERROR - 2025-12-03 19:43:11 --> Severity: Notice --> Undefined property: CI::$data C:\laragon\www\Project_Magang\application\third_party\MX\Controller.php 63
ERROR - 2025-12-03 19:43:11 --> Severity: Notice --> Indirect modification of overloaded property Mabel_meja::$data has no effect C:\laragon\www\Project_Magang\application\modules\list\controllers\Mabel_meja.php 15
