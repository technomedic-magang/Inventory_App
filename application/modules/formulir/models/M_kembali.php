<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_kembali extends CI_Model
{
    var $table = 'trx_kembali';
    var $pk_id = 'kembali_id';

    public function load_datatables()
    {
        // Menampilkan Data Pengembalian + Info Pegawai
        $query = "SELECT k.*, p.transaksi_no as pemakaian_no, pg.pegawai_nm
                  FROM trx_kembali k
                  LEFT JOIN trx_pemakaian p ON k.pemakaian_id = p.pemakaian_id
                  LEFT JOIN mst_pegawai pg ON p.pegawai_id = pg.pegawai_id";

        $search = ['k.transaksi_no', 'p.transaksi_no', 'pg.pegawai_nm'];
        $where  = ['k.deleted_st' => 0];
        $isWhere = null;
        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // Ambil Transaksi Pemakaian yang statusnya OPEN (Belum Lunas)
    public function get_open_pemakaian()
    {
        return $this->db->select('p.pemakaian_id, p.transaksi_no, pg.pegawai_nm')
                        ->from('trx_pemakaian p')
                        ->join('mst_pegawai pg', 'p.pegawai_id = pg.pegawai_id', 'left')
                        ->where(['p.pemakaian_sts' => 'OPEN', 'p.deleted_st' => 0, 'p.active_st' => 1])
                        ->get()->result_array();
    }

    // [PENTING] Ambil Detail Item dengan Info Lengkap (Atribut)
    public function get_items_pemakaian_list($pemakaian_id)
    {
        // 1. Data Utama
        $this->db->select('d.*, a.asset_nm, a.asset_kd, g.gudang_nm, sa.satuan_nm');
        $this->db->select('(d.pemakaian_qty - d.kembali_qty) as sisa_qty');

        // 2. Atribut Tambahan (Merk, Nopol, Spek, Merek&Tipe)
        $this->db->select('v_merk.value_isi as merk');
        $this->db->select('v_nopol.value_isi as nopol');
        $this->db->select('v_spek.value_isi as spesifikasi');
        $this->db->select('v_merek_tipe.value_isi as merek_tipe'); // Khusus Aksesoris

        $this->db->from('trx_pemakaian_detail d');
        $this->db->join('mst_asset a', 'd.asset_id = a.asset_id');
        $this->db->join('mst_satuan sa', 'a.satuan_id = sa.satuan_id', 'left');
        $this->db->join('mst_gudang g', 'd.gudang_id = g.gudang_id');

        // 3. JOIN KE TABEL ATRIBUT (Logika Gabungan)
        // - Merk
        $this->db->join('mst_kategori_atribut attr_merk', "attr_merk.kategori_id = a.kategori_id AND attr_merk.atribut_label = 'Merek'", 'left');
        $this->db->join('dat_asset_value v_merk', 'v_merk.asset_id = a.asset_id AND v_merk.atribut_id = attr_merk.atribut_id', 'left');
        // - Nopol (Kendaraan)
        $this->db->join('mst_kategori_atribut attr_nopol', "attr_nopol.kategori_id = a.kategori_id AND attr_nopol.atribut_label LIKE '%Polisi%'", 'left');
        $this->db->join('dat_asset_value v_nopol', 'v_nopol.asset_id = a.asset_id AND v_nopol.atribut_id = attr_nopol.atribut_id', 'left');
        // - Spesifikasi (Umum)
        $this->db->join('mst_kategori_atribut attr_spek', "attr_spek.kategori_id = a.kategori_id AND attr_spek.atribut_label LIKE '%Spesifikasi%'", 'left');
        $this->db->join('dat_asset_value v_spek', 'v_spek.asset_id = a.asset_id AND v_spek.atribut_id = attr_spek.atribut_id', 'left');
        // - Merek & Tipe (Aksesoris Komputer)
        $this->db->join('mst_kategori_atribut attr_mt', "attr_mt.kategori_id = a.kategori_id AND attr_mt.atribut_label = 'Merek & Tipe'", 'left');
        $this->db->join('dat_asset_value v_merek_tipe', 'v_merek_tipe.asset_id = a.asset_id AND v_merek_tipe.atribut_id = attr_mt.atribut_id', 'left');

        $this->db->where('d.pemakaian_id', $pemakaian_id);
        $this->db->where('d.pemakaian_qty > d.kembali_qty'); // Hanya ambil yang belum lunas

        return $this->db->get()->result_array();
    }

    public function get_auto_number($tanggal)
    {
        $prefix = 'RTN'; // Return
        $periode = date('Ym', strtotime($tanggal));
        $prefix_full = $prefix . '/' . $periode . '/';

        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        $query = $this->db->get($this->table);
        $last_no = $query->row()->transaksi_no;

        $urutan = ($last_no) ? (int)substr($last_no, -4) + 1 : 1;
        return $prefix_full . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    // PROSES SIMPAN DATA PENGEMBALIAN
    public function simpan_pengembalian($data_header, $data_detail)
    {
        $this->db->trans_start();

        // 1. Insert Header Pengembalian
        $this->db->insert($this->table, $data_header);
        $id_kembali = $this->db->insert_id();

        // 2. Proses Detail Barang
        if (!empty($data_detail['pemakaian_detail_id'])) {
            $pemakaian_detail_id = $data_detail['pemakaian_detail_id'];
            $gudang_id = $data_detail['gudang_id'];
            $asset_id  = $data_detail['asset_id'];
            $qty_kembali = (float) $data_detail['kembali_qty'];
            $kondisi_saat_kembali = $data_detail['kondisi_asset'];
            
            if ($qty_kembali > 0) {
                // A. Insert ke trx_kembali_detail
                $this->db->insert('trx_kembali_detail', [
                    'kembali_id'          => $id_kembali,
                    'pemakaian_detail_id' => $pemakaian_detail_id,
                    'gudang_id'           => $gudang_id,
                    'kembali_qty'         => $qty_kembali,
                    'kondisi_asset'       => $kondisi_saat_kembali,
                    'created_at'          => date('Y-m-d H:i:s')
                ]);

                // B. Update Stok Gudang (Tambah Stok)
                $cek_stok = $this->db->get_where('dat_stok', ['gudang_id' => $gudang_id, 'asset_id' => $asset_id])->row();
                if ($cek_stok) {
                    $this->db->set('stok_qty', 'stok_qty + ' . $qty_kembali, FALSE);
                    $this->db->where('stok_id', $cek_stok->stok_id);
                    $this->db->update('dat_stok');
                } else {
                     $this->db->insert('dat_stok', [
                        'gudang_id' => $gudang_id, 'asset_id' => $asset_id, 'stok_qty' => $qty_kembali
                    ]);
                }

                // C. Update Progres di trx_pemakaian_detail
                $this->db->set('kembali_qty', 'kembali_qty + ' . $qty_kembali, FALSE);
                $this->db->where('pemakaian_detail_id', $pemakaian_detail_id);
                $this->db->update('trx_pemakaian_detail');

                // D. Update Kondisi Aset & Log jika RUSAK
                if ($kondisi_saat_kembali != 'BAIK') {
                    $this->db->where('asset_id', $asset_id);
                    $this->db->update('mst_asset', ['asset_kondisi' => $kondisi_saat_kembali]);
                    
                    // Catat Log Kerusakan (Opsional)
                    $this->db->insert('log_asset_kondisi', [
                        'transaksi_no'  => $data_header['transaksi_no'],
                        'asset_id'      => $asset_id,
                        'transaksi_tgl' => $data_header['transaksi_tgl'],
                        'kondisi_ke'    => $kondisi_saat_kembali,
                        'transaksi_ket' => 'Rusak saat pengembalian',
                        'created_by'    => 'SYSTEM', 'active_st' => 1
                    ]);
                }
            }
        }

        // 3. Cek LUNAS? Jika semua barang sudah kembali, tutup Pemakaian
        $sisa_pinjaman = $this->db->where('pemakaian_id', $data_header['pemakaian_id'])
                                  ->where('pemakaian_qty > kembali_qty', NULL, FALSE)
                                  ->count_all_results('trx_pemakaian_detail');

        if ($sisa_pinjaman == 0) {
            $this->db->update('trx_pemakaian', ['pemakaian_sts' => 'CLOSED'], ['pemakaian_id' => $data_header['pemakaian_id']]);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}