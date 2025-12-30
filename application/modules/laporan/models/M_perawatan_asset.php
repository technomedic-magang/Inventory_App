<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_perawatan_asset extends CI_Model
{
    var $table = 'dat_service';
    var $pk_id = 'service_id';

    public function load_datatables()
    {
        // 1. QUERY MANUAL (Gaya Referensi)
        $query = "SELECT 
                    s.*, 
                    a.asset_nm, 
                    a.asset_kd, 
                    k.kategori_nm
                  FROM dat_service s
                  LEFT JOIN mst_asset a ON s.asset_id = a.asset_id
                  LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id";

        // 2. SEARCH FIELDS
        $search = ['s.bengkel_nm', 's.keterangan_txt', 'a.asset_nm', 'a.asset_kd'];
        
        // 3. WHERE DEFAULT
        $where  = ['s.deleted_st' => 0];
        
        // 4. EKSEKUSI (Pakai Helper DB Framework Anda)
        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    public function get_list_kendaraan()
    {
        $this->db->select('a.asset_id, a.asset_nm, a.asset_kd, k.kategori_nm');
        $this->db->from('mst_asset a');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id', 'left');
        $this->db->where('a.deleted_st', 0);
        $this->db->where('a.active_st', 1);
        
        // Filter Kategori: K2 (Motor) atau K4 (Mobil) atau yang ada nama 'Kendaraan'
        $this->db->group_start();
            $this->db->like('k.kategori_kd', 'K2');
            $this->db->or_like('k.kategori_kd', 'K4');
            $this->db->or_like('k.kategori_nm', 'Kendaraan'); 
        $this->db->group_end();

        $this->db->order_by('a.asset_nm', 'ASC');
        return $this->db->get()->result_array();
    }
}