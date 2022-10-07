<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vksekolah extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_induk');
		$this->load->model('M_vksekolah');
		$this->load->helper(array('Form', 'Cookie', 'String', 'captcha', 'download'));
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->library('pagination');
		if (!$this->session->userdata('loggedIn')) {
			redirect("/informasi/infobimbel");
		}
	}

	public function index()
	{
		if ($this->is_connected()) {
			redirect("/vksekolah/set/");
		} else {
			echo "SAMBUNGAN INTERNET TIDAK TERSEDIA";
		}
	}

	public function is_connected($sCheckHost = 'www.google.com')
	{
		return (bool)@fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
	}

	public function set($npsn = null, $hal = null)
	{
		if ($npsn == null)
			$npsn = "saya";
		if ($hal == null || $hal == 0)
			$hal = 1;
		$this->get_vksekolah($npsn, "hal", $hal);
	}

	public function lain()
	{
		$this->load->model('M_channel');
		$infosekolah = $this->M_channel->getInfoSekolah($this->session->userdata('npsn'));
		$idjenjangku = $infosekolah[0]->idjenjang;
		$namajenjang = $this->M_channel->getNamaJenjang($idjenjangku);
		redirect("/vksekolah/mapel/lain/".$namajenjang->nama_pendek);
	}

	public function get_vksekolah($npsn = null, $linklist = null, $iduser = null, $hal2 = null)
	{

		if ($npsn == null)
			redirect("/");

		if ($this->session->userdata('loggedIn')) {
			$id_user = $this->session->userdata("id_user");

			$tunggubayar = false;

			if ($npsn == "saya" || $npsn == $this->session->userdata('npsn')) {
				$npsn == $this->session->userdata('npsn');
				$jenis = 1;
			} else
				$jenis = 2;
			$strstrata = array("0", "lite", "pro", "premium");
			$tglbatas = new DateTime("2020-01-01 00:00:00");
			$kodebeliakhir = "";

			$kodebeli = "belumpunya";
			$tstrata = "0";
			$expired = true;

			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $jenis);

			if ($cekbeli) {

				$statusbayar = $cekbeli->status_beli;

//				$url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
//				$fgc = @file_get_contents($url);
//				if ($fgc === FALSE) {
////					$datesekarang = new DateTime();
////					$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
//				} else {
//					$obj = json_decode($fgc, true);
//					$datesekarang = new DateTime(substr($obj['datetime'], 0, 19));
//				}

				$datesekarang = new DateTime();
				$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

				$tanggalorder = new DateTime($cekbeli->tgl_beli);
				$batasorder = new DateTime($cekbeli->tgl_beli);
				$tglbatas = new DateTime($cekbeli->tgl_batas);

				$bulanorder = $tanggalorder->format('m');
				$tahunorder = $tanggalorder->format('Y');

				$tanggal = $datesekarang->format('d');
				$bulan = $datesekarang->format('m');
				$tahun = $datesekarang->format('Y');

				$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

//				echo "<br><br><br><br><br><br><br><br><br><br>SELISIH:".$selisih;
//				die();

				if ($statusbayar == 2) {
					if ($datesekarang <= $tglbatas) {
						$tstrata = $strstrata[$cekbeli->strata_paket];
						$kodebeli = $cekbeli->kode_beli;
						$expired = false;
					} else {
						$datax = array("status_beli" => 0);
						$this->M_vksekolah->update_vk_beli($datax, $id_user, $cekbeli->kode_beli);
					}
				} else {
					if ($statusbayar == 1) {
						$ceksebelumnya = $this->M_channel->getlast_kdbeli($id_user, $jenis, 2);
						if ($ceksebelumnya) {
							$statusbayarsebelumnya = $ceksebelumnya->status_beli;
							if ($statusbayarsebelumnya == 2) {
								$tglbatassebelum = new DateTime($ceksebelumnya->tgl_batas);
								if ($datesekarang <= $tglbatas) {
									$tstrata = $strstrata[$ceksebelumnya->strata_paket];
									$kodebeliakhir = $ceksebelumnya->kode_beli;
									$expired = false;
								} else {
									$datax = array("status_beli" => 0);
									$this->M_vksekolah->update_vk_beli($datax, $id_user, $cekbeli->kode_beli);
								}
							}
						}
						$batasorder = $batasorder->add(new DateInterval('P1D'));
						if ($datesekarang > $batasorder) {
							$datax = array("status_beli" => 0);
							$this->M_vksekolah->update_vk_beli($datax, $id_user, $cekbeli->kode_beli);
						} else {
							$tunggubayar = true;
						}
					}
				}
			} else {
				$cekpremiumsekolah = $this->cekpembayaransekolah($this->session->userdata('npsn'));
				if (substr($cekpremiumsekolah,0,2)=="TP")
					{
						$statuspremiumsekolah = "pro";
						//echo "Premium";
					}
				else if (substr($cekpremiumsekolah,0,2)=="TF")
					{
						$statuspremiumsekolah = "premium";
						//echo "Full Premium";
					}
				else
				$kodebeli = "belumpunya";
				$tstrata = "0";
				$expired = true;
			}
		} else {
			redirect("/");
		}

//		echo "003";
//		die();


		$this->load->Model('M_vksekolah');
		$dafplaylistall = $this->M_vksekolah->getDafPlayListSekolah($npsn, $id_user, $kodebeli);
		$jmlaktif = 0;
		$jmlkeranjang = 0;
		foreach ($dafplaylistall as $datane) {
			if ($datane->link_paket != null)
				$jmlaktif++;
			if ($datane->dikeranjang == 1)
				$jmlkeranjang++;
		}

		if ($iduser == "0")
			redirect("/vksekolah/set/");

		if ($linklist == "hal") {
			$data = array();
			$data['konten'] = "v_vksekolahall";

			$data['dafjenjang'] = $this->M_vksekolah->getJenjangSekolah();
			$data['dafkelas'] = $this->M_vksekolah->getKelasSekolah();
			$data['dafkategori'] = $this->M_vksekolah->getKategoriAll();
			$data['mapel'] = "";
			$data['asal'] = "";
			$data['npsn'] = $npsn;
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
			$data['kodebeliakhir'] = $kodebeliakhir;
			if ($kodebeliakhir != "")
				$kodebeli = $kodebeliakhir;
			$data['totalaktif'] = $jmlaktif;
			$data['totalkeranjang'] = $jmlkeranjang;
			$data['tunggubayar'] = $tunggubayar;

			$this->session->set_userdata('asalpaket', 'sekolahsaya');

			$hargapaket = $this->M_vksekolah->gethargapaket($npsn);
			if (!$hargapaket)
				$hargapaket = $this->M_vksekolah->gethargapaket("standar");

			if ($tstrata == "0")
				$data['totalmaksimalpilih'] = 0;
			else
				$data['totalmaksimalpilih'] = $hargapaket["njudul_" . $tstrata];

			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			if ($iduser == "cari") {
				$hitungdata = sizeof($this->M_vksekolah->getSekolahCari($npsn, 0, 0, $hal2));
			} else {
				$hitungdata = sizeof($dafplaylistall);
			}

			$config['base_url'] = site_url('vksekolah/'); //site url
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
			$data = array();
			$data['konten'] = "v_vksekolah_pilih";
			$paketsoal = $this->M_vksekolah->getPaket($linklist);

			$npsn_sekolah = $paketsoal[0]->npsn;
//			if (!$this->session->userdata("a01"))
//				$this->cekstatussekolah($npsn_sekolah);

			if ($paketsoal) {

				$tugasguru = $this->M_vksekolah->getTugas($jenis, $linklist);
				$data['tugasguru'] = $tugasguru;
				if ($tugasguru)
					$idtugasguru = $tugasguru->id_tugas;
				else
					$idtugasguru = 0;

				$tugassiswa = $this->M_vksekolah->getTugasSiswa($idtugasguru, $id_user);

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
						$this->M_vksekolah->addTugasSiswa($isi);
						$tugassiswa = $this->M_vksekolah->getTugasSiswa($idtugasguru, $id_user);
					}
				}
				$data['tugassiswa'] = $tugassiswa;

				//			echo "<br><br><br><br><br><br>";
