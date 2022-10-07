<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_bimbel extends CI_Model {

    public function __construct()	{
        $this->load->database();
    }

    public function getBimbelAll($idjenjang=null){
        $this->db->select('tv.*,first_name');
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
        $this->db->where('(tv.durasi<>"")');
        $this->db->where('((status_verifikasi_bimbel=4 AND id_jenis=1) OR (status_verifikasi_bimbel=2 AND id_jenis=2) 
        OR (status_verifikasi_bimbel=4 AND file_video!="") OR (status_verifikasi_bimbel=4 AND link_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
        if ($idjenjang!=null)
        {
            $this->db->where('id_jenjang', $idjenjang);
            $this->db->limit(5);
        }
        $this->db->order_by('modified','desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getBimbelMapel($namajenjang,$idmapel,$limit=null,$start=null){
		$this->db->from('tb_paket_bimbel tpc');
		$this->db->join('tb_channel_bimbel tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
//		$this->db->where('(tcv.urutan=0 OR tcv.urutan=1)');
        $this->db->join('daf_jenjang dj', 'dj.id = tpc.id_jenjang','left');
        $this->db->where('(tv.durasi<>"" AND tv.durasi<>"00:00:00")');
		$this->db->where('(((status_verifikasi_bimbel=4 OR status_verifikasi_bimbel=2) AND tv.id_jenis=1) OR ((status_verifikasi_bimbel=2 OR status_verifikasi_bimbel=4) AND tv.id_jenis=2) 
        OR (status_verifikasi_bimbel=4 AND file_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
        if ($idmapel==0)
        $this->db->where('(nama_pendek="'.$namajenjang.'")');
        else
        $this->db->where('(tpc.id_mapel='.$idmapel.')');
		$this->db->group_by('tpc.id');
        if ($limit!=null)
        {
            $this->db->limit($limit,$start);
        }
        $this->db->order_by('modified','desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getBimbelKategori($idkategori=null,$limit=null,$start=null){
        $this->db->select('tv.*,first_name');
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
        $this->db->where('(tv.durasi<>"")');
        $this->db->where('((status_verifikasi_bimbel=4 AND id_jenis=1) OR (status_verifikasi_bimbel=2 AND id_jenis=2) 
        OR (status_verifikasi_bimbel=4 AND file_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');

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

	public function getJenjangBimbel(){
		$this->db->reset_query();
		$this->db->select('dj.*');
		$this->db->from('daf_jenjang dj');
		$this->db->join('tb_paket_bimbel tv', 'dj.id = tv.id_jenjang');
		$this->db->group_by('dj.id');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getKelasAll(){
		$this->db->from('daf_kelas');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getKelasBimbel(){
    	$this->db->select('dk.*');
		$this->db->from('daf_kelas dk');
		$this->db->join('tb_paket_bimbel tv', 'dk.id = tv.id_kelas');
		$this->db->group_by('dk.id');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getKelasJenjang($jenjang){
		$this->db->from('daf_kelas');
		$this->db->where('id_jenjang', $jenjang);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getMapelJenjang($jenjang){
		$this->db->from('daf_mapel');
		$this->db->where('id_jenjang', $jenjang);
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

	public function dafMapelBimbel($namapendek,$kelas){
    	if ($kelas==null)
    		$kelas=0;
		$this->db->select('id');
		$this->db->from('daf_jenjang');
		$this->db->where('nama_pendek', $namapendek);
		$idjenjang = $this->db->get()->result_array();
		$idjenjang = $idjenjang[0]['id'];

		$this->db->select('dm.*');
		$this->db->from('daf_mapel dm');
		$this->db->join('tb_paket_bimbel tv', 'dm.id = tv.id_mapel');
		$this->db->where('dm.id_jenjang', $idjenjang);
		if ($kelas>0)
		$this->db->where('tv.id_kelas', $kelas);
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
        $this->db->where('((status_verifikasi_bimbel=4 AND id_jenis=1) OR (status_verifikasi_bimbel=2 AND id_jenis=2) OR (status_verifikasi_bimbel=4 AND !file_video=""))');
        $result = $this->db->get()->result();
       
        
        return $result;
    }

    public function getDataPerKategori(){
        $this->db->select('nama_kategori,COUNT(*) as jml_video');
        $this->db->from('tb_video tv');
        $this->db->join('daf_kategori dj', 'dj.id = tv.id_kategori','left');
        $this->db->group_by('nama_kategori');
        $this->db->where('(tv.durasi<>"")');
        $this->db->where('((status_verifikasi_bimbel=4 AND id_jenis=1) OR (status_verifikasi_bimbel=2 AND id_jenis=2) 
        OR (status_verifikasi_bimbel=4 AND file_video!=""))');
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

	function getBimbelCari($jenjangpendek,$idmapel,$kuncikunci,$limit=null,$start=null) {
		$keywordsMany = explode(' ',$kuncikunci);

		//echo $jenjangpendek."--".$idmapel."--".$kuncikunci;

//		$this->db->select('tv.*,first_name,tcv.id_paket');
		$this->db->from('tb_paket_bimbel tpc');
		$this->db->join('tb_channel_bimbel tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
//		$this->db->where('(urutan=0 OR urutan=1)');

		if ($jenjangpendek=="kategori" && $jenjangpendek!=0)
		{
//			echo "cek1";
			$this->db->where('(id_kategori="'.$idmapel.'")');
		}
		else if ($idmapel!=0)
		{
//			echo "cek2";
			$this->db->where('(id_mapel="'.$idmapel.'")');
		}
		else if ($jenjangpendek!=0)
		{
//			echo "cek3";
			$this->db->join('daf_jenjang dj', 'dj.id = tv.id_jenjang','left');
			$this->db->where('(nama_pendek="'.$jenjangpendek.'")');
		}
//		echo "cek4";
//		die();

		$this->db->where('(((status_verifikasi_bimbel=4 OR status_verifikasi_bimbel=2) AND tv.id_jenis=1) OR ((status_verifikasi_bimbel=2 OR status_verifikasi_bimbel=4) AND tv.id_jenis=2) 
        OR (status_verifikasi_bimbel=4 AND file_video!=""))');
		//$this->db->where("(judul like '%$kuncikunci%' OR topik like '%$kuncikunci%' OR keyword like '%$kuncikunci%')",NULL,FALSE);
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('tv.modified','desc');

		$isiwhere = "(judul like '%".$kuncikunci."%'";
		for ($a=0;$a<count($keywordsMany);$a++) {
			$isiwhere = $isiwhere . " OR judul like '%".$keywordsMany[$a]."%'";
		}

		$isiwhere = $isiwhere." OR nama_paket like '%".$kuncikunci."%'";
		for ($a=0;$a<count($keywordsMany);$a++) {
			$isiwhere = $isiwhere . " OR nama_paket like '%".$keywordsMany[$a]."%'";
		}

		$isiwhere = $isiwhere." OR topik like '%".$kuncikunci."%'";
		for ($a=0;$a<count($keywordsMany);$a++) {
			$isiwhere = $isiwhere . " OR topik like '%".$keywordsMany[$a]."%'";
		}

		$isiwhere = $isiwhere." OR tv.keyword like '%".$kuncikunci."%'";
		for ($a=0;$a<count($keywordsMany);$a++) {
			$isiwhere = $isiwhere . " OR tv.keyword like '%".$keywordsMany[$a]."%'";
		}

		$isiwhere = $isiwhere . ")";

		$this->db->where($isiwhere);

		if ($limit!=null)
		{
			$this->db->limit($limit,$start);
		}
		$query = $this->db->get()->result();

		return $query;
	}

	public function search_Bimbel($title){
		$this->db->like('nama_paket', $title , 'both');
		$this->db->order_by('nama_paket', 'ASC');
		$this->db->where('durasi_paket<>','00:00:00');
		$this->db->group_by('nama_paket');
		$this->db->limit(10);
		return $this->db->get('tb_paket_bimbel')->result();
	}

	public function search_Bimbel2($jenjang,$kelas,$mapel,$title){
		$this->db->like('nama_paket', $title , 'both');
		$this->db->order_by('nama_paket', 'ASC');
		$this->db->where('durasi_paket<>','00:00:00');
		$this->db->group_by('nama_paket');
		$this->db->limit(10);
		return $this->db->get('tb_paket_bimbel')->result();
	}

    public function jmlChnSekolah(){
        $this->db->from('daf_chn_sekolah');
        $this->db->where('status',1);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;
    }

	public function getDafPlayListBimbel($iduser,$kodebeli,$jenjang=null,$kelas=null,$mapel=null,$cari=null,$limit=null,$start=null)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$joinnya = "tk2.kode_beli=tb.kode_beli AND tb.tgl_beli<='".$tglsekarang."' AND tb.tgl_batas>='".$tglsekarang."'";

		$this->db->select('tpc.*, tcv.*, tv.*,tk.link_paket,tj.dikeranjang,1 as prioritas,tk.kode_beli,
		tk2.kode_beli as kode_beli2,dk.nama_kelas,dm.nama_mapel');
//		$this->db->select('tpc.nama_paket, tb.tgl_beli, tpc.link_list, tpc.status_paket, SUBSTR(tk2.kode_beli,1,3) as kodebeli');
//		$this->db->select('tpc.nama_paket,tpc.link_list,tk.kode_beli, tk2.kode_beli as kode_beli2');
		$this->db->from('tb_paket_bimbel tpc');
		$this->db->join('tb_channel_bimbel tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "'.
			$kodebeli.'" AND tk.id_user = '.$iduser,'left');
		$this->db->join('tb_virtual_kelas tk2','tk2.link_paket = tpc.link_list AND SUBSTR(tk2.kode_beli,1,3) = "ECR"'.
			' AND tk2.id_user = '.$iduser,'left');
		$this->db->join('tb_vk_beli tb', $joinnya,'left');
		$this->db->join('tb_vk_keranjang tj', 'tj.link_list = tpc.link_list AND tj.jenis_paket = 3 AND tj.id_user = '.$iduser,'left');
		$this->db->join('daf_kelas dk','dk.id = tpc.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tpc.id_mapel','left');

		$this->db->where('(((status_verifikasi_bimbel=4 OR status_verifikasi_bimbel=2) AND tv.id_jenis=1) 
		OR ((status_verifikasi_bimbel=2 OR status_verifikasi_bimbel=4) AND tv.id_jenis=2)
        OR (status_verifikasi_bimbel=4 AND file_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
		if ($jenjang!=null && $jenjang!=0)
			$this->db->where('(tpc.id_jenjang=' . $jenjang . ')');
		if ($kelas!=null && $kelas!=0)
			$this->db->where('(tpc.id_kelas=' . $kelas . ')');
		if ($mapel!=null && $mapel!=0)
			$this->db->where('(tpc.id_mapel=' . $mapel . ')');
		if ($cari!=null)
			$this->db->where('(tpc.nama_paket LIKE "%' . $cari . '%" '.
			'OR tpc.keyword LIKE "%' . $cari . '%" OR tv.judul LIKE "%' . $cari . '%" '.
			'OR tv.topik LIKE "%' . $cari . '%")');

		$this->db->where('(tpc.durasi_paket<>"00:00:00")');
		$this->db->where('(tv.durasi<>"" AND tv.durasi<>"00:00:00")');
		$this->db->where('(tk2.kode_beli IS NULL)');
		$this->db->where('(tk.kode_beli IS NULL)');
//		$this->db->where('((SUBSTR(tk.kode_beli,1,3)<>"ECR" AND SUBSTR(tk.kode_beli,1,3)<>"PKT") OR tk2.kode_beli IS NULL)');
		$this->db->where('status_paket>',0);
		$this->db->where('uraianmateri<>',"");
		$this->db->where('statussoal>',0);
		$this->db->where('statustugas>',0);
		$this->db->group_by('tpc.link_list');

		$query1 = $this->db->get_compiled_select();

		$this->db->select('tpc.*, tcv.*, tv.*,tk.link_paket,tb.kode_beli as dikeranjang,2 as prioritas,
		tk.kode_beli,tk2.kode_beli as kode_beli2,dk.nama_kelas,dm.nama_mapel');
		$this->db->from('tb_paket_bimbel tpc');
		$this->db->join('tb_channel_bimbel tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "'.
			$kodebeli.'" AND tk.id_user = '.$iduser,'left');
		$this->db->join('tb_virtual_kelas tk2','tk2.link_paket = tpc.link_list AND SUBSTR(tk2.kode_beli,1,3) = "ECR"'.
			' AND tk2.id_user = '.$iduser,'left');
		$this->db->join('tb_vk_beli tb', $joinnya,'left');
		$this->db->join('daf_kelas dk','dk.id = tpc.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tpc.id_mapel','left');

		$this->db->where('(((status_verifikasi_bimbel=4 OR status_verifikasi_bimbel=2) AND tv.id_jenis=1) 
		OR ((status_verifikasi_bimbel=2 OR status_verifikasi_bimbel=4) AND tv.id_jenis=2)
        OR (status_verifikasi_bimbel=4 AND file_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
		if ($jenjang!=null && $jenjang!=0)
			$this->db->where('(tpc.id_jenjang=' . $jenjang . ')');
		if ($kelas!=null && $kelas!=0)
			$this->db->where('(tpc.id_kelas=' . $kelas . ')');
		if ($mapel!=null && $mapel!=0)
			$this->db->where('(tpc.id_mapel=' . $mapel . ')');
		if ($cari!=null)
			$this->db->where('(tpc.nama_paket LIKE "%' . $cari . '%" '.
				'OR tpc.keyword LIKE "%' . $cari . '%" OR tv.judul LIKE "%' . $cari . '%" '.
				'OR tv.topik LIKE "%' . $cari . '%")');
		$this->db->where('(SUBSTR(tk2.kode_beli,1,3)="ECR" OR SUBSTR(tk.kode_beli,1,3)="PKT")');

		if ($limit!=null)
			$this->db->limit($limit,$start);
		$this->db->group_by('link_list');
		$this->db->order_by('prioritas', 'desc');
		$this->db->order_by('dikeranjang', 'desc');
		$this->db->order_by('link_paket', 'desc');
		$this->db->order_by('statussoal', 'desc');
		$this->db->order_by('statustugas', 'desc');
		$this->db->order_by('status_paket', 'asc');

		$query2 = $this->db->get_compiled_select();

		$query = $this->db->query($query1 . " UNION " . $query2);
		$query = $query->result();

		return $query;

	}


	public function getDafPlayListBimbelAll($linklist=null,$hal,$kodebeli=null,$iduser=null)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$joinnya = "tb.kode_beli=tk.kode_beli AND tb.tgl_beli<='".$tglsekarang."' AND tb.tgl_batas>='".$tglsekarang."'";

		$this->db->select('tpc.*, tcv.*, tv.*,tk.link_paket,SUBSTR(MIN(tk.kode_beli),5,1) as prioritas,tj.dikeranjang,MIN(tk.kode_beli) as kode_beli,
		dk.nama_kelas,dm.nama_mapel,tb.tgl_beli');
//		$this->db->select('tpc.nama_paket, SUBSTR(tk.kode_beli,5,1) as prioritas, SUBSTR(tk.kode_beli,1,3) as kodebeli');
//		$this->db->select('tpc.nama_paket,tpc.link_list,MIN(tk2.kode_beli),tb.tgl_beli,MAX(strata_paket)');
		$this->db->from('tb_paket_bimbel tpc');
		$this->db->join('tb_channel_bimbel tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
//		$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "'.
//			$kodebeli.'" AND tk.id_user = '.$iduser,'left');
		$this->db->join('tb_virtual_kelas tk',"tk.link_paket = tpc.link_list AND SUBSTR(tk.kode_beli,1,3) = 'ECR'".
			"AND tk.kode_beli = '".$kodebeli."' AND tk.id_user = ".$iduser,'left');
		$this->db->join('tb_vk_beli tb',$joinnya,'left');
		$this->db->join('tb_vk_keranjang tj', 'tj.link_list = tpc.link_list AND tj.jenis_paket = 3 AND tj.id_user = '.$iduser,'left');
		$this->db->join('daf_kelas dk','dk.id = tpc.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tpc.id_mapel','left');

		if ($linklist!=null)
			$this->db->where('tpc.link_list',$linklist);
		$this->db->where('(((status_verifikasi_bimbel=4 OR status_verifikasi_bimbel=2) AND tv.id_jenis=1) 
		OR ((status_verifikasi_bimbel=2 OR status_verifikasi_bimbel=4) AND tv.id_jenis=2) 
        OR (status_verifikasi_bimbel=4 AND file_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->where('(tpc.durasi_paket<>"00:00:00")');
		$this->db->where('(tv.durasi<>"" AND tv.durasi<>"00:00:00")');
		$this->db->where('((SUBSTR(tk.kode_beli,1,3)="ECR" AND tb.tgl_beli IS NOT NULL) OR
		(SUBSTR(tk.kode_beli,1,3)="PKT" AND tb.tgl_beli IS NOT NULL) OR 
		(tk.kode_beli IS NULL AND tb.tgl_beli IS NULL))');
//		$this->db->where('(tk2.kode_beli IS NULL)');
//		$this->db->where('(tk.kode_beli IS NULL)');
//		$this->db->where('((SUBSTR(tk.kode_beli,1,3)<>"ECR" AND SUBSTR(tk.kode_beli,1,3)<>"PKT") OR tk2.kode_beli IS NULL)');
		$this->db->where('status_paket>',0);
		$this->db->where('uraianmateri<>',"");
		$this->db->where('statussoal>',0);
		$this->db->where('statustugas>',0);

		if ($hal!="semua")
			$this->db->limit(8,($hal*8)-8);
		$this->db->group_by('link_list');
		$this->db->order_by('prioritas', 'desc');
		$this->db->order_by('dikeranjang', 'desc');
		$this->db->order_by('link_paket', 'desc');
		$this->db->order_by('statussoal', 'desc');
		$this->db->order_by('statustugas', 'desc');
		$this->db->order_by('status_paket', 'asc');

		$query1 = $this->db->get_compiled_select();

		$query = $this->db->query($query1);
		$query = $query->result();

		return $query;
	}

	public function tesambildata($linklist=null,$hal,$kodebeli=null,$iduser=null)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$joinnya = "tb.kode_beli=tk.kode_beli AND tb.tgl_beli<='".$tglsekarang."' AND tb.tgl_batas>='".$tglsekarang."'";

		$this->db->select('tpc.*, tcv.*, tv.*,tk.link_paket,tj.dikeranjang,1 as prioritas,MIN(tk.kode_beli),dk.nama_kelas,dm.nama_mapel,tb.tgl_beli');
//		$this->db->select('tpc.nama_paket, tb.tgl_beli, tpc.link_list, tpc.status_paket, SUBSTR(tk2.kode_beli,1,3) as kodebeli');
//		$this->db->select('tpc.nama_paket,tpc.link_list,MIN(tk2.kode_beli),tb.tgl_beli,MAX(strata_paket)');
		$this->db->from('tb_paket_bimbel tpc');
		$this->db->join('tb_channel_bimbel tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
//		$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "'.
//			$kodebeli.'" AND tk.id_user = '.$iduser,'left');
		$this->db->join('tb_virtual_kelas tk',"tk.link_paket = tpc.link_list AND SUBSTR(tk.kode_beli,1,3) = 'ECR'".
			"AND tk.id_user = ".$iduser,'left');
		$this->db->join('tb_vk_beli tb',$joinnya,'left');
		$this->db->join('tb_vk_keranjang tj', 'tj.link_list = tpc.link_list AND tj.jenis_paket = 3 AND tj.id_user = '.$iduser,'left');
		$this->db->join('daf_kelas dk','dk.id = tpc.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tpc.id_mapel','left');

		if ($linklist!=null)
			$this->db->where('tpc.link_list',$linklist);
		$this->db->where('(((status_verifikasi_bimbel=4 OR status_verifikasi_bimbel=2) AND tv.id_jenis=1) 
		OR ((status_verifikasi_bimbel=2 OR status_verifikasi_bimbel=4) AND tv.id_jenis=2) 
        OR (status_verifikasi_bimbel=4 AND file_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->where('(tpc.durasi_paket<>"00:00:00")');
		$this->db->where('(tv.durasi<>"" AND tv.durasi<>"00:00:00")');
		$this->db->where('((SUBSTR(tk.kode_beli,1,3)="ECR" AND tb.tgl_beli IS NOT NULL) OR
		(SUBSTR(tk.kode_beli,1,3)="PKT" AND tb.tgl_beli IS NOT NULL) OR 
		(tk.kode_beli IS NULL AND tb.tgl_beli IS NULL))');
//		$this->db->where('(tk2.kode_beli IS NULL)');
//		$this->db->where('(tk.kode_beli IS NULL)');
//		$this->db->where('((SUBSTR(tk.kode_beli,1,3)<>"ECR" AND SUBSTR(tk.kode_beli,1,3)<>"PKT") OR tk2.kode_beli IS NULL)');
		$this->db->where('status_paket>',0);
		$this->db->where('uraianmateri<>',"");
		$this->db->where('statussoal>',0);
		$this->db->where('statustugas>',0);
		$this->db->group_by('tpc.link_list');
//		$this->db->group_by('tk.link_paket');

		$query1 = $this->db->get_compiled_select();

		$this->db->select('tpc.*, tcv.*, tv.*,tk.link_paket,tb.kode_beli as dikeranjang,2 as prioritas,
		tk.kode_beli,tk2.kode_beli as kode_beli2,dk.nama_kelas,dm.nama_mapel,tb.tgl_beli');
		$this->db->from('tb_paket_bimbel tpc');
		$this->db->join('tb_channel_bimbel tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "'.
			$kodebeli.'" AND tk.id_user = '.$iduser,'left');
		$this->db->join('tb_virtual_kelas tk2','tk2.link_paket = tpc.link_list AND SUBSTR(tk2.kode_beli,1,3) = "ECR"'.
			' AND tk2.id_user = '.$iduser,'left');
		$this->db->join('tb_vk_beli tb', $joinnya,'left');
		$this->db->join('daf_kelas dk','dk.id = tpc.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tpc.id_mapel','left');

		if ($linklist!=null)
			$this->db->where('tpc.link_list',$linklist);
		$this->db->where('(((status_verifikasi_bimbel=4 OR status_verifikasi_bimbel=2) AND tv.id_jenis=1) 
		OR ((status_verifikasi_bimbel=2 OR status_verifikasi_bimbel=4) AND tv.id_jenis=2)
        OR (status_verifikasi_bimbel=4 AND file_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->where('(SUBSTR(tk2.kode_beli,1,3)="ECR" OR SUBSTR(tk.kode_beli,1,3)="PKT")');
//		$this->db->where('(tb.kode_beli IS NOT NULL)');

		if ($hal!="semua")
			$this->db->limit(8,($hal*8)-8);
		$this->db->group_by('link_list');
		$this->db->order_by('prioritas', 'desc');
		$this->db->order_by('dikeranjang', 'desc');
		$this->db->order_by('link_paket', 'desc');
		$this->db->order_by('statussoal', 'desc');
		$this->db->order_by('statustugas', 'desc');
		$this->db->order_by('status_paket', 'asc');

		$query2 = $this->db->get_compiled_select();

		$query = $this->db->query($query1);// . " UNION " . $query2);
		$query = $query->result();

		return $query;
	}

	public function getDafPlayListBimbelAllLASTOK($linklist=null,$hal,$kodebeli=null,$iduser=null)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$joinnya = "tk2.kode_beli=tb.kode_beli AND tb.tgl_beli<='".$tglsekarang."' AND tb.tgl_batas>='".$tglsekarang."'";

		$this->db->select('tpc.*, tcv.*, tv.*,tk.link_paket,tj.dikeranjang,1 as prioritas,tk.kode_beli');
//		$this->db->select('tpc.nama_paket, tpc.link_list, tpc.status_paket, SUBSTR(tk2.kode_beli,1,3) as kodebeli');
		$this->db->from('tb_paket_bimbel tpc');
		$this->db->join('tb_channel_bimbel tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "'.
			$kodebeli.'" AND tk.id_user = '.$iduser,'left');
		$this->db->join('tb_virtual_kelas tk2','tk2.link_paket=tpc.link_list','left');
		$this->db->join('tb_vk_beli tb', $joinnya,'left');
		$this->db->join('tb_vk_keranjang tj', 'tj.link_list = tpc.link_list AND tj.jenis_paket = 3 AND tj.id_user = '.$iduser,'left');

		if ($linklist!=null)
			$this->db->where('tpc.link_list',$linklist);
		$this->db->where('(((status_verifikasi_bimbel=4 OR status_verifikasi_bimbel=2) AND tv.id_jenis=1) OR ((status_verifikasi_bimbel=2 OR status_verifikasi_bimbel=4) AND tv.id_jenis=2) 
        OR (status_verifikasi_bimbel=4 AND file_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->where('(tpc.durasi_paket<>"00:00:00")');
		$this->db->where('(tv.durasi<>"" AND tv.durasi<>"00:00:00")');
		$this->db->where('(SUBSTR(tk2.kode_beli,1,3)<>"ECR" OR tk2.kode_beli IS NULL)');
		$this->db->where('status_paket>',0);
		$this->db->where('uraianmateri<>',"");
		$this->db->where('statussoal>',0);
		$this->db->where('statustugas>',0);
		$this->db->group_by('link_list');

		$query1 = $this->db->get_compiled_select();

		$this->db->select('tpc.*, tcv.*, tv.*,tk.link_paket,tb.kode_beli as dikeranjang,SUBSTR(tk.kode_beli,5,1) as prioritas,tk.kode_beli');
		$this->db->from('tb_paket_bimbel tpc');
		$this->db->join('tb_channel_bimbel tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->join('tb_virtual_kelas tk','tk.link_paket=tpc.link_list AND tk.id_user='.$iduser,'left');
		$this->db->join('tb_vk_beli tb','tk.kode_beli=tb.kode_beli','left');
		$this->db->where('(SUBSTR(tk.kode_beli,1,3)="ECR" AND
		tb.tgl_beli<="'.$tglsekarang.'"AND tb.tgl_batas>="'.$tglsekarang.'")');
		if ($linklist!=null)
			$this->db->where('tpc.link_list',$linklist);
		$this->db->where('(((status_verifikasi_bimbel=4 OR status_verifikasi_bimbel=2) AND tv.id_jenis=1) OR ((status_verifikasi_bimbel=2 OR status_verifikasi_bimbel=4) AND tv.id_jenis=2)
        OR (status_verifikasi_bimbel=4 AND file_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');

		if ($hal!="semua")
			$this->db->limit(8,($hal*8)-8);
		$this->db->group_by('link_list');
		$this->db->group_by('tk.link_paket');
		$this->db->order_by('prioritas', 'desc');
		$this->db->order_by('link_paket', 'desc');
		$this->db->order_by('statussoal', 'desc');
		$this->db->order_by('statustugas', 'desc');
		$this->db->order_by('status_paket', 'asc');

		$query2 = $this->db->get_compiled_select();

		$query = $this->db->query($query1 . " UNION " . $query2);
		$query = $query->result();

		return $query;
	}

	public function getDafPlayListBimbelEceran($linklist=null)
	{
		$this->db->select('tpc.*, tcv.*, tv.*');
		$this->db->from('tb_paket_bimbel tpc');
		$this->db->join('tb_channel_bimbel tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
//		$this->db->where('(urutan=0 OR urutan=1)');
		if ($linklist!=null)
			$this->db->where('tpc.link_list',$linklist);
		$this->db->where('(((status_verifikasi_bimbel=4 OR status_verifikasi_bimbel=2) AND tv.id_jenis=1) OR ((status_verifikasi_bimbel=2 OR status_verifikasi_bimbel=4) AND tv.id_jenis=2) 
        OR (status_verifikasi_bimbel=4 AND file_video!=""))');
		$this->db->where('(status_verifikasi_admin=4)');
//		$this->db->where('tk.kode_beli',$kodebeli);
//		$this->db->where('tk.id_user',$iduser);
//		if ($cari!=null)
//			$this->db->where('(tpc.nama_paket LIKE "%' . $cari . '%" OR tpc.keyword LIKE "%' . $cari . '%")');
		$this->db->group_by('nama_paket');
		$this->db->order_by('statussoal', 'desc');
		$this->db->order_by('statustugas', 'desc');
		$this->db->order_by('status_paket', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPlayListBimbel($link_list,$idsaya=null)
	{
		$this->db->from('tb_channel_bimbel tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_bimbel tpc', 'tpc.id = tcv.id_paket', 'left');
		//$this->db->where('(tv.id_user=' . $idsaya . ')');
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(tpc.link_list="' . $link_list . '")');
		$this->db->where('(tv.status_verifikasi_admin=4)');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPlayListBimbelAll($link_list)
	{
		$this->db->select("tv.*");
		$this->db->from('tb_channel_bimbel tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_bimbel tpc', 'tpc.id = tcv.id_paket', 'left');
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(tpc.link_list="' . $link_list . '")');
		$this->db->order_by('id_video', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getInfoGuru($kd_user)
	{
		$this->db->from('tb_user');
		$this->db->where('id', $kd_user);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPaket($linklist)
	{
		$this->db->select('tp.*, tu.first_name, tu.last_name, tu.email');
		$this->db->from('tb_paket_bimbel tp');
		$this->db->join('tb_user tu', 'tp.id_user = tu.id', 'left');
		$this->db->where('link_list', $linklist);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getSoal($id)
	{
		$this->db->from('tb_soal');
		$this->db->where('id_paket', $id);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getTugas($linklist)
	{
		$this->db->select('*');
		$this->db->from('tb_tugas_guru tg');
		$this->db->join('tb_paket_bimbel tp', 'tg.link_list = tp.link_list', 'left');
		$this->db->where('tg.link_list', $linklist);
		$this->db->where('tipe_paket', 3);
		$this->db->where('status', 1);
		$this->db->order_by('tgl_mulai', 'asc');
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function addTugas($data)
	{
		$this->db->insert('tb_tugas_guru', $data);
	}

	public function getTugasSiswa($idtugasguru,$iduser)
	{
		$this->db->select('*');
		$this->db->from('tb_tugas_siswa ts');
		$this->db->where('ts.id_tugas', $idtugasguru);
		$this->db->where('id_user', $iduser);
		$result = $this->db->get()->last_row();
		if ($result)
			return $result;
		else
			return 0;
	}

	public function getNilaiSiswa($linklist)
	{
		$this->db->select('ts.*, tu.first_name, tu.last_name');
		$this->db->from('tb_soal_nilai ts');
		$this->db->join('tb_user tu', 'ts.iduser = tu.id', 'left');
		$this->db->where('ts.linklist', $linklist);
		$result = $this->db->get()->result();
		if ($result)
			return $result;
		else
			return 0;
	}

	public function updategbrsoal($namafile, $id, $fielddb){
		$data = array(
			$fielddb => $namafile
		);
		$this->db->where('id_soal', $id);
		return $this->db->update('tb_soal', $data);
	}

	public function updatesoal($data, $id){
		$this->db->where('id_soal', $id);
		return $this->db->update('tb_soal', $data);
	}

	public function insertsoal($id)
	{
		$data['id_paket'] = $id;
		$this->db->insert('tb_soal', $data);
		$insertid = $this->db->insert_id();
		return $insertid?$insertid:0;
	}

	public function delsoal($id)
	{
		$this->db->where('(id_soal='.$id.')');
		return $this->db->delete('tb_soal');
	}

	public function updateseting($data, $linklist){
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_bimbel', $data);
	}

	public function ceknilai($linklist,$iduser)
	{
		$this->db->from('tb_soal_nilai');
		$this->db->where('(linklist="' . $linklist . '" AND iduser='.$iduser.')');
		$query = $this->db->get();
		$ret = $query->row();
		if ($ret)
		{
			return $ret;
		}
		else
		{
			$data = array (
				'linklist' => $linklist,
				'iduser' => $iduser
			);
			$this->db->insert('tb_soal_nilai', $data);
			$this->db->from('tb_soal_nilai');
			$this->db->where('(linklist="' . $linklist . '" AND iduser='.$iduser.')');
			$query = $this->db->get();
			$ret = $query->row();
			return $ret;
		}
	}

	public function updatenilai($data,$linklist,$iduser){
		$this->db->where('(linklist="' . $linklist . '" AND iduser='.$iduser.')');
		return $this->db->update('tb_soal_nilai', $data);
	}

	public function updatemateri($data,$linklist)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_bimbel', $data);
	}

	public function updatetugas($data,$tipe,$linklist)
	{
		$this->db->where('link_list', $linklist);
		$this->db->where('tipe_paket', $tipe);
		return $this->db->update('tb_tugas_guru', $data);
	}

	public function updatetugasjawab($data,$id_tugas,$iduser)
	{
		$this->db->where('id_tugas', $id_tugas);
		$this->db->where('id_user', $iduser);
		return $this->db->update('tb_tugas_siswa', $data);
	}

	public function cekpilihan($id_user,$jenis,$linklist)
	{
		$this->db->from('tb_vk_keranjang');
		$this->db->where('id_user', $id_user);
		$this->db->where('jenis_paket', $jenis);
		$this->db->where('link_list', $linklist);
		$result = $this->db->get()->row();
		if ($result)
			return 1;
		else
			return 0;
	}

	public function addkeranjang($data){
		$this->db->insert('tb_vk_keranjang', $data);
	}

	public function delkeranjang($data)
	{
		$this->db->where($data);
		return $this->db->delete('tb_vk_keranjang');
	}

	public function getkeranjang($id_user,$kodebeli)
	{
		$this->db->from('tb_vk_keranjang');
		$this->db->where('id_user', $id_user);
		$this->db->where('jenis_paket', 3);
		$this->db->where('kode_beli', $kodebeli);
		$result = $this->db->get()->result();
		return $result;
	}

	public function addTugasSiswa($data)
	{
		$this->db->insert('tb_tugas_siswa', $data);
	}

	public function insertvk($id,$data)
	{
		$this->db->where('id_user', $id);
		$this->db->where('jenis_paket', 3);
		$this->db->delete('tb_vk_keranjang');
		return $this->db->insert_batch('tb_virtual_kelas', $data);
	}

	public function insertvkeceran($data)
	{
		return $this->db->insert('tb_virtual_kelas', $data);
	}

	public function gethargapaket($npsn)
	{
		$this->db->from('daf_harga_paket');
		$this->db->where('npsn', $npsn);
		$result = $this->db->get()->row_array();
		if ($result)
			return $result;
		else
			return false;
	}

	public function insertkodepaket($data,$data2=null,$order_id=null,$iduser=null)
	{
		$this->db->insert('tb_vk_beli', $data);
		if($data2!=null)
		{
			$userID = $this->db->insert_id();
			$this->dibayarpakete($data2,$userID);
		}

	}

	public function dibayarpakete($datax, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('tb_vk_beli', $datax);
	}

	public function addbayarpaket($datax, $orderid)
	{
		$this->db->where('kode_beli', $orderid);
		$this->db->update('tb_vk_beli', $datax);
	}



	public function getUserVK($tipepaket,$linklist,$idtugas)
	{
		$this->db->select('*');
		$this->db->from('tb_virtual_kelas tv');
		$this->db->join('tb_vk_beli tb', 'tv.kode_beli = tb.kode_beli', 'left');
		$this->db->join('tb_user tu', 'tv.id_user = tu.id', 'left');
		$this->db->join('tb_tugas_siswa ts', 'tv.id_user = ts.id_user AND ts.id_tugas = '.$idtugas, 'left');
		$this->db->where('tv.link_paket', $linklist);
		$this->db->where('tv.jenis_paket', $tipepaket);
//		$this->db->where('status', 1);
		$this->db->order_by('first_name', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafModulBimbel($linklist)
	{
		$this->db->from('tb_paket_bimbel tpc');
//		$this->db->join('tb_vk_pilihguru te', 'te.id_guru = tpc.id_user AND te.id_mapel = tpc.id_mapel', 'both');
//		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
//		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
//		$this->db->join('tb_user tu', 'tu.id = tpc.id_user', 'left');
		$this->db->where('link_list',$linklist);

		$result = $this->db->get()->result();
		return $result;
	}

	public function resettglvicon($linklist)
	{
		$this->db->where('link_list', $linklist);
		$this->db->set('tglvicon',"2021-01-01 00:00:00");
		$this->db->set('koderoom',"");
		$this->db->set('kodepassvicon',"");
		$this->db->update('tb_paket_bimbel');

	}

	public function cekvklinklist($iduser,$linklist=null,$jenis=null)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$this->db->from('tb_virtual_kelas tk');
		$this->db->join('tb_vk_beli tb', 'tk.kode_beli = tb.kode_beli');
		if ($jenis==null)
			$this->db->where('tb.tgl_beli<="'.$tglsekarang.'"AND tb.tgl_batas>="'.$tglsekarang.'"');
		$this->db->where('tk.id_user', $iduser);
		if($linklist!=null)
			$this->db->where('link_paket', $linklist);
		$query = $this->db->get();
		$ret = $query->result();
		return $ret;
	}

}
