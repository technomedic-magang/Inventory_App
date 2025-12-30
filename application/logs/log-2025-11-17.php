<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-11-17 09:52:29 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai_detail' doesn't exist - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pakai_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-17 09:53:54 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai_detail' doesn't exist - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pakai_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-17 09:53:56 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai_detail' doesn't exist - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pakai_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-17 09:54:04 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai_detail' doesn't exist - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pakai_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-17 09:54:50 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai_detail' doesn't exist - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pakai_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-17 09:55:56 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai_detail' doesn't exist - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pakai_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-17 09:55:57 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai_detail' doesn't exist - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pakai_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-17 09:55:58 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai_detail' doesn't exist - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pakai_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-17 09:55:58 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai_detail' doesn't exist - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pakai_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-17 09:55:58 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai_detail' doesn't exist - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pakai_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-17 09:56:11 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai_detail' doesn't exist - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pakai_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-17 09:58:07 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai_detail' doesn't exist - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pakai_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-17 10:02:21 --> Query error: Unknown column 'pakai_qty' in 'field list' - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pemakaian_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-17 10:02:48 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: 
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Masuk' as tipe, 'primary' as warna FROM trx_masuk WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Keluar (Disposal)' as tipe, 'danger' as warna FROM trx_keluar WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pemakaian' as tipe, 'warning' as warna FROM trx_pakai WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pengembalian' as tipe, 'success' as warna FROM trx_kembali WHERE deleted_st = 0)
            
            ORDER BY tgl DESC
            LIMIT 10
        
ERROR - 2025-11-17 10:41:58 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-17 10:48:14 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-17 10:49:41 --> Severity: error --> Exception: Class 'M_aksesoris_komputer' not found C:\laragon\www\tmfw-main\application\third_party\MX\Loader.php 213
ERROR - 2025-11-17 11:11:57 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'a.asset_ket -- [BARU] Ambil kolom Keterangan

            FROM mst_asset a
  ' at line 15 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- Ambil Atribut Kustom 'Merek & Tipe'
                v_merek.value_isi as merek_tipe,
                
                -- Ambil Atribut Kustom 'Tanggal Pembelian'
                v_tgl.value_isi as tgl_pembelian_kustom

                a.asset_ket -- [BARU] Ambil kolom Keterangan

            FROM mst_asset a
            
            -- 1. JOIN Kategori (Filter 'AKS' di sini)
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd = 'ACC' -- KUNCI: Hanya Aksesoris
            
            -- 2. JOIN Atribut 'Merek & Tipe'
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label = 'Merek & Tipe'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            -- 3. JOIN Atribut 'Tanggal Pembelian'
            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label = 'Tanggal Pembelian'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
         WHERE 1 = 1  AND a.deleted_st='0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-17 11:12:01 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'a.asset_ket -- [BARU] Ambil kolom Keterangan

            FROM mst_asset a
  ' at line 15 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- Ambil Atribut Kustom 'Merek & Tipe'
                v_merek.value_isi as merek_tipe,
                
                -- Ambil Atribut Kustom 'Tanggal Pembelian'
                v_tgl.value_isi as tgl_pembelian_kustom

                a.asset_ket -- [BARU] Ambil kolom Keterangan

            FROM mst_asset a
            
            -- 1. JOIN Kategori (Filter 'AKS' di sini)
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd = 'ACC' -- KUNCI: Hanya Aksesoris
            
            -- 2. JOIN Atribut 'Merek & Tipe'
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label = 'Merek & Tipe'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            -- 3. JOIN Atribut 'Tanggal Pembelian'
            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label = 'Tanggal Pembelian'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
         WHERE 1 = 1  AND a.deleted_st='0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-17 11:12:08 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'a.asset_ket -- [BARU] Ambil kolom Keterangan

            FROM mst_asset a
  ' at line 15 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- Ambil Atribut Kustom 'Merek & Tipe'
                v_merek.value_isi as merek_tipe,
                
                -- Ambil Atribut Kustom 'Tanggal Pembelian'
                v_tgl.value_isi as tgl_pembelian_kustom

                a.asset_ket -- [BARU] Ambil kolom Keterangan

            FROM mst_asset a
            
            -- 1. JOIN Kategori (Filter 'AKS' di sini)
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd = 'ACC' -- KUNCI: Hanya Aksesoris
            
            -- 2. JOIN Atribut 'Merek & Tipe'
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label = 'Merek & Tipe'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            -- 3. JOIN Atribut 'Tanggal Pembelian'
            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label = 'Tanggal Pembelian'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
         WHERE 1 = 1  AND a.deleted_st='0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-17 11:20:39 --> Query error: Duplicate entry 'KP' for key 'mst_kategori.idx_kategori_kd' - Invalid query: INSERT INTO `mst_kategori` (`kategori_kd`, `kategori_nm`, `kategori_tipe`, `active_st`, `deleted_st`, `created_by`, `created_at`) VALUES ('KP', 'Printer &amp; LCD Proyektor', 'ASET', '1', 0, 'PEGAWAI TESTER', '2025-11-17 11:20:39')
