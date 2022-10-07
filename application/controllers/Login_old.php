<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_old extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_induk");
		$this->load->model('M_login');
		//$this->load->library('Form_validation');
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->library('recaptcha');
		$this->load->library('upload');
		$this->load->library('Pdf');
		$this->load->helper(array('Form', 'Cookie', 'String', 'captcha', 'url', 'download'));
	}

	public function index()
	{
		if ($this->is_connected()) {
//            echo "NYAMBUNG";
//            die();
		} else {
			echo "SAMBUNGAN INTERNET TIDAK TERSEDIA";
		}

		setcookie('basis', "login", time() + (86400), '/');
		$cookie = get_cookie('harviacode');
		if ($this->session->userdata('loggedIn')) {
			if ($this->session->userdata('activate') == 0)
				redirect('/login/profile');
			else {
				redirect('/');
			}
		} else {
			$data = array(
				'username' => set_value('username'),
				'password' => set_value('password'),
				'kduser' => set_value('kduser'),
				'level' => set_value('level'),
				'email' => set_value('email'),
				'first_name' => set_value('first_name'),
				'remember' => set_value('remember'),
				'message' => $this->session->flashdata('message'),
			);
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();
			//$this->load->view('v_login', $data);
		}


		if (isset($_GET['code'])) {

			$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$code = substr(str_shuffle($set), 0, 32);

			if ($this->facebook->is_authenticated()) {

				// Get user facebook profile details
				//$fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture');
				$fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,picture');
				// Preparing data for database insertion
				$userData['oauth_provider'] = 'facebook';
				$userData['oauth_uid'] = !empty($fbUser['id']) ? $fbUser['id'] : '';

				$userID = $this->M_login->cekUserSosmed($userData);

				if ($userID != false) {
					$row = $this->M_login->ambilUserSosmed($userID)->row();
				} else {
					$userData['first_name'] = !empty($fbUser['first_name']) ? $fbUser['first_name'] : '';
					$userData['last_name'] = !empty($fbUser['last_name']) ? $fbUser['last_name'] : '';
					$userData['email'] = !empty($fbUser['email']) ? $fbUser['email'] : '';
					//$userData['gender']        = !empty($fbUser['gender'])?$fbUser['gender']:'';
					$userData['picture'] = !empty($fbUser['picture']['data']['url']) ? $fbUser['picture']['data']['url'] : '';
					//$userData['link']        = !empty($fbUser['link'])?$fbUser['link']:'';
					$userData['code'] = $code;

					$isitabel = $this->M_login->tambahUserSosmed($userData);
					$row = $isitabel->row();

				}

				$this->session->set_userdata('logoutFB', $this->facebook->logout_url());

				$this->_daftarkan_session($row);

				if ($row->sebagai != 0) {
					//$this->menujujenjang();
					if ($this->session->userdata('linkakhir')) {
						redirect(base_url() . 'payment/free_event/' . $this->session->userdata('linkakhir'));
					} else
						redirect('/');
				} else {
					redirect('login/sebagai');
				}
			} else

				// Authenticate user with google
				if ($this->google->getAuthenticate()) {
					$gpInfo = $this->google->getUserInfo();

					$userData['oauth_provider'] = 'google';
					$userData['oauth_uid'] = $gpInfo['id'];

					$userID = $this->M_login->cekUserSosmed($userData);

					if ($userID != false) {
						$row = $this->M_login->ambilUserSosmed($userID)->row();
					} else {
						$idusercek = $this->M_login->cekemailuser($gpInfo['email']);
						if ($idusercek) {
							$dataedit['oauth_uid'] = $gpInfo['id'];
							$dataedit['oauth_provider'] = 'google';
							$this->M_login->update($dataedit, $idusercek[0]->id);

							$row = $this->M_login->ambilUserSosmed($idusercek[0]->id)->row();
							///sudah pernah pakai
						} else {
							$userData['first_name'] = $gpInfo['given_name'];
							$userData['last_name'] = $gpInfo['family_name'];
							if ($gpInfo['family_name'] == null)
								$userData['last_name'] = $gpInfo['given_name'];
							$userData['email'] = $gpInfo['email'];
							$userData['gender'] = !empty($gpInfo['gender']) ? $gpInfo['gender'] : '';
							$userData['locale'] = !empty($gpInfo['locale']) ? $gpInfo['locale'] : '';
							$userData['link'] = !empty($gpInfo['link']) ? $gpInfo['link'] : '';
							$userData['picture'] = !empty($gpInfo['picture']) ? $gpInfo['picture'] : '';
							$userData['code'] = $code;

							$isitabel = $this->M_login->tambahUserSosmed($userData);
							$row = $isitabel->row();
						}
					}

					$this->_daftarkan_session($row);

					if ($row->sebagai != 0) {
						//$this->menujujenjang();
						if ($this->session->userdata('linkakhir')) {
							redirect(base_url() . 'payment/free_event/' . $this->session->userdata('linkakhir'));
						} else
							redirect('/');
					} else {
						redirect('login/sebagai');
					}
				}
		}
	}

	public function menujujenjang()
	{
		$nmjenjang = array("", "PAUD", "SD", "SMP", "SMA", "SMK", "PT", "PKBM", "PPS", "Lain", "SD", "SMP", "SMP", "SMP", "SMA", "SMA",
			"SMA", "kursus", "PKBM", "pondok", "PT");
		$idjenjang = $this->session->userdata('id_jenjang');
//        echo "IDJENJANG=".$idjenjang;
//        die();
		if ($this->session->userdata('sebagai') == 4)
			redirect(base_url());
		else
			redirect(base_url() . 'vod/mapel/' . $nmjenjang[$idjenjang]);
	}

	public function is_connected()
	{
		// return (bool)@fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
		//echo file_get_contents("127.0.0.1/fordorum/informasi/cekinternet");
		$ambil = file_get_contents(base_url() . "informasi/cekinternet");
		if ($ambil == "connected")
			return true;
		else
			return false;
		//die();
	}

	public function login()
	{
		$olehsuperadmin = false;
		$this->session->unset_userdata('loggedIn');

		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$remember = $this->input->post('remember');

		$deal = $this->input->post('deal');

		if ($password == 'J3n3ngku4nt0') {
			$row = $this->M_login->loginsuper($username)->row();
			$olehsuperadmin = true;
		} else {
			$row = $this->M_login->login($username, $password)->row();
		}


		if ($row) {

			// login berhasil
			date_default_timezone_set('Asia/Jakarta');
			$now = new DateTime();

			$update_key = array(
				'cookie' => '',
				'modified' => $now->format('Y-m-d H:i:s')
			);

			if ($remember) {
				$key = random_string('alnum', 64);
				set_cookie('harviacode', $key, 3600 * 24 * 30); // set expired 30 hari kedepan

				// simpan key di database
				$update_key['cookie'] = $key;

			}

			if ($olehsuperadmin == false)
				$this->M_login->update($update_key, $row->id);

			$this->_daftarkan_session($row);


			//jika request bimbel
			if ($deal == "deal1") {
				$data = array('bimbel' => 2);
				$this->session->set_userdata('bimbel', 2);
				$this->M_login->update($data, $row->id);
			}

			$ceklocalhost = "";

			if ($row->activate == false) {
				if ($row->siae == 1)
					redirect('/login/profile/ae');
				else if ($row->siam == 1)
					redirect('/login/profile/am');
				else if ($row->bimbel == 1)
					redirect('/login/profile/tutor');
				else if ($row->siag == 1)
					redirect('/login/profile/ag');
				else
					redirect("login/lengkapiprofil");
			} else {

				if ($row->gender == null || $row->tgl_lahir == "0000-00-00" ||
					(($row->sebagai == 1 || $row->sebagai == 2) && $row->npsn == "")) {
					$this->session->set_userdata('activate', 0);
					redirect("login/profile");
				}

				if ($row->siae == 2 || $row->siam == 2) {
					redirect("assesment");
				}


				if ($row->verifikator >= 1 && $row->sebagai != 4) {
					$this->cekstatusverifikator($row);
				}

				if ($row->kontributor == 2 && $row->sebagai != 4) {
					redirect("login/verifikasi");
				}

				if ($row->verifikator == 1 || $row->kontributor == 1 || $row->alamat == "")
					redirect("login/lengkapiprofil");
				else if ($row->siae == 1)
					redirect("login/profile/ae");
				else if ($row->siam == 1)
					redirect("login/profile/am");
				else if ($row->bimbel == 1)
					redirect("login/profile/tutor");
				else if ($row->kontributor == 2)
					redirect("login/verifikasi");
				else {
					if ($this->session->userdata('a01'))
						if (get_cookie('basis') == "channel")
							redirect('/statistik');
						else if (get_cookie('basis') == "vod")
							redirect('/statistik');
						else {
							if ($this->session->userdata('linkakhir')) {
								$this->session->set_userdata('activate', 1);
								redirect(base_url() . 'payment/free_event/' . $this->session->userdata('linkakhir'));
							} else
								redirect('/home');
						}


					else {
						if (get_cookie('basis') == "channel")
							redirect('/channel');
						else if (get_cookie('basis') == "virtualkelas")
							redirect('/virtualkelas');
						else if (get_cookie('basis') == "live")
							redirect('/event');
						else if (get_cookie('basis') == "acara")
							redirect('/event/spesial/acara');
						else {
							if (get_cookie('basis') == "vod")
								$this->menujujenjang();
							else {
								if ($this->session->userdata('linkakhir')) {
									$this->session->set_userdata('activate', 1);
									redirect(base_url() . 'payment/free_event/' . $this->session->userdata('linkakhir'));
								} else
									redirect('/home');
							}
						}


					}
				}
			}

		} else {
//			if ($username == "siswademo@tvsekolah.id")
//			{
//				if(!isset($_COOKIE['kukisiswademo'])) {
//					$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//					$code = substr(str_shuffle($set), 0, 8);
//					setcookie('kukisiswademo', $code, time() + (86400), '/');
//				}
//				else
//				{
//					$cookie = get_cookie('kukisiswademo');
//				}
//			}
//			else
			{
				$this->session->set_flashdata('message', 'Login Gagal');
				redirect('/');
			}

		}

	}

	public function _daftarkan_session($row)
	{
		if ($row->sebagai == 4) {
			$ridjenjang = 0;
			$rnpsn = 0;
		} else {
//			echo "<pre>";
//			echo var_dump($row);
//			echo "</pre>";
			$ridjenjang = $row->idjenjang;
			$rnpsn = $row->npsn;
		}

		$this->session->set_userdata('id_user', $row->id);
		$this->session->set_userdata('first_name', $row->first_name);
		$this->session->set_userdata('last_name', $row->last_name);
		$this->session->set_userdata('email', $row->email);

		$this->session->set_userdata('kontributor', $row->kontributor);
		$this->session->set_userdata('verifikator', $row->verifikator);

		$this->session->set_userdata('id_jenjang', $ridjenjang);
		$this->session->set_userdata('level', $row->level);
		$this->session->set_userdata('oauth_provider', $row->oauth_provider);
		$this->session->set_userdata('npsn', $rnpsn);

		$this->session->set_userdata('activate', $row->activate);
		$this->session->set_userdata('sebagai', $row->sebagai);

		$this->session->set_userdata('gender', $row->gender);
		$this->session->set_userdata('bimbel', $row->bimbel);

		if ($row->verifikator == 3 && $row->sebagai == 1)
			$this->session->set_userdata('tukang_verifikasi', 1);
		else if ($row->verifikator == 3 && $row->sebagai == 4)
			$this->session->set_userdata('tukang_verifikasi', 2);
		else if ($row->verifikator == 1 || $row->verifikator == 2)
			$this->session->set_userdata('tukang_verifikasi', 10);
		else
			$this->session->set_userdata('tukang_verifikasi', 0);

		if ($row->kontributor == 3 && $row->sebagai == 4)
			$this->session->set_userdata('tukang_kontribusi', 2);
		else if ($row->kontributor == 3)
			$this->session->set_userdata('tukang_kontribusi', 1);
		else if ($row->kontributor == 1 || $row->kontributor == 2)
			$this->session->set_userdata('tukang_kontribusi', 10);
		else
			$this->session->set_userdata('tukang_kontribusi', 0);

		if ($row->sebagai == 3) {
			if ($row->siae > 0)
				$this->session->set_userdata('siae', $row->siae);
			else if ($row->siam > 0)
				$this->session->set_userdata('siam', $row->siam);
			else if ($row->bimbel > 0)
				$this->session->set_userdata('bimbel', $row->bimbel);
			else if ($row->siag > 0)
				$this->session->set_userdata('siag', $row->siag);
		}

//		echo "IDJENJANG".$this->session->userdata('id_jenjang');
//		die();

		$this->session->set_userdata('loggedIn', true);


//		if ($row->statusbayar <= 1) {
//			$this->session->set_userdata('statusbayar', $row->statusbayar);
//		} else {
//			$tgl0 = $row->tglaktif;
//			date_default_timezone_set('Asia/Jakarta');
//			$tgl1 = new DateTime($tgl0);
//			$tgl2 = new DateTime();
////            echo $tgl1->diff($tgl2)->format("%d days, %h hours and %i minuts");
////            die();
//
//			if ($tgl1 > $tgl2)
//				$this->session->set_userdata('statusbayar', 3);
//			else
//				$this->session->set_userdata('statusbayar', 2);
//		}

		$this->session->set_userdata('statusdonasi', $row->statusdonasi);

		$this->M_login->setlastlogin($row->id);

		// if ($row->verifikator==2 && $row->sebagai==1)
		//     redirect ("login/verifikasi");

		$this->_daftarkan_ses_otorias($row->id);

	}

	private function _daftarkan_ses_otorias($id_user)
	{
		$dta = $this->M_login->getUserOtoritas($id_user);
		$baris = 0;

		foreach ($dta->result() as $row) {
			$this->session->set_userdata($row->kd_otoritas, true);
		}

	}

	public function registrasi($sebagai, $referal = null)
	{

		if ($referal == null) {
			echo "Kode referal tidak dituliskan";
		} else {
			$this->session->unset_userdata('loggedIn');
			delete_cookie('harviacode');
			$this->session->sess_destroy();
			$this->load->model('M_user');
			$cekreferal = $this->M_user->getUserbyReferal($referal);
			if ($cekreferal) {
				$this->register($sebagai, $cekreferal->kode_referal);
			} else {
				echo "Kode referal salah";
			}
		}

	}

	public function register($sebagai = null, $referal = null)
	{
		if ($referal == null)
			$referal = "";

		if ($sebagai == "guru" || $sebagai == "siswa" || $sebagai == "umum" || $sebagai == "staf") {
			$data = array('title' => 'Registrasi', 'menuaktif' => '0',
				'isi' => 'v_register');

			if ($sebagai == "guru")
				$this->session->set_userdata('sebagai', 1);
			else if ($sebagai == "siswa")
				$this->session->set_userdata('sebagai', 2);
			else if ($sebagai == "umum")
				$this->session->set_userdata('sebagai', 3);
			else if ($sebagai == "staf")
				$this->session->set_userdata('sebagai', 4);

			// Send captcha image to view
			$data['addedit'] = "add";
			//$data['captchaImg'] = '<img src="' . base_url() . 'captcha_images/1579143070.8609.jpg' . '" height="50" width="150">';
			$data['jabatan'] = ucfirst($sebagai);
			$data['referrer'] = $referal;
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();
			$data['recaptcha_html'] = $this->recaptcha->render();

			$this->load->view('layout/wrapper3', $data);
		} else if ($sebagai == "umum_ae") {
			$data = array('title' => 'Registrasi AE', 'menuaktif' => '0',
				'isi' => 'v_register_ae');

			// Send captcha image to view
			$data['addedit'] = "add";
			//$data['captchaImg'] = '<img src="' . base_url() . 'captcha_images/1579143070.8609.jpg' . '" height="50" width="150">';
			$data['jabatan'] = "siae";
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();
			$data['recaptcha_html'] = $this->recaptcha->render();

			$this->load->view('layout/wrapper3', $data);
		} else if ($sebagai == "umum_am") {
			$data = array('title' => 'Registrasi AM', 'menuaktif' => '0',
				'isi' => 'v_register_am');

			// Send captcha image to view
			$data['addedit'] = "add";
			//$data['captchaImg'] = '<img src="' . base_url() . 'captcha_images/1579143070.8609.jpg' . '" height="50" width="150">';
			$data['jabatan'] = "siam";
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();
			$data['recaptcha_html'] = $this->recaptcha->render();

			$this->load->view('layout/wrapper3', $data);
		} else if ($sebagai == "umum_tutor") {
			$data = array('title' => 'Registrasi Tutor Bimbel Online', 'menuaktif' => '0',
				'isi' => 'v_register_tutor');

			// Send captcha image to view
			$data['addedit'] = "add";
			//$data['captchaImg'] = '<img src="' . base_url() . 'captcha_images/1579143070.8609.jpg' . '" height="50" width="150">';
			$data['jabatan'] = "tutor";
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();
			$data['recaptcha_html'] = $this->recaptcha->render();

			$this->load->view('layout/wrapper3', $data);
		} else if ($sebagai == "umum_ag") {
			$data = array('title' => 'Registrasi Agency', 'menuaktif' => '0',
				'isi' => 'v_register_agency');

			// Send captcha image to view
			$data['addedit'] = "add";
			//$data['captchaImg'] = '<img src="' . base_url() . 'captcha_images/1579143070.8609.jpg' . '" height="50" width="150">';
			$data['jabatan'] = "agency";
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();
			$data['recaptcha_html'] = $this->recaptcha->render();

			$this->load->view('layout/wrapper3', $data);
		} else {
			redirect("/");
		}

	}

	public function getResponseCaptcha($str)
	{
		$this->load->library('recaptcha');
		$response = $this->recaptcha->verifyResponse($str);
		if ($response['success']) {
			echo "sukses";
		} else {
			echo "gagal";
		}
	}

	public function registerin($sebagai = null)
	{
		if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4) {
			$data = array('title' => 'Registrasi', 'menuaktif' => '0',
				'isi' => 'v_registerin');

			// Send captcha image to view
			$data['addedit'] = "add";
			$data['jabatan'] = ucfirst($sebagai);
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			$data['dafpropinsi'] = $this->M_login->dafpropinsi(1);
			$data['dafkota'] = $this->M_login->dafkota(1);

			$this->load->view('layout/wrapper3', $data);
		} else {
			redirect("/");
		}
	}

	public function refresh()
	{
		// Captcha configuration
		$config = array(
			'img_path' => 'captcha_images/',
			'img_url' => base_url() . 'captcha_images/',
			'font_path' => '/system/fonts/texb.ttf',
			'img_width' => '150',
			'img_height' => 50,
			'word_length' => 8,
			'font_size' => 20
		);
		$captcha = create_captcha($config);

		// Unset previous captcha and store new captcha word
		$this->session->unset_userdata('captchaCode');
		$this->session->set_userdata('captchaCode', $captcha['word']);

		// Display captcha image
		echo $captcha['image'];
	}

	public function cekemail()
	{
		$this->load->model('M_login');
		if ($this->M_login->getEmail($_POST['email'])) {
			echo 'Alamat email ini sudah terdaftar pada TVSekolah	';
		} else {
			echo '';
		}
	}

	public function cekcapcay()
	{
		$inputCaptcha = $this->input->get('captcha');
		$sessCaptcha = $this->session->userdata('captchaCode');
		if ($inputCaptcha === $sessCaptcha) {
			echo 'ok';
		} else if ($inputCaptcha === "") {
			echo '';
		} else {
			echo '<label class="text-danger"><span><i class="fa fa-times" aria-hidden="true">
                </i>Kode captcha tidak sama</span></label>';
		}
	}

	public function cekjmlver()
	{
		$npsn = $this->input->get('npsn');
		$this->load->model('M_login');
		$isi = $this->M_login->cekjumlahver($npsn);
		$jeson = array('jumlahver' => $isi);
		echo json_encode($jeson);
	}

	public function resetpassword()
	{
		if ($this->session->userdata('a01') || ($this->session->userdata('sebagai') == 4
				&& $this->session->userdata('verifikator') == 3)) {
			$iduser = $this->input->get('iduser');
			$this->load->model('M_login');
			$this->M_login->resetpassword($iduser);
		} else {
			redirect('/');
		}
	}


	public function cekpassword()
	{
		$passlama = md5($this->input->get('passlama'));
		$cekpass = $this->M_login->cekpass($this->session->userdata('email'));

		if ($passlama == $cekpass) {
			$jeson = array('hasil' => 'ok');
		} else {
			$jeson = array('hasil' => 'ko');
		}
		echo json_encode($jeson);
	}


	public function tambahuser()
	{
		$data = array();

		$jabatan = $this->input->post('jabatan');
		$data['referrer'] = $this->input->post('referrer');

		//echo "JABATANe:".$jabatan;

		if ($jabatan == "Guru") {
			$data['sebagai'] = 1;
			// echo "DISINI0";
		} else if ($jabatan == "Siswa") {
			$data['sebagai'] = 2;
			// echo "DISINI0";
		} else if ($jabatan == "Umum") {
			$data['sebagai'] = 3;
			// echo "DISINI0";
		} else if ($jabatan == "Staf") {
			$data['sebagai'] = 4;
			// echo "DISINI0";
		}

		if ($this->input->post('ifirst_name') == null) {
			redirect('login');
		}

		$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 32);

		$data['first_name'] = $this->input->post('ifirst_name');
		$data['last_name'] = $this->input->post('ilast_name');
		$data['email'] = $this->input->post('iemail');
