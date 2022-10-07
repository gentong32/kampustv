<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tentangkami extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('Form', 'Cookie','download'));
	}

	public function index()
	{
		$data = array();
		$data['konten'] = "tentangkami";
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function hubungi_kami()
	{
		$data = array();
		$data['konten'] = "hubungikami";
		$this->load->view('layout/wrapper_umum', $data);
	}

	public function kebijakan()
	{
		$data = array();
		$data['konten'] = "kebijakan";
		$this->load->view('layout/wrapper_umum', $data);
	}
}


