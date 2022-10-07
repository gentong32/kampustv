<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Home2 extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
       //echo $this->session->userdata('loggedIn').$this->session->userdata('tukang_verifikasi').$this->session->userdata('tukang_kontribusi');
        if (! $this->session->userdata('loggedIn') || $this->session->userdata('tukang_verifikasi')>2 
		|| $this->session->userdata('tukang_kontribusi')>2) {
            redirect('login/lengkapiprofil');
        }
    }
 
    public function index() {
        $data = array('title' => 'Home2',
                      'isi' => 'v_home');
        //$data['userData']=$this->session->userdata('userData');
        $this->load->view('layout/wrapper', $data);
	}

}

?>

<script type="text/javascript">
if (window.location.hash === "#_=_"){
    history.replaceState 
        ? history.replaceState(null, null, window.location.href.split("#")[0])
        : window.location.hash = "";
}

</script>