<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('video', 'tanggalan'));
		$this->load->model('M_umum');
		$this->load->model('M_event');
		$this->load->Model("M_video");
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->library('Pdf');

		$this->load->helper(array('Form', 'Cookie', 'String', 'captcha', 'download', 'statusverifikator'));
	}

	public function index()
	{
		setcookie('basis', "live", time() + (86400), '/');
		$data = array();
		$data['konten'] = 'v_live';

		//$data['daf_promo'] = $this->M_video->getPilihanPromo();
		$data['url_live'] = $this->M_video->get_url_live();
		date_default_timezone_set('Asia/Jakarta');
		$now = new DateTime();
		$harike = date_format($now, 'N');
		$data['harike'] = $harike;
		$data['jadwal_acara'] = $this->M_video->get_acara_live(0);
		$linklist = "live-hdkasj84";
		$this->load->model("M_channel");
		$datapesan = $this->M_channel->getChat(4, "", $linklist);
		$data['datapesan'] = $datapesan;
		$this->load->model("M_induk");
		$data['dafacara'] = $this->M_induk->get_acara_live(0);
		$data['linklist'] = $linklist;
		$data['idku'] = $this->session->userdata('id_user');
		$data['namasekolah'] = "";
		$data['jenis'] = "live";
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function spesial($param = null, $param2 = null)
	{

		if ($this->session->userdata('loggedIn') && $this->session->userdata('activate') == 0)
			redirect(base_url() . "login/profile");
		if ($param == 'admin') {
			if ($this->session->userdata('a01') || ($this->session->userdata('sebagai') == 4 && $this->session->userdata('verifikator') == 3)) {
				$this->daftarevent();
			} else {
				redirect('/event');
			}
		} else if ($param == 'acara') {
			$this->acara();
		} else if ($param == 'pilihan') {
			$this->pilihan($param2);
		} else {
			if ($param2 != "tambah") {
				$this->load->Model('M_video');
				$viaver = $this->M_video->getAllEvent($param);
				$cekviaver = $viaver[0]->viaverifikator;

				if (!$this->session->userdata('loggedIn')) {
					redirect("/");
				}

				if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4 || $this->M_video->cekEventAktifbyLink($param, $cekviaver)) {
					if ($this->M_video->cekUserLinkEvent($param, $this->session->userdata('id_user'))) {
						$data = array();
						$data['konten'] = 'v_video';
						if ($this->session->userdata('verifikator') == 3) {
							$getstatusver = getstatusverifikator();
							$statusverifikator = $getstatusver['status_verifikator'];
						} else {
							$statusverifikator = "bukan";
						}

						$data['status_verifikator'] = $statusverifikator;
						$data['statusvideo'] = 'semua';
						$data['linkdari'] = 'event';
						$data['linkevent'] = $param;
						$data['hal'] = $param2;
						$data['dataevent'] = $this->M_video->getAllEvent($param);
						$data['jmltugasvideo'] = $data['dataevent'][0]->jumlahvideo;
						$data['kodeevent'] = $data['dataevent'][0]->code_event;
						$viaver = $data['dataevent'][0]->viaverifikator;
						$data['subjudulevent'] = $data['dataevent'][0]->sub2_nama_event;
						$data['dafvideo'] = $this->M_video->getVideobyEvent($data['dataevent'][0]->id_event, $viaver);

						$this->load->view('layout/wrapper_tabel', $data);
					} else {
						redirect('/event/spesial/acara');
					}
				} else {
					redirect('/event/spesial/acara');
				}
			} else if ($param2 == "tambah") {
				$this->tambah($param);
			}
		}
	}

	function tambah($linkevent)
	{
		$data = array();
		$data['konten'] = 'v_video_tambah';
		$data['addedit'] = "add";
		$data['linkdari'] = "event";
		$data['linkevent'] = $linkevent;
		$this->load->Model('M_video');
		$data['dataevent'] = $this->M_video->getbyLinkEvent($linkevent);
		$data['kodeevent'] = $data['dataevent'][0]->code_event;
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['datavideo'] = Array('status_verifikasi' => 0);
		$data['idvideo'] = 0;
		$data['namafile'] = "";
		//	if ($judul!=null)
		//		$data['judulvideo'] = $judul;
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function tambahevent()
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4)
			redirect('/event');
		$data = array();
		$data['konten'] = 'v_event_tambah';
		$data['addedit'] = "add";
		$mikro = str_replace(".", "", microtime(false));
		$mikro = str_replace(" ", "", $mikro);
		$mikro = base_convert($mikro, 10, 36);
		$data['code_event'] = $mikro;
		$data2['code_event'] = $mikro;

		$this->load->model('M_video');
		$this->M_video->addevent($data2);

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function editevent($kdevent = null)
	{
		if ($kdevent == null) {
			redirect("/");
		}
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4)
			redirect('/event');
		$data = array();
		$data['konten'] = 'v_event_tambah';

		$data['addedit'] = "edit";
		$data['code_event'] = $kdevent;
		$this->load->Model("M_video");
		$data['dataevent'] = $this->M_video->getbyCodeEvent($kdevent);

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function updateevent($codeevent)
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/event');
		}

		$addedit = $this->input->post('addedit');
		$cekfile = $this->input->post('adafile');
		$cekurl = $this->input->post('adaurl');
		$cekurl2 = $this->input->post('adaurl2');
		$cekurl3 = $this->input->post('adaurl3');
		$cekurl4 = $this->input->post('adaurl4');
		$cekurl5 = $this->input->post('adaurl5');
		
		$cekhal2 = $this->input->post('adah2');
		if ($cekhal2 == "tidak")
			$data['file_sertifikat_hal2'] = "";

		$data['code_event'] = $codeevent;
		$data['nama_event'] = $this->input->post('inamaevent');
		$data['sub_nama_event'] = $this->input->post('isubjudul');
		$data['sub2_nama_event'] = $this->input->post('iket');
		$data['iuran'] = $this->input->post('iiuran');
		$data['butuhuploadvideo'] = $this->input->post('adavideo');
		$data['butuhuploadmodul'] = $this->input->post('adapaket');
		$data['butuhuploadplaylist'] = $this->input->post('adaplaylist');

		if ($this->input->post('adavideo') == 1)
			$data['jumlahvideo'] = $this->input->post('jmlvideo');
		else
			$data['jumlahvideo'] = 0;

		if ($this->input->post('adapaket') == 1 || $this->input->post('adapaket') == 2)
			$data['jumlahmodul'] = $this->input->post('jmlpaket');
		else
			$data['jumlahmodul'] = 0;

		if ($this->input->post('adaplaylist') == 1)
			$data['jumlahplaylist'] = $this->input->post('jmlplaylist');
		else
			$data['jumlahplaylist'] = 0;

		$pnama = $this->input->post('posnama');
		$p_nama = explode(",", $pnama);
		$data['pos_nama'] = $p_nama[0] . "," . $p_nama[1] . "," . $p_nama[2] . "," . $p_nama[3] . "," . $p_nama[4] . "," . $p_nama[5];
		$pqr = $this->input->post('posqr');
		$p_qr = explode(",", $pqr);
		$data['posqr1'] = $p_qr[0] . "," . $p_qr[1] . "," . $p_qr[2];
		$data['posqr2'] = strval(297 - intval($p_qr[2]) - intval($p_qr[0])) . "," . $p_qr[1] . "," . $p_qr[2];

		$data['isi_event'] = $this->input->post('iisievent');
