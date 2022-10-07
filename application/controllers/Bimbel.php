<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bimbel extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_induk');
		$this->load->model('M_bimbel');
		$this->load->helper(array('Form', 'Cookie', 'String', 'tanggalan', 'download', 'video', 'statusverifikator'));
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->library('pagination');

		if ($this->session->userdata('loggedIn') && !$this->session->userdata('activate'))
			redirect('/login/profile');
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
		$this->session->unset_userdata('shared');

		if ($iduser == "share" && !$this->session->userdata('loggedIn')) {
			$data = array();
			$data['konten'] = 'v_bimbel_pilih_nosign';
			$data['dafplaylist'] = $this->M_bimbel->getDafPlayListBimbelEceran($linklist);

			$paketsoal = $this->M_bimbel->getPaket($linklist);
			$data['expired'] = true;
			$data['id_playlist'] = $linklist;
			$data['pengunggah'] = $paketsoal[0]->first_name . " " . $paketsoal[0]->last_name;

			$data['meta_title'] = $paketsoal[0]->nama_paket;
			$data['meta_description'] = "Karya: ".$data['pengunggah']."<br><br> "." ".$paketsoal[0]->deskripsi_paket;
			$data['meta_image'] = $data['dafplaylist'][0]->thumbnail;
			$data['meta_url'] = base_url()."bimbel/get_bimbel/" . $linklist. "/share";



			$this->load->view('layout/wrapper_umum', $data);

		} else if (!$this->session->userdata('loggedIn'))
		{
			redirect("/");
		}
		else {

			$jenis = 3; ////// bimbel
			$strstrata = array("0", "Lite", "Pro", "Premium");
			$tglbatas = new DateTime("2020-01-01 00:00:00");
			$kodebeliakhir = "";
			$tunggubayar = false;
			$expired = true;

			$getstatusvk = getstatusbelivk($jenis);

			if ($getstatusvk['status_tunggu_eceran'] == "tunggu") {
				redirect("/payment/tunggubayareceran/$jenis");
			}

			$kodebeli = $getstatusvk['kode_beli'];
			$tstrata = $getstatusvk['status_vk_sekarang'];
			if ($getstatusvk['status_tunggu'] == "tunggu") {
				redirect("/payment/tunggubayarpaket/$jenis");
			}

			if ($tstrata != "0")
				$expired = false;

			$tglbatas = new DateTime($getstatusvk['tgl_batas']);

//		echo $tstrata."<br>".$expired."<br>".$getstatusvk['status_tunggu'];
//		die();

			$id_user = $this->session->userdata('id_user');

			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $jenis);

			$this->load->Model('M_bimbel');
			$dafplaylistall = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli);

