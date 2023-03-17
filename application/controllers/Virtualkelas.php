<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Virtualkelas extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_vksekolah");
		$this->load->model("M_payment");
		$this->load->library('Pdf');
		$this->load->library('pagination');
		$this->load->helper(array('tanggalan', 'video', 'Form', 'Cookie', 'download', 'statusverifikator', 'payment'));
	
		date_default_timezone_set("Asia/Jakarta");
	}

	public function index()
	{
		getstatususer();
//		echo $this->session->userdata("a02")."-".$this->session->userdata("a03");
//		die();
		$data = array();
		if ($this->session->userdata("loggedIn")) {
			$getstatususer = getstatususer();
			$data['tutorbimbel'] = false;
			if ($this->session->userdata('bimbel') == 3)
				$data['tutorbimbel'] = true;

			if (!$this->session->userdata("activate")) {
				redirect("login/lengkapiprofil");
			} else {
				if ($this->session->userdata('sebagai') == 1 || $this->session->userdata('bimbel') >= 3) {
					$data['konten'] = "virtual_kelas_sign_guru";
				} else {
					$data['konten'] = "virtual_kelas_sign";
				}

			}
		} else {
			$data['konten'] = "virtual_kelas_nosign";
		}
		setcookie('acara', null, -1, '/');
		unset($_COOKIE['acara']); 
		setcookie('basis', "virtualkelas", time() + (86400), '/');
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function sekolah_saya($tanggal=null)
	{
		

		if (!$this->session->userdata('loggedIn') || $this->session->userdata('siam')==3) {
			redirect("/");
		}

		$statususer = getstatususer();
		if ($this->session->userdata('sebagai') == 2 && $statususer['kelasku'] == 0)
			redirect("/login/profile/kelasuser");

		setcookie('basis', "dashboard", time() + (86400), '/');
		$npsn = $this->session->userdata('npsn');
		$iduser = $this->session->userdata('id_user');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];

		$this->load->Model("M_channel");
		$ceknpsn = $this->M_channel->getSekolahKu($npsn, $prodi);
		

		$data = array();

		$cekmodul = hitungmodulke($tanggal);
		$semester = $cekmodul['semester'];

		$data['tgl_skr'] = $cekmodul['tanggalnya'];
		$data['bln_skr'] = $cekmodul['bulannya'];
		$data['thn_skr'] = $cekmodul['tahunnya'];
		$data['rentang_tgl'] = $cekmodul['rentangtanggal'];
		$data['namasekolah'] = $ceknpsn->nama_sekolah;
		$data['namaprodi'] = $ceknpsn->nama_prodi;

		$nmodul = $cekmodul['nmodul'];
		$data['modulke'] = $nmodul;

		$nminggu = $cekmodul['nminggu'];
		$ambilmodul = null;
		$jml_mapel = 0;

		if ($nmodul == "uts")
			$nmodul = 17;
		else if ($nmodul == "remedial uts")
			$nmodul = 18;
		else if ($nmodul == "uas")
			$nmodul = 19;
		else if ($nmodul == "remedial uas")
			$nmodul = 20;

		

		if ($this->session->userdata('sebagai') == 1) {
			$adamentor = 0;
			$cekuser = $this->M_login->getUser($this->session->userdata('id_user'));
			if ($cekuser['referrer'] != "")
				$adamentor = 1;
			$ambilmodul = $this->M_vksekolah->getModul($nmodul, $iduser, $semester, $adamentor);
			$ambilujian = $this->M_vksekolah->getDafUjianSaya($iduser, $semester);
			$data['dataujian'] = $ambilujian;
			$data['nilaiujian'] = 0;
			$data['konten'] = "vk_dashboard_guru";

			// echo "<pre>";
			// echo var_dump($ambilmodul);
			// echo "</pre>";

		} else {
			
			$ambilmodul = $this->M_vksekolah->getDafModulSaya($iduser, $nmodul, null, $semester);
			// echo "<pre>";
			// echo var_dump($ambilmodul);
			// echo "</pre>";
			$cekgurumodul = $this->M_vksekolah->cekGuruModul($iduser);
			$data['jmlgurupilih'] = sizeof($cekgurumodul);

			$tgl_sekarang = new DateTime();
			$bulanskr = $tgl_sekarang->format("n");
			$modulmana = moduldarike_bulan($bulanskr);
			$dari = $modulmana['dari'];
			$ke = $modulmana['ke'];
			$ujian1 = $modulmana['ujian1'];
			$ujian2 = $modulmana['ujian2'];
			$semester = $modulmana['semester'];

			$jmlmodulbulanini = 0;
			foreach ($cekgurumodul as $row) {
				$adamentor = 0;
				
				$cekuser = $this->M_login->getUser($row->id_guru);
				if ($cekuser['referrer'] != "")
					$adamentor = 1;
				$modulbulanini = $this->M_vksekolah->getModulPaketDariKe($dari, $ke, $semester, $row->id_mapel, $row->id_guru, $adamentor);
				$jmlmodulbulanini = $jmlmodulbulanini + sizeof($modulbulanini);
				// echo "<pre>";
				// echo var_dump($modulbulanini);
				// echo "</pre>";
			}
			// echo "MODUL:".$jmlmodulbulanini;

			

			foreach ($cekgurumodul as $row) {
				$adamentor = 0;
				$cekuser = $this->M_login->getUser($row->id_guru);
				if ($cekuser['referrer'] != "")
					$adamentor = 1;
				$modulbulanini = $this->M_vksekolah->getModulPaketDariKe($ujian1, $ujian2, $semester, $row->id_mapel, $row->id_guru, $adamentor);
				// echo "<pre>";
				// echo var_dump($modulbulanini);
				// echo "</pre>";
				$jmlmodulbulanini = $jmlmodulbulanini + sizeof($modulbulanini);
			}

			// echo "<pre>";
			// echo var_dump($modulbulanini);
			// echo "</pre>";

			// echo "<br>JML MODUL leNGKAP:".$jmlmodulbulanini."<br>";

			$this->load->Model('M_login');
			$datauser = $this->M_login->getUser($iduser);
			// echo "<pre>";
			// echo var_dump($datauser);
			// echo "</pre>";
			// die();
			// $idkelas = $datauser['kelas_user'];
			$this->load->Model('M_channel');
			$mapelaktif = $this->M_channel->getDafPlayListMapel($npsn, $prodi);

			// echo "<pre>";
			// echo var_dump($mapelaktif);
			// echo "</pre>";

			$jmlmapelaktif = sizeof($mapelaktif);
			$data['jmlmapelaktif'] = $jmlmapelaktif;

			// echo $jmlmodulbulanini;
			// echo "CC11122-".$data['jmlgurupilih'];
			// echo "-".$jmlmapelaktif;


			$data['modullengkap'] = false;
			if ($jmlmodulbulanini == $jmlmapelaktif * 4)
				$data['modullengkap'] = true;

			// $data['modullengkap'] = true;

			$data['statusbelipaket'] = 0;
			$data['keteranganbayar'] = "";

			$nilailatihan = $this->M_vksekolah->getAllNilaiLatihan($iduser, $nmodul, $semester);
			//$cekbayarstrata = $this->cekiuran($iduser);
			$getbayarvk = getstatusbelivk(1);
			$data['statusbelipaket'] = $getbayarvk['status_vk_sekarang'];

			if ($getbayarvk['status_tunggu'] == "tunggu") {
				$cekbayarstrata = "Paket " . $getbayarvk['status_vk_sekarang'] . "<br>" . "Menunggu pembayaran upgrade " .
					$getbayarvk['status_vk_berikutnya'];
				if ($getbayarvk['status_vk_sekarang'] == "0")
					$cekbayarstrata = "Menunggu pembayaran paket " . $getbayarvk['status_vk_berikutnya'];
			} else {
				if ($getbayarvk['status_vk_sekarang'] == "0")
					$cekbayarstrata = "[Beli paket]";
				else
					$cekbayarstrata = "Paket " . $getbayarvk['status_vk_sekarang'];
			}
			$dafmapel = array();
			$dafnilai = array();
			$totalnilai = 0;
			$nilaiujian = 0;

//			echo "<pre>";
//			echo var_dump($nilailatihan);
//			echo "</pre>";
//			die();

			foreach ($nilailatihan as $datane) {
				if ($datane->nama_paket == "UTS" && $datane->semester == 1) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "UTS" && $datane->semester == 2) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "UAS" && $datane->semester == 1) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "UAS" && $datane->semester == 2) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "REMEDIAL UTS" && $datane->semester == 1) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "REMEDIAL UTS" && $datane->semester == 2) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "REMEDIAL UAS" && $datane->semester == 1) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "REMEDIAL UAS" && $datane->semester == 2) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if (in_array($datane->nama_mapel, $dafmapel)) {
					$dafnilai[$datane->nama_mapel] = $dafnilai[$datane->nama_mapel] + $datane->highscore;
					$totalnilai = $totalnilai + $datane->highscore;
					continue;
				} else {
					$jml_mapel++;
					$dafmapel[] = $datane->nama_mapel;
					$dafnilai[$datane->nama_mapel] = 0;
					$dafnilai[$datane->nama_mapel] = $datane->highscore;
					$totalnilai = $totalnilai + $datane->highscore;
				}
			}

			$ceksekolahpremium = ceksekolahpremium();
			$statusvksekolah = $ceksekolahpremium['status_sekolah'];

//			echo "<pre>";
//			echo var_dump($nilailatihan);
//			echo "</pre>";
//			die();

			if ($statusvksekolah == "Pro") {
				if ($getbayarvk['status_vk_sekarang'] == "Premium")
					$cekbayarstrata = "[Sekolah Pro]<br>Paket Premium";
				else
					$cekbayarstrata = "Paket Sekolah Pro";
			} else if ($statusvksekolah == "Premium")
				$cekbayarstrata = "Paket Sekolah Premium";
			$data['nilaiujian'] = $nilaiujian;
			$data['keteranganbayar'] = $cekbayarstrata;
			$data['totalnilaitugas'] = 0;
			if ($jml_mapel > 0 && $nmodul > 0)
				$totalnilailatihan = round($totalnilai / ($jml_mapel * $nmodul), 2);
			else
				$totalnilailatihan = 0;
			$data['totalnilailatihan'] = $totalnilailatihan;

			$ambilujian = $this->M_vksekolah->getDafUjianGuruSaya($iduser, $semester);

//			echo "<pre>";
//			echo var_dump($ambilujian);
//			echo "</pre>";

			if ($ambilujian) {
				$tglmulai = $ambilujian[0]->tglvicon;
				$tglakhir = $ambilujian[0]->tanggal_tayang;

				foreach ($ambilujian as $datane) {
					{
						if (strtotime($datane->tglvicon) < strtotime($tglmulai))
							$tglmulai = $datane->tglvicon;

						if (strtotime($datane->tanggal_tayang) > strtotime($tglakhir))
							$tglakhir = $datane->tanggal_tayang;
					}
				}
				$data['jadwalujian'] = $tglmulai . " - " . $tglakhir;
			}
			//
