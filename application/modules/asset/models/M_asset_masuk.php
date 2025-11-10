<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_asset_masuk extends CI_Model
{
    var $table = 'trx_masuk';
    var $pk_id = 'masuk_id';

    public function load_datatables()
    {
        // PERBAIKAN: Panggil kolom secara eksplisit biar tidak bingung
        $query = "SELECT 
                    t.masuk_id,
                    t.transaksi_tgl,
                    t.transaksi_no,   -- Pastikan ini terpanggil tegas
                    t.transaksi_ket,
                    g.gudang_nm
                FROM trx_masuk t
                LEFT JOIN mst_gudang g ON t.gudang_id = g.gudang_id";

        $search = ['t.transaksi_no', 't.transaksi_ket', 'g.gudang_nm'];
        $where  = ['t.deleted_st' => 0];
        $isWhere = null;

        DB::datatables_query($query, $search, $where, $isWhere);
    }

    // --- MESIN TRANSAKSI KOMPLEKS ---
    public function simpan_transaksi($data_header, $data_detail)
    {
        $this->db->trans_start(); // MULAI TRANSAKSI DATABASE

        // 1. Insert HEADER
        $this->db->insert($this->table, $data_header);
        $id_header = $this->db->insert_id();

        // 2. Loop Insert DETAIL & Update STOK
        $jumlah_item = count($data_detail['asset_id']);
        for ($i = 0; $i < $jumlah_item; $i++) {
            $asset_id = $data_detail['asset_id'][$i];
            $qty_masuk = (float) $data_detail['asset_qty'][$i];

            if (!empty($asset_id) && $qty_masuk > 0) {
                // A. Insert ke trx_masuk_detail
                $this->db->insert('trx_masuk_detail', [
                    'masuk_id'   => $id_header,
                    'asset_id'   => $asset_id,
                    'asset_qty'  => $qty_masuk,
                    'detail_ket' => $data_detail['detail_ket'][$i]
                ]);

                // B. Update Stok di dat_stok (Logika UPSERT: Update if exists, else Insert)
                $gudang_id = $data_header['gudang_id'];
                $cek_stok = $this->db->get_where('dat_stok', ['gudang_id' => $gudang_id, 'asset_id' => $asset_id])->row();

                if ($cek_stok) {
                    // Jika stok sudah ada, tambahkan
                    $this->db->set('stok_qty', 'stok_qty + ' . $qty_masuk, FALSE);
                    $this->db->where('stok_id', $cek_stok->stok_id);
                    $this->db->update('dat_stok');
                } else {
                    // Jika belum ada, buat baru
                    $this->db->insert('dat_stok', [
                        'gudang_id' => $gudang_id,
                        'asset_id'  => $asset_id,
                        'stok_qty'  => $qty_masuk
                    ]);
                }
            }
        }

        $this->db->trans_complete(); // SELESAI TRANSAKSI
        return $this->db->trans_status(); // True jika sukses, False jika gagal
    }

    // --- MESIN AUTO NUMBER ---
    public function get_auto_number($tanggal)
    {
        // 1. Tentukan Prefix dan Periode (misal: IN/202511/)
        $prefix = 'IN';
        $periode = date('Ym', strtotime($tanggal)); // Ambil TahunBulan dari tanggal yang dipilih user
        $prefix_full = $prefix . '/' . $periode . '/';

        // 2. Cari nomor terakhir di database yang punya prefix sama
        $this->db->select_max('transaksi_no');
        $this->db->like('transaksi_no', $prefix_full, 'after');
        $query = $this->db->get($this->table);
        $last_no = $query->row()->transaksi_no; // misal: IN/202511/005

        // 3. Tentukan nomor urut baru
        if ($last_no) {
            // Jika sudah ada, ambil 4 digit terakhir lalu tambah 1
            $last_urutan = (int) substr($last_no, -4);
            $new_urutan = $last_urutan + 1;
        } else {
            // Jika belum ada di bulan ini, mulai dari 1
            $new_urutan = 1;
        }

        // 4. Gabungkan jadi format final (misal: IN/202511/0006)
        return $prefix_full . str_pad($new_urutan, 4, '0', STR_PAD_LEFT);
    }

}