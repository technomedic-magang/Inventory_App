<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-11-13 00:34:08 --> Severity: Notice --> Undefined property: CI::$table C:\laragon\www\tmfw-main\system\core\Model.php 79
ERROR - 2025-11-13 00:34:08 --> Severity: Notice --> Undefined property: CI::$pk_id C:\laragon\www\tmfw-main\system\core\Model.php 79
ERROR - 2025-11-13 00:34:10 --> Severity: Notice --> Undefined property: CI::$table C:\laragon\www\tmfw-main\system\core\Model.php 79
ERROR - 2025-11-13 00:34:10 --> Severity: Notice --> Undefined property: CI::$pk_id C:\laragon\www\tmfw-main\system\core\Model.php 79
ERROR - 2025-11-13 00:34:10 --> Severity: error --> Exception: Call to undefined method M_master_kategori::load_datatables() C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 130
ERROR - 2025-11-13 00:38:31 --> Severity: error --> Exception: Call to undefined method Master_kategori::get_current_atribut_ids() C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 108
ERROR - 2025-11-13 00:38:32 --> Severity: error --> Exception: Call to undefined method Master_kategori::get_current_atribut_ids() C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 108
ERROR - 2025-11-13 00:38:33 --> Severity: error --> Exception: Call to undefined method Master_kategori::get_current_atribut_ids() C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 108
ERROR - 2025-11-13 00:38:34 --> Severity: error --> Exception: Call to undefined method Master_kategori::get_current_atribut_ids() C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 108
ERROR - 2025-11-13 00:38:39 --> Severity: error --> Exception: Call to undefined method Master_kategori::get_current_atribut_ids() C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 108
ERROR - 2025-11-13 00:38:42 --> Severity: error --> Exception: Call to undefined method Master_kategori::get_current_atribut_ids() C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 108
ERROR - 2025-11-13 00:41:08 --> Severity: Notice --> Undefined variable: kategori_id C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 109
ERROR - 2025-11-13 00:41:14 --> Severity: Notice --> Undefined variable: kategori_id C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 109
ERROR - 2025-11-13 00:41:42 --> Severity: Notice --> Undefined variable: kategori_id C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 109
ERROR - 2025-11-13 00:42:10 --> Severity: Notice --> Undefined variable: kategori_id C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 109
ERROR - 2025-11-13 00:42:27 --> Severity: Notice --> Undefined variable: kategori_id C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 109
ERROR - 2025-11-13 00:43:11 --> Severity: Notice --> Undefined property: CI::$M_master_kategori C:\laragon\www\tmfw-main\application\third_party\MX\Controller.php 63
ERROR - 2025-11-13 00:43:11 --> Severity: error --> Exception: Call to a member function get_current_atribut_ids() on null C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 108
ERROR - 2025-11-13 00:44:15 --> Severity: error --> Exception: Call to undefined method Master_kategori::get_current_atribut_ids() C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 108
ERROR - 2025-11-13 00:44:16 --> Severity: error --> Exception: Call to undefined method Master_kategori::get_current_atribut_ids() C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 108
ERROR - 2025-11-13 00:44:18 --> Severity: error --> Exception: Call to undefined method Master_kategori::get_current_atribut_ids() C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 108
ERROR - 2025-11-13 00:48:50 --> Severity: error --> Exception: syntax error, unexpected '=' C:\laragon\www\tmfw-main\application\modules\master\controllers\Master_kategori.php 11
ERROR - 2025-11-13 19:58:46 --> 404 Page Not Found: ../modules/asset/controllers//index
ERROR - 2025-11-13 20:46:24 --> Severity: Notice --> Undefined property: CI::$m_pinjam C:\laragon\www\tmfw-main\application\third_party\MX\Controller.php 63
ERROR - 2025-11-13 20:46:24 --> Severity: Notice --> Trying to get property 'table' of non-object C:\laragon\www\tmfw-main\application\modules\asset\controllers\Pakai.php 10
ERROR - 2025-11-13 20:46:24 --> Severity: Notice --> Undefined property: CI::$m_pinjam C:\laragon\www\tmfw-main\application\third_party\MX\Controller.php 63
ERROR - 2025-11-13 20:46:24 --> Severity: Notice --> Trying to get property 'pk_id' of non-object C:\laragon\www\tmfw-main\application\modules\asset\controllers\Pakai.php 11
ERROR - 2025-11-13 20:47:27 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: SELECT t.*, p.pegawai_nm, p.user_id
                  FROM trx_pakai t
                  LEFT JOIN mst_pegawai p ON t.pegawai_id = p.pegawai_id WHERE 1 = 1  AND t.deleted_st='0' AND (LOWER(t.transaksi_no) LIKE '%%' OR LOWER(t.transaksi_ket) LIKE '%%' OR LOWER(p.pegawai_nm) LIKE '%%' OR LOWER(t.pakai_sts) LIKE '%%')  ORDER BY pakai_id desc LIMIT 10 OFFSET 0
ERROR - 2025-11-13 20:48:31 --> Query error: Unknown column 't.pakai_sts' in 'where clause' - Invalid query: SELECT t.*, p.pegawai_nm, p.user_id
                  FROM trx_pakai t
                  LEFT JOIN mst_pegawai p ON t.pegawai_id = p.pegawai_id WHERE 1 = 1  AND t.deleted_st='0' AND (LOWER(t.transaksi_no) LIKE '%%' OR LOWER(t.transaksi_ket) LIKE '%%' OR LOWER(p.pegawai_nm) LIKE '%%' OR LOWER(t.pakai_sts) LIKE '%%')  ORDER BY pakai_id desc LIMIT 10 OFFSET 0
ERROR - 2025-11-13 20:48:41 --> Query error: Unknown column 't.pakai_sts' in 'where clause' - Invalid query: SELECT t.*, p.pegawai_nm, p.user_id
                  FROM trx_pakai t
                  LEFT JOIN mst_pegawai p ON t.pegawai_id = p.pegawai_id WHERE 1 = 1  AND t.deleted_st='0' AND (LOWER(t.transaksi_no) LIKE '%%' OR LOWER(t.transaksi_ket) LIKE '%%' OR LOWER(p.pegawai_nm) LIKE '%%' OR LOWER(t.pakai_sts) LIKE '%%')  ORDER BY pakai_id desc LIMIT 10 OFFSET 0
ERROR - 2025-11-13 20:50:56 --> Query error: Unknown column 'pakai_id' in 'where clause' - Invalid query: SELECT *
FROM `trx_pakai`
WHERE `pakai_id` IS NULL
ERROR - 2025-11-13 20:59:28 --> 404 Page Not Found: /index
ERROR - 2025-11-13 23:17:53 --> 404 Page Not Found: /index
