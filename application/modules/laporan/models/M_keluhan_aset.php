<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_keluhan_aset extends CI_Model {

    public function get_all_keluhan()
    {
        // Join trx_keluhan dengan mst_asset
        $this->db->select('t.*, m.asset_nm, m.asset_kondisi, m.asset_kd');
        $this->db->from('trx_keluhan t');
        $this->db->join('mst_asset m', 't.asset_id = m.asset_id', 'left');
        $this->db->where('t.deleted_st', 0);
        $this->db->order_by('t.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function update_status_tiket($id, $status)
    {
        $data = [
            'tiket_status' => $status,
            'updated_at'   => date('Y-m-d H:i:s'),
            'updated_by'   => $this->session->userdata('user_id')
        ];
        
        if($status == 'SELESAI'){
            $data['selesai_tgl'] = date('Y-m-d H:i:s');
        }

        $this->db->where('keluhan_id', $id);
        return $this->db->update('trx_keluhan', $data);
    }

    public function update_kondisi_asset($asset_id, $kondisi)
    {
        $data = [
            'asset_kondisi' => $kondisi,
            'updated_at'    => date('Y-m-d H:i:s')
        ];
        $this->db->where('asset_id', $asset_id);
        return $this->db->update('mst_asset', $data);
    }
}