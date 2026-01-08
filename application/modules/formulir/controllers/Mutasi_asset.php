<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mutasi_asset extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        _models(['formulir/m_mutasi_asset']);
        $this->table = $this->m_mutasi_asset->table;
        $this->template = 'formulir/mutasi_asset/';
<<<<<<< HEAD
=======
        $this->uri_mod = 'formulir/mutasi_asset'; 
>>>>>>> repoB/main
    }

    public function index() {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null) {
<<<<<<< HEAD
        $d['form_act'] = $this->uri . '/save';
        // Ambil semua pegawai aktif
        $d['list_pegawai'] = $this->db->get_where('mst_pegawai', ['active_st'=>1])->result_array();
=======
        $d['form_act'] = site_url($this->uri_mod . '/save');
        
        // [ADAPTASI] Generate nomor otomatis awal (default hari ini)
        $d['preview_no'] = $this->m_mutasi_asset->get_auto_number(date('Y-m-d'));

        $d['list_pegawai'] = $this->db->get_where('mst_pegawai', ['active_st'=>1])->result_array();
        
>>>>>>> repoB/main
        $this->render($this->template . 'form_modal', $d);
    }

    public function save() {
<<<<<<< HEAD
        $header = [
            'transaksi_no' => 'MTS/'.date('Ymd').'/'.rand(1000,9999), // Simple Auto Number
            'transaksi_tgl' => $this->input->post('tgl_mutasi'),
            'pegawai_asal_id' => $this->input->post('pegawai_asal'),
            'pegawai_tujuan_id' => $this->input->post('pegawai_tujuan'),
            'keterangan' => $this->input->post('keterangan'),
            'created_by' => 'ADMIN'
        ];

        $assets = $this->input->post('asset_id'); // Array
        $olds   = $this->input->post('pemakaian_id'); // Array

        if($this->m_mutasi_asset->simpan_mutasi($header, $assets, $olds)) {
            _json(_response('01', $this->uri));
=======
        // [ADAPTASI] 1. Ambil & Konversi Tanggal menggunakan Helper
        $tgl_raw = $this->input->post('transaksi_tgl'); // Disamakan namanya jadi transaksi_tgl
        $tgl_sql = $this->_convert_date($tgl_raw);

        if (empty($tgl_sql)) {
             echo json_encode(['status' => '00', 'msg' => 'Tanggal Mutasi wajib diisi.']);
             return;
        }

        // [ADAPTASI] 2. Generate Nomor Transaksi (Server Side Safety)
        // Jika user tidak manipulasi input, ini akan sama dengan yang di form. 
        // Tapi kita generate ulang di sini untuk konsistensi.
        $no_transaksi = $this->m_mutasi_asset->get_auto_number($tgl_sql);

        // 3. Siapkan Header
        $header = [
            'transaksi_no'    => $no_transaksi, 
            'transaksi_tgl'   => $tgl_sql, 
            'pegawai_asal_id' => $this->input->post('pegawai_asal'),
            'pegawai_tujuan_id' => $this->input->post('pegawai_tujuan'),
            'keterangan'      => $this->input->post('keterangan'),
            'created_by'      => $this->session->userdata('user_id') ?? 'ADMIN',
            'deleted_st'      => 0
        ];

        $assets = $this->input->post('asset_id'); 
        $olds   = $this->input->post('pemakaian_id');

        if (empty($assets)) {
             echo json_encode(['status' => '00', 'msg' => 'Pilih setidaknya satu aset untuk dimutasi.']);
             return;
        }

        if($this->m_mutasi_asset->simpan_mutasi($header, $assets, $olds)) {
            _json(_response('01', site_url($this->uri_mod)));
>>>>>>> repoB/main
        } else {
            _json(['status' => '00', 'msg' => 'Gagal Mutasi']);
        }
    }

<<<<<<< HEAD
=======
    // [ADAPTASI] Endpoint AJAX untuk Watcher Tanggal
    public function get_no_transaksi_ajax()
    {
        header('Content-Type: application/json');
        $tgl_raw = $this->input->post('tanggal');
        $tgl_sql = $this->_convert_date($tgl_raw);
        
        echo json_encode(['new_no' => $this->m_mutasi_asset->get_auto_number($tgl_sql)]);
    }

>>>>>>> repoB/main
    // API: Ambil barang yang dipegang pegawai asal
    public function get_pegawai_assets() {
        $pid = $this->input->post('pegawai_id');
        $data = $this->m_mutasi_asset->get_assets_held_by_pegawai($pid);
        echo json_encode($data);
    }
    
<<<<<<< HEAD
    public function ajax_datatables() {
        $this->m_mutasi_asset->load_datatables();
    }
=======
    public function delete($id = null) {
        $this->db->update($this->table, ['deleted_st' => 1], ['mutasi_id' => $id]);
        _json(_response('03', site_url($this->uri_mod)));
    }

    public function ajax_datatables() {
        $this->m_mutasi_asset->load_datatables();
    }

    // [ADAPTASI] Helper Konversi Tanggal
    private function _convert_date($date_raw)
    {
        if (empty($date_raw)) return date('Y-m-d');
        if (strpos($date_raw, '-') !== false) {
            $parts = explode('-', $date_raw);
            // Asumsi input dd-mm-yyyy
            if (count($parts) == 3 && strlen($parts[2]) == 4) {
                return date('Y-m-d', strtotime($date_raw));
            }
        }
        return $date_raw;
    }
>>>>>>> repoB/main
}