//			echo "<pre>";
//			echo var_dump($ambilujian);
//			echo "</pre>";
//			die();
			$data['dataujian'] = $ambilujian;

			$data['konten'] = "vk_dashboard";
		}


		$data['jmlmapel'] = $jml_mapel;
		$data['tglsekarang'] = $cekmodul['tanggalsekarang'];
		$data['semester'] = $semester;
		$data['pertemuanke'] = $nminggu;
		$data['datamodul'] = $ambilmodul;

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function event($bulanevent=null, $tahunevent=null, $kodeevent=null, $idpeserta=null, $kodementor=null)
	{
		if ($bulanevent==5)
			$bulanevent=4;
		if ($bulanevent==6)
			$bulanevent=7;
		if (!$this->session->userdata('loggedIn'))
		{
			setcookie('mentor', '2-'.$bulanevent.$tahunevent.$kodeevent, time() + (86400), '/');
			redirect(base_url()."/login");
		}
		else
		{
			setcookie('mentor', '--', time() + (86400), '/');
		}

		if ($bulanevent==null)
		{
			$sekarang = new DateTime();
			$bulanevent = $sekarang->format("n");
			$tahunevent = $sekarang->format("Y");

		}
		
		$bulanevent = intval($bulanevent);

		$statususer = getstatususer();
		
		$npsn = $this->session->userdata('npsn');
		$iduser = $this->session->userdata('id_user');

		if ($this->session->userdata('sebagai') == 1) {
		
		$statususer = getstatususer();
		
		$full_name = $this->session->userdata('full_name');
		$referrer = $statususer['referrer'];
		if ($referrer=="" || $referrer==null)
		{
			redirect('/');
		}

		$cekkodeeventmentor = $this->M_vksekolah->cekKodeEventMentor($bulanevent, $tahunevent, $referrer);
			if ($cekkodeeventmentor)
				$kodeeventmentor = $cekkodeeventmentor->kode_event;
			else
				$kodeeventmentor = "-";
		}

		$kodeeventsaya = "kosong";
		$nama_sertifikat = "";
		$email_sertifikat = "";
		$download_sertifikat = 0;
		$cekkodeeventsaya = $this->M_vksekolah->cekKodeEventSaya($iduser, $bulanevent, $tahunevent);

		if ($cekkodeeventsaya!="kosong")
			{
				$kodeeventsaya = $cekkodeeventsaya->kode_event;
				$nama_sertifikat = $cekkodeeventsaya->nama_sertifikat;
				$email_sertifikat = $cekkodeeventsaya->email_sertifikat;
				$download_sertifikat = $cekkodeeventsaya->download_sertifikat;
			}
		
		$data = array();

		$data['download_sertifikat'] = $download_sertifikat;

		$data['bulanevent0'] = $bulanevent;
		$data['tahunevent0'] = $tahunevent;		
		
		$bulanevent = $bulanevent+1;

		if ($bulanevent>12)
		{
			$bulanevent=1;
			$tahunevent++;
		}

		$bulan = $bulanevent;
		$tahun = $tahunevent;

		if ($bulan>12)
		{
			$bulan=1;
			$tahun++;
		}

		$data['kodeevent'] = $kodeevent;
		$data['bulanevent'] = $bulanevent;
		$data['tahunevent'] = $tahunevent;

		$tgl_sekarang = new DateTime();
		$bulanskr = $tgl_sekarang->format("n");

		$modulmana = moduldarike_bulan($bulanevent);
		$dari = $modulmana['dari'];
		$ke = $modulmana['ke'];
		$ujian1 = $modulmana['ujian1'];
		$ujian2 = $modulmana['ujian2'];
		$semester = $modulmana['semester'];

		if ($this->session->userdata('sebagai') == 1) {

			$lanjutkan = false;
			if ($kodeeventsaya!="kosong")
			{
				$lanjutkan = true;
			}
			else if ($kodeevent!=null AND ($kodeevent == $kodeeventmentor))
			{
				$lanjutkan = true;
				$dataadd = array('id_guru'=>$iduser,'bulan'=>$bulanevent,'tahun'=>$tahunevent,'kode_event'=>$kodeeventmentor);
				$this->M_vksekolah->addKodeEventSaya($dataadd);
			}


			if ($cekkodeeventsaya!="kosong")
				{
					$kodeeventsaya = $cekkodeeventsaya->kode_event;
					$nama_sertifikat = $cekkodeeventsaya->nama_sertifikat;
					$email_sertifikat = $cekkodeeventsaya->email_sertifikat;
					$download_sertifikat = $cekkodeeventsaya->download_sertifikat;
				}
			
			$data['download_sertifikat'] = $download_sertifikat;
			
			$lanjutkan = false;
			if ($kodeeventsaya!="kosong")
			{
				$lanjutkan = true;
			}
			else if ($kodeevent!=null AND ($kodeevent == $kodeeventmentor))
			{
				$lanjutkan = true;
				$dataadd = array('id_guru'=>$iduser,'bulan'=>$bulanevent,'tahun'=>$tahunevent,'kode_event'=>$kodeeventmentor);
				$this->M_vksekolah->addKodeEventSaya($dataadd);
			}

			

			// echo "<pre>";
			// echo var_dump ($modulmana);
			// echo "</pre>";

			// if($this->session->userdata('sebagai')==2)
			// {
			// 	$getkelas = $this->M_login->dafjenjangkelas($statususer['kelasku']);
			// 	$data['namakelas'] = $getkelas->nama_pendek." - ".$getkelas->nama_kelas;
			// }
			// else
			// {
			// 	$data['namakelas'] = "";
			// }

			$data['referrer'] = $referrer;
			$data['lanjutkan'] = $lanjutkan;
			$data['bulaninioke'] = false;
			$data['bulanini'] = "untuk bulan ".nmbulan_panjang($bulanevent)." ".$tahunevent;
			$ambilmodul = $this->M_vksekolah->getModulEventMentor($dari, $ke, $semester);
			$ambilujian = $this->M_vksekolah->getModulEventMentor($ujian1, $ujian2, $semester);

			$urutan = 0;
			if ($dari==9)
			$urutan = 2;

			$jmlmodulaktif = sizeof($ambilmodul);
			$jmlujianaktif = sizeof($ambilujian);

			if ($jmlmodulaktif+$jmlujianaktif==40)
			{
				// echo "LENGKAP BULAN INI";
				$modulmana = moduldarike_bulan($bulan);
				$dari = $modulmana['dari'];
				$ke = $modulmana['ke'];
				$ujian1 = $modulmana['ujian1'];
				$ujian2 = $modulmana['ujian2'];
				$semester = $modulmana['semester'];

				$data['bulaninioke'] = true;
				$data['bulanini'] = "untuk bulan ".nmbulan_panjang($bulan)." ".$tahun;
				$ambilmodul = $this->M_vksekolah->getModulEventMentor($dari, $ke, $semester);
				$ambilujian = $this->M_vksekolah->getModulEventMentor($ujian1, $ujian2, $semester);	
			}
			else
			{
				// echo "BELUM LENGKAP BULAN INI";
				$bulan = $bulanevent;
				$tahun = $tahunevent;
			}

			$data['dataujian'] = $ambilujian;
			$data['nilaiujian'] = 0;

			
			$xbulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
			$tgakhirbln = new DateTime($tahun.'-'.$xbulan.'-01 00:00:00');
			$tglnya =  $tgakhirbln->format("t");

			$rtg = array("","1 - 7","8 - 14","15 - 21","22 - ".$tglnya);

			$urutan = 0;
			if ($dari==9)
			$urutan = 2;

			$jmlmodulaktif = sizeof($ambilmodul);
			$jmlujianaktif = sizeof($ambilujian);

			$data['moduldibuat1'] = 0;
			$data['moduldibuat2'] = 0;
			$data['moduldibuat3'] = 0;
			$data['moduldibuat4'] = 0;
			$data['modulke1'] = 0;
			$data['modulke2'] = 0;
			$data['modulke3'] = 0;
			$data['modulke4'] = 0;
			$data['warna1'] = "danger";
			$data['warna2'] = "danger";
			$data['warna3'] = "danger";
			$data['warna4'] = "danger";

			// echo "<pre>";
			// echo var_dump ($ambilujian);
			// echo "</pre>";

			// echo $jmlmodulaktif."---";
			// echo $jmlujianaktif;
			
			$indeks=0;
			for ($a=$dari; $a<=$ke; $a++)
			{
				$urutan++;
				$tgl=($urutan-1)*7+1;
				$cekmodul = hitungmodulke($tahun.'-'.$bulan.'-'.$tgl.' 00:00:00');
				$mingguke = $cekmodul['nminggu'];
				$modulke = $cekmodul['nmodul'];
				$data['pertemuanke'.$urutan] = $mingguke;
				$data['rentang_tgl'.$urutan] = $rtg[$urutan]. " " . nmbulan_pendek($bulan) . " " . $tahun;
				$data['modulke'.$urutan] = $modulke;

				if ($indeks<$jmlmodulaktif)
				{
					$indeks++;
					$isimapel[1] = $ambilmodul[$indeks-1]->nama_mapel;
					$isijudul[1] = $ambilmodul[$indeks-1]->nama_paket;
					$durpaket = $ambilmodul[$indeks-1]->durasi_paket;
					$tgv = $ambilmodul[$indeks-1]->tglvicon;
					$materi = $ambilmodul[$indeks-1]->uraianmateri;
					$soal = $ambilmodul[$indeks-1]->statussoal;
					$tugas = $ambilmodul[$indeks-1]->statustugas;
					$mentor = $ambilmodul[$indeks-1]->statusmentor;
					$data['moduldibuat'.$urutan] = 1;
				}
				else
				{
					$isimapel[1] = '-';
					$isijudul[1] = '-';
					$durpaket = '-';
					$tgv = '-';
					$materi = "";
					$soal = 0;
					$tugas = 0;
					$mentor = 0;
				}

				$data['warna'.$urutan] = "danger";
				$data['durasi'.$urutan] = $durpaket;
				$data['mapel'.$urutan] = $isimapel;
				$data['judulmodul'.$urutan] = $isijudul;
									
				if ($tgv=="2021-01-01 00:00:00")
					$data['vc'.$urutan] = "VC -";
				else
					{
						if ($tgv=="-")
							$data['vc'.$urutan] = "VC -";
						else
							$data['vc'.$urutan] = "VC ".namabulan_pendek($tgv).", ".substr($tgv,11,5)." WIB";
					}
				if ($soal==1 && $materi!="" && $tugas==1)
					{
						$data['materi'.$urutan] = "Materi/Soal : Lengkap";
						$data['warna'.$urutan] = "primary";
					}
				else
					$data['materi'.$urutan] = "Materi/Soal : Belum";
				
				if ($mentor==2)
					{
						$data['warna'.$urutan] = "success";
						$data['mentor'.$urutan] = "OKE";
					}
				else if ($mentor==1)
					$data['mentor'.$urutan] = "Belum Oke";
				else
					$data['mentor'.$urutan] = "Belum Dicek";

			}

			if ($ujian1>0)
			{
				if ($dari==9)
					$urutan = 0;

				$indeks=0;
				for ($b=$ujian1; $b<=$ujian2; $b++)
				{
					$urutan++;
					$tgl=($urutan-1)*7+1;
					$cekmodul = hitungmodulke($tahun.'-'.$bulan.'-'.$tgl.' 00:00:00');
					$mingguke = $cekmodul['nminggu'];
					$modulke = $cekmodul['nmodul'];
					$data['pertemuanke'.$urutan] = $mingguke;
					$data['rentang_tgl'.$urutan] = $rtg[$urutan]. " " . nmbulan_pendek($bulan) . " " . $tahun;
					$data['modulke'.$urutan] = $modulke;

					if ($indeks<$jmlujianaktif)
					{
						$indeks++;
						$isimapel[1] = $ambilujian[$indeks-1]->nama_mapel;
						$isijudul[1] = $ambilujian[$indeks-1]->nama_paket;
						$tgv = $ambilujian[$indeks-1]->tglvicon;
						$materi = $ambilujian[$indeks-1]->uraianmateri;
						$soal = $ambilujian[$indeks-1]->statussoal;
						$tugas = $ambilujian[$indeks-1]->statustugas;
						$mentor = $ambilujian[$indeks-1]->statusmentor;
						$data['moduldibuat'.$urutan] = 1;
					}
					else
					{
						$isimapel[1] = '-';
						$isijudul[1] = '-';
						$tgv = '-';
						$materi = "";
						$soal = 0;
						$tugas = 0;
						$mentor = 0;
					}

					$data['warna'.$urutan] = "danger";
					$data['durasi'.$urutan] = "";
					$data['mapel'.$urutan] = $isimapel;
					$data['judulmodul'.$urutan] = $isijudul;
					if ($tgv=="2021-01-01 00:00:00")
						$data['vc'.$urutan] = "Waktu: -";
					else
						{
							if ($tgv=="-")
								$data['vc'.$urutan] = "Jadwal -";
							else
								$data['vc'.$urutan] = "Jadwal ".namabulan_pendek($tgv).", ".substr($tgv,11,5)." WIB";
						}
					if ($soal==1)
						{
							$data['materi'.$urutan] = "Soal : Tersedia";
							$data['warna'.$urutan] = "primary";
						}
					else
						$data['materi'.$urutan] = "Soal : Belum";
					
					if ($mentor==2)
						{
							$data['warna'.$urutan] = "success";
							$data['mentor'.$urutan] = "OKE";
						}
					else if ($mentor==1)
						$data['mentor'.$urutan] = "Belum Oke";
					else
						$data['mentor'.$urutan] = "Belum Dicek";
					
				}
			}

			// echo "1:".$data['moduldibuat1']."<br>";
			// echo "2:".$data['moduldibuat2']."<br>";
			// echo "3:".$data['moduldibuat3']."<br>";
			// echo "4:".$data['moduldibuat4']."<br>";
			$data['bulan'] = $bulan;
			$data['tahun'] = $tahun;
			if ($kodeevent!=null)
			{
				$this->load->Model('M_marketing');
				$cekkode = $this->M_marketing->getDafEventbyCode($kodeevent);
				$kodereferal = $cekkode[0]->kode_referal;
				
			}

			$data['datavideo'] = $this->M_vksekolah->cekKodeEventMentor($data['bulanevent0'], $data['tahunevent0'], $referrer);
			
			
			$this->load->Model('M_channel');
			$data['datapesan'] = $this->M_channel->getChat(5, $referrer, $kodeeventmentor);
			$data['jenis'] = "mentor";
			$data['id_playlist'] = $kodeeventmentor;
			$data['konten'] = "vk_event_dashboard_guru";
			$data['idku'] = $this->session->userdata('id_user');
			$data['fullname'] = $full_name;

			$data['nama_sertifikat'] = $nama_sertifikat;
			$data['email_sertifikat'] = $email_sertifikat;
			$data['download_sertifikat'] = $download_sertifikat;
			$data['sertifikatfix'] = true;
			$data['cekfix'] = "block";

			if ($nama_sertifikat=="")
			{
				$data['sertifikatfix'] = false;
				$data['email_sertifikat'] = $this->session->userdata('email');
				$data['nama_sertifikat'] = $full_name;
				$data['cekfix'] = "none";
				if ($full_name=="")
					$data['nama_sertifikat'] = $this->session->userdata('first_name').
					" ".$this->session->userdata('last_name');
			}

			// echo "<pre>";
			// echo var_dump($data['datapesan'] );
			// echo "</pre>";

		} else if ($this->session->userdata('siam') == 3) {
			
			$statususer = getstatususer();
			
			$npsn = $this->session->userdata('npsn');
			$iduser = $this->session->userdata('id_user');
			$full_name = $this->session->userdata('full_name');
			$this->load->Model('M_marketing');
			$cekkode = $this->M_marketing->getDafEventbyCode($kodeevent);
			$data['npsne'] = $cekkode[0]->npsn_sekolah;
			$kodereferal = $cekkode[0]->kode_referal;
			$data['bulaninioke'] = false;
			$data['bulanini'] = "untuk bulan ".nmbulan_panjang($bulanevent)." ".$tahunevent;
			$ambilmodul = $this->M_vksekolah->getModulEventMentor($dari, $ke, $semester);
			$ambilujian = $this->M_vksekolah->getModulEventMentor($ujian1, $ujian2, $semester);

			$data['datavideo'] = $this->M_vksekolah->cekKodeEventMentor($data['bulanevent0'], $data['tahunevent0'], $kodereferal);
			// echo $bulan;
			// echo "<pre>";
			// echo var_dump($data['datavideo'] );
			// echo "</pre>";

			$urutan = 0;
			if ($dari==9)
			$urutan = 2;

			$jmlmodulaktif = sizeof($ambilmodul);
			$jmlujianaktif = sizeof($ambilujian);

			if ($jmlmodulaktif+$jmlujianaktif==40)
			{
				// echo "LENGKAP BULAN INI";
				$modulmana = moduldarike_bulan($bulan);
				$dari = $modulmana['dari'];
				$ke = $modulmana['ke'];
				$ujian1 = $modulmana['ujian1'];
				$ujian2 = $modulmana['ujian2'];
				$semester = $modulmana['semester'];

				$data['bulaninioke'] = true;
				$data['bulanini'] = "untuk bulan ".nmbulan_panjang($bulan)." ".$tahun;
				$ambilmodul = $this->M_vksekolah->getModulEventMentor($dari, $ke, $semester);
				$ambilujian = $this->M_vksekolah->getModulEventMentor($ujian1, $ujian2, $semester);	
			}
			else
			{
				// echo "BELUM LENGKAP BULAN INI";
				$bulan = $bulanevent;
				$tahun = $tahunevent;
			}

			$data['dataujian'] = $ambilujian;
			$data['nilaiujian'] = 0;

			
			$xbulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
			$tgakhirbln = new DateTime($tahun.'-'.$xbulan.'-01 00:00:00');
			$tglnya =  $tgakhirbln->format("t");

			$rtg = array("","1 - 7","8 - 14","15 - 21","22 - ".$tglnya);

			$urutan = 0;
			if ($dari==9)
			$urutan = 2;

			$jmlmodulaktif = sizeof($ambilmodul);
			$jmlujianaktif = sizeof($ambilujian);

			$data['moduldibuat1'] = 0;
			$data['moduldibuat2'] = 0;
			$data['moduldibuat3'] = 0;
			$data['moduldibuat4'] = 0;
			$data['modulke1'] = 0;
			$data['modulke2'] = 0;
			$data['modulke3'] = 0;
			$data['modulke4'] = 0;

			// echo "<pre>";
			// echo var_dump ($ambilujian);
			// echo "</pre>";

			// echo $jmlmodulaktif."---";
			// echo $jmlujianaktif;
			
			$indeks=0;
			for ($a=$dari; $a<=$ke; $a++)
			{
				$urutan++;
				$tgl=($urutan-1)*7+1;
				$cekmodul = hitungmodulke($tahun.'-'.$bulan.'-'.$tgl.' 00:00:00');
				$mingguke = $cekmodul['nminggu'];
				$modulke = $cekmodul['nmodul'];
				$data['pertemuanke'.$urutan] = $mingguke;
				$data['rentang_tgl'.$urutan] = $rtg[$urutan]. " " . nmbulan_pendek($bulan) . " " . $tahun;
				$data['modulke'.$urutan] = $modulke;

				if ($indeks<$jmlmodulaktif)
				{
					$indeks++;
					$isimapel[1] = $ambilmodul[$indeks-1]->nama_mapel;
					$isijudul[1] = $ambilmodul[$indeks-1]->nama_paket;
					$durpaket = $ambilmodul[$indeks-1]->durasi_paket;
					$tgv = $ambilmodul[$indeks-1]->tglvicon;
					$materi = $ambilmodul[$indeks-1]->uraianmateri;
					$soal = $ambilmodul[$indeks-1]->statussoal;
					$tugas = $ambilmodul[$indeks-1]->statustugas;
					$mentor = $ambilmodul[$indeks-1]->statusmentor;
					$data['moduldibuat'.$urutan] = 1;
				}
				else
				{
					$isimapel[1] = '-';
					$isijudul[1] = '-';
					$durpaket = '-';
					$tgv = '-';
					$materi = "";
					$soal = 0;
					$tugas = 0;
					$mentor = 0;
				}

				$data['warna'.$urutan] = "danger";
				$data['durasi'.$urutan] = $durpaket;
				$data['mapel'.$urutan] = $isimapel;
				$data['judulmodul'.$urutan] = $isijudul;
									
				if ($tgv=="2021-01-01 00:00:00")
					$data['vc'.$urutan] = "VC -";
				else
					{
						if ($tgv=="-")
							$data['vc'.$urutan] = "VC -";
						else
							$data['vc'.$urutan] = "VC ".namabulan_pendek($tgv).", ".substr($tgv,11,5)." WIB";
					}
				if ($soal==1 && $materi!="" && $tugas==1)
					{
						$data['materi'.$urutan] = "Materi/Soal : Lengkap";
						$data['warna'.$urutan] = "primary";
					}
				else
					$data['materi'.$urutan] = "Materi/Soal : Belum";
				
				if ($mentor==2)
					{
						$data['warna'.$urutan] = "success";
						$data['mentor'.$urutan] = "OKE";
					}
				else if ($mentor==1)
					$data['mentor'.$urutan] = "Belum Oke";
				else
					$data['mentor'.$urutan] = "Belum Dicek";

			}

			if ($ujian1>0)
			{
				if ($dari==9)
					$urutan = 0;

				$indeks=0;
				for ($b=$ujian1; $b<=$ujian2; $b++)
				{
					$urutan++;
					$tgl=($urutan-1)*7+1;
					$cekmodul = hitungmodulke($tahun.'-'.$bulan.'-'.$tgl.' 00:00:00');
					$mingguke = $cekmodul['nminggu'];
					$modulke = $cekmodul['nmodul'];
					$data['pertemuanke'.$urutan] = $mingguke;
					$data['rentang_tgl'.$urutan] = $rtg[$urutan]. " " . nmbulan_pendek($bulan) . " " . $tahun;
					$data['modulke'.$urutan] = $modulke;

					if ($indeks<$jmlujianaktif)
					{
						$indeks++;
						$isimapel[1] = $ambilujian[$indeks-1]->nama_mapel;
						$isijudul[1] = $ambilujian[$indeks-1]->nama_paket;
						$tgv = $ambilujian[$indeks-1]->tglvicon;
						$materi = $ambilujian[$indeks-1]->uraianmateri;
						$soal = $ambilujian[$indeks-1]->statussoal;
						$tugas = $ambilujian[$indeks-1]->statustugas;
						$mentor = $ambilujian[$indeks-1]->statusmentor;
						$data['moduldibuat'.$urutan] = 1;
					}
					else
					{
						$isimapel[1] = '-';
						$isijudul[1] = '-';
						$tgv = '-';
						$materi = "";
						$soal = 0;
						$tugas = 0;
						$mentor = 0;
					}

					$data['warna'.$urutan] = "danger";
					$data['durasi'.$urutan] = "";
					$data['mapel'.$urutan] = $isimapel;
					$data['judulmodul'.$urutan] = $isijudul;
					if ($tgv=="2021-01-01 00:00:00")
						$data['vc'.$urutan] = "Waktu: -";
					else
						{
							if ($tgv=="-")
								$data['vc'.$urutan] = "Jadwal -";
							else
								$data['vc'.$urutan] = "Jadwal ".namabulan_pendek($tgv).", ".substr($tgv,11,5)." WIB";
						}
					if ($soal==1)
						{
							$data['materi'.$urutan] = "Soal : Tersedia";
							$data['warna'.$urutan] = "primary";
						}
					else
						$data['materi'.$urutan] = "Soal : Belum";
					
					if ($mentor==2)
						{
							$data['warna'.$urutan] = "success";
							$data['mentor'.$urutan] = "OKE";
						}
					else if ($mentor==1)
						$data['mentor'.$urutan] = "Belum Oke";
					else
						$data['mentor'.$urutan] = "Belum Dicek";
					
				}
			}

			// echo "1:".$data['moduldibuat1']."<br>";
			// echo "2:".$data['moduldibuat2']."<br>";
			// echo "3:".$data['moduldibuat3']."<br>";
			// echo "4:".$data['moduldibuat4']."<br>";
			$data['bulan'] = $bulan;
			$data['tahun'] = $tahun;

			$this->load->Model('M_channel');
			$data['datapesan'] = $this->M_channel->getChat(5, null, $kodeevent);
			$data['jenis'] = "mentor";
			$data['id_playlist'] = $kodeevent;
			$data['konten'] = "vk_event_dashboard_mentor";
			$data['idku'] = $this->session->userdata('id_user');
			$data['fullname'] = $full_name;

			$data['nama_sertifikat'] = "";
			$data['email_sertifikat'] = "";
			$data['download_sertifikat'] = 0;
			$data['sertifikatfix'] = true;
			$data['cekfix'] = "block";
			$data['lanjutkan'] = true;
			$data['referrer'] = 0;

			// echo "<pre>";
			// echo var_dump($data['datapesan'] );
			// echo "</pre>";

		} 
		else {
			redirect("/");
			$ambilmodul = $this->M_vksekolah->getDafModulSaya($iduser, $nmodul, null, $semester);
			$cekgurumodul = $this->M_vksekolah->cekGuruModul($iduser);
			$data['jmlgurupilih'] = sizeof($cekgurumodul);

			$tgl_sekarang = new DateTime();
			$bulanskr = $tgl_sekarang->format("n");
			$modulmana = moduldarike_bulan($bulanskr);
			$dari = $modulmana['dari'];
			$ke = $modulmana['ke'];
			$ujian1 = $modulmana['ujian1'];
			$ujian2 = $modulmana['ujian2'];
			$semester = $modulmana['semester'];

			$jmlmodulbulanini = 0;
			foreach ($cekgurumodul as $row) {
				$adamentor = 0;
				$cekuser = $this->M_login->getUser($row->id_guru);
				if ($cekuser['referrer'] != "")
					$adamentor = 1;
				$modulbulanini = $this->M_vksekolah->getModulPaketDariKe($dari, $ke, $semester, $row->id_mapel, $row->id_guru, $adamentor);
				$jmlmodulbulanini = $jmlmodulbulanini + sizeof($modulbulanini);
				// echo "<pre>";
				// echo var_dump($modulbulanini);
				// echo "</pre>";
			}
			// echo "MODUL:".$jmlmodulbulanini;

			

			foreach ($cekgurumodul as $row) {
				$adamentor = 0;
				$cekuser = $this->M_login->getUser($row->id_guru);
				if ($cekuser['referrer'] != "")
					$adamentor = 1;
				$modulbulanini = $this->M_vksekolah->getModulPaketDariKe($ujian1, $ujian2, $semester, $row->id_mapel, $row->id_guru, $adamentor);
				// echo "<pre>";
				// echo var_dump($modulbulanini);
				// echo "</pre>";
				$jmlmodulbulanini = $jmlmodulbulanini + sizeof($modulbulanini);
			}

			// echo "<pre>";
			// echo var_dump($modulbulanini);
			// echo "</pre>";

			// echo "<br>JML MODUL leNGKAP:".$jmlmodulbulanini."<br>";

			$this->load->Model('M_login');
			$datauser = $this->M_login->getUser($iduser);
			$idkelas = $datauser['kelas_user'];
			$this->load->Model('M_channel');
			$mapelaktif = $this->M_channel->getDafPlayListMapel($npsn, $idkelas);

			// echo "<pre>";
			// echo var_dump($mapelaktif);
			// echo "</pre>";

			$jmlmapelaktif = sizeof($mapelaktif);
			$data['jmlmapelaktif'] = $jmlmapelaktif;

			// echo $jmlmodulbulanini;
			// echo "-".$data['jmlgurupilih'];
			// echo "-".$jmlmapelaktif;


			$data['modullengkap'] = false;
			if ($jmlmodulbulanini == $jmlmapelaktif * 4)
				$data['modullengkap'] = true;
			

			$data['statusbelipaket'] = 0;
			$data['keteranganbayar'] = "";

			$nilailatihan = $this->M_vksekolah->getAllNilaiLatihan($iduser, $nmodul, $semester);
			//$cekbayarstrata = $this->cekiuran($iduser);
			$getbayarvk = getstatusbelivk(1);
			$data['statusbelipaket'] = $getbayarvk['status_vk_sekarang'];

			if ($getbayarvk['status_tunggu'] == "tunggu") {
				$cekbayarstrata = "Paket " . $getbayarvk['status_vk_sekarang'] . "<br>" . "Menunggu pembayaran upgrade " .
					$getbayarvk['status_vk_berikutnya'];
				if ($getbayarvk['status_vk_sekarang'] == "0")
					$cekbayarstrata = "Menunggu pembayaran paket " . $getbayarvk['status_vk_berikutnya'];
			} else {
				if ($getbayarvk['status_vk_sekarang'] == "0")
					$cekbayarstrata = "[Beli paket]";
				else
					$cekbayarstrata = "Paket " . $getbayarvk['status_vk_sekarang'];
			}
			$dafmapel = array();
			$dafnilai = array();
			$totalnilai = 0;
			$nilaiujian = 0;

//			echo "<pre>";
//			echo var_dump($nilailatihan);
//			echo "</pre>";
//			die();

			foreach ($nilailatihan as $datane) {
				if ($datane->nama_paket == "UTS" && $datane->semester == 1) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "UTS" && $datane->semester == 2) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "UAS" && $datane->semester == 1) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "UAS" && $datane->semester == 2) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "REMEDIAL UTS" && $datane->semester == 1) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "REMEDIAL UTS" && $datane->semester == 2) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "REMEDIAL UAS" && $datane->semester == 1) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if ($datane->nama_paket == "REMEDIAL UAS" && $datane->semester == 2) {
					$nilaiujian = $datane->highscore;
					continue;
				} else if (in_array($datane->nama_mapel, $dafmapel)) {
					$dafnilai[$datane->nama_mapel] = $dafnilai[$datane->nama_mapel] + $datane->highscore;
					$totalnilai = $totalnilai + $datane->highscore;
					continue;
				} else {
					$jml_mapel++;
					$dafmapel[] = $datane->nama_mapel;
					$dafnilai[$datane->nama_mapel] = 0;
					$dafnilai[$datane->nama_mapel] = $datane->highscore;
					$totalnilai = $totalnilai + $datane->highscore;
				}
			}

			$ceksekolahpremium = ceksekolahpremium();
			$statusvksekolah = $ceksekolahpremium['status_sekolah'];

