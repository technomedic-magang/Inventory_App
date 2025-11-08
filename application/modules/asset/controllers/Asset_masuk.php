<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asset_masuk extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['asset/m_asset_masuk']);
        $this->table = $this->m_asset_masuk->table;
        $this->pk_id = $this->m_asset_masuk->pk_id;
        $this->template = 'asset/asset/';
    }

    public function index()
    {
        $d = []; // Inisialisasi variabel data
        $this->render($this->template . 'index', $d);
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = $this->uri . '/save/' . $id;
        $d['list_barang'] = $this->db->get('mst_asset')->result_array();
        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        if ($id != null) {
            // Kirim respon error JSON agar form modal tidak bengong
            echo json_encode(['status' => '00', 'msg' => 'Maaf, Edit Transaksi belum didukung.']);
            return;
        }

        $data_header = [
            'tanggal_masuk' => $this->input->post('tanggal_masuk'),
            'no_transaksi'  => $this->input->post('no_transaksi'),
            'keterangan'    => $this->input->post('keterangan'),
            'active_st'     => 1,
            'deleted_st'    => 0,
            // 'created_by' => $this->session->userdata('user_id')
        ];

        $data_detail = [
            'asset_id'   => $this->input->post('asset_id'),
            'jumlah'     => $this->input->post('jumlah'),
            'ket_detail' => $this->input->post('ket_detail')
        ];

        $sukses = $this->m_asset_masuk->simpan_transaksi_lengkap($data_header, $data_detail);

        if ($sukses) {
            _json(_response('01', $this->uri));
        } else {
            // Gunakan format error standar template jika ada
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan transaksi.']);
        }
    }

    // --- PASTIKAN BAGIAN INI ADA ---
    public function delete($id = null)
    {
        $w = ($id != '' ? [$this->pk_id => $id] : null);
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', $this->uri));
    }

    public function ajax_datatables()
    {
        $this->m_asset_masuk->load_datatables();
    }
}