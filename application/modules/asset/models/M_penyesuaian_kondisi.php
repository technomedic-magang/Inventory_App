<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_penyesuaian_kondisi extends CI_Model
{
    var $table = 'log_asset_kondisi';
    var $pk_id = 'log_id';

    public function load_datatables()
    {
        $query = "SELECT l.*, a.asset_kd, a.asset_nm
                  FROM log_asset_kondisi l
                  LEFT JOIN mst_asset a ON l.asset_id = a.asset_id";
                  
        $search = ['a.asset_kd', 'a.asset_nm', 'l.kondisi_ke', 'l.transaksi_ket', 'l.transaksi_no'];
        $where  = ['l.deleted_st' => 0]; // Filter deleted_st dipisah agar aman
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // Mesin Auto Number (COND/YYYYMM/0001)
    public function get_auto_number($tanggal)
    {
        $prefix = 'COND'; 
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

    // Simpan Log & Update Master Asset
    public function simpan_penyesuaian($data_log, $asset_id, $kondisi_baru)
    {
        $this->db->trans_start();

        // 1. Insert Berita Acara (Log)
        $this->db->insert($this->table, $data_log);
        
        // 2. Update Status di Master Aset
        $this->db->where('asset_id', $asset_id);
        $this->db->update('mst_asset', ['asset_kondisi' => $kondisi_baru]);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}