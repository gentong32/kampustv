<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_induk_asli extends CI_Model {

    public function __construct()	{
        $this->load->database();
    }

    public function getAllPromo(){
        $this->db->from('tb_promo');
        $this->db->order_by('created', 'desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getPilihanPromo(){
        $this->db->from('tb_promo');
        $this->db->where('(pilihan>0)');
        $this->db->order_by('pilihan', 'asc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getPromo($kodepromo){
        $this->db->from('tb_promo');
        $this->db->where('kd_promo',$kodepromo);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function updatepromo($data, $idpromo){
        $now = new DateTime();
        $now->setTimezone(new DateTimezone('Asia/Jakarta'));
        $tglsekarang = $now->format('Y-m-d H:i:s');
        $data['modified'] = $tglsekarang;

        $this->db->where('id', $idpromo);
        $this->db->update('tb_promo', $data);
    }

    public function addpromo($data){
        $data['kd_promo'] = base_convert(microtime(false), 10, 36);
        $this->db->insert('tb_promo', $data);
        $insertid = $this->db->insert_id();

        $random = rand(100,999);
        $data2['gambar'] = "img_".$random.'_'.$insertid.'.jpg';
		$data2['gambar2'] = "img2_".$random.'_'.$insertid.'.jpg';
        if ($data['nama_file']!="")
            $data2['nama_file'] = "dok_".$random.'_'.$insertid.'.pdf';
        $this->db->where('id', $insertid);
        $this->db->update('tb_promo', $data2);
        rename('uploads/promo/dok0.pdf','uploads/promo/dok_'.$random.'_'.$insertid.'.pdf');
        rename('uploads/promo/image0.jpg','uploads/promo/img_'.$random.'_'.$insertid.'.jpg');
		rename('uploads/promo/image1.jpg','uploads/promo/img2_'.$random.'_'.$insertid.'.jpg');
    }

    public function delpromo($kodepromo)
    {
        $this->db->where('kd_promo', $kodepromo);
        $this->db->delete('tb_promo');
    }

    public function updatefoto($namafile, $idpromo){
        $data = array(
            'gambar' => $namafile
        );
        $this->db->where('id', $idpromo);
        $this->db->update('tb_promo', $data);
    }

	public function updatefoto2($namafile, $idpromo){
		$data = array(
			'gambar2' => $namafile
		);
		$this->db->where('id', $idpromo);
		$this->db->update('tb_promo', $data);
	}

    public function updatedok($namafile, $idpromo){
        $data = array(
            'nama_file' => $namafile
        );
        $this->db->where('id', $idpromo);
        $this->db->update('tb_promo', $data);
    }

    public function getBeritaAll($limit=null){
        $this->db->from('tb_berita');
        if ($limit!=null)
            $this->db->limit($limit);
        $this->db->order_by('modified','desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getVideo($id_video){
        $this->db->select('tv.id_berita AS id_video,tv.kode_berita AS kode_video,tv.*');
        $this->db->from('tb_berita tv');
        $this->db->where('kode_berita', $id_video);
        $result = $this->db->get()->row_array();
        return $result;
    }

    function editVideo($data, $idberita)
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimezone('Asia/Jakarta'));
        $tglsekarang = $now->format('Y-m-d H:i:s');
        $data['modified'] = $tglsekarang;

        $this->db->where('id_berita', $idberita);
        return $this->db->update('tb_berita', $data);
    }

    public function delsafevideo($id_video)
    {
        $this->db->where('id_berita', $id_video);
        $this->db->delete('tb_berita');
    }

    function addVideo($data)
    {
        $this->db->insert('tb_berita', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function updatetonton($idvideo)
    {
        $this->db->where('id_berita', $idvideo);
        $this->db->set('ditonton','`ditonton`+1' , FALSE);
        $this->db->update('tb_berita');
    }

    public function updatesuka($idvideo)
    {
        $this->db->where('id_berita', $idvideo);
        $this->db->set('disukai','`disukai`+1' , FALSE);
        $this->db->update('tb_berita');
        $this->db->select('disukai');
        $this->db->where('id_berita', $idvideo);
        $this->db->from('tb_berita');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getKomentar($id_video){
        $this->db->select('tk.*,first_name');
        $this->db->from('tb_komentar tk');
        $this->db->join('tb_user tu', 'tu.id = tk.id_user','left');
        $this->db->where('id_video', $id_video);
        $this->db->order_by('id_parent','asc');
        $this->db->order_by('created','desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function get_url_live(){
        $this->db->from('tb_live');
        $result = $this->db->get()->row();
        return $result;
    }

    public function updateurl_live($data)
    {
        $this->db->where('id', 1);
        $this->db->update('tb_live',$data);
    }

	public function updateliveseting($data)
	{
		$this->db->where('harike', 0);
		$this->db->update('tb_live_acara',$data);
	}

    public function get_acara_live($harike=null){
    	if ($harike!=null)
        $this->db->where('harike', $harike);
        $this->db->from('tb_live_acara');
        $result = $this->db->get()->result();
        return $result;
    }

	public function getAllEvent($kode=null,$status=null)
	{
		$this->db->from('tb_event');
		if ($kode!=null)
		{
			$this->db->where('link_event', $kode);
		}
		if ($status!=null)
		{
			$this->db->where('status', $status);
		}
		$this->db->order_by("tgl_mulai", "desc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllUmumAktif()
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d');

		$this->db->from('tb_pengumuman tp');
		$this->db->where('status', 1);
		$this->db->where('(tgl_mulai<="'.$tglsekarang.'")');
		$this->db->where('(tgl_selesai>="'.$tglsekarang.'")');
		$this->db->order_by("tgl_mulai", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getbyCodeEvent($kode)
	{
		$this->db->from('tb_pengumuman');
		$this->db->where('code_pengumuman',$kode);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllPengumuman($kode=null,$status=null)
	{
		$this->db->from('tb_pengumuman');
		if ($kode!=null)
		{
			$this->db->where('link_pengumuman', $kode);
		}
		if ($status!=null)
		{
			$this->db->where('status', $status);
		}
		$this->db->order_by("tgl_mulai", "desc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getbyCodePengumuman($kode)
	{
		$this->db->from('tb_pengumuman tp');
		$this->db->where('tp.code_pengumuman',$kode);
		$result = $this->db->get()->result();
		return $result;
	}

	public function addpengumuman($data){
		$this->db->insert('tb_pengumuman', $data);
		$insertid = $this->db->insert_id();
	}

	public function updatepengumuman($data, $code){
//		$now = new DateTime();
//		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
//		$tglsekarang = $now->format('Y-m-d H:i:s');
//		$data['modified'] = $tglsekarang;

		$this->db->where('code_pengumuman', $code);
		$this->db->update('tb_pengumuman', $data);
	}

	public function delpengumuman($kodeevent)
	{
		$this->db->where('code_pengumuman', $kodeevent);
		$this->db->delete('tb_pengumuman');
	}
}
