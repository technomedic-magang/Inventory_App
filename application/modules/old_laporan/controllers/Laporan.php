<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class Laporan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['laporan/m_laporan']); 
        $this->template = '../views/laporan/'; 
    }

    public function index()
    {
        $d['list_gudang']   = $this->db->where('deleted_st', 0)->get('mst_gudang')->result_array();
        $d['list_kategori'] = $this->db->where('deleted_st', 0)->get('mst_kategori')->result_array();
        $this->render($this->template . 'index', $d);
    }

    public function preview_stok()
    {
        $gudang_id   = $this->input->post('gudang_id');
        $kategori_id = $this->input->post('kategori_id');
        
        // --- TAMBAHAN: Tangkap Token N ---
        $token_n     = $this->input->post('n');
        // ---------------------------------

        $data['laporan'] = $this->m_laporan->get_laporan_stok($gudang_id, $kategori_id);
        $data['periode'] = date('d F Y H:i');
        
        // Oper filter DAN token ke view
        $data['filter_gudang_id'] = $gudang_id;
        $data['filter_kategori_id'] = $kategori_id;
        $data['token_n'] = $token_n; // <-- KIRIM TOKEN KE VIEW
        
        if(!empty($gudang_id)) {
            $gdg = $this->db->get_where('mst_gudang', ['gudang_id' => $gudang_id])->row_array();
            $data['filter_gudang'] = $gdg['gudang_nm'];
        }
        $this->load->database();
        $q = $this->m_laporan->get_laporan_stok($gudang_id, $kategori_id);
        log_message('debug', 'SQL LAST: ' . $this->db->last_query());
        log_message('debug', 'RESULT COUNT: ' . count($q));


        $this->render($this->template . 'cetak_stok', $data, true);
    }

    public function cetak_pdf()
    {
        // Ambil token dari GET
        $token_n = $this->input->get('n');
        // (Opsional) Validasi token ini jika perlu
        if(empty($token_n)) {
            echo "Akses ditolak. Token keamanan tidak valid.";
            return;
        }

        $gudang_id   = $this->input->get('gudang_id');
        $kategori_id = $this->input->get('kategori_id');

        $data['laporan'] = $this->m_laporan->get_laporan_stok($gudang_id, $kategori_id);
        $data['periode'] = date('d F Y H:i');
        $data['filter_gudang_id'] = $gudang_id;
        $data['filter_kategori_id'] = $kategori_id;
        $data['token_n'] = $token_n; // Kirim juga ke view (meski tdk dipakai)
        
        if(!empty($gudang_id)) {
            $gdg = $this->db->get_where('mst_gudang', ['gudang_id' => $gudang_id])->row_array();
            $data['filter_gudang'] = $gdg['gudang_nm'];
        }

        $html = $this->render($this->template . 'cetak_stok', $data, true, true);
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Laporan_Stok.pdf", array("Attachment" => 1)); // Download paksa
    }
}