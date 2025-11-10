<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asset_keluar extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['asset/m_asset_keluar']);
        $this->table = $this->m_asset_keluar->table;
        $this->pk_id = $this->m_asset_keluar->pk_id;
        $this->template = 'asset/asset_keluar/';
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = $this->uri . '/save/' . $id;

        if ($id == null) {
            // Generate nomor preview berdasarkan tanggal hari ini
            $d['preview_no'] = $this->m_asset_keluar->get_auto_number(date('Y-m-d'));
        }

        // Dropdown Gudang (Sumber Barang)
        $d['list_gudang'] = $this->db->where(['deleted_st' => 0, 'active_st' => 1])->get('mst_gudang')->result_array();
        // Dropdown Asset
        $d['list_asset']  = $this->db->select('a.*, s.satuan_nm')
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

        $tgl = $this->input->post('transaksi_tgl');
        $auto_no = $this->m_asset_keluar->get_auto_number($tgl);

        $data_header = [
            'gudang_id'     => $this->input->post('gudang_id'),
            'transaksi_tgl' => $tgl,
            'transaksi_no'  => $auto_no,
            'keluar_jns'    => $this->input->post('keluar_jns'), // Jenis Keluar
            'transaksi_ket' => $this->input->post('transaksi_ket'),
            'active_st'     => 1,
            'deleted_st'    => 0
        ];

        $data_detail = [
            'asset_id'   => $this->input->post('asset_id'),
            'asset_qty'  => $this->input->post('asset_qty'),
            'detail_ket' => $this->input->post('detail_ket')
        ];

        if ($this->m_asset_keluar->simpan_transaksi($data_header, $data_detail)) {
            _json(_response('01', $this->uri));
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan. Cek stok atau nomor transaksi.']);
        }
    }

    public function delete($id = null)
    {
        // Hati-hati: Menghapus transaksi keluar seharusnya MENGEMBALIKAN stok.
        // Untuk sekarang kita soft-delete saja tanpa pengembalian stok (agar sederhana).
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', $this->uri));
    }

    public function ajax_datatables()
    {
        $this->m_asset_keluar->load_datatables();
    }

    public function get_no_transaksi_ajax()
    {
        $tgl = $this->input->post('tanggal');
        echo json_encode(['new_no' => $this->m_asset_keluar->get_auto_number($tgl)]);
    }

    // Tambahkan fungsi ini di paling bawah controller
    public function get_assets_by_gudang()
    {
        $gudang_id = $this->input->post('gudang_id');
        if (empty($gudang_id)) {
            echo json_encode([]);
            return;
        }
        
        $data = $this->m_asset_keluar->get_assets_available($gudang_id);
        echo json_encode($data);
    }
}