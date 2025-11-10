<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_pegawai extends CI_Model
{
  var $table, $pk_id, $nav_sess;
  function __construct()
  {
    parent::__construct();
    $this->table = 'mst_pegawai';
    $this->pk_id = 'pegawai_id';
    $this->nav_sess = @_ses_get(_get('n'));
  }

  public function load_datatables()
  {
    $where = "1 = 1 ";

    if (@$this->nav_sess['search']['data']['divisi_id'] != '') {
      $where .= " AND a.divisi_id LIKE '" . @$this->nav_sess['search']['data']['divisi_id'] . "%' ";
    }

    if (@$this->nav_sess['search']['data']['jabatan_id'] != '') {
      $where .= " AND a.jabatan_id = '" . @$this->nav_sess['search']['data']['jabatan_id'] . "' ";
    }

    if (@$this->nav_sess['search']['data']['active_st'] != '') {
      if (@$this->nav_sess['search']['data']['active_st'] != 'semua') {
        $where .= " AND a.active_st = '" . @$this->nav_sess['search']['data']['active_st'] . "' ";
      }
    } else {
      $where .= " AND a.active_st = 1 ";
    }

    if (@$this->nav_sess['search']['data']['term'] != '') {
      $where .= " AND LOWER(a.pegawai_nm) LIKE '%" . @strtolower($this->nav_sess['search']['data']['term']) . "%' ";
    }

    $query = "SELECT 
                *
              FROM
              (
                SELECT 
                  a.*, 
                  b.jabatan_nm, 
                  c.divisi_nm,
                  e.role_nm 
                FROM $this->table a
                LEFT JOIN mst_jabatan b ON a.jabatan_id = b.jabatan_id
                LEFT JOIN mst_divisi c ON a.divisi_id = c.divisi_id
                LEFT JOIN app_user d ON a.user_id = d.user_id
                LEFT JOIN app_role e ON d.role_id = e.role_id
                WHERE 
                  $where
              ) x ";
    $search = ['pegawai_nm', 'pegawai_nm'];
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
                b.pegawai_id,
                b.nav_id AS checked_nav,
                b.all_data_st AS checked_all  
              FROM
                app_nav a
              LEFT JOIN app_permission b ON a.nav_id = b.nav_id AND b.pegawai_id = '$id'";
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
    DB::delete('app_permission', ['pegawai_id' => @$data['pegawai_id']]);
    foreach (@$data['nav_id'] as $key => $val) {
      $data_save = array(
        'pegawai_id' => @$data['pegawai_id'],
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
            'pegawai_id' => @$data['pegawai_id'],
            'nav_id' => @$val,
          ]
        );
      }
    }
    return true;
  }
}
