<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perwakilan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_umum");
//		$this->load->helper(array('Form', 'Cookie','download'));
	}

	public function index()
	{
		$this->propinsi(null);
	}

	public function account_executive()
	{
		$data = array();
		$data['konten'] = "accountexecutive";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function area_marketing()
	{
		$data = array();
		$data['konten'] = "areamarketing";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function tutor()
	{
		$data = array();
		$data['konten'] = "tutor";

		$this->load->view('layout/wrapper_umum', $data);
	}

	public function propinsi($idpropinsi)
	{
		$data = array();
		$data['konten'] = "perwakilan";
		$data['dafpropinsi'] = $this->M_umum->dafpropinsi(1);
		$data['dafagency'] = $this->M_umum->dafagency($idpropinsi);
		$data['idprop'] = $idpropinsi;

		$this->load->view('layout/wrapper_perwakilan', $data);
	}
}


