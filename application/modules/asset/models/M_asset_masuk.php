<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_asset_masuk extends CI_Model
{
    var $table = 'trx_masuk';
    var $pk_id = 'masuk_id';

    public function load_datatables()
    {
        $query = "SELECT 
                    t.masuk_id, t.transaksi_tgl, t.transaksi_no,
                    t.transaksi_ket, g.gudang_nm
                FROM trx_masuk t
                LEFT JOIN mst_gudang g ON t.gudang_id = g.gudang_id";
        $search = ['t.transaksi_no', 't.transaksi_ket', 'g.gudang_nm'];
        $where  = ['t.deleted_st' => 0];
        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // [BARU] Ambil aset berdasarkan Kategori (Filter yang belum masuk)
    public function get_assets_by_kategori_id($kategori_id)
    {
        // 1. Ambil ID aset yang SUDAH masuk (untuk di-exclude)
        $subquery = $this->db->select('asset_id')
                             ->from('trx_masuk_detail')
                             ->get_compiled_select();

        // [PERBAIKAN DI SINI]
        // Tambahkan 'mst_asset.' di depan nama kolom agar tidak ambiguous
        $this->db->select('mst_asset.asset_id, mst_asset.asset_kd, mst_asset.asset_nm, mst_asset.kategori_id');
        
        $this->db->from('mst_asset');
        // Join Kategori untuk mengambil kodenya (perlu untuk JS nanti)
        $this->db->join('mst_kategori', 'mst_asset.kategori_id = mst_kategori.kategori_id', 'left');
        $this->db->select('mst_kategori.kategori_kd'); 

        $this->db->where('mst_asset.deleted_st', 0);
        // Pastikan where ini juga spesifik (mst_asset.kategori_id)
        $this->db->where('mst_asset.kategori_id', $kategori_id); 
        $this->db->where("mst_asset.asset_id NOT IN ($subquery)", NULL, FALSE); 
        
        return $this->db->get()->result_array();
    }

    public function simpan_transaksi_aset($data_header, $asset_id, $detail_ket)
    {
        $this->db->trans_start();

        // 1. Insert Header
        $this->db->insert($this->table, $data_header);
        $id_header = $this->db->insert_id();

        // 2. Insert Detail (Kuantitas = 1)
        $this->db->insert('trx_masuk_detail', [
            'masuk_id'   => $id_header,
            'asset_id'   => $asset_id,
            'asset_qty'  => 1.0000,
            'detail_ket' => $detail_ket
        ]);

        // 3. Update Stok (Logika UPSERT)
        $gudang_id = $data_header['gudang_id'];
        $cek_stok = $this->db->get_where('dat_stok', ['gudang_id' => $gudang_id, 'asset_id' => $asset_id])->row();
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
        $prefix_full = $prefix . '/' . $periode . '/';
        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        $last_no = $this->db->get($this->table)->row()->transaksi_no;
        
        $urutan = 1;
        if ($last_no) {
            $parts = explode('/', $last_no);
            // Ambil bagian urutan (index ke-2 dalam format IN/YYYYMM/001/SKU)
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