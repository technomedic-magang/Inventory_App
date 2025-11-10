<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_kembali extends CI_Model
{
    var $table = 'trx_kembali';
    var $pk_id = 'kembali_id';

    public function load_datatables()
    {
        $query = "SELECT k.*, p.transaksi_no as pinjam_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pinjam p ON k.pinjam_id = p.pinjam_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id";
        $search = ['k.transaksi_no', 'p.transaksi_no', 'pg.pegawai_nm'];
        $where  = ['k.deleted_st' => 0];
        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    public function get_open_pinjam()
    {
        return $this->db->select('p.pinjam_id, p.transaksi_no, pg.pegawai_nm')
                        ->from('trx_pinjam p')
                        ->join('mst_pegawai pg', 'p.pegawai_id = pg.pegawai_id', 'left')
                        ->where(['p.pinjam_sts' => 'OPEN', 'p.deleted_st' => 0, 'p.active_st' => 1])
                        ->get()->result_array();
    }

    public function simpan_pengembalian($data_header, $data_detail)
    {
        $this->db->trans_start();
        $this->db->insert($this->table, $data_header);
        $id_kembali = $this->db->insert_id();

        $total_barang = count($data_detail['pinjam_detail_id']);
        for ($i = 0; $i < $total_barang; $i++) {
            $qty_kembali = (float) $data_detail['kembali_qty'][$i];
            if ($qty_kembali > 0) {
                $pinjam_detail_id = $data_detail['pinjam_detail_id'][$i];
                $gudang_id = $data_detail['gudang_id'][$i];
                $asset_id  = $data_detail['asset_id'][$i];

                $this->db->insert('trx_kembali_detail', [
                    'kembali_id'       => $id_kembali,
                    'pinjam_detail_id' => $pinjam_detail_id,
                    'gudang_id'        => $gudang_id,
                    'kembali_qty'      => $qty_kembali,
                    'kondisi_asset'    => $data_detail['kondisi_asset'][$i]
                ]);

                // Update Stok (UPSERT)
                $cek_stok = $this->db->get_where('dat_stok', ['gudang_id' => $gudang_id, 'asset_id' => $asset_id])->row();
                if ($cek_stok) {
                    $this->db->set('stok_qty', 'stok_qty + ' . $qty_kembali, FALSE);
                    $this->db->where('stok_id', $cek_stok->stok_id);
                    $this->db->update('dat_stok');
                } else {
                     $this->db->insert('dat_stok', ['gudang_id' => $gudang_id, 'asset_id' => $asset_id, 'stok_qty' => $qty_kembali]);
                }

                // Update Sisa Pinjam
                $this->db->set('kembali_qty', 'kembali_qty + ' . $qty_kembali, FALSE);
                $this->db->where('pinjam_detail_id', $pinjam_detail_id);
                $this->db->update('trx_pinjam_detail');
            }
        }

        // Cek Lunas
        $sisa = $this->db->where('pinjam_id', $data_header['pinjam_id'])
                         ->where('pinjam_qty > kembali_qty', NULL, FALSE)
                         ->count_all_results('trx_pinjam_detail');
        if ($sisa == 0) {
            $this->db->update('trx_pinjam', ['pinjam_sts' => 'CLOSED'], ['pinjam_id' => $data_header['pinjam_id']]);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // --- AUTO NUMBER (RTN) ---
    public function get_auto_number($tanggal)
    {
        $prefix = 'RTN';
        $periode = date('Ym', strtotime($tanggal));
        $prefix_full = $prefix . '/' . $periode . '/';
        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        $last_no = $this->db->get($this->table)->row()->transaksi_no;
        $urutan = ($last_no) ? (int)substr($last_no, -4) + 1 : 1;
        return $prefix_full . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }
}