<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manajemen_asset extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['manajemen/m_manajemen_asset']);
        $this->table = $this->m_manajemen_asset->table;
        $this->pk_id = $this->m_manajemen_asset->pk_id;
        $this->template = 'manajemen/manajemen_asset/'; 
    }

    public function index()
    {
        // [FIX] Ambil data kategori agar dropdown di view tidak kosong
        $d['list_kategori'] = $this->db->where('deleted_st', 0)
                                       ->order_by('kategori_nm', 'ASC')
                                       ->get('mst_kategori')
                                       ->result_array();
        // Kirim variabel $d ke view
        $this->render($this->template . 'index', $d);
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = $this->uri . '/save/' . $id;

        $d['list_kategori'] = $this->db->where('deleted_st', 0)->order_by('kategori_nm', 'ASC')->get('mst_kategori')->result_array();
        $d['list_satuan']   = $this->db->where('deleted_st', 0)->order_by('satuan_nm', 'ASC')->get('mst_satuan')->result_array();

        $d['list_kustom'] = [];
        if ($id) {
            $data_kustom = $this->db->select('v.atribut_id, v.value_isi')
                                  ->from('dat_asset_value v')
                                  ->where('v.asset_id', $id)
                                  ->get()->result_array();
            foreach($data_kustom as $k) {
                $d['list_kustom'][$k['atribut_id']] = $k['value_isi'];
            }
        }
        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $d = _post();
        
        $data_main = [
            'kategori_id' => $d['kategori_id'],
            'satuan_id' => $d['satuan_id'],
            'asset_nm' => $d['asset_nm'],
            'asset_kd_singkat' => strtoupper($d['asset_kd_singkat']),
            'asset_thn_beli' => $d['asset_thn_beli'],
            'asset_bln_beli' => $d['asset_bln_beli'],
            'asset_masa_pakai_thn' => $d['asset_masa_pakai_thn'] ?? 0,
            'asset_kondisi' => $d['asset_kondisi'] ?? 'BAIK',
            'stok_min_qty' => $d['stok_min_qty'] ?? 0,
            'asset_ket' => $d['asset_ket'] ?? NULL,
            'active_st' => $d['active_st']
        ];
        
        $data_kustom = $d['kustom'] ?? [];

        if ($id == null) {
            $data_main['asset_kd'] = $this->m_manajemen_asset->get_next_full_sku(
                $d['kategori_id'], $data_main['asset_kd_singkat'], $d['asset_thn_beli'], $d['asset_bln_beli']
            );
            $data_main['deleted_st'] = 0;
            DB::insert($this->table, $data_main);
            $id = $this->db->insert_id();
        } else {
            $data_main['asset_kd'] = $d['asset_kd']; 
            DB::update($this->table, $data_main, [$this->pk_id => $id]);
        }

        $this->db->delete('dat_asset_value', ['asset_id' => $id]);
        if (!empty($data_kustom)) {
            $batch_data = [];
            foreach ($data_kustom as $atribut_id => $isi_value) {
                if (!empty($isi_value)) {
                    $batch_data[] = [
                        'asset_id'   => $id,
                        'atribut_id' => $atribut_id,
                        'value_isi'  => $isi_value,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
            }
            if (!empty($batch_data)) {
                $this->db->insert_batch('dat_asset_value', $batch_data);
            }
        }
        _json(_response('01', $this->uri));
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $w);
        _json(_response('03', $this->uri));
    }

    public function ajax_datatables()
    {
        $this->m_manajemen_asset->load_datatables();
    }

    public function get_sku_ajax()
    {
        $kategori_id = $this->input->post('kategori_id');
        $kd_singkat  = $this->input->post('kd_singkat');
        $tahun       = $this->input->post('tahun');
        $bulan       = $this->input->post('bulan');

        $new_sku = $this->m_manajemen_asset->get_next_full_sku($kategori_id, $kd_singkat, $tahun, $bulan);
        echo json_encode(['new_sku' => $new_sku]);
    }

    public function get_atribut_dinamis()
    {
        $kategori_id = $this->input->post('kategori_id');
        $asset_id = $this->input->post('asset_id'); 
        
        $kategori = $this->db->get_where('mst_kategori', ['kategori_id' => $kategori_id])->row_array();
        if (!$kategori) { echo json_encode(['html' => '', 'tipe' => '']); return; }

        $list_atribut = $this->db->where('kategori_id', $kategori_id)
                                 ->where('deleted_st', 0)
                                 ->order_by('atribut_urutan', 'ASC')
                                 ->get('mst_kategori_atribut')->result_array();
        
        $data['list_atribut'] = $list_atribut;
        $data['tipe_kategori'] = $kategori['kategori_tipe'];
        
        $data_tersimpan_raw = $this->db->where('asset_id', $asset_id)->get('dat_asset_value')->result_array();
        $data_tersimpan = [];
        foreach($data_tersimpan_raw as $val) { $data_tersimpan[$val['atribut_id']] = $val['value_isi']; }
        $data['tersimpan'] = $data_tersimpan; 

        $html = $this->load->view($this->template . '_ajax_form_dinamis', $data, TRUE);
        echo json_encode(['html' => $html, 'tipe' => $kategori['kategori_tipe']]);
    }
}