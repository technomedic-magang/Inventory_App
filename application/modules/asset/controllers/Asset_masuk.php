<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asset_masuk extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['asset/m_asset_masuk']);
        $this->table = $this->m_asset_masuk->table;
        $this->pk_id = $this->m_asset_masuk->pk_id;
        $this->template = 'asset/asset_masuk/';
<<<<<<< HEAD
=======
        $this->uri_mod = 'asset/asset_masuk'; // Helper URL
>>>>>>> repoB/main
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null)
    { 
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
<<<<<<< HEAD
        $d['form_act'] = $this->uri . '/save/' . $id;
=======
        $d['form_act'] = site_url($this->uri_mod . '/save/' . $id);
>>>>>>> repoB/main

        // Data Gudang
        $d['list_gudang'] = $this->db->where(['deleted_st' => 0, 'active_st' => 1])
                                     ->get('mst_gudang')->result_array();
        
<<<<<<< HEAD
        // [BARU] Ambil List Kategori untuk Filter
=======
        // Data Kategori
>>>>>>> repoB/main
        $d['list_kategori'] = $this->db->where(['deleted_st' => 0, 'active_st' => 1, 'kategori_tipe' => 'ASET'])
                                       ->order_by('kategori_nm', 'ASC')
                                       ->get('mst_kategori')->result_array();

<<<<<<< HEAD
        // [UBAH] List Asset dikosongkan (User wajib pilih kategori dulu)
        $d['list_asset'] = [];
=======
        $d['list_asset'] = []; // Kosongkan awal
>>>>>>> repoB/main

        $this->render($this->template . 'form_modal', $d);
    }
    
<<<<<<< HEAD
=======
    // [UPDATE] Menggunakan _convert_date agar lebih rapi
    public function get_no_transaksi_ajax()
    {
        $tgl_raw = $this->input->post('tanggal');
        $asset_id = $this->input->post('asset_id');

        if (empty($tgl_raw) || empty($asset_id)) {
            echo json_encode(['status' => false, 'transaksi_no' => '']);
            return;
        }

        // Gunakan Helper Konversi
        $tgl_transaksi = $this->_convert_date($tgl_raw);

        $seq_part = $this->m_asset_masuk->get_auto_number($tgl_transaksi);
        $sku_part = $this->m_asset_masuk->get_sku_by_asset_id($asset_id);

        if ($sku_part) {
            $final_no = $seq_part . '/' . $sku_part;
            echo json_encode(['status' => true, 'transaksi_no' => $final_no]);
        } else {
            echo json_encode(['status' => false, 'transaksi_no' => 'Error: SKU not found']);
        }
    }

>>>>>>> repoB/main
    public function save($id = null)
    {
        if ($id != null) {
            echo json_encode(['status' => '00', 'msg' => 'Edit transaksi belum didukung.']);
            return;
        }

<<<<<<< HEAD
        $tgl_transaksi = $this->input->post('transaksi_tgl');
        $asset_id      = $this->input->post('asset_id');
        $detail_ket    = $this->input->post('detail_ket');

        if (empty($asset_id) || empty($tgl_transaksi)) {
=======
        $tgl_raw    = $this->input->post('transaksi_tgl');
        $asset_id   = $this->input->post('asset_id');
        $detail_ket = $this->input->post('detail_ket');

        if (empty($asset_id) || empty($tgl_raw)) {
>>>>>>> repoB/main
             echo json_encode(['status' => '00', 'msg' => 'Gagal, Tanggal dan Aset wajib diisi.']);
             return;
        }

<<<<<<< HEAD
=======
        // [UPDATE] Konversi Tanggal Aman
        $tgl_transaksi = $this->_convert_date($tgl_raw);

        // Generate No Transaksi Ulang (Safety)
>>>>>>> repoB/main
        $seq_part = $this->m_asset_masuk->get_auto_number($tgl_transaksi);
        $sku_part = $this->m_asset_masuk->get_sku_by_asset_id($asset_id);

        if (!$sku_part) {
             echo json_encode(['status' => '00', 'msg' => 'Gagal, SKU Aset tidak ditemukan.']);
             return;
        }
        
        $final_transaksi_no = $seq_part . '/' . $sku_part;

        $data_header = [
            'gudang_id'     => $this->input->post('gudang_id'),
<<<<<<< HEAD
            'transaksi_tgl' => $tgl_transaksi,
=======
            'transaksi_tgl' => $tgl_transaksi, // Masuk DB format YYYY-MM-DD
>>>>>>> repoB/main
            'transaksi_no'  => $final_transaksi_no,
            'transaksi_ket' => $this->input->post('transaksi_ket'),
            'active_st'     => 1,
            'deleted_st'    => 0,
<<<<<<< HEAD
            'created_by'    => 'PEGAWAI TESTER'
=======
            'created_by'    => $this->session->userdata('user_id') ?? 'SYSTEM'
>>>>>>> repoB/main
        ];
        
        $this->db->trans_start();
        
<<<<<<< HEAD
        // 1. Simpan Transaksi
        $this->m_asset_masuk->simpan_transaksi_aset($data_header, $asset_id, $detail_ket);

        // 2. Simpan Atribut Kustom (Ruangan/Lantai)
=======
        // 1. Simpan Transaksi & Update Stok
        $this->m_asset_masuk->simpan_transaksi_aset($data_header, $asset_id, $detail_ket);

        // 2. Simpan Atribut Kustom (Jika ada form dinamis)
>>>>>>> repoB/main
        $data_kustom = $this->input->post('kustom') ?? [];
        if (!empty($data_kustom)) {
            foreach ($data_kustom as $atribut_id => $isi_value) {
                if (!empty($isi_value)) {
<<<<<<< HEAD
=======
                    // Cek apakah value sudah ada
>>>>>>> repoB/main
                    $cek = $this->db->get_where('dat_asset_value', [
                        'asset_id' => $asset_id, 
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
<<<<<<< HEAD
                            'created_by' => 'SYSTEM-ASSET-MASUK'
=======
                            'created_by' => 'SYSTEM'
>>>>>>> repoB/main
                        ]);
                    }
                }
            }
        }
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
<<<<<<< HEAD
            _json(_response('01', $this->uri));
=======
            _json(_response('01', site_url($this->uri_mod)));
>>>>>>> repoB/main
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan transaksi.']);
        }
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $w);
<<<<<<< HEAD
        _json(_response('03', $this->uri));
