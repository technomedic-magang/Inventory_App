<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mutasi_asset extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        _models(['formulir/m_mutasi_asset']);
        $this->table = $this->m_mutasi_asset->table;
        $this->template = 'formulir/mutasi_asset/';
    }

    public function index() {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null) {
        $d['form_act'] = $this->uri . '/save';
        // Ambil semua pegawai aktif
        $d['list_pegawai'] = $this->db->get_where('mst_pegawai', ['active_st'=>1])->result_array();
        $this->render($this->template . 'form_modal', $d);
    }

    public function save() {
        $header = [
            'transaksi_no' => 'MTS/'.date('Ymd').'/'.rand(1000,9999), // Simple Auto Number
            'transaksi_tgl' => $this->input->post('tgl_mutasi'),
            'pegawai_asal_id' => $this->input->post('pegawai_asal'),
            'pegawai_tujuan_id' => $this->input->post('pegawai_tujuan'),
            'keterangan' => $this->input->post('keterangan'),
            'created_by' => 'ADMIN'
        ];

        $assets = $this->input->post('asset_id'); // Array
        $olds   = $this->input->post('pemakaian_id'); // Array

        if($this->m_mutasi_asset->simpan_mutasi($header, $assets, $olds)) {
            _json(_response('01', $this->uri));
        } else {
            _json(['status' => '00', 'msg' => 'Gagal Mutasi']);
        }
    }

    // API: Ambil barang yang dipegang pegawai asal
    public function get_pegawai_assets() {
        $pid = $this->input->post('pegawai_id');
        $data = $this->m_mutasi_asset->get_assets_held_by_pegawai($pid);
        echo json_encode($data);
    }
    
    public function ajax_datatables() {
        $this->m_mutasi_asset->load_datatables();
    }
}