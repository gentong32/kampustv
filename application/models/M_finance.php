<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_finance extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function getTransaksiBesar($bulan = null, $tahun = null)
	{
		$this->db->select('sum(iuran) as total_bruto, sum(ppnrp) as total_ppn, sum(potmidrp) as total_potmid,
		(sum(pph_agencyrp)+sum(pph_siamrp)+sum(pph_verrp)) as total_pph,
		(sum(fee_agencynet)+sum(fee_siamnet)+sum(fee_vernet)) as total_fee, sum(fee_tvsekolah) as total_feetvsekolah');
		$this->db->from('tb_payment');
		$this->db->where('status', 3);
		$this->db->where('npsn_sekolah<>', '1234567890');
		$this->db->where('npsn_sekolah<>', '1234567891');
		if (($bulan==null || $bulan==0) && ($tahun==null||$tahun==0))
		{
			
		}
		else if ($bulan==0 && $tahun>0)
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang3 = $now->format($tahun.'-01-01 00:00:00');
			$tglsekarang4 = $now->format($tahun.'-12-31 23:59:59');
			$this->db->where('(tgl_bayar>="'.$tglsekarang3.'" AND tgl_bayar<="'.$tglsekarang4.'")');
		}
		else 
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang1 = $now->format($tahun.'-'.$bulan.'-01 00:00:00');
			$tglsekarang2 = $now->format($tahun.'-'.$bulan.'-t 23:59:59');
			$this->db->where('(tgl_bayar>="'.$tglsekarang1.'" AND tgl_bayar<="'.$tglsekarang2.'")');
		}

		$query1 = $this->db->get_compiled_select();

		$this->db->select('sum(rp_bruto) as total_bruto, sum(rp_ppn) as total_ppn, sum(rp_midtrans) as total_potmid,
		(sum(rp_ag_pph)+sum(rp_am_pph)+sum(rp_ver_pph)+sum(rp_kontri_pph)) as total_pph,
		(sum(rp_ag_net)+sum(rp_am_net)+sum(rp_ver_net)+sum(rp_kontri_net)) as total_fee, 
		sum(rp_manajemen_bruto) as total_feetvsekolah');
		$this->db->from('tb_virtual_kelas tk');
		$this->db->join('tb_vk_beli tb','tb.kode_beli = tk.kode_beli','left');
		$this->db->where('status_beli', 2);
		$this->db->where('npsn_user<>', '1234567890');
		$this->db->where('npsn_user<>', '1234567891');
		if (($bulan==null || $bulan==0) && ($tahun==null||$tahun==0))
		{
			
		}
		else if ($bulan==0 && $tahun>0)
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang3 = $now->format($tahun.'-01-01 00:00:00');
			$tglsekarang4 = $now->format($tahun.'-12-31 23:59:59');
			$this->db->where('(tgl_aktif>="'.$tglsekarang3.'" AND tgl_aktif<="'.$tglsekarang4.'")');
		}
		else 
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang1 = $now->format($tahun.'-'.$bulan.'-01 00:00:00');
			$tglsekarang2 = $now->format($tahun.'-'.$bulan.'-t 23:59:59');
			$this->db->where('(tgl_aktif>="'.$tglsekarang1.'" AND tgl_aktif<="'.$tglsekarang2.'")');
		}

		$query2 = $this->db->get_compiled_select();

		$this->db->select('sum(iuran) as total_bruto, sum(ppnrp) as total_ppn, sum(potmidrp) as total_potmid,
		(sum(pph_agencyrp)+sum(pph_siamrp)) as total_pph,
		(sum(fee_agencynet)+sum(fee_siamnet)) as total_fee, sum(fee_tvsekolah) as total_feetvsekolah');
		$this->db->from('tb_userevent');
		$this->db->where('status_user', 2);
		$this->db->where('npsn<>', '1234567890');
		$this->db->where('npsn<>', '1234567891');
		if (($bulan==null || $bulan==0) && ($tahun==null||$tahun==0))
		{
			
		}
		else if ($bulan==0 && $tahun>0)
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang3 = $now->format($tahun.'-01-01 00:00:00');
			$tglsekarang4 = $now->format($tahun.'-12-31 23:59:59');
			$this->db->where('(tgl_konfirm>="'.$tglsekarang3.'" AND tgl_konfirm<="'.$tglsekarang4.'")');
		}
		else 
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang1 = $now->format($tahun.'-'.$bulan.'-01 00:00:00');
			$tglsekarang2 = $now->format($tahun.'-'.$bulan.'-t 23:59:59');
			$this->db->where('(tgl_konfirm>="'.$tglsekarang1.'" AND tgl_konfirm<="'.$tglsekarang2.'")');
		}

		$query3 = $this->db->get_compiled_select();

		$query = $this->db->query('SELECT SUM(total_bruto) as total_bruto, 
		SUM(total_ppn) as total_ppn, SUM(total_potmid) as total_potmid,
		SUM(total_pph) as total_pph, SUM(total_fee) as total_fee, 
		SUM(total_feetvsekolah) as total_feetvsekolah FROM ('.$query1 . ' UNION ' . $query2. 
		' UNION ' . $query3.') as TBL');
		
		$query = $query->row();

		return $query;
	}

	public function getTransaksiDetil($bulan = null, $tahun = null)
	{
		$this->db->select('tgl_bayar, tipebayar, order_id, iuran, ppnrp, potmidrp, first_name, last_name, sekolah');
		$this->db->from('tb_payment tp');
		$this->db->join('tb_user tu', 'tp.iduser = tu.id', 'left');
		$this->db->where('status', 3);
		$this->db->where('iuran>', 0);
		$this->db->where('npsn_sekolah<>', '1234567890');
		$this->db->where('npsn_sekolah<>', '1234567891');
		if (($bulan==null || $bulan==0) && ($tahun==null||$tahun==0))
		{
			
		}
		else if ($bulan==0 && $tahun>0)
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang3 = $now->format($tahun.'-01-01 00:00:00');
			$tglsekarang4 = $now->format($tahun.'-12-31 23:59:59');
			$this->db->where('(tgl_bayar>="'.$tglsekarang3.'" AND tgl_bayar<="'.$tglsekarang4.'")');
		}
		else 
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang1 = $now->format($tahun.'-'.$bulan.'-01 00:00:00');
			$tglsekarang2 = $now->format($tahun.'-'.$bulan.'-t 23:59:59');
			$this->db->where('(tgl_bayar>="'.$tglsekarang1.'" AND tgl_bayar<="'.$tglsekarang2.'")');
		}

		$query1 = $this->db->get_compiled_select();

		$this->db->select('tgl_aktif as tgl_bayar, tipe_bayar as tipebayar, kode_beli as order_id, rupiah as iuran, ppnrp, potmidrp, first_name, last_name, sekolah');
		$this->db->from('tb_vk_beli tb');
		$this->db->join('tb_user tu', 'tb.id_user = tu.id', 'left');
		$this->db->where('rupiah>', 0);
		$this->db->where('status_beli', 2);
		$this->db->where('npsn_user<>', '1234567890');
		$this->db->where('npsn_user<>', '1234567891');
		if (($bulan==null || $bulan==0) && ($tahun==null||$tahun==0))
		{
			
		}
		else if ($bulan==0 && $tahun>0)
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang3 = $now->format($tahun.'-01-01 00:00:00');
			$tglsekarang4 = $now->format($tahun.'-12-31 23:59:59');
			$this->db->where('(tgl_aktif>="'.$tglsekarang3.'" AND tgl_aktif<="'.$tglsekarang4.'")');
		}
		else 
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang1 = $now->format($tahun.'-'.$bulan.'-01 00:00:00');
			$tglsekarang2 = $now->format($tahun.'-'.$bulan.'-t 23:59:59');
			$this->db->where('(tgl_aktif>="'.$tglsekarang1.'" AND tgl_aktif<="'.$tglsekarang2.'")');
		}

		$query2 = $this->db->get_compiled_select();

		$this->db->select('tgl_bayar, tipebayar, order_id, iuran, ppnrp, potmidrp, first_name, last_name, sekolah');
		$this->db->from('tb_userevent tp');
		$this->db->join('tb_user tu', 'tp.id_user = tu.id', 'left');
		$this->db->where('status_user', 2);
		$this->db->where('iuran>', 0);
		$this->db->where('tp.npsn<>', '1234567890');
		$this->db->where('tp.npsn<>', '1234567891');
		if (($bulan==null || $bulan==0) && ($tahun==null||$tahun==0))
		{
			
		}
		else if ($bulan==0 && $tahun>0)
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang3 = $now->format($tahun.'-01-01 00:00:00');
			$tglsekarang4 = $now->format($tahun.'-12-31 23:59:59');
			$this->db->where('(tgl_konfirm>="'.$tglsekarang3.'" AND tgl_konfirm<="'.$tglsekarang4.'")');
		}
		else 
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang1 = $now->format($tahun.'-'.$bulan.'-01 00:00:00');
			$tglsekarang2 = $now->format($tahun.'-'.$bulan.'-t 23:59:59');
			$this->db->where('(tgl_konfirm>="'.$tglsekarang1.'" AND tgl_konfirm<="'.$tglsekarang2.'")');
		}

		$query3 = $this->db->get_compiled_select();

		$query = $this->db->query($query1 . ' UNION ' . $query2 . ' UNION ' . $query3);
		$query = $query->result();

		return $query;
	}

	public function getTransaksiFee($bulan = null, $tahun = null)
	{
		$this->db->select('tgl_bayar, tipebayar, order_id, id_agency, id_siam, id_ver, 0 as id_kontri, nama_prodi, 
		fee_agencybruto,  pph_agencyrp, fee_agencynet, 
		tu1.first_name as first_name_agency, tu1.last_name as last_name_agency, tu1.npwp as npwp_agency, fee_siambruto, pph_siamrp, fee_siamnet, 
		tu2.first_name as first_name_siam, tu2.last_name as last_name_siam, tu2.npwp as npwp_siam,
		fee_verbruto, pph_verrp, fee_vernet, 
		tu3.first_name as first_name_ver, tu3.last_name as last_name_ver, tu3.npwp as npwp_ver,
		0 as fee_kontribruto, 0 as pph_kontrirp, 0 as fee_kontrinet, 
		"" as first_name_kontri, "" as last_name_kontri, "" as npwp_kontri');
		$this->db->from('tb_payment tp');
		$this->db->join('tb_user tu1', 'tp.id_agency = tu1.id', 'left');
		$this->db->join('tb_user tu2', 'tp.id_siam = tu2.id', 'left');
		$this->db->join('tb_user tu3', 'tp.id_ver = tu3.id', 'left');
		$this->db->join('daf_chn_sekolah ds', 'tp.npsn_sekolah = ds.npsn_sekolah', 'left');
		$this->db->where('tp.status', 3);
		$this->db->where('iuran>', 0);
		if (($bulan==null || $bulan==0) && ($tahun==null||$tahun==0))
		{
			
		}
		else if ($bulan==0 && $tahun>0)
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang3 = $now->format($tahun.'-01-01 00:00:00');
			$tglsekarang4 = $now->format($tahun.'-12-31 23:59:59');
			$this->db->where('(tgl_bayar>="'.$tglsekarang3.'" AND tgl_bayar<="'.$tglsekarang4.'")');
		}
		else 
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang1 = $now->format($tahun.'-'.$bulan.'-01 00:00:00');
			$tglsekarang2 = $now->format($tahun.'-'.$bulan.'-t 23:59:59');
			$this->db->where('(tgl_bayar>="'.$tglsekarang1.'" AND tgl_bayar<="'.$tglsekarang2.'")');
		}

		$query1 = $this->db->get_compiled_select();

		$this->db->select ('tgl_aktif, tipe_bayar, tk.kode_beli as order_id, id_ag, id_am, id_ver, id_kontri, nama_prodi, 
		SUM(rp_ag_bruto) as fee_agencybruto, SUM(rp_ag_pph) as pph_agencyrp, SUM(rp_ag_net) as fee_agencynet, 
		tu1.first_name as first_name_agency, tu1.last_name as last_name_agency, tu1.npwp as npwp_agency, 
		SUM(rp_am_bruto) as fee_siambruto, SUM(rp_am_pph) as pph_siamrp, SUM(rp_am_net) as fee_siamnet, 
		tu2.first_name as first_name_siam, tu2.last_name as last_name_siam, tu2.npwp as npwp_siam,
		SUM(rp_ver_bruto) as fee_verbruto, SUM(rp_ver_pph) as pph_verrp, SUM(rp_ver_net) as fee_vernet, 
		tu3.first_name as first_name_ver, tu3.last_name as last_name_ver, tu3.npwp as npwp_ver,
		SUM(rp_kontri_bruto) as fee_kontribruto, SUM(rp_kontri_pph) as pph_kontrirp, SUM(rp_kontri_net) as fee_kontrinet, 
		tu4.first_name as first_name_kontri, tu4.last_name as last_name_kontri, tu4.npwp as npwp_kontri');
		$this->db->from('tb_virtual_kelas tk');
		$this->db->join('tb_vk_beli tb', 'tb.kode_beli = tk.kode_beli', 'left');
		$this->db->join('tb_user tu1', 'tk.id_ag = tu1.id', 'left');
		$this->db->join('tb_user tu2', 'tk.id_am = tu2.id', 'left');
		$this->db->join('tb_user tu3', 'tk.id_ver = tu3.id', 'left');
		$this->db->join('tb_user tu4', 'tk.id_kontri = tu4.id', 'left');
		$this->db->join('daf_chn_sekolah ds', 'tb.npsn_user = ds.npsn_sekolah', 'left');
		$this->db->where('rupiah>', 0);
		$this->db->where('status_beli', 2);
		if (($bulan==null || $bulan==0) && ($tahun==null||$tahun==0))
		{
			
		}
		else if ($bulan==0 && $tahun>0)
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang3 = $now->format($tahun.'-01-01 00:00:00');
			$tglsekarang4 = $now->format($tahun.'-12-31 23:59:59');
			$this->db->where('(tgl_aktif>="'.$tglsekarang3.'" AND tgl_aktif<="'.$tglsekarang4.'")');
		}
		else 
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang1 = $now->format($tahun.'-'.$bulan.'-01 00:00:00');
			$tglsekarang2 = $now->format($tahun.'-'.$bulan.'-t 23:59:59');
			$this->db->where('(tgl_aktif>="'.$tglsekarang1.'" AND tgl_aktif<="'.$tglsekarang2.'")');
		}
		
		$this->db->group_by('tk.kode_beli, tk.id_kontri');

		$query2 = $this->db->get_compiled_select();

		$this->db->select('tgl_bayar, tipebayar, order_id, id_agency, id_siam, 0 as id_ver, 0 as id_kontri, nama_prodi, 
		fee_agencybruto,  pph_agencyrp, fee_agencynet, 
		tu1.first_name as first_name_agency, tu1.last_name as last_name_agency, tu1.npwp as npwp_agency, fee_siambruto, pph_siamrp, fee_siamnet, 
		tu2.first_name as first_name_siam, tu2.last_name as last_name_siam, tu2.npwp as npwp_siam,
		0 as fee_verbruto, 0 as pph_verrp, 0 as fee_vernet, 
		"" as first_name_ver, "" as last_name_ver, "" as npwp_ver,
		0 as fee_kontribruto, 0 as pph_kontrirp, 0 as fee_kontrinet, 
		"" as first_name_kontri, "" as last_name_kontri, "" as npwp_kontri');
		$this->db->from('tb_userevent tp');
		$this->db->join('tb_user tu1', 'tp.id_agency = tu1.id', 'left');
		$this->db->join('tb_user tu2', 'tp.id_siam = tu2.id', 'left');
		$this->db->join('daf_chn_sekolah ds', 'tp.npsn = ds.npsn_sekolah', 'left');
		$this->db->where('status_user', 2);
		$this->db->where('iuran>', 0);
		if (($bulan==null || $bulan==0) && ($tahun==null||$tahun==0))
		{
			
		}
		else if ($bulan==0 && $tahun>0)
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang3 = $now->format($tahun.'-01-01 00:00:00');
			$tglsekarang4 = $now->format($tahun.'-12-31 23:59:59');
			$this->db->where('(tgl_konfirm>="'.$tglsekarang3.'" AND tgl_konfirm<="'.$tglsekarang4.'")');
		}
		else 
		{
			$now = new DateTime();
			$now->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tglsekarang1 = $now->format($tahun.'-'.$bulan.'-01 00:00:00');
			$tglsekarang2 = $now->format($tahun.'-'.$bulan.'-t 23:59:59');
			$this->db->where('(tgl_konfirm>="'.$tglsekarang1.'" AND tgl_konfirm<="'.$tglsekarang2.'")');
		}

		$query3 = $this->db->get_compiled_select();

		$query = $this->db->query($query1 . ' UNION ALL ' . $query2. ' UNION ALL ' . $query3);
		//$query = $this->db->query($query1);
		$query = $query->result();

		return $query;
	}

}
