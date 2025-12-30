<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan_asset extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['keuangan/m_keuangan_asset']);
        $this->table     = $this->m_keuangan_asset->table;
        $this->pk_id     = $this->m_keuangan_asset->pk_id;
        $this->template  = 'keuangan/keuangan/';
        $this->uri_mod   = 'keuangan/keuangan_asset';
    }

    public function index()
    {
        // Data pendukung untuk filter di view
        $d['list_kategori'] = $this->db->where('deleted_st', 0)
                                       ->order_by('kategori_nm', 'ASC')
                                       ->get('mst_kategori')
                                       ->result_array();
        
        // Summary Card tetap dihitung terpisah agar akurat (opsional, bisa di-ajax-kan juga jika mau)
        $d['summary'] = $this->m_keuangan_asset->get_summary_total(); 
        $d['periode_sekarang'] = date('Y-m');
        $d['is_closed'] = $this->m_keuangan_asset->cek_tutup_buku(date('Y-m'));

        $this->render($this->template . 'index', $d);
    }

    // [PENTING] Fungsi AJAX Datatables (Mirip Asset_masuk)
    public function ajax_datatables()
    {
        $this->m_keuangan_asset->load_datatables();
    }

    // --- FORM MODAL & SAVE (Sama seperti sebelumnya) ---
    public function form_modal()
    {
        $id = $this->input->get('id');
        $d['form_act'] = site_url($this->uri_mod . '/save_setting');
        $d['data'] = ($id) ? DB::get($this->table, [$this->pk_id => $id]) : [];
        $this->load->view($this->template . 'form_modal', $d);
    }

    public function save_setting()
    {
        $d = _post();
        $nominal = str_replace('.', '', $d['beli_nominal']);
        $residu  = str_replace('.', '', $d['residu_nominal']);

        if ($nominal < 0 || $residu < 0) {
            _json(_response('00', null, 'Nominal tidak boleh minus!')); return;
        }

        $data_update = [
            'beli_nominal'   => $nominal,
            'beli_tgl'       => $d['beli_tgl'],
            'pakai_masa_bln' => $d['pakai_masa_bln'],
            'residu_nominal' => $residu,
            'valuasi_metode' => $d['valuasi_metode'],
            'updated_at'     => date('Y-m-d H:i:s'),
            'updated_by'     => $this->session->userdata('user_id')
        ];

        DB::update($this->table, $data_update, [$this->pk_id => $d['asset_id']]);
        _json(_response('01', null, 'Berhasil disimpan.'));
    }

    public function proses_tutup_buku()
    {
        // (Logika tutup buku sama seperti sebelumnya)
        $periode = date('Y-m');
        if ($this->m_keuangan_asset->cek_tutup_buku($periode)) {
            _json(_response('00', null, 'Periode ini sudah ditutup!')); return;
        }
        $this->m_keuangan_asset->eksekusi_tutup_buku($periode);
        _json(_response('01', site_url($this->uri_mod)));
    }
}