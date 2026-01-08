<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_keuangan_asset extends CI_Model
{
    var $table_asset = 'mst_asset';
    var $table_log   = 'log_asset_nilai';

    // Ambil Data Live & Kalkulasi
    public function get_live_data($filter_kategori = null)
    {
        $this->db->select('a.*, k.kategori_nm');
        $this->db->from($this->table_asset . ' a');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id', 'left');
        $this->db->where('a.deleted_st', 0);
        $this->db->where('a.active_st', 1);
        if ($filter_kategori) {
            $this->db->where('a.kategori_id', $filter_kategori);
        }
        $assets = $this->db->get()->result_array();

        $summary = [
            'total_aset_awal'  => 0,
            'total_akumulasi'  => 0,
            'total_nilai_buku' => 0
        ];

        $detail_data = [];

        foreach ($assets as $row) {
            // Hitung depresiasi per HARI INI
            $calc = $this->_hitung_depresiasi_single($row, date('Y-m-d'));
            
            $summary['total_aset_awal']  += $calc['harga_beli'];
            $summary['total_akumulasi']  -= $calc['akumulasi_depresiasi']; // Disimpan sebagai minus di summary
            $summary['total_nilai_buku'] += $calc['nilai_buku_akhir'];

            // Tambahkan hasil hitung ke row data
            $row['calc_umur_jalan'] = $calc['umur_bulan'];
            $row['calc_nilai_buku'] = $calc['nilai_buku_akhir'];
            $row['calc_status']     = $calc['status_susut'];
            $detail_data[] = $row;
        }

        return ['summary' => $summary, 'data' => $detail_data];
    }

    // Logika Inti Perhitungan Depresiasi (Straight Line)
    private function _hitung_depresiasi_single($row, $target_date)
    {
        $harga_beli = (float) $row['beli_nominal'];
        $residu     = (float) $row['residu_nominal'];
        $masa_bln   = (int) $row['pakai_masa_bln'];
        $tgl_beli   = $row['beli_tgl'];
        
        $d1 = new DateTime($tgl_beli);
        $d2 = new DateTime($target_date);
        
        // Jika belum dibeli pada target date
        if ($d1 > $d2) {
            return [
                'harga_beli' => $harga_beli,
                'umur_bulan' => 0,
                'depresiasi_bulan_ini' => 0,
                'akumulasi_depresiasi' => 0,
                'nilai_buku_awal'  => $harga_beli,
                'nilai_buku_akhir' => $harga_beli,
                'status_susut' => 'BELUM_AKTIF'
            ];
        }

        $diff = $d1->diff($d2);
        $umur_bulan = ($diff->y * 12) + $diff->m; 

        $depresiasi_per_bulan = 0;
        $akumulasi = 0;

        if ($row['depresiasi_metode'] == 'STRAIGHT_LINE' && $masa_bln > 0) {
            $depresiasi_per_bulan = ($harga_beli - $residu) / $masa_bln;
            $akumulasi = $depresiasi_per_bulan * $umur_bulan;

            $max_depresiasi = $harga_beli - $residu;
            
            if ($akumulasi >= $max_depresiasi) {
                $akumulasi = $max_depresiasi;
                $depresiasi_per_bulan = 0; // Sudah mentok
            }
        }

        $nilai_buku_akhir = $harga_beli - $akumulasi;
        
        // Nilai buku bulan lalu (estimasi)
        $nilai_buku_awal = $nilai_buku_akhir + $depresiasi_per_bulan;
        if($nilai_buku_awal > $harga_beli) $nilai_buku_awal = $harga_beli;

        return [
            'harga_beli'           => $harga_beli,
            'umur_bulan'           => $umur_bulan,
            'depresiasi_bulan_ini' => $depresiasi_per_bulan,
            'akumulasi_depresiasi' => $akumulasi,
            'nilai_buku_awal'      => $nilai_buku_awal,
            'nilai_buku_akhir'     => $nilai_buku_akhir,
            'status_susut'         => ($nilai_buku_akhir <= $residu) ? 'HABIS' : 'AKTIF'
        ];
    }

    // Proses Simpan ke Database (Log)
    public function proses_tutup_buku($periode_kd)
    {
        // Cek duplikasi
        $cek = $this->db->get_where($this->table_log, ['periode_kd' => $periode_kd, 'deleted_st' => 0])->num_rows();
        if ($cek > 0) {
            return ['status' => false, 'msg' => 'Periode ' . $periode_kd . ' sudah ditutup sebelumnya.'];
        }

        $tgl_cutoff = date('Y-m-t', strtotime($periode_kd . '-01'));
        $assets = $this->db->get_where($this->table_asset, ['deleted_st' => 0, 'active_st' => 1])->result_array();
        
        if (empty($assets)) {
            return ['status' => false, 'msg' => 'Tidak ada aset aktif.'];
        }

        $batch_data = [];
        $user_id = $this->session->userdata('user_id') ?? 'SYSTEM';

        foreach ($assets as $row) {
            $calc = $this->_hitung_depresiasi_single($row, $tgl_cutoff);

            $batch_data[] = [
                'periode_kd'                   => $periode_kd,
                'tutup_buku_tgl'               => $tgl_cutoff,
                'asset_id'                     => $row['asset_id'],
                'buku_awal_nominal'            => $calc['nilai_buku_awal'],
                'penyusutan_nominal'           => $calc['depresiasi_bulan_ini'],
                'buku_akhir_nominal'           => $calc['nilai_buku_akhir'],
                'akumulasi_penyusutan_nominal' => $calc['akumulasi_depresiasi'],
                'keterangan_txt'               => 'Tutup Buku Otomatis',
                'created_by'                   => $user_id,
                'created_at'                   => date('Y-m-d H:i:s'),
                'active_st'                    => 1,
                'deleted_st'                   => 0
            ];
        }

        $this->db->trans_start();
        if (!empty($batch_data)) {
            $this->db->insert_batch($this->table_log, $batch_data);
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return ['status' => false, 'msg' => 'Gagal menyimpan data.'];
        }

        return ['status' => true, 'msg' => 'Sukses! Tutup buku periode ' . $periode_kd . ' berhasil.'];
    }

    // ... code sebelumnya ...

    // [BARU] Fungsi Membatalkan Tutup Buku
    public function proses_buka_buku($periode_kd)
    {
        // 1. Cek apakah data log ada
        $cek = $this->db->get_where($this->table_log, ['periode_kd' => $periode_kd, 'deleted_st' => 0])->row();
        
        if (!$cek) {
            return ['status' => false, 'msg' => 'Periode ' . $periode_kd . ' belum ditutup atau sudah dibuka sebelumnya.'];
        }

        // 2. Lakukan Soft Delete (Update deleted_st = 1)
        $this->db->trans_start();
        
        $data_update = [
            'deleted_st' => 1,
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => $this->session->userdata('user_id')
        ];

        $this->db->where(['periode_kd' => $periode_kd, 'deleted_st' => 0]);
        $this->db->update($this->table_log, $data_update);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return ['status' => false, 'msg' => 'Gagal membuka kembali periode.'];
        }

        return ['status' => true, 'msg' => 'Periode ' . $periode_kd . ' berhasil dibuka kembali. Silakan lakukan perhitungan ulang jika diperlukan.'];
    }

}