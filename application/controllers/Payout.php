<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payout extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_induk");
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->helper('url');
		$this->load->helper(array('Form', 'Cookie'));
	}

	public function index()
	{

		$this->ceksaldo();

	}

	public function ceksaldo()
	{

		$curl = curl_init();

		if (base_url() == "https://tutormedia.net/tvsekolahbaru/" || base_url() == "https://tvsekolah.id/"
			|| base_url() == "http://localhost/tvsekolah2/" || $this->session->userdata('npsn') == "1234567890" || $this->session->userdata('npsn') == "1234567891") {

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://app.sandbox.midtrans.com/iris/api/v1/balance',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: Basic SVJJUy1mNmM1NGM0ZC1mZDNlLTQ0ZDUtOWRiMy03MjRlYTIyYzEwZTM6IzFfaVIxNVA0JCRfNGRtMW4='
				),
			));
		} else {
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://app.midtrans.com/iris/api/v1/balance',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: Basic SVJJUy00MWE0NDFiNy0xZjUwLTRlMDAtYTlmNi1kYjk0MDliZDQ3YTk6aTEyMSRfdHZzM0swbDQj'
				),
			));
		}

		$response = curl_exec($curl);

		curl_close($curl);
		$hasil = json_decode($response, true);
		echo $hasil['balance'];

	}

	public function validasibank($namabank, $accnumbner)
	{
		$curl = curl_init();

		if (base_url() == "https://tutormedia.net/tvsekolahbaru/" || base_url() == "http://localhost/tvsekolah2/"
			|| base_url() == "https://tvsekolah.id/" || $this->session->userdata('npsn') == "1234567890" || $this->session->userdata('npsn') == "1234567891") {
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://app.sandbox.midtrans.com/iris/api/v1/account_validation?bank=' .
					$namabank . '&account=' . $accnumbner,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: Basic SVJJUy1mNmM1NGM0ZC1mZDNlLTQ0ZDUtOWRiMy03MjRlYTIyYzEwZTM6IzFfaVIxNVA0JCRfNGRtMW4='
				),
			));
		} else {

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://app.midtrans.com/iris/api/v1/account_validation?bank=' .
					$namabank . '&account=' . $accnumbner,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: Basic SVJJUy00MWE0NDFiNy0xZjUwLTRlMDAtYTlmNi1kYjk0MDliZDQ3YTk6aTEyMSRfdHZzM0swbDQj'
				),
			));
		}

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
		$hasil = json_decode($response, true);
		if (isset($hasil['account_name']))
			echo $hasil['account_name'];
		else
			echo "nomor tidak valid";
	}

	public function updatebank($namabank, $accnumbner)
	{
		$curl = curl_init();

		if (base_url() == "https://tutormedia.net/tvsekolahbaru/" || base_url() == "http://localhost/tvsekolah2/"
			|| base_url() == "https://tvsekolah.id/" || $this->session->userdata('npsn') == "1234567890" || $this->session->userdata('npsn') == "1234567891") {
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://app.sandbox.midtrans.com/iris/api/v1/account_validation?bank=' .
					$namabank . '&account=' . $accnumbner,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: Basic SVJJUy1mNmM1NGM0ZC1mZDNlLTQ0ZDUtOWRiMy03MjRlYTIyYzEwZTM6IzFfaVIxNVA0JCRfNGRtMW4='
				),
			));
		} else {

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://app.midtrans.com/iris/api/v1/account_validation?bank=' .
					$namabank . '&account=' . $accnumbner,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: Basic SVJJUy00MWE0NDFiNy0xZjUwLTRlMDAtYTlmNi1kYjk0MDliZDQ3YTk6aTEyMSRfdHZzM0swbDQj'
				),
			));

		}

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
		$hasil = json_decode($response, true);
		if (isset($hasil['account_name'])) {
			$nama = $hasil['account_name'];
			$data = array(
				'bank' => $namabank,
				'rek' => $accnumbner,
				'nama_rek' => $nama
			);
			$this->load->model('M_login');
			$this->M_login->activate($data, $this->session->userdata('id_user'));
			echo "sukses";
		} else
			echo "gagal";
	}

	public function request_bank_transaction()
	{
		$idam = $this->session->userdata('id_user');

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $datesekarang->format('d');
		$datesekarang->modify('first day of this month');
		$datesekarang->modify('-1 month');
		$batasbulankemarin = $datesekarang->modify('+14 days');

		if ($tglsekarang < 20) {
			$batasbulankemarin = $datesekarang->modify('-1 month');
		}

		$this->load->model('M_marketing');
		$daftarvideo = $this->M_marketing->getTransaksi($idam);
		$data2 = array();
		$baris = 0;
		$jmlproses = 0;
		$jmltarik = 0;
		foreach ($daftarvideo as $row) {
			$bersih = floor($row->total_net);
			if ($row->status_am == 1 && $row->siapambil==2) {
				$jmltarik = $jmltarik + $bersih;
				$baris++;
				$data2[$baris]['status_am'] = 2;
				$data2[$baris]['kode_beli'] = $row->kode_beli;
			} else if ($row->status_am == 2) {
				$jmlproses++;
			}
		}

		$this->load->model('M_eksekusi');
		$hargastandar = $this->M_eksekusi->getStandar();
		$minimaltarik = $hargastandar->minimaltarik;

		if ($jmltarik >= $minimaltarik) {
			$this->load->Model("M_login");
			$useragency = $this->M_login->getUser($idam);
			$namarek = $useragency['nama_rek'];
			$norek = $useragency['rek'];
			$bank = $useragency['bank'];
			$email = $useragency['email'];
			$notes = "Fee Kelas Virtual AM";
			$hasilpayout = $this->create_payout($jmltarik,$namarek,$norek,$bank,$email,$notes);
			//echo "HASILPAYOUT".$hasilpayout;
			if ($hasilpayout == "sukses") {
				$this->load->model('M_payout');
				$this->M_payout->UpdateAllStatusTransaksi($data2);
				echo "ok";
			}
		} else {
			echo "onproses";
		}

	}

	public function request_bank_transaction_premium()
	{
		$idam = $this->session->userdata('id_user');

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $datesekarang->format('d');
		$datesekarang->modify('first day of this month');
		$datesekarang->modify('-1 month');
		$batasbulankemarin = $datesekarang->modify('+14 days');

		if ($tglsekarang < 20) {
			$batasbulankemarin = $datesekarang->modify('-1 month');
		}

		$this->load->model('M_marketing');
		$daftarvideo = $this->M_marketing->getTransaksiPremium($idam);
		$this->load->model('M_eksekusi');
		$standar = $this->M_eksekusi->getStandar();
		$persenfeeam = $standar->fee_am;

		$this->load->model("M_payment");
		$standar = $this->M_payment->getstandar();

		$data2 = array();
		$baris = 0;
		$jmlproses = 0;
		$jmltarik = 0;
		foreach ($daftarvideo as $row) {
			$kotor = floor($row->fee_siam);
			$pph = ceil($kotor * $persenfeeam / 100);
			$bersih = $kotor - $pph;
			if ($row->status_siam == 1 && $row->siapambil==2) {
				$jmltarik = $jmltarik + $bersih;
				$baris++;
				$data2[$baris]['status_siam'] = 2;
				$data2[$baris]['order_id'] = $row->order_id;
			} else if ($row->status_siam == 2) {
				$jmlproses++;
			}
		}

		$this->load->model('M_eksekusi');
		$hargastandar = $this->M_eksekusi->getStandar();
		$minimaltarik = $hargastandar->minimaltarik;


		if ($jmltarik >= $minimaltarik) {

			$this->load->Model("M_login");
			$useragency = $this->M_login->getUser($idam);
			$namarek = $useragency['nama_rek'];
			$norek = $useragency['rek'];
			$bank = $useragency['bank'];
			$email = $useragency['email'];
			$notes = "Fee Pembayaran Sekolah AM";

			$hasilpayout = $this->create_payout($jmltarik,$namarek,$norek,$bank,$email,$notes);
			//echo "HASILPAYOUT".$hasilpayout;
			if ($hasilpayout == "sukses") {
				$this->load->model('M_payout');
				$this->M_payout->UpdateAllStatusTransaksiPayment($data2);
				echo "ok";
			}
		} else {
			echo "onproses";
		}

	}

	public function request_bank_transaction_ae()
	{
		$idae = $this->session->userdata('id_user');

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $datesekarang->format('d');
		$datesekarang->modify('first day of this month');
		$datesekarang->modify('-1 month');
		$batasbulankemarin = $datesekarang->modify('+14 days');

		if ($tglsekarang < 20) {
			$batasbulankemarin = $datesekarang->modify('-1 month');
		}

		$this->load->model("M_eksekusi");
		$daftransaksi = $this->M_eksekusi->getTransaksi($idae);

//		echo "<pre>";
//		echo var_dump($daftransaksi);
//		echo "</pre>";

		$data2 = array();
		$baris = 0;
		$jmlproses = 0;
		$jmltarik = 0;
		foreach ($daftransaksi as $row) {
			$bersih = floor($row->fee_ae);
			//echo "TGL:".$row->tanggal."<br>";
			if ($row->status_fee == 1 && new DateTime($row->tanggal) < $batasbulankemarin) {
				$jmltarik = $jmltarik + $bersih;
				$baris++;
				$data2[$baris]['status_fee'] = 2;
				$data2[$baris]['order_id'] = $row->kode_order;
				//echo "==========".$row->kode_order."<br>";
			} else if ($row->status_fee == 2) {
				$jmlproses++;
			}
		}

		//echo "TANGGAL:".$batasbulankemarin->format("d-m-Y");
		//echo "jmlproses:".$jmlproses;

		$this->load->model('M_eksekusi');
		$hargastandar = $this->M_eksekusi->getStandar();
		$minimaltarik = $hargastandar->minimaltarik;

		if ($jmltarik >= $minimaltarik) {
			$hasilpayout = $this->create_payout($jmltarik);
			//echo "HASILPAYOUT".$hasilpayout;
			if ($hasilpayout == "sukses") {
				//echo "cihuy";
				$this->load->model('M_payout');
				$this->M_payout->UpdateAllStatusTransaksiAe($data2);
				echo "ok";
				//echo "HOREHASILPAYOUT".$hasilpayout;
			}
		} else {
			echo "onproses";
		}

	}

	public function request_bank_transaction_ag()
	{
		$idag = $this->session->userdata('id_user');

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $datesekarang->format('d');
		$datesekarang->modify('first day of this month');
		$datesekarang->modify('-1 month');
		$batasbulankemarin = $datesekarang->modify('+14 days');

		if ($tglsekarang < 20) {
			$batasbulankemarin = $datesekarang->modify('-1 month');
		}

		$this->load->model('M_agency');
		$daftarvideo = $this->M_agency->getTransaksi($idag);
		$data2 = array();
		$baris = 0;
		$jmlproses = 0;
		$jmltarik = 0;

//				echo "<pre>";
//		echo var_dump($daftarvideo);
//		echo "</pre>";

		foreach ($daftarvideo as $row) {
			$bersih = floor($row->total_net);
			if ($row->status_ag == 1 && $row->siapambil==2) {
				$jmltarik = $jmltarik + $bersih;
				$baris++;
				$data2[$baris]['status_ag'] = 2;
				$data2[$baris]['kode_beli'] = $row->kode_beli;
			} else if ($row->status_ag == 2) {
				$jmlproses++;
			}
		}

		$this->load->model('M_eksekusi');
		$hargastandar = $this->M_eksekusi->getStandar();
		$minimaltarik = $hargastandar->minimaltarik;

		if ($jmltarik >= $minimaltarik) {
			$this->load->Model("M_login");
			$useragency = $this->M_login->getUser($idag);
			$namarek = $useragency['nama_rek'];
			$norek = $useragency['rek'];
			$bank = $useragency['bank'];
			$email = $useragency['email'];
			$notes = "Fee Kelas Virtual Agency";

			$hasilpayout = $this->create_payout($jmltarik,$namarek,$norek,$bank,$email,$notes);
			//echo "HASILPAYOUT".$hasilpayout;
			if ($hasilpayout == "sukses") {
				$this->load->model('M_payout');
				$this->M_payout->UpdateAllStatusTransaksi($data2);
				echo "ok";
			}
		} else {
			echo "onproses";
		}

	}

	public function request_bank_transaction_premium_ag()
	{
		$idag = $this->session->userdata('id_user');

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $datesekarang->format('d');
		$datesekarang->modify('first day of this month');
		$datesekarang->modify('-1 month');
		$batasbulankemarin = $datesekarang->modify('+14 days');

		if ($tglsekarang < 20) {
			$batasbulankemarin = $datesekarang->modify('-1 month');
		}

		$this->load->model('M_eksekusi');
		$hargastandar = $this->M_eksekusi->getStandar();
		$this->load->Model("M_login");
		$useragency = $this->M_login->getUser($idag);
		$ceknpwp = $useragency['npwp'];
		if ($ceknpwp==null ||$ceknpwp=="-")
			$pphagency = $hargastandar->pph;
		else
			$pphagency = $hargastandar->pph_npwp;

		$this->load->model('M_agency');
		$daftarvideo = $this->M_agency->getTransaksiPremium($idag);

//		echo "<pre>";
//		echo var_dump($daftarvideo);
//		echo "</pre>";

		$data2 = array();
		$baris = 0;
		$jmlproses = 0;
		$jmltarik = 0;
		foreach ($daftarvideo as $row) {
			$kotor = floor($row->fee_agency);
			$pph = ceil($row->fee_agency*$pphagency/100);
			$bersih = $kotor - $pph;
			//echo $baris."->".$bersih."<br>";
			//echo "statusagency:".$row->status_agency;

			if ($row->status_agency == 1 && $row->siapambil==2) {
				$jmltarik = $jmltarik + $bersih;
				$baris++;
				$data2[$baris]['status_agency'] = 2;
				$data2[$baris]['order_id'] = $row->order_id;

			} else if ($row->status_agency == 2) {
				$jmlproses++;
			}
		}

		$this->load->model('M_eksekusi');
		$hargastandar = $this->M_eksekusi->getStandar();
		$minimaltarik = $hargastandar->minimaltarik;

//		echo "minimal:".$minimaltarik;
//		echo "<br>jml:".$jmltarik;
//		die();

		if ($jmltarik >= $minimaltarik) {
			$this->load->Model("M_login");
			$useragency = $this->M_login->getUser($idag);
			$namarek = $useragency['nama_rek'];
			$norek = $useragency['rek'];
			$bank = $useragency['bank'];
			$email = $useragency['email'];
			$notes = "Fee Pembayaran Sekolah Agency";

			$hasilpayout = $this->create_payout($jmltarik,$namarek,$norek,$bank,$email,$notes);
			//echo "HASILPAYOUT".$hasilpayout;
			if ($hasilpayout == "sukses") {
				$this->load->model('M_payout');
				$this->M_payout->UpdateAllStatusTransaksiPayment($data2);
				echo "ok";
			}
		} else {
			echo "onproses";
		}

	}

	public function request_bank_transaction_kontri()
	{
		$idkontri = $this->session->userdata('id_user');

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $datesekarang->format('d');
		$datesekarang->modify('first day of this month');
		$datesekarang->modify('-1 month');
		$batasbulankemarin = $datesekarang->modify('+14 days');

		if ($tglsekarang < 20) {
			$batasbulankemarin = $datesekarang->modify('-1 month');
		}

		$this->load->model('M_tutor');
		$daftarvideo = $this->M_tutor->getTransaksi($idkontri);
		$data2 = array();
		$baris = 0;
		$jmlproses = 0;
		$jmltarik = 0;
		foreach ($daftarvideo as $row) {
			$bersih = floor($row->total_net);
			if ($row->status_kontri == 1 && new DateTime($row->tgl_beli) < $batasbulankemarin) {
				$jmltarik = $jmltarik + $bersih;
				$baris++;
				$data2[$baris]['status_kontri'] = 2;
				$data2[$baris]['kode_beli'] = $row->kode_beli;
			} else if ($row->status_kontri == 2) {
				$jmlproses++;
			}
		}

		if ($jmltarik >= 1000000) {
			$hasilpayout = $this->create_payout($jmltarik);
			//echo "HASILPAYOUT".$hasilpayout;
			if ($hasilpayout == "sukses") {
				$this->load->model('M_payout');
				$this->M_payout->UpdateAllStatusTransaksi($data2);
				echo "ok";
			}
		} else {
			echo "onproses";
		}

	}

	public function request_bank_transaction_ver()
	{
		$idkontri = $this->session->userdata('id_user');

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $datesekarang->format('d');
		$datesekarang->modify('first day of this month');
		$datesekarang->modify('-1 month');
		$batasbulankemarin = $datesekarang->modify('+14 days');

		if ($tglsekarang < 20) {
			$batasbulankemarin = $datesekarang->modify('-1 month');
		}

		$this->load->model('M_tutor');
		$daftarvideo = $this->M_tutor->getTransaksiVerifikator($idkontri);
		$data2 = array();
		$baris = 0;
		$jmlproses = 0;
		$jmltarik = 0;
		foreach ($daftarvideo as $row) {
			$bersih = floor($row->total_net);
			if ($row->status_ver == 1 && new DateTime($row->tgl_beli) < $batasbulankemarin) {
				$jmltarik = $jmltarik + $bersih;
				$baris++;
				$data2[$baris]['status_ver'] = 2;
				$data2[$baris]['kode_beli'] = $row->kode_beli;
			} else if ($row->status_ver == 2) {
				$jmlproses++;
			}
		}

		if ($jmltarik >= 1000000) {
			$hasilpayout = $this->create_payout($jmltarik);
			//echo "HASILPAYOUT".$hasilpayout;
			if ($hasilpayout == "sukses") {
				$this->load->model('M_payout');
				$this->M_payout->UpdateAllStatusTransaksi($data2);
				echo "ok";
			}
		} else {
			echo "onproses";
		}

	}

	private function create_payout($jumlah,$namarek,$norek,$bank,$email,$notes)
	{
		$curl = curl_init();

		if (base_url() == "https://tutormedia.net/tvsekolahbaru/" || base_url() == "http://localhost/tvsekolah2/"
			|| base_url() == "https://tvsekolah.id/" || $this->session->userdata('npsn') == "1234567890" || $this->session->userdata('npsn') == "1234567891") {
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://app.sandbox.midtrans.com/iris/api/v1/payouts',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => '{
  "payouts": [
    {
      "beneficiary_name": "' . $namarek . '",
      "beneficiary_account": "' . $norek . '",
      "beneficiary_bank": "' . $bank . '",
      "beneficiary_email": "' . $email . '",
      "amount": "' . $jumlah . '",
      "notes": "' . $notes . '"
    }
  ]
}',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: Basic SVJJUy1mNmM1NGM0ZC1mZDNlLTQ0ZDUtOWRiMy03MjRlYTIyYzEwZTM6IzFfaVIxNVA0JCRfNGRtMW4='
				),
			));

		} else {
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://app.midtrans.com/iris/api/v1/payouts',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => '{
  "payouts": [
    {
      "beneficiary_name": "' . $namarek . '",
      "beneficiary_account": "' . $norek . '",
      "beneficiary_bank": "' . $bank . '",
      "beneficiary_email": "' . $email . '",
      "amount": "' . $jumlah . '",
      "notes": "' . $notes . '"
    }
  ]
}',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: Basic SVJJUy00MWE0NDFiNy0xZjUwLTRlMDAtYTlmNi1kYjk0MDliZDQ3YTk6aTEyMSRfdHZzM0swbDQj'
				),
			));
		}

		$response = curl_exec($curl);

		curl_close($curl);
		//echo $response;

		$hasil = json_decode($response, true);
		if (isset($hasil['payouts'])) {
			foreach ($hasil as $key => $value) {
				foreach ($value as $value2) {
					$noref = $value2['reference_no'];
				}
			}
			$approved = $this->approve_payout($noref);
			if ($approved == "berhasil")
				return "sukses";
			else
				return "gagal";
		} else
			return "gagal";
	}

	private function create_payout_ae($jumlah)
	{
		$curl = curl_init();

		if (base_url() == "https://tutormedia.net/tvsekolahbaru/" || base_url() == "http://localhost/tvsekolah2/"
			|| base_url() == "https://tvsekolah.id/" || $this->session->userdata('npsn') == "1234567890" || $this->session->userdata('npsn') == "1234567891") {
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://app.sandbox.midtrans.com/iris/api/v1/payouts',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => '{
  "payouts": [
    {
      "beneficiary_name": "Permata Simulator A",
      "beneficiary_account": "4111911431",
      "beneficiary_bank": "permata",
      "beneficiary_email": "calonam@jimail.kom",
      "amount": "' . $jumlah . '",
      "notes": "Fee AM per Mei 2021"
    }
  ]
}',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: Basic SVJJUy1mNmM1NGM0ZC1mZDNlLTQ0ZDUtOWRiMy03MjRlYTIyYzEwZTM6IzFfaVIxNVA0JCRfNGRtMW4='
				),
			));
		}
		else
		{
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://app.midtrans.com/iris/api/v1/payouts',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => '{
  "payouts": [
    {
      "beneficiary_name": "Permata Simulator A",
      "beneficiary_account": "4111911431",
      "beneficiary_bank": "permata",
      "beneficiary_email": "calonam@jimail.kom",
      "amount": "' . $jumlah . '",
      "notes": "Fee AM per Mei 2021"
    }
  ]
}',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: Basic SVJJUy00MWE0NDFiNy0xZjUwLTRlMDAtYTlmNi1kYjk0MDliZDQ3YTk6aTEyMSRfdHZzM0swbDQj'
				),
			));
		}

		$response = curl_exec($curl);

		curl_close($curl);
		//echo $response;

		$hasil = json_decode($response, true);
		if (isset($hasil['payouts'])) {
			foreach ($hasil as $key => $value) {
				foreach ($value as $value2) {
					$noref = $value2['reference_no'];
				}
			}
			$approved = $this->approve_payout($noref);
			if ($approved == "berhasil")
				return "sukses";
			else
				return "gagal";
		} else {
			return "gagal";
		}
	}

	private function approve_payout($noref)
	{
		$curl = curl_init();

		if (base_url() == "https://tutormedia.net/tvsekolahbaru/" || base_url() == "http://localhost/tvsekolah2/"
			|| base_url() == "https://tvsekolah.id/" || $this->session->userdata('npsn') == "1234567890" || $this->session->userdata('npsn') == "1234567891") {
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://app.sandbox.midtrans.com/iris/api/v1/payouts/approve',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => '{
  "reference_nos": ["' . $noref . '"]
}',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: Basic SVJJUy1lOWE1YjY2NS0yN2ZiLTRjY2EtYjg1Ny1hNzgxODU1YTQwZDc6IzJfaVIxNWYxTmFuYzM='
				),
			));
		}
		else
		{
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://app.midtrans.com/iris/api/v1/payouts/approve',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => '{
  "reference_nos": ["' . $noref . '"]
}',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: Basic SVJJUy04ZmEwOWU4Ny02ZTkzLTQyNGQtYjAxOS1lMDUxZmY5MGIxNTA6IzJfYXBwUjB2M3JAdHZTZWtvbDRo'
				),
			));
		}

		$response = curl_exec($curl);

		curl_close($curl);
		//echo $response;
		$hasil = json_decode($response, true);
		if (isset($hasil['status']))
		{
			if ($hasil['status'] == "ok")
				return "berhasil";
			else
				return "gagal";
		}
		else if (isset($hasil['error_message'])) {
			return "gagal";
		}
		else
			return "gagal";
		//echo "";
	}
}
