<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_nav extends CI_Model
{
  var $table, $pk_id;
  function __construct()
  {
    parent::__construct();
    $this->table = 'app_nav';
    $this->pk_id = 'nav_id';
  }

  public function load_datatables()
  {
    $query = "SELECT * FROM $this->table a";
    $search = ['nav_nm', 'nav_url'];
    $where = null;
    $isWhere = null;

    DB::datatables_query($query, $search, $where, $isWhere);
  }
}
