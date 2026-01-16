<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Persediaan_keluar extends MY_Controller
{
    protected $view_path = 'persediaan/keluar/';
    // Definisi Full URL di sini untuk konsistensi
    protected $uri_path  = 'persediaan/persediaan_keluar'; 

    public function __construct()
    {
        parent::__construct();
        _models(['persediaan/m_persediaan_keluar']);
        
        $this->model = $this->m_persediaan_keluar;
        $this->table = $this->model->table;
        $this->pk_id = $this->model->pk_id;
        
        // Set URI sebagai Full URL
        $this->uri = site_url($this->uri_path); 
    }

    public function index()
    {
        $this->render($this->view_path . 'index');
    }

    public function ajax_datatables()
    {
        $this->model->load_datatables();
    }

    public function form_modal($id = null)
    {
        $data = [];
        
        // 1. Data Utama
        $data['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $data['form_act'] = $this->uri . '/save/' . $id;

        if ($id) {
            $detail = $this->db->get_where('dat_persediaan_keluar_det', ['keluar_id' => $id])->row_array();
            if ($detail && $data['main']) {
                $data['main'] = array_merge($data['main'], $detail);
            }
        }

        // 2. Data Referensi
        $data['list_kategori'] = $this->db->get('mst_kategori_persediaan')->result_array();
        $data['list_satuan']   = $this->db->where('deleted_st', 0)->order_by('satuan_nm', 'ASC')->get('mst_satuan')->result_array();
        
        // 3. List Barang (Hanya yang punya stok)
        $data['list_barang'] = $this->db->select('p.*, s.satuan_nm')
                                     ->from('mst_persediaan p')
                                     ->join('mst_satuan s', 's.satuan_id = p.satuan_id', 'left')
                                     ->where('p.deleted_st', 0)
                                     ->where('p.stok_qty >', 0) 
                                     ->order_by('p.barang_nm', 'ASC')
                                     ->get()->result_array();

        // 4. List Pegawai (Penerima)
        $data['list_pegawai'] = $this->db->select('pegawai_id, pegawai_nm')
                                      ->from('mst_pegawai')
                                      ->where(['deleted_st' => 0, 'active_st' => 1])
                                      ->order_by('pegawai_nm', 'ASC')
                                      ->get()->result_array();

        $this->render($this->view_path . 'form_modal', $data);
    }

    public function save($id = null)
    {
        if ($id != null) {
             _json(['status' => false, 'msg' => 'Edit data dikunci demi keamanan stok.']);
             return;
        }

        $input = _post();

        // 1. Validasi Input (Guard Clauses)
        if (empty($input['keluar_tgl'])) { _json(['status' => false, 'msg' => 'Tanggal wajib diisi.']); return; }
        if (empty($input['persediaan_id'])) { _json(['status' => false, 'msg' => 'Barang wajib dipilih.']); return; }
        if (empty($input['keluar_qty']) || $input['keluar_qty'] <= 0) { _json(['status' => false, 'msg' => 'Jumlah harus lebih dari 0.']); return; }

        // 2. Cek Kecukupan Stok
        $is_stock_ok = $this->_validate_stock($input['persediaan_id'], $input['keluar_qty']);
        if (!$is_stock_ok) return; // Pesan error sudah dikirim di dalam fungsi _validate

        // 3. Persiapan Data
        $tgl_sql = $this->_convert_date($input['keluar_tgl']);
        $no_struk = $this->_generate_transaction_number($input, $tgl_sql);

        $data_header = [
            'struk_no'       => $no_struk,
            'keluar_tgl'     => $tgl_sql,
            'keperluan_jenis'=> $input['keperluan_jenis'],
            'penerima_nm'    => $input['penerima_nm'],
            'keterangan_txt' => $input['keterangan_txt'],
            'total_qty'      => $input['keluar_qty'],
            'active_st'      => 1,
            'deleted_st'     => 0,
            'created_at'     => date('Y-m-d H:i:s'),
            'created_by'     => $this->session->userdata('user_id')
        ];

        $data_detail = [
            'persediaan_id'  => $input['persediaan_id'],
            'satuan_id'      => $input['satuan_id'],
            'keluar_qty'     => $input['keluar_qty'],
            'keterangan_txt' => '',
            'active_st'      => 1,
            'deleted_st'     => 0,
            'created_at'     => date('Y-m-d H:i:s'),
            'created_by'     => $this->session->userdata('user_id')
        ];

        // 4. Eksekusi
        $status = $this->model->simpan_pemakaian($data_header, [$data_detail]);

        if ($status) {
            _json(_response('01', $this->uri));
        } else {
            _json(['status' => false, 'msg' => 'Gagal menyimpan transaksi.']);
        }
    }
    
    public function delete($id = null) 
    {
        if (empty($id)) return;
        
        $where = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $where);
        
        _json(_response('03', $this->uri));
    }

    // --- AJAX Methods ---

    public function get_stok_saat_ini()
    {
        $id = $this->input->get('persediaan_id');
        if(empty($id)) { echo json_encode(['status'=>false]); return; }

        $stok = $this->model->get_stok_item($id);
        echo json_encode(['status'=>true, 'stok'=>$stok]);
    }

    // --- Private Helpers ---

    private function _validate_stock($persediaan_id, $qty_input)
    {
        $stok_sekarang = $this->model->get_stok_item($persediaan_id);
        if ($qty_input > $stok_sekarang) {
             _json(['status' => false, 'msg' => 'Gagal! Stok tidak mencukupi. Sisa stok: ' . $stok_sekarang]); 
             return false;
        }
        return true;
    }

    private function _generate_transaction_number($input, $tgl_sql)
    {
        $no_struk = $input['struk_no'];
        
        // Jika Auto atau Kosong, generate baru
        if (empty($no_struk) || strpos($no_struk, '-AUTO') !== false) {
             $kategori_id = $input['kategori_temp'];
             
             // Ambil Kode Kategori
             $kategori = $this->db->get_where('mst_kategori_persediaan', ['kategori_id' => $kategori_id])->row();
             $kode_kat = ($kategori) ? 'OUT-' . $kategori->kategori_kd : 'OUT';
             
             return $this->model->get_nomor_urut($kode_kat, $tgl_sql);
        }
        
        return $no_struk;
    }

    private function _convert_date($date_raw)
    {
        if (empty($date_raw)) return date('Y-m-d');
        if (strpos($date_raw, '-') !== false) {
            $parts = explode('-', $date_raw);
            if (count($parts) == 3 && strlen($parts[2]) == 4) {
                return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
        }
        return $date_raw;
    }
}