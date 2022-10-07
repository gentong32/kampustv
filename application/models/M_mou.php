<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_mou extends CI_Model {

    public function __construct()	{
        $this->load->database();
    }

	public function getKodeMOU($npsn)
	{
		$this->db->from('tb_mou');
		$this->db->where('npsn_sekolah', $npsn);
		$result = $this->db->get()->result();
		return $result;
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

	public function getlastmou($iduser)
	{
		$this->db->from('tb_mou');
		$this->db->where('id_agency', $iduser);
		$this->db->where('status<=', 1);
		$result = $this->db->get()->row();
		return $result;
	}

	public function addmou($iduser)
	{
		$data = array("id_agency" => $iduser);
		$this->db->insert('tb_mou', $data);
		$insert_id = $this->db->insert_id();
		$this->db->from('tb_mou tm');
		$this->db->where('id', $insert_id);
		$result = $this->db->get()->row();
		return $result;
	}

	public function cekkoderefag($koderef)
	{
		$this->db->from('tb_mou');
		$this->db->where('kode_referal', $koderef);
		$this->db->where('npsn_sekolah', $this->session->userdata('npsn'));
		$result = $this->db->get()->row();
		return $result;
	}

	public function cekkoderefam($koderef)
	{
		$this->db->from('tb_marketing');
		$this->db->where('kode_referal', $koderef);
		$this->db->where('npsn_sekolah', $this->session->userdata('npsn'));
		$result = $this->db->get()->row();
		return $result;
	}

	public function addmoumarketing($idsiam, $koderef)
	{
		$data = array("id_siam" => $idsiam,
			"kode_referal"=>$koderef, "npsn_sekolah"=>$this->session->userdata('npsn'));
		$this->db->insert('tb_mou', $data);
	}

	public function cekmouaktif($npsn,$batas)
	{
		$this->db->from('tb_mou');
		$this->db->where('npsn_sekolah', $npsn);
		if ($batas>0)
			$this->db->where('pilihan_mou<=', $batas);
		else
			$this->db->where('pilihan_mou>', 0);
		$this->db->where('status_tagih4', 0);
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		$ret = $query->last_row();
		return $ret;
	}

	public function updatedatamou($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('tb_mou', $data);
	}

	public function updatestatusordermou($orderid)
	{
		$idx = substr($orderid, 4, 1);

		$this->db->where("order_id_payment".$idx, $orderid);
		$data = array ("status_tagih".$idx=>1);
		return $this->db->update('tb_mou', $data);
	}

}
