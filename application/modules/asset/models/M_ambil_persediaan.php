<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_ambil_persediaan extends CI_Model
{
    var $table = 'trx_ambil_persediaan';
    var $pk_id = 'ambil_id';

    public function load_datatables()
    {
        $query = "SELECT t.*, g.gudang_nm, p.pegawai_nm
                  FROM trx_ambil_persediaan t
                  LEFT JOIN mst_gudang g ON t.gudang_id = g.gudang_id
                  LEFT JOIN mst_pegawai p ON t.pegawai_id = p.pegawai_id";

        $search = ['t.transaksi_no', 't.transaksi_ket', 'g.gudang_nm', 'p.pegawai_nm'];
        $where  = ['t.deleted_st' => 0];
        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // [Perubahan 3] Ambil HANYA persediaan (ATK, dll) yang ada stoknya
    public function get_persediaan_available($gudang_id)
    {
        $this->db->select('s.asset_id, s.stok_qty, a.asset_nm, a.asset_kd, sat.satuan_nm');
        $this->db->from('dat_stok s');
        $this->db->join('mst_asset a', 's.asset_id = a.asset_id');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id');
        $this->db->join('mst_satuan sat', 'a.satuan_id = s.satuan_id', 'left');
        
        $this->db->where('s.gudang_id', $gudang_id);
        $this->db->where('s.stok_qty >', 0);
        $this->db->where('k.kategori_tipe', 'PERSEDIAAN'); // <-- KUNCI FILTER

        return $this->db->get()->result_array();
    }

    // [Perubahan 1] Mesin Auto Number
    public function get_auto_number($tanggal)
    {
        $prefix = 'TAKE'; // Prefix untuk Pengambilan
        $periode = date('Ym', strtotime($tanggal));
        $prefix_full = $prefix . '/' . $periode . '/';

        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        $query = $this->db->get($this->table);
        $last_no = $query->row()->transaksi_no;

        $urutan = ($last_no) ? (int)substr($last_no, -4) + 1 : 1;
        return $prefix_full . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    // Mesin Simpan Transaksi (Mengurangi Stok)
    public function simpan_transaksi($data_header, $data_detail)
    {
        $this->db->trans_start();
        $this->db->insert($this->table, $data_header);
        $id_header = $this->db->insert_id();

        $gudang_id = $data_header['gudang_id'];
        $jumlah_item = count($data_detail['asset_id']);

        for ($i = 0; $i < $jumlah_item; $i++) {
            $asset_id = $data_detail['asset_id'][$i];
            $qty_keluar = (float) $data_detail['asset_qty'][$i];

            if (!empty($asset_id) && $qty_keluar > 0) {
                // A. Insert Detail
                $this->db->insert('trx_ambil_persediaan_detail', [
                    'ambil_id'   => $id_header,
                    'asset_id'   => $asset_id,
                    'asset_qty'  => $qty_keluar,
                    'detail_ket' => $data_detail['detail_ket'][$i]
                ]);

                // B. Kurangi Stok
                $this->db->set('stok_qty', 'stok_qty - ' . $qty_keluar, FALSE);
                $this->db->where(['gudang_id' => $gudang_id, 'asset_id' => $asset_id]);
                $this->db->update('dat_stok');
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}