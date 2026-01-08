<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verifikasi_perbaikan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model khusus verifikasi
        _models(['laporan/m_verifikasi_perbaikan']);
        
        $this->table      = 'dat_service';
        $this->pk_id      = 'service_id';
        
        // Sesuaikan folder view/url Anda
        $this->uri_mod    = 'laporan/verifikasi_perbaikan'; 
        $this->template   = 'laporan/verifikasi_perbaikan/'; 
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function ajax_datatables()
    {
        // Memanggil model admin
        $this->m_verifikasi_perbaikan->load_datatables_admin();
    }

    public function form_modal($id = null)
    {
        $d['id'] = $id; 
        $d['main'] = $this->db->get_where($this->table, [$this->pk_id => $id])->row_array();
        
        // Ambil detail lengkap (aset & pelapor)
        $d['detail'] = $this->m_verifikasi_perbaikan->get_detail_lengkap($id);
        
        $d['form_act'] = site_url($this->uri_mod . '/save_process/' . $id);

        $this->render($this->template . 'form_modal', $d);
    }

    // --- LOGIKA UTAMA PERUBAHAN STATUS ---
    public function save_process($id)
    {
        $aksi = $this->input->post('aksi_admin'); // approve, reject, finish
        
        $this->db->trans_start(); 

        $tiket = $this->db->get_where($this->table, [$this->pk_id => $id])->row();
        $asset_id = $tiket->asset_id;

        if ($aksi == 'approve') {
            // SKENARIO 1: TERIMA & BUAT RENCANA (Status 0 -> 1)
            $data_update = [
                'tgl_rencana'       => $this->_convert_date($this->input->post('tgl_rencana')),
                'deskripsi_rencana' => $this->input->post('deskripsi_rencana'),
                'bengkel_nm'        => $this->input->post('bengkel_nm_rencana'),
                'status_tiket'      => 1, // Sedang Proses
                'updated_at'        => date('Y-m-d H:i:s'),
                'updated_by'        => $this->session->userdata('user_id')
            ];

            // Simpan jenis tindakan AC (jika ada) ke kolom keterangan_txt
            if ($this->input->post('jenis_perbaikan_ac')) {
                $data_update['keterangan_txt'] = $this->input->post('jenis_perbaikan_ac');
            }

            $this->db->update($this->table, $data_update, [$this->pk_id => $id]);
            
            // Update Status Master Aset jadi PERBAIKAN
            $this->db->update('mst_asset', ['asset_kondisi' => 'PERBAIKAN'], ['asset_id' => $asset_id]);

        } elseif ($aksi == 'finish') {
            // SKENARIO 2: SELESAI (Status 1 -> 2)
            $kondisi_akhir = $this->input->post('kondisi_akhir'); 
            
            // --- [PERBAIKAN PENTING: SANITASI BIAYA] ---
            $raw_biaya = $this->input->post('biaya');
            // Hapus semua karakter KECUALI angka 0-9 (Huruf/Titik/Rp akan hilang)
            $clean_biaya = preg_replace('/[^0-9]/', '', $raw_biaya);
            
            // Jika kosong (misal user input huruf semua), set jadi 0
            if(empty($clean_biaya)) $clean_biaya = 0;
            // -------------------------------------------

            $data_update = [
                'tgl_service'            => $this->_convert_date($this->input->post('tgl_service')),
                'deskripsi_penyelesaian' => $this->input->post('deskripsi_penyelesaian'),
                'bengkel_nm'             => $this->input->post('bengkel_nm'),
                'biaya'                  => (float) $clean_biaya, // Pastikan tipe data float
                'status_tiket'           => 2, // Selesai
                'updated_at'             => date('Y-m-d H:i:s'),
                'updated_by'             => $this->session->userdata('user_id'),
                'kondisi_akhir'          => $kondisi_akhir // Simpan history kondisi
            ];

            // --- LOGIKA JADWAL BERIKUTNYA (AUTO CALCULATE +3 BULAN) ---
            $tgl_selesai = date('Y-m-d'); 
            if($this->input->post('tgl_service')) {
                 $tgl_selesai = $this->_convert_date($this->input->post('tgl_service'));
            }

            // Cek Jenis Aset untuk penentuan jadwal
            $asset_detail = $this->db->get_where('mst_asset', ['asset_id' => $asset_id])->row();
            $nama_aset = strtoupper($asset_detail->asset_nm);
            $kode_aset = strtoupper($asset_detail->asset_kd);

            // Cek apakah AC atau Kendaraan (Sesuai logika JS di form modal)
            $isAC = (strpos($nama_aset, 'AC ') !== false || strpos($nama_aset, 'AIR CONDITIONER') !== false || $kode_aset == 'AC');
            $isKendaraan = (strpos($nama_aset, 'MOTOR') !== false || strpos($nama_aset, 'MOBIL') !== false || strpos($nama_aset, 'KENDARAAN') !== false);

            if ($isAC || $isKendaraan) {
                 // Set otomatis 3 bulan kedepan
                 $data_update['tgl_berikutnya'] = date('Y-m-d', strtotime('+3 months', strtotime($tgl_selesai)));
            }
            // ----------------------------------------------------------

            $this->db->update($this->table, $data_update, [$this->pk_id => $id]);
            
            // Update Kondisi Master Aset (Baik/Rusak Ringan/dll)
            $this->db->update('mst_asset', ['asset_kondisi' => $kondisi_akhir], ['asset_id' => $asset_id]);

        } elseif ($aksi == 'reject') {
            // SKENARIO 3: TOLAK
            $data_update = [
                'status_tiket' => 9, 
                'updated_at'   => date('Y-m-d H:i:s'),
                'updated_by'   => $this->session->userdata('user_id')
            ];
            $this->db->update($this->table, $data_update, [$this->pk_id => $id]);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            _json(['status' => false, 'msg' => 'Gagal memproses data.']);
        } else {
            _json(_response('01', site_url($this->uri_mod)));
        }
    }

    private function _convert_date($date_raw) {
        if (empty($date_raw)) return date('Y-m-d');
        if (strpos($date_raw, '-') !== false) {
            $parts = explode('-', $date_raw);
            if(count($parts) == 3 && strlen($parts[2]) == 4) {
                return $parts[2] . '-' . $parts[1] . '-' . $parts[0]; 
            }
        }
        return $date_raw;
    }
}