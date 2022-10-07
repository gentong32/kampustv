<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tutor extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_induk");
		$this->load->model("M_login");
		$this->load->model("M_tutor");
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->helper('tanggalan');
		$this->load->library('pagination');
		if (!$this->session->userdata('loggedIn')) {
			redirect('/');
		}
		if ($this->session->userdata('a01') || $this->session->userdata('bimbel') > 0
			|| ($this->session->userdata('a02') && $this->session->userdata('sebagai')!=4)
			|| ($this->session->userdata('a03') && $this->session->userdata('sebagai')==1)) {
			//
		} else {
			redirect('/');
		}

		$this->load->helper(array('Form', 'Cookie', 'download'));
	}

	public function index()
	{
		$this->transaksi();
	}

	public function transaksi()
	{
		if ($this->session->userdata('sebagai')==1 && ($this->session->userdata('verifikator')==3
				|| $this->session->userdata('bimbel')==3)) {
			$data = array();
			$data['konten'] = 'v_tutor_transaksi';
			$idtutor = $this->session->userdata('id_user');
			$this->load->model("M_login");
			$data['getuserdata'] = $this->M_login->getUser($idtutor);
			$data['daftransaksi'] = $this->M_tutor->getTransaksi($idtutor);
			$this->load->view('layout/wrapper_tabel_payment', $data);
		}
		else
		{
			redirect("/");
		}
	}

	public function transaksi_verifikator()
	{
		if ($this->session->userdata('bimbel')==4) {
		$data = array();
		$data['konten'] = 'v_tutor_transaksi_verifikator';

		$idtutor = $this->session->userdata('id_user');
		$this->load->model("M_login");
		$data['getuserdata'] = $this->M_login->getUser($idtutor);
		$data['daftransaksi'] = $this->M_tutor->getTransaksiVerifikator($idtutor);
		$this->load->view('layout/wrapper_payment', $data);
		}
		else
		{
			redirect("/");
		}
	}

}
