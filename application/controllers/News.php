<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_induk');
        $this->load->helper(array('Form', 'Cookie', 'url', 'download'));
    }

    public function index()
    {
        if ($this->session->userdata('a01')) {
            $data = array('title' => 'Daftar Berita', 'menuaktif' => '21',
                'isi' => 'v_news');

            $data['dafberita'] = $this->M_induk->getBeritaAll();

            $this->load->view('layout/wrapperinduk2', $data);
        } else {
            redirect('/', '_self');
        }
    }

    public function tambah()
    {
        $data = array('title' => 'Tambahkan Video Berita', 'menuaktif' => '3',
            'isi' => 'v_news_tambah');
        $data['addedit'] = "add";
//        $data['dafkategori'] = $this->M_video->getAllKategori();
        $data['datavideo'] = Array('dilist' => 1);
        $data['idberita'] = 0;
        $data['namafile'] = "";

        $this->load->view('layout/wrapper', $data);
    }

    public function tayang($idx)
    {
        $data = array('title' => 'Tambahkan Video', 'menuaktif' => '3',
            'isi' => 'v_news_tambah');
        $data['addedit'] = "add";
//        $data['dafkategori'] = $this->M_video->getAllKategori();
        $data['datavideo'] = Array('dilist' => 1);
        $data['idberita'] = 0;
        $data['namafile'] = "";

        $this->load->view('layout/wrapper', $data);
    }

    public function edit($id_video)
    {
        $data = array('title' => 'Edit Video', 'menuaktif' => '21',
            'isi' => 'v_news_tambah');

        $data['addedit'] = "edit";
        $data['datavideo'] = $this->M_induk->getVideo($id_video);
        $data['idberita'] = 0;
        $data['namafile'] = "";
        $this->load->view('layout/wrapper', $data);
    }

    public function hapus($id_video)
    {
        $this->M_induk->delsafevideo($id_video);
        redirect('/news', '_self');
    }


    public function getVideoInfo($vidkey)
    {
        $apikey = "AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU";
        $dur = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails,snippet&id=$vidkey&key=$apikey");
        $VidDuration = json_decode($dur, true);
        foreach ($VidDuration['items'] as $vidTime) {
            $VidDuration = $vidTime['contentDetails']['duration'];
//			$channel = $vidTime['snippet']['channelId'];
//			//$dur = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails,snippet&id=$vidkey&key=$apikey");
//			//$datayt = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails,statistics&mine=true&access_token=smohLqUHcpdkt9RKauZ8zOJNieyIQjxw");
//			//$daty = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=brandingSettings&mine=true&key=AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU");
//			$daty = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=id%2Csnippet%2Cstatistics%2CcontentDetails%2CtopicDetails&id=".$channel."&key=AIzaSyCytrDv72V-mQmXwIteXq50hZdK_EgmoFU");
//			echo $channel.'<br>';
//			echo $daty;
//			die();
            preg_match_all('/(\d+)/', $VidDuration, $parts);
//            echo "UKURAN:".$uk_wkt;
            if ($VidDuration == "P0D") {
                $totalSec = "00:00:00";
            } else {
                $uk_wkt = sizeof($parts[0]);
                $hours = 0;
                $minutes = 0;
                $seconds = 0;

                if ($uk_wkt == 3) {
                    $hours = intval(floor($parts[0][0]));
                    $minutes = intval($parts[0][1]);
                    $seconds = intval($parts[0][2]);
                } else if ($uk_wkt == 2) {
                    $minutes = intval($parts[0][0]);
                    $seconds = intval($parts[0][1]);
                } else if ($uk_wkt == 1) {
                    $seconds = intval($parts[0][0]);
                }


                if ($hours < 10) {
                    $hours = "0" . $hours;
                }
                if ($minutes < 10) {
                    $minutes = "0" . $minutes;
                }
                if ($seconds < 10) {
                    $seconds = "0" . $seconds;

                    //$totalSec = $hours + $minutes + $seconds;
                }
                $totalSec = $hours . ':' . $minutes . ':' . $seconds;
            }

            echo $totalSec;
            return $totalSec;
//           echo $VidDuration;
//           return $VidDuration;
        }

    }


    public function addvideo()
    {

        if ($this->input->post('ijudul') == null) {
            redirect('news');
        }

        $data['id_kategori'] = $this->input->post('ikategori');
        $data['judul'] = $this->input->post('ijudul');
        $data['deskripsi'] = $this->input->post('ideskripsi');
        $data['keyword'] = $this->input->post('ikeyword');
        $data['link_video'] = $this->input->post('ilink');
        $data['durasi'] = $this->input->post('idurjam') . ':' . $this->input->post('idurmenit') . ':' . $this->input->post('idurdetik');

        if ($this->input->post('addedit') == "add") {

            if ($data['link_video'] != "") {
                $data['durasi'] = $data['durasi']; //$this->input->post('ytube_duration');
                $data['thumbnail'] = $this->input->post('ytube_thumbnail');
                $data['id_youtube'] = $this->input->post('idyoutube');
            }
            $data['kode_berita'] = base_convert(microtime(false), 10, 36);
        } else {
            //$data['kode_video'] = base_convert($this->input->post('created'),10,16);
        }

        if ($this->input->post('addedit') == "add") {
            $idbaru = $this->M_induk->addVideo($data);
            redirect('news');
            //redirect('video/edit/'.$idbaru);
        } else {
            $this->M_induk->editVideo($data, $this->input->post('id_berita'));
            redirect('news');
        }
    }

}