//		if ($this->input->post('nmgambar') != "")
//			$data['gambar'] = "img_" . $codeevent . "." . $this->input->post('nmgambar');
//		if ($this->input->post('nmgambar2') != "")
//			$data['gambar2'] = "img_" . $codeevent . "_m." . $this->input->post('nmgambar2');
		if ($cekfile == "1") {
			if ($this->input->post('nmfile') != "")
				$data['file'] = "dok_" . $codeevent . "." . $this->input->post('nmfile');
		} else
			$data['file'] = "";

		$data['viaverifikator'] = $this->input->post('viaver');
		$data['pakaisertifikat'] = $this->input->post('sertifikat');

		$data['hidereg'] = $this->input->post('hidereg');

		if ($cekurl == "1") {
			$data['url'] = $this->input->post('linkurl');
			$data['tombolurl'] = $this->input->post('tombolurl');
			$data['url_after_reg'] = $this->input->post('afterreg');

			$tgaktif = $this->input->post('tgleventaktif');
			$data['url_aktif_tgl'] = substr($tgaktif, 6, 4) . "-" . substr($tgaktif, 3, 2) .
				"-" . substr($tgaktif, 0, 2) . " " . substr($tgaktif, 11, 8);
		} else {
			$data['url'] = "";
			$data['tombolurl'] = "";
			$data['url_after_reg'] = 0;
		}

		if ($cekurl2 == "1") {
			$data['url2'] = $this->input->post('linkurl2');
			$data['tombolurl2'] = $this->input->post('tombolurl2');
			$data['url_after_reg2'] = $this->input->post('afterreg2');

			$tgaktif2 = $this->input->post('tgleventaktif2');
			$data['url_aktif_tgl2'] = substr($tgaktif2, 6, 4) . "-" . substr($tgaktif2, 3, 2) .
				"-" . substr($tgaktif2, 0, 2) . " " . substr($tgaktif2, 11, 8);
		} else {
			$data['url2'] = "";
			$data['tombolurl2'] = "";
			$data['url_after_reg2'] = 0;
		}

		if ($cekurl3 == "1") {
			$data['url3'] = $this->input->post('linkurl3');
			$data['tombolurl3'] = $this->input->post('tombolurl3');
			$data['url_after_reg3'] = $this->input->post('afterreg3');

			$tgaktif3 = $this->input->post('tgleventaktif3');
			$data['url_aktif_tgl3'] = substr($tgaktif3, 6, 4) . "-" . substr($tgaktif3, 3, 2) .
				"-" . substr($tgaktif3, 0, 2) . " " . substr($tgaktif3, 11, 8);
		} else {
			$data['url3'] = "";
			$data['tombolurl3'] = "";
			$data['url_after_reg3'] = 0;
		}

		if ($cekurl4 == "1") {
			$data['url4'] = $this->input->post('linkurl4');
			$data['tombolurl4'] = $this->input->post('tombolurl4');
			$data['url_after_reg4'] = $this->input->post('afterreg4');

			$tgaktif4 = $this->input->post('tgleventaktif4');
			$data['url_aktif_tgl4'] = substr($tgaktif4, 6, 4) . "-" . substr($tgaktif4, 3, 2) .
				"-" . substr($tgaktif4, 0, 2) . " " . substr($tgaktif4, 11, 8);
		} else {
			$data['url4'] = "";
			$data['tombolurl4'] = "";
			$data['url_after_reg4'] = 0;
		}

		if ($cekurl5 == "1") {
			$data['url5'] = $this->input->post('linkurl5');
			$data['tombolurl5'] = $this->input->post('tombolurl5');
			$data['url_after_reg5'] = $this->input->post('afterreg5');

			$tgaktif5 = $this->input->post('tgleventaktif5');
			$data['url_aktif_tgl5'] = substr($tgaktif5, 6, 4) . "-" . substr($tgaktif5, 3, 2) .
				"-" . substr($tgaktif5, 0, 2) . " " . substr($tgaktif5, 11, 8);
		} else {
			$data['url5'] = "";
			$data['tombolurl5'] = "";
			$data['url_after_reg5'] = 0;
		}

		$tgmulai = $this->input->post('datetime');
		$data['tgl_mulai'] = substr($tgmulai, 6, 4) . "-" . substr($tgmulai, 3, 2) . "-"
			. substr($tgmulai, 0, 2) . " " . substr($tgmulai, 11, 8);
		$tgselesai = $this->input->post('datetime2');
		$data['tgl_selesai'] = substr($tgselesai, 6, 4) . "-" . substr($tgselesai, 3, 2) . "-"
			. substr($tgselesai, 0, 2) . " " . substr($tgselesai, 11, 8);

		$tgregmati = $this->input->post('tglregistermati');
		$data['tgl_batas_reg'] = substr($tgregmati, 6, 4) . "-" . substr($tgregmati, 3, 2) . "-"
			. substr($tgregmati, 0, 2) . " " . substr($tgregmati, 11, 8);
		$tgseraktif = $this->input->post('tglsertifikataktif');
		$data['tgl_mulai_sertifikat'] = substr($tgseraktif, 6, 4) . "-" . substr($tgseraktif, 3, 2) . "-"
			. substr($tgseraktif, 0, 2) . " " . substr($tgseraktif, 11, 8);

		$data['link_event'] = str_replace(" ", "-", $data['nama_event']);
		$data['link_event'] = str_replace("'", "", $data['link_event']);
		$data['link_event'] = str_replace('"', '', $data['link_event']);
		$data['link_event'] = str_replace('/', '-', $data['link_event']);
		$data['link_event'] = strtolower($data['link_event']) . "-" . substr($tgmulai, 3, 2) . "-"
			. substr($tgmulai, 0, 2);


		$data['status'] = 1;

		$this->load->Model("M_video");

		if ($addedit == 'edit') {
			$this->M_video->updateevent($data, $codeevent);
		} else {
			$this->M_video->addevent($data);
		}

		redirect('/event/spesial/admin');
	}


	public function hapusevent($kodeevent)
	{
		if (!$this->session->userdata('a01')) {
			redirect('/event');
		}
		$this->load->Model("M_video");
		$this->M_video->delevent($kodeevent);
		redirect('/event/spesial/admin');
	}

	public function hapususerevent($kodeevent, $iduser)
	{
		if (!$this->session->userdata('a01')) {
			redirect('/');
		}
		$this->load->Model("M_video");
		$this->M_video->deluserevent($kodeevent, $iduser);
		redirect('/event/aktivasi_event/' . $kodeevent);
	}


	public function upload_foto_event($codeevent)
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/event');
		}

		$addedit = $_POST['fotoaddedit'];
		$random = rand(100, 999);
		if (isset($_FILES['file'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "event/";
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

			$namafilebaru = "img_" . $random . "_" . $codeevent . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$this->load->Model("M_video");
			$this->M_video->updatefotoevent($namafilebaru, $codeevent);

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

	public function upload_foto_event2($codeevent)
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/event');
		}

		$addedit = $_POST['fotoaddedit2'];
		$random = rand(100, 999);

		if (isset($_FILES['file'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "event/";
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

			$namafilebaru = "img_" . $random . "_" . $codeevent . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$this->load->Model("M_video");
			$this->M_video->updatefotoevent2($namafilebaru, $codeevent);

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

	public function upload_foto_sertifikat($codeevent, $kodefield, $kodefield2)
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/event');
		}

		$addedit = $_POST['fotoaddedit' . $kodefield];
		$random = rand(100, 999);
		if (isset($_FILES['file' . $kodefield])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "temp_sertifikat/";
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
		if ($this->upload->do_upload("file" . $kodefield)) {
//			$gbr = $this->upload->data();
			$dataupload = array('upload_data' => $this->upload->data());

//			$config['image_library']='gd2';
//			$config['source_image']='./uploads/temp_sertifikat/'.$gbr['file_name'];
//			$config['create_thumb']= FALSE;
//			$config['maintain_ratio']= TRUE;
//			$config['quality']= '50%';
//			$config['width']= 1280;
//			$config['new_image']='./uploads/temp_sertifikat/'.$gbr['file_name'];
//			$this->load->library('image_lib', $config);
//			$this->load->library('image_lib');
//			$this->image_lib->initialize($config);
//			if (!$this->image_lib->resize()) {
//				echo $this->image_lib->display_errors();
//			}
//			$this->image_lib->clear();

			$namafile1 = $dataupload['upload_data']['file_name'];
//			$namafile1 = $gbr['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "sert" . $kodefield . "_" . $random . "_" . $codeevent . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$this->M_video->updatefotosertifikat($namafilebaru, $codeevent, $kodefield2);

			if ($addedit == "edit") {
				//rename($alamat . $namafile1, $alamat . $namafilebaru);
				echo "Sertifikat berhasil diubah";
			} else {
				//rename($alamat . $namafile1, $alamat.'image0.jpg');
				echo "Sertifikat siap digunakan";
			}


			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			echo $this->upload->display_errors();
		}
	}

	public function upload_bukti($codeevent)
	{
		if ($this->session->userdata('verifikator') != 3) {
			redirect('/event');
		}

		if (isset($_FILES['file'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "event/bukti/";
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

			$namafilebaru = "bukti_" . $this->session->userdata('npsn') . "_" . $codeevent . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			echo "Bukti Transfer tersimpan";

			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			echo $this->upload->display_errors();
		}
	}

	public function upload_dok($codeevent)
	{

		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
			redirect('/event');
		}
		//$idpromo = $_POST['idpromo'];

		$addedit = $_POST['dokaddedit'];

		if (isset($_FILES['file'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "event/";
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

			$namafilebaru = "dok_" . $codeevent . "." . $ext['extension'];
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
		//die();
		$dataevent = $this->M_video->getbyCodeEvent($kodeevent);
		// echo ($datapromo['nama_file']);
		force_download('uploads/event/' . $dataevent[0]->file, null);
		//force_download($dataevent[0]->link_event.'.pdf',base_url().'uploads/event/'.$dataevent[0]->file);
	}

	public function addbuktibayar($codeevent)
	{
		if ($this->session->userdata('verifikator') != 3) {
			redirect('/event');
		}

		$data['code_event'] = $codeevent;
		$data['id_user'] = $this->session->userdata('id_user');
		$data['npsn'] = $this->session->userdata('npsn');
		$data['nama_bank'] = $this->input->post('inamabank');
		$data['no_rek'] = $this->input->post('inorek');
		$data['nama_rek'] = $this->input->post('inamarek');
		$data['status_user'] = 1;

		if ($this->input->post('nmgambar') != "")
			$data['gambar'] = "bukti_" . $this->session->userdata('npsn') . "_" .
				$codeevent . "." . $this->input->post('nmgambar');

		$this->M_video->addbukti($data);

		redirect('/event/spesial/acara');
	}

	public function daftarevent()
	{
		$data = array();
		$data['konten'] = 'v_event';
		$this->load->model("M_video");

		if ($this->session->userdata('a01') || ($this->session->userdata('sebagai') == 4 && $this->session->userdata('verifikator') == 3))
			$data['dataevent'] = $this->M_video->getAllEvent();
		else
			redirect('/event');
		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function ikutevent($codeevent, $hal = null)
	{
		if (!$this->session->userdata('loggedIn')) {
			$this->session->set_userdata('ikutevent', $codeevent . "/" . $hal);
			redirect("/login");
		} else {
			$this->session->unset_userdata('ikutevent');
			$data = array();
			$data['konten'] = 'v_event_ikut';
			$data['hal'] = $hal;

			$this->load->Model('M_video');
			$cekbyver = $this->M_video->getEventbyCode($codeevent);
			$cekbyver = $cekbyver[0]->viaverifikator;

			if ($cekbyver == 0)
				$iduser = $this->session->userdata('id_user');
			else
				$iduser = null;

			$data['eventaktif'] = $this->M_video->getbyCodeEvent($codeevent, $iduser);
			$data['viaver'] = $cekbyver;
			$data['codeevent'] = $codeevent;

			$this->load->view('layout/wrapper_payment', $data);
		}
	}

	public function gantistatus()
	{
		$this->load->model('M_video');
		$code = $_POST['code'];
		$statusnya = $_POST['status'];
		$this->M_video->updatestatus($code, $statusnya);
//		echo 'ok';
	}

	public function gantidefault()
	{
		$this->load->model('M_video');
		$code = $this->input->post('code');
		$defaultnya = $this->input->post('status');
		$this->M_video->updatedefault($code, $defaultnya);
//		echo 'ok';
	}

	public function gantistatususer()
	{
		if ($this->session->userdata('verifikator') != 3)
			redirect('/event');
		$this->load->model('M_video');
		$code = $_POST['code'];
		$npsn = $_POST['npsn'];
		$statusnya = $_POST['status'];
		$this->M_video->updatestatususer($code, $npsn, $statusnya);
//		echo 'ok';
	}

	public function konfirmasi($kdevent)
	{
		if ($this->session->userdata('verifikator') != 3)
			redirect('/event');
		$data = array('title' => 'Konfirmasi Pembayaran', 'menuaktif' => '21',
			'isi' => 'v_event_konfirmasi');

		$data['code_event'] = $kdevent;
		$data['dataevent'] = $this->M_video->getbyCodeEvent($kdevent);

		$this->load->view('layout/wrapperinduk2', $data);
	}

	function acara($hal = null, $kodeevent = null)
	{
		if (!$this->session->userdata('loggedIn') && $kodeevent != null) {
			redirect("/");
		}

		$iduser = null;
		if (isset($this->session->userdata['id_user']))
			$iduser = $this->session->userdata('id_user');

		$order_id_akhir = $this->cekstatusbayarakhirevent($iduser);
		if ($order_id_akhir != "")
			redirect("/payment/tunggubayar_event/" . $order_id_akhir);

		if ($hal==null)
			$halmn=1;
		else
			$halmn = $hal;
		setcookie('acara', $halmn, time() + (86400), '/');

		$data = array();
		$data['konten'] = "event_aktif";
		if ($hal == null)
			$hal = 1;
		$data['hal'] = $hal;

		$getallevent = $this->M_event->getAllEventAktif($kodeevent, "acara");

//		echo "<pre>";
//		echo var_dump($getallevent);
//		echo "</pre>";
//		die();
		if ($getallevent) {
			$data['eventaktif'] = $getallevent[$hal - 1];
			$data['jmleventaktif'] = sizeof($getallevent);

			$data['asal'] = "acara";
			if (isset($iduser))
				$data['datadiri'] = $this->M_umum->getUserbyId($this->session->userdata('id_user'));

			if (!isset($this->session->userdata['npsn']))
				$data['npsnku'] = "999";
			else
				$data['npsnku'] = $this->session->userdata('npsn');
			if ($data['eventaktif']) {
				$data['meta_title'] = $data['eventaktif']->nama_event;
				$data['sub_title'] = $data['eventaktif']->sub_nama_event;
				$data['sub_title2'] = $data['eventaktif']->sub2_nama_event;
				//$data['meta_description'] = strip_tags($data['eventaktif']->isi_event);
				$data['meta_description'] = ($data['eventaktif']->isi_event);
				$data['meta_image'] = base_url() . "uploads/event/" . $data['eventaktif']->gambar;
				$data['meta_url'] = base_url() . "event/spesial/pilihan/" . $data['eventaktif']->link_event;
				$tglbatasreg = $data['eventaktif']->tgl_batas_reg;
				$data['batasreg'] = $tglbatasreg;
				$data['tb1'] = $data['eventaktif']->tombolurl;
				$data['link1'] = $data['eventaktif']->url;
				$data['dafdulu1'] = $data['eventaktif']->url_after_reg;
				$data['tb2'] = $data['eventaktif']->tombolurl2;
				$data['link2'] = $data['eventaktif']->url2;
				$data['dafdulu2'] = $data['eventaktif']->url_after_reg2;
				$data['tb3'] = $data['eventaktif']->tombolurl3;
				$data['link3'] = $data['eventaktif']->url3;
				$data['dafdulu3'] = $data['eventaktif']->url_after_reg3;
				$data['tb4'] = $data['eventaktif']->tombolurl4;
				$data['link4'] = $data['eventaktif']->url4;
				$data['dafdulu4'] = $data['eventaktif']->url_after_reg4;
				$data['tb5'] = $data['eventaktif']->tombolurl5;
				$data['link5'] = $data['eventaktif']->url5;
				$data['dafdulu5'] = $data['eventaktif']->url_after_reg5;
				$data['status_user'] = $data['eventaktif']->status_user;
				$data['linklist'] = $data['eventaktif']->code_event;
				$data['linkevent'] = $data['eventaktif']->link_event;
				$data['butuhuploadvideo'] = $data['eventaktif']->butuhuploadvideo;
				$data['jumlahvideo'] = $data['eventaktif']->jumlahvideo;
				$data['butuhuploadplaylist'] = $data['eventaktif']->butuhuploadvideo;
				$data['jumlahvideo'] = $data['eventaktif']->jumlahvideo;
				$data['jumlahplaylist'] = $data['eventaktif']->jumlahplaylist;
				$data['jumlahmodul'] = $data['eventaktif']->jumlahmodul;
				$data['hidereg'] = $data['eventaktif']->hidereg;
				$data['hal'] = $hal;

				$now = new DateTime();
				$now->setTimezone(new DateTimezone('Asia/Jakarta'));
				$tglsekarang = $now->format('Y-m-d H:i:s');
				if (strtotime($tglsekarang) <= strtotime($tglbatasreg)) {
					$data['telatdaftar'] = 0;
				} else {
					$data['telatdaftar'] = 1;
				}

				if ($this->session->userdata('loggedIn'))
					$data['cektugas'] = $this->cektugasvideo($data['eventaktif']->link_event, $data['eventaktif']);
				
					// echo $data['eventaktif']->link_event."<br>";
					//echo $data['eventaktif'];
//			if ($this->session->userdata('email')=="rosse.larasati@gmail.com")
//			{
				// echo "<pre>";
				// echo var_dump($data['eventaktif']);
				// echo "</pre>";
//			}


			}

		} else {
			$data['konten'] = "event_kosong";
		}

		$this->load->view('layout/wrapper_umum', $data);

	}

	function pilihan($link)
	{
		if ($this->session->userdata('loggedIn') && $this->session->userdata('activate') == 0)
			redirect(base_url() . "login/profile");
		{
			$data = array();
			$data['konten'] = 'v_event_aktif';
			$this->load->Model("M_video");
			$ceklink = $this->M_video->getAllEventAktif($link);

			if ($ceklink) {
				$data['eventaktif'] = $ceklink;
				if (isset($this->session->userdata['id_user']))
					$data['datadiri'] = $this->M_video->getUserbyId($this->session->userdata('id_user'));
			} else {
				redirect("/");
			}
			$data['asal'] = "pilihan";

			if (!isset($this->session->userdata['npsn']))
				$data['npsnku'] = "999";
			else
				$data['npsnku'] = $this->session->userdata('npsn');

			$data['meta_title'] = $data['eventaktif'][0]->nama_event;
			$data['meta_description'] = strip_tags($data['eventaktif'][0]->isi_event);
			$data['meta_image'] = base_url() . "uploads/event/" . $data['eventaktif'][0]->gambar;
			$data['meta_url'] = base_url() . "event/spesial/pilihan/" . $data['eventaktif'][0]->link_event;


			$this->load->view('layout/wrapper_umum', $data);
		}
	}

	public function terdaftar($link)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect("/");
		}

		$data = array('title' => 'Acara Event', 'menuaktif' => '26',
			'isi' => 'v_event_terdaftar');
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$ceklink = $this->M_video->cekUserEvent($link, $this->session->userdata('id_user'));

//		echo 'RESULT <br><pre>';
//        var_dump($ceklink);
//        echo '</pre>' ;

		if ($ceklink) {
			$data['namaevent'] = $ceklink[0]->nama_event;
			$data['linkevent'] = $ceklink[0]->link_event;
			$this->load->view('layout/wrapper3', $data);
		} else {
			redirect("/");
		}
	}

	public function daftarvideo($kodeevent)
	{
		setcookie('basis', "event", time() + (86400), '/');
		$data = array('title' => 'Daftar Video Event', 'menuaktif' => '14',
			'isi' => 'v_video');

		$data['statusvideo'] = 'event';
		$data['linkdari'] = "event";

		if ($this->is_connected())
			$data['nyambung'] = true;
		else
			$data['nyambung'] = false;
		$this->load->model("M_video");

		$id_user = $this->session->userdata('id_user');
		if ($this->session->userdata('a01') || ($this->session->userdata('sebagai') == 4 && $this->session->userdata('verifikator') == 3)) {
			$data['dafvideo'] = $this->M_video->getVideoAll();
			$data['statusvideo'] = 'admin';
		} else if ($this->session->userdata('a02') && $this->session->userdata('sebagai') != 4) {
			$data['dafvideo'] = $this->M_video->getVideoSekolah($this->session->userdata('npsn'));
			$data['statusvideo'] = 'sekolah';
//		} else if ($this->session->userdata('a03')) {
//            $data['dafvideo'] = $this->M_video->getVideoUser($id_user);
//            $data['statusvideo'] = 'pribadi';
		} else {
			redirect("/");
		}

		$this->load->view('layout/wrapper', $data);
	}

	public function aktivasi_event($codeevent, $opsi = null)
	{
		if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4) {
			$data = array();
			$data['konten'] = 'v_event_aktivasi';

			$data['namaevent'] = $this->M_video->getEventbyCode($codeevent)[0]->nama_event;
			$data['cekver'] = $this->M_video->getEventbyCode($codeevent)[0]->viaverifikator;
			$data['dafuserevent'] = $this->M_video->getAllUserEvent($codeevent, $opsi);
			$data['golongan'] = $opsi;
			$data['codeevent'] = $codeevent;

			$this->load->view('layout/wrapper_umum', $data);
		} else {
			redirect('/');
		}
	}

	public function pilih_narsum($codeevent, $idnarsum = null)
	{
		if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4) {
			$data = array();
			$data['konten'] = 'v_event_pilihnarsum';

			$data['namaevent'] = $this->M_video->getEventbyCode($codeevent)[0]->nama_event;
			$data['cekver'] = $this->M_video->getEventbyCode($codeevent)[0]->viaverifikator;
			$data['dafnarsum'] = $this->M_video->getAllNarsum($codeevent);
			$data['codeevent'] = $codeevent;
			$data['idnarsum'] = $idnarsum;

			$this->load->view('layout/wrapper_umum', $data);
		} else {
			redirect('/');
		}
	}

	public function cekstatusbayarevent($code_event)
	{
		$npsn = $this->session->userdata('npsn');
		$this->load->model('M_video');

		$cekbyver = $this->M_video->getEventbyCode($code_event);
		$cekbyver = $cekbyver[0]->viaverifikator;

		if ($cekbyver == 0)
			$iduser = $this->session->userdata('id_user');
		else
			$iduser = null;

		if ($this->M_video->cekstatusbayarevent($code_event, $npsn, $iduser))
			$isi = $this->M_video->cekstatusbayarevent($code_event, $npsn, $iduser)->status_user;
		else
			$isi = 0;

		$hasil = "belum";
		if ($isi == 2)
			$hasil = "lunas";
		echo json_encode($hasil);
	}

	private function cekstatusbayarakhirevent($iduser)
	{
		$this->load->model('M_video');

		$cekbayarakhir = $this->M_video->cekstatusbayarakhirevent($iduser);

//		echo "<pre>";
//		echo var_dump($cekbayarakhir);
//		echo "</pre>";
//		die();

		if ($cekbayarakhir)
			$isi = $this->M_video->cekstatusbayarakhirevent($iduser)->status_user;
		else
			$isi = 0;

		$hasil = "";
		if ($isi == 1)
			$hasil = $this->M_video->cekstatusbayarakhirevent($iduser)->order_id;
		return $hasil;

	}

	public function is_connected($sCheckHost = 'www.google.com')
	{
		// return (bool)@fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
		//echo file_get_contents("127.0.0.1/fordorum/informasi/cekinternet");
		$ambil = file_get_contents("https://tvsekolah.id/informasi/cekinternet");
		if ($ambil == "connected")
			return true;
		else
			return false;
		//die();
	}

	public function vervideo()
	{
		if ($this->session->userdata('a01') || $this->session->userdata('a02')) {
			$data = array('title' => 'Daftar Video', 'menuaktif' => '3',
				'isi' => 'v_videoevent');
			if ($this->session->userdata('tukang_verifikasi') == 1)
				$data['dafvideo'] = $this->M_video->getVideoVer1($this->session->userdata('npsn'));
			else if ($this->session->userdata('tukang_verifikasi') == 2)
				$data['dafvideo'] = $this->M_video->getVideoAllLain();
			else if ($this->session->userdata('a01'))
				$data['dafvideo'] = $this->M_video->getVideoAll();

			$data['statusvideo'] = 'verifikasi';
			$this->load->view('layout/wrapper', $data);
		}
	}

	public function tambahmp4()
	{
		$data = array('title' => 'Tambahkan Video', 'menuaktif' => '3',
			'isi' => 'v_video_tambahmp4');
		$data['addedit'] = "add";
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['datavideo'] = Array('status_verifikasi' => 0);
		$data['idvideo'] = 0;
		$data['namafile'] = "";
		//	if ($judul!=null)
		//		$data['judulvideo'] = $judul;
		$this->load->view('layout/wrapper', $data);
	}

	public function edit($kode, $id_video)
	{
		$data = array();
		$data['konten'] = 'v_video_tambah';

		$data['linkdari'] = "event";
		$data['kodeevent'] = $kode;

		$data['addedit'] = "edit";
		$this->load->model("M_video");
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['datavideo'] = $this->M_video->getVideo($id_video);

		$iduservideo = $data['datavideo']['id_user'];
		if ($iduservideo!=$this->session->userdata("id_user"))
		redirect("/");

		$data['dafkelas'] = $this->M_video->dafKelas($data['datavideo']['id_jenjang']);
		$data['dataevent'] = $this->M_video->getbyCodeEvent($kode);
		$data['dafmapel'] = $this->M_video->dafMapel($data['datavideo']['id_jenjang'], $data['datavideo']['id_jurusan']);

		$data['dafjurusan'] = $this->M_video->dafJurusan();

		$data['idvideo'] = $id_video;

		$data['jenisvideo'] = "mp4";
		if ($data['datavideo']['link_video'] != "") {
			//$idyoutube=substr($data['datavideo']['link_video'],32,11);
			//$data['infodurasi'] = $this->getVideoInfo($idyoutube);
			$data['jenisvideo'] = "yt";
		}

		$data['dafkd1'] = $this->M_video->dafKD($data['datavideo']['kdnpsn'], $data['datavideo']['kdkur'], $data['datavideo']['id_kelas'], $data['datavideo']['id_mapel'], $data['datavideo']['id_ki1']);
		$data['dafkd2'] = $this->M_video->dafKD($data['datavideo']['kdnpsn'], $data['datavideo']['kdkur'], $data['datavideo']['id_kelas'], $data['datavideo']['id_mapel'], $data['datavideo']['id_ki2']);
		$this->load->view('layout/wrapper', $data);
	}

	public function getVideoInfo($vidkey)
	{
		$apikey = "AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU";
		$dur = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails,snippet&id=$vidkey&key=$apikey");
		$VidDuration = json_decode($dur, true);
		foreach ($VidDuration['items'] as $vidTime) {
			$VidDuration = $vidTime['contentDetails']['duration'];
//			$channel = $vidTime['snippet']['channelId'];
//			//$dur = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails,snippet&id=$vidkey&key=$apikey");
//			//$datayt = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails,statistics&mine=true&access_token=smohLqUHcpdkt9RKauZ8zOJNieyIQjxw");
//			//$daty = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=brandingSettings&mine=true&key=AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU");
//			$daty = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=id%2Csnippet%2Cstatistics%2CcontentDetails%2CtopicDetails&id=".$channel."&key=AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU");
//			echo $channel.'<br>';
//			echo $daty;
//			die();
			preg_match_all('/(\d+)/', $VidDuration, $parts);
//            echo "UKURAN:".$uk_wkt;
			if ($VidDuration == "P0D") {
				$totalSec = "00:00:00";
			} else {
				$uk_wkt = sizeof($parts[0]);
				$hours = 0;
				$minutes = 0;
				$seconds = 0;

				if ($uk_wkt == 3) {
					$hours = intval(floor($parts[0][0]));
					$minutes = intval($parts[0][1]);
					$seconds = intval($parts[0][2]);
				} else if ($uk_wkt == 2) {
					$minutes = intval($parts[0][0]);
					$seconds = intval($parts[0][1]);
				} else if ($uk_wkt == 1) {
					$seconds = intval($parts[0][0]);
				}


				if ($hours < 10) {
					$hours = "0" . $hours;
				}
				if ($minutes < 10) {
					$minutes = "0" . $minutes;
				}
				if ($seconds < 10) {
					$seconds = "0" . $seconds;

					//$totalSec = $hours + $minutes + $seconds;
				}
				$totalSec = $hours . ':' . $minutes . ':' . $seconds;
			}

			echo $totalSec;
			return $totalSec;
//           echo $VidDuration;
//           return $VidDuration;
		}

	}


	public function hapus($kodeevent, $id_video)
	{
		$this->M_video->delsafevideo($id_video);
		$link = $this->M_video->getbyCodeEvent($kodeevent)[0]->link_event;
		redirect('/event/spesial/' . $link, '_self');
	}

	public function hapuscal($id_video)
	{
		$this->M_video->delsafevideo($id_video);
		$this->load->model("M_marketing");
		$this->M_marketing->updateCalVerDafUser('video',$this->session->userdata('id_user'));
		redirect('/event/mentor/video', '_self');
	}

	public function daftarkelas()
	{
		$idjenjang = $_GET['idjenjang'];
		$isi = $this->M_video->dafKelas($idjenjang);
		echo json_encode($isi);
	}

	public function daftarmapel()
	{
		$idjenjang = $_GET['idjenjang'];
		$idjurusan = $_GET['idjurusan'];
		$isi = $this->M_video->dafMapel($idjenjang, $idjurusan);
		echo json_encode($isi);
	}

	public function daftartema()
	{
		$idkelas = $_GET['idkelas'];
		$isi = $this->M_video->dafTema($idkelas);
		echo json_encode($isi);
	}

	public function daftarjurusan()
	{
		$idjenjang = $_GET['idjenjang'];
		if ($idjenjang == 5)
			$isi = $this->M_video->dafJurusan();
		echo json_encode($isi);
	}

	public function ambilkd()
	{
		$idkelas = $_GET['idkelas'];
		$idmapel = $_GET['idmapel'];
		$idki = $_GET['idki'];

//		$idkelas = 9;
//		$idmapel = 5;
//		$idki = 3;

		$isi = $this->M_video->dafKD($idkelas, $idmapel, $idki);
		echo json_encode($isi);
	}

	public function ambilmapel()
	{
		$idjenjang = $_GET['idjenjang'];
		if (isset ($_GET['idjurusan'])) {
			$idjurusan = $_GET['idjurusan'];
		}

		$isi = $this->M_video->dafMapel($idjenjang, $idjurusan);
		echo json_encode($isi);
	}

	public function addkd()
	{
		$idkelas = $_POST['idkelas'];
		$idmapel = $_POST['idmapel'];
		$idki = $_POST['idki'];
		$idtema = $_POST['idtema'];
		$idjurusan = $_POST['idjurusan'];
		$kade = $_POST['tekskd'];

		$data['id_kelas'] = $idkelas;
		$data['id_mapel'] = $idmapel;
		$data['id_ki'] = $idki;
		$data['id_tema'] = $idtema;
		$data['id_jurusan'] = $idjurusan;
		$data['nama_kd'] = $kade;

		$this->load->model('M_seting');
		$this->M_seting->addkd($data);

		$this->load->model('M_video');
		$isi = $this->M_video->dafKD($idkelas, $idmapel, $idki);

		echo json_encode($isi);

	}

	public function addmapel()
	{
		$idjenjang = $_POST['idjenjang'];

		if (isset($_POST['idjurusan'])) {
			$idjurusan = $_POST['idjurusan'];
			$data['c3'] = $idjurusan;
		} else {
			alert('JURUSAN BELUM DISET!');
			$idjurusan = 0;
		}

		$mapel = $_POST['teksmapel'];

		$data['id_jenjang'] = $idjenjang;


		$data['nama_mapel'] = $mapel;

		$this->load->model('M_seting');
		$this->M_seting->addmapel($data);

		$this->load->model('M_video');
		$isi = $this->M_video->dafMapel($idjenjang, $idjurusan);

		echo json_encode($isi);

	}

	public function addkat()
	{
		$kate = $_POST['tekskate'];
		$data['nama_kategori'] = $kate;

		$this->load->model('M_seting');
		$this->M_seting->addkate($data);

		$this->load->model('M_video');
		$isi = $this->M_video->getAllKategori();

		echo json_encode($isi);

	}

	public function editkd()
	{
		$idkd = $_POST['idkade'];
		$tekskade = $_POST['tekskade'];
		$idkelas = $_POST['idkelas'];
		$idmapel = $_POST['idmapel'];
		$idki = $_POST['idki'];

		$data['nama_kd'] = $tekskade;

		$this->load->model('M_seting');
		$this->M_seting->editkd($data, $idkd);

		$this->load->model('M_video');
		$isi = $this->M_video->dafKD($idkelas, $idmapel, $idki);

		echo json_encode($isi);

	}

	public function editmapel()
	{
		$idmapel = $_POST['idmapel'];
		$idjenjang = $_POST['idjenjang'];
		$teksmapel = $_POST['teksmapel'];

		$data['nama_mapel'] = $teksmapel;

		$this->load->model('M_seting');
		$this->M_seting->editmapel($data, $idmapel);

		$this->load->model('M_video');
		$isi = $this->M_video->dafMapel($idjenjang);

		echo json_encode($isi);

	}

	public function editkat()
	{
		$idkate = $_POST['idkate'];
		$tekskate = $_POST['tekskate'];


		$data['nama_kategori'] = $tekskate;

		$this->load->model('M_seting');
		$this->M_seting->editkate($data, $idkate);

		$this->load->model('M_video');
		$isi = $this->M_video->getAllKategori();

		echo json_encode($isi);

	}

	public function ambilkategori()
	{
		$this->load->model('M_video');
		$isi = $this->M_video->getAllKategori();
		echo json_encode($isi);
	}

	private function stripHTMLtags($str)
	{
		$t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
		$t = htmlentities($t, ENT_QUOTES, "UTF-8");
		return $t;
	}


	public function addvideo($idvideo=null)
	{

		if ($this->input->post('ijudul') == null) {
			redirect('video');
		}

		$this->load->model("M_video");
		$data['id_jenis'] = $this->input->post('ijenis');
		$data['id_jenjang'] = $this->input->post('ijenjang');
		$data['channeltitle'] = $this->input->post('ichannel');
		$data['channelid'] = $this->input->post('ichannelid');
		$data['id_kelas'] = $this->input->post('ikelas');
		$data['id_mapel'] = $this->input->post('imapel');
		$data['kdnpsn'] = $this->input->post('istandar');
		$data['kdkur'] = $this->input->post('ikurikulum');
		$cekevent = $this->input->post('linkevent');
		$kodeevent = $this->input->post('kodeevent');
		if ($cekevent!="calver")
		{
			$data['id_event'] = $this->M_video->getbyCodeEvent($kodeevent)[0]->id_event;
			$linkevent = $this->M_video->getbyCodeEvent($kodeevent)[0]->link_event;
		}
		else
		{
			$this->load->model("M_marketing");
			$cekrefevent = $this->M_marketing->cekrefevent($kodeevent);
			$data['id_event'] = $cekrefevent->id;
		}

		if ($data['id_jenjang'] == 2)
			$data['id_tematik'] = $this->input->post('itema');
		else
			$data['id_tematik'] = 0;
		if ($data['id_jenjang'] == 5)
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
			$data['id_user'] = $this->session->userdata('id_user');
			$data['npsn_user'] = $this->session->userdata('npsn');
			if ($data['link_video'] != "") {
				$data['durasi'] = $data['durasi'];
				$data['thumbnail'] = $this->input->post('ytube_thumbnail');
				$data['id_youtube'] = $this->input->post('idyoutube');
			}
			$mikro = str_replace(".", "", microtime(false));
			$mikro = str_replace(" ", "", $mikro);
			$mikro = base_convert($mikro, 10, 36);
			$data['kode_video'] = $mikro;
		} else {
			//$data['kode_video'] = base_convert($this->input->post('created'),10,16);
		}

		if ($cekevent=="calver")
			$data['tipe_video'] = 3;
		else
			$data['tipe_video'] = 1;
		$data['status_verifikasi'] = 0;

		if ($this->input->post('filevideo') != "" || $this->session->userdata('tukang_kontribusi') == 2) {
			$data['status_verifikasi'] = 4;
		} else if ($statusverifikasi == 1) {
			$data['status_verifikasi'] = 0;
		} else if ($statusverifikasi == 3) {
			$data['status_verifikasi'] = 2;
		}

		if ($this->session->userdata('sebagai') == 4 || $this->session->userdata('a01')) {
			if ($this->input->post('ijenis') == 1)
				$data['status_verifikasi'] = 4;
			else
				$data['status_verifikasi'] = 2;
		}

		if ($this->session->userdata('verifikator') == 3)
			$data['status_verifikasi'] = 2;

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
			$idbaru = $this->M_video->addVideo($data);
			if ($cekevent!="calver")
			{
				$this->M_video->updatejmlvidsekolah($this->session->userdata('npsn'));
				redirect('event/spesial/' . $linkevent);
			}
			else
			{
				$this->M_marketing->updateCalVerDafUser('video',$this->session->userdata('id_user'));
				redirect('event/mentor/video');
			}
			//redirect('video/edit/'.$idbaru);
		} else {
			$this->M_video->editVideo($data, $this->input->post('id_video'));
			if ($cekevent!="calver")
			{
				$this->M_video->updatejmlvidsekolah($this->session->userdata('npsn'));
				redirect('event/spesial/' . $linkevent);
			}
			else
			{
				$this->M_marketing->updateCalVerDafUser('video',$this->session->userdata('id_user'));
				if ($idvideo!=null)
					redirect('event/mentor/video/'.$idvideo);
				else
					redirect('event/mentor/video');
			}
		}

	}

	public function addvideomp4()
	{
		if ($this->input->post('ijudul') == null) {
			redirect('video');
		}

		$data['id_jenis'] = $this->input->post('ijenis');
		$data['id_jenjang'] = $this->input->post('ijenjang');
		$data['id_kelas'] = $this->input->post('ikelas');
		$data['id_mapel'] = $this->input->post('imapel');
		$data['id_ki1'] = $this->input->post('iki1');
		$data['id_ki2'] = $this->input->post('iki2');
		$data['id_kd1_1'] = $this->input->post('ikd1_1');
		$data['id_kd1_2'] = $this->input->post('ikd1_2');
		$data['id_kd1_3'] = $this->input->post('ikd1_3');
		$data['id_kd2_1'] = $this->input->post('ikd2_1');
		$data['id_kd2_2'] = $this->input->post('ikd2_2');
		$data['id_kd2_3'] = $this->input->post('ikd2_3');
		$data['id_kategori'] = $this->input->post('ikategori');
		$data['topik'] = $this->input->post('itopik');
		$data['judul'] = $this->input->post('ijudul');
		$data['deskripsi'] = $this->input->post('ideskripsi');
		$data['keyword'] = $this->input->post('ikeyword');

		$data['id_user'] = $this->session->userdata('id_user');
		$data['npsn_user'] = $this->session->userdata('npsn');
		$data['kode_video'] = base_convert(microtime(false), 10, 36);

//        if ($this->session->userdata('sebagai') == 4)
//        {
//            if ($this->input->post('ijenis')==1)
//                $data['status_verifikasi'] = 4;
//            else
//                $data['status_verifikasi'] = 2;
//        }

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
			$idbaru = $this->M_video->addVideo($data);
			$this->upload_mp4_intern($idbaru);
			//redirect('video/edit/'.$idbaru);
		} else {
			$this->M_video->editVideo($data, $this->input->post('id_video'));
			redirect('video');
		}
	}

//    public function tesprivat()
//    {
//        $this->upload_mp4_intern(5);
//    }

	public function verifikasi($id_video)
	{
		$data = array('title' => 'Verifikasi Video', 'menuaktif' => '3',
			'isi' => 'v_video_verifikasi');

		$datav['id_video'] = $id_video;
		$datav['id_verifikator'] = $this->session->userdata('id_user');
		$datav['no_verifikator'] = $this->session->userdata('tukang_verifikasi');

		$data['datavideo'] = $this->M_video->getVideoKomplit($id_video);

		if ($datav['no_verifikator'] == 0)
			redirect('video');
		if ($datav['no_verifikator'] == 1) {
			if ($this->session->userdata('npsn') != $data['datavideo']['npsn'])
				redirect('video');
		}

		$data['dafpernyataan'] = $this->M_video->getAllPernyataan($datav['no_verifikator']);
		$data['dafpenilaian'] = $this->M_video->getPenilaian($id_video, $datav);

		$this->load->view('layout/wrapper', $data);

	}

	public function simpanverifikasi()
	{
		//echo $this->session->userdata('tukang_verifikasi');
		$verifikator = $this->session->userdata('tukang_verifikasi');
		$id_video = $this->input->post('id_video');
		$total_isian = $this->input->post('total_isian');
		$jml_diisi = $this->input->post('jml_diisi');
		$lulusgak = $this->input->post('lulusgak');
		// echo 'Total:'.$total_isian;
		// echo '<br>Diisi:'.$jml_diisi;
		//echo $lulusgak
		//die();
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
			$data1['status_verifikasi'] = $status_verifikasi;

			$data2['id_video'] = $id_video;
			$data2['totalnilai'] = $this->input->post('totalnilai');
			$data2['no_verifikator'] = $verifikator;
			$data2['id_verifikator'] = $this->session->userdata('id_user');
			$data2['status_verifikasi'] = $status_verifikasi;

			////////// MENUNGGU SYARAT STATUS VERIFIKASI YG BENAR

			if ($id_video == null) {
				//echo "cek_3";	die();
				redirect('video/');
			} else {
				//echo "cek_4";	die();
				$data3['id_video'] = $id_video;
				$data3['id_verifikator'] = $this->session->userdata('id_user');
				$data3['no_verifikator'] = $verifikator;

				for ($c = 1; $c <= $total_isian; $c++) {
					$data3['penilaian' . $c] = $this->input->post('inilai' . $c);
					//echo $data3['penilaian'.$c];
				}

				$this->M_video->updatenilai($data1, $id_video);
				$this->M_video->addlogvideo($data2);
				$this->M_video->simpanverifikasi($data3, $id_video);
				redirect('video/');
			}
		} else {
//			echo "cek5";
//			die();
			redirect('video');
		}
	}

	public function file_view($idx = null)
	{
//    	echo "VER".$this->session->userdata('tukang_verifikasi');
//		echo "KON".$this->session->userdata('tukang_kontribusi');
//		die();

		if ($this->session->userdata('tukang_verifikasi') == 2 || $this->session->userdata('tukang_kontribusi') == 1 ||
			$this->session->userdata('tukang_kontribusi') == 2) {

			$data = array('title' => 'Upload Video', 'menuaktif' => '3',
				'isi' => 'v_video_upload');
			$data ['error'] = ' ';
			$data ['thumbs'] = false;
			$data ['idx'] = 0;
			if ($idx != null) {
				$data ['thumbs'] = true;
				$data ['idx'] = $idx;
			}

			$this->load->view('layout/wrapper', $data);
		} else {
			redirect('video');
		}

	}

	public function upload_mp4($idx = null)
	{
//    	echo "VER".$this->session->userdata('tukang_verifikasi');
//		echo "KON".$this->session->userdata('tukang_kontribusi');
//		die();

		if ($this->session->userdata('tukang_verifikasi') == 2 || $this->session->userdata('tukang_kontribusi') == 1 ||
			$this->session->userdata('tukang_kontribusi') == 2) {

			$data = array('title' => 'Upload Video', 'menuaktif' => '3',
				'isi' => 'v_video_upload');
			$data ['error'] = ' ';
			$data ['thumbs'] = false;
			$data ['idx'] = 0;
			if ($idx != null) {
				//$data ['thumbs'] = true;
				$data ['id_vid_baru'] = $idx;
			}

			$this->load->view('layout/wrapper', $data);
		} else {
			redirect('video');
		}
	}

	private function upload_mp4_intern($idbaru)
	{
//    	echo "VER".$this->session->userdata('tukang_verifikasi');
//		echo "KON".$this->session->userdata('tukang_kontribusi');
//		die();

		if ($this->session->userdata('tukang_verifikasi') == 2 || $this->session->userdata('tukang_kontribusi') == 1 ||
			$this->session->userdata('tukang_kontribusi') == 2) {

			$data = array('title' => 'Upload Video', 'menuaktif' => '3',
				'isi' => 'v_video_upload');
			$data['id_vid_baru'] = $idbaru;

			$this->load->view('layout/wrapper', $data);
		} else {
			redirect('video');
		}
	}

	public function do_upload()
	{
		$path1 = "vod/";
		$allow = "mp4";

		$config = array(
			'upload_path' => "uploads/" . $path1,
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "204800000"
			//'max_height' => "768",
			//'max_width' => "1024"
		);

		$this->load->library('upload', $config);
		if ($this->upload->do_upload()) {

			$dataupload = array('upload_data' => $this->upload->data());

			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			{

				$id_video = $this->input->post('id_vid_baru');

				date_default_timezone_set('Asia/Jakarta');
				$now = new DateTime();
				$date = $now->format('Y-m-d_H-i');
				$namafilebaru = $ext['filename'] . $date . '.' . $ext['extension'];

				rename($alamat . $namafile1, $alamat . $namafilebaru);

				//$data['id_user'] = $this->session->userdata('id_user');
				$data['file_video'] = $namafilebaru;
				$data['status_verifikasi'] = 0;
				$data['kode_video'] = base_convert(microtime(false), 10, 36);
				$this->M_video->editVideo($data, $id_video);
			}
			redirect('video/edit/' . $id_video);

			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			$error = array('error' => $this->upload->display_errors(), 'thumbs' => true, null);
			$this->load->view('v_video_upload', $error);
		}
	}

	public function do_uploadcanvas()
	{
		$namafile = $this->input->post('filevideo');
		$idvideo = $this->input->post('idvideo');

		file_put_contents('uploads/thumbs/' . $namafile, base64_decode(str_replace('data:image/png;base64,', '', $this->input->post('canvasimage'))));

		//$data = array('thumbnail' => $namafile);

		$this->M_video->updateThumbs($idvideo, $namafile);

		//echo "OK";

		//echo str_replace('data:image/octet-stream;base64,','',$this->input->post('canvasimage'));
	}

	public function updatesertifikat()
	{
		$namaser = $this->input->post('namane');
		$emailser = $this->input->post('emaile');
		$viaverifikator = $this->input->post('viaverifikator');
		$codene = $this->input->post('codene');
		//$userdata = $this->M_video->getUserbyId($this->session->userdata('id_user'));
		$iduser = $this->session->userdata('id_user');
		//$namasekolah=$userdata[0]->nama_sekolah;

		//if ($viaverifikator==0)
		$this->load->Model('M_video');
		$this->M_video->updatesertifikat($namaser, $emailser, $codene, $iduser);
		//echo ("Sekolah:".$namasekolah);
	}

	public function updatesertifikatcalver()
	{
		$namaser = $this->input->post('namane');
		$emailser = $this->input->post('emaile');
		$codene = $this->input->post('codene');
		//$userdata = $this->M_video->getUserbyId($this->session->userdata('id_user'));
		$iduser = $this->session->userdata('id_user');
		//$namasekolah=$userdata[0]->nama_sekolah;

		$this->load->Model('M_event');
		$this->M_event->updatesertifikatcalver($namaser, $emailser, $codene, $iduser);
	}

	public function updatesertifikatmentor($opsi)
	{
		$namaser = $this->input->post('namane');
		$emailser = $this->input->post('emaile');
		$codene = $this->input->post('codene');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		$iduser = $this->session->userdata('id_user');
		$this->load->Model('M_vksekolah');
		$this->M_vksekolah->updatesertifikatmentor($namaser, $emailser, $codene, 
		$iduser, $bulan, $tahun);
		// echo ("1".$namaser.","."2".$emailser.","."3".$codene.","."4".$bulan.","."5".$tahun);
	}

	public function createsertifikatevent($kodeevent, $narsum = null, $lihat = null, $pnama = null, $pqr = null)
	{
		$idpeserta = $this->session->userdata('id_user');

		$this->load->model('M_video');
		$opsi = null;
		if ($narsum != null) {
			if ($this->session->userdata('a01') || ($this->session->userdata('sebagai') == "4" &&
					$this->session->userdata('verifikator') == "3")) {

			} else {
				redirect("/");
			}
			//$opsi = 3;
//			$eventsekarang = $this->M_video->getEventbyCode($kodeevent);
//			if ($narsum==1)
//				$idpeserta = $eventsekarang[0]->idnarsum1;
//			else if ($narsum==2)
//				$idpeserta = $eventsekarang[0]->idnarsum2;
//			else if ($narsum==3)
//				$idpeserta = $eventsekarang[0]->idnarsum3;
//			else
			$idpeserta = $narsum;
		}

		echo "EMAIL:" . $this->session->userdata('email') . "<br>";

		echo "Nar:" . $narsum . "<br>";
		echo "IDPeserta:" . $idpeserta . "<br>";

		if ($lihat != "tessertifikat") {
			$cekudahsertifikat = $this->M_video->cekUserEvent($kodeevent, $idpeserta, $opsi);

//		echo "<pre>";
//		echo var_dump($cekudahsertifikat);
//		echo "</pre>";

			$sudahdownload = $cekudahsertifikat[0]->download_sertifikat;
			$tanggalser = $cekudahsertifikat[0]->tgl_mulai_sertifikat;

			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang = $now->format('Y-m-d H:i:s');

			$tgser = new DateTime($tanggalser);
			$tglsertifikat = $tgser->format('Y-m-d H:i:s');

			$dif = date_diff(date_create($tglsertifikat), date_create($tglsekarang));
			$hasildif = $dif->format("%R");

			$tanggaloke = true;
			if ($hasildif == "-") {
				$tanggaloke = false;
			}

			if ($this->session->userdata('a01') || ($this->session->userdata('sebagai') == 4 && $this->session->userdata('verifikator') == 3)) {
				$sudahdownload = 0;
				$tanggaloke = true;
			}
		}

		if ($lihat == "tessertifikat") {
			$p_nama = explode("_", $pnama);
			$pos_nama = $p_nama[0] . "," . $p_nama[1] . "," . $p_nama[2] . "," . $p_nama[3] . "," . $p_nama[4] . "," . $p_nama[5];
			$p_qr = explode("_", $pqr);
			$posqr1 = $p_qr[0] . "," . $p_qr[1] . "," . $p_qr[2];
			$posqr2 = strval(297 - intval($p_qr[2]) - intval($p_qr[0])) . "," . $p_qr[1] . "," . $p_qr[2];
			$font_name = "eczar";
			$file_sertifikat = $this->M_video->getEventbyCode($kodeevent);
			$file_sertifikat = $file_sertifikat[0]->file_sertifikat;
			$file_sertifikat_hal2 = $this->M_video->getEventbyCode($kodeevent);
			$file_sertifikat_hal2 = $file_sertifikat_hal2[0]->file_sertifikat_hal2;

			$this->buildsertifikat("Tes Event TV SEKOLAH", "Nama Lengkap Peserta Event, M.Gelar",
				"A00001", 1, $file_sertifikat, $file_sertifikat_hal2, $pos_nama, $posqr1, $posqr2, $font_name, $lihat);
		} else {
			if ($sudahdownload == 0 && $tanggaloke) {
				$daftarpeserta = $this->M_video->daftarpesertaeventtunggal($kodeevent, $idpeserta, $narsum);

				echo $kodeevent . "<br>";
				echo $idpeserta . "<br>";
				echo $narsum . "<br>";


				if (!$daftarpeserta)
					echo "Belum menuliskan Nama Lengkap atau Email";
				else
					echo "SERTIFIKAT:<br>";

//					echo "<pre>";
//					echo var_dump($daftarpeserta);
//					echo "</pre>";

				foreach ($daftarpeserta as $datapeserta) {
					$nama_event = $datapeserta->nama_event;
					$nama_peserta = ($datapeserta->nama_sertifikat);//strtoupper
					$email_peserta = $datapeserta->email_sertifikat;
					$code_event = $datapeserta->code_event;
					$id_peserta = $datapeserta->id_user;
					$aktifsebagai = $datapeserta->aktifsebagai;
					$file_sertifikat = $datapeserta->file_sertifikat;
					if ($aktifsebagai == "Keynote Speaker") {
						$file_sertifikat = $datapeserta->file_sertifikat_n1;
						$email_peserta = "sriwatini137@gmail.com";
					} else if ($aktifsebagai == "Narasumber 2") {
						$file_sertifikat = $datapeserta->file_sertifikat_n2;
					} else if ($aktifsebagai == "Ketua Panitia") {
						$file_sertifikat = $datapeserta->file_sertifikat_n3;
						$email_peserta = "sriwatini137@gmail.com";
					} else if ($aktifsebagai == "Narasumber") {
						$file_sertifikat = $datapeserta->file_sertifikat_narsum;
						$email_peserta = "sriwatini137@gmail.com";
					} else if ($aktifsebagai == "Sponsorship") {
						$file_sertifikat = $datapeserta->file_sertifikat_sponsor;
						$email_peserta = "sriwatini137@gmail.com";
					} else if ($aktifsebagai == "Moderator")
						$file_sertifikat = $datapeserta->file_sertifikat_moderator;
					else if ($aktifsebagai == "Host")
						$file_sertifikat = $datapeserta->file_sertifikat_host;

					$file_sertifikat_hal2 = $datapeserta->file_sertifikat_hal2;
					// echo "ID:" . $idpeserta . "<br>";
					// echo $file_sertifikat . "<br>";

//				$nomor_sertifikat = $datapeserta->nomor_sertifikat;
//				$pos_nomor = $datapeserta->pos_nomor;
					$pos_nama = $datapeserta->pos_nama;
//				$pos_sebagai = $datapeserta->pos_sebagai;
					$posqr1 = $datapeserta->posqr1;
					$posqr2 = $datapeserta->posqr2;
					$font_name = $datapeserta->font_name;
//				$font_other = $datapeserta->font_other;
//				$sebagai_peserta = "";//$datapeserta->aktifsebagai;
					// echo "------------------------------------------<br>";
					// echo "Event:" . $nama_event . "<br>" . "Nama:" . $nama_peserta . "<br>" . "Email:" . $email_peserta . "<br>";
					$this->buildsertifikat($nama_event, $nama_peserta, $code_event, $id_peserta,
						$file_sertifikat, $file_sertifikat_hal2, $pos_nama, $posqr1, $posqr2, $font_name, $lihat);
					if (base_url() != "http://localhost/fordorum/") {
						if ($lihat) {

						} else {
							$this->send_emails($email_peserta, $nama_event, $code_event, $id_peserta);
						}
					}


				}

				if ($this->session->userdata('a01') && $narsum == null) {

				} else {
					if ($this->session->userdata('a01') && $lihat != "view") {
						$this->M_video->updatesudahsertifikat($kodeevent, $idpeserta);
						redirect("/event/aktivasi_event/" . $kodeevent);
					} else
						if ($lihat != "view")
							$this->M_video->updatesudahsertifikat($kodeevent, $idpeserta);
				}

				//echo "berhasil";
			} else {
				//echo "gagal";
			}
		}
	}

	public function createsertifikateventmentor($opsi, $lihat = null)
	{

		$kodeevent = $this->input->post('codene');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$idguru = $this->session->userdata('id_user');
		
		$lihat = false;
		
		if ($opsi=="guru")
			$opsi = 2;

		$this->load->model('M_vksekolah');
		$cekudahsertifikat = $this->M_vksekolah->cekUserMentorEvent($kodeevent, $idguru, $bulan, $tahun);
		if (!$cekudahsertifikat)
			redirect ("/");
		
		$sudahdownload = $cekudahsertifikat->download_sertifikat;
		$nomorurutan = $cekudahsertifikat->urutan_nomor;
		if ($nomorurutan == 0)
			{
				$ceknomor = $this->M_vksekolah->ceknomorsertifikatakhir($kodeevent, $idguru, $bulan, $tahun);
				$nomorterakhir = $ceknomor->urutan_nomor;
				$nomorurutan = $nomorterakhir + 1;
			}

		$komplit = false;
		if ($cekudahsertifikat->nama_sertifikat != "" && $cekudahsertifikat->email_sertifikat != "")
			$komplit = true;

		if ($komplit) {			
				
				$namaguru = $cekudahsertifikat->nama_sertifikat;
				$email_peserta = $cekudahsertifikat->email_sertifikat;

				echo "Nama:" . $namaguru . "<br>";
				echo "Email:" .$email_peserta . "<br>";

				$tnomorurutan = str_pad($nomorurutan, 4, '0', STR_PAD_LEFT);

				$this->buildsertifikatmentor($namaguru, $kodeevent, $idguru, $bulan, $tahun, $tnomorurutan, $lihat);
				if (base_url() != "http://localhost/tvsekolah2/") {
					if ($lihat) {

					} else {
						//$this->send_emails($email_peserta, $nama_event, $kodeevent, $idguru);
					}
				}

			
				$sudahdownload++;
				$this->M_vksekolah->updatesertifikatmentor(null, null, $kodeevent, $idguru, $bulan, $tahun, $nomorurutan, $sudahdownload);
			
				
		} else {
			//echo "gagal";
		}


	}

	public function createsertifikateventcalver($opsi, $lihat = null)
	{

		$kodeevent = $this->input->post('codene');
		$idguru = $this->session->userdata('id_user');

		// echo "KODEEVENT:".$kodeevent;
		// echo "<br>IDGURU:".$idguru;

		$lihat = false;
		
		if ($opsi=="guru")
			$opsi = 2;

		$this->load->model('M_event');
		$cekudahsertifikat = $this->M_event->cekUserCalverEvent($kodeevent, $idguru);
		if (!$cekudahsertifikat)
			redirect ("/");

		$tanggalevent = $this->M_event->gettanggalevent($kodeevent);
		$bulan = intval(substr($tanggalevent->tgl_jalan,5,2));
		$tahun = intval(substr($tanggalevent->tgl_jalan,0,4));				
		
		$sudahdownload = $cekudahsertifikat->download_sertifikat;
		$nomorurutan = $cekudahsertifikat->urutan_nomor;
		if ($nomorurutan == 0)
			{
				$ceknomor = $this->M_event->ceknomorsertifikatakhir($kodeevent);
				if ($ceknomor)
				{
					$nomorterakhir = $ceknomor->urutan_nomor;
					$nomorurutan = $nomorterakhir + 1;
				}
				else
				{
					$nomorurutan = 1;
				}
				
			}

		$komplit = false;
		if ($cekudahsertifikat->nama_sertifikat != "" && $cekudahsertifikat->email_sertifikat != "")
			$komplit = true;

		if ($komplit) {			
				
				$namaguru = $cekudahsertifikat->nama_sertifikat;
				$email_peserta = $cekudahsertifikat->email_sertifikat;

				echo "Nama:" . $namaguru . "<br>";
				echo "Email:" .$email_peserta . "<br>";

				$tnomorurutan = str_pad($nomorurutan, 4, '0', STR_PAD_LEFT);

				$this->buildsertifikatcalver($namaguru, $kodeevent, $idguru, $tnomorurutan, $lihat, $bulan, $tahun);
				if (base_url() != "http://localhost/tvsekolah2/") {
					if ($lihat) {

					} else {
						//$this->send_emails($email_peserta, $nama_event, $kodeevent, $idguru);
					}
				}

			
				$sudahdownload++;
				// echo "KODE:".$kodeevent;
				// echo "<br>IDGURU:".$idguru;
				// echo "<br>URUTAN:".$nomorurutan;
				// echo "<br>SUDAHDOWNLOAD:".$sudahdownload;
				// die();

				$this->M_event->updatesertifikatcalver(null, null, $kodeevent, $idguru, $nomorurutan, $sudahdownload);
			
				
		} else {
			//echo "gagal";
		}


	}

	private function buatqrcode($indeks, $kode = null)
	{
		$imgname = "qr.png";
		$logo[2] = "logof.png";
		$logo[1] = "logotv.png";
		$data[2] = isset($_GET['data']) ? $_GET['data'] : "https://tvsekolah.id/event/ceksertifikat/" . $kode;
		$data[1] = isset($_GET['data']) ? $_GET['data'] : "https://tvsekolah.id";
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

	private function buatqrcodementor($indeks, $kode=null, $bulan=null, $tahun=null)
	{
		$iduser = $this->session->userdata('id_user');
		$imgname = "qr.png";
		$logo[2] = "logof.png";
		$logo[1] = "logotv.png";
		$data[2] = isset($_GET['data']) ? $_GET['data'] : "https://tvsekolah.id/event/ceksertifikatmentor/" . $kode."_".$iduser."/".$bulan."/".$tahun;
		$data[1] = isset($_GET['data']) ? $_GET['data'] : "https://tvsekolah.id";
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

	private function buatqrcodecalver($indeks, $kode=null)
	{
		$iduser = $this->session->userdata('id_user');
		$imgname = "qr.png";
		$logo[2] = "logof.png";
		$logo[1] = "logotv.png";
		$data[2] = isset($_GET['data']) ? $_GET['data'] : "https://tvsekolah.id/event/ceksertifikatcalver/" . $kode."_".$iduser;
		$data[1] = isset($_GET['data']) ? $_GET['data'] : "https://tvsekolah.id";
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

	public function buildsertifikat($nama_event, $nama_peserta, $code_event, $id_peserta, $file_sertifikat,
									$file_sertifikat_hal2, $pos_nama, $posqr1, $posqr2, $font_name, $lihat = null)
	{
		$posqr1 = explode(",", $posqr1);
		$posqr1_x = $posqr1[0];
		$posqr1_y = $posqr1[1];
		$posqr1_s = $posqr1[2];

		$posqr2 = explode(",", $posqr2);
		$posqr2_x = $posqr2[0];
		$posqr2_y = $posqr2[1];
		$posqr2_s = $posqr2[2];

//		$pos_nomor = explode(",",$pos_nomor);
//		$pos_nomor_y = $pos_nomor[0];
//		$pos_nomor_l = $pos_nomor[1];
//		$pos_nomor_t = $pos_nomor[2];
//		$pos_nomor_r = $pos_nomor[3];
//		$pos_nomor_alg = $pos_nomor[4];
//		$pos_nomor_sz = $pos_nomor[5];

		$pos_nama = explode(",", $pos_nama);
		$pos_nama_y = $pos_nama[0];
		$pos_nama_l = $pos_nama[1];
		$pos_nama_t = 0;
		$pos_nama_r = $pos_nama[2];
		$pos_nama_alg = $pos_nama[3];
		$pos_nama_sz = $pos_nama[4];
		$pos_nama_clr = $pos_nama[5];

//		$pos_sebagai = explode(",",$pos_sebagai);
//		$pos_sebagai_y = $pos_sebagai[0];
//		$pos_sebagai_l = $pos_sebagai[1];
//		$pos_sebagai_t = $pos_sebagai[2];
//		$pos_sebagai_r = $pos_sebagai[3];
//		$pos_sebagai_alg = $pos_sebagai[4];
//		$pos_sebagai_sz = $pos_sebagai[5];
//		$pos_sebagai_clr = $pos_sebagai[6];

		$qrcode1 = $this->buatqrcode(1);
		$qrcode2 = $this->buatqrcode(2, $code_event . $id_peserta);
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('Sertifikat ' . $nama_event);
		$pdf->SetTopMargin(20);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(false);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->AddPage('L', 'A4');
		$img_file = base_url() . "uploads/temp_sertifikat/" . $file_sertifikat;
		$pdf->Image($img_file, 0, 0, 297, 210, '', '', '', false, 150, '', false, false, 0);
		$pdf->Image($qrcode1, $posqr1_x, $posqr1_y, $posqr1_s, $posqr1_s, '', '', '', false, 150, '', false, false, 0);
		$pdf->Image($qrcode2, $posqr2_x, $posqr2_y, $posqr2_s, $posqr2_s, '', '', '', false, 150, '', false, false, 0);
		$pdf->AddFont($font_name);
//$pdf->SetFont($fontname, '', 20, '', '');
// pakai alamat ini untuk tambah font TTF, lalu masukkan ke folder tcpdf/fonts
// https://www.xml-convert.com/en/convert-tff-font-to-afm-pfa-fpdf-tcpdf
//		$pdf->SetXY(0, $pos_nomor_y);
//		$html = '<span style="font-family:'.$font_other.';font-weight:bold;font-size: '.$pos_nomor_sz.'px;color:#373635;">&nbsp;' . $nomor_sertifikat . '&nbsp;</span>';
//		$pdf->SetMargins($pos_nomor_l, $pos_nomor_t, $pos_nomor_r, true);
//		$pdf->writeHTML($html, true, 0, true, true, $pos_nomor_alg);

		$pdf->SetXY($pos_nama_l, $pos_nama_y);
		$html = '<span style="font-family:' . $font_name . ';font-weight:bold;font-size: ' . $pos_nama_sz . 'px;color:#' . $pos_nama_clr . ';">&nbsp;' . $nama_peserta . '&nbsp;</span>';
		$pdf->SetMargins($pos_nama_l, $pos_nama_t, $pos_nama_r, true);
		$pdf->writeHTML($html, true, 0, true, true, $pos_nama_alg);

//		$pdf->SetXY($pos_sebagai_l, $pos_sebagai_y);
//		$html = '<span style="font-family:'.$font_other.';font-weight:bold;font-size: '.$pos_sebagai_sz.'px;color:#'.$pos_sebagai_clr.';">&nbsp;' . $sebagai_peserta . '&nbsp;</span>';
//		$pdf->SetMargins($pos_sebagai_l, $pos_sebagai_t, $pos_sebagai_r, true);
//		$pdf->writeHTML($html, true, 0, true, true, $pos_sebagai_alg);

		if ($file_sertifikat_hal2 != "") {
			$pdf->AddPage('L', 'A4');
			$img_file = base_url() . "uploads/temp_sertifikat/" . $file_sertifikat_hal2;
			$pdf->Image($img_file, 0, 0, 297, 210, '', '', '', false, 150, '', false, false, 0);
		}

		if ($lihat) {
			ob_end_clean();
			$pdf->Output('sert_event.pdf', "I");
		} else {
			if (base_url() == "http://localhost/fordorum/") {
				$pdf->Output(FCPATH . 'uploads\sertifikat\sert_evt_' . $code_event . $id_peserta . '.pdf', 'F');
			} else {
				$pdf->Output(FCPATH . 'uploads/sertifikat/sert_evt_' . $code_event . $id_peserta . '.pdf', 'F');
			}
		}
	
	}

	public function buildsertifikatmentor($nama_peserta, $code_event, $id_peserta, $bulan, $tahun, $nomorurutan, $lihat)
	{
		$font_name = "norwester";
		$font_name2 = "eczar";
		$bulane = str_pad($bulan, 2, '0', STR_PAD_LEFT);
		$nomornya = $nomorurutan."/".$code_event."/M-LCMS/FDGM/".$bulane."/".$tahun;
		$qrcode1 = $this->buatqrcodementor(1);
		$qrcode2 = $this->buatqrcodementor(2, $code_event, $bulan, $tahun);
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('Sertifikat Modul Sekolah');
		$pdf->SetTopMargin(20);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(false);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->AddPage('L', 'A4');
		$img_file = base_url() . "uploads/temp_sertifikat/SertifikatModulGuru.jpeg";
		$pdf->Image($img_file, 0, 0, 297, 210, '', '', '', false, 150, '', false, false, 0);
		$pdf->Image($qrcode1, 12, 180, 20, 20, '', '', '', false, 150, '', false, false, 0);
		$pdf->Image($qrcode2, 266, 180, 20, 20, '', '', '', false, 150, '', false, false, 0);
		$pdf->AddFont($font_name);
//$pdf->SetFont($fontname, '', 20, '', '');
// pakai alamat ini untuk tambah font TTF, lalu masukkan ke folder tcpdf/fonts
// https://www.xml-convert.com/en/convert-tff-font-to-afm-pfa-fpdf-tcpdf
//		$pdf->SetXY(0, $pos_nomor_y);
//		$html = '<span style="font-family:'.$font_other.';font-weight:bold;font-size: '.$pos_nomor_sz.'px;color:#373635;">&nbsp;' . $nomor_sertifikat . '&nbsp;</span>';
//		$pdf->SetMargins($pos_nomor_l, $pos_nomor_t, $pos_nomor_r, true);
//		$pdf->writeHTML($html, true, 0, true, true, $pos_nomor_alg);

		$pdf->SetXY(0, 82);
		$html = '<span style="font-family:' . $font_name . ';font-weight:bold;font-size: 35px;color:#black;">&nbsp;' . $nama_peserta . '&nbsp;</span>';
		$pdf->SetMargins(0, 0, 0, true);
		$pdf->writeHTML($html, true, 0, true, true, 'C');

		$pdf->SetXY(0,65);
		$html = '<span style="font-family:'.$font_name.';font-weight:bold;font-size: 18px;color:#black;">&nbsp;' . $nomornya . '&nbsp;</span>';
		$pdf->SetMargins(0, 0, 0, true);
		$pdf->writeHTML($html, true, 0, true, true, 'C');

		$pdf->SetXY(0, 118);
		$html = '<span style="font-family: Verdana; font-weight:bold; font-size: 22px;color:#black;">&nbsp;' . nmbulan_panjang($bulan) . ' ' . $tahun . '&nbsp;</span>';
		$pdf->SetMargins(0, 0, 0, true);
		$pdf->writeHTML($html, true, 0, true, true, 'C');

		$pdf->SetXY(163, 135);
		$html = '<span style="font-family: Verdana; font-weight:normal; font-size: 18px;color:#black;">&nbsp;' . date('d'). ' '.nmbulan_panjang(date('n')) . ' ' . date('Y') . '&nbsp;</span>';
		$pdf->SetMargins(0, 0, 0, true);
		$pdf->writeHTML($html, true, 0, true, true, 'L');

		$pdf->AddPage('L', 'A4');
		$img_file = base_url() . "uploads/temp_sertifikat/SertifikatModulGuru2.jpeg";
		$pdf->Image($img_file, 0, 0, 297, 210, '', '', '', false, 150, '', false, false, 0);

		if ($lihat) {
			ob_end_clean();
			$pdf->Output('sert_m_guru.pdf', "I");
		} else {
			if (base_url() == "http://localhost/tvsekolah2/") {
				$pdf->Output(FCPATH . 'uploads\sertifikat\sert_m_guru' . $code_event . $id_peserta . '.pdf', 'F');
			} else {
				$pdf->Output(FCPATH . 'uploads/sertifikat/sert_m_guru' . $code_event . $id_peserta . '.pdf', 'F');
			}
		}

	}

	public function buildsertifikatcalver($nama_peserta, $code_event, $id_peserta,$nomorurutan, $lihat, $bulan, $tahun)
	{
		$font_name = "norwester";
		$font_name2 = "eczar";
		$nomornya = $nomorurutan."/".$code_event."/E-CLVS/FDGM";
		$qrcode1 = $this->buatqrcodecalver(1);
		$qrcode2 = $this->buatqrcodecalver(2, $code_event);
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('Sertifikat Calon Verifikator');
		$pdf->SetTopMargin(20);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(false);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->AddPage('L', 'A4');
		$img_file = base_url() . "uploads/temp_sertifikat/SertifikatCalver.jpeg";
		$pdf->Image($img_file, 0, 0, 297, 210, '', '', '', false, 150, '', false, false, 0);
		$pdf->Image($qrcode1, 12, 180, 20, 20, '', '', '', false, 150, '', false, false, 0);
		$pdf->Image($qrcode2, 266, 180, 20, 20, '', '', '', false, 150, '', false, false, 0);
		$pdf->AddFont($font_name);
//$pdf->SetFont($fontname, '', 20, '', '');
// pakai alamat ini untuk tambah font TTF, lalu masukkan ke folder tcpdf/fonts
// https://www.xml-convert.com/en/convert-tff-font-to-afm-pfa-fpdf-tcpdf
//		$pdf->SetXY(0, $pos_nomor_y);
//		$html = '<span style="font-family:'.$font_other.';font-weight:bold;font-size: '.$pos_nomor_sz.'px;color:#373635;">&nbsp;' . $nomor_sertifikat . '&nbsp;</span>';
//		$pdf->SetMargins($pos_nomor_l, $pos_nomor_t, $pos_nomor_r, true);
//		$pdf->writeHTML($html, true, 0, true, true, $pos_nomor_alg);

		$pdf->SetXY(0, 82);
		$html = '<span style="font-family:' . $font_name . ';font-weight:bold;font-size: 35px;color:#black;">&nbsp;' . $nama_peserta . '&nbsp;</span>';
		$pdf->SetMargins(0, 0, 0, true);
		$pdf->writeHTML($html, true, 0, true, true, 'C');

		$pdf->SetXY(0,65);
		$html = '<span style="font-family:'.$font_name.';font-weight:bold;font-size: 18px;color:#black;">&nbsp;' . $nomornya . '&nbsp;</span>';
		$pdf->SetMargins(0, 0, 0, true);
		$pdf->writeHTML($html, true, 0, true, true, 'C');

		$pdf->SetXY(0, 118);
		$html = '<span style="font-family: Verdana; font-weight:bold; font-size: 22px;color:#black;">&nbsp;' . nmbulan_panjang($bulan) . ' ' . $tahun . '&nbsp;</span>';
		$pdf->SetMargins(0, 0, 0, true);
		$pdf->writeHTML($html, true, 0, true, true, 'C');

		$pdf->SetXY(163, 135);
		$html = '<span style="font-family: Verdana; font-weight:normal; font-size: 18px;color:#black;">&nbsp;' . date('d'). ' '.nmbulan_panjang(date('n')) . ' ' . date('Y') . '&nbsp;</span>';
		$pdf->SetMargins(0, 0, 0, true);
		$pdf->writeHTML($html, true, 0, true, true, 'L');

		$pdf->AddPage('L', 'A4');
		$img_file = base_url() . "uploads/temp_sertifikat/SertifikatCalver2.jpeg";
		$pdf->Image($img_file, 0, 0, 297, 210, '', '', '', false, 150, '', false, false, 0);

		if ($lihat) {
			ob_end_clean();
			$pdf->Output('sert_m_guru.pdf', "I");
		} else {
			if (base_url() == "http://localhost/tvsekolah2/") {
				$pdf->Output(FCPATH . 'uploads\sertifikat\sert_cv' . $code_event . $id_peserta . '.pdf', 'F');
			} else {
				$pdf->Output(FCPATH . 'uploads/sertifikat/sert_cv' . $code_event . $id_peserta . '.pdf', 'F');
			}
		}

	}

	private function send_emails($email, $nama_event, $code_event, $id_peserta)
	{

		if (base_url() == "https://tutormedia.net/_tv_sekolah/") {
			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://tutormedia.net',
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
                      <title>Sertifikat Lomba</title>
                  </head>
                  <body>
                      <h2>Terimakasih telah berpartisipasi dalam event " . $nama_event . "</h2>
                      <p>Berikut kami lampirkan Sertifikat Webinar</p>
                  </body>
                  </html>
                  ";

		if (base_url() == "https://tutormedia.net/_tv_sekolah/") {
			$this->email->from('sekretariat@tutormedia.net', 'Sekretariat TVSekolah');
		} else {
			$this->email->from('sekretariat@tvsekolah.id', 'Sekretariat TVSekolah');
		}
		$this->email->to($email);
		$this->email->subject('Sertifikat Webinar');
		$this->email->message($message);
		$this->email->message($message);
		$this->email->attach(base_url() . 'uploads/sertifikat/sert_evt_' . $code_event . $id_peserta . '.pdf');

		if ($this->email->send()) {
			echo "Berhasil";
		} else {
			echo $this->email->print_debugger();
		}
	}

	public function ceksertifikat($kode = null, $opsi = null)
	{
		if ($kode == null)
			redirect("/");
		if ($kode == "A000011") {
			echo "INI UNTUK TES SAJA";
			die();
		}
		$data = array();
		$data['konten'] = 'v_event_ceksertifikat';

		$this->load->model('M_video');
		$kodeevent = substr($kode, 0, 12);
		$idpeserta = substr($kode, 12);

		$data['sertifikat'] = $this->M_video->cekUserEvent($kodeevent, $idpeserta, $opsi);
		if (!$data['sertifikat']) {
			$kodeevent = substr($kode, 0, 11);
			$idpeserta = substr($kode, 11);

			$data['sertifikat'] = $this->M_video->cekUserEvent($kodeevent, $idpeserta, $opsi);
		}

		$data['kode'] = $kode;
		$data['opsi'] = $opsi;

		$this->load->view('layout/wrapper_umum', $data);

	}

	public function ceksertifikatmentor($kode = null, $bulan=null,$tahun=null,$opsi = null)
	{
	
		$data = array();
		$data['konten'] = 'v_event_ceksertifikat_mentor';

		$this->load->model('M_event');

		// $kode = '7q35-l9002';
		$findme   = '_';
		$pos = strpos($kode, $findme,3);
		$kodesert = substr($kode,0,$pos);
		$idsert = substr($kode,$pos+1);
		$data['kode_event'] = $kodesert;
		$data['iduser'] = $idsert;
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$data['sertifikat'] = $this->M_event->getsertifikatmodul($bulan, $tahun, $kodesert, $idsert);

		if (!$data['sertifikat']) {
			$data['iduser'] = "TIDAKVALID";
		}

		$this->load->view('layout/wrapper_umum', $data);

	}

	public function ceksertifikatcalver($kode = null, $opsi = null)
	{

		$data = array();
		$data['konten'] = 'v_event_ceksertifikat_calver';

		$this->load->model('M_event');

		// $kode = '7q35-l9002';
		$findme   = '_';
		$pos = strpos($kode, $findme,3);
		$kodesert = substr($kode,0,$pos);
		$idsert = substr($kode,$pos+1);
		$data['kode_event'] = $kodesert;
		$data['iduser'] = $idsert;

		$tanggalevent = $this->M_event->gettanggalevent($kodesert);
		$bulan = intval(substr($tanggalevent->tgl_jalan,5,2));
		$tahun = intval(substr($tanggalevent->tgl_jalan,0,4));

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$data['sertifikat'] = $this->M_event->getsertifikatcalver($kodesert, $idsert);

		if (!$data['sertifikat']) {
			$data['iduser'] = "TIDAKVALID";
		}

		$this->load->view('layout/wrapper_umum', $data);

	}

	public function tambahnarsum($kodeevent)
	{
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4)
			redirect('/');
		$data = array('title' => 'Tambahkan Narasumber', 'menuaktif' => '21',
			'isi' => 'v_event_tambahnarsum');

		$data['addedit'] = "add";
		$data['code_event'] = $kodeevent;

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function addnarsum($codeevent)
	{
		if ($this->session->userdata('sebagai') != 4 && !$this->session->userdata("a01")) {
			redirect('/');
		}

		$data['id_user'] = $this->input->post('id_user');
		$data['email_sertifikat'] = $this->input->post('iemail');
		$data['npsn'] = $this->input->post('inpsn');
		$data['aktifsebagai'] = $this->input->post('isebagai');
		$data['code_event'] = $codeevent;
		$data['nama_sertifikat'] = $this->input->post('inamalengkap');
		$addedit = $this->input->post('addedit');
		$data['status_user'] = 3;

		if ($addedit == "add") {
			$this->M_video->addnarsum($data);
		} else {
			$this->M_video->updatenarsum($codeevent, $data['id_user'], $data['aktifsebagai']);
		}

//		if ($data['aktifsebagai']=="Keynote Speaker")
//			$this->M_video->updatenarsumevent($codeevent,"idnarsum1",$data['id_user']);
//		else if ($data['aktifsebagai']=="Narasumber 2")
//			$this->M_video->updatenarsumevent($codeevent,"idnarsum2",$data['id_user']);
//		else if ($data['aktifsebagai']=="Ketua Panitia")
//			$this->M_video->updatenarsumevent($codeevent,"idnarsum3",$data['id_user']);

		redirect('/event/aktivasi_event/' . $codeevent . '/1');
	}

	public function tugas_vid()
	{
		setcookie('basis', "video", time() + (86400), '/');

		$data = array('title' => 'Daftar Video', 'menuaktif' => '14',
			'isi' => 'v_video');

		$data['statusvideo'] = 'semua';
		$data['linkdari'] = "video";

		if ($this->is_connected())
			$data['nyambung'] = true;
		else
			$data['nyambung'] = false;

		$id_user = $this->session->userdata('id_user');
		if ($this->session->userdata('a01')) {
			$data['dafvideo'] = $this->M_video->getVideoAll();
			$data['statusvideo'] = 'admin';
		} else if ($this->session->userdata('sebagai') == 4 && $this->session->userdata('verifikator') == 3) {
			$data['dafvideo'] = $this->M_video->getVideoAll();
			$data['statusvideo'] = 'fordorum';
		} else if ($this->session->userdata('a02') && $this->session->userdata('sebagai') != 4) {
			$data['dafvideo'] = $this->M_video->getVideoSekolah($this->session->userdata('npsn'));
			$data['statusvideo'] = 'sekolah';
		} else if ($this->session->userdata('a03')) {
			$data['dafvideo'] = $this->M_video->getVideoUser($id_user);
			$data['statusvideo'] = 'pribadi';
		} else {
			redirect("/");
		}

		$this->load->view('layout/wrapper', $data);
	}

	public function cektugasvideo($linkevent = null, $dataevent = null)
	{
		$iduser = $this->session->userdata('id_user');

		if ($linkevent == null) {
			$codene = $this->input->post('codene');
			$pakevid = $this->input->post('pakevid');
			$pakemodul = $this->input->post('pakemodul');
			$pakebimbel = $this->input->post('pakebimbel');
			$pakeplaylist = $this->input->post('pakeplaylist');
			$link_event = $this->input->post('linkevent');
		} else {
			$codene = $dataevent->code_event;
			$pakevid = $dataevent->butuhuploadvideo;
			$pakemodul = $dataevent->butuhuploadmodul;
			$pakebimbel = $dataevent->butuhuploadbimbel;
			$pakeplaylist = $dataevent->butuhuploadplaylist;
			$link_event = $dataevent->link_event;
		}

//		$codene = "768mk5ucmne3";
//		echo "Codene".$codene;
//		echo "<br>LINKEVENT".$link_event;

		$this->load->Model('M_video');
		$hasil1 = $this->M_video->cekvideotugasevent($codene, $iduser);
		$jmlvideotugas = $hasil1[0]->nvideo;
		$hasil2 = $this->M_video->cekmodultugasevent($codene, $iduser, $pakemodul);
		$jmlmodultugas = $hasil2[0]->nmodul;
		$hasil3 = $this->M_video->cekplaylisttugasevent($codene, $iduser);
		$jmlplaylisttugas = $hasil3[0]->nplaylist;
//		$hasil3 = $this->M_video->cekbimbeltugasevent($codene, $iduser);
//		$jmlbimbeltugas = $hasil3[0]->nbimbel;

		$ambilevent = $this->M_video->getEventbyCode($codene);

		// echo $jmlmodultugas;

//		if ($this->session->userdata('email')=="rosse.larasati@gmail.com") {
			// echo "<pre>";
			// echo var_dump($hasil1);
			// echo "</pre>";
//		}

		$jmlvideo = $ambilevent[0]->jumlahvideo;
		$jmlmodul = $ambilevent[0]->jumlahmodul;
		$jmlplaylist = $ambilevent[0]->jumlahplaylist;
		//		$jmlbimbel = $ambilevent[0]->jumlahbimbel;

		$jmltotal = 111;
		if ($jmlvideotugas >= $jmlvideo || $pakevid == 0)
			$jmltotal = $jmltotal + 1;
		if ($jmlplaylisttugas >= $jmlplaylist || $pakeplaylist == 0)
			$jmltotal = $jmltotal + 10;
		if ($jmlmodultugas >= $jmlmodul || $pakemodul == 0)
			$jmltotal = $jmltotal + 100;

		// echo $jmltotal;
//		if ($jmlbimbeltugas >= $jmlbimbel || $pakebimbel == 0)
//			$jmltotal = $jmltotal + 1000;

//		echo "jmlvideotugas:".$jmlvideotugas."<br>";
//		echo "jmlvideo:".$jmlvideo."<br>";
//		echo "jmlmodultugas:".$jmlmodultugas."<br>";
//		echo "jmlmodul:".$jmlmodul."<br>";
//		echo "jmlbimbeltugas:".$jmlbimbeltugas."<br>";
//		echo "jmlbimbel:".$jmlbimbel."<br>";
//		echo "jmlplaylisttugas:".$jmlplaylisttugas."<br>";
//		echo "jmlplaylist:".$jmlplaylist."<br>";
//		echo "pakeplaylist:".$pakeplaylist."<br>";

		if ($linkevent == null) {
			echo $jmltotal;
		} else {
			return $jmltotal;
		}
		//echo ("Sekolah:".$namasekolah);
	}

	public function buatmodul($linklist = null, $hal = null)
	{
		if ($linklist == null && (!$this->session->userdata('a03') && !$this->session->userdata('a02'))) {
			redirect('/');
		}

		$this->load->model('M_channel');

		if ($linklist != null) {
			$cekevent = $this->M_channel->cekevent_pl_guru($linklist);
			if ($cekevent) {

			} else
				redirect("/");
		}


		$data = array();
		$data['konten'] = 'event_buatmodul';

		$id_user = $this->session->userdata('id_user');
		$data['linklist'] = $linklist;
		$data['hal'] = $hal;
		$id_event = null;
		$cekbuatmodul = 0;

		if ($linklist == null) {
			$id_event = 0;
		} else {
			$judulevent = $this->M_channel->cekevent_pl_guru($linklist);
			if ($judulevent) {
				$data['judulevent'] = $judulevent->nama_event;
				$data['subjudulevent'] = $judulevent->sub2_nama_event;
				$data['jmltugasmodul'] = $judulevent->jumlahmodul;
				$cekbuatmodul = $judulevent->butuhuploadmodul;
				$id_event = $judulevent->id_event;
			}
		}

		$data['cekbuatmodul'] = $cekbuatmodul;

		if($cekbuatmodul==1)
			$data['dafpaket'] = $this->M_channel->getPaketBuatModul($id_user, $id_event);
		else
			$data['dafpaket'] = $this->M_channel->getPaketBuatBimbel($id_user, $id_event);
//        echo "<pre>";
//        echo var_dump($data['dafpaket']);
//        echo "</pre>";
//        die();

		date_default_timezone_set('Asia/Jakarta');
		$date = strtotime("now");
		$tglnow = date('Y-M-d H:i:s', $date);

		//echo $tglnow;

		foreach ($data['dafpaket'] as $datane) {
			//echo "Tgl sekarang: ".$tglnow;
			//echo "Tgl tayang: ".date('Y-M-d H:i:s', strtotime($datane->tanggal_tayang));

			if ($date < strtotime($datane->tanggal_tayang)) {
				//echo "Belum";
				$this->M_channel->update_statuspaket($datane->link_list, 1);
			} else {
				//echo "Lewat";
				$this->M_channel->update_statuspaket($datane->link_list, 2);
			}
			if ($datane->durasi_paket == "00:00:00")
				$this->M_channel->update_statuspaket($datane->link_list, 0);
		}

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function tambahmodul($linklist)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}

		$data = array();
		$data['konten'] = "event_tambahmodul";
		$data['kodelink'] = $linklist;
		$data['addedit'] = "add";

		$this->load->Model('M_channel');
		$judulevent = $this->M_channel->cekevent_pl_guru($linklist);
		if ($judulevent) {
			$data['judulevent'] = $judulevent->nama_event;
			$data['subjudulevent'] = $judulevent->sub2_nama_event;
			$data['idevent'] = $judulevent->id_event;
			$data['cekbuatmodul'] = $judulevent->butuhuploadmodul;
		}

		$this->load->Model('M_video');
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function addmodul()
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
		$data['semester'] = $_POST['isemester'];
		$data['deskripsi_paket'] = $_POST['ideskripsi'];
		$jenismodul = $_POST['jenismodul'];

		// echo $jenismodul;

		$tgtyg = $_POST['datetime'];
		if ($tgtyg != "")
			$data['tanggal_tayang'] = $tgtyg;

		$this->load->model('M_channel');

		if ($_POST['addedit'] == "add") {
			$mikro = str_replace(".", "", microtime(false));
			$mikro = str_replace(" ", "", $mikro);
			$mikro = base_convert($mikro, 10, 36);
			$data['link_list'] = $mikro;
			$data['durasi_paket'] = '00:00:00';
			$data['status_paket'] = '0';
			$data['id_user'] = $this->session->userdata('id_user');
			$data['npsn_user'] = $this->session->userdata('npsn');
			$data['id_event'] = $_POST['idevent'];
			// $data['jenismodul'] = $jenismodul;
			if ($jenismodul==1)
				{
					$data['modulke'] = 0;
					$this->M_channel->addplaylist($data);
				}
			else
				$this->M_channel->addplaylist_bimbel($data);
		} else {
			$link_list = $_POST['linklist'];
			if ($jenismodul==1)
				{
					$data['modulke'] = 0;
					$this->M_channel->updatePlaylist($link_list, $data);
				}
			else
				$this->M_channel->updatePlayList_bimbel($link_list, $data);
		}
		redirect('event/buatmodul/' . $_POST['linkevent']);
	}

	public function hapusplaylist($kodepaket = null, $linklist = null)
	{
		$this->load->model('M_channel');
		$infopaket = $this->M_channel->getInfoPaket($kodepaket);

		$cekid = $infopaket->id_user;

		if ($cekid == $this->session->userdata('id_user')) {

			$this->load->model('M_channel');

			$idvideo = $this->M_channel->getPlayListAll($cekid, $kodepaket);
			$jmldata = 0;
			foreach ($idvideo as $datane) {
				$jmldata++;
				$data['id_video'][$jmldata] = $datane->id_video;
				$data['dilist'][$jmldata] = $datane->dilist;
				$linkevent = $datane->link_event;
			}

			if ($jmldata > 0)
				$this->M_channel->delPlayList($kodepaket, $data);
			else
				$this->M_channel->delPlayList($kodepaket, 0);


			redirect('/event/buatmodul/' . $linklist);

		} else {
			redirect('/');
		}

	}

	public function editmodul($kodepaket, $linkevent)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}

		$data = array();
		$data['konten'] = 'event_tambahmodul';

		$data['addedit'] = "edit";
		$cekbuatmodul = 0;

		$this->load->Model('M_channel');
		$judulevent = $this->M_channel->cekevent_pl_guru($linkevent);
		if ($judulevent) {
			$data['judulevent'] = $judulevent->nama_event;
			$data['subjudulevent'] = $judulevent->sub2_nama_event;
			$data['idevent'] = $judulevent->id_event;
			$cekbuatmodul = $judulevent->butuhuploadmodul;
		}
		$data['cekbuatmodul'] = $cekbuatmodul;

		if ($cekbuatmodul==1)
			$data['datapaket'] = $this->M_channel->getInfoPaket($kodepaket);
		else
			$data['datapaket'] = $this->M_channel->getInfoBimbel($kodepaket);

		// echo "<pre>";
		// echo var_dump($data['datapaket']);
		// echo "</pre>";
		// die();

		$data['kodepaket'] = $kodepaket;
		$data['kodelink'] = $linkevent;

		$idjenjang = $data['datapaket']->id_jenjang;
		$this->load->model('M_bimbel');
		$data['dafjenjang'] = $this->M_bimbel->getJenjangAll();
		$data['dafkelas'] = $this->M_bimbel->getKelasJenjang($idjenjang);
		$data['dafmapel'] = $this->M_bimbel->getMapelJenjang($idjenjang);
		$this->load->model('M_video');
		$data['dafjurusan'] = $this->M_video->dafJurusan();
		$data['dafjurusanpt'] = $this->M_video->dafJurusanPT();

		$this->load->view('layout/wrapper_tabel', $data);
	}

	public function videomodul($kodepaket, $linkevent)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}

		setcookie('basis', "event", time() + (86400), '/');

		$id_user = $this->session->userdata('id_user');
		$data = array();
		$data['konten'] = "event_inputvideo";
		$data['namapaket'] = "";

		$this->load->Model('M_video');
		$thisevent = $this->M_video->getAllEvent($linkevent);
		$viaver = $thisevent[0]->viaverifikator;

		$sifat = $thisevent[0]->butuhuploadmodul;

		$data['judulevent'] = $thisevent[0]->nama_event;
		$data['cekbuatmodul'] = $sifat;
		$data['subjudulevent'] = $thisevent[0]->sub2_nama_event;
		
		// echo $thisevent[0]->id_event;
		//$data['dafvideo'] = $this->M_video->getVideobyEvent($thisevent[0]->id_event, $viaver, $sifat);

		$data['linkevent'] = $linkevent;

		$this->load->model('M_channel');
		if ($sifat==1)
			$data['dafvideo'] = $this->M_channel->getVideoUser($id_user, $kodepaket, $linkevent);
		else
			$data['dafvideo'] = $this->M_channel->getVideoBimbel($id_user, $kodepaket, $linkevent);

		// echo $sifat;
		// echo "<pre>";
		// echo var_dump($data['dafvideo']);
		// echo "</pre>";

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$this->load->view('layout/wrapper_tabel', $data);

	}

	public function buatbimbel($linklist = null, $hal = null)
	{

	}

	public function playlist($kodelink, $hal)
	{
		$getevent = $this->M_event->getAllEventAktif($kodelink);
		if ($getevent[0]->status_user != 2) {
			redirect('/');
		}

		$npsn = $this->session->userdata('npsn');
		$id = $this->session->userdata('id_user');

		$this->load->Model('M_video');
		$getevent = $this->M_video->getAllEvent($kodelink);

		$data = array();
		$data['konten'] = 'event_playlist';
		$data['kodelink'] = $kodelink;
		$data['hal'] = $hal;
		$data['namaevent'] = $getevent[0]->nama_event;
		$data['sub2judulevent'] = $getevent[0]->sub2_nama_event;
		$data['jmltugasplaylist'] = $getevent[0]->jumlahplaylist;
		$this->load->Model('M_channel');
		$data['dafpaket'] = $this->M_channel->getPaketSekolahEvent($kodelink, $id);
//
//		echo "<pre>";
//		echo var_dump($data['dafpaket']);
//		echo "</pre>";
//		die();

		$this->load->view('layout/wrapper_tabel', $data);

	}

	public function tambahplaylist($hari, $kodelink, $hal)
	{
		$data = array();
		$data['konten'] = "event_tambahplaylist";
		$data['addedit'] = "add";
		$data['hari'] = $hari;
		$data['kodelink'] = $kodelink;
		$data['hal'] = $hal;
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function addplaylist($kodelink, $hal)
	{
		$data = array();
		$data['jam_tayang'] = $_POST['time'] . ":00:00";
		$data['hari'] = $_POST['hari'];
		$this->load->model('M_channel');

		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
		$stglsekarang = $tglsekarang->format("Y-m-d H:i:s");

		$npsn = $this->session->userdata('npsn');

		$getevent = $this->M_channel->cekevent_pl_guru($kodelink);
		$kodeevent = $getevent->code_event;

		if ($_POST['addedit'] == "add") {
			$mikro = str_replace(".", "", microtime(false));
			$mikro = str_replace(" ", "", $mikro);
			$mikro = base_convert($mikro, 10, 36);
			$data['link_list'] = $mikro;
			$data['durasi_paket'] = '00:00:00';
			$data['status_paket'] = '0';
			$data['jenis_paket'] = '2';
			$data['npsn'] = $npsn;
			$data['nama_paket'] = $kodeevent;
			$data['iduser'] = $this->session->userdata('id_user');
			$data['modified'] = $stglsekarang;
			$this->M_channel->addplaylist_sekolah($data);
		} else {
			$link_list = $_POST['linklist'];
			$this->M_channel->updatePlaylist_sekolah($link_list, $data);
		}

		$this->updateharitayang($kodeevent);

		redirect('event/playlist/' . $kodelink . '/' . $hal);
	}

	public function updateharitayang($kodeevent)
	{
		$tayang_channel = $this->M_channel->cektayangchannelevent($kodeevent);
		foreach ($tayang_channel as $row) {
			$data['haritayang'] = $row->totharitayang;
			$durasi = $row->tottotaltayang;
			$durasi = substr($durasi, 0, 8);
			$data['totaltayang'] = $durasi;
		}

		$this->M_channel->updatetayangchannel($data, $npsn);
	}

	public function inputplaylist($kodepaket, $linkevent, $hal)
	{

		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}

		$this->load->model('M_channel');
		if ($linkevent != null) {
			$cekevent = $this->M_channel->cekevent_pl_guru($linkevent);

			if ($cekevent) {
				$idevent = $cekevent->id_event;
			} else
				redirect("/");
		}

		$npsn = $this->session->userdata('npsn');
		$id = $this->session->userdata('id_user');

		$data = array();
		$data['konten'] = "event_inputplaylist";

		$getpaketsekolah = $this->M_channel->getPaketChannelSekolah($kodepaket);
		$idpaket = $getpaketsekolah['id'];
		$data['nama_paket'] = $getpaketsekolah['nama_paket'];
		$data['harike'] = $getpaketsekolah['hari'];
		$data['dafvideo'] = $this->M_channel->getVideoEvent($npsn, $kodepaket, $idevent);
		$data['jml_video'] = sizeof($data['dafvideo']);
		$data['link_event'] = $linkevent;
		$data['hal'] = $hal;

//		echo "<pre>";
//		echo var_dump($data['dafvideo']);
//		echo "</pre>";

		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$this->load->view('layout/wrapper_tabel', $data);

	}

	public function urutanplaylist_sekolah($kodepaket = null)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}
		$data = array();
		$data['konten'] = "v_channel_urutanplaylist_sekolah";
		$this->load->model('M_channel');


		$getpaketsekolah = $this->M_channel->getPaketChannelSekolah($kodepaket);
		$idpaket = $getpaketsekolah['id'];
		$data['nama_paket'] = $getpaketsekolah['nama_paket'];
		$data['harike'] = $getpaketsekolah['hari'];
		$data['mulaijam'] = $getpaketsekolah['jam_tayang'];
		$data['dafvideo'] = $this->M_channel->getVideoSekolahEkskulUrut($idpaket);
		$data['jml_video'] = sizeof($data['dafvideo']);


		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$this->load->view('layout/wrapper_umum', $data);

	}

	public function updateurutan_sekolah()
	{

		$data = array();
		$data['id'] = $this->input->post('id');
		$data['urutan'] = $this->input->post('urutan');
		//    $this->db->update_batch('tb_channel_video_sekolah', $data, 'id');
		$this->load->model('M_channel');
		$this->M_channel->updateurutan_sekolah($data);
//        echo "Data_ID 3 = ".$data['id'][2];
//        echo "Data_URUTAN 3 = ".$data['urutan'][2];
	}

	public function playlist3()
	{

		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}

		$npsn = $this->session->userdata('npsn');
		$id = $this->session->userdata('id_user');
		$this->load->Model('M_ekskul');
		$dataekskul = $this->M_ekskul->getEkskul($npsn);
		$status = $this->cekstatus($dataekskul);
		$dibayaroleh = $this->cekbayareskul();
		$jmlpembayar = substr($dibayaroleh, 6);

		$data = array();
		$data['konten'] = 'v_channel_playlistsekolah';
		$data['dibayaroleh'] = $dibayaroleh;
		$data['jmlpembayar'] = $jmlpembayar;
		$data['status'] = $status;
		$data['dafpaket'] = $this->M_channel->getPaketSekolah($npsn);

		$this->load->view('layout/wrapper_tabel', $data);

	}

	public function urutanplaylist($kodepaket, $linkevent, $hal)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}
		$data = array();
		$data['konten'] = "event_urutanplaylist";
		$this->load->model('M_channel');


		$getpaketsekolah = $this->M_channel->getPaketChannelSekolah($kodepaket);
		$idpaket = $getpaketsekolah['id'];
		$data['nama_paket'] = $getpaketsekolah['nama_paket'];
		$data['harike'] = $getpaketsekolah['hari'];
		$data['mulaijam'] = $getpaketsekolah['jam_tayang'];
		$data['dafvideo'] = $this->M_channel->getVideoSekolahEkskulUrut($idpaket);
		$data['jml_video'] = sizeof($data['dafvideo']);
		$data['link_event'] = $linkevent;
		$data['hal'] = $hal;


		if (!$kodepaket == null)
			$data['kodepaket'] = $kodepaket;
		else
			$data['kodepaket'] = "0";

		$this->load->view('layout/wrapper_umum', $data);

	}

	public function editplaylist($kodelink, $linkevent, $hal)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}

		$this->load->model('M_channel');

		if ($kodelink != null) {
			$cekevent = $this->M_channel->cekevent_pl_guru($linkevent);

			if ($cekevent) {
				$linklist = $cekevent->code_event;
			} else
				redirect("/");
		}

		$data = array();
		$data['konten'] = 'event_tambahplaylist';
		$data['addedit'] = "edit";
		$getpaket = $this->M_channel->getInfoPaketSekolah($kodelink);
		$data['datapaket'] = $getpaket;
		$data['hari'] = $getpaket->hari;

		$data['kodelink'] = $linkevent;
		$data['hal'] = $hal;
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function calon_verifikator($kode_event=null)
	{
		if ($this->session->userdata('siam')==3)
		redirect ("/marketing/daftar_event_ver");
		if (!$this->session->userdata('loggedIn'))
		{
			if ($kode_event!=null)
				redirect(base_url()."login/registrasi/calver/".$kode_event);
			else
				redirect("/");
		}
		else
		{
			setcookie('mentor', '--', time() + (86400), '/');
			$getuser = getstatususer();
			$referrer = $getuser['referrer']; 
			$this->load->model("M_marketing");
			if($cekevent = $this->M_marketing->cekrefevent($referrer))
			{
				$gatatugasevent = $this->M_marketing->gettugasevent($referrer);
				if ($kode_event==null)
				$kode_event=$referrer;
				$gatadafevent = $this->M_marketing->getdafeventcalver($kode_event,null,$this->session->userdata('id_user'));
				// print_r($gatadafevent);
				if (!$gatadafevent)
				{
					echo "Anda belum terdaftar sebagai Calon Verifikator Event Ini! Hubungi admin!";
					die();
				}
				
				$data = array();
				$this->load->Model('M_channel');
				$data['datapesan'] = $this->M_channel->getChat(6, null, $referrer);
				$data['id_playlist'] = $referrer;//."Od".$this->session->userdata("id_user");
				$data['jenis'] = "calver";
				$data['kodeevent'] = $kode_event;

				$data['idku'] = $this->session->userdata('id_user');
				
				$data['konten'] = 'vk_dashboard_calver';

				$nama_sertifikat = $gatadafevent[0]->nama_sertifikat;
				$email_sertifikat = $gatadafevent[0]->email_sertifikat;
				$download_sertifikat = $gatadafevent[0]->download_sertifikat;
		
				$full_name = $this->session->userdata('full_name');

				$data['nama_sertifikat'] = $nama_sertifikat;
				$data['email_sertifikat'] = $email_sertifikat;
				$data['download_sertifikat'] = $download_sertifikat;
				$data['sertifikatfix'] = true;
				$data['cekfix'] = "block";

				if ($nama_sertifikat=="")
				{
					$data['sertifikatfix'] = false;
					$data['email_sertifikat'] = $this->session->userdata('email');
					$data['nama_sertifikat'] = $full_name;
					$data['cekfix'] = "none";
					if ($full_name=="")
						$data['nama_sertifikat'] = $this->session->userdata('first_name').
						" ".$this->session->userdata('last_name');
				}

				
			
				$hitungvideo = $this->M_marketing->hitungvideo();
				$jml_video_kontri = $hitungvideo['jml_video_kontri'];
				$jml_video_kontriok = $hitungvideo['jml_video_kontriok'];
				$hitungsiswa = $this->M_marketing->hitungsiswa();	
				$jml_siswa = $hitungsiswa['jml_siswa'];

				$this->load->Model('M_ekskul');
				$dataekskul = $this->M_ekskul->getEkskul($this->session->userdata('npsn'));
				$jml_siswaekskul = sizeof($dataekskul);

				$data['judulevent'] = $cekevent->npsn_sekolah;
				$data['tanggalevent'] = namabulan_panjang(substr($cekevent->tgl_jalan,0,10));
				$data['linkvideo'] = $gatatugasevent->link_video;
				$data['videotugas'] = $gatatugasevent->jml_video;
				$data['playlisttugas'] = $gatatugasevent->jml_playlist;
				$data['kontrialltugas'] = $gatatugasevent->jml_kontri;
				$data['videokontriall'] = $gatatugasevent->jml_video_kontri;
				$data['jmlsiswatugas'] = $gatatugasevent->jml_ekskul;
				$data['videocalver'] = $gatadafevent[0]->jmlvideocalver;
				$data['playlistcalver'] = $gatadafevent[0]->jml_playlist;
				$data['kontriallcalver'] = $gatadafevent[0]->jml_kontri;
				$data['kontriok'] = $gatadafevent[0]->jml_kontriok;
				$data['videokontricalver'] = $jml_video_kontri;
				$data['videokontriok'] = $jml_video_kontriok;
				$data['jmlsiswacalver'] = $jml_siswa;
				$data['jmlsiswaekskulcalver'] = $jml_siswaekskul;

				$data['komplit'] = "false";
				if(($data['videocalver']>=$data['videotugas']) && 
					($data['playlistcalver']>=$data['playlisttugas']) &&
					($data['kontriallcalver']>=$data['kontrialltugas']) &&
					($data['kontriok']>=$data['kontrialltugas']) &&
					($data['videokontriok']>=$data['videokontriall']*$data['kontrialltugas']) &&
					($data['jmlsiswaekskulcalver']>=$data['jmlsiswatugas']) )
					$data['komplit'] = "true";
				
				$this->load->view('layout/wrapper_umum', $data);
			}
			else
				echo "KODE REFERAL ANDA TIDAK VALID";
			
		}
		
	}

	public function calon_guru($kode_event=null)
	{
		if($cekevent = $this->M_marketing->cekrefevent($kode_event))
		{
			echo "KODE TIDAK VALID";
			die();
		}

		if ($kode_event==null)
				redirect("/");

		if ($this->session->userdata('siam')==3)
			redirect ("/marketing/daftar_event_ver");

		if (!$this->session->userdata('loggedIn'))
		{
			redirect(base_url()."login/registrasi/guru/".$kode_event);
		}
		else
		{
			redirect("/");		
		}
		
	}

	public function mentor($param, $param2=null, $param3=null)
	{
		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}

		if ($param=="video")
		{
			$getuser = getstatususer();
			$referrer = $getuser['referrer']; 
			$this->load->model("M_marketing");
			if($cekevent = $this->M_marketing->cekrefevent($referrer))
			{
				if ($param2=="tambah")
				{
					$this->tambahvideocalver($referrer);
				}
				else if ($param2=="edit")
				{
					$this->editvideocalver($referrer, $param3);
				} 
				else
				{
					$dataevent = $this->M_marketing->gettugasevent($referrer);

					$data = array();
					$data['konten'] = 'v_video';
					$statusverifikator = "bukan";
					
					$data['status_verifikator'] = $statusverifikator;
					$data['statusvideo'] = 'calver';
					$data['linkdari'] = 'calver';
					$data['opsi'] = 'calvermentor';
					$data['linkevent'] = $param;
					$data['hal'] = 1;
					$data['kodevent'] = $param2;
					
					$data['jmltugasvideo'] = $dataevent->jml_video;
					$data['kodeevent'] = $referrer;
					$data['subjudulevent'] = $cekevent->npsn_sekolah;
					$data['subjudulevent2'] = namabulan_panjang($cekevent->tgl_jalan);
					$data['dafvideo'] = $this->M_video->getVideobyEvent($cekevent->id, 0);

					$this->load->view('layout/wrapper_tabel', $data);
				}
			}
			else
			{
				redirect ("/");
			}
		}
		
	}

	function tambahvideocalver($linkevent)
	{
		$data = array();
		$data['konten'] = 'v_video_tambah';
		$data['addedit'] = "add";
		$data['linkdari'] = "calver";
		$data['linkevent'] = "calver";
		$this->load->Model('M_video');
		$data['dataevent'] = "";
		$data['kodeevent'] = $linkevent;
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['datavideo'] = Array('status_verifikasi' => 0);
		$data['idvideo'] = 0;
		$data['namafile'] = "";
		//	if ($judul!=null)
		//		$data['judulvideo'] = $judul;
		$this->load->view('layout/wrapper_umum', $data);
	}

	function editvideocalver($linkevent, $id_video)
	{

		$data = array();
		$data['konten'] = 'v_video_tambah';
		$data['addedit'] = "edit";
		$data['linkdari'] = "calver";
		$data['linkevent'] = "calver";
		$this->load->Model('M_video');
		$data['dataevent'] = "";
		$data['kodeevent'] = $linkevent;


		
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['datavideo'] = $this->M_video->getVideo($id_video);

		$iduservideo = $data['datavideo']['id_user'];
		if ($iduservideo!=$this->session->userdata("id_user"))
		redirect("/");

		$data['dafkelas'] = $this->M_video->dafKelas($data['datavideo']['id_jenjang']);
		// $data['dataevent'] = $this->M_video->getbyCodeEvent($kode);
		$data['dafmapel'] = $this->M_video->dafMapel($data['datavideo']['id_jenjang'], $data['datavideo']['id_jurusan']);

		$data['dafjurusan'] = $this->M_video->dafJurusan();

		$data['idvideo'] = $id_video;

		$data['jenisvideo'] = "yt";
		
		$data['dafkd1'] = $this->M_video->dafKD($data['datavideo']['kdnpsn'], $data['datavideo']['kdkur'], $data['datavideo']['id_kelas'], $data['datavideo']['id_mapel'], $data['datavideo']['id_ki1']);
		$data['dafkd2'] = $this->M_video->dafKD($data['datavideo']['kdnpsn'], $data['datavideo']['kdkur'], $data['datavideo']['id_kelas'], $data['datavideo']['id_mapel'], $data['datavideo']['id_ki2']);
		$this->load->view('layout/wrapper_umum', $data);	
	}

}
