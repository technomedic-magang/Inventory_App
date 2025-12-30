<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perawatan_asset extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['laporan/m_perawatan_asset']); 
        
        $this->table = $this->m_perawatan_asset->table;
        $this->pk_id = $this->m_perawatan_asset->pk_id;
        
        $this->template = 'laporan/perawatan_asset/'; 
        $this->uri = 'laporan/perawatan_asset'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        // Langsung panggil model sesuai gaya referensi
        $this->m_perawatan_asset->load_datatables();
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = site_url($this->uri . '/save' . ($id ? '/' . $id : ''));

        // Ambil Data Kendaraan (K2 & K4)
        $d['list_kendaraan'] = $this->m_perawatan_asset->get_list_kendaraan();

        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $d = _post();

        if (empty($d['asset_id'])) { _json(['status' => false, 'msg' => 'Kendaraan wajib dipilih.']); return; }
        if (empty($d['tgl_service'])) { _json(['status' => false, 'msg' => 'Tanggal Perawatan wajib diisi.']); return; }
        
        $data = [
            'asset_id'           => $d['asset_id'],
            'tgl_service'        => $d['tgl_service'],
            'kilometer_saat_ini' => str_replace('.', '', $d['kilometer_saat_ini']),
            'tgl_berikutnya'     => $d['tgl_berikutnya'],
            'kilometer_berikutnya' => str_replace('.', '', $d['kilometer_berikutnya']),
            'bengkel_nm'         => $d['bengkel_nm'],
            'biaya'              => str_replace('.', '', $d['biaya']),
            'keterangan_txt'     => $d['keterangan_txt']
        ];

        // [PERBAIKAN UTAMA DI SINI]
        // Gunakan site_url() agar menghasilkan alamat lengkap (http://...)
        // Ini mencegah error URL berulang/menumpuk (laporan/laporan/...)
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
}