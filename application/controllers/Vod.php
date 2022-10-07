<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vod extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_vod');
		$this->load->helper(array('Form', 'Cookie', 'String', 'captcha'));

		$this->load->library('pagination');

	}

	public function index()
	{
		setcookie('acara', null, -1, '/');
		unset($_COOKIE['acara']); 
		setcookie('basis', "vod", time() + (86400), '/');

		if (get_cookie('basis') != "vod") {
			$pertama = true;
			//echo "TRUE";
		} else {
			$pertama = false;
			//echo "FALSE";
		}

		if ($this->is_connected()) {
			if ($this->session->userdata('loggedIn')) {
				if ($this->session->userdata('sebagai') == 0 &&
					!$this->session->userdata('a01')) {
					redirect('/login/sebagai');
				} else if ($this->session->userdata('gender') == null) {
					$this->daftar_vod();
					// redirect('/login/profile');
				} else
					if ($pertama) {
						if ($this->session->userdata('sebagai') != 4)
							$idjenjang = $this->session->userdata('id_jenjang');
						else
							$idjenjang = 0;

//						echo "IDJENJANG:".$idjenjang."<br>";

						if ($this->session->userdata('sebagai') == 4 || $idjenjang == 0)
							{
								$this->daftar_vod();
							}
						else
							{
								$this->menujujenjang();
							}
					} else {
						$this->daftar_vod();
					}
			} else {
//                echo "D2";
//                die();
				$this->daftar_vod();
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

	public function daftar_vod()
	{

		delete_cookie("cookie_vod");
		delete_cookie("cookie_jempol");
		$data = array('konten' => 'v_vodall');

		$data['dafvideo0'] = $this->M_vod->getVODAll(6);
		$data['dafvideo1'] = $this->M_vod->getVODAll(4);
		$data['dafvideo2'] = $this->M_vod->getVODAll(5);
		$data['dafvideo3'] = $this->M_vod->getVODAll(3);
		$data['dafvideo4'] = $this->M_vod->getVODAll(2);
		$data['dafvideo5'] = $this->M_vod->getVODAll(1);

		$data['dafvideo6'] = $this->M_vod->getVODKategori();

		$data['dafjenjang'] = $this->M_vod->getJenjangAll();
		$data['dafkategori'] = $this->M_vod->getKategoriAll();
		$data['mapel'] = "";
		$data['jenjang'] = 0;
		$data['kategori'] = 0;
		$data['kuncine'] = "";
		$data['message'] = $this->session->flashdata('message');


		$this->load->view('layout/wrapper_umum', $data);

	}

	public function menujujenjang()
	{
		$nmjenjang = array("", "PAUD", "SD", "SMP", "SMA", "SMK", "PT", "PKBM", "PPS", "Lain", "SD", "SMP", "SMP", "SMP", "SMA", "SMA",
			"SMA", "kursus", "PKBM", "pondok", "PT");
		$idjenjang = $this->session->userdata('id_jenjang');
//        echo "DX<br>DX<br>DX<br>DX:::<br>".$nmjenjang[$idjenjang];
//        die();
		redirect(base_url() . 'vod/mapel/' . $nmjenjang[$idjenjang]);
	}

	public function tes2()
	{
		$data = array('title' => 'Daftar VOD', 'menuaktif' => '3',
			'isi' => 'v_vodpalsu');


		$data['meta_title'] = "Indahnya Masa Kecilku";
		$data['meta_description'] = "Indahnya Masa Kecilku";
		$data['meta_images'] = "https://tutormedia<?php echo base_url(); ?>uploads/thumbs/agnFMC5O054.jpg";
		$data['meta_url'] = "https://tutormedia.net<?php echo base_url(); ?>watch/play/125d0a7cf6ec";

		$this->load->view('layout/wrapper4', $data);

	}

	public function daftarmapel()
	{
		$namapendek = $_GET['namapendek'];
		$isi = $this->M_vod->dafMapel($namapendek);
		echo json_encode($isi);
	}

	public function mapel($jenjangpendek = null, $idmapel = null, $kunci0 = null, $kunci1 = null)
	{
		$data = array();
		$data['konten'] = "v_vod";

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
			redirect( "/vod");
		} else
			if ($jenjangpendek == "carikategori") {
				redirect("/vod/kategori/pilih");
			}


		//////////////////////// buat hitung data
		if ($kunci0 == "cari") {
			$hitungdata = $this->M_vod->getVODCari($jenjangpendek, $idmapel, $kunci1);
		} else if ($idmapel == "cari") {
			$hitungdata = $this->M_vod->getVODCari($jenjangpendek, 0, $kunci0);
		} else if ($idmapel > 0 && $kunci0 == null) {
			$hitungdata = $this->M_vod->getVODMapel($jenjangpendek, $idmapel);
		} else if ($idmapel == 0 && $kunci0 > 0) {
			$hitungdata = $this->M_vod->getVODMapel($jenjangpendek, $idmapel);
		} else {
			$hitungdata = $this->M_vod->getVODMapel($jenjangpendek, $idmapel);
		}

//		echo "<pre>";
//		echo var_dump($hitungdata);
//		echo "</pre>";
//		die();
		if (count($hitungdata)==0)
			redirect( "/vod");

		$config['base_url'] = site_url('vod/'); //site url
		$config['total_rows'] = count($hitungdata);

//        echo  $config['total_rows'];
//        die();

		$config['per_page'] = 8;  //show record per halaman
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
		if (base_url()=="http://localhost/fordorum/")
		{
			$tambahseg = 0;
		}


		if ($idmapel == "0") {
			$data['page'] = ($this->uri->segment(5+$tambahseg)) ? $this->uri->segment(5+$tambahseg) : 0;
			// echo "<br><br><br><br>MAPEK".$data['page'];
			//die();
		} else if ($idmapel > 0) {
			if ($kunci0 == "cari") {
				$data['page'] = ($this->uri->segment(7+$tambahseg)) ? $this->uri->segment(7+$tambahseg) :0;
			}
			else
			{
				$data['page'] = ($this->uri->segment(5+$tambahseg)) ? $this->uri->segment(5+$tambahseg) : 0;
			}
		} else if ($idmapel == "cari") {
			$data['page'] = ($this->uri->segment(6+$tambahseg)) ? $this->uri->segment(6+$tambahseg) : 0;
			// echo "<br><br><br><br>MAPEK".$data['page'];
			//die();
		} else if($kunci1!=null) {
			$data['page'] = ($this->uri->segment(7+$tambahseg)) ? $this->uri->segment(7+$tambahseg) : 0;
			//echo "<br><br><br><br>MAPEOK".$data['page'];
			//die();
		} else	{
			$data['page'] = ($this->uri->segment(6+$tambahseg)) ? $this->uri->segment(6+$tambahseg) : 0;
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
			$jenjang = $this->M_vod->cekJenjangPendek($jenjangpendek);
			$data['jenjang'] = $jenjang[0]->id;
			$data['dafvideo'] = $this->M_vod->getVODCari($jenjangpendek, $idmapel, $kunci1, $config["per_page"], $data['page']);
			$data['kuncine'] = $kunci1;
		} else if ($idmapel == "cari") {
			//echo "q2";
			$jenjang = $this->M_vod->cekJenjangPendek($jenjangpendek);
			$data['kuncine'] = $kunci0;
			$data['jenjang'] = $jenjang[0]->id;
			$data['dafvideo'] = $this->M_vod->getVODCari($jenjangpendek, 0, $kunci0, $config["per_page"], $data['page']);
		} else if ($idmapel > 0 && $kunci0 == null) {
			//echo("q3");

			$jenjang = $this->M_vod->cekJenjangMapel($idmapel);
			$data['jenjang'] = $jenjang[0]->id_jenjang;
			$data['mapel'] = $idmapel;
			$data['kuncine'] = $kunci1;
			$data['dafvideo'] = $this->M_vod->getVODMapel($jenjangpendek, $idmapel, $config["per_page"], $data['page']);
		} else if ($idmapel >= 0) {

			//echo("q4");
			$data['kuncine'] = "";
			$data['mapel'] = $idmapel;
			$jenjang = $this->M_vod->cekJenjangPendek($jenjangpendek);
			$data['jenjang'] = $jenjang[0]->id;
			//echo ("JP".$jenjangpendek);
			$data['dafvideo'] = $this->M_vod->getVODMapel($jenjangpendek, $idmapel, $config["per_page"], $data['page']);

		} else if ($idmapel == null && $jenjangpendek != null) {

			//echo("q4");
			$data['kuncine'] = "";
			$idmapel = 0;
			$jenjang = $this->M_vod->cekJenjangPendek($jenjangpendek);
			$data['jenjang'] = $jenjang[0]->id;
			//echo ("JP".$jenjangpendek);
			$data['dafvideo'] = $this->M_vod->getVODMapel($jenjangpendek, $idmapel, $config["per_page"], $data['page']);

		}


		$data['mapel'] = $idmapel;

		$data['asal'] = "mapel";
		if ($kunci0 == "cari")
			$data['asal'] = "mapelcari";
		$data['jenjangpendek'] = $jenjangpendek;

		$data['kategori'] = 0;
		$data['dafjenjang'] = $this->M_vod->getJenjangAll();
		$data['dafmapel'] = $this->M_vod->dafMapel($jenjangpendek);

		$data['dafkategori'] = $this->M_vod->getKategoriAll();
		$data['message'] = $this->session->flashdata('message');
		$data['total_data'] = $config['total_rows'];


		$this->load->view('layout/wrapper_umum', $data);
	}

	public function kategori($idkategori = null, $cari = null, $kunci = null, $cari2 = null)
	{
		if ($idkategori == null) {
			redirect("/vod");
		} else if ($idkategori == "pilih") {
			$idkategori = "99";
		}

		$kunci = preg_replace('!\s+!', ' ', $kunci);
		$kunci = str_replace("%20%20", "%20", $kunci);
		$kunci = str_replace("%20", " ", $kunci);

		$data = array();
		$data['konten'] = "v_vod";

		//////////////////////// buat hitung data
		///
		if ($cari == "cari") {
			if ($idkategori=="99")
			{
				redirect("/vod/cari/".$cari);
			}
			else {
				$config['base_url'] = site_url(base_url() . 'kategori/' . $idkategori . '/cari/' . $kunci); //site url
				$hitungdata = $this->M_vod->getVODCari('kategori', $idkategori, $kunci);
			}
		} else if ($kunci == "cari") {
			$config['base_url'] = site_url(base_url().'kategori/' . $idkategori . '/cari/' . $kunci); //site url
			$hitungdata = $this->M_vod->getVODCari('kategori', $idkategori, $kunci);
		} else {
			$config['base_url'] = site_url(base_url().'kategori/' . $idkategori); //site url
			$hitungdata = $this->M_vod->getVODKategori($idkategori);
		}


		$config['total_rows'] = count($hitungdata);

		$config['per_page'] = 8;  //show record per halaman
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
		if (base_url()=="http://localhost/fordorum/")
		{
			$tambahseg = 0;
		}

		if ($cari=="cari")
			$data['page'] = ($this->uri->segment(6+$tambahseg)) ? $this->uri->segment(6+$tambahseg) : 0;
		else
			$data['page'] = ($this->uri->segment(4+$tambahseg)) ? $this->uri->segment(4+$tambahseg) : 0;


		if ($data['page'] >= 1)
			$data['page'] = ($data['page'] - 1) * $config['per_page'];

//		echo ($this->uri->segment(6));
//		die();

		$data['pagination'] = $this->pagination->create_links();


		if ($cari == "cari") {
			$data['dafvideo'] = $this->M_vod->getVODCari('kategori', $idkategori, $kunci, $config["per_page"], $data['page']);
			$data['kuncine'] = $kunci;
		} else if ($kunci == "cari") {
			$data['dafvideo'] = $this->M_vod->getVODCari('kategori', $idkategori, $cari2, $config["per_page"], $data['page']);
			$data['kuncine'] = $cari2;
		} else {
			$data['dafvideo'] = $this->M_vod->getVODKategori($idkategori, $config["per_page"], $data['page']);
			$data['kuncine'] = '';
		}

		if ($cari=="cari")
			$data['asal'] = "kategoricari";
		else
			$data['asal'] = "kategori";
		$data['dafjenjang'] = $this->M_vod->getJenjangAll();
		$data['dafkategori'] = $this->M_vod->getKategoriAll();
		$data['mapel'] = "";
		$data['jenjang'] = 0;
		$data['jenjangpendek']="";
		$data['kategori'] = $idkategori;
		$data['total_data'] = $config['total_rows'];

		$this->load->view('layout/wrapper_umum', $data);

	}

	public function cari($tekskunci = null, $hal=null)
	{
		delete_cookie("cookie_vod");
		delete_cookie("cookie_jempol");
		$data = array();
		$data['konten'] = "v_vod";

		$kunci = htmlspecialchars($tekskunci);
		$data['message'] = "";

		if ($kunci == "") {
			$this->index();
		} else {
			$kunci = preg_replace('!\s+!', ' ', $kunci);
			$kunci = str_replace("%20%20", "%20", $kunci);
			$kunci = str_replace("%20", " ", $kunci);
			//$kunci = str_replace("dan","",$kunci);

			$hitungdata = $data['dafvideo'] = $this->M_vod->getVODCari(0, 0, $kunci);

			$config['total_rows'] = count($hitungdata);

//			echo  $config['total_rows'];
//			die();

			$config['per_page'] = 8;  //show record per halaman
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
			if (base_url()=="http://localhost/fordorum/")
			{
				$tambahseg = 0;
			}

			$data['page'] = ($this->uri->segment(4+$tambahseg)) ? $this->uri->segment(4+$tambahseg) : 0;


			if ($data['page'] >= 1)
				$data['page'] = ($data['page'] - 1) * $config['per_page'];

			$data['pagination'] = $this->pagination->create_links();
			$data['dafvideo'] = $this->M_vod->getVODCari(0, 0, $kunci,$config["per_page"], $data['page']);

			$data['dafjenjang'] = $this->M_vod->getJenjangAll();
			$data['dafkategori'] = $this->M_vod->getKategoriAll();
			$data['mapel'] = "";
			$data['kuncine'] = $kunci;
			$data['jenjangpendek'] = "";
			$data['jenjang'] = 0;
			$data['kategori'] = 0;
			$data['asal'] = "cari";
			$data['total_data'] = $config['total_rows'];

			$this->load->view('layout/wrapper_umum', $data);

		}
	}

	// public function get_autocomplete()
	// {
	// 	if (isset($_GET['kunci'])) {
	// 		$result = $this->M_vod->search_VOD($_GET['jenjang'], $_GET['mapel'], $_GET['kunci'], $_GET['asal']);
	// 		if (count($result) > 0) {
	// 			foreach ($result as $row)
	// 				$arr_result[] = array(
	// 					"value" => $row->judul,
	// 					"deskripsi" => $row->deskripsi
	// 				);
	// 			echo json_encode($arr_result);
	// 		}
	// 	}
	// }

}
