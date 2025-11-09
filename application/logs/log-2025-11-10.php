<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-11-10 03:00:37 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '// <-- Alias Baru
                    t.transaksi_ket,
                    g.g' at line 4 - Invalid query: SELECT 
                    t.masuk_id,
                    t.transaksi_tgl,
                    t.transaksi_no AS kode_trx_unik,  // <-- Alias Baru
                    t.transaksi_ket,
                    g.gudang_nm
                FROM trx_masuk t
                LEFT JOIN mst_gudang g ON t.gudang_id = g.gudang_id WHERE 1 = 1  AND t.deleted_st='0' AND (LOWER(t.transaksi_no) LIKE '%%' OR LOWER(t.transaksi_ket) LIKE '%%' OR LOWER(g.gudang_nm) LIKE '%%')  ORDER BY transaksi_tgl desc LIMIT 10 OFFSET 0
ERROR - 2025-11-10 03:36:01 --> 404 Page Not Found: ../modules/asset/controllers/Asset_masuk/tes_db
ERROR - 2025-11-10 03:39:23 --> Severity: error --> Exception: Call to undefined method M_pinjam::get_auto_number() C:\laragon\www\tmfw-main\application\modules\asset\controllers\Pinjam.php 27
ERROR - 2025-11-10 03:39:30 --> Severity: error --> Exception: Call to undefined method M_pinjam::get_auto_number() C:\laragon\www\tmfw-main\application\modules\asset\controllers\Pinjam.php 27
ERROR - 2025-11-10 05:13:25 --> Severity: Notice --> Undefined index: transaksi_tgl C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 155
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_no C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 156
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: gudang_nm C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 157
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_tgl C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 155
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_no C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 156
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: gudang_nm C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 157
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_tgl C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 155
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_no C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 156
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: gudang_nm C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 157
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_tgl C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 155
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_no C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 156
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: gudang_nm C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 157
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_tgl C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 155
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_no C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 156
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: gudang_nm C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 157
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_tgl C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 155
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_no C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 156
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: gudang_nm C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 157
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_tgl C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 155
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_no C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 156
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: gudang_nm C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 157
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_tgl C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 155
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: transaksi_no C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 156
ERROR - 2025-11-10 05:13:26 --> Severity: Notice --> Undefined index: gudang_nm C:\laragon\www\tmfw-main\application\modules\app\views\dashboard\index_pegawai.php 157
ERROR - 2025-11-10 05:38:47 --> 404 Page Not Found: ../modules/laporan/controllers/Laporan/penjualan
