<?php

class M_ekskul extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function getEkskul($npsn)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));

		$ttime = $now->format('Y-m-01');
		$batastoleransi = $now->format('Y-m-05');
		$tanggalsekarang = new DateTime($ttime);
		$bulankemarin = new DateTime($ttime);
		$bulankemarin->modify('-1 month');
//
//		$tglsekarang = $tanggalsekarang->format('m-Y')."\n";
//		$blnkemarin = $bulankemarin->format('m-Y')."\n";

		$xbulanskr = $tanggalsekarang->format('m');
		$bulanskr = intval($xbulanskr);
		$tahunskr = $tanggalsekarang->format('Y');

		$xbulankmr = $bulankemarin->format('m');
		$bulankmr = intval($xbulankmr);
		$tahunkmr = $bulankemarin->format('Y');

		$this->db->select('te.*,tp.status,tu.*');
		$this->db->from('tb_ekskul te');
		$this->db->join('tb_user tu', 'te.id_user = tu.id', 'left');
//		$this->db->join('tb_payment tp', 'te.kode_bayar = tp.order_id AND tp.status=3 AND ((month(`tgl_order`) = ' .
//			$bulanskr . ' AND year(`tgl_order`) = ' . $tahunskr . ') OR (month(`tgl_order`) = ' .
//			$bulankmr . ' AND year(`tgl_order`) = ' . $tahunkmr . ' AND now() <= "' . $batastoleransi . '"))', 'left');
		$this->db->join('tb_payment tp', 'te.kode_bayar = tp.order_id AND tp.status=3 AND (now() <= tgl_berakhir OR now() <= "' . $batastoleransi . '")', 'left');

		$this->db->where('te.npsn_sekolah', $npsn);

