<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_marketing");
		$this->load->helper(array('video', 'tanggalan'));

		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}
		if ($this->session->userdata('a01') || $this->session->userdata('siam') > 0) {
			//
		} else {
			redirect('/');
		}

		$this->load->helper(array('Form', 'Cookie', 'download'));
		date_default_timezone_set("Asia/Jakarta");
	}

	public function index()
	{
		$data = array();
		$data['konten'] = 'v_marketing';

		$iduser = $this->session->userdata("id_user");
		$this->load->Model('M_login');
	
		$user = $this->M_login->getUser($iduser);

		$cekdata = $this->M_marketing->getlastmarketing($iduser);
//		echo var_dump($cekdata);
//		die();
		if ($cekdata)
			$data ['dafmarketing'] = $cekdata;
		else {
			$cekdata = $this->M_marketing->addmarketing($iduser);
			$data ['dafmarketing'] = $cekdata;
		}

		$data['daftaragensi'] = $this->M_marketing->getAgency($user['kd_kota']);
		$data['dafpropinsi'] = $this->M_login->dafpropinsi(1);
		$data['dafkota'] = $this->M_login->dafkota($user['kd_provinsi']);
		$data['propinsisaya'] = $user['kd_provinsi'];
		$data['kotasaya'] = $user['kd_kota'];

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function user()
	{
		$data = array('title' => 'Daftar Staf', 'menuaktif' => '11',
			'isi' => 'v_marketing_downline');

		$this->load->model("M_user");
		$data['dafuser'] = $this->M_user->getAllUser(2);
		$data['asal'] = "staf";
		$this->load->view('layout/wrapper', $data);
	}

	public function transaksi_kelasvirtual()
	{
		$data = array();
		$data['konten'] = 'v_marketing_transaksi';

		$idam = $this->session->userdata('id_user');
		$this->load->model("M_eksekusi");
		$hargastandar = $this->M_eksekusi->getStandar();
		$data['biayatarik'] = $hargastandar->biayatarik;
		$data['minimaltarik'] = $hargastandar->minimaltarik;
		$this->load->model("M_login");
		$data['getuserdata'] = $this->M_login->getUser($idam);
		$data['daftransaksi'] = $this->M_marketing->getTransaksi($idam);
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function transaksi_sekolah()
	{
		$data = array();
		$data['konten'] = 'v_marketing_transaksi_premium';

		$idam = $this->session->userdata('id_user');
		$this->load->model("M_login");
		$data['getuserdata'] = $this->M_login->getUser($idam);
		$data['daftransaksi'] = $this->M_marketing->getTransaksiPremium($idam);
		$this->load->model("M_payment");
		$standar = $this->M_payment->getstandar();
		$data['biayatarik'] = $standar->biayatarik;
		$data['minimaltarik'] = $standar->minimaltarik;
		$data['persenfeeam'] = $standar->fee_am;
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function daftar_ref()
	{
		$data = array();
		$data['konten'] = 'v_marketing_dafkode';

//		$this->load->model("M_login");
		$data['dafkode'] = $this->M_marketing->getDafKodeRef($this->session->userdata('id_user'));
		// echo "<pre>";
		// echo var_dump ($data['dafkode']);
		// echo "</pre>";
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function daftar_user($npsn)
	{
		$data = array();
		$data['konten'] = 'v_marketing_dafuser';

		$this->load->model("M_user");
		$getNamaSekolah = $this->M_user->getNamaSekolah($npsn);
		$data['namasekolah'] = $getNamaSekolah;
		$data['dafuser'] = $this->M_marketing->getDafUser($this->session->userdata('id_user'), $npsn);
//
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function daftar_modul($bulan=null, $tahun=null)
	{

		$idmarketing = $this->session->userdata('id_user');
		$data = array();
		$data['konten'] = 'v_marketing_dafmodul';

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		if ($bulan==null) {
			$bulan = $datesekarang->format("n");
			$tahun = $datesekarang->format("Y");
			$bulan = $bulan + 1;
			if ($bulan>12)
				{
					$bulan = 1;
					$tahun++;
				}
		}

		$data['bulan'] = $bulan;
		$data['blnskr'] = $datesekarang->format("n")+1;
		// $data['tahun'] = $tahun;

		
		// $modulmana = moduldarike_bulan($bulanbesok);
		// $moduldari = $modulmana['dari'];
		// $modulsampai = $modulmana['ke'];
		// $ujiandari = $modulmana['ujian1'];
		// $ujianke = $modulmana['ujian2'];
		// $semester = $modulmana['semester'];

		$cekgurumodul = $this->M_marketing->getDafUser($idmarketing);

		// echo "<pre>";
		// echo var_dump ($cekgurumodul);
		// echo "</pre>";
		// die();
		
		// $tgl_sekarang = new DateTime();
		// $bulanskr = $tgl_sekarang->format("n");
		$modulmana = moduldarike_bulan($bulan);
		$dari = $modulmana['dari'];
		$ke = $modulmana['ke'];
		$ujian1 = $modulmana['ujian1'];
		$ujian2 = $modulmana['ujian2'];
		$semester = $modulmana['semester'];

		$this->load->Model('M_vksekolah');
		$jmlmodulbulanini = 0;
		$daftarmodul = array();
		$baris=0;
		foreach ($cekgurumodul as $row) {
			$modulbulanini = $this->M_vksekolah->getSekolahModulPaketDariKe($dari, $ke, $semester, $row->id);
			foreach ($modulbulanini as $row2)
			{
				$daftarmodul[$baris][]=$row2;
				$baris++;
			}
			
		}

		foreach ($cekgurumodul as $row) {
			$modulbulanini = $this->M_vksekolah->getSekolahModulPaketDariKe($ujian1, $ujian2, $semester, $row->id);
			foreach ($modulbulanini as $row2)
			{
				$daftarmodul[$baris][]=$row2;
				$baris++;
			}
		}
		
		$data['dafmodul'] = $daftarmodul;
				
		// echo "<pre>";
		// echo var_dump ($data['dafmodul']);
		// echo "</pre>";
		// die();

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function daftar_event($bulan=null, $tahun=null)
	{
		$this->load->helper('Video');
		$idmarketing = $this->session->userdata('id_user');
		$data = array();
		$data['konten'] = 'v_marketing_dafevent';

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		if ($bulan==null) {
			$bulan = $datesekarang->format("n");
			$tahun = $datesekarang->format("Y");
		}

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$this->load->Model('M_marketing');
		$daftarmodul = $this->M_marketing->getDafEvent($bulan, $tahun);
		
		$data['dafmodul'] = $daftarmodul;
				
		// echo "<pre>";
		// echo var_dump ($data['dafmodul']);
		// echo "</pre>";
		// die();

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function daftar_event_ver($bulan=null, $tahun=null)
	{
		// $this->load->helper('Video');
		$idmarketing = $this->session->userdata('id_user');
		$data = array();
		$data['konten'] = 'v_marketing_dafevent_ver';

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		if ($bulan==null) {
			$bulan = $datesekarang->format("n");
			$tahun = $datesekarang->format("Y");
		}

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$this->load->Model('M_marketing');
		$daftarmodul = $this->M_marketing->getDafEventVer();
		
		$data['dafmodul'] = $daftarmodul;
				
		// echo "<pre>";
		// echo var_dump ($data['dafmodul']);
		// echo "</pre>";
		// die();

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function kode_referal($idmarketing)
	{
		$data = array();
		$data['konten'] = 'v_marketing_kode';

//		$this->load->model("M_login");
		$data['dataku'] = $this->M_marketing->getKodeRef($idmarketing);
//
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function ceksasaran()
	{
		$npsn = $this->input->post('npsn');
		if (!$this->M_marketing->ceksasaran($npsn))
			$this->getsekolahfull($npsn);
		else
		{
			$error = array('nama_sekolah' => 'nemu');
			echo json_encode($error);
		}

	}

	public function ceksasarandanrev()
	{
		$npsn = $this->input->post('npsn');
		$koderef = $this->input->post('koderef');
		if ($this->M_marketing->ceksasaran($npsn))
			$this->getsekolahfullRef($npsn, $koderef);
		else
		{
			$error = array('nama_sekolah' => 'gaknemu');
			echo json_encode($error);
		}

	}

	private function getsekolahfull($npsn)
	{
		$this->load->Model('M_login');
		$isi = $this->M_login->getsekolahfull($npsn);
		$error = array('nama_sekolah' => 'gaknemu');
		if ($isi)
		{
			$datasek2['idkota'] = $isi[0]->id_kota;
			$datasek2['npsn'] = $isi[0]->npsn;
			$datasek2['idjenjang'] = $isi[0]->id_jenjang;
			$datasek2['nama_sekolah'] = $isi[0]->nama_sekolah;
			$this->M_login->addchnsekolah($datasek2);
			echo json_encode($isi);
		}
		else
			echo json_encode($error);
	}

	private function getsekolahfullRef($npsn, $koderef, $bulan=null, $tahun=null)
	{
		$idmentor = $this->session->userdata('id_user');
		// $this->load->Model('M_login');
		$isi = $this->M_marketing->getsekolahfullRef($npsn, $idmentor, $bulan, $tahun);
		$error = array('nama_sekolah' => 'gaknemu');
		if ($isi)
		{
			$datasek2['idkota'] = $isi[0]->id_kota;
			$datasek2['npsn'] = $isi[0]->npsn;
			$datasek2['idjenjang'] = $isi[0]->id_jenjang;
			$datasek2['nama_sekolah'] = $isi[0]->nama_sekolah;
			$datasek2['koderef'] = $isi[0]->kode_referal;
			echo json_encode($isi);
		}
		else
			echo json_encode($error);
	}

	public function pilih_sekolah()
	{
		$id=$this->session->userdata('id_user');
		$npsn = $this->input->post('npsn');
		$siag = $this->input->post('siag');
		$set = '123456789abcdefghjkmnpqrstuvwxyz';
		$code = substr(str_shuffle($set), 0, 5);
		$koderef = $code . $id;

		$data['id_agency'] = $siag;
		$data['npsn_sekolah'] = $npsn;
		$data['kode_referal'] = $koderef;
		$data['status'] = 1;

		$this->M_marketing->updatemarketing($data, 0, $id);

		echo $koderef;
	}

	public function update_sekolahbaru()
	{
		$tglskr = new DateTime();
		$tglskr->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglskr = $tglskr->format("Y-m-d H:i:s");

		$datasek['id_kota'] = $this->input->post('ikota');
		$datasek['npsn'] = $this->input->post('npsn');
		$datasek['nama_sekolah'] = $this->input->post('isekolah');
		$datasek['alamat_sekolah'] = $this->input->post('ialamatsekolah');
		$datasek['kecamatan'] = $this->input->post('ikecamatansekolah');
		$datasek['desa'] = $this->input->post('idesasekolah');
		$datasek['id_jenjang'] = $this->input->post('ijenjangsekolah');
		$datasek['status'] = 1;

		$datasek2 = array();
		$datasek2['idkota'] = $this->input->post('ikota');
		$datasek2['npsn'] = $this->input->post('npsn');
		$datasek2['idjenjang'] = $this->input->post('ijenjangsekolah');
		$datasek2['nama_sekolah'] = $this->input->post('isekolah');

		$datasek3 = array();
		$iduser = $this->session->userdata('id_user');
		$set = '123456789abcdefghjkmnpqrstuvwxyz';
		$code = substr(str_shuffle($set), 0, 5);
		$koderef = $code . $iduser;

		$datasek3['id_agency'] = $this->input->post('siag');
		$datasek3['npsn_sekolah'] = $this->input->post('npsn');
		$datasek3['kode_referal'] = $koderef;
		$datasek3['status'] = 1;	

		// &&
		// ($this->session->userdata('siae') == 0 && $this->session->userdata('siam') == 0
		// 	&& $this->session->userdata('bimbel') == 0)
		if ($this->input->post('ikota') > 0) {
			$this->load->Model("M_login");
			$this->M_login->addsekolah($datasek);
			$this->M_login->addchnsekolah($datasek2);
			$this->M_marketing->updatemarketing($datasek3, 0, $iduser);
		}
	}

	public function terlaksana()
	{
		$id=$this->session->userdata('id_user');
		$data['status'] = 2;

		if ($this->M_marketing->updatemarketing($data, 1, $id))
			echo "berhasil";
		else
			echo "gagal";
	}

	public function lihatmodul($linklist,$bulan)
	{
		$data = array();
		$data['konten'] = 'marketing_lihatmodul';
		$data['bulan'] = $bulan;

		$datamodul = $this->M_marketing->getModulSekolah($linklist);

		// echo "<pre>";
		// echo var_dump($datamodul);
		// echo "</pre>";

		$data['dafplaylist'] = $datamodul;
		$kd_user = $datamodul->id_user;
		
		$this->load->Model('M_channel');
		$data['infoguru'] = $this->M_channel->getInfoGuru($kd_user);
		$data['dafvideo'] = $this->M_channel->getVodGuru($kd_user);

		$data['kd_user'] = $kd_user;
		$data['id_playlist'] = $linklist;

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function lihatmodulujian($linklist, $bulan)
	{
		$data = array();
		$data['konten'] = 'marketing_lihatmodulujian';
		$data['bulan'] = $bulan;
		
		$datamodul = $this->M_marketing->getModulSekolah($linklist,"ujian");

		$data['dafplaylist'] = $datamodul;
		$kd_user = $datamodul->id_user;
		
		$this->load->Model('M_channel');
		$data['infoguru'] = $this->M_channel->getInfoGuru($kd_user);
		$data['dafvideo'] = $this->M_channel->getVodGuru($kd_user);

		$data['kd_user'] = $kd_user;
		$data['id_playlist'] = $linklist;

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function update_periksa($linklist,$bulan)
	{
		$catatanmentor = $this->input->post('icatatan');
		$statusmentor = $this->input->post('pilihankonfirm');
		if ($this->M_marketing->updateperiksa($linklist,$statusmentor,$catatanmentor))
			{
				if ($bulan==null)
					redirect ("/marketing/daftar_modul");
				else
					redirect ("/marketing/daftar_modul/".$bulan);
			}
		else
		   echo "ERROR";
	}

	public function tambahevent($bulan=null, $tahun=null)
	{
		$data = array();
		$data['konten'] = 'v_marketing_event';
		
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		if($bulan==null)
		{
			$bulan = $datesekarang->format("n");
			$tahun = $datesekarang->format("Y");
		}

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;	

		$data['kodeevent'] = null;

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function editevent($kodeevent)
	{
		$data = array();
		$data['konten'] = 'v_marketing_event';
		
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$bulan = $datesekarang->format("n");
		$tahun = $datesekarang->format("Y");

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		
		$getdata = $this->M_marketing->getDafEventbyCode($kodeevent);
		if ($getdata)
			$data ['dafmarketing'] = $getdata;
		else {
			$data ['dafmarketing'] = null;
		}			

		$data['kodeevent'] = $kodeevent;

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function tambaheventver()
	{
		$data = array();
		$data['konten'] = 'v_marketing_event_ver';
		
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$tanggal = $datesekarang->format("j");
		$bulan = $datesekarang->format("n");
		$tahun = $datesekarang->format("Y");

		$this->load->Model('M_login');
		$iduser = $this->session->userdata("id_user");
		$user = $this->M_login->getUser($iduser);
		
		$data['idagsekarang'] = 1;
		$data['tanggal'] = $tanggal;
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['daftaragensi'] = $this->M_marketing->getAgency($user['kd_kota']);
		$data['judul'] = "";
		$data['jmlvideo'] = 3;
		$data['jmlplaylist'] = 1;
		$data['jmlkontri'] = 10;
		$data['jmlvideokontri'] = 10;
		$data['jmlekskul'] = 3;	
		$data['linkvideo'] = "";	

		$data['kodeevent'] = null;
		
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function editevent_ver($kodeevent)
	{
		$data = array();
		$data['konten'] = 'v_marketing_event_ver';

		$this->load->Model('M_login');
		$iduser = $this->session->userdata("id_user");
		$user = $this->M_login->getUser($iduser);

		$getdataevent = $this->M_marketing->getDafEventVer($kodeevent);	
		
		$data['idagsekarang'] = $getdataevent[0]->id_agency;
		$tanggalan = $getdataevent[0]->tgl_jalan;
		$data['tanggal'] = intval(substr($tanggalan,8,2));
		$data['bulan'] = intval(substr($tanggalan,5,2));
		$data['tahun'] = substr($tanggalan,0,4);
		$data['daftaragensi'] = $this->M_marketing->getAgency($user['kd_kota']);
		$data['judul'] = $getdataevent[0]->npsn_sekolah;
		$data['linkvideo'] = $getdataevent[0]->link_video;
		$data['channel'] = $getdataevent[0]->channel;
		$data['thumbs'] = $getdataevent[0]->thumbnail;
		$data['durjam'] = substr($getdataevent[0]->durasi,0,2);
		$data['durmenit'] = substr($getdataevent[0]->durasi,3,2);
		$data['durdetik'] = substr($getdataevent[0]->durasi,6,2);
		$data['jmlvideo'] = $getdataevent[0]->jml_video;
		$data['jmlplaylist'] = $getdataevent[0]->jml_playlist;
		$data['jmlkontri'] = $getdataevent[0]->jml_kontri;
		$data['jmlvideokontri'] = $getdataevent[0]->jml_video_kontri;
		$data['jmlekskul'] = $getdataevent[0]->jml_ekskul;

		$data['kodeevent'] = $kodeevent;
		
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function ceksasarandanrevdanbulan()
	{
		$npsn = $this->input->post('npsn');
		$koderef = $this->input->post('koderef');
		$bulan = $this->input->post('ibulan');
		$tahun = $this->input->post('itahun');

		// echo "BULAN".$bulan."<br>";
		// echo "TAHUN".$tahun."<br>";
		// echo "koderef".$koderef."<br>";

		if ($this->M_marketing->ceksasaran($npsn))
			$this->getsekolahfullRef($npsn, $koderef, $bulan, $tahun);
		else
		{
			$error = array('nama_sekolah' => 'gaknemu');
			echo json_encode($error);
		}

	}

	public function addevent()
	{
		
		$koderef = $this->input->post('kode_referal');
		$set = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$kodebaru = substr(str_shuffle($set), 0, 4);
		$kodeevent = $this->input->post('kodeevent');
		$jenisevent = 2;
		$bulan = $this->input->post('ibulan');
		$tahun = $this->input->post('itahun');
		$linkvideo = $this->input->post('ilink');
		$channel = $this->input->post('ichannel');
		$durjam = $this->input->post('idurjam');
		$durmenit = $this->input->post('idurmenit');
		$durdetik = $this->input->post('idurdetik');
		$durasi = $durjam.":".$durmenit.":".$durdetik;
		$thumbnail = $this->input->post('ytube_thumbnail');

		if ($kodeevent!=null)
		{
			$dataset["link_video"] = $linkvideo;
			$dataset["channel"] = $channel;
			$dataset['thumbnail'] = $thumbnail;
			$dataset['durasi'] = $durasi;
			
			$this->M_marketing->updateDataMentor($dataset, $koderef, $kodeevent);
		}
		else
		{
			// echo "ADD:".$koderef."-".$kodebaru."-".$bulan."-".$tahun;
			$dataset = array();
			$dataset["kode_referal"] = $koderef;
			$dataset["kode_event"] = $kodebaru;
			$dataset["jenis_event"] = 2;
			$dataset["bulan"] = $bulan;
			$dataset["tahun"] = $tahun;
			$dataset["link_video"] = $linkvideo;
			$dataset["channel"] = $channel;
			$dataset['thumbnail'] = $thumbnail;
			$dataset['durasi'] = $durasi;
			
			$this->M_marketing->addDataMentor($dataset);
		}

		redirect ("/marketing/daftar_event/".$bulan."/".$tahun);

		// if ($this->M_marketing->updateperiksa($linklist,$statusmentor,$catatanmentor))
		// 	{
		// 		if ($bulan==null)
		// 			redirect ("/marketing/daftar_modul");
		// 		else
		// 			
		// 	}
		// else
		//    echo "ERROR";
	}

	public function addeventver()
	{
		$iduser = $this->session->userdata('id_user');
		$set = '123456789abcdefghijklmnpqrstuvwxyz';
		$kodebaru = substr(str_shuffle($set), 0, 5).$iduser;
		

		$dataset1 = array();
		$dataset2 = array();
		
		$kodeevent = $this->input->post('kodeevent');

		$tanggal = $this->input->post('itanggal');
		$bulan = $this->input->post('ibulan');
		$tahun = $this->input->post('itahun');
		$tanggalevent = $tahun."-".$bulan."-".$tanggal." 00:00:00";

		$dataset1["tgl_jalan"] = $tanggalevent;
		$dataset1["id_agency"] = $this->input->post('isiag');
		$dataset1["npsn_sekolah"] = $this->input->post('ijudul');
		
		$dataset2['jml_video'] = $this->input->post('ijmlvideo');
		$dataset2['jml_playlist'] = $this->input->post('ijmlplaylist');
		$dataset2['jml_kontri'] = $this->input->post('ijmlkontri');
		$dataset2['jml_video_kontri'] = $this->input->post('ijmlvideokontri');
		$dataset2['jml_ekskul'] = $this->input->post('ijmlekskul');

		$linkvideo = $this->input->post('ilink');
		$channel = $this->input->post('ichannel');
		$durjam = $this->input->post('idurjam');
		$durmenit = $this->input->post('idurmenit');
		$durdetik = $this->input->post('idurdetik');
		$durasi = $durjam.":".$durmenit.":".$durdetik;
		$thumbnail = $this->input->post('ytube_thumbnail');
		$dataset2["link_video"] = $linkvideo;
		$dataset2["channel"] = $channel;
		$dataset2['thumbnail'] = $thumbnail;
		$dataset2['durasi'] = $durasi;

		if ($kodeevent!="")
		{
			$this->M_marketing->updateMarketingCalver($dataset1, $kodeevent);
			$this->M_marketing->updateCalVerTugas($dataset2, $kodeevent);
		}
		else
		{	
			
			$dataset1["id_siam"] = $iduser;
			$dataset1["kode_referal"] = $kodebaru;
			$dataset1["jenis_event"] = 2;
			$dataset1["status"] = 2;
			$this->M_marketing->addtbMentor($dataset1);

			$dataset2["kode_event"] = $kodebaru;
			$this->M_marketing->addDataMentorTugas($dataset2);
			

		}

		redirect ("/marketing/daftar_event_ver/");

	}

	public function chat_event($kodeevent)
	{
		$data = array();
		$data['konten'] = 'vk_dashboard_calver_mentor';

		if($cekevent = $this->M_marketing->cekrefevent($kodeevent))
		{
			$gatatugasevent = $this->M_marketing->gettugasevent($kodeevent);
			$this->load->Model('M_channel');
			$data['datapesan'] = $this->M_channel->getChat(6, null, $kodeevent);
			$data['judulevent'] = $cekevent->npsn_sekolah;
			$data['id_playlist'] = $kodeevent;
			$data['jenis'] = "calver";
			$data['idku'] = $this->session->userdata('id_user');
			$data['tanggalevent'] = namabulan_panjang(substr($cekevent->tgl_jalan,0,10));
			$data['linkvideo'] = $gatatugasevent->link_video;
			$data['videotugas'] = $gatatugasevent->jml_video;
			$data['playlisttugas'] = $gatatugasevent->jml_playlist;
			$data['kontrialltugas'] = $gatatugasevent->jml_kontri;
			$data['videokontriall'] = $gatatugasevent->jml_video_kontri;
			$data['jmlsiswatugas'] = $gatatugasevent->jml_ekskul;

			$cekvideocalver = $this->M_marketing->getVideoCalver2($kodeevent);
			$this->updatecalverdaf($cekvideocalver,'jml_videook','-');

			$cekvideokontri = $this->M_marketing->hitungvideoall2($kodeevent);
			$this->updatecalverdaf($cekvideokontri,'jml_video_kontri','jml_video_kontriok');

			$this->load->Model('M_ekskul');
			$dataekskul = $this->M_ekskul->getEkskulVer($kodeevent);
			$this->updatecalverdaf($dataekskul,'jml_ekskul','-');

			////////////////////////

			$cekcalver = $this->M_marketing->getdafeventcalver($kodeevent);
			$jmlcalver = 0;
			$jmllulus = 0;
			$jmlvideocalver = 0;
			$jmlvideolulus = 0;
			$jmlplaylist = 0;
			$jmlkontri = 0;
			$jmlkontriok = 0;
			$jml_video_kontri = 0;
			$jml_video_kontriok = 0;
			$jml_siswaekskul = 0;

			// echo "<pre>";
			// echo var_dump($cekcalver);
			// echo "</pre>";

			foreach($cekcalver as $datarow)
			{
				$jmlcalver++;
				if ($datarow->statuscalver == 1)
					$jmllulus++;
				$jmlvideocalver = $jmlvideocalver + $datarow->jmlvideocalver;
				$jmlvideolulus = $jmlvideolulus + $datarow->jml_videook;
				$jmlplaylist = $jmlplaylist + $datarow->jml_playlist;
				$jmlkontri=$jmlkontri+$datarow->jml_kontri;
				$jmlkontriok=$jmlkontriok+$datarow->jml_kontriok;
				$jml_video_kontri=$jml_video_kontri+$datarow->jml_video_kontri;
				$jml_video_kontriok=$jml_video_kontriok+$datarow->jml_video_kontriok;
				$jml_siswaekskul=$jml_siswaekskul+$datarow->jml_ekskul;
			}
			$data['jmlcalver'] = $jmlcalver;
			$data['jmllulus'] = $jmllulus;
			$data['jmlvideocalver'] = $jmlvideocalver;
			$data['jmlvideolulus'] = $jmlvideolulus;
			$data['jmlplaylist'] = $jmlplaylist;
			$data['jmlkontri'] = $jmlkontri;
			$data['jmlkontriok'] = $jmlkontriok;
			$data['jmlvideokontri'] = $jml_video_kontri;
			$data['jmlvideokontriok'] = $jml_video_kontriok;
			$data['jml_siswaekskul'] = $jml_siswaekskul;

			
		}

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function updatecalverdaf($data, $field, $field2)
	{
		if ($this->session->userdata('siam')!=3) {
			redirect("/");
		}
		$this->load->model('M_marketing');
		$data2 = array();
		$baris = 0;
		foreach ($data as $row) {
			$baris++;
			$data2[$baris][$field] = $row[$field];
			if ($field2!="-")
				$data2[$baris][$field2] = $row[$field2];
			$data2[$baris]['id_calver'] = $row['id_user'];
			// echo $field2.":".$row[$field2]."<br>"; 
		}
		$this->M_marketing->updateDafMentorCalver($data2);
	}

	public function calver($param1=null, $param2=null)
	{
		if ($param1=="daftar")
		{
			$idmarketing = $this->session->userdata('id_user');
			$data = array();
			$data['konten'] = 'v_marketing_calver_daftar';

			$this->load->Model('M_marketing');
			$dafcalver = $this->M_marketing->getdafeventcalver($param2);
			
			$data['dafcalver'] = $dafcalver;
			$data['koderef'] = $param2;
					
			// echo "<pre>";
			// echo var_dump ($data['dafmodul']);
			// echo "</pre>";
			// die();
		}
		else if ($param1=="detil")
		{
			$idmarketing = $this->session->userdata('id_user');
			$data = array();
			$data['konten'] = 'v_marketing_calver_detil';

			$this->load->Model('M_marketing');
			//$dafcalver = $this->M_marketing->getVideoCalverAll($param2);
			// echo "<pre>";
			// echo var_dump($dafcalver);
			// echo "</pre>";
			// die();
			
			$dafcalver = $this->M_marketing->getdafeventcalver($param2);
			
			$data['dafcalver'] = $dafcalver;
			$data['koderef'] = $param2;
					
		}
		else if ($param1=="video")
		{
			// $getuser = getstatususer();
			// $referrer = $getuser['referrer']; 
			// $this->load->model("M_marketing");
			if($cekevent = $this->M_marketing->cekrefevent($param2))
			{
				
				$dataevent = $this->M_marketing->gettugasevent($param2);

				$data = array();
				$data['konten'] = 'v_video';
				$statusverifikator = "bukan";
				
				$data['status_verifikator'] = $statusverifikator;
				$data['statusvideo'] = 'verifikasi';
				$data['linkdari'] = 'calver';
				$data['opsi'] = 'calver';
				$data['linkevent'] = $param2;
				$data['hal'] = 1;
				
				$data['jmltugasvideo'] = $dataevent->jml_video;
				$data['kodeevent'] = $param2;
				$data['subjudulevent'] = $cekevent->npsn_sekolah;
				$data['subjudulevent2'] = namabulan_panjang($cekevent->tgl_jalan);
				$this->load->Model("M_video");
				$data['dafvideo'] = $this->M_video->getVideobyEvent($cekevent->id, 2);

				$this->load->view('layout/wrapper_tabel', $data);
				
			}
			else
			{
				redirect ("/");
			}
		} 
		else if ($param1=="playlist")
		{
			if($cekevent = $this->M_marketing->cekrefevent($param2))
			{
				
				$dataevent = $this->M_marketing->gettugasevent($param2);
				$npsn = $this->session->userdata('npsn');
				$id = $this->session->userdata('id_user');
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
				$data['dafpaket'] = $this->M_channel->getPaketSekolah($npsn);

			}
		}
		else
		redirect("/");
		
		$this->load->view('layout/wrapper_tabel', $data);
	}

}
