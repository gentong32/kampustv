<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bimbel extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_induk');
		$this->load->model('M_bimbel');
		$this->load->helper(array('Form', 'Cookie', 'String', 'captcha', 'download'));
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->library('pagination');
		if (!$this->session->userdata('loggedIn')) {
			redirect("/informasi/infobimbel");
		}
		//|| !$this->session->userdata('bimbel') == 1
	}

	public function index()
	{
		if ($this->is_connected()) {
//			if ($this->session->userdata('loggedIn') && $this->session->userdata('bimbel') >= 0) {
			redirect("/bimbel/page/1");
//			} else {
//				redirect("/informasi/infobimbel");
//			}
		} else {
			echo "SAMBUNGAN INTERNET TIDAK TERSEDIA";
			//$this->menujujenjang();
		}
	}

	public function is_connected($sCheckHost = 'www.google.com')
	{
		return (bool)@fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
	}

	public function page($hal = null)
	{
		if ($hal == null || $hal == 0)
			$hal = 1;
//			redirect("/bimbel/page/1");
		$this->get_bimbel("hal", $hal);
	}

	public function get_bimbel($linklist = null, $iduser = null, $hal2 = null)
	{

		$jenis = 3; ////// bimbel
		$strstrata = array("", "lite", "pro", "premium");
		$tglbatas = new DateTime("2020-01-01 00:00:00");

		if ($this->session->userdata('loggedIn')) {
			$id_user = $this->session->userdata("id_user");
			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, 3);
			if ($cekbeli)
				$tglbatas = new DateTime($cekbeli->tgl_batas);
		} else {
			$id_user = 0;
		}

		$tgl_sekarang = new DateTime();
		$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

//		echo "<br><br><br><br><br>TGLBATAS:".$tglbatas->format("d-m-Y H:i:s");
//		echo "<br>TGLSEKARANG:".$tgl_sekarang->format("d-m-Y H:i:s");

		if ($tgl_sekarang > $tglbatas) {
			$expired = true;
			$kodebeli = "expired";
			$tstrata = "0";
		} else {
			$expired = false;
			$kodebeli = $cekbeli->kode_beli;
			$tstrata = $strstrata[$cekbeli->strata_paket];
		}

		$this->load->Model('M_bimbel');
		$dafplaylistall = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli);
		$jmlaktif = 0;
		$jmlkeranjang = 0;
		foreach ($dafplaylistall as $datane) {
			if ($datane->link_paket != null)
				$jmlaktif++;
			if ($datane->dikeranjang == 1)
				$jmlkeranjang++;
		}


		if ($iduser == "0")
			redirect("/bimbel/page/1");

		if ($linklist == "hal") {
			$data = array('title' => 'BIMBEL ONLINE', 'menuaktif' => '32',
				'isi' => 'v_bimbelall');


			//$data['dafvideo1'] = $this->M_bimbel->getBimbelAll();
			$data['dafjenjang'] = $this->M_bimbel->getJenjangBimbel();
			$data['dafkelas'] = $this->M_bimbel->getKelasBimbel();
			$data['dafkategori'] = $this->M_bimbel->getKategoriAll();
			$data['mapel'] = "";
			$data['asal'] = "";
			$data['ambilpaket'] = $tstrata;
			$data['jenis'] = $jenis;
			$data['jenjang'] = 0;
			$data['njenjang'] = 0;
			$data['kategori'] = 0;
			$data['kuncine'] = "";
			$data['tglbatas'] = $tglbatas->format("d-m-Y");

			$data['expired'] = $expired;
			if ($expired)
				$data['kodebeli'] = "expired";
			else
				$data['kodebeli'] = $cekbeli->kode_beli;
			$data['totalaktif'] = $jmlaktif;
			$data['totalkeranjang'] = $jmlkeranjang;
			$hargapaket = $this->M_bimbel->gethargapaket("bimbel");
			if ($tstrata == "0")
				$data['totalmaksimalpilih'] = 0;
			else
				$data['totalmaksimalpilih'] = $hargapaket["njudul_" . $tstrata];

			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			if ($iduser == "cari") {
				$hitungdata = sizeof($this->M_bimbel->getBimbelCari(0, 0, $hal2));
			} else {
				$hitungdata = sizeof($dafplaylistall);
			}

			$config['base_url'] = site_url('bimbel/'); //site url
			$config['total_rows'] = $hitungdata;
			$config['per_page'] = 10;  //show record per halaman
			$config["uri_segment"] = 3;  // uri parameter
			$choice = $config["total_rows"] / $config["per_page"];
			$config["num_links"] = floor($choice);
			// Membuat Style pagination untuk BootStrap v4
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Prev';
			$config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
			$config['full_tag_close'] = '</ul></nav></div>';
			$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
			$config['num_tag_close'] = '</span></li>';
			$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
			$config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
			$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
			$config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
			$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
			$config['prev_tagl_close'] = '</span>Next</li>';
			$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
			$config['first_tagl_close'] = '</span></li>';
			$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
			$config['last_tagl_close'] = '</span></li>';

			$this->pagination->initialize($config);

			$data['total_data'] = $hitungdata;
			$data['pagination'] = $this->pagination->create_links();
		} else {
			$data = array('title' => 'BIMBEL ONLINE', 'menuaktif' => '32',
				'isi' => 'v_bimbel_pilih');
			$paketsoal = $this->M_bimbel->getPaket($linklist);

			$tugasguru = $this->M_bimbel->getTugas($linklist);
			$data['tugasguru'] = $tugasguru;
			if ($tugasguru)
				$idtugasguru = $tugasguru->id_tugas;
			else
				$idtugasguru = 0;

			$tugassiswa = $this->M_bimbel->getTugasSiswa($idtugasguru, $id_user);

//			echo "<br><br><br><br><br><br>";
//			if ($expired==false)
//				echo "OK".$tstrata;
//			else
//				echo "EXPIRED".$tstrata;

			if ($expired == false && ($tstrata == "pro" || $tstrata == "premium")) {
				if (!$tugassiswa) {
					$isi = array(
						'id_tugas' => $idtugasguru,
						'id_user' => $id_user,
					);
					$this->M_bimbel->addTugasSiswa($isi);
					$tugassiswa = $this->M_bimbel->getTugasSiswa($idtugasguru, $id_user);
				}
			}
			$data['tugassiswa'] = $tugassiswa;

			$data['statussoal'] = $paketsoal[0]->statussoal;
			$data['pengunggah'] = $paketsoal[0]->first_name . " " . $paketsoal[0]->last_name;

			$nilaiuser = $this->M_bimbel->ceknilai($linklist, $id_user);
			$data['nilaiuser'] = $nilaiuser;
			$data['uraianmateri'] = $paketsoal[0]->uraianmateri;
			$data['filemateri'] = $paketsoal[0]->filemateri;
			$data['asal'] = "menu";

			$data['expired'] = $expired;
			if ($expired)
				$data['kodebeli'] = "expired";
			else
				$data['kodebeli'] = $cekbeli->kode_beli;
			$data['totalaktif'] = $jmlaktif;
			$data['totalkeranjang'] = $jmlkeranjang;
			$data['ambilpaket'] = $tstrata;

			$hargapaket = $this->M_bimbel->gethargapaket("bimbel");

			if ($tstrata == "0")
				$data['totalmaksimalpilih'] = 0;
			else
				$data['totalmaksimalpilih'] = $hargapaket["njudul_" . $tstrata];

			$npsnku = $this->session->userdata('npsn');
			$datapesan = $this->M_channel->getChat(3, $npsnku);
			$data['datapesan'] = $datapesan;
			$data['idku'] = $this->session->userdata('id_user');
			$data['linklist'] = $linklist;
			$data['jenis'] = "bimbel";
			$data['namasekolah'] = "Topik [" . $paketsoal[0]->nama_paket . "]";

		}


		if ($iduser == "cari") {
			$data['kuncine'] = $hal2;
			$data['dafplaylist'] = $this->M_bimbel->getBimbelCari(0, 0, $hal2);
		} else {
			if ($linklist == "hal") {
				$data['dafplaylist'] = $this->M_bimbel->getDafPlayListBimbelAll(null, $iduser, $kodebeli, $id_user);
			} else {
				$data['dafplaylist'] = $this->M_bimbel->getDafPlayListBimbelAll($linklist, "semua", $kodebeli, $id_user);
			}
		}

