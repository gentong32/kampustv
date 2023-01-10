<?php

class Assesment extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_induk');
		$this->load->model('M_assesment');
		$this->load->helper(array('Form', 'Cookie', 'String', 'captcha', 'download'));
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->library('pagination');

	}

	public function index()
	{
		if ($this->session->userdata('siae') == 0 && $this->session->userdata('siam') == 0 && $this->session->userdata('bimbel') == 0) {
			redirect('/');
		}

		//redirect("assesment/info");

		$data = array();
		$data['konten'] = 'v_assestment';

		$iduser = $this->session->userdata("id_user");

		$dafnilai = $this->M_assesment->getNilai($iduser);
//		if ($dafnilai[0]->nilaitugas1==null || $dafnilai[0]->nilaitugas2==null)
//		{
//			echo "MASIH KOSONG";
//		}
//
//		echo "<pre>";
//		echo var_dump($dafnilai);
//		echo "</pre>";
//		die();

		if ($dafnilai) {
			$data['dafnilai'] = $dafnilai;
			if ($dafnilai[0]->essaytxt != "" && $dafnilai[0]->nilaitugas1!=null && $dafnilai[0]->nilaitugas2!=null)
				{
					if ($this->session->userdata('siae')==2)
						$type="AE";
					else if ($this->session->userdata('siam')==2)
						$type="AM";
					else if ($this->session->userdata('siag')==2)
						$type="AGENCY";
					else if ($this->session->userdata('bimbel')==2)
						$type="BIMBEL";
					$this->load->Model('M_user');
					$this->M_user->updateKonfirmUser($type);
					redirect("/informasi/tungguhasil");
				}
			//echo "<br><br><br><br><br><br>disini";
		} else {
			$this->M_assesment->createNilai($iduser);
			$data['dafnilai'] = $this->M_assesment->getNilai($iduser);
			//echo "<br><br><br><br><br><br>disana";
		}

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function info()
	{
		$data = array('title' => 'Info', 'menuaktif' => '15',
			'isi' => 'v_assesment_info');

		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper2', $data);
	}

	public function tugas1()
	{
		$this->tugas_ambil(1);
	}

	public function tugas2()
	{
		$this->tugas_ambil(2);
	}

	public function tugas3()
	{
		if (!$this->session->userdata('siae') && !$this->session->userdata('siam') && !$this->session->userdata('bimbel')) {
			redirect('/');
		}

		$data = array();
		$data['konten'] = 'v_assesment_esay';

		if ($this->session->userdata('siae') == 2) {
			$essay = $this->M_assesment->getEssay(1);
		} else if ($this->session->userdata('siam') == 2) {
			$essay = $this->M_assesment->getEssay(2);
		} else if ($this->session->userdata('bimbel') == 2) {
			$essay = $this->M_assesment->getEssay(3);
		} else
			redirect("/");
		$id_user = $this->session->userdata("id_user");
		$jawaban = $this->M_assesment->getNilai($id_user);
		$data['soalessay'] = $essay[0];
		$data['jawabanessay'] = $jawaban;


		$this->load->view('layout/wrapper_umum', $data);

	}

	private function tugas_ambil($opsi)
	{
		if ($this->session->userdata('siae') == 0 && $this->session->userdata('siam') == 0 && $this->session->userdata('bimbel') == 0) {
			redirect('/');
		}

		$iduser = $this->session->userdata("id_user");
		$ceknilai = $this->M_assesment->getNilai($iduser);

		if ($opsi == 1) {
			if ($ceknilai[0]->nilaitugas1 > 0)
				redirect('assesment');
		} else if ($opsi == 2) {
			if ($ceknilai[0]->nilaitugas2 > 0)
				redirect('assesment');
		}

		$data = array();
		$data['konten'] = 'v_assesment_soal';
//		$data['soalkeluar'] = $paketsoal[0]->soalkeluar;
//		$data['acaksoal'] = $paketsoal[0]->acaksoal;

		if ($this->session->userdata('siae') == 2) {
			$tipe = "1" . $opsi;
			$judul = "Assesment Account Executive (Tugas " . $opsi . ")";
		} else if ($this->session->userdata('siam') == 2) {
			$tipe = "2" . $opsi;
			$judul = "Assesment Account Manager (Tugas " . $opsi . ")";
		} else if ($this->session->userdata('bimbel') == 2) {
			$tipe = "3" . $opsi;
			$judul = "Assesment Tutor Bimbel Online (Tugas " . $opsi . ")";
		}

		$data['judul'] = $judul;
		$data['dafsoal'] = $this->M_assesment->getSoal($tipe);
//		echo "<pre>";
//		echo var_dump($data['dafsoal']);
//		echo "</pre>";
//
		if (sizeof($data['dafsoal'])==0)
		{
			if ($this->session->userdata('bimbel') >= 2)
				redirect("/peluangkarir/tutor");
			else if ($this->session->userdata('siae') >= 2)
				redirect("/peluangkarir/account_executive");
			else if ($this->session->userdata('siam') >= 2)
				redirect("/peluangkarir/area_marketing");
		}

		$data['tipe'] = $tipe;
		$data['asal'] = "user";
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function cekjawaban()
	{
		$jawaban_user = $this->input->post('jwbuser');
		$idjawaban_user = $this->input->post('idjwbuser');
		$iduser = $this->session->userdata('id_user');
		$tipe = $this->input->post('tipe');
		$tugaske = substr($tipe, 1, 1);
		$kunci_jawaban = $this->M_assesment->getSoal($tipe);
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
			$data = array('id_user'=>$iduser, 'assesment_ke'=>$tugaske,
				'soal_ke'=>$nomor,'jawaban_user'=>$jawabane);
			$this->M_assesment->insertJawaban($data);
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
		$data['tgltugas' . $tugaske] = $tgl_sekarang->format("Y-m-d H:i:s");
		$update = $this->M_assesment->updateNilai($data, $iduser);
		if ($update)
			echo "OK";
		else
			echo "ERROR";

	}

	public function updatetugasjawab()
	{
		$tekssoal = $this->input->post('isimateri');
		$adafile = $this->input->post('adafile');
		$iduser = $this->session->userdata('id_user');
		$data = array();
		$data['essaytxt'] = $tekssoal;
		$data['essayfile'] = $adafile;
		$tgl_sekarang = new DateTime();
		$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$data['tgltugasessay'] = $tgl_sekarang->format("Y-m-d H-i:s");
//
//		echo "textsoal:".$tekssoal."<br>";
//		echo "---adafile:".$adafile."<br>";

		if ($this->M_assesment->updateNilai($data, $iduser)) {
			$dafnilai = $this->M_assesment->getNilai($iduser);
			if ($dafnilai[0]->essaytxt != "" && $dafnilai[0]->nilaitugas1!=null && $dafnilai[0]->nilaitugas2!=null)
				echo "sukses";
			else
				echo "kurang";
		} else {
			echo "gagal";
		}
	}

	public function upload_file()
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
			$iduser = $this->session->userdata("id_user");

			$namafilebaru = "asses_" . $iduser . "." . $ext['extension'];
			rename($alamat . $namafile1, $alamat . $namafilebaru);

			echo "Dokumen OK";

		} else {
			echo $this->upload->display_errors();
		}
	}

	public function download()
	{
		if ($this->session->userdata('siae') == 2) {
			force_download('uploads/assesment/esaysiae.pdf', null);
		} else if ($this->session->userdata('siam') == 2) {
		force_download('uploads/assesment/esaysiam.pdf', null);
		} else if ($this->session->userdata('bimbel') == 2) {
			force_download('uploads/assesment/esaybimbel.pdf', null);
		}
	}


}
