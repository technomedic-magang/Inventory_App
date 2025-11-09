<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pinjam extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['asset/m_pinjam']);
        $this->table = $this->m_pinjam->table;
        $this->pk_id = $this->m_pinjam->pk_id;
        $this->template = 'asset/pinjam/';
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = $this->uri . '/save/' . $id;

        if ($id == null) {
            $d['preview_no'] = $this->m_pinjam->get_auto_number(date('Y-m-d'));
        }

        $d['list_pegawai'] = $this->db->select('pegawai_id, pegawai_nm, user_id')->where(['deleted_st' => 0, 'active_st' => 1])->get('mst_pegawai')->result_array();
        $d['list_gudang']  = $this->db->where(['deleted_st' => 0, 'active_st' => 1])->get('mst_gudang')->result_array();
        $d['list_asset']   = $this->db->where(['deleted_st' => 0, 'active_st' => 1])->get('mst_asset')->result_array();

        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        if ($id != null) return;

        $tgl = $this->input->post('transaksi_tgl');
        $auto_no = $this->m_pinjam->get_auto_number($tgl);

        $data_header = [
            'transaksi_no'        => $auto_no,
            'transaksi_tgl'       => $tgl,
            'kembali_rencana_tgl' => $this->input->post('kembali_rencana_tgl'),
            'pegawai_id'          => $this->input->post('pegawai_id'),
            'transaksi_ket'       => $this->input->post('transaksi_ket'),
            'pinjam_sts'          => 'OPEN',
            'active_st' => 1, 'deleted_st' => 0
        ];

        $data_detail = [
            'gudang_id'  => $this->input->post('gudang_id'),
            'asset_id'   => $this->input->post('asset_id'),
            'pinjam_qty' => $this->input->post('pinjam_qty')
        ];

        if ($this->m_pinjam->simpan_transaksi($data_header, $data_detail)) {
            _json(_response('01', $this->uri));
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan. Cek stok barang.']);
        }
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', $this->uri));
    }

    public function ajax_datatables()
    {
        $this->m_pinjam->load_datatables();
    }

    public function get_no_transaksi_ajax()
    {
        $tgl = $this->input->post('tanggal');
        echo json_encode(['new_no' => $this->m_pinjam->get_auto_number($tgl)]);
    }

    // Tambahkan di paling bawah file Pinjam.php
    public function get_assets_by_gudang()
    {
        $gudang_id = $this->input->post('gudang_id');
        echo json_encode($this->m_pinjam->get_assets_available($gudang_id));
    }
}