<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pajak extends MY_Controller
{
    protected $view_path = 'keuangan/pajak/';
    protected $uri_path  = 'keuangan/pajak';

    public function __construct()
    {
        parent::__construct();
        _models(['keuangan/m_pajak']); 
        
        $this->model = $this->m_pajak;
        $this->table = $this->model->table;
        $this->pk_id = $this->model->pk_id;
        
        // [STANDAR] Full URL
        $this->uri = site_url($this->uri_path); 
    }

    public function index()
    {
        // Ambil Data Ringkasan untuk Dashboard Atas
        $data['summary'] = $this->model->get_dashboard_stats();
        $this->render($this->view_path . 'index', $data);
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

        if ($id == null) {
            $data['preview_no'] = $this->model->get_auto_number(date('Y-m-d'));
        }

        // Ambil List Aset untuk Dropdown
        $data['list_asset'] = $this->model->get_active_assets_for_tax();

        $this->render($this->view_path . 'form_modal', $data);
    }

    public function save($id = null)
    {
        if ($id != null) {
            _json(['status' => false, 'msg' => 'Edit data pajak dikunci untuk menjaga integritas history.']);
            return;
        }

        $input = _post();

        // 1. Validasi Input
        if (empty($input['asset_id'])) { _json(['status' => false, 'msg' => 'Aset wajib dipilih.']); return; }
        if (empty($input['transaksi_tgl'])) { _json(['status' => false, 'msg' => 'Tanggal Bayar wajib diisi.']); return; }
        if (empty($input['nominal_pokok'])) { _json(['status' => false, 'msg' => 'Nominal Pokok wajib diisi.']); return; }

        // 2. Upload Bukti (Jika ada)
        $file_name = $this->_handle_upload_bukti();
        if ($file_name === false) return; // Error handled inside

        // 3. Persiapan Data (Hitung Tanggal & Nominal)
        $asset_id = $input['asset_id'];
        $tgl_bayar = $this->_convert_date($input['transaksi_tgl']);
        
        // Kalkulasi Tanggal Jatuh Tempo Berikutnya
        $dates = $this->_calculate_next_dates($asset_id, $tgl_bayar, $input['pajak_jenis']);
        
        // Persiapan Data Transaksi
        $data_trx = $this->_prepare_transaction_data($input, $tgl_bayar, $dates['next_due'], $file_name);

        // Persiapan Data Update Master Aset
        $data_asset_update = $this->_prepare_asset_update($input, $dates);

        // 4. Eksekusi Database (Transaction)
        $status = $this->model->simpan_pembayaran($data_trx, $asset_id, $data_asset_update);

        if ($status) {
            _json(_response('01', $this->uri));
        } else {
            // Hapus file jika gagal database
            if ($file_name) @unlink('./uploads/pajak/' . $file_name);
            _json(['status' => false, 'msg' => 'Gagal menyimpan data pajak.']);
        }
    }

    public function delete($id = null)
    {
        if (empty($id)) return;
        
        // Soft Delete
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $w);
        
        _json(_response('03', $this->uri));
    }
    
    public function get_no_transaksi_ajax()
    {
        header('Content-Type: application/json');
        $tgl_raw = $this->input->post('tanggal');
        $tgl_sql = $this->_convert_date($tgl_raw);
        
        echo json_encode(['new_no' => $this->model->get_auto_number($tgl_sql)]);
    }

    // --- Private Helper Methods ---

    private function _handle_upload_bukti()
    {
        if (empty($_FILES['bukti_file']['name'])) return null;

        $config['upload_path']   = './uploads/pajak/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size']      = 5120; // 5MB
        $config['file_name']     = 'TAX_' . time();
        
        $this->load->library('upload', $config);
        
        if ($this->upload->do_upload('bukti_file')) {
            return $this->upload->data('file_name');
        } else {
            _json(['status' => false, 'msg' => 'Upload Gagal: ' . $this->upload->display_errors('', '')]);
            return false;
        }
    }

    private function _calculate_next_dates($asset_id, $tgl_bayar, $jenis_pajak)
    {
        $asset = $this->db->get_where('mst_asset', ['asset_id' => $asset_id])->row();
        
        // Logic: Jika ada history tgl jatuh tempo sebelumnya, gunakan itu sebagai basis.
        // Jika tidak, gunakan tanggal bayar saat ini.
        $last_due = (!empty($asset->tgl_pajak_tahunan)) ? $asset->tgl_pajak_tahunan : $tgl_bayar;
        $next_due = date('Y-m-d', strtotime('+1 year', strtotime($last_due)));

        $next_plat = null;
        if ($jenis_pajak == '5_TAHUNAN') {
            $last_plat = (!empty($asset->tgl_pajak_plat)) ? $asset->tgl_pajak_plat : $tgl_bayar;
            $next_plat = date('Y-m-d', strtotime('+5 years', strtotime($last_plat)));
        }

        return ['next_due' => $next_due, 'next_plat' => $next_plat];
    }

    private function _prepare_transaction_data($input, $tgl_bayar, $next_due, $file_name)
    {
        $pokok = (int) str_replace('.', '', $input['nominal_pokok']);
        $denda = (int) str_replace('.', '', $input['nominal_denda']);
        
        // Ambil Nopol Lama untuk History
        $asset_lama = $this->db->get_where('mst_asset', ['asset_id' => $input['asset_id']])->row();
        $nopol_lama = isset($asset_lama->nopol) ? $asset_lama->nopol : null; // Asumsi field nopol ada di mst_asset atau null

        $nopol_baru = $nopol_lama;
        if ($input['pajak_jenis'] == '5_TAHUNAN' && !empty($input['nopol_baru'])) {
            $nopol_baru = strtoupper($input['nopol_baru']);
        }

        return [
            'transaksi_no'    => $this->model->get_auto_number($tgl_bayar),
            'transaksi_tgl'   => $tgl_bayar,
            'jatuh_tempo_tgl' => $next_due,
            'asset_id'        => $input['asset_id'],
            'pajak_jenis'     => $input['pajak_jenis'],
            'nopol_lama'      => $nopol_lama,
            'nopol_baru'      => $nopol_baru,
            'nominal_pokok'   => $pokok,
            'nominal_denda'   => $denda,
            'nominal_total'   => $pokok + $denda,
            'transaksi_ket'   => $input['transaksi_ket'],
            'bukti_file'      => $file_name,
            'created_by'      => $this->session->userdata('user_id'),
            'created_at'      => date('Y-m-d H:i:s'),
            'active_st'       => 1,
            'deleted_st'      => 0
        ];
    }

    private function _prepare_asset_update($input, $dates)
    {
        $data = [
            'tgl_pajak_tahunan' => $dates['next_due'],
            'updated_at'        => date('Y-m-d H:i:s')
        ];

        if ($input['pajak_jenis'] == '5_TAHUNAN') {
            $data['tgl_pajak_plat'] = $dates['next_plat'];
            // Update Nopol di Master jika ada perubahan
            /* Note: Jika Nopol disimpan di dat_asset_value (bukan field mst_asset), 
               logika update ini harus disesuaikan di Model. 
               Disini saya asumsikan update tanggal saja di master. */
        }

        return $data;
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