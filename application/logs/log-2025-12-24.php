<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-12-24 01:28:41 --> Query error: Table 'tmfw_inventory_management_system.trx_masuk' doesn't exist - Invalid query: SELECT 
                    t.masuk_id, t.transaksi_tgl, t.transaksi_no,
                    t.transaksi_ket, g.gudang_nm
                FROM trx_masuk t
                LEFT JOIN mst_gudang g ON t.gudang_id = g.gudang_id WHERE 1 = 1  AND t.deleted_st='0' AND (LOWER(t.transaksi_no) LIKE '%%' OR LOWER(t.transaksi_ket) LIKE '%%' OR LOWER(g.gudang_nm) LIKE '%%')  ORDER BY transaksi_tgl desc LIMIT 500 OFFSET 0
ERROR - 2025-12-24 17:01:01 --> Query error: Unknown column 'nip' in 'field list' - Invalid query: SELECT `pegawai_id`, `pegawai_nm`, `nip`
FROM `mst_pegawai`
WHERE `active_st` = 1
AND `deleted_st` = 0
ERROR - 2025-12-24 17:01:10 --> Query error: Unknown column 'nip' in 'field list' - Invalid query: SELECT `pegawai_id`, `pegawai_nm`, `nip`
FROM `mst_pegawai`
WHERE `active_st` = 1
AND `deleted_st` = 0
ERROR - 2025-12-24 17:33:16 --> Severity: Notice --> Undefined index: active_st C:\laragon\www\tmfw-main\application\modules\manajemen\controllers\Manajemen_asset.php 77
ERROR - 2025-12-24 17:33:25 --> Severity: Notice --> Undefined index: active_st C:\laragon\www\tmfw-main\application\modules\manajemen\controllers\Manajemen_asset.php 77
