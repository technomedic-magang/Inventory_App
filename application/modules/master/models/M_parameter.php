<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_parameter extends CI_Model
{
  var $table, $pk_id;
  function __construct()
  {
    parent::__construct();
    $this->table = 'mst_parameter';
    $this->pk_id = 'parameter_id';
  }

  public function load_datatables()
  {
    $query = "SELECT * FROM $this->table a";
    $search = ['a.parameter_group', 'a.parameter_nm', 'a.parameter_field', 'a.parameter_cd', 'a.parameter_val'];
    $where = null;
    $isWhere = null;

    DB::datatables_query($query, $search, $where, $isWhere);
  }
}