//		echo "<pre>";
//		echo var_dump($data['dafplaylist']);
//		echo "</pre>";

		if ($data['dafplaylist']) {
			$data['punyalist'] = true;
			$statusakhir = $data['dafplaylist'][0]->link_list;

			if ($linklist == null) {
				$data['playlist'] = $this->M_bimbel->getPlayListBimbel($statusakhir, $iduser);
			} else {
				$data['playlist'] = $this->M_bimbel->getPlayListBimbel($linklist, $iduser);
			}

		} else {

			$data['punyalist'] = false;
		}


		$data['infoguru'] = $this->M_bimbel->getInfoGuru($iduser);
//			$data['dafvideo'] = $this->M_bimbel->getVodGuru($iduser);
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		$data['iduser'] = $iduser;
		if ($linklist == "hal")
			$linklist = null;
		$data['id_playlist'] = $linklist;
		$data['gembokorpilih'] = $this->M_bimbel->cekpilihan($id_user, $jenis, $linklist);

		$this->load->view('layout/wrapper3vod', $data);

	}

	public function menujujenjang()
	{
		$nmjenjang = array("", "PAUD", "PAUD", "PAUD", "PAUD", "TK", "TK", "TK", "SD", "SD", "SD", "SMP", "SMP", "SMP", "SMA", "SMA",
			"SMA", "kursus", "PKBM", "pondok", "PT");
		$idjenjang = $this->session->userdata('id_jenjang');
//        echo "DX<br>DX<br>DX<br>DX:::<br>".$nmjenjang[$idjenjang];
//        die();
		redirect(base_url() . 'bimbel/mapel/' . $nmjenjang[$idjenjang]);
	}

	public function daftarmapel()
	{
		$namapendek = $_GET['namapendek'];
		$isi = $this->M_bimbel->dafMapelBimbel($namapendek);
		echo json_encode($isi);
	}

	public function mapel($jenjangpendek = null, $idkelas = null, $idmapel = null, $kunci0 = null, $kunci1 = null)
	{
		$data = array('title' => 'BIMBEL ONLINE', 'menuaktif' => '3',
			'isi' => 'v_bimbelall');

		$kunci0 = preg_replace('!\s+!', ' ', $kunci0);
		$kunci0 = str_replace("%20%20", "%20", $kunci0);
		$kunci0 = str_replace("%20", " ", $kunci0);

		$kunci1 = preg_replace('!\s+!', ' ', $kunci1);
		$kunci1 = str_replace("%20%20", "%20", $kunci1);
		$kunci1 = str_replace("%20", " ", $kunci1);

		$data['mapel'] = "";
		$data['jenjang'] = 0;
		$data['kategori'] = 0;
		$data['message'] = "";

		if ($jenjangpendek == null) {
			redirect("/bimbel");
		} else
			if ($jenjangpendek == "carikategori") {
				redirect("/bimbel/kategori/pilih");
			}


		//////////////////////// buat hitung data
		if ($kunci0 == "cari") {
			$hitungdata = $this->M_bimbel->getBimbelCari($jenjangpendek, $idmapel, $kunci1);
		} else if ($idmapel == "cari") {
			$hitungdata = $this->M_bimbel->getBimbelCari($jenjangpendek, 0, $kunci0);
		} else if ($idmapel > 0 && $kunci0 == null) {
			$hitungdata = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel);
		} else if ($idmapel == 0 && $kunci0 > 0) {
			$hitungdata = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel);
		} else {
			$hitungdata = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel);
		}

		$config['base_url'] = site_url('bimbel/'); //site url
		$config['total_rows'] = count($hitungdata);

//        echo  $config['total_rows'];
//        die();

		$config['per_page'] = 10;  //show record per halaman
		$config["uri_segment"] = 3;  // uri parameter
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = floor($choice);

		// Membuat Style pagination untuk BootStrap v4
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</ul></nav></div>';
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close'] = '</span>Next</li>';
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close'] = '</span></li>';

		$this->pagination->initialize($config);

		$tambahseg = 0;
		if (base_url() == "http://localhost/fordorum/") {
			$tambahseg = 0;
		}


		if ($idmapel == "0") {
			$data['page'] = ($this->uri->segment(5 + $tambahseg)) ? $this->uri->segment(5 + $tambahseg) : 0;
			// echo "<br><br><br><br>MAPEK".$data['page'];
			//die();
		} else if ($idmapel > 0) {
			if ($kunci0 == "cari") {
				$data['page'] = ($this->uri->segment(7 + $tambahseg)) ? $this->uri->segment(7 + $tambahseg) : 0;
			} else {
				$data['page'] = ($this->uri->segment(5 + $tambahseg)) ? $this->uri->segment(5 + $tambahseg) : 0;
			}
		} else if ($idmapel == "cari") {
			$data['page'] = ($this->uri->segment(6 + $tambahseg)) ? $this->uri->segment(6 + $tambahseg) : 0;
			// echo "<br><br><br><br>MAPEK".$data['page'];
			//die();
		} else if ($kunci1 != null) {
			$data['page'] = ($this->uri->segment(7 + $tambahseg)) ? $this->uri->segment(7 + $tambahseg) : 0;
			//echo "<br><br><br><br>MAPEOK".$data['page'];
			//die();
		} else {
			$data['page'] = ($this->uri->segment(6 + $tambahseg)) ? $this->uri->segment(6 + $tambahseg) : 0;
			//echo "<br><br><br><br>MAPEOK".$data['page'];
			//die();
		}

		if ($data['page'] >= 1)
			$data['page'] = ($data['page'] - 1) * $config['per_page'];


