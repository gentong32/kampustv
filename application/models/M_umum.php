<?php

class M_umum extends CI_Model {

    public function __construct()	{
        $this->load->database();
    }

	function dafpropinsi($idnegara)
	{
		$this->db->where('id_negara', $idnegara);
		$this->db->from('daf_propinsi');
		$result = $this->db->get()->result();
		return $result;
	}

	function dafagency($idpropinsi = null)
	{
		$this->db->from('tb_user tu');
		if ($idpropinsi>100)
		{
			$this->db->where('kd_negara', $idpropinsi-100);
			$this->db->join('daf_propinsi dk','tu.kd_kota = dk.id_propinsi','left');
		}

		else
		{
			$this->db->join('daf_kota dk','tu.kd_kota = dk.id_kota','left');
			if ($idpropinsi!=null)
			$this->db->where('id_propinsi', $idpropinsi);
		}

		$this->db->where('siag', 3);
		$result = $this->db->get()->result();
		return $result;
	}

	function getUserbyId($iduser)
	{
		$this->db->from('tb_user tu');
		$this->db->join('daf_chn_sekolah ds', 'ds.npsn = tu.npsn','left');
		$this->db->where('tu.id',$iduser);
		$result = $this->db->get()->result();
		return $result;
	}

	function getEmailUser200($index)
	{
		$this->db->select('email');
		$this->db->from('tb_user tu');
		$this->db->where('tu.sebagai',1);
		$this->db->where('tu.verifikator',3);
		$this->db->limit(200, 200*($index-1));
		$result = $this->db->get()->result();
		return $result;
	}
}
