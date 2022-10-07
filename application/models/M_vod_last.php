<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_vod extends CI_Model {

    public function __construct()	{
        $this->load->database();
    }

    public function getVODAll($idjenjang=null){
        $this->db->select('tv.*,first_name');
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
        $this->db->where('(tv.durasi<>"")');
        $this->db->where('((status_verifikasi=4 AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!="") OR (status_verifikasi=4 AND link_video!=""))');
        if ($idjenjang!=null)
        {
            $this->db->where('id_jenjang', $idjenjang);
            $this->db->limit(5);
        }
        $this->db->order_by('modified','desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getVODMapel($namajenjang,$idmapel,$limit=null,$start=null){
        $this->db->select('tv.*,first_name');
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
        $this->db->join('daf_jenjang dj', 'dj.id = tv.id_jenjang','left');
        $this->db->where('(tv.durasi<>"")');
        $this->db->where('((status_verifikasi=4 AND id_jenis=1) OR ((status_verifikasi=2 OR status_verifikasi=4) AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!=""))');
        if ($idmapel==0)
        $this->db->where('(nama_pendek="'.$namajenjang.'")');
        else
        $this->db->where('(id_mapel='.$idmapel.')');
        if ($limit!=null)
        {
            $this->db->limit($limit,$start);
        }
        $this->db->order_by('modified','desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getVODKategori($idkategori=null,$limit=null,$start=null){
        $this->db->select('tv.*,first_name');
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
        $this->db->where('(tv.durasi<>"")');
        $this->db->where('((status_verifikasi=4 AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!=""))');

        if ($idkategori!=null)
        {
            $this->db->where('(id_kategori='.$idkategori.')');
        }

        $this->db->order_by('modified','desc');
        if ($limit!=null)
        {
            $this->db->limit($limit,$start);
        }
        else
        {
            $this->db->limit($limit,$start);
        }

        $result = $this->db->get()->result();
        return $result;
    }

    public function getJenjangAll(){
        $this->db->from('daf_jenjang');
		$this->db->where('(urutan>0)');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getKategoriAll(){
        $this->db->from('daf_kategori');
        $result = $this->db->get()->result();
        return $result;
    }
    

    public function cekJenjangMapel($idmapel=null){
        $this->db->select('*');
        $this->db->from('daf_mapel');
        $this->db->where('id', $idmapel);
        $result = $this->db->get()->result();
        return $result;
    }

    public function cekJenjangPendek($namapendek){
        $this->db->select('*');
        $this->db->from('daf_jenjang');
        $this->db->where('nama_pendek', $namapendek);
        $result = $this->db->get()->result();
        return $result;
    }

    public function dafMapel($namapendek){
        $this->db->select('id');
        $this->db->from('daf_jenjang');
        $this->db->where('nama_pendek', $namapendek);
        $idjenjang = $this->db->get()->result_array();
        $idjenjang = $idjenjang[0]['id'];

        $this->db->select('*');
        $this->db->from('daf_mapel');
        $this->db->where('id_jenjang', $idjenjang);
        $result = $this->db->get()->result();
        return $result;
    }

    public function getDataPerJenjang(){
        $this->db->select('nama_pendek,COUNT(*) as jml_video');
        $this->db->from('tb_video tv');
        $this->db->join('daf_jenjang dj', 'dj.id = tv.id_jenjang','left');
        $this->db->group_by('nama_pendek');
        $this->db->where('(tv.durasi<>"")');
        $this->db->where('((status_verifikasi=4 AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) OR (status_verifikasi=4 AND !file_video=""))');
        $result = $this->db->get()->result();
       
        
        return $result;
    }

    public function getDataPerKategori(){
        $this->db->select('nama_kategori,COUNT(*) as jml_video');
        $this->db->from('tb_video tv');
        $this->db->join('daf_kategori dj', 'dj.id = tv.id_kategori','left');
        $this->db->group_by('nama_kategori');
        $this->db->where('(tv.durasi<>"")');
        $this->db->where('((status_verifikasi=4 AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!=""))');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getVideo($id_video){
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
		$this->db->where('kode_video', $id_video);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function updatetonton($idvideo)
	{
        $this->db->where('id_video', $idvideo);
        $this->db->set('ditonton','`ditonton`+1' , FALSE);
        $this->db->update('tb_video');
    }

	public function updatesuka($idvideo)
	{
		$this->db->where('id_video', $idvideo);
		$this->db->set('disukai','`disukai`+1' , FALSE);
		$this->db->update('tb_video');
		$this->db->select('disukai');
		$this->db->where('id_video', $idvideo);
		$this->db->from('tb_video');
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

	public function addtbsuka($data){
		$this->db->insert('tb_like', $data);
	}

	public function addkomen($data){
		$this->db->insert('tb_komentar', $data);
	}

	public function addshare($data){
		$this->db->insert('tb_share', $data);
	}

	function getVODCari($jenjangpendek,$idmapel,$kuncikunci,$limit=null,$start=null) {
		$keywordsMany = explode(' ',$kuncikunci);

		$result=array();

		$this->db->select('tv.*,first_name');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
		if ($jenjangpendek=="kategori" && $jenjangpendek!=0)
		{
			//echo "z1";
			$this->db->where('(id_kategori="'.$idmapel.'")');
		}
		else if ($idmapel!=0)
		{
			//echo "z2";
			$this->db->where('(id_mapel="'.$idmapel.'")');
		}
		else if (!$jenjangpendek==0)
		{
			//echo "z3";
			$this->db->join('daf_jenjang dj', 'dj.id = tv.id_jenjang','left');
			$this->db->where('(nama_pendek="'.$jenjangpendek.'")');
		}

		$this->db->where('((status_verifikasi=4 AND id_jenis=1) OR ((status_verifikasi=2 OR status_verifikasi=4) AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!=""))');
		$this->db->where("(judul like '%$kuncikunci%' OR topik like '%$kuncikunci%' OR keyword like '%$kuncikunci%')",NULL,FALSE);

		$this->db->order_by('modified','desc');

		$query = $this->db->get()->result();
		if ($limit!=null)
        {
            $this->db->limit($limit,$start);
        }

		$result = array_merge($result, $query);

		foreach($keywordsMany as $kunci) {
			$this->db->select('tv.*,first_name');
			$this->db->from('tb_video tv');
			$this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
			if ($jenjangpendek=="kategori")
			{
				$this->db->where('(id_kategori="'.$idmapel.'")');
			}
			else if ($idmapel!=0)
			{
				$this->db->where('(id_mapel="'.$idmapel.'")');
			}
			else if (!$jenjangpendek==0)
			{
				$this->db->join('daf_jenjang dj', 'dj.id = tv.id_jenjang','left');
				$this->db->where('(nama_pendek="'.$jenjangpendek.'")');
			}
			$this->db->where('((status_verifikasi=4 AND id_jenis=1) OR ((status_verifikasi=2 OR status_verifikasi=4) AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!=""))');
			$this->db->where("(judul like '%$kunci%' OR topik like '%$kunci%' OR keyword like '%$kunci%')",NULL,FALSE);
            $this->db->where('(tv.durasi<>"")');
			$this->db->order_by('modified','desc');

			$query = $this->db->get()->result();

			$result = array_merge($result, $query);


		}

		return $result;
	}

	public function search_VOD($title){
		$this->db->like('judul', $title , 'both');
		$this->db->order_by('judul', 'ASC');
		$this->db->limit(10);
		return $this->db->get('tb_video')->result();
	}

}
