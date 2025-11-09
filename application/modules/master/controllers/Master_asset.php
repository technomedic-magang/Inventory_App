<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_asset extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['master/m_master_asset']);
        $this->table = $this->m_master_asset->table;
        $this->pk_id = $this->m_master_asset->pk_id;
        $this->template = 'master/master_asset/';
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = $this->uri . '/save/' . $id;

        // Ambil data dropdown (filter hanya yang aktif & tidak terhapus)
        $d['list_kategori'] = $this->db->where(['deleted_st' => 0, 'active_st' => 1])->get('mst_kategori')->result_array();
        $d['list_satuan']   = $this->db->where(['deleted_st' => 0, 'active_st' => 1])->get('mst_satuan')->result_array();

        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $d = _post();
        
        if ($id == null) {
            // --- LOGIKA AUTO-GENERATE SKU ---
            // Jika user tidak mengisi asset_kd, kita buatkan otomatis
            if (empty($d['asset_kd'])) {
                $prefix = $this->m_master_asset->get_kategori_prefix($d['kategori_id']);
                if ($prefix) {
                    $d['asset_kd'] = $this->m_master_asset->get_next_sku($prefix);
                } else {
                    // Fallback jika kategori tidak punya kode
                    $d['asset_kd'] = 'BRG-' . date('ymdHis'); 
                }
            }
            // Default nilai wajib TMFW saat insert
            $d['deleted_st'] = 0;
            // $d['created_by'] = $this->session->userdata('user_id'); // Aktifkan jika sudah login beneran

            DB::insert($this->table, $d);
            _json(_response('01', $this->uri));
        } else {
            // Saat update, jangan lupa set updated_at/by (biasanya otomatis oleh DB trigger, tapi aman diset juga)
            // $d['updated_by'] = $this->session->userdata('user_id');
            
            $w = [$this->pk_id => $id];
            DB::update($this->table, $d, $w);
            _json(_response('02', $this->uri));
        }
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        // Soft delete standar TMFW
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $w);
        _json(_response('03', $this->uri));
    }

    public function ajax_datatables()
    {
        $this->m_master_asset->load_datatables();
    }

    // --- API AJAX untuk Form Modal ---
    public function get_sku_ajax()
    {
        $kategori_id = $this->input->post('kategori_id');
        $prefix = $this->m_master_asset->get_kategori_prefix($kategori_id);
        $new_sku = ($prefix) ? $this->m_master_asset->get_next_sku($prefix) : '';
        echo json_encode(['new_sku' => $new_sku]);
    }
}