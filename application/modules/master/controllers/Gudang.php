<?php defined('BASEPATH') or exit('No direct script access allowed');

class Gudang extends MY_Controller
{
    // Konfigurasi dasar path view dan URI
    protected $view_path = 'master/gudang/';
    protected $uri_path  = 'master/gudang';

    public function __construct()
    {
        parent::__construct();
        _models(['master/m_gudang']);
        
        $this->table = $this->m_gudang->table;
        $this->pk_id = $this->m_gudang->pk_id;
    }

    public function index()
    {
        $this->render($this->view_path . 'index');
    }

    public function form_modal($id = null)
    {
        $data = [];
        $is_new_entry = ($id === null);

        // Ambil data utama berdasarkan ID
        $data['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $data['form_act'] = site_url($this->uri_path . '/save/' . $id);
        
        // Ambil data referensi pegawai untuk dropdown PIC
        $data['list_pegawai'] = $this->db->select('pegawai_id, pegawai_nm, user_id') 
                              ->where(['active_st' => 1, 'deleted_st' => 0])
                              ->get('mst_pegawai')->result_array();

        // Generate kode otomatis jika input baru
        if ($is_new_entry) {
            $data['main']['gudang_kd'] = $this->m_gudang->get_next_kode_gudang();
        }
        
        $this->render($this->view_path . 'form_modal', $data);
    }

    public function save($id = null)
    {
        $input_data = _post();
        
        // Cek apakah ini proses update atau insert baru
        if (!empty($id)) {
            return $this->_update_existing($id, $input_data);
        }

        return $this->_insert_new($input_data);
    }

    public function delete($id = null) 
    {
        if (empty($id)) return;

        // Soft delete data
        $where = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $where);
        
        _json(_response('03', site_url($this->uri_path)));
    }
    
    public function ajax_datatables() 
    { 
        $this->m_gudang->load_datatables(); 
    }

    // --- Private Methods ---

    // Proses simpan data baru
    private function _insert_new($data)
    {
        // Pastikan kode terisi
        if (empty($data['gudang_kd'])) {
            $data['gudang_kd'] = $this->m_gudang->get_next_kode_gudang();
        }
        
        $data['created_by'] = $this->session->userdata('user_id');
        $data['deleted_st'] = 0;
        
        DB::insert($this->table, $data);
        _json(_response('01', site_url($this->uri_path)));
    }

    // Proses update data lama
    private function _update_existing($id, $data)
    {
        $where = [$this->pk_id => $id];
        $data['updated_by'] = $this->session->userdata('user_id');
        
        DB::update($this->table, $data, $where);
        _json(_response('02', site_url($this->uri_path)));
    }
}