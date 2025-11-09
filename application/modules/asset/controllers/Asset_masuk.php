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

        // Jika sedang Tambah Baru ($id == null), kita buatkan nomor preview
    if ($id == null) {
        // Gunakan tanggal hari ini sebagai dasar preview nomor
        $d['preview_no'] = $this->m_asset_masuk->get_auto_number(date('Y-m-d'));
    }

        // Ambil data untuk dropdown di form
        $d['list_gudang'] = $this->db->where(['deleted_st' => 0, 'active_st' => 1])->get('mst_gudang')->result_array();
        // Ambil data asset beserta satuannya untuk tampilan yang lebih informatif
        $d['list_asset'] = $this->db->select('a.*, s.satuan_nm')
                                    ->from('mst_asset a')
                                    ->join('mst_satuan s', 'a.satuan_id = s.satuan_id', 'left')
                                    ->where(['a.deleted_st' => 0, 'a.active_st' => 1])
                                    ->get()->result_array();

        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        if ($id != null) {
            echo json_encode(['status' => '00', 'msg' => 'Edit transaksi belum didukung.']);
            return;
        }

        // 1. Ambil Tanggal yang dipilih user
        $tgl_transaksi = $this->input->post('transaksi_tgl');

        // 2. GENERATE NOMOR OTOMATIS (Panggil mesin di Model)
        $auto_no = $this->m_asset_masuk->get_auto_number($tgl_transaksi);

        // 3. Siapkan Data Header (Pakai nomor otomatis tadi)
        $data_header = [
            'gudang_id'     => $this->input->post('gudang_id'),
            'transaksi_tgl' => $tgl_transaksi,
            'transaksi_no'  => $auto_no, // <-- PAKAI VARIABEL AUTO_NO
            'transaksi_ket' => $this->input->post('transaksi_ket'),
            'active_st'     => 1,
            'deleted_st'    => 0
        ];

        // 4. Siapkan Data Detail
        $data_detail = [
            'asset_id'   => $this->input->post('asset_id'),
            'asset_qty'  => $this->input->post('asset_qty'),
            'detail_ket' => $this->input->post('detail_ket')
        ];

        // 5. Eksekusi
        if ($this->m_asset_masuk->simpan_transaksi($data_header, $data_detail)) {
            _json(_response('01', $this->uri));
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan transaksi.']);
        }
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        // Soft delete header saja, detailnya biarkan (atau bisa ikut dihapus jika mau)
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', $this->uri));
    }

    public function ajax_datatables()
    {
        $this->m_asset_masuk->load_datatables();
    }

    // --- API AJAX UNTUK GENERATE NOMOR DINAMIS ---
    public function get_no_transaksi_ajax()
    {
        // Ambil tanggal yang dikirim oleh Javascript
        $tgl = $this->input->post('tanggal');

        // Panggil mesin generator di Model
        $new_no = $this->m_asset_masuk->get_auto_number($tgl);

        // Kirim balik hasilnya ke Javascript
        echo json_encode(['new_no' => $new_no]);
    }
}