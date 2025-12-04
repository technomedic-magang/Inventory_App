<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Persediaan_masuk extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['persediaan/m_persediaan_masuk']);
        
        $this->table = $this->m_persediaan_masuk->table;
        $this->pk_id = $this->m_persediaan_masuk->pk_id;
        $this->template = 'persediaan/masuk/'; 
        $this->uri = 'persediaan/persediaan_masuk'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        $this->m_persediaan_masuk->load_datatables();
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = site_url($this->uri . '/save' . ($id ? '/' . $id : ''));

        if ($id) {
            $detail = $this->db->get_where('dat_persediaan_masuk_det', ['masuk_id' => $id])->row_array();
            if ($detail && $d['main']) {
                $d['main'] = array_merge($d['main'], $detail);
            }
        }

        $d['list_kategori'] = $this->db->get('mst_kategori_persediaan')->result_array();
        
        $d['list_barang'] = $this->db->select('p.*, s.satuan_nm')
                                     ->from('mst_persediaan p')
                                     ->join('mst_satuan s', 's.satuan_id = p.satuan_id', 'left')
                                     ->where('p.deleted_st', 0)
                                     ->order_by('p.barang_nm', 'ASC')
                                     ->get()->result_array();

        $d['list_satuan'] = $this->db->where('deleted_st', 0)->order_by('satuan_nm', 'ASC')->get('mst_satuan')->result_array();

        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $d = _post();

        if (empty($d['beli_tgl'])) { _json(['status' => false, 'msg' => 'Tanggal wajib diisi.']); return; }
        if (empty($d['kategori_temp'])) { _json(['status' => false, 'msg' => 'Kategori wajib dipilih.']); return; }
        if (empty($d['persediaan_id'])) { _json(['status' => false, 'msg' => 'Nama Barang wajib diisi.']); return; }

        $input_barang = trim($d['persediaan_id']); 
        $persediaan_id = null;
        $update_lokasi = ['lokasi_lantai' => $d['lokasi_lantai'], 'lokasi_ruang' => $d['lokasi_ruang']];

        // 1. LOGIKA BARANG
        if (is_numeric($input_barang)) {
            $persediaan_id = $input_barang;
            $this->db->where('persediaan_id', $persediaan_id)->update('mst_persediaan', $update_lokasi);
        } else {
            $this->db->where('LOWER(barang_nm)', strtolower($input_barang))->where('deleted_st', 0);
            $cek = $this->db->get('mst_persediaan')->row();
            
            if ($cek) {
                $persediaan_id = $cek->persediaan_id;
                $this->db->where('persediaan_id', $persediaan_id)->update('mst_persediaan', $update_lokasi);
            } else {
                $data_master = [
                    'barang_nm'     => $input_barang, 
                    'barang_kd'     => 'AUTO-' . rand(1000,9999), 
                    'satuan_id'     => $d['satuan_id'],
                    'kategori_id'   => $d['kategori_temp'],
                    'stok_qty'      => 0,
                    'lokasi_lantai' => $d['lokasi_lantai'],
                    'lokasi_ruang'  => $d['lokasi_ruang'],
                    'active_st'     => 1,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'created_by'    => $this->session->userdata('user_id')
                ];
                $this->db->insert('mst_persediaan', $data_master);
                $persediaan_id = $this->db->insert_id(); 
            }
        }

        // 2. LOGIKA NO STRUK (Cek format baru)
        $no_struk_final = $d['struk_no'];
        // Jika kosong ATAU mengandung kata '-AUTO' (berarti user pakai generator preview)
        if (empty($no_struk_final) || strpos($no_struk_final, '-AUTO') !== false) {
            // Generate nomor asli via Model
            $no_struk_final = $this->m_persediaan_masuk->get_nomor_urut($d['kategori_temp'], $d['beli_tgl']);
        }

        $data_header = [
            'struk_no'       => $no_struk_final,
            'beli_tgl'       => $d['beli_tgl'],
            'keterangan_txt' => $d['keterangan_txt'],
            'total_qty'      => $d['masuk_qty'],
            'active_st'      => 1
        ];

        $data_detail = [
            'persediaan_id'  => $persediaan_id,
            'satuan_id'      => $d['satuan_id'],
            'masuk_qty'      => $d['masuk_qty'],
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

            $status = $this->m_persediaan_masuk->simpan_restock($data_header, [$data_detail]);

            if ($status) {
                $redirect_url = site_url($this->uri); 
                _json(_response('01', $redirect_url));
            } else {
                _json(['status' => false, 'msg' => 'Gagal menyimpan transaksi.']);
            }
        } else {
             _json(['status' => false, 'msg' => 'Edit data dikunci.']);
        }
    }
    
    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $w);
        _json(_response('03', $this->uri));
    }
}