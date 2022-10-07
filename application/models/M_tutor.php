<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_tutor extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function getTransaksi($kontri)
	{
		$this->db->select('tu.first_name, tu.last_name, tu.sekolah, tb.tgl_beli, 
		sum(rp_kontri_bruto) as total_bruto,tv.kode_beli, tv.jenis_paket,
		sum(rp_kontri_pph) as total_pph, sum(rp_kontri_net) as total_net, tv.status_kontri');
		$this->db->from('tb_virtual_kelas tv');
		$this->db->join('tb_vk_beli tb', 'tv.kode_beli = tb.kode_beli', 'left');
		$this->db->join('tb_paket_channel tc', 'tv.link_paket = tc.link_list', 'left');
		$this->db->join('tb_user tu', 'tv.id_user = tu.id', 'left');
		$this->db->group_by('tv.id_user, tv.kode_beli');
		$this->db->where('id_kontri', $kontri);
		$this->db->order_by("tv.status_kontri","asc");
		$this->db->order_by("tb.tgl_beli","asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getTransaksiVerifikator($veri)
	{
		$this->db->select('tu.first_name, tu.last_name, tu.sekolah, tb.tgl_beli, 
		sum(rp_ver_bruto) as total_bruto,tv.kode_beli,
		sum(rp_ver_pph) as total_pph, sum(rp_ver_net) as total_net, tv.status_ver');
		$this->db->from('tb_virtual_kelas tv');
		$this->db->join('tb_vk_beli tb', 'tv.kode_beli = tb.kode_beli', 'left');
		$this->db->join('tb_paket_channel tc', 'tv.link_paket = tc.link_list', 'left');
		$this->db->join('tb_user tu', 'tv.id_user = tu.id', 'left');
		$this->db->group_by('tv.id_user, tv.kode_beli');
		$this->db->where('id_ver', $veri);
		$this->db->order_by("tv.status_ver","asc");
		$this->db->order_by("tb.tgl_beli","asc");
		$result = $this->db->get()->result();
		return $result;
	}

}
