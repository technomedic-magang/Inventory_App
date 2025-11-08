<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_divisi extends CI_Model
{
  var $table, $pk_id;
  function __construct()
  {
    parent::__construct();
    $this->table = 'mst_divisi';
    $this->pk_id = 'divisi_id';
  }

  public function load_datatables()
  {
    $query = "SELECT * FROM $this->table a";
    $search = ['divisi_id', 'divisi_nm'];
    $where = null;
    $isWhere = null;

    DB::datatables_query($query, $search, $where, $isWhere);
  }
}