//        echo "MAPEOK".$data['page']."---IDMAPEL".$idmapel;
//		die();

		$data['pagination'] = $this->pagination->create_links();

		if ($kunci0 == "cari") {
			//echo "q1";
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['jenjang'] = $jenjang[0]->id;
			$data['dafvideo'] = $this->M_bimbel->getBimbelCari($jenjangpendek, $idmapel, $kunci1, $config["per_page"], $data['page']);
			$data['kuncine'] = $kunci1;
		} else if ($idmapel == "cari") {
			//echo "q2";
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['kuncine'] = $kunci0;
			$data['jenjang'] = $jenjang[0]->id;
			$data['dafvideo'] = $this->M_bimbel->getBimbelCari($jenjangpendek, 0, $kunci0, $config["per_page"], $data['page']);
		} else if ($idmapel > 0 && $kunci0 == null) {
			//echo("q3");

			$jenjang = $this->M_bimbel->cekJenjangMapel($idmapel);
			$data['jenjang'] = $jenjang[0]->id_jenjang;
			$data['mapel'] = $idmapel;
			$data['kuncine'] = $kunci1;
			$data['dafvideo'] = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel, $config["per_page"], $data['page']);
		} else if ($idmapel >= 0) {

			//echo("q4");
			$data['kuncine'] = "";
			$data['mapel'] = $idmapel;
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['jenjang'] = $jenjang[0]->id;
			//echo ("JP".$jenjangpendek);
			$data['dafvideo'] = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel, $config["per_page"], $data['page']);

		} else if ($idmapel == null && $jenjangpendek != null) {

			//echo("q4");
			$data['kuncine'] = "";
			$idmapel = 0;
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['jenjang'] = $jenjang[0]->id;
			//echo ("JP".$jenjangpendek);
			$data['dafvideo'] = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel, $config["per_page"], $data['page']);

		}


		$data['mapel'] = $idmapel;

		$data['asal'] = "mapel";
		if ($kunci0 == "cari")
			$data['asal'] = "mapelcari";
		$data['jenjangpendek'] = $jenjangpendek;

		$data['kategori'] = 0;
		$data['dafjenjang'] = $this->M_bimbel->getJenjangBimbel();
		$data['dafkelas'] = $this->M_bimbel->getKelasBimbel();
		$data['dafmapel'] = $this->M_bimbel->dafMapelBimbel($jenjangpendek, $idkelas);
		$data['dafkategori'] = $this->M_bimbel->getKategoriAll();
		$data['message'] = $this->session->flashdata('message');
		$data['total_data'] = $config['total_rows'];
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		$data['iduser'] = null;

		if ($jenjangpendek != null) {
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['njenjang'] = $jenjang[0]->id;
		} else {
			$data['njenjang'] = 0;
		}

		if ($idkelas == null) {
			$data['nkelas'] = 0;
		} else {
			$data['nkelas'] = $idkelas;
		}

		if ($idmapel == null) {
			$data['nmapel'] = 0;
		} else {
			$data['nmapel'] = $idmapel;
		}

		$jenis = 3; ////// bimbel
		$strstrata = array("", "lite", "pro", "premium");
		$tglbatas = new DateTime("2020-01-01 00:00:00");

		if ($this->session->userdata('loggedIn')) {
			$id_user = $this->session->userdata("id_user");
			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, 3);
			if ($cekbeli)
				$tglbatas = new DateTime($cekbeli->tgl_batas);
		} else {
			$id_user = 0;
		}

		$tgl_sekarang = new DateTime();
		$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		if ($tgl_sekarang > $tglbatas) {
			$expired = true;
			$kodebeli = "expired";
			$tstrata = "0";
		} else {
			$expired = false;
			$kodebeli = $cekbeli->kode_beli;
			$tstrata = $strstrata[$cekbeli->strata_paket];
		}


		$dafplaylistall = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli);
		$jmlaktif = 0;
		$jmlkeranjang = 0;
		foreach ($dafplaylistall as $datane) {
			if ($datane->link_paket != null)
				$jmlaktif++;
			if ($datane->dikeranjang == 1)
				$jmlkeranjang++;
		}

		$data['expired'] = $expired;
		if ($expired)
			$data['kodebeli'] = "expired";
		else
			$data['kodebeli'] = $cekbeli->kode_beli;
		$data['totalaktif'] = $jmlaktif;
		$data['totalkeranjang'] = $jmlkeranjang;
		$data['tglbatas'] = $tglbatas->format("d-m-Y");

		$hargapaket = $this->M_bimbel->gethargapaket("bimbel");

		if ($tstrata == "0")
			$data['totalmaksimalpilih'] = 0;
		else
			$data['totalmaksimalpilih'] = $hargapaket["njudul_" . $tstrata];


		$data['dafplaylist'] = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel);

		if ($data['dafplaylist']) {
			$data['punyalist'] = true;
			$statusakhir = $data['dafplaylist'][0]->link_list;
//				echo "<br><br><br><br><br>SattusAkhir:".$statusakhir;
			$data['playlist'] = $this->M_bimbel->getPlayListBimbel($statusakhir, null);
		} else {
//            $data['playlist'] = $this->M_bimbel->getPlayListGuru($kd_user);
			$data['punyalist'] = false;
//			if (!$this->session->userdata('loggedIn')) {
//				redirect('/');
//			}
		}

		$data['ambilpaket'] = $tstrata;
		$data['jenis'] = $jenis;


		$data['infoguru'] = $this->M_bimbel->getInfoGuru(null);
