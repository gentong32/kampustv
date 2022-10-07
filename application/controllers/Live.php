<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Live extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_induk');
        $this->load->library('google');
        $this->load->library('facebook');
        $this->load->library('encrypt');
        $this->load->library('email');
        $this->load->helper(array('Form', 'Cookie', 'String', 'captcha'));
    }

    public function index()
    {
        $this->panggil_live();
    }

    public function is_connected($sCheckHost = 'www.google.com')
    {
        return (bool)@fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
    }

    public function panggil_live()
    {
        setcookie('basis', "live", time() + (86400), '/');
        $data = array();
        $data['konten'] = 'v_live';

        //$data['daf_promo'] = $this->M_induk->getPilihanPromo();
        $data['url_live'] = $this->M_induk->get_url_live();
        date_default_timezone_set('Asia/Jakarta');
        $now = new DateTime();
        $harike = date_format($now, 'N');
        $data['harike'] = $harike;
        $data['jadwal_acara'] = $this->M_induk->get_acara_live();
		$data['dafacara'] = $this->M_induk->get_acara_live();
        $this->load->view('layout/wrapper_umum', $data);
    }

}