//			echo "IDGURU".$idtugasguru;
//			echo "<pre>";
//			echo var_dump($tugassiswa);
//			echo "</pre>";

				$data['statussoal'] = $paketsoal[0]->statussoal;
				$data['pengunggah'] = $paketsoal[0]->first_name . " " . $paketsoal[0]->last_name;

				$nilaiuser = $this->M_vksekolah->ceknilai($linklist, $id_user);
				$data['nilaiuser'] = $nilaiuser;
				$data['uraianmateri'] = $paketsoal[0]->uraianmateri;
				$data['filemateri'] = $paketsoal[0]->filemateri;

				$data['asal'] = "menu";
				$data['npsn'] = $npsn;
				$data['ambilpaket'] = $tstrata;
				$data['jenis'] = $jenis;

				$data['expired'] = $expired;
				if ($expired)
					$data['kodebeli'] = "expired";
				else
					$data['kodebeli'] = $cekbeli->kode_beli;
				$data['kodebeliakhir'] = $kodebeliakhir;
				$data['tunggubayar'] = $tunggubayar;
				if ($kodebeliakhir != "")
					$kodebeli = $kodebeliakhir;
				$data['totalaktif'] = $jmlaktif;
				$data['totalkeranjang'] = $jmlkeranjang;

				$hargapaket = $this->M_vksekolah->gethargapaket($npsn);
				if (!$hargapaket)
					$hargapaket = $this->M_vksekolah->gethargapaket("standar");

				if ($tstrata == "0")
					$data['totalmaksimalpilih'] = 0;
				else
					$data['totalmaksimalpilih'] = $hargapaket["njudul_" . $tstrata];

				$data['datapesan'] = $this->M_channel->getChat($jenis, $npsn);
				$data['idku'] = $this->session->userdata('id_user');
				$data['linklist'] = $linklist;
				if ($jenis == 1)
					$data['namasekolah'] = "Topik " . $paketsoal[0]->nama_paket . "";
				else
					$data['namasekolah'] = "Topik [" . $paketsoal[0]->nama_paket . "]";

				$getpaket = $this->M_channel->getInfoBeliPaket($id_user, $jenis, $linklist);
				if ($getpaket) {
					$idkontributor = $getpaket->id_kontri;
					$iduserbeli = $getpaket->id_user;
					$batasaktif = $getpaket->tgl_batas;
					$data['adavicon'] = "ada";
					//echo "KONTRI:".$idkontributor.", YGBELI:".$iduserbeli." , BATAS:".$batasaktif;
				}
				else
					$data['adavicon'] = "tidak";


			} else {
				redirect("/");
			}
		}


		if ($iduser == "cari") {
			$data['kuncine'] = $hal2;
			$data['dafplaylist'] = $this->M_vksekolah->getSekolahCari($npsn, 0, 0, $hal2);
		} else {
			if ($linklist == "hal") {
				$data['dafplaylist'] = $this->M_vksekolah->getDafPlayListSekolahAll($npsn, null, $iduser, $kodebeli, $id_user);
			} else {
				$data['dafplaylist'] = $this->M_vksekolah->getDafPlayListSekolahAll($npsn, $linklist, "semua", $kodebeli, $id_user);
			}
		}

//		echo "<pre>";
//		echo var_dump($data['dafplaylist']);
//		echo "</pre>";
//		die();

		if (sizeof($data['dafplaylist']) == 0)
			redirect("/");


		if ($data['dafplaylist']) {
			$data['punyalist'] = true;
			$statusakhir = $data['dafplaylist'][0]->link_list;

			if ($linklist == null) {
				$data['playlist'] = $this->M_vksekolah->getPlayListSekolah($statusakhir, $iduser);
			} else {
				$data['playlist'] = $this->M_vksekolah->getPlayListSekolah($linklist, $iduser);
			}

		} else {

			$data['punyalist'] = false;
		}


		$data['infoguru'] = $this->M_vksekolah->getInfoGuru($iduser);
