<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seting extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_induk");
		$this->load->model('M_video');
		$this->load->model('M_seting');
		$this->load->helper('video');
		$this->load->helper('download');
		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4 && !$this->session->userdata('a02')) {
			redirect('/');
		}
		$this->load->helper(array('Form', 'Cookie'));
	}

	public function index()
	{
		$data = array('title' => 'Home2', 'menuaktif' => '21',
			'isi' => 'v_seting');
		//$data['userData']=$this->session->userdata('userData');
		$this->load->view('layout/wrapper', $data);
	}

	public function cobacari()
	{
		$data = array('title' => 'SEARCH', 'menuaktif' => '21',
			'isi' => 'v_cobacari');
		//$data['userData']=$this->session->userdata('userData');
		$data['info'] = $this->getVideoInfo('ApMWcabuSTg');
		$this->load->view('layout/wrapper', $data);

	}

	// $vid - video id in youtube
	// returns - video info
	public function getVideoInfo($vidkey)
	{
		//$vidkey = "ApMWcabuSTg";
		$apikey = "AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU";
		$dur = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=$vidkey&key=$apikey");
		$VidDuration = json_decode($dur, true);
		foreach ($VidDuration['items'] as $vidTime) {
			$VidDuration = $vidTime['contentDetails']['duration'];
		}
		preg_match_all('/(\d+)/', $VidDuration, $parts);
		$hours = intval(floor($parts[0][0] / 60) * 60 * 60);
		$minutes = intval($parts[0][0] % 60 * 60);
		$seconds = intval($parts[0][1]);
		$totalSec = $hours + $minutes + $seconds;
		return $totalSec;
	}

	public function updatekodevideo()
	{
		if (!$this->session->userdata('a01')) {
			redirect("/");
		}
		$this->load->model('M_video');
		$daftarvideo = $this->M_video->getVideoAll2();
		$data2 = array();
		$baris = 0;
		foreach ($daftarvideo as $row) {
			$baris++;
			$kode_area = base_convert($row->created, 10, 16);
			$data2[$baris]['kode_video'] = $kode_area;
			$data2[$baris]['id_video'] = $row->id_video;

			echo "TGL:" . $row->created . ", JADI:" . $kode_area . '<br>';
		}
		$this->M_video->updateVideoAll($data2);
	}

	public function penilaian()
	{
		$data = array('title' => 'Daftar Penilaian', 'menuaktif' => '21',
			'isi' => 'v_seting_penilaian');
		//$data['dafpenilaian']=$this->session->userdata('userData');
		$this->load->model('M_seting');
		$data['dafpenilaian'] = $this->M_seting->getPenilaian();
		$this->load->view('layout/wrapper', $data);
	}

	public function editpenil()
	{
		$soal = $_POST['soal'];
		$jmlsoal = $_POST['jmlsoal'];
		$this->load->model('M_seting');
		$this->M_seting->updatePenilaian($soal, $jmlsoal);
		echo 'ok';
	}

	public function addkd()
	{
//		$idkelas = $_POST['idkelas'];
//		$idmapel = $_POST['idmapel'];
//		$idki = $_POST['idki'];
//		$kade = $_POST['tekskd'];

//		$idkelas = 9;
//		$idmapel = 5;
//		$idki = 3;
//		$kade = 'Aha';
//
//		$data['id_kelas'] = $idkelas;
//		$data['id_mapel'] = $idmapel;
//		$data['id_ki'] = $idki;
//		$data['nama_kd'] = $kade;
//
//		//$this->load->model('M_seting');
//		//$this->M_seting->addKD($data);
//
//		$this->load->model('M_video');
//		$isi = $this->M_video->dafKD($idkelas, $idmapel, $idki);
//
//		echo json_encode($isi);

		$idkelas = 9;
		$idmapel = 5;
		$idki = 3;

		$isi = $this->M_video->dafKD($idkelas, $idmapel, $idki);
		echo json_encode($isi);

	}

	public function kurangisoal()
	{
		$jmlsoal = $_POST['jmlsoal'];
		$this->load->model('M_seting');
		$this->M_seting->kurangiPenilaian($jmlsoal);
		echo 'ok';
	}

	public function kompetensi()
	{
		$data = array('title' => 'Kompetensi Dasar', 'menuaktif' => '21',
			'isi' => 'v_seting_kd');
		$this->load->model('M_video');
		$data['dafkurikulum'] = $this->M_video->getKurikulum();
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();

		$this->load->view('layout/wrapper', $data);
	}

	public function mapel()
	{
		$data = array('title' => 'Mata Pelajaran', 'menuaktif' => '21',
			'isi' => 'v_seting_mapel');
		$this->load->model('M_video');
		$data['dafjenjang'] = $this->M_video->getAllJenjang();
		$data['dafkategori'] = $this->M_video->getAllKategori();
		$data['dafjurusan'] = $this->M_video->dafJurusan();
		$data['dafjurusanpt'] = $this->M_video->dafJurusanPT();

		$this->load->view('layout/wrapper', $data);
	}

	public function daftarsekolah($idkota = null)
	{
		$data = array('title' => 'Daftar Sekolah', 'menuaktif' => '21',
			'isi' => 'v_seting_daftarsekolah');
		$this->load->model('M_login');
		$data['dafpropinsi'] = $this->M_login->dafpropinsi(1);
		$data['idpropinsi'] = 0;
		$data['idkota'] = null;
		if ($idkota != null) {
			$data['idpropinsi'] = $this->M_login->getKota($idkota)[0]->id_propinsi;
			$data['idkota'] = $idkota;
			$data['dafkota'] = $this->M_login->dafkota($data['idpropinsi']);
			$data['dafsekolah'] = $this->M_login->dafsekolah($idkota);
		}

		$this->load->view('layout/wrapper', $data);
	}

	public function tambahsekolah($idkota)
	{
		$data = array('title' => 'Tambah Sekolah', 'menuaktif' => '21',
			'isi' => 'v_seting_sekolah_tambah');
		$data['addedit'] = 'add';
		$this->load->model('M_login');
		$data['idpropinsi'] = $this->M_login->getKota($idkota)[0]->id_propinsi;
		$data['nama_propinsi'] = $this->M_login->getProp($data['idpropinsi'])[0]->nama_propinsi;
		$data['idkota'] = $idkota;
		$data['nama_kota'] = $this->M_login->getKota($idkota)[0]->nama_kota;

		$this->load->view('layout/wrapper', $data);
	}

	public function editsekolah($idsekolah)
	{
		$data = array('title' => 'Tambah Sekolah', 'menuaktif' => '21',
			'isi' => 'v_seting_sekolah_tambah');
		$data['addedit'] = 'edit';
		$this->load->model('M_login');
		$data['dafsekolah'] = $this->M_login->getSekolahbyId($idsekolah);
		$idkota = $data['dafsekolah'][0]->id_kota;
		$data['idkota'] = $idkota;
		$data['idpropinsi'] = $this->M_login->getKota($idkota)[0]->id_propinsi;
		$data['nama_propinsi'] = $this->M_login->getProp($data['idpropinsi'])[0]->nama_propinsi;
		$data['nama_kota'] = $this->M_login->getKota($idkota)[0]->nama_kota;

		$this->load->view('layout/wrapper', $data);
	}

	public function updatesekolah()
	{
		$data = array();
		$data['id_kota'] = $_POST['idkota'];
		$data['id_jenjang'] = $_POST['idjenjang'];
		$data['nama_sekolah'] = $_POST['nama_sekolah'];
		$data['alamat_sekolah'] = $_POST['alamat_sekolah'];
		$data['npsn'] = $_POST['npsn'];
		$data['kecamatan'] = $_POST['kecamatan'];
		$data['desa'] = $_POST['desa'];
		$this->load->model('M_seting');
		if ($_POST['addedit'] == 'add') {
			$this->M_seting->addSekolah($data);
		} else {
			$id_sekolah = $_POST['idsekolah'];
			$this->M_seting->updateSekolah($data, $id_sekolah);
		}
	}

	public function delsekolah()
	{
		$id = $_POST['id'];
		$this->load->model('M_seting');
		$this->M_seting->delSekolah($id);
		//echo 'ok';
	}

	public function jurusansmk()
	{
		$data = array('title' => 'Jurusan SMK', 'menuaktif' => '21',
			'isi' => 'v_seting_jurusansmk');
		$this->load->model('M_video');
		$data['dafjurusan'] = $this->M_video->dafJurusan();
		$this->load->view('layout/wrapper', $data);
	}

	public function fakultas()
	{
		$data = array('title' => 'Fakultas Perguruan Tinggi', 'menuaktif' => '21',
			'isi' => 'v_seting_fakultas');
		$this->load->model('M_video');
		$data['daffakultas'] = $this->M_video->dafFakultas();
		$this->load->view('layout/wrapper', $data);
	}

	public function tambahjurusansmk()
	{
		$jurusan = $_POST['jurusan'];
		$data = array('nama_jurusan' => $jurusan);
		$this->load->model('M_seting');
		$this->M_seting->addJurusanSMK($data);
		//echo 'ok';
	}

	public function editjurusansmk()
	{
		$id = $_POST['id'];
		$jurusan = $_POST['jurusan'];
		$data = array('nama_jurusan' => $jurusan);
		$this->load->model('M_seting');
		$this->M_seting->updateJurusanSMK($data, $id);
		//echo 'ok';
	}

	public function deljurusansmk()
	{
		$id = $_POST['id'];
		$this->load->model('M_seting');
		$this->M_seting->delJurusanSMK($id);
		//echo 'ok';
	}

	public function tambahfakultas()
	{
		$fakultas = $_POST['fakultas'];
		$data = array('nama_fakultas' => $fakultas);
		$this->load->model('M_seting');
		$this->M_seting->addFakultas($data);
		//echo 'ok';
	}

	public function editfakultas()
	{
		$id = $_POST['id'];
		$fakultas = $_POST['fakultas'];
		$data = array('nama_fakultas' => $fakultas);
		$this->load->model('M_seting');
		$this->M_seting->updateFakultas($data, $id);
		//echo 'ok';
	}

	public function delfakultas()
	{
		$id = $_POST['id'];
		$this->load->model('M_seting');
		$this->M_seting->delFakultas($id);
		//echo 'ok';
	}

	public function jurusanpt()
	{
		$data = array('title' => 'Jurusan Perguruan Tinggi', 'menuaktif' => '21',
			'isi' => 'v_seting_jurusanpt');
		$this->load->model('M_video');
		$data['daffakultas'] = $this->M_video->dafFakultas();

		$this->load->view('layout/wrapper', $data);
	}

	public function url_live($harike = null)
	{
		$data = array('title' => 'Seting URL Live', 'menuaktif' => '23',
			'isi' => 'v_seting_live');
		$this->load->model('M_induk');
		date_default_timezone_set('Asia/Jakarta');

		if ($harike == null) {
			$now = new DateTime();
			$harike = date_format($now, 'N');
		}
		//echo $harike;
		$data['harike'] = $harike;
		$data['url_live'] = $this->M_induk->get_url_live();
		$this->load->model('M_video');
		$data['dafevent'] = $this->M_video->getAllEvent(null, 1);
		$data['dafacara'] = $this->M_induk->get_acara_live(0);
		$this->load->view('layout/wrapper', $data);
	}

	public function seting_live()
	{
		$data = array('title' => 'Seting URL Live', 'menuaktif' => '23',
			'isi' => 'v_live_edit');
		$this->load->model('M_induk');

		//echo $harike;
		$this->load->model('M_video');
		$data['dafevent'] = $this->M_video->getAllEvent(null, 1);
		$dafacara = $this->M_induk->get_acara_live(0);
		$data['dafacara'] = $dafacara[0];
		$this->load->view('layout/wrapper', $data);
	}

	public function updateurl_live()
	{
		$this->load->model('M_induk');
		$data['url'] = $_POST['url_baru'];
		$this->M_induk->updateurl_live($data);
		redirect('/live');
	}

	public function updateliveseting()
	{
		$this->load->model('M_induk');
		$data['link1'] = $_POST['isiurl1'];
		$data['link2'] = $_POST['isiurl2'];
		$data['link3'] = $_POST['isiurl3'];
		$data['tekslink1'] = $_POST['turl1'];
		$data['tekslink2'] = $_POST['turl2'];
		$data['tekslink3'] = $_POST['turl3'];
		$tglmulai = new DateTime($_POST['tglmulai']);
		$data['tanggal_mulai'] = $tglmulai->format("Y-m-d H:i:s");
		$tglselesai = new DateTime($_POST['tglselesai']);
		$data['tanggal_selesai'] = $tglselesai->format("Y-m-d H:i:s");

		$this->M_induk->updateliveseting($data);
	}


	public function addAcara()
	{
		$data = array('harike' => $_POST['harike'], 'urutan' => $_POST['urutan'],
			'jam' => $_POST['jame'], 'acara' => $_POST['acarae']);
		$this->load->model('M_seting');
		$this->M_seting->addAcara($data);
		echo 'ok';
	}

	public function editAcara()
	{
		$data = array('jam' => $_POST['jame'], 'acara' => $_POST['acarae']);
		$id = $_POST['ide'];
		$this->load->model('M_seting');
		$this->M_seting->updateAcara($data, $id);
		echo 'ok';
	}

	public function kurangAcara()
	{
		$data = array('urutan' => $_POST['urutan'], 'harike' => $_POST['harike']);
		$this->load->model('M_seting');
		$this->M_seting->delAcara($data);
		echo 'ok';
	}

	public function soal($opsi = null, $asseske = null)
	{
		$this->load->model('M_seting');
		if ($opsi == "tampilkan") {
			$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_assesment_tampil');
			$data['soalkeluar'] = 0;
			$data['acaksoal'] = 0;
			$data['dafsoal'] = $this->M_seting->getSoal($asseske);
			$data['asseske'] = $asseske;
			$data['asal'] = "owner";
		} else if ($opsi == "buat") {
			$data = array('title' => 'Soal Latihan', 'menuaktif' => '15',
				'isi' => 'v_assesment_buatsoal');
			$data['dafsoal'] = $this->M_seting->getSoal($asseske);
			$data['asseske'] = $asseske;
			$data['asal'] = "owner";
		} else if ($opsi == null) {
			$data = array('title' => 'Buat Soal Assesment', 'menuaktif' => '15',
				'isi' => 'v_seting_buat_assesment');
		} else if ($opsi != "tampilkan") {
			$data = array('title' => 'Mulai Soal', 'menuaktif' => '15',
				'isi' => 'v_seting_mulai');
			$data['soalkeluar'] = 0;
			$data['acaksoal'] = 0;
			$dafsoal = $this->M_seting->getSoal($asseske);
			$data['totalsoal'] = sizeof($dafsoal);
			$data['asseske'] = $asseske;
			$data['asal'] = "owner";
		}

		$this->load->view('layout/wrapper2', $data);
	}

	public function upload_gambarsoal($asseske, $id, $kodefield, $fielddb)
	{
//		if (!$this->session->userdata('a01') && $this->session->userdata('sebagai') != 4) {
//			redirect('/event');
//		}

		$random = rand(100, 999);
		if (isset($_FILES['f' . $kodefield])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$path1 = "assesment/";
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
				$config['source_image'] = './uploads/assesment/' . $gbr['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['quality'] = '50%';
				$config['width'] = 600;
				$config['new_image'] = './uploads/assesment/' . $gbr['file_name'];
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

			$namafilebaru = "ggr" . $asseske . "_" . $id . "_" . $random . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$this->M_seting->updategbrsoal($namafilebaru, $id, $fielddb);

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

	public function updatesoal($asseske)
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

		$this->load->model('M_seting');
		$this->M_seting->updatesoal($data, $idsoal);

		redirect('seting/soal/buat/' . $asseske);
	}

	public function insertsoal($asseske)
	{

		$idbaru = $this->M_seting->insertsoal($asseske);
		if ($idbaru > 0)
			echo $idbaru;
		else
			echo "gagal";
	}

	public function delsoal()
	{
		$id = $this->input->post('id_soal');
		{
			if ($this->M_seting->delsoal($id))
				echo "berhasil";
			else
				echo "gagal";
		}
	}

	public function cekjawaban()
	{
		$jawaban_user = $this->input->post('jwbuser');
		$idjawaban_user = $this->input->post('idjwbuser');
		$iduser = $this->session->userdata('id_user');
		$asseske = $this->input->post('asseske');
		$tugaske = substr($asseske, 1, 1);
		$kunci_jawaban = $this->M_seting->getSoal($tugaske);
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

//		echo "NOMOR:".$nomor;
//		die();

		$nilai = intval($betul * (100 / ($nomor - 1)) * 100) / 100;
		if ($nilai == 0)
			$nilai = 1;
		$data = array();
		$data['nilaitugas' . $tugaske] = $nilai;
		$tgl_sekarang = new DateTime();
		$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$data['tgltugas' . $tugaske] = $tgl_sekarang->format("Y-m-d H-i:s");
		$update = $this->M_assesment->updateNilai($data, $iduser);
		if ($update)
			echo "OK";
		else
			echo "ERROR";

	}

	public function esay($opsi, $untuksi)
	{
//		$this->load->Model('M_seting');
		$paket = $this->M_seting->getesay($untuksi);
		$data = array('title' => 'Assesment 3', 'menuaktif' => '15');
		$data['untuksi'] = $untuksi;
		if ($paket) {
			$data['uraian'] = $paket->tanyatxt;
			$data['file'] = $paket->tanyafile;
		}
		else
		{
			$data['uraian'] = "";
			$data['file'] = "";
		}

		if ($opsi == "buat") {

			$data['isi'] = "v_assesment_buatesay";

		} else if ($opsi == "tampilkan") {

			$data['isi'] = "v_assesment_tampilesay";

		}

		$this->load->view('layout/wrapper2', $data);
	}

	public function updateesay($untuksi)
	{
		$tekssoal = $this->input->post('isimateri');
		$data = array();
		$data['tanyatxt'] = $tekssoal;
		if ($this->M_seting->updateesay($data, $untuksi)) {
			echo "sukses";
		} else
			echo "gagal";

	}

	public function kosonginfiletugas()
	{
		$linklist = $this->input->post('linklist');
		$iduser = $this->session->userdata('id_user');
		$cekpaket = $this->M_channel->getpaket($linklist);
		if ($cekpaket[0]->iduser == $iduser) {
			$data = array("tanyafile" => "");
			if ($this->M_channel->updatetugas($data, $linklist))
				echo "sukses";
			else
				echo "gagal";
		} else {
			echo "gagal";
		}
	}

	public function upload_doktugas($untuksi)
	{
		if (isset($_FILES['filedok'])) {
			echo "";
		} else {
			echo "ERROR";
		}

		$config = array(
			'upload_path' => "uploads/assesment/",
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

			if ($untuksi==1)
				$namafilebaru = "esay_1_" .$random. "." . $ext['extension'];
			else if ($untuksi==2)
				$namafilebaru = "esay_2_" .$random. "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			$data = array("tanyafile" => $namafilebaru);
			$this->M_seting->updateesay($data, $untuksi);

			echo "Dokumen OK";

		} else {
			echo $this->upload->display_errors();
		}
	}

	public function download_esay($untuksi)
	{
		$esay = $this->M_seting->getesay($untuksi);
		$esay = $esay->tanyafile;
		echo $esay;
		force_download('uploads/assesment/'.$esay, null);
	}

}

?>
