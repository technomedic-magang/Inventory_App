<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-01-18 13:41:27 --> 404 Page Not Found: ../modules/keuangan/controllers/Keuangan_asset/form_modal
ERROR - 2026-01-18 14:48:54 --> Query error: Table 'tmfw_inventory_management_system.trx_perawatan' doesn't exist - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- [BARU] Ambil Data Tahun dan Bulan Beli Murni
                a.asset_thn_beli,
                a.asset_bln_beli,

                -- Data Lama (Opsional, tetap diambil jika butuh backup)
                v_tgl.value_isi as tgl_pembuatan_custom,

                v_merek.value_isi as merk,
                v_seri.value_isi as seri,
                v_warna.value_isi as warna,
                v_nopol.value_isi as nopol,
                v_bpkb.value_isi as bpkb,

                COALESCE(pg.pegawai_nm, g.pic_nm, '-') as penanggungjawab,
                
                CASE 
                    WHEN pg.pegawai_id IS NOT NULL THEN COALESCE(j.jabatan_nm, '-')
                    WHEN g.gudang_id IS NOT NULL THEN 'Kepala Gudang'
                    ELSE '-'
                END as jabatan,

                COALESCE(DATE_FORMAT(tr_latest.max_tgl, '%d/%m/%Y'), '-') as service_terakhir,
                
                -- [PERBAIKAN] Mengambil max(transaksi_tgl) dari trx_pajak
                COALESCE(DATE_FORMAT(tp_latest.max_tgl, '%d/%m/%Y'), '-') as pajak_kendaraan

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd IN ('K2', 'K4')

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label LIKE '%Tahun%'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
            
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

            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id
            LEFT JOIN mst_jabatan j ON pg.jabatan_id = j.jabatan_id

            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id

            LEFT JOIN (SELECT asset_id, MAX(tgl_perawatan) as max_tgl FROM trx_perawatan WHERE deleted_st = 0 GROUP BY asset_id) tr_latest ON a.asset_id = tr_latest.asset_id
            
            -- [PERBAIKAN DISINI: Ganti tgl_jatuh_tempo menjadi transaksi_tgl]
            LEFT JOIN (SELECT asset_id, MAX(transaksi_tgl) as max_tgl FROM trx_pajak WHERE deleted_st = 0 GROUP BY asset_id) tp_latest ON a.asset_id = tp_latest.asset_id
         WHERE 1 = 1  AND a.deleted_st='0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_nopol.value_isi) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%' OR LOWER(a.asset_thn_beli) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2026-01-18 14:49:21 --> Query error: Table 'tmfw_inventory_management_system.trx_perawatan' doesn't exist - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- [BARU] Ambil Data Tahun dan Bulan Beli Murni
                a.asset_thn_beli,
                a.asset_bln_beli,

                -- Data Lama (Opsional, tetap diambil jika butuh backup)
                v_tgl.value_isi as tgl_pembuatan_custom,

                v_merek.value_isi as merk,
                v_seri.value_isi as seri,
                v_warna.value_isi as warna,
                v_nopol.value_isi as nopol,
                v_bpkb.value_isi as bpkb,

                COALESCE(pg.pegawai_nm, g.pic_nm, '-') as penanggungjawab,
                
                CASE 
                    WHEN pg.pegawai_id IS NOT NULL THEN COALESCE(j.jabatan_nm, '-')
                    WHEN g.gudang_id IS NOT NULL THEN 'Kepala Gudang'
                    ELSE '-'
                END as jabatan,

                COALESCE(DATE_FORMAT(tr_latest.max_tgl, '%d/%m/%Y'), '-') as service_terakhir,
                
                -- [PERBAIKAN] Mengambil max(transaksi_tgl) dari trx_pajak
                COALESCE(DATE_FORMAT(tp_latest.max_tgl, '%d/%m/%Y'), '-') as pajak_kendaraan

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd IN ('K2', 'K4')

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label LIKE '%Tahun%'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
            
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

            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id
            LEFT JOIN mst_jabatan j ON pg.jabatan_id = j.jabatan_id

            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id

            LEFT JOIN (SELECT asset_id, MAX(tgl_perawatan) as max_tgl FROM trx_perawatan WHERE deleted_st = 0 GROUP BY asset_id) tr_latest ON a.asset_id = tr_latest.asset_id
            
            -- [PERBAIKAN DISINI: Ganti tgl_jatuh_tempo menjadi transaksi_tgl]
            LEFT JOIN (SELECT asset_id, MAX(transaksi_tgl) as max_tgl FROM trx_pajak WHERE deleted_st = 0 GROUP BY asset_id) tp_latest ON a.asset_id = tp_latest.asset_id
         WHERE 1 = 1  AND a.deleted_st='0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_nopol.value_isi) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%' OR LOWER(a.asset_thn_beli) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2026-01-18 14:49:30 --> Query error: Table 'tmfw_inventory_management_system.trx_perawatan' doesn't exist - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- [BARU] Ambil Data Tahun dan Bulan Beli Murni
                a.asset_thn_beli,
                a.asset_bln_beli,

                -- Data Lama (Opsional, tetap diambil jika butuh backup)
                v_tgl.value_isi as tgl_pembuatan_custom,

                v_merek.value_isi as merk,
                v_seri.value_isi as seri,
                v_warna.value_isi as warna,
                v_nopol.value_isi as nopol,
                v_bpkb.value_isi as bpkb,

                COALESCE(pg.pegawai_nm, g.pic_nm, '-') as penanggungjawab,
                
                CASE 
                    WHEN pg.pegawai_id IS NOT NULL THEN COALESCE(j.jabatan_nm, '-')
                    WHEN g.gudang_id IS NOT NULL THEN 'Kepala Gudang'
                    ELSE '-'
                END as jabatan,

                COALESCE(DATE_FORMAT(tr_latest.max_tgl, '%d/%m/%Y'), '-') as service_terakhir,
                
                -- [PERBAIKAN] Mengambil max(transaksi_tgl) dari trx_pajak
                COALESCE(DATE_FORMAT(tp_latest.max_tgl, '%d/%m/%Y'), '-') as pajak_kendaraan

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd IN ('K2', 'K4')

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label LIKE '%Tahun%'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
            
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

            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id
            LEFT JOIN mst_jabatan j ON pg.jabatan_id = j.jabatan_id

            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id

            LEFT JOIN (SELECT asset_id, MAX(tgl_perawatan) as max_tgl FROM trx_perawatan WHERE deleted_st = 0 GROUP BY asset_id) tr_latest ON a.asset_id = tr_latest.asset_id
            
            -- [PERBAIKAN DISINI: Ganti tgl_jatuh_tempo menjadi transaksi_tgl]
            LEFT JOIN (SELECT asset_id, MAX(transaksi_tgl) as max_tgl FROM trx_pajak WHERE deleted_st = 0 GROUP BY asset_id) tp_latest ON a.asset_id = tp_latest.asset_id
         WHERE 1 = 1  AND a.deleted_st='0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_nopol.value_isi) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%' OR LOWER(a.asset_thn_beli) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