//			$data['dafvideo'] = $this->M_vksekolah->getVodGuru($iduser);
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		$data['iduser'] = $iduser;
		if ($linklist == "hal")
			$linklist = null;
		$data['id_playlist'] = $linklist;
		$data['gembokorpilih'] = $this->M_vksekolah->cekpilihan($id_user, $jenis, $linklist);

		$this->load->view('layout/wrapper_umum', $data);

	}

	public function menujujenjang()
	{
		$nmjenjang = array("", "PAUD", "SD", "SMP", "SMA", "SMK", "PT", "PKBM", "PPS", "Lain", "SD", "SMP", "SMP", "SMP", "SMA", "SMA",
			"SMA", "kursus", "PKBM", "pondok", "PT");
		$idjenjang = $this->session->userdata('id_jenjang');
//        echo "DX<br>DX<br>DX<br>DX:::<br>".$nmjenjang[$idjenjang];
//        die();
		redirect(base_url() . 'vksekolah/mapel/' . $nmjenjang[$idjenjang]);
	}

	public function daftarmapel()
	{
		$namapendek = $_GET['namapendek'];
		$isi = $this->M_vksekolah->dafMapelSekolah($namapendek);
		echo json_encode($isi);
	}

	public function mapel($npsn = null, $jenjangpendek = null, $idkelas = null, $idmapel = null, $kunci0 = null, $kunci1 = null)
	{
		if ($npsn == "saya")
			$npsn = $this->session->userdata('npsn');

		$data = array();
		$data['konten'] = "v_vksekolahall";

		///////////////////////////////////////////////////////////////////////////////////////

		if ($this->session->userdata('loggedIn')) {
			$id_user = $this->session->userdata("id_user");

			$tunggubayar = false;

			if ($npsn == "saya" || $npsn == $this->session->userdata('npsn')) {
				$npsn == $this->session->userdata('npsn');
				$jenis = 1;
			} else
				$jenis = 2;
			$strstrata = array("", "lite", "pro", "premium");
			$tglbatas = new DateTime("2020-01-01 00:00:00");
			$kodebeliakhir = "";

			$kodebeli = "belumpunya";
			$tstrata = 0;
			$expired = true;

			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $jenis);

			if ($cekbeli) {

				$statusbayar = $cekbeli->status_beli;

//				$url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
//				$fgc = @file_get_contents($url);
//				if ($fgc === FALSE) {
////					$datesekarang = new DateTime();
////					$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
//				} else {
//					$obj = json_decode($fgc, true);
//					$datesekarang = new DateTime(substr($obj['datetime'], 0, 19));
//				}

				$datesekarang = new DateTime();
				$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
				//$datesekarang = new DateTime();

				$tanggalorder = new DateTime($cekbeli->tgl_beli);
				$batasorder = new DateTime($cekbeli->tgl_beli);
				$tglbatas = new DateTime($cekbeli->tgl_batas);

				$bulanorder = $tanggalorder->format('m');
				$tahunorder = $tanggalorder->format('Y');

				$tanggal = $datesekarang->format('d');
				$bulan = $datesekarang->format('m');
				$tahun = $datesekarang->format('Y');

				$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

//				echo "<br><br><br><br><br><br><br><br><br><br>SELISIH:".$selisih;
//				die();

				if ($statusbayar == 2) {
					if ($datesekarang <= $tglbatas) {
						$tstrata = $strstrata[$cekbeli->strata_paket];
						$kodebeli = $cekbeli->kode_beli;
						$expired = false;
					} else {
						$datax = array("status_beli" => 0);
						$this->M_vksekolah->update_vk_beli($datax, $id_user, $cekbeli->kode_beli);
					}
				} else {
					if ($statusbayar == 1) {
						$ceksebelumnya = $this->M_channel->getlast_kdbeli($id_user, $jenis, 2);
						$statusbayarsebelumnya = $ceksebelumnya->status_beli;
						if ($statusbayarsebelumnya == 2) {
							$tglbatassebelum = new DateTime($ceksebelumnya->tgl_batas);
							if ($datesekarang <= $tglbatas) {
								$tstrata = $strstrata[$ceksebelumnya->strata_paket];
								$kodebeliakhir = $ceksebelumnya->kode_beli;
								$expired = false;
							} else {
								$datax = array("status_beli" => 0);
								$this->M_vksekolah->update_vk_beli($datax, $id_user, $cekbeli->kode_beli);
							}
						}
						$batasorder = $batasorder->add(new DateInterval('P1D'));
						if ($datesekarang > $batasorder) {
							$datax = array("status_beli" => 0);
							$this->M_vksekolah->update_vk_beli($datax, $id_user, $cekbeli->kode_beli);
						} else {
							$tunggubayar = true;
						}
					}
				}
			} else {
				$kodebeli = "belumpunya";
				$tstrata = 0;
				$expired = true;
			}
		} else {
			redirect("/");
		}

		///////////////////////////////////////////////////////////////////////////////////////

		$this->load->Model('M_vksekolah');
		$dafplaylistall = $this->M_vksekolah->getDafPlayListSekolah($npsn, $id_user, $kodebeli);
		$jmlaktif = 0;
		$jmlkeranjang = 0;
		foreach ($dafplaylistall as $datane) {
			if ($datane->link_paket != null)
				$jmlaktif++;
			if ($datane->dikeranjang == 1)
				$jmlkeranjang++;
		}

		$data['totalaktif'] = $jmlaktif;
		$data['totalkeranjang'] = $jmlkeranjang;
		$data['expired'] = $expired;
		if ($expired)
			$data['kodebeli'] = "expired";
		else
			$data['kodebeli'] = $cekbeli->kode_beli;
		$data['kodebeliakhir'] = $kodebeliakhir;
		$data['tunggubayar'] = $tunggubayar;
		if ($kodebeliakhir != "")
			$kodebeli = $kodebeliakhir;
		$data['tglbatas'] = $tglbatas->format("d-m-Y");

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
			redirect("/vksekolah");
		} else
			if ($jenjangpendek == "carikategori") {
				redirect("/vksekolah/kategori/pilih");
			}


		//////////////////////// buat hitung data
		if ($kunci0 == "cari") {
			$hitungdata = $this->M_vksekolah->getSekolahCari($npsn, $jenjangpendek, $idmapel, $kunci1);
		} else if ($idmapel == "cari") {
			$hitungdata = $this->M_vksekolah->getSekolahCari($npsn, $jenjangpendek, 0, $kunci0);
		} else if ($idmapel > 0 && $kunci0 == null) {
			$hitungdata = $this->M_vksekolah->getSekolahMapel($npsn, $jenjangpendek, $idmapel);
		} else if ($idmapel == 0 && $kunci0 > 0) {
			$hitungdata = $this->M_vksekolah->getSekolahMapel($npsn, $jenjangpendek, $idmapel);
		} else {
			$hitungdata = $this->M_vksekolah->getSekolahMapel($npsn, $jenjangpendek, $idmapel);
		}

		$config['base_url'] = site_url('vksekolah/'); //site url
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
			$jenjang = $this->M_vksekolah->cekJenjangPendek($jenjangpendek);
			if ($jenjang) {
				$data['jenjang'] = $jenjang[0]->id;
				$data['dafvideo'] = $this->M_vksekolah->getSekolahCari($npsn, $jenjangpendek, $idmapel, $kunci1, $config["per_page"], $data['page']);
				$data['kuncine'] = $kunci1;
			}
			else
			{
				redirect("/");
			}
		} else if ($idmapel == "cari") {
			//echo "q2";
			$jenjang = $this->M_vksekolah->cekJenjangPendek($jenjangpendek);
			if ($jenjang) {
				$data['kuncine'] = $kunci0;
				$data['jenjang'] = $jenjang[0]->id;
				$data['dafvideo'] = $this->M_vksekolah->getSekolahCari($npsn, $jenjangpendek, 0, $kunci0, $config["per_page"], $data['page']);
			}
			else
			{
				redirect("/");
			}
		} else if ($idmapel > 0 && $kunci0 == null) {
			//echo("q3");
			$jenjang = $this->M_vksekolah->cekJenjangMapel($idmapel);
			if ($jenjang) {
			$data['jenjang'] = $jenjang[0]->id_jenjang;
			$data['mapel'] = $idmapel;
			$data['kuncine'] = $kunci1;
			$data['dafvideo'] = $this->M_vksekolah->getSekolahMapel($npsn, $jenjangpendek, $idmapel, $config["per_page"], $data['page']);
			}
			else
			{
				redirect("/");
			}
		}
			else if ($idmapel >= 0) {

			//echo("q4");
			$data['kuncine'] = "";
			$data['mapel'] = $idmapel;
			$jenjang = $this->M_vksekolah->cekJenjangPendek($jenjangpendek);
				if ($jenjang) {
					$data['jenjang'] = $jenjang[0]->id;
					//echo ("JP".$jenjangpendek);
					$data['dafvideo'] = $this->M_vksekolah->getSekolahMapel($npsn, $jenjangpendek, $idmapel, $config["per_page"], $data['page']);
				} else
				{
					redirect("/");
				}
		} else if ($idmapel == null && $jenjangpendek != null) {

			//echo("q4");
			$data['kuncine'] = "";
			$idmapel = 0;
			$jenjang = $this->M_vksekolah->cekJenjangPendek($jenjangpendek);
				if ($jenjang) {
					$data['jenjang'] = $jenjang[0]->id;
					//echo ("JP".$jenjangpendek);
					$data['dafvideo'] = $this->M_vksekolah->getSekolahMapel($npsn, $jenjangpendek, $idmapel, $config["per_page"], $data['page']);
				}else
				{
					redirect("/");
				}
		}


		$data['mapel'] = $idmapel;

		$data['asal'] = "mapel";
		if ($kunci0 == "cari")
			$data['asal'] = "mapelcari";
		$data['jenjangpendek'] = $jenjangpendek;

		$data['kategori'] = 0;
		$data['dafjenjang'] = $this->M_vksekolah->getJenjangSekolah();
		$data['dafkelas'] = $this->M_vksekolah->getKelasSekolah();
		$data['dafmapel'] = $this->M_vksekolah->dafMapelSekolah($jenjangpendek, $idkelas);
		$data['dafkategori'] = $this->M_vksekolah->getKategoriAll();
		$data['message'] = $this->session->flashdata('message');
		$data['total_data'] = $config['total_rows'];
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		if ($jenjangpendek != null) {
			$jenjang = $this->M_vksekolah->cekJenjangPendek($jenjangpendek);
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


		$hargapaket = $this->M_vksekolah->gethargapaket($npsn);
		if (!$hargapaket)
			$hargapaket = $this->M_vksekolah->gethargapaket("standar");

		if ($tstrata == "0")
			$data['totalmaksimalpilih'] = 0;
		else
			$data['totalmaksimalpilih'] = $hargapaket["njudul_" . $tstrata];

		//$data['dafplaylist'] = $this->M_vksekolah->getDafPlayListSekolah($npsn, $id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel);

		$data['dafplaylist'] = $this->M_vksekolah->getDafPlayListSekolahRev($npsn, null, 1, $kodebeli, $id_user, $jenjang[0]->id, $idkelas, $idmapel);
//		echo "<pre>";
//		echo var_dump($data['dafplaylist']);
//		echo "</pre>";
//		die();


		if ($data['dafplaylist']) {
			$data['punyalist'] = true;
			$statusakhir = $data['dafplaylist'][0]->link_list;
//				echo "<br><br><br><br><br>SattusAkhir:".$statusakhir;
			$data['playlist'] = $this->M_vksekolah->getPlayListSekolah($statusakhir, null);
		} else {
//            $data['playlist'] = $this->M_vksekolah->getPlayListGuru($kd_user);
			$data['punyalist'] = false;
//			if (!$this->session->userdata('loggedIn')) {
//				redirect('/');
//			}
		}


		$data['infoguru'] = $this->M_vksekolah->getInfoGuru(null);
//			$data['dafvideo'] = $this->M_vksekolah->getVodGuru($iduser);
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		$data['iduser'] = null;
		$data['npsn'] = $npsn;
		$data['ambilpaket'] = $tstrata;
		$data['jenis'] = $jenis;
		$data['id_playlist'] = null;

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function kategori($npsn, $idkategori = null, $cari = null, $kunci = null, $cari2 = null)
	{
		if ($npsn == "saya")
			$npsn = $this->session->userdata('npsn');
		if ($idkategori == null) {
			redirect("/vksekolah");
		} else if ($idkategori == "pilih") {
			$idkategori = "99";
		}

		$kunci = preg_replace('!\s+!', ' ', $kunci);
		$kunci = str_replace("%20%20", "%20", $kunci);
		$kunci = str_replace("%20", " ", $kunci);

		$data = array('title' => 'PERPUSTAKAAN DIGITAL', 'menuaktif' => '3',
			'isi' => 'v_vksekolahall');

		//////////////////////// buat hitung data
		///
		if ($cari == "cari") {
			if ($idkategori == "99") {
				redirect("/vksekolah/cari/" . $cari);
			} else {
				$config['base_url'] = site_url(base_url() . 'kategori/' . $idkategori . '/cari/' . $kunci); //site url
				$hitungdata = $this->M_vksekolah->getSekolahCari($npsn, 'kategori', $idkategori, $kunci);
			}
		} else if ($kunci == "cari") {
			$config['base_url'] = site_url(base_url() . 'kategori/' . $idkategori . '/cari/' . $kunci); //site url
			$hitungdata = $this->M_vksekolah->getSekolahCari($npsn, 'kategori', $idkategori, $kunci);
		} else {
			$config['base_url'] = site_url(base_url() . 'kategori/' . $idkategori); //site url
			$hitungdata = $this->M_vksekolah->getSekolahKategori($idkategori);
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
			$data['dafvideo'] = $this->M_vksekolah->getSekolahCari($npsn, 'kategori', $idkategori, $kunci, $config["per_page"], $data['page']);
			$data['kuncine'] = $kunci;
		} else if ($kunci == "cari") {
			$data['dafvideo'] = $this->M_vksekolah->getSekolahCari($npsn, 'kategori', $idkategori, $cari2, $config["per_page"], $data['page']);
			$data['kuncine'] = $cari2;
		} else {
			$data['dafvideo'] = $this->M_vksekolah->getSekolahKategori($idkategori, $config["per_page"], $data['page']);
			$data['kuncine'] = '';
		}

		if ($cari == "cari")
			$data['asal'] = "kategoricari";
		else
			$data['asal'] = "kategori";
		$data['dafjenjang'] = $this->M_vksekolah->getJenjangSekolah();
		$data['dafkategori'] = $this->M_vksekolah->getKategoriAll();
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

	public function cari($npsn, $tekskunci = null, $hal = null)
	{
		if ($npsn == "saya")
			$npsn = $this->session->userdata('npsn');
		$data = array();
		$data['konten'] = "v_vksekolahall";

		$kunci = htmlspecialchars($tekskunci);
		$data['message'] = "";

		if ($kunci == "") {
			$this->index();
		} else {
			$kunci = preg_replace('!\s+!', ' ', $kunci);
			$kunci = str_replace("%20%20", "%20", $kunci);
			$kunci = str_replace("%20", " ", $kunci);
			//$kunci = str_replace("dan","",$kunci);

			$data['dafvideo'] = $this->M_vksekolah->getSekolahCari($npsn, 0, 0, $kunci);
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
			$data['dafvideo'] = $this->M_vksekolah->getSekolahCari($npsn, 0, 0, $kunci, $config["per_page"], $data['page']);

			$data['dafjenjang'] = $this->M_vksekolah->getJenjangSekolah();
			$data['dafkategori'] = $this->M_vksekolah->getKategoriAll();
			$data['dafkelas'] = $this->M_vksekolah->getKelasAll();
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


//			if ($npsn == "saya" || $npsn == $this->session->userdata('npsn'))
//				$jenis = 1;
//			else
//				$jenis = 2;
//
//			$strstrata = array("", "lite", "reguler", "premium");
//			$tglbatas = new DateTime("2020-01-01 00:00:00");

			///////////////////////////////////////////////////////////////////////////////////////

			if ($this->session->userdata('loggedIn')) {
				$id_user = $this->session->userdata("id_user");

				$tunggubayar = false;

				if ($npsn == "saya" || $npsn == $this->session->userdata('npsn')) {
					$npsn == $this->session->userdata('npsn');
					$jenis = 1;
				} else
					$jenis = 2;
				$strstrata = array("", "lite", "pro", "premium");
				$tglbatas = new DateTime("2020-01-01 00:00:00");
				$kodebeliakhir = "";

				$kodebeli = "belumpunya";
				$tstrata = 0;
				$expired = true;

				$this->load->Model('M_channel');
				$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $jenis);

				if ($cekbeli) {

					$statusbayar = $cekbeli->status_beli;

//					$url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
//					$fgc = @file_get_contents($url);
//					if ($fgc === FALSE) {
////					$datesekarang = new DateTime();
////					$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
//					} else {
//						$obj = json_decode($fgc, true);
//						$datesekarang = new DateTime(substr($obj['datetime'], 0, 19));
//					}

					$datesekarang = new DateTime();
					$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
					//$datesekarang = new DateTime();

					$tanggalorder = new DateTime($cekbeli->tgl_beli);
					$batasorder = new DateTime($cekbeli->tgl_beli);
					$tglbatas = new DateTime($cekbeli->tgl_batas);

					$bulanorder = $tanggalorder->format('m');
					$tahunorder = $tanggalorder->format('Y');

					$tanggal = $datesekarang->format('d');
					$bulan = $datesekarang->format('m');
					$tahun = $datesekarang->format('Y');

					$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

//				echo "<br><br><br><br><br><br><br><br><br><br>SELISIH:".$selisih;
//				die();

					if ($statusbayar == 2) {
						if ($datesekarang <= $tglbatas) {
							$tstrata = $strstrata[$cekbeli->strata_paket];
							$kodebeli = $cekbeli->kode_beli;
							$expired = false;
						} else {
							$datax = array("status_beli" => 0);
							$this->M_vksekolah->update_vk_beli($datax, $id_user, $cekbeli->kode_beli);
						}
					} else {
						if ($statusbayar == 1) {
							$ceksebelumnya = $this->M_channel->getlast_kdbeli($id_user, $jenis, 2);
							$statusbayarsebelumnya = $ceksebelumnya->status_beli;
							if ($statusbayarsebelumnya == 2) {
								$tglbatassebelum = new DateTime($ceksebelumnya->tgl_batas);
								if ($datesekarang <= $tglbatas) {
									$tstrata = $strstrata[$ceksebelumnya->strata_paket];
									$kodebeliakhir = $ceksebelumnya->kode_beli;
									$expired = false;
								} else {
									$datax = array("status_beli" => 0);
									$this->M_vksekolah->update_vk_beli($datax, $id_user, $cekbeli->kode_beli);
								}
							}
							$batasorder = $batasorder->add(new DateInterval('P1D'));
							if ($datesekarang > $batasorder) {
								$datax = array("status_beli" => 0);
								$this->M_vksekolah->update_vk_beli($datax, $id_user, $cekbeli->kode_beli);
							} else {
								$tunggubayar = true;
							}
						}
					}
				} else {
					$kodebeli = "belumpunya";
					$tstrata = 0;
					$expired = true;
				}
			} else {
				redirect("/");
			}

			///////////////////////////////////////////////////////////////////////////////////////

			$dafplaylistall = $this->M_vksekolah->getDafPlayListSekolah($npsn, $id_user, $kodebeli);
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
			$data['kodebeliakhir'] = $kodebeliakhir;
			if ($kodebeliakhir != "")
				$kodebeli = $kodebeliakhir;
			$data['tunggubayar'] = $tunggubayar;
			$data['totalaktif'] = $jmlaktif;
			$data['totalkeranjang'] = $jmlkeranjang;

			$data['tglbatas'] = $tglbatas->format("d-m-Y");

			$hargapaket = $this->M_vksekolah->gethargapaket($npsn);
			if (!$hargapaket)
				$hargapaket = $this->M_vksekolah->gethargapaket("standar");

			if ($tstrata == "0")
				$data['totalmaksimalpilih'] = 0;
			else
				$data['totalmaksimalpilih'] = $hargapaket["njudul_" . $tstrata];

//			$data['dafplaylist'] = $this->M_vksekolah->getDafPlayListSekolahRev($npsn, $id_user, $kodebeli, null, null, null, $kunci);
			$data['dafplaylist'] = $this->M_vksekolah->getDafPlayListSekolahRev($npsn, null, 1, $kodebeli, $id_user, null, null, null, $kunci);

			if ($data['dafplaylist']) {
				$data['punyalist'] = true;
				$statusakhir = $data['dafplaylist'][0]->link_list;
//				echo "<br><br><br><br><br>SattusAkhir:".$statusakhir;
				$data['playlist'] = $this->M_vksekolah->getPlayListSekolah($statusakhir, null);
			} else {
//            $data['playlist'] = $this->M_vksekolah->getPlayListGuru($kd_user);
				$data['punyalist'] = false;
//			if (!$this->session->userdata('loggedIn')) {
//				redirect('/');

//			}
			}

			$data['infoguru'] = $this->M_vksekolah->getInfoGuru(null);
//			$data['dafvideo'] = $this->M_vksekolah->getVodGuru($iduser);

			$data['iduser'] = null;
			$data['npsn'] = $npsn;
			$data['ambilpaket'] = $tstrata;
			$data['jenis'] = $jenis;
			$data['id_playlist'] = null;
			$this->load->view('layout/wrapper_umum', $data);

		}
	}

	public function get_autocomplete($npsn)
	{
		if ($npsn == "saya")
			$npsn = $this->session->userdata('npsn');
		if (isset($_GET['term'])) {
			$result = $this->M_vksekolah->search_Sekolah($_GET['term'], $npsn);
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

	public function tambahplaylist_sekolah()
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02') && $this->session->userdata('bimbel') != 3) {
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

	public function soal($npsn = null, $opsi = null, $linklist = null)
	{
//		if ($npsn=="saya")
//			$npsn = $this->session->userdata('npsn');
		if ($npsn == null)
			redirect("/");

		if ($npsn == "saya" || $npsn == $this->session->userdata('npsn')) {
			$npsn == $this->session->userdata('npsn');
			$jenis = 1;
		} else
			$jenis = 2;

		$strstrata = array("", "lite", "pro", "premium");
		$tglbatas = new DateTime("2020-01-01 00:00:00");

		if ($this->session->userdata('loggedIn')) {
			$id_user = $this->session->userdata("id_user");
			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $jenis);
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

		if ($id_user == 0 || $expired == true)
			redirect("/");

		if ($opsi == "tampilkan") {
			$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_vksekolah_soal');
			$paketsoal = $this->M_vksekolah->getPaket($linklist);
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$data['judul'] = $paketsoal[0]->nama_paket;
			$data['dafsoal'] = $this->M_vksekolah->getSoal($paketsoal[0]->id);
			$data['linklist'] = $linklist;
			$data['asal'] = "owner";
		} else if ($opsi == "buat") {
			$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_vksekolah_buatsoal');
			$paket = $this->M_vksekolah->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['dafsoal'] = $this->M_vksekolah->getSoal($paket[0]->id);
			$data['linklist'] = $linklist;
			$data['npsn'] = $npsn;
			$data['asal'] = "owner";
		} else if ($opsi == "seting") {
			$data = array('title' => 'Seting Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_vksekolah_soal_seting');
			$paketsoal = $this->M_vksekolah->getPaket($linklist);
			$data['paket'] = $paketsoal;
			$dafsoal = $this->M_vksekolah->getSoal($paketsoal[0]->id);
			$data['totalsoal'] = sizeof($dafsoal);
			$data['npsn'] = $npsn;
			$data['linklist'] = $linklist;
		} else if ($opsi == "kerjakan") {
			$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_vksekolah_soal');
			$paketsoal = $this->M_vksekolah->getPaket($linklist);
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$data['judul'] = $paketsoal[0]->nama_paket;
			$data['dafsoal'] = $this->M_vksekolah->getSoal($paketsoal[0]->id);
			$data['linklist'] = $linklist;
			$data['npsn'] = $npsn;
			$data['asal'] = "menu";
		} else if ($opsi == null) {
			redirect("/vksekolah/page/1");
		} else if ($opsi != "tampilkan") {
			$data = array('title' => 'Mulai Soal', 'menuaktif' => '15',
				'isi' => 'v_vksekolah_mulai');
			$paketsoal = $this->M_vksekolah->getPaket($opsi);
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$dafsoal = $this->M_vksekolah->getSoal($paketsoal[0]->id);
			$data['totalsoal'] = sizeof($dafsoal);
			$data['linklist'] = $opsi;
			$data['npsn'] = $npsn;
			$data['asal'] = $linklist;
		}

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper2', $data);
	}

	public function materi($npsn = null, $opsi = null, $linklist = null)
	{
		if ($npsn == null)
			redirect("/");

		if ($npsn == "saya" || $npsn == $this->session->userdata('npsn')) {
			$npsn == $this->session->userdata('npsn');
			$jenis = 1;
		} else
			$jenis = 2;

		$strstrata = array("", "lite", "pro", "premium");
		$tglbatas = new DateTime("2020-01-01 00:00:00");

		if ($this->session->userdata('loggedIn')) {
			$id_user = $this->session->userdata("id_user");
			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $jenis);
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

		if (!$this->session->userdata("a01") && ($id_user == 0 || $expired == true))
			redirect("/");

		if ($opsi == "buat") {
			$data = array('title' => 'Uraian Materi', 'menuaktif' => '15',
				'isi' => 'v_vksekolah_buatmateri');
			$paket = $this->M_vksekolah->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['uraian'] = $paket[0]->uraianmateri;
			$data['file'] = $paket[0]->filemateri;
			$data['linklist'] = $linklist;
		} else if ($opsi == "tampilkan") {
			$data = array('title' => 'Uraian Materi', 'menuaktif' => '15',
				'isi' => 'v_vksekolah_materi');
			$paket = $this->M_vksekolah->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['uraian'] = $paket[0]->uraianmateri;
			$data['file'] = $paket[0]->filemateri;
			$data['npsn'] = $npsn;
			$data['linklist'] = $linklist;
		}
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper2', $data);
	}

	public function tugas($npsn, $opsi = null, $linklist = null)
	{
		if ($npsn == "saya") {
			$tipepaket = 1;
		} else {
			$tipepaket = 2;
		}

		if ($npsn == null)
			redirect("/");

		if ($npsn == "saya" || $npsn == $this->session->userdata('npsn')) {
			$npsn == $this->session->userdata('npsn');
			$jenis = 1;
		} else
			$jenis = 2;

		$strstrata = array("", "lite", "pro", "premium");
		$tglbatas = new DateTime("2020-01-01 00:00:00");

		if ($this->session->userdata('loggedIn')) {
			$id_user = $this->session->userdata("id_user");
			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $jenis);
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

		if ($cekbeli->strata_paket < 2)
			redirect("/");


		if ($opsi == "buat") {
//			$data = array('title' => 'Uraian Tugas', 'menuaktif' => '15',
//				'isi' => 'v_vksekolah_buattugas');
//			$paket = $this->M_vksekolah->getPaket($linklist);
//			$data['judul'] = $paket[0]->nama_paket;
//			$data['uraian'] = $paket[0]->uraianmateri;
//			$data['file'] = $paket[0]->filemateri;
//			$data['linklist'] = $linklist;
		} else if ($opsi == "tampilkan") {
			if ($this->session->userdata('a01') || ($this->session->userdata('sebagai') == 4 &&
					$this->sessiono->userdata('verifikator') == 3)) {
				$expired = false;
				$id_user = $this->session->userdata("id_user");
			} else if ($this->session->userdata("a02") || $this->session->userdata("a03")) {
				$expired = false;
				$id_user = $this->session->userdata("id_user");
			} else {
				if ($this->session->userdata('loggedIn')) {
					$id_user = $this->session->userdata("id_user");
					$this->load->Model('M_channel');
					$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $tipepaket);
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
			}

			$data = array('title' => 'Uraian Tugas', 'menuaktif' => '15',
				'isi' => 'v_vksekolah_tugas');
			$tugasguru = $this->M_vksekolah->getTugas($tipepaket, $linklist);
			$data['tugasguru'] = $tugasguru;
			$idtugasguru = $tugasguru->id_tugas;
			$tugassiswa = $this->M_vksekolah->getTugasSiswa($idtugasguru, $id_user);
			if (!$tugassiswa) {
				$isi = array(
					'id_tugas' => $idtugasguru,
					'id_user' => $id_user
				);
				$this->M_vksekolah->addTugasSiswa($isi);
				$tugassiswa = $this->M_vksekolah->getTugasSiswa($idtugasguru, $id_user);
			}
			$data['tugassiswa'] = $tugassiswa;
			$data['id_tugas'] = $idtugasguru;
			$data['npsn'] = $npsn;
			$data['linklist'] = $linklist;
		} else if ($opsi == "jawabansaya") {
			if ($this->session->userdata("a02") || $this->session->userdata("a03")) {
				$expired = false;
			} else {
				if ($this->session->userdata('loggedIn')) {
					$id_user = $this->session->userdata("id_user");
					$this->load->Model('M_channel');
					$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $tipepaket);
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
			}

			$data = array('title' => 'Uraian Tugas', 'menuaktif' => '15',
				'isi' => 'v_vksekolah_jawabansaya');
			$tugasguru = $this->M_vksekolah->getTugas($tipepaket, $linklist);
			$data['tugasguru'] = $tugasguru;
			$idtugasguru = $tugasguru->id_tugas;
			$tugassiswa = $this->M_vksekolah->getTugasSiswa($idtugasguru, $id_user);

			$data['tugassiswa'] = $tugassiswa;
			$data['id_tugas'] = $idtugasguru;
			$data['npsn'] = $npsn;
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
		$paket = $this->M_vksekolah->getPaket($linklist);
		$jmlsoalkeluar = $paket[0]->soalkeluar;
		$iduserpaket = $paket[0]->id_user;
		$kunci_jawaban = $this->M_vksekolah->getSoal($paket[0]->id);
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
			$nilaiuser = $this->M_vksekolah->ceknilai($linklist, $iduser);
			$highscore = $nilaiuser->highscore;
			if ($nilai > $highscore)
				$data['highscore'] = $nilai;
			$data['score'] = $nilai;
			$update = $this->M_vksekolah->updatenilai($data, $linklist, $iduser);
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

		$paket = $this->M_vksekolah->getPaket($linklist);
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

			$this->M_vksekolah->updategbrsoal($namafilebaru, $id, $fielddb);

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

		$this->M_vksekolah->updatesoal($data, $idsoal);
		redirect('vksekolah/soal/buat/' . $linklist);
	}

	public function insertsoal($linklist)
	{
		$paket = $this->M_vksekolah->getPaket($linklist);
		$id_paket = $paket[0]->id;
		$idbaru = $this->M_vksekolah->insertsoal($id_paket);
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
			if ($this->M_vksekolah->delsoal($id))
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

			if ($this->M_vksekolah->updateseting($data, $linklist))
				redirect('vksekolah/soal/buat/' . $linklist);
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
			$nilaiuser = $this->M_vksekolah->ceknilai($linklist, $iduser);
			$highscore = $nilaiuser->highscore;
			if ($nilaiakhir > $highscore)
				$data['highscore'] = $nilaiakhir;
			$data['score'] = $nilaiakhir;
			$data['linklist'] = $linklist;
			$data['iduser'] = $iduser;
			$update = $this->M_vksekolah->updatenilai($data, $linklist, $iduser);
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
		if ($this->M_vksekolah->updatemateri($data, $linklist))
			echo "sukses";
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
		if ($this->M_vksekolah->updatetugasjawab($data, $id_tugas, $iduser)) {
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
			$this->M_vksekolah->updatemateri($data, $linklist);

			echo "Dokumen OK";

		} else {
			echo $this->upload->display_errors();
		}
	}

	public function upload_doktugas($linklist)
	{
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

		$iduser = $this->session->userdata('id_user');
		$idtgs = $this->input->post('idtgs');

		$this->load->library('upload', $config);
		if ($this->upload->do_upload("filedok")) {

			$dataupload = array('upload_data' => $this->upload->data());
			$random = rand(100, 999);
			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "ts_" . $iduser . "_" . $linklist . "_" . $random . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$data = array("jawabanfile" => $namafilebaru);
			$this->M_vksekolah->updatetugasjawab($data, $idtgs, $iduser);

			echo "Dokumen OK";

		} else {
			echo $this->upload->display_errors();
		}
	}

	public function kosonginfilemateri()
	{
		$linklist = $this->input->post('linklist');
		$data = array("filemateri" => "");
		$this->M_vksekolah->updatemateri($data, $linklist);
		echo "sukses";
	}

	public function download($npsn, $bentuk, $linklist)
	{
		if ($npsn == "saya" || $npsn == $this->session->userdata('npsn'))
			$jenis = 1;
		else
			$jenis = 2;

		$strstrata = array("", "lite", "pro", "premium");
		$tglbatas = new DateTime("2020-01-01 00:00:00");

		if ($this->session->userdata('loggedIn')) {
			$id_user = $this->session->userdata("id_user");
			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $jenis);
			if ($cekbeli)
				$tglbatas = new DateTime($cekbeli->tgl_batas);
		} else {
			$id_user = 0;
		}


		$tgl_sekarang = new DateTime();
		$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		if ($tgl_sekarang > $tglbatas) {
			$expired = "true";
			$tstrata = "0";
		} else {
			$expired = false;
			$tstrata = $strstrata[$cekbeli->strata_paket];
		}

		if ($bentuk == "materi") {
			$paket = $this->M_vksekolah->getPaket($linklist);
			force_download('uploads/materi/' . $paket[0]->filemateri, null);
		} else if ($bentuk == "tugas") {
			if ($expired == false && ($tstrata == "pro" || $tstrata == "premium")) {
				$paket = $this->M_vksekolah->getTugas($jenis, $linklist);
				force_download('uploads/tugas/' . $paket->tanyafile, null);
			} else {
				echo "<script>alert ('Gagal download. Hubungi admin!');
				window.open('" . base_url() . "vksekolah/tugas/" . $npsn . "/tampilkan/" . $linklist . "','_self');</script>";
			}
		} else if ($bentuk == "jawaban") {
			if ($expired == false && ($tstrata == "pro" || $tstrata == "premium")) {
				$paket = $this->M_vksekolah->getTugasSiswa($linklist, $id_user);
				force_download('uploads/tugas/' . $paket->jawabanfile, null);
			} else {
				echo "<script>alert ('Gagal download. Hubungi admin!');
				window.open('" . base_url() . "vksekolah/" . "','_self');</script>";
			}

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
			$this->M_vksekolah->addkeranjang($data);
		} else {
			$this->M_vksekolah->delkeranjang($data);
		}
		echo "sukses";
	}

	public function konfirmpilihan()
	{
		$jenis = $this->input->post('jenis');
		//$jenis =1;

//		if ($jenis == 1)
//			$npsn = "saya";
//		else if ($jenis == 2)
//			$npsn = "lain";

//		if ($npsn == "saya" || $npsn == $this->session->userdata('npsn'))
//			$jenis = 1;
//		else
//			$jenis = 2;

		$strstrata = array("0", "lite", "pro", "premium");
		$tglbatas = new DateTime("2020-01-01 00:00:00");

		if ($this->session->userdata('loggedIn')) {
			$id_user = $this->session->userdata("id_user");

			///////////////////////// ambil data am/ag/ver/kon
			$this->load->model('M_login');
			$getuserdata = $this->M_login->getUser($id_user);
			$npsn = $getuserdata['npsn'];
			$koderef = $getuserdata['referrer'];
			$idam = 0;
			$idag = 0;

			if($koderef!="" && $koderef!=null)
			{
				$this->load->model('M_marketing');
				$getDataRef = $this->M_marketing->getDataRef($koderef);
				$idam = $getDataRef->id_siam;
				$idag = $getDataRef->id_agency;
			}

			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $jenis);
			if ($cekbeli) {
				$tglbatas = new DateTime($cekbeli->tgl_batas);
				$rupiahbruto = $cekbeli->rupiah/25;
			}

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

			$this->load->Model('M_vksekolah');
			$datakeranjang = $this->M_vksekolah->getkeranjang($id_user, $jenis, $kodebeli);

			$data = array();
			$a = 0;
			foreach ($datakeranjang as $datane) {
				$a++;
				$data[$a]['id_user'] = $id_user;
				$data[$a]['jenis_paket'] = $jenis;
				$data[$a]['kode_beli'] = $kodebeli;
				$data[$a]['link_paket'] = $datane->link_list;
				if ($jenis==1||$jenis==2)
					$getinfopaket = $this->M_channel->getInfoPaket($datane->link_list);
				else if ($jenis==3)
					$getinfopaket = $this->M_channel->getInfoBimbel($datane->link_list);

				$npsn_modul = $getinfopaket->npsn_user;
				$this->load->model('M_eksekusi');
				$verifikatorlastactived = $this->M_eksekusi->getveraktif($npsn_modul);
				$idverifikator = $verifikatorlastactived->id;

				$statusverifikator = $this->cekstatusverifikator($verifikatorlastactived->npsn);

				$idkontributor = $getinfopaket->id_user;
				$data[$a]['id_ver'] = $idverifikator;
				$data[$a]['id_kontri'] = $idkontributor;
				$data[$a]['id_ag'] = $idag;
				$data[$a]['id_am'] = $idam;
				$data[$a]['rp_bruto'] = $rupiahbruto;
				$hargastandar = $this->M_eksekusi->getStandar();
				$hargapaket = $this->M_vksekolah->gethargapaket("standar");
				$batasmaxmodul = $hargapaket['njudul_pro'];
				$potonganmidtrans = $hargastandar->pot_midtrans/$batasmaxmodul;
				if($rupiahbruto==0)
					$potonganmidtrans=0;
				$data[$a]['rp_midtrans'] = $potonganmidtrans;
				$rupiahnet = $rupiahbruto - $potonganmidtrans;
				$data[$a]['rp_net'] = $rupiahnet;
				$data[$a]['rp_ppn'] = $rupiahnet*0.1;

				if ($statusverifikator)
				{
//					echo "ADA FEE VER";
//					die();
					$feever = $hargastandar->fee_ver;
				}
				else
				{
//					echo "GAK ADA VER";
//					die();
					$feever = 0;
				}
				///masing-masing dalam persen
				$feekon = $hargastandar->fee_kon;
				$feeam = $hargastandar->fee_am;
				$feeagency = $hargastandar->fee_agency;
				$pph = 10;

				////////////////////////////////////////
				$feemanajemen = 100 - ($feever+$feekon+$pph);
				$manajemenbruto = $rupiahnet*$feemanajemen/100;
				$data[$a]['rp_manajemen_bruto'] = $manajemenbruto;
				$manajemenpph = $manajemenbruto*2.5/100;
				$data[$a]['rp_manajemen_pph'] = $manajemenpph;
				$data[$a]['rp_manajemen_net'] = $manajemenbruto - $manajemenpph;
				///////////////////////////////////////
				$kontribruto = $rupiahnet*$feekon/100;
				$data[$a]['rp_kontri_bruto'] = $kontribruto;
				$kontripph = $kontribruto*2.5/100;
				$data[$a]['rp_kontri_pph'] = $kontripph;
				$data[$a]['rp_kontri_net'] = $kontribruto - $kontripph;
				///////////////////////////////////////
				if ($idam!=0) {
					if ($idag==0)
						$feeam = $hargastandar->fee_am + $hargastandar->fee_agency;
					else
						$feeam = $hargastandar->fee_am;
					$ambruto = $rupiahnet * $feeam / 100;
					$data[$a]['rp_am_bruto'] = $ambruto;
					$ampph = $ambruto * 2.5 / 100;
					$data[$a]['rp_am_pph'] = $ampph;
					$data[$a]['rp_am_net'] = $ambruto - $ampph;
				}
				else
				{
					$feeam=0;
				}

				if ($idag!=0) {
					$feeagency = $hargastandar->fee_agency;
					$agbruto = $rupiahnet * $feeagency / 100;
					$data[$a]['rp_ag_bruto'] = $agbruto;
					$agpph = $agbruto * 2.5 / 100;
					$data[$a]['rp_ag_pph'] = $agpph;
					$data[$a]['rp_ag_net'] = $agbruto - $agpph;
				}
				else
				{
					$feeagency=0;
				}
				///////////////////////////////////////
				$verbruto = $rupiahnet*($feever-($feeam+$feeagency))/100;
				$data[$a]['rp_ver_bruto'] = $verbruto;
				$verpph = $verbruto*2.5/100;
				$data[$a]['rp_ver_pph'] = $verpph;
				$data[$a]['rp_ver_net'] = $verbruto - $verpph;
			}

			if ($this->M_vksekolah->insertvk($id_user, $jenis, $data)) {
				echo "sukses";
			} else {
				echo "gagal";
			}

		}

	}

	private function cekstatusverifikator($npsn)
	{
		$this->load->model('M_payment');
		$cekstatusbayar = $this->M_payment->getlastsekolahpayment($npsn);

		if ($cekstatusbayar) {

			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

			$statusbayar = $cekstatusbayar->status;

			$tanggalorder = new DateTime($cekstatusbayar->tgl_order);
			$batasorder = $tanggalorder->add(new DateInterval('P1D'));
			$bulanorder = $tanggalorder->format('m');
			$tahunorder = $tanggalorder->format('Y');

			$tanggal = $datesekarang->format('d');
			$bulan = $datesekarang->format('m');
			$tahun = $datesekarang->format('Y');

			$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

			if ($statusbayar == 4) {
//				echo "01";
				return true;
			} else {
				if ($selisih >= 2) {
					if ($this->aktifolehsiswa())
						{
//							echo "02";
							return true;
						}
					else
						{
//							echo "03";
							return false;
						}
				} else if ($selisih == 1) {
					if ($this->aktifolehsiswa())
					{
//						echo "04";
						return true;
					}

					if ($tanggal <= 5) {
//						echo "05";
						return true;
					} else {
//						echo "06";
						return false;
					}

				} else {
					if ($statusbayar == 1) {
						if ($this->aktifolehsiswa())
						{
//							echo "07";
							return true;
						}
						else
							{
//								echo "08";
								return false;
							}
					} else if ($statusbayar == 3) {
//						echo "09";
						return true;
					}
				}
			}
		} else {

			if ($this->aktifolehsiswa())
				{
//					echo "09";
					return true;
				}
			else
				{
//					echo "10";
					return false;
				}
		}
	}

	private function aktifolehsiswa()
	{
		$ceksiswareguler = $this->M_login->getsiswabeli($this->session->userdata('npsn'),2);
		$ceksiswapremium = $this->M_login->getsiswabeli($this->session->userdata('npsn'),3);

		if ($ceksiswareguler>=10 || $ceksiswapremium>=1)
			{
//				echo "-a-";
				return true;
			}
		else
			{
//				echo "-b-";
				return false;
			}
	}

	public function pilih_paket($npsn)
	{
		$this->load->model('M_vksekolah');
		$data = array();
		$data['konten'] = "v_vksekolah_belipaket";

		$data['npsn'] = $npsn;

		$data['tvpremium'] = "";
		$data['total_adapaketreguler'] = 0;
		$data['total_adapaketpremium'] = 0;

		if ($npsn == "saya") {
			$npsn = $this->session->userdata('npsn');
			$jenis = 1;

			///////////////////// CEK JUMLAH PREMIUM ///////////////////
			$this->load->model("M_user");
			$cekuser = $this->M_user->getUserBeli($this->session->userdata('npsn'));
			$jmlbelipaketreguler = 0;
			$jmlbelipaketpremium = 0;
			foreach ($cekuser as $rowdata)
			{
//				echo $rowdata->kode_beli."<br>";
				if ($rowdata->strata == 2)
					$jmlbelipaketreguler++;
				else if ($rowdata->strata == 3)
					$jmlbelipaketpremium++;
			}
//			die();
			$data['total_adapaketreguler'] = $jmlbelipaketreguler;
			$data['total_adapaketpremium'] = $jmlbelipaketpremium;

			$totalpaketgratis = $jmlbelipaketreguler + $jmlbelipaketpremium;

			$this->load->model("M_payment");
			$cekpremium = $this->M_payment->cekpremium($this->session->userdata['npsn']);

//			echo "<pre>";
//			echo var_dump($cekpremium);
//			echo "</pre>";
//			die();

			if ($cekpremium)
			{
				$orderid = $cekpremium->order_id;
				if (substr($orderid,0,3)=="TP0")
					$data['tvpremium'] = "PREMIUMEB";
				else if (substr($orderid,0,3)=="TF0")
					$data['tvpremium'] = "FULLPREMIUMEB";
				else if (substr($orderid,0,3)=="TP1" && $totalpaketgratis<=100)
					$data['tvpremium'] = "PREMIUM";
				else if (substr($orderid,0,3)=="TF1" && $totalpaketgratis<=100)
					$data['tvpremium'] = "FULLPREMIUM";
			}

//			echo $totalpaketgratis;
//			die();
			//////////////////////////////////////////////////////////////

		} else {
			$jenis = 2;
		}


		$iduser = $this->session->userdata('id_user');

		$this->load->model('M_channel');
		$cekstatusbayar = $this->M_channel->getlast_kdbeli($iduser, $jenis);

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
				$data['tstrata'] = $strstrata[$cekstatusbayar->strata_paket];
				//echo "AMANNNN";
			} else {
				if ($statusbayar == 1) {
					if ($datesekarang > $batasorder) {
						$datax = array("status_beli" => 0);
						$this->M_payment->update_vk_beli($datax, $iduser, $cekstatusbayar->kode_beli);
					} else {
						redirect("/payment/tunggubayarpaket/$jenis");
					}

				}
			}
		}


		$harga = $this->M_vksekolah->gethargapaket($npsn);
		if ($harga)
			$data['harga'] = $harga;
		else
			$data['harga'] = $this->M_vksekolah->gethargapaket("standar");
		$data['jenis'] = $jenis;

		$this->load->view('layout/wrapper_payment', $data);
	}

	public function cekstatussekolah($npsn)
	{
		$this->load->model('M_payment');
//		echo "NPSN:".$npsn;

		$cekstatusbayar = $this->M_payment->getlastpaymentsekolah($npsn);

//		echo "<pre>";
//		echo var_dump($cekstatusbayar);
//		echo "</pre>";
//
//		die();

		if ($cekstatusbayar) {
//			$url = 'https://worldtimeapi.org/api/timezone/Asia/Jakarta';
//			$fgc = @file_get_contents($url);
//			if ($fgc === FALSE) {
//				redirect("/");
////			$datesekarang = new DateTime();
////			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
//			} else {
//				$obj = json_decode($fgc, true);
//				$datesekarang = new DateTime(substr($obj['datetime'], 0, 19));
//			}

			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

			$statusbayar = $cekstatusbayar->status;

			$tanggalorder = new DateTime($cekstatusbayar->tgl_order);
			$batasorder = $tanggalorder->add(new DateInterval('P1D'));
			$bulanorder = $tanggalorder->format('m');
			$tahunorder = $tanggalorder->format('Y');

			$tanggal = $datesekarang->format('d');
			$bulan = $datesekarang->format('m');
			$tahun = $datesekarang->format('Y');

			$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

			if ($statusbayar == 4) {

			} else {
				if ($selisih >= 2) {
					redirect("vksekolah/sekolahoff");
				}
//				else if ($selisih == 1) {
//					if ($tanggal <= 5) {
//
//					} else {
//						redirect("vksekolah/sekolahoff");
//					}
//				}
			else {
					if ($statusbayar == 1) {
						redirect("vksekolah/sekolahoff");
					} else if ($statusbayar == 3) {

					}
				}
			}
		} else {
			redirect("vksekolah/sekolahoff");
		}
	}

	public function sekolahoff()
	{
		$data = array('title' => 'Playing VOD', 'menuaktif' => 1,
			'isi' => 'v_informasisekolahoff');
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapperchannel', $data);
	}

	private function cekpembayaransekolah($npsn)
	{
		$this->load->Model('M_payment');
		$cekstatusbayar = $this->M_payment->getlastpaymentsekolah($npsn);

		if ($cekstatusbayar) {

			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

			$statusbayar = $cekstatusbayar->status;
			$orderid = $cekstatusbayar->order_id;

			$tanggalorder = new DateTime($cekstatusbayar->tgl_order);
			$batasorder = $tanggalorder->add(new DateInterval('P1D'));
			$bulanorder = $tanggalorder->format('m');
			$tahunorder = $tanggalorder->format('Y');

			$tanggal = $datesekarang->format('d');
			$bulan = $datesekarang->format('m');
			$tahun = $datesekarang->format('Y');

			$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

			if ($statusbayar == 4) {
				return $orderid;
			} else {
				if ($selisih >= 2) {
					return "zonk";
				}
				else if ($selisih == 1) {
					if ($tanggal <= 5) {
						return $orderid;
					} else {
						return "zonk";
					}
				}
				else {
					if ($statusbayar == 1) {
						return "zonk";
					} else if ($statusbayar == 3) {
						return $orderid;
					}
				}
			}
		} else {
			return "zonk";
		}
	}

}
