<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Induk');
		$this->load->helper(array('tanggalan', 'video'));
	}

	public function index()
	{
		setcookie('acara', 0, -1, '/');
		unset($_COOKIE['acara']); 
		setcookie('basis', "home", time() + (86400), '/');
		$datapromo = $this->M_Induk->getPilihanPromo();
		$databerita = $this->M_Induk->getBeritaAll(5);
		$data = array();
		$data['konten'] = "induk";
		$data['datapromo'] = $datapromo;
		$data['databerita'] = $databerita;
		$data['videoterbaru'] = "off";

		$this->load->view('layout/wrapper', $data);
	}


	public function berita($kodeberita)
	{

		$data = array();
		$data['konten'] = "induk_berita";
		$data['datavideo'] = $this->M_Induk->getVideo($kodeberita);

		$data['meta_title'] = $data['datavideo']['judul'];
		$data['meta_description'] = $data['datavideo']['deskripsi'];
		if (substr($data['datavideo']['thumbnail'], 8, 11) == "img.youtube")
			$data['meta_image'] = $data['datavideo']['thumbnail'];
		else
			$data['meta_image'] = base_url()."uploads/thumbs/" . $data['datavideo']['thumbnail'];
		$data['meta_url'] = base_url()."tve/watch/play/" . $kodeberita;

		$id_video = $data['datavideo']['id_berita'];

		$data['dafkomentar'] = $this->M_Induk->getKomentar($id_video);

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function tampil_promo($kdpromo)
	{
		$data = array('title' => 'Promo', 'menuaktif' => '0',
			'isi' => 'v_induk_promo');
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$data['konten_promo'] = $this->M_induk->getPromo($kdpromo);

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function qrcode()
	{
		$this->load->view('qrcode');
	}

}
