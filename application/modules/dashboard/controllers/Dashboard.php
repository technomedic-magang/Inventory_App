<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // PATH MODEL FOLDER DASHBOARD
        _models(['dashboard/m_dashboard']);

        // PATH VIEW FOLDER DASHBOARD
        $this->template = 'dashboard/dashboard/';
    }

    public function index()
    {
        // data view
        $d['total_types']   = $this->m_dashboard->count_total_asset_types();
        $d['total_items']   = $this->m_dashboard->sum_total_stok();
        $d['total_borrowed']= $this->m_dashboard->sum_sedang_dipakai();
        $d['low_stock']     = $this->m_dashboard->get_low_stock_items();
        $d['recent_trx']    = $this->m_dashboard->get_recent_activities();

        $this->render($this->template . 'index', $d);
    }
}