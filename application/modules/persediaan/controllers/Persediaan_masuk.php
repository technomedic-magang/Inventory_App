<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Persediaan_masuk extends MY_Controller
{
    // Definisi path view
    protected $view_path = 'persediaan/masuk/';

    public function __construct()
    {
        parent::__construct();
        _models(['persediaan/m_persediaan_masuk']);
        
        $this->model = $this->m_persediaan_masuk;
        $this->table = $this->model->table;
        $this->pk_id = $this->model->pk_id;

        // [FIX ERROR AJAX]
        // Definisi URI sebagai FULL URL agar konsisten dengan _js.php
        $this->uri = site_url('persediaan/persediaan_masuk');
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
        
        // Ambil Data Utama
        $data['main'] = DB::get($this->table, [$this->pk_id => $id]);
        
        // URL Action Form (Gunakan $this->uri langsung)
        $data['form_act'] = $this->uri . '/save/' . $id;

        if ($id) {
            $detail = $this->db->get_where('dat_persediaan_masuk_det', ['masuk_id' => $id])->row_array();
            if ($detail && $data['main']) {
                $data['main'] = array_merge($data['main'], $detail);
            }
        }

        // Data Referensi
        $data['list_kategori'] = $this->db->get('mst_kategori_persediaan')->result_array();
        $data['list_satuan']   = $this->db->where('deleted_st', 0)->order_by('satuan_nm', 'ASC')->get('mst_satuan')->result_array();
        
        // List Barang
        $data['list_barang'] = $this->db->select('p.*, s.satuan_nm')
                                     ->from('mst_persediaan p')
                                     ->join('mst_satuan s', 's.satuan_id = p.satuan_id', 'left')
                                     ->where('p.deleted_st', 0)
                                     ->order_by('p.barang_nm', 'ASC')
                                     ->get()->result_array();

        $this->render($this->view_path . 'form_modal', $data);
    }

    public function save($id = null)
    {
        if ($id != null) {
             _json(['status' => false, 'msg' => 'Edit data dikunci.']);
             return;
        }

        $input = _post();

        // Validasi
        if (empty($input['beli_tgl'])) { _json(['status' => false, 'msg' => 'Tanggal wajib diisi.']); return; }
        if (empty($input['kategori_temp'])) { _json(['status' => false, 'msg' => 'Kategori wajib dipilih.']); return; }
        if (empty($input['persediaan_id'])) { _json(['status' => false, 'msg' => 'Nama Barang wajib diisi.']); return; }

        $tgl_sql = $this->_convert_date($input['beli_tgl']);
        
        // Proses Master Barang & Transaksi
        $persediaan_id = $this->_process_master_item($input);
        $this->_process_transaction($input, $persediaan_id, $tgl_sql);
    }
    
    public function delete($id = null)
    {
        if (empty($id)) return;

        $where = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $where);
        
        _json(_response('03', $this->uri));
    }

    // --- Private Helper Methods ---

    private function _process_master_item($input)
    {
        $input_barang  = trim($input['persediaan_id']); 
        $update_lokasi = [
            'lokasi_lantai' => $input['lokasi_lantai'], 
            'lokasi_ruang'  => $input['lokasi_ruang']
        ];

        // Cek apakah input berupa ID (Barang Lama)
        if (is_numeric($input_barang)) {
            $this->db->where('persediaan_id', $input_barang)->update('mst_persediaan', $update_lokasi);
            return $input_barang;
        } 
        
        // Cek by Nama
        $this->db->where('LOWER(barang_nm)', strtolower($input_barang))->where('deleted_st', 0);
        $cek = $this->db->get('mst_persediaan')->row();
        
        if ($cek) {
            $this->db->where('persediaan_id', $cek->persediaan_id)->update('mst_persediaan', $update_lokasi);
            return $cek->persediaan_id;
        } 
        
        // Barang Baru
        $data_master = [
            'barang_nm'     => $input_barang, 
            'barang_kd'     => 'AUTO-' . rand(1000,9999), 
            'satuan_id'     => $input['satuan_id'],
            'kategori_id'   => $input['kategori_temp'],
            'stok_qty'      => 0,
            'lokasi_lantai' => $input['lokasi_lantai'],
            'lokasi_ruang'  => $input['lokasi_ruang'],
            'active_st'     => 1,
            'created_at'    => date('Y-m-d H:i:s'),
            'created_by'    => $this->session->userdata('user_id')
        ];
        
        $this->db->insert('mst_persediaan', $data_master);
        return $this->db->insert_id(); 
    }

    private function _process_transaction($input, $persediaan_id, $tgl_sql)
    {
        $no_struk = $input['struk_no'];
        if (empty($no_struk) || strpos($no_struk, '-AUTO') !== false) {
            $no_struk = $this->model->get_nomor_urut($input['kategori_temp'], $tgl_sql);
        }

        $data_header = [
            'struk_no'       => $no_struk,
            'beli_tgl'       => $tgl_sql,
            'keterangan_txt' => $input['keterangan_txt'],
            'total_qty'      => $input['masuk_qty'],
            'active_st'      => 1,
            'deleted_st'     => 0,
            'created_at'     => date('Y-m-d H:i:s'),
            'created_by'     => $this->session->userdata('user_id')
        ];

        $data_detail = [
            'persediaan_id'  => $persediaan_id,
            'satuan_id'      => $input['satuan_id'],
            'masuk_qty'      => $input['masuk_qty'],
            'keterangan_txt' => '',
            'active_st'      => 1,
            'deleted_st'     => 0,
            'created_at'     => date('Y-m-d H:i:s'),
            'created_by'     => $this->session->userdata('user_id')
        ];

        $status = $this->model->simpan_restock($data_header, [$data_detail]);

        if ($status) {
            _json(_response('01', $this->uri));
        } else {
            _json(['status' => false, 'msg' => 'Gagal menyimpan transaksi.']);
        }
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