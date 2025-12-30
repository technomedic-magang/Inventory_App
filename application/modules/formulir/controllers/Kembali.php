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
        $this->uri_mod = 'formulir/kembali';
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = site_url($this->uri_mod . '/save/' . $id);

        if ($id == null) {
            // Default tanggal hari ini untuk preview
            $d['preview_no'] = $this->m_kembali->get_auto_number(date('Y-m-d'));
        }

        $d['list_pemakaian'] = $this->m_kembali->get_open_pemakaian();
        
        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        if ($id != null) return; 

        // 1. Ambil & Konversi Tanggal (dd-mm-yyyy -> yyyy-mm-dd)
        $tgl_raw = $this->input->post('transaksi_tgl');
        $tgl_sql = $this->_convert_date($tgl_raw);

        // 2. Generate Nomor (Server Side Safety)
        $auto_no = $this->m_kembali->get_auto_number($tgl_sql);

        $data_header = [
            'pemakaian_id'  => $this->input->post('pemakaian_id'),
            'transaksi_no'  => $auto_no,
            'transaksi_tgl' => $tgl_sql,
            'transaksi_ket' => $this->input->post('transaksi_ket'),
            'active_st'     => 1, 
            'deleted_st'    => 0,
            'created_by'    => $this->session->userdata('user_id') ?? 'SYSTEM'
        ];

        $data_detail = [
            'pemakaian_detail_id' => $this->input->post('pemakaian_detail_id'),
            'asset_id'            => $this->input->post('asset_id'),
            'gudang_id'           => $this->input->post('gudang_id'),
            'kembali_qty'         => $this->input->post('kembali_qty'),
            'kondisi_asset'       => $this->input->post('kondisi_asset')
        ];

        if ($this->m_kembali->simpan_pengembalian($data_header, $data_detail)) {
            _json(_response('01', site_url($this->uri_mod . '?n=' . $this->input->get('n'))));
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan pengembalian.']);
        }
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', site_url($this->uri_mod . '?n=' . $this->input->get('n'))));
    }

    public function ajax_datatables()
    {
        $this->m_kembali->load_datatables();
    }
    
    // AJAX: Auto Number dengan Konversi Tanggal
    public function get_no_transaksi_ajax()
    {
        header('Content-Type: application/json');
        $tgl_raw = $this->input->post('tanggal');
        $tgl_sql = $this->_convert_date($tgl_raw);
        
        echo json_encode(['new_no' => $this->m_kembali->get_auto_number($tgl_sql)]);
    }

    // AJAX: Ambil Item (Panggil Model yang baru)
    public function get_items_pemakaian()
    {
        header('Content-Type: application/json');
        $pemakaian_id = $this->input->post('pemakaian_id');
        $items = $this->m_kembali->get_items_pemakaian_list($pemakaian_id);
        echo json_encode($items);
    }

    // Helper: Konversi Tanggal dd-mm-yyyy -> yyyy-mm-dd
    private function _convert_date($date_raw)
    {
        if (empty($date_raw)) return date('Y-m-d');
        if (strpos($date_raw, '-') !== false) {
            $parts = explode('-', $date_raw);
            if (count($parts) == 3 && strlen($parts[2]) == 4) {
                return date('Y-m-d', strtotime($date_raw));
            }
        }
        return $date_raw;
    }
}