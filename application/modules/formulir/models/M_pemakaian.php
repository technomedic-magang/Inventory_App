<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_pemakaian extends CI_Model
{
    var $table = 'trx_pemakaian';
    var $pk_id = 'pemakaian_id';

    public function load_datatables()
    {
        $query = "SELECT t.*, p.pegawai_nm, p.user_id
                  FROM trx_pemakaian t
                  LEFT JOIN mst_pegawai p ON t.pegawai_id = p.pegawai_id";

        $search = ['t.transaksi_no', 't.transaksi_ket', 'p.pegawai_nm', 't.pemakaian_sts'];
        $where  = ['t.deleted_st' => 0];
        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    public function get_assets_available($gudang_id)
    {
        $this->db->select('s.asset_id, s.stok_qty, a.asset_nm, a.asset_kd, sat.satuan_nm');
        $this->db->from('dat_stok s');
        $this->db->join('mst_asset a', 's.asset_id = a.asset_id');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id');
        $this->db->join('mst_satuan sat', 'a.satuan_id = sat.satuan_id', 'left');
        
        $this->db->where('s.gudang_id', $gudang_id);
        $this->db->where('s.stok_qty >', 0);
        $this->db->where('k.kategori_tipe', 'ASET');

        return $this->db->get()->result_array();
    }

    public function get_auto_number($tanggal)
    {
        $prefix = 'PMK'; 
        $periode = date('Ym', strtotime($tanggal));
        $prefix_full = $prefix . '/' . $periode . '/';

        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        $query = $this->db->get($this->table);
        $last_no = $query->row()->transaksi_no;

        $urutan = ($last_no) ? (int)substr($last_no, -4) + 1 : 1;
        return $prefix_full . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    // [REVISI] Simpan TANPA LOOPING (Single Item)
    public function simpan_transaksi($data_header, $asset_id, $gudang_id, $qty_pakai)
    {
        $this->db->trans_start();

        // 1. Insert Header
        $this->db->insert($this->table, $data_header);
        $id_header = $this->db->insert_id();

        // 2. Insert Detail (Cuma 1 kali)
        if (!empty($asset_id) && $qty_pakai > 0) {
            $this->db->insert('trx_pemakaian_detail', [
                'pemakaian_id'  => $id_header,
                'asset_id'      => $asset_id,
                'gudang_id'     => $gudang_id,
                'pemakaian_qty' => $qty_pakai,
                'kembali_qty'   => 0,
                'created_at'    => date('Y-m-d H:i:s')
            ]);

            // 3. Kurangi Stok
            $this->db->set('stok_qty', 'stok_qty - ' . $qty_pakai, FALSE);
            $this->db->where(['gudang_id' => $gudang_id, 'asset_id' => $asset_id]);
            $this->db->update('dat_stok');
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}