<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Mlearning extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
		$this->load->library('google');
		$this->load->library('facebook');
		$this->load->library('encrypt');
		$this->load->helper(array('Form', 'Cookie'));
        
    }
 
    public function index()
    {
        setcookie('basis', "festival", time() + (86400), '/');
        if ($this->session->userdata('loggedIn')) {
            if ($this->session->userdata('activate') == 0)
                redirect('/login/profile');
            else
                $this->showinfo();
        }
        else
        {
            $this->showinfo();
        }
    }


    public function showinfo()
    {
        $data = array('title' => 'Kelas Virtual','menuaktif' => '4',
						'isi' => 'v_mlearning');
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
						
        $this->load->view('layout/wrapper3',$data);
        
    }

}