//			$data['dafvideo'] = $this->M_bimbel->getVodGuru($iduser);
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		$data['iduser'] = null;
		$data['id_playlist'] = null;

		$this->load->view('layout/wrapper3vod', $data);
	}

	public function kategori($idkategori = null, $cari = null, $kunci = null, $cari2 = null)
	{
		if ($idkategori == null) {
			redirect("/bimbel");
		} else if ($idkategori == "pilih") {
			$idkategori = "99";
		}

		$kunci = preg_replace('!\s+!', ' ', $kunci);
		$kunci = str_replace("%20%20", "%20", $kunci);
		$kunci = str_replace("%20", " ", $kunci);

		$data = array('title' => 'PERPUSTAKAAN DIGITAL', 'menuaktif' => '3',
			'isi' => 'v_bimbelall');

		//////////////////////// buat hitung data
		///
		if ($cari == "cari") {
			if ($idkategori == "99") {
				redirect("/bimbel/cari/" . $cari);
			} else {
				$config['base_url'] = site_url(base_url() . 'kategori/' . $idkategori . '/cari/' . $kunci); //site url
				$hitungdata = $this->M_bimbel->getBimbelCari('kategori', $idkategori, $kunci);
			}
		} else if ($kunci == "cari") {
			$config['base_url'] = site_url(base_url() . 'kategori/' . $idkategori . '/cari/' . $kunci); //site url
			$hitungdata = $this->M_bimbel->getBimbelCari('kategori', $idkategori, $kunci);
		} else {
			$config['base_url'] = site_url(base_url() . 'kategori/' . $idkategori); //site url
			$hitungdata = $this->M_bimbel->getBimbelKategori($idkategori);
		}


		$config['total_rows'] = count($hitungdata);

		$config['per_page'] = 10;  //show record per halaman
		$config["uri_segment"] = 3;  // uri parameter
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = floor($choice);

		// Membuat Style pagination untuk BootStrap v4
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</ul></nav></div>';
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close'] = '</span>Next</li>';
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close'] = '</span></li>';

		$this->pagination->initialize($config);

		$tambahseg = 0;
		if (base_url() == "http://localhost/fordorum/") {
			$tambahseg = 0;
		}

		if ($cari == "cari")
			$data['page'] = ($this->uri->segment(6 + $tambahseg)) ? $this->uri->segment(6 + $tambahseg) : 0;
		else
			$data['page'] = ($this->uri->segment(4 + $tambahseg)) ? $this->uri->segment(4 + $tambahseg) : 0;


		if ($data['page'] >= 1)
			$data['page'] = ($data['page'] - 1) * $config['per_page'];

//		echo ($this->uri->segment(6));
//		die();

		$data['pagination'] = $this->pagination->create_links();


		if ($cari == "cari") {
			$data['dafvideo'] = $this->M_bimbel->getBimbelCari('kategori', $idkategori, $kunci, $config["per_page"], $data['page']);
			$data['kuncine'] = $kunci;
		} else if ($kunci == "cari") {
			$data['dafvideo'] = $this->M_bimbel->getBimbelCari('kategori', $idkategori, $cari2, $config["per_page"], $data['page']);
			$data['kuncine'] = $cari2;
		} else {
			$data['dafvideo'] = $this->M_bimbel->getBimbelKategori($idkategori, $config["per_page"], $data['page']);
			$data['kuncine'] = '';
		}

		if ($cari == "cari")
			$data['asal'] = "kategoricari";
		else
			$data['asal'] = "kategori";
		$data['dafjenjang'] = $this->M_bimbel->getJenjangBimbel();
		$data['dafkategori'] = $this->M_bimbel->getKategoriAll();
		$data['mapel'] = "";
		$data['jenjang'] = 0;
		$data['jenjangpendek'] = "";
		$data['kategori'] = $idkategori;
		$data['total_data'] = $config['total_rows'];
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		$this->load->view('layout/wrapper3vod', $data);

	}

	public function cari($tekskunci = null, $hal = null)
	{
		$data = array('title' => 'BIMBEL ONLINE', 'menuaktif' => '32',
			'isi' => 'v_bimbelall');

		$kunci = htmlspecialchars($tekskunci);
		$data['message'] = "";

		if ($kunci == "") {
			$this->index();
		} else {
			$kunci = preg_replace('!\s+!', ' ', $kunci);
			$kunci = str_replace("%20%20", "%20", $kunci);
			$kunci = str_replace("%20", " ", $kunci);
			//$kunci = str_replace("dan","",$kunci);

			$data['dafvideo'] = $this->M_bimbel->getBimbelCari(0, 0, $kunci);
			$jmldata = sizeof($data['dafvideo']);
//			echo "<br><br><br><br><br><br>".$jmldata;

			$config['total_rows'] = $jmldata;

			$config['per_page'] = 10;  //show record per halaman
			$config["uri_segment"] = 3;  // uri parameter
			$choice = $config["total_rows"] / $config["per_page"];
			$config["num_links"] = floor($choice);

			// Membuat Style pagination untuk BootStrap v4
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Prev';
			$config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
			$config['full_tag_close'] = '</ul></nav></div>';
			$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
			$config['num_tag_close'] = '</span></li>';
			$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
			$config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
			$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
			$config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
			$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
			$config['prev_tagl_close'] = '</span>Next</li>';
			$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
			$config['first_tagl_close'] = '</span></li>';
			$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
			$config['last_tagl_close'] = '</span></li>';

			$this->pagination->initialize($config);

			$tambahseg = 0;
			if (base_url() == "http://localhost/fordorum/") {
				$tambahseg = 0;
			}

			$data['page'] = ($this->uri->segment(4 + $tambahseg)) ? $this->uri->segment(4 + $tambahseg) : 0;


			if ($data['page'] >= 1)
				$data['page'] = ($data['page'] - 1) * $config['per_page'];

			$data['pagination'] = $this->pagination->create_links();
			$data['dafvideo'] = $this->M_bimbel->getBimbelCari(0, 0, $kunci, $config["per_page"], $data['page']);

			$data['dafjenjang'] = $this->M_bimbel->getJenjangBimbel();
			$data['dafkategori'] = $this->M_bimbel->getKategoriAll();
			$data['dafkelas'] = $this->M_bimbel->getKelasAll();
			$data['mapel'] = "";
			$data['kuncine'] = $kunci;
			$data['jenjangpendek'] = "";
			$data['jenjang'] = 0;
			$data['kategori'] = 0;
			$data['asal'] = "cari";
			$data['total_data'] = $config['total_rows'];
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();
			$data['njenjang'] = 0;
			$data['nkelas'] = 0;
			$data['nmapel'] = 0;

			$id_user = $this->session->userdata("id_user");
			$jenis = 3; ////// bimbel
			$strstrata = array("", "lite", "pro", "premium");
			$tglbatas = new DateTime("2020-01-01 00:00:00");

			if ($this->session->userdata('loggedIn')) {
				$id_user = $this->session->userdata("id_user");
				$this->load->Model('M_channel');
				$cekbeli = $this->M_channel->getlast_kdbeli($id_user, 3);
				if ($cekbeli)
					$tglbatas = new DateTime($cekbeli->tgl_batas);
			} else {
				$id_user = 0;
			}

			$tgl_sekarang = new DateTime();
			$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

			if ($tgl_sekarang > $tglbatas) {
				$expired = true;
				$kodebeli = "expired";
				$tstrata = "0";
			} else {
				$expired = false;
				$kodebeli = $cekbeli->kode_beli;
				$tstrata = $strstrata[$cekbeli->strata_paket];
			}

			$dafplaylistall = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli);
			$jmlaktif = 0;
			$jmlkeranjang = 0;
			foreach ($dafplaylistall as $datane) {
				if ($datane->link_paket != null)
					$jmlaktif++;
				if ($datane->dikeranjang == 1)
					$jmlkeranjang++;
			}

			$data['expired'] = $expired;
			if ($expired)
				$data['kodebeli'] = "expired";
			else
				$data['kodebeli'] = $kodebeli;
			$data['totalaktif'] = $jmlaktif;
			$data['ambilpaket'] = $tstrata;
			$data['jenis'] = $jenis;
			$data['tglbatas'] = $tglbatas->format("d-m-Y");
			$data['totalkeranjang'] = $jmlkeranjang;
			$hargapaket = $this->M_bimbel->gethargapaket("bimbel");
			if ($tstrata == "0")
				$data['totalmaksimalpilih'] = 0;
			else
				$data['totalmaksimalpilih'] = $hargapaket["njudul_" . $tstrata];

			$data['dafplaylist'] = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, null, null, null, $kunci);

			if ($data['dafplaylist']) {
				$data['punyalist'] = true;
				$statusakhir = $data['dafplaylist'][0]->link_list;
//				echo "<br><br><br><br><br>SattusAkhir:".$statusakhir;
				$data['playlist'] = $this->M_bimbel->getPlayListBimbel($statusakhir, null);
			} else {
//            $data['playlist'] = $this->M_bimbel->getPlayListGuru($kd_user);
				$data['punyalist'] = false;
//			if (!$this->session->userdata('loggedIn')) {
//				redirect('/');
//			}
			}

			$data['infoguru'] = $this->M_bimbel->getInfoGuru(null);