ERROR - 2026-01-18 15:05:11 --> 404 Page Not Found: /index
ERROR - 2026-01-18 19:04:59 --> 404 Page Not Found: /index
ERROR - 2026-01-18 20:33:31 --> Query error: Table 'tmfw_inventory_management_system.trx_perawatan' doesn't exist - Invalid query: 
            SELECT 
                a.asset_id,
                a.asset_kd,
                a.asset_nm,
                a.asset_kondisi,
                a.active_st,
                k.kategori_nm,
                
                -- [BARU] Ambil Data Tahun dan Bulan Beli Murni
                a.asset_thn_beli,
                a.asset_bln_beli,

                -- Data Lama (Opsional, tetap diambil jika butuh backup)
                v_tgl.value_isi as tgl_pembuatan_custom,

                v_merek.value_isi as merk,
                v_seri.value_isi as seri,
                v_warna.value_isi as warna,
                v_nopol.value_isi as nopol,
                v_bpkb.value_isi as bpkb,

                COALESCE(pg.pegawai_nm, g.pic_nm, '-') as penanggungjawab,
                
                CASE 
                    WHEN pg.pegawai_id IS NOT NULL THEN COALESCE(j.jabatan_nm, '-')
                    WHEN g.gudang_id IS NOT NULL THEN 'Kepala Gudang'
                    ELSE '-'
                END as jabatan,

                COALESCE(DATE_FORMAT(tr_latest.max_tgl, '%d/%m/%Y'), '-') as service_terakhir,
                
                -- [PERBAIKAN] Mengambil max(transaksi_tgl) dari trx_pajak
                COALESCE(DATE_FORMAT(tp_latest.max_tgl, '%d/%m/%Y'), '-') as pajak_kendaraan

            FROM mst_asset a
            
            JOIN mst_kategori k ON a.kategori_id = k.kategori_id 
                 AND k.kategori_kd IN ('K2', 'K4')

            LEFT JOIN mst_kategori_atribut attr_tgl ON attr_tgl.kategori_id = a.kategori_id AND attr_tgl.atribut_label LIKE '%Tahun%'
            LEFT JOIN dat_asset_value v_tgl ON v_tgl.asset_id = a.asset_id AND v_tgl.atribut_id = attr_tgl.atribut_id
            
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

            LEFT JOIN trx_pemakaian_detail tpd ON tpd.asset_id = a.asset_id AND tpd.kembali_qty < tpd.pemakaian_qty
            LEFT JOIN trx_pemakaian tp ON tpd.pemakaian_id = tp.pemakaian_id AND tp.pemakaian_sts = 'OPEN'
            LEFT JOIN mst_pegawai pg ON tp.pegawai_id = pg.pegawai_id
            LEFT JOIN mst_jabatan j ON pg.jabatan_id = j.jabatan_id

            LEFT JOIN dat_stok ds ON a.asset_id = ds.asset_id AND ds.stok_qty > 0
            LEFT JOIN mst_gudang g ON ds.gudang_id = g.gudang_id

            LEFT JOIN (SELECT asset_id, MAX(tgl_perawatan) as max_tgl FROM trx_perawatan WHERE deleted_st = 0 GROUP BY asset_id) tr_latest ON a.asset_id = tr_latest.asset_id
            
            -- [PERBAIKAN DISINI: Ganti tgl_jatuh_tempo menjadi transaksi_tgl]
            LEFT JOIN (SELECT asset_id, MAX(transaksi_tgl) as max_tgl FROM trx_pajak WHERE deleted_st = 0 GROUP BY asset_id) tp_latest ON a.asset_id = tp_latest.asset_id
         WHERE 1 = 1  AND a.deleted_st='0' AND (LOWER(a.asset_kd) LIKE '%%' OR LOWER(a.asset_nm) LIKE '%%' OR LOWER(v_nopol.value_isi) LIKE '%%' OR LOWER(pg.pegawai_nm) LIKE '%%' OR LOWER(a.asset_thn_beli) LIKE '%%')  ORDER BY asset_kd asc LIMIT 25 OFFSET 0
