<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends MX_Controller
{
  var $params, $form_act;
  var $module_id, $nav_id, $module, $nav;
  var $table, $pk_id, $title, $uri, $template, $parent;
  var $search_act;
  var $nav_sess = array(
    'search' => [],
    'per_page' => 10,
    'cur_page' => 0,
    'total' => 0,
  );

  public function __construct()
  {
    parent::__construct();
    _models('app/m_app');

    if (@$this->session->userdata('login_st') != 1) redirect('app/auth/login');

    // Params
    $this->params = array(
      'callback' => null,
      'form_act' => null,
    );

    // Nav
    $this->nav_id = _get('n');
    $this->nav = $this->m_app->nav_get($this->nav_id);
    if ($this->nav == null) redirect(site_url() . '/app/dashboard?n=' . md5('00'));

    // Navigation
    $this->title = $this->nav['nav_nm'];
    $this->uri = site_url($this->nav['nav_url']);
    $this->parent = $this->nav['nav_parent'];

    // Session
    if (!@_ses_get($this->nav_id)) _ses_init([$this->nav_id => $this->nav_sess]);
    $this->nav_sess = _ses_get($this->nav_id);
    _pg_sess(['cur_page' => intval(_get('p'))]);

    //Search
    $this->search_act = site_url('app/search_init?n=' . $this->nav_id);

    // Pagination config
    $config_pagination['full_tag_open'] = '<ul class="pagination pagination-sm float-right">';
    $config_pagination['full_tag_close'] = '</ul>';
    $config_pagination['attributes'] = ['class' => 'page-link'];
    $config_pagination["first_link"] = "&Lang;";
    $config_pagination["last_link"] = "&Rang;";
    $config_pagination['first_tag_open'] = '<li class="page-item">';
    $config_pagination['first_tag_close'] = '</li>';
    $config_pagination['prev_link'] = '&lang;';
    $config_pagination['prev_tag_open'] = '<li class="page-item">';
    $config_pagination['prev_tag_close'] = '</li>';
    $config_pagination['next_link'] = '&rang;';
    $config_pagination['next_tag_open'] = '<li class="page-item">';
    $config_pagination['next_tag_close'] = '</li>';
    $config_pagination['last_tag_open'] = '<li class="page-item">';
    $config_pagination['last_tag_close'] = '</li>';
    $config_pagination['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
    $config_pagination['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
    $config_pagination['num_tag_open'] = '<li class="page-item">';
    $config_pagination['num_tag_close'] = '</li>';
    $config_pagination['num_links'] = 3;
    $this->pagination->initialize($config_pagination);
  }

  public function render($content, $data = array())
  {
    $data['identitas'] = $this->m_app->identitas_get();
    $data['nav'] = $this->nav;
    $data['nav_list'] = $this->m_app->nav_list($this->module_id);
    // var_dump($data['nav_list']);
    // die;
    $data['nav_sess'] = $this->nav_sess;

    // @load ajax
    $_is_ajax = _post('_is_ajax');
    if ($_is_ajax == true) {
      _json($this->load->view($content, $data, true));
    } else {
      $this->load->view('app/template/header', $data);
      $this->load->view('app/template/navbar', $data);
      $this->load->view($content, $data);
      $this->load->view('app/template/footer');
    }
  }
}
