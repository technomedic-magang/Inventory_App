<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
01. GENERAL FUNCTION
*/

// POST
if (!function_exists('_post')) {
	function _post($data = '', $e = '', $t = 'normal')
	{
		$CI = &get_instance();
		if ($data == '') {
			$data = html_escape($CI->input->post());
			if (array_key_exists('_is_ajax', $data)) {
				unset($data['_is_ajax'], $data['_token']);
			}
			foreach ($data as $k => $v) {
				if (!is_array($data[$k])) {
					$data[$k] = _clear_str($data[$k], $t);
				} else {
					foreach ($data[$k] as $k2 => $v2) {
						$data[$k][$k2] = _clear_str($data[$k][$k2], $t);
					}
				}
			}
		} else {
			$data = html_escape($CI->input->post($data));
			if ($e == '') $data = _e($data);
			$data = _clear_str($data, $t);
		}
		return $data;
	}
}

if (!function_exists('_clear_str')) {
	function _clear_str($str, $t = 'normal')
	{
		if ($t == 'lower') {
			$str = strtolower($str);
		}
		if ($t == 'upper') {
			$str = strtoupper($str);
		}
		$str = preg_replace('!\s+!', ' ', @trim(@$str));
		$str = ($str == " " || $str == "") ? null : $str;
		return $str;
	}
}

// GET
if (!function_exists('_get')) {
	function _get($data = '', $e = '', $r = null)
	{
		$CI = &get_instance();
		$data = $CI->input->get($data);
		if ($e == '') $data = _e($data);
		if ($r != null) if ($data == null) $data = $r;
		return $data;
	}
}

// PREVENT INJECTION
if (!function_exists('_e')) {
	function _e($val = '')
	{

		if (is_array($val)) {
			foreach ($val as $k => $v) {
				$res = trim($v);
				$res = str_replace("'", "`", $res);
				$res = str_replace('"', "`", $res);
				$res = htmlentities($res);
				$res = strip_tags($res);
				$res = html_escape($res);

				$val[$k] = $res;
			}
		} else {
			$val = trim($val);
			$val = str_replace("'", "`", $val);
			$val = str_replace('"', "`", $val);
			$val = htmlentities($val);
			$val = strip_tags($val);
			$val = html_escape($val);
		}

		return $val;
	}
}

// REDIRECT
if (!function_exists('_to')) {
	function _to($uri, $type = null)
	{
		$_is_ajax = _post('_is_ajax');
		if ($_is_ajax == true) {
			_json($uri);
		} else {
			if ($type != '') {
				redirect($uri, $type);
			} else {
				redirect($uri);
			}
		}
	}
}


// JSON
if (!function_exists('_json')) {
	function _json($data)
	{
		header('Content-Type: application/json');
		echo json_encode($data);
	}
}


// NOW DATE
if (!function_exists('_now')) {
	function _now()
	{
		date_default_timezone_set("Asia/Jakarta");
		return date('Y-m-d H:i:s');
	}
}

/*
02. MVC
*/

// LOAD MODELS
if (!function_exists('_models')) {
	function _models($data)
	{
		$CI = &get_instance();
		return $CI->load->model($data);
	}
}

// LOAD VIEW
if (!function_exists('_view')) {
	function _view($template, $data = null, $type = null)
	{
		$CI = &get_instance();
		if ($type != null) {
			return $CI->load->view($template, $data, $type);
		} else {
			return $CI->load->view($template, $data);
		}
	}
}

/*
03. SESSION
*/

// SESSION SET
if (!function_exists('_ses_init')) {
	function _ses_init($data)
	{
		$CI = &get_instance();
		$CI->session->set_userdata($data);
	}
}

if (!function_exists('_hapus_sebutan')) {
	function _hapus_sebutan($string)
	{
		$data = preg_replace('/,?\s*(NY|TN|SDR|AN|BY|NN)$/', '', $string);
		return $data;
	}
}
// SESSION GET
if (!function_exists('_ses_get')) {
	function _ses_get($data)
	{
		$CI = &get_instance();
		$data = $CI->session->userdata($data);
		return $data;
	}
}

// SESSION UNSET
if (!function_exists('_ses_clear')) {
	function _ses_clear($data)
	{
		$CI = &get_instance();
		$CI->session->unset_userdata($data);
	}
}

// SESSION DESTROY
if (!function_exists('_ses_destroy')) {
	function _ses_destroy()
	{
		$CI = &get_instance();
		$CI->session->sess_destroy();
	}
}

/*
04. TOKEN
*/

// TOKEN
if (!function_exists('_token')) {
	function _token($key = 'INDOTECHNOMEDIC')
	{
		$var = $key . '-' . _now();
		_ses_init(array(
			'_ses_token' => md5(md5($var))
		));
		$_token = _ses_get('_ses_token');
		return $_token;
	}
}

// VALID TOKEN
if (!function_exists('_validate_token')) {
	function _validate_token()
	{
		// if (_post('_token') == '') {
		// 	_to('app/dashboard');
		// }
	}
}


/*
05. CUSTOM
*/

// RESPONSE
if (!function_exists('_response')) {
	function _response($code = null, $uri = null, $data = null)
	{
		$response = array(
			// TRUE
			'00' => array(
				'status' => true,
				'message' => 'Data berhasil diproses.',
				'uri' => $uri,
				'data' => $data,
			),
			'01' => array(
				'status' => true,
				'message' => 'Data berhasil disimpan.',
				'uri' => $uri,
				'data' => $data,
			),
			'02' => array(
				'status' => true,
				'message' => 'Data berhasil diubah.',
				'uri' => $uri,
				'data' => $data,
			),
			'03' => array(
				'status' => true,
				'message' => 'Data berhasil dihapus.',
				'uri' => $uri,
				'data' => $data,
			),
			'04' => array(
				'status' => true,
				'message' => 'Tindak Lanjut berhasil dibatalkan.',
				'uri' => $uri,
				'data' => $data,
			),
			'09' => array(
				'status' => true,
				'message' => @$data['message'],
				'uri' => $uri,
				'data' => $data,
			),
			// FALSE
			'10' => array(
				'status' => false,
				'message' => 'Data gagal diproses !',
				'uri' => $uri,
				'data' => $data,
			),
			'11' => array(
				'status' => false,
				'message' => 'Data gagal disimpan !',
				'uri' => $uri,
				'data' => $data,
			),
			'12' => array(
				'status' => false,
				'message' => 'Data gagal diubah !',
				'uri' => $uri,
				'data' => $data,
			),
			'13' => array(
				'status' => false,
				'message' => 'Data gagal dihapus !',
				'uri' => $uri,
				'data' => $data,
			),
			'14' => array(
				'status' => false,
				'message' => 'Tindak Lanjut gagal dibatalkan !',
				'uri' => $uri,
				'data' => $data,
			),
			'15' => array(
				'status' => false,
				'message' => 'File gagal diunggah',
				'uri' => $uri,
				'data' => $data,
			),
			'20' => array(
				'status' => false,
				'message' => 'Terjadi duplikasi kode !',
				'uri' => $uri,
				'data' => $data,
			),
			'29' => array(
				'status' => false,
				'message' => @$data['message'],
				'uri' => $uri,
				'data' => $data,
			),
		);
		return $response[$code];
	}
}

if (!function_exists('_yesno')) {
	function _yesno($key = null)
	{
		$data = array('0' => 'Tidak', 'Ya');
		return $data[$key];
	}
}

// TERBILANG
if (!function_exists('_terbilang')) {
	function _terbilang($x)
	{
		$x = abs((int) $x);
		if ($x >= 0) {

			$abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
			if ($x < 12) {
				return " " . $abil[$x];
			} elseif ($x < 20) {
				return _terbilang($x - 10) . " Belas";
			} elseif ($x < 100) {
				return _terbilang($x / 10) . " Puluh" . _terbilang($x % 10);
			} elseif ($x < 200) {
				return " Seratus" . _terbilang($x - 100);
			} elseif ($x < 1000) {
				return _terbilang($x / 100) . " Ratus" . _terbilang($x % 100);
			} elseif ($x < 2000) {
				return " Seribu" . _terbilang($x - 1000);
			} elseif ($x < 1000000) {
				return _terbilang($x / 1000) . " Ribu" . _terbilang($x % 1000);
			} elseif ($x < 1000000000) {
				return _terbilang($x / 1000000) . " Juta" . _terbilang($x % 1000000);
			} else {
				return '';
			}
		}
	}
}