=======
        _json(_response('03', site_url($this->uri_mod)));
>>>>>>> repoB/main
    }

    public function ajax_datatables()
    {
        $this->m_asset_masuk->load_datatables();
    }

<<<<<<< HEAD
    public function get_no_transaksi_ajax()
    {
        $tgl_transaksi = $this->input->post('tanggal');
        $asset_id      = $this->input->post('asset_id');

        if (empty($tgl_transaksi) || empty($asset_id)) {
            echo json_encode(['status' => false, 'transaksi_no' => '']);
            return;
        }

        $seq_part = $this->m_asset_masuk->get_auto_number($tgl_transaksi);
        $sku_part = $this->m_asset_masuk->get_sku_by_asset_id($asset_id);

        if ($sku_part) {
            $final_no = $seq_part . '/' . $sku_part;
            echo json_encode(['status' => true, 'transaksi_no' => $final_no]);
        } else {
            echo json_encode(['status' => false, 'transaksi_no' => 'Error: SKU not found']);
        }
    }

    // [BARU] API Ambil Asset berdasarkan Kategori
=======
>>>>>>> repoB/main
    public function get_list_asset_by_kategori()
    {
        $kategori_id = $this->input->post('kategori_id');
        $data = $this->m_asset_masuk->get_assets_by_kategori_id($kategori_id);
        echo json_encode($data);
    }

<<<<<<< HEAD
    // [BARU] API Ambil Form Dinamis
    public function get_form_dinamis_by_kategori()
    {
        $kategori_kd = $this->input->post('kategori_kd');
        
        // Cari ID Kategori
        $kategori = $this->db->get_where('mst_kategori', ['kategori_kd' => $kategori_kd])->row();
        if (!$kategori) {
            echo json_encode(['html' => '']); return;
        }

        // Ambil atribut 'Ruangan' dan 'Lantai'
=======
    public function get_form_dinamis_by_kategori()
    {
        $kategori_kd = $this->input->post('kategori_kd');
        $kategori = $this->db->get_where('mst_kategori', ['kategori_kd' => $kategori_kd])->row();
        if (!$kategori) { echo json_encode(['html' => '']); return; }

>>>>>>> repoB/main
        $list_atribut = $this->db->where('kategori_id', $kategori->kategori_id)
                                 ->where_in('atribut_label', ['Ruangan', 'Lantai'])
                                 ->where('deleted_st', 0)
                                 ->get('mst_kategori_atribut')->result_array();
        
<<<<<<< HEAD
        if (empty($list_atribut)) {
            echo json_encode(['html' => '']); return;
        }

        $d['list_atribut'] = $list_atribut;
        $html = $this->load->view($this->template . '_ajax_form_dinamis', $d, TRUE);
        
        echo json_encode(['html' => $html]);
    }
=======
        if (empty($list_atribut)) { echo json_encode(['html' => '']); return; }

        $d['list_atribut'] = $list_atribut;
        $html = $this->load->view($this->template . '_ajax_form_dinamis', $d, TRUE);
        echo json_encode(['html' => $html]);
    }

    // [HELPER KONSISTEN UNTUK TANGGAL]
    private function _convert_date($date_raw)
    {
        if (empty($date_raw)) return date('Y-m-d');

        // Cek format dd-mm-yyyy (dash)
        if (strpos($date_raw, '-') !== false) {
            $parts = explode('-', $date_raw);
            // Jika format 31-12-2025
            if (count($parts) == 3 && strlen($parts[2]) == 4) {
                return date('Y-m-d', strtotime($date_raw));
            }
        }
        return $date_raw;
    }
>>>>>>> repoB/main
}