ERROR - 2025-11-17 11:21:56 --> Query error: Duplicate entry 'KP' for key 'mst_kategori.idx_kategori_kd' - Invalid query: INSERT INTO `mst_kategori` (`kategori_kd`, `kategori_nm`, `kategori_tipe`, `active_st`, `deleted_st`, `created_by`, `created_at`) VALUES ('KP', 'Printer &amp; LCD Proyektor', 'ASET', '1', 0, 'PEGAWAI TESTER', '2025-11-17 11:21:56')
ERROR - 2025-11-17 11:32:06 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-17 11:37:10 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'Printer', 'LCD Proyektor')' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm' at line 21 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                v_merek.value_isi as merek_tipe,
                v_tgl.value_isi as tgl_pembelian_kustom

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
            
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label LIKE 'Merek%'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label LIKE 'Tanggal%'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
         WHERE 1 = 1  AND a.deleted_st='0' AND a.kategori_id='8' AND 0='a.asset_nm IN ('Printer', 'LCD Proyektor')' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-17 11:37:20 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'Printer', 'LCD Proyektor')' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm' at line 21 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                v_merek.value_isi as merek_tipe,
                v_tgl.value_isi as tgl_pembelian_kustom

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
            
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label LIKE 'Merek%'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label LIKE 'Tanggal%'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
         WHERE 1 = 1  AND a.deleted_st='0' AND a.kategori_id='8' AND 0='a.asset_nm IN ('Printer', 'LCD Proyektor')' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-17 11:39:13 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'PR', 'PRY')' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR ' at line 21 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                v_merek.value_isi as merek_tipe,
                v_tgl.value_isi as tgl_pembelian_kustom

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
            
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label LIKE 'Merek%'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label LIKE 'Tanggal%'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
         WHERE 1 = 1  AND a.deleted_st='0' AND a.kategori_id='8' AND 0='a.asset_nm IN ('PR', 'PRY')' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-17 11:40:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'Printer', 'LCD Proyektor')' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm' at line 21 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                v_merek.value_isi as merek_tipe,
                v_tgl.value_isi as tgl_pembelian_kustom

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
            
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label LIKE 'Merek%'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label LIKE 'Tanggal%'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
         WHERE 1 = 1  AND a.deleted_st='0' AND a.kategori_id='8' AND 0='a.asset_nm IN ('Printer', 'LCD Proyektor')' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-17 11:49:01 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE 1 = 1  AND a.deleted_st='0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.as' at line 26 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                v_merek.value_isi as merek_tipe,
                v_tgl.value_isi as tgl_pembelian_kustom

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
            
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label LIKE 'Merek%'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label LIKE 'Tanggal%'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
            
            -- [FILTER DIPINDAH KE SINI]
            WHERE 
                a.kategori_id = 8 
                AND a.asset_nm IN ('Printer', 'LCD Proyektor')
         WHERE 1 = 1  AND a.deleted_st='0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2025-11-17 13:35:39 --> Severity: Warning --> Use of undefined constant uri - assumed 'uri' (this will throw an Error in a future version of PHP) C:\laragon\www\tmfw-main\application\modules\asset\views\asset_masuk\form_modal.php 109
