<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ekskul extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_induk");
		$this->load->model("M_ekskul");
		$this->load->model("M_payment");
		$this->load->library('Pdf');
		$this->load->helper(array('tanggalan', 'video', 'Form', 'Cookie', 'download','statusverifikator'));
		if (!$this->session->userdata('loggedIn')) {
			redirect('/informasi/ekstrakurikuler');
		}

		if ($this->session->userdata('a01') || $this->session->userdata('a02')
			|| ($this->session->userdata('sebagai') == 1 && 
			($this->session->userdata('verifikator') ==1 || 
			$this->session->userdata('verifikator') == 3))
			|| $this->session->userdata('sebagai') == 2) {
		} else {
			redirect('/informasi/ekstrakurikuler');
		}

	}

	public function index()
	{
		$npsn = $this->session->userdata('npsn');
		$data = array();

		$dataekskul = $this->ambildata($npsn);
		$jmlpeserta = count($dataekskul);
		$jmlpesertaaktif = $this->cekpesertaaktif($dataekskul);

		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
		$tanggalnya = $tglsekarang->format("d");
		$bulannya = $tglsekarang->format("n");
		$tahunnya = $tglsekarang->format("Y");
		$tanggalakhir = $tglsekarang->format("t");

		$data['tgl_skr'] = $tanggalnya;
		$data['bln_skr'] = $bulannya;
		$data['thn_skr'] = $tahunnya;

		$data['dataekskul'] = $dataekskul;
		$data['jmlpeserta'] = $jmlpeserta;

		$tanggalsekarang = $tglsekarang->format("Y-m-d");
		$data['lunas'] = substr(namabulan_pendek($tanggalsekarang), 3) . " [belum bayar]";

		//$bulannya="01";

		if ($tanggalnya >= 22) {
			$data['rentang_tgl'] = "22 - " . $tanggalakhir;
			$cekvideo = $this->cekvideoupload($tahunnya . "/" . $bulannya . "/22", $tahunnya . "/" . $bulannya . "/" . $tanggalakhir);
		} else if ($tanggalnya >= 15) {
			$data['rentang_tgl'] = "15 - 21";
			$cekvideo = $this->cekvideoupload($tahunnya . "/" . $bulannya . "/15", $tahunnya . "/" . $bulannya . "/21");
		} else if ($tanggalnya >= 8) {
			$data['rentang_tgl'] = "8 - 14";
			$cekvideo = $this->cekvideoupload($tahunnya . "/" . $bulannya . "/08", $tahunnya . "/" . $bulannya . "/14");
		} else if ($tanggalnya >= 1) {
			$data['rentang_tgl'] = "1 - 7";
			$cekvideo = $this->cekvideoupload($tahunnya . "/" . $bulannya . "/01", $tahunnya . "/" . $bulannya . "/07");
		}

//		echo "Tahun:".$tahunnya.", Bulan:".$bulannya;
//		die();

		$cekvideosemua = $this->cekvideoupload(null, null);


		if ($this->session->userdata('sebagai') == 1 && $this->session->userdata('verifikator') == 3) {
			$data ['konten'] = "ekskul_dashboard_verifikator";

			$jmltungguver = 0;
			$jmltungguversemua = 0;

			$jmlokminggu = 0;
			$jmloksemua = 0;

			$totalminggu = 0;
			$totalsemua = 0;

			if ($cekvideo!=" - ")
			$totalminggu = count($cekvideo);

			if ($cekvideosemua!=" - ")
				$totalsemua = count($cekvideosemua);

//			echo "<pre>";
//			echo var_dump($cekvideo);
//			echo "</pre>";
//			die();


			if ($cekvideo != " - ") {
				foreach ($cekvideo as $datavideo) {
					if ($datavideo->status_verifikasi == 0)
						$jmltungguver++;
					else if ($datavideo->status_verifikasi >= 2)
						$jmlokminggu++;
				}
			}

			if ($cekvideosemua != " - ") {
				foreach ($cekvideosemua as $datavideosemua) {
					if ($datavideosemua->status_verifikasi == 0)
						$jmltungguversemua++;
					else if ($datavideosemua->status_verifikasi >= 2)
						$jmloksemua++;
				}
			}

			$data['keteranganmingguan'] = "Total semua video: ".$totalminggu;

			if ($jmltungguver == 0 && $jmlokminggu>0)
				$data['keteranganmingguan'] = "Total : ".$totalminggu. " Video <br> - " . $jmlokminggu . " video OK";
			else if ($jmltungguver > 0)
				$data['keteranganmingguan'] = "Total : ".$totalminggu. " Video <br> - " .
					$jmltungguver . " video perlu diverifikasi";

			$tambahan = "";

			$jmltungguversemua = $jmltungguversemua - $jmltungguver;

			if ($jmltungguversemua > 0)
				$tambahan = "Dan masih ada " . $jmltungguversemua . " video lama belum diverifikasi";

			$data['keteranganmingguan'] = $data['keteranganmingguan'] . "<br>" . $tambahan;

			$getPaketChannel = $this->M_ekskul->getPaketChannelSekolahVer($npsn);
			$namapenyusun = $getPaketChannel->first_name . " " . $getPaketChannel->last_name;
			$tglsusun = $getPaketChannel->modified;
			$tglmenyusun = namabulan_pendek($tglsusun) . " " . substr($tglsusun, 11);
			$harimenyusun = namahari_panjang($getPaketChannel->hari);

			if ($getPaketChannel->iduser == 0)
				$data['keteranganbulanan'] = "Belum ada siswa yang menyusun";
			else
				$data['keteranganbulanan'] = "Penyusun terakhir playlist:<br> - Hari: " . $harimenyusun . "<br>" .
					" - Oleh: " . $namapenyusun . "<br> - Tanggal: " . $tglmenyusun;

			if ($jmlpeserta == 0)
				$data['keteranganpeserta'] = "Belum ada peserta mendaftar";
			else
				if ($jmlpeserta == $jmlpesertaaktif)
					$data['keteranganpeserta'] = "Terdapat " . $jmlpeserta . " siswa aktif";
				else
					$data['keteranganpeserta'] = "Terdapat " . $jmlpesertaaktif . " peserta aktif dan " . ($jmlpeserta - $jmlpesertaaktif) .
						" siswa belum aktif";
		} else {
			$id = $this->session->userdata('id_user');
			$status = $this->cekstatus($dataekskul);

			if ($this->session->userdata('verifikator')==1)
			{
				$getuser = getstatususer();
				$referrer = $getuser['referrer'];
				if ($referrer!="" && $referrer!=null)
					$data ['konten'] = "ekskul_daftar";
			}
			else if ($jmlpeserta >= 3) {
				$data ['konten'] = "ekskul_dashboard";
			} else {
				$data ['konten'] = "ekskul_daftar";
			}

			$this->load->Model('M_payment');
			$cekbayar = $this->M_payment->getlastpaymentekskul($id);
			
			// echo var_dump($cekbayar);

			if ($cekbayar) {
				$awalnyamulai = new DateTime($cekbayar->tgl_bayar);
				$tahunmulai = $awalnyamulai->format("Y");
				$bulanmulai = $awalnyamulai->format("n");
				$awalnyaakhir = new DateTime($cekbayar->tgl_berakhir);
				$tahunawalakhir = $awalnyaakhir->format("Y");
				$bulanawalakhir = $awalnyaakhir->format("n");
				$awalnyaakhir = $awalnyaakhir->format("Y-m-01 23:59:59");
				$besoknyaakhir = new DateTime($awalnyaakhir);
				$besoknyaakhir = $besoknyaakhir->modify('+1 month');
				$tahunakhir = $besoknyaakhir->format("Y");
				$bulanakhir = $besoknyaakhir->format("n");

				$tanggalsekarang = $tglsekarang->format("Y-m-d");
				//$data['lunas'] = substr(namabulan_pendek($tanggalsekarang), 3) . " [belum bayar]";

				if ($bulanmulai == $bulanawalakhir || $tahunawalakhir == "2001") {
					$ketbulantahun = nmbulan_pendek($bulanmulai) . " " . $tahunmulai;
				} else {
					if ($tahunmulai != $tahunawalakhir)
						$ketbulantahun = nmbulan_pendek($bulanmulai) . " " . $tahunmulai . " - " .
							nmbulan_pendek($bulanawalakhir) . " " . $tahunawalakhir;
					else
						$ketbulantahun = nmbulan_pendek($bulanmulai) . " - " .
							nmbulan_pendek($bulanawalakhir) . " " . $tahunawalakhir;
				}

				$dibayaroleh = $this->cekbayareskul();

				if ($status == 2 || $status == 12) {
					if ($bulannya == $bulanakhir && $tahunnya == $tahunakhir)
						$data['lunas'] = "<b>" . $ketbulantahun . "</b> [silakan bayar sebelum tanggal 5]";
					else
					{
						if (substr($cekbayar->order_id,0,3)=="EKF")
							$data['lunas'] = "<b>" . $ketbulantahun . "</b> [gratis]";
						else
							$data['lunas'] = "<b>" . $ketbulantahun . "</b> [lunas]";
					}

				} else {
					$data['lunas'] = "<b>" . substr(namabulan_pendek($tanggalsekarang), 3) . "</b> [belum bayar]";
				}

				if ($dibayaroleh == "sekolah") {
					$data['lunas'] = "<b>" . substr(namabulan_pendek($tanggalsekarang), 3) . "</b> [lunas]".
						"<br> Oleh Sekolah";
				}
			}
			else
			{
				$dibayaroleh = $this->cekbayareskul();

				if ($status == 2 || $status == 12) {
					if ($bulannya == $bulanakhir && $tahunnya == $tahunakhir)
						$data['lunas'] = "<b>" . $ketbulantahun . "</b> [silakan bayar sebelum tanggal 5]";
					else
						$data['lunas'] = "<b>" . $ketbulantahun . "</b> [lunas]";
				} else {
					$data['lunas'] = "<b>" . substr(namabulan_pendek($tanggalsekarang), 3) . "</b> [belum bayar]";
				}

				if ($dibayaroleh == "sekolah") {
					$data['lunas'] = "<b>" . substr(namabulan_pendek($tanggalsekarang), 3) . "</b> [lunas]".
					"<br> Oleh Sekolah";
				}
			}

			$data['statuspeserta'] = $status;
			$data['tgl_upload'] = substr(namabulan_pendek(substr($cekvideo, 0, 10)), 0, 6);

			$cekplaylist = $this->cekplaylist($id, $bulannya);
			if ($cekplaylist == " - ")
				$data['tgl_playlist'] = " - ";
			else
				$data['tgl_playlist'] = substr(namabulan_pendek(substr($cekplaylist->modified, 0, 10)), 0, 6);

			$cektugas = $this->cektugassiswa();
			if ($cektugas=="lulus" || $this->session->userdata('id_user')==115)
				{
					$data['linksertifikat'] = base_url()."ekskul/sertifikat_download";
					$data['keterangansertifikat'] = "<b>Unduh Sertifikat</b>";
				}
			else
				{
					$data['linksertifikat'] = "#";
					$data['keterangansertifikat'] = "Sertifikat belum tersedia";
				}

		}

		$dibayaroleh = $this->cekbayareskul();
		$jmlpembayar = substr($dibayaroleh, 6);
		$data['dibayaroleh'] = $dibayaroleh;
		$data['jmlpembayar'] = $jmlpembayar;


		if ($dibayaroleh == "sekolah") {
			$data['keteranganpembayaran'] = "<br>Telah dibayarkan oleh sekolah";
			$data['keteranganpeserta'] = "Terdapat " . $jmlpeserta . " siswa aktif";
		} else if (substr($dibayaroleh, 0, 5) == "siswa") {
			$data['keteranganpembayaran'] = "<br>Ada " . $jmlpembayar . " siswa telah membayar";
		} else if ($dibayaroleh == "-") {
			$getpembayar = $this->M_ekskul->cekpembayar();
			if ($getpembayar->pembayarekskul == 1) {
				$data['keteranganpembayaran'] = "[belum aktif]<br>Pembayaran:<br> - Oleh: Sekolah";
				$data['lunas'] = "Menunggu pembayaran oleh Sekolah";
			} else {
				$data['keteranganpembayaran'] = "[belum aktif]<br>Daftar Pembayaran oleh Siswa<br>";
			}
		}

//		echo "<pre>";
//		echo var_dump($dataekskul);
//		echo "</pre>";
//		die();
//
//		echo $status;
//		echo ":".substr($status,1,1);
//		die();

//		echo $statuspeserta;
//		die();

		$this->load->view('layout/wrapper_umum', $data);

	}

	private function cekbayareskul()
	{

		$getbayarekskul = $this->M_payment->getbayarEkskul($this->session->userdata('npsn'), null, 3, true);

		// echo "<pre>";
		// echo var_dump($getbayarekskul);
		// echo "</pre>";
//		die();

		$jmlsiswabayar = 0;
		$jmlverbayar = 0;
		foreach ($getbayarekskul as $databayar) {
			if ($databayar->sebagai == 1) {
				$jmlverbayar++;
			} else if ($databayar->sebagai == 2) {
				$jmlsiswabayar++;
			}
		}

		if ($jmlverbayar > 0)
			return "sekolah";
		else if ($jmlsiswabayar > 0)
			return "siswa_" . $jmlsiswabayar;
		else
			return "-";
	}

	private function cekvideoupload($tglawal, $tglakhir)
	{
		if ($this->session->userdata('sebagai') == 1 && $this->session->userdata('verifikator') == 3) {
			$hasil = $this->M_ekskul->getVideoUploadSiswa($this->session->userdata('npsn'), $tglawal, $tglakhir);

//			echo "aaa<pre>";
//			echo var_dump($hasil);
//			echo "</pre>";
//			die();

			if ($hasil == null)
				return " - ";
			else
				return $hasil;
		} else {
			$hasil = $this->M_ekskul->getVideoUpload($this->session->userdata('id_user'), $tglawal, $tglakhir);
			if ($hasil == null)
				return " - ";
			else
				return $hasil->modified;
		}
	}

	private function cekplaylist($id, $bulansekarang)
	{
		$hasil = $this->M_ekskul->getPaketChannelSekolah($id);
		if ($hasil == null)
			return " - ";
		else {
			if (intval(substr($hasil->modified, 5, 2)) == $bulansekarang)
				return $hasil;
			else
				return " - ";
		}
	}

	public function daftar_bayar()
	{
		$npsn = $this->session->userdata('npsn');
		$id = $this->session->userdata('id_user');
		$databayar = $this->ambildatabayar($npsn, $id);

		$jmlbayar = count($databayar);
		$cekbayarakhir = $this->cekbayarakhir($jmlbayar, $databayar);
		if ($cekbayarakhir) {
			$statusbayar = $cekbayarakhir->status;
			if ($cekbayarakhir->tgl_berakhir == "2001-01-01 00:00:00")
				$bayarakhir = $cekbayarakhir->tgl_bayar;
			else
				$bayarakhir = $cekbayarakhir->tgl_berakhir;
		} else {
			$statusbayar = 0;
			$bayarakhir = "";
		}
//
//		echo "id".$id;
//		echo "<pre>";
//		echo var_dump($cekbayarakhir);
//		echo "</pre>";

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tanggalsekarang = $datesekarang->format("Y-m-d H:i:s");
		$bulansekarang = $datesekarang->format('m');
		$tahunsekarang = $datesekarang->format('Y');
		$batastanggal = $datesekarang;
		$batastanggal = $batastanggal->modify('-1 day');
		$batastanggal = $batastanggal->format("Y-m-d H:i:s");

		if ($statusbayar == 1) {
			$batasbayar = $cekbayarakhir->tgl_order;
			$orderid = $cekbayarakhir->order_id;

			if (strtotime($batastanggal) > strtotime($batasbayar)) {
				$databayar = Array();
				$databayar['status'] = 0;
				$this->load->model('M_payment');
				$this->M_payment->update_payment($databayar, $id, $orderid);
				$databayar = $this->ambildatabayar($npsn, $id);
				$jmlbayar = count($databayar);
				$cekbayarakhir = $this->cekbayarakhir($jmlbayar, $databayar);
			}
		}
//		else if ($statusbayar == 3)
//		{
		$bulaninisudah = false;
		$bulanbayarakhir = substr($bayarakhir, 5, 2);
		$tahunbayarakhir = substr($bayarakhir, 0, 4);


		if ($tahunsekarang == $tahunbayarakhir && $bulansekarang == $bulanbayarakhir) {
			$bulaninisudah = true;
		}

		if ($statusbayar == 3 && strtotime($tanggalsekarang) <= strtotime($bayarakhir)) {
			$bulaninisudah = true;
		}

		$getpembayar = $this->M_ekskul->cekpembayar();

		if ($getpembayar->pembayarekskul == 1) {
			$pembayar = "sekolah";
		} else
			$pembayar = "siswa";

		$data = array();
		$data['konten'] = "ekskul_bayar";
		$data['bulaninisudah'] = $bulaninisudah;
		$data['databayar'] = $databayar;
		$data['pembayar'] = $pembayar;
		$this->load->view('layout/wrapper_payment', $data);
//		}
//		else
//		{
//			redirect('ekskul');
//		}

		//$jmlbayar = count($databayar);

	}

	public function daftar_bayar_verifikator($asal=null)
	{
		if ($this->session->userdata('sebagai') == 1) {

			$npsn = $this->session->userdata('npsn');
			$id = $this->session->userdata('id_user');
			$databayar = $this->ambildatabayarsekolah($npsn);

			$jmlbayar = count($databayar);
			$cekbayarakhir = $this->cekbayarakhir($jmlbayar, $databayar);
//			echo "<pre>";
//			echo var_dump($cekbayarakhir);
//			echo "</pre>";
//			die();
			if ($cekbayarakhir) {
				$statusbayar = $cekbayarakhir->status;
				$bayarakhir = $cekbayarakhir->tgl_bayar;
			} else {
				$statusbayar = 0;
				$bayarakhir = "";
			}

			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$bulansekarang = $datesekarang->format('m');
			$tahunsekarang = $datesekarang->format('Y');
			$batastanggal = $datesekarang;
			$batastanggal = $batastanggal->modify('-1 day');
			$batastanggal = $batastanggal->format("Y-m-d H:i:s");

			$dibayaroleh = $this->cekbayareskul();
			$getpembayar = $this->M_ekskul->cekpembayar();

			if (substr($dibayaroleh, 0, 5) == "siswa")
				$dibayaroleh = "siswa";

			if ($getpembayar->pembayarekskul == 1)
				$pembayar = "sekolah";
			else
				$pembayar = "siswa";

			if ($statusbayar == 1) {
				$batasbayar = $cekbayarakhir->tgl_order;
				$orderid = $cekbayarakhir->order_id;

				if (strtotime($batastanggal) > strtotime($batasbayar)) {
					$databayar = Array();
					$databayar['status'] = 0;
					$this->load->model('M_payment');
					$this->M_payment->update_payment($databayar, $id, $orderid);
					$databayar = $this->ambildatabayarsekolah($npsn);
					$jmlbayar = count($databayar);
					$cekbayarakhir = $this->cekbayarakhir($jmlbayar, $databayar);
				}
			}

			$bulaninisudah = false;
			$bulanbayarakhir = substr($bayarakhir, 5, 2);
			$tahunbayarakhir = substr($bayarakhir, 0, 4);


			if ($tahunsekarang == $tahunbayarakhir && $bulansekarang == $bulanbayarakhir) {
				$bulaninisudah = true;
			}

			$data = array();

			$data['dibayaroleh'] = $dibayaroleh;
			$data['pembayar'] = $pembayar;
			$data['konten'] = "ekskul_bayar_ver";
			$data['bulaninisudah'] = $bulaninisudah;
			$data['databayar'] = $databayar;
			$data['asal'] = $asal;
			$data['statusakhirbayar'] = $statusbayar;
			$this->load->view('layout/wrapper_payment', $data);
		}
	}

	public function daftar_bayar_siswa($idusersiswa)
	{
		if ($this->session->userdata('sebagai') == 1) {
			$npsn = $this->session->userdata('npsn');
			$databayar = $this->ambildatabayar($npsn, $idusersiswa);
			$jmlbayar = count($databayar);
			$cekbayarakhir = $this->cekbayarakhir($jmlbayar, $databayar);
			if ($cekbayarakhir) {
				$statusbayar = $cekbayarakhir->status;
				$bayarakhir = $cekbayarakhir->tgl_bayar;
			} else {
				$statusbayar = 0;
				$bayarakhir = "";
			}

			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$bulansekarang = $datesekarang->format('m');
			$tahunsekarang = $datesekarang->format('Y');
			$batastanggal = $datesekarang;
			$batastanggal = $batastanggal->modify('-1 day');
			$batastanggal = $batastanggal->format("Y-m-d H:i:s");

			if ($statusbayar == 1) {
				$batasbayar = $cekbayarakhir->tgl_order;
				$orderid = $cekbayarakhir->order_id;

				if (strtotime($batastanggal) > strtotime($batasbayar)) {
					$databayar = Array();
					$databayar['status'] = 0;
					$this->load->model('M_payment');
					$this->M_payment->update_payment($databayar, $id, $orderid);
					$databayar = $this->ambildatabayar($npsn, $id);
					$jmlbayar = count($databayar);
					$cekbayarakhir = $this->cekbayarakhir($jmlbayar, $databayar);
				}
			}

			$bulaninisudah = false;
			$bulanbayarakhir = substr($bayarakhir, 5, 2);
			$tahunbayarakhir = substr($bayarakhir, 0, 4);


			if ($tahunsekarang == $tahunbayarakhir && $bulansekarang == $bulanbayarakhir) {
				$bulaninisudah = true;
			}

			$data = array();
			$data['konten'] = "ekskul_bayar";
			$data['bulaninisudah'] = $bulaninisudah;
			$data['databayar'] = $databayar;
			$this->load->view('layout/wrapper_umum', $data);
		}
	}

	public function daftar_video($asal=null)
	{
		$npsn = $this->session->userdata('npsn');
		$id = $this->session->userdata('id_user');
		$dataekskul = $this->ambildata($npsn);

		$status = $this->cekstatus($dataekskul);

		$dibayaroleh = $this->cekbayareskul();
		$jmlpembayar = substr($dibayaroleh, 6);

		// echo "<pre>";
		// echo var_dump($dataekskul);
		// echo "</pre>";
		
		// echo "DIBAYAROLEH:".$dibayaroleh;
		// echo "<br>JMLPEMBAYAR:".$jmlpembayar;
		// echo "STTS:".$status;
		// die();
		$ceksekolahpremium = ceksekolahpremium();
		$status = "non";
		if ($ceksekolahpremium['status_sekolah'] != "non")
			{
				$status = $ceksekolahpremium['status_sekolah'];
				if ($status == "Lite Siswa")
					$status = "Lite";
			}
			
		// echo "STTS:".$status;

		$data = array();
		$data['konten'] = "ekskul_video";
		$data['status'] = $status;
		$data['asal'] = $asal;
		$data['dibayaroleh'] = $dibayaroleh;
		$data['jmlpembayar'] = $jmlpembayar;

		$getstatus = getstatusverifikator();
		$data['status_verifikator'] = $getstatus['status_verifikator'];

//		if ($status == 2||$status == 12) {
		if ($this->session->userdata('sebagai') == 2) {
			$data['dafvideo'] = $this->M_ekskul->getVideoEkskul();
		} else if ($this->session->userdata('sebagai') == 1 && $this->session->userdata('verifikator') == 3) {
			$data['dafvideo'] = $this->M_ekskul->getVideoEkskul($npsn);
		} else
			redirect("/");

//			echo "<pre>";
//			echo var_dump($data['dafvideo']);
//			echo "</pre>";
//			die();

		$this->load->view('layout/wrapper_tabel', $data);

	}

	public function daftar_peserta($opsi=null)
	{
		if ($this->session->userdata('sebagai') == 1 && $this->session->userdata('verifikator') == 3) {
			$npsn = $this->session->userdata('npsn');
			$id = $this->session->userdata('id_user');

			$dibayaroleh = $this->cekbayareskul();
			$dataekskul = $this->ambildata($npsn, $id);
			$status = $this->cekstatus($dataekskul);

//			echo "<pre>";
//			echo var_dump($dataekskul);
//			echo "</pre>";
//			die();

			$data = array();

			$data['statuspeserta'] = $status;
			$data['dibayaroleh'] = $dibayaroleh;
			$data['konten'] = "ekskul_daftar_ver";
			$data['dataekskul'] = $dataekskul;
			$data['opsi'] = $opsi;

			$this->load->view('layout/wrapper_tabel', $data);
		}

	}

	public function daftar_pesertates()
	{
		if ($this->session->userdata('sebagai') == 1 && $this->session->userdata('verifikator') == 3) {
			$npsn = $this->session->userdata('npsn');
			$id = $this->session->userdata('id_user');

			$dibayaroleh = $this->cekbayareskul();
			$dataekskul = $this->ambildata($npsn, $id);
			$status = $this->cekstatus($dataekskul);

//			echo "<pre>";
//			echo var_dump($dataekskul);
//			echo "</pre>";
//			die();

			$data = array();

			$data['statuspeserta'] = $status;
			$data['dibayaroleh'] = $dibayaroleh;
			$data['konten'] = "ekskul_daftar_ver";
			$data['dataekskul'] = $dataekskul;

			$this->load->view('layout/wrapper_tabel', $data);
		}

	}

	private function ambildata($npsn)
	{
		if ($this->session->userdata('sebagai') == 1 && $this->session->userdata('verifikator') == 3) {
			$id = null;
		} else {
			$id = $this->session->userdata('id_user');
		}
		$data = $this->M_ekskul->getEkskul($npsn);

		return $data;
	}

	private function ambildatabayar($npsn, $id = null)
	{
		$this->load->Model('M_payment');
		$data = $this->M_payment->getbayarEkskul($npsn, $id);
		return $data;
	}

	private function ambildatabayarsekolah($npsn)
	{
		$this->load->Model('M_payment');
		$data = $this->M_payment->getbayarEkskulSekolah($npsn);
		return $data;
	}

	private function cekbayarakhir($dataakhir, $dataekskul)
	{
		if ($dataakhir > 0) {
			$tanggalbayarakhir = $dataekskul[$dataakhir - 1];
			return $tanggalbayarakhir;
		} else return "";
	}

	private function cekstatus($dataekskul)
	{
		$id = $this->session->userdata('id_user');
		$status = 0;
		$bayar10 = 0;

		foreach ($dataekskul as $datane) {
			if ($datane->status == 3)
				$bayar10++;
			if ($datane->id_user == $id) {
				$status = 1;
				if ($datane->status == 3)
					$status = 2;
			}
		}
		if ($bayar10 >= 3)
			$status = $status + 10;
		return $status;
	}

	private function cekpesertaaktif($dataekskul)
	{
		$jmlpeserta = 0;

		foreach ($dataekskul as $datane) {
			if ($datane->status == 3)
				$jmlpeserta++;
		}

		return $jmlpeserta;
	}

	private function ceksudahbayar($id, $dataekskul)
	{
		$statusbayar = 0;
		$this->load->model("M_payment");
		$cekbayar = $this->M_ekskul->getEkskul($id, $dataekskul);
		return $cekbayar;
	}

	public function ikuti()
	{
		$id = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$this->M_ekskul->addEkskul($npsn, $id);
		$cekekskul = $this->cekgratisekskul();

		if ($cekekskul['sisa_gratis']>0) {
			$kodeacak = "EKF-" . $id."_".$cekekskul['order_id'];
			$this->load->Model('M_payment');
			$this->M_payment->insertkodeorder($kodeacak, $id, $npsn, 0, $cekekskul['tgl_berakhir']);
			$data = array("status"=>3);
			$this->M_payment->tambahbayar($data,$kodeacak, $id);

			$this->M_ekskul->updateEkskul($npsn, $id, $kodeacak);
		}
		redirect("/ekskul");
	}

	private function cekgratisekskul()
	{
		$arraygratis = array("Lite"=>3, "Pro"=>10, "Premium"=>1000, "Lite Siswa"=>0);
		$ceksekolahpremium = ceksekolahpremium();
		$data['statussekolah'] = " [ - ]";
		$sisagratis = 0;

		if ($ceksekolahpremium['status_sekolah'] != "non")
		{
			$statussekolah = $ceksekolahpremium['status_sekolah'];
			$totalgratis = $arraygratis[$statussekolah];
			$orderid = $ceksekolahpremium['order_id'];
			$tglakhir = $ceksekolahpremium['tgl_berakhir'];
			$totalambilgratis = siswaambilgratisekskul();
			$sisagratis = $totalgratis - $totalambilgratis;
		}

		$hasil = array();
		$hasil['order_id'] = $orderid;
		$hasil['sisa_gratis'] = $sisagratis;
		$hasil['tgl_berakhir'] = $tglakhir;
		return $hasil;

	}

	public function videotambah()
	{
		if ($this->session->userdata('sebagai') == 2) {
			$npsn = $this->session->userdata('npsn');
			$id = $this->session->userdata('id_user');
			$dataekskul = $this->ambildata($npsn, $id);
			$status = $this->cekstatus($dataekskul);
			$dibayaroleh = $this->cekbayareskul();
			if ($status == 2 || $status == 12 || $dibayaroleh == "sekolah") {
				$data = array();
				$data['konten'] = "ekskul_video_tambah";
				$data['addedit'] = "add";
				$this->load->Model("M_video");
				$data['dafkurikulum'] = $this->M_video->getKurikulum();
				$data['dafjenjang'] = $this->M_video->getAllJenjang();
				$data['dafkategori'] = $this->M_video->getAllKategori();
				$data['datavideo'] = Array('status_verifikasi' => 0);
				$data['idvideo'] = 0;
				$data['namafile'] = "";

				$this->load->view('layout/wrapper_umum', $data);
			}
		}
	}

	public function addvideo()
	{

		if ($this->input->post('ijudul') == null) {
			redirect('videotambah');
		}

//		if ($this->session->userdata('bimbel') == 3
//			&& $this->session->userdata('verifikator') == 0
//			&& $this->session->userdata('kontributor') == 0) {
//			$data['sifat'] = 2;
//		}
		$data['channeltitle'] = $this->input->post('ichannel');
		$data['channelid'] = $this->input->post('ichannelid');
		$data['tipe_video'] = 2;
		$data['id_jenis'] = $this->input->post('ijenis');
		$data['id_jenjang'] = $this->input->post('ijenjang');
		$data['id_kelas'] = $this->input->post('ikelas');
		$data['id_mapel'] = $this->input->post('imapel');
		$data['kdnpsn'] = $this->input->post('istandar');
		$data['kdkur'] = $this->input->post('ikurikulum');
		if ($data['id_jenjang'] == 2)
			$data['id_tematik'] = $this->input->post('itema');
		else
			$data['id_tematik'] = 0;
		if ($data['id_jenjang'] == 5 || $data['id_jenjang'] == 6)
			$data['id_jurusan'] = $this->input->post('ijurusan');
		else
			$data['id_jurusan'] = 0;
//        echo $data['id_jurusan'];
//        die();

		$data['id_ki1'] = $this->input->post('iki1');
		$data['id_ki2'] = $this->input->post('iki2');
		$data['id_kd1_1'] = $this->input->post('ikd1_1');
		$data['id_kd1_2'] = $this->input->post('ikd1_2');
		$data['id_kd1_3'] = $this->input->post('ikd1_3');
		$data['id_kd2_1'] = $this->input->post('ikd2_1');
		$data['id_kd2_2'] = $this->input->post('ikd2_2');
		$data['id_kd2_3'] = $this->input->post('ikd2_3');
		$data['id_kategori'] = $this->input->post('ikategori');

		$data['topik'] = $this->stripHTMLtags($this->input->post('itopik'));
		$data['judul'] = $this->stripHTMLtags($this->input->post('ijudul'));
		$data['deskripsi'] = $this->stripHTMLtags($this->input->post('ideskripsi'));
		$data['keyword'] = $this->stripHTMLtags($this->input->post('ikeyword'));
		$data['link_video'] = $this->stripHTMLtags($this->input->post('ilink'));
		$data['durasi'] = $this->input->post('idurjam') . ':' . $this->input->post('idurmenit') . ':' . $this->input->post('idurdetik');

		$statusverifikasi = $this->input->post('status_ver');

		if ($this->input->post('addedit') == "add") {
			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$bulansekarang = $datesekarang->format('m');
			$tahunsekarang = $datesekarang->format('Y');
//			$data['bulanekskul'] = intval($bulansekarang);
//			$data['tahunekskul'] = $tahunsekarang;

			$data['id_user'] = $this->session->userdata('id_user');
			$data['npsn_user'] = $this->session->userdata('npsn');
			if ($data['link_video'] != "") {
				$data['durasi'] = $data['durasi'];
				$data['thumbnail'] = $this->input->post('ytube_thumbnail');
				$data['id_youtube'] = $this->input->post('idyoutube');
			}
			$data['kode_video'] = base_convert(microtime(false), 10, 36);
		} else {
			//$data['kode_video'] = base_convert($this->input->post('created'),10,16);
		}

		if ($statusverifikasi == 1) {
			$data['status_verifikasi'] = 0;
		} else if ($statusverifikasi == 3) {
			$data['status_verifikasi'] = 2;
		}

		$data['status_verifikasi'] = 0;

		if ($data['id_jenis'] == 1) {
			$data['id_kategori'] = 0;
		} else {
			$data['id_jenjang'] = 0;
			$data['id_kelas'] = 0;
			$data['id_mapel'] = 0;
			$data['id_ki1'] = 0;
			$data['id_ki2'] = 0;
			$data['id_kd1_1'] = 0;
			$data['id_kd1_2'] = 0;
			$data['id_kd1_3'] = 0;
			$data['id_kd2_1'] = 0;
			$data['id_kd2_2'] = 0;
			$data['id_kd2_3'] = 0;
		}

		if ($this->input->post('addedit') == "add") {
			$idbaru = $this->M_ekskul->addVideo($data);
			redirect('ekskul/daftar_video');
			//redirect('video/edit/'.$idbaru);
		} else {
			$this->M_ekskul->editVideo($data, $this->input->post('id_video'));
			redirect('ekskul/daftar_video');
		}

	}

	public function editvideo($id_video = null)
	{
		if ($id_video == null) {
			redirect("/");
		}

		$data = array();
		$data['konten'] = "ekskul_video_tambah";

		$data['linkdari'] = "video";
		$data['addedit'] = "edit";
		$this->load->Model("M_video");
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['datavideo'] = $this->M_ekskul->getVideoEkskulpilih($id_video);

//		echo "<pre>";
//		echo var_dump($data['datavideo']);
//		echo "</pre>";
//
//		die();

		if ($data['datavideo']) {
			$data['dafkelas'] = $this->M_video->dafKelas($data['datavideo']['id_jenjang']);

			$data['dafmapel'] = $this->M_video->dafMapel($data['datavideo']['id_jenjang'], $data['datavideo']['id_jurusan']);

			$data['dafjurusan'] = $this->M_video->dafJurusan();
			$data['dafjurusanpt'] = $this->M_video->dafJurusanPT();

			$data['idvideo'] = $id_video;

			$data['jenisvideo'] = "mp4";
			if ($data['datavideo']['link_video'] != "") {
				//$idyoutube=substr($data['datavideo']['link_video'],32,11);
				//$data['infodurasi'] = $this->getVideoInfo($idyoutube);
				$data['jenisvideo'] = "yt";
			}

			$data['dafkd1'] = $this->M_video->dafKD($data['datavideo']['kdnpsn'], $data['datavideo']['kdkur'], $data['datavideo']['id_kelas'], $data['datavideo']['id_mapel'], $data['datavideo']['id_ki1']);
			$data['dafkd2'] = $this->M_video->dafKD($data['datavideo']['kdnpsn'], $data['datavideo']['kdkur'], $data['datavideo']['id_kelas'], $data['datavideo']['id_mapel'], $data['datavideo']['id_ki2']);
			$this->load->view('layout/wrapper_umum', $data);
		} else {
			redirect("/");
		}
	}

	public function hapusvideo($id_video)
	{
		$this->M_ekskul->delsafevideo($id_video);
		redirect('/ekskul/daftar_video', '_self');
	}

	private function stripHTMLtags($str)
	{
		$t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
		$t = htmlentities($t, ENT_QUOTES, "UTF-8");
		return $t;
	}

	public function daftar_playlist($linklist = null)
	{

		$namabulan = array("", "Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$bulansekarang = $datesekarang->format('m');
		$tahunsekarang = $datesekarang->format('Y');
		$bulantahun = $namabulan[intval($bulansekarang)] . " " . $tahunsekarang;

		$data = array();
		$data['konten'] = "ekskul_daftar_playlist";

		$id_user = $this->session->userdata('id_user');
		$data['linklist'] = $linklist;
		$data['dafpaket'] = $this->M_ekskul->getPaketEkskul($id_user);

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function tambahplaylist($linklist_event = null)
	{
		$data = array();
		$data['konten'] = "ekskul_tambahplaylist";

		$data['addedit'] = "add";
		$this->load->Model('M_video');
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['message'] = $this->session->flashdata('message');

		$data['linklist_event'] = $linklist_event;

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function addplaylist()
	{
		$data = array();
		$data['nama_paket'] = $_POST['ipaket'];
		$data['id_jenjang'] = $_POST['ijenjang'];
		if ($data['id_jenjang'] == 5 || $data['id_jenjang'] == 6)
			$data['id_jurusan'] = $_POST['ijurusan'];
		else
			$data['id_jurusan'] = 0;
		$data['id_kelas'] = $_POST['ikelas'];
		$data['id_mapel'] = $_POST['imapel'];

		$tgtyg = $_POST['datetime'];
		if ($tgtyg != "")
			$data['tanggal_tayang'] = $tgtyg;
		$linklist_event = $_POST['linklist_event'];
		$this->load->model('M_channel');

		if ($_POST['addedit'] == "add") {
			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$bulansekarang = $datesekarang->format('m');
			$tahunsekarang = $datesekarang->format('Y');
			$data['bulanekskul'] = intval($bulansekarang);
			$data['tahunekskul'] = $tahunsekarang;
			$mikro = str_replace(".", "", microtime(false));
			$mikro = str_replace(" ", "", $mikro);
			$mikro = base_convert($mikro, 10, 36);
			$data['link_list'] = $mikro;
			$data['durasi_paket'] = '00:00:00';
			$data['status_paket'] = '0';
			$data['id_user'] = $this->session->userdata('id_user');
			$data['npsn_user'] = $this->session->userdata('npsn');
			$this->M_ekskul->addplaylist($data);
		} else {
			$link_list = $_POST['linklist'];
			$this->M_ekskul->updatePlaylist($link_list, $data);
		}

		redirect('ekskul/daftar_playlist');

	}

	public function inputplaylist($kodepaket = null, $kodeevent = null)
	{
		$data = array();
		$data['konten'] = "ekskul_inputplaylist";
		$this->load->model('M_ekskul');
		$id_user = $this->session->userdata('id_user');
		$data['dafvideo'] = $this->M_ekskul->getVideoUser($id_user, $kodepaket);

//		echo "<br><br><br><br><br><br><br><br><pre>";
//		echo var_dump($data['dafvideo']);
//		echo "</pre>";

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$data['message'] = $this->session->flashdata('message');

		$this->load->view('layout/wrapper_umum', $data);

	}

	public function playlist($kodeusr = null, $linklist = null)
	{
		$namabulan = array("", "Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$bulansekarang = $datesekarang->format('m');
		$tahunsekarang = $datesekarang->format('Y');
		$bulantahun = $namabulan[intval($bulansekarang)] . " " . $tahunsekarang;

		$data = array();

		if ($linklist == null) {
			$data['konten'] = 'ekskul_playlist';

		} else {
			$data['konten'] = 'ekskul_playlist_pilih';
			$paketsoal = $this->M_channel->getPaket($linklist);
			$data['statussoal'] = $paketsoal[0]->statussoal;
			$data['pengunggah'] = $paketsoal[0]->first_name . " " . $paketsoal[0]->last_name;

//			if ($this->session->userdata("loggedIn")) {
//				//$iduser = $this->session->userdata("id_user");
//				if ($paketsoal[0]->npsn_user == $this->session->userdata('npsn')) {
//					$jenis = 1;
//				} else
//					$jenis = 2;
//				$nilaiuser = $this->M_channel->ceknilai($linklist, $iduser);
//				$cekbeli = $this->M_channel->getlast_kdbeli($iduser, $jenis);
//
//			} else {
//				$data['masuk'] = 0;
//				$kodebeli = "-";
//				$jenis = 0;
//			}


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


		if ($npsn == "")
			$npsn = "000";

		//echo "KODEBELI:".$iduser;

		$data['dafplaylist'] = $this->M_ekskul->getDafPlayListEkskul($kd_user);

		// echo "<pre>";
		// echo var_dump ($data['dafplaylist']);
		// echo "</pre>";
		// die();

		if ($data['dafplaylist']) {
			$data['punyalist'] = true;
			$statusakhir = $data['dafplaylist'][0]->link_list;
			if ($linklist == null) {
				$data['playlist'] = $this->M_ekskul->getPlayListSayaEkskul($kd_user, $statusakhir);
			} else {
				$data['playlist'] = $this->M_ekskul->getPlayListSayaEkskul($kd_user, $linklist);

			}


		} else {
//            $data['playlist'] = $this->M_channel->getPlayListGuru($kd_user);
			$data['punyalist'] = false;
//			if (!$this->session->userdata('loggedIn')) {
//				redirect('/');
//			}
		}

		if ($kd_user == null) {
			$kd_user = $this->session->userdata('id_user');
		}

		$this->load->Model('M_channel');
		$data['infoguru'] = $this->M_channel->getInfoGuru($kd_user);
		$data['dafvideo'] = $this->M_channel->getVodGuru($kd_user);
		$data['message'] = $this->session->flashdata('message');

		$data['kd_user'] = $kd_user;
		$data['id_playlist'] = $linklist;

		$data['title'] = 'PLAYLIST SAYA <br> [' .
//			$data['infoguru'][0]->first_name . ' ' . $data['infoguru'][0]->last_name .
			" " . $bulantahun . ']';

		$this->session->set_userdata('asalpaket', 'channel');

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function masukinlist()
	{
		$id_video = $_POST['id'];
		$status_video = $_POST['status'];
		$linklist_paket = $_POST['kodepaket'];

		$infopaket = $this->M_ekskul->getInfoPaketEkskul($linklist_paket);

		//$datachannelvideo = $this->M_channel->getDataChannelVideo($infopaket->id);
		//$urutanakhir = $datachannelvideo[0]->urutan;

		$data1 = array();
		$data1['npsn'] = $this->session->userdata('npsn');
		$data1['id_paket'] = $infopaket->id;
		$data1['urutan'] = 0;
		$data1['id_video'] = $id_video;

		if ($status_video == 1) {
			$this->M_ekskul->addDataChannelVideoEkskul($data1);
			$this->M_ekskul->updatedilistekskul($id_video, 1);
		} else {
			$this->M_ekskul->delDataChannelVideoEkskul($id_video, $infopaket->id);
			$this->M_ekskul->updatedilistekskul($id_video, 0);
		}

		$datachannelvideo = $this->M_ekskul->getDataChannelVideoEkskul($infopaket->id);

		$durasi = 0;
		foreach ($datachannelvideo as $datane) {
			$hitungdurasi = $this->durasikedetik($datane->durasi);
			$durasi = $durasi + $hitungdurasi;
		}

		$data2['durasi_paket'] = $this->detikkedurasi($durasi);
		if ($durasi == 0)
			$data2['status_paket'] = 0;
		else {
			if (new DateTime(date('Y-m-d H:i:s')) < new DateTime($infopaket->tanggal_tayang)) {
				$data2['status_paket'] = 1;
			} else {
				$data2['status_paket'] = 2;
			}
		}

		$this->M_ekskul->updateDurasiPaketEkskul($linklist_paket, $data2);

		//$infovideo = $this->M_channel->getInfoVideo($id_video);
		return "OK";

		//$this->M_channel->gantistatuspaket($id_paket);
	}

	public function detikkedurasi($detik)
	{

		$detikjam = (int)($detik / 3600);
		$sisajam = $detik - ($detikjam * 3600);
		$detikmenit = (int)($sisajam / 60);
		$detikdetik = $sisajam - ($detikmenit * 60);

		if ($detikjam < 10)
			$detikjam = "0" . $detikjam;
		if ($detikmenit < 10)
			$detikmenit = "0" . $detikmenit;
		if ($detikdetik < 10)
			$detikdetik = "0" . $detikdetik;

		return $detikjam . ":" . $detikmenit . ":" . $detikdetik;
	}

	public function durasikedetik($durasi)
	{
		$detikjam = (int)substr($durasi, 0, 2) * 3600;
		$detikmenit = (int)substr($durasi, 3, 2) * 60;
		$detikdetik = (int)substr($durasi, 6, 2);

		return $detikjam + $detikmenit + $detikdetik;
	}

	public function editplaylist($kodepaket = null, $linklist = null)
	{
		$data = array();
		$data['konten'] = "ekskul_tambahplaylist";

		$data['addedit'] = "edit";
		$data['datapaket'] = $this->M_ekskul->getInfoPaketEkskul($kodepaket);
		$data['kodepaket'] = $kodepaket;
		$data['linklist_event'] = $linklist;

		$idjenjang = $data['datapaket']->id_jenjang;
		$this->load->model('M_bimbel');
		$data['dafjenjang'] = $this->M_bimbel->getJenjangAll();
		$data['dafkelas'] = $this->M_bimbel->getKelasJenjang($idjenjang);
		$data['dafmapel'] = $this->M_bimbel->getMapelJenjang($idjenjang);
		$this->load->model('M_video');
		$data['dafjurusan'] = $this->M_video->dafJurusan();
		$data['dafjurusanpt'] = $this->M_video->dafJurusanPT();

		$data['message'] = $this->session->flashdata('message');

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function lihatplaylist($linklist = null, $linklistevent = null)
	{
		$data = array();
		$data['konten'] = "ekskul_lihat";

		$iduser = $this->session->userdata('id_user');

		$infopaket = $this->M_ekskul->getInfoPaketEkskul($linklist);
		$data['namapaket'] = $infopaket->nama_paket;

		$data['dafplaylist'] = $this->M_ekskul->getDafPlayListEkskul($iduser);

		if ($data['dafplaylist']) {
			$data['punyalist'] = true;
			$data['playlist'] = $this->M_ekskul->getPlayListSayaEkskul($linklist);
		} else {
			$data['punyalist'] = false;
		}

		$data['linklist'] = $linklist;

		$data['npsn'] = $this->session->userdata('npsn');
		$data['asal'] = "menu";
		$data['message'] = $this->session->flashdata('message');

		$data['iduser'] = $iduser;
		$data['idku'] = $iduser;
		$data['id_playlist'] = $linklist;

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function urutanplaylist($kodepaket = null)
	{
		$data = array();
		$data['konten'] = "ekskul_urutanplaylist";
		$id_user = $this->session->userdata('id_user');
		$data['dafvideo'] = $this->M_ekskul->getVideoUserPaketEkskul($id_user, $kodepaket);

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$data['message'] = $this->session->flashdata('message');


		$this->load->view('layout/wrapper_umum', $data);

	}

	public function updateurutan()
	{

		$data = array();
		$data['id'] = $this->input->post('id');
		$data['urutan'] = $this->input->post('urutan');
		//    $this->db->update_batch('tb_channel_video_sekolah', $data, 'id');
		$this->M_ekskul->updateurutan($data);
	}

	public function verifikasi($id_video)
	{
		$getstatus = getstatusverifikator();

		if ($getstatus['status_verifikator']=="oke" &&
			($this->session->userdata('a01') || $this->session->userdata('verifikator') == 3)) {

			$data = array();

			$data['konten'] = "ekskul_verifikasi";

			$this->load->Model("M_video");
			$data['datavideo'] = $this->M_video->getVideoKomplit($id_video);

			if ($this->session->userdata('npsn') != $data['datavideo']['npsn'])
				redirect('ekskul/daftar_video');

			$datav['id_video'] = $id_video;
			$datav['id_verifikator'] = $this->session->userdata('id_user');
			if ($this->session->userdata('a01')) {
				$datav['no_verifikator'] = 2;
				$data['no_verifikator'] = 2;
			} else {
				$datav['no_verifikator'] = 1;
				$data['no_verifikator'] = 1;
			}

			$data['dafpernyataan'] = $this->M_video->getAllPernyataan($datav['no_verifikator']);
			$data['dafpenilaian'] = $this->M_video->getPenilaian($id_video, $datav);

			$this->load->view('layout/wrapper_umum', $data);
		}
		else
		{
			redirect("/ekskul/daftar_video/dashboard");
		}
	}

	public function simpanverifikasi()
	{
		$verifikator = 1;
		if ($this->session->userdata('a01'))
			$verifikator = 2;
		$id_video = $this->input->post('id_video');
		$total_isian = $this->input->post('total_isian');
		$jml_diisi = $this->input->post('jml_diisi');
		$lulusgak = $this->input->post('lulusgak');
//		 echo 'Total:'.$total_isian;
//		 echo '<br>Diisi:'.$jml_diisi;
//		echo $lulusgak;
//		die();
		/////////////// GANTI LULUS DENGAN INPUTAN LULUSGAK, BUKAN LENGKAP ATAU TIDAKNYA///////////////////////////////////////////////////
		if ($verifikator == 1)
			$status_verifikasi = 0 + $lulusgak;
		else
			$status_verifikasi = 2 + $lulusgak;

		//echo "Total isian:".$total_isian.'-'.'Diisi:'.$jml_diisi;	die();

		if ($verifikator >= 1) {
			if ($verifikator == 1) {
				$data1['totalnilai1'] = $this->input->post('totalnilai');
				$data1['catatan1'] = $this->input->post('icatatan');
			} else {
				$data1['totalnilai2'] = $this->input->post('totalnilai');
				$data1['catatan2'] = $this->input->post('icatatan');
			}
			if ($this->session->userdata('a01')) {
				$data1['status_verifikasi_admin'] = $status_verifikasi;
				$data1['status_verifikasi'] = $status_verifikasi;
			} else
				$data1['status_verifikasi'] = $status_verifikasi;

			$data2['id_video'] = $id_video;
			$data2['totalnilai'] = $this->input->post('totalnilai');
			$data2['no_verifikator'] = $verifikator;
			$data2['id_verifikator'] = $this->session->userdata('id_user');
			$data2['status_verifikasi'] = $status_verifikasi;

			////////// MENUNGGU SYARAT STATUS VERIFIKASI YG BENAR

			if ($id_video == null) {
				//echo "cek_3";	die();
				redirect('ekskul/daftar_video/');
			} else {
				//echo "cek_4";	die();
				$data3['id_video'] = $id_video;
				$data3['id_verifikator'] = $this->session->userdata('id_user');
				$data3['no_verifikator'] = $verifikator;

				for ($c = 1; $c <= $total_isian; $c++) {
					$data3['penilaian' . $c] = $this->input->post('inilai' . $c);
					//echo $data3['penilaian'.$c];
				}

				$this->load->Model("M_video");
				$this->M_video->updatenilai($data1, $id_video);
				$this->M_video->addlogvideo($data2);
				$this->M_video->simpanverifikasi($data3, $id_video);
				redirect('ekskul/daftar_video');
			}
		} else {
//			echo "cek5";
//			die();
			redirect('ekskul/daftar_video');
		}
	}

	public function gantipembayar()
	{
		if ($this->session->userdata('sebagai') == 1 && $this->session->userdata('verifikator') == 3) {
			$idpembayar = $addedit = $this->input->post('idpembayar');
			if ($this->M_ekskul->updatepembayar($idpembayar))
				return true;
			else
				return false;
		}

	}

	public function sertifikat_download()
	{
		if ($this->session->userdata('loggedIn')) {
			$iduser = $this->session->userdata('id_user');
			$cektugas = $this->cektugassiswa();
			if ($cektugas=="lulus" || $this->session->userdata('id_user')==115){
				$filecari = "uploads/sertifikat/sert_ekskul_" . $iduser . ".pdf";
				if (!file_exists($filecari)) {
					$this->sertifikatekskul($iduser);
				}
				force_download($filecari, NULL);
			}
			else
			{

			}

		}
	}

	private function cektugassiswa()
	{
		$iduser = $this->session->userdata('id_user');
		$tugasvideo = $this->M_ekskul->getTugasVideoBulanan($iduser);
		$jumlahbulanvideo = count($tugasvideo);

		$jumlahvideotugas = 0;
		foreach ($tugasvideo as $datatugas)
		{
			$jumlahvideotugas = $jumlahvideotugas + $datatugas->totalvideo;
		}

		$videoplaylist = $this->M_ekskul->getVideoPlaylistHarian($iduser);
		$jumlahvideoplaylist = count($videoplaylist);

		if ($jumlahbulanvideo>=6 && $jumlahvideotugas>=24 && $jumlahvideoplaylist>=6)
			return "lulus";
		else
			return "gagal";
	}

	private function sertifikatekskul()
	{
		$idpeserta = $this->session->userdata('id_user');
		$getdatasiswaekskul = $this->M_ekskul->getSiswaEkskul($idpeserta);
		if ($getdatasiswaekskul) {
			$nomor = "Nomor:".$getdatasiswaekskul->id."/e-cert/ekskul/tvs/".date("Y");
			$nama = $getdatasiswaekskul->first_name. " ". $getdatasiswaekskul->last_name;
			$kegiatan = "Bahwa yang bersangkutan telah aktif mengikuti kegiatan Ekstrakurikuler ".
				"TV Kampus untuk periode tahun ".date("Y");
			$tanggal = "Jakarta, ".nmbulan_panjang(date("n"))." ".date("Y");
			$this->buildsertifikat($nomor,$idpeserta,$nama,$kegiatan,$tanggal);
		} else {
			echo "BUKAN HAK ANDA";
		}

	}

	private function buatqrcode($indeks, $kode = null)
	{
		$imgname = "qr.png";
		$logo[2] = "logof.png";
		$logo[1] = "logotv.png";
		$data[1] = isset($_GET['data']) ? $_GET['data'] : "https://beta.tvsekolah.id/informasi/ceksertifikat/" . $kode;
		$data[2] = isset($_GET['data']) ? $_GET['data'] : "https://beta.tvsekolah.id";
		$logo = isset($_GET['logo']) ? $_GET['logo'] : base_url() . 'assets/images/' . $logo[$indeks];
		$sdir = explode("/", $_SERVER['REQUEST_URI']);
		$dir = str_replace($sdir[count($sdir) - 1], "", $_SERVER['REQUEST_URI']);

		require_once(APPPATH . 'libraries/phpqrcode/qrlib.php');
		QRcode::png($data[$indeks], $imgname, QR_ECLEVEL_L, 11.45, 0);

		$QR = imagecreatefrompng($imgname);
		if ($logo !== FALSE) {
			$logopng = imagecreatefrompng($logo);
			$QR_width = imagesx($QR);
			$QR_height = imagesy($QR);
			$logo_width = imagesx($logopng);
			$logo_height = imagesy($logopng);

			list($newwidth, $newheight) = getimagesize($logo);
			$out = imagecreatetruecolor($QR_width, $QR_width);
			imagecopyresampled($out, $QR, 0, 0, 0, 0, $QR_width, $QR_height, $QR_width, $QR_height);
			imagecopyresampled($out, $logopng, $QR_width / 2.65, $QR_height / 2.65, 0, 0, $QR_width / 4, $QR_height / 4, $newwidth, $newheight);

		}
		imagepng($out, $imgname);
		imagedestroy($out);

		$im = imagecreatefrompng($imgname);
		$r = 44;
		$g = 62;
		$b = 80;
		for ($x = 0; $x < imagesx($im); ++$x) {
			for ($y = 0; $y < imagesy($im); ++$y) {
				$index = imagecolorat($im, $x, $y);
				$c = imagecolorsforindex($im, $index);
				if (($c['red'] < 100) && ($c['green'] < 100) && ($c['blue'] < 100)) { // dark colors
					// here we use the new color, but the original alpha channel
					$colorB = imagecolorallocatealpha($im, 0x12, 0x2E, 0x31, $c['alpha']);
					imagesetpixel($im, $x, $y, $colorB);
				}
			}
		}
		imagepng($im, $imgname);
		imagedestroy($im);

		$type = pathinfo($imgname, PATHINFO_EXTENSION);
		$datahasil = file_get_contents($imgname);
		$imgbase64 = 'data:image/' . $type . ';base64,' . base64_encode($datahasil);

		$path = tempnam(sys_get_temp_dir(), 'prefix');
		file_put_contents($path, $datahasil);
		//echo "<img src='$imgbase64' style='position:relative;display:block;width:240px;height:240px;margin:160px auto;'>";
		return $path;
	}

	private function buildsertifikat($nomor, $id_peserta, $nama_peserta, $kegiatan, $tanggal)
	{
		$qrcode1 = $this->buatqrcode(1, $id_peserta);
		//$qrcode2 = $this->buatqrcode(1, $id_peserta);
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('Sertifikat Ekstrakurikuler');
		$pdf->SetTopMargin(20);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(false);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->AddPage('L', 'A4');
		$img_file = base_url() . "uploads/temp_sertifikat/sert_ekskul_1.jpg";
		$pdf->Image($img_file, 0, 0, 297, 167, '', '', '', false, 150, '', false, false, 0);
		$pdf->Image($qrcode1, 10, 10, 20, 20, '', '', '', false, 150, '', false, false, 0);
		//$pdf->Image($qrcode2, 267, 10, 20, 20, '', '', '', false, 150, '', false, false, 0);
		$pdf->AddFont('frenchscriptmt');

//$pdf->SetFont($fontname, '', 20, '', '');
// pakai alamat ini untuk tambah font TTF, lalu masukkan ke folder tcpdf/fonts
// https://www.xml-convert.com/en/convert-tff-font-to-afm-pfa-fpdf-tcpdf

		$pdf->SetXY(0, 50);
		$html = '<span style="font-family:Helvetica;font-weight:bold;font-size: 14px;color:#000000;">' . $nomor . '</span>';
		$pdf->SetMargins(0, 0, 0, true);
		$pdf->writeHTML($html, true, 0, true, true, 'C');

		$pdf->SetXY(0, 60);
		$html = '<span style="font-family:Helvetica;font-weight:bold;font-size: 18px;color:#000000;">diberikan kepada</span><br>'.
		'<span style="font-family:Helvetica;font-weight:bold;font-size: 24px;color:#000000;">&nbsp;' . $nama_peserta . '&nbsp;</span>';
		$pdf->SetMargins(0, 0, 0, true);
		$pdf->writeHTML($html, true, 0, true, true, 'C');

		$pdf->SetXY(0, 90);
		$html = '<span style="font-family:Helvetica;font-weight:normal;font-size: 18px;color:#000000;">&nbsp;' . $kegiatan . '&nbsp;</span>';
		$pdf->SetMargins(20, 0, 20, true);
		$pdf->writeHTML($html, true, 0, true, true, 'C');

		$pdf->SetXY(96, 110);
		$html = '<span style="font-family:Helvetica;font-weight:bold;font-size: 14px;color:#000000;">&nbsp;' . $tanggal . '&nbsp;</span>';
		$pdf->SetMargins(0, 0, 0, true);
		$pdf->writeHTML($html, true, 0, true, true, 'C');

		if ($file_sertifikat_hal2 != "") {
			$pdf->AddPage('L', 'A4');
			$img_file = base_url() . "uploads/temp_sertifikat/" . $file_sertifikat_hal2;
			$pdf->Image($img_file, 0, 0, 297, 167, '', '', '', false, 150, '', false, false, 0);
		}

		if ($lihat) {
			ob_end_clean();
			$pdf->Output('sert_ekskul.pdf', "I");
		} else {
			if (base_url() == "http://localhost/fordorum/") {
				$pdf->Output(FCPATH . 'uploads\sertifikat\sert_ekskul_' . $id_peserta . '.pdf', 'F');
			} else {
				$pdf->Output(FCPATH . 'uploads/sertifikat/sert_ekskul_' . $id_peserta . '.pdf', 'F');
			}
		}

	}

}
