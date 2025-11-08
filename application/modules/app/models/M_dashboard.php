<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
  function pegawai_get()
  {
    $sql = "SELECT 
              a.*,
              b.jabatan_nm,
              c.divisi_nm,
              d.pendidikan_nm
            FROM mst_pegawai a
            LEFT JOIN mst_jabatan b ON a.jabatan_id = b.jabatan_id
            LEFT JOIN mst_divisi c ON a.divisi_id = c.divisi_id
            LEFT JOIN mst_pendidikan d ON a.pendidikan_id = d.pendidikan_id
            WHERE a.pegawai_id = ?";
    $query = $this->db->query($sql, array(_ses_get('pegawai_id')));
    $res = $query->row_array();
    return $res;
  }

  function magang_get()
  {
    $sql = "SELECT 
              a.*,
              b.sekolah_nm
            FROM mst_magang a
            LEFT JOIN mst_sekolah b ON a.sekolah_id = b.sekolah_id
            WHERE a.magang_id = ?";
    $query = $this->db->query($sql, array(_ses_get('magang_id')));
    $res = $query->row_array();
    return $res;
  }
}
