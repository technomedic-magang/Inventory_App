<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_persediaan_keluar extends CI_Model {

    public $table = 'dat_persediaan_keluar';
    public $pk_id = 'keluar_id';

    // Kolom untuk sorting (Urutan harus sama dengan kolom di _js.php)
    // 0:No, 1:Aksi, 2:Tgl, 3:Struk, 4:Keperluan, 5:Penerima, 6:Barang, 7:Kategori, 8:Qty, 9:Satuan, 10:Ket
    var $column_order = array(null, null, 't.keluar_tgl', 't.struk_no', 't.keperluan_jenis', 't.penerima_nm', 'p.barang_nm', 'k.kategori_nm', 'd.keluar_qty', 's.satuan_nm', 't.keterangan_txt');
    
    // Kolom untuk pencarian (Search box)
    var $column_search = array('t.struk_no', 'p.barang_nm', 't.penerima_nm', 't.keperluan_jenis'); 

    // --- 1. FUNGSI CEK SISA STOK ---
    public function get_stok_item($persediaan_id)
    {
        $this->db->select('stok_qty');
        $this->db->where('persediaan_id', $persediaan_id);
        $q = $this->db->get('mst_persediaan');
        return ($q->num_rows() > 0) ? floatval($q->row()->stok_qty) : 0;
    }

    // --- 2. FUNGSI GENERATOR NOMOR (OUT-KODE-TGL-URUT) ---
    public function get_nomor_urut($prefix_kode, $tanggal)
    {
        if(empty($tanggal)) $tanggal = date('Y-m-d');
        $date_format = date('Y.m.d', strtotime($tanggal));
        
        // Prefix: OUT-ATK-2025.12.03-
        $prefix = $prefix_kode . '-' . $date_format . '-';
        
        $this->db->select('struk_no');
        $this->db->from('dat_persediaan_keluar');
        $this->db->like('struk_no', $prefix, 'after'); 
        $this->db->order_by('struk_no', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $last_no = $query->row()->struk_no;
            // Ambil angka setelah strip terakhir
            $parts = explode('-', $last_no);
            $last_seq = end($parts);
            $urutan = (int) $last_seq + 1;
        } else {
            $urutan = 1;
        }

        return $prefix . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    // --- 3. FUNGSI SIMPAN TRANSAKSI & KURANGI STOK ---
    public function simpan_pemakaian($data_header, $data_detail) {
        $this->db->trans_start();

        // A. Insert Header
        $this->db->insert('dat_persediaan_keluar', $data_header);
        $keluar_id = $this->db->insert_id();

        // B. Insert Detail & Update Stok
        foreach ($data_detail as $item) {
            $item['keluar_id'] = $keluar_id;
            
            // Simpan Detail
            $this->db->insert('dat_persediaan_keluar_det', $item);

            // Update Stok Master (MENGURANGI / DECREMENT)
            $this->db->set('stok_qty', 'stok_qty - ' . floatval($item['keluar_qty']), FALSE);
            $this->db->set('updated_at', date('Y-m-d H:i:s'));
            $this->db->set('updated_by', $this->session->userdata('user_id'));
            $this->db->where('persediaan_id', $item['persediaan_id']);
            $this->db->update('mst_persediaan');
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // --- 4. LOGIKA DATATABLES (SERVER SIDE) ---
    public function load_datatables() {
        $this->_get_datatables_query();
        if($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        
        $query = $this->db->get();
        $list = $query->result();
        
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->_count_all(),
            "recordsFiltered" => $this->_count_filtered(),
            "data" => $list,
        );
        echo json_encode($output);
    }

    private function _get_datatables_query() {
        // Select Lengkap untuk Tampilan Index
        $this->db->select('
            t.keluar_id,
            t.keluar_tgl,
            t.struk_no,
            t.keperluan_jenis,
            t.penerima_nm,
            t.keterangan_txt,
            d.keluar_qty,
            p.barang_nm,
            k.kategori_nm,
            s.satuan_nm
        ');
        $this->db->from('dat_persediaan_keluar t');
        // Join ke Detail
        $this->db->join('dat_persediaan_keluar_det d', 't.keluar_id = d.keluar_id');
        // Join ke Master Barang
        $this->db->join('mst_persediaan p', 'd.persediaan_id = p.persediaan_id');
        // Join ke Kategori
        $this->db->join('mst_kategori_persediaan k', 'p.kategori_id = k.kategori_id', 'left');
        // Join ke Satuan
        $this->db->join('mst_satuan s', 'd.satuan_id = s.satuan_id', 'left');
        
        $this->db->where('t.deleted_st', 0);

        // Logika Pencarian
        $i = 0;
        $search_value = $this->input->post('search')['value']; 
        if($search_value) {
            foreach ($this->column_search as $item) {
                if($i===0) { $this->db->group_start(); $this->db->like($item, $search_value); }
                else { $this->db->or_like($item, $search_value); }
                if(count($this->column_search) - 1 == $i) $this->db->group_end(); 
                $i++;
            }
        }
        
        // Logika Sorting
        $order = $this->input->post('order');
        if($order) { 
            $this->db->order_by($this->column_order[$order['0']['column']], $order['0']['dir']); 
        } else { 
            $this->db->order_by('t.keluar_tgl', 'DESC'); 
        }
    }

    private function _count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function _count_all() {
        $this->db->from('dat_persediaan_keluar');
        $this->db->where('deleted_st', 0);
        return $this->db->count_all_results();
    }
}