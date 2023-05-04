<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_channel2 extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function getVODAll()
	{
		$this->db->select('tv.*,first_name');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->where('((status_verifikasi=4 AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!="") OR (status_verifikasi=4 AND link_video!=""))');
		$this->db->where('sifat', 0);
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(status_verifikasi<>0)');
		$this->db->order_by('modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getSekolah()
	{
		$this->db->from('daf_sekolah');
		$this->db->where('status', 1);
		$this->db->order_by('created', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getSekolahLain($npsn = null, $all = null)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$hari = $now->format('N');

//		echo "HARI:".$hari;
//		die();

		$this->db->from('daf_chn_sekolah ds');
		$this->db->join('tb_paket_channel_sekolah tp', 'ds.npsn = tp.npsn', 'left');
		if ($npsn != "")
			$this->db->where('(ds.npsn<>' . $npsn . ')');
		$this->db->where('status', 1);
		$this->db->group_by("tp.npsn");
//		if ($buattes != null)
//			$this->db->where('tp.hari', $buattes);
//		else
		$this->db->where('tp.hari', $hari);
		// $this->db->where('tp.durasi_paket>=', '01:30:00');
		$this->db->where('(status_paket>0)');
		$this->db->where('(ds.npsn<>"10000010" AND ds.npsn<>"10000002")');
		$this->db->order_by('ds.modified', 'desc');
//		if ($all == null)
//			$this->db->limit(10);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllSekolah($opsi=null)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$hari = $now->format('N');
		$tglskr = $now->format('Y-m-d H:i:s');

		$this->db->select('IF(tp.hari='.$hari.',"ada","zonk") as cekhari,ds.*,tp.*');
		$this->db->from('daf_chn_sekolah ds');
		$this->db->join('tb_paket_channel_sekolah tp', 'ds.npsn = tp.npsn', 'left');

		$this->db->where('status', 1);

		if ($opsi=="home")
		$this->db->where('kadaluwarsa>=', $tglskr);
		
		$this->db->group_by("tp.npsn, cekhari");

		//$this->db->where('(status_paket>0)');
		$this->db->where('(ds.npsn<>"10000010" AND ds.npsn<>"10000002")');
		$this->db->where('tp.hari', $hari);
		// $this->db->where('tp.durasi_paket>=', '01:30:00');

		

		if ($opsi=="home")
		{
			$this->db->order_by('durasi_paket', 'desc');
			$this->db->limit(10, 0);
		}
		else
		{
			$this->db->order_by('kadaluwarsa', 'desc');
			$this->db->order_by('cekhari', 'asc');
			$this->db->order_by('status_paket', 'desc');
		}

		$result = $this->db->get()->result();
		return $result;
	}

	public function getSekolahKu($npsn)
	{
		$this->db->from('daf_chn_sekolah');
		$this->db->where('status>=', 0);
		$this->db->where('npsn',$npsn);
		$this->db->order_by('created', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function insertkeDafSekolahKu($npsn)
	{
		$this->db->query('INSERT daf_chn_sekolah (npsn, idkota, nama_sekolah) SELECT npsn, id_kota, nama_sekolah ' .
			'FROM daf_sekolah WHERE npsn = ' . $npsn);
	}

	public function getPlayList($npsn)
	{
		$this->db->from('tb_channel_video tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->where('(npsn=' . $npsn . ')');
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('urutan', 'asc');
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

	public function getPlayListSaya($idsaya, $link_list)
	{
		$this->db->from('tb_channel_video tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_channel tpc', 'tpc.id = tcv.id_paket', 'left');
		$this->db->where('(tv.id_user=' . $idsaya . ')');
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(tpc.link_list="' . $link_list . '")');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPlayListGuru($npsn, $link_list)
	{
		$this->db->from('tb_channel_video tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_channel tpc', 'tpc.id = tcv.id_paket', 'left');
		$this->db->where('(tv.npsn_user=' . $npsn . ')');
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(tpc.link_list="' . $link_list . '")');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPlayListAll($idsaya, $link_list)
	{
		$this->db->from('tb_channel_video tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_channel tpc', 'tpc.id = tcv.id_paket', 'left');
		$this->db->where('(tv.id_user=' . $idsaya . ')');
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(tpc.link_list="' . $link_list . '")');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPlayListBimbel($link_list, $idsaya = null)
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

	public function getPlayListBimbelSaya($link_list, $idsaya = null)
	{
		$this->db->from('tb_channel_bimbel tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_bimbel tpc', 'tpc.id = tcv.id_paket', 'left');
		$this->db->where('(tpc.id_user=' . $idsaya . ')');
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

	public function getPlayListSekolah($npsn, $link_list)
	{
		$this->db->from('tb_video tv');
		$this->db->join('tb_channel_video_sekolah tcv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_channel_sekolah tpc', 'tpc.id = tcv.id_paket', 'left');
		$this->db->where('(tcv.npsn=' . $npsn . ')');
		$this->db->where('(tpc.link_list="' . $link_list . '")');
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->order_by('dilist', 'desc');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPlayListSekolahAll($npsn, $link_list)
	{
		$this->db->from('tb_channel_video_sekolah tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_channel_sekolah tpc', 'tpc.id = tcv.id_paket', 'left');
		$this->db->where('(tcv.npsn=' . $npsn . ')');
		$this->db->where('(tpc.link_list="' . $link_list . '")');
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPlayListTVE($link_list)
	{
		$this->db->from('tb_video tv');
		$this->db->join('tb_channel_video_tve tcv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_channel_tve tpc', 'tpc.id = tcv.id_paket', 'left');
		$this->db->where('(tpc.link_list="' . $link_list . '")');
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(tcv.id_video>0)');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPlayListTVEAll($link_list)
	{
		$this->db->from('tb_channel_video_tve tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_channel_tve tpc', 'tpc.id = tcv.id_paket', 'left');
		$this->db->where('(tpc.link_list="' . $link_list . '")');
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafPlayListSaya($idsaya, $iduser = null, $kodebeli = null, $jenis = null)
	{
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->join('daf_kelas dk','dk.id = tpc.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tpc.id_mapel','left');
//		$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "' .
//			$kodebeli . '" AND tk.jenis_paket = ' . $jenis . ' AND tk.id_user = ' . $iduser, 'left');
//		$this->db->where('(urutan=0 OR urutan=1)');
		$this->db->where('(tpc.id_user=' . $idsaya . ')');
		$this->db->where('tv.id_video IS NOT NULL');
		$this->db->where('status_paket>',0);
		$this->db->where('uraianmateri<>',"");
		$this->db->where('statussoal>',0);
		$this->db->where('statustugas>',0);
		$this->db->group_by('link_list');
		$this->db->order_by('semester','asc');
		$this->db->order_by('modulke','asc');
		$this->db->order_by('tpc.id_kelas','asc');
		$this->db->order_by('tpc.id_mapel','asc');

		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafPlayListGuru($npsn)
	{
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->join('daf_kelas dk','dk.id = tpc.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tpc.id_mapel','left');
//		$this->db->join('tb_virtual_kelas tk', 'tk.link_paket = tpc.link_list AND tk.kode_beli = "' .
//			$kodebeli . '" AND tk.jenis_paket = ' . $jenis . ' AND tk.id_user = ' . $iduser, 'left');
//		$this->db->where('(urutan=0 OR urutan=1)');
		$this->db->where('(tpc.npsn_user=' . $npsn . ')');
		$this->db->where('tv.id_video IS NOT NULL');
		$this->db->where('status_paket>',0);
		$this->db->where('uraianmateri<>',"");
		$this->db->where('statussoal>',0);
		$this->db->where('statustugas>',0);
		$this->db->group_by('link_list');
		$this->db->order_by('semester','asc');
		$this->db->order_by('modulke','asc');
		$this->db->order_by('tpc.id_kelas','asc');
		$this->db->order_by('tpc.id_mapel','asc');

		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafPlayListMapel($npsn, $idkelas)
	{
		$this->db->select('tpc.id_mapel,tpc.id_kelas,tpc.*');
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->where('tpc.id_kelas', $idkelas);
		$this->db->where('(tpc.npsn_user=' . $npsn . ')');
		$this->db->where('tv.id_video IS NOT NULL');
		$this->db->where('status_paket>',0);
		$this->db->where('uraianmateri<>',"");
		$this->db->where('statussoal>',0);
		$this->db->where('statustugas>',0);
		$this->db->where('tpc.id_mapel>',0);
		$this->db->group_by('tpc.id_mapel');

		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafBimbelSaya($idsaya, $iduser = null, $kodebeli = null, $jenis = null)
	{
//		$this->db->select('tpc.nama_paket, tpc.id_user, tv.id_video');
		$this->db->from('tb_paket_bimbel tpc');
		$this->db->join('tb_channel_bimbel tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->join('daf_kelas dk','dk.id = tpc.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tpc.id_mapel','left');
		$this->db->where('(tpc.id_user=' . $idsaya . ')');
		$this->db->where('tv.id_video IS NOT NULL');
		$this->db->where('status_paket>',0);
		$this->db->where('uraianmateri<>',"");
		$this->db->where('statussoal>',0);
		$this->db->where('statustugas>',0);
		$this->db->group_by('link_list');
		$this->db->order_by('status_paket', 'asc');
		$this->db->order_by('tanggal_tayang', 'desc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafPlayListBimbel($opsi = null)
	{
		$this->db->from('tb_paket_bimbel tpc');
		$this->db->join('tb_channel_bimbel tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
//		$this->db->where('(urutan=0 OR urutan=1)');
		//$this->db->where('(tpc.id_user=' . $idsaya . ')');
		$this->db->group_by('nama_paket');
		$this->db->order_by('status_paket', 'asc');
		$this->db->order_by('tanggal_tayang', 'desc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafPlayListSekolah($npsn, $tayang, $hari)
	{
		$this->db->from('tb_paket_channel_sekolah tpc');
		$this->db->join('tb_channel_video_sekolah tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
//		$this->db->where('(urutan=0 OR urutan=1)');
		$this->db->where('(tpc.npsn=' . $npsn . ')');
		$this->db->where('(tpc.tayang=' . $tayang . ')');
		$this->db->where('(tpc.hari=' . $hari . ')');
		$this->db->group_by('nama_paket');
		$this->db->order_by('status_paket', 'asc');
		$this->db->order_by('jam_tayang', 'desc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafPlayListTVE($tayang, $hari)
	{
		// $hari = 6;
		$this->db->from('tb_paket_channel_tve tpc');
		$this->db->join('tb_channel_video_tve tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
//		$this->db->where('(urutan=0 OR urutan=1)');
		$this->db->where('(tpc.tayang=' . $tayang . ')');
		$this->db->where('(tpc.hari=' . $hari . ')');
		$this->db->group_by('nama_paket');
		$this->db->order_by('status_paket', 'asc');
		$this->db->order_by('jam_tayang', 'desc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}


	public function getPaketGuru($id_user, $id_event)
	{
		$this->db->from('tb_paket_channel');
		$this->db->where('id_user', $id_user);
		if ($id_event > 0)
			$this->db->where('id_event', $id_event);
		$this->db->order_by('tanggal_tayang', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPaketBuatModul($id_user, $idevent)
	{
		$this->db->select('*,IF(modulke=0,100,modulke) as modulke,dk.nama_kelas,dm.nama_mapel');
		$this->db->from('tb_paket_channel tp');
		$this->db->join('daf_kelas dk','dk.id = tp.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tp.id_mapel','left');
		$this->db->where('id_user', $id_user);
		$this->db->where('id_event', $idevent);
		$this->db->order_by('id_kelas', 'asc');
		$this->db->order_by('semester', 'asc');
		$this->db->order_by('id_mapel', 'asc');
		$this->db->order_by('modulke', 'asc');
		$this->db->order_by('tanggal_tayang', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPaketBuatBimbel($id_user, $idevent)
	{
		$this->db->select('*,dk.nama_kelas,dm.nama_mapel');
		$this->db->from('tb_paket_bimbel tp');
		$this->db->join('daf_kelas dk','dk.id = tp.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tp.id_mapel','left');
		$this->db->where('id_user', $id_user);
		$this->db->where('id_event', $idevent);
		$this->db->order_by('id_kelas', 'asc');
		$this->db->order_by('semester', 'asc');
		$this->db->order_by('id_mapel', 'asc');
		$this->db->order_by('tanggal_tayang', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPaketBimbel($id_user, $id_event)
	{
		$this->db->from('tb_paket_bimbel tp');
		$this->db->where('id_user', $id_user);
		$this->db->join('daf_kelas dk','dk.id = tp.id_kelas','left');
		$this->db->join('daf_mapel dm','dm.id = tp.id_mapel','left');
		if ($id_event > 0)
			$this->db->where('id_event', $id_event);
		$this->db->order_by('id_kelas', 'asc');
		$this->db->order_by('semester', 'asc');
		$this->db->order_by('id_mapel', 'asc');
		$this->db->order_by('tanggal_tayang', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPaketSekolah($npsn)
	{
		$this->db->select('tpc.*,tu.first_name,tu.last_name');
		$this->db->from('tb_paket_channel_sekolah tpc');
		$this->db->join('tb_user tu', 'tu.id = tpc.iduser', 'left');
		$this->db->where('tpc.npsn', $npsn);
		$this->db->order_by('hari', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPaketTVSekolah()
	{
		$this->db->select('tpc.*');
		$this->db->from('tb_paket_channel_tve tpc');
		$this->db->order_by('hari', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPaketSekolahEvent($kodeevent,$id)
	{
		$this->db->select('tpc.*,tu.first_name,tu.last_name');
		$this->db->from('tb_paket_channel_sekolah tpc');
		$this->db->join('tb_event te', 'te.code_event = tpc.nama_paket', 'left');
		$this->db->join('tb_user tu', 'tu.id = tpc.iduser', 'left');
		$this->db->where('te.link_event', $kodeevent);
		$this->db->where('tpc.iduser', $id);
		$this->db->where('tpc.jenis_paket', 2);
		$this->db->order_by('hari', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPaketTVE()
	{
		$this->db->from('tb_paket_channel_tve');
		$this->db->order_by('hari', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getChannelGuru($npsn)
	{
		$this->db->from('tb_user tu');
		$this->db->join('tb_paket_channel tpc', 'tu.id = tpc.id_user', 'right');
		$this->db->where('npsn', $npsn);
		$this->db->order_by('level', 'desc');
		$this->db->group_by('tu.id');
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

	public function getInfoSekolah($npsn)
	{
		$this->db->from('daf_chn_sekolah');
		$this->db->where('npsn', $npsn);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVODSekolah($npsn)
	{
		$this->db->select('tv.*,first_name');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->where('((status_verifikasi=4 AND id_jenis=1) OR (status_verifikasi=2 AND id_jenis=2) 
        OR (status_verifikasi=4 AND file_video!="") OR (status_verifikasi=4 AND link_video!=""))');
		if (!$this->session->userdata('a01'))
			$this->db->where('npsn', $npsn);
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('sifat', 0);
		$this->db->order_by('modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVODGuru($kd_user)
	{
		$this->db->select('tv.*,first_name');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->where('(link_video!="")');
		$this->db->where('id_user', $kd_user);
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->order_by('modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}


	public function getVODList($kd_user)
	{
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->where('id_user', $kd_user);
		$this->db->where('dilist', 1);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getChannelAll()
	{
		$this->db->from('daf_sekolah');
		$this->db->order_by('created', 'desc');
		//$this->db->limit(100);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getChannelSiap($batas)
	{
		$this->db->select('max(tu.verifikator),tu.hp, tu.email, tu.first_name, nama_pendek as jenjang, tu.last_name,dk.*, dcs.*');
		$this->db->from('daf_chn_sekolah dcs');
		$this->db->join('daf_kota dk', 'dcs.idkota=dk.id_kota', 'left');
		// $this->db->join('daf_kelas dkl', 'dkl.id=dcs.idjenjang', 'left');
		$this->db->join('daf_jenjang dj', 'dj.id=dcs.idjenjang', 'left');
		$this->db->join('tb_user tu','dcs.npsn=tu.npsn AND verifikator=3','left');
		$this->db->where('(dcs.status>=0)');
		$this->db->where('(dcs.idjenjang>=0)');
		$this->db->group_by('dcs.npsn');
		$this->db->order_by('dcs.strata_sekolah', 'desc');
		$this->db->order_by('dcs.modified', 'desc');
		if ($batas > 0)
			$this->db->limit($batas);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getChannelStatistik($mulai = null, $sampai = null)
	{
		$tglmulai = "";
		$tglsampai = "";
		//echo $mulai."<br>";

		if ($mulai != null) {
			$tgl1 = new DateTime($mulai . " 00:00:00");
			$tgl1->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglmulai = $tgl1->format('Y-m-d H-i-s');
			//echo "TGLMULAI".$tglmulai.'<br>';
		}
		if ($sampai != null) {
			$tgl2 = new DateTime($sampai . " 23:59:59");
			$tgl2->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsampai = $tgl2->format('Y-m-d H-i-s');
			//echo "TGLSAMPAI".$tglsampai.'<br>';
		}

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('m');
		$bulanskr = intval($tglsekarang);
		$tahunskr = $now->format('Y');
		//$this->db->select('ds.*, count(tu.npsn) as jml_guru1, count(tu2.npsn) as jml_guru2');
		$this->db->select('ds.*, count(tu.first_name) as jmlver, 0 as jmlkon, 
		0 as jmlsis, 0 as jmlnontonskl, 0 as jmlnontonguru, 0 as jmlvideo, 0 as channelguru, 0 as jmlpaket');
		$this->db->from('daf_chn_sekolah ds');
		$this->db->join('tb_user tu', 'tu.npsn = ds.npsn', 'inner');
		$this->db->group_by('ds.npsn');
		$this->db->where('((tu.sebagai=1 AND tu.verifikator=3))');
		$this->db->where('(ds.npsn<>"")');
		$query1 = $this->db->get_compiled_select();

		$this->db->select('ds.*, 0 as jmlver, count(tu2.first_name) as jmlkon, 
		0 as jmlsis, 0 as jmlnontonskl, 0 as jmlnontonguru, 0 as jmlvideo, 
		0 as channelguru, 0 as jmlpaket');
		$this->db->from('daf_chn_sekolah ds');
		$this->db->join('tb_user tu2', 'tu2.npsn = ds.npsn', 'inner');
		$this->db->group_by('ds.npsn');
		$this->db->where('((tu2.sebagai=1 AND tu2.kontributor=3))');
		$this->db->where('(ds.npsn<>"")');
		$query2 = $this->db->get_compiled_select();

		$this->db->select('ds.*, 0 as jmlver, 0 as jmlkon, count(tu3.first_name) as jmlsis, 
		0 as jmlnontonskl, 0 as jmlnontonguru, 0 as jmlvideo, 0 as channelguru, 0 as jmlpaket');
		$this->db->from('daf_chn_sekolah ds');
		$this->db->join('tb_user tu3', 'tu3.npsn = ds.npsn', 'inner');
		$this->db->group_by('ds.npsn');
		$this->db->where('(tu3.sebagai=2)');
		$this->db->where('(ds.npsn<>"")');
		$query3 = $this->db->get_compiled_select();

		$this->db->select('ds.*, 0 as jmlver, 0 as jmlkon, 0 as jmlsis, 
		sum(tn.durasi) as jmlnontonskl, 0 as jmlnontonguru, 0 as jmlvideo, 
		0 as channelguru, 0 as jmlpaket');
		$this->db->from('daf_chn_sekolah ds');
		$this->db->join('tb_nonton tn', 'tn.npsn_sekolah = ds.npsn', 'inner');
		$this->db->group_by('ds.npsn');
		if ($mulai == null && $sampai == null)
			$this->db->where('(month(`tanggal`) = '.$bulanskr.' AND year(`tanggal`) = '.$tahunskr.')');
		else if ($mulai != null && $sampai == null)
			$this->db->where('(tanggal >= (' . $tglmulai . '))');
		else if ($mulai == null && $sampai != null)
			$this->db->where('(tanggal <= (' . $tglsampai . '))');
		else if ($mulai != null && $sampai != null)
			$this->db->where('(tanggal >= date("' . $tglmulai . '") AND tanggal <= date("' . $tglsampai . '"))');
		$this->db->where('(ds.npsn<>"")');
		$query4 = $this->db->get_compiled_select();

		$this->db->select('ds.*, 0 as jmlver, 0 as jmlkon, 0 as jmlsis, 0 as jmlnontonskl, 
		sum(tn.durasi) as jmlnontonguru, 0 as jmlvideo, 0 as channelguru, 0 as jmlpaket');
		$this->db->from('daf_chn_sekolah ds');
		$this->db->join('tb_nonton tn', 'tn.npsn_guru = ds.npsn', 'inner');
		$this->db->group_by('ds.npsn');
		$this->db->where('(month(`tanggal`) = '.$bulanskr.' AND year(`tanggal`) = '.$tahunskr.')');
		$this->db->where('(ds.npsn<>"")');
		$query5 = $this->db->get_compiled_select();

		$this->db->select('ds.*, 0 as jmlver, 0 as jmlkon, 0 as jmlsis, 0 as jmlnontonskl, 
		0 as jmlnontonguru, count(tv.id_video) as jmlvideo, 0 as channelguru, 0 as jmlpaket');
		$this->db->from('daf_chn_sekolah ds');
		$this->db->join('tb_video tv', 'tv.npsn_user = ds.npsn', 'inner');
		$this->db->group_by('ds.npsn');
		$this->db->where('(status_verifikasi=2 OR status_verifikasi=4)');
		$query6 = $this->db->get_compiled_select();

		$this->db->select('ds.*, 0 as jmlver, 0 as jmlkon, 0 as jmlsis, 0 as jmlnontonskl,
		0 as jmlnontonguru, 0 as jmlvideo, count(DISTINCT tp.id_user) as channelguru, 0 as jmlpaket');
		$this->db->from('daf_chn_sekolah ds');
		$this->db->join('tb_paket_channel tp', 'tp.npsn_user = ds.npsn', 'inner');
		$this->db->group_by('ds.npsn');
		$query7 = $this->db->get_compiled_select();

		$this->db->select('ds.*, 0 as jmlver, 0 as jmlkon, 0 as jmlsis, 0 as jmlnontonskl,
		0 as jmlnontonguru, 0 as jmlvideo, 0 as channelguru, count(tp.id) as jmlpaket');
		$this->db->from('daf_chn_sekolah ds');
		$this->db->join('tb_paket_channel tp', 'tp.npsn_user = ds.npsn', 'inner');
		$this->db->group_by('ds.npsn');
		$query8 = $this->db->get_compiled_select();

		$query = $this->db->query($query1 . ' UNION ALL ' . $query2 .
			' UNION ALL ' . $query3 . ' UNION ALL ' . $query4 .
			' UNION ALL ' . $query5 . ' UNION ALL ' . $query6 .
			' UNION ALL ' . $query7 . ' UNION ALL ' . $query8);
		$query = $query->result();

		return $query;
	}

	public function retrieveStatistikAE($hal = null, $berdasar = null, $prop = null, $kab = null, $jenjang = null, $tampil = null)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$db2 = $this->load->database('sekolah', TRUE);

		$db2->select('ds.*, count(tu.first_name) as jmlver, 0 as jmlkon, 
		0 as jmlsis, 0 as jmlnontonskl, 0 as jmlnontonguru, 0 as jmlvideo, 0 as channelguru, 0 as jmlpaket');
		$db2->from('daf_chn_sekolah ds');
		$db2->join('tb_user tu', 'tu.npsn = ds.npsn', 'inner');
		$db2->group_by('ds.npsn');
		$db2->where('((tu.sebagai=1 AND tu.verifikator=3))');
		$db2->where('(ds.npsn<>"")');
		$db2->where('(idjenjang>0)');
		// $db2->where('(batas_sponsor<"'.$tglsekarang.'")');
		$query1 = $db2->get_compiled_select();

		$db2->select('ds.*, 0 as jmlver, count(tu2.first_name) as jmlkon, 
		0 as jmlsis, 0 as jmlnontonskl, 0 as jmlnontonguru, 0 as jmlvideo, 
		0 as channelguru, 0 as jmlpaket');
		$db2->from('daf_chn_sekolah ds');
		$db2->join('tb_user tu2', 'tu2.npsn = ds.npsn', 'inner');
		$db2->group_by('ds.npsn');
		$db2->where('((tu2.sebagai=1 AND tu2.kontributor=3))');
		$db2->where('(ds.npsn<>"")');
		$db2->where('(idjenjang>0)');
		// $db2->where('(batas_sponsor<"'.$tglsekarang.'")');
		$query2 = $db2->get_compiled_select();

		$db2->select('ds.*, 0 as jmlver, 0 as jmlkon, count(tu3.first_name) as jmlsis, 
		0 as jmlnontonskl, 0 as jmlnontonguru, 0 as jmlvideo, 0 as channelguru, 0 as jmlpaket');
		$db2->from('daf_chn_sekolah ds');
		$db2->join('tb_user tu3', 'tu3.npsn = ds.npsn', 'inner');
		$db2->group_by('ds.npsn');
		$db2->where('(tu3.sebagai=2)');
		$db2->where('(ds.npsn<>"")');
		$db2->where('(idjenjang>0)');
		// $db2->where('(batas_sponsor<"'.$tglsekarang.'")');
		$query3 = $db2->get_compiled_select();

		$db2->select('ds.*, 0 as jmlver, 0 as jmlkon, 0 as jmlsis, 
		sum(tn.durasi) as jmlnontonskl, 0 as jmlnontonguru, 0 as jmlvideo, 
		0 as channelguru, 0 as jmlpaket');
		$db2->from('daf_chn_sekolah ds');
		$db2->join('tb_nonton tn', 'tn.npsn_sekolah = ds.npsn', 'inner');
		$db2->group_by('ds.npsn');
		$db2->where('(ds.npsn<>"")');
		$db2->where('(idjenjang>0)');
		// $db2->where('(batas_sponsor<"'.$tglsekarang.'")');
		$query4 = $db2->get_compiled_select();

		$db2->select('ds.*, 0 as jmlver, 0 as jmlkon, 0 as jmlsis, 0 as jmlnontonskl, 
		sum(tn.durasi) as jmlnontonguru, 0 as jmlvideo, 0 as channelguru, 0 as jmlpaket');
		$db2->from('daf_chn_sekolah ds');
		$db2->join('tb_nonton tn', 'tn.npsn_guru = ds.npsn', 'inner');
		$db2->group_by('ds.npsn');
		$db2->where('(ds.npsn<>"")');
		$db2->where('(idjenjang>0)');
		// $db2->where('(batas_sponsor<"'.$tglsekarang.'")');
		$query5 = $db2->get_compiled_select();

		$db2->select('ds.*, 0 as jmlver, 0 as jmlkon, 0 as jmlsis, 0 as jmlnontonskl, 
		0 as jmlnontonguru, count(tv.id_video) as jmlvideo, 0 as channelguru, 0 as jmlpaket');
		$db2->from('daf_chn_sekolah ds');
		$db2->join('tb_video tv', 'tv.npsn_user = ds.npsn', 'inner');
		$db2->group_by('ds.npsn');
		$db2->where('(status_verifikasi=2 OR status_verifikasi=4)');
		$db2->where('(idjenjang>0)');
		// $db2->where('(batas_sponsor<"'.$tglsekarang.'")');
		$query6 = $db2->get_compiled_select();

		$db2->select('ds.*, 0 as jmlver, 0 as jmlkon, 0 as jmlsis, 0 as jmlnontonskl,
		0 as jmlnontonguru, 0 as jmlvideo, count(DISTINCT tp.id_user) as channelguru, 0 as jmlpaket');
		$db2->from('daf_chn_sekolah ds');
		$db2->join('tb_paket_channel tp', 'tp.npsn_user = ds.npsn', 'inner');
		$db2->group_by('ds.npsn');
		$db2->where('(idjenjang>0)');
		// $db2->where('(batas_sponsor<"'.$tglsekarang.'")');
		$query7 = $db2->get_compiled_select();

		$db2->select('ds.*, 0 as jmlver, 0 as jmlkon, 0 as jmlsis, 0 as jmlnontonskl,
		0 as jmlnontonguru, 0 as jmlvideo, 0 as channelguru, count(tp.id) as jmlpaket');
		$db2->from('daf_chn_sekolah ds');
		$db2->join('tb_paket_channel tp', 'tp.npsn_user = ds.npsn', 'inner');
		$db2->group_by('ds.npsn');
		$db2->where('(idjenjang>0)');
		// $db2->where('(batas_sponsor<"'.$tglsekarang.'")');
		$query8 = $db2->get_compiled_select();

		$query = $db2->query(($query1) . ' UNION ALL ' . ($query2) .
			' UNION ALL ' . ($query3) . ' UNION ALL ' . $query4 .
			' UNION ALL ' . $query5 . ' UNION ALL ' . $query6 .
			' UNION ALL ' . $query7 . ' UNION ALL ' . $query8);

//		$db2->select('ds.*, count(tu.first_name) as jmlver, 0 as jmlkon,
//		0 as jmlsis, 0 as jmlnontonskl, 0 as jmlnontonguru, 0 as jmlvideo, 0 as channelguru, 0 as jmlpaket');
//		$db2->from('daf_chn_sekolah ds');
//		$db2->join('tb_user tu', 'tu.npsn = ds.npsn', 'inner');
//		$db2->group_by('ds.npsn');
//		$db2->where('((tu.sebagai=1 AND tu.verifikator=3))');
//		$db2->where('(ds.npsn<>"")');
//		$query1 = $db2->get_compiled_select();

		$query = $query->result();

		$data = array();
		$this->db->empty_table("tb_statistik_ae");
		$this->db->query("ALTER TABLE tb_statistik_ae AUTO_INCREMENT 1");
		$a = 0;
		foreach ($query as $row) {
			$a++;
			$data[$a]["nama_sekolah"] = $row->nama_sekolah;
			$data[$a]["npsn"] = $row->npsn;
			$data[$a]["idkota"] = $row->idkota;
			$data[$a]["idjenjang"] = $row->idjenjang;
			$data[$a]["jmlver"] = $row->jmlver;
			$data[$a]["jmlkontri"] = $row->jmlkon;
			$data[$a]["jmlsiswa"] = $row->jmlsis;
			$data[$a]["jmlchguru"] = $row->channelguru;
			$data[$a]["jmlkelas"] = $row->jmlpaket;
			$data[$a]["jmlkonten"] = $row->jmlvideo;
			$data[$a]["tontonguru"] = $row->jmlnontonguru;
			$data[$a]["tontonsekolah"] = $row->jmlnontonskl;
			$data[$a]["haritayang"] = $row->haritayang;
			$data[$a]["totaltayang"] = $row->totaltayang;
		}

		$this->db->insert_batch("tb_statistik_ae", $data);

		return $this->getStatistikAE($hal, $berdasar, $prop, $kab, $jenjang, $tampil);
	}

	public function getchnsekolah()
	{
		$this->db->from('daf_chn_sekolah ds');
//		$this->db->where('npsn','40102731');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getidjenjangdafsekolah($npsn)
	{
		$this->db->from('daf_sekolah ds');
		$this->db->where('npsn', $npsn);
		$query = $this->db->get();
		$ret = $query->row();
		if ($ret) {
			return $ret->id_jenjang;
		} else
			return 0;

	}

	public function updatejenjangchnsekolah($data)
	{
		$result = $this->db->update_batch('daf_chn_sekolah', $data, 'npsn');
		return $result;
	}

	public function updatestratachnsekolah($data, $npsn)
	{
		$this->db->where('npsn', $npsn);
		$result = $this->db->update('daf_chn_sekolah', $data);
		return $result;
	}

	public function getPropinsiAll()
	{
		$this->db->from('daf_propinsi');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getKota($idprop)
	{
		if ($idprop == null)
			$idprop = 0;
		$this->db->from('daf_kota');
		$this->db->where('id_propinsi', $idprop);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getNamaPropinsi($idpropinsi)
	{
		$this->db->where('id_propinsi', $idpropinsi);
		$this->db->from('daf_propinsi');
		$result = $this->db->get()->row();
		return $result;
	}

	public function getNamaKota($idkota)
	{
		$this->db->where('id_kota', $idkota);
		$this->db->from('daf_kota');
		$result = $this->db->get()->row();
		return $result;
	}

	public function getStatistikAE($berdasar = null, $hal = null, $prop = null, $kab = null, $jenjang = null, $tampil = null)
	{
		// $cektanggal = new DateTime();
		// $cektanggal->setTimezone(new DateTimezone('Asia/Jakarta'));
		// $cektanggal->modify('first day of next month');
		// $blnbesok = date_format($cektanggal, 'Y-m');

		// $this->db->from('tb_payment');
		// $this->db->where('(date_format(tgl_order, "%Y-%m")="' . $blnbesok . '")');
		// $this->db->where('(status=3)');
		// $resultnpsn = $this->db->get()->result();

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$arraynpsn = array();

		$db2 = $this->load->database('sekolah', TRUE);
		$db2->from('daf_chn_sekolah');
		$db2->where('(batas_sponsor>"'.$tglsekarang.'")');
		$resultnpsn = $db2->get()->result();
		
		foreach ($resultnpsn as $row) {
			array_push($arraynpsn, $row->npsn);
		}

		$db2->from('daf_chn_sekolah');
		$db2->where('(kadaluwarsa>"'.$tglsekarang.'" AND (strata_sekolah=2 OR strata_sekolah=3 OR strata_sekolah=8 OR strata_sekolah=9))');
		$resultnpsn2 = $db2->get()->result();
		
		foreach ($resultnpsn2 as $row) {
			array_push($arraynpsn, $row->npsn);
		}

		

		$njenjang = array("PAUD" => 1, "SD" => 2, "SMP" => 3, "SMA" => 4, "SMK" => 5, "PT" => 6, "PKBM" => 7);
		$this->db->select('ts.id,ts.npsn,nama_sekolah,npsn,idjenjang,idkota,haritayang,totaltayang,sum(jmlver) as jmlver,sum(jmlkontri) as jmlkontri,
		sum(jmlsiswa) as jmlsiswa,sum(jmlchguru) as jmlchguru,sum(jmlkelas) as jmlkelas,sum(jmlkonten) as jmlkonten,
		sum(tontonguru) as tontonguru,sum(tontonsekolah) as tontonsekolah');
		$this->db->from('tb_statistik_ae ts');

		if (sizeof($arraynpsn) > 0)
			$this->db->where_not_in('npsn', $arraynpsn);

		$this->db->where('(idjenjang>0)');
		$this->db->where('(TIME_TO_SEC(totaltayang)>0)');

		if ($prop != null && $prop != "all") {
			$this->db->join('daf_kota dk', 'dk.id_kota = ts.idkota', 'left');
			$this->db->where('id_propinsi', $prop);
		}

		if ($kab != null && $kab != "all")
			$this->db->where('idkota', $kab);

		if ($jenjang != null && $jenjang != "all")
			$this->db->where('idjenjang', $njenjang[$jenjang]);

		if ($berdasar == null || $berdasar == "siswa")
			$this->db->order_by('jmlsiswa desc');
		else if ($berdasar == "modul")
			$this->db->order_by('jmlkelas desc');
		else if ($berdasar == "video")
			$this->db->order_by('jmlkonten desc');

		$this->db->order_by('id');

		if ($tampil == null)
			$tampil = 5;
		if ($hal == null)
			$this->db->limit($tampil, 0);
		else
			$this->db->limit($tampil, ($hal - 1) * $tampil);

		$this->db->group_by('npsn');

		$result = $this->db->get()->result();
		return $result;
	}

	public function getChannelGuruStatistik($mulai = null, $sampai = null)
	{
		$tglmulai = "";
		$tglsampai = "";
		//echo $mulai."<br>";

		if ($mulai != null) {
			$tgl1 = new DateTime($mulai . " 00:00:00");
			$tgl1->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglmulai = $tgl1->format('Y-m-d H-i-s');
			//echo "TGLMULAI".$tglmulai.'<br>';
		}
		if ($sampai != null) {
			$tgl2 = new DateTime($sampai . " 23:59:59");
			$tgl2->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsampai = $tgl2->format('Y-m-d H-i-s');
			//echo "TGLSAMPAI".$tglsampai.'<br>';
		}

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('m');
		$bulanskr = intval($tglsekarang);
		$tahunskr = $now->format('Y');
		//$this->db->select('ds.*, count(tu.npsn) as jml_guru1, count(tu2.npsn) as jml_guru2');
		$this->db->select('tc.*, tu.first_name,tu.last_name,
		count(tc.id) as jmlpaket, 0 as jmlvideo, 0 as jmlnontonguru,0 as jmlviewer,
		ds.npsn,ds.nama_sekolah');
		$this->db->from('tb_paket_channel tc');
		$this->db->join('tb_user tu', 'tu.id = tc.id_user', 'inner');
		$this->db->join('daf_chn_sekolah ds', 'tu.npsn = ds.npsn', 'inner');
		$this->db->group_by('tc.id_user');
		$this->db->where('(ds.npsn<>"")');
		$query1 = $this->db->get_compiled_select();

		$this->db->select('tc.*, tu.first_name,tu.last_name,
		0 as jmlpaket, count(tv.id_video) as jmlvideo, 0 as jmlnontonguru,
		0 as jmlviewer,ds.npsn,ds.nama_sekolah');
		$this->db->from('tb_paket_channel tc');
		$this->db->join('tb_user tu', 'tu.id = tc.id_user', 'inner');
		$this->db->join('daf_chn_sekolah ds', 'tu.npsn = ds.npsn', 'inner');
		$this->db->join('tb_video tv', 'tv.id_user = tc.id_user', 'inner');
		$this->db->group_by('tc.id_user');
		$query2 = $this->db->get_compiled_select();

		$this->db->select('tc.*, tu.first_name,tu.last_name,
		0 as jmlpaket, 0 as jmlvideo, sum(tn.durasi) as jmlnontonguru,
		0 as jmlviewer,ds.npsn,ds.nama_sekolah');
		$this->db->from('tb_paket_channel tc');
		$this->db->join('tb_user tu', 'tu.id = tc.id_user', 'inner');
		$this->db->join('daf_chn_sekolah ds', 'tu.npsn = ds.npsn', 'inner');
		$this->db->join('tb_nonton tn', 'tn.id_guru = tc.id_user', 'inner');
		$this->db->where('(tn.user_sebagai=2)');
		if ($mulai == null && $sampai == null)
			$this->db->where('(month(`tanggal`) = '.$bulanskr.' AND year(`tanggal`) = '.$tahunskr.')');
		else if ($mulai != null && $sampai == null)
			$this->db->where('(tanggal >= (' . $tglmulai . '))');
		else if ($mulai == null && $sampai != null)
			$this->db->where('(tanggal <= (' . $tglsampai . '))');
		else if ($mulai != null && $sampai != null)
			$this->db->where('(tanggal >= date("' . $tglmulai . '") AND tanggal <= date("' . $tglsampai . '"))');
		$this->db->group_by('tc.id_user');
		$query3 = $this->db->get_compiled_select();

		$this->db->select('tc.*, tu.first_name,tu.last_name,
		0 as jmlpaket, 0 as jmlvideo, 0 as jmlnontonguru,
		count(tn.id_user) as jmlviewer,ds.npsn,ds.nama_sekolah');
		$this->db->from('tb_paket_channel tc');
		$this->db->join('tb_user tu', 'tu.id = tc.id_user', 'inner');
		$this->db->join('daf_chn_sekolah ds', 'tu.npsn = ds.npsn', 'inner');
		$this->db->join('tb_nonton tn', 'tn.id_guru = tc.id_user', 'inner');
		$this->db->where('(tn.user_sebagai=2)');
		if ($mulai == null && $sampai == null)
			$this->db->where('(month(`tanggal`) = '.$bulanskr.' AND year(`tanggal`) = '.$tahunskr.')');
		else if ($mulai != null && $sampai == null)
			$this->db->where('(tanggal >= (' . $tglmulai . '))');
		else if ($mulai == null && $sampai != null)
			$this->db->where('(tanggal <= (' . $tglsampai . '))');
		else if ($mulai != null && $sampai != null)
			$this->db->where('(tanggal >= date("' . $tglmulai . '") AND tanggal <= date("' . $tglsampai . '"))');
		$this->db->group_by('tc.id_user');
		$query4 = $this->db->get_compiled_select();

		$query = $this->db->query($query1 . ' UNION ALL ' . $query2 .
			' UNION ALL ' . $query3 . ' UNION ALL ' . $query4);

//		$query = $this->db->query($query1 . ' UNION ALL ' . $query2 .
//			' UNION ALL ' . $query3 . ' UNION ALL ' . $query4 .
//			' UNION ALL ' . $query5 . ' UNION ALL ' . $query6 .
//			' UNION ALL ' . $query7 . ' UNION ALL ' . $query8);

		$query = $query->result();

		return $query;
	}

	public function updatestatus($id, $status)
	{
		$this->db->where('id', $id);
		$data = array(
			'status' => $status
		);
		return $this->db->update('daf_chn_sekolah', $data);
	}

	public function updatesifat($id, $status)
	{
		$this->db->where('id_video', $id);
		$data = array(
			'sifat' => $status
		);
		return $this->db->update('tb_video', $data);
	}

	public function updatedilist($id, $status)
	{
		$this->db->where('id_video', $id);
		$data = array(
			'dilist' => $status
		);
		return $this->db->update('tb_video', $data);
	}

	public function updatedilistbimbel($id, $status)
	{
		$this->db->where('id_video', $id);
		$data = array(
			'dilist' => $status
		);
		return $this->db->update('tb_video', $data);
	}

	public function updatedilistsekolah($id, $status)
	{
		$this->db->where('id_video', $id);
		$data = array(
			'dilist' => $status
		);
		return $this->db->update('tb_video', $data);
	}

	public function updatedilisttve($id, $status)
	{
		$this->db->where('id_video', $id);
		$data = array(
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
		$data = array(
			'status_paket' => 2
		);
		return $this->db->update('tb_paket_channel', $data);
	}

	public function gantistatuspaketbimbel($id)
	{
		$this->db->where('id', $id);
		$data = array(
			'status_paket' => 2
		);
		return $this->db->update('tb_paket_bimbel', $data);
	}

	public function gantistatuspaket_sekolah($id)
	{
		$this->db->where('id', $id);
		$data = array(
			'status_paket' => 2
		);
		return $this->db->update('tb_paket_channel_sekolah', $data);
	}

	public function gantistatuspaket_tve($id)
	{
		$this->db->where('id', $id);
		$data = array(
			'status_paket' => 2
		);
		return $this->db->update('tb_paket_channel_tve', $data);
	}

	public function addplaylist($data)
	{
		if($data['modulke']>0)
		{
			$data2 = array('modulke'=>0);
			$this->db->where('id_kelas',$data['id_kelas']);
			$this->db->where('id_mapel',$data['id_mapel']);
			$this->db->where('modulke',$data['modulke']);
			$this->db->where('id_user', $this->session->userdata('id_user'));
			$this->db->update('tb_paket_channel', $data2);
		}
		return $this->db->insert('tb_paket_channel', $data);
		//return $this->db->insert_id();
	}

	public function addplaylist_bimbel($data)
	{
		$this->db->insert('tb_paket_bimbel', $data);
	}

	public function addplaylist_sekolah($data)
	{
		$this->db->insert('tb_paket_channel_sekolah', $data);
	}

	public function addplaylist_tve($data)
	{
		$this->db->insert('tb_paket_channel_tve', $data);
	}

	public function getVideoUser($id_user, $kodepaket, $kodeevent = null)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel');
		$this->db->from('tb_video tv');
		$this->db->join('tb_paket_channel tpc', 'tv.id_user = tpc.id_user', 'left');
		$this->db->join('tb_channel_video tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)', 'left');
		$this->db->where('tv.id_user', $id_user);
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
		if ($kodeevent == null) {
			$this->db->where('(status_verifikasi=2 OR status_verifikasi=4)');
			$this->db->where('(status_verifikasi_admin=4)');
		}
		$this->db->where('(sifat=1)');
		$this->db->where('(dilist=0||(dilist=1 && tcv.id_video = tv.id_video))');
		$this->db->order_by('dilist', 'desc');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVideoBimbel($id_user, $kodepaket, $kodeevent = null)
	{
		$this->db->select('*,tv.id_video as idvideo, tv.id_jenis as idjenis, tcv.id as idchannel');
		$this->db->from('tb_video tv');
		$this->db->join('tb_paket_bimbel tpc', 'tv.id_user = tpc.id_user', 'left');
		$this->db->join('tb_channel_bimbel tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)', 'left');
		$this->db->where('tv.id_user', $id_user);
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
		if ($kodeevent == null) {
			$this->db->where('(status_verifikasi_bimbel=2 OR status_verifikasi_bimbel=4)');
			$this->db->where('(status_verifikasi_admin=4)');
		}
		$this->db->where('(sifat=2)');
		$this->db->where('(dilist=0||(dilist=1 && tcv.id_video = tv.id_video))');
		$this->db->order_by('dilist', 'desc');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVideoFordorum($kodepaket)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel');
		$this->db->from('tb_video tv');
		$this->db->join('tb_paket_channel tpc', 'tv.id_user = tpc.id_user', 'left');
		$this->db->join('tb_channel_video tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)', 'left');
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(status_verifikasi=2 OR status_verifikasi=4)');
		$this->db->where('(dilist=0)');
		$this->db->where('(dilist=0||(dilist=1 && tcv.id_video = tv.id_video))');
		$this->db->order_by('modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVideoUserPaket($id_user, $kodepaket)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel, tcv.id as idplaylist');
		$this->db->from('tb_video tv');
		$this->db->join('tb_channel_video tcv', '(tcv.id_video = tv.id_video)', 'left');
		$this->db->join('tb_paket_channel tpc', 'tcv.id_paket = tpc.id', 'left');

		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('tcv.urutan ASC, tcv.id ASC');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVideoBimbelPaket($id_user, $kodepaket)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel, tcv.id as idplaylist');
		$this->db->from('tb_video tv');
		$this->db->join('tb_channel_bimbel tcv', '(tcv.id_video = tv.id_video)', 'left');
		$this->db->join('tb_paket_bimbel tpc', 'tcv.id_paket = tpc.id', 'left');

		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('tcv.urutan ASC, tcv.id ASC');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVideoSekolah($npsn, $kodepaket, $sifat = null)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel, if(tcv.id is NULL,0,1) as masuk');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->join('tb_paket_channel_sekolah tpc', 'tu.npsn = tpc.npsn', 'left');
		$this->db->join('tb_channel_video_sekolah tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)', 'left');

		$this->db->where('tu.npsn', $npsn);
		if ($kodepaket!=null)
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(status_verifikasi=2 OR status_verifikasi=4)');
		$this->db->where('(status_verifikasi_admin=4)');
		if($sifat==null)
			$this->db->where('(sifat=0)');
		else
			$this->db->where('(sifat='.$sifat.' OR sifat=0)');
		// $this->db->where('(tcv.id is NOT NULL)');
		$this->db->order_by('masuk', 'desc');
		$this->db->order_by('tv.modified', 'desc');
		$this->db->group_by('tv.id_video');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVideoSekolahtes($npsn, $kodepaket, $sifat = null)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->join('tb_paket_channel_sekolah tpc', 'tu.npsn = tpc.npsn', 'left');
		$this->db->join('tb_channel_video_sekolah tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)', 'left');

		$this->db->where('tu.npsn', $npsn);
		if ($kodepaket!=null)
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(status_verifikasi=2 OR status_verifikasi=4)');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->where('(sifat='.$sifat.' OR sifat=0)');
//		$this->db->where('(dilist=0||(dilist=1 && tcv.id_video = tv.id_video))');
		$this->db->order_by('tv.modified', 'desc');
		$this->db->group_by('tv.id_video');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVideoEvent($npsn, $kodepaket, $idevent)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->join('tb_paket_channel_sekolah tpc', 'tu.npsn = tpc.npsn', 'left');
		$this->db->join('tb_channel_video_sekolah tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)', 'left');

		$this->db->where('tu.npsn', $npsn);
		$this->db->where('tv.id_event', $idevent);
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
		// $this->db->where('(status_verifikasi=2 OR status_verifikasi=4)');
		// $this->db->where('(status_verifikasi_admin=4)');
		$this->db->where('(tv.sifat=0 OR tv.sifat=3)');
//		$this->db->where('(sifat=0)');
//		$this->db->where('(dilist=0||(dilist=1 && tcv.id_video = tv.id_video))');
		$this->db->order_by('tv.modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVideoSekolahEkskul($npsn, $iduser, $idpaket=null, $hari=null)
	{
//		$npsn = $result['npsn'];
//		$idpaket = $result['id'];
//		$nama_paket = $result['id'];

		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel');
//		$this->db->select('*,tv.id_video as idvideo');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->join('tb_channel_video_sekolah tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = '.$idpaket.')', 'left');
		$this->db->where('(npsn_user="'.$npsn.'" AND tu.sebagai=1) OR (id_user='.$iduser.')');
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(status_verifikasi=2 OR status_verifikasi=4)');
		$this->db->where('(status_verifikasi_admin=4)');
//		if ($idpaket!=null)
//			$this->db->where('(tcv.id_paket = '.$idpaket.')');
		$this->db->group_by('(tv.id_video)');
//		$this->db->where('(dilist=0||(dilist=1 && tcv.id_video = tv.id_video))');
		$this->db->order_by('tcv.id', 'desc');
		$this->db->order_by('tcv.urutan', 'asc');


//		$this->db->limit(1,243);
		$result = $this->db->get()->result();

		return $result;
	}

	public function getVideoSekolahCalver($npsn, $kodepaket, $sifat = null)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->join('tb_paket_channel_sekolah tpc', 'tu.npsn = tpc.npsn', 'left');
		$this->db->join('tb_channel_video_sekolah tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)', 'left');

		$this->db->where('tu.npsn', $npsn);
		if ($kodepaket!=null)
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(tipe_video=3)');
		if($sifat==null)
			$this->db->where('(sifat=0)');
		else
			$this->db->where('(sifat='.$sifat.' OR sifat=0)');
//		$this->db->where('(dilist=0||(dilist=1 && tcv.id_video = tv.id_video))');
		$this->db->order_by('tv.modified', 'desc');
		$this->db->group_by('tv.id_video');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVideoSekolahEkskulUrut($idpaket)
	{

		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel');
		$this->db->from('tb_channel_video_sekolah tcv');
		$this->db->join('tb_video tv', '(tcv.id_video = tv.id_video)', 'left');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->where('(tcv.id_paket = '.$idpaket.')');
		$this->db->order_by('tcv.urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();

		return $result;
	}

	public function getVideoSekolahTVEEkskulUrut($idpaket)
	{

		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel');
		$this->db->from('tb_video tv');
		$this->db->join('tb_channel_video_tve tcv', '(tcv.id_video = tv.id_video)', 'left');
		$this->db->where('(tcv.id_paket = '.$idpaket.')');
		$this->db->where('(tv.durasi <> "")');
		$this->db->order_by('tcv.urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();

		return $result;
	}
	

	public function getPaketChannelSekolah($kodepaket)
	{
		$this->db->from('tb_paket_channel_sekolah');
		$this->db->where('link_list', $kodepaket);
		$result = $this->db->get()->row_array();
		return $result;
	}

	public function getPaketChannelTVE($kodepaket)
	{
		$this->db->from('tb_paket_channel_tve');
		$this->db->where('link_list', $kodepaket);
		$result = $this->db->get()->row_array();
		return $result;
	}

	public function getVideoSekolahPaket($kodepaket)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel, tcv.id as idplaylist');
		$this->db->from('tb_video tv');
		$this->db->join('tb_channel_video_sekolah tcv', '(tcv.id_video = tv.id_video)', 'left');
		$this->db->join('tb_paket_channel_sekolah tpc', 'tcv.id_paket = tpc.id', 'left');
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('tcv.urutan ASC, tcv.id ASC');
		$result = $this->db->get()->result();
		return $result;
	}

	public function updateurutan_sekolah($data)
	{
		$updateArray = array();
		for ($x = 0; $x < sizeof($data['id']); $x++) {
			$updateArray[] = array(
				'id' => $data['id'][$x],
				'urutan' => $data['urutan'][$x]
			);
//            echo "ID:".$data['id'][$x];
//            echo "URUTAN:".$data['urutan'][$x]."<br>";

		}
		//$this->db->update_batch('po_order_details',$updateArray, 'poid');
		if ($this->session->userdata('a01'))
			$this->db->update_batch('tb_channel_video_tve', $updateArray, 'id');
		else
			$this->db->update_batch('tb_channel_video_sekolah', $updateArray, 'id');
	}

	public function updateurutan_guru($data)
	{
		$updateArray = array();
		for ($x = 0; $x <= sizeof($data['id']); $x++) {
			$updateArray[] = array(
				'id' => $data['id'][$x],
				'urutan' => $data['urutan'][$x]
			);
//            echo "ID:".$data['id'][$x];
//            echo "URUTAN:".$data['urutan'][$x]."<br>";

		}
		//$this->db->update_batch('po_order_details',$updateArray, 'poid');
		$this->db->update_batch('tb_channel_video', $updateArray, 'id');
	}

	public function updateurutan_bimbel($data)
	{
		$updateArray = array();
		for ($x = 0; $x <= sizeof($data['id']); $x++) {
			$updateArray[] = array(
				'id' => $data['id'][$x],
				'urutan' => $data['urutan'][$x]
			);

		}
		$this->db->update_batch('tb_channel_bimbel', $updateArray, 'id');
	}

	public function updateurutan_tve($data)
	{
		$updateArray = array();
		for ($x = 0; $x < sizeof($data['id']); $x++) {
			$updateArray[] = array(
				'id' => $data['id'][$x],
				'urutan' => $data['urutan'][$x]
			);
			echo "ID:" . $data['id'][$x];
			echo "URUTAN:" . $data['urutan'][$x] . "<br>";

		}
		//$this->db->update_batch('po_order_details',$updateArray, 'poid');
		$this->db->update_batch('tb_channel_video_tve', $updateArray, 'id');
	}

	public function getVideoTVE($kodepaket)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel, if(tcv.id is NULL,0,1) as masuk');
		$this->db->from('tb_video tv');
		$this->db->join('tb_paket_channel_tve tpc', 'tayang=0', 'left');
		$this->db->join('tb_channel_video_tve tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)', 'left');
		$this->db->group_by('tv.id_video');
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('masuk', 'desc');
		$this->db->order_by('idchannel', 'desc');
		$this->db->order_by('tv.modified', 'desc');

		$result = $this->db->get()->result();
		return $result;
	}

	public function getVideoTVEPaket($kodepaket)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel, tcv.id as idplaylist');
		$this->db->from('tb_video tv');
		$this->db->join('tb_channel_video_tve tcv', '(tcv.id_video = tv.id_video)', 'left');
		$this->db->join('tb_paket_channel_tve tpc', 'tcv.id_paket = tpc.id', 'left');
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
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
		$this->db->join('tb_paket_channel tpc', 'tv.id_user = tpc.id_user', 'left');
		//$this->db->join('tb_channel_video tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)','left');

		$this->db->where('tv.id_user', $id_user);
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->order_by('modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getInfoVideo($id_video)
	{
		$this->db->from('tb_video');
		$this->db->where('id_video', $id_video);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function cekVideoChannel($id_video)
	{
		$this->db->from('tb_channel_video');
		$this->db->where('id_video', $id_video);
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekVideoChannelBimbel($id_video)
	{
		$this->db->from('tb_channel_bimbel');
		$this->db->where('id_video', $id_video);
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekVideoChannelSekolah($id_video)
	{
		$this->db->from('tb_channel_video_sekolah');
		$this->db->where('id_video', $id_video);
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekVideoChannelTVE($id_video)
	{
		$this->db->from('tb_channel_video_tve');
		$this->db->where('id_video', $id_video);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getInfoPaket($linklist)
	{
		$this->db->from('tb_paket_channel');
		$this->db->where('link_list', $linklist);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getInfoBimbel($linklist)
	{
		$this->db->from('tb_paket_bimbel tb');
		$this->db->where('link_list', $linklist);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function cekLinklist_VK($iduser,$jenispaket,$linklist)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$this->db->from('tb_virtual_kelas tk');
		$this->db->join('tb_vk_beli tb','tk.kode_beli=tb.kode_beli','left');
		$this->db->where('tk.id_user', $iduser);
		$this->db->where('tk.jenis_paket', $jenispaket);
		$this->db->where('tk.link_paket', $linklist);
		$this->db->where("tgl_beli<='".$tglsekarang."' AND tgl_batas>='".$tglsekarang."'");
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getInfoBeliPaket($iduser, $jenis, $linklist)
	{
		$this->db->select('tv.*,tb.tgl_batas,nama_paket,koderoom,kodepassvicon,tglkode');
		$this->db->from('tb_virtual_kelas tv');
		$this->db->join('tb_vk_beli tb','tv.kode_beli=tb.kode_beli','left');
		if($jenis==3)
			$this->db->join('tb_paket_bimbel tp','tv.link_paket=tp.link_list','left');
		else
			$this->db->join('tb_paket_channel tp','tv.link_paket=tp.link_list','left');
		$this->db->where('(tv.id_user='.$iduser.' OR tv.id_kontri='.$iduser.')');
//		$this->db->where('tv.jenis_paket', $jenis);
		$this->db->where('link_paket', $linklist);
		$this->db->where('tb.status_beli', 2);
		$this->db->where('tb.strata_paket', 3);
		$this->db->order_by('tb.tgl_batas', 'asc');
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getInfoPaketSekolah($linklist)
	{
		$this->db->from('tb_paket_channel_sekolah');
		$this->db->where('link_list', $linklist);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getInfoPaketTVE($linklist)
	{
		$this->db->from('tb_paket_channel_tve');
		$this->db->where('link_list', $linklist);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getDataChannelVideo($id_paket)
	{
		$this->db->from('tb_channel_video tcv');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->where('id_paket', $id_paket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('urutan', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDataChannelBimbel($id_paket)
	{
		$this->db->from('tb_channel_bimbel tcv');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->where('id_paket', $id_paket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('urutan', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDataChannelVideoSekolah($id_paket)
	{
		$this->db->from('tb_channel_video_sekolah tcv');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->where('id_paket', $id_paket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('urutan', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDataChannelVideoTVE($id_paket)
	{
		$this->db->from('tb_channel_video_tve tcv');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->where('id_paket', $id_paket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('urutan', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function addDataChannelVideo($data)
	{
		$this->db->insert('tb_channel_video', $data);
	}

	public function addDataChannelBimbel($data)
	{
		$this->db->insert('tb_channel_bimbel', $data);
	}

	public function addDataChannelVideoSekolah($data)
	{
		$this->db->insert('tb_channel_video_sekolah', $data);
	}

	public function addDataChannelVideoTVE($data)
	{
		$this->db->insert('tb_channel_video_tve', $data);
	}

	public function delDataChannelVideo($id_video, $id_paket)
	{
		$this->db->where('(id_video = ' . $id_video . ' AND id_paket = ' . $id_paket . ')');
		$this->db->delete('tb_channel_video');
	}

	public function delDataChannelBimbel($id_video, $id_paket)
	{
		$this->db->where('(id_video = ' . $id_video . ' AND id_paket = ' . $id_paket . ')');
		$this->db->delete('tb_channel_bimbel');
	}

	public function delDataChannelVideoSekolah($id_video, $id_paket)
	{
		$this->db->where('(id_video = ' . $id_video . ' AND id_paket = ' . $id_paket . ')');
		$this->db->delete('tb_channel_video_sekolah');
	}

	public function delDataChannelVideoTVE($id_video, $id_paket)
	{
		$this->db->where('(id_video = ' . $id_video . ' AND id_paket = ' . $id_paket . ')');
		$this->db->delete('tb_channel_video_tve');
	}

	public function updateDurasiPaket($linklist, $data)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel', $data);
	}

	public function updateDurasiBimbel($linklist, $data)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_bimbel', $data);
	}

	public function updateDurasiPaketSekolah($linklist, $data)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel_sekolah', $data);
	}

	public function updateDurasiPaketTVE($linklist, $data)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel_tve', $data);
	}

	public function delPlayList($kodepaket, $data)
	{
		if ($data != 0) {
			$updateArray = array();
			for ($a = 1; $a <= sizeof($data['id_video']); $a++) {
				$updateArray[] = array(
					'id_video' => $data['id_video'][$a],
					'dilist' => 0
				);
			}
			$this->db->update_batch('tb_video', $updateArray, 'id_video');
		}
		$this->db->where('link_list', $kodepaket);
		return $this->db->delete('tb_paket_channel');
	}

	public function delPlayListBimbel($kodepaket, $data)
	{
		if ($data != 0) {
			$updateArray = array();
			for ($a = 1; $a <= sizeof($data['id_video']); $a++) {
				$updateArray[] = array(
					'id_video' => $data['id_video'][$a],
					'dilist' => 0
				);
			}
			$this->db->update_batch('tb_video', $updateArray, 'id_video');
		}
		$this->db->where('link_list', $kodepaket);
		return $this->db->delete('tb_paket_bimbel');
	}

	public function delPlayListSekolah($kodepaket, $data)
	{
		$updateArray = array();
		for ($a = 1; $a <= sizeof($data['id_video']); $a++) {
			$updateArray[] = array(
				'id_video' => $data['id_video'][$a],
				'dilist' => 0
			);
		}
		$this->db->update_batch('tb_video', $updateArray, 'id_video');

		$this->db->where('link_list', $kodepaket);
		return $this->db->delete('tb_paket_channel_sekolah');
	}

	public function delPlayListTVE($kodepaket, $data)
	{
		$updateArray = array();
		for ($a = 1; $a <= sizeof($data['id_video']); $a++) {
			$updateArray[] = array(
				'id_video' => $data['id_video'][$a],
				'dilist' => 0
			);
		}
		$this->db->update_batch('tb_video', $updateArray, 'id_video');

		$this->db->where('link_list', $kodepaket);
		return $this->db->delete('tb_paket_channel_tve');
	}

	public function updatePlayList($linklist, $data)
	{
		if($data['modulke']>0)
		{
			$data2 = array('modulke'=>0);
			$this->db->where('id_kelas',$data['id_kelas']);
			$this->db->where('id_mapel',$data['id_mapel']);
			$this->db->where('modulke',$data['modulke']);
			$this->db->where('id_user', $this->session->userdata('id_user'));
			$this->db->update('tb_paket_channel', $data2);
		}

		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel', $data);
	}

	public function updatePlayList_bimbel($linklist, $data)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_bimbel', $data);
	}

	public function updatePlayList_sekolah($linklist, $data)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel_sekolah', $data);
	}

	public function updatePlayList_tve($linklist, $data)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel_tve', $data);
	}

	public function update_statuspaket($link_list, $status)
	{
		$this->db->where('link_list', $link_list);
		$data = array(
			'status_paket' => $status
		);
		return $this->db->update('tb_paket_channel', $data);
	}

	public function update_statuspaket_bimbel($link_list, $status)
	{
		$this->db->where('link_list', $link_list);
		$data = array(
			'status_paket' => $status
		);
		return $this->db->update('tb_paket_bimbel', $data);
	}

	public function update_statuspaket_sekolah($link_list, $status)
	{
		$this->db->where('link_list', $link_list);
		$data = array(
			'status_paket' => $status
		);
		return $this->db->update('tb_paket_channel_sekolah', $data);
	}

	public function update_statuspaket_tve($link_list, $status)
	{
		$this->db->where('link_list', $link_list);
		$data = array(
			'status_paket' => $status
		);
		return $this->db->update('tb_paket_channel_tve', $data);
	}

	public function ceknonton($channel, $npsn, $idguru, $linklist)
	{
		$this->db->from('tb_nonton');
		if ($channel == 1)
			$this->db->where('npsn_sekolah', $npsn);
		else if ($channel == 2) {
			$this->db->where('id_guru', $idguru);
			$this->db->where('link_list', $linklist);
		}
		$this->db->where('id_user', $this->session->userdata('id_user'));

		$result = $this->db->get()->result();
		return $result;
	}

	public function insertnonton($channel, $npsn, $idguru, $linklist, $durasi)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$data = array(
			'channel' => $channel,
			'durasi' => $durasi,
			'id_user' => $this->session->userdata('id_user'),
			'user_sebagai' => $this->session->userdata('sebagai'),
			'npsn_user' => $this->session->userdata('npsn'),
			'tanggal' => $tglsekarang
		);
		if ($channel == 1) {
			$data['npsn_sekolah'] = $npsn;
			$data['npsn_guru'] = "";
			$data['id_guru'] = "";
			$data['link_list'] = "";
		} else if ($channel == 2) {
			$data['npsn_sekolah'] = "";
			$data['npsn_guru'] = $npsn;
			$data['id_guru'] = $idguru;
			$data['link_list'] = $linklist;
		}

		return $this->db->insert('tb_nonton', $data);
	}

	public function updatenonton($channel, $npsn, $idguru, $linklist, $durasi)
	{
		if ($channel == 1)
			$this->db->where('npsn_sekolah', $npsn);
		else if ($channel == 2) {
			$this->db->where('id_guru', $idguru);
			$this->db->where('link_list', $linklist);
		}
		$this->db->where('id_user', $this->session->userdata('id_user'));
		$data = array(
			'durasi' => $durasi
		);
		return $this->db->update('tb_nonton', $data);
	}

	public function getNPSN($iduser)
	{
		$this->db->from('tb_user');
		$this->db->where('id', $iduser);
		$result = $this->db->get();
		$ret = $result->row();
		return $ret->npsn;
	}

	public function getVideoAll()
	{
		$this->db->from('tb_video');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPaketAll()
	{
		$this->db->from('tb_paket_channel');
		$result = $this->db->get()->result();
		return $result;
	}

	public function updateNPSNvideo($data)
	{
		$this->db->update_batch('tb_video', $data, 'id_user');
	}

	public function updateNPSNpaket($data)
	{
		$this->db->update_batch('tb_paket_channel', $data, 'id_user');
	}

	public function cekevent_pl_guru($linklist)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format("Y-m-d H:i:s");

		$this->db->from('tb_event');
		$this->db->where('link_event', $linklist);
		$this->db->where('tgl_selesai>=', $tglsekarang);
		$result = $this->db->get();
		$ret = $result->row();
		return $ret;
	}


	public function getAllChannel()
	{
		$this->db->from('daf_chn_sekolah');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getIdKota($npsn)
	{
		$this->db->from('daf_sekolah');
		$this->db->where('npsn', $npsn);
		$result = $this->db->get()->result();
		if ($result)
			return $result[0]->id_kota;
		else
			return 0;
	}

	public function updateidkotachannel($data)
	{
//		echo "<pre>";
//		echo var_dump($data);
//		echo "</pre>";

		$updateArray = array();
		for ($x = 0; $x <= sizeof($data); $x++) {
			$idkota = $this->getIdKota($data[$x]->npsn);
			$updateArray[] = array(
				'npsn' => $data[$x]->npsn,
				'idkota' => $idkota
			);
			echo "NPSN:" . $data[$x]->npsn . " - ";
			echo "IDKOTA:" . $idkota . "<br>";

		}

		$this->db->update_batch('daf_chn_sekolah', $updateArray, 'npsn');
	}

	public function getPaket($linklist)
	{
		$this->db->select('tp.*, tu.first_name, tu.last_name, tu.email, tu.id as iduser');
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

	public function getTugas($tipepaket, $linklist)
	{
		$this->db->select('*');
		$this->db->from('tb_tugas_guru tg');
		$this->db->join('tb_paket_channel tp', 'tg.link_list = tp.link_list', 'left');
		$this->db->where('tg.link_list', $linklist);
		$this->db->where('tipe_paket', $tipepaket);
		$this->db->where('status', 1);
		$this->db->order_by('tgl_mulai', 'asc');
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function getTugasSiswa($idtugasguru, $idsiswa=null, $opsi=null)
	{
		$this->db->from('tb_tugas_siswa ts');
		$this->db->join('tb_user tu', 'ts.id_user = tu.id', 'left');
		$this->db->where('ts.id_tugas', $idtugasguru);
		if ($idsiswa!=null)
		$this->db->where('ts.id_user', $idsiswa);
		if($opsi==null)
			$result = $this->db->get()->last_row();
		else
			$result = $this->db->get()->result();
		if ($result)
			return $result;
		else
			return 0;
	}

	public function getNilaiSiswa($linklist)
	{
		$this->db->select('ts.*, tu.first_name, tu.last_name');
		$this->db->from('tb_soal_guru_nilai ts');
		$this->db->join('tb_user tu', 'ts.iduser = tu.id', 'left');
		$this->db->where('ts.linklist', $linklist);
		$result = $this->db->get()->result();
		if ($result)
			return $result;
		else
			return 0;
	}

	public function getNilaiSiswaBimbel($linklist)
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

	public function addTugas($data)
	{
		$this->db->insert('tb_tugas_guru', $data);
	}

	public function updategbrsoal($namafile, $id, $fielddb)
	{
		$data = array(
			$fielddb => $namafile
		);
		$this->db->where('id_soal', $id);
		return $this->db->update('tb_soal_guru', $data);
	}

	public function updatesoal($data, $id)
	{
		$this->db->where('id_soal', $id);
		return $this->db->update('tb_soal_guru', $data);
	}

	public function insertsoal($id)
	{
		$data['id_paket'] = $id;
		$this->db->insert('tb_soal_guru', $data);
		$insertid = $this->db->insert_id();
		return $insertid ? $insertid : 0;
	}

	public function delsoal($id)
	{
		$this->db->where('(id_soal=' . $id . ')');
		return $this->db->delete('tb_soal_guru');
	}

	public function updateseting($data, $linklist)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel', $data);
	}

	public function ceknilai($linklist, $iduser)
	{
		$this->db->from('tb_soal_guru_nilai');
		$this->db->where('(linklist="' . $linklist . '" AND iduser=' . $iduser . ')');
		$query = $this->db->get();
		$ret = $query->row();
		if ($ret) {
			return $ret;
		} else {
			$data = array(
				'linklist' => $linklist,
				'iduser' => $iduser
			);
			$this->db->insert('tb_soal_guru_nilai', $data);
			$this->db->from('tb_soal_guru_nilai');
			$this->db->where('(linklist="' . $linklist . '" AND iduser=' . $iduser . ')');
			$query = $this->db->get();
			$ret = $query->row();
			return $ret;
		}
	}

	public function updatenilai($data, $linklist, $iduser)
	{
		$this->db->where('(linklist="' . $linklist . '" AND iduser=' . $iduser . ')');
		return $this->db->update('tb_soal_guru_nilai', $data);
	}

	public function updatemateri($data, $linklist)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel', $data);
	}

	public function updatetugas($data, $linklist)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_tugas_guru', $data);
	}

	public function updatestatustugas($status, $linklist)
	{
		$data = array("statustugas" => $status);
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel', $data);
	}

	public function updatetugasnilai($data, $idtugas, $iduser)
	{
		$this->db->where('id_tugas', $idtugas);
		$this->db->where('id_user', $iduser);
		return $this->db->update('tb_tugas_siswa', $data);
	}

	public function updatejawaban($data, $idtugas, $iduser)
	{
		$this->db->where('id_tugas', $idtugas);
		$this->db->where('id_user', $iduser);
		return $this->db->update('tb_tugas_siswa', $data);
	}


	public function getChat($jenis, $npsn, $linklist = null, $tgl = null)
	{
		$this->db->select('tc.*, tu.first_name, tu.last_name');
		$this->db->from('tb_chat tc');
		$this->db->join('tb_user tu', 'tc.id_pengirim = tu.id', 'left');
		if ($linklist == "" || $linklist == null)
			$this->db->where('tc.npsn', $npsn);
		$this->db->where('tc.tipe_paket', $jenis);
		if ($linklist != "" && $linklist != null)
			$this->db->where('linklist', $linklist);
		//$this->db->where('DATE(tanggal)',$tgl);
		$this->db->order_by('tanggal');
		$result = $this->db->get()->result();
		return $result;
	}

	public function addChat($data)
	{
		$this->db->insert('tb_chat', $data);
		$insertid = $this->db->insert_id();
		return $insertid ? $insertid : 0;

	}

	public function updateOnlineChat($jenischat = null, $linklist = null, $tgl = null, $batas = null, $iduser = null)
	{
		$this->db->select('to.*');
		$this->db->from('tb_online to');
		$this->db->where('id_user', $iduser);
		$this->db->where('tipe_paket', $jenischat);
		$result = $this->db->get()->result();

		$data = array(
			'id_user' => $iduser,
			'tgl_chat' => $tgl,
			'tipe_paket' => $jenischat,
			'linklist' => $linklist
		);
		if (sizeof($result) == 0)
			$this->db->insert('tb_online', $data);
		else {
			$this->db->where('id_user', $iduser);
			$this->db->where('tipe_paket', $jenischat);
			$this->db->update('tb_online', $data);
		}

		$this->db->select('to.*, tu.first_name, tu.last_name, tu.picture');
		$this->db->from('tb_online to');
		$this->db->join('tb_user tu', 'to.id_user = tu.id', 'left');
		$this->db->where('tgl_chat>', $batas);
		$this->db->where('tipe_paket', $jenischat);
		$this->db->order_by('tu.first_name');
		$result = $this->db->get()->result();
		return $result;
	}

	public function get_VK_sekolah_saya($iduser, $kodebeli)
	{
		$npsn = $this->session->userdata('npsn');
		$this->db->from('tb_virtual_kelas tk');
		$this->db->join('tb_paket_channel tpc', 'tk.link_paket = tpc.link_list', 'left');
		$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->where('tk.id_user', $iduser);
		$this->db->where('tpc.npsn_user', $npsn);
		$this->db->where('jenis_paket', 1);
		$this->db->where('kode_beli', $kodebeli);
		$this->db->group_by('nama_paket');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getlast_kdbeli($iduser, $jenis, $status = null)
	{
		$this->db->from('tb_vk_beli');
		$this->db->where('id_user', $iduser);
		$this->db->where('jenis_paket', $jenis);
		$this->db->where('SUBSTR(kode_beli,1,3) = "PKT"');
		if ($status != null)
			$this->db->where('status_beli', $status);
		else
			$this->db->where('status_beli>', 0);
		$this->db->order_by('id');
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function hapus_vk_gurupilih($order_id)
	{
		$this->db->where('kode_beli', $order_id);
		$this->db->where('id_user',$this->session->userdata('id_user'));
		$this->db->delete('tb_virtual_kelas');
	}

	public function getlast_kdbeli_eceran($iduser, $jenis, $status = null)
	{
		$this->db->from('tb_vk_beli');
		$this->db->where('id_user', $iduser);
		$this->db->where('jenis_paket', $jenis);
		$this->db->where('SUBSTR(kode_beli,1,3) = "ECR"');
		if ($status != null)
			$this->db->where('status_beli', $status);
		else
			$this->db->where('status_beli>', 0);
		$this->db->order_by('id');
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function getUserVK($tipepaket, $linklist, $idtugas)
	{
		$this->db->select('*');
		$this->db->from('tb_virtual_kelas tv');
		$this->db->join('tb_vk_beli tb', 'tv.kode_beli = tb.kode_beli', 'left');
		$this->db->join('tb_user tu', 'tv.id_user = tu.id', 'left');
		$this->db->join('tb_tugas_siswa ts', 'tv.id_user = ts.id_user AND ts.id_tugas = ' . $idtugas, 'left');
		$this->db->where('tv.link_paket', $linklist);
		$this->db->where('tv.jenis_paket', $tipepaket);
//		$this->db->where('status', 1);
		$this->db->order_by('first_name', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafPlayListModul($jenis, $linklist, $iduserolehadmin = null)
	{
		if ($this->session->userdata('a01'))
			$iduser = $iduserolehadmin;
		else
			$iduser = $this->session->userdata('id_user');
		$this->db->select('tpc.*, tcv.*, tv.*');
		if ($jenis == "sekolah") {
			$this->db->from('tb_paket_channel tpc');
			$this->db->join('tb_channel_video tcv', 'tcv.id_paket = tpc.id', 'left');
		} else {
			$this->db->from('tb_paket_bimbel tpc');
			$this->db->join('tb_channel_bimbel tcv', 'tcv.id_paket = tpc.id', 'left');
		}
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		//$this->db->where('(urutan=0 OR urutan=1)');
		$this->db->where('status_paket>=', 1);
		if ($this->session->userdata('siam')!=3)
		$this->db->where('tpc.id_user', $iduser);
		$this->db->where('tpc.link_list', $linklist);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPlayListModul($jenis, $link_list)
	{
		if ($jenis == "sekolah") {
			$this->db->from('tb_channel_video tcv');
			$this->db->join('tb_paket_channel tpc', 'tpc.id = tcv.id_paket', 'left');
		} else {
			$this->db->from('tb_channel_bimbel tcv');
			$this->db->join('tb_paket_bimbel tpc', 'tpc.id = tcv.id_paket', 'left');
		}
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(tpc.link_list="' . $link_list . '")');
		$this->db->where('(tv.status_verifikasi_admin=4)');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekModul($jenis, $linklist)
	{
		if ($jenis == "sekolah") {
			$this->db->from('tb_paket_channel tp');
		} else {
			$this->db->from('tb_paket_bimbel tp');
		}
		$this->db->where('link_list', $linklist);
		$result = $this->db->get()->result();
		return $result;
	}


	public function getallpayment()
	{
		$this->db->select('tp.iduser, tu.npsn');
		$this->db->from('tb_payment tp');
		$this->db->join('tb_user tu', 'tp.iduser = tu.id', 'left');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function updatenpsnpayment($data)
	{
		$updateArray = array();
		for ($x = 0; $x < sizeof($data); $x++) {
			$updateArray[] = array(
				'iduser' => $data[$x]['iduser'],
				'npsn_sekolah' => $data[$x]['npsn']
			);
//            echo "ID:".$data['id'][$x];
//            echo "URUTAN:".$data['urutan'][$x]."<br>";

		}
		//$this->db->update_batch('po_order_details',$updateArray, 'poid');
		$this->db->update_batch('tb_payment', $updateArray, 'iduser');
	}

	public function cek_kdbeli($orderid, $iduser, $status)
	{
		$this->db->where('kode_beli', $orderid);
		$this->db->where('id_user', $iduser);
		$this->db->where('status_beli', $status);
		$this->db->from('tb_vk_beli');
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function update_kdbeli($orderid)
	{
		$data = array("status_beli" => 0);
		$this->db->where('kode_beli', $orderid);
		$this->db->update('tb_vk_beli', $data);
	}

	public function cek_payment($orderid, $iduser, $status)
	{
		$this->db->from('tb_payment');
		$this->db->where('order_id', $orderid);
		$this->db->where('iduser', $iduser);
		$this->db->where('status', $status);
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function update_payment($orderid)
	{
		$data = array("status" => 0);
		$this->db->where('order_id', $orderid);
		$this->db->update('tb_payment', $data);
	}

	public function cek_payment_event($orderid, $iduser, $status)
	{
		$this->db->from('tb_userevent');
		$this->db->where('order_id', $orderid);
		$this->db->where('id_user', $iduser);
		$this->db->where('status_user', $status);
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function update_payment_event($orderid)
	{
		$data = array("status_user" => 0);
		$this->db->where('order_id', $orderid);
		$this->db->update('tb_userevent', $data);
	}

	public function cektayangchannelall()
	{
		$this->db->select('ds.npsn, count(tp.hari) as totharitayang, 
		SEC_TO_TIME(SUM(TIME_TO_SEC(durasi_paket))) as tottotaltayang');
		$this->db->from('daf_chn_sekolah ds');
		$this->db->join('tb_paket_channel_sekolah tp', 'ds.npsn = tp.npsn', 'left');
		$this->db->group_by('ds.npsn');
		$result = $this->db->get()->result();
		return $result;
	}

	public function updatetayangchannelAll($data)
	{
		$this->db->update_batch('daf_chn_sekolah', $data, 'npsn');
	}

	public function cektayangchannel($npsn)
	{
		$this->db->select('count(hari) as totharitayang, 
		SEC_TO_TIME(SUM(TIME_TO_SEC(durasi_paket))) as tottotaltayang');
		$this->db->from('tb_paket_channel_sekolah');
		if (!$this->session->userdata('a01'))
			$this->db->where('npsn', $npsn);
		$result = $this->db->get()->result();
		return $result;
	}

	public function cektayangchannelevent($kodeevent)
	{
		$this->db->select('count(hari) as totharitayang, 
		SEC_TO_TIME(SUM(TIME_TO_SEC(durasi_paket))) as tottotaltayang');
		$this->db->from('tb_paket_channel_sekolah');
		$this->db->where('nama_paket', $kodeevent);
		$result = $this->db->get()->result();
		return $result;
	}

	public function updatetayangchannel($data, $npsn)
	{
		$this->db->where('npsn', $npsn);
		$this->db->update('daf_chn_sekolah', $data);
	}

	public function getsponsor($npsn)
	{
		$cektanggal = new DateTime();
		$cektanggal->setTimezone(new DateTimezone('Asia/Jakarta'));
		$bulansekarang = date_format($cektanggal, 'Y-m');

		$this->db->select('SUBSTRING(tp.order_id,5) as order_id, td.nama_lembaga, ta.url_sponsor, ta.durasi_sponsor');
		$this->db->from('tb_payment tp');
		$this->db->join('tb_eksekusi_ae ta', 'SUBSTRING(tp.order_id,5)=ta.order_id', 'left');
		$this->db->join('tb_donatur td', 'ta.id_donatur=td.id', 'left');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('(tipebayar="donasi" OR tipebayar="sponsor")');
		$this->db->where('(date_format(tgl_order, "%Y-%m")="' . $bulansekarang . '")');
		$result = $this->db->get()->row();
		return $result;
	}

	public function getNamaJenjang($idjenjang)
	{
		$this->db->from('daf_jenjang');
		$this->db->where('id',$idjenjang);
		$result = $this->db->get()->row();
		return $result;
	}

	public function clearpaymentvkexpired()
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');
		$this->db->where('status_beli', 1);
		$this->db->where('DATE_ADD(tgl_beli, INTERVAL 1 DAY)<', $tglsekarang);
		$data = array("status_beli" => 0);
		$this->db->update('tb_vk_beli', $data);
	}

	public function getpaymentsekolah($npsn, $opsi)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$this->db->from('tb_payment');
		$this->db->where('npsn_sekolah', $npsn);
		if ($opsi=="semua")
			$this->db->where('(SUBSTRING(order_id,1,3)="TVS" OR SUBSTRING(order_id,1,2)="TP" OR SUBSTRING(order_id,1,2)="TF")');
		else if ($opsi=="premium")
			$this->db->where('(SUBSTRING(order_id,1,2)="TP" OR SUBSTRING(order_id,1,2)="TF")');
		else if ($opsi=="ekskul")
			$this->db->where('(SUBSTRING(order_id,1,3)="EK1" OR SUBSTRING(order_id,1,3)="EK3"
			OR SUBSTRING(order_id,1,3)="EK4" OR SUBSTRING(order_id,1,3)="EK4")');
		else if ($opsi=="gratisekskul")
			$this->db->where('(SUBSTRING(order_id,1,3)="EKF")');
		$this->db->where('tgl_bayar<=', $tglsekarang);
		$this->db->where('tgl_berakhir>=', $tglsekarang);
		$this->db->where('status', 3);
		$this->db->order_by('tgl_berakhir', 'desc');
		if ($opsi!="gratisekskul")
			$result = $this->db->get()->last_row();
		else
			$result = $this->db->get()->result();
		return $result;
	}

	public function updatedafchannel($data)
    {
        $updateArray = array();
        for($x = 1; $x <= sizeof($data); $x++){
			if ($data[$x]['strata']>0)
			{
				$updateArray[] = array(
					'npsn'=>$data[$x]['npsn'],
					'strata_sekolah' => $data[$x]['strata'],
					'kadaluwarsa' => $data[$x]['kadaluwarsa']
				);
			}

        }

        $this->db->update_batch('daf_chn_sekolah', $updateArray, 'npsn');
    }

	public function getmodultb_virtual($linkpaket)
	{
		$this->db->from('tb_virtual_kelas');
		$this->db->where('link_paket',$linkpaket);
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekpaket($modulke,$semester,$iduser)
	{
		$this->db->from('tb_paket_channel');
		$this->db->where('modulke', $modulke);
		$this->db->where('semester', $semester);
		$this->db->where('id_user', $iduser);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getsiaranaktif($npsn=null)
	{
		if ($this->session->userdata('verifikator')==3)
		{
			$npsn = $this->session->userdata('npsn');
		}

		$this->db->from('daf_sekolah');
		$this->db->where('npsn', $npsn);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function updateurl($url, $npsn)
	{
		$data['urllive'] = $url;
		$this->db->where('npsn', $npsn);
		return $this->db->update('daf_sekolah', $data);
	}

	public function updatesiaran($siaranganti, $npsn)
	{
		$data['siaranaktif'] = $siaranganti;
		$this->db->where('npsn', $npsn);
		return $this->db->update('daf_sekolah', $data);
	}

}
