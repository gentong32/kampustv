<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('video');
		$this->load->model('M_induk');
		$this->load->model('M_video');
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');

		$this->load->helper(array('Form', 'Cookie', 'String', 'captcha', 'download'));
	}

	public function index()
	{
		setcookie('basis', "live", time() + (86400), '/');
		$data = array('title' => 'Event Live', 'menuaktif' => '24',
			'isi' => 'v_live');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		//$data['daf_promo'] = $this->M_video->getPilihanPromo();
		$data['url_live'] = $this->M_video->get_url_live();
		date_default_timezone_set('Asia/Jakarta');
		$now = new DateTime();
		$harike = date_format($now, 'N');
		$data['harike'] = $harike;
		$data['jadwal_acara'] = $this->M_video->get_acara_live($harike);
		$this->load->view('layout/wrapper3', $data);
	}

	public function spesial($param = null, $param2 = null)
	{
		if ($param == 'admin') {
			if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4) {
				$this->daftarevent();
			} else {
				redirect('/event');
			}
		} else if ($param == 'acara') {
			$this->acara();
		} else if ($param == 'pilihan') {
			$this->pilihan($param2);
		} else {
			if ($param2 == null) {
				if ($this->session->userdata('sebagai') == 4 || $this->M_video->cekEventAktifbyLink($param)) {
					$data = array('title' => 'Daftar Video Event Spesial', 'menuaktif' => '23',
						'isi' => 'v_video');
					$data['message'] = $this->session->flashdata('message');
					$data['authURL'] = $this->facebook->login_url();
					$data['loginURL'] = $this->google->loginURL();
					$data['statusvideo'] = 'semua';
					$data['linkdari'] = 'event';
					$data['linkevent'] = $param;
					$data['dataevent'] = $this->M_video->getAllEvent($param);
					$data['kodeevent'] = $data['dataevent'][0]->code_event;
					$data['dafvideo'] = $this->M_video->getVideobyEvent($data['dataevent'][0]->id_event);

					$this->load->view('layout/wrapper2', $data);
				} else {
					redirect('/event/spesial/acara');
				}
			} else if ($param2 == "tambah") {
				$this->tambah($param);
			}
		}
	}

	function tambah($linkevent)
	{
		$data = array('title' => 'Tambahkan Video', 'menuaktif' => '14',
			'isi' => 'v_video_tambah');
		$data['addedit'] = "add";
		$data['linkdari'] = "event";
		$data['linkevent'] = $linkevent;
		$data['dataevent'] = $this->M_video->getbyLinkEvent($linkevent);
		$data['kodeevent'] = $data['dataevent'][0]->code_event;
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['datavideo'] = Array('status_verifikasi' => 0);
		$data['idvideo'] = 0;
		$data['namafile'] = "";
		//	if ($judul!=null)
		//		$data['judulvideo'] = $judul;
		$this->load->view('layout/wrapper', $data);
	}

	public function tambahevent()
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4)
			redirect('/event');
		$data = array('title' => 'Tambahkan Event', 'menuaktif' => '21',
			'isi' => 'v_event_tambah');
		$data['addedit'] = "add";
		$mikro = str_replace(".", "", microtime(false));
		$mikro = str_replace(" ", "", $mikro);
		$mikro = base_convert($mikro, 10, 36);
		$data['code_event'] = $mikro;

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function editevent($kdevent = null)
	{
		if ($kdevent == null) {
			redirect("/");
		}
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4)
			redirect('/event');
		$data = array('title' => 'Edit Event', 'menuaktif' => '21',
			'isi' => 'v_event_tambah');

		$data['addedit'] = "edit";
		$data['code_event'] = $kdevent;
		$data['dataevent'] = $this->M_video->getbyCodeEvent($kdevent);

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function updateevent($codeevent)
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/event');
		}

		$addedit = $this->input->post('addedit');
		$cekfile = $this->input->post('adafile');
		$cekurl = $this->input->post('adaurl');

		$data['code_event'] = $codeevent;
		$data['nama_event'] = $this->input->post('inamaevent');
		$data['iuran'] = $this->input->post('iiuran');
		$data['link_event'] = str_replace(" ", "-", $data['nama_event']);
		$data['link_event'] = str_replace("'", "", $data['link_event']);
		$data['link_event'] = str_replace('"', '', $data['link_event']);
		$data['link_event'] = strtolower($data['link_event']) . "-" . rand(100, 999);
		$data['isi_event'] = $this->input->post('iisievent');
		if ($this->input->post('nmgambar') != "")
			$data['gambar'] = "img_" . $codeevent . "." . $this->input->post('nmgambar');
		if ($cekfile == "1") {
			if ($this->input->post('nmfile') != "")
				$data['file'] = "dok_" . $codeevent . "." . $this->input->post('nmfile');
		}
		else
			$data['file'] = "";

		if ($cekurl == "1") {
			$data['url'] = $this->input->post('linkurl');
			$data['tombolurl'] = $this->input->post('tombolurl');
		} else {
			$data['url'] = "";
			$data['tombolurl'] = "";
		}

		$tgmulai = $this->input->post('datetime');
		$data['tgl_mulai'] = substr($tgmulai, 6, 4) . "-" . substr($tgmulai, 3, 2) . "-" . substr($tgmulai, 0, 2);
		$tgselesai = $this->input->post('datetime2');
		$data['tgl_selesai'] = substr($tgselesai, 6, 4) . "-" . substr($tgselesai, 3, 2) . "-" . substr($tgselesai, 0, 2);
		$data['status'] = 1;

		if ($addedit == 'edit') {
			$this->M_video->updateevent($data, $codeevent);
		} else {
			$this->M_video->addevent($data);
		}

		redirect('/event/spesial/admin');
	}


	public function hapusevent($kodeevent)
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/event');
		}
		$this->M_video->delevent($kodeevent);
		redirect('/event/spesial/admin');
	}

	public function upload_foto_event($codeevent)
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/event');
		}

		$addedit = $_POST['fotoaddedit'];

		if (isset($_FILES['file'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "event/";
		$allow = "jpg|png";

		$config = array(
			'upload_path' => "uploads/" . $path1,
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "204800000",
			//'max_height' => "768",
			//'max_width' => "1024"
		);

		$this->load->library('upload', $config);
		if ($this->upload->do_upload("file")) {

			$dataupload = array('upload_data' => $this->upload->data());

			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "img_" . $codeevent . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			if ($addedit == "edit") {
				//rename($alamat . $namafile1, $alamat . $namafilebaru);
				echo "Foto berhasil diubah";
			} else {
				//rename($alamat . $namafile1, $alamat.'image0.jpg');
				echo "Foto siap digunakan";
			}


			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			echo $this->upload->display_errors();
		}
	}

	public function upload_bukti($codeevent)
	{
		if ($this->session->userdata('verifikator') != 3) {
			redirect('/event');
		}

		if (isset($_FILES['file'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "event/bukti/";
		$allow = "jpg|png";

		$config = array(
			'upload_path' => "uploads/" . $path1,
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "204800000",
			//'max_height' => "768",
			//'max_width' => "1024"
		);

		$this->load->library('upload', $config);
		if ($this->upload->do_upload("file")) {

			$dataupload = array('upload_data' => $this->upload->data());

			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "bukti_" . $this->session->userdata('npsn') . "_" . $codeevent . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			echo "Bukti Transfer tersimpan";

			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			echo $this->upload->display_errors();
		}
	}

	public function upload_dok($codeevent)
	{

		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/event');
		}
		//$idpromo = $_POST['idpromo'];

		$addedit = $_POST['dokaddedit'];

		if (isset($_FILES['file'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "event/";
		$allow = "pdf";

		$config = array(
			'upload_path' => "uploads/" . $path1,
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "204800000",

			//'max_height' => "768",
			//'max_width' => "1024"
		);

		$this->load->library('upload', $config);
		if ($this->upload->do_upload("file")) {

			$dataupload = array('upload_data' => $this->upload->data());

			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "dok_" . $codeevent . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			if ($addedit == "edit") {

				echo "Dokumen sudah diperbarui";
			} else {
				//rename($alamat . $namafile1, $alamat.'dok0.pdf');
				echo "Dokumen siap";
			}

			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			echo $this->upload->display_errors();
		}
	}

	public function di_download($kodeevent)
	{
		//die();
		$dataevent = $this->M_video->getbyCodeEvent($kodeevent);
		// echo ($datapromo['nama_file']);
		force_download('uploads/event/' . $dataevent[0]->file, null);
		//force_download($dataevent[0]->link_event.'.pdf',base_url().'uploads/event/'.$dataevent[0]->file);
	}

	public function addbuktibayar($codeevent)
	{
		if ($this->session->userdata('verifikator') != 3) {
			redirect('/event');
		}

		$data['code_event'] = $codeevent;
		$data['id_user'] = $this->session->userdata('id_user');
		$data['npsn'] = $this->session->userdata('npsn');
		$data['nama_bank'] = $this->input->post('inamabank');
		$data['no_rek'] = $this->input->post('inorek');
		$data['nama_rek'] = $this->input->post('inamarek');
		$data['status_user'] = 1;

		if ($this->input->post('nmgambar') != "")
			$data['gambar'] = "bukti_" . $this->session->userdata('npsn') . "_" .
				$codeevent . "." . $this->input->post('nmgambar');

		$this->M_video->addbukti($data);

		redirect('/event/spesial/acara');
	}

	public function daftarevent()
	{
		$data = array('title' => 'Daftar Event Spesial', 'menuaktif' => '25',
			'isi' => 'v_event');
		$this->load->model("M_video");

		if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4)
			$data['dataevent'] = $this->M_video->getAllEvent();
		else
			redirect('/event');
		$this->load->view('layout/wrapper2', $data);
	}

	public function ikutevent($codeevent)
	{
		if ($this->session->userdata('verifikator') != 3) {
			redirect('/event/spesial/acara');
		}
		$data = array('title' => 'Daftar Event Spesial', 'menuaktif' => '23',
			'isi' => 'v_event_ikut');
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$data['eventaktif'] = $this->M_video->getbyCodeEvent($codeevent);
		$data['codeevent'] = $codeevent;

		$this->load->view('layout/wrapperpayment', $data);
	}

	public function gantistatus()
	{
		$this->load->model('M_video');
		$code = $_POST['code'];
		$statusnya = $_POST['status'];
		$this->M_video->updatestatus($code, $statusnya);
//		echo 'ok';
	}

	public function gantistatususer()
	{
		if ($this->session->userdata('verifikator') != 3)
			redirect('/event');
		$this->load->model('M_video');
		$code = $_POST['code'];
		$npsn = $_POST['npsn'];
		$statusnya = $_POST['status'];
		$this->M_video->updatestatususer($code, $npsn, $statusnya);
//		echo 'ok';
	}

	public function konfirmasi($kdevent)
	{
		if ($this->session->userdata('verifikator') != 3)
			redirect('/event');
		$data = array('title' => 'Konfirmasi Pembayaran', 'menuaktif' => '21',
			'isi' => 'v_event_konfirmasi');

		$data['code_event'] = $kdevent;
		$data['dataevent'] = $this->M_video->getbyCodeEvent($kdevent);

		$this->load->view('layout/wrapperinduk2', $data);
	}

	function acara()
	{
//		if($this->session->userdata('loggedIn'))
		{
			$data = array('title' => 'Acara Event', 'menuaktif' => '26',
				'isi' => 'v_event_aktif');
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			$data['eventaktif'] = $this->M_video->getAllEventAktif();
			$data['asal'] = "acara";

			if (!isset($this->session->userdata['npsn']))
				$data['npsnku'] = "999";
			else
				$data['npsnku'] = $this->session->userdata('npsn');
			if ($data['eventaktif']) {
				$data['meta_title'] = $data['eventaktif'][0]->nama_event;
				$data['meta_description'] = strip_tags($data['eventaktif'][0]->isi_event);
				$data['meta_image'] = base_url() . "uploads/event/" . $data['eventaktif'][0]->gambar;
				$data['meta_url'] = base_url() . "event/spesial/pilihan/" . $data['eventaktif'][0]->link_event;
			}

			$this->load->view('layout/wrapper3', $data);
		}
	}

	function pilihan($link)
	{
//		if($this->session->userdata('loggedIn'))
		{
			$data = array('title' => 'Acara Event', 'menuaktif' => '26',
				'isi' => 'v_event_aktif');
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			$data['eventaktif'] = $this->M_video->getAllEventAktif($link);
			$data['asal'] = "pilihan";

			if (!isset($this->session->userdata['npsn']))
				$data['npsnku'] = "999";
			else
				$data['npsnku'] = $this->session->userdata('npsn');

			$data['meta_title'] = $data['eventaktif'][0]->nama_event;
			$data['meta_description'] = strip_tags($data['eventaktif'][0]->isi_event);
			$data['meta_image'] = base_url() . "uploads/event/" . $data['eventaktif'][0]->gambar;
			$data['meta_url'] = base_url() . "event/spesial/pilihan/" . $data['eventaktif'][0]->link_event;


			$this->load->view('layout/wrapperevent', $data);
		}
	}

	public function daftarvideo($kodeevent)
	{
		setcookie('basis', "event", time() + (86400), '/');
		$data = array('title' => 'Daftar Video Event', 'menuaktif' => '14',
			'isi' => 'v_video');

		$data['statusvideo'] = 'event';
		$data['linkdari'] = "event";

		if ($this->is_connected())
			$data['nyambung'] = true;
		else
			$data['nyambung'] = false;
		$this->load->model("M_video");

		$id_user = $this->session->userdata('id_user');
		if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4) {
			$data['dafvideo'] = $this->M_video->getVideoAll();
			$data['statusvideo'] = 'admin';
		} else if ($this->session->userdata('a02') && $this->session->userdata('sebagai') != 4) {
			$data['dafvideo'] = $this->M_video->getVideoSekolah($this->session->userdata('npsn'));
			$data['statusvideo'] = 'sekolah';
//		} else if ($this->session->userdata('a03')) {
//            $data['dafvideo'] = $this->M_video->getVideoUser($id_user);
//            $data['statusvideo'] = 'pribadi';
		} else {
			redirect("/");
		}

		$this->load->view('layout/wrapper', $data);
	}

	public function aktivasi_event($codeevent)
	{
		$data = array('title' => 'Peserta Event', 'menuaktif' => '26',
			'isi' => 'v_event_aktivasi');
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$data['namaevent'] = $this->M_video->getbyCodeEvent($codeevent)[0]->nama_event;
		$data['dafuserevent'] = $this->M_video->getAllUserEvent($codeevent, 1);

		$this->load->view('layout/wrapper2', $data);
	}

	public function cekstatusbayarevent($code_event)
	{
		$npsn = $this->session->userdata('npsn');
		$this->load->model('M_video');
		if ($this->M_video->cekstatusbayarevent($code_event, $npsn))
			$isi = $this->M_video->cekstatusbayarevent($code_event, $npsn)->status_user;
		else
			$isi = 0;

		$hasil = "belum";
		if ($isi == 2)
			$hasil = "lunas";
		echo json_encode($hasil);
	}

	public function is_connected($sCheckHost = 'www.google.com')
	{
		// return (bool)@fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
		//echo file_get_contents("127.0.0.1/fordorum/informasi/cekinternet");
		$ambil = file_get_contents("https://tvsekolah.id/informasi/cekinternet");
		if ($ambil == "connected")
			return true;
		else
			return false;
		//die();
	}

	public function vervideo()
	{
		if ($this->session->userdata('a01') || $this->session->userdata('a02')) {
			$data = array('title' => 'Daftar Video', 'menuaktif' => '3',
				'isi' => 'v_videoevent');
			if ($this->session->userdata('tukang_verifikasi') == 1)
				$data['dafvideo'] = $this->M_video->getVideoVer1($this->session->userdata('npsn'));
			else if ($this->session->userdata('tukang_verifikasi') == 2)
				$data['dafvideo'] = $this->M_video->getVideoAllLain();
			else if ($this->session->userdata('a01'))
				$data['dafvideo'] = $this->M_video->getVideoAll();

			$data['statusvideo'] = 'verifikasi';
			$this->load->view('layout/wrapper', $data);
		}
	}

	public function tambahmp4()
	{
		$data = array('title' => 'Tambahkan Video', 'menuaktif' => '3',
			'isi' => 'v_video_tambahmp4');
		$data['addedit'] = "add";
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['datavideo'] = Array('status_verifikasi' => 0);
		$data['idvideo'] = 0;
		$data['namafile'] = "";
		//	if ($judul!=null)
		//		$data['judulvideo'] = $judul;
		$this->load->view('layout/wrapper', $data);
	}

	public function edit($kode, $id_video)
	{
		$data = array('title' => 'Edit Video', 'menuaktif' => '3',
			'isi' => 'v_video_tambah');

		$data['linkdari'] = "event";
		$data['kodeevent'] = $kode;

		$data['addedit'] = "edit";
		$this->load->model("M_video");
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['datavideo'] = $this->M_video->getVideo($id_video);
		$data['dafkelas'] = $this->M_video->dafKelas($data['datavideo']['id_jenjang']);
		$data['dataevent'] = $this->M_video->getbyCodeEvent($kode);
		$data['dafmapel'] = $this->M_video->dafMapel($data['datavideo']['id_jenjang'], $data['datavideo']['id_jurusan']);

		$data['dafjurusan'] = $this->M_video->dafJurusan();

		$data['idvideo'] = $id_video;

		$data['jenisvideo'] = "mp4";
		if ($data['datavideo']['link_video'] != "") {
			//$idyoutube=substr($data['datavideo']['link_video'],32,11);
			//$data['infodurasi'] = $this->getVideoInfo($idyoutube);
			$data['jenisvideo'] = "yt";
		}

		$data['dafkd1'] = $this->M_video->dafKD($data['datavideo']['kdnpsn'], $data['datavideo']['kdkur'], $data['datavideo']['id_kelas'], $data['datavideo']['id_mapel'], $data['datavideo']['id_ki1']);
		$data['dafkd2'] = $this->M_video->dafKD($data['datavideo']['kdnpsn'], $data['datavideo']['kdkur'], $data['datavideo']['id_kelas'], $data['datavideo']['id_mapel'], $data['datavideo']['id_ki2']);
		$this->load->view('layout/wrapper', $data);
	}

	public function getVideoInfo($vidkey)
	{
		$apikey = "AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU";
		$dur = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails,snippet&id=$vidkey&key=$apikey");
		$VidDuration = json_decode($dur, true);
		foreach ($VidDuration['items'] as $vidTime) {
			$VidDuration = $vidTime['contentDetails']['duration'];
//			$channel = $vidTime['snippet']['channelId'];
//			//$dur = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails,snippet&id=$vidkey&key=$apikey");
//			//$datayt = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails,statistics&mine=true&access_token=smohLqUHcpdkt9RKauZ8zOJNieyIQjxw");
//			//$daty = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=brandingSettings&mine=true&key=AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU");
//			$daty = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=id%2Csnippet%2Cstatistics%2CcontentDetails%2CtopicDetails&id=".$channel."&key=AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU");
//			echo $channel.'<br>';
//			echo $daty;
//			die();
			preg_match_all('/(\d+)/', $VidDuration, $parts);
//            echo "UKURAN:".$uk_wkt;
			if ($VidDuration == "P0D") {
				$totalSec = "00:00:00";
			} else {
				$uk_wkt = sizeof($parts[0]);
				$hours = 0;
				$minutes = 0;
				$seconds = 0;

				if ($uk_wkt == 3) {
					$hours = intval(floor($parts[0][0]));
					$minutes = intval($parts[0][1]);
					$seconds = intval($parts[0][2]);
				} else if ($uk_wkt == 2) {
					$minutes = intval($parts[0][0]);
					$seconds = intval($parts[0][1]);
				} else if ($uk_wkt == 1) {
					$seconds = intval($parts[0][0]);
				}


				if ($hours < 10) {
					$hours = "0" . $hours;
				}
				if ($minutes < 10) {
					$minutes = "0" . $minutes;
				}
				if ($seconds < 10) {
					$seconds = "0" . $seconds;

					//$totalSec = $hours + $minutes + $seconds;
				}
				$totalSec = $hours . ':' . $minutes . ':' . $seconds;
			}

			echo $totalSec;
			return $totalSec;
//           echo $VidDuration;
//           return $VidDuration;
		}

	}


	public function hapus($kodeevent, $id_video)
	{
		$this->M_video->delsafevideo($id_video);
		$link = $this->M_video->getbyCodeEvent($kodeevent)[0]->link_event;
		redirect('/event/spesial/' . $link, '_self');
	}

	public function daftarkelas()
	{
		$idjenjang = $_GET['idjenjang'];
		$isi = $this->M_video->dafKelas($idjenjang);
		echo json_encode($isi);
	}

	public function daftarmapel()
	{
		$idjenjang = $_GET['idjenjang'];
		$idjurusan = $_GET['idjurusan'];
		$isi = $this->M_video->dafMapel($idjenjang, $idjurusan);
		echo json_encode($isi);
	}

	public function daftartema()
	{
		$idkelas = $_GET['idkelas'];
		$isi = $this->M_video->dafTema($idkelas);
		echo json_encode($isi);
	}

	public function daftarjurusan()
	{
		$idjenjang = $_GET['idjenjang'];
		if ($idjenjang == 5)
			$isi = $this->M_video->dafJurusan();
		echo json_encode($isi);
	}

	public function ambilkd()
	{
		$idkelas = $_GET['idkelas'];
		$idmapel = $_GET['idmapel'];
		$idki = $_GET['idki'];

//		$idkelas = 9;
//		$idmapel = 5;
//		$idki = 3;

		$isi = $this->M_video->dafKD($idkelas, $idmapel, $idki);
		echo json_encode($isi);
	}

	public function ambilmapel()
	{
		$idjenjang = $_GET['idjenjang'];
		if (isset ($_GET['idjurusan'])) {
			$idjurusan = $_GET['idjurusan'];
		}

		$isi = $this->M_video->dafMapel($idjenjang, $idjurusan);
		echo json_encode($isi);
	}

	public function addkd()
	{
		$idkelas = $_POST['idkelas'];
		$idmapel = $_POST['idmapel'];
		$idki = $_POST['idki'];
		$idtema = $_POST['idtema'];
		$idjurusan = $_POST['idjurusan'];
		$kade = $_POST['tekskd'];

		$data['id_kelas'] = $idkelas;
		$data['id_mapel'] = $idmapel;
		$data['id_ki'] = $idki;
		$data['id_tema'] = $idtema;
		$data['id_jurusan'] = $idjurusan;
		$data['nama_kd'] = $kade;

		$this->load->model('M_seting');
		$this->M_seting->addkd($data);

		$this->load->model('M_video');
		$isi = $this->M_video->dafKD($idkelas, $idmapel, $idki);

		echo json_encode($isi);

	}

	public function addmapel()
	{
		$idjenjang = $_POST['idjenjang'];

		if (isset($_POST['idjurusan'])) {
			$idjurusan = $_POST['idjurusan'];
			$data['c3'] = $idjurusan;
		} else {
			alert('JURUSAN BELUM DISET!');
			$idjurusan = 0;
		}

		$mapel = $_POST['teksmapel'];

		$data['id_jenjang'] = $idjenjang;


		$data['nama_mapel'] = $mapel;

		$this->load->model('M_seting');
		$this->M_seting->addmapel($data);

		$this->load->model('M_video');
		$isi = $this->M_video->dafMapel($idjenjang, $idjurusan);

		echo json_encode($isi);

	}

	public function addkat()
	{
		$kate = $_POST['tekskate'];
		$data['nama_kategori'] = $kate;

		$this->load->model('M_seting');
		$this->M_seting->addkate($data);

		$this->load->model('M_video');
		$isi = $this->M_video->getAllKategori();

		echo json_encode($isi);

	}

	public function editkd()
	{
		$idkd = $_POST['idkade'];
		$tekskade = $_POST['tekskade'];
		$idkelas = $_POST['idkelas'];
		$idmapel = $_POST['idmapel'];
		$idki = $_POST['idki'];

		$data['nama_kd'] = $tekskade;

		$this->load->model('M_seting');
		$this->M_seting->editkd($data, $idkd);

		$this->load->model('M_video');
		$isi = $this->M_video->dafKD($idkelas, $idmapel, $idki);

		echo json_encode($isi);

	}

	public function editmapel()
	{
		$idmapel = $_POST['idmapel'];
		$idjenjang = $_POST['idjenjang'];
		$teksmapel = $_POST['teksmapel'];

		$data['nama_mapel'] = $teksmapel;

		$this->load->model('M_seting');
		$this->M_seting->editmapel($data, $idmapel);

		$this->load->model('M_video');
		$isi = $this->M_video->dafMapel($idjenjang);

		echo json_encode($isi);

	}

	public function editkat()
	{
		$idkate = $_POST['idkate'];
		$tekskate = $_POST['tekskate'];


		$data['nama_kategori'] = $tekskate;

		$this->load->model('M_seting');
		$this->M_seting->editkate($data, $idkate);

		$this->load->model('M_video');
		$isi = $this->M_video->getAllKategori();

		echo json_encode($isi);

	}

	public function ambilkategori()
	{
		$this->load->model('M_video');
		$isi = $this->M_video->getAllKategori();
		echo json_encode($isi);
	}

	private function stripHTMLtags($str)
	{
		$t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
		$t = htmlentities($t, ENT_QUOTES, "UTF-8");
		return $t;
	}


	public function addvideo()
	{

		if ($this->input->post('ijudul') == null) {
			redirect('video');
		}

		$this->load->model("M_video");
		$data['id_jenis'] = $this->input->post('ijenis');
		$data['id_jenjang'] = $this->input->post('ijenjang');
		$data['id_kelas'] = $this->input->post('ikelas');
		$data['id_mapel'] = $this->input->post('imapel');
		$data['kdnpsn'] = $this->input->post('istandar');
		$data['kdkur'] = $this->input->post('ikurikulum');
		$kodeevent = $this->input->post('kodeevent');
		$data['id_event'] = $this->M_video->getbyCodeEvent($kodeevent)[0]->id_event;
		$linkevent = $this->M_video->getbyCodeEvent($kodeevent)[0]->link_event;


		if ($data['id_jenjang'] == 2)
			$data['id_tematik'] = $this->input->post('itema');
		else
			$data['id_tematik'] = 0;
		if ($data['id_jenjang'] == 5)
			$data['id_jurusan'] = $this->input->post('ijurusan');
		else
			$data['id_jurusan'] = 0;
//        echo $data['id_jurusan'];
//        die();

		$data['id_ki1'] = $this->input->post('iki1');
		$data['id_ki2'] = $this->input->post('iki2');
		$data['id_kd1_1'] = $this->input->post('ikd1_1');
		$data['id_kd1_2'] = $this->input->post('ikd1_2');
		$data['id_kd1_3'] = $this->input->post('ikd1_3');
		$data['id_kd2_1'] = $this->input->post('ikd2_1');
		$data['id_kd2_2'] = $this->input->post('ikd2_2');
		$data['id_kd2_3'] = $this->input->post('ikd2_3');
		$data['id_kategori'] = $this->input->post('ikategori');
		$data['topik'] = $this->stripHTMLtags($this->input->post('itopik'));
		$data['judul'] = $this->stripHTMLtags($this->input->post('ijudul'));
		$data['deskripsi'] = $this->stripHTMLtags($this->input->post('ideskripsi'));
		$data['keyword'] = $this->stripHTMLtags($this->input->post('ikeyword'));
		$data['link_video'] = $this->stripHTMLtags($this->input->post('ilink'));
		$data['durasi'] = $this->input->post('idurjam') . ':' . $this->input->post('idurmenit') . ':' . $this->input->post('idurdetik');

		$statusverifikasi = $this->input->post('status_ver');

		if ($this->input->post('addedit') == "add") {
			$data['id_user'] = $this->session->userdata('id_user');
			$data['npsn_user'] = $this->session->userdata('npsn');
			if ($data['link_video'] != "") {
				$data['durasi'] = $data['durasi'];
				$data['thumbnail'] = $this->input->post('ytube_thumbnail');
				$data['id_youtube'] = $this->input->post('idyoutube');
			}
			$mikro = str_replace(".", "", microtime(false));
			$mikro = str_replace(" ", "", $mikro);
			$mikro = base_convert($mikro, 10, 36);
			$data['kode_video'] = $mikro;
		} else {
			//$data['kode_video'] = base_convert($this->input->post('created'),10,16);
		}

		$data['status_verifikasi'] = 0;

		if ($this->input->post('filevideo') != "" || $this->session->userdata('tukang_kontribusi') == 2) {
			$data['status_verifikasi'] = 4;
		} else if ($statusverifikasi == 1) {
			$data['status_verifikasi'] = 0;
		} else if ($statusverifikasi == 3) {
			$data['status_verifikasi'] = 2;
		}

		if ($this->session->userdata('sebagai') == 4 || $this->session->userdata('a01')) {
			if ($this->input->post('ijenis') == 1)
				$data['status_verifikasi'] = 4;
			else
				$data['status_verifikasi'] = 2;
		}

		if ($this->session->userdata('verifikator') == 3)
			$data['status_verifikasi'] = 2;


		if ($data['id_jenis'] == 1) {
			$data['id_kategori'] = 0;
		} else {
			$data['id_jenjang'] = 0;
			$data['id_kelas'] = 0;
			$data['id_mapel'] = 0;
			$data['id_ki1'] = 0;
			$data['id_ki2'] = 0;
			$data['id_kd1_1'] = 0;
			$data['id_kd1_2'] = 0;
			$data['id_kd1_3'] = 0;
			$data['id_kd2_1'] = 0;
			$data['id_kd2_2'] = 0;
			$data['id_kd2_3'] = 0;
		}

		if ($this->input->post('addedit') == "add") {
			$idbaru = $this->M_video->addVideo($data);
			$this->M_video->updatejmlvidsekolah($this->session->userdata('npsn'));
			redirect('event/spesial/' . $linkevent);
			//redirect('video/edit/'.$idbaru);
		} else {
			$this->M_video->editVideo($data, $this->input->post('id_video'));
			$this->M_video->updatejmlvidsekolah($this->session->userdata('npsn'));
			redirect('event/spesial/' . $linkevent);
		}

	}

	public function addvideomp4()
	{
		if ($this->input->post('ijudul') == null) {
			redirect('video');
		}

		$data['id_jenis'] = $this->input->post('ijenis');
		$data['id_jenjang'] = $this->input->post('ijenjang');
		$data['id_kelas'] = $this->input->post('ikelas');
		$data['id_mapel'] = $this->input->post('imapel');
		$data['id_ki1'] = $this->input->post('iki1');
		$data['id_ki2'] = $this->input->post('iki2');
		$data['id_kd1_1'] = $this->input->post('ikd1_1');
		$data['id_kd1_2'] = $this->input->post('ikd1_2');
		$data['id_kd1_3'] = $this->input->post('ikd1_3');
		$data['id_kd2_1'] = $this->input->post('ikd2_1');
		$data['id_kd2_2'] = $this->input->post('ikd2_2');
		$data['id_kd2_3'] = $this->input->post('ikd2_3');
		$data['id_kategori'] = $this->input->post('ikategori');
		$data['topik'] = $this->input->post('itopik');
		$data['judul'] = $this->input->post('ijudul');
		$data['deskripsi'] = $this->input->post('ideskripsi');
		$data['keyword'] = $this->input->post('ikeyword');

		$data['id_user'] = $this->session->userdata('id_user');
		$data['npsn_user'] = $this->session->userdata('npsn');
		$data['kode_video'] = base_convert(microtime(false), 10, 36);

//        if ($this->session->userdata('sebagai') == 4)
//        {
//            if ($this->input->post('ijenis')==1)
//                $data['status_verifikasi'] = 4;
//            else
//                $data['status_verifikasi'] = 2;
//        }

		if ($data['id_jenis'] == 1) {
			$data['id_kategori'] = 0;
		} else {
			$data['id_jenjang'] = 0;
			$data['id_kelas'] = 0;
			$data['id_mapel'] = 0;
			$data['id_ki1'] = 0;
			$data['id_ki2'] = 0;
			$data['id_kd1_1'] = 0;
			$data['id_kd1_2'] = 0;
			$data['id_kd1_3'] = 0;
			$data['id_kd2_1'] = 0;
			$data['id_kd2_2'] = 0;
			$data['id_kd2_3'] = 0;
		}

		if ($this->input->post('addedit') == "add") {
			$idbaru = $this->M_video->addVideo($data);
			$this->upload_mp4_intern($idbaru);
			//redirect('video/edit/'.$idbaru);
		} else {
			$this->M_video->editVideo($data, $this->input->post('id_video'));
			redirect('video');
		}
	}

//    public function tesprivat()
//    {
//        $this->upload_mp4_intern(5);
//    }

	public function verifikasi($id_video)
	{
		$data = array('title' => 'Verifikasi Video', 'menuaktif' => '3',
			'isi' => 'v_video_verifikasi');

		$datav['id_video'] = $id_video;
		$datav['id_verifikator'] = $this->session->userdata('id_user');
		$datav['no_verifikator'] = $this->session->userdata('tukang_verifikasi');

		$data['datavideo'] = $this->M_video->getVideoKomplit($id_video);

		if ($datav['no_verifikator'] == 0)
			redirect('video');
		if ($datav['no_verifikator'] == 1) {
			if ($this->session->userdata('npsn') != $data['datavideo']['npsn'])
				redirect('video');
		}

		$data['dafpernyataan'] = $this->M_video->getAllPernyataan($datav['no_verifikator']);
		$data['dafpenilaian'] = $this->M_video->getPenilaian($id_video, $datav);

		$this->load->view('layout/wrapper', $data);

	}

	public function simpanverifikasi()
	{
		//echo $this->session->userdata('tukang_verifikasi');
		$verifikator = $this->session->userdata('tukang_verifikasi');
		$id_video = $this->input->post('id_video');
		$total_isian = $this->input->post('total_isian');
		$jml_diisi = $this->input->post('jml_diisi');
		$lulusgak = $this->input->post('lulusgak');
		// echo 'Total:'.$total_isian;
		// echo '<br>Diisi:'.$jml_diisi;
		//echo $lulusgak 
		//die();
		/////////////// GANTI LULUS DENGAN INPUTAN LULUSGAK, BUKAN LENGKAP ATAU TIDAKNYA///////////////////////////////////////////////////
		if ($verifikator == 1)
			$status_verifikasi = 0 + $lulusgak;
		else
			$status_verifikasi = 2 + $lulusgak;

		//echo "Total isian:".$total_isian.'-'.'Diisi:'.$jml_diisi;	die();

		if ($verifikator >= 1) {
			if ($verifikator == 1) {
				$data1['totalnilai1'] = $this->input->post('totalnilai');
				$data1['catatan1'] = $this->input->post('icatatan');
			} else {
				$data1['totalnilai2'] = $this->input->post('totalnilai');
				$data1['catatan2'] = $this->input->post('icatatan');
			}
			$data1['status_verifikasi'] = $status_verifikasi;

			$data2['id_video'] = $id_video;
			$data2['totalnilai'] = $this->input->post('totalnilai');
			$data2['no_verifikator'] = $verifikator;
			$data2['id_verifikator'] = $this->session->userdata('id_user');
			$data2['status_verifikasi'] = $status_verifikasi;

			////////// MENUNGGU SYARAT STATUS VERIFIKASI YG BENAR

			if ($id_video == null) {
				//echo "cek_3";	die();
				redirect('video/');
			} else {
				//echo "cek_4";	die();
				$data3['id_video'] = $id_video;
				$data3['id_verifikator'] = $this->session->userdata('id_user');
				$data3['no_verifikator'] = $verifikator;

				for ($c = 1; $c <= $total_isian; $c++) {
					$data3['penilaian' . $c] = $this->input->post('inilai' . $c);
					//echo $data3['penilaian'.$c];
				}

				$this->M_video->updatenilai($data1, $id_video);
				$this->M_video->addlogvideo($data2);
				$this->M_video->simpanverifikasi($data3, $id_video);
				redirect('video/');
			}
		} else {
//			echo "cek5";
//			die();
			redirect('video');
		}
	}

	public function file_view($idx = null)
	{
//    	echo "VER".$this->session->userdata('tukang_verifikasi');
//		echo "KON".$this->session->userdata('tukang_kontribusi');
//		die();

		if ($this->session->userdata('tukang_verifikasi') == 2 || $this->session->userdata('tukang_kontribusi') == 1 ||
			$this->session->userdata('tukang_kontribusi') == 2) {

			$data = array('title' => 'Upload Video', 'menuaktif' => '3',
				'isi' => 'v_video_upload');
			$data ['error'] = ' ';
			$data ['thumbs'] = false;
			$data ['idx'] = 0;
			if ($idx != null) {
				$data ['thumbs'] = true;
				$data ['idx'] = $idx;
			}

			$this->load->view('layout/wrapper', $data);
		} else {
			redirect('video');
		}

	}

	public function upload_mp4($idx = null)
	{
//    	echo "VER".$this->session->userdata('tukang_verifikasi');
//		echo "KON".$this->session->userdata('tukang_kontribusi');
//		die();

		if ($this->session->userdata('tukang_verifikasi') == 2 || $this->session->userdata('tukang_kontribusi') == 1 ||
			$this->session->userdata('tukang_kontribusi') == 2) {

			$data = array('title' => 'Upload Video', 'menuaktif' => '3',
				'isi' => 'v_video_upload');
			$data ['error'] = ' ';
			$data ['thumbs'] = false;
			$data ['idx'] = 0;
			if ($idx != null) {
				//$data ['thumbs'] = true;
				$data ['id_vid_baru'] = $idx;
			}

			$this->load->view('layout/wrapper', $data);
		} else {
			redirect('video');
		}
	}

	private function upload_mp4_intern($idbaru)
	{
//    	echo "VER".$this->session->userdata('tukang_verifikasi');
//		echo "KON".$this->session->userdata('tukang_kontribusi');
//		die();

		if ($this->session->userdata('tukang_verifikasi') == 2 || $this->session->userdata('tukang_kontribusi') == 1 ||
			$this->session->userdata('tukang_kontribusi') == 2) {

			$data = array('title' => 'Upload Video', 'menuaktif' => '3',
				'isi' => 'v_video_upload');
			$data['id_vid_baru'] = $idbaru;

			$this->load->view('layout/wrapper', $data);
		} else {
			redirect('video');
		}
	}

	public function do_upload()
	{
		$path1 = "vod/";
		$allow = "mp4";

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

			$dataupload = array('upload_data' => $this->upload->data());

			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			{

				$id_video = $this->input->post('id_vid_baru');

				date_default_timezone_set('Asia/Jakarta');
				$now = new DateTime();
				$date = $now->format('Y-m-d_H-i');
				$namafilebaru = $ext['filename'] . $date . '.' . $ext['extension'];

				rename($alamat . $namafile1, $alamat . $namafilebaru);

				//$data['id_user'] = $this->session->userdata('id_user');
				$data['file_video'] = $namafilebaru;
				$data['status_verifikasi'] = 0;
				$data['kode_video'] = base_convert(microtime(false), 10, 36);
				$this->M_video->editVideo($data, $id_video);
			}
			redirect('video/edit/' . $id_video);

			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			$error = array('error' => $this->upload->display_errors(), 'thumbs' => true, null);
			$this->load->view('v_video_upload', $error);
		}
	}

	public function do_uploadcanvas()
	{
		$namafile = $this->input->post('filevideo');
		$idvideo = $this->input->post('idvideo');

		file_put_contents('uploads/thumbs/' . $namafile, base64_decode(str_replace('data:image/png;base64,', '', $this->input->post('canvasimage'))));

		//$data = array('thumbnail' => $namafile);

		$this->M_video->updateThumbs($idvideo, $namafile);

		//echo "OK";

		//echo str_replace('data:image/octet-stream;base64,','',$this->input->post('canvasimage'));
	}

}
