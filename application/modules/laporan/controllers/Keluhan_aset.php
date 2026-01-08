<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keluhan_aset extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Load Model dengan helper bawaan project
        _models(['laporan/m_keluhan_aset']);
        
        // Konfigurasi dasar modul
        $this->uri    = 'laporan/keluhan_aset'; 
        $this->template   = 'laporan/keluhan_aset/';
        
        // Helper & Library tambahan
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        // Ambil data (query builder standard)
        $d['keluhan'] = $this->m_keluhan_aset->get_all_keluhan();
        
        // Judul halaman (biasanya dipakai di template header)
        $d['title']   = "Daftar Keluhan Aset";

        // Render view menggunakan Template Master (header/sidebar otomatis muncul)
        $this->render($this->template . 'index', $d);
    }

    // --- FUNGSI AKSI (ACC & SELESAI) ---

    public function acc_tiket($keluhan_id)
    {
        if (empty($keluhan_id)) redirect($this->uri_mod);

        $update = $this->m_keluhan_aset->update_status_tiket($keluhan_id, 'DIPROSES');
        $this->_set_msg($update, 'Tiket berhasil di-ACC (Diproses).');
        
        redirect($this->uri_mod);
    }

    public function selesaikan_tiket($keluhan_id, $asset_id)
    {
        if (empty($keluhan_id) || empty($asset_id)) redirect($this->uri_mod);

        // Update Tiket & Aset
        $up_tiket = $this->m_keluhan_aset->update_status_tiket($keluhan_id, 'SELESAI');
        $up_asset = $this->m_keluhan_aset->update_kondisi_asset($asset_id, 'BAIK');

        $this->_set_msg(($up_tiket && $up_asset), 'Perbaikan Selesai. Aset kembali BAIK.');

        redirect($this->uri_mod);
    }
    
    // Helper kecil untuk flash message standar
    private function _set_msg($status, $text_success)
    {
        if($status) {
            $this->session->set_flashdata('msg', $text_success);
            $this->session->set_flashdata('msg_type', 'success');
        } else {
            $this->session->set_flashdata('msg', 'Gagal memproses data.');
            $this->session->set_flashdata('msg_type', 'danger');
        }
    }
}