<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mou extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_induk');
		$this->load->model('M_mou');
		$this->load->model('M_login');
		$this->load->helper(array('Form', 'Cookie', 'String', 'captcha', 'download'));
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->library('pagination');
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}

		if (!$this->session->userdata('activate'))
			redirect('/login/profile');
		//|| !$this->session->userdata('bimbel') == 1
	}

	public function index()
	{
		if ($this->is_connected()) {
			$npsn=$this->session->userdata('npsn');
			$getmou = $this->M_mou->getKodeMOU($npsn);
			$cekkodemou = "";
			if ($getmou)
				$cekkodemou = $getmou[0]->kode_referal;

			if ($this->session->userdata('loggedIn') && $cekkodemou=="") {
				redirect("/mou/input_mou");
			} else {
				redirect("/mou/pilih_paket");
			}
		} else {
			echo "SAMBUNGAN INTERNET TIDAK TERSEDIA";
			//$this->menujujenjang();
		}
	}

	public function is_connected($sCheckHost = 'www.google.com')
	{
		return (bool)@fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
	}

	public function input_mou()
	{
		if ($this->session->userdata("mou")<=1) {
			$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_mou_inputref');

			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			$this->load->view('layout/wrapper2', $data);
		}
		else
		{
			redirect("/payment/pembayaran");
		}

	}

	public function cekkoderef()
	{
		$koderef = $this->input->post('koderef');
		if ($this->M_mou->cekkoderefag($koderef))
		{
			$this->session->set_userdata('mou', 1);
			echo "OK";
		}
		else
		{
			$getam = $this->M_mou->cekkoderefam($koderef);
			if ($getam)
			{
				$idam = $getam->id_siam;
				$this->M_mou->addmoumarketing($idam, $koderef);
				$this->session->set_userdata('mou', true);
				echo "OK";
			}
			else
			{
				$this->session->unset_userdata('mou');
				echo "kosong";
			}
		}
	}

	public function pilih_paket()
	{
		if ($this->session->userdata("mou")<=1) {
			$this->load->model('M_mou');
			$data = array('title' => 'Pilih Paket', 'menuaktif' => '',
				'isi' => 'v_mou_belipaket');

			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			$this->load->view('layout/wrapperpayment', $data);
		}
		else
		{
			redirect("/mou/input_mou");
		}
	}

	public function detil_paket($indeks)
	{
		if ($this->session->userdata("mou")==1) {
			$this->load->model('M_mou');
			$data = array('title' => 'Detil Paket', 'menuaktif' => '',
				'isi' => 'v_mou_detilpaket');

			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();
			$data['indeks'] = $indeks;

			$this->load->view('layout/wrapperpayment', $data);
		}
		else
		{
			redirect("/mou/input_mou");
		}
	}

	public function setuju_paket()
	{
		$indeks = $this->input->post('indeks');
		if ($this->session->userdata("mou")<=1) {
			$triwulan1 = new DateTime("");
			$triwulan1->setTimezone(new DateTimezone('Asia/Jakarta'));
			$triwulan2 = new DateTime("");
			$triwulan2->setTimezone(new DateTimezone('Asia/Jakarta'));
			$triwulan3 = new DateTime("");
			$triwulan3->setTimezone(new DateTimezone('Asia/Jakarta'));
			$triwulan4 = new DateTime("");
			$triwulan4->setTimezone(new DateTimezone('Asia/Jakarta'));
			$triwulan1 = $triwulan1->modify("+2 months");
			$triwulan2 = $triwulan2->modify("+5 months");
			$triwulan3 = $triwulan3->modify("+8 months");
			$triwulan4 = $triwulan4->modify("+11 months");

			switch ($indeks) {
				case 1:
					$bayar1 = 900000;
					$bayar2 = 900000;
					$bayar3 = 0;
					$bayar4 = 0;
					break;
				case 2:
					$bayar1 = 900000;
					$bayar2 = 900000;
					$bayar3 = 900000;
					$bayar4 = 900000;
					break;
				case 3:
					$bayar1 = 1500000;
					$bayar2 = 1500000;
					$bayar3 = 0;
					$bayar4 = 0;
					break;

				default:
					$bayar1 = 1500000;
					$bayar2 = 1500000;
					$bayar3 = 1500000;
					$bayar4 = 1500000;
			}
			$this->load->model('M_mou');
			$mouaktif = $this->M_mou->cekmouaktif($this->session->userdata('npsn'),1);
			if ($mouaktif)
			{
				$idmou = $mouaktif->id;

				$tglsekarang = new DateTime("");
				$tglsekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

				$datamou = array ("pilihan_mou"=>$indeks,"tgl_mou_awal"=>$tglsekarang->format("y-m-d H:i"),
					"tgl_penagihan1"=>$triwulan1->format("y-m-d H:i"),"tagihan1"=>$bayar1,
					"tgl_penagihan2"=>$triwulan2->format("y-m-d H:i"),"tagihan2"=>$bayar2);
				if ($bayar3>0)
				{
					$datamou['tagihan3'] = $bayar3;
					$datamou['tgl_penagihan3'] = $triwulan3->format("y-m-d H:i");
				}

				if ($bayar4>0)
				{
					$datamou['tagihan4'] = $bayar4;
					$datamou['tgl_penagihan4'] = $triwulan4->format("y-m-d H:i");
				}


				$this->M_mou->updatedatamou($idmou,$datamou);
				$this->session->set_userdata('mou', "2");
				$this->session->set_userdata('a02', true);
				$this->session->set_userdata('statusbayar', 3);
				echo "OK";
			}
			else
			{
				echo "GAGAL";
			}
		}
		else
		{
			redirect("/mou/input_mou");
		}
	}

	public function bayar_paket($indeks)
	{
		if ($this->session->userdata("mou")==2) {
			$this->load->model('M_mou');
			$data = array('title' => 'Pilih Paket', 'menuaktif' => '',
				'isi' => 'v_mou_bayarpaket');

			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();


			$iduser = $this->session->userdata('id_user');

			$this->load->model('M_channel');
			$cekstatusbayar = $this->M_channel->getlast_kdbeli($iduser, 3);

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
					//echo "AMANNNN";
					$data['upgrade'] = "ya";
					$data['tstrata'] = $strstrata[$cekstatusbayar->strata_paket];
				} else {
					if ($statusbayar == 1) {
						if ($datesekarang > $batasorder) {
							$datax = array("status_beli" => 0);
							$this->M_payment->update_vk_beli($datax, $iduser, $cekstatusbayar->kode_beli);
						} else {
							$this->tunggubayar();
						}

					}
				}
			}

			$this->load->view('layout/wrapperpayment', $data);
		}
		else
		{
			redirect("/mou/input_mou");
		}
	}

}