//			echo "<pre>";
//			echo var_dump($nilailatihan);
//			echo "</pre>";
//			die();

			if ($statusvksekolah == "Pro") {
				if ($getbayarvk['status_vk_sekarang'] == "Premium")
					$cekbayarstrata = "[Sekolah Pro]<br>Paket Premium";
				else
					$cekbayarstrata = "Paket Sekolah Pro";
			} else if ($statusvksekolah == "Premium")
				$cekbayarstrata = "Paket Sekolah Premium";
			$data['nilaiujian'] = $nilaiujian;
			$data['keteranganbayar'] = $cekbayarstrata;
			$data['totalnilaitugas'] = 0;
			if ($jml_mapel > 0 && $nmodul > 0)
				$totalnilailatihan = round($totalnilai / ($jml_mapel * $nmodul), 2);
			else
				$totalnilailatihan = 0;
			$data['totalnilailatihan'] = $totalnilailatihan;

			$ambilujian = $this->M_vksekolah->getDafUjianGuruSaya($iduser, $semester);

//			echo "<pre>";
//			echo var_dump($ambilujian);
//			echo "</pre>";

			if ($ambilujian) {
				$tglmulai = $ambilujian[0]->tglvicon;
				$tglakhir = $ambilujian[0]->tanggal_tayang;

				foreach ($ambilujian as $datane) {
					{
						if (strtotime($datane->tglvicon) < strtotime($tglmulai))
							$tglmulai = $datane->tglvicon;

						if (strtotime($datane->tanggal_tayang) > strtotime($tglakhir))
							$tglakhir = $datane->tanggal_tayang;
					}
				}
				$data['jadwalujian'] = $tglmulai . " - " . $tglakhir;
			}
			//
