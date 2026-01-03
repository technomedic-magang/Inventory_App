<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verifikasi_perbaikan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model khusus verifikasi
        _models(['laporan/m_verifikasi_perbaikan']);
        
        $this->table      = 'dat_service';
        $this->pk_id      = 'service_id';
        
        // [FIX PATH] Sesuai folder Anda: laporan
        $this->uri_mod    = 'laporan/verifikasi_perbaikan'; 
        $this->template   = 'laporan/verifikasi_perbaikan/'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        // Memanggil model admin
        $this->m_verifikasi_perbaikan->load_datatables_admin();
    }

    public function form_modal($id = null)
    {
        $d['id'] = $id; 
        $d['main'] = $this->db->get_where($this->table, [$this->pk_id => $id])->row_array();
        
        // Ambil detail lengkap (aset & pelapor)
        $d['detail'] = $this->m_verifikasi_perbaikan->get_detail_lengkap($id);
        
        $d['form_act'] = site_url($this->uri_mod . '/save_process/' . $id);

        $this->render($this->template . 'form_modal', $d);
    }

    // --- LOGIKA UTAMA PERUBAHAN STATUS ---
    public function save_process($id)
    {
        $aksi = $this->input->post('aksi_admin'); // approve, reject, finish
        
        $this->db->trans_start(); 

        $tiket = $this->db->get_where($this->table, [$this->pk_id => $id])->row();
        $asset_id = $tiket->asset_id;

        if ($aksi == 'approve') {
            // SKENARIO 1: TERIMA & JADWALKAN
            $data_update = [
                'tgl_rencana'  => $this->_convert_date($this->input->post('tgl_rencana')),
                'status_tiket' => 1, // Proses
                'updated_at'   => date('Y-m-d H:i:s'),
                'updated_by'   => $this->session->userdata('user_id')
            ];
            $this->db->update($this->table, $data_update, [$this->pk_id => $id]);
            $this->db->update('mst_asset', ['asset_kondisi' => 'PERBAIKAN'], ['asset_id' => $asset_id]);

        } elseif ($aksi == 'reject') {
            // SKENARIO 2: TOLAK
            $data_update = [
                'status_tiket' => 9, // Ditolak
                'updated_at'   => date('Y-m-d H:i:s'),
                'updated_by'   => $this->session->userdata('user_id')
            ];
            $this->db->update($this->table, $data_update, [$this->pk_id => $id]);

        } elseif ($aksi == 'finish') {
            // SKENARIO 3: SELESAI
            $kondisi_akhir = $this->input->post('kondisi_akhir'); 
            $biaya = str_replace('.', '', $this->input->post('biaya'));

            $data_update = [
                'tgl_service'  => $this->_convert_date($this->input->post('tgl_service')),
                'bengkel_nm'   => $this->input->post('bengkel_nm'),
                'biaya'        => (float) $biaya,
                'status_tiket' => 2, // Selesai
                'updated_at'   => date('Y-m-d H:i:s'),
                'updated_by'   => $this->session->userdata('user_id')
            ];

            $this->db->update($this->table, $data_update, [$this->pk_id => $id]);
            $this->db->update('mst_asset', ['asset_kondisi' => $kondisi_akhir], ['asset_id' => $asset_id]);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            _json(['status' => false, 'msg' => 'Gagal memproses data.']);
        } else {
            _json(_response('01', site_url($this->uri_mod)));
        }
    }

    private function _convert_date($date_raw) {
        if (empty($date_raw)) return date('Y-m-d');
        if (strpos($date_raw, '-') !== false) {
            $parts = explode('-', $date_raw);
            if(count($parts) == 3 && strlen($parts[2]) == 4) {
                return $parts[2] . '-' . $parts[1] . '-' . $parts[0]; 
            }
        }
        return $date_raw;
    }
}