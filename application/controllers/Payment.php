<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_induk");
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->library('midtrans');
		$this->load->library('Pdf');
		if (base_url() == "https://tutormedia.net/tvsekolahbaru/" || base_url() == "http://localhost/fordorum/"
			|| base_url() == "http://localhost/tvsekolah/" || base_url() == "http://localhost/kampustv/"
			|| $this->session->userdata('npsn') == "1234567890" || $this->session->userdata('npsn') == "1234567891") {
			$params = array('server_key' => 'SB-Mid-server-dQDHk1T4KGhT9kh24H46iyV-', 'production' => false);
		} else {
			$params = array('server_key' => 'Mid-server-GCS0SuN6kT7cH0G5iTey_-Ct', 'production' => true);
		}

		$this->midtrans->config($params);
		$this->load->helper('url');
		$this->load->helper(array('Form', 'Cookie', 'payment', 'tanggalan'));
	}

	public function index()
	{
//		setcookie('basis', "informasi", time() + (86400), '/');
//		if ($this->session->userdata('loggedIn')) {
//			if ($this->session->userdata('activate') == 0)
//				redirect('/login/profile');
//			else
//				$this->iuran();
//		} else {
//			$this->iuran();
//		}
	}

	public function pembayaran()
	{
		if ($getmou = $this->cekmou()) {
			$data = array();
			$data['konten'] = "v_mou_tagihan";


			$data['tagihan'] = $getmou;
			$this->load->view('layout/wrapperpayment', $data);
		} else if ($this->session->userdata('loggedIn') && $this->session->userdata('verifikator') > 0) {
			$iduser = $this->session->userdata('id_user');

			$data = array();
			$data['konten'] = "v_bayar";

			$this->cekstatusverifikator();
			$standarbayar = $this->M_payment->getstandar();
			$data['iuran'] = $standarbayar->iuran;
			$data['reaktivasi'] = $standarbayar->reaktivasi;

			$this->load->view('layout/wrapper_payment', $data);
		}
	}

	private function cekmou()
	{
		$this->load->model('M_mou');
		$mouaktif = $this->M_mou->cekmouaktif($this->session->userdata('npsn'), 4);
		if ($mouaktif) {
			return $mouaktif;
		} else {
			return false;
		}
	}

	public function premium()
	{
		if ($this->session->userdata('loggedIn') && $this->session->userdata('verifikator') > 0) {
			$npsn = $this->session->userdata('npsn');

			$this->cekstatusverifikator();

			$data = array('title' => 'Pembayaran', 'menuaktif' => '0',
				'isi' => 'v_bayar_premium');

			$this->load->model('M_login');
			$cekSekolahTerdaftar = $this->M_login->getsekolah($npsn);
			$tgldaftar = new DateTime($cekSekolahTerdaftar[0]->created);
			$tglcek1 = $tgldaftar;
			$bataspromo1 = $tglcek1->modify("+12 months");
			$tglcek2 = $tgldaftar;
			$bataspromo2 = $tglcek2->modify("+24 months");
			$tanggalsekarang = new DateTime();
			$tanggalsekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$promoke = 0;
			if ($tanggalsekarang <= $bataspromo1) {
				$promoke = 1;
			} else if ($tanggalsekarang <= $bataspromo2) {
				$promoke = 2;
			}

//			if ($promoke>0)
//			{
//				echo "MASUK PROMO KE-".$promoke;
//			}
//			else
//				echo "NORMAL";
//			die();

			$standarbayar = $this->M_payment->getstandar();
			if ($promoke == 1) {
				$data['iuran1'] = $standarbayar->pro / 10;
				$data['iuran2'] = $standarbayar->premium / 10;
			} else if ($promoke == 2) {
				$data['iuran1'] = $standarbayar->pro / 10 * 4;
				$data['iuran2'] = $standarbayar->premium / 10 * 4;
			} else {
				$data['iuran1'] = $standarbayar->pro;
				$data['iuran2'] = $standarbayar->premium4;
			}

			$data['promoke'] = $promoke;

			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			$this->load->view('layout/wrapperpayment', $data);

		}
	}

	public function vk_premium()
	{
		if ($this->session->userdata('loggedIn') && $this->session->userdata('verifikator') > 0) {
			$npsn = $this->session->userdata('npsn');

			$this->cekstatusverifikator();

			$data = array('title' => 'Pembayaran', 'menuaktif' => '0',
				'isi' => 'v_bayar_vkpremium');

			$this->load->model('M_login');
			$cekSekolahTerdaftar = $this->M_login->getsekolah($npsn);
			$tgldaftar = new DateTime($cekSekolahTerdaftar[0]->created);
			$tglcek1 = $tgldaftar;
			$bataspromo1 = $tglcek1->modify("+12 months");
			$tglcek2 = $tgldaftar;
			$bataspromo2 = $tglcek2->modify("+24 months");
			$tanggalsekarang = new DateTime();
			$tanggalsekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$promoke = 0;
			if ($tanggalsekarang <= $bataspromo1) {
				$promoke = 1;
			} else if ($tanggalsekarang <= $bataspromo2) {
				$promoke = 2;
			}

//			if ($promoke>0)
//			{
//				echo "MASUK PROMO KE-".$promoke;
//			}
//			else
//				echo "NORMAL";
//			die();

			$standarbayar = $this->M_payment->getstandar();
			if ($promoke == 1) {
				$data['iuran1'] = $standarbayar->pro / 10;
				$data['iuran2'] = $standarbayar->premium / 10;
			} else if ($promoke == 2) {
				$data['iuran1'] = $standarbayar->pro / 10 * 4;
				$data['iuran2'] = $standarbayar->premium / 10 * 4;
			} else {
				$data['iuran1'] = $standarbayar->pro;
				$data['iuran2'] = $standarbayar->premium4;
			}

			$data['promoke'] = $promoke;

			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			$this->load->view('layout/wrapperpayment', $data);

		}
	}

	public function donasi()
	{
		if ($this->session->userdata('loggedIn')) {
			$this->load->model('M_payment');

			$cekdonasipending = $this->M_payment->getlastdonasi($this->session->userdata('id_user'), 1);
			if ($cekdonasipending) {
				redirect("/payment/infodonasi");
			} else {
				$data = array();
				$data['konten'] = 'v_donasi';

				$data['dafdonasi'] = $this->M_payment->getdonasipil();
			}
		} else {
			$data = array();
			$data['konten'] = 'v_donasi_login';
		}

		$this->load->view('layout/wrapper_payment', $data);
	}

	public function bayartenanki()
	{
		if ($this->session->userdata('loggedIn') && $this->session->userdata('verifikator') > 0) {
			$iduser = $this->session->userdata('id_user');
			$this->load->model('M_payment');
			$statusbayar = $this->M_payment->cekstatusbayar($iduser)->statusbayar;

			if ($statusbayar == 0) {
				$data = array('title' => 'Pembayaran', 'menuaktif' => '0',
					'isi' => 'v_bayar');

				$this->load->model("M_payment");
				$standar = $this->M_payment->getstandar();
				$iuran = $standar->iuran;
				$data['iuran'] = $iuran;
				$data['message'] = $this->session->flashdata('message');
				$data['authURL'] = $this->facebook->login_url();
				$data['loginURL'] = $this->google->loginURL();

				$this->load->view('layout/wrapperpayment', $data);
			} else if ($statusbayar == 1) {
				redirect("/payment/tunggubayar");
			} else
				redirect("/");

		} else {
			redirect("/");
		}
	}

	public function perpanjang()
	{
		$data = array('title' => 'Pembayaran', 'menuaktif' => '0',
			'isi' => 'v_perpanjang');

		$this->load->view('layout/wrapper3', $data);
	}

	public function token($pilihan)
	{
		if (!$this->session->userdata("loggedIn"))
			redirect("/");

		$batasbulanini = new DateTime();
		$batasbulanini->setTimezone(new DateTimezone('Asia/Jakarta'));
		$batas3bulan = new DateTime();
		$batas3bulan->setTimezone(new DateTimezone('Asia/Jakarta'));
		$batas6bulan = new DateTime();
		$batas6bulan->setTimezone(new DateTimezone('Asia/Jakarta'));
		$batas12bulan = new DateTime();
		$batas12bulan->setTimezone(new DateTimezone('Asia/Jakarta'));

		$batasbulanini = $batasbulanini->modify('first day of this month');
		$namabulanini = $batasbulanini->format('n');
		$batasbulanini = $batasbulanini->format("Y-m-t 23:59:59");

		$batas3bulan = $batas3bulan->modify('first day of this month');
		$batas3bulan = $batas3bulan->modify('+2 month');
		$nama3bulan = $batas3bulan->format('n');
		$batas3bulan = $batas3bulan->format("Y-m-t 23:59:59");

		$batas6bulan = $batas6bulan->modify('first day of this month');
		$batas6bulan = $batas6bulan->modify('+5 month');
		$nama6bulan = $batas6bulan->format('n');
		$batas6bulan = $batas6bulan->format("Y-m-t 23:59:59");

		$batas12bulan = $batas12bulan->modify('first day of this month');
		$batas12bulan = $batas12bulan->modify('+11 month');
		$nama12bulan = $batas12bulan->format('n');
		$batas12bulan = $batas12bulan->format("Y-m-t 23:59:59");

		$this->load->model("M_payment");
		$standar = $this->M_payment->getstandar();

		if ($pilihan == 1) {
			$tanggalbatas = $batasbulanini;
			$iuran = $standar->iuran;
			$bulanapa = 1;//nmbulan_panjang($namabulanini);
		} else if ($pilihan == 2) {
			$tanggalbatas = $batas3bulan;
			$iuran = $standar->iuran3bulan;
			$bulanapa = 3;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama6bulan);
		} else if ($pilihan == 3) {
			$tanggalbatas = $batas6bulan;
			$iuran = $standar->iuran6bulan;
			$bulanapa = 6;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama6bulan);
		} else if ($pilihan == 4) {
			$tanggalbatas = $batas12bulan;
			$iuran = $standar->iuran12bulan;
			$bulanapa = 12;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama12bulan);
		}

		$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
			'Oktober', 'November', 'Desember');

		if ($this->session->userdata('statusbayar') == 2 && $this->session->userdata('a02') == false) {
			$iuran = $iuran + $standar->reaktivasi;
			$namane = "Reaktivasi " . $bulanapa . " Bulan TV Kampus";
		} else {
			$namane = "Pembayaran " . $bulanapa . " Bulan TV Kampus";
		}

		$this->load->model('M_login');
		$iduser = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$getuser = $this->M_login->getUser($iduser);
		$prodi = $getuser['kd_prodi'];
		$id = $getuser['id'];

		$kodeacak = "TVS-" . $id . "-" . rand();

		$this->M_payment->insertkodeorder($kodeacak, $id, $npsn, $prodi, $iuran, $tanggalbatas);

//        echo $iuran;
//        die();
		$transaction_details = array(
			'order_id' => $kodeacak,
			'gross_amount' => $iuran, // no decimal allowed for creditcard
		);

		$item1_details = array(
			'id' => 'a1',
			'price' => $iuran,
			'quantity' => 1,
			'name' => $namane
		);
//
		$item_details = array($item1_details);

		$customer_details = array(
			'first_name' => $this->session->userdata('first_name'),
			'last_name' => $this->session->userdata('last_name'),
			'email' => $this->session->userdata('email'),
			'phone' => $this->session->userdata('hp'),
//            'billing_address'  => $billing_address,
//            'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration' => 1440
		);

		$enabled_payments = array("gopay", "shopeepay", "akulaku");
		$enabled_payments2 = array("echannel", "alfamart", "Indomaret", "bni_va", "other_va", "permata_va", "bca_va",
			"bni_va", "danamon_online", "mandiri_clickpay", "bri_epay");

		if ($iuran <= 10000) {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'enabled_payments' => $enabled_payments,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		} else if ($iuran >= 250000) {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'enabled_payments' => $enabled_payments2,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		} else {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		}

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function token_lama()
	{
		if (!$this->session->userdata("loggedIn"))
			redirect("/");

		$bulan = new DateTime();

		$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
			'Oktober', 'November', 'Desember');

		$this->load->model("M_payment");
		$standar = $this->M_payment->getstandar();
		if ($this->session->userdata('statusbayar') == 2 && $this->session->userdata('a02') == false) {
			$iuran = $standar->reaktivasi;
			$namane = "Reaktivasi Verifikator TV Kampus";
		} else {
			$iuran = $standar->iuran;
			$namane = "Pembayaran Verifikator Bulan " . $nmbulan[intval($bulan->format("m"))] . " TV Kampus";
		}

		$iduser = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$kodeacak = "TVS-" . $iduser . "-" . rand();

		$this->M_payment->insertkodeorder($kodeacak, $iduser, $npsn, $iuran);

//        echo $iuran;
//        die();
		$transaction_details = array(
			'order_id' => $kodeacak,
			'gross_amount' => $iuran, // no decimal allowed for creditcard
		);


		// Optional
		$item1_details = array(
			'id' => 'a1',
			'price' => $iuran,
			'quantity' => 1,
			'name' => $namane
		);
//
//        // Optional
//        $item2_details = array(
//            'id' => 'a2',
//            'price' => 20000,
//            'quantity' => 3,
//            'name' => "Orange"
//        );
//
//        // Optional
		$item_details = array($item1_details);
//
//        // Optional
//        $billing_address = array(
//            'first_name'    => "Andri",
//            'last_name'     => "Litani",
//            'address'       => "Mangga 20",
//            'city'          => "Jakarta",
//            'postal_code'   => "16602",
//            'phone'         => "081122334455",
//            'country_code'  => 'IDN'
//        );
//
//        // Optional
//        $shipping_address = array(
//            'first_name'    => "Obet",
//            'last_name'     => "Supriadi",
//            'address'       => "Manggis 90",
//            'city'          => "Jakarta",
//            'postal_code'   => "16601",
//            'phone'         => "08113366345",
//            'country_code'  => 'IDN'
//        );
//
//        // Optional
		$customer_details = array(
			'first_name' => $this->session->userdata('first_name'),
			'last_name' => $this->session->userdata('last_name'),
			'email' => $this->session->userdata('email'),
			'phone' => $this->session->userdata('hp'),
//            'billing_address'  => $billing_address,
//            'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration' => 1440
		);

		$transaction_data = array(
			'transaction_details' => $transaction_details,
			'item_details' => $item_details,
			'customer_details' => $customer_details,
			'credit_card' => $credit_card,
			'expiry' => $custom_expiry
		);

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function token_pro($pilihan)
	{
		if (!$this->session->userdata("loggedIn"))
			redirect("/");

		$batasbulanini = new DateTime();
		$batasbulanini->setTimezone(new DateTimezone('Asia/Jakarta'));
		$batas3bulan = new DateTime();
		$batas3bulan->setTimezone(new DateTimezone('Asia/Jakarta'));
		$batas6bulan = new DateTime();
		$batas6bulan->setTimezone(new DateTimezone('Asia/Jakarta'));
		$batas12bulan = new DateTime();
		$batas12bulan->setTimezone(new DateTimezone('Asia/Jakarta'));

		$batasbulanini = $batasbulanini->modify('first day of this month');
		$namabulanini = $batasbulanini->format('n');
		$batasbulanini = $batasbulanini->format("Y-m-t 23:59:59");

		$batas3bulan = $batas3bulan->modify('first day of this month');
		$batas3bulan = $batas3bulan->modify('+2 month');
		$nama3bulan = $batas3bulan->format('n');
		$batas3bulan = $batas3bulan->format("Y-m-t 23:59:59");

		$batas6bulan = $batas6bulan->modify('first day of this month');
		$batas6bulan = $batas6bulan->modify('+5 month');
		$nama6bulan = $batas6bulan->format('n');
		$batas6bulan = $batas6bulan->format("Y-m-t 23:59:59");

		$batas12bulan = $batas12bulan->modify('first day of this month');
		$batas12bulan = $batas12bulan->modify('+11 month');
		$nama12bulan = $batas12bulan->format('n');
		$batas12bulan = $batas12bulan->format("Y-m-t 23:59:59");

		$this->load->model("M_payment");
		$standar = $this->M_payment->getstandar();

		if ($pilihan == 1) {
			$tanggalbatas = $batasbulanini;
			$iuran = $standar->pro;
			$bulanapa = 1;//nmbulan_panjang($namabulanini);
		} else if ($pilihan == 2) {
			$tanggalbatas = $batas3bulan;
			$iuran = $standar->pro3bulan;
			$bulanapa = 3;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama6bulan);
		} else if ($pilihan == 3) {
			$tanggalbatas = $batas6bulan;
			$iuran = $standar->pro6bulan;
			$bulanapa = 6;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama6bulan);
		} else if ($pilihan == 4) {
			$tanggalbatas = $batas12bulan;
			$iuran = $standar->pro12bulan;
			$bulanapa = 12;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama12bulan);
		}

		$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
			'Oktober', 'November', 'Desember');

		$this->load->model("M_payment");
		$standar = $this->M_payment->getstandar();

		$namane = "Pembayaran Pro " . $bulanapa . " Bulan TV Kampus";

		$this->load->model('M_login');
		$getuser = $this->M_login->getUser($this->session->userdata('id_user'));
		$iduser = $getuser['id'];
		$prodi = $getuser['kd_prodi'];
		$npsn = $this->session->userdata('npsn');

		$kodeacak = "TP2-" . $iduser . "-" . rand();

		$this->M_payment->insertkodeorder($kodeacak, $iduser, $npsn, $prodi, $iuran, $tanggalbatas);

