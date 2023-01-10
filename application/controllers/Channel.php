<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Channel extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		error_reporting(0);
		$this->load->model("M_channel");
		$this->load->helper(array('form', 'video', 'tanggalan', 'download', 'statusverifikator'));
	}

	public function index()
	{

		$this->kampus();

//     	setcookie('acara', null, -1, '/');
// 		unset($_COOKIE['acara']); 
// 		setcookie('basis', "channel", time() + (86400), '/');
// 		$data = array();
// 		$data['konten'] = "v_channel_home";
// 		$npsn = "";
// 		if ($this->session->userdata('loggedIn')) {
// 			if ($this->session->userdata('sebagai') == 4)
// 				$npsn = "";
// 			else
// 				{
// 					$npsn = $this->session->userdata('npsn');
// 					$iduser = $this->session->userdata('id_user');
// 					$getuser = $this->M_login->getUser($iduser);
// 					$prodi = $getuser['kd_prodi'];
// 				}
// 		}

// 		if ($npsn == "")
// 			$npsn = "000";

// 		$now = new DateTime();
// 		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
// 		$hari = $now->format('N');

// 		$data['dafplaylist'] = $this->M_channel->getDafPlayListTVE(0, $hari);

// 		$durasiplaylist = $data['dafplaylist'][0]->durasi_paket;

// 		if ($durasiplaylist != "00:00:00") {
// 			// echo "Disini-02";
// 			$data['punyalist'] = true;
// 			$statusakhir = $data['dafplaylist'][0]->link_list;
// 			$data['playlist'] = $this->M_channel->getPlayListTVE($statusakhir);
// 			$linklist = $statusakhir;


// 		} else {
// 			//echo "Belum punya daftar siaran";
// 			$data['punyalist'] = false;
// //            if (!$this->session->userdata('loggedIn')) {
// //                redirect('/');
// //            }
// 		}

// 		//die();

// 		if ($npsn == "000")
// 			{
// 				$npsn = "10101010101";
// 				$prodi= "0";
// 			}

// 		$iduser = $this->session->userdata('id_user');
		

// 		$data['channelku'] = $this->M_channel->getSekolahKu($npsn, $prodi);
// 		$data['dafchannel'] = $this->M_channel->getSekolahLain($npsn, "");

// 		//unset($data['dafchannel'][0]);

// 		$indeks = 0;
// 		$batas10 = 0;
// 		foreach ($data['dafchannel'] as $row) {
// 			if ($this->cekstatusbayarchannel($row->npsn) == "off") {
// 				unset($data['dafchannel'][$indeks]);
// 			} else {
// 				$batas10++;
// 			}
// 			$indeks++;
// 			if ($batas10 > 9)
// 				unset($data['dafchannel'][$indeks]);
// //			echo $row->npsn."==".$this->cekstatusbayarchannel($row->npsn)."<br>";
// 		}


// 		$data['dafvideo'] = $this->M_channel->getVodAll();

// 		$this->load->view('layout/wrapper_umum', $data);
	}

	public function kampus()
	{
		$data['konten'] = "v_channel_kampus";
		$data['dafkampus'] =  $this->M_channel->getKampusAktifSiaran();
		// echo var_dump ($data['dafkampus']);
		
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function siaran($npsn = null, $prodi = null, $linklist = null)
	{

		if ($npsn != null) {
			$npsn = substr($npsn, 2);

			$data = array();

			$this->load->Model('M_channel');
			$getsekolah = $this->M_channel->getSekolahKu($npsn, $prodi);
			$stratasekolah = $getsekolah->strata_sekolah;
			$dafstratasekolah=array('-', 'Lite', 'Pro', 'Premium');
			$statussekolahskr = " [".$dafstratasekolah[$stratasekolah]."]";

			if (($statussekolah=="Pro" && $this->session->userdata('loggedIn'))  || $statussekolah=="Premium")
				{
					$getpilihansiaran = $this->M_channel->getsiaranaktif($npsn, $prodi);
					$data['siaranaktif'] = $getpilihansiaran->siaranaktif;
					$data['urllive'] = $getpilihansiaran->urllive;
				}
			else
				{
					$data['siaranaktif'] = 1;
					$data['urllive'] = "";
				}

			// echo $npsn;
			// echo $data['siaranaktif'];
			// die();

			if ($this->session->userdata('a02'))
				$cekuser = 2;
			else
				$cekuser = 2;

			
			$data['konten'] = "v_channel_siaran";
			

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

				$ceknpsn = $this->M_channel->getSekolahKu($npsn, $prodi);
				$data['namasekolah'] = $ceknpsn->nama_sekolah;
				$data['namaprodi'] = $ceknpsn->nama_prodi;
				// echo var_dump($ceknpsn);

				// if (sizeof($ceknpsn) == 0) {
				// 	$ceknpsn = $this->M_channel->insertkeDafSekolahKu($npsn);
				// }

				//$this->cekstatussekolah($npsn);


				$data['dafplaylist'] = $this->M_channel->getDafPlayListSekolah($npsn, $prodi, 0, $hari);
//					echo "<pre>";
//					echo var_dump($data['dafplaylist']);
//					echo "</pre>";
//					die();

				if ($data['dafplaylist']) {
					//echo "Disini-1";
					$data['punyalist'] = true;
					$statusakhir = $data['dafplaylist'][0]->link_list;
					if ($linklist == null) {
						$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $prodi, $statusakhir);

					} else {
						$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $prodi, $linklist);

					}

					/////////paksa dulu ------------
					$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $prodi, $statusakhir);
					$linklist = $statusakhir;

				} else {
					//echo "Disini-2";
					$data['punyalist'] = false;
//            if (!$this->session->userdata('loggedIn')) {
//                redirect('/');
//            }
				}

				//die();
				$data['sponsor'] = "";
				$data['url_sponsor'] = "";
				$data['durasi_sponsor'] = "00:00:00";

				$getsponsor = $this->M_channel->getsponsor($npsn, $prodi);
				if ($getsponsor) {
					//echo "<br><br><br><br><br><br><br><br>".$getsponsor->url_sponsor;
					$data['sponsor'] = $getsponsor->nama_lembaga;
					$data['url_sponsor'] = $getsponsor->url_sponsor;
					$data['durasi_sponsor'] = $getsponsor->durasi_sponsor;
				}
				//echo var_dump($getsponsor);

				$data['dafchannelguru'] = $this->M_channel->getChannelGuru($npsn, $prodi);
				$cekinfosekolah = $this->M_channel->getInfoSekolah($npsn, $prodi);

				if ($cekinfosekolah) {
					$data['infosekolah'] = $cekinfosekolah;
				}
				$data['dafvideo'] = $this->M_channel->getVodSekolah($npsn, $prodi);


			}

			$data['id_playlist'] = $linklist;

			$this->load->view('layout/wrapper_umum', $data);
		} else {

			$data = array();
			$data['konten'] = "v_channel_all_sekolah";


			if ($this->session->userdata('loggedIn') && !$this->session->userdata('a01')) {
				$npsn = $this->session->userdata('npsn');

				if ($npsn == "000")
					$npsn = "10101010101";
				else $npsn = "0";
				$data['channelku'] = $this->M_channel->getSekolahKu($npsn);
				$data['dafchannel'] = $this->M_channel->getSekolahLain($npsn, "all");
			} else {
				$data['dafchannel'] = $this->M_channel->getAllSekolah();
			}

//			echo "<pre>";
//			echo var_dump($data['dafchannel']);
//			echo "</pre>";
//			die();

			$datakosong = array();

			$indeks = 0;
			foreach ($data['dafchannel'] as $row) {
				if ($this->cekstatusbayarchannel($row->npsn) == "off") {
					$datakosong[$indeks] = $row->npsn;
					//unset($data['dafchannel'][$indeks]);
				}
				$indeks++;
//			echo $row->npsn."==".$this->cekstatusbayarchannel($row->npsn)."<br>";
			}

			$this->load->view('layout/wrapper_umum', $data);
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

	public function daftarprodi($opsi=null)
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('siag')!=3)
		redirect ("/");

		$this->load->model('M_channel');
		$data = array();
		$data['konten'] = 'v_prodi_all';

		$getchannel = $this->M_channel->getProdiAll();
		$data['dafchannel'] = $getchannel;

		$this->load->view('layout/wrapper_tabel', $data);

	}

	public function daftarchannel()
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('siag')!=3)
		redirect ("/");

		$this->load->model('M_channel');
		$data = array();
		$data['konten'] = 'v_channel_all';

		$getchannel = $this->M_channel->getChannelSiap();

		// echo var_dump($getchannel);

		// $ceksekolahpremium = ceksekolahpremium('69877907');
			
		$batascek = new DateTime('2000-01-01 00:00:00');
		$tglbatas = $batascek->format('Y-m-d H:i:s');
		$batascek2 = new DateTime('2001-01-01 00:00:00');
		$tglbatas2 = $batascek2->format('Y-m-d H:i:s');
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:59');
		$dataupdate = array();
		$adaupdate = false;
		$baris = 0;

		if ($opsi=="refresh") {
			foreach ($getchannel as $rowdata)
			{
				$baris++;
				$adaupdate = true;
				$statussekolah = "NON";
				$ceksekolahpremium = ceksekolahpremium($rowdata->npsn);
				$data['statussekolah'] = " [ - ]";
				if ($ceksekolahpremium['status_sekolah'] != "non")
				{
					$statussekolah = $ceksekolahpremium['status_sekolah'];
					if ($statussekolah == "Lite Siswa")
						$statussekolah = "Lite";
					$data['statussekolah'] = " [ " . $statussekolah . " ] ";
				}

				if($statussekolah=="Premium")
				{
					$strata = 3;
					if ($ceksekolahpremium['tipebayar']=="freepremium")
						$strata = 9;
				}
				else if($statussekolah=="Pro")
				{
					$strata = 2;
					if ($ceksekolahpremium['tipebayar']=="freepro")
						$strata = 8;
				}
				else if($statussekolah=="Lite")
				{
					$strata = 1;
					if ($ceksekolahpremium['tipebayar']=="freelite")
						$strata = 7;
				}
				else
					$strata = 0;

				$dataupdate[$baris]['npsn'] = $rowdata->npsn;
				$dataupdate[$baris]['strata'] = $strata;

				if ($strata>0)
				{
					$dataupdate[$baris]['kadaluwarsa'] = $ceksekolahpremium['tgl_berakhir'];
				}
				
			}
		}

		if ($adaupdate)
		{			
			// $this->load->model('M_channel');
			$this->M_channel->updatedafchannel($dataupdate);
			$getchannel = $this->M_channel->getChannelSiap();
		}
		
		$data['dafchannel'] = $getchannel;
		
		$this->load->view('layout/wrapper_tabel', $data);

	}

	public function daftaragency()
	{
		if (!$this->session->userdata("a01"))
		{
			redirect("/");
		}
		$this->load->model('M_channel');
		$data = array();
		$data['konten'] = 'v_agency_all';
		$getchannel = $this->M_channel->getAgencyAll();
		$data['dafagency'] = $getchannel;
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function daftarkampus()
	{
		if (!$this->session->userdata("a01"))
		{
			redirect("/");
		}
		$this->load->model('M_channel');
		$data = array();
		$data['konten'] = 'v_kampus_all';
		$getchannel = $this->M_channel->getKampusAll();
		$data['dafchannel'] = $getchannel;
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function tambahkampus()
	{
		$data = array();
		$this->load->model('M_login');
		$data['dafpropinsi'] = $this->M_login->dafpropinsi(1);
		$data['konten'] = 'v_kampus_tambah';
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function tambahprodi()
	{
		$data = array();
		$this->load->model('M_login');
		$data['dafkampus'] = $this->M_login->dafkampus();
		if ($this->session->userdata('siag')==3)
		{
			$kampus = $this->M_channel->getInfoKampus($this->session->userdata('npsn'));
			$data['namakampus'] = $kampus->nama_sekolah;
		}
		$data['konten'] = 'v_prodi_tambah';
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function addprodi()
	{
		// $npsn = $_POST['ikampus'];
		$kodeprodi = $_POST['ikode'];
		$namaprodi = $_POST['iprodi'];
		$jenjang = $_POST['ijenjang'];

		// $dataprodi['npsn_sekolah'] = $npsn;
		$dataprodi['kd_prodi'] = $kodeprodi;
		$dataprodi['nama_prodi'] = $namaprodi;
		$dataprodi['jenjang'] = $jenjang;
		// $dataprodi['pengusul'] = $this->session->userdata('id_user');

		$this->load->model('M_login');
		$addprodi = $this->M_channel->addprodi($dataprodi);

		redirect('channel/daftarprodi');
	}

	public function inputagency($idwilayah)
	{
		$data = array();
		$infolldikti = $this->M_channel->getInfoLLDIKTI($idwilayah);
		$data['namalembaga'] = $infolldikti->nama_lembaga;
		$data['lokasi'] = $infolldikti->lokasi_wilayah;
		$data['email'] = $infolldikti->email;
		$data['idwilayah'] = $idwilayah;

		$data['konten'] = 'v_agency_input';
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function masukkanagency()
	{
		$email = $this->input->post('iemail');
		$password = $this->input->post('ipassword');
		$iwilayah = $this->input->post('iwilayah');
		$namalembaga = $this->input->post('namalembaga');
	
		$data = array();

		$ceklldikti = $this->M_channel->getInfoLLDIKTI($iwilayah);
		if ($ceklldikti->email==$email)
		{
			$data['token'] = md5($password);
			$this->M_channel->updateuser($data, $ceklldikti->kd_user);
		}
		else
		{
			$data['sekolah'] = $namalembaga;
			$data['npsn'] = $iwilayah;
			$id=hash('ripemd128', $data['email']).strtotime("now");
			$data['kd_user'] = $id;
			$data['email'] = $email;
			$data['first_name'] = "";
			$data['last_name'] = "";
			$data['full_name'] = "";
			$data['alamat'] = "";
			$data['hp'] = "";
			$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$code = substr(str_shuffle($set), 0, 32);
			$data['code'] = $code;
			$data['token'] = md5($password);
			$data['siag'] = 3;

			$this->M_channel->insertuser($data);
			$this->M_channel->updateidagency($iwilayah,$id);
		}
		
		
		

		redirect("/channel/daftaragency/");
	}

	public function eksporchannel()
	{
		if ($this->session->userdata('a01')) {
			$this->load->model("M_channel");
			$data['dafchannel'] = $this->M_channel->getChannelSiap(0);
			$this->load->view('v_excel2', $data);
		}
	}

	public function export(){
		$stratasekolah = Array('-', 'Lite', 'Pro', 'Premium','','','','Free Lite','Free Pro','Free Premium');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = [
		  'font' => ['bold' => true], // Set font nya jadi bold
		  'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = [
		  'alignment' => [
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];

		$style_row2 = [
			'numberFormat' => ['formatCode'=> \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER],
			'alignment' => [
			  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
			  'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			  'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			  'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			  'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			],
			
		  ];

		$sheet->setCellValue('A1', "DAFTAR CHANNEL"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
		$sheet->getStyle('A1')->getAlignment()->setHorizontal('center'); // Set bold kolom A1
		// Buat header tabel nya pada baris ke 3
		$sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('B3', "NAMA SEKOLAH"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('C3', "JENJANG"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('D3', "VERIFIKATOR"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('E3', "TELP"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('F3', "STATUS SEKOLAH"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('G3', "NPSN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('H3', "EMAIL"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('I3', "KOTA"); // Set kolom E3 dengan tulisan "ALAMAT"
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->getStyle('A3')->applyFromArray($style_col);
		$sheet->getStyle('B3')->applyFromArray($style_col);
		$sheet->getStyle('C3')->applyFromArray($style_col);
		$sheet->getStyle('D3')->applyFromArray($style_col);
		$sheet->getStyle('E3')->applyFromArray($style_col);
		$sheet->getStyle('F3')->applyFromArray($style_col);
		$sheet->getStyle('G3')->applyFromArray($style_col);
		$sheet->getStyle('H3')->applyFromArray($style_col);
		$sheet->getStyle('I3')->applyFromArray($style_col);
		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
	
		$this->load->model("M_channel");
		$siswa = $data['dafchannel'] = $this->M_channel->getChannelSiap(0);
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($siswa as $data){ // Lakukan looping pada variabel siswa

			$stratane=$stratasekolah[$data->strata_sekolah];
			if ($data->strata_sekolah==0)
				$tstrata = $stratane;
			else
				$tstrata =  $stratane . " [ " . namabulantahun_pendek($data->kadaluwarsa)." ]";

		  $sheet->setCellValue('A'.$numrow, $no);
		  $sheet->setCellValue('B'.$numrow, $data->nama_sekolah);
		  $sheet->setCellValue('C'.$numrow, $data->jenjang);
		  $sheet->setCellValue('D'.$numrow, $data->first_name.' '.$data->last_name);
		  $sheet->setCellValue('E'.$numrow, $data->hp);
		  $sheet->setCellValue('F'.$numrow, $tstrata);
		  if ($data->strata_sekolah==0)
		  	$sheet->getStyle('F'.$numrow)->getAlignment()->setHorizontal('center');
		  $sheet->setCellValue('G'.$numrow, $data->npsn);
		  $sheet->setCellValue('H'.$numrow, $data->email);
		  $sheet->setCellValue('I'.$numrow, $data->nama_kota);
		  
		  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		  $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('E'.$numrow)->applyFromArray($style_row2);
		  $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('H'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('I'.$numrow)->applyFromArray($style_row);
		  
		  $no++; // Tambah 1 setiap kali looping
		  $numrow++; // Tambah 1 setiap kali looping
		}
		// Set width kolom
		$sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$sheet->getColumnDimension('B')->setWidth(35); // Set width kolom B
		$sheet->getColumnDimension('C')->setWidth(20);// Set width kolom E
		$sheet->getColumnDimension('D')->setWidth(25); // Set width kolom C
		$sheet->getColumnDimension('E')->setWidth(15); // Set width kolom D
		$sheet->getColumnDimension('F')->setWidth(25);// Set width kolom E
		$sheet->getColumnDimension('G')->setWidth(20);// Set width kolom E
		$sheet->getColumnDimension('H')->setWidth(30);// Set width kolom E
		$sheet->getColumnDimension('I')->setWidth(20);// Set width kolom E
		
		
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$sheet->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$sheet->setTitle("Channel Sekolah");
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data_Channel_Sekolah.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
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
		$data = array();

		if ($this->session->userdata("loggedIn")) {
			$iduser = $this->session->userdata("id_user");

		} else {
			$kodebeli = '-';
			$jenis = 0;
			$iduser = 0;
		}

		if ($linklist == null) {
			$data['konten'] = 'v_channel_guru';
			$cekbeli = $this->M_channel->getlast_kdbeli($iduser, 1);
			$nilaiuser = 0;
		} else {
			redirect("/channel/guru/" . $kodeusr);
			$data['konten'] = 'v_channel_guru_pilih';
			$paketsoal = $this->M_channel->getPaket($linklist);
			$data['statussoal'] = $paketsoal[0]->statussoal;
			$data['pengunggah'] = $paketsoal[0]->first_name . " " . $paketsoal[0]->last_name;

			if ($this->session->userdata("loggedIn")) {
				//$iduser = $this->session->userdata("id_user");
				if ($paketsoal[0]->npsn_user == $this->session->userdata('npsn')) {
					$jenis = 1;
				} else
					$jenis = 2;
				$nilaiuser = $this->M_channel->ceknilai($linklist, $iduser);
				$cekbeli = $this->M_channel->getlast_kdbeli($iduser, $jenis);

			} else {
				$data['masuk'] = 0;
				$kodebeli = "-";
				$jenis = 0;
			}


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

		if ($cekbeli) {
			$kodebeli = $cekbeli->kode_beli;
			$data['masuk'] = 1;
		} else {
			$data['masuk'] = 0;
			$kodebeli = "-";
			$jenis = 0;
		}

		if ($npsn == "")
			$npsn = "000";

		//echo "KODEBELI:".$iduser;

		$data['dafplaylist'] = $this->M_channel->getDafPlayListSaya($kd_user, $iduser, $kodebeli, 1);

		// echo "<pre>";
		// echo var_dump ($data['dafplaylist']);
		// echo "</pre>";
		// die();

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

		$data['kd_user'] = $kd_user;
		$data['id_playlist'] = $linklist;

		$this->session->set_userdata('asalpaket', 'channel');


		$this->load->view('layout/wrapper_umum', $data);
	}

	public function bimbel($linklist = null, $iduser = null)
	{
		if ($this->session->userdata('bimbel') == 3) {

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

	public function playlistkampus($opsi=null,$kodeevent=null)
	{

		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}

		$npsn = $this->session->userdata('npsn');
		$id = $this->session->userdata('id_user');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];
		$this->load->Model('M_ekskul');
		$dataekskul = $this->M_ekskul->getEkskul($npsn);
		$status = $this->cekstatus($dataekskul);
		$dibayaroleh = $this->cekbayareskul();
		$jmlpembayar = substr($dibayaroleh, 6);

		$data = array();
		$data['konten'] = 'v_channel_playlistsekolah';
		$data['dibayaroleh'] = $dibayaroleh;
		$data['jmlpembayar'] = $jmlpembayar;
		$data['status'] = $status;
		$data['opsi'] = $opsi;
		$data['kodeevent'] = $kodeevent;
		$data['dafpaket'] = $this->M_channel->getPaketSekolah($npsn, $prodi);

		$this->load->view('layout/wrapper_tabel', $data);

	}

	private function cekstatus($dataekskul)
	{
		$id = $this->session->userdata('id_user');
		$status = 0;
		$bayar10 = 0;

		foreach ($dataekskul as $datane) {
			if ($datane->status == 3)
				$bayar10++;
			if ($datane->id_user == $id) {
				$status = 1;
				if ($datane->status == 3)
					$status = 2;
			}
		}
		if ($bayar10 >= 10)
			$status = $status + 10;
		return $status;
	}

	private function cekbayareskul()
	{
		$npsn = $this->session->userdata('npsn');
		$getuser = getstatususer();
		$prodi = $getuser["kelasku"];
		$this->load->Model('M_payment');
		
		$getbayarekskul = $this->M_payment->getbayarEkskul($npsn, $prodi, null, 3, true);
		
		$jmlsiswabayar = 0;
		$jmlverbayar = 0;
		foreach ($getbayarekskul as $databayar) {
			if ($databayar->sebagai == 1) {
				$jmlverbayar++;
			} else if ($databayar->sebagai == 2) {
				$jmlsiswabayar++;
			}
		}

		if ($jmlverbayar > 0)
			return "sekolah";
		else if ($jmlsiswabayar > 0)
			return "siswa_" . $jmlsiswabayar;
		else
			return "-";
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
		if ($linklist == null && (!$this->session->userdata('a03') && !$this->session->userdata('a02'))) {
			redirect('/');
		}

		if ($linklist != null) {
			$cekevent = $this->M_channel->cekevent_pl_guru($linklist);
			if ($cekevent) {

			} else
				redirect("/");
		}

		$this->load->model('M_channel');
		$data = array('title' => 'DAFTAR KELAS SAYA', 'menuaktif' => '19',
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

//		if ($this->is_connected()) {
////            $url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
////            $obj = json_decode(file_get_contents($url), true);
////            $stampdate = substr($obj['datetime'], 0, 19);
////
////            $date = strtotime($stampdate);
////			echo "<br><br><br><br><br>";
////			$url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
//			$url = false;
//			if ($url) {
//				$content = file_get_contents($url);
//				$obj = json_decode($content, true);
//				$stampdate = substr($obj['datetime'], 0, 19);
//
//				$date = strtotime($stampdate);
//				//$tglnow = date('Y-M-d H:i:s', $date);
//				//echo "PUSAT";
//			} else {
//				date_default_timezone_set('Asia/Jakarta');
//				$date = strtotime("now");
//				//echo "KOMPUTER";
//			}
//		}

		date_default_timezone_set('Asia/Jakarta');
		$date = strtotime("now");
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

	public function playlistbimbel($linklist = null, $tambah = null)
	{
		if ($linklist == null && (!$this->session->userdata('a03') && !$this->session->userdata('a02') && $this->session->userdata('bimbel') != 3)) {
			redirect('/');
		}

		$this->load->model('M_channel');
		$data = array('title' => 'DAFTAR MODUL BIMBEL', 'menuaktif' => '31',
			'isi' => 'v_channel_playlistbimbel');

		$id_user = $this->session->userdata('id_user');
		$data['linklist'] = $linklist;
		$id_event = null;

		if ($linklist == null) {
			$id_event = 0;
		} else {
			$cekevent = $this->M_channel->cekevent_pl_guru($linklist);
			if ($cekevent) {
				$data['judulevent'] = $cekevent->nama_event;
				$data['subjudulevent'] = $cekevent->sub2_nama_event;
				$id_event = $cekevent->id_event;
			} else
				redirect("/");
		}

		$data['dafpaket'] = $this->M_channel->getPaketBimbel($id_user, $id_event);

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$stampdate = $now->format("Y-m-d") . "T" . $now->format("H:i:s");

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

		$data['dafpaket'] = $this->M_channel->getPaketBimbel($id_user, $id_event);

//		else {
//			if ($tambah == "tambah") {
//				$this->load->model('M_video');
//				$cekevent = $this->M_video->getAllEvent($linklist);
//				if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4 || $this->session->userdata('bimbel')==1) {
//						$data = array('title' => 'Daftar Video Bimbel Event Spesial', 'menuaktif' => '23',
//							'isi' => 'v_video');
//						$data['message'] = $this->session->flashdata('message');
//						$data['authURL'] = $this->facebook->login_url();
//						$data['loginURL'] = $this->google->loginURL();
//						$data['statusvideo'] = 'semua';
//						$data['linkdari'] = 'bimbel';
//						$data['linkevent'] = $linklist;
//						$data['dataevent'] = $cekevent;
//						$data['kodeevent'] = $data['dataevent'][0]->code_event;
//						$data['dafvideo'] = $this->M_video->getVideobyEvent($data['dataevent'][0]->id_event, 0);
//
//						$this->load->view('layout/wrapper2', $data);
//				} else {
//					redirect('/event/spesial/acara');
//				}
//			} else if ($tambah == "tambah") {
//				$this->tambah($linklist);
//			}
//		}

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
			if ($statusnya==2)
				echo $cekdulu->status_verifikasi_bimbel.$cekdulu->catatan3;
			else
				echo $cekdulu->status_verifikasi.$cekdulu->catatan1;
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
		$linklist_event = $_POST['linklist_event'];
		$this->load->model('M_channel');

		if ($linklist_event != null) {
			$judulevent = $this->M_channel->cekevent_pl_guru($linklist_event);
			$data['id_event'] = $judulevent->id_event;
		}

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


		if ($linklist_event == null)
			redirect('channel/playlistbimbel');
		else
			redirect('channel/playlistbimbel/' . $linklist_event);
	}

	public function addplaylist_kampus($opsi=null,$kodeevent=null)
	{
		
		$data = array();
		$data['jam_tayang'] = $_POST['time'] . ":00:00";
		$data['hari'] = $_POST['hari'];
		$this->load->model('M_channel');

		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
		$stglsekarang = $tglsekarang->format("Y-m-d H:i:s");

		$npsn = $this->session->userdata('npsn');
		$iduser = $this->session->userdata('id_user');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];

		if ($kodeevent!=null)
		{
			$kodeevent = "/".$kodeevent;
		}
		else
		{
			$kodeevent = "";
		}

		if ($_POST['addedit'] == "add") {
			$data['link_list'] = base_convert(microtime(false), 10, 36);
			$data['durasi_paket'] = '00:00:00';
			$data['status_paket'] = '0';
			$data['npsn'] = $npsn;
			$data['iduser'] = $iduser;
			$data['kd_prodi'] = $prodi;
			$data['modified'] = $stglsekarang;
			$this->M_channel->addplaylist_sekolah($data);
		} else {
			$link_list = $_POST['linklist'];
			$this->M_channel->updatePlaylist_sekolah($link_list, $data);
		}

		if ($opsi=="calver")
			{
				$this->load->model('M_marketing');
				$this->M_marketing->updateCalVerDafUser("playlist",$iduser);
			}

		$this->updateharitayang_channel($npsn, $prodi);

		redirect('channel/playlistkampus/'.$opsi.$kodeevent);
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
		if ($linklist_event == null && (!$this->session->userdata('a03') && !$this->session->userdata('a02'))) {
			redirect('/');
		}

		if ($linklist_event != null) {
			$cekevent = $this->M_channel->cekevent_pl_guru($linklist_event);
			if ($cekevent) {

			} else
				redirect("/");
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

	public function tambahplaylist_bimbel($linklist_event = null)
	{
		if ($linklist_event == null && (!$this->session->userdata('a03') && !$this->session->userdata('a02') && $this->session->userdata('bimbel') != 3)) {
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

		$data['linklist_event'] = $linklist_event;

		if ($linklist_event == null) {

		} else {
			$this->load->model('M_channel');
			$judulevent = $this->M_channel->cekevent_pl_guru($linklist_event);
			if ($judulevent) {
				$data['judulevent'] = $judulevent->nama_event;
				$data['subjudulevent'] = $judulevent->sub2_nama_event;
			} else {
				redirect("/");
			}

		}

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function tambahplaylist_kampus($hari=null,$opsi=null)
	{
//		if (!$this->session->userdata('a02')) {
//			redirect('/');
//		}

		if ($hari>=1 && $hari<=7)
		{
			$data = array();
			$data['konten'] = "v_channel_tambahplaylist_sekolah";
			$data['addedit'] = "add";
			$data['opsi'] = $opsi;
			$data['hari'] = $hari;
		}
		else
		{
			redirect("/");
		}


		$this->load->view('layout/wrapper_umum', $data);
	}

	public function editplaylist($kodepaket = null, $linklist = null)
	{
		if ($linklist == null && (!$this->session->userdata('a03') && !$this->session->userdata('a02'))) {
			redirect('/');
		}

		if ($linklist != null) {
			$cekevent = $this->M_channel->cekevent_pl_guru($linklist);
			if ($cekevent) {

			} else
				redirect("/");
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

	public function editplaylist_bimbel($kodepaket = null, $linklist = null)
	{
		if ($linklist == null && (!$this->session->userdata('a03') && !$this->session->userdata('a02') && $this->session->userdata('bimbel') != 3)) {
			redirect('/');
		}
		$data = array('title' => 'Edit Playlist', 'menuaktif' => '4',
			'isi' => 'v_channel_tambahplaylist_bimbel');
		$data['addedit'] = "edit";

		$this->load->model('M_channel');
		$data['datapaket'] = $this->M_channel->getInfoBimbel($kodepaket);

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
			$cekevent = $this->M_channel->cekevent_pl_guru($linklist);
			if ($cekevent) {
				$data['judulevent'] = $cekevent->nama_event;
				$data['subjudulevent'] = $cekevent->sub2_nama_event;
				$id_event = $cekevent->id_event;
			} else
				redirect("/");
		}

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function editplaylist_kampus($kodepaket = null, $opsi = null, $kodeevent = null)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}
		$data = array();
		$data['konten'] = "v_channel_tambahplaylist_sekolah";
		$data['addedit'] = "edit";
		$data['opsi'] = $opsi;
		$data['kodeevent'] = $kodeevent;

		$this->load->model('M_channel');
		$data['datapaket'] = $this->M_channel->getInfoPaketSekolah($kodepaket);

		$this->load->view('layout/wrapper_umum', $data);
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


			redirect('/virtualkelas/modul');

		} else {
			redirect('/');
		}

	}

	public function hapusplaylist_bimbel($kodepaket = null, $kodeevent = null)
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

			redirect('/channel/playlistbimbel/' . $kodeevent);
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

	public function inputplaylist($kodepaket = null, $kodeevent = null)
	{
		if ($kodeevent == null && (!$this->session->userdata('a03') && !$this->session->userdata('a02'))) {
			redirect('/');
		}

		if ($kodeevent != null) {
			$cekevent = $this->M_channel->cekevent_pl_guru($kodeevent);
			if ($cekevent) {

			} else
				redirect("/");
		}

		$data = array('title' => 'Masukkan Video Playlist', 'menuaktif' => '19',
			'isi' => 'v_channel_inputplaylist');
		$this->load->model('M_channel');
		$id_user = $this->session->userdata('id_user');
		$data['dafvideo'] = $this->M_channel->getVideoUser($id_user, $kodepaket, $kodeevent);

//		echo "<br><br><br><br><br><br><br><br><pre>";
//		echo var_dump($data['dafvideo']);
//		echo "</pre>";

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$data['kodeevent'] = $kodeevent;
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

	public function inputplaylist_bimbel($kodepaket = null, $kodeevent = null)
	{

		if ($kodeevent == null && (!$this->session->userdata('a03') && !$this->session->userdata('a02')
				&& !$this->session->userdata('bimbel'))) {
			redirect('/');
		}
		$data = array('title' => 'Masukkan Video Playlist', 'menuaktif' => '31',
			'isi' => 'v_channel_inputplaylist_bimbel');
		$this->load->model('M_channel');
		$id_user = $this->session->userdata('id_user');

		$data['dafvideo'] = $this->M_channel->getVideoBimbel($id_user, $kodepaket, $kodeevent);

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$data['linklist_event'] = $kodeevent;
		if ($kodeevent == null) {
			$data['judulevent'] = "";
			$data['subjudulevent'] = "";
		} else {
			$this->load->model('M_channel');
			$cekevent = $this->M_channel->cekevent_pl_guru($kodeevent);
			if ($cekevent) {
				$data['judulevent'] = $cekevent->nama_event;
				$data['subjudulevent'] = $cekevent->sub2_nama_event;
				$id_event = $cekevent->id_event;
			} else
				redirect("/");
		}

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

	public function inputplaylist_sekolah_old($kodepaket = null, $opsi = null, $kodeevent = null)
	{

		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}

		$npsn = $this->session->userdata('npsn');
		$id = $this->session->userdata('id_user');
		$this->load->Model('M_ekskul');
		$dataekskul = $this->M_ekskul->getEkskul($npsn);
		$status = $this->cekstatus($dataekskul);
		$dibayaroleh = $this->cekbayareskul();
		$jmlpembayar = substr($dibayaroleh, 6);

		$data = array();
		$data['konten'] = "v_channel_inputplaylist_sekolah";
		$data['kodeevent'] = $kodeevent;

		if ($this->session->userdata('sebagai') == 2 && ($dibayaroleh == "sekolah" || $status == 2 || $status == 12)) {
			$getpaketsekolah = $this->M_channel->getPaketChannelSekolah($kodepaket);
			$idpaket = $getpaketsekolah['id'];
			$data['nama_paket'] = $getpaketsekolah['nama_paket'];
			$data['harike'] = $getpaketsekolah['hari'];
			$data['dafvideo'] = $this->M_channel->getVideoSekolahEkskul($npsn, $id, $idpaket);
			$data['jml_video'] = sizeof($data['dafvideo']);

//				echo "IDPAKET:".$idpaket;
//				echo "<br>NAMAPAKET:".$data['nama_paket'];
//				echo "<br>HARIKE:".$data['harike'];
//				die();


//				echo "KODEPAKET:".$kodepaket."===".$data['nama_paket'];
//				die();
//				echo "<pre>";
//				echo var_dump($data['dafvideo']);
//				echo "</pre>";
//				die();
		} else if ($this->session->userdata('sebagai') == 1) {
			
			$getpaketsekolah = $this->M_channel->getPaketChannelSekolah($kodepaket);
			$idpaket = $getpaketsekolah['id'];
			$data['nama_paket'] = $getpaketsekolah['nama_paket'];
			$data['harike'] = $getpaketsekolah['hari'];
			if ($opsi=="calver")
				$data['dafvideo'] = $this->M_channel->getVideoSekolahCalver($npsn, $kodepaket, 3);
			else 
			{
				if ($this->session->userdata('verifikator') == 3)
					$data['dafvideo'] = $this->M_channel->getVideoSekolah($npsn, $kodepaket, 3);
				else
					$data['dafvideo'] = $this->M_channel->getVideoSekolahCalver($npsn, $kodepaket, 3);
			}
			if ($opsi=="tes")
			$data['dafvideo'] = $this->M_channel->getVideoSekolahtes($npsn, $kodepaket, 3);
			
			$data['jml_video'] = sizeof($data['dafvideo']);

			// if ($opsi=="calver")
			// {
				// echo "<pre>";
				// echo var_dump($data['dafvideo']);
				// echo "</pre>";
			// }

		} else {
			redirect("/");
		}

		$data['opsi'] = $opsi;


		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$this->load->view('layout/wrapper_tabel', $data);

	}

	public function inputplaylist_kampus($kodepaket = null, $opsi = null, $kodeevent = null)
	{

		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}

		$npsn = $this->session->userdata('npsn');
		$id = $this->session->userdata('id_user');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];
		$this->load->Model('M_ekskul');
		$dataekskul = $this->M_ekskul->getEkskul($npsn);
		$status = $this->cekstatus($dataekskul);
		$dibayaroleh = $this->cekbayareskul();
		$jmlpembayar = substr($dibayaroleh, 6);

		$data = array();
		$data['konten'] = "v_channel_inputplaylist_sekolah3";
		$data['kodeevent'] = $kodeevent;

		if ($this->session->userdata('sebagai') == 2 && ($dibayaroleh == "sekolah" || $status == 2 || $status == 12)) {
			$getpaketsekolah = $this->M_channel->getPaketChannelSekolah($kodepaket);
			$idpaket = $getpaketsekolah['id'];
			$data['nama_paket'] = $getpaketsekolah['nama_paket'];
			$data['harike'] = $getpaketsekolah['hari'];
			$data['dafvideo'] = $this->M_channel->getVideoSekolahEkskul($npsn, $prodi, $id, $idpaket);
			$data['jml_video'] = sizeof($data['dafvideo']);

//				echo "IDPAKET:".$idpaket;
//				echo "<br>NAMAPAKET:".$data['nama_paket'];
//				echo "<br>HARIKE:".$data['harike'];
//				die();


//				echo "KODEPAKET:".$kodepaket."===".$data['nama_paket'];
//				die();
//				echo "<pre>";
//				echo var_dump($data['dafvideo']);
//				echo "</pre>";
//				die();
		} else if ($this->session->userdata('sebagai') == 1) {
			
			$getpaketsekolah = $this->M_channel->getPaketChannelSekolah($kodepaket);
			$idpaket = $getpaketsekolah['id'];
			$data['nama_paket'] = $getpaketsekolah['nama_paket'];
			$data['harike'] = $getpaketsekolah['hari'];
			$data['mulaitayang'] = $getpaketsekolah['jam_tayang'];
			
			if ($opsi=="calver")
				{
					
					$data['dafvideo'] = $this->M_channel->getVideoSekolahCalver($npsn, $prodi, $kodepaket, 3);
				}
			else 
			{
				if ($this->session->userdata('verifikator') == 3)
					{
						$data['dafvideo'] = $this->M_channel->getVideoSekolah($npsn, $prodi, $kodepaket, 0);
						// echo "<pre>";
						// echo var_dump($data['dafvideo']);
						// echo "</pre>";
					}
				else
					$data['dafvideo'] = $this->M_channel->getVideoSekolahCalver($npsn, $prodi, $kodepaket, 3);
			}
			if ($opsi=="tes")
			$data['dafvideo'] = $this->M_channel->getVideoSekolahtes($npsn, $prodi, $kodepaket, 3);
			
			$data['jml_video'] = sizeof($data['dafvideo']);

			// echo $npsn.",".$prodi.",".$kodepaket;
			// echo "<pre>";
			// echo var_dump($data['dafvideo']);
			// echo "</pre>";
			// die();

			// echo $data['mulaitayang'];
			// die();

			// if ($opsi=="calver")
			// {
				// echo "<pre>";
				// echo var_dump($data['dafvideo']);
				// echo "</pre>";
			// }

		} else {
			redirect("/");
		}

		$data['opsi'] = $opsi;


		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		////////////////////////////////////////////////////////
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$hari = $data['harike'];//$now->format('N');

		$data['hari'] = $hari;
		// echo "hari:".$hari;
		// echo " - harike:".$data['harike'];
		// die();

		$data['dafplaylist'] = $this->M_channel->getDafPlayListSekolah($npsn, $prodi, 0, $hari);
		if ($data['dafplaylist']) {
			//echo "Disini-1";
			$data['punyalist'] = true;
			$statusakhir = $data['dafplaylist'][0]->link_list;
			if ($linklist == null) {
				$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $prodi, $statusakhir);

			} else {
				$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $prodi, $linklist);

			}

			/////////paksa dulu ------------
			$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $prodi, $statusakhir);
			$linklist = $statusakhir;

		} else {
			//echo "Disini-2";
			$data['punyalist'] = false;
//            if (!$this->session->userdata('loggedIn')) {
//                redirect('/');
//            }
		}

		//die();
		$data['sponsor'] = "";
		$data['url_sponsor'] = "";
		$data['durasi_sponsor'] = "00:00:00";

		$getsponsor = $this->M_channel->getsponsor($npsn);
		if ($getsponsor) {
			//echo "<br><br><br><br><br><br><br><br>".$getsponsor->url_sponsor;
			$data['sponsor'] = $getsponsor->nama_lembaga;
			$data['url_sponsor'] = $getsponsor->url_sponsor;
			$data['durasi_sponsor'] = $getsponsor->durasi_sponsor;
		}
		//echo var_dump($getsponsor);

		$data['dafchannelguru'] = $this->M_channel->getChannelGuru($npsn, $prodi);
		$cekinfosekolah = $this->M_channel->getInfoSekolah($npsn, $prodi);

		if ($cekinfosekolah) {
			$data['infosekolah'] = $cekinfosekolah;
		}
		$data['dafvideo2'] = $this->M_channel->getVodSekolah($npsn, $prodi);
		$data['id_playlist'] = $linklist;

		$this->load->view('layout/wrapper_tabel', $data);

	}

	public function urutanplaylist_sekolah_old($kodepaket = null, $opsi = null, $kodeevent = null)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}
		$data = array();
		$data['konten'] = "v_channel_urutanplaylist_sekolah";
		$data['kodeevent'] = $kodeevent;
		$this->load->model('M_channel');


		$getpaketsekolah = $this->M_channel->getPaketChannelSekolah($kodepaket);
		$idpaket = $getpaketsekolah['id'];
		$data['nama_paket'] = $getpaketsekolah['nama_paket'];
		$data['harike'] = $getpaketsekolah['hari'];
		$data['mulaijam'] = $getpaketsekolah['jam_tayang'];
		if ($this->session->userdata('sebagai')==10)
		{
			$npsn = $this->session->userdata('npsn');
			$data['dafvideo'] = $this->M_channel->getVideoSekolah($npsn, $kodepaket, 3);
		}
		else
		{
			if ($opsi=="calver")
				$data['dafvideo'] = $this->M_channel->getVideoSekolahEkskulUrut($idpaket);
			else
				$data['dafvideo'] = $this->M_channel->getVideoSekolahEkskulUrut($idpaket);
		}
		
		$data['jml_video'] = sizeof($data['dafvideo']);

		$data['opsi'] = $opsi;

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$this->load->view('layout/wrapper_umum', $data);

	}

	public function urutanplaylist_kampus($kodepaket = null, $opsi = null, $kodeevent = null)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}
		$data = array();
		$data['konten'] = "v_channel_urutanplaylist_sekolah2";
		$data['kodeevent'] = $kodeevent;
		$this->load->model('M_channel');

		$getpaketsekolah = $this->M_channel->getPaketChannelSekolah($kodepaket);
		$idpaket = $getpaketsekolah['link_list'];
		$data['nama_paket'] = $getpaketsekolah['nama_paket'];
		$data['harike'] = $getpaketsekolah['hari'];
		$data['mulaijam'] = $getpaketsekolah['jam_tayang'];

		$npsn = $this->session->userdata('npsn');
		$id = $this->session->userdata('id_user');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];

		if ($this->session->userdata('sebagai')==10)
		{
			$data['dafvideo'] = $this->M_channel->getVideoSekolah($npsn, $prodi, $kodepaket, 3);
		}
		else
		{
			if ($opsi=="calver")
				$data['dafvideo'] = $this->M_channel->getVideoSekolahEkskulUrut($kodepaket);
			else
				$data['dafvideo'] = $this->M_channel->getVideoSekolahEkskulUrut($kodepaket);
		}
		
		$data['jml_video'] = sizeof($data['dafvideo']);

		$data['opsi'] = $opsi;

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		///////////////////////////
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$hari = $data['harike'];//$now->format('N');

		$data['hari'] = $hari;
		$data['dafplaylist'] = $this->M_channel->getDafPlayListSekolah($npsn, $prodi, 0, $hari);
		if ($data['dafplaylist']) {
			//echo "Disini-1";
			$data['punyalist'] = true;
			$statusakhir = $data['dafplaylist'][0]->link_list;
			if ($linklist == null) {
				$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $prodi, $statusakhir);

			} else {
				$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $prodi, $linklist);

			}

			/////////paksa dulu ------------
			// $data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $statusakhir);
			$linklist = $statusakhir;
			// echo $statusakhir;
			// echo "<pre>";
			// echo var_dump($data['dafplaylist']);
			// echo "</pre>";
			// die();

		} else {
			//echo "Disini-2";
			$data['punyalist'] = false;
//            if (!$this->session->userdata('loggedIn')) {
//                redirect('/');
//            }
		}

		//die();
		$data['sponsor'] = "";
		$data['url_sponsor'] = "";
		$data['durasi_sponsor'] = "00:00:00";

		$getsponsor = $this->M_channel->getsponsor($npsn);
		if ($getsponsor) {
			//echo "<br><br><br><br><br><br><br><br>".$getsponsor->url_sponsor;
			$data['sponsor'] = $getsponsor->nama_lembaga;
			$data['url_sponsor'] = $getsponsor->url_sponsor;
			$data['durasi_sponsor'] = $getsponsor->durasi_sponsor;
		}
		//echo var_dump($getsponsor);

		$data['dafchannelguru'] = $this->M_channel->getChannelGuru($npsn, $prodi);
		$cekinfosekolah = $this->M_channel->getInfoSekolah($npsn, $prodi);

		if ($cekinfosekolah) {
			$data['infosekolah'] = $cekinfosekolah;
		}
		$data['dafvideo2'] = $this->M_channel->getVodSekolah($npsn, $prodi);
		$data['id_playlist0'] = $linklist;

		$this->load->view('layout/wrapper_umum', $data);

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

	public function masukinlist_sekolah($opsi=null)
	{
		$id_video = $_POST['id'];
		$status_video = $_POST['status'];
		$link_list_paket = $_POST['kodepaket'];

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		// $this->load->model('M_channel');
		// $infopaket = $this->M_channel->getInfoPaketSekolah($link_list_paket);

		// echo "<pre>";
		// echo var_dump ($infopaket);
		// echo "</pre>";

		//$datachannelvideo = $this->M_channel->getDataChannelVideo($infopaket->id);
		//$urutanakhir = $datachannelvideo[0]->urutan;

		$npsn = $this->session->userdata('npsn');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];

		$data1 = array();
		$data1['npsn'] = $npsn;
		$data1['kd_prodi'] = $prodi;
		$data1['link_list_paket'] = $link_list_paket;
		$data1['urutan'] = 0;
		$data1['id_video'] = $id_video;

		if ($status_video == 1) {
			$this->M_channel->addDataChannelVideoSekolah($data1);
			$this->M_channel->updatedilist($id_video, 1);
		} else {
			$this->M_channel->delDataChannelVideoSekolah($id_video, $link_list_paket);
			$this->M_channel->updatedilist($id_video, 0);
		}

		$datachannelvideo = $this->M_channel->getDataChannelVideoSekolah($link_list_paket);
		
		$durasi = 0;
		foreach ($datachannelvideo as $datane) {
			$hitungdurasi = $this->durasikedetik($datane->durasi);
			$durasi = $durasi + $hitungdurasi;
		}

		// echo "<pre>";
		// echo var_dump ($datachannelvideo);
		// echo "</pre>";


		$data2['durasi_paket'] = $this->detikkedurasi($durasi);
		$data2['modified'] = $tglsekarang;
		$data2['iduser'] = $this->session->userdata('id_user');
		if ($durasi == 0)
			$data2['status_paket'] = 0;
		else {
			$data2['status_paket'] = 2;
			// if (new DateTime(date('Y-m-d H:i:s')) < new DateTime($infopaket->tanggal_tayang)) {
			// 	$data2['status_paket'] = 1;
			// } else {
			// 	$data2['status_paket'] = 2;
			// }
		}

		$this->M_channel->updateDurasiPaketSekolah($link_list_paket, $data2);

		if ($opsi=="calver")
			{
				$iduser = $this->session->userdata('id_user');
				$this->load->model('M_marketing');
				$this->M_marketing->updateCalVerDafUser("playlist",$iduser);
			}

		$this->updateharitayang_channel($npsn, $prodi);

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

	public function soal($opsi = null, $linklist = null, $kodeevent = null)
	{

		if ($kodeevent != null) {
			$cekevent = $this->M_channel->cekevent_pl_guru($kodeevent);
			if ($cekevent) {

			} else
				redirect("/");
		}

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
			$data['kodeevent'] = $kodeevent;
			$data['asal'] = "owner";
		} else if ($opsi == "buat") {
			$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_channel_buatsoal');
			$paket = $this->M_channel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['dafsoal'] = $this->M_channel->getSoal($paket[0]->id);
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $kodeevent;
			$data['asal'] = "owner";
		} else if ($opsi == "seting") {
			$data = array('title' => 'Seting Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_channel_soal_seting');
			$paketsoal = $this->M_channel->getPaket($linklist);
			$data['paket'] = $paketsoal;
			$dafsoal = $this->M_channel->getSoal($paketsoal[0]->id);
			$data['totalsoal'] = sizeof($dafsoal);
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $kodeevent;
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
			$data['kodeevent'] = $kodeevent;
			$data['asal'] = "menu";
		} else if ($opsi == "nilaisiswa") {
			if ($this->session->userdata("a02") || $this->session->userdata("a03")) {
				$expired = false;
			} else {
				$expired = true;
			}
			$data = array('title' => 'Uraian Tugas', 'menuaktif' => '15',
				'isi' => 'v_channel_soal_jsiswa');
			$nilai = $this->M_channel->getNilaiSiswa($linklist);
			if (!$nilai)
				$nilai = null;
			$paket = $this->M_channel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['dafuser'] = $nilai;
			$data['linklist'] = $linklist;
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
			$data['kodeevent'] = $kodeevent;
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

	public function tugas($npsn = null, $opsi = null, $linklist = null, $idsiswa = null)
	{
		$expired = true;
		if ($npsn == "saya") {
			$tipepaket = 1;
		} else {
			$tipepaket = 2;
		}

		if ($opsi == "buat") {
			if ($idsiswa != null || ($this->session->userdata("a02") || $this->session->userdata("a03"))) {
				$expired = false;
			} else {
				$expired = true;
			}

			$data = array('title' => 'Uraian Tugas', 'menuaktif' => '15',
				'isi' => 'v_channel_buattugas');
			$this->load->Model('M_channel');
			$paket = $this->M_channel->getTugas($tipepaket, $linklist);
			if (!$paket) {
				$isi = array(
					'tipe_paket' => $tipepaket,
					'link_list' => $linklist,
					'status' => 1
				);
				$this->M_channel->addTugas($isi);
				$paket = $this->M_channel->getTugas($tipepaket, $linklist);
			}
			$data['judul'] = $paket->nama_paket;
			$data['uraian'] = $paket->tanyatxt;
			$data['file'] = $paket->tanyafile;
			$data['npsn'] = $npsn;
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $idsiswa;

			if ($idsiswa != null) {
				$cekevent = $this->M_channel->cekevent_pl_guru($idsiswa);
				if ($cekevent) {

				} else
					redirect("/");
			}

		} else if ($opsi == "tampilkan") {
			if ($idsiswa != null || $this->session->userdata("a02") || $this->session->userdata("a03")) {
				$expired = false;
			} else {
				$expired = true;

			}

			$data = array('title' => 'Uraian Tugas', 'menuaktif' => '15',
				'isi' => 'v_channel_tugas');
			$paket = $this->M_channel->getTugas($tipepaket, $linklist);
			if (!$paket || $paket->tanyatxt == "")
				redirect(base_url() . "channel/tugas/saya/buat/" . $linklist);
			$getalluservk = $this->M_channel->getUserVK($tipepaket, $linklist, $paket->id_tugas);
//			echo "<br><br><br>";
//			echo "<pre>";
//			echo var_dump($getalluservk);
//			echo "</pre>";

//			echo "JML1:".sizeof($getalluservk);
			$tgl_sekarang = new DateTime();
			$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$dafuser = array();
			foreach ($getalluservk as $datauser) {
				$tglbatas = new DateTime($datauser->tgl_batas);
				if ($tgl_sekarang > $tglbatas) {

				} else {
					if ($datauser->strata_paket == 2 || $datauser->strata_paket == 3)
						$dafuser[] = $datauser;
				}
			}

			$data['judul'] = $paket->nama_paket;
			$data['dafuser'] = $dafuser;
			$data['uraian'] = $paket->tanyatxt;
			$data['file'] = $paket->tanyafile;
			$data['npsn'] = $npsn;
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $idsiswa;

			if ($idsiswa != null) {
				$cekevent = $this->M_channel->cekevent_pl_guru($idsiswa);
				if ($cekevent) {

				} else
					redirect("/");
			}

		} else if ($opsi == "penilaian") {
			if ($this->session->userdata("a02") || $this->session->userdata("a03")) {
				$expired = false;
			} else {
				$expired = true;
			}

			$data = array('title' => 'Uraian Tugas', 'menuaktif' => '15',
				'isi' => 'v_channel_responguru');
			$tugasguru = $this->M_channel->getTugas($tipepaket, $linklist);
			$data['tugasguru'] = $tugasguru;
			$idtugasguru = $tugasguru->id_tugas;
			$tugassiswa = $this->M_channel->getTugasSiswa($idtugasguru, $idsiswa);

			$data['tugassiswa'] = $tugassiswa;
			$data['id_tugas'] = $idtugasguru;
			$data['npsn'] = $npsn;
			$data['linklist'] = $linklist;
		}

		if ($expired == false) {
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			$this->load->view('layout/wrapper2', $data);
		}
	}

	public function cekjawaban()
	{
		$iduser = $this->session->userdata('id_user');
		$jawaban_user = $this->input->post('jwbuser');
		$idjawaban_user = $this->input->post('idjwbuser');
		$linklist = $this->input->post('linklistnya');

		// $jawaban_user = array ("1");
		// $idjawaban_user = array ("7");
		// $linklist = "63ft165k44zp";
		
		
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
			$tgl_sekarang = new DateTime();
			$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$data['modified'] = $tgl_sekarang->format("Y-m-d H-i:s");
			if ($this->session->userdata('siam')==3)
			{
				echo($nilai);
			}
			else
			{
				$update = $this->M_channel->updatenilai($data, $linklist, $iduser);
				if ($update)
					echo($nilai);
				else
					echo "gagal";
			}
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

	public function updatesoal($linklist, $kodeevent = null, $bulan=null, $tahun=null)
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
		if ($kodeevent=="evm")
			{
				$alamat = "/evm/".$bulan."/".$tahun;
			}
		else if ($kodeevent != null)
			$alamat = "/" . $kodeevent;
		else
			$alamat = "";
		
		redirect('virtualkelas/soal/buat/' . $linklist . $alamat);
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

	public function updateseting($linklist, $kodeevent = null, $bulan = null, $tahun = null)
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

			if ($kodeevent=="evm")
				{
					$alamat = "/evm/".$bulan."/".$tahun;
				}
			else if ($kodeevent != null)
				$alamat = "/" . $kodeevent;
			else
				$alamat = "";

			if ($this->M_channel->updateseting($data, $linklist))
				redirect('virtualkelas/soal/buat/' . $linklist . $alamat);
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
			$tgl_sekarang = new DateTime();
			$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$data['modified'] = $tgl_sekarang->format("Y-m-d H-i:s");
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

	public function updatetugas($linklist)
	{
		$npsn = $this->input->post('npsn');
		$tekssoal = $this->input->post('isimateri');
		$data = array();
		$data['tanyatxt'] = $tekssoal;
		if ($this->M_channel->updatetugas($data, $linklist)) {
			if ($tekssoal == "")
				$this->M_channel->updatestatustugas(0, $linklist);
			else
				$this->M_channel->updatestatustugas(1, $linklist);
			echo "sukses";
		} else
			echo "gagal";

	}

	public function updatetugasnilai()
	{
		$nilai = $this->input->post('nilai');
		$keterangan = $this->input->post('keterangan');
		$id_tugas = $this->input->post('idtgs');
		$iduser = $this->input->post('iduser');
		$data = array();
		$data['nilai'] = $nilai;
		$data['keterangan'] = $keterangan;
		$tgl_sekarang = new DateTime();
		$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$data['tgl_menilai'] = $tgl_sekarang->format("Y-m-d H-i:s");

		if ($this->M_channel->updatetugasnilai($data, $id_tugas, $iduser)) {
			echo "sukses";
		} else {
			echo "gagal";
		}
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

	public function upload_doktugas($linklist)
	{
		if (isset($_FILES['filedok'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$config = array(
			'upload_path' => "uploads/tugas/",
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

			$namafilebaru = "tg_" . $linklist . "_" . $random . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$data = array("tanyafile" => $namafilebaru);
			$this->M_channel->updatetugas($data, $linklist);

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

	public function kosonginfiletugas()
	{
		$linklist = $this->input->post('linklist');
		$iduser = $this->session->userdata('id_user');
		$cekpaket = $this->M_channel->getpaket($linklist);
		if ($cekpaket[0]->iduser == $iduser) {
			$data = array("tanyafile" => "");
			if ($this->M_channel->updatetugas($data, $linklist))
				echo "sukses";
			else
				echo "gagal";
		} else {
			echo "gagal";
		}
	}

	public function kosonginfilejawaban()
	{
		$idtugas = $this->input->post('idtgs');
		$data = array("jawabanfile" => "");
		$iduser = $this->session->userdata('id_user');
		if ($this->M_channel->updatejawaban($data, $idtugas, $iduser))
			echo "sukses";
		else
			echo "gagal";
	}

	public function modul($opsi = null, $linklist = null, $linklistevent = null)
	{
		$data = array();
		$data['konten'] = 'v_channel_modul_lihat';

		$iduser = $this->session->userdata('id_user');
		$paketsoal = $this->M_channel->cekModul($opsi, $linklist);
		if ($opsi == "sekolah")
			$infopaket = $this->M_channel->getInfoPaket($linklist);
		else if ($opsi == "bimbel")
			$infopaket = $this->M_channel->getInfoBimbel($linklist);
		$idkontri = $infopaket->id_user;
		$npsnpaket = $infopaket->npsn_user;

		if ($idkontri != $iduser)
			redirect("/");

		$tjenis = array("sekolah" => 1, "lain" => 2, "bimbel" => 3);
		$jenischat = $tjenis[$opsi];

//		if ($npsnpaket==$this->session->userdata('npsn'))
//			$jenischat = 2;

		$data['datapesan'] = $this->M_channel->getChat($jenischat, null, $linklist);
		$data['dafplaylist'] = $this->M_channel->getDafPlayListModul($opsi, $linklist);

		if ($data['dafplaylist']) {
			$data['punyalist'] = true;
			$data['playlist'] = $this->M_channel->getPlayListModul($opsi, $linklist);
		} else {
			$data['punyalist'] = false;
		}

//		echo "<pre>";
//		echo var_dump($data['playlist']);
//		echo "</pre>";
//		die();

		$data['namasekolah'] = "Topik " . $paketsoal[0]->nama_paket . "";
		$this->load->model('M_vksekolah');
		$data['infoguru'] = $this->M_vksekolah->getInfoGuru($iduser);
		$data['linklist'] = $linklist;
		$data['linklistevent'] = $linklistevent;

		if ($linklistevent != null) {
			$cekevent = $this->M_channel->cekevent_pl_guru($linklistevent);
			if ($cekevent) {

			} else
				redirect("/");
		}

		$data['jenis'] = $opsi;
		$data['npsn'] = $this->session->userdata('npsn');
		$data['asal'] = "menu";
		$data['opsi'] = $opsi;

		$data['iduser'] = $iduser;
		$data['idku'] = $iduser;
		$data['id_playlist'] = $linklist;

		$getpaket = $this->M_channel->getInfoBeliPaket($iduser, $jenischat, $linklist);

		if ($getpaket) {
			$idkontributor = $getpaket->id_kontri;
			$iduserbeli = $getpaket->id_user;
			$batasaktif = $getpaket->tgl_batas;

			$tglkode = substr($getpaket->tglkode, 0, 10);
			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang = $datesekarang->format('Y-m-d');
			$tglsekarangfull = $datesekarang->format('Y-m-d H:i:s');
			if (strtotime($tglsekarangfull) <= strtotime($batasaktif)) {
				$data['adavicon'] = "ada";
			} else {
				$data['adavicon'] = "tidak";
			}

			//echo "KONTRI:".$idkontributor.", YGBELI:".$iduserbeli." , BATAS:".$batasaktif;
		} else
			$data['adavicon'] = "tidak";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function download($bentuk, $linklist, $idsiswa = null)
	{
		if ($bentuk == "materi") {
			$paket = $this->M_channel->getPaket($linklist);
			force_download('uploads/materi/' . $paket[0]->filemateri, null);
		} else if ($bentuk == "tugas") {
			$paket = $this->M_channel->getTugas(1, $linklist);
			force_download('uploads/tugas/' . $paket->tanyafile, null);
		} else if ($bentuk == "jawabansiswa") {
			$paket = $this->M_channel->getTugas(1, $linklist);
			$paketsiswa = $this->M_channel->getTugasSiswa($paket->id_tugas, $idsiswa);
			force_download('uploads/tugas/' . $paketsiswa->jawabanfile, null);
		}

	}

	public function chat($jenis = null, $linklist = null)
	{
		if ($jenis == null)
			echo "<script>this.close();</script>";

		$tjenis = array("sekolah" => 1, "lain" => 2, "bimbel" => 3);
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
		if (($this->session->userdata('a02') && $this->session->userdata('sebagai') == 1)
			|| $this->session->userdata('a03'))
			$bolehchat = true;

		if ($this->session->userdata('bimbel') != 3 && $jenis == "bimbel")
			$bolehchat = false;

		if ($this->session->userdata('a01'))
			$bolehchat = true;

		if (($npsnku == null || $npsnku == 0 || $npsnku == "" || $tgl_sekarang > $tglbatas) && $bolehchat == false) {
			echo "<script>alert ('BELUM LOGIN ATAU BELUM PUNYA PAKET');
			this.close();</script>";
		} else {
			$data = array('title' => 'Uraian Materi', 'menuaktif' => '15',
				'isi' => 'v_chat');

			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			$datapesan = $this->M_channel->getChat($jenischat, $npsnku);
//			echo "<pre>";
//			echo var_dump($datapesan);
//			echo "</pre>";

			$data['datapesan'] = $datapesan;
			$data['jenis'] = $jenis;
			$data['linklist'] = $linklist;
			if ($jenis == "bimbel")
				$data['namasekolah'] = "BIMBEL";
			else
				$data['namasekolah'] = $this->M_channel->getSekolahKu($npsnku)[0]->nama_sekolah;
			$data['idku'] = $this->session->userdata('id_user');

			$this->load->view('layout/wrapperchat', $data);
		}
	}

	public function sendchat($opsi=null)
	{
		$bulan = array("", "Jan", "Peb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nop", "Des");
		$pesan = $this->input->post('pesanku');
		$jenis = $this->input->post('jenis');
		$tjenis = array("sekolah" => 1, "lain" => 1, "bimbel" => 3, "live" => 4, "mentor" =>5, "calver" =>6);
		$jenischat = $tjenis[$jenis];
		$linklist = $this->input->post('linklistku');
		
		if ($jenis=="mentor")
			$linklist = $linklist."o".$this->session->userdata('npsn');
		if ($opsi=="mentor")
			{
				$npsnmentor = $this->input->post('npsne');
				$linklist = $linklist.$npsnmentor;
			}
		if ($linklist != null && $linklist != "")
			$npsnku = "";
		else
			$npsnku = $this->session->userdata('npsn');

		if ($this->session->userdata('loggedIn')) {
			$iduser = $this->session->userdata('id_user');

			$data = array(
				'tipe_paket' => $jenischat,
				'linklist' => $linklist,
				'id_pengirim' => $iduser,
				'npsn' => $npsnku,
				'pesan' => $pesan
			);


			if ($this->M_channel->addChat($data) > 0 AND $pesan != null) {
				$now = new DateTime();
				$now->setTimezone(new DateTimezone('Asia/Jakarta'));
				$curr_date = $now->format('Y-m-d ');
				$npsnku = $this->session->userdata('npsn');
				$pesanharini = $this->M_channel->getChat($jenischat, $npsnku, $linklist, $curr_date);

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
			<table style="font-size:14px;background-color: #f6fff7; text-align:right;float:right;margin-top:0px;margin-bottom:0px;max-width:100%;border: #5faabd 0.5px dashed;vertical-align: center;padding: 15px;">
			<tr>
			<td style="font-size:14px;padding:5px;padding-bottom: 0px;">' . $datane->pesan . '<br><span style="font-size: 10px;">'.substr($datane->tanggal, 11, 5).
							'</span></td>
			
			</tr>
			</table>
			</div>';
					} else {
						echo '<div class="row">
								<table
									style="font-size:14px;float:left;max-width:100%;border: #5faabd 0.5px dashed;vertical-align: center;padding: 15px;">
									<tr>
										<td style="font-size:14px;font-weight:bold;padding:5px;padding-bottom: 0px;">' .
							$datane->first_name . " " . $datane->last_name . '</td>
										<td>
										</td>
									</tr>
									<tr>
										<td style="font-size:14px;padding:5px;padding-top: 0px;">' .
							$datane->pesan . '<br><span style="font-size: 10px;">'.substr($datane->tanggal, 11, 5).
							'</span></td>
										
									</tr>
								</table>
							</div>';
					}
				}
			} else {
				echo "gagal";
			}
		} else
			echo "gagal";
	}

	public function loadchat($opsi=null)
	{
		$bulan = array("", "Jan", "Peb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nop", "Des");
		$jenis = $this->input->post('jenis');
		$tjenis = array("sekolah" => 1, "lain" => 1, "bimbel" => 3, "live" => 4, "mentor" => 5, "calver"=>6);
		$linklist = $this->input->post('linklistku');
		if ($jenis=="mentor")
			$linklist = $this->input->post('linklistku')."o".$this->session->userdata('npsn');
		if ($opsi=="mentor")
			{
				$npsnmentor = $this->input->post('npsne');
				$linklist = $linklist.$npsnmentor;
			}
		$jenischat = $tjenis[$jenis];

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
			$pesanharini = $this->M_channel->getChat($jenischat, $npsnku, $linklist, $curr_date);

//			echo "LINK".$linklist;
//			echo "<pre>";
//			echo var_dump($pesanharini);
//			echo "</pre>";

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
			<table style="font-size:14px;background-color: #f6fff7; text-align:right;float:right;margin-top:0px;margin-bottom:0px;max-width:100%;border: #5faabd 0.5px dashed;vertical-align: center;padding: 15px;">
			<tr>
			<td style="font-size:14px;padding:5px;padding-bottom: 0px;">' . $datane->pesan . '<br><span style="font-size: 10px;">'.substr($datane->tanggal, 11, 5).
						'</span></td>
			
			</tr>
			</table>
			</div>';
				} else {
					echo '<div class="row">
								<table
									style="font-size:14px;float:left;max-width:100%;border: #5faabd 0.5px dashed;vertical-align: center;padding: 15px;">
									<tr>
										<td style="font-size:14px;font-weight:bold;padding:5px;padding-bottom: 0px;">' .
						$datane->first_name . " " . $datane->last_name . '</td>
										<td>
										</td>
									</tr>
									<tr>
										<td style="font-size:14px;padding:5px;padding-top: 0px;">' .
						$datane->pesan . '<br><span style="font-size: 10px;">'.substr($datane->tanggal, 11, 5).
						'</span></td>
										
									</tr>
								</table>
							</div>';
				}
			}
		}

	}

	public function loaduser($opsi=null)
	{
		$linklist = $this->input->post('linklistku');
		$jenis = $this->input->post('jenis');
		$tjenis = array("sekolah" => 1, "lain" => 2, "bimbel" => 3, "live" => 4, "mentor" =>5, "calver" =>6);
		$jenischat = $tjenis[$jenis];

		if ($this->session->userdata('loggedIn')) {
			$iduser = $this->session->userdata('id_user');

			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$curr_time = $now->format('Y-m-d H:i:s');

			$dateinsec = strtotime($curr_time);
			$newdate = $dateinsec - 3;
			$tglbatas = date('Y-m-d H:i:s', $newdate);

			$useronline = $this->M_channel->updateOnlineChat($jenischat, $linklist, $curr_time, $tglbatas, $iduser);
//			echo "<pre>";
//			echo var_dump($useronline);
//			echo "</pre>";

			$jmlpesan = 1;
			foreach ($useronline as $datane) {
				if ($datane->id_user == $this->session->userdata('id_user')) {
					$nama[1] = "Anda";
					if (substr($datane->picture, 0, 4) == "http") {
						$gambar[1] = $datane->picture;
					} else {
						if ($datane->picture == null)
							$gambar[1] = base_url() . 'assets/images/profil_blank.jpg';
						else
							$gambar[1] = base_url() . 'uploads/profil/' . $datane->picture;
					}
				} else {
					$jmlpesan++;
					$nama[$jmlpesan] = $datane->first_name . " " . $datane->last_name;
					if (substr($datane->picture, 0, 4) == "http") {
						$gambar[$jmlpesan] = $datane->picture;
					} else {
						if ($datane->picture == null)
							$gambar[$jmlpesan] = base_url() . 'assets/images/profil_blank.jpg';
						else
							$gambar[$jmlpesan] = base_url() . 'uploads/profil/' . $datane->picture;
					}
				}
			}

			echo '<table style="text-align:left;vertical-align: center;padding-top: 15px;padding-bottom: 15px;">';
			for ($ab = 1; $ab <= $jmlpesan; $ab++) {
				echo '<tr><td style="padding-bottom: 5px;">
								<img src="' . $gambar[$ab] . '" width="30px" height="auto" style="max-height: 50px;">
							</td>
							<td style="font-size:13px;line-height:14px;text-align:left;padding-left: 5px;font-style: italic">' .
					$nama[$ab] . '</td></tr>';
			}
			echo '</table>';
		}
	}

	public function updatenpsnpayment()
	{
		$getallpayment = $this->M_channel->getallpayment();
		echo "<bro>";
		echo var_dump($getallpayment);
		echo "</bro>";
		echo sizeof($getallpayment);
		$this->M_channel->updatenpsnpayment($getallpayment);
	}

	public function cekstatussekolah($npsn)
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

	public function cekstatusbayarchannel($npsn)
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

			if ($statusbayar == 4) {
				return "ok";
			} else if ($selisih >= 2) {
				return "off";
			} else if ($selisih == 1) {
				if ($tanggal <= 5) {
					return "ok";
				} else {
					return "off";
				}

			} else {
				if ($statusbayar == 1) {
					return "off";
				} else if ($statusbayar == 3) {
					return "ok";
				}
			}
		} else {
			return "off";
		}
	}

	public function sekolahoff()
	{
		$data = array('title' => 'Playing VOD', 'menuaktif' => 1,
			'isi' => 'v_informasisekolahoff');
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperchannel', $data);
	}

	public function updateharitayang_channelall()
	{
		$tayang_channel = $this->M_channel->cektayangchannelall();

		$a = 0;

		foreach ($tayang_channel as $row) {
			$a++;
			$data[$a]['npsn'] = $row->npsn;
			$data[$a]['haritayang'] = $row->totharitayang;
			$durasi = $row->tottotaltayang;
			$durasi = substr($durasi, 0, 8);
			$data[$a]['totaltayang'] = $durasi;
		}

		$this->M_channel->updatetayangchannelAll($data);
	}

	public function updateharitayang_channel($npsn, $prodi)
	{
		$tayang_channel = $this->M_channel->cektayangchannel($npsn, $prodi);
		foreach ($tayang_channel as $row) {
			$data['haritayang'] = $row->totharitayang;
			$durasi = $row->tottotaltayang;
			$durasi = substr($durasi, 0, 8);
			$data['totaltayang'] = $durasi;
		}

		$this->M_channel->updatetayangchannel($data, $npsn, $prodi);
	}

	public function realdate()
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		echo $now->format("Y-m-d H:i:s");
	}

	public function setjadwalvicon_bimbel($kodelink)
	{
		$data = array('title' => 'Edit Playlist Bimbel', 'menuaktif' => '4',
			'isi' => 'v_channel_setjadwalvicon_bimbel');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$data['datapaket'] = $this->M_channel->getInfoBimbel($kodelink);

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function savejadwalvicon_bimbel()
	{
		$linklist = $this->input->post('linklist');
		$tglvicon = $this->input->post('datetime') . ":00";
		$data = array();
		$data['tglvicon'] = $tglvicon;
		$this->load->model('M_channel');
		$this->M_channel->updateDurasiBimbel($linklist, $data);
		redirect("/channel/playlistbimbel");
	}

	public function setjadwalvicon_modul($kodelink)
	{
		$data = array('title' => 'Edit Playlist Modul', 'menuaktif' => '4',
			'isi' => 'v_channel_setjadwalvicon');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$data['datapaket'] = $this->M_channel->getInfoPaket($kodelink);

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function savejadwalvicon_modul()
	{
		$linklist = $this->input->post('linklist');
		$tglvicon = $this->input->post('datetime') . ":00";
		$data = array();
		$data['tglvicon'] = $tglvicon;
		$this->load->model('M_channel');
		$this->M_channel->updateDurasiPaket($linklist, $data);
		redirect("/channel/playlistguru");
	}

	public function getstreaming($npsn = null, $linklist = null)
	{
		if ($npsn != null) {
			$npsn = substr($npsn, 2);

			if ($this->session->userdata('a02'))
				$cekuser = 2;
			else
				$cekuser = 2;

			$data = array();
			$data['konten'] = "v_channel_sekolah";

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

				if (sizeof($ceknpsn) == 0) {
					$ceknpsn = $this->M_channel->insertkeDafSekolahKu($npsn);
				}

				//$this->cekstatussekolah($npsn);


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
				$data['sponsor'] = "";
				$data['url_sponsor'] = "";
				$data['durasi_sponsor'] = "00:00:00";

				$getsponsor = $this->M_channel->getsponsor($npsn);
				if ($getsponsor) {
					//echo "<br><br><br><br><br><br><br><br>".$getsponsor->url_sponsor;
					$data['sponsor'] = $getsponsor->nama_lembaga;
					$data['url_sponsor'] = $getsponsor->url_sponsor;
					$data['durasi_sponsor'] = $getsponsor->durasi_sponsor;
				}
				//echo var_dump($getsponsor);

				$data['dafchannelguru'] = $this->M_channel->getChannelGuru($npsn);
				$cekinfosekolah = $this->M_channel->getInfoSekolah($npsn);
				

				if ($cekinfosekolah) {
					$data['infosekolah'] = $cekinfosekolah;
				}
				$data['dafvideo'] = $this->M_channel->getVodSekolah($npsn);


			}

			$data['id_playlist'] = $linklist;

			$this->load->view('v_api_sekolah', $data);
		} else {
			die();
		}

	}

	public function setfreepremium($npsn)
	{
		if (!$this->session->userdata('a01'))
			redirect('/');

		$data = array();
		$data['konten'] = 'v_channel_setfreepremium';
		$sekolahku = $this->M_channel->getSekolahKu($npsn);
		$this->load->Model('M_eksekusi');
		$dataverifikator = $this->M_eksekusi->getveraktif($npsn);
		$data['idver'] = $dataverifikator->id;
		$data['datasekolah'] = $sekolahku[0];

		// echo "<pre>";
		// echo var_dump($data['datasekolah']);
		// echo "</pre>";

		if (!$data['datasekolah'])
		{

		}
		else
		{
			
			$statussekolah = "NON";
			$ceksekolahpremium = ceksekolahpremium($npsn);
			$data['statussekolah'] = " [ - ]";
			if ($ceksekolahpremium['status_sekolah'] != "non")
			{
				$statussekolah = $ceksekolahpremium['status_sekolah'];
				if ($statussekolah == "Lite Siswa")
					$statussekolah = "Lite";
				$data['statussekolah'] = " [ " . $statussekolah . " ] ";
			}

			if($statussekolah=="Premium")
				{
					$strata = 3;
					if ($ceksekolahpremium['tipebayar']=="freepremium")
						$strata = 9;
				}
			else if($statussekolah=="Pro")
			{
				$strata = 2;
				if ($ceksekolahpremium['tipebayar']=="freepro")
					$strata = 8;
			}
			else if($statussekolah=="Lite")
			{
				$strata = 1;
				if ($ceksekolahpremium['tipebayar']=="freelite")
					$strata = 7;
			}
			else
				$strata = 0;


			$data['strata'] = $strata;
			$data['tgl_berakhir'] = "";
			$data['order_id'] = "";
			if($strata > 0)
			{
				$data['tgl_berakhir'] = $ceksekolahpremium['tgl_berakhir'];
				$data['order_id'] = $ceksekolahpremium['order_id'];
			}

			// echo $statussekolah;

			$this->load->view('layout/wrapper_umum', $data);
		}
	}

	public function updatefreepremium()
	{
		if (!$this->session->userdata('a01'))
			redirect('/');

		$data = array();

		$strataawal = $this->input->post('strataawal');
		$pilihan = $this->input->post('pilihan');
		$strata = $this->input->post('istrata');
		$iduser = $this->input->post('iduser');
		$npsnsekolah = $this->input->post('npsnuser');

		if ($strata=="freelite")
			{
				$nstrata = 7;
				$orderid = "TVS-FREE-".$iduser."-".rand(1000, 9999);
			}
		else if ($strata=="freepro")
			{
				$nstrata = 8;
				$orderid = "TP2-FREE-".$iduser."-".rand(1000, 9999);
			}
		else if ($strata=="freepremium")
			{
				$nstrata = 9;
				$orderid = "TF2-FREE-".$iduser."-".rand(1000, 9999);
			}

		$tglberakhir = $this->input->post('itahun')."-".
		str_pad($this->input->post('ibulan'), 2, '0', STR_PAD_LEFT).
		"-".str_pad($this->input->post('itanggal'), 2, '0', STR_PAD_LEFT)." 23:59:59";

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$data['npsn_sekolah'] = $npsnsekolah;
		$data['iduser'] = $iduser;
		$data['order_id'] = $orderid;
		$data['tgl_order'] = $tglsekarang;
		$data['tipebayar'] = $this->input->post('istrata');
		$data['tgl_bayar'] = $tglsekarang;
		$data['tgl_berakhir'] = $tglberakhir;
		$data['status'] = 3;

	
		if ($strataawal>=7)
		{
			$order_id = $this->input->post('orderid');
			$this->load->Model('M_payment');

			if ($pilihan==1)
			{
				$this->M_payment->tambahbayar($data,$order_id, $iduser);

				$dataupdate = array();
				$dataupdate['strata_sekolah'] = $nstrata;
				$dataupdate['kadaluwarsa'] = $tglberakhir;
				$this->M_channel->updatestratachnsekolah($dataupdate, $npsnsekolah);
			}
			else
			{
				$datahapus = array();
				$datahapus['status'] = 0;
				$this->M_payment->tambahbayar($datahapus,$order_id, $iduser);

				$statussekolah = "NON";
				$ceksekolahpremium = ceksekolahpremium($npsnsekolah);
				$data['statussekolah'] = " [ - ]";
				if ($ceksekolahpremium['status_sekolah'] != "non")
				{
					$statussekolah = $ceksekolahpremium['status_sekolah'];
					if ($statussekolah == "Lite Siswa")
						$statussekolah = "Lite";
					$data['statussekolah'] = " [ " . $statussekolah . " ] ";
				}

				if($statussekolah=="Premium")
				{
					$strata = 3;
					if ($ceksekolahpremium['tipebayar']=="freepremium")
						$strata = 9;
				}
				else if($statussekolah=="Pro")
				{
					$strata = 2;
					if ($ceksekolahpremium['tipebayar']=="freepro")
						$strata = 8;
				}
				else if($statussekolah=="Lite")
				{
					$strata = 1;
					if ($ceksekolahpremium['tipebayar']=="freelite")
						$strata = 7;
				}
				else
					$strata = 0;

				$dataupdate['npsn'] = $npsnsekolah;
				$dataupdate['strata_sekolah'] = $strata;
				$dataupdate['kadaluwarsa'] = $ceksekolahpremium['tgl_berakhir'];
				$this->M_channel->updatestratachnsekolah($dataupdate, $npsnsekolah);
				
			}
		}
		else
		{
			$this->load->Model('M_payment');
			$this->M_payment->addDonasi($data);

			$dataupdate['strata_sekolah'] = $nstrata;
			$dataupdate['kadaluwarsa'] = $tglberakhir;
			
			$this->M_channel->updatestratachnsekolah($dataupdate, $npsnsekolah);
			$getchannel = $this->M_channel->getChannelSiap(0);
		}

		redirect ('/channel/daftarprodi');
	}

	public function nosiaran()
	{
		$data = array();
		$data['konten'] = "channelsiaran_no";
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function pilihsiaran()
	{
		
		if ($this->session->userdata('verifikator')==3) {
			$npsn = $this->session->userdata('npsn');
			$getuser = getstatususer();
			$prodi = $getuser['kelasku'];

			$getpilihansiaran = $this->M_channel->getsiaranaktif($npsn, $prodi);
			$data = array();
			$data['tombolpilihansiaran'] = base_url()."assets/images/switch".$getpilihansiaran->siaranaktif.".png";
			$data['urllive'] = $getpilihansiaran->urllive;
			$data['siaranaktif'] = $getpilihansiaran->siaranaktif;

			// $ceksekolahpremium = ceksekolahpremium();
			// $statussekolah = "non";
			// $data['statussekolah'] = " [ - ]";
			// if ($ceksekolahpremium['status_sekolah'] != "non")
			// {
			// 	$statussekolah = $ceksekolahpremium['status_sekolah'];
			// 	if ($statussekolah == "Lite Siswa")
			// 		$statussekolah = "Lite";
			// 	$data['statussekolah'] = " [ " . $statussekolah . " ] ";
			// }

			$this->load->Model('M_channel');
			$getsekolah = $this->M_channel->getSekolahKu($npsn, $prodi);
			$stratasekolah = $getsekolah->strata_sekolah;
			$dafstratasekolah=array('-', 'Lite', 'Pro', 'Premium');
			$statussekolah = $dafstratasekolah[$stratasekolah];

			if ($statussekolah=="Pro" || $statussekolah=="Premium")
				$data['konten'] = "channelsiaran";
			else
				$data['konten'] = "channelsiaran_lite";


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

				$ceknpsn = $this->M_channel->getSekolahKu($npsn,$prodi);

				if (!$ceknpsn) {
					// echo "PERLU UPDATE SEKOLAH";
					$ceknpsn = $this->M_channel->insertkeDafSekolahKu($npsn,$prodi);
				}

				$data['dafplaylist'] = $this->M_channel->getDafPlayListSekolah($npsn, $prodi,0, $hari);
//					echo "<pre>";
//					echo var_dump($data['dafplaylist']);
//					echo "</pre>";
//					die();

				if ($data['dafplaylist']) {
					//echo "Disini-1";
					$data['punyalist'] = true;
					$statusakhir = $data['dafplaylist'][0]->link_list;
					if ($linklist == null) {
						$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $prodi, $statusakhir);

					} else {
						$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $linklist);

					}

					/////////paksa dulu ------------
					$data['playlist'] = $this->M_channel->getPlayListSekolah($npsn, $prodi, $statusakhir);
					$linklist = $statusakhir;

				} else {
					//echo "Disini-2";
					$data['punyalist'] = false;
//            if (!$this->session->userdata('loggedIn')) {
//                redirect('/');
//            }
				}

				//die();
				$data['sponsor'] = "";
				$data['url_sponsor'] = "";
				$data['durasi_sponsor'] = "00:00:00";

				$getsponsor = $this->M_channel->getsponsor($npsn);
				if ($getsponsor) {
					//echo "<br><br><br><br><br><br><br><br>".$getsponsor->url_sponsor;
					$data['sponsor'] = $getsponsor->nama_lembaga;
					$data['url_sponsor'] = $getsponsor->url_sponsor;
					$data['durasi_sponsor'] = $getsponsor->durasi_sponsor;
				}
				//echo var_dump($getsponsor);

				$data['dafchannelguru'] = $this->M_channel->getChannelGuru($npsn, $prodi);
				$cekinfosekolah = $this->M_channel->getInfoSekolah($npsn, $prodi);
				

				if ($cekinfosekolah) {
					$data['infosekolah'] = $cekinfosekolah;
				}
				$data['dafvideo'] = $this->M_channel->getVodSekolah($npsn, $prodi);


			}

			$data['id_playlist'] = $linklist;

			$this->load->view('layout/wrapper_umum', $data);
		} else {
			die();
		}
	
	}

	public function updateurl()
	{
		$npsn = $this->session->userdata('npsn');
		$url = $_POST['url'];
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];

		$updateurl = $this->M_channel->updateurl($url,$npsn,$prodi);

		if ($updateurl)
		{
			echo "sukses";
		}
		else
		{
			echo "gagal";
		}
	}

	public function gantisiaran()
	{
		$npsn = $this->session->userdata('npsn');
		$siaranaktif = $_POST['siaranaktif'];
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];

		if ($siaranaktif==2)
		$siaranganti=1;
		else
		$siaranganti=2;

		$updatesiaran = $this->M_channel->updatesiaran($siaranganti,$npsn, $prodi);

		if ($updatesiaran)
		{
			echo "sukses";
		}
		else
		{
			echo "gagal";
		}
	}

	public function cekprodi()
	{
		$hasil = $this->M_channel->getProdi($_POST['kode']);
		if ($hasil) {
			echo 'Kode prodi ini sudah terdaftar pada';
		} else {
			echo '';
		}
	}

}
