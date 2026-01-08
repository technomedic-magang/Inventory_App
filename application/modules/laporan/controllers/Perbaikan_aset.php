<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perbaikan_aset extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['laporan/m_perbaikan_aset']);
        
        $this->table      = $this->m_perbaikan_aset->table;
        $this->pk_id      = $this->m_perbaikan_aset->pk_id;
        $this->uri_mod    = 'laporan/perbaikan_aset'; 
        // $this->uri    = 'laporan/perbaikan_aset'; 
        $this->template   = 'laporan/perbaikan_aset/'; 
    }

    public function index()
    {
        $d['list_kategori'] = $this->m_perbaikan_aset->get_all_kategori();
        $this->render($this->template . 'index', $d);
    }

    public function ajax_datatables()
    {
        $this->m_perbaikan_aset->load_datatables();
    }

    public function form_modal($id = null)
    {
        $d['id'] = $id; 
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = site_url($this->uri_mod . '/save' . ($id ? '/' . $id : ''));

        $d['list_asset']    = $this->m_perbaikan_aset->get_all_assets();
        $d['list_kategori'] = $this->m_perbaikan_aset->get_all_kategori();

        if ($id) {
            $pelapor = $this->db->select('p.pegawai_nm')
                                ->from('dat_service s')
                                ->join('mst_pegawai p', 's.pelapor_id = p.pegawai_id')
                                ->where('s.service_id', $id)
                                ->get()->row();
            $d['nama_pelapor'] = $pelapor ? $pelapor->pegawai_nm : '-';
        } else {
            $user_id = $this->session->userdata('user_id'); 
            $pgw = $this->db->get_where('mst_pegawai', ['user_id' => $user_id])->row();
            $d['nama_pelapor'] = $pgw ? $pgw->pegawai_nm : 'User Tamu';
        }

        $d['asset_detail'] = [];
        if(!empty($d['main']['asset_id'])){
             $d['asset_detail'] = $this->db->get_where('mst_asset', ['asset_id'=>$d['main']['asset_id']])->row_array();
        }

        $this->render($this->template . 'form_modal', $d);
    }

    public function get_no_tiket_ajax()
    {
        if (ob_get_length()) ob_clean(); 
        header('Content-Type: application/json');

        $tgl_raw  = $this->input->post('tanggal');
        $asset_id = $this->input->post('asset_id'); 

        if (empty($tgl_raw)) $tgl_raw = date('d-m-Y');
        $tgl_sql = $this->_convert_date($tgl_raw);

        if(empty($asset_id)) {
            echo json_encode(['status' => true, 'no_tiket' => 'Pilih Aset Dahulu...']);
            return;
        }

        $no_tiket = $this->m_perbaikan_aset->get_auto_ticket_number($tgl_sql, $asset_id);
        echo json_encode(['status' => true, 'no_tiket' => $no_tiket]);
        exit;
    }

    public function save($id = null)
    {
        // 1. Validasi Edit: Cek Status
        if ($id) {
            $cek_status = $this->db->select('status_tiket')->get_where($this->table, [$this->pk_id => $id])->row();
            if ($cek_status && $cek_status->status_tiket != 0) {
                // KIRIM msg DAN message
                _json(['status' => false, 'msg' => 'Data terkunci (Sudah diproses).', 'message' => 'Data terkunci (Sudah diproses).']);
                return;
            }
        }

        $d = _post();
        if (empty($d['asset_id'])) { 
            _json(['status' => false, 'msg' => 'Aset wajib dipilih.', 'message' => 'Aset wajib dipilih.']); 
            return; 
        }

        // 2. VALIDASI DOUBLE TICKET
        $this->db->where('asset_id', $d['asset_id']);
        $this->db->where_in('status_tiket', [0, 1]); 
        $this->db->where('deleted_st', 0);
        if ($id) { $this->db->where($this->pk_id . ' !=', $id); }
        $active_ticket = $this->db->get($this->table)->row();

        if ($active_ticket) {
            $status_msg = ($active_ticket->status_tiket == 0) ? 'Menunggu Verifikasi' : 'Sedang Diperbaiki';
            $pesan_error = 'GAGAL: Aset ini masih dalam status ' . $status_msg . '. Harap selesaikan tiket sebelumnya.';
            // KIRIM msg DAN message
            _json(['status' => false, 'msg' => $pesan_error, 'message' => $pesan_error]);
            return;
        }

        // =========================================================================
        // MODIFIKASI: UPLOAD KE FOLDER PROJECT API (Project_Magang_API)
        // =========================================================================
        $foto_name = '';
        if (!empty($_FILES['keluhan_foto']['name'])) {
            
            // Tentukan path relatif mundur satu folder (..) lalu masuk ke folder API
            // FCPATH mengarah ke C:\laragon\www\Project_Magang\
            $path_api = FCPATH . '../Project_Magang_API/uploads/keluhan/';

            // Cek apakah folder tujuan ada, jika tidak, buat foldernya secara otomatis
            if (!is_dir($path_api)) {
                mkdir($path_api, 0777, true);
            }

            // Set konfigurasi upload
            $config['upload_path']   = $path_api; 
            $config['allowed_types'] = 'jpg|jpeg|png'; 
            $config['max_size']      = 5120; // 5MB
            $config['encrypt_name']  = TRUE; // Nama file diacak agar unik
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('keluhan_foto')) {
                $upload_data = $this->upload->data();
                $foto_name = $upload_data['file_name'];
            } else {
                $err = 'Upload Gagal: ' . $this->upload->display_errors('', '');
                // Uncomment baris bawah jika ingin debug path saat error
                // $err .= " (Target Path: " . $path_api . ")"; 
                _json(['status' => false, 'msg' => $err, 'message' => $err]); 
                return;
            }
        }
        // =========================================================================

        $created_at = !empty($d['created_at']) ? $this->_convert_date($d['created_at']) : date('Y-m-d');
        $created_at .= ' ' . date('H:i:s');

        $km_saat_ini = isset($d['kilometer_saat_ini']) ? str_replace('.', '', $d['kilometer_saat_ini']) : NULL;
        $km_next     = isset($d['kilometer_berikutnya']) ? str_replace('.', '', $d['kilometer_berikutnya']) : NULL;
        $tgl_next    = !empty($d['tgl_berikutnya']) ? $this->_convert_date($d['tgl_berikutnya']) : NULL;

        $data = [
            'asset_id'           => $d['asset_id'],
            'keluhan_deskripsi'  => $d['keluhan_deskripsi'],
            'created_at'         => $created_at, 
            'updated_at'         => date('Y-m-d H:i:s'),
            'updated_by'         => $this->session->userdata('user_id'),
            'kilometer_saat_ini' => empty($km_saat_ini) ? NULL : $km_saat_ini,
            'kilometer_berikutnya'=> empty($km_next) ? NULL : $km_next,
            'tgl_berikutnya'     => $tgl_next
        ];

        // Jika ada foto baru yang diupload, masukkan ke database
        if ($foto_name) {
            $data['keluhan_foto'] = $foto_name;
        }

        $redirect_uri = site_url($this->uri_mod . '?n=' . $this->input->get('n'));

        if ($id == null) {
            $user_id = $this->session->userdata('user_id');
            $pgw = $this->db->get_where('mst_pegawai', ['user_id' => $user_id])->row();
            
            $data['pelapor_id']   = $pgw ? $pgw->pegawai_id : NULL; 
            $data['status_tiket'] = 0; 
            $data['created_by']   = $user_id;
            $data['deleted_st']   = 0;
            
            DB::insert($this->table, $data);
            _json(_response('01', $redirect_uri));
        } else {
            DB::update($this->table, $data, [$this->pk_id => $id]);
            _json(_response('02', $redirect_uri));
        }
    }
    
    public function delete($id = null) {
        $cek_status = $this->db->select('status_tiket')->get_where($this->table, [$this->pk_id => $id])->row();
        if ($cek_status && $cek_status->status_tiket != 0) {
            _json(['status' => false, 'msg' => 'Tiket sudah diproses, tidak dapat dihapus.', 'message' => 'Tiket sudah diproses.']);
            return;
        }

        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1], $w);
        _json(_response('03', site_url($this->uri_mod . '?n=' . $this->input->get('n'))));
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