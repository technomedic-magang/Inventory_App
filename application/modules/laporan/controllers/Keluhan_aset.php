<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keluhan_aset extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // 1. Load Model sesuai standar project (menggunakan helper _models)
        _models(['laporan/m_keluhan_aset']);
        
        // 2. Setup properti dasar module
        $this->uri    = 'laporan/keluhan_aset'; 
        $this->template   = 'laporan/keluhan_aset/';
        
        // Load library/helper standar (biasanya sudah autoload, tapi kita pastikan)
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        // 3. Ambil data (Tidak pakai Datatables AJAX dulu, pakai query biasa sesuai request)
        $d['keluhan'] = $this->m_keluhan_aset->get_all_keluhan();
        
        $d['title'] = "Daftar Keluhan Aset";

        // 4. Render View menggunakan template master (MY_Controller)
        $this->render($this->template . 'index', $d);
    }

    /**
     * Fungsi: ACC Tiket
     */
    public function acc_tiket($keluhan_id)
    {
        if (empty($keluhan_id)) {
            redirect($this->uri_mod);
        }

        $update = $this->m_keluhan_aset->update_status_tiket($keluhan_id, 'DIPROSES');

        if ($update) {
            $this->session->set_flashdata('msg', 'Berhasil! Tiket telah di-ACC.');
            $this->session->set_flashdata('msg_type', 'success');
        } else {
            $this->session->set_flashdata('msg', 'Gagal update status.');
            $this->session->set_flashdata('msg_type', 'danger');
        }

        redirect($this->uri_mod);
    }

    /**
     * Fungsi: Selesaikan Perbaikan
     */
    public function selesaikan_tiket($keluhan_id, $asset_id)
    {
        if (empty($keluhan_id) || empty($asset_id)) {
            $this->session->set_flashdata('msg', 'ID tidak valid.');
            $this->session->set_flashdata('msg_type', 'danger');
            redirect($this->uri_mod);
        }

        // Update status tiket & kondisi aset
        $up_tiket = $this->m_keluhan_aset->update_status_tiket($keluhan_id, 'SELESAI');
        $up_asset = $this->m_keluhan_aset->update_kondisi_asset($asset_id, 'BAIK');

        if ($up_tiket && $up_asset) {
            $this->session->set_flashdata('msg', 'Perbaikan Selesai. Aset kembali BAIK.');
            $this->session->set_flashdata('msg_type', 'success');
        } else {
            $this->session->set_flashdata('msg', 'Terjadi kesalahan sistem.');
            $this->session->set_flashdata('msg_type', 'danger');
        }

        redirect($this->uri_mod);
    }
}