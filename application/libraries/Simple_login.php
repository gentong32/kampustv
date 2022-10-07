<?php if(! defined('BASEPATH')) exit('Akses langsung tidak diperbolehkan');

class Simple_login {
    // SET SUPER GLOBAL
    var $CI = NULL;
    public function __construct() {
        $this->CI =& get_instance();
    }
    // Fungsi login
    public function login($username, $password) {
        $query = $this->CI->db->get_where('user',array('username'=>$username,'password' => md5($password)));
        if($query->num_rows() == 1) {
            $row = $this->CI->db->query('SELECT * FROM user where username = "'.$username.'"');
            $admin = $row->row();
            $id = $admin->id_user;
            $level = $admin->level;
			$koord_lib = $admin->koord_lib;
			$koord_prev = $admin->koord_prev;
			$koord_imp = $admin->koord_imp;
			$koord_eval = $admin->koord_eval;
            $kduser = $admin->kdUser;
			$telegramid = $admin->telegram_id;
            $this->CI->session->set_userdata('username', $username);
            $this->CI->session->set_userdata('id_login', uniqid(rand()));
            $this->CI->session->set_userdata('id', $id);
            $this->CI->session->set_userdata('level', $level);
			$this->CI->session->set_userdata('menuke', 0);
			$this->CI->session->set_userdata('koord_lib', $agt_qc);
			$this->CI->session->set_userdata('koord_prev', $koord_prev);
			$this->CI->session->set_userdata('koord_imp', $koord_imp);
			$this->CI->session->set_userdata('koord_eval', $koord_eval);
            $this->CI->session->set_userdata('kduser', $kduser);
			$this->CI->session->set_userdata('telegram_id', $telegramid);
            redirect(base_url('dasborutama'));
        }else{
            $this->CI->session->set_flashdata('sukses','Oops... Username/password salah');
            redirect(base_url('login'));
        }
        return false;
    }
    // Proteksi halaman
    public function cek_login() {
        if($this->CI->session->userdata('username') == '') {
            $this->CI->session->set_flashdata('sukses','Anda belum login');
            redirect(base_url('login'));
        }
    }
    // Fungsi logout
    public function logout() {
        $this->CI->session->unset_userdata('username');
        $this->CI->session->unset_userdata('id_login');
        $this->CI->session->unset_userdata('id');
		$this->CI->session->unset_userdata('menuke');
        $this->CI->session->unset_userdata('level');
		$this->CI->session->unset_userdata('agt_qc');
		$this->CI->session->unset_userdata('agt_prv');
		$this->CI->session->unset_userdata('admin_kikd');
        $this->CI->session->unset_userdata('kduser');
		$this->CI->session->unset_userdata('telegram_id');
        $this->CI->session->set_flashdata('sukses','Anda berhasil logout');
        redirect(base_url('login'));
    }
}
