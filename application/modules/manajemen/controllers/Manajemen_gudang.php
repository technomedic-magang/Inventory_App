<?php defined('BASEPATH') or exit('No direct script access allowed');

class Manajemen_gudang extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['manajemen/m_manajemen_gudang']);
        $this->table = $this->m_manajemen_gudang->table;
        $this->pk_id = $this->m_manajemen_gudang->pk_id;
        $this->template = 'manajemen/manajemen_gudang/';
        // Pastikan URI sesuai folder controller Anda
        $this->uri_mod = 'manajemen/manajemen_gudang'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = site_url($this->uri_mod . '/save/' . $id);
        
        // [MODIFIKASI 1] Ambil list pegawai untuk dropdown PIC
        $d['list_pegawai'] = $this->db->select('pegawai_id, pegawai_nm, user_id') 
                              ->where(['active_st' => 1, 'deleted_st' => 0])
                              ->get('mst_pegawai')->result_array();
        if ($id == null) {
            // Jika tambah baru, generate kode otomatis
            $d['main']['gudang_kd'] = $this->m_manajemen_gudang->get_next_kode_gudang();
        }
        
        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        // Ambil data POST
        $d = _post();
        
        // [MODIFIKASI 2] Bersihkan data yang tidak perlu masuk DB (jika ada)
        // Pastikan input 'pegawai_id' tersimpan, bukan 'pic_nm' lagi
        
        $w = ($id != '' ? [$this->pk_id => $id] : null);

        if ($id == null) {
            if (empty($d['gudang_kd'])) {
                $d['gudang_kd'] = $this->m_manajemen_gudang->get_next_kode_gudang();
            }
            $d['created_by'] = $this->session->userdata('user_id'); // [Baru] Catat pembuat
            $d['deleted_st'] = 0;
            DB::insert($this->table, $d);
            _json(_response('01', site_url($this->uri_mod)));
        } else {
            $d['updated_by'] = $this->session->userdata('user_id'); // [Baru] Catat pengupdate
            DB::update($this->table, $d, $w);
            _json(_response('02', site_url($this->uri_mod)));
        }
    }

    public function delete($id = null) {
        $w = ($id != '' ? [$this->pk_id => $id] : null);
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', site_url($this->uri_mod)));
    }
    
    public function ajax_datatables() { 
        $this->m_manajemen_gudang->load_datatables(); 
    }
}