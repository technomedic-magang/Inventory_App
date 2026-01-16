<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aset_masuk extends MY_Controller
{
    // Properti Eksplisit
    protected $view_path = 'aset/aset_masuk/';
    protected $uri_path  = 'aset/aset_masuk';

    public function __construct()
    {
        parent::__construct();
        _models(['aset/m_aset_masuk']);
        
        $this->model = $this->m_aset_masuk;
        $this->table = $this->model->table;
        $this->pk_id = $this->model->pk_id;
    }

    public function index()
    {
        $this->render($this->view_path . 'index');
    }

    public function form_modal($id = null)
    { 
        $data = [];
        
        // Data Utama (Untuk View Detail/Edit - meski saat ini hanya Insert)
        $data['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $data['form_act'] = site_url($this->uri_path . '/save/' . $id);

        // Ambil Referensi Aktif
        $data['list_gudang'] = $this->db->where(['deleted_st' => 0, 'active_st' => 1])
                                        ->get('mst_gudang')->result_array();
        
        // Kategori hanya tipe ASET (Barang Modal)
        $data['list_kategori'] = $this->db->where(['deleted_st' => 0, 'active_st' => 1, 'kategori_tipe' => 'ASET'])
                                          ->order_by('kategori_nm', 'ASC')
                                          ->get('mst_kategori')->result_array();

        $data['list_asset'] = []; // Kosongkan awal, load via AJAX

        $this->render($this->view_path . 'form_modal', $data);
    }

    public function save($id = null)
    {
        // Fitur Edit belum didukung
        if ($id != null) {
            echo json_encode(['status' => '00', 'msg' => 'Edit transaksi belum didukung.']);
            return;
        }

        $input = _post();
        
        // 1. Validasi Input Dasar
        if (empty($input['asset_id']) || empty($input['transaksi_tgl'])) {
             echo json_encode(['status' => '00', 'msg' => 'Gagal, Tanggal dan Aset wajib diisi.']);
             return;
        }

        // 2. Persiapan Data Header
        $tgl_transaksi = $this->_convert_date($input['transaksi_tgl']);
        $no_transaksi  = $this->_generate_transaction_number($tgl_transaksi, $input['asset_id']);

        if (!$no_transaksi) {
             echo json_encode(['status' => '00', 'msg' => 'Gagal, SKU Aset tidak ditemukan.']);
             return;
        }

        $data_header = [
            'gudang_id'     => $input['gudang_id'],
            'transaksi_tgl' => $tgl_transaksi,
            'transaksi_no'  => $no_transaksi,
            'transaksi_ket' => $input['detail_ket'] ?? '', // Menggunakan detail_ket sebagai keterangan umum
            'active_st'     => 1,
            'deleted_st'    => 0,
            'created_by'    => $this->session->userdata('user_id') ?? 'SYSTEM'
        ];
        
        // 3. Eksekusi Transaksi Database
        $this->db->trans_start();
        
        $this->model->simpan_transaksi_aset($data_header, $input['asset_id'], $input['detail_ket']);
        
        // Simpan Atribut Lokasi (Kustom)
        $data_kustom = $input['kustom'] ?? [];
        $this->_save_custom_attributes($input['asset_id'], $data_kustom);
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            _json(_response('01', site_url($this->uri_path)));
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan transaksi.']);
        }
    }

    public function delete($id = null)
    {
        if (empty($id)) return;
        
        $where = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $where);
        
        _json(_response('03', site_url($this->uri_path)));
    }

    public function ajax_datatables()
    {
        $this->model->load_datatables();
    }

    // --- AJAX Methods ---

    public function get_list_asset_by_kategori()
    {
        $kategori_id = $this->input->post('kategori_id');
        $data = $this->model->get_assets_by_kategori_id($kategori_id);
        echo json_encode($data);
    }

    public function get_no_transaksi_ajax()
    {
        $tgl_raw  = $this->input->post('tanggal');
        $asset_id = $this->input->post('asset_id');

        if (empty($tgl_raw) || empty($asset_id)) {
            echo json_encode(['status' => false, 'transaksi_no' => '']);
            return;
        }

        $tgl_transaksi = $this->_convert_date($tgl_raw);
        $final_no = $this->_generate_transaction_number($tgl_transaksi, $asset_id);

        if ($final_no) {
            echo json_encode(['status' => true, 'transaksi_no' => $final_no]);
        } else {
            echo json_encode(['status' => false, 'transaksi_no' => 'Error: SKU not found']);
        }
    }

    public function get_form_dinamis_by_kategori()
    {
        $kategori_kd = $this->input->post('kategori_kd');
        
        // Cek kategori exist
        $kategori = $this->db->get_where('mst_kategori', ['kategori_kd' => $kategori_kd])->row();
        if (!$kategori) { echo json_encode(['html' => '']); return; }

        // Ambil atribut khusus (Ruangan & Lantai)
        $list_atribut = $this->db->where('kategori_id', $kategori->kategori_id)
                                 ->where_in('atribut_label', ['Ruangan', 'Lantai']) // Filter spesifik
                                 ->where('deleted_st', 0)
                                 ->get('mst_kategori_atribut')->result_array();
        
        if (empty($list_atribut)) { echo json_encode(['html' => '']); return; }

        $data['list_atribut'] = $list_atribut;
        $html = $this->load->view($this->view_path . '_ajax_form_dinamis', $data, TRUE);
        echo json_encode(['html' => $html]);
    }

    // --- Private Helpers ---

    private function _generate_transaction_number($tgl_transaksi, $asset_id)
    {
        $seq_part = $this->model->get_auto_number($tgl_transaksi);
        $sku_part = $this->model->get_sku_by_asset_id($asset_id);

        if ($sku_part) {
            return $seq_part . '/' . $sku_part;
        }
        return false;
    }

    private function _save_custom_attributes($asset_id, $data_kustom)
    {
        if (empty($data_kustom)) return;

        foreach ($data_kustom as $atribut_id => $isi_value) {
            if (!empty($isi_value)) {
                // Upsert Logic (Update if exists, Insert if new)
                $cek = $this->db->get_where('dat_asset_value', [
                    'asset_id'   => $asset_id, 
                    'atribut_id' => $atribut_id
                ])->row();

                if($cek) {
                    $this->db->where('value_id', $cek->value_id);
                    $this->db->update('dat_asset_value', ['value_isi' => $isi_value]);
                } else {
                    $this->db->insert('dat_asset_value', [
                        'asset_id'   => $asset_id,
                        'atribut_id' => $atribut_id,
                        'value_isi'  => $isi_value,
                        'created_by' => 'SYSTEM'
                    ]);
                }
            }
        }
    }

    private function _convert_date($date_raw)
    {
        if (empty($date_raw)) return date('Y-m-d');

        // Deteksi format dd-mm-yyyy
        if (strpos($date_raw, '-') !== false) {
            $parts = explode('-', $date_raw);
            if (count($parts) == 3 && strlen($parts[2]) == 4) {
                // Reorder: Year-Month-Day
                return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
        }
        return $date_raw;
    }
}