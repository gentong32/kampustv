<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agency extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_agency");
		$this->load->model("M_login");
		$this->load->helper('tanggalan');

		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}
		if ($this->session->userdata('a01') || $this->session->userdata('siag') > 0) {
			//
		} else {
			redirect('/');
		}

		$this->load->helper(array('Form', 'Cookie', 'download'));
	}

	public function index()
	{
		$data = array();
		$data['konten'] = 'v_agency_aktivitas';

//		$this->load->model("M_login");
		$data['dafaktif'] = $this->M_agency->getDafAktif($this->session->userdata('id_user'));
//
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function daftar_am()
	{
		$data = array();
		$data['konten'] = 'v_agency_dafam';
		 

		$getuser = $this->M_login->getUser($this->session->userdata('id_user'));
		$this->load->model("M_agency");
		if ($getuser['level']==0)
			{
				$data['dafuser'] = $this->M_agency->getDafUser($getuser['kd_kota']);
			}
		else if ($getuser['level']==1)
			{
				$data['dafuser'] = $this->M_agency->getDafUserAll();
			}
		$data['level'] = $getuser['level'];
		
//
		$this->load->view('layout/wrapper_tabel', $data);
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

	public function transaksi_virtualkelas()
	{
		$data = array();
		$data['konten'] = 'v_agency_transaksi';

		$idagency = $this->session->userdata('id_user');
		$this->load->model("M_eksekusi");
		$hargastandar = $this->M_eksekusi->getStandar();
		$this->load->Model("M_login");
		$data['biayatarik'] = $hargastandar->biayatarik;
		$data['minimaltarik'] = $hargastandar->minimaltarik;
		$data['daftransaksi'] = $this->M_agency->getTransaksi($idagency);
		$data['getuserdata'] = $this->M_login->getUser($idagency);
		//echo "<br><br><br><br><br><br><br><br><br><br><br>";
		//echo var_dump($data['daftransaksi']);
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function transaksi_sekolah()
	{
		$data = array();
		$data['konten'] = 'v_agency_transaksi_premium';
		
		$idagency = $this->session->userdata('id_user');
		$this->load->model('M_eksekusi');
		$hargastandar = $this->M_eksekusi->getStandar();
		$this->load->Model("M_login");
		$useragency = $this->M_login->getUser($idagency);
		$ceknpwp = $useragency['npwp'];
		if ($ceknpwp==null ||$ceknpwp=="-")
			$pphagency = $hargastandar->pph;
		else
			$pphagency = $hargastandar->pph_npwp;
		$data['biayatarik'] = $hargastandar->biayatarik;
		$data['minimaltarik'] = $hargastandar->minimaltarik;
		$data['pphagency'] = $pphagency;
		$data['daftransaksi'] = $this->M_agency->getTransaksiPremium($idagency);
		$data['getuserdata'] = $this->M_login->getUser($idagency);
		//echo "<br><br><br><br><br><br><br><br><br><br><br>";
		//echo var_dump($data['daftransaksi']);
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function daftar_user($npsn)
	{
		$data = array('title' => 'Daftar Kode Referal', 'menuaktif' => '11',
			'isi' => 'v_marketing_dafuser');

		$this->load->model("M_user");
		$getNamaSekolah = $this->M_user->getNamaSekolah($npsn);
		$data['namasekolah'] = $getNamaSekolah;
		$data['dafuser'] = $this->M_agency->getDafUser($this->session->userdata('id_user'), $npsn);
//
		$this->load->view('layout/wrapper', $data);
	}

	public function kode_referal($idmarketing)
	{
		$data = array('title' => 'Kode Referal', 'menuaktif' => '11',
			'isi' => 'v_marketing_kode');

//		$this->load->model("M_login");
		$data['dataku'] = $this->M_agency->getKodeRef($idmarketing);
//
		$this->load->view('layout/wrapper', $data);
	}

	public function ceksasaran($npsn=null)
	{
		if ($npsn==null)
			$npsn = $this->input->post('npsn');
		if (!$this->M_agency->ceksasaran($npsn))
			$this->getsekolahfull($npsn);
		else
		{
			$error = array('nama_sekolah' => 'nemu');
			echo json_encode($error);
		}

	}

	private function getsekolahfull($npsn)
	{
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

	public function pilih_sekolah()
	{
		$id=$this->session->userdata('id_user');
		$npsn = $this->input->post('npsn');

		$set = '123456789abcdefghjkmnpqrstuvwxyz';
		$code = substr(str_shuffle($set), 0, 5);
		$koderef = $code . $id;

		$data['npsn_sekolah'] = $npsn;
		$data['kode_referal'] = $koderef;
		$data['status'] = 1;

		$this->M_agency->updateagencymou($data, 0, $id);

		echo $koderef;
	}

	public function update_sekolahbaru()
	{
		$datasek['id_kota'] = $this->input->post('ikota');
		$datasek['npsn'] = $this->input->post('inpsn');
		$datasek['nama_sekolah'] = $this->input->post('isekolah');
		$datasek['alamat_sekolah'] = $this->input->post('ialamatsekolah');
		$datasek['kecamatan'] = $this->input->post('ikecamatansekolah');
		$datasek['desa'] = $this->input->post('idesasekolah');
		$datasek['id_jenjang'] = $this->input->post('ijenjangsekolah');
		$datasek['status'] = 1;

		$datasek2 = array();
		$datasek2['idkota'] = $this->input->post('ikota');
		$datasek2['npsn'] = $this->input->post('inpsn');
		$datasek2['idjenjang'] = $this->input->post('ijenjangsekolah');
		$datasek2['nama_sekolah'] = $this->input->post('isekolah');

		if ($this->input->post('ikota') > 0 &&
			($this->session->userdata('siae') == 0 && $this->session->userdata('siam') == 0
				&& $this->session->userdata('bimbel') == 0)) {
			$this->M_login->addsekolah($datasek);
			$this->M_login->addchnsekolah($datasek2);
		}
	}

	public function terlaksana()
	{
		$id=$this->session->userdata('id_user');
		$data['status'] = 2;

		if ($this->M_agency->updateagencymou($data, 1, $id))
			echo "berhasil";
		else
			echo "gagal";
	}

	public function mou_daftar()
	{
		$data = array();
		$data['konten'] = 'v_agency_daftar_mou';

		$data['dafkode'] = $this->M_agency->getDafMOU($this->session->userdata('id_user'));
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function mou_baru()
	{
		$data = array();
		$data['konten'] = 'v_agency_mou_baru';

		$iduser = $this->session->userdata("id_user");
		$user = $this->M_login->getUser($iduser);

		$cekdata = $this->M_agency->getlastagency($iduser);
//		echo var_dump($cekdata);
//		die();
		if ($cekdata)
			$data ['dafagency'] = $cekdata;
		else {
			$cekdata = $this->M_agency->addagency($iduser);
			$data ['dafagency'] = $cekdata;
		}

		$data['dafpropinsi'] = $this->M_login->dafpropinsi(1);
		$data['dafkota'] = $this->M_login->dafkota($user['kd_provinsi']);
		$data['propinsisaya'] = $user['kd_provinsi'];
		$data['kotasaya'] = $user['kd_kota'];

		$this->load->view('layout/wrapper_umum', $data);
	}

}
