<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kembali extends MY_Controller
{
    // Definisi Path View & URI
    protected $view_path = 'transaksi/kembali/';
    protected $uri_path  = 'transaksi/kembali';

    public function __construct()
    {
        parent::__construct();
        _models(['transaksi/m_kembali']);
        
        $this->model = $this->m_kembali;
        $this->table = $this->model->table;
        $this->pk_id = $this->model->pk_id;
        
        // [STANDAR BARU] URI Full URL
        $this->uri = site_url($this->uri_path); 
    }

    public function index()
    {
        $this->render($this->view_path . 'index');
    }

    public function ajax_datatables()
    {
        $this->model->load_datatables();
    }

    public function form_modal($id = null)
    {
        $data = [];
        $data['main'] = DB::get($this->table, [$this->pk_id => $id]);
        
        // URL Action (Full URL)
        $data['form_act'] = $this->uri . '/save/' . $id;

        if ($id == null) {
            // Preview Nomor Otomatis Hari Ini
            $data['preview_no'] = $this->model->get_auto_number(date('Y-m-d'));
        }

        // List Pemakaian yang masih OPEN
        $data['list_pemakaian'] = $this->model->get_open_pemakaian();
        
        $this->render($this->view_path . 'form_modal', $data);
    }

    public function save($id = null)
    {
        // Edit dimatikan (Logika Logistik: Retur tidak boleh diedit, harus hapus & buat baru)
        if ($id != null) {
             _json(['status' => false, 'msg' => 'Data pengembalian tidak dapat diedit.']);
             return;
        }

        $input = _post();

        // 1. Validasi Input (Guard Clause)
        if (empty($input['transaksi_tgl'])) { _json(['status' => false, 'msg' => 'Tanggal Kembali wajib diisi.']); return; }
        if (empty($input['pemakaian_id'])) { _json(['status' => false, 'msg' => 'Referensi Pemakaian wajib dipilih.']); return; }
        if (empty($input['pemakaian_detail_id'])) { _json(['status' => false, 'msg' => 'Barang wajib dipilih.']); return; }
        if (empty($input['kembali_qty']) || $input['kembali_qty'] <= 0) { _json(['status' => false, 'msg' => 'Jumlah kembali tidak valid.']); return; }

        // 2. Persiapan Data
        $tgl_sql = $this->_convert_date($input['transaksi_tgl']);
        
        // Generate nomor (Server side safety)
        $auto_no = $this->model->get_auto_number($tgl_sql);

        $data_header = [
            'pemakaian_id'  => $input['pemakaian_id'],
            'transaksi_no'  => $auto_no,
            'transaksi_tgl' => $tgl_sql,
            'transaksi_ket' => $input['transaksi_ket'],
            'active_st'     => 1, 
            'deleted_st'    => 0,
            'created_by'    => $this->session->userdata('user_id') ?? 'SYSTEM'
        ];

        $data_detail = [
            'pemakaian_detail_id' => $input['pemakaian_detail_id'],
            'asset_id'            => $input['asset_id'],
            'gudang_id'           => $input['gudang_id'],
            'kembali_qty'         => $input['kembali_qty'],
            'kondisi_asset'       => $input['kondisi_asset']
        ];

        // 3. Eksekusi Simpan
        $status = $this->model->simpan_pengembalian($data_header, $data_detail);

        if ($status) {
            _json(_response('01', $this->uri));
        } else {
            _json(['status' => false, 'msg' => 'Gagal menyimpan pengembalian.']);
        }
    }

    public function delete($id = null)
    {
        if (empty($id)) return;

        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $w);
        
        _json(_response('03', $this->uri));
    }

    // --- AJAX Helper Methods ---

    public function get_no_transaksi_ajax()
    {
        header('Content-Type: application/json');
        $tgl_raw = $this->input->post('tanggal');
        $tgl_sql = $this->_convert_date($tgl_raw);
        
        echo json_encode(['new_no' => $this->model->get_auto_number($tgl_sql)]);
    }

    public function get_items_pemakaian()
    {
        header('Content-Type: application/json');
        $pemakaian_id = $this->input->post('pemakaian_id');
        $items = $this->model->get_items_pemakaian_list($pemakaian_id);
        echo json_encode($items);
    }

    // --- Private Methods ---

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