//			echo "<pre>";
//			echo var_dump($ambilujian);
//			echo "</pre>";
//			die();
			$data['dataujian'] = $ambilujian;

			$data['konten'] = "vk_dashboard";
		}

		
		$data['semester'] = $semester;
		$data['datamodul'] = $ambilmodul;

		$this->load->view('layout/wrapper_umum', $data);
	}

	private function cekiuran($iduser)
	{
		getstatusbelivk();
		$tstrata = array("-", "Lite", "Pro", "Premium");
		$this->load->Model('M_channel');
		$cekbeliaktif = $this->M_channel->getlast_kdbeli($iduser, 1, 2);
		$cekbeliakhir = $this->M_channel->getlast_kdbeli($iduser, 1);

		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
		$tanggalsekarang = strtotime($tglsekarang->format("Y-m-d H:i:s"));


		if ($cekbeliaktif) {
			$tglmulai = strtotime($cekbeliaktif->tgl_beli);
			$tglakhir = strtotime($cekbeliaktif->tgl_batas);
			if ($tanggalsekarang >= $tglmulai && $tanggalsekarang <= $tglakhir) {
				$statussebelumnya = $cekbeliaktif->strata_paket;
			} else {
				$statussebelumnya = 0;
			}
		}

		if ($cekbeliakhir) {
			$statusbayar = $cekbeliakhir->status_beli;
			if ($statusbayar == 2 && $tanggalsekarang >= $tglmulai && $tanggalsekarang <= $tglakhir) {
				$statussekarang = 9;
			} else if ($statusbayar == 1 && $tanggalsekarang >= $tglmulai && $tanggalsekarang <= $tglakhir) {
				$statussekarang = $cekbeliakhir->strata_paket;
			} else {
				$statussekarang = 0;
			}
		}

		if ($statussekarang == 9)
			return $tstrata[$statussebelumnya];
		else if ($statussekarang > 0)
			return $tstrata[$statussebelumnya] . "<br><i>[menunggu pembayaran upgrade ke $tstrata[$statussekarang]]</i>";
		else
			return "-";

	}

	public function modul($linklist = null, $opsi = null)
	{
		if (isset($_GET['tanggal']))
		$tanggal = $_GET['tanggal'];
		else
		$tanggal = null;

		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}

		setcookie('basis', "modul", time() + (86400), '/');
		$id_user = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];

		if ($this->session->userdata('verifikator') == 3) {
			$data = array();
			$data['konten'] = 'virtual_kelas_modul_ver';
			$data['dafpaket'] = $this->M_vksekolah->getPaketSekolah($npsn);

			// echo $npsn;
			// echo "<pre>";
			// echo var_dump($data['dafpaket']);
			// echo "</pre>";

			$this->load->view('layout/wrapper_tabel', $data);
		} else if ($this->session->userdata('sebagai') == 1) {
			$data = array();
			$this->load->Model('M_login');
			$user = $this->M_login->getUser($id_user);
			$data['referrer'] = $user['referrer'];
			$data['konten'] = 'virtual_kelas_modul_guru';
			$data['krs'] = $this->M_vksekolah->getSetingKRS($npsn, $prodi);
			$data['dafpaket'] = $this->M_vksekolah->getPaketGuru($id_user);
			// echo "<pre>";
			// echo var_dump($data['dafpaket']);
			// echo "</pre>";
			$this->load->view('layout/wrapper_tabel', $data);
		} else if ($this->session->userdata('sebagai') == 2) {
			$cekmapelmodul = $this->M_vksekolah->getModulMapel($npsn);
			$jmlmapel = count($cekmapelmodul);
			$cekmoduluser = $this->M_vksekolah->cekModulPilihan($id_user);
			$jmlmapelpilihan = count($cekmoduluser);

			$this->modul_siswa($linklist, $opsi, $tanggal);

			// echo "CEK84734".$tanggal;
			// if ($jmlmapelpilihan == $jmlmapel) {
			// } else {
			// 	$this->pilih_modul();
			// }
		}
	}

	public function modul_semua()
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}

		$id_user = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');

		$data = array();
		$data['konten'] = 'virtual_kelas_modul_siswa_all';
		$ambilmodul = $this->M_vksekolah->getDafModulSayaSemua($id_user);
		$data['dafpaket'] = $ambilmodul;

		// echo var_dump($data['dafpaket']);
		// die();

		$this->load->view('layout/wrapper_tabel', $data);

	}


	private function modul_siswa($linklist, $opsi = null, $tanggal = null)
	{

		if ($linklist == null)
			redirect("/");

		$data = array();

		$getstatusbelivk = getstatusbelivk(1);
		$statusvksaya = $getstatusbelivk['status_vk_sekarang'];
		$ceksekolahpremium = ceksekolahpremium();
		$statusvksekolah = $ceksekolahpremium['status_sekolah'];

		// echo "1:".$statusvksaya;
		// echo "<br>2:".$statusvksekolah;
		// die();

		$id_user = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$jenis = 1;

		$data['ambilpaket'] = $statusvksaya;
		if ($statusvksaya == "Premium" || $statusvksekolah == "Premium")
			$data['ambilpaket'] = "premium";
		else if ($statusvksaya == "Pro" || $statusvksekolah == "Pro")
			$data['ambilpaket'] = "pro";

		// echo $data['ambilpaket'];
		// die();

		$cekmodulsaya = $this->M_vksekolah->getModulSaya($linklist);
		if ($cekmodulsaya)
		{
			$stratamodul = substr($kodepaket,4,1);
			if ($stratamodul==1)
				$data['ambilpaket'] = "Lite";
			else if ($stratamodul==2)
				$data['ambilpaket'] = "pro";
			else if ($stratamodul==3)
				$data['ambilpaket'] = "premium";
			$data['modullaluke'] = $cekmodulsaya->modulke;
		}
		else if ($npsn=="001007")
		{
			$data['ambilpaket'] = "premium";
		}
		else if ($data['ambilpaket']!="Lite")
			redirect("/virtualkelas/sekolah_saya");

		$cekmodul = hitungmodulke($tanggal);

		// echo "CEK1456".$tanggal;
		$modulke = $cekmodul['nmodul'];
		$mingguke = $cekmodul['nminggu'];
		$semester = $cekmodul['semester'];

		$data['konten'] = 'virtual_kelas_channel_siswa';
		$dafmodul = $this->M_vksekolah->getDafModulSaya($id_user, $modulke, $linklist, $semester);
		// echo var_dump($dafmodul);
		$data['dafplaylist'] = $dafmodul;
		$data['modulke'] = $modulke;
		$data['mingguke'] = $mingguke;
		$data['opsi'] = $opsi;

		$cekbukamateri = $this->M_vksekolah->getStatusModulSaya($id_user, $modulke, $linklist);
		if ($cekbukamateri)
			$data['bukamateri'] = "sudah";
		else
			$data['bukamateri'] = "belum";

		$data['nilaiuser'] = 0;
		if ($linklist != null)
			$nilaiuser = $this->M_vksekolah->ceknilai($linklist, $id_user);
		$data['nilaiuser'] = $nilaiuser;

		$data['tugasguru'] = 0;
		if ($linklist != null)
			$tugasguru = $this->M_vksekolah->getTugas($jenis, $linklist);
		$data['tugasguru'] = $tugasguru;

		if ($tugasguru)
			$idtugasguru = $tugasguru->id_tugas;
		else
			$idtugasguru = 0;

		$tugassiswa = $this->M_vksekolah->getTugasSiswa($idtugasguru, $id_user);
		if (!$tugassiswa) {
			$isi = array(
				'id_tugas' => $idtugasguru,
				'id_user' => $id_user,
			);
			$this->M_vksekolah->addTugasSiswa($isi);
			$tugassiswa = $this->M_vksekolah->getTugasSiswa($idtugasguru, $id_user);
		}
		$data['tugassiswa'] = $tugassiswa;

//		 echo "<pre>";
//		 echo var_dump ($tugasguru);
//		 echo "</pre>";
//		 die();

		$data['dafstatus'] = true;
		$data['npsn'] = "saya";
		$data['playlist'] = $this->M_vksekolah->getPlayListSekolah($linklist, $id_user);
		$data['id_playlist'] = $linklist;
		$this->load->Model('M_channel');
		$data['datapesan'] = $this->M_channel->getChat("sekolah", $npsn);
		$data['namasekolah'] = "";
		$data['idku'] = $this->session->userdata('id_user');
		$data['jenis'] = "sekolah";

//		echo "<pre>";
//		echo var_dump ($data['playlist']);
//		echo "</pre>";
//		die();
//
//		echo "a121";
//		die();

		////////// UNTUK JITSI ///////////
		if (!$dafmodul[0])
			redirect("/");
		$idkontributor = $dafmodul[0]->id_user;
		$data['nama_paket'] = $dafmodul[0]->nama_paket;
		$data['koderoom'] = "";
		$tglkode = substr($dafmodul[0]->tglkode, 0);
		$tglvicon = substr($dafmodul[0]->tglvicon, 0, 10);
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $datesekarang->format('Y-m-d');
		$tglsekarangfull = $datesekarang->format('Y-m-d H:i:s');

		if ($id_user == $idkontributor) {
			$data['statusvicon'] = "moderator";
			if ($tglsekarang == $tglkode && $dafmodul[0]->koderoom != "") {
				$data['koderoom'] = $dafmodul[0]->koderoom;
				if (strtotime($tglsekarangfull) <= strtotime($tglvicon))
					$data['koderoom'] = "";
			} else {
				$set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$code = substr(str_shuffle($set), 0, 10);
				$code2 = substr(str_shuffle($set), 0, 10);
				$data2 = array('koderoom' => $code,
					'kodepassvicon' => $code2,
					'tglkode' => $tglsekarangfull);
				if ($jenis == 3)
					$this->M_channel->updateDurasiBimbel($linklist, $data2);
				else
					$this->M_channel->updateDurasiPaket($linklist, $data2);
				$data['koderoom'] = $code;
			}
		} else {
			$data['statusvicon'] = "siswa";
//			echo $tglsekarang;
//			echo "---";
//			echo $tglkode;
//			echo "---";
//			echo $tglvicon;
			if (substr($tglsekarang, 0, 10) == substr($tglkode, 0, 10)) {
				$data['koderoom'] = $dafmodul[0]->koderoom;
				if (substr($tglsekarang, 0, 10) != substr($tglvicon, 0, 10))
					$data['koderoom'] = "";
			}
		}

		//$data['jenis'] = $jenis;
		$data['kodelink'] = $linklist;

		$this->session->set_userdata('asalpaket', 'channel');
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function modul_aktif_guru($linklist, $opsi = null)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		$id_user = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$jenis = 1;

		$cekmodul = hitungmodulke();
		$modulke = $cekmodul['nmodul'];
		$mingguke = $cekmodul['nminggu'];

		$data = array();

		$data['konten'] = 'virtual_kelas_channel_aktif_guru';
		$dafmodul = $this->M_vksekolah->getDafModulGuru($linklist);
		$data['dafplaylist'] = $dafmodul;
		$data['modulke'] = $modulke;
		$data['mingguke'] = $mingguke;

//		 echo "<pre>";
//		 echo var_dump ($dafmodul);
//		 echo "</pre>";
//		 die();

		$data['dafstatus'] = true;
		$data['npsn'] = "saya";
		$data['playlist'] = $this->M_vksekolah->getPlayListSekolah($linklist, $id_user);
		$data['id_playlist'] = $linklist;
		$this->load->Model('M_channel');
		$data['datapesan'] = $this->M_channel->getChat("sekolah", $npsn, $linklist);
		$data['namasekolah'] = "";
		$data['idku'] = $this->session->userdata('id_user');
		$data['jenis'] = "sekolah";
		$data['opsi'] = $opsi;

		////////// UNTUK JITSI ///////////
		$data['koderoom'] = "";
		$idkontributor = 0;
		$data['nama_paket'] = "";
		$tglkode = "2021-01-01 00:00:00";
		$tglvicon = "2021-01-01 00:00:00";

		if ($dafmodul) {
			$idkontributor = $dafmodul[0]->id_user;
			$data['nama_paket'] = $dafmodul[0]->nama_paket;
			$tglkode = substr($dafmodul[0]->tglkode, 0, 10);
			$tglvicon = substr($dafmodul[0]->tglvicon, 0);
		}
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $datesekarang->format('Y-m-d');
		$tglsekarangfull = $datesekarang->format('Y-m-d H:i:s');

		if ($id_user == $idkontributor) {
			$data['statusvicon'] = "moderator";
			if ($tglsekarang == $tglkode && $dafmodul[0]->koderoom != "") {
				$data['koderoom'] = $dafmodul[0]->koderoom;
				if (strtotime($tglsekarangfull) <= strtotime($tglvicon))
					$data['koderoom'] = "";

			} else {
				$set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$code = substr(str_shuffle($set), 0, 10);
				$code2 = substr(str_shuffle($set), 0, 10);
				$data2 = array('koderoom' => $code,
					'kodepassvicon' => $code2,
					'tglkode' => $tglsekarangfull);
				if ($jenis == 3)
					$this->M_channel->updateDurasiBimbel($linklist, $data2);
				else
					$this->M_channel->updateDurasiPaket($linklist, $data2);
				$data['koderoom'] = $code;
			}
		} else {
			$data['statusvicon'] = "siswa";
//			echo $tglsekarang;
////			echo "---";
////			echo $tglkode;
			if ($tglsekarang == $tglkode) {
				$data['koderoom'] = $dafmodul[0]->koderoom;
			}
		}

		//$data['jenis'] = $jenis;
		$data['kodelink'] = $linklist;
		$data['tglvicon'] = $tglvicon;

		$this->session->set_userdata('asalpaket', 'channel');
		$this->load->view('layout/wrapper_umum', $data);
	}

	private function cekstatuspembelian($npsn)
	{
		if ($this->session->userdata('loggedIn')) {
			$id_user = $this->session->userdata("id_user");

			$tunggubayar = false;

			if ($npsn == "saya" || $npsn == $this->session->userdata('npsn')) {
				$npsn == $this->session->userdata('npsn');
				$jenis = 1;
			} else
				$jenis = 2;
			$strstrata = array("0", "lite", "pro", "premium");
			$tglbatas = new DateTime("2020-01-01 00:00:00");
			$kodebeliakhir = "";

			$kodebeli = "belumpunya";
			$tstrata = "0";
			$expired = true;

			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $jenis);

			if ($cekbeli) {

				$statusbayar = $cekbeli->status_beli;
				$datesekarang = new DateTime();
				$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

				$tanggalorder = new DateTime($cekbeli->tgl_beli);
				$batasorder = new DateTime($cekbeli->tgl_beli);
				$tglbatas = new DateTime($cekbeli->tgl_batas);

				$bulanorder = $tanggalorder->format('m');
				$tahunorder = $tanggalorder->format('Y');

				$tanggal = $datesekarang->format('d');
				$bulan = $datesekarang->format('m');
				$tahun = $datesekarang->format('Y');

				$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

				if ($statusbayar == 2) {
					if ($datesekarang <= $tglbatas) {
						$tstrata = $strstrata[$cekbeli->strata_paket];
						$kodebeli = $cekbeli->kode_beli;
						$expired = false;
					} else {
						$datax = array("status_beli" => 0);
						//$this->M_vksekolah->update_vk_beli($datax, $id_user, $cekbeli->kode_beli);
					}
				} else {
					if ($statusbayar == 1) {
						$ceksebelumnya = $this->M_channel->getlast_kdbeli($id_user, $jenis, 2);
						if ($ceksebelumnya) {
							$statusbayarsebelumnya = $ceksebelumnya->status_beli;
							if ($statusbayarsebelumnya == 2) {
								$tglbatassebelum = new DateTime($ceksebelumnya->tgl_batas);
								if ($datesekarang <= $tglbatas) {
									$tstrata = $strstrata[$ceksebelumnya->strata_paket];
									$kodebeliakhir = $ceksebelumnya->kode_beli;
									$expired = false;
								} else {
									$datax = array("status_beli" => 0);
									$this->M_vksekolah->update_vk_beli($datax, $id_user, $cekbeli->kode_beli);
								}
							}
						}
						$batasorder = $batasorder->add(new DateInterval('P1D'));
						if ($datesekarang > $batasorder) {
							$datax = array("status_beli" => 0);
							$this->M_vksekolah->update_vk_beli($datax, $id_user, $cekbeli->kode_beli);
						} else {
							$tunggubayar = true;
						}
					}
				}
			} else {
				$cekpremiumsekolah = $this->cekpembayaransekolah($this->session->userdata('npsn'));
				if (substr($cekpremiumsekolah, 0, 2) == "TP") {
					$statuspremiumsekolah = "pro";
					echo "Premium";
					die();
				} else if (substr($cekpremiumsekolah, 0, 2) == "TF") {
					$statuspremiumsekolah = "premium";
					echo "Full Premium";
					die();
				} else {
					$kodebeli = "belumpunya";
					redirect("virtualkelas/pilih_paket/saya");
				}
				$tstrata = "0";
				$expired = true;
			}
		} else {
			redirect("/");
		}

		return $tstrata;
	}

	public function tambahmodul($testanggal=null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}

		$statususer = getstatususer();
		$referrer = $statususer['referrer'];

		date_default_timezone_set('Asia/Jakarta');

		$namabulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September','Oktober', 'November', 'Desember');

		if ($testanggal==null)
			$sekarang = new DateTime();
		else
			$sekarang = new DateTime($testanggal);

		$tglpaket = $sekarang->format("Y-m-d H:i");
		$tahun = $sekarang->format("Y");

		
		$data = array();

		if (intval(substr($tglpaket,5,2))>=6)
		$semestermodul = 1;
		else
		$semestermodul = 2;

		$npsn = $this->session->userdata('npsn');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];
		
		$getdaftarmodul = $this->M_vksekolah->getDafModul($semestermodul);
		$data['datakrs'] = $this->M_vksekolah->getSetingKRS($npsn,$prodi);
		$data['dafmodul'] = $getdaftarmodul;
		$data['semestermodul'] = $semestermodul;
		$data['konten'] = "virtual_kelas_tambahmodul";
		$data['addedit'] = "add";
		$this->load->Model('M_video');
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['dafmapel'] = $this->M_video->getMatkul($this->session->userdata('id_user'));
		// echo var_dump($data['dafmapel']);
		$data['sudahdibeli'] = 0;

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function tambahujian()
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}

		$data = array();
		$data['konten'] = "virtual_kelas_tambahujian";
		$data['addedit'] = "add";
		$this->load->Model('M_video');
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['dafmapel'] = $this->M_video->getMatkul($this->session->userdata('id_user'));

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function buatujian()
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}

		if ($_POST['paket'] == 1)
			$namapaket = "UTS";
		else if ($_POST['paket'] == 2)
			$namapaket = "UAS";
		else if ($_POST['paket'] == 3)
			$namapaket = "REMEDIAL UTS";
		else if ($_POST['paket'] == 4)
			$namapaket = "REMEDIAL UAS";

		$data = array();
		$data['nama_paket'] = $namapaket;
		$data['id_jenjang'] = $_POST['jenjang'];
		$data['id_kelas'] = $_POST['kelas'];
		$data['id_mapel'] = $_POST['mapel'];
		$data['semester'] = $_POST['semester'];

		//$data = array('nama_paket'=>'REMEDIAL UAS', 'id_jenjang'=>3, 'id_kelas'=>9, 'id_mapel'=>5, 'semester'=>1);

		$hasil = $this->M_vksekolah->cekmodulujian($data);

		if ($hasil)
			echo "ada";
		else
			echo "aman";
	}

	public function pilih_modul()
	{
		if ($this->session->userdata('sebagai') == 2) {
			$data = array();
			$data['konten'] = 'virtual_kelas_pilih_modul';
			$id_user = $this->session->userdata('id_user');
			$npsn = $this->session->userdata('npsn');
			$this->load->Model('M_login');
			$getuser = getstatususer();
			$prodi = $getuser['kelasku'];
			$data['dafmapel'] = $this->M_vksekolah->getModulAda($npsn, $id_user, $prodi);

			// echo "<pre>";
			// echo var_dump($data['dafmapel']);
			// echo "</pre>";

			$cekmodul = hitungmodulke();
			$nmodul = $cekmodul['nmodul'];
			$data['modulke'] = $nmodul;

//			echo "<pre>";
//			echo var_dump($data['dafmapel']);
//			echo "</pre>";

			$this->load->view('layout/wrapper_tabel', $data);
		}
	}

	public function editmodul($kodepaket = null, $bulan = null, $tahun = null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}

		$data = array();

		$npsn = $this->session->userdata('npsn');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];
		
		$data['datakrs'] = $this->M_vksekolah->getSetingKRS($npsn,$prodi);

		$data['konten'] = 'virtual_kelas_tambahmodul';

		$data['addedit'] = "edit";

		$statususer = getstatususer();
		$referrer = $statususer['referrer'];

		$this->load->model('M_channel');
		$ambildatapaket = $this->M_channel->getInfoPaket($kodepaket);

		if ($ambildatapaket)
			$data['datapaket'] = $ambildatapaket;
		else
			redirect('/virtualkelas/modul');

		$data['kodepaket'] = $kodepaket;
		$data['referrer'] = $referrer;
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$idjenjang = $data['datapaket']->id_jenjang;
		$this->load->model('M_bimbel');
		$this->load->model('M_video');
		$data['dafmapel'] = $this->M_video->getMatkul($this->session->userdata('id_user'));

		///////////////////////////////

		$semestermodul = $data['datapaket']->semester;
		
		$getdaftarmodul = $this->M_vksekolah->getDafModul($semestermodul);
		// echo var_dump($getdaftarmodul);
		$data['dafmodul'] = $getdaftarmodul;
		
		$cekbelimodul = $this->M_channel->getmodultb_virtual($kodepaket);
	
		if(sizeOf($cekbelimodul)>0)
			$data['sudahdibeli'] = 1;
		else
			$data['sudahdibeli'] = 0;

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function addmodul($bulan=null, $tahun=null)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}

		$data = array();
		$data['nama_paket'] = $_POST['ipaket'];
		$data['modulke'] = $_POST['imingguke'];
		$data['semester'] = $_POST['isemester'];
		$data['id_mapel'] = $_POST['imapel'];

		$this->load->model('M_channel');

		/////////////////// MAPEL BARU
		if ($data['id_mapel']=="baru")
		{
			$getuser = getstatususer();
			$npsn = $this->session->userdata('npsn');
			$kd_prodi = $getuser['kelasku'];
			$namamatkulbaru = $_POST['imatkulbaru'];
			$datamatkul['npsn_sekolah']=$npsn;
			$datamatkul['kd_prodi']=$kd_prodi;
			$datamatkul['nama_mapel']=$namamatkulbaru;
			$datamatkul['kd_user']=$this->session->userdata('id_user');
			$mikro = str_replace(".", "", microtime(false));
			$mikro = str_replace(" ", "", $mikro);
			$mikro = base_convert($mikro, 10, 36);
			$datamatkul['kode_mapel'] = "mk_".$mikro;

			$idmapelbaru = $this->M_channel->addMatkulBaru($datamatkul);
			$data['id_mapel'] = $idmapelbaru;
		}

		$tgtyg = $_POST['datetime'];
		if ($tgtyg != "")
			$data['tanggal_tayang'] = $tgtyg;

		

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
			if ($tahun!=null)
				redirect('virtualkelas/videomodul/' . $data['link_list'].'/'.$bulan.'/'.$tahun);
			else
				redirect('virtualkelas/videomodul/' . $data['link_list']);
		} else {
			$link_list = $_POST['linklist'];
			$this->M_channel->updatePlaylist($link_list, $data);
			if ($tahun!=null)
				redirect('virtualkelas/videomodul/' . $link_list.'/'.$bulan.'/'.$tahun);
			else
				redirect('virtualkelas/videomodul/' . $link_list);
				
		}
	}

	public function editujian($kodepaket = null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}

		setcookie('basis', "modul", time() + (86400), '/');

		$data = array();
		$data['konten'] = 'virtual_kelas_tambahujian';

		$data['addedit'] = "edit";

		$this->load->model('M_channel');
		$data['datapaket'] = $this->M_channel->getInfoPaket($kodepaket);
		$data['kodepaket'] = $kodepaket;
		$this->load->model('M_video');
		$data['dafmapel'] = $this->M_video->getMatkul($this->session->userdata('id_user'));

		$idjenjang = $data['datapaket']->id_jenjang;
		$this->load->model('M_bimbel');

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function addujian()
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		$data = array();
		$data['semester'] = $_POST['isemester'];
		$data['id_mapel'] = $_POST['imapel'];
		if ($_POST['ipaket'] == "1") {
			$data['nama_paket'] = "UTS";
			$data['modulke'] = 17;
		} else if ($_POST['ipaket'] == "2") {
			$data['nama_paket'] = "UAS";
			$data['modulke'] = 19;
		} else if ($_POST['ipaket'] == "3") {
			$data['nama_paket'] = "REMEDIAL UTS";
			$data['modulke'] = 18;
		} else if ($_POST['ipaket'] == "4") {
			$data['nama_paket'] = "REMEDIAL UAS";
			$data['modulke'] = 20;
		}

		//////////////// MATKUL BARU ------------------------------
		if ($data['id_mapel']=="baru")
		{
			$getuser = getstatususer();
			$npsn = $this->session->userdata('npsn');
			$kd_prodi = $getuser['kelasku'];
			$namamatkulbaru = $_POST['imatkulbaru'];
			$datamatkul['npsn_sekolah']=$npsn;
			$datamatkul['kd_prodi']=$kd_prodi;
			$datamatkul['nama_mapel']=$namamatkulbaru;
			$datamatkul['kd_user']=$this->session->userdata('id_user');
			$mikro = str_replace(".", "", microtime(false));
			$mikro = str_replace(" ", "", $mikro);
			$mikro = base_convert($mikro, 10, 36);
			$datamatkul['kode_mapel'] = "mk_".$mikro;
			$this->load->Model('M_channel');
			$idmapelbaru = $this->M_channel->addMatkulBaru($datamatkul);
			$data['id_mapel'] = $idmapelbaru;
		}

		/////////////---------------------------------------------

		$tgtyg = $_POST['datetime'];
		if ($tgtyg != "")
			$data['tanggal_tayang'] = $tgtyg;

		$this->load->model('M_channel');

		if ($_POST['addedit'] == "add") {
			$mikro = str_replace(".", "", microtime(false));
			$mikro = str_replace(" ", "", $mikro);
			$mikro = base_convert($mikro, 10, 36);
			$data['link_list'] = $mikro;
			$data['durasi_paket'] = '-';
			$data['status_paket'] = '2';
			$data['id_user'] = $this->session->userdata('id_user');
			$data['npsn_user'] = $this->session->userdata('npsn');
			$getuser = getstatususer();
			$prodi = $getuser['kelasku'];
			$data['kd_prodi_user'] = $prodi;
			$this->M_channel->addplaylist($data);
			redirect('virtualkelas/modul');
		} else {
			$link_list = $_POST['linklist'];
			$this->M_channel->updatePlaylist($link_list, $data);
			redirect('virtualkelas/modul');
		}
	}

	public function videomodul($kodepaket = null, $bulan = null, $tahun = null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}

		setcookie('basis', "vk-" . $kodepaket, time() + (86400), '/');

		$id_user = $this->session->userdata('id_user');
		$data = array();
		$data['konten'] = "virtual_kelas_inputvideo";
		if ($kodepaket != null) {
			$cekmodul = $this->M_vksekolah->cekModulbyLink($id_user, $kodepaket);
			$namapaket = $cekmodul->nama_paket;
			$modulkepaket = $cekmodul->modulke;
			$data['namapaket'] = $namapaket;
			if ($modulkepaket == 17 || $modulkepaket ==18 || $modulkepaket == 19 || $modulkepaket == 20) {
				if($tahun!=null)
					redirect("virtualkelas/soal/buat/" . $kodepaket . '/evm/'.$bulan.'/'.$tahun);
				else
					redirect("virtualkelas/soal/buat/" . $kodepaket);
			}
		} else {
			$data['namapaket'] = "";
		}
		$this->load->model('M_channel');

		$data['dafvideo'] = $this->M_channel->getVideoUser($id_user, $kodepaket);
		// echo var_dump($data['dafvideo']);
		
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$bulanev=$bulan-1;
		$tahunev=$tahun;
		if ($bulanev==0)
		{
			$bulanev=12;
			$tahunev=$tahunev-1;
		}
		$data['bulanevent']=$bulanev;
		$data['tahunevent']=$tahunev;

