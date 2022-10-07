<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_promo extends CI_Model {

    public function __construct()	{
        $this->load->database();
    }



    public function updatePenilaian($isiteks,$ke) {
    	$ke++;
		$this->db->where('id', $ke);
		$data = array (
			'nama_penilaian' => $isiteks
		);
		return $this->db->update('daf_penilaian2', $data);
	}

	public function addkd($data){
		$this->db->insert('daf_kd', $data);
	}

    public function addmapel($data){
        $this->db->insert('daf_mapel', $data);
    }

	public function addkate($data){
		$this->db->insert('daf_kategori', $data);
	}

	public function editkd($data,$idkd) {
		$this->db->where('id', $idkd);
		return $this->db->update('daf_kd', $data);
	}

    public function editmapel($data,$idmapel) {
        $this->db->where('id', $idmapel);
        return $this->db->update('daf_mapel', $data);
    }

	public function editkate($data,$idkd) {
		$this->db->where('id', $idkd);
		return $this->db->update('daf_kategori', $data);
	}



}
