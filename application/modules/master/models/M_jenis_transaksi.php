<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_jenis_transaksi extends CI_Model
{
  var $table, $pk_id;
  function __construct()
  {
    parent::__construct();
    $this->table = 'mst_jenis_transaksi';
    $this->pk_id = 'jenis_transaksi_id';
  }

  public function load_datatables()
  {
    $query = "SELECT * FROM $this->table a";
    $search = ['jenis_transaksi_id', 'jenis_transaksi_nm'];
    $where = null;
    $isWhere = null;

    DB::datatables_query($query, $search, $where, $isWhere);
  }
}