//        echo $iuran;
//        die();
		$transaction_details = array(
			'order_id' => $kodeacak,
			'gross_amount' => $iuran, // no decimal allowed for creditcard
		);


		// Optional
		$item1_details = array(
			'id' => 'a1',
			'price' => $iuran,
			'quantity' => 1,
			'name' => $namane
		);

		$item_details = array($item1_details);

		$customer_details = array(
			'first_name' => $this->session->userdata('first_name'),
			'last_name' => $this->session->userdata('last_name'),
			'email' => $this->session->userdata('email'),
			'phone' => $this->session->userdata('hp'),
		);


		$credit_card['secure'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration' => 1440
		);

		$enabled_payments = array("gopay", "shopeepay", "akulaku");
		$enabled_payments2 = array("echannel", "alfamart", "Indomaret", "bni_va", "other_va", "permata_va", "bca_va",
			"bni_va", "danamon_online", "mandiri_clickpay", "bri_epay");

		if ($iuran <= 10000) {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'enabled_payments' => $enabled_payments,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		} else if ($iuran >= 250000) {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'enabled_payments' => $enabled_payments2,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		} else {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		}

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function token_premium($pilihan)
	{
		if (!$this->session->userdata("loggedIn"))
			redirect("/");

		$batasbulanini = new DateTime();
		$batasbulanini->setTimezone(new DateTimezone('Asia/Jakarta'));
		$batas3bulan = new DateTime();
		$batas3bulan->setTimezone(new DateTimezone('Asia/Jakarta'));
		$batas6bulan = new DateTime();
		$batas6bulan->setTimezone(new DateTimezone('Asia/Jakarta'));
		$batas12bulan = new DateTime();
		$batas12bulan->setTimezone(new DateTimezone('Asia/Jakarta'));

		$batasbulanini = $batasbulanini->modify('first day of this month');
		$namabulanini = $batasbulanini->format('n');
		$batasbulanini = $batasbulanini->format("Y-m-t 23:59:59");

		$batas3bulan = $batas3bulan->modify('first day of this month');
		$batas3bulan = $batas3bulan->modify('+2 month');
		$nama3bulan = $batas3bulan->format('n');
		$batas3bulan = $batas3bulan->format("Y-m-t 23:59:59");

		$batas6bulan = $batas6bulan->modify('first day of this month');
		$batas6bulan = $batas6bulan->modify('+5 month');
		$nama6bulan = $batas6bulan->format('n');
		$batas6bulan = $batas6bulan->format("Y-m-t 23:59:59");

		$batas12bulan = $batas12bulan->modify('first day of this month');
		$batas12bulan = $batas12bulan->modify('+11 month');
		$nama12bulan = $batas12bulan->format('n');
		$batas12bulan = $batas12bulan->format("Y-m-t 23:59:59");

		$this->load->model("M_payment");
		$standar = $this->M_payment->getstandar();

		if ($pilihan == 1) {
			$tanggalbatas = $batasbulanini;
			$iuran = $standar->premium;
			$bulanapa = 1;//nmbulan_panjang($namabulanini);
		} else if ($pilihan == 2) {
			$tanggalbatas = $batas3bulan;
			$iuran = $standar->premium3bulan;
			$bulanapa = 3;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama6bulan);
		} else if ($pilihan == 3) {
			$tanggalbatas = $batas6bulan;
			$iuran = $standar->premium6bulan;
			$bulanapa = 6;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama6bulan);
		} else if ($pilihan == 4) {
			$tanggalbatas = $batas12bulan;
			$iuran = $standar->premium12bulan;
			$bulanapa = 12;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama12bulan);
		}

		$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
			'Oktober', 'November', 'Desember');

		$this->load->model("M_payment");
		$standar = $this->M_payment->getstandar();

		$namane = "Pembayaran Premium " . $bulanapa . " Bulan TV Kampus";

		$this->load->model('M_login');
		$getuser = $this->M_login->getUser($this->session->userdata('id_user'));
		$iduser = $getuser['id'];
		$prodi = $getuser['kd_prodi'];
		$npsn = $this->session->userdata('npsn');

		$kodeacak = "TF2-" . $iduser . "-" . rand();


		$this->M_payment->insertkodeorder($kodeacak, $iduser, $npsn, $prodi, $iuran, $tanggalbatas);

//        echo $iuran;
//        die();
		$transaction_details = array(
			'order_id' => $kodeacak,
			'gross_amount' => $iuran, // no decimal allowed for creditcard
		);


		// Optional
		$item1_details = array(
			'id' => 'a1',
			'price' => $iuran,
			'quantity' => 1,
			'name' => $namane
		);

		$item_details = array($item1_details);

		$customer_details = array(
			'first_name' => $this->session->userdata('first_name'),
			'last_name' => $this->session->userdata('last_name'),
			'email' => $this->session->userdata('email'),
			'phone' => $this->session->userdata('hp'),
		);


		$credit_card['secure'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration' => 1440
		);

		$enabled_payments = array("gopay", "shopeepay", "akulaku");
		$enabled_payments2 = array("echannel", "alfamart", "Indomaret", "bni_va", "other_va", "permata_va", "bca_va",
			"bni_va", "danamon_online", "mandiri_clickpay", "bri_epay");

		if ($iuran <= 10000) {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'enabled_payments' => $enabled_payments,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		} else if ($iuran >= 250000) {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'enabled_payments' => $enabled_payments2,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		} else {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		}

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function token_ekskul($opsi)
	{
		if (!$this->session->userdata("loggedIn"))
			redirect("/");

		$tglsekarang = new DateTime();
		$bulan = $tglsekarang->format("m");
		$nbulan = intval($bulan);
		$tahun = substr($tglsekarang->format("Y"), 0, 4);
		$tahun2 = $tahun;
		$nbulan2 = $bulan + 5;
		if ($nbulan2 > 12) {
			$nbulan2 = $nbulan2 - 12;
			$tahun2 = $tahun + 1;
		}

		$bulan2 = $nbulan2;
		if ($nbulan2 < 10)
			$bulan2 = "0" . $nbulan2;


		$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
			'Oktober', 'November', 'Desember');

		$nmbulan2 = Array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep',
			'Okt', 'Nov', 'Des');

		$this->load->model("M_payment");
		$standar = $this->M_payment->getstandar();

		$iduser = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$getuser = $this->M_login->getUser($iduser);
		$prodi = $getuser['kd_prodi'];
		$id = $getuser['id'];

		if ($opsi == "bulanan") {
			$kodeacak = "EKS-" . $iduser . "-" . $bulan . $tahun . "-" . rand();
			$keteranganbayar = $nmbulan[$nbulan] . " " . $tahun;
			$iuran = $standar->iuran_ekskul;
			$tglakhir = new DateTime($tahun . "-" . $bulan . "-01 23:59:59");
		} else {
			$kodeacak = "EKZ-" . $iduser . "-" . $bulan . $tahun . "-" . rand();
			if ($tahun2 == $tahun)
				$keteranganbayar = $nmbulan[$nbulan] . " - " . $nmbulan[$nbulan2] . " " . $tahun;
			else
				$keteranganbayar = $nmbulan2[$nbulan] . " " . $tahun . " - " . $nmbulan2[$nbulan2] . " " . $tahun2;
			$iuran = $standar->iuran_ekskul * 5;
			$tglakhir = new DateTime($tahun2 . "-" . $bulan2 . "-01 23:59:59");
		}

		$tglakhir = $tglakhir->format("Y-m-t H:i:s");

		$this->M_payment->insertkodeorderekskul($kodeacak, $id, $npsn, $prodi, $iuran, $tglakhir);

		$this->load->model("M_ekskul");
		$this->M_ekskul->updateEkskul($npsn, $prodi, $iduser, $kodeacak);

//        echo $iuran;
//        die();
		$transaction_details = array(
			'order_id' => $kodeacak,
			'gross_amount' => $iuran, // no decimal allowed for creditcard
		);

//		"shopeepay",
//		"permata_va",
//		"bca_va",
//		"bni_va",
//		"bri_va",
//		"echannel",
//		"other_va",
//		"danamon_online",
//		"mandiri_clickpay",
//		"cimb_clicks",
//		"bca_klikbca",
//		"bca_klikpay",
//		"bri_epay",
//		"xl_tunai",
//		"indosat_dompetku",
//		"kioson",
//		"Indomaret",
//		"alfamart",
//		"akulaku"

		// Optional


		$item1_details = array(
			'id' => 'a1',
			'price' => $iuran,
			'quantity' => 1,
			'name' => 'Bayar Ekskul ' . $keteranganbayar
		);

		$item_details = array($item1_details);

		$customer_details = array(
			'first_name' => $this->session->userdata('first_name'),
			'last_name' => $this->session->userdata('last_name'),
			'email' => $this->session->userdata('email'),
			'phone' => $this->session->userdata('hp'),
//            'billing_address'  => $billing_address,
//            'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration' => 1440
		);

		$enabled_payments = array("gopay", "shopeepay", "akulaku");
		$enabled_payments2 = array("echannel", "alfamart", "Indomaret", "bni_va", "other_va", "permata_va", "bca_va",
			"bni_va", "danamon_online", "mandiri_clickpay", "bri_epay");

		if ($iuran <= 10000) {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'enabled_payments' => $enabled_payments,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		} else if ($iuran >= 250000) {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'enabled_payments' => $enabled_payments2,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		} else {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		}

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function token_ekskul_ver($opsi)
	{
		$tglsekarang = new DateTime();
		$bulan = $tglsekarang->format("m");
		$nbulan = intval($bulan);
		$tahun = substr($tglsekarang->format("Y"), 0, 4);
		$tahun2 = $tahun;
		$tahun3 = $tahun;
		$tahun4 = $tahun;
		$nbulan2 = $bulan + 2;
		if ($nbulan2 > 12) {
			$nbulan2 = $nbulan2 - 12;
			$tahun2 = $tahun + 1;
		}
		$nbulan3 = $bulan + 5;
		if ($nbulan3 > 12) {
			$nbulan3 = $nbulan3 - 12;
			$tahun3 = $tahun + 1;
		}
		$nbulan4 = $bulan + 11;
		if ($nbulan4 > 12) {
			$nbulan4 = $nbulan4 - 12;
			$tahun4 = $tahun + 1;
		}

		$bulan2 = $nbulan2;
		if ($nbulan2 < 10)
			$bulan2 = "0" . $nbulan2;

		$bulan3 = $nbulan3;
		if ($nbulan3 < 10)
			$bulan3 = "0" . $nbulan3;

		$bulan4 = $nbulan4;
		if ($nbulan4 < 10)
			$bulan4 = "0" . $nbulan4;


		$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
			'Oktober', 'November', 'Desember');

		$nmbulan2 = Array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep',
			'Okt', 'Nov', 'Des');

		$this->load->model("M_payment");
		$standar = $this->M_payment->getstandar();

		$iduser = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$getuser = $this->M_login->getUser($iduser);
		$prodi = $getuser['kd_prodi'];
		$id = $getuser['id'];

		if ($opsi == "1") {
			$kodeacak = "EK1-" . $iduser . "-" . $bulan . $tahun . "-" . rand();
			$keteranganbayar = $nmbulan[$nbulan] . " " . $tahun;
			$iuran = $standar->iuran_ekskul_ver;
			$tglakhir = new DateTime($tahun . "-" . $bulan . "-01 23:59:59");
			$feever = 30000;
		} else if ($opsi == "2") {
			$kodeacak = "EK2-" . $iduser . "-" . $bulan . $tahun . "-" . rand();
			if ($tahun2 == $tahun)
				$keteranganbayar = $nmbulan[$nbulan] . " - " . $nmbulan[$nbulan2] . " " . $tahun;
			else
				$keteranganbayar = $nmbulan2[$nbulan] . " " . $tahun . " - " . $nmbulan2[$nbulan2] . " " . $tahun2;
			$iuran = $standar->iuran_ekskul_ver * 3;
			$tglakhir = new DateTime($tahun2 . "-" . $bulan2 . "-01 23:59:59");
			$feever = 100000;
		} else if ($opsi == "3") {
			$kodeacak = "EK3-" . $iduser . "-" . $bulan . $tahun . "-" . rand();
			if ($nbulan <= 6)
				$keteranganbayar = $nmbulan[$nbulan] . " - " . $nmbulan[$nbulan3] . " " . $tahun;
			else
				$keteranganbayar = $nmbulan2[$nbulan] . " " . $tahun . " - " . $nmbulan2[$nbulan3] . " " . $tahun3;
			$iuran = $standar->iuran_ekskul_ver * 6;
			$tglakhir = new DateTime($tahun3 . "-" . $bulan3 . "-01 23:59:59");
			$feever = 250000;
		} else if ($opsi == "4") {
			$kodeacak = "EK4-" . $iduser . "-" . $bulan . $tahun . "-" . rand();
			if ($nbulan == 1)
				$keteranganbayar = $nmbulan[$nbulan] . " - " . $nmbulan[$nbulan4] . " " . $tahun;
			else
				$keteranganbayar = $nmbulan2[$nbulan] . " " . $tahun . " - " . $nmbulan2[$nbulan4] . " " . $tahun4;
			$iuran = $standar->iuran_ekskul_ver * 12;
			$tglakhir = new DateTime($tahun4 . "-" . $bulan4 . "-01 23:59:59");
			$feever = 600000;
		} else {
			redirect("/");
		}

		$tglakhir = $tglakhir->format("Y-m-t H:i:s");

		$this->M_payment->insertkodeorderekskul($kodeacak, $id, $npsn, $prodi, $iuran, $tglakhir, null, null, null, null, $feever, $iduser);

		$id = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$this->load->model("M_ekskul");
		//$this->M_ekskul->updateEkskul($npsn, $id, $kodeacak);

