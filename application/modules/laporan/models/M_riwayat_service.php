<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_riwayat_service extends CI_Model
{
    var $table = 'dat_service';
    var $pk_id = 'service_id';

    public function load_datatables()
    {
        $query = "SELECT 
                    s.*, 
                    a.asset_nm, 
                    a.asset_kd, 
                    k.kategori_nm,
                    k.kategori_kd
                  FROM dat_service s
                  LEFT JOIN mst_asset a ON s.asset_id = a.asset_id
                  LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id";

        $search = ['s.bengkel_nm', 's.keterangan_txt', 'a.asset_nm', 'a.asset_kd'];
        $where  = ['s.deleted_st' => 0];
        $isWhere = null; 
        
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // [UPDATE] Ambil SEMUA aset + Kategori ID untuk filtering
    public function get_all_assets()
    {
        // Tambahkan k.kategori_id
        $this->db->select('a.asset_id, a.asset_nm, a.asset_kd, k.kategori_nm, k.kategori_kd, k.kategori_id');
        $this->db->from('mst_asset a');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id', 'left');
        $this->db->where('a.deleted_st', 0);
        $this->db->where('a.active_st', 1);
        $this->db->order_by('a.asset_nm', 'ASC');
        return $this->db->get()->result_array();
    }

    // [BARU] Ambil List Kategori untuk Filter
    public function get_all_kategori()
    {
        return $this->db->where('deleted_st', 0)
                        ->order_by('kategori_nm', 'ASC')
                        ->get('mst_kategori')
                        ->result_array();
    }
}