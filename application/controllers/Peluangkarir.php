<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peluangkarir extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('Form', 'Cookie','download', 'statusverifikator'));
	}

	public function index()
	{
		$data = array();
		$data['konten'] = "peluangkarir";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function account_executive()
	{
		$data = array();
		$data['konten'] = "accountexecutive";
		if ($this->session->userdata('siae')==2)
			redirect("/assesment");

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function area_marketing()
	{
		$data = array();
		$data['konten'] = "areamarketing";
		if ($this->session->userdata('siam')==2)
			redirect("/assesment");

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function tutor()
	{
		getstatususer();
		$data = array();
		$data['konten'] = "tutor";
		$this->load->Model('M_assesment');
		$iduser = $this->session->userdata("id_user");
		$dafnilai = $this->M_assesment->getNilai($iduser);
		$data['sudahtes'] = "belum";
		if($dafnilai) {
			if ($dafnilai[0]->essaytxt != "" && $dafnilai[0]->nilaitugas1 != null && $dafnilai[0]->nilaitugas2 != null)
				$data['sudahtes'] = "sudah";
		}
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function agency()
	{
		$data = array();
		$data['konten'] = "agency";

		$this->load->view('layout/wrapper_umum', $data);
	}
}