//		echo "<br><br><br><br><br><br><br><br><pre>";
//		echo var_dump($data['dafvideo']);
//		echo "</pre>";

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$this->load->view('layout/wrapper_tabel', $data);

	}

	public function urutanmodul($kodepaket = null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}
		$data = array();
		$data['konten'] = "virtual_kelas_urutanmodul";

		$this->load->model('M_channel');
		$id_user = $this->session->userdata('id_user');
		$data['dafvideo'] = $this->M_channel->getVideoUserPaket($id_user, $kodepaket);

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$this->load->view('layout/wrapper_tabel', $data);

	}

	public function daftar_modul($kodeusr, $linklist = null)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
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
				if ($linklist != null)
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

	public function modul_guru($kodeusr, $linklist = null)
	{
		if (!$this->session->userdata('loggedIn') || $this->session->userdata('sebagai') == 2) {
			redirect("/");
		}
		if ($this->session->userdata('a02'))
			$cekuser = 2;
		else
			$cekuser = 2;
		$this->load->model('M_channel');
		$data = array();

		if ($this->session->userdata("loggedIn")) {
			$iduser = $this->session->userdata("id_user");

			if ($kodeusr == "saya")
				$kodeusr = "chusr" . $iduser;
			else if ($kodeusr == "verifikator") {
				if ($this->session->userdata("verifikator") != 3)
					redirect("/");
			}

		} else {
			$kodebeli = '-';
			$jenis = 0;
			$iduser = 0;
		}

		if ($linklist == null || $linklist == "tampilkan") {
			$data['konten'] = 'virtual_kelas_channel_guru';
			if ($kodeusr != "verifikator")
				$cekbeli = $this->M_channel->getlast_kdbeli($iduser, 1);
			else
				$cekbeli = false;
			$nilaiuser = 0;
		} else {
			redirect("/channel/guru/" . $kodeusr);
			$data['konten'] = 'v_channel_guru_pilih';
			$paketsoal = $this->M_channel->getPaket($linklist);
			$data['statussoal'] = $paketsoal[0]->statussoal;
			$data['pengunggah'] = $paketsoal[0]->first_name . " " . $paketsoal[0]->last_name;

			if ($this->session->userdata("loggedIn")) {
				//$iduser = $this->session->userdata("id_user");
				if ($paketsoal[0]->npsn_user == $this->session->userdata('npsn') || $kodeusr == "verifikator") {
					$jenis = 1;
				} else
					$jenis = 2;
				if ($linklist != null && $kodeusr != "verifikator")
					$nilaiuser = $this->M_channel->ceknilai($linklist, $iduser);

				if ($kodeusr != "verifikator")
					$cekbeli = $this->M_channel->getlast_kdbeli($iduser, $jenis);
				else
					$cekbeli = false;

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

		if ($kodeusr != "verifikator")
			{
				$data['dafplaylist'] = $this->M_channel->getDafPlayListSaya($kd_user, $iduser, $kodebeli, 1);
			}
		else
			{
				$data['dafplaylist'] = $this->M_channel->getDafPlayListGuru($this->session->userdata("npsn"), $iduser, $kodebeli, 1);
			}

		if (sizeof($data['dafplaylist']) == 0 && $linklist != "tampilkan")
			redirect("/virtualkelas/modul");

		// echo "<pre>";
		// echo var_dump ($data['dafplaylist']);
		// echo "</pre>";
		// die();

		if ($data['dafplaylist']) {
			$data['punyalist'] = true;
			$statusakhir = $data['dafplaylist'][0]->link_list;
			if ($linklist == null) {
				if ($kodeusr != "verifikator")
					$data['playlist'] = $this->M_channel->getPlayListSaya($kd_user, $statusakhir);
				else
					$data['playlist'] = $this->M_channel->getPlayListGuru($this->session->userdata("npsn"), $statusakhir);
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

	public function lihatmodul($opsi = null, $linklist = null, $linklistevent = null)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		$data = array();
		$data['konten'] = "virtual_kelas_lihat_modul";

		$this->load->Model('M_channel');
		$iduser = $this->session->userdata('id_user');
		$paketsoal = $this->M_channel->cekModul($opsi, $linklist);
		if ($opsi == "sekolah")
			$infopaket = $this->M_channel->getInfoPaket($linklist);
		else if ($opsi == "bimbel")
			$infopaket = $this->M_channel->getInfoBimbel($linklist);
		$idkontri = $infopaket->id_user;
		$npsnpaket = $infopaket->npsn_user;


		if ($idkontri != $iduser && $this->session->userdata('siam')!=3)
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
//		echo var_dump($data['dafplaylist']);
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

	public function materi($opsi = null, $linklist = null, $bulan = null, $tahun=null)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		$this->load->Model('M_channel');
		$data = array();
		if ($opsi == "buat") {
			$data['konten'] = "virtual_kelas_buatmateri";
			$paket = $this->M_channel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['uraian'] = $paket[0]->uraianmateri;
			$data['file'] = $paket[0]->filemateri;
			$data['linklist'] = $linklist;
		} else if ($opsi == "tampilkan") {
			$data['konten'] = "virtual_kelas_materi";
			$paket = $this->M_channel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['uraian'] = $paket[0]->uraianmateri;
			$data['file'] = $paket[0]->filemateri;
			$data['linklist'] = $linklist;
		}

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function tugas($npsn = null, $opsi = null, $linklist = null, $idsiswa = null, $bulan = null, $tahun = null)
	{

		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}

		$expired = true;
		if ($npsn == "saya") {
			$tipepaket = 1;
		} else {
			$tipepaket = 2;
		}

		$data = array();

		if ($opsi == "buat") {
			if ($idsiswa != null || ($this->session->userdata("a02") || $this->session->userdata("a03"))) {
				$expired = false;
			} else {
				$expired = true;
			}

			$data['konten'] = 'virtual_kelas_buattugas';
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
			$data['bulan'] = $bulan;
			$data['tahun'] = $tahun;


			if ($idsiswa != null && $idsiswa!= "evm") {
				$cekevent = $this->M_channel->cekevent_pl_guru($idsiswa);
				if ($cekevent) {

				} else
					redirect("/");
			}


		} else if ($opsi == "tampilkan") {
			if ($this->session->userdata("sebagai") == 1 || $this->session->userdata("siam") == 3 || get_cookie("basis") == "event") {
				$data['konten'] = 'virtual_kelas_tugas';
				$this->load->Model('M_channel');
				$paket = $this->M_channel->getTugas($tipepaket, $linklist);
				if (!$paket || $paket->tanyatxt == "")
				{
					if ($idsiswa=="evm")
						redirect(base_url() . "virtualkelas/tugas/saya/buat/" . $linklist.'evm/'.$bulan.'/'.$tahun);
					else
						redirect(base_url() . "virtualkelas/tugas/saya/buat/" . $linklist);
				}
					
				$iduser = $this->session->userdata('id_user');
				$getalluservk = $this->M_channel->getUserVK($tipepaket, $linklist, $paket->id_tugas);
				$getalltugassiswa = $this->M_channel->getTugasSiswa($paket->id_tugas, null, "semua");

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
				$data['dafuser'] = $getalltugassiswa;
				$data['uraian'] = $paket->tanyatxt;
				$data['file'] = $paket->tanyafile;
				$data['npsn'] = $npsn;
				$data['linklist'] = $linklist;
				$data['kodeevent'] = $idsiswa;
				$data['bulan'] = $bulan;
				$data['tahun'] = $tahun;

				if ($idsiswa != "tampil" && $idsiswa != "evm") {
					if ($idsiswa != null) {
						$cekevent = $this->M_channel->cekevent_pl_guru($idsiswa);
						if ($cekevent) {

						} else
							redirect("/");
					}
				}
			} else if ($this->session->userdata("sebagai") == 2) {
				$id_user = $this->session->userdata("id_user");
				$data['konten'] = 'virtual_kelas_tugas_siswa';
				$tugasguru = $this->M_vksekolah->getTugas($tipepaket, $linklist);
				$data['tugasguru'] = $tugasguru;
				$idtugasguru = $tugasguru->id_tugas;
				$tugassiswa = $this->M_vksekolah->getTugasSiswa($idtugasguru, $id_user);
				if (!$tugassiswa) {
					$isi = array(
						'id_tugas' => $idtugasguru,
						'id_user' => $id_user
					);
					$this->M_vksekolah->addTugasSiswa($isi);
					$tugassiswa = $this->M_vksekolah->getTugasSiswa($idtugasguru, $id_user);
				}
				$data['tugassiswa'] = $tugassiswa;
				$data['id_tugas'] = $idtugasguru;
				$data['npsn'] = $npsn;
				$data['linklist'] = $linklist;
			}

		} else if ($opsi == "jawabansaya") {
			if ($this->session->userdata("a02") || $this->session->userdata("a03")) {
				$expired = false;
			} else {
				if ($this->session->userdata('loggedIn')) {
					$id_user = $this->session->userdata("id_user");
					$this->load->Model('M_channel');
					$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $tipepaket);
					if ($cekbeli)
						$tglbatas = new DateTime($cekbeli->tgl_batas);
				} else {
					$id_user = 0;
				}

				$tgl_sekarang = new DateTime();
				$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

				if ($tgl_sekarang > $tglbatas) {
					$expired = true;
				} else {
					$expired = false;
				}
			}

			$data['konten'] = 'virtual_kelas_jawabansaya';
			$tugasguru = $this->M_vksekolah->getTugas($tipepaket, $linklist);
			$data['tugasguru'] = $tugasguru;
			$idtugasguru = $tugasguru->id_tugas;
			$tugassiswa = $this->M_vksekolah->getTugasSiswa($idtugasguru, $id_user);

			$data['tugassiswa'] = $tugassiswa;
			$data['id_tugas'] = $idtugasguru;
			$data['npsn'] = $npsn;
			$data['linklist'] = $linklist;
		} else if ($opsi == "penilaian") {
			if ($this->session->userdata("a02") || $this->session->userdata("a03")) {
				$expired = false;
			} else {
				$expired = true;
			}

			$data['konten'] = 'virtual_kelas_responguru';
			$tugasguru = $this->M_vksekolah->getTugas($tipepaket, $linklist);
			$data['tugasguru'] = $tugasguru;
			$idtugasguru = $tugasguru->id_tugas;

			$tugassiswa = $this->M_vksekolah->getTugasSiswa($idtugasguru, $idsiswa);

			$data['tugassiswa'] = $tugassiswa;
			$data['id_tugas'] = $idtugasguru;
			$data['npsn'] = $npsn;
			$data['linklist'] = $linklist;
		}

		if ($expired == false) {
			$this->load->view('layout/wrapper_umum', $data);
		} else {
			$this->load->view('layout/wrapper_umum', $data);
		}
	}

	public function soal($opsi = null, $linklist = null, $kodeevent = null, $bulan=null,$tahun=null)
	{

		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}

		$this->load->Model("M_channel");

		if ($kodeevent == "tampil" || $kodeevent == "evm" || $kodeevent == "owner") {

		} else {
			if ($kodeevent != null) {
				$cekevent = $this->M_channel->cekevent_pl_guru($kodeevent);
				if ($cekevent) {

				} else
					redirect("/");
			}
		}

		$data = array();

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$bulanev=$bulan-1;
		$tahunev=$tahun;
		if ($bulanev==0)
		{
			$bulanev=12;
			$tahunev=$tahunev-1;
		}
		$data['bulanevent']=$bulanev;
		$data['tahunevent']=$tahunev;

		if ($opsi == "tampilkan") {

			$data['konten'] = "virtual_kelas_soal";
			$paketsoal = $this->M_channel->getPaket($linklist);
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$data['judul'] = $paketsoal[0]->nama_paket;
			$data['kd_user'] = $paketsoal[0]->id_user;
			$data['dafsoal'] = $this->M_channel->getSoal($paketsoal[0]->id);
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $kodeevent;
			$data['asal'] = "owner";
			$this->load->view('layout/wrapper_umum', $data);
		} else if ($opsi == "buat") {
			$data['konten'] = 'virtual_kelas_buatsoal';
			$paket = $this->M_channel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['dafsoal'] = $this->M_channel->getSoal($paket[0]->id);
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $kodeevent;
			$data['asal'] = "owner";
			$this->load->view('layout/wrapper_tabel', $data);
		} else if ($opsi == "seting") {
			$data['konten'] = 'virtual_kelas_soal_seting';
			$paketsoal = $this->M_channel->getPaket($linklist);
			$data['paket'] = $paketsoal;
			$dafsoal = $this->M_channel->getSoal($paketsoal[0]->id);
			$data['totalsoal'] = sizeof($dafsoal);
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $kodeevent;
			$this->load->view('layout/wrapper_umum', $data);
		} else if ($opsi == "kerjakan") {
			$data['konten'] = 'virtual_kelas_soal_siswa';
			$paketsoal = $this->M_channel->getPaket($linklist);
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$data['judul'] = $paketsoal[0]->nama_paket;
			$data['tglujian'] = $paketsoal[0]->tglvicon;
			$data['kd_user'] = $paketsoal[0]->id_user;
			$data['dafsoal'] = $this->M_channel->getSoal($paketsoal[0]->id);
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $kodeevent;
			$data['asal'] = "menu";

			// $cekmodulsaya = $this->M_vksekolah->getModulSaya($linklist);
			// if (!$cekmodulsaya)
			// 	redirect("/virtualkelas/sekolah_saya");

			$sudahujian = 0;
			$siapujian = true;
			$ceknilai = $this->M_vksekolah->ceknilaisoal($this->session->userdata('id_user'), $linklist);
			if ($ceknilai && ($paketsoal[0]->nama_paket == "UAS" || $paketsoal[0]->nama_paket == "UTS" ||
					$paketsoal[0]->nama_paket == "REMEDIAL UTS" || $paketsoal[0]->nama_paket == "REMEDIAL UAS")) {
				$sudahujian = 1;
			}

			$data['sudahujian'] = $sudahujian;

			if ($paketsoal[0]->nama_paket == "UTS" || $paketsoal[0]->nama_paket == "UAS" ||
				$paketsoal[0]->nama_paket == "REMEDIAL UTS" || $paketsoal[0]->nama_paket == "REMEDIAL UAS") {
				$datesekarang = new DateTime("");
				$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
				$tglsekarang = $datesekarang->format("Y-m-d H:i:s");
				$tglujian = $paketsoal[0]->tglvicon;
				$jammulai = new DateTime($tglujian);
				$jammulai = $jammulai->modify("+" . $paketsoal[0]->durasi_paket . " minutes");
				$jammulai = $jammulai->format("Y-m-d H:i:s");
				$tglujian2 = $jammulai;
				$data['tglselesaiujian'] = $tglujian2;
				if (strtotime($tglsekarang) >= strtotime($tglujian) &&
					strtotime($tglsekarang) <= strtotime($tglujian2) && $tglujian != "2021-01-01 00:00:00") {
					$siapujian = true;
				} else {
					$siapujian = false;
				}
			}

//			echo "SIAP=".$siapujian;
//			echo "--SUDAH=".$sudahujian;

//			echo var_dump($ceknilai);

			if (!$siapujian || $sudahujian == 1) {
				$data['konten'] = 'virtual_kelas_sudah_ujian';
			}

			$data['sudahujian'] = $sudahujian;
			if ($ceknilai)
				$data['nilai'] = $ceknilai[0]->score;
			else
				$data['nilai'] = "-";

			$this->load->view('layout/wrapper_umum', $data);
		} else if ($opsi == "nilaisiswa") {
			if ($this->session->userdata("a02") || $this->session->userdata("a03")) {
				$expired = false;
			} else {
				$expired = true;
			}
			$data['konten'] = 'virtual_kelas_soal_jsiswa';
			$nilai = $this->M_channel->getNilaiSiswa($linklist);
			if (!$nilai)
				$nilai = null;
			$paket = $this->M_channel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['dafuser'] = $nilai;
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $kodeevent;
			$this->load->view('layout/wrapper_tabel', $data);
		} else if ($opsi == null) {
			redirect("/channel");
		} else if ($opsi != "tampilkan") {
			$data['konten'] = 'virtual_kelas_mulai';
			$paketsoal = $this->M_channel->getPaket($opsi);
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$dafsoal = $this->M_channel->getSoal($paketsoal[0]->id);
			$data['totalsoal'] = sizeof($dafsoal);
			$data['linklist'] = $opsi;
			$data['kodeevent'] = $kodeevent;
			$data['asal'] = $linklist;
			$this->load->view('layout/wrapper_tabel', $data);
		}


	}

	public function setjadwalvicon_modul($kodelink)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		$data = array();
		$data ['konten'] = 'virtual_kelas_setjadwalvicon';

		$this->load->Model('M_channel');
		$data['datapaket'] = $this->M_channel->getInfoPaket($kodelink);

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function savejadwalvicon_modul()
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}

		$linklist = $this->input->post('linklist');
		$tglvicon = $this->input->post('datetime') . ":00";
		$durasi = $this->input->post('durasiujian');

		$data = array();
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarangfull = $datesekarang->format('Y-m-d H:i:s');
		$set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 10);
		$code2 = substr(str_shuffle($set), 0, 10);
		$data['koderoom'] = $code;
		$data['kodepassvicon'] = $code2;
		$data['tglkode'] = $tglsekarangfull;

		if ($durasi)
			$data['durasi_paket'] = $durasi;

		$data['tglvicon'] = $tglvicon;
		$this->load->model('M_channel');
		$this->M_channel->updateDurasiPaket($linklist, $data);
		if (get_cookie('basis') == "modul")
			redirect("/virtualkelas/modul");
		else
			redirect("/virtualkelas/sekolah_saya");
	}

	public function updatemodulpilihan($idmapel, $idguru)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}

		$id_user = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');

		$this->load->Model('M_login');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];
		$this->load->Model('M_channel');
		$jmlmapelaktif = sizeof($this->M_channel->getDafPlayListMapel($npsn, $prodi));
		// echo "ca23131:".$jmlmapelaktif;
		// die();
		$this->load->Model('M_vksekolah');
		$jmlgurupilih = sizeof($this->M_vksekolah->cekGuruModul($id_user));

		// if ($pertemuanke>1 && $jmlmapelaktif==$jmlgurupilih)
		// 	redirect("/virtualkelas/pilih_modul");

		
		$cekPilihan = $this->M_vksekolah->cekModulPilihan($id_user, $npsn, $idmapel, $idguru);
		if ($cekPilihan) {
			// echo var_dump($cekPilihan);
			$this->M_vksekolah->updateModulPilihan($id_user, $npsn, $idmapel, $idguru);
		} else {
			// echo "ca48888:".$cekPilihan;
			$this->M_vksekolah->addModulPilihan($id_user, $npsn, $idmapel, $idguru);
		}
		// die();
		$this->cekmapelsudahdipilih();
		redirect("/virtualkelas/pilih_modul");
	}

	private function cekmapelsudahdipilih()
	{
		$tgl_sekarang=new DateTime();
		$bulanskr = $tgl_sekarang->format("n");
		$modulmana = moduldarike_bulan($bulanskr);

		$this->load->Model('M_channel');
		$cekbeli = $this->M_channel->getlast_kdbeli($this->session->userdata('id_user'), 1);
		if ($cekbeli)
			{
				$order_id = $cekbeli->kode_beli;
				$this->M_channel->hapus_vk_gurupilih($order_id);
				hitungfeevksekolah($order_id,$modulmana);
			}
	}

	public function setpassword($jenis, $kodelink)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		$idsaya = $this->session->userdata('id_user');
		$this->load->model('M_channel');
		$getpaket = $this->M_channel->getInfoBeliPaket($idsaya, $jenis, $kodelink);
		//echo "<br><br><br><br><br><br><br><br><br>";
		//echo var_dump($getpaket);
		if ($getpaket) {
			$idkontributor = $getpaket->id_kontri;
			$iduserbeli = $getpaket->id_user;
			$kodepassvicon = $getpaket->kodepassvicon;
			if ($idsaya == $idkontributor) {
				$data['statusvicon'] = "moderator";
			} else if ($idsaya == $iduserbeli) {
				$data['statusvicon'] = "siswa";
			}
			echo $kodepassvicon;
		} else {
			echo "outside";
		}
	}

	public function akhirivicon($linklist, $jenis)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		if ($this->session->userdata('sebagai') == 1) {
			$this->M_vksekolah->resettglvicon($linklist);
		}
		redirect(base_url() . "virtualkelas/sekolah_saya");
	}

	public function cekvicon($linklist = null)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		$id_user = $this->session->userdata('id_user');
		$cekmodul = hitungmodulke();

		$modulke = $cekmodul['nmodul'];
		$semester = $cekmodul['semester'];

		$dafmodul = $this->M_vksekolah->getDafModulSaya($id_user, $modulke, $linklist, $semester);