//        echo $iuran;
//        die();
		$transaction_details = array(
			'order_id' => $kodeacak,
			'gross_amount' => $iuran, // no decimal allowed for creditcard
		);

		// Optional

		$item1_details = array(
			'id' => 'a1',
			'price' => $iuran,
			'quantity' => 1,
			'name' => 'Bayar Ekskul ' . $keteranganbayar
		);

		$item_details = array($item1_details);

		$customer_details = array(
			'first_name' => $this->session->userdata('first_name'),
			'last_name' => $this->session->userdata('last_name'),
			'email' => $this->session->userdata('email'),
			'phone' => $this->session->userdata('hp'),
//            'billing_address'  => $billing_address,
//            'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration' => 1440
		);

		$transaction_data = array(
			'transaction_details' => $transaction_details,
			'item_details' => $item_details,
			'customer_details' => $customer_details,
			'credit_card' => $credit_card,
			'expiry' => $custom_expiry
		);

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function finish($opsi = null)
	{
		// console.log("MAMPIR KESINI");
		//$datesekarang = new DateTime("2021-03-02 01:00:00");
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tanggal = $datesekarang->format('d');

		$result = json_decode($this->input->post('result_data'));
//        echo 'RESULT <br><pre>';
//        var_dump($result);
//        echo '</pre>' ;

		$iduser = $this->session->userdata('id_user');
		$this->load->model('M_login');
		$getuser = $this->M_login->getUser($iduser);
		$iduserid = $getuser['id'];
		$prodi = $getuser['kd_prodi'];
		$order_id = $result->order_id;
		$tgl_order = $result->transaction_time;
		$tipebayar = $result->payment_type;
		$petunjuk = $result->pdf_url;
		if ($tipebayar == "bank_transfer") {
			if (isset($result->permata_va_number)) {
				$namabank = "Bank Permata";
				$rektujuan = $result->permata_va_number;
			} else {
				$namabank = $result->va_numbers[0]->bank;
				$rektujuan = $result->va_numbers[0]->va_number;
			}
		} else if ($tipebayar == "echannel") {
			$namabank = "Mandiri";
			$rektujuan = $result->biller_code . "-" . $result->bill_key;
		} else if ($tipebayar == "gopay") {
			$namabank = "gopay";
			$rektujuan = "";
		} else if ($tipebayar == "cstore") {
			$namabank = "alfamart"; //$result->store;
			$rektujuan = $result->payment_code;
		} else {
			$namabank = "";
			$rektujuan = "";
		}

		$this->load->model('M_payment');
		$standar = $this->M_payment->getstandar();
		$iurananggota = $standar->iuran;
		$data = array('tgl_order' => $tgl_order, 'tipebayar' => $tipebayar,
			'namabank' => $namabank, 'rektujuan' => $rektujuan, 'petunjuk' => $petunjuk);

		if ($tanggal <= 5) {
			$this->session->set_userdata('statusbayar', 1);
		} else {
			$this->session->set_userdata('statusbayar', 1);
		}

		$cekorder = $this->M_payment->cekorder($order_id);
		$statusorder = $cekorder->status;
		if ($statusorder == 0)
			$data['status'] = 1;
		else if ($statusorder == 3)
			$this->session->set_userdata('statusbayar', 3);

		$this->M_payment->tambahbayar($data, $order_id, $iduserid);
		$data2 = array('statusbayar' => 1, 'lastorder' => $order_id);
		$this->M_payment->updatestatusbayar($iduser, $data2);

		if ($opsi == "pay1")
			redirect("/profil/pembayaran");
		else
			redirect("/payment/tunggubayar");
	}

	public function finish_premium()
	{
		//$datesekarang = new DateTime("2021-03-02 01:00:00");
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tanggal = $datesekarang->format('d');

		$result = json_decode($this->input->post('result_data'));

//		echo 'RESULT <br><pre>';
//		var_dump($result);
//		echo '</pre>' ;
//		die();

		$iduser = $this->session->userdata('id_user');
		$order_id = $result->order_id;
		$tgl_order = $result->transaction_time;
		$tipebayar = $result->payment_type;
		$petunjuk = $result->pdf_url;
		if ($tipebayar == "bank_transfer") {
			if (isset($result->permata_va_number)) {
				$namabank = "Bank Permata";
				$rektujuan = $result->permata_va_number;
			} else {
				$namabank = $result->va_numbers[0]->bank;
				$rektujuan = $result->va_numbers[0]->va_number;
			}
		} else if ($tipebayar == "echannel") {
			$namabank = "Mandiri";
			$rektujuan = $result->biller_code . "-" . $result->bill_key;
		} else if ($tipebayar == "gopay") {
			$namabank = "gopay";
			$rektujuan = "";
		} else if ($tipebayar == "cstore") {
			$namabank = "alfamart";
			$rektujuan = $result->payment_code;
		} else {
			$namabank = "";
			$rektujuan = "";
		}

		$this->load->model('M_payment');
		$standar = $this->M_payment->getstandar();
		if (substr($order_id, 0, 3) == "TP0")
			$iurananggota = $standar->pro / 10;
		else if (substr($order_id, 0, 3) == "TP1")
			$iurananggota = $standar->pro / 10 * 4;
		else if (substr($order_id, 0, 3) == "TP2")
			$iurananggota = $standar->pro;
		else if (substr($order_id, 0, 3) == "TF0")
			$iurananggota = $standar->premium / 10;
		else if (substr($order_id, 0, 3) == "TF1")
			$iurananggota = $standar->premium / 10 * 4;
		else if (substr($order_id, 0, 3) == "TF2")
			$iurananggota = $standar->premium;
		$data = array('tgl_order' => $tgl_order, 'tipebayar' => $tipebayar,
			'namabank' => $namabank, 'rektujuan' => $rektujuan, 'petunjuk' => $petunjuk,
			'iuran' => $iurananggota);

		if ($tanggal <= 5) {
			$this->session->set_userdata('statusbayar', 1);
		} else {
			$this->session->set_userdata('statusbayar', 1);
		}

		$cekorder = $this->M_payment->cekorder($order_id);
		$statusorder = $cekorder->status;
		if ($statusorder == 0)
			$data['status'] = 1;
		else if ($statusorder == 3)
			$this->session->set_userdata('statusbayar', 3);

		$this->M_payment->tambahbayar($data, $order_id, $iduser);
		$data2 = array('statusbayar' => 1, 'lastorder' => $order_id);
		$this->M_payment->updatestatusbayar($iduser, $data2);

		redirect("/payment/tunggubayar");
	}

	public function finish_ekskul()
	{
		//$datesekarang = new DateTime("2021-03-02 01:00:00");
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tanggal = $datesekarang->format('d');

		$result = json_decode($this->input->post('result_data'));
//        echo 'RESULT <br><pre>';
//        var_dump($result);
//        echo '</pre>' ;

		$iduser = $this->session->userdata('id_user');
		$order_id = $result->order_id;
		$tgl_order = $result->transaction_time;
		$tipebayar = $result->payment_type;
		$petunjuk = $result->pdf_url;
		if ($tipebayar == "bank_transfer") {
			if (isset($result->permata_va_number)) {
				$namabank = "Bank Permata";
				$rektujuan = $result->permata_va_number;
			} else {
				$namabank = $result->va_numbers[0]->bank;
				$rektujuan = $result->va_numbers[0]->va_number;
			}
		} else if ($tipebayar == "echannel") {
			$namabank = "Mandiri";
			$rektujuan = $result->biller_code . "-" . $result->bill_key;
		} else if ($tipebayar == "gopay") {
			$namabank = "gopay";
			$rektujuan = "";
		} else if ($tipebayar == "cstore") {
			$namabank = "alfamart";
			$rektujuan = $result->payment_code;
		} else {
			$namabank = "";
			$rektujuan = "";
		}

		$this->load->model('M_payment');
		$standar = $this->M_payment->getstandar();

		$data = array('tgl_order' => $tgl_order, 'tipebayar' => $tipebayar,
			'namabank' => $namabank, 'rektujuan' => $rektujuan, 'petunjuk' => $petunjuk);

		$this->session->set_userdata('statusbayar', 1);

		$cekorder = $this->M_payment->cekorder($order_id);
		$statusorder = $cekorder->status;
		if ($statusorder == 0)
			$data['status'] = 1;
		else if ($statusorder == 3)
			$this->session->set_userdata('statusbayar', 3);

		$this->M_payment->tambahbayar($data, $order_id, $iduser);
		$data2 = array('statusbayar' => 1, 'lastorder' => $order_id);
		$this->M_payment->updatestatusbayar($iduser, $data2);

		redirect("/payment/tunggubayar_ekskul");
	}

	public function token_event($kodeevent)
	{

		if (!$this->session->userdata("loggedIn"))
			redirect("/");

		$this->load->model("M_payment");

		$iuran = $this->M_payment->getiuranevent($kodeevent);
		$namaevent = substr($this->M_payment->getnamaevent($kodeevent), 0, 34);

		$iduser = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$kodeacak = "EVT-" . $iduser . "-" . rand();

		$data = array("code_event" => $kodeevent, "order_id" => $kodeacak, "id_user" => $iduser, "iuran" => $iuran,
			"npsn" => $npsn, "status_user" => 0);
		$this->load->model("M_video");
		$this->M_video->addbukti($data);

		$transaction_details = array(
			'order_id' => $kodeacak,
			'gross_amount' => $iuran, // no decimal allowed for creditcard
		);

		// Optional
		$item1_details = array(
			'id' => 'a1',
			'price' => $iuran,
			'quantity' => 1,
			'name' => "Pembayaran Event " . $namaevent
		);

		$item_details = array($item1_details);

		$customer_details = array(
			'first_name' => $this->session->userdata('first_name'),
			'last_name' => $this->session->userdata('last_name'),
			'email' => $this->session->userdata('email'),
			'phone' => $this->session->userdata('hp'),
//            'billing_address'  => $billing_address,
//            'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration' => 1440
		);

		$transaction_data = array(
			'transaction_details' => $transaction_details,
			'item_details' => $item_details,
			'customer_details' => $customer_details,
			'credit_card' => $credit_card,
			'expiry' => $custom_expiry
		);

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function finish_event()
	{
		$codeevent = $this->input->post("kodeevent");

		$result = json_decode($this->input->post('result_data'));
//		echo "<pre>";
//		var_dump($result);
//		echo "</pre>";
//		die();
		$iduser = $this->session->userdata('id_user');
		$order_id = $result->order_id;
		$tgl_order = $result->transaction_time;
		$tipebayar = $result->payment_type;
		$petunjuk = $result->pdf_url;
		if ($tipebayar == "bank_transfer") {
			if (isset($result->permata_va_number)) {
				$namabank = "Bank Permata";
				$rektujuan = $result->permata_va_number;
			} else {
				$namabank = $result->va_numbers[0]->bank;
				$rektujuan = $result->va_numbers[0]->va_number;
			}
		} else if ($tipebayar == "echannel") {
			$namabank = "Mandiri";
			$rektujuan = $result->biller_code . "-" . $result->bill_key;
		} else if ($tipebayar == "gopay") {
			$namabank = "gopay";
			$rektujuan = "";
		} else if ($tipebayar == "cstore") {
			$namabank = "alfamart";
			$rektujuan = $result->payment_code;
		} else {
			$namabank = "";
			$rektujuan = "";
		}

		$data = array();

		$data['tipebayar'] = $tipebayar;
		$data['tgl_bayar'] = $tgl_order;
		$data['nama_bank'] = $namabank;
		$data['no_rek'] = $rektujuan;
		$data['petunjukbayar'] = $petunjuk;
		$data['status_user'] = 1;

		$this->load->model('M_video');
		$cekdulu = $this->M_video->cekUserEvent($codeevent, $iduser, 1);

		if ($cekdulu) {
			$this->M_video->updatetglbayareventorder($order_id, $iduser, $data);
		}

		$this->session->set_userdata('statusbayarevent', 1);

		redirect('/event/spesial/acara');
	}

	public function free_event($kodeevent)
	{
		$this->load->model('M_payment');
		$cekiuran = $this->M_payment->getiuranevent($kodeevent);
		if ($cekiuran != 0) {
			redirect("/event/spesial/acara");
		} else {
			if (isset($this->session->userdata['id_user'])) {
				$data['code_event'] = $kodeevent;
				$data['id_user'] = $this->session->userdata('id_user');
				$this->load->model('M_video');
				$cekuser = $this->M_video->cekUserEvent($kodeevent,
					$this->session->userdata('id_user'), 0);
//				echo 'RESULT <br><pre>';
//        		var_dump($cekuser);
//       			echo '</pre>' ;
				if ($cekuser) {
					if ($this->session->userdata('linkakhir')) {
						$alamat = $this->M_video->getEventbyCode($this->session->userdata('linkakhir'));
						$link = $alamat[0]->link_event;
						redirect("event/pilihan/" . $link);
					}
				} else {
					$this->load->model('M_video');
					$cekevent = $this->M_video->getEventbyCode($kodeevent);
					$tglakhir = date_create($cekevent[0]->tgl_batas_reg);
					$tglsekarang = new DateTime();
					$tglsekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
					$time1 = strtotime($tglakhir->format("d-m-Y H:i:s"));
					$time2 = strtotime($tglsekarang->format("d-m-Y H:i:s"));
					$selisih = $time1 - $time2;
					if ($selisih < 0) {
						echo "tutup";
						die();
					} else {
						$data['iuran'] = 0;
						$data['npsn'] = $this->session->userdata('npsn');
						$data['status_user'] = 2;
						$this->M_video->addbukti($data);
						$this->session->set_userdata('statusbayarevent', 2);
						if ($this->session->userdata('linkakhir')) {
							$alamat = $this->session->userdata('linkakhir');
							redirect("/event/terdaftar/" . $alamat);
						}
					}
				}
			} else {
				redirect("/");
			}
		}
	}

	public function ikuteventsekolah($kodeevent)
	{
		$this->load->model('M_video');
		$cekstatussekolah = $this->M_video->cekstatusbayarevent($kodeevent, $this->session->userdata('npsn'));

		if ($cekstatussekolah->status_user != 2) {
			redirect("/event/spesial/acara");
		} else {
			$data['code_event'] = $kodeevent;
			$data['id_user'] = $this->session->userdata('id_user');
			$data['npsn'] = $this->session->userdata('npsn');
			$data['status_user'] = 2;
			$this->M_video->addbukti($data);
		}
	}

	public function token_donasi($pilihan)
	{
		if (!$this->session->userdata("loggedIn"))
			redirect("/");

		$this->load->model("M_payment");

		if ($pilihan > 4)
			$iuran = $pilihan;
		else
			$iuran = $this->M_payment->getdonasipil($pilihan);
		//echo $iuran;
		//die();
		$iduser = $this->session->userdata('id_user');
		$orderid = "DNS-" . $iduser . "_" . rand();

		$data = array("iduser" => $iduser, "order_id" => $orderid, "iuran" => $iuran,
			"status" => 1);

		$this->load->model("M_payment");
		$this->M_payment->addDonasi($data);

		$transaction_details = array(
			'order_id' => $orderid,
			'gross_amount' => $iuran, // no decimal allowed for creditcard
		);

		// Optional
		$item1_details = array(
			'id' => 'a1',
			'price' => $iuran,
			'quantity' => 1,
			'name' => "DONASI UNTUK TV SEKOLAH"
		);

		$item_details = array($item1_details);

		$customer_details = array(
			'first_name' => $this->session->userdata('first_name'),
			'last_name' => $this->session->userdata('last_name'),
			'email' => $this->session->userdata('email'),
			'phone' => $this->session->userdata('hp'),
//            'billing_address'  => $billing_address,
//            'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration' => 1440
		);

		$transaction_data = array(
			'transaction_details' => $transaction_details,
			'item_details' => $item_details,
			'customer_details' => $customer_details,
			'credit_card' => $credit_card,
			'expiry' => $custom_expiry
		);

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function token_donasi_ae()
	{
		if (!$this->session->userdata("loggedIn"))
			redirect("/");

		$this->load->model("M_eksekusi");

		$iduser = $this->session->userdata("id_user");
		$ambildata = $this->M_eksekusi->getlasteksekusi($iduser, 0);
		$ambildonatur = $this->M_eksekusi->getDonatur($ambildata->id_donatur);
		$donasi = $ambildata->total_donasi;
		$totalsekolah = $ambildata->total_sekolah;
		$jangka = $ambildata->bulan_donasi;

		$orderid = "DN" . $ambildata->jenis_donasi . "-" . $iduser . "_" . $ambildata->id_donatur . "-" . rand();

		$data = array("iduser" => $iduser, "order_id" => $orderid, "iuran" => $donasi,
			"npsn_sekolah" => "", "status" => 1);

		$this->load->model("M_payment");
		$this->M_payment->addDonasi($data);

		$standar = $this->M_payment->getstandar();
		$feeae1 = $standar->fee_ae_1;
		$feeae2 = $standar->fee_ae_2;

		if ($ambildata->jenis_donasi == 1) {
			$feeae = ($feeae1 / 100) * $donasi * 90 / 100;
			$judul = "Donasi";
		} else if ($ambildata->jenis_donasi == 2) {
			$feeae = ($feeae2 / 100) * $donasi * 90 / 100;
			$judul = "Sponsor";
		}


		$data2 = array("order_id" => $orderid, "status_donasi" => 1, "fee" => $feeae, "status_fee" => 0);
		$this->M_eksekusi->updateeksekusi($data2, $ambildata->kode_eks, $iduser);

		$transaction_details = array(
			'order_id' => $orderid,
			'gross_amount' => $donasi,
		);

		// Optional
		$item1_details = array(
			'id' => 'a1',
			'price' => $donasi,
			'quantity' => 1,
			'name' => $judul . " untuk " . $totalsekolah . " sekolah selama " . $jangka . " bulan"
		);

		$item_details = array($item1_details);

		$customer_details = array(
			'first_name' => $ambildonatur->nama_donatur,
			'last_name' => "",
			'email' => $ambildonatur->email_donatur,
			'phone' => $ambildonatur->telp_donatur,
//            'billing_address'  => $billing_address,
//            'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration' => 1440
		);

		$transaction_data = array(
			'transaction_details' => $transaction_details,
			'item_details' => $item_details,
			'customer_details' => $customer_details,
			'credit_card' => $credit_card,
			'expiry' => $custom_expiry
		);

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function token_paket($npsn, $id)
	{
		if (!$this->session->userdata("loggedIn"))
			redirect("/");

		$iduser = $this->session->userdata("id_user");

//		echo "SASAS";
//		die();

		/////////////////////////////////

		$upgrade = "tidak";

		$this->load->model('M_channel');
		if ($npsn == "bimbel")
			$jenisbayar = 3;
		else if ($npsn == "saya")
			$jenisbayar = 1;
		else if ($npsn == "lain")
			$jenisbayar = 2;
		$cekstatusbayar = $this->M_channel->getlast_kdbeli($iduser, $jenisbayar);
		$datesekarang = new DateTime("");
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		if ($npsn == "bimbel") {
			$jenis = 3;
			$this->load->model("M_bimbel");
			$hargapaket = $this->M_bimbel->gethargapaket("bimbel");
			$npsn = $this->session->userdata('npsn');
		} else {
			$jenis = 2;
			if ($npsn == "saya" || $npsn == $this->session->userdata('npsn')) {
				$npsn = $this->session->userdata('npsn');
				$jenis = 1;
			}
			$this->load->model("M_bimbel");
			$hargapaket = $this->M_bimbel->gethargapaket($npsn);
			if (!$hargapaket)
				$hargapaket = $this->M_bimbel->gethargapaket("standar");
		}


		if ($jenis<3) {
			$this->load->Model('M_login');
			$datauser = $this->M_login->getUser($iduser);
			$idkelas = $datauser['kelas_user'];
			$this->load->Model('M_channel');
			$jmlmapelaktif = sizeof($this->M_channel->getDafPlayListMapel($npsn, $idkelas));
			$totalmoduleceran = $jmlmapelaktif * 4;
			$keteranganmapel = $jmlmapelaktif . " mapel";
		}
		else
		{
			$totalmoduleceran = 1;
			$keteranganmapel = "";
		}

		$selisihupgrade = $hargapaket['harga_' . $id] * $totalmoduleceran;
		$jmlmodul = $hargapaket['njudul_' . $id] * $totalmoduleceran;

		if ($cekstatusbayar) {
			$statusbayar = $cekstatusbayar->status_beli;
			$stratapaket = $cekstatusbayar->strata_paket;
			$tipebayar = $cekstatusbayar->tipe_bayar;
			$rupiahnya = $cekstatusbayar->rupiah;
			$tanggalorder = new DateTime($cekstatusbayar->tgl_beli);
			$batasorder = $tanggalorder->add(new DateInterval('P1D'));
			$bulanorder = $tanggalorder->format('m');
			$tahunorder = $tanggalorder->format('Y');

			$tanggal = $datesekarang->format('d');
			$bulan = $datesekarang->format('m');
			$tahun = $datesekarang->format('Y');

			$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

			//$selisihupgrade = $hargapaket['harga_' . $id]*$jmlmapelaktif*4;

			if ($selisih == 0 && $statusbayar == 2) {
				$upgrade = "ya";
				if ($stratapaket == 1 && $id == "pro")
					$selisihupgrade = ($hargapaket['harga_pro'] - $hargapaket['harga_lite'])*$totalmoduleceran;
				else if ($stratapaket == 1 && $id == "premium")
					$selisihupgrade = ($hargapaket['harga_premium'] - $hargapaket['harga_lite'])*$totalmoduleceran;
				else if ($stratapaket == 2 && $id == "premium")
					$selisihupgrade = ($hargapaket['harga_premium'] - $hargapaket['harga_pro'])*$totalmoduleceran;
			}
		}


		//////

		$idxpaket = array("lite" => 1, "pro" => 2, "premium" => 3);

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$tanggalbulanini = $datesekarang;

		$tanggalini = $datesekarang->format("d");
		$bulanini = $datesekarang->format("m");
		$tahunini = $datesekarang->format("Y");
		$tahundepan = $tahunini;

		$bulandepan = intval($bulanini) + 1;
		if (intval($bulandepan) > 12) {
			$bulandepan = 1;
			$tahundepan = $tahunini + 1;
		}
		$bulandepan = str_pad($bulandepan, 2, '0', STR_PAD_LEFT);

		$tanggalbulandepan = new DateTime("$tahundepan" . "-" . "$bulandepan" . "-28 00:00:00");

		if ($tanggalini < 20) {
			$tgl_batas = $tanggalbulanini->format('Y-m-t 23:59:59');
		} else {
			$tgl_batas = $tanggalbulandepan->format('Y-m-t 23:59:59');
		}

		$faktorpengali = 1;
		$lain = "";
		$hargaupgrademin = 0;
		$judulupgrade = "";

		if ($upgrade == "ya") {
			$judulupgrade = "Upgrade ";
		}

		if ($jenis == 2) {
			$faktorpengali = ($hargapaket['persensekolahlain'] + 100) / 100;
			$lain = " 'sekolah lain'";
		}

		$iuran = ($selisihupgrade) * $faktorpengali;
		$kodeacak = "PKT" . $jenis . $idxpaket[$id] . "_" . $iduser . "-" . rand(1000000000, 9999999999);
		$datax = array("id_user" => $iduser, "npsn_user" => $this->session->userdata('npsn'), "jenis_paket" => $jenis, "strata_paket" => $idxpaket[$id],
			"kode_beli" => $kodeacak, "tgl_batas" => $tgl_batas, "rupiah" => $iuran, "jml_modul" => $jmlmodul);

		$this->M_bimbel->insertkodepaket($datax);

		$transaction_details = array(
			'order_id' => $kodeacak,
			'gross_amount' => $iuran, // no decimal allowed for creditcard
		);

		// Optional
		$item1_details = array(
			'id' => 'a1',
			'price' => $iuran,
			'quantity' => 1,
			'name' => $judulupgrade . "Paket " . $id . $lain . " ".$keteranganmapel
		);

		$item_details = array($item1_details);

		$customer_details = array(
			'first_name' => $this->session->userdata('first_name'),
			'last_name' => $this->session->userdata('last_name'),
			'email' => $this->session->userdata('email'),
			'phone' => $this->session->userdata('hp'),
//            'billing_address'  => $billing_address,
//            'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration' => 1440
		);

		$enabled_payments = array("gopay", "shopeepay", "akulaku");
		$enabled_payments2 = array("echannel", "alfamart", "Indomaret", "bni_va", "other_va", "permata_va", "bca_va",
			"bni_va", "danamon_online", "mandiri_clickpay", "bri_epay");

		if ($iuran <= 10000) {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'enabled_payments' => $enabled_payments,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		} else if ($iuran >= 250000) {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'enabled_payments' => $enabled_payments2,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		} else {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		}

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function token_eceran($jenis, $pilihaneceran, $linklist)
	{
		if (!$this->session->userdata("loggedIn"))
			redirect("/");

		$iduser = $this->session->userdata("id_user");

		/////////////////////////////////

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$tanggalbulanini = $datesekarang;

		$tanggalini = $datesekarang->format("d");
		$bulanini = $datesekarang->format("m");
		$tahunini = $datesekarang->format("Y");
		$tahundepan = $tahunini;

		$bulandepan = intval($bulanini) + 1;
		if (intval($bulandepan) > 12) {
			$bulandepan = 1;
			$tahundepan = $tahunini + 1;
		}
		$bulandepan = str_pad($bulandepan, 2, '0', STR_PAD_LEFT);

		$tanggalbulandepan = new DateTime("$tahundepan" . "-" . "$bulandepan" . "-28 00:00:00");

		if ($tanggalini < 20) {
			$tgl_batas = $tanggalbulanini->format('Y-m-t 23:59:59');
		} else {
			$tgl_batas = $tanggalbulandepan->format('Y-m-t 23:59:59');
		}

		if ($jenis == "bimbel") {
			$njenis = 3;
			$this->load->model("M_bimbel");
			$hargapaket = $this->M_bimbel->gethargapaket("bimbel");
		}

		$idxpaket = array("lite" => 1, "pro" => 2, "premium" => 3, "privat" => 4);

		$npilihaneceran = $idxpaket[$pilihaneceran];

		$iuran = $hargapaket['harga_ecer' . $pilihaneceran];

		$kodeacak = "ECR" . $njenis . $npilihaneceran . "_" . $iduser . "-" . $linklist . rand(10, 99);
		$datax = array("id_user" => $iduser, "npsn_user" => $this->session->userdata('npsn'), "jenis_paket" => $njenis,
			"strata_paket" => $pilihaneceran, "kode_beli" => $kodeacak, "tgl_batas" => $tgl_batas, "rupiah" => $iuran, "jml_modul" => 1);

		$this->M_bimbel->insertkodepaket($datax);

		$transaction_details = array(
			'order_id' => $kodeacak,
			'gross_amount' => $iuran, // no decimal allowed for creditcard
		);

		// Optional
		$item1_details = array(
			'id' => 'a1',
			'price' => $iuran,
			'quantity' => 1,
			'name' => "Eceran " . strtoupper($pilihaneceran) . " " . strtoupper($jenis)
		);

		$item_details = array($item1_details);

		$customer_details = array(
			'first_name' => $this->session->userdata('first_name'),
			'last_name' => $this->session->userdata('last_name'),
			'email' => $this->session->userdata('email'),
			'phone' => $this->session->userdata('hp'),
//            'billing_address'  => $billing_address,
//            'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration' => 1440
		);

		$enabled_payments = array("gopay", "shopeepay", "akulaku");
		$enabled_payments2 = array("echannel", "alfamart", "Indomaret", "bni_va", "other_va", "permata_va", "bca_va",
			"bni_va", "danamon_online", "mandiri_clickpay", "bri_epay");

		if ($iuran <= 10000) {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'enabled_payments' => $enabled_payments,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		} else if ($iuran >= 250000) {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'enabled_payments' => $enabled_payments2,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		} else {
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);
		}

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function token_mou()
	{

		$this->load->model('M_mou');
		$mouaktif = $this->M_mou->cekmouaktif($this->session->userdata('npsn'), 4);
		if ($mouaktif) {
			$datamou = array();

			$idmou = $mouaktif->id;
			$idegency = $mouaktif->id_agency;
			$idsiam = $mouaktif->id_siam;

			$status_tagih1 = $mouaktif->status_tagih1;
			$status_tagih2 = $mouaktif->status_tagih2;
			$status_tagih3 = $mouaktif->status_tagih3;
			$status_tagih4 = $mouaktif->status_tagih4;
			$tagihan1 = $mouaktif->tagihan1;
			$tagihan2 = $mouaktif->tagihan2;
			$tagihan3 = $mouaktif->tagihan3;
			$tagihan4 = $mouaktif->tagihan4;
			$indeks = $mouaktif->pilihan_mou;

			$fee_agancy = 0;
			$fee_siam = 0;

			if ($status_tagih1 == 0) {
				$tagihantoken = $tagihan1;
				$term = "1";
				if ($idegency > 0)
					$fee_agancy = 1;
				else if ($idsiam > 0)
					$fee_siam = 1;
			} else if ($status_tagih2 == 0) {
				$tagihantoken = $tagihan2;
				$term = "2";
			} else if ($status_tagih3 == 0 && $tagihan3 > 0) {
				$tagihantoken = $tagihan3;
				$term = "3";
			} else if ($status_tagih4 == 0 && $tagihan4 > 0) {
				$tagihantoken = $tagihan4;
				$term = "4";
			}

			$iduser = $this->session->userdata('id_user');
			$npsn = $this->session->userdata('npsn');
			$getuser = $this->M_login->getUser($iduser);
			$prodi = $getuser['kd_prodi'];
			$id = $getuser['id'];
			$namapaket = array("", "A", "B", "C", "D");
			$kodeacak = "MO" . $indeks . "_" . $term . "_" . $id . "-" . rand(1000000000, 9999999999);

			$datamou["order_id_payment" . $term] = $kodeacak;

			$this->load->model('M_payment');
			$this->M_payment->insertkodeorder($kodeacak, $id, $npsn, $prodi, $tagihantoken,
				$fee_agancy, $fee_siam, $idegency, $idsiam);

			$this->M_mou->updatedatamou($idmou, $datamou);

			$transaction_details = array(
				'order_id' => $kodeacak,
				'gross_amount' => $tagihantoken, // no decimal allowed for creditcard
			);


			// Optional
			$item1_details = array(
				'id' => 'a1',
				'price' => $tagihantoken,
				'quantity' => 1,
				'name' => "Paket MOU-" . $namapaket[$indeks] . " (#" . $term . ")",
			);

			$item_details = array($item1_details);

			$customer_details = array(
				'first_name' => $this->session->userdata('first_name'),
				'last_name' => $this->session->userdata('last_name'),
				'email' => $this->session->userdata('email'),
				'phone' => $this->session->userdata('hp'),
//            'billing_address'  => $billing_address,
//            'shipping_address' => $shipping_address
			);

			// Data yang akan dikirim untuk request redirect_url.
			$credit_card['secure'] = true;
			//ser save_card true to enable oneclick or 2click
			//$credit_card['save_card'] = true;

			$time = time();
			$custom_expiry = array(
				'start_time' => date("Y-m-d H:i:s O", $time),
				'unit' => 'minute',
				'duration' => 1440
			);

			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);

			error_log(json_encode($transaction_data));
			$snapToken = $this->midtrans->getSnapToken($transaction_data);
			error_log($snapToken);
			echo $snapToken;

		} else {
			redirect("/");
		}

	}

	public function finish_donasi()
	{
		$result = json_decode($this->input->post('result_data'));
//		echo 'RESULT <br><pre>';
//		var_dump($result);
//		echo '</pre>' ;
//		die();
		$iduser = $this->session->userdata('id_user');
		$order_id = $result->order_id;
		$tgl_order = $result->transaction_time;
		$tipebayar = $result->payment_type;
		$permata_va = $result->permata_va_number;
		$donasi = $result->gross_amount;
		$petunjuk = $result->pdf_url;
		if ($tipebayar == "bank_transfer") {
			$namabank = $result->va_numbers[0]->bank;
			$rektujuan = $result->va_numbers[0]->va_number;
			if ($permata_va != "") {
				$namabank = "permata";
				$rektujuan = $permata_va;
			}
		} else if ($tipebayar == "echannel") {
			$namabank = "mandiri";
			$rektujuan = $result->biller_code . "-" . $result->bill_key;
		} else {
			$namabank = "";
			$rektujuan = "";
		}

		$data = array();

		$data['order_id'] = $order_id;
		$data['iduser'] = $iduser;
		$data['tgl_order'] = $tgl_order;
		$data['tipebayar'] = $tipebayar;
		$data['namabank'] = $namabank;
		$data['rektujuan'] = $rektujuan;
		$data['iuran'] = $donasi;
		$data['petunjuk'] = $petunjuk;

//		$data['status'] = 1;

		$this->session->set_userdata('statusdonasi', 1);

		$this->load->model('M_payment');
		$cekorder = $this->M_payment->cekstatusdonasi($order_id);
		$this->M_payment->update_payment($data, $iduser, $order_id);

		redirect('/payment/infodonasi');
	}

	public function finish_donasi_ae()
	{
		$result = json_decode($this->input->post('result_data'));
//		echo 'RESULT <br><pre>';
//		var_dump($result);
//		echo '</pre>' ;
//		die();
		$iduser = $this->session->userdata('id_user');
		$order_id = $result->order_id;
		$tgl_order = $result->transaction_time;
		$tipebayar = $result->payment_type;
		$permata_va = $result->permata_va_number;
		$donasi = $result->gross_amount;
		$petunjuk = $result->pdf_url;
		if ($tipebayar == "bank_transfer") {
			$namabank = $result->va_numbers[0]->bank;
			$rektujuan = $result->va_numbers[0]->va_number;
			if ($permata_va != "") {
				$namabank = "permata";
				$rektujuan = $permata_va;
			}
		} else if ($tipebayar == "echannel") {
			$namabank = "mandiri";
			$rektujuan = $result->biller_code . "-" . $result->bill_key;
		} else {
			$namabank = "";
			$rektujuan = "";
		}

		$data = array();

		$data['order_id'] = $order_id;
		$data['iduser'] = $iduser;
		$data['tgl_order'] = $tgl_order;
		$data['tipebayar'] = $tipebayar;
		$data['namabank'] = $namabank;
		$data['rektujuan'] = $rektujuan;
		$data['iuran'] = $donasi;
		$data['petunjuk'] = $petunjuk;

		$data['status'] = 1;

		$this->load->model('M_payment');
		$cekorder = $this->M_payment->cekstatusdonasi($order_id);
		if ($cekorder->status == 1)
			$this->M_payment->update_payment($data, $iduser, $order_id);

		redirect('/eksekusi/transaksi');
	}

	public function finish_paket()
	{
		$result = json_decode($this->input->post('result_data'));

		$iduser = $this->session->userdata('id_user');
		$npsnuser = $this->session->userdata('npsn_user');

		$order_id = $result->order_id;
		$tgl_order = $result->transaction_time;
		$rupiah = $result->gross_amount;
		$tipebayar = $result->payment_type;
		$petunjuk = $result->pdf_url;
		if ($tipebayar == "bank_transfer") {
			if (isset($result->permata_va_number)) {
				$namabank = "Bank Permata";
				$rektujuan = $result->permata_va_number;
			} else {
				$namabank = $result->va_numbers[0]->bank;
				$rektujuan = $result->va_numbers[0]->va_number;
			}
		} else if ($tipebayar == "echannel") {
			$namabank = "Mandiri";
			$rektujuan = $result->biller_code . "-" . $result->bill_key;
		} else if ($tipebayar == "gopay") {
			$namabank = "gopay";
			$rektujuan = "";
		} else if ($tipebayar == "cstore") {
			$namabank = "alfamart";
			$rektujuan = $result->payment_code;
		} else {
			$namabank = "";
			$rektujuan = "";
		}

		$datesekarang = new DateTime($tgl_order);

		$tanggalbulanini = $datesekarang;

		$tanggalini = $datesekarang->format("d");
		$bulanini = $datesekarang->format("m");
		$tahunini = $datesekarang->format("Y");
		$tahundepan = $tahunini;

		$bulandepan = intval($bulanini) + 1;
		if (intval($bulandepan) > 12) {
			$bulandepan = 1;
			$tahundepan = $tahunini + 1;
		}
		$bulandepan = str_pad($bulandepan, 2, '0', STR_PAD_LEFT);

		$tanggalbulandepan = new DateTime("$tahundepan" . "-" . "$bulandepan" . "-28 00:00:00");

		if ($tanggalini < 20) {
			$tgl_batas = $tanggalbulanini->format('Y-m-t 23:59:59');
		} else {
			$tgl_batas = $tanggalbulandepan->format('Y-m-t 23:59:59');
		}

		////////////////////////////////////////////////////
		$data = array();

		$jenis = substr($order_id, 3, 1);

		$data['jenis_paket'] = $jenis;
		$data['strata_paket'] = substr($order_id, 4, 1);
//		$data['kode_beli'] = $order_id;
//		$data['tgl_beli'] = $tgl_order;
//		$data['tgl_batas'] = $tgl_batas;
		$data['tipe_bayar'] = $tipebayar;
		$data['nama_bank'] = $namabank;
		$data['rekening_tujuan'] = $rektujuan;
		$data['rupiah'] = $rupiah;
		$data['petunjuk'] = $petunjuk;

		$this->load->model('M_payment');
		$cekorder = $this->M_payment->cekvkbeli($order_id);
		//echo $order_id;
		$statusbeli = $cekorder->status_beli;
		if ($statusbeli == 0)
			$data['status_beli'] = 1;

		$this->load->model('M_bimbel');
		$this->M_bimbel->addbayarpaket($data, $order_id);

		redirect("/payment/tunggubayarpaket/" . $jenis);
	}

	public function finish_eceran()
	{
		$result = json_decode($this->input->post('result_data'));

		$iduser = $this->session->userdata('id_user');
		$npsnuser = $this->session->userdata('npsn_user');

		$order_id = $result->order_id;
		$tgl_order = $result->transaction_time;
		$rupiah = $result->gross_amount;
		$tipebayar = $result->payment_type;
		$petunjuk = $result->pdf_url;
		if ($tipebayar == "bank_transfer") {
			if (isset($result->permata_va_number)) {
				$namabank = "Bank Permata";
				$rektujuan = $result->permata_va_number;
			} else {
				$namabank = $result->va_numbers[0]->bank;
				$rektujuan = $result->va_numbers[0]->va_number;
			}
		} else if ($tipebayar == "echannel") {
			$namabank = "Mandiri";
			$rektujuan = $result->biller_code . "-" . $result->bill_key;
		} else if ($tipebayar == "gopay") {
			$namabank = "gopay";
			$rektujuan = "";
		} else if ($tipebayar == "cstore") {
			$namabank = "alfamart";
			$rektujuan = $result->payment_code;
		} else {
			$namabank = "";
			$rektujuan = "";
		}

		$datesekarang = new DateTime($tgl_order);

		$tanggalbulanini = $datesekarang;

		$tanggalini = $datesekarang->format("d");
		$bulanini = $datesekarang->format("m");
		$tahunini = $datesekarang->format("Y");
		$tahundepan = $tahunini;

		$bulandepan = intval($bulanini) + 1;
		if (intval($bulandepan) > 12) {
			$bulandepan = 1;
			$tahundepan = $tahunini + 1;
		}
		$bulandepan = str_pad($bulandepan, 2, '0', STR_PAD_LEFT);

		$tanggalbulandepan = new DateTime("$tahundepan" . "-" . "$bulandepan" . "-28 00:00:00");

		if ($tanggalini < 20) {
			$tgl_batas = $tanggalbulanini->format('Y-m-t 23:59:59');
		} else {
			$tgl_batas = $tanggalbulandepan->format('Y-m-t 23:59:59');
		}

		////////////////////////////////////////////////////
		$data = array();

		$jenis = substr($order_id, 3, 1);

		$data['jenis_paket'] = $jenis;
		$data['strata_paket'] = substr($order_id, 4, 1);
//		$data['kode_beli'] = $order_id;
//		$data['tgl_beli'] = $tgl_order;
//		$data['tgl_batas'] = $tgl_batas;
		$data['tipe_bayar'] = $tipebayar;
		$data['nama_bank'] = $namabank;
		$data['rekening_tujuan'] = $rektujuan;
		$data['rupiah'] = $rupiah;
		$data['petunjuk'] = $petunjuk;

		$this->load->model('M_payment');
		$cekorder = $this->M_payment->cekvkbeli($order_id);
		//echo $order_id;
		$statusbeli = $cekorder->status_beli;
		if ($statusbeli == 0)
			$data['status_beli'] = 1;

		$this->load->model('M_bimbel');
		$this->M_bimbel->addbayarpaket($data, $order_id);

		redirect("/payment/tunggubayareceran/" . $jenis);
	}

	public function finish_paket0($npsn, $id)
	{
		if ($id == "pro" || $id == "premium")
			redirect("/");

		$this->load->model("M_bimbel");
		$idxpaket = array("lite" => 1, "pro" => 2, "premium" => 3);
		if ($npsn == "bimbel") {
			$jenis = 3;
			$hargapaket = $this->M_bimbel->gethargapaket("bimbel");
		} else {
			$jenis = 2;
			if ($npsn == "saya" || $npsn == $this->session->userdata('npsn')) {
				$npsn = $this->session->userdata('npsn');
				$jenis = 1;
			}
			$hargapaket = $this->M_bimbel->gethargapaket($npsn);
			if (!$hargapaket)
				$hargapaket = $this->M_bimbel->gethargapaket("standar");
		}

		if ($hargapaket["harga_" . $id] == 0) {
			$iduser = $this->session->userdata('id_user');
			$order_id = "PKT" . $jenis . $idxpaket[$id] . "_" . $iduser . "-" . rand(1000000000, 9999999999);


			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

//			$datesekarang = new DateTime("2021-01-20");

			$tgl_sekarang = $datesekarang->format('Y-m-d H:i:s');

			$tanggalbulanini = $datesekarang;

			$tanggalini = $datesekarang->format("d");
			$bulanini = $datesekarang->format("m");
			$tahunini = $datesekarang->format("Y");
			$tahundepan = $tahunini;

			$bulandepan = intval($bulanini) + 1;
			if (intval($bulandepan) > 12) {
				$bulandepan = 1;
				$tahundepan = $tahunini + 1;
			}
			$bulandepan = str_pad($bulandepan, 2, '0', STR_PAD_LEFT);

			$tanggalbulandepan = new DateTime("$tahundepan" . "-" . "$bulandepan" . "-28 00:00:00");
			$tglbulandepan = $tanggalbulandepan->format("Y-m-d H:i:s");

			if ($tanggalini < 20) {
				//echo "Akhir bulan udah hangus";
				$tgl_batas = $tanggalbulanini->format('Y-m-t 23:59:59');
			} else {
				//echo "Bulan depan masih aktif";
				$tgl_batas = $tanggalbulandepan->format('Y-m-t 23:59:59');
			}

//			echo $tgl_sekarang."<br>";
//			echo $tgl_batas;
//			die();

			//$datesekarang->add(new DateInterval('P30D'));

			if (intval($bulanini)>=7)
				$tgl_batassampaiakhir = $tahundepan."-05-31 23:59:59";
			else
				$tgl_batassampaiakhir = $tahunini."-05-31 23:59:59";

			$data = array();
//			$data['id_user'] = $iduser;
			$data['npsn_user'] = $this->session->userdata('npsn');
			$data['jenis_paket'] = $jenis;
			$data['strata_paket'] = $idxpaket[$id];
//			$data['kode_beli'] = $order_id;
			$data['tgl_beli'] = $tgl_sekarang;
			$data['tgl_aktif'] = $tgl_sekarang;
//			if ($jenis==3)
				$data['tgl_batas'] = $tgl_batas;
//			else
//				$data['tgl_batas'] = $tgl_batassampaiakhir;
			$data['tipe_bayar'] = "gratis";
			$data['nama_bank'] = "";
			$data['rekening_tujuan'] = "";
			$data['rupiah'] = 0;
			$data['petunjuk'] = "";
			$data['status_beli'] = 2;

			$dataawal = array("id_user" => $iduser, "kode_beli" => $order_id);
			$this->M_bimbel->insertkodepaket($dataawal, $data, $order_id, $iduser);
			echo "sukses";

		} else
			echo "gagal ik piye jal";
	}

	public function finish_paket1($npsn, $id)
	{
		if ($id != "pro")
			redirect("/");

		$npsn = $this->session->userdata('npsn');
		$this->load->Model('M_payment');
		$cekpremium = $this->M_payment->cekpremium($npsn);

		if (!$cekpremium)
			redirect("/");
		else {
			$kode_premium = $cekpremium->order_id;
			$kodeprem = substr($kode_premium, 0, 3);

			if ($kodeprem != "TP0" && $kodeprem != "TP1" && $kodeprem != "TP2" &&
				$kodeprem != "TF0" && $kodeprem != "TF1" && $kodeprem != "TF2") {
//				echo "GAK BOLEH YA......";
//				die();
				redirect("/");
			}

			if ($this->sisagratismasihada() == false) {
				echo "habis";
			} else {
				$this->load->model("M_bimbel");
				$idxpaket = array("lite" => 1, "pro" => 2, "premium" => 3);


				$jenis = 1;

				$iduser = $this->session->userdata('id_user');
				$order_id = "PKT" . $jenis . $idxpaket[$id] . "_" . $iduser . "-" . rand(1000000000, 9999999999);

				$datesekarang = new DateTime();
				$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

				$tgl_sekarang = $datesekarang->format('Y-m-d H:i:s');

				$tanggalbulanini = $datesekarang;

				$tanggalini = $datesekarang->format("d");
				$bulanini = $datesekarang->format("m");
				$tahunini = $datesekarang->format("Y");
				$tahundepan = $tahunini;

				$bulandepan = intval($bulanini) + 1;
				if (intval($bulandepan) > 12) {
					$bulandepan = 1;
					$tahundepan = $tahunini + 1;
				}
				$bulandepan = str_pad($bulandepan, 2, '0', STR_PAD_LEFT);

				$tanggalbulandepan = new DateTime("$tahundepan" . "-" . "$bulandepan" . "-28 00:00:00");
				$tglbulandepan = $tanggalbulandepan->format("Y-m-d H:i:s");

				if ($tanggalini < 20) {
					//echo "Akhir bulan udah hangus";
					$tgl_batas = $tanggalbulanini->format('Y-m-t 23:59:59');
				} else {
					//echo "Bulan depan masih aktif";
					$tgl_batas = $tanggalbulandepan->format('Y-m-t 23:59:59');
				}

				$data = array();
//			$data['id_user'] = $iduser;
				$data['jenis_paket'] = $jenis;
				$data['strata_paket'] = $idxpaket[$id];
//			$data['kode_beli'] = $order_id;
				$data['npsn_user'] = $this->session->userdata('npsn');
				$data['tgl_beli'] = $tgl_sekarang;
				$data['tgl_aktif'] = $tgl_sekarang;
				$data['tgl_batas'] = $tgl_batas;
				$data['tipe_bayar'] = "TV-Premium";
				$data['nama_bank'] = "";
				$data['rekening_tujuan'] = "";
				$data['rupiah'] = 0;
				$data['petunjuk'] = "";
				$data['status_beli'] = 2;

				$dataawal = array("id_user" => $iduser, "kode_beli" => $order_id);
				$this->M_bimbel->insertkodepaket($dataawal, $data, $order_id, $iduser);
				echo "sukses";
			}
		}
	}

	public function finish_paket2($npsn, $id)
	{
		if ($id != "premium")
			redirect("/");

		$npsn = $this->session->userdata('npsn');
		$this->load->Model('M_payment');
		$cekpremium = $this->M_payment->cekpremium($npsn);

		if (!$cekpremium)
			redirect("/");
		else {
			$kode_premium = $cekpremium->order_id;
			$kodeprem = substr($kode_premium, 0, 3);

			if ($kodeprem != "TF0" && $kodeprem != "TF1" && $kodeprem != "TF2") {
//				echo "GAK BOLEH YA......";
//				die();
				redirect("/");
			}

			if ($this->sisagratismasihada() == false) {
				echo "habis";
			} else {
				$this->load->model("M_bimbel");
				$idxpaket = array("lite" => 1, "pro" => 2, "premium" => 3);

				$jenis = 1;

				$iduser = $this->session->userdata('id_user');
				$order_id = "PKT" . $jenis . $idxpaket[$id] . "_" . $iduser . "-" . rand(1000000000, 9999999999);

				$datesekarang = new DateTime();
				$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

				$tgl_sekarang = $datesekarang->format('Y-m-d H:i:s');

				$tanggalbulanini = $datesekarang;

				$tanggalini = $datesekarang->format("d");
				$bulanini = $datesekarang->format("m");
				$tahunini = $datesekarang->format("Y");
				$tahundepan = $tahunini;

				$bulandepan = intval($bulanini) + 1;
				if (intval($bulandepan) > 12) {
					$bulandepan = 1;
					$tahundepan = $tahunini + 1;
				}
				$bulandepan = str_pad($bulandepan, 2, '0', STR_PAD_LEFT);

				$tanggalbulandepan = new DateTime("$tahundepan" . "-" . "$bulandepan" . "-28 00:00:00");
				$tglbulandepan = $tanggalbulandepan->format("Y-m-d H:i:s");

				if ($tanggalini < 20) {
					//echo "Akhir bulan udah hangus";
					$tgl_batas = $tanggalbulanini->format('Y-m-t 23:59:59');
				} else {
					//echo "Bulan depan masih aktif";
					$tgl_batas = $tanggalbulandepan->format('Y-m-t 23:59:59');
				}

				$data = array();
//			$data['id_user'] = $iduser;
				$data['jenis_paket'] = $jenis;
				$data['strata_paket'] = $idxpaket[$id];
//			$data['kode_beli'] = $order_id;
				$data['npsn_user'] = $this->session->userdata('npsn');
				$data['tgl_beli'] = $tgl_sekarang;
				$data['tgl_aktif'] = $tgl_sekarang;
				$data['tgl_batas'] = $tgl_batas;
				$data['tipe_bayar'] = "TV-Premium";
				$data['nama_bank'] = "";
				$data['rekening_tujuan'] = "";
				$data['rupiah'] = 0;
				$data['petunjuk'] = "";
				$data['status_beli'] = 2;

				$dataawal = array("id_user" => $iduser, "kode_beli" => $order_id);
				$this->M_bimbel->insertkodepaket($dataawal, $data, $order_id, $iduser);
				echo "sukses";
			}
		}
	}

	public function finish_mou()
	{
		$result = json_decode($this->input->post('result_data'));

		$iduser = $this->session->userdata('id_user');
		$order_id = $result->order_id;
		$tgl_order = $result->transaction_time;
		$rupiah = $result->gross_amount;
		$tipebayar = $result->payment_type;
		$petunjuk = $result->pdf_url;
		if ($tipebayar == "bank_transfer") {
			if (isset($result->permata_va_number)) {
				$namabank = "Bank Permata";
				$rektujuan = $result->permata_va_number;
			} else {
				$namabank = $result->va_numbers[0]->bank;
				$rektujuan = $result->va_numbers[0]->va_number;
			}
		} else if ($tipebayar == "echannel") {
			$namabank = "Mandiri";
			$rektujuan = $result->biller_code . "-" . $result->bill_key;
		} else if ($tipebayar == "gopay") {
			$namabank = "gopay";
			$rektujuan = "";
		} else if ($tipebayar == "cstore") {
			$namabank = "alfamart";
			$rektujuan = $result->payment_code;
		} else {
			$namabank = "";
			$rektujuan = "";
		}

		////////////////////////////////////////////////////
		$data = array();

		$data['tipebayar'] = $tipebayar;
		$data['namabank'] = $namabank;
		$data['rektujuan'] = $rektujuan;
		$data['iuran'] = $rupiah;
		$data['petunjuk'] = $petunjuk;

		$this->load->model('M_payment');
		$cekorder = $this->M_payment->cekorder($order_id);
		$statusorder = $cekorder->status;
		if ($statusorder == 0)
			$data['status'] = 1;
		else if ($statusorder == 3)
			$this->session->set_userdata('statusbayar', 3);

		$this->M_payment->tambahbayar($data, $order_id, $iduser);
//		$this->load->model('M_mou');
//		$this->M_mou->updatedatamou($idmou, $datamou);

		redirect("/payment/tunggubayar");
	}

	private function sisagratismasihada()
	{
		$this->load->model("M_user");
		$cekuser = $this->M_user->getUserSekolah($this->session->userdata['npsn']);
		$jmlbelipaketreguler = 0;
		$jmlbelipaketpremium = 0;
		foreach ($cekuser as $rowdata) {
			if ($rowdata->strata == 2)
				$jmlbelipaketreguler++;
			else if ($rowdata->strata == 3)
				$jmlbelipaketpremium++;
		}
		$data['total_adapaketreguler'] = $jmlbelipaketreguler;
		$data['total_adapaketpremium'] = $jmlbelipaketpremium;

		$totalpaketgratis = $jmlbelipaketreguler + $jmlbelipaketpremium;

		$this->load->model("M_payment");
		if ($this->M_payment->cekpremium($this->session->userdata['npsn']) && $totalpaketgratis <= 1000) {
			return true;
		} else {
			return false;
		}
	}

	public function infodonasi()
	{
		$this->load->model('M_payment');
		$cekdonasipending = $this->M_payment->getlastdonasi($this->session->userdata('id_user'), 1);
		if ($cekdonasipending) {
			$data = array();
			$data['konten'] = 'v_donasi_info';

			$data['email'] = $this->session->userdata('email');
			$data['donasi'] = $cekdonasipending;
			$this->load->view('layout/wrapper_payment', $data);
		} else {
			redirect("/");
		}
	}

	public function notifikasi($opsi = null)
	{

		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);


		if ($result) {

			$transaction = $result->transaction_status;
			$transaction_time = $result->transaction_time;
			$type = $result->payment_type;
			$fraud = $result->fraud_status;
			$order_id = $result->order_id;
			$sejumlah = $result->gross_amount;

			if ($type == "bank_transfer") {
				if (isset($result->permata_va_number)) {
					$namabank = "Bank Permata";
					$rektujuan = $result->permata_va_number;
				} else {
					$namabank = $result->va_numbers[0]->bank;
					$rektujuan = $result->va_numbers[0]->va_number;
				}
			} else if ($type == "echannel") {
				$namabank = "Mandiri";
				$rektujuan = $result->biller_code . "-" . $result->bill_key;
			} else if ($type == "gopay") {
				$namabank = "gopay";
				$rektujuan = "";
			} else if ($type == "cstore") {
				$namabank = "alfamart";
				$rektujuan = $result->payment_code;
			} else {
				$namabank = "";
				$rektujuan = "";
			}

			if ($transaction == 'capture') {
				// For credit card transaction, we need to check whether transaction is challenge by FDS or not
				if ($type == 'credit_card') {
					if ($fraud == 'challenge') {
						// TODO set payment status in merchant's database to 'Challenge by FDS'
						// TODO merchant should decide whether this transaction is authorized or not in MAP
						echo "Transaction order_id: " . $order_id . " is challenged by FDS";
					} else {
						// TODO set payment status in merchant's database to 'Success'
						echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
					}
				}
			} else if ($transaction == 'settlement') {
				// TODO set payment status in merchant's database to 'Settlement'
				//echo "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
				$this->load->model('M_payment');
				if (substr($order_id, 0, 3) == "TVS"
					|| substr($order_id, 0, 3) == "TP0" || substr($order_id, 0, 3) == "TF0"
					|| substr($order_id, 0, 3) == "TP1" || substr($order_id, 0, 3) == "TF1"
					|| substr($order_id, 0, 3) == "TP2" || substr($order_id, 0, 3) == "TF2") {

					$datesekarang = new DateTime();
					$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
					$tglsekarang = $datesekarang->format("Y-m-d H:i:s");

					$data3 = array('status' => 3, 'tgl_bayar' => $tglsekarang);

					/////////////////////////////////////////////////////////
//					$standar = $this->M_payment->getstandar();
					$cekorder = $this->M_payment->cekorder($order_id);
					$tipebayar = $cekorder->tipebayar;
					if ($tipebayar == null) {
						$data3['tipebayar'] = $type;
						$data3['namabank'] = $namabank;
						$data3['rektujuan'] = $rektujuan;
						$data3['iuran'] = $sejumlah;
					}

					if ($this->M_payment->updatestatuspayment($order_id, $data3)) {
						hitungfeeiuran($order_id);
						echo "";
					} else {
						echo "gagal";
					}

				} else if (substr($order_id, 0, 3) == "EVT") {
//					$this->load->model('M_payment');
//					$iduser = $this->M_payment->cekevent($order_id);
//					$iduser = $iduser->id_user;
					$data2 = array('status_user' => 2);
					$datesekarang = new DateTime();
					$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
					$tglsekarang = $datesekarang->format("Y-m-d H:i:s");
					$data2['tgl_konfirm'] = $tglsekarang;

					$cekorder = $this->M_payment->cekevent($order_id);
					$statusorder = $cekorder->tipebayar;

					if ($statusorder == null) {
						$data2['tipebayar'] = $type;
						$data2['nama_bank'] = $namabank;
						$data2['no_rek'] = $rektujuan;
						$data2['iuran'] = $sejumlah;
					}

					$this->M_payment->updatestatusbayarevent($order_id, $data2);
					hitungfeeevent($order_id);
//					echo "<br>cihuy";
				} else if (substr($order_id, 0, 3) == "DNS") {
//					$datesekarang = new DateTime();
//					$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
//					$tglsekarang = $datesekarang->format("Y-m-d H:i:s");
					$data2 = array('status' => 3, 'tgl_bayar' => $transaction_time);

					$cekorder = $this->M_payment->cekorder($order_id);
					$iduser = $cekorder->iduser;
					$tipebayar = $cekorder->tipebayar;
					if ($tipebayar == null) {
						$tipebayar = $type;
						$data2['tipebayar'] = $type;
						$data2['namabank'] = $namabank;
						$data2['rektujuan'] = $rektujuan;
						$data2['iuran'] = $sejumlah;
					}

					$iuran = $cekorder->iuran;
					if ($tipebayar == "gopay")
						$potongan = 0.02 * $sejumlah;
					else
						$potongan = 4400;
					$iurannet = $iuran - $potongan;

					$data2['potongan'] = $potongan;
					$data2['iuran_net'] = $iurannet;

					$this->M_payment->updatestatuspayment($order_id, $data2);
					$this->M_payment->updatestatusdonasi($iduser, 3);
					$this->session->set_userdata('statusdonasi', 3);
					//$this->sertifikatdonasi($order_id);
					//echo "iduser:".$iduser;
				} else if (substr($order_id, 0, 3) == "PKT") {
					$data2 = array('status_beli' => 2, 'tgl_aktif' => $transaction_time);
					$cekorder = $this->M_payment->cekvkbeli($order_id);
					$tipebayar = $cekorder->tipebayar;
					if ($tipebayar == "" || $tipebayar == null) {
						$data2['tipe_bayar'] = $type;
						$data2['nama_bank'] = $namabank;
						$data2['rekening_tujuan'] = $rektujuan;
						$data2['rupiah'] = $sejumlah;
					}
					$this->M_payment->update_vk_beli($data2, $order_id);
					/////////////////////////////////////////////////////////
					if (substr($order_id, 0, 4) == "PKT1")
					{
						$tgl_sekarang=new DateTime();
						$bulanskr = $tgl_sekarang->format("n");
						$modulmana = moduldarike_bulan($bulanskr);
						hitungfeevksekolah($order_id,$modulmana);
					}

					//INI NANTI AJA YA CEK LAGI --- 12/02/2022
					//$this->cekmodul($iduser);

				} else if (substr($order_id, 0, 3) == "ECR") {
					$cekorder = $this->M_payment->cekvkbeli($order_id);
					$data2 = array('status_beli' => 2, 'tgl_aktif' => $transaction_time);

					/////////////////////////////////////////////////////////

					$tipebayar = $cekorder->tipe_bayar;
					if ($tipebayar == "" || $tipebayar == null) {
						$tipebayar = $type;
						$data2['tipe_bayar'] = $type;
						$data2['nama_bank'] = $namabank;
						$data2['rekening_tujuan'] = $rektujuan;
						$data2['rupiah'] = $sejumlah;
					}

					$this->M_payment->update_vk_beli($data2, $order_id);

					$iduser = $cekorder->id_user;
					$jenispaket = $cekorder->jenis_paket;
					$jmlmodul = $cekorder->jml_modul;

					$posawal = strpos($order_id,"-")+1;
					$panjangsemua = strlen($order_id)-2;
					$panjangkode = $panjangsemua-$posawal;
					$linkpaket = substr($order_id,$posawal,$panjangkode);
					$this->masukkanketb_vk($iduser, $order_id , $jenispaket, $linkpaket, $tipebayar, $sejumlah, $jmlmodul);

				} else if (substr($order_id, 0, 3) == "DN1" ||
					substr($order_id, 0, 3) == "DN2") {
					$datesekarang = new DateTime();
					$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
					$tglsekarang = $datesekarang->format("Y-m-d H:i:s");

					$data1 = array('status' => 3, 'tgl_bayar' => $tglsekarang);

					$cekorder = $this->M_payment->cekorder($order_id);
					$tipebayar = $cekorder->tipebayar;
					if ($tipebayar == null) {
						$tipebayar = $type;
						$data1['tipebayar'] = $type;
						$data1['namabank'] = $namabank;
						$data1['rektujuan'] = $rektujuan;
						$data1['iuran'] = $sejumlah;
					}

					$iuran = $cekorder->iuran;
					if ($tipebayar == "gopay")
						$potongan = 0.02 * $sejumlah;
					else
						$potongan = 4400;
					$iurannet = $iuran - $potongan;

					$data1['potongan'] = $potongan;
					$data1['iuran_net'] = $iurannet;


					$this->M_payment->updatestatuspayment($order_id, $data1);

					$data2 = array('status_donasi' => 2, 'status_fee' => 1);
					$this->load->model('M_eksekusi');
					$this->M_eksekusi->updateordeksekusi($order_id, $data2);
					$this->M_eksekusi->paysekolahpilihan($order_id);
					//echo "iduser:".$iduser;
				} else if (substr($order_id, 0, 3) == "TVD") {
					$data3 = array('status' => 3, 'tgl_bayar' => $transaction_time);

					$cekorder = $this->M_payment->cekorderdesa($order_id);
					$tipebayar = $cekorder->tipebayar;
					if ($tipebayar == null) {
						$tipebayar = $type;
						$data3['tipebayar'] = $type;
						$data3['namabank'] = $namabank;
						$data3['rektujuan'] = $rektujuan;
						$data3['iuran'] = $sejumlah;
					}

					if ($tipebayar == "gopay")
						$potongan = 0.02 * $sejumlah;
					else
						$potongan = 4400;
					$pph = 0.1 * $sejumlah;
					$iurannet = $sejumlah - $potongan - $pph;

					$data3['potongan'] = $potongan;
					$data3['ppn'] = $pph;
					$data3['iuran_net'] = $iurannet;
					$data3['fee_siam'] = 0;
					$data3['fee_agency'] = 0;

					//////////////// UPDATE KERANJANG ///////////
					$ambilkeranjang = $this->M_payment->getkeranjang($order_id);
					$jmldata = 1;
					$data = array();
					foreach ($ambilkeranjang as $row) {
						$data[$jmldata]['iduser'] = 0;
						$data[$jmldata]['npsn_sekolah'] = $row->npsn;
						$data[$jmldata]['order_id'] = "TVD-X-" . substr($order_id, 4);
						$data[$jmldata]['tgl_order'] = $transaction_time;
						$data[$jmldata]['tgl_bayar'] = $transaction_time;
						$data[$jmldata]['tipebayar'] = "terbayar";
						$data[$jmldata]['status'] = 3;

						$jmldata++;
					}
					if ($this->M_payment->updatekeranjang($data))
						$this->M_payment->klirkeranjang();

					///////////////////////////////////////////////

					if ($this->M_payment->updatestatuspaymentdesa($order_id, $data3)) {
						echo "";
					} else {
						echo "gagal";
					}
				} else if (substr($order_id, 0, 3) == "TVV") {
					$data3 = array('status' => 3, 'tgl_bayar' => $transaction_time);

					$cekorder = $this->M_payment->cekordervokus($order_id);
					$tipebayar = $cekorder->tipebayar;
					if ($tipebayar == null) {
						$tipebayar = $type;
						$data3['tipebayar'] = $type;
						$data3['namabank'] = $namabank;
						$data3['rektujuan'] = $rektujuan;
						$data3['iuran'] = $sejumlah;
					}

					$standar = $this->M_payment->getstandarvokus();
					$midtrans = $standar->pot_midtrans;
					$gopay = $standar->pot_gopay;
					$ppn = $standar->ppn;
					$pph = $standar->pph;
					$feetvsekolah = $standar->iuran_tvs;
					$feepuspelindo = $standar->iuran_vokus;

					if ($tipebayar == "gopay")
						$potongan = $gopay * $sejumlah / 100;
					else
						$potongan = $midtrans;
					$rpppn = $ppn * $sejumlah / 100;
					$iuransetelahpotong = $sejumlah - $potongan - $rpppn;

					$iurannet = $iuransetelahpotong * $feetvsekolah / 100;
					$puspelindonet = $iuransetelahpotong * $feepuspelindo / 100;

					$data3['iuran_net'] = floor($iurannet * (100 - $pph) / 100);
					$data3['puspelindo_net'] = floor(($puspelindonet) * (100 - $pph) / 100);

					if ($this->M_payment->updatestatuspaymentvokus($order_id, $data3)) {
						echo "";
					} else {
						echo "gagal";
					}
				} else if (substr($order_id, 0, 3) == "DNV") {
					$datesekarang = new DateTime();
					$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
					$tglsekarang = $datesekarang->format("Y-m-d H:i:s");

					$data1 = array('status' => 3, 'tgl_bayar' => $tglsekarang);

					$cekorder = $this->M_payment->cekordervokus($order_id);
					$tipebayar = $cekorder->tipebayar;
					if ($tipebayar == null) {
						$tipebayar = $type;
						$data1['tipebayar'] = $type;
						$data1['namabank'] = $namabank;
						$data1['rektujuan'] = $rektujuan;
						$data1['iuran'] = $sejumlah;
					}

					$iuran = $cekorder->iuran;
					$standar = $this->M_payment->getstandarvokus();
					$midtrans = $standar->pot_midtrans;
					$gopay = $standar->pot_gopay;
					$ppn = $standar->ppn;
					$pph = $standar->pph;

					if ($tipebayar == "gopay")
						$potongan = $gopay * $sejumlah / 100;
					else
						$potongan = $midtrans;
					$rpppn = $ppn * $iuran / 100;
					$iurannet = $iuran - $potongan - $rpppn;

					$data1['potongan'] = $potongan;
					$data1['iuran_net'] = floor($iurannet * (100 - $pph) / 100);

					$this->M_payment->updatestatuspaymentvokus($order_id, $data1);

					//echo "iduser:".$iduser;
				} else if (substr($order_id, 0, 2) == "MO") {
					$data3 = array('status' => 3, 'tgl_bayar' => $transaction_time);

					$cekorder = $this->M_payment->cekorder($order_id);
					$tipebayar = $cekorder->tipebayar;
					if ($tipebayar == null) {
						$tipebayar = $type;
						$data3['tipebayar'] = $type;
						$data3['namabank'] = $namabank;
						$data3['rektujuan'] = $rektujuan;
						$data3['iuran'] = $sejumlah;
					}

					$feeagen = ceil(($sejumlah / 3) * 97.5 / 100);
					if ($cekorder->fee_siam > 0)
						$data3['fee_siam'] = $feeagen;
					if ($cekorder->fee_agency > 0)
						$data3['fee_agency'] = $feeagen;

					if ($tipebayar == "gopay")
						$potongan = 0.02 * $sejumlah;
					else
						$potongan = 4400;
					$pph = 0.1 * $sejumlah;
					$iurannet = $sejumlah - $potongan - $pph - $feeagen;

					$data3['potongan'] = $potongan;
					$data3['pph'] = $pph;
					$data3['iuran_net'] = $iurannet;

					if ($this->M_payment->updatestatuspayment($order_id, $data3)) {
						echo "";
						$this->load->Model("M_mou");
						$this->M_mou->updatestatusordermou($order_id);
					} else {
						echo "gagal";
					}
				} else if (substr($order_id, 0, 3) == "PMO") {
					$cekorder = $this->M_payment->cekvkbelivokus($order_id);
					$data2 = array('status_beli' => 2, 'tgl_aktif' => $transaction_time);

					$statusbeli = $cekorder->rupiah;
					$iduser = $cekorder->id_user;
					$jenispaket = $cekorder->jenis_paket;
					$strata = $cekorder->strata_paket;
					$kodebeli = $cekorder->kode_beli;
					$tglbatas = $cekorder->tgl_batas;

					if ($statusbeli == 0) {
						$data2['tipe_bayar'] = $type;
						$data2['nama_bank'] = $namabank;
						$data2['rekening_tujuan'] = $rektujuan;
						$data2['rupiah'] = $sejumlah;
					}

					if ($this->M_payment->update_vk_beli_vokus($data2, $order_id))
						$this->updatebelikeranjangvokus($iduser, $jenispaket, $strata, $kodebeli,
							$sejumlah, $type, $tglbatas);

					//echo "iduser:".$iduser;
				} else if (substr($order_id, 0, 2) == "EK") {
					$cekorder = $this->M_payment->cekorder($order_id);
					$tipebayar = $cekorder->tipebayar;
					$data2 = array('status' => 3, 'tgl_bayar' => $transaction_time);
//					if ($tipebayar == null) {
//						$data2['tipe_bayar'] = $type;
//						$data2['nama_bank'] = $namabank;
//						$data2['rekening_tujuan'] = $rektujuan;
//						$data2['rupiah'] = $sejumlah;
//					}
//
//					$iuran = $cekorder->iuran;
//					if ($tipebayar == "gopay")
//						$potongan = 0.02 * $sejumlah;
//					else
//						$potongan = 4400;
//					$iurannet = $iuran - $potongan;
//
//					$data2['potongan'] = $potongan;
//					$data2['iuran_net'] = $iurannet;

					if ($this->M_payment->updatestatuspayment($order_id, $data2)) {
						hitungfeeekskul($order_id);
						echo "";
					} else {
						echo "gagal";
					}
				}
//                redirect("/");
			} else if ($transaction == 'pending') {
				// TODO set payment status in merchant's database to 'Pending'
				echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
			} else if ($transaction == 'deny') {
				// TODO set payment status in merchant's database to 'Denied'
				echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
			}
		} else {
			echo "tidak valid";
			error_log(print_r($result, TRUE));
		}

		//notification handler sample
	}

	private function updatebelikeranjangvokus($iduser, $jenispaket, $strata, $kodebeli, $sejumlah, $type,
											  $tglbatas)
	{
		$this->load->model('M_login');
		$getuserdata = $this->M_login->getUserVokus($iduser);
		$npsn = $getuserdata['npsn'];

		$lkpdapatgak = $this->ceklkponoff($npsn);

		$strstrata = array("0", "lite", "pro", "premium");
		$tstrata = $strstrata[$strata];

		$datakeranjang = $this->M_payment->getkeranjangvokus($iduser);
		$jumlahmodul = sizeof($datakeranjang);

		$rupiahbruto = $sejumlah / $jumlahmodul;

		$data = array();
		$a = 0;
		foreach ($datakeranjang as $datane) {
			$a++;
			$data[$a]['id_user'] = $iduser;
			$data[$a]['jenis_paket'] = $jenispaket;
			$data[$a]['strata_paket'] = $strata;
			$data[$a]['tgl_batas'] = $tglbatas;
			$data[$a]['kode_beli'] = $kodebeli;
			$data[$a]['link_paket'] = $datane->link_list;
			if ($jenispaket == 1 || $jenispaket == 2)
				$getinfopaket = $this->M_payment->getInfoPaket($datane->link_list);
			else if ($jenispaket == 3)
				$getinfopaket = $this->M_payment->getInfoBimbel($datane->link_list);

			$npsn_modul = $getinfopaket->npsn_user;

			$verifikatorlastactived = $this->M_payment->getveraktif($npsn_modul);
			$idverifikator = $verifikatorlastactived->id;

			$idkontributor = $getinfopaket->id_user;
			$data[$a]['id_lkp'] = $idverifikator;
			$data[$a]['id_instruktur'] = $idkontributor;
			$data[$a]['rp_bruto'] = $rupiahbruto;
			$hargastandar = $this->M_payment->getStandarVokus2();

			if ($type == "gopay")
				$potonganmidtrans = $hargastandar->pot_gopay;
			else
				$potonganmidtrans = $hargastandar->pot_midtrans;

			if ($rupiahbruto == 0)
				$potonganmidtrans = 0;
			$data[$a]['rp_midtrans'] = $potonganmidtrans;
			$rupiahnet = $rupiahbruto - $potonganmidtrans;
			$data[$a]['rp_net'] = $rupiahnet;
			$data[$a]['rp_ppn'] = $rupiahnet * ($hargastandar->ppn / 100);

			$feemanajemen = $hargastandar->kv_tvs;
			$feepuspelindo = $hargastandar->kv_puspelindo;
			$feever = $hargastandar->kv_verifikator;
			$feeins = $hargastandar->kv_instruktur;

			if ($lkpdapatgak == "lewat") {
				$feemanajemen = $feemanajemen + $feepuspelindo + $feever;
				$feepuspelindo = 0;
				$feever = 0;
			}

			////////////////////////////////////////
			$manajemenbruto = $rupiahnet * $feemanajemen / 100;
			$data[$a]['rp_manajemen_bruto'] = $manajemenbruto;
			$manajemenpph = $manajemenbruto * ($hargastandar->pph / 100);
			$data[$a]['rp_manajemen_pph'] = $manajemenpph;
			$data[$a]['rp_manajemen_net'] = $manajemenbruto - $manajemenpph;
			///////////////////////////////////////
			$puspelindobruto = $rupiahnet * $feepuspelindo / 100;
			$data[$a]['rp_puspelindo_bruto'] = $puspelindobruto;
			$puspelindopph = $puspelindobruto * ($hargastandar->pph / 100);
			$data[$a]['rp_puspelindo_pph'] = $puspelindopph;
			$data[$a]['rp_puspelindo_net'] = $puspelindobruto - $puspelindopph;
			///////////////////////////////////////
			$verbruto = $rupiahnet * $feever / 100;
			$data[$a]['rp_lkp_bruto'] = $verbruto;
			$verpph = $verbruto * ($hargastandar->pph / 100);
			$data[$a]['rp_lkp_pph'] = $verpph;
			$data[$a]['rp_lkp_net'] = $verbruto - $verpph;
			///////////////////////////////////////
			$kontribruto = $rupiahnet * $feeins / 100;
			$data[$a]['rp_instruktur_bruto'] = $kontribruto;
			$kontripph = $kontribruto * ($hargastandar->pph / 100);
			$data[$a]['rp_instruktur_pph'] = $kontripph;
			$data[$a]['rp_instruktur_net'] = $kontribruto - $kontripph;
			///////////////////////////////////////

		}

		if ($this->M_payment->insertvk($iduser, $data)) {
			echo "sukses";
		} else {
			echo "gagal";
		}


	}

	public function cetakdonasi($orderid)
	{
		$this->sertifikatdonasi($orderid);
	}

	public function sertifikatdonasi($orderid)
	{
		$this->load->model('M_payment');
		$cekstatus = $this->M_payment->ambilorder($orderid);
		if ($cekstatus[0]->status == 3) {
			//$iduser = $cekstatus[0]->iduser;
			$email = $cekstatus[0]->email;
			$data['donasi'] = $cekstatus;
			$data['orderid'] = $orderid;
			$this->load->view('v_sertifikat', $data);
			//$this->send_emails($email, $orderid);
		} else {
			echo "BUKAN HAK ANDA";
		}
	}

	private function send_emails($email, $orderid)
	{

		if (base_url() == "https://tutormedia.net/_tv_sekolah/") {
			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://mail.tutormedia.net',
				'smtp_port' => 465,
				'smtp_user' => 'sekretariat@tutormedia.net',
				'smtp_pass' => '3=6!CWueF4dQ',
				'crlf' => "\r\n",
				'newline' => "\r\n"
			);
		} else {
			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://tvsekolah.id',
				'smtp_port' => 465,
				'smtp_user' => 'sekretariat@tvsekolah.id',
				'smtp_pass' => 'F()rd0rum',
				'crlf' => "\r\n",
				'newline' => "\r\n"
			);
		}

		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		$message = "
                  <html>
                  <head>
                      <title>Sertifikat Donasi</title>
                  </head>
                  <body>
                      <h2>Terimakasih atas donasi anda</h2>
                      <p>Berikut kami lampirkan Sertifikat Donasi</p>
                  </body>
                  </html>
                  ";
		if (base_url() == "https://tutormedia.net/_tv_sekolah/") {
			$this->email->from('sekretariat@tutormedia.net', 'Sekretariat TVSekolah');
		} else {
			$this->email->from('sekretariat@tvsekolah.id', 'Sekretariat TVSekolah');
		}
		$this->email->to($email);
		$this->email->subject('Sertifikat Donasi');
		$this->email->message($message);
//		$this->email->message($message);
		$this->email->attach(base_url() . 'uploads/sertifikat/sert_donasi_' . $orderid . '.pdf');

//		echo ("Hasil:".base_url().'uploads/sertifikat/sert_donasi_'.$orderid.'.pdf');
//		die();

		if ($this->email->send()) {
			echo "Berhasil";
			$this->session->set_flashdata('message', 'Sertifikat dikirim ke email');
		} else {
			//echo "Gagal";
			$this->session->set_flashdata('message', $this->email->print_debugger());
			echo($this->email->print_debugger());
			die();
			//redirect(base_url() . "informasi/sertifikatthanks");
			$this->session->set_flashdata('message', $this->email->print_debugger());
		}

		redirect(base_url() . "informasi/sertifikatthanks");
	}

	public function tunggubayar()
	{
		if ($this->session->userdata('loggedIn')) {
			$iduser = $this->session->userdata('id_user');
			$this->load->model('M_payment');
			if ($this->session->userdata("mou") >= 2) {
				$cekstatusbayar = $this->M_payment->getlastmou($iduser, 1);
			} else {
				$cekstatusbayar = $this->M_payment->getlastverifikator($iduser, 1);
			}

			if ($cekstatusbayar) {

				$statusbayar = $cekstatusbayar->status;
				$orderkode = substr($cekstatusbayar->order_id, 0, 3);
				if ($statusbayar == 1) {
					$data = array();
					$data['konten'] = 'v_tunggubayar';

					$lastorder = $this->M_payment->cekstatusbayar($iduser)->lastorder;
					if ($this->session->userdata("mou") >= 2)
						$lastorder = $cekstatusbayar->order_id;

//					echo "<pre>";
//					echo var_dump($lastorder);
//					echo "</pre>";
//					die();

					if ($this->M_payment->cekorder($lastorder) == "error") {
						$data['namabank'] = "XXX";
						$data['rektujuan'] = "XXX";
						$data['order_id'] = "XXX";
						$data['tgl_order'] = "XXX";
						$data['petunjuk'] = "";
					} else {
						$ambildata = $this->M_payment->cekorder($lastorder);
						$data['namabank'] = $ambildata->namabank;
						$data['rektujuan'] = $ambildata->rektujuan;
						$data['order_id'] = $ambildata->order_id;
						$tglorder = $ambildata->tgl_order;
						$tglorder = new DateTime($tglorder);
						$data['petunjuk'] = $ambildata->petunjuk;
						//echo "<br><br><br><br><br>IKI TANGGALE:".$tglorder->format('Y-m-d H:i:s');
						$tglorder->add(new DateInterval('P1D'));
						$data['tgl_order'] = $tglorder;
					}

					$standar = $this->M_payment->getstandar();
					$data['iuran'] = $ambildata->iuran;
					if ($this->session->userdata("mou") >= 2)
						$data['iuran'] = $ambildata->iuran;

					if ($orderkode == "TP0" || $orderkode == "TP1" || $orderkode == "TP2") {
						$data['isi'] = "v_tunggubayar_premium";
						$data['iuran'] = $standar->pro;
						$data['full'] = " PRO ";
						if ($orderkode == "TP0") {
							$data['iuran'] = $standar->pro / 10;
							$data['full'] = $data['full'] . " EARLY BIRD";
						} else if ($orderkode == "TP1") {
							$data['iuran'] = $standar->pro / 10 * 4;
							$data['full'] = $data['full'] . " EARLY BIRD II";
						}
					} else if ($orderkode == "TF0" || $orderkode == "TF1" || $orderkode == "TF2") {
						$data['isi'] = "v_tunggubayar_premium";
						$data['full'] = " PREMIUM ";
						$data['iuran'] = $standar->premium;
						if ($orderkode == "TF0") {
							$data['full'] = $data['full'] . " EARLY BIRD";
							$data['iuran'] = $standar->premium / 10;
						} else if ($orderkode == "TF1") {
							$data['full'] = $data['full'] . " EARLY BIRD II";
							$data['iuran'] = $standar->premium / 10 * 4;
						}

					}


					$this->load->view('layout/wrapper_payment', $data);
				} else if ($statusbayar == 3) {
					$this->session->set_userdata('a02', true);
					$this->session->set_userdata('a03', false);
					$this->session->set_userdata('statusbayar', 3);
					redirect("/");
				}
			} else {
				redirect("/");
			}
		} else {
			redirect("/");
		}
	}

	public function tunggubayar_ekskul()
	{
		if ($this->session->userdata('loggedIn')) {
			$iduser = $this->session->userdata('id_user');
			$this->load->model('M_payment');

			$cekstatusbayar = $this->M_payment->getlastbayarekskul($iduser, 1);

			if ($cekstatusbayar) {

				$statusbayar = $cekstatusbayar->status;
				$orderkode = substr($cekstatusbayar->order_id, 0, 3);
				if ($statusbayar == 1) {
					$data = array();
					$data['konten'] = "v_tunggubayar_ekskul";
					$data['jenis'] = 4;

					$lastorder = $this->M_payment->cekstatusbayar($iduser)->lastorder;

					if ($this->M_payment->cekorder($lastorder) == "error") {
						$data['namabank'] = "XXX";
						$data['rektujuan'] = "XXX";
						$data['order_id'] = "XXX";
						$data['tgl_order'] = "XXX";
						$data['petunjuk'] = "";
					} else {
						$ambildata = $this->M_payment->cekorder($lastorder);
						$data['namabank'] = $ambildata->namabank;
						$data['rektujuan'] = $ambildata->rektujuan;
						$data['order_id'] = $ambildata->order_id;
						$tglorder = $ambildata->tgl_order;
						$tglorder = new DateTime($tglorder);
						$data['petunjuk'] = $ambildata->petunjuk;
						//echo "<br><br><br><br><br>IKI TANGGALE:".$tglorder->format('Y-m-d H:i:s');
						$tglorder->add(new DateInterval('P1D'));
						$data['tgl_order'] = $tglorder;
					}

					$standar = $this->M_payment->getstandar();
					$data['iuran'] = $ambildata->iuran;

					$this->load->view('layout/wrapper_payment', $data);
				} else if ($statusbayar == 3) {
					$this->session->set_userdata('a02', true);
					$this->session->set_userdata('a03', false);
					$this->session->set_userdata('statusbayar', 3);
					redirect("/ekskul");
				}
			} else {
				redirect("/");
			}
		} else {
			redirect("/");
		}
	}

	public function tunggubayar_event($order_id)
	{
		if ($this->session->userdata('loggedIn')) {
			$data = array();
			$data['konten'] = "v_tunggubayar_event";
			$this->load->Model('M_payment');
			$ambildata = $this->M_payment->cekorderevent($order_id);
			if ($ambildata->status_user != 1)
				redirect("/event/acara");
			else {
				$tglskr = new DateTime();
				$tglskr->setTimezone(new DateTimezone('Asia/Jakarta'));
				$batastanggal = $tglskr->modify('-1 day');
				$batastanggal = $tglskr->format("Y-m-d H:i:s");
				$tglorder = $ambildata->tgl_bayar;
				if (strtotime($tglorder) < strtotime($batastanggal))
					redirect("/event/acara");
			}
			$data['namabank'] = $ambildata->nama_bank;
			$data['rektujuan'] = $ambildata->no_rek;
			$data['order_id'] = $ambildata->order_id;
			$tglorder = $ambildata->tgl_bayar;
			$tglorder = new DateTime($tglorder);
			$data['petunjuk'] = $ambildata->petunjukbayar;
			//echo "<br><br><br><br><br>IKI TANGGALE:".$tglorder->format('Y-m-d H:i:s');
			$tglorder->add(new DateInterval('P1D'));
			$data['tgl_order'] = $tglorder;
			$data['iuran'] = $ambildata->iuran;
			$this->load->view('layout/wrapper_payment', $data);

		} else {
			redirect("/");
		}
	}

	public function tunggubayarpaket($jenis = null)
	{

		if ($this->session->userdata('loggedIn')) {
			$iduser = $this->session->userdata('id_user');
			$this->load->model('M_channel');
			$cekstatusbayar = $this->M_channel->getlast_kdbeli($iduser, $jenis);

			if ($cekstatusbayar) {
				$statusbayar = $cekstatusbayar->status_beli;
				$jenispaket = $cekstatusbayar->jenis_paket;
				if ($statusbayar == 1) {
					$data = array();
					$data['konten'] = 'virtual_kelas_tunggubayarpaket';
					$data['jenis'] = $jenis;
					$data['namabank'] = $cekstatusbayar->nama_bank;
					$data['rektujuan'] = $cekstatusbayar->rekening_tujuan;
					$data['order_id'] = $cekstatusbayar->kode_beli;
					$tglorder = $cekstatusbayar->tgl_beli;
					$tglorder = new DateTime($tglorder);
					$data['petunjuk'] = $cekstatusbayar->petunjuk;
					//echo "<br><br><br><br><br>IKI TANGGALE:".$tglorder->format('Y-m-d H:i:s');
					$tglorder->add(new DateInterval('P1D'));
					$data['tgl_order'] = $tglorder;
					$data['stgl_order'] = $tglorder->format("Y-m-d H:i:s");

					$data['iuran'] = $cekstatusbayar->rupiah;

					$this->load->view('layout/wrapper_payment', $data);
				} else if ($statusbayar == 2) {
					if ($jenispaket == 1)
						redirect("/virtualkelas/sekolah_saya/");
					else if ($jenispaket == 2)
						redirect("/vksekolah/set/lain");
					else if ($jenispaket == 3)
						redirect("/bimbel/page/1");
				}
			} else
				redirect("/");
		} else {
			redirect("/");
		}
	}

	public function tunggubayareceran($jenis = null)
	{

		if ($this->session->userdata('loggedIn')) {
			$iduser = $this->session->userdata('id_user');
			$this->load->model('M_channel');
			$cekstatusbayar = $this->M_channel->getlast_kdbeli_eceran($iduser, $jenis);

			if ($cekstatusbayar) {
				$statusbayar = $cekstatusbayar->status_beli;
				$jenispaket = $cekstatusbayar->jenis_paket;
				if ($statusbayar == 1) {
					$data = array();
					$data['konten'] = 'virtual_kelas_tunggubayarpaket';
					$data['jenis'] = $jenis;
					$data['namabank'] = $cekstatusbayar->nama_bank;
					$data['rektujuan'] = $cekstatusbayar->rekening_tujuan;
					$data['order_id'] = $cekstatusbayar->kode_beli;
					$tglorder = $cekstatusbayar->tgl_beli;
					$tglorder = new DateTime($tglorder);
					$data['petunjuk'] = $cekstatusbayar->petunjuk;
					//echo "<br><br><br><br><br>IKI TANGGALE:".$tglorder->format('Y-m-d H:i:s');
					$tglorder->add(new DateInterval('P1D'));
					$data['tgl_order'] = $tglorder;
					$data['stgl_order'] = $tglorder->format("Y-m-d H:i:s");

					$data['iuran'] = $cekstatusbayar->rupiah;

					$this->load->view('layout/wrapper_payment', $data);
				} else if ($statusbayar == 2) {
					if ($jenispaket == 1)
						redirect("/virtualkelas/sekolah_saya/");
					else if ($jenispaket == 2)
						redirect("/vksekolah/set/lain");
					else if ($jenispaket == 3)
						redirect("/bimbel/page/1");
				}
			} else
				redirect("/");
		} else {
			redirect("/");
		}
	}

	public function transaksi($opsi = null)
	{
		if (($this->session->userdata('a01') || $this->session->userdata('email') == 'CEO@tvsekolah.id')) {
			if ($opsi == null)
				$opsi = "pembayaran";
			$data = array('title' => 'Transaksi', 'menuaktif' => '23',
				'isi' => 'v_transaksi');
			//$data['sortby'] = '';
			$this->load->model("M_payment");
			$data['alltransaksi'] = $this->M_payment->gettransaksi(null);
			$data['allincome'] = $this->M_payment->getincome('income');
			$data['transaksi'] = $this->M_payment->gettransaksi($opsi);
			$data['opsi'] = $opsi;
			$this->load->view('layout/wrapper', $data);
		} else
			redirect('/');
	}


	public function tesnotifikasi($order_id)
	{
		$this->load->model("M_payment");
		$data1 = array('status' => 3);
		$this->M_payment->updatestatuspayment($order_id, $data1);
		$data2 = array('status_donasi' => 2, 'status_fee' => 1);
		$this->load->model('M_eksekusi');
		$this->M_eksekusi->updateordeksekusi($order_id, $data2);
		$this->M_eksekusi->paysekolahpilihan($order_id);
	}

	public function tesemail()
	{
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://tvsekolah.id',
			'smtp_port' => 465,
			'smtp_user' => 'sekretariat@tvsekolah.id',
			'smtp_pass' => 'F()rd0rum',
			'crlf' => "\r\n",
			'newline' => "\r\n"
		);

		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		$message = "
                  <html>
                  <head>
                      <title>Sertifikat Donasi</title>
                  </head>
                  <body>
                      <h2>Terimakasih atas donasi anda</h2>
                      <p>Berikut kami lampirkan Sertifikat Donasi</p>
                  </body>
                  </html>
                  ";

		$orderid = "DNS-2033009186";

		$this->email->from('sekretariat@tvsekolah.id', 'Sekretariat TVSekolah');
		$this->email->to("antok9000@gmail.com");
		$this->email->subject('Sertifikat Donasi');
		$this->email->message($message);
		$this->email->attach(base_url() . 'uploads/sertifikat/sert_donasi_' . $orderid . '.pdf');

