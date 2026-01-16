<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manajemen_aset extends MY_Controller
{
    protected $view_path = 'aset/manajemen_aset/';
    protected $uri_path  = 'aset/manajemen_aset';

    public function __construct()
    {
        parent::__construct();
        _models(['aset/m_manajemen_aset']);
        
        $this->model = $this->m_manajemen_aset;
        $this->table = $this->model->table;
        $this->pk_id = $this->model->pk_id;
    }

    public function index()
    {
        // Ambil data kategori untuk filter di view
        $data['list_kategori'] = $this->db->where('deleted_st', 0)
                                       ->order_by('kategori_nm', 'ASC')
                                       ->get('mst_kategori')
                                       ->result_array();
                                       
        $this->render($this->view_path . 'index', $data);
    }

    public function form_modal($id = null)
    {
        $data = [];
        $is_edit = !empty($id);

        // 1. Ambil Data Utama
        $data['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $data['form_act'] = site_url($this->uri_path . '/save/' . $id);

        // 2. Ambil Data Referensi
        $data['list_kategori'] = $this->db->where('deleted_st', 0)->order_by('kategori_nm', 'ASC')->get('mst_kategori')->result_array();
        $data['list_satuan']   = $this->db->where('deleted_st', 0)->order_by('satuan_nm', 'ASC')->get('mst_satuan')->result_array();

        // 3. Ambil Data Atribut Kustom (Jika Edit)
        $data['list_kustom'] = [];
        if ($is_edit) {
            $raw_kustom = $this->db->select('atribut_id, value_isi')
                                   ->from('dat_asset_value')
                                   ->where('asset_id', $id)
                                   ->get()->result_array();
                                   
            foreach($raw_kustom as $k) {
                $data['list_kustom'][$k['atribut_id']] = $k['value_isi'];
            }
        }
        
        $this->render($this->view_path . 'form_modal', $data);
    }

    public function save($id = null)
    {
        $input = _post(); 

        // 1. Sanitasi Data (Money & Date)
        $harga_beli   = $this->_sanitize_money($input['beli_nominal']);
        $nilai_residu = $this->_sanitize_money($input['residu_nominal']);
        $masa_pakai   = abs((int) $input['pakai_masa_bln']);
        if ($masa_pakai < 1) $masa_pakai = 1; // Cegah division by zero
        
        $tgl_beli_sql = $this->_convert_date_to_sql($input['beli_tgl']);

        // 2. Persiapan Data Utama
        $data_main = [
            'kategori_id'          => $input['kategori_id'],
            'satuan_id'            => $input['satuan_id'],
            'asset_nm'             => $input['asset_nm'],
            'asset_kd_singkat'     => strtoupper($input['asset_kd_singkat']),
            
            'beli_nominal'         => (float) $harga_beli,
            'beli_tgl'             => $tgl_beli_sql, 
            'pakai_masa_bln'       => (int) $input['pakai_masa_bln'],
            'residu_nominal'       => (float) $nilai_residu,
            'depresiasi_metode'    => $input['depresiasi_metode'],
            
            // Kolom Legacy (Generate dari tanggal)
            'asset_thn_beli'       => date('Y', strtotime($tgl_beli_sql)), 
            'asset_bln_beli'       => date('m', strtotime($tgl_beli_sql)),
            'asset_masa_pakai_thn' => floor((int)$input['pakai_masa_bln'] / 12), 
            
            'asset_kondisi'        => $input['asset_kondisi'] ?? 'BAIK',
            'stok_min_qty'         => $input['stok_min_qty'] ?? 0,
            'asset_ket'            => $input['asset_ket'] ?? NULL,
            'active_st'            => 1 
        ];
        
        // 3. Pisahkan Logika Insert/Update
        if (empty($id)) {
            $id = $this->_insert_new($data_main, $tgl_beli_sql);
        } else {
            $this->_update_existing($id, $data_main);
        }

        // 4. Proses Simpan Atribut Kustom
        $data_kustom = $input['kustom'] ?? [];
        $this->_save_custom_attributes($id, $data_kustom);

        _json(_response('01', site_url($this->uri_path)));
    }

    public function delete($id = null)
    {
        if (empty($id)) return;
        
        $where = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $where);
        
        _json(_response('03', site_url($this->uri_path)));
    }

    public function ajax_datatables()
    {
        $this->model->load_datatables();
    }
    
    // --- AJAX Helpers ---

    public function get_atribut_dinamis()
    {
        $kategori_id = $this->input->post('kategori_id');
        $asset_id    = $this->input->post('asset_id'); 
        
        $kategori = $this->db->get_where('mst_kategori', ['kategori_id' => $kategori_id])->row_array();
        
        if (!$kategori) { 
            echo json_encode(['html' => '', 'tipe' => '']); 
            return; 
        }

        $list_atribut = $this->db->where('kategori_id', $kategori_id)
                                 ->where('deleted_st', 0)
                                 ->order_by('atribut_urutan', 'ASC')
                                 ->get('mst_kategori_atribut')->result_array();

        $data_tersimpan = [];
        if ($asset_id) {
            $raw = $this->db->where('asset_id', $asset_id)->get('dat_asset_value')->result_array();
            foreach($raw as $val) { 
                $data_tersimpan[$val['atribut_id']] = $val['value_isi']; 
            }
        }

        $view_data = [
            'list_atribut'  => $list_atribut,
            'tipe_kategori' => $kategori['kategori_tipe'],
            'tersimpan'     => $data_tersimpan
        ];

        $html = $this->load->view($this->view_path . '_ajax_form_dinamis', $view_data, TRUE);
        echo json_encode(['html' => $html, 'tipe' => $kategori['kategori_tipe']]);
    }

    public function get_sku_ajax()
    {
        $kategori_id  = $this->input->post('kategori_id');
        $kd_singkat   = $this->input->post('kd_singkat');
        $tgl_beli_raw = $this->input->post('tgl_beli'); 
        
        $tgl_beli = $this->_convert_date_to_sql($tgl_beli_raw);
        $tahun    = date('Y', strtotime($tgl_beli));
        $bulan    = date('m', strtotime($tgl_beli));
        
        $new_sku = $this->model->get_next_full_sku($kategori_id, $kd_singkat, $tahun, $bulan);
        echo json_encode(['new_sku' => $new_sku]);
    }

    public function get_singkatan_ajax()
    {
        // Buffer Output untuk mencegah error whitespace
        ob_start(); 

        $kategori_id = $this->input->post('kategori_id');
        
        if (empty($kategori_id)) {
            ob_end_clean();
            header('Content-Type: application/json');
            echo json_encode([]);
            return;
        }

        $data = $this->db->select('asset_kd_singkat')
                        ->from('mst_asset')
                        ->where('kategori_id', $kategori_id)
                        ->where('asset_kd_singkat !=', '') 
                        ->where('asset_kd_singkat IS NOT NULL', null, false)
                        ->where('deleted_st', 0)
                        ->group_by('asset_kd_singkat')
                        ->order_by('asset_kd_singkat', 'ASC')
                        ->get()
                        ->result_array();
        
        ob_end_clean();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // --- Private Helper Methods ---

    private function _insert_new($data, $tgl_beli_sql)
    {
        $tahun = date('Y', strtotime($tgl_beli_sql));
        $bulan = date('m', strtotime($tgl_beli_sql));
        
        // Generate SKU Otomatis
        $data['asset_kd']   = $this->model->get_next_full_sku($data['kategori_id'], $data['asset_kd_singkat'], $tahun, $bulan);
        $data['deleted_st'] = 0;
        $data['created_by'] = $this->session->userdata('user_id');
        
        DB::insert($this->table, $data);
        return $this->db->insert_id();
    }

    private function _update_existing($id, $data)
    {
        $data['updated_by'] = $this->session->userdata('user_id');
        DB::update($this->table, $data, [$this->pk_id => $id]);
    }

    private function _save_custom_attributes($asset_id, $data_kustom)
    {
        // Hapus data lama (Reset)
        $this->db->delete('dat_asset_value', ['asset_id' => $asset_id]);

        if (empty($data_kustom)) return;

        $batch_data = [];
        foreach ($data_kustom as $atribut_id => $isi_value) {
            if (!empty($isi_value)) {
                $batch_data[] = [
                    'asset_id'   => $asset_id,
                    'atribut_id' => $atribut_id,
                    'value_isi'  => $isi_value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('user_id')
                ];
            }
        }

        if (!empty($batch_data)) {
            $this->db->insert_batch('dat_asset_value', $batch_data);
        }
    }

    private function _sanitize_money($value)
    {
        // Hapus titik ribuan (1.000.000 -> 1000000)
        $clean = str_replace('.', '', $value);
        return empty($clean) ? 0 : $clean;
    }

    private function _convert_date_to_sql($date_raw)
    {
        if (empty($date_raw)) return date('Y-m-d');
        
        // Konversi dari dd-mm-yyyy ke Y-m-d
        if (strpos($date_raw, '-') !== false) {
            $parts = explode('-', $date_raw);
            if (count($parts) == 3 && strlen($parts[2]) == 4) {
                return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
        }
        return $date_raw;
    }
}