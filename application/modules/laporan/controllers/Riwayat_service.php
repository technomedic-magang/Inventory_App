<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_service extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['laporan/m_riwayat_service']);
        
        $this->table = $this->m_riwayat_service->table;
        $this->pk_id = $this->m_riwayat_service->pk_id;
        
        $this->template = 'laporan/riwayat_service/'; 
        $this->uri = 'laporan/riwayat_service'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        $this->m_riwayat_service->load_datatables();
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = site_url($this->uri . '/save' . ($id ? '/' . $id : ''));

        // Ambil Data Pendukung
        $d['list_asset']    = $this->m_riwayat_service->get_all_assets();
        $d['list_kategori'] = $this->m_riwayat_service->get_all_kategori(); // [BARU]

        $this->render($this->template . 'form_modal', $d);
    }

    // Fungsi untuk memuat HTML Kalender via AJAX
    public function get_calendar_html()
    {
        $target_date = $this->input->get('date'); // Format Y-m-d
        
        // Load library Calendar (Custom yang Anda berikan)
        // Pastikan nama file dan class sesuai (Huruf besar/kecil)
        $this->load->library('Calendar', $target_date); 
        
        // Render HTML
        echo $this->calendar->__toString();
    }

    public function save($id = null)
    {
        $d = _post();

        if (empty($d['asset_id'])) { _json(['status' => false, 'msg' => 'Aset wajib dipilih.']); return; }
        if (empty($d['tgl_service'])) { _json(['status' => false, 'msg' => 'Tanggal wajib diisi.']); return; }
        
        // --- 1. KONVERSI TANGGAL (dd-mm-yyyy -> yyyy-mm-dd) ---
        
        // Fungsi helper sederhana untuk membalik tanggal
        // Input: 31-12-2025 -> Output: 2025-12-31
        $tgl_service_sql = $d['tgl_service'];
        if (strpos($d['tgl_service'], '-') !== false) {
            $tgl_service_sql = date('Y-m-d', strtotime($d['tgl_service']));
        }

        $tgl_berikutnya_sql = NULL;
        if (!empty($d['tgl_berikutnya'])) {
            if (strpos($d['tgl_berikutnya'], '-') !== false) {
                $tgl_berikutnya_sql = date('Y-m-d', strtotime($d['tgl_berikutnya']));
            } else {
                $tgl_berikutnya_sql = $d['tgl_berikutnya'];
            }
        }
        // -----------------------------------------------------------

        // Bersihkan format ribuan
        $km_now  = !empty($d['kilometer_saat_ini']) ? str_replace('.', '', $d['kilometer_saat_ini']) : 0;
        $km_next = !empty($d['kilometer_berikutnya']) ? str_replace('.', '', $d['kilometer_berikutnya']) : 0;
        $biaya   = !empty($d['biaya']) ? str_replace('.', '', $d['biaya']) : 0;

        $data = [
            'asset_id'           => $d['asset_id'],
            'tgl_service'        => $tgl_service_sql,     
            'bengkel_nm'         => $d['bengkel_nm'],
            'biaya'              => $biaya,
            'keterangan_txt'     => $d['keterangan_txt'],
            'kilometer_saat_ini'   => $km_now,
            'tgl_berikutnya'       => $tgl_berikutnya_sql, 
            'kilometer_berikutnya' => $km_next,
        ];

        $redirect_uri = site_url($this->uri . '?n=' . $this->input->get('n'));

        if ($id == null) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['deleted_st'] = 0;
            DB::insert($this->table, $data);
            _json(_response('01', $redirect_uri));
        } else {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $this->session->userdata('user_id');
            DB::update($this->table, $data, [$this->pk_id => $id]);
            _json(_response('02', $redirect_uri));
        }
    }
    
    public function delete($id = null) {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', site_url($this->uri . '?n=' . $this->input->get('n'))));
    }
}