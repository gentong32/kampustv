<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_induk');
		$this->load->helper(array('Form', 'Cookie', 'url', 'download'));
	}

	public function index()
	{
		$data = array('title' => 'Daftar Promo','menuaktif' => '21',
			'isi' => 'v_promo');

		$data['dafpromo'] = $this->M_induk->getAllPromo();

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function tambah()
	{
        if (!$this->session->userdata('a01') && $this->session->userdata('sebagai')!=4)
            redirect('/home');
		$data = array('title' => 'Tambahkan Promo','menuaktif' => '21',
			'isi' => 'v_promo_tambah');
		$data['addedit'] = "add";

		$this->load->model('M_video');
		$data['dafevent'] = $this->M_video->getAllEvent(null,1);

		$this->load->view('layout/wrapperinduk2', $data);
	}

	public function edit($kdpromo)
	{
	    if (!$this->session->userdata('a01') && $this->session->userdata('sebagai')!=4)
	        redirect('/home');
		$data = array('title' => 'Edit Promo','menuaktif' => '21',
			'isi' => 'v_promo_tambah');

		$data['addedit'] = "edit";
		$data['dafpromo'] = $this->M_induk->getPromo($kdpromo);
		$this->load->model('M_video');
		$data['dafevent'] = $this->M_video->getAllEvent(null,1);
		$this->load->view('layout/wrapperinduk2', $data);
	}

    public function upload_foto_promo($idpromo)
    {
        if (!$this->session->userdata('a01')) {
            redirect('/home');
        }
        //$idpromo = $_POST['idpromo'];
        $random = rand(100,999);
        if (isset($_FILES['file']))
        {
            echo "";
        }
        else
        {
            echo "ERROR";
        }

        $path1 = "promo/";
        $allow = "jpg|jpeg|png";

        $config = array(
            'upload_path' => "uploads/" . $path1,
            'allowed_types' => $allow,
            'overwrite' => TRUE,
            'max_size' => "204800000",
            //'max_height' => "768",
            //'max_width' => "1024"
        );

        $this->load->library('upload', $config);
        if ($this->upload->do_upload("file")) {

            $dataupload = array('upload_data' => $this->upload->data());

            $namafile1 = $dataupload['upload_data']['file_name'];
            $namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
            $namafile = preg_replace('/-+/', '-', $namafile);
            $ext = pathinfo($namafile);

            $alamat = $config['upload_path'];

            $namafilebaru = "img_" . $random . "_" .$idpromo. ".". $ext['extension'];

            $this->M_induk->updatefoto($namafilebaru, $idpromo);

            if ($idpromo>0)
            {
                rename($alamat . $namafile1, $alamat . $namafilebaru);
                echo "Foto berhasil diubah";
            }
            else
            {
                rename($alamat . $namafile1, $alamat.'image0.jpg');
                echo "Foto siap digunakan";
            }


            //$this->tambah($dataupload['upload_data']['file_name']);
        } else {

            echo $this->upload->display_errors();
        }
    }

	public function upload_foto_promob($idpromo)
	{
		if (!$this->session->userdata('a01')) {
			redirect('/home');
		}
		//$idpromo = $_POST['idpromo'];
		$random = rand(100,999);
		if (isset($_FILES['file']))
		{
			echo "";
		}
		else
		{
			echo "ERROR";
		}

		$path1 = "promo/";
		$allow = "jpg|jpeg|png";

		$config = array(
			'upload_path' => "uploads/" . $path1,
			'allowed_types' => $allow,
			'overwrite' => TRUE,
			'max_size' => "204800000",
			//'max_height' => "768",
			//'max_width' => "1024"
		);

		$this->load->library('upload', $config);
		if ($this->upload->do_upload("file")) {

			$dataupload = array('upload_data' => $this->upload->data());

			$namafile1 = $dataupload['upload_data']['file_name'];
			$namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
			$namafile = preg_replace('/-+/', '-', $namafile);
			$ext = pathinfo($namafile);

			$alamat = $config['upload_path'];

			$namafilebaru = "img_" . $random . "_" .$idpromo. ".". $ext['extension'];

			$this->M_induk->updatefoto2($namafilebaru, $idpromo);

			if ($idpromo>0)
			{
				rename($alamat . $namafile1, $alamat . $namafilebaru);
				echo "Foto berhasil diubah";
			}
			else
			{
				rename($alamat . $namafile1, $alamat.'image1.jpg');
				echo "Foto siap digunakan";
			}


			//$this->tambah($dataupload['upload_data']['file_name']);
		} else {

			echo $this->upload->display_errors();
		}
	}

    public function upload_dok($idpromo)
    {
        if (!$this->session->userdata('a01')) {
            redirect('/home');
        }
        //$idpromo = $_POST['idpromo'];
        $random = rand(100,999);

        if (isset($_FILES['file']))
        {
            echo "";
        }
        else
        {
            echo "ERROR";
        }

        $path1 = "promo/";
        $allow = "pdf";

        $config = array(
            'upload_path' => "uploads/" . $path1,
            'allowed_types' => $allow,
            'overwrite' => TRUE,
            'max_size' => "204800000",

            //'max_height' => "768",
            //'max_width' => "1024"
        );

        $this->load->library('upload', $config);
        if ($this->upload->do_upload("file")) {

            $dataupload = array('upload_data' => $this->upload->data());

            $namafile1 = $dataupload['upload_data']['file_name'];
            $namafile = preg_replace('/[^A-Za-z0-9.\-]/', '', $namafile1);
            $namafile = preg_replace('/-+/', '-', $namafile);
            $ext = pathinfo($namafile);

            $alamat = $config['upload_path'];

            $namafilebaru = "dok_" . $random . "_" .$idpromo. ".". $ext['extension'];

            $this->M_induk->updatedok($namafilebaru, $idpromo);

            if ($idpromo>0)
            {
                rename($alamat . $namafile1, $alamat . $namafilebaru);
                echo "Dokumen OK";
            }
            else
            {
                rename($alamat . $namafile1, $alamat.'dok0.pdf');
                echo "Dokumen siap";
            }

            //$this->tambah($dataupload['upload_data']['file_name']);
        } else {

            echo $this->upload->display_errors();
        }
    }

    public function updatepromo($idpromo)
    {
        if (!$this->session->userdata('a01') && $this->session->userdata('sebagai')!=4) {
            redirect('/home');
        }

        $addedit = $this->input->post('addedit');
        $data['judul'] = $this->input->post('ijudul');
//        $data['subjudul'] = $this->input->post('isubjudul');
        $data['isipromo'] = $this->input->post('iisipromo');
        $ceklink = $this->input->post('adalink');
        if ($ceklink==0)
			$data['link'] = "";
        else {
			$alamatlink = $this->input->post('linkevent');
			if ($alamatlink=="")
				$data['link'] = "";
			else
				$data['link'] = $alamatlink;
		}

        if ($this->input->post('adafile')==0)
            $data['nama_file'] = "";

        //$data['pilihan'] = $this->input->post('pilihan');
        //$data['subjudul'] = 'ch' . base_convert(microtime(false), 10, 36);

        if ($addedit=='edit')
        {
            $this->M_induk->updatepromo($data,$idpromo);
        }
        else
        {
            $this->M_induk->addpromo($data);

        }

            //echo "INI DITAMBAH ";

//        echo $data['ada_file'];


        redirect('/promo');
    }

    public function hapus($idpromo)
    {
        if (!$this->session->userdata('a01')) {
            redirect('/home');
        }
        $this->M_induk->delpromo($idpromo);
        redirect('/promo');
    }

    public function di_download($kodepromo){
        $datapromo = $this->M_induk->getPromo($kodepromo);
        force_download('uploads/promo/'.$datapromo['nama_file'],NULL);
    }

    public function updateuruttayang() {
	    $idpromo = $this->input->post('idpromo');
        $urutan = $this->input->post('urutan');

        $data['pilihan'] = $urutan;
        $id = $this->M_induk->updatepromo($data,$idpromo);

    }

	
}
