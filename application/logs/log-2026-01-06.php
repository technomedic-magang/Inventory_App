<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-01-06 01:16:12 --> Query error: Table 'tmfw_inventory_management_system.dat_service' doesn't exist - Invalid query: SELECT `s`.`tgl_berikutnya`, `s`.`kilometer_berikutnya`, `a`.`asset_nm`, `a`.`asset_kd`
FROM `dat_service` `s`
JOIN `mst_asset` `a` ON `s`.`asset_id` = `a`.`asset_id`
WHERE `s`.`deleted_st` = 0
AND  `s`.`tgl_berikutnya` LIKE '2026-01%' ESCAPE '!'
ORDER BY `s`.`tgl_berikutnya` ASC
