<?php

class Eksekusi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_induk');
		$this->load->model('M_eksekusi');
		$this->load->helper(array('Form', 'Cookie', 'String', 'captcha', 'download','statusverifikator','tanggalan'));
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->library('pagination');

		if (!$this->session->userdata('a02')) {
			redirect('/');
		}
	}

	public function index()
	{
		$data = array();
		$data['konten'] = 'v_eksekusi';

		$iduser = $this->session->userdata("id_user");
		$statusdonasi = 0;

		$data['standar'] = $this->M_eksekusi->getStandar();
		$data ['batasakhir'] = "2000-01-01 00:00:00";
		$cekdata = $this->M_eksekusi->getlasteksekusi($iduser, 0);
		
		if ($cekdata)
		{
			$data ['dafeksekusi'] = $cekdata;
			$kodeeks = $cekdata->kode_eks;
			$data ['dafgrupsekolah'] = $this->M_eksekusi->getdafgrupsekolah($kodeeks);
			
		}
		else {

			$cekdata = $this->M_eksekusi->getlasteksekusi($iduser, 1);
			if ($cekdata)
			{
				$data ['dafeksekusi'] = $cekdata;
				$data ['dafgrupsekolah'] = $this->M_eksekusi->getdafgrupsekolah($cekdata->kode_eks);
				$orderidterakhir = $cekdata->order_id;
				$kodeeks = $cekdata->kode_eks;
				$this->load->model("M_payment");
				$payment = $this->M_payment->cekstatusdonasi($orderidterakhir);
				$batasakhir = jamnamabulan_panjang($payment->tgl_berakhir);
				
				$data ['batasakhir'] = $batasakhir;
			}
			else
				$orderidterakhir = "orderidgakada";

			$npsn = $this->session->userdata('npsn');
			$getuser = getstatususer();
			$prodi = $getuser['kelasku'];
			$this->load->model('M_payment');

			// echo "NPSN:$npsn, KODEPRODI:$prodi<br>";
			$bayarankampus = $this->M_payment->getlastpaymentsekolah($npsn, $prodi);
			// echo var_dump($bayarankampus);
			// die();
			if ($bayarankampus)
			{	
				$batasakhir = $bayarankampus->tgl_berakhir;
				if (time() - strtotime($batasakhir)>0)
				{
					// echo "Silakan melakukan pembayaran tagihan kampus terlebih dahulu, untuk dapat menjalankan program Promosi Sekolah.";
					// die();
					redirect(base_url().'informasi/promobayardulu');
				}
				else
				{
					$orderid = $bayarankampus->order_id;
					if ($orderid==$orderidterakhir)
					{
						// echo "Sudah terlaksana";
						$statusdonasi = 1;
					}
					else
					{
						if (substr($orderid,0,2)=="TP")
						{
							$jmlsekolah = 10;
						}
						else if (substr($orderid,0,2)=="TF")
						{
							$jmlsekolah = 20;
						}
						$adddata = $this->M_eksekusi->addeksekusi($iduser, $orderid, $jmlsekolah);
						$data ['dafeksekusi'] = $adddata;
						$kodeeks = $adddata->kode_eks;
						$data ['dafgrupsekolah'] = $this->M_eksekusi->getdafgrupsekolah($kodeeks);
					}
				}

			}
			else
			{
				redirect(base_url().'informasi/promobayardulu');
			}

			
		}

		$data ['statusdonasi'] = $statusdonasi;

		// $data ['datadonatur'] = $this->M_eksekusi->getDonatur($cekdata->id_donatur);
		

		$sekolahdonasi = $this->M_eksekusi->getsekolahdonasi($kodeeks);
		$data ['dafsekolahdonasi'] = $sekolahdonasi;

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function dieksekusi($kodeeks)
	{
		$data = array("status_donasi" => 1);
		$iduser = $this->session->userdata("id_user");

		$this->load->model("M_eksekusi");
		$update = $this->M_eksekusi->updateeksekusi($data, $kodeeks, $iduser);
		if ($update)
		{
			//update data sponsor di database tvsekolah
			$this->sinkrondatasponsor($kodeeks);
		}
		else
		echo "gagal";
	}

	public function sinkrondatasponsor($kodeeks)
	{
		$getuser = getstatususer();
		$prodi = $getuser['namaprodi'];
		$kampus = $getuser['namakampus'];
		if ($prodi=="KAMPUS")
		$tprodi = $prodi;
		else
		$tprodi = "Prodi. ".$prodi;
		$namasponsor = $tprodi." - ".$kampus;

		$this->load->model("M_eksekusi");
		$daftarsekolahsponsor = $this->M_eksekusi->getsekolahdonasi($kodeeks);
		// echo "<pre>";
		// echo var_dump($daftarsekolahsponsor);
		// echo "</pre>";
		$data = array();
		$baris=1;
		foreach ($daftarsekolahsponsor as $row) {
			$data[$baris]['npsn'] = $row->npsn;
			$data[$baris]['nama_sponsor'] = $namasponsor;
			$data[$baris]['url_sponsor'] = $row->url_video;
			$data[$baris]['durasi_sponsor'] = $row->durasi_video;
			$data[$baris]['batas_sponsor'] = $row->batasdonasi;
			$baris++;
		}
		$update = $this->M_eksekusi->updatesponsortvsekolah($data);
		if ($update)
		echo "sukses";
		else
		echo "gagal";
	}

	public function kode($kodeeks)
	{
		$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
			'isi' => 'v_eksekusi');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$iduser = $this->session->userdata("id_user");

		$data['standar'] = $this->M_eksekusi->getStandar();

		$cekdata = $this->M_eksekusi->getlasteksekusi($iduser, null, $kodeeks);

		$data ['dafeksekusi'] = $cekdata;

		$data ['dafgrupsekolah'] = $this->M_eksekusi->getdafgrupsekolah($cekdata->kode_eks);

		$this->load->view('layout/wrapper2', $data);
	}

	public function update_eksekusi($kodeeks)
	{
		$iduser = $this->session->userdata("id_user");

		$jenisdonasi = $this->input->post('jenisdonasi');
		$url_sponsor = $this->input->post('url_sponsor');
		$thumb_sponsor = $this->input->post('thumb_sponsor');
		$durasi = $this->input->post('durasi');
		$totalpilihan = $this->input->post('totalpilihan');
		$totalsekolah = $this->input->post('totalsekolah');
		$jangkapilihan = $this->input->post('jangkapilihan');
		$iddonatur = $this->input->post('iddonatur');


		$data['jenis_donasi'] = $jenisdonasi;
		$data['bulan_donasi'] = $jangkapilihan;
		if ($jenisdonasi == 1) {
			$data['url_sponsor'] = "";
			$data['thumb_sponsor'] = "";
			$data['durasi_sponsor'] = "";
		} else {
			$data['url_sponsor'] = $url_sponsor;
			$data['thumb_sponsor'] = $thumb_sponsor;
			$data['durasi_sponsor'] = $durasi;
		}

		$perkalian = 1;
		if ($jenisdonasi == 1)
			$perkalian = 1;
		else if ($jenisdonasi == 2)
			$perkalian = 6;

		{
			if ($totalpilihan == 1)
				$totalsekolah = 10;
			else if ($totalpilihan == 2)
				$totalsekolah = 25;
			else if ($totalpilihan == 3)
				$totalsekolah = 50;
			else if ($totalpilihan == 4)
				$totalsekolah = 100;
			else if ($totalpilihan == 5)
				$totalsekolah = 1;
			else if ($totalpilihan == 6)
				$totalsekolah = 2;
			else if ($totalpilihan == 7)
				$totalsekolah = 5;
			else if ($totalpilihan == 8)
				$totalsekolah = 10;
		}
		$data['total_sekolah'] = $totalsekolah;

		$standar = $this->M_eksekusi->getStandar();
		if ($totalpilihan >= 1 && $totalpilihan <= 4 || $totalsekolah >= 10) {
			$data['reg_prem'] = 1;
			$data['total_donasi'] = $standar->iuran * $totalsekolah * $perkalian * $jangkapilihan;
		} else {
			$data['reg_prem'] = 2;
			$data['total_donasi'] = $standar->iuran * $totalsekolah * 10 * $jangkapilihan;
		}

		$data2 = array();
		$data2['default_url_sponsor'] = $url_sponsor;
		$data2['default_thumb_sponsor'] = $thumb_sponsor;
		$data2['default_durasi_sponsor'] = $durasi;

		if ($iddonatur>0)
		$this->M_eksekusi->updatedonatur($data2, $iddonatur);


		if ($this->M_eksekusi->updateeksekusi($data, $kodeeks, $iduser))
			echo "sukses";
		else
			echo "gagal";
	}

	public function pilihsekolah($kode_eks, $berdasarkan = null, $hal = null, $propinsi = null, $kab = null, $jenjang = null, $tampil = null)
	{
		$data = array();
		$data['konten'] = 'v_eksekusi_sekolah';

		$this->load->model("M_vod2");
		$data['dafjenjang'] = $this->M_vod2->getJenjangAll();

		$this->load->model("M_channel2");
		if ($berdasarkan == null && $hal == null && $propinsi == null && $kab == null && $jenjang == null)
			$data['dafchannel'] = $this->M_channel2->retrieveStatistikAE($berdasarkan, $hal, $propinsi, $kab, $jenjang, $tampil);
		else
			$data['dafchannel'] = $this->M_channel2->getStatistikAE($berdasarkan, $hal, $propinsi, $kab, $jenjang,$tampil);

		// echo var_dump($data['dafchannel']);
		// die();

		$data['kode_eks'] = $kode_eks;
		$data['dafpropinsi'] = $this->M_channel2->getPropinsiAll();
		$data['dafkota'] = $this->M_channel2->getKota($propinsi);
		$data['berdasarkan'] = $berdasarkan;
		$data['hal'] = $hal;
		$data['prop'] = $propinsi;
		$data['kab'] = $kab;
		$data['jenjang'] = $jenjang;
		$data['tampil'] = $tampil;

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function setpilihsekolah($kode_eks, $berdasarkan, $hal, $propinsi, $kab, $jenjang, $tampil)
	{
		$this->load->model("M_channel2");
		$ambildata = $this->M_channel2->getStatistikAE($berdasarkan, $hal, $propinsi, $kab, $jenjang, $tampil);

		// echo "<pre>";
		// echo var_dump($ambildata);
		// echo "</pre>";
		// die();

		$this->load->model("M_eksekusi");
		$dataeks = $this->M_eksekusi->getordereksbykode($kode_eks);
		$orderid = $dataeks->order_id;
		$urlsponsor = $dataeks->url_sponsor;
		$durasisponsor = $dataeks->durasi_sponsor;

		$this->load->model("M_payment");
		$payment = $this->M_payment->cekstatusdonasi($orderid);

		$batasakhir = $payment->tgl_berakhir;

//		echo "<pre>";
//		echo var_dump($ambildata);
//		echo "</pre>";
//		die();

		$nmjenjang = "";
		if ($jenjang != "all")
			$nmjenjang = " " . $jenjang;

		$nmpropinsi = "";
		if ($propinsi != "all" && $kab == "all") {
			$getprop = $this->M_channel->getNamaPropinsi($propinsi);
			$nmpropinsi = " Prop. " . substr($getprop->nama_propinsi, 9);
		}

		$nmkota = "";
		if ($kab != "all") {
			$nmpropinsi = "";
			$getkab = $this->M_channel->getNamaKota($kab);
			$nmkota = " " . substr($getkab->nama_kota, 5);
		}

		$grup = count($ambildata) . " sekolah" . $nmjenjang . $nmpropinsi . $nmkota . " " . $berdasarkan . " terbanyak " . $hal;
		//echo $grup;

		$cekgrup = $this->M_eksekusi->cekgrupsekolah($kode_eks, $grup);
		if ($cekgrup)
			echo "wisono";
		else {
			$jmldata = 1;
			foreach ($ambildata as $row) {
				$data[$jmldata]['kode_eks'] = $kode_eks;
				$data[$jmldata]['npsn'] = $row->npsn;
				if ($berdasarkan=="siswa")
					$totalnya = $row->jmlsiswa;
				else if ($berdasarkan=="modul")
					$totalnya = $row->jmlkelas;
				else if ($berdasarkan=="video")
					$totalnya = $row->jmlkonten;
				$data[$jmldata]['total'] = $totalnya;
				$data[$jmldata]['grup'] = $grup;
				$data[$jmldata]['batasdonasi'] = $batasakhir;
				$data[$jmldata]['url_video'] = $urlsponsor;
				$data[$jmldata]['durasi_video'] = $durasisponsor;
				$jmldata++;
			}
			if ($this->M_eksekusi->insertbatch_pilsekolah($data, $kode_eks))
				echo "sukses";
			else
				echo "gagal";
		}
	}

	public function hapusgrup($kodeeks)
	{
		$iduser = $this->session->userdata("id_user");
		$grup = $this->input->post('namagrup');
		$cekkode = $this->M_eksekusi->getlasteksekusi($iduser, 0, $kodeeks);

		if ($cekkode) {
			if ($this->M_eksekusi->delgrup($kodeeks, $grup))
				echo "sukses";
			else
				echo "gagal";
		} else {
			echo "gagal kode";
		}
	}

	public function register_donatur($opsi = null)
	{
		$data = array();
		$data['konten'] = 'v_register_donatur';

		$data['addedit'] = "add";

		$data['opsi'] = $opsi;

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function edit_donatur($opsi,$id_donatur)
	{
		$data = array();
		$data['konten'] = 'v_register_donatur';

		$data['addedit'] = "edit";
		$data['userdonatur'] = $this->M_eksekusi->getDonatur($id_donatur);

		$data['opsi'] = $opsi;
		if ($opsi=="id")
			$data['opsi'] = null;


		$this->load->view('layout/wrapper_umum', $data);
	}

	public function donatur()
	{
		$data = array();
		$data['konten'] = 'v_donatur';

		$iduser = $this->session->userdata("id_user");
//		echo "<br><br><br><br><br>".$iduser;
		$data['dafuser'] = $this->M_eksekusi->getAllDonatur($iduser);

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function pilih_donatur($kodeeks = null)
	{
		$data = array();
		$data['konten'] = 'v_donatur_pilih';

		$iduser = $this->session->userdata("id_user");
		if ($kodeeks == null) {
			$cekdata = $this->M_eksekusi->getlasteksekusi($iduser, 0);
			$kodeeks = $cekdata->kode_eks;
		}
		$data['kodeeks'] = $kodeeks;
		$data['dafuser'] = $this->M_eksekusi->getAllDonatur($iduser);
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function update_donatur($opsi=null)
	{
		$data = array();

		$data['id_ae'] = $this->session->userdata("id_user");
		$data['email_donatur'] = $this->input->post('iemail');
		$data['nama_donatur'] = $this->input->post('ifirst_name');
		$data['telp_donatur'] = $this->input->post('ihape');
		$data['alamat'] = $this->input->post('ialamat');
		$data['pekerjaan_donatur'] = $this->input->post('ijob');
		$data['nama_lembaga'] = $this->input->post('iinstansi');

		if ($this->input->post('addedit') == "add")
			$update = $this->M_eksekusi->tambahdonatur($data);
		else {
			$iddonatur = $this->input->post('iddonatur');
			$update = $this->M_eksekusi->updatedonatur($data, $iddonatur);
		}
		if ($opsi==null)
			redirect("eksekusi/donatur");
		else
			redirect("eksekusi/pilih_donatur");

	}

	public function donatur_terpilih($kodeeks, $iddonatur)
	{
		$data = array("id_donatur" => $iddonatur);
		$iduser = $this->session->userdata("id_user");
		$update = $this->M_eksekusi->updateeksekusi($data, $kodeeks, $iduser);

		redirect("eksekusi");
	}

	public function deldonatur()
	{
		$iddonatur = $this->input->post('iddonatur');
		$iduser = $this->session->userdata('id_user');
		$hapus = $this->M_eksekusi->deldonatur($iddonatur, $iduser);
		if($hapus)
			echo "berhasil";
		else
			echo "gagal";
	}

	public function delsekolahsisa($kodeeks)
	{
		$diambil = $this->input->post('totaldiambil');
		$hapus = $this->M_eksekusi->delsekolahsisa($kodeeks, $diambil);
		if($hapus)
			echo "sukses";
		else
			echo "gagal";
	}

	public function transaksi()
	{
		$data = array();
		$data['konten'] = 'v_eks_transaksi';

		$iduser = $this->session->userdata("id_user");
		$this->load->model("M_login");
		$data['getuserdata'] = $this->M_login->getUser($iduser);
		$data['daftransaksi'] = $this->M_eksekusi->getTransaksi($iduser);

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function sponsor()
	{
		$data = array('title' => 'Daftar User', 'menuaktif' => '11',
			'isi' => 'v_eks_sponsor');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper', $data);
	}

	public function tesver($npsn)
	{
		$verifikator = $this->M_eksekusi->getveraktif($npsn);
		echo $verifikator->first_name." - Last Login: ".$verifikator->lastlogin;
	}

	public function teshangus($iduser)
	{
		echo "HASIL:".$this->M_eksekusi->cekchanelhangus($iduser);
	}

	public function del_transaksi_ae()
	{
		$iduser = $this->input->post('id');
		if($this->M_eksekusi->del_transaksi_ae($iduser))
			echo "berhasil";
		else
			echo "gagal";
	}

	public function hasil_sekolah_donasi($idtransaksi)
	{
		$data = array();
		$data['konten'] = 'v_eks_sekolahdonasi';

		//$iduser = $this->session->userdata("id_user");
		$getordereksbyid = $this->M_eksekusi->getordereksbyid($idtransaksi);
//		echo "<br><br><br><br><br><br><br><br>".var_dump($getordereksbyid);
		$orderid = $getordereksbyid->order_id;
		$data['dafsekolah'] = $this->M_eksekusi->getHasilSekolahSasaran($orderid);
		$datagrup = $this->M_eksekusi->getDataGrup($orderid);
		$data['grup'] = $datagrup[0]->grup;
		$data['orderid'] = $orderid;

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function tespay($order_id)
	{
		$this->M_eksekusi->paysekolahpilihan($order_id);
	}
}
