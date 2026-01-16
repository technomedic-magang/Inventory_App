<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_aset_masuk extends CI_Model
{
    public $table = 'trx_masuk';
    public $pk_id = 'masuk_id';

    public function load_datatables()
    {
        $query = "SELECT 
                    t.masuk_id, t.transaksi_tgl, t.transaksi_no,
                    t.transaksi_ket, g.gudang_nm
                FROM trx_masuk t
                LEFT JOIN mst_gudang g ON t.gudang_id = g.gudang_id";
        
        $search_fields = ['t.transaksi_no', 't.transaksi_ket', 'g.gudang_nm'];
        $where_clauses = ['t.deleted_st' => 0];
        
        DB::datatables_query($query, $search_fields, $where_clauses, null);
    }

    // Ambil aset berdasarkan Kategori (Hanya yang belum pernah masuk/stok awal)
    public function get_assets_by_kategori_id($kategori_id)
    {
        // Subquery: Ambil ID aset yang SUDAH ada di transaksi masuk
        $subquery = $this->db->select('asset_id')
                             ->from('trx_masuk_detail')
                             ->get_compiled_select();

        $this->db->select('ma.asset_id, ma.asset_kd, ma.asset_nm, ma.kategori_id, mk.kategori_kd');
        $this->db->from('mst_asset ma');
        $this->db->join('mst_kategori mk', 'ma.kategori_id = mk.kategori_id', 'left');
        
        $this->db->where('ma.deleted_st', 0);
        $this->db->where('ma.kategori_id', $kategori_id); 
        // Filter: Exclude aset yang sudah ada di trx_masuk_detail
        $this->db->where("ma.asset_id NOT IN ($subquery)", NULL, FALSE); 
        
        return $this->db->get()->result_array();
    }

    public function simpan_transaksi_aset($data_header, $asset_id, $detail_ket)
    {
        $this->db->trans_start();

        // 1. Insert Header Transaksi
        $this->db->insert($this->table, $data_header);
        $id_header = $this->db->insert_id();

        // 2. Insert Detail Transaksi (Default Qty = 1 untuk Aset Tetap)
        $this->db->insert('trx_masuk_detail', [
            'masuk_id'   => $id_header,
            'asset_id'   => $asset_id,
            'asset_qty'  => 1.0000,
            'detail_ket' => $detail_ket
        ]);

        // 3. Update Stok Gudang (Upsert)
        $gudang_id = $data_header['gudang_id'];
        $cek_stok  = $this->db->get_where('dat_stok', [
            'gudang_id' => $gudang_id, 
            'asset_id'  => $asset_id
        ])->row();

        if ($cek_stok) {
            $this->db->set('stok_qty', 'stok_qty + 1', FALSE);
            $this->db->where('stok_id', $cek_stok->stok_id);
            $this->db->update('dat_stok');
        } else {
            $this->db->insert('dat_stok', [
                'gudang_id' => $gudang_id,
                'asset_id'  => $asset_id,
                'stok_qty'  => 1.0000
            ]);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_auto_number($tanggal)
    {
        $prefix = 'IN';
        $periode = date('Ym', strtotime($tanggal));
        $prefix_full = $prefix . '/' . $periode . '/'; // Format: IN/202510/
        
        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        
        $last_no = $this->db->get($this->table)->row()->transaksi_no;
        $urutan = 1;

        if ($last_no) {
            // Pecah string: IN/202510/001/SKU-ASET
            $parts = explode('/', $last_no);
            if(isset($parts[2]) && is_numeric($parts[2])) {
                $urutan = (int) $parts[2] + 1;
            }
        }
        
        return $prefix_full . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    }

    public function get_sku_by_asset_id($asset_id)
    {
        $this->db->select('asset_kd');
        $this->db->where('asset_id', $asset_id);
        $q = $this->db->get('mst_asset');
        return ($q->num_rows() > 0) ? $q->row()->asset_kd : null;
    }
}