<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_induk");
		$this->load->model('M_video');
		$this->load->helper('video');
		

		if ($this->session->userdata('verifikator')==2 || $this->session->userdata('kontributor')==2)
		{

		}
		else
		if (!$this->session->userdata('loggedIn') ||
			($this->session->userdata('tukang_kontribusi') > 2 && $this->session->userdata('verifikator')!=3 &&
				($this->session->userdata('siae')==0 && $this->session->userdata('siam')==0 && $this->session->userdata('bimbel')==0))) {
			redirect('/');
		}

		if (!$this->session->userdata('activate') &&
			($this->session->userdata('siae')==0 && $this->session->userdata('siam')==0 && $this->session->userdata('bimbel')==0))
			redirect('/login/profile');

		$this->load->helper(array('Form', 'Cookie', 'Video', 'Statusverifikator'));
	}

	public function index()
	{
		$this->lihat();
	}

	public function lihat($adakembali=null, $kodemodul=null, $bulan=null, $tahun = null)
	{
		$data = array();
		$data['konten'] = "v_video";

		if (substr(get_cookie("basis"),0,3)=="vk-")
		{

		}
		else
			{
				setcookie('basis', "video", time() + (86400), '/');
			}

		$data['statusvideo'] = 'semua';
		$data['linkdari'] = "video";
		
		$data['kembali'] = $adakembali;
		$data['kodemodul'] = $kodemodul;
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$getstatus = getstatusverifikator();
		$data['status_verifikator'] = $getstatus['status_verifikator'];

		if ($this->session->userdata('a02') && !$this->session->userdata('a01'))
			$this->saya();

		$id_user = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$getuser = getstatususer();
		$prodi = $getuser["kelasku"];
		
		if ($this->session->userdata('a01')) {
			$data['dafvideo'] = $this->M_video->getVideoAll();
			$data['statusvideo'] = 'admin';
		} else if ($this->session->userdata('sebagai') == 4 && $this->session->userdata('verifikator')==3) {
			$data['dafvideo'] = $this->M_video->getVideoAll();
			$data['statusvideo'] = 'fordorum';
		} else if ($this->session->userdata('a02') && $this->session->userdata('sebagai') != 4) {
			$data['dafvideo'] = $this->M_video->getVideoSekolah($npsn, $prodi);
			$data['statusvideo'] = 'sekolah';
		} else if ($this->session->userdata('a03')) {
			$data['dafvideo'] = $this->M_video->getVideoUser($id_user);
			$data['statusvideo'] = 'modul';
		} else if ($this->session->userdata('bimbel')==3) {
			$data['dafvideo'] = $this->M_video->getVideoUser($id_user);
			$data['statusvideo'] = 'bimbel';
		} else {
			redirect("/");
		}

		
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function saya($opsi=null)
	{
		$data = array();
		$data['konten'] = "v_video";

		$data['sudahdicekagency'] = false;
		$data['sudahdicekverifikator'] = false;

		if (substr(get_cookie("basis"),0,3)=="vk-")
		{
			$data['opsikhusus'] = get_cookie("basis");
		}
		else
		{
			setcookie('basis', "video", time() + (86400), '/');
		}


		$data['kembali'] = "saya";
		$data['statusvideo'] = 'semua';
		$data['linkdari'] = "video";

		$getstatus = getstatusverifikator();
		$data['status_verifikator'] = $getstatus['status_verifikator'];
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];

		$data['opsi'] = $opsi;

		if ($this->session->userdata('sebagai') == 1) {
			$data['dafvideo'] = $this->M_video->getVideoSekolah($this->session->userdata('npsn'),$prodi,"saya",0,null,null,null,$prodi);
			if ($this->session->userdata('verifikator') == 3)
				$data['statusvideo'] = 'sekolahsaya';
			else if ($this->session->userdata('kontributor') == 3)
				$data['statusvideo'] = 'videosaya';

		} else if ($this->session->userdata('bimbel') == 3) {

			$data['dafvideo'] = $this->M_video->getVideoSekolah(null,null,"saya",0);
			$data['statusvideo'] = 'bimbelsaya';
//			echo "<pre>";
//			echo var_dump($data['dafvideo']);
//			echo "</pre>";
//			die();
		} else if ($this->session->userdata('bimbel') == 4) {

			$data['dafvideo'] = $this->M_video->getVideoSekolah(null,null,"saya",0);
			$data['statusvideo'] = 'bimbelsaya';
//			echo "<pre>";
//			echo var_dump($data['dafvideo']);
//			echo "</pre>";
//			die();
		}
		else
			redirect("/");

		foreach ($data['dafvideo'] as $datavideobimbel)
		{
			if ($datavideobimbel->status_verifikasi==2 || $datavideobimbel->status_verifikasi==4)
			{
				if ($datavideobimbel->sifat==2)
					$data['sudahdicekagency'] = "sudah";
				else
					$data['sudahdicekverifikator'] = "sudah";
			}
			else
			{
				if ($datavideobimbel->sifat==2)
					$data['sudahdicekagency'] = "belum";
				else
					$data['sudahdicekverifikator'] = "belum";
			}
		}

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function kontributor($opsi=null)
	{
		setcookie('basis', "video", time() + (86400), '/');

		$data = array();
		$data['konten'] = "v_video";

		$data['statusvideo'] = 'semua';
		$data['linkdari'] = "video";
		$data['opsi'] = $opsi;

		$getstatus = getstatusverifikator();
		$data['status_verifikator'] = $getstatus['status_verifikator'];

		if ($this->session->userdata('sebagai') == 1) {
			$data['dafvideo'] = $this->M_video->getVideoSekolah($this->session->userdata('npsn'),"kontributor",0);
			$data['statusvideo'] = 'sekolahkontri';
		} else if ($this->session->userdata('a01')) {

			$data['dafvideo'] = $this->M_video->getVideoAll(null,0);
			$data['statusvideo'] = 'admin';
//			echo "<pre>";
//			echo var_dump($data['dafvideo']);
//			echo "</pre>";
//			die();
		}
		else
			redirect("/");

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function ekskul($opsi=null)
	{
		if (!$this->session->userdata('a01'))
		redirect("/ekskul/daftar_video/dashboard");
		setcookie('basis', "video", time() + (86400), '/');

		$data = array();
		$data['konten'] = "v_video";

		$data['statusvideo'] = 'ekskul';
		$data['linkdari'] = "video";
		$data['opsi'] = $opsi;

		$getstatus = getstatusverifikator();
		$data['status_verifikator'] = $getstatus['status_verifikator'];

		if ($this->session->userdata('sebagai') == 1) {
			$data['dafvideo'] = $this->M_video->getVideoSekolah($this->session->userdata('npsn'),"kontributor",2);
			$data['statusvideo'] = 'ekskul';
		} else if ($this->session->userdata('a01')) {
			$data['dafvideo'] = $this->M_video->getVideoAll(2);
			$data['statusvideo'] = 'ekskul';
		}
		else
			redirect("/");

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function event($opsi=null,$idevent=null)
	{
		if ($idevent==null)
			$idevent="semua";
		setcookie('basis', "video", time() + (86400), '/');

		$data = array();
		$data['konten'] = "v_video";

		$data['statusvideo'] = 'event';
		$data['linkdari'] = "video";
		$data['opsi'] = $opsi;
		$data['idevent'] = $idevent;

		$getstatus = getstatusverifikator();
		$data['status_verifikator'] = $getstatus['status_verifikator'];

		if ($this->session->userdata('sebagai') == 1) {
			$data['dafvideo'] = $this->M_video->getVideoSekolah($this->session->userdata('npsn'),"kontributor",1);
			$data['statusvideo'] = 'event';
		} else if ($this->session->userdata('a01')) {
			$data['dafvideo'] = $this->M_video->getVideoAll(null,$idevent);
			$data['dafevent'] = $this->M_video->getAllbyIdEvent();

		}
		else
			redirect("/");

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function bimbel($opsi=null)
	{
		setcookie('basis', "video", time() + (86400), '/');

		$data = array();
		$data['konten'] = "v_video";

		$data['statusvideo'] = 'bimbel';
		$data['linkdari'] = "video";
		$data['opsi'] = $opsi;

		$getstatus = getstatusverifikator();
		$data['status_verifikator'] = $getstatus['status_verifikator'];

		if ($this->session->userdata('bimbel') == 4) {
			$sifat=2;
			$this->load->Model('M_login');
			$getdatauser = $this->M_login->getUser($this->session->userdata('id_user'));
			$kodekotaku=$getdatauser['kd_kota'];
//			echo $kodekotaku;
//			die();
			$data['dafvideo'] = $this->M_video->getVideoSekolah(null,"kontributorbimbel",
				null,null,$sifat,$kodekotaku);
			// echo "<pre>";
			// echo var_dump($data['dafvideo']);
			// echo "</pre>";
		}
		else
			redirect("/");

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function is_connected($sCheckHost = 'www.google.com')
	{
		return (bool)@fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
	}

	public function vervideo()
	{
		if ($this->session->userdata('a01') || $this->session->userdata('a02')) {
			$data = array('title' => 'Daftar Video', 'menuaktif' => '3',
				'isi' => 'v_video');
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

	public function tambah($asal = null, $kodeevent = null, $bulan = null, $tahun = null)
	{
		$data = array();
		$data['konten'] = "v_video_tambah";
		$data['addedit'] = "add";
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['datavideo'] = Array('status_verifikasi' => 0);
		$data['idvideo'] = 0;
		$data['namafile'] = "";
		$data['asal'] = $asal;
		$data['kodeevent'] = $kodeevent;
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		//	if ($judul!=null)
		//		$data['judulvideo'] = $judul;
		$this->load->view('layout/wrapper_tabel', $data);
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

	public function edit($id_video = null, $asal = null)
	{
		if ($id_video == null) {
			redirect("/");
		}
		$data = array();
		$data['konten'] = "v_video_tambah";

		$data['linkdari'] = "video";
		$data['addedit'] = "edit";
		$data['asal'] = $asal;
		$data['datavideo'] = $this->M_video->getVideo($id_video);

		$iduservideo = $data['datavideo']['id_user'];
		if ($iduservideo!=$this->session->userdata("id_user"))
		redirect("/");
		
		if ($data['datavideo']) {
			$data['idvideo'] = $id_video;

			$data['jenisvideo'] = "mp4";
			if ($data['datavideo']['link_video'] != "") {
				//$idyoutube=substr($data['datavideo']['link_video'],32,11);
				//$data['infodurasi'] = $this->getVideoInfo($idyoutube);
				$data['jenisvideo'] = "yt";
			}
			$this->load->view('layout/wrapper_tabel', $data);
		} else {
			redirect("/");
		}
	}

	public function getVideoInfo($vidkey)
	{
		$cekalamat = $this->M_video->cekidyoutub($vidkey);
		if ($cekalamat) {
			//echo "sudahpernah";
			//return "sudahpernah";
			$hasil = array('ket'=>'sudahpernah','durasi'=>'00:00:00','channeltitle'=>'','channelid'=>'');
			echo json_encode($hasil);
		} else {
			$apikey = "AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU";
			$dur = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails,snippet&id=$vidkey&key=$apikey");
			$VidDuration = json_decode($dur, true);
			foreach ($VidDuration['items'] as $vidTime) {
				$VidDuration = $vidTime['contentDetails']['duration'];
				$channeltitle = $vidTime['snippet']['channelTitle'];
				$channelid = $vidTime['snippet']['channelId'];
				//$channel = $vidTime['snippet']['channelId'];
//			//$dur = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails,snippet&id=$vidkey&key=$apikey");
//			//$datayt = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails,statistics&mine=true&access_token=smohLqUHcpdkt9RKauZ8zOJNieyIQjxw");
//			//$daty = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=brandingSettings&mine=true&key=AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU");
//			$daty = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=id%2Csnippet%2Cstatistics%2CcontentDetails%2CtopicDetails&id=".$channel."&key=AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU");
				//echo $channel.'<br>';
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

					$pos1 = strpos($VidDuration, "T");
					$jamvalid = substr($VidDuration,$pos1+1);
					//echo $jamvalid."<br>";
					$pos2 = strpos($jamvalid, "H");
					if ($pos2<>"") {
						$hours = substr($jamvalid, 0, $pos2);
						$jamvalid = substr($jamvalid, $pos2 + 1);
					}
					//echo "JAM:".$hours."<br>";
					$pos2 = strpos($jamvalid, "M");
					if ($pos2<>"") {
						$minutes = substr($jamvalid, 0, $pos2);
						$jamvalid = substr($jamvalid, $pos2 + 1);
					}
					//echo "MENIT:".$minutes."<br>";
					$pos2 = strpos($jamvalid, "S");
					if ($pos2<>"") {
						$seconds = substr($jamvalid, 0, $pos2);
						$jamvalid = substr($jamvalid, $pos2 + 1);
					}
					//echo "DETIK:".$seconds."<br>";
					//echo $jamvalid."<br>";

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

				//echo $totalSec;
				//return $totalSec;
				$hasil = array('ket'=>'','durasi'=>$totalSec,'channeltitle'=>$channeltitle,'channelid'=>$channelid);
				echo json_encode($hasil);
//           echo $VidDuration;
//           return $VidDuration;
			}
		}
	}


	public function hapus($id_video,$asal=null,$bulan=null,$tahun=null)
	{
		$this->M_video->delsafevideo($id_video);
		
		if ($tahun!=null)
			redirect('/video/lihat/modul/'.$asal.'/'.$bulan.'/'.$tahun, '_self');
		else if ($asal=="bimbel")
			redirect('/video/bimbel/dashboard', '_self');
		else if ($asal=="saya")
			redirect('/video/saya/dashboard', '_self');
		else
			redirect('/video', '_self');
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
		else if ($idjenjang == 6)
			$isi = $this->M_video->dafJurusanPT();
		echo json_encode($isi);
	}

	public function ambilkd()
	{
		$npsn = $_GET['npsn'];
		$kurikulum = $_GET['kurikulum'];
		$idkelas = $_GET['idkelas'];
		$idmapel = $_GET['idmapel'];
		$idki = $_GET['idki'];

//		$idkelas = 9;
//		$idmapel = 5;
//		$idki = 3;

		$isi = $this->M_video->dafKD($npsn, $kurikulum, $idkelas, $idmapel, $idki);
		echo json_encode($isi);
	}

	public function ambilmapel()
	{
		$idjenjang = $_GET['idjenjang'];
		if (isset ($_GET['idjurusan'])) {
			$idjurusansmk = $_GET['idjurusan'];
		}
		if (isset ($_GET['idjurusanpt'])) {
			$idjurusanpt = $_GET['idjurusanpt'];
		}
		if($idjenjang!=5 && $idjenjang!=6)
			$idjurusan=0;
		if ($idjenjang==5)
			$idjurusan = $idjurusansmk;
		else if ($idjenjang==6)
			$idjurusan = $idjurusanpt;

		$isi = $this->M_video->dafMapel($idjenjang, $idjurusan);
		echo json_encode($isi);
	}

	public function ambil_jurusanpt()
	{
		$idfakultas = $_GET['idfakultas'];
		$this->load->model('M_seting');
		$jurusan = $this->M_seting->getJurusanPT($idfakultas);
		echo json_encode($jurusan);
	}

	public function addkd()
	{
		$idkelas = $_POST['idkelas'];
		$idmapel = $_POST['idmapel'];
		$idki = $_POST['idki'];
		$idtema = $_POST['idtema'];
		$idjurusan = $_POST['idjurusan'];
		$kade = $_POST['tekskd'];
		$npsn = $_POST['npsn'];
		$kurikulum = $_POST['kurikulum'];

		$data['id_kelas'] = $idkelas;
		$data['id_mapel'] = $idmapel;
		$data['id_ki'] = $idki;
		$data['id_tema'] = $idtema;
		$data['id_jurusan'] = $idjurusan;
		$data['nama_kd'] = $kade;
		$data['npsn'] = $npsn;
		$data['kurikulum'] = $kurikulum;

		$this->load->model('M_seting');
		$this->M_seting->addkd($data);

		$this->load->model('M_video');
		$isi = $this->M_video->dafKD($npsn, $kurikulum, $idkelas, $idmapel, $idki);

		echo json_encode($isi);

	}

	public function addmapel()
	{
		$idjenjang = $_POST['idjenjang'];

		if($idjenjang==5)
		{
			if (isset($_POST['idjurusan'])) {
				$idjurusan = $_POST['idjurusan'];
				$data['c3'] = $idjurusan;
			} else {
				$idjurusan = 0;
			}
		} else if($idjenjang==6)
		{
			if (isset($_POST['idjurusanpt'])) {
				$idjurusan = $_POST['idjurusanpt'];
				$data['c3'] = $idjurusan;
			} else {
				$idjurusan = 0;
			}
		} else
			$idjurusan = 0;

		$mapel = $_POST['teksmapel'];

		$data['id_jenjang'] = $idjenjang;
		$data['nama_mapel'] = $mapel;

		$this->load->model('M_seting');
		$this->M_seting->addmapel($data);

		$this->load->model('M_video');
		$isi = $this->M_video->dafMapel($idjenjang, $idjurusan);

		echo json_encode($isi);

	}

	public function addjurusan()
	{
		$idfakultas = $_POST['idfakultas'];
		$data['id_fakultas'] = $idfakultas;
		$data['nama_jurusan'] = $_POST['namajurusan'];

		$this->load->model('M_seting');
		$this->M_seting->addJurusan($data);
		$jurusan = $this->M_seting->getJurusanPT($idfakultas);
		echo json_encode($jurusan);
	}

	public function editjurusan()
	{
		$idjurusan = $_POST['idjurusan'];
		$idfakultas = $_POST['idfakultas'];
		$data['id_fakultas'] = $idfakultas;
		$data['nama_jurusan'] = $_POST['namajurusan'];

		$this->load->model('M_seting');
		$this->M_seting->updateJurusan($data,$idjurusan);
		$jurusan = $this->M_seting->getJurusanPT($idfakultas);
		echo json_encode($jurusan);
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
		$npsn = $_POST['npsn'];
		$kurikulum = $_POST['kurikulum'];

		$data['nama_kd'] = $tekskade;

		$this->load->model('M_seting');
		$this->M_seting->editkd($data, $idkd);

		$this->load->model('M_video');
		$isi = $this->M_video->dafKD($npsn,$kurikulum,$idkelas, $idmapel, $idki);

		echo json_encode($isi);
	}

	public function delkd()
	{
		$idkd = $_POST['idkade'];
		$idkelas = $_POST['idkelas'];
		$idmapel = $_POST['idmapel'];
		$idki = $_POST['idki'];
		$npsn = $_POST['npsn'];
		$kurikulum = $_POST['kurikulum'];

		$this->load->model('M_seting');
		$jmlpakai = $this->M_seting->cekKDterpakai($idkd);

		if ($jmlpakai>0)
		{
			$isi = array("");
			echo json_encode($isi);
		}
		else
		{
			$this->M_seting->delkd($idkd);
			$this->load->model('M_video');
			$isi = $this->M_video->dafKD($npsn,$kurikulum,$idkelas, $idmapel, $idki);
			echo json_encode($isi);
		}

	}

	public function delkat()
	{
		$idkate = $_POST['idkate'];

		$this->load->model('M_seting');
		$jmlpakai = $this->M_seting->cekKATterpakai($idkate);

		if ($jmlpakai>0)
		{
			$isi = array("");
			echo json_encode($isi);
		}
		else
		{
			$this->M_seting->delkat($idkate);
			$this->load->model('M_video');
			$isi = $this->M_video->getAllKategori();
			echo json_encode($isi);
		}
	}

	public function editmapel()
	{
		$idmapel = $_POST['idmapel'];
		$idjenjang = $_POST['idjenjang'];
		$teksmapel = $_POST['teksmapel'];

		if($idjenjang==5)
		{
			if (isset($_POST['idjurusan'])) {
				$idjurusan = $_POST['idjurusan'];
				$data['c3'] = $idjurusan;
			} else {
				$idjurusan = 0;
			}
		} else if($idjenjang==6)
		{
			if (isset($_POST['idjurusanpt'])) {
				$idjurusan = $_POST['idjurusanpt'];
				$data['c3'] = $idjurusan;
			} else {
				$idjurusan = 0;
			}
		} else
			$idjurusan = 0;

		$data['nama_mapel'] = $teksmapel;

		$this->load->model('M_seting');
		$this->M_seting->editmapel($data, $idmapel);

		$this->load->model('M_video');
		$isi = $this->M_video->dafMapel($idjenjang,$idjurusan);

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

	public function addvideo($asal=null, $kodeevent = null, $bulan = null, $tahun = null)
	{
		if ($this->input->post('ijudul') == null) {
			redirect('video');
		}

		if (($this->session->userdata('bimbel')==3 && $asal=='bimbel') ||
			($this->session->userdata('bimbel')==4 && $asal=='saya' &&
				$this->session->userdata('verifikator')<3 &&
				$this->session->userdata('kontributor')<3))
		{
			$data['sifat']=2;
		}
		$data['channeltitle'] = $this->input->post('ichannel');
		$data['channelid'] = $this->input->post('ichannelid');
		$data['id_jenis'] = 0;
		$data['id_jenjang'] = 0;
		$data['id_kelas'] = 0;
		$data['id_mapel'] = 0;
		$data['kdnpsn'] = 0;
		$data['kdkur'] = 0;
		if ($data['id_jenjang'] == 2)
			$data['id_tematik'] = $this->input->post('itema');
		else
			$data['id_tematik'] = 0;
		if ($data['id_jenjang'] == 5 || $data['id_jenjang'] == 6)
			$data['id_jurusan'] = $this->input->post('ijurusan');
		else
			$data['id_jurusan'] = 0;
//        echo $data['id_jurusan'];
//        die();

		$npsn = $this->session->userdata('npsn');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];

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

		$data['status_verifikasi'] = 0;

		if ($this->input->post('addedit') == "add") {
			$data['id_user'] = $this->session->userdata('id_user');
			if($this->session->userdata('npsn')==null)
				$data['npsn_user']="";
			else
				$data['npsn_user'] = $this->session->userdata('npsn');
			$data['kd_prodi_user'] = $prodi;
			if ($data['link_video'] != "") {
				$data['durasi'] = $data['durasi'];
				$data['thumbnail'] = $this->input->post('ytube_thumbnail');
				$data['id_youtube'] = $this->input->post('idyoutube');
			}
			$angka = microtime(false);
			$angka2 = str_replace(".","",$angka);
			$angka2 = str_replace(" ","",$angka2);
			$kode_video = base_convert($angka2, 10, 36);
			$data['kode_video'] = $kode_video;
		} else {
			//$data['kode_video'] = base_convert($this->input->post('created'),10,16);
		}

		if ($statusverifikasi == 1) {
			$data['status_verifikasi'] = 0;
		} else if ($statusverifikasi == 3) {
			$data['status_verifikasi'] = 2;
		}

		$getstatus = getstatusverifikator();

		if ($this->session->userdata('a01') || $getstatus['status_verifikator']=="oke") {
			if ($this->input->post('ijenis') == 1)
				$data['status_verifikasi'] = 4;
			else
				$data['status_verifikasi'] = 2;
		}

		if ($this->session->userdata('verifikator')!=3)
		{
			$data['status_verifikasi'] = 0;
		}


		$data['id_kategori'] = 0;
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
		

		// $this->load->model("M_marketing");
		// $this->M_marketing->updateCalVerDafUser('videokontri',$this->session->userdata('id_user'));

		if ($this->input->post('addedit') == "add") {
			$idbaru = $this->M_video->addVideo($data);

			$this->M_video->updatejmlvidsekolah($npsn, $prodi);
			if ($asal=='bimbel')
				redirect('video/bimbel/dashboard');
			else if ($asal=='saya')
				redirect('video/saya/dashboard');
			else if ($asal=='evm')
				redirect('video/lihat/modul/'.$kodeevent.'/'.$bulan.'/'.$tahun);
			else
				redirect('video');
			//redirect('video/edit/'.$idbaru);
		} else {
			$this->M_video->editVideo($data, $this->input->post('id_video'));
			$this->M_video->updatejmlvidsekolah($npsn, $prodi);
			if ($asal=='bimbel')
				redirect('video/bimbel/dashboard');
			else if ($asal=='saya')
				redirect('video/saya/dashboard');
			else if ($asal=='evm')
				redirect('video/lihat/modul/'.$kodeevent.'/'.$bulan.'/'.$tahun);
			else
				redirect('video');
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
		$data['topik'] = $this->stripHTMLtags($this->input->post('itopik'));
		$data['judul'] = $this->stripHTMLtags($this->input->post('ijudul'));
		$data['deskripsi'] = $this->stripHTMLtags($this->input->post('ideskripsi'));
		$data['keyword'] = $this->stripHTMLtags($this->input->post('ikeyword'));

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

	public function verifikasi($id_video, $asal = null)
	{
		$getstatus = getstatusverifikator();

		if ($getstatus['status_verifikator']=="oke" || $this->session->userdata('bimbel')==4 || $this->session->userdata('a01')
		|| ($this->session->userdata('siam') == 3 && substr($asal,0,6)=="calver") || $this->session->userdata('verifikator') == 1 ) {

			$data = array();
			$data['konten'] = "v_video_verifikasi";

			$datav['id_video'] = $id_video;
			$datav['id_verifikator'] = $this->session->userdata('id_user');
			$datav['no_verifikator'] = $this->session->userdata('tukang_verifikasi');
			$data['no_verifikator'] = $this->session->userdata('tukang_verifikasi');

			$data['asal'] = $asal;

			$data['datavideo'] = $this->M_video->getVideoKomplit($id_video);

			if ($this->session->userdata('a01') || substr($asal,0,6)=="calver" || ($this->session->userdata('sebagai') == 4
					&& $this->session->userdata('verifikator') == 3)) {
				$datav['no_verifikator'] = 2;
				$data['no_verifikator'] = 2;
			} else if ($this->session->userdata('verifikator')==1)
			{
				$datav['no_verifikator'] = 1;
				$data['no_verifikator'] = 1;
			} else if ($this->session->userdata('bimbel')==4)
			{
				$datav['no_verifikator'] = 3;
				$data['no_verifikator'] = 3;
			}
			else {
				if ($datav['no_verifikator'] == 0)
					redirect('video');
				if ($datav['no_verifikator'] == 1) {
					if ($this->session->userdata('npsn') != $data['datavideo']['npsn'])
						redirect('video');
				}
			}

			$data['dafpernyataan'] = $this->M_video->getAllPernyataan($datav['no_verifikator']);
			$data['dafpenilaian'] = $this->M_video->getPenilaian($id_video, $datav);

			$this->load->view('layout/wrapper_umum', $data);
		}
		else
		{
			if ($asal=="ekskulprofil")
				redirect('video/ekskul/profil');
			else if ($asal=="sekolahkontriprofil")
				redirect('video/kontributor/profil');
			else if ($asal=="eventprofil")
				redirect('video/event/profil');
			else if ($asal=="ekskuldashboard")
				redirect('video/ekskul/dashboard');
			else if ($asal=="sekolahkontridashboard")
				redirect('video/kontributor/dashboard');
			else if ($asal=="sekolahsayadashboard")
				redirect('video/saya/dashboard');
			else if ($asal=="eventdashboard")
				redirect('video/event/dashboard');
			else if ($asal=="bimbeldashboard")
				redirect('video/bimbel/dashboard');
			else if (substr($asal,0,6)=="calver")
				redirect('marketing/calver/video/'.substr($asal,6));
			else if ($asal=="dashboard" && $this->session->userdata('verifikator')==1)
				redirect('video/kontributor/dashboard');
			else
				redirect('video');
		}
	}

	public function simpanverifikasi($asal = null)
	{
		$verifikator = $this->session->userdata('tukang_verifikasi');
		if (($this->session->userdata('siam') == 3 && substr($asal,0,6)=="calver")
		|| $this->session->userdata('verifikator') == 1)
			$verifikator = 1;
		if ($this->session->userdata('a01'))
			$verifikator = 2;
		if ($this->session->userdata('bimbel')==4)
			$verifikator = 3;
		$id_video = $this->input->post('id_video');
		$total_isian = $this->input->post('total_isian');
		$jml_diisi = $this->input->post('jml_diisi');
		$lulusgak = $this->input->post('lulusgak');
		// echo 'Total:'.$total_isian;
		// echo '<br>Diisi:'.$jml_diisi;
		//echo $lulusgak
		//die();
		/////////////// GANTI LULUS DENGAN INPUTAN LULUSGAK, BUKAN LENGKAP ATAU TIDAKNYA///////////////////////////////////////////////////
		if ($verifikator == 1 || $verifikator == 3)
			$status_verifikasi = 0 + $lulusgak;
		else
			$status_verifikasi = 2 + $lulusgak;

		//echo "Total isian:".$total_isian.'-'.'Diisi:'.$jml_diisi;	die();

		if ($verifikator >= 1) {
			if ($verifikator == 1) {
				$data1['totalnilai1'] = $this->input->post('totalnilai');
				$data1['catatan1'] = $this->input->post('icatatan');
			} else if ($verifikator == 2) {
				$data1['totalnilai2'] = $this->input->post('totalnilai');
				$data1['catatan2'] = $this->input->post('icatatan');
			} else {
				$data1['totalnilai3'] = $this->input->post('totalnilai');
				$data1['catatan3'] = $this->input->post('icatatan');
			}
			if ($this->session->userdata('a01'))
			{
				if ($asal=="bimbeldashboard")
				{
					$data1['status_verifikasi_bimbel'] = $status_verifikasi;
				}
				else
				{
					$data1['status_verifikasi_admin'] = $status_verifikasi;
					$data1['status_verifikasi'] = $status_verifikasi;
				}
				
				
			}
			else if ($this->session->userdata('bimbel')==4)
				$data1['status_verifikasi_bimbel'] = $status_verifikasi;
			else
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

				// echo "cek_4".$verifikator;	die();

				for ($c = 1; $c <= $total_isian; $c++) {
					$data3['penilaian' . $c] = $this->input->post('inilai' . $c);
					echo $data3['penilaian'.$c];
				}

				
				// die();

				$this->M_video->updatenilai($data1, $id_video);
				$this->M_video->addlogvideo($data2);
				$this->M_video->simpanverifikasi($data3, $id_video);
				if (substr($asal,0,4)=="mntr")
					redirect('event/mentor/video/'.substr($asal,4));
				else if ($asal=="ekskulprofil")
					redirect('video/ekskul/profil');
				else if ($asal=="sekolahkontriprofil")
					redirect('video/kontributor/profil');
				else if ($asal=="eventprofil")
					redirect('video/event/profil');
				else if ($asal=="ekskuldashboard")
					redirect('video/ekskul/dashboard');
				else if ($asal=="sekolahkontridashboard")
					redirect('video/kontributor/dashboard');
				else if ($asal=="sekolahsayadashboard")
					redirect('video/saya/dashboard');
				else if ($asal=="eventdashboard")
					redirect('video/event/dashboard');
				else if ($asal=="bimbeldashboard")
					redirect('video/bimbel/dashboard');
				else if (substr($asal,0,6)=="calver")
					redirect('marketing/calver/video/'.substr($asal,6));
				else if ($this->session->userdata('verifikator')==1)
					redirect('video/kontributor/dashboard');
				else
					redirect('video');
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

	public function getfile()
	{
		$videoId = '8Pyo5IZvA14';
		$apikey = 'AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU';
		$googleApiUrl = 'https://www.googleapis.com/youtube/v3/videos?id=' . $videoId . '&key=' . $apikey . '&part=snippet';

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);

		curl_close($ch);

		$data = json_decode($response);

		$value = json_decode(json_encode($data), true);

		echo 'RESULT <br><pre>';
		var_dump($value);
		echo '</pre>' ;

		$title = $value['items'][0]['snippet']['title'];
		$description = $value['items'][0]['snippet']['description'];
		$channelid = $value['items'][0]['snippet']['channelId'];
		$channeltitle = $value['items'][0]['snippet']['channelTitle'];
		echo $channelid;
	}
}
