<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_service extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['laporan/m_riwayat_service']);
        
        $this->table = $this->m_riwayat_service->table;
        $this->pk_id = $this->m_riwayat_service->pk_id;
        
        $this->template = 'laporan/riwayat_service/'; 
        $this->uri = 'laporan/riwayat_service'; 
    }

    public function index()
    {
        // [MODIFIKASI] Kirim data kategori untuk filter di halaman utama
        $d['list_kategori'] = $this->m_riwayat_service->get_all_kategori();
        $this->render($this->template . 'index', $d);
    }

    public function ajax_datatables()
    {
        $this->m_riwayat_service->load_datatables();
    }

    // --- FORM MODAL (VERSI STOCK - CLIENT SIDE FILTER) ---
    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = site_url($this->uri . '/save' . ($id ? '/' . $id : ''));

        // Ambil Data Pendukung (Load Semua di Awal)
        $d['list_asset']    = $this->m_riwayat_service->get_all_assets();
        $d['list_kategori'] = $this->m_riwayat_service->get_all_kategori();

        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $d = _post();

        if (empty($d['asset_id'])) { _json(['status' => false, 'msg' => 'Aset wajib dipilih.']); return; }
        if (empty($d['tgl_service'])) { _json(['status' => false, 'msg' => 'Tanggal wajib diisi.']); return; }
        
        // Helper konversi tanggal
        $tgl_service_sql = $this->_convert_date($d['tgl_service']);
        $tgl_berikutnya_sql = !empty($d['tgl_berikutnya']) ? $this->_convert_date($d['tgl_berikutnya']) : NULL;

        // Bersihkan format ribuan
        $km_now  = !empty($d['kilometer_saat_ini']) ? str_replace('.', '', $d['kilometer_saat_ini']) : 0;
        $km_next = !empty($d['kilometer_berikutnya']) ? str_replace('.', '', $d['kilometer_berikutnya']) : 0;
        $biaya   = !empty($d['biaya']) ? str_replace('.', '', $d['biaya']) : 0;

        $data = [
            'asset_id'           => $d['asset_id'],
            'tgl_service'        => $tgl_service_sql,     
            'bengkel_nm'         => $d['bengkel_nm'],
            'biaya'              => $biaya,
            'keterangan_txt'     => $d['keterangan_txt'],
            'kilometer_saat_ini'   => $km_now,
            'tgl_berikutnya'       => $tgl_berikutnya_sql, 
            'kilometer_berikutnya' => $km_next,
        ];

        $redirect_uri = site_url($this->uri . '?n=' . $this->input->get('n'));

        if ($id == null) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['deleted_st'] = 0;
            DB::insert($this->table, $data);
            _json(_response('01', $redirect_uri));
        } else {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $this->session->userdata('user_id');
            DB::update($this->table, $data, [$this->pk_id => $id]);
            _json(_response('02', $redirect_uri));
        }
    }
    
    public function delete($id = null) {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', site_url($this->uri . '?n=' . $this->input->get('n'))));
    }

    private function _convert_date($date_raw) {
        if (strpos($date_raw, '-') !== false) {
            $parts = explode('-', $date_raw);
            if(count($parts) == 3) {
                return date('Y-m-d', strtotime($date_raw));
            }
        }
        return $date_raw;
    }
}