<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_channel extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function getVODAll(){
		$this->db->select('tv.*,first_name');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
		$this->db->where('((status_verifikasi=4 AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!="") OR (status_verifikasi=4 AND link_video!=""))');
		$this->db->where('sifat',0);
        $this->db->where('(status_verifikasi<>0)');
		$this->db->order_by('modified','desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getSekolah(){
		$this->db->from('daf_sekolah');
		$this->db->where('status',1);
		$this->db->order_by('created','desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getSekolahLain($npsn){
		$this->db->from('daf_sekolah ds');
        $this->db->join('tb_user tu', 'tu.npsn = ds.npsn','left');
		$this->db->where('status',1);
        $this->db->where('verifikator',3);
        $this->db->where('activate',1);
		if ($npsn!="")
			$this->db->where('(tu.npsn<>'.$npsn.')');
        $this->db->group_by('tu.npsn,ds.id');
		$this->db->order_by('ds.created','desc');
        $this->db->limit(10);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getSekolahKu($npsn){
		$this->db->from('daf_sekolah');
		$this->db->where('status',1);
		$this->db->where('(npsn='.$npsn.')');
		$this->db->order_by('created','desc');
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function getPlayList($npsn)
	{
		$this->db->from('tb_channel_video tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video','left');
		$this->db->where('(npsn='.$npsn.')');
		$this->db->order_by('urutan','asc');
		$result = $this->db->get()->result();
		return $result;
	}	
	
//	public function getPlayListGuru($idsaya)
//	{
//		$this->db->from('tb_video tv');
//		$this->db->where('(tv.id_user='.$idsaya.')');
//		$result = $this->db->get()->result();
//		return $result;
//	}

    public function getPlayListSaya($idsaya,$link_list)
    {
        $this->db->from('tb_channel_video tcv');
        $this->db->join('tb_video tv', 'tcv.id_video = tv.id_video','left');
        $this->db->join('tb_paket_channel tpc', 'tpc.id = tcv.id_paket','left');
        $this->db->where('(tv.id_user='.$idsaya.')');
        $this->db->where('(tpc.link_list="'.$link_list.'")');
        $this->db->order_by('urutan','asc');
        $this->db->order_by('tcv.id','asc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getPlayListSekolah($npsn,$link_list)
    {
        $this->db->from('tb_channel_video_sekolah tcv');
        $this->db->join('tb_video tv', 'tcv.id_video = tv.id_video','left');
        $this->db->join('tb_paket_channel_sekolah tpc', 'tpc.id = tcv.id_paket','left');
        $this->db->where('(tcv.npsn='.$npsn.')');
        $this->db->where('(tpc.link_list="'.$link_list.'")');
        $this->db->order_by('urutan','asc');
        $this->db->order_by('tcv.id','asc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getPlayListTVE($link_list)
    {
        $this->db->from('tb_channel_video_tve tcv');
        $this->db->join('tb_video tv', 'tcv.id_video = tv.id_video','left');
        $this->db->join('tb_paket_channel_tve tpc', 'tpc.id = tcv.id_paket','left');
        $this->db->where('(tpc.link_list="'.$link_list.'")');
        $this->db->order_by('urutan','asc');
        $this->db->order_by('tcv.id','asc');
        $result = $this->db->get()->result();
        return $result;
    }

	public function getDafPlayListSaya($idsaya)
	{
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id','left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video','left');
		$this->db->where('(urutan=0 OR urutan=1)');
		$this->db->where('(tpc.id_user='.$idsaya.')');
		$this->db->group_by('nama_paket');
		$this->db->order_by('status_paket','asc');
		$this->db->order_by('tanggal_tayang','desc');
		$this->db->order_by('tcv.id','asc');
		$result = $this->db->get()->result();
		return $result;
	}

    public function getDafPlayListSekolah($npsn,$tayang,$hari)
    {
        $this->db->from('tb_paket_channel_sekolah tpc');
        $this->db->join('tb_channel_video_sekolah tcv', 'tcv.id_paket = tpc.id','left');
        $this->db->join('tb_video tv', 'tv.id_video = tcv.id_video','left');
        $this->db->where('(urutan=0 OR urutan=1)');
        $this->db->where('(tpc.npsn='.$npsn.')');
        $this->db->where('(tpc.tayang='.$tayang.')');
        $this->db->where('(tpc.hari='.$hari.')');
        $this->db->group_by('nama_paket');
        $this->db->order_by('status_paket','asc');
        $this->db->order_by('jam_tayang','desc');
        $this->db->order_by('tcv.id','asc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getDafPlayListTVE($tayang,$hari)
    {
        //$hari = 6;
        $this->db->from('tb_paket_channel_tve tpc');
        $this->db->join('tb_channel_video_tve tcv', 'tcv.id_paket = tpc.id','left');
        $this->db->join('tb_video tv', 'tv.id_video = tcv.id_video','left');
        $this->db->where('(urutan=0 OR urutan=1)');
        $this->db->where('(tpc.tayang='.$tayang.')');
        $this->db->where('(tpc.hari='.$hari.')');
        $this->db->group_by('nama_paket');
        $this->db->order_by('status_paket','asc');
        $this->db->order_by('jam_tayang','desc');
        $this->db->order_by('tcv.id','asc');
        $result = $this->db->get()->result();
        return $result;
    }

	
	public function getPaketGuru($id_user)
	{
		$this->db->from('tb_paket_channel');
		$this->db->where('id_user', $id_user);
		$this->db->order_by('tanggal_tayang', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

    public function getPaketSekolah($npsn)
    {
        $this->db->from('tb_paket_channel_sekolah');
        $this->db->where('npsn', $npsn);
        $this->db->order_by('hari', 'asc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getPaketTVE($npsn)
    {
        $this->db->from('tb_paket_channel_tve');
        $this->db->order_by('hari', 'asc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getChannelGuru($npsn){
		$this->db->from('tb_user tu');
		$this->db->join('tb_paket_channel tpc', 'tu.id = tpc.id_user','right');
		$this->db->where('npsn',$npsn);
		$this->db->order_by('level','desc');
		$this->db->group_by('tu.id');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getInfoGuru($kd_user){
		$this->db->from('tb_user');
		$this->db->where('id',$kd_user);
		$result = $this->db->get()->result();
		return $result;
	}

    public function getInfoSekolah($npsn){
        $this->db->from('daf_sekolah');
        $this->db->where('npsn',$npsn);
        $result = $this->db->get()->result();
        return $result;
    }

	public function getVODSekolah($npsn){
		$this->db->select('tv.*,first_name');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
		$this->db->where('((status_verifikasi=4 AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!="") OR (status_verifikasi=4 AND link_video!=""))');
		$this->db->where('npsn',$npsn);
		$this->db->where('sifat',0);
		$this->db->order_by('modified','desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVODGuru($kd_user){
		$this->db->select('tv.*,first_name');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
		$this->db->where('(link_video!="")');
		$this->db->where('id_user',$kd_user);
		$this->db->order_by('modified','desc');
		$result = $this->db->get()->result();
		return $result;
	}


	public function getVODList($kd_user)
	{
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
		$this->db->where('id_user',$kd_user);
		$this->db->where('dilist',1);
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function getChannelAll()
	{
		$this->db->from('daf_sekolah');
		$this->db->order_by('created', 'desc');
        $this->db->limit(100);
		$result = $this->db->get()->result();
		return $result;
	}

    public function getChannelSiap()
    {
        $this->db->from('daf_sekolah ds');
        $this->db->join('tb_user tu', 'tu.npsn = ds.npsn','left');
        $this->db->where('status',1);
        $this->db->where('verifikator',3);
        $this->db->where('activate',1);
        $this->db->group_by('tu.npsn');
        $this->db->order_by('ds.created','desc');
        $this->db->limit(100);
        $result = $this->db->get()->result();
        return $result;
    }

	public function updatestatus($id,$status)
	{
		$this->db->where('id', $id);
		$data = array (
			'status' => $status
		);
		return $this->db->update('daf_sekolah', $data);
	}
	
	public function updatesifat($id, $status)
	{
		$this->db->where('id_video', $id);
		$data = array (
		'sifat' => $status
		);
		return $this->db->update('tb_video', $data);
	}
	
	public function updatedilist($id, $status)
	{
		$this->db->where('id_video', $id);
		$data = array (
		'dilist' => $status
		);
		return $this->db->update('tb_video', $data);
	}

    public function updatedilistsekolah($id, $status)
    {
        $this->db->where('id_video', $id);
        $data = array (
            'dilist' => $status
        );
        return $this->db->update('tb_video', $data);
    }

    public function updatedilisttve($id, $status)
    {
        $this->db->where('id_video', $id);
        $data = array (
            'dilist' => $status
        );
        return $this->db->update('tb_video', $data);
    }
	
	public function insertplaylist($data)
	{
		$this->db->where('id_user', $this->session->userdata('id_user'));
		$this->db->delete('tb_channel_video');
		return $this->db->insert_batch('tb_channel_video', $data);
	}
	
	public function gantistatuspaket($id)
	{
		$this->db->where('id', $id);
		$data = array (
		'status_paket' => 2
		);
		return $this->db->update('tb_paket_channel', $data);
	}

    public function gantistatuspaket_sekolah($id)
    {
        $this->db->where('id', $id);
        $data = array (
            'status_paket' => 2
        );
        return $this->db->update('tb_paket_channel_sekolah', $data);
    }

    public function gantistatuspaket_tve($id)
    {
        $this->db->where('id', $id);
        $data = array (
            'status_paket' => 2
        );
        return $this->db->update('tb_paket_channel_tve', $data);
    }

	public function addplaylist($data)
	{
		$this->db->insert('tb_paket_channel', $data);
	}

    public function addplaylist_sekolah($data)
    {
        $this->db->insert('tb_paket_channel_sekolah', $data);
    }

    public function addplaylist_tve($data)
    {
        $this->db->insert('tb_paket_channel_tve', $data);
    }

	public function getVideoUser($id_user,$kodepaket)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel');
		$this->db->from('tb_video tv');
		$this->db->join('tb_paket_channel tpc', 'tv.id_user = tpc.id_user','left');
		$this->db->join('tb_channel_video tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)','left');

		$this->db->where('tv.id_user', $id_user);
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->order_by('modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

    public function getVideoUserPaket($id_user,$kodepaket)
    {
        $this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel, tcv.id as idplaylist');
        $this->db->from('tb_video tv');
        $this->db->join('tb_channel_video tcv', '(tcv.id_video = tv.id_video)','left');
        $this->db->join('tb_paket_channel tpc', 'tcv.id_paket = tpc.id','left');

        $this->db->where('tpc.link_list', $kodepaket);
        $this->db->order_by('tcv.urutan ASC, tcv.id ASC');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getVideoSekolah($npsn,$kodepaket)
    {
        $this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel');
        $this->db->from('tb_video tv');
        $this->db->join('tb_user tu', 'tu.id = tv.id_user','left');
        $this->db->join('tb_paket_channel_sekolah tpc', 'tu.npsn = tpc.npsn','left');
        $this->db->join('tb_channel_video_sekolah tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)','left');

        $this->db->where('tu.npsn', $npsn);
        $this->db->where('tpc.link_list', $kodepaket);
        $this->db->order_by('tv.modified', 'desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getVideoSekolahPaket($kodepaket)
    {
        $this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel, tcv.id as idplaylist');
        $this->db->from('tb_video tv');
        $this->db->join('tb_channel_video_sekolah tcv', '(tcv.id_video = tv.id_video)','left');
        $this->db->join('tb_paket_channel_sekolah tpc', 'tcv.id_paket = tpc.id','left');
        $this->db->where('tpc.link_list', $kodepaket);
        $this->db->order_by('tcv.urutan ASC, tcv.id ASC');
        $result = $this->db->get()->result();
        return $result;
    }

    public function updateurutan_sekolah($data)
    {
        $updateArray = array();
        for($x = 0; $x <= sizeof($data); $x++){
            $updateArray[] = array(
                'id'=>$data['id'][$x],
                'urutan' => $data['urutan'][$x]
            );
//            echo "ID:".$data['id'][$x];
//            echo "URUTAN:".$data['urutan'][$x]."<br>";

        }
        //$this->db->update_batch('po_order_details',$updateArray, 'poid');
        $this->db->update_batch('tb_channel_video_sekolah', $updateArray, 'id');
    }

    public function updateurutan_guru($data)
    {
        $updateArray = array();
        for($x = 0; $x <= sizeof($data); $x++){
            $updateArray[] = array(
                'id'=>$data['id'][$x],
                'urutan' => $data['urutan'][$x]
            );
//            echo "ID:".$data['id'][$x];
//            echo "URUTAN:".$data['urutan'][$x]."<br>";

        }
        //$this->db->update_batch('po_order_details',$updateArray, 'poid');
        $this->db->update_batch('tb_channel_video', $updateArray, 'id');
    }

    public function updateurutan_tve($data)
    {
        $updateArray = array();
        for($x = 0; $x < sizeof($data); $x++){
            $updateArray[] = array(
                'id'=>$data['id'][$x],
                'urutan' => $data['urutan'][$x]
            );
//            echo "ID:".$data['id'][$x];
//            echo "URUTAN:".$data['urutan'][$x]."<br>";

        }
        //$this->db->update_batch('po_order_details',$updateArray, 'poid');
        $this->db->update_batch('tb_channel_video_tve', $updateArray, 'id');
    }

    public function getVideoTVE($kodepaket)
    {
        $this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel');
        $this->db->from('tb_video tv');
        $this->db->join('tb_paket_channel_tve tpc', 'tayang=0','left');
        $this->db->join('tb_channel_video_tve tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)','left');
        $this->db->group_by('tv.id_video');
        $this->db->where('tpc.link_list', $kodepaket);
        $this->db->where('(tv.durasi<>"")');
        $this->db->order_by('tv.modified', 'desc');

        $result = $this->db->get()->result();
        return $result;
    }

    public function getVideoTVEPaket($kodepaket)
    {
        $this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel, tcv.id as idplaylist');
        $this->db->from('tb_video tv');
        $this->db->join('tb_channel_video_tve tcv', '(tcv.id_video = tv.id_video)','left');
        $this->db->join('tb_paket_channel_tve tpc', 'tcv.id_paket = tpc.id','left');
        $this->db->where('tpc.link_list', $kodepaket);
        $this->db->order_by('tcv.urutan ASC, tcv.id ASC');
        $result = $this->db->get()->result();
        return $result;

//        $this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel, tcv.id as idplaylist');
//        $this->db->from('tb_video tv');
//        $this->db->join('tb_channel_video_tve tcv', '(tcv.id_video = tv.id_video)','left');
//        $this->db->join('tb_paket_channel_tve tpc', 'tayang=0','left');
//        $this->db->where('tpc.link_list', $kodepaket);
//        $this->db->order_by('tv.modified', 'desc');
//
//        $result = $this->db->get()->result();
//        return $result;
    }

	public function getVideoUsercek($id_user, $kodepaket)
	{
		$this->db->select('*,tv.id_video as idvideo');
		$this->db->from('tb_video tv');
		$this->db->join('tb_paket_channel tpc', 'tv.id_user = tpc.id_user','left');
		//$this->db->join('tb_channel_video tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)','left');

		$this->db->where('tv.id_user', $id_user);
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->order_by('modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function getInfoVideo($id_video)
		{
		$this->db->from('tb_video');
		$this->db->where('id_video',$id_video);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}
	
	public function cekVideoChannel($id_video)
	{
		$this->db->from('tb_channel_video');
		$this->db->where('id_video',$id_video);
		$result = $this->db->get()->result();
		return $result;
	}

    public function cekVideoChannelSekolah($id_video)
    {
        $this->db->from('tb_channel_video_sekolah');
        $this->db->where('id_video',$id_video);
        $result = $this->db->get()->result();
        return $result;
    }

    public function cekVideoChannelTVE($id_video)
    {
        $this->db->from('tb_channel_video_tve');
        $this->db->where('id_video',$id_video);
        $result = $this->db->get()->result();
        return $result;
    }

	public function getInfoPaket($linklist)
	{
		$this->db->from('tb_paket_channel');
		$this->db->where('link_list',$linklist);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

    public function getInfoPaketSekolah($linklist)
    {
        $this->db->from('tb_paket_channel_sekolah');
        $this->db->where('link_list',$linklist);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret;
    }

    public function getInfoPaketTVE($linklist)
    {
        $this->db->from('tb_paket_channel_tve');
        $this->db->where('link_list',$linklist);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret;
    }
	
	public function getDataChannelVideo($id_paket)
	{
		$this->db->from('tb_channel_video tcv');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video','left');
		$this->db->where('id_paket',$id_paket);
		$this->db->order_by('urutan', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

    public function getDataChannelVideoSekolah($id_paket)
    {
        $this->db->from('tb_channel_video_sekolah tcv');
        $this->db->join('tb_video tv', 'tv.id_video = tcv.id_video','left');
        $this->db->where('id_paket',$id_paket);
        $this->db->order_by('urutan', 'desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function getDataChannelVideoTVE($id_paket)
    {
        $this->db->from('tb_channel_video_tve tcv');
        $this->db->join('tb_video tv', 'tv.id_video = tcv.id_video','left');
        $this->db->where('id_paket',$id_paket);
        $this->db->order_by('urutan', 'desc');
        $result = $this->db->get()->result();
        return $result;
    }

	public function addDataChannelVideo($data)
	{
		$this->db->insert('tb_channel_video', $data);
	}

    public function addDataChannelVideoSekolah($data)
    {
        $this->db->insert('tb_channel_video_sekolah', $data);
    }

    public function addDataChannelVideoTVE($data)
    {
        $this->db->insert('tb_channel_video_tve', $data);
    }
	
	public function delDataChannelVideo($id_video,$id_paket)
	{
		$this->db->where('(id_video = '.$id_video.' AND id_paket = '.$id_paket.')');
		$this->db->delete('tb_channel_video');
	}

    public function delDataChannelVideoSekolah($id_video,$id_paket)
    {
        $this->db->where('(id_video = '.$id_video.' AND id_paket = '.$id_paket.')');
        $this->db->delete('tb_channel_video_sekolah');
    }

    public function delDataChannelVideoTVE($id_video,$id_paket)
    {
        $this->db->where('(id_video = '.$id_video.' AND id_paket = '.$id_paket.')');
        $this->db->delete('tb_channel_video_tve');
    }

	public function updateDurasiPaket($linklist,$data)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel', $data);
	}

    public function updateDurasiPaketSekolah($linklist,$data)
    {
        $this->db->where('link_list', $linklist);
        return $this->db->update('tb_paket_channel_sekolah', $data);
    }

    public function updateDurasiPaketTVE($linklist,$data)
    {
        $this->db->where('link_list', $linklist);
        return $this->db->update('tb_paket_channel_tve', $data);
    }

	public function delPlayList($kodepaket)
	{
		$this->db->where('link_list', $kodepaket);
		return $this->db->delete('tb_paket_channel');
	}

    public function delPlayListSekolah($kodepaket)
    {
        $this->db->where('link_list', $kodepaket);
        return $this->db->delete('tb_paket_channel_sekolah');
    }

    public function delPlayListTVE($kodepaket)
    {
        $this->db->where('link_list', $kodepaket);
        return $this->db->delete('tb_paket_channel_tve');
    }

	public function updatePlayList($linklist,$data)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel', $data);
	}

    public function updatePlayList_sekolah($linklist,$data)
    {
        $this->db->where('link_list', $linklist);
        return $this->db->update('tb_paket_channel_sekolah', $data);
    }

    public function updatePlayList_tve($linklist,$data)
    {
        $this->db->where('link_list', $linklist);
        return $this->db->update('tb_paket_channel_tve', $data);
    }
	
	public function update_statuspaket($link_list, $status)
	{
		$this->db->where('link_list', $link_list);
		$data = array (
		'status_paket' => $status
		);
		return $this->db->update('tb_paket_channel', $data);
	}

    public function update_statuspaket_sekolah($link_list, $status)
    {
        $this->db->where('link_list', $link_list);
        $data = array (
            'status_paket' => $status
        );
        return $this->db->update('tb_paket_channel_sekolah', $data);
    }

    public function update_statuspaket_tve($link_list, $status)
    {
        $this->db->where('link_list', $link_list);
        $data = array (
            'status_paket' => $status
        );
        return $this->db->update('tb_paket_channel_tve', $data);
    }
		
}
