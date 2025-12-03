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
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null)
    { 
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = $this->uri . '/save/' . $id;

        // Data Gudang
        $d['list_gudang'] = $this->db->where(['deleted_st' => 0, 'active_st' => 1])
                                     ->get('mst_gudang')->result_array();
        
        // [BARU] Ambil List Kategori untuk Filter
        $d['list_kategori'] = $this->db->where(['deleted_st' => 0, 'active_st' => 1, 'kategori_tipe' => 'ASET'])
                                       ->order_by('kategori_nm', 'ASC')
                                       ->get('mst_kategori')->result_array();

        // [UBAH] List Asset dikosongkan (User wajib pilih kategori dulu)
        $d['list_asset'] = [];

        $this->render($this->template . 'form_modal', $d);
    }
    
    public function save($id = null)
    {
        if ($id != null) {
            echo json_encode(['status' => '00', 'msg' => 'Edit transaksi belum didukung.']);
            return;
        }

        $tgl_transaksi = $this->input->post('transaksi_tgl');
        $asset_id      = $this->input->post('asset_id');
        $detail_ket    = $this->input->post('detail_ket');

        if (empty($asset_id) || empty($tgl_transaksi)) {
             echo json_encode(['status' => '00', 'msg' => 'Gagal, Tanggal dan Aset wajib diisi.']);
             return;
        }

        $seq_part = $this->m_asset_masuk->get_auto_number($tgl_transaksi);
        $sku_part = $this->m_asset_masuk->get_sku_by_asset_id($asset_id);

        if (!$sku_part) {
             echo json_encode(['status' => '00', 'msg' => 'Gagal, SKU Aset tidak ditemukan.']);
             return;
        }
        
        $final_transaksi_no = $seq_part . '/' . $sku_part;

        $data_header = [
            'gudang_id'     => $this->input->post('gudang_id'),
            'transaksi_tgl' => $tgl_transaksi,
            'transaksi_no'  => $final_transaksi_no,
            'transaksi_ket' => $this->input->post('transaksi_ket'),
            'active_st'     => 1,
            'deleted_st'    => 0,
            'created_by'    => 'PEGAWAI TESTER'
        ];
        
        $this->db->trans_start();
        
        // 1. Simpan Transaksi
        $this->m_asset_masuk->simpan_transaksi_aset($data_header, $asset_id, $detail_ket);

        // 2. Simpan Atribut Kustom (Ruangan/Lantai)
        $data_kustom = $this->input->post('kustom') ?? [];
        if (!empty($data_kustom)) {
            foreach ($data_kustom as $atribut_id => $isi_value) {
                if (!empty($isi_value)) {
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
                            'created_by' => 'SYSTEM-ASSET-MASUK'
                        ]);
                    }
                }
            }
        }
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            _json(_response('01', $this->uri));
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan transaksi.']);
        }
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', $this->uri));
    }

    public function ajax_datatables()
    {
        $this->m_asset_masuk->load_datatables();
    }

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
    public function get_list_asset_by_kategori()
    {
        $kategori_id = $this->input->post('kategori_id');
        $data = $this->m_asset_masuk->get_assets_by_kategori_id($kategori_id);
        echo json_encode($data);
    }

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
        $list_atribut = $this->db->where('kategori_id', $kategori->kategori_id)
                                 ->where_in('atribut_label', ['Ruangan', 'Lantai'])
                                 ->where('deleted_st', 0)
                                 ->get('mst_kategori_atribut')->result_array();
        
        if (empty($list_atribut)) {
            echo json_encode(['html' => '']); return;
        }

        $d['list_atribut'] = $list_atribut;
        $html = $this->load->view($this->template . '_ajax_form_dinamis', $d, TRUE);
        
        echo json_encode(['html' => $html]);
    }
}