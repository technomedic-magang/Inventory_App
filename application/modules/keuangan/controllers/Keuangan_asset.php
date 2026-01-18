<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan_asset extends MY_Controller
{
    protected $view_path = 'keuangan/keuangan_asset/';
    protected $uri_path  = 'keuangan/keuangan_asset';

    public function __construct()
    {
        parent::__construct();
        _models(['keuangan/m_keuangan_asset']);
        
        $this->model = $this->m_keuangan_asset;
        $this->uri = site_url($this->uri_path); // Standard Full URL
    }

    public function index()
    {
        $periode_sekarang = date('Y-m');
        
        // Cek status periode
        $cek_closed = $this->db->select('nilai_id')
                               ->get_where('log_asset_nilai', [
                                   'periode_kd' => $periode_sekarang, 
                                   'deleted_st' => 0
                               ])->row();

        $data['is_closed']        = ($cek_closed != null);
        $data['periode_sekarang'] = $periode_sekarang; 
        $data['periode_text']     = date('F Y');       

        $data['list_kategori'] = $this->db->where('deleted_st', 0)
                                          ->order_by('kategori_nm', 'ASC')
                                          ->get('mst_kategori')
                                          ->result_array();

        // Ambil summary untuk widget atas
        $kalkulasi = $this->model->get_live_data(); 
        $data['summary'] = $kalkulasi['summary'];

        $this->render($this->view_path . 'index', $data);
    }

    public function ajax_datatables()
    {
        $filter_kategori = $this->input->post('filter_kategori');
        $result = $this->model->get_live_data($filter_kategori);
        
        echo json_encode([
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => count($result['data']),
            "recordsFiltered" => count($result['data']),
            "data" => $result['data']
        ]);
    }

    // [BARU] Modal View Detail Aset
    public function form_modal_view($id = null)
    {
        if (empty($id)) {
            echo '<div class="alert alert-danger">ID Aset tidak ditemukan.</div>';
            return;
        }

        // Ambil data detail + kalkulasi dari Model
        $data['main'] = $this->model->get_detail_asset($id);
        
        if (!$data['main']) {
            echo '<div class="alert alert-warning">Data Aset tidak ditemukan.</div>';
            return;
        }

        $this->render($this->view_path . 'form_modal_view', $data);
    }

    public function form_modal_tutup_buku()
    {
        $periode = date('Y-m');
        $cek = $this->db->get_where('log_asset_nilai', ['periode_kd' => $periode, 'deleted_st' => 0])->row();
        
        if($cek) {
            echo '<div class="alert alert-danger">Periode '.$periode.' sudah ditutup!</div>';
            return;
        }

        $kalkulasi = $this->model->get_live_data(); 
        
        $d['summary']      = $kalkulasi['summary'];
        $d['total_asset']  = count($kalkulasi['data']);
        $d['periode']      = $periode;
        $d['periode_text'] = date('F Y');
        $d['form_act']     = $this->uri . '/tutup_buku_process';

        $this->render($this->view_path . 'form_modal_tutup_buku', $d);
    }

    public function tutup_buku_process()
    {
        $periode = $this->input->post('periode_kd');
        if (empty($periode)) $periode = date('Y-m');

        $res = $this->model->proses_tutup_buku($periode);
        
        if ($res['status']) {
            _json(_response('01', $this->uri));
        } else {
            _json(['status' => false, 'msg' => $res['msg']]);
        }
    }
}