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

	public function tambahbayar($data)
	{
		$this->db->insert('tb_payment', $data);
	}

	public function updatestatusbayar($iduser, $data, $ver = null)
	{
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		//$datesekarang->add(new DateInterval('P30D'));
		$dateakhir = $datesekarang;
		$dateakhir->add(new DateInterval('P1Y'));

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

	public function getlastverifikator($iduser, $status = null)
	{
		$this->db->from('tb_payment');
		$this->db->where('iduser', $iduser);
		if ($status!=null)
			$this->db->where('(status>='.$status.')');
		$this->db->where('(SUBSTRING(order_id,1,3)="TVS")');
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
			$this->db->select('iduser as id_user,order_id,status,tgl_order,iuran,email,first_name,last_name,sekolah,npsn');
			$this->db->from('tb_payment tp');
			$this->db->join('tb_user ts', 'tp.iduser = ts.id', 'left');
			$query1 = $this->db->get_compiled_select();

			$this->db->select('id_user,order_id,status_user as status,tgl_bayar as tgl_order,iuran,email,first_name,last_name,sekolah,ts.npsn');
			$this->db->from('tb_userevent tu');
			$this->db->join('tb_user ts', 'tu.id_user = ts.id', 'left');
			$this->db->where('(tu.id_user<>1008)');
			$this->db->where('(order_id<>"")');
			$query2 = $this->db->get_compiled_select();
			$query = $this->db->query($query1 . ' UNION ' . $query2);
			$query = $query->result();
		} else if ($opsi == "reg") {
			$this->db->select('tp.*');
			$this->db->from('tb_payment tp');
		} else if ($opsi == "event") {
			$this->db->select('tu.*');
			$this->db->from('tb_userevent tu');
		}

		return $query;
	}

	public function addDonasi($data)
	{
		$this->db->insert('tb_payment', $data);
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


}
