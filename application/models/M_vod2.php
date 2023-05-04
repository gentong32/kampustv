<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_vod2 extends CI_Model {

    public function __construct()	{
        $this->load->database('sekolah', TRUE);
    }

    public function getVODAll($idjenjang=null){
        $this->db->select('tv.*,first_name');
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
        $this->db->where('(tv.durasi<>"")');
        $this->db->where('(((status_verifikasi=4 || status_verifikasi=2) AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!="") OR (status_verifikasi=4 AND link_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->where('(sifat=0)');
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
		$this->db->where('(((status_verifikasi=4 || status_verifikasi=2) AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!="") OR (status_verifikasi=4 AND link_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->where('(sifat=0)');
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
		$this->db->where('(((status_verifikasi=4 || status_verifikasi=2) AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!="") OR (status_verifikasi=4 AND link_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->where('(sifat=0)');

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
		//$this->db->order_by('urutan');
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

        $this->db->select('dm.*');
        $this->db->from('daf_mapel dm');
		$this->db->join('tb_video tv', 'dm.id = tv.id_mapel');
        $this->db->where('dm.id_jenjang', $idjenjang);
		$this->db->where('tv.sifat', 0);
		$this->db->group_by('dm.id');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getDataPerJenjang(){
        $this->db->select('nama_pendek,COUNT(*) as jml_video');
        $this->db->from('tb_video tv');
        $this->db->join('daf_jenjang dj', 'dj.id = tv.id_jenjang','left');
        $this->db->group_by('nama_pendek');
        $this->db->where('(tv.durasi<>"")');
		$this->db->where('(((status_verifikasi=4 || status_verifikasi=2) AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!="") OR (status_verifikasi=4 AND link_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
        $result = $this->db->get()->result();
       
        
        return $result;
    }

    public function getDataPerKategori(){
        $this->db->select('nama_kategori,COUNT(*) as jml_video');
        $this->db->from('tb_video tv');
        $this->db->join('daf_kategori dj', 'dj.id = tv.id_kategori','left');
        $this->db->group_by('nama_kategori');
        $this->db->where('(tv.durasi<>"")');
		$this->db->where('(((status_verifikasi=4 || status_verifikasi=2) AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!="") OR (status_verifikasi=4 AND link_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getVideo($id_video){
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
		$this->db->where('kode_video', $id_video);
		$this->db->where('(status_verifikasi_admin=4)');
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

	function getVODCari($jenjangpendek,$idmapel,$kuncikunci,$limit=null,$start=null,$asal=null) {
		$keywordsMany = explode(' ',$kuncikunci);

		//echo $jenjangpendek."--".$idmapel."--".$kuncikunci;

		$this->db->select('tv.*,first_name');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
		if ($asal=="mapel")
			$this->db->where('(id_jenis=1)');
		else if ($asal=="kategori")
			$this->db->where('(id_jenis=2)');
		if ($jenjangpendek=="kategori" && $jenjangpendek!="0")
		{
			$this->db->where('(id_kategori="'.$idmapel.'")');
		}
		else if ($idmapel!=0)
		{
			$this->db->where('(id_mapel="'.$idmapel.'")');
		}
		else if ($jenjangpendek!=0)
		{
			$this->db->join('daf_jenjang dj', 'dj.id = tv.id_jenjang','left');
			$this->db->where('(nama_pendek="'.$jenjangpendek.'")');
		}
//		die();

		$this->db->where('(((status_verifikasi=4 || status_verifikasi=2) AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2)
        OR (status_verifikasi=4 AND file_video!="") OR (status_verifikasi=4 AND link_video!=""))');
//		$this->db->where('(status_verifikasi=4)');
		//$this->db->where("(judul like '%$kuncikunci%' OR topik like '%$kuncikunci%' OR keyword like '%$kuncikunci%')",NULL,FALSE);
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->where('(sifat=0)');
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('modified','desc');

		$isiwhere = "(judul like '%".$kuncikunci."%'";
//		for ($a=0;$a<count($keywordsMany);$a++) {
//			$isiwhere = $isiwhere . " OR judul like '%".$keywordsMany[$a]."%'";
//		}

		$isiwhere = $isiwhere." OR topik like '%".$kuncikunci."%'";
//		for ($a=0;$a<count($keywordsMany);$a++) {
//			$isiwhere = $isiwhere . " OR topik like '%".$keywordsMany[$a]."%'";
//		}

		$isiwhere = $isiwhere." OR keyword like '%".$kuncikunci."%'";
//		for ($a=0;$a<count($keywordsMany);$a++) {
//			$isiwhere = $isiwhere . " OR keyword like '%".$keywordsMany[$a]."%'";
//		}

		$isiwhere = $isiwhere . ")";

		$this->db->where($isiwhere);

		if ($limit!=null)
		{
			$this->db->limit($limit,$start);
		}
		$query = $this->db->get()->result();

		return $query;
	}

	public function search_VOD($jenjang,$mapel,$kunci,$asal){
		$this->db->like('judul', $kunci , 'both');
		$this->db->where('(((status_verifikasi=4 || status_verifikasi=2) AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2)
        OR (status_verifikasi=4 AND file_video!="") OR (status_verifikasi=4 AND link_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->where('(sifat=0)');
		if ($asal=="mapel")
			$this->db->where('(id_jenis=1)');
		else if ($asal=="kategori")
			$this->db->where('(id_jenis=2)');
		if ($jenjang!="" && $jenjang!="0")
			$this->db->where('id_jenjang',$jenjang);
		if ($mapel!="cari" && $mapel!="0")
			$this->db->where('id_mapel',$mapel);
		$this->db->order_by('judul', 'ASC');
		$this->db->limit(10);
		return $this->db->get('tb_video')->result();
	}

    public function jmlChnSekolah(){
        $this->db->from('daf_chn_sekolah');
        $this->db->where('status',1);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;
    }

	public function jmlChnAktifSekolah(){
		$this->db->from('daf_chn_sekolah');
		$this->db->where('status',1);
		$this->db->where('jml_video>',0);
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount;
	}

	public function jmlPlaylistAktifSekolah(){
		$this->db->from('daf_chn_sekolah ds');
		$this->db->join('tb_paket_channel_sekolah tc', 'tc.npsn = ds.npsn','left');
		$this->db->group_by('tc.npsn');
		$this->db->where('(status_paket>0)');
		$this->db->where('(ds.npsn<>"10000010" AND ds.npsn<>"10000002")');
		$this->db->where('status', 1);
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount;
	}

	public function jmlPerJenjang($jenjang){
		$this->db->from('daf_chn_sekolah ds');
		$this->db->where('(ds.npsn<>"10000010" AND ds.npsn<>"10000002")');
		$this->db->where('idjenjang', $jenjang);
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount;
	}

	public function jmlVideo(){
		$this->db->from('tb_video');
		$this->db->where('(durasi<>"")');
		$this->db->where('(((status_verifikasi=4 || status_verifikasi=2) AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!="") OR (status_verifikasi=4 AND link_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount;
	}

	public function jmlGuru(){
		$this->db->from('tb_user');
		$this->db->where('(sebagai=1)');
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount;
	}

	public function jmlVerSekolah(){
		$this->db->from('tb_user');
		$this->db->where('(sebagai=1)');
		$this->db->where('(verifikator=3)');
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount;
	}

	public function jmlKontributorSekolah(){
		$this->db->from('tb_user');
		$this->db->where('(sebagai=1)');
		$this->db->where('(kontributor=3)');
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount;
	}

	public function jmlSiswa(){
		$this->db->from('tb_user');
		$this->db->where('(sebagai=2)');
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount;
	}

	public function jmlKontributorSiswa(){
		$this->db->from('tb_user');
		$this->db->where('(sebagai=2)');
		$this->db->where('(kontributor=3)');
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount;
	}

	public function jmlUmum(){
		$this->db->from('tb_user');
		$this->db->where('(sebagai=3)');
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount;
	}

	public function jmlKontributorUmum(){
		$this->db->from('tb_user');
		$this->db->where('(sebagai=3)');
		$this->db->where('(kontributor=3)');
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount;
	}

}
