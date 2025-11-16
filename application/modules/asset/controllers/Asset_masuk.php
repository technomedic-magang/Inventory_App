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
        
        // --- [PERBAIKAN LOGIKA DROPDOWN ASET] ---
        // Hanya tampilkan aset yang BELUM PERNAH ada di tabel trx_masuk_detail
        
        // 1. Ambil semua ID aset yang sudah pernah masuk (dan transaksinya aktif)
        $subquery = $this->db->select('asset_id')
                             ->from('trx_masuk_detail')
                             ->get_compiled_select();

        // 2. Ambil data Master Aset yang ID-nya TIDAK ADA di subquery tadi
        $this->db->select('a.asset_id, a.asset_kd, a.asset_nm');
        $this->db->from('mst_asset a');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id', 'left');
        $this->db->where('a.deleted_st', 0);
        $this->db->where('k.kategori_tipe', 'ASET'); // Hanya tipe ASET
        
        // Filter Kunci: Aset ID tidak boleh ada di daftar yang sudah masuk
        $this->db->where("a.asset_id NOT IN ($subquery)", NULL, FALSE);
        
        $d['list_asset'] = $this->db->get()->result_array();
        // ----------------------------------------

        $this->render($this->template . 'form_modal', $d);
    }
    
    public function save($id = null)
    {
        if ($id != null) {
            echo json_encode(['status' => '00', 'msg' => 'Edit transaksi belum didukung.']);
            return;
        }

        // [REVISI] Ambil semua data yang dibutuhkan
        $tgl_transaksi = $this->input->post('transaksi_tgl');
        $asset_id      = $this->input->post('asset_id');
        $detail_ket    = $this->input->post('detail_ket');

        if (empty($asset_id) || empty($tgl_transaksi)) {
             echo json_encode(['status' => '00', 'msg' => 'Gagal, Tanggal dan Aset wajib diisi.']);
             return;
        }

        // [REVISI] Generate nomor transaksi final di server
        // 1. Dapatkan nomor urut (cth: IN/202511/001)
        $seq_part = $this->m_asset_masuk->get_auto_number($tgl_transaksi);
        // 2. Dapatkan SKU (cth: ITM-K2-MT-2014.10.001)
        $sku_part = $this->m_asset_masuk->get_sku_by_asset_id($asset_id);

        if (!$sku_part) {
             echo json_encode(['status' => '00', 'msg' => 'Gagal, SKU Aset tidak ditemukan.']);
             return;
        }
        
        // 3. Gabungkan
        $final_transaksi_no = $seq_part . '/' . $sku_part;

        $data_header = [
            'gudang_id'     => $this->input->post('gudang_id'),
            'transaksi_tgl' => $tgl_transaksi,
            'transaksi_no'  => $final_transaksi_no, // <-- Nomor Baru
            'transaksi_ket' => $this->input->post('transaksi_ket'),
            'active_st'     => 1,
            'deleted_st'    => 0,
            'created_by'    => 'PEGAWAI TESTER'
        ];
        
        if ($this->m_asset_masuk->simpan_transaksi_aset($data_header, $asset_id, $detail_ket)) {
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

    // [REVISI] API AJAX sekarang butuh 2 parameter: Tanggal dan Asset
    public function get_no_transaksi_ajax()
    {
        $tgl_transaksi = $this->input->post('tanggal');
        $asset_id      = $this->input->post('asset_id');

        // Jika salah satu kosong, jangan generate
        if (empty($tgl_transaksi) || empty($asset_id)) {
            echo json_encode(['status' => false, 'transaksi_no' => '']);
            return;
        }

        // 1. Get sequential part
        $seq_part = $this->m_asset_masuk->get_auto_number($tgl_transaksi);
        // 2. Get SKU part
        $sku_part = $this->m_asset_masuk->get_sku_by_asset_id($asset_id);

        if ($sku_part) {
            $final_no = $seq_part . '/' . $sku_part;
            echo json_encode(['status' => true, 'transaksi_no' => $final_no]);
        } else {
            echo json_encode(['status' => false, 'transaksi_no' => 'Error: SKU not found']);
        }
    }
}