<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_app extends CI_Model
{
  function identitas_get()
  {
    $sql = "SELECT 
              a.*, b.pegawai_nm as kepala_nm
            FROM mst_identitas a
            LEFT JOIN mst_pegawai b ON a.kepala_id = b.pegawai_id";
    $query = $this->db->query($sql);
    $res = $query->row_array();
    return $res;
  }

  function login()
  {
    $d = html_escape($this->input->post());

    $res = -4;
    if (!isset($d['u']) || !isset($d['p']) || !isset($d['t']) || !isset($d['c'])) {
      $res = -4;
    } else {
      if ($d['t'] == md5(date('YmdH'))) {
        $user = $this->db->where('auth_nm', $d['u'])->get('app_user')->row_array();
        if ($user != null) {
          if ($user['active_st'] == 1) {
            if (password_verify($d['p'], $user['auth_hash'])) {
              if ($d['c'] == $this->session->userdata('captchaword')) {

                $role = DB::get('app_role', ['role_id' => $user['role_id']]);
                if ($role['role_tp'] == '01') {
                  // Pegawai
                  $pegawai = DB::get('mst_pegawai', ['user_id' => $user['user_id']]);

                  $jabatan = DB::get('mst_jabatan', ['jabatan_id' => $pegawai['jabatan_id']]);

                  // Masa Kerja
                  $tanggal_awal = $pegawai['pegawai_tmt'];
                  $tanggal_akhir = date('Y-m-d');
                  $awal = new DateTime($tanggal_awal);
                  $akhir = new DateTime($tanggal_akhir);
                  $selisih = $awal->diff($akhir);
                  $masa_kerja = $selisih->y . " Th " . $selisih->m . " Bl " . $selisih->d . " Hr";
                  // End Masa Kerja

                  $sess_data = array(
                    'login_st'       => 1,
                    'login_at'       => date('Y-m-d H:i:s'),
                    'user_id'        => $user['user_id'],
                    'user_nm'        => $pegawai['pegawai_nm'],
                    'role_id'        => $role['role_id'],
                    'role_tp'        => $role['role_tp'],
                    'role_nm'        => $role['role_nm'],
                    'pegawai_id'     => $pegawai['pegawai_id'],
                    'pegawai_nm'     => $pegawai['pegawai_nm'],
                    'jabatan_id'     => $pegawai['jabatan_id'],
                    'jabatan_nm'     => @$jabatan['jabatan_nm'],
                    'masa_kerja'     => $masa_kerja,
                  );

                  $this->session->set_userdata($sess_data);

                  $res = 1;
                }

                if ($role['role_tp'] == '02') {
                  // Magang
                  $magang = DB::get('mst_magang', ['user_id' => $user['user_id']]);

                  $sekolah = DB::get('mst_sekolah', ['sekolah_id' => $magang['sekolah_id']]);

                  $sess_data = array(
                    'login_st'       => 1,
                    'login_at'       => date('Y-m-d H:i:s'),
                    'user_id'        => $user['user_id'],
                    'user_nm'        => $magang['magang_nm'],
                    'role_id'        => $role['role_id'],
                    'role_tp'        => $role['role_tp'],
                    'role_nm'        => $role['role_nm'],
                    'magang_id'      => $magang['magang_id'],
                    'magang_nm'      => $magang['magang_nm'],
                    'jabatan_nm'     => 'MAGANG - ' . @$sekolah['sekolah_nm'],
                  );

                  $this->session->set_userdata($sess_data);

                  $res = 1;
                }
              } else {
                $res = -5;
              }
            } else {
              $res = 0;
            }
          } else {
            $res = -1;
          }
        } else {
          $res = -2;
        }
      } else {
        $res = -3;
      }
    }

    return $res;
  }

  // ====================== Start Navigation ======================
  function nav_get($nav_id)
  {
    $role_id = $this->session->userdata('role_id');
    $nav_id = $this->db->escape_str($nav_id);

    $sql = "SELECT 
                a.*, b.all_data_st 
              FROM app_nav a
              JOIN app_permission b ON a.nav_id = b.nav_id
              WHERE 
                b.role_id = '$role_id'
                AND md5(a.nav_id) = '$nav_id'";
    $query = $this->db->query($sql);
    $res = $query->row_array();
    return $res;
  }


  function nav_encrypt_get($str)
  {
    $sql = "SELECT * FROM app_nav WHERE md5(nav_id) = '$str'";
    $query = $this->db->query($sql);
    $res = $query->row_array();
    return $res;
  }

  public function nav_list($nav_parent = '')
  {
    $role_id = $this->session->userdata('role_id');

    $where = ($nav_parent != '') ? "b.nav_parent = '$nav_parent'" : "(b.nav_parent = '' OR b.nav_parent IS NULL)";
    $sql = "SELECT 
              a.role_id, a.nav_id, 
              b.nav_nm, b.nav_url, b.icon
            FROM app_permission a
            JOIN app_nav b ON a.nav_id = b.nav_id
            WHERE 
              $where
              AND a.role_id = '$role_id'
              AND b.active_st = 1
              AND a.nav_id != '00'
            ORDER BY a.nav_id";
    $query = $this->db->query($sql);
    $res = $query->result_array();

    if ($res != null) {
      foreach ($res as $key => $val) {
        $res[$key]['child'] = $this->nav_list($res[$key]['nav_id']);
      }
      return $res;
    } else {
      return array();
    }
  }
  // ====================== /End Navigation ======================
}
