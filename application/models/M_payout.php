<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_payout extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function UpdateAllStatusTransaksi($data)
	{
		$this->db->update_batch('tb_virtual_kelas', $data, 'kode_beli');
	}

	public function UpdateAllStatusTransaksiPayment($data)
	{
		$this->db->update_batch('tb_payment', $data, 'order_id');
	}

	public function UpdateAllStatusTransaksiAe($data)
	{
		$this->db->update_batch('tb_eksekusi_ae', $data, 'order_id');
	}

}
