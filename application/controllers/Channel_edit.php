<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channel extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_induk");
		$this->load->model("M_channel");
		$this->load->helper('video');
		//$this->load->helper('cookie');
		$this->load->helper(array('Form', 'Cookie', 'String', 'captcha', 'download'));
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');

	}

	public function index()
	{
		setcookie('basis', "channel", time() + (86400), '/');
		if ($this->session->userdata('loggedIn')) {
			if ($this->session->userdata('activate') == 90)
				redirect('/login/profile');
			else
				$this->hometes();
		} else {
			if ($this->is_connected()) {
				$this->hometes();
			} else {
				echo "SAMBUNGAN INTERNET TIDAK TERSEDIA";
			}
		}
	}

	public function is_connected($sCheckHost = 'www.google.com')
	{
		return (bool)@fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
	}

	public function home($linklist = null, $buattes = null)
	{
		//get_cookie('basis')
		$this->load->model('M_channel');
		setcookie('basis', "channel", time() + (86400), '/');
		$data = array('title' => 'Panggung Sekolah', 'menuaktif' => '2',
			'isi' => 'v_channel_home_sebelumdirev');
		delete_cookie("cookie_vod");
		delete_cookie("cookie_jempol");

		$npsn = "";
		if ($this->session->userdata('loggedIn')) {
			if ($this->session->userdata('sebagai') == 4)
				$npsn = "";
			else
				$npsn = $this->session->userdata('npsn');
		}

		if ($npsn == "")
			$npsn = "000";

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$hari = $now->format('N');

		//echo "HARI:".$hari;

		$data['dafplaylist'] = $this->M_channel->getDafPlayListTVE(0, $hari);
//        echo "Disini-01";
		if ($data['dafplaylist']) {
			// echo "Disini-02";
			$data['punyalist'] = true;
			$statusakhir = $data['dafplaylist'][0]->link_list;
			if ($linklist == null) {
				$data['playlist'] = $this->M_channel->getPlayListTVE($statusakhir);

			} else {
				$data['playlist'] = $this->M_channel->getPlayListTVE($linklist);

			}

			/////////paksa dulu ------------
			$data['playlist'] = $this->M_channel->getPlayListTVE($statusakhir);
			$linklist = $statusakhir;

		} else {
			//echo "Disini-03";
			$data['punyalist'] = false;
//            if (!$this->session->userdata('loggedIn')) {
//                redirect('/');
//            }
		}

//        echo "NPSN:".$npsn;
//        die();
		if ($npsn == "000")
			$npsn = "10101010101";
		$data['channelku'] = $this->M_channel->getSekolahKu($npsn);
		$data['dafchannel'] = $this->M_channel->getSekolahLain($npsn, $buattes);

		if ($buattes != null) {
			foreach ($data['dafchannel'] as $row) {
				echo $row->npsn . "<br>";
				echo $row->hari . "<br>";
				echo "--------------" . "<br>";
			}
			die();
		}


		$data['dafvideo'] = $this->M_channel->getVodAll();
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		if ($this->is_connected())
			$data['nyambung'] = true;
		else
			$data['nyambung'] = false;

		$data['id_playlist'] = $linklist;

		$this->load->view('layout/wrapperchannel', $data);
	}

	public function hometes($linklist = null, $buattes = null)
	{
		//get_cookie('basis')
		$this->load->model('M_channel');
		setcookie('basis', "channel", time() + (86400), '/');
		$data = array('title' => 'Panggung Sekolah', 'menuaktif' => '2',
			'isi' => 'v_channel_home');
		delete_cookie("cookie_vod");
		delete_cookie("cookie_jempol");

		$npsn = "";
		if ($this->session->userdata('loggedIn')) {
			if ($this->session->userdata('sebagai') == 4)
				$npsn = "";
			else
				$npsn = $this->session->userdata('npsn');
		}

		if ($npsn == "")
			$npsn = "000";

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$hari = $now->format('N');

		//echo "HARI:".$hari;
		//die();

		$data['dafplaylist'] = $this->M_channel->getDafPlayListTVE(0, $hari);
//        echo "Disini-01";

		$durasiplaylist = $data['dafplaylist'][0]->durasi_paket;

		if ($durasiplaylist != "00:00:00") {
			// echo "Disini-02";
			$data['punyalist'] = true;
			$statusakhir = $data['dafplaylist'][0]->link_list;
			if ($linklist == null) {
				$data['playlist'] = $this->M_channel->getPlayListTVE($statusakhir);

			} else {
				$data['playlist'] = $this->M_channel->getPlayListTVE($linklist);

			}

			/////////paksa dulu ------------
			$data['playlist'] = $this->M_channel->getPlayListTVE($statusakhir);
			$linklist = $statusakhir;

//			echo "<pre>";
//			echo var_dump($data['playlist']);
//			echo "</pre>";
//			die();

		} else {
			//echo "Belum punya daftar siaran";
			$data['punyalist'] = false;
//            if (!$this->session->userdata('loggedIn')) {
//                redirect('/');
//            }
		}

		//die();

		if ($npsn == "000")
			$npsn = "10101010101";
		$data['channelku'] = $this->M_channel->getSekolahKu($npsn);
		$data['dafchannel'] = $this->M_channel->getSekolahLain($npsn, "");

		if ($buattes != null) {
			foreach ($data['dafchannel'] as $row) {
				echo $row->npsn . "<br>";
				echo $row->hari . "<br>";
				echo "--------------" . "<br>";
			}
			die();
		}


		$data['dafvideo'] = $this->M_channel->getVodAll();
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		if ($this->is_connected())
			$data['nyambung'] = true;
		else
			$data['nyambung'] = false;

		$data['id_playlist'] = $linklist;

		$this->load->view('layout/wrapperchannel', $data);
	}

	public function sekolah($npsn = null, $linklist = null)
	{

		if ($npsn != null) {
			if ($this->session->userdata('a02'))
				$cekuser = 2;
			else
				$cekuser = 2;
			$this->load->model('M_channel');
			$data = array('title' => 'Playing VOD', 'menuaktif' => $cekuser,
				'isi' => 'v_channel_sekolah');
			$npsn = substr($npsn, 2);

			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$hari = $now->format('N');

			$data['hari'] = $hari;

			//$npsn = "";
			$data['kdusr'] = "orang";

			if ($this->session->userdata('loggedIn')) {
				if ($this->session->userdata('npsn') == $npsn)
					$data['kdusr'] = "pemilik";
			}

			if (strlen($npsn) > 0) {

				$ceknpsn = $this->M_channel->getSekolahKu($npsn);
				if ($ceknpsn) {


					$data['dafplaylist'] = $this->M_channel->getDafPlayListSekolah($npsn, 0, $hari);
//					echo "<pre>";
//					echo var_dump($data['dafplaylist']);
//					echo "</pre>";
//					die();

					if ($data['dafplaylist']) {
						//echo "Disini-1";
						$data['punyalist'] = true;
						$statusakhir = $data['dafplaylist'][0]->link_list;
						if ($linklist == null) {
							$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $statusakhir);

						} else {
							$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $linklist);

						}

						/////////paksa dulu ------------
						$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $statusakhir);
						$linklist = $statusakhir;

					} else {
						//echo "Disini-2";
						$data['punyalist'] = false;
//            if (!$this->session->userdata('loggedIn')) {
//                redirect('/');
//            }
					}

					//die();

					$data['dafchannelguru'] = $this->M_channel->getChannelGuru($npsn);
					$data['infosekolah'] = $this->M_channel->getInfoSekolah($npsn);
					$data['dafvideo'] = $this->M_channel->getVodSekolah($npsn);

				}
			}
			if ($this->is_connected())
				$data['nyambung'] = true;
			else
				$data['nyambung'] = false;
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();
			$data['id_playlist'] = $linklist;

			$this->load->view('layout/wrapperchannel', $data);
		} else {
			$data = array('title' => 'Playing VOD', 'menuaktif' => 2, 'isi' => 'v_channel_all_sekolah');
			$this->load->model('M_channel');
			if ($this->session->userdata('loggedIn') && !$this->session->userdata('a01')) {
				$npsn = $this->session->userdata('npsn');
				if ($npsn == "000")
					$npsn = "10101010101";
				$data['channelku'] = $this->M_channel->getSekolahKu($npsn);
				$data['dafchannel'] = $this->M_channel->getSekolahLain($npsn, "all");
			} else {
				$data['dafchannel'] = $this->M_channel->getAllSekolah();
			}

			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();
			if ($this->is_connected())
				$data['nyambung'] = true;
			else
				$data['nyambung'] = false;

			$this->load->view('layout/wrapper3', $data);
		}

	}

	public function edit()
	{
		$data = array('title' => 'Playing VOD', 'menuaktif' => '4',
			'isi' => 'v_channel_edit');
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		$data['addedit'] = "edit";

		$this->load->view('layout/wrapperchannel', $data);
	}

	public function update($idx = null)
	{

		$this->load->model('M_channel');

		$path1 = "thumbs/";
		$allow = "jpg|png";

		$config = array(
			'upload_path' => "uploads/channel/",
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "2048000",
			'max_height' => "1024",
			'max_width' => "1024"
		);
		$this->load->library('upload', $config);
		if ($this->upload->do_upload()) {
			$dataupload = array('upload_data' => $this->upload->data());

			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			if ($idx == null) {
				date_default_timezone_set('Asia/Jakarta');
				$now = new DateTime();
				$date = $now->format('Y-m-d_H-i');
				$namafilebaru = $ext['filename'] . $date . '.' . $ext['extension'];

				rename($alamat . $namafile1, $alamat . $namafilebaru);

				$data['id_user'] = $this->session->userdata('id_user');
				$data['file_video'] = $namafilebaru;
				$data['kode_video'] = base_convert(microtime(false), 10, 36);
				//$idvideo = $this->M_channel->addChannel($data);
			} else {
				$datavideo = $this->M_channel->getChannel($idx);

				$namafilevideo = $datavideo['file_channel'];
				$namafilebaru = substr($namafilevideo, -11) . '.' . $ext['extension'];

				//$this->M_channel->updateChannel($idx,$namafilebaru);

				rename($alamat . $namafile1, $alamat . $namafilebaru);
				//$idvideo = $datavideo['id_video'];
			}
//			redirect('video/edit/'.$idvideo);

			$this->sirkel($namafilebaru);
			redirect('/channel');
		} else {
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('v_channel_edit', $error);
		}
	}

	public function sirkel($image)
	{

		//$_GET['image']
		$filename = base_url() . "uploads/channel/" . $image;
//		echo $filename;
//		die();
		$image_s = imagecreatefromstring(file_get_contents($filename));
		$width = imagesx($image_s);
		$height = imagesy($image_s);
		$newwidth = 285;
		$newheight = 285;
		$image = imagecreatetruecolor($newwidth, $newheight);
		imagealphablending($image, true);
		imagecopyresampled($image, $image_s, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
//create masking
		$mask = imagecreatetruecolor($newwidth, $newheight);
		$transparent = imagecolorallocate($mask, 255, 0, 0);
		imagecolortransparent($mask, $transparent);
		imagefilledellipse($mask, $newwidth / 2, $newheight / 2, $newwidth, $newheight, $transparent);
		$red = imagecolorallocate($mask, 0, 0, 0);
		imagecopymerge($image, $mask, 0, 0, 0, 0, $newwidth, $newheight, 100);
		imagecolortransparent($image, $red);
		imagefill($image, 0, 0, $red);
//output, save and free memory
		header('Content-type: image/png');
		imagepng($image);
		imagepng($image, 'uploads/channel/image.png');
		imagedestroy($image);
		imagedestroy($mask);
	}

	public function daftar_vod()
	{
		$this->load->model('M_vod');
		delete_cookie("cookie_vod");
		delete_cookie("cookie_jempol");
		$data = array('title' => 'Daftar VOD', 'menuaktif' => '4',
			'isi' => 'v_vod');

		$data['dafvideo'] = $this->M_vod->getVODAll();

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper3', $data);

	}

	public function daftarchannel()
	{
		$this->load->model('M_channel');
		$data = array('title' => 'Daftar Channel', 'menuaktif' => '15',
			'isi' => 'v_channel_all');

		$data['dafchannel'] = $this->M_channel->getChannelSiap(0);

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperchannel1', $data);

	}

	public function gantistatus()
	{
		$this->load->model('M_channel');
		$id = $_POST['id'];
		$statusnya = $_POST['status'];
		$this->M_channel->updatestatus($id, $statusnya);
		echo 'ok';
	}


	public function guru($kodeusr, $linklist = null)
	{
		if ($this->session->userdata('a02'))
			$cekuser = 2;
		else
			$cekuser = 2;
		$this->load->model('M_channel');
		$data = array('title' => 'Playing VOD', 'menuaktif' => $cekuser,
			'menuaktif' => '17');
		if ($linklist == null)
			$data['isi'] = 'v_channel_guru';
		else {
			$data['isi'] = 'v_channel_guru_pilih';
			$paketsoal = $this->M_channel->getPaket($linklist);
			$data['statussoal'] = $paketsoal[0]->statussoal;
			$data['pengunggah'] = $paketsoal[0]->first_name . " " . $paketsoal[0]->last_name;

			if ($this->session->userdata("loggedIn")) {
				$iduser = $this->session->userdata("id_user");
				$nilaiuser = $this->M_channel->ceknilai($linklist, $iduser);
				$data['nilaiuser'] = $nilaiuser;
				$data['masuk'] = 1;
			} else
				$data['masuk'] = 0;

			$data['uraianmateri'] = $paketsoal[0]->uraianmateri;
			$data['filemateri'] = $paketsoal[0]->filemateri;

			$data['asal'] = "menu";
		}

		$kd_user = substr($kodeusr, 5);
		$npsn = "";
		$data['kdusr'] = "orang";

		if ($this->session->userdata('loggedIn')) {
			$npsn = $this->session->userdata('npsn');

			if ($this->session->userdata('id_user') == $kd_user)
				$data['kdusr'] = "pemilik";
		}

		if ($npsn == "")
			$npsn = "000";

		$data['dafplaylist'] = $this->M_channel->getDafPlayListSaya($kd_user);

		if ($data['dafplaylist']) {
			$data['punyalist'] = true;
			$statusakhir = $data['dafplaylist'][0]->link_list;
			if ($linklist == null) {
				$data['playlist'] = $this->M_channel->getPlayListSaya($kd_user, $statusakhir);

			} else {
				$data['playlist'] = $this->M_channel->getPlayListSaya($kd_user, $linklist);

			}


		} else {
//            $data['playlist'] = $this->M_channel->getPlayListGuru($kd_user);
			$data['punyalist'] = false;
//			if (!$this->session->userdata('loggedIn')) {
//				redirect('/');
//			}
		}


		$data['infoguru'] = $this->M_channel->getInfoGuru($kd_user);
		$data['dafvideo'] = $this->M_channel->getVodGuru($kd_user);
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		$data['kd_user'] = $kd_user;
		$data['id_playlist'] = $linklist;

		if ($this->is_connected())
			$data['nyambung'] = true;
		else
			$data['nyambung'] = false;


		$this->load->view('layout/wrapperchannel', $data);
	}

	public function bimbel($linklist = null, $iduser = null)
	{
		if ($this->session->userdata('bimbel') == 1) {

			$this->load->model('M_channel');
			$data = array('title' => 'BIMBEL', 'menuaktif' => 0,
				'isi' => 'v_channel_bimbel', 'menuaktif' => '17');

			$data['dafplaylist'] = $this->M_channel->getDafPlayListBimbel($iduser);

			if ($data['dafplaylist']) {
				$data['punyalist'] = true;
				$statusakhir = $data['dafplaylist'][0]->link_list;
//				echo "<br><br><br><br><br>SattusAkhir:".$statusakhir;
				if ($linklist == null) {
					$data['playlist'] = $this->M_channel->getPlayListBimbel($statusakhir, $iduser);

				} else {
					$data['playlist'] = $this->M_channel->getPlayListBimbel($linklist, $iduser);

				}


			} else {
//            $data['playlist'] = $this->M_channel->getPlayListGuru($kd_user);
				$data['punyalist'] = false;
//			if (!$this->session->userdata('loggedIn')) {
//				redirect('/');
//			}
			}


			$data['infoguru'] = $this->M_channel->getInfoGuru($iduser);
//			$data['dafvideo'] = $this->M_channel->getVodGuru($iduser);
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();
			$data['iduser'] = $iduser;
			$data['id_playlist'] = $linklist;


			$this->load->view('layout/wrapper2', $data);
		} else
			redirect("/informasi/infobimbel");
	}

	public function saya()
	{
		if (!$this->session->userdata('loggedIn') || $this->session->userdata('tukang_verifikasi') > 2
			|| $this->session->userdata('tukang_kontribusi') > 2) {
			redirect('/');
		} else {
			$this->load->model('M_channel');
			$data = array('title' => 'Daftar Video', 'menuaktif' => '16',
				'isi' => 'v_channel_seting');

			$data['statusvideo'] = 'semua';

			if ($this->is_connected())
				$data['nyambung'] = true; else
				$data['nyambung'] = false;

			$id_user = $this->session->userdata('id_user');
			/*
			if ($this->session->userdata('a01')) {
				$data['dafvideo'] = $this->M_video->getVideoAll();
				$data['statusvideo'] = 'admin';
			} else if ($this->session->userdata('a02') || $this->session->userdata('a03')) {
				$data['dafvideo'] = $this->M_video->getVideoUser($id_user);
			}*/

			$data['dafvideoku'] = $this->M_channel->getVODList($id_user);
			//$data['dafplaylist'] = $this->M_channel->getPlayListSaya($id_user);
			$data['dafplaylist'] = $this->M_channel->getDafPlayListSaya($id_user);

			if ($data['dafplaylist']) {
				$data['punyalist'] = true;
				$statusakhir = $data['dafplaylist'][0]->link_list;
				$data['playlist'] = $this->M_channel->getPlayListSaya($id_user, $statusakhir);
			} else {
				$data['punyalist'] = false;
			}

			$this->load->view('layout/wrapperchannel', $data);
		}
	}

	public function playlistsekolah()
	{
		if ($this->is_connected()) {

			if (!$this->session->userdata('a02')) {
				redirect('/');
			}

			$this->load->model('M_channel');
			$data = array('title' => 'Playlist Sekolah', 'menuaktif' => '18',
				'isi' => 'v_channel_playlistsekolah');

			$npsn = $this->session->userdata('npsn');
			$data['dafpaket'] = $this->M_channel->getPaketSekolah($npsn);

//            $url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
//            if ($url)
//            {
//				$content = file_get_contents($url);
//				$obj = json_decode($content, true);
//				$stampdate = substr($obj['datetime'], 0, 19);
//
//				$date = strtotime($stampdate);
//				$tglnow = date('Y-M-d H:i:s', $date);
//			}


			//echo "<br><br><br><br><br>";
//        foreach ($data['dafpaket'] as $datane)
//        {
//            //echo "Tgl sekarang: ".$tglnow;
//            //echo "Tgl tayang: ".date('Y-M-d H:i:s', strtotime($datane->tanggal_tayang));
//
//            if ($date<strtotime($datane->tanggal_tayang))
//            {
//                //echo "Belum";
//                $this->M_channel->update_statuspaket_sekolah($datane->link_list,1);
//            }
//            else
//            {
//                //echo "Lewat";
//                $this->M_channel->update_statuspaket_sekolah($datane->link_list,2);
//            }
//            if ($datane->durasi_paket=="00:00:00")
//                $this->M_channel->update_statuspaket_sekolah($datane->link_list,0);
//        }

			//die();

			$data['dafpaket'] = $this->M_channel->getPaketSekolah($npsn);

			$this->load->view('layout/wrapperinduk2', $data);

		} else {
			echo "SAMBUNGAN INTERNET TIDAK TERSEDIA";
			die();
		}


	}

	public function playlisttve()
	{
		if (!$this->session->userdata('a01')) {
			redirect('/');
		}

		$this->load->model('M_channel');
		$data = array('title' => 'Playlist TVSekolah', 'menuaktif' => '20',
			'isi' => 'v_channel_playlisttve');

		$npsn = $this->session->userdata('npsn');
		$data['dafpaket'] = $this->M_channel->getPaketTVE($npsn);

//        $url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
//        $obj = json_decode(file_get_contents($url), true);
//        $stampdate = substr($obj['datetime'], 0, 19);
//
//        $date = strtotime($stampdate);
//        $tglnow = date('Y-M-d H:i:s', $date);

		$data['dafpaket'] = $this->M_channel->getPaketTVE($npsn);

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function playlistguru($linklist = null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}

		$this->load->model('M_channel');
		$data = array('title' => 'Playlist Modul', 'menuaktif' => '19',
			'isi' => 'v_channel_playlistguru');

		$id_user = $this->session->userdata('id_user');
		$data['linklist'] = $linklist;
		$id_event = null;

		if ($linklist == null) {
			$id_event = 0;
		} else {
			$judulevent = $this->M_channel->cekevent_pl_guru($linklist);
			if ($judulevent) {
				$data['judulevent'] = $judulevent->nama_event;
				$data['subjudulevent'] = $judulevent->sub2_nama_event;
				$id_event = $judulevent->id_event;
			}
		}

		$data['dafpaket'] = $this->M_channel->getPaketGuru($id_user, $id_event);
//        echo "<pre>";
//        echo var_dump($data['dafpaket']);
//        echo "</pre>";
//        die();

		if ($this->is_connected()) {
//            $url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
//            $obj = json_decode(file_get_contents($url), true);
//            $stampdate = substr($obj['datetime'], 0, 19);
//
//            $date = strtotime($stampdate);
//			echo "<br><br><br><br><br>";
//			$url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
			$url = false;
			if ($url) {
				$content = file_get_contents($url);
				$obj = json_decode($content, true);
				$stampdate = substr($obj['datetime'], 0, 19);

				$date = strtotime($stampdate);
				//$tglnow = date('Y-M-d H:i:s', $date);
				//echo "PUSAT";
			} else {
				date_default_timezone_set('Asia/Jakarta');
				$date = strtotime("now");
				//echo "KOMPUTER";
			}
		}

		$tglnow = date('Y-M-d H:i:s', $date);

		//echo $tglnow;

		foreach ($data['dafpaket'] as $datane) {
			//echo "Tgl sekarang: ".$tglnow;
			//echo "Tgl tayang: ".date('Y-M-d H:i:s', strtotime($datane->tanggal_tayang));

			if ($date < strtotime($datane->tanggal_tayang)) {
				//echo "Belum";
				$this->M_channel->update_statuspaket($datane->link_list, 1);
			} else {
				//echo "Lewat";
				$this->M_channel->update_statuspaket($datane->link_list, 2);
			}
			if ($datane->durasi_paket == "00:00:00")
				$this->M_channel->update_statuspaket($datane->link_list, 0);
		}

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function playlistbimbel()
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02') && $this->session->userdata('bimbel') != 1) {
			redirect('/');
		}

		$this->load->model('M_channel');
		$data = array('title' => 'Playlist BIMBEL', 'menuaktif' => '32',
			'isi' => 'v_channel_playlistbimbel');

		$id_user = $this->session->userdata('id_user');
		$data['dafpaket'] = $this->M_channel->getPaketBimbel($id_user);

//		if ($this->is_connected()) {
//			$url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
//			$obj = json_decode(file_get_contents($url), true);
//			$stampdate = substr($obj['datetime'], 0, 19);
//
//			$date = strtotime($stampdate);
//		}
//		//$tglnow = date('Y-M-d H:i:s', $date);

//		if ($this->is_connected()) {
//			$url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
//			$fgc = @file_get_contents($url);
//			if($fgc===FALSE)
//			{
//				$now = new DateTime();
//				$now->setTimezone(new DateTimezone('Asia/Jakarta'));
//				$stampdate = $now->format("Y-m-d") ."T".$now->format("H:i:s");
//			}
//			else
//			{
//				$obj = json_decode($fgc, true);
//				$stampdate = substr($obj['datetime'], 0, 19);
//			}
//
//		}
//		else
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$stampdate = $now->format("Y-m-d") . "T" . $now->format("H:i:s");
		}

		$date = strtotime($stampdate);

		//echo "<br><br><br><br><br>";
		foreach ($data['dafpaket'] as $datane) {
			//echo "Tgl sekarang: ".$tglnow;
			//echo "Tgl tayang: ".date('Y-M-d H:i:s', strtotime($datane->tanggal_tayang));

			if ($date < strtotime($datane->tanggal_tayang)) {
				//echo "Belum";
				$this->M_channel->update_statuspaket_bimbel($datane->link_list, 1);
			} else {
				//echo "Lewat";
				$this->M_channel->update_statuspaket_bimbel($datane->link_list, 2);
			}
			if ($datane->durasi_paket == "00:00:00")
				$this->M_channel->update_statuspaket_bimbel($datane->link_list, 0);
		}

		//die();

		$data['dafpaket'] = $this->M_channel->getPaketBimbel($id_user);

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function seting($kode = null)
	{
		$this->load->model('M_channel');
		$data = array('title' => 'Setting', 'menuaktif' => '4',
			'isi' => 'v_channel_seting');

		$data['dafchannel'] = $this->M_channel->getSekolah();
		$data['dafvideo'] = $this->M_channel->getVodAll();
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperchannel', $data);
	}

	public function gantisifat()
	{
		$this->load->model('M_channel');
		$id = $_POST['id'];
		$statusnya = $_POST['status'];
		$cekdulu = $this->M_channel->getInfoVideo($id);
		if ($cekdulu->dilist == 1)
			echo "jangan";
		else {
			$this->M_channel->updatesifat($id, $statusnya);
			echo 'ok';
		}
	}

	public function gantilist()
	{
		$this->load->model('M_channel');
		$id = $_POST['id'];
		$statusnya = $_POST['status'];
		$this->M_channel->updatedilist($id, $statusnya);
		echo 'ok';
	}

	public function updatelist()
	{
		$this->load->model('M_channel');
		$daftarlist = $_POST['datalist'];

		$data = array();
		$id = array();
		$npsn = array();


		$jml_list = 0;

		$datalist = json_decode($daftarlist);
		//echo $datalist[0];

		for ($a = 1; $a <= count($datalist); $a++) {
			$data[$a]['urutan'] = $a;
			$data[$a]['npsn'] = $this->session->userdata('npsn');
			$data[$a]['id_user'] = $this->session->userdata('id_user');
			$data[$a]['id_video'] = $datalist[$a - 1];
			//echo $data['id_video'][$a];
		}

		$this->M_channel->insertplaylist($data);

	}

	public function addplaylist()
	{
		$data = array();
		$data['nama_paket'] = $_POST['ipaket'];
		$data['id_jenjang'] = $_POST['ijenjang'];
		if ($data['id_jenjang'] == 5 || $data['id_jenjang'] == 6)
			$data['id_jurusan'] = $_POST['ijurusan'];
		else
			$data['id_jurusan'] = 0;
		$data['id_kelas'] = $_POST['ikelas'];
		$data['id_mapel'] = $_POST['imapel'];

		$tgtyg = $_POST['datetime'];
		if ($tgtyg != "")
			$data['tanggal_tayang'] = $tgtyg;
		$linklist = $_POST['linklist'];
		$linklist_event = $_POST['linklist_event'];
		$this->load->model('M_channel');

		if ($linklist_event != null) {
			$judulevent = $this->M_channel->cekevent_pl_guru($linklist_event);
			$data['id_event'] = $judulevent->id_event;
		}


		if ($_POST['addedit'] == "add") {
			$mikro = str_replace(".", "", microtime(false));
			$mikro = str_replace(" ", "", $mikro);
			$mikro = base_convert($mikro, 10, 36);
			$data['link_list'] = $mikro;
			$data['durasi_paket'] = '00:00:00';
			$data['status_paket'] = '0';
			$data['id_user'] = $this->session->userdata('id_user');
			$data['npsn_user'] = $this->session->userdata('npsn');
			$this->M_channel->addplaylist($data);
		} else {
			$link_list = $_POST['linklist'];
			$this->M_channel->updatePlaylist($link_list, $data);
		}

		if ($linklist_event == null)
			redirect('channel/playlistguru');
		else
			redirect('channel/playlistguru/' . $linklist_event);
	}

	public function addplaylist_bimbel()
	{
		$data = array();
		$data['nama_paket'] = $_POST['ipaket'];
		$data['tanggal_tayang'] = $_POST['datetime'];
		$data['id_jenjang'] = $_POST['ijenjang'];
		if ($data['id_jenjang'] == 5 || $data['id_jenjang'] == 6)
			$data['id_jurusan'] = $_POST['ijurusan'];
		else
			$data['id_jurusan'] = 0;
		$data['id_kelas'] = $_POST['ikelas'];
		$data['id_mapel'] = $_POST['imapel'];

		$this->load->model('M_channel');

		if ($_POST['addedit'] == "add") {
			$data['link_list'] = base_convert(microtime(false), 10, 36);
			$data['durasi_paket'] = '00:00:00';
			$data['status_paket'] = '0';
			$data['id_user'] = $this->session->userdata('id_user');
			$data['npsn_user'] = $this->session->userdata('npsn');
			$this->M_channel->addplaylist_bimbel($data);
		} else {
			$link_list = $_POST['linklist'];
			$this->M_channel->updatePlaylist_bimbel($link_list, $data);
		}


		redirect('channel/playlistbimbel');
	}

	public function addplaylist_sekolah()
	{
		$data = array();
		$data['jam_tayang'] = $_POST['time'] . ":00:00";
		$data['hari'] = $_POST['hari'];
		$this->load->model('M_channel');

		if ($_POST['addedit'] == "add") {
			$data['link_list'] = base_convert(microtime(false), 10, 36);
			$data['durasi_paket'] = '00:00:00';
			$data['status_paket'] = '0';
			$data['npsn'] = $this->session->userdata('npsn');
			$this->M_channel->addplaylist_sekolah($data);
		} else {
			$link_list = $_POST['linklist'];
			$this->M_channel->updatePlaylist_sekolah($link_list, $data);
		}

		redirect('channel/playlistsekolah');
	}

	public function addplaylist_tve()
	{
		$data = array();
		$data['jam_tayang'] = $_POST['time'] . ":00:00";
		$data['hari'] = $_POST['hari'];
		$this->load->model('M_channel');

		if ($_POST['addedit'] == "add") {
			$data['link_list'] = base_convert(microtime(false), 10, 36);
			$data['durasi_paket'] = '00:00:00';
			$data['status_paket'] = '0';
			$this->M_channel->addplaylist_tve($data);
		} else {
			$link_list = $_POST['linklist'];
			$this->M_channel->updatePlaylist_tve($link_list, $data);
		}

		redirect('channel/playlisttve');
	}

	public function gantistatuspaket()
	{
		$this->load->model('M_channel');
		$id_paket = $_POST['id'];
		$this->M_channel->gantistatuspaket($id_paket);

	}

	public function gantistatuspaketbimbel()
	{
		$this->load->model('M_channel');
		$id_paket = $_POST['id'];
		$this->M_channel->gantistatuspaketbimbel($id_paket);

	}

	public function gantistatuspaket_sekolah()
	{
		$this->load->model('M_channel');
		$id_paket = $_POST['id'];
		$this->M_channel->gantistatuspaket_sekolah($id_paket);

	}

	public function tambahplaylist($linklist_event = null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}
		$data = array('title' => 'Tambahkan Playlist', 'menuaktif' => '15',
			'isi' => 'v_channel_tambahplaylist');
		$data['addedit'] = "add";
		$this->load->Model('M_video');
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$data['linklist_event'] = $linklist_event;

		if ($linklist_event == null) {
//			$id_event = null;
		} else {
			$this->load->model('M_channel');
			$judulevent = $this->M_channel->cekevent_pl_guru($linklist_event);
			$data['judulevent'] = $judulevent->nama_event;
			$data['subjudulevent'] = $judulevent->sub2_nama_event;
//			$id_event = $judulevent->id_event;
		}

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function tambahplaylist_bimbel()
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02') && $this->session->userdata('bimbel') != 1) {
			redirect('/');
		}
		$data = array('title' => 'Tambahkan Playlist', 'menuaktif' => '15',
			'isi' => 'v_channel_tambahplaylist_bimbel');

		$this->load->Model('M_video');
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['addedit'] = "add";
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function tambahplaylist_sekolah($hari)
	{
		if (!$this->session->userdata('a02')) {
			redirect('/');
		}
		$data = array('title' => 'Tambahkan Playlist Sekolah', 'menuaktif' => '15',
			'isi' => 'v_channel_tambahplaylist_sekolah');
		$data['addedit'] = "add";
		$data['hari'] = $hari;
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function editplaylist($kodepaket = null, $linklist = null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}
		$data = array('title' => 'Edit Playlist Modul', 'menuaktif' => '4',
			'isi' => 'v_channel_tambahplaylist');
		$data['addedit'] = "edit";

		$this->load->model('M_channel');
		$data['datapaket'] = $this->M_channel->getInfoPaket($kodepaket);

		$data['kodepaket'] = $kodepaket;
		$data['linklist_event'] = $linklist;

		$idjenjang = $data['datapaket']->id_jenjang;
		$this->load->model('M_bimbel');
		$data['dafjenjang'] = $this->M_bimbel->getJenjangAll();
		$data['dafkelas'] = $this->M_bimbel->getKelasJenjang($idjenjang);
		$data['dafmapel'] = $this->M_bimbel->getMapelJenjang($idjenjang);
		$this->load->model('M_video');
		$data['dafjurusan'] = $this->M_video->dafJurusan();
		$data['dafjurusanpt'] = $this->M_video->dafJurusanPT();

		if ($linklist == null) {
			$data['judulevent'] = "";
			$data['subjudulevent'] = "";
		} else {
			$this->load->model('M_channel');
			$judulevent = $this->M_channel->cekevent_pl_guru($linklist);
			$data['judulevent'] = $judulevent->nama_event;
			$data['subjudulevent'] = $judulevent->sub2_nama_event;
		}


		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function editplaylist_bimbel($kodepaket = null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02') && $this->session->userdata('bimbel') != 1) {
			redirect('/');
		}
		$data = array('title' => 'Edit Playlist', 'menuaktif' => '4',
			'isi' => 'v_channel_tambahplaylist_bimbel');
		$data['addedit'] = "edit";

		$this->load->model('M_channel');
		$data['datapaket'] = $this->M_channel->getInfoBimbel($kodepaket);
		$idjenjang = $data['datapaket']->id_jenjang;
		$this->load->model('M_bimbel');
		$data['dafjenjang'] = $this->M_bimbel->getJenjangAll();
		$data['dafkelas'] = $this->M_bimbel->getKelasJenjang($idjenjang);
		$data['dafmapel'] = $this->M_bimbel->getMapelJenjang($idjenjang);
		$this->load->model('M_video');
		$data['dafjurusan'] = $this->M_video->dafJurusan();
		$data['dafjurusanpt'] = $this->M_video->dafJurusanPT();

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function editplaylist_sekolah($kodepaket = null)
	{
		if (!$this->session->userdata('a02')) {
			redirect('/');
		}
		$data = array('title' => 'Edit Playlist Sekolah', 'menuaktif' => '4',
			'isi' => 'v_channel_tambahplaylist_sekolah');
		$data['addedit'] = "edit";

		$this->load->model('M_channel');
		$data['datapaket'] = $this->M_channel->getInfoPaketSekolah($kodepaket);

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function editplaylist_tve($kodepaket = null)
	{
		if (!$this->session->userdata('a01')) {
			redirect('/');
		}
		$data = array('title' => 'Edit Playlist TVE', 'menuaktif' => '4',
			'isi' => 'v_channel_tambahplaylist_tve');
		$data['addedit'] = "edit";

		$this->load->model('M_channel');
		$data['datapaket'] = $this->M_channel->getInfoPaketTVE($kodepaket);

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function hapusplaylist($kodepaket = null, $linklist = null)
	{
		$this->load->model('M_channel');
		$infopaket = $this->M_channel->getInfoPaket($kodepaket);

		$cekid = $infopaket->id_user;

		if ($cekid == $this->session->userdata('id_user')) {

			$this->load->model('M_channel');

			$idvideo = $this->M_channel->getPlayListAll($cekid, $kodepaket);
			$jmldata = 0;
			foreach ($idvideo as $datane) {
				$jmldata++;
				$data['id_video'][$jmldata] = $datane->id_video;
				$data['dilist'][$jmldata] = $datane->dilist;
			}

			if ($jmldata > 0)
				$this->M_channel->delPlayList($kodepaket, $data);
			else
				$this->M_channel->delPlayList($kodepaket, 0);

			if ($linklist == null)
				redirect('/channel/playlistguru');
			else
				redirect('/channel/playlistguru/' . $linklist);
		} else {
			redirect('/');
		}

	}

	public function hapusplaylist_bimbel($kodepaket = null)
	{
		$this->load->model('M_channel');
		$infopaket = $this->M_channel->getInfoBimbel($kodepaket);

		$cekid = $infopaket->id_user;

		if ($cekid == $this->session->userdata('id_user')) {

			$this->load->model('M_channel');

			$idvideo = $this->M_channel->getPlayListBimbelAll($kodepaket);
			$jmldata = 0;
			foreach ($idvideo as $datane) {
				$jmldata++;
				$data['id_video'][$jmldata] = $datane->id_video;
				$data['dilist'][$jmldata] = $datane->dilist;
			}

			if ($jmldata > 0)
				$this->M_channel->delPlayListBimbel($kodepaket, $data);
			else
				$this->M_channel->delPlayListBimbel($kodepaket, 0);

			redirect('/channel/playlistbimbel');
		} else {
			redirect('/');
		}

	}

	public function hapusplaylist_sekolah($kodepaket = null)
	{
		$this->load->model('M_channel');
		$infopaket = $this->M_channel->getInfoPaketSekolah($kodepaket);

		$npsn = $infopaket->npsn;

		if ($npsn == $this->session->userdata('npsn')) {

			$this->load->model('M_channel');

			$idvideo = $this->M_channel->getPlayListSekolahAll($kodepaket);
			$jmldata = 0;
			foreach ($idvideo as $datane) {
				$jmldata++;
				$data['id_video'][$jmldata] = $datane->id_video;
				$data['dilist'][$jmldata] = $datane->dilist;
			}

			$this->M_channel->delPlayListSekolah($kodepaket, $data);

			redirect('/channel/playlistsekolah');
		} else {
			redirect('/');
		}

	}

	public function inputplaylist($kodepaket = null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}
		$data = array('title' => 'Masukkan Video Playlist', 'menuaktif' => '19',
			'isi' => 'v_channel_inputplaylist');
		$this->load->model('M_channel');
		$id_user = $this->session->userdata('id_user');
		$data['dafvideo'] = $this->M_channel->getVideoUser($id_user, $kodepaket);

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);

	}

	public function urutanplaylist_guru($kodepaket = null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}
		$data = array('title' => 'Masukkan Video Playlist', 'menuaktif' => '4',
			'isi' => 'v_channel_urutanplaylist_guru');
		$this->load->model('M_channel');
		$id_user = $this->session->userdata('id_user');
		$data['dafvideo'] = $this->M_channel->getVideoUserPaket($id_user, $kodepaket);

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);

	}

	public function inputplaylist_bimbel($kodepaket = null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}
		$data = array('title' => 'Masukkan Video Playlist', 'menuaktif' => '31',
			'isi' => 'v_channel_inputplaylist_bimbel');
		$this->load->model('M_channel');
		$id_user = $this->session->userdata('id_user');
		$data['dafvideo'] = $this->M_channel->getVideoBimbel($id_user, $kodepaket);

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);

	}

	public function urutanplaylist_bimbel($kodepaket = null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}
		$data = array('title' => 'Masukkan Video Playlist', 'menuaktif' => '4',
			'isi' => 'v_channel_urutanplaylist_bimbel');
		$this->load->model('M_channel');
		$id_user = $this->session->userdata('id_user');
		$data['dafvideo'] = $this->M_channel->getVideoBimbelPaket($id_user, $kodepaket);

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);

	}

	public function inputplaylist_sekolah($kodepaket = null)
	{
		if (!$this->session->userdata('a02')) {
			redirect('/');
		}
		$data = array('title' => 'Masukkan Video Playlist Sekolah', 'menuaktif' => '4',
			'isi' => 'v_channel_inputplaylist_sekolah');
		$this->load->model('M_channel');
		$npsn = $this->session->userdata('npsn');
		$data['dafvideo'] = $this->M_channel->getVideoSekolah($npsn, $kodepaket);

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);

	}

	public function urutanplaylist_sekolah($kodepaket = null)
	{
		if (!$this->session->userdata('a02')) {
			redirect('/');
		}
		$data = array('title' => 'Masukkan Video Playlist Sekolah', 'menuaktif' => '4',
			'isi' => 'v_channel_urutanplaylist_sekolah');
		$this->load->model('M_channel');
		$data['dafvideo'] = $this->M_channel->getVideoSekolahPaket($kodepaket);

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);

	}

	public function updateurutan_sekolah()
	{

		$data = array();
		$data['id'] = $this->input->post('id');
		$data['urutan'] = $this->input->post('urutan');
		//    $this->db->update_batch('tb_channel_video_sekolah', $data, 'id');
		$this->load->model('M_channel');
		$this->M_channel->updateurutan_sekolah($data);
//        echo "Data_ID 3 = ".$data['id'][2];
//        echo "Data_URUTAN 3 = ".$data['urutan'][2];
	}

	public function updateurutan_guru()
	{

		$data = array();
		$data['id'] = $this->input->post('id');
		$data['urutan'] = $this->input->post('urutan');
		//    $this->db->update_batch('tb_channel_video_sekolah', $data, 'id');
		$this->load->model('M_channel');
		$this->M_channel->updateurutan_guru($data);
//        echo "Data_ID 3 = ".$data['id'][2];
//        echo "Data_URUTAN 3 = ".$data['urutan'][2];
	}

	public function updateurutan_bimbel()
	{

		$data = array();
		$data['id'] = $this->input->post('id');
		$data['urutan'] = $this->input->post('urutan');
		//    $this->db->update_batch('tb_channel_video_sekolah', $data, 'id');
		$this->load->model('M_channel');
		$this->M_channel->updateurutan_bimbel($data);
//        echo "Data_ID 3 = ".$data['id'][2];
//        echo "Data_URUTAN 3 = ".$data['urutan'][2];
	}

	public function inputplaylist_tve($kodepaket = null)
	{
		if (!$this->session->userdata('a01')) {
			redirect('/');
		}
		$data = array('title' => 'Masukkan Video Playlist TVE', 'menuaktif' => '4',
			'isi' => 'v_channel_inputplaylist_tve');
		$this->load->model('M_channel');

		$data['dafvideo'] = $this->M_channel->getVideoTVE($kodepaket);

		//$data['kodepaket'] = $kodepaket;

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);

	}

	public function urutanplaylist_tve($kodepaket = null)
	{
		if (!$this->session->userdata('a01')) {
			redirect('/');
		}
		$data = array('title' => 'Masukkan Video Playlist TVE', 'menuaktif' => '4',
			'isi' => 'v_channel_urutanplaylist_tve');
		$this->load->model('M_channel');

		$data['dafvideo'] = $this->M_channel->getVideoTVEPaket($kodepaket);

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);

	}

	public function updateurutan_tve()
	{

		$data = array();
		$data['id'] = $this->input->post('id');
		$data['urutan'] = $this->input->post('urutan');

		//echo "JMLDATA:".sizeof($data['id']);

		//    $this->db->update_batch('tb_channel_video_sekolah', $data, 'id');
		$this->load->model('M_channel');
		$this->M_channel->updateurutan_tve($data);
		//echo "Data_ID 3 = " . $data['id'][1];
		//echo "Data_URUTAN 3 = " . $data['urutan'][1];
	}

	public function masukinlist()
	{
		$id_video = $_POST['id'];
		$status_video = $_POST['status'];
		$linklist_paket = $_POST['kodepaket'];

		$this->load->model('M_channel');
		$infopaket = $this->M_channel->getInfoPaket($linklist_paket);

		//$datachannelvideo = $this->M_channel->getDataChannelVideo($infopaket->id);
		//$urutanakhir = $datachannelvideo[0]->urutan;

		$data1 = array();
		$data1['npsn'] = $this->session->userdata('npsn');
		$data1['id_paket'] = $infopaket->id;
		$data1['urutan'] = 0;
		$data1['id_video'] = $id_video;

		if ($status_video == 1) {
			$this->M_channel->addDataChannelVideo($data1);
			$this->M_channel->updatedilist($id_video, 1);
		} else {
			$this->M_channel->delDataChannelVideo($id_video, $infopaket->id);
			$this->M_channel->updatedilist($id_video, 0);
		}

		$datachannelvideo = $this->M_channel->getDataChannelVideo($infopaket->id);

		$durasi = 0;
		foreach ($datachannelvideo as $datane) {
			$hitungdurasi = $this->durasikedetik($datane->durasi);
			$durasi = $durasi + $hitungdurasi;
		}

		$data2['durasi_paket'] = $this->detikkedurasi($durasi);
		if ($durasi == 0)
			$data2['status_paket'] = 0;
		else {
			if (new DateTime(date('Y-m-d H:i:s')) < new DateTime($infopaket->tanggal_tayang)) {
				$data2['status_paket'] = 1;
			} else {
				$data2['status_paket'] = 2;
			}
		}

		$this->M_channel->updateDurasiPaket($linklist_paket, $data2);

		//$infovideo = $this->M_channel->getInfoVideo($id_video);
		return "OK";

		//$this->M_channel->gantistatuspaket($id_paket);
	}

	public function masukinlist_bimbel()
	{
		$id_video = $_POST['id'];
		$status_video = $_POST['status'];
		$linklist_paket = $_POST['kodepaket'];

		$this->load->model('M_channel');
		$infopaket = $this->M_channel->getInfoBimbel($linklist_paket);

		//$datachannelvideo = $this->M_channel->getDataChannelVideo($infopaket->id);
		//$urutanakhir = $datachannelvideo[0]->urutan;

		$data1 = array();
		$data1['npsn'] = $this->session->userdata('npsn');
		$data1['id_paket'] = $infopaket->id;
		$data1['urutan'] = 0;
		$data1['id_video'] = $id_video;

//		echo "Id_paket:".$infopaket->id."<br>";
//		echo "ID_VIDeo:".$id_video."<br>";
//		echo "Statusnya:".$status_video."<br>";


		if ($status_video == 1) {
			$this->M_channel->addDataChannelBimbel($data1);
			$this->M_channel->updatedilist($id_video, 1);
		} else {
			$this->M_channel->delDataChannelBimbel($id_video, $infopaket->id);
			$this->M_channel->updatedilist($id_video, 0);
		}

		$datachannelvideo = $this->M_channel->getDataChannelBimbel($infopaket->id);

		$durasi = 0;
		foreach ($datachannelvideo as $datane) {
			$hitungdurasi = $this->durasikedetik($datane->durasi);
			$durasi = $durasi + $hitungdurasi;
		}

		$data2['durasi_paket'] = $this->detikkedurasi($durasi);
		if ($durasi == 0)
			$data2['status_paket'] = 0;
		else {
			if (new DateTime(date('Y-m-d H:i:s')) < new DateTime($infopaket->tanggal_tayang)) {
				$data2['status_paket'] = 1;
			} else {
				$data2['status_paket'] = 2;
			}
		}

		$this->M_channel->updateDurasiBimbel($linklist_paket, $data2);

		//$infovideo = $this->M_channel->getInfoVideo($id_video);
		return "OK";

		//$this->M_channel->gantistatuspaket($id_paket);
	}

	public function masukinlist_sekolah()
	{
		$id_video = $_POST['id'];
		$status_video = $_POST['status'];
		$linklist_paket = $_POST['kodepaket'];

		$this->load->model('M_channel');
		$infopaket = $this->M_channel->getInfoPaketSekolah($linklist_paket);

		//$datachannelvideo = $this->M_channel->getDataChannelVideo($infopaket->id);
		//$urutanakhir = $datachannelvideo[0]->urutan;

		$data1 = array();
		$data1['npsn'] = $this->session->userdata('npsn');
		$data1['id_paket'] = $infopaket->id;
		$data1['urutan'] = 0;
		$data1['id_video'] = $id_video;

		if ($status_video == 1) {
			$this->M_channel->addDataChannelVideoSekolah($data1);
			$this->M_channel->updatedilist($id_video, 1);
		} else {
			$this->M_channel->delDataChannelVideoSekolah($id_video, $infopaket->id);
			$this->M_channel->updatedilist($id_video, 0);
		}

		$datachannelvideo = $this->M_channel->getDataChannelVideoSekolah($infopaket->id);

		$durasi = 0;
		foreach ($datachannelvideo as $datane) {
			$hitungdurasi = $this->durasikedetik($datane->durasi);
			$durasi = $durasi + $hitungdurasi;
		}

		$data2['durasi_paket'] = $this->detikkedurasi($durasi);
		if ($durasi == 0)
			$data2['status_paket'] = 0;
		else {
			if (new DateTime(date('Y-m-d H:i:s')) < new DateTime($infopaket->tanggal_tayang)) {
				$data2['status_paket'] = 1;
			} else {
				$data2['status_paket'] = 2;
			}
		}

		$this->M_channel->updateDurasiPaketSekolah($linklist_paket, $data2);

		//$infovideo = $this->M_channel->getInfoVideo($id_video);
		return "OK";

		//$this->M_channel->gantistatuspaket($id_paket);
	}

	public function masukinlist_tve()
	{
		$id_video = $_POST['id'];
		$status_video = $_POST['status'];
		$linklist_paket = $_POST['kodepaket'];

		$this->load->model('M_channel');
		$infopaket = $this->M_channel->getInfoPaketTVE($linklist_paket);

		//$datachannelvideo = $this->M_channel->getDataChannelVideo($infopaket->id);
		//$urutanakhir = $datachannelvideo[0]->urutan;

		$data1 = array();
		$data1['id_paket'] = $infopaket->id;
		$data1['urutan'] = 0;
		$data1['id_video'] = $id_video;

		if ($status_video == 1) {
			$this->M_channel->addDataChannelVideoTVE($data1);
			$this->M_channel->updatedilist($id_video, 1);
		} else {
			$this->M_channel->delDataChannelVideoTVE($id_video, $infopaket->id);
			$this->M_channel->updatedilist($id_video, 0);
		}

		$datachannelvideo = $this->M_channel->getDataChannelVideoTVE($infopaket->id);

		$durasi = 0;
		foreach ($datachannelvideo as $datane) {
			$hitungdurasi = $this->durasikedetik($datane->durasi);
			$durasi = $durasi + $hitungdurasi;
		}

		$data2['durasi_paket'] = $this->detikkedurasi($durasi);
		if ($durasi == 0)
			$data2['status_paket'] = 0;
		else {
			if (new DateTime(date('H:i:s')) < new DateTime($infopaket->jam_tayang)) {
				$data2['status_paket'] = 1;
			} else {
				$data2['status_paket'] = 2;
			}
		}

		$this->M_channel->updateDurasiPaketTVE($linklist_paket, $data2);

		//$infovideo = $this->M_channel->getInfoVideo($id_video);
		return "OK";

		//$this->M_channel->gantistatuspaket($id_paket);
	}

	public function durasikedetik($durasi)
	{
		$detikjam = (int)substr($durasi, 0, 2) * 3600;
		$detikmenit = (int)substr($durasi, 3, 2) * 60;
		$detikdetik = (int)substr($durasi, 6, 2);

		return $detikjam + $detikmenit + $detikdetik;
	}

	public function detikkedurasi($detik)
	{

		$detikjam = (int)($detik / 3600);
		$sisajam = $detik - ($detikjam * 3600);
		$detikmenit = (int)($sisajam / 60);
		$detikdetik = $sisajam - ($detikmenit * 60);

		if ($detikjam < 10)
			$detikjam = "0" . $detikjam;
		if ($detikmenit < 10)
			$detikmenit = "0" . $detikmenit;
		if ($detikdetik < 10)
			$detikdetik = "0" . $detikdetik;

		return $detikjam . ":" . $detikmenit . ":" . $detikdetik;
	}

	public function updatenonton()
	{
		if ($this->session->userdata('loggedIn')) {
			$channel = $this->input->post('channel');
			$npsn = $this->input->post('npsn');
			$idguru = $this->input->post('idguru');
			$durasi = $this->input->post('durasi');
			$linklist = $this->input->post('linklist');
			$this->load->model('M_channel');
			$cek = $this->M_channel->ceknonton($channel, $npsn, $idguru, $linklist);
			if ($cek) {
				$now = new DateTime();
				$now->setTimezone(new DateTimezone('Asia/Jakarta'));
				$tglsekarang = $now->format('Y-m-d');
				$tgldata = new DateTime($cek[0]->tanggal);
				$tgldata = $tgldata->format('Y-m-d');
				$date1 = date_create($tgldata);
				$date2 = date_create($tglsekarang);
				$diff = date_diff($date1, $date2);
				if ($cek[0]->durasi < $durasi AND intval($diff->format("%a")) == 0)
					$this->M_channel->updatenonton($channel, $npsn, $idguru, $linklist, $durasi);
				else
					$this->M_channel->insertnonton($channel, $npsn, $idguru, $linklist, $durasi);
			} else {
				$this->M_channel->insertnonton($channel, $npsn, $idguru, $linklist, $durasi);
			}
			echo "CEK DEVELOPER 101";
		} else {
			redirect("/");
		}

	}

	public function updatenpsnvideo()
	{
//		$this->load->model('M_channel');
//		$daftarvideo = $this->M_channel->getVideoAll();
//		$data = array();
//		$dobel = array();
//		$baris = 0;
//		foreach ($daftarvideo as $row) {
//			if (in_array($row->id_user,$dobel)){
//				continue;
//			} else {
//				$dobel[] = $row->id_user;
//				$baris++;
//				$npsn = $this->M_channel->getNPSN($row->id_user);
//				$data[$baris]['npsn_user'] = $npsn;
//				$data[$baris]['id_user'] = $row->id_user;
//			}
//		}
//		$this->M_channel->updateNPSNvideo($data);
	}

	public function updatenpsnpaket()
	{
//		$this->load->model('M_channel');
//		$daftarvideo = $this->M_channel->getPaketAll();
//		$data = array();
//		$dobel = array();
//		$baris = 0;
//		foreach ($daftarvideo as $row) {
//			if (in_array($row->id_user,$dobel)){
//				continue;
//			} else {
//				$dobel[] = $row->id_user;
//				$baris++;
//				$npsn = $this->M_channel->getNPSN($row->id_user);
//				$data[$baris]['npsn_user'] = $npsn;
//				$data[$baris]['id_user'] = $row->id_user;
//			}
//		}
//		$this->M_channel->updateNPSNpaket($data);
	}

	public function updateidkotaall()
	{
		$this->load->model('M_channel');
		$data = $this->M_channel->getAllChannel();
		$this->M_channel->updateidkotachannel($data);
		echo 'ok';
	}

	////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////

	public function soal($opsi = null, $linklist = null)
	{
		if ($opsi == "tampilkan") {
			$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_channel_soal');
			$paketsoal = $this->M_channel->getPaket($linklist);
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$data['judul'] = $paketsoal[0]->nama_paket;
			$data['kd_user'] = $paketsoal[0]->id_user;
			$data['dafsoal'] = $this->M_channel->getSoal($paketsoal[0]->id);
			$data['linklist'] = $linklist;
			$data['asal'] = "owner";
		} else if ($opsi == "buat") {
			$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_channel_buatsoal');
			$paket = $this->M_channel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['dafsoal'] = $this->M_channel->getSoal($paket[0]->id);
			$data['linklist'] = $linklist;
			$data['asal'] = "owner";
		} else if ($opsi == "seting") {
			$data = array('title' => 'Seting Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_channel_soal_seting');
			$paketsoal = $this->M_channel->getPaket($linklist);
			$data['paket'] = $paketsoal;
			$dafsoal = $this->M_channel->getSoal($paketsoal[0]->id);
			$data['totalsoal'] = sizeof($dafsoal);
			$data['linklist'] = $linklist;
		} else if ($opsi == "kerjakan") {
			$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_channel_soal');
			$paketsoal = $this->M_channel->getPaket($linklist);
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$data['judul'] = $paketsoal[0]->nama_paket;
			$data['kd_user'] = $paketsoal[0]->id_user;
			$data['dafsoal'] = $this->M_channel->getSoal($paketsoal[0]->id);
			$data['linklist'] = $linklist;
			$data['asal'] = "menu";
		} else if ($opsi == null) {
			redirect("/channel");
		} else if ($opsi != "tampilkan") {
			$data = array('title' => 'Mulai Soal', 'menuaktif' => '15',
				'isi' => 'v_channel_mulai');
			$paketsoal = $this->M_channel->getPaket($opsi);
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$dafsoal = $this->M_channel->getSoal($paketsoal[0]->id);
			$data['totalsoal'] = sizeof($dafsoal);
			$data['linklist'] = $opsi;
			$data['asal'] = $linklist;
		}

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper2', $data);
	}

	public function materi($opsi = null, $linklist = null)
	{
		if ($opsi == "buat") {
			$data = array('title' => 'Uraian Materi', 'menuaktif' => '15',
				'isi' => 'v_channel_buatmateri');
			$this->load->Model('M_channel');
			$paket = $this->M_channel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['uraian'] = $paket[0]->uraianmateri;
			$data['file'] = $paket[0]->filemateri;
			$data['linklist'] = $linklist;
		} else if ($opsi == "tampilkan") {
			$data = array('title' => 'Uraian Materi', 'menuaktif' => '15',
				'isi' => 'v_channel_materi');
			$paket = $this->M_channel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['uraian'] = $paket[0]->uraianmateri;
			$data['file'] = $paket[0]->filemateri;
			$data['linklist'] = $linklist;
		}
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper2', $data);
	}

	public function cekjawaban()
	{
		$jawaban_user = $this->input->post('jwbuser');
		$idjawaban_user = $this->input->post('idjwbuser');
		$iduser = $this->session->userdata('id_user');
		$linklist = $this->input->post('linklistnya');
		$paket = $this->M_channel->getPaket($linklist);
		$jmlsoalkeluar = $paket[0]->soalkeluar;
		$iduserpaket = $paket[0]->id_user;
		$kunci_jawaban = $this->M_channel->getSoal($paket[0]->id);
		$idsoal = array();
		$kuncisoal = array();

		foreach ($kunci_jawaban as $jawaban) {
			$kuncisoal[$jawaban->id_soal] = $jawaban->kunci;
		}

		$nomor = 1;
		foreach ($idjawaban_user as $jawabane) {
			$idsoal[$nomor] = $jawabane;
			$nomor++;
		}

		$nomor = 1;
		$betul = 0;
		foreach ($jawaban_user as $jawabane) {
			if ($kuncisoal[$idsoal[$nomor]] == $jawabane)
				$betul++;
			$nomor++;
		}

		if ($jmlsoalkeluar == 0)
			$jmlsoalkeluar = $nomor - 1;

		$nilai = intval($betul * (100 / $jmlsoalkeluar) * 100) / 100;

//		if($iduser!=$iduserpaket)
		{
			$nilaiuser = $this->M_channel->ceknilai($linklist, $iduser);
			$highscore = $nilaiuser->highscore;
			if ($nilai > $highscore)
				$data['highscore'] = $nilai;
			$data['score'] = $nilai;
			$update = $this->M_channel->updatenilai($data, $linklist, $iduser);
			if ($update)
				echo($nilai);
			else
				echo "gagal";
		}
//		else
//		{
//			echo ($nilai);
//		}

	}

	public function upload_gambarsoal($linklist, $id, $kodefield, $fielddb)
	{
//		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
//			redirect('/event');
//		}

		$paket = $this->M_channel->getPaket($linklist);
		$id_paket = $paket[0]->id;

		$random = rand(100, 999);
		if (isset($_FILES['f' . $kodefield])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "soal/";
		$allow = "jpg|png|jpeg";

		$config = array(
			'upload_path' => "uploads/" . $path1,
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "204800000",
			//'max_height' => "768",
			//'max_width' => "1024"
		);

		//$this->upload->initialize($config);
		$this->load->library('upload', $config);
		if ($this->upload->do_upload("f" . $kodefield)) {
			$gbr = $this->upload->data();
//			$dataupload = array('upload_data' => $this->upload->data());

			if ($gbr['image_width'] > 600) {
				$config['image_library'] = 'gd2';
				$config['source_image'] = './uploads/soal/' . $gbr['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['quality'] = '50%';
				$config['width'] = 600;
				$config['new_image'] = './uploads/soal/' . $gbr['file_name'];
				$this->load->library('image_lib', $config);
				$this->load->library('image_lib');
				$this->image_lib->initialize($config);
				if (!$this->image_lib->resize()) {
					echo $this->image_lib->display_errors();
				}
				$this->image_lib->clear();
			}
//			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile1 = $gbr['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "ggr" . $id_paket . "_" . $id . "_" . $random . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$this->M_channel->updategbrsoal($namafilebaru, $id, $fielddb);

//			if ($addedit == "edit") {
//				//rename($alamat . $namafile1, $alamat . $namafilebaru);
//				echo "Gambar berhasil diubah";
//			} else {
//				//rename($alamat . $namafile1, $alamat.'image0.jpg');
//				echo "Gambar siap";
//			}

			echo "Gambar OK";

			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			echo $this->upload->display_errors();
		}
	}

	public function updatesoal($linklist)
	{
		$tekssoal = $this->input->post('textsoal');
		$teksopsia = $this->input->post('textopsia');
		$teksopsib = $this->input->post('textopsib');
		$teksopsic = $this->input->post('textopsic');
		$teksopsid = $this->input->post('textopsid');
		$teksopsie = $this->input->post('textopsie');
		$idsoal = $this->input->post('idsoal');
		$kuncisoal = $this->input->post('kuncisoal');

		$adagbsoal = $this->input->post('adagbsoal');
		$adagbopsia = $this->input->post('adagbopsia');
		$adagbopsib = $this->input->post('adagbopsib');
		$adagbopsic = $this->input->post('adagbopsic');
		$adagbopsid = $this->input->post('adagbopsid');
		$adagbopsie = $this->input->post('adagbopsie');


		$data = array();
		$data['soaltxt'] = $tekssoal;
		$data['opsiatxt'] = $teksopsia;
		$data['opsibtxt'] = $teksopsib;
		$data['opsictxt'] = $teksopsic;
		$data['opsidtxt'] = $teksopsid;
		$data['opsietxt'] = $teksopsie;
		$data['kunci'] = $kuncisoal;

		if ($adagbsoal == "kosong")
			$data['soalgbr'] = "";
		if ($adagbopsia == "kosong")
			$data['opsiagbr'] = "";
		if ($adagbopsib == "kosong")
			$data['opsibgbr'] = "";
		if ($adagbopsic == "kosong")
			$data['opsicgbr'] = "";
		if ($adagbopsid == "kosong")
			$data['opsidgbr'] = "";
		if ($adagbopsie == "kosong")
			$data['opsiegbr'] = "";

		$this->M_channel->updatesoal($data, $idsoal);
		redirect('channel/soal/buat/' . $linklist);
	}

	public function insertsoal($linklist)
	{
		$paket = $this->M_channel->getPaket($linklist);
		$id_paket = $paket[0]->id;
		$idbaru = $this->M_channel->insertsoal($id_paket);
		if ($idbaru > 0)
			echo $idbaru;
		else
			echo "gagal";
	}

	public function delsoal()
	{
		$id = $this->input->post('id_soal');
//		if (pemilik)
		{
			if ($this->M_channel->delsoal($id))
				echo "berhasil";
			else
				echo "gagal";
		}
	}

	public function updateseting($linklist)
	{
		$soalkeluar = $this->input->post('ntampil');
		$urutsoal = $this->input->post('soalacak');
		$statussoal = $this->input->post('statussoal');

//		if (pemilik)
		{
			$data = array();
			$data['soalkeluar'] = $soalkeluar;
			$data['acaksoal'] = $urutsoal;
			$data['statussoal'] = $statussoal;

			if ($this->M_channel->updateseting($data, $linklist))
				redirect('channel/soal/buat/' . $linklist);
			else
				echo "gagal";
		}
	}

	public function updatenilai()
	{
		$nilaiakhir = $this->input->post('nilaiakhir');
		$linklist = $this->input->post('linklist');
		$iduser = $this->session->userdata('id_user');
		if ($this->session->userdata('loggedIn')) {
			$nilaiuser = $this->M_channel->ceknilai($linklist, $iduser);
			$highscore = $nilaiuser->highscore;
			if ($nilaiakhir > $highscore)
				$data['highscore'] = $nilaiakhir;
			$data['score'] = $nilaiakhir;
			$data['linklist'] = $linklist;
			$data['iduser'] = $iduser;
			$update = $this->M_channel->updatenilai($data, $linklist, $iduser);
			if ($update)
				echo "berhasil";
			else
				echo "gagal";
		}
	}

	public function updatemateri($linklist)
	{
		$tekssoal = $this->input->post('isimateri');
		$data = array();
		$data['uraianmateri'] = $tekssoal;
		if ($this->M_channel->updatemateri($data, $linklist))
			echo "sukses";
		else
			echo "gagal";

	}

	public function upload_dok($linklist)
	{
		if (isset($_FILES['filedok'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$config = array(
			'upload_path' => "uploads/materi/",
			'allowed_types' => "pdf",
			'overwrite' => TRUE,
			'max_size' => "204800000",
		);

		$this->load->library('upload', $config);
		if ($this->upload->do_upload("filedok")) {

			$dataupload = array('upload_data' => $this->upload->data());
			$random = rand(100, 999);
			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "mgr_" . $linklist . "_" . $random . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$data = array("filemateri" => $namafilebaru);
			$this->M_channel->updatemateri($data, $linklist);

			echo "Dokumen OK";

		} else {
			echo $this->upload->display_errors();
		}
	}

	public function kosonginfilemateri()
	{
		$linklist = $this->input->post('linklist');
		$data = array("filemateri" => "");
		$this->M_channel->updatemateri($data, $linklist);
		echo "sukses";
	}

	public function di_download($linklist)
	{
		$paket = $this->M_channel->getPaket($linklist);
		force_download('uploads/materi/' . $paket[0]->filemateri, null);
	}

	public function chat($jenis = null, $linklist = null)
	{
		if ($jenis==null)
			echo "<script>this.close();</script>";

		if ($linklist==null)
			$linklist="";

		$tjenis = array ("sekolah"=>1, "bimbel"=>3);
		$jenischat = $tjenis[$jenis];

		$npsnku = $this->session->userdata('npsn');
		$tglbatas = new DateTime("2020-01-01 00:00:00");

		if ($this->session->userdata('loggedIn')) {
			$id_user = $this->session->userdata("id_user");
			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $jenischat);
			if ($cekbeli)
				$tglbatas = new DateTime($cekbeli->tgl_batas);
		} else {
			$id_user = 0;
		}

		$tgl_sekarang = new DateTime();
		$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$bolehchat = false;
		if (($this->session->userdata('a02') && $this->session->userdata('sebagai')==1)
			|| $this->session->userdata('a03'))
			$bolehchat = true;

		if ($this->session->userdata('bimbel') != 1 && $jenis=="bimbel")
			$bolehchat = false;

		if ($this->session->userdata('a01'))
			$bolehchat = true;

		if (($npsnku==null || $npsnku==0 || $npsnku=="" || $tgl_sekarang > $tglbatas) && $bolehchat==false) {
			echo "<script>alert ('BELUM LOGIN ATAU BELUM PUNYA PAKET');
			this.close();</script>";
		} else {
			$data = array('title' => 'Uraian Materi', 'menuaktif' => '15',
				'isi' => 'v_chat');

			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			$datapesan = $this->M_channel->getChat($jenischat,$npsnku);


			$data['datapesan'] = $datapesan;
			$data['jenis'] = $jenischat;
			$data['linklist'] = $linklist;
			if ($jenis=="bimbel")
				$data['namasekolah'] = "BIMBEL";
			else
				$data['namasekolah'] = $this->M_channel->getSekolahKu($npsnku)[0]->nama_sekolah;
			$data['idku'] = $this->session->userdata('id_user');

			$this->load->view('layout/wrapperchat', $data);
		}
	}

	public function sendchat()
	{
		$bulan = array("","Jan","Peb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Nop","Des");
		$pesan = $this->input->post('pesanku');
		$jenis = $this->input->post('jenis');
//		$tjenis = array ("sekolah"=>1, "bimbel"=>2);
//		$jenischat = $tjenis[$jenis];

		$linklist = $this->input->post('linklistku');
		if ($this->session->userdata('loggedIn')) {
			$iduser = $this->session->userdata('id_user');

			$data = array(
				'tipe_paket' => $jenis,
				'linklist' => $linklist,
				'id_pengirim' => $iduser,
				'npsn' => $this->session->userdata('npsn'),
				'pesan' => $pesan
			);

			if ($this->M_channel->addChat($data) > 0 AND $pesan != null) {
				$now = new DateTime();
				$now->setTimezone(new DateTimezone('Asia/Jakarta'));
				$curr_date = $now->format('Y-m-d ');
				$npsnku = $this->session->userdata('npsn');
				$pesanharini = $this->M_channel->getChat($jenis, $npsnku, $linklist, $curr_date);

				$do_not_duplicate = array();

				foreach ($pesanharini as $datane) {

					if (in_array(substr($datane->tanggal,0,10), $do_not_duplicate))
					{

					}
					else
					{
						$do_not_duplicate[] = substr($datane->tanggal,0,10);
						echo '<div class="row">
			<table
			style="font-size:14px;background-color: #ecf2ff;margin:auto;text-align: center;
			width:100%;border: #5faabd 0.5px dashed;padding: 5px;">
			<tr>
			<td>'.substr($datane->tanggal,8,2)." ".
							$bulan[intval(substr($datane->tanggal,5,2))]." ".
							substr($datane->tanggal,0,4).'</td></tr>
			</table>
			</div>';
					}

					if ($datane->id_pengirim == $iduser) {
						echo '<div class="row">
			<table
			style="background-color: #f6fff7; float:right;margin-top:0px;margin-bottom:0px;max-width:80%;border: #5faabd 0.5px dashed;vertical-align: center;padding: 15px;">
			<tr>
			<td style="font-size:14px;padding:5px;padding-top: 0px;">' . $datane->pesan .
							'</td>
			<td style="vertical-align: bottom;font-size:10px;padding:5px;padding-bottom: 0px;">' . substr($datane->tanggal, 11, 5) . '</td>
			</tr>
			</table>
			</div>';
					} else {
						echo '<div class="row">
								<table
									style="float:left;max-width:80%;border: #5faabd 0.5px dashed;vertical-align: center;padding: 15px;">
									<tr>
										<td style="font-size:14px;font-weight:bold;padding:5px;padding-bottom: 0px;">' .
							$datane->first_name . " " . $datane->last_name . '</td>
										<td>
										</td>
									</tr>
									<tr>
										<td style="font-size:14px;padding:5px;padding-top: 0px;">' .
							$datane->pesan . '</td>
										<td style="vertical-align:bottom;font-size:10px;padding:5px">' .
							substr($datane->tanggal, 11, 5) . '</td>
									</tr>
								</table>
							</div>';
					}
				}
			} else {
				echo "kosong";
			}
		} else
			echo "gagal";
	}

	public function loadchat()
	{
		$bulan = array("Jan","Peb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Nop","Des");
		$jenis = $this->input->post('jenis');
//		echo "a".$jenis."b";
//		if (isset($jenis))
		{
//			$tjenis = array("sekolah" => 1, "bimbel" => 2);
//			$jenischat = $tjenis[$jenis];
			$linklist = $this->input->post('linklistku');
			if ($this->session->userdata('loggedIn')) {
				$iduser = $this->session->userdata('id_user');

				$now = new DateTime();
				$now->setTimezone(new DateTimezone('Asia/Jakarta'));
				$curr_date = $now->format('Y-m-d ');

//			if (file_exists('chats.txt')) {
//				echo "file ada";
//				die();
//			} else {
//				$namaFile = 'chats.txt';
//				$file = fopen($namaFile, 'w');
//				$konten = "";
//				fwrite($file, $konten);
//				fclose($file);
//			}
				$npsnku = $this->session->userdata('npsn');
				$pesanharini = $this->M_channel->getChat($jenis, $npsnku, $linklist, $curr_date);
				$do_not_duplicate = array();

				foreach ($pesanharini as $datane) {
					if (in_array(substr($datane->tanggal, 0, 10), $do_not_duplicate)) {

					} else {
						$do_not_duplicate[] = substr($datane->tanggal, 0, 10);
						echo '<div class="row">
			<table
			style="font-size:14px;background-color: #ecf2ff;margin:auto;text-align: center;
			width:100%;border: #5faabd 0.5px dashed;padding: 5px;">
			<tr>
			<td>' . substr($datane->tanggal, 8, 2) . " " .
							$bulan[intval(substr($datane->tanggal, 5, 2))] . " " .
							substr($datane->tanggal, 0, 4) . '</td></tr>
			</table>
			</div>';
					}

					if ($datane->id_pengirim == $iduser) {
						echo '<div class="row">
			<table
			style="font-size:14px;background-color: #f6fff7; float:right;margin-top:0px;margin-bottom:0px;max-width:80%;border: #5faabd 0.5px dashed;vertical-align: center;padding: 15px;">
			<tr>
			<td style="font-size:14px;padding:5px;padding-bottom: 0px;">' . $datane->pesan .
							'</td>
			<td style="vertical-align: bottom;font-size:10px;padding:5px;padding-bottom: 0px;">' . substr($datane->tanggal, 11, 5) . '</td>
			</tr>
			</table>
			</div>';
					} else {
						echo '<div class="row">
								<table
									style="font-size:14px;float:left;max-width:80%;border: #5faabd 0.5px dashed;vertical-align: center;padding: 15px;">
									<tr>
										<td style="font-size:14px;font-weight:bold;padding:5px;padding-bottom: 0px;">' .
							$datane->first_name . " " . $datane->last_name . '</td>
										<td>
										</td>
									</tr>
									<tr>
										<td style="font-size:14px;padding:5px;padding-top: 0px;">' .
							$datane->pesan . '</td>
										<td style="vertical-align:bottom;font-size:10px;padding:5px">' .
							substr($datane->tanggal, 11, 5) . '</td>
									</tr>
								</table>
							</div>';
					}
				}
			}
		}

	}

	public function loaduser()
	{
		$linklist = $this->input->post('linklistku');
		$jenis = $this->input->post('jenis');
//		if (isset($jenis))
		{
//			$tjenis = array("sekolah" => 1, "bimbel" => 3);
//			$jenischat = $tjenis[$jenis];

			if ($this->session->userdata('loggedIn')) {
				$iduser = $this->session->userdata('id_user');

				$now = new DateTime();
				$now->setTimezone(new DateTimezone('Asia/Jakarta'));
				$curr_time = $now->format('Y-m-d H:i:s');

				$dateinsec = strtotime($curr_time);
				$newdate = $dateinsec - 3;
				$tglbatas = date('Y-m-d H:i:s', $newdate);

				$useronline = $this->M_channel->updateOnlineChat($jenis, $linklist, $curr_time, $tglbatas, $iduser);
//			echo "<pre>";
//			echo var_dump($useronline);
//			echo "</pre>";

				echo '<table style="vertical-align: center;padding-top: 15px;padding-bottom: 15px;">';
				foreach ($useronline as $datane) {
					if (substr($datane->picture, 0, 4) == "http") {
						$gambar = $datane->picture;
					} else {
						if ($datane->picture == null)
							$gambar = base_url() . 'assets/images/profil_blank.jpg';
						else
							$gambar = base_url() . 'uploads/profil/' . $datane->picture;
					}
					echo '<tr><td style="padding-bottom: 5px;">
								<img src="' . $gambar . '" width="30px" height="auto">
							</td>
							<td style="text-align:left;padding-left: 5px;font-style: italic">' .
						$datane->first_name . " " . $datane->last_name . '</td></tr>';
				}
				echo '</table>';
			}
		}
	}
}
