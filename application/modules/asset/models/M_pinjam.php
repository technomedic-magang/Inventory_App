<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_pinjam extends CI_Model
{
    var $table = 'trx_pinjam';
    var $pk_id = 'pinjam_id';

    public function load_datatables()
    {
        $query = "SELECT t.*, p.pegawai_nm, p.user_id
                  FROM trx_pinjam t
                  LEFT JOIN mst_pegawai p ON t.pegawai_id = p.pegawai_id";

        $search = ['t.transaksi_no', 't.transaksi_ket', 'p.pegawai_nm', 't.pinjam_sts'];
        $where  = ['t.deleted_st' => 0];
        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    public function simpan_transaksi($data_header, $data_detail)
    {
        $this->db->trans_start();
        $this->db->insert($this->table, $data_header);
        $id_header = $this->db->insert_id();

        $jumlah_item = count($data_detail['asset_id']);
        for ($i = 0; $i < $jumlah_item; $i++) {
            $asset_id = $data_detail['asset_id'][$i];
            $gudang_id = $data_detail['gudang_id'][$i];
            $qty_pinjam = (float) $data_detail['pinjam_qty'][$i];

            if (!empty($asset_id) && $qty_pinjam > 0) {
                $this->db->insert('trx_pinjam_detail', [
                    'pinjam_id'  => $id_header,
                    'asset_id'   => $asset_id,
                    'gudang_id'  => $gudang_id,
                    'pinjam_qty' => $qty_pinjam,
                    'kembali_qty'=> 0
                ]);

                // Kurangi Stok
                $this->db->set('stok_qty', 'stok_qty - ' . $qty_pinjam, FALSE);
                $this->db->where(['gudang_id' => $gudang_id, 'asset_id' => $asset_id]);
                $this->db->update('dat_stok');
            }
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // --- AUTO NUMBER (PJM) ---
    public function get_auto_number($tanggal)
    {
        $prefix = 'PJM';
        $periode = date('Ym', strtotime($tanggal));
        $prefix_full = $prefix . '/' . $periode . '/';

        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        $query = $this->db->get($this->table);
        $last_no = $query->row()->transaksi_no;

        if ($last_no) {
            $urutan = (int) substr($last_no, -4);
            $urutan++;
        } else {
            $urutan = 1;
        }
        return $prefix_full . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    // Tambahkan di paling bawah file M_pinjam.php
    public function get_assets_available($gudang_id)
    {
        $this->db->select('s.asset_id, s.stok_qty, a.asset_nm, a.asset_kd, sat.satuan_nm');
        $this->db->from('dat_stok s');
        $this->db->join('mst_asset a', 's.asset_id = a.asset_id');
        $this->db->join('mst_satuan sat', 'a.satuan_id = sat.satuan_id', 'left');
        $this->db->where('s.gudang_id', $gudang_id);
        $this->db->where('s.stok_qty >', 0);
        return $this->db->get()->result_array();
    }
}