<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login');
		$this->load->library('email');
		$this->load->library('midtrans');
		$this->load->library('Pdf');
		$this->load->library('upload');
		$this->load->helper(array('url', 'tanggalan', 'Form', 'Cookie', 'download', 'statusverifikator'));

		if (base_url() == "https://tutormedia.net/_tv_sekolah/" || base_url() == "http://localhost/fordorum/"
			|| base_url() == "http://localhost/tvsekolah2/" || $this->session->userdata('npsn') == "1234567890" || $this->session->userdata('npsn') == "1234567891") {
			$params = array('server_key' => 'SB-Mid-server-dQDHk1T4KGhT9kh24H46iyV-', 'production' => false);
		} else {
			$params = array('server_key' => 'Mid-server-GCS0SuN6kT7cH0G5iTey_-Ct', 'production' => true);
		}
		$this->midtrans->config($params);

		if (!$this->session->userdata('loggedIn'))
			redirect('/');
	}

	public function index()
	{
		$statususer = getstatususer();

		$getdonasi = $this->M_login->getdonasi($this->session->userdata('id_user'));
		if (sizeof($getdonasi) > 0)
			$this->session->set_userdata('pernahdonasi', true);

		if ($this->session->userdata('sebagai') != 2 && $statususer['npwp'] == null)
			redirect("/login/profile");

		if ($this->session->userdata('activate') == 0) {
			if ($this->session->userdata('bimbel') == 1 && $this->session->userdata('sebagai') == 3)
				redirect("/login/profile_umum/tutor");
			else
				redirect("/login/sebagai");
		} else if ($statususer['gender'] == null)
			redirect("/login/profile");
		else if (($this->session->userdata('bimbel') == 2 || $this->session->userdata('siae') == 2
			|| $this->session->userdata('siam') == 2)
			&& $this->session->userdata('sebagai') == 3) {
			$iduser = $this->session->userdata("id_user");
			$this->load->Model('M_assesment');
			$dafnilai = $this->M_assesment->getNilai($iduser);
			if ($dafnilai) {
				$data['dafnilai'] = $dafnilai;
				if ($dafnilai[0]->essaytxt != "" && $dafnilai[0]->nilaitugas1 != null && $dafnilai[0]->nilaitugas2 != null) {
					$this->profil_diri();
				}
				else
					redirect("/assesment");
			}
		}
		else if ( $this->session->userdata('siag') == 2 && $this->session->userdata('sebagai') == 3) {
			if (base_url() == "http://localhost/tvsekolah2/")
				$urltambahan = "/tvsekolah2";
			else if (base_url() == "https://tvsekolah.id/")
				$urltambahan = "";
			else if (base_url() == "https://tutormedia.net/tvsekolahbaru/")
				$urltambahan = "/tvsekolahbaru";
			$filename = $_SERVER['DOCUMENT_ROOT'] . $urltambahan . "/uploads/agency/dok_agency_" .
				$this->session->userdata('id_user');
			if (file_exists($filename . ".jpeg") || file_exists($filename . ".jpg") ||
				file_exists($filename . ".png") || file_exists($filename . ".bmp")) {
				redirect("informasi/tungguhasilagency");
			} else {
				redirect("/login/profile");
			}

		} else if ($this->session->userdata('a01'))
			$this->dashboard_admin();
		else if ($this->session->userdata('siag') == 3)
			$this->dashboard_agency();
		else if ($this->session->userdata('sebagai') == 1 && ($this->session->userdata('verifikator') == 3
				|| $this->session->userdata('bimbel') == 4))
			$this->dashboard_verifikator();
		else if ($this->session->userdata('sebagai') == 1 && ($this->session->userdata('verifikator') == 2))
			$this->dashboard_calonverifikator();
		else if ($this->session->userdata('sebagai') == 1 && ($this->session->userdata('kontributor') == 2))
			// $this->dashboard_calonkontributor();
			$this->profil_diri();
		else if ($this->session->userdata('sebagai') == 2 && $statususer['kelasku'] == "0")
			redirect("/login/profile/kelasuser");
		else if ($this->session->userdata('sebagai') == 0)
			redirect("/login/sebagai");
		else
			$this->profil_diri();
	}

	public function profil_diri()
	{
		if ($this->session->userdata('sebagai') == 1 && ($this->session->userdata('verifikator') == 2))
			$this->dashboard_calonverifikator();
		
		$getstatus = getstatususer();
		$data = array();
		$data['konten'] = "profil_diri";
		$data['profilku'] = $this->ambilprofil();

		$npsn = $this->session->userdata('npsn');

		$kadaluwarsa = 0;
		$telat2bulan = 0;
		$veraktif = 0; //asumsi awal verifikator gak ada
		$referrer = $getstatus['referrer'];

		if ($npsn==null)
		$npsn = "9999099999";
		$this->load->Model('M_eksekusi');
		$dataverifikator = $this->M_eksekusi->getveraktif($npsn);
		$datacalonverifikator = $this->M_eksekusi->getcalonveraktif($npsn, $referrer);

		// echo "<br><br><br><br><br><pre>";
		// echo var_dump ($dataverifikator);
		// echo "</pre>";
		// echo $dataverifikator->npsn;

		if ($dataverifikator) {
			$veraktif = 2; //verifikator ditemukan aktif
			$cekkadaluwarsa = $this->M_eksekusi->getchanelkadaluwarsa($npsn);
			$cekbayarakhir = $this->M_eksekusi->getlastverbayar($dataverifikator->id);

			// echo $dataverifikator->id."--";
			// echo "<pre>";
			// echo var_dump ($cekkadaluwarsa);
			// echo "</pre>";

			$data['namaverifikator'] = $dataverifikator->first_name . " " . $dataverifikator->last_name;
			$data['telpverifikator'] = $dataverifikator->hp;
			$data['emailverifikator'] = $dataverifikator->email;
			
			$tgl_kadaluwarsa = $cekkadaluwarsa->kadaluwarsa;
			if ($tgl_kadaluwarsa=="0000-00-00 00:00:00")
			{
				$kadaluwarsa = 1;
			}
			else
			{
				$bataskadaluwarsa = new DateTime($tgl_kadaluwarsa);
				$bataskadaluwarsa = $bataskadaluwarsa->modify('first day of this month');
				$bataskadaluwarsa = $bataskadaluwarsa->modify('+1 month');
				$bataskadaluwarsa = $bataskadaluwarsa->format ("Y-m-d");
				date_default_timezone_set('Asia/Jakarta');
				$now = new DateTime();
				$tglsekarang = $now->format ("Y-m-01");
				
				if (strtotime($bataskadaluwarsa)<=strtotime($tglsekarang))
				{
					$kadaluwarsa = 1;
				}
			}

			if ($cekbayarakhir)
			{
				$tgl_akhir = $cekbayarakhir[0]->tgl_berakhir;
				$batas2bulan = new DateTime($tgl_akhir);
				$batas2bulan = $batas2bulan->modify('first day of this month');
				$batas2bulan = $batas2bulan->modify('+2 month');
				$batas2bulan = $batas2bulan->format ("Y-m-d");
				date_default_timezone_set('Asia/Jakarta');
				$now = new DateTime();
				$tglsekarang = $now->format ("Y-m-01");
				if (strtotime($batas2bulan)<=strtotime($tglsekarang))
				{
					$telat2bulan = 1;
				}
			}
			else
			{
				$telat2bulan = 1;
			}
				
			if ($kadaluwarsa==1 && $telat2bulan==1)
				$veraktif = 1;  //adaver tapi gak produktif
		}
		else if ($datacalonverifikator) 
		{
			$veraktif = 3 ;  //event calon verifikator
		}

		$data['verifikator_aktif'] = $veraktif;

		$this->load->view('layout/wrapper_profil', $data);
	}

	public function dashboard_calonverifikator()
	{
		$data = array();
		$data['konten'] = "profil_calonverifikatoroke";
		$data['profilku'] = $this->ambilprofil();

		$this->load->view('layout/wrapper_profil', $data);
	}

	public function upgradever()
	{
		$iduser = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');

		$veraktif = 0;
		$idverlama = 0;

		$this->load->Model('M_eksekusi');
		$dataverifikator = $this->M_eksekusi->getveraktif($npsn);

		if ($dataverifikator) {
			$idverlama = $dataverifikator->id;
			$veraktif = 2; //verifikator ditemukan aktif
			$cekkadaluwarsa = $this->M_eksekusi->getchanelkadaluwarsa($npsn);
			$cekbayarakhir = $this->M_eksekusi->getlastverbayar($idverlama);
		
			$tgl_kadaluwarsa = $cekkadaluwarsa->kadaluwarsa;
			if ($tgl_kadaluwarsa=="0000-00-00 00:00:00")
			{
				$kadaluwarsa = 1;
			}
			else
			{
				$bataskadaluwarsa = new DateTime($tgl_kadaluwarsa);
				$bataskadaluwarsa = $bataskadaluwarsa->modify('first day of this month');
				$bataskadaluwarsa = $bataskadaluwarsa->modify('+1 month');
				$bataskadaluwarsa = $bataskadaluwarsa->format ("Y-m-d");
				date_default_timezone_set('Asia/Jakarta');
				$now = new DateTime();
				$tglsekarang = $now->format ("Y-m-01");
				
				if (strtotime($bataskadaluwarsa)<=strtotime($tglsekarang))
				{
					$kadaluwarsa = 1;
				}
			}

			if ($cekbayarakhir)
			{
				$tgl_akhir = $cekbayarakhir[0]->tgl_berakhir;
				$batas2bulan = new DateTime($tgl_akhir);
				$batas2bulan = $batas2bulan->modify('first day of this month');
				$batas2bulan = $batas2bulan->modify('+2 month');
				$batas2bulan = $batas2bulan->format ("Y-m-d");
				date_default_timezone_set('Asia/Jakarta');
				$now = new DateTime();
				$tglsekarang = $now->format ("Y-m-01");
				if (strtotime($batas2bulan)<=strtotime($tglsekarang))
				{
					$telat2bulan = 1;
				}
			}
			else
			{
				$telat2bulan = 1;
			}
				
			if ($kadaluwarsa==1 && $telat2bulan==1)
				$veraktif = 1;  //adaver tapi gak produktif
		}

		$this->load->Model('M_eksekusi');
		$dataverifikator = $this->M_eksekusi->getveraktif($this->session->userdata('npsn'));
		if ($veraktif==2) {
			echo "ada";
		} else {
			$this->load->Model('M_user');
			$data = array("verifikator" => 2, "kontributor" => 0);
			$this->M_user->updateStaf($data, $iduser);

			if ($veraktif==1)
			{
				$data2 = array("verifikator" => 0, "kontributor" => 3);
				$this->M_user->updateStaf($data2, $idverlama);
			}

			$this->M_user->updateKonfirmUser("KONTRI");
			$this->M_user->updateKonfirmUser("VER");
			echo "oke";
		}

	}

	public function dashboard_calonkontributor()
	{
		
		$data = array();
		$data['konten'] = "profil_calonkontributor";
		$data['profilku'] = $this->ambilprofil();

		$getstatus = getstatususer();

		$data['namaverifikator'] = "-";
		$data['telpverifikator'] = "-";
		$data['emailverifikator'] = "-";

		$npsn = $this->session->userdata('npsn');
		if ($npsn==null)
		$npsn = "9999099999";
		
		$veraktif = 0;
		$referrer = $getstatus['referrer'];

		$this->load->Model('M_eksekusi');
		$dataverifikator = $this->M_eksekusi->getveraktif($npsn);
		$datacalonverifikator = $this->M_eksekusi->getcalonveraktif($npsn, $referrer);

		if ($dataverifikator) {
			$veraktif = 2; //verifikator ditemukan aktif
			$cekkadaluwarsa = $this->M_eksekusi->getchanelkadaluwarsa($npsn);
			$cekbayarakhir = $this->M_eksekusi->getlastverbayar($dataverifikator->id);

			$data['namaverifikator'] = $dataverifikator->first_name . " " . $dataverifikator->last_name;
			$data['telpverifikator'] = $dataverifikator->hp;
			$data['emailverifikator'] = $dataverifikator->email;
			
			$tgl_kadaluwarsa = $cekkadaluwarsa->kadaluwarsa;
			if ($tgl_kadaluwarsa=="0000-00-00 00:00:00")
			{
				$kadaluwarsa = 1;
			}
			else
			{
				$bataskadaluwarsa = new DateTime($tgl_kadaluwarsa);
				$bataskadaluwarsa = $bataskadaluwarsa->modify('first day of this month');
				$bataskadaluwarsa = $bataskadaluwarsa->modify('+1 month');
				$bataskadaluwarsa = $bataskadaluwarsa->format ("Y-m-d");
				date_default_timezone_set('Asia/Jakarta');
				$now = new DateTime();
				$tglsekarang = $now->format ("Y-m-01");
				
				if (strtotime($bataskadaluwarsa)<=strtotime($tglsekarang))
				{
					$kadaluwarsa = 1;
				}
			}

			if ($cekbayarakhir)
			{
				$tgl_akhir = $cekbayarakhir[0]->tgl_berakhir;
				$batas2bulan = new DateTime($tgl_akhir);
				$batas2bulan = $batas2bulan->modify('first day of this month');
				$batas2bulan = $batas2bulan->modify('+2 month');
				$batas2bulan = $batas2bulan->format ("Y-m-d");
				date_default_timezone_set('Asia/Jakarta');
				$now = new DateTime();
				$tglsekarang = $now->format ("Y-m-01");
				if (strtotime($batas2bulan)<=strtotime($tglsekarang))
				{
					$telat2bulan = 1;
				}
			}
			else
			{
				$telat2bulan = 1;
			}
				
			if ($kadaluwarsa==1 && $telat2bulan==1)
				$veraktif = 1;  //adaver tapi gak produktif
		}
		else if ($datacalonverifikator) 
		{
			$veraktif = 3 ;  //event calon verifikator
		}

		$data['verifikator_aktif'] = $veraktif;

		$this->load->view('layout/wrapper_profil', $data);
	}

	public function dashboard_verifikator()
	{
		$getstatus = getstatusverifikator();

		$data = array();
		$data['konten'] = "profil_dashboard_verifikator";
		$data['profilku'] = $this->ambilprofil();

		$this->load->Model('M_payment');
		$standarbayar = $this->M_payment->getstandar();
		$data['iuranbulanan'] = $standarbayar->iuran;

		$data['status_dibayarin_donatur'] = $getstatus['status_dibayardonatur'];
		$jmlbulandonatur = $getstatus['jumlah_bulan_donatur'];
		$tanggalawaldonatur = $getstatus['tgl_awal_donatur'];
		$tanggalakhirdonatur = $getstatus['tgl_akhir_donatur'];
		$namadonatur = $getstatus['nama_donatur'];
		$data['keterangandonatur'] = "Sekolah telah mendapatkan bantuan dana dari donatur ($namadonatur) selama $jmlbulandonatur bulan, 
		mulai tanggal " . namabulan_pendek($tanggalawaldonatur) . " sampai " . namabulan_pendek($tanggalakhirdonatur);

		$data['status_verifikator'] = $getstatus['status_verifikator'];
		$data['keteranganpro'] = "-";
		$keteranganekskul = "-";
		$data['keteranganstatus'] = "-";

		if ($getstatus['status_bayar4'] == "lunas") {
			$data['keteranganbayar1'] = "-";
			$data['keteranganbayar2'] = "Pembayaran Sekolah Premium Lunas";
			$keteranganekskul = "Semua siswa mendapat ekskul gratis";
		} else if ($getstatus['status_bayar3'] == "lunas") {
			$data['keteranganbayar1'] = "-";
			$data['keteranganbayar2'] = "Pembayaran Sekolah Pro Lunas";
			$keteranganekskul = "10 siswa ekskul gratis";
		} else if ($getstatus['status_dibayardonatur'] == "oke") {
			$data['keteranganbayar1'] = "-";
			$data['keteranganbayar2'] = "Pembayaran Bulan Ini Dibiayai oleh Donatur";
			$data['keteranganstatus'] = "Sekolah Lite Gratis dari Donatur";
		} else if ($getstatus['status_ekskul'] == "oke") {
			$data['keteranganbayar1'] = "-";
			$data['keteranganbayar2'] = "Pembayaran Bulan Ini Lunas oleh Siswa";
			$data['keteranganstatus'] = "Sekolah Lite Gratis dari Siswa Ekskul";
		} else if ($getstatus['status_virtualkelas'] == "oke") {
			$data['keteranganbayar1'] = "-";
			$data['keteranganbayar2'] = "Pembayaran Bulan Ini Lunas oleh Siswa";
			$data['keteranganstatus'] = "Sekolah Lite Gratis dari Siswa Kelas Virtual";
		} else if ($getstatus['status_bayar'] == "masatenggang") {
			$data['keteranganbayar1'] = number_format($standarbayar->iuran, 0, ',', '.');
			$data['keteranganbayar2'] = "Masuk Masa Tenggang";
		} else if ($getstatus['status_bayar'] == "lunas") {
			$data['keteranganpro'] = "";
			if ($getstatus['selisih'] < 0)
				$keterangan2 = "Lunas hingga " . substr(namabulan_pendek($getstatus['expired']), 3);
			else
				$keterangan2 = "Pembayaran bulan ini lunas";
			$data['keteranganbayar1'] = "-";
			$data['keteranganbayar2'] = $keterangan2;
			$keteranganekskul = "3 siswa ekskul gratis";
			$data['keteranganstatus'] = "Sekolah Lite";
		} else if ($getstatus['status_bayar2'] == "lunas") {
			$data['keteranganbayar1'] = "-";
			$data['keteranganbayar2'] = "Pembayaran Pembayaran Ekskul oleh Sekolah Lunas";
		} else {
			$data['keteranganbayar1'] = number_format($standarbayar->iuran, 0, ',', '.');
			$data['keteranganbayar2'] = "Tagihan Bulan Ini";
		}

		if ($getstatus['status_tunggu'] == "tunggu") {
			$data['keteranganbayar1'] = number_format($getstatus['iuran'], 0, ',', '.');
			$data['keteranganbayar2'] = "Menunggu Pembayaran";
		}

		$jmlver = 0;
		$jmlverevent = 0;
		$jmlverekskul = 0;

		$this->load->Model('M_video');
		$getdafvideo = $this->M_video->getVideoSekolah($this->session->userdata('npsn'), "kontributor", 0, "0");
		$getdafvideoekskul = $this->M_video->getVideoSekolah($this->session->userdata('npsn'), "kontributor", 2, "0");
		$getdafvideoevent = $this->M_video->getVideoSekolah($this->session->userdata('npsn'), "kontributor", 1, "0");

		if ($getdafvideo)
			$jmlver = sizeof($getdafvideo);

		if ($getdafvideoekskul)
			$jmlverekskul = sizeof($getdafvideoekskul);

		if ($getdafvideoevent)
			$jmlverevent = sizeof($getdafvideoevent);

		$jumlahvertotal = $jmlver + $jmlverekskul + $jmlverevent;

		$data['jumlahvertotal'] = $jumlahvertotal;

		$this->load->Model('M_user');
		$getuserguru = $this->M_user->getUserSebagai($this->session->userdata['npsn']);

		$totalguru = 0;
		$jmlcalonkontri = 0;
		$jmlsiswa = 0;
		foreach ($getuserguru as $datane) {
			if ($datane->sebagai == 1) {
				$totalguru++;
				if ($datane->kontributor == 2)
					$jmlcalonkontri++;
			} else if ($datane->sebagai == 2) {
				$jmlsiswa++;
			}

		}

		$data['keterangansiswa1'] = $jmlsiswa;
		$data['linksiswa'] = base_url() . "user/usersekolah/dashboard/siswa";

		if ($jmlcalonkontri > 0) {
			$data['keteranganguru1'] = $jmlcalonkontri;
			$data['keteranganguru2'] = "Calon Guru menunggu diverifikasi";
			$data['linkguru'] = base_url() . "user/kontributor/dashboard";
		} else {
			$data['keteranganguru1'] = $totalguru;
			$data['keteranganguru2'] = "Jumlah Seluruh Guru";
			$data['linkguru'] = base_url() . "user/usersekolah/dashboard/guru";
		}

//		if ($getstatus['status_bayar2'] == "lunas")
//			$keteranganekskul = "Dibayar oleh Sekolah";
//		else {
//			$this->load->Model('M_ekskul');
//			$getpembayar = $this->M_ekskul->cekpembayar();
//			if ($getpembayar->pembayarekskul == 1) {
//				$keteranganekskul = "Sekolah yang akan membayar";
//			} else {
//				$keteranganekskul = "Siswa yang akan membayar";
//			}
//		}
		$this->load->Model('M_ekskul');
		$getpembayar = $this->M_ekskul->cekpembayar();
		if ($getpembayar->pembayarekskul == 1)
				$pembayar = "sekolah";
			else
				$pembayar = "siswa";
		
		$data['pembayar'] = $pembayar;

		$data['keteranganekskul'] = $keteranganekskul;


		if ($getstatus['status_bayar3'] == "lunas") {
			if ($getstatus['kodeorder3'] == "TP2") {
				$data['keteranganpro'] = "<b>Sekolah Pro</b>";
				$data['keteranganstatus'] = "<b>Sekolah Pro</b>";
			}
		}

		if ($getstatus['status_bayar4'] == "lunas") {
			if ($getstatus['kodeorder4'] == "TF2") {
				$data['keteranganpremium'] = "<b>Sekolah Premium</b>";
				$data['keteranganstatus'] = "<b>Sekolah Premium</b>";
			}
		}

		$data['jumlah_siswaeks'] = $getstatus['jumlah_ekskul'];
		$data['jumlah_lite'] = $getstatus['jumlah_lite'];
		$data['jumlah_pro'] = $getstatus['jumlah_pro'];
		$data['jumlah_premium'] = $getstatus['jumlah_premium'];
		$data['jumlah_lite_bimbel'] = $getstatus['jumlah_lite_bimbel'];
		$data['jumlah_pro_bimbel'] = $getstatus['jumlah_pro_bimbel'];
		$data['jumlah_premium_bimbel'] = $getstatus['jumlah_premium_bimbel'];


		$this->load->view('layout/wrapper_profil', $data);
	}

	public function dashboard_admin()
	{
		$getstatus = getstatususer();
		
		$data = array();
		$data['konten'] = "profil_dashboard_admin";
		$data['profilku'] = $this->ambilprofil();
		

		$this->load->Model('M_user');
//		$getuser = $this->M_user->getAllUser();
		$getuser = $this->M_user->getTabelDashboardAdmin();

		$totalkampus = $getuser['n_kampus'];
		$totalprodi = $getuser['n_prodi'];
		$totalguru = $getuser['n_guru'];
		$jmlcalonver = $getuser['n_calon_ver'];
		$jmlver = 10;
		$jmlcalontutor = $getuser['n_calon_tutor'];
		$jmltutor = 0;
		$jmlcalonguru = $getuser['n_calon_guru'];
		$jmlkontributor = 0;
		$jmlcalonae = $getuser['n_calon_ae'];
		$jmlcalonam = $getuser['n_calon_am'];
		$jmlcalonag = $getuser['n_calon_agency'];
		$jmlsiswa = $getuser['n_siswa'];

		$totalsiplahkonfirm = $getuser['n_verify_siplah'];

		if ($totalguru==0)
		{
			$getuser = $this->M_user->getAllUser();
			foreach ($getuser as $datane) {
				if ($datane->sebagai == 1) {
						$totalguru++;
						if ($datane->verifikator == 2)
							$jmlcalonver++;
						else if ($datane->verifikator == 3)
							$jmlver++;
						else if ($datane->kontributor == 2)
							$jmlcalonguru++;
						else if ($datane->kontributor == 3)
							$jmlkontributor++;
					} else if ($datane->bimbel == 2) {
						$jmlcalontutor++;
					} else if ($datane->bimbel == 3) {
						$jmltutor++;
					} else if ($datane->sebagai == 2) {
						$jmlsiswa++;
					} else if ($datane->siae == 2) {
						$jmlcalonae++;
					} else if ($datane->siam == 2) {
						$jmlcalonam++;
					} else if ($datane->siag == 2) {
						$jmlcalonag++;
				}
			}

			$this->load->Model('M_agency');
			$getsiplah = $this->M_agency->getAllUnggahSiplah();
			
	
			foreach ($getsiplah as $datane) {
				if ($datane->konfirmasi == 1 || $datane->konfirmasi == 4) {
					$totalsiplahkonfirm++;
				}
			}

			$totalsiplahkonfirm = $totalsiplahkonfirm;

			$datasave = array();
			$datasave['n_guru'] = $totalguru;
			$datasave['n_calon_ver'] = $jmlcalonver;
			$datasave['n_ver'] = $jmlver;
			$datasave['n_calon_tutor'] = $jmlcalontutor;
			$datasave['n_calon_guru'] = $jmlcalonguru;
			$datasave['n_calon_ae'] = $jmlcalonae;
			$datasave['n_calon_am'] = $jmlcalonam;
			$datasave['n_calon_agency'] = $jmlcalonag;
			$datasave['n_siswa'] = $jmlsiswa;
			$datasave['n_verify_siplah'] = $totalsiplahkonfirm;

			$this->M_user->updateDashAdmin($datasave);

			// $totalguru = $getuser['n_guru'];
			// $jmlcalonver = $getuser['n_calon_ver'];
			// $jmlver = 10;
			// $jmlcalontutor = $getuser['n_calon_tutor'];
			// $jmltutor = 0;
			// $jmlcalonguru = $getuser['n_calon_guru'];
			// $jmlkontributor = 0;
			// $jmlcalonae = $getuser['n_calon_ae'];
			// $jmlcalonam = $getuser['n_calon_am'];
			// $jmlcalonag = $getuser['n_calon_agency'];
			// $jmlsiswa = $getuser['n_siswa'];

		
		}

		$data['keterangansiswa1'] = $jmlsiswa;
		$data['linksiswa'] = base_url() . "user/usersekolah/dashboard/siswa";

		if ($jmlcalonver > 0) {
			$data['keteranganuser1'] = $jmlcalonver;
			$data['keteranganuser2'] = "Calon Verifikator menunggu diverifikasi";
			$data['linkguru'] = base_url() . "user/calver";
		} else if ($jmlcalonguru > 0) {
			$data['keteranganuser1'] = $jmlcalonguru;
			$data['keteranganuser2'] = "Calon Guru menunggu diverifikasi";
			$data['linkguru'] = base_url() . "user/calkontri";
		} else {
			$data['keteranganuser1'] = $totalguru;
			$data['keteranganuser2'] = "Jumlah Seluruh Guru";
			$data['linkguru'] = base_url() . "user/usersekolah/dashboard";
		}

		$totalfreechannel = 0;
		$this->load->Model('M_channel');
		$getchannel = $this->M_channel->getChannelSiap(0);
		foreach ($getchannel as $datane) {
			if ($datane->strata_sekolah >=7 ) {
				$totalfreechannel++;
			}
		}
		
		$data['jmlkampus'] = $totalkampus;
		$data['linkkampus'] = base_url() . "channel/daftarkampus";

		$data['jmlprodi'] = $totalprodi;
		$data['linkprodi'] = base_url() . "channel/daftarprodi";

		$data['jmlfreechannel'] = $totalfreechannel;
		$data['linkchn'] = base_url() . "channel/daftarprodi";


		$data['jmlcalonae'] = $jmlcalonae;
		$data['linkae'] = base_url() . "user/ae";

		$data['jmlcalonam'] = $jmlcalonam;
		$data['linkam'] = base_url() . "user/am";

		$data['jmlcalonag'] = $jmlcalonag;
		$data['linkag'] = base_url() . "user/agency";

		$data['jmlsiplahkonfirm'] = $totalsiplahkonfirm;
		$data['linksiplah'] = base_url() . "finance/transaksi_siplah";

		$this->load->view('layout/wrapper_profil', $data);
	}

	public function dashboard_agency()
	{
		$getstatus = getstatususer();
		$kodekotaku = $getstatus['kd_kota'];

		$data = array();
		$data['konten'] = "profil_dashboard_agency";
		$data['profilku'] = $this->ambilprofil();

		//////////////////// DATA TUTOR /////////////////////
		$this->load->Model('M_user');
		$getuser = $this->M_user->getAllUserBimbel($kodekotaku);

		$totaltutor = 0;
		$jmlcalontutor = 0;

		foreach ($getuser as $datane) {
			if ($datane->bimbel == 3)
				$totaltutor++;
			else if ($datane->bimbel == 2)
				$jmlcalontutor++;
		}

		//////////////////// DATA AM/MENTOR /////////////////////
		$getuser = $data['profilku'];
		
		$this->load->model("M_agency");
		if ($getuser->level==0)
			{
				$totalmentor = sizeof($this->M_agency->getDafUser($getuser->kd_kota));
			}
		else if ($getuser->level==1)
			{
				$totalmentor = sizeof($data['dafuser'] = $this->M_agency->getDafUserAll());
			}
		
		$data['totalmentor'] = $totalmentor;
		$data['totaltutor'] = $totaltutor;
		$data['jmlcalontutor'] = $jmlcalontutor;
		$data['linkmentor'] = base_url() . "agency/daftar_am";
		$data['linktutor'] = base_url() . "user/bimbel";

		//////////////////// DATA VIDEO ////////////////////
		$sifat = 2;
		$this->load->Model('M_video');
		$getvideo = $this->M_video->getVideoSekolah(null, "kontributorbimbel",
			null, null, $sifat, $kodekotaku);

		$totalvideo = 0;
		$jmlvideoperluver = 0;

		foreach ($getvideo as $datane) {
			$totalvideo++;
			if ($datane->status_verifikasi_bimbel == 0)
				$jmlvideoperluver++;
		}

		$data['totalvideo'] = $totalvideo;
		$data['jmlvideoperluver'] = $jmlvideoperluver;
		$data['linkvideo'] = base_url() . "video/bimbel/dashboard";


		$this->load->view('layout/wrapper_profil', $data);
	}

	public function sekolah()
	{
		if ($this->session->userdata('sebagai') == 3)
			redirect("/profil");
		$data = array();
		$data['konten'] = "profil_sekolah_diri";
		$data['profilku'] = $this->ambilprofil();
		$data['namaverifikator'] = "-";
		$data['telpverifikator'] = "-";
		$data['emailverifikator'] = "-";
		$data['namaag'] = "-";
		$data['namaam'] = "-";
		$data['namaverbimbel'] = "-";

		$statususer = getstatususer();
		$kodekota = $statususer['kd_kota'];
		if ($kodekota==0)
		{
			$this->load->Model("M_channel");
			$sekolahku=$this->M_channel->getSekolahKu($this->session->userdata('npsn'));
			$kodekota = $sekolahku[0]->idkota;
			$datapropkota = $this->M_login->getpropkota($kodekota);
			$kodepropinsi = $datapropkota->id_propinsi;
			$datakota = array ("kd_provinsi"=>$kodepropinsi, "kd_kota"=>$kodekota);
			$this->M_login->updatekotapropinsi($datakota, $this->session->userdata('id_user'));
		}
			
		
		$datapropkota = $this->M_login->getpropkota($kodekota);
		$data['namapropinsi'] = $datapropkota->nama_propinsi;
		$data['namakota'] = $datapropkota->nama_kota;
		

		$this->load->Model("M_eksekusi");
		$dataag = $this->M_eksekusi->getagaja($kodekota);
		if ($dataag) {
			$data['namaverbimbel'] = $dataag->first_name . " " . $dataag->last_name;
			$data['telpverbimbel'] = $dataag->hp;
			$data['emailverbimbel'] = $dataag->email;
		}

		$this->load->Model('M_login');
		$datasaya = $this->M_login->getUser($this->session->userdata('id_user'));
		$data['referrer'] = $datasaya['referrer'];

		// echo $data['referrer'];
		// die();

		$this->load->Model('M_eksekusi');
		$dataverifikator = $this->M_eksekusi->getveraktif($this->session->userdata('npsn'));
		$dataagam = $this->M_eksekusi->getagam($this->session->userdata('npsn'));

		if ($dataverifikator) {
			$data['namaverifikator'] = $dataverifikator->first_name . " " . $dataverifikator->last_name;
			$data['telpverifikator'] = $dataverifikator->hp;
			$data['emailverifikator'] = $dataverifikator->email;
		}
		if ($dataagam) {
			if ($dataagam->id_agency != 0 && $dataagam->id_agency != null) {
				$data['namaag'] = $dataagam->ag_firstname . " " . $dataagam->ag_lastname;
				$data['telpag'] = $dataagam->ag_hp;
				$data['emailag'] = $dataagam->ag_email;
			}
			$data['namaam'] = $dataagam->am_firstname . " " . $dataagam->am_lastname;
			$data['telpam'] = $dataagam->am_hp;
			$data['emailam'] = $dataagam->am_email;
			$data['koderef'] = $dataagam->kode_referal;
		} else
		{
			$dataagam2 = $this->M_eksekusi->getagambyref($data['referrer']);
			if ($dataagam2) {
				if ($dataagam2->id_agency != 0 && $dataagam2->id_agency != null) {
					$data['namaag'] = $dataagam2->ag_firstname . " " . $dataagam2->ag_lastname;
					$data['telpag'] = $dataagam2->ag_hp;
					$data['emailag'] = $dataagam2->ag_email;
				}
				$data['namaam'] = $dataagam2->am_firstname . " " . $dataagam2->am_lastname;
				$data['telpam'] = $dataagam2->am_hp;
				$data['emailam'] = $dataagam2->am_email;
				$data['koderef'] = $dataagam2->kode_referal;
			}
		}

		$ceksekolahpremium = ceksekolahpremium();
		$data['statussekolah'] = " [ - ]";
		if ($ceksekolahpremium['status_sekolah'] != "non")
			{
				$statussekolah = $ceksekolahpremium['status_sekolah'];
				if ($statussekolah == "Lite Siswa")
					$statussekolah = "Lite";
				$data['statussekolah'] = " [ " . $statussekolah . " ] ";
			}
		else
		{

		}

		$this->load->view('layout/wrapper_profil', $data);
	}

	public function pekerjaan()
	{
		$statususer = getstatususer();
		$kodekota = $statususer['kd_kota'];
		$data = array();
		$data['konten'] = "profil_pekerjaan";
		$data['profilku'] = $this->ambilprofil();
		$data['namaag'] = "-";
		$this->load->Model("M_eksekusi");
		if ($kodekota!=999) {
			$dataagam = $this->M_eksekusi->getagaja($kodekota);
			if ($dataagam) {
				$data['namaag'] = $dataagam->first_name . " " . $dataagam->last_name;
				$data['telpag'] = $dataagam->hp;
				$data['emailag'] = $dataagam->email;
			}
		}
		else
		{
			$data['namaag'] = "";
			$data['telpag'] = "";
			$data['emailag'] = "";
		}
		if ($this->session->userdata('siam') == 3 || $this->session->userdata('siag') == 3) {
			$this->load->Model("M_login");
			if ($kodekota!=999) {
				$datapropkota = $this->M_login->getpropkota($kodekota);
				if ($datapropkota)
				{
					$data['namapropinsi'] = $datapropkota->nama_propinsi;
					$data['namakota'] = $datapropkota->nama_kota;
				}
				else
				{
					$data['namapropinsi'] = "";
					$data['namakota'] = "";
				}
			}
			else
			{
				$data['namapropinsi'] = "Seluruh Wilayah";
				$data['namakota'] = "Indonesia";
			}
		}

		$this->load->view('layout/wrapper_profil', $data);
	}

	public function ambilprofil()
	{
		$tstatususer = array("", "Admin", "Verifikator Prodi", "Dosen", "Calon Dosen", "Mahasiswa", "Kontributor", "Umum", "Calon Verifikator");
		$statustutorbimbel = "";
		$data = $this->M_login->getdatasiswa($this->session->userdata('email'));
		
		$fotouser = $data->picture;
		if ($fotouser == null)
			$fotouser = base_url() . "assets/images/profil_blank.jpg";
		else if (substr($fotouser, 0, 4) != "http")
			$fotouser = base_url() . "uploads/profil/" . $fotouser;
		$data->fotouser = $fotouser;
		$data->username = $data->first_name . " " . $data->last_name;
		$data->logosekolah = base_url() . "uploads/profil/" . $data->logo;

		if ($this->session->userdata('a01')) {
			$statususer = 1;
		} else if ($this->session->userdata('sebagai') == 2) {
			$statususer = 5;
			if ($data->kd_prodi=="prodibaru")
				{
					$getprodi = $this->M_login->dafprodi($data->npsn, null, $data->kd_user);
					echo "1";
					echo "NPSN:".$data->npsn;
					echo "KODEUSER:".$data->kd_user;
					print_r($getprodi);
				}
			else
				{
					$getprodi = $this->M_login->dafprodi($data->npsn, $data->kd_prodi);
					echo "2";
					print_r($getprodi);
				}
			$data->namaprodi = $getprodi->nama_prodi;
			
		} else if ($this->session->userdata('sebagai') == 1) {
			$statususer = 4;
			if ($this->session->userdata('verifikator') == 3) {
				$statususer = 2;
			} else if ($this->session->userdata('kontributor') != 3 &&
			 ($this->session->userdata('verifikator') == 1 || $this->session->userdata('verifikator') == 2)) {
				$statususer = 8;
			} else if ($this->session->userdata('kontributor') == 3) {
				$statususer = 3;
			}
			$getgurumapel = $this->M_login->dafmapelsaya($this->session->userdata('id_user'));
			$dafmapelsaya = "";
			foreach ($getgurumapel as $row)
			{	
				if ($row->nama_mapel!="")
				$dafmapelsaya = $dafmapelsaya . $row->nama_mapel . ", ";
			}
			$dafmapelsaya = "Guru ".substr($dafmapelsaya, 0, -2);
			$data->namamapel = $dafmapelsaya;
		} else if ($this->session->userdata('sebagai') == 3 && $this->session->userdata('kontributor') == 3) {
			$statususer = 6;
		} else {
			$statususer = 7;
		}

		if ($this->session->userdata('bimbel') == 4)
			$statustutorbimbel = " - Verifikator Bimbel";
		else if ($this->session->userdata('bimbel') == 3)
			$statustutorbimbel = " - Tutor Bimbel";
		else if ($this->session->userdata('siae') == 3)
			$statustutorbimbel = " - Account Excecutive";
		else if ($this->session->userdata('siam') == 3)
			$statustutorbimbel = " - Area Marketing";
		else if ($this->session->userdata('bimbel') == 2)
			$statustutorbimbel = " - Calon Tutor Bimbel";
		else if ($this->session->userdata('siae') == 2)
			$statustutorbimbel = " - Calon Account Excecutive";
		else if ($this->session->userdata('siam') == 2)
			$statustutorbimbel = " - Calon Area Marketing";
		else if ($this->session->userdata('siag') == 2)
			$statustutorbimbel = " - Calon Agency";

		$data->statususer = $statususer;
		$data->tstatususer = $tstatususer[$statususer] . $statustutorbimbel;

		if ($this->session->userdata('siag') == 3) {
			$data->tstatususer = "Agency - Verifikator Bimbel";
		}

		return $data;
	}

	public function cekstatusbayarsekolah($jenis = null)
	{
		$getstatus = getstatusverifikator();
		if ($jenis == 3 && $getstatus['status_tunggu'] == "tidak") {
			echo "tidak3";
		} else
			echo $getstatus['status_tunggu'];
	}

	public function pembayaran()
	{
		if ($this->session->userdata('loggedIn') && $this->session->userdata('verifikator') > 0) {

			$npsn = $this->session->userdata('npsn');
			$data = array();
			$data['konten'] = "profil_iuran";
			$data['profilku'] = $this->ambilprofil();

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

			$getstatus = getstatusverifikator();

			$data['status_verifikator'] = $getstatus['status_verifikator'];
			$data['status_bayar'] = $getstatus['status_bayar'];
			$data['status_tunggu'] = $getstatus['status_tunggu'];
			$data['keteranganbayartunggu'] = "";
			$data['keteranganbayar'] = "Silakan pilih salah satu metode pembayaran";
			$data['keteranganbayar2'] = "";
			$data['keteranganbayar3'] = "";
			$data['keteranganekskul'] = "";
			$data['keteranganpro'] = "";
			$data['keteranganpro2'] = "";
			$data['keteranganpremium'] = "";
			$infolunas = "";
			$data['jmlpro'] = 10 - $getstatus['jumlah_pro'];
			$data['jmlpremium'] = 1 - $getstatus['jumlah_premium'];
			$data['jmlekskul'] = 3 - $getstatus['jumlah_ekskul'];

			$data['lunas'] = false;
			$data['lewatsiplah'] = false;
			$data['keterangansiplah'] = "";
			$data['keterangansiplah2'] = "";
			$data['buktisiplah'] = "";
			$data['siplahkonfirm'] = 0;
			$data['petunjuk'] = "";

			$keteranganlunas1 = "";
			$keteranganlunas3 = "";
			$keteranganlunas4 = "";
			$keterangansiplah = "";

			$this->load->model('M_payment');
			$getsiplah = $this->M_payment->getSiplah($this->session->userdata('id_user'));

			// echo "<br><br><br>";
			// echo var_dump($getsiplah);

			$namapaket = array ('','Lite','Pro','Premium');

			// $data['buktisiplah'] = "";
			// $data['siplahkonfirm'] = 0;
			// $data['token'] = 0;
			// $data['namapaket'] = "paket";
			// $data['lamabulan'] = 0;
			// $data['tglberakhir'] = "";

			if ($getsiplah)
				{
					$data['buktisiplah'] = $getsiplah[0]->filebukti;
					$data['siplahkonfirm'] = $getsiplah[0]->konfirmasi;
					$data['token'] = $getsiplah[0]->token;
					$data['namapaket'] = $namapaket[$getsiplah[0]->strata];
					$data['lamabulan'] = $getsiplah[0]->lamabulan;
					$data['tglberakhir'] = $getsiplah[0]->tgl_berakhir;
				}
			$data['namasekolah'] = $cekSekolahTerdaftar[0]->nama_sekolah;;
			//echo "<br><br><br>".$data['token']."-".$data['namasekolah'];
			
			if ($data['siplahkonfirm'] == 1)
				$data['keteranganbayar'] = "Menunggu konfirmasi pembayaran Siplah";

			if ($getstatus['status_tunggu'] == "tunggu") {

				if (substr($getstatus['order_id'], 0, 3) == "TVS")
					$namapembayaran = "Pembayaran TV Sekolah";
				else if (substr($getstatus['order_id'], 0, 3) == "EK1" || substr($getstatus['order_id'], 0, 3) == "EK2" ||
					substr($getstatus['order_id'], 0, 3) == "EK3" || substr($getstatus['order_id'], 0, 3) == "EK4")
					$namapembayaran = "Pembayaran Ekskul oleh Sekolah";
				else if (substr($getstatus['order_id'], 0, 2) == "TP")
					$namapembayaran = "Pembayaran Sekolah Pro";
				else if (substr($getstatus['order_id'], 0, 2) == "TF")
					$namapembayaran = "Pembayaran Sekolah Premium";
				$lamabayar = $getstatus['lamabayar'];
				$data['keteranganbayar'] = "";
				$data['keteranganbayartunggu'] = "Menunggu Pembayaran " . $namapembayaran . " " . $lamabayar;
				$data['batasbayar'] = namabulan_panjang($getstatus['batas_bayar']) . " pukul " .
					substr($getstatus['batas_bayar'], 11, 5);
				$data['totaltagihan'] = $getstatus['iuran'];
				$data['akhirlunas'] = substr(namabulan_panjang($getstatus['expired']), 3);
				$orderid = $getstatus['order_id'];
				$kodeorder = substr($orderid, 0, 3);
				$data['orderid'] = $orderid;
				$namabank = $getstatus['nama_bank'];
				$rekeningtujuan = $getstatus['rek_tujuan'];
				$data['petunjuk'] = $getstatus['petunjuk'];
				if ($namabank == "gopay") {
					$data['keteranganbayar3'] = 'Jika anda berhasil melakukan pembayaran menggunakan GOPAY sebesar <span' .
						' style="font-weight: bold">Rp' . number_format($iuran, 0, ",", ".") . ',-</span>' .
						'silakan klik "Saya sudah bayar", jika tidak silakan ulangi atau ganti cara pembayaran!';
				}
				$data['keteranganbayar2'] = "<hr>Pembayaran melalui:<br><span style='font-size: 20px'><b>" . $namabank .
					"</b></span><br>No. Rek.<br><span style='font-size: 20px'><b>" . $rekeningtujuan . "</b></span>";

			}

//			echo "Ekskul:".$getstatus['status_ekskul'];
//			echo "<br>KelasVir:".$getstatus['status_virtualkelas'];
//			echo "<br>StatusBayar:".$getstatus['status_bayar'];
//			die();



			if ($getstatus['status_dibayardonatur'] == "oke") {
				$data['keteranganbayar'] = "Pembayaran TVSekolah telah Dibiayai oleh " . $getstatus['nama_donatur'];
			} else if ($getstatus['status_ekskul'] == "oke") {
				$data['keteranganbayar'] = "Pembayaran Bulan Ini Lunas oleh Siswa Ekskul";
			} else if ($getstatus['status_virtualkelas'] == "oke") {
				$data['keteranganbayar'] = "Pembayaran Bulan Ini Lunas oleh Siswa Kelas Virtual";
			} else if ($getstatus['status_bayar'] == "lunas") {
				$data['lunas'] = true;
				if ($getstatus['melalui1'] == "midtrans") {
					if ($getstatus['selisih'] < 0) {
						$keterangan = "Lunas hingga " . substr(namabulan_pendek($getstatus['expired']), 3);
						$infolunas = "Verifikator Aktif";
					} else {
						$keterangan = "Bulan Ini Sudah Lunas";
						$infolunas = "Verifikator Aktif";
					}
					$data['keteranganbayar'] = $keterangan . "<br><span style='font-size: smaller;'>" . $infolunas . "</span>";
				}
				else
				{
					$data['keterangansiplah'] = "[Sekolah aktif dengan paket Lite]";
					$data['keteranganbayar'] = "Tagihan sudah lunas melalui SIPLAH";
				}
			} else if ($getstatus['status_bayar'] == "masatenggang") {
				$data['keteranganbayar'] = "Masuk Masa Tenggang";
			} else if ($getstatus['status_bayar'] == "belumbayar") {
				$data['keteranganbayar'] = "Tagihan Bulan Ini";
			}


			if ($getstatus['status_bayar2'] == "lunas") {
				$data['lunas'] = true;

				if ($getstatus['kodeorder2'] == "EK1") {
					$keteranganekskul = "[Pembayaran Ekskul 1 bulan]";
				} else if ($getstatus['kodeorder2'] == "EK2") {
					$data['tagihekskul'] = false;
					$keteranganekskul = "[Pembayaran Ekskul 3 bulan]";
				} else if ($getstatus['kodeorder2'] == "EK3") {
					$data['tagihekskul'] = false;
					$keteranganekskul = "[Pembayaran Ekskul 6 bulan]";
				} else if ($getstatus['kodeorder2'] == "EK4") {
					$data['tagihekskul'] = false;
					$keteranganekskul = "[Pembayaran Ekskul 1 Tahun]";
				}

				if ($getstatus['selisih2'] < 0) {
					$keteranganlunas2 = "Lunas hingga " . substr(namabulan_pendek($getstatus['expired2']), 3);
				} else {
					$keteranganlunas2 = "Bulan Ini Sudah Lunas";
				}

				$data['keteranganekskul'] = $keteranganlunas2 . "<br>" . $keteranganekskul;
			}

			if ($getstatus['status_bayar3'] == "lunas") {
				$data['lunas'] = true;
				if ($getstatus['selisih3'] < 0) {
					$keteranganbulan = "Berlaku hingga " . substr(namabulan_pendek($getstatus['expired3']), 3);
				} else {
					$keteranganbulan = "Bulan Ini Sudah Lunas";
				}
				if ($getstatus['kodeorder3'] == "TP2") {
					if ($getstatus['melalui3'] == "midtrans") {
						$data['keteranganbayar'] = "Tagihan sudah lunas";
						$data['keteranganpro'] = "[Aktif sebagai Sekolah Pro]";
						$data['keteranganpro2'] = $keteranganbulan;
					}
					else
					{
						$data['keteranganbayar'] = "Tagihan sudah lunas melalui SIPLAH";
						$data['keterangansiplah'] = "[Aktif sebagai Sekolah Pro]";
						$data['keterangansiplah2'] = $keteranganbulan;
					}
				}

			} else if ($getstatus['status_bayar4'] == "lunas") {
				$data['lunas'] = true;
				if ($getstatus['kodeorder4'] == "TF2") {
					if ($getstatus['melalui3'] == "midtrans") {
						$data['keteranganpremium'] = "[Aktif sebagai Sekolah Premium]";
						$data['keteranganbayar'] = "Tagihan sudah lunas";
					}
					else
					{
						$data['keterangansiplah'] = "[Aktif sebagai Sekolah Premium]";
						$data['keteranganbayar'] = "Tagihan sudah lunas melalui SIPLAH";
					}
				}
			}

		}


//			if ($promoke>0)
////			{
////				echo "MASUK PROMO KE-".$promoke;
////			}
////			else
////				echo "NORMAL";
////			die();

		$this->load->model('M_payment');
		$standarbayar = $this->M_payment->getstandar();
		if ($promoke == 1) {
			$data['iuran1'] = $standarbayar->pro / 10;
			$data['iuran2'] = $standarbayar->premium / 10;
		} else if ($promoke == 2) {
			$data['iuran1'] = $standarbayar->pro / 10 * 4;
			$data['iuran2'] = $standarbayar->premium / 10 * 4;
		} else {
			$data['iuran1'] = $standarbayar->pro;
			$data['iuran2'] = $standarbayar->premium;
		}

		$data['iuranstandar1'] = $standarbayar->iuran;
		$data['iuranstandar2'] = $standarbayar->iuran3bulan;
		$data['iuranstandar3'] = $standarbayar->iuran6bulan;
		$data['iuranstandar4'] = $standarbayar->iuran12bulan;
		$data['iuranpro1'] = $standarbayar->pro;
		$data['iuranpro2'] = $standarbayar->pro3bulan;
		$data['iuranpro3'] = $standarbayar->pro6bulan;
		$data['iuranpro4'] = $standarbayar->pro12bulan;
		$data['iuranpremium1'] = $standarbayar->premium;
		$data['iuranpremium2'] = $standarbayar->premium3bulan;
		$data['iuranpremium3'] = $standarbayar->premium6bulan;
		$data['iuranpremium4'] = $standarbayar->premium12bulan;
		$data['biayareaktivasi'] = $standarbayar->reaktivasi;
		$data['iuranekskulver'] = $standarbayar->iuran_ekskul_ver;
		$data['promoke'] = $promoke;

//		echo $data['melalui'];
//		die();

		$this->load->view('layout/wrapper_profil_payment', $data);
	}


	public function verifikasi()
	{
		if ($this->session->userdata('verifikator')==2)
		{
			redirect("/");
		}
		
		$getstatus = getstatusverifikator();
		$udahlunas = true;

		if ($getstatus['status_verifikator'] == "oke")
			$udahlunas = true;

		if ($this->session->userdata('loggedIn') && $this->session->userdata('verifikator') > 0 && $udahlunas) {
			$npsn = $this->session->userdata('npsn');
			$data = array();
			$data['konten'] = "profil_verifikasi";
			$data['profilku'] = $this->ambilprofil();

			$jmlver = 0;
			$jmlverevent = 0;
			$jmlverekskul = 0;

			$jmlvid = 0;
			$jmlvidevent = 0;
			$jmlvidekskul = 0;

			$this->load->Model('M_video');
			$getdafvideoall = $this->M_video->getVideoSekolah($this->session->userdata('npsn'), "kontributor", 0);
			$getdafvideoekskulall = $this->M_video->getVideoSekolah($this->session->userdata('npsn'), "kontributor", 2);
			$getdafvideoeventall = $this->M_video->getVideoSekolah($this->session->userdata('npsn'), "kontributor", 1);

			$getdafvideo = $this->M_video->getVideoSekolah($this->session->userdata('npsn'), "kontributor", 0, "0");
			$getdafvideoekskul = $this->M_video->getVideoSekolah($this->session->userdata('npsn'), "kontributor", 2, "0");
			$getdafvideoevent = $this->M_video->getVideoSekolah($this->session->userdata('npsn'), "kontributor", 1, "0");

			if ($getdafvideo)
				$jmlver = sizeof($getdafvideo);
			$data['jmlverkontributor'] = $jmlver;
			if ($getdafvideoekskul)
				$jmlverekskul = sizeof($getdafvideoekskul);
			$data['jmlverekskul'] = $jmlverekskul;
			if ($getdafvideoevent)
				$jmlverevent = sizeof($getdafvideoevent);
			$data['jmlverevent'] = $jmlverevent;

			if ($getdafvideoall)
				$jmlvid = sizeof($getdafvideoall);
			$data['jmlvidkontributor'] = $jmlvid;
			if ($getdafvideoekskulall)
				$jmlvidekskul = sizeof($getdafvideoekskulall);
			$data['jmlvidekskul'] = $jmlvidekskul;
			if ($getdafvideoeventall)
				$jmlvidevent = sizeof($getdafvideoeventall);
			$data['jmlvidevent'] = $jmlvidevent;

//			if ($jmlverevent==0)
//				redirect("/profil");
			// echo "<br><br><br><br><br><pre>";
			// echo var_dump ($getdafvideo);
			// echo "</pre>";

			$this->load->view('layout/wrapper_profil', $data);
		} else {
			redirect("/profil");
		}
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
			$tanggalbatas = $batas6bulan;
			$iuran = $standar->iuran6bulan;
			$bulanapa = 6;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama6bulan);
		} else if ($pilihan == 3) {
			$tanggalbatas = $batas12bulan;
			$iuran = $standar->iuran12bulan;
			$bulanapa = 12;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama12bulan);
		}

		$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
			'Oktober', 'November', 'Desember');

		if ($this->session->userdata('statusbayar') == 2 && $this->session->userdata('a02') == false) {
			$iuran = $iuran + $standar->reaktivasi;
			$namane = "Reaktivasi " . $bulanapa . " Bulan TV Sekolah";
		} else {
			$namane = "Pembayaran " . $bulanapa . " Bulan TV Sekolah";
		}

		$iduser = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$kodeacak = "TVS-" . $iduser . "-" . rand();

		$this->M_payment->insertkodeorder($kodeacak, $iduser, $npsn, $iuran, $tanggalbatas);

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

	public function token_eksul($pilihan)
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
			$iuran = $standar->iuran_ekskul_ver;
			$bulanapa = 1;//nmbulan_panjang($namabulanini);
		} else if ($pilihan == 2) {
			$tanggalbatas = $batas3bulan;
			$iuran = $standar->iuran_ekskul_ver * 3;
			$bulanapa = 3;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama6bulan);
		} else if ($pilihan == 3) {
			$tanggalbatas = $batas6bulan;
			$iuran = $standar->iuran_ekskul_ver * 6;
			$bulanapa = 6;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama12bulan);
		} else if ($pilihan == 4) {
			$tanggalbatas = $batas12bulan;
			$iuran = $standar->iuran_ekskul_ver * 12;
			$bulanapa = 12;//nmbulan_pendek($namabulanini)." - ".nmbulan_pendek($nama12bulan);
		}

		$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
			'Oktober', 'November', 'Desember');

		$namane = "Pembayaran Ekskul " . $bulanapa . " Bulan (oleh Sekolah)";

		$iduser = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$kodeacak = "EKS-" . $iduser . "-" . rand();

		$this->M_payment->insertkodeorder($kodeacak, $iduser, $npsn, $iuran, $tanggalbatas);

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
			$iuran = $standar->pro; //di database yg pro pakai premium, yg premium pakai fullpremium
			$bulanapa = 1;//nmbulan_panjang($namabulanini);
		}

		$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
			'Oktober', 'November', 'Desember');

		$namane = "Pembayaran Sekolah Pro" . $bulanapa . " Bulan";


		$iduser = $this->session->userdata('id_user');
		$npsn = $this->session->userdata('npsn');
		$kodeacak = "TP2-" . $iduser . "-" . rand();

		$this->M_payment->insertkodeorder($kodeacak, $iduser, $npsn, $iuran, $tanggalbatas);

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

	public function finish()
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

		$this->M_payment->tambahbayar($data, $order_id, $iduser);
		$data2 = array('statusbayar' => 1, 'lastorder' => $order_id);
		$this->M_payment->updatestatusbayar($iduser, $data2);

		redirect("/profil/pembayaran");
	}

	public function donasi()
	{
		if ($this->session->userdata('loggedIn')) {
			$data = array();
			$data['konten'] = "v_user_donasi";
			$data['profilku'] = $this->ambilprofil();
			$this->load->model('M_login');
			$getdonasi = $this->M_login->getdonasi($this->session->userdata('id_user'));
			$data['jmldonasi'] = sizeof($getdonasi);
			$data['dafdonasi'] = $getdonasi;

			$this->load->view('layout/wrapper_profil', $data);
		} else {
			redirect("/profil");
		}
	}

	public function upload_buktisiplah()
	{
		$tfile = "file";
		$tfoto = "foto_";

		if (isset($_FILES[$tfile])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "siplah/";
		$allow = "jpg|png|jpeg";

		$config = array(
			'upload_path' => "uploads/" . $path1,
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "204800000",
			'encrypt_name' => TRUE
			//'max_height' => "768",
			//'max_width' => "1024"
		);

		$this->upload->initialize($config);
		//$this->load->library('upload', $config);


		if ($this->upload->do_upload($tfile)) {

			$tglsekarang = new DateTime();
			$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
			$tahunnya = $tglsekarang->format("y");
			$bulannya = $tglsekarang->format("m");
			$bulantahun = $tahunnya . $bulannya;

			$gbr = $this->upload->data();

			$config['image_library'] = 'gd2';
			$config['source_image'] = './uploads/siplah/' . $gbr['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['quality'] = '100%';
			$config['width'] = 600;
			$config['new_image'] = './uploads/siplah/' . $gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->load->library('image_lib');
			$this->image_lib->initialize($config);
			if (!$this->image_lib->resize()) {
				echo $this->image_lib->display_errors();
			}
			$this->image_lib->clear();

			$data['id_user'] = $this->session->userdata('id_user');

			$namafile1 = $gbr['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

//			$namafilehapus1 = "sl" . $data['id_user'] . "_". $bulantahun . ".png";
			$namafilehapus2 = "sl" . $data['id_user'] . "_" . $bulantahun . ".jpg";
//			$namafilehapus3 = "sl" . $data['id_user'] . "_". $bulantahun . ".jpeg";
			$namafilebaru = "sl" . $data['id_user'] . "_" . $bulantahun . ".jpg";// . $ext['extension'];

//			if(file_exists($alamat . $namafilehapus1))
//			unlink($alamat . $namafilehapus1);
			if (file_exists($alamat . $namafilehapus2))
				unlink($alamat . $namafilehapus2);
//			if(file_exists($alamat . $namafilehapus3))
//			unlink($alamat . $namafilehapus3);

			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$this->load->Model("M_payment");
			$addsiplah = $this->M_payment->addsiplah($namafilebaru);
			$this->M_payment->updateKonfirmSiplah();

			echo "Bukti Surat Pemesanan Siplah Berhasil Diunggah";

			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			echo $this->upload->display_errors();
		}
	}

	function tes($namafilebaru)
	{
		$this->load->Model("M_payment");
		$addsiplah = $this->M_payment->addsiplah($namafilebaru);
		echo $addsiplah;
	}

	function aktifkantoken()
	{
		$this->load->model('M_payment');
		$iduser = $this->session->userdata('id_user');
		$npsnuser = $this->session->userdata('npsn');
		$getsiplah = $this->M_payment->getSiplah($iduser);

		if ($getsiplah)
		{
			$siplahkonfirm = $getsiplah[0]->konfirmasi;
			$token = $getsiplah[0]->token;
			$kodesiplah = $getsiplah[0]->kode;
			$iuran = $getsiplah[0]->iuran;
			$strata = $getsiplah[0]->strata;

			if ($token!=0 && $siplahkonfirm==2)
			{
				$tglskr = new DateTime();
				$tglskr->setTimezone(new DateTimezone('Asia/Jakarta'));
				$tglskr = $tglskr->format("Y-m-d H:i:s");
				$batas7hari = new DateTime();
				$batas7hari = $batas7hari->modify('+7 day');
				$batas7hari = $batas7hari->format("Y-m-d 23:59:59");
				
				if ($strata==1)
					$kodeawal = "TVS";
				else if ($strata==2)
					$kodeawal = "TP2";
				else if ($strata==3)
					$kodeawal = "TF2";

				$kode = $kodeawal."-".$kodesiplah;
				$data = array();
				$data['iduser'] = $iduser;
				$data['npsn_sekolah'] = $npsnuser;
				$data['order_id'] = $kode;
				$data['tgl_order'] = $tglskr;
				$data['tgl_bayar'] = $tglskr;
				$data['tgl_berakhir'] = $batas7hari;
				$data['tipebayar'] = "SIPLAH";
				$data['iuran'] = $iuran;
				$data['status'] = 3;
				$this->M_payment->addDonasi($data);

				$data2 = array();
				$data2["konfirmasi"] = 4;
				$data2["tgl_aktifkan"] = $tglskr;
				$this->M_payment->update_siplah($kodesiplah,$data2);
				$this->M_payment->updateKonfirmSiplah();
			}
			else 
			{
				redirect ("/");
			}
		}
	}
}