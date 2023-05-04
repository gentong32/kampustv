<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informasi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_induk");
		$this->load->library("email");
		$this->load->helper(array('Form', 'Cookie','download','tanggalan'));

	}

	public function index()
	{
		setcookie('basis', "informasi", time() + (86400), '/');
		$this->showinfo();
	}

	public function panggung_sekolah()
	{
		$data = array();
		$data['konten'] = "panggungsekolah";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function perpustakaan_digital()
	{
		$data = array();
		$data['konten'] = "perpustakaandigital";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function kelas_virtual()
	{
		$data = array();
		$data['konten'] = "kelasvirtual";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function festival()
	{
		$data = array();
		$data['konten'] = "festival";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function ekstrakurikuler()
	{
		setcookie('basis', "ekskul", time() + (86400), '/');
		$data = array();
		$data['konten'] = "ekskul";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function cekjam()
	{
		$datetimedoank = new DateTime();
		$datetimedoank->setTimezone(new DateTimezone('Asia/Jakarta'));
		echo $datetimedoank->format("Y-m-d H:i:s");
	}


	public function showinfo()
	{
		$data = array('title' => 'Tentang Kami', 'menuaktif' => '28',
			'isi' => 'v_informasi');
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper3', $data);

	}

	public function sertifikatthanks()
	{
		$data = array('title' => 'Ierimakasih', 'menuaktif' => '28',
			'isi' => 'v_sertifikat_thanks');
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$data['email'] = $this->session->userdata('email');

		$this->load->view('layout/wrapper3', $data);

	}


	public function pengumuman()
	{
		$data = array('title' => 'Tentang Kami', 'menuaktif' => '30',
			'isi' => 'v_pengumuman_aktif');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->model('M_induk');
		$data['pengumumanaktif'] = $this->M_induk->getAllUmumAktif();

		$this->load->view('layout/wrapper3', $data);
	}

	public function lowongan()
	{
		$data = array('title' => 'Lowongan', 'menuaktif' => '33',
			'isi' => 'v_lowongan');

		$statusae = true;

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper3', $data);
	}

	public function syaratag()
	{
		$data = array('title' => 'Lowongan', 'menuaktif' => '33',
			'isi' => 'v_syarat_ag');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper3', $data);
	}

	public function lowongan_ae()
	{
		$data = array('title' => 'Lowongan', 'menuaktif' => '33',
			'isi' => 'v_lowongan_ae');

		$statusae = true;

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper3', $data);
	}

	public function lowongan_am()
	{
		$data = array('title' => 'Lowongan', 'menuaktif' => '34',
			'isi' => 'v_lowongan_am');

		$statusae = true;

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper3', $data);
	}

	public function lowongan_bimbel()
	{
		$data = array('title' => 'Lowongan', 'menuaktif' => '34',
			'isi' => 'v_lowongan_bimbel');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper3', $data);
	}

	public function showtentang()
	{
		setcookie('basis', "tentang", time() + (86400), '/');
		if ($this->session->userdata('loggedIn')) {
			if ($this->session->userdata('activate') == 0)
				redirect('/login/profile');
			else {
				$data = array('title' => 'Playing VOD', 'menuaktif' => '28',
					'isi' => 'v_tentang');
				$data['message'] = $this->session->flashdata('message');
				$data['authURL'] = $this->facebook->login_url();
				$data['loginURL'] = $this->google->loginURL();

				$this->load->view('layout/wrapper3', $data);
			}
		} else {
			$data = array('title' => 'Playing VOD', 'menuaktif' => '28',
				'isi' => 'v_tentang');
			$data['message'] = $this->session->flashdata('message');
			$data['authURL'] = $this->facebook->login_url();
			$data['loginURL'] = $this->google->loginURL();

			$this->load->view('layout/wrapper3', $data);
		}

	}

	public function bayar()
	{
		$data = array('title' => 'Pembayaran', 'menuaktif' => '0',
			'isi' => 'v_bayarfree');

		$this->load->view('layout/wrapper3', $data);
	}

	public function perpanjang()
	{
		$data = array('title' => 'Pembayaran', 'menuaktif' => '0',
			'isi' => 'v_perpanjang');

		$this->load->view('layout/wrapper3', $data);
	}

	public function faq()
	{
		$data = array();
		$data['konten'] = "faq";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function agency($idpropinsi=null)
	{
		$data = array('title' => 'FAQ', 'menuaktif' => '34',
			'isi' => 'v_infoagency');

		$this->load->model('M_login');
		$data['dafnegara'] = $this->M_login->dafnegara();
		$data['dafpropinsi'] = $this->M_login->dafpropinsi(1);
		$data['dafagency'] = $this->M_login->dafagency($idpropinsi);
		$data['idprop'] = $idpropinsi;
		$data['idnegara'] = 1;
		if ($idpropinsi==102)
		{
			$data['idnegara'] = 2;
			$data['dafagency'] = $this->M_login->dafagency($idpropinsi);
		}

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper3', $data);
	}

	public function cekinternet()
	{
		echo "connected";
	}

	public function daftarpengumuman()
	{
		$data = array('title' => 'Daftar Pengumuman', 'menuaktif' => '25',
			'isi' => 'v_pengumuman');
		$this->load->model("M_induk");

		if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4)
			$data['datapengumuman'] = $this->M_induk->getAllPengumuman();
		else
			redirect('/');
		$this->load->view('layout/wrapper2', $data);
	}

	public function tambahpengumuman()
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4)
			redirect('/informasi/pengumuman');
		$data = array('title' => 'Tambahkan Pengumuman', 'menuaktif' => '27',
			'isi' => 'v_pengumuman_tambah');
		$data['addedit'] = "add";
		$mikro = str_replace(".", "", microtime(false));
		$mikro = str_replace(" ", "", $mikro);
		$mikro = base_convert($mikro, 10, 36);
		$data['code_pengumuman'] = $mikro;

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function editpengumuman($kdpengumuman = null)
	{
		if ($kdpengumuman == null) {
			redirect("/");
		}
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4)
			redirect('/informasi/pengumuman');
		$data = array('title' => 'Edit Pengumuman', 'menuaktif' => '27',
			'isi' => 'v_pengumuman_tambah');

		$data['addedit'] = "edit";
		$data['code_pengumuman'] = $kdpengumuman;
		$data['datapengumuman'] = $this->M_induk->getbyCodePengumuman($kdpengumuman);

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function updatepengumuman($codepengumuman)
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/informasi/pengumuman');
		}

		$addedit = $this->input->post('addedit');
		$cekfile = $this->input->post('adafile');
		$cekurl = $this->input->post('adaurl');

		$data['code_pengumuman'] = $codepengumuman;
		$data['nama_pengumuman'] = $this->input->post('inamaevent');
		$data['link_pengumuman'] = str_replace(" ", "-", $data['nama_pengumuman']);
		$data['link_pengumuman'] = str_replace("'", "", $data['link_pengumuman']);
		$data['link_pengumuman'] = str_replace('"', '', $data['link_pengumuman']);
		$data['link_pengumuman'] = strtolower($data['link_pengumuman']) . "-" . rand(100, 999);
		$data['isi_pengumuman'] = $this->input->post('iisievent');
		if ($this->input->post('nmgambar') != "")
			$data['gambar'] = "img_" . $codepengumuman . "." . $this->input->post('nmgambar');
		if ($cekfile == "1") {
			if ($this->input->post('nmfile') != "")
				$data['file'] = "dok_" . $codepengumuman . "." . $this->input->post('nmfile');
		} else
			$data['file'] = "";

		if ($cekurl == "1") {
			$data['url'] = $this->input->post('linkurl');
			$data['tombolurl'] = $this->input->post('tombolurl');
		} else {
			$data['url'] = "";
			$data['tombolurl'] = "";
		}

		$tgmulai = $this->input->post('datetime');
		$data['tgl_mulai'] = substr($tgmulai, 6, 4) . "-" . substr($tgmulai, 3, 2) . "-" . substr($tgmulai, 0, 2);
		$tgselesai = $this->input->post('datetime2');
		$data['tgl_selesai'] = substr($tgselesai, 6, 4) . "-" . substr($tgselesai, 3, 2) . "-" . substr($tgselesai, 0, 2);
		$data['status'] = 1;

		if ($addedit == 'edit') {
			$this->M_induk->updatepengumuman($data, $codepengumuman);
		} else {
			$this->M_induk->addpengumuman($data);
		}

		redirect('/informasi/daftarpengumuman');
	}


	public function hapusevent($kodeevent)
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/event');
		}
		$this->M_video->delevent($kodeevent);
		redirect('/event/spesial/admin');
	}

	public function hapuspengumuman($kode)
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/informasi/pengumuman');
		}
		$this->M_induk->delpengumuman($kode);
		redirect('/informasi/daftarpengumuman');
	}

	public function upload_foto_pengumuman($codepengumuman)
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/informasi');
		}

		$addedit = $_POST['fotoaddedit'];

		if (isset($_FILES['file'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "pengumuman/";
		$allow = "jpg|png";

		$config = array(
			'upload_path' => "uploads/" . $path1,
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "204800000",
			//'max_height' => "768",
			//'max_width' => "1024"
		);

		$this->load->library('upload', $config);
		if ($this->upload->do_upload("file")) {

			$dataupload = array('upload_data' => $this->upload->data());

			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "img_" . $codepengumuman . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			if ($addedit == "edit") {
				//rename($alamat . $namafile1, $alamat . $namafilebaru);
				echo "Foto berhasil diubah";
			} else {
				//rename($alamat . $namafile1, $alamat.'image0.jpg');
				echo "Foto siap digunakan";
			}


			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			echo $this->upload->display_errors();
		}
	}

	public function upload_dok($codepengumuman)
	{

		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/informasi');
		}
		//$idpromo = $_POST['idpromo'];

		$addedit = $_POST['dokaddedit'];

		if (isset($_FILES['file'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "pengumuman/";
		$allow = "pdf";

		$config = array(
			'upload_path' => "uploads/" . $path1,
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "204800000",

			//'max_height' => "768",
			//'max_width' => "1024"
		);

		$this->load->library('upload', $config);
		if ($this->upload->do_upload("file")) {

			$dataupload = array('upload_data' => $this->upload->data());

			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "dok_" . $codepengumuman . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			if ($addedit == "edit") {

				echo "Dokumen sudah diperbarui";
			} else {
				//rename($alamat . $namafile1, $alamat.'dok0.pdf');
				echo "Dokumen siap";
			}

			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			echo $this->upload->display_errors();
		}
	}

	public function di_download($kodeevent)
	{
		$this->load->model('M_induk');
		$dataevent = $this->M_induk->getbyCodeEvent($kodeevent);
		force_download('uploads/pengumuman/' . $dataevent[0]->file, null);
	}

	public function di_download_ae()
	{
		force_download('uploads/pengumuman/dokumen_ae.pdf', null);
	}

	public function di_download_am()
	{
		force_download('uploads/pengumuman/dokumen_am.pdf', null);
	}

	public function infobimbel()
	{
		$data = array();
		$data['konten'] = "v_informasibimbel";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function tungguhasil()
	{
		$data = array();
		$data['konten'] = 'v_tunggu_hasil';

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function tungguhasilagency()
	{
		$data = array();
		$data['konten'] = 'v_tunggu_cek_agency';

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function ceksertifikat($idpeserta)
	{
		$data = array();
		$data['konten'] = 'ekskul_ceksertifikat';

		$this->load->Model('M_ekskul');
		$getdatasiswaekskul = $this->M_ekskul->getSiswaEkskul($idpeserta);
		if ($getdatasiswaekskul) {
			$nomor = "Nomor:".$getdatasiswaekskul->id."/e-cert/ekskul/tvs/".date("Y");
			$nama = $getdatasiswaekskul->first_name. " ". $getdatasiswaekskul->last_name;
			$kegiatan = "Bahwa yang bersangkutan telah aktif mengikuti kegiatan Ekstrakurikuler ".
				"TV Kampus untuk periode tahun ".date("Y");
			$tanggal = "Jakarta, ".nmbulan_panjang(date("n"))." ".date("Y");
			$data['nomor'] = $nomor;
			$data['nama'] = $nama;
			$data['kegiatan'] = $kegiatan;
			$data['tanggal'] = $tanggal;
		} else {
			$data['nomor'] = "-";
		}

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function send_email_info($indeks)
	{
		$this->load->Model('M_umum');
		$getemail = $this->M_umum->getEmailUser200($indeks);
		$dataemail= "";
		foreach ($getemail as $datane)
		{
			$dataemail = $dataemail . $datane->email.",";
		}
		//$dataemail = implode(",", $getemail);

		$dataemail = substr_replace($dataemail ,"", -1);

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
		$this->email->to($dataemail);
		$this->email->subject('Sertifikat Donasi');
		$this->email->message($message);
//		$this->email->message($message);
		$this->email->attach(base_url() . 'uploads/sertifikat/sert_donasi_' . $orderid . '.pdf');

//		echo ("Hasil:".base_url().'uploads/sertifikat/sert_donasi_'.$orderid.'.pdf');
//		die();

//		if ($this->email->send()) {
//			echo "Berhasil";
//		} else {
//			//echo "Gagal";
//			$this->session->set_flashdata('message', $this->email->print_debugger());
//			echo($this->email->print_debugger());
//			die();
//		}

	}

	public function promobayardulu()
	{
		$data = array();
		$data['konten'] = "promobayardulu";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function cekdatabase()
	{
		$this->load->Model('M_jurnal');
		$getdata = $this->M_jurnal->getdata();
		echo "<pre>";
		echo var_dump($getdata);
		echo "</pre>";
	}

}


