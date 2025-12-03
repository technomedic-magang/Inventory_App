<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyesuaian_kondisi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['asset/m_penyesuaian_kondisi']);
        $this->table = $this->m_penyesuaian_kondisi->table;
        $this->pk_id = $this->m_penyesuaian_kondisi->pk_id;
        $this->template = 'asset/penyesuaian_kondisi/';
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = $this->uri . '/save/'; 

        if ($id == null) {
            $d['preview_no'] = $this->m_penyesuaian_kondisi->get_auto_number(date('Y-m-d'));
        }

        // [REVISI LOGIKA 1]
        // Hanya ambil aset yang STOK-nya ADA di gudang (qty > 0)
        // Artinya barang tidak sedang dipinjam.
        $d['list_asset'] = $this->db->select('a.asset_id, a.asset_kd, a.asset_nm, a.asset_kondisi, g.gudang_nm')
                                    ->from('mst_asset a')
                                    ->join('dat_stok s', 'a.asset_id = s.asset_id') // Join ke stok
                                    ->join('mst_gudang g', 's.gudang_id = g.gudang_id')
                                    ->where('a.deleted_st', 0)
                                    ->where('s.stok_qty >', 0) // KUNCI: Stok harus ada
                                    ->get()->result_array();

        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $asset_id   = $this->input->post('asset_id');
        $kondisi_ke = $this->input->post('kondisi_ke');
        $tgl        = $this->input->post('transaksi_tgl');

        // 1. Validasi Aset
        $aset = $this->db->select('asset_kondisi')->where('asset_id', $asset_id)->get('mst_asset')->row();
        if (!$aset) {
            echo json_encode(['status' => '00', 'msg' => 'Aset tidak ditemukan.']);
            return;
        }

        // 2. Generate Nomor Final (Server Side)
        $auto_no = $this->m_penyesuaian_kondisi->get_auto_number($tgl);

        $data_log = [
            'transaksi_no'  => $auto_no,
            'asset_id'      => $asset_id,
            'transaksi_tgl' => $tgl,
            'kondisi_dari'  => $aset->asset_kondisi, // Ambil kondisi saat ini
            'kondisi_ke'    => $kondisi_ke,
            'transaksi_ket' => $this->input->post('transaksi_ket'),
            'created_by'    => 'PEGAWAI TESTER',
            'deleted_st'    => 0,
            'active_st'     => 1
        ];

        if ($this->m_penyesuaian_kondisi->simpan_penyesuaian($data_log, $asset_id, $kondisi_ke)) {
            _json(_response('01', $this->uri));
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan data.']);
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
        $this->m_penyesuaian_kondisi->load_datatables();
    }

    // API AJAX untuk Preview Nomor
    public function get_no_transaksi_ajax()
    {
        $tgl = $this->input->post('tanggal');
        $new_no = $this->m_penyesuaian_kondisi->get_auto_number($tgl);
        echo json_encode(['new_no' => $new_no]);
    }
}