<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Persediaan_keluar extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['persediaan/m_persediaan_keluar']);
        
        $this->table = $this->m_persediaan_keluar->table;
        $this->pk_id = $this->m_persediaan_keluar->pk_id;
        $this->template = 'persediaan/keluar/'; 
        $this->uri = 'persediaan/persediaan_keluar'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        $this->m_persediaan_keluar->load_datatables();
    }

    // --- AJAX: Ambil Stok Terkini ---
    public function get_stok_saat_ini()
    {
        $id = $this->input->get('persediaan_id');
        if(empty($id)) { echo json_encode(['status'=>false]); return; }

        $stok = $this->m_persediaan_keluar->get_stok_item($id);
        echo json_encode(['status'=>true, 'stok'=>$stok]);
    }

    // --- AJAX: Generate Nomor Otomatis ---
    public function get_penomoran_otomatis()
    {
        $kategori_id = $this->input->get('kategori_id'); 
        $tgl_raw     = $this->input->get('tanggal');
        
        // [FIX] Konversi Tanggal (dd-mm-yyyy -> yyyy-mm-dd)
        $tgl_sql = $tgl_raw;
        if (strpos($tgl_raw, '-') !== false) {
            $tgl_sql = date('Y-m-d', strtotime($tgl_raw));
        }

        // Ambil Kode Kategori
        $kode_kat = 'OUT'; 
        if(!empty($kategori_id)) {
            $kategori = $this->db->get_where('mst_kategori_persediaan', ['kategori_id' => $kategori_id])->row();
            if($kategori && isset($kategori->kategori_kd)) {
                $kode_kat = 'OUT-' . $kategori->kategori_kd; 
            }
        }

        // Generate nomor pakai tanggal SQL
        $new_no = $this->m_persediaan_keluar->get_nomor_urut($kode_kat, $tgl_sql);
        
        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'no_otomatis' => $new_no]);
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        
        // [FIX] Site URL
        $d['form_act'] = site_url($this->uri . '/save' . ($id ? '/' . $id : ''));

        if ($id) {
            $detail = $this->db->get_where('dat_persediaan_keluar_det', ['keluar_id' => $id])->row_array();
            if ($detail && $d['main']) {
                $d['main'] = array_merge($d['main'], $detail);
            }
        }

        $d['list_kategori'] = $this->db->get('mst_kategori_persediaan')->result_array();
        
        $d['list_barang'] = $this->db->select('p.*, s.satuan_nm')
                                     ->from('mst_persediaan p')
                                     ->join('mst_satuan s', 's.satuan_id = p.satuan_id', 'left')
                                     ->where('p.deleted_st', 0)
                                     ->where('p.stok_qty >', 0) 
                                     ->order_by('p.barang_nm', 'ASC')
                                     ->get()->result_array();

        $d['list_satuan'] = $this->db->where('deleted_st', 0)->order_by('satuan_nm', 'ASC')->get('mst_satuan')->result_array();

        $d['list_pegawai'] = $this->db->select('pegawai_id, pegawai_nm')
                                      ->from('mst_pegawai')
                                      ->where('deleted_st', 0)
                                      ->where('active_st', 1) 
                                      ->order_by('pegawai_nm', 'ASC')
                                      ->get()->result_array();

        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $d = _post();

        if (empty($d['keluar_tgl'])) { _json(['status' => false, 'msg' => 'Tanggal wajib diisi.']); return; }
        if (empty($d['persediaan_id'])) { _json(['status' => false, 'msg' => 'Barang wajib dipilih.']); return; }
        if (empty($d['keluar_qty']) || $d['keluar_qty'] <= 0) { _json(['status' => false, 'msg' => 'Jumlah harus lebih dari 0.']); return; }

        // [FIX] Konversi Tanggal
        $tgl_raw = $d['keluar_tgl'];
        $tgl_sql = $tgl_raw;
        if (strpos($tgl_raw, '-') !== false) {
            $tgl_sql = date('Y-m-d', strtotime($tgl_raw));
        }

        // 1. VALIDASI STOK
        $stok_sekarang = $this->m_persediaan_keluar->get_stok_item($d['persediaan_id']);
        if ($d['keluar_qty'] > $stok_sekarang) {
             _json(['status' => false, 'msg' => 'Gagal! Stok tidak mencukupi. Sisa stok: ' . $stok_sekarang]); return;
        }

        // 2. Generate No Transaksi
        $no_struk = $d['struk_no'];
        if (empty($no_struk) || strpos($no_struk, '-AUTO') !== false) {
             $kategori = $this->db->get_where('mst_kategori_persediaan', ['kategori_id' => $d['kategori_temp']])->row();
             $kode_kat = ($kategori) ? 'OUT-' . $kategori->kategori_kd : 'OUT';
             // Gunakan tanggal SQL
             $no_struk = $this->m_persediaan_keluar->get_nomor_urut($kode_kat, $tgl_sql);
        }

        $data_header = [
            'struk_no'       => $no_struk,
            'keluar_tgl'     => $tgl_sql, // Masuk DB YYYY-MM-DD
            'keperluan_jenis'=> $d['keperluan_jenis'],
            'penerima_nm'    => $d['penerima_nm'],
            'keterangan_txt' => $d['keterangan_txt'],
            'total_qty'      => $d['keluar_qty'],
            'active_st'      => 1
        ];

        $data_detail = [
            'persediaan_id'  => $d['persediaan_id'],
            'satuan_id'      => $d['satuan_id'],
            'keluar_qty'     => $d['keluar_qty'],
            'keterangan_txt' => '',
            'created_at'     => date('Y-m-d H:i:s'),
            'created_by'     => $this->session->userdata('user_id'),
            'active_st'      => 1,
            'deleted_st'     => 0
        ];

        if ($id == null) {
            $data_header['created_at'] = date('Y-m-d H:i:s');
            $data_header['created_by'] = $this->session->userdata('user_id');
            $data_header['deleted_st'] = 0;

            $status = $this->m_persediaan_keluar->simpan_pemakaian($data_header, [$data_detail]);

            if ($status) {
                _json(_response('01', site_url($this->uri)));
            } else {
                _json(['status' => false, 'msg' => 'Gagal menyimpan transaksi.']);
            }
        } else {
             _json(['status' => false, 'msg' => 'Edit data dikunci demi keamanan stok.']);
        }
    }
    
    public function delete($id = null) {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $w);
        _json(_response('03', site_url($this->uri)));
    }
}