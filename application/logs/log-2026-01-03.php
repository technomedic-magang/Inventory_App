<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-01-03 01:21:59 --> Severity: Notice --> Undefined variable: list_kategori C:\laragon\www\tmfw-main\application\modules\laporan\views\verifikasi_perbaikan\index.php 35
ERROR - 2026-01-03 01:21:59 --> Severity: Warning --> Invalid argument supplied for foreach() C:\laragon\www\tmfw-main\application\modules\laporan\views\verifikasi_perbaikan\index.php 35
ERROR - 2026-01-03 01:22:13 --> 404 Page Not Found: ../modules/laporan/controllers/Verifikasi_perbaikan/proses
ERROR - 2026-01-03 01:22:45 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\laporan\views\verifikasi_perbaikan\form_modal.php 7
ERROR - 2026-01-03 01:22:45 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\laporan\views\verifikasi_perbaikan\form_modal.php 8
ERROR - 2026-01-03 01:22:45 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\laporan\views\verifikasi_perbaikan\form_modal.php 11
ERROR - 2026-01-03 01:22:45 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\laporan\views\verifikasi_perbaikan\form_modal.php 12
ERROR - 2026-01-03 01:22:45 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\laporan\views\verifikasi_perbaikan\form_modal.php 16
ERROR - 2026-01-03 01:22:45 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\laporan\views\verifikasi_perbaikan\form_modal.php 22
ERROR - 2026-01-03 01:26:20 --> 404 Page Not Found: ../modules/manajemen/controllers//index
ERROR - 2026-01-03 01:42:34 --> Severity: Notice --> Undefined index: value C:\laragon\www\tmfw-main\application\modules\laporan\models\M_verifikasi_perbaikan.php 36
ERROR - 2026-01-03 02:36:28 --> Severity: Notice --> Undefined variable: detail C:\laragon\www\tmfw-main\application\modules\laporan\views\perbaikan_aset\form_modal.php 7
ERROR - 2026-01-03 02:36:28 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\laporan\views\perbaikan_aset\form_modal.php 7
ERROR - 2026-01-03 02:36:28 --> Severity: Notice --> Undefined variable: detail C:\laragon\www\tmfw-main\application\modules\laporan\views\perbaikan_aset\form_modal.php 8
ERROR - 2026-01-03 02:36:28 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\laporan\views\perbaikan_aset\form_modal.php 8
ERROR - 2026-01-03 02:36:28 --> Severity: Notice --> Undefined variable: detail C:\laragon\www\tmfw-main\application\modules\laporan\views\perbaikan_aset\form_modal.php 11
ERROR - 2026-01-03 02:36:28 --> Severity: Notice --> Trying to access array offset on value of type null C:\laragon\www\tmfw-main\application\modules\laporan\views\perbaikan_aset\form_modal.php 11
ERROR - 2026-01-03 21:44:04 --> Query error: Unknown column 'asset_kd' in 'order clause' - Invalid query: SELECT k.*, p.transaksi_no as pemakaian_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pemakaian p ON k.pemakaian_id = p.pemakaian_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id WHERE 1 = 1  AND k.deleted_st='0' AND (LOWER(k.transaksi_no) LIKE '%%' OR LOWER(p.transaksi_no) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%')  ORDER BY asset_kd desc LIMIT 500 OFFSET 0
