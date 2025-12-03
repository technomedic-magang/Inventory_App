<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MX_Controller
{

  function __construct()
  {
    parent::__construct();
    _models(['m_app']);
  }

  function index()
  {
    $this->session->sess_destroy();
    redirect(site_url() . '/app/auth/login');
  }

  function login()
  {
    $this->session->sess_destroy();
    $data['identitas'] = $this->m_app->identitas_get();
    $this->load->view('auth/login', $data);
  }

  function login_action()
  {
    $res = $this->m_app->login();
    switch ($res) {
      case 0:
        $this->session->set_flashdata('flash_error', 'Nama Pengguna dan Kata Sandi tidak cocok.');
        redirect(site_url() . '/app/auth/login');
        break;

      case 1:
        redirect(site_url() . '/app/dashboard?n=' . md5('00'));
        break;

      case -1:
        $this->session->set_flashdata('flash_error', 'Akun tidak aktif.');
        redirect(site_url() . '/app/auth/login');
        break;

      case -2:
        $this->session->set_flashdata('flash_error', 'Akun tidak ditemukan.');
        redirect(site_url() . '/app/auth/login');
        break;

      case -3:
        $this->session->set_flashdata('flash_error', 'Token tidak valid.');
        redirect(site_url() . '/app/auth/login');
        break;

      case -4:
        $this->session->set_flashdata('flash_error', 'Parameter tidak valid.');
        redirect(site_url() . '/app/auth/login');
        break;

      case -5:
        $this->session->set_flashdata('flash_error', 'Captcha tidak cocok.');
        redirect(site_url() . '/app/auth/login');
        break;

      default:
        $this->session->set_flashdata('flash_error', 'Nama Pengguna dan Kata Sandi tidak cocok.');
        redirect(site_url() . '/app/auth/login');
        break;
    }
  }

  public function logout_action()
  {
    $this->session->sess_destroy();
    redirect(site_url() . '/app/auth/login');
  }

  public function ajax_statement($type = null, $params = null)
  {
    if ($type == 'get_captcha') {
      $this->load->helper('captcha');
      $config = array(
        'img_path'      => FCPATH . 'captcha/',
        'img_url'       => base_url('captcha'),
        'img_width'     => 120,
        'img_height'    => 30,
        'expiration'    => 7200,
        'word_length'   => 4,
        'font_size'     => 12,
        'img_id'        => 'captcha',
        'pool'          => '123456789',
        'colors'        => array(
          'background' => array(255, 255, 255),
          'border' => array(9, 132, 227),
          'text' => array(0, 0, 0),
          'grid' => array(116, 185, 255)
        )
      );

      $cap = create_captcha($config);
      $this->session->set_userdata('captchaword', $cap['word']);
      _json($cap);
    }
  }
}
