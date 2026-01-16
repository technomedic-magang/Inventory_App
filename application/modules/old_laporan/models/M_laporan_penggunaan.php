<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan_penggunaan extends CI_Model
{
    // Ambil Data Laporan berdasarkan Filter
    public function get_report_data($start_date, $end_date, $status_filter = 'ALL')
    {
        $this->db->select('
            h.transaksi_tgl,
            h.transaksi_no,
            h.keperluan_txt,
            p.pegawai_nm,
            a.asset_nm,
            a.asset_kd,
            d.qty_ambil,
            d.qty_kembali
        ');
        
        // Join 4 Tabel: Header -> Detail -> Aset -> Pegawai
        $this->db->from('trx_pemakaian h');
        $this->db->join('trx_pemakaian_detail d', 'h.pemakaian_id = d.pemakaian_id');
        $this->db->join('mst_asset a', 'd.asset_id = a.asset_id');
        $this->db->join('mst_pegawai p', 'h.pegawai_id = p.pegawai_id', 'left');

        // Filter Wajib
        $this->db->where('h.deleted_st', 0);
        $this->db->where('h.transaksi_tgl >=', $start_date);
        $this->db->where('h.transaksi_tgl <=', $end_date);

        // Filter Status (Dipakai / Kembali)
        if ($status_filter == 'OPEN') {
            // Masih Dipakai (Kembali < Ambil)
            $this->db->where('d.qty_kembali < d.qty_ambil');
        } elseif ($status_filter == 'CLOSED') {
            // Sudah Kembali (Kembali >= Ambil)
            $this->db->where('d.qty_kembali >= d.qty_ambil');
        }

        $this->db->order_by('h.transaksi_tgl', 'ASC');
        
        return $this->db->get()->result_array();
    }
}