//			echo "<pre>";
//			echo var_dump($dafplaylistall);
//			echo "</pre>";
//			die();

			$jmlaktif = 0;
			$jmlkeranjang = 0;
			foreach ($dafplaylistall as $datane) {
				if ($datane->link_paket != null || $datane->kode_beli != null || $datane->kode_beli2 != null)
					$jmlaktif++;
				if ($datane->dikeranjang == 1)
					$jmlkeranjang++;
			}


			if ($iduser == "0")
				redirect("/bimbel/page/1");

			if ($linklist == "hal") {
				$data = array();
				$data['konten'] = 'v_bimbelall';

				$data['halaman'] = $iduser;
				//$data['dafvideo1'] = $this->M_bimbel->getBimbelAll();
				$data['dafjenjang'] = $this->M_bimbel->getJenjangBimbel();
				$data['dafkelas'] = $this->M_bimbel->getKelasBimbel();
				$data['dafkategori'] = $this->M_bimbel->getKategoriAll();
				$data['mapel'] = "";
				$data['asal'] = "page";
				$data['ambilpaket'] = $tstrata;
				$data['jenis'] = $jenis;
				$data['jenjang'] = 0;
				$data['njenjang'] = 0;
				$data['kategori'] = 0;
				$data['kuncine'] = "";
				$data['tglbatas'] = $tglbatas->format("d-m-Y");

				if ($kodebeli == "belumpunya") {
					$data['expired'] = true;
					$data['kodebeli'] = "expired";
				} else {
					$data['expired'] = false;
					$data['kodebeli'] = $kodebeli;
				}
				$data['kodebeliakhir'] = $kodebeliakhir;
				if ($kodebeliakhir != "")
					$kodebeli = $kodebeliakhir;
				$data['totalaktif'] = $jmlaktif;
				$data['totalkeranjang'] = $jmlkeranjang;
				$hargapaket = $this->M_bimbel->gethargapaket("bimbel");

				if ($tstrata == "0")
					$data['totalmaksimalpilih'] = 0;
				else
					$data['totalmaksimalpilih'] = $hargapaket["njudul_" . strtolower($tstrata)];

				if ($iduser == "cari") {
					$hitungdata = sizeof($this->M_bimbel->getBimbelCari(0, 0, $hal2));
				} else {
					$hitungdata = sizeof($dafplaylistall);
				}

				$config['base_url'] = site_url('bimbel/'); //site url
				$config['total_rows'] = $hitungdata;
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

				$data['total_data'] = $hitungdata;
				$data['pagination'] = $this->pagination->create_links();
			} else {
				$data = array();
				$data['konten'] = 'v_bimbel_pilih';
				$paketsoal = $this->M_bimbel->getPaket($linklist);
				$tugasguru = $this->M_bimbel->getTugas($linklist);

				$this->load->Model("M_channel");
				$jenispaket = 3;
				$cekorder = $this->M_channel->cekLinklist_VK($id_user,$jenispaket,$linklist);
				if ($cekorder)
				if (substr($cekorder->kode_beli,0,3)=="ECR")
				{
					$strataecer = substr($cekorder->kode_beli,4,1);
					$strstrata = array("0", "Lite", "Pro", "Premium", "Privat");
					$tstrata = $strstrata[$strataecer];

					if ($tstrata != "0")
						$expired = false;
				}

				$data['tugasguru'] = $tugasguru;
				if ($tugasguru)
					$idtugasguru = $tugasguru->id_tugas;
				else
					$idtugasguru = 0;

				$tugassiswa = $this->M_bimbel->getTugasSiswa($idtugasguru, $id_user);

				$bolehchat = false;

				if ($tstrata == "Lite" || $tstrata == "Pro" || $tstrata == "Premium" || $this->session->userdata('a01'))
					$bolehchat = true;

				$data['bolehchat'] = $bolehchat;

//			echo "<br><br><br><br><br><br>";
//			if ($expired==false)
//				echo "OK".$tstrata;
//			else
//				echo "EXPIRED".$tstrata;

				if ($expired == false && ($tstrata == "Pro" || $tstrata == "Premium")) {
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
				{
					if ($cekorder)
						$data['kodebeli'] = $cekorder->kode_beli;
					else
						$data['kodebeli'] = $cekbeli->kode_beli;
				}

				$data['kodebeliakhir'] = $kodebeliakhir;
				if ($kodebeliakhir != "")
					$kodebeli = $kodebeliakhir;
				$data['totalaktif'] = $jmlaktif;
				$data['totalkeranjang'] = $jmlkeranjang;
				$data['ambilpaket'] = $tstrata;

				$hargapaket = $this->M_bimbel->gethargapaket("bimbel");

				if ($tstrata == "0")
					$data['totalmaksimalpilih'] = 0;
				else
					$data['totalmaksimalpilih'] = $hargapaket["njudul_" . strtolower($tstrata)];

				$npsnku = $this->session->userdata('npsn');
				$datapesan = $this->M_channel->getChat(3, $npsnku);
				$data['datapesan'] = $datapesan;
				$data['idku'] = $this->session->userdata('id_user');
				$data['linklist'] = $linklist;
				$data['jenis'] = "bimbel";
				$data['namasekolah'] = "Topik [" . $paketsoal[0]->nama_paket . "]";

				$getpaket = $this->M_channel->getInfoBeliPaket($id_user, 3, $linklist);
				if ($getpaket) {

					$data['adavicon'] = "ada";
					//echo "KONTRI:".$idkontributor.", YGBELI:".$iduserbeli." , BATAS:".$batasaktif;
				} else
					$data['adavicon'] = "tidak";

				////////// UNTUK JITSI ///////////
				///

				$jenis = 3;
				if (!$paketsoal[0])
					redirect("/");
				$idkontributor = $paketsoal[0]->id_user;
				$data['nama_paket'] = $paketsoal[0]->nama_paket;
				$data['koderoom'] = "";
				$tglkode = substr($paketsoal[0]->tglkode, 0);
				$tglvicon = substr($paketsoal[0]->tglvicon, 0, 10);
				$datesekarang = new DateTime();
				$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
				$tglsekarang = $datesekarang->format('Y-m-d');
				$tglsekarangfull = $datesekarang->format('Y-m-d H:i:s');

				if ($id_user == $idkontributor) {
					$data['statusvicon'] = "moderator";
					if ($tglsekarang == $tglkode && $paketsoal[0]->koderoom != "") {
						$data['koderoom'] = $paketsoal[0]->koderoom;
						if (strtotime($tglsekarangfull) <= strtotime($tglvicon))
							$data['koderoom'] = "";
					} else {
						$set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						$code = substr(str_shuffle($set), 0, 10);
						$code2 = substr(str_shuffle($set), 0, 10);
						$data2 = array('koderoom' => $code,
							'kodepassvicon' => $code2,
							'tglkode' => $tglsekarangfull);
						if ($jenis == 3)
							$this->M_channel->updateDurasiBimbel($linklist, $data2);
						else
							$this->M_channel->updateDurasiPaket($linklist, $data2);
						$data['koderoom'] = $code;
					}
				} else {
					$data['statusvicon'] = "siswa";
//			echo $tglsekarang;
//			echo "---";
//			echo $tglkode;
//			echo "---";
//			echo $tglvicon;
					if (substr($tglsekarang, 0, 10) == substr($tglkode, 0, 10)) {
						$data['koderoom'] = $paketsoal[0]->koderoom;
						if (substr($tglsekarang, 0, 10) != substr($tglvicon, 0, 10))
							$data['koderoom'] = "";
					}
				}
				////////////////////////////////////////////
			}


			if ($iduser == "cari") {
				$data['kuncine'] = $hal2;
				$data['dafplaylist'] = $this->M_bimbel->getBimbelCari(0, 0, $hal2);
			} else {
				if ($linklist == "hal") {
					$data['dafplaylist'] = $this->M_bimbel->getDafPlayListBimbelAll(null, $iduser, $kodebeli, $id_user);
					//$data['dafplaylist'] = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, null, null, null, null);
				} else {
					$data['dafplaylist'] = $this->M_bimbel->getDafPlayListBimbelAll($linklist, "semua", $kodebeli, $id_user);
//					if ($data['dafplaylist'][0]->tgl_beli==null)
//						{
//							$data['ambilpaket'] = "";
//							$data['expired'] = true;
//						}
				}
			}

//			$data['dafplaylist'] = $this->M_bimbel->tesambildata(null, $iduser, $kodebeli, $id_user);
//			echo "<pre>";
//			echo var_dump($data['dafplaylist']);
//			echo "</pre>";

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

			$data['iduser'] = $iduser;
			$data['page'] = $iduser;
			if ($linklist == "hal")
				$linklist = null;
			$data['id_playlist'] = $linklist;
			$data['kodelink'] = $linklist;
			$data['gembokorpilih'] = $this->M_bimbel->cekpilihan($id_user, $jenis, $linklist);
			$data['tunggubayar'] = $tunggubayar;

			$this->load->view('layout/wrapper_umum', $data);
		}

	}

	public function menujujenjang()
	{
		$nmjenjang = array("", "PAUD", "SD", "SMP", "SMA", "SMK", "PT", "PKBM", "PPS", "Lain", "SD", "SMP", "SMP", "SMP", "SMA", "SMA",
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
		$data = array();
		$data['konten'] = 'v_bimbelall';

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


		$tunggubayar = false;

		if ($jenjangpendek == null) {
			redirect("/bimbel");
		} else
			if ($jenjangpendek == "carikategori") {
				redirect("/bimbel/kategori/pilih");
			}


		//////////////////////////////////////////////////////////////////////////////////////////
		$id_user = $this->session->userdata("id_user");
		$jenis = 3; ////// bimbel
		$strstrata = array("", "lite", "pro", "premium");
		$tglbatas = new DateTime("2020-01-01 00:00:00");
		$kodebeliakhir = "";

		if ($this->session->userdata('loggedIn')) {
			$kodebeli = "belumpunya";
			$tstrata = 0;
			$expired = true;

			$id_user = $this->session->userdata("id_user");

			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $jenis);
			$tunggubayar = false;

			if ($cekbeli) {
				$statusbayar = $cekbeli->status_beli;

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
				$this->load->Model('M_vksekolah');
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
			$id_user = 0;
		}

		if ($jenjangpendek != null) {
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['njenjang'] = $jenjang[0]->id;
		} else {
			$data['njenjang'] = 0;
		}

		if ($idkelas == null) {
			$data['nkelas'] = 0;
		} else if ($idkelas == "hal") {
			$data['nkelas'] = 0;
			$halaman = $idmapel;
		} else {
			$data['nkelas'] = $idkelas;
		}

		if ($idmapel == null) {
			$data['nmapel'] = 0;
		} else {
			$data['nmapel'] = $idmapel;
		}


		////////////////////////////////////////////////////////////////////////////////////////

		$dafplaylistall = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli);
		$jmlaktif = 0;
		$jmlkeranjang = 0;
		foreach ($dafplaylistall as $datane) {
			if ($datane->link_paket != null || $datane->kode_beli != null || $datane->kode_beli2 != null)
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
		$data['totalaktif'] = $jmlaktif;
		$data['totalkeranjang'] = $jmlkeranjang;
		$data['tglbatas'] = $tglbatas->format("d-m-Y");

		$hargapaket = $this->M_bimbel->gethargapaket("bimbel");

		if ($tstrata == "0")
			$data['totalmaksimalpilih'] = 0;
		else
			$data['totalmaksimalpilih'] = $hargapaket["njudul_" . $tstrata];


//		if ($kunci0 == "cari") {
////			$hitungdata = $this->M_bimbel->getBimbelCari($jenjangpendek, $idmapel, $kunci1);
//			$getdatabimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel, $kunci1);
//		} else if ($idmapel == "cari") {
////			$hitungdata = $this->M_bimbel->getBimbelCari($jenjangpendek, 0, $kunci0);
//			$getdatabimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, 0, $kunci1);
//		} else if ($idmapel > 0 && $kunci0 == null) {
////			$hitungdata = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel);
//			$getdatabimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel);
//		} else if ($idmapel == 0 && $kunci0 > 0) {
////			$hitungdata = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel);
//			$getdatabimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel);
//		} else {
////			$hitungdata = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel);
//			$getdatabimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel);
//		}

		$getdatabimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel, $kunci1);


//		echo "<pre>";
//		echo var_dump($hitungdata);
//		echo "</pre>";

		$config['base_url'] = site_url('bimbel/'); //site url
		$config['total_rows'] = count($getdatabimbel);

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

//
//		if ($idmapel == "0") {
//			$data['page'] = ($this->uri->segment(5 + $tambahseg)) ? $this->uri->segment(5 + $tambahseg) : 0;
//			// echo "<br><br><br><br>MAPEK".$data['page'];
//			//die();
//		} else if ($idmapel > 0) {
//			if ($kunci0 == "cari") {
//				$data['page'] = ($this->uri->segment(7 + $tambahseg)) ? $this->uri->segment(7 + $tambahseg) : 0;
//			} else {
//				$data['page'] = ($this->uri->segment(5 + $tambahseg)) ? $this->uri->segment(5 + $tambahseg) : 0;
//			}
//		} else if ($idmapel == "cari") {
//			$data['page'] = ($this->uri->segment(6 + $tambahseg)) ? $this->uri->segment(6 + $tambahseg) : 0;
//			// echo "<br><br><br><br>MAPEK".$data['page'];
//			//die();
//		} else if ($kunci1 != null) {
//			$data['page'] = ($this->uri->segment(7 + $tambahseg)) ? $this->uri->segment(7 + $tambahseg) : 0;
//			//echo "<br><br><br><br>MAPEOK".$data['page'];
//			//die();
//		} else {
//			$data['page'] = ($this->uri->segment(6 + $tambahseg)) ? $this->uri->segment(6 + $tambahseg) : 0;
//			//echo "<br><br><br><br>MAPEOK".$data['page'];
//			//die();
//		}


//        echo "MAPEOK".$data['page']."---IDMAPEL".$idmapel;
//		die();

		$data['pagination'] = $this->pagination->create_links();

		if ($kunci0 == "cari") {
			echo "q0";
			die();
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['jenjang'] = $jenjang[0]->id;
			$data['dafvideo'] = $this->M_bimbel->getBimbelCari($jenjangpendek, $idmapel, $kunci1, $config["per_page"], $data['page']);
			$data['kuncine'] = $kunci1;
		} else if ($idmapel == "cari") {
			echo "q1";
			die();
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['kuncine'] = $kunci0;
			$data['jenjang'] = $jenjang[0]->id;
			$data['dafvideo'] = $this->M_bimbel->getBimbelCari($jenjangpendek, 0, $kunci0, $config["per_page"], $data['page']);
			$getdafbimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel, null, $config["per_page"], $data['page']);
		} else if ($idkelas > 0 && $idmapel == 0) {

			if ($kunci0 == null)
				$kunci0 = 1;
//			echo "HALAMAN:".$kunci0;
			$data['halaman'] = $kunci0;
			$data['asal'] = "kelas";
			$data['kuncine'] = "";
			$data['mapel'] = $idmapel;
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['jenjang'] = $jenjang[0]->id;
			//echo ("JP".$jenjangpendek);
			$bataslimit = $kunci0;
			if ($bataslimit >= 1)
				$bataslimit = ($bataslimit - 1) * $config['per_page'];
//			$data['dafvideo'] = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel, $config["per_page"], $data['page']);
			$getdafbimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel, null, $config["per_page"], $bataslimit);
			$totaldata = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel, null);
			$data['total_data'] = sizeof($totaldata);
		} else if ($idkelas > 0 && $idmapel == "hal") {
//			echo "q3";
//			die();
			$data['asal'] = "kelas";
			$data['kuncine'] = "";
			$data['mapel'] = $idmapel;
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['jenjang'] = $jenjang[0]->id;
			//echo ("JP".$jenjangpendek);
			$bataslimit = $idmapel;
			if ($bataslimit >= 1)
				$bataslimit = $bataslimit - 1 * $config['per_page'];
//			$data['dafvideo'] = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel, $config["per_page"], $data['page']);
			$getdafbimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel, null, $config["per_page"], $bataslimit);
			$totaldata = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel, null);
			$data['total_data'] = sizeof($totaldata);
		} else if ($idkelas == "hal") {
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$kunci0 = null;
			$data['asal'] = "jenjang";
			$data['kuncine'] = "";
			$data['jenjang'] = $jenjang[0]->id;
			$bataslimit = $idmapel;
			$data['halaman'] = $idmapel;
			if ($bataslimit >= 1)
				$bataslimit = ($bataslimit - 1) * $config['per_page'];

//			echo "BATASLIMIT:::".$bataslimit;
//			echo "idmapel:::".$bataslimit;
//			die();
//			$data['dafvideo'] = $this->M_bimbel->getBimbelCari($jenjangpendek, 0, $kunci0, $config["per_page"], $bataslimit);
			$getdafbimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, null, null, null, $config["per_page"], $bataslimit);
			$totaldata = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, null, null, null);
			$data['total_data'] = sizeof($totaldata);
			//			echo "<pre>";
