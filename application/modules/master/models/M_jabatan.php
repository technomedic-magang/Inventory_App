<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_jabatan extends CI_Model
{
  var $table, $pk_id;
  function __construct()
  {
    parent::__construct();
    $this->table = 'mst_jabatan';
    $this->pk_id = 'jabatan_id';
  }

  public function load_datatables()
  {
    $query = "SELECT * FROM $this->table a";
    $search = ['jabatan_id', 'jabatan_nm'];
    $where = null;
    $isWhere = null;

    DB::datatables_query($query, $search, $where, $isWhere);
  }
}
