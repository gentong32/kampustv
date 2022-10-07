<?php
class Blog extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('M_vod');
		error_reporting(0);
	}

	function index(){
		$this->load->view('blog_view');
	}

	public function get_autocomplete(){
		if (isset($_GET['term']))
		{
		  	$result = $this->M_vod->search_VOD($_GET['term']);
		   	if (count($result) > 0) {
		    foreach ($result as $row)
		     	$arr_result[] = array(
					"value"	=> $row->judul,
					"deskripsi"	=> $row->deskripsi
				);
		     	echo json_encode($arr_result);
		   	}
		}
	}

}
