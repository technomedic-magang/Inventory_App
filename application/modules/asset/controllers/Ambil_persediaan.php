<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ambil_persediaan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['asset/m_ambil_persediaan']);
        $this->table = $this->m_ambil_persediaan->table;
        $this->pk_id = $this->m_ambil_persediaan->pk_id;
        $this->template = 'asset/ambil_persediaan/';
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
            $d['preview_no'] = $this->m_ambil_persediaan->get_auto_number(date('Y-m-d'));
        }

        $d['list_gudang'] = $this->db->where(['deleted_st' => 0, 'active_st' => 1])->get('mst_gudang')->result_array();
        $d['list_pegawai'] = $this->db->select('pegawai_id, pegawai_nm, user_id')->where(['deleted_st' => 0, 'active_st' => 1])->get('mst_pegawai')->result_array();
        
        // List asset tidak diload di sini, tapi via AJAX (Perubahan 3)

        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        if ($id != null) return;

        $tgl = $this->input->post('transaksi_tgl');
        $auto_no = $this->m_ambil_persediaan->get_auto_number($tgl);

        $data_header = [
            'gudang_id'     => $this->input->post('gudang_id'),
            'pegawai_id'    => $this->input->post('pegawai_id'),
            'transaksi_tgl' => $tgl,
            'transaksi_no'  => $auto_no,
            'transaksi_ket' => $this->input->post('transaksi_ket'),
            'active_st' => 1, 'deleted_st' => 0
        ];

        $data_detail = [
            'asset_id'   => $this->input->post('asset_id'),
            'asset_qty'  => $this->input->post('asset_qty'),
            'detail_ket' => $this->input->post('detail_ket')
        ];

        if ($this->m_ambil_persediaan->simpan_transaksi($data_header, $data_detail)) {
            _json(_response('01', $this->uri));
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan. Cek stok.']);
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
        $this->m_ambil_persediaan->load_datatables();
    }

    // API untuk Auto Number
    public function get_no_transaksi_ajax()
    {
        $tgl = $this->input->post('tanggal');
        echo json_encode(['new_no' => $this->m_ambil_persediaan->get_auto_number($tgl)]);
    }
    
    // API untuk Perubahan 3 (Dropdown Dinamis)
    public function get_persediaan_by_gudang()
    {
        $gudang_id = $this->input->post('gudang_id');
        echo json_encode($this->m_ambil_persediaan->get_persediaan_available($gudang_id));
    }
}