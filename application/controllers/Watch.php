<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Watch extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_induk");
		$this->load->helper('video');
		//$this->load->helper('cookie');
		$this->load->helper(array('Form', 'String', 'captcha'));

	}

	public function index()
	{
		//$id = $this->input->post('idvideo');
		$this->load->model('M_vod');
		if ($this->is_connected()) {
			//$this->play_vod(0);
		} else {
			echo "SAMBUNGAN INTERNET TIDAK TERSEDIA";
		}


	}

	public function is_connected($sCheckHost = 'www.google.com')
	{
		return (bool)@fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
	}
 
	public function play($kode_video,$pribadi=null)
	{
		$this->load->model('M_vod');
		$data = array();
		$data['konten'] = "v_vod_play";

		$data['datavideo'] = $this->M_vod->getVideo($kode_video);
		if (!$data['datavideo'])
		{
			redirect("/vod");
		}

		$data['meta_title'] = $data['datavideo']['judul'];
		$data['meta_description'] = $data['datavideo']['deskripsi'];
		if (substr($data['datavideo']['thumbnail'], 8, 11) == "img.youtube")
			$data['meta_image'] = $data['datavideo']['thumbnail'];
		else
			$data['meta_image'] = base_url()."uploads/thumbs/" . $data['datavideo']['thumbnail'];
		$data['meta_url'] = base_url()."watch/play/" . $kode_video;

		$id_video = $data['datavideo']['id_video'];
		//echo $id_video;

		if (($data['datavideo']['status_verifikasi'] == 4 && $data['datavideo']['id_jenis'] == 1) ||
			($data['datavideo']['status_verifikasi'] == 2 && $data['datavideo']['id_jenis'] == 1) ||
			($data['datavideo']['status_verifikasi'] == 2 && $data['datavideo']['id_jenis'] == 2) ||
			($data['datavideo']['status_verifikasi'] == 4 && $data['datavideo']['file_video'] != "") ||
			($data['datavideo']['status_verifikasi'] == 4 && $data['datavideo']['link_video'] != "") ||
			$pribadi!=null) {

			$cookie_name = 'cookie_vod'.$kode_video;
			if (!isset($_COOKIE[$cookie_name]))
			{
				$this->M_vod->updatetonton($id_video);
				setcookie($cookie_name, "ok", time() + (86400), '/');
			}

			$data['dafkomentar'] = $this->M_vod->getKomentar($id_video);
			$this->load->view('layout/wrapper_umum', $data);
		} else {
			redirect('/');
		}


	}

    public function news($kode_video=null,$pribadi=null)
    {
    	if ($kode_video==null)
		{
			redirect("/");
		}
        $this->load->model('M_induk');
        $data = array('title' => 'Playing VOD','menuaktif' => '1',
            'isi' => 'v_vod_play');

        $data['message'] = $this->session->flashdata('message');
        $data['authURL'] = $this->facebook->login_url();
        $data['loginURL'] = $this->google->loginURL();

        $data['datavideo'] = $this->M_induk->getVideo($kode_video);

        $data['meta_title'] = $data['datavideo']['judul'];
        $data['meta_description'] = $data['datavideo']['deskripsi'];
        if (substr($data['datavideo']['thumbnail'], 8, 11) == "img.youtube")
            $data['meta_image'] = $data['datavideo']['thumbnail'];
        else
            $data['meta_image'] = base_url()."uploads/thumbs/" . $data['datavideo']['thumbnail'];
        $data['meta_url'] = base_url()."tve/watch/play/" . $kode_video;

        $id_video = $data['datavideo']['id_berita'];
        //echo $id_video;


            $cookie_name = 'cookie_news'.$kode_video;
            if (!isset($_COOKIE[$cookie_name]))
            {
                $this->M_induk->updatetonton($id_video);
                setcookie($cookie_name, "ok", time() + (86400), '/');
            }

            $data['dafkomentar'] = $this->M_induk->getKomentar($id_video);
            $this->load->view('layout/wrapperinduk2', $data);
//        } else {
//            redirect('/');
//        }


    }

	public function disukai()
	{
		$id_video = $_GET['idvideo'];
		$cookie_name2 = 'cookie_suka'.$id_video;
		if (!isset($_COOKIE[$cookie_name2]))
		{
			setcookie($cookie_name2, "ok", time() + (86400), '/');

			$data['id_user'] = $this->session->userdata('id_user');

			if ($data['id_user'] != null) {
				$data['id_video'] = $id_video;
				$this->load->model('M_vod');
				$this->M_vod->addtbsuka($data);
				$this->ceklevel();
			}
			$this->load->model('M_vod');
			$isi = $this->M_vod->updatesuka($id_video);
			echo json_encode($isi);
		}

	}

	public function dishare()
	{
		$data['id_user'] = $this->session->userdata('id_user');
		$data['id_video'] = $_GET['idvideo'];
		$data['id_web'] = $_GET['idweb'];
		$this->load->model('M_vod');
		$isi = $this->M_vod->addshare($data);
		$this->ceklevel();
		echo json_encode($isi);
	}

	public function kirimkomen()
	{
		$data['id_video'] = $this->input->post('idvideo');
		$data['id_parent'] = $this->input->post('idparent');
		$data['id_user'] = $this->session->userdata('id_user');
		$tekskomen = $this->input->post('textkomen');

		function stripHTMLtags($str)
		{
			$t = preg_replace('/<[^<|>]+/', '', htmlspecialchars_decode($str));
			$t = htmlentities($t, ENT_QUOTES, "UTF-8");
			return $t;
		}

		$data['komentar'] = stripHTMLtags($tekskomen);

		$this->load->model('M_vod');
		$this->M_vod->addkomen($data);
		$isi = $this->M_vod->getKomentar($data['id_video']);
		$this->ceklevel();
		echo json_encode($isi);
	}

	public function ceklevel()
	{
		$this->load->model('M_login');
		$jmllike = $this->M_login->hitunglike($this->session->userdata('id_user'));
		$jmlkomen = $this->M_login->hitungkomen($this->session->userdata('id_user'));
		$jmlshare = $this->M_login->hitungshare($this->session->userdata('id_user'));

		if ($this->session->userdata('level') == 0) {
			if ($jmllike >= 10 && $jmlkomen >= 10 && $jmlshare >= 10) {
				$this->M_login->updateLevel($this->session->userdata('id_user'), 1);
			}
		}
	}

}
