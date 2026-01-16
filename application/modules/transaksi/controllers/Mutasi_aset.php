<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mutasi_aset extends MY_Controller 
{
    // Definisi Path View & URI
    protected $view_path = 'transaksi/mutasi_aset/';
    protected $uri_path  = 'transaksi/mutasi_aset'; 

    public function __construct() 
    {
        parent::__construct();
        _models(['transaksi/m_mutasi_aset']);
        
        $this->model = $this->m_mutasi_aset;
        $this->table = $this->model->table;
        $this->pk_id = $this->model->pk_id;
        
        // [PENTING] Set URI sebagai Full URL
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
        
        // URL Aksi Form (Full URL)
        $data['form_act'] = $this->uri . '/save';
        
        // Generate nomor otomatis awal (Default hari ini)
        $data['preview_no'] = $this->model->get_auto_number(date('Y-m-d'));

        // List Pegawai Aktif
        $data['list_pegawai'] = $this->db->where(['active_st' => 1, 'deleted_st' => 0])
                                         ->order_by('pegawai_nm', 'ASC')
                                         ->get('mst_pegawai')->result_array();
        
        $this->render($this->view_path . 'form_modal', $data);
    }

    public function save() 
    {
        $input = _post();

        // 1. Validasi Input (Guard Clause)
        if (empty($input['transaksi_tgl'])) { _json(['status' => false, 'msg' => 'Tanggal Mutasi wajib diisi.']); return; }
        if (empty($input['asset_id'])) { _json(['status' => false, 'msg' => 'Pilih setidaknya satu aset.']); return; }
        
        if ($input['pegawai_asal'] == $input['pegawai_tujuan']) {
             _json(['status' => false, 'msg' => 'Pegawai asal dan tujuan tidak boleh sama.']); return;
        }

        // 2. Persiapan Data
        $tgl_sql = $this->_convert_date($input['transaksi_tgl']);
        $header  = $this->_prepare_header($input, $tgl_sql);
        
        $assets = $input['asset_id']; 
        $olds   = $input['pemakaian_id'];

        // 3. Eksekusi Simpan
        $status = $this->model->simpan_mutasi($header, $assets, $olds);

        if ($status) {
            _json(_response('01', $this->uri));
        } else {
            _json(['status' => false, 'msg' => 'Gagal memproses mutasi.']);
        }
    }

    public function get_no_transaksi_ajax()
    {
        header('Content-Type: application/json');
        $tgl_raw = $this->input->post('tanggal');
        $tgl_sql = $this->_convert_date($tgl_raw);
        
        echo json_encode(['new_no' => $this->model->get_auto_number($tgl_sql)]);
    }

    public function get_pegawai_assets() 
    {
        $pid = $this->input->post('pegawai_id');
        $data = $this->model->get_assets_held_by_pegawai($pid);
        echo json_encode($data);
    }
    
    public function delete($id = null) 
    {
        if(empty($id)) return;
        
        $where = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $where);
        
        _json(_response('03', $this->uri));
    }

    // --- Private Methods ---

    private function _prepare_header($input, $tgl_sql)
    {
        // Re-generate nomor untuk keamanan data (server-side)
        $no_transaksi = $this->model->get_auto_number($tgl_sql);

        return [
            'transaksi_no'      => $no_transaksi, 
            'transaksi_tgl'     => $tgl_sql, 
            'pegawai_asal_id'   => $input['pegawai_asal'],
            'pegawai_tujuan_id' => $input['pegawai_tujuan'],
            'keterangan'        => $input['keterangan'],
            'created_by'        => $this->session->userdata('user_id') ?? 'ADMIN',
            'deleted_st'        => 0
        ];
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