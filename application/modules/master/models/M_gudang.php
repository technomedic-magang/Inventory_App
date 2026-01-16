<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_gudang extends CI_Model
{
    public $table = 'mst_gudang';
    public $pk_id = 'gudang_id';
    
    // Prefix untuk penomoran otomatis
    const KODE_PREFIX = 'GDG';

    public function load_datatables()
    {
        // Join ke tabel pegawai untuk mengambil nama PIC
        $query = "SELECT g.*, p.pegawai_nm as pic_nm 
                  FROM mst_gudang g
                  LEFT JOIN mst_pegawai p ON g.pegawai_id = p.pegawai_id";

        $search_fields = ['g.gudang_kd', 'g.gudang_nm', 'p.pegawai_nm', 'g.gudang_alm'];
        $where_clauses = ['g.deleted_st' => 0];
        
        DB::datatables_query($query, $search_fields, $where_clauses, null);
    }

    public function get_next_kode_gudang()
    {
        // Ambil kode terakhir berdasarkan prefix
        $this->db->select('gudang_kd');
        $this->db->like('gudang_kd', self::KODE_PREFIX . '-', 'after');
        $this->db->order_by('gudang_kd', 'DESC');
        $this->db->limit(1);
        
        $query = $this->db->get($this->table);
        $new_sequence = 1;

        if ($query->num_rows() > 0) {
            $last_kode = $query->row()->gudang_kd;
            // Parse nomor urut dari string kode (GDG-001 -> 001)
            $last_sequence = (int) substr($last_kode, strlen(self::KODE_PREFIX) + 1); 
            $new_sequence  = $last_sequence + 1;
        }

        // Return format: GDG-00X
        return self::KODE_PREFIX . '-' . str_pad($new_sequence, 3, '0', STR_PAD_LEFT);
    }
}