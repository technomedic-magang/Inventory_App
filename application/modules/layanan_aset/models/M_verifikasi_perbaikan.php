<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_verifikasi_perbaikan extends CI_Model
{
    var $table = 'dat_service';
    var $pk_id = 'service_id';

    public function load_datatables_admin()
    {
        if (ob_get_length()) ob_clean(); 
        header('Content-Type: application/json');

        $sql_tiket = "CONCAT('SERV/', DATE_FORMAT(s.created_at, '%Y.%m'), '/', IFNULL(a.asset_kd, 'UNK'), '/', LPAD(s.service_id, 4, '0'))";

        $this->db->select("
            s.*, 
            $sql_tiket AS tiket_perbaikan,
            a.asset_nm, a.asset_kd,
            k.kategori_nm,
            p.pegawai_nm AS pelapor_nm
        ", FALSE); 

        $this->db->from($this->table . ' s');
        $this->db->join('mst_asset a', 's.asset_id = a.asset_id', 'left');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id', 'left');
        $this->db->join('mst_pegawai p', 's.pelapor_id = p.pegawai_id', 'left');
        $this->db->where('s.deleted_st', 0);

        // Filter Status (Opsional, bisa ditambahkan dropdown di index)
        $filter_status = $this->input->post('filter_status');
        if ($filter_status != '') {
            $this->db->where('s.status_tiket', $filter_status);
        }

        // Search Global
        $search = $this->input->post('search')['value'];
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('s.keluhan_deskripsi', $search);
            $this->db->or_like('a.asset_nm', $search);
            $this->db->or_like('a.asset_kd', $search);
            $this->db->or_like('p.pegawai_nm', $search); 
            $this->db->or_like("$sql_tiket", $search); 
            $this->db->group_end();
        }

        $this->db->order_by('s.created_at', 'DESC'); 
        
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        if($length != -1) $this->db->limit($length, $start);

        $data_raw = $this->db->get()->result_array();
        $total_all = $this->db->where('deleted_st', 0)->count_all_results($this->table);

        echo json_encode([
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $total_all,
            "recordsFiltered" => $total_all,
            "data" => $data_raw
        ]);
        exit;
    }

    public function get_detail_lengkap($id)
    {
        $this->db->select('s.*, a.asset_nm, a.asset_kd, a.asset_kondisi as kondisi_sekarang, p.pegawai_nm');
        $this->db->from($this->table . ' s');
        $this->db->join('mst_asset a', 's.asset_id = a.asset_id', 'left');
        $this->db->join('mst_pegawai p', 's.pelapor_id = p.pegawai_id', 'left');
        $this->db->where('s.service_id', $id);
        return $this->db->get()->row_array();
    }
}