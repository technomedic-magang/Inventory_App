<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_manajemen_gudang extends CI_Model
{
    var $table = 'mst_gudang';
    var $pk_id = 'gudang_id';

    public function load_datatables()
    {
<<<<<<< HEAD
        $query = "SELECT * FROM $this->table";
        // SESUAIKAN NAMA KOLOM UNTUK PENCARIAN
        $search = ['gudang_kd', 'gudang_nm', 'pic_nm', 'gudang_alm'];
        $where  = ['deleted_st' => 0];
        $isWhere = null;
=======
        // [MODIFIKASI 3] JOIN ke Tabel Pegawai untuk mengambil nama PIC
        $query = "SELECT g.*, p.pegawai_nm as pic_nm 
                  FROM mst_gudang g
                  LEFT JOIN mst_pegawai p ON g.pegawai_id = p.pegawai_id";

        // Kolom pencarian disesuaikan
        $search = ['g.gudang_kd', 'g.gudang_nm', 'p.pegawai_nm', 'g.gudang_alm'];
        $where  = ['g.deleted_st' => 0];
        $isWhere = null;
        
>>>>>>> repoB/main
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    public function get_next_kode_gudang()
    {
<<<<<<< HEAD
        $prefix = 'GG';
        // SESUAIKAN NAMA KOLOM
=======
        $prefix = 'GDG';
>>>>>>> repoB/main
        $this->db->select('gudang_kd');
        $this->db->like('gudang_kd', $prefix . '-', 'after');
        $this->db->order_by('gudang_kd', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
<<<<<<< HEAD
            $last_kode = $query->row()->gudang_kd; // gudang_kd
            $last_num  = (int) substr($last_kode, 4);
=======
            $last_kode = $query->row()->gudang_kd;
            $last_num  = (int) substr($last_kode, 4); // Ambil angka setelah 'GDG-'
>>>>>>> repoB/main
            $new_num   = $last_num + 1;
        } else {
            $new_num = 1;
        }

        return $prefix . '-' . str_pad($new_num, 3, '0', STR_PAD_LEFT);
    }
}