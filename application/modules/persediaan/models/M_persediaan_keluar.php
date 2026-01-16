<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_persediaan_keluar extends CI_Model {

    public $table = 'dat_persediaan_keluar';
    public $pk_id = 'keluar_id';

    public function load_datatables() 
    {
        // Query Utama
        $query = "SELECT 
                    t.keluar_id, t.keluar_tgl, t.struk_no, t.keperluan_jenis, t.penerima_nm, t.keterangan_txt,
                    d.keluar_qty,
                    p.barang_nm,
                    k.kategori_nm,
                    s.satuan_nm
                  FROM dat_persediaan_keluar t
                  JOIN dat_persediaan_keluar_det d ON t.keluar_id = d.keluar_id
                  JOIN mst_persediaan p ON d.persediaan_id = p.persediaan_id
                  LEFT JOIN mst_kategori_persediaan k ON p.kategori_id = k.kategori_id
                  LEFT JOIN mst_satuan s ON d.satuan_id = s.satuan_id";
        
        $search_fields = ['t.struk_no', 'p.barang_nm', 't.penerima_nm', 't.keperluan_jenis'];
        $where_clauses = ['t.deleted_st' => 0];
        
        // Sorting Default
        $order = ['t.keluar_tgl' => 'DESC'];
        
        // Parameter ke-4 harus null/string
        $isWhere = null; 

        DB::datatables_query($query, $search_fields, $where_clauses, $isWhere);
    }

    // --- Helper Functions ---

    public function get_stok_item($persediaan_id)
    {
        $this->db->select('stok_qty');
        $this->db->where('persediaan_id', $persediaan_id);
        $q = $this->db->get('mst_persediaan');
        return ($q->num_rows() > 0) ? floatval($q->row()->stok_qty) : 0;
    }

    public function get_nomor_urut($prefix_kode, $tanggal)
    {
        if(empty($tanggal)) $tanggal = date('Y-m-d');
        $date_format = date('Y.m.d', strtotime($tanggal));
        
        // Format: OUT-KODE-YYYY.MM.DD-
        $prefix = $prefix_kode . '-' . $date_format . '-';
        
        $this->db->select('struk_no');
        $this->db->like('struk_no', $prefix, 'after'); 
        $this->db->order_by('struk_no', 'DESC');
        $this->db->limit(1);
        $last_data = $this->db->get($this->table)->row();

        $urutan = 1;
        if ($last_data) {
            $parts = explode('-', $last_data->struk_no);
            $last_seq = end($parts);
            $urutan = (int) $last_seq + 1;
        }

        return $prefix . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    public function simpan_pemakaian($data_header, $data_detail) 
    {
        $this->db->trans_start();

        // 1. Simpan Header
        $this->db->insert($this->table, $data_header);
        $keluar_id = $this->db->insert_id();

        // 2. Simpan Detail & Kurangi Stok
        foreach ($data_detail as $item) {
            $item['keluar_id'] = $keluar_id;
            
            $this->db->insert('dat_persediaan_keluar_det', $item);

            // Update Stok (Decrement)
            $this->db->set('stok_qty', 'stok_qty - ' . floatval($item['keluar_qty']), FALSE);
            $this->db->set('updated_at', date('Y-m-d H:i:s'));
            $this->db->set('updated_by', $this->session->userdata('user_id'));
            $this->db->where('persediaan_id', $item['persediaan_id']);
            $this->db->update('mst_persediaan');
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}