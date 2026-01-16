<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_persediaan_masuk extends CI_Model {

    public $table = 'dat_persediaan_masuk';
    public $pk_id = 'masuk_id';

    public function load_datatables() 
    {
        // Query Utama dengan Join
        $query = "SELECT t.*, d.masuk_qty, p.barang_nm, k.kategori_nm, s.satuan_nm 
                  FROM dat_persediaan_masuk t
                  JOIN dat_persediaan_masuk_det d ON t.masuk_id = d.masuk_id
                  JOIN mst_persediaan p ON d.persediaan_id = p.persediaan_id
                  LEFT JOIN mst_kategori_persediaan k ON p.kategori_id = k.kategori_id
                  LEFT JOIN mst_satuan s ON d.satuan_id = s.satuan_id";

        $search_fields = ['t.struk_no', 'p.barang_nm', 'k.kategori_nm'];
        $where_clauses = ['t.deleted_st' => 0];

        // [PERBAIKAN] Parameter ke-4 ($isWhere) harus NULL atau String, bukan Array.
        // Ordering sudah ditangani otomatis oleh library berdasarkan request dari JS (order: [[2, 'desc']])
        $isWhere = null;

        DB::datatables_query($query, $search_fields, $where_clauses, $isWhere);
    }

    // --- Generator Nomor (ATK-2025.03.23-0001) ---
    public function get_nomor_urut($kategori_id, $tanggal)
    {
        // 1. Ambil Kode Kategori
        $kode_kat = 'GEN';
        if (!empty($kategori_id)) {
            $kat = $this->db->get_where('mst_kategori_persediaan', ['kategori_id' => $kategori_id])->row();
            if ($kat && !empty($kat->kategori_kd)) {
                $kode_kat = $kat->kategori_kd;
            }
        }

        // 2. Format Tanggal (YYYY.MM.DD)
        if(empty($tanggal)) $tanggal = date('Y-m-d');
        $date_format = date('Y.m.d', strtotime($tanggal));
        
        // 3. Susun Prefix
        $prefix = $kode_kat . '-' . $date_format . '-';
        
        // 4. Cari Urutan Terakhir
        $this->db->select('struk_no');
        $this->db->like('struk_no', $prefix, 'after'); 
        $this->db->order_by('struk_no', 'DESC');
        $this->db->limit(1);
        $last_data = $this->db->get($this->table)->row();

        $urutan = 1;
        if ($last_data) {
            // Ambil angka setelah strip terakhir
            $parts = explode('-', $last_data->struk_no);
            $last_seq = end($parts);
            $urutan = (int) $last_seq + 1;
        }

        // 5. Return Format Lengkap
        return $prefix . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    public function simpan_restock($data_header, $data_detail) 
    {
        $this->db->trans_start();

        // 1. Simpan Header
        $this->db->insert($this->table, $data_header);
        $masuk_id = $this->db->insert_id();

        // 2. Simpan Detail & Update Stok Master
        foreach ($data_detail as $item) {
            $item['masuk_id'] = $masuk_id;
            
            $this->db->insert('dat_persediaan_masuk_det', $item);
            
            // Direct Update Stok (Efisiensi)
            $this->db->set('stok_qty', 'stok_qty + ' . floatval($item['masuk_qty']), FALSE);
            $this->db->set('updated_at', date('Y-m-d H:i:s'));
            $this->db->set('updated_by', $this->session->userdata('user_id'));
            $this->db->where('persediaan_id', $item['persediaan_id']);
            $this->db->update('mst_persediaan');
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}