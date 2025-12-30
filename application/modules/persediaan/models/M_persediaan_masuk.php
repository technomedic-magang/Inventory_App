<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_persediaan_masuk extends CI_Model {

    public $table = 'dat_persediaan_masuk';
    public $pk_id = 'masuk_id';

    var $column_order = array(null, null, 't.beli_tgl', 't.struk_no', 'p.barang_nm', 'k.kategori_nm', 'd.masuk_qty');
    var $column_search = array('t.struk_no', 'p.barang_nm', 'k.kategori_nm'); 

    // --- [GENERATOR NOMOR BARU: FORMAT ATK-2025.03.23-0001] ---
    public function get_nomor_urut($kategori_id, $tanggal)
    {
        // 1. Cari Kode Kategori dari ID
        $kode_kat = 'GEN';
        if (!empty($kategori_id)) {
            $this->db->select('kategori_kd');
            $this->db->where('kategori_id', $kategori_id);
            $q = $this->db->get('mst_kategori_persediaan');
            if ($q->num_rows() > 0) {
                $row = $q->row();
                if (!empty($row->kategori_kd)) {
                    $kode_kat = $row->kategori_kd;
                }
            }
        }

        // 2. Format Tanggal dengan TITIK (2025.03.23)
        if(empty($tanggal)) $tanggal = date('Y-m-d');
        $date_format = date('Y.m.d', strtotime($tanggal));
        
        // 3. Prefix: KODE-TANGGAL- (Contoh: ATK-2025.03.23-)
        $prefix = $kode_kat . '-' . $date_format . '-';
        
        // 4. Query Nomor Terakhir
        // Kita cari struk_no yang depannya mirip prefix
        $this->db->select('struk_no');
        $this->db->from('dat_persediaan_masuk');
        $this->db->like('struk_no', $prefix, 'after'); 
        $this->db->order_by('struk_no', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $last_no = $query->row()->struk_no; // Contoh: ATK-2025.03.23-0005
            
            // Ambil angka paling belakang (setelah strip terakhir)
            // Explode string berdasarkan strip, ambil elemen terakhir
            $parts = explode('-', $last_no);
            $last_seq = end($parts);
            
            $urutan = (int) $last_seq + 1;
        } else {
            $urutan = 1;
        }

        // 5. Return dengan 4 Digit (0001)
        return $prefix . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    public function simpan_restock($data_header, $data_detail) {
        $this->db->trans_start();
        $this->db->insert('dat_persediaan_masuk', $data_header);
        $masuk_id = $this->db->insert_id();
        foreach ($data_detail as $item) {
            $item['masuk_id'] = $masuk_id;
            $this->db->insert('dat_persediaan_masuk_det', $item);
            $this->db->set('stok_qty', 'stok_qty + ' . floatval($item['masuk_qty']), FALSE);
            $this->db->set('updated_at', date('Y-m-d H:i:s'));
            $this->db->set('updated_by', $this->session->userdata('user_id'));
            $this->db->where('persediaan_id', $item['persediaan_id']);
            $this->db->update('mst_persediaan');
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

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
        $this->db->select('t.*, d.masuk_qty, p.barang_nm, k.kategori_nm, s.satuan_nm');
        $this->db->from('dat_persediaan_masuk t');
        $this->db->join('dat_persediaan_masuk_det d', 't.masuk_id = d.masuk_id');
        $this->db->join('mst_persediaan p', 'd.persediaan_id = p.persediaan_id');
        $this->db->join('mst_kategori_persediaan k', 'p.kategori_id = k.kategori_id', 'left');
        $this->db->join('mst_satuan s', 'd.satuan_id = s.satuan_id', 'left');
        $this->db->where('t.deleted_st', 0);

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
        $order = $this->input->post('order');
        if($order) { $this->db->order_by($this->column_order[$order['0']['column']], $order['0']['dir']); } 
        else { $this->db->order_by('t.beli_tgl', 'DESC'); }
    }

    private function _count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function _count_all() {
        $this->db->from('dat_persediaan_masuk');
        $this->db->where('deleted_st', 0);
        return $this->db->count_all_results();
    }
}