/*
06. ICONS
*/
if (!function_exists('_icon')) {
	function _icon($x)
	{
		$data = array(
			'add' => '<i class="fas fa-plus ms-1 me-2"></i>',
			'list' => '<i class="fas fa-list text-success ms-1 me-2"></i>',
			'edit' => '<i class="fas fa-pencil-alt text-warning ms-1 me-2"></i>',
			'trash' => '<i class="fas fa-trash-alt text-danger ms-1 me-2"></i>',
			'save' => '<i class="fas fa-save ms-1 me-2"></i>',
			'cancel' => '<i class="fas fa-times ms-1 me-2"></i>',
			'cog' => '<i class="fas fa-cog ms-1 me-2"></i>',
			'bullhorn' => '<i class="fas fa-bullhorn ms-1 me-2"></i>',
			'print' => '<i class="fas fa-print ms-1 me-2"></i>',
			'sync' => '<i class="fas fa-sync ms-1 me-2"></i>',
			'search' => '<i class="fas fa-search ms-1 me-2"></i>',
			'copy' => '<i class="fas fa-copy ms-1 me-2"></i>',
			'plane' => '<i class="fas fa-plane text-success ms-1 me-2"></i>',
			'file-invoice' => '<i class="fas fa-file-invoice text-primary ms-1 me-2"></i>',
			'plus' => '<i class="fas fa-plus ms-1 me-2"></i>',
			'plus-square' => '<i class="fas fa-plus-square" ms-1 me-2"></i>',
			'check' => '<i class="fas fa-check ms-1 me-2"></i>',
			'eye' => '<i class="fas fa-eye ms-1 me-2"></i>',
			'receipt' => '<i class="fas fa-receipt ms-1 me-2 text-success"></i>',
		);
		return @$data[$x];
	}
}

/*
07. PAGINATION
*/
if (!function_exists('_pg_set')) {
	function _pg_set($nav)
	{
		$CI = get_instance();
		$s = _ses_get(md5($nav['nav_id']));

		$config['reuse_query_string'] = true;
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['query_string_segment'] = 'p';
		$config['use_page_numbers'] = true;
		$config['per_page'] = $s['per_page'];
		$config['base_url'] = site_url() . '/' . $nav['nav_url'];
		$config['total_rows'] = $s['total'];

		$CI->pagination->initialize($config);
	}
}

if (!function_exists('_pg_sess')) {
	function _pg_sess($data)
	{
		$s = _ses_get(_get('n'));
		foreach ($data as $k => $v) {
			$s[$k] = $v;
		}
		_ses_init([_get('n') => $s]);
	}
}

if (!function_exists('_pg_no')) {
	function _pg_no($no)
	{
		$s = _ses_get(_get('n'));
		if (@$s['cur_page'] == 0 || @$s['cur_page'] == 1) {
			return $no;
		} else {
			return (@$s['cur_page'] - 1) * @$s['per_page'] + $no;
		}
	}
}

if (!function_exists('_pg_info')) {
	function _pg_info()
	{
		$CI = get_instance();
		$s = _ses_get(_get('n'));

		if (@$s['cur_page'] == 0 || @$s['cur_page'] == 1) {
			$start = 1;
		} else {
			$start = ($s['cur_page'] - 1) * $s['per_page'];
		}
		$end = $start + @$s['per_page'];
		$end = ($end > $s['total']) ? $s['total'] : $end;
		$count = '<small class="pt-1"><i class="fas fa-eye"></i> ' . $start . ' s/d ' . $end . ' dari ' . @$s['total'] . '</small>';

		$info = '<div class="btn-list pb-3">';
		$info .= '	<small class="pt-1"><i class="fas fa-file"></i> Perhalaman </small> ';
		$info .= '	<div class="dropdown">';
		$info .= '		<button class="btn btn-sm btn-default dropdown-toggle align-text-top" data-bs-toggle="dropdown">';
		$info .= '			' . intval(@$s['per_page']);
		$info .= '		</button>';
		$info .= '		<div class="dropdown-menu">';
		$info .= '			<a class="dropdown-item p-1" href="javascript:void(0)" onclick="_perpage(\'10\',\'' . _get('n') . '\')">10</a>';
		$info .= '			<a class="dropdown-item p-1" href="javascript:void(0)" onclick="_perpage(\'100\',\'' . _get('n') . '\')">100</a>';
		$info .= '			<a class="dropdown-item p-1" href="javascript:void(0)" onclick="_perpage(\'1000\',\'' . _get('n') . '\')">1000</a>';
		$info .= '			<a class="dropdown-item p-1" href="javascript:void(0)" onclick="_perpage(\'10000\',\'' . _get('n') . '\')">10000</a>';
		$info .= '		</div>';
		$info .= '	</div>';
		$info .= $count;
		$info .= '</div>';

		$html = '<div class="row mt-3 me-2">';
		$html .= '	<div class="col-lg-6 col-md-6 align-middle ps-3">' . $info . '</div>';
		$html .= '	<div class="col-lg-6 col-md-6">';
		$html .= '		<div class="float-end">' . $CI->pagination->create_links() . '</div>';
		$html .= '	</div>';
		$html .= '</div>';

		return $html;
	}
}

if (!function_exists('_pg_limit')) {
	function _pg_limit()
	{
		$s = _ses_get(_get('n'));
		if (@$s['cur_page'] == 0 || @$s['cur_page'] == 1) {
			return " LIMIT " . intval(@$s['per_page']) . " OFFSET 0";
		} else {
			return " LIMIT " . intval(@$s['per_page']) . " OFFSET " . intval((@$s['cur_page'] - 1) * @$s['per_page']);
		}
	}
}

if (!function_exists('hash_password')) {
	function hash_password($str)
	{
		if ($str == "") $str = date('Y-m-d H:i:s');
		$result = password_hash($str, PASSWORD_BCRYPT);
		return $result;
	}
}

