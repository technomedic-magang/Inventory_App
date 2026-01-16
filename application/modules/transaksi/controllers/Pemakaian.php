<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemakaian extends MY_Controller
{
    protected $view_path = 'transaksi/pemakaian/';
    protected $uri_path  = 'transaksi/pemakaian';

    public function __construct()
    {
        parent::__construct();
        _models(['transaksi/m_pemakaian']);
        
        $this->model = $this->m_pemakaian;
        $this->table = $this->model->table;
        $this->pk_id = $this->model->pk_id;
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
        $data['form_act'] = $this->uri . '/save/' . $id;
        
        // [LOGIC KUNCI] Jika ID ada = Mode Detail (Read Only)
        $data['is_readonly'] = ($id != null);

        if ($id) {
            // Ambil detail item juga untuk ditampilkan
            $detail = $this->db->get_where('trx_pemakaian_detail', ['pemakaian_id' => $id])->row_array();
            if ($detail && $data['main']) {
                $data['main'] = array_merge($data['main'], $detail);
            }
        } else {
            $data['preview_no'] = $this->model->get_auto_number(date('Y-m-d'));
        }

        $data['list_pegawai'] = $this->db->where(['deleted_st' => 0, 'active_st' => 1])
                                         ->get('mst_pegawai')->result_array();
                                      
        $data['list_gudang']  = $this->db->where(['deleted_st' => 0, 'active_st' => 1])
                                         ->get('mst_gudang')->result_array();
        
        $this->render($this->view_path . 'form_modal', $data);
    }

    public function save($id = null)
    {
        // [SECURITY] Blokir penyimpanan jika ID tidak null (Mode Detail)
        if ($id != null) {
            _json(['status' => false, 'msg' => 'Mode View: Data tidak dapat diubah.']);
            return;
        }

        $input = _post();

        if (empty($input['transaksi_tgl'])) { _json(['status' => false, 'msg' => 'Tanggal wajib diisi.']); return; }
        if (empty($input['gudang_id'])) { _json(['status' => false, 'msg' => 'Gudang wajib dipilih.']); return; }
        if (empty($input['asset_id'])) { _json(['status' => false, 'msg' => 'Aset wajib dipilih.']); return; }

        $tgl_sql = $this->_convert_date($input['transaksi_tgl']);
        
        $header = [
            'transaksi_no'        => $this->model->get_auto_number($tgl_sql),
            'transaksi_tgl'       => $tgl_sql,
            'kembali_rencana_tgl' => empty($input['kembali_rencana_tgl']) ? $tgl_sql : $this->_convert_date($input['kembali_rencana_tgl']),
            'pegawai_id'          => $input['pegawai_id'],
            'transaksi_ket'       => $input['transaksi_ket'],
            'pemakaian_sts'       => 'OPEN',
            'active_st'           => 1, 
            'deleted_st'          => 0,
            'created_by'          => $this->session->userdata('user_id') ?? 'SYSTEM'
        ];

        $status = $this->model->simpan_transaksi($header, $input['asset_id'], $input['gudang_id'], $input['pemakaian_qty']);

        if ($status) {
            _json(_response('01', $this->uri));
        } else {
            _json(['status' => false, 'msg' => 'Gagal menyimpan. Cek stok barang.']);
        }
    }

    // Fungsi Delete (Hapus)
    public function delete($id = null)
    {
        if (empty($id)) return;
        
        $status = $this->model->hapus_transaksi($id);
        
        if ($status) {
            _json(_response('03', $this->uri));
        } else {
            _json(['status' => false, 'msg' => 'Gagal menghapus data.']);
        }
    }

    // --- AJAX ---
    public function get_assets_by_gudang()
    {
        header('Content-Type: application/json');
        echo json_encode($this->model->get_assets_available($this->input->post('gudang_id')));
    }

    public function get_no_transaksi_ajax()
    {
        header('Content-Type: application/json');
        $tgl = $this->_convert_date($this->input->post('tanggal'));
        echo json_encode(['new_no' => $this->model->get_auto_number($tgl)]);
    }

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