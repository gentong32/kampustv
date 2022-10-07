<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login');
		//$this->load->library('Form_validation');
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->helper(array('Form', 'Cookie', 'String', 'captcha'));
	}

	public function index()
	{
		if ($this->is_connected()) {
			//
		} else {
			echo "SAMBUNGAN INTERNET TIDAK TERSEDIA";
		}


		$cookie = get_cookie('harviacode');
		if ($this->session->userdata('loggedIn')) {
			redirect('/');
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

				if ($userID != false && $row->sebagai != 0) {
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
						//echo "TIDAK ADA";
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

					$this->_daftarkan_session($row);

					if ($userID != false && $row->sebagai != 0) {
						redirect('/');
					} else {
						redirect('login/sebagai');
					}
				}
		}
	}

	public function is_connected($sCheckHost = 'www.google.com')
	{
		return (bool)@fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
	}

	public function login()
	{
		$this->session->unset_userdata('loggedIn');

		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$remember = $this->input->post('remember');

		$row = $this->M_login->login($username, $password)->row();

		// if ($row && $row->verifikator==1) {
		//     // login gagal
		//     $this->session->set_flashdata('message','User sebagai VERIFIKATOR belum diverifikasi oleh PUSAT');
		//     $this->index();
		// }
		// else

		if ($row && $row->activate == true) {
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

			$this->M_login->update($update_key, $row->id);
			$this->_daftarkan_session($row);

			if ($row->verifikator == 1 || $row->kontributor == 1 || $row->alamat == "")
				redirect("login/lengkapiprofil");
			else if ($row->verifikator == 2 || $row->kontributor == 2)
				redirect("login/verifikasi");
			else {
				if ($this->session->userdata('a01'))
					if (get_cookie('basis')=="channel")
						redirect('/beranda/channel');
					else
						redirect('/beranda');

				else
				{
					if (get_cookie('basis')=="channel")
						redirect('/channel');
					else
						redirect('/');

				}

			}

		} else if ($row && $row->activate == false) {
			// login gagal
            echo "DISINI SALAH";
			$this->session->set_flashdata('message', 'Update profil dulu');
            redirect('/login/profile');
		} else {
			// login gagal
			$this->session->set_flashdata('message', 'Login Gagal');
			redirect('/');
		}

	}

	public function _daftarkan_session($row)
	{
		// 1. Daftarkan Session
		$sess = array(
			'id_user' => $row->id,
			//'last_name' => $row->last_name,
			'first_name' => $row->first_name,
			//'kduser' => $row->kdUser,
			//'email' => $row->email,
			//'alamat' => $row->alamat,
			//'nomor_nasional' => $row->nomor_nasional,
			'level' => $row->level,
			'oauth_provider' => $row->oauth_provider,
			'npsn' => $row->npsn
			//'logoutURL' => $this->facebook->logout_url()
		);

		$this->session->set_userdata('sebagai', $row->sebagai);

		// echo "sebagai:".$row->sebagai.", ver:".$row->verifikator.", kontr:".$row->kontributor;
		// die();

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

		$this->session->set_userdata('loggedIn', true);
		$this->session->set_userdata('userData', $sess);


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

	public function register($sebagai = null)
	{
		$data = array('title' => 'Registrasi',
			'isi' => 'v_register');


		// Captcha configuration
		$config = array(
			'img_path' => 'captcha_images/',
			'img_url' => base_url() . 'captcha_images/',
			'font_path' => 'system/fonts/texb.ttf',
			'img_width' => '150',
			'img_height' => 50,
			'word_length' => 8,
			'font_size' => 16
		);
		$captcha = create_captcha($config);

		// Unset previous captcha and store new captcha word
		$this->session->unset_userdata('captchaCode');
		$this->session->set_userdata('captchaCode', $captcha['word']);


		// Send captcha image to view
		$data['addedit'] = "add";
		$data['captchaImg'] = $captcha['image'];
		$data['jabatan'] = ucfirst($sebagai);
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] =  $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper3', $data);

	}

	public function refresh()
	{
		// Captcha configuration
		$config = array(
			'img_path' => 'captcha_images/',
			'img_url' => base_url() . 'captcha_images/',
			'font_path' => 'system/fonts/texb.ttf',
			'img_width' => '150',
			'img_height' => 50,
			'word_length' => 8,
			'font_size' => 16
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
			echo 'Alamat email ini sudah terdaftar';
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


	public function tambahuser()
	{

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

		if ($this->input->post('ifirst_name') == null) {
			redirect('login');
		}

		$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 32);

		$data['first_name'] = $this->input->post('ifirst_name');
		$data['last_name'] = $this->input->post('ilast_name');
		$data['email'] = $this->input->post('iemail');
		$data['token'] = md5($this->input->post('ipassword'));
		//$data['sebagai'] = $this->input->post('ijenis');
		$data['oauth_provider'] = "system";
		$data['code'] = $code;

		// echo "Jabatan:".$jabatan. " - ".  $data['verifikator'];
		// die();


		// if ($data['sebagai']==4)
		// {
		//     $data['activate'] = false;
		//     $this->session->set_userdata('loggedIn', false);
		//     $id = $this->M_login->tambahuser($data);
		//     redirect('login/verifikasi');
		// }
		// else
		{
			//$data['activate'] = true;
			$id = $this->M_login->tambahuser($data);
			$data['id_user'] = $id;
			$this->session->set_userdata('loggedIn', true);
			$this->session->set_userdata('userData', $data);
			$this->session->set_userdata('tukang_verifikasi', 10);
			redirect("login/lengkapiprofil");
		}


		//$this->send_email($id,$this->input->post('iemail'),$code);
		//redirect('login/verifikasi');
		//Store the status and user profile info into session


	}

	private function send_email($id, $email, $code)
	{

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.mailtrap.io',
			'smtp_port' => 2525,
			'smtp_user' => 'cca739129655cb',
			'smtp_pass' => '236b07a1f7a48a',
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
			//echo "Gagal";
			$this->session->set_flashdata('message', $this->email->print_debugger());
		}

		redirect('login/verifikasi');
	}

	public function verifikasi()
	{
		$data = array('title' => 'Playing VOD',
			'isi' => 'v_daftarbaru');

		$this->load->view('layout/wrapper3', $data);
	}

	public function lengkapiprofil()
	{
		if ($this->session->userdata('loggedIn')) {
			$data = array('title' => 'Playing VOD',
				'isi' => 'v_lengkapiprofil');

			$this->load->view('layout/wrapper3', $data);
		}
	}

	public function sebagai()
	{
		if ($this->session->userdata('loggedIn')) {
			$data = array('title' => 'Playing VOD',
				'isi' => 'v_login_sosmed');

			$this->load->view('layout/wrapper3', $data);
		}
	}

	public function daftar()
	{
		$data = array('title' => 'Pendaftaran Baru',
			'isi' => 'v_login_daftar');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] =  $this->facebook->login_url();
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

	public function profile()
	{
		if ($this->session->userdata('a01')) {
			redirect('/user');
		}
		if ($this->session->userdata('loggedIn')) {
			$data = array('title' => 'Update Profil',
				'isi' => 'v_profile');
			//$data['userData']=$this->session->userdata('userData');
			if ($this->input->post('pilsebagai') != null)
				$data['sebagai'] = $this->input->post('pilsebagai');
			else
				$data['sebagai'] = 0;

			$data['addedit'] = "edit";
			$data['userData'] = $this->M_login->getUser($this->session->userdata('id_user'));
			$data['dafnegara'] = $this->M_login->dafnegara();
			$data['dafpropinsi'] = $this->M_login->dafpropinsi($data['userData']['kd_negara']);
			$data['dafkota'] = $this->M_login->dafkota($data['userData']['kd_provinsi']);
			$data['jmllike'] = $this->M_login->hitunglike($this->session->userdata('id_user'));
			$data['jmlkomen'] = $this->M_login->hitungkomen($this->session->userdata('id_user'));
			$data['jmlshare'] = $this->M_login->hitungshare($this->session->userdata('id_user'));
			//$dat = $data['dafnegara'];
			//echo $dat[1]['nama_negara'][1];
			//die();
			$this->load->view('layout/wrapper', $data);
		} else {
			//die();
			redirect('/');
		}
	}

	public function updateuser()
	{
		$data = array();
		$data2 = array();

		if ($this->input->post('ifirst_name') == null) {
			echo "cek firstname";
			redirect('login');
		}

		$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 32);

		$data['first_name'] = $this->input->post('ifirst_name');
		$data['last_name'] = $this->input->post('ilast_name');
		$data['alamat'] = $this->input->post('ialamat');
		//$data['token'] = $this->input->post('ipassword');
		$pilsebagai = $this->input->post('iverikontri');
		$data['sebagai'] = $this->input->post('ijenis');
		$this->session->set_userdata('sebagai', $this->input->post('ijenis'));
		$barudaftar = $this->input->post('ibarudaftar');



		if ($barudaftar == "1") {
			$data['activate'] = 0;
			if ((!$this->input->post('iverifikator') == "on") && (!$this->input->post('ikontributor') == "on"))
				$data['activate'] = 1;
			if ($pilsebagai == 3)
				$data['verifikator'] = 2;
			else if ($pilsebagai == 2)
				$data['kontributor'] = 2;
		} else {

			if ($this->input->post('iverifikator') == "on")
				$data['verifikator'] = 2;
			else
				$data['verifikator'] = 0;
			if ($this->input->post('ikontributor') == "on")
				$data['kontributor'] = 2;
			else
				$data['kontributor'] = 0;

		}

		// echo "pilsebagai:".$data['verifikator'];
		// die();

		$data['kd_negara'] = $this->input->post('inegara');
		$data['kd_provinsi'] = $this->input->post('ipropinsi');
		$data['kd_kota'] = $this->input->post('ikota');
		if ($data['sebagai'] == 4)
			$data['nomor_nasional'] = $this->input->post('inomor2');
		else
			$data['nomor_nasional'] = $this->input->post('inomor');
		$data['sekolah'] = $this->input->post('isekolah');
		$data['npsn'] = $this->input->post('inpsn');
		$data['bidang'] = $this->input->post('ibidang');
		$data['hp'] = $this->input->post('ihp');
		$data['code'] = $code;

		$data2['npsn'] = $this->input->post('inpsn');
		$data2['nama_sekolah'] = $this->input->post('isekolah');
		$data2['kode_sekolah'] = 'ch'.base_convert(microtime(false), 10, 36);



		$id = $this->M_login->updateuser($data);

        if ($data['verifikator'] == 2 && $barudaftar == "1")
        {
            redirect('login/dok_upload');
        }
		else if ($data['verifikator'] == 2 || $data['kontributor'] == 2 || $data['activate'] == 0) {
			redirect('login/verifikasi');
		} else {
			$this->session->set_userdata('tukang_verifikasi', 0);
			redirect('/');
		}
	}

    public function dok_upload()
    {
        $data = array('title' => 'Tambahkan Berkas',
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

            $namafilebaru = "dok_verifikasi_".$data['id_user'].".pdf";

            rename($alamat . $namafile1, $alamat . $namafilebaru);

            //$idvideo = $this->M_login->updateStatusDok();

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
			$this->google->revokeToken();
			$this->facebook->destroy_session();
		}
		// Remove token and user data from the session
		$this->session->unset_userdata('loggedIn');

		// if ($this->session->userdata('oauth_provider')=="facebook") {
		//redirect($this->session->userdata('logoutFB'));
		// }

		$this->session->unset_userdata('userData');

		delete_cookie('harviacode');

		// Destroy entire session data

		$this->session->sess_destroy();

		if ($idx == "ver")
			redirect('login/verifikasi');
		else
		{
			if (get_cookie('basis')=="channel")
				redirect('/channel');
			else
				redirect('/');
		}
	}

	public function daftarkota()
	{
		$idpropinsi = $_GET['idpropinsi'];
		$isi = $this->M_login->dafkota($idpropinsi);
		echo json_encode($isi);
	}

	public function getsekolah()
	{
		$npsn = $_GET['npsn'];
		$isi = $this->M_login->getsekolah($npsn);
		echo json_encode($isi);
	}


}
