<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemakaian extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['formulir/m_pemakaian']); 
        $this->table = $this->m_pemakaian->table;
        $this->pk_id = $this->m_pemakaian->pk_id;
        $this->template = 'formulir/pemakaian/'; 
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
            $d['preview_no'] = $this->m_pemakaian->get_auto_number(date('Y-m-d'));
        }

        $d['list_pegawai'] = $this->db->select('pegawai_id, pegawai_nm, user_id')->where(['deleted_st' => 0, 'active_st' => 1])->get('mst_pegawai')->result_array();
        $d['list_gudang']  = $this->db->where(['deleted_st' => 0, 'active_st' => 1])->get('mst_gudang')->result_array();
        
        $this->render($this->template . 'form_modal', $d);
    }

    // [REVISI] Save Single Item
    public function save($id = null)
    {
        if ($id != null) return;

        $tgl = $this->input->post('transaksi_tgl');
        $auto_no = $this->m_pemakaian->get_auto_number($tgl);

        // Ambil data input tunggal
        $gudang_id = $this->input->post('gudang_id');
        $asset_id  = $this->input->post('asset_id');
        $qty_pakai = $this->input->post('pemakaian_qty');

        // Validasi sederhana
        if (empty($gudang_id) || empty($asset_id) || empty($qty_pakai)) {
             echo json_encode(['status' => '00', 'msg' => 'Mohon lengkapi data barang.']);
             return;
        }

        $data_header = [
            'transaksi_no'        => $auto_no,
            'transaksi_tgl'       => $tgl,
            'kembali_rencana_tgl' => $this->input->post('kembali_rencana_tgl'),
            'pegawai_id'          => $this->input->post('pegawai_id'),
            'transaksi_ket'       => $this->input->post('transaksi_ket'),
            'pemakaian_sts'       => 'OPEN',
            'active_st' => 1, 'deleted_st' => 0,
            'created_by' => 'PEGAWAI TESTER'
        ];

        // Panggil fungsi simpan yang baru (tanpa array)
        if ($this->m_pemakaian->simpan_transaksi($data_header, $asset_id, $gudang_id, $qty_pakai)) {
            _json(_response('01', $this->uri));
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan. Cek stok barang.']);
        }
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $w);
        _json(_response('03', $this->uri));
    }

    public function ajax_datatables()
    {
        $this->m_pemakaian->load_datatables();
    }

    public function get_no_transaksi_ajax()
    {
        $tgl = $this->input->post('tanggal');
        echo json_encode(['new_no' => $this->m_pemakaian->get_auto_number($tgl)]);
    }

    public function get_assets_by_gudang()
    {
        $gudang_id = $this->input->post('gudang_id');
        echo json_encode($this->m_pemakaian->get_assets_available($gudang_id));
    }
}