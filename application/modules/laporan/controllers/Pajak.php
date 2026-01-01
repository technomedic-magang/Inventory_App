<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pajak extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['laporan/m_pajak']); 
        
        $this->table = $this->m_pajak->table;
        $this->pk_id = $this->m_pajak->pk_id;
        $this->template = 'laporan/pajak/'; 
        $this->uri_mod = 'laporan/pajak'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        $this->m_pajak->load_datatables();
    }

    // --- [PERBAIKAN UTAMA DISINI] ---
    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = site_url($this->uri_mod . '/save/' . $id);

        if ($id == null) {
            $d['preview_no'] = $this->m_pajak->get_auto_number(date('Y-m-d'));
        }

        // Ambil list aset aktif DENGAN JOIN ATRIBUT (Adaptasi dari M_kembali)
        $this->db->select('a.asset_id, a.asset_nm, a.asset_kd, a.tgl_pajak_tahunan, a.tgl_pajak_plat, k.kategori_nm');
        
        // Ambil Nopol dari tabel value (menggunakan alias nopol_asli agar tidak tertukar)
        $this->db->select('v_nopol.value_isi as nopol_asli');

        $this->db->from('mst_asset a');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id');

        // --- ADAPTASI DARI PROGRAM KEMBALI ---
        // Cari atribut yang labelnya mengandung kata 'Polisi' (misal: No. Polisi / Nomor Polisi)
        $this->db->join('mst_kategori_atribut attr_nopol', "attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'", 'left');
        // Ambil isinya dari tabel dat_asset_value
        $this->db->join('dat_asset_value v_nopol', 'v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id', 'left');
        // -------------------------------------

        $this->db->where('a.deleted_st', 0);
        $this->db->where('a.active_st', 1);
        $this->db->order_by('a.asset_nm', 'ASC');

        $d['list_asset'] = $this->db->get()->result_array();

        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        if ($id != null) return; 

        // 1. Konversi Tanggal
        $tgl_raw = $this->input->post('transaksi_tgl');
        $tgl_sql = (strpos($tgl_raw, '-') !== false) ? date('Y-m-d', strtotime($tgl_raw)) : date('Y-m-d');

        $asset_id    = $this->input->post('asset_id');
        $jenis_pajak = $this->input->post('pajak_jenis'); 
        
        // Input user (hanya relevan untuk kendaraan 5 tahunan)
        $nopol_input = strtoupper($this->input->post('nopol_baru')); 

        $asset_lama = $this->db->get_where('mst_asset', ['asset_id' => $asset_id])->row();
        $update_master = ['updated_at' => date('Y-m-d H:i:s')];
        
        // --- LOGIKA PERHITUNGAN JATUH TEMPO ---
        $last_due_date = (!empty($asset_lama->tgl_pajak_tahunan)) ? $asset_lama->tgl_pajak_tahunan : $tgl_sql;
        $next_due_date = date('Y-m-d', strtotime('+1 year', strtotime($last_due_date)));
        
        // Update Jatuh Tempo Tahunan
        $update_master['tgl_pajak_tahunan'] = $next_due_date;

        // --- LOGIKA KHUSUS KENDARAAN (5 TAHUNAN) ---
        if ($jenis_pajak == '5_TAHUNAN') {
            $last_plat = (!empty($asset_lama->tgl_pajak_plat)) ? $asset_lama->tgl_pajak_plat : $tgl_sql;
            $next_plat = date('Y-m-d', strtotime('+5 years', strtotime($last_plat)));
            
            $update_master['tgl_pajak_plat'] = $next_plat;
            
            if (!empty($nopol_input)) $update_master['nopol'] = $nopol_input;
        }

        // --- SIMPAN DATA ---
        $auto_no = $this->m_pajak->get_auto_number($tgl_sql);
        
        // Upload Bukti
        $file_name = null;
        if (!empty($_FILES['bukti_file']['name'])) {
            $config['upload_path']   = './uploads/pajak/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 2048; 
            $config['file_name']     = 'TAX_' . time();
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('bukti_file')) {
                $file_name = $this->upload->data('file_name');
            }
        }

        $nominal_pokok = (int) str_replace('.', '', $this->input->post('nominal_pokok'));
        $nominal_denda = (int) str_replace('.', '', $this->input->post('nominal_denda'));
        $nominal_total = $nominal_pokok + $nominal_denda;

        $data_trx = [
            'transaksi_no'    => $auto_no,
            'transaksi_tgl'   => $tgl_sql,
            'jatuh_tempo_tgl' => $next_due_date,
            'asset_id'        => $asset_id,
            'pajak_jenis'     => $jenis_pajak,
            'nopol_lama'      => $asset_lama->nopol,
            'nopol_baru'      => ($jenis_pajak == '5_TAHUNAN' && !empty($nopol_input)) ? $nopol_input : $asset_lama->nopol,
            'nominal_pokok'   => $nominal_pokok,
            'nominal_denda'   => $nominal_denda,
            'nominal_total'   => $nominal_total,
            'transaksi_ket'   => $this->input->post('transaksi_ket'),
            'bukti_file'      => $file_name,
            'created_by'      => $this->session->userdata('user_id'),
            'created_at'      => date('Y-m-d H:i:s'),
            'active_st'       => 1
        ];

        $this->db->trans_start();
        $this->db->insert($this->table, $data_trx);
        $this->db->where('asset_id', $asset_id)->update('mst_asset', $update_master);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            _json(_response('01', site_url($this->uri_mod)));
        } else {
            if($file_name) unlink('./uploads/pajak/'.$file_name);
            _json(['status' => '00', 'msg' => 'Gagal menyimpan data pajak.']);
        }
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $w);
        _json(_response('03', site_url($this->uri_mod)));
    }
    
    public function get_no_transaksi_ajax()
    {
        $tgl_raw = $this->input->post('tanggal');
        $tgl_sql = date('Y-m-d');
        if (strpos($tgl_raw, '-') !== false) {
            $tgl_sql = date('Y-m-d', strtotime($tgl_raw));
        }
        echo json_encode(['new_no' => $this->m_pajak->get_auto_number($tgl_sql)]);
    }
}