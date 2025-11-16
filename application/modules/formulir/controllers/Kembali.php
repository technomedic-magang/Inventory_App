<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kembali extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['formulir/m_kembali']);
        $this->table = $this->m_kembali->table;
        $this->pk_id = $this->m_kembali->pk_id;
        $this->template = 'formulir/kembali/';
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

        // Load daftar pemakaian yang masih OPEN
        $d['list_pemakaian'] = $this->m_kembali->get_open_pemakaian();
        
        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        if ($id != null) return; // Edit tidak didukung untuk menjaga integritas stok

        $tgl = $this->input->post('transaksi_tgl');
        $auto_no = $this->m_kembali->get_auto_number($tgl);

        $data_header = [
            'pemakaian_id'  => $this->input->post('pemakaian_id'),
            'transaksi_no'  => $auto_no,
            'transaksi_tgl' => $tgl,
            'transaksi_ket' => $this->input->post('transaksi_ket'),
            'active_st' => 1, 'deleted_st' => 0,
            'created_by' => 'PEGAWAI TESTER'
        ];

        // Data detail tunggal (karena formnya kita buat 1 per 1 biar aman)
        $data_detail = [
            'pemakaian_detail_id' => $this->input->post('pemakaian_detail_id'), // ID unik baris pemakaian
            'asset_id'            => $this->input->post('asset_id'),
            'gudang_id'           => $this->input->post('gudang_id'),
            'kembali_qty'         => $this->input->post('kembali_qty'),
            'kondisi_asset'       => $this->input->post('kondisi_asset')
        ];

        if ($this->m_kembali->simpan_pengembalian($data_header, $data_detail)) {
            _json(_response('01', $this->uri));
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan pengembalian.']);
        }
    }

    public function delete($id = null)
    {
        // Soft delete saja
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', $this->uri));
    }

    public function ajax_datatables()
    {
        $this->m_kembali->load_datatables();
    }
    
    public function get_no_transaksi_ajax()
    {
        $tgl = $this->input->post('tanggal');
        echo json_encode(['new_no' => $this->m_kembali->get_auto_number($tgl)]);
    }

    // API AJAX: Ambil barang yang DIPAKAI berdasarkan ID Pemakaian
    public function get_items_pemakaian()
    {
        $pemakaian_id = $this->input->post('pemakaian_id');
        
        // Ambil detail barang yang pemakaian_qty > kembali_qty (belum lunas)
        $items = $this->db->select('d.*, a.asset_nm, a.asset_kd, g.gudang_nm, sa.satuan_nm, (d.pemakaian_qty - d.kembali_qty) as sisa_qty')
                          ->from('trx_pemakaian_detail d')
                          ->join('mst_asset a', 'd.asset_id = a.asset_id')
                          ->join('mst_satuan sa', 'a.satuan_id = sa.satuan_id', 'left')
                          ->join('mst_gudang g', 'd.gudang_id = g.gudang_id')
                          ->where('d.pemakaian_id', $pemakaian_id)
                          ->where('d.pemakaian_qty > d.kembali_qty') 
                          ->get()->result_array();
        echo json_encode($items);
    }
}