<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_induk");
		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}

//		echo $this->session->userdata('a02');

		if ($this->session->userdata('a01') || ($this->session->userdata('sebagai')==1
				&& ($this->session->userdata('verifikator')==3 || $this->session->userdata('verifikator')==1)) ||  $this->session->userdata('a02')
			|| $this->session->userdata('siae') > 0 || $this->session->userdata('siam') > 0
			|| $this->session->userdata('tutor') > 0
			|| $this->session->userdata('siag') > 0 || $this->session->userdata('bimbel') > 0) {
			//
		} else {

			redirect('/');
		}

		$this->load->helper(array('Form', 'Cookie', 'download','statusverifikator'));
	}

	public function index()
	{
		$this->verifikator();
	}

	public function usersekolah($asal=null, $sebagai=null)
	{
		$data = array();
		$data['konten'] = 'v_user';
		//$data['sortby'] = '';
		$data['statusaktif'] = "all";
		$this->load->model("M_user");

		// echo "CEK".$this->session->userdata['npsn'];

		if ($this->session->userdata('a01'))
			$data['dafuser'] = $this->M_user->getAllUser(null,0,0);
		else if ($this->session->userdata['tukang_verifikasi'] == 1 || $this->session->userdata['verifikator'] == 1 )
			$data['dafuser'] = $this->M_user->getUserSekolah($this->session->userdata['npsn'], $sebagai);
		else if ($this->session->userdata['tukang_verifikasi'] == 2)
			$data['dafuser'] = $this->M_user->getAllUser();
		$ceknpsn = $this->session->userdata['npsn'];
		if ($ceknpsn != "")
			$data['sekolahku'] = $this->M_user->getNamaSekolah($ceknpsn);
		else
			$data['sekolahku'] = "";
		$data['asal'] = $asal;
		$data['sebagai'] = $sebagai;

		if ($asal=="uji")
		{
			echo "<pre>";
			echo var_dump($data['dafuser']);
			echo "</pre>";
			die();
		}

		$data['premium'] = "";
		$npsn = $this->session->userdata('npsn');
		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];
		$this->load->model("M_payment");
		if ($this->M_payment->cekpremium($npsn,$prodi))
		{
			$data['premium'] = " [PREMIUM]";
		}

		$data['nama_am'] = "kosong";
		$data['total_adapaketreguler'] = 0;
		$data['total_adapaketpremium'] = 0;

		if ($this->session->userdata('a02') && !$this->session->userdata('a01')) {
			$jmlbelipaketreguler = 0;
			$jmlbelipaketpremium = 0;
			foreach ($data['dafuser'] as $rowdata)
			{
				if ($rowdata->strata == 2)
					$jmlbelipaketreguler++;
				else if ($rowdata->strata == 3)
					$jmlbelipaketpremium++;
			}
			$data['total_adapaketreguler'] = $jmlbelipaketreguler;
			$data['total_adapaketpremium'] = $jmlbelipaketpremium;

			$this->load->model("M_login");
			$getuser = $this->M_login->getUser($this->session->userdata['id_user']);
			$kodeam = $getuser['referrer'];
			$this->load->model("M_marketing");
			$getam = $this->M_marketing->getDataRef($kodeam);
			if ($getam) {
				$getuseram = $this->M_login->getUser($getam->id_siam);
				if ($getam)
					$data['nama_am'] = $getuseram['first_name'] . " " . $getuseram['last_name'];
				else
					$data['nama_am'] = "kosong";
			}
		}

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function guru($asal=null)
	{
		$data = array();
		$data['konten'] = 'v_user';
		//$data['sortby'] = '';
		$data['statusaktif'] = "all";
		$this->load->model("M_user");

		if ($this->session->userdata('a01'))
			$data['dafuser'] = $this->M_user->getAllUser();
		else if ($this->session->userdata['tukang_verifikasi'] == 1)
			$data['dafuser'] = $this->M_user->getUserSekolah($this->session->userdata['npsn'],1);
		else if ($this->session->userdata['tukang_verifikasi'] == 2)
			$data['dafuser'] = $this->M_user->getAllUser();
		$ceknpsn = $this->session->userdata['npsn'];
		if ($ceknpsn != "")
			$data['sekolahku'] = $this->M_user->getNamaSekolah($ceknpsn);
		else
			$data['sekolahku'] = "";
		$data['asal'] = $asal;

		if ($asal=="uji")
		{
			echo "<pre>";
			echo var_dump($data['dafuser']);
			echo "</pre>";
			die();
		}

		$data['premium'] = "";
		$this->load->model("M_payment");
		if ($this->M_payment->cekpremium($this->session->userdata['npsn']))
		{
			$data['premium'] = " [PREMIUM]";
		}

		$data['nama_am'] = "kosong";
		$data['total_adapaketreguler'] = 0;
		$data['total_adapaketpremium'] = 0;

		if ($this->session->userdata('a02') && !$this->session->userdata('a01')) {
			$jmlbelipaketreguler = 0;
			$jmlbelipaketpremium = 0;
			foreach ($data['dafuser'] as $rowdata)
			{
				if ($rowdata->strata == 2)
					$jmlbelipaketreguler++;
				else if ($rowdata->strata == 3)
					$jmlbelipaketpremium++;
			}
			$data['total_adapaketreguler'] = $jmlbelipaketreguler;
			$data['total_adapaketpremium'] = $jmlbelipaketpremium;

			$this->load->model("M_login");
			$getuser = $this->M_login->getUser($this->session->userdata['id_user']);
			$kodeam = $getuser['referrer'];
			$this->load->model("M_marketing");
			$getam = $this->M_marketing->getDataRef($kodeam);
			if ($getam) {
				$getuseram = $this->M_login->getUser($getam->id_siam);
				if ($getam)
					$data['nama_am'] = $getuseram['first_name'] . " " . $getuseram['last_name'];
				else
					$data['nama_am'] = "kosong";
			}
		}

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function staf()
	{
		$data = array('title' => 'Daftar Staf', 'menuaktif' => '11',
			'isi' => 'v_user3');

		$this->load->model("M_user");
		$data['dafuser'] = $this->M_user->getAllUser(2);
		$data['asal'] = "staf";
		$this->load->view('layout/wrapper', $data);
	}

	public function bimbel_old()
	{
		if ($this->session->userdata('a01') ||
			($this->session->userdata('sebagai') == 4) && $this->session->userdata('verifikator') == 3) {
			$data = array('title' => 'Daftar Anggota Bimbel', 'menuaktif' => '11',
				'isi' => 'v_userbimbel');

			$this->load->model("M_user");
			$data['dafuser'] = $this->M_user->getBimbelUser();
			$data['asal'] = "bimbel";
			$this->load->view('layout/wrapper', $data);
		} else
			redirect("/");
	}

	public function narsum()
	{
		$data = array();
		$data['konten'] = 'v_user2';

		$this->load->model("M_user");
		$data['dafuser'] = $this->M_user->getAllUser(1);
		$data['asal'] = "narsum";
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function daftarcalver($opsi=null)
	{
		$data = array();
		$data['konten'] = 'v_user';
		$data['judul'] = 'CALON VERIFIKATOR';

		$this->load->model("M_user");
		$data['sekolahku'] = $this->M_user->getNamaSekolah($this->session->userdata['npsn']);
		$data['dafuser'] = $this->M_user->getAllVer(2);
		if ($opsi=="tes")
			{
				echo "<pre>";
				echo var_dump($data['dafuser']);
				echo "</pre>";
			}
		$data['asal'] = "dashboard";
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function verifikator($opsi=null)
	{
		$data = array();
		$data['konten'] = 'v_user';
		$data['judul'] = 'VERIFIKATOR';

		$this->load->model("M_user");
		$data['sekolahku'] = $this->M_user->getNamaSekolah($this->session->userdata['npsn']);
		$data['dafuser'] = $this->M_user->getAllVer();
		if ($opsi=="tes")
			{
				echo "<pre>";
				echo var_dump($data['dafuser']);
				echo "</pre>";
			}
		$data['asal'] = "dashboard";
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function dosen()
	{
		$data = array();
		$data['konten'] = 'v_user';
		$data['judul'] = 'DOSEN';

		$getuser = getstatususer();
		$data['sekolahku'] = $getuser['namakampus'];
		$data['prodiku'] = $getuser['namaprodi'];
		$npsn = $this->session->userdata('npsn');
		$kd_prodi = $getuser['kelasku'];

		$this->load->Model('M_user');
		$data['dafuser'] = $this->M_user->getAllDosen($npsn, $kd_prodi);

		$data['asal'] = "dashboard";
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function mahasiswa()
	{
		$data = array();
		$data['konten'] = 'v_user';
		$data['judul'] = 'MAHASISWA';

		$getuser = getstatususer();
		$data['sekolahku'] = $getuser['namakampus'];
		$data['prodiku'] = $getuser['namaprodi'];
		$npsn = $this->session->userdata('npsn');
		$kd_prodi = $getuser['kelasku'];

		$this->load->model("M_user");
		$data['dafuser'] = $this->M_user->getAllMahasiswa($npsn, $kd_prodi);

		$data['asal'] = "dashboard";
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function calkontri()
	{
		$data = array();
		$data['konten'] = 'v_user';

		$this->load->model("M_user");
		$data['sekolahku'] = $this->M_user->getNamaSekolah($this->session->userdata['npsn']);
		$data['dafuser'] = $this->M_user->getAllKontri(2);
		$data['asal'] = "dashboard";
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function kontributor()
	{
		$data = array();
		$data['konten'] = 'v_user_kontributor';

		$this->load->model("M_user");
		$data['sekolahku'] = $this->M_user->getNamaSekolah($this->session->userdata['npsn']);
		$data['dafuser'] = $this->M_user->getKontributorSekolah($this->session->userdata['npsn']);
		$data['asal'] = "dashboard";
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function calonstaf()
	{
		if (!$this->session->userdata('a01'))
			redirect('/');
		$data = array('title' => 'Daftar User Calon Staf', 'menuaktif' => '0',
			'isi' => 'v_user_staf');
		//$data['sortby'] = '';
		$this->load->model("M_user");
		$data['dafuser'] = $this->M_user->getAllStaf();
		$this->load->view('layout/wrapper', $data);
	}

	public function verifikator_old()
	{
		if (!($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4))
			redirect('/');
		$data = array('title' => 'Daftar Calon Verifikator', 'menuaktif' => '12',
			'isi' => 'v_user_verifikator');
		//$data['sortby'] = '';
		$this->load->model("M_user");
		$data['dafuser'] = $this->M_user->getAllVerifikator();
		$this->load->view('layout/wrapper', $data);
	}

	public function kontributorsekolah($asal=null)
	{
		if (!$this->session->userdata('a01'))
			redirect('/');

		$this->load->model("M_user");
		$data = array();
		$data['konten'] = 'v_user_kontributor_sekolah';
		$data['asal'] = $asal;

		if ($this->session->userdata('a01')) {
			$data['dafuser'] = $this->M_user->getAllKontributorModul(1);
		}
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function kontributorbimbel($asal=null)
	{
		if (!$this->session->userdata('a01'))
			redirect('/');

		$this->load->model("M_user");
		$data = array();
		$data['konten'] = 'v_user_kontributor_bimbel';
		$data['asal'] = $asal;

		if ($this->session->userdata('a01')) {
			$data['dafuser'] = $this->M_user->getAllKontributorModul(3);
		}
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function detil($id = null, $asal = null)
	{
		if (!$this->session->userdata('a01') && !$this->session->userdata('a02') &&
			$this->session->userdata('siag')!=3 && $this->session->userdata('verifikator')!=1)
			redirect('/');

		$data = array();
		$data['konten'] = 'v_user_detil';

		//$data['sortby'] = '';
		$this->load->model("M_login");
		$data['userData'] = $this->M_login->getUser($id);
		$data['idkotasekolah'] = 0;

		if ($this->session->userdata('siag')==3 && ($data['userData']['bimbel']==0 || $data['userData']['bimbel']==4))
			redirect('/');

		if ($data['userData']['siae'] >= 1 && $this->session->userdata('a01')) {
			$data['isi'] = 'v_user_detil_ae';
		} else if ($data['userData']['siam'] >= 1 && $this->session->userdata('a01')) {
			$data['isi'] = 'v_user_detil_am';
		} else if ($data['userData']['siag'] >= 1 && $this->session->userdata('a01')) {
			$data['isi'] = 'v_user_detil_am';
		} else if ($data['userData']['bimbel'] >= 1 && $this->session->userdata('a01')) {
			$data['isi'] = 'v_user_detil';
		} else {
			$npsnuser = $data['userData']['npsn'];
			if ($npsnuser > 0) {
				$kotasekolah = $this->M_login->getKotaSekolah($npsnuser);
//			echo "<br><br><br><br><br><br><br><br><pre>";
//			echo var_dump($kotasekolah);
//			echo "</pre>";
				if ($kotasekolah) {
					$data['namakotasekolah'] = $kotasekolah->nama_propinsi;
					$data['idkotasekolah'] = $kotasekolah->id_propinsi;
				} else {
					$data['namakotasekolah'] = "";
					$data['idkotasekolah'] = 0;
				}
			} else {
				$data['namakotasekolah'] = "";
				$data['idkotasekolah'] = 0;
			}
		}
		$data['asal'] = $asal;
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function porto($id)
	{
		if (!$this->session->userdata('a01') && !$this->session->userdata('a02') && $this->session->userdata('siag')!=3)
			redirect('/');

		$data = array();
		$data['konten'] = 'v_user_porto';

		$this->load->model("M_login");
		$data['userData'] = $this->M_login->getUser($id);

		if ($this->session->userdata('siag')==3 && ($data['userData']['bimbel']==0 || $data['userData']['bimbel']==4))
			redirect('/');

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function assesment($id = null)
	{
		if ($id == null)
			redirect("/");
		$data = array();
		$data['konten'] = 'v_user_assesment';
		$this->load->model("M_login");
		$datauser = $this->M_login->getUser($id);
		if($datauser['siae']>=2)
			$jenis=10;
		else if($datauser['siam']>=2)
			$jenis=20;
		else if($datauser['bimbel']>=2)
			$jenis=30;
		$this->load->model("M_user");
		$hasilasses = $this->M_user->getHasilAssesment($id);
		$this->load->model("M_assesment");
		$data['asal'] = "owner";
		$data['tipe'] = $jenis+1;
		$data['judul'] = "Assesment";
		$data['dafsoal1'] = $this->M_assesment->getSoal($jenis+1);
		$data['dafjawaban1'] = $this->M_assesment->getJawaban($id,1);
		$data['dafsoal2'] = $this->M_assesment->getSoal($jenis+2);
		$data['dafjawaban2'] = $this->M_assesment->getJawaban($id,2);
		$data['hasilasses'] = $hasilasses[0];

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function updateverifikator($asal = null)
	{

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$kondisi = $this->input->post('kondisi');
		$kondisibayar = $this->input->post('kondisibayar');

		//date_default_timezone_set('Asia/Jakarta');

		if ($kondisibayar == 9) {
			//$datesekarang = new DateTime('2021-01-31');
			//$data['tglaktif'] = $datesekarang->format('Y-m-d');
		}


		if ($kondisi == 3)
			$kondisibayar = 3;
		else if ($kondisi == 32) {
			$kondisibayar = 0;
			$kondisi = 0;
			$data['statusbayar'] = 0;
			$tglbatas = new DateTime('0000-00-00 00:00:00');
			$data['tglaktif'] = $tglbatas->format('Y-m-d H:i:s');
		} else if ($kondisi == 4) {
			$data['kontributor'] = 0;
			$kondisi = 0;
			$kondisibayar = 0;
		} else if ($kondisi == 5) {
			$data['kontributor'] = 3;
			$kondisi = 0;
			$kondisibayar = 0;
		} else {
			if ($kondisibayar == 0) {
				$kondisi = 2;
				$kondisibayar = 0;
			} else if ($kondisibayar == 1) {
				$kondisi = 3;
				$kondisibayar = 3;
			}
		}

		$id = $this->input->post('id_user');
		$npsn = $this->input->post('npsn');
		$sekolah = $this->input->post('nm_sekolah');
		$idkota = $this->input->post('kt_sekolah');
		$kodeprodi = $this->input->post('kodeprodi');

		$this->load->model("M_user");
		// $idpropinsi = $this->M_user->kodepropfromkota($idkota);

		$data['verifikator'] = $kondisi;
		if ($kondisi == 3) {
			$data['tgl_verifikasi'] = $datesekarang->format('Y-m-d H:i:s');
		}
		$data['activate'] = 1;
		$data['statusbayar'] = $kondisibayar;

		$this->M_user->updateStaf($data, $id);
		// $this->M_user->tambahsekolah($data3,$data4);
		// $this->M_user->updateOtoritas($data2);
		$this->load->view('layout/wrapper', $data);

		//redirect($_SERVER['HTTP_REFERER']);

		$this->M_user->updateSisaCalver($npsn, $kodeprodi, $id);
		$this->M_user->updateKonfirmUser("CALVER");
		$this->M_user->updateKonfirmUser("VER");
		$this->M_user->updateKonfirmUser("KONTRI");
		$this->M_user->updateKonfirmUser("DOSEN");

		$this->load->Model('M_channel');
		$totalchanneladaver = sizeof($this->M_channel->getChannelSiap('adaver'));
		$dataprodi['n_prodi'] = $totalchanneladaver;
		$this->M_user->updateDashAdmin($dataprodi);

		redirect('user/verifikator/' . $asal);
	}

	public function updatekontributor($asal = null)
	{

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$this->load->model("M_user");
		$tujuan = "";

		$kondisi = $this->input->post('kondisi');
		$id = $this->input->post('id_user');
		$npsn = $this->input->post('npsn');
		$sekolah = $this->input->post('nm_sekolah');
		$idkota = $this->input->post('kt_sekolah');

		if ($kondisi == 31) {
			$data['verifikator'] = 3;
			$data['tgl_verifikasi'] = $datesekarang->format('Y-m-d H:i:s');
			$data['statusbayar'] = 3;
			$tglbatas = new DateTime('2021-01-31 23:23:23');
			$data['tglaktif'] = $tglbatas->format('Y-m-d H:i:s');
			$data2['id_user'] = $id;
			$data2['kd_otoritas'] = "a02";
			$this->M_user->updateOtoritas($data2);
			$tujuan = "verifikator";
		} else if ($kondisi == 32) {
			$data['verifikator'] = 0;
			$data['statusbayar'] = 0;
			$tglbatas = new DateTime('0000-00-00 00:00:00');
			$data['tglaktif'] = $tglbatas->format('Y-m-d H:i:s');
			$data2['id_user'] = $id;
			$data2['kd_otoritas'] = "a02";
			$this->M_user->delOtoritas($data2);
			$tujuan = "verifikator";
		} else {
			if ($kondisi == 4) {
				$data['kontributor'] = 2;
				$data2['id_user'] = $id;
				$data2['kd_otoritas'] = "a03";
				// $this->M_user->delOtoritas($data2);
				$tujuan = "dosen";
			} else if ($kondisi == 5 || $kondisi == 3 || $kondisi == 9) {
				$data['tgl_verifikasi'] = $datesekarang->format('Y-m-d H:i:s');
				$data['kontributor'] = 3;
				$data2['id_user'] = $id;
				$data2['kd_otoritas'] = "a03";
				// $this->M_user->updateOtoritas($data2);
				$tujuan = "dosen";
			}

		}

		$data['activate'] = 1;

		// echo $kondisi;
		// die();


		// $data3['npsn'] = $npsn;
		// //$data3['kode_sekolah'] = "ch".base_convert(microtime(false), 10, 36);
		// $data3['nama_sekolah'] = $sekolah;
		// $data3['idkota'] = $idkota;

		$this->M_user->updateStaf($data, $id);

		$this->load->Model('M_marketing');
		$this->M_marketing->updateCalVerDafUser("kontributor", $this->session->userdata('id_user'));

		$this->M_user->updateKonfirmUser("VER");
		$this->M_user->updateKonfirmUser("KONTRI");

		// $this->M_user->tambahsekolah($data3);
		$this->load->view('layout/wrapper', $data);
		if ($asal != null)
			$tujuan = $tujuan."/".$asal;
		IF ($this->session->userdata('verifikator')==1)
			$tujuan = "usersekolah/dashboard/calver";
		if ($this->session->userdata('a01'))
			redirect("/user/dosen");
		else
			redirect('user/'.$tujuan);
	}

	public function updatestaf($asal = null)
	{
		$kondisi = $this->input->post('kondisi');
		$id = $this->input->post('id_user');

		$data2['id_user'] = $id;

		//$data['verifikator'] = 3;

		$this->load->model("M_user");
		if ($kondisi == 3) {
			$data['verifikator'] = 3;
			$data['activate'] = 1;
			$data2['kd_otoritas'] = "a02";
			$this->M_user->updateOtoritas($data2);
		} else if ($kondisi == 5) {
			$data['kontributor'] = 3;
			$data['activate'] = 1;
			$data2['kd_otoritas'] = "a03";
			$this->M_user->updateOtoritas($data2);
		} else if ($kondisi == 4) {
			$data['kontributor'] = 0;
			$data2['kd_otoritas'] = "a02";
			$this->M_user->delOtoritas($data2);
		} else if ($kondisi == 32) {
			$data['verifikator'] = 0;
			$data2['kd_otoritas'] = "a02";
			$this->M_user->delOtoritas($data2);
		}
		//echo $kondisi;
		//die();
		$update = $this->M_user->updateStaf($data, $id);

		$this->load->Model('M_marketing');
		$this->M_marketing->updateCalVerDafUser("kontributor", $this->session->userdata('id_user'));
		
		$this->M_user->updateKonfirmUser("KONTRI");
		$this->M_user->updateKonfirmUser("VER");
		// $this->load->view('layout/wrapper', $data);
		//redirect($_SERVER['HTTP_REFERER']);
		// if ($kondisi==4)
		// redirect('user/verifikator');
		// else if ($kondisi==5)
		redirect('user/' . $asal);
	}

	public function upload_dok($field)
	{
		$config = array(
			'upload_path' => "uploads/profil/",
			'allowed_types' => "pdf",
			'overwrite' => TRUE,
			'max_size' => "204800000",
		);

		if ($field == "ijazah")
			$filedok = 'filedok';
		else if ($field == "mou")
		{
			$filedok = 'filemou';
			$field = "dok_agency";
			$config['upload_path'] = "uploads/agency/";
			$config['allowed_types'] = "jpg|jpeg|png|bmp";
		}
		else
			$filedok = 'filedok2';

		if (isset($_FILES[$filedok])) {
			echo "";
		} else {
			echo "ERROR";
		}


		$this->load->library('upload', $config);
		if ($this->upload->do_upload($filedok)) {

			$dataupload = array('upload_data' => $this->upload->data());
			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$iduser = $this->session->userdata("id_user");
			$namafilebaru = $field . "_" . $iduser . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			if ($field == "dok_agency")
				echo "File telah terupload!";
			else
			{
				$this->load->model("M_user");
				$this->M_user->updateberkas($field, $namafilebaru, $iduser);
				echo "Dokumen OK";
			}


		} else {
			echo $this->upload->display_errors();
		}
	}

	public function ubahsebagai()
	{
		if ($this->session->userdata('a01')) {
			$iduser = $this->input->post('iduser');
			$sebagai = $this->input->post('sebagaiuser');
			$this->load->model('M_user');
			$this->M_user->updatesebagai($sebagai, $iduser);
		} else
			redirect("/");
	}

	public function ubahbimbel()
	{
		if ($this->session->userdata('a01')) {
			$iduser = $this->input->post('iduser');
			$statusbimbel = $this->input->post('statusbimbel');
			$this->load->model('M_user');
			$this->M_user->updatebimbel($statusbimbel, $iduser);
		} else
			redirect("/");
	}


	public function aktifkan($id)
	{
		if (!$this->session->userdata('a01'))
			redirect('/');
		$this->load->model("M_user");
		$this->M_user->setAktif($id);
		redirect('/user');
	}

	public function deleteakun()
	{
		$iduser = $_POST['iduser'];
		$sebagaiuser = $_POST['sebagaiuser'];
		$npsnuser = $_POST['npsnuser'];
		$verifikatoruser = $_POST['verifikatoruser'];

		if ($sebagaiuser == "" || $sebagaiuser == "99" ||
			($this->session->userdata('sebagai') == 4 && $sebagaiuser == 4) ||
			($this->session->userdata('verifikator') == 3 && $this->session->userdata('sebagai') != 4 &&
				($verifikatoruser == 3 || ($this->session->userdata('npsn') != $npsnuser)))) {
			//echo "IDUSER:".$iduser.", SEBAGAI:".$sebagaiuser.", NPSN:".$npsnuser.", VERIFIKATOR:".$verifikatoruser;
		} else {
			$this->load->model('M_user');
			$this->M_user->deleteakun($iduser);
			//echo "OKE";
		}
	}

	public function tambahnarsum()
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4)
			redirect('/');
		$data = array();
		$data['konten'] = 'v_login_daftarin';

		$this->session->set_userdata('tambahnarsum', 'true');

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function ae()
	{
		if ($this->session->userdata("a01") || ($this->session->userdata("sebagai") == 4
				&& $this->session->userdata("verifikator") == 3)) {
			$data = array();
			$data['konten'] = 'v_user_ae';
			$this->load->model("M_user");
			$data['dafuser'] = $this->M_user->getAllUserAE();
			$this->load->view('layout/wrapper_tabel', $data);
		}
		else
			redirect("/");
	}

	public function am()
	{
		if ($this->session->userdata("a01") || ($this->session->userdata("sebagai") == 4
				&& $this->session->userdata("verifikator") == 3)) {
			$data = array();
			$data['konten'] = 'v_user_am';
			$this->load->model("M_user");
			$data['dafuser'] = $this->M_user->getAllUserAM();
			$this->load->view('layout/wrapper_tabel', $data);
		}
		else
			redirect("/");
	}

	public function agency()
	{
		if ($this->session->userdata("a01") || ($this->session->userdata("sebagai") == 4
				&& $this->session->userdata("verifikator") == 3)) {
			$data = array();
			$data['konten'] = 'v_user_ag';
			$this->load->model("M_user");
			$data['dafuser'] = $this->M_user->getAllUserAG();
			$this->load->view('layout/wrapper_umum', $data);
		}
		else
			redirect("/");
	}

	public function bimbel()
	{
		if ($this->session->userdata("a01") || ($this->session->userdata("bimbel") == 4
				&& $this->session->userdata("siag") == 3)) {
			$data = array();
			$data['konten'] = 'v_user_bimbel';
			$this->load->model("M_user");
			if ($this->session->userdata("a01"))
				$data['dafuser'] = $this->M_user->getAllUserBimbel();
			else
			{
				$getstatus = getstatususer();
				$data['dafuser'] = $this->M_user->getAllUserBimbel($getstatus['kd_kota']);
			}

			$this->load->view('layout/wrapper_tabel', $data);
		}
		else
			redirect("/");
	}

	public function aksi($sebagai, $id)
	{
		if (!$this->session->userdata("a01") && $this->session->userdata("siag")!=3)
			redirect("/");
		$data = array();
		$data['konten'] = 'v_user_aksi';
		$this->load->model("M_login");
		$cekuser = $this->M_login->getUser($id);
		$data['userData'] = $cekuser;

		if ($this->session->userdata('siag')==3 && ($data['userData']['bimbel']==0 || $data['userData']['bimbel']==4))
			redirect('/');

		$this->load->model("M_user");
		$cekagency = $this->M_user->cekagency($cekuser['kd_kota']);
		if ($cekagency && $id != $cekagency[0]->id)
			$data['adaagency'] = "ada";
		else
			$data['adaagency'] = "kosong";
		$data['sebagai'] = $sebagai;
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function cekagency($idkota)
	{
		$this->load->model("M_user");
		$dafagency = $this->M_user->cekagency($idkota);
		if ($dafagency)
			echo "ada";
		else
			echo "kosong";
	}


	public function tetapin($tipe)
	{
		if (!$this->session->userdata("a01") && $this->session->userdata("siag")!=3)
			redirect("/");
		$this->load->model("M_user");
		$id = $this->input->post('iduser');
		$status = $this->input->post('status');
		if ($this->M_user->tetapin($tipe, $id, $status))
		{
			$this->M_user->updateKonfirmUser($tipe);
			echo "sukses";
		}
		else
			echo "gagal";
	}

	public function download_assesment($id)
	{
		force_download('uploads/assesment/asses_' . $id . ".pdf", null);
	}

	public function signpdf()
	{
		//echo 'Versi PHP yang sedang digunakan: ' . phpinfo();
		$this->load->library('image_lib');
		$uploadpath = "uploads/agency/";
		$im             = new Imagick();
		$im->setResolution(200,200);
		$im->readimage("uploads/agency/agency.pdf");

		$im->setImageBackgroundColor('white');
		$im->setImageAlphaChannel(imagick::ALPHACHANNEL_REMOVE);
		$im->mergeImageLayers(imagick::LAYERMETHOD_FLATTEN);
		$im->setImageFormat('jpg');

		$image_name     = 'agency.jpg';
		$imageprops     = $im->getImageGeometry();

		$im->writeImage( $uploadpath.$image_name);
		$im->clear();
		$im->destroy();

//				// change file permission for file manipulation
//				chmod($uploadpath.$image_name, 0777); // CHMOD file
//
//				// add watermark to image
//				$img_manip              = array();
//				$img_manip              = array(
//					'image_library'     => 'gd2',
//					'wm_type'           => 'overlay',
//					'wm_overlay_path'   => FCPATH . '/uploads/gb1.jpg', // path to watermark image
//					'wm_x_transp'       => '10',
//					'wm_y_transp'       => '10',
//					'wm_opacity'        => '100',
//					'wm_vrt_alignment'  => 'middle',
//					'wm_hor_alignment'  => 'center',
//					'source_image'      => $uploadpath.$image_name
//				);
//
//				$this->image_lib->initialize($img_manip);
//				$this->image_lib->watermark();
//
//				ImageJPEG(ImageCreateFromString(file_get_contents($uploadpath.$image_name)), $uploadpath.$image_name);
//
//
//			// unlink the original pdf file
//			chmod($uploadpath.$image_name, 0777); // CHMOD file
//			//unlink($uploadpath.$image_name);    // remove file

	}

	public function cleansiswa()
	{
		$this->load->Model('M_user');
		$this->M_user->cleansiswaver();
	}

	public function teskodepropinsi($kodekota)
	{
		$this->load->model("M_user");
		$idpropinsi = $this->M_user->kodepropfromkota($kodekota);
		echo $idpropinsi;
	}

}
