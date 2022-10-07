<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model("M_induk");
        $this->load->model('M_vod');
		$this->load->helper(array('Form', 'Cookie', 'String', 'captcha'));
        if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
            redirect('/');
        }
    }

    public function index() {
        $data = array('title' => 'Statistik','menuaktif' => '10',
                      'isi' => 'v_statistik');
        //$data['userData']=$this->session->userdata('userData');
        $data['jmlchnsekolah'] = $this->M_vod->jmlChnSekolah();
		$data['jmlchnaktifsekolah'] = $this->M_vod->jmlChnAktifSekolah();
		$data['jmlplaylistaktifsekolah'] = $this->M_vod->jmlPlaylistAktifSekolah();
		$data['jmlpaud'] = $this->M_vod->jmlPerJenjang(1);
		$data['jmlsd'] = $this->M_vod->jmlPerJenjang(2);
		$data['jmlsmp'] = $this->M_vod->jmlPerJenjang(3);
		$data['jmlsma'] = $this->M_vod->jmlPerJenjang(4);
		$data['jmlsmk'] = $this->M_vod->jmlPerJenjang(5);
		$data['jmlpt'] = $this->M_vod->jmlPerJenjang(6);
		$data['jmlpkbm'] = $this->M_vod->jmlPerJenjang(7);
		$data['jmllain'] = $this->M_vod->jmlPerJenjang(0);
		$data['jmltotalguru'] = $this->M_vod->jmlGuru();
		$data['jmltotalguruver'] = $this->M_vod->jmlVerSekolah();
		$data['jmltotalgurukon'] = $this->M_vod->jmlKontributorSekolah();
		$data['jmltotalsiswa'] = $this->M_vod->jmlSiswa();
		$data['jmltotalsiswakon'] = $this->M_vod->jmlKontributorSiswa();
		$data['jmltotalumum'] = $this->M_vod->jmlUmum();
		$data['jmltotalumumkon'] = $this->M_vod->jmlKontributorUmum();
		$data['jmltotalvideo'] = $this->M_vod->jmlVideo();
        $data['jmlperjenjang'] = $this->M_vod->getDataPerJenjang();
        $data['jmlperkategori'] = $this->M_vod->getDataPerKategori();

        $this->load->view('layout/wrapper3', $data);
	}

	public function datasekolah($mulai = null, $sampai = null)
	{
		$data = array('title' => 'Daftar Sekolah', 'menuaktif' => '11',
			'isi' => 'v_datasekolah');

		$data['statusaktif'] = "all";
		$this->load->model("M_channel");

		$data['dafchannel'] = $this->M_channel->getChannelStatistik($mulai, $sampai);

//		echo "<pre>";
//		echo var_dump($data['dafchannel']);
//		echo "</pre>";
//		die();

		$data['mulai'] = $mulai;
		$data['sampai'] = $sampai;

		$this->load->view('layout/wrapperchannel1', $data);
	}

	public function dataguru($mulai = null, $sampai = null)
	{
		$data = array('title' => 'Daftar Channel Guru', 'menuaktif' => '11',
			'isi' => 'v_dataguru');

		$data['statusaktif'] = "all";
		$this->load->model("M_channel");
		$data['dafchannel'] = $this->M_channel->getChannelGuruStatistik($mulai, $sampai);
		$this->load->model("M_video");
		$data['dafpesertalomba'] = $this->M_video->daftarpesertaeventsekolahl();

		$data['mulai'] = $mulai;
		$data['sampai'] = $sampai;

		$this->load->view('layout/wrapperchannel1', $data);
	}

	public function ekspor()
	{
		$this->load->model("M_channel");
		$data['dafchannel'] = $this->M_channel->getChannelStatistik();
		$this->load->view('v_excel', $data);

	}

	public function statistik_ae($berdasarkan = null, $hal = null, $propinsi = null, $kab = null, $jenjang = null) {
		$data = array('title' => 'Statistik Sekolah','menuaktif' => '10',
			'isi' => 'v_statistik_ae');

		$this->load->model("M_vod");
		$data['dafjenjang'] = $this->M_vod->getJenjangAll();

		$this->load->model("M_channel");
		if ($berdasarkan==null && $hal==null && $propinsi==null && $kab==null && $jenjang==null)
			$data['dafchannel'] = $this->M_channel->retrieveStatistikAE($berdasarkan,$hal,$propinsi,$kab,$jenjang);
		else
			$data['dafchannel'] = $this->M_channel->getStatistikAE($berdasarkan,$hal,$propinsi,$kab,$jenjang);

		$data['dafpropinsi'] = $this->M_channel->getPropinsiAll();
		$data['dafkota'] = $this->M_channel->getKota($propinsi);
		$data['berdasarkan'] = $berdasarkan;
		$data['hal'] = $hal;
		$data['prop'] = $propinsi;
		$data['kab'] = $kab;
		$data['jenjang'] = $jenjang;

		$this->load->view('layout/wrapper3', $data);
	}

	public function updatejenjang_dafchnsekolah()
	{
		$this->load->model("M_channel");
		$chnsekolah = $this->M_channel->getchnsekolah();
					$data2 = array();
					$baris=1;
		//echo $this->M_channel->getidjenjangdafsekolah('40102731');
		//$cek = $this->M_channel->getidjenjangdafsekolah(null);
		//echo $cek;
		foreach ($chnsekolah as $row) {
			$cek = $this->M_channel->getidjenjangdafsekolah($row->npsn);
			if ($cek>0)
			{
				echo $baris." ".$cek."<br>";
				if ($cek==20) //pt
					$jenjang = 6;
				else if ($cek==19) //ponpes
					$jenjang = 8;
				else if ($cek==18) //pkbm
					$jenjang = 7;
				else if ($cek==17) //kursus
					$jenjang = 7;
				else if ($cek==16) //smalb
					$jenjang = 9;
				else if ($cek==15) //smk
					$jenjang = 5;
				else if ($cek==14) //sma
					$jenjang = 4;
				else if ($cek==13) //smptp
					$jenjang = 9;
				else if ($cek==12) //smplb
					$jenjang = 9;
				else if ($cek==11) //smp
					$jenjang = 3;
				else if ($cek==10) //skh
					$jenjang = 9;
				else if ($cek==9) //sdlb
					$jenjang = 9;
				else if ($cek==8) //sd
					$jenjang = 2;
				else if ($cek==7 || $cek==5) //tk
					$jenjang = 1;
				else if ($cek==6) //tklb
					$jenjang = 9;
				else if ($cek==4 || $cek==3 || $cek==1) //paud
					$jenjang = 1;

				$data2[$baris]['idjenjang'] = $jenjang;
				$data2[$baris]['npsn'] = $row->npsn;
				$baris++;
			}
		}
		$this->M_channel->updatejenjangchnsekolah($data2);
	}
}

?>
