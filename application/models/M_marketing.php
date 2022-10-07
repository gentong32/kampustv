<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_marketing extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function getlastmarketing($iduser)
	{
		$this->db->select('tm.*, nama_sekolah, nama_kota');
		$this->db->from('tb_marketing tm');
		$this->db->join('daf_chn_sekolah ds', 'tm.npsn_sekolah = ds.npsn', 'left');
		$this->db->join('daf_kota dk', 'ds.idkota = dk.id_kota', 'left');
		$this->db->where('id_siam', $iduser);
		$this->db->where('tm.jenis_event', 1);
		$this->db->where('tm.status<=', 1);
		$result = $this->db->get()->row();
		return $result;
	}

	public function addmarketing($iduser)
	{
		$data = array("id_siam" => $iduser);
		$this->db->insert('tb_marketing', $data);
		$insert_id = $this->db->insert_id();
		$this->db->select('tm.*, nama_sekolah, nama_kota');
		$this->db->from('tb_marketing tm');
		$this->db->join('daf_chn_sekolah ds', 'tm.npsn_sekolah = ds.npsn', 'left');
		$this->db->join('daf_kota dk', 'ds.idkota = dk.id_kota', 'left');
		$this->db->where('tm.id', $insert_id);
		$result = $this->db->get()->row();
		return $result;
	}

	public function updateeksekusi($data, $idmarketing, $iduser)
	{
		$this->db->where('id', $idmarketing);
		$this->db->where('id_user', $iduser);
		return $this->db->update('tb_marketing', $data);
	}

	public function insertbatch_pilsekolah($data, $kode_eks)
	{
//		$this->db->where('kode_eks', $kode_eks);
//		$this->db->delete('tb_eksae_daftar_sekolah');
		return $this->db->insert_batch('tb_eksae_daftar_sekolah', $data);
	}

	public function getAgency($idkota)
	{
		$this->db->from('tb_user');
		$this->db->where('siag', 3);
		$this->db->where('kd_kota', $idkota);
		$result = $this->db->get()->result();
		return $result;
	}

	public function updatemarketing($data, $status, $id)
	{
		$this->db->where('id_siam', $id);
		$this->db->where('status', $status);
		if($this->db->update('tb_marketing', $data))
			return true;
		else
			return false;
	}

	public function ceksasaran($npsn)
	{
		$this->db->from('tb_marketing');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('jenis_event', 1);
		$result = $this->db->get()->row();
		return $result;
	}

	public function getDafKodeRef($id)
	{
		$this->db->select('tm.*,nama_sekolah,tu.first_name,tu.last_name');
		$this->db->from('tb_marketing tm');
		$this->db->join('daf_chn_sekolah ds', 'tm.npsn_sekolah = ds.npsn', 'left');
		$this->db->join('tb_user tu', 'tm.id_agency = tu.id', 'left');
		$this->db->where('id_siam', $id);
		$this->db->where('tm.jenis_event', 1);
		$this->db->where('tm.status', 2);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafUser($idsiam, $npsn=null)
	{
		$this->db->select('tu.*');
		$this->db->from('tb_user tu');
		$this->db->join('tb_marketing tm', 'tm.kode_referal = tu.referrer AND referrer<>""', 'left');
		$this->db->where('id_siam', $idsiam);
		if ($npsn!=null)
		$this->db->where('tu.npsn', $npsn);
		// $this->db->where('referrer<>', "");
		$this->db->order_by("tu.verifikator","desc");
		$this->db->order_by("tu.sebagai","asc");
		$this->db->order_by("tu.referrer","asc");
		
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafModul($koderef, $moduldari, $modulsampai, $ujiandari, $ujiansampai, $semester)
	{
		$this->db->select('tu.*');
		$this->db->from('tb_user tu');
		$this->db->join('tb_marketing tm', 'tm.kode_referal = tu.referrer', 'left');
		$this->db->where('id_siam', $idsiam);
		$this->db->where('tu.npsn', $npsn);
		$this->db->where('referrer', "6puzr6472");
		$this->db->order_by("tu.verifikator","desc");
		$this->db->order_by("tu.sebagai","asc");
		$this->db->order_by("tu.referrer","asc");
		
		$result = $this->db->get()->result();
		return $result;
	}

	public function getTransaksi($idsiam)
	{
		$this->db->select('tu.first_name, tu.last_name, tu.sekolah, tb.tgl_beli, siapambil,
		sum(rp_am_bruto) as total_bruto,tv.kode_beli,tv.jenis_paket,
		sum(rp_am_pph) as total_pph, sum(rp_am_net) as total_net, tv.status_am');
		$this->db->from('tb_virtual_kelas tv');
		$this->db->join('tb_vk_beli tb', 'tv.kode_beli = tb.kode_beli', 'left');
		$this->db->join('tb_paket_channel tc', 'tv.link_paket = tc.link_list', 'left');
		$this->db->join('tb_user tu', 'tv.id_user = tu.id', 'left');
		$this->db->group_by('tv.id_user, tv.kode_beli');
		$this->db->where('id_am', $idsiam);
		$this->db->order_by("tb.tgl_beli","asc");
		$this->db->order_by("tv.status_am","asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getTransaksiPremium($idsiam)
	{
		$this->db->select('ds.nama_sekolah, tp.tgl_bayar, tp.fee_siam, tp.status_siam, tp.order_id, siapambil');
		$this->db->from('tb_payment tp');
		$this->db->join('daf_chn_sekolah ds', 'tp.npsn_sekolah = ds.npsn', 'left');
		$this->db->where('id_siam', $idsiam);
		$this->db->order_by("tp.tgl_bayar","asc");
		$this->db->order_by("tp.status_siam","asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getKodeRef($idmarketing)
	{
		$this->db->from('tb_marketing tm');
		$this->db->join('daf_chn_sekolah ds', 'tm.npsn_sekolah = ds.npsn', 'left');
		$this->db->where('tm.jenis_event', 1);
		$this->db->where('tm.id', $idmarketing);
		$result = $this->db->get()->row();
		return $result;
	}

	public function getDataRef($koderef)
	{
		$this->db->from('tb_marketing');
		$this->db->where('kode_referal', $koderef);
		$result = $this->db->get()->row();
		return $result;
	}

	public function updateDataRef($data, $koderef)
	{
		$this->db->where('kode_referal', $koderef);
		if($this->db->update('tb_marketing', $data))
			return true;
		else
			return false;
	}

	public function getModulSekolah($linklist, $opsi=null)
	{
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
		if ($opsi==null)
			$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->join('daf_kelas dk','dk.id = tpc.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tpc.id_mapel','left');
//		$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "' .
//			$kodebeli . '" AND tk.jenis_paket = ' . $jenis . ' AND tk.id_user = ' . $iduser, 'left');
//		$this->db->where('(urutan=0 OR urutan=1)');
		$this->db->where('(link_list="' . $linklist . '")');
		if ($opsi==null)
		$this->db->where('tv.id_video IS NOT NULL');
		// $this->db->where('status_paket>',0);
		// $this->db->where('uraianmateri<>',"");
		$this->db->where('statussoal>',0);
		// $this->db->where('statustugas>',0);
		$this->db->group_by('link_list');
		$this->db->order_by('semester','asc');
		$this->db->order_by('modulke','asc');
		$this->db->order_by('tpc.id_kelas','asc');
		$this->db->order_by('tpc.id_mapel','asc');

		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->row();
		return $result;
	}

	public function getModulPaket($link_list)
	{
		$this->db->from('tb_channel_video tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_channel tpc', 'tpc.id = tcv.id_paket', 'left');
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(tpc.link_list="' . $link_list . '")');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->row();
		return $result;
	}

	public function updateperiksa($linklist, $status, $catatan)
	{
		$data = array ("statusmentor"=>$status, "catatanmentor"=>$catatan);
		$this->db->where('link_list', $linklist);
		if ($this->db->update('tb_paket_channel', $data))
			return true;
		else
			return false;
	}

	public function getDafEvent($bulan, $tahun)
	{
		// $this->db->select('tu.*');
		$this->db->from('tb_mentor_event te');
		$this->db->join('tb_marketing tm', 'tm.kode_referal = te.kode_referal', 'left');
		$this->db->join('daf_chn_sekolah ds', 'ds.npsn = tm.npsn_sekolah', 'left');
		$this->db->join('daf_kota dk', 'dk.id_kota = ds.idkota', 'left');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('id_siam', $this->session->userdata('id_user'));
		$this->db->group_by('te.kode_referal');
		$this->db->order_by("npsn_sekolah","asc");
		
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafEventVer($kodeevent=null)
	{
		// $this->db->select('tu.*');
		$this->db->from('tb_marketing tm');
		$this->db->join('tb_mentor_calver_tugas tt', 'tm.kode_referal = tt.kode_event', 'left');
		$this->db->where('jenis_event', 2);
		$this->db->where('id_siam', $this->session->userdata('id_user'));
		if ($kodeevent!=null)
		$this->db->where('kode_referal', $kodeevent);
		
		$result = $this->db->get()->result();
		return $result;
	}

	// public function getDafEventVer($bulan, $tahun)
	// {
	// 	// $this->db->select('tu.*');
	// 	$this->db->from('tb_mentor_daf_calver td');
	// 	$this->db->join('tb_marketing tm', 'tm.kode_referal = td.kode_referal', 'left');
	// 	$this->db->join('tb_mentor_event te', 'te.kode_referal = td.kode_referal', 'left');
	// 	$this->db->join('daf_chn_sekolah ds', 'ds.npsn = td.npsn_sekolah', 'left');
	// 	$this->db->join('daf_kota dk', 'dk.id_kota = ds.idkota', 'left');
	// 	$this->db->where('bulan', $bulan);
	// 	$this->db->where('tahun', $tahun);
	// 	$this->db->where('id_siam', $this->session->userdata('id_user'));
	// 	$this->db->group_by('td.kode_referal');
	// 	$this->db->order_by("td.npsn_sekolah","asc");
		
	// 	$result = $this->db->get()->result();
	// 	return $result;
	// }

	public function getDafEventbyCode($kodeevent)
	{
		// $this->db->select('tu.*');
		$this->db->from('tb_mentor_event te');
		$this->db->join('tb_marketing tm', 'tm.kode_referal = te.kode_referal', 'left');
		$this->db->join('daf_chn_sekolah ds', 'ds.npsn = tm.npsn_sekolah', 'left');
		$this->db->join('daf_kota dk', 'dk.id_kota = ds.idkota', 'left');
		$this->db->where('kode_event', $kodeevent);
		$this->db->group_by('te.kode_referal');
		$this->db->order_by("npsn_sekolah","asc");
		
		$result = $this->db->get()->result();
		return $result;
	}

	public function getsekolahfullRef($npsn, $idmentor, $bulan=null, $tahun=null)
	{
		$this->db->select('dc.*,dk.nama_kota,tm.kode_referal');
		$this->db->from('daf_sekolah dc');
		$this->db->join('daf_kota dk', 'dk.id_kota = dc.id_kota', 'left');
		$this->db->join('tb_marketing tm', 'tm.npsn_sekolah = dc.npsn', 'left');
		$this->db->where('npsn', $npsn);
		$this->db->where('id_siam', $idmentor);
		if ($bulan!=null)
		{
			$this->db->join('tb_mentor_event tme', 'tme.kode_referal = tm.kode_referal', 'left');
			$this->db->where('bulan', $bulan);
			$this->db->where('tahun', $tahun);
		}
		$this->db->group_by('dc.npsn');
		$result = $this->db->get()->result();
		return $result;
	}

	public function addDataMentor($data)
	{
		$this->db->insert('tb_mentor_event', $data);
	}

	public function addDataMentorTugas($data)
	{
		$this->db->insert('tb_mentor_calver_tugas', $data);
	}

	public function addtbMentor($data)
	{
		$this->db->insert('tb_marketing', $data);
	}

	public function updateDataMentor($data, $koderef, $kodeevent)
	{
		$this->db->where('kode_referal', $koderef);
		$this->db->where('kode_event', $kodeevent);
		$this->db->update('tb_mentor_event', $data);
	}

	public function updateMarketingCalver($data, $koderef)
	{
		$this->db->where('kode_referal', $koderef);
		$this->db->update('tb_marketing', $data);
	}

	public function getCalver($kodeevent, $npsn)
	{
		$this->db->from('tb_mentor_calver_daf');
		$this->db->where('kode_event',$kodeevent);
		$this->db->where('npsn_sekolah',$npsn);
		$result = $this->db->get()->result();
		return $result;
	}

	public function updateCalVerTugas($data, $kodeevent)
	{
		$this->db->where('kode_event', $kodeevent);
		$this->db->update('tb_mentor_calver_tugas', $data);
	}

	public function updateCalVerDafUser($fielddata, $iduser)
	{
		$data = array();

		if ($fielddata=="video")
		{
			$this->db->from('tb_video');
			$this->db->where('tipe_video',3);
			$this->db->where('id_event>',0);
			$this->db->where('id_user',$iduser);
			$totaldata = $this->db->get()->num_rows();
			$data['jml_'.$fielddata] = $totaldata;
		}
		else if ($fielddata=="playlist")
		{
			$this->db->from('tb_paket_channel_sekolah');
			$this->db->where('durasi_paket<>"00:00:00"');	
			$this->db->where('iduser',$iduser);	
			$totaldata = $this->db->get()->num_rows();
			$data['jml_'.$fielddata] = $totaldata;	
		}

		else if ($fielddata=="kontributor")
		{
			$this->db->from('tb_user');
			$this->db->where('(kontributor=2 OR kontributor=3)');	
			$this->db->where('npsn',$this->session->userdata('npsn'));	
			$totaldata1 = $this->db->get()->num_rows();
			$this->db->from('tb_user');
			$this->db->where('(kontributor=3)');	
			$this->db->where('npsn',$this->session->userdata('npsn'));	
			$totaldata2 = $this->db->get()->num_rows();
			$data['jml_kontri'] = $totaldata1;	
			$data['jml_kontriok'] = $totaldata2;	
			// echo "NPSN:".$this->session->userdata('npsn')."-".$data['jml_kontri'];
		}

		else if ($fielddata=="siswa")
		{
			$this->db->from('tb_user');
			$this->db->where('(sebagai=2)');	
			$this->db->where('npsn',$this->session->userdata('npsn'));	
			$totaldata1 = $this->db->get()->num_rows();
			$data['jml_siswa'] = $totaldata1;
		}
		
		$this->db->where('id_calver', $iduser);
		$this->db->update('tb_mentor_calver_daf', $data);
	}

	public function hitungvideo()
	{
		$iduser = $this->session->userdata('id_user');
		$data = array();
		$this->db->from('tb_video');
		$this->db->where('npsn_user',$this->session->userdata('npsn'));	
		$this->db->where('id_user<>',$iduser);	
		$totaldata1 = $this->db->get()->num_rows();
		$this->db->from('tb_video');
		$this->db->where('(status_verifikasi=2)');		
		$this->db->where('npsn_user',$this->session->userdata('npsn'));	
		$this->db->where('id_user<>',$iduser);
		$totaldata2 = $this->db->get()->num_rows();
		$data['jml_video_kontri'] = $totaldata1;	
		$data['jml_video_kontriok'] = $totaldata2;	
		return $data;
	}

	public function hitungvideoall($koderef)
	{
		$data = array();
		$this->db->from('tb_video tv');
		$this->db->join('tb_mentor_calver_daf tm', 'tm.npsn_sekolah = tv.npsn_user', 'left');
		$this->db->join('tb_user tu', 'tv.id_user = tu.id', 'left');
		$this->db->where('tm.kode_event',$koderef);
		$this->db->where('verifikator<>1');
		// $cekdata = $this->db->get()->result();
		// echo "<pre>";
		// echo var_dump ($cekdata);
		// echo "</pre>";
		$totaldata1 = $this->db->get()->num_rows();
		$this->db->from('tb_video tv');
		$this->db->join('tb_mentor_calver_daf tm', 'tm.npsn_sekolah = tv.npsn_user', 'left');
		$this->db->join('tb_user tu', 'tv.id_user = tu.id', 'left');
		$this->db->where('tm.kode_event',$koderef);
		$this->db->where('verifikator<>1');
		$this->db->where('(status_verifikasi=2)');		
		$totaldata2 = $this->db->get()->num_rows();
		$data['jml_video_kontri'] = $totaldata1;	
		$data['jml_video_kontriok'] = $totaldata2;	
		return $data;
	}

	public function hitungvideoall2($koderef)
	{
		// $this->db->select ('tm.id_calver as id_user, count(tv.kode_video) as jml_video_kontri,
		//  sum(if(tv.status_verifikasi="2" && tv.id_user<>tm.id_calver,1,0)) as jml_video_kontriok');
		$this->db->select ('tm.id_calver as id_user, sum(if(tv.id_user<>tm.id_calver,1,0)) as jml_video_kontri, 
		sum(if(tv.status_verifikasi="2" && tv.id_user<>tm.id_calver,1,0)) as jml_video_kontriok');
		$this->db->from('tb_video tv');
		$this->db->join('tb_mentor_calver_daf tm', 'tm.npsn_sekolah = tv.npsn_user', 'left');
		$this->db->join('tb_user tu', 'tv.id_user = tu.id', 'left');
		$this->db->where('tm.kode_event',$koderef);
		$this->db->group_by('id_calver');
		$this->db->order_by('id_calver', 'asc');
        $result = $this->db->get()->result_array();
		return $result;
	}

	public function hitungsiswa()
	{
		$iduser = $this->session->userdata('id_user');
		$data = array();
		$this->db->from('tb_user');
		$this->db->where('npsn',$this->session->userdata('npsn'));	
		$this->db->where('sebagai',2);	
		$totaldata1 = $this->db->get()->num_rows();
		$data['jml_siswa'] = $totaldata1;		
		return $data;
	}

	public function cekadaver($npsn)
	{
		$this->db->from('tb_user');
		$this->db->where('npsn', $npsn);
		$this->db->where('sebagai', 1);
		$this->db->where('verifikator', 3);
		$result = $this->db->get()->row();
		return $result;
	}

	public function cekisiref($npsn)
	{
		$this->db->from('tb_user');
		$this->db->where('npsn', $npsn);
		$this->db->where('sebagai', 1);
		$this->db->where('verifikator', 3);
		$this->db->where('referrer!=""');
		$result = $this->db->get()->row();
		return $result;
	}

	public function cekrefevent($ref)
	{
		$this->db->from('tb_marketing');
		$this->db->where('kode_referal', $ref);
		$result = $this->db->get()->row();
		return $result;
	}

	public function gettugasevent($ref)
	{
		$this->db->from('tb_mentor_calver_tugas');
		$this->db->where('kode_event', $ref);
		$result = $this->db->get()->row();
		
		return $result;
	}

	public function getdafeventcalver($kodeevent, $status=null, $iduser=null)
	{
		$this->db->select("tm.status as statuscalver, tm.jml_video as jmlvideocalver, tm.*, tu.*, ds.*");
		$this->db->from('tb_mentor_calver_daf tm');
		$this->db->join('tb_user tu', 'tu.id = tm.id_calver', 'left');
		$this->db->join('daf_chn_sekolah ds', 'tm.npsn_sekolah = ds.npsn', 'left');
		$this->db->where('tm.kode_event', $kodeevent);
		if ($status!=null)
		$this->db->where('tm.status', $status);
		if ($iduser!=null)
		$this->db->where('tm.id_calver', $iduser);
		$this->db->order_by("tm.id_calver");
		$result = $this->db->get()->result();
		
		return $result;
	}

	public function addtbMentorCalverDaf($kodeevent, $npsn)
	{
		$this->db->from('tb_mentor_calver_daf');
		$this->db->where('kode_event',$kodeevent);
		$this->db->where('id_calver',$this->session->userdata('id_user'));
		$data = array("kode_event"=>$kodeevent, "id_calver"=>$this->session->userdata('id_user'),
		"npsn_sekolah"=>$npsn);
		if (!$this->db->get()->result())
			$this->db->insert('tb_mentor_calver_daf', $data);
	}

	public function getVideoCalver($koderef)
    {
        $this->db->from('tb_video tv');
		$this->db->join('tb_marketing tm', 'tv.id_event = tm.id', 'left');
        $this->db->where('kode_referal', $koderef);
        $result = $this->db->get()->result();
        return $result;
    }

	public function getVideoCalver2($koderef)
    {
		$this->db->select ('tv.id_user as id_user, count(tv.kode_video) as jml_video,
		 sum(if(tv.status_verifikasi="2",1,0)) as jml_videook');
        $this->db->from('tb_video tv');
		$this->db->join('tb_marketing tm', 'tv.id_event = tm.id', 'left');
        $this->db->where('kode_referal', $koderef);
		$this->db->group_by('id_user');
		$this->db->order_by('id_user', 'asc');
        $result = $this->db->get()->result_array();
        return $result;
    }

	public function getVideoCalverAll($koderef)
    {

		$this->db->from('tb_video tv');
        $this->db->join('tb_mentor_calver_daf td','td.id_calver = tv.id_user', 'left');
		$this->db->join('tb_marketing tm', 'tv.id_event = tm.id', 'left');
        $this->db->where('kode_referal', $koderef);
        $result = $this->db->get()->result();
        return $result;
    }

	public function getVideoKontri($npsn, $sebagai)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('m');
		$bulanskr = intval($tglsekarang);
		$tahunskr = $now->format('Y');
		$idku = $this->session->userdata('id_user');

		$this->db->select('tu.*, MAX(tb.strata_paket) as strata, 1 as ranking,dk.nama_kota');
		$this->db->from('tb_user tu');
		$this->db->join('tb_vk_beli tb','tu.id=tb.id_user AND 
		month(`tgl_batas`) = '. $bulanskr . ' AND 
		year(`tgl_batas`) = '. $tahunskr . ' AND jenis_paket=1 AND status_beli=2','left');
		$this->db->join('daf_kota dk', 'tu.kd_kota = dk.id_kota');
		$this->db->where('tu.id='.$idku.' AND npsn="' . $npsn . '"');
		if ($sebagai=="guru")
			$this->db->where('sebagai',1);
		else if ($sebagai=="siswa")
			$this->db->where('sebagai',2);
		if ($this->session->userdata('verifikator')==1)
			$this->db->where('kontributor',1);

		$this->db->group_by('tu.id');

//		$this->db->where('jenis_paket=1 AND status_beli=2');
//		$this->db->where('(month(`tgl_batas`) = ' . $bulanskr . ')');

		$query1 = $this->db->get_compiled_select();

		$this->db->select('tu.*, MAX(tb.strata_paket) as strata, 2 as ranking,dk.nama_kota');
		$this->db->from('tb_user tu');
		$this->db->join('tb_vk_beli tb','tu.id=tb.id_user AND 
		month(`tgl_batas`) = '. $bulanskr . ' AND 
		year(`tgl_batas`) = '. $tahunskr . ' AND jenis_paket=1 AND status_beli=2','left');
		$this->db->join('daf_kota dk', 'tu.kd_kota = dk.id_kota');
		$this->db->where('tu.id!=1 AND tu.id!='.$idku.' AND npsn="' . $npsn . '"');
		if ($sebagai=="guru")
			$this->db->where('sebagai',1);
		else if ($sebagai=="siswa")
			$this->db->where('sebagai',2);

//		$this->db->where('jenis_paket=1 AND status_beli=2');
//		$this->db->where('(month(`tgl_batas`) = ' . $bulanskr . ')');

		$this->db->group_by('tu.id');
		$this->db->order_by('ranking', 'asc');
		$this->db->order_by('sebagai', 'asc');
		$this->db->order_by('verifikator', 'desc');
		$this->db->order_by('kontributor', 'desc');
		$this->db->order_by('first_name', 'asc');

		$query2 = $this->db->get_compiled_select();

		$query = $this->db->query($query1 . ' UNION ' . $query2);
		$query = $query->result();

		return $query;
	}

	public function updateDafMentorCalver($data)
    {
		$this->db->from('tb_mentor_calver_daf');
        $this->db->where('id_calver', $this->session->userdata('id_user'));
        $result = $this->db->get()->result();
       	if ($result)
        $this->db->update_batch('tb_mentor_calver_daf', $data, 'id_calver');
    }

	
}
