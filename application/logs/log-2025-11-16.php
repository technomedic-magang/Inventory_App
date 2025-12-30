<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-11-16 02:04:20 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') as service_terakhir,

                -- [PERBAIKAN DI SINI: AMBIL PAJAK TER' at line 4 - Invalid query: 
            SELECT COUNT(1) AS count FROM trx_perawatan 
                    WHERE asset_id = a.asset_id AND deleted_st = 0 
                    ORDER BY tgl_perawatan DESC LIMIT 1
                ) as service_terakhir,

                -- [PERBAIKAN DI SINI: AMBIL PAJAK TERAKHIR]
                -- Subquery untuk ambil tanggal jatuh tempo pajak
                (
                    SELECT DATE_FORMAT(tgl_jatuh_tempo, '%d/%m/%Y') 
                    FROM trx_pajak 
                    WHERE asset_id = a.asset_id AND deleted_st = 0 
                    ORDER BY tgl_jatuh_tempo DESC LIMIT 1
                ) as pajak_kendaraan

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd IN ('K2', 'K4')
            
            -- ... (JOIN ATRIBUT KUSTOM TETAP SAMA SEPERTI SEBELUMNYA) ...
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label = 'Merek'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_seri ON attr_seri.kategori_id = a.kategori_id AND (attr_seri.atribut_label LIKE 'Seri%' OR attr_seri.atribut_label LIKE 'Model%')
            LEFT JOIN dat_asset_value v_seri ON v_seri.asset_id = a.asset_id AND v_seri.atribut_id = attr_seri.atribut_id

            LEFT JOIN mst_kategori_atribut attr_warna ON attr_warna.kategori_id = a.kategori_id AND attr_warna.atribut_label = 'Warna'
            LEFT JOIN dat_asset_value v_warna ON v_warna.asset_id = a.asset_id AND v_warna.atribut_id = attr_warna.atribut_id

            LEFT JOIN mst_kategori_atribut attr_nopol ON attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'
            LEFT JOIN dat_asset_value v_nopol ON v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id

            LEFT JOIN mst_kategori_atribut attr_bpkb ON attr_bpkb.kategori_id = a.kategori_id AND attr_bpkb.atribut_label LIKE '%BPKB%'
            LEFT JOIN dat_asset_value v_bpkb ON v_bpkb.asset_id = a.asset_id AND v_bpkb.atribut_id = attr_bpkb.atribut_id

            -- JOIN LAINNYA (SIRKULASI & GUDANG) TETAP SAMA
            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id
            LEFT JOIN mst_jabatan j ON pg.jabatan_id = j.jabatan_id

            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id
         WHERE 1 = 1  AND a.deleted_st='0'
ERROR - 2025-11-16 02:04:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') as service_terakhir,

                -- [PERBAIKAN DI SINI: AMBIL PAJAK TER' at line 4 - Invalid query: 
            SELECT COUNT(1) AS count FROM trx_perawatan 
                    WHERE asset_id = a.asset_id AND deleted_st = 0 
                    ORDER BY tgl_perawatan DESC LIMIT 1
                ) as service_terakhir,

                -- [PERBAIKAN DI SINI: AMBIL PAJAK TERAKHIR]
                -- Subquery untuk ambil tanggal jatuh tempo pajak
                (
                    SELECT DATE_FORMAT(tgl_jatuh_tempo, '%d/%m/%Y') 
                    FROM trx_pajak 
                    WHERE asset_id = a.asset_id AND deleted_st = 0 
                    ORDER BY tgl_jatuh_tempo DESC LIMIT 1
                ) as pajak_kendaraan

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd IN ('K2', 'K4')
            
            -- ... (JOIN ATRIBUT KUSTOM TETAP SAMA SEPERTI SEBELUMNYA) ...
            LEFT JOIN mst_kategori_atribut attr_merek ON attr_merek.kategori_id = a.kategori_id AND attr_merek.atribut_label = 'Merek'
            LEFT JOIN dat_asset_value v_merek ON v_merek.asset_id = a.asset_id AND v_merek.atribut_id = attr_merek.atribut_id

            LEFT JOIN mst_kategori_atribut attr_seri ON attr_seri.kategori_id = a.kategori_id AND (attr_seri.atribut_label LIKE 'Seri%' OR attr_seri.atribut_label LIKE 'Model%')
            LEFT JOIN dat_asset_value v_seri ON v_seri.asset_id = a.asset_id AND v_seri.atribut_id = attr_seri.atribut_id

            LEFT JOIN mst_kategori_atribut attr_warna ON attr_warna.kategori_id = a.kategori_id AND attr_warna.atribut_label = 'Warna'
            LEFT JOIN dat_asset_value v_warna ON v_warna.asset_id = a.asset_id AND v_warna.atribut_id = attr_warna.atribut_id

            LEFT JOIN mst_kategori_atribut attr_nopol ON attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'
            LEFT JOIN dat_asset_value v_nopol ON v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id

            LEFT JOIN mst_kategori_atribut attr_bpkb ON attr_bpkb.kategori_id = a.kategori_id AND attr_bpkb.atribut_label LIKE '%BPKB%'
            LEFT JOIN dat_asset_value v_bpkb ON v_bpkb.asset_id = a.asset_id AND v_bpkb.atribut_id = attr_bpkb.atribut_id

            -- JOIN LAINNYA (SIRKULASI & GUDANG) TETAP SAMA
            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id
            LEFT JOIN mst_jabatan j ON pg.jabatan_id = j.jabatan_id

            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id
         WHERE 1 = 1  AND a.deleted_st='0'
ERROR - 2025-11-16 18:20:18 --> 404 Page Not Found: ../modules/persediaan/controllers/Persediaan/persediaan_masuk
