<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_video extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function getVideo($id_video)
    {
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
        $this->db->where('kode_video', $id_video);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function delsafevideo($id_video)
    {
    	if ($this->session->userdata('a01'))
		{
			$this->db->where('(kode_video = ' . $id_video.')');
		}
        else if ($this->session->userdata('sebagai')==4) {
			$this->db->select('tb_video.id_video');
			$this->db->from('tb_video');
			$this->db->join('tb_user', 'tb_user.id = tb_video.id_user', 'left');
			$this->db->where('(kode_video = ' . $id_video . ' AND 
		(status_verifikasi=0 OR sebagai=4))');
			$where_clause = $this->db->get_compiled_select();

			$this->db->where("`id_video` IN ($where_clause)", NULL, FALSE);

        } else if ($this->session->userdata('kontributor')==3) {
			$this->db->select('tb_video.id_video');
			$this->db->from('tb_video');
			$this->db->join('tb_user', 'tb_user.id = tb_video.id_user', 'left');
			$this->db->where('(kode_video = ' . $id_video . ' AND 
		(status_verifikasi=0 OR sebagai=4) AND dilist = 0 AND dilist2 = 0)');
			$where_clause = $this->db->get_compiled_select();

			$this->db->where("`kode_video` IN ($where_clause)", NULL, FALSE);

		}
        else if ($this->session->userdata('verifikator')==3) {
			$this->db->select('tb_video.kode_video');
			$this->db->from('tb_video');
			$this->db->join('tb_user', 'tb_user.id = tb_video.id_user', 'left');
			$this->db->where('(kode_video = ' . $id_video . ' AND 
		npsn="'.$this->session->userdata('npsn').'")');
			$where_clause = $this->db->get_compiled_select();

			$this->db->where("`kode_video` IN ($where_clause)", NULL, FALSE);
		}
        else if ($this->session->userdata('verifikator')==2) {
			$this->db->select('tb_video.kode_video');
			$this->db->from('tb_video');
			$this->db->join('tb_user', 'tb_user.id = tb_video.id_user', 'left');
			$this->db->where('(kode_video = ' . $id_video . ' AND 
		npsn="'.$this->session->userdata('npsn').'")');
			$where_clause = $this->db->get_compiled_select();

			$this->db->where("`kode_video` IN ($where_clause)", NULL, FALSE);
		}
		else {
            $this->db->where('(kode_video = ' . $id_video . ' AND 
		id_user = ' . $this->session->userdata("id_user") . ' AND
		status_verifikasi=0)');
        }

//		$this->db->from('tb_video');
//		$result = $this->db->get()->row_array();

//		echo "<pre>";
//		echo var_dump($result);
//		echo "</pre>";
		//return $result;

        $this->db->delete('tb_video');

    }

    public function getVideoKomplit($id_video)
    {
        $this->db->select('tv.*,tu.npsn,nama_jenjang,dk.nama_kelas,dm.nama_mapel,dkt.nama_kategori,
        dkd1.nama_kd as nama_kd1_1, dkd2.nama_kd as nama_kd1_2, dkd3.nama_kd as nama_kd1_3,
        dkd4.nama_kd as nama_kd2_1, dkd5.nama_kd as nama_kd2_2, dkd6.nama_kd as nama_kd2_3');
        $this->db->from('tb_video tv');
        $this->db->join('daf_jenjang dj', 'dj.id = tv.id_jenjang', 'left');
        $this->db->join('daf_kelas dk', 'dk.id = tv.id_kelas', 'left');
        $this->db->join('daf_mapel dm', 'dm.id = tv.id_mapel', 'left');
        $this->db->join('daf_kd dkd1', 'dkd1.id = tv.id_kd1_1', 'left');
        $this->db->join('daf_kd dkd2', 'dkd2.id = tv.id_kd1_2', 'left');
        $this->db->join('daf_kd dkd3', 'dkd3.id = tv.id_kd1_3', 'left');
        $this->db->join('daf_kd dkd4', 'dkd4.id = tv.id_kd2_1', 'left');
        $this->db->join('daf_kd dkd5', 'dkd5.id = tv.id_kd2_2', 'left');
        $this->db->join('daf_kd dkd6', 'dkd6.id = tv.id_kd2_3', 'left');
        $this->db->join('daf_kategori dkt', 'dkt.id = tv.id_kategori', 'left');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
        $this->db->where('id_video', $id_video);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function getVideoUser($id_user)
    {
        $this->db->from('tb_video');
        $this->db->where('id_user', $id_user);
        $this->db->order_by('modified', 'desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getVideoVer1($npsn)
    {
        $this->db->from('tb_video tv');
//		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
//		$this->db->where('tu.npsn', $npsn);
//		$this->db->where('(tv.id_user <> "' . $this->session->userdata('userData')['id_user'] . '")');
//
//		$this->db->order_by('status_verifikasi', 'asc');
//		$this->db->order_by('tv.modified', 'desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getVideoAll($tipevideo=null,$event=null)
    {
    	if ($this->session->userdata('a01'))
			$this->db->select('tv.*,tu.*,tu.created as createduser');
    	else
        	$this->db->select('tv.*,tu.*,tu.created as createduser');

        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');

		if ($tipevideo!=null)
			$this->db->where('tv.tipe_video', $tipevideo);

		if ($this->session->userdata('a01'))
		{
//			$this->db->join('tb_payment tp', 'tu.npsn = tp.npsn_sekolah AND tp.status=3', 'left');
//			$this->db->group_by('tv.id_video');
			$this->db->order_by('tv.modified', 'desc');
			$this->db->order_by('tv.status_verifikasi', 'asc');
			if ($event=="semua")
				{
					$this->db->where('tv.id_event>', 0);
				}
				else
				{
				$this->db->where('tv.id_event', $event);
				}
		}
		else
		{
			$this->db->order_by('tv.modified', 'asc');
		}

        $result = $this->db->get()->result();
        return $result;
    }

	public function getVideoAllTes()
	{

		if ($this->session->userdata('a01'))
			$this->db->select('*');
		else
			$this->db->select('tv.*,tu.*,tu.created as createduser');

		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');

		$this->db->where('tv.tipe_video', 0);

		{
			$this->db->order_by('tv.modified', 'asc');
		}

		$result = $this->db->get()->result();
		return $result;
	}

	public function getVideobyEvent($idevent,$viaver=null,$sifat=null)
	{
		$this->db->select('tv.*,tu.*,tu.created as createduser,nama_sekolah');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->join('daf_chn_sekolah dc', 'dc.npsn = tu.npsn', 'left');
		$this->db->where('id_event', $idevent);
		if($this->session->userdata('sebagai')!=4 && $this->session->userdata('loggedIn'))
		{
			if($viaver!=2)
			$this->db->where('tu.npsn', $this->session->userdata('npsn'));
		}
			
		if ($viaver==0)
			$this->db->where('id_user', $this->session->userdata('id_user'));
		if ($sifat!=null)
			$this->db->where('tv.sifat', $sifat);
//		if($this->session->userdata('sebagai')==4)
//			$this->db->where('(tv.status_verifikasi=2 OR tv.status_verifikasi=4)');
		$this->db->group_by('tv.id_video');
		$this->db->order_by('tv.modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

    public function getVideoSekolah($npsn=null, $prodi=null, $opsi = null, $tipevideo = null, $statusverifikasi = null,
									$sifat = null, $kodekotaku = null)
    {
        $this->db->select('tv.*,tu.first_name as namadepan,tu.*,tu.created as createduser');
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.kd_user = tv.id_user', 'left');
		if ($npsn!=null)
        {
			$this->db->where('tv.npsn_user', $npsn);
			$this->db->where('tv.kd_prodi_user', $prodi);
		}
        if ($tipevideo!=null)
			$this->db->where('tv.tipe_video', $tipevideo);
		if ($sifat!=null)
			{
				$this->db->where('tv.sifat', $sifat);
				if ($sifat==2 && $opsi!="saya" && !$this->session->userdata('a01'))
					$this->db->where('tu.kd_kota', $kodekotaku);
				if ($sifat==2 && $this->session->userdata('a01'))
					$this->db->where('tu.kd_kota>0');
			}

        if($opsi=="saya")
			$this->db->where('tv.id_user', $this->session->userdata('id_user'));
        else if($opsi=="kontributor")
		{
			$this->db->order_by('tv.status_verifikasi', 'asc');
			$this->db->where('tv.id_user<>', $this->session->userdata('id_user'));
		}
		else if($opsi=="kontributorbimbel")
		{
			$this->db->order_by('tv.status_verifikasi_bimbel', 'asc');
			$this->db->where('tv.id_user<>', $this->session->userdata('id_user'));
		}
		if($statusverifikasi!=null)
		{
			if($opsi=="kontributorbimbel")
			{
				$this->db->where('tv.status_verifikasi_bimbel', $statusverifikasi);
				$this->db->where('tv.sifat', 2);
			}
			else
			{
				$this->db->where('tv.status_verifikasi', $statusverifikasi);
				$this->db->where('tv.sifat<>', 2);
			}
				
		}

        $this->db->order_by('tv.modified', 'desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getVideoAll2()
    {
        $this->db->from('tb_video');
        $result = $this->db->get()->result();
        return $result;
    }

    public function updateVideoAll($data)
    {
        $this->db->update_batch('tb_video', $data, 'id_video');
    }

    public function getVideoAllLain()
    {
        $this->db->from('tb_video tv');
        $this->db->where('(tv.id_user <> ' . $this->session->userdata('id_user') . ')');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
        $this->db->order_by('tv.status_verifikasi asc, tv.modified asc');
        $result = $this->db->get()->result();
        return $result;
    }

	public function getKurikulum($npsn=null)
	{
		$this->db->select('kurikulum');
		$this->db->from('daf_kd');
		$this->db->group_by('kurikulum');
		$result = $this->db->get()->result();
		return $result;
	}

    public function getAllJenjang()
    {
        $this->db->from('daf_jenjang');
        $this->db->where('(urutan>0)');
        $result = $this->db->get()->result();
        return $result;
    }

    public function dafMapel($idjenjang, $idjurusan = null)
    {
        $this->db->from('daf_mapel');
        $this->db->where('id_jenjang', $idjenjang);
        if ($idjurusan != null) {
            $this->db->where('c3', $idjurusan);
        }
        $result = $this->db->get()->result();
        return $result;
    }

    public function dafKD($npsn,$kurikulum,$idkelas, $idmapel, $idki)
    {
        $this->db->from('daf_kd');
		$this->db->where('npsn', $npsn);
		$this->db->where('kurikulum', $kurikulum);
        $this->db->where('id_kelas', $idkelas);
        $this->db->where('id_mapel', $idmapel);
        $this->db->where('id_ki', $idki);
        $result = $this->db->get()->result();
        return $result;
    }

    public function getAllKategori()
    {
        $this->db->from('daf_kategori');
        $result = $this->db->get()->result();
        return $result;
    }

    public function dafTema($idkelas)
    {
        $this->db->from('daf_tematik');
        $this->db->where('id_kelas', $idkelas);
        $result = $this->db->get()->result();
        return $result;
    }

    public function dafJurusan()
    {
        $this->db->from('daf_jurusan');
        $result = $this->db->get()->result();
        return $result;
    }

	public function dafFakultas()
	{
		$this->db->from('daf_fakultas');
		$result = $this->db->get()->result();
		return $result;
	}

	public function dafJurusanPT()
	{
		$this->db->from('daf_jurusanpt');
		$result = $this->db->get()->result();
		return $result;
	}



    public function dafKelas($idjenjang)
    {
        $this->db->from('daf_kelas');
        $this->db->where('id_jenjang', $idjenjang);
        $result = $this->db->get()->result();
        return $result;
    }

    function addVideo($data)
    {
        $this->db->insert('tb_video', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function editVideo($data, $idvideo)
    {
        $this->db->where('id_video', $idvideo);
        return $this->db->update('tb_video', $data);
    }

    function updateThumbs($idvideo, $namafilebaru)
    {
        $data = Array('thumbnail' => $namafilebaru);
        $this->db->where('id_video', $idvideo);
        return $this->db->update('tb_video', $data);
    }

    public function updateVerifikator($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update('tb_user', $data);
    }

    public function getAllPernyataan($idx)
    {
        $this->db->from('daf_penilaian' . $idx);
        $this->db->where('(nama_penilaian!="")');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getPenilaian($id_video, $datav)
    {
        $this->db->from('tb_penilaian' . $datav['no_verifikator']);
        $this->db->where('id_video', $id_video);
        $result = $this->db->get()->result_array();
        if ($result) {
            return $result;
        } else {
            $this->db->insert('tb_penilaian' . $datav['no_verifikator'], $datav);
            $this->db->from('tb_penilaian' . $datav['no_verifikator']);
            $this->db->where('id_video', $id_video);
            $result = $this->db->get()->result_array();
            return $result;
        }

    }

    public function updatenilai($data, $id)
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimezone('Asia/Jakarta'));
        $tglsekarang = $now->format('Y-m-d H:i:s');
        //$data['modified'] = $tglsekarang;

        $this->db->where('id_video', $id);
        return $this->db->update('tb_video', $data);
    }

    public function addlogvideo($data)
    {
        $this->db->insert('log_video', $data);
    }

    public function simpanverifikasi($data, $id)
    {
        $this->db->where('id_video', $id);
        // $this->db->from('tb_penilaian');
        // $hasil = $this->db->get()->row();
        // if($hasil->id_video>=1)
		// echo "<pre>";
		// echo var_dump($data);
		// echo "</pre>";
		// echo "<br>TB:".$data['no_verifikator'];	
		// die();

        $this->db->update('tb_penilaian' . $data['no_verifikator'], $data);
		
        //else
        //    $this->db->insert('tb_penilaian', $data);
    }

    public function updatejmlvidsekolah($npsn, $prodi)
    {
        $this->db->select('tv.*,tu.*,tu.created as createduser');
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
        $this->db->where('tv.npsn_user', $npsn);
        $this->db->where('tv.kd_prodi_user', $prodi);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        $data = array('jml_video' => $rowcount);
        $this->db->where('npsn_sekolah', $npsn);
        $this->db->where('kd_prodi', $prodi);
        $this->db->update('daf_chn_sekolah', $data);
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
		$this->db->order_by("status", "desc");
		$this->db->order_by("tgl_mulai", "desc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getEventbyCode($kode)
	{
		$this->db->from('tb_event');
		$this->db->where('code_event', $kode);
		$result = $this->db->get()->result();
		return $result;
	}


	public function getAllEventAktif($link=null,$asal=null)
	{
		if ($link!=null)
		{
			$this->db->where('link_event', $link);
		}

		if (!isset($this->session->userdata['npsn']))
		{
			$iduserku="2";
		}
		else
		{
			$iduserku=$this->session->userdata('id_user');
		}

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$this->db->select('te.*,tu.download_sertifikat,tu.status_user,tu.npsn,tu.filedok,tu.tgl_konfirm,
		tu.id_user,tu.nama_sertifikat,tu.email_sertifikat,tu.tgl_bayar,tu.tipebayar,tu.nama_bank,tu.no_rek');
		$this->db->from('tb_event te');
		$this->db->join('tb_userevent tu', 'te.code_event = tu.code_event AND tu.id_user = "'.
			$iduserku.'"','left');
		if ($this->session->userdata('a01'))
		{
			if ($asal=="acara")
			$this->db->where('te.status>=', 1);
		}
		else
		{
			$this->db->where('te.status>=', 1);
		}

		$this->db->where('viaverifikator', 0);
		if (isset($this->session->userdata['email'])) {
			if ($this->session->userdata('a01') && $asal==null) {

			} else {
				$this->db->where('(tgl_mulai<="' . $tglsekarang . '")');
				$this->db->where('(tgl_selesai>="' . $tglsekarang . '")');
			}
		}
		else
			{
				$this->db->where('(tgl_mulai<="' . $tglsekarang . '")');
				$this->db->where('(tgl_selesai>="' . $tglsekarang . '")');
			}

		$query1 = $this->db->get_compiled_select();

		//////////////////////////////////////////////////////////////////////
		if ($link!=null)
		{
			$this->db->where('link_event', $link);
		}

		if (!isset($this->session->userdata['npsn']))
		{
			$npsnku="999";
		}
		else
		{
			$npsnku=$this->session->userdata('npsn');
		}

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d');

		$this->db->select('te.*,tu.download_sertifikat,tu.status_user,tu.npsn,tu.filedok,tu.tgl_konfirm,
		tu.id_user,tu.nama_sertifikat,tu.email_sertifikat,tu.tgl_bayar,tu.tipebayar,tu.nama_bank,tu.no_rek');
		$this->db->from('tb_event te');
		$this->db->join('tb_userevent tu', 'te.code_event = tu.code_event AND tu.npsn = "'.
			$npsnku.'"','left');
		$this->db->where('te.status', 1);
		$this->db->where('viaverifikator', 1);
		if (isset($this->session->userdata['email'])) {
			if ($this->session->userdata('a01')) {

			} else {
				$this->db->where('(tgl_mulai<="' . $tglsekarang . '")');
				$this->db->where('(tgl_selesai>="' . $tglsekarang . '")');
			}
		}
		else
		{
			$this->db->where('(tgl_mulai<="' . $tglsekarang . '")');
			$this->db->where('(tgl_selesai>="' . $tglsekarang . '")');
		}
		$this->db->order_by("tgl_mulai", "desc");
		$query2 = $this->db->get_compiled_select();

		$query = $this->db->query($query1 . ' UNION ' . $query2);
		$query = $query->result();

		return $query;
	}

	public function cekEventAktifbyLink($link_event,$cekviaver=null)
	{
		if (!isset($this->session->userdata['npsn']))
		{
			$npsnku="999";
		}
		else
		{
			$npsnku=$this->session->userdata('npsn');
		}

		$this->db->select('te.*,tu.status_user');
		$this->db->from('tb_event te');
		////SEMENTARA NPSN DI TU diabaikan
		///
//		$this->db->join('tb_userevent tu', 'te.code_event = tu.code_event AND tu.npsn = "'.
//			$npsnku.'"','left');
		$this->db->join('tb_userevent tu', 'te.code_event = tu.code_event','left');
		$this->db->where('status', 1);
		$this->db->where('status_user', 2);
		$this->db->where('link_event', $link_event);
		if ($this->session->userdata('sebagai')!=4 && $cekviaver)
		$this->db->where('npsn', $this->session->userdata('npsn'));
		$result = $this->db->get()->result();
		return $result;
	}

	public function getbyCodeEvent($kode, $iduser=null)
	{
		if (!isset($this->session->userdata['npsn']))
		{
			$npsnku="999";
		}
		else
		{
			$npsnku=$this->session->userdata('npsn');
		}
		$this->db->select('te.*,tu.status_user,tu.order_id,tu.nama_bank,tu.no_rek,tu.tgl_bayar,tu.petunjukbayar');
		$this->db->from('tb_event te');
		if ($iduser!=null)
			$this->db->join('tb_userevent tu', 'te.code_event = tu.code_event AND tu.id_user = "'.
				$iduser.'"','left');
		else
			$this->db->join('tb_userevent tu', 'te.code_event = tu.code_event AND tu.npsn = "'.
				$npsnku.'"','left');
		$this->db->where('te.code_event',$kode);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getbyLinkEvent($link)
	{
		$this->db->from('tb_event');
		$this->db->where('link_event',$link);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllbyIdEvent()
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format("Y-m-d H:i:s");

		$this->db->from('tb_event');
		$this->db->where('tgl_selesai>=', $tglsekarang);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllUserEvent($codeevent,$opsi=null)
	{
		$this->db->select('tu.*,tt.*,dk.nama_kota,dp.nama_propinsi,tv.id_video,tv.link_video');
//		$this->db->select('tu.*,tt.*,df.*,dk.nama_kota');
		$this->db->from('tb_userevent tu');
		$this->db->join('tb_user tt', 'tt.id = tu.id_user','left');
		$this->db->join('daf_kota dk', 'dk.id_kota = tt.kd_kota','left');
		$this->db->join('daf_propinsi dp', 'dp.id_propinsi = tt.kd_provinsi','left');
		$this->db->join('tb_event te', 'te.code_event= tu.code_event','left');
		$this->db->join('tb_video tv', 'tv.id_event = te.id_event AND tv.id_user = tu.id_user','left');

		$this->db->where('tu.code_event', $codeevent);
		if ($opsi==1)
			$this->db->where('(status_user=3)');
		else {
			$this->db->where('(status_user=2)');
			$this->db->where('(tu.npsn<>"10000001" AND tu.npsn<>"1000000001" AND tu.npsn<>"10000010")', null, false);
		}

		$this->db->order_by("tgl_bayar", "desc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllNarsum($codeevent)
	{
		$this->db->select('tu.*,tt.*,dk.nama_kota,dp.nama_propinsi');
//		$this->db->select('tu.*,tt.*,df.*,dk.nama_kota');
		$this->db->from('tb_user tt');
		$this->db->join('tb_userevent tu', 'tt.id = tu.id_user','left');
		$this->db->join('daf_kota dk', 'dk.id_kota = tt.kd_kota','left');
		$this->db->join('daf_propinsi dp', 'dp.id_propinsi = tt.kd_provinsi','left');
		$this->db->where('(tt.golongan=1 OR tt.sebagai=4)');
		$this->db->group_by('tt.id');
		$this->db->order_by("golongan", "desc");
		$this->db->order_by("first_name", "asc");

		$result = $this->db->get()->result();
		return $result;
	}

	public function cekUserEvent($code,$iduser,$semuastatus=null)
	{
		$this->db->from('tb_userevent tu');
		$this->db->join('tb_event te', 'te.code_event = tu.code_event','left');
		$this->db->where('(tu.code_event="'.$code.'" AND id_user='.$iduser.')');
		if ($semuastatus==null)
			$this->db->where('(status_user=2 OR status_user=3)');
		else
			$this->db->where('(status_user<='.$semuastatus.')');
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekUserLinkEvent($param,$iduser,$semuastatus=null)
	{
		$this->db->from('tb_userevent tu');
		$this->db->join('tb_event te', 'te.code_event = tu.code_event','left');
		$this->db->where('(te.link_event="'.$param.'" AND id_user='.$iduser.')');
		if ($semuastatus==null)
			$this->db->where('(status_user=2 OR status_user=3)');
		else
			$this->db->where('(status_user='.$semuastatus.')');
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

	public function get_url_live(){
		$this->db->from('tb_live');
		$result = $this->db->get()->row();
		return $result;
	}

	public function get_acara_live($harike){
		$this->db->where('harike', 0);
		$this->db->from('tb_live_acara');
		$result = $this->db->get()->result();
		return $result;
	}

	public function addevent($data){
		$this->db->insert('tb_event', $data);
		$insertid = $this->db->insert_id();
//		$random = substr($data['code_event'],0,3);
//		rename('uploads/event/dok0.pdf','uploads/event/dok_'.$random.'_'.$insertid.'.pdf');
//		rename('uploads/event/image0.jpg','uploads/event/img_'.$random.'_'.$insertid.'.jpg');
	}



	public function updatetglbayarevent($kode,$iduser,$data){
		$this->db->where('code_event', $kode);
		$this->db->where('id_user', $iduser);
		$this->db->update('tb_userevent', $data);
	}

	public function updatetglbayareventorder($orderid,$iduser,$data){
		$this->db->where('order_id', $orderid);
		$this->db->where('id_user', $iduser);
		$this->db->update('tb_userevent', $data);
	}

	public function addbukti($data){

		$this->db->insert('tb_userevent', $data);
	}

	public function updateevent($data, $codeevent){
//		$now = new DateTime();
//		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
//		$tglsekarang = $now->format('Y-m-d H:i:s');
//		$data['modified'] = $tglsekarang;

		$this->db->where('code_event', $codeevent);
		$this->db->update('tb_event', $data);
	}

	public function delevent($kodeevent)
	{
		$this->db->where('code_event', $kodeevent);
		$this->db->delete('tb_event');
	}

	public function deluserevent($kodeevent,$iduser)
	{
		$this->db->where('(code_event="'.$kodeevent.'" AND id_user='.$iduser.')');
		$this->db->delete('tb_userevent');
	}


	public function updatestatus($code, $status)
	{
		$this->db->where('code_event', $code);
		$data = array (
			'status' => $status
		);
		return $this->db->update('tb_event', $data);
	}

	public function updatedefault($code, $status)
	{
		$this->db->from('tb_event');
		$this->db->where('code_event', $code);
		$query = $this->db->get()->result();
		$ret = $query[0]->default;

		if ($ret==1)
		{
			$data = array (
				'default' => 0
			);
			$this->db->where('code_event', $code);
			return $this->db->update('tb_event', $data);
		}
		else
		{
			$data = array (
				'default' => 0
			);
			$this->db->update('tb_event', $data);
			$data = array (
				'default' => 1
			);
			$this->db->where('code_event', $code);
			return $this->db->update('tb_event', $data);
		}

	}

	public function updatestatususer($code, $npsn, $status)
	{
		$this->db->where('code_event', $code);
		$this->db->where('npsn', $npsn);
		$data = array (
			'status_user' => $status,
		);
		return $this->db->update('tb_userevent', $data);
	}

	public function cekstatusbayarevent($code_event,$npsn,$iduser=null)
	{
		$this->db->from('tb_userevent');
		$this->db->where('code_event', $code_event);
		if ($iduser!=null)
			$this->db->where('id_user', $iduser);
		else
			$this->db->where('npsn', $npsn);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function cekstatusbayarakhirevent($iduser)
	{
		$tglskr = new DateTime();
		$tglskr->setTimezone(new DateTimezone('Asia/Jakarta'));
		$batastanggal = $tglskr->modify('-1 day');
		$batastanggal = $tglskr->format("Y-m-d H:i:s");

		//echo $batastanggal;

		$this->db->from('tb_userevent');
		$this->db->where('id_user', $iduser);
		$this->db->where('status_user', 1);
		$this->db->where('(tgl_bayar >= "' . $batastanggal . '")');
		$query = $this->db->get();
		$ret = $query->last_row();
		return $ret;
	}

	public function cekidyoutub($idyoutube)
	{
		$this->db->like('link_video', $idyoutube , 'both');
		$this->db->from('tb_video');
		$hasil = $this->db->get()->result();
		return $hasil;
	}

	public function updatefotoevent($namafile, $codeevent){
		$data = array(
			'gambar' => $namafile
		);
		$this->db->where('code_event', $codeevent);
		$this->db->update('tb_event', $data);
	}

	public function updatefotoevent2($namafile, $codeevent){
		$data = array(
			'gambar2' => $namafile
		);
		$this->db->where('code_event', $codeevent);
		$this->db->update('tb_event', $data);
	}

	public function updatefotosertifikat($namafile, $codeevent, $kodefield){
    	if ($kodefield=="ps")
    		$kodefield = "file_sertifikat";
    	else
			$kodefield = "file_sertifikat_".$kodefield;
		$data = array(
			$kodefield => $namafile
		);
		$this->db->where('code_event', $codeevent);
		$this->db->update('tb_event', $data);
	}

	public function getUserbyId($iduser)
	{
		$this->db->from('tb_user tu');
		$this->db->join('daf_chn_sekolah ds', 'ds.npsn = tu.npsn','left');
		$this->db->where('tu.id',$iduser);
		$result = $this->db->get()->result();
		return $result;
	}

	public function updatesertifikat($namaser,$emailser,$code,$iduser)
	{
		$data = array(
			'nama_sertifikat' => $namaser,
			'email_sertifikat' => $emailser,
		);
		$this->db->where('code_event', $code);
		$this->db->where('id_user', $iduser);
		$this->db->update('tb_userevent', $data);
	}

	public function daftarpesertaeventtunggal($code_event=null,$idpeserta=null,$idnarsum=null)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d');

		$this->db->from('tb_userevent tue');
		$this->db->join('tb_event te', 'te.code_event = tue.code_event','left');
		$this->db->join('tb_user tu', 'tu.id = tue.id_user','left');
		//$this->db->where('(te.viaverifikator=0)');
//		if ($idnarsum!=null)
//			$this->db->where('(status_user=3)');
//		else
		$this->db->where('(status_user>=2)');
		$this->db->where('(nama_sertifikat<>"" AND email_sertifikat<>"")');

		if ($code_event==null)
			$this->db->where('(tgl_selesai<"'.$tglsekarang.'")');
		else
			$this->db->where('(tue.code_event="'.$code_event.'")');
		if ($idpeserta!=null)
			$this->db->where('(tue.id_user="'.$idpeserta.'")');
		$this->db->order_by('tue.code_event');
		$result = $this->db->get()->result();
		return $result;
	}

	public function daftarpesertaeventsekolahl()
	{
		$this->db->from('tb_userevent tue');
		$this->db->where('(status_user=2)');
		$this->db->where('(code_event="3oartkv3agv3")');
		$this->db->where('(npsn<>"")');
		$result = $this->db->get()->result();
		return $result;
	}

	public function updatesudahsertifikat($code,$idpeserta)
	{
		$this->db->where('code_event', $code);
		$this->db->where('id_user', $idpeserta);
		$data = array (
			'download_sertifikat' => 1
		);
		return $this->db->update('tb_userevent', $data);
	}

	public function addnarsum($data)
	{
		$this->db->insert('tb_userevent', $data);
	}

	public function updatenarsum($code,$idpeserta,$sebagai)
	{
		$this->db->where('code_event', $code);
		$this->db->where('id_user', $idpeserta);
		$data = array (
			'aktifsebagai' => $sebagai
		);
		return $this->db->update('tb_userevent', $data);
	}

	public function updatenarsumevent($code,$fieldnarsum,$iduser)
	{
		$this->db->where('code_event', $code);
		$data = array (
			$fieldnarsum => $iduser
		);
		return $this->db->update('tb_event', $data);
	}

	public function cekvideotugasevent($code,$iduser)
	{
		$this->db->select('count(te.code_event) as nvideo');
		$this->db->from('tb_video tv');
		$this->db->join('tb_event te', 'te.id_event = tv.id_event','left');
		$this->db->where('(te.code_event="'.$code.'" AND id_user='.$iduser.')');
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekmodultugasevent($code,$iduser,$tipemodul)
	{
		$this->db->select('count(te.code_event) as nmodul');
		if ($tipemodul==2)
			$this->db->from('tb_paket_bimbel tp');
		else
			$this->db->from('tb_paket_channel tp');
		$this->db->join('tb_event te', 'te.id_event = tp.id_event','left');
		$this->db->where('(te.code_event="'.$code.'" AND durasi_paket<>"00:00:00" AND statussoal=1 
		AND uraianmateri<>"" AND statustugas=1 AND id_user='.$iduser.')');
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekbimbeltugasevent($code,$iduser)
	{
		$this->db->select('count(te.code_event) as nbimbel');
		$this->db->from('tb_paket_bimbel tp');
		$this->db->join('tb_event te', 'te.id_event = tp.id_event','left');
		$this->db->where('(te.code_event="'.$code.'" AND durasi_paket<>"00:00:00" AND statussoal=1 
		AND uraianmateri<>"" AND statustugas=1 AND id_user='.$iduser.')');
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekplaylisttugasevent($code,$iduser)
	{
		$this->db->select('count(tp.id) as nplaylist');
		$this->db->from('tb_paket_channel_sekolah tp');
		$this->db->join('tb_event te', 'te.code_event = tp.nama_paket','left');
		$this->db->where('(tp.nama_paket="'.$code.'" AND durasi_paket<>"00:00:00" AND status_paket>=1 
		AND jenis_paket=2 AND iduser='.$iduser.')');
		$result = $this->db->get()->result();
		return $result;
	}

}
