<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perbaikan_asset extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['laporan/m_perbaikan_asset']); // Load Model Baru
        
        $this->table = $this->m_perbaikan_asset->table;
        $this->pk_id = $this->m_perbaikan_asset->pk_id;
        
        $this->template = 'laporan/perbaikan_asset/'; 
        $this->uri = 'laporan/perbaikan_asset'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        $this->m_perbaikan_asset->load_datatables();
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = site_url($this->uri . '/save' . ($id ? '/' . $id : ''));

        // [UBAH] Ambil SEMUA Aset (Laptop, AC, Kendaraan, dll)
        $d['list_asset'] = $this->m_perbaikan_asset->get_list_all_asset();

        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $d = _post();

        if (empty($d['asset_id'])) { _json(['status' => false, 'msg' => 'Aset wajib dipilih.']); return; }
        if (empty($d['tgl_service'])) { _json(['status' => false, 'msg' => 'Tanggal Perbaikan wajib diisi.']); return; }
        
        $data = [
            'asset_id'           => $d['asset_id'],
            'tgl_service'        => $d['tgl_service'],
            // Kilometer opsional, isi 0 jika kosong
            'kilometer_saat_ini' => !empty($d['kilometer_saat_ini']) ? str_replace('.', '', $d['kilometer_saat_ini']) : 0,
            'bengkel_nm'         => $d['bengkel_nm'], // Bisa diisi nama toko service komputer
            'biaya'              => str_replace('.', '', $d['biaya']),
            'keterangan_txt'     => $d['keterangan_txt']
        ];

        // Redirect URL dengan token 'n'
        $redirect_uri = site_url($this->uri . '?n=' . $this->input->get('n'));

        if ($id == null) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['deleted_st'] = 0;
            DB::insert($this->table, $data);
            
            // [OPSIONAL] Update Kondisi Aset jadi 'PERBAIKAN'?
            // $this->db->update('mst_asset', ['asset_kondisi' => 'PERBAIKAN'], ['asset_id' => $d['asset_id']]);

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
}