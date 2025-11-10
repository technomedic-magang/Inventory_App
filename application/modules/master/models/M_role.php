<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_role extends CI_Model
{
  var $table, $pk_id;
  function __construct()
  {
    parent::__construct();
    $this->table = 'app_role';
    $this->pk_id = 'role_id';
  }

  public function load_datatables()
  {
    $query = "SELECT * FROM $this->table a";
    $search = ['role_id', 'role_nm'];
    $where = null;
    $isWhere = null;

    DB::datatables_query($query, $search, $where, $isWhere);
  }

  public function load_datatables_permissions($id = '')
  {
    $query = "SELECT
                a.nav_id,
                a.nav_nm,
                a.active_st,
                b.role_id,
                b.nav_id AS checked_nav,
                b.all_data_st AS checked_all  
              FROM app_nav a
              LEFT JOIN app_permission b ON a.nav_id = b.nav_id AND b.role_id = '$id'";
    $search = ['a.nav_id', 'a.nav_nm'];
    $where = null;
    $isWhere = null;

    DB::datatables_query($query, $search, $where, $isWhere);
  }

  public function save_permissions($data = array())
  {
    // @validate token
    _validate_token();
    // @main process
    DB::delete('app_permission', ['role_id' => @$data['role_id']]);
    foreach (@$data['nav_id'] as $key => $val) {
      $data_save = array(
        'role_id' => @$data['role_id'],
        'nav_id' => @$val,
      );
      DB::insert('app_permission', $data_save, null);
    }

    if (is_array(@$data['all_data_st'])) {
      foreach (@$data['all_data_st'] as $key => $val) {
        DB::update(
          'app_permission',
          ['all_data_st' => 1],
          [
            'role_id' => @$data['role_id'],
            'nav_id' => @$val,
          ]
        );
      }
    }
    return true;
  }
}
