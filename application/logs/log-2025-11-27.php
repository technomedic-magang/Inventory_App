<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-11-27 22:20:37 --> 404 Page Not Found: ../modules/asset/controllers/Asset_masuk/get_list_asset_by_kategori
ERROR - 2025-11-27 22:20:56 --> 404 Page Not Found: ../modules/asset/controllers/Asset_masuk/get_list_asset_by_kategori
ERROR - 2025-11-27 22:24:02 --> 404 Page Not Found: ../modules/asset/controllers/Asset_masuk/get_list_asset_by_kategori
ERROR - 2025-11-27 22:26:18 --> 404 Page Not Found: ../modules/asset/controllers/Asset_masuk/get_list_asset_by_kategori
ERROR - 2025-11-27 22:28:34 --> 404 Page Not Found: ../modules/asset/controllers/Asset_masuk/get_list_asset_by_kategori
ERROR - 2025-11-27 22:28:51 --> 404 Page Not Found: ../modules/asset/controllers/Asset_masuk/get_list_asset_by_kategori
ERROR - 2025-11-27 22:28:54 --> 404 Page Not Found: ../modules/asset/controllers/Asset_masuk/get_list_asset_by_kategori
ERROR - 2025-11-27 22:40:50 --> Query error: Column 'kategori_id' in field list is ambiguous - Invalid query: SELECT `asset_id`, `asset_kd`, `asset_nm`, `kategori_id`, `mst_kategori`.`kategori_kd`
FROM `mst_asset`
LEFT JOIN `mst_kategori` ON `mst_asset`.`kategori_id` = `mst_kategori`.`kategori_id`
WHERE `mst_asset`.`deleted_st` = 0
AND `mst_asset`.`kategori_id` = '9'
AND mst_asset.asset_id NOT IN (SELECT `asset_id`
FROM `trx_masuk_detail`)
