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

<<<<<<< HEAD
=======
    // Tambahkan fungsi ini di model

    public function get_assets_available_by_kategori($kategori_id)
    {
        // Select Data Utama
        $this->db->select('a.asset_id, a.asset_kd, a.asset_nm, a.asset_kondisi, g.gudang_nm');
        
        // Select Atribut Tambahan
        $this->db->select('v_merk.value_isi as merk');
        $this->db->select('v_nopol.value_isi as nopol');
        $this->db->select('v_spek.value_isi as spesifikasi');
        $this->db->select('v_merek_tipe.value_isi as merek_tipe');

        $this->db->from('mst_asset a');
        $this->db->join('dat_stok s', 'a.asset_id = s.asset_id'); // Join Stok
        $this->db->join('mst_gudang g', 's.gudang_id = g.gudang_id');

        // JOIN ATRIBUT (Standard)
        $this->db->join('mst_kategori_atribut attr_merk', "attr_merk.kategori_id = a.kategori_id AND attr_merk.atribut_label = 'Merek'", 'left');
        $this->db->join('dat_asset_value v_merk', 'v_merk.asset_id = a.asset_id AND v_merk.atribut_id = attr_merk.atribut_id', 'left');
        
        $this->db->join('mst_kategori_atribut attr_nopol', "attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'", 'left');
        $this->db->join('dat_asset_value v_nopol', 'v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id', 'left');
        
        $this->db->join('mst_kategori_atribut attr_spek', "attr_spek.kategori_id = a.kategori_id AND attr_spek.atribut_label LIKE '%Spesifikasi%'", 'left');
        $this->db->join('dat_asset_value v_spek', 'v_spek.asset_id = a.asset_id AND v_spek.atribut_id = attr_spek.atribut_id', 'left');
        
        $this->db->join('mst_kategori_atribut attr_mt', "attr_mt.kategori_id = a.kategori_id AND attr_mt.atribut_label = 'Merek & Tipe'", 'left');
        $this->db->join('dat_asset_value v_merek_tipe', 'v_merek_tipe.asset_id = a.asset_id AND v_merek_tipe.atribut_id = attr_mt.atribut_id', 'left');

        $this->db->where('a.deleted_st', 0);
        $this->db->where('s.stok_qty >', 0); // Hanya yg ada di gudang
        
        // Filter Kategori
        if($kategori_id) {
            $this->db->where('a.kategori_id', $kategori_id);
        }

        return $this->db->get()->result_array();
    }

>>>>>>> repoB/main
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