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
        $this->db->where('id_video', $id_video);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function delsafevideo($id_video)
    {
    	if ($this->session->userdata('a01'))
		{
			$this->db->where('(id_video = ' . $id_video.')');
		}
        else if ($this->session->userdata('sebagai')==4) {
			$this->db->select('tb_video.id_video');
			$this->db->from('tb_video');
			$this->db->join('tb_user', 'tb_user.id = tb_video.id_user', 'left');
			$this->db->where('(id_video = ' . $id_video . ' AND 
		(status_verifikasi=0 OR sebagai=4))');
			$where_clause = $this->db->get_compiled_select();

			$this->db->where("`id_video` IN ($where_clause)", NULL, FALSE);

        } else if ($this->session->userdata('verifikator')==3) {
			$this->db->select('tb_video.id_video');
			$this->db->from('tb_video');
			$this->db->join('tb_user', 'tb_user.id = tb_video.id_user', 'left');
			$this->db->where('(id_video = ' . $id_video . ' AND 
		npsn="'.$this->session->userdata('npsn').'")');
			$where_clause = $this->db->get_compiled_select();

			$this->db->where("`id_video` IN ($where_clause)", NULL, FALSE);
		}
        else {
            $this->db->where('(id_video = ' . $id_video . ' AND 
		id_user = ' . $this->session->userdata("userData")["id_user"] . ' AND
		status_verifikasi=0)');
        }

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
//		$this->db->where('(tv.id_user <> "' . $this->session->userdata('id_user') . '")');
//
//		$this->db->order_by('status_verifikasi', 'asc');
//		$this->db->order_by('tv.modified', 'desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getVideoAll()
    {
        $this->db->select('tv.*,tu.*,tu.created as createduser');
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
        $this->db->order_by('tv.modified', 'desc');
        $result = $this->db->get()->result();
        return $result;
    }

	public function getVideobyEvent($idevent)
	{
		$this->db->select('tv.*,tu.*,tu.created as createduser,nama_sekolah');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->join('daf_chn_sekolah dc', 'dc.npsn = tu.npsn', 'left');
		$this->db->where('id_event', $idevent);
		if($this->session->userdata('sebagai')!=4 && $this->session->userdata('loggedIn'))
			$this->db->where('tu.npsn', $this->session->userdata('npsn'));
//		if($this->session->userdata('sebagai')==4)
//			$this->db->where('(tv.status_verifikasi=2 OR tv.status_verifikasi=4)');
		$this->db->order_by('tv.modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

    public function getVideoSekolah($npsn)
    {
        $this->db->select('tv.*,tu.*,tu.created as createduser');
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
        $this->db->where('tu.npsn', $npsn);
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
        $data['modified'] = $tglsekarang;

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
        $this->db->update('tb_penilaian' . $data['no_verifikator'], $data);
        //else
        //    $this->db->insert('tb_penilaian', $data);
    }

    public function updatejmlvidsekolah($npsn)
    {
        $this->db->select('tv.*,tu.*,tu.created as createduser');
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
        $this->db->where('tu.npsn', $npsn);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        $data = array('jml_video' => $rowcount);
        $this->db->where('npsn', $npsn);
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
		$this->db->order_by("tgl_mulai", "desc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllEventAktif($link=null)
	{
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

		$this->db->select('te.*,tu.status_user,tu.npsn,tu.filedok');
		$this->db->from('tb_event te');
		$this->db->join('tb_userevent tu', 'te.code_event = tu.code_event AND tu.npsn = "'.
			$npsnku.'"','left');
		$this->db->where('status', 1);
		$this->db->where('(tgl_mulai<="'.$tglsekarang.'")');
		$this->db->where('(tgl_selesai>="'.$tglsekarang.'")');
//		if ($this->session->userdata('loggedIn')) {
//			$this->db->where('tu.npsn', $this->session->userdata('npsn'));
//		}
//		$this->db->group_by("te.code_event");
		$this->db->order_by("status_user", "desc");
		$this->db->order_by("tgl_mulai", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekEventAktifbyLink($link_event)
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
		$this->db->join('tb_userevent tu', 'te.code_event = tu.code_event AND tu.npsn = "'.
			$npsnku.'"','left');
		$this->db->where('status', 1);
		$this->db->where('status_user', 2);
		$this->db->where('link_event', $link_event);
		if ($this->session->userdata('sebagai')!=4)
		$this->db->where('npsn', $this->session->userdata('npsn'));
		$result = $this->db->get()->result();
		return $result;
	}

	public function getbyCodeEvent($kode)
	{
		if (!isset($this->session->userdata['npsn']))
		{
			$npsnku="999";
		}
		else
		{
			$npsnku=$this->session->userdata('npsn');
		}
		$this->db->select('te.*,tu.status_user,tu.order_id,tu.nama_bank,tu.no_rek,tu.tgl_bayar');
		$this->db->from('tb_event te');
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

	public function getAllUserEvent($codeevent,$status=null)
	{
		$this->db->from('tb_userevent tu');
		$this->db->join('daf_chn_sekolah ds', 'tu.npsn = ds.npsn','left');
		$this->db->where('code_event', $codeevent);
		$this->db->where('(status_user>=1)');
		$this->db->order_by("tgl_bayar", "desc");
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
		$this->db->where('harike', $harike);
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

	public function updatestatus($code, $status)
	{
		$this->db->where('code_event', $code);
		$data = array (
			'status' => $status
		);
		return $this->db->update('tb_event', $data);
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

	public function cekstatusbayarevent($code_event,$npsn)
	{
		$this->db->from('tb_userevent');
		$this->db->where('code_event', $code_event);
		$this->db->where('npsn', $npsn);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function cekidyoutub($idyoutube)
	{
		$this->db->like('link_video', $idyoutube , 'both');
		$this->db->from('tb_video');
		$hasil = $this->db->get()->result();
		return $hasil;
	}
}
