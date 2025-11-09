<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['laporan/m_laporan']); // Load model khusus laporan
        $this->template = 'laporan/';
    }

    // Halaman Utama: Pilih Jenis Laporan & Filter
    public function index()
    {
        // Ambil data untuk filter dropdown
        $d['list_gudang']   = $this->db->where('deleted_st', 0)->get('mst_gudang')->result_array();
        $d['list_kategori'] = $this->db->where('deleted_st', 0)->get('mst_kategori')->result_array();

        $this->render($this->template . 'laporan/index', $d);
    }

    // Proses Cetak Laporan Stok
    public function cetak_stok()
    {
        $gudang_id   = $this->input->get('gudang_id');
        $kategori_id = $this->input->get('kategori_id');

        $data['laporan'] = $this->m_laporan->get_laporan_stok($gudang_id, $kategori_id);
        $data['periode'] = date('d F Y H:i'); // Waktu cetak
        
        // Info filter untuk judul laporan
        if($gudang_id) {
            $gdg = $this->db->get_where('mst_gudang', ['gudang_id' => $gudang_id])->row_array();
            $data['filter_gudang'] = $gdg['gudang_nm'];
        }

        // Load view khusus cetak (tanpa header/sidebar template utama)
        $this->load->view($this->template . 'cetak_stok', $data);
    }
}