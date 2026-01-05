<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan_asset extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model dengan nama yang sesuai file
        _models(['keuangan/m_keuangan_asset']);
        
        $this->template = 'keuangan/keuangan_asset/'; 
        $this->uri_mod  = 'keuangan/keuangan_asset';
    }

    public function index()
    {
        $periode_sekarang = date('Y-m');
        
        $cek_closed = $this->db->select('nilai_id')
                               ->get_where('log_asset_nilai', [
                                   'periode_kd' => $periode_sekarang, 
                                   'deleted_st' => 0
                               ])->row();

        $d['is_closed']        = ($cek_closed != null);
        $d['periode_sekarang'] = $periode_sekarang; 
        $d['periode_text']     = date('F Y');       

        $d['list_kategori'] = $this->db->where('deleted_st', 0)
                                       ->get('mst_kategori')
                                       ->result_array();

        $kalkulasi = $this->m_keuangan_asset->get_live_data(); 
        $d['summary'] = $kalkulasi['summary'];

        $this->render($this->template . 'index', $d);
    }

    public function ajax_datatables()
    {
        $filter_kategori = $this->input->post('filter_kategori');
        
        $result = $this->m_keuangan_asset->get_live_data($filter_kategori);
        $list_data = $result['data'];

        $data = [];
        $no = 1;

        foreach ($list_data as $r) {
            $row = [];
            $row[] = $no++;
            $row[] = '-'; // Aksi Read Only
            $row[] = '<div class="fw-bold text-dark">'.$r['asset_kd'].'</div>';
            $row[] = date('d-m-Y', strtotime($r['beli_tgl']));
            
            $umur_jalan = $r['calc_umur_jalan'];
            $masa_total = $r['pakai_masa_bln'];
            $persen = ($masa_total > 0) ? round(($umur_jalan / $masa_total) * 100) : 0;
            if ($persen > 100) $persen = 100;
            
            $bar_color = ($persen >= 100) ? 'bg-purple' : 'bg-blue';
            $row[] = '<div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span>'.$umur_jalan.' / '.$masa_total.' Bln</span>
                            <span>'.$persen.'%</span>
                        </div>
                        <div class="progress progress-xs">
                            <div class="progress-bar '.$bar_color.'" style="width: '.$persen.'%"></div>
                        </div>
                      </div>';
            
            $row[] = 'Rp ' . number_format($r['beli_nominal'], 0, ',', '.');
            $row[] = '<div class="text-center"><span class="badge bg-secondary-lt text-uppercase" style="font-size:10px">'.$r['depresiasi_metode'].'</span></div>';
            
            $val_buku = $r['calc_nilai_buku'];
            $row[] = '<div class="text-end fw-bold text-green">Rp ' . number_format($val_buku, 0, ',', '.') . '</div>';
            
            if ($r['calc_status'] == 'HABIS') {
                $row[] = '<div class="text-center"><span class="badge bg-purple-lt">Habis Susut</span></div>';
            } else {
                $row[] = '<div class="text-center"><span class="badge bg-yellow-lt">Aktif</span></div>';
            }

            $data[] = $row;
        }

        echo json_encode([
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        ]);
    }

    // [FIX UTAMA] Menggunakan $this->render agar modal muncul di UI
    public function form_modal_tutup_buku()
    {
        $periode = date('Y-m');
        
        $cek = $this->db->get_where('log_asset_nilai', ['periode_kd' => $periode, 'deleted_st' => 0])->row();
        if($cek) {
            echo '<div class="alert alert-danger">Periode '.$periode.' sudah ditutup!</div>';
            return;
        }

        $kalkulasi = $this->m_keuangan_asset->get_live_data(); 
        
        $d['summary']      = $kalkulasi['summary'];
        $d['total_asset']  = count($kalkulasi['data']);
        $d['periode']      = $periode;
        $d['periode_text'] = date('F Y');
        
        $d['form_act'] = site_url($this->uri_mod . '/tutup_buku_process');

        // Gunakan render, bukan load->view
        $this->render($this->template . 'form_modal_tutup_buku', $d);
    }

    public function tutup_buku_process()
    {
        $periode = $this->input->post('periode_kd');
        if (empty($periode)) $periode = date('Y-m');

        $res = $this->m_keuangan_asset->proses_tutup_buku($periode);
        
        // Gunakan helper standar _json & _response
        if ($res['status']) {
            _json(_response('01', site_url($this->uri_mod)));
        } else {
            _json(['status' => false, 'msg' => $res['msg']]);
        }
    }

    // ... code sebelumnya ...

    // [BARU] Proses Buka Buku Kembali
    public function buka_buku_process()
    {
        $periode = $this->input->post('periode_kd');
        if (empty($periode)) $periode = date('Y-m');

        $res = $this->m_keuangan_asset->proses_buka_buku($periode);
        
        if ($res['status']) {
            // Reload halaman setelah sukses
            _json(_response('01', site_url($this->uri_mod)));
        } else {
            _json(['status' => false, 'msg' => $res['msg']]);
        }
    }

}