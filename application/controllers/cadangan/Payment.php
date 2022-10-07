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
		if (base_url() == "http://localhost/fordorum/"||$this->session->userdata('email')=="kumisgentong@gmail.com") {
			$params = array('server_key' => 'SB-Mid-server-dQDHk1T4KGhT9kh24H46iyV-', 'production' => false);
		} else {
			$params = array('server_key' => 'Mid-server-GCS0SuN6kT7cH0G5iTey_-Ct', 'production' => true);
		}

		$this->midtrans->config($params);
		$this->load->helper('url');
		$this->load->helper(array('Form', 'Cookie'));
	}

	public function index()
	{
		setcookie('basis', "informasi", time() + (86400), '/');
		if ($this->session->userdata('loggedIn')) {
			if ($this->session->userdata('activate') == 0)
				redirect('/login/profile');
			else
				$this->bayar();
		} else {
			$this->bayar();
		}
	}

	public function bayar()
	{
		if ($this->session->userdata('loggedIn') && $this->session->userdata('verifikator') > 0) {
			$iduser = $this->session->userdata('id_user');
			$this->load->model('M_payment');
			$statusbayar = $this->M_payment->cekstatusbayar($iduser)->statusbayar;

			if ($statusbayar == 0) {
				$data = array('title' => 'Pembayaran', 'menuaktif' => '0',
					'isi' => 'v_bayarfree');

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

	public function donasi()
	{
		if ($this->session->userdata('loggedIn')) {
			$this->load->model('M_payment');

			$cekdonasipending = $this->M_payment->getlastdonasi($this->session->userdata('id_user'), 1);
			if ($cekdonasipending)
			{
				redirect("/payment/infodonasi");
			}
			else {
				$data = array('title' => 'Donasi', 'menuaktif' => '0',
					'isi' => 'v_donasi');

				$data['dafdonasi'] = $this->M_payment->getdonasipil();
			}
		} else {
			$data = array('title' => 'Donasi', 'menuaktif' => '0',
				'isi' => 'v_donasi_login');
		}
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		$this->load->view('layout/wrapperpayment', $data);
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

	public function token()
	{

		// Required
		$this->load->model("M_payment");
		$iuran = $this->M_payment->getiuran();
//        echo $iuran;
//        die();
		$transaction_details = array(
			'order_id' => "TVS-" . rand(),
			'gross_amount' => $iuran, // no decimal allowed for creditcard
		);

		// Optional
		$item1_details = array(
			'id' => 'a1',
			'price' => $iuran,
			'quantity' => 1,
			'name' => "Pembayaran TV Sekolah"
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

	public function finish()
	{
		$result = json_decode($this->input->post('result_data'));
//        echo 'RESULT <br><pre>';
//        var_dump($result);
//        echo '</pre>' ;
		$iduser = $this->session->userdata('id_user');
		$order_id = $result->order_id;
		$tgl_order = $result->transaction_time;
		$tipebayar = $result->payment_type;
		$namabank = $result->va_numbers[0]->bank;
		$rektujuan = $result->va_numbers[0]->va_number;
		$this->load->model('M_payment');
		$iurananggota = $this->M_payment->getiuran();
		$data = array('iduser' => $iduser, 'order_id' => $order_id,
			'tgl_order' => $tgl_order, 'tipebayar' => $tipebayar,
			'namabank' => $namabank, 'rektujuan' => $rektujuan, 'iuran' => $iurananggota);
		$this->M_payment->tambahbayar($data);
		$data2 = array('statusbayar' => 1, 'lastorder' => $order_id);
		$this->M_payment->updatestatusbayar($iduser, $data2);
		$this->session->set_userdata('statusbayar', 1);
		redirect("/payment/tunggubayar");
	}

	public function token_event($kodeevent)
	{

		$this->load->model("M_payment");

		$iuran = $this->M_payment->getiuranevent($kodeevent);
		$namaevent = substr($this->M_payment->getnamaevent($kodeevent), 0, 34);

		$transaction_details = array(
			'order_id' => "EVT-" . rand(),
			'gross_amount' => $iuran, // no decimal allowed for creditcard
		);

		// Optional
		$item1_details = array(
			'id' => 'a1',
			'price' => $iuran,
			'quantity' => 1,
			'name' => "Iuran Event " . $namaevent
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
			if (isset($result->permata_va_number))
			{
				$namabank = "Bank Permata";
				$rektujuan = $result->permata_va_number;
			}
			else {
				$namabank = $result->va_numbers[0]->bank;
				$rektujuan = $result->va_numbers[0]->va_number;
			}
		} else if ($tipebayar == "echannel") {
			$namabank = "Mandiri";
			$rektujuan = $result->biller_code."-".$result->bill_key;
		} else if ($tipebayar == "gopay") {
			$namabank = "gopay";
			$rektujuan = "";
		} else {
			$namabank = "";
			$rektujuan = "";
		}

		$data = array();

		$data['code_event'] = $codeevent;
		$data['order_id'] = $order_id;
		$data['id_user'] = $iduser;
		$data['npsn'] = $this->session->userdata('npsn');
		$data['tipebayar'] = $tipebayar;
		$data['tgl_bayar'] = $tgl_order;
		$data['nama_bank'] = $namabank;
		$data['no_rek'] = $rektujuan;
		$data['petunjukbayar'] = $petunjuk;

		$this->load->model('M_payment');
		$data['iuran'] = $this->M_payment->getiuranevent($codeevent);

		$data['status_user'] = 1;

		$this->load->model('M_video');
//		echo "ID:".$iduser."<br>";
//		echo "KODE:".$codeevent;

		$cekdulu = $this->M_video->cekUserEvent($codeevent,$iduser,1);
		echo 'RESULT <br><pre>';
        var_dump($cekdulu);
        echo '</pre>' ;
		if ($cekdulu)
		{
			$this->M_video->updatetglbayarevent($codeevent,$iduser,$data);
		}
		else
		{
			$this->M_video->addbukti($data);
		}

		$this->session->set_userdata('statusbayarevent', 1);

		redirect('/event/spesial/acara');
	}

	public function free_event($kodeevent) {
		$this->load->model('M_payment');
		$cekiuran = $this->M_payment->getiuranevent($kodeevent);
		if ($cekiuran!=0)
		{
			redirect("/event/spesial/acara");
		} else {
			if (isset($this->session->userdata['id_user'])) {
				$data['code_event'] = $kodeevent;
				$data['id_user'] = $this->session->userdata('id_user');
				$this->load->model('M_video');
				$cekuser = $this->M_video->cekUserEvent($kodeevent,
					$this->session->userdata('id_user'),0);
//				echo 'RESULT <br><pre>';
//        		var_dump($cekuser);
//       			echo '</pre>' ;
				if ($cekuser)
				{
					if ($this->session->userdata('linkakhir')) {
						$alamat = $this->M_video->getEventbyCode($this->session->userdata('linkakhir'));
						$link = $alamat[0]->link_event;
						redirect("event/pilihan/" . $link);
					}
				}
				else {
					$data['iuran'] = 0;
					$data['npsn'] = $this->session->userdata('npsn');
					$data['status_user'] = 2;
					$this->load->model('M_video');
					$this->M_video->addbukti($data);
					$this->session->set_userdata('statusbayarevent', 2);
					if ($this->session->userdata('linkakhir')) {
						$alamat = $this->session->userdata('linkakhir');
						redirect("/event/terdaftar/" . $alamat);
					}
				}
			}
			else
			{
				redirect("/");
			}
		}
	}

	public function token_donasi($pilihan)
	{
		$this->load->model("M_payment");

		if ($pilihan > 4)
			$iuran = $pilihan;
		else
			$iuran = $this->M_payment->getdonasipil($pilihan);
		//echo $iuran;
		//die();
		$transaction_details = array(
			'order_id' => "DNS-" . rand(),
			'gross_amount' => $iuran, // no decimal allowed for creditcard
		);

		// Optional
		$item1_details = array(
			'id' => 'a1',
			'price' => $iuran,
			'quantity' => 1,
			'name' => "DONASI UNTUK FORDORUM"
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
		$donasi = $result->gross_amount;
		if ($tipebayar == "bank_transfer") {
			$namabank = $result->va_numbers[0]->bank;
			$rektujuan = $result->va_numbers[0]->va_number;
		} else if ($tipebayar == "echannel") {
			$namabank = "";
			$rektujuan = $result->bill_key;
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

		$data['status'] = 1;

		$this->load->model('M_payment');
		$this->M_payment->addDonasi($data);
		$this->session->set_userdata('statusdonasi', 1);

		redirect('/payment/infodonasi');
	}

	public function infodonasi()
	{
		$this->load->model('M_payment');
		$cekdonasipending = $this->M_payment->getlastdonasi($this->session->userdata('id_user'), 1);
		if ($cekdonasipending) {
			$data = array('title' => 'Ierimakasih', 'menuaktif' => '28',
				'isi' => 'v_donasi_info');
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();
			$data['email'] = $this->session->userdata('email');
			$data['donasi'] = $cekdonasipending;
			$this->load->view('layout/wrapper3', $data);
		} else {
			redirect("/");
		}
	}

	public function notifikasi($opsi=null)
	{

		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);


		if ($result) {
//			$order_id = $result->order_id;
//			$this->load->model('M_payment');
//			$iduser = $this->M_payment->cekevent($order_id);
//			$iduser = $iduser->id_user;
//			echo $iduser;
//			if ($iduser==1)
//			{
//				$notif = $this->midtrans->status($result->order_id);
//				$transaction = $notif->transaction_status;
//				$type = $notif->payment_type;
//				$order_id = $notif->order_id;
//				$fraud = $notif->fraud_status;
//			}
//			else {
				//$notif = $this->midtrans->status($result->order_id);
				$transaction = $result->transaction_status;
				$type = $result->payment_type;
				$order_id = $result->order_id;
				$fraud = $result->fraud_status;
//			}
//
//			echo "point 2 here<br>";

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
				echo "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
				$this->load->model('M_payment');
				if (substr($order_id, 0, 3) == "TVS") {
					$data2 = array('statusbayar' => 3, 'lastorder' => $order_id);
					$iduser = $this->M_payment->cekorder($order_id)->iduser;
					$this->M_payment->updatestatusbayar($iduser, $data2, 3);
					$this->session->set_userdata('statusbayar', 3);
					$this->session->set_userdata('a03', true);
					$data3 = array('status' => 2);
					$this->M_payment->updatestatuspayment($order_id, $data3);
				} else if (substr($order_id, 0, 3) == "EVT") {
//					$this->load->model('M_payment');
//					$iduser = $this->M_payment->cekevent($order_id);
//					$iduser = $iduser->id_user;
					$data2 = array('status_user' => 2);
//					if ($iduser==1)
//						$data2['nama_rek'] = "kumis";
					$this->M_payment->updatestatusbayarevent($order_id, $data2);
//					echo "<br>cihuy";
				} else if (substr($order_id, 0, 3) == "DNS") {
					$iduser = $this->M_payment->cekorder($order_id);
					$iduser = $iduser->iduser;
					$data2 = array('status' => 2);
					$this->M_payment->updatestatuspayment($order_id, $data2);
					$this->M_payment->updatestatusdonasi($iduser, 2);
					$this->session->set_userdata('statusdonasi', 2);
//					$this->sertifikatdonasi($order_id);
					//echo "iduser:".$iduser;
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
			error_log(print_r($result, TRUE));
		}

		//notification handler sample
	}

	public function cetakdonasi($orderid)
	{
		$this->sertifikatdonasi($orderid);
	}

	public function sertifikatdonasi($orderid)
	{
		$this->load->model('M_payment');
		$cekstatus = $this->M_payment->ambilorder($orderid);
		if ($cekstatus[0]->status == 2) {
			$iduser = $cekstatus[0]->iduser;
			$email = $cekstatus[0]->email;
			$data['donasi'] = $cekstatus;
			$data['orderid'] = $orderid;
			$this->load->view('v_sertifikat', $data);
			$this->send_emails($email, $orderid);
		} else {
			echo "BUKAN HAK ANDA";
		}
	}

	private function send_emails($email, $orderid)
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

		$this->email->from('sekretariat@tvsekolah.id', 'Sekretariat TVSekolah');
		$this->email->to($email);
		$this->email->subject('Sertifikat Donasi');
		$this->email->message($message);
		$this->email->message($message);
		$this->email->attach(base_url() . 'uploads/sertifikat/sert_donasi_' . $orderid . '.pdf');

//		echo ("Hasil:".base_url().'uploads/sertifikat/sert_donasi_'.$orderid.'.pdf');
//		die();

		if ($this->email->send()) {
			//echo "Berhasil";
			$this->session->set_flashdata('message', 'Sertifikat dikirim ke email');
		} else {
			redirect(base_url() . "informasi/sertifikatthanks");
			$this->session->set_flashdata('message', $this->email->print_debugger());
		}

		redirect(base_url() . "informasi/sertifikatthanks");
	}

	public function tunggubayar()
	{
		if ($this->session->userdata('loggedIn')) {
			$iduser = $this->session->userdata('id_user');
			$this->load->model('M_payment');
			$statusbayar = $this->M_payment->cekstatusbayar($iduser)->statusbayar;

			if ($statusbayar == 1) {
				$data = array('title' => 'Pembayaran', 'menuaktif' => '0',
					'isi' => 'v_tunggubayar');

				$lastorder = $this->M_payment->cekstatusbayar($iduser)->lastorder;

				if ($this->M_payment->cekorder($lastorder) == "error") {
					$data['namabank'] = "XXX";
					$data['rektujuan'] = "XXX";
					$data['order_id'] = "XXX";
					$data['tgl_order'] = "XXX";
				} else {
					$data['namabank'] = $this->M_payment->cekorder($lastorder)->namabank;
					$data['rektujuan'] = $this->M_payment->cekorder($lastorder)->rektujuan;
					$data['order_id'] = $this->M_payment->cekorder($lastorder)->order_id;
					$tglorder = $this->M_payment->cekorder($lastorder)->tgl_order;
					$tglorder = new DateTime($tglorder);
					//echo "<br><br><br><br><br>IKI TANGGALE:".$tglorder->format('Y-m-d H:i:s');
					$tglorder->add(new DateInterval('P1D'));
					$data['tgl_order'] = $tglorder;
				}

				$data['iuran'] = $this->M_payment->getiuran();

				$this->load->view('layout/wrapper3', $data);
			} else
				redirect("/");
		} else {
			redirect("/");
		}
	}

	public function transaksi($opsi = null)
	{
		if (($this->session->userdata('a01') || $this->session->userdata('email') == 'CEO@tvsekolah.id')) {

			$data = array('title' => 'Transaksi', 'menuaktif' => '23',
				'isi' => 'v_transaksi');
			//$data['sortby'] = '';
			$this->load->model("M_payment");
			$data['daftransaksi'] = $this->M_payment->gettransaksi($opsi);

			$this->load->view('layout/wrapper', $data);
		} else
			redirect('/');
	}


	public function tesnotifikasi_8747387834738($order_id)
	{
//        $iduser = $this->session->userdata('id_user');
//        echo 'test notification handler';
//		$json_result = file_get_contents('php://input');
//		$result = json_decode($json_result);
		$result = true;

		if ($result) {
//			$notif = $this->midtrans->status($result->order_id);
			$transaction = "settlement";
//			$type = $notif->payment_type;
//			$order_id = $notif->order_id;
//			$fraud = $notif->fraud_status;

//            $transaction = 'settlement';
//            $type = "kredit";
//            $fraud = "celeng";
//            $order_id = "TVS-000";

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
				if (substr($order_id, 0, 3) == "TVS") {
					$data2 = array('statusbayar' => 3, 'lastorder' => $order_id);
					$iduser = $this->M_payment->cekorder($order_id)->iduser;
					$this->M_payment->updatestatusbayar($iduser, $data2, 3);
					$this->session->set_userdata('statusbayar', 3);
					$this->session->set_userdata('a03', true);
					$data3 = array('status' => 2);
					$this->M_payment->updatestatuspayment($order_id, $data3);
				} else if (substr($order_id, 0, 3) == "EVT") {
					//$iduser = $this->M_payment->cekevent($order_id)->iduser;
					$data2 = array('status_user' => 2);
					$this->M_payment->updatestatusbayarevent($order_id, $data2);
				} else if (substr($order_id, 0, 3) == "DNS") {
					$iduser = $this->M_payment->cekorder($order_id);
					$iduser = $iduser->iduser;
					$data2 = array('status' => 2);
					$this->M_payment->updatestatuspayment($order_id, $data2);
					$this->M_payment->updatestatusdonasi($iduser, 2);
					$this->session->set_userdata('statusdonasi', 2);
					$this->sertifikatdonasi($order_id);
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
			error_log(print_r($result, TRUE));
		}

		//notification handler sample
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
		$url = base_url().'payment/notifikasi';

		$ch = curl_init($url);

		$jsonData = array(
			"transaction_time" => "2020-10-07 09:41:02",
 			 "transaction_status" => "settlement",
			  "transaction_id" => "1df52f91-6517-460b-903e-9ac3424df6fe",
			  "status_message" => "midtrans payment notification",
			  "status_code" => "200",
			  "signature_key" =>"d175e394556099ad83b2d2706ec2b686cb8d4b3ece9be5a7c216d773a202bd531caf94c0779d092d3495b5f2bb83d4603a50e9e8904a02baaa0d002824f90839",
			  "settlement_time" => "2020-10-06 23:10:39",
			  "payment_type" => "echannel",
			  "order_id" => "EVT-891082891",
			  "merchant_id" => "G961922282",
			  "gross_amount" => "150000.00",
			  "fraud_status" => "accept",
			  "currency" => "IDR",
			  "biller_code" => "70012",
			  "bill_key" => "954356298778"
		);

		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
	}
}
