<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manajemen_asset extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['manajemen/m_manajemen_asset']);
        $this->table = $this->m_manajemen_asset->table;
        $this->pk_id = $this->m_manajemen_asset->pk_id;
        $this->template = 'manajemen/manajemen_asset/'; 
        $this->uri_mod = 'manajemen/manajemen_asset';
    }

    public function index()
    {
        $d['list_kategori'] = $this->db->where('deleted_st', 0)
                                       ->order_by('kategori_nm', 'ASC')
                                       ->get('mst_kategori')
                                       ->result_array();
        $this->render($this->template . 'index', $d);
    }

    public function form_modal($id = null)
    {
        $d['main'] = DB::get($this->table, [$this->pk_id => $id]);
        $d['form_act'] = site_url($this->uri_mod . '/save/' . $id);

        $d['list_kategori'] = $this->db->where('deleted_st', 0)->order_by('kategori_nm', 'ASC')->get('mst_kategori')->result_array();
        $d['list_satuan']   = $this->db->where('deleted_st', 0)->order_by('satuan_nm', 'ASC')->get('mst_satuan')->result_array();

        $d['list_kustom'] = [];
        if ($id) {
            $data_kustom = $this->db->select('v.atribut_id, v.value_isi')
                                    ->from('dat_asset_value v')
                                    ->where('v.asset_id', $id)
                                    ->get()->result_array();
            foreach($data_kustom as $k) {
                $d['list_kustom'][$k['atribut_id']] = $k['value_isi'];
            }
        }
        $this->render($this->template . 'form_modal', $d);
    }

    public function save($id = null)
    {
        $d = _post(); 
        
        // [REVISI FORMAT RUPIAH]
        // Hapus titik (.) agar menjadi integer murni
        // Contoh: "1.000.000" menjadi "1000000"
        $harga_beli = str_replace('.', '', $d['beli_nominal']);
        $nilai_residu = str_replace('.', '', $d['residu_nominal']);

        // Pastikan kosong dianggap 0
        if(empty($harga_beli)) $harga_beli = 0;
        if(empty($nilai_residu)) $nilai_residu = 0;

        // Konversi Tanggal (Format input sekarang pasti dd-mm-yyyy)
        // Fungsi ini akan mengubahnya menjadi Y-m-d untuk disimpan ke MySQL
        $tgl_beli_sql = $this->_convert_date($d['beli_tgl']);

        $data_main = [
            'kategori_id' => $d['kategori_id'],
            'satuan_id' => $d['satuan_id'],
            'asset_nm' => $d['asset_nm'],
            'asset_kd_singkat' => strtoupper($d['asset_kd_singkat']),
            
            'beli_nominal' => (float) $harga_beli,
            'beli_tgl' => $tgl_beli_sql, 
            'pakai_masa_bln' => (int) $d['pakai_masa_bln'],
            'residu_nominal' => (float) $nilai_residu,
            'depresiasi_metode' => $d['depresiasi_metode'],
            
            // Kolom Legacy (Generate dari tanggal)
            'asset_thn_beli' => date('Y', strtotime($tgl_beli_sql)), 
            'asset_bln_beli' => date('m', strtotime($tgl_beli_sql)),
            'asset_masa_pakai_thn' => floor((int)$d['pakai_masa_bln'] / 12), 
            
            'asset_kondisi' => $d['asset_kondisi'] ?? 'BAIK',
            'stok_min_qty' => $d['stok_min_qty'] ?? 0,
            'asset_ket' => $d['asset_ket'] ?? NULL,
            'active_st' => 1 
        ];
        
        $data_kustom = $d['kustom'] ?? [];

        if ($id == null) {
            $tahun = date('Y', strtotime($tgl_beli_sql));
            $bulan = date('m', strtotime($tgl_beli_sql));
            
            $data_main['asset_kd'] = $this->m_manajemen_asset->get_next_full_sku(
                $d['kategori_id'], $data_main['asset_kd_singkat'], $tahun, $bulan
            );
            $data_main['deleted_st'] = 0;
            $data_main['created_by'] = $this->session->userdata('user_id');
            
            DB::insert($this->table, $data_main);
            $id = $this->db->insert_id();
        } else {
            $data_main['updated_by'] = $this->session->userdata('user_id');
            DB::update($this->table, $data_main, [$this->pk_id => $id]);
        }

        $this->db->delete('dat_asset_value', ['asset_id' => $id]);
        if (!empty($data_kustom)) {
            $batch_data = [];
            foreach ($data_kustom as $atribut_id => $isi_value) {
                if (!empty($isi_value)) {
                    $batch_data[] = [
                        'asset_id'   => $id,
                        'atribut_id' => $atribut_id,
                        'value_isi'  => $isi_value,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('user_id')
                    ];
                }
            }
            if (!empty($batch_data)) {
                $this->db->insert_batch('dat_asset_value', $batch_data);
            }
        }
        _json(_response('01', site_url($this->uri_mod)));
    }

    public function delete($id = null)
    {
        $w = [$this->pk_id => $id];
        DB::update($this->table, ['deleted_st' => 1, 'active_st' => 0], $w);
        _json(_response('03', site_url($this->uri_mod)));
    }

    public function ajax_datatables()
    {
        $this->m_manajemen_asset->load_datatables();
    }
    
    public function get_atribut_dinamis()
    {
        $kategori_id = $this->input->post('kategori_id');
        $asset_id = $this->input->post('asset_id'); 
        $kategori = $this->db->get_where('mst_kategori', ['kategori_id' => $kategori_id])->row_array();
        if (!$kategori) { echo json_encode(['html' => '', 'tipe' => '']); return; }
        $list_atribut = $this->db->where('kategori_id', $kategori_id)->where('deleted_st', 0)->order_by('atribut_urutan', 'ASC')->get('mst_kategori_atribut')->result_array();
        $data['list_atribut'] = $list_atribut;
        $data['tipe_kategori'] = $kategori['kategori_tipe'];
        $data_tersimpan = [];
        if($asset_id){
            $raw = $this->db->where('asset_id', $asset_id)->get('dat_asset_value')->result_array();
            foreach($raw as $val) { $data_tersimpan[$val['atribut_id']] = $val['value_isi']; }
        }
        $data['tersimpan'] = $data_tersimpan; 
        $html = $this->load->view($this->template . '_ajax_form_dinamis', $data, TRUE);
        echo json_encode(['html' => $html, 'tipe' => $kategori['kategori_tipe']]);
    }

    public function get_sku_ajax()
    {
        $kategori_id = $this->input->post('kategori_id');
        $kd_singkat  = $this->input->post('kd_singkat');
        $tgl_beli_raw = $this->input->post('tgl_beli'); 
        
        $tgl_beli = $this->_convert_date($tgl_beli_raw);

        $tahun = date('Y', strtotime($tgl_beli));
        $bulan = date('m', strtotime($tgl_beli));
        $new_sku = $this->m_manajemen_asset->get_next_full_sku($kategori_id, $kd_singkat, $tahun, $bulan);
        echo json_encode(['new_sku' => $new_sku]);
    }

    public function get_singkatan_ajax()
    {
        // Cegah output HTML liar (misal dari error PHP Notice/Warning)
        ob_start(); 

        $kategori_id = $this->input->post('kategori_id');
        
        if(empty($kategori_id)) {
            ob_end_clean();
            header('Content-Type: application/json');
            echo json_encode([]);
            return;
        }

        // Ambil data
        $data = $this->db->select('asset_kd_singkat')
                        ->from('mst_asset')
                        ->where('kategori_id', $kategori_id)
                        ->where('asset_kd_singkat !=', '') 
                        ->where('asset_kd_singkat IS NOT NULL', null, false)
                        ->where('deleted_st', 0)
                        ->group_by('asset_kd_singkat')
                        ->order_by('asset_kd_singkat', 'ASC')
                        ->get()
                        ->result_array();
        
        // Bersihkan buffer output sebelum kirim JSON
        ob_end_clean();
        
        // Paksa Header JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    private function _convert_date($date_raw)
    {
        if (empty($date_raw)) return date('Y-m-d');
        
        // Cek apakah format dd-mm-yyyy (indonesia)
        if (strpos($date_raw, '-') !== false) {
            $parts = explode('-', $date_raw);
            
            // Jika ada 3 bagian (tgl, bln, thn)
            if (count($parts) == 3) {
                // Pastikan bagian tahun (indeks 2) panjangnya 4 digit
                if (strlen($parts[2]) == 4) {
                    // Manual Reorder: Thn-Bln-Tgl
                    return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                }
            }
        }
        // Jika format sudah Y-m-d atau lainnya, kembalikan apa adanya
        return $date_raw;
    }
}