//			echo var_dump($getdafbimbel);
//			echo "</pre>";
		} else if ($idmapel > 0 && $kunci0 == null) {

			if ($kunci0 == null)
				$kunci0 = 1;
//			echo "HALAMAN:".$kunci0;
			$data['halaman'] = $kunci0;
			$data['asal'] = "mapelnya";
			$data['kuncine'] = "";
			$data['mapel'] = $idmapel;
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['jenjang'] = $jenjang[0]->id;
			//echo ("JP".$jenjangpendek);
			$bataslimit = $kunci0;
			if ($bataslimit >= 1)
				$bataslimit = ($bataslimit - 1) * $config['per_page'];

//			$data['asal'] = "mapelnya";
//			$jenjang = $this->M_bimbel->cekJenjangMapel($idmapel);
//			$data['jenjang'] = $jenjang[0]->id_jenjang;
//			$data['mapel'] = $idmapel;
//			$data['kuncine'] = $kunci1;

//			$data['dafvideo'] = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel, $config["per_page"], $data['page']);
			$getdafbimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel, null, $config["per_page"], $bataslimit);
			$totaldata = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel);
			$data['total_data'] = sizeof($totaldata);
//			echo "<pre>";
//			echo var_dump($getdafbimbel);
//			echo "</pre>";

		} else if (($idmapel == null || $idmapel == 0) && $jenjangpendek != null) {
//			echo "C";
//			die();
			//echo("q4");
			$data['kuncine'] = "";
			$idmapel = 0;
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['jenjang'] = $jenjang[0]->id;
			//echo ("JP".$jenjangpendek);
			$bataslimit = $idmapel;
			if ($bataslimit >= 1)
				$bataslimit = $bataslimit - 1 * $config['per_page'];
			else {
				$bataslimit = 0;
			}
//			echo "BATASLIMIT:::".$bataslimit;
//			$data['dafvideo'] = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel, $config["per_page"], $data['page']);
			$getdafbimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel, null, $config["per_page"], $bataslimit);
			$totaldata = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel, null);

			$data['total_data'] = sizeof($totaldata);
			$data['asal'] = "jenjang";
			$data['nkelas'] = $idkelas;
			//			echo "<pre>";
//			echo var_dump($getdafbimbel);
//			echo "</pre>";
//
		} else if ($idmapel == "hal") {
			echo "q7";
			die();
			$data['asal'] = "jenjang";
			$data['kuncine'] = "";
			$data['mapel'] = $idmapel;
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['jenjang'] = $jenjang[0]->id;
			//echo ("JP".$jenjangpendek);
			$bataslimit = $kunci0;
			if ($bataslimit >= 1)
				$bataslimit = ($bataslimit - 1) * $config['per_page'];
//			$data['dafvideo'] = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel, $config["per_page"], $data['page']);
			$getdafbimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, null, null, $config["per_page"], $bataslimit);
			$totaldata = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, null, null);
			$data['total_data'] = sizeof($totaldata);
		} else if ($idmapel > 0) {

			if ($kunci1 == null)
				$kunci1 = 1;
//			echo "HALAMAN:".$kunci0;
			$data['halaman'] = $kunci1;
			$data['asal'] = "mapelnya";
			$data['kuncine'] = "";
			$data['mapel'] = $idmapel;
			$jenjang = $this->M_bimbel->cekJenjangPendek($jenjangpendek);
			$data['jenjang'] = $jenjang[0]->id;
			//echo ("JP".$jenjangpendek);
			$bataslimit = $kunci1;
			if ($bataslimit >= 1)
				$bataslimit = ($bataslimit - 1) * $config['per_page'];

//			$data['asal'] = "mapelnya";
//			$jenjang = $this->M_bimbel->cekJenjangMapel($idmapel);
//			$data['jenjang'] = $jenjang[0]->id_jenjang;
//			$data['mapel'] = $idmapel;
//			$data['kuncine'] = $kunci1;

//			$data['dafvideo'] = $this->M_bimbel->getBimbelMapel($jenjangpendek, $idmapel, $config["per_page"], $data['page']);
			$getdafbimbel = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel, null, $config["per_page"], $bataslimit);
			$totaldata = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, $jenjang[0]->id, $idkelas, $idmapel);
			$data['total_data'] = sizeof($totaldata);
		}

		$data['page'] = $bataslimit;

		$data['dafplaylist'] = $getdafbimbel;