ERROR - 2025-11-17 13:35:39 --> Severity: error --> Exception: Object of class MY_Loader could not be converted to string C:\laragon\www\tmfw-main\application\modules\asset\views\asset_masuk\form_modal.php 109
ERROR - 2025-11-17 13:35:50 --> Severity: Warning --> Use of undefined constant uri - assumed 'uri' (this will throw an Error in a future version of PHP) C:\laragon\www\tmfw-main\application\modules\asset\views\asset_masuk\form_modal.php 109
ERROR - 2025-11-17 13:35:50 --> Severity: error --> Exception: Object of class MY_Loader could not be converted to string C:\laragon\www\tmfw-main\application\modules\asset\views\asset_masuk\form_modal.php 109
ERROR - 2025-11-17 13:37:59 --> Severity: Warning --> Use of undefined constant uri - assumed 'uri' (this will throw an Error in a future version of PHP) C:\laragon\www\tmfw-main\application\modules\asset\views\asset_masuk\form_modal.php 109
ERROR - 2025-11-17 13:37:59 --> Severity: error --> Exception: Object of class MY_Loader could not be converted to string C:\laragon\www\tmfw-main\application\modules\asset\views\asset_masuk\form_modal.php 109
ERROR - 2025-11-17 13:41:25 --> Severity: Warning --> Use of undefined constant uri - assumed 'uri' (this will throw an Error in a future version of PHP) C:\laragon\www\tmfw-main\application\modules\asset\controllers\Asset_masuk.php 119
ERROR - 2025-11-17 13:41:25 --> Severity: error --> Exception: Object of class Asset_masuk could not be converted to string C:\laragon\www\tmfw-main\application\modules\asset\controllers\Asset_masuk.php 119
ERROR - 2025-11-17 13:41:32 --> Severity: Warning --> Use of undefined constant uri - assumed 'uri' (this will throw an Error in a future version of PHP) C:\laragon\www\tmfw-main\application\modules\asset\controllers\Asset_masuk.php 119
ERROR - 2025-11-17 13:41:32 --> Severity: error --> Exception: Object of class Asset_masuk could not be converted to string C:\laragon\www\tmfw-main\application\modules\asset\controllers\Asset_masuk.php 119
ERROR - 2025-11-17 13:44:11 --> Severity: Warning --> Use of undefined constant uri - assumed 'uri' (this will throw an Error in a future version of PHP) C:\laragon\www\tmfw-main\application\modules\asset\controllers\Asset_masuk.php 119
ERROR - 2025-11-17 13:44:11 --> Severity: error --> Exception: Object of class Asset_masuk could not be converted to string C:\laragon\www\tmfw-main\application\modules\asset\controllers\Asset_masuk.php 119
ERROR - 2025-11-17 13:44:56 --> Severity: Warning --> Use of undefined constant uri - assumed 'uri' (this will throw an Error in a future version of PHP) C:\laragon\www\tmfw-main\application\modules\asset\controllers\Asset_masuk.php 119
ERROR - 2025-11-17 13:44:56 --> Severity: error --> Exception: Object of class Asset_masuk could not be converted to string C:\laragon\www\tmfw-main\application\modules\asset\controllers\Asset_masuk.php 119
ERROR - 2025-11-17 14:25:13 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-17 14:26:00 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-17 14:26:03 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-17 14:26:06 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-17 15:32:22 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '='LCD Proyektor' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%'' at line 40 - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                a.asset_ket,
                k.kategori_nm,
                v_merek.value_isi as merek_seri_spek,
                v_tgl.value_isi as tgl_pembelian_kustom,
                COALESCE(pg.pegawai_nm, g.pic_nm, '-') as penanggungjawab,
                CASE 
                    WHEN pg.pegawai_id IS NOT NULL THEN COALESCE(j.jabatan_nm, '-')
                    WHEN g.gudang_id IS NOT NULL THEN 'Kepala Gudang'
                    ELSE '-'
                END as jabatan,
                CASE
                    WHEN tp.pemakaian_id IS NOT NULL THEN CONCAT('Dipakai: ', pg.pegawai_nm)
                    WHEN g.gudang_id IS NOT NULL THEN g.gudang_nm
                    ELSE 'Lokasi TBD'
                END as lokasi

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id
            
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label LIKE 'Merek%'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label LIKE 'Tgl Pembelian%'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id

            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id
            LEFT JOIN mst_jabatan j ON pg.jabatan_id = j.jabatan_id

            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id
         WHERE 1 = 1  AND a.deleted_st='0' AND k.kategori_kd='KP' AND a.asset_nm !=='LCD Proyektor' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_merek.value_isi) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%' OR LOWER(g.gudang_nm) LIKE '%%')  ORDER BY asset_kd asc LIMIT 500 OFFSET 0
ERROR - 2025-11-17 15:36:38 --> Severity: error --> Exception: Class 'M_aksesoris_komputer' not found C:\laragon\www\tmfw-main\application\third_party\MX\Loader.php 213
ERROR - 2025-11-17 15:37:46 --> 404 Page Not Found: ../modules/list/controllers//index
