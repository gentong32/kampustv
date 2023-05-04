<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_payment extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function getstandar()
	{
		$this->db->from('standar');
		$this->db->where('id', 1);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getstandarvokus()
	{
		$this->db->from('standar_vokus');
		$this->db->where('id', 1);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getdonasipil($pil = null)
	{
		$this->db->from('standar');
		$this->db->where('id', 1);
		$query = $this->db->get();
		$ret = $query->row();
		if ($pil == 1)
			return $ret->donasi1;
		else if ($pil == 2)
			return $ret->donasi2;
		else if ($pil == 3)
			return $ret->donasi3;
		else if ($pil == 4)
			return $ret->donasi4;
		else return $query->result();
	}

	public function getiuranevent($codeevent)
	{
		$this->db->from('tb_event');
		$this->db->where('code_event', $codeevent);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret->iuran;
	}

	public function getnamaevent($codeevent)
	{
		$this->db->from('tb_event');
		$this->db->where('code_event', $codeevent);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret->nama_event;
	}

	public function insertkodeorder($kodeacak,$iduser,$npsn,$prodi,$iuran,$tanggalbatas=null,
									$feeagensy=null,$feeam=null,$idagency=null,$idsiam=null)
	{
		$data = array ("iduser"=>$iduser, "npsn_sekolah"=>$npsn, "kd_prodi"=>$prodi, "order_id"=>$kodeacak, "iuran"=>$iuran);
		if ($tanggalbatas!=null)
			$data['tgl_berakhir'] = $tanggalbatas;
		if ($feeagensy>0)
		{
			$data['fee_agency'] = $feeagensy;
			$data['id_agency'] = $idagency;
		}
		if ($feeam>0)
			{
				$data['fee_siam'] = $feeam;
				$data['id_siam'] = $idsiam;
			}

		$this->db->insert('tb_payment', $data);
	}

	public function insertkodeorderekskul($kodeacak,$iduser,$npsn,$prodi,$iuran,$tglakhir,
									$feeagensy=null,$feeam=null,$idagency=null,$idsiam=null,$feever=null,$idver=null)
	{
		$data = array ("iduser"=>$iduser, "npsn_sekolah"=>$npsn, "kd_prodi"=>$prodi, "order_id"=>$kodeacak, "iuran"=>$iuran,
			"tgl_berakhir"=>$tglakhir);
		if ($feeagensy>0)
		{
			$data['fee_agency'] = $feeagensy;
			$data['id_agency'] = $idagency;
		}
		if ($feeam>0)
		{
			$data['fee_siam'] = $feeam;
			$data['id_siam'] = $idsiam;
		}
		if ($feever>0)
		{
			$data['fee_ver'] = $feever;
			$data['id_ver'] = $idver;
		}

		$this->db->insert('tb_payment', $data);
	}

	public function tambahbayar($data,$order_id, $iduser)
	{
		$this->db->where('order_id', $order_id);
		$this->db->where('iduser', $iduser);
		$this->db->update('tb_payment', $data);
	}

	public function updatestatusbayar($iduser, $data, $ver = null)
	{
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		//$datesekarang->add(new DateInterval('P30D'));
		$dateakhir = $datesekarang;
		$dateakhir->add(new DateInterval('P1M'));

		$data['tglaktif'] = $dateakhir->format('Y-m-d');
		$data['modified'] = $datesekarang->format('Y-m-d H:i:s');
		if ($ver != null)
			$data['verifikator'] = $ver;

		$this->db->where('tb_user.id', $iduser);
		return $this->db->update('tb_user', $data);
	}

	public function updatestatusbayarevent($order_id, $data)
	{
		$this->db->where('order_id', $order_id);
		return $this->db->update('tb_userevent', $data);
	}

	public function updatestatuspayment($order_id, $data)
	{
		$this->db->where('order_id', $order_id);
		return $this->db->update('tb_payment', $data);
	}

	public function updatestatuspaymentdesa($order_id, $data)
	{
		$this->db->where('order_id', $order_id);
		return $this->db->update('tb_payment_desa', $data);
	}

	public function updatestatuspaymentvokus($order_id, $data)
	{
		$this->db->where('order_id', $order_id);
		return $this->db->update('tb_payment_vokus', $data);
	}

	public function updatestatusdonasi($iduser, $status)
	{
		$data = array('statusdonasi' => $status);
		$this->db->where('id', $iduser);
		return $this->db->update('tb_user', $data);
	}


	public function cekstatusbayar($iduser)
	{
		$this->db->from('tb_user');
		$this->db->where('id', $iduser);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getlastverifikator($iduser, $status = null, $kode = null)
	{
		$this->db->from('tb_payment');
		$this->db->where('iduser', $iduser);
		if ($status!=null)
			$this->db->where('status', $status);
		if ($kode=="standar")
		{
			$this->db->where('(SUBSTRING(order_id,1,3)="TVS")');
		}
		else if ($kode=="ekskul")
		{
			$this->db->where('(SUBSTRING(order_id,1,3)="EK1" OR SUBSTRING(order_id,1,3)="EK2" OR 
		SUBSTRING(order_id,1,3)="EK3" OR SUBSTRING(order_id,1,3)="EK4")');
		}
		else if ($kode=="pro")
		{
			$this->db->where('(SUBSTRING(order_id,1,2)="TP")');
		}
		else if ($kode=="premium")
		{
			$this->db->where('(SUBSTRING(order_id,1,2)="TF")');
		}
		else if ($kode=="siplah")
		{
			$this->db->where('(tipebayar="SIPLAH")');
		}
		else
		{
			$this->db->where('(SUBSTRING(order_id,1,3)="TVS" OR SUBSTRING(order_id,1,2)="TP" OR 
		SUBSTRING(order_id,1,2)="TF" OR SUBSTRING(order_id,1,3)="EK1" OR SUBSTRING(order_id,1,3)="EK2" OR 
		SUBSTRING(order_id,1,3)="EK3" OR SUBSTRING(order_id,1,3)="EK4")');
		}
		$query = $this->db->get();
		$ret = $query->last_row();
		if ($query)
			return $ret;
		else
			return "error";
	}

	public function clearpaymentexpired()
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');
		$this->db->where('status', 1);
		$this->db->where('DATE_ADD(tgl_order, INTERVAL 1 DAY)<', $tglsekarang);
		$data = array("status" => 0);
		$this->db->update('tb_payment', $data);
	}

	public function clearvkpaymentexpired()
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');
		$this->db->where('status_beli', 1);
		$this->db->where('DATE_ADD(tgl_beli, INTERVAL 1 DAY)<', $tglsekarang);
		$data = array("status_beli" => 0);
		$this->db->update('tb_vk_beli', $data);
	}

	public function getlastbayarekskul($iduser, $status = null)
	{
		$this->db->from('tb_payment');
		$this->db->where('iduser', $iduser);
		if ($status!=null)
			$this->db->where('(status>='.$status.')');
		$this->db->where('(SUBSTRING(order_id,1,3)="EKS" OR SUBSTRING(order_id,1,3)="EKZ" OR '.
		'SUBSTRING(order_id,1,3)="EK1" OR SUBSTRING(order_id,1,3)="EK2" OR SUBSTRING(order_id,1,3)="EK3" OR '.
		'SUBSTRING(order_id,1,3)="EK4")');
//		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
//		$ret = $query->result();
		$ret = $query->last_row();
		if ($query)
			return $ret;
		else
			return "error";
	}

	public function getlastsekolahpayment($npsn, $opsi=null)
	{
		$this->db->from('tb_payment');
		$this->db->where('npsn_sekolah', $npsn);
		if ($opsi!=null)
		$this->db->where('status>=',1);
		$this->db->where('(SUBSTRING(order_id,1,2)<>"EK")');
		$this->db->order_by('tgl_order','asc');
		$query = $this->db->get();
		$ret = $query->last_row();
		if ($query)
			return $ret;
		else
			return "error";
	}

	public function getlastmou($iduser, $status = null)
	{
		$this->db->from('tb_payment');
		$this->db->where('iduser', $iduser);
		if ($status!=null)
			$this->db->where('(status>='.$status.')');
		$this->db->where('(SUBSTRING(order_id,1,2)="MO")');
//		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
//		$ret = $query->result();
		$ret = $query->last_row();
		if ($query)
			return $ret;
		else
			return "error";
	}

	public function cekstatusdonasi($orderid)
	{
		$this->db->from('tb_payment');
		$this->db->where('order_id', $orderid);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function cekorder($orderid)
	{
		$this->db->from('tb_payment');
		$this->db->where('order_id', $orderid);
		$query = $this->db->get();
		$ret = $query->row();
		if ($ret)
			return $ret;
		else
			return "error";
	}

	public function cekorderevent($orderid)
	{
		$this->db->from('tb_userevent');
		$this->db->where('order_id', $orderid);
		$query = $this->db->get();
		$ret = $query->row();
		if ($ret)
			return $ret;
		else
			return "error";
	}

	public function cekorderdesa($orderid)
	{
		$this->db->from('tb_payment_desa');
		$this->db->where('order_id', $orderid);
		$query = $this->db->get();
		$ret = $query->row();
		if ($ret)
			return $ret;
		else
			return "error";
	}

	public function cekordervokus($orderid)
	{
		$this->db->from('tb_payment_vokus');
		$this->db->where('order_id', $orderid);
		$query = $this->db->get();
		$ret = $query->row();
		if ($ret)
			return $ret;
		else
			return "error";
	}

	public function cekvkbeli($orderid)
	{
		$this->db->from('tb_vk_beli');
		$this->db->where('kode_beli', $orderid);
		$query = $this->db->get();
		$ret = $query->row();
		if ($ret)
			return $ret;
		else
			return "error";
	}

	public function cekvkbelivokus($orderid)
	{
		$this->db->from('tb_vk_beli_vokus');
		$this->db->where('kode_beli', $orderid);
		$query = $this->db->get();
		$ret = $query->row();
		if ($ret)
			return $ret;
		else
			return "error";
	}

	public function ambilorder($orderid)
	{
		$this->db->from('tb_payment tp');
		$this->db->join('tb_user tu', 'tp.iduser = tu.id', 'left');
		$this->db->where('order_id', $orderid);
		$query = $this->db->get();
		$ret = $query->result();
		if ($ret)
			return $ret;
		else
			return "error";
	}

	public function getlastdonasi($iduser, $status)
	{
		$this->db->from('tb_payment');
		$this->db->where('iduser', $iduser);
		$this->db->where('status', $status);
		$this->db->where('(SUBSTRING(order_id,1,3)="DNS")');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$ret = $query->row();
		if ($query)
			return $ret;
		else
			return "error";
	}

	public function gettransaksi($opsi)
	{
		if ($opsi == null) {
			$this->db->select('iduser as id_user,order_id,status,tgl_order,iuran,email,first_name,last_name,sekolah,npsn,kd_prodi');
			$this->db->from('tb_payment tp');
			$this->db->where('(iuran<>0)');
			$this->db->where('(tipebayar<>"donasi")');
			$this->db->where('(status=3 OR (status=1 AND tgl_order >= DATE_SUB(NOW(), INTERVAL 1 DAY)))');
			$this->db->join('tb_user ts', 'tp.iduser = ts.id', 'left');
//			$this->db->order_by('tp.id','asc');
			$queryp1 = ($this->db->get_compiled_select());

			$this->db->select('id_user,order_id,status_user as status,tgl_bayar as tgl_order,iuran,email,first_name,last_name,sekolah,ts.npsn,ts.kd_prodi');
			$this->db->from('tb_userevent tu');
			$this->db->join('tb_user ts', 'tu.id_user = ts.id', 'left');
			$this->db->where('(tu.id_user<>1008)');
			$this->db->where('(order_id<>"")');
			$this->db->where('(iuran<>0)');
			$this->db->where('(status_user=2 OR (status_user=1 AND tgl_bayar >= DATE_SUB(NOW(), INTERVAL 1 DAY)))');
//			$this->db->order_by('tu.id','asc');
			$queryp2 = ($this->db->get_compiled_select());
//			$this->db->order_by('tgl_order','asc');
			$query = $this->db->query($queryp1 . ' UNION ' . $queryp2);

			$this->db->select('id_user,kode_beli as order_id,status_beli as status,tgl_beli as tgl_order,rupiah as iuran,email,first_name,last_name,sekolah,ts.npsn, ts.kd_prodi');
			$this->db->from('tb_vk_beli tv');
			$this->db->join('tb_user ts', 'tv.id_user = ts.id', 'left');
			$this->db->where('(rupiah<>0)');
			$this->db->where('(status_beli=2 OR (status_beli=1 AND tgl_beli >= DATE_SUB(NOW(), INTERVAL 1 DAY)))');
//			$this->db->order_by('tu.id','asc');
			$queryp3 = ($this->db->get_compiled_select());
//			$this->db->order_by('tgl_order','asc');
			$query = $this->db->query($queryp1 . ' UNION ' . $queryp2 . ' UNION ' . $queryp3);

			$query = $query->result();
		} else if ($opsi == "iuran") {
			$this->db->select('iduser as id_user,order_id,status,tgl_order,tgl_bayar,iuran,email,first_name,last_name,sekolah,npsn,kd_prodi');
			$this->db->from('tb_payment tp');
			$this->db->where('(iuran<>0)');
			$this->db->where('(substring(order_id,1,3)="TVS")');
			$this->db->where('(tipebayar<>"donasi")');
			$this->db->where('(status=3 OR (status=1 AND tgl_order >= DATE_SUB(NOW(), INTERVAL 1 DAY)))');
			$this->db->join('tb_user ts', 'tp.iduser = ts.id', 'left');
			$this->db->order_by('tgl_bayar','desc');
			$query = $this->db->get()->result();
		} else if ($opsi == "donasi") {
			$this->db->select('iduser as id_user,tp.order_id,status,tgl_order,tgl_bayar,iuran,email,first_name,
			last_name,sekolah,npsn,kd_prodinama_donatur,nama_lembaga');
			$this->db->from('tb_payment tp');
			$this->db->join('tb_eksekusi_ae ta', 'tp.order_id = ta.order_id', 'left');
			$this->db->join('tb_donatur td', 'ta.id_donatur = td.id', 'left');
			$this->db->where('(iuran<>0)');
			$this->db->where('(substring(tp.order_id,1,2)="DN")');
			$this->db->where('(status=3 OR (status=1 AND tgl_order >= DATE_SUB(NOW(), INTERVAL 1 DAY)))');
			$this->db->join('tb_user ts', 'tp.iduser = ts.id', 'left');
			$this->db->order_by('tgl_bayar','desc');
			$query = $this->db->get()->result();
		} else if ($opsi == "event") {
			$this->db->select('id_user,order_id,status_user as status,tgl_bayar,iuran,email,first_name,last_name,sekolah,ts.npsn, ts.kd_prodi');
			$this->db->from('tb_userevent tu');
			$this->db->join('tb_user ts', 'tu.id_user = ts.id', 'left');
			$this->db->where('(tu.id_user<>1008)');
			$this->db->where('(order_id<>"")');
			$this->db->where('(iuran<>0)');
			$this->db->where('(status_user=2 OR (status_user=1 AND tgl_bayar >= DATE_SUB(NOW(), INTERVAL 1 DAY)))');
			$this->db->order_by('tgl_bayar','desc');
			$query = $this->db->get()->result();
		} else if ($opsi == "vkelas") {
			$this->db->select('id_user,kode_beli as order_id,status_beli as status,tgl_beli as tgl_bayar,rupiah as iuran,email,first_name,last_name,sekolah,ts.npsn, ts.kd_prodi');
			$this->db->from('tb_vk_beli tv');
			$this->db->join('tb_user ts', 'tv.id_user = ts.id', 'left');
			$this->db->where('(rupiah<>0)');
			$this->db->where('(SUBSTRING(kode_beli,1,4) = "PKT1" OR SUBSTRING(kode_beli,1,4) = "PKT2")');
			$this->db->where('(status_beli=2 OR (status_beli=1 AND tgl_beli >= DATE_SUB(NOW(), INTERVAL 1 DAY)))');
			$this->db->order_by('tgl_beli','desc');
			$query = $this->db->get()->result();
		} else if ($opsi == "bimbel") {
			$this->db->select('id_user,kode_beli as order_id,status_beli as status,tgl_beli as tgl_bayar,rupiah as iuran,email,first_name,last_name,sekolah,ts.npsn,ts.kd_prodi');
			$this->db->from('tb_vk_beli tv');
			$this->db->join('tb_user ts', 'tv.id_user = ts.id', 'left');
			$this->db->where('(rupiah<>0)');
			$this->db->where('(SUBSTRING(kode_beli,1,4) = "PKT3")');
			$this->db->where('(status_beli=2 OR (status_beli=1 AND tgl_beli >= DATE_SUB(NOW(), INTERVAL 1 DAY)))');
			$this->db->order_by('tgl_beli','desc');
			$query = $this->db->get()->result();
		}

		return $query;
	}

	public function addDonasi($data)
	{
		$this->db->insert('tb_payment', $data);
	}

	public function delete_payment($kode)
	{
		$this->db->where('order_id', $kode);
		$this->db->delete('tb_payment');
	}

	public function addpaymentvokus($data)
	{
		$this->db->insert('tb_payment_vokus', $data);
	}

	public function cekevent($order_id)
	{
		$this->db->from('tb_userevent');
		$this->db->where('order_id', $order_id);
		$query = $this->db->get();
		$ret = $query->row();
		if ($ret)
			return $ret;
		else
			return "error";
	}

	public function update_payment($data, $iduser, $orderid)
	{
		$this->db->where('iduser', $iduser);
		$this->db->where('order_id', $orderid);
		return $this->db->update('tb_payment', $data);
	}

	public function update_vk_beli($data, $kode_beli)
	{
		$this->db->where('kode_beli', $kode_beli);
		return $this->db->update('tb_vk_beli', $data);
	}


	public function clearkeranjang($iduser, $jenispaket)
	{
		$this->db->where('id_user', $iduser);
		$this->db->where('jenis_paket', $jenispaket);
		$this->db->delete('tb_vk_keranjang');
	}

	public function getlastpaymentsekolah($npsn, $prodi)
	{
		$this->db->from('tb_payment');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('kd_prodi', $prodi);
		// $this->db->where('(tipebayar<>"auto")');
		$this->db->order_by('status','asc');
		$query = $this->db->get();
		$ret = $query->last_row();
		return $ret;
	}

	public function getlastpaymentekskul($iduser)
	{
		$this->db->from('tb_payment');
		$this->db->where('iduser', $iduser);
		$this->db->where('(SUBSTRING(order_id, 1, 3)="EKS" OR SUBSTRING(order_id, 1, 3)="EKZ" 
		OR SUBSTRING(order_id, 1, 3)="EKF")');
		$this->db->where('status', 3);
		$query = $this->db->get();
		$ret = $query->last_row();
		return $ret;
	}

	public function getlastpaymentmou($npsn, $prodi)
	{
		$this->db->from('tb_payment');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('kd_prodi', $prodi);
		$this->db->where('(SUBSTRING(order_id,1,3) = "MO1")');
		$this->db->order_by('status','asc');
		$query = $this->db->get();
		$ret = $query->last_row();
		return $ret;
	}

	public function getlastordermou($npsn, $prodi)
	{
		$this->db->from('tb_mou');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('kd_prodi', $prodi);
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		$ret = $query->last_row();
		return $ret;
	}

	public function updatetbmou($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('tb_mou', $data);
	}

	public function getincome($opsi = null)
	{
		$this->db->select('sum(bruto) as totalbruto, sum(net) as totalnet');
		$this->db->from('tb_transfer');
		$this->db->where('untuk', $opsi);
		$this->db->where('(status=2)');
		$query = $this->db->get();
		$ret = $query->last_row();
		return $ret;
	}

	public function ceksiap25modulbeli($npsn, $prodi)
	{
		$timezone = new DateTimeZone('Asia/Jakarta');
		$date = new DateTime();
		$date->setTimeZone($timezone);
		$bulan = $date->format('m');
		$tahun = $date->format('Y');

		$this->db->select('tb.*');
		$this->db->from('tb_vk_beli tb');
		$this->db->join('tb_user tu','tb.id_user = tu.id','left');
		$this->db->where('npsn', $npsn);
		$this->db->where('kd_prodi', $prodi);
		$this->db->where('jenis_paket', 1);
		$this->db->where('strata_paket>=', 2);
		$this->db->where('status_beli', 2);
		$this->db->where('MONTH(tgl_beli)',$bulan);
		$this->db->where('YEAR(tgl_beli)',$tahun);
		$query = $this->db->get();
		$ret = $query->result();
		return $ret;
	}

	public function ceksudah25modul($npsnuser, $prodi, $tglorderbaru)
	{
		$this->db->from('tb_payment');
		$this->db->where('npsn_sekolah', $npsnuser);
		$this->db->where('kd_prodi', $prodi);
		$this->db->where('order_id', "TVS-FREE-OF-MODUL");
		$this->db->where('tgl_order', $tglorderbaru);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function cekpremium($npsn, $prodi)
	{

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');
		$bulanskr = intval($tglsekarang);
		$tahunskr = $now->format('Y');

		$this->db->from('tb_payment');
		$this->db->where('(SUBSTRING(order_id,1,3)="TP0" 
		OR SUBSTRING(order_id,1,3)="TF0" OR SUBSTRING(order_id,1,3)="TP1" 
		OR SUBSTRING(order_id,1,3)="TF1" OR SUBSTRING(order_id,1,3)="TF2" OR SUBSTRING(order_id,1,3)="TP2")');
		$this->db->where('status', 3);
		$this->db->where('npsn_sekolah',$npsn);
		$this->db->where('kd_prodi',$prodi);
		//$this->db->where('(month(`tgl_order`) = '.$bulanskr.' AND year(`tgl_order`) = '.$tahunskr.')');
		$this->db->where('(tgl_bayar<="' . $tglsekarang . '")');
		$this->db->where('(tgl_berakhir>="' . $tglsekarang . '")');
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getFirst_T0($npsn, $prodi, $kodeearly)
	{
		$this->db->from('tb_payment');
		$this->db->where('SUBSTRING(order_id,1,3)="'.$kodeearly.'"');
		$this->db->where('status', 3);
		$this->db->where('npsn_sekolah',$npsn);
		$this->db->where('kd_prodi',$prodi);
		$this->db->where('status', 3);
		$this->db->order_by('tgl_order','asc');
		$query = $this->db->get();
		$ret = $query->result();
		return $ret;
	}

	public function getkeranjang($orderid)
	{
		$this->db->from('tb_payment_desa_keranjang');
		$this->db->where('order_id', $orderid);
		$query = $this->db->get();
		$ret = $query->result();
		return $ret;
	}

	public function updatekeranjang($data)
	{
		return $this->db->insert_batch('tb_payment_desa', $data);
	}

	public function klirkeranjang()
	{
		$this->db->empty_table('tb_payment_desa_keranjang');
	}

	public function cekvkvokusbeli($orderid)
	{
		$this->db->from('tb_vk_beli_vokus');
		$this->db->where('kode_beli', $orderid);
		$query = $this->db->get();
		$ret = $query->row();
		if ($ret)
			return $ret;
		else
			return "error";
	}

	public function update_vk_beli_vokus($data, $kode_beli)
	{
		$this->db->where('kode_beli', $kode_beli);
		return $this->db->update('tb_vk_beli_vokus', $data);
	}

	public function getkeranjangvokus($id_user)
	{
		$this->db->from('tb_vk_keranjang_vokus');
		$this->db->where('id_user', $id_user);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getInfoPaket($linklist)
	{
		$this->db->from('tb_paket_channel_vokus');
		$this->db->where('link_list', $linklist);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getInfoBimbel($linklist)
	{
		$this->db->from('tb_paket_bimbel_vokus');
		$this->db->where('link_list', $linklist);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	public function getveraktif($npsn)
	{
		$this->db->from('tb_user_vokus');
		$this->db->where('npsn', $npsn);
		$this->db->where('sebagai', 1);
		$this->db->where('verifikator', 3);
		$this->db->order_by('lastlogin', 'asc');
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function getStandarVokus2()
	{
		$this->db->from('standar_vokus');
		$result = $this->db->get()->row();
		return $result;
	}

	public function insertvk($id,$data)
	{
		if ($this->db->insert_batch('tb_virtual_kelas_vokus', $data))
		{
			$this->db->where('id_user', $id);
			$this->db->delete('tb_vk_keranjang_vokus');
			return true;
		}
		else
			return false;
	}

	public function gettglakhirbayarlkp($npsn)
	{
		$this->db->from('tb_payment_vokus');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('status', 3);
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function getbayarEkskul($npsn,$prodi, $iduser=null,$status=null,$pakaibatas=null)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));

		$this->db->from('tb_payment tp');
		$this->db->join('tb_user tu', 'tp.iduser = tu.id', 'left');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('tp.kd_prodi', $prodi);
		if ($iduser!=null)
			$this->db->where('iduser', $iduser);
		if ($status==null)
			$this->db->where('(status>0)');
		else
			$this->db->where('status',$status);
		if ($pakaibatas!=null)
			$this->db->where('(now() >= tgl_bayar AND now() <= IF(tgl_berakhir="2001-01-01 00:00:00",LAST_DAY(tgl_bayar),tgl_berakhir))');
		$this->db->where('(SUBSTRING(order_id,1,2)="EK" OR SUBSTRING(order_id,1,3)="TVS") OR
		SUBSTRING(order_id,1,3)="TP2" OR SUBSTRING(order_id,1,3)="TF2"');
		$query = $this->db->get();
		$ret = $query->result();
		if ($query)
			return $ret;
		else
			return "error";
	}

	public function getbayarEkskulSekolah($npsn,$prodi,$status=null,$pakaibatas=null)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));

		$this->db->select('tp.*, max(if(tp.status=3,tgl_bayar,if(tp.status=1 AND tu.sebagai=1,tgl_order,"2001-01-01 00:00:00"))) as tgl_bayar, sum(if(tp.status=3,iuran,0)) as totaliuran, tu.sebagai, sum(if(tp.status=3,1,0)) as totaluser');
		$this->db->from('tb_payment tp');
		$this->db->join('tb_user tu', 'tp.iduser = tu.id', 'left');
		$this->db->where('npsn_sekolah', $npsn);
		if ($status==null)
		$this->db->where('kd_prodi', $prodi);
		if ($status==null)
			$this->db->where('(status>0)');
		else
			$this->db->where('status',$status);
		if ($pakaibatas!=null)
			$this->db->where('(now() >= tgl_bayar AND now() <= IF(tgl_berakhir="2001-01-01 00:00:00",LAST_DAY(tgl_bayar),tgl_berakhir))');
		$this->db->where('(SUBSTRING(order_id,1,2)="EK")');
		$this->db->group_by('(SUBSTRING(tp.tgl_bayar,6,2))');
		$query = $this->db->get();
		$ret = $query->result();
		if ($query)
			return $ret;
		else
			return "error";
	}

	public function addsiplah($namafile)
	{
		$iduser = $this->session->userdata("id_user");
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');
		$set = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 5);

		$data = array(
			"id_user" => $iduser,
			"npsn" => $this->session->userdata("npsn"),
			"filebukti" => $namafile,
			"tgl_upload" => $tglsekarang,
			"tgl_aktifkan" => $tglsekarang,
			"konfirmasi" => 1
		);

		$this->db->from('tb_siplah');
		$this->db->where('filebukti',$namafile);
		$result = $this->db->get()->result();
		if ($result)
		{
			$this->db->where('id_user', $iduser);
			$this->db->update('tb_siplah', $data);
		}
		else
			{
				$data["kode"] = "SL_".$iduser."_".$code;
				$this->db->insert('tb_siplah', $data);
			}
	}

	public function getSiplah($iduser)
	{
		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$tahunnya = $tglsekarang->format("y");
		$bulannya = $tglsekarang->format("m");
		$bulantahun = $tahunnya.$bulannya;

		$filebukti1 = "sl".$iduser."_".$bulantahun.".jpg";
		$filebukti2 = "sl".$iduser."_".$bulantahun.".jpeg";
		$filebukti3 = "sl".$iduser."_".$bulantahun.".png";

		$this->db->from('tb_siplah');
		$this->db->where('id_user=',$iduser);
		$this->db->where('(konfirmasi>=1 AND konfirmasi<=5)');
		$this->db->where('(LOWER(filebukti)="'.$filebukti1.'" OR LOWER(filebukti)="'.$filebukti2.
			'" OR LOWER(filebukti)="'.$filebukti3.'")');

		$result = $this->db->get()->result();
		return $result;
	}

	public function update_siplah($kodesiplah, $data)
	{
		$this->db->where('kode', $kodesiplah);
		$this->db->update('tb_siplah', $data);
	}

	public function updateKonfirmSiplah()
	{
		$this->db->from('tb_siplah tp');
		$this->db->where("(tp.konfirmasi=1 OR tp.konfirmasi=4)");
		$totalverify = $this->db->get()->num_rows();

		$data = array('n_verify_siplah'=>$totalverify);
		$this->db->update('tb_dash_admin', $data);

	}

	public function updatepaymentmidtrans($orderid, $ppnrp, $rpmidtrans)
	{
		$data = array ('potmidrp'=>$rpmidtrans, 'ppnrp'=>$ppnrp);
		$this->db->where('order_id', $orderid);
		$this->db->update('tb_payment', $data);
	}

	public function updatevkmidtrans($kodebeli, $ppnrp, $rpmidtrans)
	{
		$data = array ('potmidrp'=>$rpmidtrans, 'ppnrp'=>$ppnrp);
		$this->db->where('kode_beli', $kodebeli);
		$this->db->update('tb_vk_beli', $data);
	}

	public function getmodulbulanini()
	{

	}

	public function cekpaymentaktif()
	{
		$this->db->from('tb_payment');
		$this->db->where('status', 3);
		$this->db->where('npsn_sekolah<>', '1234567890');
		$this->db->where('npsn_sekolah<>', '1234567891');
		$result = $this->db->get()->result();
		return $result;
	} 

	public function cekvkbeliaktif()
	{
		$this->db->from('tb_vk_beli tb');
		$this->db->where('rupiah>', 0);
		$this->db->where('status_beli', 2);
		$this->db->where('npsn_user<>', '1234567890');
		$this->db->where('npsn_user<>', '1234567891');
		$result = $this->db->get()->result();
		return $result;
	}

}
