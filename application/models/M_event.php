<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_event extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
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
		$this->db->join('tb_userevent tu', 'te.code_event = tu.code_event AND tu.status_user = 2 AND tu.id_user = "'.
			$iduserku.'"','left');
		if ($this->session->userdata('a01'))
		{
			//if ($asal=="acara")
				$this->db->where('te.status>=', 1);
		}
		else
		{
			$this->db->where('te.status>=', 1);
		}

		$this->db->where('viaverifikator', 0);
		if (isset($this->session->userdata['email'])) {
			if ($this->session->userdata('a001') && $asal==null) {

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
		$this->db->join('tb_userevent tu', 'te.code_event = tu.code_event AND tu.status_user = 2 AND tu.npsn = "'.
			$npsnku.'"','left');
		$this->db->where('te.status', 1);
		$this->db->where('viaverifikator', 1);
		if (isset($this->session->userdata['email'])) {
			if ($this->session->userdata('a001')) {

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
		$this->db->group_by("code_event");
		$this->db->order_by("tgl_mulai", "desc");
		$query2 = $this->db->get_compiled_select();

		$query = $this->db->query($query1 . ' UNION ' . $query2);
		$query = $query->result();

		return $query;
	}

	public function updatesertifikatcalver($namaser,$emailser,$code,$iduser,$nomorurutan = null,$download = null)
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
		$this->db->where('id_calver', $iduser);
		$this->db->where('kode_event', $code);
		$this->db->update('tb_mentor_calver_daf', $data);
	}

	public function cekUserCalverEvent($code,$iduser,$opsi=null)
	{
		$this->db->from('tb_mentor_calver_daf tm');
		// $this->db->join('tb_user tu', 'tu.id = tm.id_calver','left');
		$this->db->where('(kode_event="'.$code.'" AND id_calver='.$iduser.')');
		$result = $this->db->get()->row();
		return $result;
	}

	public function ceknomorsertifikatakhir($code)
	{
		$this->db->from('tb_mentor_calver_daf');
		$this->db->where('(kode_event="'.$code.'")');
		$this->db->where('urutan_nomor>0');
		$this->db->order_by('urutan_nomor','asc');
		$result = $this->db->get()->row();
		return $result;
	}

	public function gettanggalevent($koderef)
	{
		$this->db->from('tb_marketing');
		$this->db->where('(kode_referal="'.$koderef.'")');
		$result = $this->db->get()->row();
		return $result;
	}

	public function getsertifikatmodul($bulan,$tahun,$kodeevent,$iduser)
	{
		$this->db->from('tb_modul_bulanan');
		$this->db->where('(id_guru="'.$iduser.'")');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_event', $kodeevent);
		$result = $this->db->get()->row();
		return $result;
	}

	public function getsertifikatcalver($kodeevent,$iduser)
	{
		$this->db->from('tb_mentor_calver_daf');
		$this->db->where('(id_calver="'.$iduser.'")');
		$this->db->where('kode_event', $kodeevent);
		$result = $this->db->get()->row();
		return $result;
	}

}