//
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


		$data['mapel'] = $idmapel;

		if ($kunci0 == "cari")
			$data['asal'] = "mapelcari";
		$data['jenjangpendek'] = $jenjangpendek;

		$data['kategori'] = 0;
		$data['dafjenjang'] = $this->M_bimbel->getJenjangBimbel();
		$data['dafkelas'] = $this->M_bimbel->getKelasBimbel();
		$data['dafmapel'] = $this->M_bimbel->dafMapelBimbel($jenjangpendek, $idkelas);
		$data['dafkategori'] = $this->M_bimbel->getKategoriAll();
		$data['message'] = $this->session->flashdata('message');
		//$data['total_data'] = $config['total_rows'];
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
		$data['iduser'] = null;

		$data['ambilpaket'] = $tstrata;
		$data['jenis'] = $jenis;
		$data['tunggubayar'] = $tunggubayar;


		$data['infoguru'] = $this->M_bimbel->getInfoGuru(null);
//			$data['dafvideo'] = $this->M_bimbel->getVodGuru($iduser);

		$data['iduser'] = null;
		$data['id_playlist'] = null;
//		$data['halaman'] = $data['page'];

		$this->load->view('layout/wrapper_umum', $data);
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
		$data = array();
		$data['konten'] = 'v_bimbelall';

		$kunci = htmlspecialchars($tekskunci);
		$data['message'] = "";

		$kodebeliakhir = "";

		if ($kunci == "") {
			$this->index();
		} else {

			$kunci = str_replace("dan", "", $kunci);

//			$data['dafvideo'] = $this->M_bimbel->getBimbelCari(0, 0, $kunci);

			//$data['dafvideo'] = $this->M_bimbel->getBimbelCari(0, 0, $kunci, $config["per_page"], $data['page']);

//						echo "<pre>";
//			echo var_dump($data['dafvideo']);
//			echo "</pre>";
//			echo "<br><br><br><br><br><br>".$jmldata;
//			die();


			$data['dafjenjang'] = $this->M_bimbel->getJenjangBimbel();
			$data['dafkategori'] = $this->M_bimbel->getKategoriAll();
			$data['dafkelas'] = $this->M_bimbel->getKelasAll();
			$data['mapel'] = "";
			$data['kuncine'] = $kunci;
			$data['jenjangpendek'] = "";
			$data['jenjang'] = 0;
			$data['kategori'] = 0;
			$data['asal'] = "cari";
			$data['njenjang'] = 0;
			$data['nkelas'] = 0;
			$data['nmapel'] = 0;

			$id_user = $this->session->userdata("id_user");

			$jenis = 3; ////// bimbel
			$strstrata = array("", "lite", "pro", "premium");
			$tglbatas = new DateTime("2020-01-01 00:00:00");

			///////////////////////////////////////////////////////////////////
			if ($this->session->userdata('loggedIn')) {
				$kodebeli = "belumpunya";
				$tstrata = 0;
				$expired = true;

				$id_user = $this->session->userdata("id_user");

				$this->load->Model('M_channel');
				$cekbeli = $this->M_channel->getlast_kdbeli($id_user, $jenis);
				$tunggubayar = false;

				if ($cekbeli) {
					$statusbayar = $cekbeli->status_beli;

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
					$this->load->Model('M_vksekolah');
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
				$id_user = 0;
				redirect("/");
			}

			////////////////////////////////////////////////////////////////////////////////////////

			$kunci = preg_replace('!\s+!', ' ', $kunci);
			$kunci = str_replace("%20%20", "%20", $kunci);
			$kunci = str_replace("%20", " ", $kunci);

			$dafplaylistall = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, null, null, null, $kunci);
			$jmldata = sizeof($dafplaylistall);

//			echo "<pre>";
//			echo var_dump($dafplaylistall);
//			echo "</pre>";
//			echo "<br><br><br><br><br><br>".$jmldata;
//			die();
			$config['total_rows'] = $jmldata;

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

			$data['total_data'] = $config['total_rows'];

			$tambahseg = 0;
			if (base_url() == "http://localhost/fordorum/") {
				$tambahseg = 0;
			}

			$data['page'] = ($this->uri->segment(4 + $tambahseg)) ? $this->uri->segment(4 + $tambahseg) : 0;


			if ($data['page'] >= 1)
				$data['page'] = ($data['page'] - 1) * $config['per_page'];

			$data['pagination'] = $this->pagination->create_links();

			//$dafplaylistall = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli);
			$dafplaylist = $this->M_bimbel->getDafPlayListBimbel($id_user, $kodebeli, null, null, null, $kunci, 8, $data['page']);
			$data['dafplaylist'] = $dafplaylist;
//
//			echo $id_user;
//			echo "<br>$kodebeli";
//			echo "<pre>";
//			echo var_dump($dafplaylist);
//			echo "</pre>";
//			die();

			$jmlaktif = 0;
			$jmlkeranjang = 0;
			foreach ($dafplaylistall as $datane) {
				if ($datane->link_paket != null || $datane->kode_beli != null || $datane->kode_beli2 != null)
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
			$data['tunggubayar'] = $tunggubayar;

			if ($kodebeliakhir != "")
				$kodebeli = $kodebeliakhir;
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
			$data['halaman'] = $hal;
			$this->load->view('layout/wrapper_umum', $data);

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

	public function get_autocomplete2()
	{
		if (isset($_GET['term'])) {
			$result = $this->M_bimbel->search_Bimbel($_GET['jenjang'], $_GET['kelas'], $_GET['mapel'], $_GET['kunci']);
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
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02') && $this->session->userdata('bimbel') != 2) {
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

	public function soal($opsi = null, $linklist = null, $kodeevent = null)
	{
		$strstrata = array("", "lite", "pro", "premium", "privat");
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

		//$cekpunyaku = $this->M_bimbel->getDafPlayListBimbelAll($linklist, "semua", $kodebeli, $id_user);
		$cekgurubimbel = $this->M_bimbel->getPaket($linklist);

		if ($kodeevent != null) {
			$cekevent = $this->M_channel->cekevent_pl_guru($kodeevent);
			if ($cekevent) {

			} else
				if ($kodeevent != "saya")
					redirect("/");
		} else
			$kodeevent = null;


		if ($opsi == "tampilkan") {
			$data = array();
			$data['konten'] = 'v_bimbel_soal';
			$paketsoal = $this->M_bimbel->getPaket($linklist);
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$data['judul'] = $paketsoal[0]->nama_paket;
			$data['dafsoal'] = $this->M_bimbel->getSoal($paketsoal[0]->id);
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $kodeevent;
			$data['asal'] = "owner";
		} else if ($opsi == "buat") {
			$data = array();
			$data['konten'] = 'v_bimbel_buatsoal';
			$paket = $this->M_bimbel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['dafsoal'] = $this->M_bimbel->getSoal($paket[0]->id);
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $kodeevent;
			$data['asal'] = "owner";
			if ($cekgurubimbel[0]->id_user != $id_user)
				redirect("/");
		} else if ($opsi == "seting") {
			$data = array();
			$data['konten'] = 'v_bimbel_soal_seting';
			$paketsoal = $this->M_bimbel->getPaket($linklist);
			$data['paket'] = $paketsoal;
			$dafsoal = $this->M_bimbel->getSoal($paketsoal[0]->id);
			$data['totalsoal'] = sizeof($dafsoal);
			$data['kodeevent'] = $kodeevent;
			$data['linklist'] = $linklist;
		} else if ($opsi == "kerjakan") {
			$data = array();
			$data['konten'] = 'v_bimbel_soal';
			$paketsoal = $this->M_bimbel->getPaket($linklist);
//			echo "<br><br><br><br><br><br><br>LINKLIST".$linklist;
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$data['judul'] = $paketsoal[0]->nama_paket;
			$data['dafsoal'] = $this->M_bimbel->getSoal($paketsoal[0]->id);
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $kodeevent;
			$data['asal'] = "menu";
		} else if ($opsi == "nilaisiswa") {
			if ($cekgurubimbel[0]->id_user != $id_user)
				redirect("/");
			$data = array();
			$data['konten'] = 'v_bimbel_soal_jsiswa';
			$nilai = $this->M_channel->getNilaiSiswaBimbel($linklist);
			if (!$nilai)
				$nilai = null;
			$paket = $this->M_bimbel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['dafuser'] = $nilai;
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $kodeevent;
		} else if ($opsi == null) {
			redirect("/bimbel/page/1");
		} else if ($opsi != "tampilkan") {
			$data = array();
			$data['konten'] = 'v_bimbel_mulai';
			$paketsoal = $this->M_bimbel->getPaket($opsi);
			$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
			$data['acaksoal'] = $paketsoal[0]->acaksoal;
			$dafsoal = $this->M_bimbel->getSoal($paketsoal[0]->id);
			$data['totalsoal'] = sizeof($dafsoal);
			$data['linklist'] = $opsi;
			$data['kodeevent'] = $kodeevent;
			$data['asal'] = $linklist;
		}

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function materi($opsi = null, $linklist = null, $linkevent = null)
	{
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
		//$cekpunyaku = $this->M_bimbel->getDafPlayListBimbelAll($linklist, "semua", $kodebeli, $id_user);
		$cekgurubimbel = $this->M_bimbel->getPaket($linklist);


		if ($linkevent != null) {
			$cekevent = $this->M_channel->cekevent_pl_guru($linkevent);
			if ($cekevent) {

			} else
				redirect("/");
		}
//		echo "<pre>";
//		echo var_dump($cekpunyaku);
//		echo "</pre>";


		if ($opsi == "buat") {
			$data = array();
			$data['konten'] = 'v_bimbel_buatmateri';
			$paket = $this->M_bimbel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$data['uraian'] = $paket[0]->uraianmateri;
			$data['file'] = $paket[0]->filemateri;
			$data['linklist'] = $linklist;
			if ($cekgurubimbel[0]->id_user != $id_user)
				redirect("/");

		} else if ($opsi == "tampilkan") {
			$data = array();
			$data['konten'] = 'v_bimbel_materi';
			$paket = $this->M_bimbel->getPaket($linklist);
			$data['judul'] = $paket[0]->nama_paket;
			$uraian = $paket[0]->uraianmateri;
			$parsed = $this->get_string_between($uraian, 'localhost', 'ref');


			$data['uraian'] = $paket[0]->uraianmateri;

			$data['file'] = $paket[0]->filemateri;
			$data['linklist'] = $linklist;
		}

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function tugas($opsi = null, $linklist = null, $idsiswa = null)
	{
		$strstrata = array("", "lite", "pro", "premium", "privat");
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
		//$cekpunyaku = $this->M_bimbel->getDafPlayListBimbelAll($linklist, "semua", $kodebeli, $id_user);
		$cekgurubimbel = $this->M_bimbel->getPaket($linklist);

		if ($opsi == "buat") {

			if ($cekgurubimbel[0]->id_user != $id_user && $idsiswa == null)
				redirect("/");

			if ($this->session->userdata("bimbel") == 3 || $idsiswa != null) {
				$expired = false;
			} else {
				$expired = true;
			}
			$data = array();
			$data['konten'] = 'v_bimbel_buattugas';
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

			// echo "<pre>";
			// echo var_dump ($paket);
			// echo "</pre>";
			

			$data['judul'] = $paket->nama_paket;
			$data['uraian'] = $paket->tanyatxt;
			$data['file'] = $paket->tanyafile;
			$data['linklist'] = $linklist;
			$data['kodeevent'] = $idsiswa;
			if ($idsiswa != null) {
				$cekevent = $this->M_channel->cekevent_pl_guru($idsiswa);
				if ($cekevent) {

				} else
					redirect("/");
			}
			$expired = true;
			$this->load->view('layout/wrapper_umum', $data);
		} else if ($opsi == "tampilkan") {

			if ($this->session->userdata("bimbel") == 3 || $idsiswa != null) {
				$expired = false;
			} else {
				$expired = true;
			}

			$data = array();
			$data['konten'] = 'v_bimbel_tugas';
			$paket = $this->M_bimbel->getTugas($linklist);
			if ($idsiswa != null && $idsiswa != "saya")
				$alamat = "/" . $idsiswa;
			else
				$alamat = "";
			if (!$paket || $paket->tanyatxt == "")
				redirect(base_url() . "bimbel/tugas/buat/" . $linklist . $alamat);
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
			$data['kodeevent'] = $idsiswa;
			if ($idsiswa != null) {
				$cekevent = $this->M_channel->cekevent_pl_guru($idsiswa);
				if ($cekevent) {

				} else if ($idsiswa != "saya")
					redirect("/");
			}

		} else if ($opsi == "kerjakan") {
			if ($cekbeli->strata_paket < 2)
				redirect("/");
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

			if ($this->session->userdata('a01') || ($this->session->userdata('sebagai') == 4 &&
					$this->sessiono->userdata('verifikator') == 3))
				$expired = false;

			$data = array();
			$data['konten'] = 'v_bimbel_tugaskerjakan';
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
			if ($this->session->userdata("bimbel") == 3) {
				$expired = false;
			} else {
				$expired = true;
			}

			$data = array();
			$data['konten'] = 'v_bimbel_responguru';
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


			$data = array();
			$data['konten'] = 'v_bimbel_jawabansaya';
			$tugasguru = $this->M_bimbel->getTugas($linklist);
			$data['tugasguru'] = $tugasguru;
			$idtugasguru = $tugasguru->id_tugas;
			$tugassiswa = $this->M_bimbel->getTugasSiswa($idtugasguru, $id_user);

			$data['tugassiswa'] = $tugassiswa;
			$data['id_tugas'] = $idtugasguru;
			$data['linklist'] = $linklist;
		}

		if ($expired == false) {

			$this->load->view('layout/wrapper_tabel', $data);
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
		if ($jmlsoalkeluar == 0)
			$jmlsoalkeluar = 1;
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
			$tgl_sekarang = new DateTime();
			$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$data['modified'] = $tgl_sekarang->format("Y-m-d H-i:s");
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

	public function updateseting($linklist, $kodeevent = null)
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

			if ($kodeevent != null)
				$alamat = "/" . $kodeevent;
			else
				$alamat = "";

			if ($this->M_bimbel->updateseting($data, $linklist))
				redirect('bimbel/soal/buat/' . $linklist . $alamat);
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
			$tgl_sekarang = new DateTime();
			$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$data['modified'] = $tgl_sekarang->format("Y-m-d H-i:s");
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
		if ($this->M_bimbel->updatetugas($data, 3, $linklist)) {
			$data2 = array();
			if ($tekssoal != "") {
				$data2['statustugas'] = 1;
				if ($this->M_bimbel->updatemateri($data2, $linklist))
					echo "sukses";
				else
					echo "gagal";
			} else {
				$data2['statustugas'] = 0;
				if ($this->M_bimbel->updatemateri($data2, $linklist))
					echo "sukses";
				else
					echo "gagal";
			}

		} else
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
		else if ($opsi == "event")
			$opsi = "event";
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

			if ($this->session->userdata('bimbel') == 2 || $opsi=="event") {
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
		$jmlmodul = 1;

		if ($this->session->userdata('loggedIn')) {
			$id_user = $this->session->userdata("id_user");
			$this->load->Model('M_channel');
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, 3);
			if ($cekbeli) {
				$tglbatas = new DateTime($cekbeli->tgl_batas);
				$jmlmodul = $cekbeli->jml_modul;
				if ($jmlmodul == 0) {
//					$this->load->Model('M_eksekusi');
					$getstandar = $this->M_bimbel->gethargapaket("bimbel");
					$strata = $cekbeli->strata_paket;
					if ($strata == 1)
						$jmlmodul = $getstandar['njudul_lite'];
					else if ($strata == 2)
						$jmlmodul = $getstandar['njudul_pro'];
					else if ($strata == 3)
						$jmlmodul = $getstandar['njudul_premium'];
				}

				$rupiahbruto = $cekbeli->rupiah / $jmlmodul;
			}
		} else {
			$id_user = 0;
		}

		if ($cekbeli->status_beli == 1) {
			$cekbeli = $this->M_channel->getlast_kdbeli($id_user, 3, 2);
			$tglbatas = new DateTime($cekbeli->tgl_batas);
			$jmlmodul = $cekbeli->jml_modul;
			$rupiahbruto = 0;
			echo "gagal";
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

				$getinfopaket = $this->M_channel->getInfoBimbel($datane->link_list);

				$this->load->model('M_eksekusi');
				$hargastandar = $this->M_eksekusi->getStandar();
				$this->load->model('M_vksekolah');
				$hargapaket = $this->M_vksekolah->gethargapaket("bimbel");

				////////////////////////////// CEK POTONGAN MIDTRANS //////////////////
				$tipebayar = $cekbeli->tipe_bayar;
				if ($tipebayar == "alfa")
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

				$data[$a]['rp_bruto'] = $rupiahbruto;
				$data[$a]['rp_midtrans'] = $potonganmidtrans;
				$rupiahbruto = $rupiahbruto - $potonganmidtrans;
				$rupiahppn = $rupiahbruto * $ppn / 100;
				$data[$a]['rp_ppn'] = $rupiahppn;
				$rupiahnet = $rupiahbruto - $rupiahppn;
				$data[$a]['rp_net'] = $rupiahnet;

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
				$data[$a]['id_kontri'] = $idkontributor;
				$data[$a]['rp_kontri_bruto'] = $kontribruto;
				$data[$a]['rp_kontri_pph'] = $kontripph;
				$data[$a]['rp_kontri_net'] = $kontrinet;

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
					$data[$a]['id_ag'] = $idagency;
					$data[$a]['rp_ag_bruto'] = $agencybruto;
					$data[$a]['rp_ag_pph'] = $agencypph;
					$data[$a]['rp_ag_net'] = $agencynet;
				} else {
					$data[$a]['id_ag'] = 0;
					$data[$a]['rp_ag_bruto'] = 0;
					$data[$a]['rp_ag_pph'] = 0;
					$data[$a]['rp_ag_net'] = 0;
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
					$data[$a]['id_am'] = 0;
					$data[$a]['rp_am_bruto'] = 0;
					$data[$a]['rp_am_pph'] = 0;
					$data[$a]['rp_am_net'] = 0;
				}


				//////////////////TV SEKOLAH///////////////////
				$pphtv = $hargastandar->pph_npwp;
				$feetv = 100 - ($feetutor + $feeagency + $feeam);
				$tvbruto = $rupiahnet * $feetv / 100;
				$tvpph = $tvbruto * $pphtv / 100;
				$tvnet = $tvbruto - $tvpph;
				//--------------------------------------------//
				$data[$a]['rp_manajemen_bruto'] = $tvbruto;
				$data[$a]['rp_manajemen_pph'] = $tvpph;
				$data[$a]['rp_manajemen_net'] = $tvnet;

			}

			if ($this->M_bimbel->insertvk($id_user, $data))
				echo "sukses";
			else
				echo "gagal";

		}
	}


	public function pilih_paket($linklist = null)
	{
		$this->load->model('M_bimbel');
		$data = array();
		$data['konten'] = 'v_bimbel_belipaket';

		$data['harga'] = $this->M_bimbel->gethargapaket("bimbel");
		$data['upgrade'] = "tidak";

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
						// $this->payment->tunggubayar();
					}

				}
			}
		}

		$this->load->view('layout/wrapper_payment', $data);
	}

	public function pilih_eceran($link_list)
	{
		$this->session->unset_userdata('shared');
		$iduser = $this->session->userdata('id_user');

		$dibeli = "-";
		$this->load->model('M_bimbel');
		$getdatabeli = $this->M_bimbel->cekvklinklist($iduser, $link_list);
		if($getdatabeli)
		{
			if (substr($getdatabeli[0]->kode_beli,0,5)=="PKT31")
				$dibeli = "Paket Lite";
			else if (substr($getdatabeli[0]->kode_beli,0,5)=="PKT32")
				$dibeli = "Paket Pro";
			else if (substr($getdatabeli[0]->kode_beli,0,5)=="PKT33")
				$dibeli = "Paket Premium";
			else if (substr($getdatabeli[0]->kode_beli,0,5)=="ECR33")
				$dibeli = "Eceran Premium";
			else if (substr($getdatabeli[0]->kode_beli,0,5)=="ECR34")
			{
				$dibeli = "Eceran Privat";
				redirect("bimbel/get_bimbel/$link_list");
			}
		}

		$data = array();
		$data['konten'] = 'v_bimbel_belieceran';
		$data['dibeli'] = $dibeli;
		$data['harga'] = $this->M_bimbel->gethargapaket("bimbel");
		$data['linklist'] = $link_list;

		$this->load->view('layout/wrapper_payment', $data);
	}

	function get_string_between($string, $start, $end)
	{
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}

	public function jitsi($jenis, $kodelink)
	{
		$data = array('title' => 'Pilih Paket', 'menuaktif' => '',
			'isi' => 'v_jitsi');
		$this->load->model('M_channel');

		if ($jenis == "sekolah")
			$jenis = 1;
		else if ($jenis == "lain")
			$jenis = 2;
		else if ($jenis == "bimbel")
			$jenis = 3;

		$idsaya = $this->session->userdata('id_user');
		$getpaket = $this->M_channel->getInfoBeliPaket($idsaya, $jenis, $kodelink);
		//echo "<br><br><br><br><br><br><br><br><br>";
		//echo var_dump($getpaket);
		if ($getpaket) {
			$idkontributor = $getpaket->id_kontri;
			$iduserbeli = $getpaket->id_user;
			$batasaktif = $getpaket->tgl_batas;
			$data['nama_paket'] = $getpaket->nama_paket;
			$data['koderoom'] = "";

			$tglkode = substr($getpaket->tglkode, 0, 10);
			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang = $datesekarang->format('Y-m-d');
			$tglsekarangfull = $datesekarang->format('Y-m-d H:i:s');

			if ($idsaya == $idkontributor) {
				$data['statusvicon'] = "moderator";
				if ($tglsekarang == $tglkode && $getpaket->koderoom != "") {
					$data['koderoom'] = $getpaket->koderoom;
				} else {
					$set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$code = substr(str_shuffle($set), 0, 10);
					$code2 = substr(str_shuffle($set), 0, 10);
					$data2 = array('koderoom' => $code,
						'kodepassvicon' => $code2,
						'tglkode' => $tglsekarangfull);
					if ($jenis == 3)
						$this->M_channel->updateDurasiBimbel($kodelink, $data2);
					else
						$this->M_channel->updateDurasiPaket($kodelink, $data2);
					$data['koderoom'] = $code;
				}
			} else if ($idsaya == $iduserbeli) {
				$data['statusvicon'] = "siswa";
				if ($tglsekarang == $tglkode) {
					$data['koderoom'] = $getpaket->koderoom;
				}
			}
			//echo "KONTRI:".$idkontributor.", YGBELI:".$iduserbeli." , BATAS:".$batasaktif;
		} else {
			$data['nama_paket'] = "";
			$data['statusvicon'] = "outside";
			$data['koderoom'] = "outside";
		}


		$data['jenis'] = $jenis;
		$data['kodelink'] = $kodelink;

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper2', $data);
	}

	public function setpassword($jenis, $kodelink)
	{
		$idsaya = $this->session->userdata('id_user');
		$this->load->model('M_channel');
		$getpaket = $this->M_channel->getInfoBeliPaket($idsaya, $jenis, $kodelink);
		//echo "<br><br><br><br><br><br><br><br><br>";
		//echo var_dump($getpaket);
		if ($getpaket) {
			$idkontributor = $getpaket->id_kontri;
			$iduserbeli = $getpaket->id_user;
			$kodepassvicon = $getpaket->kodepassvicon;
			if ($idsaya == $idkontributor) {
				$data['statusvicon'] = "moderator";
			} else if ($idsaya == $iduserbeli) {
				$data['statusvicon'] = "siswa";
			}
			echo $kodepassvicon;
		} else {
			echo "outside";
		}
	}

	public function inputplaylist_bimbel($kodepaket = null, $kodeevent = null)
	{

		if ($kodeevent == null && (!$this->session->userdata('a03') && !$this->session->userdata('a02')
				&& !$this->session->userdata('bimbel'))) {
			redirect('/');
		}
		$data = array();
		$data['konten'] = 'v_channel_inputplaylist_bimbel';
		$this->load->model('M_channel');
		$id_user = $this->session->userdata('id_user');

		$data['dafvideo'] = $this->M_channel->getVideoBimbel($id_user, $kodepaket, $kodeevent);

		if (!$kodepaket == null)
			$data['kode_paket'] = $kodepaket;
		else
			$data['kode_paket'] = "0";


		$data['linklist_event'] = $kodeevent;
		if ($kodeevent == null) {
			$data['judulevent'] = "";
			$data['subjudulevent'] = "";
		} else {
			$this->load->model('M_channel');
			$cekevent = $this->M_channel->cekevent_pl_guru($kodeevent);
			if ($cekevent) {
				$data['judulevent'] = $cekevent->nama_event;
				$data['subjudulevent'] = $cekevent->sub2_nama_event;
				$id_event = $cekevent->id_event;
			} else
				redirect("/");
		}

		$this->load->view('layout/wrapper_tabel', $data);

	}

	public function urutanplaylist_bimbel($kodepaket = null)
	{
		if (!$this->session->userdata('a03') && !$this->session->userdata('a02')) {
			redirect('/');
		}
		$data = array();
		$data['konten'] = 'v_channel_urutanplaylist_bimbel';
		$this->load->model('M_channel');
		$id_user = $this->session->userdata('id_user');
		$data['dafvideo'] = $this->M_channel->getVideoBimbelPaket($id_user, $kodepaket);

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper_tabel', $data);

	}

	public function editplaylist_bimbel($kodepaket = null, $linklist = null)
	{
		if ($linklist == null && (!$this->session->userdata('a03') && !$this->session->userdata('a02') && $this->session->userdata('bimbel') != 3 && $this->session->userdata('bimbel') != 4)) {
			redirect('/');
		}
		$data = array();
		$data['konten'] = 'v_channel_tambahplaylist_bimbel';
		$data['addedit'] = "edit";

		$this->load->model('M_channel');
		$data['datapaket'] = $this->M_channel->getInfoBimbel($kodepaket);

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

		if ($linklist == null) {
			$data['judulevent'] = "";
			$data['subjudulevent'] = "";
		} else {
			$this->load->model('M_channel');
			$cekevent = $this->M_channel->cekevent_pl_guru($linklist);
			if ($cekevent) {
				$data['judulevent'] = $cekevent->nama_event;
				$data['subjudulevent'] = $cekevent->sub2_nama_event;
				$id_event = $cekevent->id_event;
			} else
				redirect("/");
		}


		$this->load->view('layout/wrapper_umum', $data);
	}

	public function addplaylist_bimbel()
	{
		$data = array();
		$data['nama_paket'] = $_POST['ipaket'];
		$data['deskripsi_paket'] = $_POST['ideskripsi'];
		$data['semester'] = $_POST['isemester'];
		$data['tanggal_tayang'] = $_POST['datetime'];
		$data['id_jenjang'] = $_POST['ijenjang'];
		if ($data['id_jenjang'] == 5 || $data['id_jenjang'] == 6)
			$data['id_jurusan'] = $_POST['ijurusan'];
		else
			$data['id_jurusan'] = 0;
		$data['id_kelas'] = $_POST['ikelas'];
		$data['id_mapel'] = $_POST['imapel'];
		$linklist_event = $_POST['linklist_event'];
		$this->load->model('M_channel');

		if ($linklist_event != null) {
			$judulevent = $this->M_channel->cekevent_pl_guru($linklist_event);
			$data['id_event'] = $judulevent->id_event;
		}

		$this->load->model('M_channel');

		if ($_POST['addedit'] == "add") {
			$data['link_list'] = base_convert(microtime(false), 10, 36);
			$data['durasi_paket'] = '00:00:00';
			$data['status_paket'] = '0';
			$data['id_user'] = $this->session->userdata('id_user');
			$data['npsn_user'] = $this->session->userdata('npsn');
			$this->M_channel->addplaylist_bimbel($data);
		} else {
			$link_list = $_POST['linklist'];
			$this->M_channel->updatePlaylist_bimbel($link_list, $data);
		}


		if ($linklist_event == null)
			redirect('virtualkelas/bimbel');
		else
			redirect('virtualkelas/bimbel/' . $linklist_event);
	}

	public function setjadwalvicon_bimbel($kodelink, $opsi = null)
	{
		$data = array();
		$data['konten'] = 'v_channel_setjadwalvicon_bimbel';
		$data['opsi'] = $opsi;
		$this->load->Model('M_channel');
		$data['datapaket'] = $this->M_channel->getInfoBimbel($kodelink);

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function savejadwalvicon_bimbel($opsi = null)
	{
		$linklist = $this->input->post('linklist');
		$tglvicon = $this->input->post('datetime') . ":00";
		$data = array();
		$data['tglvicon'] = $tglvicon;
		$this->load->model('M_channel');
		$this->M_channel->updateDurasiBimbel($linklist, $data);
		if ($opsi != null)
			redirect("/bimbel/modul_saya");
		else
			redirect("/virtualkelas/bimbel");
	}

	public function hapusplaylist_bimbel($kodepaket = null, $kodeevent = null)
	{
		$this->load->model('M_channel');
		$infopaket = $this->M_channel->getInfoBimbel($kodepaket);

		$cekid = $infopaket->id_user;

		if ($cekid == $this->session->userdata('id_user')) {

			$this->load->model('M_channel');

			$idvideo = $this->M_channel->getPlayListBimbelAll($kodepaket);
			$jmldata = 0;
			foreach ($idvideo as $datane) {
				$jmldata++;
				$data['id_video'][$jmldata] = $datane->id_video;
				$data['dilist'][$jmldata] = $datane->dilist;
			}

			if ($jmldata > 0)
				$this->M_channel->delPlayListBimbel($kodepaket, $data);
			else
				$this->M_channel->delPlayListBimbel($kodepaket, 0);

			redirect('/virtualkelas/bimbel/' . $kodeevent);
		} else {
			redirect('/');
		}

	}

	public function lihatmodul($linklist = null, $linklistevent = null, $iduserolehadmin = null)
	{
		$opsi = "bimbel";
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		$data = array();
		$data['konten'] = "v_bimbel_lihat_modul";

		$this->load->Model('M_channel');
		$iduser = $this->session->userdata('id_user');
		$paketsoal = $this->M_channel->cekModul("bimbel", $linklist);
		$infopaket = $this->M_channel->getInfoBimbel($linklist);
		$idkontri = $infopaket->id_user;
		$npsnpaket = $infopaket->npsn_user;

		if ($this->session->userdata('bimbel') < 3 && !$this->session->userdata('a01'))
			redirect("/");

		$tjenis = array("sekolah" => 1, "lain" => 2, "bimbel" => 3);
		$jenischat = $tjenis["bimbel"];

//		if ($npsnpaket==$this->session->userdata('npsn'))
//			$jenischat = 2;

		$data['datapesan'] = $this->M_channel->getChat($jenischat, null, $linklist);
		$data['dafplaylist'] = $this->M_channel->getDafPlayListModul($opsi, $linklist, $iduserolehadmin);

		if ($data['dafplaylist']) {
			$data['punyalist'] = true;
			$data['playlist'] = $this->M_channel->getPlayListModul($opsi, $linklist);
		} else {
			$data['punyalist'] = false;
		}

//		echo "<pre>";
//		echo var_dump($data['dafplaylist']);
//		echo "</pre>";
//		die();
		$data['namapaket'] = $paketsoal[0]->nama_paket;
		$data['namasekolah'] = "Topik " . $paketsoal[0]->nama_paket . "";
		$this->load->model('M_vksekolah');
		$data['infoguru'] = $this->M_vksekolah->getInfoGuru($iduser);
		$data['linklist'] = $linklist;
		$data['linklistevent'] = $linklistevent;

		if ($linklistevent != null && !$this->session->userdata("a01")) {
			$cekevent = $this->M_channel->cekevent_pl_guru($linklistevent);
			if ($cekevent) {

			} else
				redirect("/");
		} else if ($this->session->userdata("a01"))
		{
			$data["iduserolehadmin"] = $iduserolehadmin;
		}

		$data['jenis'] = $opsi;
		$data['npsn'] = $this->session->userdata('npsn');
		$data['asal'] = "menu";

		$data['iduser'] = $iduser;
		$data['idku'] = $iduser;
		$data['id_playlist'] = $linklist;

		$getpaket = $this->M_channel->getInfoBeliPaket($iduser, $jenischat, $linklist);

		if ($getpaket) {
			$idkontributor = $getpaket->id_kontri;
			$iduserbeli = $getpaket->id_user;
			$batasaktif = $getpaket->tgl_batas;

			$tglkode = substr($getpaket->tglkode, 0, 10);
			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang = $datesekarang->format('Y-m-d');
			$tglsekarangfull = $datesekarang->format('Y-m-d H:i:s');
			if (strtotime($tglsekarangfull) <= strtotime($batasaktif)) {
				$data['adavicon'] = "ada";
			} else {
				$data['adavicon'] = "tidak";
			}

			//echo "KONTRI:".$idkontributor.", YGBELI:".$iduserbeli." , BATAS:".$batasaktif;
		} else
			$data['adavicon'] = "tidak";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function modul_saya($linklist = null)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		if ($this->session->userdata('a02'))
			$cekuser = 2;
		else
			$cekuser = 2;
		$this->load->model('M_channel');
		$data = array();

		if ($this->session->userdata("loggedIn")) {
			$iduser = $this->session->userdata("id_user");

		} else {
			$kodebeli = '-';
			$jenis = 0;
			$iduser = 0;
		}

		if ($this->session->userdata('a01'))
		{
			if ($linklist==null)
				redirect("/profil");
			$iduser = $linklist;
			$data['konten'] = 'v_bimbel_modul_saya';
		}
		else {

			if ($linklist == null || $linklist == "tampilkan") {
				$data['konten'] = 'v_bimbel_modul_saya';
			}
		}


		$kd_user = $iduser;//substr($kodeusr, 5);
		$npsn = "";
		$data['kdusr'] = "orang";

		if ($this->session->userdata('loggedIn')) {
			$npsn = $this->session->userdata('npsn');

			if ($this->session->userdata('id_user') == $kd_user)
				$data['kdusr'] = "pemilik";
		}

		$data['dafplaylist'] = $this->M_channel->getDafBimbelSaya($kd_user);

		if (sizeof($data['dafplaylist']) == 0 && $linklist!="tampilkan")
			redirect("/virtualkelas/bimbel");

//		 echo "<pre>";
//		 echo var_dump ($data['dafplaylist']);
//		 echo "</pre>";
//		 die();

		if ($data['dafplaylist']) {
			$data['punyalist'] = true;
			$statusakhir = $data['dafplaylist'][0]->link_list;
			if ($linklist == null) {
				$data['playlist'] = $this->M_channel->getPlayListBimbelSaya($statusakhir, $kd_user);

			} else {
				$data['playlist'] = $this->M_channel->getPlayListBimbelSaya($linklist, $kd_user);

			}


		} else {
//            $data['playlist'] = $this->M_channel->getPlayListGuru($kd_user);
			$data['punyalist'] = false;
//			if (!$this->session->userdata('loggedIn')) {
//				redirect('/');
//			}
		}


		$data['infoguru'] = $this->M_channel->getInfoGuru($kd_user);
		$data['dafvideo'] = $this->M_channel->getVodGuru($kd_user);

		$data['kd_user'] = $kd_user;
		$data['id_playlist'] = $linklist;

		$this->session->set_userdata('asalpaket', 'channel');
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function modul_aktif_bimbel($linklist)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		$id_user = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$jenis = 3;

		$data = array();

		$data['konten'] = 'v_bimbel_aktif';
		$dafmodul = $this->M_bimbel->getDafModulBimbel($linklist);
		$data['dafplaylist'] = $dafmodul;
		$data['ambilpaket'] = "premium";
		$tanggalvicon = $dafmodul[0]->tglvicon;
		if ($tanggalvicon == "2021-01-01 00:00:00") {
			$tanggalvicon = "Belum ditentukan";
			$displayjitsi = "display:none;";
		} else {
			$tanggalvicon = jamnamabulan_pendek($dafmodul[0]->tglvicon);
			$displayjitsi = "";
		}

		$data['tglvicon'] = $tanggalvicon;
		$data['displayjitsi'] = $displayjitsi;

//		 echo "<pre>";
//		 echo var_dump ($dafmodul);
//		 echo "</pre>";
//		 die();

		$data['dafstatus'] = true;
		$data['npsn'] = "saya";
		$data['playlist'] = $this->M_bimbel->getPlayListBimbel($linklist, $id_user);
		$data['id_playlist'] = $linklist;
		$this->load->Model('M_channel');
		$data['datapesan'] = $this->M_channel->getChat("bimbel", $npsn, $linklist);
		$data['namasekolah'] = "";
		$data['idku'] = $this->session->userdata('id_user');
		$data['jenis'] = "bimbel";

		////////// UNTUK JITSI ///////////
		$data['koderoom'] = "";
		$idkontributor = 0;
		$data['nama_paket'] = "";
		$tglkode = "2021-01-01 00:00:00";
		$tglvicon = "2021-01-01 00:00:00";

		if ($dafmodul) {
			$idkontributor = $dafmodul[0]->id_user;
			$data['nama_paket'] = $dafmodul[0]->nama_paket;
			$tglkode = substr($dafmodul[0]->tglkode, 0, 10);
			$tglvicon = substr($dafmodul[0]->tglvicon, 0);
		}
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $datesekarang->format('Y-m-d');
		$tglsekarangfull = $datesekarang->format('Y-m-d H:i:s');

		if ($id_user == $idkontributor) {
			$data['statusvicon'] = "moderator";
			if ($tglsekarang == $tglkode && $dafmodul[0]->koderoom != "") {
				$data['koderoom'] = $dafmodul[0]->koderoom;
				if (strtotime($tglsekarangfull) <= strtotime($tglvicon))
					$data['koderoom'] = "";

			} else {
				$set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$code = substr(str_shuffle($set), 0, 10);
				$code2 = substr(str_shuffle($set), 0, 10);
				$data2 = array('koderoom' => $code,
					'kodepassvicon' => $code2,
					'tglkode' => $tglsekarangfull);
				if ($jenis == 3)
					$this->M_channel->updateDurasiBimbel($linklist, $data2);
				else
					$this->M_channel->updateDurasiPaket($linklist, $data2);
				$data['koderoom'] = $code;
			}
		} else {
			$data['statusvicon'] = "siswa";
//			echo $tglsekarang;
////			echo "---";
////			echo $tglkode;
			if ($tglsekarang == $tglkode) {
				$data['koderoom'] = $dafmodul[0]->koderoom;
			}
		}

		//$data['jenis'] = $jenis;
		$data['kodelink'] = $linklist;

		$this->session->set_userdata('asalpaket', 'channel');
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function cekvicon($linklist = null)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		$id_user = $this->session->userdata('id_user');

		$this->load->Model("M_bimbel");
		$paket = $this->M_bimbel->getPaket($linklist);
//		echo "<pre>";
//		echo var_dump($dafmodul);
//		echo "</pre>";
//		die();
		$koderoom = $paket[0]->koderoom;
		$hasil = "on";
		if ($koderoom == "")
			$hasil = "off";
		echo json_encode($hasil);
	}

	public function akhirivicon($linklist)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}
		if ($this->session->userdata('bimbel') == 3) {
//			$this->load->Model('M_vksekolah');
			$this->M_bimbel->resettglvicon($linklist);
		}
		redirect(base_url() . "bimbel/modul_saya");
	}

}
