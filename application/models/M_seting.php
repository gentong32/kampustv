<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_seting extends CI_Model {

    public function __construct()	{
        $this->load->database();
    }

    public function getPenilaian(){
        $this->db->from('daf_penilaian2');
        $this->db->where('(nama_penilaian<>"")');
        $result = $this->db->get()->result();
        return $result;
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

	public function delkd($idkd) {
		$this->db->where('id', $idkd);
		return $this->db->delete('daf_kd');
	}

    public function editmapel($data,$idmapel) {
        $this->db->where('id', $idmapel);
        return $this->db->update('daf_mapel', $data);
    }

	public function editkate($data,$idkd) {
		$this->db->where('id', $idkd);
		return $this->db->update('daf_kategori', $data);
	}

	public function delkat($idkat) {
		$this->db->where('id', $idkat);
		return $this->db->delete('daf_kategori');
	}

    public function addAcara($data){
        $this->db->insert('tb_live_acara', $data);
    }

    public function updateAcara($data,$id) {
        $this->db->where('id', $id);
        return $this->db->update('tb_live_acara', $data);
    }

    public function delAcara($data){
        $this -> db -> where($data);
        $this -> db -> delete('tb_live_acara');
    }

    public function addJurusanSMK($data){
        $this->db->insert('daf_jurusan', $data);
    }

    public function updateJurusanSMK($data,$id) {
        $this->db->where('id', $id);
        return $this->db->update('daf_jurusan', $data);
    }

    public function delJurusanSMK($id){
        $this->db->where('id', $id);
        $this -> db -> delete('daf_jurusan');
    }

	public function addFakultas($data){
		$this->db->insert('daf_fakultas', $data);
	}

	public function updateFakultas($data,$id) {
		$this->db->where('id', $id);
		return $this->db->update('daf_fakultas', $data);
	}

	public function delFakultas($id){
		$this->db->where('id', $id);
		$this -> db -> delete('daf_fakultas');
	}

	public function getJurusanPT($idfakultas){
		$this->db->from('daf_jurusanpt');
		$this->db->where('id_fakultas', $idfakultas);
		$result = $this->db->get()->result();
		return $result;
	}

	public function addJurusan($data)
	{
		$this->db->insert('daf_jurusanpt', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function updateJurusan($data,$id) {
		$this->db->where('id', $id);
		return $this->db->update('daf_jurusanpt', $data);
	}

    public function addSekolah($data){
		$this->db->from('daf_sekolah');
		$this->db->where('npsn',$data['npsn']);
		if (!$this->db->get()->result())
			$this->db->insert('daf_sekolah', $data);
    }

    public function updateSekolah($data,$id) {
        $this->db->where('id', $id);
        return $this->db->update('daf_sekolah', $data);
    }

    public function delSekolah($id){
        $this->db->where('id', $id);
        $this -> db -> delete('daf_sekolah');
    }

    public function cekKDterpakai($idkd)
	{
		$this->db->from('tb_video');
		$this->db->where('id_kd1_1',$idkd);
		$query = $this->db->get();
		$rowcount1 = $query->num_rows();

		$this->db->from('tb_video');
		$this->db->where('id_kd1_2',$idkd);
		$query = $this->db->get();
		$rowcount2 = $query->num_rows();

		$this->db->from('tb_video');
		$this->db->where('id_kd1_3',$idkd);
		$query = $this->db->get();
		$rowcount3 = $query->num_rows();

		$rowcounttot = $rowcount1 + $rowcount2 + $rowcount3;
		return $rowcounttot;

	}

	public function cekKATterpakai($idkd)
	{
		$this->db->from('tb_video');
		$this->db->where('id_kategori',$idkd);
		$query = $this->db->get();
		$rowcount = $query->num_rows();

		return $rowcount;
	}

	public function getSoal($idpaket)
	{
		$this->db->from('tb_soal_assesment');
		$this->db->where('id_paket', $idpaket);
		$result = $this->db->get()->result();
		return $result;
	}

	public function updategbrsoal($namafile, $id, $fielddb){
		$data = array(
			$fielddb => $namafile
		);
		$this->db->where('id_soal', $id);
		return $this->db->update('tb_soal_assesment', $data);
	}

	public function updatesoal($data, $id){
		$this->db->where('id_soal', $id);
		return $this->db->update('tb_soal_assesment', $data);
	}

	public function insertsoal($asseske)
	{
		$data['id_paket'] = $asseske;
		$this->db->insert('tb_soal_assesment', $data);
		$insertid = $this->db->insert_id();
		return $insertid?$insertid:0;
	}

	public function delsoal($id)
	{
		$this->db->where('(id_soal='.$id.')');
		return $this->db->delete('tb_soal_assesment');
	}

	public function getesay($untuksi)
	{
		$this->db->from('tb_soalessay_assesment');
		$this->db->where('tipe_paket', $untuksi);
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function updateesay($data,$untuksi)
	{
		$this->db->where('tipe_paket', $untuksi);
		return $this->db->update('tb_soalessay_assesment', $data);
	}


}
