<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Festival extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
		$this->load->model("M_induk");
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
        $data = array('title' => 'Festival TV','menuaktif' => '4',
						'isi' => 'v_festival');
		$data['message'] = $this->session->flashdata('message');
		$data['authURL'] = $this->facebook->login_url();
		$data['loginURL'] = $this->google->loginURL();
						
        $this->load->view('layout/wrapper3',$data);
        
    }

}
