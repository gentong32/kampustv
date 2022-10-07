<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_agency extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function getlastagency($iduser)
	{
		$this->db->select('tam.*, nama_sekolah, nama_kota');
		$this->db->from('tb_mou tam');
		$this->db->join('daf_chn_sekolah ds', 'tam.npsn_sekolah = ds.npsn', 'left');
		$this->db->join('daf_kota dk', 'ds.idkota = dk.id_kota', 'left');
		$this->db->where('id_agency', $iduser);
		$this->db->where('tam.status<=', 1);
		$result = $this->db->get()->row();
		return $result;
	}

	public function addagency($iduser)
	{
		$data = array("id_agency" => $iduser);
		$this->db->insert('tb_mou', $data);
		$insert_id = $this->db->insert_id();
		$this->db->select('tam.*, nama_sekolah, nama_kota');
		$this->db->from('tb_mou tam');
		$this->db->join('daf_chn_sekolah ds', 'tam.npsn_sekolah = ds.npsn', 'left');
		$this->db->join('daf_kota dk', 'ds.idkota = dk.id_kota', 'left');
		$this->db->where('tam.id', $insert_id);
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

	public function updateagencymou($data, $status, $id)
	{
		$this->db->where('id_agency', $id);
		$this->db->where('status', $status);
		if($this->db->update('tb_mou', $data))
			return true;
		else
			return false;
	}

	public function ceksasaran($npsn)
	{
		$this->db->from('tb_mou');
		$this->db->where('npsn_sekolah', $npsn);
		$result = $this->db->get()->row();
		return $result;
	}

	public function getDafAktif($id)
	{
		$this->db->select('tm.*,nama_sekolah,tu.first_name,tu.last_name');
		$this->db->from('tb_marketing tm');
		$this->db->join('daf_chn_sekolah ds', 'tm.npsn_sekolah = ds.npsn', 'left');
		$this->db->join('tb_user tu', 'tm.id_siam = tu.id', 'left');
		$this->db->where('id_agency', $id);
		// $this->db->where('tm.status', 2);
		$this->db->group_by('tm.id');
		$this->db->order_by("tm.tgl_jalan","desc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafUser($idkota)
	{
		$this->db->select('tu.*');
		$this->db->from('tb_user tu');
		$this->db->where('kd_kota', $idkota);
		$this->db->where('siam', 3);
		$this->db->order_by("tu.first_name","asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDafUserAll()
	{
		$this->db->select('tu.*,nama_kota');
		$this->db->from('tb_user tu');
		$this->db->join('daf_kota dk', 'dk.id_kota = tu.kd_kota', 'left');
		$this->db->where('siam', 3);
		$this->db->order_by("tu.first_name","asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getTransaksi($idsiag)
	{
		$this->db->select('tu.first_name, tu.last_name, tu.sekolah, tb.tgl_beli, tv.siapambil,
		sum(rp_ag_bruto) as total_bruto,tv.kode_beli,tv.jenis_paket,
		sum(rp_ag_pph) as total_pph, sum(rp_ag_net) as total_net, tv.status_ag');
		$this->db->from('tb_virtual_kelas tv');
		$this->db->join('tb_vk_beli tb', 'tv.kode_beli = tb.kode_beli', 'left');
		$this->db->join('tb_paket_channel tc', 'tv.link_paket = tc.link_list', 'left');
		$this->db->join('tb_user tu', 'tv.id_user = tu.id', 'left');
		$this->db->group_by('tv.id_user, tv.kode_beli');
		$this->db->where('id_ag', $idsiag);
		$this->db->order_by("tb.tgl_beli","asc");
		$this->db->order_by("tv.status_ag","asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllTransaksiKelasVirtual($bulan,$tahun)
	{
		$tanggalset = new DateTime("$tahun/$bulan/1");
		$tanggalset = $tanggalset->modify("-1 month");
		$batasawal = $tanggalset->format("Y-m-01 00:00:00");
		$batasakhir = $tanggalset->format("Y-m-t 23:59:59");

		$this->db->select('tu.first_name, tu.last_name, tu.sekolah, tb.tgl_beli, tv.siapambil, 
		sum(rp_ag_bruto) as total_bruto_ag, sum(rp_ag_pph) as total_pph_ag, sum(rp_ag_net) as total_net_ag,
		sum(rp_kontri_bruto) as total_bruto_kontri, sum(rp_kontri_pph) as total_pph_kontri, sum(rp_kontri_net) as total_net_kontri, 
		tv.kode_beli, tv.jenis_paket, tv.status_ag, tv.status_am');
		$this->db->from('tb_virtual_kelas tv');
		$this->db->join('tb_vk_beli tb', 'tv.kode_beli = tb.kode_beli', 'left');
		$this->db->join('tb_paket_channel tc', 'tv.link_paket = tc.link_list', 'left');
		$this->db->join('tb_user tu', 'tv.id_user = tu.id', 'left');
		$this->db->group_by('tv.id_user, tv.kode_beli');
		$this->db->where('tb.tgl_beli>=',$batasawal);
		$this->db->where('tb.tgl_beli<=',$batasakhir);
		$this->db->where('tv.jenis_paket',3);
		$this->db->order_by("tb.tgl_beli","asc");
		$this->db->order_by("tv.status_ag","asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getTransaksiPremium($idsiag)
	{
		$this->db->select('ds.nama_sekolah, tp.tgl_bayar, tp.fee_agency, tp.status_agency, tp.order_id, siapambil');
		$this->db->from('tb_payment tp');
		$this->db->join('daf_chn_sekolah ds', 'tp.npsn_sekolah = ds.npsn', 'left');
		$this->db->where('id_agency', $idsiag);
		$this->db->order_by("tp.tgl_bayar","asc");
		$this->db->order_by("tp.status_agency","asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllTransaksiIuranSekolah($bulan,$tahun)
	{
		$tanggalset = new DateTime("$tahun/$bulan/1");
		$tanggalset = $tanggalset->modify("-1 month");
		$batasawal = $tanggalset->format("Y-m-1 00:00:00");
		$batasakhir = $tanggalset->format("Y-m-t 23:59:59");

		$this->db->select('ds.nama_sekolah, tp.tgl_bayar, tp.fee_agency, tp.status_agency, tp.siapambil, 
		tp.fee_siam, tp.status_siam, tp.order_id, tp.id_siam, tp.id_agency');
		$this->db->from('tb_payment tp');
		$this->db->join('daf_chn_sekolah ds', 'tp.npsn_sekolah = ds.npsn', 'left');
		$this->db->where('fee_siam>=', 0);
		$this->db->where('fee_agency>=', 0);
		$this->db->where('tgl_bayar>=',$batasawal);
		$this->db->where('tgl_bayar<=',$batasakhir);
		$this->db->where('(SUBSTR(order_id,1,2)="TV" OR SUBSTR(order_id,1,2)="TP" OR SUBSTR(order_id,1,2)="TF")');
		$this->db->order_by("tp.tgl_bayar","asc");
		$this->db->order_by("tp.status_agency","asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllTransaksiIuranSiplah($bulan,$tahun)
	{
		$tanggalset = new DateTime("$tahun/$bulan/1");
		$tanggalset = $tanggalset->modify("-1 month");
		$batasawal = $tanggalset->format("Y-m-1 00:00:00");
		$batasakhir = $tanggalset->format("Y-m-t 23:59:59");

		$this->db->select('ds.nama_sekolah, tu.first_name, tu.last_name,tp.*');
		$this->db->from('tb_siplah tp');
		$this->db->join('tb_user tu', 'tu.id = tp.id_user', 'left');
		$this->db->join('daf_chn_sekolah ds', 'tp.npsn = ds.npsn', 'left');
		$this->db->where('konfirmasi>',0);
		$this->db->where('tgl_bayar>=',$batasawal);
		$this->db->where('tgl_bayar<=',$batasakhir);
		$this->db->order_by("tp.tgl_upload","asc");
		$this->db->order_by("tp.konfirmasi","asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllUnggahSiplah($kode=null)
	{
		$this->db->select('ds.nama_sekolah, tu.first_name, tu.last_name,tp.*');
		$this->db->from('tb_siplah tp');
		$this->db->join('tb_user tu', 'tu.kd_user = tp.id_user', 'left');
		$this->db->join('daf_sekolah ds', 'tp.npsn = ds.npsn_sekolah', 'left');
		if ($kode!=null)
			$this->db->where('tp.kode', $kode);
		$this->db->group_by("tp.kode");
		$this->db->order_by("tp.tgl_upload","asc");
		$this->db->order_by("tp.konfirmasi","asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getKodeRef($idmarketing)
	{
		$this->db->from('tb_marketing tm');
		$this->db->join('daf_chn_sekolah ds', 'tm.npsn_sekolah = ds.npsn', 'left');
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

	public function getDafMOU($id)
	{
		$this->db->select('tm.*,nama_sekolah');
		$this->db->from('tb_mou tm');
		$this->db->join('daf_chn_sekolah ds', 'tm.npsn_sekolah = ds.npsn', 'left');
		$this->db->where('id_agency', $id);
		$this->db->where('tm.status', 2);
		$result = $this->db->get()->result();
		return $result;
	}

	public function updateTransaksiPindah($bulan, $tahun, $status)
	{
		$berhasil1 = false;
		$berhasil2 = false;

		$tanggalset = new DateTime("$tahun/$bulan/1");
		$tanggalset = $tanggalset->modify("-1 month");
		$batasawal = $tanggalset->format("Y-m-1 00:00:00");
		$batasakhir = $tanggalset->format("Y-m-t 23:59:59");

		//$this->db->join('tb_vk_beli tb', 'tv.kode_beli = tb.kode_beli', 'left');
//		$this->db->where('tv.status_ag',1);
//		$this->db->where('tv.status_kontri',1);
		$this->db->where('tb.tgl_beli>=',$batasawal);
		$this->db->where('tb.tgl_beli<=',$batasakhir);
		$this->db->where('tb.jenis_paket',3);

		$data = array (
			'siapambil' => $status
		);
		if ($this->db->update('(tb_virtual_kelas tv LEFT JOIN tb_vk_beli tb ON tv.kode_beli = tb.kode_beli)',$data))
			$berhasil1 = true;

		$this->db->where('fee_siam>', 0);
		$this->db->where('fee_agency>', 0);
//		$this->db->where('status_siam',1);
//		$this->db->where('status_agency',1);
		$this->db->where('tgl_bayar>=',$batasawal);
		$this->db->where('tgl_bayar<=',$batasakhir);
		$this->db->where('(SUBSTR(order_id,1,2)="TV" OR SUBSTR(order_id,1,2)="TP" OR SUBSTR(order_id,1,2)="TF")');
		$data = array (
			'siapambil' => $status
		);
		if ($this->db->update('tb_payment', $data))
			$berhasil2 = true;

		if ($berhasil1 && $berhasil2)
			return true;
		else
			return false;
	}

}
