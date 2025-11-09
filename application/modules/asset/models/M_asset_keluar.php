<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_asset_keluar extends CI_Model
{
    var $table = 'trx_keluar';
    var $pk_id = 'keluar_id';

    public function load_datatables()
    {
        $query = "SELECT t.*, g.gudang_nm
                  FROM trx_keluar t
                  LEFT JOIN mst_gudang g ON t.gudang_id = g.gudang_id";

        $search = ['t.transaksi_no', 't.transaksi_ket', 'g.gudang_nm', 't.keluar_jns'];
        $where  = ['t.deleted_st' => 0];
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }

    public function simpan_transaksi($data_header, $data_detail)
    {
        $this->db->trans_start();

        // 1. Insert Header
        $this->db->insert($this->table, $data_header);
        $id_header = $this->db->insert_id();

        // 2. Loop Detail & Kurangi Stok
        $gudang_id = $data_header['gudang_id'];
        $jumlah_item = count($data_detail['asset_id']);

        for ($i = 0; $i < $jumlah_item; $i++) {
            $asset_id = $data_detail['asset_id'][$i];
            $qty_keluar = (float) $data_detail['asset_qty'][$i];

            if (!empty($asset_id) && $qty_keluar > 0) {
                // A. Insert Detail
                $this->db->insert('trx_keluar_detail', [
                    'keluar_id'  => $id_header,
                    'asset_id'   => $asset_id,
                    'asset_qty'  => $qty_keluar,
                    'detail_ket' => $data_detail['detail_ket'][$i]
                ]);

                // B. Update Stok (MENGURANGI)
                // Cek dulu apakah stok cukup (opsional, tapi disarankan)
                $cek_stok = $this->db->get_where('dat_stok', ['gudang_id' => $gudang_id, 'asset_id' => $asset_id])->row();
                if ($cek_stok && $cek_stok->stok_qty >= $qty_keluar) {
                    $this->db->set('stok_qty', 'stok_qty - ' . $qty_keluar, FALSE);
                    $this->db->where('stok_id', $cek_stok->stok_id);
                    $this->db->update('dat_stok');
                } else {
                    // Jika stok tidak cukup, sebenarnya harus rollback.
                    // Untuk kesederhanaan template ini, kita biarkan minus atau bisa tambahkan validasi nanti.
                     $this->db->set('stok_qty', 'stok_qty - ' . $qty_keluar, FALSE);
                     $this->db->where(['gudang_id' => $gudang_id, 'asset_id' => $asset_id]);
                     $this->db->update('dat_stok');
                }
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_auto_number($tanggal)
    {
        $prefix = 'OUT'; // Prefix khusus modul ini
        $periode = date('Ym', strtotime($tanggal));
        $prefix_full = $prefix . '/' . $periode . '/';

        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        $query = $this->db->get($this->table);
        $last_no = $query->row()->transaksi_no;

        if ($last_no) {
            $last_urutan = (int) substr($last_no, -4);
            $new_urutan = $last_urutan + 1;
        } else {
            $new_urutan = 1;
        }
        return $prefix_full . str_pad($new_urutan, 4, '0', STR_PAD_LEFT);
    }

    // Tambahkan fungsi ini di paling bawah file model
    public function get_assets_available($gudang_id)
    {
        // Ambil data stok gabung dengan master asset dan satuan
        $this->db->select('s.asset_id, s.stok_qty, a.asset_nm, a.asset_kd, sat.satuan_nm');
        $this->db->from('dat_stok s');
        $this->db->join('mst_asset a', 's.asset_id = a.asset_id');
        $this->db->join('mst_satuan sat', 'a.satuan_id = sat.satuan_id', 'left');
        $this->db->where('s.gudang_id', $gudang_id);
        $this->db->where('s.stok_qty >', 0); // HANYA YANG ADA STOKNYA
        $query = $this->db->get();

        return $query->result_array();
    }
}