<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_vksekolah extends CI_Model {

    public function __construct()	{
        $this->load->database();
    }

    public function getSekolahMapel($npsn, $namajenjang,$idmapel,$limit=null,$start=null){
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->where('(tcv.urutan=0 OR tcv.urutan=1)');
        $this->db->join('daf_jenjang dj', 'dj.id = tv.id_jenjang','left');
        $this->db->where('(tv.durasi<>"")');
        $this->db->where('((status_verifikasi=4 AND tv.id_jenis=1) OR ((status_verifikasi=2 OR status_verifikasi=4) AND tv.id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!=""))');
		$this->db->where('tpc.npsn_user',$npsn);
		$this->db->where('(status_verifikasi_admin=4)');
        if ($idmapel==0)
        $this->db->where('(nama_pendek="'.$namajenjang.'")');
        else
        $this->db->where('(tpc.id_mapel='.$idmapel.')');
        if ($limit!=null)
        {
            $this->db->limit($limit,$start);
        }
        $this->db->order_by('modified','desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getSekolahKategori($idkategori=null,$limit=null,$start=null){
        $this->db->select('tv.*,first_name');
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
        $this->db->where('(tv.durasi<>"")');
        $this->db->where('((status_verifikasi=4 AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!=""))');
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

	public function getJenjangSekolah(){
		$this->db->select('dj.*');
		$this->db->from('daf_jenjang dj');
		$this->db->join('tb_paket_channel tv', 'dj.id = tv.id_jenjang');
		$this->db->group_by('dj.id');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getKelasAll(){
		$this->db->from('daf_kelas');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getKelasSekolah(){
    	$this->db->select('dk.*');
		$this->db->from('daf_kelas dk');
		$this->db->join('tb_paket_channel tv', 'dk.id = tv.id_kelas');
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

	public function dafMapelSekolah($namapendek,$kelas){
    	if ($kelas==null)
    		$kelas=0;
		$this->db->select('id');
		$this->db->from('daf_jenjang');
		$this->db->where('nama_pendek', $namapendek);
		$idjenjang = $this->db->get()->result_array();
		if ($idjenjang) {
			$idjenjang = $idjenjang[0]['id'];
		}
		else
		{
			redirect("/");
		}

		$this->db->select('dm.*');
		$this->db->from('daf_mapel dm');
		$this->db->join('tb_paket_channel tv', 'dm.id = tv.id_mapel');
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

	function getSekolahCari($npsn,$jenjangpendek,$idmapel,$kuncikunci,$limit=null,$start=null) {
		$keywordsMany = explode(' ',$kuncikunci);

		//echo $jenjangpendek."--".$idmapel."--".$kuncikunci;

//		$this->db->select('tv.*,first_name,tcv.id_paket');
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
//		$this->db->where('(urutan=0 OR urutan=1)');
		$this->db->where('tpc.npsn_user',$npsn);

		if ($jenjangpendek=="kategori" && $jenjangpendek!="0")
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
//		die();

		$this->db->where('(((status_verifikasi=4 OR status_verifikasi=2) AND tv.id_jenis=1) OR ((status_verifikasi=2 OR status_verifikasi=4) AND tv.id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!=""))');
		//$this->db->where("(judul like '%$kuncikunci%' OR topik like '%$kuncikunci%' OR keyword like '%$kuncikunci%')",NULL,FALSE);
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('tv.modified','desc');

		$isiwhere = "(judul like '%".$kuncikunci."%'";
		for ($a=0;$a<count($keywordsMany);$a++) {
			$isiwhere = $isiwhere . " OR judul like '%".$keywordsMany[$a]."%'";
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

	public function search_Sekolah($title,$npsn){
		$this->db->like('nama_paket', $title , 'both');
		$this->db->order_by('nama_paket', 'ASC');
		$this->db->where('durasi_paket<>','00:00:00');
		if ($npsn=="lain")
		{
			$npsnku = $this->session->userdata('npsn');
			$this->db->where('npsn_user<>',$npsnku);
		}
		else
		{
			$this->db->where('npsn_user',$npsn);
		}

		$this->db->group_by('nama_paket');
		$this->db->limit(10);
		return $this->db->get('tb_paket_channel')->result();
	}

    public function jmlChnSekolah(){
        $this->db->from('daf_chn_sekolah');
        $this->db->where('status',1);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;
    }

	public function getDafPlayListSekolah($npsn,$iduser,$kodebeli,$jenjang=null,$kelas=null,$mapel=null,$cari=null)
	{
		$mynpsn = $this->session->userdata('npsn');
		if ($npsn=="saya" || $npsn==$mynpsn)
		{
			$npsn=$mynpsn;
			$jenis = 1;
		}
		else
		{
			$jenis = 2;
		}

		$this->db->select('tpc.*, tcv.*, tv.*,tk.link_paket,tj.dikeranjang');
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		if ($this->session->userdata('a01') || ($this->session->userdata('sebagai')==4 &&
				$this->session->userdata('verifikator')==3))
		{
			$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "'.
				$kodebeli.'" AND tk.jenis_paket = '.$jenis,'left');
		}
		else
		{
			$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "'.
				$kodebeli.'" AND tk.jenis_paket = '.$jenis.' AND tk.id_user = '.$iduser,'left');
		}

		$this->db->join('tb_vk_keranjang tj', 'tj.link_list = tpc.link_list AND tj.jenis_paket = '.$jenis.
			' AND tj.kode_beli = "'. $kodebeli.'" AND tj.id_user = '.$iduser,'left');
//		$this->db->where('(urutan=0 OR urutan=1)');
		$this->db->where('status_paket',2);
		if ($this->session->userdata('a01') || ($this->session->userdata('sebagai')==4 &&
				$this->session->userdata('verifikator')==3))
		{
			//boleh lihat semua npsn
		}
		else
		{
			if ($jenis == 1)
			$this->db->where('tpc.npsn_user',$npsn);
			else if ($jenis == 2)
				$this->db->where('tpc.npsn_user!=',$mynpsn);
		}

		if ($jenjang!=null && $jenjang!=0)
			$this->db->where('(tpc.id_jenjang=' . $jenjang . ')');
		if ($kelas!=null && $kelas!=0)
			$this->db->where('(tpc.id_kelas=' . $kelas . ')');
		if ($mapel!=null && $mapel!=0)
			$this->db->where('(tpc.id_mapel=' . $mapel . ')');
		if ($cari!=null)
			$this->db->where('(tpc.nama_paket LIKE "%' . $cari . '%")');
		$this->db->group_by('nama_paket');
		$this->db->order_by('link_paket', 'desc');
		$this->db->order_by('statussoal', 'desc');
		$this->db->order_by('statustugas', 'desc');
		$this->db->order_by('status_paket', 'asc');
		$this->db->order_by('tanggal_tayang', 'desc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafPlayListSekolahRev($npsn,$linklist,$hal,$kodebeli=null,$iduser=null,$idjenjang=null, $idkelas=null, $idmapel=null,$cari=null)
	{
		if ($linklist==null)
		$linklist = "";
		$mynpsn = $this->session->userdata('npsn');
		if ($npsn=="saya" || $npsn==$mynpsn)
		{
			$npsn=$mynpsn;
			$jenis = 1;
		}
		else
		{
			$jenis = 2;
		}

		$this->db->select('tpc.*, tcv.*, tv.*,tk.link_paket,tj.dikeranjang');
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		if ($this->session->userdata('a01') || ($this->session->userdata('sebagai')==4 &&
				$this->session->userdata('verifikator')==3))
		{
			$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "'.
				$kodebeli.'" AND tk.jenis_paket = '.$jenis,'left');
		}
		else
		{
			$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "'.
				$kodebeli.'" AND tk.jenis_paket = '.$jenis.' AND tk.id_user = '.$iduser,'left');
		}
		$this->db->join('tb_vk_keranjang tj', 'tj.link_list = tpc.link_list AND tj.jenis_paket = '.$jenis.
			' AND tj.kode_beli = "'. $kodebeli.'" AND tj.id_user = '.$iduser,'left');
//		$this->db->where('(urutan=0 OR urutan=1)');
		$this->db->where('status_paket',2);
		$this->db->where('tv.id_video IS NOT NULL');
		if ($this->session->userdata('a01') || ($this->session->userdata('sebagai')==4 &&
				$this->session->userdata('verifikator')==3))
		{
			//semua npsn bisa dlihat
		}
		else{
			if($jenis == 1)
				$this->db->where('tpc.npsn_user',$npsn);
			else if ($jenis == 2)
				$this->db->where('tpc.npsn_user!=',$mynpsn);
		}


		if ($linklist!=null)
		$this->db->where('tpc.link_list',$linklist);
		if ($idjenjang!=null && $idjenjang!=0)
			$this->db->where('(tpc.id_jenjang=' . $idjenjang . ')');
		if ($idkelas!=null && $idkelas!=0)
			$this->db->where('(tpc.id_kelas=' . $idkelas . ')');
		if ($idmapel!=null && $idmapel!=0)
			$this->db->where('(tpc.id_mapel=' . $idmapel . ')');
		if ($cari!=null)
			$this->db->where('(tpc.nama_paket LIKE "%' . $cari . '%")');
//		$this->db->where('tk.kode_beli',$kodebeli);
//		$this->db->where('tk.id_user',$iduser);
//		if ($cari!=null)
//			$this->db->where('(tpc.nama_paket LIKE "%' . $cari . '%" OR tpc.keyword LIKE "%' . $cari . '%")');
		if ($hal!="semua")
		$this->db->limit(10,($hal*10)-10);
		$this->db->group_by('nama_paket');
		$this->db->order_by('link_paket', 'desc');
		$this->db->order_by('statussoal', 'desc');
		$this->db->order_by('statustugas', 'desc');
		$this->db->order_by('status_paket', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafPlayListSekolahAll($npsn,$linklist,$hal,$kodebeli=null,$iduser=null)
	{
		if ($linklist==null)
		$linklist = "";
		$mynpsn = $this->session->userdata('npsn');
		if ($npsn=="saya" || $npsn==$mynpsn)
		{
			$npsn=$mynpsn;
			$jenis = 1;
		}
		else
		{
			$jenis = 2;
		}

		$this->db->select('tpc.*, tcv.*, tv.*,tk.link_paket,tj.dikeranjang');
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		if ($this->session->userdata('a01') || ($this->session->userdata('sebagai')==4 &&
				$this->session->userdata('verifikator')==3))
		{
			$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "'.
				$kodebeli.'" AND tk.jenis_paket = '.$jenis,'left');
		}
		else
		{
			$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "'.
				$kodebeli.'" AND tk.jenis_paket = '.$jenis.' AND tk.id_user = '.$iduser,'left');
		}
		$this->db->join('tb_vk_keranjang tj', 'tj.link_list = tpc.link_list AND tj.jenis_paket = '.$jenis.
			' AND tj.kode_beli = "'. $kodebeli.'" AND tj.id_user = '.$iduser,'left');
//		$this->db->where('(urutan=0 OR urutan=1)');
		$this->db->where('status_paket',2);
		$this->db->where('tv.id_video IS NOT NULL');
		if ($this->session->userdata('a01') || ($this->session->userdata('sebagai')==4 &&
				$this->session->userdata('verifikator')==3))
		{
			//semua npsn bisa dlihat
		}
		else{
			if($jenis == 1)
				$this->db->where('tpc.npsn_user',$npsn);
			else if ($jenis == 2)
				$this->db->where('tpc.npsn_user!=',$mynpsn);
		}


		if ($linklist!=null)
			$this->db->where('tpc.link_list',$linklist);
//		$this->db->where('tk.kode_beli',$kodebeli);
//		$this->db->where('tk.id_user',$iduser);
//		if ($cari!=null)
//			$this->db->where('(tpc.nama_paket LIKE "%' . $cari . '%" OR tpc.keyword LIKE "%' . $cari . '%")');
		if ($hal!="semua")
			$this->db->limit(10,($hal*10)-10);
		$this->db->group_by('nama_paket');
		$this->db->order_by('link_paket', 'desc');
		$this->db->order_by('statussoal', 'desc');
		$this->db->order_by('statustugas', 'desc');
		$this->db->order_by('status_paket', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPlayListSekolah($link_list,$idsaya=null)
	{
		$this->db->from('tb_channel_video tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_channel tpc', 'tpc.id = tcv.id_paket', 'left');
		//$this->db->where('(tv.id_user=' . $idsaya . ')');
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(tpc.link_list="' . $link_list . '")');
		$this->db->where('(tv.status_verifikasi_admin=4)');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPlayListSekolahAll($link_list)
	{
		$this->db->select("tv.*");
		$this->db->from('tb_channel_video tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_channel tpc', 'tpc.id = tcv.id_paket', 'left');
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
		$this->db->select('tp.*, tu.first_name, tu.last_name, tu.email, tu.npsn');
		$this->db->from('tb_paket_channel tp');
		$this->db->join('tb_user tu', 'tp.id_user = tu.id', 'left');
		$this->db->where('link_list', $linklist);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getSoal($id)
	{
		$this->db->from('tb_soal_guru');
		$this->db->where('id_paket', $id);
		$result = $this->db->get()->result();
		return $result;
	}

	public function updategbrsoal($namafile, $id, $fielddb){
		$data = array(
			$fielddb => $namafile
		);
		$this->db->where('id_soal', $id);
		return $this->db->update('tb_soal_guru', $data);
	}

	public function updatesoal($data, $id){
		$this->db->where('id_soal', $id);
		return $this->db->update('tb_soal_guru', $data);
	}

	public function insertsoal($id)
	{
		$data['id_paket'] = $id;
		$this->db->insert('tb_soal_guru', $data);
		$insertid = $this->db->insert_id();
		return $insertid?$insertid:0;
	}

	public function delsoal($id)
	{
		$this->db->where('(id_soal='.$id.')');
		return $this->db->delete('tb_soal_guru');
	}

	public function updateseting($data, $linklist){
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel', $data);
	}

	public function ceknilai($linklist,$iduser)
	{
		$this->db->from('tb_soal_guru_nilai');
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
			$this->db->insert('tb_soal_guru_nilai', $data);
			$this->db->from('tb_soal_guru_nilai');
			$this->db->where('(linklist="' . $linklist . '" AND iduser='.$iduser.')');
			$query = $this->db->get();
			$ret = $query->row();
			return $ret;
		}
	}

	public function updatenilai($data,$linklist,$iduser){
		$this->db->where('(linklist="' . $linklist . '" AND iduser='.$iduser.')');
		return $this->db->update('tb_soal_guru_nilai', $data);
	}

	public function updatemateri($data,$linklist)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel', $data);
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

	public function getkeranjang($id_user,$jenis,$kodebeli)
	{
		$this->db->from('tb_vk_keranjang');
		$this->db->where('id_user', $id_user);
		$this->db->where('jenis_paket', $jenis);
		$this->db->where('kode_beli', $kodebeli);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getTugas($tipepaket,$linklist)
	{
		$this->db->select('*');
		$this->db->from('tb_tugas_guru tg');
		$this->db->join('tb_paket_channel tp', 'tg.link_list = tp.link_list', 'left');
		$this->db->where('tg.link_list', $linklist);
		$this->db->where('tipe_paket', $tipepaket);
		$this->db->where('status', 1);
		$this->db->order_by('tgl_mulai', 'asc');
		$result = $this->db->get()->last_row();
		if ($result)
			return $result;
		else
			return 0;
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

	public function addTugasSiswa($data)
	{
		$this->db->insert('tb_tugas_siswa', $data);
	}

	public function insertvk($id,$jenis,$data)
	{
		if ($this->db->insert_batch('tb_virtual_kelas', $data))
		{
		$this->db->where('id_user', $id);
		$this->db->where('jenis_paket', $jenis);
		$this->db->delete('tb_vk_keranjang');
		return true;
		}
		else
			return false;
	}

	public function insertvk_sekolah($data)
	{
		$this->db->insert_batch('tb_virtual_kelas', $data);
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

	public function addBayarPaket($data)
	{
		$this->db->insert('tb_vk_beli', $data);
	}

	public function update_vk_beli($data, $iduser, $orderid)
	{
		$this->db->where('id_user', $iduser);
		$this->db->where('kode_beli', $orderid);
		return $this->db->update('tb_vk_beli', $data);
	}

	public function getPaketGuru($id_user)
	{
		$this->db->select('*,IF(modulke=0,100,modulke) as modulke, MAX(IF(status_verifikasi=3,9,IF(status_verifikasi=0,9,status_verifikasi))) as status_max,
		dk.nama_kelas,dm.nama_mapel');
		$this->db->from('tb_paket_channel tp');
		$this->db->join('daf_kelas dk','dk.id = tp.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tp.id_mapel','left');
		$this->db->join('tb_channel_video tc','tc.id_paket = tp.id','left');
		$this->db->join('tb_video tv','tv.id_video = tc.id_video','left');
		$this->db->where('tp.id_user', $id_user);
		$this->db->group_by('tp.id');
		$this->db->order_by('tp.id_kelas', 'asc');
		$this->db->order_by('tp.semester', 'asc');
		$this->db->order_by('tp.id_mapel', 'asc');
		$this->db->order_by('modulke', 'asc');
		$this->db->order_by('tanggal_tayang', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPaketSekolah($npsn)
	{
		$this->db->select('*,IF(modulke=0,100,modulke) as modulke,dk.nama_kelas,dm.nama_mapel');
		$this->db->from('tb_paket_channel tp');
		$this->db->join('daf_kelas dk','dk.id = tp.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tp.id_mapel','left');
		$this->db->join('tb_user tu','tp.id_user = tu.id','left');
		$this->db->where('npsn_user', $npsn);
		$this->db->where('id_kelas<>', 0);
		$this->db->where('tp.durasi_paket<>', "00:00:00");
		$this->db->where('((tp.nama_paket="UTS" OR tp.nama_paket="UAS" OR tp.nama_paket="REMEDIAL UTS"
		OR tp.nama_paket="REMEDIAL UAS") OR modulke>0)');
		// $this->db->where('id_event', 0);
		$this->db->order_by('id_kelas', 'asc');
		$this->db->order_by('semester', 'asc');
		$this->db->order_by('modulke', 'asc');
		$this->db->order_by('id_mapel', 'asc');
		$this->db->order_by('id_user', 'asc');
		$this->db->order_by('tanggal_tayang', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function countJumlahMapelKelas($npsn)
	{
		$this->db->from('tb_paket_channel tp');
		$this->db->where('npsn_user', $npsn);
		$this->db->where('id_event', 0);
		$this->db->group_by('id_kelas', 'asc');
		$this->db->order_by('semester', 'asc');
		$this->db->order_by('id_mapel', 'asc');
		$this->db->order_by('modulke', 'asc');
		$this->db->order_by('tanggal_tayang', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getModul($modulke, $iduser, $semester, $adamentor = null)
	{
		$this->db->from('tb_paket_channel tp');
		$this->db->join('daf_mapel dm','dm.id = tp.id_mapel','left');
		$this->db->where('modulke', $modulke);
		$this->db->where('id_user', $iduser);
		$this->db->where('semester', $semester);
		$this->db->where('(((nama_paket="UTS" OR nama_paket="UAS" OR nama_paket="REMEDIAL UTS" 
		OR nama_paket="REMEDIAL UAS") AND statussoal=1) OR (uraianmateri<>"" AND statustugas=1 
		AND statussoal=1))');
		if ($adamentor!=null)
		$this->db->where('statusmentor', 2);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getModulEventMentor($dari, $ke, $semester, $tahun = null)
	{
		$this->db->from('tb_paket_channel tp');
		$this->db->join('daf_mapel dm','dm.id = tp.id_mapel','left');
		$this->db->join('daf_kelas dk','dk.id = tp.id_kelas','left');
		$this->db->where('(modulke>='.$dari.' AND modulke<='.$ke.')');
		$this->db->where('(modulke<>0)');
		$this->db->where('id_user', $this->session->userdata('id_user'));
		$this->db->where('semester', $semester);
		if ($tahun!=null)
			$this->db->where('tahun', $tahun);
		$this->db->order_by('modulke');
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekModulPilihan($iduser, $npsn = null, $idmapel = null)
	{
		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
		$bulan = $tglsekarang->format("n");
		$tahun = $tglsekarang->format("Y");
		if ($bulan>=7)
			{
				$batas1 = $tahun."-07-01 00:00:00";
				$batas2 = ($tahun+1)."-06-30 23:59:59";
			}
		else
		{
			$batas1 = ($tahun-1)."-07-01 00:00:00";
			$batas2 = $tahun."-06-30 23:59:59";
		}

		$this->db->from('tb_vk_pilihguru te');
		$this->db->where('(created>="'.$batas1.'" AND created<="'.$batas2.'")');
		$this->db->where('id_user', $iduser);
		if ($idmapel!=null)
		{
			$this->db->where('npsn_sekolah', $npsn);
			$this->db->where('id_mapel', $idmapel);
		}
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekModulbyLink($iduser, $linklist)
	{
		$this->db->from('tb_paket_channel');
		$this->db->where('id_user', $iduser);
		$this->db->where('link_list', $linklist);
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function updateModulPilihan($iduser, $npsn, $idmapel, $idguru) {
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$this->db->where('id_user', $iduser);
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('id_mapel', $idmapel);
		$data = array (
			'id_guru' => $idguru,
			'modified' => $tglsekarang
		);
		return $this->db->update('tb_vk_pilihguru', $data);
	}

	public function addModulPilihan($iduser, $npsn, $idmapel, $idguru){
    	$data = array('id_user'=>$iduser, 'npsn_sekolah'=>$npsn, 'id_guru'=>$idguru, 'id_mapel'=>$idmapel);
		$this->db->insert('tb_vk_pilihguru', $data);
	}

	public function getModulAda($npsn, $iduser, $idkelas)
	{
		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
		$bulan = $tglsekarang->format("n");
		$tahun = $tglsekarang->format("Y");
		if ($bulan>=7)
		{
			$batas1 = $tahun.'-07-01 00:00:00';
			$batas2 = ($tahun+1).'-06-30 23:59:59';
		}
		else
		{
			$batas1 = ($tahun-1).'-07-01 00:00:00';
			$batas2 = $tahun.'-06-30 23:59:59';
		}

		$joinnya = "te.id_user = '".$iduser."' AND te.id_guru = tp.id_user AND te.id_mapel = tp.id_mapel 
		AND te.created>='$batas1' AND te.created<='$batas2'";

		$this->db->select('tp.*, dm.id as idmapel,dm.nama_mapel,tu.id as idguru,tu.first_name,
		tu.last_name,te.id_user as iduserpilih');
		$this->db->from('tb_paket_channel tp');
		$this->db->join('daf_mapel dm','dm.id = tp.id_mapel','left');
		$this->db->join('tb_user tu','tu.id = tp.id_user','left');
		$this->db->join('tb_vk_pilihguru te',$joinnya,'left');
		$this->db->where('npsn_user', $npsn);
		$this->db->where('modulke>', 0);
		$this->db->where('tp.id_kelas', $idkelas);
//		$this->db->where('(te.created>="'.$batas1.'" AND te.created<="'.$batas2.'")');
		$this->db->group_by(array("tp.id_mapel", "tp.id_user"));

		$result = $this->db->get()->result();
		return $result;
	}

	public function getModulMapel($npsn)
	{
		$this->db->from('tb_paket_channel tp');
		$this->db->where('npsn_user', $npsn);
		$this->db->where('modulke>', 0);
		$this->db->group_by("tp.id_mapel");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafModulSaya($idsaya, $modulke = null, $linklist = null, $semester = null)
	{
		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
		$bulan = $tglsekarang->format("n");
		$tahun = $tglsekarang->format("Y");
		if ($bulan>=7)
		{
			$batas1 = $tahun."-07-01 00:00:00";
			$batas2 = ($tahun+1)."-06-30 23:59:59";
		}
		else
		{
			$batas1 = ($tahun-1)."-07-01 00:00:00";
			$batas2 = $tahun."-06-30 23:59:59";
		}
		$joinnya = "te.id_guru = tpc.id_user AND te.id_mapel = tpc.id_mapel  
		AND te.created>='$batas1' AND te.created<='$batas2'";
		//$this->db->select('*,tu2.first_name as first_nameguru,tu2.last_name as last_nameguru');
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('daf_mapel dm','dm.id = tpc.id_mapel','left');
		$this->db->join('tb_vk_pilihguru te', $joinnya, 'both');
		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->join('tb_user tu', 'tu.id = tpc.id_user', 'left');
		$this->db->join('tb_user tu2', 'tu2.id = te.id_guru', 'left');
		if ($modulke>0)
			$this->db->where('modulke',$modulke);
		$this->db->where('(te.id_user=' . $idsaya . ')');
		if ($linklist!=null)
			$this->db->where('tpc.link_list=',$linklist);
		if ($semester!="semua")
			$this->db->where('semester', $semester);
		else
			if ($this->session->userdata('sebagai')==2)
			{
				$this->db->where('(semester=1 OR semester=2)');
			}

		$this->db->group_by("tpc.link_list");

		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafModulSayaSemua($idsaya)
	{
		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
		$bulan = $tglsekarang->format("n");
		$tahun = $tglsekarang->format("Y");
		if ($bulan>=7)
		{
			$batas1 = $tahun."-07-01 00:00:00";
			$batas2 = ($tahun+1)."-06-30 23:59:59";
		}
		else
		{
			$batas1 = ($tahun-1)."-07-01 00:00:00";
			$batas2 = $tahun."-06-30 23:59:59";
		}
		$joinnya = "te.id_guru = tpc.id_user AND te.id_mapel = tpc.id_mapel  
		AND te.created>='$batas1' AND te.created<='$batas2'";
		//$this->db->select('*,tu2.first_name as first_nameguru,tu2.last_name as last_nameguru');
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_virtual_kelas tk','tk.link_paket = tpc.link_list','left');
		$this->db->join('daf_kelas dk','dk.id = tpc.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tpc.id_mapel','left');
		$this->db->join('tb_vk_pilihguru te', $joinnya, 'left');
		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->join('tb_user tu', 'tu.id = tpc.id_user', 'left');
		$this->db->join('tb_user tu2', 'tu2.id = te.id_guru', 'left');
		$this->db->where('(tk.id_user=' . $idsaya . ')');
		$this->db->group_by("tpc.link_list");
		$this->db->order_by('tpc.id_kelas', 'desc');
		$this->db->order_by('tpc.semester', 'desc');
		$this->db->order_by('tpc.modulke', 'asc');
		$this->db->order_by('tpc.id_mapel', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekGuruModul($idsaya)
	{
		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
		$bulan = $tglsekarang->format("n");
		$tahun = $tglsekarang->format("Y");
		if ($bulan>=7)
		{
			$batas1 = $tahun."-07-01 00:00:00";
			$batas2 = ($tahun+1)."-06-30 23:59:59";
		}
		else
		{
			$batas1 = ($tahun-1)."-07-01 00:00:00";
			$batas2 = $tahun."-06-30 23:59:59";
		}
		//$this->db->select('*,tu2.first_name as first_nameguru,tu2.last_name as last_nameguru');
		$this->db->from('tb_vk_pilihguru');
		$this->db->where('id_user', $idsaya);
		$this->db->where('(created>="'.$batas1.'" AND created<="'.$batas2.'")');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafUjianSaya($idsaya, $semester)
	{
		//$this->db->select('*,tu2.first_name as first_nameguru,tu2.last_name as last_nameguru');
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('daf_mapel dm','dm.id = tpc.id_mapel','left');
		$this->db->where('id_user', $idsaya);
		$this->db->where('semester', $semester);
		$this->db->where('(nama_paket = "UTS" OR nama_paket = "REMEDIAL UTS" '.
		'OR nama_paket = "UAS" OR nama_paket = "REMEDIAL UAS")');
		$this->db->order_by("modulke", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafUjianGuruSaya($idsaya, $semester = null)
	{
		//$this->db->select('*,tu2.first_name as first_nameguru,tu2.last_name as last_nameguru');
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_vk_pilihguru tvp','tvp.id_guru = tpc.id_user AND tvp.id_mapel = tpc.id_mapel','left');
		$this->db->join('daf_mapel dm','dm.id = tpc.id_mapel','left');
		$this->db->where('tvp.id_user', $idsaya);
		$this->db->where('semester', $semester);
		$this->db->where('(nama_paket = "UTS" OR nama_paket = "REMEDIAL UTS" '.
			'OR nama_paket = "UAS" OR nama_paket = "REMEDIAL UAS")');
		$this->db->order_by("modulke", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getStatusModulSaya($id_user, $modulke, $linklist)
	{
		$this->db->from('tb_vk_lihatmodulvideo');
		$this->db->where('id_user',$id_user);
		$this->db->where('modulke',$modulke);
		$this->db->where('link_list',$linklist);
		$result = $this->db->get()->result();
		return $result;
	}


	public function getDafModulGuru($linklist)
	{
		$this->db->from('tb_paket_channel tpc');
//		$this->db->join('tb_vk_pilihguru te', 'te.id_guru = tpc.id_user AND te.id_mapel = tpc.id_mapel', 'both');
//		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
//		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
//		$this->db->join('tb_user tu', 'tu.id = tpc.id_user', 'left');
		$this->db->where('link_list',$linklist);

		$result = $this->db->get()->result();
		return $result;
	}

	public function ceknilaisoal($iduser,$linklist)
	{
		$this->db->from('tb_soal_guru_nilai ts');
		$this->db->where('linklist',$linklist);
		$this->db->where('iduser',$iduser);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getlast_kdbeli($iduser, $jenis, $status = null)
	{
		$this->db->from('tb_vk_beli');
		$this->db->where('id_user', $iduser);
		$this->db->where('jenis_paket', $jenis);
		if ($status != null)
			$this->db->where('status_beli', $status);
		else
			$this->db->where('status_beli>', 0);
		$this->db->order_by('id');
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function resettglvicon($linklist)
	{
		$this->db->where('link_list', $linklist);
		$this->db->set('tglvicon',"2021-01-01 00:00:00");
		$this->db->set('koderoom',"");
		$this->db->set('kodepassvicon',"");
		$this->db->update('tb_paket_channel');

	}

	public function getAllNilaiLatihan($iduser, $modulke, $semester)
	{
		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
		$bulan = $tglsekarang->format("n");
		$tahun = $tglsekarang->format("Y");
		if ($bulan>=7)
		{
			$batas1 = $tahun."-07-01 00:00:00";
			$batas2 = ($tahun+1)."-06-30 23:59:59";
		}
		else
		{
			$batas1 = ($tahun-1)."-07-01 00:00:00";
			$batas2 = $tahun."-06-30 23:59:59";
		}

		if($modulke>16)
			$modulke=16;

		$joinnya = "te.id_guru = tpc.id_user AND te.id_mapel = tpc.id_mapel 
		AND te.created>='$batas1' AND te.created<='$batas2'";

		$this->db->from('tb_soal_guru_nilai ts');
		$this->db->join('tb_paket_channel tpc', 'tpc.link_list = ts.linklist', 'left');
		$this->db->join('tb_vk_pilihguru te', $joinnya, 'both');
		$this->db->join('daf_mapel dm','dm.id = te.id_mapel','left');
		$this->db->where('(ts.iduser=' . $iduser . ')');
		$this->db->where('(tpc.modulke>0)');
		$this->db->where('(tpc.modulke<=' . $modulke . ')');
		$this->db->where('(tpc.semester=' . $semester . ')');

		$this->db->order_by('tpc.modulke', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllNilaiTugas($iduser)
	{
		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
		$bulan = $tglsekarang->format("n");
		$tahun = $tglsekarang->format("Y");
		if ($bulan>=7)
		{
			$batas1 = $tahun."-07-01 00:00:00";
			$batas2 = ($tahun+1)."-06-30 23:59:59";
		}
		else
		{
			$batas1 = ($tahun-1)."-07-01 00:00:00";
			$batas2 = $tahun."-06-30 23:59:59";
		}

		$joinnya = "te.id_guru = tpc.id_user AND te.id_mapel = tpc.id_mapel 
		AND te.created>='$batas1' AND te.created<='$batas2'";

		$this->db->from('tb_tugas_siswa ts');
		$this->db->join('tb_tugas_guru tg', 'tg.id_tugas = ts.id_tugas','left');
		$this->db->join('tb_paket_channel tpc', 'tpc.link_list = tg.link_list', 'left');
		$this->db->join('tb_vk_pilihguru te', $joinnya, 'both');
		$this->db->join('daf_mapel dm','dm.id = te.id_mapel','left');
		$this->db->where('(ts.id_user=' . $iduser . ')');
		$this->db->where('(tpc.modulke>0)');

		$this->db->order_by('tpc.modulke', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekmodulujian($data)
	{
		$this->db->from('tb_paket_channel');
		$this->db->where('nama_paket',$data['nama_paket']);
		$this->db->where('id_jenjang',$data['id_jenjang']);
		$this->db->where('id_kelas',$data['id_kelas']);
		$this->db->where('id_mapel',$data['id_mapel']);
		$this->db->where('semester',$data['semester']);
		$result = $this->db->get()->result();
		return $result;

	}

	public function getsiswabayarvk($jenispaket=null, $npsn = null)
	{
		if ($npsn==null)
			$npsn = $this->session->userdata('npsn');
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$this->db->select('*,max(strata_paket) as strata_paket');
		$this->db->from('tb_vk_beli');
		$this->db->where('npsn_user', $npsn);
		if ($jenispaket!=null)
			$this->db->where('jenis_paket', $jenispaket);
		else
			$this->db->where('jenis_paket', 1);
		$this->db->where('strata_paket>=', 1);
		$this->db->where('tgl_batas>=', $tglsekarang);
		$this->db->where('status_beli', 2);
		$this->db->group_by('id_user');
		$this->db->order_by('id');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getsiswabayarekskul($npsn = null)
	{
		if ($npsn==null)
			$npsn = $this->session->userdata('npsn');
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$this->db->from('tb_payment');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('(SUBSTRING(order_id,1,2)="EK")');
		$this->db->where('tgl_berakhir>=', $tglsekarang);
		$this->db->where('status', 3);
		$this->db->order_by('id');
		$result = $this->db->get()->result();
		return $result;
	}

	public function get_vkbeli_berbayar()
	{
		$npsn = $this->session->userdata('npsn');
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$this->db->from('tb_payment');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('(SUBSTRING(order_id,1,2)="EK")');
		$this->db->where('tgl_berakhir>=', $tglsekarang);
		$this->db->where('status', 3);
		$this->db->order_by('id');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getModulPaketDariKe($dari, $ke, $semester, $mapel, $idguru, $adamentor=null)
	{
		//$this->db->select('*,tu2.first_name as first_nameguru,tu2.last_name as last_nameguru');
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_channel_video tc','tc.id_paket = tpc.id','left');
		$this->db->join('tb_video tv','tv.id_video = tc.id_video','left');
		$this->db->where('semester', $semester);
		$this->db->where('(modulke>='.$dari.' AND modulke<='.$ke.')');
		$this->db->where('tpc.id_mapel', $mapel);
		$this->db->where('tpc.id_user', $idguru);
		/////////SYARAT DIANGGAP LENGKAP/////////////////
		$this->db->where('(((nama_paket="UTS" OR nama_paket="UAS" OR nama_paket="REMEDIAL UTS" 
		OR nama_paket="REMEDIAL UAS") AND statussoal=1) OR (uraianmateri<>"" AND statustugas=1 
		AND statussoal=1 AND (tv.status_verifikasi=2 OR tv.status_verifikasi=4)))');
		if ($adamentor!=null)
		$this->db->where('statusmentor', 2);
		$this->db->group_by('tpc.id');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getSekolahModulPaketDariKe($dari, $ke, $semester, $idguru)
	{
		//$this->db->select('*,tu2.first_name as first_nameguru,tu2.last_name as last_nameguru');
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_user tu', 'tu.id = tpc.id_user','left');
		$this->db->join('daf_chn_sekolah ds', 'ds.npsn = tpc.npsn_user','left');
		$this->db->join('daf_kelas dk', 'dk.id = tpc.id_kelas', 'left');
        $this->db->join('daf_mapel dm', 'dm.id = tpc.id_mapel', 'left');
		$this->db->where('semester', $semester);
		$this->db->where('(modulke>='.$dari.' AND modulke<='.$ke.')');
		$this->db->where('id_user', $idguru);
		$this->db->group_by('tpc.id');
		$this->db->order_by('tpc.npsn_user');
		$this->db->order_by('tpc.id_user');
		$this->db->order_by('tpc.id_kelas');
		$this->db->order_by('tpc.semester');
		$this->db->order_by('tpc.id_mapel');
		$this->db->order_by('tpc.nama_paket');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getModulSaya($linkpaket)
	{
		$this->db->from('tb_virtual_kelas tv');
		$this->db->join('tb_paket_channel tpc', 'tpc.link_list = tv.link_paket','left');
		$this->db->where('link_paket',$linkpaket);
		$this->db->where('tv.id_user',$this->session->userdata('id_user'));

		$result = $this->db->get()->last_row();
		return $result;
	}

	public function cekKodeEventSaya($iduser, $bulan, $tahun)
	{
		$this->db->from('tb_modul_bulanan');
		$this->db->where('bulan',$bulan);
		$this->db->where('tahun',$tahun);
		$this->db->where('id_guru',$iduser);
		$result = $this->db->get()->last_row();
		if ($result)
			return $result;
		else
			return 'kosong';
	}

	public function addKodeEventSaya($data)
	{
		$this->db->from('tb_modul_bulanan');
		$this->db->where('id_guru',$data['id_guru']);
		$this->db->where('bulan',$data['bulan']);
		$this->db->where('tahun',$data['tahun']);
		$this->db->where('kode_event',$data['kode_event']);
		$result = $this->db->get()->result();
		if (!$result)
		return $this->db->insert('tb_modul_bulanan', $data);
	}

	public function cekKodeEventMentor($bulan, $tahun, $kodereferal)
	{
		$this->db->from('tb_mentor_event tm');
		$this->db->where('bulan',$bulan);
		$this->db->where('tahun',$tahun);
		if ($this->session->userdata('siam')==6)
			$this->db->where('kode_event',$kodereferal);
		else
			$this->db->where('kode_referal',$kodereferal);
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function updatesertifikatmentor($namaser,$emailser,$code,$iduser,$bulan,$tahun,$nomorurutan = null,$download = null)
	{
		$data = array();
		if ($namaser!=null)
			{
				$data['nama_sertifikat'] = $namaser;
				$data['email_sertifikat'] = $emailser;
			}
		if ($nomorurutan!=null)
			$data['urutan_nomor'] = $nomorurutan;
		if ($download!=null)
			$data['download_sertifikat'] = $download;
		$this->db->where('id_guru', $iduser);
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_event', $code);
		$this->db->update('tb_modul_bulanan', $data);
	}

	public function cekUserMentorEvent($code,$iduser,$bulan,$tahun)
	{
		$this->db->from('tb_modul_bulanan');
		// $this->db->join('tb_event te', 'te.code_event = tu.code_event','left');
		$this->db->where('(kode_event="'.$code.'" AND bulan="'.$bulan.'" AND tahun="'.$tahun.'" AND id_guru='.$iduser.')');
		$result = $this->db->get()->row();
		return $result;
	}

	public function ceknomorsertifikatakhir($code,$iduser,$bulan,$tahun)
	{
		$this->db->from('tb_modul_bulanan');
		$this->db->where('(kode_event="'.$code.'" AND bulan="'.$bulan.'" AND tahun="'.$tahun.'")');
		$this->db->where('urutan_nomor>0');
		$this->db->order_by('urutan_nomor','asc');
		$result = $this->db->get()->row();
		return $result;
	}
	
}
