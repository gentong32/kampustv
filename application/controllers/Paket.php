<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_channel");
		$this->load->model("M_induk");
		$this->load->helper(array('Form', 'Cookie', 'String', 'captcha', 'download'));
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');

		if (!$this->session->userdata('loggedIn')) {
			redirect(base_url());
		}

	}

	public function index()
	{
		$this->paketsaya();
	}

	public function paketsaya()
	{
		$data = array('title' => 'Uraian Materi', 'menuaktif' => '15',
			'isi' => 'v_paket');

		$id_user = $this->session->userdata("id_user");
		$jenis = 1;
		//$this->load->model('M_channel');
		$kodebeli = $this->M_channel->getlast_kdbeli($id_user,$jenis);
//		if($kodebeli)
//			echo "<br><br><br><br><br>ketemu:".$kodebeli->kode_beli;
//		else
//			echo "gak_ketemu";
		$data['dafpaket'] = $this->M_channel->get_VK_sekolah_saya($id_user,$kodebeli->kode_beli);
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();

		$this->load->view('layout/wrapper', $data);
	}

}
