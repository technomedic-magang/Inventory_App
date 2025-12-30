<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyesuaian_kondisi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['asset/m_penyesuaian_kondisi']);
        $this->table = $this->m_penyesuaian_kondisi->table;
        $this->pk_id = $this->m_penyesuaian_kondisi->pk_id;
        $this->template = 'asset/penyesuaian_kondisi/';
        $this->uri_mod = 'asset/penyesuaian_kondisi';
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = site_url($this->uri_mod . '/save/'); 

        if ($id == null) {
            $d['preview_no'] = $this->m_penyesuaian_kondisi->get_auto_number(date('Y-m-d'));
        }

        // [MODIFIKASI] Ambil List Kategori untuk Filter
        $d['list_kategori'] = $this->db->where(['deleted_st' => 0, 'active_st' => 1, 'kategori_tipe' => 'ASET'])
                                       ->order_by('kategori_nm', 'ASC')
                                       ->get('mst_kategori')->result_array();

        // [MODIFIKASI] List Asset dikosongkan (User wajib pilih kategori dulu via AJAX)
        $d['list_asset'] = [];

        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $asset_id   = $this->input->post('asset_id');
        $kondisi_ke = $this->input->post('kondisi_ke');
        $tgl_raw    = $this->input->post('transaksi_tgl');

        // 1. Konversi Tanggal
        $tgl_sql = $this->_convert_date($tgl_raw);

        // 2. Validasi Aset
        $aset = $this->db->select('asset_kondisi')->where('asset_id', $asset_id)->get('mst_asset')->row();
        if (!$aset) {
            echo json_encode(['status' => '00', 'msg' => 'Aset tidak ditemukan.']);
            return;
        }

        // 3. Generate Nomor Final
        $auto_no = $this->m_penyesuaian_kondisi->get_auto_number($tgl_sql);

        $data_log = [
            'transaksi_no'  => $auto_no,
            'asset_id'      => $asset_id,
            'transaksi_tgl' => $tgl_sql,
            'kondisi_dari'  => $aset->asset_kondisi, 
            'kondisi_ke'    => $kondisi_ke,
            'transaksi_ket' => $this->input->post('transaksi_ket'),
            'created_by'    => 'PEGAWAI TESTER', // Ganti session user
            'deleted_st'    => 0,
            'active_st'     => 1
        ];

        if ($this->m_penyesuaian_kondisi->simpan_penyesuaian($data_log, $asset_id, $kondisi_ke)) {
            _json(_response('01', site_url($this->uri_mod)));
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan data.']);
        }
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', site_url($this->uri_mod)));
    }

    public function ajax_datatables()
    {
        $this->m_penyesuaian_kondisi->load_datatables();
    }

    // API AJAX: Preview Nomor dengan konversi tanggal
    public function get_no_transaksi_ajax()
    {
        header('Content-Type: application/json');
        $tgl_raw = $this->input->post('tanggal');
        $tgl_sql = $this->_convert_date($tgl_raw);
        
        $new_no = $this->m_penyesuaian_kondisi->get_auto_number($tgl_sql);
        echo json_encode(['new_no' => $new_no]);
    }

    // [BARU] API AJAX: Get Asset by Kategori (Hanya yg ada stok di gudang)
    public function get_assets_by_kategori()
    {
        header('Content-Type: application/json');
        $kategori_id = $this->input->post('kategori_id');
        
        $data = $this->m_penyesuaian_kondisi->get_assets_available_by_kategori($kategori_id);
        echo json_encode($data);
    }

    // Helper Tanggal
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