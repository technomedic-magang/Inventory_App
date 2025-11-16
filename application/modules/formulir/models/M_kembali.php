<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_kembali extends CI_Model
{
    var $table = 'trx_kembali';
    var $pk_id = 'kembali_id';

    public function load_datatables()
    {
        // JOIN ke Pemakaian & Pegawai untuk info lengkap
        $query = "SELECT k.*, p.transaksi_no as pemakaian_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pemakaian p ON k.pemakaian_id = p.pemakaian_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id";

        $search = ['k.transaksi_no', 'p.transaksi_no', 'pg.pegawai_nm'];
        $where  = ['k.deleted_st' => 0];
        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // Ambil daftar Pemakaian yang belum lunas (OPEN)
    public function get_open_pemakaian()
    {
        return $this->db->select('p.pemakaian_id, p.transaksi_no, pg.pegawai_nm')
                        ->from('trx_pemakaian p')
                        ->join('mst_pegawai pg', 'p.pegawai_id = pg.pegawai_id', 'left')
                        ->where(['p.pemakaian_sts' => 'OPEN', 'p.deleted_st' => 0, 'p.active_st' => 1])
                        ->get()->result_array();
    }

    public function get_auto_number($tanggal)
    {
        $prefix = 'RTN'; // Return
        $periode = date('Ym', strtotime($tanggal));
        $prefix_full = $prefix . '/' . $periode . '/';

        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        $query = $this->db->get($this->table);
        $last_no = $query->row()->transaksi_no;

        $urutan = ($last_no) ? (int)substr($last_no, -4) + 1 : 1;
        return $prefix_full . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    // MESIN PENYIMPAN PENGEMBALIAN
    public function simpan_pengembalian($data_header, $data_detail)
    {
        $this->db->trans_start();

        // 1. Insert Header Pengembalian
        $this->db->insert($this->table, $data_header);
        $id_kembali = $this->db->insert_id();

        // 2. Loop Detail Barang yang Dikembalikan
        // (Karena single entry form, kita anggap arraynya cuma 1 elemen, tapi tetap pakai loop agar aman)
        if (!empty($data_detail['pemakaian_detail_id'])) {
            $pemakaian_detail_id = $data_detail['pemakaian_detail_id'];
            $gudang_id = $data_detail['gudang_id'];
            $asset_id  = $data_detail['asset_id'];
            $qty_kembali = (float) $data_detail['kembali_qty'];
            $kondisi_saat_kembali = $data_detail['kondisi_asset'];
            
            if ($qty_kembali > 0) {
                // A. Insert ke trx_kembali_detail
                $this->db->insert('trx_kembali_detail', [
                    'kembali_id'          => $id_kembali,
                    'pemakaian_detail_id' => $pemakaian_detail_id, // Link ke detail pemakaian spesifik
                    'gudang_id'           => $gudang_id,
                    'kembali_qty'         => $qty_kembali,
                    'kondisi_asset'       => $kondisi_saat_kembali,
                    'created_at'          => date('Y-m-d H:i:s')
                ]);

                // B. Update Stok Gudang (Bertambah +)
                // Cek dulu apakah stok barang ini sudah ada di gudang tujuan
                $cek_stok = $this->db->get_where('dat_stok', ['gudang_id' => $gudang_id, 'asset_id' => $asset_id])->row();
                
                if ($cek_stok) {
                    $this->db->set('stok_qty', 'stok_qty + ' . $qty_kembali, FALSE);
                    $this->db->where('stok_id', $cek_stok->stok_id);
                    $this->db->update('dat_stok');
                } else {
                     $this->db->insert('dat_stok', [
                        'gudang_id' => $gudang_id,
                        'asset_id'  => $asset_id,
                        'stok_qty'  => $qty_kembali
                    ]);
                }

                // C. Update Progres Pengembalian di trx_pemakaian_detail
                $this->db->set('kembali_qty', 'kembali_qty + ' . $qty_kembali, FALSE);
                $this->db->where('pemakaian_detail_id', $pemakaian_detail_id);
                $this->db->update('trx_pemakaian_detail');

                // --- [LOGIKA BARU 2: OTOMATISASI UPDATE KONDISI] ---
                // Jika kondisi saat kembali BUKAN 'BAIK', update Master Asset & Catat Log
                if ($kondisi_saat_kembali != 'BAIK') {
                    
                    // A. Update Master Asset
                    $this->db->where('asset_id', $asset_id);
                    $this->db->update('mst_asset', ['asset_kondisi' => $kondisi_saat_kembali]);

                    // B. Catat di Log Kondisi (Agar terdata di riwayat kerusakan)
                    $log_data = [
                        'transaksi_no'  => $data_header['transaksi_no'], // Pakai no pengembalian
                        'asset_id'      => $asset_id,
                        'transaksi_tgl' => $data_header['transaksi_tgl'],
                        'kondisi_dari'  => 'BAIK', // Asumsi awal dipinjam baik
                        'kondisi_ke'    => $kondisi_saat_kembali,
                        'transaksi_ket' => 'Otomatis dari Pengembalian (No: ' . $data_header['transaksi_no'] . ')',
                        'created_by'    => 'SYSTEM',
                        'active_st'     => 1
                    ];
                    $this->db->insert('log_asset_kondisi', $log_data);
                }
            }
        }

        // 3. Cek apakah Transaksi Pemakaian ini sudah LUNAS?
        // Logic: Cek apakah masih ada detail yang (pemakaian_qty > kembali_qty)
        $sisa_pinjaman = $this->db->where('pemakaian_id', $data_header['pemakaian_id'])
                                  ->where('pemakaian_qty > kembali_qty', NULL, FALSE)
                                  ->count_all_results('trx_pemakaian_detail');

        if ($sisa_pinjaman == 0) {
            // Jika sisa 0, berarti semua sudah kembali -> Set status CLOSED
            $this->db->update('trx_pemakaian', ['pemakaian_sts' => 'CLOSED'], ['pemakaian_id' => $data_header['pemakaian_id']]);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}