<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan_asset extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Memuat model khusus untuk modul ini
        _models(['keuangan/m_keuangan_asset']);
        
        // Inisialisasi variabel properti dari model
        $this->table     = $this->m_keuangan_asset->table;
        $this->pk_id     = $this->m_keuangan_asset->pk_id;
        $this->template  = 'keuangan/keuangan/';
        $this->uri_mod   = 'keuangan/keuangan_asset';
    }

    /**
     * Menampilkan halaman utama modul Keuangan Aset.
     */
    public function index()
    {
        // Mengambil daftar kategori untuk filter dropdown
        $d['list_kategori'] = $this->db->where('deleted_st', 0)
                                       ->order_by('kategori_nm', 'ASC')
                                       ->get('mst_kategori')
                                       ->result_array();
        
        // Mengambil data ringkasan total aset
        $d['summary'] = $this->m_keuangan_asset->get_summary_total(); 
        
        // Data periode saat ini dan status tutup buku
        $d['periode_sekarang'] = date('Y-m');
        $d['is_closed'] = $this->m_keuangan_asset->cek_tutup_buku(date('Y-m'));

        // Render view utama
        $this->render($this->template . 'index', $d);
    }

    /**
     * Endpoint AJAX untuk memuat data tabel aset (Server Side).
     */
    public function ajax_datatables()
    {
        $this->m_keuangan_asset->load_datatables();
    }

    /**
     * Menampilkan modal form untuk tambah/edit data aset.
     */
    public function form_modal()
    {
        $id = $this->input->get('id');
        
        // URL action untuk form
        $d['form_act'] = site_url($this->uri_mod . '/save_setting');
        
        // Jika ada ID, ambil data untuk edit. Jika tidak, data kosong (tambah baru).
        $d['data'] = ($id) ? DB::get($this->table, [$this->pk_id => $id]) : [];
        
        // Load view modal
        $this->load->view($this->template . 'form_modal', $d);
    }

    /**
     * Menyimpan data dari form modal ke database.
     */
    public function save_setting()
    {
        $d = _post();
        
        // Membersihkan format angka (menghapus titik ribuan)
        $nominal = str_replace('.', '', $d['beli_nominal']);
        $residu  = str_replace('.', '', $d['residu_nominal']);

        // Validasi input negatif
        if ($nominal < 0 || $residu < 0) {
            _json(_response('00', null, 'Nominal tidak boleh minus!')); 
            return;
        }

        $data_update = [
            'beli_nominal'   => $nominal,
            'beli_tgl'       => $d['beli_tgl'],
            'pakai_masa_bln' => $d['pakai_masa_bln'],
            'residu_nominal' => $residu,
            'valuasi_metode' => $d['valuasi_metode'],
            'updated_at'     => date('Y-m-d H:i:s'),
            'updated_by'     => $this->session->userdata('user_id')
        ];

        // Update data di database
        DB::update($this->table, $data_update, [$this->pk_id => $d['asset_id']]);
        
        // Kirim respon sukses
        _json(_response('01', null, 'Berhasil disimpan.'));
    }

    /**
     * Menghapus data aset (Soft Delete).
     */
    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        // Set deleted_st = 1 untuk soft delete
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $w);
        
        // Kirim respon sukses dan refresh tabel
        _json(_response('03', site_url($this->uri_mod)));
    }

    /**
     * Memproses tutup buku bulanan.
     */
    public function proses_tutup_buku()
    {
        $periode = date('Y-m');
        
        // Cek apakah sudah pernah tutup buku di periode ini
        if ($this->m_keuangan_asset->cek_tutup_buku($periode)) {
            _json(_response('00', null, 'Periode ini sudah ditutup!')); 
            return;
        }
        
        // Eksekusi tutup buku
        $this->m_keuangan_asset->eksekusi_tutup_buku($periode);
        
        // Kirim respon sukses
        _json(_response('01', site_url($this->uri_mod)));
    }
}