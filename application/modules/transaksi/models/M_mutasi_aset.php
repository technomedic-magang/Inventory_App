<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_mutasi_aset extends CI_Model
{
    public $table = 'trx_mutasi';
    public $pk_id = 'mutasi_id';

    public function load_datatables()
    {
        $query = "SELECT 
                    m.*, 
                    p1.pegawai_nm as asal_nm, 
                    p2.pegawai_nm as tujuan_nm
                  FROM trx_mutasi m
                  LEFT JOIN mst_pegawai p1 ON m.pegawai_asal_id = p1.pegawai_id
                  LEFT JOIN mst_pegawai p2 ON m.pegawai_tujuan_id = p2.pegawai_id";
        
        $search_fields = ['m.transaksi_no', 'p1.pegawai_nm', 'p2.pegawai_nm'];
        $where_clauses = ['m.deleted_st' => 0];
        $isWhere = null; // Pastikan null agar tidak error Array to String
        
        DB::datatables_query($query, $search_fields, $where_clauses, $isWhere);
    }

    public function get_assets_held_by_pegawai($pegawai_id)
    {
        // Query untuk mencari aset yang SEDANG DIPEGANG (Status OPEN)
        $this->db->select('
            tpd.asset_id, a.asset_nm, a.asset_kd, 
            tp.transaksi_no, tp.pemakaian_id, tpd.pemakaian_detail_id,
            v_merk.value_isi as merk,
            v_spek.value_isi as spesifikasi
        ');

        $this->db->from('trx_pemakaian_detail tpd');
        $this->db->join('trx_pemakaian tp', 'tpd.pemakaian_id = tp.pemakaian_id');
        $this->db->join('mst_asset a', 'tpd.asset_id = a.asset_id');

        // Join Atribut Tambahan (Opsional)
        $this->db->join('mst_kategori_atribut attr_merk', "attr_merk.kategori_id = a.kategori_id AND attr_merk.atribut_label = 'Merek'", 'left');
        $this->db->join('dat_asset_value v_merk', 'v_merk.asset_id = a.asset_id AND v_merk.atribut_id = attr_merk.atribut_id', 'left');
        
        $this->db->join('mst_kategori_atribut attr_spek', "attr_spek.kategori_id = a.kategori_id AND attr_spek.atribut_label LIKE '%Spesifikasi%'", 'left');
        $this->db->join('dat_asset_value v_spek', 'v_spek.asset_id = a.asset_id AND v_spek.atribut_id = attr_spek.atribut_id', 'left');

        $this->db->where('tp.pegawai_id', $pegawai_id);
        $this->db->where('tp.pemakaian_sts', 'OPEN');
        $this->db->where('tp.deleted_st', 0);
        $this->db->where('tpd.kembali_qty < tpd.pemakaian_qty'); // Belum dikembalikan

        return $this->db->get()->result_array();
    }

    public function simpan_mutasi($header, $detail_asset_ids, $pemakaian_asal_ids)
    {
        $this->db->trans_start();

        // 1. Insert Header Mutasi
        $this->db->insert($this->table, $header);
        $mutasi_id = $this->db->insert_id();

        // Loop Aset
        for ($i = 0; $i < count($detail_asset_ids); $i++) {
            $asset_id = $detail_asset_ids[$i];
            $old_pemakaian_id = $pemakaian_asal_ids[$i];

            // 2. TUTUP Transaksi Lama (Set Kembali Qty = 1)
            $this->db->set('kembali_qty', 'pemakaian_qty', FALSE);
            $this->db->where('pemakaian_id', $old_pemakaian_id);
            $this->db->where('asset_id', $asset_id);
            $this->db->update('trx_pemakaian_detail');
            
            // Tandai Header Lama CLOSED (Simplifikasi)
            $this->db->update('trx_pemakaian', ['pemakaian_sts' => 'CLOSED'], ['pemakaian_id' => $old_pemakaian_id]);

            // 3. BUKA Transaksi Baru (Untuk Pegawai Tujuan)
            $new_trans_no = 'PMK-AUTO/' . date('ymd') . '/' . rand(1000,9999); 
            
            $data_new_usage = [
                'transaksi_no'  => $new_trans_no,
                'transaksi_tgl' => $header['transaksi_tgl'],
                'pegawai_id'    => $header['pegawai_tujuan_id'],
                'transaksi_ket' => 'Mutasi dari Dokumen: ' . $header['transaksi_no'],
                'pemakaian_sts' => 'OPEN',
                'active_st'     => 1, 
                'created_by'    => 'SYSTEM'
            ];
            $this->db->insert('trx_pemakaian', $data_new_usage);
            $new_pemakaian_id = $this->db->insert_id();

            // Insert Detail Baru
            // Ambil data gudang lama untuk konsistensi stok fisik
            $old_detail = $this->db->get_where('trx_pemakaian_detail', ['pemakaian_id'=>$old_pemakaian_id, 'asset_id'=>$asset_id])->row();
            
            $this->db->insert('trx_pemakaian_detail', [
                'pemakaian_id' => $new_pemakaian_id,
                'asset_id'     => $asset_id,
                'gudang_id'    => $old_detail->gudang_id ?? 0,
                'pemakaian_qty'=> 1,
                'kembali_qty'  => 0
            ]);

            // 4. Catat Log Detail Mutasi
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

    public function get_auto_number($tanggal)
    {
        // Format: MTS/YYYYMM/XXXX
        $prefix = 'MTS'; 
        $periode = date('Ym', strtotime($tanggal)); 
        $prefix_full = $prefix . '/' . $periode . '/';

        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        $query = $this->db->get($this->table);
        $last_no = $query->row()->transaksi_no;

        $urutan = 1;
        if ($last_no) {
            $urutan = (int)substr($last_no, -4) + 1;
        }
        return $prefix_full . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }
}