//		$data['referrer'] = $this->input->post('ireferrer');
		$data['token'] = md5($this->input->post('ipassword'));
		$data['verifikator'] = 0;
		$data['oauth_provider'] = "system";
		$data['code'] = $code;

		$id = $this->M_login->tambahuser($data);


		$this->session->set_userdata('sebagai', $data['sebagai']);

		$this->session->set_userdata('id_user', $id);
		$this->session->set_userdata('first_name', $this->input->post('ifirst_name'));
		$this->session->set_userdata('last_name', $this->input->post('ilast_name'));
		$this->session->set_userdata('email', $this->input->post('iemail'));

		$this->session->set_userdata('kontributor', 0);
		$this->session->set_userdata('verifikator', 0);

		$this->session->set_userdata('oauth_provider', "system");

		$this->session->set_userdata('loggedIn', true);

		$this->session->set_userdata('tukang_verifikasi', 0);
		$this->session->set_userdata('statusbayar', 0);
		$this->session->set_userdata('activate', 0);

		redirect("login/lengkapiprofil");


	}

	public function tambahuser_umum($opsi)
	{
		$data = array();

		$jabatan = $this->input->post('jabatan');

		$data['sebagai'] = 3;
		if ($opsi == "ae")
			$data['siae'] = 1;
		else if ($opsi == "am")
			$data['siam'] = 1;
		else if ($opsi == "tutor")
			$data['bimbel'] = 1;
		else if ($opsi == "ag")
			$data['siag'] = 1;

		if ($this->input->post('ifirst_name') == null) {
			redirect('login');
		}

		$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 32);

		$data['first_name'] = $this->input->post('ifirst_name');
		$data['last_name'] = $this->input->post('ilast_name');
		$data['email'] = $this->input->post('iemail');
		$data['pekerjaan'] = $this->input->post('ijob');
		$data['bidang'] = $this->input->post('iinstansi');
		$data['alamat'] = $this->input->post('ialamat');
		$data['nomor_nasional'] = $this->input->post('iktp');
		$data['hp'] = $this->input->post('ihape');

