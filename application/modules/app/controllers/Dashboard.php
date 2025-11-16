<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['app/m_dashboard']);
        $this->template = 'app/dashboard/';
    }

    public function index()
    {
        // 1. Data Umum
        $d['tahun']     = date('Y');
        $d['bulan']     = date('m');
        $d['tgl_awal']  = date('Y-m-01');
        $d['tgl_total'] = date('t', strtotime($d['tgl_awal']));

        // 2. Data Pegawai
        $d['pegawai'] = $this->m_dashboard->pegawai_get();

        // 3. Data Dashboard Inventaris
        $d['total_types']    = $this->m_dashboard->count_total_asset_types();
        $d['total_items']    = $this->m_dashboard->sum_total_stok();
        $d['total_borrowed'] = $this->m_dashboard->sum_sedang_dipakai();
        $d['low_stock']      = $this->m_dashboard->get_low_stock_items();
        $d['recent_trx']     = $this->m_dashboard->get_recent_activities();

        $this->render($this->template . 'index_pegawai', $d);
    }
}