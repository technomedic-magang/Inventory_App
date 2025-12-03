<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_mutasi_asset extends CI_Model
{
    var $table = 'trx_mutasi';
    var $pk_id = 'mutasi_id';

    public function load_datatables()
    {
        $query = "SELECT 
                    m.*, 
                    p1.pegawai_nm as asal_nm, 
                    p2.pegawai_nm as tujuan_nm
                  FROM trx_mutasi m
                  LEFT JOIN mst_pegawai p1 ON m.pegawai_asal_id = p1.pegawai_id
                  LEFT JOIN mst_pegawai p2 ON m.pegawai_tujuan_id = p2.pegawai_id";
        
        $search = ['m.transaksi_no', 'p1.pegawai_nm', 'p2.pegawai_nm'];
        $where  = ['m.deleted_st' => 0];
        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // [LOGIKA CANGGIH] Ambil Aset yang SEDANG DIPEGANG oleh Pegawai X
    public function get_assets_held_by_pegawai($pegawai_id)
    {
        return $this->db->select('tpd.asset_id, a.asset_nm, a.asset_kd, tp.transaksi_no, tp.pemakaian_id, tpd.pemakaian_detail_id')
                        ->from('trx_pemakaian_detail tpd')
                        ->join('trx_pemakaian tp', 'tpd.pemakaian_id = tp.pemakaian_id')
                        ->join('mst_asset a', 'tpd.asset_id = a.asset_id')
                        ->where('tp.pegawai_id', $pegawai_id)
                        ->where('tp.pemakaian_sts', 'OPEN') // Hanya yang masih dipinjam
                        ->where('tpd.kembali_qty < tpd.pemakaian_qty') // Belum kembali
                        ->get()->result_array();
    }

    // [MESIN MUTASI]
    public function simpan_mutasi($header, $detail_asset_ids, $pemakaian_asal_ids)
    {
        $this->db->trans_start();

        // 1. Insert Header Mutasi
        $this->db->insert($this->table, $header);
        $mutasi_id = $this->db->insert_id();

        // Loop setiap aset yang dimutasi
        for ($i = 0; $i < count($detail_asset_ids); $i++) {
            $asset_id = $detail_asset_ids[$i];
            $old_pemakaian_id = $pemakaian_asal_ids[$i];

            // 2. TUTUP Transaksi Lama (Pegawai Asal)
            // Kita anggap dikembalikan (Close)
            $this->db->set('kembali_qty', 'pemakaian_qty', FALSE); // Set lunas
            $this->db->where('pemakaian_id', $old_pemakaian_id);
            $this->db->where('asset_id', $asset_id);
            $this->db->update('trx_pemakaian_detail');
            
            // Cek apakah header lama bisa di-close? (Anggap saja ya untuk simplifikasi mutasi)
            $this->db->update('trx_pemakaian', ['pemakaian_sts' => 'CLOSED'], ['pemakaian_id' => $old_pemakaian_id]);


            // 3. BUKA Transaksi Baru (Pegawai Tujuan)
            // Generate nomor baru otomatis untuk pemakaian
            $new_trans_no = 'PMK-MTS/' . date('Ymd') . '/' . rand(100,999); 
            
            $data_new_usage = [
                'transaksi_no'  => $new_trans_no,
                'transaksi_tgl' => $header['transaksi_tgl'],
                'pegawai_id'    => $header['pegawai_tujuan_id'],
                'transaksi_ket' => 'Mutasi dari: ' . $old_pemakaian_id,
                'pemakaian_sts' => 'OPEN',
                'active_st' => 1, 'created_by' => 'SYSTEM_MUTASI'
            ];
            $this->db->insert('trx_pemakaian', $data_new_usage);
            $new_pemakaian_id = $this->db->insert_id();

            // Detail Baru
            // Kita perlu tau gudang asalnya dari transaksi lama
            $old_detail = $this->db->get_where('trx_pemakaian_detail', ['pemakaian_id'=>$old_pemakaian_id, 'asset_id'=>$asset_id])->row();
            
            $this->db->insert('trx_pemakaian_detail', [
                'pemakaian_id' => $new_pemakaian_id,
                'asset_id'     => $asset_id,
                'gudang_id'    => $old_detail->gudang_id, // Tetap tercatat dari gudang yang sama
                'pemakaian_qty'=> 1,
                'kembali_qty'  => 0
            ]);

            // 4. Catat di Detail Mutasi
            $this->db->insert('trx_mutasi_detail', [
                'mutasi_id' => $mutasi_id,
                'asset_id'  => $asset_id,
                'pemakaian_id_asal' => $old_pemakaian_id,
                'pemakaian_id_baru' => $new_pemakaian_id
            ]);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // [FITUR LOG/HISTORY] Menghitung Durasi
    public function get_history_usage($asset_id)
    {
        // Ambil semua riwayat pemakaian untuk aset ini
        $this->db->select('tp.transaksi_tgl as tgl_mulai, tp.pemakaian_sts, p.pegawai_nm, tk.transaksi_tgl as tgl_kembali');
        $this->db->from('trx_pemakaian_detail tpd');
        $this->db->join('trx_pemakaian tp', 'tpd.pemakaian_id = tp.pemakaian_id');
        $this->db->join('mst_pegawai p', 'tp.pegawai_id = p.pegawai_id');
        // Join ke tabel kembali (jika ada) - Logika ini agak kompleks, 
        // untuk simplifikasi kita ambil tgl kembali dari trx_kembali terakhir terkait pemakaian ini
        $this->db->join('trx_kembali_detail tkd', 'tkd.pemakaian_detail_id = tpd.pemakaian_detail_id', 'left');
        $this->db->join('trx_kembali tk', 'tkd.kembali_id = tk.kembali_id', 'left');
        
        $this->db->where('tpd.asset_id', $asset_id);
        $this->db->order_by('tp.transaksi_tgl', 'ASC');
        
        return $this->db->get()->result_array();
    }
}