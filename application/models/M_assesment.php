<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_assesment extends CI_Model
{
	public function __construct()	{
		$this->load->database();
	}

	public function getSoal($tipe)
	{
		$this->db->from('tb_soal_assesment');
		$this->db->where('id_paket', $tipe);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getJawaban($iduser,$tipe)
	{
		$this->db->from('tb_soal_assesment_jawaban');
		$this->db->where('id_user', $iduser);
		$this->db->where('assesment_ke', $tipe);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getNilai($iduser)
	{
		$this->db->from('tb_soal_assesment_nilai');
		$this->db->where('id_user', $iduser);
		$result = $this->db->get()->result();
		return $result;
	}

	public function createNilai($iduser)
	{
		$this->db->from('tb_soal_assesment_nilai');
		$this->db->where('id_user', $iduser);
		$result = $this->db->get()->result();
		if (!$result) {
			$data = array("id_user" => $iduser);
			$this->db->insert('tb_soal_assesment_nilai', $data);
		}
	}

	public function updateNilai($data, $iduser)
	{
		$this->db->where('id_user', $iduser);
		return $this->db->update('tb_soal_assesment_nilai', $data);
	}

	public function getEssay($tipe)
	{
		$this->db->from('tb_soalessay_assesment');
		$this->db->where('tipe_paket', $tipe);
		$result = $this->db->get()->result();
		return $result;
	}

	public function insertJawaban($data)
	{
		$this->db->insert('tb_soal_assesment_jawaban', $data);
	}

}