//			$data['dafvideo'] = $this->M_bimbel->getVodGuru($iduser);

			$data['iduser'] = null;
			$data['id_playlist'] = null;
			$this->load->view('layout/wrapper3vod', $data);

		}
	}

	public function get_autocomplete()
	{
		if (isset($_GET['term'])) {
			$result = $this->M_bimbel->search_Bimbel($_GET['term']);
			if (count($result) > 0) {
				foreach ($result as $row)
					$arr_result[] = array(
						"value" => $row->nama_paket,
						"durasi" => $row->durasi_paket
					);
				echo json_encode($arr_result);
			}
		}
	}

	public function tambahplaylist_bimbel()
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02') && $this->session->userdata('bimbel') != 1) {
			redirect('/');
		}
		$data = array('title' => 'Tambahkan Playlist', 'menuaktif' => '15',
			'isi' => 'v_channel_tambahplaylist_bimbel');
		$data['addedit'] = "add";
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function soal($opsi = null, $linklist = null)
	{
		if ($opsi == "tampilkan") {
			$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_bimbel_soal');
			$paketsoal = $this->M_bimbel->getPaket($linklist);
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$data['judul'] = $paketsoal[0]->nama_paket;
			$data['dafsoal'] = $this->M_bimbel->getSoal($paketsoal[0]->id);
			$data['linklist'] = $linklist;
			$data['asal'] = "owner";
		} else if ($opsi == "buat") {
			$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_bimbel_buatsoal');
			$paket = $this->M_bimbel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['dafsoal'] = $this->M_bimbel->getSoal($paket[0]->id);
			$data['linklist'] = $linklist;
			$data['asal'] = "owner";
		} else if ($opsi == "seting") {
			$data = array('title' => 'Seting Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_bimbel_soal_seting');
			$paketsoal = $this->M_bimbel->getPaket($linklist);
			$data['paket'] = $paketsoal;
			$dafsoal = $this->M_bimbel->getSoal($paketsoal[0]->id);
			$data['totalsoal'] = sizeof($dafsoal);
			$data['linklist'] = $linklist;
		} else if ($opsi == "kerjakan") {
			$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_bimbel_soal');
			$paketsoal = $this->M_bimbel->getPaket($linklist);
//			echo "<br><br><br><br><br><br><br>LINKLIST".$linklist;
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$data['judul'] = $paketsoal[0]->nama_paket;
			$data['dafsoal'] = $this->M_bimbel->getSoal($paketsoal[0]->id);
			$data['linklist'] = $linklist;
			$data['asal'] = "menu";
		} else if ($opsi == null) {
			redirect("/bimbel/page/1");
		} else if ($opsi != "tampilkan") {
			$data = array('title' => 'Mulai Soal', 'menuaktif' => '15',
				'isi' => 'v_bimbel_mulai');
			$paketsoal = $this->M_bimbel->getPaket($opsi);
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$dafsoal = $this->M_bimbel->getSoal($paketsoal[0]->id);
			$data['totalsoal'] = sizeof($dafsoal);
			$data['linklist'] = $opsi;
			$data['asal'] = $linklist;
		}

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper2', $data);
	}

	public function materi($opsi = null, $linklist = null)
	{
		if ($opsi == "buat") {
			$data = array('title' => 'Uraian Materi', 'menuaktif' => '15',
				'isi' => 'v_bimbel_buatmateri');
			$paket = $this->M_bimbel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['uraian'] = $paket[0]->uraianmateri;
			$data['file'] = $paket[0]->filemateri;
			$data['linklist'] = $linklist;
		} else if ($opsi == "tampilkan") {
			$data = array('title' => 'Uraian Materi', 'menuaktif' => '15',
				'isi' => 'v_bimbel_materi');
			$paket = $this->M_bimbel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['uraian'] = $paket[0]->uraianmateri;
			$data['file'] = $paket[0]->filemateri;
			$data['linklist'] = $linklist;
		}
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper2', $data);
	}

	public function tugas($opsi = null, $linklist = null, $idsiswa = null)
	{
		if ($opsi == "buat") {

			if ($this->session->userdata("bimbel") == 1) {
				$expired = false;
			} else {
				$expired = true;
			}
			$data = array('title' => 'Uraian Tugas', 'menuaktif' => '15',
				'isi' => 'v_bimbel_buattugas');
			$paket = $this->M_bimbel->getTugas($linklist);
			if (!$paket) {
				$isi = array(
					'tipe_paket' => 3,
					'link_list' => $linklist,
					'status' => 1
				);
				$this->M_bimbel->addTugas($isi);
				$paket = $this->M_bimbel->getTugas($linklist);
			}
			$data['judul'] = $paket->nama_paket;
			$data['uraian'] = $paket->tanyatxt;
			$data['file'] = $paket->tanyafile;
			$data['linklist'] = $linklist;
		} else if ($opsi == "tampilkan") {

			if ($this->session->userdata("bimbel") == 1) {
				$expired = false;
			} else {
				$expired = true;
//				if ($this->session->userdata('loggedIn')) {
//					$id_user = $this->session->userdata("id_user");
//					$this->load->Model('M_channel');
//					$cekbeli = $this->M_channel->getlast_kdbeli($id_user, 3);
//					if ($cekbeli)
//						$tglbatas = new DateTime($cekbeli->tgl_batas);
//				} else {
//					$id_user = 0;
//				}
//
//				$tgl_sekarang = new DateTime();
//				$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
//
//				if ($tgl_sekarang > $tglbatas) {
//					$expired = true;
//				} else {
//					$expired = false;
//				}
			}

			$data = array('title' => 'Uraian Tugas', 'menuaktif' => '15',
				'isi' => 'v_bimbel_tugas');
			$paket = $this->M_bimbel->getTugas($linklist);
			if (!$paket || $paket->tanyatxt == "")
				redirect(base_url() . "bimbel/tugas/buat/" . $linklist);
			$getalluservk = $this->M_bimbel->getUserVK(3, $linklist, $paket->id_tugas);
//			echo "<br><br><br>";
//			echo "<pre>";
//			echo var_dump($getalluservk);
//			echo "</pre>";

//			echo "JML1:".sizeof($getalluservk);
			$tgl_sekarang = new DateTime();
			$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$dafuser = array();
			foreach ($getalluservk as $datauser) {
				$tglbatas = new DateTime($datauser->tgl_batas);
				if ($tgl_sekarang > $tglbatas) {

				} else {
					if ($datauser->strata_paket == 2 || $datauser->strata_paket == 3)
						$dafuser[] = $datauser;
				}
			}

			$data['judul'] = $paket->nama_paket;
			$data['dafuser'] = $dafuser;
			$data['uraian'] = $paket->tanyatxt;
			$data['file'] = $paket->tanyafile;
			$data['linklist'] = $linklist;
		} else if ($opsi == "kerjakan") {
			$expired = false;
			if ($this->session->userdata('loggedIn')) {
				$id_user = $this->session->userdata("id_user");
				$this->load->Model('M_channel');
				$cekbeli = $this->M_channel->getlast_kdbeli($id_user, 3);
				if ($cekbeli)
					$tglbatas = new DateTime($cekbeli->tgl_batas);
			} else {
				$id_user = 0;
			}

			$tgl_sekarang = new DateTime();
			$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

			if ($tgl_sekarang > $tglbatas || $cekbeli->strata_paket == 1) {
				$expired = true;
			} else {
				$expired = false;
			}

			if ($this->session->userdata('a01') || ($this->session->userdata('sebagai')==4 &&
				$this->sessiono->userdata('verifikator')==3))
				$expired = false;

			$data = array('title' => 'Uraian Tugas', 'menuaktif' => '15',
				'isi' => 'v_bimbel_tugaskerjakan');
			$tugasguru = $this->M_bimbel->getTugas($linklist);
			$data['tugasguru'] = $tugasguru;
			$idtugasguru = $tugasguru->id_tugas;
			$tugassiswa = $this->M_bimbel->getTugasSiswa($idtugasguru, $id_user);
			if (!$tugassiswa) {
				$isi = array(
					'id_tugas' => $idtugasguru,
					'id_user' => $id_user
				);
				$this->M_bimbel->addTugasSiswa($isi);
				$tugassiswa = $this->M_bimbel->getTugasSiswa($idtugasguru, $id_user);
			}
			$data['tugassiswa'] = $tugassiswa;
			$data['id_tugas'] = $idtugasguru;
			$data['linklist'] = $linklist;
		} else if ($opsi == "penilaian") {
			if ($this->session->userdata("bimbel") == 1) {
				$expired = false;
			} else {
				$expired = true;
			}

			$data = array('title' => 'Uraian Tugas', 'menuaktif' => '15',
				'isi' => 'v_bimbel_responguru');
			$tugasguru = $this->M_bimbel->getTugas($linklist);
			$data['tugasguru'] = $tugasguru;
			$idtugasguru = $tugasguru->id_tugas;
			$tugassiswa = $this->M_bimbel->getTugasSiswa($idtugasguru, $idsiswa);

			$data['tugassiswa'] = $tugassiswa;
			$data['id_tugas'] = $idtugasguru;
			$data['linklist'] = $linklist;
		} else if ($opsi == "jawabansaya") {

			$expired = false;
			if ($this->session->userdata('loggedIn')) {
				$id_user = $this->session->userdata("id_user");
				$this->load->Model('M_channel');
				$cekbeli = $this->M_channel->getlast_kdbeli($id_user, 3);
				if ($cekbeli)
					$tglbatas = new DateTime($cekbeli->tgl_batas);
			} else {
				$id_user = 0;
			}

			$tgl_sekarang = new DateTime();
			$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

			if ($tgl_sekarang > $tglbatas) {
				$expired = true;
			} else {
				$expired = false;
			}


			$data = array('title' => 'Uraian Tugas', 'menuaktif' => '15',
				'isi' => 'v_bimbel_jawabansaya');
			$tugasguru = $this->M_bimbel->getTugas($linklist);
			$data['tugasguru'] = $tugasguru;
			$idtugasguru = $tugasguru->id_tugas;
			$tugassiswa = $this->M_bimbel->getTugasSiswa($idtugasguru, $id_user);

			$data['tugassiswa'] = $tugassiswa;
			$data['id_tugas'] = $idtugasguru;
			$data['linklist'] = $linklist;
		}

		if ($expired == false) {
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			$this->load->view('layout/wrapper2', $data);
		}

	}

	public function cekjawaban()
	{
		$jawaban_user = $this->input->post('jwbuser');
		$idjawaban_user = $this->input->post('idjwbuser');
		$iduser = $this->session->userdata('id_user');
		$linklist = $this->input->post('linklistnya');
		$paket = $this->M_bimbel->getPaket($linklist);
		$jmlsoalkeluar = $paket[0]->soalkeluar;
		$iduserpaket = $paket[0]->id_user;
		$kunci_jawaban = $this->M_bimbel->getSoal($paket[0]->id);
		$idsoal = array();
		$kuncisoal = array();

		foreach ($kunci_jawaban as $jawaban) {
			$kuncisoal[$jawaban->id_soal] = $jawaban->kunci;
		}

		$nomor = 1;
		foreach ($idjawaban_user as $jawabane) {
			$idsoal[$nomor] = $jawabane;
			$nomor++;
		}

		$nomor = 1;
		$betul = 0;
		foreach ($jawaban_user as $jawabane) {
			if ($kuncisoal[$idsoal[$nomor]] == $jawabane)
				$betul++;
			$nomor++;
		}

		$nilai = intval($betul * (100 / $jmlsoalkeluar) * 100) / 100;

//		if($iduser!=$iduserpaket)
		{
			$nilaiuser = $this->M_bimbel->ceknilai($linklist, $iduser);
			$highscore = $nilaiuser->highscore;
			if ($nilai > $highscore)
				$data['highscore'] = $nilai;
			$data['score'] = $nilai;
			$update = $this->M_bimbel->updatenilai($data, $linklist, $iduser);
			if ($update)
				echo($nilai);
			else
				echo "gagal";
		}
//		else
//		{
//			echo ($nilai);
//		}

	}

	public function upload_gambarsoal($linklist, $id, $kodefield, $fielddb)
	{
//		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
//			redirect('/event');
//		}

		$paket = $this->M_bimbel->getPaket($linklist);
		$id_paket = $paket[0]->id;

		$random = rand(100, 999);
		if (isset($_FILES['f' . $kodefield])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "soal/";
		$allow = "jpg|png|jpeg";

		$config = array(
			'upload_path' => "uploads/" . $path1,
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "204800000",
			//'max_height' => "768",
			//'max_width' => "1024"
		);

		//$this->upload->initialize($config);
		$this->load->library('upload', $config);
		if ($this->upload->do_upload("f" . $kodefield)) {
			$gbr = $this->upload->data();
//			$dataupload = array('upload_data' => $this->upload->data());

			if ($gbr['image_width'] > 600) {
				$config['image_library'] = 'gd2';
				$config['source_image'] = './uploads/soal/' . $gbr['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['quality'] = '50%';
				$config['width'] = 600;
				$config['new_image'] = './uploads/soal/' . $gbr['file_name'];
				$this->load->library('image_lib', $config);
				$this->load->library('image_lib');
				$this->image_lib->initialize($config);
				if (!$this->image_lib->resize()) {
					echo $this->image_lib->display_errors();
				}
				$this->image_lib->clear();
			}
//			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile1 = $gbr['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "g" . $id_paket . "_" . $id . "_" . $random . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$this->M_bimbel->updategbrsoal($namafilebaru, $id, $fielddb);

//			if ($addedit == "edit") {
//				//rename($alamat . $namafile1, $alamat . $namafilebaru);
//				echo "Gambar berhasil diubah";
//			} else {
//				//rename($alamat . $namafile1, $alamat.'image0.jpg');
//				echo "Gambar siap";
//			}

			echo "Gambar OK";

			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			echo $this->upload->display_errors();
		}
	}

	public function updatesoal($linklist)
	{
		$tekssoal = $this->input->post('textsoal');
		$teksopsia = $this->input->post('textopsia');
		$teksopsib = $this->input->post('textopsib');
		$teksopsic = $this->input->post('textopsic');
		$teksopsid = $this->input->post('textopsid');
		$teksopsie = $this->input->post('textopsie');
		$idsoal = $this->input->post('idsoal');
		$kuncisoal = $this->input->post('kuncisoal');

		$adagbsoal = $this->input->post('adagbsoal');
		$adagbopsia = $this->input->post('adagbopsia');
		$adagbopsib = $this->input->post('adagbopsib');
		$adagbopsic = $this->input->post('adagbopsic');
		$adagbopsid = $this->input->post('adagbopsid');
		$adagbopsie = $this->input->post('adagbopsie');


		$data = array();
		$data['soaltxt'] = $tekssoal;
		$data['opsiatxt'] = $teksopsia;
		$data['opsibtxt'] = $teksopsib;
		$data['opsictxt'] = $teksopsic;
		$data['opsidtxt'] = $teksopsid;
		$data['opsietxt'] = $teksopsie;
		$data['kunci'] = $kuncisoal;

		if ($adagbsoal == "kosong")
			$data['soalgbr'] = "";
		if ($adagbopsia == "kosong")
			$data['opsiagbr'] = "";
		if ($adagbopsib == "kosong")
			$data['opsibgbr'] = "";
		if ($adagbopsic == "kosong")
			$data['opsicgbr'] = "";
		if ($adagbopsid == "kosong")
			$data['opsidgbr'] = "";
		if ($adagbopsie == "kosong")
			$data['opsiegbr'] = "";

		$this->M_bimbel->updatesoal($data, $idsoal);
		redirect('bimbel/soal/buat/' . $linklist);
	}

	public function insertsoal($linklist)
	{
		$paket = $this->M_bimbel->getPaket($linklist);
		$id_paket = $paket[0]->id;
		$idbaru = $this->M_bimbel->insertsoal($id_paket);
		if ($idbaru > 0)
			echo $idbaru;
		else
			echo "gagal";
	}

	public function delsoal()
	{
		$id = $this->input->post('id_soal');
//		if (pemilik)
		{
			if ($this->M_bimbel->delsoal($id))
				echo "berhasil";
			else
				echo "gagal";
		}
	}

	public function updateseting($linklist)
	{
		$soalkeluar = $this->input->post('ntampil');
		$urutsoal = $this->input->post('soalacak');
		$statussoal = $this->input->post('statussoal');

//		if (pemilik)
		{
			$data = array();
			$data['soalkeluar'] = $soalkeluar;
			$data['acaksoal'] = $urutsoal;
			$data['statussoal'] = $statussoal;

			if ($this->M_bimbel->updateseting($data, $linklist))
				redirect('bimbel/soal/buat/' . $linklist);
			else
				echo "gagal";
		}
	}

	public function updatenilai()
	{
		$nilaiakhir = $this->input->post('nilaiakhir');
		$linklist = $this->input->post('linklist');
		$iduser = $this->session->userdata('id_user');
		if ($this->session->userdata('loggedIn')) {
			$nilaiuser = $this->M_bimbel->ceknilai($linklist, $iduser);
			$highscore = $nilaiuser->highscore;
			if ($nilaiakhir > $highscore)
				$data['highscore'] = $nilaiakhir;
			$data['score'] = $nilaiakhir;
			$data['linklist'] = $linklist;
			$data['iduser'] = $iduser;
			$update = $this->M_bimbel->updatenilai($data, $linklist, $iduser);
			if ($update)
				echo "berhasil";
			else
				echo "gagal";
		}
	}

	public function updatemateri($linklist)
	{
		$tekssoal = $this->input->post('isimateri');
		$data = array();
		$data['uraianmateri'] = $tekssoal;
		if ($this->M_bimbel->updatemateri($data, $linklist))
			echo "sukses";
		else
			echo "gagal";

	}

	public function updatetugas($linklist)
	{
		$tekssoal = $this->input->post('isimateri');
		$data = array();
		$data['tanyatxt'] = $tekssoal;
		if ($this->M_bimbel->updatetugas($data, 3, $linklist))
		{
			$data2 = array();
			if ($tekssoal!="")
			{
				$data2['statustugas'] = 1;
				if ($this->M_bimbel->updatemateri($data2, $linklist))
					echo "sukses";
				else
					echo "gagal";
			} else
			{
				$data2['statustugas'] = 0;
				if ($this->M_bimbel->updatemateri($data2, $linklist))
					echo "sukses";
				else
					echo "gagal";
			}

		}
		else
			echo "gagal";

	}

	public function updatetugasjawab()
	{
		$tekssoal = $this->input->post('isimateri');
		$id_tugas = $this->input->post('idtgs');
		$iduser = $this->session->userdata('id_user');
		$data = array();
		$data['jawabantxt'] = $tekssoal;
		$this->load->model('M_vksekolah');
		if ($this->M_vksekolah->updatetugasjawab($data, $id_tugas, $iduser)) {
			echo "sukses";
		} else {
			echo "gagal";
		}
	}

	public function updatetugasnilai()
	{
		$nilai = $this->input->post('nilai');
		$keterangan = $this->input->post('keterangan');
		$id_tugas = $this->input->post('idtgs');
		$iduser = $this->input->post('iduser');
		$data = array();
		$data['nilai'] = $nilai;
		$data['keterangan'] = $keterangan;
		$tgl_sekarang = new DateTime();
		$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$data['tgl_menilai'] = $tgl_sekarang->format("Y-m-d H-i:s");

		$this->load->model("M_channel");
		if ($this->M_channel->updatetugasnilai($data, $id_tugas, $iduser)) {
			echo "sukses";
		} else {
			echo "gagal";
		}
	}

	public function upload_dok($linklist)
	{
		if (isset($_FILES['filedok'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$config = array(
			'upload_path' => "uploads/materi/",
			'allowed_types' => "pdf",
			'overwrite' => TRUE,
			'max_size' => "204800000",
		);

		$this->load->library('upload', $config);
		if ($this->upload->do_upload("filedok")) {

			$dataupload = array('upload_data' => $this->upload->data());
			$random = rand(100, 999);
			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "m_" . $linklist . "_" . $random . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$data = array("filemateri" => $namafilebaru);
			$this->M_bimbel->updatemateri($data, $linklist);

			echo "Dokumen OK";

		} else {
			echo $this->upload->display_errors();
		}
	}

	public function upload_doktugas($linklist, $opsi = null)
	{
		if ($opsi == null)
			$opsi = "";
		else
			$opsi = "sw";

		if (isset($_FILES['filedok'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$config = array(
			'upload_path' => "uploads/tugas/",
			'allowed_types' => "pdf",
			'overwrite' => TRUE,
			'max_size' => "204800000",
		);

		$this->load->library('upload', $config);
		if ($this->upload->do_upload("filedok")) {

			$dataupload = array('upload_data' => $this->upload->data());
			$random = rand(100, 999);
			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "t3" . $opsi . "_" . $linklist . "_" . $random . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			if ($this->session->userdata('bimbel') == 1) {
				$data = array("tanyafile" => $namafilebaru);
				$this->M_bimbel->updatetugas($data, 3, $linklist);
			} else {
				$data = array("jawabanfile" => $namafilebaru);
				if ($opsi == "sw") {
					$iduser = $this->session->userdata('id_user');
					$idtgs = $this->input->post('idtgs');
					$this->M_bimbel->updatetugasjawab($data, $idtgs, $iduser);
				}
			}

			echo "Dokumen OK";

		} else {
			echo $this->upload->display_errors();
		}
	}

	public function kosonginfilemateri()
	{
		$linklist = $this->input->post('linklist');
		$data = array("filemateri" => "");
		$this->M_bimbel->updatemateri($data, $linklist);
		echo "sukses";
	}

	public function kosonginfiletugas()
	{
		$linklist = $this->input->post('linklist');
		$data = array("tanyafile" => "");
		$this->M_bimbel->updatetugas($data, 3, $linklist);
		echo "sukses";
	}

	public function download($bentuk, $linklist, $idsiswa = null)
	{
		if ($bentuk == "materi") {
			$paket = $this->M_bimbel->getPaket($linklist);
			force_download('uploads/' . $bentuk . '/' . $paket[0]->filemateri, null);
		} else if ($bentuk == "tugas") {
			$paket = $this->M_bimbel->getTugas($linklist);
			force_download('uploads/' . $bentuk . '/' . $paket->tanyafile, null);
		} else if ($bentuk == "jawabansaya") {
			$paket = $this->M_bimbel->getTugas($linklist);
			$idsaya = $this->session->userdata('id_user');
			$paketsiswa = $this->M_bimbel->getTugasSiswa($paket->id_tugas, $idsaya);
			force_download('uploads/tugas/' . $paketsiswa->jawabanfile, null);
		} else if ($bentuk == "jawabansiswa") {
			$paket = $this->M_bimbel->getTugas($linklist);
			$paketsiswa = $this->M_bimbel->getTugasSiswa($paket->id_tugas, $idsiswa);
			force_download('uploads/tugas/' . $paketsiswa->jawabanfile, null);
		}
	}

	public function masuk_keranjang()
	{
		$opsi = $this->input->post('opsi');
		$linklist = $this->input->post('linklist');
		$jenis = $this->input->post('jenis');
		$kodebeli = $this->input->post('kodebeli');
		$data = array("id_user" => $this->session->userdata('id_user'),
			"jenis_paket" => $jenis,
			"kode_beli" => $kodebeli,
			"link_list" => $linklist);
		if ($opsi == 1) {
			$this->M_bimbel->addkeranjang($data);
		} else {
			$this->M_bimbel->delkeranjang($data);
		}
		echo "sukses";
	}

	public function konfirmpilihan()
	{
		$data = array();

		$tglbatas = new DateTime("2020-01-01 00:00:00");

		if ($this->session->userdata('loggedIn')) {
			$id_user = $this->session->userdata("id_user");
			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, 3);
			if ($cekbeli)
				$tglbatas = new DateTime($cekbeli->tgl_batas);
		} else {
			$id_user = 0;
		}

		$tgl_sekarang = new DateTime();
		$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		if ($tgl_sekarang > $tglbatas) {
			$expired = true;
			$kodebeli = "expired";
		} else {
			$kodebeli = $cekbeli->kode_beli;
			$datakeranjang = $this->M_bimbel->getkeranjang($id_user, $kodebeli);

			$a = 0;
			foreach ($datakeranjang as $datane) {
				$a++;
				$data[$a]['id_user'] = $id_user;
				$data[$a]['jenis_paket'] = 3;
				$data[$a]['kode_beli'] = $kodebeli;
				$data[$a]['link_paket'] = $datane->link_list;
			}

			if ($this->M_bimbel->insertvk($id_user, $data))
				echo "sukses";
			else
				echo "gagal";
		}
	}


	public function pilih_paket()
	{
		$this->load->model('M_bimbel');
		$data = array('title' => 'Pilih Paket', 'menuaktif' => '',
			'isi' => 'v_bimbel_belipaket');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		$data['harga'] = $this->M_bimbel->gethargapaket("bimbel");

		$this->load->view('layout/wrapperpayment', $data);
	}

}
