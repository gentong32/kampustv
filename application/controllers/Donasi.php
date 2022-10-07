<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donasi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('Form', 'Cookie','download'));
	}

	public function index()
	{
		$data = array();
		$data['konten'] = "donasi";
		$this->load->view('layout/wrapper_umum', $data);
	}

}