//		$this->db->where('id_user', $id);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getEkskulVer($koderef)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));

		$ttime = $now->format('Y-m-01');
		$batastoleransi = $now->format('Y-m-05');
		$tanggalsekarang = new DateTime($ttime);
		$bulankemarin = new DateTime($ttime);
		$bulankemarin->modify('-1 month');

		$xbulanskr = $tanggalsekarang->format('m');
		$bulanskr = intval($xbulanskr);
		$tahunskr = $tanggalsekarang->format('Y');

		$xbulankmr = $bulankemarin->format('m');
		$bulankmr = intval($xbulankmr);
		$tahunkmr = $bulankemarin->format('Y');

		$this->db->select('tm.id_calver as id_user, count(te.id_user) as jml_ekskul');
		$this->db->from('tb_mentor_calver_daf tm');
		$this->db->join('tb_ekskul te', 'tm.npsn_sekolah = te.npsn_sekolah', 'left');
		$this->db->join('tb_user tu', 'te.id_user = tu.id', 'left');
		$this->db->join('tb_payment tp', 'te.kode_bayar = tp.order_id AND tp.status=3 AND (now() <= tgl_berakhir OR now() <= "' . $batastoleransi . '")', 'left');

		$this->db->where('tm.kode_event', $koderef);
		$this->db->group_by('id_calver');
		$this->db->order_by('id_calver','asc');

		$result = $this->db->get()->result_array();
		return $result;
	}

	public function addEkskul($npsn, $id)
	{
		$this->db->from('tb_ekskul te');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('id_user', $id);
		$result = $this->db->get()->result();

		if (!$result) {
			$kodegen = "eks_" . $id . rand("1000", "9999");
			$data = array('id_user' => $id, 'npsn_sekolah' => $npsn, 'kode_link' => $kodegen);
			$this->db->insert('tb_ekskul', $data);
		}
	}

	public function updateEkskul($npsn, $id, $kodebeli)
	{
		$this->db->from('tb_ekskul te');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('id_user', $id);
		$result = $this->db->get()->last_row();
		$idnya = $result->id;

		$data = array("kode_bayar" => $kodebeli);
		$this->db->where('id', $idnya);
		$this->db->update('tb_ekskul', $data);
	}

	public function getVideoEkskul($npsn = null, $bulan = null, $tahun = null)
	{
		$this->db->select('tv.*,tu.*,tv.modified as tglupload, tu.created as createduser');
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->where('tv.tipe_video', 2); //tipe video ekskul
		if($npsn==null)
			$this->db->where('tv.id_user', $this->session->userdata('id_user'));
		else
			$this->db->where('tv.npsn_user', $npsn);
//		if ($bulan != null) {
//			$this->db->where('tv.bulanekskul', $bulan);
//			$this->db->where('tv.tahunekskul', $tahun);
//		} else {
//			$datesekarang = new DateTime();
//			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
//			$bulansekarang = $datesekarang->format('m');
//			$tahunsekarang = $datesekarang->format('Y');
//			$this->db->where('tv.bulanekskul', $bulansekarang);
//			$this->db->where('tv.tahunekskul', $tahunsekarang);
//		}
		$this->db->order_by('tv.modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVideoEkskulpilih($id_video)
	{
		$this->db->from('tb_video tv');
		$this->db->join('tb_user tu', 'tu.id = tv.id_user', 'left');
		$this->db->where('id_video', $id_video);
		$result = $this->db->get()->row_array();
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
		return $this->db->update('tb_video_ekskul', $data);
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
		id_user = ' . $this->session->userdata("id_user") . ' AND
		status_verifikasi=0)');
		}

		$this->db->delete('tb_video');
	}

	public function getPaketEkskul($id_user, $bulan = null, $tahun = null)
	{
		$this->db->from('tb_paket_channel_ekskul');
		$this->db->where('id_user', $id_user);
		if ($bulan != null) {
			$this->db->where('bulanekskul', $bulan);
			$this->db->where('tahunekskul', $tahun);
		} else {
			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$bulansekarang = $datesekarang->format('m');
			$tahunsekarang = $datesekarang->format('Y');
			$this->db->where('bulanekskul', $bulansekarang);
			$this->db->where('tahunekskul', $tahunsekarang);
		}
		$result = $this->db->get()->result();
		return $result;
	}

	public function addplaylist($data)
	{
		$this->db->insert('tb_paket_channel_ekskul', $data);
	}

	public function updatePlayList($linklist, $data)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel_ekskul', $data);
	}

	public function getVideoUser($id_user, $kodepaket)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel');
		$this->db->from('tb_video tv');
		$this->db->join('tb_paket_channel_ekskul tpc', 'tv.id_user = tpc.id_user', 'left');
		$this->db->join('tb_channel_video_ekskul tcv', '(tcv.id_video = tv.id_video AND tcv.id_paket = tpc.id)', 'left');
		$this->db->where('tv.id_user', $id_user);
		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(dilist=0||(dilist=1 && tcv.id_video = tv.id_video))');
		$this->db->order_by('modified', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getInfoPaketEkskul($linklist)
	{
		$this->db->from('tb_paket_channel_ekskul');
		$this->db->where('link_list', $linklist);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getPaketChannelSekolah($iduser)
	{
		$this->db->from('tb_paket_channel_sekolah');
		$this->db->where('iduser', $iduser);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getPaketChannelSekolahVer($npsn)
	{
		$this->db->from('tb_paket_channel_sekolah tpc');
		$this->db->join('tb_user tu', 'tu.id = tpc.iduser', 'left');
		$this->db->where('tpc.npsn', $npsn);
		$this->db->order_by('tpc.modified', 'asc');
		$query = $this->db->get();
		$ret = $query->last_row();
		return $ret;
	}

	public function addDataChannelVideoEkskul($data)
	{
		$this->db->insert('tb_channel_video_ekskul', $data);
	}

	public function updatedilistekskul($id, $status)
	{
		$this->db->where('id_video', $id);
		$data = array(
			'dilist' => $status
		);
		return $this->db->update('tb_video', $data);
	}

	public function delDataChannelVideoEkskul($id_video, $id_paket)
	{
		$this->db->where('(id_video = ' . $id_video . ' AND id_paket = ' . $id_paket . ')');
		$this->db->delete('tb_channel_video_ekskul');
	}

	public function getDataChannelVideoEkskul($id_paket)
	{
		$this->db->from('tb_channel_video_ekskul tcv');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		$this->db->where('id_paket', $id_paket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('urutan', 'desc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function updateDurasiPaketEkskul($linklist, $data)
	{
		$this->db->where('link_list', $linklist);
		return $this->db->update('tb_paket_channel_ekskul', $data);
	}

	public function getDafPlayListEkskul($idsaya,$bulan = null, $tahun = null)
	{
		$this->db->from('tb_paket_channel_ekskul tpc');
		$this->db->join('tb_channel_video_ekskul tcv', 'tcv.id_paket = tpc.id', 'left');
		$this->db->join('tb_video tv', 'tv.id_video = tcv.id_video', 'left');
		if ($idsaya!=null)
			$this->db->where('(tpc.id_user=' . $idsaya . ')');
		if ($bulan != null) {
			$this->db->where('tpc.bulanekskul', $bulan);
			$this->db->where('tpc.tahunekskul', $tahun);
		} else {
			$datesekarang = new DateTime();
			$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$bulansekarang = $datesekarang->format('m');
			$tahunsekarang = $datesekarang->format('Y');
			$this->db->where('tpc.bulanekskul', $bulansekarang);
			$this->db->where('tpc.tahunekskul', $tahunsekarang);
		}
		$this->db->where('tv.id_video IS NOT NULL');
		$this->db->group_by('nama_paket');
		$this->db->order_by('status_paket', 'asc');
		$this->db->order_by('tanggal_tayang', 'desc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getPlayListSayaEkskul($link_list=null)
	{
		$this->db->from('tb_channel_video_ekskul tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_channel_ekskul tpc', 'tpc.id = tcv.id_paket', 'left');
//		$this->db->where('(tv.id_user=' . $idsaya . ')');
		$this->db->where('(tv.durasi<>"")');
		$this->db->where('(tpc.link_list="' . $link_list . '")');
		$this->db->where('(status_verifikasi_admin=4)');
		$this->db->order_by('urutan', 'asc');
		$this->db->order_by('tcv.id', 'asc');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getVideoUserPaketEkskul($id_user, $kodepaket)
	{
		$this->db->select('*,tv.id_video as idvideo, tcv.id as idchannel, tcv.id as idplaylist');
		$this->db->from('tb_video tv');
		$this->db->join('tb_channel_video_ekskul tcv', '(tcv.id_video = tv.id_video)', 'left');
		$this->db->join('tb_paket_channel_ekskul tpc', 'tcv.id_paket = tpc.id', 'left');

		$this->db->where('tpc.link_list', $kodepaket);
		$this->db->where('(tv.durasi<>"")');
		$this->db->order_by('tcv.urutan ASC, tcv.id ASC');
		$result = $this->db->get()->result();
		return $result;
	}

	public function updateurutan($data)
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
		$this->db->update_batch('tb_channel_video_ekskul', $updateArray, 'id');
	}

	public function getVideoUpload($id, $tglawal, $tglakhir)
	{
		$this->db->from('tb_video tv');
		$this->db->where('tipe_video', 2);// tipe video untuk ekskul
		$this->db->where('(modified>="' . $tglawal . '")');
		$this->db->where('(modified<="' . $tglakhir . '")');
		if ($id!=null)
		{
			$this->db->where('id_user', $id);
		}

//		$this->db->order_by('tv.id ASC');
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function getVideoUploadSiswa($npsn, $tglawal, $tglakhir)
	{
		$this->db->from('tb_video tv');
		$this->db->where('tipe_video', 2);// tipe video untuk ekskul
		if ($tglawal!=null && $tglakhir!=null) {
			$this->db->where('(modified>="' . $tglawal . '")');
			$this->db->where('(modified<="' . $tglakhir . '")');
		}
		$this->db->where('npsn_user', $npsn);

//		$this->db->order_by('tv.id ASC');
		$result = $this->db->get()->result();

		return $result;

	}

	public function cekpembayar()
	{
		$this->db->from('daf_chn_sekolah');
		$this->db->where('npsn', $this->session->userdata('npsn'));
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function updatepembayar($idpembayar)
	{
		$data = array(
			'pembayarekskul' => $idpembayar
		);
		$this->db->where('npsn', $this->session->userdata('npsn'));
		$this->db->update('daf_chn_sekolah', $data);
	}

	public function getSiswaEkskul($iduser)
	{
		$this->db->select('te.id as nomorekskul, te.*, tu.first_name, tu.last_name');
		$this->db->from('tb_ekskul te');
		$this->db->join('tb_user tu', 'tu.id = te.id_user', 'left');
		$this->db->where('te.id_user', $iduser);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getTugasVideoBulanan($iduser)
	{
		$this->db->select('tv.id_video, sum(if(tv.id_video="",0,1)) as totalvideo');
		$this->db->from('tb_video tv');
		$this->db->where('tv.tipe_video', 2);
		$this->db->where('(tv.status_verifikasi=2 OR tv.status_verifikasi=4)');
		$this->db->where('tv.id_user', $iduser);
		$this->db->group_by('(SUBSTRING(tv.created,1,7))');
		$query = $this->db->get();
		$ret = $query->result();
		return $ret;
	}

	public function getVideoPlaylistHarian($iduser)
	{
//		$this->db->select('te.id as nomorekskul, te.*, tu.first_name, tu.last_name');
		$this->db->from('tb_channel_video_sekolah tcv');
		$this->db->join('tb_video tv', 'tcv.id_video = tv.id_video', 'left');
		$this->db->join('tb_paket_channel_sekolah tpc', 'tpc.id = tcv.id_paket', 'left');
		$this->db->where('tv.tipe_video', 2);
		$this->db->where('(tv.status_verifikasi=2 OR tv.status_verifikasi=4)');
		$this->db->where('tv.id_user', $iduser);
		$this->db->group_by('tcv.id_paket');
		$query = $this->db->get();
		$ret = $query->result();
		return $ret;
	}

	public function cekIuranBulanan($iduser)
	{
		$this->db->from('tb_payment tp');
		$this->db->where('tp.iduser', $iduser);
		$this->db->where('(SUBSTRING(order_id,1,2)="EK")');
		$query = $this->db->get();
		$ret = $query->result();
		return $ret;
	}

}
