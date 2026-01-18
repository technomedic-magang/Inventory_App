<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_pajak extends CI_Model
{
    var $table = 'trx_pajak';
    var $pk_id = 'pajak_id';

    public function load_datatables()
    {
        $query = "SELECT 
                    t.*, 
                    a.asset_nm, 
                    a.asset_kd, 
                    k.kategori_nm,
                    -- Logika Nopol: Ambil dari Transaksi (History) atau Master
                    COALESCE(NULLIF(t.nopol_baru, ''), v_nopol.value_isi, '-') as plat_nomor
                  FROM trx_pajak t
                  JOIN mst_asset a ON t.asset_id = a.asset_id
                  LEFT JOIN mst_kategori k ON a.kategori_id = k.kategori_id
                  LEFT JOIN mst_kategori_atribut attr_nopol ON (attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%')
                  LEFT JOIN dat_asset_value v_nopol ON (v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id)";

        $search = ['t.transaksi_no', 'a.asset_nm', 't.nopol_baru', 'v_nopol.value_isi', 'k.kategori_nm'];
        $where  = ['t.deleted_st' => 0];
        $isWhere = null; 

        DB::datatables_query($query, $search, $where, $isWhere);
    }

    public function get_active_assets_for_tax()
    {
        $this->db->select('a.asset_id, a.asset_nm, a.asset_kd, a.tgl_pajak_tahunan, a.tgl_pajak_plat, k.kategori_nm');
        $this->db->select('v_nopol.value_isi as nopol_asli');
        $this->db->from('mst_asset a');
        $this->db->join('mst_kategori k', 'a.kategori_id = k.kategori_id');
        // Join Nopol
        $this->db->join('mst_kategori_atribut attr_nopol', "attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'", 'left');
        $this->db->join('dat_asset_value v_nopol', 'v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id', 'left');
        
        $this->db->where('a.deleted_st', 0);
        $this->db->where('a.active_st', 1);
        $this->db->order_by('a.asset_nm', 'ASC');
        
        return $this->db->get()->result_array();
    }

    public function get_auto_number($tanggal)
    {
        $prefix = 'TAX'; 
        $periode = date('Ym', strtotime($tanggal)); 
        $prefix_full = $prefix . '/' . $periode . '/';

        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        $query = $this->db->get($this->table);
        $last_no = $query->row()->transaksi_no;

        $urutan = ($last_no) ? (int)substr($last_no, -4) + 1 : 1;
        return $prefix_full . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    public function simpan_pembayaran($data_trx, $asset_id, $data_asset_update)
    {
        $this->db->trans_start();
        
        // 1. Insert History Pembayaran
        $this->db->insert($this->table, $data_trx);
        
        // 2. Update Tanggal di Master Asset
        $this->db->where('asset_id', $asset_id);
        $this->db->update('mst_asset', $data_asset_update);

        // 3. Update Nopol di dat_asset_value jika 5 tahunan (Optional Logic)
        if (!empty($data_trx['nopol_baru']) && $data_trx['pajak_jenis'] == '5_TAHUNAN') {
            // Cari atribut ID untuk Nopol aset ini
            $attr = $this->db->query("
                SELECT v.value_id 
                FROM dat_asset_value v 
                JOIN mst_kategori_atribut ka ON v.atribut_id = ka.atribut_id
                WHERE v.asset_id = ? AND ka.atribut_label LIKE '%Polisi%'
            ", [$asset_id])->row();

            if ($attr) {
                $this->db->where('value_id', $attr->value_id);
                $this->db->update('dat_asset_value', ['value_isi' => $data_trx['nopol_baru']]);
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // [BARU] Statistik Dashboard
    public function get_dashboard_stats()
    {
        $tahun_ini = date('Y');
        $bulan_ini = date('Y-m');

        // Total Bayar Tahun Ini
        $total_tahun = $this->db->select_sum('nominal_total')
                                ->where('deleted_st', 0)
                                ->like('transaksi_tgl', $tahun_ini, 'after')
                                ->get($this->table)->row()->nominal_total ?? 0;

        // Total Bayar Bulan Ini
        $total_bulan = $this->db->select_sum('nominal_total')
                                ->where('deleted_st', 0)
                                ->like('transaksi_tgl', $bulan_ini, 'after')
                                ->get($this->table)->row()->nominal_total ?? 0;

        // Jumlah Transaksi Bulan Ini
        $count_bulan = $this->db->where('deleted_st', 0)
                                ->like('transaksi_tgl', $bulan_ini, 'after')
                                ->count_all_results($this->table);

        return [
            'total_tahun' => $total_tahun,
            'total_bulan' => $total_bulan,
            'count_bulan' => $count_bulan
        ];
    }
}