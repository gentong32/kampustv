<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finance extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_finance");
		$this->load->model("M_agency");
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->helper('tanggalan');

		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}
		if ($this->session->userdata('a01') || $this->session->userdata('email')=="cfo@tvsekolah.id") {
			//
		} else {
			redirect('/');
		}

		$this->load->helper(array('Form', 'Cookie', 'download', 'payment'));
	}

	public function index()
	{
		$this->transaksi_ikhtisar();
	}

	public function transaksi_ikhtisar($bulan=null,$tahun=null)
	{
		$data = array();
		$data['konten'] = 'v_finance_ikhtisar';

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$data['tahunsekarang'] = $datesekarang->format("Y");

		if ($bulan==null) {
			$bulan = $datesekarang->format("m");
			$tahun = $datesekarang->format("Y");
		}

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$data['daftransaksi'] = $this->M_finance->getTransaksiBesar($bulan,$tahun);

		
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function transaksi_detil($bulan=null,$tahun=null)
	{
		$data = array();
		$data['konten'] = 'v_finance_detil';

		$this->load->model('M_eksekusi');
		$data['standar'] = $this->M_eksekusi->getStandar();

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$data['tahunsekarang'] = $datesekarang->format("Y");

		if ($bulan==null) {
			$bulan = $datesekarang->format("m");
			$tahun = $datesekarang->format("Y");
		}

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$data['daftransaksi'] = $this->M_finance->getTransaksiDetil($bulan,$tahun);

		
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function transaksi_fee($bulan=null,$tahun=null)
	{
		$data = array();
		$data['konten'] = 'v_finance_fee';

		$this->load->model('M_eksekusi');
		$data['standar'] = $this->M_eksekusi->getStandar();

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$data['tahunsekarang'] = $datesekarang->format("Y");

		if ($bulan==null) {
			$bulan = $datesekarang->format("m");
			$tahun = $datesekarang->format("Y");
		}

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$data['daftransaksi'] = $this->M_finance->getTransaksiFee($bulan,$tahun);

		
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function transaksi_virtualkelas($bulan=null,$tahun=null)
	{
		$data = array();
		$data['konten'] = 'v_finance_transaksi';

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$data['tahunsekarang'] = $datesekarang->format("Y");

		if ($bulan==null) {
			$bulan = $datesekarang->format("n");
			$tahun = $datesekarang->format("Y");
		}

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$idagency = $this->session->userdata('id_user');
		$this->load->model("M_eksekusi");
		$hargastandar = $this->M_eksekusi->getStandar();
		$this->load->Model("M_login");
		$data['biayatarik'] = $hargastandar->biayatarik;
		$data['minimaltarik'] = $hargastandar->minimaltarik;
		$data['daftransaksi'] = $this->M_agency->getAllTransaksiKelasVirtual($bulan,$tahun);
		$data['daftransaksi2'] = $this->M_agency->getAllTransaksiIuranSekolah($bulan,$tahun);
		$data['getuserdata'] = $this->M_login->getUser($idagency);
		//echo "<br><br><br><br><br><br><br><br><br><br><br>";
		//echo var_dump($data['daftransaksi']);
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function transaksi_sekolah($bulan=null,$tahun=null)
	{
		$data = array();
		$data['konten'] = 'v_finance_transaksi_premium';

		$this->load->model("M_eksekusi");
		$hargastandar = $this->M_eksekusi->getStandar();
		$this->load->Model("M_login");
		$data['biayatarik'] = $hargastandar->biayatarik;
		$data['minimaltarik'] = $hargastandar->minimaltarik;

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$data['tahunsekarang'] = $datesekarang->format("Y");

		if ($bulan==null) {
			$bulan = $datesekarang->format("n");
			$tahun = $datesekarang->format("Y");
		}

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['daftransaksi'] = $this->M_agency->getAllTransaksiIuranSekolah($bulan,$tahun);
		$data['daftransaksi2'] = $this->M_agency->getAllTransaksiKelasVirtual($bulan,$tahun);

//		echo "<pre>";
//		echo var_dump($data['daftransaksi']);
//		echo "</pre>";
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function transaksi_siplah($bulan=null,$tahun=null)
	{
		$data = array();
		$data['konten'] = 'v_finance_unggah_siplah';

		$data['daftransaksi'] = $this->M_agency->getAllUnggahSiplah();


//		echo "<pre>";
//		echo var_dump($data['daftransaksi']);
//		echo "</pre>";
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function konfirmasi_siplah($kodesiplah)
	{
		$data = array();
		$data['konten'] = 'v_finance_konfirmasi_siplah';

		$this->load->model("M_eksekusi");
		$hargastandar = $this->M_eksekusi->getStandar();
		$this->load->Model("M_login");
		$data['biayatarik'] = $hargastandar->biayatarik;
		$data['minimaltarik'] = $hargastandar->minimaltarik;

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$data['tahunsekarang'] = $datesekarang->format("Y");

		$data['transaksi'] = $this->M_agency->getAllUnggahSiplah($kodesiplah);

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function updatekonfirmasi()
	{
		$data = array();
		$data2 = array();

		$iduser = $this->input->post('iduser');
		$npsnuser = $this->input->post('npsnuser');
		$kodesiplah = $this->input->post('kodesiplah');
		$itanggal = $this->input->post('itanggal');
		$itanggal = str_pad($itanggal, 2, '0', STR_PAD_LEFT);
		$ibulan = $this->input->post('ibulan');
		$ibulan = str_pad($ibulan, 2, '0', STR_PAD_LEFT);
		$itahun = $this->input->post('itahun');
		$ilamabulan = $this->input->post('ilamabulan');
		$strata = $this->input->post('istrata');
		$iuran = $this->input->post('isejumlah');
		$iuran = (int) filter_var($iuran, FILTER_SANITIZE_NUMBER_INT);
		$konfirmasi = $this->input->post('konfirmasi');
		$pilihankonfirm = $this->input->post('pilihankonfirm');

		$tglskr = new DateTime();
		$tglskr->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglskr = $tglskr->format("Y-m-d H:i:s");
		$mulaibulan = new DateTime($itahun."-".$ibulan."-".$itanggal);
		$mulaibulan = $mulaibulan->format("Y-m-d");
		$mulaibulan2 = new DateTime($itahun."-".$ibulan."-".$itanggal);
		$mulaibulan2 = $mulaibulan2->format("Y-m-t 00:00:00");
		$batasbulan = new DateTime($itahun."-".$ibulan."-01");
		$batasbulan->setTimezone(new DateTimezone('Asia/Jakarta'));
		$batasbulan = $batasbulan->modify('+'.($ilamabulan-1).' month');
		$batasbulan = $batasbulan->format("Y-m-t 23:59:59");
		$batas7hari = new DateTime($itahun."-".$ibulan."-".$itanggal);
		$batas7hari = $batas7hari->modify('+7 day');
		$batas7hari = $batas7hari->format("Y-m-d 23:59:59");


		if ($strata==1)
			$kodeawal = "TVS";
		else if ($strata==2)
			$kodeawal = "TP2";
		else if ($strata==3)
			$kodeawal = "TF2";

		$kode = $kodeawal."-".$kodesiplah;

		$data['iduser'] = $iduser;
		$data['npsn_sekolah'] = $npsnuser;
		$data['order_id'] = $kode;
		$data['tgl_order'] = $tglskr;
		$data['tgl_bayar'] = $mulaibulan;
		$data['tipebayar'] = "SIPLAH";
		$data['iuran'] = $iuran;
		$data['status'] = 3;
		

		$this->load->Model('M_payment');
		if ($pilihankonfirm==1) {
			if ($konfirmasi == 1) //KONFIRMASI SURAT PESANAN OK
			{
				$data2['tgl_mulai'] = $mulaibulan;
				$data2['tgl_berakhir'] = $batasbulan;
				$data2['tgl_konfirmasi'] = $tglskr;
				$data2['tgl_berakhir_s'] = $batas7hari;
				$data2['lamabulan'] = $ilamabulan;
				$data2['iuran'] = $iuran;
				$data2['strata'] = $strata;
				$data2['token'] = rand(1000000001, 9999999999);
				$data2["konfirmasi"] = 2;
				$this->M_payment->update_siplah($kodesiplah,$data2);
				//$this->M_payment->addDonasi($data);
				
			}
			else if ($konfirmasi == 4) //KONFIRMASI SUDAH DIAKTIFASI DAN UANG SUDAH MASUK
			{
				//$this->M_payment->addDonasi($data);
				
				$data['tgl_berakhir'] = $batasbulan;
				$this->M_payment->update_payment($data, $iduser, $kode);
				hitungfeeiuran($kode);
				$data2["konfirmasi"] = 5;
				$data2['tgl_konfirmasi'] = $tglskr;
				$this->M_payment->update_siplah($kodesiplah,$data2);
			
			}
			
		}
		else
		{
			if ($konfirmasi == 1 || $konfirmasi == 2) //KONFIRMASI SURAT PESANAN TIDAK OK
			{
				$data2["konfirmasi"] = 3;
				$data2['tgl_konfirmasi'] = $tglskr;
				$this->M_payment->update_siplah($kodesiplah,$data2);
			}
			else if ($konfirmasi == 5) //KONFIRMASI SUDAH DIAKTIFASI DAN DIBATALIN UANG MASUKNYA
			{
				//$this->M_payment->delete_payment($kode);
				$data2["konfirmasi"] = 4;
				$data2['tgl_konfirmasi'] = $tglskr;
				$this->M_payment->update_siplah($kodesiplah,$data2);
				$data['tgl_berakhir'] = $batas7hari;
				$this->M_payment->update_payment($data, $iduser, $kode);
			}
			
			
			
		}

		$this->M_payment->updateKonfirmSiplah();

		redirect("/finance/transaksi_siplah");

	}

	public function pindahkan($bulan,$tahun,$status)
	{
		$perintah = $this->M_agency->updateTransaksiPindah($bulan,$tahun,$status);
		if ($perintah)
			echo "oke";
		else
			echo "gagal";
	}

	
}
