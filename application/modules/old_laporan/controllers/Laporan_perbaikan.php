<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_perbaikan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Model Baru
        _models(['laporan/m_laporan_perbaikan']);
        
        // Sesuaikan Folder View
        $this->template = 'laporan/laporan_perbaikan/';
        $this->uri      = 'laporan/laporan_perbaikan';
    }

    public function index()
    {
        // Default Filter: Bulan Ini
        $start = $this->input->get('start') ?? date('Y-m-01');
        $end   = $this->input->get('end') ?? date('Y-m-d');

        // Jika tombol filter ditekan
        if ($this->input->get('filter')) {
            $data['list_data'] = $this->m_laporan_perbaikan->get_report($start, $end);
        } else {
            $data['list_data'] = []; 
        }

        $data['start_date'] = $start;
        $data['end_date']   = $end;

        $this->title = 'Laporan Perbaikan Asset';
        $this->render($this->template . 'index', $data);
    }

    public function cetak()
    {
        $start = $this->input->get('start');
        $end   = $this->input->get('end');
        
        $data['list_data']  = $this->m_laporan_perbaikan->get_report($start, $end);
        $data['periode']    = date('d M Y', strtotime($start)) . ' s/d ' . date('d M Y', strtotime($end));
        
        $this->load->view($this->template . 'cetak', $data);
    }
}