<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kembali extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['asset/m_kembali']);
        $this->table = $this->m_kembali->table;
        $this->pk_id = $this->m_kembali->pk_id;
        $this->template = 'asset/kembali/';
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
            $d['preview_no'] = $this->m_kembali->get_auto_number(date('Y-m-d'));
        }

        $d['list_pinjam'] = $this->m_kembali->get_open_pinjam();
        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        if ($id != null) return;

        $tgl = $this->input->post('transaksi_tgl');
        $auto_no = $this->m_kembali->get_auto_number($tgl);

        $data_header = [
            'pinjam_id'     => $this->input->post('pinjam_id'),
            'transaksi_no'  => $auto_no,
            'transaksi_tgl' => $tgl,
            'transaksi_ket' => $this->input->post('transaksi_ket'),
            'active_st' => 1, 'deleted_st' => 0
        ];

        $data_detail = [
            'pinjam_detail_id' => $this->input->post('pinjam_detail_id'),
            'asset_id'         => $this->input->post('asset_id'),
            'gudang_id'        => $this->input->post('gudang_id'),
            'kembali_qty'      => $this->input->post('kembali_qty'),
            'kondisi_asset'    => $this->input->post('kondisi_asset')
        ];

        if ($this->m_kembali->simpan_pengembalian($data_header, $data_detail)) {
            _json(_response('01', $this->uri));
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan pengembalian.']);
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
        $this->m_kembali->load_datatables();
    }

    public function get_items_pinjam()
    {
        $pinjam_id = $this->input->post('pinjam_id');
        $items = $this->db->select('d.*, a.asset_nm, a.asset_kd, g.gudang_nm, s.satuan_nm, (d.pinjam_qty - d.kembali_qty) as sisa_qty')
                          ->from('trx_pinjam_detail d')
                          ->join('mst_asset a', 'd.asset_id = a.asset_id')
                          ->join('mst_satuan s', 'a.satuan_id = s.satuan_id', 'left')
                          ->join('mst_gudang g', 'd.gudang_id = g.gudang_id')
                          ->where('d.pinjam_id', $pinjam_id)
                          ->where('d.pinjam_qty > d.kembali_qty')
                          ->get()->result_array();
        echo json_encode($items);
    }

    public function get_no_transaksi_ajax()
    {
        $tgl = $this->input->post('tanggal');
        echo json_encode(['new_no' => $this->m_kembali->get_auto_number($tgl)]);
    }
}