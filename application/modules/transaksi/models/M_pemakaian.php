<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_pemakaian extends CI_Model
{
    public $table = 'trx_pemakaian';
    public $pk_id = 'pemakaian_id';

    public function load_datatables()
    {
        $query = "SELECT t.*, p.pegawai_nm, p.user_id
                  FROM trx_pemakaian t
                  LEFT JOIN mst_pegawai p ON t.pegawai_id = p.pegawai_id";

        $search = ['t.transaksi_no', 't.transaksi_ket', 'p.pegawai_nm', 't.pemakaian_sts'];
        
        // Filter hanya yang tidak dihapus
        $where  = ['t.deleted_st' => 0]; 
        $isWhere = null;
        $order = ['t.transaksi_tgl' => 'DESC'];

        DB::datatables_query($query, $search, $where, $isWhere, $order);
    }

    public function get_assets_available($gudang_id)
    {
        $this->db->select('s.asset_id, s.stok_qty, a.asset_nm, a.asset_kd, sat.satuan_nm');
        $this->db->select('v_merk.value_isi as merk, v_nopol.value_isi as nopol, v_spek.value_isi as spesifikasi, v_merek_tipe.value_isi as merek_tipe');

        $this->db->from('dat_stok s');
        $this->db->join('mst_asset a', 's.asset_id = a.asset_id');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id');
        $this->db->join('mst_satuan sat', 'a.satuan_id = sat.satuan_id', 'left');
        
        $this->_join_attribute('Merek', 'v_merk');
        $this->_join_attribute('Polisi', 'v_nopol', true);
        $this->_join_attribute('Spesifikasi', 'v_spek', true);
        $this->_join_attribute('Merek & Tipe', 'v_merek_tipe');

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

    public function simpan_transaksi($data_header, $asset_id, $gudang_id, $qty_pakai)
    {
        $this->db->trans_start();

        $this->db->insert($this->table, $data_header);
        $id_header = $this->db->insert_id();

        if (!empty($asset_id) && $qty_pakai > 0) {
            $this->db->insert('trx_pemakaian_detail', [
                'pemakaian_id'  => $id_header,
                'asset_id'      => $asset_id,
                'gudang_id'     => $gudang_id,
                'pemakaian_qty' => $qty_pakai,
                'kembali_qty'   => 0,
                'created_at'    => date('Y-m-d H:i:s')
            ]);

            $this->db->set('stok_qty', 'stok_qty - ' . $qty_pakai, FALSE);
            $this->db->where(['gudang_id' => $gudang_id, 'asset_id' => $asset_id]);
            $this->db->update('dat_stok');
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // [KEMBALI KE LOGIKA AWAL]
    // Hapus data, tapi jika barang belum kembali, stok dikembalikan dulu
    public function hapus_transaksi($id)
    {
        $this->db->trans_start();

        $trx = $this->db->get_where($this->table, [$this->pk_id => $id])->row();
        
        // Jika masih OPEN, kembalikan stok dulu
        if ($trx && $trx->pemakaian_sts == 'OPEN') {
             $details = $this->db->get_where('trx_pemakaian_detail', ['pemakaian_id' => $id])->result_array();
             foreach ($details as $d) {
                // Sisa yang belum dikembalikan
                $sisa = $d['pemakaian_qty'] - $d['kembali_qty'];
                if($sisa > 0) {
                    $this->db->set('stok_qty', 'stok_qty + ' . $sisa, FALSE);
                    $this->db->where(['asset_id' => $d['asset_id'], 'gudang_id' => $d['gudang_id']]);
                    $this->db->update('dat_stok');
                }
            }
        }

        // Soft Delete (Sembunyikan Data) dan Set Status DIBATALKAN
        $this->db->where($this->pk_id, $id);
        $this->db->update($this->table, [
            'deleted_st' => 1,
            'pemakaian_sts' => 'DIBATALKAN'
        ]);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    private function _join_attribute($label, $alias, $is_like = false)
    {
        $condition = "attr_$alias.kategori_id = a.kategori_id AND attr_$alias.atribut_label";
        $condition .= $is_like ? " LIKE '%$label%'" : " = '$label'";
        $this->db->join("mst_kategori_atribut attr_$alias", $condition, 'left');
        $this->db->join("dat_asset_value $alias", "$alias.asset_id = a.asset_id AND $alias.atribut_id = attr_$alias.atribut_id", 'left');
    }
}