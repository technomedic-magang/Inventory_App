<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_asset_masuk extends CI_Model
{
    var $table = 'trx_asset_masuk';
    var $pk_id = 'asset_masuk_id';

    public function load_datatables()
    {
        $query = "SELECT * FROM $this->table";
        $search = ['no_transaksi', 'keterangan', 'tanggal_masuk'];
        $where = ['deleted_st' => 0];
        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // --- FUNGSI BARU: MESIN PENYIMPAN TRANSAKSI ---
    public function simpan_transaksi_lengkap($data_header, $data_detail)
    {
        // Mulai Transaksi (Semua sukses atau batal sama sekali)
        $this->db->trans_start();

        // 1. Simpan Header
        $this->db->insert($this->table, $data_header);
        // Ambil ID Header yang baru saja dibuat
        $id_header_baru = $this->db->insert_id();

        // 2. Simpan Detail (Looping sebanyak baris barang)
        $jumlah_baris = count($data_detail['asset_id']);
        for ($i = 0; $i < $jumlah_baris; $i++) {
            
            // Hanya simpan jika Barang dipilih & Jumlah > 0
            if (!empty($data_detail['asset_id'][$i]) && $data_detail['jumlah'][$i] > 0) {
                $detail = [
                    'asset_masuk_id' => $id_header_baru,
                    'asset_id'       => $data_detail['asset_id'][$i],
                    'jumlah'         => $data_detail['jumlah'][$i],
                    'keterangan'     => $data_detail['ket_detail'][$i]
                ];
                $this->db->insert('trx_asset_masuk_detail', $detail);
            }
        }

        // Selesaikan Transaksi
        $this->db->trans_complete();

        // Kembalikan status (TRUE jika sukses, FALSE jika ada error)
        return $this->db->trans_status();
    }
}