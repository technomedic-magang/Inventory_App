<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemakaian extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
<<<<<<< HEAD
        _models(['formulir/m_pemakaian']); 
        $this->table = $this->m_pemakaian->table;
        $this->pk_id = $this->m_pemakaian->pk_id;
        $this->template = 'formulir/pemakaian/'; 
=======
        // Pastikan path model benar
        _models(['formulir/m_pemakaian']); 
        
        $this->table = $this->m_pemakaian->table;
        $this->pk_id = $this->m_pemakaian->pk_id;
        $this->template = 'formulir/pemakaian/'; 
        $this->uri = 'formulir/pemakaian'; 
>>>>>>> repoB/main
    }

    public function index()
    {
        $this->render($this->template . 'index');
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
<<<<<<< HEAD
        $d['form_act'] = $this->uri . '/save/' . $id;

=======
        $d['form_act'] = site_url($this->uri . '/save/' . $id);

        // Jika mode tambah baru, generate nomor otomatis
>>>>>>> repoB/main
        if ($id == null) {
            $d['preview_no'] = $this->m_pemakaian->get_auto_number(date('Y-m-d'));
        }

<<<<<<< HEAD
        $d['list_pegawai'] = $this->db->select('pegawai_id, pegawai_nm, user_id')->where(['deleted_st' => 0, 'active_st' => 1])->get('mst_pegawai')->result_array();
        $d['list_gudang']  = $this->db->where(['deleted_st' => 0, 'active_st' => 1])->get('mst_gudang')->result_array();
=======
        $d['list_pegawai'] = $this->db->select('pegawai_id, pegawai_nm, user_id')
                                      ->where(['deleted_st' => 0, 'active_st' => 1])
                                      ->get('mst_pegawai')
                                      ->result_array();
                                      
        $d['list_gudang']  = $this->db->where(['deleted_st' => 0, 'active_st' => 1])
                                      ->get('mst_gudang')
                                      ->result_array();
>>>>>>> repoB/main
        
        $this->render($this->template . 'form_modal', $d);
    }

<<<<<<< HEAD
    // [REVISI] Save Single Item
    public function save($id = null)
    {
        if ($id != null) return;

        $tgl = $this->input->post('transaksi_tgl');
        $auto_no = $this->m_pemakaian->get_auto_number($tgl);

        // Ambil data input tunggal
        $gudang_id = $this->input->post('gudang_id');
        $asset_id  = $this->input->post('asset_id');
        $qty_pakai = $this->input->post('pemakaian_qty');

        // Validasi sederhana
        if (empty($gudang_id) || empty($asset_id) || empty($qty_pakai)) {
             echo json_encode(['status' => '00', 'msg' => 'Mohon lengkapi data barang.']);
             return;
        }

        $data_header = [
            'transaksi_no'        => $auto_no,
            'transaksi_tgl'       => $tgl,
            'kembali_rencana_tgl' => $this->input->post('kembali_rencana_tgl'),
            'pegawai_id'          => $this->input->post('pegawai_id'),
            'transaksi_ket'       => $this->input->post('transaksi_ket'),
            'pemakaian_sts'       => 'OPEN',
            'active_st' => 1, 'deleted_st' => 0,
            'created_by' => 'PEGAWAI TESTER'
        ];

        // Panggil fungsi simpan yang baru (tanpa array)
        if ($this->m_pemakaian->simpan_transaksi($data_header, $asset_id, $gudang_id, $qty_pakai)) {
            _json(_response('01', $this->uri));
        } else {
             echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan. Cek stok barang.']);
        }
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $w);
        _json(_response('03', $this->uri));