//		echo "<pre>";
//		echo var_dump($dafmodul);
//		echo "</pre>";
//		die();
		$koderoom = $dafmodul[0]->koderoom;
		$hasil = "on";
		if ($koderoom == "")
			$hasil = "off";
		echo json_encode($hasil);
	}

	public function nilai_saya()
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		if ($this->session->userdata('sebagai') == 2) {
			$data = array();
			$data['konten'] = 'virtual_kelas_nilai_siswa';
			$iduser = $this->session->userdata('id_user');
			$npsn = $this->session->userdata('npsn');

			$cekmodul = hitungmodulke();
			$nmodul = $cekmodul['nmodul'];
			$semester = $cekmodul['semester'];

			$nilailatihan = $this->M_vksekolah->getAllNilaiLatihan($iduser, $nmodul, $semester);

			$dafmapel = array();
			$dafnilai = array();
			$ratamodulke = array();
			$jml_mapel = 0;
			$totalnilai = 0;
			foreach ($nilailatihan as $datane) {
				if (!isset($ratamodulke[$datane->modulke]))
					$ratamodulke[$datane->modulke] = 0;
				$ratamodulke[$datane->modulke] = $ratamodulke[$datane->modulke] + $datane->highscore;
				if (in_array($datane->nama_mapel, $dafmapel)) {
					$dafnilai[$datane->nama_mapel][$datane->modulke] = $datane->highscore;
					continue;
				} else {
					$jml_mapel++;
					$dafmapel[] = $datane->nama_mapel;
					$dafnilai[$datane->nama_mapel][$datane->modulke] = $datane->highscore;
				}
			}

//			echo "<pre>";
//			echo var_dump($ratamodulke);
//			echo "</pre>";
//			die();

			$data['dafmapel'] = $dafmapel;
			$data['datanilai'] = $dafnilai;
			$data['totalnilaimodulke'] = $ratamodulke;
			if ($nmodul > 16)
				$nmodul = 16;
			$data['modulakhir'] = $nmodul;

			$this->load->view('layout/wrapper_tabel', $data);
		}
	}

	public function nilaitugas_saya()
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		if ($this->session->userdata('sebagai') == 2) {
			$data = array();
			$data['konten'] = 'virtual_kelas_nilaitugas_siswa';
			$iduser = $this->session->userdata('id_user');
			$npsn = $this->session->userdata('npsn');

			$cekmodul = hitungmodulke();
			$nmodul = $cekmodul['nmodul'];

			$nilaitugas = $this->M_vksekolah->getAllNilaiTugas($iduser);

//			echo "<pre>";
//			echo var_dump($nilaitugas);
//			echo "</pre>";
//			die();

			$dafmapel = array();
			$dafnilai = array();
			$jml_mapel = 0;
			foreach ($nilaitugas as $datane) {
				if (in_array($datane->nama_mapel, $dafmapel)) {
					$dafnilai[$datane->nama_mapel][$datane->modulke] = $datane->nilai;
					continue;
				} else {
					$jml_mapel++;
					$dafmapel[] = $datane->nama_mapel;
					$dafnilai[$datane->nama_mapel][$datane->modulke] = $datane->nilai;
				}
			}

//			echo "<pre>";
//			echo var_dump($ratamodulke);
//			echo "</pre>";
//			die();

			$data['dafmapel'] = $dafmapel;
			$data['datanilai'] = $dafnilai;
			if ($nmodul > 16)
				$nmodul = 16;
			$data['modulakhir'] = $nmodul;

			$this->load->view('layout/wrapper_tabel', $data);
		}
	}

	public function pilih_paket($npsn)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		$this->load->model('M_vksekolah');
		$data = array();
		$data['konten'] = "virtual_kelas_belipaket";

		$data['npsn'] = $npsn;

		$data['tvpremium'] = "";
		$data['total_adapaketreguler'] = 0;
		$data['total_adapaketpremium'] = 0;

		if ($npsn == "saya") {
			$npsn = $this->session->userdata('npsn');
			$jenis = 1;

			///////////////////// CEK JUMLAH PREMIUM ///////////////////
			$this->load->model("M_user");
			$cekuser = $this->M_user->getUserBeli($this->session->userdata('npsn'));
			$jmlbelipaketpro = 0;
			$jmlbelipaketpremium = 0;
			foreach ($cekuser as $rowdata) {
//				echo $rowdata->kode_beli."<br>";
				if ($rowdata->strata == 2)
					$jmlbelipaketpro++;
				else if ($rowdata->strata == 3)
					$jmlbelipaketpremium++;
			}
//			die();
			$data['total_adapaketreguler'] = $jmlbelipaketpro;
			$data['total_adapaketpremium'] = $jmlbelipaketpremium;

			$totalpaketgratis = $jmlbelipaketpro + $jmlbelipaketpremium;

			$this->load->model("M_payment");
			$cekpremium = $this->M_payment->cekpremium($this->session->userdata['npsn']);

//			echo "<pre>";
//			echo var_dump($cekpremium);
//			echo "</pre>";
//			die();

			if ($cekpremium) {
				$orderid = $cekpremium->order_id;
				if (substr($orderid, 0, 3) == "TP0")
					$data['tvpremium'] = "PROEB";
				else if (substr($orderid, 0, 3) == "TF0")
					$data['tvpremium'] = "PREMIUMEB";
				else if (substr($orderid, 0, 3) == "TP1" && $totalpaketgratis <= 100)
					$data['tvpremium'] = "PROEB2";
				else if (substr($orderid, 0, 3) == "TF1" && $totalpaketgratis <= 100)
					$data['tvpremium'] = "PREMIUMEB2";
				else if (substr($orderid, 0, 3) == "TP2" && $totalpaketgratis <= 100)
					$data['tvpremium'] = "PRO";
				else if (substr($orderid, 0, 3) == "TF2" && $totalpaketgratis <= 100)
					$data['tvpremium'] = "PREMIUM";
			}

			//////////////////////////////////////////////////////////////

		} else {
			$jenis = 2;
		}


		$iduser = $this->session->userdata('id_user');

		$this->load->model('M_channel');
		$cekstatusbayar = $this->M_channel->getlast_kdbeli($iduser, $jenis);

		$strstrata = array("", "lite", "pro", "premium");
		$data['tstrata'] = "";
		$datesekarang = new DateTime("");
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		if ($cekstatusbayar) {
			$statusbayar = $cekstatusbayar->status_beli;

			$tanggalorder = new DateTime($cekstatusbayar->tgl_beli);
			$batasorder = $tanggalorder->add(new DateInterval('P1D'));
			$bulanorder = $tanggalorder->format('m');
			$tahunorder = $tanggalorder->format('Y');

			$tanggal = $datesekarang->format('d');
			$bulan = $datesekarang->format('m');
			$tahun = $datesekarang->format('Y');

			$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

			if ($selisih == 0 && $statusbayar == 2) {
				$data['tstrata'] = $strstrata[$cekstatusbayar->strata_paket];
				//echo "AMANNNN";
			} else {
				if ($statusbayar == 1) {
					if ($datesekarang > $batasorder) {
						$datax = array("status_beli" => 0);
						$this->M_payment->update_vk_beli($datax, $iduser, $cekstatusbayar->kode_beli);
					} else {
						redirect("/payment/tunggubayarpaket/$jenis");
					}

				}
			}
		}

		if ($data['tvpremium'] != "") {
			$kodeprem = substr($data['tvpremium'], 0, 3);
			if ($kodeprem == "PRO")
				$data['tstrata'] = "pro";
			else if ($kodeprem == "PRE")
				$data['tstrata'] = "premium";
		}

		$this->load->Model('M_login');
		$datauser = $this->M_login->getUser($iduser);
		$idkelas = $datauser['kelas_user'];

		$this->load->Model('M_channel');
		$jmlmapelaktif = sizeof($this->M_channel->getDafPlayListMapel($npsn, $idkelas));
		$data['jmlmapelaktif'] = $jmlmapelaktif;

		$harga = $this->M_vksekolah->gethargapaket($npsn);
		if ($harga)
			$data['harga'] = $harga;
		else
			$data['harga'] = $this->M_vksekolah->gethargapaket("standar");
		$data['jenis'] = $jenis;

		$this->load->view('layout/wrapper_payment', $data);
	}


	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function sekolah_lain()
	{
		$data = array();
		$data['konten'] = "vk_dashboard_lain";
		$this->load->view('layout/wrapper_umum', $data);
	}


	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function bimbel($linklist = null, $tambah = null)
	{
		getstatususer();
		if ($linklist == null && (!$this->session->userdata('a03') && !$this->session->userdata('a02')
				&& $this->session->userdata('bimbel') != 3)) {
			redirect('/');
		}

		if ($this->session->userdata('sebagai') == 2 || $this->session->userdata('bimbel') <= 2) {
			redirect('/');
		}


		$this->load->model('M_channel');
		$data = array();
		$data['konten'] = 'bimbel_daftar_modul';

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

//		echo "<pre>";
//		echo var_dump($data['dafpaket']);
//		echo "</pre>";


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

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function tambahmodul_bimbel($linklist_event = null)
	{
		if ($linklist_event == null && (!$this->session->userdata('a03') && !$this->session->userdata('a02') && $this->session->userdata('bimbel') != 3)) {
			redirect('/');
		}
		$data = array();
		$data['konten'] = 'bimbel_tambahmodul';

		$this->load->Model('M_video');
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['addedit'] = "add";

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

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function addmodul_bimbel()
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
			redirect('virtualkelas/bimbel');
		else
			redirect('virtualkelas/bimbel/' . $linklist_event);
	}

	private function cekpembayaransekolah($npsn)
	{
		$this->load->Model('M_payment');
		$cekstatusbayar = $this->M_payment->getlastpaymentsekolah($npsn);

		if ($cekstatusbayar) {

			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

			$statusbayar = $cekstatusbayar->status;
			$orderid = $cekstatusbayar->order_id;

			$tanggalorder = new DateTime($cekstatusbayar->tgl_order);
			$batasorder = $tanggalorder->add(new DateInterval('P1D'));
			$bulanorder = $tanggalorder->format('m');
			$tahunorder = $tanggalorder->format('Y');

			$tanggal = $datesekarang->format('d');
			$bulan = $datesekarang->format('m');
			$tahun = $datesekarang->format('Y');

			$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

			if ($statusbayar == 4) {
				return $orderid;
			} else {
				if ($selisih >= 2) {
					return "zonk";
				} else if ($selisih == 1) {
					if ($tanggal <= 5) {
						return $orderid;
					} else {
						return "zonk";
					}
				} else {
					if ($statusbayar == 1) {
						return "zonk";
					} else if ($statusbayar == 3) {
						return $orderid;
					}
				}
			}
		} else {
			return "zonk";
		}
	}

	public function cekkodeevent()
	{
		$kodeevent = $this->input->post('kodeevent');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$referrer = $this->input->post('referrer');
		$cekkodeeventmentor = $this->M_vksekolah->cekKodeEventMentor($bulan, $tahun, $referrer);
		if ($cekkodeeventmentor)
			$kodeeventmentor = $cekkodeeventmentor->kode_event;
		else
			$kodeeventmentor = "tidak_ada_kode";
		$iduser = $this->session->userdata('id_user');

		// echo "REF". $referrer."<br>";
		// echo "BLN". $bulan."<br>";
		// echo "THN". $tahun."<br>";
		// echo "<pre>";
		// echo var_dump($cekkodeeventmentor);
		// echo "</pre>";
		
		if ($kodeeventmentor!=null && $kodeeventmentor==$kodeevent)
		{
			$dataadd = array('id_guru'=>$iduser,'bulan'=>$bulan,'tahun'=>$tahun,'kode_event'=>$kodeeventmentor);
			$this->M_vksekolah->addKodeEventSaya($dataadd);
			echo "oke";
		}
		else
		{
			echo "oops";
		}
		
	}

	// public function tambahkodeevent()
	// {
	// 	$kodeevent = $this->input->post('ikodeevent');
	// 	echo $kodeevent;
	// }

	public function tambah_modulevent()
	{
		$iduser = $this->session->userdata('id_user');
		$modulke = $this->input->post('modulke');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		if (intval($bulan)<=6)
			$semester = 2;
		else
			$semester = 1;
		
		$data = array();

		if ($modulke == "uts")
			{
				$modulke = 17;
				$data['nama_paket'] = 'UTS';
			}
		else if ($modulke == "remedial uts")
			{
				$modulke = 18;
				$data['nama_paket'] = 'REMEDIAL UTS';
			}
		else if ($modulke == "uas")
			{
				$modulke = 19;
				$data['nama_paket'] = 'UAS';
			}
		else if ($modulke == "remedial uas")
			{
				$modulke = 20;
				$data['nama_paket'] = 'REMEDIAL UAS';
			}

		$this->load->Model('M_channel');
		$cekmodul = $this->M_channel->cekpaket($modulke,$semester,$iduser);

		if ($cekmodul)
			echo $cekmodul->link_list;
		else 
		{
			
			$mikro = str_replace(".", "", microtime(false));
			$mikro = str_replace(" ", "", $mikro);
			$mikro = base_convert($mikro, 10, 36);
			$data['link_list'] = $mikro;
			if ($modulke<17)
				$data['durasi_paket'] = '00:00:00';
			else
				$data['durasi_paket'] = '-';
			$data['status_paket'] = '0';
			$data['semester'] = $semester;
			$data['modulke'] = $modulke;
			$data['id_kelas'] = 0;
			$data['id_mapel'] = 0;
			$data['id_user'] = $iduser;
			$data['npsn_user'] = $this->session->userdata('npsn');
			
			if ($this->M_channel->addplaylist($data))
				echo $mikro;
			else
				echo "gagal";
		}
	}

	public function playmentor($bulan,$tahun,$kodereferal)
	{
		$this->load->model('M_vod');
		$data = array();
		$data['konten'] = "vk_event_playvideo";
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$data['datavideo'] = $this->M_vksekolah->cekKodeEventMentor($bulan, $tahun, $kodereferal);
		
		// echo "<pre>";
		// echo var_dump ($data['datavideo']);
		// echo "</pre>"; 
		if (!$data['datavideo'])
		{
			redirect("/");
		}

		$this->load->view('layout/wrapper_umum', $data);
		
	}

	public function ceksertifikat($code,$iduser,$bulan,$tahun)
	{
		$data = array();
		$data['konten'] = 'v_event_ceksertifikat_mentor';
		
		$this->load->model('M_vksekolah');
		
		$data['sertifikat'] = $this->M_vksekolah->cekUserMentorEvent($code,$iduser,$bulan,$tahun);

		//echo var_dump($data['sertifikat']);

		$this->load->view('layout/wrapper_umum', $data);

	}

	public function getdafmodulke($semestermodul=null)
	{
		if ($semestermodul==null)
		$semestermodul = $_GET['semester'];

		$getdaftarmodul = array();

		$npsn = $this->session->userdata('npsn');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];
		$datakrs = $this->M_vksekolah->getSetingKRS($npsn,$prodi);

		for ($a0=1;$a0<=16;$a0++)
		{
			$a = $a0;
			if ($a>8)
			$a=$a0+2;

			$kd_modul[$a0] = $a;
			
			if ($semestermodul==1)
			$gettglmodul = hitungtanggalmodul($a,$semestermodul,$datakrs->start_tgl1,$datakrs->start_bln1);
			else
			$gettglmodul = hitungtanggalmodul($a,$semestermodul,$datakrs->start_tgl2,$datakrs->start_bln2);
			$keteranganmod = $gettglmodul['fulltgl'];

			$getdaftarmodul[] = "Modul ".$a0." [".$keteranganmod."]";
		}
		echo json_encode($getdaftarmodul);
	}

	public function getdafmodulke_old($semester=null)
	{
		$namabulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September','Oktober', 'November', 'Desember');

		if ($semester==null)
		$semester = $_GET['semester'];
		$sekarang = new DateTime();
		$tglpaket = $sekarang->format("Y-m-d H:i");
		$tahun = $sekarang->format("Y");

		$getdaftarmodul = array();
		$nmodul=0;

		if ($semester==1)
		{
			for ($a=8; $a<=12; $a++)
			{
				for ($b=1; $b<=3; $b++)
				{
					if (($a==10 && $b<=2) || ($a==12 && $b>2))
					{

					}
					else
					{
						$nmodul++;
						$getdaftarmodul[] = "Modul ".$nmodul." [".(1+($b-1)*7)." - ".(7+($b-1)*7)." ".$namabulan[$a]."]";
					}
				} 
				if ($a==12)
				{

				}
				else
				{
					$nmodul++;
					$tglhitung = new DateTime($tahun."-".($a)."-1");
					$tglakhir = $tglhitung->format("t");
					$getdaftarmodul[] = "Modul ".$nmodul." [22 - ".$tglakhir." ".$namabulan[$a]."]";
				}
			}
		}
		else
		{
			for ($a=2; $a<=6; $a++)
			{
				for ($b=1; $b<=3; $b++)
				{
					if (($a==4 && $b<=2) || ($a==6 && $b>2))
					{

					}
					else
					{
						$nmodul++;
						$getdaftarmodul[] = "Modul ".$nmodul." [".(1+($b-1)*7)." - ".(7+($b-1)*7)." ".$namabulan[$a]."]";
					}
				} 
				if ($a==6)
				{

				}
				else
				{
					$nmodul++;
					$tglhitung = new DateTime($tahun."-".($a)."-1");
					$tglakhir = $tglhitung->format("t");
					if ($a==2)
						$tglakhir = "28/29";
					$getdaftarmodul[] = "Modul ".$nmodul." [22 - ".$tglakhir." ".$namabulan[$a]."]";
				}
			}
		}

		echo json_encode($getdaftarmodul);
	}

	public function krs()
	{
		if (!$this->session->userdata('loggedIn'))
		redirect("/");
		$npsn = $this->session->userdata('npsn');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];

		$data = array();
		$data['konten'] = "jadwalkrs";
		$data['datakrs'] = $this->M_vksekolah->getSetingKRS($npsn,$prodi);

		// var_dump($data['datakrs']);

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function updatejadwalkrs($semester)
	{
		$npsn = $this->session->userdata('npsn');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];
		$tgl1 = $_POST['tgl1'];
		$tgl2 = $_POST['tgl2'];
		$tgl1format = substr($tgl1,6,4)."-".substr($tgl1,3,2)."-".substr($tgl1,0,2);
		$tgl2format = substr($tgl2,6,4)."-".substr($tgl2,3,2)."-".substr($tgl2,0,2);
		$update = $this->M_vksekolah->updatejadwalkrs($npsn,$prodi,$semester,$tgl1format,$tgl2format);
		if ($update)
			echo "sukses";
		else
			echo "gagal";
	}

	public function updatemulaikuliah($semester)
	{
		$npsn = $this->session->userdata('npsn');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];
		$tgl = $_POST['tglstart'];
		$bln = $_POST['blnstart'];
		$update = $this->M_vksekolah->updatemulaikuliah($npsn,$prodi,$semester,$tgl,$bln);
		if ($update)
			echo "sukses";
		else
			echo "gagal";
	}

	public function tesmodul()
	{
		hitungtanggalmodul(8,1,8,9,2022);
	}

}