if (!function_exists('get_bulan')) {
	function get_bulan($bln)
	{
		switch ($bln) {
			case 1:
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}
}

if (!function_exists('to_date')) {
	function to_date($date = null, $sp = null, $tp = null, $sp2 = null)
	{
		if ($date != '' && $date != null) {
			if ($tp == 'date') {
				$arr_date = explode(' ', $date);
				$date = $arr_date[0];
			} elseif ($tp == 'full_date') {
				$arr_date = explode(' ', $date);
				$date = $arr_date[0];
				$time = $arr_date[1];
			} elseif ($tp == 'time') {
				$arr_date = explode(' ', $date);
				$time = $arr_date[1];
			} elseif ($tp == 'hour_minute') {
				$arr_date = explode(' ', $date);
				$time = $arr_date[1];
				$arr_time = explode(':', $time);
				$hour = @$arr_time[0];
				$minute = @$arr_time[1];
			} elseif ($tp == 'only_day_month_name') {
				$arr_date = explode(' ', $date);
				$date = $arr_date[0];
			} elseif ($tp == 'only_year') {
				$arr_date = explode(' ', $date);
				$date = $arr_date[0];
			} elseif ($tp == 'only_day') {
				$arr_date = explode(' ', $date);
				$date = $arr_date[0];
			} elseif ($tp == 'date_hour_minute') {
				$arr_date = explode(' ', $date);
				$date = $arr_date[0];
				$time = $arr_date[1];
				$arr_time = explode(':', $time);
				$hour = @$arr_time[0];
				$minute = @$arr_time[1];
			}
			$arr = explode('-', $date);
			if (@$arr[2] == '') {
				$arr = explode('/', $date);
			}
			if ($sp != '') {
				$result = $arr[2] . $sp . $arr[1] . $sp . $arr[0];
			} else {
				$result = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
			}
			if ($tp == 'full_date') {
				if ($sp2 != '') {
					$result .= $sp2 . $time;
				} else {
					$result .= ' ' . $time;
				}
			}
			if ($tp == 'time') {
				$result = $time;
			}
			if ($tp == 'hour_minute') {
				$result = $hour . ':' . $minute;
			}
			if ($tp == 'only_year') {
				$result = $arr[0];
			}
			if ($tp == 'only_month') {
				$result = $arr[1];
			}
			if ($tp == 'only_day') {
				$result = $arr[2];
			}
			if ($tp == 'only_day_month_name') {
				if ($sp != null) {
					$result = $arr[2] . $sp . get_bulan($arr[1]);
				} else {
					$result = $arr[2] . '-' . $arr[1];
				}
			}
			if ($tp == 'date_hour_minute') {
				$result .= ' ' . $hour . ':' . $minute;
			}
		} else {
			$result = null;
		}

		if ($result == '00-00-0000' || $result == '0000-00-00' || $result == '00-00-0000 00:00:00' || $result == '0000-00-00 00:00:00') {
			$result = null;
		}

		return $result;
	}
}

if (!function_exists('ifConDate')) {
	function ifConDate($val = '', $elseVal = '', $typeDate = 'full_date')
	{
		if (@$val != '' || @$val != null) {
			if (@$val != '0000-00-00 00:00:00') {
				$res = to_date($val, '-', $typeDate);
			} else {
				$res = $elseVal;
			}
		} else {
			$res = $elseVal;
		}
		return $res;
	}
}

if (!function_exists('to_date_indo')) {
	function to_date_indo($tgl = '', $type = '', $sp = '', $wib = true)
	{
		if ($tgl != '') {
			$tanggal = substr($tgl, 8, 2);
			$jam = substr($tgl, 11, 8);
			$hour = substr($tgl, 11, 2);
			$minute = substr($tgl, 14, 2);
			$second = substr($tgl, 17, 2);
			$bulan = get_bulan(substr($tgl, 5, 2));
			$tahun = substr($tgl, 0, 4);
			if ($type == 'date') {
				if ($sp != '') {
					return $tanggal . $sp . $bulan . $sp . $tahun;
				} else {
					return $tanggal . ' ' . $bulan . ' ' . $tahun;
				}
			} elseif ($type == 'date_hour_minute') {
				return $tanggal . ' ' . $bulan . ' ' . $tahun . ' ' . $hour . ':' . $minute;
			} else {
				if ($jam != '') {
					if ($sp != '') {
						if ($wib == false) {
							return $tanggal . $sp . $bulan . $sp . $tahun . $sp . $jam;
						} else {
							return $tanggal . $sp . $bulan . $sp . $tahun . $sp . $jam . ' WIB';
						}
					} else {
						if ($wib == false) {
							return $tanggal . ' ' . $bulan . ' ' . $tahun . ' ' . $jam;
						} else {
							return $tanggal . ' ' . $bulan . ' ' . $tahun . ' ' . $jam . ' WIB';
						}
					}
				} else {
					if ($sp != '') {
						return $tanggal . $sp . $bulan . $sp . $tahun;
					} else {
						return $tanggal . ' ' . $bulan . ' ' . $tahun;
					}
				}
			}
		}
	}
}
if (!function_exists('date_dayname')) {
	function date_dayname($id = null)
	{
		$arr = array(
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu',
		);
		if ($id != '') return $arr[$id];
		else return $arr;
	}
}
if (!function_exists('to_dayname')) {
	function to_dayname($date = null)
	{
		if ($date == '') $date = date('Y-m-d');
		$datetime = DateTime::createFromFormat('Y-m-d', $date);
		$dayindex = $datetime->format('D');
		$dayname  = @date_dayname($dayindex);
		//
		$result = $dayname;
		return $result;
	}
}
/*
08. FORM
*/
if (!function_exists('_frm_select')) {
	function _frm_select($field = null, $data = null, $val_key = null, $val_str = null, $val_selected = null, $val_empty = null, $attribute = null)
	{
		$html = '<select id="' . $field . '" name="' . $field . '" ' . $attribute . '>';
		$option = '';
		if ($val_empty != '') {
			$option .= '<option value="">' . $val_empty . '</option>';
		}
		foreach ($data as $r) {
			$_key = $r[$val_key];
			$_str = "";
			$_arr_str = explode(' - ', $val_str);
			if (count($_arr_str) > 0) {
				foreach ($_arr_str as $kstr => $vstr) {
					if ($kstr > 0) $_str .= " - ";
					$_str .= $r[$vstr];
				}
			} else {
				$_str = $r[$val_str];
			}
			$option .= '<option value="' . $_key . '" ' . (($_key == $val_selected) ? 'selected' : '') . '>' . $_str . '</option>';
		}
		$html .= $option;
		$html .= '</select>';
		return $html;
	}
}

if (!function_exists('_frm_unset')) {
	function _frm_unset($data, $field)
	{
		foreach ($field as $k => $v) {
			unset($data[$v]);
		}
		return $data;
	}
}

if (!function_exists('empty_to_null')) {
	function empty_to_null($data)
	{
		if (@$data == '') {
			$data = null;
		} else {
			$data = @$data;
		}
		return $data;
	}
}

if (!function_exists('folder_exist')) {
	function folder_exist($folder)
	{
		// Get canonicalized absolute pathname
		$path = realpath($folder);

		// If it exist, check if it's a directory
		if ($path !== false and is_dir($path)) {
			// Return canonicalized absolute pathname
			return $path;
		}

		// Path/folder does not exist
		return false;
	}
}

if (!function_exists('upload_file')) {
	function upload_file($folder, $allowed_types = null, $field)
	{
		$CI = &get_instance();
		if ($allowed_types == null) $allowed_types =  'gif|jpg|jpeg|png|doc|docx|pdf|xls|xlsx';

		$arr_folder = explode('/', $folder);
		$upload_path = $CI->config->item('upload_root_folder');
		if (count($arr_folder) > 0) {
			for ($i = 0; $i < count($arr_folder); $i++) {
				$upload_path .= $arr_folder[$i] . '/';
				if (!folder_exist($upload_path)) {
					mkdir($upload_path);
				}
			}
		} else {
			$upload_path .= $folder . '/';
			if (!folder_exist($upload_path)) {
				mkdir($upload_path);
			}
		}


		$config['upload_path']          = $upload_path;
		$config['allowed_types']        = $allowed_types;
		$config['overwrite']            = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;

		$CI->load->library('upload', $config);

		if (!$CI->upload->do_upload($field)) {
			$data['error'] = $CI->upload->display_errors();
			return array(
				'status' => false,
				'error' => $data['error']
			);
		} else {
			$uploaded_data = $CI->upload->data();
			return array(
				'status' => true,
				'data' => $uploaded_data,
			);
		}
	}
}

if (!function_exists('upload_base64')) {
	function upload_base64($field)
	{
		if (isset($_FILES[$field])) {
			if ($_FILES[$field]['name'] != "") {
				$tmp = $_FILES[$field]['tmp_name'];
				$type = $_FILES[$field]['type'];
				$data = file_get_contents($tmp);
				$base64 = 'data:' . $type . ';base64,' . base64_encode($data);
				return $base64;
			}
		} else {
			return null;
		}
	}
}

if (!function_exists('base64_to_jpeg')) {
	function base64_to_jpeg($base64_string, $output_file)
	{
		// open the output file for writing
		$ifp = fopen($output_file, 'wb');

		// split the string on commas
		// $data[ 0 ] == "data:image/png;base64"
		// $data[ 1 ] == <actual base64 string>
		$data = explode(',', $base64_string);

		// we could add validation here with ensuring count( $data ) > 1
		fwrite($ifp, base64_decode($data[1]));

		// clean up the file resource
		fclose($ifp);

		return $output_file;
	}
}

if (!function_exists('get_file')) {
	function get_file($folder, $file_name = null)
	{
		$CI = &get_instance();
		$file_path = $CI->config->item('upload_root_folder');
		$arr_folder = explode('-', $folder);
		if (count($arr_folder) > 0) {
			for ($i = 0; $i < count($arr_folder); $i++) {
				$file_path .= $arr_folder[$i] . '/';
			}
		} else {
			$file_path .= $folder . '/';
		}
		$file_path .= $file_name;
		// echo $file_path;
		// die;
		if (file_exists($file_path)) {
			$mime = mime_content_type($file_path);
			header('Content-type: ' . $mime);
			readfile($file_path);
		} else {
			echo "File not found!";
		};
	}
}

if (!function_exists('where_array')) {
	function where_array($arr = [])
	{
		$result = [];
		foreach ($arr as $key => $val) {
			$result = array_merge($result, $val);
		}
		return $result;
	}
}

if (!function_exists('num_clear')) {
	function num_clear($val = null)
	{
		$result = str_replace('.', '', $val);
		$result = str_replace(',', '.', $result);
		if (strpos($val, ',')) {
			return floatval($result);
		} else {
			return intval($result);
		}
	}
}

if (!function_exists('num_id')) {
	function num_id($v, $s = null)
	{
		if ($v != '') {
			if (is_numeric($v)) {
				$res = number_format($v, 0, ",", ".");
				if ($s != null && $v == 0) return $s;
				else return $res;
			} else {
				return $s;
			}
		} else {
			return 0;
		}
	}
}

if (!function_exists('float_id')) {
	function float_id($v, $s = null, $limit = 2)
	{
		$raw = explode('.', $v);
		$fraction = "";
		$fraction = (count($raw) == 2) ? "," . str_pad($raw[1], 2, '0', STR_PAD_RIGHT) : ",00";
		$fraction = substr($fraction, 0, ($limit + 1));
		if ($v != '') {
			if (is_numeric($v)) {
				$res = number_format($raw[0], 0, ",", ".");
				if ($s != null && $raw[0] == 0)
					return $s;
				else
					return $res . $fraction;
			} else {
				return $s . ",00";
			}
		} else {
			return "0" . ",00";
		}
	}
}

if (!function_exists('vclaim_config')) {
	function vclaim_config()
	{
		$CI = &get_instance();
		// $CI->db->where(['config_id' => 1]);
		$config = $CI->db->get('conf_bridging')->row_array();
		$vclaim_config = [
			'cons_id' => bridging_config_decrypt($config['vclaim_cons_id']),
			'secret_key' => bridging_config_decrypt($config['vclaim_secret_key']),
			'base_url' => bridging_config_decrypt($config['vclaim_base_url']),
			'service_name' => bridging_config_decrypt($config['vclaim_service_name']),
			'user_key' => bridging_config_decrypt($config['vclaim_user_key']),
		];
		return $vclaim_config;
	}
}

if (!function_exists('antrean_config')) {
	function antrean_config()
	{
		$CI = &get_instance();
		// $CI->db->where(['config_id' => 1]);
		$config = $CI->db->get('conf_bridging')->row_array();
		$antrean_config = [
			'cons_id' => bridging_config_decrypt($config['antrean_cons_id']),
			'secret_key' => bridging_config_decrypt($config['antrean_secret_key']),
			'base_url' => bridging_config_decrypt($config['antrean_base_url']),
			'service_name' => bridging_config_decrypt($config['antrean_service_name']),
			'user_key' => bridging_config_decrypt($config['antrean_user_key']),
		];
		return $antrean_config;
	}
}

if (!function_exists('aplicare_config')) {
	function aplicare_config()
	{
		$CI = &get_instance();
		// $CI->db->where(['config_id' => 1]);
		$config = $CI->db->get('conf_bridging')->row_array();
		$aplicare_config = [
			'cons_id' => bridging_config_decrypt($config['aplicare_cons_id']),
			'secret_key' => bridging_config_decrypt($config['aplicare_secret_key']),
			'kode_ppk' => bridging_config_decrypt($config['aplicare_kode_ppk']),
			'base_url' => bridging_config_decrypt($config['aplicare_base_url']),
			'service_name' => bridging_config_decrypt($config['aplicare_service_name']),
			'user_key' => bridging_config_decrypt($config['aplicare_user_key']),
		];
		return $aplicare_config;
	}
}

if (!function_exists('satusehat_config')) {
	function satusehat_config()
	{
		$CI = &get_instance();
		// $CI->db->where(['config_id' => 1]);
		$config = $CI->db->get('conf_bridging')->row_array();
		$satusehat_config = [
			'auth_url' => bridging_config_decrypt($config['satusehat_auth_url']),
			'base_url' => bridging_config_decrypt($config['satusehat_base_url']),
			'consent_url' => bridging_config_decrypt($config['satusehat_consent_url']),
			'organization_id' => bridging_config_decrypt($config['satusehat_organization_id']),
			'client_id' => bridging_config_decrypt($config['satusehat_client_id']),
			'client_secret' => bridging_config_decrypt($config['satusehat_client_secret']),
			'access_token' => $config['satusehat_access_token'],
			'expired_token' => $config['satusehat_expired_token'],
		];
		return $satusehat_config;
	}
}

if (!function_exists('bpjs_service_aplicare')) {
	function bpjs_service_aplicare($method = null, $url = null, $data_str = null)
	{
		$CI = get_instance();
		$conf = aplicare_config();

		$data = $conf['cons_id'];
		$secretKey = $conf['secret_key'];
		$userKey = $conf['user_key'];

		date_default_timezone_set('UTC');
		$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
		$signature = hash_hmac('sha256', $data . "&" . $tStamp, $secretKey, true);

		// base64 encode…
		$encodedSignature = base64_encode($signature);
		$base_url = $conf['base_url'];
		$service_name = $conf['service_name'];

		$url_str = $base_url . $service_name . '/' . $url;

		$curl = curl_init();

		$curl_conf = array(
			CURLOPT_URL => "$url_str",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "$method",
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_HTTPHEADER => array(
				"X-cons-id: $data",
				"X-timestamp: $tStamp",
				"X-signature: $encodedSignature",
				"user_key: $userKey"
			)
		);

		if ($method == 'POST') {
			$curl_conf[CURLOPT_POSTFIELDS] = "$data_str";
			$curl_conf[CURLOPT_HTTPHEADER] = array(
				"X-cons-id: $data",
				"X-timestamp: $tStamp",
				"X-signature: $encodedSignature",
				"user_key: $userKey",
				"Content-Type: application/json"
			);
		}

		curl_setopt_array($curl, $curl_conf);

		$response = curl_exec($curl);

		curl_close($curl);

		return $response;
	}
}

if (!function_exists('icon_pasien')) {
	function icon_pasien($sex_id = '')
	{
		$result = base_url() . 'assets/icons/male.png';
		if ($sex_id == 'L') {
			$result = base_url() . 'assets/icons/male.png';
		} elseif ($sex_id == 'P') {
			$result = base_url() . 'assets/icons/female.png';
		}
		return $result;
	}
}

if (!function_exists('hitung_umur')) {
	function hitung_umur($date, $res)
	{
		$birthDate = new DateTime($date);
		$today = new DateTime("today");
		if ($birthDate > $today) {
			exit("0 th 0 bln 0 hr");
		}
		$y = $today->diff($birthDate)->y;
		$m = $today->diff($birthDate)->m;
		$d = $today->diff($birthDate)->d;
		if ($res == 'years') {
			$result = array(
				'years' => $y,
			);
		} else if ($res == 'months') {
			$result = array(
				'months' => $m,
			);
		} else if ($res == 'days') {
			$result = array(
				'days' => $d,
			);
		} else {
			$result = $y . " th " . $m . " bln " . $d . " hr";
		}
		return $result;
	}
}

if (!function_exists('all_parameter')) {
	function all_parameter($parameter_field = null)
	{
		$res = DB::all('mst_parameter', ['parameter_field' => $parameter_field]);
		return $res;
	}
}

if (!function_exists('get_parameter')) {
	function get_parameter($parameter_field = null)
	{
		$res = DB::get('mst_parameter', ['parameter_field' => $parameter_field]);
		return @$res['parameter_val'];
	}
}

if (!function_exists('get_lokasi')) {
	function get_lokasi($lokasi_map = null)
	{
		$res = DB::raw('row_array', "SELECT * FROM mst_lokasi WHERE lokasi_map = ? ORDER BY lokasi_id DESC LIMIT 1", $lokasi_map);
		return $res;
	}
}

if (!function_exists('get_master')) {
	function get_master($table = null, $field = null, $value = null)
	{
		$res = DB::raw('row_array', "SELECT * FROM $table WHERE $field = ? LIMIT 1", $value);
		return $res;
	}
}

if (!function_exists('bridging_config_decrypt')) {
	function bridging_config_decrypt($value)
	{
		$CI = &get_instance();
		// @encrypt
		$CI->load->library('encryption');
		$CI->encryption->initialize(
			array(
				'cipher' => 'aes-256',
				'mode' => 'ctr',
				'key' => $CI->config->item('encryption_key'),
			)
		);

		return $CI->encryption->decrypt($value);
	}
}

if (!function_exists('eklaim_config')) {
	function eklaim_config()
	{
		$CI = &get_instance();
		// $CI->db->where(['config_id' => 1]);
		$config = $CI->db->get('conf_bridging')->row_array();
		$eklaim_config = [
			'eklaim_base_url' => bridging_config_decrypt($config['eklaim_base_url']),
			'eklaim_encryption_key' => bridging_config_decrypt($config['eklaim_encryption_key']),
			'eklaim_kode_rs' => bridging_config_decrypt($config['eklaim_kode_rs']),
			'eklaim_username' => bridging_config_decrypt($config['eklaim_username']),
			'eklaim_password' => bridging_config_decrypt($config['eklaim_password']),
			'eklaim_kode_tarif' => bridging_config_decrypt($config['eklaim_kode_tarif']),
			'eklaim_coder_nik' => bridging_config_decrypt($config['eklaim_coder_nik']),
		];
		return $eklaim_config;
	}
}

if (!function_exists('eklaim_config_pragrouper')) {
	function eklaim_config_pragrouper()
	{
		$CI = &get_instance();
		// $CI->db->where(['config_id' => 1]);
		$config = $CI->db->get('conf_bridging')->row_array();
		$eklaim_config = [
			'eklaim_base_url_pragrouper' => bridging_config_decrypt($config['eklaim_base_url_pragrouper']),
			'eklaim_encryption_key_pragrouper' => bridging_config_decrypt($config['eklaim_encryption_key_pragrouper']),
			'eklaim_kode_rs_pragrouper' => bridging_config_decrypt($config['eklaim_kode_rs_pragrouper']),
			'eklaim_username_pragrouper' => bridging_config_decrypt($config['eklaim_username_pragrouper']),
			'eklaim_password_pragrouper' => bridging_config_decrypt($config['eklaim_password_pragrouper']),
			'eklaim_kode_tarif_pragrouper' => bridging_config_decrypt($config['eklaim_kode_tarif_pragrouper']),
			'eklaim_coder_nik_pragrouper' => bridging_config_decrypt($config['eklaim_coder_nik_pragrouper']),
		];
		return $eklaim_config;
	}
}

if (!function_exists('inacbg_encrypt')) {
	function inacbg_encrypt($data, $key)
	{
		/// make binary representasion of $key
		$key = hex2bin($key);
		/// check key length, must be 256 bit or 32 bytes
		if (mb_strlen($key, "8bit") !== 32) {
			throw new Exception("Needs a 256-bit key!");
		}
		/// create initialization vector
		$iv_size = openssl_cipher_iv_length("aes-256-cbc");
		$iv = openssl_random_pseudo_bytes($iv_size); // dengan catatan dibawah
		/// encrypt
		$encrypted = openssl_encrypt(
			$data,
			"aes-256-cbc",
			$key,
			OPENSSL_RAW_DATA,
			$iv
		);
		/// create signature, against padding oracle attacks
		$signature = mb_substr(hash_hmac(
			"sha256",
			$encrypted,
			$key,
			true
		), 0, 10, "8bit");
		/// combine all, encode, and format
		$encoded = chunk_split(base64_encode($signature . $iv . $encrypted));
		return $encoded;
	}
}

if (!function_exists('inacbg_decrypt')) {
	function inacbg_decrypt($str, $strkey)
	{
		/// make binary representation of $key
		$key = hex2bin($strkey);
		/// check key length, must be 256 bit or 32 bytes
		if (mb_strlen($key, "8bit") !== 32) {
			throw new Exception("Needs a 256-bit key!");
		}
		/// calculate iv size
		$iv_size = openssl_cipher_iv_length("aes-256-cbc");
		/// breakdown parts
		$decoded = base64_decode($str);
		$signature = mb_substr($decoded, 0, 10, "8bit");
		$iv = mb_substr($decoded, 10, $iv_size, "8bit");
		$encrypted = mb_substr($decoded, $iv_size + 10, NULL, "8bit");
		/// check signature, against padding oracle attack
		$calc_signature = mb_substr(hash_hmac(
			"sha256",
			$encrypted,
			$key,
			true
		), 0, 10, "8bit");
		if (!inacbg_compare($signature, $calc_signature)) {
			return "SIGNATURE_NOT_MATCH"; /// signature doesn't match
		}

		$decrypted = openssl_decrypt(
			$encrypted,
			"aes-256-cbc",
			$key,
			OPENSSL_RAW_DATA,
			$iv
		);
		return $decrypted;
	}
}

if (!function_exists('inacbg_compare')) {
	function inacbg_compare($a, $b)
	{
		/// compare individually to prevent timing attacks

		/// compare length
		if (strlen($a) !== strlen($b)) return false;

		/// compare individual
		$result = 0;
		for ($i = 0; $i < strlen($a); $i++) {
			$result |= ord($a[$i]) ^ ord($b[$i]);
		}

		return $result == 0;
	}
}

if (!function_exists('inacbg_service')) {
	function inacbg_service($request)
	{
		$CI = get_instance();
		$conf = eklaim_config();

		// contoh encryption key, bukan aktual
		$key = $conf['eklaim_encryption_key'];
		// membuat json juga dapat menggunakan json_encode:
		$ws_query["metadata"] = $request['metadata'];
		$ws_query["data"] = $request['data'];

		$json_request = json_encode($ws_query);
		// data yang akan dikirimkan dengan method POST adalah encrypted:
		//   if ($conf['eklaim_environment'] == 'debug') {
		// 	$payload = $json_request;
		//   }
		//   if ($conf['eklaim_environment'] == 'production') {
		$payload = inacbg_encrypt($json_request, $key);
		//   }

		// tentukan Content-Type pada http header
		$header = array("Content-Type: application/x-www-form-urlencoded");
		// url server aplikasi E-Klaim,
		// silakan disesuaikan instalasi masing-masing
		$url = $conf['eklaim_base_url'];

		// setup curl
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		// request dengan curl
		$response = curl_exec($ch);

		//   if ($conf['eklaim_environment'] == 'debug') {
		// 	$msg = json_decode($response, true);
		// 	return $msg;
		//   }
		//   if ($conf['eklaim_environment'] == 'production') {
		// terlebih dahulu hilangkan "----BEGIN ENCRYPTED DATA----\r\n"
		// dan hilangkan "----END ENCRYPTED DATA----\r\n" dari response
		$first = strpos($response, "\n") + 1;
		$last = strrpos($response, "\n") - 1;
		$response = substr(
			$response,
			$first,
			strlen($response) - $first - $last
		);
		// decrypt dengan fungsi inacbg_decrypt
		$response = inacbg_decrypt($response, $key);
		// hasil decrypt adalah format json, ditranslate kedalam array
		$msg = json_decode($response, true);
		return $msg;
		//   }
	}
}


if (!function_exists('inacbg_service_pragrouper')) {
	function inacbg_service_pragrouper($request)
	{
		$CI = get_instance();
		$conf = eklaim_config_pragrouper();

		// contoh encryption key, bukan aktual
		$key = $conf['eklaim_encryption_key_pragrouper'];
		// membuat json juga dapat menggunakan json_encode:
		$ws_query["metadata"] = $request['metadata'];
		$ws_query["data"] = $request['data'];

		$json_request = json_encode($ws_query);
		// data yang akan dikirimkan dengan method POST adalah encrypted:
		//   if ($conf['eklaim_environment_pragrouper'] == 'debug') {
		// 	$payload = $json_request;
		//   }
		//   if ($conf['eklaim_environment_pragrouper'] == 'production') {
		$payload = inacbg_encrypt($json_request, $key);
		//   }

		// tentukan Content-Type pada http header
		$header = array("Content-Type: application/x-www-form-urlencoded");
		// url server aplikasi E-Klaim,
		// silakan disesuaikan instalasi masing-masing
		$url = $conf['eklaim_base_url_pragrouper'];

		// setup curl
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		// request dengan curl
		$response = curl_exec($ch);

		//   if ($conf['eklaim_environment_pragrouper'] == 'debug') {
		// 	$msg = json_decode($response, true);
		// 	return $msg;
		//   }
		//   if ($conf['eklaim_environment_pragrouper'] == 'production') {
		// terlebih dahulu hilangkan "----BEGIN ENCRYPTED DATA----\r\n"
		// dan hilangkan "----END ENCRYPTED DATA----\r\n" dari response
		$first = strpos($response, "\n") + 1;
		$last = strrpos($response, "\n") - 1;
		$response = substr(
			$response,
			$first,
			strlen($response) - $first - $last
		);
		// decrypt dengan fungsi inacbg_decrypt
		$response = inacbg_decrypt($response, $key);
		// hasil decrypt adalah format json, ditranslate kedalam array
		$msg = json_decode($response, true);
		return $msg;
		//   }
	}
}

if (!function_exists('list_cob_inacbg')) {
	function list_cob_inacbg()
	{
		$data = array(
			'0001' => 'MANDIRI INHEALTH',
			'0005' => 'ASURANSI SINAR MAS',
			'0006' => 'ASURANSI TUGU MANDIRI',
			'0007' => 'ASURANSI MITRA MAPARYA',
			'0008' => 'ASURANSI AXA MANDIRI FINANSIAL SERVICE',
			'0009' => 'ASURANSI AXA FINANSIAL INDONESIA',
			'0010' => 'LIPPO GENERAL INSURANCE',
			'0011' => 'ARTHAGRAHA GENERAL INSURANSE',
			'0012' => 'TUGU PRATAMA INDONESIA',
			'0013' => 'ASURANSI BINA DANA ARTA',
			'0014' => 'ASURANSI JIWA SINAR MAS MSIG',
			'0015' => 'AVRIST ASSURANCE',
			'0016' => 'ASURANSI JIWA SRAYA',
			'0017' => 'ASURANSI JIWA CENTRAL ASIA RAYA',
			'0018' => 'ASURANSI TAKAFUL KELUARGA',
			'0019' => 'ASURANSI JIWA GENERALI INDONESIA',
			'0020' => 'ASURANSI ASTRA BUANA',
			'0021' => 'ASURANSI UMUM MEGA',
			'0022' => 'ASURANSI MULTI ARTHA GUNA',
			'0023' => 'ASURANSI AIA INDONESIA',
			'0024' => 'ASURANSI JIWA EQUITY LIFE INDONESIA',
			'0025' => 'ASURANSI JIWA RECAPITAL',
			'0026' => 'GREAT EASTERN LIFE INDONESIA',
			'0027' => 'ASURANSI ADISARANA WANAARTHA',
			'0028' => 'ASURANSI JIWA BRINGIN JIWA SEJAHTERA',
			'0029' => 'BOSOWA ASURANSI',
			'0030' => 'MNC LIFE ASSURANCE',
			'0031' => 'ASURANSI AVIVA INDONESIA',
			'0032' => 'ASURANSI CENTRAL ASIA RAYA',
			'0033' => 'ASURANSI ALLIANZ LIFE INDONESIA',
			'0034' => 'ASURANSI BINTANG',
			'0035' => 'TOKIO MARINE LIFE INSURANCE INDONESIA',
			'0036' => 'MALACCA TRUST WUWUNGAN',
			'0037' => 'ASURANSI JASA INDONESIA',
			'0038' => 'ASURANSI JIWA MANULIFE INDONESIA',
			'0039' => 'ASURANSI BANGUN ASKRIDA',
			'0040' => 'ASURANSI JIWA SEQUIS FINANCIAL',
			'0041' => 'ASURANSI AXA INDONESIA',
			'0042' => 'BNI LIFE',
			'0043' => 'ACE LIFE INSURANCE',
			'0044' => 'CITRA INTERNATIONAL UNDERWRITERS',
			'0045' => 'ASURANSI RELIANCE INDONESIA',
			'0046' => 'HANWHA LIFE INSURANCE INDONESIA',
			'0047' => 'ASURANSI DAYIN MITRA',
			'0048' => 'ASURANSI ADIRA DINAMIKA',
			'0049' => 'PAN PASIFIC INSURANCE',
			'0050' => 'ASURANSI SAMSUNG TUGU',
			'0051' => 'ASURANSI UMUM BUMI PUTERA MUDA 1967',
			'0052' => 'ASURANSI JIWA KRESNA',
			'0053' => 'ASURANSI RAMAYANA',
			'0054' => 'VICTORIA INSURANCE',
			'0055' => 'ASURANSI JIWA BERSAMA BUMIPUTERA 1912',
			'0056' => 'FWD LIFE INDONESIA',
			'0057' => 'ASURANSI TAKAFUL KELUARGA',
			'0058' => 'ASURANSI TUGU KRESNA PRATAMA',
			'0059' => 'SOMPO INSURANCE'
		);
		return $data;
	}
}

if (!function_exists('list_cara_masuk_inacbg')) {
	function list_cara_masuk_inacbg()
	{
		// gp = Rujukan FKTP, hosp-trans = Rujukan FKRTL,
		//  mp = Rujukan Spesialis, outp = Dari Rawat Jalan,
		//  inp = Dari Rawat Inap, emd = Dari Rawat Darurat,
		//  born = Lahir di RS, nursing = Rujukan Panti Jompo,
		//  psych = Rujukan dari RS Jiwa, rehab = Rujukan Fasilitas
		//  Rehab, other = Lain-lain
		$data = array(
			'gp' => 'Rujukan FKTP',
			'hosp-trans' => 'Rujukan FKRTL',
			'mp' => 'Rujukan Spesialis',
			'outp' => 'Dari Rawat Jalan',
			'inp' => 'Dari Rawat Inap',
			'emd' => 'Dari Rawat Darurat',
			'born' => 'Lahir di RS',
			'nursing' => 'Rujukan Panti Jompo',
			'psych' => 'Rujukan dari RS Jiwa',
			'rehab' => 'Rujukan Fasilitas Rebah',
			'other' => 'Lain-lain'
		);
		return $data;
	}
}

if (!function_exists('eklaim_status')) {
	function eklaim_status($value)
	{
		switch ($value) {
			case '0':
				$res = 'Sudah Dikirim';
				break;
			case '1':
				$res = 'Proses Grouping';
				break;
			case '2':
				$res = 'Finalisasi';
				break;
			case '3':
				$res = 'DC Kemkes';
				break;
			default:
				$res = 'Belum Dikirim';
				break;
		}
		return $res;
	}
}

if (!function_exists('list_tahun')) {
	function list_tahun($start = 2023, $end = null, $ord = 'asc')
	{
		if ($end == null) {
			$end = date("Y", strtotime(date("Y", strtotime(date('Y'))) . " + 5 year"));
		}
		$data = array();
		if ($ord == 'asc') {
			for ($i = $start; $i <= $end; $i++) {
				$data[$i] = $i;
			}
		}
		if ($ord == 'desc') {
			for ($i = $end; $i >= $start; $i--) {
				$data[$i] = $i;
			}
		}
		return $data;
	}
}

if (!function_exists('list_bulan')) {
	function list_bulan()
	{
		$data = array(
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember',
		);
		return $data;
	}
}


if (!function_exists('str_gen')) {
	function str_gen($char = ".", $len = 10)
	{
		$res = "";
		for ($i = 0; $i < $len; $i++) {
			$res .= $char;
		}
		return $res;
	}
}

if (!function_exists('str_replace_between')) {
	function str_replace_between($str, $needle_start, $needle_end, $replacement)
	{
		$pos = strpos($str, $needle_start);
		$start = $pos === false ? 0 : $pos + strlen($needle_start);

		$pos = strpos($str, $needle_end, $start);
		$end = $pos === false ? strlen($str) : $pos;

		return substr_replace($str, $replacement, $start, $end - $start);
	}
}

if (!function_exists('color_chart')) {
	function color_chart($no)
	{
		if ($no == 1) {
			$color = 'rgb(255, 99, 132)';
		} elseif ($no == 2) {
			$color = 'rgb(255, 159, 64)';
		} elseif ($no == 3) {
			$color = 'rgb(255, 205, 86)';
		} elseif ($no == 4) {
			$color = 'rgb(75, 192, 192)';
		} elseif ($no == 5) {
			$color = 'rgb(54, 162, 235)';
		} elseif ($no == 6) {
			$color = 'rgb(153, 102, 255)';
		} elseif ($no == 7) {
			$color = 'rgb(201, 203, 207)';
		} elseif ($no == 8) {
			$color = 'rgb(255, 99, 132)';
		} elseif ($no == 9) {
			$color = 'rgb(255, 159, 64)';
		} elseif ($no == 10) {
			$color = 'rgb(255, 205, 86)';
		} elseif ($no == 11) {
			$color = 'rgb(75, 192, 192)';
		} elseif ($no == 12) {
			$color = 'rgb(54, 162, 235)';
		} elseif ($no == 13) {
			$color = 'rgb(153, 102, 255)';
		} elseif ($no == 14) {
			$color = 'rgb(201, 203, 207)';
		} elseif ($no == 15) {
			$color = 'rgb(255, 99, 132)';
		} elseif ($no == 16) {
			$color = 'rgb(255, 159, 64)';
		} elseif ($no == 17) {
			$color = 'rgb(255, 205, 86)';
		} elseif ($no == 18) {
			$color = 'rgb(75, 192, 192)';
		} elseif ($no == 19) {
			$color = 'rgb(54, 162, 235)';
		} elseif ($no == 20) {
			$color = 'rgb(153, 102, 255)';
		} else {
			$color = 'rgb(255, 99, 132)';
		}
		//
		return $color;
	}
}

if (!function_exists('date_dayname')) {
	function date_dayname($id = null)
	{
		$arr = array(
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu',
		);
		if ($id != '') return $arr[$id];
		else return $arr;
	}
}

if (!function_exists('date_chat_single')) {
	function date_chat_single($tgl = '')
	{
		$timestamp = $tgl;

		$today = new DateTime("today"); // This object represents current date/time with time set to midnight

		$match_date = DateTime::createFromFormat("Y-m-d H:i:s", $timestamp);
		$match_date->setTime(0, 0, 0); // set time part to midnight, in order to prevent partial comparison

		$diff = $today->diff($match_date);
		$diffDays = (int)$diff->format("%R%a"); // Extract days count in interval

		if ($diffDays == 0) {
			$result = 'HARI INI';
		} elseif ($diffDays == -1) {
			$result = 'KEMARIN';
		} elseif ($diffDays == -2 || $diffDays == -3 || $diffDays == -4 || $diffDays == -5 || $diffDays == -6 || $diffDays == -7) {
			$datetime = DateTime::createFromFormat('Y-m-d H:i:s', $tgl);
			$dayindex = $datetime->format('D');
			$dayname  = @date_dayname($dayindex);
			$result = strtoupper($dayname);
		} else {
			$result = to_date($tgl, '/', 'date');
		}
		return $result;
	}
}

if (!function_exists('date_chat')) {
	function date_chat($tgl = '')
	{
		if ($tgl != '') {
			$jam = substr($tgl, 11, 5);
			return $jam;
		}
	}
}

if (!function_exists('get_file_type')) {
	function get_file_type($file_name = null)
	{
		$arr = explode('.', $file_name);
		$len = count($arr) - 1;
		$file_type = $arr[$len];
		return $file_type;
	}
}

if (!function_exists('get_file_name')) {
	function get_file_name($file_name = null)
	{
		$arr = explode('.', $file_name);
		$len = count($arr) - 2;
		$file_name = $arr[$len];
		$file_name = str_replace(' ', '-', $file_name);
		return $file_name;
	}
}

if (!function_exists('tgl_list_user_chat')) {
	function tgl_list_user_chat($tgl = '')
	{
		$timestamp = $tgl;

		$today = new DateTime("today"); // This object represents current date/time with time set to midnight

		$match_date = DateTime::createFromFormat("Y-m-d H:i:s", $timestamp);
		$match_date->setTime(0, 0, 0); // set time part to midnight, in order to prevent partial comparison

		$diff = $today->diff($match_date);
		$diffDays = (int)$diff->format("%R%a"); // Extract days count in interval

		if ($diffDays == 0) {
			$result = substr($tgl, 11, 5);
		} elseif ($diffDays == -1) {
			$result = 'Kemarin';
		} elseif ($diffDays == -2 || $diffDays == -3 || $diffDays == -4 || $diffDays == -5 || $diffDays == -6 || $diffDays == -7) {
			$datetime = DateTime::createFromFormat('Y-m-d H:i:s', $tgl);
			$dayindex = $datetime->format('D');
			$dayname  = @date_dayname($dayindex);
			$result = $dayname;
		} else {
			$result = to_date($tgl, '/', 'date');
		}
		return $result;
	}
}

if (!function_exists('time_elapsed')) {
	function time_elapsed($datetime, $full = false)
	{
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'tahun',
			'm' => 'bulan',
			'w' => 'minggu',
			'd' => 'hari',
			'h' => 'jam',
			'i' => 'menit',
			's' => 'detik',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' lalu' : 'baru saja';
	}
}

if (!function_exists('dot_to_empty')) {
	function dot_to_empty($val = null)
	{
		$result = str_replace('.', '', $val);
		return $result;
	}
}

if (!function_exists('dot_to_underscore')) {
	function dot_to_underscore($val = null)
	{
		$result = str_replace('.', '_', $val);
		return $result;
	}
}
if (!function_exists('underscore_to_dot')) {
	function underscore_to_dot($val = null)
	{
		$result = str_replace('_', '.', $val);
		return $result;
	}
}

if (!function_exists('hastag_to_comma')) {
	function hastag_to_comma($val = null)
	{
		$result = str_replace('#', ', ', $val);
		return $result;
	}
}

if (!function_exists('to_rome')) {
	function to_rome($number)
	{
		$map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
		$returnValue = '';
		while ($number > 0) {
			foreach ($map as $roman => $int) {
				if ($number >= $int) {
					$number -= $int;
					$returnValue .= $roman;
					break;
				}
			}
		}
		return $returnValue;
	}
}

if (!function_exists('scan_dir')) {
	function scan_dir($dir)
	{
		$ignored = array('.', '..', 'index.html');

		$files = array();
		foreach (scandir($dir) as $file) {
			if (in_array($file, $ignored)) continue;
			$files[$file] = filemtime($dir . '/' . $file);
		}

		arsort($files);
		$files = array_keys($files);

		return $files;
	}
}

if (!function_exists('get_status_antrean')) {
	function get_status_antrean($val)
	{
		switch ($val) {
			case 0:
				$res = 'Belum Hadir';
				break;
			case 1:
				$res = 'Hadir';
				break;
			case 2:
				$res = 'Tidak Hadir';
				break;
			default:
				$res = 'Belum Hadir';
				break;
		}
		return $res;
	}
}

if (!function_exists('png_to_base64')) {
	function png_to_base64($path)
	{
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		return $base64;
	}
}

if (!function_exists('hitung_kamar')) {
	function hitung_kamar($kamar_id, $sex_id, $type = 'pengurangan')
	{
		$CI = &get_instance();
		$CI->db->where(['kamar_id' => @$kamar_id]);
		$kamar = $CI->db->get('mst_kamar')->row_array();

		$terisi_bed_lk = @$kamar['terisi_bed_lk'];
		$terisi_bed_pr = @$kamar['terisi_bed_pr'];
		$sisa_bed_lk = @$kamar['sisa_bed_lk'];
		$sisa_bed_pr = @$kamar['sisa_bed_pr'];
		if (@$sex_id == 'L') {
			if (@$type == 'penambahan') {
				$terisi_bed_lk = ($terisi_bed_lk - 1);
				$sisa_bed_lk = ($sisa_bed_lk + 1);
			} else {
				$terisi_bed_lk = ($terisi_bed_lk + 1);
				$sisa_bed_lk = ($sisa_bed_lk - 1);
			}
		} else {
			if (@$type == 'penambahan') {
				$terisi_bed_pr = ($terisi_bed_pr - 1);
				$sisa_bed_pr = ($sisa_bed_pr + 1);
			} else {
				$terisi_bed_pr = ($terisi_bed_pr + 1);
				$sisa_bed_pr = ($sisa_bed_pr - 1);
			}
		}
		$terisi_bed_total = ($terisi_bed_lk + $terisi_bed_pr);
		$sisa_bed_total = ($sisa_bed_lk + $sisa_bed_pr);

		return array(
			'terisi_bed_lk' => @$terisi_bed_lk,
			'terisi_bed_pr' => @$terisi_bed_pr,
			'terisi_bed_total' => @$terisi_bed_total,
			'sisa_bed_lk' => @$sisa_bed_lk,
			'sisa_bed_pr' => @$sisa_bed_pr,
			'sisa_bed_total' => @$sisa_bed_total,
		);
	}
}

if (!function_exists('hitung_hari')) {
	function hitung_hari($tgl_awal = '', $tgl_akhir = '')
	{
		$diff = strtotime($tgl_awal) - strtotime($tgl_akhir);
		$result = floor($diff / (60 * 60 * 24));
		return $result + 1;
	}
}

if (!function_exists('upload_move_video')) {
	function upload_move_video($path_dir, $tmp_name, $fupload_name = '', $old_file = null)
	{
		if ($old_file != "") {
			// unlink($path_dir . $old_file);
		}
		//
		$file_type = get_file_type($fupload_name);
		$file_name = 'simrs-' . md5(md5(date('Y-m-d H:i:s') . microtime() . $fupload_name)) . '.' . $file_type;
		$vfile_upload = $path_dir . $file_name;
		//
		if (!$tmp_name) { // if file not chosen
			echo "ERROR: Please browse for a file before clicking the upload button.";
			exit();
		}
		if (move_uploaded_file($tmp_name, $vfile_upload)) {
			echo "Video berhasil di upload";
		} else {
			echo "move_uploaded_file function failed";
		}

		//
		return @$file_name;
	}
}

if (!function_exists('update_log_bayar_st')) {
	function update_log_bayar_st($registrasi_id, $table = 'all', $tipe = 'log')
	{
		if ($tipe == 'log') {
			// check belum bayar
			if ($table == 'tindakan' || $table == 'all' || $table == '') {
				$sql = "SELECT COUNT(pelayanan_id) as jml_data FROM dat_tindakan WHERE registrasi_id=? AND tindakan_st=1 AND bayar_st='0'";
				$row = DB::raw('row_array', $sql, $registrasi_id);
				if (@$row['jml_data'] > 0) {
					$sql = "UPDATE dat_registrasi SET log_bayar_st=0 WHERE registrasi_id=?";
					DB::raw('query', $sql, [$registrasi_id]);
				}
			}
			if ($table == 'resep' || $table == 'all' || $table == '') {
				$sql = "SELECT COUNT(pelayanan_id) as jml_data FROM dat_resep WHERE registrasi_id=? AND resep_st >= 1 AND copyresep_st=0 AND bayar_st='0'";
				$row = DB::raw('row_array', $sql, $registrasi_id);
				if (@$row['jml_data'] > 0) {
					$sql = "UPDATE dat_registrasi SET log_bayar_st=0 WHERE registrasi_id=?";
					DB::raw('query', $sql, [$registrasi_id]);
				}
			}
		}
		//
		if ($tipe == 'freq') {
			$sql = "UPDATE dat_registrasi SET log_bayar_freq=COALESCE(log_bayar_freq)+1, log_bayar_st=1 WHERE registrasi_id=?";
			DB::raw('query', $sql, [$registrasi_id]);
		}
	}
}

// create blank example function
if (!function_exists('get_status_selesai_perbaikan')) {
	function get_status_selesai_perbaikan()
	{
		return [
			[
				'selesai_st' => 0,
				'selesai_nm' => 'Belum Direspon',
				'selesai_warna' => 'rgb(255, 99, 132)',
				'selesai_slug' => 'belumdirespon'
			],
			[
				'selesai_st' => 1,
				'selesai_nm' => 'Dalam Penanganan',
				'selesai_warna' => 'rgb(255, 159, 64)',
				'selesai_slug' => 'dalampenanganan'
			],
			[
				'selesai_st' => 3,
				'selesai_nm' => 'Dalam Proses Pengajuan',
				'selesai_warna' => 'rgb(255, 205, 86)',
				'selesai_slug' => 'dalamprosespengajuan'
			],
			[
				'selesai_st' => 4,
				'selesai_nm' => 'Tidak Layak Pakai',
				'selesai_warna' => 'rgb(75, 192, 192)',
				'selesai_slug' => 'tidaklayakpakai'
			],
			[
				'selesai_st' => 2,
				'selesai_nm' => 'Sudah Selesai/Siap Pakai',
				'selesai_warna' => 'rgb(54, 162, 235)',
				'selesai_slug' => 'sudahselesaisiappakai'
			],
		];
	}
}

// create dd function
if (!function_exists('dd')) {
	function dd(...$vars)
	{
		foreach ($vars as $var) {
			echo '<pre>';
			var_dump($var);
			echo '</pre>';
		}
		die;
	}
}

if (!function_exists('dd_table')) {
	function dd_table($vars)
	{
		foreach ($vars as $key => $var) {
			// echo '<pre>';
			echo $key . " text, <br>";
			// echo '</pre>';
		}
		die;
		die;
	}
}

if (!function_exists('romawi')) {
	function romawi($angka)
	{
		$angka = intval($angka);
		$result = '';

		$array = array(
			'M' => 1000,
			'CM' => 900,
			'D' => 500,
			'CD' => 400,
			'C' => 100,
			'XC' => 90,
			'L' => 50,
			'XL' => 40,
			'X' => 10,
			'IX' => 9,
			'V' => 5,
			'IV' => 4,
			'I' => 1
		);

		foreach ($array as $roman => $value) {
			$matches = intval($angka / $value);

			$result .= str_repeat($roman, $matches);

			$angka = $angka % $value;
		}

		return $result;
	}
}

if (!function_exists('base64_to_file')) {
	function base64_to_file($base64_string = '', $file_path = '', $file_name = '')
	{
		$splited = explode(',', substr($base64_string, 5), 2);
		$mime = $splited[0];
		$data = $splited[1];

		$mime_split_without_base64 = explode(';', $mime, 2);
		$mime_split = explode('/', $mime_split_without_base64[0], 2);
		if (count($mime_split) == 2) {
			$extension = $mime_split[1];
			if ($extension == 'jpeg') $extension = 'jpg';
			$output_file_with_extension = $file_name . '.' . 'jpg';
		}
		file_put_contents($file_path . $output_file_with_extension, base64_decode($data));
		return $output_file_with_extension;
	}
}

function curl_get($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_NOBODY, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$head = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
}

if (!function_exists('get_hari_jadwal_dokter')) {
	function get_hari_jadwal_dokter($id = null)
	{
		$arr = array(
			'Sun' => '7',
			'Mon' => '1',
			'Tue' => '2',
			'Wed' => '3',
			'Thu' => '4',
			'Fri' => '5',
			'Sat' => '6',
		);
		if ($id != '') return $arr[$id];
		else return $arr;
	}
}

if (!function_exists('get_hour_minute_from_time')) {
	function get_hour_minute_from_time($val = null)
	{
		$arr_date = explode(':', $val);
		return @$arr_date[0] . ':' . @$arr_date[1];
	}
}

if (!function_exists('long_hour_from_dates')) {
	function long_hour_from_dates($dateAwal = null, $dateAkhir = null)
	{
		$date1 = new DateTime($dateAwal);
		$date2 = new DateTime($dateAkhir);

		$diff = $date2->diff($date1);

		$hours = $diff->h;
		$hours = $hours + ($diff->days * 24);

		echo $hours;
	}
}

if (!function_exists('is_bpjs_connected')) {
	function is_bpjs_connected()
	{
		$vclaim_config = vclaim_config();

		// $connected = @fsockopen($res['vclaim_base_url'], 80); //website, port  (try 80 or 443)
		// if ($connected){
		//     $is_conn = 1; //action when connected
		//     fclose($connected);
		// }else{
		//     $is_conn = 0; //action in connection failure
		// }
		// return $is_conn;
		$ch = curl_init($vclaim_config['vclaim_base_url']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_CONNECT_TIME);
		curl_close($ch);
		return ($httpcode > 0) ? 1 : 0;
	}
}


if (!function_exists('get_last_id')) {
	function get_last_id($table, $pk_id)
	{
		$res = DB::raw('row_array', "SELECT $pk_id FROM $table ORDER BY $pk_id DESC LIMIT 1");
		if (@$res[$pk_id] != '') {
			$arr_a = explode(".", $res[$pk_id]);
		} else {
			$arr_a = explode(".", '0');
		}
		if (@$arr_a[1] != '') {
			$res = DB::raw('row_array', "SELECT $pk_id FROM $table ORDER BY $pk_id DESC LIMIT 1");
		}
		// if (@$arr_a[1] != '') {
		// 	$res = DB::raw('row_array', "SELECT $pk_id FROM $table ORDER BY $pk_id DESC LIMIT 1");
		// } else {
		// 	$res = DB::raw('row_array', "SELECT $pk_id::INTEGER FROM $table ORDER BY $pk_id::INTEGER DESC LIMIT 1");
		// }
		if (@$res[$pk_id] != '') {
			$arr_a = explode(".", $res[$pk_id]);
		} else {
			$arr_a = explode(".", '0');
		}
		$last = intval($arr_a[count($arr_a) - 1]) + 1;
		$last = str_pad($last, strlen($arr_a[count($arr_a) - 1]), '0', STR_PAD_LEFT);

		$arr_a[count($arr_a) - 1] = $last;

		$new_id = implode(".", $arr_a);
		return $new_id;
	}
}

if (!function_exists('getCalculatePercentageChange')) {
	function getCalculatePercentageChange($percentage, $of)
	{
		$percent = $percentage / $of;
		return  number_format($percent * 100, 2);
	}
}

if (!function_exists('random_color_part')) {
	function random_color_part()
	{
		return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
	}
}

if (!function_exists('random_color')) {
	function random_color()
	{
		return random_color_part() . random_color_part() . random_color_part();
	}
}

if (!function_exists('telegram_send_message')) {
	function telegram_send_message($topic_id, $message)
	{
		// Ganti dengan Token Bot kamu
		$telegram_bot_token_id = @DB::get('mst_parameter', ['parameter_field' => 'telegram_bot_token_id'])['parameter_val'];
		$token = $telegram_bot_token_id;

		// Ganti dengan Chat ID grup (gunakan angka negatif jika supergroup)
		$telegram_chat_id = @DB::get('mst_parameter', ['parameter_field' => 'telegram_chat_id'])['parameter_val'];
		$chat_id = $telegram_chat_id;

		//Topic 
		$message_thread_id = $topic_id;

		// Pesan yang ingin dikirim

		// API URL untuk mengirim pesan
		$url = "https://api.telegram.org/bot$token/sendMessage";

		// Data yang dikirim
		$data = [
			'chat_id' => $chat_id,
			'message_thread_id' => $message_thread_id,
			'text' => $message,
			'parse_mode' => 'HTML' // Bisa pakai Markdown atau HTML untuk format teks
		];

		// Gunakan cURL untuk mengirim request ke API Telegram
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Set timeout dalam detik
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // Waktu maksimal koneksi ke server (10 detik)
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Waktu maksimal eksekusi request (20 detik)

		$result = curl_exec($ch);
		curl_close($ch);

		// Tampilkan respon dari Telegram API
		return $result;
	}
}

if (!function_exists('get_gsheet_data')) {
	function get_gsheet_data($config)
	{
		$gsheet_api_key = get_parameter('gsheet_api_key');
		$spreadsheet_id = $config['spreadsheet_id'];
		$range = $config['range']; // Contoh : "Sheet2!A:A"; Ganti dengan range yang diinginkan

		$url = "https://sheets.googleapis.com/v4/spreadsheets/$spreadsheet_id/values/$range?key=$gsheet_api_key";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Matikan verifikasi SSL
		$response = curl_exec($ch);
		curl_close($ch);

		$data = json_decode($response, true);

		if (isset($data['values'])) {
			return [
				'status' => true,
				'message' => 'Data berhasil diambil',
				'data' => $data['values'],
			];
		} else {
			log_message('error', json_encode($data));
			return [
				'status' => false,
				'message' => @$data['error']['message'],
				'data' => $data
			];
		}
	}
}

if (!function_exists('get_gsheet_sheet_name')) {
	function get_gsheet_sheet_name($config)
	{
		$gsheet_api_key = get_parameter('gsheet_api_key');
		$spreadsheet_id = $config['spreadsheet_id'];

		$url = "https://sheets.googleapis.com/v4/spreadsheets/$spreadsheet_id?key=$gsheet_api_key";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Matikan verifikasi SSL
		$response = curl_exec($ch);
		curl_close($ch);

		$data = json_decode($response, true);

		if (isset($data['sheets'])) {
			return [
				'status' => true,
				'message' => 'Data berhasil diambil',
				'data' => $data['sheets'],
			];
		} else {
			log_message('error', json_encode($data));
			return [
				'status' => false,
				'message' => @$data['error']['message'],
				'data' => $data
			];
		}
	}
}

if (!function_exists('huruf_ke_angka')) {
	function huruf_ke_angka($huruf)
	{
		$huruf = strtoupper($huruf); // Biar konsisten (A-Z)
		return ord($huruf) - ord('A') + 1;
	}
}