=======
    public function save($id = null)
    {
        // [PERBAIKAN] Hapus baris di bawah ini jika Anda ingin mengizinkan Edit Data.
        // Jika hanya Insert, biarkan. Tapi biasanya ini bug yang membuat Edit gagal.
        // if ($id != null) return; 

        $tgl_raw = $this->input->post('transaksi_tgl');
        $kembali_raw = $this->input->post('kembali_rencana_tgl');

        // Validasi input dasar
        if (empty($tgl_raw)) {
             echo json_encode(['status' => '00', 'msg' => 'Tanggal Pinjam wajib diisi.']);
             return;
        }

        if ($id != null) {
            _json(['status' => false, 'msg' => 'Maaf, Data Pemakaian tidak bisa diedit demi keamanan stok. Silakan Hapus dan Input Ulang.']);
            return;
        }

        // --- 1. KONVERSI TANGGAL PINJAM (Helper Function) ---
        $tgl_sql = $this->_convert_date($tgl_raw);

        // --- 2. KONVERSI TANGGAL KEMBALI ---
        // Jika kosong, samakan dengan tanggal pinjam
        $kembali_sql = empty($kembali_raw) ? $tgl_sql : $this->_convert_date($kembali_raw);

        // Siapkan Data Header
        $data_header = [
            'transaksi_tgl'       => $tgl_sql,
            'kembali_rencana_tgl' => $kembali_sql,
            'pegawai_id'          => $this->input->post('pegawai_id'),
            'transaksi_ket'       => $this->input->post('transaksi_ket'),
            'active_st'           => 1, 
            'deleted_st'          => 0,
        ];

        // LOGIKA INSERT
        if ($id == null) {
            $data_header['transaksi_no'] = $this->m_pemakaian->get_auto_number($tgl_sql);
            $data_header['pemakaian_sts'] = 'OPEN';
            $data_header['created_by'] = $this->session->userdata('user_id') ?? 'SYSTEM';

            $gudang_id = $this->input->post('gudang_id');
            $asset_id  = $this->input->post('asset_id');
            $qty_pakai = $this->input->post('pemakaian_qty');

            if (empty($gudang_id) || empty($asset_id) || empty($qty_pakai)) {
                 echo json_encode(['status' => '00', 'msg' => 'Data barang dan jumlah wajib diisi.']);
                 return;
            }

            // Panggil fungsi simpan di Model
            if ($this->m_pemakaian->simpan_transaksi($data_header, $asset_id, $gudang_id, $qty_pakai)) {
                _json(_response('01', site_url($this->uri . '?n=' . $this->input->get('n'))));
            } else {
                 echo json_encode(['status' => '00', 'msg' => 'Gagal menyimpan. Cek stok barang.']);
            }
        } 
        // LOGIKA UPDATE (Jika diperlukan)
        else {
            $data_header['updated_by'] = $this->session->userdata('user_id');
            // Update logic standar (header only biasanya)
            DB::update($this->table, $data_header, [$this->pk_id => $id]);
            _json(_response('02', site_url($this->uri . '?n=' . $this->input->get('n'))));
        }
    }

    // Di Controller Pemakaian.php
    public function delete($id = null)
    {
        // Panggil fungsi model yang sudah kita perbaiki stok-nya
        $status = $this->m_pemakaian->hapus_transaksi($id);
        
        if ($status) {
            _json(_response('03', site_url($this->uri . '?n=' . $this->input->get('n'))));
        } else {
            _json(['status' => false, 'msg' => 'Gagal menghapus data.']);
        }
>>>>>>> repoB/main
    }

    public function ajax_datatables()
    {
<<<<<<< HEAD
        $this->m_pemakaian->load_datatables();
=======
        // [PENTING] Header JSON untuk mencegah error parse DataTables
        header('Content-Type: application/json');
        
        // Panggil model. 
        // NOTE: Pastikan load_datatables() di model melakukan 'echo' outputnya.
        // Jika model hanya me-return string/array, tambahkan 'echo' di depannya.
        $output = $this->m_pemakaian->load_datatables();
        
        // Cek jika model me-return data (tidak langsung echo)
        if (is_array($output) || is_object($output)) {
            echo json_encode($output);
        } else if (is_string($output)) {
            echo $output;
        }
>>>>>>> repoB/main
    }

    public function get_no_transaksi_ajax()
    {
<<<<<<< HEAD
        $tgl = $this->input->post('tanggal');
        echo json_encode(['new_no' => $this->m_pemakaian->get_auto_number($tgl)]);
=======
        header('Content-Type: application/json');
        $tgl_raw = $this->input->post('tanggal');
        $tgl_sql = $this->_convert_date($tgl_raw);
        
        echo json_encode(['new_no' => $this->m_pemakaian->get_auto_number($tgl_sql)]);
>>>>>>> repoB/main
    }

    public function get_assets_by_gudang()
    {
<<<<<<< HEAD
        $gudang_id = $this->input->post('gudang_id');
        echo json_encode($this->m_pemakaian->get_assets_available($gudang_id));
    }
=======
        header('Content-Type: application/json');
        $gudang_id = $this->input->post('gudang_id');
        echo json_encode($this->m_pemakaian->get_assets_available($gudang_id));
    }

    // --- HELPER INTERNAL CONTROLLER UNTUK TANGGAL ---
    private function _convert_date($date_raw)
    {
        if (empty($date_raw)) return date('Y-m-d');

        // Cek apakah format dd-mm-yyyy (cek dash dan posisi tahun)
        if (strpos($date_raw, '-') !== false) {
            $parts = explode('-', $date_raw);
            // Asumsi dd-mm-yyyy (tahun di belakang)
            if (count($parts) == 3 && strlen($parts[2]) == 4) {
                return date('Y-m-d', strtotime($date_raw));
            }
        }
        return $date_raw;
    }
>>>>>>> repoB/main
}