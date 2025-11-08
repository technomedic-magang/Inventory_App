<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_pendidikan extends CI_Model
{
  var $table, $pk_id;
  function __construct()
  {
    parent::__construct();
    $this->table = 'mst_pendidikan';
    $this->pk_id = 'pendidikan_id';
  }

  public function load_datatables()
  {
    $query = "SELECT * FROM $this->table a";
    $search = ['pendidikan_id', 'pendidikan_nm'];
    $where = null;
    $isWhere = null;

    DB::datatables_query($query, $search, $where, $isWhere);
  }
}