//		echo ("Hasil:".base_url().'uploads/sertifikat/sert_donasi_'.$orderid.'.pdf');
//		die();

		if ($this->email->send()) {
			echo "Berhasil";
			$this->session->set_flashdata('message', 'Sertifikat dikirim ke email');
		} else {
			echo "GAGAL";
			$this->session->set_flashdata('message', $this->email->print_debugger());
		}
	}

	public function ujipos()
	{
		$url = base_url() . 'payment/notifikasi';

		$ch = curl_init($url);

		$jsonData = array(
			"transaction_time" => "2021-03-17 09:00:05",
			"transaction_status" => "settlement",
			"transaction_id" => "86cedce9-8490-4e36-8587-7dbea957b89c",
			"status_message" => "midtrans payment notification",
			"status_code" => "200",
			"signature_key" => "6eab4842e0e8a37988b3dde5981c745195e9965cb2916f822dcdb3133b029cb469eeff7258ab223f1e0dc91a3199416eb83815664965c9bd4690149c817875ed",
			"settlement_time" => "2021-03-17 09:00:27",
			"payment_type" => "echannel",
			"order_id" => "DNS-40_810239833",
			"merchant_id" => "G961922282",
			"gross_amount" => "750000.00",
			"fraud_status" => "accept",
			"currency" => "IDR",
			"biller_code" => "70012",
			"bill_key" => "524692641325"
		);

		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
	}

	public function infoverifikator()
	{
		if ($this->session->userdata('loggedIn') && $this->session->userdata('a02')) {
			$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
				'Oktober', 'November', 'Desember');

			$data = array();
			$data['konten'] = 'v_infoverifikator';
			$this->load->model("M_payment");

			$iduser = $this->session->userdata('id_user');
			$standarbayar = $this->M_payment->getstandar();
			$cekstatusbayar = $this->M_payment->getlastverifikator($iduser, 1);
			$sampai = "";
			if ($cekstatusbayar) {
				$bulan = substr($cekstatusbayar->tgl_order, 5, 2);
				$tahun = substr($cekstatusbayar->tgl_order, 0, 4);
				$sampai = $nmbulan[intval($bulan)] . " " . $tahun;
			}

			$data['iuran'] = $standarbayar->iuran;
			$data['sampai'] = $sampai;
			$this->load->model("M_payment");

			$this->load->view('layout/wrapper_umum', $data);
		} else
			redirect("/");
	}

	public function cekstatusverifikator()
	{
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

//		$datesekarang = new DateTime("2021-04-06 11:00:00");

		$iduser = $this->session->userdata('id_user');
		$userlama = false;

		if ($this->session->userdata('statusbayar') == 3) {
			$this->session->set_userdata('a03', false);
			redirect("/");
		} else {
			$this->load->model("M_payment");
			$cekstatusbayar = $this->M_payment->getlastverifikator($iduser, 1);

//			echo "<pre>";
//			echo var_dump($cekstatusbayar);
//			echo "</pre>";

			if ($cekstatusbayar) {
				$statusbayar = $cekstatusbayar->status;

				$tanggalorder = new DateTime($cekstatusbayar->tgl_order);
				$batasorder = $tanggalorder->add(new DateInterval('P1D'));
				$bulanorder = $tanggalorder->format('m');
				$tahunorder = $tanggalorder->format('Y');

				$tanggal = $datesekarang->format('d');
				$bulan = $datesekarang->format('m');
				$tahun = $datesekarang->format('Y');

				$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

				if ($selisih >= 2) {
					if ($cekstatusbayar->tipebayar == "auto")
						$this->session->set_userdata('statusbayar', 1);
					else
						$this->session->set_userdata('statusbayar', 2);
					$this->session->set_userdata('a02', false);
				} else if ($selisih == 1) {

					$this->session->set_userdata('statusbayar', 1);
					if ($tanggal <= 5) {

						$this->session->set_userdata('a02', true);
						$this->session->set_userdata('statusbayar', 2);
						$this->session->set_userdata('a03', false);
					} else {

						$this->session->set_userdata('a02', false);
						if ($statusbayar == 3) {

						} else if ($statusbayar == 1) {

							if ($datesekarang > $batasorder) {

								$datax = array("status" => 0);
								$this->M_payment->update_payment($datax, $iduser, $cekstatusbayar->order_id);

							} else {

								$this->tunggubayar();
							}
						}
					}

				} else {

					if ($statusbayar == 1) {
						if ($datesekarang > $batasorder) {
							$datax = array("status" => 0);
							$this->M_payment->update_payment($datax, $iduser, $cekstatusbayar->order_id);

						} else {
							$this->tunggubayar();
						}
					} else if ($statusbayar == 3) {
						$this->session->set_userdata('a02', true);
						$this->session->set_userdata('a03', false);
						$this->session->set_userdata('statusbayar', 3);
						redirect("/");
					}
				}
			} else {

			}
		}
	}

	public function ganticarabayar($orderid, $opsi=null)
	{
		$iduser = $this->session->userdata('id_user');
		$bayarapa = substr($orderid, 0, 3);
		$this->load->Model('M_channel');
		if ($bayarapa == "PKT") {
			$jenis = substr($orderid, 3, 1);
			$cekbeli = $this->M_channel->cek_kdbeli($orderid, $iduser, 1);
			$tipe = $cekbeli->tipe_bayar;
//			if ($tipe == "gopay")
			{
				$this->M_channel->update_kdbeli($orderid);
			}
			if ($jenis == "1")
				redirect("/vksekolah/set");
			else if ($jenis == "3")
				redirect("/bimbel/page/1");
		} else if ($bayarapa == "TVS") {
			$cekbeli = $this->M_channel->cek_payment($orderid, $iduser, 1);
			$tipe = $cekbeli->tipebayar;
//			if ($tipe == "gopay")
			{
				$this->M_channel->update_payment($orderid);
			}
			if ($opsi=="profil")
				redirect("/profil/pembayaran");
			else
				redirect("/payment/pembayaran");
		} else if ($bayarapa == "EKS" || $bayarapa == "EKZ") {
			$cekbeli = $this->M_channel->cek_payment($orderid, $iduser, 1);
			$tipe = $cekbeli->tipebayar;
//			if ($tipe == "gopay")
			{
				$this->M_channel->update_payment($orderid);
			}
			redirect("/ekskul/daftar_bayar");
		} else if ($bayarapa == "EK1" || $bayarapa == "EK2" || $bayarapa == "EK3" || $bayarapa == "EK4") {
			$cekbeli = $this->M_channel->cek_payment($orderid, $iduser, 1);
			$tipe = $cekbeli->tipebayar;
//			if ($tipe == "gopay")
			{
				$this->M_channel->update_payment($orderid);
			}
			redirect("/profil/pembayaran");
		} else if ($bayarapa == "TP0" || $bayarapa == "TP1" || $bayarapa == "TP2" || $bayarapa == "TF0"
			|| $bayarapa == "TF1" || $bayarapa == "TF2") {
			$cekbeli = $this->M_channel->cek_payment($orderid, $iduser, 1);
			$tipe = $cekbeli->tipebayar;
//			if ($tipe == "gopay")
			{
				$this->M_channel->update_payment($orderid);
			}
			redirect("/profil/pembayaran");
		} else if ($bayarapa == "EVT") {
			$cekbeli = $this->M_channel->cek_payment_event($orderid, $iduser, 1);
			$kodeevent = $cekbeli->code_event;
//			if ($tipe == "gopay")
			{
				$this->M_channel->update_payment_event($orderid);
			}
			redirect("/event/ikutevent/" . $kodeevent);
		}
	}

	private function cekmodul($iduser)
	{
		//$iduser = 5357;
		$this->load->model("M_login");
		$getdatauser = $this->M_login->getUser($iduser);
		$npsnuser = $getdatauser['npsn'];
		$this->load->model("M_payment");
		$cekmodul = $this->M_payment->ceksiap25modulbeli($npsnuser);
//		echo "<pre>";
//		echo var_dump($cekmodul);
//		echo "</pre>";
		$jumlahmodul = sizeof($cekmodul);
		if ($jumlahmodul >= 25) {
			$this->load->model("M_eksekusi");
			$verifikatorlastactived = $this->M_eksekusi->getveraktif($npsnuser);
			if ($verifikatorlastactived) {
				$iduser = $verifikatorlastactived->id;
				$iduserada = true;
			} else {
				$iduser = 0;
				$iduserada = false;
			}

			$timezone = new DateTimeZone('Asia/Jakarta');
			$date = new DateTime();
			$date->setTimeZone($timezone);

			$date->modify('first day of next month');
			$tglorderbaru = $date->format("Y-m-d");

			$data = array(
				"iduser" => $iduser,
				"npsn_sekolah" => $npsnuser,
				"order_id" => "TVS-FREE-OF-MODUL",
				"tgl_order" => $tglorderbaru,
				"tipebayar" => "25modul",
				"status" => 3
			);
			if (!$this->M_payment->ceksudah25modul($npsnuser, $tglorderbaru))
				$this->M_payment->addDonasi($data);
		}
	}

	public function kursidr()
	{
//		$url = $this->fungsiCurl('https://id.valutafx.com/MYR-IDR.htm');
//		print_r($url);

		$url = "https://id.valutafx.com/MYR-IDR.htm";
		include_once('simple_html_dom.php');

		$html = file_get_html('https://id.valutafx.com/MYR-IDR.htm');

		//$dom = str_get_html($html);

		$elem = $html->find('.rate-value', 0);
		echo $elem;
	}

	private function fungsiCurl($url)
	{
		$data = curl_init();
		curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($data, CURLOPT_URL, $url);
		curl_setopt($data, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
		$hasil = curl_exec($data);
		curl_close($data);
		return $hasil;
	}

	public function bayar_mou()
	{
		$this->load->model('M_mou');
		$mouaktif = $this->M_mou->cekmouaktif($this->session->userdata('npsn'), 4);
		if ($mouaktif) {
			$status_tagih1 = $mouaktif->status_tagih1;
			$status_tagih2 = $mouaktif->status_tagih2;
			$status_tagih3 = $mouaktif->status_tagih3;
			$status_tagih4 = $mouaktif->status_tagih4;
			$tagihan1 = $mouaktif->tagihan1;
			$tagihan2 = $mouaktif->tagihan2;
			$tagihan3 = $mouaktif->tagihan3;
			$tagihan4 = $mouaktif->tagihan4;

			if ($status_tagih1 == 0) {
				$tagihantoken = $tagihan1;
				$term = "Term 1";
			} else if ($status_tagih2 == 0) {
				$tagihantoken = $tagihan2;
				$term = "Term 2";
			} else if ($status_tagih3 == 0 && $tagihan3 > 0) {
				$tagihantoken = $tagihan3;
				$term = "Term 3";
			} else if ($status_tagih4 == 0 && $tagihan4 > 0) {
				$tagihantoken = $tagihan4;
				$term = "Term 4";
			}
		} else {
			redirect("/");
		}
	}

	private function masukkanketb_vk($id_user, $order_id , $jenispaket, $linkpaket, $tipebayar, $sejumlah, $jmlmodul)
	{
		$data = array();
		$data['id_user'] = $id_user;
		$data['kode_beli'] = $order_id;
		$data['jenis_paket'] = $jenispaket;
		$data['link_paket'] = $linkpaket;

		$rupiahbruto = $sejumlah / $jmlmodul;

		$this->load->model('M_channel');
		$getinfopaket = $this->M_channel->getInfoBimbel($linkpaket);
		$this->load->model('M_eksekusi');
		$hargastandar = $this->M_eksekusi->getStandar();
		$this->load->model('M_vksekolah');
		$hargapaket = $this->M_vksekolah->gethargapaket("bimbel");

		////////////////////////////// CEK POTONGAN MIDTRANS //////////////////

		if ($tipebayar == "alfamart")
			$potongan = $hargastandar->pot_alfa;
		else if ($tipebayar == "akulaku")
			$potongan = $hargastandar->pot_akulaku / 100 * $sejumlah;
		else if ($tipebayar == "gopay")
			$potongan = $hargastandar->pot_gopay / 100 * $sejumlah;
		else if ($tipebayar == "shopee")
			$potongan = $hargastandar->pot_shopee / 100 * $sejumlah;
		else if ($tipebayar == "qris")
			$potongan = $hargastandar->pot_qris / 100 * $sejumlah;
		else
			$potongan = $hargastandar->pot_midtrans;

		$potonganmidtrans = $potongan / $jmlmodul;
		if ($rupiahbruto == 0)
			$potonganmidtrans = 0;
		$ppn = $hargastandar->ppn;

		$data['rp_bruto'] = $rupiahbruto;
		$data['rp_midtrans'] = $potonganmidtrans;
		$rupiahbruto = $rupiahbruto - $potonganmidtrans;
		$rupiahppn = $rupiahbruto * $ppn / 100;
		$data['rp_ppn'] = $rupiahppn;
		$rupiahnet = $rupiahbruto - $rupiahppn;
		$data['rp_net'] = $rupiahnet;

		///////////////////TUTOR BIMBEL//////////////
		$idkontributor = $getinfopaket->id_user;
		$this->load->Model("M_login");
		$userkontri = $this->M_login->getUser($idkontributor);
		$ceknpwp = $userkontri['npwp'];
		$kotakontri = $userkontri['kd_kota'];
		if ($ceknpwp == null || $ceknpwp == "-")
			$pphtutor = $hargastandar->pph;
		else
			$pphtutor = $hargastandar->pph_npwp;
		$feetutor = $hargastandar->fee_tutor;
		$kontribruto = $rupiahnet * $feetutor / 100;
		$kontripph = $kontribruto * $pphtutor / 100;
		$kontrinet = $kontribruto - $kontripph;
		//--------------------------------------------//
		$data['id_kontri'] = $idkontributor;
		$data['rp_kontri_bruto'] = $kontribruto;
		$data['rp_kontri_pph'] = $kontripph;
		$data['rp_kontri_net'] = $kontrinet;

		////////////////////AGENCY - VERBIMBEL//////////
		$feeagency = $hargastandar->fee_verbimbel;
		$this->load->Model("M_agency");
		$agency = $this->M_agency->getAgency($kotakontri);
		if ($agency) {
			$idagency = $agency[0]->id;
			$ceknpwp = $agency[0]->npwp;
			if ($ceknpwp == null || $ceknpwp == "-")
				$pphagency = $hargastandar->pph;
			else
				$pphagency = $hargastandar->pph_npwp;
			$agencybruto = $rupiahnet * $feeagency / 100;
			$agencypph = $agencybruto * $pphagency / 100;
			$agencynet = $agencybruto - $agencypph;
			//--------------------------------------------//
			$data['id_ag'] = $idagency;
			$data['rp_ag_bruto'] = $agencybruto;
			$data['rp_ag_pph'] = $agencypph;
			$data['rp_ag_net'] = $agencynet;
		} else {
			$data['id_ag'] = 0;
			$data['rp_ag_bruto'] = 0;
			$data['rp_ag_pph'] = 0;
			$data['rp_ag_net'] = 0;
		}


		////////////////////////// MENTOR /////////////////////////
		$feeam = 0;
//				$feeam = $hargastandar->fee_am;
//				$this->load->Model('M_eksekusi');
//				$dataagam = $this->M_eksekusi->getagam($this->session->userdata('npsn'));
//				$idam = $dataagam->am_iduser;
//				$this->load->Model("M_login");
//				$useram = $this->M_login->getUser($idam);
//				if ($useram) {
//					$ceknpwp = $useram['npwp'];
//					if ($ceknpwp==null ||$ceknpwp=="-")
//						$ppham = $hargastandar->pph;
//					else
//						$ppham = $hargastandar->pph_npwp;
//					$ambruto = $rupiahnet*$feeam/100;
//					$ampph = $ambruto*$ppham/100;
//					$amnet = $ambruto - $ampph;
//					//--------------------------------------------//
//					$data[$a]['id_am'] = $idam;
//					$data[$a]['rp_am_bruto'] = $ambruto;
//					$data[$a]['rp_am_pph'] = $ampph;
//					$data[$a]['rp_am_net'] = $amnet;
//				}
//				else
		{
			$data['id_am'] = 0;
			$data['rp_am_bruto'] = 0;
			$data['rp_am_pph'] = 0;
			$data['rp_am_net'] = 0;
		}


		//////////////////TV SEKOLAH///////////////////
		$pphtv = $hargastandar->pph_npwp;
		$feetv = 100 - ($feetutor + $feeagency + $feeam);
		$tvbruto = $rupiahnet * $feetv / 100;
		$tvpph = $tvbruto * $pphtv / 100;
		$tvnet = $tvbruto - $tvpph;
		//--------------------------------------------//
		$data['rp_manajemen_bruto'] = $tvbruto;
		$data['rp_manajemen_pph'] = $tvpph;
		$data['rp_manajemen_net'] = $tvnet;

		$this->load->Model("M_bimbel");
		if ($this->M_bimbel->insertvkeceran($data))
			echo "sukses";
		else
			echo "gagal";
	}

	public function testvv()
	{
		$this->load->model("M_payment");
		$order_id = "TP2-2-1292208483";
		$sejumlah = 750000;
		$type = "bank_transfer";
		$namabank = "bca";
		$rektujuan = "22282237652";
		$transaction_time = "2022-10-09 09:37:24";

		//--------------------------------------------------------
		$this->load->model('M_payment');
		if (substr($order_id, 0, 3) == "TVS"
			|| substr($order_id, 0, 3) == "TP0" || substr($order_id, 0, 3) == "TF0"
			|| substr($order_id, 0, 3) == "TP1" || substr($order_id, 0, 3) == "TF1"
			|| substr($order_id, 0, 3) == "TP2" || substr($order_id, 0, 3) == "TF2") {

			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang = $datesekarang->format("Y-m-d H:i:s");

			$data3 = array('status' => 3, 'tgl_bayar' => $tglsekarang);

			/////////////////////////////////////////////////////////
			$standar = $this->M_payment->getstandar();

			$this->load->model('M_payment');
			$cekorder = $this->M_payment->cekorder($order_id);
			$tipebayar = $cekorder->tipebayar;
			if ($tipebayar == null) {
				$tipebayar = $type;
				$data3['tipebayar'] = $type;
				$data3['namabank'] = $namabank;
				$data3['rektujuan'] = $rektujuan;
				$data3['iuran'] = $sejumlah;
			}

			if ($tipebayar == "alfamart")
				$potongan = $standar->pot_alfa;
			else if ($tipebayar == "akulaku")
				$potongan = $standar->pot_akulaku / 100 * $sejumlah;
			else if ($tipebayar == "gopay")
				$potongan = $standar->pot_gopay / 100 * $sejumlah;
			else if ($tipebayar == "shopee")
				$potongan = $standar->pot_shopee / 100 * $sejumlah;
			else if ($tipebayar == "qris")
				$potongan = $standar->pot_qris / 100 * $sejumlah;
			else
				$potongan = $standar->pot_midtrans;

			$data['potongan'] = $potongan;

			$ppn = $standar->ppn;

			$bruto = $sejumlah - $potongan;
			$rp_ppn = $ppn / 100 * $sejumlah;
			$iurannet = $bruto - $rp_ppn;

			$data3['ppn'] = $rp_ppn;

			$cekorder = $this->M_payment->cekorder($order_id);
			//$npsn = $cekorder->npsn_sekolah;
			$iduser = $cekorder->iduser;
			$this->load->model('M_login');
			$cekuser = $this->M_login->getUserById($iduser);
			$referrer = $cekuser['referrer'];

			//echo $iduser;
			$id_siam = null;
			$id_agency = null;
			$fee_siam = 0;
			$fee_agency = 0;

			if ($referrer != "" && $referrer != null) {
				$this->load->model('M_marketing');
				$cekdataref = $this->M_marketing->getDataRef($referrer);

				$cekdapatfee = $cekdataref->status_feepertama;

				$id_siam = $cekdataref->id_siam;
				$id_agency = $cekdataref->id_agency;

				if ($cekdapatfee == 0 && $sejumlah == 50000) {
					$persen_am = $standar->fee_iuran_am1;
					$persen_agency = $standar->fee_iuran_agency1;
					$dataref = array('status_feepertama' => 1);
					$this->M_marketing->updateDataRef($dataref, $referrer);
				} else {
					$persen_am = $standar->fee_iuran_am;
					$persen_agency = $standar->fee_iuran_agency;
				}
			}

			if ($id_siam != "" && $id_siam != 0)
				$fee_siam = $persen_am * $iurannet / 100;
			if ($id_agency != "" && $id_agency != 0)
				$fee_agency = $persen_agency * $iurannet / 100;

			$data3['fee_siam'] = $fee_siam;
			$data3['fee_agency'] = $fee_agency;
			$data3['id_siam'] = $id_siam;
			$data3['id_agency'] = $id_agency;


			$data3['iuran_net'] = $iurannet - ($data3['fee_siam'] + $data3['fee_agency']);

			///////////////////////////////////////////////////////////////////

			if ($this->M_payment->updatestatuspayment($order_id, $data3)) {
				echo "";
			} else {
				echo "gagal";
			}
		}
	}

	public function tes012($order_id)
	{
		$sejumlah = 300000;
		$type = "tes_type";
		$namabank = "tes_bank";
		$rektujuan = "tes_rek";

		if (substr($order_id, 0, 3) == "TVS"
			|| substr($order_id, 0, 3) == "TP0" || substr($order_id, 0, 3) == "TF0"
			|| substr($order_id, 0, 3) == "TP1" || substr($order_id, 0, 3) == "TF1"
			|| substr($order_id, 0, 3) == "TP2" || substr($order_id, 0, 3) == "TF2") {

			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang = $datesekarang->format("Y-m-d H:i:s");

			$data3 = array('status' => 3, 'tgl_bayar' => $tglsekarang);

			$this->load->model('M_payment');
			$cekorder = $this->M_payment->cekorder($order_id);
			$tipebayar = $cekorder->tipebayar;
			if ($tipebayar == null) {
				$tipebayar = $type;
				$data3['tipebayar'] = $type;
				$data3['namabank'] = $namabank;
				$data3['rektujuan'] = $rektujuan;
				$data3['iuran'] = $sejumlah;
			}

			if ($tipebayar == "gopay")
				$potongan = 0.02 * $sejumlah;
			else
				$potongan = 4400;
			$pph = 0.1 * $sejumlah;
			$iurannet = $sejumlah - $potongan - $pph;

			$data3['potongan'] = $potongan;
			$data3['pph'] = $pph;
			$data3['iuran_net'] = $iurannet;
			$data3['fee_siam'] = 0;
			$data3['fee_agency'] = 0;

			if (substr($order_id, 0, 3) == "TVS"
				|| substr($order_id, 0, 3) == "TP0" || substr($order_id, 0, 3) == "TF0"
				|| substr($order_id, 0, 3) == "TP1" || substr($order_id, 0, 3) == "TF1"
				|| substr($order_id, 0, 3) == "TP2" || substr($order_id, 0, 3) == "TF2") {
				$cekorder = $this->M_payment->cekorder($order_id);
				$npsn = $cekorder->npsn_sekolah;
				$iduser = $cekorder->iduser;
				$this->load->model('M_login');
				$cekuser = $this->M_login->getUser($iduser);
				$referrer = $cekuser['referrer'];
				$standar = $this->M_payment->getstandar();

				if ($referrer != "" && $referrer != null) {
					$this->load->model('M_marketing');
					$cekdataref = $this->M_marketing->getDataRef($referrer);
					$cekdapatfee = $cekdataref->status_feepertama;

					$id_siam = $cekdataref->id_siam;
					$id_agency = $cekdataref->id_agency;

					if ($cekdapatfee == 0) {
						$persen_am = $standar->fee_iuran_am1;
						$persen_agency = $standar->fee_iuran_agency1;
						$dataref = array('status_feepertama' => 1);
						$this->M_marketing->updateDataRef($dataref, $referrer);
					} else {
						$persen_am = $standar->fee_iuran_am;
						$persen_agency = $standar->fee_iuran_agency;
					}
				}

				$data3['id_siam'] = $id_siam;
				$data3['id_agency'] = $id_agency;
				if ($id_siam != "" && $id_siam != null)
					$data3['fee_siam'] = $persen_am * $iurannet / 100;
				if ($id_agency != "" && $id_agency != null)
					$data3['fee_agency'] = $persen_agency * $iurannet / 100;

				$data3['iuran_net'] = $iurannet - ($data3['fee_siam'] + $data3['fee_agency']);

			}


			if ($this->M_payment->updatestatuspayment($order_id, $data3)) {
				echo "";
			} else {
				echo "gagal";
			}

//					$data2 = array('statusbayar' => 3, 'lastorder' => $order_id);
//					$cekorder = $this->M_payment->cekorder($order_id);
//					$iduser=$cekorder->iduser;
//					$this->M_payment->updatestatusbayar($iduser, $data2, 3);

		}
	}

	public function ceklkponoff($npsn)
	{
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$sdatesekarang = $datesekarang->format("Y-m-d H:i:s");

		$this->load->Model('M_payment');
		$tglbayar = $this->M_payment->gettglakhirbayarlkp($npsn);
		$tglbatas = new DateTime($tglbayar->tgl_bayar);
		$tglbatas->add(new DateInterval('P36D'));
		$stglbatas = $tglbatas->format("Y-m-d H:i:s");

		//echo "Tanggal batas:".$stglbatas;

		if (strtotime($sdatesekarang) > strtotime($stglbatas)) {
			//echo "<br>Dah kelewat batas";
			return "lewat";
		} else {
			//echo "<br>Masih belum lewat batas";
			return "dapat";
		}
	}

	public function tesmasukinbimbel($orderid)
	{
		if($this->session->userdata('a01'))
		{
			$transaction = "settlement";
			$transaction_time = "2022-02-18 09:33:53";
			$type = "echannel";
			$fraud = "accept";
			$sejumlah = 25000;
			$this->load->Model("M_payment");
			$cekorder = $this->M_payment->cekvkbeli($orderid);
			$data2 = array('status_beli' => 2, 'tgl_aktif' => $transaction_time);

			/////////////////////////////////////////////////////////

			$tipebayar = $cekorder->tipe_bayar;
			if ($tipebayar == "" || $tipebayar == null) {
				$tipebayar = $type;
				$data2['tipe_bayar'] = $type;
				$data2['nama_bank'] = "bank";
				$data2['rekening_tujuan'] = "756386884";
				$data2['rupiah'] = $sejumlah;
			}

			$this->M_payment->update_vk_beli($data2, $orderid);

			$iduser = $cekorder->id_user;
			$jenispaket = $cekorder->jenis_paket;
			$jmlmodul = $cekorder->jml_modul;

			$posawal = strpos($orderid,"-")+1;
			$panjangsemua = strlen($orderid)-2;
			$panjangkode = $panjangsemua-$posawal;
			$linkpaket = substr($orderid,$posawal,$panjangkode);
			$this->masukkanketb_vk($iduser, $orderid , $jenispaket, $linkpaket, $tipebayar, $sejumlah, $jmlmodul);

		}

	}

	function tes_x01()
	{
		if ($this->session->userdata('loggedIn'))
		{
			$tgl_sekarang=new DateTime();
			$bulanskr = $tgl_sekarang->format("n");
			$modulmana = moduldarike_bulan($bulanskr);
			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($this->session->userdata('id_user'), 1);
			if ($cekbeli)
			{
				$order_id = $cekbeli->kode_beli;
				echo $order_id;
				hitungfeevksekolah($order_id,$modulmana);
			}
		}
	}

	function hitungfee($orderid)
	{
		hitungfeeiuran($orderid);
		//hitungfeeekskul($orderid);
	}

	function hitungfeeekskul($orderid)
	{
		//hitungfeeiuran($orderid);
		hitungfeeekskul($orderid);
	}

	function hitungfeepaket($orderid)
	{
		$tgl_sekarang=new DateTime();
		$bulanskr = $tgl_sekarang->format("n");
		$modulmana = moduldarike_bulan($bulanskr);
		hitungfeevksekolah($orderid,$modulmana);
	}

	function hitungfeeevent($orderid)
	{
		//hitungfeeiuran($orderid);
		hitungfeeevent($orderid);
	}

	function hitungmidtranspayment($orderid)
	{
		$this->load->model('M_payment');
		$cekorder = $this->M_payment->cekorder($orderid);
		$tipebayar = $cekorder->tipebayar;
		$sejumlah = $cekorder->iuran;
		
		$this->load->model('M_eksekusi');
		$standar = $this->M_eksekusi->getStandar();

		$ppn = $standar->ppn;
		$ppnrp = $ppn / 100 * $sejumlah;

		if ($tipebayar == "alfamart") {
			$potongan = $standar->pot_alfa;
			$potonganrp = $potongan;
		} else if ($tipebayar == "akulaku") {
			$potongan = $standar->pot_akulaku / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "gopay") {
			$potongan = $standar->pot_gopay / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "shopee") {
			$potongan = $standar->pot_shopee / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "qris") {
			$potongan = $standar->pot_qris / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "SIPLAH") {
			$ppn = 0;
			$ppnrp = 0;
			$potongan = 0;
			$potonganrp = 0;
		} else {
			$potongan = $standar->pot_midtrans;
			$potonganrp = $potongan;
		}

		if ($sejumlah==0)
			$potonganrp = 0;
		$this->M_payment->updatepaymentmidtrans($orderid, $ppnrp, $potonganrp);
	}

	function hitungmidtransvk($orderid)
	{
		$this->load->model('M_payment');
		$cekorder = $this->M_payment->cekvkbeli($orderid);
		$tipebayar = $cekorder->tipe_bayar;
		$sejumlah = $cekorder->rupiah;
		
		$this->load->model('M_eksekusi');
		$standar = $this->M_eksekusi->getStandar();

		$ppn = $standar->ppn;
		$ppnrp = $ppn / 100 * $sejumlah;

		if ($tipebayar == "alfamart") {
			$potongan = $standar->pot_alfa;
			$potonganrp = $potongan;
		} else if ($tipebayar == "akulaku") {
			$potongan = $standar->pot_akulaku / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "gopay") {
			$potongan = $standar->pot_gopay / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "shopee") {
			$potongan = $standar->pot_shopee / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "qris") {
			$potongan = $standar->pot_qris / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "SIPLAH") {
			$ppn = 0;
			$ppnrp = 0;
			$potongan = 0;
			$potonganrp = 0;
		} else {
			$potongan = $standar->pot_midtrans;
			$potonganrp = $potongan;
		}

		if ($sejumlah==0)
			$potonganrp = 0;
		$this->M_payment->updatevkmidtrans($orderid, $ppnrp, $potonganrp);
	}

	public function hitungpaymentaktif()
	{
		$this->load->model('M_payment');
		$cekpayment = $this->M_payment->cekpaymentaktif();
		foreach ($cekpayment as $row)
		{
			$this->hitungmidtranspayment($row->order_id);
		}
	}

	public function hitungvkaktif()
	{
		$this->load->model('M_payment');
		$cekpayment = $this->M_payment->cekvkbeliaktif();
		foreach ($cekpayment as $row)
		{
			$this->hitungmidtransvk($row->kode_beli);
		}
	}


}