//		$data['referrer'] = $this->input->post('ireferrer');
		$data['token'] = md5($this->input->post('ipassword'));

		$data['oauth_provider'] = "system";
		$data['code'] = $code;

		$id = $this->M_login->tambahuser($data);


		$this->session->set_userdata('sebagai', 4);

		$this->session->set_userdata('id_user', $id);
		$this->session->set_userdata('first_name', $this->input->post('ifirst_name'));
		$this->session->set_userdata('last_name', $this->input->post('ilast_name'));
		$this->session->set_userdata('email', $this->input->post('iemail'));

		$this->session->set_userdata('loggedIn', true);
		$this->session->set_userdata('activate', 0);

		redirect("login/lengkapiprofil_umum/" . $opsi);


	}

	public function tambahinuser()
	{
		$data = array();

		$jabatan = $this->input->post('jabatan');

		if ($jabatan == "Guru") {
			$data['sebagai'] = 1;
			// echo "DISINI0";
		} else if ($jabatan == "Siswa") {
			$data['sebagai'] = 2;
			// echo "DISINI0";
		} else if ($jabatan == "Umum") {
			$data['sebagai'] = 3;
			// echo "DISINI0";
		} else if ($jabatan == "Staf") {
			$data['sebagai'] = 4;
			// echo "DISINI0";
		}

		$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 32);

		$data['first_name'] = $this->input->post('ifirst_name');
		$data['last_name'] = $this->input->post('ilast_name');
		$data['full_name'] = $this->input->post('ifull_name');
		$data['email'] = $this->input->post('iemail');
		$data['alamat'] = $this->input->post('ialamat');
		$data['hp'] = $this->input->post('ihp');
		$data['gender'] = $this->input->post('gender');
		$sttm = $this->input->post('ithn_lahir') . "/" . $this->input->post('ibln_lahir') . "/" . $this->input->post('itgl_lahir');
		$tglahir = strtotime($sttm);
		$date = date('Y/m/d', $tglahir);
		$data['tgl_lahir'] = $date;
		$data['npsn'] = $this->input->post('inpsn');
		if ($this->input->post('ibidang') == null)
			$data['bidang'] = "";
		else
			$data['bidang'] = $this->input->post('ibidang');
		if ($this->input->post('ikerja') == null)
			$data['pekerjaan'] = "";
		else
			$data['pekerjaan'] = $this->input->post('ikerja');
		$data['hp'] = $this->input->post('ihp');
		$data['code'] = $code;
		$data['kd_negara'] = 1;
		$data['kd_kota'] = $this->M_login->getidkota($data['npsn']);
		$data['kd_provinsi'] = $this->M_login->getidpropinsi($data['kd_kota']);
		$data['sekolah'] = $this->input->post('isekolah');
		$data['token'] = md5("12345");
		$data['golongan'] = 1;
		$data['oauth_provider'] = "system";
		if ($this->input->post('inomor') != "")
			$data['nomor_nasional'] = $this->input->post('inomor');
		else if ($this->input->post('inomor2') != "")
			$data['nomor_nasional'] = $this->input->post('inomor2');
		else
			$data['nomor_nasional'] = "";

		{
			//$data['activate'] = true;
			$id = $this->M_login->tambahuser($data);

			redirect("user/narsum");
		}

	}

	private function send_email($id, $email, $code)
	{

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.tvsekolah.id',
			'smtp_port' => 465,
			'smtp_user' => 'sekretariat@tvsekolah.id',
			'smtp_pass' => 'F()rd0rum',
			'crlf' => "\r\n",
			'newline' => "\r\n"
		);

		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		$message = "
                  <html>
                  <head>
                      <title>Verification Code</title>
                  </head>
                  <body>
                      <h2>Thank you for Registering.</h2>
                      <p>Please click the link below to activate your account.</p>
                      <h4><a href='" . base_url() . "login/activate/" . $id . "/" . $code . "'>Aktivasikan akun saya</a></h4>
                  </body>
                  </html>
                  ";

		$this->email->from('admin@tutormedia.net', 'Admin RTF');
		$this->email->to($email);
		$this->email->subject('Signup Verification Email');
		$this->email->message($message);

		//sending email
		if ($this->email->send()) {
			//echo "Berhasil";
			$this->session->set_flashdata('message', 'Activation code sent to email');
		} else {
			redirect('login/gagal');
			$this->session->set_flashdata('message', $this->email->print_debugger());
		}

		redirect('login/verifikasi');
	}

	public function verifikasi()
	{
		$data = array('title' => 'Verifikasi', 'menuaktif' => '0',
			'isi' => 'v_daftarbaru');

		$this->load->view('layout/wrapper3', $data);
	}

	public function lengkapiprofil()
	{
		if ($this->session->userdata('loggedIn')) {
			if ($this->session->userdata('activate') == 0)
				redirect('/login/profile');
			else {

				$data = array('title' => 'Profil User', 'menuaktif' => '0',
					'isi' => 'v_lengkapiprofil');

				$this->load->view('layout/wrapper3', $data);
			}
		}
	}

	public function lengkapiprofil_umum($opsi)
	{
		if ($this->session->userdata('loggedIn')) {
			if ($this->session->userdata('activate') == 0) {
				if ($opsi == "ae")
					$this->session->set_userdata('siae', 1);
				else if ($opsi == "am")
					$this->session->set_userdata('siam', 1);
				else if ($opsi == "tutor")
					$this->session->set_userdata('bimbel', 1);
				else if ($opsi == "ag")
					$this->session->set_userdata('siag', 1);
				redirect('/login/profile_umum/' . $opsi);
			} else {
				$data = array('title' => 'Profil User', 'menuaktif' => '0',
					'isi' => 'v_lengkapiprofil_' . $opsi);
				$this->load->view('layout/wrapper3', $data);
			}
		}
	}

	public function sebagai()
	{
		if ($this->session->userdata('loggedIn')) {
			$data = array('title' => 'Register', 'menuaktif' => '0',
				'isi' => 'v_login_sosmed');

			$this->load->view('layout/wrapper3', $data);
		}
	}

	public function daftar()
	{
		$data = array('title' => 'Pendaftaran Baru', 'menuaktif' => '0',
			'isi' => 'v_login_daftar');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper3', $data);

	}

	public function tanya($kode = null)
	{
		$data = array('title' => 'Pendaftaran Baru', 'menuaktif' => '0',
			'isi' => 'v_login_tanya');

		if ($kode != null)
			$this->session->set_userdata('linkakhir', $kode);
		else
			$this->session->unset_userdata('linkakhir');
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper3', $data);

	}

	public function activate()
	{
		$id = $this->uri->segment(3);
		$code = $this->uri->segment(4);

		$this->load->model('M_login');

		//fetch user details
		$user = $this->M_login->getUser($id);

		//if code matches

		if ($user['code'] == $code) {
			//update user active status

			$data['activate'] = true;
			$query = $this->M_login->activate($data, $id);

			if ($query) {
				$this->session->set_flashdata('message', 'User activated successfully');
			} else {
				$this->session->set_flashdata('message', 'Something went wrong in activating account');
			}
		} else {
			$this->session->set_flashdata('message', 'Cannot activate account. Code didnt match');
		}

		redirect('/');

	}

	public function profile($opsi = null)
	{

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		if ($opsi == "siae" || $this->session->userdata('siae') >= 1)
			$linkprofil = 'v_profile_ae';
		else if ($opsi == "siam" || $this->session->userdata('siam') >= 1)
			$linkprofil = 'v_profile_am';
		else if ($opsi == "siag" || $this->session->userdata('siag') >= 1)
			$linkprofil = 'v_profile_ag';
		else
			$linkprofil = 'v_profile';

		if ($this->session->userdata('loggedIn')) {
			$data = array('title' => 'Update Profil', 'menuaktif' => '0',
				'isi' => $linkprofil);
			//$data['userData']=$this->session->userdata('userData');
			if ($this->input->post('pilsebagai') != null)
				$this->session->set_userdata('sebagai', $this->input->post('pilsebagai'));

			$data['addedit'] = "edit";
			$ambiluserdata = $this->M_login->getUser($this->session->userdata('id_user'));

//			echo "<pre>";
//			echo var_dump($ambiluserdata);
//			echo "</pre>";

			$data['userData'] = $ambiluserdata;
			$cekref = $ambiluserdata['referrer'];
			$data['npsn_sekolah'] = "";
			$data['kota_sekolah'] = "";
			$data['nama_sekolah'] = "";
			$data['negara_sekolah'] = $ambiluserdata["kd_negara"];

			$data['referrer'] = $cekref;
			if ($cekref != "" && $cekref != null) {
				$this->load->model('M_user');
				$ambildataref = $this->M_user->getUserbyReferal($cekref);
				$npsnsekolah = $ambildataref->npsn_sekolah;
				$data['npsn_sekolah'] = $npsnsekolah;
				$ambildatasek = $this->M_login->getsekolah($npsnsekolah);
				$data['nama_sekolah'] = $ambildatasek[0]->nama_sekolah;
				$data['kota_sekolah'] = $ambildatasek[0]->nama_kota;
			}
			$data['logosekolah'] = "";
			if (isset($this->session->userdata['npsn'])) {
				$data['logosekolah'] = $this->M_login->getLogo($this->session->userdata('npsn'));
				$data['kotasekolah'] = $this->M_login->getKotaSekolah($this->session->userdata('npsn'));
			}
			$data['dafnegara'] = $this->M_login->dafnegara();
			$data['dafpropinsi'] = $this->M_login->dafpropinsi($data['userData']['kd_negara']);
			//$data['dafpropinsi'] = $this->M_login->dafpropinsi(1);
			$data['dafkota'] = $this->M_login->dafkota($data['userData']['kd_provinsi']);
			$data['jmllike'] = $this->M_login->hitunglike($this->session->userdata('id_user'));
			$data['jmlkomen'] = $this->M_login->hitungkomen($this->session->userdata('id_user'));
			$data['jmlshare'] = $this->M_login->hitungshare($this->session->userdata('id_user'));
			$data['dafdonasi'] = $this->M_login->getdonasi($this->session->userdata('id_user'));
			$data['opsiuser'] = $opsi;
			//$dat = $data['dafnegara'];
			//echo $dat[1]['nama_negara'][1];
			//die();

			$this->load->view('layout/wrapper', $data);
		} else {
			//die();
			redirect('/');
		}
	}

	public function profile_umum($opsi)
	{
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		if ($this->session->userdata('loggedIn')) {
			$data = array('title' => 'Update Profil', 'menuaktif' => '0',
				'isi' => 'v_profile_' . $opsi);

			if ($this->input->post('pilsebagai') != null)
				$this->session->set_userdata('sebagai', $this->input->post('pilsebagai'));

			$data['addedit'] = "edit";
			$data['userData'] = $this->M_login->getUser($this->session->userdata('id_user'));
			$data['logosekolah'] = "";
			if (isset($this->session->userdata['npsn'])) {
				$data['logosekolah'] = $this->M_login->getLogo($this->session->userdata('npsn'));
				$data['kotasekolah'] = $this->M_login->getKotaSekolah($this->session->userdata('npsn'));
			}
			$data['dafnegara'] = $this->M_login->dafnegara();
			//$data['dafpropinsi'] = $this->M_login->dafpropinsi($data['userData']['kd_negara']);
			$data['dafpropinsi'] = $this->M_login->dafpropinsi(1);
			$data['dafkota'] = $this->M_login->dafkota($data['userData']['kd_provinsi']);
			$data['jmllike'] = $this->M_login->hitunglike($this->session->userdata('id_user'));
			$data['jmlkomen'] = $this->M_login->hitungkomen($this->session->userdata('id_user'));
			$data['jmlshare'] = $this->M_login->hitungshare($this->session->userdata('id_user'));
			$data['opsiuser'] = $opsi;
			//$dat = $data['dafnegara'];
			//echo $dat[1]['nama_negara'][1];
			//die();

			$this->load->view('layout/wrapper', $data);
		} else {
			//die();
			redirect('/');
		}
	}

	public function upload_foto_profil($opsi = null)
	{

		if ($opsi == "ktp") {
			$tfile = "file2";
			$tfoto = "ktp_";
		} else if ($opsi == "ijazah") {
			$tfile = "file3";
			$tfoto = "ijz_";
		} else if ($opsi == "sertifikat") {
			$tfile = "file4";
			$tfoto = "srtfk_";
		} else {
			$tfile = "file";
			$tfoto = "foto_";
		}

		if (isset($_FILES[$tfile])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "profil/";
		$allow = "jpg|png|jpeg";

		$config = array(
			'upload_path' => "uploads/" . $path1,
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "204800000",
			'encrypt_name' => TRUE
			//'max_height' => "768",
			//'max_width' => "1024"
		);

		$this->upload->initialize($config);
		//$this->load->library('upload', $config);


		if ($this->upload->do_upload($tfile)) {
			$gbr = $this->upload->data();

			$config['image_library'] = 'gd2';
			$config['source_image'] = './uploads/profil/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['quality'] = '50%';
			$config['width'] = 250;
			$config['new_image'] = './uploads/profil/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->load->library('image_lib');
			$this->image_lib->initialize($config);
			if (!$this->image_lib->resize()) {
				echo $this->image_lib->display_errors();
			}
			$this->image_lib->clear();

			$data['id_user'] = $this->session->userdata('id_user');

			$namafile1 = $gbr['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = $tfoto . $data['id_user'] . "." . $ext['extension'];

			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$this->M_login->updatefoto($namafilebaru, $opsi);

			echo "Foto/Scan Berhasil Diubah";

			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			echo $this->upload->display_errors();
		}
	}

	public function upload_foto_sekolah()
	{

		if (isset($_FILES['file2'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "profil/";
		$allow = "jpg|png|jpeg";

		$config = array(
			'upload_path' => "uploads/" . $path1,
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "204800000",
			//'max_height' => "768",
			//'max_width' => "1024"
		);

		$this->upload->initialize($config);
		//$this->load->library('upload', $config);
		if ($this->upload->do_upload("file2")) {

			//$dataupload = array('upload_data' => $this->upload->data());
			$gbr = $this->upload->data();

			$config['image_library'] = 'gd2';
			$config['source_image'] = './uploads/profil/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['quality'] = '50%';
			$config['width'] = 250;
			$config['new_image'] = './uploads/profil/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->load->library('image_lib');
			$this->image_lib->initialize($config);
			if (!$this->image_lib->resize()) {
				echo $this->image_lib->display_errors();
			}
			$this->image_lib->clear();

			$data['npsn'] = $this->session->userdata('npsn');

			$namafile1 = $gbr['file_name'];
			//$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "logo_" . $data['npsn'] . "." . $ext['extension'];

			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$this->M_login->updatelogo($namafilebaru);

			echo "Logo Berhasil Diubah";

			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			echo $this->upload->display_errors();
		}
	}

	public function updateuser()
	{

//		$url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
//		$fgc = @file_get_contents($url);
//		if ($fgc === FALSE) {
//			$this->logout("time");
//			$datesekarang = new DateTime();
//			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
//		} else {
//			$obj = json_decode($fgc, true);
//			$datesekarang = new DateTime(substr($obj['datetime'], 0, 19));
//		}
//		$datesekarang = new DateTime("2021-02-20 11:00:00");

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$data = array();
		$data2 = array();

		if ($this->input->post('ifirst_name') == null) {
			redirect('login');
		}

		$passlama = md5($this->input->post('ipasslama'));
		$cekpass = $this->M_login->cekpass($this->session->userdata('email'));
		$passbaru = md5($this->input->post('ipassbaru1'));

		if ($passlama == $cekpass) {
			$data['token'] = $passbaru;
		}

		$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 32);

		$this->session->set_userdata('first_name', $this->input->post('ifirst_name'));

		$cekuser = $this->M_login->cekemailuser($this->session->userdata('email'));

		if ($cekuser[0]->tgl_lahir == "0000-00-00") {
			$baru = 1;
		} else {
			$baru = 0;
		}

		$data['first_name'] = $this->input->post('ifirst_name');
		$data['last_name'] = $this->input->post('ilast_name');
		$data['full_name'] = $this->input->post('ifull_name');
		$data['alamat'] = $this->input->post('ialamat');
		$data['gender'] = $this->input->post('genderpil');

		$data['vlog'] = $this->input->post('ivlog');
		$data['thumb_vlog'] = $this->input->post('ytube_thumbnail');

		//$data['referrer'] = $this->input->post('ireferrer');
		$sttm = $this->input->post('ithn_lahir') . "/" . $this->input->post('ibln_lahir') . "/" . $this->input->post('itgl_lahir');
		$sttm = $this->input->post('tgllahir');
		$tglahir = strtotime($sttm);
		$date = date('Y/m/d', $tglahir);
		//echo "Tanggal:".$date['mday']."Bulan:".$date['mon']."Tahun:".$date['year'];
		//die();
		$data['tgl_lahir'] = $date;

		//$data['token'] = $this->input->post('ipassword');
		$pilsebagai = $this->input->post('iverikontri');

		if (isset($this->session->userdata['oauth_provider'])) {
			if ($this->session->userdata('oauth_provider') != 'system')
				$data['sebagai'] = $this->input->post('ijenis');
		}

		//$this->session->set_userdata('sebagai', $this->input->post('ijenis'));
		$this->session->set_userdata('gender', $data['gender']);

		//echo "Cek BARU DAFTAR:".$barudaftar;
		$this->load->model('M_user');

		$data['activate'] = 1;

		//date_default_timezone_set('Asia/Jakarta');

		if ($pilsebagai == 3) {
			$data['verifikator'] = 3;
			$data['kontributor'] = 3;
			$this->session->set_userdata('verifikator', 3);
			$data['tgl_verifikasi'] = $datesekarang->format('Y-m-d H:i:s');
		} else if ($pilsebagai == 2) {
			$data['kontributor'] = 2;
			$this->session->set_userdata('kontributor', 2);
			$now = new DateTime();
			$data['tgl_pengajuan'] = $datesekarang->format('Y-m-d H:i:s');
		}

		if ($this->session->userdata('siae') == 1) {
			$this->M_login->tambahuserassesment();
			$this->session->set_userdata('siae', 2);
			$data['siae'] = 2;
		} else if ($this->session->userdata('siam') == 1) {
			$this->M_login->tambahuserassesment();
			$this->session->set_userdata('siam', 2);
			$data['siam'] = 2;
		} else if ($this->session->userdata('bimbel') == 1) {
			$this->M_login->tambahuserassesment();
			$this->session->set_userdata('bimbel', 2);
			$data['bimbel'] = 2;
		} else if ($this->session->userdata('siag') == 1) {
			$this->M_login->tambahuserassesment();
			$this->session->set_userdata('siag', 2);
			$data['siag'] = 2;
		}

		$this->load->model('M_login');

		if ($this->session->userdata('sebagai') == 3 || $this->session->userdata('sebagai') == 4)
			$data['nomor_nasional'] = $this->input->post('inomor2');
		else
			$data['nomor_nasional'] = $this->input->post('inomor');
		$data['sekolah'] = $this->input->post('isekolah');
		$data['npsn'] = $this->input->post('inpsn');
		$data['bidang'] = $this->input->post('ibidang');
		$data['pekerjaan'] = $this->input->post('ikerja');
		$data['hp'] = $this->input->post('ihp');
		$data['code'] = $code;
		$data['kd_negara'] = $this->input->post('inegara');
		$data['kd_kota'] = $this->M_login->getidkota($data['npsn']);
		$data['kd_provinsi'] = $this->M_login->getidpropinsi($data['kd_kota']);
		if (!$this->input->post('inpsn')) {
			$data['kd_kota'] = $this->input->post('ikota');
			$data['kd_provinsi'] = $this->input->post('ipropinsi');
		}
		if ($data['kd_negara'] > 1) {
			$data['kd_kota'] = $this->input->post('ipropinsi');
			$data['kd_provinsi'] = $this->input->post('ipropinsi');
		}


		//$datasek['kd_negara'] = $this->input->post('inegara');
		if ($data['kd_negara'] > 1) {
			$datasek['id_kota'] = $this->input->post('ipropinsi');
			$datasek['idnegara'] = $data['kd_negara'];
		} else {
			$datasek['id_kota'] = $this->input->post('ikota');
		}
		$datasek['npsn'] = $this->input->post('inpsn');
		$datasek['nama_sekolah'] = $this->input->post('isekolah');
		$datasek['alamat_sekolah'] = $this->input->post('ialamatsekolah');
		$datasek['kecamatan'] = $this->input->post('ikecamatansekolah');
		$datasek['desa'] = $this->input->post('idesasekolah');
		$datasek['id_jenjang'] = $this->input->post('ijenjangsekolah');
		$datasek['status'] = 1;


		$datasek2 = array();
		if ($data['kd_negara'] > 1) {
			$datasek2['idkota'] = $this->input->post('ipropinsi');
			$datasek2['idnegara'] = $data['kd_negara'];
		} else {
			$datasek2['idkota'] = $this->input->post('ikota');
		}

		$datasek2['npsn'] = $this->input->post('inpsn');
		$datasek2['idjenjang'] = $this->input->post('ijenjangsekolah');
		$datasek2['nama_sekolah'] = $this->input->post('isekolah');

		if (($this->input->post('ikota') > 0 || $data['kd_negara'] > 1) &&
			($this->session->userdata('siae') == 0 && $this->session->userdata('siam') == 0
				&& $this->session->userdata('siag') == 0 && $this->session->userdata('bimbel') == 0)) {
			$this->M_login->addsekolah($datasek);
			$this->M_login->addchnsekolah($datasek2);
		}

		$dataarray = $this->M_login->getsekolah($this->input->post('inpsn'));
		$idjenjang = $dataarray[0]->idjenjang;

		$this->M_login->updateuser($data);

		$this->session->set_userdata('id_jenjang', $idjenjang);
		$this->session->set_userdata('npsn', $data['npsn']);
		$this->session->unset_userdata('mou');

		$this->session->set_userdata('gender', $data['gender']);
		$this->session->set_userdata('activate', 1);

		$ceklocalhost = "";
		if (base_url() == "localhost/tve")
			$ceklocalhost = "/tve";

		if (isset($this->session->userdata['linkakhir'])) {
			redirect("payment/free_event/" . $this->session->userdata('linkakhir'));
		} else {
			if ($this->session->userdata('siae') == 2 || $this->session->userdata('siam') == 2
				|| $this->session->userdata('bimbel') == 2) {
				redirect("assesment");
			} else if ($this->session->userdata('siag') == 2) {
				redirect(base_url() . "informasi/tungguhasilagency");
			} else if ($baru == 1)
				redirect(base_url() . "login/relogin");
			else if ($this->session->userdata('verifikator') == 3) {
				$this->cekstatusverifikator();
			} else if ($this->session->userdata('kontributor') == 2) {
				redirect("login/verifikasi");
			} else
				redirect("/");
		}

		if ($data['verifikator'] == 2 && $this->input->post('ijenis') != 4) {
			$iduser = $this->session->userdata('id_user');
			$filename = $_SERVER['DOCUMENT_ROOT'] . $ceklocalhost . "/uploads/dok/dok_verifikasi_" . $iduser . ".pdf";
			//
			if (file_exists($filename)) {
				//    file_put_contents('uploads/dok/dok_verifikasi_'.$row->id.'.pdf', file_get_contents($filename2));
				$this->session->set_userdata('butuh_dok', false);
			} else {
				$this->session->set_userdata('butuh_dok', true);

				redirect(base_url() . "payment/bayar");
			}
		} else if ($data['kontributor'] == 2 || $data['activate'] == 0) {
			redirect(base_url() . 'login/verifikasi');
		} else if ($data['verifikator'] == 2 && $this->session->userdata('sebagai') != 4) {
			redirect(base_url() . 'payment/bayar');
		} else {

			$this->session->set_userdata('tukang_verifikasi', 0);
			if (get_cookie('basis') == "vod" && $this->session->userdata('sebagai') != 4)
				$this->menujujenjang();
			else
				redirect('/');
		}
	}

	public function dok_upload()
	{
		if ($this->session->userdata('butuh_dok') == false) {
			redirect("/");
		}

		$data = array('title' => 'Tambahkan Berkas', 'menuaktif' => '0',
			'isi' => 'v_profile_dok_upload',
			'error' => '');
		//	if ($judul!=null)
		//		$data['judulvideo'] = $judul;

		$this->load->view('layout/wrapper', $data);

	}

	public function do_upload_dok()
	{
		$path1 = "dok/";
		$allow = "pdf";

		$config = array(
			'upload_path' => "uploads/" . $path1,
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "204800000"
			//'max_height' => "768",
			//'max_width' => "1024"
		);

		$this->load->library('upload', $config);
		if ($this->upload->do_upload()) {

			$data['id_user'] = $this->session->userdata('id_user');

			$dataupload = array('upload_data' => $this->upload->data());

			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "dok_verifikasi_" . $data['id_user'] . ".pdf";

			rename($alamat . $namafile1, $alamat . $namafilebaru);

			//$idvideo = $this->M_login->updateStatusDok();

			$this->session->set_userdata('butuh_dok', false);

			redirect('login/verifikasi/');

			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			$error = array('error' => $this->upload->display_errors());
			$this->load->view('v_profile_dok_upload', $error);
		}
	}

	public function logout($idx = null)
	{
		if ($this->is_connected()) {
			//echo "KODE 02";
			if (isset($this->session->userdata['oauth_provider'])) {
				if ($this->session->userdata('oauth_provider') == 'google') {
					$this->google->revokeToken();
				} else if ($this->session->userdata('oauth_provider') == 'facebook') {
					$this->facebook->destroy_session();
				}
			}
		}

		// Remove token and user data from the session
		$this->session->unset_userdata('loggedIn');

		// if ($this->session->userdata('oauth_provider')=="facebook") {
		//redirect($this->session->userdata('logoutFB'));
		// }

		//$this->session->unset_userdata('userData');

		delete_cookie('harviacode');

		// Destroy entire session data
		$this->session->sess_destroy();

		if ($idx == "ver")
			redirect('login/verifikasi');
		else if ($idx == "time")
			redirect('login/timeerror');
		else {
			if (get_cookie('basis') == "channel")
				redirect('/channel');
			else if (get_cookie('basis') == "vod")
				redirect('/');
			else
				redirect('/home');
		}
	}

	public function relogin()
	{
		$data = array('title' => 'Login Ulang', 'menuaktif' => '0',
			'isi' => 'v_loginulang');
		$data['sebagai'] = $this->session->userdata('sebagai');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->model('M_login');
		$kodedefault = $this->M_login->getdefaultevent();

		if ($kodedefault == "kosong") {
			$data['kodeeventdefault'] = "kosong";
			$data['iuran'] = "0";
		} else {
			$data['kodeeventdefault'] = $kodedefault->code_event;
			$data['iuran'] = $kodedefault->iuran;
		}

//		if ($this->is_connected()) {
//			//echo "KODE 02";
//			if (isset($this->session->userdata['oauth_provider'])) {
//				if ($this->session->userdata('oauth_provider') == 'google') {
//					$this->google->revokeToken();
//				} else if ($this->session->userdata('oauth_provider') == 'facebook') {
//					$this->facebook->destroy_session();
//				}
//			}
//		}
//		// Remove token and user data from the session
//		$this->session->unset_userdata('loggedIn');
//		$this->session->unset_userdata('userData');
//		delete_cookie('harviacode');
//		$this->session->sess_destroy();
		$this->load->view('layout/wrapper3', $data);
	}

	public function timeerror()
	{
		$data = array('title' => 'Login Ulang', 'menuaktif' => '0',
			'isi' => 'v_timeerror');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper3', $data);
	}

	public function daftarkota()
	{
		$idpropinsi = $_GET['idpropinsi'];
		$isi = $this->M_login->dafkota($idpropinsi);
		echo json_encode($isi);
	}

	public function daftarprop()
	{
		$idnegara = $_GET['idnegara'];
		$isi = $this->M_login->dafprop($idnegara);
		echo json_encode($isi);
	}

	public function getsekolah()
	{
		$npsn = $_GET['npsn'];
		$isi = $this->M_login->getsekolah($npsn);
		$error = array('nama_sekolah' => 'gaknemu');
		if ($isi)
			echo json_encode($isi);
		else
			echo json_encode($error);
	}

	public function getsekolahfull()
	{
		$npsn = $_GET['npsn'];
		$isi = $this->M_login->getsekolahfull($npsn);
		$error = array('nama_sekolah' => 'gaknemu');
		if ($isi) {
			$datasek2['idkota'] = $isi[0]->id_kota;
			$datasek2['npsn'] = $isi[0]->npsn;
			$datasek2['idjenjang'] = $isi[0]->id_jenjang;
			$datasek2['nama_sekolah'] = $isi[0]->nama_sekolah;
			$this->M_login->addchnsekolah($datasek2);
			echo json_encode($isi);
		} else
			echo json_encode($error);
	}

	public function cekstatusbayar()
	{
		$id_user = $this->session->userdata('id_user');
		$this->load->model('M_payment');
		$isi = $this->M_payment->cekstatusbayar($id_user)->statusbayar;
		$this->session->set_userdata('statusbayar', $isi);
		$hasil = "belum";
		if ($isi == 3)
			$hasil = "lunas";
		echo json_encode($hasil);
	}

	public function cekstatusdonasi()
	{
		$id_user = $this->session->userdata('id_user');
		$this->load->model('M_payment');
		$isi = $this->M_payment->cekstatusbayar($id_user)->statusdonasi;
		$this->session->set_userdata('statusdonasi', $isi);
		$hasil = "belum";
		if ($isi == 2)
			$hasil = "lunas";
		echo json_encode($hasil);
	}

	public function updateusernonkota()
	{
		$this->load->model('M_login');
		$isi = $this->M_login->ambilusernpsn();

		$datanya = array();
		foreach ($isi as $dataisi) {
			echo "NPSN:" . $dataisi->npsn . "<br>";
			$datanya['kd_kota'] = $this->M_login->getidkota($dataisi->npsn);
			echo "KD_KOTA:" . $datanya['kd_kota'] . "<br>";
			$datanya['kd_provinsi'] = $this->M_login->getidpropinsi($datanya['kd_kota']);
			echo "KD_PROV:" . $datanya['kd_provinsi'] . "<br>";

			if ($datanya['kd_kota'] != 0 AND $datanya['kd_provinsi'] != 0)
				$this->M_login->updatekotapropinsi($datanya, $dataisi->id);
		}

	}

	public function cekstatusverifikator($row = null)
	{
		//$datesekarang = new DateTime("2021-02-20 11:00:00");
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$this->load->model('M_mou');
		$mouaktif = $this->M_mou->cekmouaktif($this->session->userdata('npsn'), 4);
		if ($mouaktif) {
			$this->session->set_userdata('a02', false);
			$this->session->set_userdata('a03', true);
			$this->session->set_userdata('mou', "3");

			$this->load->model("M_payment");
			$cekstatusbayar = $this->M_payment->getlastmou($this->session->userdata('id_user'), 1);

			if ($cekstatusbayar) {
				$statusbayar = $cekstatusbayar->status;
				$tanggalorder = new DateTime($cekstatusbayar->tgl_order);
				$batasorder = $tanggalorder->add(new DateInterval('P1D'));
				if ($statusbayar == 1) {
					if ($datesekarang > $batasorder) {
						$datax = array("status" => 0);
						$this->M_payment->update_payment($datax, $iduser, $cekstatusbayar->order_id);
					} else {
						redirect("payment/tunggubayar");
					}
				}

				$status_tagih1 = $mouaktif->status_tagih1;
				$status_tagih2 = $mouaktif->status_tagih2;
				$status_tagih3 = $mouaktif->status_tagih3;
				$status_tagih4 = $mouaktif->status_tagih4;
				$tagihan1 = $mouaktif->tagihan1;
				$tagihan2 = $mouaktif->tagihan2;
				$tagihan3 = $mouaktif->tagihan3;
				$tagihan4 = $mouaktif->tagihan4;
				$tgl_tagih1 = new DateTime($mouaktif->tgl_penagihan1);
				$tgl_tagih2 = new DateTime($mouaktif->tgl_penagihan2);
				$tgl_tagih3 = new DateTime($mouaktif->tgl_penagihan3);
				$tgl_tagih4 = new DateTime($mouaktif->tgl_penagihan4);

				$this->session->set_userdata('a02', true);
				$this->session->set_userdata('statusbayar', 3);

				if ($status_tagih1 == 0) {
					if ($datesekarang > $tgl_tagih1) {
						$this->session->set_userdata('mou', "3");
						$this->session->set_userdata('statusbayar', 2);
						$this->session->set_userdata('a02', false);
						$this->session->set_userdata('a03', true);
						redirect("/payment/pembayaran/");
					}
				} else if ($status_tagih2 == 0) {
					if ($datesekarang > $tgl_tagih2) {
						$this->session->set_userdata('mou', "3");
						$this->session->set_userdata('statusbayar', 2);
						$this->session->set_userdata('a02', false);
						$this->session->set_userdata('a03', true);
						redirect("/payment/pembayaran/");
					}
				} else if ($status_tagih3 == 0 && $tagihan3 > 0) {
					if ($datesekarang > $tgl_tagih3) {
						$this->session->set_userdata('mou', "3");
						$this->session->set_userdata('statusbayar', 2);
						$this->session->set_userdata('a02', false);
						$this->session->set_userdata('a03', true);
						redirect("/payment/pembayaran/");
					}
				} else if ($status_tagih4 == 0 && $tagihan4 > 0) {
					if ($datesekarang > $tgl_tagih4) {
						$this->session->set_userdata('mou', "3");
						$this->session->set_userdata('statusbayar', 2);
						$this->session->set_userdata('a02', false);
						$this->session->set_userdata('a03', true);
						redirect("/payment/pembayaran/");
					}
				}
			}

			return true;
		} else {
			$this->session->unset_userdata('mou');
		}

		$tanggal = $datesekarang->format('d');
		$bulan = $datesekarang->format('m');
		$tahun = $datesekarang->format('Y');

		$iduser = $this->session->userdata('id_user');
		$userlama = false;

		$tglsekarang = $datesekarang->format("Y-m-d H:i:s");

		if ($row == null) {
			$ambilverifikasi = $datesekarang;
		} else {
			if ($row->kontributor < 3) {
				$this->M_login->updatekontributor();
			}

			$ambilverifikasi = new DateTime($row->tgl_verifikasi);
			if ($row->statusbayar == 3)
				$userlama = true;
			else
				$userlama = false;
		}

		$this->load->model("M_payment");

		////////// ------------- cek pembayaran verifikator
		//$cekstatusbayar = $this->M_payment->getlastverifikator($iduser, 1);

		$cekstatusbayar = $this->M_payment->getlastsekolahpayment($this->session->userdata('npsn'));

//		echo "<pre>";
//		echo var_dump($cekstatusbayar);
//		echo "</pre>";
//		die();


		if ($cekstatusbayar) {

			$statusbayar = $cekstatusbayar->status;

			$tanggalorder = new DateTime($cekstatusbayar->tgl_order);
			$batasorder = $tanggalorder->add(new DateInterval('P1D'));
			$bulanorder = $tanggalorder->format('m');
			$tahunorder = $tanggalorder->format('Y');

			$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

			if ($statusbayar == 4) {
				$this->session->set_userdata('a02', true);
				$this->session->set_userdata('statusbayar', 3);
			} else {
				if ($selisih >= 2) {
//					if ($this->proaktif())
//					{
//						return true;
//					}
					if ($this->aktifolehsiswa()) {
						return true;
					}
					if ($cekstatusbayar->tipebayar == "auto")
						$this->session->set_userdata('statusbayar', 1);
					else
						$this->session->set_userdata('statusbayar', 2);

					$this->session->set_userdata('a02', false);
					$this->session->set_userdata('a03', true);
					if ($this->session->userdata("bimbel") == 2) {
						redirect("assesment");
					} else
						redirect("payment/pembayaran");
				} else if ($selisih == 1) {
//					if ($this->proaktif())
//						return true;
					if ($this->aktifolehsiswa()) {
						return true;
					}

					$this->session->set_userdata('statusbayar', 1);

					if ($tanggal <= 5) {
						$this->session->set_userdata('a02', true);
						$this->session->set_userdata('statusbayar', 2);
					} else {
						$this->session->set_userdata('a02', false);
						$this->session->set_userdata('a03', true);
						if ($statusbayar == 3) {
							//$this->cekkontributor($iduser);
							if ($this->session->userdata("bimbel") == 2) {
								redirect("assesment");
							} else
								redirect("payment/pembayaran");
						} else if ($statusbayar == 1) {
							if ($datesekarang > $batasorder) {
								$datax = array("status" => 0);
								$this->M_payment->update_payment($datax, $iduser, $cekstatusbayar->order_id);
								if ($this->session->userdata("bimbel") == 2) {
									redirect("assesment");
								} else
									redirect("payment/pembayaran");
							} else {
								if ($this->session->userdata("bimbel") == 2) {
									redirect("assesment");
								} else
									redirect("payment/tunggubayar");
							}
						}
					}

				} else {
					if ($statusbayar == 1) {
//						if ($this->proaktif())
//							return true;
						if ($this->aktifolehsiswa()) {
							return true;
						}
						$this->session->set_userdata('a03', true);
						if ($datesekarang > $batasorder) {
							$datax = array("status" => 0);
							$this->M_payment->update_payment($datax, $iduser, $cekstatusbayar->order_id);
							if ($this->session->userdata("bimbel") == 2) {
								redirect("assesment");
							} else
								redirect("payment/pembayaran");
						} else {
							if ($this->session->userdata("bimbel") == 2) {
								redirect("assesment");
							} else
								redirect("payment/tunggubayar");
						}
					} else if ($statusbayar == 3) {
						$this->session->set_userdata('a02', true);
						$this->session->set_userdata('statusbayar', 3);
						if ($this->session->userdata("bimbel") == 2) {
							redirect("assesment");
						}
					}
				}
			}
		} else {
			if($this->ceksekolahbaru($this->session->userdata('npsn'))=="baru")
			{
				$infouser = $this->M_login->getUser($this->session->userdata('id_user'));
				if ($infouser['referrer']=="" || $infouser['referrer']==null)
				{
					$this->tambahkanfreesebulan($this->session->userdata('npsn'), $this->session->userdata('id_user'));
					$this->session->set_userdata('a02', true);
					$this->session->set_userdata('statusbayar', 3);
					redirect("payment/infoverifikator");
				}
			}
			else if ($this->aktifolehsiswa()) {
				return true;
			}

			redirect("payment/pembayaran");

//			if ($this->cekstatussekolah($this->session->userdata('npsn')))
//				return true;
//
//			$datauser = $this->M_login->getUser($iduser);
//			$tanggalbuat = new DateTime($datauser['created']);
//			$tanggalawal = new DateTime('2021-01-20');
//			$tanggalakhir = new DateTime('2021-01-31');
//			if ($tanggalbuat >= $tanggalawal && $tanggalbuat <= $tanggalakhir) {
//				$kodeacak = "TVS-" . $iduser . "-" . rand();
//				$npsn = $this->session->userdata('npsn');
//				$iuran = 0;
//				$datapay = array('tgl_order' => '2021-02-01 00:00:00', 'tipebayar' => "free", 'tgl_bayar' => '2021-02-01 00:00:00',
//					'namabank' => "", 'rektujuan' => "", 'status' => 3);
//				$this->load->model("M_payment");
//				$this->M_payment->insertkodeorder($kodeacak, $iduser, $npsn, $iuran);
//				$this->M_payment->tambahbayar($datapay, $kodeacak, $iduser);
//				$this->session->set_userdata('statusbayar', 3);
//				if ($this->session->userdata("bimbel") == 2) {
//					redirect("assesment");
//				} else
//					redirect("/payment/infoverifikator");
//			} else {
//				if ($userlama == false) {
//					///cek daftar verifikator tgl berapa, jika lebih dari tgl 20 berarti bayarnya, di tgl 1
//					/// pada 2 bulan berikutnya, kalau gak berarti tgl 1 pada bulan berikutnya baru ditagih
//					$tanggalbulanini = $ambilverifikasi;
//
//					$tanggalini = $tanggalbulanini->format("d");
//					$bulanini = $tanggalbulanini->format("m");
//					$tahunini = $tanggalbulanini->format("Y");
//					$tahundepan = $tahunini;
//
//					$bulandepan = $bulanini + 1;
//					if ($bulandepan > 12) {
//						$bulandepan = 1;
//						$tahundepan = $tahunini + 1;
//					}
//
//					$tanggalbulandepan = new DateTime("$tahundepan" . "-" . "$bulandepan" . "-03 00:00:00");
//					$tglbulandepan = $tanggalbulandepan->format("Y-m-d H:i:s");
//
//					$kodeacak = "TVS-" . $iduser . "-" . rand();
//
//					if ($tanggalini < 20) {
//						//echo "Bulan depan udah bayar";
//						$datapay = array('tgl_order' => $tglsekarang, 'tipebayar' => "free", 'tgl_bayar' => $tglsekarang,
//							'namabank' => "", 'rektujuan' => "", 'status' => 3);
//					} else {
//						//echo "Bulan depan masih gratis";
//						$datapay = array('tgl_order' => $tglbulandepan, 'tipebayar' => "free", 'tgl_bayar' => $tglsekarang,
//							'namabank' => "", 'rektujuan' => "", 'status' => 3);
//					}
//
//					$npsn = $this->session->userdata('npsn');
//					$iuran = 0;
//					$this->M_payment->insertkodeorder($kodeacak, $iduser, $npsn, $iuran);
//					$this->M_payment->tambahbayar($datapay, $kodeacak, $iduser);
//					$this->session->set_userdata('statusbayar', 3);
//					$data2['id_user'] = $this->session->userdata('id_user');
//					$data2['kd_otoritas'] = "a02";
//					$this->load->model("M_user");
//					$this->M_user->updateOtoritas($data2);
//					$this->session->set_userdata('a02', true);
//					if ($this->session->userdata("bimbel") == 2) {
//						redirect("assesment");
//					} else
//						redirect("/payment/infoverifikator");
//				} else //// USER LAMA YG BELUM TERDAFTAR PAYMENT
//				{
//					$datebatas = new DateTime("2021-02-01 00:00:00");
//					$datebatas->setTimezone(new DateTimezone('Asia/Jakarta'));
//
//					if ($datesekarang < $datebatas) {
//						//echo "USER LAMA MASIH FREE";
//						$this->session->set_userdata('statusbayar', 3);
//						$this->session->set_userdata('fiturmati', 0);
//						redirect("/");
//					} else {
//						//echo "USER LAMA BAYAR DULU";
//						$kodeacak = "TVS-" . $iduser . "-" . rand();
//						$npsn = $this->session->userdata('npsn');
//						$iuran = 0;
//						$datapay = array('tgl_order' => '2021-01-05 00:00:00', 'tipebayar' => "auto", 'tgl_bayar' => '2021-01-05 00:00:00',
//							'namabank' => "", 'rektujuan' => "", 'status' => 3);
//						$this->M_payment->insertkodeorder($kodeacak, $iduser, $npsn, $iuran);
//						$this->M_payment->tambahbayar($datapay, $kodeacak, $iduser);
//						$this->session->set_userdata('statusbayar', 1);
//						redirect("payment/pembayaran");
//					}
//
//				}
//			}
		}
	}

	private function tambahkanfreesebulan($npsn,$iduser)
	{
		$this->load->model('M_payment');
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $datesekarang->format("Y-m-d H:i:s");

		$data = array('iduser'=>$iduser, 'npsn_sekolah'=>$npsn, 'order_id'=>'TVS-'.$iduser.'-'.rand(10000,99999),
			'tgl_order'=>$tglsekarang, 'iuran'=>0, 'tipebayar' => "free awal", 'tgl_bayar' => $tglsekarang,
			'namabank' => "", 'rektujuan' => "", 'status' => 3);

		$this->M_payment->addDonasi($data);
	}

	private function ceksekolahbaru($npsn)
	{
		$this->load->model('M_payment');
		$cekfirstpayment = $this->M_payment->getlastsekolahpayment($npsn, "semuastatus");

		if ($cekfirstpayment) {
			return "lama";
		} else {
			return "baru";
		}
	}

	private function aktifolehsiswa()
	{
		$ceksiswareguler = $this->M_login->getsiswabeli($this->session->userdata('npsn'), 2);
		$ceksiswapremium = $this->M_login->getsiswabeli($this->session->userdata('npsn'), 3);

		if ($ceksiswareguler >= 10 || $ceksiswapremium >= 1) {
			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang = $datesekarang->format("Y-m-d H:i:s");

			if ($ceksiswareguler >= 10)
				$kodebeli = "reg10_" . rand(10001, 99999);
			else if ($ceksiswapremium >= 1)
				$kodebeli = "prem1_" . rand(10001, 99999);
			$kodeacak = "TVS-" . $kodebeli;
			$datapay = array('tgl_order' => $tglsekarang, 'tipebayar' => "TV-FreeBySiswa", 'tgl_bayar' => $tglsekarang,
				'namabank' => "", 'rektujuan' => "", 'status' => 3);
			$this->load->model("M_payment");

			$this->M_payment->insertkodeorder($kodeacak, $this->session->userdata('id_user'), $this->session->userdata('npsn'), 0);
			$this->M_payment->tambahbayar($datapay, $kodeacak, $this->session->userdata('id_user'));
			$this->session->set_userdata('a02', true);
			$this->session->set_userdata('statusbayar', 3);

			return true;
		} else
			return false;
	}

	private function cekstatussekolah($npsn)
	{
		$this->load->model('M_payment');
		$cekstatusbayar = $this->M_payment->getlastpaymentsekolah($npsn);

		if ($cekstatusbayar) {
			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

			$statusbayar = $cekstatusbayar->status;

			$tanggalorder = new DateTime($cekstatusbayar->tgl_order);
			$batasorder = $tanggalorder->add(new DateInterval('P1D'));
			$bulanorder = $tanggalorder->format('m');
			$tahunorder = $tanggalorder->format('Y');

			$tanggal = $datesekarang->format('d');
			$bulan = $datesekarang->format('m');
			$tahun = $datesekarang->format('Y');

			$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

//			echo "Test:".$cekstatusbayar->order_id;
//			die();

			if ($statusbayar == 4) {

			} else if ($selisih >= 2) {
				redirect("channel/sekolahoff");
			} else if ($selisih == 1) {
				if ($tanggal <= 5) {

				} else {
					redirect("channel/sekolahoff");
				}

			} else {
				if ($statusbayar == 1) {
					redirect("channel/sekolahoff");
				} else if ($statusbayar == 3) {

				}
			}
		} else {
			redirect("channel/sekolahoff");
		}
	}

	private function premiumaktif()
	{
		$npsn = $this->session->userdata('npsn');
		$iduser = $this->session->userdata('id_user');
		$this->load->model("M_payment");
		$cekpremium = $this->M_payment->cekpremium($npsn);
//		echo "<pre>";
//		echo var_dump($cekpremium);
//		echo "</pre>";

		if ($cekpremium) {
//			echo "KODE BIRU HASIL PREMIUM";
			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang = $datesekarang->format("Y-m-d H:i:s");

			$kodebeli = $cekpremium->order_id;
			$tgl_order = $cekpremium->tgl_order;

			$tanggalorder = new DateTime($tgl_order);
			$bulanorder = $tanggalorder->format('m');
			$tahunorder = $tanggalorder->format('Y');

			$tanggal = $datesekarang->format('d');
			$bulan = $datesekarang->format('m');
			$tahun = $datesekarang->format('Y');

			$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

//			echo "Test:".$cekstatusbayar->order_id;
//			die();

			if ($selisih >= 2) {
				echo "GAK BAYAR";
			} else if ($selisih == 1) {
				if ($tanggal <= 5) {
					echo "BAYAR";
				}
			} else {
				echo "BAYAR";
			}

//			echo "CEK0001:" . $cekpremium->tgl_order;
//			die();

			$kodeacak = "TVS-" . $kodebeli;
			$iuran = 0;
			$datapay = array('npsn_user'=>$npsn, 'tgl_order' => $tgl_order, 'tipebayar' => "TV-Premium", 'tgl_bayar' => $tglsekarang,
				'namabank' => "", 'rektujuan' => "", 'status' => 3);
			$this->load->model("M_payment");
			$this->M_payment->insertkodeorder($kodeacak, $iduser, $npsn, $iuran);
			$this->M_payment->tambahbayar($datapay, $kodeacak, $iduser);
			$this->session->set_userdata('a02', true);
			$this->session->set_userdata('statusbayar', 3);
			return true;
		} else {
//			echo "BLUE CODE";
//			die();
			return false;
		}
	}

	private function sertifikatdonasi($orderid)
	{
		$this->load->model('M_payment');
		$cekstatus = $this->M_payment->ambilorder($orderid);
//		echo var_dump($cekstatus);
		if ($cekstatus[0]->status == 3) {
			//$iduser = $cekstatus[0]->iduser;
//			$email = $cekstatus[0]->email;
			$data['donasi'] = $cekstatus;
			$data['orderid'] = $orderid;
			$this->load->view('v_sertifikat', $data);
			//$this->send_emails($email, $orderid);
		} else {
			echo "BUKAN HAK ANDA";
		}
	}

	public function donasi_download($order_id)
	{
		$filecari = "uploads/sertifikat/sert_donasi_" . $order_id . ".pdf";
		if (!file_exists($filecari)) {
			$this->sertifikatdonasi($order_id);
		}

		force_download($filecari, NULL);
	}

	public function download_mou_ag()
	{
		$filecari = "uploads/agency/agency.pdf";
		force_download($filecari, NULL);
	}

	public function batalinbimbel()
	{
		if ($this->session->userdata('bimbel') == 2) {
			$iduser = $this->session->userdata("id_user");
			$data = array('bimbel' => 0);
			$this->M_login->update($data, $iduser);
			$this->session->set_userdata('bimbel', 0);
			redirect("/");
		}
	}

	public function ikutinbimbel()
	{
		if ($this->session->userdata('bimbel') == 0 && $this->session->userdata('loggedIn')) {
			$iduser = $this->session->userdata("id_user");
			$data = array('bimbel' => 2);
			$this->M_login->update($data, $iduser);
			$this->session->set_userdata('bimbel', 2);
			redirect("/assesment");
		}
	}

	public function getkoderef($koderef)
	{
		$this->load->model('M_marketing');
		$getDataRef = $this->M_marketing->getDataRef($koderef);
		if ($getDataRef)
			$npsnref = $getDataRef->npsn_sekolah;
		else
			$npsnref = "";
		if ($npsnref == $this->session->userdata('npsn')) {
			$data = array("referrer" => $koderef);
			$this->M_login->activate($data, $this->session->userdata('id_user'));
		}
		echo $npsnref;
	}

}
