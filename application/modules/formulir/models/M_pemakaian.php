<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_pemakaian extends CI_Model
{
    var $table = 'trx_pemakaian';
    var $pk_id = 'pemakaian_id';

    public function load_datatables()
    {
        // Query Utama
        $query = "SELECT t.*, p.pegawai_nm, p.user_id
                  FROM trx_pemakaian t
                  LEFT JOIN mst_pegawai p ON t.pegawai_id = p.pegawai_id";

        $search = ['t.transaksi_no', 't.transaksi_ket', 'p.pegawai_nm', 't.pemakaian_sts'];
        
        // [PERBAIKAN 1]: HAPUS FILTER deleted_st AGAR HISTORY TETAP MUNCUL
        // $where  = ['t.deleted_st' => 0];  <-- Dihapus
        $where  = null; 
        
        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    public function get_assets_available($gudang_id)
    {
        $this->db->select('s.asset_id, s.stok_qty, a.asset_nm, a.asset_kd, sat.satuan_nm');
        
        $this->db->select('k.kategori_nm as jenis');
        $this->db->select('v_merk.value_isi as merk');
        $this->db->select('v_nopol.value_isi as nopol');
        $this->db->select('v_spek.value_isi as spesifikasi');
        $this->db->select('v_merek_tipe.value_isi as merek_tipe');

        $this->db->from('dat_stok s');
        $this->db->join('mst_asset a', 's.asset_id = a.asset_id');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id');
        $this->db->join('mst_satuan sat', 'a.satuan_id = sat.satuan_id', 'left');
        
        $this->db->join('mst_kategori_atribut attr_merk', "attr_merk.kategori_id = a.kategori_id AND attr_merk.atribut_label = 'Merek'", 'left');
        $this->db->join('dat_asset_value v_merk', 'v_merk.asset_id = a.asset_id AND v_merk.atribut_id = attr_merk.atribut_id', 'left');

        $this->db->join('mst_kategori_atribut attr_nopol', "attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'", 'left');
        $this->db->join('dat_asset_value v_nopol', 'v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id', 'left');

        $this->db->join('mst_kategori_atribut attr_spek', "attr_spek.kategori_id = a.kategori_id AND attr_spek.atribut_label LIKE '%Spesifikasi%'", 'left');
        $this->db->join('dat_asset_value v_spek', 'v_spek.asset_id = a.asset_id AND v_spek.atribut_id = attr_spek.atribut_id', 'left');
        
        $this->db->join('mst_kategori_atribut attr_mt', "attr_mt.kategori_id = a.kategori_id AND attr_mt.atribut_label = 'Merek & Tipe'", 'left');
        $this->db->join('dat_asset_value v_merek_tipe', 'v_merek_tipe.asset_id = a.asset_id AND v_merek_tipe.atribut_id = attr_mt.atribut_id', 'left');

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

    public function hapus_transaksi($id)
    {
        $this->db->trans_start();

        // 1. Ambil detail barang yang dipakai sebelum dihapus
        $details = $this->db->get_where('trx_pemakaian_detail', ['pemakaian_id' => $id])->result_array();

        // 2. Kembalikan Stok (Looping per item)
        foreach ($details as $d) {
            $this->db->set('stok_qty', 'stok_qty + ' . $d['pemakaian_qty'], FALSE);
            $this->db->where(['asset_id' => $d['asset_id'], 'gudang_id' => $d['gudang_id']]);
            $this->db->update('dat_stok');
        }

        // 3. Soft Delete Header & UPDATE STATUS JADI DIBATALKAN
        $this->db->where($this->pk_id, $id);
        $this->db->update($this->table, [
            'deleted_st'    => 1, 
            'active_st'     => 0,
            'pemakaian_sts' => 'DIBATALKAN' // [PERBAIKAN 2] Ubah Status Text
        ]);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function simpan_transaksi($data_header, $asset_id, $gudang_id, $qty_pakai)
    {
        $this->db->trans_start();

        // 1. Insert Header
        $this->db->insert($this->table, $data_header);
        $id_header = $this->db->insert_id();

        // 2. Insert Detail
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