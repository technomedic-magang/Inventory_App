<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-11-20 12:06:45 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai_detail' doesn't exist - Invalid query: SELECT SUM(pakai_qty - kembali_qty) as sisa_pakai
FROM `trx_pakai_detail`
WHERE `pakai_qty` > `kembali_qty`
ERROR - 2025-11-20 12:15:53 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: 
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Masuk' as tipe, 'primary' as warna FROM trx_masuk WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Keluar (Disposal)' as tipe, 'danger' as warna FROM trx_keluar WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pemakaian' as tipe, 'warning' as warna FROM trx_pakai WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pengembalian' as tipe, 'success' as warna FROM trx_kembali WHERE deleted_st = 0)
            
            ORDER BY tgl DESC
            LIMIT 10
        
ERROR - 2025-11-20 12:15:55 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: 
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Masuk' as tipe, 'primary' as warna FROM trx_masuk WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Keluar (Disposal)' as tipe, 'danger' as warna FROM trx_keluar WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pemakaian' as tipe, 'warning' as warna FROM trx_pakai WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pengembalian' as tipe, 'success' as warna FROM trx_kembali WHERE deleted_st = 0)
            
            ORDER BY tgl DESC
            LIMIT 10
        
ERROR - 2025-11-20 12:15:56 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: 
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Masuk' as tipe, 'primary' as warna FROM trx_masuk WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Keluar (Disposal)' as tipe, 'danger' as warna FROM trx_keluar WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pemakaian' as tipe, 'warning' as warna FROM trx_pakai WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pengembalian' as tipe, 'success' as warna FROM trx_kembali WHERE deleted_st = 0)
            
            ORDER BY tgl DESC
            LIMIT 10
        
ERROR - 2025-11-20 12:15:56 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: 
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Masuk' as tipe, 'primary' as warna FROM trx_masuk WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Keluar (Disposal)' as tipe, 'danger' as warna FROM trx_keluar WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pemakaian' as tipe, 'warning' as warna FROM trx_pakai WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pengembalian' as tipe, 'success' as warna FROM trx_kembali WHERE deleted_st = 0)
            
            ORDER BY tgl DESC
            LIMIT 10
        
ERROR - 2025-11-20 12:15:56 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: 
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Masuk' as tipe, 'primary' as warna FROM trx_masuk WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Keluar (Disposal)' as tipe, 'danger' as warna FROM trx_keluar WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pemakaian' as tipe, 'warning' as warna FROM trx_pakai WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pengembalian' as tipe, 'success' as warna FROM trx_kembali WHERE deleted_st = 0)
            
            ORDER BY tgl DESC
            LIMIT 10
        
ERROR - 2025-11-20 12:15:56 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: 
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Masuk' as tipe, 'primary' as warna FROM trx_masuk WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Keluar (Disposal)' as tipe, 'danger' as warna FROM trx_keluar WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pemakaian' as tipe, 'warning' as warna FROM trx_pakai WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pengembalian' as tipe, 'success' as warna FROM trx_kembali WHERE deleted_st = 0)
            
            ORDER BY tgl DESC
            LIMIT 10
        
ERROR - 2025-11-20 12:15:57 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: 
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Masuk' as tipe, 'primary' as warna FROM trx_masuk WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Keluar (Disposal)' as tipe, 'danger' as warna FROM trx_keluar WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pemakaian' as tipe, 'warning' as warna FROM trx_pakai WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pengembalian' as tipe, 'success' as warna FROM trx_kembali WHERE deleted_st = 0)
            
            ORDER BY tgl DESC
            LIMIT 10
        
ERROR - 2025-11-20 12:15:57 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: 
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Masuk' as tipe, 'primary' as warna FROM trx_masuk WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Keluar (Disposal)' as tipe, 'danger' as warna FROM trx_keluar WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pemakaian' as tipe, 'warning' as warna FROM trx_pakai WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pengembalian' as tipe, 'success' as warna FROM trx_kembali WHERE deleted_st = 0)
            
            ORDER BY tgl DESC
            LIMIT 10
        
ERROR - 2025-11-20 12:15:57 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: 
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Masuk' as tipe, 'primary' as warna FROM trx_masuk WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Keluar (Disposal)' as tipe, 'danger' as warna FROM trx_keluar WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pemakaian' as tipe, 'warning' as warna FROM trx_pakai WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pengembalian' as tipe, 'success' as warna FROM trx_kembali WHERE deleted_st = 0)
            
            ORDER BY tgl DESC
            LIMIT 10
        
ERROR - 2025-11-20 12:15:58 --> Query error: Table 'tmfw_inventory_management_system.trx_pakai' doesn't exist - Invalid query: 
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Masuk' as tipe, 'primary' as warna FROM trx_masuk WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Barang Keluar (Disposal)' as tipe, 'danger' as warna FROM trx_keluar WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pemakaian' as tipe, 'warning' as warna FROM trx_pakai WHERE deleted_st = 0)
            UNION ALL
            (SELECT created_at as tgl, transaksi_no as ref, 'Pengembalian' as tipe, 'success' as warna FROM trx_kembali WHERE deleted_st = 0)
            
            ORDER BY tgl DESC
            LIMIT 10
        
ERROR - 2025-11-20 12:20:53 --> 404 Page Not Found: ../modules/formulir/controllers//index
ERROR - 2025-11-20 12:22:07 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_masuk
ERROR - 2025-11-20 12:22:12 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_keluar
ERROR - 2025-11-20 12:22:16 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_masuk
ERROR - 2025-11-20 12:25:17 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-20 12:25:24 --> 404 Page Not Found: ../modules/formulir/controllers//index
ERROR - 2025-11-20 12:25:32 --> 404 Page Not Found: ../modules/formulir/controllers//index
ERROR - 2025-11-20 12:29:36 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-20 12:29:39 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-20 12:29:42 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-20 12:47:42 --> 404 Page Not Found: ../modules/list/controllers//index
ERROR - 2025-11-20 12:53:51 --> 404 Page Not Found: ../modules/list/controllers/Komputer/index
ERROR - 2025-11-20 12:54:34 --> 404 Page Not Found: ../modules/list/controllers/Komputer/index
ERROR - 2025-11-20 12:55:18 --> 404 Page Not Found: ../modules/list/controllers/Komputer/index
ERROR - 2025-11-20 12:55:56 --> 404 Page Not Found: ../modules/list/controllers/Komputer/index
